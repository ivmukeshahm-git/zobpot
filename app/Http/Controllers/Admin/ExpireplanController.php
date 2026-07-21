<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ExpireplanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function ExpireCompanyPlanIndex()
    {
        return view('admin.expireplan.expire-company-plan');
    }


    public function CompanygetTableData(Request $request)
    {
        $company     = $request->input('company_name');
        $email       = $request->input('email');
        $contact_no  = $request->input('contact_no');

        $latestHistory = DB::table('tbl_plan_history')
            ->select('user_id', 'id', 'plan_id', 'purchase_date', 'expire_date')
            ->whereRaw('id IN (
            SELECT MAX(id) FROM tbl_plan_history GROUP BY user_id, plan_id
        )');

        // ✅ Main query with joins
        $data = DB::table('users as a')
            ->leftJoin('tbl_state as s', 'a.state_id', '=', 's.state_id')
            ->leftJoin('tbl_city as c', 'a.city_id', '=', 'c.city_id')
            ->leftJoin('tbl_plan_pricing as b', 'a.active_plan_id', '=', 'b.plan_id')

            // ✅ Join latest history using subquery
            ->leftJoinSub($latestHistory, 'd', function ($join) {
                $join->on('a.id', '=', 'd.user_id');
            })

            ->where('a.role', 'User')
            ->where('a.profile_type', 'Company')
            ->where('a.active_plan_id', 0)
            ->orderBy('d.id', 'desc'); // ✅ fixed order by

        // ✅ Apply filters if they exist
        if (!empty($company)) {
            $data->where('a.name', 'like', '%' . $company . '%');
        }

        if (!empty($email)) {
            $data->where('a.email', 'like', '%' . $email . '%'); // ✅ fixed
        }

        if (!empty($contact_no)) {
            $data->where('a.contact_no', '=', $contact_no); // ✅ fixed
        }

        // ✅ Final select
        $data->select(
            'a.id',
            'a.name',
            'a.email',
            'a.contact_no',
            's.state_name',
            'c.city_nm',
            'a.active_plan_id',
            'b.plan_name',
            'a.created_at',
            'd.expire_date'
        );

        return DataTables::of($data)
            ->addIndexColumn()
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
            ->addColumn('action', function ($row) {
                $viewUrl = url("admin/company-profile/{$row->id}");
                return '<a href="' . $viewUrl . '" class="btn btn-sm rounded-pill btn-icon btn-secondary">
                        <span class="tf-icons fa fa-eye"></span>
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
            ->filterColumn('plan_name', function ($query, $keyword) {
                $query->where('b.plan_name', 'like', "%$keyword%");
            })
            ->filterColumn('expire_date', function ($query, $keyword) {
                $query->where('d.expire_date', 'like', "%$keyword%");
            })
            ->rawColumns(['action', 'plan'])
            ->make(true);
    }


    public function ExpireCandidatePlanIndex()
    {
        return view('admin.expireplan.expire-candidates-plan');
    }


    public function CandidategetTableData(Request $request)
    {
        $candidate_name     = $request->input('candidate_name');
        $email       = $request->input('email');
        $contact_no  = $request->input('contact_no');

        $latestHistory = DB::table('tbl_plan_history')
            ->select('user_id', 'id', 'plan_id', 'purchase_date', 'expire_date')
            ->whereRaw('id IN (
            SELECT MAX(id) FROM tbl_plan_history GROUP BY user_id, plan_id
        )');

        // ✅ Main query with joins
        $data = DB::table('users as a')
            ->leftJoin('tbl_state as s', 'a.state_id', '=', 's.state_id')
            ->leftJoin('tbl_city as c', 'a.city_id', '=', 'c.city_id')
            ->leftJoin('tbl_plan_pricing as b', 'a.active_plan_id', '=', 'b.plan_id')

            // ✅ Join latest history using subquery
            ->leftJoinSub($latestHistory, 'd', function ($join) {
                $join->on('a.id', '=', 'd.user_id');
            })

            ->where('a.role', 'User')
            ->where('a.profile_type', 'Employee')
            ->where('a.active_plan_id', 0)
            ->orderBy('d.id', 'desc'); // ✅ fixed order by

        // ✅ Apply filters if they exist
        if (!empty($candidate_name)) {
            $data->where('a.name', 'like', '%' . $candidate_name . '%');
        }

        if (!empty($email)) {
            $data->where('a.email', 'like', '%' . $email . '%'); // ✅ fixed
        }

        if (!empty($contact_no)) {
            $data->where('a.contact_no', '=', $contact_no); // ✅ fixed
        }

        // ✅ Final select
        $data->select(
            'a.id',
            'a.name',
            'a.email',
            'a.contact_no',
            's.state_name',
            'c.city_nm',
            'a.active_plan_id',
            'b.plan_name',
            'a.created_at',
            'd.expire_date'
        );

        return DataTables::of($data)
            ->addIndexColumn()
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
            ->addColumn('action', function ($row) {
                $viewUrl = url("admin/candidate-profile/{$row->id}");
                return '<a href="' . $viewUrl . '" class="btn btn-sm rounded-pill btn-icon btn-secondary">
                        <span class="tf-icons fa fa-eye"></span>
                    </a>
                    <button type="button" class="btn btn-sm btn-warning" onclick="ViewPlanHistory(' . $row->id . ')">
                                Plan History
                            </button>';
            })
            ->rawColumns(['action', 'plan'])
            ->make(true);
    }




    public function ViewPlanHistory(Request $request)
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
