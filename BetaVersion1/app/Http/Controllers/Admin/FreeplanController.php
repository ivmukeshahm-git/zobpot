<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class FreeplanController extends Controller
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

    public function FreeCompanyPlanIndex()
    {
        return view('admin.freeplan.free-company');
    }


    public function FreeCompanygetTableData(Request $request)
    {
        $company     = $request->input('company_name');
        $email       = $request->input('email');
        $contact_no  = $request->input('contact_no');



        // ✅ Main query with joins
        $data = DB::table('users as a')
            ->leftJoin('tbl_state as s', 'a.state_id', '=', 's.state_id')
            ->leftJoin('tbl_city as c', 'a.city_id', '=', 'c.city_id')
            ->leftJoin('tbl_plan_pricing as b', 'a.active_plan_id', '=', 'b.plan_id')

            ->where('a.role', 'User')
            ->where('a.profile_type', 'Company')
            ->where('a.active_plan_id', null);

        // ✅ Apply filters if they exist
        if (!empty($company)) {
            $data->where('a.name', 'like', '%' . $company . '%');
        }

        if (!empty($email)) {
            $data->where('a.email', 'like', '%' . $email . '%'); // ✅ fixed
        }

        if (!empty($contact_no)) {
            $data->where('a.contact_no', $contact_no); // ✅ fixed
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
        );

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('plan', function ($row) {
                if (is_null($row->active_plan_id)) {
                    return '<span class="badge bg-danger">Free</span>';
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
            ->rawColumns(['action', 'plan'])
            ->make(true);
    }


    public function FreeCandidatePlanIndex()
    {
        return view('admin.freeplan.free-candidates');
    }


    public function FreeCandidategetTableData(Request $request)
    {
        $candidate_name     = $request->input('candidate_name');
        $email       = $request->input('email');
        $contact_no  = $request->input('contact_no');



        // ✅ Main query with joins
        $data = DB::table('users as a')
            ->leftJoin('tbl_state as s', 'a.state_id', '=', 's.state_id')
            ->leftJoin('tbl_city as c', 'a.city_id', '=', 'c.city_id')
            ->leftJoin('tbl_plan_pricing as b', 'a.active_plan_id', '=', 'b.plan_id')

            ->where('a.role', 'User')
            ->where('a.profile_type', 'Employee')
            ->where('a.active_plan_id', null);

        // ✅ Apply filters if they exist
        if (!empty($candidate_name)) {
            $data->where('a.name', 'like', '%' . $candidate_name . '%');
        }

        if (!empty($email)) {
            $data->where('a.email', 'like', '%' . $email . '%'); // ✅ fixed
        }

        if (!empty($contact_no)) {
            $data->where('a.contact_no', $contact_no); // ✅ fixed
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
        );

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('plan', function ($row) {
                if (is_null($row->active_plan_id)) {
                    return '<span class="badge bg-danger">Free</span>';
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
                    ';
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
            ->rawColumns(['action', 'plan'])
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
