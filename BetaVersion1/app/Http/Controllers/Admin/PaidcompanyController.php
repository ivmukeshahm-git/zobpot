<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PaidcompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.paidcompany.paid-company');
    }

    public function getTableData(Request $request)
    {
        $company = $request->input('company_name');
        $purchaseDate = $request->input('purchase_date');
        $expiredDate  = $request->input('expired_date');

        $latestHistory = DB::table('tbl_plan_history')
            ->select('user_id', 'plan_id', 'purchase_date', 'expire_date')
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
                $join->on('a.id', '=', 'd.user_id')
                    ->on('a.active_plan_id', '=', 'd.plan_id');
            })

            ->where('a.role', 'User')
            ->where('a.profile_type', 'Company')
            ->where('a.active_plan_id', '!=', null);

        // ✅ Apply filters if they exist
        if (!empty($company)) {
            $data->where('a.name', 'like', '%' . $company . '%');
        }

        if (!empty($purchaseDate)) {
            $data->whereDate('d.purchase_date', '>=', $purchaseDate);
        }

        if (!empty($expiredDate)) {
            $data->whereDate('d.expire_date', '<=', $expiredDate);
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
            'd.purchase_date',
            'd.expire_date'
        );


        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $viewUrl = url("admin/company-profile/{$row->id}"); // Create dynamic URL
                return '<a href="' . $viewUrl . '" class="btn btn-sm rounded-pill btn-icon btn-secondary">
                                    <span class="tf-icons fa fa-eye"></span>
                                </a>';
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
            ->filterColumn('purchase_date', function ($query, $keyword) {
                $query->where('d.purchase_date', 'like', "%$keyword%");
            })
            ->filterColumn('expire_date', function ($query, $keyword) {
                $query->where('d.expire_date', 'like', "%$keyword%");
            })
            ->rawColumns(['action'])
            ->make(true);
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
