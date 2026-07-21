<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;


class SmsHelper
{
    public static function sendOtp($number, $otp, $name = "User")
    {
        // https://bulksms.ivinfotech.in/api/smsapi?key=b3951f18b943b8aa873e271fc1f1e02a&route=4&sender=ZOBPOT&number=8490974440&sms=%20Your%20www.zobpot.com%20registration%20verification%20code%20is%20457862.%20Team%20PRAMUKH%20MANAGEMENT%20PRIVATE%20LIMITED&templateid=1207175982471361537
        // $apiKey     = "b3951f18b943b8aa873e271fc1f1e02a";
        
        // $route      = "4";
        // $sender     = "ZOBPOT";
        // $templateId = "1207175611041347237";

        // $message = "Welcome to Zobpot. Hey, $name Your OTP is $otp Team - Zobpot";

        $apiKey     = "b3951f18b943b8aa873e271fc1f1e02a";
        $route      = "4";
        $sender     = "ZOBPOT";
        $templateId = "1207175982471361537";

        $message = "Your www.zobpot.com registration verification code is ".$otp." Team PRAMUKH MANAGEMENT PRIVATE LIMITED";

// $message = "Your www.zobpot.com registration verification code is ".$otp."Team Zobpot";

// $message = "Your www.zobpot.com registration verification code is " . $otp . " Team Zobpot";


        $response = Http::withOptions([
            'verify' => false, // disable SSL verification
        ])->get("https://bulksms.ivinfotech.in/api/smsapi", [
            'key'        => $apiKey,
            'route'      => $route,
            'sender'     => $sender,
            'number'     => $number,
            'sms'        => $message,
            'templateid' => $templateId,
        ]);
        file_put_contents(
            storage_path('logs/custom-log.log'),
            print_r($response->json(),true) . "Your log text here" . PHP_EOL,
            FILE_APPEND
        );
        return $response->json(); // or ->body() depending on API response
    }

    public static function PaymentGateway()
    {
//         Key iD : rzp_test_RHlEZntD6oCrP6
//        Secerate : AvgiXCAHmpQ7eRyK3PmCxYjQ
    }
}
