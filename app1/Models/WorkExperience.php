<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkExperience extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_work_experience';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'work_type_id',
        'user_id',
        'company',
        'working_status',
        'start_date',
        'end_date',
        'location',
        'job_type_id',
        'role_responsibility'
    ];

    protected $dates = ['deleted_at'];
}
