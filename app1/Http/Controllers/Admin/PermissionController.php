<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use Illuminate\Support\Facades\Validator;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\StaffActivityController;

class PermissionController extends Controller
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
            return view('admin.permission.permission');
        } else {
            return redirect()->route('admin.login');
        }
        
    }


    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::select(['id', 'name', 'guard_name', 'created_at']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d M Y h:i A');
                })
                ->addColumn('action', function ($row) {
                    return '
                    <button type="button" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning" data-id="' . $row->id . '">
                        <span class="tf-icons bx bx-edit-alt bx-18px"></span>
                    </button>
                    <button type="button" class="btn delete-permission-btn btn-sm rounded-pill btn-icon btn-danger" data-id="' . $row->id . '">
                        <span class="tf-icons bx bx-trash bx-18px"></span>
                    </button>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
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
        $validator = Validator::make($request->all(), [
            'permission_nm' => 'required|string|max:255|unique:permissions,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => 'Validation Error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            Permission::create([
                'name' => $request->input('permission_nm'),
                'guard_name' => 'web', // or 'api' if you're using API auth
            ]);

             StaffActivityController::insertActivity(Auth::user()->id, 'Permission Added Successfully.');


            return response()->json([
                'status'  => 1,
                'message' => 'Permission created successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Failed to create permission.',
                'error'   => $e->getMessage()
            ], 500);
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
        $validator = Validator::make($request->all(), [
            'permission_nm' => 'required|string|max:255|unique:permissions,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $permission = Permission::findOrFail($id);
            $permission->name = $request->permission_nm;
            $permission->save();

            StaffActivityController::insertActivity(Auth::user()->id, 'Permission Update Successfully.');

            return response()->json([
                'status' => 1,
                'message' => 'Permission updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to update permission.',
                'error' => $e->getMessage(),
            ], 500);
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
            $permission = Permission::findOrFail($id);
            $permission->delete();

            StaffActivityController::insertActivity(Auth::user()->id, 'Permission Delete Successfully.');


            return response()->json([
                'status' => 1,
                'message' => 'Permission deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Failed to delete permission.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
