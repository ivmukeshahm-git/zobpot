@push('css')
    <style>
        .stats-card {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .staff-section-card {
            background: #fff; border-radius: 12px; border: 2px solid #242a62;
            overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,.08); margin-bottom: 30px;
        }
        .staff-section-header {
            background: linear-gradient(135deg, #242a62, #3d4575); color: #fff;
            padding: 20px 25px; display: flex; align-items: center; gap: 10px;
        }
        .staff-section-header h5 { margin: 0; font-weight: 700; font-size: 18px; color: #fff; }
    </style>
@endpush

@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "College-Dashboard";
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card" style="background: linear-gradient(135deg, #242a62 0%, #3a4799 100%); border-radius: 12px; color: white;">
                    <div class="card-body" style="padding: 30px;">
                        @php
                            $authUser = auth()->guard('college')->user() ?? auth()->guard('college_staff')->user();
                            $welcomeName = auth()->guard('college')->check()
                                ? ($authUser->college_name ?? 'College')
                                : ($authUser->name ?? 'Staff');
                        @endphp
                        <h3 style="color: white; font-weight: 700; margin-bottom: 10px;">
                            Welcome, {{ $welcomeName }}
                        </h3>
                        <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 15px;">
                            @if($isCollegeStaff)
                                Manage assigned internships and track student progress
                            @else
                                Manage your students, track internship applications, and monitor college activities
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @if($isCollegeStaff)
        {{-- ══════════════ COLLEGE STAFF DASHBOARD ══════════════ --}}
        <!-- Staff Statistics Cards -->
        <div class="row mb-4 g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card stats-card" style="background: #e7f3ff; border-color: #2196F3;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <h5 class="mb-1" style="font-size: 28px; font-weight: 700; color: #242a62;">{{ $assignedInternships }}</h5>
                                <small style="font-size: 15px; font-weight: 600; color: #666;">Assign Internship</small>
                            </div>
                            <span class="badge rounded-circle p-3" style="background: #2196F3;">
                                <i class="bx bx-briefcase bx-lg" style="color: white;"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card stats-card" style="background: #e8f5e9; border-color: #4CAF50;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <h5 class="mb-1" style="font-size: 28px; font-weight: 700; color: #242a62;">{{ $assignedStudents }}</h5>
                                <small style="font-size: 15px; font-weight: 600; color: #666;">Assign Student</small>
                            </div>
                            <span class="badge rounded-circle p-3" style="background: #4CAF50;">
                                <i class="bx bx-user bx-lg" style="color: white;"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card stats-card" style="background: #fff3e0; border-color: #FF9800;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <h5 class="mb-1" style="font-size: 28px; font-weight: 700; color: #242a62;">{{ $staffProcessingInternships }}</h5>
                                <small style="font-size: 15px; font-weight: 600; color: #666;">In Processing Internship</small>
                            </div>
                            <span class="badge rounded-circle p-3" style="background: #FF9800;">
                                <i class="bx bx-loader-circle bx-lg" style="color: white;"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card stats-card" style="background: #f3e5f5; border-color: #9C27B0;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <h5 class="mb-1" style="font-size: 28px; font-weight: 700; color: #242a62;">{{ $staffCompletedInternships }}</h5>
                                <small style="font-size: 15px; font-weight: 600; color: #666;">Complete Internship</small>
                            </div>
                            <span class="badge rounded-circle p-3" style="background: #9C27B0;">
                                <i class="bx bx-check-circle bx-lg" style="color: white;"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assigned Students Table -->
        <div class="staff-section-card">
            <div class="staff-section-header">
                <i class="bx bx-user" style="font-size:24px;"></i>
                <h5>Assign Student List</h5>
            </div>
            <div style="padding: 25px;">
                <div class="table-responsive">
                    <table class="table table-hover" id="assignedStudentsTable" style="width:100%">
                        <thead >
                            <tr>
                                <th>Sr No</th>
                                <th>Student Name</th>
                                <th>Internship</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Assigned Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Staff Internships Table -->
        <div class="staff-section-card">
            <div class="staff-section-header">
                <i class="bx bx-briefcase-alt-2" style="font-size:24px;"></i>
                <h5>Internship List</h5>
            </div>
            <div style="padding: 25px;">
                <div class="table-responsive">
                    <table class="table table-hover" id="staffInternshipsTable" style="width:100%">
                        <thead >
                            <tr>
                                <th>Sr No</th>
                                <th>Internship Title</th>
                                <th>Company</th>
                                <th>Duration</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Total Students</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        @else
        {{-- ══════════════ COLLEGE ADMIN DASHBOARD ══════════════ --}}
        <!-- Statistics Cards -->
        <div class="row mb-4 g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card stats-card" style="background: #e7f3ff; border-color: #2196F3;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <h5 class="mb-1" style="font-size: 28px; font-weight: 700; color: #242a62;">{{ $totalStudents }}</h5>
                                <small style="font-size: 15px; font-weight: 600; color: #666;">Total Students</small>
                            </div>
                            <span class="badge rounded-circle p-3" style="background: #2196F3;">
                                <i class="bx bx-user bx-lg" style="color: white;"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card stats-card" style="background: #e8f5e9; border-color: #4CAF50;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <h5 class="mb-1" style="font-size: 28px; font-weight: 700; color: #242a62;">{{ $activeInternships }}</h5>
                                <small style="font-size: 15px; font-weight: 600; color: #666;">Active Internships</small>
                            </div>
                            <span class="badge rounded-circle p-3" style="background: #4CAF50;">
                                <i class="bx bx-briefcase bx-lg" style="color: white;"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card stats-card" style="background: #fff3e0; border-color: #FF9800;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <h5 class="mb-1" style="font-size: 28px; font-weight: 700; color: #242a62;">{{ $pendingApplications }}</h5>
                                <small style="font-size: 15px; font-weight: 600; color: #666;">Pending Applications</small>
                            </div>
                            <span class="badge rounded-circle p-3" style="background: #FF9800;">
                                <i class="bx bx-time-five bx-lg" style="color: white;"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card stats-card" style="background: #f3e5f5; border-color: #9C27B0;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <h5 class="mb-1" style="font-size: 28px; font-weight: 700; color: #242a62;">{{ $completedInternships }}</h5>
                                <small style="font-size: 15px; font-weight: 600; color: #666;">Completed Internships</small>
                            </div>
                            <span class="badge rounded-circle p-3" style="background: #9C27B0;">
                                <i class="bx bx-check-circle bx-lg" style="color: white;"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card stats-card" style="background: #fff8e1; border-color: #FFC107; cursor:pointer;" onclick="window.location='{{ route('admin.college.pending-marks') }}'">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <h5 class="mb-1" style="font-size: 28px; font-weight: 700; color: #242a62;">{{ $pendingMarksCount }}</h5>
                                <small style="font-size: 15px; font-weight: 600; color: #666;">Pending Marks</small>
                            </div>
                            <span class="badge rounded-circle p-3" style="background: #FFC107;">
                                <i class="bx bx-time bx-lg" style="color: white;"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Marks Section --}}
        @if($pendingMarksCount > 0)
        <div class="card mt-4">
            <div class="card-header p-4 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="bx bx-time"></i> Pending Marks — Action Required</h5>
                <a href="{{ route('admin.college.pending-marks') }}" class="btn btn-sm btn-warning">View All</a>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="pendingMarksTable" class="table table-sm table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Internship Title</th>
                            <th>Company</th>
                            <th>Duration</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- College Internship Dashboard Sections --}}
        @include('admin.college-internship.dashboard-section')
        @endif
    </div>
