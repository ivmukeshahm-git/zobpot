<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'tbl_testimonial';        // Custom table name
    protected $primaryKey = 'id';        // Custom primary key

    protected $fillable = [
        'username',
        'designation',
        'description',
        'profile_img',
        'status',
    ];

}
