<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Minqualification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_min_qualification';        // Custom table name
    protected $primaryKey = 'qualification_id';        // Custom primary key

    protected $fillable = [
        'name',
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
