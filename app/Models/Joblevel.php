<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Joblevel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_job_level';        // Custom table name
    protected $primaryKey = 'job_level_id';        // Custom primary key

    protected $fillable = [
        'type_nm',
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
