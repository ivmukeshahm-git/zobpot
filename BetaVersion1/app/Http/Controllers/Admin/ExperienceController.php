<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Yajra\DataTables\DataTables;
use App\Models\Experiencereq;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\StaffActivityController;


class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.experience.experience');
    }

    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = Experiencereq::select(['experience_req_id', 'name', 'created_at']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actions = '';

                    if (auth()->user()->can('ExperienceRequired-Edit')) {
                        $actions .= '
            <button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
                                    <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                                </button>
        ';
                    }

                    if (auth()->user()->can('ExperienceRequired-Delete')) {
                        $actions .= '
      <button type="button" class="btn delete-experience-btn btn-sm rounded-pill btn-icon btn-danger">
                                    <span class="tf-icons bx bx-trash bx-18px"></span>
                                </button>
        ';
                    }

                    return $actions;
                })
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('name', 'like', "%$keyword%");
                })
                ->rawColumns(['action'])->make(true);
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
            'experience' => 'required|string|max:255',
        ]);

        try {
            $Experiencereq = Experiencereq::create([
                'name' => $request->input('experience'),
            ]);

            StaffActivityController::insertActivity(Auth::user()->id, 'Master Experience Added successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Experience created successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to create Experience'
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
            'experience' => 'required|string|max:255',
        ]);

        // Find the record
        $Experiencereq = Experiencereq::findOrFail($id);

        if (!$Experiencereq) {
            return response()->json([
                'status' => 0,
                'message' => 'Experience not found.'
            ], 404);
        }

        // Update record
        $Experiencereq->update([
            'name' => $request->input('experience'),
        ]);

        StaffActivityController::insertActivity(Auth::user()->id, 'Master Experience Update successfully.');


        return response()->json([
            'status' => 1,
            'message' => 'Experience updated successfully.',
            'data' => $Experiencereq
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
        $Experiencereq = Experiencereq::findOrFail($id);

        if (!$Experiencereq) {
            return response()->json([
                'status' => 0,
                'message' => 'Experience not found.',
            ]);
        }

        $Experiencereq->delete(); // If using soft deletes, this marks it deleted

        StaffActivityController::insertActivity(Auth::user()->id, 'Master Experience Delete successfully.');

        return response()->json([
            'status' => 1,
            'message' => 'Experience deleted successfully.',
        ]);
    }
}
