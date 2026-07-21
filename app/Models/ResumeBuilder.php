<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ResumeBuilder extends Model
{
    use HasFactory;

    protected $table = 'tbl_resume_builder';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'resume_id',
        'profile_img',
        'full_name',
        'email',
        'phone',
        'skills',
        'designation',
        'summary',
        'experience',
        'education',
        'dob',
        'marital_status',
        'address',
        'language_known',
        'gender'
    ];
}
