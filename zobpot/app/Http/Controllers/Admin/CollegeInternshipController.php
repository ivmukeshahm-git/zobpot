<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Internship;
use App\Models\InternshipApplication;
use App\Models\InternshipPayment;
use App\Models\CollegeStaff;
use App\Models\User;
use App\Models\College;
use App\Models\InternshipTask;
use Carbon\Carbon;

class CollegeInternshipController extends Controller
{
    /**
     * Get the current college ID (works for both college guard and web guard with college_id)
     */
    private function getCollegeId()
    {
        // College guard login
        if (Auth::guard('college')->check()) {
            return Auth::guard('college')->id();
        }
        // College staff guard login
        if (Auth::guard('college_staff')->check()) {
            return Auth::guard('college_staff')->user()->college_id;
        }
        // Web guard with college_id on user
        if (Auth::check() && Auth::user()->college_id) {
            return Auth::user()->college_id;
        }
        return null;
    }

    /**
     * Get current authenticated user (either guard)
     */
    private function getAuthUser()
    {
        return Auth::user() ?? Auth::guard('college')->user() ?? Auth::guard('college_staff')->user();
    }

    /**
     * Get internship IDs for this college's students (with successful payment)
     */
    private function getCollegeInternshipQuery($collegeId)
    {
        return InternshipApplication::query()
            ->join('users', 'tbl_internship_application.user_id', '=', 'users.id')
            ->join('tbl_internship_payment', function ($j) {
                $j->on('tbl_internship_payment.application_id', '=', 'tbl_internship_application.id')
                  ->where('tbl_internship_payment.payment_status', 1);
            })
            ->where('users.college_id', $collegeId);
    }

    /**
     * Compute status string for an internship
     */
    private function computeStatus($internship)
    {
        if ($internship->complete_status == 1) {
            return 'Completed';
        }
        $now = Carbon::today();
        $start = $internship->start_date ? Carbon::parse($internship->start_date) : null;
        $end = $internship->end_date ? Carbon::parse($internship->end_date) : null;

        if ($start && $end && $now->between($start, $end)) {
            return 'Processing';
        }
        if ($start && $now->lt($start)) {
            return 'Ongoing';
        }
        if ($end && $now->gt($end)) {
            return 'Pending';
        }
        return 'Ongoing';
    }

    /**
     * Return status badge HTML
     */
    private function statusBadge($status)
    {
        $map = [
            'Processing' => 'background:#ffc107;color:#000',
            'Ongoing'    => 'background:#17a2b8;color:#fff',
            'Pending'    => 'background:#fd7e14;color:#fff',
            'Completed'  => 'background:#28a745;color:#fff',
        ];
        $style = $map[$status] ?? 'background:#6c757d;color:#fff';
        return '<span class="badge" style="' . $style . ';padding:6px 14px;border-radius:20px;font-size:12px;">' . e($status) . '</span>';
    }

    // ─────────────────────────────────────────────────────────
    // 1 & 2.  My Processing Internship  (college dashboard)
    // ─────────────────────────────────────────────────────────

    /**
     * DataTable: processing internships for this college
     * (not completed)
     */
    public function getProcessingData(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Invalid request'], 400);
        }

        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Subquery: count distinct students per internship for this college (all applications, no payment filter)
        $sub = DB::table('tbl_internship_application as ia')
            ->join('users as u', 'ia.user_id', '=', 'u.id')
            ->where('u.college_id', $collegeId)
            ->whereNull('u.deleted_at')
            ->groupBy('ia.internship_id')
            ->select('ia.internship_id', DB::raw('COUNT(DISTINCT ia.user_id) as total_students'));

