<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Internship;
use App\Models\InternshipTask;
use App\Models\InternshipApplication;
use App\Models\InternshipMark;
use App\Models\InternshipReview;
use App\Models\PlanPricing;
use App\Models\User;
use App\Models\Grade;
use App\Models\GradeSection;
use App\Models\GradeCriterion;
use App\Models\College;
use App\Models\Degree;
use App\Models\Setting;
use App\Models\CertificateSetting;
use App\Models\InternshipWishlist;
use App\Models\InternshipPayment;
use App\Helpers\PaymentHelper;
use Carbon\Carbon;

class InternshipController extends Controller
{
    // ==========================================
    // COMPANY SIDE APIs
    // ==========================================

    public function createInternship(Request $request)
    {
        if ($request->has('batch_days') && is_string($request->batch_days)) {
            $request->merge(['batch_days' => json_decode($request->batch_days, true)]);
        }

	if (in_array($request->company_website, ['', 'null', 'undefined', null], true)) {
            $request->merge(['company_website' => null]);
        }

        $request->validate([
            'company_id' => 'required|exists:users,id',
            'internship_title' => 'required|string|max:255',
            'category_id' => 'nullable|integer',
            'new_category_name' => 'nullable|string',
            'sub_category_id' => 'nullable|array',
            'sub_category_id.*' => 'integer',
            'new_sub_category_names' => 'nullable|array',
            'new_sub_category_names.*' => 'string',
            'company_website' => 'nullable|url|max:255',
            'internship_mode' => 'required|in:Online,Offline,Hybrid,Weekly Internship,Part Time Internship,Full Time Internship',
            'location' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'weeks' => 'required|integer|min:1',
            'hours' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'application_deadline' => 'required|date',
            'stipend' => 'nullable|numeric|min:0',
            'openings' => 'required|integer|min:1',
            'required_skills' => 'nullable|string',
            'required_eligibility_criteria' => 'nullable|string',
            'internship_description' => 'required|string',
            'module_description' => 'required|string',
            'internship_objective' => 'required|string',
            'internship_outcome' => 'required|string',
            'internship_fee' => 'nullable|numeric|min:0',
            'last_registration_date' => 'nullable|date',
            'late_register_last_date' => 'nullable|date',
            'late_registration_fee' => 'nullable|numeric|min:0',
            'gst_percentage' => 'nullable|numeric|min:0|max:100',
            'gst_amount' => 'nullable|numeric|min:0',
            'total_fee' => 'nullable|numeric|min:0',
        ]);

        if (empty($request->category_id) && empty($request->new_category_name)) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'category_id' => ['Either category_id or new_category_name must be provided.']
                ]
            ], 422);
        }

        if ($request->filled('new_category_name')) {
            $exists = \App\Models\JobCategory::where('category_nm', $request->new_category_name)->exists();
            if ($exists) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'new_category_name' => ['This category already exists. Please select it from the list.']
                    ]
                ], 422);
            }
        }

        if (!empty($request->new_sub_category_names)) {
            foreach ((array)$request->new_sub_category_names as $subName) {
                $query = \App\Models\Jobsubcategory::where('sub_category_nm', $subName);
                if ($request->filled('category_id') && empty($request->new_category_name)) {
                    $query->where('category_id', $request->category_id);
                }
                if ($query->exists()) {
                    return response()->json([
                        'message' => 'The given data was invalid.',
                        'errors' => [
                            'new_sub_category_names' => ["The sub-category '{$subName}' already exists. Please select it from the list."]
                        ]
                    ], 422);
                }
            }
        }

        try {
            $user = User::find($request->company_id);

            if ($user && ($user->profile_type ?? '') === 'Company') {
                if (!PlanPricing::companyCanPost($user, 'internship')) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Your current plan does not include Opportunity service. Please upgrade your plan to post opportunities.',
                    ], 403);
                }

                $limitCheck = PlanPricing::checkServiceLimit($user, 'internship', 'create');
                if (!$limitCheck['allowed']) {
                    return response()->json([
                        'status' => false,
                        'message' => $limitCheck['message'],
                        'limit' => $limitCheck['limit'],
                        'used' => $limitCheck['used'],
                    ], 403);
                }
            }
            
            $slug = Str::slug($request->internship_title);
            $originalSlug = $slug;
            $counter = 1;
            
            while (Internship::withTrashed()->where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $batchDays = $request->batch_days ?? [];
            $perks = $request->perks ?? [];

            $useOtherCategory = !empty($request->new_category_name);
            $categoryId = $useOtherCategory ? 0 : (int) $request->category_id;
            
            $subCategories = [];
            if (!$useOtherCategory) {
                $subCategories = array_values(array_filter(array_map('intval', (array) $request->input('sub_category_id', []))));
            }

            $registrationFees = (float) ($request->internship_fee ?? 0);
            $lateRegistrationFee = $request->filled('late_registration_fee') ? (float) $request->late_registration_fee : 0;
            $lastRegistrationDate = $request->input('last_registration_date') ?: $request->input('late_register_last_date');
            
            $gstPercentage = (float) ($request->gst_percentage ?? 0);
            $gstAmount = $request->filled('gst_amount') ? (float) $request->gst_amount : round(($registrationFees * $gstPercentage) / 100, 2);
            $finalAmount = $request->filled('total_fee') ? (float) $request->total_fee : round($registrationFees + $gstAmount, 2);
            
            $internship = Internship::create([
                'internship_title' => $request->internship_title,
                'slug' => $slug,
                'category' => $categoryId,
                'sub_categories' => $subCategories,
                'company_id' => $user->id,
                'company_website' => $request->company_website,
                'mode' => $request->internship_mode,
                'location' => $request->location,
                'duration' => $request->duration,
                'total_weeks' => $request->weeks,
                'total_hours' => $request->hours,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'application_deadline' => $request->application_deadline,
                'stipend' => $request->stipend,
                'openings' => $request->openings,
                'skills' => $request->required_skills,
                'eligibility_criteria' => $request->required_eligibility_criteria,
                'internship_description' => $request->internship_description,
                'module_brief_description' => $request->module_description,
                'internship_objective' => $request->internship_objective,
                'internship_outcome' => $request->internship_outcome,
                'batch_days' => $batchDays,
                'perks' => $perks,
                'registration_fees' => $registrationFees,
                'late_registration_fee' => $lateRegistrationFee,
                'last_registration_date' => $lastRegistrationDate,
                'gst_percentage' => $gstPercentage,
                'gst_amount' => $gstAmount,
                'final_amount' => $finalAmount,
                'manage_task_status' => $request->manage_task_status ?? 0,
                'approve_status' => 0, // Pending by default in web
            ]);

            if ($useOtherCategory) {
                \App\Models\CategorySubcategoryRequest::create([
                    'request_type' => 'category',
                    'requested_name' => trim((string) $request->new_category_name),
                    'user_id' => $user->id,
                    'internship_id' => $internship->id,
                    'status' => \App\Models\CategorySubcategoryRequest::STATUS_PENDING,
                ]);
            }

            if (!empty($request->new_sub_category_names)) {
                $parentCategoryId = $useOtherCategory ? null : (int)$request->category_id;
                $parentCategoryName = $useOtherCategory ? trim((string)$request->new_category_name) : optional(\App\Models\JobCategory::find($parentCategoryId))->category_nm;
                
                foreach ((array)$request->new_sub_category_names as $newSubCat) {
                    if (trim((string)$newSubCat) !== '') {
                        \App\Models\CategorySubcategoryRequest::create([
                            'request_type' => 'subcategory',
                            'requested_name' => trim((string)$newSubCat),
                            'category_id' => $parentCategoryId ?: null,
                            'parent_category_name' => $parentCategoryName ?: null,
                            'user_id' => $user->id,
                            'internship_id' => $internship->id,
                            'status' => \App\Models\CategorySubcategoryRequest::STATUS_PENDING,
                        ]);
                    }
                }
            }

            PlanPricing::incrementServiceUsage($user, 'internship');

            return response()->json([
                'status' => true,
                'message' => 'Internship created successfully. Waiting for admin approval.',
                'data' => $internship
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getPerksAndBenefits()
    {
        $perks = [
            'Certificate', 'Letter of Recommendation', 'Flexible Work Hours', 
            '5 Days a Week', 'Free Snacks & Beverages', 'Health Insurance', 
            'Job Offer (PPO)', 'Mentorship', 'Work from Home'
        ];

        return response()->json([
            'status' => true,
            'message' => 'Perks list fetched successfully',
            'data' => $perks
        ], 200);
    }

    public function getCompanyInternships(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:users,id'
        ]);

        $internships = Internship::with(['jobCategory'])
            ->withCount(['internshipApplications as applied_count'])
            ->where('company_id', $request->company_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $internships->transform(function ($internship) {
            if (is_array($internship->sub_categories) && count($internship->sub_categories) > 0) {
                $internship->sub_categories_data = \App\Models\Jobsubcategory::whereIn('sub_category_id', $internship->sub_categories)->get();
            } else {
                $internship->sub_categories_data = [];
            }
            return $this->attachPendingCategorySubcategory($internship);
        });

        return response()->json([
            'status' => true,
            'message' => 'Company internships fetched successfully',
            'data' => $internships
        ], 200);
    }
    public function getInternshipApplicants(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:tbl_internship,id'
        ]);

        $applications = InternshipApplication::with(['user', 'internship'])
            ->where('internship_id', $request->internship_id)
            ->orderBy('applied_on', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Applicants fetched successfully',
            'data' => $applications
        ], 200);
    }

    public function getInternshipDetails(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:tbl_internship,id',
            'student_id'    => 'nullable|exists:users,id',
            'user_id'       => 'nullable|exists:users,id',
        ]);

        $internship = Internship::with(['company', 'jobCategory', 'tasks', 'marks'])
            ->find($request->internship_id);

        if (!$internship) {
            return response()->json([
                'status' => false,
                'message' => 'Internship not found'
            ], 404);
        }

        $userId = $request->student_id ?? $request->user_id ?? Auth::id();
        $isSaved = false;
        if (!empty($userId)) {
            $isSaved = InternshipWishlist::where('user_id', $userId)
                ->where('internship_id', $internship->id)
                ->exists();
        }

        $internship->is_saved = $isSaved;
        $internship->is_wishlist = $isSaved;

        if (is_array($internship->sub_categories) && count($internship->sub_categories) > 0) {
            $internship->sub_categories_data = \App\Models\Jobsubcategory::whereIn('sub_category_id', $internship->sub_categories)->get();
        } else {
            $internship->sub_categories_data = [];
        }

        $internship = $this->attachPendingCategorySubcategory($internship);

        $isSubmitted = ($internship->company_complete_sts == 1 || $internship->complete_status == 1);
        $internship->is_submitted = $isSubmitted;
        $internship->evaluation_data = $this->buildEvaluationData($internship);

        return response()->json([
            'status' => true,
            'message' => 'Internship details fetched successfully',
            'data' => $internship
        ], 200);
    }

    /** Build evaluation and criteria data for all enrolled students */
    private function buildEvaluationData($internship)
    {
        $applications = InternshipApplication::with(['user.college', 'user.degree'])
            ->where('internship_id', $internship->id)
            ->get();

        $savedMarks = InternshipMark::where('internship_id', $internship->id)
            ->get()
            ->groupBy('student_id');

        $isSubmitted = ($internship->company_complete_sts == 1 || $internship->complete_status == 1);

        $gradeLetter = function (float $pct): string {
            if ($pct >= 90) return 'A+';
            if ($pct >= 80) return 'A';
            if ($pct >= 70) return 'B';
            if ($pct >= 60) return 'C';
            if ($pct >= 50) return 'D';
            if ($pct >  0)  return 'F';
            return '-';
        };

        $studentsData = [];
        $hasIndustryCriteria = false;
        $criteriaCache = [];

        foreach ($applications as $app) {
            $student = $app->user;
            if (!$student) continue;

            $cKey = "{$student->college_id}:{$student->degree_id}";
            if (!array_key_exists($cKey, $criteriaCache)) {
                $grade = Grade::where('college_id', $student->college_id)
                    ->when($student->degree_id, fn($q) => $q->where('course_id', $student->degree_id))
                    ->first();
                $industryCrit = collect();
                if ($grade) {
                    $sectionIds = GradeSection::where('grade_id', $grade->id)
                        ->where('title', 'Industry Marks')
                        ->pluck('id');
                    $industryCrit = GradeCriterion::whereIn('section_id', $sectionIds)
                        ->whereNull('deleted_at')
                        ->get();
                }
                $criteriaCache[$cKey] = $industryCrit;
            }

            $criteriaList = $criteriaCache[$cKey];
            if ($criteriaList->isNotEmpty()) {
                $hasIndustryCriteria = true;
            }

            $studentSaved = isset($savedMarks[$student->id]) ? $savedMarks[$student->id]->keyBy('criteria_id') : collect();

            $totalObtained = 0;
            $totalMax = (int) $criteriaList->sum('marks');
            $criteriaFormatted = [];

            foreach ($criteriaList as $crit) {
                $obtained = isset($studentSaved[$crit->id]) ? (int)$studentSaved[$crit->id]->marks : 0;
                $totalObtained += $obtained;

                $criteriaFormatted[] = [
                    'criteria_id' => $crit->id,
                    'criteria_name' => $crit->title,
                    'max_marks' => (int)$crit->marks,
                    'obtained_marks' => $obtained,
                ];
            }

            $percentage = $totalMax > 0 ? round(($totalObtained / $totalMax) * 100, 2) : 0.00;
            $grade = $totalObtained > 0 ? $gradeLetter($percentage) : '-';

            // Certificate logic
            $isComplete = (int) $app->complete_status === 1;
            $companyCertReady = (int) ($internship->company_complete_sts ?? 0) === 1 || $isComplete;
            $collegeCertReady = (int) ($internship->internship_type ?? 0) === 1
                              && (int) ($internship->college_complete_sts ?? 0) === 1;
            $certificateAvailable = $companyCertReady || $collegeCertReady;

            $studentsData[] = [
                'student_id' => $student->id,
                'student_name' => $student->name ?? '',
                'email' => $student->email ?? '',
                'profile_img' => $student->profile_img ? asset('uploads/users/' . $student->profile_img) : null,
                'college_name' => $student->college->college_name ?? null,
                'degree_name' => $student->degree->degree_name ?? null,
                'company_feedback' => $app->company_feedback,
                'total_obtained_marks' => $totalObtained,
                'total_max_marks' => $totalMax,
                'percentage' => $percentage,
                'grade' => $grade,
                'is_submitted' => $isSubmitted,
                'certificate_available' => $certificateAvailable,
                'company_certificate_available' => $companyCertReady,
                'college_certificate_available' => $collegeCertReady,
                'company_certificate_download_url' => $companyCertReady
                    ? url('/api/candidate/internship/certificate/pdf/' . $app->id . '/company') : null,
                'company_certificate_preview_url'  => $companyCertReady
                    ? url('/api/candidate/internship/certificate/preview/' . $app->id . '/company') : null,
                'college_certificate_download_url' => $collegeCertReady
                    ? url('/api/candidate/internship/certificate/pdf/' . $app->id . '/college') : null,
                'college_certificate_preview_url'  => $collegeCertReady
                    ? url('/api/candidate/internship/certificate/preview/' . $app->id . '/college') : null,
                'criteria' => $criteriaFormatted
            ];
        }

        return [
            'has_industry_criteria' => $hasIndustryCriteria,
            'is_submitted' => $isSubmitted,
            'students' => $studentsData
        ];
    }

    public function addUpdateGeneralInstruction(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:tbl_internship,id',
            'general_instructions' => 'required|string'
        ]);

        $internship = Internship::find($request->internship_id);
        $internship->general_instructions = $request->general_instructions;
        $internship->save();

        return response()->json([
            'status' => true,
            'message' => 'General instructions saved successfully.',
            'data' => $internship
        ], 200);
    }

    public function editInternship(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:tbl_internship,id',
            'internship_title' => 'required|string|max:255',
            'category_id' => 'nullable|integer',
            'new_category_name' => 'nullable|string',
            'sub_category_id' => 'nullable|array',
            'sub_category_id.*' => 'integer',
            'new_sub_category_names' => 'nullable|array',
            'new_sub_category_names.*' => 'string',
        ]);

        if (empty($request->category_id) && empty($request->new_category_name) && !$request->has('category_id')) {
            // we allow missing category_id entirely if they don't want to update it, but if they pass it, one must be there.
            // actually the previous rule was required, so we just enforce one of them is present if they want to update
        }

        if ($request->filled('new_category_name')) {
            $exists = \App\Models\JobCategory::where('category_nm', $request->new_category_name)->exists();
            if ($exists) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'new_category_name' => ['This category already exists. Please select it from the list.']
                    ]
                ], 422);
            }
        }

        if (!empty($request->new_sub_category_names)) {
            foreach ((array)$request->new_sub_category_names as $subName) {
                $query = \App\Models\Jobsubcategory::where('sub_category_nm', $subName);
                if ($request->filled('category_id') && empty($request->new_category_name)) {
                    $query->where('category_id', $request->category_id);
                }
                if ($query->exists()) {
                    return response()->json([
                        'message' => 'The given data was invalid.',
                        'errors' => [
                            'new_sub_category_names' => ["The sub-category '{$subName}' already exists. Please select it from the list."]
                        ]
                    ], 422);
                }
            }
        }

        try {
            $internship = Internship::find($request->internship_id);
            
            if ($request->has('batch_days') && is_string($request->batch_days)) {
                $request->merge(['batch_days' => json_decode($request->batch_days, true)]);
            }

            $batchDays = $request->batch_days ?? $internship->batch_days;
            $perks = $request->perks ?? $internship->perks;
            
            $useOtherCategory = !empty($request->new_category_name);
            // If new category is provided, set categoryId to 0, otherwise if category_id is provided, use it, else keep old
            $categoryId = $useOtherCategory ? 0 : ($request->filled('category_id') ? (int) $request->category_id : $internship->category);
            
            $subCategories = [];
            if (!$useOtherCategory && $request->has('sub_category_id')) {
                $subCategories = array_values(array_filter(array_map('intval', (array) $request->input('sub_category_id', []))));
            } else if (!$useOtherCategory) {
                $subCategories = $internship->sub_categories ?? [];
            }

            $registrationFees = (float) ($request->internship_fee ?? $internship->registration_fees);
            $gstPercentage = (float) ($request->gst_percentage ?? $internship->gst_percentage);
            $gstAmount = $request->filled('gst_amount') ? (float) $request->gst_amount : round(($registrationFees * $gstPercentage) / 100, 2);
            $finalAmount = $request->filled('total_fee') ? (float) $request->total_fee : round($registrationFees + $gstAmount, 2);

            $internship->update([
                'internship_title' => $request->internship_title,
                'category' => $categoryId,
                'sub_categories' => $subCategories,
                'mode' => $request->internship_mode ?? $internship->mode,
                'location' => $request->location ?? $internship->location,
                'duration' => $request->duration ?? $internship->duration,
                'total_weeks' => $request->weeks ?? $internship->total_weeks,
                'total_hours' => $request->hours ?? $internship->total_hours,
                'start_date' => $request->start_date ?? $internship->start_date,
                'end_date' => $request->end_date ?? $internship->end_date,
                'application_deadline' => $request->application_deadline ?? $internship->application_deadline,
                'openings' => $request->openings ?? $internship->openings,
                'skills' => $request->required_skills ?? $internship->skills,
                'eligibility_criteria' => $request->required_eligibility_criteria ?? $internship->eligibility_criteria,
                'internship_description' => $request->internship_description ?? $internship->internship_description,
                'module_brief_description' => $request->module_description ?? $internship->module_brief_description,
                'internship_objective' => $request->internship_objective ?? $internship->internship_objective,
                'internship_outcome' => $request->internship_outcome ?? $internship->internship_outcome,
                'batch_days' => $batchDays,
                'perks' => $perks,
                'registration_fees' => $registrationFees,
                'late_registration_fee' => $request->late_registration_fee ?? $internship->late_registration_fee,
                'last_registration_date' => $request->input('last_registration_date') ?: $request->input('late_register_last_date', $internship->last_registration_date),
                'gst_percentage' => $gstPercentage,
                'gst_amount' => $gstAmount,
                'final_amount' => $finalAmount,
                'manage_task_status' => $request->manage_task_status ?? $internship->manage_task_status,
            ]);
            
            $user = User::find($internship->company_id) ?? auth()->user();

            if ($useOtherCategory) {
                \App\Models\CategorySubcategoryRequest::create([
                    'request_type' => 'category',
                    'requested_name' => trim((string) $request->new_category_name),
                    'user_id' => $user->id,
                    'internship_id' => $internship->id,
                    'status' => \App\Models\CategorySubcategoryRequest::STATUS_PENDING,
                ]);
            }

            if (!empty($request->new_sub_category_names)) {
                $parentCategoryId = $useOtherCategory ? null : (int)$request->category_id;
                $parentCategoryName = $useOtherCategory ? trim((string)$request->new_category_name) : optional(\App\Models\JobCategory::find($parentCategoryId))->category_nm;
                
                foreach ((array)$request->new_sub_category_names as $newSubCat) {
                    if (trim((string)$newSubCat) !== '') {
                        \App\Models\CategorySubcategoryRequest::create([
                            'request_type' => 'subcategory',
                            'requested_name' => trim((string)$newSubCat),
                            'category_id' => $parentCategoryId ?: null,
                            'parent_category_name' => $parentCategoryName ?: null,
                            'user_id' => $user->id,
                            'internship_id' => $internship->id,
                            'status' => \App\Models\CategorySubcategoryRequest::STATUS_PENDING,
                        ]);
                    }
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Internship updated successfully.',
                'data' => $internship
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteInternship(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:tbl_internship,id'
        ]);

        $internship = Internship::find($request->internship_id);
        $internship->delete();

        return response()->json([
            'status' => true,
            'message' => 'Internship deleted successfully.'
        ], 200);
    }

    public function toggleInternshipStatus(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:tbl_internship,id',
            'status' => 'nullable|in:0,1'
        ]);

        $internship = Internship::find($request->internship_id);
        
        // If status is passed, use it. Otherwise, simply toggle the current complete_status
        $newStatus = $request->has('status') ? (int) $request->status : ($internship->complete_status == 1 ? 0 : 1);
        
        $internship->complete_status = $newStatus;
        $internship->save();

        return response()->json([
            'status' => true,
            'message' => 'Status changed successfully.',
            'data' => $internship
        ], 200);
    }

    public function getInternshipTasks(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:tbl_internship,id'
        ]);

        $tasks = InternshipTask::where('internship_id', $request->internship_id)
            ->whereNull('parent_id') // Master tasks only (1 row per task, same as web)
            ->orderBy('date_time', 'asc')
            ->get();

        $formattedTasks = $tasks->map(function ($task) {
            $childTasks = InternshipTask::where('parent_id', $task->id)->get();
            $totalStudents = $childTasks->count();
            $completedStudents = $childTasks->where('status', 1)->count();
            $pendingStudents = $totalStudents - $completedStudents;

            $statusText = 'No Students';
            if ($totalStudents > 0) {
                $statusText = ($completedStudents == $totalStudents) 
                    ? "Completed ({$completedStudents}/{$totalStudents})" 
                    : "Pending ({$completedStudents}/{$totalStudents})";
            }

            return [
                'id' => $task->id,
                'internship_id' => $task->internship_id,
                'module_title' => $task->module_title,
                'module_description' => $task->module_description,
                'date_time' => $task->date_time,
                'day' => $task->day,
                'last_submission_date' => $task->last_submission_date,
                'online_link' => $task->online_link,
                'is_final_assignment' => (bool)$task->is_final_assignment,
                'upload_file' => $task->upload_file,
                'upload_file_url' => $task->upload_file ? url('uploads/internship_tasks/' . $task->upload_file) : null,
                'total_students' => $totalStudents,
                'completed_students' => $completedStudents,
                'pending_students' => $pendingStudents,
                'submission_status_text' => $statusText,
                'status' => $task->status,
                'created_at' => $task->created_at,
                'updated_at' => $task->updated_at,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Tasks fetched successfully.',
            'data' => $formattedTasks
        ], 200);
    }

    public function addInternshipTask(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:tbl_internship,id',
            'task_name' => 'nullable|string|max:255',
            'module_title' => 'nullable|string|max:255',
            'task_description' => 'nullable|string',
            'module_description' => 'nullable|string',
            'date_time' => 'required|date',
            'day' => 'nullable|string|max:50',
            'last_submission_date' => 'nullable|date',
            'online_link' => 'nullable|url',
            'is_final_assignment' => 'nullable',
            'upload_file' => 'nullable|file|max:5120',
            'document_file' => 'nullable|file|max:5120',
            'task_file' => 'nullable|file|max:5120',
        ]);

        $title = $request->task_name ?? $request->module_title;
        $description = $request->task_description ?? $request->module_description;

        if (empty($title) || empty($description)) {
            return response()->json([
                'status' => false,
                'message' => 'Task name and description are required.'
            ], 422);
        }

        $task = new InternshipTask();
        $task->internship_id = $request->internship_id;
        $task->module_title = $title;
        $task->module_description = $description;
        $task->date_time = $request->date_time;
        $task->day = $request->day ?? Carbon::parse($request->date_time)->format('l');
        $task->last_submission_date = $request->last_submission_date ?? Carbon::parse($request->date_time)->addDays(1)->format('Y-m-d H:i:s');
        $task->online_link = $request->online_link;
        $task->is_final_assignment = $request->is_final_assignment ? 1 : 0;

        // Handle document/file upload (Max 5MB, any file format)
        $file = $request->file('upload_file') ?? $request->file('document_file') ?? $request->file('task_file');
        if ($file) {
            $destination = public_path('uploads/internship_tasks');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $ext = $file->getClientOriginalExtension() ?: 'pdf';
            $fileName = time() . '_task_' . Str::random(6) . '.' . $ext;
            $file->move($destination, $fileName);
            $task->upload_file = $fileName;
        }

        $task->save();

        // Assign to all unique students currently enrolled in this internship
        $students = InternshipApplication::where('internship_id', $request->internship_id)
            ->pluck('user_id')
            ->filter()
            ->unique();

        foreach ($students as $studentId) {
            $exists = InternshipTask::where('parent_id', $task->id)
                ->where('student_id', $studentId)
                ->exists();

            if ($exists) {
                continue;
            }

            $studentTask = new InternshipTask();
            $studentTask->internship_id = $request->internship_id;
            $studentTask->parent_id = $task->id;
            $studentTask->student_id = $studentId;
            $studentTask->module_title = $task->module_title;
            $studentTask->module_description = $task->module_description;
            $studentTask->date_time = $task->date_time;
            $studentTask->day = $task->day;
            $studentTask->last_submission_date = $task->last_submission_date;
            $studentTask->online_link = $task->online_link;
            $studentTask->is_final_assignment = $task->is_final_assignment;
            $studentTask->upload_file = $task->upload_file;
            $studentTask->status = 0; // pending
            $studentTask->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Task created and assigned to students successfully.',
            'data' => $task
        ], 200);
    }

    public function viewInternshipTask(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tbl_internship_tasks,id'
        ]);

        $task = InternshipTask::find($request->task_id);

        return response()->json([
            'status' => true,
            'message' => 'Task fetched successfully.',
            'data' => $task
        ], 200);
    }

    public function editInternshipTask(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tbl_internship_tasks,id',
            'task_name' => 'nullable|string|max:255',
            'module_title' => 'nullable|string|max:255',
            'task_description' => 'nullable|string',
            'module_description' => 'nullable|string',
            'date_time' => 'nullable|date',
            'day' => 'nullable|string|max:50',
            'last_submission_date' => 'nullable|date',
            'online_link' => 'nullable|url',
            'is_final_assignment' => 'nullable',
            'upload_file' => 'nullable|file|max:5120',
            'document_file' => 'nullable|file|max:5120',
            'task_file' => 'nullable|file|max:5120',
        ]);

        $task = InternshipTask::find($request->task_id);
        if (!$task) {
            return response()->json(['status' => false, 'message' => 'Task not found.'], 404);
        }

        if ($request->filled('task_name') || $request->filled('module_title')) {
            $task->module_title = $request->task_name ?? $request->module_title;
        }
        if ($request->filled('task_description') || $request->filled('module_description')) {
            $task->module_description = $request->task_description ?? $request->module_description;
        }
        if ($request->filled('date_time')) {
            $task->date_time = $request->date_time;
            if (!$request->filled('day')) {
                $task->day = Carbon::parse($request->date_time)->format('l');
            }
        }
        if ($request->filled('day')) {
            $task->day = $request->day;
        }
        if ($request->filled('last_submission_date')) {
            $task->last_submission_date = $request->last_submission_date;
        }
        if ($request->has('online_link')) {
            $task->online_link = $request->online_link;
        }
        if ($request->has('is_final_assignment')) {
            $task->is_final_assignment = $request->is_final_assignment ? 1 : 0;
        }

        $file = $request->file('upload_file') ?? $request->file('document_file') ?? $request->file('task_file');
        if ($file) {
            $destination = public_path('uploads/internship_tasks');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            if ($task->upload_file && file_exists(public_path('uploads/internship_tasks/' . $task->upload_file))) {
                @unlink(public_path('uploads/internship_tasks/' . $task->upload_file));
            }
            $ext = $file->getClientOriginalExtension() ?: 'pdf';
            $fileName = time() . '_task_' . Str::random(6) . '.' . $ext;
            $file->move($destination, $fileName);
            $task->upload_file = $fileName;
        }

        $task->save();

        // Propagate updates to child tasks
        $updateData = [
            'module_title' => $task->module_title,
            'module_description' => $task->module_description,
            'date_time' => $task->date_time,
            'day' => $task->day,
            'last_submission_date' => $task->last_submission_date,
            'online_link' => $task->online_link,
            'is_final_assignment' => $task->is_final_assignment,
        ];
        if (isset($fileName)) {
            $updateData['upload_file'] = $fileName;
        }

        InternshipTask::where('parent_id', $task->id)->update($updateData);

        return response()->json([
            'status' => true,
            'message' => 'Task updated successfully.',
            'data' => $task
        ], 200);
    }

    public function deleteInternshipTask(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tbl_internship_tasks,id'
        ]);

        $task = InternshipTask::find($request->task_id);
        if ($task) {
            $task->delete(); // Soft deletes the master task
            InternshipTask::where('parent_id', $task->id)->delete(); // Soft deletes child tasks
        }

        return response()->json([
            'status' => true,
            'message' => 'Task deleted successfully.'
        ], 200);
    }

    public function getTaskSubmissions(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tbl_internship_tasks,id' // Master task id
        ]);

        $masterTask = InternshipTask::where('id', $request->task_id)
            ->whereNull('parent_id')
            ->first();

        $submissions = InternshipTask::with(['student'])
            ->where('parent_id', $request->task_id)
            ->get();

        $completed = $submissions->where('status', 1)->count();
        $total = $submissions->count();
        $pending = $total - $completed;

        $studentList = $submissions->map(function ($sub, $idx) use ($masterTask) {
            return [
                'sr' => $idx + 1,
                'child_task_id' => $sub->id,
                'student_id' => $sub->student_id,
                'student_name' => optional($sub->student)->name ?? 'N/A',
                'student_email' => optional($sub->student)->email ?? 'N/A',
                'task_title' => $sub->module_title ?? optional($masterTask)->module_title,
                'status' => (int)$sub->status,
                'status_text' => $sub->status == 1 ? 'Submitted' : 'Pending',
                'student_submit_file' => $sub->student_submit_file,
                'student_submit_file_url' => $sub->student_submit_file ? url('uploads/internship_tasks_submit/' . $sub->student_submit_file) : null,
                'student_submit_description' => $sub->student_submit_description,
                'student_submit_project_link' => $sub->student_submit_project_link,
                'submit_on' => $sub->submit_on ? Carbon::parse($sub->submit_on)->format('d M Y, h:i A') : null,
                'task_feedback' => $sub->task_feedback,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Submissions fetched successfully.',
            'data' => [
                'master_task_id' => (int)$request->task_id,
                'task_title' => optional($masterTask)->module_title ?? 'Untitled Task',
                'total_students' => $total,
                'completed_students' => $completed,
                'pending_students' => $pending,
                'students' => $studentList
            ]
        ], 200);
    }

    public function viewSubmittedTask(Request $request)
    {
        $request->validate([
            'submission_id' => 'required|exists:tbl_internship_tasks,id'
        ]);

        $submission = InternshipTask::with(['student'])->find($request->submission_id);

        return response()->json([
            'status' => true,
            'message' => 'Submitted task details fetched successfully.',
            'data' => $submission
        ], 200);
    }

    public function addFeedback(Request $request)
    {
        $request->validate([
            'submission_id' => 'nullable|exists:tbl_internship_tasks,id',
            'task_id' => 'nullable|exists:tbl_internship_tasks,id',
            'student_id' => 'nullable|exists:users,id',
            'feedback' => 'nullable|string',
            'task_feedback' => 'nullable|string',
        ]);

        $feedbackText = $request->feedback ?? $request->task_feedback ?? $request->company_feedback;
        if (empty($feedbackText)) {
            return response()->json(['status' => false, 'message' => 'Feedback is required.'], 422);
        }

        $taskId = $request->submission_id ?? $request->task_id;
        if (!$taskId) {
            return response()->json(['status' => false, 'message' => 'Submission ID or Task ID is required.'], 422);
        }

        $submission = null;
        if ($request->filled('student_id')) {
            $submission = InternshipTask::where(function ($q) use ($taskId) {
                    $q->where('id', $taskId)
                      ->orWhere('parent_id', $taskId);
                })
                ->where('student_id', $request->student_id)
                ->first();
        } else {
            $submission = InternshipTask::find($taskId);
        }

        if (!$submission) {
            return response()->json(['status' => false, 'message' => 'Task submission not found.'], 404);
        }

        $submission->task_feedback = $feedbackText;
        $submission->save();

        return response()->json([
            'status' => true,
            'message' => 'Feedback saved successfully.',
            'data' => [
                'id' => $submission->id,
                'parent_id' => $submission->parent_id,
                'student_id' => $submission->student_id,
                'task_feedback' => $submission->task_feedback,
                'feedback' => $submission->task_feedback,
                'updated_at' => $submission->updated_at
            ]
        ], 200);
    }

    public function viewFeedback(Request $request)
    {
        $request->validate([
            'submission_id' => 'nullable|exists:tbl_internship_tasks,id',
            'task_id' => 'nullable|exists:tbl_internship_tasks,id',
            'student_id' => 'nullable|exists:users,id',
        ]);

        $taskId = $request->submission_id ?? $request->task_id;
        if (!$taskId) {
            return response()->json(['status' => false, 'message' => 'Submission ID or Task ID is required.'], 422);
        }

        $submission = null;
        if ($request->filled('student_id')) {
            $submission = InternshipTask::where(function ($q) use ($taskId) {
                    $q->where('id', $taskId)
                      ->orWhere('parent_id', $taskId);
                })
                ->where('student_id', $request->student_id)
                ->first();
        } else {
            $submission = InternshipTask::find($taskId);
        }

        if (!$submission) {
            return response()->json(['status' => false, 'message' => 'Task submission not found.'], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Feedback fetched successfully.',
            'data' => [
                'id' => $submission->id,
                'task_feedback' => $submission->task_feedback,
                'feedback' => $submission->task_feedback,
            ]
        ], 200);
    }

    public function addIndustryMarks(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:tbl_internship,id',
        ]);

        $studentsData = [];

        // Support for multiple students format
        if ($request->has('students') && is_array($request->students)) {
            $studentsData = $request->students;
        } 
        // Backward compatibility for single student format
        else if ($request->has('student_id') && $request->has('marks')) {
            $studentsData = [
                [
                    'student_id' => $request->student_id,
                    'marks' => $request->marks
                ]
            ];
        } else {
            return response()->json(['status' => false, 'message' => 'Please provide students data or student_id with marks.'], 400);
        }

        foreach ($studentsData as $student) {
            if (!isset($student['student_id'])) {
                continue;
            }

            // Save feedback if provided
            if (isset($student['feedback'])) {
                InternshipApplication::where('internship_id', $request->internship_id)
                    ->where('user_id', $student['student_id'])
                    ->update(['company_feedback' => $student['feedback']]);
            }

            if (!isset($student['marks']) || !is_array($student['marks'])) {
                continue;
            }

            foreach ($student['marks'] as $markData) {
                // Ensure max_marks is set, default to 10 if not provided
                $maxMarks = isset($markData['max_marks']) ? $markData['max_marks'] : 10;
                $givenMarks = isset($markData['marks']) ? $markData['marks'] : (isset($markData['mark']) ? $markData['mark'] : 0);

                if ($givenMarks > $maxMarks) {
                    return response()->json(['status' => false, 'message' => "Marks cannot exceed {$maxMarks} for student {$student['student_id']}"], 422);
                }

                InternshipMark::updateOrCreate(
                    [
                        'internship_id' => $request->internship_id,
                        'student_id' => $student['student_id'],
                        'criteria_id' => $markData['criteria_id'] ?? 0,
                    ],
                    [
                        'criteria_name' => $markData['criteria_name'] ?? 'General',
                        'max_marks' => $maxMarks,
                        'marks' => $givenMarks,
                        'status' => 0
                    ]
                );
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Marks saved successfully.'
        ], 200);
    }

    public function completeInternship(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:tbl_internship,id',
            'student_id' => 'nullable|exists:users,id'
        ]);

        $internship = Internship::find($request->internship_id);
        if (!$internship) {
            return response()->json(['status' => false, 'message' => 'Internship not found.'], 404);
        }

        DB::beginTransaction();
        try {
            if ($request->filled('student_id')) {
                $application = InternshipApplication::where('internship_id', $request->internship_id)
                    ->where('user_id', $request->student_id)
                    ->first();

                if ($application) {
                    $application->complete_status = 1; // Completed
                    $application->save();
                }
            } else {
                // Mark all enrolled applications for this internship as complete
                InternshipApplication::where('internship_id', $request->internship_id)
                    ->update(['complete_status' => 1]);
            }

            // Mark marks as submitted/finalized
            InternshipMark::where('internship_id', $internship->id)
                ->when($request->filled('student_id'), fn($q) => $q->where('student_id', $request->student_id))
                ->update(['status' => 1]);

            // Update internship company complete status
            $internship->company_complete_sts = 1;
            if ($internship->internship_type == 2 || $internship->college_complete_sts == 1) {
                $internship->complete_status = 1;
            }
            $internship->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Internship completed successfully.',
                'data' => [
                    'internship_id' => $internship->id,
                    'company_complete_sts' => (int)$internship->company_complete_sts,
                    'complete_status' => (int)$internship->complete_status
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    // ==========================================
    // CANDIDATE SIDE APIs
    // ==========================================

    public function getActiveInternships(Request $request)
    {
        $request->validate([
            'student_id' => 'nullable|exists:users,id'
        ]);

        // Follows web flow: only approved, open, non-expired internships with available openings
        $query = Internship::with(['company', 'jobCategory'])
            ->where('approve_status', 1)
            ->where('complete_status', 0)
            ->whereNull('rejection_reason')
            ->where(function ($q) {
                // Exclude internships whose application deadline has passed
                $q->whereNull('application_deadline')
                  ->orWhere('application_deadline', '>=', now()->toDateString());
            })
            ->withAvailableOpenings(); // ✅ DB-level scope (same as web)

        // Search filter
        if ($request->filled('search')) {
            $query->where('internship_title', 'LIKE', '%' . $request->search . '%');
        }

        $availableInternships = $query->orderBy('created_at', 'desc')->get();

        // Check apply & wishlist status if student_id is provided
        $appliedInternshipIds = [];
        $wishlistInternshipIds = [];
        $studentCollegeInfo = null;

        if ($request->filled('student_id')) {
            $appliedInternshipIds = InternshipApplication::where('user_id', $request->student_id)
                ->pluck('internship_id')
                ->toArray();

            $wishlistInternshipIds = InternshipWishlist::where('user_id', $request->student_id)
                ->pluck('internship_id')
                ->toArray();

            $user = \App\Models\User::find($request->student_id);
            if ($user) {
                $isFilled = !empty($user->university_id) || !empty($user->college_id) || !empty($user->degree_level_id) || !empty($user->degree_id) || !empty($user->major_id) || !empty($user->semester);
                $studentCollegeInfo = [
                    'is_filled' => $isFilled,
                    'university_id' => $user->university_id,
                    'college_id' => $user->college_id,
                    'degree_level_id' => $user->degree_level_id,
                    'degree_id' => $user->degree_id,
                    'major_id' => $user->major_id,
                    'semester' => $user->semester,
                ];
            }
        }

        $availableInternships->transform(function ($internship) use ($appliedInternshipIds, $wishlistInternshipIds) {
            $internship->is_applied = in_array($internship->id, $appliedInternshipIds);
            $internship->is_saved = in_array($internship->id, $wishlistInternshipIds);
            $internship->is_wishlist = $internship->is_saved;
        if (is_array($internship->sub_categories) && count($internship->sub_categories) > 0) {
                $internship->sub_categories_data = \App\Models\Jobsubcategory::whereIn('sub_category_id', $internship->sub_categories)->get();
            } else {
                $internship->sub_categories_data = [];
            }

            return $this->attachPendingCategorySubcategory($internship);
        });

        $response = [
            'status' => true,
            'message' => 'Active internships fetched successfully.',
            'data' => $availableInternships
        ];

        if ($studentCollegeInfo !== null) {
            $response['student_college_info'] = $studentCollegeInfo;
        }

        return response()->json($response, 200);
    }

    public function getInternshipDetailsForCandidate(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:tbl_internship,id',
            'student_id' => 'required|exists:users,id'
        ]);

        $internship = Internship::with(['company', 'jobCategory'])
            ->withCount(['internshipApplications as apply_count'])
            ->find($request->internship_id);

        if (!$internship) {
            return response()->json(['status' => false, 'message' => 'Internship not found'], 404);
        }
        $alreadyApplied = false;
        $isSaved = false;
        $applicationData = null;
        $studentCollegeInfo = null;
        $completeStatus = 0;
        $statusText = 'Not Applied';
        $certificateAvailable = false;
        $totalTasks = 0;
        $completedTasks = 0;
        $pendingTasks = 0;

        if ($request->filled('student_id')) {
            $isSaved = InternshipWishlist::where('user_id', $request->student_id)
                ->where('internship_id', $internship->id)
                ->exists();

            $application = DB::table('tbl_internship_application')
                ->where('internship_id', $internship->id)
                ->where('user_id', $request->student_id)
                ->first();

            if ($application) {
                $alreadyApplied = true;
                $completeStatus = (int) ($application->complete_status ?? 0);
                $statusText = $completeStatus === 1 ? 'Completed' : 'Ongoing';

                $companyCertReady = (int) ($internship->company_complete_sts ?? 0) === 1;
                $collegeCertReady = (int) ($internship->internship_type ?? 0) === 1 && (int) ($internship->college_complete_sts ?? 0) === 1;
                $certificateAvailable = ($completeStatus === 1) || $companyCertReady || $collegeCertReady;

                $totalTasks = InternshipTask::where('internship_id', $internship->id)
                    ->where('student_id', $request->student_id)
                    ->whereNotNull('parent_id')
                    ->count();

                $completedTasks = InternshipTask::where('internship_id', $internship->id)
                    ->where('student_id', $request->student_id)
                    ->whereNotNull('parent_id')
                    ->where('status', 1)
                    ->count();

                $pendingTasks = max(0, $totalTasks - $completedTasks);

                $applicationData = [
                    'id' => $application->id,
                    'user_id' => (int) $application->user_id,
                    'internship_id' => (int) $application->internship_id,
                    'complete_status' => $completeStatus,
                    'status_text' => $statusText,
                    'certificate_available' => $certificateAvailable,
                    'applied_on' => $application->applied_on,
                    'total_tasks' => $totalTasks,
                    'completed_tasks' => $completedTasks,
                    'pending_tasks' => $pendingTasks,
                ];
            }

            $user = \App\Models\User::find($request->student_id);
            if ($user) {
                $isFilled = !empty($user->university_id) || !empty($user->college_id) || !empty($user->degree_level_id) || !empty($user->degree_id) || !empty($user->major_id) || !empty($user->semester);
                $studentCollegeInfo = [
                    'is_filled' => $isFilled,
                    'university_id' => $user->university_id,
                    'college_id' => $user->college_id,
                    'degree_level_id' => $user->degree_level_id,
                    'degree_id' => $user->degree_id,
                    'major_id' => $user->major_id,
                    'semester' => $user->semester,
                ];
            }
        }
        $openingsFull = !$internship->hasAvailableOpenings();

    if (is_array($internship->sub_categories) && count($internship->sub_categories) > 0) {
            $internship->sub_categories_data = \App\Models\Jobsubcategory::whereIn('sub_category_id', $internship->sub_categories)->get();
        } else {
            $internship->sub_categories_data = [];
        }

        $internship = $this->attachPendingCategorySubcategory($internship);

        $responseData = [
            'internship' => $internship,
            'is_applied' => $alreadyApplied,
            'is_saved' => $isSaved,
            'is_wishlist' => $isSaved,
            'complete_status' => $completeStatus,
            'status_text' => $statusText,
            'certificate_available' => $certificateAvailable,
            'openings_full' => $openingsFull
        ];

        if ($applicationData !== null) {
            $responseData['application'] = $applicationData;
            $responseData['total_tasks'] = $totalTasks;
            $responseData['completed_tasks'] = $completedTasks;
            $responseData['pending_tasks'] = $pendingTasks;
        }

        if ($studentCollegeInfo !== null) {
            $responseData['student_college_info'] = $studentCollegeInfo;
        }

        return response()->json([
            'status' => true,
            'message' => 'Internship details fetched successfully.',
            'data' => $responseData
        ], 200);
    }

    public function getEducationDetails()
    {
        $universities = DB::table('tbl_university')->where('status', 1)->get();
        $colleges = DB::table('tbl_college')->where('status', 1)->get();
        $degreeLevels = DB::table('tbl_degree_level')->get();
        $degrees = DB::table('tbl_degree')->get();
        $majors = DB::table('tbl_major')->get();

        return response()->json([
            'status' => true,
            'message' => 'Education details fetched successfully.',
            'data' => [
                'universities' => $universities,
                'colleges' => $colleges,
                'degree_levels' => $degreeLevels,
                'degrees' => $degrees,
                'majors' => $majors,
                'semesters' => [1, 2, 3, 4, 5, 6, 7, 8]
            ]
        ], 200);
    }
    public function submitCollegeInfo(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'university_id' => 'nullable',
            'college_id' => 'nullable',
            'degree_level_id' => 'nullable',
            'degree_id' => 'nullable',
            'major_id' => 'nullable',
            'semester' => 'nullable'
        ]);

        $user = \App\Models\User::find($request->student_id);

        // Normalize inputs
        $universityId = $request->input('university_id');
        $collegeId = $request->input('college_id');
        $degreeLevelId = $request->input('degree_level_id');
        $degreeId = $request->input('degree_id');
        $majorId = $request->input('major_id');

        $universityOther = $request->input('university_other') ? trim($request->input('university_other')) : null;
        $collegeOther = $request->input('college_other') ? trim($request->input('college_other')) : null;
        $degreeLevelOther = $request->input('degree_level_other') ? trim($request->input('degree_level_other')) : null;
        $degreeOther = $request->input('degree_other') ? trim($request->input('degree_other')) : null;
        $majorOther = $request->input('major_other') ? trim($request->input('major_other')) : null;

        DB::beginTransaction();
        try {
            // If university other provided
            if ($universityOther) {
                $university = \App\Models\University::create([
                    'university_name' => $universityOther,
                    'status' => 0,
                ]);
                $universityId = $university->id;
            }

            // If degree level other provided, create it
            if ($degreeLevelOther) {
                $degreeLevel = \App\Models\DegreeLevel::create([
                    'degree_level_name' => $degreeLevelOther,
                    'approve_status' => 0,
                ]);
                $degreeLevelId = $degreeLevel->degree_level_id;
            }

            // If college other provided
            if ($collegeOther) {
                $college = \App\Models\College::create([
                    'college_name' => $collegeOther,
                    'university_id' => is_numeric($universityId) ? $universityId : null,
                    'status' => 0,
                ]);
                $collegeId = $college->id;
            }

            // If degree other provided, create it
            if ($degreeOther) {
                $degree = \App\Models\Degree::create([
                    'degree_level_id' => is_numeric($degreeLevelId) ? $degreeLevelId : null,
                    'degree_name' => $degreeOther,
                ]);
                $degreeId = $degree->degree_id;
            }

            // If major other provided, create it
            if ($majorOther) {
                $major = \App\Models\Major::create([
                    'degree_id' => is_numeric($degreeId) ? $degreeId : null,
                    'major_name' => $majorOther,
                    'approve_status' => 0,
                ]);
                $majorId = $major->major_id;
            }

            // Update user profile fields
            $user->university_id = is_numeric($universityId) ? (int) $universityId : null;
            $user->college_id = is_numeric($collegeId) ? (int) $collegeId : null;
            $user->degree_level_id = is_numeric($degreeLevelId) ? (int) $degreeLevelId : null;
            $user->degree_id = is_numeric($degreeId) ? (int) $degreeId : null;
            $user->major_id = is_numeric($majorId) ? (int) $majorId : null;
            $user->semester = $request->semester ? (int) $request->semester : null;
            
            $user->save();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'College information updated successfully',
                'data' => $user
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to update college information: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createInternshipRazorpayOrder(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|integer|exists:tbl_internship,id',
            'student_id' => 'required|integer|exists:users,id',
            'amount' => 'nullable|numeric',
        ]);

        $gate = $this->internshipApplyEligibility($request->internship_id, $request->student_id);
        if ($gate instanceof \Illuminate\Http\JsonResponse) {
            return $gate;
        }

        $internship = $gate['internship'];
        $user = $gate['user'];
        $paymentCalc = app(\App\Services\InternshipPaymentService::class)->calculatePayment($internship);
        $serverAmount = (float) $paymentCalc['total_amount'];

        if ($serverAmount <= 0) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid payment amount.',
            ], 422);
        }

        $receipt = 'INT-' . $internship->id . '-' . $user->id . '-' . time();
        $order = PaymentHelper::createOrder($serverAmount, $receipt, 'INR', 'live');

        if (is_array($order) && isset($order['error'])) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to create Razorpay order.',
                'error' => $order['error'],
            ], 500);
        }

        $orderId = is_array($order) ? ($order['id'] ?? null) : $order['id'];
        $orderAmount = is_array($order) ? ($order['amount'] ?? (int) round($serverAmount * 100)) : $order['amount'];

        if (!$orderId) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to create Razorpay order.',
            ], 500);
        }

        $userName = trim((string) ($user->name ?? ''));
        if ($userName === '') {
            $userName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
        }

        $contact = (string) ($user->mobile ?? $user->phone ?? $user->contact ?? $user->contact_no ?? '');
        $contact = preg_replace('/\D+/', '', $contact);
        if (strlen($contact) > 10) {
            $contact = substr($contact, -10);
        }

        return response()->json([
            'status' => true,
            'message' => 'Razorpay order created successfully.',
            'data' => [
                'key' => PaymentHelper::getKeyId('live'),
                'order_id' => $orderId,
                'amount' => (int) $orderAmount,
                'currency' => 'INR',
                'name' => 'ZobPot',
                'description' => $internship->internship_title,
                'theme' => [
                    'color' => '#242a62',
                ],
                'prefill' => [
                    'name' => $userName,
                    'email' => $user->email ?? '',
                    'contact' => $contact,
                ],
                'payment' => [
                    'total_amount' => $serverAmount,
                    'registration_fee' => $paymentCalc['registration_fee'],
                    'late_registration_fee' => $paymentCalc['late_registration_fee'],
                    'gst_amount' => $paymentCalc['gst_amount'],
                ],
            ],
        ]);
    }

    public function applyInternship(Request $request)
    {
        $paymentId = $request->razorpay_payment_id ?: $request->payment_id;
        $orderId = $request->razorpay_order_id ?: $request->order_id;
        $signature = $request->razorpay_signature ?: $request->signature;

        $request->merge([
            'razorpay_payment_id' => $paymentId,
            'razorpay_order_id' => $orderId,
            'razorpay_signature' => $signature,
        ]);

        $request->validate([
            'internship_id' => 'required|integer|exists:tbl_internship,id',
            'student_id' => 'required|integer|exists:users,id',
            'razorpay_payment_id' => 'required|string',
        ]);

        if ($orderId && $signature) {
            $verified = PaymentHelper::verifyPayment([
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
            ], 'live');
            if (!$verified) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment verification failed.',
                ], 400);
            }
        } else {
            $payment = PaymentHelper::fetchPayment($paymentId, 'live');
            if (is_array($payment) && isset($payment['error'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment verification failed.',
                    'error' => $payment['error'],
                ], 400);
            }
            $payStatus = strtolower((string) ($payment['status'] ?? ''));
            if (!in_array($payStatus, ['captured', 'authorized'], true)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Payment not successful.',
                ], 400);
            }
        }

        $gate = $this->internshipApplyEligibility($request->internship_id, $request->student_id);
        if ($gate instanceof \Illuminate\Http\JsonResponse) {
            return $gate;
        }

        return $this->persistInternshipApplicationAfterPayment(
            $gate['user'],
            $gate['internship'],
            $gate['existing'],
            $paymentId
        );
    }

    private function internshipApplyEligibility($internshipId, $studentId)
    {
        $internship = Internship::find($internshipId);

        if (!$internship) {
            return response()->json(['status' => false, 'message' => 'Internship not found.'], 404);
        }

        if ((int) $internship->approve_status !== 1) {
            return response()->json(['status' => false, 'message' => 'Internship is not available.'], 403);
        }

        if ((int) $internship->complete_status === 1) {
            return response()->json(['status' => false, 'message' => 'Internship is closed.'], 409);
        }

        $user = User::find($studentId);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Student not found.'], 404);
        }

        if (!PlanPricing::employeeCanApply($user, 'internship')) {
            return response()->json([
                'status' => false,
                'message' => 'Your current plan does not include Internship service. Please upgrade your plan to apply.',
            ], 403);
        }

        if (!$user->college_id || !$user->degree_id) {
            return response()->json([
                'status' => false,
                'message' => 'College information is required. Please submit college info first.',
            ], 422);
        }

        $existing = InternshipApplication::where('user_id', $studentId)
            ->where('internship_id', $internship->id)
            ->first();

        if ($existing) {
            $existingPayment = InternshipPayment::where(function ($q) use ($existing, $studentId, $internship) {
                $q->where('application_id', $existing->id)
                    ->orWhere(function ($q2) use ($studentId, $internship) {
                        $q2->where('user_id', $studentId)
                            ->where('internship_id', $internship->id);
                    });
            })->first();

            if ($existingPayment) {
                return response()->json(['status' => false, 'message' => 'You have already applied for this internship.'], 409);
            }
        } else {
            $limitCheck = PlanPricing::checkServiceLimit($user, 'internship', 'apply');
            if (!$limitCheck['allowed']) {
                return response()->json([
                    'status' => false,
                    'message' => $limitCheck['message'],
                    'limit' => $limitCheck['limit'],
                    'used' => $limitCheck['used'],
                ], 403);
            }

            $appliedCount = InternshipApplication::where('internship_id', $internship->id)->count();
            if ($internship->openings > 0 && $appliedCount >= (int) $internship->openings) {
                return response()->json(['status' => false, 'message' => 'This internship has no openings left.'], 409);
            }
        }

        return [
            'user' => $user,
            'internship' => $internship,
            'existing' => $existing,
        ];
    }

    private function persistInternshipApplicationAfterPayment($user, $internship, $existing, $transactionId)
    {
        $userId = $user->id;
        $paymentCalc = app(\App\Services\InternshipPaymentService::class)->calculatePayment($internship);
        $txn = $transactionId ?: $this->generatePaymentTransactionId();

        try {
            DB::beginTransaction();

            if ($existing) {
                $application = $existing;
            } else {
                $application = InternshipApplication::create([
                    'user_id' => $userId,
                    'internship_id' => $internship->id,
                    'company_id' => $internship->company_id ?? null,
                    'college_id' => $user->college_id,
                    'degree_id' => $user->degree_id,
                    'complete_status' => 0,
                    'applied_on' => now(),
                    'company_feedback' => null,
                    'college_feedback' => null,
                ]);
                PlanPricing::incrementServiceUsage($user, 'internship');
            }

            $payment = InternshipPayment::createFromCalculation([
                'application_id' => $application->id,
                'user_id' => $userId,
                'internship_id' => $internship->id,
                'payment_mode' => 'online',
                'payment_status' => 1,
                'paid_on' => now(),
            ], $paymentCalc, $txn);

            try {
                $this->duplicateTasksForStudent($internship->id, $userId);
            } catch (\Throwable $e) {
                \Log::error('Failed to duplicate tasks for student: ' . $e->getMessage());
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Successfully applied to the internship.',
                'data' => [
                    'application_id' => $application->id,
                    'payment_id' => $payment->id ?? null,
                    'transaction_id' => $txn,
                    'application' => $application,
                ],
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Failed to create internship payment: ' . $e->getMessage(), [
                'user_id' => $userId,
                'internship_id' => $internship->id,
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => false,
                'message' => 'Unable to create payment. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function generatePaymentTransactionId()
    {
        $rand = mt_rand(100000, 999999);
        return 'TXN' . time() . $rand;
    }

    private function duplicateTasksForStudent($internshipId, $studentId)
    {
        $masterTasks = \App\Models\InternshipTask::where('internship_id', $internshipId)
            ->whereNull('parent_id')
            ->get();

        foreach ($masterTasks as $task) {
            $exists = \App\Models\InternshipTask::where('parent_id', $task->id)
                ->where('student_id', $studentId)
                ->exists();

            if ($exists) {
                continue;
            }

            \App\Models\InternshipTask::create([
                'parent_id' => $task->id,
                'student_id' => $studentId,
                'internship_id' => $task->internship_id,
                'date_time' => $task->date_time,
                'day' => $task->day,
                'module_title' => $task->module_title,
                'module_description' => $task->module_description,
                'upload_file' => $task->upload_file,
                'last_submission_date' => $task->last_submission_date,
                'online_link' => $task->online_link,
                'is_final_assignment' => $task->is_final_assignment,
                'status' => 0,
                'student_submit_file' => null,
                'student_submit_description' => null,
                'student_submit_project_link' => null,
                'submit_on' => null,
            ]);
        }
    }

    public function getAssignedTasks(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:tbl_internship,id',
            'student_id' => 'required|exists:users,id'
        ]);

        // Auto-generate missing sub-tasks for the candidate (fixes older applications too)
        $this->duplicateTasksForStudent($request->internship_id, $request->student_id);

        $tasks = InternshipTask::where('internship_id', $request->internship_id)
            ->where('student_id', $request->student_id)
            ->whereNotNull('parent_id') // It's an assigned sub-task for student
            ->orderBy('date_time', 'asc')
            ->get();

        $formattedTasks = $tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'parent_id' => $task->parent_id,
                'internship_id' => $task->internship_id,
                'student_id' => $task->student_id,
                'module_title' => $task->module_title,
                'module_description' => $task->module_description,
                'date_time' => $task->date_time,
                'day' => $task->day,
                'last_submission_date' => $task->last_submission_date,
                'online_link' => $task->online_link,
                'is_final_assignment' => (bool)$task->is_final_assignment,
                'upload_file' => $task->upload_file,
                'upload_file_url' => $task->upload_file ? url('uploads/internship_tasks/' . $task->upload_file) : null,
                'student_submit_file' => $task->student_submit_file,
                'student_submit_file_url' => $task->student_submit_file ? url('uploads/internship_tasks_submit/' . $task->student_submit_file) : null,
                'student_submit_description' => $task->student_submit_description,
                'student_submit_project_link' => $task->student_submit_project_link,
                'submit_on' => $task->submit_on,
                'status' => (int)$task->status,
                'status_text' => $task->status == 1 ? 'Submitted' : 'Pending',
                'task_feedback' => $task->task_feedback,
                'created_at' => $task->created_at,
                'updated_at' => $task->updated_at,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Assigned tasks fetched successfully.',
            'data' => $formattedTasks
        ], 200);
    }

    public function submitTask(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tbl_internship_tasks,id',
            'student_id' => 'required|exists:users,id',
            'task_notes' => 'nullable|string',
            'student_submit_description' => 'nullable|string',
            'project_link' => 'nullable|url',
            'student_submit_project_link' => 'nullable|url',
            'student_submit_file' => 'nullable|file|max:5120',
            'task_file' => 'nullable|file|max:5120',
            'upload_file' => 'nullable|file|max:5120',
            'document_file' => 'nullable|file|max:5120',
            'file' => 'nullable|file|max:5120'
        ]);

        $task = InternshipTask::where(function ($q) use ($request) {
                $q->where('id', $request->task_id)
                  ->orWhere('parent_id', $request->task_id);
            })
            ->where('student_id', $request->student_id)
            ->first();

        // If not found, attempt on-demand duplication in case tasks weren't duplicated yet
        if (!$task) {
            $inputTask = InternshipTask::find($request->task_id);
            if ($inputTask) {
                $internshipId = $inputTask->internship_id;
                $this->duplicateTasksForStudent($internshipId, $request->student_id);

                $task = InternshipTask::where(function ($q) use ($request) {
                        $q->where('id', $request->task_id)
                          ->orWhere('parent_id', $request->task_id);
                    })
                    ->where('student_id', $request->student_id)
                    ->first();
            }
        }

        if (!$task) {
            return response()->json(['status' => false, 'message' => 'Task not found or not assigned to you.'], 404);
        }

        $file = $request->file('student_submit_file') 
            ?? $request->file('task_file') 
            ?? $request->file('upload_file') 
            ?? $request->file('document_file') 
            ?? $request->file('file');

        if ($file) {
            if ($task->student_submit_file && file_exists(public_path('uploads/internship_tasks_submit/' . $task->student_submit_file))) {
                @unlink(public_path('uploads/internship_tasks_submit/' . $task->student_submit_file));
            }

            $ext = $file->getClientOriginalExtension() ?: 'pdf';
            $filename = 'student_task_' . $task->id . '_' . time() . '.' . $ext;
            $destination = public_path('uploads/internship_tasks_submit');
            if (!\File::exists($destination)) {
                \File::makeDirectory($destination, 0755, true);
            }
            $file->move($destination, $filename);

            $task->student_submit_file = $filename;
        }

        $task->student_submit_description = $request->task_notes ?? $request->student_submit_description ?? $task->student_submit_description;
        $task->student_submit_project_link = $request->project_link ?? $request->student_submit_project_link ?? $task->student_submit_project_link;
        $task->submit_on = now();
        $task->status = 1; // Mark completed
        $task->save();

        $formatted = [
            'id' => $task->id,
            'parent_id' => $task->parent_id,
            'internship_id' => $task->internship_id,
            'student_id' => $task->student_id,
            'module_title' => $task->module_title,
            'module_description' => $task->module_description,
            'date_time' => $task->date_time,
            'day' => $task->day,
            'last_submission_date' => $task->last_submission_date,
            'online_link' => $task->online_link,
            'is_final_assignment' => (bool)$task->is_final_assignment,
            'upload_file' => $task->upload_file,
            'upload_file_url' => $task->upload_file ? url('uploads/internship_tasks/' . $task->upload_file) : null,
            'student_submit_file' => $task->student_submit_file,
            'student_submit_file_url' => $task->student_submit_file ? url('uploads/internship_tasks_submit/' . $task->student_submit_file) : null,
            'student_submit_description' => $task->student_submit_description,
            'student_submit_project_link' => $task->student_submit_project_link,
            'submit_on' => $task->submit_on,
            'status' => (int)$task->status,
            'status_text' => 'Submitted',
            'task_feedback' => $task->task_feedback,
            'created_at' => $task->created_at,
            'updated_at' => $task->updated_at,
        ];

        return response()->json([
            'status' => true,
            'message' => 'Task submitted successfully.',
            'data' => $formatted
        ], 200);
    }

    public function viewMySubmittedTask(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tbl_internship_tasks,id',
            'student_id' => 'required|exists:users,id'
        ]);

        $task = InternshipTask::where(function ($q) use ($request) {
                $q->where('id', $request->task_id)
                  ->orWhere('parent_id', $request->task_id);
            })
            ->where('student_id', $request->student_id)
            ->first();

        if (!$task) {
            return response()->json(['status' => false, 'message' => 'Task not found.'], 404);
        }

        $formatted = [
            'id' => $task->id,
            'parent_id' => $task->parent_id,
            'internship_id' => $task->internship_id,
            'student_id' => $task->student_id,
            'module_title' => $task->module_title,
            'module_description' => $task->module_description,
            'date_time' => $task->date_time,
            'day' => $task->day,
            'last_submission_date' => $task->last_submission_date,
            'online_link' => $task->online_link,
            'is_final_assignment' => (bool)$task->is_final_assignment,
            'upload_file' => $task->upload_file,
            'upload_file_url' => $task->upload_file ? url('uploads/internship_tasks/' . $task->upload_file) : null,
            'student_submit_file' => $task->student_submit_file,
            'student_submit_file_url' => $task->student_submit_file ? url('uploads/internship_tasks_submit/' . $task->student_submit_file) : null,
            'student_submit_description' => $task->student_submit_description,
            'student_submit_project_link' => $task->student_submit_project_link,
            'submit_on' => $task->submit_on,
            'status' => (int)$task->status,
            'status_text' => $task->status == 1 ? 'Submitted' : 'Pending',
            'task_feedback' => $task->task_feedback,
            'created_at' => $task->created_at,
            'updated_at' => $task->updated_at,
        ];

        return response()->json([
            'status' => true,
            'message' => 'Submitted task details fetched successfully.',
            'data' => $formatted
        ], 200);
    }

    public function getMyAppliedInternships(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id'
        ]);

        $applications = InternshipApplication::whereHas('internship')
            ->with(['internship.company', 'internship.jobCategory'])
            ->where('user_id', $request->student_id)
            ->orderBy('applied_on', 'desc')
            ->get();

        $applications->transform(function ($application) use ($request) {
            $internship = $application->internship;
            $isComplete = (int) $application->complete_status === 1;

            // Certificate availability logic (matches Web)
            $companyCertReady = (int) (optional($internship)->company_complete_sts ?? 0) === 1 || $isComplete;
            $collegeCertReady = (int) (optional($internship)->internship_type ?? 0) === 1 && (int) (optional($internship)->college_complete_sts ?? 0) === 1;
            $certificateAvailable = $companyCertReady || $collegeCertReady;

            // Task stats for this student
            $totalTasks = InternshipTask::where('internship_id', $application->internship_id)
                ->where('student_id', $request->student_id)
                ->whereNotNull('parent_id')
                ->count();

            $completedTasks = InternshipTask::where('internship_id', $application->internship_id)
                ->where('student_id', $request->student_id)
                ->whereNotNull('parent_id')
                ->where('status', 1)
                ->count();

            $application->complete_status = (int) $application->complete_status;
            $application->status_text = $isComplete ? 'Completed' : 'Ongoing';
            $application->certificate_available = $certificateAvailable;
            $application->company_certificate_available = $companyCertReady;
            $application->college_certificate_available = $collegeCertReady;
            $application->company_certificate_download_url = $companyCertReady ? url('/api/candidate/internship/certificate/pdf/' . $application->id . '/company') : null;
            $application->company_certificate_preview_url = $companyCertReady ? url('/api/candidate/internship/certificate/preview/' . $application->id . '/company') : null;
            $application->college_certificate_download_url = $collegeCertReady ? url('/api/candidate/internship/certificate/pdf/' . $application->id . '/college') : null;
            $application->college_certificate_preview_url = $collegeCertReady ? url('/api/candidate/internship/certificate/preview/' . $application->id . '/college') : null;
            $application->total_tasks = $totalTasks;
            $application->completed_tasks = $completedTasks;
            $application->pending_tasks = max(0, $totalTasks - $completedTasks);

            if ($internship) {
                $internship->is_applied = true;
                $internship->company_complete_sts = (int) ($internship->company_complete_sts ?? 0);
                $internship->college_complete_sts = (int) ($internship->college_complete_sts ?? 0);
        if (is_array($internship->sub_categories) && count($internship->sub_categories) > 0) {
                    $internship->sub_categories_data = \App\Models\Jobsubcategory::whereIn('sub_category_id', $internship->sub_categories)->get();
                } else {
                    $internship->sub_categories_data = [];
                }
                $internship = $this->attachPendingCategorySubcategory($internship);
            }
            return $application;
        });

        return response()->json([
            'status' => true,
            'message' => 'Applied internships fetched successfully.',
            'data' => $applications
        ], 200);
    }

    public function getAppliedInternshipDetails(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:tbl_internship_application,id',
            'student_id'     => 'required|exists:users,id'
        ]);

        $application = InternshipApplication::whereHas('internship')
            ->with(['internship.company', 'internship.jobCategory'])
            ->where('id', $request->application_id)
            ->where('user_id', $request->student_id)
            ->first();

        if (!$application) {
            return response()->json(['status' => false, 'message' => 'Application not found or internship deleted'], 404);
        }

        $internship  = $application->internship;
        $company     = optional($internship)->company;
        $category    = optional($internship)->jobCategory;

        $completeStatus     = (int) ($application->complete_status ?? 0);
        $isComplete         = $completeStatus === 1;

        $companyCertReady   = (int) (optional($internship)->company_complete_sts ?? 0) === 1 || $isComplete;
        $collegeCertReady   = (int) (optional($internship)->internship_type ?? 0) === 1
                              && (int) (optional($internship)->college_complete_sts ?? 0) === 1;
        $certificateAvailable = $companyCertReady || $collegeCertReady;

        $totalTasks = InternshipTask::where('internship_id', $application->internship_id)
            ->where('student_id', $request->student_id)
            ->whereNotNull('parent_id')
            ->count();

        $completedTasks = InternshipTask::where('internship_id', $application->internship_id)
            ->where('student_id', $request->student_id)
            ->whereNotNull('parent_id')
            ->where('status', 1)
            ->count();

        $data = [
            // --- Application fields ---
            'id'                            => $application->id,
            'user_id'                       => $application->user_id,
            'internship_id'                 => $application->internship_id,
            'company_id'                    => $application->company_id,
            'college_id'                    => $application->college_id,
            'degree_id'                     => $application->degree_id,
            'applied_on'                    => optional($application->applied_on)->format('Y-m-d H:i:s'),
            'company_feedback'              => $application->company_feedback,
            'college_feedback'              => $application->college_feedback,
            'assigned_staff_id'             => $application->assigned_staff_id,

            // --- Status (clean, single) ---
            'complete_status'               => $completeStatus,
            'status_text'                   => $isComplete ? 'Completed' : 'Ongoing',

            // --- Certificate ---
            'certificate_available'         => $certificateAvailable,
            'company_certificate_available' => $companyCertReady,
            'college_certificate_available' => $collegeCertReady,
            'company_certificate_download_url' => $companyCertReady
                ? url('/api/candidate/internship/certificate/pdf/' . $application->id . '/company') : null,
            'company_certificate_preview_url'  => $companyCertReady
                ? url('/api/candidate/internship/certificate/preview/' . $application->id . '/company') : null,
            'college_certificate_download_url' => $collegeCertReady
                ? url('/api/candidate/internship/certificate/pdf/' . $application->id . '/college') : null,
            'college_certificate_preview_url'  => $collegeCertReady
                ? url('/api/candidate/internship/certificate/preview/' . $application->id . '/college') : null,

            // --- Tasks ---
            'total_tasks'                   => $totalTasks,
            'completed_tasks'               => $completedTasks,
            'pending_tasks'                 => max(0, $totalTasks - $completedTasks),
        ];

        if ($internship) {
            $internship = $this->attachPendingCategorySubcategory($internship);
            $data['internship'] = [
                'id'                       => $internship->id,
                'internship_title'         => $internship->internship_title,
                'slug'                     => $internship->slug,
                'internship_type'          => (int) ($internship->internship_type ?? 0),
                'category'                 => $internship->category,
                'pending_category'         => $internship->pending_category,
                'sub_categories'           => $internship->sub_categories,
                'sub_categories_data'      => (is_array($internship->sub_categories) && count($internship->sub_categories) > 0) ? \App\Models\Jobsubcategory::whereIn('sub_category_id', $internship->sub_categories)->get() : [],
                'pending_sub_categories'   => $internship->pending_sub_categories,
                'company_id'               => $internship->company_id,
                'company_website'          => $internship->company_website,
                'mode'                     => $internship->mode,
                'location'                 => $internship->location,
                'stipend'                  => $internship->stipend,
                'openings'                 => $internship->openings,
                'duration'                 => $internship->duration,
                'total_weeks'              => $internship->total_weeks,
                'total_hours'              => $internship->total_hours,
                'start_date'               => optional($internship->start_date)->format('Y-m-d'),
                'end_date'                 => optional($internship->end_date)->format('Y-m-d'),
                'application_deadline'     => optional($internship->application_deadline)->format('Y-m-d'),
                'last_registration_date'   => optional($internship->last_registration_date)->format('Y-m-d'),
                'batch_days'               => $internship->batch_days,
                'skills'                   => $internship->skills,
                'eligibility_criteria'     => $internship->eligibility_criteria,
                'internship_description'   => $internship->internship_description ?? $internship->description,
                'module_brief_description' => $internship->module_brief_description,
                'internship_objective'     => $internship->internship_objective,
                'internship_outcome'       => $internship->internship_outcome,
                'general_instructions'     => $internship->general_instructions,
                'perks'                    => $internship->perks,
                'registration_fees'        => $internship->registration_fees,
                'late_registration_fee'    => $internship->late_registration_fee,
                'gst_percentage'           => $internship->gst_percentage,
                'gst_amount'               => $internship->gst_amount,
                'final_amount'             => $internship->final_amount,
                'manage_task_status'       => (bool) ($internship->manage_task_status ?? false),
                'complete_status'          => (int) ($internship->complete_status ?? 0),
                'college_complete_sts'     => (int) ($internship->college_complete_sts ?? 0),
                'college_pending_flag'     => (int) ($internship->college_pending_flag ?? 0),
                'company_complete_sts'     => (int) ($internship->company_complete_sts ?? 0),
                'approve_status'           => (int) ($internship->approve_status ?? 0),
                'is_applied'               => true,
                'company' => $company ? [
                    'id'          => $company->id,
                    'name'        => $company->name,
                    'profile_img' => $company->profile_img
                        ? asset('uploads/profile/' . $company->profile_img) : null,
                ] : null,
                'category_details' => $category ? [
                    'id'   => $category->id ?? $category->category_id ?? null,
                    'name' => $category->cat_name ?? $category->category_nm ?? $category->name ?? null,
                ] : null,
                'job_category' => $category ? [
                    'category_id'     => $category->category_id ?? $category->id ?? null,
                    'preference_type' => $category->preference_type ?? null,
                    'category_nm'     => $category->category_nm ?? $category->cat_name ?? $category->name ?? null,
                    'image'           => $category->image ?? null,
                ] : null,
            ];
        } else {
            $data['internship'] = null;
        }

        return response()->json([
            'status'  => true,
            'message' => 'Applied internship details fetched successfully.',
            'data'    => $data,
        ], 200);
    }

    public function downloadCertificate(Request $request)
    {
        $request->validate([
            'application_id' => 'nullable|exists:tbl_internship_application,id',
            'internship_id' => 'nullable|exists:tbl_internship,id',
            'student_id' => 'nullable|exists:users,id',
            'type' => 'nullable|in:company,college'
        ]);

        $applicationId = $request->application_id;
        if (!$applicationId && $request->internship_id && $request->student_id) {
            $app = InternshipApplication::where('internship_id', $request->internship_id)
                ->where('user_id', $request->student_id)
                ->first();
            $applicationId = $app ? $app->id : null;
        }

        if (!$applicationId) {
            return response()->json(['status' => false, 'message' => 'Application ID or internship_id and student_id is required.'], 422);
        }

        $application = InternshipApplication::with(['internship.company', 'user'])->find($applicationId);

        if (!$application) {
            return response()->json(['status' => false, 'message' => 'Application not found'], 404);
        }

        $internship = $application->internship;
        $studentName = optional($application->user)->name ?? 'Student';
        $internshipTitle = optional($internship)->internship_title ?? 'Internship';

        $companyCertificateAvailable = (int) (optional($internship)->company_complete_sts ?? 0) === 1 || (int) ($application->complete_status ?? 0) === 1;
        $collegeCertificateAvailable = (int) (optional($internship)->internship_type ?? 0) === 1 && (int) (optional($internship)->college_complete_sts ?? 0) === 1;

        $companyCertNo = sprintf('ZP-COMP-%s-%s', $internship ? $internship->id : 0, $application->id);
        $companyFileName = 'COMPANY_Certificate_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentName) . '_' . $companyCertNo . '.pdf';
        $companyDownloadUrl = $companyCertificateAvailable ? url('/api/candidate/internship/certificate/pdf/' . $application->id . '/company') : null;
        $companyPreviewUrl = $companyCertificateAvailable ? url('/api/candidate/internship/certificate/preview/' . $application->id . '/company') : null;

        $collegeCertNo = sprintf('ZP-COLL-%s-%s', $internship ? $internship->id : 0, $application->id);
        $collegeFileName = 'COLLEGE_Certificate_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentName) . '_' . $collegeCertNo . '.pdf';
        $collegeDownloadUrl = $collegeCertificateAvailable ? url('/api/candidate/internship/certificate/pdf/' . $application->id . '/college') : null;
        $collegePreviewUrl = $collegeCertificateAvailable ? url('/api/candidate/internship/certificate/preview/' . $application->id . '/college') : null;

        $type = strtolower($request->input('type', ''));
        if (!in_array($type, ['company', 'college'], true)) {
            $type = ($collegeCertificateAvailable && !$companyCertificateAvailable) ? 'college' : 'company';
        }

        $activeAvailable = $type === 'college' ? $collegeCertificateAvailable : $companyCertificateAvailable;
        $activeCertNo = $type === 'college' ? $collegeCertNo : $companyCertNo;
        $activeFileName = $type === 'college' ? $collegeFileName : $companyFileName;
        $activeDownloadUrl = $activeAvailable ? ($type === 'college' ? $collegeDownloadUrl : $companyDownloadUrl) : null;
        $activePreviewUrl = $activeAvailable ? ($type === 'college' ? $collegePreviewUrl : $companyPreviewUrl) : null;

        $message = ($companyCertificateAvailable || $collegeCertificateAvailable)
            ? 'Certificate download link generated successfully.'
            : 'Certificate is not available yet.';

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => [
                'download_url' => $activeDownloadUrl,
                'preview_url' => $activePreviewUrl,
                'file_name' => $activeFileName,
                'certificate_no' => $activeCertNo,
                'student_name' => $studentName,
                'internship_title' => $internshipTitle,
                'certificate_type' => $type,
                'issue_date' => now()->format('d F Y'),
                'company_certificate_available' => $companyCertificateAvailable,
                'college_certificate_available' => $collegeCertificateAvailable,
                'certificates' => [
                    'company' => [
                        'type' => 'company',
                        'title' => 'Industry / Company Certificate',
                        'is_available' => $companyCertificateAvailable,
                        'download_url' => $companyDownloadUrl,
                        'preview_url' => $companyPreviewUrl,
                        'file_name' => $companyFileName,
                        'certificate_no' => $companyCertNo,
                    ],
                    'college' => [
                        'type' => 'college',
                        'title' => 'College / Academic Certificate',
                        'is_available' => $collegeCertificateAvailable,
                        'download_url' => $collegeDownloadUrl,
                        'preview_url' => $collegePreviewUrl,
                        'file_name' => $collegeFileName,
                        'certificate_no' => $collegeCertNo,
                    ]
                ]
            ]
        ], 200);
    }

    public function downloadCertificatePdf($applicationId, $type = 'company')
    {
        $type = strtolower($type ?: 'company');
        if (!in_array($type, ['company', 'college'], true)) {
            $type = 'company';
        }

        $data = $this->buildCertificateData((int) $applicationId, $type);
        $fileName = strtoupper($type) . '_Certificate_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $data['student_name']) . '_' . $data['certificate_no'] . '.pdf';

        if (class_exists('\Dompdf\Dompdf')) {
            $html = view('admin.internship.certificate-pdf', $data)->render();

            $options = new \Dompdf\Options();
            $options->set('isRemoteEnabled', true);
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isFontSubsettingEnabled', true);
            $options->set('defaultFont', 'DejaVu Serif');
            $options->set('dpi', 72);
            $options->setChroot(public_path());

            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($html, 'UTF-8');
            $dompdf->setPaper('a4', 'landscape');
            $dompdf->setBasePath(public_path());
            $dompdf->render();
            $output = $dompdf->output();

            return response()->streamDownload(function () use ($output) {
                echo $output;
            }, $fileName, [
                'Content-Type' => 'application/pdf',
            ]);
        }

        return view('admin.internship.certificate-pdf', $data);
    }

    public function previewCertificatePdf($applicationId, $type = 'company')
    {
        $type = strtolower($type ?: 'company');
        if (!in_array($type, ['company', 'college'], true)) {
            $type = 'company';
        }

        $data = $this->buildCertificateData((int) $applicationId, $type);
        return view('candidate.certificate-preview', $data);
    }

    protected function buildCertificateData(int $applicationId, string $type): array
    {
        $type = strtolower($type);
        if (!in_array($type, ['company', 'college'], true)) {
            $type = 'company';
        }

        $application = InternshipApplication::with([
            'user.college.university',
            'user.degree',
            'internship.company',
        ])->findOrFail($applicationId);

        $internship = $application->internship;
        if (!$internship) {
            abort(404, 'Internship not found.');
        }

        $student = $application->user;
        $company = $internship->company;

        $college = null;
        if (!empty($application->college_id)) {
            $college = College::with('university')->find($application->college_id);
        }
        if (!$college && $student && $student->college) {
            $college = $student->college;
            if (!$college->relationLoaded('university')) {
                $college->load('university');
            }
        }

        $degree = null;
        if (!empty($application->degree_id)) {
            $degree = Degree::find($application->degree_id);
        }
        if (!$degree && $student && $student->degree) {
            $degree = $student->degree;
        }

        $university = $college && $college->university ? $college->university : null;
        $setting = Setting::first();

        $prefix = $type === 'company' ? 'ZP-COMP' : 'ZP-COLL';
        $certificateNo = sprintf('%s-%s-%s', $prefix, $internship->id, $application->id);

        $modeLabel = 'N/A';
        if (!empty($internship->mode)) {
            $modeMap = [1 => 'Online', 2 => 'Offline', 3 => 'Hybrid'];
            $rawMode = $internship->mode;
            $modeLabel = $modeMap[(int) $rawMode] ?? ucfirst((string) $rawMode);
        }

        $startDate = $internship->start_date ? $internship->start_date->format('d M Y') : 'N/A';
        $endDate = $internship->end_date ? $internship->end_date->format('d M Y') : 'N/A';
        $issueDate = now()->format('d F Y');

        $durationText = $internship->duration ?: 'N/A';
        if ($internship->start_date && $internship->end_date) {
            $durationText .= ' (' . $startDate . ' – ' . $endDate . ')';
        }

        $platformLogoPath = null;
        $platformLogoUrl = asset('assets/imgs/logo/logo1.png');
        $defaultPlatformRel = 'assets/imgs/logo/logo1.png';
        if (file_exists(public_path($defaultPlatformRel))) {
            $platformLogoPath = public_path($defaultPlatformRel);
        }
        if ($setting && !empty($setting->header_logo)) {
            $rel = 'uploads/logo_img/' . $setting->header_logo;
            if (file_exists(public_path($rel))) {
                $platformLogoPath = public_path($rel);
                $platformLogoUrl = asset($rel);
            }
        }

        $companyLogoPath = null;
        $companyLogoUrl = null;
        $companyLogoField = $company->certificate_logo ?? $company->profile_img ?? null;
        if ($company && !empty($companyLogoField)) {
            $rel = 'uploads/profile/' . $companyLogoField;
            if (file_exists(public_path($rel))) {
                $companyLogoPath = public_path($rel);
                $companyLogoUrl = asset($rel);
            }
        }

        $collegeLogoPath = null;
        $collegeLogoUrl = null;
        if ($college) {
            if (!empty($college->certificate_logo)) {
                $rel = 'uploads/college/' . $college->certificate_logo;
                if (file_exists(public_path($rel))) {
                    $collegeLogoPath = public_path($rel);
                    $collegeLogoUrl = asset($rel);
                }
            }
            if (!$collegeLogoPath && !empty($college->logo)) {
                $rel = ltrim($college->logo, '/');
                if (file_exists(public_path($rel))) {
                    $collegeLogoPath = public_path($rel);
                    $collegeLogoUrl = asset($rel);
                }
            }
        }

        $collegeSignaturePath = null;
        $collegeSignatureUrl = null;
        if ($college && !empty($college->college_signature)) {
            $rel = 'uploads/college/' . $college->college_signature;
            if (file_exists(public_path($rel))) {
                $collegeSignaturePath = public_path($rel);
                $collegeSignatureUrl = asset($rel);
            }
        }

        $directorSignaturePath = null;
        $directorSignatureUrl = null;
        if ($setting && !empty($setting->director_signature)) {
            $rel = 'uploads/logo_img/' . $setting->director_signature;
            if (file_exists(public_path($rel))) {
                $directorSignaturePath = public_path($rel);
                $directorSignatureUrl = asset($rel);
            }
        }

        $roundSealPath = null;
        $roundSealUrl = null;
        if ($setting && !empty($setting->round_seal)) {
            $rel = 'uploads/logo_img/' . $setting->round_seal;
            if (file_exists(public_path($rel))) {
                $roundSealPath = public_path($rel);
                $roundSealUrl = asset($rel);
            }
        }

        $companySignaturePath = null;
        $companySignatureUrl = null;
        if ($company && !empty($company->company_signature)) {
            $rel = 'uploads/profile/' . $company->company_signature;
            if (file_exists(public_path($rel))) {
                $companySignaturePath = public_path($rel);
                $companySignatureUrl = asset($rel);
            }
        }

        $issuerName = $type === 'company'
            ? ($company->name ?? 'Company')
            : ($college->college_name ?? 'College');

        $issuedByLabel = $type === 'company' ? 'Industry / Company' : 'College';

        return [
            'type' => $type,
            'certSettings' => CertificateSetting::forType($type),
            'certificate_no' => $certificateNo,
            'issue_date' => $issueDate,
            'student_name' => $student->name ?? 'N/A',
            'student_email' => $student->email ?? null,
            'degree_name' => $degree->degree_name ?? null,
            'semester' => $student->semester ?? null,
            'college_name' => $college->college_name ?? 'N/A',
            'university_name' => $university->university_name ?? 'N/A',
            'internship_title' => $internship->internship_title ?? 'N/A',
            'company_name' => $company->name ?? 'N/A',
            'duration' => $internship->duration ?: 'N/A',
            'duration_text' => $durationText,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'mode' => $modeLabel,
            'location' => $internship->location ?: 'N/A',
            'total_weeks' => $internship->total_weeks,
            'total_hours' => $internship->total_hours,
            'issuer_name' => $issuerName,
            'issued_by_label' => $issuedByLabel,
            'platform_name' => $setting->web_title ?? 'ZobPot',
            'platform_logo_url' => $platformLogoUrl,
            'platform_logo_path' => $platformLogoPath,
            'platform_logo_src' => $this->toDompdfImageSrc($platformLogoPath, 120),
            'company_logo_url' => $companyLogoUrl,
            'company_logo_path' => $companyLogoPath,
            'company_logo_src' => $this->toDompdfImageSrc($companyLogoPath, 120),
            'college_logo_url' => $collegeLogoUrl,
            'college_logo_path' => $collegeLogoPath,
            'college_logo_src' => $this->toDompdfImageSrc($collegeLogoPath, 120),
            'college_signature_url' => $collegeSignatureUrl,
            'college_signature_path' => $collegeSignaturePath,
            'college_signature_src' => $this->toDompdfImageSrc($collegeSignaturePath),
            'director_signature_url' => $directorSignatureUrl,
            'director_signature_path' => $directorSignaturePath,
            'director_signature_src' => $this->toDompdfImageSrc($directorSignaturePath),
            'round_seal_url' => $roundSealUrl,
            'round_seal_path' => $roundSealPath,
            'round_seal_src' => $this->toDompdfImageSrc($roundSealPath),
            'company_signature_url' => $companySignatureUrl,
            'company_signature_path' => $companySignaturePath,
            'company_signature_src' => $this->toDompdfImageSrc($companySignaturePath),
            'application' => $application,
            'internship' => $internship,
            'download_url' => url('/api/candidate/internship/certificate/pdf/' . $application->id . '/' . $type),
            'preview_url' => url('/api/candidate/internship/certificate/preview/' . $application->id . '/' . $type),
            'back_url' => url('/'),
            'is_college_login' => false,
        ];
    }

    protected function toDompdfImageSrc(?string $absolutePath, int $maxWidth = 400): ?string
    {
        if (empty($absolutePath) || !is_file($absolutePath) || !is_readable($absolutePath)) {
            return null;
        }

        $ext = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
        $mimeMap = [
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'bmp' => 'image/bmp',
        ];

        $mime = $mimeMap[$ext] ?? null;
        if (!$mime && function_exists('mime_content_type')) {
            $detected = @mime_content_type($absolutePath);
            if (is_string($detected) && str_starts_with($detected, 'image/')) {
                $mime = $detected;
            }
        }
        $mime = $mime ?: 'image/png';
        if ($mime === 'image/jpg') {
            $mime = 'image/jpeg';
        }

        if (extension_loaded('gd')) {
            $normalized = $this->normalizeImageForDompdf($absolutePath, $mime, $maxWidth);
            if ($normalized !== null) {
                return $normalized;
            }
        }

        $contents = @file_get_contents($absolutePath);
        if ($contents === false || $contents === '') {
            return null;
        }

        $dompdfSafe = ['image/png', 'image/jpeg', 'image/gif'];
        if (!in_array(strtolower($mime), $dompdfSafe, true)) {
            return null;
        }

        return 'data:' . $mime . ';base64,' . base64_encode($contents);
    }

    protected function normalizeImageForDompdf(string $absolutePath, string $mime, int $maxWidth): ?string
    {
        $raw = @file_get_contents($absolutePath);
        if ($raw === false) {
            return null;
        }

        $image = @imagecreatefromstring($raw);
        if (!$image) {
            return null;
        }

        $width = imagesx($image);
        $height = imagesy($image);
        if ($width < 1 || $height < 1) {
            imagedestroy($image);
            return null;
        }

        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = (int) max(1, round($height * ($maxWidth / $width)));
            $resized = imagecreatetruecolor($newWidth, $newHeight);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
            imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resized;
        } else {
            imagesavealpha($image, true);
        }

        $outMime = (strtolower($mime) === 'image/jpeg') ? 'image/jpeg' : 'image/png';
        ob_start();
        if ($outMime === 'image/jpeg') {
            $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
            $white = imagecolorallocate($bg, 255, 255, 255);
            imagefilledrectangle($bg, 0, 0, imagesx($image), imagesy($image), $white);
            imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
            imagejpeg($bg, null, 85);
            imagedestroy($bg);
        } else {
            imagepng($image, null, 6);
        }
        $binary = ob_get_clean();
        imagedestroy($image);

        if ($binary === false || $binary === '') {
            return null;
        }

        return 'data:' . $outMime . ';base64,' . base64_encode($binary);
    }

    public function addReview(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:tbl_internship,id',
            'student_id' => 'required|exists:users,id',
            'rating' => 'nullable|integer|min:1|max:5',
            'star' => 'nullable|integer|min:1|max:5',
            'review' => 'required|string'
        ]);

        $starValue = $request->star ?? $request->rating;

        if (!$starValue) {
            return response()->json(['status' => false, 'message' => 'Please provide a rating or star value.'], 422);
        }

        $review = InternshipReview::updateOrCreate(
            [
                'internship_id' => $request->internship_id,
                'student_id' => $request->student_id,
            ],
            [
                'star' => $starValue,
                'review' => $request->review,
                'active_status' => 1, // Active
                'write_on' => now()->toDateTimeString()
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Review submitted successfully.',
            'data' => $review
        ], 200);
    }

    public function getInternshipReviews(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:tbl_internship,id'
        ]);

        $reviews = InternshipReview::with(['student'])
            ->where('internship_id', $request->internship_id)
            ->where('active_status', 1)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Reviews fetched successfully.',
            'data' => $reviews
        ], 200);
    }

    public function getGlobalReviews(Request $request)
    {
        $limit = (int) $request->input('limit', 20);
        if ($limit < 1 || $limit > 100) $limit = 20;

        $reviews = InternshipReview::with([
                'student:id,name,profile_img',
                'internship:id,internship_title,company_id',
                'internship.company:id,name,profile_img',
            ])
            ->where('active_status', 1)
            ->whereNotNull('star')
            ->orderByDesc('write_on')
            ->orderByDesc('id')
            ->limit($limit)
            ->get()
            ->map(function ($review) {
                $student = $review->student;
                $internship = $review->internship;
                $company = optional($internship)->company;

                $profileImg = null;
                if ($student && $student->profile_img) {
                    $profileImg = asset('uploads/profile/' . $student->profile_img);
                }

                return [
                    'id'               => $review->id,
                    'star'             => (int) $review->star,
                    'review'           => $review->review,
                    'write_on'         => optional($review->write_on)->format('d M Y'),
                    'student_id'       => optional($student)->id,
                    'student_name'     => optional($student)->name,
                    'student_avatar'   => $profileImg,
                    'internship_id'    => optional($internship)->id,
                    'internship_title' => optional($internship)->internship_title,
                    'company_name'     => optional($company)->name,
                ];
            });

        return response()->json([
            'status'  => true,
            'message' => 'Global reviews fetched successfully.',
            'total'   => $reviews->count(),
            'data'    => $reviews,
        ], 200);
    }

    public function toggleWishlist(Request $request)
    {
        $request->validate([
            'student_id'    => 'nullable|exists:users,id',
            'user_id'       => 'nullable|exists:users,id',
            'internship_id' => 'required|exists:tbl_internship,id',
        ]);

        $userId = $request->student_id ?? $request->user_id ?? Auth::id();

        if (!$userId) {
            return response()->json([
                'status'  => false,
                'message' => 'User or Student ID is required.'
            ], 422);
        }

        $internshipId = $request->internship_id;

        $wishlist = InternshipWishlist::where('user_id', $userId)
            ->where('internship_id', $internshipId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json([
                'status'      => true,
                'action'      => 'removed',
                'is_saved'    => false,
                'is_wishlist' => false,
                'message'     => 'Internship removed from wishlist successfully.'
            ], 200);
        } else {
            InternshipWishlist::create([
                'user_id'       => $userId,
                'internship_id' => $internshipId,
            ]);
            return response()->json([
                'status'      => true,
                'action'      => 'added',
                'is_saved'    => true,
                'is_wishlist' => true,
                'message'     => 'Internship added to wishlist successfully.'
            ], 200);
        }
    }

    public function getWishlistInternships(Request $request)
    {
        $request->validate([
            'student_id' => 'nullable|exists:users,id',
            'user_id'    => 'nullable|exists:users,id',
        ]);

        $userId = $request->student_id ?? $request->user_id ?? Auth::id();

        if (!$userId) {
            return response()->json([
                'status'  => false,
                'message' => 'User or Student ID is required.'
            ], 422);
        }

        $wishlists = InternshipWishlist::with(['internship.company', 'internship.jobCategory'])
            ->where('user_id', $userId)
            ->whereHas('internship', function ($q) {
                $q->whereNull('deleted_at');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $appliedInternshipIds = InternshipApplication::where('user_id', $userId)
            ->pluck('internship_id')
            ->toArray();

        $internships = $wishlists->map(function ($wishlist) use ($appliedInternshipIds) {
            $internship = $wishlist->internship;
            if ($internship) {
                $internship->is_applied = in_array($internship->id, $appliedInternshipIds);
                $internship->is_saved = true;
                $internship->is_wishlist = true;
        if (is_array($internship->sub_categories) && count($internship->sub_categories) > 0) {
                    $internship->sub_categories_data = \App\Models\Jobsubcategory::whereIn('sub_category_id', $internship->sub_categories)->get();
                } else {
                    $internship->sub_categories_data = [];
                }
            }
            return $internship;
        })->filter()->values();

        return response()->json([
            'status'  => true,
            'message' => 'Saved/wishlisted internships fetched successfully.',
            'data'    => $internships
        ], 200);
    }
    public function getEducationList()
    {
        try {
            // Fetch all non-null eligibility criteria from the internships table
            $criteriaList = Internship::whereNotNull('eligibility_criteria')
                ->where('eligibility_criteria', '!=', '')
                ->pluck('eligibility_criteria');

            $allEducation = [];

            foreach ($criteriaList as $criteria) {
                // If it's a JSON array
                $decoded = json_decode($criteria, true);
                
                if (is_array($decoded)) {
                    $items = $decoded;
                } else {
                    // Try exploding by comma if not JSON
                    $items = explode(',', $criteria);
                }

                foreach ($items as $item) {
                    // Remove dots, replace dashes with space, reduce multiple spaces to single space, trim, and convert to uppercase
                    $normalized = strtoupper(trim(str_replace('.', '', $item)));
                    $normalized = str_replace('-', ' ', $normalized);
                    $normalized = preg_replace('/\s+/', ' ', $normalized);
                    
                    if (!empty($normalized)) {
                        $allEducation[$normalized] = true;
                    }
                }
            }

            $uniqueEducation = array_keys($allEducation);
            sort($uniqueEducation);

            return response()->json([
                'status'  => true,
                'message' => 'Education list fetched successfully.',
                'data'    => $uniqueEducation
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to fetch education list: ' . $e->getMessage()
            ], 500);
        }
    }

    private function attachPendingCategorySubcategory($internship)
    {
        if (!$internship) return $internship;

        if (empty($internship->category)) {
            $catReq = \App\Models\CategorySubcategoryRequest::where('internship_id', $internship->id)
                ->where('request_type', 'category')
                ->where('status', \App\Models\CategorySubcategoryRequest::STATUS_PENDING)
                ->first();
            
            if ($catReq) {
                $internship->pending_category = [
                    'id' => 0,
                    'name' => $catReq->requested_name,
                    'status' => 'Pending'
                ];
            } else {
                $internship->pending_category = null;
            }
        } else {
            $internship->pending_category = null;
        }

        $subReqs = \App\Models\CategorySubcategoryRequest::where('internship_id', $internship->id)
            ->where('request_type', 'subcategory')
            ->where('status', \App\Models\CategorySubcategoryRequest::STATUS_PENDING)
            ->get();
        
        if ($subReqs->isNotEmpty()) {
            $pendingSubCats = [];
            foreach ($subReqs as $req) {
                $pendingSubCats[] = [
                    'id' => 0,
                    'name' => $req->requested_name,
                    'status' => 'Pending'
                ];
            }
            $internship->pending_sub_categories = $pendingSubCats;
        } else {
            $internship->pending_sub_categories = [];
        }

        return $internship;
    }
}
