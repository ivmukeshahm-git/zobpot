<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class CandidateregisterlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.candidatesregisterlist.candidates-register-list');
    }


    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users as a')
                ->leftJoin('tbl_plan_pricing as b', 'a.active_plan_id', '=', 'b.plan_id')
                ->leftJoin('tbl_state as s', 'a.state_id', '=', 's.state_id')
                ->leftJoin('tbl_city as c', 'a.city_id', '=', 'c.city_id')
                ->where('a.role', 'User')
                ->where('a.profile_type', 'Employee')
                ->select(
                    'a.id',
                    'a.name',
                    'a.email',
                    'a.contact_no',
                    'a.active_plan_id',
                    'b.plan_name',
                    'a.created_at',
                    's.state_name',
                    'c.city_nm',
                );

            return DataTables::of($data)
                ->addIndexColumn()

                // ✅ Plan column logic
                ->addColumn('plan', function ($row) {
                    if (is_null($row->active_plan_id)) {
                        return '<span class="badge bg-secondary">No Plan Purchased</span>';
                    } elseif ($row->active_plan_id == 0) {
                        return '<span class="badge bg-danger">Plan Expired</span>';
                    } elseif ($row->plan_name) {
                        return '<span class="badge bg-success">' . e($row->plan_name) . '</span>';
                    } else {
                        return '<span class="badge bg-warning">Unknown Plan</span>';
                    }
                })

                // ✅ Action column
                ->addColumn('action', function ($row) {
                    $viewUrl = url("admin/candidate-profile/{$row->id}"); // Create dynamic URL
                    return '
                <a href="' .  $viewUrl . '" class="btn btn-sm rounded-pill btn-icon btn-secondary">
                                    <span class="tf-icons fa fa-eye "></span>
                                </a>
                                <button type="button" class="btn btn-sm btn-warning" onclick="ViewPlanHistory(' . $row->id . ')">
                                    Plan History
                                </button>';
                })
                 ->filterColumn('name', function ($query, $keyword) {
                    $query->where('a.name', 'like', "%$keyword%");
                })
                 ->filterColumn('email', function ($query, $keyword) {
                    $query->where('a.email', 'like', "%$keyword%");
                })
                 ->filterColumn('contact_no', function ($query, $keyword) {
                    $query->where('a.contact_no', 'like', "%$keyword%");
                })
                 ->filterColumn('state_name', function ($query, $keyword) {
                    $query->where('s.state_name', 'like', "%$keyword%");
                })
                 ->filterColumn('city_nm', function ($query, $keyword) {
                    $query->where('c.city_nm', 'like', "%$keyword%");
                })
                ->rawColumns(['plan', 'action']) // ✅ Allow HTML
                ->make(true);
        }
    }


    public function ViewCandidatesPlanHistory(Request $request)
    {
        $id = $request->input('id'); // user_id

        try {
            // ✅ Fetch plan history with plan details
            $planHistory = DB::table('tbl_plan_history as a')
                ->join('tbl_plan_pricing as b', 'a.plan_id', '=', 'b.plan_id')
                ->select(
                    'a.*',
                    'b.plan_name',
                    'b.plan_price'
                )
                ->where('a.user_id', $id)
                ->orderByDesc('a.id')
                ->get();

            if ($planHistory->isEmpty()) {
                return response()->json([
                    'status' => 0,
                    'message' => 'No plan history found for this user.'
                ]);
            }

            return response()->json([
                'status' => 1,
                'message' => 'Plan History Fetch Successfully.',
                'data' => $planHistory
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => 0,
                'message'   => $th->getMessage(), // Hide this in production
            ], 200);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
