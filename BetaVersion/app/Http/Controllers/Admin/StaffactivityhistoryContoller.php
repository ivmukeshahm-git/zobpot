<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;


class StaffactivityhistoryContoller extends Controller
{
    public function index(Request $request)
    {

        $StaffData = User::where('role', 'Staff')->get();
        $Roles = Role::get();
        return view('admin.staffactivityhistory.staff-activity-history', compact('StaffData','Roles'));
    }


    public function getTableData(Request $request)
    {
        $staff_nm   = $request->input('staff_nm');
        $start_date = $request->input('start_date');
        $end_date   = $request->input('end_date');
        $role_nm    = $request->input('role_nm');

        $query = DB::table('tbl_staff_activity as a')
            ->join('users as b', 'a.user_id', '=', 'b.id')
            ->leftJoin('model_has_roles as c', function ($join) {
                $join->on('b.id', '=', 'c.model_id')
                    ->where('c.model_type', '=', 'App\\Models\\User'); // Required for Spatie
            })
            ->leftJoin('roles as r', 'c.role_id', '=', 'r.id')
            ->select('a.*', 'b.name as user_name', 'r.name as role_nm')
            ->where('b.role', 'Staff')
            ->orderByDesc('a.datetime');

        // ✅ Apply filters dynamically
        if (!empty($staff_nm)) {
            $query->where('b.name', 'like', "%$staff_nm%");
        }

        if (!empty($role_nm)) {
            $query->where('r.id', 'like', "%$role_nm%");
        }

        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween('a.datetime', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        } elseif (!empty($start_date)) {
            $query->whereDate('a.datetime', '>=', $start_date);
        } elseif (!empty($end_date)) {
            $query->whereDate('a.datetime', '<=', $end_date);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('department_name', function ($row) {
                return '<span class="badge bg-label-secondary">' . ($row->role_nm ?? 'N/A') . '</span>';
            })
            ->editColumn('datetime', function ($row) {
                return date('d-m-Y h:i A', strtotime($row->datetime));
            })
            ->rawColumns(['user_name','department_name']) // Marking safe columns
            ->make(true);
    }
}
