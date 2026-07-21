<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InternshipTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_internship_tasks';

    protected $fillable = [
        'internship_id',
        'parent_id',
        'student_id',
        'date_time',
        'day',
        'module_title',
        'module_description',
        'upload_file',
        'last_submission_date',
        'student_submit_file',
        'student_submit_description',
        'student_submit_project_link',
        'submit_on',
        'online_link',
        'is_final_assignment',
        'status',
        'task_feedback',
    ];

    protected $casts = [
        'date_time' => 'datetime',
        'last_submission_date' => 'date',
        'is_final_assignment' => 'boolean',
        'status' => 'integer',
    ];

    /**
     * Relationship with Internship
     */
    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internship_id');
    }

    /**
     * Optional parent task (for sub-tasks)
     */
    public function parent()
    {
        return $this->belongsTo(InternshipTask::class, 'parent_id');
    }

    /**
     * Student assigned to the task (if applicable)
     */
    public function student()
    {
        return $this->belongsTo(\App\Models\User::class, 'student_id');
    }
}
