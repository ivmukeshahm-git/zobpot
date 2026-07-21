<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achievement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_achievement';        // Custom table name
    protected $primaryKey = 'id';        // Custom primary key

    protected $fillable = [
        'count',
        'title',
        'description'
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
