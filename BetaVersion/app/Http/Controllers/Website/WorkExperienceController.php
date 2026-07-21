<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WorkExperience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WorkExperienceController extends Controller
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
            ], 422);
        }

        $validated = $validator->validated();

        $validated['currently_working'] = $request->has('currently_working') ? 1 : 0;
        if ($validated['currently_working']) {
            $validated['end_date'] = null;
        }

        $user_id = Auth::user()->id; // Ensure the user is authenticated
        $work = WorkExperience::create([
            'title'               => $request->input('title'),
            'user_id' => $user_id,
            'work_type_id'        => $request->input('employment_type'),
            'company'             => $request->input('company_name'),
            'start_date'          => $request->input('start_date'),
            'end_date'            => $request->input('end_date') ?? null,
            'location'            => $request->input('location'),
            'working_status'      => $request->has('currently_working') ? 1 : 0,
            'job_type_id'         => $request->input('location_type'),
            'role_responsibility' => $request->input('role_responsibility') ?? null,
        ]);

        return response()->json([
            'status'  => 1,
            'message' => 'Work experience added successfully.',
            'data'    => $work
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
            $work = WorkExperience::findOrFail($id);

            return response()->json([
                'status' => 1,
                'data'   => $work
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Work experience not found.'
            ], 404);
        }
    }

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

        $work = WorkExperience::findOrFail($id);
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

        return response()->json([
            'status'  => 1,
            'message' => 'Work experience updated successfully.',
            'data'    => $work
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $work = WorkExperience::findOrFail($id);
        $work->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Work experience deleted successfully.'
        ]);
    }
}
