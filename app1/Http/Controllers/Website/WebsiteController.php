<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\AdBanner;
use App\Models\Blog;
use App\Models\City;
use Illuminate\Http\Request;
use App\Helpers\WhatsappHelper; // or CandidateProfile if it's a separate model
use Yajra\DataTables\Facades\DataTables;


use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\PlanPricing;
use App\Models\JobCategory;
use App\Models\Jobsubcategory;
use App\Models\Jobtype;
use App\Models\WorkExperience;
use App\Models\Worktype;
use App\Models\Education;
use App\Models\Experiencereq;
use App\Models\JobApply;
use App\Models\JobApplyHistory;
use App\Models\Minqualification;
use App\Models\User;
use App\Models\Joblevel;
use App\Models\Job;
use App\Models\JobRound;
use App\Models\JobRoundComplete;
use App\Models\Jobsave;
use App\Models\Resume;
use App\Models\ResumeBuilder;
use App\Models\Testimonial;
use App\Models\Setting;
use App\Models\Partner;
use App\Models\Registration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;



use Barryvdh\DomPDF\Facade\Pdf;


use App\Models\Internship;
use App\Models\InternshipApplication;
use App\Models\InternshipMark;
use App\Models\Grade;
use App\Models\GradeSection;
use App\Models\GradeCriterion;

