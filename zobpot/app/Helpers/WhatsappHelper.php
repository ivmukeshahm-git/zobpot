<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappHelper
{
    /**
     * Build Cloud API messages endpoint:
     * https://{domain}/{version}/{phone_number_id}/messages
     */
    protected static function messagesUrl(): string
    {
        $base = rtrim((string) config('services.whatsapp.base_url'), '/');
        $version = trim((string) config('services.whatsapp.version'), '/');
        $phoneNumberId = (string) config('services.whatsapp.phone_number_id');

        return "{$base}/{$version}/{$phoneNumberId}/messages";
    }

    /**
     * Resolve a usable SSL CA bundle path.
     * Laragon sometimes points curl.cainfo to a missing drive (e.g. D:\...).
     *
     * @return string|true
     */
    protected static function sslVerifyOption()
    {
        $candidates = array_filter([
            ini_get('curl.cainfo') ?: null,
            ini_get('openssl.cafile') ?: null,
            'C:\\laragon\\etc\\ssl\\cacert.pem',
            'D:\\laragon\\etc\\ssl\\cacert.pem',
            storage_path('certs/cacert.pem'),
        ]);

        foreach ($candidates as $path) {
            if (is_string($path) && $path !== '' && is_file($path)) {
                return $path;
            }
        }

        return true;
    }

    /**
     * Shared HTTP client for WhatsApp API calls.
     */
    protected static function http()
    {
        return Http::withToken((string) config('services.whatsapp.api_key'))
            ->acceptJson()
            ->asJson()
            ->timeout(30)
            ->withOptions([
                'verify' => self::sslVerifyOption(),
            ]);
    }

    /**
     * Dedicated WhatsApp channel + laravel.log.
     */
    protected static function writeReport(string $status, string $message, array $context = []): void
    {
        $status = strtoupper($status);
        $line = "[WHATSAPP][{$status}] {$message}";
        $payload = array_merge(['status' => $status], $context);

        try {
            if ($status === 'SUCCESS') {
                Log::channel('whatsapp')->info($line, $payload);
                Log::info($line, $payload);
                return;
            }

            Log::channel('whatsapp')->error($line, $payload);
            Log::error($line, $payload);
        } catch (\Throwable $e) {
            // Never break business flow because logging failed
            @file_put_contents(
                storage_path('logs/whatsapp-fallback.log'),
                date('c') . ' ' . $line . ' ' . json_encode($payload) . PHP_EOL,
                FILE_APPEND
            );
        }
    }

    /**
     * Public wrapper for phone normalization (used by notification services).
     */
    public static function normalizePhonePublic(?string $to): ?string
    {
        return self::normalizePhone($to);
    }

    /**
     * Normalize recipient to digits-only international format (default India 91).
     * Does not blindly prepend 91 if a country code is already present.
     */
    protected static function normalizePhone(?string $to): ?string
    {
        if ($to === null || $to === '') {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $to);
        if ($digits === null || $digits === '') {
            return null;
        }

        // Strip a single leading trunk 0 (e.g. 09876...), not country-code digits
        if (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            $digits = substr($digits, 1);
        }

        // Already has India country code
        if (str_starts_with($digits, '91') && strlen($digits) === 12) {
            return $digits;
        }

        // Plain 10-digit Indian mobile
        if (strlen($digits) === 10 && preg_match('/^[6-9]/', $digits)) {
            return '91' . $digits;
        }

        // Other international numbers already including country code (11–15 digits)
        if (strlen($digits) >= 11 && strlen($digits) <= 15) {
            return $digits;
        }

        // Unusable length
        return null;
    }

    /**
     * Fortius returns { isValid, response:[{status,message,statusCode}] }
     * Meta Cloud returns { messages:[{id}] }
     */
    protected static function parseApiResult($response, $json): array
    {
        $httpStatus = $response->status();
        $messageId = data_get($json, 'messages.0.id');

        $apiError = data_get($json, 'error.message')
            ?? data_get($json, 'error.error_user_msg')
            ?? data_get($json, 'response.0.message')
            ?? data_get($json, 'response.0.status')
            ?? data_get($json, 'message');

        $isValid = data_get($json, 'isValid');

        $ok = false;
        if ($response->successful()) {
            if ($messageId) {
                $ok = true;
            } elseif ($isValid === true) {
                $ok = true;
            } elseif ($isValid === false) {
                $ok = false;
            } elseif (is_array($json) && empty($apiError)) {
                // HTTP 2xx with no explicit Fortius/Meta error
                $ok = true;
            }
        }

        return [
            'ok' => $ok,
            'http_status' => $httpStatus,
            'message_id' => $messageId,
            'api_error' => $apiError,
            'is_valid' => $isValid,
        ];
    }

    /**
     * Send an approved WhatsApp template message.
     *
     * Controllers call:
     * WhatsappHelper::sendTemplate($phone, 'template_name', ['param1', 'param2']);
     *
     * @param  string|null  $to
     * @param  string  $templateName
     * @param  array<int, string|int|float>  $parameters
     * @param  string  $languageCode
     * @return array|null
     */
    public static function sendTemplate(
        $to,
        string $templateName,
        array $parameters = [],
        string $languageCode = 'en'
    ): ?array {
        $phone = self::normalizePhone($to !== null ? (string) $to : null);
        if (!$phone) {
            self::writeReport('FAILED', 'Invalid / empty recipient phone', [
                'type' => 'template',
                'to_raw' => $to,
                'template' => $templateName,
                'reason' => 'invalid_phone',
            ]);
            return null;
        }

        $apiKey = (string) config('services.whatsapp.api_key');
        $url = self::messagesUrl();

        if ($apiKey === '' || !config('services.whatsapp.phone_number_id')) {
            self::writeReport('FAILED', 'Missing WhatsApp API config', [
                'type' => 'template',
                'to' => $phone,
                'template' => $templateName,
                'url' => $url,
                'reason' => 'missing_config',
            ]);
            return null;
        }

        $bodyParams = [];
        foreach ($parameters as $param) {
            $bodyParams[] = [
                'type' => 'text',
                'text' => (string) $param,
            ];
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $phone,
            'type' => 'template',
            'template' => [
                'name' => $templateName,
                'language' => [
                    'code' => $languageCode,
                ],
            ],
        ];

        if (!empty($bodyParams)) {
            $payload['template']['components'] = [
                [
                    'type' => 'body',
                    'parameters' => $bodyParams,
                ],
            ];
        }

        try {
            $response = self::http()->post($url, $payload);

            $json = $response->json();
            $parsed = self::parseApiResult($response, $json);

            if ($parsed['ok']) {
                self::writeReport('SUCCESS', "Template '{$templateName}' sent", [
                    'type' => 'template',
                    'to' => $phone,
                    'template' => $templateName,
                    'language' => $languageCode,
                    'parameters' => $parameters,
                    'http_status' => $parsed['http_status'],
                    'message_id' => $parsed['message_id'],
                    'url' => $url,
                    'response' => $json,
                ]);

                return is_array($json) ? $json : ['raw' => $response->body()];
            }

            self::writeReport('FAILED', "Template '{$templateName}' not delivered", [
                'type' => 'template',
                'to' => $phone,
                'template' => $templateName,
                'language' => $languageCode,
                'parameters' => $parameters,
                'http_status' => $parsed['http_status'],
                'api_error' => $parsed['api_error'],
                'url' => $url,
                'request' => $payload,
                'response' => $json ?? $response->body(),
            ]);

            return is_array($json) ? $json : ['raw' => $response->body()];
        } catch (\Throwable $e) {
            self::writeReport('FAILED', "Template '{$templateName}' exception", [
                'type' => 'template',
                'to' => $phone,
                'template' => $templateName,
                'parameters' => $parameters,
                'url' => $url,
                'exception' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Send a plain text WhatsApp message (within 24h session window).
     */
    public static function sendText($to, string $message): ?array
    {
        $phone = self::normalizePhone($to !== null ? (string) $to : null);
        if (!$phone || $message === '') {
            self::writeReport('FAILED', 'Invalid phone or empty text message', [
                'type' => 'text',
                'to_raw' => $to,
                'reason' => 'invalid_phone_or_message',
            ]);
            return null;
        }

        $apiKey = (string) config('services.whatsapp.api_key');
        $url = self::messagesUrl();

        if ($apiKey === '' || !config('services.whatsapp.phone_number_id')) {
            self::writeReport('FAILED', 'Missing WhatsApp API config', [
                'type' => 'text',
                'to' => $phone,
                'url' => $url,
                'reason' => 'missing_config',
            ]);
            return null;
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $phone,
            'type' => 'text',
            'text' => [
                'preview_url' => false,
                'body' => $message,
            ],
        ];

        try {
            $response = self::http()->post($url, $payload);

            $json = $response->json();
            $parsed = self::parseApiResult($response, $json);

            if ($parsed['ok']) {
                self::writeReport('SUCCESS', 'Text message sent', [
                    'type' => 'text',
                    'to' => $phone,
                    'http_status' => $parsed['http_status'],
                    'message_id' => $parsed['message_id'],
                    'url' => $url,
                    'response' => $json,
                ]);

                return is_array($json) ? $json : ['raw' => $response->body()];
            }

            self::writeReport('FAILED', 'Text message not delivered', [
                'type' => 'text',
                'to' => $phone,
                'http_status' => $parsed['http_status'],
                'api_error' => $parsed['api_error'],
                'url' => $url,
                'request' => $payload,
                'response' => $json ?? $response->body(),
            ]);

            return is_array($json) ? $json : ['raw' => $response->body()];
        } catch (\Throwable $e) {
            self::writeReport('FAILED', 'Text message exception', [
                'type' => 'text',
                'to' => $phone,
                'url' => $url,
                'exception' => $e->getMessage(),
            ]);

            return null;
        }
    }
}
