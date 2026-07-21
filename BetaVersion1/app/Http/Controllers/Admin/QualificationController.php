<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Minqualification;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

use App\Http\Controllers\StaffActivityController;

class QualificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.qualification.qualification');
    }

    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = Minqualification::select(['qualification_id', 'name', 'created_at']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actions = '';

                    if (auth()->user()->can('MinimumQualification-Edit')) {
                        $actions .= '
            <button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
                                    <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                                </button>
        ';
                    }

                    if (auth()->user()->can('MinimumQualification-Delete')) {
                        $actions .= '
            <button type="button" class="btn delete-qualification-btn btn-sm rounded-pill btn-icon btn-danger">
                                    <span class="tf-icons bx bx-trash bx-18px"></span>
                                </button>
        ';
                    }

                    return $actions;
                })
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('name', 'like', "%$keyword%");
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
            'qualification_name' => 'required|string|max:255',
        ]);

        try {
            $qualification = Minqualification::create([
                'name' => $request->input('qualification_name'),
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Qualification Added Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Qualification created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to create Qualification'
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
            'qualification_name' => 'required|string|max:255',
        ]);

        // Find the record
        $Minqualification = Minqualification::findOrFail($id);

        if (!$Minqualification) {
            return response()->json([
                'status' => 0,
                'message' => 'Qualification not found.'
            ], 404);
        }

        // Update record
        $Minqualification->update([
            'name' => $request->input('qualification_name'),
        ]);

        StaffActivityController::insertActivity(Auth::user()->id, 'Qualification Update Successfully.');

        return response()->json([
            'status' => 1,
            'message' => 'Qualification updated successfully.',
            'data' => $Minqualification
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
        $Minqualification = Minqualification::findOrFail($id);

        if (!$Minqualification) {
            return response()->json([
                'status' => 0,
                'message' => 'Qualification not found.',
            ]);
        }

        $Minqualification->delete(); // If using soft deletes, this marks it deleted

        StaffActivityController::insertActivity(Auth::user()->id, 'Qualification Delete Successfully.');

        return response()->json([
            'status' => 1,
            'message' => 'Qualification deleted successfully.',
        ]);
    }
}
