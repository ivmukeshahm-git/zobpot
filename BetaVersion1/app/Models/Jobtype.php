<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jobtype extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_job_type';        // Custom table name
    protected $primaryKey = 'job_type_id';        // Custom primary key

    protected $fillable = [
        'type_name',
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
