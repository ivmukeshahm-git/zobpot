<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\WhatsappHelper;

class CompanyController extends Controller
{
    public function getMyUploadedJobs(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
        ]);

        $userId = $request->user_id;

        // Base query builder with application count
        $baseQuery = DB::table("tbl_job as j")
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
            ->leftJoin("tbl_job_apply as ja", "j.job_id", "=", "ja.job_id") // join with job_apply
            ->select([
                "j.job_id",
                "j.user_id",
                "j.preference_type",
                "j.category_id",
                "c.category_nm",
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
                DB::raw("COUNT(ja.user_id) as total_applied_count"), // count applied rows
            ])
            ->whereNull("j.deleted_at")
            ->where("j.user_id", $userId)
            ->groupBy(
                "j.job_id",
                "j.user_id",
                "j.preference_type",
                "j.category_id",
                "c.category_nm",
                "j.sub_category_id",
                "sc.sub_category_nm",
                "j.job_title",
                "j.qualification_id",
                "q.name",
                "j.job_level_id",
                "jl.type_nm",
                "j.job_type_id",
                "jt.type_name",
                "j.work_type_id",
                "wt.type_nm",
                "j.number_of_openings",
                "j.job_description",
                "j.interviewer_address",
                "j.experience_req_id",
                "er.name",
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
                "j.updated_at"
            );

        // Fetch job lists by status
        $activeJobs = (clone $baseQuery)
            ->where("j.status", 1)
            ->orderByDesc("j.created_at")
            ->get();
        $draftJobs = (clone $baseQuery)
            ->where("j.status", 0)
            ->orderByDesc("j.created_at")
            ->get();
        $inactiveJobs = (clone $baseQuery)
            ->where("j.status", 2)
            ->orderByDesc("j.created_at")
            ->get();

        return response()->json(
            [
                "status" => true,
                "message" => "Uploaded jobs fetched successfully",
                "active_jobs" => $activeJobs,
                "draft_jobs" => $draftJobs,
                "inactive_jobs" => $inactiveJobs,
            ],
            200
        );
    }

    public function searchAndFilterEmployeeList(Request $request)
    {
        // ──────────────────────── 1. Validation
        $request->validate([
            "search_flag" => "nullable|boolean",
            "search_value" => "nullable|string",
            "skills" => "nullable|array",
        ]);

        // ──────────────────────── 2. Base query
        $query = DB::table("users as u")
            ->leftJoin(
                "tbl_job_category as c",
                "u.category_id",
                "=",
                "c.category_id"
            )
            ->leftJoin(
                "tbl_sub_category as sc",
                "u.sub_category_id",
                "=",
                "sc.sub_category_id"
            )
            ->leftJoin("tbl_state as s", "u.state_id", "=", "s.state_id")
            ->leftJoin("tbl_city as ci", "u.city_id", "=", "ci.city_id")
            ->leftJoin("tbl_area as a", "u.area_id", "=", "a.area_id")
            ->leftJoin("tbl_zipcode as z", "u.zipcode_id", "=", "z.zipcode_id")
            ->select([
                "u.id",
                "u.name",
                "u.email",
                "u.contact_no",
                "u.preference_type", // 1 = Skilled, 2 = Non-Skilled
                "u.category_id",
                "c.category_nm",
                "u.sub_category_id",
                "sc.sub_category_nm",
                "u.skills_id",
                "u.designation",
                "u.about",
                "u.address",
                "u.state_id",
                "s.state_name",
                "u.city_id",
                "ci.city_nm",
                "u.area_id",
                "a.area_nm",
                "u.zipcode_id",
                "z.zipcode",
                "u.verify_status",
                "u.active_status",
                "u.resume_nm",
                "u.profile_img",
                "u.cover_img",
                "u.created_at",
                "u.updated_at",
            ])
            ->whereNull("u.deleted_at")
            ->where("u.profile_type", "Employee"); // only employees

        // ──────────────────────── 3. Search
        if (
            $request->boolean("search_flag") &&
            $request->filled("search_value")
        ) {
            $search = trim($request->input("search_value"));

            $query->where(function ($q) use ($search) {
                $fields = [
                    "u.name",
                    "u.email",
                    "u.contact_no",
                    "u.designation",
                    "u.about",
                    "u.address",
                    "u.skills_id",
                    "c.category_nm",
                    "sc.sub_category_nm",
                    "s.state_name",
                    "ci.city_nm",
                    "a.area_nm",
                    "z.zipcode",
                ];
                foreach ($fields as $field) {
                    $q->orWhere($field, "LIKE", "%{$search}%");
                }
            });
        }

        // ──────────────────────── 4. Filters
        $filterable = [
            "preference_type",
            "category_id",
            "sub_category_id",
            "state_id",
            "city_id",
            "area_id",
            "zipcode_id",
            "verify_status",
            "active_status",
        ];

        foreach ($filterable as $column) {
            if ($request->filled($column)) {
                $query->where("u.$column", $request->input($column));
            }
        }

        // ──────────────────────── 5. Skills array filter
        if ($request->filled("skills") && is_array($request->skills)) {
            $skills = $request->skills;
            $query->where(function ($q) use ($skills) {
                foreach ($skills as $skill) {
                    $q->orWhere("u.skills_id", "LIKE", "%{$skill}%");
                }
            });
        }

        // ──────────────────────── 6. Execute
        $employees = $query->orderByDesc("u.created_at")->get();

        return response()->json(
            [
                "status" => true,
                "message" => "Employee list fetched successfully",
                "data" => $employees,
            ],
            200
        );
    }

    public function getCompanyDetails($user_id)
    {
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

        // Step 5: Active, Closed, and Draft Jobs Posted by Company
        $jobBaseQuery = DB::table("tbl_job as j")
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
            ->where("j.user_id", $user_id)
            ->whereNull("j.deleted_at")
            ->select([
                "j.*",
                "c.category_nm",
                "sc.sub_category_nm",
                "q.name as qualification_name",
                "jl.type_nm as job_level_name",
                "jt.type_name as job_type_name",
                "wt.type_nm as work_type_name",
                "er.name as experience_req_name",
                "s.state_name",
                "ci.city_nm",
                "a.area_nm",
                "z.zipcode",
            ]);

        // Active Jobs → status = 1
        $activeJobs = (clone $jobBaseQuery)
            ->where("j.status", 1)
            ->orderByDesc("j.created_at")
            ->get();

        // Closed Jobs → status = 2
        $closedJobs = (clone $jobBaseQuery)
            ->where("j.status", 2)
            ->orderByDesc("j.created_at")
            ->get();

        // Draft Jobs → status = 0
        $draftJobs = (clone $jobBaseQuery)
            ->where("j.status", 0)
            ->orderByDesc("j.created_at")
            ->get();

        $userArray["active_jobs"] = $activeJobs;
        $userArray["active_jobs_count"] = $activeJobs->count();

        $userArray["closed_jobs"] = $closedJobs;
        $userArray["closed_jobs_count"] = $closedJobs->count();

        $userArray["draft_jobs"] = $draftJobs;
        $userArray["draft_jobs_count"] = $draftJobs->count();

        // Final response
        return response()->json([
            "status" => true,
            "message" => "Company details fetched successfully",
            "user" => $userArray,
        ]);
    }

    public function getJobDetailsWithApplications(Request $request)
    {
        $request->validate([
            "job_id" => "required|exists:tbl_job,job_id",
        ]);

        $jobId = $request->job_id;

        // 1. Get Job Details (no GROUP BY issues)
        $job = DB::table("tbl_job as j")
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
                "j.*",
                "c.category_nm as category_name",
                "sc.sub_category_nm as sub_category_name",
                "q.name as qualification_name",
                "jl.type_nm as job_level_name",
                "jt.type_name as job_type_name",
                "wt.type_nm as work_type_name",
                "er.name as experience_req_name",
                "s.state_name",
                "ci.city_nm as city_name",
                "a.area_nm as area_name",
                "z.zipcode",
            ])
            ->where("j.job_id", $jobId)
            ->first();

        if (!$job) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Job not found",
                ],
                404
            );
        }

        // ✅ Get total applied count separately (avoids GROUP BY error)
        $job->total_applied_count = DB::table("tbl_job_apply")
            ->where("job_id", $jobId)
            ->whereNull("deleted_at")
            ->count();

        // 2. Get Job Rounds
        $jobRounds = DB::table("tbl_job_round")
            ->where("job_id", $jobId)
            ->whereNull("deleted_at")
            ->orderBy("created_at")
            ->get(["id as round_id", "round_name", "created_at"]);

        // 3. Get Applied Users
        $appliedUsers = DB::table("tbl_job_apply as a")
            ->leftJoin("users as u", "a.user_id", "=", "u.id")
            ->where("a.job_id", $jobId)
            ->whereNull("a.deleted_at")
            ->select(
                "a.id as apply_id",
                "a.user_id",
                "a.created_at as applied_at",
                "a.status as job_apply_status",
                DB::raw("CASE 
                WHEN a.status = 0 THEN 'Pending' 
                WHEN a.status = 1 THEN 'Accepted' 
                WHEN a.status = 2 THEN 'Rejected' 
                WHEN a.status = 3 THEN 'Shortlisted' 
                WHEN a.status = 4 THEN 'Schedule Interview' 
                ELSE 'Unknown' END as job_apply_status_name"),
                "u.name",
                "u.email",
                "u.contact_no",
                "u.profile_img"
            )
            ->get();

        foreach ($appliedUsers as $user) {
            // Apply History
            $user->apply_history = DB::table("tbl_job_apply_history")
                ->where("user_id", $user->user_id)
                ->where("job_id", $jobId)
                ->whereNull("deleted_at")
                ->orderBy("created_at", "desc")
                ->get();

            // Round Completion Status
            $user->completed_rounds = $jobRounds->map(function ($round) use (
                $user,
                $jobId
            ) {
                $completed = DB::table("tbl_round_complete")
                    ->where("user_id", $user->user_id)
                    ->where("job_id", $jobId)
                    ->where("round_id", $round->round_id)
                    ->first();

                return (object) [
                    "round_id" => $round->round_id,
                    "round_name" => $round->round_name,
                    "is_completed" => $completed && $completed->status == 1,
                    "status" => $completed->status ?? 0,
                    "hr_name" => $completed->hr_name ?? null,
                    "hr_email" => $completed->hr_email ?? null,
                    "hr_contact_no" => $completed->hr_contact_no ?? null,
                    "interview_address" =>
                        $completed->interview_address ?? null,
                    "datetime" => $completed->datetime ?? null,
                    "complete_datetime" =>
                        $completed->complete_datetime ?? null,
                    "completed_at" => $completed->created_at ?? null,
                ];
            });
        }

        // 4. Response
        return response()->json([
            "status" => true,
            "message" =>
                "Job details and applied user data fetched successfully.",
            "data" => [
                "job" => $job,
                "job_rounds" => $jobRounds,
                "applied_users" => $appliedUsers,
            ],
        ]);
    }

    public function getAppliedUsersForJob(Request $request)
    {
        $request->validate([
            "job_id" => "required|exists:tbl_job,job_id",
        ]);

        $jobId = $request->job_id;

        // Check Job Exists
        $jobExists = DB::table("tbl_job")
            ->where("job_id", $jobId)
            ->exists();

        if (!$jobExists) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Job not found",
                ],
                404
            );
        }

        // 1. Fetch Job Rounds (needed for completion status)
        $jobRounds = DB::table("tbl_job_round")
            ->where("job_id", $jobId)
            ->whereNull("deleted_at")
            ->orderBy("created_at")
            ->get(["id as round_id", "round_name", "created_at"]);

        // 2. Fetch Applied Users
        $appliedUsers = DB::table("tbl_job_apply as a")
            ->leftJoin("users as u", "a.user_id", "=", "u.id")
            ->where("a.job_id", $jobId)
            ->whereNull("a.deleted_at")
            ->select(
                "a.id as apply_id",
                "a.user_id",
                "a.created_at as applied_at",
                "a.status as job_apply_status",
                DB::raw("CASE 
                WHEN a.status = 0 THEN 'Pending' 
                WHEN a.status = 1 THEN 'Accepted' 
                WHEN a.status = 2 THEN 'Rejected' 
                WHEN a.status = 3 THEN 'Shortlisted' 
                WHEN a.status = 4 THEN 'Schedule Interview' 
                ELSE 'Unknown' END as job_apply_status_name"),
                "u.name",
                "u.email",
                "u.contact_no",
                "u.profile_img"
            )
            ->get();

        foreach ($appliedUsers as $user) {
            // Apply History
            $user->apply_history = DB::table("tbl_job_apply_history")
                ->where("user_id", $user->user_id)
                ->where("job_id", $jobId)
                ->whereNull("deleted_at")
                ->orderBy("created_at", "desc")
                ->get();

            // Round Completion Status
            $user->completed_rounds = $jobRounds->map(function ($round) use (
                $user,
                $jobId
            ) {
                $completed = DB::table("tbl_round_complete")
                    ->where("user_id", $user->user_id)
                    ->where("job_id", $jobId)
                    ->where("round_id", $round->round_id)
                    ->first();

                return (object) [
                    "round_id" => $round->round_id,
                    "round_name" => $round->round_name,
                    "is_completed" => $completed && $completed->status == 1,
                    "status" => $completed->status ?? 0,
                    "hr_name" => $completed->hr_name ?? null,
                    "hr_email" => $completed->hr_email ?? null,
                    "hr_contact_no" => $completed->hr_contact_no ?? null,
                    "interview_address" =>
                        $completed->interview_address ?? null,
                    "datetime" => $completed->datetime ?? null,
                    "complete_datetime" =>
                        $completed->complete_datetime ?? null,
                    "completed_at" => $completed->created_at ?? null,
                ];
            });
        }

        // ✅ Response
        return response()->json([
            "status" => true,
            "message" => "Applied users fetched successfully.",
            "data" => $appliedUsers,
        ]);
    }

    public function markRoundComplete(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
            "job_id" => "required|exists:tbl_job,job_id", // ⚠️ confirm table name
            "round_id" => "required|exists:tbl_job_round,id",
            "status" => "required|in:0,1",
            "complete_datetime" => "nullable|date_format:Y-m-d H:i:s",
        ]);

        // ✅ Fetch user details
        $user = DB::table("users")
            ->select("id", "name", "contact_no", "email")
            ->where("id", $request->user_id)
            ->first();

        if (!$user) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "User not found.",
                ],
                404
            );
        }

        // ✅ Fetch job details
        $job = DB::table("tbl_job")
            ->select("job_id", "job_title", "user_id as company_user_id")
            ->where("job_id", $request->job_id)
            ->first();

        if (!$job) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Job not found.",
                ],
                404
            );
        }

        // ✅ Fetch round details
        $round = DB::table("tbl_job_round")
            ->select("id", "round_name")
            ->where("id", $request->round_id)
            ->first();

        if (!$round) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Round not found.",
                ],
                404
            );
        }

        // ✅ Update the matching record
        $updated = DB::table("tbl_round_complete")
            ->where("user_id", $request->user_id)
            ->where("job_id", $request->job_id)
            ->where("round_id", $request->round_id)
            ->update([
                "status" => $request->status,
                "complete_datetime" => $request->complete_datetime ?? now(),
                "updated_at" => now(),
            ]);

        // ✅ WhatsApp notification
        $contactPerson = "HR Team"; // you can replace this dynamically if needed
        $interviewStatus = $request->status == 1 ? "Completed" : "Pending";

        WhatsappHelper::sendTemplate(
            $user->contact_no,
            "interview_status_update",
            [
                $user->name,
                $round->round_name . " (" . $interviewStatus . ")",
                $contactPerson,
            ]
        );

        if ($updated) {
            return response()->json([
                "status" => true,
                "message" => "Round status updated successfully.",
                "user" => $user,
                "job" => $job,
                "round" => $round,
            ]);
        } else {
            return response()->json(
                [
                    "status" => false,
                    "message" => "No matching round found for given details.",
                ],
                404
            );
        }
    }

    public function acceptJob(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
            "job_id" => "required|exists:tbl_job,job_id",
        ]);

        // ✅ Update job application status
        $updated = DB::table("tbl_job_apply")
            ->where("user_id", $request->user_id)
            ->where("job_id", $request->job_id)
            ->update([
                "status" => 1,
                "updated_at" => now(),
            ]);

        if (!$updated) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Failed to accept job.",
                ],
                400
            );
        }

        // ✅ Fetch user details
        $user = DB::table("users")
            ->select("id", "name", "contact_no", "email")
            ->where("id", $request->user_id)
            ->first();

        // ✅ Fetch job details
        $job = DB::table("tbl_job")
            ->select("job_id", "job_title", "user_id as company_user_id")
            ->where("job_id", $request->job_id)
            ->first();

        // ✅ Fetch company details (from users table)
        $company = null;
        if ($job) {
            $company = DB::table("users")
                ->where("id", $job->company_user_id)
                ->select("id", "name", "contact_no", "email")
                ->first();
        }

        // ✅ Fetch job rounds
        $rounds = DB::table("tbl_job_round")
            ->where("job_id", $request->job_id)
            ->whereNull("deleted_at")
            ->select("id", "round_name", "round_desc")
            ->get();

        // Pick first round for WhatsApp message (or modify as per your flow)
        $roundName = $rounds->isNotEmpty()
            ? $rounds->first()->round_name
            : "Initial Round";
        $contactPerson = $company ? $company->name : "HR";

        // ✅ Send WhatsApp Notifications
        WhatsappHelper::sendTemplate(
            $user->contact_no,
            "interview_status_update",
            [
                $user->name,
                $job->job_title . " for (" . $roundName . ")",
                $contactPerson,
            ]
        );

        WhatsappHelper::sendTemplate($user->contact_no, "interview_selected", [
            $user->name,
            $job->job_title,
            $contactPerson,
            $company ? $company->contact_no : "N/A",
        ]);

        return response()->json(
            [
                "status" => true,
                "message" => "Job accepted successfully.",
                "user" => $user,
                "job" => $job,
                "company" => $company,
                "rounds" => $rounds,
            ],
            200
        );
    }

    public function rejectJob(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
            "job_id" => "required|exists:tbl_job,job_id", // ⚠️ check table name
            "msg" => "required|string|max:1000",
        ]);

        // ✅ Fetch user details
        $user = DB::table("users")
            ->select("id", "name", "contact_no", "email")
            ->where("id", $request->user_id)
            ->first();

        if (!$user) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "User not found.",
                ],
                404
            );
        }

        // ✅ Fetch job details
        $job = DB::table("tbl_job")
            ->select("job_id", "job_title")
            ->where("job_id", $request->job_id)
            ->first();

        if (!$job) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Job not found.",
                ],
                404
            );
        }

        // ✅ Get job_apply entry
        $jobApply = DB::table("tbl_job_apply")
            ->where("user_id", $request->user_id)
            ->where("job_id", $request->job_id)
            ->first();

        if (!$jobApply) {
            return response()->json([
                "status" => false,
                "message" => "Job application not found.",
            ]);
        }

        // ✅ Update status in tbl_job_apply
        $updated = DB::table("tbl_job_apply")
            ->where("id", $jobApply->id)
            ->update([
                "status" => 2,
                "updated_at" => now(),
            ]);

        // ✅ Update only msg in tbl_job_apply_history using job_apply_id
        if ($updated) {
            DB::table("tbl_job_apply_history")
                ->where("job_apply_id", $jobApply->id)
                ->update([
                    "msg" => $request->msg,
                    "updated_at" => now(),
                ]);
        }

        // ✅ WhatsApp Notification
        WhatsappHelper::sendTemplate($user->contact_no, "candidate_reject", [
            $user->name,
            $job->job_title,
        ]);

        return response()->json([
            "status" => $updated ? true : false,
            "message" => $updated
                ? "Job rejected and message updated."
                : "Failed to reject job.",
        ]);
    }

    public function shortlistCandidate(Request $request)
    {
        // ✅ Validate request
        $request->validate([
            "user_id" => "required|exists:users,id",
            "job_id" => "required|exists:tbl_job,job_id",
        ]);

        // ✅ Check if record exists in tbl_job_apply
        $application = DB::table("tbl_job_apply")
            ->where("user_id", $request->user_id)
            ->where("job_id", $request->job_id)
            ->first();

        if (!$application) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "No application found for this user and job",
                ],
                404
            );
        }

        // ✅ Fetch candidate (user) details
        $user = DB::table("users")
            ->select("id", "name", "contact_no", "email")
            ->where("id", $request->user_id)
            ->first();

        // ✅ Fetch job details
        $job = DB::table("tbl_job")
            ->select("job_id", "job_title", "user_id as company_user_id")
            ->where("job_id", $request->job_id)
            ->first();

        if (!$job) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Job not found.",
                ],
                404
            );
        }

        // dd($job);

        // ✅ Fetch company details (from users table)
        $company = DB::table("users")
            ->where("id", $job->company_user_id)
            ->select("id", "name", "contact_no", "email")
            ->first();

        // ✅ Update status to 3 (shortlisted)
        DB::table("tbl_job_apply")
            ->where("user_id", $request->user_id)
            ->where("job_id", $request->job_id)
            ->update([
                "status" => 3,
                "updated_at" => now(),
            ]);

        // ✅ Send WhatsApp notification
        WhatsappHelper::sendTemplate(
            $user->contact_no,
            "candidate_shortlist_interview",
            [$user->name, $job->job_title, $company->name, $company->name]
        );

        return response()->json(
            [
                "status" => true,
                "message" => "Candidate shortlisted successfully",
                "user" => $user,
                "job" => $job,
                "company" => $company,
            ],
            200
        );
    }

    public function scheduleUserRound(Request $request)
    {
        try {
            // ✅ Validate required fields
            $request->validate([
                "round_id" => "required",
                "job_id" => "required",
                "user_id" => "required|exists:users,id",
                // "hr_contact_no" => "required",
                // "hr_email" => "required|email",
                // "interview_address" => "required",
                "datetime" => "required|date_format:Y-m-d H:i:s",
            ]);

            // ✅ Fetch user data
            $user = DB::table("users")
                ->select("id", "name", "contact_no", "email")
                ->where("id", $request->user_id)
                ->first();

            if (!$user) {
                return response()->json(
                    [
                        "status" => false,
                        "message" => "User not found.",
                    ],
                    404
                );
            }

            // ✅ Fetch job data
            $job = DB::table("tbl_job")
                ->select("job_id", "job_title")
                ->where("job_id", $request->job_id)
                ->first();

            if (!$job) {
                return response()->json(
                    [
                        "status" => false,
                        "message" => "Job not found.",
                    ],
                    404
                );
            }

            // ✅ Fetch round name
            $round = DB::table("tbl_job_round")
                ->select("round_name")
                ->where("id", $request->round_id)
                ->first();

            if (!$round) {
                return response()->json(
                    [
                        "status" => false,
                        "message" => "Round not found.",
                    ],
                    404
                );
            }

            $roundName = $round->round_name;

            // ✅ Check if record exists in round complete
            $exists = DB::table("tbl_round_complete")
                ->where("round_id", $request->round_id)
                ->where("job_id", $request->job_id)
                ->where("user_id", $request->user_id)
                ->first();

            if (!$exists) {
                return response()->json(
                    [
                        "status" => false,
                        "message" => "Round record not found for this user.",
                    ],
                    404
                );
            }

            // 🔄 Update existing record
            DB::table("tbl_round_complete")
                ->where("round_id", $request->round_id)
                ->where("job_id", $request->job_id)
                ->where("user_id", $request->user_id)
                ->update([
                    "hr_contact_no" => $request->hr_contact_no,
                    "hr_email" => $request->hr_email,
                    "interview_address" => $request->interview_address,
                    "datetime" => $request->datetime,
                    "updated_at" => now(),
                ]);

            // 🔄 Update job application status
            DB::table("tbl_job_apply")
                ->where("job_id", $request->job_id)
                ->where("user_id", $request->user_id)
                ->update([
                    "status" => 4,
                    "updated_at" => now(),
                ]);

            // ✅ Send WhatsApp Template with round name
            $round = $roundName;
            WhatsappHelper::sendTemplate(
                $user->contact_no,
                "candidate_interview_schdule",
                [
                    $user->name,
                    $job->job_title . " for (" . $round . ")",
                    $request->hr_contact_no,
                    $request->datetime,
                    $request->interview_address,
                ]
            );

            return response()->json(
                [
                    "status" => true,
                    "message" =>
                        "User round updated successfully and job application status changed.",
                ],
                200
            );
        } catch (\Exception $e) {
            // ✅ Catch any exception and return JSON
            return response()->json(
                [
                    "status" => false,
                    "message" => "Something went wrong.",
                    "error" => $e->getMessage(),
                ],
                500
            );
        }
    }

    public function getHrDetails(Request $request)
    {
        // ✅ Validate
        $request->validate([
            "job_id" => "required|exists:tbl_job,job_id",
        ]);

        // ✅ Fetch HR details
        $hrDetails = DB::table("tbl_job")
            ->select("hr_email", "hr_contact_no")
            ->where("job_id", $request->job_id)
            ->first();

        if (!$hrDetails) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Job not found",
                ],
                404
            );
        }

        return response()->json(
            [
                "status" => true,
                "data" => $hrDetails,
            ],
            200
        );
    }

    public function checkCompanyProfileCompletion(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
        ]);

        $userId = $request->user_id;

        // ✅ Company related fields to check
        $companyFields = [
            "company_desc",
            // "about",
            "average_salary",
            "company_size",
            "company_since",
            "personal_website",
            "cover_img",
        ];

        // Fetch user only with company fields
        $user = DB::table("users")
            ->select(array_merge(["id"], $companyFields))
            ->where("id", $userId)
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

        $totalFields = count($companyFields);
        $filledFields = 0;
        $remainingFields = [];

        foreach ($companyFields as $field) {
            if (!empty($user->$field)) {
                $filledFields++;
            } else {
                $remainingFields[] = $field;
            }
        }

        // ✅ Profile completion condition (half or more fields must be filled)
        $isCompleted = $filledFields >= ceil($totalFields / 2);

        return response()->json([
            "status" => true,
            "message" => "Profile check successful",
            "data" => [
                "user_id" => $userId,
                "profile_completed" => $isCompleted,
                "filled_fields_count" => $filledFields,
                "total_company_fields" => $totalFields,
                "remaining_fields" => $remainingFields,
            ],
        ]);
    }
}