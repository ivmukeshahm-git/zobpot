<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\StaffActivityController;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'Admin') {
            
            // Only load permissions for the 'web' guard so college/college_staff permissions
            // (which use other guards) are not shown in the super-admin Roles modal.
            $PermissionData = \Spatie\Permission\Models\Permission::where('guard_name', 'web')
                ->get()
                ->groupBy(function ($item) {
                    return explode('-', $item->name)[0]; // e.g., 'User' from 'User-Add'
                });
            return view('admin.roles.role', compact('PermissionData'));
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            // Only show admin/web guard roles on the admin Roles page
            $data = Role::select(['id', 'name', 'guard_name', 'created_at'])
                ->where('guard_name', 'web')
                ->where('id', '!=', 5);

            return DataTables::of($data)
                ->addIndexColumn()
               ->addColumn('action', function ($row) {
    $editBtn = '
        <button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning" data-id="' . $row->id . '">
            <span class="tf-icons bx bx-edit-alt bx-18px"></span>
        </button>
    ';

    $deleteBtn = '';
    if ($row->id != 3) {
        $deleteBtn = '
            <button type="button" class="btn delete-role-btn btn-sm rounded-pill btn-icon btn-danger" data-id="' . $row->id . '">
                <span class="tf-icons bx bx-trash bx-18px"></span>
            </button>
        ';
    }

    return $editBtn . $deleteBtn;
})
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function getRolePermissions($id)
    {
        try {
            $role = Role::findOrFail($id);
            $permissions = $role->permissions->pluck('id'); // get permission names

            return response()->json([
                'status' => 1,
                'permissions' => $permissions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to fetch role permissions.'
            ]);
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
            'role_nm' => 'required|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        try {
            $role = Role::create([
                'name' => $request->input('role_nm'),
                'guard_name' => 'web'
            ]);

            if ($request->has('permissions')) {
                $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');
                $role->syncPermissions($permissionNames);
            }

            StaffActivityController::insertActivity(Auth::user()->id, 'Role Added Successfully.');

            return response()->json(['status' => 1, 'message' => 'Role created successfully.']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to create role.',
                'error' => $e->getMessage(), // <== Copy this output and share with me if it still fails
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
            'role_nm' => 'required|unique:roles,name,' . $id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        try {
            $role = Role::findOrFail($id);
            $role->name = $request->input('role_nm');
            $role->save();

            if ($request->has('permissions')) {
                $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');
                $role->syncPermissions($permissionNames);
            } else {
                $role->syncPermissions([]); // Remove all permissions if none selected
            }

            StaffActivityController::insertActivity(Auth::user()->id, 'Role Update Successfully.');

            return response()->json(['status' => 1, 'message' => 'Role updated successfully.']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to update role.',
                'error' => $e->getMessage(),
            ]);
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
            $role = Role::findOrFail($id);
            $role->delete();

            StaffActivityController::insertActivity(Auth::user()->id, 'Role Delete Successfully.');

            return response()->json(['status' => 1, 'message' => 'Role deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to delete role.',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
