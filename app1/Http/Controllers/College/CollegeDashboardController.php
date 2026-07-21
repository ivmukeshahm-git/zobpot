<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\College;

class CollegeDashboardController extends Controller
{
    /**
     * Get the college_id for the currently authenticated user (college or college_staff guard).
     */
    private function getCollegeId()
    {
        if (Auth::guard('college')->check()) {
            return Auth::guard('college')->id();
        }
        if (Auth::guard('college_staff')->check()) {
            return Auth::guard('college_staff')->user()->college_id;
        }
        return null;
    }

    /**
     * Display the college dashboard.
     */
    public function index()
    {
        $collegeId = $this->getCollegeId();

        if (!$collegeId) {
            return redirect()->route('admin.login')->with('error', 'Unauthorized access.');
        }

        // ── Total Students: all users registered under this college ──
        $totalStudents = DB::table('users')
            ->where('college_id', $collegeId)
            ->where('role', 'User')
            ->whereNull('deleted_at')
            ->count();

        // Helper: distinct internship IDs for this college's students (type 1 only)
        $collegeInternshipIds = DB::table('tbl_internship_application as ia')
            ->join('users as u', 'ia.user_id', '=', 'u.id')
            ->join('tbl_internship as i', 'ia.internship_id', '=', 'i.id')
            ->where('u.college_id', $collegeId)
            ->whereNull('u.deleted_at')
            ->where('i.internship_type', 1)
            ->distinct()
            ->pluck('ia.internship_id');

        // ── Active Internships: distinct internships NOT yet completed ──
        $activeInternships = DB::table('tbl_internship')
            ->whereIn('id', $collegeInternshipIds)
            ->where('complete_status', '!=', 1)
            ->count();

        // ── Pending Applications: distinct internships still in progress ──
        $pendingApplications = DB::table('tbl_internship')
            ->whereIn('id', $collegeInternshipIds)
            ->where('complete_status', '!=', 1)
            ->count();

        // ── Completed Internships: distinct internships that are completed ──
        $completedInternships = DB::table('tbl_internship')
            ->whereIn('id', $collegeInternshipIds)
            ->where('complete_status', 1)
            ->count();

        $isCollegeStaff = Auth::guard('college_staff')->check();

        // Staff-specific stats
        $assignedInternships = 0;
        $assignedStudents = 0;
        $staffProcessingInternships = 0;
        $staffCompletedInternships = 0;

        if ($isCollegeStaff) {
            $staffId = Auth::guard('college_staff')->id();

            $assignedStudents = DB::table('tbl_internship_application')
                ->where('assigned_staff_id', $staffId)
                ->count();

            $assignedInternshipIds = DB::table('tbl_internship_application')
                ->where('assigned_staff_id', $staffId)
                ->distinct()
                ->pluck('internship_id');

            $assignedInternships = $assignedInternshipIds->count();

            $staffProcessingInternships = DB::table('tbl_internship')
                ->whereIn('id', $assignedInternshipIds)
                ->where('internship_type', 1)
                ->where('complete_status', '!=', 1)
                ->count();

            $staffCompletedInternships = DB::table('tbl_internship')
                ->whereIn('id', $assignedInternshipIds)
                ->where('internship_type', 1)
                ->where('complete_status', 1)
                ->count();
        }

        // ── Pending Marks: internships where internship_type=1,
        //    company has completed (company_complete_sts=1) but college marks not yet submitted (college_complete_sts=0) ──
        $pendingMarksCount = DB::table('tbl_internship')
            ->whereIn('id', $collegeInternshipIds)
            ->where('internship_type', 1)
            ->where('company_complete_sts', 1)
            ->where('college_complete_sts', 0)
            ->count();

        return view('college-dashboard.index', compact(
            'totalStudents',
            'activeInternships',
            'pendingApplications',
            'completedInternships',
            'isCollegeStaff',
            'assignedInternships',
            'assignedStudents',
            'staffProcessingInternships',
            'staffCompletedInternships',
            'pendingMarksCount'
        ));
    }

