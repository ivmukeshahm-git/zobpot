<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Job;
use App\Models\JobApply;
use App\Models\JobApplyHistory;
use App\Models\JobRound;
use App\Models\JobRoundComplete;
use App\Models\State;
use App\Models\Resume;
use App\Models\Setting;

use Illuminate\Http\Request;
use App\Models\User; // or CandidateProfile if it's a separate model
use App\Helpers\WhatsappHelper; // or CandidateProfile if it's a separate model
use App\Models\Zipcode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class ProfileController extends Controller
{
    public function CandidateProfile(Request $request, $id)
    {
        $rules = [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'contact_no' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'zipcode' => 'required',
            'address' => 'required',
            'profile_img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'resume' => 'nullable|mimes:pdf|max:2048',
            'gender' => 'required|in:1,2,3', 
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 200);
        }

        try {
            $state_id = 0;
            $city_id = 0;
            $area_id = 0;
            $zipcode_id = 0;

            // STATE
            if ($request->state_id_hidden != null) {
                $CheckState = State::find($request->state_id_hidden);
                if ($CheckState) {
                    $state_id = $CheckState->state_id;
                }
            } elseif ($request->state_id) {
                $AddState = State::create([
                    'state_name' => $request->state_id,
                    'country_id' => 1 // default country ID if applicable
                ]);
                $state_id = $AddState->state_id;
            }

            // CITY
            if ($request->city_id_hidden != null) {
                $CheckCity = City::find($request->city_id_hidden);
                if ($CheckCity) {
                    $city_id = $CheckCity->city_id;
                }
            } elseif ($request->city_id) {
                $AddCity = City::create([
                    'city_nm' => $request->city_id,
                    'state_id'  => $state_id
                ]);
                $city_id = $AddCity->city_id;
            }

            // AREA
            if ($request->area_id_hidden != null) {
                $CheckArea = Area::find($request->area_id_hidden);
                if ($CheckArea) {
                    $area_id = $CheckArea->area_id;
                }
            } elseif ($request->area_id) {
                $AddArea = Area::create([
                    'area_nm' => $request->area_id,
                    'city_id'   => $city_id,
                    'state_id' => $state_id,
                ]);
                $area_id = $AddArea->area_id;


                if ($request->pincode_id_hidden != null) {
                    $AddZip = Zipcode::create([
                        'zipcode'  => $request->zipcode,
                        'city_id'  => $city_id,
                        'area_id'  => $area_id,
                        'state_id' => $state_id,
                    ]);
                    $zipcode_id = $AddZip->zipcode_id;
                }
            }


            // PINCODE
            if ($request->pincode_id_hidden != null) {
                $CheckZip = Zipcode::find($request->pincode_id_hidden);
                if ($CheckZip) {
                    $zipcode_id = $CheckZip->zipcode_id;
                }
            } elseif ($request->zipcode) {
                $AddZip = Zipcode::create([
                    'zipcode'  => $request->zipcode,
                    'city_id'  => $city_id,
                    'area_id'  => $area_id,
                    'state_id' => $state_id,
                ]);
                $zipcode_id = $AddZip->zipcode_id;
            }


            $user = User::findOrFail($id); // ❌ No creation, only update

            $user->name = $request->full_name;
            $user->email = $request->email;
            $user->contact_no = $request->contact_no;
            $user->state_id = $state_id;
            $user->city_id = $city_id;
            $user->area_id = $area_id;
            $user->zipcode_id = $zipcode_id;
            $user->address = $request->address;
            $user->personal_website = $request->personal_website;
            $user->designation = $request->designation;
            $user->gender = $request->gender;


            // ✅ Handle profile image upload
            if ($request->hasFile('profile_img')) {
                $image = $request->file('profile_img');
                $ext = $image->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $ext;

                $uploadPath = public_path('uploads/profile');

                // Ensure directory exists
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                $resizedImage = Image::make($image)
                    ->fit(100, 100) // ✅ force exact 100x100 with crop
                    ->encode($ext, 60); // Compress to 60% quality

                // Save new image
                $resizedImage->save($uploadPath . '/' . $imageName);

                // Remove old image
                if (!empty($user->profile_img) && file_exists($uploadPath . '/' . $user->profile_img) && $user->profile_img != 'profile.png') {
                    unlink($uploadPath . '/' . $user->profile_img);
                }


                // Update user
                $user->profile_img = $imageName;
                $user->save();
            }


            if ($request->hasFile('cover_img')) {
                $image = $request->file('cover_img');
                $ext = $image->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $ext;

                $uploadPath = public_path('uploads/profile');

                // Ensure directory exists
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                $resizedImage = Image::make($image)
                    ->fit(1400, 400) // ✅ force exact 1400x400 with crop
                    ->encode($ext, 60); // Compress to 60% quality

                // Save new image
                $resizedImage->save($uploadPath . '/' . $imageName);

                // Remove old image
                if (!empty($user->cover_img) && file_exists($uploadPath . '/' . $user->cover_img)) {
                    unlink($uploadPath . '/' . $user->cover_img);
                }


                // Update user
                $user->cover_img = $imageName;
                $user->save();
            }


            if ($request->hasFile('resume')) {
                Log::info('✅ Resume file found in request.');

                $file = $request->file('resume');

                // Generate clean filename
                $username = Str::slug($user->name); // Corrected: removed `title:` syntax error
                $extension = $file->getClientOriginalExtension();
                $filename = $username . '_' . uniqid() . '_resume.' . $extension;

                Log::info('📁 Generated filename: ' . $filename);

                // ✅ Use storeAs() to set custom file name
                $path = $request->file('resume')->storeAs('resumes', $filename, 'public');

                Log::info('📂 Stored at: ' . $path);
                $resume = Resume::updateOrCreate(
                    ['user_id' => $user->id], // match condition
                    [
                        // 'file_nm' => $path,
                        'file_nm' => $filename,
                        'resume_type' => 1,
                    ]
                );

                Log::info('✅ Resume saved in DB: ' . $user->resume_nm);
            } else {
                Log::error('❌ Resume file not found in request.');
            }

            // ✅ Handle image removal
            if ($request->remove_img == 1 && $user->profile_img) {
                if (file_exists(public_path('uploads/profile/' . $user->profile_img))) {
                    unlink(public_path('uploads/profile/' . $user->profile_img));
                }
                $user->profile_img = null;
            }

            $user->save();

            return response()->json([
                'status' => 1,
                'message' => 'Profile updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function CandidateProfileAboutSkill(Request $request, $id)
    {
        $rules = [
            'about'           => 'required|string',
            'category_id'     => 'required|integer',
            'sub_category_id' => 'required|integer',
            'skills_hidden'   => 'required', // This should be an array of skill names or IDs
            // 'experience'      => [
            //     'required',
            //     'regex:/^(Fresher|[1-9][0-9]*\s(month|months|year|years))$/i'
            // ],
            'experience' => 'required|string'
        ];

        $messages = [
        'experience.regex' => 'Experience must be like Fresher, 7 months, or 1 year'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first()
            ], 200);
        }

        try {
            $user = User::findOrFail($id);

            $user->about = $request->input('about');
            $user->category_id   = $request->input('category_id');
            $user->sub_category_id = $request->input('sub_category_id');
            // $user->experience = $request->input('Experience');
            // $user->experience = strtolower(trim($request->input('experience')));
            $user->experience = strtolower(trim($request->experience));

            $user->expected_salary = $request->input('expected_salary');
            $user->languages = explode(",",$request->input('selectedLanguages'));
            $user->skills_id   = json_encode(explode(',', $request->input('skills_hidden'))); // Convert array to comma-separated string

            $user->save();

            return response()->json([
                'status'  => 1,
                'message' => 'Profile about and skills updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Something went wrong.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function CompanyProfile(Request $request, $id)
    {
        $rules = [
            'company_nm' => 'required|string|max:255',
            'email' => 'required|email',
            'contact_no' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'zipcode' => 'required',
            'address' => 'required',
            'profile_img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 200);
        }

        try {
            $state_id = 0;
            $city_id = 0;
            $area_id = 0;
            $zipcode_id = 0;

            // STATE
            if ($request->state_id_hidden != null) {
                $CheckState = State::find($request->state_id_hidden);
                if ($CheckState) {
                    $state_id = $CheckState->state_id;
                }
            } elseif ($request->state_id) {
                $AddState = State::create([
                    'state_name' => $request->state_id,
                    'country_id' => 1 // default country ID if applicable
                ]);
                $state_id = $AddState->state_id;
            }

            // CITY
            if ($request->city_id_hidden != null) {
                $CheckCity = City::find($request->city_id_hidden);
                if ($CheckCity) {
                    $city_id = $CheckCity->city_id;
                }
            } elseif ($request->city_id) {
                $AddCity = City::create([
                    'city_nm' => $request->city_id,
                    'state_id'  => $state_id
                ]);
                $city_id = $AddCity->city_id;
            }

            // AREA
            if ($request->area_id_hidden != null) {
                $CheckArea = Area::find($request->area_id_hidden);
                if ($CheckArea) {
                    $area_id = $CheckArea->area_id;
                }
            } elseif ($request->area_id) {
                $AddArea = Area::create([
                    'area_nm' => $request->area_id,
                    'city_id'   => $city_id,
                    'state_id' => $state_id,
                ]);
                $area_id = $AddArea->area_id;


                if ($request->pincode_id_hidden != null) {
                    $AddZip = Zipcode::create([
                        'zipcode'  => $request->zipcode,
                        'city_id'  => $city_id,
                        'area_id'  => $area_id,
                        'state_id' => $state_id,
                    ]);
                    $zipcode_id = $AddZip->zipcode_id;
                }
            }

            // PINCODE
            if ($request->pincode_id_hidden != null) {
                $CheckZip = Zipcode::find($request->pincode_id_hidden);
                if ($CheckZip) {
                    $zipcode_id = $CheckZip->zipcode_id;
                }
            } elseif ($request->zipcode) {
                $AddZip = Zipcode::create([
                    'zipcode'  => $request->zipcode,
                    'city_id'  => $city_id,
                    'area_id'  => $area_id,
                    'state_id' => $state_id,
                ]);
                $zipcode_id = $AddZip->zipcode_id;
            }


            $user = User::findOrFail($id); // ❌ No creation, only update

            $user->name = $request->company_nm;
            $user->email = $request->email;
            $user->contact_no = $request->contact_no;
            $user->state_id = $state_id;
            $user->city_id = $city_id;
            $user->area_id = $area_id;
            $user->zipcode_id = $zipcode_id;
            $user->address = $request->address;
            $user->personal_website = $request->company_website;
            $user->designation = $request->designation;

            // ✅ Handle profile image upload
            if ($request->hasFile('profile_img')) {
                $image = $request->file('profile_img');
                $ext = $image->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $ext;

                $uploadPath = public_path('uploads/profile');

                // Ensure directory exists
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                $resizedImage = Image::make($image)
                    ->fit(100, 100) // ✅ force exact 100x100 with crop
                    ->encode($ext, 60); // Compress to 60% quality

                // Save new image
                $resizedImage->save($uploadPath . '/' . $imageName);

                // Remove old image
                if (!empty($user->profile_img) && file_exists($uploadPath . '/' . $user->profile_img  && $user->profile_img != 'profile.png')) {
                    unlink($uploadPath . '/' . $user->profile_img);
                }

                // Update user
                $user->profile_img = $imageName;
                $user->save();
            }


            if ($request->hasFile('cover_img')) {
                $image = $request->file('cover_img');
                $ext = $image->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $ext;

                $uploadPath = public_path('uploads/profile');

                // Ensure directory exists
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                $resizedImage = Image::make($image)
                    ->fit(1400, 400) // ✅ force exact 1400x400 with crop
                    ->encode($ext, 60); // Compress to 60% quality

                // Save new image
                $resizedImage->save($uploadPath . '/' . $imageName);

                // Remove old image
                if (!empty($user->cover_img) && file_exists($uploadPath . '/' . $user->cover_img)) {
                    unlink($uploadPath . '/' . $user->cover_img);
                }

                // Update user
                $user->cover_img = $imageName;
                $user->save();
            }

            // ✅ Handle image removal
            if ($request->remove_img == 1 && $user->profile_img) {
                if (file_exists(public_path('uploads/profile/' . $user->profile_img))) {
                    unlink(public_path('uploads/profile/' . $user->profile_img));
                }
                $user->profile_img = null;
            }

            $user->save();

            return response()->json([
                'status' => 1,
                'message' => 'Profile updated successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Profile upload error: ' . $e->getMessage());
            return response()->json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }


    public function CompanyProfileAbout(Request $request, $id)
    {
        $rules = [
            'company_desc' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 200);
        }

        try {
            $user = User::findOrFail($id);

            $user->company_desc = $request->input('company_desc');

            $user->save();

            return response()->json([
                'status'  => 1,
                'message' => 'Company profile updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }


    public function MyJobCandidateViewDetail(Request $request)
    {
        $user = Auth::user();
        $job_id = $request->input('job_id');

        $jobData = DB::table('tbl_job_apply as a')
            ->select(
                'a.*',
                'o.*',
                'a.status as apply_status',
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
                'm.profile_img',
                'p.msg as history_msg',
                'p.datetime as history_datetime',
            )
            ->leftJoin('tbl_job_apply_history as p', 'p.job_apply_id', '=', 'a.id')
            ->join('tbl_job as o', 'o.job_id', '=', 'a.job_id') // ✅ fixed here

            // Now joining everything based on job o.*
            ->join('tbl_job_category as b', 'o.category_id', '=', 'b.category_id')
            ->join('tbl_sub_category as c', 'o.sub_category_id', '=', 'c.sub_category_id')
            ->join('tbl_min_qualification as d', 'o.qualification_id', '=', 'd.qualification_id')
            ->join('tbl_job_level as e', 'o.job_level_id', '=', 'e.job_level_id')
            ->join('tbl_job_type as f', 'o.job_type_id', '=', 'f.job_type_id')
            ->join('tbl_work_type as g', 'o.work_type_id', '=', 'g.work_type_id')
            ->join('tbl_experience_req as h', 'o.experience_req_id', '=', 'h.experience_req_id')
            ->join('tbl_state as i', 'o.state_id', '=', 'i.state_id')
            ->join('tbl_city as j', 'o.city_id', '=', 'j.city_id')
            ->join('tbl_area as k', 'o.area_id', '=', 'k.area_id')
            ->join('tbl_zipcode as l', 'o.zipcode_id', '=', 'l.zipcode_id')
            ->join('users as m', 'o.user_id', '=', 'm.id')
            ->where('a.job_id', $job_id)
            ->where('a.user_id', $user->id)
            ->first();


        $latestSub = DB::table('tbl_round_complete')
            ->select('round_id', 'user_id', DB::raw('MAX(datetime) as latest_datetime'))
            ->where('job_id', $job_id)
            ->groupBy('round_id', 'user_id');

        $JobRoundComplete = DB::table('tbl_job_round as a')
            ->joinSub($latestSub, 'latest', function ($join) {
                $join->on('a.id', '=', 'latest.round_id');
            })
            ->join('tbl_round_complete as b', function ($join) {
                $join->on('b.round_id', '=', 'latest.round_id')
                    ->on('b.user_id', '=', 'latest.user_id');
            })
            ->where('b.job_id', $job_id)
            ->where('b.user_id', $user->id)
            ->select(
                'a.id',
                'a.job_id',
                'a.round_name',
                'a.round_desc',
                'b.user_id',
                'b.hr_contact_no',
                'b.hr_email',
                'b.interview_address',
                'b.datetime as interview_datetime',
                'b.complete_datetime',
                'b.status',
                'b.remarks',
            )
            ->orderBy('a.id')
            ->get();

        if (!$jobData) {
            return response()->json(['status' => 0, 'message' => 'Job not found'], 404);
        }
        $Setting = Setting::where('id', 1)->first();

        $htmlContent = view('website.jobs-partials-view.job-detail', compact('jobData', 'JobRoundComplete', 'Setting', 'user'))->render();

        return response()->json([
            'status' => 1,
            'htmlContent' => $htmlContent,
            'data' => $JobRoundComplete
        ]);
    }


    public function MyJobApplyHistoryCompany(Request $request)
    {

        $job_id = $request->input('job_id');

        $latestRoundSubquery = DB::table('tbl_round_complete')
            ->select('job_id', DB::raw('MAX(datetime) as latest_datetime'))
            ->groupBy('job_id');

        $roundCompleteJoin = DB::table('tbl_round_complete as rc')
            ->joinSub($latestRoundSubquery, 'latest_round', function ($join) {
                $join->on('rc.job_id', '=', 'latest_round.job_id')
                    ->on('rc.datetime', '=', 'latest_round.latest_datetime');
            })
            ->select('rc.job_id', 'rc.datetime');

        $latestHistorySubquery = DB::table('tbl_job_apply_history')
            ->select('job_apply_id', DB::raw('MAX(datetime) as latest_datetime'))
            ->groupBy('job_apply_id');
        $jobApplicants = DB::table('tbl_job_apply as a')
            ->select(
                'a.id',
                'a.user_id',
                'a.job_id',
                'a.file_nm',
                'a.status',
                'b.name',
                'b.email',
                'b.contact_no',
                'h.msg as history_msg',
                'h.datetime as history_datetime',
                'rc.datetime as interview_datetime'
            )
            ->join('users as b', 'a.user_id', '=', 'b.id')
            ->leftJoinSub($roundCompleteJoin, 'rc', function ($join) {
                $join->on('a.job_id', '=', 'rc.job_id');
            })
            ->leftJoinSub($latestHistorySubquery, 'latest', function ($join) {
                $join->on('latest.job_apply_id', '=', 'a.id');
            })
            ->leftJoin('tbl_job_apply_history as h', function ($join) {
                $join->on('h.job_apply_id', '=', 'a.id')
                    ->on('h.datetime', '=', 'latest.latest_datetime');
            })
            ->where('a.job_id', $job_id)
            ->groupBy(
                'a.id',
                'a.user_id',
                'a.job_id',
                'a.file_nm',
                'a.status',
                'b.name',
                'b.email',
                'b.contact_no',
                'h.msg',
                'h.datetime',
                'rc.datetime'
            )
            ->orderByDesc('a.id')
            ->paginate(10)
            ->appends([
                'job_id' => $job_id,
            ]);

        // $JobData = Job::findOrFail($job_id);

        if (!$job_id) {
            return response()->json([
                'status' => 0,
                'message' => 'Job ID missing'
            ]);
        }

        $JobData = Job::find($job_id);

        if (!$JobData) {
            return response()->json([
                'status' => 0,
                'message' => 'Invalid Job ID'
            ]);
        }

        if ($jobApplicants->isEmpty()) {
            return response()->json(['status' => 0, 'message' => 'No job history found.'], 404);
        }

        // ✅ Pass paginated data to view
        $htmlContent = view('website.jobs-partials-view.apply-history', compact('jobApplicants', 'JobData'))->render();

        return response()->json([
            'status' => 1,
            'htmlContent' => $htmlContent
        ]);
    }

    public function FetchUserJobRound(Request $request)
    {
        $job_id  = $request->input('job_id');
        $user_id = $request->input('user_id');

        // $JobRound = DB::table('tbl_round_complete as a')
        //     ->join('tbl_job_round as b', 'a.round_id', '=', 'b.id')
        //     ->select('a.id', 'a.round_id', 'b.round_name', 'b.round_desc', 'a.status')
        //     ->where('a.job_id', $job_id)
        //     ->where('a.user_id', $user_id)
        //     ->groupBy('a.round_id', 'b.round_name', 'b.round_desc', 'a.status', 'a.id') // full groupBy for strict SQL
        //     ->get();
        $JobRound = DB::table('tbl_job_round as r')
        ->leftJoin('tbl_round_complete as c', function ($join) use ($job_id, $user_id) {
            $join->on('c.round_id', '=', 'r.id')
                ->where('c.job_id', $job_id)
                ->where('c.user_id', $user_id);
        })
        ->select(
            'r.id as round_id',
            'r.round_name',
            'r.round_desc',
            'c.status',
            'c.datetime'
        )
        ->where('r.job_id', $job_id)
        ->whereNull('r.deleted_at')
        ->get();


        return response()->json($JobRound);
    }


    public function ScheduleInterview(Request $request)
    {
        $rules = [
            // 'interview_job_id'     => 'required|exists:tbl_round_complete,job_id',
            'interview_job_id' => 'required|exists:tbl_job,job_id',
            'interview_user_id'   => 'required|exists:users,id',
            'interview_datetime'  => 'nullable|date',
            'hr_contact_no'       => 'required|string|max:20',
            'hr_email'            => 'required|email|max:100',
            'interviewer_address' => 'required|string|max:255',
            'round_ids'           => 'required|array|min:1',
            'round_ids.*'         => 'exists:tbl_job_round,id',
            'interview_job_apply_id' => 'required|exists:tbl_job_apply,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 200);
        }

        $job_id = $request->input('interview_job_id');
        $user_id = $request->input('interview_user_id');
        $interviewDatetime = $request->input('interview_datetime');
        $hrContactNo = $request->input('hr_contact_no');
        $hrEmail = $request->input('hr_email');
        $interviewAddress = $request->input('interviewer_address');
        $interview_job_apply_id = $request->input('interview_job_apply_id');
        $round_ids = $request->input('round_ids');

        try {
            // Update apply job status
            $applyjob = JobApply::findOrFail($interview_job_apply_id);
            $applyjob->status = 4;
            $applyjob->save();

            $totalUpdated = 0;

            // foreach ($round_ids as $ids) {
            //     $affected = JobRoundComplete::where('job_id', $job_id)->where('user_id', $user_id)
            //         ->where('round_id', $ids)
            //         ->update([
            //             'hr_contact_no'     => $hrContactNo,
            //             'hr_email'          => $hrEmail,
            //             'interview_address' => $interviewAddress,
            //             'datetime'          => $interviewDatetime,
            //         ]);

            //     $totalUpdated += $affected;
            // }
            foreach ($round_ids as $ids) {

                JobRoundComplete::updateOrCreate(
                    [
                        'job_id'   => $job_id,
                        'user_id'  => $user_id,
                        'round_id' => $ids,
                    ],
                    [
                        'hr_contact_no'     => $hrContactNo,
                        'hr_email'          => $hrEmail,
                        'interview_address' => $interviewAddress,
                        'datetime'          => $interviewDatetime,
                        'status'            => 0,
                    ]
                );
            }


            // if ($totalUpdated === 0) {
            //     return response()->json([
            //         'status' => 0,
            //         'message' => 'No interview records were found or updated.',
            //     ], 200);
            // }

            $user = User::find($applyjob->user_id);
            $job = Job::find($applyjob->job_id);
            $company = User::find($job->user_id);
            $round = JobRound::whereIn('id', $round_ids)
                ->pluck('round_name')
                ->implode(',');
            $contactPerson =$company->name.'|'.$hrContactNo.'|'.$hrEmail;
            WhatsappHelper::sendTemplate($user->contact_no, 'candidate_interview_schdule', [$user->name,$job->job_title.'for('.$round.')',$contactPerson,$interviewDatetime,$interviewAddress]);
//            candidate_interview_schdule

//            dd($helper);
            return response()->json([
                'status' => 1,
                'message' => 'Interview(s) scheduled successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to schedule interview.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function UpdateApplicationStatus(Request $request)
    {
        $rules = [
            'application_status' => 'required|string|max:50',
            'remarks'            => 'nullable|string|max:500',
            'status_job_id'             => 'required|string|max:20',
            'status_user_id'             => 'required|string|max:20',
            'job_apply_id'       => 'required|integer|exists:tbl_job_apply,id',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ], 200);
        }

        $application_status = $request->input('application_status');
        $remarks            = $request->input('remarks');
        $job_id             = $request->input('status_job_id');
        $user_id             = $request->input('status_user_id');
        $job_apply_id       = $request->input('job_apply_id');
        // $rounds             = $request->input('round_ids', []);

        $jobApply = JobApply::findOrFail($job_apply_id);

//        dd($request->all());
        // Update job application status
        if ($application_status === "Selected") {
            $jobApply->status = 1;

            if (!empty($rounds)) {
                foreach ($rounds as $round_id) {
                    JobRoundComplete::where('job_id', $job_id)
                        ->where('user_id', $user_id)
                         ->where('round_id', $round_id)
                        ->update([
                            'status' => 1,
                            'complete_datetime' => now(),
                            'remarks' => $remarks,
                        ]);
                }

                $user = User::find($jobApply->user_id);
                $job = Job::find($jobApply->job_id);
                $company = User::find($job->user_id);
                $round = JobRound::whereIn('id', $rounds)
                    ->pluck('round_name')
                    ->implode(',');
                $contactPerson =$company->name;
                WhatsappHelper::sendTemplate($user->contact_no, 'interview_status_update', [$user->name,$job->job_title.'for('.$round.')',$contactPerson]);
                WhatsappHelper::sendTemplate($user->contact_no, 'interview_selected', [$user->name,$job->job_title,$contactPerson,$contactPerson]);

            } else {
                // If no round is selected, mark all as completed
                JobRoundComplete::where('job_id', $job_id)
                    ->where('user_id', $user_id)
                    ->whereNull('remarks')
                    ->update([
                        'status' => 1,
                        'complete_datetime' => now(),
                        'remarks' => $remarks,
                    ]);

                $user = User::find($jobApply->user_id);
                $job = Job::find($jobApply->job_id);
                $company = User::find($job->user_id);
                $round = "All Round ";
                $contactPerson =$company->name;
                WhatsappHelper::sendTemplate($user->contact_no, 'interview_status_update', [$user->name,$round,$contactPerson]);
                WhatsappHelper::sendTemplate($user->contact_no, 'interview_selected', [$user->name,$job->job_title,$contactPerson,$contactPerson]);

            }
        } elseif ($application_status === "Rejected") {
            $jobApply->status = 2;
            if (!empty($rounds)) {
                foreach ($rounds as $round_id) {
                    JobRoundComplete::where('job_id', $job_id)
                        ->where('user_id', $user_id)
                        ->where('round_id', $round_id)
                        ->update([
                            'status' => 1,
                            'complete_datetime' => now(),
                            'remarks' => $remarks,
                        ]);
                }
            } else {
                // If no round is selected, mark all as completed
                JobRoundComplete::where('job_id', $job_id)
                    ->where('user_id', $user_id)
                    ->update([
                        'status' => 1,
                        'complete_datetime' => now(),
                        'remarks' => $remarks,
                    ]);
            }

            $user = User::find($jobApply->user_id);
            $job = Job::find($jobApply->job_id);
            $company = User::find($job->user_id);
            $round = "All Round ";
            $contactPerson =$company->name;
            WhatsappHelper::sendTemplate($user->contact_no, 'candidate_reject', [$user->name,$job->job_title]);

        } else {
               // 🔥 application_status = ROUND ID
                JobRoundComplete::where('job_id', $job_id)
                    ->where('user_id', $user_id)
                    ->where('round_id', $application_status)   // ✅ MAIN FIX
                    ->update([
                        'status' => 1,
                        'complete_datetime' => now(),
                        'remarks' => $remarks
                    ]);

                // fetch updated round
                $jobComplete = JobRoundComplete::where('job_id', $job_id)
                    ->where('user_id', $user_id)
                    ->where('round_id', $application_status)
                    ->first();

                if (!$jobComplete) {
                    return response()->json([
                        'status' => 0,
                        'message' => 'Selected round not found'
                    ]);
                }

                $round = JobRound::find($application_status);
                $user = User::find($jobApply->user_id);
                $job = Job::find($jobApply->job_id);
                $company = User::find($job->user_id);
//                $round = "All Round ";
                $contactPerson =$company->name;
                //  $round = JobRound::where('id', $jobComplete->round_id)->first();
                WhatsappHelper::sendTemplate($user->contact_no, 'interview_status_update', [$user->name,$round->round_name,$contactPerson]);

        }

        $jobApply->save();


        // Save remarks in job application history
        if (!is_null($remarks)) {
            JobApplyHistory::updateOrCreate(
                ['job_apply_id' => $job_apply_id, 'job_id' => $job_id, 'user_id' => $user_id],
                ['msg' => $remarks]
            );
        }

        return response()->json([
            'status' => 1,
            'message' => 'Application status updated successfully.',
            'job_id'  => $job_id
        ], 200);
    }

    public function ApplyApplicationRejectUpdate(Request $request)
    {
        $rules = [
            'status'    => 'required|in:0,1,2', // 0=Pending, 1=Approved, 2=Rejected
            'message'   => 'nullable|string',
            'apply_id'  => 'required|exists:tbl_job_apply,id',
        ];

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 200);
        }

        DB::beginTransaction();

        try {
            // ✅ Update tbl_job_apply
            $apply = JobApply::where('id', $request->apply_id)->first();
            $apply->status = $request->status;
            $apply->datetime = now();
            $apply->save();

            // ✅ Insert into tbl_job_apply_history
            JobApplyHistory::create([
                'user_id'       => auth()->id(), // adjust if needed
                'job_id'        => $apply->job_id,
                'job_apply_id'  => $apply->id,
                'msg'           => $request->message ?? '',
                'datetime'      => now(),
            ]);

            $user = User::find($apply->user_id);
            $job = Job::find($apply->job_id);
//            job_title
//            candidate_shortlist_interview
            WhatsappHelper::sendTemplate($user->contact_no, 'candidate_reject', [$user->name,$job->job_title]);

            DB::commit();

            return response()->json([
                'status'  => 1,
                'message' => 'Application status updated successfully.',
                'job_id'  => $apply->job_id
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'status'  => 0,
                'message' => 'Something went wrong. Please try again.',
                'error'   => $th->getMessage() // optional
            ], 500);
        }
    }


    public function ApplicationAddtoshortlist(Request $request)
    {
        $rules = [
            'id'  => 'required|exists:tbl_job_apply,id',
        ];

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()], 200);
        }

        DB::beginTransaction();

        try {
            // ✅ Update tbl_job_apply
            $apply = JobApply::where('id', $request->id)->first();
            $apply->status = 3;
            $apply->save();

            DB::commit();


            $user = User::find($apply->user_id);
            $job = Job::find($apply->job_id);
            $company =User::find($job->user_id);
//            job_title
//            candidate_shortlist_interview
            WhatsappHelper::sendTemplate($user->contact_no, 'candidate_shortlist_interview', [$user->name,$job->job_title,$company->name,$company->name]);


            return response()->json([
                'status'  => 1,
                'message' => 'Application Shortlist Successfully.',
                'job_id'  => $apply->job_id 
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'status'  => 0,
                'message' => 'Something went wrong. Please try again.',
                'error'   => $th->getMessage() // optional
            ], 500);
        }
    }
   public function changeJobStatus(Request $request)
{
    $request->validate([
        'job_id' => 'required|exists:tbl_job,job_id',
        'status' => 'required|in:0,1,2'
    ]);

    $job = Job::where('job_id', $request->job_id)->first();

    if (!$job) {
        return response()->json([
            'status' => false,
            'message' => 'Job not found!'
        ]);
    }

    $job->status = $request->status;
    $job->save();

    return response()->json([
        'status' => true,
        'message' => 'Status Updated Successfully!',
        'new_status' => $job->status
    ]);
}


}
