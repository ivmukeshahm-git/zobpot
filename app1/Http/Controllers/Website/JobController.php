<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Job;
use App\Models\State;
use App\Models\City;
use App\Models\Area;
use App\Models\JobRound;
use App\Models\Zipcode;
use App\Models\JobTitle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_preference_type'       => 'required|string',
            'job_category_id'       => 'required|integer',
            'job_sub_category_id'   => 'nullable|integer',
            'job_title'             => 'required|string|max:255',
            'job_minimum_qualification' => 'required|string',
            'job_level'             => 'nullable|string',
            'job_type'              => 'nullable|string',
            'job_work_type'             => 'nullable|string',
            'job_number_of_openings'    => 'required|integer|min:1',
            'job_salary_budget'    => 'nullable',
            'job_description'       => 'nullable|string',
            'gender' => 'required|string|in:All,Male,Female,Other,Both',
            'job_interviewer_address'   => 'nullable|string',
            'job_experience_required'   => 'nullable|string',
            'job_contact_number'        => 'nullable|string|max:20',
            'job_company_website'       => 'nullable|string',
            'job_company_address'       => 'nullable|string',
            'job_state_id'          => 'nullable',
            'job_city_id'           => 'nullable',
            'job_area_id'           => 'nullable',
            'job_zipcode'           => 'nullable',
             'job_age'               => 'nullable',
            'job_timing'               => 'nullable',
            'job_hr_email'              => 'nullable|email',
            'job_hr_contact_no'         => 'nullable|string|max:20',
            'skills_hidden'         => 'nullable|string'
        ]);
        // dd(Auth::user()->role);


        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 200);
        }

        $state_id = 0;
        $city_id = 0;
        $area_id = 0;
        $zipcode_id = 0;

        // STATE
        if ($request->job_state_id_hidden != null) {
            $CheckState = State::find($request->job_state_id_hidden);
            if ($CheckState) {
                $state_id = $CheckState->state_id;
            }
        } elseif ($request->job_state_id) {
            $AddState = State::create([
                'state_name' => $request->job_state_id,
                'country_id' => 1 // default country ID if applicable
            ]);
            $state_id = $AddState->state_id;
        }

        // CITY
        if ($request->job_city_id_hidden != null) {
            $CheckCity = City::find($request->job_city_id_hidden);
            if ($CheckCity) {
                $city_id = $CheckCity->city_id;
            }
        } elseif ($request->job_city_id) {
            $AddCity = City::create([
                'city_nm' => $request->job_city_id,
                'state_id'  => $state_id
            ]);
            $city_id = $AddCity->city_id;
        }

        // AREA
        if ($request->job_area_id_hidden != null) {
            $CheckArea = Area::find($request->job_area_id_hidden);
            if ($CheckArea) {
                $area_id = $CheckArea->area_id;
            }
        } elseif ($request->job_area_id) {
            $AddArea = Area::create([
                'area_nm' => $request->job_area_id,
                'city_id'   => $city_id,
                'state_id' => $state_id,
            ]);
            $area_id = $AddArea->area_id;

            if ($request->job_pincode_id_hidden != null) {
                $AddZip = Zipcode::create([
                    'zipcode'  => $request->job_zipcode,
                    'city_id'  => $city_id,
                    'area_id'  => $area_id,
                    'state_id' => $state_id,
                ]);
                $zipcode_id = $AddZip->zipcode_id;
            }
        }

        // PINCODE
        if ($request->job_pincode_id_hidden != null) {
            $CheckZip = Zipcode::find($request->job_pincode_id_hidden);
            if ($CheckZip) {
                $zipcode_id = $CheckZip->zipcode_id;
            }
        } elseif ($request->job_zipcode) {
            $AddZip = Zipcode::create([
                'zipcode'  => $request->job_zipcode,
                'city_id'  => $city_id,
                'area_id'  => $area_id,
                'state_id' => $state_id,
            ]);
            $zipcode_id = $AddZip->zipcode_id;
        }
        if (Auth::user()->role == 'Admin' && $request->company_id) {
         // Superadmin/Admin creating job for a company
            $user_id = $request->company_id;
        } else {
            // Normal company user
            $user_id = Auth::id();
        }


        $job = Job::create([
            'user_id'               => $user_id, // Assuming authenticated user is creating
            'preference_type'       => $request->input('job_preference_type'),
            'category_id'       => $request->input('job_category_id'),
            'sub_category_id'   => $request->input('job_sub_category_id'),
            'job_title'             => $request->input('job_title'),
            'qualification_id' => $request->input('job_minimum_qualification'),
            'job_level_id'             => $request->input('job_level'),
            'job_type_id'              => $request->input('job_type'),
            'work_type_id'             => $request->input('job_work_type'),
            'number_of_openings'    => $request->input('job_number_of_openings'),
            'salary_budget'    => $request->input('job_salary_budget'),
            'job_description'       => $request->input('job_description'),
            'gender'               => $request->input('gender', 'All'),
            'interviewer_address'   => $request->input('job_interviewer_address'),
            'experience_req_id'   => $request->input('job_experience_required'),
            'contact_no'        => $request->input('job_contact_number'),
            'company_website'       => $request->input('job_company_website'),
            'company_address'       => $request->input('job_company_address'),
            'state_id'          => $state_id,
            'city_id'           => $city_id,
            'area_id'           => $area_id,
            'zipcode_id'           => $zipcode_id,
            'hr_email'              => $request->input('job_hr_email'),
            'hr_contact_no'         => $request->input('job_hr_contact_no'),
                            'age'         => $request->input('job_age'),
                'job_timing'         => $request->input('job_timing'),
            'skill_id'         => json_encode(explode(',', $request->input('skills_hidden'))),
            'datetime'              => now(), // Assuming you want current datetime
        ]);


        $roundNames = $request->input('round_nm') ?? [];
        $roundDescriptions = $request->input('round_description') ?? [];

        foreach ($roundNames as $index => $roundName) {
            // Skip if round name is empty/null/whitespace
            if (empty(trim($roundName))) {
                continue;
            }

            $roundDesc = $roundDescriptions[$index] ?? null;

            JobRound::create([
                "job_id"     => $job->job_id,
                "round_name" => $roundName,
                "round_desc" => $roundDesc,
            ]);
        }


        return response()->json([
            'status' => 1,
            'message' => 'Job created successfully',
            'job' => $job
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    try {

        $Job = DB::table('tbl_job as j')
            ->select(
                'j.*',
                's.state_name',
                'c.city_nm',
                'a.area_nm',
                'z.zipcode'
            )
            ->leftJoin('tbl_state as s', 'j.state_id', '=', 's.state_id')
            ->leftJoin('tbl_city as c', 'j.city_id', '=', 'c.city_id')
            ->leftJoin('tbl_area as a', 'j.area_id', '=', 'a.area_id')
            ->leftJoin('tbl_zipcode as z', 'j.zipcode_id', '=', 'z.zipcode_id')
            ->where('j.job_id', $id)
            ->first();

        if (!$Job) {
            return response()->json([
                'status'  => 0,
                'message' => 'Job not found.'
            ], 404);
        }

        // 🔥 FETCH INTERVIEW ROUNDS (THIS WAS MISSING)
        $rounds = JobRound::where('job_id', $Job->job_id)
                    ->whereNull('deleted_at')
                    ->get();

        return response()->json([
            'status'  => 1,
            'message' => 'Job found.',
            'data'    => $Job,
            'rounds'  => $rounds   // 🔥 VERY IMPORTANT
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => 0,
            'message' => 'Something went wrong.',
            'error'   => $e->getMessage()
        ], 500);
    }
}

    // public function edit($id)
    // {
    //     try {
    //         $Job = DB::table('tbl_job as j')
    //             ->select(
    //                 'j.*',
    //                 's.state_name',
    //                 'c.city_nm',
    //                 'a.area_nm',
    //                 'z.zipcode'
    //             )
    //             ->leftJoin('tbl_state as s', 'j.state_id', '=', 's.state_id')
    //             ->leftJoin('tbl_city as c', 'j.city_id', '=', 'c.city_id')
    //             ->leftJoin('tbl_area as a', 'j.area_id', '=', 'a.area_id')
    //             ->leftJoin('tbl_zipcode as z', 'j.zipcode_id', '=', 'z.zipcode_id')
    //             ->where('j.job_id', $id)
    //             ->first();

    //         if (!$Job) {
    //             return response()->json([
    //                 'status'  => 0,
    //                 'message' => 'Job not found.'
    //             ], 404);
    //         }

    //         return response()->json([
    //             'status'  => 1,
    //             'message' => 'Job found.',
    //             'data'    => $Job
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status'  => 0,
    //             'message' => 'Something went wrong.'
    //         ], 500);
    //     }
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'job_preference_type'       => 'required|string',
            'job_category_id'           => 'required|integer',
            'job_sub_category_id'       => 'nullable|integer',
            'job_title'                 => 'required|string|max:255',
            'job_minimum_qualification' => 'required|string',
            'job_level'                 => 'nullable|string',
            'job_type'                  => 'nullable|string',
            'job_work_type'             => 'nullable|string',
            'job_number_of_openings'    => 'required|integer|min:1',
            'job_salary_budget'    => 'nullable',
            'job_description'           => 'nullable|string',
            'gender' => 'required|string|in:All,Male,Female,Other,Both',
            'job_interviewer_address'   => 'nullable|string',
            'job_experience_required'   => 'nullable|string',
            'job_contact_number'        => 'nullable|string|max:20',
            'job_company_website'       => 'nullable|string',
            'job_company_address'       => 'nullable|string',
            'job_state_id'              => 'nullable',
            'job_city_id'               => 'nullable',
            'job_area_id'               => 'nullable',
            'job_zipcode'               => 'nullable',
             'job_age'               => 'nullable',
            'job_timing'               => 'nullable',
            'job_hr_email'              => 'nullable|email',
            'job_hr_contact_no'         => 'nullable|string|max:20',
            'skills_hidden'             => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 200);
        }

        $state_id = 0;
        $city_id = 0;
        $area_id = 0;
        $zipcode_id = 0;

        // STATE
        if ($request->job_state_id_hidden != null) {
            $CheckState = State::find($request->job_state_id_hidden);
            if ($CheckState) {
                $state_id = $CheckState->state_id;
            }
        } elseif ($request->job_state_id) {
            $AddState = State::create([
                'state_name' => $request->job_state_id,
                'country_id' => 1
            ]);
            $state_id = $AddState->state_id;
        }

        // CITY
        if ($request->job_city_id_hidden != null) {
            $CheckCity = City::find($request->job_city_id_hidden);
            if ($CheckCity) {
                $city_id = $CheckCity->city_id;
            }
        } elseif ($request->job_city_id) {
            $AddCity = City::create([
                'city_nm'  => $request->job_city_id,
                'state_id' => $state_id
            ]);
            $city_id = $AddCity->city_id;
        }

        // AREA
        if ($request->job_area_id_hidden != null) {
            $CheckArea = Area::find($request->job_area_id_hidden);
            if ($CheckArea) {
                $area_id = $CheckArea->area_id;
            }
        } elseif ($request->job_area_id) {
            $AddArea = Area::create([
                'area_nm' => $request->job_area_id,
                'city_id' => $city_id,
                'state_id' => $state_id,
            ]);
            $area_id = $AddArea->area_id;
        }

        // PINCODE
        if ($request->job_pincode_id_hidden != null) {
            $CheckZip = Zipcode::find($request->job_pincode_id_hidden);
            if ($CheckZip) {
                $zipcode_id = $CheckZip->zipcode_id;
            }
        } elseif ($request->job_zipcode) {
            $AddZip = Zipcode::create([
                'zipcode'  => $request->job_zipcode,
                'city_id'  => $city_id,
                'area_id'  => $area_id,
                'state_id' => $state_id,
            ]);
            $zipcode_id = $AddZip->zipcode_id;
        }

        try {
            $job = Job::findOrFail($id);
            $job->update([
                'preference_type'     => $request->input('job_preference_type'),
                'category_id'         => $request->input('job_category_id'),
                'sub_category_id'     => $request->input('job_sub_category_id'),
                'job_title'           => $request->input('job_title'),
                'qualification_id'    => $request->input('job_minimum_qualification'),
                'job_level_id'        => $request->input('job_level'),
                'job_type_id'         => $request->input('job_type'),
                'work_type_id'        => $request->input('job_work_type'),
                'number_of_openings'  => $request->input('job_number_of_openings'),
                'salary_budget'    => $request->input('job_salary_budget'),
                'job_description'     => $request->input('job_description'),
                'gender'               => $request->input('gender', 'All'),
                'interviewer_address' => $request->input('job_interviewer_address'),
                'experience_req_id'   => $request->input('job_experience_required'),
                'contact_no'          => $request->input('job_contact_number'),
                'company_website'     => $request->input('job_company_website'),
                'company_address'     => $request->input('job_company_address'),
                'state_id'            => $state_id,
                'city_id'             => $city_id,
                'area_id'             => $area_id,
                'zipcode_id'          => $zipcode_id,
                'hr_email'            => $request->input('job_hr_email'),
                'hr_contact_no'       => $request->input('job_hr_contact_no'),
                                'age'         => $request->input('job_age'),
                'job_timing'         => $request->input('job_timing'),
                'skill_id'            => json_encode(explode(',', $request->input('skills_hidden'))),
            ]);
           
       $roundIds   = $request->round_id ?? [];
        $roundNames = $request->round_nm ?? [];
        $roundDescs = $request->round_description ?? [];

        foreach ($roundNames as $index => $roundName) {

            // ❌ EMPTY ROW SKIP
            if (empty(trim($roundName))) {
                continue;
            }

            // ✅ UPDATE
            if (isset($roundIds[$index]) && !empty($roundIds[$index])) {

                JobRound::where('id', $roundIds[$index])
                    ->where('job_id', $job->job_id)
                    ->update([
                        'round_name' => $roundName,
                        'round_desc' => $roundDescs[$index] ?? null,
                    ]);

            }
            // 🟢 INSERT (ONLY REAL NEW ROW)
            else {

                JobRound::create([
                    'job_id'     => $job->job_id,
                    'round_name' => $roundName,
                    'round_desc' => $roundDescs[$index] ?? null,
                ]);
            }
        }



            return response()->json([
                'status' => 1,
                'message' => 'Job updated successfully',
                'job' => $job
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Job not found or update failed',
                'error' => $e->getMessage()
            ], 200);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json([
                'status' => 0,
                'message' => 'Job not found.'
            ], 404);
        }

        JobRound::where('job_id', $id)->delete();

        $job->delete();


        return response()->json([
            'status' => 1,
            'message' => 'Job deleted successfully.'
        ]);
    }
    public function fetchTitles(Request $request)
    {
        $search = $request->keyword;

        $titles = JobTitle::where('title_name', 'LIKE', "%$search%")
            ->orderBy('title_name')
            ->limit(10)
            ->get();

        return response()->json([
            'status' => 1,
            'data' => $titles
        ]);
    }
}
