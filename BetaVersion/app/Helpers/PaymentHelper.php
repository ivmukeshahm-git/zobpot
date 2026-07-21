<?php

namespace App\Helpers;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Http;


class PaymentHelper
{

//    public static function PaymentGateway()
//    {
////         Key iD : rzp_test_RHlEZntD6oCrP6
////        Secerate : AvgiXCAHmpQ7eRyK3PmCxYjQ
//
//
//    }

    /**
     * Create Razorpay Order
     */
    public static function createOrder($amount, $receipt = null, $currency = 'INR')
    {
        try {
            // $api = new Api('rzp_test_RHlEZntD6oCrP6','AvgiXCAHmpQ7eRyK3PmCxYjQ');
            $api = new Api('rzp_live_RyDOBxkxJtrIzG','MIXMh3JqG5wBM2QGlY6SC86p');

            $orderData = [
                'receipt'   => $receipt ?? uniqid(),
                'amount'    => $amount * 100, // convert to paise
                'currency'  => $currency
            ];

            return $api->order->create($orderData);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Verify Razorpay Payment Signature
     */
    public static function verifyPayment($attributes)
    {
        try {
            // $api = new Api('rzp_test_RHlEZntD6oCrP6','AvgiXCAHmpQ7eRyK3PmCxYjQ');
             $api = new Api('rzp_live_RyDOBxkxJtrIzG','MIXMh3JqG5wBM2QGlY6SC86p');
            $api->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
