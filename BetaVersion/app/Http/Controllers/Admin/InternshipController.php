<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InternshipController extends Controller
{
    /**
     * Display the internship management page
     */
    public function index()
    {
        return view('admin.internship.internship');
    }

    /**
     * Show the form for creating a new internship
     */
    public function create()
    {
        return view('admin.internship.create');
    }

    /**
     * Display the internship view page with all details
     */
    public function view($id)
    {
        // In production, fetch internship details from database
        // $internship = DB::table('internships')->where('id', $id)->first();
        // $students = DB::table('internship_enrollments')
        //     ->join('users', 'internship_enrollments.student_id', '=', 'users.id')
        //     ->where('internship_enrollments.internship_id', $id)
        //     ->select('users.*', 'internship_enrollments.status', 'internship_enrollments.progress')
        //     ->get();
        // $tasks = DB::table('internship_tasks')->where('internship_id', $id)->get();
        // $payments = DB::table('internship_payments')
        //     ->join('users', 'internship_payments.student_id', '=', 'users.id')
        //     ->where('internship_payments.internship_id', $id)
        //     ->get();
        
        // Log activity
        $this->logActivity('Viewed internship details (ID: ' . $id . ')');
        
        return view('admin.internship.view', compact('id'));
    }

    /**
     * Store a newly created internship in storage
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'internship_title' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'company_id' => 'required|integer',
            'company_website' => 'nullable|url|max:255',
            'internship_mode' => 'required|in:Online,Offline,Hybrid',
            'location' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'weeks' => 'required|integer|min:1',
            'hours' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'application_deadline' => 'required|date',
            'batch_time' => 'required|array',
            'stipend' => 'nullable|numeric|min:0',
            'openings' => 'required|integer|min:1',
            'internship_fee' => 'nullable|numeric|min:0',
            'late_registration_fee' => 'nullable|numeric|min:0',
            'late_register_last_date' => 'nullable|date',
            'gst_percentage' => 'nullable|numeric|min:0|max:100',
            'gst_amount' => 'nullable|numeric|min:0',
            'total_fee' => 'nullable|numeric|min:0',
            'required_skills' => 'nullable|string',
            'required_eligibility_criteria' => 'nullable|string',
            'internship_description' => 'required|string',
            'module_description' => 'required|string',
            'internship_objective' => 'required|string',
            'internship_outcome' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Prepare batch time data
            $batchTime = implode(',', $request->batch_time);
            
            // Prepare time slots
            $timeSlots = $request->time_slots;
            if ($request->time_slots_2) {
                $timeSlots .= ' | ' . $request->time_slots_2;
            }

            // Insert internship into database
            $internshipId = DB::table('internships')->insertGetId([
                'internship_title' => $request->internship_title,
                'category_id' => $request->category_id,
                'company_id' => $request->company_id,
                'company_website' => $request->company_website,
                'internship_mode' => $request->internship_mode,
                'location' => $request->location,
                'duration' => $request->duration,
                'weeks' => $request->weeks,
                'hours' => $request->hours,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'stipend' => $request->stipend ?? 0,
                'openings' => $request->openings,
                'application_deadline' => $request->application_deadline,
                'batch_time' => $batchTime,
                'time_slots' => $timeSlots,
                'internship_fee' => $request->internship_fee ?? 0,
                'late_registration_fee' => $request->late_registration_fee ?? 0,
                'late_register_last_date' => $request->late_register_last_date,
                'gst_percentage' => $request->gst_percentage ?? 0,
                'gst_amount' => $request->gst_amount ?? 0,
                'total_fee' => $request->total_fee ?? 0,
                'required_skills' => $request->required_skills,
                'required_eligibility_criteria' => $request->required_eligibility_criteria,
                'internship_description' => $request->internship_description,
                'module_description' => $request->module_description,
                'internship_objective' => $request->internship_objective,
                'internship_outcome' => $request->internship_outcome,
                'status' => 'active',
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Log activity
            $this->logActivity('internship_created', "Created new internship: {$request->internship_title}", $internshipId);

            return redirect()
                ->route('admin.internship.management')
                ->with('success', 'Internship created successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create internship: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Get New Requests DataTable
     */
    public function getNewRequestsData(Request $request)
    {
        if ($request->ajax()) {
            // Sample query - Replace with your actual internship applications table
            $data = DB::table('internship_applications')
                ->select([
                    'internship_applications.id',
                    'internship_applications.internship_name',
                    'internship_applications.company_name',
                    'internship_applications.duration_months',
                    'internship_applications.applied_date',
                    'internship_applications.student_name',
                    'internship_applications.student_email',
                    'internship_applications.university',
                    'internship_applications.status',
                    'internship_applications.created_at',
                ])
                ->where('internship_applications.status', 'pending')
                ->whereNull('internship_applications.deleted_at')
                ->orderBy('internship_applications.created_at', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status_badge', function ($row) {
                    return '<span class="badge bg-warning">Pending</span>';
                })
                ->addColumn('action', function ($row) {
                    $acceptBtn = '<button class="btn btn-action btn-accept btn-sm me-1" onclick="openAcceptModal(' . $row->id . ')">
                        <i class="bx bx-check"></i> Accept
                    </button>';
                    
                    $rejectBtn = '<button class="btn btn-action btn-reject btn-sm" onclick="rejectInternship(' . $row->id . ')">
                        <i class="bx bx-x"></i> Reject
                    </button>';

                    return $acceptBtn . $rejectBtn;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }
    }

    /**
     * Get Processing Internships DataTable
     */
    public function getProcessingData(Request $request)
    {
        if ($request->ajax()) {
            // Sample query - Replace with your actual internship table
            $data = DB::table('internship_applications')
                ->select([
                    'internship_applications.id',
                    'internship_applications.internship_name',
                    'internship_applications.company_name',
                    'internship_applications.duration_months',
                    'internship_applications.start_date',
                    'internship_applications.end_date',
                    'internship_applications.student_name',
                    'internship_applications.progress_percentage',
                    'internship_applications.status',
                ])
                ->where('internship_applications.status', 'in_progress')
                ->whereNull('internship_applications.deleted_at')
                ->orderBy('internship_applications.start_date', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('progress_bar', function ($row) {
                    $progress = $row->progress_percentage ?? 0;
                    return '<div class="progress" style="height: 20px;">
                        <div class="progress-bar" role="progressbar" style="width: ' . $progress . '%;" 
                             aria-valuenow="' . $progress . '" aria-valuemin="0" aria-valuemax="100">' . $progress . '%</div>
                    </div>';
                })
                ->addColumn('status_badge', function ($row) {
                    return '<span class="badge bg-info">In Progress</span>';
                })
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-action btn-view btn-sm" onclick="viewInternshipDetails(' . $row->id . ')">
                        <i class="bx bx-show"></i> View
                    </button>';
                })
                ->rawColumns(['progress_bar', 'status_badge', 'action'])
                ->make(true);
        }
    }

    /**
     * Get Completed Internships DataTable
     */
    public function getCompletedData(Request $request)
    {
        if ($request->ajax()) {
            // Sample query - Replace with your actual internship table
            $data = DB::table('internship_applications')
                ->select([
                    'internship_applications.id',
                    'internship_applications.internship_name',
                    'internship_applications.company_name',
                    'internship_applications.duration_months',
                    'internship_applications.completion_date',
                    'internship_applications.student_name',
                    'internship_applications.rating',
                    'internship_applications.certificate_status',
                ])
                ->where('internship_applications.status', 'completed')
                ->whereNull('internship_applications.deleted_at')
                ->orderBy('internship_applications.completion_date', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('rating_stars', function ($row) {
                    $rating = $row->rating ?? 0;
                    $stars = '';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= floor($rating)) {
                            $stars .= '<i class="bx bxs-star text-warning"></i>';
                        } elseif ($i == ceil($rating) && $rating - floor($rating) >= 0.5) {
                            $stars .= '<i class="bx bxs-star-half text-warning"></i>';
                        } else {
                            $stars .= '<i class="bx bx-star text-warning"></i>';
                        }
                    }
                    return $stars;
                })
                ->addColumn('certificate_badge', function ($row) {
                    if ($row->certificate_status == 'issued') {
                        return '<span class="badge bg-success">Issued</span>';
                    } else {
                        return '<span class="badge bg-secondary">Pending</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-action btn-view btn-sm" onclick="viewInternshipDetails(' . $row->id . ')">
                        <i class="bx bx-show"></i> View
                    </button>';
                })
                ->rawColumns(['rating_stars', 'certificate_badge', 'action'])
                ->make(true);
        }
    }

    /**
     * Get internship details for modal
     */
    public function getInternshipDetails($id)
    {
        try {
            // Replace with your actual query
            $internship = DB::table('internship_applications')
                ->where('id', $id)
                ->first();

            if (!$internship) {
                return response()->json([
                    'success' => false,
                    'message' => 'Internship not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $internship
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching internship details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Accept internship application
     */
    public function acceptInternship(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'internship_id' => 'required|integer',
                'registration_fees' => 'required|numeric|min:0',
                'last_register_date' => 'required|date',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'total_seats' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update the internship application
            DB::table('internship_applications')
                ->where('id', $request->internship_id)
                ->update([
                    'status' => 'accepted',
                    'registration_fees' => $request->registration_fees,
                    'last_register_date' => $request->last_register_date,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'total_seats' => $request->total_seats,
                    'mentor_name' => $request->mentor_name,
                    'prerequisites' => $request->prerequisites,
                    'learning_objectives' => $request->learning_objectives,
                    'certificate_type' => $request->certificate_type,
                    'evaluation_criteria' => $request->evaluation_criteria,
                    'special_notes' => $request->special_notes,
                    'updated_at' => now(),
                ]);

            // Send notifications if checkboxes are checked
            if ($request->send_welcome_email) {
                // Send email to student
                // Implement your email sending logic here
            }

            if ($request->notify_company) {
                // Send notification to company
                // Implement your notification logic here
            }

            // Log activity
            $this->logActivity('Accepted internship application ID: ' . $request->internship_id);

            return response()->json([
                'success' => true,
                'message' => 'Internship application accepted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error accepting internship: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject internship application
     */
    public function rejectInternship(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'internship_id' => 'required|integer',
                'rejection_reason' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update the internship application
            DB::table('internship_applications')
                ->where('id', $request->internship_id)
                ->update([
                    'status' => 'rejected',
                    'rejection_reason' => $request->rejection_reason,
                    'updated_at' => now(),
                ]);

            // Send rejection email to student
            // Implement your email sending logic here

            // Log activity
            $this->logActivity('Rejected internship application ID: ' . $request->internship_id);

            return response()->json([
                'success' => true,
                'message' => 'Internship application rejected successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error rejecting internship: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update internship progress
     */
    public function updateProgress(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'internship_id' => 'required|integer',
                'progress_percentage' => 'required|integer|min:0|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::table('internship_applications')
                ->where('id', $request->internship_id)
                ->update([
                    'progress_percentage' => $request->progress_percentage,
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Progress updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating progress: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics for badge counts
     */
    public function getStatistics()
    {
        try {
            $newCount = DB::table('internship_applications')
                ->where('status', 'pending')
                ->whereNull('deleted_at')
                ->count();

            $processingCount = DB::table('internship_applications')
                ->where('status', 'in_progress')
                ->whereNull('deleted_at')
                ->count();

            $completeCount = DB::table('internship_applications')
                ->where('status', 'completed')
                ->whereNull('deleted_at')
                ->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'new' => $newCount,
                    'processing' => $processingCount,
                    'complete' => $completeCount,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Log admin activity
     */
    private function logActivity($description)
    {
        try {
            DB::table('staff_activities')->insert([
                'user_id' => Auth::id(),
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Log error but don't fail the main operation
            \Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }

    /**
     * Display certificate management page
     */
    public function certificates()
    {
        // Log activity
        $this->logActivity('Accessed certificate management page');
        
        return view('admin.internship.certificates');
    }

    /**
     * Get students with certificates for a specific internship
     */
    public function getCertificateStudents($id)
    {
        try {
            // In production, fetch actual data from database
            // $internship = DB::table('internships')->where('id', $id)->first();
            
            // $students = DB::table('internship_enrollments')
            //     ->join('users', 'internship_enrollments.student_id', '=', 'users.id')
            //     ->join('certificates', 'internship_enrollments.id', '=', 'certificates.enrollment_id')
            //     ->where('internship_enrollments.internship_id', $id)
            //     ->where('internship_enrollments.status', 'completed')
            //     ->select(
            //         'users.id',
            //         'users.name',
            //         'users.email',
            //         'users.university',
            //         'certificates.certificate_number',
            //         'certificates.issue_date',
            //         'certificates.download_count',
            //         'internship_enrollments.completion_date'
            //     )
            //     ->get();

            // $statistics = [
            //     'total_students' => $students->count(),
            //     'certificates_generated' => $students->count(),
            //     'total_downloads' => $students->sum('download_count')
            // ];

            // Sample data for demonstration
            $students = [
                [
                    'id' => 1,
                    'name' => 'Rahul Sharma',
                    'email' => 'rahul@example.com',
                    'university' => 'Gujarat University',
                    'certificate_number' => 'CERT-2026-001',
                    'completion_date' => '10 Jan 2026',
                    'download_count' => 5
                ],
                [
                    'id' => 2,
                    'name' => 'Priya Patel',
                    'email' => 'priya@example.com',
                    'university' => 'Mumbai University',
                    'certificate_number' => 'CERT-2026-002',
                    'completion_date' => '10 Jan 2026',
                    'download_count' => 3
                ],
                [
                    'id' => 3,
                    'name' => 'Amit Kumar',
                    'email' => 'amit@example.com',
                    'university' => 'Delhi University',
                    'certificate_number' => 'CERT-2026-003',
                    'completion_date' => '10 Jan 2026',
                    'download_count' => 8
                ]
            ];

            $statistics = [
                'total_students' => 25,
                'certificates_generated' => 25,
                'total_downloads' => 187
            ];

            // Log activity
            $this->logActivity('Viewed certificates for internship ID: ' . $id);

            return response()->json([
                'success' => true,
                'students' => $students,
                'statistics' => $statistics
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching certificate data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download certificate for a specific student
     */
    public function downloadCertificate($studentId)
    {
        try {
            // In production, fetch certificate data
            // $certificate = DB::table('certificates')
            //     ->join('internship_enrollments', 'certificates.enrollment_id', '=', 'internship_enrollments.id')
            //     ->join('users', 'internship_enrollments.student_id', '=', 'users.id')
            //     ->join('internships', 'internship_enrollments.internship_id', '=', 'internships.id')
            //     ->where('users.id', $studentId)
            //     ->select(
            //         'users.name as student_name',
            //         'internships.title as internship_title',
            //         'internships.company_name',
            //         'certificates.certificate_number',
            //         'certificates.issue_date',
            //         'internships.duration'
            //     )
            //     ->first();

            // if (!$certificate) {
            //     return response()->json(['error' => 'Certificate not found'], 404);
            // }

            // Generate PDF using a library like TCPDF or DomPDF
            // $pdf = PDF::loadView('admin.internship.certificate-pdf', compact('certificate'));
            // 
            // // Update download count
            // DB::table('certificates')
            //     ->where('enrollment_id', $certificate->enrollment_id)
            //     ->increment('download_count');
            //
            // // Log activity
            // $this->logActivity('Downloaded certificate for student: ' . $certificate->student_name);
            //
            // return $pdf->download('Certificate_' . $certificate->certificate_number . '.pdf');

            // For demonstration, return JSON
            $this->logActivity('Downloaded certificate for student ID: ' . $studentId);
            
            return response()->json([
                'success' => true,
                'message' => 'Certificate download initiated',
                'student_id' => $studentId
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error downloading certificate: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download all certificates for an internship as ZIP
     */
    public function downloadAllCertificates($internshipId)
    {
        try {
            // In production, fetch all certificates for the internship
            // $students = DB::table('internship_enrollments')
            //     ->join('users', 'internship_enrollments.student_id', '=', 'users.id')
            //     ->join('certificates', 'internship_enrollments.id', '=', 'certificates.enrollment_id')
            //     ->join('internships', 'internship_enrollments.internship_id', '=', 'internships.id')
            //     ->where('internship_enrollments.internship_id', $internshipId)
            //     ->where('internship_enrollments.status', 'completed')
            //     ->get();

            // // Create ZIP file
            // $zip = new \ZipArchive();
            // $zipFileName = 'certificates_internship_' . $internshipId . '_' . time() . '.zip';
            // $zipPath = storage_path('app/temp/' . $zipFileName);
            //
            // if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
            //     foreach ($students as $student) {
            //         // Generate PDF for each student
            //         $pdf = PDF::loadView('admin.internship.certificate-pdf', compact('student'));
            //         $pdfContent = $pdf->output();
            //         $zip->addFromString('Certificate_' . $student->name . '.pdf', $pdfContent);
            //     }
            //     $zip->close();
            // }
            //
            // // Log activity
            // $this->logActivity('Downloaded all certificates for internship ID: ' . $internshipId);
            //
            // return response()->download($zipPath)->deleteFileAfterSend(true);

            // For demonstration
            $this->logActivity('Downloaded all certificates for internship ID: ' . $internshipId);
            
            return response()->json([
                'success' => true,
                'message' => 'All certificates download initiated',
                'internship_id' => $internshipId
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error downloading certificates: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export certificates data to Excel/CSV
     */
    public function exportCertificates()
    {
        try {
            // In production, fetch all certificate data
            // $certificates = DB::table('certificates')
            //     ->join('internship_enrollments', 'certificates.enrollment_id', '=', 'internship_enrollments.id')
            //     ->join('users', 'internship_enrollments.student_id', '=', 'users.id')
            //     ->join('internships', 'internship_enrollments.internship_id', '=', 'internships.id')
            //     ->select(
            //         'certificates.certificate_number',
            //         'users.name as student_name',
            //         'users.email',
            //         'internships.title as internship_title',
            //         'internships.company_name',
            //         'certificates.issue_date',
            //         'internship_enrollments.completion_date',
            //         'certificates.download_count'
            //     )
            //     ->get();

            // // Use Laravel Excel package to export
            // return Excel::download(new CertificatesExport($certificates), 'certificates_' . date('Y-m-d') . '.xlsx');

            // For demonstration
            $this->logActivity('Exported certificates data');
            
            return response()->json([
                'success' => true,
                'message' => 'Certificates export initiated'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error exporting certificates: ' . $e->getMessage()
            ], 500);
        }
    }
}

