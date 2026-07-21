<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\CollegeStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class CollegeStaffController extends Controller
{
    /**
     * Get the college_id for the current authenticated college user.
     */
    private function getCollegeId()
    {
        if (Auth::guard('college')->check()) {
            return Auth::guard('college')->id();
        }
        return null;
    }

    // ─── STAFF MANAGEMENT ────────────────────────────────────────────

    /**
     * Show college staff listing page.
     */
    public function index()
    {
        if (!$this->getCollegeId()) {
            return redirect()->route('admin.login');
        }
        return view('college-dashboard.staff.index');
    }

    /**
     * DataTable data for college staff listing.
     */
    public function getStaffData(Request $request)
    {
        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = CollegeStaff::where('college_id', $collegeId)
            ->with('role')
            ->select('id', 'name', 'email', 'phone', 'role_id', 'active_status', 'created_at');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('role_name', function ($row) {
                return $row->role ? $row->role->name : '<span class="badge bg-secondary">No Role</span>';
            })
            ->addColumn('status_badge', function ($row) {
                return $row->active_status == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <button type="button" class="btn btn-sm rounded-pill btn-icon btn-warning edit-staff-btn" data-id="' . $row->id . '">
                        <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                    </button>
                    <button type="button" class="btn btn-sm rounded-pill btn-icon btn-danger delete-staff-btn" data-id="' . $row->id . '">
                        <span class="tf-icons bx bx-trash bx-18px"></span>
                    </button>';
            })
            ->rawColumns(['role_name', 'status_badge', 'action'])
            ->make(true);
    }

    /**
     * Store a new college staff member.
     */
    public function store(Request $request)
    {
        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return response()->json(['status' => 0, 'message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:tbl_college_staff,email',
            'phone'         => 'nullable|string|max:15',
            'password'      => 'required|string|min:6',
            'role_id'       => 'nullable|integer|exists:roles,id',
            'active_status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        // Verify role belongs to this college
        if ($request->role_id) {
            $role = Role::where('id', $request->role_id)->where('college_id', $collegeId)->first();
            if (!$role) {
                return response()->json(['status' => 0, 'message' => 'Invalid role selected.']);
            }
        }

        $staff = CollegeStaff::create([
            'college_id'    => $collegeId,
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $request->phone ?: null,
            'password'      => Hash::make($request->password),
            'role_id'       => $request->role_id ?: null,
            'active_status' => $request->active_status,
        ]);

        // Assign Spatie role if set
        if ($request->role_id) {
            $role = Role::find($request->role_id);
            if ($role) {
                $staff->assignRole($role->name);
            }
        }

        return response()->json(['status' => 1, 'message' => 'Staff created successfully.']);
    }

    /**
     * Get a single staff member for editing.
     */
    public function edit($id)
    {
        $collegeId = $this->getCollegeId();
        $staff = CollegeStaff::where('id', $id)->where('college_id', $collegeId)->first();

        if (!$staff) {
            return response()->json(['status' => 0, 'message' => 'Staff not found.']);
        }

        return response()->json(['status' => 1, 'data' => $staff]);
    }

    /**
     * Update an existing college staff member.
     */
    public function update(Request $request, $id)
    {
        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return response()->json(['status' => 0, 'message' => 'Unauthorized'], 403);
        }

        $staff = CollegeStaff::where('id', $id)->where('college_id', $collegeId)->first();
        if (!$staff) {
            return response()->json(['status' => 0, 'message' => 'Staff not found.']);
        }

        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:tbl_college_staff,email,' . $id,
            'phone'         => 'nullable|string|max:15',
            'password'      => 'nullable|string|min:6',
            'role_id'       => 'nullable|integer|exists:roles,id',
            'active_status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()]);
        }

        // Verify role belongs to this college
        if ($request->role_id) {
            $role = Role::where('id', $request->role_id)->where('college_id', $collegeId)->first();
            if (!$role) {
                return response()->json(['status' => 0, 'message' => 'Invalid role selected.']);
            }
        }

        $staff->name          = $request->name;
        $staff->email         = $request->email;
        $staff->phone         = $request->phone ?: null;
        $staff->role_id       = $request->role_id ?: null;
        $staff->active_status = $request->active_status;

        if ($request->filled('password')) {
            $staff->password = Hash::make($request->password);
        }

        $staff->save();

        // Sync Spatie role
        $staff->syncRoles([]);
        if ($request->role_id) {
            $role = Role::find($request->role_id);
            if ($role) {
                $staff->assignRole($role->name);
            }
        }

        return response()->json(['status' => 1, 'message' => 'Staff updated successfully.']);
    }

    /**
     * Delete a college staff member.
     */
    public function destroy($id)
    {
        $collegeId = $this->getCollegeId();
        $staff = CollegeStaff::where('id', $id)->where('college_id', $collegeId)->first();

        if (!$staff) {
            return response()->json(['status' => 0, 'message' => 'Staff not found.']);
        }

        $staff->delete();
        return response()->json(['status' => 1, 'message' => 'Staff deleted successfully.']);
    }

    // ─── ROLE MANAGEMENT ─────────────────────────────────────────────

    /**
     * Show college role management page.
     */
    public function roles()
    {
        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return redirect()->route('admin.login');
        }

        // Get college-specific permissions only (guard_name = college_staff)
        $PermissionData = Permission::where('guard_name', 'college_staff')
            ->get()
            ->groupBy(function ($item) {
                return explode('-', $item->name)[0];
            });

        return view('college-dashboard.roles.index', compact('PermissionData'));
    }

    /**
     * DataTable data for college roles.
     */
    public function getRolesData(Request $request)
    {
        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = Role::where('college_id', $collegeId)
            ->select('id', 'name', 'guard_name', 'created_at');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at_formatted', function ($row) {
                return $row->created_at ? $row->created_at->format('d M Y H:i:s') : 'N/A';
            })
            ->addColumn('action', function ($row) {
                return '
                    <button type="button" class="btn btn-sm rounded-pill btn-icon btn-warning edit-role-btn" data-id="' . $row->id . '">
                        <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                    </button>
                    <button type="button" class="btn btn-sm rounded-pill btn-icon btn-danger delete-role-btn" data-id="' . $row->id . '">
                        <span class="tf-icons bx bx-trash bx-18px"></span>
                    </button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Store a new college role.
     */
    public function storeRole(Request $request)
    {
        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return response()->json(['status' => 0, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'role_nm' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Check uniqueness within this college
        $exists = Role::where('college_id', $collegeId)->where('name', $request->role_nm)->exists();
        if ($exists) {
            return response()->json(['status' => 0, 'message' => 'A role with this name already exists.']);
        }

        $role = Role::create([
            'name' => $request->role_nm,
            'guard_name' => 'college_staff',
            'college_id' => $collegeId,
        ]);

        if ($request->has('permissions')) {
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');
            $role->syncPermissions($permissionNames);
        }

        return response()->json(['status' => 1, 'message' => 'Role created successfully.']);
    }

    /**
     * Get role permissions for editing.
     */
    public function getRolePermissions($id)
    {
        $collegeId = $this->getCollegeId();
        $role = Role::where('id', $id)->where('college_id', $collegeId)->first();

        if (!$role) {
            return response()->json(['status' => 0, 'message' => 'Role not found.']);
        }

        return response()->json([
            'status' => 1,
            'role' => $role,
            'permissions' => $role->permissions->pluck('id'),
        ]);
    }

    /**
     * Update a college role.
     */
    public function updateRole(Request $request, $id)
    {
        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return response()->json(['status' => 0, 'message' => 'Unauthorized'], 403);
        }

        $role = Role::where('id', $id)->where('college_id', $collegeId)->first();
        if (!$role) {
            return response()->json(['status' => 0, 'message' => 'Role not found.']);
        }

        $request->validate([
            'role_nm' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Check uniqueness within college (exclude current)
        $exists = Role::where('college_id', $collegeId)
            ->where('name', $request->role_nm)
            ->where('id', '!=', $id)
            ->exists();
        if ($exists) {
            return response()->json(['status' => 0, 'message' => 'A role with this name already exists.']);
        }

        $role->name = $request->role_nm;
        $role->save();

        if ($request->has('permissions')) {
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');
            $role->syncPermissions($permissionNames);
        } else {
            $role->syncPermissions([]);
        }

        return response()->json(['status' => 1, 'message' => 'Role updated successfully.']);
    }

    /**
     * Delete a college role.
     */
    public function destroyRole($id)
    {
        $collegeId = $this->getCollegeId();
        $role = Role::where('id', $id)->where('college_id', $collegeId)->first();

        if (!$role) {
            return response()->json(['status' => 0, 'message' => 'Role not found.']);
        }

        $role->delete();
        return response()->json(['status' => 1, 'message' => 'Role deleted successfully.']);
    }

    /**
     * Get roles for this college (used in staff form dropdown).
     */
    public function getRolesList()
    {
        $collegeId = $this->getCollegeId();
        if (!$collegeId) {
            return response()->json([]);
        }

        $roles = Role::where('college_id', $collegeId)->select('id', 'name')->get();
        return response()->json($roles);
    }
}
