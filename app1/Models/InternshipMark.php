<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipMark extends Model
{
    use HasFactory;

    protected $table = 'internship_marks';

    protected $fillable = [
        'internship_id',
        'student_id',
        'criteria_id',
        'criteria_name',
        'max_marks',
        'marks',
        'status',
    ];

    protected $casts = [
        'marks' => 'integer',
        'max_marks' => 'integer',
        'status' => 'integer',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internship_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function criterion()
    {
        return $this->belongsTo(GradeCriterion::class, 'criteria_id');
    }
}
