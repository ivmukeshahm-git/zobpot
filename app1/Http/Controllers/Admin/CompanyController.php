<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function CompanyList()
    {
        return view('admin.company.company');
    }

    public function CompanyDataTable(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users')
                ->select([
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.contact_no',
                    'users.active_status',
                    'tbl_state.state_name',
                    'tbl_city.city_nm',
                    'tbl_zipcode.zipcode',
                    'users.created_at',
                    'users.profile_status',
                ])
                ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
                ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
                ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')
                ->where('users.profile_type', 'Company')
                ->where('users.role', 'User')
                ->whereNull('users.deleted_at');


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $viewUrl = url("admin/company-profile/{$row->id}");

                    // View profile button
                    $actionButtons = '<a href="' . $viewUrl . '" class="btn btn-sm rounded-pill btn-icon btn-secondary me-1" title="View Profile">
        <span class="tf-icons fa fa-eye"></span>
    </a>';

                    // Approve or Reject button based on profile_statusid
                    if ($row->profile_status == 1) {
                        $actionButtons .= '<a href="javascript:void(0);" onclick="ApproveDisapproveProfile(2, \'Reject\', \'' . $row->id . '\')" class="btn btn-sm btn-danger me-1">
            Reject
        </a>';
                    } else if ($row->profile_status == 0) {
                        $actionButtons .= '
        <a href="javascript:void(0);" onclick="ApproveDisapproveProfile(1, \'Approve\', \'' . $row->id . '\')" class="btn btn-sm btn-success mx-1">
            Approve
        </a>';
                    } else {
                        $actionButtons .= '<a href="javascript:void(0);" onclick="ApproveDisapproveProfile(1, \'Approve\', \'' . $row->id . '\')" class="btn btn-sm btn-success me-1">
            Approve
        </a>';
                    }

                    return $actionButtons;
                })
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('users.name', 'like', "%$keyword%");
                })
                ->filterColumn('email', function ($query, $keyword) {
                    $query->where('users.email', 'like', "%$keyword%");
                })
                ->filterColumn('contact_no', function ($query, $keyword) {
                    $query->where('users.contact_no', 'like', "%$keyword%");
                })
                ->filterColumn('state_name', function ($query, $keyword) {
                    $query->where('tbl_state.state_name', 'like', "%$keyword%");
                })
                ->filterColumn('city_nm', function ($query, $keyword) {
                    $query->where('tbl_city.city_nm', 'like', "%$keyword%");
                })
                ->filterColumn('zipcode', function ($query, $keyword) {
                    $query->where('tbl_zipcode.zipcode', 'like', "%$keyword%");
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
