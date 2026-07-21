<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Experiencereq extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_experience_req';        // Custom table name
    protected $primaryKey = 'experience_req_id';        // Custom primary key

    protected $fillable = [
        'name',
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
