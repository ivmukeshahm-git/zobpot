<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanHistory extends Model
{
    use HasFactory;

    protected $table = 'tbl_plan_history';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'plan_id',
        'purchase_date',
        'expire_date',
        'duration',
        'status',
        'payment_id',
        'order_id',
        'note',
    ];
}
