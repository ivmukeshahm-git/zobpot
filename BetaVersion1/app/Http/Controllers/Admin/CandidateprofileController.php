<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Education;
use App\Models\Jobtype;
use App\Models\JobCategory;
use App\Models\State;
use App\Models\User;
use App\Models\WorkExperience;
use App\Models\Worktype;
use App\Models\Zipcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\StaffActivityController;


class CandidateprofileController extends Controller
{
    public function index(Request $request, $id)
    {
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
                'tbl_sub_category.sub_category_nm',
            ])
            ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
            ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
            ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'users.area_id')
            ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')
            ->leftJoin('tbl_job_category', 'tbl_job_category.category_id', '=', 'users.category_id') // <-- New join
            ->leftJoin('tbl_sub_category', 'tbl_sub_category.sub_category_id', '=', 'users.sub_category_id') // <-- New join
            ->where('users.id', $id)
            ->whereNull('users.deleted_at')
            ->first();


        $SaveJobData = DB::table('tbl_job_save as s')
            ->select([
                's.*',
                'j.*',
                'w.type_nm as work_type_name',
            ])
            ->leftJoin('tbl_job as j', 's.job_id', '=', 'j.job_id')
            ->leftJoin('tbl_work_type as w', 'j.work_type_id', '=', 'w.work_type_id')
            ->where('s.user_id', $id)
            ->whereNull('j.deleted_at') // only non-deleted jobs
            ->orderBy('j.job_id', 'desc')
            ->get();

        $states = State::select('state_id', 'state_name')->get(); // replace with your table column names

        $CategoryData = JobCategory::get();
        $WorkExperienceData = WorkExperience::select(
            'tbl_work_experience.*',
            'tbl_job_type.type_name as job_type_name',
            'tbl_work_type.type_nm as work_type_name'
        )
            ->join('tbl_job_type', 'tbl_job_type.job_type_id', '=', 'tbl_work_experience.job_type_id')
            ->join('tbl_work_type', 'tbl_work_type.work_type_id', '=', 'tbl_work_experience.work_type_id')
            ->where('tbl_work_experience.user_id', $id)
            ->get();

        $EducationData = Education::where('user_id', $id)->get();

        $WorktypeData = Worktype::get();
        $JobtypeData = Jobtype::get();

        $PlanHistoryData = DB::table('tbl_plan_history as a')
            ->join('tbl_plan_pricing as b', 'a.plan_id', '=', 'b.plan_id')
            ->leftJoin('users as c', 'a.user_id', '=', 'c.id')
            ->where('a.user_id', $id)
            ->select([
                'a.*',
                'b.plan_name',
                'b.plan_price',
                DB::raw("CASE WHEN a.plan_id = c.active_plan_id THEN 'Active' ELSE 'Inactive' END as status")
            ])
            ->get();

        $MyjobData = DB::table('tbl_job_apply as a')
            ->select(
                'a.*',
                'b.job_title',
                'b.company_address',
                'b.datetime',
                'b.skill_id',
                'c.type_nm as work_type_name'
            )
            ->join('tbl_job as b', 'a.job_id', '=', 'b.job_id')
            ->join('tbl_work_type as c', 'b.work_type_id', '=', 'c.work_type_id')
            ->where('a.user_id', $id)
            ->orderBy('a.datetime', 'desc')  // ✅ Correct orderBy usage
            ->get();


        // Load the Eloquent User when possible; fall back to the query result object
        $user = User::find($id);
        if (!$user) {
            // $userData is a stdClass from the query; use it for completion calculation
            $user = $userData;
        }

        $CandidateProfileComplete = 0;
        if ($user) {
            $CandidateProfileComplete = $this->calculateProfileCompletion($user);
        }
        return view('admin.candidateprofile.candidate-profile', compact('userData', 'SaveJobData', 'states', 'CategoryData', 'WorkExperienceData', 'EducationData', 'WorktypeData', 'JobtypeData', 'PlanHistoryData', 'CandidateProfileComplete', 'MyjobData'));
    }

    public function calculateProfileCompletion($user)
    {
        $fields = [
            'name',
            'email',
            'contact_no',
            'city_id',
            'area_id',
            'state_id',
            'zipcode_id',
            'address',
            'category_id',
            'sub_category_id',
            'skills_id',
            'about',
        ];

        $filled = 0;

        foreach ($fields as $field) {
            $value = $user->{$field};

            // Consider as filled if not null and not an empty string (""), even if it's 0
            if (!is_null($value) && $value !== '') {
                $filled++;
            }
        }

        $total = count($fields);
        $completion = round(($filled / $total) * 100);

        return $completion;
    }



    public function CandidateProfile(Request $request)
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
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
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

            $userId = $request->user_id;

            $user = User::findOrFail($userId); // ❌ No creation, only update

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


            $user->save();

            StaffActivityController::insertActivity(Auth::user()->id, 'Candidate Profile update Successfully.');


            return response()->json([
                'status' => 1,
                'message' => 'Profile updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function CandidateProfileAboutSkill(Request $request)
    {
        $rules = [
            'about'           => 'required|string|max:500',
            'category_id'     => 'required|integer',
            'sub_category_id' => 'required|integer',
            'skills_hidden'   => 'required', // This should be an array of skill names or IDs
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {

            $userId = $request->input('user_id');

            $user = User::findOrFail($userId);

            $user->about = $request->input('about');
            $user->category_id   = $request->input('category_id');
            $user->sub_category_id = $request->input('sub_category_id');
            // $user->skills_id   = json_encode(explode(',', $request->input('skills_hidden'))); // Convert array to comma-separated string

            // $skills = array_filter(
            //     array_map('trim', explode(',', $request->skills_hidden))
            // );


            // $user->skills_id = $skills;
            // $user->save();
            $skills = array_map('trim', explode(',', $request->skills_hidden));
$user->skills_id = json_encode($skills);
$user->save();


            StaffActivityController::insertActivity(Auth::user()->id, 'Candidate Profile about and skills updated successfully.');


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

    public function CandidateWorkExperience(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'               => 'required|string|max:255',
            'employment_type'     => 'required|integer',
            'company_name'        => 'required|string|max:255',
            'start_date'          => 'required|date',
            'end_date'            => 'nullable|date|after_or_equal:start_date',
            'location'            => 'required|string|max:255',
            'location_type'       => 'required|integer',
            'role_responsibility' => 'nullable|string',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 200);
        }

        $validated = $validator->validated();

        $validated['currently_working'] = $request->has('currently_working') ? 1 : 0;
        if ($validated['currently_working']) {
            $validated['end_date'] = null;
        }

        $row_id = $request->input('work_exp_row_id');

        $work = WorkExperience::findOrFail($row_id);
        $work->update([
            'title'               => $request->input('title'),
            'work_type_id'        => $request->input('employment_type'),
            'company'             => $request->input('company_name') ?? null,
            'start_date'          => $request->input('start_date'),
            'end_date'            => $request->input('end_date') ?? null,
            'location'            => $request->input('location'),
            'working_status'      => $request->has('currently_working') ? 1 : 0,
            'job_type_id'         => $request->input('location_type'),
            'role_responsibility' => $request->input('role_responsibility') ?? null,
        ]);

        StaffActivityController::insertActivity(Auth::user()->id, 'Candidate Work experience updated successfully.');

        return response()->json([
            'status'  => 1,
            'message' => 'Work experience updated successfully.',
            'data'    => $work
        ], 200);
    }


    public function CandidateEducation(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'school_name'     => 'required|string|max:255',
        //     'degree_name'     => 'required|string|max:255',
        //     'field_of_study'  => 'nullable|string|max:255',
        //     'grade'           => 'nullable|string|max:50',
        //     'start_date'      => 'nullable|date',
        //     'end_date'        => 'nullable|date|after_or_equal:start_date',
        //     'description'     => 'nullable|string',
        // ]);
        $validator = Validator::make($request->all(), [
            'school_name'     => 'required|string|max:255',
            'degree_name'     => 'required|string|max:255',
            'field_of_study'  => 'nullable|string|max:255',
            'grade'           => 'nullable|string|max:50',
            'end_date'    => 'required|digits:4|integer|min:1950|max:' . date('Y'),
            'description'     => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 200);
        }

        $row_id = $request->input('education_row_id');
        $education = Education::findOrFail($row_id);

        // $education->update([
        //     'school_name'     => $request->input('school_name'),
        //     'degree'          => $request->input('degree_name'),
        //     'field_of_study'  => $request->input('field_of_study'),
        //     'grade'           => $request->input('grade'),
        //     'start_date'      => $request->input('start_date'),
        //     'end_date'        => $request->input('end_date'),
        //     'description'     => $request->input('description'),
        // ]);
        $education->update([
            'school_name'    => $request->school_name,
            'degree'         => $request->degree_name,
            'field_of_study' => $request->field_of_study,
            'grade'          => $request->grade,
            'end_date'       => (int) $request->end_date,
            'description'    => $request->description,
        ]);

        StaffActivityController::insertActivity(Auth::user()->id, 'Candidate Education updated successfully.');

        return response()->json([
            'status'  => 1,
            'message' => 'Education updated successfully.',
            'data'    => $education
        ]);
    }

    public function CandidateRemoveJob(Request $request)
    {
        $id = $request->input('id');

        try {
            $deleted = DB::table('tbl_job_save')->where('id', $id)->delete();

            if ($deleted) {
                StaffActivityController::insertActivity(Auth::user()->id, 'Candidate Job removed from saved list successfully.');


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
}
