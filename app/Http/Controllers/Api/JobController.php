<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Helpers\WhatsappHelper;

class JobController extends Controller
{
    public function fetchResumeData(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
        ]);

        $userId = $request->user_id;

        // Fetch resume data
        $resume = DB::table("tbl_resume_builder")
            ->where("user_id", $userId)
            ->select(
                "id",
                "user_id",
                "resume_id",
                "profile_img",
                "full_name",
                "email",
                "phone",
                "skills",
                "designation",
                "summary",
                "experience",
                "education",
                "dob",
                "marital_status",
                "language_known",
                "address",
                "gender",
                "created_at",
                "updated_at"
            )
            // ->first();
            ->latest("updated_at") // or ->latest("created_at")
            ->first();

        if (!$resume) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "No resume found for this user",
                ],
                200
            );
        }

        return response()->json(
            [
                "status" => true,
                "message" => "Resume fetched successfully",
                "data" => $resume,
            ],
            200
        );
    }
    
    public function applyJob(Request $request)
    {
        $request->validate([
            "job_id" => "required",
            "user_id" => "required",
            "description" => "nullable",
            "file" => "nullable|mimes:jpeg,png,jpg,pdf,doc,docx",
            "resume_path" => "nullable|string",
            "isotherresume" => "required|boolean",
        ]);
	
	$alreadyApplied = DB::table("tbl_job_apply")
            ->where("job_id", $request->job_id)
            ->where("user_id", $request->user_id)
            ->whereNull("deleted_at")
            ->exists();
        if ($alreadyApplied) {
            return response()->json([
                "status" => false,
                "message" => "You have already applied for this job.",
            ], 200);
        }

        $FindUser = \App\Models\User::find($request->user_id);
        if (!\App\Models\PlanPricing::employeeCanApply($FindUser, 'job')) {
            return response()->json([
                "status" => 0,
                "message" => "Your current plan does not include Job service. Please upgrade your plan to apply.",
            ], 403);
        }

        $limitCheck = \App\Models\PlanPricing::checkServiceLimit($FindUser, 'job', 'apply');
        if (!$limitCheck['allowed']) {
            return response()->json([
                "status" => 0,
                "message" => $limitCheck['message'],
                "limit" => $limitCheck['limit'],
                "used" => $limitCheck['used'],
            ], 403);
        }

        // Fast path: already applied (same email/user + same job)
        $alreadyApplied = DB::table("tbl_job_apply")
            ->where("job_id", $request->job_id)
            ->where("user_id", $request->user_id)
            ->whereNull("deleted_at")
            ->exists();

        if ($alreadyApplied) {
            return response()->json([
                "status" => false,
                "message" => "You have already applied for this job.",
            ], 409);
        }

        $filePath = null;

        // Case 1: resume_path given, no file, and isotherresume = false
        if (
            $request->resume_path &&
            !$request->hasFile("file") &&
            !$request->isotherresume
        ) {
            $filePath = $request->resume_path;
        }

        // Case 2: isotherresume = true, file uploaded, resume_path null
        elseif (
            $request->isotherresume &&
            $request->hasFile("file") &&
            !$request->resume_path
        ) {
            $existingResume = DB::table("tbl_resume")
                ->where("user_id", $request->user_id)
                ->where("resume_type", 1)
                ->first();

            // Store uploaded file
            $file = $request->file("file");
            $fileName = time() . "_" . uniqid() . "." . $file->getClientOriginalExtension();
            
            $publicStorage = public_path("storage");
            if (file_exists($publicStorage) && !is_dir($publicStorage)) {
                @unlink($publicStorage);
            }
            $resumePath = public_path("storage/resumes");
            if (!file_exists($resumePath) || !is_dir($resumePath)) {
                @mkdir($resumePath, 0777, true);
            }
            try {
                $file->move($resumePath, $fileName);
            } catch (\Exception $e) {
                $fallbackPath = storage_path("app/public/resumes");
                if (!file_exists($fallbackPath) || !is_dir($fallbackPath)) {
                    @mkdir($fallbackPath, 0777, true);
                }
                $file->move($fallbackPath, $fileName);
            }
            $filePath = $fileName;

            if (!$existingResume) {
                // Insert into tbl_resume if not exists
                DB::table("tbl_resume")->insert([
                    "user_id" => $request->user_id,
                    "file_nm" => $filePath,
                    "resume_type" => 1,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
            }
        }

        // Case 3: If user_id has resume_type=1 already, and no file uploaded, use it
        elseif (!$request->hasFile("file") && !$request->resume_path) {
            $existingResume = DB::table("tbl_resume")
                ->where("user_id", $request->user_id)
                ->where("resume_type", 1)
                ->first();

            if ($existingResume) {
                $filePath = $existingResume->file_nm;
            }
        }

        // Step 3+4: Insert apply + history with lock so 2 devices at same time
        // only create one application; the other gets "already applied".
        $id = DB::transaction(function () use ($request, $filePath) {
            // Lock user row to serialize concurrent apply requests for same account
            DB::table("users")
                ->where("id", $request->user_id)
                ->lockForUpdate()
                ->first();

            $exists = DB::table("tbl_job_apply")
                ->where("job_id", $request->job_id)
                ->where("user_id", $request->user_id)
                ->whereNull("deleted_at")
                ->exists();

            if ($exists) {
                return null;
            }

            $applyId = DB::table("tbl_job_apply")->insertGetId([
                "job_id" => $request->job_id,
                "user_id" => $request->user_id,
                "description" => $request->description,
                "file_nm" => $filePath,
                "status" => 0,
                "datetime" => now(),
                "created_at" => now(),
                "updated_at" => now(),
            ]);

            DB::table("tbl_job_apply_history")->insert([
                "user_id" => $request->user_id,
                "job_id" => $request->job_id,
                "job_apply_id" => $applyId,
                "msg" => null,
                "datetime" => now(),
                "created_at" => now(),
                "updated_at" => now(),
            ]);

            return $applyId;
        });

        if ($id === null) {
            return response()->json([
                "status" => false,
                "message" => "You have already applied for this job.",
            ], 409);
        }

        if ($FindUser) {
            \App\Models\PlanPricing::incrementServiceUsage($FindUser, 'job');
        }

        // Step 5: Fetch and insert rounds into tbl_round_complete
        $rounds = DB::table("tbl_job_round")
            ->where("job_id", $request->job_id)
            ->pluck("id");

        if (!$rounds->isEmpty()) {
            $insertRounds = [];
            foreach ($rounds as $roundId) {
                $insertRounds[] = [
                    "user_id" => $request->user_id,
                    "job_id" => $request->job_id,
                    "round_id" => $roundId,
                    "hr_name" => null,
                    "hr_contact_no" => null,
                    "hr_email" => null,
                    "interview_address" => null,
                    "datetime" => null,
                    "complete_datetime" => null,
                    "status" => 0,
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
            }
            DB::table("tbl_round_complete")->insert($insertRounds);
        }

        // Step 6: Fetch additional details for WhatsApp
        $FindUser = DB::table("users")
            ->where("id", $request->user_id)
            ->select("name")
            ->first();

        $FindJob = DB::table("tbl_job")
            ->where("job_id", $request->job_id)
            ->select("job_title", "user_id")
            ->first();

        $company = null;
        if ($FindJob) {
            $company = DB::table("users")
                ->where("id", $FindJob->user_id)
                ->select("contact_no")
                ->first();
        }

        // Send WhatsApp notification if company contact is available
        try {
            if ($company && $company->contact_no && $FindUser && $FindJob) {
                WhatsappHelper::sendTemplate(
                    $company->contact_no,
                    'candidate_company_apply',
                    [$FindUser->name, $FindJob->job_title]
                );
            }
        } catch (\Throwable $wh) {
            \Illuminate\Support\Facades\Log::warning('WhatsApp failed on API job apply', [
                'error' => $wh->getMessage(),
            ]);
        }

        // Step 7: Return response
        $appliedJob = DB::table("tbl_job_apply")
            ->where("id", $id)
            ->first();

        return response()->json([
            "status" => true,
            "message" => "Job applied successfully and rounds added",
            "data" => $appliedJob,
        ]);
    }

    // public function applyJob(Request $request)
    // {
    //     $request->validate([
    //         "job_id" => "required",
    //         "user_id" => "required",
    //         "description" => "nullable",
    //         "file" => "nullable|mimes:jpeg,png,jpg,pdf,doc,docx",
    //         "resume_path" => "nullable|string",
    //         "isotherresume" => "required|boolean",
    //     ]);

    //     $FindUser = \App\Models\User::find($request->user_id);
    //     if (!\App\Models\PlanPricing::employeeCanApply($FindUser, 'job')) {
    //         return response()->json([
    //             "status" => 0,
    //             "message" => "Your current plan does not include Job service. Please upgrade your plan to apply.",
    //         ], 403);
    //     }

    //     $filePath = null;

    //     // Case 1: resume_path given, no file, and isotherresume = false
    //     if (
    //         $request->resume_path &&
    //         !$request->hasFile("file") &&
    //         !$request->isotherresume
    //     ) {
    //         $filePath = $request->resume_path;
    //     }

    //     // Case 2: isotherresume = true, file uploaded, resume_path null
    //     elseif (
    //         $request->isotherresume &&
    //         $request->hasFile("file") &&
    //         !$request->resume_path
    //     ) {
    //         $existingResume = DB::table("tbl_resume")
    //             ->where("user_id", $request->user_id)
    //             ->where("resume_type", 1)
    //             ->first();

    //         // Store uploaded file
    //         $file = $request->file("file");
    //         $fileName = time() . "." . $file->getClientOriginalExtension();
    //         $file->move(public_path("storage/resumes"), $fileName);
    //         $filePath = $fileName;

    //         if (!$existingResume) {
    //             // Insert into tbl_resume if not exists
    //             DB::table("tbl_resume")->insert([
    //                 "user_id" => $request->user_id,
    //                 "file_nm" => $filePath,
    //                 "resume_type" => 1,
    //                 "created_at" => now(),
    //                 "updated_at" => now(),
    //             ]);
    //         }
    //     }

    //     // Case 3: If user_id has resume_type=1 already, and no file uploaded, use it
    //     elseif (!$request->hasFile("file") && !$request->resume_path) {
    //         $existingResume = DB::table("tbl_resume")
    //             ->where("user_id", $request->user_id)
    //             ->where("resume_type", 1)
    //             ->first();

    //         if ($existingResume) {
    //             $filePath = $existingResume->file_nm;
    //         }
    //     }

    //     // Step 3: Insert into tbl_job_apply
    //     $id = DB::table("tbl_job_apply")->insertGetId([
    //         "job_id" => $request->job_id,
    //         "user_id" => $request->user_id,
    //         "description" => $request->description,
    //         "file_nm" => $filePath,
    //         "status" => 0,
    //         "datetime" => now(),
    //         "created_at" => now(),
    //         "updated_at" => now(),
    //     ]);

    //     // Step 4: Insert into tbl_job_apply_history
    //     DB::table("tbl_job_apply_history")->insert([
    //         "user_id" => $request->user_id,
    //         "job_id" => $request->job_id,
    //         "job_apply_id" => $id,
    //         "msg" => null,
    //         "datetime" => now(),
    //         "created_at" => now(),
    //         "updated_at" => now(),
    //     ]);

    //     // Step 5: Fetch and insert rounds into tbl_round_complete
    //     $rounds = DB::table("tbl_job_round")
    //         ->where("job_id", $request->job_id)
    //         ->pluck("id");

    //     if (!$rounds->isEmpty()) {
    //         $insertRounds = [];
    //         foreach ($rounds as $roundId) {
    //             $insertRounds[] = [
    //                 "user_id" => $request->user_id,
    //                 "job_id" => $request->job_id,
    //                 "round_id" => $roundId,
    //                 "hr_name" => null,
    //                 "hr_contact_no" => null,
    //                 "hr_email" => null,
    //                 "interview_address" => null,
    //                 "datetime" => null,
    //                 "complete_datetime" => null,
    //                 "status" => 0,
    //                 "created_at" => now(),
    //                 "updated_at" => now(),
    //             ];
    //         }
    //         DB::table("tbl_round_complete")->insert($insertRounds);
    //     }

    //     // Step 6: Fetch additional details for WhatsApp
    //     $FindUser = DB::table("users")
    //         ->where("id", $request->user_id)
    //         ->select("name")
    //         ->first();

    //     $FindJob = DB::table("tbl_job")
    //         ->where("job_id", $request->job_id)
    //         ->select("job_title", "user_id")
    //         ->first();

    //     $company = null;
    //     if ($FindJob) {
    //         $company = DB::table("users")
    //             ->where("id", $FindJob->user_id)
    //             ->select("contact_no")
    //             ->first();
    //     }

    //     // Send WhatsApp notification if company contact is available
    //     try {
    //         if ($company && $company->contact_no && $FindUser && $FindJob) {
    //             WhatsappHelper::sendTemplate(
    //                 $company->contact_no,
    //                 'candidate_company_apply',
    //                 [$FindUser->name, $FindJob->job_title]
    //             );
    //         }
    //     } catch (\Throwable $wh) {
    //         \Illuminate\Support\Facades\Log::warning('WhatsApp failed on API job apply', [
    //             'error' => $wh->getMessage(),
    //         ]);
    //     }

    //     // Step 7: Return response
    //     $appliedJob = DB::table("tbl_job_apply")
    //         ->where("id", $id)
    //         ->first();

    //     return response()->json([
    //         "status" => true,
    //         "message" => "Job applied successfully and rounds added",
    //         "data" => $appliedJob,
    //     ]);
    // }

    public function toggleSavedJobPost(Request $request)
    {
        // Step 1: Validate input
        $request->validate([
            "user_id" => "required|exists:users,id",
            "job_id" => "required|exists:tbl_job,job_id",
        ]);

        // Step 2: Check if a record exists (with or without deleted_at)
        $existing = DB::table("tbl_job_save")
            ->where("user_id", $request->user_id)
            ->where("job_id", $request->job_id)
            ->first();

        // Step 3: Handle based on existing record
        if ($existing) {
            if ($existing->deleted_at) {
                // Record was soft deleted (unsaved) -> Now save again
                DB::table("tbl_job_save")
                    ->where("user_id", $request->user_id)
                    ->where("job_id", $request->job_id)
                    ->update([
                        "saved_at" => now(),
                        "deleted_at" => null,
                        "updated_at" => now(),
                    ]);

                return response()->json([
                    "status" => true,
                    "message" => "Job post saved again",
                    "is_saved" => true,
                ]);
            } else {
                // Record is already saved -> Now unsave (soft delete)
                DB::table("tbl_job_save")
                    ->where("user_id", $request->user_id)
                    ->where("job_id", $request->job_id)
                    ->update([
                        "saved_at" => null,
                        "deleted_at" => now(),
                        "updated_at" => now(),
                    ]);

                return response()->json([
                    "status" => true,
                    "message" => "Job post removed from saved",
                    "is_saved" => false,
                ]);
            }
        } else {
            // No record exists -> First time save
            DB::table("tbl_job_save")->insert([
                "user_id" => $request->user_id,
                "job_id" => $request->job_id,
                "saved_at" => now(),
                "deleted_at" => null,
                "created_at" => now(),
                "updated_at" => now(),
            ]);

            return response()->json([
                "status" => true,
                "message" => "Job post saved successfully",
                "is_saved" => true,
            ]);
        }
    }

    public function fetchMySavedPosts(Request $request)
    {
        $request->validate([
            "user_id" => "required|exists:users,id",
        ]);

        $userId = $request->query("user_id");

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
            ->select([
                "js.id as saved_id",
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
                "js.saved_at",
            ])
            ->where("js.user_id", $userId)
            ->whereNull("js.deleted_at")
            ->whereNull("j.deleted_at")
            ->orderByDesc("js.saved_at")
            ->get();

        return response()->json(
            [
                "status" => true,
                "message" => "Saved job posts fetched successfully",
                "data" => $savedJobs,
            ],
            200
        );
    }

    public function getJobList(Request $request)
    {
        $jobs = DB::table("tbl_job as j")
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
            ->get();

        return response()->json(
            [
                "status" => true,
                "message" => "Active job list fetched successfully",
                "data" => $jobs,
            ],
            200
        );
    }

    public function getJobDetails(Request $request)
    {
        $request->validate([
            "job_id" => "required|exists:tbl_job,job_id",
            "user_id" => "nullable",
        ]);

        $job_id = $request->job_id;
        $user_id = $request->user_id;

        // ────────────────────────── Fetch job
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
            ->leftJoin("users as u", "j.user_id", "=", "u.id") // 👈 Company details from users
            ->select([
                "j.job_id",
                "j.user_id",
                "j.preference_type",
                "j.category_id",
                "c.category_nm",
                "c.image as category_img",
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
                "j.salary_budget",
                "j.job_timing",
                "j.age",
                "j.gender",
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
                "j.created_at",
                "j.updated_at",
                // 👇 Company details
                "u.id as company_id",
                "u.name as company_name",
                "u.email as company_email",
                "u.contact_no as company_contact",
                "u.profile_img as company_logo",
                "u.company_size as company_size",
                "u.company_since as company_since",
                "u.personal_website as company_website",
            ])
            ->where("j.job_id", $job_id)
            ->whereNull("j.deleted_at")
            ->first();

        if (!$job) {
            return response()->json(
                ["status" => false, "message" => "Job not found"],
                404
            );
        }

        // ────────────────────────── Applied count & resumes
        $appliedCount = DB::table("tbl_job_apply")
            ->where("job_id", $job_id)
            ->whereNull("deleted_at")
            ->count();

        $isApplied = false;
        $resumes = [];
        $applicationStatus = null;
        $rejectionReason = null;
        $savedFlag = false; // default
        $markAsRead = false; // 👈 default false

        if ($user_id) {
            $application = DB::table("tbl_job_apply")
                ->where("job_id", $job_id)
                ->where("user_id", $user_id)
                ->whereNull("deleted_at")
                ->first();

            if ($application) {
                $isApplied = true;
                $applicationStatus = $application->status;

                // 👇 check markAsRead flag
                $markAsRead = !is_null($application->markAsRead);

                // If rejected, get reason
                if ($application->status == 2) {
                    $history = DB::table("tbl_job_apply_history")
                        ->where("job_id", $job_id)
                        ->where("user_id", $user_id)
                        ->orderByDesc("id")
                        ->first();

                    $rejectionReason = $history ? $history->msg : null;
                }
            }

            // User resumes
            $resumes = DB::table("tbl_resume")
                ->where("user_id", $user_id)
                ->select("resume_id", "file_nm", "resume_type", "created_at")
                ->get();

            // ────────────────────────── Saved job check
            $savedJob = DB::table("tbl_job_save")
                ->where("job_id", $job_id)
                ->where("user_id", $user_id)
                ->first();

            if (
                $savedJob &&
                !empty($savedJob->saved_at) &&
                empty($savedJob->deleted_at)
            ) {
                $savedFlag = true;
            }
        }

        // ────────────────────────── Job rounds
        $rounds = DB::table("tbl_job_round")
            ->where("job_id", $job_id)
            ->whereNull("deleted_at")
            ->orderBy("id", "asc")
            ->get();

        $roundDetails = [];
        foreach ($rounds as $round) {
            $roundStatus = "not_completed";
            $roundData = null;

            if ($user_id) {
                $rc = DB::table("tbl_round_complete")
                    ->where("job_id", $job_id)
                    ->where("round_id", $round->id)
                    ->where("user_id", $user_id)
                    ->first();

                if ($rc) {
                    // ✅ COMPLETED
                    if (
                        $rc->status == 1 &&
                        !empty($rc->datetime) &&
                        !empty($rc->complete_datetime)
                    ) {
                        $roundStatus = "completed";
                        $roundData = $rc;
                    }
                    // ❌ NOT COMPLETED
                    elseif (
                        $rc->status == 0 &&
                        empty($rc->datetime) &&
                        empty($rc->complete_datetime)
                    ) {
                        $roundStatus = "not_completed";
                        $roundData = $rc;
                    }
                    // ⏳ SCHEDULED
                    elseif (
                        $rc->status == 0 &&
                        !empty($rc->datetime) &&
                        empty($rc->complete_datetime)
                    ) {
                        $roundStatus = "scheduled";
                        $roundData = $rc;
                    }
                }
            }

            $roundDetails[] = [
                "round_id" => $round->id,
                "round_name" => $round->round_name,
                "round_desc" => $round->round_desc,
                "status" => $roundStatus,
                "details" => $roundData,
            ];
        }

        // ────────────────────────── Final response
        $job->total_applied = $appliedCount;
        $job->remaining_seats = max(
            0,
            $job->number_of_openings - $appliedCount
        );
        $job->is_applied = $isApplied;
        $job->resumes = $resumes;
        $job->application_status = $applicationStatus;
        $job->rejection_reason = $rejectionReason;
        $job->rounds = $roundDetails;
        $job->saved_flag = $savedFlag; // 👈 added flag
        $job->mark_as_read = $markAsRead; // 👈 added new flag

        return response()->json([
            "status" => true,
            "message" => "Job details fetched successfully",
            "data" => $job,
        ]);
    }

    public function getUserDetails($user_id)
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

        // Step 5: Education
        $userArray["education"] = DB::table("tbl_education")
            ->where("user_id", $user_id)
            ->whereNull("deleted_at")
            ->get([
                "id",
                "school_name",
                "degree",
                "field_of_study",
                "grade",
                "start_date",
                "end_date",
                "description",
            ]);

        // Step 6: Work Experience
        $userArray["work_experience"] = DB::table("tbl_work_experience")
            ->where("user_id", $user_id)
            ->whereNull("deleted_at")
            ->get([
                "id",
                "title",
                "work_type_id",
                "company",
                "working_status",
                "start_date",
                "end_date",
                "location",
                "job_type_id",
                "role_responsibility",
            ]);

        // Step 7: Saved Jobs - with full job details
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
            ])
            ->orderByDesc("j.created_at")
            ->get();

        $userArray["saved_jobs"] = $savedJobs;
        $userArray["saved_jobs_count"] = $savedJobs->count();

        // Step 8: Applied Jobs - with full job details
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
            ])
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

    // public function searchAndFilterJobList(Request $request)
    // {
    //     $request->validate([
    //         "search_flag" => "nullable|boolean",
    //         "search_value" => "nullable|string",
    //         "skills" => "nullable|array",
    //         "skills.*" => "string",
    //         "user_id" => "nullable|integer",
    //     ]);

    //     $userId = $request->input("user_id");

    //     $query = DB::table("tbl_job as j")
    //         ->leftJoin(
    //             "tbl_job_category as c",
    //             "j.category_id",
    //             "=",
    //             "c.category_id"
    //         )
    //         ->leftJoin(
    //             "tbl_sub_category as sc",
    //             "j.sub_category_id",
    //             "=",
    //             "sc.sub_category_id"
    //         )
    //         ->leftJoin(
    //             "tbl_min_qualification as q",
    //             "j.qualification_id",
    //             "=",
    //             "q.qualification_id"
    //         )
    //         ->leftJoin(
    //             "tbl_job_level as jl",
    //             "j.job_level_id",
    //             "=",
    //             "jl.job_level_id"
    //         )
    //         ->leftJoin(
    //             "tbl_job_type as jt",
    //             "j.job_type_id",
    //             "=",
    //             "jt.job_type_id"
    //         )
    //         ->leftJoin(
    //             "tbl_work_type as wt",
    //             "j.work_type_id",
    //             "=",
    //             "wt.work_type_id"
    //         )
    //         ->leftJoin(
    //             "tbl_experience_req as er",
    //             "j.experience_req_id",
    //             "=",
    //             "er.experience_req_id"
    //         )
    //         ->leftJoin("tbl_state as s", "j.state_id", "=", "s.state_id")
    //         ->leftJoin("tbl_city as ci", "j.city_id", "=", "ci.city_id")
    //         ->leftJoin("tbl_area as a", "j.area_id", "=", "a.area_id")
    //         ->leftJoin("tbl_zipcode as z", "j.zipcode_id", "=", "z.zipcode_id")
    //         ->select([
    //             "j.job_id",
    //             "j.user_id",
    //             "j.preference_type",
    //             "j.category_id",
    //             "j.salary_budget",
    //             "c.category_nm",
    //             "j.sub_category_id",
    //             "sc.sub_category_nm",
    //             "j.job_title",
    //             "j.qualification_id",
    //             "q.name as qualification_name",
    //             "j.job_level_id",
    //             "jl.type_nm as job_level_name",
    //             "j.job_type_id",
    //             "jt.type_name as job_type_name",
    //             "j.work_type_id",
    //             "wt.type_nm as work_type_name",
    //             "j.number_of_openings",
    //             "j.job_description",
    //             "j.interviewer_address",
    //             "j.experience_req_id",
    //             "er.name as experience_req_name",
    //             "j.contact_no",
    //             "j.company_website",
    //             "j.company_address",
    //             "j.state_id",
    //             "s.state_name",
    //             "j.city_id",
    //             "ci.city_nm",
    //             "j.area_id",
    //             "a.area_nm",
    //             "j.zipcode_id",
    //             "z.zipcode",
    //             "j.hr_email",
    //             "j.hr_contact_no",
    //             "j.skill_id",
    //             "j.datetime",
    //             "j.status", // from jobs table
    //             "j.total_apply",
    //             "j.remain_opening",
    //             "j.created_at",
    //             "j.updated_at",
    //             // "---------"
    //         ])
    //         // add applied flag using EXISTS
    //         ->when(
    //             $userId,
    //             function ($q) use ($userId) {
    //                 return $q->selectRaw(
    //                     "EXISTS (
    //                 SELECT 1
    //                 FROM tbl_job_apply ja
    //                 WHERE ja.job_id = j.job_id
    //                   AND ja.user_id = ?
    //                   AND ja.deleted_at IS NULL
    //             ) AS applied",
    //                     [$userId]
    //                 );
    //             },
    //             function ($q) {
    //                 return $q->selectRaw("0 AS applied"); // no user -> not applied
    //             }
    //         )
    //         ->whereNull("j.deleted_at")
    //         ->where("j.status", 1);

    //     // --- your search logic ---
    //     if (
    //         $request->input("search_flag") &&
    //         $request->filled("search_value")
    //     ) {
    //         $search = $request->input("search_value");
    //         $query->where(function ($q) use ($search) {
    //             $q->where("j.job_title", "LIKE", "%{$search}%")
    //                 ->orWhere("j.job_description", "LIKE", "%{$search}%")
    //                 ->orWhere("j.company_address", "LIKE", "%{$search}%")
    //                 ->orWhere("j.contact_no", "LIKE", "%{$search}%")
    //                 ->orWhere("j.company_website", "LIKE", "%{$search}%")
    //                 ->orWhere("j.hr_email", "LIKE", "%{$search}%")
    //                 ->orWhere("j.hr_contact_no", "LIKE", "%{$search}%")
    //                 ->orWhere("j.skill_id", "LIKE", "%{$search}%")
    //                 ->orWhere("j.preference_type", "LIKE", "%{$search}%")
    //                 ->orWhere("j.interviewer_address", "LIKE", "%{$search}%")
    //                 ->orWhere("c.category_nm", "LIKE", "%{$search}%")
    //                 ->orWhere("sc.sub_category_nm", "LIKE", "%{$search}%")
    //                 ->orWhere("q.name", "LIKE", "%{$search}%")
    //                 ->orWhere("jl.type_nm", "LIKE", "%{$search}%")
    //                 ->orWhere("jt.type_name", "LIKE", "%{$search}%")
    //                 ->orWhere("wt.type_nm", "LIKE", "%{$search}%")
    //                 ->orWhere("er.name", "LIKE", "%{$search}%")
    //                 ->orWhere("s.state_name", "LIKE", "%{$search}%")
    //                 ->orWhere("ci.city_nm", "LIKE", "%{$search}%")
    //                 ->orWhere("a.area_nm", "LIKE", "%{$search}%")
    //                 ->orWhere("z.zipcode", "LIKE", "%{$search}%");
    //         });
    //     } else {
    //         // --- your filter logic (unchanged) ---
    //         $filterableColumns = [
    //             "preference_type",
    //             "category_id",
    //             "sub_category_id",
    //             "qualification_id",
    //             "job_level_id",
    //             "job_type_id",
    //             "work_type_id",
    //             "experience_req_id",
    //             "state_id",
    //             "city_id",
    //             "area_id",
    //             "zipcode_id",
    //             "status",
    //             "user_id",
    //             "number_of_openings",
    //             "total_apply",
    //             "remain_opening",
    //         ];

    //         foreach ($filterableColumns as $column) {
    //             if ($request->filled($column)) {
    //                 $value = $request->input($column);
    //                 is_array($value)
    //                     ? $query->whereIn("j.$column", $value)
    //                     : $query->where("j.$column", $value);
    //             }
    //         }

    //         if ($request->filled("skills") && is_array($request->skills)) {
    //             $matchedCategories = [];
    //             $matchedSubCategories = [];

    //             $skillsDataAll = DB::table("tbl_skills")
    //                 ->whereNull("deleted_at")
    //                 ->where(function ($qq) use ($request) {
    //                     foreach ($request->skills as $kw) {
    //                         $qq->orWhere("skill_nm", "LIKE", "%" . $kw . "%");
    //                     }
    //                 })
    //                 ->get(["category_id", "sub_category_id"]);

    //             foreach ($skillsDataAll as $row) {
    //                 if (
    //                     $row->category_id &&
    //                     !in_array($row->category_id, $matchedCategories)
    //                 ) {
    //                     $matchedCategories[] = $row->category_id;
    //                 }
    //                 if (
    //                     $row->sub_category_id &&
    //                     !in_array($row->sub_category_id, $matchedSubCategories)
    //                 ) {
    //                     $matchedSubCategories[] = $row->sub_category_id;
    //                 }
    //             }

    //             $query->where(function ($q) use (
    //                 $matchedCategories,
    //                 $matchedSubCategories
    //             ) {
    //                 if (!empty($matchedCategories)) {
    //                     $q->whereIn("j.category_id", $matchedCategories);
    //                 }
    //                 if (!empty($matchedSubCategories)) {
    //                     $q->orWhereIn(
    //                         "j.sub_category_id",
    //                         $matchedSubCategories
    //                     );
    //                 }
    //             });
    //         }
    //     }

    //     $jobs = $query->orderByDesc("j.created_at")->get();

    //     // cast applied to boolean in response
    //     $jobs->transform(function ($row) {
    //         $row->applied = (bool) $row->applied;
    //         return $row;
    //     });

    //     return response()->json(
    //         [
    //             "status" => true,
    //             "message" => "Job list fetched successfully",
    //             "data" => $jobs,
    //         ],
    //         200
    //     );
    // }

    //     public function searchAndFilterJobList(Request $request)
