<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;

use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use App\Http\Controllers\StaffActivityController;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $StateData = State::get();
        return view('admin.area.area', compact('StateData'));
    }

    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tbl_area')
                ->join('tbl_city', 'tbl_area.city_id', '=', 'tbl_city.city_id')
                ->join('tbl_state', 'tbl_city.state_id', '=', 'tbl_state.state_id')
                ->select([
                    'tbl_area.area_id',
                    'tbl_area.area_nm',
                    'tbl_area.city_id',
                    'tbl_area.state_id',
                    'tbl_city.city_nm',
                    'tbl_state.state_name',
                    'tbl_area.created_at'
                ])->whereNull('tbl_area.deleted_at');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actions = '';

                    if (auth()->user()->can('Area-Edit')) {
                        $actions .= '
            <button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
                    <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                </button>
        ';
                    }

                    if (auth()->user()->can('Area-Delete')) {
                        $actions .= '
            <button type="button" class="btn delete-area-btn btn-sm rounded-pill btn-icon btn-danger">
                    <span class="tf-icons bx bx-trash bx-18px"></span>
                </button>
        ';
                    }

                    return $actions;
                })
                ->filterColumn('state_name', function ($query, $keyword) {
                    $query->where('tbl_state.state_name', 'like', "%$keyword%");
                })
                ->filterColumn('city_nm', function ($query, $keyword) {
                    $query->where('tbl_city.city_nm', 'like', "%$keyword%");
                })
                ->filterColumn('area_nm', function ($query, $keyword) {
                    $query->where('tbl_area.area_nm', 'like', "%$keyword%");
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function get_state(Request $request)
    {
        $state_id = $request->input('state_id');

        // Fetch all subcategories where category_id matches
        $AreaData = City::where('state_id', $state_id)->get();

        if ($AreaData->isEmpty()) {
            return response()->json([
                'status' => 0,
                'message' => 'No City found for this State.'
            ], 404);
        }

        return response()->json([
            'status' => 1,
            'message' => 'City fetched successfully.',
            'data' => $AreaData
        ], 200);
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
        $validated = $request->validate([
            'state_id' => 'required|exists:tbl_state,state_id',
            'city_id'  => 'required|exists:tbl_city,city_id',
            'area_nm'  => 'required|string|max:255',
        ]);

        try {
            $category = Area::create([
                'state_id' => $request->input('state_id'),
                'city_id' => $request->input('city_id'),
                'area_nm' => $request->input('area_nm'),
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Area Added Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Area created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to create Area.'
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
        $validated = $request->validate([
            'state_id' => 'required|exists:tbl_state,state_id',
            'city_id'  => 'required|exists:tbl_city,city_id',
            'area_nm'  => 'required|string|max:255',
        ]);

        try {
            $area = Area::findOrFail($id); // Find the area or throw 404
            $area->update([
                'state_id' => $request->input('state_id'),
                'city_id'  => $request->input('city_id'),
                'area_nm'  => $request->input('area_nm'),
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Area Update Successfully.');

            return response()->json([
                'status'  => 1,
                'message' => 'Area updated successfully.',
                'data'    => $area
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Failed to update Area.',
                'error'   => $e->getMessage()
            ], 500);
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
        try {
            $area = Area::findOrFail($id);
            $area->delete();

            StaffActivityController::insertActivity(Auth::user()->id, 'Area Delete Successfully.');


            return response()->json([
                'status'  => 1,
                'message' => 'Area deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Failed to delete Area.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
