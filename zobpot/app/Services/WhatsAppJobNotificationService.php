<?php

namespace App\Services;

use App\Helpers\WhatsappHelper;
use App\Models\Job;
use App\Models\User;
use App\Models\WhatsappNotification;
use Illuminate\Support\Facades\Log;

class WhatsAppJobNotificationService
{
    public const TEMPLATE_NAME = 'account_info';
    public const NOTIFICATION_TYPE = WhatsappNotification::TYPE_NEW_JOB_ALERT;

    /**
     * Send WhatsApp "account_info" new-job alerts to candidates matching
     * the job's category + subcategory.
     *
     * Payload template:
     * {
     *   "messaging_product": "whatsapp",
     *   "recipient_type": "individual",
     *   "to": "{{to}}",
     *   "type": "template",
     *   "template": {
     *     "name": "account_info",
     *     "language": { "code": "en" },
     *     "components": [{
     *       "type": "body",
     *       "parameters": [
     *         { "type": "text", "text": "{{1}}" }, // job_title
     *         { "type": "text", "text": "{{2}}" }, // company_name
     *         { "type": "text", "text": "{{3}}" }, // category_name
     *         { "type": "text", "text": "{{4}}" }, // subcategory_name
     *         { "type": "text", "text": "{{5}}" }  // location
     *       ]
     *     }]
     *   }
     * }
     *
     * @return array{matched:int,sent:int,failed:int,skipped:int}
     */
    public function sendNewJobAlert(Job $job): array
    {
        $stats = ['matched' => 0, 'sent' => 0, 'failed' => 0, 'skipped' => 0];

        try {
            $job->loadMissing([
                'company:id,name,contact_no',
                'category:category_id,category_nm',
                'subCategory:sub_category_id,sub_category_nm',
                'city:city_id,city_nm',
                'state:state_id,state_name',
                'area:area_id,area_nm',
            ]);

            if (!$job->category_id) {
                Log::channel('whatsapp')->warning('[WHATSAPP][SKIP] Job has no category_id', [
                    'job_id' => $job->job_id,
                ]);
                return $stats;
            }

            $candidates = $this->findMatchingCandidates($job);
            $stats['matched'] = $candidates->count();

            if ($stats['matched'] === 0) {
                Log::channel('whatsapp')->info('[WHATSAPP] No matching candidates for job alert', [
                    'job_id' => $job->job_id,
                    'category_id' => $job->category_id,
                    'sub_category_id' => $job->sub_category_id,
                ]);
                return $stats;
            }

            $jobTitle = (string) ($job->job_title ?? '');
            $companyName = (string) ($job->company->name ?? 'Company');
            $categoryName = (string) ($job->category->category_nm ?? '');
            $subcategoryName = (string) ($job->subCategory->sub_category_nm ?? 'N/A');
            $location = $this->buildLocation($job);

            foreach ($candidates as $candidate) {
                $result = $this->sendToCandidate(
                    $job,
                    $candidate,
                    [
                        $jobTitle,
                        $companyName,
                        $categoryName,
                        $subcategoryName,
                        $location,
                    ]
                );

                $stats[$result]++;
            }
        } catch (\Throwable $e) {
            // Never bubble up — job creation must remain successful.
            Log::channel('whatsapp')->error('[WHATSAPP] sendNewJobAlert exception', [
                'job_id' => $job->job_id ?? null,
                'exception' => $e->getMessage(),
            ]);
            Log::error('[WHATSAPP] sendNewJobAlert exception', [
                'job_id' => $job->job_id ?? null,
                'exception' => $e->getMessage(),
            ]);
        }

        Log::channel('whatsapp')->info('[WHATSAPP] New job alert batch finished', [
            'job_id' => $job->job_id,
            'stats' => $stats,
        ]);

        return $stats;
    }

    /**
     * Candidates with matching category (+ subcategory when set on the job).
     */
    protected function findMatchingCandidates(Job $job)
    {
        $query = User::query()
            ->select(['id', 'name', 'contact_no', 'category_id', 'sub_category_id', 'profile_type'])
            ->where('profile_type', 'Employee')
            ->where('role', 'User')
            ->where('category_id', $job->category_id)
            ->whereNotNull('contact_no')
            ->where('contact_no', '!=', '');

        if (!empty($job->sub_category_id)) {
            $query->where('sub_category_id', $job->sub_category_id);
        }

        return $query->get();
    }

