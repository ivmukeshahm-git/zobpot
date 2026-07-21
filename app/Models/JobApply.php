<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApply extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_job_apply';        // Custom table name
    protected $primaryKey = 'id';        // Custom primary key

    protected $fillable = [
        'job_id',
        'user_id',
        'description',
        'file_nm',
        'status',
        'datetime'
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
