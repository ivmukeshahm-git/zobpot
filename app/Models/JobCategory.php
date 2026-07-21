<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_job_category';        // Custom table name
    protected $primaryKey = 'category_id';        // Custom primary key

    protected $fillable = [
        'preference_type',
        'category_nm',
        'image'
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
