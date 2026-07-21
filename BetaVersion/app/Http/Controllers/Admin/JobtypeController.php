<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Jobtype;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\StaffActivityController;

class JobtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.jobtype.job-type');
    }



    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = Jobtype::select(['job_type_id', 'type_name', 'created_at']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actions = '';

                    if (auth()->user()->can('JobType-Edit')) {
                        $actions .= '
            <button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
                                    <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                                </button>';
                    }

                    if (auth()->user()->can('JobType-Delete')) {
                        $actions .= '
            <button type="button" class="btn delete-job-type-btn btn-sm rounded-pill btn-icon btn-danger">
                                    <span class="tf-icons bx bx-trash bx-18px"></span>
                                </button>';
                    }

                    return $actions;
                })
                ->filterColumn('type_name', function ($query, $keyword) {
                    $query->where('type_name', 'like', "%$keyword%");
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
            'type_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors(),
            ], 422);
        }

        try {
            $JobType = Jobtype::create([
                'type_name' => $request->input('type_name'),
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Job Type Added Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Job Type created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to create job Type.'
            ]);
        }
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
        //
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
        $request->validate([
            'type_name' => 'required|string|max:255',
        ]);

        // Find the record
        $JobType = Jobtype::findOrFail($id);

        if (!$JobType) {
            return response()->json([
                'status' => 0,
                'message' => 'Job type not found.'
            ], 404);
        }

        // Update record
        $JobType->update([
            'type_name' => $request->input('type_name'),
        ]);
        
        StaffActivityController::insertActivity(Auth::user()->id, 'Job Type Update Successfully.');

        return response()->json([
            'status' => 1,
            'message' => 'Job Type updated successfully.',
            'data' => $JobType
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $JobType = Jobtype::findOrFail($id);

        if (!$JobType) {
            return response()->json([
                'status' => 0,
                'message' => 'Job type not found.',
            ]);
        }

        $JobType->delete(); // If using soft deletes, this marks it deleted

        StaffActivityController::insertActivity(Auth::user()->id, 'Job Type Delete Successfully.');


        return response()->json([
            'status' => 1,
            'message' => 'Job Type deleted successfully.',
        ]);
    }
}
