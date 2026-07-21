<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skills extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_skills';        // Custom table name
    protected $primaryKey = 'id';        // Custom primary key

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'skill_nm'
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