    /**
     * Registration list page — students registered under this college.
     */
    public function registrationList()
    {
        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return redirect()->route('admin.login');
        }
        return view('college-dashboard.registration-list');
    }

    /**
     * DataTable data for registration list.
     */
    public function getRegistrationData(Request $request)
    {
        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = User::where('college_id', $collegeId)
            ->where('role', 'User')
            ->whereNull('deleted_at')
            ->with(['college', 'college.university', 'degree'])
            ->select('id', 'name', 'email', 'contact_no', 'college_id', 'degree_id', 'university_id', 'created_at');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('university_name', function ($row) {
                return $row->college && $row->college->university
                    ? $row->college->university->university_name
                    : 'N/A';
            })
            ->addColumn('course', function ($row) {
                return $row->degree ? $row->degree->degree_nm : 'N/A';
            })
            ->addColumn('registered_date', function ($row) {
                return $row->created_at ? $row->created_at->format('d M Y') : 'N/A';
            })
            ->addColumn('action', function ($row) {
                $url = url('admin/candidate-profile/' . $row->id);
                return '<a href="' . $url . '" class="btn btn-sm btn-info" target="_blank"><i class="bx bx-user"></i> View Profile</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * DataTable: students assigned to the current college staff member.
     */
    public function getAssignedStudentsData(Request $request)
    {
        if (!Auth::guard('college_staff')->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $staffId = Auth::guard('college_staff')->id();

        $data = \App\Models\InternshipApplication::with(['user', 'internship', 'user.college', 'user.college.university'])
            ->where('assigned_staff_id', $staffId)
            ->orderBy('created_at', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('student_name', fn($r) => $r->user ? $r->user->name : 'N/A')
            ->addColumn('internship_title', fn($r) => $r->internship ? $r->internship->internship_title : 'N/A')
            ->addColumn('email', fn($r) => $r->user ? ($r->user->email ?: 'N/A') : 'N/A')
            ->addColumn('contact', fn($r) => $r->user ? ($r->user->contact_no ?: 'N/A') : 'N/A')
            ->addColumn('assigned_date', fn($r) => $r->updated_at ? $r->updated_at->format('d M Y') : 'N/A')
            ->addColumn('action', function ($r) {
                $userId = $r->user ? $r->user->id : null;
                $url = $userId ? url('admin/candidate-profile/' . $userId) : '#';
                return '<a href="' . $url . '" class="btn btn-sm btn-info" target="_blank"><i class="bx bx-user"></i> View Profile</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * DataTable: internships assigned to the current college staff member.
     */
    public function getStaffInternshipsData(Request $request)
    {
        if (!Auth::guard('college_staff')->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $staffId = Auth::guard('college_staff')->id();

        $internshipIds = \App\Models\InternshipApplication::where('assigned_staff_id', $staffId)
            ->distinct()
            ->pluck('internship_id');

        $data = \App\Models\Internship::with(['company', 'jobCategory'])
            ->whereIn('id', $internshipIds)
            ->where('internship_type', 1);

        $studentCounts = \App\Models\InternshipApplication::where('assigned_staff_id', $staffId)
            ->whereIn('internship_id', $internshipIds)
            ->groupBy('internship_id')
            ->select('internship_id', DB::raw('COUNT(DISTINCT user_id) as total'))
            ->pluck('total', 'internship_id');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('company_name', fn($r) => $r->company ? $r->company->name : 'N/A')
            ->addColumn('category_name', fn($r) => $r->jobCategory ? $r->jobCategory->category_nm : 'N/A')
            ->addColumn('status_label', function ($r) {
                if ($r->complete_status == 1) {
                    $status = 'Completed';
                    $style = 'background:#28a745;color:#fff';
                } else {
                    $now = \Carbon\Carbon::today();
                    $start = $r->start_date ? \Carbon\Carbon::parse($r->start_date) : null;
                    $end = $r->end_date ? \Carbon\Carbon::parse($r->end_date) : null;
                    if ($start && $end && $now->between($start, $end)) {
                        $status = 'Processing'; $style = 'background:#ffc107;color:#000';
                    } elseif ($start && $now->lt($start)) {
                        $status = 'Ongoing'; $style = 'background:#17a2b8;color:#fff';
                    } elseif ($end && $now->gt($end)) {
                        $status = 'Pending'; $style = 'background:#fd7e14;color:#fff';
                    } else {
                        $status = 'Ongoing'; $style = 'background:#17a2b8;color:#fff';
                    }
                }
                return '<span class="badge" style="' . $style . ';padding:6px 14px;border-radius:20px;font-size:12px;">' . e($status) . '</span>';
            })
            ->addColumn('total_students', fn($r) => $studentCounts[$r->id] ?? 0)
            ->addColumn('action', function ($r) {
                $url = route('admin.college-internship.view', $r->id);
                return '<a href="' . $url . '" class="btn btn-sm btn-info"><i class="bx bx-show"></i> View</a>';
            })
            ->rawColumns(['status_label', 'action'])
            ->make(true);
    }

    /**
     * Pending Marks page for college dashboard.
     * Shows internships where admin has flagged college_pending_flag=1.
     */
    public function pendingMarks()
    {
        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return redirect()->route('admin.login');
        }
        return view('college-dashboard.pending-marks', compact('collegeId'));
    }

    /**
     * DataTable: internships pending college marks entry.
     */
    public function getPendingMarksData(Request $request)
    {
        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Get internship IDs where students from this college are enrolled
        $internshipIds = \App\Models\InternshipApplication::whereHas('user', function ($q) use ($collegeId) {
                $q->where('college_id', $collegeId)->whereNull('deleted_at');
            })
            ->pluck('internship_id')
            ->unique();

        $data = \App\Models\Internship::with(['company'])
            ->whereIn('id', $internshipIds)
            ->where('internship_type', 1)
            ->where('company_complete_sts', 1)
            ->where('college_complete_sts', 0)
            ->select('tbl_internship.*');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('company_name', fn($r) => $r->company ? $r->company->name : 'N/A')
            ->addColumn('formatted_start_date', fn($r) => $r->start_date ? \Carbon\Carbon::parse($r->start_date)->format('d M Y') : 'N/A')
            ->addColumn('formatted_end_date', fn($r) => $r->end_date ? \Carbon\Carbon::parse($r->end_date)->format('d M Y') : 'N/A')
            ->addColumn('status_badge', function ($r) {
                return '<span class="badge" style="background:#fff3cd;color:#856404;padding:6px 14px;border-radius:20px;font-size:12px;font-weight:600;">
                            <i class="bx bx-time"></i> Pending Marks
                        </span>';
            })
            ->addColumn('action', function ($r) use ($collegeId) {
                $url = route('admin.internship.college-marks');
                return '<a href="' . $url . '" class="btn btn-sm" style="background:#242a62;color:#fff;border-radius:6px;">
                            <i class="bx bx-edit"></i> Fill Marks
                        </a>';
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }
}
