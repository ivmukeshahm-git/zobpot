<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_area';        // Custom table name
    protected $primaryKey = 'area_id';        // Custom primary key

    protected $fillable = [
        'state_id',
        'city_id',
        'area_nm'
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