// {
//     // Force JSON response (VERY IMPORTANT)
//     if (!$request->expectsJson()) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Invalid request type'
//         ], 400);
//     }

    //     // Validation
//     $validated = $request->validate([
//         "search_flag"        => "nullable|boolean",
//         "search_value"       => "nullable|string",
//         "skills"             => "nullable|array",
//         "skills.*"           => "string",
//         "user_id"            => "nullable|integer",

    //         "preference_type"    => "nullable|integer",
//         "category_id"        => "nullable|integer",
//         "sub_category_id"    => "nullable|integer",
//         "qualification_id"   => "nullable|integer",
//         "job_level_id"       => "nullable|integer",
//         "job_type_id"        => "nullable|integer",
//         "work_type_id"       => "nullable|integer",
//         "experience_req_id"  => "nullable|integer",
//         "state_id"           => "nullable|integer",
//         "city_id"            => "nullable|integer",
//         "area_id"            => "nullable|integer",
//         "zipcode_id"         => "nullable|integer",
//     ]);

    //     $userId = $request->user_id;

    //     // ===================== BASE QUERY =====================
//     $query = DB::table("tbl_job as j")
//         ->leftJoin("tbl_job_category as c", "j.category_id", "=", "c.category_id")
//         ->leftJoin("tbl_sub_category as sc", "j.sub_category_id", "=", "sc.sub_category_id")
//         ->leftJoin("tbl_min_qualification as q", "j.qualification_id", "=", "q.qualification_id")
//         ->leftJoin("tbl_job_level as jl", "j.job_level_id", "=", "jl.job_level_id")
//         ->leftJoin("tbl_job_type as jt", "j.job_type_id", "=", "jt.job_type_id")
//         ->leftJoin("tbl_work_type as wt", "j.work_type_id", "=", "wt.work_type_id")
//         ->leftJoin("tbl_experience_req as er", "j.experience_req_id", "=", "er.experience_req_id")
//         ->leftJoin("tbl_state as s", "j.state_id", "=", "s.state_id")
//         ->leftJoin("tbl_city as ci", "j.city_id", "=", "ci.city_id")
//         ->leftJoin("tbl_area as a", "j.area_id", "=", "a.area_id")
//         ->leftJoin("tbl_zipcode as z", "j.zipcode_id", "=", "z.zipcode_id")
//         ->whereNull("j.deleted_at")
//         ->where("j.status", 1);

    //     // ===================== APPLIED FLAG =====================
