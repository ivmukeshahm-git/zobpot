<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Internship;
use App\Models\User;
use App\Models\JobCategory;
use App\Models\Jobsubcategory;
use App\Models\CategorySubcategoryRequest;
use App\Models\InternshipTask;
use App\Models\InternshipApplication;
use App\Models\InternshipMark;
use App\Models\CollegeStaff;
use App\Models\Grade;
use App\Models\GradeSection;
use App\Models\GradeCriterion;
use App\Models\University;
use App\Models\College;
use App\Models\InternshipReview;
use App\Models\InternshipCollegeSubmit;
use App\Models\InternshipPayment;
use App\Models\InternshipWishlist;
use App\Http\Controllers\StaffActivityController;

class InternshipController extends Controller
{
    /**
     * Display all internship applications from the dashboard's View All link.
     */
    public function appliedInternships()
    {
        $approvedInternships = Internship::where('approve_status', 1)
            ->select('id', 'internship_title')
            ->orderBy('internship_title')
            ->get();

        return view('admin.internship.applied-internships-data', compact('approvedInternships'));
    }

    /**
     * Return all internship applications for the dashboard's full list.
     */
    public function appliedInternshipsData(Request $request)
    {
        $latestPayment = DB::table('tbl_internship_payment as payment')
            ->select('payment.application_id', DB::raw('MAX(payment.id) as latest_payment_id'))
            ->groupBy('payment.application_id');

        $query = DB::table('tbl_internship_application as application')
            ->join('users as applicant', 'applicant.id', '=', 'application.user_id')
            ->leftJoin('tbl_city as city', 'city.city_id', '=', 'applicant.city_id')
            ->leftJoin('tbl_internship as internship', 'internship.id', '=', 'application.internship_id')
            ->leftJoinSub($latestPayment, 'latest_payment', function ($join) {
                $join->on('latest_payment.application_id', '=', 'application.id');
            })
            ->leftJoin('tbl_internship_payment as payment', 'payment.id', '=', 'latest_payment.latest_payment_id')
            ->whereNull('application.deleted_at')
            ->select(
                'application.id',
                'applicant.name',
                'applicant.contact_no',
                'applicant.email',
                'city.city_nm',
                'internship.internship_title',
                'internship.approve_status',
                'application.applied_on',
                'payment.payment_status',
                'payment.total_amount'
            );

        $internshipIds = array_filter((array) $request->input('internship_id', []));
        if ($internshipIds) {
            $query->whereIn('application.internship_id', $internshipIds);
        } else {
            $query->where('internship.approve_status', 1);
        }

        if ($request->input('payment_status') === 'paid') {
            $query->where('payment.payment_status', 1);
        } elseif ($request->input('payment_status') === 'unpaid') {
            $query->where(function ($paymentQuery) {
                $paymentQuery->whereNull('payment.payment_status')
                    ->orWhere('payment.payment_status', '!=', 1);
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('application.applied_on', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('application.applied_on', '<=', $request->input('date_to'));
        }

        $applications = $query->orderByDesc('application.applied_on')->get();
        $rows = $applications->values()->map(function ($application, $index) {
                $isPaid = (int) $application->payment_status === 1;

                return [
                    'DT_RowIndex' => $index + 1,
                    'application_id' => $application->id,
                    'name' => $application->name ?? '-',
                    'contact_no' => $application->contact_no ?? '-',
                    'email' => $application->email ?? '-',
                    'city' => $application->city_nm ?? '-',
                    'internship_title' => $application->internship_title ?? '-',
                    'internship_status' => (int) $application->approve_status === 1
                        ? 'Approved'
                        : 'Not Approved',
                    'applied_at' => $application->applied_on
                        ? date('d-m-Y h:i A', strtotime($application->applied_on))
                        : '-',
                    'payment_status' => $isPaid ? 'Paid' : 'Unpaid',
                    'payment_amount' => $isPaid
                        ? number_format((float) $application->total_amount, 2)
                        : '-',
                ];
            });

        return response()->json([
            'draw' => (int) $request->input('draw', 1),
            'recordsTotal' => $rows->count(),
            'recordsFiltered' => $rows->count(),
            'data' => $rows,
            'summary' => [
                'total' => $rows->count(),
                'paid_count' => $applications->where('payment_status', 1)->count(),
                'paid_amount' => number_format((float) $applications->where('payment_status', 1)->sum('total_amount'), 2),
                'unpaid_count' => $applications->where(function ($row) {
                    return (int) $row->payment_status !== 1;
                })->count(),
                'unpaid_amount' => '0.00',
            ],
        ]);
    }

    /**
     * Soft-delete an internship application.
     */
    public function deleteApplication($id)
    {
        $application = InternshipApplication::findOrFail($id);
        $application->delete();

        return response()->json([
            'success' => true,
            'message' => 'Internship application deleted successfully.',
        ]);
    }

    /**
     * Display the internship management page
     */
    public function index()
    {
        return view('admin.internship.internship');
    }

    /**
     * Show the form for creating a new internship
     */
    public function create()
    {
        // Get companies (users with role = 'company')
        $companies = User::where('role', 'User')
            ->where('active_status', 1)
            ->where('profile_type','Company')
            ->select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        // Get categories
        $categories = JobCategory::select('category_id', 'category_nm')
            ->orderBy('category_nm', 'asc')
            ->get();

        return view('admin.internship.create', compact('companies', 'categories'));
    }

    /**
     * Display the internship view page with all details
     */
    public function view($id)
    {
        $internship = Internship::with(['company', 'jobCategory'])->findOrFail($id);

        // Fetch enrolled students with college info (eager load to avoid N+1)
        $students = InternshipApplication::with(['user.college'])
            ->where('internship_id', $id)
            ->get();

        // Build per-student "Industry Marks" criteria map (college + degree specific).
        // Cache by "collegeId:degreeId" to avoid duplicate queries for students in the same college/degree.
        $studentCriteriaMap = [];
        $gradeCriteriaCache  = [];

        foreach ($students as $application) {
            $student = $application->user;
            if (!$student) {
                continue;
            }

            $collegeId = $student->college_id;
            $degreeId  = $student->degree_id;

            if (!$collegeId) {
                $studentCriteriaMap[$student->id] = collect();
                continue;
            }

            $cacheKey = "{$collegeId}:{$degreeId}";

            if (!array_key_exists($cacheKey, $gradeCriteriaCache)) {
                $grade = Grade::where('college_id', $collegeId)
                    ->when($degreeId, fn ($q) => $q->where('course_id', $degreeId))
                    ->first();

                if (!$grade) {
                    $gradeCriteriaCache[$cacheKey] = collect();
                } else {
                    $section = GradeSection::where('grade_id', $grade->id)
                        ->where('title', 'Industry Marks')
                        ->first();

                    $gradeCriteriaCache[$cacheKey] = $section
                        ? GradeCriterion::where('section_id', $section->id)
                            ->whereNull('deleted_at')
                            ->get()
                        : collect();
                }
            }

            $studentCriteriaMap[$student->id] = $gradeCriteriaCache[$cacheKey];
        }

        // Keep legacy variables (used nowhere else in this view but kept for safety)
        $gradeSections   = collect();
        $industryCriteria = collect();

        // Pre-load saved marks for this internship (keyed by student_id + criteria_id)
        $savedMarks = InternshipMark::where('internship_id', $id)
            ->get()
            ->groupBy('student_id');

        // Pre-load feedback from applications
        $savedFeedbacks = InternshipApplication::where('internship_id', $id)
            ->pluck('company_feedback', 'user_id');

        // Log activity
        StaffActivityController::insertActivity(Auth::id(), "Viewed internship details (ID: {$id})");

        return view('admin.internship.view', compact(
            'internship', 'students', 'gradeSections', 'industryCriteria',
            'studentCriteriaMap', 'savedMarks', 'savedFeedbacks'
        ));
    }

    /**
     * Store a newly created internship in storage
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'internship_title' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'sub_category_id' => 'required|array|min:1',
            'sub_category_id.*' => 'integer|exists:tbl_sub_category,sub_category_id',
            'company_id' => 'required|integer',
            'company_website' => 'nullable|url|max:255',
            'internship_mode' => 'required|in:Online,Offline,Hybrid,Weekly,Part Time,Full Time',
            'location' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'weeks' => 'required|integer|min:1',
            'hours' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'application_deadline' => 'required|date|after_or_equal:today|before_or_equal:start_date',
            'batch_days' => 'nullable|array',
            'stipend' => 'nullable|numeric|min:0',
            'openings' => 'required|integer|min:1',
            'required_skills' => 'nullable|string',
            'required_eligibility_criteria' => 'nullable|string',
            'internship_description' => 'required|string',
            'module_description' => 'required|string',
            'internship_objective' => 'required|string',
            'internship_outcome' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Generate unique slug
            $slug = Str::slug($request->internship_title);
            $originalSlug = $slug;
            $counter = 1;
            
            // Include soft-deleted rows — unique index still applies to them
            while (Internship::withTrashed()->where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            // Create internship
            $internship = Internship::create([
                'internship_title' => $request->internship_title,
                'slug' => $slug,
                'category' => $request->category_id,
                'sub_categories' => array_values(array_filter(array_map('intval', (array) $request->input('sub_category_id', [])))),
                'company_id' => $request->company_id,
                'company_website' => $request->company_website,
                'mode' => $request->internship_mode,
                'location' => $request->location,
                'duration' => $request->duration,
                'total_weeks' => $request->weeks,
                'total_hours' => $request->hours,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'stipend' => $request->stipend ?? 0,
                'openings' => $request->openings,
                'application_deadline' => $request->application_deadline,
                'batch_days' => $request->batch_days ?? [],
                'skills' => $this->normalizeTagList($request->required_skills),
                'eligibility_criteria' => $this->normalizeTagList($request->required_eligibility_criteria),
                'perks' => $request->perks ?? [],
                'internship_description' => $request->internship_description,
                'module_brief_description' => $request->module_description,
                'internship_objective' => $request->internship_objective,
                'internship_outcome' => $request->internship_outcome,
                'registration_fees' => 0,
                'gst_percentage' => 0,
                'gst_amount' => 0,
                'final_amount' => 0,
                'complete_status' => 0,
                'approve_status' => 0,
            ]);

            // Log activity
            StaffActivityController::insertActivity(Auth::id(), "Created new internship: {$request->internship_title}");

            return redirect()
                ->route('admin.internship.management')
                ->with('success', 'Internship created successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create internship: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Get New Requests DataTable
     */
    public function getNewRequestsData(Request $request)
    {
        if ($request->ajax()) {
            // Get internships with pending/new status (approve_status = 0 and not rejected)
            $data = Internship::with(['company', 'jobCategory'])
                ->where('approve_status', 0)
                ->whereNull('rejection_reason')
                ->where('complete_status', 0)
                ->orderBy('created_at', 'desc')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('company_name', function ($row) {
                    return $row->company ? $row->company->name : 'N/A';
                })
                ->addColumn('category_name', function ($row) {
                    return $row->jobCategory ? $row->jobCategory->category_nm : 'N/A';
                })
                ->addColumn('formatted_date', function ($row) {
                    return $row->created_at->format('M d, Y');
                })
                ->addColumn('status_badge', function ($row) {
                    return '<span class="badge bg-warning">Pending</span>';
                })
                ->addColumn('action', function ($row) {
                    $user = auth()->user();
                    $btn = '';
                    if ($user->can('Internship-Approve')) {
                        $btn .= '<button type="button" class="btn btn-sm me-1" onclick="openAcceptModal(' . $row->id . ')" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3); transition: all 0.3s ease;"><i class="bx bx-check-circle"></i> Accept</button>';
                    }
                    if ($user->can('Internship-Reject')) {
                        $btn .= '<button type="button" class="btn btn-sm me-1" onclick="rejectInternship(' . $row->id . ')" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3); transition: all 0.3s ease;"><i class="bx bx-x-circle"></i> Reject</button>';
                    }
                    if ($user->can('Internship-Delete')) {
                        $btn .= '<button onclick="deleteInternship(' . $row->id . ')" class="btn btn-sm" style="background: #6c757d; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600;"><i class="bx bx-trash"></i> Delete</button>';
                    }
                    return $btn;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }
    }

    /**
     * Get Approved Internships DataTable
     */
    public function getApprovedData(Request $request)
    {
        if ($request->ajax()) {
            // Get approved internships that haven't started yet or just started
            $data = Internship::with(['company', 'jobCategory'])
                ->where('approve_status', 1)
                ->where('complete_status', 0)
                ->whereNull('rejection_reason')
                ->orderBy('start_date', 'asc')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" class="internship-checkbox" value="' . $row->id . '">';
                })
                ->addColumn('company_name', function ($row) {
                    return $row->company ? $row->company->name : 'N/A';
                })
                ->addColumn('category_name', function ($row) {
                    return $row->jobCategory ? $row->jobCategory->category_nm : 'N/A';
                })
                ->addColumn('formatted_start_date', function ($row) {
                    return $row->start_date ? $row->start_date->format('M d, Y') : 'N/A';
                })
                ->addColumn('formatted_end_date', function ($row) {
                    return $row->end_date ? $row->end_date->format('M d, Y') : 'N/A';
                })
                ->addColumn('status_badge', function ($row) {
                    return '<span class="badge bg-success">Approved</span>';
                })
                ->addColumn('action', function ($row) {
                    $user = auth()->user();
                    $btn = '';
                    if ($user->can('Internship-View')) {
                        $btn .= '<a href="' . route('admin.internship.view', $row->id) . '" class="btn btn-action btn-view btn-sm me-1"><i class="bx bx-show"></i> View</a>';
                    }
                    if ($user->can('Internship-Edit')) {
                        $btn .= '<a href="' . route('admin.internship.edit', $row->id) . '" class="btn btn-action btn-sm me-1" style="background: #17a2b8; color: white;"><i class="bx bx-edit"></i> Edit</a>';
                    }
                    if ($user->can('Internship-Delete')) {
                        $btn .= '<button onclick="deleteInternship(' . $row->id . ')" class="btn btn-action btn-sm" style="background: #dc3545; color: white;"><i class="bx bx-trash"></i> Delete</button>';
                    }
                    return $btn;
                })
                ->rawColumns(['checkbox','status_badge', 'action'])
                ->make(true);
        }
    }

    /**
     * Return active college staff list (for assign modal)
     */
    public function getStaffList(Request $request)
    {
        // If current admin user (super-admin), return admin users with role 'Staff'
        $auth = auth()->user();
        if ($auth && $auth->role === 'Admin') {
            $users = \App\Models\User::where('role', 'Staff')
                ->where('active_status', 1)
                ->select('id', 'name', 'email')
                ->orderBy('name')
                ->get();

            return response()->json(['success' => true, 'data' => $users, 'type' => 'admin']);
        }

        // Otherwise return college staff list
        $staff = CollegeStaff::where('active_status', 1)
            ->select('id', 'name', 'college_id')
            ->orderBy('name')
            ->get();

        $staff->transform(function($s){
            $s->college_name = $s->college ? $s->college->college_name : null;
            return $s;
        });

        return response()->json(['success' => true, 'data' => $staff, 'type' => 'college']);
    }

    /**
     * Bulk assign all existing applications of selected internships to a staff member
     */
    public function bulkAssignToStaff(Request $request)
    {
        $request->validate([
            'internship_ids' => 'required|array|min:1',
            'internship_ids.*' => 'integer|exists:tbl_internship,id',
            'staff_id' => 'required|integer',
        ]);

        $ids = $request->input('internship_ids');
        $staffId = $request->input('staff_id');

        // Determine whether staffId exists in users (admin staff) or college staff
        $isAdminStaff = \App\Models\User::where('id', $staffId)->where('role', 'Staff')->exists();
        $isCollegeStaff = CollegeStaff::where('id', $staffId)->where('active_status', 1)->exists();

        if (! $isAdminStaff && ! $isCollegeStaff) {
            return response()->json(['success' => false, 'message' => 'Selected staff not found.'], 422);
        }

        // Update internship applications associated with these internships
        $updated = InternshipApplication::whereIn('internship_id', $ids)
            ->update(['assigned_staff_id' => $staffId]);

        return response()->json([
            'success' => true,
            'message' => $updated . ' application(s) updated and assigned to staff.',
            'updated' => $updated
        ]);
    }

    /**
     * Get Rejected Internships DataTable
     */
    public function getRejectedData(Request $request)
    {
        if ($request->ajax()) {
            // Get rejected internships
            $data = Internship::with(['company', 'jobCategory'])
                ->whereNotNull('rejection_reason')
                ->orderBy('updated_at', 'desc')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('company_name', function ($row) {
                    return $row->company ? $row->company->name : 'N/A';
                })
                ->addColumn('category_name', function ($row) {
                    return $row->jobCategory ? $row->jobCategory->category_nm : 'N/A';
                })
                ->addColumn('formatted_date', function ($row) {
                    return $row->updated_at->format('M d, Y');
                })
                ->addColumn('rejection_reason', function ($row) {
                    return $row->rejection_reason ? substr($row->rejection_reason, 0, 50) . '...' : 'No reason provided';
                })
                ->addColumn('status_badge', function ($row) {
                    return '<span class="badge bg-danger">Rejected</span>';
                })
                ->addColumn('action', function ($row) {
                    $user = auth()->user();
                    $btn = '';
                    if ($user->can('Internship-View')) {
                        $btn .= '<a href="' . route('admin.internship.view', $row->id) . '" class="btn btn-action btn-view btn-sm me-1"><i class="bx bx-show"></i> View</a>';
                    }
                    if ($user->can('Internship-Delete')) {
                        $btn .= '<button type="button" class="btn btn-action btn-reject btn-sm" onclick="deleteInternship(' . $row->id . ')"><i class="bx bx-trash"></i> Delete</button>';
                    }
                    return $btn;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }
    }

    /**
     * Get Processing Internships DataTable
     */
    public function getProcessingData(Request $request)
    {
        if ($request->ajax()) {
            // Get internships that are approved and in progress
            $data = Internship::with(['company', 'jobCategory'])
                ->where('approve_status', 1)
                ->where('complete_status', 0)
                ->where('college_complete_sts', 0)
                ->where('company_complete_sts', 0)
                ->orderBy('start_date', 'asc')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('company_name', function ($row) {
                    return $row->company ? $row->company->name : 'N/A';
                })
                ->addColumn('category_name', function ($row) {
                    return $row->jobCategory ? $row->jobCategory->category_nm : 'N/A';
                })
                ->addColumn('formatted_start_date', function ($row) {
                    return $row->start_date ? $row->start_date->format('M d, Y') : 'N/A';
                })
                ->addColumn('formatted_end_date', function ($row) {
                    return $row->end_date ? $row->end_date->format('M d, Y') : 'N/A';
                })
                ->addColumn('status_badge', function ($row) {
                    return '<span class="badge bg-info">In Progress</span>';
                })
                ->addColumn('action', function ($row) {
                    $user = auth()->user();
                    $btn = '';
                    if ($user->can('Internship-View')) {
                        $btn .= '<a href="' . route('admin.internship.view', $row->id) . '" class="btn btn-action btn-view btn-sm me-1"><i class="bx bx-show"></i> View</a>';
                    }
                    if ($user->can('Internship-Delete')) {
                        $btn .= '<button onclick="deleteInternship(' . $row->id . ')" class="btn btn-action btn-sm" style="background: #dc3545; color: white;"><i class="bx bx-trash"></i> Delete</button>';
                    }
                    return $btn;
                })
                ->rawColumns(['progress', 'status_badge', 'action'])
                ->make(true);
        }
    }

    /**
     * Get Completed Internships DataTable
     */
    public function getCompletedData(Request $request)
    {
        if ($request->ajax()) {
            // Get completed internships.
            // Rules:
            // - Include internships which are fully completed (complete_status = 1 AND company_complete_sts = 1)
            // - Also include internships of type 2 (company-only) where company has submitted marks (internship_type = 2 AND company_complete_sts = 1)
            $data = Internship::with(['company', 'jobCategory'])
                ->where(function($q) {
                    $q->where(function($q1) {
                        $q1->where('complete_status', 1)
                           ->where('company_complete_sts', 1);
                    })
                    ->orWhere(function($q2) {
                        $q2->where('internship_type', 2)
                           ->where('company_complete_sts', 1);
                    });
                })
                ->orderBy('end_date', 'desc')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('company_name', function ($row) {
                    return $row->company ? $row->company->name : 'N/A';
                })
                ->addColumn('category_name', function ($row) {
                    return $row->jobCategory ? $row->jobCategory->category_nm : 'N/A';
                })
                ->addColumn('formatted_end_date', function ($row) {
                    return $row->end_date ? $row->end_date->format('M d, Y') : 'N/A';
                })
                ->addColumn('status_badge', function ($row) {
                    return '<span class="badge bg-success">Completed</span>';
                })
                ->addColumn('action', function ($row) {
                    if (auth()->user()->can('Internship-View')) {
                        return '<a href="' . route('admin.internship.view', $row->id) . '" class="btn btn-action btn-view btn-sm"><i class="bx bx-show"></i> View</a>';
                    }
                    return '';
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }
    }

    /**
     * Get internship details for modal
     */
    public function getInternshipDetails($id)
    {
        try {
            $internship = Internship::with(['company', 'jobCategory'])->findOrFail($id);

            // Resolve subcategory names
            $subCategoryIds = is_array($internship->sub_categories) ? array_map('intval', $internship->sub_categories) : [];
            $subCategoryNames = [];
            $subcategoryIsRequested = false;
            if (!empty($subCategoryIds)) {
                $subCategoryNames = Jobsubcategory::whereIn('sub_category_id', $subCategoryIds)
                    ->pluck('sub_category_nm')
                    ->toArray();
            }

            // Resolve category name
            $categoryName = $internship->jobCategory ? $internship->jobCategory->category_nm : null;
            $categoryIsRequested = false;

            // Fall back to requested (Other) category/subcategory names from requests table
            $categoryRequest = CategorySubcategoryRequest::where('internship_id', $internship->id)
                ->where('request_type', 'category')
                ->orderByDesc('id')
                ->first();

            if (!$categoryName && $categoryRequest) {
                $categoryName = $categoryRequest->requested_name;
                $categoryIsRequested = true;
            }

            if (empty($subCategoryNames)) {
                $requestedSubNames = CategorySubcategoryRequest::where('internship_id', $internship->id)
                    ->where('request_type', 'subcategory')
                    ->orderByDesc('id')
                    ->pluck('requested_name')
                    ->toArray();
                if (!empty($requestedSubNames)) {
                    $subCategoryNames = $requestedSubNames;
                    $subcategoryIsRequested = true;
                }
            }

            // Approval checks — category/subcategory must exist in master tables
            $categoryApproved = $internship->category > 0
                && $internship->jobCategory
                && JobCategory::where('category_id', $internship->category)->exists();

            $existingSubIds = !empty($subCategoryIds)
                ? Jobsubcategory::whereIn('sub_category_id', $subCategoryIds)->pluck('sub_category_id')->map(fn ($v) => (int) $v)->toArray()
                : [];
            $subcategoriesApproved = !empty($subCategoryIds)
                && count(array_diff($subCategoryIds, $existingSubIds)) === 0;

            // Related subcategory request statuses for this internship
            $subcategoryRequestStatus = null;
            $subcategoryRequests = CategorySubcategoryRequest::where('internship_id', $internship->id)
                ->where('request_type', 'subcategory')
                ->orderByDesc('id')
                ->get();
            if ($subcategoryRequests->isNotEmpty()) {
                if ($subcategoryRequests->contains(fn ($r) => $r->status == CategorySubcategoryRequest::STATUS_REJECTED)) {
                    $subcategoryRequestStatus = 'rejected';
                } elseif ($subcategoryRequests->contains(fn ($r) => $r->status == CategorySubcategoryRequest::STATUS_PENDING)) {
                    $subcategoryRequestStatus = 'pending';
                } else {
                    $subcategoryRequestStatus = 'approved';
                }
            }

            // Request status for category
            $categoryRequestStatus = null;
            if ($categoryRequest) {
                $categoryRequestStatus = $categoryRequest->status == CategorySubcategoryRequest::STATUS_PENDING
                    ? 'pending'
                    : ($categoryRequest->status == CategorySubcategoryRequest::STATUS_APPROVED ? 'approved' : 'rejected');
            }

            // Master lists for admin re-selection (used when requests were rejected)
            $categories = JobCategory::orderBy('category_nm', 'asc')
                ->get(['category_id', 'category_nm'])
                ->map(fn ($c) => ['id' => $c->category_id, 'name' => $c->category_nm]);

            $subcategories = Jobsubcategory::orderBy('sub_category_nm', 'asc')
                ->get(['sub_category_id', 'category_id', 'sub_category_nm'])
                ->map(fn ($s) => [
                    'id' => $s->sub_category_id,
                    'category_id' => $s->category_id,
                    'name' => $s->sub_category_nm,
                ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $internship->id,
                    'internship_title' => $internship->internship_title,
                    'category_name' => $categoryName
                        ? $categoryName . ($categoryIsRequested ? ' (Requested)' : '')
                        : 'N/A',
                    'category_id' => (int) $internship->category,
                    'subcategory_names' => !empty($subCategoryNames)
                        ? implode(', ', $subCategoryNames) . ($subcategoryIsRequested ? ' (Requested)' : '')
                        : 'N/A',
                    'sub_categories' => $subCategoryIds,
                    'category_approved' => $categoryApproved,
                    'subcategories_approved' => $subcategoriesApproved,
                    'category_request_status' => $categoryRequestStatus,
                    'subcategory_request_status' => $subcategoryRequestStatus,
                    'categories' => $categories,
                    'subcategories' => $subcategories,
                    'company_name' => $internship->company ? $internship->company->name : 'N/A',
                    'company_website' => $internship->company_website,
                    'mode' => $internship->mode,
                    'location' => $internship->location,
                    'duration' => $internship->duration,
                    'total_weeks' => $internship->total_weeks,
                    'total_hours' => $internship->total_hours,
                    'start_date' => $internship->start_date ? $internship->start_date->format('Y-m-d') : null,
                    'end_date' => $internship->end_date ? $internship->end_date->format('Y-m-d') : null,
                    'formatted_start_date' => $internship->start_date ? $internship->start_date->format('M d, Y') : 'N/A',
                    'formatted_end_date' => $internship->end_date ? $internship->end_date->format('M d, Y') : 'N/A',
                    'formatted_deadline' => $internship->application_deadline ? $internship->application_deadline->format('M d, Y') : 'N/A',
                    'application_deadline' => $internship->application_deadline ? $internship->application_deadline->format('Y-m-d') : null,
                    'stipend' => $internship->stipend,
                    'openings' => $internship->openings,
                    'batch_days' => $internship->batch_days,
                    'skills' => $internship->skills,
                    'eligibility_criteria' => $internship->eligibility_criteria,
                    'internship_description' => $internship->internship_description,
                    'module_brief_description' => $internship->module_brief_description,
                    'internship_objective' => $internship->internship_objective,
                    'internship_outcome' => $internship->internship_outcome,
                    'registration_fees' => $internship->registration_fees,
                    'late_registration_fee' => $internship->late_registration_fee ?? 0,
                    'last_registration_date' => $internship->last_registration_date
                        ? $internship->last_registration_date->format('Y-m-d')
                        : null,
                    'late_register_last_date' => $internship->last_registration_date
                        ? $internship->last_registration_date->format('Y-m-d')
                        : null,
                    'formatted_last_registration_date' => $internship->last_registration_date
                        ? $internship->last_registration_date->format('M d, Y')
                        : 'N/A',
                    'gst_percentage' => $internship->gst_percentage,
                    'gst_amount' => $internship->gst_amount,
                    'final_amount' => $internship->final_amount,
                    'platform_service_charge' => $internship->platform_service_charge ?? 0,
                    'payment_preview' => app(\App\Services\InternshipPaymentService::class)->calculatePayment($internship),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internship not found: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Get applied students for an internship (DataTables)
     */
    public function getStudentsData(Request $request)
    {
        if ($request->ajax()) {
            $internshipId = $request->input('internship_id');
            $internship = Internship::find($internshipId);
            $internshipType = (int) ($internship->internship_type ?? 0);
            $companyCompleted = $internship && (int) $internship->company_complete_sts === 1;
            $collegeCompleted = $internship && (int) $internship->college_complete_sts === 1;

            $data = InternshipApplication::with([
                    'user.college.university',
                    'user.degree.degreeLevel',
                    'user.major',
                ])
                ->where('internship_id', $internshipId)
                ->orderBy('applied_on', 'desc')
                ->get();

            // Prefetch degree levels by user.degree_level_id (covers cases where degree relation is missing)
            $degreeLevelIds = $data->map(function ($row) {
                return $row->user->degree_level_id ?? null;
            })->filter()->unique()->values()->all();
            $degreeLevelsById = $degreeLevelIds
                ? \App\Models\DegreeLevel::whereIn('degree_level_id', $degreeLevelIds)->get()->keyBy('degree_level_id')
                : collect();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('student_name', function ($row) {
                    return $row->user ? $row->user->name : 'N/A';
                })
                ->addColumn('email', function ($row) {
                    return $row->user ? ($row->user->email ?: 'N/A') : 'N/A';
                })
                ->addColumn('phone', function ($row) {
                    return $row->user ? ($row->user->contact_no ?: 'N/A') : 'N/A';
                })
                ->addColumn('university_name', function ($row) {
                    $university = $row->user && $row->user->college ? $row->user->college->university : null;
                    // Only show approved university (status = 1); unapproved/pending => N/A
                    if ($university && (int) $university->status === 1) {
                        return $university->university_name ?: 'N/A';
                    }
                    return 'N/A';
                })
                ->addColumn('college_name', function ($row) {
                    $college = $row->user ? $row->user->college : null;
                    // Only show approved college (status = 1); unapproved/pending => N/A
                    if ($college && (int) $college->status === 1) {
                        return $college->college_name ?: 'N/A';
                    }
                    return 'N/A';
                })
                ->addColumn('degree_level_name', function ($row) use ($degreeLevelsById) {
                    $degreeLevel = null;
                    if ($row->user && $row->user->degree_level_id) {
                        $degreeLevel = $degreeLevelsById->get($row->user->degree_level_id);
                    }
                    if (!$degreeLevel && $row->user && $row->user->degree) {
                        $degreeLevel = $row->user->degree->degreeLevel;
                    }
                    // Only show approved degree level (approve_status = 1)
                    if ($degreeLevel && (int) $degreeLevel->approve_status === 1) {
                        return $degreeLevel->degree_level_name ?: 'N/A';
                    }
                    return 'N/A';
                })
                ->addColumn('degree_name', function ($row) {
                    $degree = $row->user ? $row->user->degree : null;
                    // Only show approved degree (approve_status = 1)
                    if ($degree && (int) $degree->approve_status === 1) {
                        return $degree->degree_name ?: 'N/A';
                    }
                    return 'N/A';
                })
                ->addColumn('major_name', function ($row) {
                    $major = $row->user ? $row->user->major : null;
                    // Only show approved major (approve_status = 1)
                    if ($major && (int) $major->approve_status === 1) {
                        return $major->major_name ?: 'N/A';
                    }
                    return 'N/A';
                })
                ->addColumn('semester', function ($row) {
                    return $row->user && $row->user->semester ? $row->user->semester : 'N/A';
                })
                ->addColumn('enrollment_date', function ($row) {
                    return $row->applied_on ? $row->applied_on->format('d M Y') : 'N/A';
                })
                ->addColumn('action', function ($row) use ($internshipType, $companyCompleted, $collegeCompleted) {
                    $userId = $row->user ? $row->user->id : null;
                    $url = $userId ? url('admin/candidate-profile/' . $userId) : '#';
                    $buttons = '<div class="d-flex flex-wrap gap-1 justify-content-center align-items-center">'
                        . '<button type="button" class="btn btn-sm btn-edit-student" title="Edit Academic Details" '
                        . 'onclick="openEditStudentAcademic(' . (int) $row->id . ')">'
                        . '<i class="bx bx-edit"></i></button>'
                        . '<a href="' . $url . '" class="btn btn-sm btn-view-profile" title="View Profile" target="_blank">'
                        . '<i class="bx bx-show"></i></a>';

                    if ($companyCompleted) {
                        $companyUrl = route('admin.internship.certificate.preview', [
                            'applicationId' => $row->id,
                            'type' => 'company',
                        ]);
                        $buttons .= '<a href="' . $companyUrl . '" class="btn btn-sm btn-success" target="_blank" title="Company Certificate">'
                            . '<i class="bx bx-certification"></i></a>';
                    }

                    if ($collegeCompleted && $internshipType === 1) {
                        $collegeUrl = route('admin.internship.certificate.preview', [
                            'applicationId' => $row->id,
                            'type' => 'college',
                        ]);
                        $buttons .= '<a href="' . $collegeUrl . '" class="btn btn-sm btn-warning" target="_blank" title="College Certificate">'
                            . '<i class="bx bx-certification"></i></a>';
                    }

                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['action'])
                ->only([
                    'DT_RowIndex',
                    'student_name',
                    'email',
                    'phone',
                    'university_name',
                    'college_name',
                    'degree_level_name',
                    'degree_name',
                    'major_name',
                    'semester',
                    'enrollment_date',
                    'action',
                ])
                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }

    /**
     * Get enrolled student's academic details for edit modal.
     */
    public function getEnrolledStudentAcademic($applicationId)
    {
        $application = InternshipApplication::with(['user.college', 'user.degree'])->findOrFail($applicationId);
        $user = $application->user;

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found for this application.',
            ], 404);
        }

        $universityId = $user->university_id;
        if (!$universityId && $user->college) {
            $universityId = $user->college->university_id;
        }

        $degreeLevelId = $user->degree_level_id;
        if (!$degreeLevelId && $user->degree) {
            $degreeLevelId = $user->degree->degree_level_id;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'application_id' => $application->id,
                'student_id' => $user->id,
                'student_name' => $user->name,
                'university_id' => $universityId,
                'college_id' => $user->college_id,
                'degree_level_id' => $degreeLevelId,
                'degree_id' => $user->degree_id,
                'major_id' => $user->major_id,
                'semester' => $user->semester,
            ],
        ]);
    }

    /**
     * Update enrolled student's academic details (user + application snapshot).
     */
    public function updateEnrolledStudentAcademic(Request $request, $applicationId)
    {
        $validator = Validator::make($request->all(), [
            'university_id' => 'required|integer|exists:tbl_university,id',
            'college_id' => 'required|integer|exists:tbl_college,id',
            'degree_level_id' => 'required|integer|exists:tbl_degree_level,degree_level_id',
            'degree_id' => 'required|integer|exists:tbl_degree,degree_id',
            'major_id' => 'required|integer|exists:tbl_major,major_id',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first() ?: 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $application = InternshipApplication::with('user')->findOrFail($applicationId);
        $user = $application->user;

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found for this application.',
            ], 404);
        }

        // Ensure college belongs to selected university
        $college = College::where('id', $request->college_id)
            ->where('university_id', $request->university_id)
            ->first();
        if (!$college) {
            return response()->json([
                'success' => false,
                'message' => 'Selected college does not belong to the selected university.',
            ], 422);
        }

        // Ensure degree belongs to selected degree level
        $degree = \App\Models\Degree::where('degree_id', $request->degree_id)
            ->where('degree_level_id', $request->degree_level_id)
            ->first();
        if (!$degree) {
            return response()->json([
                'success' => false,
                'message' => 'Selected degree does not belong to the selected degree level.',
            ], 422);
        }

        // Ensure major belongs to selected degree
        $major = \App\Models\Major::where('major_id', $request->major_id)
            ->where('degree_id', $request->degree_id)
            ->first();
        if (!$major) {
            return response()->json([
                'success' => false,
                'message' => 'Selected major does not belong to the selected degree.',
            ], 422);
        }

        DB::beginTransaction();
        try {
            $user->university_id = (int) $request->university_id;
            $user->college_id = (int) $request->college_id;
            $user->degree_level_id = (int) $request->degree_level_id;
            $user->degree_id = (int) $request->degree_id;
            $user->major_id = (int) $request->major_id;
            $user->semester = (int) $request->semester;
            $user->save();

            $application->college_id = (int) $request->college_id;
            $application->degree_id = (int) $request->degree_id;
            $application->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Student academic details updated successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('updateEnrolledStudentAcademic error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update student academic details.',
            ], 500);
        }
    }

    /**
     * Accept internship application
     */
    public function acceptInternship(Request $request, $id)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'registration_fees' => 'nullable|numeric|min:0',
                'last_registration_date' => 'nullable|date|before_or_equal:start_date',
                'late_registration_fee' => 'nullable|numeric|min:0',
                'gst_percentage' => 'nullable|numeric|min:0|max:100',
                'gst_amount' => 'nullable|numeric|min:0',
                'final_amount' => 'nullable|numeric|min:0',
                'platform_service_charge' => 'nullable|numeric|min:0',
                'manage_task_status' => 'nullable|boolean',
                'internship_type' => 'required|integer|in:1,2',
                'category_id' => 'nullable|integer|exists:tbl_job_category,category_id',
                'sub_category_ids' => 'nullable|array',
                'sub_category_ids.*' => 'integer|exists:tbl_sub_category,sub_category_id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first() ?: 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $internship = Internship::findOrFail($id);

            // Admin re-selected category/subcategory (used when original request was rejected)
            if ($request->filled('category_id')) {
                $updateCategory = ['category' => (int) $request->input('category_id')];

                if ($request->has('sub_category_ids')) {
                    $selectedSubIds = array_values(array_unique(array_map('intval', (array) $request->input('sub_category_ids', []))));
                    // Only keep subcategories that belong to the selected category
                    $validSubIds = Jobsubcategory::where('category_id', (int) $request->input('category_id'))
                        ->whereIn('sub_category_id', $selectedSubIds)
                        ->pluck('sub_category_id')
                        ->map(fn ($v) => (int) $v)
                        ->toArray();
                    $updateCategory['sub_categories'] = $validSubIds;
                }

                $internship->update($updateCategory);
                $internship->refresh();
            }

            // Last registration must be on/after application deadline when both are present
            if ($request->filled('last_registration_date')) {
                $lastReg = \Carbon\Carbon::parse($request->input('last_registration_date'))->startOfDay();
                $appDeadline = $internship->application_deadline
                    ? \Carbon\Carbon::parse($internship->application_deadline)->startOfDay()
                    : null;
                $startDate = $request->filled('start_date')
                    ? \Carbon\Carbon::parse($request->input('start_date'))->startOfDay()
                    : ($internship->start_date ? \Carbon\Carbon::parse($internship->start_date)->startOfDay() : null);

                if ($appDeadline && $lastReg->lt($appDeadline)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Last date of registration must be on or after the application deadline.',
                    ], 422);
                }
                if ($startDate && $lastReg->gt($startDate)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Last date of registration must be on or before the start date.',
                    ], 422);
                }
            }

            // Prepare update data — always persist type/status so they cannot stay at 0
            $updateData = [
                'approve_status' => 1,
                'rejection_reason' => null,
                'internship_type' => (int) $request->input('internship_type'),
                'manage_task_status' => $request->boolean('manage_task_status') ? 1 : 0,
            ];

            // Add optional fields if provided
            if ($request->filled('start_date')) {
                $updateData['start_date'] = $request->start_date;
            }
            if ($request->filled('end_date')) {
                $updateData['end_date'] = $request->end_date;
            }
            if ($request->has('registration_fees')) {
                $updateData['registration_fees'] = (float) $request->registration_fees;
            }

            // Always persist late registration config from admin approve modal
            $updateData['last_registration_date'] = $request->filled('last_registration_date')
                ? $request->input('last_registration_date')
                : null;
            $updateData['late_registration_fee'] = $request->filled('late_registration_fee')
                ? (float) $request->input('late_registration_fee')
                : 0;

            if ($request->has('gst_percentage')) {
                $updateData['gst_percentage'] = $request->gst_percentage;
            }
            if ($request->has('gst_amount')) {
                $updateData['gst_amount'] = $request->gst_amount;
            }
            if ($request->has('final_amount')) {
                $updateData['final_amount'] = $request->final_amount;
            }
            $updateData['platform_service_charge'] = $request->filled('platform_service_charge')
                ? (float) $request->input('platform_service_charge')
                : 0;

            // Update internship
            $internship->update($updateData);

            // Log activity
            StaffActivityController::insertActivity(Auth::id(), "Approved internship: {$internship->internship_title}");

            return response()->json([
                'success' => true,
                'message' => 'Internship approved successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve internship: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject internship application
     */
    public function rejectInternship(Request $request, $id)
    {
        try {
            $internship = Internship::findOrFail($id);
            
            // Update internship status to rejected
            $internship->update([
                'approve_status' => 2, // 2 = rejected
                'rejection_reason' => $request->rejection_reason ?? 'No reason provided'
            ]);

            // Log activity
            StaffActivityController::insertActivity(Auth::id(), "Rejected internship: {$internship->internship_title}");

            return response()->json([
                'success' => true,
                'message' => 'Internship rejected successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject internship: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update internship progress
     */
    public function updateProgress(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'internship_id' => 'required|integer',
                'progress_percentage' => 'required|integer|min:0|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::table('internship_applications')
                ->where('id', $request->internship_id)
                ->update([
                    'progress_percentage' => $request->progress_percentage,
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Progress updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating progress: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics for badge counts
     */
    public function getStatistics()
    {
        try {
            $newCount = Internship::where('approve_status', 0)
                ->whereNull('rejection_reason')
                ->where('complete_status', 0)
                ->count();

            $approvedCount = Internship::where('approve_status', 1)
                ->whereNull('rejection_reason')
                ->where('complete_status', 0)
                ->count();

            $rejectedCount = Internship::whereNotNull('rejection_reason')
                ->count();

            $processingCount = Internship::where('approve_status', 1)
                ->where('complete_status', 0)
                ->where('college_complete_sts', 0)
                ->where('company_complete_sts', 0)
                ->whereNull('rejection_reason')
                ->count();

            // Align completed count with getCompletedData logic:
            // - Include internships which are finalized (complete_status = 1 and company_complete_sts = 1)
            // - Also include company-only internships (internship_type = 2) where company has submitted marks
            $completeCount = Internship::where(function($q) {
                    $q->where(function($q1) {
                        $q1->where('complete_status', 1)
                           ->where('company_complete_sts', 1);
                    })
                    ->orWhere(function($q2) {
                        $q2->where('internship_type', 2)
                           ->where('company_complete_sts', 1);
                    });
                })->count();

            $collegePendingCount = Internship::where('internship_type', 1)
                ->where('company_complete_sts', 1)
                ->where('college_complete_sts', 0)
                ->where('complete_status', 0)
                ->count();

            return response()->json([
                'new_count' => $newCount,
                'approved_count' => $approvedCount,
                'rejected_count' => $rejectedCount,
                'processing_count' => $processingCount,
                'complete_count' => $completeCount,
                'college_pending_count' => $collegePendingCount,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'new_count' => 0,
                'approved_count' => 0,
                'rejected_count' => 0,
                'processing_count' => 0,
                'complete_count' => 0,
                'college_pending_count' => 0,
            ], 500);
        }
    }

    /**
     * Show the form for editing an internship
     */
public function edit($id)
    {
        $internship = Internship::findOrFail($id);

        // Get companies (users with role = 'company')
        $companies = User::where('role', 'User')
            ->where('profile_type', 'Company')
            ->where('active_status', 1)
            ->select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        // Get categories
        $categories = JobCategory::select('category_id', 'category_nm')
            ->orderBy('category_nm', 'asc')
            ->get();

        // If category = 0 (Other was used), fetch requested category/subcategory names
        $requestedCategoryName = null;
        $requestedSubcategoryNames = [];
        if ($internship->category == 0 || empty($internship->sub_categories)) {
            $categoryRequest = CategorySubcategoryRequest::where('internship_id', $internship->id)
                ->where('request_type', 'category')
                ->orderByDesc('id')
                ->first();
            $subcategoryRequests = CategorySubcategoryRequest::where('internship_id', $internship->id)
                ->where('request_type', 'subcategory')
                ->orderByDesc('id')
                ->get();

            $requestedCategoryName = $categoryRequest ? $categoryRequest->requested_name : null;
            $requestedSubcategoryNames = $subcategoryRequests ? $subcategoryRequests->pluck('requested_name')->toArray() : [];
        }

        return view('admin.internship.edit', compact(
            'internship',
            'companies',
            'categories',
            'requestedCategoryName',
            'requestedSubcategoryNames'
        ));
    }

/**
     * Update an internship
     */
    public function update(Request $request, $id)
    {
        $useOtherCategory = $request->boolean('use_other_category');
        $useOtherSubcategory = $request->boolean('use_other_subcategory');

        $validator = Validator::make($request->all(), [
            'internship_title' => 'required|string|max:255',
            'category_id' => $useOtherCategory ? 'nullable|integer' : 'required|integer',
            'sub_category_id' => $useOtherSubcategory ? 'nullable|array' : 'required|array|min:1',
            'sub_category_id.*' => 'integer|exists:tbl_sub_category,sub_category_id',
            'other_category_name' => $useOtherCategory ? 'required|string|max:255' : 'nullable|string',
            'other_subcategory_name' => $useOtherSubcategory ? 'required|string|max:255' : 'nullable|string',
            'company_id' => 'required|integer',
            'company_website' => 'nullable|url|max:255',
            'internship_mode' => 'required|in:Online,Offline,Hybrid,Weekly,Part Time,Full Time',
            'location' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'weeks' => 'required|integer|min:1',
            'hours' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'application_deadline' => 'required|date|before_or_equal:start_date',
            'batch_days' => 'nullable|array',
            'stipend' => 'nullable|numeric|min:0',
            'openings' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $internship = Internship::findOrFail($id);

            // Generate unique slug if title changed
            $slug = $internship->slug;
            if ($request->internship_title !== $internship->internship_title) {
                $slug = Str::slug($request->internship_title);
                $originalSlug = $slug;
                $counter = 1;

                // Include soft-deleted rows — unique index still applies to them
                while (Internship::withTrashed()->where('slug', $slug)->where('id', '!=', $id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }

            $categoryId = $useOtherCategory ? 0 : (int) $request->category_id;
            $subCategoryIds = $useOtherSubcategory ? [] : array_values(array_filter(array_map('intval', (array) $request->input('sub_category_id', []))));

            $internship->update([
                'internship_title' => $request->internship_title,
                'slug' => $slug,
                'category' => $categoryId,
                'sub_categories' => $subCategoryIds,
                'company_id' => $request->company_id,
                'company_website' => $request->company_website,
                'mode' => $request->internship_mode,
                'location' => $request->location,
                'duration' => $request->duration,
                'total_weeks' => $request->weeks,
                'total_hours' => $request->hours,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'stipend' => $request->stipend ?? 0,
                'openings' => $request->openings,
                'application_deadline' => $request->application_deadline,
                'batch_days' => $request->batch_days ?? [],
                'skills' => $this->normalizeTagList($request->required_skills),
                'eligibility_criteria' => $this->normalizeTagList($request->required_eligibility_criteria),
                'perks' => $request->perks ?? [],
                'internship_description' => $request->internship_description,
                'module_brief_description' => $request->module_description,
                'internship_objective' => $request->internship_objective,
                'internship_outcome' => $request->internship_outcome,
            ]);

            StaffActivityController::insertActivity(Auth::id(), "Updated internship: {$request->internship_title}");

            // Handle "Other" category/subcategory requests
            if ($useOtherCategory) {
                $otherCategoryName = $request->input('other_category_name');
                // Remove existing pending category request for this internship
                CategorySubcategoryRequest::where('internship_id', $id)
                    ->where('request_type', 'category')
                    ->where('status', CategorySubcategoryRequest::STATUS_PENDING)
                    ->delete();
                // Create new request
                CategorySubcategoryRequest::create([
                    'request_type' => 'category',
                    'requested_name' => $otherCategoryName,
                    'user_id' => $internship->company_id,
                    'internship_id' => $id,
                    'status' => CategorySubcategoryRequest::STATUS_PENDING,
                ]);
            }

            if ($useOtherSubcategory) {
                $otherSubNames = array_map('trim', explode(',', $request->input('other_subcategory_name')));
                $otherSubNames = array_filter($otherSubNames);
                // Remove existing pending subcategory requests for this internship
                CategorySubcategoryRequest::where('internship_id', $id)
                    ->where('request_type', 'subcategory')
                    ->where('status', CategorySubcategoryRequest::STATUS_PENDING)
                    ->delete();
                // Create new requests
                foreach ($otherSubNames as $subName) {
                    if ($subName !== '') {
                        CategorySubcategoryRequest::create([
                            'request_type' => 'subcategory',
                            'requested_name' => $subName,
                            'user_id' => $internship->company_id,
                            'internship_id' => $id,
                            'status' => CategorySubcategoryRequest::STATUS_PENDING,
                        ]);
                    }
                }
            }

            // Check if we need to return to modal
            if ($request->has('return_to_modal')) {
                return redirect()
                    ->route('admin.internship.management')
                    ->with('success', 'Internship updated successfully!')
                    ->with('openModal', $id);
            }

            return redirect()
                ->route('admin.internship.management')
                ->with('success', 'Internship updated successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update internship: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete an internship
     */
    public function destroy($id)
    {
        try {
            $internship = Internship::findOrFail($id);
            $title = $internship->internship_title;

            DB::beginTransaction();

            // Delete all related records first
            InternshipApplication::where('internship_id', $id)->delete();
            InternshipCollegeSubmit::where('internship_id', $id)->delete();
            InternshipPayment::where('internship_id', $id)->delete();
            InternshipReview::where('internship_id', $id)->delete();
            InternshipWishlist::where('internship_id', $id)->delete();
            InternshipTask::where('internship_id', $id)->delete();
            InternshipMark::where('internship_id', $id)->delete();

            // Delete the internship itself
            $internship->delete();

            DB::commit();

            StaffActivityController::insertActivity(Auth::id(), "Deleted internship: {$title}");

            return response()->json([
                'success' => true,
                'message' => 'Internship deleted successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete internship: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update general instructions for internship
     */
    public function updateInstructions(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'general_instructions' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please enter instructions content before saving.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $internship = Internship::findOrFail($id);

            $internship->update([
                'general_instructions' => $request->general_instructions
            ]);

            try {
                StaffActivityController::insertActivity(Auth::id(), "Updated general instructions for internship: {$internship->internship_title}");
            } catch (\Throwable $e) {
                // Do not block instructions update if activity logging fails
                \Log::warning('Staff activity log failed for updateInstructions: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Instructions updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update instructions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new task for internship
     */
    public function storeTask(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date_time' => 'required|date',
                'day' => 'nullable|string|max:50',
                'module_title' => 'required|string|max:255',
                'module_description' => 'required|string',
                'upload_file' => 'nullable|file|mimes:pdf|max:10240', // Only PDF, 10MB max
                'last_submission_date' => 'required|date',
                'online_link' => 'nullable|url',
                'is_final_assignment' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $internship = Internship::findOrFail($id);
            
            $taskData = [
                'parent_id' => null,
                'student_id' => null,
                'internship_id' => $id,
                'date_time' => $request->date_time,
                'day' => $request->day,
                'module_title' => $request->module_title,
                'module_description' => $request->module_description,
                'last_submission_date' => $request->last_submission_date,
                'online_link' => $request->online_link,
                'is_final_assignment' => $request->boolean('is_final_assignment') ? 1 : 0,
                'status' => 1,
            ];

            // Handle file upload
            if ($request->hasFile('upload_file')) {
                $file = $request->file('upload_file');
                $fileName = time() . '_task_file.pdf';
                $file->move(public_path('uploads/internship_tasks'), $fileName);
                $taskData['upload_file'] = $fileName;
            }

            $task = \App\Models\InternshipTask::create($taskData);

            // Duplicate this master task as per-student child tasks for every student
            // who has an application for this internship. Skip if no applications.
            try {
                $studentIds = InternshipApplication::where('internship_id', $id)
                    ->pluck('user_id')
                    ->filter()
                    ->unique();

                foreach ($studentIds as $studentId) {
                    // Skip if already duplicated for this student
                    $exists = InternshipTask::where('parent_id', $task->id)
                        ->where('student_id', $studentId)
                        ->exists();

                    if ($exists) {
                        continue;
                    }

                    InternshipTask::create([
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
                        'submit_on' => now()->toDateString(),
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error('Failed to duplicate new task for students: ' . $e->getMessage());
            }

            // If this task is marked as final assignment, unset the flag on other tasks
            if ($task->is_final_assignment) {
                try {
                    \App\Models\InternshipTask::where('internship_id', $id)
                        ->where(function ($q) use ($task) {
                            $q->where('id', '!=', $task->id)->where('parent_id', '!=', $task->id);
                        })
                        ->update(['is_final_assignment' => 0]);
                } catch (\Exception $e) {
                    \Log::error('Failed to unset other final assignment flags: ' . $e->getMessage());
                }
            }

            if (Auth::check() && Auth::id()) {
                try {
                    StaffActivityController::insertActivity(Auth::id(), "Added new task '{$request->module_title}' for internship: {$internship->internship_title}");
                } catch (\Exception $e) {
                    \Log::warning('Staff activity log failed for storeTask: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Task added successfully!',
                'task' => $task
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add task: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get tasks for internship (DataTables)
     */
    public function getTasks($id)
    {
        try {
            // Return only parent tasks (master tasks) for the given internship
            $tasks = \App\Models\InternshipTask::where('internship_id', $id)
                ->whereNull('parent_id')
                ->orderBy('date_time', 'desc')
                ->get();

            // Expected submissions = number of applications for this internship
            $expected = \App\Models\InternshipApplication::where('internship_id', $id)->distinct('user_id')->count();

            // For each parent task, compute completed submissions (child tasks where a student submitted)
            $tasksWithCounts = $tasks->map(function($task) use ($expected) {
                $completed = \App\Models\InternshipTask::where('parent_id', $task->id)
                    ->where(function($q) {
                        $q->whereNotNull('student_submit_file')
                          ->orWhereNotNull('student_submit_description')
                          ->orWhereNotNull('student_submit_project_link')
                          ->orWhereNotNull('submit_on')
                          ->orWhere('status', 1);
                    })
                    ->distinct('student_id')
                    ->count('student_id');

                $taskArr = $task->toArray();
                $taskArr['completed_submissions'] = (int) $completed;
                $taskArr['expected_submissions'] = (int) $expected;

                return $taskArr;
            })->toArray();

            return response()->json([
                'success' => true,
                'data' => $tasksWithCounts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tasks: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get payments for an internship (used by Admin Payment History)
     */
    public function getPaymentsData(Request $request, $id)
    {
        try {
            $query = DB::table('tbl_internship_payment as p')
                ->leftJoin('users as u', 'p.user_id', '=', 'u.id')
                ->leftJoin('tbl_internship_application as a', 'p.application_id', '=', 'a.id')
                ->where('p.internship_id', $id);

            // Filters
            if ($request->filled('payment_status')) {
                $query->where('p.payment_status', $request->payment_status);
            }

            if ($request->filled('payment_mode')) {
                $query->where('p.payment_mode', $request->payment_mode);
            }

            if ($request->filled('date_from') && $request->filled('date_to')) {
                try {
                    $from = date('Y-m-d 00:00:00', strtotime($request->date_from));
                    $to = date('Y-m-d 23:59:59', strtotime($request->date_to));
                    $query->whereBetween('p.paid_on', [$from, $to]);
                } catch (\Exception $e) {
                    // ignore invalid dates
                }
            }

            $payments = $query->select('p.*', 'u.name as student_name', 'u.email as student_email')->orderBy('p.paid_on', 'desc')->get();

            // Convert to plain array to avoid JSON encoding issues in the frontend
            $paymentsArray = $payments->map(function($item) {
                return (array) $item;
            })->toArray();

            // Summary computations
            $totalRevenue = (float) array_sum(array_column($paymentsArray, 'total_amount'));
            $successfulCount = count(array_filter($paymentsArray, function($r){ return isset($r['payment_status']) && intval($r['payment_status']) === 1; }));
            $failedCount = count(array_filter($paymentsArray, function($r){ return isset($r['payment_status']) && intval($r['payment_status']) === 2; }));
            $studentIds = array_unique(array_filter(array_column($paymentsArray, 'user_id')));
            $totalStudentsPaid = count($studentIds);

            // Log for debugging
            // \\Log::debug('getPaymentsData called', ['internship_id' => $id, 'filters' => $request->all(), 'payments_count' => count($paymentsArray)]);

            return response()->json([
                'success' => true,
                'data' => $paymentsArray,
                'summary' => [
                    'total_revenue' => $totalRevenue,
                    'total_students_paid' => (int) $totalStudentsPaid,
                    'successful' => (int) $successfulCount,
                    'failed' => (int) $failedCount,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch payments: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Return a single payment's details by transaction id (or id)
     */
    public function getPaymentDetails($txn)
    {
        try {
            $payment = \App\Models\InternshipPayment::where('transaction_id', $txn)
                ->orWhere('id', $txn)
                ->first();

            if (!$payment) {
                return response()->json(['success' => false, 'message' => 'Payment not found'], 404);
            }

            $user = $payment->user_id ? \App\Models\User::find($payment->user_id) : null;
            $application = $payment->application_id ? \App\Models\InternshipApplication::find($payment->application_id) : null;

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $payment->id,
                    'transaction_id' => $payment->transaction_id,
                    'registration_fee' => $payment->registration_fee ?? max(0, (float) $payment->total_amount - (float) $payment->gst_amount),
                    'late_registration_fee' => $payment->late_registration_fee ?? 0,
                    'subtotal' => $payment->subtotal ?? max(0, (float) $payment->total_amount - (float) $payment->gst_amount),
                    'total_amount' => $payment->total_amount,
                    'gst_amount' => $payment->gst_amount,
                    'gst_percentage' => $payment->gst_percentage,
                    'is_late_registration' => (bool) ($payment->is_late_registration ?? false),
                    'payment_mode' => $payment->payment_mode,
                    'payment_status' => $payment->payment_status,
                    'paid_on' => $payment->paid_on,
                    'payment_response_data' => $payment->payment_response_data,
                    'user' => $user ? [ 'id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'contact_no' => $user->contact_no ] : null,
                    'application' => $application ? [ 'id' => $application->id ] : null,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Generate and return receipt PDF for transaction
     */
    public function downloadReceiptPDF($txn)
    {
        try {
            $payment = \App\Models\InternshipPayment::where('transaction_id', $txn)
                ->orWhere('id', $txn)
                ->first();

            if (!$payment) {
                return redirect()->back()->with('error', 'Payment not found');
            }

            $user = $payment->user_id ? \App\Models\User::find($payment->user_id) : null;

            $data = [
                'payment' => $payment,
                'user' => $user,
                'internship' => $payment->internship_id ? \App\Models\Internship::find($payment->internship_id) : null
            ];

            // Try to use Dompdf if available
            if (class_exists('\Dompdf\Dompdf')) {
                $html = view('admin.internship.receipt_pdf', $data)->render();
                $dompdf = new \Dompdf\Dompdf();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $output = $dompdf->output();

                $fileName = 'receipt_' . ($payment->transaction_id ?: $payment->id) . '.pdf';
                return response()->streamDownload(function() use ($output) { echo $output; }, $fileName, [
                    'Content-Type' => 'application/pdf'
                ]);
            }

            // Fallback: return HTML view for manual print
            return view('admin.internship.receipt_pdf', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Update task
     */
    public function updateTask(Request $request, $taskId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date_time' => 'required|date',
                'day' => 'nullable|string|max:50',
                'module_title' => 'required|string|max:255',
                'module_description' => 'required|string',
                'upload_file' => 'nullable|file|mimes:pdf|max:10240', // Only PDF, 10MB max
                'last_submission_date' => 'required|date',
                'online_link' => 'nullable|url',
                'is_final_assignment' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $task = \App\Models\InternshipTask::findOrFail($taskId);
            
            $taskData = [
                'date_time' => $request->date_time,
                'day' => $request->day,
                'module_title' => $request->module_title,
                'module_description' => $request->module_description,
                'last_submission_date' => $request->last_submission_date,
                'online_link' => $request->online_link,
                'is_final_assignment' => $request->boolean('is_final_assignment') ? 1 : 0,
            ];

            // Handle file upload
            if ($request->hasFile('upload_file')) {
                // Delete old file if exists
                if ($task->upload_file && file_exists(public_path('uploads/internship_tasks/' . $task->upload_file))) {
                    unlink(public_path('uploads/internship_tasks/' . $task->upload_file));
                }
                
                $file = $request->file('upload_file');
                $fileName = time() . '_task_file.pdf';
                $file->move(public_path('uploads/internship_tasks'), $fileName);
                $taskData['upload_file'] = $fileName;
            }

            $task->update($taskData);

            // If this is a master task (parent_id is null), propagate updated fields to its child copies
            try {
                if (is_null($task->parent_id)) {
                    $childUpdate = [];
                    $fieldsToPropagate = ['date_time','day','module_title','module_description','last_submission_date','online_link','is_final_assignment','upload_file'];
                    foreach ($fieldsToPropagate as $f) {
                        if (array_key_exists($f, $taskData)) {
                            $childUpdate[$f] = $taskData[$f];
                        }
                    }

                    if (!empty($childUpdate)) {
                        \App\Models\InternshipTask::where('parent_id', $task->id)->update($childUpdate);
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Failed to propagate task update to child copies: ' . $e->getMessage());
            }

            // If this task was set as final assignment, unset the flag on other tasks for this internship
            if (!empty($taskData['is_final_assignment']) && $taskData['is_final_assignment'] == 1) {
                try {
                    \App\Models\InternshipTask::where('internship_id', $task->internship_id)
                        ->where(function ($q) use ($task) {
                            $q->where('id', '!=', $task->id)->where('parent_id', '!=', $task->id);
                        })
                        ->update(['is_final_assignment' => 0]);
                } catch (\Exception $e) {
                    \Log::error('Failed to unset other final assignment flags on update: ' . $e->getMessage());
                }
            }

            if (Auth::check() && Auth::id()) {
                try {
                    StaffActivityController::insertActivity(Auth::id(), "Updated task '{$request->module_title}'");
                } catch (\Exception $e) {
                    \Log::warning('Staff activity log failed for updateTask: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully!',
                'task' => $task
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update task: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete task
     */
    public function deleteTask($taskId)
    {
        try {
            $task = \App\Models\InternshipTask::findOrFail($taskId);
            $title = $task->module_title;

            DB::beginTransaction();

            // If this is a master task (parent_id is null) delete all child student copies
            if (is_null($task->parent_id)) {
                $childTasks = \App\Models\InternshipTask::where('parent_id', $task->id)->get();
                foreach ($childTasks as $ct) {
                    // delete student submitted file if present
                    if ($ct->student_submit_file && file_exists(public_path('uploads/internship_tasks_submit/' . $ct->student_submit_file))) {
                        @unlink(public_path('uploads/internship_tasks_submit/' . $ct->student_submit_file));
                    }
                    // If child has an upload_file (copied from master), try remove it from internship_tasks as well
                    if ($ct->upload_file && file_exists(public_path('uploads/internship_tasks/' . $ct->upload_file))) {
                        @unlink(public_path('uploads/internship_tasks/' . $ct->upload_file));
                    }
                    $ct->delete();
                }

                // delete master upload file
                if ($task->upload_file && file_exists(public_path('uploads/internship_tasks/' . $task->upload_file))) {
                    @unlink(public_path('uploads/internship_tasks/' . $task->upload_file));
                }

                // delete master record
                $task->delete();
            } else {
                // it's a student-specific copy; delete its student submission and file, then delete record
                if ($task->student_submit_file && file_exists(public_path('uploads/internship_tasks_submit/' . $task->student_submit_file))) {
                    @unlink(public_path('uploads/internship_tasks_submit/' . $task->student_submit_file));
                }
                if ($task->upload_file && file_exists(public_path('uploads/internship_tasks/' . $task->upload_file))) {
                    @unlink(public_path('uploads/internship_tasks/' . $task->upload_file));
                }
                $task->delete();
            }

            DB::commit();

            if (Auth::check() && Auth::id()) {
                try {
                    StaffActivityController::insertActivity(Auth::id(), "Deleted task: {$title}");
                } catch (\Exception $e) {
                    \Log::warning('Staff activity log failed for deleteTask: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete task: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Return all student submissions for a master task as JSON.
     */
    public function getTaskSubmissions($id)
    {
        $masterTask = InternshipTask::where('id', $id)->whereNull('parent_id')->first();
        if (!$masterTask) {
            return response()->json(['error' => 'Task not found.'], 404);
        }

        $childTasks = InternshipTask::with('student')
            ->where('parent_id', $masterTask->id)
            ->get();

        $completed = $childTasks->where('status', 1)->count();
        $total = $childTasks->count();
        $pending = $total - $completed;

        $students = [];
        foreach ($childTasks as $idx => $ct) {
            $student = $ct->student;
            $students[] = [
                'sr' => $idx + 1,
                'name' => optional($student)->name ?? 'N/A',
                'email' => optional($student)->email ?? 'N/A',
                'task_title' => $ct->module_title ?? $masterTask->module_title,
                'status' => (int) $ct->status,
                'student_submit_file' => $ct->student_submit_file ?? null,
                'student_submit_description' => $ct->student_submit_description ?? '',
                'student_submit_project_link' => $ct->student_submit_project_link ?? null,
                'submit_on' => $ct->submit_on ? \Carbon\Carbon::parse($ct->submit_on)->format('d M Y, h:i A') : null,
                'student_id' => $ct->student_id,
                'child_task_id' => $ct->id,
                'task_feedback' => $ct->task_feedback ?? null,
            ];
        }

        return response()->json([
            'task_title' => $masterTask->module_title ?? 'Untitled Task',
            'master_task_id' => $masterTask->id,
            'completed' => $completed,
            'pending' => $pending,
            'total' => $total,
            'students' => $students,
        ]);
    }

    /**
     * Return child task details for Note modal (student submission note).
     */
    public function getStudentTaskNote($taskId, $studentId)
    {
        $childTask = InternshipTask::with('student')
            ->where('parent_id', $taskId)
            ->where('student_id', $studentId)
            ->first();

        if (!$childTask) {
            return response()->json(['error' => 'Task not found.'], 404);
        }

        return response()->json([
            'student_name' => optional($childTask->student)->name ?? 'N/A',
            'task_title' => $childTask->module_title ?? 'Untitled Task',
            'status' => (int) $childTask->status,
            'submit_on' => $childTask->submit_on ? \Carbon\Carbon::parse($childTask->submit_on)->format('d M Y, h:i A') : null,
            'student_submit_file' => $childTask->student_submit_file ?? null,
            'student_submit_description' => $childTask->student_submit_description ?? '',
            'student_submit_project_link' => $childTask->student_submit_project_link ?? null,
            'task_feedback' => $childTask->task_feedback ?? null,
        ]);
    }

    /**
     * Get task feedback for a child task.
     */
    public function getTaskFeedback($taskId, $studentId)
    {
        $childTask = InternshipTask::where('parent_id', $taskId)
            ->where('student_id', $studentId)
            ->first();

        if (!$childTask) {
            return response()->json(['error' => 'Task not found.'], 404);
        }

        return response()->json([
            'task_feedback' => $childTask->task_feedback ?? null,
            'task_title' => $childTask->module_title ?? 'Untitled Task',
            'student_name' => optional($childTask->student)->name ?? 'N/A',
            'status' => (int) $childTask->status,
        ]);
    }

    /**
     * Save or update task feedback for a child task.
     */
    public function saveTaskFeedback(Request $request)
    {
        $request->validate([
            'task_id' => 'required|integer',
            'student_id' => 'required|integer',
            'feedback' => 'required|string|max:5000',
        ]);

        $childTask = InternshipTask::where('parent_id', $request->input('task_id'))
            ->where('student_id', $request->input('student_id'))
            ->first();

        if (!$childTask) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $childTask->task_feedback = $request->input('feedback');
        $childTask->save();

        return response()->json([
            'success' => true,
            'message' => 'Feedback saved successfully.',
            'task_feedback' => $childTask->task_feedback,
        ]);
    }

    /**
     * Log admin activity
     */
    private function logActivity($description)
    {
        try {
            StaffActivityController::insertActivity(Auth::id(), $description);
        } catch (\Exception $e) {
            // Log error but don't fail the main operation
            \Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }

    /**
     * Display certificate management page
     */
    public function certificates()
    {
        $this->logActivity('Accessed certificate management page');

        $internships = Internship::with(['company'])
            ->withCount('internshipApplications')
            ->where('approve_status', 1)
            ->where(function ($q) {
                $q->where('company_complete_sts', 1)
                    ->orWhere('college_complete_sts', 1)
                    ->orWhere('complete_status', 1);
            })
            ->orderByDesc('updated_at')
            ->get();

        return view('admin.internship.certificates', compact('internships'));
    }

    /**
     * Get students with certificates for a specific internship
     */
    public function getCertificateStudents($id)
    {
        try {
            $internship = Internship::with('company')->findOrFail($id);
            $internshipType = (int) ($internship->internship_type ?? 0);
            $companyCompleted = (int) $internship->company_complete_sts === 1;
            $collegeCompleted = (int) $internship->college_complete_sts === 1;

            $applications = InternshipApplication::with(['user.college.university'])
                ->where('internship_id', $internship->id)
                ->orderBy('applied_on', 'desc')
                ->get();

            $students = $applications->map(function ($app) use ($internship, $internshipType, $companyCompleted, $collegeCompleted) {
                $user = $app->user;
                $university = 'N/A';
                if ($user && $user->college && $user->college->university) {
                    $university = $user->college->university->university_name;
                }

                $showCompany = $companyCompleted;
                $showCollege = $collegeCompleted && $internshipType === 1;

                return [
                    'application_id' => $app->id,
                    'user_id' => $user->id ?? null,
                    'name' => $user->name ?? 'N/A',
                    'email' => $user->email ?? 'N/A',
                    'university' => $university,
                    'completion_date' => $app->applied_on
                        ? $app->applied_on->format('d M Y')
                        : ($internship->end_date ? $internship->end_date->format('d M Y') : 'N/A'),
                    'show_company_certificate' => $showCompany,
                    'show_college_certificate' => $showCollege,
                    'company_certificate_url' => $showCompany
                        ? route('admin.internship.certificate.preview', [
                            'applicationId' => $app->id,
                            'type' => 'company',
                        ])
                        : null,
                    'college_certificate_url' => $showCollege
                        ? route('admin.internship.certificate.preview', [
                            'applicationId' => $app->id,
                            'type' => 'college',
                        ])
                        : null,
                    'profile_url' => !empty($user->id) ? url('admin/candidate-profile/' . $user->id) : null,
                ];
            })->values();

            $this->logActivity('Viewed certificates for internship ID: ' . $id);

            return response()->json([
                'success' => true,
                'internship' => [
                    'id' => $internship->id,
                    'title' => $internship->internship_title,
                    'company' => optional($internship->company)->name,
                    'internship_type' => $internshipType,
                    'company_complete' => $companyCompleted,
                    'college_complete' => $collegeCompleted,
                ],
                'students' => $students,
                'statistics' => [
                    'total_students' => $students->count(),
                    'company_certificates' => $students->where('show_company_certificate', true)->count(),
                    'college_certificates' => $students->where('show_college_certificate', true)->count(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching certificate data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download certificate for a specific student
     */
    public function downloadCertificate($studentId)
    {
        try {
            // In production, fetch certificate data
            // $certificate = DB::table('certificates')
            //     ->join('internship_enrollments', 'certificates.enrollment_id', '=', 'internship_enrollments.id')
            //     ->join('users', 'internship_enrollments.student_id', '=', 'users.id')
            //     ->join('internships', 'internship_enrollments.internship_id', '=', 'internships.id')
            //     ->where('users.id', $studentId)
            //     ->select(
            //         'users.name as student_name',
            //         'internships.title as internship_title',
            //         'internships.company_name',
            //         'certificates.certificate_number',
            //         'certificates.issue_date',
            //         'internships.duration'
            //     )
            //     ->first();

            // if (!$certificate) {
            //     return response()->json(['error' => 'Certificate not found'], 404);
            // }

            // Generate PDF using a library like TCPDF or DomPDF
            // $pdf = PDF::loadView('admin.internship.certificate-pdf', compact('certificate'));
            // 
            // // Update download count
            // DB::table('certificates')
            //     ->where('enrollment_id', $certificate->enrollment_id)
            //     ->increment('download_count');
            //
            // // Log activity
            // $this->logActivity('Downloaded certificate for student: ' . $certificate->student_name);
            //
            // return $pdf->download('Certificate_' . $certificate->certificate_number . '.pdf');

            // For demonstration, return JSON
            $this->logActivity('Downloaded certificate for student ID: ' . $studentId);
            
            return response()->json([
                'success' => true,
                'message' => 'Certificate download initiated',
                'student_id' => $studentId
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error downloading certificate: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download all certificates for an internship as ZIP
     */
    public function downloadAllCertificates($internshipId)
    {
        try {
            // In production, fetch all certificates for the internship
            // $students = DB::table('internship_enrollments')
            //     ->join('users', 'internship_enrollments.student_id', '=', 'users.id')
            //     ->join('certificates', 'internship_enrollments.id', '=', 'certificates.enrollment_id')
            //     ->join('internships', 'internship_enrollments.internship_id', '=', 'internships.id')
            //     ->where('internship_enrollments.internship_id', $internshipId)
            //     ->where('internship_enrollments.status', 'completed')
            //     ->get();

            // // Create ZIP file
            // $zip = new \ZipArchive();
            // $zipFileName = 'certificates_internship_' . $internshipId . '_' . time() . '.zip';
            // $zipPath = storage_path('app/temp/' . $zipFileName);
            //
            // if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
            //     foreach ($students as $student) {
            //         // Generate PDF for each student
            //         $pdf = PDF::loadView('admin.internship.certificate-pdf', compact('student'));
            //         $pdfContent = $pdf->output();
            //         $zip->addFromString('Certificate_' . $student->name . '.pdf', $pdfContent);
            //     }
            //     $zip->close();
            // }
            //
            // // Log activity
            // $this->logActivity('Downloaded all certificates for internship ID: ' . $internshipId);
            //
            // return response()->download($zipPath)->deleteFileAfterSend(true);

            // For demonstration
            $this->logActivity('Downloaded all certificates for internship ID: ' . $internshipId);
            
            return response()->json([
                'success' => true,
                'message' => 'All certificates download initiated',
                'internship_id' => $internshipId
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error downloading certificates: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export certificates data to Excel/CSV
     */
    public function exportCertificates()
    {
        try {
            // In production, fetch all certificate data
            // $certificates = DB::table('certificates')
            //     ->join('internship_enrollments', 'certificates.enrollment_id', '=', 'internship_enrollments.id')
            //     ->join('users', 'internship_enrollments.student_id', '=', 'users.id')
            //     ->join('internships', 'internship_enrollments.internship_id', '=', 'internships.id')
            //     ->select(
            //         'certificates.certificate_number',
            //         'users.name as student_name',
            //         'users.email',
            //         'internships.title as internship_title',
            //         'internships.company_name',
            //         'certificates.issue_date',
            //         'internship_enrollments.completion_date',
            //         'certificates.download_count'
            //     )
            //     ->get();

            // // Use Laravel Excel package to export
            // return Excel::download(new CertificatesExport($certificates), 'certificates_' . date('Y-m-d') . '.xlsx');

            // For demonstration
            $this->logActivity('Exported certificates data');
            
            return response()->json([
                'success' => true,
                'message' => 'Certificates export initiated'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error exporting certificates: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Build shared certificate payload for a student application.
     *
     * @param  int  $applicationId
     * @param  string  $type  company|college
     * @return array
     */
    protected function buildCertificateData(int $applicationId, string $type): array
    {
        $type = strtolower($type);
        if (!in_array($type, ['company', 'college'], true)) {
            abort(404, 'Invalid certificate type.');
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

        $internshipType = (int) ($internship->internship_type ?? 0);

        if ($type === 'college' && $internshipType !== 1) {
            abort(403, 'College certificate is only available for college-associated internships.');
        }

        if ($type === 'company' && (int) $internship->company_complete_sts !== 1) {
            abort(403, 'Company certificate is available only after the company side completes the internship.');
        }

        if ($type === 'college' && (int) $internship->college_complete_sts !== 1) {
            abort(403, 'College certificate is available only after the college side completes the internship.');
        }

        $this->authorizeCertificateAccess($application, $type);

        $student = $application->user;
        $company = $internship->company;

        // Prefer enrollment college/degree snapshot, fall back to user profile
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
            $degree = \App\Models\Degree::find($application->degree_id);
        }
        if (!$degree && $student && $student->degree) {
            $degree = $student->degree;
        }

        $university = $college && $college->university ? $college->university : null;
        $setting = \App\Models\Setting::first();

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

        // Logo absolute paths for Dompdf + public URLs for browser preview
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

        // College authorized signatory signature
        $collegeSignaturePath = null;
        $collegeSignatureUrl = null;
        if ($college && !empty($college->college_signature)) {
            $rel = 'uploads/college/' . $college->college_signature;
            if (file_exists(public_path($rel))) {
                $collegeSignaturePath = public_path($rel);
                $collegeSignatureUrl = asset($rel);
            }
        }

        // Director signature
        $directorSignaturePath = null;
        $directorSignatureUrl = null;
        if ($setting && !empty($setting->director_signature)) {
            $rel = 'uploads/logo_img/' . $setting->director_signature;
            if (file_exists(public_path($rel))) {
                $directorSignaturePath = public_path($rel);
                $directorSignatureUrl = asset($rel);
            }
        }

        // Round seal
        $roundSealPath = null;
        $roundSealUrl = null;
        if ($setting && !empty($setting->round_seal)) {
            $rel = 'uploads/logo_img/' . $setting->round_seal;
            if (file_exists(public_path($rel))) {
                $roundSealPath = public_path($rel);
                $roundSealUrl = asset($rel);
            }
        }

        // Company signatory signature
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

        $isCollegeLogin = Auth::guard('college')->check() || Auth::guard('college_staff')->check();
        $isStudentOwner = Auth::check()
            && optional(Auth::user())->role === 'User'
            && (int) $application->user_id === (int) Auth::id();

        if ($isStudentOwner && !empty($internship->slug)) {
            $backUrl = route('my-internship-details', $internship->slug) . '#certificate';
        } elseif ($isCollegeLogin) {
            $backUrl = route('admin.college-internship.view', $internship->id) . '#ci-students';
        } else {
            $backUrl = url('admin/internship/view/' . $internship->id) . '#students';
        }

        return [
            'type' => $type,
            'certSettings' => \App\Models\CertificateSetting::forType($type),
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
            'download_url' => route('admin.internship.certificate.download', [
                'applicationId' => $application->id,
                'type' => $type,
            ]),
            'preview_url' => route('admin.internship.certificate.preview', [
                'applicationId' => $application->id,
                'type' => $type,
            ]),
            'back_url' => $backUrl,
            'is_college_login' => $isCollegeLogin,
        ];
    }

    /**
     * Restrict certificate access for college login accounts.
     */
    protected function authorizeCertificateAccess(InternshipApplication $application, string $type): void
    {
        $isCollegeLogin = Auth::guard('college')->check() || Auth::guard('college_staff')->check();
        if ($isCollegeLogin) {
            if ($type !== 'college') {
                abort(403, 'College accounts can only access college certificates.');
            }

            $loggedCollegeId = Auth::guard('college')->check()
                ? (int) Auth::guard('college')->id()
                : (int) (Auth::guard('college_staff')->user()->college_id ?? 0);

            $studentCollegeId = (int) ($application->college_id ?? optional($application->user)->college_id ?? 0);

            if (!$loggedCollegeId || $studentCollegeId !== $loggedCollegeId) {
                abort(403, 'You are not authorized to view this certificate.');
            }

            if (Auth::guard('college_staff')->check()) {
                $staffId = (int) Auth::guard('college_staff')->id();
                if ((int) ($application->assigned_staff_id ?? 0) !== $staffId) {
                    abort(403, 'This certificate is not assigned to you.');
                }
            }

            return;
        }

        $user = Auth::user();
        if ($user && $user->role === 'User') {
            // Company accounts may download certificates for applicants of their own internships
            if (($user->profile_type ?? '') === 'Company') {
                $internship = $application->relationLoaded('internship')
                    ? $application->internship
                    : Internship::find($application->internship_id);

                if (!$internship || (int) $internship->company_id !== (int) $user->id) {
                    abort(403, 'You are not authorized to view this certificate.');
                }

                return;
            }

            // Student accounts may only access their own certificates
            if ((int) $application->user_id !== (int) $user->id) {
                abort(403, 'You are not authorized to view this certificate.');
            }

            return;
        }

        if (!Auth::check()) {
            abort(403, 'Unauthorized access.');
        }
    }

    /**
     * Convert a local image file to a base64 data-URI for Dompdf.
     * Avoids file:// path issues (spaces, Windows paths) that cause "Image type unknown".
     */
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

        // Prefer GD resize/normalize so Dompdf always gets a safe PNG/JPEG
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

    /**
     * Resize/convert an image to a Dompdf-safe base64 data URI.
     */
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

        // Keep JPEG as JPEG for photos; everything else as PNG (supports transparency)
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

    /**
     * Preview company/college certificate in browser.
     */
    public function previewStudentCertificate($applicationId, $type)
    {
        $data = $this->buildCertificateData((int) $applicationId, $type);
        $this->logActivity('Previewed ' . $type . ' certificate for application ID: ' . $applicationId);

        return view('admin.internship.certificate-preview', $data);
    }

    /**
     * Download company/college certificate as PDF.
     */
    public function downloadStudentCertificate($applicationId, $type)
    {
        $data = $this->buildCertificateData((int) $applicationId, $type);
        $fileName = strtoupper($type) . '_Certificate_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $data['student_name']) . '_' . $data['certificate_no'] . '.pdf';

        $this->logActivity('Downloaded ' . $type . ' certificate for application ID: ' . $applicationId);

        if (class_exists('\Dompdf\Dompdf')) {
            // Same certificate-body HTML as Admin Preview (forPdf images = base64)
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

        // Fallback: printable HTML
        return view('admin.internship.certificate-pdf', $data);
    }

    // ==================== INTERNSHIP COMPLETION / GRADING ====================

    /**
     * Save marks via AJAX (auto-save on input change)
     * Inserts or updates a single criteria mark for a student.
     * Stores snapshot of criteria_name and max_marks for future-proof consistency.
     */
    public function saveMarks(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'internship_id'  => 'required|integer',
            'student_id'     => 'required|integer',
            'criteria_id'    => 'required|integer',
            'criteria_name'  => 'required|string|max:255',
            'max_marks'      => 'required|integer|min:0',
            'marks'          => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        try {
            $internship = Internship::findOrFail($request->internship_id);

            // Prevent modifying marks after company submission / finalisation
            if ($internship->company_complete_sts == 1 || $internship->complete_status == 1) {
                return response()->json(['success' => false, 'message' => 'Marks cannot be modified after submission.'], 422);
            }

            if ($request->marks > $request->max_marks) {
                return response()->json(['success' => false, 'message' => "Marks cannot exceed {$request->max_marks}"], 422);
            }

            $mark = InternshipMark::updateOrCreate(
                [
                    'internship_id' => $request->internship_id,
                    'student_id'    => $request->student_id,
                    'criteria_id'   => $request->criteria_id,
                ],
                [
                    'criteria_name' => $request->criteria_name,
                    'max_marks'     => $request->max_marks,
                    'marks'         => $request->marks,
                    'status'        => 0, // draft
                ]
            );

            return response()->json(['success' => true, 'message' => 'Marks saved', 'data' => $mark]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Save feedback via AJAX (auto-save on textarea change)
     * Always stores in tbl_internship_application.company_feedback
     * (applies to both internship_type 1 and 2)
     */
    public function saveFeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'internship_id' => 'required|integer',
            'student_id'    => 'required|integer',
            'feedback'      => 'nullable|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed'], 422);
        }

        try {
            $internship = Internship::findOrFail($request->internship_id);

            // Prevent modifying feedback after company submission / finalisation
            if ($internship->company_complete_sts == 1 || $internship->complete_status == 1) {
                return response()->json(['success' => false, 'message' => 'Feedback cannot be modified after submission.'], 422);
            }

            InternshipApplication::where('internship_id', $request->internship_id)
                ->where('user_id', $request->student_id)
                ->update(['company_feedback' => $request->feedback]);

            return response()->json(['success' => true, 'message' => 'Feedback saved']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Fetch saved marks for all students in an internship (used on page load)
     * Returns snapshot-based data (criteria_name, max_marks stored with each mark row)
     * and feedback from tbl_internship_application.
     */
    public function fetchMarks($internshipId)
    {
        try {
            $internship = Internship::findOrFail($internshipId);

            // Fetch feedback from applications
            $applications = InternshipApplication::where('internship_id', $internshipId)
                ->pluck('company_feedback', 'user_id');

            $marks = InternshipMark::where('internship_id', $internshipId)
                ->get()
                ->groupBy('student_id')
                ->map(function ($studentMarks) use ($applications) {
                    $studentId = $studentMarks->first()->student_id;
                    return [
                        'feedback' => $applications[$studentId] ?? null,
                        'status'   => $studentMarks->first()->status,
                        'criteria' => $studentMarks->mapWithKeys(function ($m) {
                            return [$m->criteria_id => [
                                'marks'         => $m->marks,
                                'criteria_name' => $m->criteria_name,
                                'max_marks'     => $m->max_marks,
                            ]];
                        }),
                    ];
                });

            return response()->json(['success' => true, 'data' => $marks]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Final submit: validate all marks, set status=1, mark internship complete
     */
    public function submitInternship(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'internship_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed'], 422);
        }

        try {
            $internship = Internship::findOrFail($request->internship_id);

            // Ensure there are enrolled students
            $studentIds = InternshipApplication::where('internship_id', $internship->id)
                ->pluck('user_id');

            if ($studentIds->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No students enrolled in this internship'], 422);
            }

            // Validate every student has grade configured + marks saved
            // (only required for type 1 — type 2 is feedback-only)
            $missingStudents = [];
            $noGradeStudents = [];
            if ($internship->internship_type != 2) {
                foreach ($studentIds as $studentId) {
                    $student = User::find($studentId);
                    $studentName = $student ? $student->name : "ID: $studentId";
                    $collegeId = $student ? $student->college_id : null;
                    $degreeId = $student ? $student->degree_id : null;

                    $criteriaCount = 0;
                    if ($collegeId) {
                        $grade = Grade::where('college_id', $collegeId)
                            ->when($degreeId, fn ($q) => $q->where('course_id', $degreeId))
                            ->first();

                        if ($grade) {
                            $section = GradeSection::where('grade_id', $grade->id)
                                ->where('title', 'Industry Marks')
                                ->first();
                            if ($section) {
                                $criteriaCount = GradeCriterion::where('section_id', $section->id)
                                    ->whereNull('deleted_at')
                                    ->count();
                            }
                        }
                    }

                    if ($criteriaCount === 0) {
                        $noGradeStudents[] = $studentName;
                        continue;
                    }

                    $savedCount = InternshipMark::where('internship_id', $internship->id)
                        ->where('student_id', $studentId)
                        ->whereNotNull('marks')
                        ->count();

                    if ($savedCount < $criteriaCount) {
                        $missingStudents[] = $studentName;
                    }
                }
            }

            if (!empty($noGradeStudents)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Grade is not configured for students: ' . implode(', ', array_slice($noGradeStudents, 0, 5))
                        . '. Please configure Industry Marks in Manage Grade.'
                ], 422);
            }

            if (!empty($missingStudents)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing marks for students: ' . implode(', ', array_slice($missingStudents, 0, 5))
                ], 422);
            }

            // Validate feedback exists in applications
            $missingFeedback = [];
            foreach ($studentIds as $studentId) {
                $app = InternshipApplication::where('internship_id', $internship->id)
                    ->where('user_id', $studentId)
                    ->first();
                if (!$app || empty($app->company_feedback)) {
                    $student = User::find($studentId);
                    $missingFeedback[] = $student ? $student->name : "ID: $studentId";
                }
            }

            if (!empty($missingFeedback)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing feedback for students: ' . implode(', ', array_slice($missingFeedback, 0, 5))
                ], 422);
            }

            DB::beginTransaction();

            // Set all industry marks status = 1 (submitted)
            InternshipMark::where('internship_id', $internship->id)
                ->update(['status' => 1]);

            // Mark company/industry side as completed
            $internship->update(['company_complete_sts' => 1]);

            // If this is a company-only internship (type 2), finalise immediately.
            if ($internship->internship_type == 2) {
                $internship->update(['complete_status' => 1]);
                InternshipApplication::where('internship_id', $internship->id)
                    ->update(['complete_status' => 1]);
            } else {
                // Otherwise, require college side to be completed as well
                if ($internship->college_complete_sts == 1) {
                    $internship->update(['complete_status' => 1]);
                    // Update all applications' complete_status
                    InternshipApplication::where('internship_id', $internship->id)
                        ->update(['complete_status' => 1]);
                }
            }

            DB::commit();

            $this->logActivity('Completed industry marks for internship ID: ' . $internship->id);

            return response()->json([
                'success' => true,
                'message' => 'Internship completed successfully! All grades have been finalized.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    // ===================================================================
    //  COLLEGE MARKS MODULE
    // ===================================================================

    /**
     * Show the College Marks Update page with filters.
     * Super Admin sees University → College → Course dropdowns.
     * College login auto-selects their own college.
     */
    public function collegeMarksPage()
    {
        $isSuperAdmin = auth()->check() && !auth()->guard('college')->check() && !auth()->guard('college_staff')->check();
        $isCollegeLogin = auth()->guard('college')->check() || auth()->guard('college_staff')->check();

        $collegeId = null;
        $universityId = null;

        if ($isCollegeLogin) {
            $college = auth()->guard('college')->user() ?? optional(auth()->guard('college_staff')->user())->college;
            $collegeId = $college ? $college->id : null;
            $universityId = $college ? $college->university_id : null;
        }

        // Dropdowns for super admin
        $universities = $isSuperAdmin ? University::orderBy('university_name')->whereNull('deleted_at')->get() : collect();

        return view('admin.internship.college-marks', compact(
            'isSuperAdmin', 'isCollegeLogin', 'collegeId', 'universityId', 'universities'
        ));
    }

    /**
     * AJAX: Fetch colleges for a university (dependent dropdown).
     */
    public function getCollegesByUniversity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'university_id' => 'required|integer|exists:tbl_university,id',
        ]);

        if ($validator->fails()) {
            return response()->json([], 422);
        }

        $colleges = College::where('university_id', $request->university_id)
            ->orderBy('college_name')
            ->get(['id', 'college_name']);

        return response()->json($colleges);
    }

    /**
     * AJAX: Fetch courses (degrees) linked to a college via grades table.
     */
    public function getCoursesByCollege(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'college_id' => 'required|integer|exists:tbl_college,id',
        ]);

        if ($validator->fails()) {
            return response()->json([], 422);
        }

        $courseIds = Grade::where('college_id', $request->college_id)
            ->pluck('course_id')
            ->unique()
            ->filter();

        $courses = \App\Models\Degree::whereIn('degree_id', $courseIds)
            ->orderBy('degree_name')
            ->get(['degree_id', 'degree_name']);

        return response()->json($courses);
    }

    /**
     * AJAX: Load students for College Marks DataTable based on filters.
     * Returns internship + students + college criteria + saved marks.
     * Filters: internship_type=1, company_complete_sts=1, college_complete_sts=0, complete_status=0
     */
    public function getCollegeMarksData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'college_id' => 'required|integer',
            'course_id'  => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Please select all filters'], 422);
        }

        $collegeId = (int) $request->college_id;
        $courseId   = (int) $request->course_id;

        // Find internship IDs that have students from this college + course
        $internshipIds = InternshipApplication::whereHas('user', function ($q) use ($collegeId, $courseId) {
                $q->where('college_id', $collegeId)
                  ->where('degree_id', $courseId);
            })
            ->pluck('internship_id')
            ->unique();

        if ($internshipIds->isEmpty()) {
            return response()->json([
                'success' => true,
                'internships' => [],
                'message' => 'No internships found for the selected filters.'
            ]);
        }

        // Exclude internships where this specific college+course has already submitted
        $alreadySubmittedInternshipIds = InternshipCollegeSubmit::where('college_id', $collegeId)
            ->where('course_id', $courseId)
            ->pluck('internship_id');

        // Load only PENDING internships (exclude already submitted by this college+course)
        $internships = Internship::whereIn('id', $internshipIds)
            ->whereNotIn('id', $alreadySubmittedInternshipIds) // pending only
            ->where('internship_type', 1)           // Industry+College type only
            ->where('company_complete_sts', 1)       // Company side completed
            ->where('approve_status', 1)             // Approved only
            ->get();

        if ($internships->isEmpty()) {
            return response()->json([
                'success' => true,
                'internships' => [],
                'message' => 'No pending internships found. All college marks may already be submitted, or company marks are not yet complete.'
            ]);
        }

        // Find grade for this college + course → "College Marks" section → criteria
        $grade = Grade::where('college_id', $collegeId)
            ->where('course_id', $courseId)
            ->first();

        $collegeCriteria = collect();
        if ($grade) {
            $collegeSections = GradeSection::where('grade_id', $grade->id)
                ->where('title', 'College Marks')
                ->pluck('id');

            $collegeCriteria = GradeCriterion::whereIn('section_id', $collegeSections)
                ->whereNull('deleted_at')
                ->get();
        }

        $criteriaIds = $collegeCriteria->pluck('id')->toArray();
        $internshipIdList = $internships->pluck('id')->toArray();

        // Eager load all applications for these internships + college + course in one query
        $allApplications = InternshipApplication::with(['user.college.university'])
            ->whereIn('internship_id', $internshipIdList)
            ->whereHas('user', function ($q) use ($collegeId, $courseId) {
                $q->where('college_id', $collegeId)
                  ->where('degree_id', $courseId);
            })
            ->get()
            ->groupBy('internship_id');

        // Batch load all saved marks for these internships + criteria in one query
        $allMarks = InternshipMark::whereIn('internship_id', $internshipIdList)
            ->whereIn('criteria_id', $criteriaIds)
            ->get()
            ->groupBy('internship_id');

        // Build data per internship (no N+1 queries)
        $result = [];
        foreach ($internships as $internship) {
            $applications = $allApplications->get($internship->id, collect());
            if ($applications->isEmpty()) continue;

            $internshipMarks = $allMarks->get($internship->id, collect())->groupBy('student_id');

            $students = [];
            foreach ($applications as $app) {
                $student = $app->user;
                if (!$student) continue;

                $studentMarks = $internshipMarks->get($student->id, collect())->keyBy('criteria_id');

                $students[] = [
                    'id'              => $student->id,
                    'name'            => $student->name,
                    'college_name'    => optional($student->college)->college_name ?? 'N/A',
                    'university_name' => optional(optional($student->college)->university)->university_name ?? 'N/A',
                    'saved_marks'     => $studentMarks,
                    'feedback'        => $app->college_feedback ?? '',
                ];
            }

            $result[] = [
                'internship_id'       => $internship->id,
                'internship_title'    => $internship->internship_title,
                'college_complete_sts'=> $internship->college_complete_sts,
                'college_submitted'   => $alreadySubmittedInternshipIds->contains($internship->id),
                'complete_status'     => $internship->complete_status,
                'students'            => $students,
            ];
        }

        return response()->json([
            'success'         => true,
            'internships'     => $result,
            'college_criteria'=> $collegeCriteria,
        ]);
    }

    /**
     * AJAX: Auto-save a single college mark.
     */
    public function saveCollegeMarks(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'internship_id'  => 'required|integer',
            'student_id'     => 'required|integer',
            'criteria_id'    => 'required|integer',
            'criteria_name'  => 'required|string|max:255',
            'max_marks'      => 'required|integer|min:0',
            'marks'          => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        try {
            $internship = Internship::findOrFail($request->internship_id);
            if ((int) $internship->college_complete_sts === 1 || (int) $internship->complete_status === 1) {
                return response()->json(['success' => false, 'message' => 'College marks cannot be modified after submission.'], 422);
            }

            if ($request->marks > $request->max_marks) {
                return response()->json(['success' => false, 'message' => "Marks cannot exceed {$request->max_marks}"], 422);
            }

            $mark = InternshipMark::updateOrCreate(
                [
                    'internship_id' => $request->internship_id,
                    'student_id'    => $request->student_id,
                    'criteria_id'   => $request->criteria_id,
                ],
                [
                    'criteria_name' => $request->criteria_name,
                    'max_marks'     => $request->max_marks,
                    'marks'         => $request->marks,
                    'status'        => 0,
                ]
            );

            return response()->json(['success' => true, 'message' => 'Marks saved', 'data' => $mark]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * AJAX: Auto-save college feedback.
     */
    public function saveCollegeFeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'internship_id' => 'required|integer',
            'student_id'    => 'required|integer',
            'feedback'      => 'nullable|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed'], 422);
        }

        try {
            $internship = Internship::findOrFail($request->internship_id);
            if ((int) $internship->college_complete_sts === 1 || (int) $internship->complete_status === 1) {
                return response()->json(['success' => false, 'message' => 'College feedback cannot be modified after submission.'], 422);
            }
            InternshipApplication::where('internship_id', $request->internship_id)
                ->where('user_id', $request->student_id)
                ->update(['college_feedback' => $request->feedback]);

            return response()->json(['success' => true, 'message' => 'Feedback saved']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * AJAX: Final submit of college marks for an internship.
     * Sets college_complete_sts=1. If company side also done, sets complete_status=1.
     */
    public function submitCollegeMarks(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'internship_id' => 'required|integer',
            'college_id'    => 'required|integer',
            'course_id'     => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed'], 422);
        }

        try {
            $internship = Internship::findOrFail($request->internship_id);
            $collegeId  = (int) $request->college_id;
            $courseId   = (int) $request->course_id;

            // Get students from this college+course enrolled in this internship
            $studentIds = InternshipApplication::where('internship_id', $internship->id)
                ->whereHas('user', function ($q) use ($collegeId, $courseId) {
                    $q->where('college_id', $collegeId)
                      ->where('degree_id', $courseId);
                })
                ->pluck('user_id');

            if ($studentIds->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No students found'], 422);
            }

            // Find college criteria to validate against — MUST match same college+course used during data load
            $grade = Grade::where('college_id', $collegeId)
                ->where('course_id', $courseId)
                ->first();
            $collegeCriteriaIds = collect();
            if ($grade) {
                $collegeSectionIds = GradeSection::where('grade_id', $grade->id)
                    ->where('title', 'College Marks')
                    ->pluck('id');
                $collegeCriteriaIds = GradeCriterion::whereIn('section_id', $collegeSectionIds)
                    ->whereNull('deleted_at')
                    ->pluck('id');
            }

            // Block submit when College Marks grade/criteria are not configured
            if ($collegeCriteriaIds->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No grade configured. Please configure College Marks grade criteria for this course before submitting.'
                ], 422);
            }

            // Pre-load student names to avoid N+1
            $studentNames = User::whereIn('id', $studentIds)->pluck('name', 'id');

            // Batch load mark counts per student in one query
            $markCounts = InternshipMark::where('internship_id', $internship->id)
                ->whereIn('student_id', $studentIds)
                ->whereIn('criteria_id', $collegeCriteriaIds)
                ->where('marks', '>', 0)
                ->selectRaw('student_id, COUNT(*) as cnt')
                ->groupBy('student_id')
                ->pluck('cnt', 'student_id');

            $missingStudents = [];
            foreach ($studentIds as $studentId) {
                if (($markCounts[$studentId] ?? 0) < $collegeCriteriaIds->count()) {
                    $missingStudents[] = $studentNames[$studentId] ?? "ID: $studentId";
                }
            }

            if (!empty($missingStudents)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing college marks for: ' . implode(', ', array_slice($missingStudents, 0, 5))
                ], 422);
            }

            // Batch load feedback status for all students
            $feedbackMap = InternshipApplication::where('internship_id', $internship->id)
                ->whereIn('user_id', $studentIds)
                ->pluck('college_feedback', 'user_id');

            $missingFeedback = [];
            foreach ($studentIds as $studentId) {
                if (empty($feedbackMap[$studentId] ?? '')) {
                    $missingFeedback[] = $studentNames[$studentId] ?? "ID: $studentId";
                }
            }

            if (!empty($missingFeedback)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Missing college feedback for: ' . implode(', ', array_slice($missingFeedback, 0, 5))
                ], 422);
            }

            DB::beginTransaction();

            // Set college marks status = 1 (submitted) for these students + criteria
            InternshipMark::where('internship_id', $internship->id)
                ->whereIn('student_id', $studentIds)
                ->whereIn('criteria_id', $collegeCriteriaIds)
                ->update(['status' => 1]);

            // Record this college+course as submitted
            InternshipCollegeSubmit::firstOrCreate([
                'internship_id' => $internship->id,
                'college_id'    => $collegeId,
                'course_id'     => $courseId,
            ], ['submitted_at' => now()]);

            // Check if ALL distinct college+course groups for this internship have now submitted
            $allCollegeCombos = InternshipApplication::where('internship_id', $internship->id)
                ->join('users', 'users.id', '=', 'tbl_internship_application.user_id')
                ->selectRaw('DISTINCT users.college_id, users.degree_id')
                ->whereNotNull('users.college_id')
                ->whereNotNull('users.degree_id')
                ->get();

            $submittedCount = InternshipCollegeSubmit::where('internship_id', $internship->id)->count();
            $allSubmitted = ($submittedCount >= $allCollegeCombos->count()) && $allCollegeCombos->count() > 0;

            // Only mark college side globally complete when ALL colleges have submitted
            if ($allSubmitted) {
                $internship->update(['college_complete_sts' => 1]);
                $internship->refresh();
                if ($internship->company_complete_sts == 1) {
                    $internship->update(['complete_status' => 1]);
                    InternshipApplication::where('internship_id', $internship->id)
                        ->update(['complete_status' => 1]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'College marks submitted successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * AJAX: Mark an internship as pending for college marks entry.
     * Requires: company_complete_sts=1 AND college_complete_sts=0 AND internship_type=1
     * Sets: college_pending_flag = 1
     */
    public function markCollegePending(Request $request, $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:tbl_internship,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid internship.'], 422);
        }

        try {
            $internship = Internship::findOrFail($id);

            // Only valid for Industry+College type
            if ($internship->internship_type != 1) {
                return response()->json(['success' => false, 'message' => 'This action is only valid for Industry+College internships.'], 422);
            }

            // Only allowed when company side is done but college side is not
            if ($internship->company_complete_sts != 1) {
                return response()->json(['success' => false, 'message' => 'Industry side marks must be submitted first.'], 422);
            }

            if ($internship->college_complete_sts == 1) {
                return response()->json(['success' => false, 'message' => 'College marks are already submitted.'], 422);
            }

            // Prevent duplicate flag
            if ($internship->college_pending_flag == 1) {
                return response()->json(['success' => false, 'message' => 'Already marked as pending for college.'], 422);
            }

            $internship->update(['college_pending_flag' => 1]);

            $this->logActivity("Marked internship ID {$id} as pending for college marks.");

            return response()->json([
                'success' => true,
                'message' => 'Internship marked as pending for college marks. College can now see it in their dashboard.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * DataTable: College Pending internships (company done, college pending, flag set).
     */
    public function getCollegePendingData(Request $request)
    {
        try {
            $data = Internship::with(['company'])
                ->where('internship_type', 1)
                ->where('company_complete_sts', 1)
                ->where('college_complete_sts', 0)
                ->where('complete_status', 0)
                ->select('tbl_internship.*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('company_name', fn($row) => $row->company ? $row->company->name : 'N/A')
                ->addColumn('formatted_start_date', fn($row) => $row->start_date ? $row->start_date->format('d M Y') : 'N/A')
                ->addColumn('formatted_end_date', fn($row) => $row->end_date ? $row->end_date->format('d M Y') : 'N/A')
                ->addColumn('status_badge', function ($row) {
                    return '<span class="badge" style="background:#fff3cd;color:#856404;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:600;">
                                <i class="bx bx-time"></i> Industry Completed / College Pending
                            </span>';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.internship.view', $row->id) . '" class="btn btn-sm btn-primary" style="border-radius:6px;">
                                <i class="bx bx-show"></i> View
                            </a>';
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ==================== COLLEGE MARKS HISTORY (CARD VIEW + DETAIL PAGE) ====================

    /**
     * Page 1: Card grid view of all completed internships (college marks submitted).
     */
    public function collegeMarksHistoryCards()
    {
        $isSuperAdmin = auth()->check() && !auth()->guard('college')->check() && !auth()->guard('college_staff')->check();
        $isCollegeLogin = auth()->guard('college')->check() || auth()->guard('college_staff')->check();

        $collegeId = null;
        $universityId = null;

        if ($isCollegeLogin) {
            $college = auth()->guard('college')->user() ?? optional(auth()->guard('college_staff')->user())->college;
            $collegeId = $college ? $college->id : null;
            $universityId = $college ? $college->university_id : null;
        }

        // Build query
        $query = Internship::where('company_complete_sts', 1)
            ->where('approve_status', 1);

        if ($isCollegeLogin) {
            // College login: only show Industry+College (type 1) where college has submitted marks
            $query->where('internship_type', 1)
                  ->where('college_complete_sts', 1);

            if ($collegeId) {
                $submittedType1Ids = InternshipCollegeSubmit::where('college_id', $collegeId)
                    ->pluck('internship_id')->unique();
                $query->whereIn('id', $submittedType1Ids);
            }
        } else {
            // Super admin: include both type 1 (college_complete_sts=1) and type 2 (complete_status=1)
            $query->where(function ($q) {
                $q->where(function ($sub) {
                    $sub->where('internship_type', 1)->where('college_complete_sts', 1);
                })->orWhere(function ($sub) {
                    $sub->where('internship_type', 2)->where('complete_status', 1);
                });
            });
        }

        $internships = $query->orderBy('updated_at', 'desc')->get();

        // Eager load applications with user→college→university for card info
        $internshipIds = $internships->pluck('id');
        $applicationsQuery = InternshipApplication::with(['user.college.university'])
            ->whereIn('internship_id', $internshipIds);

        if ($isCollegeLogin && $collegeId) {
            $applicationsQuery->whereHas('user', function ($q) use ($collegeId) {
                $q->where('college_id', $collegeId);
            });
        }

        $allApplications = $applicationsQuery->get()->groupBy('internship_id');

        // Build card data
        $cards = [];
        foreach ($internships as $internship) {
            $apps = $allApplications->get($internship->id, collect());
            // Do NOT skip when apps is empty — completed internships always appear

            $studentCount = $apps->count();

            // Derive university name from applications (first found), for superadmin filter
            $universityName = $apps->map(fn($a) => optional(optional(optional($a->user)->college)->university)->university_name)
                ->filter()->first() ?? '';

            // Get company info from internship (company is a User)
            $companyUser = $internship->company;

            // Include student names for college login view
            $studentNames = $isCollegeLogin
                ? $apps->map(fn($a) => optional($a->user)->name)->filter()->values()
                : collect();

            $cards[] = [
                'id'              => $internship->id,
                'title'           => $internship->internship_title,
                'internship_type' => $internship->internship_type,
                'company_name'    => $companyUser ? $companyUser->name : 'N/A',
                'student_count'   => $studentCount,
                'students'        => $studentNames,
                'university_name' => $universityName,
                'start_date'      => $internship->start_date,
                'end_date'        => $internship->end_date,
                'updated_at'      => $internship->updated_at,
            ];
        }

        $universities = $isSuperAdmin ? University::orderBy('university_name')->whereNull('deleted_at')->get() : collect();

        return view('admin.internship.marks-history-cards', compact(
            'isSuperAdmin', 'isCollegeLogin', 'collegeId', 'universityId', 'universities', 'cards'
        ));
    }

    /**
     * Page 2: Detail page showing student-wise marks table for a specific internship.
     */
    public function collegeMarksHistoryDetail($id)
    {
        $isSuperAdmin = auth()->check() && !auth()->guard('college')->check() && !auth()->guard('college_staff')->check();
        $isCollegeLogin = auth()->guard('college')->check() || auth()->guard('college_staff')->check();
        $collegeIdForCheck = null;

        // For college login: check access differently per type
        if ($isCollegeLogin) {
            $college = auth()->guard('college')->user() ?? optional(auth()->guard('college_staff')->user())->college;
            $collegeIdForCheck = $college ? $college->id : null;

            $internshipType = Internship::where('id', $id)->value('internship_type');

            // College login cannot access Company-Only (type 2) internships in marks history
            abort_if($internshipType == 2, 403, 'Company-only internships are not viewable in college marks history.');

            // Type 1: college must have submitted marks (InternshipCollegeSubmit record)
            $submitted = $collegeIdForCheck
                ? InternshipCollegeSubmit::where('internship_id', $id)->where('college_id', $collegeIdForCheck)->exists()
                : false;
            abort_unless($submitted, 403, 'College marks not yet submitted for this internship.');
        }

        $internship = Internship::where('id', $id)  
            ->where('company_complete_sts', 1)
            ->where('approve_status', 1)
            ->whereIn('internship_type', [1, 2])
            ->firstOrFail();

        $collegeId = $collegeIdForCheck ?? null;

        // Load applications with degree eager-loaded
        $applicationsQuery = InternshipApplication::with(['user.college.university', 'user.degree'])
            ->where('internship_id', $id);

        if ($isCollegeLogin && $collegeId) {
            $applicationsQuery->whereHas('user', function ($q) use ($collegeId) {
                $q->where('college_id', $collegeId);
            });
        }

        $applications = $applicationsQuery->get();

        // Allow viewing even if no applications exist (data may have been cleared after submission)

        // Build per-student criteria maps — cached by "collegeId:degreeId"
        $criteriaCache              = [];
        $studentCollegeCriteriaMap  = [];
        $studentIndustryCriteriaMap = [];

        foreach ($applications as $app) {
            $student = $app->user;
            if (!$student) continue;

            $cKey = "{$student->college_id}:{$student->degree_id}";

            if (!array_key_exists($cKey, $criteriaCache)) {
                $grade = Grade::where('college_id', $student->college_id)
                    ->when($student->degree_id, fn($q) => $q->where('course_id', $student->degree_id))
                    ->first();

                $collegeCrit  = collect();
                $industryCrit = collect();

                if ($grade) {
                    $collegeSectionIds = GradeSection::where('grade_id', $grade->id)
                        ->where('title', 'College Marks')->pluck('id');
                    $collegeCrit = GradeCriterion::whereIn('section_id', $collegeSectionIds)
                        ->whereNull('deleted_at')->get();

                    $industrySectionIds = GradeSection::where('grade_id', $grade->id)
                        ->where('title', 'Industry Marks')->pluck('id');
                    $industryCrit = GradeCriterion::whereIn('section_id', $industrySectionIds)
                        ->whereNull('deleted_at')->get();
                }

                $criteriaCache[$cKey] = ['college' => $collegeCrit, 'industry' => $industryCrit];
            }

            $studentCollegeCriteriaMap[$student->id]  = $criteriaCache[$cKey]['college'];
            $studentIndustryCriteriaMap[$student->id] = $criteriaCache[$cKey]['industry'];
        }

        // Collect all unique criteria IDs across all students for one marks query
        $allCriteriaIds = collect();
        foreach ($criteriaCache as $crit) {
            $allCriteriaIds = $allCriteriaIds->merge($crit['college']->pluck('id'));
            $allCriteriaIds = $allCriteriaIds->merge($crit['industry']->pluck('id'));
        }
        $allCriteriaIds = $allCriteriaIds->unique()->values();

        // Load all marks in one query grouped by student
        $allMarksByStudent = InternshipMark::where('internship_id', $id)
            ->when($allCriteriaIds->isNotEmpty(), fn($q) => $q->whereIn('criteria_id', $allCriteriaIds))
            ->get()
            ->groupBy('student_id');

        // Helper: grade letter from percentage
        $gradeLetter = function (float $pct): string {
            if ($pct >= 90) return 'A+';
            if ($pct >= 80) return 'A';
            if ($pct >= 70) return 'B';
            if ($pct >= 60) return 'C';
            if ($pct >= 50) return 'D';
            if ($pct >  0)  return 'F';
            return '-';
        };

        // Build student rows
        $students = [];
        foreach ($applications as $app) {
            $student = $app->user;
            if (!$student) continue;

            $studentMarks = $allMarksByStudent->get($student->id, collect())->keyBy('criteria_id');
            $collegeCrit  = $studentCollegeCriteriaMap[$student->id]  ?? collect();
            $industryCrit = $studentIndustryCriteriaMap[$student->id] ?? collect();

            // College marks
            $collegeTotal = 0; $collegeMaxTotal = 0; $collegeMarksData = [];
            foreach ($collegeCrit as $c) {
                $collegeMaxTotal += $c->marks;
                $mark    = $studentMarks->get($c->id);
                $markVal = $mark ? min($mark->marks, $c->marks) : 0;
                $collegeTotal += $markVal;
                $collegeMarksData[$c->id] = $markVal;
            }
            $collegePct = $collegeMaxTotal > 0 ? round(($collegeTotal / $collegeMaxTotal) * 100, 2) : 0;

            // Industry marks
            $industryTotal = 0; $industryMaxTotal = 0; $industryMarksData = [];
            foreach ($industryCrit as $c) {
                $industryMaxTotal += $c->marks;
                $mark    = $studentMarks->get($c->id);
                $markVal = $mark ? min($mark->marks, $c->marks) : 0;
                $industryTotal += $markVal;
                $industryMarksData[$c->id] = $markVal;
            }
            $industryPct = $industryMaxTotal > 0 ? round(($industryTotal / $industryMaxTotal) * 100, 2) : 0;

            // Combined
            $combinedTotal    = $collegeTotal    + $industryTotal;
            $combinedMaxTotal = $collegeMaxTotal + $industryMaxTotal;
            $combinedPct      = $combinedMaxTotal > 0 ? round(($combinedTotal / $combinedMaxTotal) * 100, 2) : 0;

            $students[] = [
                'id'               => $student->id,
                'application_id'   => $app->id,
                'name'             => $student->name,
                'college_name'     => optional($student->college)->college_name ?? 'N/A',
                'university_name'  => optional(optional($student->college)->university)->university_name ?? 'N/A',
                'degree_name'      => optional($student->degree)->degree_name ?? 'N/A',
                // Per-student criteria collections (for blade iteration)
                'college_criteria' => $collegeCrit,
                'industry_criteria'=> $industryCrit,
                // Mark values keyed by criteria_id
                'college_marks'    => $collegeMarksData,
                'industry_marks'   => $industryMarksData,
                // Feedback
                'college_feedback' => $app->college_feedback ?? '',
                'company_feedback' => $app->company_feedback ?? '',
                // College stats
                'college_total'      => $collegeTotal,
                'college_max_total'  => $collegeMaxTotal,
                'college_percentage' => $collegePct,
                'college_grade'      => $gradeLetter($collegePct),
                // Industry stats
                'industry_total'      => $industryTotal,
                'industry_max_total'  => $industryMaxTotal,
                'industry_percentage' => $industryPct,
                'industry_grade'      => $gradeLetter($industryPct),
                // Combined stats
                'combined_total'      => $combinedTotal,
                'combined_max_total'  => $combinedMaxTotal,
                'combined_percentage' => $combinedPct,
                'combined_grade'      => $gradeLetter($combinedPct),
            ];
        }

        return view('admin.internship.marks-history-detail', compact(
            'internship', 'isSuperAdmin', 'isCollegeLogin', 'students'
        ));
    }

    /**
     * Super admin: update a single student's marks/feedback from Marks History.
     * Honours the current view (all / college / industry) so only that side is saved.
     */
    public function updateMarksHistoryRow(Request $request)
    {
        $isSuperAdmin = auth()->check() && !auth()->guard('college')->check() && !auth()->guard('college_staff')->check();
        if (!$isSuperAdmin) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'internship_id'     => 'required|integer',
            'student_id'        => 'required|integer',
            'view'              => 'nullable|in:all,college,industry',
            'college_marks'     => 'nullable|array',
            'industry_marks'    => 'nullable|array',
            'college_feedback'  => 'nullable|string|max:5000',
            'company_feedback'  => 'nullable|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $internship = Internship::findOrFail($request->internship_id);
        $studentId  = (int) $request->student_id;
        $view       = $request->input('view', 'all');

        $application = InternshipApplication::with('user')
            ->where('internship_id', $internship->id)
            ->where('user_id', $studentId)
            ->first();

        if (!$application || !$application->user) {
            return response()->json(['success' => false, 'message' => 'Student not found for this internship.'], 404);
        }

        $student = $application->user;
        $grade = Grade::where('college_id', $student->college_id)
            ->when($student->degree_id, fn ($q) => $q->where('course_id', $student->degree_id))
            ->first();

        $collegeCrit  = collect();
        $industryCrit = collect();
        if ($grade) {
            $collegeSectionIds = GradeSection::where('grade_id', $grade->id)
                ->where('title', 'College Marks')->pluck('id');
            $collegeCrit = GradeCriterion::whereIn('section_id', $collegeSectionIds)
                ->whereNull('deleted_at')->get()->keyBy('id');

            $industrySectionIds = GradeSection::where('grade_id', $grade->id)
                ->where('title', 'Industry Marks')->pluck('id');
            $industryCrit = GradeCriterion::whereIn('section_id', $industrySectionIds)
                ->whereNull('deleted_at')->get()->keyBy('id');
        }

        $updateCollege  = in_array($view, ['all', 'college'], true);
        $updateIndustry = in_array($view, ['all', 'industry'], true);

        DB::beginTransaction();
        try {
            if ($updateCollege) {
                $collegeMarks = $request->input('college_marks', []);
                foreach ($collegeMarks as $criteriaId => $markVal) {
                    $criteria = $collegeCrit->get((int) $criteriaId);
                    if (!$criteria) {
                        continue;
                    }
                    $marks = max(0, min((int) $markVal, (int) $criteria->marks));
                    InternshipMark::updateOrCreate(
                        [
                            'internship_id' => $internship->id,
                            'student_id'    => $studentId,
                            'criteria_id'   => $criteria->id,
                        ],
                        [
                            'criteria_name' => $criteria->title,
                            'max_marks'     => $criteria->marks,
                            'marks'         => $marks,
                            'status'        => 1,
                        ]
                    );
                }
                if ($request->exists('college_feedback')) {
                    $application->college_feedback = $request->input('college_feedback');
                }
            }

            if ($updateIndustry) {
                $industryMarks = $request->input('industry_marks', []);
                foreach ($industryMarks as $criteriaId => $markVal) {
                    $criteria = $industryCrit->get((int) $criteriaId);
                    if (!$criteria) {
                        continue;
                    }
                    $marks = max(0, min((int) $markVal, (int) $criteria->marks));
                    InternshipMark::updateOrCreate(
                        [
                            'internship_id' => $internship->id,
                            'student_id'    => $studentId,
                            'criteria_id'   => $criteria->id,
                        ],
                        [
                            'criteria_name' => $criteria->title,
                            'max_marks'     => $criteria->marks,
                            'marks'         => $marks,
                            'status'        => 1,
                        ]
                    );
                }
                if ($request->exists('company_feedback')) {
                    $application->company_feedback = $request->input('company_feedback');
                }
            }

            $application->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }

        $allMarks = InternshipMark::where('internship_id', $internship->id)
            ->where('student_id', $studentId)
            ->get()
            ->keyBy('criteria_id');

        $collegeTotal = 0;
        $collegeMax = 0;
        $collegeMarksData = [];
        foreach ($collegeCrit as $c) {
            $collegeMax += (int) $c->marks;
            $markVal = $allMarks->get($c->id) ? min((int) $allMarks->get($c->id)->marks, (int) $c->marks) : 0;
            $collegeTotal += $markVal;
            $collegeMarksData[$c->id] = $markVal;
        }
        $collegePct = $collegeMax > 0 ? round(($collegeTotal / $collegeMax) * 100, 2) : 0;

        $industryTotal = 0;
        $industryMax = 0;
        $industryMarksData = [];
        foreach ($industryCrit as $c) {
            $industryMax += (int) $c->marks;
            $markVal = $allMarks->get($c->id) ? min((int) $allMarks->get($c->id)->marks, (int) $c->marks) : 0;
            $industryTotal += $markVal;
            $industryMarksData[$c->id] = $markVal;
        }
        $industryPct = $industryMax > 0 ? round(($industryTotal / $industryMax) * 100, 2) : 0;

        $combinedTotal = $collegeTotal + $industryTotal;
        $combinedMax = $collegeMax + $industryMax;
        $combinedPct = $combinedMax > 0 ? round(($combinedTotal / $combinedMax) * 100, 2) : 0;

        $gradeLetter = function (float $pct): string {
            if ($pct >= 90) return 'A+';
            if ($pct >= 80) return 'A';
            if ($pct >= 70) return 'B';
            if ($pct >= 60) return 'C';
            if ($pct >= 50) return 'D';
            if ($pct >  0)  return 'F';
            return '-';
        };
        $gradeClass = function (float $pct): string {
            if ($pct >= 80) return 'grade-A';
            if ($pct >= 70) return 'grade-B';
            if ($pct >= 60) return 'grade-C';
            if ($pct >= 50) return 'grade-D';
            if ($pct >  0)  return 'grade-F';
            return 'grade-dash';
        };

        return response()->json([
            'success' => true,
            'message' => 'Marks updated successfully.',
            'data' => [
                'college_marks'        => $collegeMarksData,
                'industry_marks'       => $industryMarksData,
                'college_feedback'     => $application->college_feedback ?? '',
                'company_feedback'     => $application->company_feedback ?? '',
                'college_total'        => $collegeTotal,
                'college_max_total'    => $collegeMax,
                'college_percentage'   => $collegePct,
                'college_grade'        => $gradeLetter($collegePct),
                'college_grade_class'  => $gradeClass($collegePct),
                'industry_total'       => $industryTotal,
                'industry_max_total'   => $industryMax,
                'industry_percentage'  => $industryPct,
                'industry_grade'       => $gradeLetter($industryPct),
                'industry_grade_class' => $gradeClass($industryPct),
                'combined_total'       => $combinedTotal,
                'combined_max_total'   => $combinedMax,
                'combined_percentage'  => $combinedPct,
                'combined_grade'       => $gradeLetter($combinedPct),
                'combined_grade_class' => $gradeClass($combinedPct),
            ],
        ]);
    }

    /**
     * Export marks history to Excel (server-side via PhpSpreadsheet).
     */
    public function exportMarksHistory(Request $request, $internshipId)
    {
        $internship = Internship::findOrFail($internshipId);

        // Security: college users can only export their own students
        $isCollegeLogin = auth()->guard('college')->check() || auth()->guard('college_staff')->check();
        $collegeId = null;

        if ($isCollegeLogin) {
            $college = auth()->guard('college')->user() ?? optional(auth()->guard('college_staff')->user())->college;
            $collegeId = $college ? $college->id : null;
        }

        // Get students
        $applicationsQuery = InternshipApplication::with(['user.college.university'])
            ->where('internship_id', $internshipId);

        if ($collegeId) {
            $applicationsQuery->whereHas('user', function ($q) use ($collegeId) {
                $q->where('college_id', $collegeId);
            });
        }

        $applications = $applicationsQuery->get();

        if ($applications->isEmpty()) {
            return back()->with('error', 'No students found for this internship.');
        }

        // Get college criteria from the first student's college
        $firstStudent = $applications->first()->user;
        $grade = Grade::where('college_id', $firstStudent->college_id)->first();

        $collegeCriteria = collect();
        if ($grade) {
            $collegeSections = GradeSection::where('grade_id', $grade->id)
                ->where('title', 'College Marks')
                ->pluck('id');
            $collegeCriteria = GradeCriterion::whereIn('section_id', $collegeSections)
                ->whereNull('deleted_at')
                ->get();
        }

        $criteriaIds = $collegeCriteria->pluck('id')->toArray();

        // Load all marks
        $allMarks = InternshipMark::where('internship_id', $internshipId)
            ->whereIn('criteria_id', $criteriaIds)
            ->get()
            ->groupBy('student_id');

        // Build spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Marks History');

        // Header row
        $col = 'A';
        $sheet->setCellValue($col++ . '1', 'SR.NO');
        $sheet->setCellValue($col++ . '1', 'STUDENT NAME');
        $sheet->setCellValue($col++ . '1', 'UNIVERSITY');
        $sheet->setCellValue($col++ . '1', 'COLLEGE');

        foreach ($collegeCriteria as $c) {
            $sheet->setCellValue($col++ . '1', strtoupper($c->title) . ' (/' . $c->marks . ')');
        }

        $sheet->setCellValue($col++ . '1', 'FEEDBACK');
        $sheet->setCellValue($col++ . '1', 'TOTAL');
        $sheet->setCellValue($col++ . '1', 'PERCENTAGE');
        $sheet->setCellValue($col . '1', 'GRADE');

        // Style header
        $lastCol = $col;
        $headerRange = "A1:{$lastCol}1";
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '242A62']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // Data rows
        $row = 2;
        $srNo = 1;
        foreach ($applications as $app) {
            $student = $app->user;
            if (!$student) continue;

            $studentMarks = $allMarks->get($student->id, collect())->keyBy('criteria_id');

            $col = 'A';
            $sheet->setCellValue($col++ . $row, $srNo++);
            $sheet->setCellValue($col++ . $row, strtoupper($student->name ?? 'N/A'));
            $sheet->setCellValue($col++ . $row, optional(optional($student->college)->university)->university_name ?? 'N/A');
            $sheet->setCellValue($col++ . $row, optional($student->college)->college_name ?? 'N/A');

            $total = 0;
            $maxTotal = 0;
            foreach ($collegeCriteria as $c) {
                $mark = $studentMarks->get($c->id);
                $markVal = $mark ? min($mark->marks, $c->marks) : 0;
                $total += $markVal;
                $maxTotal += $c->marks;
                $sheet->setCellValue($col++ . $row, $markVal);
            }

            $percentage = $maxTotal > 0 ? round(($total / $maxTotal) * 100, 2) : 0;

            $grade_letter = '-';
            if ($percentage >= 90) $grade_letter = 'A+';
            elseif ($percentage >= 80) $grade_letter = 'A';
            elseif ($percentage >= 70) $grade_letter = 'B';
            elseif ($percentage >= 60) $grade_letter = 'C';
            elseif ($percentage >= 50) $grade_letter = 'D';
            elseif ($percentage > 0) $grade_letter = 'F';

            $sheet->setCellValue($col++ . $row, $app->college_feedback ?? '');
            $sheet->setCellValue($col++ . $row, "{$total} / {$maxTotal}");
            $sheet->setCellValue($col++ . $row, "{$percentage}%");
            $sheet->setCellValue($col . $row, $grade_letter);

            $row++;
        }

        // Auto-size columns
        foreach (range('A', $lastCol) as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        // Add borders
        $dataRange = "A1:{$lastCol}" . ($row - 1);
        $sheet->getStyle($dataRange)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ]);

        $filename = 'marks_history_' . Str::slug($internship->internship_title) . '_' . date('Y-m-d') . '.xlsx';

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // ==================== INTERNSHIP REVIEW MANAGEMENT ====================

    /**
     * Admin page listing all internship reviews with DataTables.
     */
    public function reviewManagementPage()
    {
        return view('admin.internship.reviews');
    }

    /**
     * AJAX: DataTables data source for reviews.
     */
    public function getReviewsData(Request $request)
    {
        $query = InternshipReview::with(['student', 'internship'])
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('student_name', fn($row) => $row->student ? $row->student->name : 'N/A')
            ->addColumn('internship_title', fn($row) => $row->internship ? $row->internship->internship_title : 'N/A')
            ->addColumn('star_display', function ($row) {
                $html = '';
                for ($i = 1; $i <= 5; $i++) {
                    $html .= $i <= $row->star
                        ? '<span style="color:#ffc107;font-size:16px;">&#9733;</span>'
                        : '<span style="color:#e0e0e0;font-size:16px;">&#9733;</span>';
                }
                return $html;
            })
            ->addColumn('review_text', fn($row) => Str::limit($row->review ?? '-', 80))
            ->addColumn('status_badge', function ($row) {
                $status = intval($row->active_status);
                if ($status === 1) {
                    return '<span class="badge bg-success">Approved</span>';
                } elseif ($status === 2) {
                    return '<span class="badge bg-danger">Rejected</span>';
                }
                return '<span class="badge bg-warning text-dark">Pending</span>';
            })
            ->addColumn('submitted_at', fn($row) => $row->write_on ? $row->write_on->format('d M Y') : ($row->created_at ? $row->created_at->format('d M Y') : '-'))
            ->addColumn('action', function ($row) {
                $html = '<div class="d-flex gap-1">';
                $status = intval($row->active_status);
                if ($status !== 1) {
                    $html .= '<button class="btn btn-sm btn-success review-action" data-id="' . $row->id . '" data-status="1" title="Approve"><i class="bx bx-check"></i></button>';
                }
                if ($status !== 2) {
                    $html .= '<button class="btn btn-sm btn-danger review-action" data-id="' . $row->id . '" data-status="2" title="Reject"><i class="bx bx-x"></i></button>';
                }
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['star_display', 'status_badge', 'action'])
            ->make(true);
    }

    /**
     * Update review status (approve/reject).
     */
    public function updateReviewStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1,2',
        ]);

        $review = InternshipReview::findOrFail($id);
        $review->active_status = intval($request->status);
        $review->save();

        $statusLabels = [0 => 'Pending', 1 => 'Approved', 2 => 'Rejected'];

        return response()->json([
            'success' => true,
            'message' => 'Review status updated to ' . ($statusLabels[$review->active_status] ?? 'Unknown'),
        ]);
    }

    /**
     * AJAX: Get review stats for dashboard cards.
     */
    public function getReviewStats()
    {
        $total = InternshipReview::count();
        $pending = InternshipReview::where('active_status', 0)->count();
        $approved = InternshipReview::where('active_status', 1)->count();
        $rejected = InternshipReview::where('active_status', 2)->count();

        return response()->json([
            'success' => true,
            'total' => $total,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
        ]);
    }

    private function normalizeTagList($value)
    {
        if (is_array($value)) {
            $items = $value;
        } else {
            $value = trim((string) $value);
            if ($value === '') {
                return json_encode([]);
            }

            $decoded = json_decode($value, true);
            if (is_string($decoded)) {
                $decoded = json_decode($decoded, true);
            }

            if (is_array($decoded)) {
                $items = $decoded;
            } else {
                $items = preg_split('/,/', $value);
            }
        }

        $unique = [];
        foreach ($items as $item) {
            if (is_array($item)) {
                $item = implode(' ', $item);
            }

            $name = preg_replace('/\s+/u', ' ', trim(strip_tags((string) $item)));
            $name = trim($name, " \t\n\r\0\x0B\"'[]");
            if ($name === '') {
                continue;
            }

            $key = mb_strtolower($name);
            if (!isset($unique[$key])) {
                $unique[$key] = $name;
            }
        }

        return json_encode(array_values($unique));
    }
}