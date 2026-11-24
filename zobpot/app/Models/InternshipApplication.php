<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Internship;

class InternshipApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_internship_application';

    protected $fillable = [
        'user_id',
        'internship_id',
        'company_id',
        'college_id',
        'degree_id',
        'complete_status',
        'applied_on',
        'company_feedback',
        'college_feedback',
        'assigned_staff_id',
    ];

    protected $casts = [
        'applied_on' => 'datetime',
        'complete_status' => 'integer',
    ];

    /**
     * The user who submitted this application.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The internship this application belongs to.
     */
    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internship_id');
    }

    /**
     * The staff member assigned to this application (CollegeStaff model).
     */
    public function assignedStaff()
    {
        return $this->belongsTo(\App\Models\CollegeStaff::class, 'assigned_staff_id');
    }
}
