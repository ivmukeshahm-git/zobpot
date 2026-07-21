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

        .section-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #242a62;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #242a62;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }

        .student-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e0e0e0;
        }

        .status-badge-active {
            background: #28a745;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-badge-pending {
            background: #ffc107;
            color: #000;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-badge-completed {
            background: #6c757d;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .announcement-card {
            background: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .announcement-card h6 {
            color: #242a62;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .announcement-card p {
            color: #666;
            font-size: 13px;
            margin: 0;
        }

        .btn-action {
            padding: 6px 14px;
            font-size: 12px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .chart-container {
            position: relative;
            height: 350px;
        }
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
                        <h3 style="color: white; font-weight: 700; margin-bottom: 10px;">Welcome to College Dashboard</h3>
                        <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 15px;">Manage your students, track internship applications, and monitor college activities</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-6 g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card stats-card" style="background: #e7f3ff; border-color: #2196F3;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <h5 class="mb-1" style="font-size: 28px; font-weight: 700; color: #242a62;">245</h5>
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
                                <h5 class="mb-1" style="font-size: 28px; font-weight: 700; color: #242a62;">38</h5>
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
                                <h5 class="mb-1" style="font-size: 28px; font-weight: 700; color: #242a62;">67</h5>
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
                                <h5 class="mb-1" style="font-size: 28px; font-weight: 700; color: #242a62;">124</h5>
                                <small style="font-size: 15px; font-weight: 600; color: #666;">Completed Internships</small>
                            </div>
                            <span class="badge rounded-circle p-3" style="background: #9C27B0;">
                                <i class="bx bx-check-circle bx-lg" style="color: white;"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Students List Section -->
            <div class="col-xl-12 col-lg-12 mb-4">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="bx bx-group"></i> Recent Students
                        </h5>
                        <a href="{{ route('admin.college.students') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-show"></i> View All Students
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Student</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Department</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Semester</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Internship Status</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('uploads/profile/candidate.jpg') }}" alt="Avatar" class="student-avatar me-2">
                                            <div>
                                                <p class="mb-0" style="font-weight: 600; color: #242a62; font-size: 13px;">Rahul Sharma</p>
                                                <small style="color: #666; font-size: 12px;">rahul@example.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Computer Science</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">6th Semester</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="status-badge-active">Active</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <button class="btn btn-sm btn-primary btn-action">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('uploads/profile/candidate.jpg') }}" alt="Avatar" class="student-avatar me-2">
                                            <div>
                                                <p class="mb-0" style="font-weight: 600; color: #242a62; font-size: 13px;">Priya Patel</p>
                                                <small style="color: #666; font-size: 12px;">priya@example.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Information Technology</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">5th Semester</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="status-badge-pending">Pending</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <button class="btn btn-sm btn-primary btn-action">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('uploads/profile/candidate.jpg') }}" alt="Avatar" class="student-avatar me-2">
                                            <div>
                                                <p class="mb-0" style="font-weight: 600; color: #242a62; font-size: 13px;">Amit Kumar</p>
                                                <small style="color: #666; font-size: 12px;">amit@example.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Mechanical Engineering</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">7th Semester</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="status-badge-completed">Completed</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <button class="btn btn-sm btn-primary btn-action">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('uploads/profile/candidate.jpg') }}" alt="Avatar" class="student-avatar me-2">
                                            <div>
                                                <p class="mb-0" style="font-weight: 600; color: #242a62; font-size: 13px;">Neha Shah</p>
                                                <small style="color: #666; font-size: 12px;">neha@example.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Electronics & Communication</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">6th Semester</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="status-badge-active">Active</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <button class="btn btn-sm btn-primary btn-action">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('uploads/profile/candidate.jpg') }}" alt="Avatar" class="student-avatar me-2">
                                            <div>
                                                <p class="mb-0" style="font-weight: 600; color: #242a62; font-size: 13px;">Vijay Desai</p>
                                                <small style="color: #666; font-size: 12px;">vijay@example.com</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Civil Engineering</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">8th Semester</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="status-badge-pending">Pending</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <button class="btn btn-sm btn-primary btn-action">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

           
        </div>

        <!-- Recent Internship Applications -->
        <div class="row">
            <div class="col-12">
                <div class="section-card">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="bx bx-file"></i> Recent Internship Applications
                        </h5>
                        <a href="{{ route('admin.college.applications') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-show"></i> View All Applications
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Student Name</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Internship Title</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Company</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Applied Date</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Duration</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Status</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="vertical-align: middle;">
                                        <span style="font-weight: 600; color: #242a62; font-size: 13px;">Rahul Sharma</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Full-Stack Web Development</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">TechCorp Solutions</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">05 Feb 2026</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">3 Months</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="status-badge-active">Approved</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <button class="btn btn-sm btn-primary btn-action">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">
                                        <span style="font-weight: 600; color: #242a62; font-size: 13px;">Priya Patel</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Digital Marketing</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Creative Agency</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">08 Feb 2026</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">2 Months</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="status-badge-pending">Under Review</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <button class="btn btn-sm btn-primary btn-action">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">
                                        <span style="font-weight: 600; color: #242a62; font-size: 13px;">Neha Shah</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">UI/UX Design</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Design Studio</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">09 Feb 2026</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">4 Months</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="status-badge-active">Approved</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <button class="btn btn-sm btn-primary btn-action">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    // Add any custom JavaScript here
    console.log('College Dashboard Loaded');
</script>
@endpush
