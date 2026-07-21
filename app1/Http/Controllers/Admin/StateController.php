<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

use App\Http\Controllers\StaffActivityController;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.state.state');
    }


    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = State::select(['state_id', 'state_name', 'country_id']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actions = '';

                    if (auth()->user()->can('State-Edit')) {
                        $actions .= '
           <button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
                                    <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                                </button>
        ';
                    }

                    if (auth()->user()->can('State-Delete')) {
                        $actions .= '
             <button type="button" class="btn delete-state-btn btn-sm rounded-pill btn-icon btn-danger">
                                    <span class="tf-icons bx bx-trash bx-18px"></span>
                                </button>
        ';
                    }

                    return $actions;
                })
                ->filterColumn('state_name', function ($query, $keyword) {
                    $query->where('state_name', 'like', "%$keyword%");
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
            'state_name' => 'required|string|max:255',
        ]);

        try {
            $State = State::create([
                'state_name' => $request->input('state_name'),
                'country_id' => 1,
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'State Added Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'State created successfully.'
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
            'state_name' => 'required|string|max:255',
        ]);

        // Find the record
        $State = State::findOrFail($id);

        if (!$State) {
            return response()->json([
                'status' => 0,
                'message' => 'State not found.'
            ], 404);
        }

        // Update record
        $State->update([
            'state_name' => $request->input('state_name'),
        ]);

        StaffActivityController::insertActivity(Auth::user()->id, 'State Update Successfully.');

        return response()->json([
            'status' => 1,
            'message' => 'State updated successfully.',
            'data' => $State
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
        $State = State::findOrFail($id);

        if (!$State) {
            return response()->json([
                'status' => 0,
                'message' => 'State not found.',
            ]);
        }

        $State->delete(); // If using soft deletes, this marks it deleted

        StaffActivityController::insertActivity(Auth::user()->id, 'State Delete Successfully.');

        return response()->json([
            'status' => 1,
            'message' => 'State deleted successfully.',
        ]);
    }
}
