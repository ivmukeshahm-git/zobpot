<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_education';        // Custom table name
    protected $primaryKey = 'id';        // Custom primary key

    protected $fillable = [
        'school_name',
        'user_id',
        'degree',
        'field_of_study',
        'grade',
        'start_date',
        'end_date',
        'description'
    ];

    protected $dates = ['deleted_at'];            // Required for soft deletes
}
