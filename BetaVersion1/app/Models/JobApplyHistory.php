<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplyHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_job_apply_history';        // Custom table name
    protected $primaryKey = 'id';        // Custom primary key

    protected $fillable = [
        'user_id',
        'job_id',
        'job_apply_id',
        'msg',
        'datetime',
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
