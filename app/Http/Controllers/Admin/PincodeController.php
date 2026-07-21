<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Zipcode;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

use App\Http\Controllers\StaffActivityController;


class PincodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $StateData = State::get();
        return view('admin.pincode.pincode', compact('StateData'));
    }

    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tbl_zipcode')
                ->join('tbl_area', 'tbl_zipcode.area_id', '=', 'tbl_area.area_id')
                ->join('tbl_city', 'tbl_area.city_id', '=', 'tbl_city.city_id')
                ->join('tbl_state', 'tbl_city.state_id', '=', 'tbl_state.state_id')
                ->select([
                    'tbl_zipcode.zipcode_id',
                    'tbl_zipcode.zipcode',
                    'tbl_area.area_nm',
                    'tbl_city.city_nm',
                    'tbl_state.state_name',
                    'tbl_zipcode.created_at',
                    'tbl_zipcode.state_id',
                    'tbl_zipcode.city_id',
                    'tbl_zipcode.area_id',
                ])
                ->whereNull('tbl_zipcode.deleted_at'); // Optional if soft deletes used

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actions = '';

                    if (auth()->user()->can('Zipcode-Edit')) {
                        $actions .= '
           <button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
                    <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                </button>
        ';
                    }

                    if (auth()->user()->can('Zipcode-Delete')) {
                        $actions .= '
            <button type="button" class="btn delete-pincode-btn btn-sm rounded-pill btn-icon btn-danger">
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
                ->filterColumn('zipcode', function ($query, $keyword) {
                    $query->where('tbl_zipcode.zipcode', 'like', "%$keyword%");
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function get_city(Request $request)
    {
        $state_id = $request->input('state_id');

        // Fetch all subcategories where category_id matches
        $CityData = City::where('state_id', $state_id)->get();

        if ($CityData->isEmpty()) {
            return response()->json([
                'status' => 0,
                'message' => 'No City found for this State.'
            ], 404);
        }

       

        return response()->json([
            'status' => 1,
            'message' => 'City fetched successfully.',
            'data' => $CityData
        ], 200);
    }


    public function get_area(Request $request)
    {
        $city_id = $request->input('city_id');

        // Fetch all subcategories where category_id matches
        $AreaData = Area::where('city_id', $city_id)->get();

        if ($AreaData->isEmpty()) {
            return response()->json([
                'status' => 0,
                'message' => 'No Area found for this City.'
            ], 404);
        }

        

        return response()->json([
            'status' => 1,
            'message' => 'Area fetched successfully.',
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
            'area_id'  => 'required|exists:tbl_area,area_id',
            'pincode'  => 'required|string|max:255',
        ]);

        try {
            $pincode = Zipcode::create([
                'state_id' => $request->input('state_id'),
                'city_id'  => $request->input('city_id'),
                'area_id'  => $request->input('area_id'),
                'zipcode'  => $request->input('pincode'),
            ]);

             StaffActivityController::insertActivity(Auth::user()->id, 'Pincode Delete Successfully.');


            return response()->json([
                'status'  => 1,
                'message' => 'Pincode created successfully.',
                'data'    => $pincode,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Failed to create pincode.',
                'error'   => $e->getMessage(),
            ], 500);
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
            'area_id'  => 'required|exists:tbl_area,area_id',
            'pincode'  => 'required',
        ]);

        try {
            $pincode = Zipcode::findOrFail($id);

            $pincode->update([
                'state_id' => $request->input('state_id'),
                'city_id'  => $request->input('city_id'),
                'area_id'  => $request->input('area_id'),
                'zipcode'  => $request->input('pincode'),
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Pincode Update Successfully.');

            return response()->json([
                'status'  => 1,
                'message' => 'Pincode updated successfully.',
                'data'    => $pincode,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Failed to update pincode.',
                'error'   => $e->getMessage(),
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
            $pincode = Zipcode::find($id);
            // dd($id);
            $pincode->delete();

            StaffActivityController::insertActivity(Auth::user()->id, 'Pincode Delete Successfully.');


            return response()->json([
                'status'  => 1,
                'message' => 'Pincode deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Failed to delete pincode.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
