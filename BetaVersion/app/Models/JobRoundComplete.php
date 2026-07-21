<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRoundComplete extends Model
{
    use HasFactory;

    protected $table = 'tbl_round_complete';        // Custom table name
    protected $primaryKey = 'id';        // Custom primary key

    protected $fillable = [
        'round_id',
        'user_id',
        'job_id',
        'hr_name',
        'hr_contact_no',
        'hr_email',
        'interview_address',
        'datetime',
        'time',
        'status',
        'remarks'
    ];

}
