<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Education;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class EducationController extends Controller
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
            'school_name'     => 'required|string|max:255',
            'degree_name'          => 'required|string|max:255',
            'field_of_study'  => 'nullable|string|max:255',
            'grade'           => 'nullable|string|max:50',
            // 'start_date'      => 'required|date',
            'end_date' => 'nullable|integer|digits:4',
            'description'     => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }
        $user_id = Auth::user()->id; // Ensure the user is authenticated
        $education = Education::create([
            'user_id'        => $user_id,
            'school_name'     => $request->input('school_name'),
            'degree'          => $request->input('degree_name'),
            'field_of_study'  => $request->input('field_of_study'),
            'grade'           => $request->input('grade'),
            // 'start_date'      => $request->input('start_date'),
            'end_date'        => $request->input('end_date'),
            'description'     => $request->input('description'),
        ]);

        return response()->json([
            'status'  => 1,
            'message' => 'Education record created successfully.',
            'data'    => $education
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
        $education = Education::findOrFail($id);

        return response()->json([
            'status' => 1,
            'data'   => $education
        ]);
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
            'school_name'     => 'required|string|max:255',
            'degree_name'     => 'required|string|max:255',
            'field_of_study'  => 'nullable|string|max:255',
            'grade'           => 'nullable|string|max:50',
            // 'start_date'      => 'required|date',
            'end_date' => 'nullable|integer|digits:4',
            'description'     => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        $education = Education::findOrFail($id);

        $education->update([
            'school_name'     => $request->input('school_name'),
            'degree'          => $request->input('degree_name'),
            'field_of_study'  => $request->input('field_of_study'),
            'grade'           => $request->input('grade'),
            // 'start_date'      => $request->input('start_date'),
            'end_date'        => $request->input('end_date'),
            'description'     => $request->input('description'),
        ]);

        return response()->json([
            'status'  => 1,
            'message' => 'Education record updated successfully.',
            'data'    => $education
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $education = Education::findOrFail($id);
        $education->delete(); // Soft delete

        return response()->json([
            'status'  => 1,
            'message' => 'Education record deleted successfully.'
        ]);
    }
}
