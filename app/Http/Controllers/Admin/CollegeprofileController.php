<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\User;
use App\Models\Internship;
use App\Models\InternshipApplication;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CollegeprofileController extends Controller
{
    /**
     * Display college profile
     */
    public function index($id)
    {
        $college = College::with('university')->findOrFail($id);
        
        // Calculate profile completion percentage
        $completion = $this->calculateProfileCompletion($college);
        
        // Get summary counts
        $totalStudents = User::where('college_id', $id)->count();
        
        $studentIds = User::where('college_id', $id)->pluck('id');
        
        // Get counts using InternshipApplication table directly
        if ($studentIds->isEmpty()) {
            $activeInternships = 0;
            $completedInternships = 0;
            $totalApplications = 0;
        } else {
            $activeInternships = Internship::whereIn('id', function($q) use ($studentIds) {
                    $q->select('internship_id')
                      ->from('tbl_internship_application')
                      ->whereIn('user_id', $studentIds)
                      ->distinct();
                })
                ->where('approve_status', 1)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->count();
                
            $completedInternships = Internship::whereIn('id', function($q) use ($studentIds) {
                    $q->select('internship_id')
                      ->from('tbl_internship_application')
                      ->whereIn('user_id', $studentIds)
                      ->distinct();
                })
                ->where('end_date', '<', now())
                ->count();
                
            $totalApplications = InternshipApplication::whereIn('user_id', $studentIds)->count();
        }
        
        return view('admin.collegeprofile.college-profile', compact(
            'college', 
            'completion',
            'totalStudents',
            'activeInternships',
            'completedInternships',
            'totalApplications'
        ));
    }
    
    /**
     * Calculate profile completion percentage
     */
    private function calculateProfileCompletion($college)
    {
        $fields = [
            'college_name', 'college_code', 'university_id', 'email', 'phone',
            'website', 'established_year', 'address', 'city', 'state', 'pincode', 'logo'
        ];
        
        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($college->$field)) {
                $filled++;
            }
        }
        
        return round(($filled / count($fields)) * 100);
    }
    
    /**
     * Update college profile
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'college_id' => 'required|exists:tbl_college,id',
            'college_name' => 'required|string|max:255',
            'college_code' => 'nullable|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'website' => 'nullable|url|max:255',
            'established_year' => 'nullable|string|max:4',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $college = College::findOrFail($request->college_id);
            
            $data = [
                'college_name' => $request->college_name,
                'college_code' => $request->college_code,
                'email' => $request->email,
                'phone' => $request->phone,
                'website' => $request->website,
                'established_year' => $request->established_year,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
            ];
            
            // Handle logo upload
            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                $logoName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/college'), $logoName);
                $data['logo'] = 'uploads/college/' . $logoName;
                
                // Delete old logo if exists
                if ($college->logo && file_exists(public_path($college->logo))) {
                    @unlink(public_path($college->logo));
                }
            }
            
            $college->update($data);
            
            return response()->json([
                'success' => true,
                'message' => 'College profile updated successfully!',
                'completion' => $this->calculateProfileCompletion($college)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get students data for DataTable
     */
    public function getStudentsData(Request $request)
    {
        $collegeId = $request->college_id;
        
        $query = User::where('college_id', $collegeId)
            ->where('role', 'User')
            ->with('degree', 'major')
            ->select('users.*');
        
        // Apply filters
        if ($request->has('name') && $request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        if ($request->has('email') && $request->email) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        
        if ($request->has('degree_id') && $request->degree_id) {
            $query->where('degree_id', $request->degree_id);
        }
        
        if ($request->has('major_id') && $request->major_id) {
            $query->where('major_id', $request->major_id);
        }
        
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('student_name', function($row) {
                return $row->name ?: 'N/A';
            })
            ->addColumn('student_email', function($row) {
                return $row->email ?: 'N/A';
            })
            ->addColumn('student_phone', function($row) {
                return $row->contact_no ?: 'N/A';
            })
            ->addColumn('degree_name', function($row) {
                return $row->degree ? $row->degree->degree_name : 'N/A';
            })
            ->addColumn('major_name', function($row) {
                return $row->major ? $row->major->major_name : 'N/A';
            })
            ->addColumn('registration_date', function($row) {
                return $row->created_at ? $row->created_at->format('d M Y') : 'N/A';
            })
            ->addColumn('action', function($row) {
                return '<a href="' . url('/admin/candidate-profile/' . $row->id) . '" class="btn btn-sm btn-primary" target="_blank">
                    <i class="bx bx-show"></i> View Profile
                </a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    /**
     * Get internships data for DataTable
     */
    public function getInternshipsData(Request $request)
    {
        $collegeId = $request->college_id;
        
        // Get student IDs from this college
        $studentIds = User::where('college_id', $collegeId)->pluck('id');
        
        // Handle case when no students found
        if ($studentIds->isEmpty()) {
            return DataTables::of(Internship::whereRaw('1 = 0'))->make(true);
        }
        
        // Get internships with count of applications from students of this college
        $query = Internship::select('tbl_internship.*')
            ->selectRaw('(SELECT COUNT(DISTINCT ia.id) FROM tbl_internship_application ia WHERE ia.internship_id = tbl_internship.id AND ia.user_id IN (' . $studentIds->implode(',') . ')) as applied_students')
            ->whereIn('id', function($q) use ($studentIds) {
                $q->select('internship_id')
                  ->from('tbl_internship_application')
                  ->whereIn('user_id', $studentIds)
                  ->distinct();
            });
        
        // Apply filters
        if ($request->has('internship_name') && $request->internship_name) {
            $query->where('internship_title', 'like', '%' . $request->internship_name . '%');
        }
        
        if ($request->has('company_name') && $request->company_name) {
            $query->whereHas('company', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->company_name . '%');
            });
        }
        
        if ($request->has('status') && $request->status) {
            $now = now();
            if ($request->status == 'active') {
                $query->where('approve_status', 1)
                      ->where('start_date', '<=', $now)
                      ->where('end_date', '>=', $now);
            } elseif ($request->status == 'completed') {
                $query->where('end_date', '<', $now);
            } elseif ($request->status == 'upcoming') {
                $query->where('start_date', '>', $now);
            }
        }
        
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }
        
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('company_name', function($row) {
                return $row->company ? $row->company->name : 'N/A';
            })
            ->addColumn('start_date', function($row) {
                return $row->start_date ? date('d M Y', strtotime($row->start_date)) : 'N/A';
            })
            ->addColumn('end_date', function($row) {
                return $row->end_date ? date('d M Y', strtotime($row->end_date)) : 'N/A';
            })
            ->addColumn('status_badge', function($row) {
                $now = now();
                $start = \Carbon\Carbon::parse($row->start_date);
                $end = \Carbon\Carbon::parse($row->end_date);
                
                if ($end->lt($now)) {
                    return '<span class="badge bg-secondary">Completed</span>';
                } elseif ($start->gt($now)) {
                    return '<span class="badge bg-warning">Upcoming</span>';
                } else {
                    return '<span class="badge bg-success">Active</span>';
                }
            })
            ->addColumn('action', function($row) {
                return '<a href="' . url('admin/internship/view/' . $row->id) . '" class="btn btn-sm btn-info" target="_blank">
                    <i class="bx bx-show"></i> View
                </a>';
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }
    
    /**
     * Deactivate college account
     */
    public function deactivate(Request $request)
    {
        try {
            $college = College::findOrFail($request->college_id);

            // Accept explicit status (1 = active, 0 = inactive). If not provided, toggle.
            $requestedStatus = $request->has('status') ? $request->input('status') : null;
            if (!is_null($requestedStatus)) {
                // normalize to integer 1 or 0
                $newStatus = intval($requestedStatus) === 1 ? 1 : 0;
            } else {
                // toggle
                $curr = $college->status;
                $newStatus = (intval($curr) === 1) ? 0 : 1;
            }

            $college->update(['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => $newStatus === 1 ? 'College account activated successfully!' : 'College account deactivated successfully!',
                'status' => $newStatus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to deactivate account: ' . $e->getMessage()
            ], 500);
        }
    }
}