        // Main query: processing internships (not completed, college type only)
        $query = DB::table('tbl_internship as i')
            ->joinSub($sub, 'ic', function ($join) {
                $join->on('i.id', '=', 'ic.internship_id');
            })
            ->leftJoin('users as comp', 'i.company_id', '=', 'comp.id')
            ->leftJoin('tbl_job_category as jc', 'i.category', '=', 'jc.category_id')
            ->where('i.internship_type', 1)
            ->where('i.complete_status', '!=', 1)
            ->select(
                'i.id',
                'i.internship_title',
                'comp.name as company_name',
                'i.duration',
                'jc.category_nm as category_name',
                'i.location',
                'i.openings',
                'i.start_date',
                'i.end_date',
                'i.complete_status',
                'ic.total_students'
            );

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('status_label', function ($r) {
                // build a small object compatible with computeStatus()
                $tmp = new \stdClass();
                $tmp->complete_status = $r->complete_status;
                $tmp->start_date = $r->start_date;
                $tmp->end_date = $r->end_date;
                return $this->statusBadge($this->computeStatus($tmp));
            })
            ->addColumn('action', function ($r) {
                $url = route('admin.college-internship.view', $r->id);
                return '<a href="' . $url . '" class="btn btn-sm btn-info"><i class="bx bx-show"></i> View</a>';
            })
            ->filterColumn('internship_title', function ($query, $keyword) {
                $query->where('i.internship_title', 'like', "%{$keyword}%");
            })
            ->filterColumn('company_name', function ($query, $keyword) {
                $query->where('comp.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('duration', function ($query, $keyword) {
                $query->where('i.duration', 'like', "%{$keyword}%");
            })
            ->filterColumn('category_name', function ($query, $keyword) {
                $query->where('jc.category_nm', 'like', "%{$keyword}%");
            })
            ->filterColumn('location', function ($query, $keyword) {
                $query->where('i.location', 'like', "%{$keyword}%");
            })
            ->filterColumn('openings', function ($query, $keyword) {
                $query->where('i.openings', 'like', "%{$keyword}%");
            })
            ->orderColumn('company_name', 'comp.name $1')
            ->orderColumn('category_name', 'jc.category_nm $1')
            ->rawColumns(['status_label', 'action'])
            ->make(true);
    }

    // ─────────────────────────────────────────────────────────
    // 3.  Completed Internship table
    // ─────────────────────────────────────────────────────────

    public function getCompletedData(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Invalid request'], 400);
        }

        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Subquery: count distinct students per internship for this college (all applications, no payment filter)
        $sub = DB::table('tbl_internship_application as ia')
            ->join('users as u', 'ia.user_id', '=', 'u.id')
            ->where('u.college_id', $collegeId)
            ->whereNull('u.deleted_at')
            ->groupBy('ia.internship_id')
            ->select('ia.internship_id', DB::raw('COUNT(DISTINCT ia.user_id) as total_students'));

        $query = DB::table('tbl_internship as i')
            ->joinSub($sub, 'ic', function ($join) {
                $join->on('i.id', '=', 'ic.internship_id');
            })
            ->leftJoin('users as comp', 'i.company_id', '=', 'comp.id')
            ->leftJoin('tbl_job_category as jc', 'i.category', '=', 'jc.category_id')
            ->where('i.internship_type', 1)
            ->where('i.complete_status', 1)
            ->select(
                'i.id',
                'i.internship_title',
                'comp.name as company_name',
                'i.duration',
                'jc.category_nm as category_name',
                'i.location',
                'i.openings',
                'i.start_date',
                'i.end_date',
                'i.complete_status',
                'ic.total_students'
            );

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('status_label', fn($r) => $this->statusBadge('Completed'))
            ->addColumn('action', function ($r) {
                $url = route('admin.college-internship.view', $r->id);
                return '<a href="' . $url . '" class="btn btn-sm btn-info"><i class="bx bx-show"></i> View</a>';
            })
            ->filterColumn('internship_title', function ($query, $keyword) {
                $query->where('i.internship_title', 'like', "%{$keyword}%");
            })
            ->filterColumn('company_name', function ($query, $keyword) {
                $query->where('comp.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('duration', function ($query, $keyword) {
                $query->where('i.duration', 'like', "%{$keyword}%");
            })
            ->filterColumn('category_name', function ($query, $keyword) {
                $query->where('jc.category_nm', 'like', "%{$keyword}%");
            })
            ->filterColumn('location', function ($query, $keyword) {
                $query->where('i.location', 'like', "%{$keyword}%");
            })
            ->filterColumn('openings', function ($query, $keyword) {
                $query->where('i.openings', 'like', "%{$keyword}%");
            })
            ->orderColumn('company_name', 'comp.name $1')
            ->orderColumn('category_name', 'jc.category_nm $1')
            ->rawColumns(['status_label', 'action'])
            ->make(true);
    }

