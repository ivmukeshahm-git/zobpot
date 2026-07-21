<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipPayment extends Model
{
    use HasFactory;

    protected $table = 'tbl_internship_payment';

    protected $fillable = [
        'application_id',
        'user_id',
        'internship_id',
        'gst_percentage',
        'gst_amount',
        'total_amount',
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
        'gst_percentage' => 'float',
        'gst_amount' => 'float',
        'total_amount' => 'float',
    ];
}
