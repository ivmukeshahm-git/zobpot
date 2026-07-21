<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipReview extends Model
{
    protected $table = 'tbl_internship_review';

    protected $fillable = [
        'internship_id',
        'student_id',
        'star',
        'review',
        'active_status',
        'write_on',
    ];

    protected $casts = [
        'write_on' => 'datetime',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internship_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
