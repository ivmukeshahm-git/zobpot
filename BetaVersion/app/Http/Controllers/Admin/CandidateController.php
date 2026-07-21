<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CandidateController extends Controller
{
    public function SkillCandidate(Request $request)
    {
        return view('admin.candidate.skilled');
    }

    public function SkillDataTable(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users')
                ->select([
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.contact_no',
                    'tbl_state.state_name',
                    'tbl_city.city_nm',
                    'tbl_zipcode.zipcode',
                    'users.created_at',
                    'users.profile_status'
                ])
                ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
                ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
                ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')
                // ->leftJoin('tbl_area', 'tbl_area.area_id', '=', 'users.area_id') // Uncomment if needed
                ->where('users.preference_type', 1)
                ->where('users.profile_type', 'Employee')
                ->whereNull('users.deleted_at'); // For soft deletes

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $viewUrl = url("admin/candidate-profile/{$row->id}"); // Dynamic view URL

                    $actionButtons = '
        <a href="' . $viewUrl . '" class="btn btn-sm rounded-pill btn-icon btn-secondary mx-1">
            <span class="tf-icons fa fa-eye"></span>
        </a>
         <a href="javascript:void(0);"
            onclick="toggleUserStatus(' . $row->id . ')"
            class="btn btn-sm rounded-pill btn-icon btn-warning mx-1"
            title="Settings">
                <span class="tf-icons fa fa-cog"></span>
        </a>
        ';

                    if ($row->profile_status == 1) {
                        $actionButtons .= '
        <a href="javascript:void(0);" onclick="ApproveDisapproveProfile(2, \'Reject\', \'' . $row->id . '\')" class="btn btn-sm btn-danger mx-1">
            Reject
        </a>';
                    } else if ($row->profile_status == 0) {
                        $actionButtons .= '
        <a href="javascript:void(0);" onclick="ApproveDisapproveProfile(1, \'Approve\', \'' . $row->id . '\')" class="btn btn-sm btn-success mx-1">
            Approve
        </a>';
                    } else {
                        $actionButtons .= '
        <a href="javascript:void(0);" onclick="ApproveDisapproveProfile(1, \'Approve\', \'' . $row->id . '\')" class="btn btn-sm btn-success mx-1">
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

    public function NonSkillCandidate(Request $request)
    {
        if (Auth::check()) {
            return view('admin.candidate.none-skilled');
        } else {
            return redirect()->route('admin.login')->with('error', 'You must be logged in to access this page.');
        }
    }


    public function NoneSkillDataTable(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users')
                ->select([
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.contact_no',
                    'tbl_state.state_name',
                    'tbl_city.city_nm',
                    'tbl_zipcode.zipcode',
                    'users.created_at',
                    'users.profile_status'
                ])
                ->leftJoin('tbl_state', 'tbl_state.state_id', '=', 'users.state_id')
                ->leftJoin('tbl_city', 'tbl_city.city_id', '=', 'users.city_id')
                ->leftJoin('tbl_zipcode', 'tbl_zipcode.zipcode_id', '=', 'users.zipcode_id')
                ->where('users.preference_type', 2)
                ->where('users.profile_type', 'Employee')
                ->whereNull('users.deleted_at');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $viewUrl = url("admin/candidate-profile/{$row->id}"); // Dynamic view URL

                    $actionButtons = '
        <a href="' . $viewUrl . '" class="btn btn-sm rounded-pill btn-icon btn-secondary mx-1">
            <span class="tf-icons fa fa-eye"></span>
        </a>
        <a href="javascript:void(0);"
            onclick="toggleUserStatus(' . $row->id . ')"
            class="btn btn-sm rounded-pill btn-icon btn-warning mx-1"
            title="Settings">
                <span class="tf-icons fa fa-cog"></span>
        </a>
        ';

                    if ($row->profile_status == 1) {

                        $actionButtons .= '
        <a href="javascript:void(0);" onclick="ApproveDisapproveProfile(2, \'Reject\', \'' . $row->id . '\')" class="btn btn-sm btn-danger mx-1">
            Reject
        </a>';
                    }else if ($row->profile_status == 0) {
                        $actionButtons .= '
        <a href="javascript:void(0);" onclick="ApproveDisapproveProfile(1, \'Approve\', \'' . $row->id . '\')" class="btn btn-sm btn-success mx-1">
            Approve
        </a>';
                    } else {
                        $actionButtons .= '
        <a href="javascript:void(0);" onclick="ApproveDisapproveProfile(1, \'Approve\', \'' . $row->id . '\')" class="btn btn-sm btn-success mx-1">
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

    public function NoneSkillUserStatus(Request $request)
    {
        // include soft deleted users also
        $user = User::withTrashed()->find($request->id);

        if (!$user) {
            return response()->json([
                'status'  => 0,
                'title'   => 'User Not Found',
                'message' => 'User does not exist.'
            ]);
        }

        // 🔁 TOGGLE USING deleted_at
        if ($user->deleted_at) {
            // ACTIVATE
            $user->restore();

            return response()->json([
                'status'  => 1,
                'title'   => 'Activated',
                'message' => 'User activated successfully.'
            ]);
        } else {
            // DEACTIVATE
            $user->delete();

            return response()->json([
                'status'  => 1,
                'title'   => 'Deactivated',
                'message' => 'User deactivated successfully.'
            ]);
        }
    }


    public function SkillUserStatus(Request $request)
    {
        // include soft deleted users also
        $user = User::withTrashed()->find($request->id);

        if (!$user) {
            return response()->json([
                'status'  => 0,
                'title'   => 'User Not Found',
                'message' => 'User does not exist.'
            ]);
        }

        // 🔁 TOGGLE USING deleted_at
        if ($user->deleted_at) {
            // ACTIVATE
            $user->restore();

            return response()->json([
                'status'  => 1,
                'title'   => 'Activated',
                'message' => 'User activated successfully.'
            ]);
        } else {
            // DEACTIVATE
            $user->delete();

            return response()->json([
                'status'  => 1,
                'title'   => 'Deactivated',
                'message' => 'User deactivated successfully.'
            ]);
        }
    }


}
