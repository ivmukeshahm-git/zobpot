<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_city';        // Custom table name
    protected $primaryKey = 'city_id';        // Custom primary key

    protected $fillable = [
        'state_id',
        'city_nm'
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