    // ─────────────────────────────────────────────────────────
    // 4.  College Internship View Page
    // ─────────────────────────────────────────────────────────

    public function view($id)
    {
        $internship = Internship::with(['company', 'jobCategory'])->findOrFail($id);
        $collegeId  = $this->getCollegeId();
        $isStaff    = Auth::guard('college_staff')->check();

        if ($internship->internship_type != 1) {
            abort(404, 'Internship not found.');
        }

        $hasCollegeStudent = InternshipApplication::where('internship_id', $internship->id)
            ->whereHas('user', function ($q) use ($collegeId) {
                $q->where('college_id', $collegeId)->whereNull('deleted_at');
            })
            ->exists();

        if (!$hasCollegeStudent) {
            abort(404, 'Internship not found.');
        }

        // College staff list for assignment dropdown
        $staffList = [];
        if ($collegeId && !$isStaff) {
            $staffList = CollegeStaff::where('college_id', $collegeId)
                ->where('active_status', 1)
                ->select('id', 'name')
                ->orderBy('name')
                ->get();
        }

        $myTasks = InternshipTask::where('internship_id', $internship->id)
            ->whereNull('parent_id')
            ->orderBy('date_time', 'desc')
            ->get();

        $collegeStudentIds = $this->getCollegeStudentIdsForInternship($internship->id, $collegeId, $isStaff);

        $childrenByParent = InternshipTask::whereIn('parent_id', $myTasks->pluck('id')->filter())
            ->when($collegeStudentIds->isNotEmpty(), function ($q) use ($collegeStudentIds) {
                $q->whereIn('student_id', $collegeStudentIds);
            })
            ->when($collegeStudentIds->isEmpty(), function ($q) {
                $q->whereRaw('1 = 0');
            })
            ->get()
            ->groupBy('parent_id');

        foreach ($myTasks as $task) {
            $children = $childrenByParent->get($task->id, collect());
            $task->college_total_students = $children->count();
            $task->college_completed_students = $children->where('status', 1)->count();
        }

        return view('admin.college-internship.view', compact('internship', 'collegeId', 'isStaff', 'staffList', 'myTasks'));
    }

    /**
     * Applied Students DataTable for the view page (Tab 2)
     */
    public function getAppliedStudents(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Invalid request'], 400);
        }

        $internshipId = $request->input('internship_id');
        $collegeId    = $this->getCollegeId();
        $isStaff      = Auth::guard('college_staff')->check();

        $internship = Internship::find($internshipId);
        $collegeCertificateAvailable = $internship
            && (int) $internship->internship_type === 1
            && (int) $internship->college_complete_sts === 1;

        $query = InternshipApplication::with(['user', 'user.college', 'user.college.university', 'assignedStaff'])
            ->join('users', 'tbl_internship_application.user_id', '=', 'users.id')
            ->where('tbl_internship_application.internship_id', $internshipId)
            ->where('users.college_id', $collegeId)
            ->select('tbl_internship_application.*');

        // Staff sees only their assigned students
        if ($isStaff) {
            $query->where('tbl_internship_application.assigned_staff_id', Auth::guard('college_staff')->id());
        }

