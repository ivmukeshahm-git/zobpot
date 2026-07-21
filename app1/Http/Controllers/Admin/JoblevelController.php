<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Joblevel;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

use App\Http\Controllers\StaffActivityController;


class JoblevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.joblevel.job-level');
    }

    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = Joblevel::select(['job_level_id', 'type_nm', 'created_at']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actions = '';

                    if (auth()->user()->can('JobLevel-Edit')) {
                        $actions .= '
            <button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
                                    <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                                </button>
        ';
                    }

                    if (auth()->user()->can('JobLevel-Delete')) {
                        $actions .= '
            <button type="button" class="btn delete-job-level-btn btn-sm rounded-pill btn-icon btn-danger">
                                    <span class="tf-icons bx bx-trash bx-18px"></span>
                                </button>
        ';
                    }

                    return $actions;
                })
                ->filterColumn('type_nm', function ($query, $keyword) {
                    $query->where('type_nm', 'like', "%$keyword%");
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
        $request->validate([
            'type_nm' => 'required|string|max:255',
        ]);

        try {
            $category = Joblevel::create([
                'type_nm' => $request->input('type_nm'),
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Job Level Added Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Job Level created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to create job Level.'
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
            'type_nm' => 'required|string|max:255',
        ]);

        // Find the record
        $JobLevel = Joblevel::findOrFail($id);

        if (!$JobLevel) {
            return response()->json([
                'status' => 0,
                'message' => 'Job Level not found.'
            ], 404);
        }

        // Update record
        $JobLevel->update([
            'type_nm' => $request->input('type_nm'),
        ]);

        StaffActivityController::insertActivity(Auth::user()->id, 'Job Level Update Successfully.');


        return response()->json([
            'status' => 1,
            'message' => 'Job Level updated successfully.',
            'data' => $JobLevel
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
        $JobLevel = Joblevel::findOrFail($id);

        if (!$JobLevel) {
            return response()->json([
                'status' => 0,
                'message' => 'Job Level not found.',
            ]);
        }

        $JobLevel->delete(); // If using soft deletes, this marks it deleted

        StaffActivityController::insertActivity(Auth::user()->id, 'Job Level Delete Successfully.');

        return response()->json([
            'status' => 1,
            'message' => 'Job Level deleted successfully.',
        ]);
    }
}