@endsection

@if($isCollegeStaff)
@push('script')
<script>
$(function(){
    // Assigned Students DataTable
    $('#assignedStudentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.college.staff-dashboard.assigned-students') }}",
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'student_name' },
            { data: 'internship_title' },
            { data: 'email' },
            { data: 'contact' },
            { data: 'assigned_date' },
            { data: 'action', orderable: false, searchable: false }
        ],
        order: [[5, 'desc']],
        language: { emptyTable: "No students assigned to you yet." }
    });

    // Staff Internships DataTable
    $('#staffInternshipsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.college.staff-dashboard.internships') }}",
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'internship_title' },
            { data: 'company_name' },
            { data: 'duration' },
            { data: 'category_name' },
            { data: 'status_label', orderable: false },
            { data: 'total_students', orderable: false }
            ,{ data: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']],
        language: { emptyTable: "No internships assigned to you yet." }
    });
});
</script>
@endpush
@endif

@if(!$isCollegeStaff)
@push('script')
<script>
$(function(){
    if ($('#pendingMarksTable').length) {
        $('#pendingMarksTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.college.pending-marks.data') }}",
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' }
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'internship_title' },
                { data: 'company_name' },
                { data: 'duration' },
                { data: 'formatted_start_date' },
                { data: 'formatted_end_date' },
                { data: 'status_badge', orderable: false },
                { data: 'action', orderable: false, searchable: false }
            ],
            order: [[4, 'asc']],
            pageLength: 5,
            language: { emptyTable: "No pending marks at this time." }
        });
    }
});
</script>
@endpush
@endif
