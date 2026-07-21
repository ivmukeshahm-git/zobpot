<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PlanPricing extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_plan_pricing';
    protected $primaryKey = 'plan_id';

    protected $fillable = [
        'plan_name',
        'plan_price',
        'plan_description',
        'plan_for',
        'benefits',
        'plan_duration',
        'plan_time',
        'status',
    ];
}
