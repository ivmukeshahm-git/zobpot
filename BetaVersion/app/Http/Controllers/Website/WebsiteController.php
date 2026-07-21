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
use App\Models\Registration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Barryvdh\DomPDF\Facade\Pdf;


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
            ])
            ->leftJoin('tbl_work_type', 'tbl_work_type.work_type_id', '=', 'tbl_job.work_type_id')
            ->whereNull('tbl_job.deleted_at') // ✅ Correct way to check for null
            ->where('tbl_job.status', 1) // only active jobs
            ->orderBy('tbl_job.datetime', 'desc')
            ->limit(8)
            ->get(); // 👈 Change 6 to how many per page

        $today = Carbon::today();
        $adBanner = AdBanner::where('page_nm', 1)->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)->first();
        return view('website.index', compact('CategoryData', 'JobCategoryData', 'Joblocations', 'Achievement', 'Blog', 'About', 'jobData', 'adBanner'));
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
            ->orderBy('ph.id', 'desc')
            ->first();

        $now = Carbon::now();

        // ❌ No plan found
        if (!$planData) {
            User::where('id', $user->id)->update(['active_plan_id' => 0]);
            return redirect()->route('pricing', $user->id);
        }

        $expireDate = Carbon::parse($planData->expire_date);

        // ❌ Plan expired
        if ($now->gt($expireDate)) {
            User::where('id', $user->id)->update(['active_plan_id' => 0]);
            return redirect()->route('pricing', $user->id);
        }

        // ✅ Plan valid → allow access
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
            ->select([
                'a.*',
                'b.plan_name',
                'b.plan_price',
                DB::raw("CASE WHEN a.plan_id = c.active_plan_id THEN 'Active' ELSE 'Expired' END as status")
            ])->orderBy('a.id', 'DESC')
            ->get();
        // dd($PlanHistoryData);

        return view('website.company-profile', compact(
            'states', 'userData', 'CategoryData', 'MinqualificationData', 
            'JoblevelData', 'JobtypeData', 'WorktypeData', 'ExperiencereqData', 
            'JobData', 'Setting', 'PlanHistoryData', 'filter'
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
            return view('website.candidate-profile', compact('states', 'userData', 'CategoryData', 'WorktypeData', 'JobtypeData', 'WorkExperienceData', 'EducationData', 'SaveJobData', 'MyjobData', 'Setting', 'PlanHistoryData', 'Resume', 'Resumes', 'experience'));
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
        $user_id = "";

        if ($user) {
            $this->planValidityCheck($user);
            $user_id = $user->id;
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

        $Resume = Resume::where('resume_type', 1)
            ->where('user_id', $user_id)
            ->first();

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
        $preference_type    = $request->input('preference_type', []);
        $experience         = $request->input('experience', []);
        $candidate_location = $request->input('candidate_location');
        $candidate_title    = $request->input('candidate_title');

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


        $allCompanyCount = DB::table('users')->where('role', 'User')->where('profile_type', 'Company')->where('active_status', 1)->count();
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
        $job_category      = $request->category_id;
        $job_location      = $request->job_location;
        $job_title         = $request->job_title;
        $order_by          = $request->order_by;
        $per_page          = $request->per_page ?? 12;

        $job_type_id       = $request->job_type_id;
        $job_level_id      = $request->job_level_id;
        $work_type_id      = $request->work_type_id;
        $experience_req_id = $request->experience_req_id;

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
            // $query->whereIn('tbl_job.category_id', (array)$job_category);
            $query->whereIn('users.category_id', (array)$job_category);
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
    $fileName = 'resumes/' . $filename;
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

            WhatsappHelper::sendTemplate($company->contact_no, 'candidate_company_apply', [$FindUser->name,$FindJob->job_title]);

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



    public function internship(){
        return view('website.internship');
    }

    public function internshipDetail(){
        return view('website.internship-detail');
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

    /**
     * Display internship application history page
     */
    public function internshipApplicationHistory()
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your internship applications');
        }

        $user = Auth::user();
        
        // In production, fetch actual internship applications from database
        // $applications = DB::table('internship_applications')
        //     ->where('user_id', $user->id)
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        return view('website.internship-application-history');
    }

}