        $data = $query->orderBy('tbl_internship_application.applied_on', 'desc')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('student_name', fn($r) => $r->user ? $r->user->name : 'N/A')
            ->addColumn('email', fn($r) => $r->user ? ($r->user->email ?: 'N/A') : 'N/A')
            ->addColumn('phone', fn($r) => $r->user ? ($r->user->contact_no ?: 'N/A') : 'N/A')
            ->addColumn('university_name', fn($r) => $r->user && $r->user->college && $r->user->college->university ? $r->user->college->university->university_name : 'N/A')
            ->addColumn('college_name', fn($r) => $r->user && $r->user->college ? $r->user->college->college_name : 'N/A')
            ->addColumn('applied_date', fn($r) => $r->applied_on ? $r->applied_on->format('d M Y') : 'N/A')
            ->addColumn('assigned_to', function ($r) {
                if ($r->assignedStaff) {
                    return '<span class="badge bg-success">' . e($r->assignedStaff->name) . '</span>';
                }
                return '<span class="badge bg-warning text-dark">Assign Pending</span>';
            })
            ->addColumn('checkbox', fn($r) => '<input type="checkbox" class="student-checkbox" value="' . $r->id . '">')
            ->addColumn('action', function ($r) use ($collegeCertificateAvailable) {
                $userId = $r->user ? $r->user->id : null;
                $url = $userId ? url('admin/candidate-profile/' . $userId) : '#';
                $buttons = '<div class="d-flex flex-wrap gap-1">'
                    . '<a href="' . $url . '" class="btn btn-sm btn-info" target="_blank"><i class="bx bx-user"></i> View Profile</a>';

                if ($collegeCertificateAvailable) {
                    $collegeUrl = route('admin.internship.certificate.preview', [
                        'applicationId' => $r->id,
                        'type' => 'college',
                    ]);
                    $buttons .= '<a href="' . $collegeUrl . '" class="btn btn-sm btn-warning" target="_blank" title="College Certificate">'
                        . '<i class="bx bx-certification"></i> College Certificate</a>';
                }

                $buttons .= '</div>';
                return $buttons;
            })
            ->rawColumns(['assigned_to', 'checkbox', 'action'])
            ->make(true);
    }

    // ─────────────────────────────────────────────────────────
    // 5.  Multi-Select & Assign Staff
    // ─────────────────────────────────────────────────────────

    /**
     * Get college staff list (for modal dropdown)
     */
    public function getStaffList(Request $request)
    {
        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $staff = CollegeStaff::where('college_id', $collegeId)
            ->where('active_status', 1)
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return response()->json(['success' => true, 'data' => $staff]);
    }

    /**
     * Assign staff to selected applications
     */
    public function assignStaff(Request $request)
    {
        $request->validate([
            'application_ids'   => 'required|array|min:1',
            'application_ids.*' => 'integer|exists:tbl_internship_application,id',
            'staff_id'          => 'required|integer|exists:tbl_college_staff,id',
        ]);

        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Verify the staff belongs to this college
        $staff = CollegeStaff::where('id', $request->staff_id)
            ->where('college_id', $collegeId)
            ->first();

        if (!$staff) {
            return response()->json(['success' => false, 'message' => 'Invalid staff selection.'], 422);
        }

        // Update only applications that belong to this college's students
        $updated = InternshipApplication::whereIn('tbl_internship_application.id', $request->application_ids)
            ->join('users', 'tbl_internship_application.user_id', '=', 'users.id')
            ->where('users.college_id', $collegeId)
            ->update(['tbl_internship_application.assigned_staff_id' => $request->staff_id]);

        return response()->json([
            'success' => true,
            'message' => $updated . ' student(s) assigned to ' . $staff->name . ' successfully.',
        ]);
    }

    // ─────────────────────────────────────────────────────────
    // 6.  College Staff Dashboard
    // ─────────────────────────────────────────────────────────

    /**
     * Staff dashboard: internships assigned to this staff member
     */
    public function getStaffInternships(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Invalid request'], 400);
        }

        $staffId = Auth::guard('college_staff')->check() ? Auth::guard('college_staff')->id() : Auth::id();
        if (!$staffId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Distinct internship IDs assigned to this staff
        $internshipIds = InternshipApplication::where('assigned_staff_id', $staffId)
            ->pluck('internship_id')
            ->unique();

        $internships = Internship::with(['company', 'jobCategory'])
            ->whereIn('id', $internshipIds)
            ->where('internship_type', 1)
            ->get();

        // Student count assigned to this staff per internship
        $studentCounts = InternshipApplication::where('assigned_staff_id', $staffId)
            ->whereIn('internship_id', $internshipIds)
            ->groupBy('internship_id')
            ->select('internship_id', DB::raw('COUNT(DISTINCT user_id) as total'))
            ->pluck('total', 'internship_id');

        return DataTables::of($internships)
            ->addIndexColumn()
            ->addColumn('company_name', fn($r) => $r->company ? $r->company->name : 'N/A')
            ->addColumn('category_name', fn($r) => $r->jobCategory ? $r->jobCategory->category_nm : 'N/A')
            ->addColumn('status_label', fn($r) => $this->statusBadge($this->computeStatus($r)))
            ->addColumn('total_students', fn($r) => $studentCounts[$r->id] ?? 0)
            ->addColumn('action', function ($r) {
                $url = route('admin.college-internship.view', $r->id);
                return '<a href="' . $url . '" class="btn btn-sm btn-info"><i class="bx bx-show"></i> View</a>';
            })
            ->rawColumns(['status_label', 'action'])
            ->make(true);
    }

    /**
     * Dashboard statistics (badge counts)
     */
    public function getStatistics()
    {
        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return response()->json(['processing' => 0, 'completed' => 0]);
        }

        $internshipIds = DB::table('tbl_internship_application as ia')
            ->join('users as u', 'ia.user_id', '=', 'u.id')
            ->join('tbl_internship as i', 'ia.internship_id', '=', 'i.id')
            ->where('u.college_id', $collegeId)
            ->whereNull('u.deleted_at')
            ->where('i.internship_type', 1)
            ->distinct()
            ->pluck('ia.internship_id');

        $processing = DB::table('tbl_internship')
            ->whereIn('id', $internshipIds)
            ->where('complete_status', '!=', 1)
            ->count();

        $completed = DB::table('tbl_internship')
            ->whereIn('id', $internshipIds)
            ->where('complete_status', 1)
            ->count();

        return response()->json(['processing' => $processing, 'completed' => $completed]);
    }

    /**
     * Confirm the logged-in college can access this internship.
     */
    private function ensureCollegeInternshipAccess($internshipId): Internship
    {
        $internship = Internship::findOrFail($internshipId);
        $collegeId = $this->getCollegeId();

        if (!$collegeId || (int) $internship->internship_type !== 1) {
            abort(403, 'Unauthorized');
        }

        $hasCollegeStudent = InternshipApplication::where('internship_id', $internship->id)
            ->whereHas('user', function ($q) use ($collegeId) {
                $q->where('college_id', $collegeId)->whereNull('deleted_at');
            })
            ->exists();

        abort_unless($hasCollegeStudent, 403, 'Unauthorized');

        return $internship;
    }

    /**
     * Student IDs from this college (and assigned staff, when applicable).
     */
    private function getCollegeStudentIdsForInternship($internshipId, $collegeId, $isStaff = false)
    {
        $query = InternshipApplication::query()
            ->join('users', 'tbl_internship_application.user_id', '=', 'users.id')
            ->where('tbl_internship_application.internship_id', $internshipId)
            ->where('users.college_id', $collegeId)
            ->whereNull('users.deleted_at');

        if ($isStaff && Auth::guard('college_staff')->check()) {
            $query->where('tbl_internship_application.assigned_staff_id', Auth::guard('college_staff')->id());
        }

        return $query->pluck('tbl_internship_application.user_id')->unique()->values();
    }

    public function getTaskSubmissions($id)
    {
        $masterTask = InternshipTask::where('id', $id)->whereNull('parent_id')->first();
        if (!$masterTask) {
            return response()->json(['error' => 'Task not found.'], 404);
        }

        $this->ensureCollegeInternshipAccess($masterTask->internship_id);
        $collegeId = $this->getCollegeId();
        $isStaff = Auth::guard('college_staff')->check();
        $collegeStudentIds = $this->getCollegeStudentIdsForInternship($masterTask->internship_id, $collegeId, $isStaff);

        $childTasks = InternshipTask::with('student')
            ->where('parent_id', $masterTask->id)
            ->when($collegeStudentIds->isNotEmpty(), fn ($q) => $q->whereIn('student_id', $collegeStudentIds))
            ->when($collegeStudentIds->isEmpty(), fn ($q) => $q->whereRaw('1 = 0'))
            ->get();

        $completed = $childTasks->where('status', 1)->count();
        $total = $childTasks->count();

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
                'submit_on' => $ct->submit_on ? Carbon::parse($ct->submit_on)->format('d M Y, h:i A') : null,
                'student_id' => $ct->student_id,
                'child_task_id' => $ct->id,
                'task_feedback' => $ct->task_feedback ?? null,
            ];
        }

        return response()->json([
            'task_title' => $masterTask->module_title ?? 'Untitled Task',
            'master_task_id' => $masterTask->id,
            'completed' => $completed,
            'pending' => $total - $completed,
            'total' => $total,
            'students' => $students,
        ]);
    }

    public function getStudentTaskNote($taskId, $studentId)
    {
        $childTask = InternshipTask::with('student')
            ->where('parent_id', $taskId)
            ->where('student_id', $studentId)
            ->first();

        if (!$childTask) {
            return response()->json(['error' => 'Task not found.'], 404);
        }

        $this->ensureCollegeInternshipAccess($childTask->internship_id);
        $this->ensureCollegeCanViewStudent($childTask->internship_id, $studentId);

        return response()->json([
            'student_name' => optional($childTask->student)->name ?? 'N/A',
            'task_title' => $childTask->module_title ?? 'Untitled Task',
            'status' => (int) $childTask->status,
            'submit_on' => $childTask->submit_on ? Carbon::parse($childTask->submit_on)->format('d M Y, h:i A') : null,
            'student_submit_file' => $childTask->student_submit_file ?? null,
            'student_submit_description' => $childTask->student_submit_description ?? '',
            'student_submit_project_link' => $childTask->student_submit_project_link ?? null,
            'task_feedback' => $childTask->task_feedback ?? null,
        ]);
    }

    public function getTaskFeedback($taskId, $studentId)
    {
        $childTask = InternshipTask::where('parent_id', $taskId)
            ->where('student_id', $studentId)
            ->first();

        if (!$childTask) {
            return response()->json(['error' => 'Task not found.'], 404);
        }

        $this->ensureCollegeInternshipAccess($childTask->internship_id);
        $this->ensureCollegeCanViewStudent($childTask->internship_id, $studentId);

        return response()->json([
            'task_title' => $childTask->module_title ?? 'Untitled Task',
            'status' => (int) $childTask->status,
            'task_feedback' => $childTask->task_feedback ?? null,
        ]);
    }

    private function ensureCollegeCanViewStudent($internshipId, $studentId): void
    {
        $collegeId = $this->getCollegeId();
        $isStaff = Auth::guard('college_staff')->check();
        $allowed = $this->getCollegeStudentIdsForInternship($internshipId, $collegeId, $isStaff);

        abort_unless($allowed->contains(fn ($id) => (int) $id === (int) $studentId), 403, 'Unauthorized');
    }
}
