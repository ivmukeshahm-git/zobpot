<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobRound extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_job_round';        // Custom table name
    protected $primaryKey = 'id';        // Custom primary key

    protected $fillable = [
        'job_id',
        'round_name',
        'round_desc'
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
