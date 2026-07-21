<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CollegeDashboardController extends Controller
{
    /**
     * Display the college dashboard
     */
    public function index()
    {
        // Get statistics
        $totalStudents = 245; // Replace with actual query: DB::table('students')->count();
        $activeInternships = 38; // Replace with actual query
        $pendingApplications = 67; // Replace with actual query
        $completedInternships = 124; // Replace with actual query

        // Get recent students
        // $recentStudents = DB::table('students')
        //     ->orderBy('created_at', 'desc')
        //     ->limit(5)
        //     ->get();

        // Get recent applications
        // $recentApplications = DB::table('internship_applications')
        //     ->join('students', 'internship_applications.student_id', '=', 'students.id')
        //     ->join('internships', 'internship_applications.internship_id', '=', 'internships.id')
        //     ->orderBy('internship_applications.created_at', 'desc')
        //     ->limit(3)
        //     ->get();

        return view('college-dashboard.index', compact(
            'totalStudents',
            'activeInternships',
            'pendingApplications',
            'completedInternships'
        ));
    }

    /**
     * Display all students list
     */
    public function students()
    {
        // Get all students with filters
        // $students = DB::table('students')
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        return view('college-dashboard.students');
    }

    /**
     * Display all internship applications
     */
    public function applications()
    {
        // Get application statistics
        $pendingCount = 67; // Replace with actual query
        $approvedCount = 38; // Replace with actual query
        $inProgressCount = 52; // Replace with actual query
        $completedCount = 124; // Replace with actual query

        // Get all applications
        // $applications = DB::table('internship_applications')
        //     ->join('students', 'internship_applications.student_id', '=', 'students.id')
        //     ->join('internships', 'internship_applications.internship_id', '=', 'internships.id')
        //     ->join('companies', 'internships.company_id', '=', 'companies.id')
        //     ->select(
        //         'internship_applications.*',
        //         'students.name as student_name',
        //         'students.enrollment_no',
        //         'internships.title as internship_title',
        //         'internships.duration',
        //         'internships.stipend',
        //         'companies.name as company_name'
        //     )
        //     ->orderBy('internship_applications.created_at', 'desc')
        //     ->get();

        return view('college-dashboard.applications', compact(
            'pendingCount',
            'approvedCount',
            'inProgressCount',
            'completedCount'
        ));
    }

    /**
     * Get students table data for AJAX DataTable
     */
    public function getStudentsData(Request $request)
    {
        // DataTable server-side processing
        // Implement DataTables server-side logic here
        
        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => 245,
            'recordsFiltered' => 245,
            'data' => []
        ]);
    }

    /**
     * Get applications table data for AJAX DataTable
     */
    public function getApplicationsData(Request $request)
    {
        // DataTable server-side processing
        // Implement DataTables server-side logic here
        
        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => 281,
            'recordsFiltered' => 281,
            'data' => []
        ]);
    }

    /**
     * Store a new student
     */
    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'enrollment_no' => 'required|string|unique:students,enrollment_no',
            'phone' => 'required|string|max:15',
            'department' => 'required|string',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        // Insert student into database
        // DB::table('students')->insert([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'enrollment_no' => $request->enrollment_no,
        //     'phone' => $request->phone,
        //     'department' => $request->department,
        //     'semester' => $request->semester,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        return response()->json([
            'success' => true,
            'message' => 'Student added successfully'
        ]);
    }

    /**
     * Update student status
     */
    public function updateStudentStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,pending,completed'
        ]);

        // Update student status
        // DB::table('students')
        //     ->where('id', $id)
        //     ->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }

    /**
     * Update application status
     */
    public function updateApplicationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,in-progress,completed'
        ]);

        // Update application status
        // DB::table('internship_applications')
        //     ->where('id', $id)
        //     ->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Application status updated successfully'
        ]);
    }

    /**
     * Delete a student
     */
    public function deleteStudent($id)
    {
        // Delete student
        // DB::table('students')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully'
        ]);
    }

    /**
     * Export students data
     */
    public function exportStudents()
    {
        // Export logic (CSV/Excel)
        // Use Laravel Excel package or custom CSV export
        
        return response()->download(storage_path('exports/students.csv'));
    }

    /**
     * Export applications data
     */
    public function exportApplications()
    {
        // Export logic (CSV/Excel)
        
        return response()->download(storage_path('exports/applications.csv'));
    }
}
