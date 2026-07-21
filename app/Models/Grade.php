<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'college_id',
        'course_id',
        'total_marks',
    ];

    protected $casts = [
        'total_marks' => 'integer',
    ];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function sections()
    {
        return $this->hasMany(GradeSection::class);
    }

    public function criteria()
    {
        return $this->hasMany(GradeCriterion::class);
    }
}
