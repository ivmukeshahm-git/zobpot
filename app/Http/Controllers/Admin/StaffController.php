<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use App\Models\Zipcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Yajra\DataTables\DataTables;

use App\Http\Controllers\StaffActivityController;



class StaffController extends Controller
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
            return view('admin.staff.index');
        } else {
            return redirect()->route('admin.login');
        }
    }


    public function add_staff()
    {
        $user = Auth::user();
        if ($user->role == 'Admin') {

            $Roles = Role::get();
            $states = State::select('state_id', 'state_name')->get(); // replace with your table column names
            $method = "POST";
            $flag = "A";
            $row_id = 0;
            return view('admin.staff.add-staff', compact('states', 'Roles', 'method', 'flag', 'row_id'));
        } else {
            return redirect()->route('admin.login');
        }
    }


    public function GetTableData(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users as a')
                ->leftJoin('tbl_state as s', 'a.state_id', '=', 's.state_id')
                ->leftJoin('tbl_city as c', 'a.city_id', '=', 'c.city_id')
                ->where('a.role', 'Staff')
                ->select(
                    'a.id',
                    'a.name',
                    'a.email',
                    'a.contact_no',
                    'a.active_status',
                    'a.created_at',
                    's.state_name',
                    'c.city_nm',
                );

            return DataTables::of($data)
                ->addIndexColumn()

                // ✅ Plan column logic
                ->addColumn('active_status_badge', function ($row) {
                    if ($row->active_status == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">Deactive</span>';
                    }
                })

                // ✅ Action column
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.staff.edit', $row->id);
                    return '
        <a href="' . $editUrl . '" class="btn view-details-btn btn-sm rounded-pill btn-icon btn-warning">
            <span class="tf-icons bx bx-edit-alt bx-18px"></span>
        </a>
        <button type="button" class="btn delete-staff-btn btn-sm rounded-pill btn-icon btn-danger">
            <span class="tf-icons bx bx-trash bx-18px"></span>
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
                ->rawColumns(['active_status_badge', 'action']) // ✅ Allow HTML
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
            'staff_name' => 'required|string|max:255',
            'staff_email' => 'required|email|unique:users,email',
            'staff_contact' => 'required|string|max:15',
            'state_id' => 'required',
            'city_id' => 'required',
            'area_id' => 'required',
            'zipcode' => 'required',
            'staff_address' => 'required|string|max:500',
            'staff_password' => 'required|string|min:6',
            'staff_role' => 'required|string|exists:roles,id', // Ensure role exists
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ], 200);
        }


        $state_id = 0;
        $city_id = 0;
        $area_id = 0;
        $zipcode_id = 0;

        // STATE
        if ($request->state_id_hidden != null) {
            $CheckState = State::find($request->state_id_hidden);
            if ($CheckState) {
                $state_id = $CheckState->state_id;
            }
        } elseif ($request->state_id) {
            $AddState = State::create([
                'state_name' => $request->state_id,
                'country_id' => 1 // default country ID if applicable
            ]);
            $state_id = $AddState->state_id;
        }

        // CITY
        if ($request->city_id_hidden != null) {
            $CheckCity = City::find($request->city_id_hidden);
            if ($CheckCity) {
                $city_id = $CheckCity->city_id;
            }
        } elseif ($request->city_id) {
            $AddCity = City::create([
                'city_nm' => $request->city_id,
                'state_id'  => $state_id
            ]);
            $city_id = $AddCity->city_id;
        }

        // AREA
        if ($request->area_id_hidden != null) {
            $CheckArea = Area::find($request->area_id_hidden);
            if ($CheckArea) {
                $area_id = $CheckArea->area_id;
            }
        } elseif ($request->area_id) {
            $AddArea = Area::create([
                'area_nm' => $request->area_id,
                'city_id'   => $city_id,
                'state_id' => $state_id,
            ]);
            $area_id = $AddArea->area_id;

            if ($request->pincode_id_hidden != null) {
                $AddZip = Zipcode::create([
                    'zipcode'  => $request->zipcode,
                    'city_id'  => $city_id,
                    'area_id'  => $area_id,
                    'state_id' => $state_id,
                ]);
                $zipcode_id = $AddZip->zipcode_id;
            }
        }

        // PINCODE
        if ($request->pincode_id_hidden != null) {
            $CheckZip = Zipcode::find($request->pincode_id_hidden);
            if ($CheckZip) {
                $zipcode_id = $CheckZip->zipcode_id;
            }
        } elseif ($request->zipcode) {
            $AddZip = Zipcode::create([
                'zipcode'  => $request->zipcode,
                'city_id'  => $city_id,
                'area_id'  => $area_id,
                'state_id' => $state_id,
            ]);
            $zipcode_id = $AddZip->zipcode_id;
        }


        // Create the user
        $user = User::create([
            'name' => $request->staff_name,
            'email' => $request->staff_email,
            'contact_no' => $request->staff_contact,
            'state_id' => $state_id,
            'city_id' => $city_id,
            'area_id' => $area_id,
            'zipcode_id' => $zipcode_id,
            'address' => $request->staff_type,
            'password' => Hash::make($request->staff_password),
            'role' => 'Staff',
            'active_status' => $request->staff_type,
        ]);


        $role = Role::find($request->staff_role); // fetch role by ID
        $user->assignRole($role->name); // assign role by name

        StaffActivityController::insertActivity(Auth::user()->id, 'Staff Added Successfully.');

        return response()->json([
            'status' => 1,
            'message' => "Staff Create Successfully"
        ], 200);
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
        $Roles = Role::get();
        $states = State::select('state_id', 'state_name')->get(); // replace with your table column names

        $users = DB::table('users as a')
            ->leftJoin('tbl_state as s', 'a.state_id', '=', 's.state_id')
            ->leftJoin('tbl_city as c', 'a.city_id', '=', 'c.city_id')
            ->leftJoin('tbl_area as d', 'a.area_id', '=', 'd.area_id')
            ->leftJoin('tbl_zipcode as e', 'a.zipcode_id', '=', 'e.zipcode_id')
            ->select(
                'a.*',
                's.state_name',
                's.state_id',
                'c.city_nm',
                'c.city_id',
                'd.area_nm',
                'd.area_id',
                'e.zipcode',
                'e.zipcode_id'
            )
            ->where('a.id', $id)
            ->first();


        $method = "PUT";
        $flag = "U";
        $row_id = $users->id;

        $userData = User::findOrFail($id);
        $userRole = $userData->roles->pluck('id')->first(); // This will give you the role ID

        return view('admin.staff.add-staff', compact('states', 'Roles', 'method', 'flag', 'row_id', 'userRole', 'users'));
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
            'staff_name' => 'required|string|max:255',
            'staff_email' => 'required|email|unique:users,email,' . $id,
            'staff_contact' => 'required|string|max:15',
            'state_id' => 'required',
            'city_id' => 'required',
            'area_id' => 'required',
            'zipcode' => 'required',
            'staff_address' => 'required|string|max:500',
            'staff_role' => 'required|string|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ], 200);
        }

        $user = User::findOrFail($id);

        $state_id = 0;
        $city_id = 0;
        $area_id = 0;
        $zipcode_id = 0;

        // STATE
        if ($request->state_id_hidden != null) {
            $CheckState = State::find($request->state_id_hidden);
            if ($CheckState) {
                $state_id = $CheckState->state_id;
            }
        } elseif ($request->state_id) {
            $AddState = State::create([
                'state_name' => $request->state_id,
                'country_id' => 1 // default country ID if applicable
            ]);
            $state_id = $AddState->state_id;
        }

        // CITY
        if ($request->city_id_hidden != null) {
            $CheckCity = City::find($request->city_id_hidden);
            if ($CheckCity) {
                $city_id = $CheckCity->city_id;
            }
        } elseif ($request->city_id) {
            $AddCity = City::create([
                'city_nm' => $request->city_id,
                'state_id'  => $state_id
            ]);
            $city_id = $AddCity->city_id;
        }

        // AREA
        if ($request->area_id_hidden != null) {
            $CheckArea = Area::find($request->area_id_hidden);
            if ($CheckArea) {
                $area_id = $CheckArea->area_id;
            }
        } elseif ($request->area_id) {
            $AddArea = Area::create([
                'area_nm' => $request->area_id,
                'city_id'   => $city_id,
                'state_id' => $state_id,
            ]);
            $area_id = $AddArea->area_id;

            if ($request->pincode_id_hidden != null) {
                $AddZip = Zipcode::create([
                    'zipcode'  => $request->zipcode,
                    'city_id'  => $city_id,
                    'area_id'  => $area_id,
                    'state_id' => $state_id,
                ]);
                $zipcode_id = $AddZip->zipcode_id;
            }
        }

        // PINCODE
        if ($request->pincode_id_hidden != null) {
            $CheckZip = Zipcode::find($request->pincode_id_hidden);
            if ($CheckZip) {
                $zipcode_id = $CheckZip->zipcode_id;
            }
        } elseif ($request->zipcode) {
            $AddZip = Zipcode::create([
                'zipcode'  => $request->zipcode,
                'city_id'  => $city_id,
                'area_id'  => $area_id,
                'state_id' => $state_id,
            ]);
            $zipcode_id = $AddZip->zipcode_id;
        }

        // Update user details
        $user->update([
            'name' => $request->staff_name,
            'email' => $request->staff_email,
            'contact_no' => $request->staff_contact,
            'state_id' => $state_id,
            'city_id' => $city_id,
            'area_id' => $area_id,
            'zipcode_id' => $zipcode_id,
            'address' => $request->staff_address,
            'active_status' => $request->staff_type,
        ]);

        // Sync role using Spatie
        $role = Role::find($request->staff_role); // fetch role by ID
        $user->assignRole($role->name); // assign role by name

        StaffActivityController::insertActivity(Auth::user()->id, 'Staff Update Successfully.');

        return response()->json([
            'status' => 1,
            'message' => "Staff updated successfully"
        ], 200);
    }


    public function RoleAssignSuperAdmin()
    {
        $user = User::findOrFail(1);
        $role = Role::find(3); // fetch role by ID
        $user->assignRole($role->name); // assign role by name
        
        return $role->name;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Staff not found.'
            ], 404);
        }

        $user->delete();

        StaffActivityController::insertActivity(Auth::user()->id, 'Staff Delete Successfully.');

        return response()->json([
            'status' => 1,
            'message' => 'Staff deleted successfully.'
        ]);
    }
    
    
    
    /**
     * Show assign internship page for staff users.
     */
    public function assignInternship()
    {
        $user = auth()->user() ?? auth()->guard('college_staff')->user() ?? auth()->guard('college')->user();

        // Only allow staff users to view this page; otherwise redirect to staff list
        $role = optional($user)->role ?? optional(optional($user)->roles->first())->name;
        if ($role !== 'Staff') {
            return redirect()->route('admin.staff.index');
        }

        return view('admin.staff.assign-internship');
    }

    /**
     * Super-admin page: show all assigned internships (only for users with Assign-Internship permission).
     */
    public function assignInternshipSuper()
    {
        $auth = auth()->user();
        // Allow access if user explicitly has the permission OR is an Admin role (fallback)
        $isAdminRole = optional($auth)->role === 'Admin' || optional(optional($auth)->roles->first())->name === 'Admin';
        if (! $auth || (! $auth->can('Assign-Internship') && ! $isAdminRole)) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.staff.assign-internship-super');
    }

    /**
     * DataTable endpoint returning assigned internship applications for super-admin view.
     */
    public function assignInternshipSuperData(Request $request)
    {
        if (! $request->ajax()) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        $auth = auth()->user();
        $isAdminRole = optional($auth)->role === 'Admin' || optional(optional($auth)->roles->first())->name === 'Admin';
        if (! $auth || (! $auth->can('Assign-Internship') && ! $isAdminRole)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = \App\Models\InternshipApplication::with(['user', 'internship'])
            ->whereNotNull('assigned_staff_id')
            ->orderBy('applied_on', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('student_name', function($row){
                return $row->user ? $row->user->name : 'N/A';
            })
            ->addColumn('internship_title', function($row){
                return $row->internship ? $row->internship->internship_title : 'N/A';
            })
            ->addColumn('assigned_to', function($row){
                // Try users table first (admin staff), else college_staff
                $assigned = \App\Models\User::find($row->assigned_staff_id);
                if ($assigned) return $assigned->name . ' (Admin Staff)';
                $c = \App\Models\CollegeStaff::find($row->assigned_staff_id);
                if ($c) return $c->name . ' (College Staff)';
                return 'Unknown';
            })
            ->addColumn('assigned_date', function($row){
                return $row->applied_on ? $row->applied_on->format('M d, Y') : '';
            })
            ->addColumn('action', function($row){
                $btn = '';
                if (auth()->user()->can('Internship-View')) {
                    $btn .= '<a href="' . route('admin.internship.view', $row->internship_id) . '" class="btn btn-sm btn-primary">View Internship</a>';
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
