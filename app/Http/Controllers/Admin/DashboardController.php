<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

use Illuminate\Support\Carbon;


class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $Count = DB::table('users')
            ->selectRaw("
        COUNT(CASE WHEN role = 'User' AND profile_type = 'Company' AND verify_status = 1 AND deleted_at IS NULL THEN 1 END) as TotalCompany,
        COUNT(CASE WHEN role = 'User' AND profile_type = 'Employee' AND verify_status = 1 AND deleted_at IS NULL THEN 1 END) as TotalCandidate,
        COUNT(CASE WHEN role = 'User' AND active_plan_id IS NOT NULL AND active_plan_id != 0 AND verify_status = 1 AND deleted_at IS NULL THEN 1 END) as TotalPaidUser,
        COUNT(CASE WHEN role = 'User' AND (active_plan_id IS NULL OR active_plan_id = 0) AND verify_status = 1 AND deleted_at IS NULL THEN 1 END) as TotalFreeUser
    ")
            ->first();
    //     $FreeUsersDebug = DB::table('users')
    //     ->select('id', 'name', 'email', 'profile_type', 'active_plan_id')
    //     ->where('role', 'User')
    //     ->where('verify_status', 1)
    //     ->whereNull('deleted_at')
    //     ->where(function ($q) {
    //         $q->whereNull('active_plan_id')
    //           ->orWhere('active_plan_id', 0);
    //     })
    //     ->get();

    // dd($FreeUsersDebug);


        $PaidCompanylatestHistory = DB::table('tbl_plan_history')
            ->select('id', 'user_id', 'plan_id', 'purchase_date')
            ->whereRaw('id IN (SELECT MAX(id) FROM tbl_plan_history GROUP BY user_id, plan_id)');


        $PaidCompanyData = DB::table('users as a')
            ->join('tbl_plan_pricing as b', 'a.active_plan_id', '=', 'b.plan_id')

            // Join the latest plan purchase per user
            ->joinSub($PaidCompanylatestHistory, 'c', function ($join) {
                $join->on('a.id', '=', 'c.user_id')
                    ->on('a.active_plan_id', '=', 'c.plan_id');
            })

            ->where('a.role', 'User')
            ->where('a.profile_type', 'Company')
            ->whereNotNull('a.active_plan_id')
            ->where('a.active_plan_id', '!=', 0)

            ->select(
                'a.*',
                'b.plan_name',
                'b.plan_price',
                'b.plan_time',
                'b.plan_duration',
                'c.purchase_date'
            )
            ->paginate(5);



        $PaidCandidatelatestHistory = DB::table('tbl_plan_history')
            ->select('id', 'user_id', 'plan_id', 'purchase_date')
            ->whereRaw('id IN (SELECT MAX(id) FROM tbl_plan_history GROUP BY user_id, plan_id)');


        $PaidCandidateData = DB::table('users as a')
            ->join('tbl_plan_pricing as b', 'a.active_plan_id', '=', 'b.plan_id')

            // Join the latest plan purchase per user
            ->joinSub($PaidCandidatelatestHistory, 'c', function ($join) {
                $join->on('a.id', '=', 'c.user_id')
                    ->on('a.active_plan_id', '=', 'c.plan_id');
            })

            ->where('a.role', 'User')
            ->where('a.profile_type', 'Employee')
            ->whereNotNull('a.active_plan_id')
            ->where('a.active_plan_id', '!=', 0)

            ->select(
                'a.*',
                'b.plan_name',
                'b.plan_price',
                'b.plan_time',
                'b.plan_duration',
                'c.purchase_date'
            )
            ->paginate(5);


        $FreeCompanyData = DB::table('users')
            ->where('role', 'User')
            ->where('profile_type', 'Company')
            ->whereNull('active_plan_id') // ✅ this checks for IS NULL
            ->paginate(5); // use ->paginate(x) if needed


        $FreeCandidateData = DB::table('users')
            ->where('role', 'User')
            ->where('profile_type', 'Employee')
            ->whereNull('active_plan_id') // ✅ this checks for IS NULL
            ->paginate(5); // use ->paginate(x) if needed


        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;



        $ExpiredPlanCompanylatestHistory = DB::table('tbl_plan_history')
            ->select('id', 'user_id', 'plan_id', 'purchase_date', 'expire_date')
            ->whereRaw('id IN (SELECT MAX(id) FROM tbl_plan_history GROUP BY user_id, plan_id)');


        $ExpiredPlanCompanyData = DB::table('users as a')
            ->join('tbl_plan_pricing as b', 'a.active_plan_id', '=', 'b.plan_id')

            // Join the latest plan purchase per user
            ->joinSub($ExpiredPlanCompanylatestHistory, 'c', function ($join) {
                $join->on('a.id', '=', 'c.user_id')
                    ->on('a.active_plan_id', '=', 'c.plan_id');
            })

            ->where('a.role', 'User')
            ->where('a.profile_type', 'Company')
            ->whereNotNull('a.active_plan_id')
            ->where('a.active_plan_id', '!=', 0)
            ->whereMonth('c.expire_date', $currentMonth)
            ->whereYear('c.expire_date', $currentYear)

            ->select(
                'a.*',
                'b.plan_name',
                'b.plan_price',
                'b.plan_time',
                'b.plan_duration',
                'c.expire_date'
            )
            ->paginate(5);



        $ExpiredPlanCandidatelatestHistory = DB::table('tbl_plan_history')
            ->select('id', 'user_id', 'plan_id', 'purchase_date', 'expire_date')
            ->whereRaw('id IN (SELECT MAX(id) FROM tbl_plan_history GROUP BY user_id, plan_id)');


        $ExpiredPlanCandidateData = DB::table('users as a')
            ->join('tbl_plan_pricing as b', 'a.active_plan_id', '=', 'b.plan_id')

            // Join the latest plan purchase per user
            ->joinSub($ExpiredPlanCandidatelatestHistory, 'c', function ($join) {
                $join->on('a.id', '=', 'c.user_id')
                    ->on('a.active_plan_id', '=', 'c.plan_id');
            })

            ->where('a.role', 'User')
            ->where('a.profile_type', 'Employee')
            ->whereNotNull('a.active_plan_id')
            ->where('a.active_plan_id', '!=', 0)
            ->whereMonth('c.expire_date', $currentMonth)
            ->whereYear('c.expire_date', $currentYear)

            ->select(
                'a.*',
                'b.plan_name',
                'b.plan_price',
                'b.plan_time',
                'b.plan_duration',
                'c.expire_date'
            )
            ->paginate(5);

        $activities = DB::table('tbl_staff_activity as a')
            ->join('users as b', 'a.user_id', '=', 'b.id')
            ->leftJoin('model_has_roles as c', function ($join) {
                $join->on('b.id', '=', 'c.model_id')
                    ->where('c.model_type', '=', 'App\\Models\\User'); // Important!
            })
            ->leftJoin('roles as r', 'c.role_id', '=', 'r.id')
            ->select('a.*', 'b.name as user_name', 'r.name as role_name')
            ->where('b.role', 'Staff')
            ->orderByDesc('a.datetime')
            ->get();

        return view('admin.index', compact('Count', 'PaidCompanyData', 'PaidCandidateData', 'FreeCompanyData', 'FreeCandidateData', 'ExpiredPlanCompanyData', 'ExpiredPlanCandidateData','activities'));
    }


    public function TodayCandidatesRegisterLIst(Request $request)
    {
        if ($request->ajax()) {
            $today = Carbon::today(); // 📅 Get yyyy-mm-dd


            $data = DB::table('users as a')
                ->leftJoin('tbl_plan_pricing as b', 'a.active_plan_id', '=', 'b.plan_id')
                ->leftJoin('tbl_state as s', 'a.state_id', '=', 's.state_id')
                ->leftJoin('tbl_city as c', 'a.city_id', '=', 'c.city_id')
                ->where('a.role', 'User')
                ->where('a.profile_type', 'Employee')
                ->where('a.profile_status', 0)
                ->whereDate('a.created_at', $today) // ✅ Filter by today's registration
                ->select(
                    'a.id',
                    'a.name',
                    'a.email',
                    'a.contact_no',
                    'a.active_plan_id',
                    'a.preference_type',
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
                        return '<span class="badge bg-secondary">Free</span>';
                    } elseif ($row->active_plan_id == 0) {
                        return '<span class="badge bg-danger">Plan Expired</span>';
                    } elseif ($row->plan_name) {
                        return '<span class="badge bg-success">Paid</span>';
                    } else {
                        return '<span class="badge bg-warning">Unknown Plan</span>';
                    }
                })
                ->addColumn('preference_type_name', function ($row) {
                    if ($row->preference_type == 1) {
                        return 'Skilled';
                    } elseif ($row->preference_type == 2) {
                        return 'Non-Skilled';
                    }
                })

                // ✅ Action column
                ->addColumn('action', function ($row) {
                    $viewUrl = url("admin/candidate-profile/{$row->id}"); // Create dynamic URL
                    return '
                <a href="' .  $viewUrl . '" class="btn btn-sm rounded-pill btn-icon btn-secondary mx-2">
                                    <span class="tf-icons fa fa-eye "></span>
                                </a><a href="javascript:void(0);" onclick="ApproveDisapproveProfile(1, \'Approve\', \'' . $row->id . '\')" class="btn btn-sm btn-success">
            Approve
        </a>';
                })
                ->rawColumns(['plan', 'action', 'preference_type_name']) // ✅ Allow HTML
                ->make(true);
        }
    }

    public function TodayApproveCandidatesRegisterLIst(Request $request)
    {
        if ($request->ajax()) {
            $today = Carbon::today(); // 📅 Get yyyy-mm-dd


            $data = DB::table('users as a')
                ->leftJoin('tbl_plan_pricing as b', 'a.active_plan_id', '=', 'b.plan_id')
                ->leftJoin('tbl_state as s', 'a.state_id', '=', 's.state_id')
                ->leftJoin('tbl_city as c', 'a.city_id', '=', 'c.city_id')
                ->where('a.role', 'User')
                ->where('a.profile_type', 'Employee')
                ->where('a.profile_status', 1)
                ->whereDate('a.created_at', $today) // ✅ Filter by today's registration
                ->select(
                    'a.id',
                    'a.name',
                    'a.email',
                    'a.contact_no',
                    'a.active_plan_id',
                    'a.preference_type',
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
                        return '<span class="badge bg-secondary">Free</span>';
                    } elseif ($row->active_plan_id == 0) {
                        return '<span class="badge bg-danger">Plan Expired</span>';
                    } elseif ($row->plan_name) {
                        return '<span class="badge bg-success">Paid</span>';
                    } else {
                        return '<span class="badge bg-warning">Unknown Plan</span>';
                    }
                })
                ->addColumn('preference_type_name', function ($row) {
                    if ($row->preference_type == 1) {
                        return 'Skilled';
                    } elseif ($row->preference_type == 2) {
                        return 'Non-Skilled';
                    }
                })

                // ✅ Action column
                ->addColumn('action', function ($row) {
                    $viewUrl = url("admin/candidate-profile/{$row->id}"); // Create dynamic URL
                    return '
                <a href="' .  $viewUrl . '" class="btn btn-sm rounded-pill btn-icon btn-secondary mx-2">
                                    <span class="tf-icons fa fa-eye "></span>
                                </a><a href="javascript:void(0);" onclick="ApproveDisapproveProfile(2, \'Reject\', \'' . $row->id . '\')" class="btn btn-sm btn-danger">
            Reject
        </a>';
                })
                ->rawColumns(['plan', 'action', 'preference_type_name']) // ✅ Allow HTML
                ->make(true);
        }
    }



    public function TodayCompanyRegisterLIst(Request $request)
    {
        if ($request->ajax()) {
            $today = Carbon::today(); // 📅 Get yyyy-mm-dd


            $data = DB::table('users as a')
                ->leftJoin('tbl_plan_pricing as b', 'a.active_plan_id', '=', 'b.plan_id')
                ->leftJoin('tbl_state as s', 'a.state_id', '=', 's.state_id')
                ->leftJoin('tbl_city as c', 'a.city_id', '=', 'c.city_id')
                ->where('a.role', 'User')
                ->where('a.profile_type', 'Company')
                ->where('a.profile_status', 0)
                ->whereDate('a.created_at', $today) // ✅ Filter by today's registration
                ->select(
                    'a.id',
                    'a.name',
                    'a.email',
                    'a.contact_no',
                    'a.active_plan_id',
                    'a.preference_type',
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
                        return '<span class="badge bg-secondary">Free</span>';
                    } elseif ($row->active_plan_id == 0) {
                        return '<span class="badge bg-danger">Plan Expired</span>';
                    } elseif ($row->plan_name) {
                        return '<span class="badge bg-success">Paid</span>';
                    } else {
                        return '<span class="badge bg-warning">Unknown Plan</span>';
                    }
                })

                // ✅ Action column
                ->addColumn('action', function ($row) {
                    $viewUrl = url("admin/company-profile/{$row->id}"); // Create dynamic URL
                    return '
                <a href="' .  $viewUrl . '" class="btn btn-sm rounded-pill btn-icon btn-secondary mx-2">
                                    <span class="tf-icons fa fa-eye "></span>
                                </a><a href="javascript:void(0);" onclick="ApproveDisapproveProfile(1, \'Approve\', \'' . $row->id . '\')" class="btn btn-sm btn-success">
            Approve
        </a>';
                })
                ->rawColumns(['plan', 'action']) // ✅ Allow HTML
                ->make(true);
        }
    }


    public function TodayApproveCompanyRegisterLIst(Request $request)
    {
        if ($request->ajax()) {
            $today = Carbon::today(); // 📅 Get yyyy-mm-dd


            $data = DB::table('users as a')
                ->leftJoin('tbl_plan_pricing as b', 'a.active_plan_id', '=', 'b.plan_id')
                ->leftJoin('tbl_state as s', 'a.state_id', '=', 's.state_id')
                ->leftJoin('tbl_city as c', 'a.city_id', '=', 'c.city_id')
                ->where('a.role', 'User')
                ->where('a.profile_type', 'Company')
                ->where('a.profile_status', 1)
                ->whereDate('a.created_at', $today) // ✅ Filter by today's registration
                ->select(
                    'a.id',
                    'a.name',
                    'a.email',
                    'a.contact_no',
                    'a.active_plan_id',
                    'a.preference_type',
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
                        return '<span class="badge bg-secondary">Free</span>';
                    } elseif ($row->active_plan_id == 0) {
                        return '<span class="badge bg-danger">Plan Expired</span>';
                    } elseif ($row->plan_name) {
                        return '<span class="badge bg-success">Paid</span>';
                    } else {
                        return '<span class="badge bg-warning">Unknown Plan</span>';
                    }
                })

                // ✅ Action column
                ->addColumn('action', function ($row) {
                    $viewUrl = url("admin/candidate-profile/{$row->id}"); // Create dynamic URL
                    return '
                <a href="' .  $viewUrl . '" class="btn btn-sm rounded-pill btn-icon btn-secondary mx-2">
                                    <span class="tf-icons fa fa-eye "></span>
                                </a><a href="javascript:void(0);" onclick="ApproveDisapproveProfile(2, \'Reject\', \'' . $row->id . '\')" class="btn btn-sm btn-danger">
            Reject
        </a>';
                })
                ->rawColumns(['plan', 'action']) // ✅ Allow HTML
                ->make(true);
        }
    }
}