//     if ($userId) {
//         $query->selectRaw(
//             "EXISTS (
//                 SELECT 1 FROM tbl_job_apply ja
//                 WHERE ja.job_id = j.job_id
//                 AND ja.user_id = ?
//                 AND ja.deleted_at IS NULL
//             ) AS applied",
//             [$userId]
//         );
//     } else {
//         $query->selectRaw("0 AS applied");
//     }

    //     // ===================== SEARCH =====================
//     if ($request->boolean("search_flag") && $request->filled("search_value")) {
//         $search = $request->search_value;

    //         $query->where(function ($q) use ($search) {
//             $q->where("j.job_title", "LIKE", "%$search%")
//               ->orWhere("j.job_description", "LIKE", "%$search%")
//               ->orWhere("c.category_nm", "LIKE", "%$search%")
//               ->orWhere("sc.sub_category_nm", "LIKE", "%$search%")
//               ->orWhere("jt.type_name", "LIKE", "%$search%")
//               ->orWhere("wt.type_nm", "LIKE", "%$search%")
//               ->orWhere("s.state_name", "LIKE", "%$search%")
//               ->orWhere("ci.city_nm", "LIKE", "%$search%");
//         });
//     }

    //     // ===================== FILTERS =====================
//     $filters = [
//         "preference_type",
//         "category_id",
//         "sub_category_id",
//         "qualification_id",
//         "job_level_id",
//         "job_type_id",
//         "work_type_id",
//         "experience_req_id",
//         "state_id",
//         "city_id",
//         "area_id",
//         "zipcode_id",
//     ];

    //     foreach ($filters as $field) {
