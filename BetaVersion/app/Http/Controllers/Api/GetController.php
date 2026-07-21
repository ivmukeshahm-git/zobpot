<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GetController extends Controller
{
    public function getUserDetails(Request $request, $user_id)
    {
        $jobId = $request->job_id; // optional parameter

        // Step 1: Get user data
        $user = DB::table("users")
            ->where("id", $user_id)
            ->first();

        if (!$user) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "User not found",
                ],
                404
            );
        }

        $userArray = (array) $user;

        // Step 2: Add location details
        $userArray["state_name"] = DB::table("tbl_state")
            ->where("state_id", $user->state_id)
            ->value("state_name");
        $userArray["city_name"] = DB::table("tbl_city")
            ->where("city_id", $user->city_id)
            ->value("city_nm");
        $userArray["zipcode"] = DB::table("tbl_zipcode")
            ->where("zipcode_id", $user->zipcode_id)
            ->value("zipcode");
        $userArray["area_name"] = DB::table("tbl_area")
            ->where("area_id", $user->area_id)
            ->value("area_nm");

        // Step 3: Category & subcategory
        $userArray["category_name"] = DB::table("tbl_job_category")
            ->where("category_id", $user->category_id)
            ->value("category_nm");
        $userArray["sub_category_name"] = DB::table("tbl_sub_category")
            ->where("sub_category_id", $user->sub_category_id)
            ->value("sub_category_nm");

        // Step 4: Skills
        $skills = DB::table("tbl_skills")
            ->whereNull("deleted_at")
            ->where("category_id", $user->category_id)
            ->where("sub_category_id", $user->sub_category_id)
            ->pluck("skill_nm");
        $userArray["skill_nm"] = $skills->implode(",");

        // Step 5: Education
        $userArray["education"] = DB::table("tbl_education")
            ->where("user_id", $user_id)
            ->whereNull("deleted_at")
            ->get();

        // Step 6: Work Experience
        $userArray["work_experience"] = DB::table("tbl_work_experience")
            ->where("user_id", $user_id)
            ->whereNull("deleted_at")
            ->get();

        // Step 7: Resume(s)
        if ($jobId) {
            // fetch file_nm (resume file) from tbl_job_apply for given job & user
            $resumeFile = DB::table("tbl_job_apply")
                ->where("user_id", $user_id)
                ->where("job_id", $jobId)
                ->value("file_nm");

            if ($resumeFile) {
                // directly return the resume file used for that application
                $userArray["resumes"] = [
                    [
                        "file_nm" => $resumeFile,
                    ],
                ];
            } else {
                $userArray["resumes"] = [];
            }
        } else {
            // no job id → return all current resumes from tbl_resume
            $userArray["resumes"] = DB::table("tbl_resume")
                ->where("user_id", $user_id)
                ->get();
        }

        // Step 8: Saved Jobs
        $savedJobs = DB::table("tbl_job_save as js")
            ->join("tbl_job as j", "js.job_id", "=", "j.job_id")
            ->leftJoin(
                "tbl_job_category as c",
                "j.category_id",
                "=",
                "c.category_id"
            )
            ->leftJoin(
                "tbl_sub_category as sc",
                "j.sub_category_id",
                "=",
                "sc.sub_category_id"
            )
            ->leftJoin(
                "tbl_min_qualification as q",
                "j.qualification_id",
                "=",
                "q.qualification_id"
            )
            ->leftJoin(
                "tbl_job_level as jl",
                "j.job_level_id",
                "=",
                "jl.job_level_id"
            )
            ->leftJoin(
                "tbl_job_type as jt",
                "j.job_type_id",
                "=",
                "jt.job_type_id"
            )
            ->leftJoin(
                "tbl_work_type as wt",
                "j.work_type_id",
                "=",
                "wt.work_type_id"
            )
            ->leftJoin(
                "tbl_experience_req as er",
                "j.experience_req_id",
                "=",
                "er.experience_req_id"
            )
            ->leftJoin("tbl_state as s", "j.state_id", "=", "s.state_id")
            ->leftJoin("tbl_city as ci", "j.city_id", "=", "ci.city_id")
            ->leftJoin("tbl_area as a", "j.area_id", "=", "a.area_id")
            ->leftJoin("tbl_zipcode as z", "j.zipcode_id", "=", "z.zipcode_id")
            ->where("js.user_id", $user_id)
            ->whereNull("js.deleted_at")
            ->whereNull("j.deleted_at")
            ->where("j.status", 1)
            ->orderByDesc("j.created_at")
            ->get();
        $userArray["saved_jobs"] = $savedJobs;
        $userArray["saved_jobs_count"] = $savedJobs->count();

        // Step 9: Applied Jobs
        $appliedJobs = DB::table("tbl_job_apply as ja")
            ->join("tbl_job as j", "ja.job_id", "=", "j.job_id")
            ->leftJoin(
                "tbl_job_category as c",
                "j.category_id",
                "=",
                "c.category_id"
            )
            ->leftJoin(
                "tbl_sub_category as sc",
                "j.sub_category_id",
                "=",
                "sc.sub_category_id"
            )
            ->leftJoin(
                "tbl_min_qualification as q",
                "j.qualification_id",
                "=",
                "q.qualification_id"
            )
            ->leftJoin(
                "tbl_job_level as jl",
                "j.job_level_id",
                "=",
                "jl.job_level_id"
            )
            ->leftJoin(
                "tbl_job_type as jt",
                "j.job_type_id",
                "=",
                "jt.job_type_id"
            )
            ->leftJoin(
                "tbl_work_type as wt",
                "j.work_type_id",
                "=",
                "wt.work_type_id"
            )
            ->leftJoin(
                "tbl_experience_req as er",
                "j.experience_req_id",
                "=",
                "er.experience_req_id"
            )
            ->leftJoin("tbl_state as s", "j.state_id", "=", "s.state_id")
            ->leftJoin("tbl_city as ci", "j.city_id", "=", "ci.city_id")
            ->leftJoin("tbl_area as a", "j.area_id", "=", "a.area_id")
            ->leftJoin("tbl_zipcode as z", "j.zipcode_id", "=", "z.zipcode_id")
            ->where("ja.user_id", $user_id)
            ->whereNull("ja.deleted_at")
            ->whereNull("j.deleted_at")
            ->where("j.status", 1)
            ->orderByDesc("j.created_at")
            ->get();
        $userArray["applied_jobs"] = $appliedJobs;
        $userArray["applied_jobs_count"] = $appliedJobs->count();

        // Final response
        return response()->json([
            "status" => true,
            "message" => "User data fetched successfully",
            "user" => $userArray,
        ]);
    }

    public function getAllCategories(Request $request)
    {
        $preferenceType = $request->query("preference_type"); // Get from query string

        // ─────────────── Query builder for categories ───────────────
        $query = DB::table("tbl_job_category as c")
            ->whereNull("c.deleted_at")
            ->orderBy("c.category_nm", "asc")
            ->select(
                "c.*",
                DB::raw(
                    "(SELECT COUNT(*) FROM tbl_job j WHERE j.category_id = c.category_id AND j.status = 1) as active_jobs_count"
                )
            );

        // If preference_type is provided (1 or 2), filter accordingly
        if (in_array($preferenceType, ["1", "2"])) {
            $categories = $query
                ->where("c.preference_type", $preferenceType)
                ->get();

            $typeText = $preferenceType == "1" ? "Skilled" : "Non-Skilled";

            return response()->json([
                "status" => true,
                "message" => "$typeText job categories fetched successfully.",
                "data" => $categories,
            ]);
        }

        // If no preference_type is passed → return all categories
        $allCategories = $query->get();

        return response()->json([
            "status" => true,
            "message" => "All job categories fetched successfully.",
            "data" => $allCategories,
        ]);
    }

    public function getByCategory($category_id)
    {
        $subCategories = DB::table("tbl_sub_category")
            ->where("category_id", $category_id)
            ->whereNull("deleted_at")
            ->orderBy("sub_category_nm", "asc")
            ->select(
                "sub_category_id",
                "category_id",
                "sub_category_nm",
                "created_at",
                "updated_at"
            )
            ->get();

        if ($subCategories->isEmpty()) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "No sub-categories found for this category.",
                    "data" => [],
                ],
                404
            );
        }

        return response()->json([
            "status" => true,
            "message" => "Sub-categories fetched successfully.",
            "data" => $subCategories,
        ]);
    }

    public function getSkills(Request $request)
    {
        $category_id = $request->input("category_id");
        $sub_category_id = $request->input("sub_category_id");

        $query = DB::table("tbl_skills")
            ->whereNull("deleted_at")
            ->select("skill_nm");

        // Apply conditions as per logic
        if ($category_id && !$sub_category_id) {
            $query->where("category_id", $category_id);
        } elseif (!$category_id && $sub_category_id) {
            $query->where("sub_category_id", $sub_category_id);
        } elseif ($category_id && $sub_category_id) {
            $query
                ->where("category_id", $category_id)
                ->where("sub_category_id", $sub_category_id);
        }

        $skillsData = $query->orderBy("category_id", "asc")->get();

        if ($skillsData->isEmpty()) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "No skills found.",
                    "data" => [],
                ],
                404
            );
        }

        // Convert comma-separated skill_nm to unique skill list
        $skillsList = [];
        foreach ($skillsData as $row) {
            $skills = explode(",", $row->skill_nm);
            foreach ($skills as $skill) {
                $trimmed = trim($skill);
                if (!in_array($trimmed, $skillsList)) {
                    $skillsList[] = $trimmed;
                }
            }
        }

        return response()->json([
            "status" => true,
            "message" => "Skills fetched successfully.",
            "data" => $skillsList,
        ]);
    }

    public function getWorkTypes()
    {
        $workTypes = DB::table("tbl_work_type")
            ->whereNull("deleted_at")
            ->select("work_type_id", "type_nm", "created_at", "updated_at")
            // ->orderBy('type_nm', 'asc')
            ->get();

        if ($workTypes->isEmpty()) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "No work types found.",
                    "data" => [],
                ],
                404
            );
        }

        return response()->json([
            "status" => true,
            "message" => "Work types fetched successfully.",
            "data" => $workTypes,
        ]);
    }

    public function getJobTypes()
    {
        $jobTypes = DB::table("tbl_job_type")
            ->select("job_type_id", "type_name")
            ->whereNull("deleted_at")
            ->orderBy("type_name", "asc")
            ->get();

        return response()->json(
            [
                "status" => true,
                "message" => "Job types fetched successfully",
                "data" => $jobTypes,
            ],
            200
        );
    }
    
    public function getAllJobTitles(Request $request)
{
    // ─────────────── Query builder for job titles ───────────────
    $jobTitles = DB::table("tbl_job_title")
        ->whereNull("deleted_at")          // Exclude deleted records
        ->orderBy("title_name", "asc")     // Sort alphabetically
        ->select(
            "id",
            "title_name",
            "created_at",
            "updated_at"
        )
        ->get();

    return response()->json([
        "status" => true,
        "message" => "Job titles fetched successfully.",
        "data" => $jobTitles,
    ]);
}

    public function addOrUpdateExperience(Request $request)
    {
        $request->validate([
            "id" => "nullable|exists:tbl_work_experience,id",
            "title" => "required",
            "work_type_id" => "required",
            "user_id" => "required|exists:users,id",
            "company" => "required",
            "working_status" => "required",
            "start_date" => "required",
            "end_date" => "nullable",
            "location" => "required",
            "job_type_id" => "required",
            "role_responsibility" => "nullable",
        ]);

        $data = [
            "title" => $request->title,
            "work_type_id" => $request->work_type_id,
            "user_id" => $request->user_id,
            "company" => $request->company,
            "working_status" => $request->working_status,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "location" => $request->location,
            "job_type_id" => $request->job_type_id,
            "role_responsibility" => $request->role_responsibility,
            "updated_at" => now(),
        ];

        if ($request->id) {
            // Update existing
            DB::table("tbl_work_experience")
                ->where("id", $request->id)
                ->update($data);

            $experience = DB::table("tbl_work_experience")
                ->where("id", $request->id)
                ->first();

            return response()->json(
                [
                    "status" => true,
                    "message" => "Experience updated successfully",
                    "data" => $experience,
                ],
                200
            );
        } else {
            // Insert new
            $data["created_at"] = now();
            $id = DB::table("tbl_work_experience")->insertGetId($data);
            $experience = DB::table("tbl_work_experience")
                ->where("id", $id)
                ->first();

            return response()->json(
                [
                    "status" => true,
                    "message" => "Experience added successfully",
                    "data" => $experience,
                ],
                201
            );
        }
    }

    public function getHomeScreenData(Request $request)
    {
        $userId = $request->user_id;

        if (!$userId) {
            return response()->json([
                "status" => 400,
                "msg" => "user_id is required",
            ]);
        }

        // ✅ Step 1: Get valid saved jobs (saved_at is not null, deleted_at is null)
        $savedJobs = DB::table("tbl_job_save")
            ->where("user_id", $userId)
            ->whereNotNull("saved_at")
            ->whereNull("deleted_at")
            ->pluck("job_id")
            ->toArray();

        // ✅ Step 1.1: Get applied job IDs by this user
        $appliedJobs = DB::table("tbl_job_apply")
            ->where("user_id", $userId)
            ->pluck("job_id")
            ->toArray();

        // ✅ Step 2: Fetch Active Job Categories
        $categories = DB::table("tbl_job_category")
            ->whereNull("deleted_at")
            ->select("category_id", "category_nm", "image")
            ->orderBy("category_nm")
            ->get();

        // ✅ Step 3: Fetch Recently Added Jobs
        $recentJobs = DB::table("tbl_job as j")
            ->leftJoin(
                "tbl_job_category as c",
                "j.category_id",
                "=",
                "c.category_id"
            )
            ->leftJoin(
                "tbl_sub_category as sc",
                "j.sub_category_id",
                "=",
                "sc.sub_category_id"
            )
            ->leftJoin(
                "tbl_min_qualification as q",
                "j.qualification_id",
                "=",
                "q.qualification_id"
            )
            ->leftJoin(
                "tbl_job_level as jl",
                "j.job_level_id",
                "=",
                "jl.job_level_id"
            )
            ->leftJoin(
                "tbl_job_type as jt",
                "j.job_type_id",
                "=",
                "jt.job_type_id"
            )
            ->leftJoin(
                "tbl_work_type as wt",
                "j.work_type_id",
                "=",
                "wt.work_type_id"
            )
            ->leftJoin(
                "tbl_experience_req as er",
                "j.experience_req_id",
                "=",
                "er.experience_req_id"
            )
            ->leftJoin("tbl_state as s", "j.state_id", "=", "s.state_id")
            ->leftJoin("tbl_city as ci", "j.city_id", "=", "ci.city_id")
            ->leftJoin("tbl_area as a", "j.area_id", "=", "a.area_id")
            ->leftJoin("tbl_zipcode as z", "j.zipcode_id", "=", "z.zipcode_id")
            ->select([
                "j.job_id",
                "j.user_id",
                "j.preference_type",
                "j.category_id",
                "c.category_nm",
                "j.sub_category_id",
                "j.salary_budget",
                "sc.sub_category_nm",
                "j.job_title",
                "j.qualification_id",
                "q.name as qualification_name",
                "j.job_level_id",
                "jl.type_nm as job_level_name",
                "j.job_type_id",
                "jt.type_name as job_type_name",
                "j.work_type_id",
                "wt.type_nm as work_type_name",
                "j.number_of_openings",
                "j.job_description",
                "j.interviewer_address",
                "j.experience_req_id",
                "er.name as experience_req_name",
                "j.contact_no",
                "j.company_website",
                "j.company_address",
                "j.state_id",
                "s.state_name",
                "j.city_id",
                "ci.city_nm",
                "j.area_id",
                "a.area_nm",
                "j.zipcode_id",
                "z.zipcode",
                "j.hr_email",
                "j.hr_contact_no",
                "j.skill_id",
                "j.datetime",
                "j.status",
                "j.total_apply",
                "j.remain_opening",
                "j.created_at",
                "j.updated_at",
            ])
            ->whereNull("j.deleted_at")
            ->where("j.status", 1)
            ->orderByDesc("j.created_at")
            ->take(4)
            ->get()
            ->map(function ($job) use ($savedJobs, $appliedJobs) {
                $job->saved = in_array($job->job_id, $savedJobs);
                $job->applied = in_array($job->job_id, $appliedJobs);
                return $job;
            });

        // ✅ Step 4: Fetch Most Applied Jobs of Last Month
        $lastMonth = now()->subMonth();

        $mostAppliedJobIds = DB::table("tbl_job_apply")
            ->select("job_id", DB::raw("COUNT(*) as apply_count"))
            ->where("created_at", ">=", $lastMonth)
            ->groupBy("job_id")
            ->orderByDesc("apply_count")
            ->take(4)
            ->pluck("job_id");

        $mostAppliedJobs = DB::table("tbl_job as j")
            ->leftJoin(
                "tbl_job_category as c",
                "j.category_id",
                "=",
                "c.category_id"
            )
            ->leftJoin(
                "tbl_sub_category as sc",
                "j.sub_category_id",
                "=",
                "sc.sub_category_id"
            )
            ->leftJoin(
                "tbl_min_qualification as q",
                "j.qualification_id",
                "=",
                "q.qualification_id"
            )
            ->leftJoin(
                "tbl_job_level as jl",
                "j.job_level_id",
                "=",
                "jl.job_level_id"
            )
            ->leftJoin(
                "tbl_job_type as jt",
                "j.job_type_id",
                "=",
                "jt.job_type_id"
            )
            ->leftJoin(
                "tbl_work_type as wt",
                "j.work_type_id",
                "=",
                "wt.work_type_id"
            )
            ->leftJoin(
                "tbl_experience_req as er",
                "j.experience_req_id",
                "=",
                "er.experience_req_id"
            )
            ->leftJoin("tbl_state as s", "j.state_id", "=", "s.state_id")
            ->leftJoin("tbl_city as ci", "j.city_id", "=", "ci.city_id")
            ->leftJoin("tbl_area as a", "j.area_id", "=", "a.area_id")
            ->leftJoin("tbl_zipcode as z", "j.zipcode_id", "=", "z.zipcode_id")
            ->select([
                "j.job_id",
                "j.user_id",
                "j.preference_type",
                "j.category_id",
                "c.category_nm",
                "j.sub_category_id",
                "j.salary_budget",
                "sc.sub_category_nm",
                "j.job_title",
                "j.qualification_id",
                "q.name as qualification_name",
                "j.job_level_id",
                "jl.type_nm as job_level_name",
                "j.job_type_id",
                "jt.type_name as job_type_name",
                "j.work_type_id",
                "wt.type_nm as work_type_name",
                "j.number_of_openings",
                "j.job_description",
                "j.interviewer_address",
                "j.experience_req_id",
                "er.name as experience_req_name",
                "j.contact_no",
                "j.company_website",
                "j.company_address",
                "j.state_id",
                "s.state_name",
                "j.city_id",
                "ci.city_nm",
                "j.area_id",
                "a.area_nm",
                "j.zipcode_id",
                "z.zipcode",
                "j.hr_email",
                "j.hr_contact_no",
                "j.skill_id",
                "j.datetime",
                "j.status",
                "j.total_apply",
                "j.remain_opening",
                "j.created_at",
                "j.updated_at",
            ])
            ->whereIn("j.job_id", $mostAppliedJobIds)
            ->whereNull("j.deleted_at")
            ->where("j.status", 1)
            ->orderByDesc("j.created_at")
            ->get()
            ->map(function ($job) use ($savedJobs, $appliedJobs) {
                $job->saved = in_array($job->job_id, $savedJobs);
                $job->applied = in_array($job->job_id, $appliedJobs);
                return $job;
            });

        // ✅ Step 5: Fetch Available Resumes for the User
        $resumes = DB::table("tbl_resume")
            ->where("user_id", $userId)
            // ->whereNull('deleted_at')
            ->get();

        // ✅ Step 6: Return the final response
        return response()->json([
            "status" => 200,
            "msg" => "Home Screen Data fetched successfully",
            "data" => [
                "categories" => $categories,
                "recent_jobs" => $recentJobs,
                "most_applied_jobs" => $mostAppliedJobs,
                "resumes" => $resumes,
            ],
        ]);
    }

    public function getJobsList(Request $request)
    {
        $request->validate([
            "user_id" => "nullable|exists:users,id", // make user_id optional
            "preference_type" => "nullable",
        ]);

        $userId = $request->user_id;
        $preferenceType = $request->preference_type;

        // ─────────── Saved & Applied Jobs IDs ───────────
        $savedJobs = [];
        $appliedJobs = [];

        if ($userId) {
            $savedJobs = DB::table("tbl_job_save")
                ->where("user_id", $userId)
                ->whereNotNull("saved_at")
                ->whereNull("deleted_at")
                ->pluck("job_id")
                ->toArray();

            $appliedJobs = DB::table("tbl_job_apply")
                ->where("user_id", $userId)
                ->pluck("job_id")
                ->toArray();
        }

        // ─────────── Base Select for Jobs ───────────
        $baseSelect = [
            "j.job_id",
            "j.user_id",
            "j.preference_type",
            "j.category_id",
            "c.category_nm",
            "j.sub_category_id",
            "j.salary_budget",
            "sc.sub_category_nm",
            "j.job_title",
            "j.qualification_id",
            "q.name as qualification_name",
            "j.job_level_id",
            "jl.type_nm as job_level_name",
            "j.job_type_id",
            "jt.type_name as job_type_name",
            "j.work_type_id",
            "wt.type_nm as work_type_name",
            "j.number_of_openings",
            "j.job_description",
            "j.interviewer_address",
            "j.experience_req_id",
            "er.name as experience_req_name",
            "j.contact_no",
            "j.company_website",
            "j.company_address",
            "j.state_id",
            "s.state_name",
            "j.city_id",
            "ci.city_nm",
            "j.area_id",
            "a.area_nm",
            "j.zipcode_id",
            "z.zipcode",
            "j.hr_email",
            "j.hr_contact_no",
            "j.skill_id",
            "j.datetime",
            "j.status",
            "j.total_apply",
            "j.remain_opening",
            "j.created_at",
            "j.updated_at",
        ];

        $baseJoins = function ($query) {
            $query
                ->leftJoin(
                    "tbl_job_category as c",
                    "j.category_id",
                    "=",
                    "c.category_id"
                )
                ->leftJoin(
                    "tbl_sub_category as sc",
                    "j.sub_category_id",
                    "=",
                    "sc.sub_category_id"
                )
                ->leftJoin(
                    "tbl_min_qualification as q",
                    "j.qualification_id",
                    "=",
                    "q.qualification_id"
                )
                ->leftJoin(
                    "tbl_job_level as jl",
                    "j.job_level_id",
                    "=",
                    "jl.job_level_id"
                )
                ->leftJoin(
                    "tbl_job_type as jt",
                    "j.job_type_id",
                    "=",
                    "jt.job_type_id"
                )
                ->leftJoin(
                    "tbl_work_type as wt",
                    "j.work_type_id",
                    "=",
                    "wt.work_type_id"
                )
                ->leftJoin(
                    "tbl_experience_req as er",
                    "j.experience_req_id",
                    "=",
                    "er.experience_req_id"
                )
                ->leftJoin("tbl_state as s", "j.state_id", "=", "s.state_id")
                ->leftJoin("tbl_city as ci", "j.city_id", "=", "ci.city_id")
                ->leftJoin("tbl_area as a", "j.area_id", "=", "a.area_id")
                ->leftJoin(
                    "tbl_zipcode as z",
                    "j.zipcode_id",
                    "=",
                    "z.zipcode"
                );
        };

        // ─────────── Recent Jobs Query ───────────
        $recentJobsQuery = DB::table("tbl_job as j")
            ->tap($baseJoins)
            ->select($baseSelect)
            ->whereNull("j.deleted_at")
            ->where("j.status", 1);

        if ($preferenceType) {
            $recentJobsQuery->where("j.preference_type", $preferenceType);
        }

        $recentJobs = $recentJobsQuery
            ->orderByDesc("j.created_at")
            ->take(10)
            ->get()
            ->map(function ($job) use ($savedJobs, $appliedJobs, $userId) {
                $job->saved = $userId
                    ? in_array($job->job_id, $savedJobs)
                    : false;
                $job->applied = $userId
                    ? in_array($job->job_id, $appliedJobs)
                    : false;
                return $job;
            });

        // ─────────── Popular Jobs Query ───────────
        $lastMonth = now()->subMonth();
        $mostAppliedJobIds = DB::table("tbl_job_apply")
            ->select("job_id", DB::raw("COUNT(*) as apply_count"))
            ->where("created_at", ">=", $lastMonth)
            ->groupBy("job_id")
            ->orderByDesc("apply_count")
            ->pluck("job_id");

        $popularJobsQuery = DB::table("tbl_job as j")
            ->tap($baseJoins)
            ->select($baseSelect)
            ->whereIn("j.job_id", $mostAppliedJobIds)
            ->whereNull("j.deleted_at")
            ->where("j.status", 1);

        if ($preferenceType) {
            $popularJobsQuery->where("j.preference_type", $preferenceType);
        }

        $popularJobs = $popularJobsQuery
            ->orderByDesc("j.created_at")
            ->get()
            ->map(function ($job) use ($savedJobs, $appliedJobs, $userId) {
                $job->saved = $userId
                    ? in_array($job->job_id, $savedJobs)
                    : false;
                $job->applied = $userId
                    ? in_array($job->job_id, $appliedJobs)
                    : false;
                return $job;
            });

        // ─────────── Response ───────────
        return response()->json([
            "status" => 200,
            "msg" => "Jobs fetched successfully",
            "data" => [
                "recent_jobs" => $recentJobs,
                "popular_jobs" => $popularJobs,
            ],
        ]);
    }

    public function getJobScreendata(Request $request)
    {
        $categoryId = $request->category_id;
        $userId = $request->user_id;

        // Step 1: Fetch the user to get active_plan_id
        $user = DB::table("users")
            ->where("id", $userId)
            ->first();
        $activePlanId = $user->active_plan_id ?? null;

        // Step 2: Decide whether to show company details
        $showCompanyDetails = true;

        if (is_null($activePlanId) || $activePlanId == 0) {
            // Get setting value
            $setting = DB::table("tbl_setting")->first();
            $showCompanySetting = $setting->ShowCompanyDetails ?? 1;

            if ($showCompanySetting == 2) {
                $showCompanyDetails = false;
            }
        }

        // ✅ Fetch saved job entries
        $savedJobs = DB::table("tbl_job_save")
            ->where("user_id", $userId)
            ->whereNotNull("saved_at")
            ->whereNull("deleted_at")
            ->pluck("job_id")
            ->toArray();

        // ✅ Fetch applied job entries
        $appliedJobs = DB::table("tbl_job_apply")
            ->where("user_id", $userId)
            ->pluck("job_id")
            ->toArray();

        // Base jobs query
        $jobsQuery = DB::table("tbl_job as j")
            ->leftJoin(
                "tbl_job_category as c",
                "j.category_id",
                "=",
                "c.category_id"
            )
            ->leftJoin(
                "tbl_sub_category as sc",
                "j.sub_category_id",
                "=",
                "sc.sub_category_id"
            )
            ->leftJoin(
                "tbl_min_qualification as q",
                "j.qualification_id",
                "=",
                "q.qualification_id"
            )
            ->leftJoin(
                "tbl_job_level as jl",
                "j.job_level_id",
                "=",
                "jl.job_level_id"
            )
            ->leftJoin(
                "tbl_job_type as jt",
                "j.job_type_id",
                "=",
                "jt.job_type_id"
            )
            ->leftJoin(
                "tbl_work_type as wt",
                "j.work_type_id",
                "=",
                "wt.work_type_id"
            )
            ->leftJoin(
                "tbl_experience_req as er",
                "j.experience_req_id",
                "=",
                "er.experience_req_id"
            )
            ->leftJoin("tbl_state as s", "j.state_id", "=", "s.state_id")
            ->leftJoin("tbl_city as ci", "j.city_id", "=", "ci.city_id")
            ->leftJoin("tbl_area as a", "j.area_id", "=", "a.area_id")
            ->leftJoin("tbl_zipcode as z", "j.zipcode_id", "=", "z.zipcode_id")
            ->select([
                "j.job_id",
                "j.user_id",
                "j.preference_type",
                "j.category_id",
                "c.category_nm",
                "j.salary_budget",
                "c.image as category_image",
                "j.sub_category_id",
                "sc.sub_category_nm",
                "j.job_title",
                "j.qualification_id",
                "q.name as qualification_name",
                "j.job_level_id",
                "jl.type_nm as job_level_name",
                "j.job_type_id",
                "jt.type_name as job_type_name",
                "j.work_type_id",
                "wt.type_nm as work_type_name",
                "j.number_of_openings",
                "j.job_description",
                "j.interviewer_address",
                "j.experience_req_id",
                "er.name as experience_req_name",
                "j.contact_no",
                "j.company_website",
                "j.company_address",
                "j.state_id",
                "s.state_name",
                "j.city_id",
                "ci.city_nm",
                "j.area_id",
                "a.area_nm",
                "j.zipcode_id",
                "z.zipcode",
                "j.hr_email",
                "j.hr_contact_no",
                "j.skill_id",
                "j.datetime",
                "j.status",
                "j.total_apply",
                "j.remain_opening",
                "j.created_at",
                "j.updated_at",
            ])
            ->whereNull("j.deleted_at")
            ->where("j.status", 1);

        if ($categoryId) {
            $jobsQuery->where("j.category_id", $categoryId);
        }

        // Fetch jobs and mark saved/applied flag + remove company details if needed
        $jobs = $jobsQuery
            ->orderByDesc("j.created_at")
            ->get()
            ->map(function ($job) use (
                $savedJobs,
                $appliedJobs,
                $showCompanyDetails
            ) {
                $job->saved = in_array($job->job_id, $savedJobs);
                $job->applied = in_array($job->job_id, $appliedJobs);

                if (!$showCompanyDetails) {
                    $job->contact_no = null;
                    $job->company_website = null;
                    $job->company_address = null;
                    $job->hr_email = null;
                    $job->hr_contact_no = null;
                }

                return $job;
            });

        // Fetch categories
        $categoriesQuery = DB::table("tbl_job_category")
            ->whereNull("deleted_at")
            ->orderBy("category_nm");

        if ($categoryId) {
            $categoriesQuery->where("category_id", $categoryId);
        }

        $categories = $categoriesQuery->get([
            "category_id",
            "category_nm",
            "image",
        ]);

        if ($categoryId) {
            $category = $categories->first();

            if (!$category) {
                return response()->json(
                    [
                        "status" => false,
                        "message" => "Invalid category_id provided",
                        "data" => null,
                    ],
                    404
                );
            }

            $jobsInCategory = $jobs
                ->where("category_id", $category->category_id)
                ->values();

            return response()->json(
                [
                    "status" => true,
                    "message" => "Category jobs fetched successfully",
                    "data" => [
                        "category_id" => $category->category_id,
                        "category_name" => $category->category_nm,
                        "category_image" => $category->image,
                        "jobs" => $jobsInCategory,
                    ],
                ],
                200
            );
        }

        // Group jobs by category
        $categoryWiseJobs = [];
        foreach ($categories as $category) {
            $jobsInCategory = $jobs
                ->where("category_id", $category->category_id)
                ->values();

            $categoryWiseJobs[] = [
                "category_id" => $category->category_id,
                "category_name" => $category->category_nm,
                "category_image" => $category->image,
                "jobs" => $jobsInCategory,
            ];
        }

        return response()->json(
            [
                "status" => true,
                "message" => "Jobs fetched successfully",
                "data" => [
                    "all_jobs" => $jobs->values(),
                    "category_wise_jobs" => $categoryWiseJobs,
                ],
            ],
            200
        );
    }

    public function getAllJobLevels()
    {
        $jobLevels = DB::table("tbl_job_level")
            ->whereNull("deleted_at")
            ->get();

        return response()->json([
            "status" => true,
            "message" => "Job levels fetched successfully",
            "data" => $jobLevels,
        ]);
    }

    public function removeWorkExperience(Request $request)
    {
        // Validate the request
        $request->validate([
            "user_id" => "required|exists:users,id",
            "work_experience_id" => "required|exists:tbl_work_experience,id",
        ]);

        // Soft delete by updating only the deleted_at column
        $updated = DB::table("tbl_work_experience")
            ->where("id", $request->work_experience_id)
            ->where("user_id", $request->user_id)
            ->whereNull("deleted_at") // ensure it's not already deleted
            ->update([
                "deleted_at" => now(),
            ]);

        // Check if update happened
        if ($updated) {
            return response()->json([
                "status" => true,
                "message" => "Work experience removed successfully.",
            ]);
        } else {
            return response()->json(
                [
                    "status" => false,
                    "message" =>
                        "Work experience not found or already deleted.",
                ],
                404
            );
        }
    }

    public function getMinQualificationList(Request $request)
    {
        $qualifications = DB::table("tbl_min_qualification")
            ->whereNull("deleted_at")
            ->select("qualification_id", "name")
            ->orderBy("name", "asc")
            ->get();

        return response()->json([
            "status" => true,
            "message" => "Minimum qualification list fetched successfully.",
            "data" => $qualifications,
        ]);
    }

    public function getExperienceList(Request $request)
    {
        $experiences = DB::table("tbl_experience_req")
            ->whereNull("deleted_at")
            ->select("experience_req_id", "name")
            ->orderBy("name", "asc")
            ->get();

        return response()->json([
            "status" => true,
            "message" => "Experience list fetched successfully.",
            "data" => $experiences,
        ]);
    }
}