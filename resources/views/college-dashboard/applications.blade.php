@push('css')
    <style>
        .application-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .application-item {
            border: 2px solid #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .application-item:hover {
            border-color: #242a62;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .company-logo {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #e0e0e0;
        }

        .timeline-badge {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
        }

        .timeline-item {
            position: relative;
            padding-left: 60px;
            margin-bottom: 30px;
        }

        .timeline-item:before {
            content: '';
            position: absolute;
            left: 20px;
            top: 40px;
            bottom: -30px;
            width: 2px;
            background: #e0e0e0;
        }

        .timeline-item:last-child:before {
            display: none;
        }

        .timeline-badge {
            position: absolute;
            left: 0;
            top: 0;
        }

        .status-chip {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-chip.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-chip.approved {
            background: #d4edda;
            color: #155724;
        }

        .status-chip.rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .status-chip.in-progress {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-chip.completed {
            background: #d6d8db;
            color: #383d41;
        }
    </style>
@endpush

@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "College-Dashboard";
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: #242a62;">
                    <i class="bx bx-file"></i> Candidate Applications
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.college.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Applications</li>
                    </ol>
                </nav>
            </div>
            <div>
                <button class="btn btn-success">
                    <i class="bx bx-download"></i> Export Report
                </button>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="row mb-4 g-4">
            <div class="col-md-3">
                <div class="card" style="border-left: 4px solid #2196F3;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-0" style="font-weight: 700; color: #242a62;">156</h3>
                                <small style="color: #666;">Total Opportunities</small>
                            </div>
                            <i class="bx bx-briefcase" style="font-size: 36px; color: #2196F3;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="border-left: 4px solid #FF9800;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-0" style="font-weight: 700; color: #242a62;">67</h3>
                                <small style="color: #666;">Processing Opportunities</small>
                            </div>
                            <i class="bx bx-time-five" style="font-size: 36px; color: #FF9800;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="border-left: 4px solid #4CAF50;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-0" style="font-weight: 700; color: #242a62;">124</h3>
                                <small style="color: #666;">Completed Programs</small>
                            </div>
                            <i class="bx bx-check-circle" style="font-size: 36px; color: #4CAF50;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="border-left: 4px solid #9C27B0;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-0" style="font-weight: 700; color: #242a62;">245</h3>
                                <small style="color: #666;">Total Students</small>
                            </div>
                            <i class="bx bx-group" style="font-size: 36px; color: #9C27B0;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <ul class="nav nav-pills mb-4" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all-applications" role="tab">
                    <i class="bx bx-list-ul"></i>&nbsp; All Opportunities
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pending-applications" role="tab">
                    <i class="bx bx-time-five"></i>&nbsp; Pending
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#in-progress-applications" role="tab">
                    <i class="bx bx-loader-circle"></i>&nbsp; In Progress
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#completed-applications" role="tab">
                    <i class="bx bx-trophy"></i>&nbsp; Completed
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content p-0">
            <!-- All Applications Tab -->
            <div class="tab-pane fade show active" id="all-applications" role="tabpanel">
                <div class="application-card">
                    <div class="table-responsive">
                        <table class="table table-hover" id="allInternshipsTable">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">ID</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Opportunity Title</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Company Name</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Duration</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Stipend</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Mode</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Location</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Status</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="vertical-align: middle;">#001</td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-weight: 600; color: #242a62; font-size: 13px;">Full-Stack Web Development</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">TechCorp Solutions</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">3 Months</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">₹15,000/month</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge bg-info" style="font-size: 11px;">Remote</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Mumbai, MH</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge" style="background: #17a2b8; color: white; font-size: 11px;">In Progress</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <a href="{{ url('admin/opportunity/view/1') }}" class="btn btn-sm btn-primary">
                                            <i class="bx bx-show"></i> View
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">#002</td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-weight: 600; color: #242a62; font-size: 13px;">Digital Marketing</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Creative Agency</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">2 Months</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">₹10,000/month</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge bg-warning" style="font-size: 11px; color: #000;">Hybrid</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Pune, MH</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge" style="background: #ffc107; color: #000; font-size: 11px;">Pending</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <a href="{{ url('admin/opportunity/view/2') }}" class="btn btn-sm btn-primary">
                                            <i class="bx bx-show"></i> View
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">#003</td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-weight: 600; color: #242a62; font-size: 13px;">UI/UX Design</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Design Studio</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">4 Months</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">₹12,000/month</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge bg-success" style="font-size: 11px;">On-site</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Bangalore, KA</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge" style="background: #4CAF50; color: white; font-size: 11px;">Completed</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <a href="{{ url('admin/opportunity/view/3') }}" class="btn btn-sm btn-primary">
                                            <i class="bx bx-show"></i> View
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">#004</td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-weight: 600; color: #242a62; font-size: 13px;">Data Analytics</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Analytics Corp</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">3 Months</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">₹18,000/month</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge bg-info" style="font-size: 11px;">Remote</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Delhi, DL</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge" style="background: #17a2b8; color: white; font-size: 11px;">In Progress</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <a href="{{ url('admin/opportunity/view/4') }}" class="btn btn-sm btn-primary">
                                            <i class="bx bx-show"></i> View
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">#005</td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-weight: 600; color: #242a62; font-size: 13px;">Mobile App Development</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">App Innovators</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">6 Months</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">₹20,000/month</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge bg-warning" style="font-size: 11px; color: #000;">Hybrid</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Hyderabad, TS</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge" style="background: #ffc107; color: #000; font-size: 11px;">Pending</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <a href="{{ url('admin/opportunity/view/5') }}" class="btn btn-sm btn-primary">
                                            <i class="bx bx-show"></i> View
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pending Tab -->
            <div class="tab-pane fade" id="pending-applications" role="tabpanel">
                <div class="application-card">
                    <div class="table-responsive">
                        <table class="table table-hover" id="pendingInternshipsTable">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">ID</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Opportunity Title</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Company Name</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Duration</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Stipend</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Mode</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Location</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Status</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="vertical-align: middle;">#002</td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-weight: 600; color: #242a62; font-size: 13px;">Digital Marketing</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Creative Agency</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">2 Months</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">₹10,000/month</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge bg-warning" style="font-size: 11px; color: #000;">Hybrid</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Pune, MH</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge" style="background: #ffc107; color: #000; font-size: 11px;">Pending</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <a href="{{ url('admin/opportunity/view/2') }}" class="btn btn-sm btn-primary">
                                            <i class="bx bx-show"></i> View
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">#005</td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-weight: 600; color: #242a62; font-size: 13px;">Mobile App Development</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">App Innovators</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">6 Months</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">₹20,000/month</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge bg-warning" style="font-size: 11px; color: #000;">Hybrid</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Hyderabad, TS</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge" style="background: #ffc107; color: #000; font-size: 11px;">Pending</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <a href="{{ url('admin/opportunity/view/5') }}" class="btn btn-sm btn-primary">
                                            <i class="bx bx-show"></i> View
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- In Progress Tab -->
            <div class="tab-pane fade" id="in-progress-applications" role="tabpanel">
                <div class="application-card">
                    <div class="table-responsive">
                        <table class="table table-hover" id="inProgressInternshipsTable">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">ID</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Opportunity Title</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Company Name</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Duration</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Stipend</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Mode</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Location</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Status</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="vertical-align: middle;">#001</td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-weight: 600; color: #242a62; font-size: 13px;">Full-Stack Web Development</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">TechCorp Solutions</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">3 Months</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">₹15,000/month</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge bg-info" style="font-size: 11px;">Remote</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Mumbai, MH</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge" style="background: #17a2b8; color: white; font-size: 11px;">In Progress</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <a href="{{ url('admin/opportunity/view/1') }}" class="btn btn-sm btn-primary">
                                            <i class="bx bx-show"></i> View
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">#004</td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-weight: 600; color: #242a62; font-size: 13px;">Data Analytics</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Analytics Corp</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">3 Months</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">₹18,000/month</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge bg-info" style="font-size: 11px;">Remote</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Delhi, DL</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge" style="background: #17a2b8; color: white; font-size: 11px;">In Progress</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <a href="{{ url('admin/opportunity/view/4') }}" class="btn btn-sm btn-primary">
                                            <i class="bx bx-show"></i> View
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Completed Tab -->
            <div class="tab-pane fade" id="completed-applications" role="tabpanel">
                <div class="application-card">
                    <div class="table-responsive">
                        <table class="table table-hover" id="completedInternshipsTable">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">ID</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Opportunity Title</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Company Name</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Duration</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Stipend</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Mode</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Location</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Status</th>
                                    <th style="font-weight: 700; color: #242a62; font-size: 13px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="vertical-align: middle;">#003</td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-weight: 600; color: #242a62; font-size: 13px;">UI/UX Design</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Design Studio</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">4 Months</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">₹12,000/month</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge bg-success" style="font-size: 11px;">On-site</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span style="font-size: 13px; color: #666;">Bangalore, KA</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="badge" style="background: #4CAF50; color: white; font-size: 11px;">Completed</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <a href="{{ url('admin/opportunity/view/3') }}" class="btn btn-sm btn-primary">
                                            <i class="bx bx-show"></i> View
                                        </a>
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
    $(document).ready(function() {
        // DataTable configuration options
        var dataTableOptions = {
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[0, 'asc']],
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _MAX_ total entries)",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            responsive: true,
            columnDefs: [
                { orderable: false, targets: -1 } // Disable sorting on Action column
            ]
        };

        // Initialize DataTable for All Opportunities
        var allInternshipsTable = $('#allInternshipsTable').DataTable(dataTableOptions);

        // Initialize DataTable for Pending Programs
        var pendingInternshipsTable = $('#pendingInternshipsTable').DataTable(dataTableOptions);

        // Initialize DataTable for In Progress Opportunities
        var inProgressInternshipsTable = $('#inProgressInternshipsTable').DataTable(dataTableOptions);

        // Initialize DataTable for Completed Programs
        var completedInternshipsTable = $('#completedInternshipsTable').DataTable(dataTableOptions);

        // Reinitialize DataTable when tab is shown (fixes column width issues)
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("data-bs-target");
            
            if (target === '#all-applications') {
                allOpportunitiesTable.columns.adjust().responsive.recalc();
            } else if (target === '#pending-applications') {
                pendingOpportunitiesTable.columns.adjust().responsive.recalc();
            } else if (target === '#in-progress-applications') {
                inProgressOpportunitiesTable.columns.adjust().responsive.recalc();
            } else if (target === '#completed-applications') {
                completedOpportunitiesTable.columns.adjust().responsive.recalc();
            }
        });

        console.log('Applications page loaded with DataTables');
    });
</script>
@endpush