//         if ($request->filled($field)) {
//             $query->where("j.$field", $request->$field);
//         }
//     }

    //     // ===================== SKILLS FILTER (CORRECT) =====================
//     if ($request->filled("skills")) {
//         $skills = $request->skills;

    //         $query->where(function ($q) use ($skills) {
//             foreach ($skills as $skill) {
//                 $q->orWhere("j.skill_id", "LIKE", "%$skill%");
//             }
//         });
//     }

    //     // ===================== SELECT =====================
//     // $query->select([
//     //     "j.job_id",
//     //     "j.job_title",
//     //     "j.salary_budget",
//     //     "j.company_address",
//     //     "j.skill_id",
//     //     "j.created_at",
//     //     "c.category_nm",
//     //     "sc.sub_category_nm",
//     //     "jt.type_name as job_type",
//     //     "wt.type_nm as work_type",
//     //     "s.state_name",
//     //     "ci.city_nm",
//     // ]);

    //     $query->select([
//     "j.job_id",
//     "j.job_title",
//     "j.salary_budget",
//     "j.company_address",
//     "j.skill_id",
//     "j.created_at",
//     "c.category_nm",
//     "sc.sub_category_nm",
//     "jt.type_name as job_type",
//     "wt.type_nm as work_type",
//     "s.state_name",
//     "ci.city_nm",

    //     // ✅ applied flag (SAFE)
