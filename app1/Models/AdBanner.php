<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdBanner extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_ad_banner';        // Custom table name
    protected $primaryKey = 'id';        // Custom primary key

    protected $fillable = [
        'page_nm',
        'ad_link',
        'img_nm',
        'start_date',
        'end_date',
        'datetime',
        'status'
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
