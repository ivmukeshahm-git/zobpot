@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "CollegeProfile";
</script>

<style>
    /* Profile Completion Alert */
    .profile-completion-alert {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .completion-percentage {
        font-size: 32px;
        font-weight: 700;
        margin-right: 15px;
    }

    .completion-bar {
        height: 8px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
        overflow: hidden;
        margin-top: 10px;
    }

    .completion-fill {
        height: 100%;
        background: #fff;
        border-radius: 10px;
        transition: width 0.5s ease;
    }

    /* Account Status Section */
    .account-status-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        margin-bottom: 25px;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
    }

    .status-active {
        background: #d4edda;
        color: #155724;
    }

    .status-inactive {
        background: #f8d7da;
        color: #721c24;
    }

    .btn-deactivate {
        background: #dc3545;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-deactivate:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    /* Summary Cards */
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .summary-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border-left: 4px solid;
        transition: all 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .summary-card.students { border-left-color: #667eea; }
    .summary-card.active { border-left-color: #28a745; }
   .summary-card.completed { border-left-color: #6c757d; }
    .summary-card.applications { border-left-color: #ffc107; }

    .summary-card-icon {
        font-size: 36px;
        margin-bottom: 10px;
    }

    .summary-card.students .summary-card-icon { color: #667eea; }
    .summary-card.active .summary-card-icon { color: #28a745; }
    .summary-card.completed .summary-card-icon { color: #6c757d; }
    .summary-card.applications .summary-card-icon { color: #ffc107; }

    .summary-card-number {
        font-size: 32px;
        font-weight: 700;
        color: #2c3e50;
        margin: 5px 0;
    }

    .summary-card-label {
        color: #7f8c8d;
        font-size: 14px;
        font-weight: 600;
    }

    /* Tabs Navigation */
    .profile-tabs {
        background: white;
        border-radius: 12px;
        padding: 0;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .profile-tabs .nav-tabs {
        border-bottom: 2px solid #e9ecef;
        padding: 0 20px;
    }

    .profile-tabs .nav-link {
        color: #6c757d;
        font-weight: 600;
        padding: 15px 25px;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .profile-tabs .nav-link:hover {
        color: #242a62;
        background: #f8f9fa;
    }

    .profile-tabs .nav-link.active {
        color: #242a62;
        background: white;
        border-bottom-color: #242a62;
    }

    /* Tab Content */
    .tab-content-wrapper {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    /* Profile Details */
    .profile-section {
        background: #ffffff;
        padding: 0;
        border-radius: 10px;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .profile-banner {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #7e22ce 100%);
        height: 200px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .profile-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 300"><path fill="rgba(255,255,255,0.1)" d="M0,100 C150,150 350,0 600,100 C850,200 1050,50 1200,100 L1200,0 L0,0 Z"/></svg>');
        background-size: cover;
    }

    .profile-banner-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
    }

    .profile-banner-content h2 {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        letter-spacing: 2px;
    }

    .profile-banner-content p {
        font-size: 16px;
        opacity: 0.95;
        margin: 0;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    }

    .banner-icons {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        overflow: hidden;
        opacity: 0.15;
    }

    .banner-icon {
        position: absolute;
        color: white;
        font-size: 80px;
    }

    .banner-icon:nth-child(1) {
        top: 20px;
        right: 10%;
        animation: float 6s ease-in-out infinite;
    }

    .banner-icon:nth-child(2) {
        bottom: 30px;
        left: 8%;
        animation: float 8s ease-in-out infinite;
    }

    .banner-icon:nth-child(3) {
        top: 50%;
        left: 15%;
        animation: float 7s ease-in-out infinite;
    }

    .banner-icon:nth-child(4) {
        top: 30%;
        right: 15%;
        animation: float 9s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    .profile-section {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e9ecef;
    }

    .college-logo {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        object-fit: cover;
        border: 3px solid #e9ecef;
        margin-right: 25px;
    }

    .profile-info h3 {
        color: #242a62;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .profile-info p {
        color: #6c757d;
        margin-bottom: 3px;
    }

    .profile-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 15px;
    }

    .profile-field {
        background: white;
        padding: 15px;
        border-radius: 8px;
        border-left: 3px solid #242a62;
    }

    .profile-field-label {
        font-weight: 600;
        color: #7f8c8d;
        font-size: 13px;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .profile-field-value {
        color: #2c3e50;
        font-size: 15px;
        font-weight: 500;
    }

    .btn-edit-profile {
        background: #242a62;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 700;
        transition: all 0.3s ease;
        margin-top: 20px;
    }

    .btn-edit-profile:hover {
        background: #1a1f4a;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(36, 42, 98, 0.3);
    }

    /* Filter Section */
    .filter-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .filter-field label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 13px;
        margin-bottom: 5px;
        display: block;
    }

    .filter-field input,
    .filter-field select {
        width: 100%;
        padding: 8px 12px;
        border: 2px solid #e9ecef;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .filter-field input:focus,
    .filter-field select:focus {
        border-color: #242a62;
        outline: none;
    }

    .btn-filter {
        background: #242a62;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 6px;
        font-weight: 600;
        margin-top: 20px;
    }

    .btn-reset {
        background: #6c757d;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 6px;
        font-weight: 600;
        margin-top: 20px;
        margin-left: 10px;
    }

    /* DataTable Styling */
    .dataTables_wrapper {
        padding: 20px 0;
    }

    table.dataTable thead th {
        background: #242a62;
        color: white;
        font-weight: 600;
        padding: 12px;
        border: none;
    }

    table.dataTable tbody td {
        padding: 12px;
        vertical-align: middle;
    }

    table.dataTable tbody tr:hover {
        background: #f8f9fa;
    }

    /* Modal Styling */
    .modal-header {
        background: linear-gradient(135deg, #242a62 0%, #1a1f4a 100%);
        color: white;
        border-radius: 10px 10px 0 0;
    }

    .modal-body {
        padding: 30px;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #242a62;
        box-shadow: 0 0 0 0.2rem rgba(36, 42, 98, 0.1);
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Profile Completion Alert -->
    @if($completion < 100)
    <div class="profile-completion-alert">
        <div class="d-flex align-items-center">
            <div class="completion-percentage">{{ $completion }}%</div>
            <div class="flex-grow-1">
                <h5 style="margin: 0; font-weight: 700;">Profile Incomplete</h5>
                <p style="margin: 5px 0 0 0; opacity: 0.9;">Complete your profile to unlock a better and more personalized experience.</p>
                <div class="completion-bar">
                    <div class="completion-fill" style="width: {{ $completion }}%;"></div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Top Row: Header and Account Status -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                <h3 style="color: #242a62; font-weight: 700; margin-bottom: 5px;">
                    <i class="bx bx-building"></i> College Profile
                </h3>
                <p style="color: #6c757d; margin: 0;">Manage college information, students, and opportunities</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="account-status-card position-relative">
                <div class="d-flex justify-content-between align-items-start">
                    <h6 style="margin-bottom: 10px; font-weight: 700; color: #2c3e50;">Account Status</h6>
                    <button id="toggleStatusBtn" class="btn btn-sm btn-outline-primary" onclick="toggleAccountStatus()">
                        @if(intval($college->status) === 1)
                            Deactivate
                        @else
                            Activate
                        @endif
                    </button>
                </div>

                <div style="margin-top:6px">
                    <span id="statusBadge" class="status-badge status-{{ intval($college->status) === 1 ? 'active' : 'inactive' }}">
                        {{ intval($college->status) === 1 ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card students">
            <div class="summary-card-icon"><i class="bx bx-group"></i></div>
            <div class="summary-card-number">{{ $totalStudents }}</div>
            <div class="summary-card-label">Total Students</div>
        </div>
        <div class="summary-card active">
            <div class="summary-card-icon"><i class="bx bx-time-five"></i></div>
            <div class="summary-card-number">{{ $activeInternships }}</div>
            <div class="summary-card-label">Active Opportunities</div>
        </div>
        <div class="summary-card completed">
            <div class="summary-card-icon"><i class="bx bx-check-circle"></i></div>
            <div class="summary-card-number">{{ $completedInternships }}</div>
            <div class="summary-card-label">Completed Programs</div>
        </div>
        <div class="summary-card applications">
            <div class="summary-card-icon"><i class="bx bx-file"></i></div>
            <div class="summary-card-number">{{ $totalApplications }}</div>
            <div class="summary-card-label">Total Applications</div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="profile-tabs">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                    <i class="bx bx-user"></i> Profile
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button" role="tab">
                    <i class="bx bx-group"></i> Students
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="internship-tab" data-bs-toggle="tab" data-bs-target="#internship" type="button" role="tab">
                    <i class="bx bx-briefcase"></i> Opportunity
                </button>
            </li>
        </ul>
    </div>

    <!-- Tab Content -->
    <div class="tab-content p-0">
        
        <!-- Profile Tab -->
        <div class="tab-pane fade show active" id="profile" role="tabpanel">
            <div class="tab-content-wrapper">
               <!-- Profile Info Section -->
                    <div style="border-radius: 10px; position: relative; z-index: 10;">
                        <div class="profile-header">
                            @php
                                $logoPath = null;
                                if(!empty($college->logo) && file_exists(public_path($college->logo))) {
                                    $logoPath = asset($college->logo);
                                } else {
                                    $logoPath = asset('assets/imgs/school.png');
                                }
                            @endphp
                            <img src="{{ $logoPath }}" alt="College Logo" class="college-logo" id="profileLogo">
                            <div class="profile-info">
                                <h3>{{ $college->college_name }}</h3>
                                <p><i class="bx bx-buildings"></i> {{ $college->university ? $college->university->university_name : 'N/A' }}</p>
                                <p><i class="bx bx-envelope"></i> {{ $college->email }}</p>
                                <p><i class="bx bx-phone"></i> {{ $college->phone }}</p>
                            </div>
                        </div>

                    <div class="profile-row">
                        <div class="profile-field">
                            <div class="profile-field-label">College Code</div>
                            <div class="profile-field-value">{{ $college->college_code ?: 'Not Provided' }}</div>
                        </div>
                        <div class="profile-field">
                            <div class="profile-field-label">Website</div>
                            <div class="profile-field-value">
                                <a href="{{ $college->website }}" target="_blank">{{ $college->website ?: 'Not Provided' }}</a>
                            </div>
                        </div>
                        <div class="profile-field">
                            <div class="profile-field-label">Established Year</div>
                            <div class="profile-field-value">{{ $college->established_year ?: 'Not Provided' }}</div>
                        </div>
                    </div>

                    <div class="profile-row">
                        <div class="profile-field">
                            <div class="profile-field-label">Address</div>
                            <div class="profile-field-value">{{ $college->address ?: 'Not Provided' }}</div>
                        </div>
                        <div class="profile-field">
                            <div class="profile-field-label">City</div>
                            <div class="profile-field-value">{{ $college->city ?: 'Not Provided' }}</div>
                        </div>
                    </div>

                    <div class="profile-row">
                        <div class="profile-field">
                            <div class="profile-field-label">State</div>
                            <div class="profile-field-value">{{ $college->state ?: 'Not Provided' }}</div>
                        </div>
                        <div class="profile-field">
                            <div class="profile-field-label">Zip Code</div>
                            <div class="profile-field-value">{{ $college->pincode ?: 'Not Provided' }}</div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn-edit-profile" onclick="openEditModal()">
                            <i class="bx bx-edit"></i> Edit Profile
                        </button>
                    </div>
                    </div>
            </div>
        </div>

        <!-- Students Tab -->
        <div class="tab-pane fade" id="students" role="tabpanel">
            <div class="tab-content-wrapper">
                <!-- (Note: opportunity state buttons moved to Opportunity tab) -->

                <!-- Filter Section -->
                <div class="filter-section">
                    <h5 style="margin-bottom: 15px; font-weight: 700; color: #242a62;">
                        <i class="bx bx-filter"></i> Filter Students
                    </h5>
                    <div class="filter-row" id="studentFilters">
                        <div class="filter-field">
                            <label>Name</label>
                            <input type="text" class="form-control" id="filter_name" placeholder="Enter student name">
                        </div>
                        <div class="filter-field">
                            <label>Email</label>
                            <input type="text" class="form-control" id="filter_email" placeholder="Enter email">
                        </div>
                        <div class="filter-field">
                            <label>Degree</label>
                            <select class="form-control" id="filter_degree">
                                <option value="">All Degrees</option>
                            </select>
                        </div>
                        <div class="filter-field">
                            <label>Major</label>
                            <select class="form-control" id="filter_major">
                                <option value="">All Majors</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-top: 15px;">
                        <button class="btn-filter" onclick="applyStudentFilters()">
                            <i class="bx bx-search"></i> Apply Filters
                        </button>
                        <button class="btn-reset" onclick="resetStudentFilters()">
                            <i class="bx bx-reset"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Students Table -->
                <div style="margin-top: 20px;">
                    <table id="studentsTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>SR. NO.</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Degree</th>
                                <th>Major</th>
                                <th>Registration Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- Opportunity Tab -->
        <div class="tab-pane fade" id="internship" role="tabpanel">
            <div class="tab-content-wrapper">
                <!-- Opportunity State Tabs -->
                <div class="mb-3">
                    <div class="btn-group" role="group" aria-label="Opportunity states">
                        <button type="button" class="btn btn-outline-secondary internship-state-btn" data-state="upcoming">Upcoming</button>
                        <button type="button" class="btn btn-outline-secondary internship-state-btn active" data-state="active">Processing</button>
                        <button type="button" class="btn btn-outline-secondary internship-state-btn" data-state="completed">Complete</button>
                    </div>
                </div>
                <!-- Filter Section -->
                <div class="filter-section">
                    <h5 style="margin-bottom: 15px; font-weight: 700; color: #242a62;">
                        <i class="bx bx-filter"></i> Filter Opportunities
                    </h5>
                    <div class="filter-row" id="internshipFilters">
                        <div class="filter-field">
                            <label>Opportunity Name</label>
                            <input type="text" class="form-control" id="filter_internship_name" placeholder="Enter opportunity name">
                        </div>
                        <div class="filter-field">
                            <label>Company Name</label>
                            <input type="text" class="form-control" id="filter_company_name" placeholder="Enter company name">
                        </div>
                        <div class="filter-field">
                            <label>Status</label>
                            <select class="form-control" id="filter_status">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="completed">Completed</option>
                                <option value="upcoming">Upcoming</option>
                            </select>
                        </div>
                    </div>
                    <div class="filter-row" style="margin-top: 15px;">
                        <div class="filter-field">
                            <label>Start Date</label>
                            <input type="date" class="form-control" id="filter_start_date">
                        </div>
                        <div class="filter-field">
                            <label>End Date</label>
                            <input type="date" class="form-control" id="filter_end_date">
                        </div>
                    </div>
                    <div style="margin-top: 15px;">
                        <button class="btn-filter" onclick="applyInternshipFilters()">
                            <i class="bx bx-search"></i> Apply Filters
                        </button>
                        <button class="btn-reset" onclick="resetInternshipFilters()">
                            <i class="bx bx-reset"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Opportunity Table -->
                <div style="margin-top: 20px;">
                    <table id="internshipTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>SR. NO.</th>
                                <th>Opportunity Title</th>
                                <th>Company</th>
                                <th>Applied Students</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" style="color:#fff;"><i class="bx bx-edit"></i> Edit College Profile</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editProfileForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="college_id" value="{{ $college->id }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">College Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="college_name" value="{{ $college->college_name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">College Code</label>
                            <input type="text" class="form-control" name="college_code" value="{{ $college->college_code }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ $college->email }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" value="{{ $college->phone }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Website</label>
                            <input type="url" class="form-control" name="website" value="{{ $college->website }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Established Year</label>
                            <input type="text" class="form-control" name="established_year" value="{{ $college->established_year }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="2">{{ $college->address }}</textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city" value="{{ $college->city }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">State</label>
                            <input type="text" class="form-control" name="state" value="{{ $college->state }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Zip Code</label>
                            <input type="text" class="form-control" name="pincode" value="{{ $college->pincode }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">College Logo</label>
                            <input type="file" class="form-control" name="logo" accept="image/*">
                            <small class="text-muted">Leave blank to keep current logo</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- (mandatory alert modal removed) -->

@endsection

@push('script')
<script>
let studentsTable, opportunityTable;
const collegeId = {{ $college->id }};

$(document).ready(function() {
    // (mandatory profile alert logic removed)
    
    // Initialize Students DataTable
    studentsTable = $('#studentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.college-profile.students-data") }}',
            type: 'POST',
            data: function(d) {
                d._token = '{{ csrf_token() }}';
                d.college_id = collegeId;
                d.name = $('#filter_name').val();
                d.email = $('#filter_email').val();
                d.degree_id = $('#filter_degree').val();
                d.major_id = $('#filter_major').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'student_name', name: 'student_name' },
            { data: 'student_email', name: 'student_email' },
            { data: 'student_phone', name: 'student_phone' },
            { data: 'degree_name', name: 'degree_name' },
            { data: 'major_name', name: 'major_name' },
            { data: 'registration_date', name: 'registration_date' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[6, 'desc']],
        pageLength: 25
    });

    // Initialize Opportunity DataTable
    opportunityTable = $('#internshipTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.college-profile.internships-data") }}',
            type: 'POST',
            data: function(d) {
                d._token = '{{ csrf_token() }}';
                d.college_id = collegeId;
                d.internship_name = $('#filter_internship_name').val();
                d.company_name = $('#filter_company_name').val();
                // status comes from selected state button inside opportunity tab or status select
                var state = $('#internship .opportunity-state-btn.active').data('state');
                d.status = state || $('#filter_status').val();
                d.start_date = $('#filter_start_date').val();
                d.end_date = $('#filter_end_date').val();
                // debug
                try { console.log('opportunity ajax params', d); } catch(e) {}
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error('Opportunity DataTable AJAX error', textStatus, errorThrown, xhr);
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'internship_title', name: 'internship_title' },
            { data: 'company_name', name: 'company_name' },
            { data: 'applied_students', name: 'applied_students' },
            { data: 'start_date', name: 'start_date' },
            { data: 'end_date', name: 'end_date' },
            { data: 'status_badge', name: 'status_badge', orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[4, 'desc']],
        pageLength: 25
    });

    // Opportunity state button click (scoped to opportunity tab)
    if ($('#internship .opportunity-state-btn.active').length === 0) {
        $('#internship .opportunity-state-btn[data-state="active"]').addClass('active');
    }
    $(document).on('click', '#internship .opportunity-state-btn', function() {
        $('#internship .opportunity-state-btn').removeClass('active');
        $(this).addClass('active');
        if (typeof opportunityTable !== 'undefined') opportunityTable.ajax.reload();
    });

    // Load degrees and majors for filters
    loadDegreesForFilter();
    loadMajorsForFilter();

    // (mandatory profile handlers removed)

    // Edit Profile Form Submit
    $('#editProfileForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        Swal.fire({
            title: 'Updating...',
            text: 'Please wait while we update your profile',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '{{ route("admin.college-profile.update") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
            }
        });
    });
});

function openEditModal() {
    $('#editProfileModal').modal('show');
}

function applyStudentFilters() {
    studentsTable.ajax.reload();
}

function resetStudentFilters() {
    $('#filter_name').val('');
    $('#filter_email').val('');
    $('#filter_degree').val('');
    $('#filter_major').val('');
    studentsTable.ajax.reload();
}

function applyInternshipFilters() {
    opportunityTable.ajax.reload();
}

function resetInternshipFilters() {
    $('#filter_internship_name').val('');
    $('#filter_company_name').val('');
    $('#filter_status').val('');
    $('#filter_start_date').val('');
    $('#filter_end_date').val('');
    opportunityTable.ajax.reload();
}

function loadDegreesForFilter() {
    $.ajax({
        url: '{{ url("admin/degree/all") }}',
        method: 'GET',
        success: function(response) {
            if (response.data) {
                let options = '<option value="">All Degrees</option>';
                response.data.forEach(degree => {
                    options += `<option value="${degree.degree_id}">${degree.degree_name}</option>`;
                });
                $('#filter_degree').html(options);
            }
        }
    });
}

function loadMajorsForFilter() {
    $.ajax({
        url: '{{ url("admin/major/all") }}',
        method: 'GET',
        success: function(response) {
            if (response.data) {
                let options = '<option value="">All Majors</option>';
                response.data.forEach(major => {
                    options += `<option value="${major.major_id}">${major.major_name}</option>`;
                });
                $('#filter_major').html(options);
            }
        }
    });
}

function deactivateAccount() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This will deactivate the college account!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, deactivate it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("admin.college-profile.deactivate") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    college_id: collegeId
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deactivated!',
                        text: response.message,
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to deactivate account'
                    });
                }
            });
        }
    });
}

function toggleAccountStatus() {
    // determine current status from badge text or server-rendered value
    let current = '{{ $college->status }}';
    let desired = 1;
    if (parseInt(current) === 1) {
        desired = 0;
    }

    Swal.fire({
        title: 'Please confirm',
        text: desired === 0 ? 'This will deactivate the college account!' : 'This will activate the college account!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: desired === 0 ? '#dc3545' : '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: desired === 0 ? 'Yes, deactivate it!' : 'Yes, activate it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("admin.college-profile.deactivate") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    college_id: collegeId,
                    status: desired
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1500
                    }).then(() => {
                        // update UI without reload
                        if (desired === 1) {
                            $('#statusBadge').removeClass('status-inactive').addClass('status-active').text('Active');
                            $('#toggleStatusBtn').text('Deactivate');
                        } else {
                            $('#statusBadge').removeClass('status-active').addClass('status-inactive').text('Inactive');
                            $('#toggleStatusBtn').text('Activate');
                        }
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update account status'
                    });
                }
            });
        }
    });
}
</script>
@endpush
