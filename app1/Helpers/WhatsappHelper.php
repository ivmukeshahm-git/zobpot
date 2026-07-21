<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;


class WhatsappHelper
{

    // public static function sendTemplate($to, $templateName, array $parameters = [])
    // {
    //     $url = "https://cloudapi.wafortius.com/api/v1.0/messages/send-template/916357024800";

    //     // Build parameters dynamically
    //     $params = [];
    //     foreach ($parameters as $param) {
    //         $params[] = [
    //             "type" => "text",
    //             "text" => $param
    //         ];
    //     }

    //     $response = Http::withToken('pmYv8kXAPkCz6nRu2fQEjQ')
    //         ->withHeaders([
    //             'Content-Type' => 'application/json',
    //         ])
    //         ->post($url, [
    //             "messaging_product" => "whatsapp",
    //             "recipient_type"    => "individual",
    //             "to"                => $to,
    //             "type"              => "template",
    //             "template" => [
    //                 "name"     => $templateName,
    //                 "language" => [
    //                     "code" => "en"
    //                 ],
    //                 "components" => [
    //                     [
    //                         "type"       => "body",
    //                         "parameters" => $params
    //                     ]
    //                 ]
    //             ]
    //         ]);

    //     return $response->json();
    // }
}
