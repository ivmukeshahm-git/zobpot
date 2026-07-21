<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GradeSection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'grade_id',
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

    public function criteria()
    {
        return $this->hasMany(GradeCriterion::class, 'section_id');
    }
}
