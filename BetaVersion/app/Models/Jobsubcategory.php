<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jobsubcategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_sub_category';        // Custom table name
    protected $primaryKey = 'sub_category_id';        // Custom primary key

    protected $fillable = [
        'sub_category_nm',
        'category_id',
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