class WebsiteController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // if ($user) {
        //     $this->planValidityCheck($user);
        // }
        if ($user) {
            $redirect = $this->planValidityCheck($user);
            if ($redirect) {
                return $redirect; // 🔥 GAME CHANGER
            }
        }

        $CategoryData = DB::table('tbl_job_category as a')
            // ->leftJoin('tbl_job as b', 'a.category_id', '=', 'b.category_id')
            ->leftJoin('tbl_job as b', function ($join) {
        $join->on('a.category_id', '=', 'b.category_id')
             ->where('b.status', 1); // active jobs only
        })
            ->select('a.category_id', 'a.preference_type', 'a.category_nm', 'a.image', DB::raw('COUNT(b.job_id) as totalJob'))
            ->groupBy('a.category_id', 'a.category_nm', 'a.image', 'a.preference_type')
            ->whereNull('a.deleted_at')
            ->get();

        $JobCategoryData = JobCategory::get();
        $Joblocations = DB::table('tbl_city as a')
            ->join('tbl_state as b', 'a.state_id', '=', 'b.state_id')
            ->select(
                'a.city_id',
                'a.state_id',
                DB::raw("CONCAT(a.city_nm, ',', b.state_name) as location")
            )
            ->get();

        $Achievement = Achievement::get();
        $Blog = Blog::where('status', 1)->get();
        $About = Setting::where('id', 1)->first();

        $jobData = DB::table('tbl_job')
            ->select([
                'tbl_job.*',
                'tbl_work_type.type_nm as work_type_name',
                'tbl_city.city_nm',
                'tbl_min_qualification.name as qualification_nm',
            ])
            ->leftJoin('tbl_work_type', 'tbl_work_type.work_type_id', '=', 'tbl_job.work_type_id')
            ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'tbl_job.city_id')
            ->leftJoin('tbl_min_qualification', 'tbl_min_qualification.qualification_id', '=', 'tbl_job.qualification_id')
            ->whereNull('tbl_job.deleted_at') // ✅ Correct way to check for null
            ->where('tbl_job.status', 1) // only active jobs
            ->orderBy('tbl_job.datetime', 'desc')
            ->limit(8)
            ->get(); // 👈 Change 6 to how many per page

        $today = Carbon::today();
        $adBanner = AdBanner::where('page_nm', 1)->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)->first();
        $partner = Partner::where('status', 1)->get();
        return view('website.index', compact('CategoryData', 'JobCategoryData', 'Joblocations', 'Achievement', 'Blog', 'About', 'jobData', 'adBanner','partner'));
    }
    
    
    // internship
        public function internship(Request $request){
        // Get filter parameters
        $search = $request->input('search');
        $category = $request->input('category');
        $mode = $request->input('mode');
        $location = $request->input('location');
        $sortBy = $request->input('sort_by', 'latest'); // default: latest

        // Base query - only approved internships with available openings
        $query = Internship::with(['company', 'jobCategory'])
            ->where('approve_status', 1)
            ->where('complete_status', 0)
            ->whereNull('rejection_reason')
            ->withAvailableOpenings();

        // Search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('internship_title', 'LIKE', "%{$search}%")
                  ->orWhere('skills', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%");
            });
        }

        // Category filter
        if ($category) {
            $query->where('category', $category);
        }

        // Mode filter (Online/Offline/Hybrid)
        if ($mode) {
            $query->where('mode', $mode);
        }

        // Location filter
        if ($location) {
            $query->where('location', 'LIKE', "%{$location}%");
        }

        // Sorting
        switch ($sortBy) {
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'stipend_high':
                $query->orderBy('stipend', 'desc');
                break;
            case 'stipend_low':
                $query->orderBy('stipend', 'asc');
                break;
            case 'deadline':
                $query->orderBy('application_deadline', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Paginate results
        $internships = $query->paginate(10);

        // Get user's wishlist internship IDs
        $wishlistIds = [];
        if (Auth::check()) {
            $wishlistIds = \App\Models\InternshipWishlist::where('user_id', Auth::id())
                ->pluck('internship_id')
                ->toArray();
        }

        // Get featured internships (latest 6 with available openings)
        $featuredInternships = Internship::with(['company', 'jobCategory'])
            ->where('approve_status', 1)
            ->where('complete_status', 0)
            ->whereNull('rejection_reason')
            ->withAvailableOpenings()
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Get categories for filter dropdown
        $categories = JobCategory::select('category_id', 'category_nm', 'image')
            ->orderBy('category_nm', 'asc')
            ->get();

        // Get statistics
        $stats = [
            'total' => Internship::where('approve_status', 1)->where('complete_status', 0)->count(),
            'remote' => Internship::where('approve_status', 1)->where('complete_status', 0)->where('mode', 'Online')->count(),
            'onsite' => Internship::where('approve_status', 1)->where('complete_status', 0)->where('mode', 'Offline')->count(),
            'hybrid' => Internship::where('approve_status', 1)->where('complete_status', 0)->where('mode', 'Hybrid')->count(),
        ];

        return view('website.internship', compact('internships', 'categories', 'stats', 'wishlistIds', 'featuredInternships'));
    }

    public function internshipDetail($slugOrId){
        if (!$slugOrId) {
            return redirect()->route('internship')->with('error', 'Internship not found');
        }

        // Try to fetch by slug first, then by ID for backward compatibility
        $internship = Internship::with(['company', 'jobCategory'])
            ->withCount(['internshipApplications as apply_count'])
            ->where(function($query) use ($slugOrId) {
                $query->where('slug', $slugOrId)
                      ->orWhere('id', $slugOrId);
            })
            ->where('approve_status', 1)
            ->first();

        if (!$internship) {
            return redirect()->route('internship')->with('error', 'Internship not found or not available');
        }

        // Determine if the current authenticated user already applied to this internship
        $alreadyApplied = false;
        if (Auth::check()) {
            $alreadyApplied = DB::table('tbl_internship_application')
                ->where('internship_id', $internship->id)
                ->where('user_id', Auth::id())
                ->exists();
        }

        $openingsFull = !$internship->hasAvailableOpenings();

        if ($openingsFull && !$alreadyApplied) {
            return redirect()->route('internship')->with('error', 'This internship has no openings left.');
        }

        // Check if in wishlist
        $inWishlist = false;
        if (Auth::check()) {
            $inWishlist = \App\Models\InternshipWishlist::where('user_id', Auth::id())
                ->where('internship_id', $internship->id)
                ->exists();
        }

        // Fetch recent internships (excluding current one, only with openings)
        $recentInternships = Internship::with(['company', 'jobCategory'])
            ->where('approve_status', 1)
            ->where('complete_status', 0)
            ->where('id', '!=', $internship->id)
            ->withAvailableOpenings()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Calculate days left for application
        $daysLeft = null;
        if ($internship->application_deadline) {
            $deadline = \Carbon\Carbon::parse($internship->application_deadline);
            $now = \Carbon\Carbon::now();
            $daysLeft = $now->diffInDays($deadline, false);
        }

        // Parse batch days if JSON
        $batchDays = [];
        if ($internship->batch_days) {
            if (is_string($internship->batch_days)) {
                $decoded = json_decode($internship->batch_days, true);
                if (is_array($decoded)) {
                    // Convert associative array to indexed array
                    foreach ($decoded as $day => $times) {
                        $batchDays[] = [
                            'day' => $day,
                            'start_time' => $times['start_time'] ?? null,
                            'end_time' => $times['end_time'] ?? null
                        ];
                    }
                }
            } elseif (is_array($internship->batch_days)) {
                // Convert associative array to indexed array
                foreach ($internship->batch_days as $day => $times) {
                    if (is_array($times)) {
                        $batchDays[] = [
                            'day' => $day,
                            'start_time' => $times['start_time'] ?? null,
                            'end_time' => $times['end_time'] ?? null
                        ];
                    }
                }
            }
        }

        return view('website.internship-detail', compact('internship', 'daysLeft', 'batchDays', 'inWishlist', 'recentInternships', 'alreadyApplied', 'openingsFull'));
    }
    
    
    public function toggleWishlist(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to save internships',
                'redirect' => route('login')
            ], 401);
        }

        $request->validate([
            'internship_id' => 'required|exists:tbl_internship,id'
        ]);

        $userId = Auth::id();
        $internshipId = $request->internship_id;

        // Check if already in wishlist
        $wishlist = \App\Models\InternshipWishlist::where('user_id', $userId)
            ->where('internship_id', $internshipId)
            ->first();

        if ($wishlist) {
            // Remove from wishlist
            $wishlist->delete();
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Internship removed from wishlist'
            ]);
        } else {
            // Add to wishlist
            \App\Models\InternshipWishlist::create([
                'user_id' => $userId,
                'internship_id' => $internshipId
            ]);
            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => 'Internship added to wishlist'
            ]);
        }
    }
    
      public function checkWishlist(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['in_wishlist' => false]);
        }

        $internshipId = $request->internship_id;
        $inWishlist = \App\Models\InternshipWishlist::where('user_id', Auth::id())
            ->where('internship_id', $internshipId)
            ->exists();

        return response()->json(['in_wishlist' => $inWishlist]);
    }


 public function getInternshipPaymentData(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|integer|exists:tbl_internship,id'
        ]);

        $internship = \App\Models\Internship::select(
            'id', 'internship_title', 'duration', 'registration_fees',
            'gst_percentage', 'gst_amount', 'final_amount'
        )->findOrFail($request->internship_id);

        return response()->json([
            'success' => true,
            'data' => [
                'internship_title' => $internship->internship_title,
                'duration' => $internship->duration,
                'registration_fees' => number_format($internship->registration_fees, 2),
                'gst_percentage' => $internship->gst_percentage,
                'gst_amount' => number_format($internship->gst_amount, 2),
                'final_amount' => number_format($internship->final_amount, 2),
                'final_amount_raw' => $internship->final_amount
            ]
        ]);
    }
    
     public function submitCollegeInfo(Request $request)
    {
        // Require authenticated user to update their profile
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'login_required'
            ], 401);
        }

        $user = Auth::user();

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

        // Use DB transaction to avoid partial updates
        DB::beginTransaction();
        try {
            // If university other provided (either select was 'other' or select empty but other has value)
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
                // Note: primary key is degree_level_id
                $degreeLevelId = $degreeLevel->degree_level_id;
            }

            // If college other provided (either select was 'other' or select empty but other has value)
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
                'success' => true,
                'university_id' => $user->university_id,
                'college_id' => $user->college_id,
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::error('submitCollegeInfo error: ' . $ex->getMessage());
            return response()->json(['success' => false, 'message' => 'server_error'], 500);
        }
    }
    
    
       public function createInternshipApplication(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|integer|exists:tbl_internship,id'
        ]);

        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'login_required'], 401);
        }

        $userId = Auth::id();
        $internship = \App\Models\Internship::find($request->internship_id);

        if (!$internship) {
            return response()->json(['success' => false, 'message' => 'invalid_internship'], 404);
        }

        if ((int) $internship->approve_status !== 1) {
            return response()->json(['success' => false, 'message' => 'internship_not_available'], 403);
        }

        if ((int) $internship->complete_status === 1) {
            return response()->json(['success' => false, 'message' => 'internship_closed'], 409);
        }

        // Avoid duplicate application rows for same user+internship
        $existing = \App\Models\InternshipApplication::where('user_id', $userId)
            ->where('internship_id', $internship->id)
            ->first();

        if ($existing) {
            // User already applied — do not create another application or payment
            return response()->json(['success' => false, 'message' => 'already_applied'], 409);
        }

        $appliedCount = \App\Models\InternshipApplication::where('internship_id', $internship->id)->count();
        if ($internship->openings > 0 && $appliedCount >= (int) $internship->openings) {
            return response()->json(['success' => false, 'message' => 'no_openings'], 409);
        }

        $user = User::findOrFail($userId);

        if (!$user->college_id || !$user->degree_id) {
            return response()->json([
                'success' => false,
                'message' => 'college_info_required',
            ], 422);
        }

        $application = \App\Models\InternshipApplication::create([
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

        // Create a payment record linked to this application
        try {
            $txn = $this->generatePaymentTransactionId();

            $payment = \App\Models\InternshipPayment::create([
                'application_id' => $application->id,
                'user_id' => $userId,
                'internship_id' => $internship->id,
                'gst_percentage' => $internship->gst_percentage ?? 0,
                'gst_amount' => $internship->gst_amount ?? 0,
                'total_amount' => $internship->final_amount ?? 0,
                'payment_mode' => 'online',
                'transaction_id' => $txn,
                'payment_status' => 1,
                'paid_on' => now(),
                'payment_response_data' => null,
                'payment_transaction_id' => null,
            ]);
            // Duplicate master tasks for this internship as per-student tasks
            try {
                $this->duplicateTasksForStudent($internship->id, $userId);
            } catch (\Exception $e) {
                // Log but don't fail the whole request
                \Log::error('Failed to duplicate tasks for student: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            // If payment record creation fails, log and continue — return partial success
            \Log::error('Failed to create internship payment: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'payment_create_failed']);
        }

        return response()->json([
            'success' => true,
            'message' => 'created',
            'application_id' => $application->id,
            'payment_id' => $payment->id ?? null,
            'transaction_id' => $txn ?? null,
        ]);
    }
    
    
     /**
     * Duplicate master internship tasks for a specific student.
     * Creates child tasks with parent_id pointing to the master task and student_id set.
     *
     * @param int $internshipId
     * @param int $studentId
     * @return void
     */
    private function duplicateTasksForStudent($internshipId, $studentId)
    {
        // Fetch master tasks (tasks without parent)
        $masterTasks = \App\Models\InternshipTask::where('internship_id', $internshipId)
            ->whereNull('parent_id')
            ->get();

        foreach ($masterTasks as $task) {
            // Skip if already duplicated for this student
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
                'upload_file' => $task->upload_file, // keep reference or set null
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
    }

    
    
      public function getUniversities()
    {
        $universities = \App\Models\University::where('status', 1)
            ->orderBy('university_name')
            ->get(['id', 'university_name']);
        return response()->json($universities);
    }

    public function getCollegesByUniversity(Request $request)
    {
        $colleges = \App\Models\College::where('university_id', $request->university_id)
            ->where('status', 1)
            ->orderBy('college_name')
            ->get(['id', 'college_name']);
        return response()->json($colleges);
    }

    public function getDegreeLevels()
    {
        $levels = \App\Models\DegreeLevel::orderBy('degree_level_name')
            ->get(['degree_level_id', 'degree_level_name']);
        return response()->json($levels);
    }

    public function getDegreesByLevel(Request $request)
    {
        $degrees = \App\Models\Degree::where('degree_level_id', $request->degree_level_id)
            ->orderBy('degree_name')
            ->get(['degree_id', 'degree_name']);
        return response()->json($degrees);
    }

    public function getMajorsByDegree(Request $request)
    {
        $majors = \App\Models\Major::where('degree_id', $request->degree_id)
            ->orderBy('major_name')
            ->get(['major_id', 'major_name']);
        return response()->json($majors);
    }

    /**
     * Return degrees configured for a given college.
     * Response contains degree_id, degree_name, degree_level_id and degree_level_name
     */
    public function getDegreesByCollege(Request $request)
    {
        $request->validate([
            'college_id' => 'required|integer|exists:tbl_college,id',
        ]);

        $college = \App\Models\College::findOrFail($request->college_id);
        $degreeIds = $college->degree_ids ?? [];
        if (!is_array($degreeIds)) {
            $degreeIds = json_decode($degreeIds, true) ?: [];
        }
        $degreeIds = array_filter($degreeIds);

        if (empty($degreeIds)) {
            return response()->json([]);
        }

        $degrees = \Illuminate\Support\Facades\DB::table('tbl_degree as d')
            ->join('tbl_degree_level as dl', 'd.degree_level_id', '=', 'dl.degree_level_id')
            ->select('d.degree_id', 'd.degree_name', 'd.degree_level_id', 'dl.degree_level_name')
            ->whereIn('d.degree_id', $degreeIds)
            ->whereNull('d.deleted_at')
            ->orderBy('d.degree_name')
            ->get();

        return response()->json($degrees);
    }

    /**
     * Return majors for a degree only if that degree is assigned to the college.
     */
    public function getMajorsByDegreeAndCollege(Request $request)
    {
        $request->validate([
            'college_id' => 'required|integer|exists:tbl_college,id',
            'degree_id' => 'required|integer|exists:tbl_degree,degree_id',
        ]);

        $college = \App\Models\College::findOrFail($request->college_id);
        $degreeIds = $college->degree_ids ?? [];
        if (!is_array($degreeIds)) {
            $degreeIds = json_decode($degreeIds, true) ?: [];
        }

        if (!in_array($request->degree_id, $degreeIds)) {
            // Degree not assigned to this college — return empty list
            return response()->json([]);
        }

        $majors = \App\Models\Major::where('degree_id', $request->degree_id)
            ->orderBy('major_name')
            ->get(['major_id', 'major_name']);

        return response()->json($majors);
    }



  public function my_internship_details(Request $request, $slug)
    {
        $user = Auth::user();

        // Resolve internship by slug
        $internship = Internship::with(['company', 'tasks', 'jobCategory'])
            ->where('slug', $slug)
            ->first();

        if (!$internship) {
            return redirect()->route('candidate-profile')->with('error', 'Internship not found');
        }

        // Optional: ensure the user applied to this internship. Remove if not desired.
        $application = InternshipApplication::where('internship_id', $internship->id)
            ->where('user_id', optional($user)->id)
            ->first();

        if (!$application) {
            return redirect()->route('candidate-profile')->with('error', 'You have not applied to this internship');
        }

        $companyCertificateAvailable = (int) ($internship->company_complete_sts ?? 0) === 1;
        $collegeCertificateAvailable = (int) ($internship->internship_type ?? 0) === 1
            && (int) ($internship->college_complete_sts ?? 0) === 1;
        $certificatesAvailable = $companyCertificateAvailable || $collegeCertificateAvailable;

        // Prepare formatted dates
        $startDateFormatted = $internship->start_date ? Carbon::parse($internship->start_date)->format('d F Y') : null;
        $endDateFormatted = $internship->end_date ? Carbon::parse($internship->end_date)->format('d F Y') : null;

        // Load any existing review by this student for this internship
        $userReview = null;
        if ($user) {
            $userReview = DB::table('tbl_internship_review')
                ->where('internship_id', $internship->id)
                ->where('student_id', $user->id)
                ->first();
        }

        return view('website.my-internship-details', compact(
            'internship',
            'startDateFormatted',
            'endDateFormatted',
            'userReview',
            'application',
            'companyCertificateAvailable',
            'collegeCertificateAvailable',
            'certificatesAvailable'
        ));
    }

    /**
     * Student: preview own internship certificate (same design as admin panel).
     */
    public function previewMyCertificate($applicationId, $type)
    {
        $this->ensureStudentOwnsCertificateApplication((int) $applicationId);

        return app(\App\Http\Controllers\Admin\InternshipController::class)
            ->previewStudentCertificate($applicationId, $type);
    }

    /**
     * Student: download own internship certificate PDF.
     */
    public function downloadMyCertificate($applicationId, $type)
    {
        $this->ensureStudentOwnsCertificateApplication((int) $applicationId);

        return app(\App\Http\Controllers\Admin\InternshipController::class)
            ->downloadStudentCertificate($applicationId, $type);
    }

    /**
     * Ensure the logged-in student owns the internship application.
     */
    private function ensureStudentOwnsCertificateApplication(int $applicationId): InternshipApplication
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized access.');
        }

        $application = InternshipApplication::where('id', $applicationId)
            ->where('user_id', $user->id)
            ->first();

        if (!$application) {
            abort(403, 'You are not authorized to access this certificate.');
        }

        return $application;
    }


  public function submitTask(Request $request)
    {
        $request->validate([
            'task_id' => 'required|integer',
            'task_file' => 'required|file|mimes:pdf|max:10240',
            'task_notes' => 'nullable|string',
            'project_link' => 'nullable|url',
        ]);

        $user = Auth::user();
        $task = \App\Models\InternshipTask::where('id', $request->input('task_id'))
            ->where('student_id', $user->id)
            ->first();

        if (!$task) {
            return back()->with('error', 'Task not found or not assigned to you.');
        }

        // Handle file upload to public/uploads/internship_tasks_submit
        if ($request->hasFile('task_file')) {
            // delete previous student submission file if exists
            if ($task->student_submit_file && file_exists(public_path('uploads/internship_tasks_submit/' . $task->student_submit_file))) {
                @unlink(public_path('uploads/internship_tasks_submit/' . $task->student_submit_file));
            }

            $file = $request->file('task_file');
            $ext = $file->getClientOriginalExtension();
            $filename = 'student_task_' . $task->id . '_' . time() . '.' . $ext;
            $destination = public_path('uploads/internship_tasks_submit');
            if (!\File::exists($destination)) {
                \File::makeDirectory($destination, 0755, true);
            }
            $file->move($destination, $filename);

            $task->student_submit_file = $filename;
        }

        $task->student_submit_description = $request->input('task_notes');
        $task->student_submit_project_link = $request->input('project_link');
        $task->submit_on = now();
        $task->status = 1; // mark completed
        $task->save();

        return back()->with('success', 'Task submitted successfully.');
    }
    
    
        /**
     * Display internship application history page
     */
    public function internshipApplicationHistory(Request $request, $slug = null)
    {
        // Require authentication
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your internship applications');
        }

        // Resolve internship by slug or id (accept either)
        $internship = null;
        $internshipId = null;

        if (!empty($slug)) {
            $internship = Internship::with(['company', 'jobCategory'])
                ->where(function ($query) use ($slug) {
                    $query->where('slug', $slug)
                          ->orWhere('id', $slug);
                })
                ->first();

            if ($internship) {
                $internshipId = $internship->id;
            }
        }

        // Fallback to query param if provided
        if (empty($internshipId)) {
            $internshipId = $request->query('internship_id');
        }

        // If we only have an id, try to load the internship
        if (empty($internship) && !empty($internshipId)) {
            $internship = Internship::with(['company', 'jobCategory'])->find($internshipId);
        }

        if (!$internship) {
            return redirect()->back()->with('error', 'Internship not found');
        }

        // Only the owning company can view applicant history / manage this internship
        if ((int) $internship->company_id !== (int) Auth::id()) {
            return redirect()->route('company-profile')->with('error', 'You are not authorized to view this internship.');
        }

        // Load applications for this internship
        $applications = \App\Models\InternshipApplication::with(['user'])
            ->where('internship_id', $internship->id)
            ->orderBy('applied_on', 'desc')
            ->get();

        // Load tasks assigned to the current user for this internship (My Tasks)
        $myTasks = collect();
        if (\Auth::check()) {
            $myTasks = \App\Models\InternshipTask::where('internship_id', $internship->id)
                ->where('parent_id', null) // only master tasks
                ->orderBy('date_time', 'asc')
                ->get();
        }

        // Compute totals for dashboard display
        $totalTasks = $myTasks->count();
        $completedTasks = 0;
        if ($totalTasks > 0) {
            foreach ($myTasks as $t) {
                $children = \App\Models\InternshipTask::where('parent_id', $t->id)->get();
                if ($children->count() > 0 && $children->where('status', 1)->count() == $children->count()) {
                    $completedTasks++;
                }
            }
        }

        // ===== Complete Internship Tab Data =====
        // Fetch enrolled students with college + degree info
        $students = InternshipApplication::with(['user.college', 'user.degree'])
            ->where('internship_id', $internship->id)
            ->get();

        // Build per-student Industry Marks criteria keyed by student_id, cached by college_id:degree_id
        $completeCriteriaCache      = [];
        $studentCriteriaMap         = [];
        foreach ($students as $app) {
            $student = $app->user;
            if (!$student) continue;
            $cKey = "{$student->college_id}:{$student->degree_id}";
            if (!array_key_exists($cKey, $completeCriteriaCache)) {
                $grade = Grade::where('college_id', $student->college_id)
                    ->when($student->degree_id, fn($q) => $q->where('course_id', $student->degree_id))
                    ->first();
                $industryCrit = collect();
                if ($grade) {
                    $ids = GradeSection::where('grade_id', $grade->id)
                        ->where('title', 'Industry Marks')->pluck('id');
                    $industryCrit = GradeCriterion::whereIn('section_id', $ids)
                        ->whereNull('deleted_at')->get();
                }
                $completeCriteriaCache[$cKey] = $industryCrit;
            }
            $studentCriteriaMap[$student->id] = $completeCriteriaCache[$cKey];
        }
        $hasIndustryCriteria = collect($studentCriteriaMap)->flatten(1)->isNotEmpty();

        // Pre-load saved marks
        $savedMarks = InternshipMark::where('internship_id', $internship->id)
            ->get()
            ->groupBy('student_id');

        // Pre-load feedback from applications
        $feedbackColumn = $internship->internship_type == 2 ? 'college_feedback' : 'company_feedback';
        $savedFeedbacks = InternshipApplication::where('internship_id', $internship->id)
            ->pluck($feedbackColumn, 'user_id');

        // ===== Marks History Tab Data (visible when college or company has submitted) =====
        $marksStudents = [];
        $marksGrouped  = [];

        if ($internship->college_complete_sts == 1 || $internship->company_complete_sts == 1 || $internship->complete_status == 1) {
            $markApplications = InternshipApplication::with(['user.college.university', 'user.degree'])
                ->where('internship_id', $internship->id)
                ->get();

            // Grade letter helper
            $gradeLetter = function (float $pct): string {
                if ($pct >= 90) return 'A+';
                if ($pct >= 80) return 'A';
                if ($pct >= 70) return 'B';
                if ($pct >= 60) return 'C';
                if ($pct >= 50) return 'D';
                if ($pct >  0)  return 'F';
                return '-';
            };

            // Build per-student criteria cache keyed by "college_id:degree_id"
            $criteriaCache = [];
            foreach ($markApplications as $app) {
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
            }

            // Collect all criteria IDs for one marks query
            $allCriteriaIds = collect();
            foreach ($criteriaCache as $crit) {
                $allCriteriaIds = $allCriteriaIds->merge($crit['college']->pluck('id'));
                $allCriteriaIds = $allCriteriaIds->merge($crit['industry']->pluck('id'));
            }
            $allCriteriaIds = $allCriteriaIds->unique()->values();

            $allMarksByStudent = InternshipMark::where('internship_id', $internship->id)
                ->when($allCriteriaIds->isNotEmpty(), fn($q) => $q->whereIn('criteria_id', $allCriteriaIds))
                ->get()
                ->groupBy('student_id');

            $allFeedbacks = InternshipApplication::where('internship_id', $internship->id)
                ->get()->keyBy('user_id');

            foreach ($markApplications as $app) {
                $student = $app->user;
                if (!$student) continue;

                $cKey = "{$student->college_id}:{$student->degree_id}";
                $collegeCrit  = $criteriaCache[$cKey]['college']  ?? collect();
                $industryCrit = $criteriaCache[$cKey]['industry'] ?? collect();
                $studentMarks = ($allMarksByStudent->get($student->id, collect()))->keyBy('criteria_id');

                $collegeTotal = 0; $collegeMaxTotal = 0; $collegeMarksData = [];
                foreach ($collegeCrit as $c) {
                    $collegeMaxTotal += $c->marks;
                    $mark = $studentMarks->get($c->id);
                    $mv = $mark ? min($mark->marks, $c->marks) : 0;
                    $collegeTotal += $mv;
                    $collegeMarksData[$c->id] = $mv;
                }
                $collegePct = $collegeMaxTotal > 0 ? round(($collegeTotal / $collegeMaxTotal) * 100, 2) : 0;

                $industryTotal = 0; $industryMaxTotal = 0; $industryMarksData = [];
                foreach ($industryCrit as $c) {
                    $industryMaxTotal += $c->marks;
                    $mark = $studentMarks->get($c->id);
                    $mv = $mark ? min($mark->marks, $c->marks) : 0;
                    $industryTotal += $mv;
                    $industryMarksData[$c->id] = $mv;
                }
                $industryPct = $industryMaxTotal > 0 ? round(($industryTotal / $industryMaxTotal) * 100, 2) : 0;

                $combinedTotal    = $collegeTotal    + $industryTotal;
                $combinedMaxTotal = $collegeMaxTotal + $industryMaxTotal;
                $combinedPct      = $combinedMaxTotal > 0 ? round(($combinedTotal / $combinedMaxTotal) * 100, 2) : 0;

                $appRow = $allFeedbacks->get($student->id);
                $collegeName = optional($student->college)->college_name ?? 'N/A';
                $degreeName  = optional($student->degree)->degree_name    ?? 'N/A';
                $groupKey    = $collegeName . '||' . $degreeName;

                $row = [
                    'id'                  => $student->id,
                    'name'                => $student->name,
                    'college_name'        => $collegeName,
                    'degree_name'         => $degreeName,
                    'group_key'           => $groupKey,
                    'college_criteria'    => $collegeCrit,
                    'industry_criteria'   => $industryCrit,
                    'college_marks'       => $collegeMarksData,
                    'industry_marks'      => $industryMarksData,
                    'college_feedback'    => $appRow->college_feedback ?? '',
                    'company_feedback'    => $appRow->company_feedback ?? '',
                    'college_total'       => $collegeTotal,
                    'college_max_total'   => $collegeMaxTotal,
                    'college_percentage'  => $collegePct,
                    'college_grade'       => $gradeLetter($collegePct),
                    'industry_total'      => $industryTotal,
                    'industry_max_total'  => $industryMaxTotal,
                    'industry_percentage' => $industryPct,
                    'industry_grade'      => $gradeLetter($industryPct),
                    'combined_total'      => $combinedTotal,
                    'combined_max_total'  => $combinedMaxTotal,
                    'combined_percentage' => $combinedPct,
                    'combined_grade'      => $gradeLetter($combinedPct),
                ];
                $marksStudents[] = $row;
                $marksGrouped[$groupKey][] = $row;
            }
        }

        return view('website.internship-application-history', compact(
            'internship', 'applications', 'myTasks', 'totalTasks', 'completedTasks',
            'students', 'studentCriteriaMap', 'hasIndustryCriteria', 'savedMarks', 'savedFeedbacks',
            'marksStudents', 'marksGrouped'
        ));
    }
    
    
        /**
     * Return task details as JSON for AJAX view.
     */
    public function getTaskJson($id)
    {
        $user = Auth::user();

        // Allow viewing master tasks (parent_id IS NULL) for company users,
        // and student-specific tasks for student users
        $task = \App\Models\InternshipTask::where('id', $id)
            ->where(function ($q) use ($user) {
                $q->whereNull('parent_id') // master task — any authenticated user can view
                  ->orWhere('student_id', $user->id); // or student's own task
            })
            ->first();

        if (!$task) {
            return response()->json(['error' => 'Task not found.'], 404);
        }

        // Safely parse dates using Carbon
        $dateTime = null;
        if (!empty($task->date_time)) {
            $dateTime = Carbon::parse($task->date_time)->format('Y-m-d H:i:s');
        } elseif (!empty($task->created_at)) {
            $dateTime = Carbon::parse($task->created_at)->format('Y-m-d H:i:s');
        }

        $dueDate = null;
        if (!empty($task->last_submission_date)) {
            $dueDate = Carbon::parse($task->last_submission_date)->format('Y-m-d');
        } elseif (!empty($task->due_date)) {
            $dueDate = Carbon::parse($task->due_date)->format('Y-m-d');
        }

        $submitOn = null;
        if (!empty($task->submit_on)) {
            $submitOn = Carbon::parse($task->submit_on)->format('Y-m-d H:i:s');
        }

        return response()->json([
            'id' => $task->id,
            'title' => $task->module_title ?? 'Untitled Task',
            // also include legacy `description` key for frontend compatibility
            'description' => $task->module_description ?? '',
            'date_time' => $dateTime,
            'day' => $task->day ?? null,
            'due_date' => $dueDate,
            'module_description' => $task->module_description ?? '',
            // use key expected by frontend JS
            'student_submit_description' => $task->student_submit_description ?? '',
            'status' => $task->status ?? 0,
            'upload_file' => $task->upload_file ?? null,
            'online_link' => $task->online_link ?? null,
            'is_final_assignment' => $task->is_final_assignment ? true : false,
            'student_submit_file' => $task->student_submit_file ?? null,
            'student_submit_project_link' => $task->student_submit_project_link ?? null,
            'submit_on' => $submitOn,
            // include instructor feedback if present
            'task_feedback' => $task->task_feedback ?? null,
            // optional metadata for feedback (if stored on the task)
            'feedback_by_name' => $task->feedback_by_name ?? null,
            'feedback_on' => !empty($task->feedback_on) ? Carbon::parse($task->feedback_on)->format('Y-m-d H:i:s') : null,
        ]);
    }
    
    
       /**
     * Return all student submissions for a master task as JSON.
     */
    public function getTaskSubmissions($id)
    {
        // Load the master task
        $masterTask = \App\Models\InternshipTask::where('id', $id)
            ->whereNull('parent_id')
            ->first();

        if (!$masterTask) {
            return response()->json(['error' => 'Task not found.'], 404);
        }

        // Get all child tasks (student copies) with student info
        $childTasks = \App\Models\InternshipTask::with('student')
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
        $childTask = \App\Models\InternshipTask::with('student')
            ->where('parent_id', $taskId)
            ->where('student_id', $studentId)
            ->first();

        if (!$childTask) {
            return response()->json(['error' => 'Task not found.'], 404);
        }

        $student = $childTask->student;

        return response()->json([
            'student_name' => optional($student)->name ?? 'N/A',
            'task_title' => $childTask->module_title ?? 'Untitled Task',
            'status' => (int) $childTask->status,
            'submit_on' => $childTask->submit_on ? Carbon::parse($childTask->submit_on)->format('d M Y, h:i A') : null,
            'student_submit_file' => $childTask->student_submit_file ?? null,
            'student_submit_description' => $childTask->student_submit_description ?? '',
            'student_submit_project_link' => $childTask->student_submit_project_link ?? null,
            'task_feedback' => $childTask->task_feedback ?? null,
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

        $childTask = \App\Models\InternshipTask::where('parent_id', $request->input('task_id'))
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
     * Get task feedback for a child task.
     */
    public function getTaskFeedback($taskId, $studentId)
    {
        $childTask = \App\Models\InternshipTask::where('parent_id', $taskId)
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
     * Update a master task (website-facing).
     */
    public function updateTask(Request $request, $taskId)
    {
        $request->validate([
            'date_time' => 'required|date',
            'day' => 'nullable|string|max:50',
            'module_title' => 'required|string|max:255',
            'module_description' => 'required|string',
            'upload_file' => 'nullable|file|mimes:pdf|max:10240',
            'last_submission_date' => 'required|date',
            'online_link' => 'nullable|url',
            'is_final_assignment' => 'nullable',
        ]);

        $task = \App\Models\InternshipTask::where('id', $taskId)
            ->whereNull('parent_id')
            ->firstOrFail();

        $task->date_time = $request->date_time;
        $task->day = $request->day;
        $task->module_title = $request->module_title;
        $task->module_description = $request->module_description;
        $task->last_submission_date = $request->last_submission_date;
        $task->online_link = $request->online_link;
        $task->is_final_assignment = $request->is_final_assignment ? 1 : 0;

        if ($request->hasFile('upload_file')) {
            if ($task->upload_file && file_exists(public_path('uploads/internship_tasks/' . $task->upload_file))) {
                @unlink(public_path('uploads/internship_tasks/' . $task->upload_file));
            }
            $file = $request->file('upload_file');
            $fileName = time() . '_task_file.pdf';
            $file->move(public_path('uploads/internship_tasks'), $fileName);
            $task->upload_file = $fileName;
        }

        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully!',
        ]);
    }

    /**
     * Delete a master task and its child tasks (website-facing).
     */
    public function deleteTask($taskId)
    {
        $task = \App\Models\InternshipTask::where('id', $taskId)
            ->whereNull('parent_id')
            ->firstOrFail();

        // Delete file if exists
        if ($task->upload_file && file_exists(public_path('uploads/internship_tasks/' . $task->upload_file))) {
            @unlink(public_path('uploads/internship_tasks/' . $task->upload_file));
        }

        // Delete child tasks
        \App\Models\InternshipTask::where('parent_id', $task->id)->delete();

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully!',
        ]);
    }

    /**
     * Save internship review submitted by student (AJAX JSON)
     */
    public function saveInternshipReview(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|integer',
            'student_id' => 'required|integer',
            'star' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $user = Auth::user();
        if (!$user || $user->id != $request->input('student_id')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = [
            'internship_id' => $request->input('internship_id'),
            'student_id' => $request->input('student_id'),
            'star' => $request->input('star'),
            'review' => $request->input('review'),
            'active_status' => $request->input('active_status', 1),
            'write_on' => $request->input('write_on') ? Carbon::parse($request->input('write_on')) : now(),
            'updated_at' => now(),
        ];

        $exists = DB::table('tbl_internship_review')
            ->where('internship_id', $data['internship_id'])
            ->where('student_id', $data['student_id'])
            ->first();

        if ($exists) {
            DB::table('tbl_internship_review')->where('id', $exists->id)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('tbl_internship_review')->insert($data);
        }

        return response()->json(['success' => true, 'message' => 'Review saved successfully.']);
    }

    /**
     * Get general instructions for an internship (AJAX)
     */
    public function getInstructions($id)
    {
        $internship = Internship::find($id);
        if (!$internship) {
            return response()->json(['success' => false, 'message' => 'Internship not found.'], 404);
        }

        return response()->json([
            'success' => true,
            'instructions' => $internship->general_instructions ?? null,
        ]);
    }

    /**
     * Save general instructions for an internship (AJAX)
     */
    public function saveInstructions(Request $request, $id)
    {
        $request->validate([
            'instructions' => 'nullable|string',
        ]);

        $internship = Internship::find($id);
        if (!$internship) {
            return response()->json(['success' => false, 'message' => 'Internship not found.'], 404);
        }

        $internship->general_instructions = $request->input('instructions');
        $internship->save();

        return response()->json(['success' => true, 'message' => 'Instructions saved successfully.', 'instructions' => $internship->general_instructions]);
    }

    
    
     // ==================== COMPANY INTERNSHIP MANAGEMENT ====================
    
    /**
     * Store new internship from company profile
     */
    public function companyInternshipStore(Request $request)
    {
        // Decode batch_days if it's a JSON string
        if ($request->has('batch_days') && is_string($request->batch_days)) {
            $request->merge(['batch_days' => json_decode($request->batch_days, true)]);
        }

        $request->validate([
            'internship_title' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'company_website' => 'nullable|url|max:255',
            'internship_mode' => 'required|in:Online,Offline,Hybrid',
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
            'gst_percentage' => 'nullable|numeric|min:0|max:100',
            'gst_amount' => 'nullable|numeric|min:0',
            'total_fee' => 'nullable|numeric|min:0',
        ]);

        try {
            $user = Auth::user();
            
            // Generate unique slug
            $slug = Str::slug($request->internship_title);
            $originalSlug = $slug;
            $counter = 1;
            
            // Include soft-deleted rows — unique index still applies to them
            while (Internship::withTrashed()->where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            // Prepare batch days
            $batchDays = $request->batch_days ?? [];
            
            // Prepare perks (handle array from select2)
            $perks = $request->perks ?? [];

            $registrationFees = (float) ($request->internship_fee ?? 0);
            $gstPercentage = (float) ($request->gst_percentage ?? 0);
            $gstAmount = $request->filled('gst_amount')
                ? (float) $request->gst_amount
                : round(($registrationFees * $gstPercentage) / 100, 2);
            $finalAmount = $request->filled('total_fee')
                ? (float) $request->total_fee
                : round($registrationFees + $gstAmount, 2);
            
            // Create internship
            $internship = Internship::create([
                'internship_title' => $request->internship_title,
                'slug' => $slug,
                'category' => $request->category_id,
                'company_id' => $user->id,
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
                'batch_days' => $batchDays,
                'skills' => $request->required_skills,
                'eligibility_criteria' => $request->required_eligibility_criteria,
                'perks' => $perks,
                'internship_description' => $request->internship_description,
                'module_brief_description' => $request->module_description,
                'internship_objective' => $request->internship_objective,
                'internship_outcome' => $request->internship_outcome,
                'registration_fees' => $registrationFees,
                'gst_percentage' => $gstPercentage,
                'gst_amount' => $gstAmount,
                'final_amount' => $finalAmount,
                'complete_status' => 0,
                'approve_status' => 0, // Pending approval
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Internship created successfully! It will be visible after admin approval.',
                'internship_id' => $internship->id
            ]);
                
        } catch (\Exception $e) {
            \Log::error('Internship Store Error: ' . $e->getMessage());
            \Log::error('Stack Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create internship: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update internship from company profile
     */
    public function companyInternshipUpdate(Request $request, $id)
    {
        // Decode JSON strings if they exist
        if ($request->has('batch_days') && is_string($request->batch_days)) {
            $request->merge(['batch_days' => json_decode($request->batch_days, true)]);
        }
        if ($request->has('required_skills') && is_string($request->required_skills)) {
            $request->merge(['required_skills' => $request->required_skills]);
        }
        if ($request->has('required_eligibility_criteria') && is_string($request->required_eligibility_criteria)) {
            $request->merge(['required_eligibility_criteria' => $request->required_eligibility_criteria]);
        }
        if ($request->has('perks') && is_string($request->perks)) {
            $request->merge(['perks' => json_decode($request->perks, true)]);
        }
        
        $request->validate([
            'internship_title' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'company_website' => 'nullable|url|max:255',
            'internship_mode' => 'required|in:Online,Offline,Hybrid',
            'location' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'weeks' => 'required|integer|min:1',
            'hours' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'application_deadline' => 'required|date',
            'batch_days' => 'nullable|array',
            'stipend' => 'nullable|numeric|min:0',
            'openings' => 'required|integer|min:1',
            'required_skills' => 'nullable|string',
            'required_eligibility_criteria' => 'nullable|string',
            'internship_description' => 'required|string',
            'module_description' => 'required|string',
            'internship_objective' => 'required|string',
            'internship_outcome' => 'required|string',
            'perks' => 'nullable|array',
            'internship_fee' => 'nullable|numeric|min:0',
            'gst_percentage' => 'nullable|numeric|min:0|max:100',
            'gst_amount' => 'nullable|numeric|min:0',
            'total_fee' => 'nullable|numeric|min:0',
        ]);

        try {
            $user = Auth::user();
            $internship = Internship::where('id', $id)
                ->where('company_id', $user->id)
                ->firstOrFail();
            
            // Generate unique slug if title changed
            if ($internship->internship_title !== $request->internship_title) {
                $slug = Str::slug($request->internship_title);
                $originalSlug = $slug;
                $counter = 1;
                
                while (Internship::withTrashed()->where('slug', $slug)->where('id', '!=', $id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            } else {
                $slug = $internship->slug;
            }

            $registrationFees = (float) ($request->internship_fee ?? $internship->registration_fees ?? 0);
            $gstPercentage = (float) ($request->gst_percentage ?? $internship->gst_percentage ?? 0);
            $gstAmount = $request->filled('gst_amount')
                ? (float) $request->gst_amount
                : round(($registrationFees * $gstPercentage) / 100, 2);
            $finalAmount = $request->filled('total_fee')
                ? (float) $request->total_fee
                : round($registrationFees + $gstAmount, 2);
            
            // Update internship
            $internship->update([
                'internship_title' => $request->internship_title,
                'slug' => $slug,
                'category' => $request->category_id,
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
                'skills' => $request->required_skills,
                'eligibility_criteria' => $request->required_eligibility_criteria,
                'perks' => $request->perks ?? [],
                'internship_description' => $request->internship_description,
                'module_brief_description' => $request->module_description,
                'internship_objective' => $request->internship_objective,
                'internship_outcome' => $request->internship_outcome,
                'registration_fees' => $registrationFees,
                'gst_percentage' => $gstPercentage,
                'gst_amount' => $gstAmount,
                'final_amount' => $finalAmount,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Internship updated successfully!'
            ]);
                
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update internship: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete internship from company profile
     */
    public function companyInternshipDestroy($id)
    {
        try {
            $user = Auth::user();
            $internship = Internship::where('id', $id)
                ->where('company_id', $user->id)
                ->firstOrFail();
            
            $internship->delete();

            return response()->json([
                'success' => true,
                'message' => 'Internship deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete internship: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get internship data for editing
     */
    public function companyInternshipEdit($id)
    {
        try {
            $user = Auth::user();
            $internship = Internship::where('id', $id)
                ->where('company_id', $user->id)
                ->firstOrFail();

            // Format dates for HTML date input (Y-m-d format)
            $internshipData = $internship->toArray();
            if ($internship->start_date) {
                $internshipData['start_date'] = $internship->start_date->format('Y-m-d');
            }
            if ($internship->end_date) {
                $internshipData['end_date'] = $internship->end_date->format('Y-m-d');
            }
            if ($internship->application_deadline) {
                $internshipData['application_deadline'] = $internship->application_deadline->format('Y-m-d');
            }

            return response()->json([
                'success' => true,
                'internship' => $internshipData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internship not found'
            ], 404);
        }
    }

    /**
     * Change internship status (active/closed)
     */
    public function companyInternshipChangeStatus(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $internship = Internship::where('id', $id)
                ->where('company_id', $user->id)
                ->firstOrFail();
            
            $request->validate([
                'status' => 'required|in:0,1'
            ]);
            
            $internship->update([
                'complete_status' => $request->status
            ]);

            $statusText = $request->status == 1 ? 'closed' : 'active';
            
            return response()->json([
                'success' => true,
                'message' => "Internship marked as {$statusText} successfully!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

 /**
     * Generate a pseudo-random transaction id like TXN89347293847
     *
     * @return string
     */
    private function generatePaymentTransactionId()
    {
        // TXN + timestamp + random 6 digits
        $rand = mt_rand(100000, 999999);
        return 'TXN' . time() . $rand;
    }

    
     /**
     * Show the internship completion / grading page (website frontend)
     */
    public function internshipCompletePage($id)
    {
        $user = Auth::user();
        $internship = Internship::with(['company', 'jobCategory'])->findOrFail($id);

        // Only the company owner can access
        if ($internship->company_id != $user->id) {
            return redirect()->route('company-profile')->with('error', 'Unauthorized access');
        }

        $students = InternshipApplication::with(['user.college', 'user.degree'])
            ->where('internship_id', $id)
            ->get();

        // Build per-student "Industry Marks" criteria keyed by student_id, cached by college_id:degree_id
        $criteriaCache      = [];
        $studentCriteriaMap = [];

        foreach ($students as $app) {
            $student = $app->user;
            if (!$student) continue;

            $cKey = "{$student->college_id}:{$student->degree_id}";
            if (!array_key_exists($cKey, $criteriaCache)) {
                $grade = Grade::where('college_id', $student->college_id)
                    ->when($student->degree_id, fn($q) => $q->where('course_id', $student->degree_id))
                    ->first();

                $industryCrit = collect();
                if ($grade) {
                    $industrySectionIds = GradeSection::where('grade_id', $grade->id)
                        ->where('title', 'Industry Marks')->pluck('id');
                    $industryCrit = GradeCriterion::whereIn('section_id', $industrySectionIds)
                        ->whereNull('deleted_at')->get();
                }
                $criteriaCache[$cKey] = $industryCrit;
            }
            $studentCriteriaMap[$student->id] = $criteriaCache[$cKey];
        }

        // Flag: any student has industry criteria (drives column header visibility)
        $hasIndustryCriteria = collect($studentCriteriaMap)->flatten(1)->isNotEmpty();

        $savedMarks = InternshipMark::where('internship_id', $id)
            ->get()
            ->groupBy('student_id');

        // Pre-load feedback from applications
        $feedbackColumn = $internship->internship_type == 2 ? 'college_feedback' : 'company_feedback';
        $savedFeedbacks = InternshipApplication::where('internship_id', $id)
            ->pluck($feedbackColumn, 'user_id');

        return view('website.internship-complete', compact(
            'internship', 'students', 'studentCriteriaMap', 'hasIndustryCriteria', 'savedMarks', 'savedFeedbacks'
        ));
    }

    /**
     * Save marks (AJAX auto-save) - website frontend
     * Stores snapshot of criteria_name and max_marks for data consistency.
     */
    public function saveInternshipMarks(Request $request)
    {
        $request->validate([
            'internship_id'  => 'required|integer',
            'student_id'     => 'required|integer',
            'criteria_id'    => 'required|integer',
            'criteria_name'  => 'required|string|max:255',
            'max_marks'      => 'required|integer|min:0',
            'marks'          => 'required|integer|min:0',
        ]);

        $user = Auth::user();
        $internship = Internship::findOrFail($request->internship_id);

        if ($internship->company_id != $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

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
                'status'        => 0,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Marks saved', 'data' => $mark]);
    }

    /**
     * Save feedback (AJAX auto-save) - website frontend
     * Stores in tbl_internship_application based on internship_type.
     */
    public function saveInternshipFeedback(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|integer',
            'student_id'    => 'required|integer',
            'feedback'      => 'nullable|string|max:5000',
        ]);

        $user = Auth::user();
        $internship = Internship::findOrFail($request->internship_id);

        if ($internship->company_id != $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Prevent modifying feedback after company submission / finalisation
        if ($internship->company_complete_sts == 1 || $internship->complete_status == 1) {
            return response()->json(['success' => false, 'message' => 'Feedback cannot be modified after submission.'], 422);
        }

        $feedbackColumn = $internship->internship_type == 2 ? 'college_feedback' : 'company_feedback';

        InternshipApplication::where('internship_id', $request->internship_id)
            ->where('user_id', $request->student_id)
            ->update([$feedbackColumn => $request->feedback]);

        return response()->json(['success' => true, 'message' => 'Feedback saved']);
    }

    /**
     * Fetch saved marks - website frontend
     * Returns snapshot data and feedback from tbl_internship_application.
     */
    public function fetchInternshipMarks($internshipId)
    {
        $internship = Internship::findOrFail($internshipId);
        $feedbackColumn = $internship->internship_type == 2 ? 'college_feedback' : 'company_feedback';

        $applications = InternshipApplication::where('internship_id', $internshipId)
            ->pluck($feedbackColumn, 'user_id');

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
    }

    /**
     * Final submit - website frontend
     */
    public function submitInternshipCompletion(Request $request)
    {
        $request->validate(['internship_id' => 'required|integer']);

        $user = Auth::user();
        $internship = Internship::findOrFail($request->internship_id);

        if ($internship->company_id != $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        // Mark industry (company) side as submitted. Leave college and overall completion untouched.
        DB::beginTransaction();
        try {
            // For company-only internships (type == 2) finalise on company submission
            if ($internship->internship_type == 2) {
                // mark marks as submitted and finalise
                InternshipMark::where('internship_id', $internship->id)
                    ->update(['status' => 1]);

                $internship->update([
                    'company_complete_sts' => 1,
                    'college_complete_sts' => 0,
                    'complete_status' => 1,
                ]);

                // mark applications as complete
                InternshipApplication::where('internship_id', $internship->id)
                    ->update(['complete_status' => 1]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Industry marks submitted and internship finalised.'
                ]);
            }

            // Default behaviour for Industry+College internships: only company side submitted
            $internship->update([
                'company_complete_sts' => 1,
                'college_complete_sts' => 0,
                'complete_status' => 0,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Industry marks submitted successfully. College marks are still pending.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
    
    
    
    
    public function blog()
    {
        $user = Auth::user();

        // if ($user) {
        //     $this->planValidityCheck($user);
        // }
        if ($user) {
            $redirect = $this->planValidityCheck($user);
            if ($redirect) {
                return $redirect; // 🔥 GAME CHANGER
            }
        }

        $Blog = Blog::where('status', 1)->paginate(9);


        return view('website.blog', compact('Blog'));
    }
    
    
    
     public function faq()
    {
        $user = Auth::user();

        if ($user) {
            $this->planValidityCheck($user);
        }



        return view('website.faq');
    }
    
    
    public function blog_detail(Request $request, $id)
    {
        $user = Auth::user();

        if ($user) {
            $this->planValidityCheck($user);
        }

        $Blog = Blog::where('id', $id)->where('status', 1)->first();
        return view('website.blog-details', compact('Blog'));
    }

     public function privacy_policy(Request $request){
        return view('website.privacy-policy');
    }

        public function term_and_conditions(Request $request){
        return view('website.terms-and-conditions');
    }

    // public function planValidityCheck($user)
    // {
    //     $planData = DB::table('tbl_plan_history as ph')
    //         ->join('tbl_plan_pricing as pp', 'pp.plan_id', '=', 'ph.plan_id')
    //         ->select(
    //             'ph.purchase_date',
    //             'ph.expire_date',
    //             'pp.plan_name',
    //             'pp.plan_price',
    //             'pp.plan_duration',
    //             'pp.plan_time'
    //         )
    //         ->where('ph.plan_id', $user->active_plan_id) // ✅ Fix here
    //         ->where('ph.user_id', $user->id) // ✅ Fix here
    //         ->orderBy('ph.id', 'desc') // ✅ Fix here
    //         ->first();


    //     $planExpired = false;
    //     $planMessage = '';

    //     if ($planData) {
    //         $now = Carbon::now();
    //         $expireDate = Carbon::parse($planData->expire_date);

    //         if ($now->gt($expireDate)) {
    //             $planExpired = true;
    //             $planMessage = '⚠️ Your plan has expired.';
    //         } elseif ($now->isSameDay($expireDate)) {
    //             $planMessage = '⏰ Your plan expires today.';
    //         } elseif ($now->diffInDays($expireDate, false) <= 3) {
    //             $daysLeft = $now->diffInDays($expireDate);
    //             $planMessage = "⚠️ Your plan will expire in $daysLeft day(s).";
    //         } else {
    //             $planMessage = '✅ Plan is active: ' . $planData->plan_name;
    //         }
    //     } else {
    //         $planMessage = '❌ No active plan found.';
    //         $planExpired = true;
    //         User::where('id', $user->id)
    //             ->update(['active_plan_id' => 0]);
    //     }

    //     if ($planExpired == true) {
    //         User::where('id', $user->id)
    //             ->update(['active_plan_id' => 0]); // Reset active_plan_id if expired
    //         $planMessage .= ' Your active plan has been reset.';
    //     }
    // }
    public function planValidityCheck($user)
    {
        $today = Carbon::today()->toDateString();

        // 1) Expire any active plan_history rows that passed their expire_date
        DB::table('tbl_plan_history')
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->whereDate('expire_date', '<', $today)
            ->update(['status' => 0]);

        // 2) If user's active_plan_id has expired, clear it and redirect to pricing
        if (!empty($user->active_plan_id)) {
            $expired = DB::table('tbl_plan_history')
                ->where('user_id', $user->id)
                ->where('plan_id', $user->active_plan_id)
                ->whereDate('expire_date', '<', $today)
                ->exists();

            if ($expired) {
                User::where('id', $user->id)->update(['active_plan_id' => 0]);
                return redirect()->route('pricing', $user->id);
            }
        }

        // 3) Confirm there is a valid (status = 1) plan record for the active_plan_id
        $planData = DB::table('tbl_plan_history as ph')
            ->join('tbl_plan_pricing as pp', 'pp.plan_id', '=', 'ph.plan_id')
            ->select(
                'ph.purchase_date',
                'ph.expire_date',
                'pp.plan_name',
                'pp.plan_price',
                'pp.plan_duration',
                'pp.plan_time'
            )
            ->where('ph.plan_id', $user->active_plan_id)
            ->where('ph.user_id', $user->id)
            ->where('ph.status', 1)
            ->orderBy('ph.id', 'desc')
            ->first();

        if (!$planData) {
            User::where('id', $user->id)->update(['active_plan_id' => 0]);
            return redirect()->route('pricing', $user->id);
        }

        // Double-check expire date
        $expireDate = Carbon::parse($planData->expire_date);
        if (Carbon::now()->gt($expireDate)) {
            // ensure the history is marked expired and active plan cleared
            DB::table('tbl_plan_history')
                ->where('user_id', $user->id)
                ->whereDate('expire_date', '<', $today)
                ->update(['status' => 0]);

            User::where('id', $user->id)->update(['active_plan_id' => 0]);
            return redirect()->route('pricing', $user->id);
        }

        // Plan is valid
        return null;
    }


    // public function company_profile()
    // {
    //     $user = Auth::user();
    //     if ($user) {
    //         if ($user) {
    //             $this->planValidityCheck($user);
    //         }


    //         $userData = DB::table('users')
    //             ->select([
    //                 'users.*',
    //                 'tbl_state.state_name',
    //                 'tbl_state.state_id',
    //                 'tbl_city.city_nm',
    //                 'tbl_city.city_id',
    //                 'tbl_area.area_nm',
    //                 'tbl_area.area_id',
    //                 'tbl_zipcode.zipcode',
    //                 'tbl_zipcode.zipcode_id',
    //             ])
    //             ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
    //             ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
    //             ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'users.area_id')
    //             ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')
    //             ->where('users.id', $user->id)
    //             ->first();
    //         $states = State::select('state_id', 'state_name')->get(); // replace with your table column names


    //         $CategoryData = JobCategory::get();
    //         $MinqualificationData = Minqualification::get();
    //         $WorktypeData = Worktype::get();
    //         $JobtypeData = Jobtype::get(); // Uncomment if needed
    //         $JoblevelData = Joblevel::get();
    //         $ExperiencereqData = Experiencereq::get();


    //         $JobData = DB::table('tbl_job')
    //             ->select([
    //                 'tbl_job.*',
    //                 'tbl_work_type.type_nm as work_type_name',
    //                 'tbl_state.state_name',
    //                 'tbl_city.city_nm',
    //                 'tbl_area.area_nm',
    //             ])
    //             ->leftJoin('tbl_work_type', 'tbl_work_type.work_type_id', '=', 'tbl_job.work_type_id')
    //             ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'tbl_job.state_id')
    //             ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'tbl_job.city_id')
    //             ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'tbl_job.area_id')
    //             ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'tbl_job.zipcode_id')
    //             ->where('tbl_job.user_id', $user->id)
    //             ->whereNull('tbl_job.deleted_at') // ✅ Correct way to check for null
    //             ->orderBy('tbl_job.job_id', 'desc')
    //             ->paginate(9); // 👈 Change 6 to how many per page


    //         foreach ($JobData as $job) {
    //             $job->apply_count = DB::table('tbl_job_apply')
    //                 ->where('job_id', $job->job_id)
    //                 ->count();
    //         }
    //         $Setting = Setting::where('id', 1)->first();
    //         $PlanHistoryData = DB::table('tbl_plan_history as a')
    //             ->join('tbl_plan_pricing as b', 'a.plan_id', '=', 'b.plan_id')
    //             ->leftJoin('users as c', 'a.user_id', '=', 'c.id')
    //             ->where('a.user_id', $user->id)
    //             ->select([
    //                 'a.*',
    //                 'b.plan_name',
    //                 'b.plan_price',
    //                 DB::raw("CASE WHEN a.plan_id = c.active_plan_id THEN 'Active' ELSE 'Expired' END as status")
    //             ])->orderBy('a.id', 'DESC')
    //             ->get();
    //         return view('website.company-profile', compact('states', 'userData', 'CategoryData', 'MinqualificationData', 'JoblevelData', 'JobtypeData', 'WorktypeData', 'ExperiencereqData', 'JobData', 'Setting', 'PlanHistoryData'));
    //     } else {
    //         return redirect()->route('login', ['login_type' => 'Employee'])->with('error', 'You must be logged in to view this page.');
    //     }
    // }
    public function company_profile()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login', ['login_type' => 'Employee'])->with('error', 'You must be logged in to view this page.');
        }

        // Plan validity check
        // if ($user) {
        //     $this->planValidityCheck($user);
        // }
        if ($user) {
            $redirect = $this->planValidityCheck($user);
            if ($redirect) {
                return $redirect; // 🔥 GAME CHANGER
            }
        }

        // Get filter from request
        $filter = request('filter', 'all'); // Default to 'all'

        $userData = DB::table('users')
            ->select([
                'users.*',
                'tbl_state.state_name',
                'tbl_state.state_id',
                'tbl_city.city_nm',
                'tbl_city.city_id',
                'tbl_area.area_nm',
                'tbl_area.area_id',
                'tbl_zipcode.zipcode',
                'tbl_zipcode.zipcode_id',
            ])
            ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
            ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
            ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'users.area_id')
            ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')
            ->where('users.id', $user->id)
            ->first();

        $states = State::select('state_id', 'state_name')->get();
        $CategoryData = JobCategory::get();
        $MinqualificationData = Minqualification::orderBy('name','ASC')->get();
        $WorktypeData = Worktype::get();
        $JobtypeData = Jobtype::get();
        $JoblevelData = Joblevel::get();
        $ExperiencereqData = Experiencereq::get();

        // Build job query with filter
        $jobQuery = DB::table('tbl_job')
            ->select([
                'tbl_job.*',
                'tbl_work_type.type_nm as work_type_name',
                'tbl_state.state_name',
                'tbl_city.city_nm',
                'tbl_area.area_nm',
            ])
            ->leftJoin('tbl_work_type', 'tbl_work_type.work_type_id', '=', 'tbl_job.work_type_id')
            ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'tbl_job.state_id')
            ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'tbl_job.city_id')
            ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'tbl_job.area_id')
            ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'tbl_job.zipcode_id')
            ->where('tbl_job.user_id', $user->id)
            ->whereNull('tbl_job.deleted_at');

        // Apply filter
        switch ($filter) {
            case 'active':
                $jobQuery->where('tbl_job.status', 1);
                break;
            case 'closed':
                $jobQuery->where('tbl_job.status', 2);
                break;
            case 'draft':
                $jobQuery->where('tbl_job.status', 0); // Assuming 0 is draft
                break;
            case 'all':
            default:
                // No additional filter for 'all'
                break;
        }

        $JobData = $jobQuery->orderBy('tbl_job.job_id', 'desc')->paginate(9);

        // Apply count for each job
        foreach ($JobData as $job) {
            $job->apply_count = DB::table('tbl_job_apply')
                ->where('job_id', $job->job_id)
                ->count();
        }

        $Setting = Setting::where('id', 1)->first();
        $PlanHistoryData = DB::table('tbl_plan_history as a')
            ->join('tbl_plan_pricing as b', 'a.plan_id', '=', 'b.plan_id')
            ->leftJoin('users as c', 'a.user_id', '=', 'c.id')
            ->where('a.user_id', $user->id)
            // ->whereNotNull('a.payment_id')
            // ->whereNotNull('a.order_id')
            ->select([
                'a.*',
                'b.plan_name',
                'b.plan_price',
                DB::raw("CASE WHEN a.plan_id = c.active_plan_id THEN 'Active' ELSE 'Expired' END as status")
            ])->orderBy('a.id', 'DESC')
            ->get();
        // dd($PlanHistoryData);

        // 🔥 ACTIVE PLAN (latest)
        $activePlan = DB::table('tbl_plan_history as a')
            ->join('tbl_plan_pricing as b', 'a.plan_id', '=', 'b.plan_id')
            ->where('a.user_id', $user->id)
            ->orderBy('a.id','DESC')
            ->select('b.plan_price','b.plan_for')
            ->first();

        // 🔥 total job count
        $totalJobs = DB::table('tbl_job')
            ->where('user_id', $user->id)
            ->whereNull('deleted_at')
            ->count();
        // 🔥 button hide logic
        $hideCreateJobBtn = false;

        if($activePlan){

            // price float ma convert
            $price = (float) $activePlan->plan_price;

            // lowercase compare
            $planFor = strtolower($activePlan->plan_for);

            if($price == 0 && $planFor == 'company'){
                if($totalJobs >= 1){
                    $hideCreateJobBtn = true;
                }
            }
        }

    // dd($hideCreateJobBtn);
    
    
     // Fetch internships for the company
        // Use Eloquent relationship count for applications (from tbl_internship_application)
        $internshipQuery = Internship::with(['jobCategory'])
            ->withCount(['internshipApplications as apply_count'])
            ->where('company_id', $user->id);

        // Apply filter based on approval status
        switch ($filter) {
            case 'approved':
                // Show approved internships that are not yet completed
                $internshipQuery->where('approve_status', 1)
                               ->where('complete_status', 0);
                break;
            case 'pending':
                // Pending approval - not yet approved or rejected
                $internshipQuery->where('approve_status', 0);
                break;
            case 'college_pending':
                // Company has submitted marks but college yet to submit (college pending)
                $internshipQuery->where('internship_type', 1)
                               ->where('company_complete_sts', 1)
                               ->where('college_complete_sts', 0)
                               ->where('complete_status', 0);
                break;
            case 'completed':
                // Completed internships - approved and closed
                $internshipQuery->where('approve_status', 1)
                               ->where('complete_status', 1);
                break;
            case 'rejected':
                $internshipQuery->where('approve_status', 2);
                break;
            case 'all':
            default:
                // No additional filter for 'all'
                break;
        }

    
     $InternshipData = $internshipQuery->orderBy('id', 'desc')->get();

        // Ensure legacy `apply_count` property is available for views
        foreach ($InternshipData as $internship) {
            $internship->apply_count = isset($internship->apply_count) ? $internship->apply_count : ($internship->applications_count ?? 0);
        }
        
        $MinqualificationData = Minqualification::orderBy('name','ASC')->get();

        return view('website.company-profile', compact(
            'states', 'userData', 'CategoryData', 'MinqualificationData', 
            'JoblevelData', 'JobtypeData', 'WorktypeData', 'ExperiencereqData', 
            'JobData', 'Setting', 'PlanHistoryData', 'filter', 'hideCreateJobBtn', 'InternshipData','MinqualificationData'
        ));
    }
    public function candidate_profile()
    {
        $experience = Experiencereq::get();
        $user = Auth::user();
        if ($user) {
            $user = Auth::user();
            $user_id = "";
            // if ($user) {
            //     $this->planValidityCheck($user);
            // }
            if ($user) {
                $redirect = $this->planValidityCheck($user);
                if ($redirect) {
                    return $redirect; // 🔥 GAME CHANGER
                }
            }
            $userData = DB::table('users')
                ->select([
                    'users.*',
                    'tbl_state.state_name',
                    'tbl_state.state_id',
                    'tbl_city.city_nm',
                    'tbl_city.city_id',
                    'tbl_area.area_nm',
                    'tbl_area.area_id',
                    'tbl_zipcode.zipcode',
                    'tbl_zipcode.zipcode_id',
                ])
                ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
                ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
                ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'users.area_id')
                ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')
                ->whereNull('users.deleted_at')
                ->where('users.id', $user->id)
                ->first();
            // dd($userData);
            $states = State::select('state_id', 'state_name')->get(); // replace with your table column names

            // $CategoryData = JobCategory::get();
            $employeeType = $user->preference_type;
            $CategoryData = JobCategory::when(in_array($employeeType, [1, 2]), function ($q) use ($employeeType) {
                $q->where('preference_type', $employeeType);
            })
            ->orderBy('category_nm', 'ASC')
            ->get();
            // dd($CategoryData);

            $WorktypeData = Worktype::get();
            $JobtypeData = Jobtype::get();
            $WorkExperienceData = WorkExperience::select(
                'tbl_work_experience.*',
                'tbl_job_type.type_name as job_type_name',
                'tbl_work_type.type_nm as work_type_name'
            )
                ->join('tbl_job_type', 'tbl_job_type.job_type_id', '=', 'tbl_work_experience.job_type_id')
                ->join('tbl_work_type', 'tbl_work_type.work_type_id', '=', 'tbl_work_experience.work_type_id')
                ->where('tbl_work_experience.user_id', $user->id)
                ->get();

            $EducationData = Education::where('user_id', $user->id)->get();

            $SaveJobData = DB::table('tbl_job_save as s')
                ->select([
                    's.*',
                    'j.*',
                    'w.type_nm as work_type_name',
                    'n.state_name',
                    'c.city_nm',
                    'a.area_nm'
                ])
                ->leftJoin('tbl_job as j', 's.job_id', '=', 'j.job_id')
                ->leftJoin('tbl_work_type as w', 'j.work_type_id', '=', 'w.work_type_id')
                ->leftJoin('tbl_state as n', 'j.state_id', '=', 'n.state_id')
                ->leftJoin('tbl_city as c', 'j.city_id', '=', 'c.city_id')
                ->leftJoin('tbl_area as a', 'j.city_id', '=', 'a.area_id')
                ->where('s.user_id', $user->id)
                ->whereNull('j.deleted_at') // only non-deleted jobs
                ->orderBy('j.job_id', 'desc')
                ->paginate(9);


            $MyjobData = DB::table('tbl_job_apply as a')
                ->select(
                    'a.*',
                    'b.job_title',
                    'b.company_address',
                    'b.datetime',
                    'b.skill_id',
                    'c.type_nm as work_type_name',
                    'd.state_name',
                    'e.city_nm',
                    'f.area_nm',
                )
                ->join('tbl_job as b', 'a.job_id', '=', 'b.job_id')
                ->join('tbl_work_type as c', 'b.work_type_id', '=', 'c.work_type_id')
                ->join('tbl_state as d', 'b.state_id', '=', 'd.state_id')
                ->join('tbl_city as e', 'b.city_id', '=', 'e.city_id')
                ->join('tbl_area as f', 'b.area_id', '=', 'f.area_id')
                ->where('a.user_id', $user->id)
                ->orderBy('a.datetime', 'desc')  // ✅ Correct orderBy usage
                ->paginate(6);

            $Setting = Setting::where('id', 1)->first();

            $PlanHistoryData = DB::table('tbl_plan_history as a')
                ->join('tbl_plan_pricing as b', 'a.plan_id', '=', 'b.plan_id')
                ->leftJoin('users as c', 'a.user_id', '=', 'c.id')
                ->where('a.user_id', $user->id)
                ->select([
                    'a.*',
                    'b.plan_name',
                    'b.plan_price',
                    DB::raw("CASE WHEN a.plan_id = c.active_plan_id THEN 'Active' ELSE 'Expired' END as status")
                ])->orderBy('a.id', 'DESC')
                ->get();

            $Resume = Resume::where('resume_type', 1)->where('user_id', $user->id)->first();
            $Resumes = Resume::whereIn('resume_type', [1,2])->where('user_id', $user->id)->get();
            // dd($Resumes);
            // dd($Resumes);
            
            
              // Fetch internships the user has applied to
            $MyInternshipData = DB::table('tbl_internship_application as a')
                ->select([
                    'a.*',
                    'b.id as internship_id',
                    'b.slug as slug',
                    'b.internship_title',
                    'b.start_date',
                    'b.complete_status',
                    'b.end_date',
                    'b.duration',
                    'b.mode',
                    'b.stipend',
                    'c.name as company_name',
                ])
                ->leftJoin('tbl_internship as b', 'a.internship_id', '=', 'b.id')
                ->leftJoin('users as c', 'b.company_id', '=', 'c.id')
                ->where('a.user_id', $user->id)
                ->orderBy('a.applied_on', 'desc')
                ->get();

            // calculate formatted dates and remaining days
            $today = Carbon::today();
            foreach ($MyInternshipData as $it) {
                $it->start_date_formatted = $it->start_date ? Carbon::parse($it->start_date)->format('d M Y') : null;
                $it->end_date_formatted = $it->end_date ? Carbon::parse($it->end_date)->format('d M Y') : null;

                $start = $it->start_date ? Carbon::parse($it->start_date) : null;
                $end   = $it->end_date   ? Carbon::parse($it->end_date)   : null;
                $it->start_on_date    = $start ? $start->format('d M Y') : null;
                $it->complete_on_date = $end   ? $end->format('d M Y')   : null;

                // PRIMARY: use database complete_status=1 as the source of truth for Completed
                if (isset($it->complete_status) && intval($it->complete_status) === 1) {
                    $it->status          = 'Completed';
                    $it->start_in_days   = 0;
                    $it->complete_in_days = 0;
                } elseif ($start && $today->lt($start)) {
                    // Not yet started
                    $it->status           = 'Upcoming';
                    $it->start_in_days    = $today->diffInDays($start);
                    $it->complete_in_days = $end ? $today->diffInDays($end) : null;
                } elseif ($end && $today->gt($end)) {
                    // Past end date but complete_status != 1
                    $it->status           = 'Pending';
                    $it->start_in_days    = 0;
                    $it->complete_in_days = 0;
                } elseif (($start && $end && $today->between($start, $end)) || (!$start && $end && $today->lte($end))) {
                    // Within the internship period
                    $it->status           = 'Ongoing';
                    $it->start_in_days    = 0;
                    $it->complete_in_days = $end ? $today->diffInDays($end) : null;
                } else {
                    // Fallback
                    $it->status           = 'Ongoing';
                    $it->start_in_days    = null;
                    $it->complete_in_days = null;
                }
            }
            return view('website.candidate-profile', compact('states','MyInternshipData','userData', 'CategoryData', 'WorktypeData', 'JobtypeData', 'WorkExperienceData', 'EducationData', 'SaveJobData', 'MyjobData', 'Setting', 'PlanHistoryData', 'Resume', 'Resumes', 'experience'));
        } else {
            return redirect()->route('login', ['login_type' => 'Employee'])->with('error', 'You must be logged in to view this page.');
        }
    }

        public function deleteResume(Request $request)
        {
            $request->validate([
                'resume_id' => 'required|integer'
            ]);

            $resume = Resume::where('resume_id', $request->resume_id)
                ->where('user_id', auth()->id())
                ->first();

            if (!$resume) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Resume not found'
                ]);
            }

            // 🔥 delete file from folder
            // $filePath = public_path('uploads/resume/' . $resume->file_nm);
            $filePath = storage_path('app/public/resume/' . basename($resume->file_nm));
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            // delete record
            $resume->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Resume deleted successfully'
            ]);
        }


    // public function candidate_profile_detail($id)
    // {

    //     $user = Auth::user();
    //     $user_id = "";
    //     if ($user) {
    //         $this->planValidityCheck($user);
    //         $user_id = $user->id;
    //     }
    //     $userData = DB::table('users')
    //         ->select([
    //             'users.*',
    //             'tbl_state.state_name',
    //             'tbl_state.state_id',
    //             'tbl_city.city_nm',
    //             'tbl_city.city_id',
    //             'tbl_area.area_nm',
    //             'tbl_area.area_id',
    //             'tbl_zipcode.zipcode',
    //             'tbl_zipcode.zipcode_id',
    //         ])
    //         ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
    //         ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
    //         ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'users.area_id')
    //         ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')
    //         ->where('users.id', $id)
    //         ->whereNull('users.deleted_at')
    //         ->first();

    //     $WorkExperienceData = WorkExperience::select(
    //         'tbl_work_experience.*',
    //         'tbl_job_type.type_name as job_type_name',
    //         'tbl_work_type.type_nm as work_type_name'
    //     )->join('tbl_job_type', 'tbl_job_type.job_type_id', '=', 'tbl_work_experience.job_type_id')
    //         ->join('tbl_work_type', 'tbl_work_type.work_type_id', '=', 'tbl_work_experience.work_type_id')
    //         ->where('tbl_work_experience.user_id', $id)
    //         ->whereNull('tbl_work_experience.deleted_at')
    //         ->get(); // 👈 Pagination instead of get()

    //     $EducationData = Education::where('user_id', $id)->get();

    //     $today = Carbon::today();
    //     $adBanner = AdBanner::where('page_nm', 4)->whereDate('start_date', '<=', $today)
    //         ->whereDate('end_date', '>=', $today)->first();

    //     $Resume = Resume::where('resume_type', 1)->where('user_id', $user_id)->first();
    //     return view('website.candidate-details', compact('userData', 'WorkExperienceData', 'EducationData', 'adBanner', 'Resume'));
    // }
    public function candidate_profile_detail($id)
    {
        $user = Auth::user();

        if ($user) {
            $this->planValidityCheck($user);
        }

        /* ---------------------------------------------------
        🔥 FIX: Apply required status filters
        --------------------------------------------------- */
        $userData = DB::table('users')
            ->select([
                'users.*',
                'tbl_state.state_name',
                'tbl_city.city_nm',
                'tbl_area.area_nm',
                'tbl_zipcode.zipcode'
            ])
            ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
            ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
            ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'users.area_id')
            ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')
            ->where('users.id', $id)
            ->whereNull('users.deleted_at')
            ->where('users.active_status', 1)
            // ->where('users.profile_status', 1)
            // ->where('users.profile_type', 'Candidate')   // 🔥 Required condition
            ->first();
        


        /* ---------------------------------------------------
        🧩 Experience Data
        --------------------------------------------------- */
        $WorkExperienceData = WorkExperience::select(
            'tbl_work_experience.*',
            'tbl_job_type.type_name as job_type_name',
            'tbl_work_type.type_nm as work_type_name'
        )
        ->join('tbl_job_type', 'tbl_job_type.job_type_id', '=', 'tbl_work_experience.job_type_id')
        ->join('tbl_work_type', 'tbl_work_type.work_type_id', '=', 'tbl_work_experience.work_type_id')
        ->where('tbl_work_experience.user_id', $id)
        ->whereNull('tbl_work_experience.deleted_at')
        ->get();

        $EducationData = Education::where('user_id', $id)->get();

        $today = Carbon::today();
        $adBanner = AdBanner::where('page_nm', 4)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->first();

        $Resume = Resume::where('user_id', $id)
            ->where('resume_type', 1)
            ->latest('resume_id')
            ->first();

        if (!$Resume) {
            $Resume = Resume::where('user_id', $id)
                ->latest('resume_id')
                ->first();
        }
            // dd($Resume);

        return view('website.candidate-details', compact(
            'userData', 
            'WorkExperienceData', 
            'EducationData', 
            'adBanner', 
            'Resume'
        ));
    }


    public function company_profile_detail(Request $request, $id)
    {
        $user = Auth::user($id);

        $user = Auth::user();
        // if ($user) {
        //     $this->planValidityCheck($user);
        // }
        if ($user) {
            $redirect = $this->planValidityCheck($user);
            if ($redirect) {
                return $redirect; // 🔥 GAME CHANGER
            }
        }


        $userData = DB::table('users')
            ->select([
                'users.*',
                'tbl_state.state_name',
                'tbl_state.state_id',
                'tbl_city.city_nm',
                'tbl_city.city_id',
                'tbl_area.area_nm',
                'tbl_area.area_id',
                'tbl_zipcode.zipcode',
                'tbl_zipcode.zipcode_id',
                'tbl_job_category.category_nm',
            ])
            ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
            ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
            ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'users.area_id')
            ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')
            ->leftJoin('tbl_job_category', 'tbl_job_category.category_id', '=', 'users.category_id') // <-- New join
            ->where('users.id', $id)
            ->whereNull('users.deleted_at')
            ->first();

        $JobData = DB::table('tbl_job')
            ->select([
                'tbl_job.*',
                'tbl_work_type.type_nm as work_type_name',
            ])
            ->leftJoin('tbl_work_type', 'tbl_work_type.work_type_id', '=', 'tbl_job.work_type_id')
            ->where('tbl_job.user_id', $id)
            ->whereNull('tbl_job.deleted_at') // ✅ Correct way to check for null
            ->orderBy('tbl_job.job_id', 'desc')
            ->where('tbl_job.status', 1) // only active jobs
            ->paginate(5); // 👈 Change 6 to how many per page


        $today = Carbon::today();
        $adBanner = AdBanner::where('page_nm', 3)->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)->first();
        return view('website.company-details', compact('userData', 'JobData', 'adBanner'));
    }

    public function job_detail(Request $request, $id)
    {
        $user = Auth::user();
        // if ($user) {
        //     $this->planValidityCheck($user);
        // }
        if ($user) {
            $redirect = $this->planValidityCheck($user);
            if ($redirect) {
                return $redirect; // 🔥 GAME CHANGER
            }
        }

        $SaveJobData = [];
        $JobApplyHistory = [];
        $jobData = DB::table('tbl_job as a')
            ->select(
                'a.*',
                'b.category_nm',
                'c.sub_category_nm',
                'd.name as qualification_nm',
                'e.type_nm as job_level_name',
                'f.type_name as job_type_name',
                'g.type_nm as work_type_name',
                'h.name as experience_name',
                'i.state_name',
                'j.city_nm',
                'k.area_nm',
                'l.zipcode',
                'm.name as user_name',
                'm.profile_img'
            )
            ->join('tbl_job_category as b', 'a.category_id', '=', 'b.category_id')
            ->join('tbl_sub_category as c', 'a.sub_category_id', '=', 'c.sub_category_id')
            ->join('tbl_min_qualification as d', 'a.qualification_id', '=', 'd.qualification_id')
            ->join('tbl_job_level as e', 'a.job_level_id', '=', 'e.job_level_id')
            ->join('tbl_job_type as f', 'a.job_type_id', '=', 'f.job_type_id')
            ->join('tbl_work_type as g', 'a.work_type_id', '=', 'g.work_type_id')
            ->join('tbl_experience_req as h', 'a.experience_req_id', '=', 'h.experience_req_id')
            ->join('tbl_state as i', 'a.state_id', '=', 'i.state_id')
            ->join('tbl_city as j', 'a.city_id', '=', 'j.city_id')
            ->join('tbl_area as k', 'a.area_id', '=', 'k.area_id')
            ->join('tbl_zipcode as l', 'a.zipcode_id', '=', 'l.zipcode_id')
            ->join('users as m', 'a.user_id', '=', 'm.id')
            ->where('a.job_id', $id)
            ->first();
        if ($user) {
            $JobApplyHistory = JobApply::where('job_id', $id)->where('user_id', $user->id)->first();
            $SaveJobData = Jobsave::where('user_id', $user->id)->where('job_id', $id)->whereNull('deleted_at')->first();
        }

        $today = Carbon::today();
        $adBanner = AdBanner::where('page_nm', 2)->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)->first();


        $Setting = Setting::where('id', 1)->first();

        $Resumes = [];

        if ($user) {
            $Resumes = Resume::where('user_id', $user->id)->get();
        }
        // dd($jobData);

        return view('website.job-details', compact('jobData', 'user', 'SaveJobData', 'JobApplyHistory', 'adBanner', 'Setting', 'Resumes'));
    }


    public function contact()
    {
        $user = Auth::user();
        if ($user) {
            $this->planValidityCheck($user);
        }

        $Blog = Blog::where('status', 1)->get();
        $Testimonial = Testimonial::get();
        $Setting = Setting::where('id', 1)->first();
        return view('website.contact', compact('Blog', 'Testimonial', 'Setting'));
    }

    public function about()
    {
        $user = Auth::user();
        if ($user) {
            $this->planValidityCheck($user);
        }
        $Blog = Blog::where('status', 1)->get();
        $Testimonial = Testimonial::get();
        $About = Setting::where('id', 1)->first();
        return view('website.about', compact('Blog', 'Testimonial', 'About'));
    }


    public function create_resume(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $this->planValidityCheck($user);
        }

        $ResumeData = ResumeBuilder::where('user_id', $user->id)->first();
        $Setting = Setting::where('id', 1)->first();
        return view('website.create-resume', compact('Setting', 'ResumeData', 'user'));
    }

    // public function candidates()
    // {
    //     $user = Auth::user();
    //     if ($user) {
    //         $this->planValidityCheck($user);
    //     }
    //     $CandidatesData = User::where('role', 'User')->where('profile_type', 'Employee')->whereNull('deleted_at')->orderBy('id', 'desc')->get();
    //     return view('website.candidates-list', compact('CandidatesData'));
    // }

    // public function find_candidates(Request $request)
    // {
    //     $user = Auth::user();
    //     if ($user) {
    //         $this->planValidityCheck($user);
    //     }

    
    //     $CandidateData = DB::table('users')
    //         ->select([
    //             'users.*',
    //             'tbl_state.state_name',
    //             'tbl_city.city_nm',
    //             'tbl_area.area_nm',
    //             'tbl_zipcode.zipcode',

    //             // add category & subcategory names
    //             'tbl_job_category.category_nm as category_name',
    //             'tbl_sub_category.sub_category_nm as sub_category_name',
    //         ])
    //         ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
    //         ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
    //         ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'users.area_id')
    //         ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')

    //         // 👇 Add category mapping
    //         ->leftJoin('tbl_job_category', 'tbl_job_category.category_id', '=', 'users.category_id')

    //         // 👇 Add subcategory mapping
    //         ->leftJoin('tbl_sub_category', 'tbl_sub_category.sub_category_id', '=', 'users.sub_category_id')

    //         ->where('users.profile_type', 'Employee')
    //         ->where('users.role', 'User')
    //         ->where('users.active_status', 1)
    //         ->paginate(12);
    //     // dd($CandidateData);

    //     $CategoryData = JobCategory::get();
    //     $locations = DB::table('tbl_city as a')
    //         ->join('tbl_state as b', 'a.state_id', '=', 'b.state_id')
    //         ->select(
    //             'a.city_id',
    //             'a.state_id',
    //             DB::raw("CONCAT(a.city_nm, ',', b.state_name) as location")
    //         )->get();

    //     // All jobs
    //     // $allCandidateCount = DB::table('users')->where('role', 'User')->where('profile_type', 'Employee')->where('profile_status', 1)->where('active_status', 1)->count();
    //     $allCandidateCount = DB::table('users')
    //     ->where('role', 'User')
    //     ->where('profile_type', 'Employee')
    //     ->where('active_status', 1)
    //     ->count();

    //     $Blog = Blog::where('status', 1)->get();
    //     return view('website.find-candidates', compact('CandidateData', 'CategoryData', 'locations', 'allCandidateCount', 'Blog'));
    // }
    public function find_candidates(Request $request)
    {
        $user = Auth::user();
        // if (!$user || $user->profile_type === 'Employee') {
        //     abort(403, 'Unauthorized action.');
        // }
        // if ($user) {
        //     $this->planValidityCheck($user);
        // }
        if ($user) {
            $redirect = $this->planValidityCheck($user);
            if ($redirect) {
                return $redirect; // 🔥 GAME CHANGER
            }
        }

        /* ===========================
        CANDIDATE LIST (AS IT IS)
        ============================ */
        $CandidateData = DB::table('users')
            ->select([
                'users.*',
                'tbl_state.state_name',
                'tbl_city.city_nm',
                'tbl_area.area_nm',
                'tbl_zipcode.zipcode',
                'tbl_job_category.category_nm as category_name',
                'tbl_sub_category.sub_category_nm as sub_category_name',
            ])
            ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
            ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
            ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'users.area_id')
            ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')
            ->leftJoin('tbl_job_category', 'tbl_job_category.category_id', '=', 'users.category_id')
            ->leftJoin('tbl_sub_category', 'tbl_sub_category.sub_category_id', '=', 'users.sub_category_id')
            ->where('users.profile_type', 'Employee')
            ->where('users.role', 'User')
            ->where('users.active_status', 1)
            ->whereNull('users.deleted_at')
            ->paginate(12);
            // dd($CandidateData->items());

            // dd($CandidateData);

        /* ===========================
        OTHER OLD DATA
        ============================ */
        // $CategoryData = JobCategory::get();
        $CategoryData = JobCategory::orderBy('category_nm', 'asc')
        ->whereNull('deleted_at')
        ->get();
        $SubCategoryData = Jobsubcategory::orderBy('sub_category_nm', 'asc')->get();

        $locations = DB::table('tbl_city as a')
            ->join('tbl_state as b', 'a.state_id', '=', 'b.state_id')
            ->select(
                'a.city_id',
                'a.state_id',
                DB::raw("CONCAT(a.city_nm, ',', b.state_name) as location")
            )
            ->whereNull('a.deleted_at')
            ->orderBy('a.city_nm', 'asc')
            ->get();

        $allCandidateCount = DB::table('users')
            ->where('role', 'User')
            ->where('profile_type', 'Employee')
            ->where('active_status', 1)
            ->whereNull('deleted_at')
            ->count();

        //     $allCandidateCount  = DB::table('users')
        // ->select('id', 'name', 'preference_type')
        // ->where('role', 'User')
        // ->where('profile_type', 'Employee')
        // ->where('active_status', 1)
        // ->get();

        // dd($allCandidateCount);

            

        /* =========================================================
        ADVANCE FILTER COUNTS (CORRECT TABLE MAPPING)
        ========================================================= */

        // Preference Type (Skilled / UnSkilled)
        $preferenceTypeCounts = DB::table('users')
        ->select(
            'preference_type',
            DB::raw('COUNT(id) as total')
        )
        ->where('profile_type', 'Employee')
        ->where('active_status', 1)
        ->whereNull('deleted_at')
        ->whereIn('preference_type', [1, 2])   // 🔥 IMPORTANT
        ->groupBy('preference_type')
        ->get();


        // Industry / Category Count (USED AS $JobCategoryCount IN BLADE)
        $JobCategoryCount = DB::table('users as u')
            ->join('tbl_job_category as c', 'c.category_id', '=', 'u.category_id')
            ->select(
                'u.category_id',
                'c.category_nm',
                DB::raw('COUNT(u.id) as TotalJob')
            )
            ->where('u.profile_type', 'Employee')
            ->where('u.active_status', 1)
            ->whereNull('u.deleted_at')
            ->groupBy('u.category_id', 'c.category_nm')
            ->whereNull('c.deleted_at')
            ->orderBy('c.category_nm', 'asc')
            ->get();

        // Job Type Count (JOIN VIA tbl_job)
        $jobTypeCounts = DB::table('tbl_job_type as jt')
            ->join('tbl_job as j', 'jt.job_type_id', '=', 'j.job_type_id')
            ->join('users as u', 'u.id', '=', 'j.user_id')
            ->select(
                'jt.job_type_id',
                'jt.type_name',
                DB::raw('COUNT(j.job_id) as total_jobs')
            )
            ->where('u.profile_type', 'Company')   // 🔥 IMPORTANT
            ->where('u.active_status', 1)
            ->whereNull('u.deleted_at')
            ->whereNull('j.deleted_at')
            ->groupBy('jt.job_type_id', 'jt.type_name')
            ->get();


        // Job Level Count
        $jobLevelCounts = DB::table('tbl_job_level as jl')
            ->join('tbl_job as j', 'jl.job_level_id', '=', 'j.job_level_id')
            ->join('users as u', 'u.id', '=', 'j.user_id')
            ->select(
                'jl.job_level_id',
                'jl.type_nm as job_level_name',
                DB::raw('COUNT(j.job_id) as total_jobs')
            )
            ->where('u.profile_type', 'Company')
            ->where('u.active_status', 1)
            ->whereNull('u.deleted_at')
            ->whereNull('j.deleted_at')
            ->groupBy('jl.job_level_id', 'jl.type_nm')
            ->get();


        // Work Type Count
        $workTypeCounts = DB::table('tbl_work_type as wt')
            ->join('tbl_job as j', 'wt.work_type_id', '=', 'j.work_type_id')
            ->join('users as u', 'u.id', '=', 'j.user_id')
            ->select(
                'wt.work_type_id',
                'wt.type_nm as work_type_name',
                DB::raw('COUNT(j.job_id) as total_jobs')
            )
            ->where('u.profile_type', 'Company')
            ->where('u.active_status', 1)
            ->whereNull('u.deleted_at')
            ->whereNull('j.deleted_at')
            ->groupBy('wt.work_type_id', 'wt.type_nm')
            ->get();


        // Experience Level Count
    //    $experienceCounts = DB::table('tbl_experience_req as er')
    //     ->leftJoin('users as u', function ($join) {
    //         $join->on('u.experience', '=', 'er.name')
    //             ->where('u.profile_type', 'Employee')
    //             ->where('u.active_status', 1);
    //     })
    //     ->whereNull('er.deleted_at')    
    //     ->select(
    //         'er.experience_req_id',
    //         'er.name as experience_name',
    //         DB::raw('COUNT(u.id) as total_jobs')
    //     )
    //     ->groupBy('er.experience_req_id', 'er.name')
    //     ->orderBy('er.experience_req_id')
    //     ->get();
    $experienceCounts = DB::table('tbl_experience_req as er')
        ->leftJoin('users as u', function ($join) {
            $join->on(
                    DB::raw("CAST(REGEXP_SUBSTR(u.experience, '[0-9]+') AS UNSIGNED)"),
                    '=',
                    DB::raw("CAST(REGEXP_SUBSTR(er.name, '[0-9]+') AS UNSIGNED)")
                )
                ->where('u.profile_type', 'Employee')
                ->where('u.active_status', 1)
                ->whereNull('u.deleted_at');
        })
        ->whereNull('er.deleted_at')
        ->select(
            'er.experience_req_id',
            'er.name as experience_name',
            DB::raw('COUNT(u.id) as total_jobs')
        )
        ->groupBy('er.experience_req_id', 'er.name')
        ->orderBy('er.experience_req_id')
        ->get();
        // dd($experienceCounts);




        /* ===========================
        BLOG
        ============================ */
        $Blog = Blog::where('status', 1)->get();

        return view('website.find-candidates', compact(
            'CandidateData',
            'CategoryData',
            'SubCategoryData',
            'locations',
            'allCandidateCount',

            // sidebar filters
            'preferenceTypeCounts',
            'JobCategoryCount',
            'jobTypeCounts',
            'jobLevelCounts',
            'workTypeCounts',
            'experienceCounts',

            'Blog'
        ));
    }



   public function filter_candidates(Request $request)
    {
        $candidate_category = $request->input('category_id', []);
        $candidate_sub_category = $request->input('sub_category_id', []);
        $preference_type    = $request->input('preference_type', []);
        $experience         = $request->input('experience', []);
        $candidate_location = $request->input('candidate_location');
        $candidate_title    = $request->input('candidate_title');

        $candidate_sub_category = is_array($candidate_sub_category)
            ? $candidate_sub_category
            : [$candidate_sub_category];

        $candidate_sub_category = array_filter($candidate_sub_category, function ($value) {
            return $value !== null && $value !== '' && $value !== 'all';
        });

        $order_by = $request->input('order_by');
        $per_page = $request->input('per_page');
        $orderBy_name = ($order_by === "Old") ? "asc" : "desc";

        try {

            $CandidateData = DB::table('users')
                ->select([
                    'users.*',
                    'tbl_state.state_name',
                    'tbl_city.city_nm',
                    'tbl_area.area_nm',
                    'tbl_zipcode.zipcode',
                    'tbl_job_category.category_nm as category_name',
                    'tbl_sub_category.sub_category_nm as sub_category_name',
                ])
                ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
                ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
                ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'users.area_id')
                ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')
                ->leftJoin('tbl_job_category', 'tbl_job_category.category_id', '=', 'users.category_id')
                ->leftJoin('tbl_sub_category', 'tbl_sub_category.sub_category_id', '=', 'users.sub_category_id')

                ->where('users.profile_type', 'Employee')
                ->where('users.role', 'User')
                ->where('users.active_status', 1)
                ->whereNull('users.deleted_at')

                // ✅ PREFERENCE TYPE FILTER (🔥 MAIN FIX)
                ->when(!empty($preference_type), function ($q) use ($preference_type) {
                    $q->whereIn('users.preference_type', (array) $preference_type);
                })

                // ✅ CATEGORY FILTER
                ->when(!empty($candidate_category), function ($q) use ($candidate_category) {
                    $q->whereIn('users.category_id', $candidate_category);
                })

                // ✅ SUB CATEGORY FILTER
                ->when(!empty($candidate_sub_category), function ($q) use ($candidate_sub_category) {
                    $q->whereIn('users.sub_category_id', $candidate_sub_category);
                })

                // ✅ EXPERIENCE FILTER (🔥 MAIN FIX)

                // ->when(!empty($experience), function ($q) use ($experience) {
                //     $q->whereIn('users.experience', $experience);
                // })
                // ->when(!empty($experience), function ($q) use ($experience) {

                //     // experience array mathi number nikadvo (2,3,4...)
                //     $experienceNumbers = array_map(function ($exp) {
                //         preg_match('/\d+/', $exp, $matches);
                //         return $matches[0] ?? null;
                //     }, (array) $experience);

                //     $experienceNumbers = array_filter($experienceNumbers);

                //     if (!empty($experienceNumbers)) {
                //         $q->whereIn(
                //             DB::raw("CAST(REGEXP_SUBSTR(users.experience, '[0-9]+') AS UNSIGNED)"),
                //             $experienceNumbers
                //         );
                //     }
                // })
                ->when(!empty($experience), function ($q) use ($experience) {

                    $experience = array_map('strtolower', (array) $experience);

                    $q->where(function ($sub) use ($experience) {

                        // 🟢 1️⃣ Fresher handle
                        if (in_array('fresher', $experience)) {
                            $sub->orWhere('users.experience', 'fresher');
                        }

                        // 🟢 2️⃣ NULL treat as fresher (IMPORTANT)
                        // if (in_array('fresher', $experience)) {
                        //     $sub->orWhereNull('users.experience');
                        // }

                        // 🟢 3️⃣ Numeric experience (1,2,3…)
                        $experienceNumbers = array_map(function ($exp) {
                            preg_match('/\d+/', $exp, $matches);
                            return $matches[0] ?? null;
                        }, $experience);

                        $experienceNumbers = array_filter($experienceNumbers);

                        if (!empty($experienceNumbers)) {
                            $sub->orWhereIn(
                                DB::raw("CAST(REGEXP_SUBSTR(users.experience, '[0-9]+') AS UNSIGNED)"),
                                $experienceNumbers
                            );
                        }
                    });
                })

                // ->when(!empty($experience), function ($q) use ($experience) {
                //     $q->whereIn('users.experience', (array)$experience);
                // })



                // ✅ LOCATION FILTER
                ->when($candidate_location, function ($q) use ($candidate_location) {
                    $q->where('users.city_id', $candidate_location);
                })

                // ✅ SEARCH FILTER
                // ->when($candidate_title, function ($q) use ($candidate_title) {
                //     $q->where(function ($sub) use ($candidate_title) {
                //         $sub->where('users.name', 'LIKE', "%$candidate_title%")
                //             ->orWhere('users.about', 'LIKE', "%$candidate_title%")
                //             ->orWhere('users.skills_id', 'LIKE', "%$candidate_title%");
                //     });
                // })
                // ✅ SEARCH FILTER (Name + About + Skills + Sub Category)
                // ->when($candidate_title, function ($q) use ($candidate_title) {
                //     $q->where(function ($sub) use ($candidate_title) {
                //         $sub->where('users.name', 'LIKE', "%{$candidate_title}%")
                //             ->orWhere('users.about', 'LIKE', "%{$candidate_title}%")
                //             ->orWhere('users.skills_id', 'LIKE', "%{$candidate_title}%")
                //             ->orWhere('tbl_sub_category.sub_category_nm', 'LIKE', "%{$candidate_title}%"); // ✅ MAIN LINE
                //     });
                // })
                ->when($candidate_title, function ($q) use ($candidate_title) {
                    $q->where(function ($sub) use ($candidate_title) {
                        $sub->where('users.name', 'LIKE', "%{$candidate_title}%")
                            ->orWhere('users.about', 'LIKE', "%{$candidate_title}%")
                            ->orWhere('users.skills_id', 'LIKE', "%{$candidate_title}%")
                            ->orWhere('tbl_sub_category.sub_category_nm', 'LIKE', "%{$candidate_title}%")
                            ->orWhere('tbl_zipcode.zipcode', 'LIKE', "%{$candidate_title}%"); // ✅ ZIPCODE FIX
                    });
                })

                ->orderBy('users.id', $orderBy_name)
                ->paginate($per_page ?? 12);

            return response()->json([
                'status' => 1,
                'message' => 'Filtered Candidates retrieved.',
                'data' => $CandidateData,
                'job_info' => [
                    'from' => $CandidateData->firstItem(),
                    'to' => $CandidateData->lastItem(),
                    'total' => $CandidateData->total(),
                ]
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong while filtering Candidates.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }


    public function find_companies()
    {
        $user = Auth::user();
        if ($user) {
            $this->planValidityCheck($user);
        }

        // $CategoryData = JobCategory::get();
        $CategoryData = JobCategory::orderBy('category_nm', 'asc')->get();
        $locations = DB::table('tbl_city as a')
            ->join('tbl_state as b', 'a.state_id', '=', 'b.state_id')
            ->select(
                'a.city_id',
                'a.state_id',
                DB::raw("CONCAT(a.city_nm, ',', b.state_name) as location")
            )
            ->whereNull('a.deleted_at')
            ->orderBy('a.city_nm', 'asc')
            ->get();

        // $JobCategoryCount = DB::table('tbl_job as a')
        //     ->select('a.category_id', 'b.category_nm', DB::raw('COUNT(a.job_id) as TotalJob'))
        //     ->join('tbl_job_category as b', 'a.category_id', '=', 'b.category_id')
        //     ->groupBy('a.category_id', 'b.category_nm')
        //     ->get();
        // $JobCategoryCount = DB::table('tbl_job as a')
        // ->select(
        //     'a.category_id',
        //     'b.category_nm',
        //     DB::raw('COUNT(a.job_id) as TotalJob')
        // )
        // ->join('tbl_job_category as b', function ($join) {
        //     $join->on('a.category_id', '=', 'b.category_id')
        //         ->whereNull('b.deleted_at'); 
        // })
        // ->whereNull('a.deleted_at') 
        // ->groupBy('a.category_id', 'b.category_nm')
        // ->get();    
        $JobCategoryCount = DB::table('users as u')
            ->join('tbl_job_category as c', 'c.category_id', '=', 'u.category_id')
            ->select(
                'u.category_id',
                'c.category_nm',
                DB::raw('COUNT(DISTINCT u.id) as TotalCompany')
            )
            ->where('u.profile_type', 'Company')
            ->where('u.role', 'User')
            ->where('u.active_status', 1)
            ->groupBy('u.category_id', 'c.category_nm')
            ->get();


        // dd($JobCategoryCount);

        $jobTypeCounts = DB::table('tbl_job_type as a')
            ->leftJoin('tbl_job as b', 'a.job_type_id', '=', 'b.job_type_id')
            ->select(
                'a.job_type_id',
                'a.type_name',
                DB::raw('COUNT(b.job_id) as total_jobs')
            )
            ->groupBy('a.job_type_id', 'a.type_name')
            ->whereNull('a.deleted_at')
            ->whereNull('b.deleted_at')
            ->where('b.status', 1)
            ->get();

        $jobLevelCounts = DB::table('tbl_job_level as a')
            ->leftJoin('tbl_job as b', 'a.job_level_id', '=', 'b.job_level_id')
            ->select(
                'a.job_level_id',
                'a.type_nm as job_level_name',
                DB::raw('COUNT(b.job_id) as total_jobs')
            )
            ->groupBy('a.job_level_id', 'a.type_nm')
            ->wherenull('a.deleted_at')
            ->wherenull('b.deleted_at')
            ->where('b.status', 1)
            ->get();

        $workTypeCounts = DB::table('tbl_work_type as a')
            ->leftJoin('tbl_job as b', 'a.work_type_id', '=', 'b.work_type_id')
            ->select(
                'a.work_type_id',
                'a.type_nm as work_type_name',
                DB::raw('COUNT(b.job_id) as total_jobs')
            )
            ->groupBy('a.work_type_id', 'a.type_nm')
            ->whereNull('a.deleted_at')
            ->whereNull('b.deleted_at')
            ->where('b.status', 1)
            ->get();

        // $experienceCounts = DB::table('tbl_experience_req as a')
        //     ->leftJoin('tbl_job as b', 'a.experience_req_id', '=', 'b.experience_req_id')
        //     ->select(
        //         'a.experience_req_id',
        //         'a.name as experience_name',
        //         DB::raw('COUNT(b.job_id) as total_jobs')
        //     )
        //     ->whereNull('a.deleted_at')
        //     ->whereNull('b.deleted_at')

        //     ->groupBy('a.experience_req_id', 'a.name')
        //     ->get();

            $experienceCounts = DB::table('tbl_experience_req as a')
                ->leftJoin('tbl_job as b', function ($join) {
                    $join->on('a.experience_req_id', '=', 'b.experience_req_id')
                        ->whereNull('b.deleted_at')
                        ->where('b.status', 1);
                })
                ->select(
                    'a.experience_req_id',
                    'a.name as experience_name',
                    DB::raw('COUNT(b.job_id) as total_jobs')
                )
                ->whereNull('a.deleted_at')
                ->groupBy('a.experience_req_id', 'a.name')
                ->get();


        // $CompanyData = DB::table('users')
        // ->select([
        //     'users.id',
        //     'users.name',
        //     'users.profile_img',
        //     'tbl_state.state_name',
        //     'tbl_state.state_id',
        //     'tbl_city.city_nm',
        //     'tbl_city.city_id',
        //     'tbl_area.area_nm',
        //     'tbl_area.area_id',
        //     'tbl_zipcode.zipcode',
        //     'tbl_zipcode.zipcode_id',
        //     DB::raw('COUNT(DISTINCT tbl_job.job_id) as JobCount')
        // ])
        // ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
        // ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
        // ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'users.area_id')
        // ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')
        // ->leftJoin('tbl_job', 'tbl_job.user_id', '=', 'users.id')
        // ->where('users.profile_type', 'Company')
        // ->where('users.role', 'User')
        // ->where('users.active_status', 1)
        // ->groupBy(
        //     'users.id',
        //     'users.name',
        //     'users.profile_img',
        //     'tbl_state.state_name',
        //     'tbl_state.state_id',
        //     'tbl_city.city_nm',
        //     'tbl_city.city_id',
        //     'tbl_area.area_nm',
        //     'tbl_area.area_id',
        //     'tbl_zipcode.zipcode',
        //     'tbl_zipcode.zipcode_id'
        // )
        // ->orderBy('users.name')
        // ->paginate(12);
        // dd($CompanyData);
        $CompanyData = DB::table('users')
            ->select([
                'users.id',
                'users.name',
                'users.profile_img',
                'tbl_state.state_name',
                'tbl_state.state_id',
                'tbl_city.city_nm',
                'tbl_city.city_id',
                'tbl_area.area_nm',
                'tbl_area.area_id',
                'tbl_zipcode.zipcode',
                'tbl_zipcode.zipcode_id',
                DB::raw('COUNT(DISTINCT tbl_job.job_id) as JobCount')
            ])
            ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
            ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
            ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'users.area_id')
            ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')

            // ✅ FIX HERE
            ->leftJoin('tbl_job', function ($join) {
                $join->on('tbl_job.user_id', '=', 'users.id')
                    ->where('tbl_job.status', 1)          // only active jobs
                    ->whereNull('tbl_job.deleted_at');
            })

            ->where('users.profile_type', 'Company')
            ->where('users.role', 'User')
            ->where('users.active_status', 1)
            ->whereNull('users.deleted_at')

            ->groupBy(
                'users.id',
                'users.name',
                'users.profile_img',
                'tbl_state.state_name',
                'tbl_state.state_id',
                'tbl_city.city_nm',
                'tbl_city.city_id',
                'tbl_area.area_nm',
                'tbl_area.area_id',
                'tbl_zipcode.zipcode',
                'tbl_zipcode.zipcode_id'
            )
            ->orderBy('users.name')
            ->paginate(12);

            // dd($CompanyData);


        $allCompanyCount = DB::table('users')->where('role', 'User')->where('profile_type', 'Company')->where('active_status', 1)->whereNull('deleted_at')->count();
        $Blog = Blog::where('status', 1)->get();
        return view('website.find-companies', compact('CategoryData', 'locations', 'JobCategoryCount', 'jobTypeCounts', 'jobLevelCounts', 'workTypeCounts', 'experienceCounts', 'CompanyData', 'allCompanyCount', 'Blog'));
    }

    // public function filter_companies(Request $request)
    // {
    //     $job_category = $request->input('job_category');
    //     $job_location = $request->input('job_location'); // city_id
    //     $job_title = $request->input('job_title');


    //     $order_by = $request->input('order_by');
    //     $per_page = $request->input('per_page');
    //     $category_id = $request->input('category_id');
    //     $job_type_id = $request->input('job_type_id');
    //     $job_level_id = $request->input('job_level_id');
    //     $work_type_id = $request->input('work_type_id');
    //     $experience_req_id = $request->input('experience_req_id');
    //     $job_posted_day = $request->input('job_posted_day');


    //     $orderBy_name = ($order_by === "Old") ? "asc" : "desc";

    //     try {
    //         $query = DB::table('users')
    //             ->select([
    //                 'users.id',
    //                 'users.name',
    //                 'tbl_state.state_name',
    //                 'tbl_state.state_id',
    //                 'tbl_city.city_nm',
    //                 'tbl_city.city_id',
    //                 'tbl_area.area_nm',
    //                 'tbl_area.area_id',
    //                 'tbl_zipcode.zipcode',
    //                 'tbl_zipcode.zipcode_id',
    //                 DB::raw('COUNT(DISTINCT tbl_job.job_id) as JobCount')
    //             ])
    //             ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
    //             ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
    //             ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'users.area_id')
    //             ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')
    //             ->leftJoin('tbl_job', 'tbl_job.user_id', '=', 'users.id')
    //             ->where('users.profile_type', 'Company')
    //             ->where('users.role', 'User')
    //             ->where('users.active_status', 1);
    //             // ->where('users.profile_status', 1);;

    //         // Apply filters conditionally
    //         if ($job_category) {
    //             // Assuming jobs have a category_id related to users via tbl_job
    //             // Join tbl_job_category via tbl_job (if needed)
    //             // Since we don't join tbl_job_category in the base query, we'll filter users by jobs matching category_id

    //             $query->whereExists(function ($subQuery) use ($job_category) {
    //                 $subQuery->select(DB::raw(1))
    //                     ->from('tbl_job')
    //                     ->whereColumn('tbl_job.user_id', 'users.id')
    //                     ->when(is_array($job_category), function ($q) use ($job_category) {
    //                         $q->whereIn('tbl_job.category_id', $job_category);
    //                     }, function ($q) use ($job_category) {
    //                         $q->where('tbl_job.category_id', $job_category);
    //                     });
    //             });
    //         }


    //         if ($category_id) {
    //             // Assuming jobs have a category_id related to users via tbl_job
    //             // Join tbl_job_category via tbl_job (if needed)
    //             // Since we don't join tbl_job_category in the base query, we'll filter users by jobs matching category_id

    //             $query->whereExists(function ($subQuery) use ($category_id) {
    //                 $subQuery->select(DB::raw(1))
    //                     ->from('tbl_job')
    //                     ->whereColumn('tbl_job.user_id', 'users.id')
    //                     ->when(is_array($category_id), function ($q) use ($category_id) {
    //                         $q->whereIn('tbl_job.category_id', $category_id);
    //                     }, function ($q) use ($category_id) {
    //                         $q->where('tbl_job.category_id', $category_id);
    //                     });
    //             });
    //         }


    //         if ($job_type_id) {
    //             $query->whereExists(function ($subQuery) use ($job_type_id) {
    //                 $subQuery->select(DB::raw(1))
    //                     ->from('tbl_job')
    //                     ->whereColumn('tbl_job.user_id', 'users.id')
    //                     ->when(is_array($job_type_id), function ($q) use ($job_type_id) {
    //                         $q->whereIn('tbl_job.job_type_id', $job_type_id);
    //                     }, function ($q) use ($job_type_id) {
    //                         $q->where('tbl_job.job_type_id', $job_type_id);
    //                     });
    //             });
    //         }


    //         if ($job_level_id) {
    //             $query->whereExists(function ($subQuery) use ($job_level_id) {
    //                 $subQuery->select(DB::raw(1))
    //                     ->from('tbl_job')
    //                     ->whereColumn('tbl_job.user_id', 'users.id')
    //                     ->when(is_array($job_level_id), function ($q) use ($job_level_id) {
    //                         $q->whereIn('tbl_job.job_level_id', $job_level_id);
    //                     }, function ($q) use ($job_level_id) {
    //                         $q->where('tbl_job.job_level_id', $job_level_id);
    //                     });
    //             });
    //         }


    //         if ($work_type_id) {
    //             $query->whereExists(function ($subQuery) use ($work_type_id) {
    //                 $subQuery->select(DB::raw(1))
    //                     ->from('tbl_job')
    //                     ->whereColumn('tbl_job.user_id', 'users.id')
    //                     ->when(is_array($work_type_id), function ($q) use ($work_type_id) {
    //                         $q->whereIn('tbl_job.work_type_id', $work_type_id);
    //                     }, function ($q) use ($work_type_id) {
    //                         $q->where('tbl_job.work_type_id', $work_type_id);
    //                     });
    //             });
    //         }

    //         if ($experience_req_id) {
    //             $query->whereExists(function ($subQuery) use ($experience_req_id) {
    //                 $subQuery->select(DB::raw(1))
    //                     ->from('tbl_job')
    //                     ->whereColumn('tbl_job.user_id', 'users.id')
    //                     ->when(is_array($experience_req_id), function ($q) use ($experience_req_id) {
    //                         $q->whereIn('tbl_job.experience_req_id', $experience_req_id);
    //                     }, function ($q) use ($experience_req_id) {
    //                         $q->where('tbl_job.experience_req_id', $experience_req_id);
    //                     });
    //             });
    //         }


    //         if ($job_location) {
    //             if (is_array($job_location)) {
    //                 $query->whereIn('users.city_id', $job_location);
    //             } else {
    //                 $query->where('users.city_id', $job_location);
    //             }
    //         }


    //         if ($job_title) {
    //             // Filter companies who have jobs matching job_title
    //             $query->whereExists(function ($subQuery) use ($job_title) {
    //                 $subQuery->select(DB::raw(1))
    //                     ->from('tbl_job')
    //                     ->whereColumn('tbl_job.user_id', 'users.id')
    //                     ->where('tbl_job.job_title', 'LIKE', '%' . $job_title . '%')
    //                     ->Orwhere('users.name', 'LIKE', '%' . $job_title . '%')
    //                     ->Orwhere('users.skills_id', 'LIKE', '%' . $job_title . '%');
    //             });
    //         }

    //         // Group & order
    //         $query->groupBy(
    //             'users.id',
    //             'users.name',
    //             'tbl_state.state_name',
    //             'tbl_state.state_id',
    //             'tbl_city.city_nm',
    //             'tbl_city.city_id',
    //             'tbl_area.area_nm',
    //             'tbl_area.area_id',
    //             'tbl_zipcode.zipcode',
    //             'tbl_zipcode.zipcode_id'
    //         )
    //             ->orderBy('users.name', $orderBy_name);

    //         // Pagination
    //         $companies = $query->paginate($per_page);

    //         return response()->json([
    //             'status'  => 1,
    //             'message' => 'Companies filtered successfully',
    //             'data'    => $companies,
    //         ]);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status'  => 0,
    //             'message' => 'Something went wrong while filtering companies.',
    //             'error' => $th->getMessage()
    //         ], 500);
    //     }
    // }
    // public function filter_companies(Request $request)
    // {
    //     $job_category      = $request->job_category;        // Top dropdown
    //     $job_location      = $request->job_location;        // City
    //     $job_title         = $request->job_title;

    //     $order_by          = $request->order_by;
    //     $per_page          = $request->per_page ?? 12;

    //     $job_type_id       = $request->job_type_id;
    //     $job_level_id      = $request->job_level_id;
    //     $work_type_id      = $request->work_type_id;
    //     $experience_req_id = $request->experience_req_id;

    //     $orderBy_name = ($order_by === "Old") ? "asc" : "desc";

    //     try {

    //         $query = DB::table('users')
    //             ->select([
    //                 'users.id',
    //                 'users.name',
    //                 'users.profile_img',
    //                 'tbl_state.state_name',
    //                 'tbl_city.city_nm',
    //                 DB::raw('COUNT(tbl_job.job_id) as JobCount')
    //             ])
    //             ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
    //             ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
    //             ->leftJoin('tbl_job', function($join){
    //                 $join->on('tbl_job.user_id', '=', 'users.id')
    //                     ->whereNull('tbl_job.deleted_at')
    //                     ->where('tbl_job.status', 1);
    //             })
    //             ->where('users.profile_type', 'Company')
    //             ->where('users.role', 'User')
    //             ->where('users.active_status', 1);
    //             // ->where('users.profile_status', 1);

    //         /* ---------------------------------------------------------
    //             🔥 FILTER 1: INDUSTRY DROPDOWN (job_category)
    //         --------------------------------------------------------- */
    //         if ($job_category) {
    //             $query->where('users.category_id', $job_category);
    //         }

    //         /* ---------------------------------------------------------
    //             🔥 FILTER 2: LOCATION (CITY)
    //         --------------------------------------------------------- */
    //         if ($job_location) {
    //             $query->where('users.city_id', $job_location);
    //         }

    //         /* ---------------------------------------------------------
    //             🔥 FILTER 3: KEYWORD SEARCH
    //         --------------------------------------------------------- */
    //         if (!empty($job_title)) {
    //             $query->where(function ($q) use ($job_title) {
    //                 $q->where('users.name', 'LIKE', '%' . $job_title . '%')
    //                 ->orWhereExists(function ($sub) use ($job_title) {
    //                     $sub->select(DB::raw(1))
    //                         ->from('tbl_job')
    //                         ->whereColumn('tbl_job.user_id', 'users.id')
    //                         ->where('tbl_job.job_title', 'LIKE', '%' . $job_title . '%');
    //                 });
    //             });
    //         }

    //         /* ---------------------------------------------------------
    //             🔥 FILTER 4: JOB TYPE
    //         --------------------------------------------------------- */
    //         if ($job_type_id) {
    //             $query->whereExists(function ($sub) use ($job_type_id) {
    //                 $sub->select(DB::raw(1))
    //                     ->from('tbl_job')
    //                     ->whereColumn('tbl_job.user_id', 'users.id')
    //                     ->whereIn('tbl_job.job_type_id', (array)$job_type_id);
    //             });
    //         }

    //         /* ---------------------------------------------------------
    //             🔥 FILTER 5: JOB LEVEL
    //         --------------------------------------------------------- */
    //         if ($job_level_id) {
    //             $query->whereExists(function ($sub) use ($job_level_id) {
    //                 $sub->select(DB::raw(1))
    //                     ->from('tbl_job')
    //                     ->whereColumn('tbl_job.user_id', 'users.id')
    //                     ->whereIn('tbl_job.job_level_id', (array)$job_level_id);
    //             });
    //         }

    //         /* ---------------------------------------------------------
    //             🔥 FILTER 6: WORK TYPE
    //         --------------------------------------------------------- */
    //         if ($work_type_id) {
    //             $query->whereExists(function ($sub) use ($work_type_id) {
    //                 $sub->select(DB::raw(1))
    //                     ->from('tbl_job')
    //                     ->whereColumn('tbl_job.user_id', 'users.id')
    //                     ->whereIn('tbl_job.work_type_id', (array)$work_type_id);
    //             });
    //         }

    //         /* ---------------------------------------------------------
    //             🔥 FILTER 7: EXPERIENCE REQUIREMENT
    //         --------------------------------------------------------- */
    //         if ($experience_req_id) {
    //             $query->whereExists(function ($sub) use ($experience_req_id) {
    //                 $sub->select(DB::raw(1))
    //                     ->from('tbl_job')
    //                     ->whereColumn('tbl_job.user_id', 'users.id')
    //                     ->whereIn('tbl_job.experience_req_id', (array)$experience_req_id);
    //             });
    //         }

    //         /* ---------------------------------------------------------
    //             🔥 FINAL GROUP + SORT
    //         --------------------------------------------------------- */
    //         $query->groupBy(
    //             'users.id',
    //             'users.name',
    //             'users.profile_img',
    //             'tbl_state.state_name',
    //             'tbl_city.city_nm'
    //         )->orderBy('users.id', $orderBy_name);

    //         /* ---------------------------------------------------------
    //             🔥 PAGINATION
    //         --------------------------------------------------------- */
    //         $companies = $query->paginate($per_page);

    //         return response()->json([
    //             'status'  => 1,
    //             'message' => 'Companies filtered successfully',
    //             'data'    => $companies,
    //         ]);

    //     } catch (\Throwable $th) {

    //         return response()->json([
    //             'status'  => 0,
    //             'message' => 'Something went wrong.',
    //             'error'   => $th->getMessage()
    //         ], 500);
    //     }
    // }
    // public function filter_companies(Request $request)
    // {
    //         // dd($request->all());

    //     $job_category = $request->category_id;
    //     $job_location      = $request->job_location;
    //     $job_title         = $request->job_title;
    //     $order_by          = $request->order_by;
    //     $per_page          = $request->per_page ?? 12;

    //     $job_type_id       = $request->job_type_id;
    //     $job_level_id      = $request->job_level_id;
    //     $work_type_id      = $request->work_type_id;
    //     $experience_req_id = $request->experience_req_id;

    //     $orderBy = ($order_by === "Old") ? "asc" : "desc";

    //     $query = DB::table('users')
    //         ->select(
    //             'users.id',
    //             'users.name',
    //             'users.profile_img',
    //             'tbl_state.state_name',
    //             'tbl_city.city_nm',
    //             DB::raw('COUNT(DISTINCT tbl_job.job_id) as JobCount')
    //         )
    //         ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
    //         ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
    //         ->leftJoin('tbl_job', function ($join) {
    //             $join->on('tbl_job.user_id', '=', 'users.id')
    //                 ->where('tbl_job.status', 1)
    //                 ->whereNull('tbl_job.deleted_at');
    //         })
    //         ->where('users.profile_type', 'Company')
    //         ->where('users.role', 'User')
    //         ->where('users.active_status', 1);

    //     if (!empty($job_category)) {
    //         $query->whereIn('tbl_job.category_id', (array)$job_category);
    //     }

    //     if ($job_location) {
    //         $query->where('users.city_id', $job_location);
    //     }

    //     if ($job_title) {
    //         $query->where('users.name', 'LIKE', "%$job_title%");
    //     }

    //     if (!empty($job_type_id)) {
    //         $query->whereIn('tbl_job.job_type_id', (array)$job_type_id);
    //     }

    //     if (!empty($job_level_id)) {
    //         $query->whereIn('tbl_job.job_level_id', (array)$job_level_id);
    //     }

    //     if (!empty($work_type_id)) {
    //         $query->whereIn('tbl_job.work_type_id', (array)$work_type_id);
    //     }

    //     if (!empty($experience_req_id)) {
    //         $query->whereIn('tbl_job.experience_req_id', (array)$experience_req_id);
    //     }

    //     $companies = $query
    //         ->groupBy('users.id','users.name','users.profile_img','tbl_state.state_name','tbl_city.city_nm')
    //         ->orderBy('users.id', $orderBy)
    //         ->paginate($per_page);

    //     return response()->json([
    //         'status' => 1,
    //         'data' => $companies
    //     ]);
    // }
    public function filter_companies(Request $request)
    {
        $job_category      = $request->input('category_id', []);
        $job_category_top  = $request->input('job_category');
        $sub_category_id   = $request->input('sub_category_id', []);
        $job_location      = $request->job_location;
        $job_title         = $request->job_title;
        $order_by          = $request->order_by;
        $per_page          = $request->per_page ?? 12;

        $job_type_id       = $request->job_type_id;
        $job_level_id      = $request->job_level_id;
        $work_type_id      = $request->work_type_id;
        $experience_req_id = $request->experience_req_id;

        $job_category = is_array($job_category) ? $job_category : [$job_category];
        $job_category = array_filter($job_category, function ($value) {
            return $value !== null && $value !== '' && $value !== 'all';
        });

        if (!empty($job_category_top) && !in_array($job_category_top, $job_category)) {
            $job_category[] = $job_category_top;
        }

        $sub_category_id = is_array($sub_category_id) ? $sub_category_id : [$sub_category_id];
        $sub_category_id = array_filter($sub_category_id, function ($value) {
            return $value !== null && $value !== '' && $value !== 'all';
        });

        $orderBy = ($order_by === "Old") ? "asc" : "desc";

        $query = DB::table('users')
            ->select(
                'users.id',
                'users.name',
                'users.profile_img',
                'tbl_state.state_name',
                'tbl_city.city_nm',
                DB::raw('COUNT(DISTINCT tbl_job.job_id) as JobCount')
            )
            ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
            ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
            ->leftJoin('tbl_job', function ($join) {
                $join->on('tbl_job.user_id', '=', 'users.id')
                    ->where('tbl_job.status', 1)
                    ->whereNull('tbl_job.deleted_at');
            })
            ->where('users.profile_type', 'Company')
            ->where('users.role', 'User')
            ->where('users.active_status', 1);

        // 🔹 EXISTING FILTERS (UNCHANGED)
        if (!empty($job_category)) {
            $query->whereIn('users.category_id', $job_category);
        }

        if (!empty($sub_category_id)) {
            $query->whereIn('users.sub_category_id', $sub_category_id);
        }

        if ($job_location) {
            $query->where('users.city_id', $job_location);
        }

        if ($job_title) {
            $query->where('users.name', 'LIKE', "%$job_title%");
        }

        if (!empty($job_type_id)) {
            $query->whereIn('tbl_job.job_type_id', (array)$job_type_id);
        }

        if (!empty($job_level_id)) {
            $query->whereIn('tbl_job.job_level_id', (array)$job_level_id);
        }

        if (!empty($work_type_id)) {
            $query->whereIn('tbl_job.work_type_id', (array)$work_type_id);
        }

        if (!empty($experience_req_id)) {
            $query->whereIn('tbl_job.experience_req_id', (array)$experience_req_id);
        }

        // ✅ ONLY FIX (1 SAFE LINE)
        $companies = $query
            ->groupBy(
                'users.id',
                'users.name',
                'users.profile_img',
                'tbl_state.state_name',
                'tbl_city.city_nm'
            )
            ->havingRaw('COUNT(DISTINCT tbl_job.job_id) > 0') // ⭐ FIX
            ->orderBy('users.id', $orderBy)
            ->paginate($per_page);

        return response()->json([
            'status' => 1,
            'data'   => $companies
        ]);
    }




    public function job()
    {

        $user = Auth::user();
        if ($user) {
            $this->planValidityCheck($user);
        }

        // $jobData = DB::table('tbl_job as a')
        //     ->select(
        //         'a.*',
        //         'b.category_nm',
        //         'c.sub_category_nm',
        //         'd.name as qualification_nm',
        //         'e.type_nm as job_level_name',
        //         'f.type_name as job_type_name',
        //         'g.type_nm as work_type_name',
        //         'h.name as experience_name',
        //         'i.state_name',
        //         'j.city_nm',
        //         'k.area_nm',
        //         'l.zipcode',
        //         'm.name as user_name',
        //         'm.profile_img',
        //         'n.state_name',
        //         'o.city_nm',
        //         'p.area_nm',
        //         'q.zipcode',
        //     )->join('tbl_job_category as b', 'a.category_id', '=', 'b.category_id')
        //     ->join('tbl_sub_category as c', 'a.sub_category_id', '=', 'c.sub_category_id')
        //     ->join('tbl_min_qualification as d', 'a.qualification_id', '=', 'd.qualification_id')
        //     ->join('tbl_job_level as e', 'a.job_level_id', '=', 'e.job_level_id')
        //     ->join('tbl_job_type as f', 'a.job_type_id', '=', 'f.job_type_id')
        //     ->join('tbl_work_type as g', 'a.work_type_id', '=', 'g.work_type_id')
        //     ->join('tbl_experience_req as h', 'a.experience_req_id', '=', 'h.experience_req_id')
        //     ->join('tbl_state as i', 'a.state_id', '=', 'i.state_id')
        //     ->join('tbl_city as j', 'a.city_id', '=', 'j.city_id')
        //     ->join('tbl_area as k', 'a.area_id', '=', 'k.area_id')
        //     ->join('tbl_zipcode as l', 'a.zipcode_id', '=', 'l.zipcode_id')
        //     ->join('users as m', 'a.user_id', '=', 'm.id')
        //     ->join('tbl_state as n', 'a.state_id', '=', 'n.state_id')
        //     ->join('tbl_city as o', 'a.city_id', '=', 'o.city_id')
        //     ->join('tbl_area as p', 'a.area_id', '=', 'p.area_id')
        //     ->join('tbl_zipcode as q', 'a.zipcode_id', '=', 'q.zipcode_id')
        //     ->where('a.status', 1)  // ✅ Correct orderBy usage
        //     ->orderBy('a.datetime', 'desc')  // ✅ Correct orderBy usage
        //     ->paginate(12);
        
        // $query = DB::table('tbl_job as a')
        //     ->select(
        //         'a.*',
        //         'b.category_nm',
        //         'c.sub_category_nm',
        //         'd.name as qualification_nm',
        //         'e.type_nm as job_level_name',
        //         'f.type_name as job_type_name',
        //         'g.type_nm as work_type_name',
        //         'h.name as experience_name',
        //         'i.state_name',
        //         'j.city_nm',
        //         'k.area_nm',
        //         'l.zipcode',
        //         'm.name as user_name',
        //         'm.profile_img',
        //         'n.state_name',
        //         'o.city_nm',
        //         'p.area_nm',
        //         'q.zipcode',
        //     )
        //     ->join('tbl_job_category as b','a.category_id','=','b.category_id')
        //     ->join('tbl_sub_category as c','a.sub_category_id','=','c.sub_category_id')
        //     ->join('tbl_min_qualification as d','a.qualification_id','=','d.qualification_id')
        //     ->join('tbl_job_level as e','a.job_level_id','=','e.job_level_id')
        //     ->join('tbl_job_type as f','a.job_type_id','=','f.job_type_id')
        //     ->join('tbl_work_type as g','a.work_type_id','=','g.work_type_id')
        //     ->join('tbl_experience_req as h','a.experience_req_id','=','h.experience_req_id')
        //     ->join('tbl_state as i','a.state_id','=','i.state_id')
        //     ->join('tbl_city as j','a.city_id','=','j.city_id')
        //     ->join('tbl_area as k','a.area_id','=','k.area_id')
        //     ->join('tbl_zipcode as l','a.zipcode_id','=','l.zipcode_id')
        //     ->join('users as m','a.user_id','=','m.id')
        //     ->join('tbl_state as n','a.state_id','=','n.state_id')
        //     ->join('tbl_city as o','a.city_id','=','o.city_id')
        //     ->join('tbl_area as p','a.area_id','=','p.area_id')
        //     ->join('tbl_zipcode as q','a.zipcode_id','=','q.zipcode_id')
        //     ->where('a.status',1);
        $query = DB::table('tbl_job as a')
            ->select(
                'a.*',
                'b.category_nm',
                'c.sub_category_nm',
                'd.name as qualification_nm',
                'e.type_nm as job_level_name',
                'f.type_name as job_type_name',
                'g.type_nm as work_type_name',
                'h.name as experience_name',
                'i.state_name',
                'j.city_nm',
                'k.area_nm',
                'l.zipcode',
                'm.name as user_name',
                'm.profile_img'
            )

            // REQUIRED RELATIONS
            ->join('tbl_job_category as b','a.category_id','=','b.category_id')
            ->join('tbl_job_level as e','a.job_level_id','=','e.job_level_id')
            ->join('tbl_job_type as f','a.job_type_id','=','f.job_type_id')
            ->join('tbl_work_type as g','a.work_type_id','=','g.work_type_id')
            ->join('users as m','a.user_id','=','m.id')

            // OPTIONAL RELATIONS (🔥 LEFT JOIN)
            ->leftJoin('tbl_sub_category as c','a.sub_category_id','=','c.sub_category_id')
            ->leftJoin('tbl_min_qualification as d','a.qualification_id','=','d.qualification_id')
            ->leftJoin('tbl_experience_req as h','a.experience_req_id','=','h.experience_req_id')
            ->leftJoin('tbl_state as i','a.state_id','=','i.state_id')
            ->leftJoin('tbl_city as j','a.city_id','=','j.city_id')
            ->leftJoin('tbl_area as k','a.area_id','=','k.area_id')
            ->leftJoin('tbl_zipcode as l','a.zipcode_id','=','l.zipcode_id')

            ->where('a.status', 1);


        if(request()->has('category')){
            $query->where('a.category_id', request('category'));
        }
        $jobData = $query->orderBy('a.datetime','desc')->paginate(12);



        // $CategoryData = JobCategory::get();
        $CategoryData = JobCategory::orderBy('category_nm', 'asc')->get();
        $locations = DB::table('tbl_city as a')
            ->join('tbl_state as b', 'a.state_id', '=', 'b.state_id')
            ->select(
                'a.city_id',
                'a.state_id',
                DB::raw("CONCAT(a.city_nm, ',', b.state_name) as location")
            )
            ->whereNull('a.deleted_at')
            ->orderBy('a.city_nm', 'asc')
            ->get();

        $JobCategoryCount = DB::table('tbl_job as a')
            ->select('a.category_id', 'b.category_nm', DB::raw('COUNT(a.job_id) as TotalJob'))
            ->join('tbl_job_category as b', 'a.category_id', '=', 'b.category_id')
            ->where('a.status', 1)
            ->groupBy('a.category_id', 'b.category_nm')
            ->orderBy('b.category_nm', 'asc')
            ->get();

        $jobTypeCounts = DB::table('tbl_job_type as a')
            ->leftJoin('tbl_job as b', 'a.job_type_id', '=', 'b.job_type_id')
            ->select(
                'a.job_type_id',
                'a.type_name',
                DB::raw('COUNT(b.job_id) as total_jobs')
            )
            ->where('b.status', 1)
            ->groupBy('a.job_type_id', 'a.type_name')
            ->get();

        $jobLevelCounts = DB::table('tbl_job_level as a')
            ->leftJoin('tbl_job as b', 'a.job_level_id', '=', 'b.job_level_id')
            ->select(
                'a.job_level_id',
                'a.type_nm as job_level_name',
                DB::raw('COUNT(b.job_id) as total_jobs')
            )
            ->where('b.status', 1)
            ->groupBy('a.job_level_id', 'a.type_nm')
            ->get();

        $workTypeCounts = DB::table('tbl_work_type as a')
            ->leftJoin('tbl_job as b', 'a.work_type_id', '=', 'b.work_type_id')
            ->select(
                'a.work_type_id',
                'a.type_nm as work_type_name',
                DB::raw('COUNT(b.job_id) as total_jobs')
            )
            ->where('b.status', 1)
            ->groupBy('a.work_type_id', 'a.type_nm')
            ->get();

        // $experienceCounts = DB::table('tbl_experience_req as a')
        //     ->leftJoin('tbl_job as b', 'a.experience_req_id', '=', 'b.experience_req_id')
        //     ->select(
        //         'a.experience_req_id',
        //         'a.name as experience_name',
        //         DB::raw('COUNT(b.job_id) as total_jobs')
        //     )
        //     ->whereNull('a.deleted_at')
        //     ->whereNull('b.deleted_at')
        //     ->where('b.status', 1)
        //     ->groupBy('a.experience_req_id', 'a.name')
        //     ->get();
        $experienceCounts = DB::table('tbl_experience_req as a')
        ->leftJoin('tbl_job as b', function ($join) {
            $join->on('a.experience_req_id', '=', 'b.experience_req_id')
                ->whereNull('b.deleted_at')
                ->where('b.status', 1);
        })
        ->select(
            'a.experience_req_id',
            'a.name as experience_name',
            DB::raw('COUNT(b.job_id) as total_jobs')
        )
        ->whereNull('a.deleted_at')
        ->groupBy('a.experience_req_id', 'a.name')
        ->get();



        $jobpreferencetypeCounts = DB::table('tbl_job')
            ->selectRaw('
        COUNT(*) as total_jobs,
        COUNT(CASE WHEN preference_type = 1 THEN 1 END) as skilled_jobs,
        COUNT(CASE WHEN preference_type = 2 THEN 1 END) as non_skilled_jobs
    ')
            ->where('status', 1)
            ->first();

        $now = Carbon::now();

        // 1 day
        $oneDayCount = DB::table('tbl_job')
            ->where('created_at', '>=', $now->copy()->subDays(1))
            ->where('status',  1)
            ->count();

        // 7 days
        $sevenDaysCount = DB::table('tbl_job')
            ->where('created_at', '>=', $now->copy()->subDays(7))
            ->where('status',  1)
            ->count();

        // 30 days
        $thirtyDaysCount = DB::table('tbl_job')
            ->where('created_at', '>=', $now->copy()->subDays(30))
            ->where('status',  1)
            ->count();

        // All jobs
        $allJobCount = DB::table('tbl_job')->where('status', 1)->count();


        $Blog = Blog::where('status', 1)->get();
        $Setting = Setting::where('id', 1)->first();
        return view('website.jobs', compact('user', 'jobData', 'CategoryData', 'locations', 'JobCategoryCount', 'jobTypeCounts', 'jobLevelCounts', 'workTypeCounts', 'experienceCounts', 'oneDayCount', 'sevenDaysCount', 'thirtyDaysCount', 'allJobCount', 'Blog', 'Setting', 'jobpreferencetypeCounts'));
    }
    


    public function filter_job(Request $request)
    {
        $job_category = $request->input('job_category');
        $job_location = $request->input('job_location');
        $job_title = $request->input('job_title');
        $order_by = $request->input('order_by');
        $per_page = $request->input('per_page', 9); // default to 10
        $page = $request->input('page', 1);

        $category_id = $request->input('category_id');
        $job_type_id = $request->input('job_type_id');
        $job_level_id = $request->input('job_level_id');
        $work_type_id = $request->input('work_type_id');
        $experience_req_id = $request->input('experience_req_id');
        $job_posted_day = $request->input('job_posted_day');
        $preference_type = $request->input('preference_type');
        
        $orderBy_name = ($order_by === "Old") ? "asc" : "desc";

        try {
            $user = Auth::user();

            $cityState = City::where('city_id', $job_location)->first();
            $city_id = $cityState->city_id ?? '';
            $state_id = $cityState->state_id ?? '';

            $jobData = DB::table('tbl_job as a')
                ->select(
                    'a.*',
                    'b.category_nm',
                    'c.sub_category_nm',
                    'd.name as qualification_nm',
                    'e.type_nm as job_level_name',
                    'f.type_name as job_type_name',
                    'g.type_nm as work_type_name',
                    'h.name as experience_name',
                    'i.state_name',
                    'j.city_nm',
                    'k.area_nm',
                    'l.zipcode',
                    'm.name as user_name',
                    'm.profile_img'
                )
                ->join('tbl_job_category as b', 'a.category_id', '=', 'b.category_id')
                ->join('tbl_sub_category as c', 'a.sub_category_id', '=', 'c.sub_category_id')
                ->join('tbl_min_qualification as d', 'a.qualification_id', '=', 'd.qualification_id')
                ->join('tbl_job_level as e', 'a.job_level_id', '=', 'e.job_level_id')
                ->join('tbl_job_type as f', 'a.job_type_id', '=', 'f.job_type_id')
                ->join('tbl_work_type as g', 'a.work_type_id', '=', 'g.work_type_id')
                ->join('tbl_experience_req as h', 'a.experience_req_id', '=', 'h.experience_req_id')
                ->join('tbl_state as i', 'a.state_id', '=', 'i.state_id')
                // ->join('tbl_city as j', 'a.city_id', '=', 'j.city_id')
                // ->join('tbl_area as k', 'a.area_id', '=', 'k.area_id')
                // ->join('tbl_zipcode as l', 'a.zipcode_id', '=', 'l.zipcode_id')
                ->leftJoin('tbl_city as j', 'a.city_id', '=', 'j.city_id')
                ->leftJoin('tbl_area as k', 'a.area_id', '=', 'k.area_id')
                ->leftJoin('tbl_zipcode as l', 'a.zipcode_id', '=', 'l.zipcode_id')
                ->join('users as m', 'a.user_id', '=', 'm.id')
                // ->when($job_category, fn($q) => $q->orWhere('a.category_id', $job_category))
                ->when($job_category, fn($q) => $q->where('a.category_id', $job_category))
                // ->when($job_title, fn($q) => $q->orWhere('a.job_title', 'LIKE', '%' . $job_title . '%'))
                ->when($job_title, function($q) use ($job_title) {
                    $keywords = explode(' ', $job_title); // split by space

                    foreach ($keywords as $word) {
                        $q->where(function($sub) use ($word) {
                            $sub->where('a.job_title', 'LIKE', "%$word%")
                                ->orWhere('m.name', 'LIKE', "%$word%")      
                                ->orWhere('j.city_nm', 'LIKE', "%$word%")   
                                ->orWhere('i.state_name', 'LIKE', "%$word%")
                                ->orWhere('l.zipcode', 'LIKE', "%$word%")   
                                ->orWhere('l.zipcode_id', 'LIKE', "%$word%");
                        });
                    }

                })
                // ->when($city_id, fn($q) => $q->orWhere('a.city_id', $city_id))
                // ->when($city_id, fn($q) => $q->where('a.city_id', $city_id))
                ->when($city_id, function ($q) use ($city_id) {
                    $q->where(function ($sub) use ($city_id) {
                        $sub->where('a.city_id', $city_id)
                            ->orWhereNull('a.city_id'); // 🔥 NULL ALSO ALLOWED
                    });
                })


                ->when($category_id, fn($q) => $q->whereIn('a.category_id', (array) $category_id))
                ->when($job_type_id, fn($q) => $q->whereIn('a.job_type_id', (array) $job_type_id))
                ->when($job_level_id, fn($q) => $q->whereIn('a.job_level_id', (array) $job_level_id))
                ->when($work_type_id, fn($q) => $q->whereIn('a.work_type_id', (array) $work_type_id))
                ->when($experience_req_id, fn($q) => $q->whereIn('a.experience_req_id', (array) $experience_req_id))
                // ->when($job_posted_day, fn($q) => $q->whereDate('a.datetime', '>=', now()->subDays((int) $job_posted_day)))
                // ->when($job_posted_day, function ($q) use ($job_posted_day) {
                //     $q->where(function ($sub) use ($job_posted_day) {
                //         $sub->where('a.datetime', '>=', now()->subDays((int)$job_posted_day))
                //             ->orWhereNull('a.datetime'); // 🔥 NULL date ALSO INCLUDED
                //     });
                // })

                ->when($job_posted_day, function ($q) use ($job_posted_day) {

                    $daysArray = (array) $job_posted_day;

                    $q->where(function ($outer) use ($daysArray) {

                        foreach ($daysArray as $day) {
                            $outer->orWhere(function ($sub) use ($day) {
                                $sub->where('a.datetime', '>=', now()->subDays((int)$day));
                            });
                        }
                    });
                })

                ->when($preference_type, fn($q) => $q->whereIn('a.preference_type', (array) $preference_type))
                ->where('a.status', 1)
                ->orderBy('a.datetime', $orderBy_name)
                ->paginate($per_page, ['*'], 'page', $page);

            $setting = Setting::where('id', 1)->first();

            return response()->json([
                'status' => 1,
                'message' => 'Filtered jobs retrieved.',
                'data' => $jobData,
                'setting' => $setting,
                'user' => $user,
                'job_info' => [
                    'from' => $jobData->firstItem(),
                    'to' => $jobData->lastItem(),
                    'total' => $jobData->total(),
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong while filtering jobs.',
                'error' => $th->getMessage()
            ], 500);
        }
    }



    // Save Job
    public function save_job(Request $request)
    {
        $job_id = $request->input('job_id');
        $user_id = $request->input('user_id');

        // Validate inputs
        if (!$job_id || !$user_id) {
            return response()->json(['status' => 0, 'message' => 'Job ID and User ID are required.'], 200);
        }

        // Check if the job is already saved by the user
        $alreadySaved = DB::table('tbl_job_save')
            ->where('job_id', $job_id)
            ->where('user_id', $user_id)
            ->whereNull('deleted_at') // In case soft deletes are used
            ->exists();

        if ($alreadySaved) {
            return response()->json(['status' => 0, 'message' => 'Job already saved.'], 200);
        }

        // Save the job
        DB::table('tbl_job_save')->insert([
            'job_id'    => $job_id,
            'user_id'   => $user_id,
            'saved_at'  => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json(['status' => 1, 'message' => 'Job saved successfully.'], 200);
    }

    // Remove Job
    public function remove_save_job(Request $request)
    {
        $id = $request->input('id');

        try {
            $deleted = DB::table('tbl_job_save')->where('id', $id)->delete();

            if ($deleted) {
                return response()->json([
                    'status' => 1,
                    'message' => 'Job removed from saved list successfully.',
                ], 200);
            } else {
                return response()->json([
                    'status' => 1,
                    'message' => 'Job not found or already removed.',
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 200);
        }
    }


    public function apply_job(Request $request)
    {
        $request->validate([
            'resume'      => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'description' => 'nullable|string',
            'job_id'      => 'required|exists:tbl_job,job_id',
        ]);

        try {
            $job_id = $request->input('job_id');
            $user_id = $request->input('user_id');
            $upload_type = $request->input('upload_type');
            $selected_resume = $request->input('selected_resume');

            // ✅ Find job or fail
            $FindJob = Job::findOrFail($job_id);
            $FindUser = User::findOrFail($user_id);

            $existingApply = JobApply::where('job_id', $job_id)
                ->where('user_id', $user_id)
                ->first();

            if ($existingApply) {
                return response()->json([
                    'status'  => 0,
                    'message' => 'You have already applied for this job.',
                ]);
            }

            // $fileName = null;

            // // if ($upload_type === "Old") {
            // //     // ✅ Use existing resume
            // //     $resume = Resume::findOrFail($selected_resume);
            // //     $fileName = $resume->file_nm;
            // // }
            // if ($upload_type === "Old") {
            //     $resume = Resume::findOrFail($selected_resume);

            //     // 🔥 FORCE FULL PATH
            //     if (!str_contains($resume->file_nm, 'uploads/')) {
            //         $fileName = 'uploads/resume/' . basename($resume->file_nm);
            //     } else {
            //         $fileName = $resume->file_nm;
            //     }
            // }  else {
            //     if ($request->hasFile('resume')) {
            //         $file = $request->file('resume');

            //         $username  = Str::slug($FindUser->name);
            //         $extension = $file->getClientOriginalExtension();
            //         $fileName  = $username . '_' . uniqid() . '_resume.' . $extension;

            //         // if ($request->hasFile('resume')) {

            //         //     $file = $request->file('resume');

            //         //     $filename = Str::slug($FindUser->name) . '_' . uniqid() . '_resume.' . $file->getClientOriginalExtension();

            //         //     // ✅ ONLY public/uploads/resume
            //         //     $file->move(public_path('uploads/resume'), $filename);

            //         //     // ✅ DB ma ONLY aa path
            //         //     $fileName = 'uploads/resume/' . $filename;
            //         // }
            //         if ($request->hasFile('resume')) {

            //             $file = $request->file('resume');

            //             $filename = Str::slug($FindUser->name)
            //                     . '_' . uniqid()
            //                     . '_resume.'
            //                     . $file->getClientOriginalExtension();

            //             // ✅ direct PUBLIC folder
            //             $file->move(public_path('uploads/resume'), $filename);

            //             // ✅ DB ma aa j store
            //             $fileName = 'uploads/resume/' . $filename;
            //         }

            //         // ✅ Update user's resume
            //         if ($FindUser->resume_nm == null) {
            //             $FindUser->resume_nm = $fileName;
            //             $FindUser->save();
            //         }
            //     } 
            // }
            // else {
            //         return response()->json([
            //             'status'  => 0,
            //             'message' => 'Please upload a resume.',
            //         ]);
            //     }
            // $fileName = null;

            // /* =========================
            // 1️⃣ OLD RESUME SELECTED
            // ========================= */
            // if ($upload_type === "Old" && $selected_resume) {

            //     $resume = Resume::where('user_id', $FindUser->id)
            //                     ->findOrFail($selected_resume);

            //     // DB ma je path chhe e j use
            //     $fileName = $resume->file_nm;
            // }

            // /* =========================
            // 2️⃣ NEW RESUME UPLOAD
            // ========================= */
            // elseif ($upload_type === "New" && $request->hasFile('resume')) {

            //     $file = $request->file('resume');

            //     $filename = Str::slug($FindUser->name)
            //         . '_' . uniqid()
            //         . '_resume.'
            //         . $file->getClientOriginalExtension();

            //     // ✅ storage/app/public/resume
            //     $file->storeAs('public/resume', $filename);

            //     // ✅ DB friendly path
            //     $fileName = 'storage/resume/' . $filename;

            //     // Optional: user profile resume update
            //     if (empty($FindUser->resume_nm)) {
            //         $FindUser->resume_nm = $fileName;
            //         $FindUser->save();
            //     }
            // }

            // /* =========================
            // 3️⃣ NO RESUME CASE
            // ========================= */
            // else {
            //     return response()->json([
            //         'status'  => 0,
            //         'message' => 'Please select or upload a resume.',
            //     ]);
            // }
            $fileName = null;

            /* =========================
            1️⃣ OLD RESUME SELECTED
            ========================= */
            if ($upload_type === "Old" && $selected_resume) {

                $resume = Resume::where('user_id', $FindUser->id)
                                ->findOrFail($selected_resume);

                // ✅ DB ma only "resume/filename.pdf" hovu joiye
                $fileName = $resume->file_nm; 
            }

            /* =========================
            2️⃣ NEW RESUME UPLOAD
            ========================= */
            // elseif ($upload_type === "New" && $request->hasFile('resume')) {

            //     $file = $request->file('resume');

            //     $filename = Str::slug($FindUser->name)
            //         . '_' . uniqid()
            //         . '_resume.'
            //         . $file->getClientOriginalExtension();

            //     // ✅ ONLY storage/app/public/resumes
            //     $file->storeAs('public/resumes', $filename);

            //     // ✅ DB ma ONLY relative path
            //     $fileName = 'resumes/' . $filename;

            //     // optional user resume update
            //     if (empty($FindUser->resume_nm)) {
            //         $FindUser->resume_nm = $fileName;
            //         $FindUser->save();
            //     }
            // }
            elseif ($upload_type === "New" && $request->hasFile('resume')) {

                $file = $request->file('resume');

                $filename = Str::slug($FindUser->name)
                    . '_' . uniqid()
                    . '_resume.'
                    . $file->getClientOriginalExtension();

                // ✅ ONLY STORAGE
                $file->storeAs('public/resumes', $filename);

                // ✅ DB ma ONLY relative path
                $fileName = $filename;
            }


            /* =========================
            3️⃣ NO RESUME
            ========================= */
            else {
                return response()->json([
                    'status'  => 0,
                    'message' => 'Please select or upload a resume.',
                ]);
            }


            // ✅ Insert into tbl_job_apply
            $jobApply = JobApply::create([
                'user_id'    => auth()->id(),                 // Assuming user is logged in
                'job_id'     => $request->input('job_id'),
                'description' => $request->input('description'),
                'file_nm'    => $fileName,
                'status'     => 0,                            // Default: Pending
                'datetime'   => now(),
            ]);

            // ✅ Insert into tbl_job_apply_history
            JobApplyHistory::create([
                'user_id'      => auth()->id(),
                'job_id'       => $request->input('job_id'),
                'job_apply_id' => $jobApply->id,
                'msg'          => '',
                'datetime'     => now(),
            ]);


            // Get all job rounds for this job
            $jobround = JobRound::where('job_id', $job_id)->get();

            if ($jobround->isNotEmpty()) {
                foreach ($jobround as $round) {
                    JobRoundComplete::create([
                        "round_id"          => $round->id,
                        "user_id"           => auth()->id(),
                        "job_id"            => $job_id,
                        "hr_name"           => null,
                        "hr_contact_no"     => null,
                        "hr_email"          => null,
                        "interview_address" => null,
                        "datetime"          => null,
                        "complete_datetime" => null,
                        "status"            => 0,
                    ]);
                }
            }

            // ✅ Update total_apply in tbl_job
            $FindJob->total_apply = $FindJob->total_apply + 1;
            $FindJob->save();


            $company = User::find($FindJob->user_id);

            try {
                if ($company && $company->contact_no) {
                    WhatsappHelper::sendTemplate($company->contact_no, 'candidate_company_apply', [$FindUser->name, $FindJob->job_title]);
                }
            } catch (\Throwable $wh) {
                \Illuminate\Support\Facades\Log::warning('WhatsApp notification failed on job apply', [
                    'job_id'  => $job_id,
                    'user_id' => $user_id,
                    'error'   => $wh->getMessage(),
                ]);
            }

            return response()->json([
                'status' => 1,
                'message' => 'Job application submitted successfully.',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong while applying for the job.',
                'error' => $th->getMessage(), // ✅ Add this line
            ], 500);
        }
    }

    public function create_resume_action(Request $request)
    {
        $row_id      = $request->input('row_id');
        $user_id     = $request->input('user_id');
        $image       = $request->input('image'); // base64 image
        $full_name   = $request->input('full_name');
        $designation = $request->input('designation');
        $email       = $request->input('email');
        $phone       = $request->input('phone');
        $skills      = $request->input('skills');
        $summary     = $request->input('summary');
        $experience  = $request->input('experience');
        $education   = $request->input('education');
        $resumeHtml  = $request->input('resume'); // full resume HTML


          $dob  = $request->input('dob'); // full resume HTML
         $marital_status  = $request->input('marital_status'); // full resume HTML
          $address  = $request->input('address'); // full resume HTML
          $language_known  = $request->input('language_known'); // full resume HTML
         $gender  = $request->input('gender'); // full resume HTML
                  
        // 1. Validate user exists
        $user = User::find($user_id);
        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'User not found.'
            ], 200);
        }

        // 2. Generate PDF from HTML
        if (empty($resumeHtml)) {
            return response()->json([
                'status' => 0,
                'message' => 'Resume HTML is empty.'
            ], 200);
        }

        if (!empty($image)) {
            $imageData = base64_decode($image);
            // $imgFolder = public_path('uploads/resume_profile');
            $imgFolder = storage_path('app/public/resume_profile');

            if (!File::exists($imgFolder)) {
                File::makeDirectory($imgFolder, 0755, true);
            }

            $imgFilename = 'resume_profile_' . time() . '_' . Str::random(5) . '.webp';
            $imgPath = $imgFolder . '/' . $imgFilename;
            File::put($imgPath, $imageData);

            $relativeImgPath = 'resume_profile/' . $imgFilename;
        }


        $data = [
            'profile'        => $relativeImgPath,
            'name'        => $full_name,
            'designation' => $designation,
            'email'       => $email,
            'phone'       => $phone,
            'summary'     => $summary,
            'experience'  => $experience,
            'education'   => $education,
            'skills'      => explode(",", $skills),
            'dob'=>$dob,
            'marital_status'=>$marital_status,
            'address'=>$address,
            'language_known'=>$language_known,
            'gender'=>$gender
        ];


        $pdf = Pdf::loadView('website.layout.resume-pdf', $data)
            ->setPaper('a4', 'portrait') // Use 'portrait' or 'landscape'
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'isRemoteEnabled' => true,
                'dpi' => 150,
                'defaultFont' => 'DejaVu Sans'
        ]);


        // $pdf = Pdf::loadHTML($resumeHtml);
        $username = Str::slug($user->name);
        $filename = $username . '_' . uniqid() . '_resume.pdf';
        $pdfFolder = public_path('uploads/resume');

        if (!File::exists($pdfFolder)) {
            File::makeDirectory($pdfFolder, 0755, true);
        }

        $pdfPath = $pdfFolder . '/' . $filename;

        // $pdf->save(storage_path('app/public/resumes/' . $filename));
        // $pdf->save(public_path('uploads/resume/' . $filename));
        $pdf->save(storage_path('app/public/resumes/' . $filename));
        // $pdf->save($pdfPath);

        // 3. Save base64 image
        $relativeImgPath = null;


        // 4. Store in tbl_resume (update if exists)
        $resumeData = [
            // 'file_nm'     => 'resumes/' . $filename,
            // 'file_nm'     => 'uploads/resume/' . $filename,
            'file_nm' => $filename,
            'resume_type' => 2
        ];

        $resumeRecord = Resume::updateOrCreate(
            [
                'user_id'     => $user_id,
                'resume_type' => 2
            ],
            $resumeData
        );

        // 5. Store in tbl_resume_builder (update if exists)
        $builderData = [
            'user_id'     => $user_id,
            'resume_id'   => $resumeRecord->resume_id,
            'profile_img' => $relativeImgPath,
            'full_name'   => $full_name,
            'email'       => $email,
            'phone'       => $phone,
            'skills'      => $skills,
            'designation' => $designation,
            'summary'     => $summary,
            'experience'  => $experience,
            'education'   => $education,
            'dob'=>$dob,
            'marital_status'=>$marital_status,
            'address'=>$address,
            'language_known'=>$language_known,
            'gender'=>$gender
        ];

        ResumeBuilder::updateOrCreate(
            ['resume_id' => $resumeRecord->resume_id], // avoid using row_id
            $builderData
        );

        return response()->json([
            'status' => 1,
            'message' => 'Resume created and saved successfully.',
            'file'    => asset('uploads/resume/' . $filename)
        ]);
    }
    
    
    public function frontPlan(){
        
        $pricing = PlanPricing::where('plan_for', 'Employee')->get();
        
         $pricingCompany= PlanPricing::where('plan_for', 'Company')->get();
        
        return view('website.frontplan',compact('pricing','pricingCompany'));
    }

    public function getCategoriesByPreference(Request $request)
    {
        $preferenceType = $request->preference_type;
        
        $categories = JobCategory::where('preference_type', $preferenceType)
                                ->whereNull('deleted_at')
                                ->orderBy('category_nm', 'asc')  
                                ->get();
        
        return response()->json([
            'status' => 1,
            'data' => $categories
        ]);
    }

    public function skillthon(){
        return view('website.skillthon');
    }

    public function skillthonStore(Request $request)
    {
        DB::table('tbl_registrations')->insert([
            'type'       => 1,
            'name'       => $request->name,
            'email'      => $request->email,
            'phone_no'   => $request->phone_no,
            'city'       => $request->city,
            'pincode'    => $request->pincode,
            'university' => $request->university,
            'college'    => $request->college,
            'degree'     => $request->degree,
            'gender'     => $request->gender,
            'created_at'=> now()
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Skillthon Registration Done'
        ]);
    }




    public function internshipStore(Request $request)
    {
        DB::table('tbl_registrations')->insert([
            'type'       => 2,
            'name'       => $request->name,
            'email'      => $request->email,
            'phone_no'   => $request->phone_no,
            'city'       => $request->city,
            'pincode'    => $request->pincode,
            'university' => $request->university,
            'college'    => $request->college,
            'degree'     => $request->degree,
            'gender'     => $request->gender,
            'created_at'=> now()
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Internship Registration Done'
        ]);
    }

}
