<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jobsave extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_job_save';        // Custom table name
    protected $primaryKey = 'id';        // Custom primary key

    protected $fillable = [
        'user_id',
        'job_id',
        'saved_at'
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
