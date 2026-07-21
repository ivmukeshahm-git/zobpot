<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zipcode extends Model
{
   use HasFactory, SoftDeletes;

    protected $table = 'tbl_zipcode';        // Custom table name
    protected $primaryKey = 'zipcode_id';        // Custom primary key

    protected $fillable = [
        'state_id',
        'city_id',
        'area_id',
        'zipcode'
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