//     DB::raw(
//         $userId
//             ? "EXISTS (
//                 SELECT 1 FROM tbl_job_apply ja
//                 WHERE ja.job_id = j.job_id
//                 AND ja.user_id = $userId
//                 AND ja.deleted_at IS NULL
//               ) AS applied"
//             : "0 AS applied"
//     ),
// ]);

    //     $jobs = $query->orderByDesc("j.created_at")->get();

    //     $jobs->transform(function ($row) {
//         $row->applied = (bool) $row->applied;
//         return $row;
//     });

    //     return response()->json([
//         "status" => true,
//         "message" => "Job list fetched successfully",
//         "data" => $jobs
//     ]);
// }

    public function searchAndFilterJobList(Request $request)
    {
        $request->validate([
            "search_flag" => "nullable|boolean",
            "search_value" => "nullable|string",
            "skills" => "nullable|array",
            "skills.*" => "string",
            "user_id" => "nullable|integer",

            "preference_type" => "nullable|integer",
            "category_id" => "nullable|integer",
            "sub_category_id" => "nullable|integer",
            "qualification_id" => "nullable|integer",
            "job_level_id" => "nullable|integer",
            "job_type_id" => "nullable|integer",
            "work_type_id" => "nullable|integer",
            "experience_req_id" => "nullable|integer",
            "state_id" => "nullable|integer",
            "city_id" => "nullable|integer",
            "area_id" => "nullable|integer",
            "zipcode_id" => "nullable|integer",
        ]);

        $userId = $request->user_id;

        // ================= BASE QUERY =================
        // $query = DB::table("tbl_job as j")
        //     ->leftJoin("tbl_job_category as c", "j.category_id", "=", "c.category_id")
        //     ->leftJoin("tbl_sub_category as sc", "j.sub_category_id", "=", "sc.sub_category_id")
        //     ->leftJoin("tbl_min_qualification as q", "j.qualification_id", "=", "q.qualification_id")
        //     ->leftJoin("tbl_job_level as jl", "j.job_level_id", "=", "jl.job_level_id")
        //     ->leftJoin("tbl_job_type as jt", "j.job_type_id", "=", "jt.job_type_id")
        //     ->leftJoin("tbl_work_type as wt", "j.work_type_id", "=", "wt.work_type_id")
        //     ->leftJoin("tbl_experience_req as er", "j.experience_req_id", "=", "er.experience_req_id")
        //     ->leftJoin("tbl_state as s", "j.state_id", "=", "s.state_id")
        //     ->leftJoin("tbl_city as ci", "j.city_id", "=", "ci.city_id")
        //     ->leftJoin("tbl_area as a", "j.area_id", "=", "a.area_id")
        //     ->leftJoin("tbl_zipcode as z", "j.zipcode_id", "=", "z.zipcode_id")
        //     ->whereNull("j.deleted_at")
        //     ->where("j.status", 1);

        $query = DB::table("tbl_job as j")
            ->leftJoin("users as u", "j.user_id", "=", "u.id") // ✅ NEW

            ->leftJoin("tbl_job_category as c", "j.category_id", "=", "c.category_id")
            ->leftJoin("tbl_sub_category as sc", "j.sub_category_id", "=", "sc.sub_category_id")
            ->leftJoin("tbl_min_qualification as q", "j.qualification_id", "=", "q.qualification_id")
            ->leftJoin("tbl_job_level as jl", "j.job_level_id", "=", "jl.job_level_id")
            ->leftJoin("tbl_job_type as jt", "j.job_type_id", "=", "jt.job_type_id")
            ->leftJoin("tbl_work_type as wt", "j.work_type_id", "=", "wt.work_type_id")
            ->leftJoin("tbl_experience_req as er", "j.experience_req_id", "=", "er.experience_req_id")
            ->leftJoin("tbl_state as s", "j.state_id", "=", "s.state_id")
            ->leftJoin("tbl_city as ci", "j.city_id", "=", "ci.city_id")
            ->leftJoin("tbl_area as a", "j.area_id", "=", "a.area_id")
            ->leftJoin("tbl_zipcode as z", "j.zipcode_id", "=", "z.zipcode_id")
            ->whereNull("j.deleted_at")
            ->where("j.status", 1);

        // ================= APPLIED FLAG =================
        $query->selectRaw(
            $userId
            ? "EXISTS (
                SELECT 1 FROM tbl_job_apply ja
                WHERE ja.job_id = j.job_id
                AND ja.user_id = ?
                AND ja.deleted_at IS NULL
              ) AS applied"
            : "0 AS applied",
            $userId ? [$userId] : []
        );

        // ================= SEARCH (FIXED) =================
        if ($request->boolean("search_flag") && $request->filled("search_value")) {

            $search = $request->search_value;

            $query->where(function ($q) use ($search) {
                $q->where("j.job_title", "LIKE", "%{$search}%")
                    ->orWhere("j.job_description", "LIKE", "%{$search}%")
                    ->orWhere("j.company_address", "LIKE", "%{$search}%")
                    ->orWhere("j.contact_no", "LIKE", "%{$search}%")
                    ->orWhere("j.company_website", "LIKE", "%{$search}%")
                    ->orWhere("j.hr_email", "LIKE", "%{$search}%")
                    ->orWhere("j.hr_contact_no", "LIKE", "%{$search}%")
                    ->orWhere("j.skill_id", "LIKE", "%{$search}%")
                    ->orWhere("j.interviewer_address", "LIKE", "%{$search}%")

                    ->orWhere("c.category_nm", "LIKE", "%{$search}%")
                    ->orWhere("sc.sub_category_nm", "LIKE", "%{$search}%")
                    ->orWhere("q.name", "LIKE", "%{$search}%")
                    ->orWhere("jl.type_nm", "LIKE", "%{$search}%")
                    ->orWhere("jt.type_name", "LIKE", "%{$search}%")
                    ->orWhere("wt.type_nm", "LIKE", "%{$search}%")
                    ->orWhere("er.name", "LIKE", "%{$search}%")
                    ->orWhere("s.state_name", "LIKE", "%{$search}%")
                    ->orWhere("ci.city_nm", "LIKE", "%{$search}%")
                    ->orWhere("a.area_nm", "LIKE", "%{$search}%")
                    ->orWhere("z.zipcode", "LIKE", "%{$search}%");
            });
        }

        // ================= FILTERS (ALWAYS APPLY) =================
        $filterableColumns = [
            "preference_type",
            "category_id",
            "sub_category_id",
            "qualification_id",
            "job_level_id",
            "job_type_id",
            "work_type_id",
            "experience_req_id",
            "state_id",
            "city_id",
            "area_id",
            "zipcode_id",
        ];

        foreach ($filterableColumns as $column) {
            if ($request->filled($column)) {
                $query->where("j.$column", $request->$column);
            }
        }

        // ================= SKILLS FILTER =================
        if ($request->filled("skills")) {
            $query->where(function ($q) use ($request) {
                foreach ($request->skills as $skill) {
                    $q->orWhere("j.skill_id", "LIKE", "%{$skill}%");
                }
            });
        }

        // ================= SELECT =================
        $query->addSelect([
            "j.job_id",
            "j.job_title",
            "j.salary_budget",
            "u.name as company_name", // ✅ NEW
            "j.company_address",
            "j.skill_id",
            "j.created_at",
            "c.category_nm",
            "sc.sub_category_nm",
            "jt.type_name as job_type",
            "wt.type_nm as work_type",
            "s.state_name",
            "ci.city_nm",
            "a.area_nm",
        ]);

        $jobs = $query->orderByDesc("j.created_at")->get();

        $jobs->transform(function ($row) {
            $row->applied = (bool) $row->applied;
            return $row;
        });

        return response()->json([
            "status" => true,
            "message" => "Job list fetched successfully",
            "data" => $jobs
        ]);
    }

    public function postJob(Request $request)
    {
        $rules = [
            "user_id" => "required",
            "preference_type" => "required",
            "category_id" => "required",
            "sub_category_id" => "nullable",
            "job_title" => "required",
            "qualification_id" => "nullable",
            "job_level_id" => "nullable",
            "job_type_id" => "nullable",
            "salary_budget" => "nullable",
            "job_timing" => "nullable",
            "age" => "nullable",
            "gender" => "nullable",
            "work_type_id" => "nullable",
            "number_of_openings" => "required",
            "job_description" => "required",
            "interviewer_address" => "nullable",
            "experience_req_id" => "nullable",
            "contact_no" => "nullable",
            "company_website" => "nullable",
            "company_address" => "nullable",
            "state_id" => "nullable",
            "city_id" => "nullable",
            "area_id" => "nullable",
            "zipcode_id" => "nullable",
            "hr_email" => "nullable",
            "hr_contact_no" => "nullable",
            "skill_id" => "nullable|array", // 👈 validate as array
            "datetime" => "nullable",
            "status" => "required",
            "total_apply" => "nullable",
            "remain_opening" => "nullable",
            "rounds" => "nullable|array",
        ];

        $validated = $request->validate($rules);

        // Remove 'rounds' from job insert data
        $data = collect($validated)
            ->except("rounds")
            ->toArray();

        // ✅ Convert skill_id array to JSON before storing
        if (!empty($request->skill_id) && is_array($request->skill_id)) {
            $data["skill_id"] = json_encode($request->skill_id);
        }

        $data["datetime"] = $request->datetime ?? now();
        $data["total_apply"] = $request->total_apply ?? 0;
        $data["remain_opening"] =
            $request->remain_opening ?? $request->number_of_openings;
        $data["created_at"] = now();
        $data["updated_at"] = now();

        $jobId = DB::table("tbl_job")->insertGetId($data);

        // Insert job rounds only if valid data exists
        if (
            is_array($request->rounds) &&
            count(
                array_filter($request->rounds, function ($r) {
                    return !empty($r["round_name"]) || !empty($r["round_desc"]);
                })
            ) > 0
        ) {
            $roundData = [];

            foreach ($request->rounds as $round) {
                $roundData[] = [
                    "job_id" => $jobId,
                    "round_name" => $round["round_name"] ?? "",
                    "round_desc" => $round["round_desc"] ?? "",
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
            }

            DB::table("tbl_job_round")->insert($roundData);
        }

        return response()->json(
            [
                "status" => true,
                "message" => "Job posted successfully",
                "data" => array_merge(["job_id" => $jobId], $data),
            ],
            201
        );
    }

    public function getAppliedJobs(Request $request)
    {
        $userId = $request->user_id;

        if (!$userId) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "user_id is required",
                ],
                400
            );
        }

        // STEP 1: Fetch user and check plan status
        $user = DB::table("users")
            ->where("id", $userId)
            ->first();
        $activePlanId = $user->active_plan_id ?? null;

        $showCompanyDetails = true;
        if (is_null($activePlanId) || $activePlanId == 0) {
            $setting = DB::table("tbl_setting")->first();
            $showCompanySetting = $setting->ShowCompanyDetails ?? 1;

            if ($showCompanySetting == 2) {
                $showCompanyDetails = false;
            }
        }

        // STEP 2: Fetch saved job IDs
        $savedJobIds = DB::table("tbl_job_save")
            ->where("user_id", $userId)
            ->pluck("job_id")
            ->toArray();

        // STEP 3: Fetch applied jobs
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
            ->leftJoin(
                DB::raw("(SELECT h1.*
            FROM tbl_job_apply_history h1
            INNER JOIN (
                SELECT job_apply_id, MAX(created_at) as latest
                FROM tbl_job_apply_history
                WHERE deleted_at IS NULL
                GROUP BY job_apply_id
            ) h2 ON h1.job_apply_id = h2.job_apply_id AND h1.created_at = h2.latest
        ) as jah"),
                "ja.id",
                "=",
                "jah.job_apply_id"
            )
            ->where("ja.user_id", $userId)
            ->whereNull("j.deleted_at")
            ->where("j.status", 1)
            ->orderByDesc("ja.created_at")
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
                "j.salary_budget",
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
                "j.created_at as job_created_at",
                "ja.created_at as applied_at",
                "jah.msg as application_status_msg",
                "jah.created_at as application_status_updated_at",
                "ja.status as apply_status",
                "ja.file_nm",
                "ja.description",
                "ja.datetime as apply_datetime",
            ])
            ->get()
            ->map(function ($job) use ($savedJobIds, $showCompanyDetails) {
                // Add saved flag
                $job->saved = in_array($job->job_id, $savedJobIds);

                // Apply status text
                $statusMap = [
                    0 => "Pending",
                    1 => "Accepted",
                    2 => "Rejected",
                    3 => "Shortlisted",
                ];
                $job->apply_status_text =
                    $statusMap[$job->apply_status] ?? "Unknown";

                // Conditionally hide company details
                if (!$showCompanyDetails) {
                    $job->contact_no = null;
                    $job->company_website = null;
                    $job->company_address = null;
                    $job->hr_email = null;
                    $job->hr_contact_no = null;
                }

                return $job;
            });

        return response()->json(
            [
                "status" => true,
                "message" => "Applied jobs fetched successfully",
                "data" => $appliedJobs,
            ],
            200
        );
    }

    public function getSavedJobs(Request $request)
    {
        $userId = $request->user_id;

        if (!$userId) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "user_id is required",
                ],
                400
            );
        }

        // Step 1: Determine visibility of company details
        $user = DB::table("users")
            ->where("id", $userId)
            ->first();
        $activePlanId = $user->active_plan_id ?? null;

        $showCompanyDetails = true;
        if (is_null($activePlanId) || $activePlanId == 0) {
            $setting = DB::table("tbl_setting")->first();
            $showCompanySetting = $setting->ShowCompanyDetails ?? 1;

            if ($showCompanySetting == 2) {
                $showCompanyDetails = false;
            }
        }

        // Step 2: Get saved jobs with joins
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
            ->where("js.user_id", $userId)
            ->whereNotNull("js.saved_at")
            ->whereNull("js.deleted_at")
            ->whereNull("j.deleted_at")
            ->where("j.status", 1)
            ->orderByDesc("js.created_at")
            ->select([
                "j.job_id",
                "j.user_id",
                "j.preference_type",
                "j.category_id",
                "c.category_nm",
                "j.sub_category_id",
                "sc.sub_category_nm",
                "j.job_title",
                "j.salary_budget",
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
                "j.created_at as job_created_at",
                "js.created_at as saved_at",
            ])
            ->get()
            ->map(function ($job) use ($showCompanyDetails) {
                $job->saved = true;

                if (!$showCompanyDetails) {
                    $job->contact_no = null;
                    $job->company_website = null;
                    $job->company_address = null;
                    $job->hr_email = null;
                    $job->hr_contact_no = null;
                }

                return $job;
            });

        return response()->json(
            [
                "status" => true,
                "message" => "Saved jobs fetched successfully",
                "data" => $savedJobs,
            ],
            200
        );
    }

    public function uploadResume(Request $request)
    {
        // ---- Validation ----
        if (empty($request->user_id)) {
            return response()->json(
                ["status" => false, "message" => "user_id is required"],
                400
            );
        }

        if (!in_array($request->resume_type, [1, 2])) {
            return response()->json(
                ["status" => false, "message" => "resume_type must be 1 or 2"],
                400
            );
        }

        if (!$request->hasFile("file")) {
            return response()->json(
                ["status" => false, "message" => "file is required"],
                400
            );
        }

        $file = $request->file("file");

        if (strtolower($file->getClientOriginalExtension()) !== "pdf") {
            return response()->json(
                ["status" => false, "message" => "file must be a PDF"],
                400
            );
        }

        if ($file->getSize() > 2 * 1024 * 1024) {
            // 2MB
            return response()->json(
                ["status" => false, "message" => "file must not exceed 2MB"],
                400
            );
        }

        // ---- Store file ----
        $fileName =
            time() . "_" . uniqid() . "." . $file->getClientOriginalExtension();
        $publicStorage = public_path("storage");
        if (file_exists($publicStorage) && !is_dir($publicStorage)) {
            @unlink($publicStorage);
        }
        $resumePath = public_path("storage/resumes");
        if (!file_exists($resumePath) || !is_dir($resumePath)) {
            @mkdir($resumePath, 0777, true);
        }
        try {
            $file->move($resumePath, $fileName);
        } catch (\Exception $e) {
            $fallbackPath = storage_path("app/public/resumes");
            if (!file_exists($fallbackPath) || !is_dir($fallbackPath)) {
                @mkdir($fallbackPath, 0777, true);
            }
            $file->move($fallbackPath, $fileName);
        }

        $filePath = $fileName;

        // ---- Insert into tbl_resume & get ID ----
        $resumeId = DB::table("tbl_resume")->insertGetId([
            "user_id" => $request->user_id,
            "file_nm" => $filePath,
            "resume_type" => $request->resume_type,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        return response()->json([
            "status" => true,
            "message" => "Resume uploaded successfully.",
            "data" => [
                "resume_id" => $resumeId,
                "file_nm" => url($filePath),
                "resume_type" => $request->resume_type,
            ],
        ]);
    }

    public function storeResumeData(Request $request)
    {
        // ---- Validation ----
        $requiredFields = [
            "user_id",
            "full_name",
            "email",
            "phone",
            "skills",
            "designation",
            "summary",
            "education",
            'dob',
            'marital_status',
            'address',
            'language_known',
            'gender'
        ];

        foreach ($requiredFields as $field) {
            if (empty($request->$field)) {
                return response()->json(
                    ["status" => false, "message" => "$field is required"],
                    400
                );
            }
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "email must be a valid email address",
                ],
                400
            );
        }

        // ---- Handle profile_img file if available ----
        $profileImgPath = null;
        if ($request->hasFile("profile_img")) {
            $file = $request->file("profile_img");

            // Optional: Validate file type & size
            $allowedExtensions = ["jpg", "jpeg", "png", "webp"];
            if (
                !in_array(
                    strtolower($file->getClientOriginalExtension()),
                    $allowedExtensions
                )
            ) {
                return response()->json(
                    [
                        "status" => false,
                        "message" =>
                            "profile_img must be JPG, JPEG, PNG, or WEBP",
                    ],
                    400
                );
            }

            if ($file->getSize() > 2 * 1024 * 1024) {
                // 2MB limit
                return response()->json(
                    [
                        "status" => false,
                        "message" => "profile_img must not exceed 2MB",
                    ],
                    400
                );
            }

            // Store the file
            $fileName =
                time() .
                "_" .
                uniqid() .
                "." .
                $file->getClientOriginalExtension();
            $file->move(public_path("storage/profile_images/"), $fileName);

            // Store relative path
            $profileImgPath = "storage/profile_images/" . $fileName;
        }

        // ---- Generate unique resume_id ----
        // $resumeId = (string) Str::uuid();

        // ---- Insert into tbl_resume_builder ----
        DB::table("tbl_resume_builder")->insert([
            "user_id" => $request->user_id,
            "resume_id" => $request->resume_id,
            "profile_img" => $profileImgPath,
            "full_name" => $request->full_name,
            "email" => $request->email,
            "phone" => $request->phone,
            "skills" => $request->skills,
            "designation" => $request->designation,
            "summary" => $request->summary,
            "education" => $request->education,
            "dob" => $request->dob,
            "marital_status" => $request->marital_status,
            "address" => $request->address,
            "language_known" => $request->language_known,
            "gender" => $request->gender,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        return response()->json([
            "status" => true,
            "message" => "Resume data stored successfully.",
            "data" => [
                // "resume_id"   => $resumeId,
                "profile_img" => $profileImgPath ? url($profileImgPath) : null,
            ],
        ]);
    }

    public function markJobAsRead(Request $request)
    {
        $request->validate([
            "job_id" => "required|exists:tbl_job,job_id",
            "user_id" => "required|exists:users,id",
        ]);

        $job_id = $request->job_id;
        $user_id = $request->user_id;

        // ────────────────────────── Fetch application
        $application = DB::table("tbl_job_apply")
            ->where("job_id", $job_id)
            ->where("user_id", $user_id)
            ->whereNull("deleted_at")
            ->first();

        if (!$application) {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Application not found",
                ],
                404
            );
        }

        // ────────────────────────── Update only if markAsRead is null
        if (is_null($application->markAsRead)) {
            DB::table("tbl_job_apply")
                ->where("job_id", $job_id)
                ->where("user_id", $user_id)
                ->update([
                    "markAsRead" => 1,
                    "updated_at" => now(),
                ]);

            return response()->json([
                "status" => true,
                "message" => "Job marked as read successfully",
                "mark_as_read" => true,
            ]);
        }

        // Already marked
        return response()->json([
            "status" => true,
            "message" => "Job already marked as read",
            "mark_as_read" => true,
        ]);
    }

    public function toggleJobStatus(Request $request)
    {
        $request->validate([
            "job_id" => "required|exists:tbl_job,job_id",
        ]);

        $job_id = $request->job_id;

        // Get current status
        $job = DB::table("tbl_job")
            ->where("job_id", $job_id)
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

        // Toggle status (1 -> 2, 2 -> 1)
        $newStatus = $job->status == 1 ? 2 : 1;

        $updateData = [
            "status" => $newStatus,
            "updated_at" => now(),
        ];

        // If job becomes active again
        if ($newStatus == 1) {

            $updateData["created_at"] = now();
        }

        DB::table("tbl_job")
            ->where("job_id", $job_id)
            // ->update(["status" => $newStatus]);
            ->update($updateData);

        return response()->json([
            "status" => true,
            "message" => "Job status updated successfully",
            "job_id" => $job_id,
            "new_status" => $newStatus,
        ]);
    }
}