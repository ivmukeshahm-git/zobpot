<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class InternshipPayment extends Model
{
    use HasFactory;

    protected $table = 'tbl_internship_payment';

    protected $fillable = [
        'application_id',
        'user_id',
        'internship_id',
        'registration_fee',
        'late_registration_fee',
        'subtotal',
        'gst_percentage',
        'gst_amount',
        'platform_service_charge',
        'total_amount',
        'is_late_registration',
        'payment_mode',
        'transaction_id',
        'payment_status',
        'paid_on',
        'payment_response_data',
        'payment_transaction_id',
    ];

    protected $casts = [
        'payment_response_data' => 'array',
        'paid_on' => 'datetime',
        'registration_fee' => 'float',
        'late_registration_fee' => 'float',
        'subtotal' => 'float',
        'gst_percentage' => 'float',
        'gst_amount' => 'float',
        'platform_service_charge' => 'float',
        'total_amount' => 'float',
        'is_late_registration' => 'boolean',
    ];

    /**
     * Create a payment row using only columns that exist in the current DB.
     * Avoids live failures when late-fee migrations have not been run yet.
     */
    public static function createFromCalculation(array $base, array $paymentCalc, string $transactionId): self
    {
        $payload = array_merge($base, [
            'registration_fee' => $paymentCalc['registration_fee'] ?? 0,
            'late_registration_fee' => $paymentCalc['late_registration_fee'] ?? 0,
            'subtotal' => $paymentCalc['subtotal'] ?? ($paymentCalc['registration_fee'] ?? 0),
            'gst_percentage' => $paymentCalc['gst_percentage'] ?? 0,
            'gst_amount' => $paymentCalc['gst_amount'] ?? 0,
            'platform_service_charge' => $paymentCalc['platform_service_charge'] ?? ($paymentCalc['total_amount'] ?? 0),
            'total_amount' => $paymentCalc['total_amount'] ?? 0,
            'is_late_registration' => !empty($paymentCalc['is_late_registration']) ? 1 : 0,
            'payment_mode' => $base['payment_mode'] ?? 'online',
            'transaction_id' => $transactionId,
            'payment_status' => $base['payment_status'] ?? 1,
            'paid_on' => $base['paid_on'] ?? now(),
        ]);

        // Omit null JSON / optional columns — some live MySQL/MariaDB CHECK(json_valid(...)) rejects bad empties
        unset($payload['payment_response_data'], $payload['payment_transaction_id']);

        $columns = Schema::getColumnListing((new static)->getTable());
        $payload = array_intersect_key($payload, array_flip($columns));

        return static::create($payload);
    }
}
