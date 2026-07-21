<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipCollegeSubmit extends Model
{
    protected $table = 'tbl_internship_college_submits';

    protected $fillable = [
        'internship_id',
        'college_id',
        'course_id',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internship_id');
    }
}
