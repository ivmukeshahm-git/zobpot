<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worktype extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_work_type';        // Custom table name
    protected $primaryKey = 'work_type_id';        // Custom primary key

    protected $fillable = [
        'type_nm',
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
