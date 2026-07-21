<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Yajra\DataTables\DataTables;
use App\Models\Worktype;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\StaffActivityController;


class WorktypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.worktype.work-type');
    }

    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = Worktype::select(['work_type_id', 'type_nm', 'created_at']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actions = '';

                    if (auth()->user()->can('WorkType-Edit')) {
                        $actions .= '
            <button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
                                    <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                                </button>
        ';
                    }

                    if (auth()->user()->can('WorkType-Delete')) {
                        $actions .= '
               <button type="button" class="btn delete-work-type-btn btn-sm rounded-pill btn-icon btn-danger">
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
            $category = Worktype::create([
                'type_nm' => $request->input('type_nm'),
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Work Type Added Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Work Type created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to create Work Type.'
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
        $WorkType = Worktype::findOrFail($id);

        if (!$WorkType) {
            return response()->json([
                'status' => 0,
                'message' => 'Work type not found.'
            ], 404);
        }

        // Update record
        $WorkType->update([
            'type_nm' => $request->input('type_nm'),
        ]);

         StaffActivityController::insertActivity(Auth::user()->id, 'Work Type Update Successfully.');

        return response()->json([
            'status' => 1,
            'message' => 'Work Type updated successfully.',
            'data' => $WorkType
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
        $WorkType = Worktype::findOrFail($id);

        if (!$WorkType) {
            return response()->json([
                'status' => 0,
                'message' => 'Work type not found.',
            ]);
        }

        $WorkType->delete(); // If using soft deletes, this marks it deleted

        StaffActivityController::insertActivity(Auth::user()->id, 'Work Type Delete Successfully.');

        return response()->json([
            'status' => 1,
            'message' => 'Work Type deleted successfully.',
        ]);
    }
}
