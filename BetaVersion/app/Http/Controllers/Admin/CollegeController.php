<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CollegeController extends Controller
{
    /**
     * Display the college management page
     */
    public function index()
    {
        return view('admin.college.index');
    }

    /**
     * Get colleges data for DataTable
     */
    public function getCollegesData(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('colleges')
                ->select([
                    'colleges.id',
                    'colleges.college_name',
                    'colleges.college_code',
                    'colleges.university_name',
                    'colleges.city',
                    'colleges.state',
                    'colleges.college_type',
                    'colleges.established_year',
                    'colleges.contact_number',
                    'colleges.status',
                    'colleges.created_at',
                ])
                ->whereNull('colleges.deleted_at')
                ->orderBy('colleges.college_name', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('type_badge', function ($row) {
                    $badges = [
                        'Government' => 'badge-govt',
                        'Private' => 'badge-private',
                        'Autonomous' => 'badge-autonomous',
                        'Deemed' => 'badge bg-warning'
                    ];
                    $badgeClass = $badges[$row->college_type] ?? 'badge bg-secondary';
                    return '<span class="badge ' . $badgeClass . '">' . $row->college_type . '</span>';
                })
                ->addColumn('status_badge', function ($row) {
                    $statusClass = $row->status == 'Active' ? 'bg-success' : 'bg-secondary';
                    return '<span class="badge ' . $statusClass . '">' . $row->status . '</span>';
                })
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-edit-college btn-sm me-1" onclick="editCollege(' . $row->id . ')">
                                <i class="bx bx-edit"></i> Edit
                            </button>
                            <button class="btn btn-delete-college btn-sm" onclick="deleteCollege(' . $row->id . ')">
                                <i class="bx bx-trash"></i> Delete
                            </button>';
                })
                ->rawColumns(['type_badge', 'status_badge', 'action'])
                ->make(true);
        }
    }

    /**
     * Store a newly created college
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'college_name' => 'required|string|max:255',
            'college_code' => 'nullable|string|max:50|unique:colleges,college_code',
            'university_id' => 'required|integer',
            'affiliation' => 'nullable|string|max:255',
            'college_type' => 'required|in:Government,Private,Autonomous,Deemed',
            'established_year' => 'required|integer|min:1800|max:2026',
            'status' => 'required|in:Active,Inactive',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:6',
            'contact_number' => 'required|string|max:20',
            'alternate_contact' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'principal_name' => 'nullable|string|max:255',
            'total_students' => 'nullable|integer|min:0',
            'courses_offered' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get university name
            $universityName = DB::table('universities')->where('id', $request->university_id)->value('name');

            $collegeId = DB::table('colleges')->insertGetId([
                'college_name' => $request->college_name,
                'college_code' => $request->college_code,
                'university_id' => $request->university_id,
                'university_name' => $universityName ?? 'N/A',
                'affiliation' => $request->affiliation,
                'college_type' => $request->college_type,
                'established_year' => $request->established_year,
                'status' => $request->status ?? 'Active',
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'contact_number' => $request->contact_number,
                'alternate_contact' => $request->alternate_contact,
                'email' => $request->email,
                'website' => $request->website,
                'principal_name' => $request->principal_name,
                'total_students' => $request->total_students,
                'courses_offered' => $request->courses_offered,
                'description' => $request->description,
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Log activity
            $this->logActivity('college_created', "Created new college: {$request->college_name}", $collegeId);

            return response()->json([
                'success' => true,
                'message' => 'College added successfully!',
                'college_id' => $collegeId
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add college: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get college details for editing
     */
    public function edit($id)
    {
        try {
            $college = DB::table('colleges')
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if (!$college) {
                return response()->json([
                    'success' => false,
                    'message' => 'College not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'college' => $college
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch college details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update college information
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'college_id' => 'required|integer|exists:colleges,id',
            'college_name' => 'required|string|max:255',
            'college_code' => 'nullable|string|max:50|unique:colleges,college_code,' . $request->college_id,
            'university_id' => 'required|integer',
            'college_type' => 'required|in:Government,Private,Autonomous,Deemed',
            'established_year' => 'required|integer|min:1800|max:2026',
            'status' => 'required|in:Active,Inactive',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get university name
            $universityName = DB::table('universities')->where('id', $request->university_id)->value('name');

            DB::table('colleges')
                ->where('id', $request->college_id)
                ->update([
                    'college_name' => $request->college_name,
                    'college_code' => $request->college_code,
                    'university_id' => $request->university_id,
                    'university_name' => $universityName ?? 'N/A',
                    'affiliation' => $request->affiliation,
                    'college_type' => $request->college_type,
                    'established_year' => $request->established_year,
                    'status' => $request->status,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'pincode' => $request->pincode,
                    'contact_number' => $request->contact_number,
                    'alternate_contact' => $request->alternate_contact,
                    'email' => $request->email,
                    'website' => $request->website,
                    'principal_name' => $request->principal_name,
                    'total_students' => $request->total_students,
                    'courses_offered' => $request->courses_offered,
                    'description' => $request->description,
                    'updated_by' => Auth::id(),
                    'updated_at' => now(),
                ]);

            // Log activity
            $this->logActivity('college_updated', "Updated college: {$request->college_name}", $request->college_id);

            return response()->json([
                'success' => true,
                'message' => 'College updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update college: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete college
     */
    public function destroy($id)
    {
        try {
            $college = DB::table('colleges')->where('id', $id)->first();

            if (!$college) {
                return response()->json([
                    'success' => false,
                    'message' => 'College not found'
                ], 404);
            }

            // Soft delete
            DB::table('colleges')
                ->where('id', $id)
                ->update([
                    'deleted_at' => now(),
                    'deleted_by' => Auth::id()
                ]);

            // Log activity
            $this->logActivity('college_deleted', "Deleted college: {$college->college_name}", $id);

            return response()->json([
                'success' => true,
                'message' => 'College deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete college: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get college statistics
     */
    public function getStatistics()
    {
        try {
            $stats = [
                'total_colleges' => DB::table('colleges')->whereNull('deleted_at')->count(),
                'active_colleges' => DB::table('colleges')->where('status', 'Active')->whereNull('deleted_at')->count(),
                'government_colleges' => DB::table('colleges')->where('college_type', 'Government')->whereNull('deleted_at')->count(),
                'private_colleges' => DB::table('colleges')->where('college_type', 'Private')->whereNull('deleted_at')->count(),
            ];

            return response()->json([
                'success' => true,
                'statistics' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Log admin activity
     */
    private function logActivity($action, $description, $collegeId = null)
    {
        try {
            DB::table('staff_activities')->insert([
                'staff_id' => Auth::id(),
                'action' => $action,
                'description' => $description,
                'reference_id' => $collegeId,
                'reference_type' => 'college',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Log error but don't fail the main operation
            \Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }
}
