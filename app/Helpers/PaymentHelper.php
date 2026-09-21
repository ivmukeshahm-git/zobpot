<?php

namespace App\Helpers;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Http;


class PaymentHelper
{
    private const TEST_KEY_ID = 'rzp_test_RHlEZntD6oCrP6';
    private const TEST_KEY_SECRET = 'AvgiXCAHmpQ7eRyK3PmCxYjQ';

    private const LIVE_KEY_ID = 'rzp_live_RyDOBxkxJtrIzG';
    private const LIVE_KEY_SECRET = 'MIXMh3JqG5wBM2QGlY6SC86p';

    private static function keys($mode = 'live')
    {
        if ($mode === 'test') {
            return [self::TEST_KEY_ID, self::TEST_KEY_SECRET];
        }

        return [self::LIVE_KEY_ID, self::LIVE_KEY_SECRET];
    }

    private static function api($mode = 'live')
    {
        [$keyId, $keySecret] = self::keys($mode);
        return new Api($keyId, $keySecret);
    }

    public static function getKeyId($mode = 'live')
    {
        [$keyId] = self::keys($mode);
        return $keyId;
    }

    /**
     * Create Razorpay Order
     * $mode = live | test
     */
    public static function createOrder($amount, $receipt = null, $currency = 'INR', $mode = 'live')
    {
        try {
            $orderData = [
                'receipt'   => $receipt ?? uniqid(),
                'amount' => (int) round($amount * 100),
                'currency'  => $currency
            ];

            return self::api($mode)->order->create($orderData);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Verify Razorpay Payment Signature
     */
    public static function verifyPayment($attributes, $mode = 'live')
    {
        try {
            self::api($mode)->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function fetchPayment($paymentId, $mode = 'live')
    {
        try {
            return self::api($mode)->payment->fetch($paymentId);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
