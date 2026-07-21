<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GradeCriterion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'grade_id',
        'section_id',
        'title',
        'marks',
    ];

    protected $casts = [
        'marks' => 'integer',
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function section()
    {
        return $this->belongsTo(GradeSection::class, 'section_id');
    }
}
