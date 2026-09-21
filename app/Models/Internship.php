<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Internship extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_internship';

    protected $fillable = [
        'internship_type',
        'internship_title',
        'slug',
        'category',
        'sub_categories',
        'company_id',
        'company_website',
        'mode',
        'location',
        'stipend',
        'openings',
        'duration',
        'total_weeks',
        'total_hours',
        'start_date',
        'end_date',
        'application_deadline',
        'last_registration_date',
        'batch_days',
        'skills',
        'eligibility_criteria',
        'internship_description',
        'module_brief_description',
        'internship_objective',
        'internship_outcome',
        'general_instructions',
        'perks',
        'registration_fees',
        'late_registration_fee',
        'gst_percentage',
        'gst_amount',
        'final_amount',
        'manage_task_status',
        'complete_status',
        'college_complete_sts',
        'company_complete_sts',
        'college_pending_flag',
        'approve_status',
        'rejection_reason',
    ];

    protected $casts = [
        'batch_days' => 'array',
        'perks' => 'array',
        'sub_categories' => 'array',
        'stipend' => 'decimal:2',
        'registration_fees' => 'decimal:2',
        'late_registration_fee' => 'decimal:2',
        'gst_percentage' => 'decimal:2',
        'gst_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'manage_task_status' => 'boolean',
        'complete_status' => 'integer',
        'college_complete_sts' => 'integer',
        'company_complete_sts' => 'integer',
        'college_pending_flag' => 'integer',
        'approve_status' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'application_deadline' => 'date',
        'last_registration_date' => 'date',
    ];

    // Relationship with User (Company)
    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    // Relationship with JobCategory
    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'category', 'category_id');
    }

    // Relationship with InternshipTask
    public function tasks()
    {
        return $this->hasMany(InternshipTask::class, 'internship_id');
    }

    // Relationship with Registration (Applications)
    public function applications()
    {
        return $this->hasMany(Registration::class, 'internship_id')->where('type', 2);
    }

    // Relationship with tbl_internship_application (preferred source of internship applications)
    public function internshipApplications()
    {
        return $this->hasMany(InternshipApplication::class, 'internship_id');
    }

    /**
     * Only internships that still have available openings.
     * Null or zero openings are treated as unlimited.
     */
    public function scopeWithAvailableOpenings($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('openings')
                ->orWhere('openings', '<=', 0)
                ->orWhereRaw('openings > (
                    SELECT COUNT(*)
                    FROM tbl_internship_application
                    WHERE tbl_internship_application.internship_id = tbl_internship.id
                )');
        });
    }

    public function hasAvailableOpenings(): bool
    {
        if (!$this->openings || $this->openings <= 0) {
            return true;
        }

        $appliedCount = $this->internship_applications_count
            ?? $this->internshipApplications()->count();

        return $appliedCount < (int) $this->openings;
    }

    // Relationship with InternshipMark
    public function marks()
    {
        return $this->hasMany(InternshipMark::class, 'internship_id');
    }
}
