@push('css')
    <style>
        /* Page-level polish; global college theme lives in college-saas.css */
        .stats-card {
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #E5E7EB;
        }
        .stats-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 32px rgba(37, 99, 235, 0.12);
        }
        .staff-section-card {
            background: #fff; border-radius: 20px; border: 1px solid #E5E7EB;
            overflow: hidden; box-shadow: 0 4px 24px rgba(15, 23, 42, 0.06); margin-bottom: 30px;
        }
        .staff-section-header {
            background: linear-gradient(135deg, #2563EB, #4F46E5); color: #fff;
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
        @php
            $authUser = auth()->guard('college')->user() ?? auth()->guard('college_staff')->user();
            $welcomeName = auth()->guard('college')->check()
                ? ($authUser->college_name ?? 'College')
                : ($authUser->name ?? 'Staff');
        @endphp

        <div class="zp-page-banner zp-banner-default">
            <div class="zp-page-banner-bg" aria-hidden="true">
                <span class="zp-orb zp-orb-1"></span>
                <span class="zp-orb zp-orb-2"></span>
                <span class="zp-grid"></span>
            </div>
            <div class="zp-page-banner-inner">
                <div class="zp-page-banner-copy">
                    <div class="zp-page-banner-badge">College Dashboard</div>
                    <h1>Welcome back, {{ $welcomeName }} 👋</h1>
                    <p>
                        @if($isCollegeStaff)
                            Manage assigned internships and track student progress from one place.
                        @else
                            Manage students, internships, staff, marks and placements from one dashboard.
                        @endif
                    </p>
                    <nav class="zp-breadcrumb" aria-label="Breadcrumb">
                        <span>Dashboard</span>
                    </nav>
                </div>
                <div class="zp-page-banner-right">
                    <div class="zp-page-illu d-none d-md-flex" aria-hidden="true">
                        @include('admin.layout.partials.college-illustrations', ['type' => 'students'])
                    </div>
                </div>
            </div>
        </div>

        @if($isCollegeStaff)
        {{-- ══════════════ COLLEGE STAFF DASHBOARD ══════════════ --}}
        <div class="zp-stats-grid zp-stats-4" id="zp-dashboard-stats">
            <div class="card stats-card zp-stat-card zp-stat-active">
                <div class="card-body">
                    <div class="zp-stat-top">
                        <div>
                            <h5 class="zp-stat-value">{{ $assignedInternships }}</h5>
                            <small class="zp-stat-label">Assign Internship</small>
                        </div>
                        <span class="zp-stat-icon"><i class="bx bx-briefcase"></i></span>
                    </div>
                    <div class="zp-stat-progress"><span></span></div>
                </div>
            </div>

            <div class="card stats-card zp-stat-card zp-stat-students">
                <div class="card-body">
                    <div class="zp-stat-top">
                        <div>
                            <h5 class="zp-stat-value">{{ $assignedStudents }}</h5>
                            <small class="zp-stat-label">Assign Student</small>
                        </div>
                        <span class="zp-stat-icon"><i class="bx bx-user"></i></span>
                    </div>
                    <div class="zp-stat-progress"><span></span></div>
                </div>
            </div>

            <div class="card stats-card zp-stat-card zp-stat-pending">
                <div class="card-body">
                    <div class="zp-stat-top">
                        <div>
                            <h5 class="zp-stat-value">{{ $staffProcessingInternships }}</h5>
                            <small class="zp-stat-label">In Processing Internship</small>
                        </div>
                        <span class="zp-stat-icon"><i class="bx bx-loader-circle"></i></span>
                    </div>
                    <div class="zp-stat-progress"><span></span></div>
                </div>
            </div>

            <div class="card stats-card zp-stat-card zp-stat-completed">
                <div class="card-body">
                    <div class="zp-stat-top">
                        <div>
                            <h5 class="zp-stat-value">{{ $staffCompletedInternships }}</h5>
                            <small class="zp-stat-label">Complete Internship</small>
                        </div>
                        <span class="zp-stat-icon"><i class="bx bx-check-circle"></i></span>
                    </div>
                    <div class="zp-stat-progress"><span></span></div>
                </div>
            </div>
        </div>

        <div class="staff-section-card">
            <div class="staff-section-header">
                <i class="bx bx-user" style="font-size:24px;"></i>
                <h5>Assign Student List</h5>
            </div>
            <div style="padding: 25px;">
                <div class="table-responsive">
                    <table class="table table-hover" id="assignedStudentsTable" style="width:100%">
                        <thead>
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

        <div class="staff-section-card">
            <div class="staff-section-header">
                <i class="bx bx-briefcase-alt-2" style="font-size:24px;"></i>
                <h5>Internship List</h5>
            </div>
            <div style="padding: 25px;">
                <div class="table-responsive">
                    <table class="table table-hover" id="staffInternshipsTable" style="width:100%">
                        <thead>
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
        <div class="zp-stats-grid" id="zp-dashboard-stats">
            <div class="card stats-card zp-stat-card zp-stat-students">
                <div class="card-body">
                    <div class="zp-stat-top">
                        <div>
                            <h5 class="zp-stat-value">{{ $totalStudents }}</h5>
                            <small class="zp-stat-label">Total Students</small>
                        </div>
                        <span class="zp-stat-icon"><i class="bx bx-user"></i></span>
                    </div>
                    <div class="zp-stat-progress"><span></span></div>
                </div>
            </div>

            <div class="card stats-card zp-stat-card zp-stat-active">
                <div class="card-body">
                    <div class="zp-stat-top">
                        <div>
                            <h5 class="zp-stat-value">{{ $activeInternships }}</h5>
                            <small class="zp-stat-label">Active Internships</small>
                        </div>
                        <span class="zp-stat-icon"><i class="bx bx-briefcase"></i></span>
                    </div>
                    <div class="zp-stat-progress"><span></span></div>
                </div>
            </div>

            <div class="card stats-card zp-stat-card zp-stat-pending">
                <div class="card-body">
                    <div class="zp-stat-top">
                        <div>
                            <h5 class="zp-stat-value">{{ $pendingApplications }}</h5>
                            <small class="zp-stat-label">Pending Applications</small>
                        </div>
                        <span class="zp-stat-icon"><i class="bx bx-time-five"></i></span>
                    </div>
                    <div class="zp-stat-progress"><span></span></div>
                </div>
            </div>

            <div class="card stats-card zp-stat-card zp-stat-completed">
                <div class="card-body">
                    <div class="zp-stat-top">
                        <div>
                            <h5 class="zp-stat-value">{{ $completedInternships }}</h5>
                            <small class="zp-stat-label">Completed Internships</small>
                        </div>
                        <span class="zp-stat-icon"><i class="bx bx-check-circle"></i></span>
                    </div>
                    <div class="zp-stat-progress"><span></span></div>
                </div>
            </div>

            <div class="card stats-card zp-stat-card zp-stat-marks" style="cursor:pointer;" onclick="window.location='{{ route('admin.college.pending-marks') }}'">
                <div class="card-body">
                    <div class="zp-stat-top">
                        <div>
                            <h5 class="zp-stat-value">{{ $pendingMarksCount }}</h5>
                            <small class="zp-stat-label">Pending Marks</small>
                        </div>
                        <span class="zp-stat-icon"><i class="bx bx-time"></i></span>
                    </div>
                    <div class="zp-stat-progress"><span></span></div>
                </div>
            </div>
        </div>

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

        @include('admin.college-internship.dashboard-section')
        @endif
    </div>
@endsection

@if($isCollegeStaff)
@push('script')
<script>
$(function(){
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
            { data: 'total_students', orderable: false },
            { data: 'action', orderable: false, searchable: false }
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