    /**
     * @param  array{0:string,1:string,2:string,3:string,4:string}  $parameters
     * @return 'sent'|'failed'|'skipped'
     */
    protected function sendToCandidate(Job $job, User $candidate, array $parameters): string
    {
        $phone = WhatsappHelper::normalizePhonePublic($candidate->contact_no);

        if (!$phone) {
            $this->recordNotification(
                $job->job_id,
                $candidate->id,
                null,
                WhatsappNotification::STATUS_SKIPPED,
                ['reason' => 'invalid_or_empty_phone']
            );

            Log::channel('whatsapp')->warning('[WHATSAPP][SKIP] Invalid candidate phone', [
                'job_id' => $job->job_id,
                'candidate_id' => $candidate->id,
                'phone_masked' => $this->maskPhone((string) $candidate->contact_no),
            ]);

            return 'skipped';
        }

        // Duplicate protection: never re-send successful / skipped alerts.
        // Failed rows may be retried by the queue worker.
        $log = WhatsappNotification::where('job_id', $job->job_id)
            ->where('candidate_id', $candidate->id)
            ->where('notification_type', self::NOTIFICATION_TYPE)
            ->first();

        if ($log && in_array($log->status, [
            WhatsappNotification::STATUS_SENT,
            WhatsappNotification::STATUS_SKIPPED,
        ], true)) {
            Log::channel('whatsapp')->info('[WHATSAPP][SKIP] Duplicate job alert prevented', [
                'job_id' => $job->job_id,
                'candidate_id' => $candidate->id,
                'status' => $log->status,
            ]);
            return 'skipped';
        }

        if ($log) {
            $log->update([
                'phone_number' => $phone,
                'template_name' => self::TEMPLATE_NAME,
                'status' => WhatsappNotification::STATUS_PENDING,
                'api_response' => null,
                'sent_at' => null,
            ]);
        } else {
            try {
                $log = WhatsappNotification::create([
                    'job_id' => $job->job_id,
                    'candidate_id' => $candidate->id,
                    'phone_number' => $phone,
                    'template_name' => self::TEMPLATE_NAME,
                    'notification_type' => self::NOTIFICATION_TYPE,
                    'status' => WhatsappNotification::STATUS_PENDING,
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                Log::channel('whatsapp')->info('[WHATSAPP][SKIP] Duplicate job alert race prevented', [
                    'job_id' => $job->job_id,
                    'candidate_id' => $candidate->id,
                ]);
                return 'skipped';
            }
        }

        try {
            $response = WhatsappHelper::sendTemplate(
                $phone,
                self::TEMPLATE_NAME,
                $parameters,
                'en'
            );

            $ok = $this->isApiSuccess($response);

            $log->update([
                'status' => $ok
                    ? WhatsappNotification::STATUS_SENT
                    : WhatsappNotification::STATUS_FAILED,
                'api_response' => $this->safeJson($response),
                'sent_at' => $ok ? now() : null,
            ]);

            if (!$ok) {
                Log::channel('whatsapp')->error('[WHATSAPP] New job alert failed for candidate', [
                    'job_id' => $job->job_id,
                    'candidate_id' => $candidate->id,
                    'phone_masked' => $this->maskPhone($phone),
                    'response' => $response,
                ]);
                return 'failed';
            }

            return 'sent';
        } catch (\Throwable $e) {
            $log->update([
                'status' => WhatsappNotification::STATUS_FAILED,
                'api_response' => $this->safeJson(['exception' => $e->getMessage()]),
            ]);

            Log::channel('whatsapp')->error('[WHATSAPP] New job alert exception for candidate', [
                'job_id' => $job->job_id,
                'candidate_id' => $candidate->id,
                'phone_masked' => $this->maskPhone($phone),
                'exception' => $e->getMessage(),
            ]);

            return 'failed';
        }
    }

    protected function buildLocation(Job $job): string
    {
        $parts = array_filter([
            optional($job->area)->area_nm,
            optional($job->city)->city_nm,
            optional($job->state)->state_name,
        ], function ($v) {
            return $v !== null && trim((string) $v) !== '';
        });

        if (!empty($parts)) {
            return implode(', ', $parts);
        }

        if (!empty($job->company_address)) {
            return (string) $job->company_address;
        }

        return 'Not specified';
    }

    protected function isApiSuccess(?array $response): bool
    {
        if ($response === null) {
            return false;
        }

        if (!empty($response['messages'][0]['id'])) {
            return true;
        }

        if (($response['isValid'] ?? null) === true) {
            return true;
        }

        if (($response['isValid'] ?? null) === false) {
            return false;
        }

        if (isset($response['error'])) {
            return false;
        }

        return false;
    }

    protected function recordNotification(
        int $jobId,
        int $candidateId,
        ?string $phone,
        string $status,
        array $apiResponse = []
    ): void {
        try {
            WhatsappNotification::firstOrCreate(
                [
                    'job_id' => $jobId,
                    'candidate_id' => $candidateId,
                    'notification_type' => self::NOTIFICATION_TYPE,
                ],
                [
                    'phone_number' => $phone,
                    'template_name' => self::TEMPLATE_NAME,
                    'status' => $status,
                    'api_response' => $this->safeJson($apiResponse),
                ]
            );
        } catch (\Throwable $e) {
            // Ignore duplicate / log failures
        }
    }

    protected function maskPhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';
        $len = strlen($digits);
        if ($len <= 4) {
            return str_repeat('*', $len);
        }

        return substr($digits, 0, 2) . str_repeat('*', max(0, $len - 4)) . substr($digits, -2);
    }

    protected function safeJson($data): ?string
    {
        if ($data === null) {
            return null;
        }

        try {
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
