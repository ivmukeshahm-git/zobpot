<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\City;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

use App\Http\Controllers\StaffActivityController;


class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $StateData = State::get();
        return view('admin.city.city', compact('StateData'));
    }

    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = City::join('tbl_state', 'tbl_city.state_id', '=', 'tbl_state.state_id')
                ->select([
                    'tbl_city.city_id',
                    'tbl_city.city_nm',
                    'tbl_state.state_name',
                    'tbl_city.state_id',
                    'tbl_city.created_at'
                ]);


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actions = '';

                    if (auth()->user()->can('City-Edit')) {
                        $actions .= '
            <button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
                                    <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                                </button>
        ';
                    }

                    if (auth()->user()->can('City-Delete')) {
                        $actions .= '
            <button type="button" class="btn delete-city-btn btn-sm rounded-pill btn-icon btn-danger">
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
        $validated = $request->validate([
            'state_id' => 'required', // Ensure state exists
            'city_nm'  => 'required|string|max:255',
        ]);

        try {
            // Create the city
            $city = City::create([
                'state_id' => $request->input('state_id'),
                'city_nm'  => $request->input('city_nm'),
            ]);

             StaffActivityController::insertActivity(Auth::user()->id, 'City Added successfully.');

            return response()->json([
                'status'  => 1,
                'message' => 'City created successfully.',
                'data'    => $city,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Failed to create city.',
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
            'state_id' => 'required',
            'city_nm'  => 'required|string|max:255',
        ]);

        try {
            $city = City::findOrFail($id);

            $city->update([
                'state_id' => $request->input('state_id'),
                'city_nm'  => $request->input('city_nm'),
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'City Update successfully.');

            return response()->json([
                'status'  => 1,
                'message' => 'City updated successfully.',
                'data'    => $city,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Failed to update city.',
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
            $city = City::findOrFail($id);
            $city->delete();

            StaffActivityController::insertActivity(Auth::user()->id, 'City Delete successfully.');


            return response()->json([
                'status'  => 1,
                'message' => 'City deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Failed to delete city.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
