@extends('admin.layout.layout')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- Select2 CSS --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script>
    page_active_id = "College";
</script>

<style>
    /* College Management Page Styles */
    .college-header {
        background: #242b62;
        padding: 25px 30px;
        border-radius: 12px 12px 0 0;
        box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3);
    }

    .college-header h5 {
        color: white;
        margin: 0;
        font-size: 24px;
        font-weight: 700;
    }

    .college-header p {
        color: rgba(255, 255, 255, 0.85);
        margin: 5px 0 0 0;
        font-size: 14px;
    }

    .btn-add-college {
        background: #fff;
        color: #242b62;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(79, 172, 254, 0.3);
    }

    .btn-add-college:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(79, 172, 254, 0.4);
        color: white;
    }

    .table-container {
        background: white;
        padding: 30px;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .table-college {
        margin-top: 20px;
    }

    .table-college thead {
        background: #f8f9fa;
        border-bottom: 2px solid #242b62;
    }

    .table-college thead th {
        color: #242b62;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        padding: 15px 12px;
        border: none;
    }

    .table-college tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #e9ecef;
    }

    .table-college tbody tr:hover {
        background: #f8f9fa;
        transform: scale(1.01);
    }

    .table-college tbody td {
        padding: 15px 12px;
        vertical-align: middle;
        color: #495057;
        font-size: 14px;
    }

    .college-logo {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #e9ecef;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-approved {
        background: #d4edda;
        color: #155724;
    }

    .status-rejected {
        background: #f8d7da;
        color: #721c24;
    }

    .university-tag {
        background: #242b62;
        color: white;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .btn-action {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        margin: 0 3px;
    }

    .btn-edit {
        background: #17a2b8;
        color: white;
    }

    .btn-edit:hover {
        background: #138496;
        color: white;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background: #c82333;
        color: white;
        transform: translateY(-2px);
    }

    .btn-view {
        background: #6f42c1;
        color: white;
    }

    .btn-view:hover {
        background: #5a32a3;
        color: white;
        transform: translateY(-2px);
    }

    /* Modal Styles */
    .modal-header-custom {
        background: #242b62;
        color: white;
        padding: 20px 30px;
        border: none;
    }

    .modal-header-custom .modal-title {
        font-size: 20px;
        font-weight: 700;
    }

    .modal-header-custom .btn-close {
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
        opacity: 1 !important;
        width: 1em;
        height: 1em;
        border: none;
        padding: 0.25em;
    }

    .modal-header-custom .btn-close:hover {
        opacity: 0.75 !important;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .form-label .required {
        color: #dc3545;
        margin-left: 3px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #242b62;
        box-shadow: 0 0 0 0.2rem rgba(240, 147, 251, 0.15);
    }

    .btn-submit {
        background: #242b62;
        color: white;
        padding: 10px 28px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        color: white;
    }

    .file-upload-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-preview {
        margin-top: 10px;
        max-width: 150px;
        border-radius: 8px;
        border: 2px solid #e9ecef;
    }

    /* Tab Navigation Styles */
    .college-tabs-wrapper {
        background: white;
        padding: 20px 30px 0;
    }

    .nav-tabs {
        border-bottom: 2px solid #242b62;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 600;
        padding: 12px 24px;
        margin-right: 8px;
        background: #f8f9fa;
        border-radius: 8px 8px 0 0;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        background: #e9ecef;
        color: #495057;
    }

    .nav-tabs .nav-link.active {
        background: #242b62;
        color: white;
    }

    .tab-content {
        padding: 0;
    }

    .btn-approve {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        margin: 0 3px;
    }

    .btn-approve:hover {
       background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        color: white;
    }

    .btn-reject {
         background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        margin: 0 3px;
    }

    .btn-reject:hover {
          background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        color: white;
    }

    /* Approve/Reject Modal Styles */
    .modal-header-approve {
        background: #242a62;
        color: white;
        padding: 20px 30px;
        border: none;
    }

    .modal-header-reject {
        background: #242a62;
        color: white;
        padding: 20px 30px;
        border: none;
    }

    .modal-header-approve .modal-title,
    .modal-header-reject .modal-title {
        font-size: 20px;
        font-weight: 700;
    }

    .modal-header-approve .btn-close,
    .modal-header-reject .btn-close {
        filter: brightness(0) invert(1);
        opacity: 1 !important;
        background-size: 20px;
        background: #242b62!important;
        border: none;
    }

    .modal-header-approve .btn-close:hover,
    .modal-header-reject .btn-close:hover {
        opacity: 0.8 !important;
    }

    .alert-modal {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 600;
        /* display: none; */
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-modal.show {
        display: block;
    }

    .alert-modal.alert-warning {
        background: linear-gradient(135deg, #fff9e6 0%, #fff3cd 100%);
        color: #856404;
        border: 2px solid #ffc107;
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);
    }

    .alert-modal.alert-warning i {
        font-size: 20px;
        margin-right: 8px;
        vertical-align: middle;
    }

    .alert-modal.alert-danger {
        background: linear-gradient(135deg, #ffe6e6 0%, #f8d7da 100%);
        color: #721c24;
        border: 2px solid #dc3545;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
    }

    .alert-modal.alert-danger i {
        font-size: 20px;
        margin-right: 8px;
        vertical-align: middle;
    }

    .college-info-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #667eea;
        margin-bottom: 20px;
    }

    .college-info-box strong {
        color: #2c3e50;
        display: block;
        margin-bottom: 5px;
    }

    .college-info-box .college-name {
        color: #667eea;
        font-size: 16px;
        font-weight: 700;
    }

    .college-info-box .university-name {
        color: #6c757d;
        font-size: 14px;
        font-style: italic;
        display: block;
        margin-top: 5px;
    }

    .btn-generate-password {
        background: #242b62;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 0 6px 6px 0;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-generate-password:hover {
        background: #242b62;
        transform: scale(1.02);
        color: white;
    }

    .password-input-wrapper {
        display: flex;
        width: 100%;
    }

    .password-input-wrapper .input-group {
        flex: 1;
        border-radius: 6px 0 0 6px;
    }

    .password-input-wrapper .input-group .form-control {
        border-radius: 0;
    }

    .input-group-text {
        background: #f8f9fa;
        border: 1px solid #ced4da;
    }

    /* College Profile Modal Styles */
    .profile-header {
        background: #242b62;
        padding: 30px;
        text-align: center;
        color: white;
    }

    .profile-header .btn-close {
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
        opacity: 1 !important;
        width: 1em;
        height: 1em;
        border: none;
        padding: 0.25em;
    }

    .profile-header .btn-close:hover {
        opacity: 0.75 !important;
    }

    .profile-logo-large {
        width: 120px;
        height: 120px;
        border-radius: 15px;
        border: 5px solid white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        object-fit: cover;
        margin-bottom: 15px;
    }

    .profile-header h4 {
        margin: 10px 0 5px 0;
        font-weight: 700;
    }

    .profile-header .college-code {
        opacity: 0.9;
        font-size: 14px;
    }

    .profile-section {
        padding: 25px;
    }

    .profile-section-title {
        font-size: 18px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #242b62;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .profile-detail-row {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .profile-detail-label {
        font-weight: 700;
        color: #495057;
        width: 180px;
        flex-shrink: 0;
    }

    .profile-detail-value {
        color: #6c757d;
        flex: 1;
    }

    .profile-status-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 13px;
        display: inline-block;
    }

    /* ---- Select2 inside modal overrides ---- */
    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        border-radius: 6px;
        min-height: 38px;
        padding: 2px 6px;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #242b62;
        box-shadow: 0 0 0 0.2rem rgba(36, 43, 98, 0.15);
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #242b62;
        border: none;
        color: white;
        border-radius: 4px;
        padding: 2px 8px;
        font-size: 12px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: rgba(255,255,255,0.8);
        margin-right: 4px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: white;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="card" style="border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
        <div class="college-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5><i class="bx bx-building"></i> College Management</h5>
                    <p>Manage colleges and their information</p>
                </div>
                @can('College-Add')
                <button type="button" class="btn btn-add-college" onclick="openAddCollegeModal()">
                    <i class="bx bx-plus-circle"></i> Add New College
                </button>
                @endcan
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="college-tabs-wrapper">
            <ul class="nav nav-tabs" id="collegeTabs" role="tablist">
                 <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="new-requests-tab" data-bs-toggle="tab" data-bs-target="#new-requests" type="button">
                        <i class="bx bx-time-five"></i>&nbsp; New College Requests
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link " id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button">
                        <i class="bx bx-check-circle"></i>&nbsp; Approved Colleges
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button">
                        <i class="bx bx-x-circle"></i>&nbsp; Rejected Colleges
                    </button>
                </li>
            </ul>
        </div>

        <div class="table-container">
            <div class="tab-content" id="collegeTabContent">
                <!-- Approved Colleges Tab -->
                <div class="tab-pane fade " id="approved" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-college table-hover" id="approvedCollegeTable">
                            <thead>
                                <tr>
                                    <th>SR. NO</th>
                                    <th>COLLEGE NAME</th>
                                    <th>CODE</th>
                                    <th>UNIVERSITY</th>
                                    <th>LOCATION</th>
                                    <th>CONTACT</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Rejected Colleges Tab -->
                <div class="tab-pane fade" id="rejected" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-college table-hover" id="rejectedCollegeTable">
                            <thead>
                                <tr>
                                    <th>SR. NO</th>
                                    <th>COLLEGE NAME</th>
                                    <th>CODE</th>
                                    <th>UNIVERSITY</th>
                                    <th>LOCATION</th>
                                    <th>REJECTED DATE</th>
                                    <th>REASON</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- New College Requests Tab -->
                <div class="tab-pane fade show active" id="new-requests" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-college table-hover" id="newRequestsTable">
                            <thead>
                                <tr>
                                    <th>SR. NO</th>
                                    <th>COLLEGE NAME</th>
                                    <th>CODE</th>
                                    <th>UNIVERSITY</th>
                                    <th>LOCATION</th>
                                    <th>CONTACT</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- College Profile View Modal (XL) -->
<div class="modal fade" id="collegeProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <!-- Profile Header -->
            <div class="profile-header">
                <img src="https://via.placeholder.com/120" alt="College Logo" class="profile-logo-large" id="profileLogo">
                <h4 id="profileCollegeName">Government Engineering College</h4>
                <p class="college-code" id="profileCollegeCode">GEC-AHM-001</p>
                <span class="profile-status-badge status-approved" id="profileStatus">Approved</span>
            </div>

            <div class="modal-body" style="padding: 0;">
                <!-- Basic Information Section -->
                <div class="profile-section">
                    <div class="profile-section-title">
                        <i class="bx bx-info-circle"></i> Basic Information
                    </div>
                    <div class="profile-detail-row">
                        <div class="profile-detail-label">University:</div>
                        <div class="profile-detail-value" id="profileUniversity">Gujarat University</div>
                    </div>
                    <div class="profile-detail-row">
                        <div class="profile-detail-label">College Type:</div>
                        <div class="profile-detail-value" id="profileType">Government</div>
                    </div>
                    <div class="profile-detail-row">
                        <div class="profile-detail-label">Affiliation Status :</div>
                        <div class="profile-detail-value" id="profileAffiliation">Affiliated</div>
                    </div>
                    <div class="profile-detail-row">
                        <div class="profile-detail-label">Established Year :</div>
                        <div class="profile-detail-value" id="profileEstYear">1948</div>
                    </div>
                    <div class="profile-detail-row">
                        <div class="profile-detail-label">Website:</div>
                        <div class="profile-detail-value">
                            <a href="#" id="profileWebsite" target="_blank" style="color: #667eea;">https://college.edu</a>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="profile-section" style="background: #f8f9fa;">
                    <div class="profile-section-title">
                        <i class="bx bx-phone"></i> Contact Information
                    </div>
                    <div class="profile-detail-row">
                        <div class="profile-detail-label">Email:</div>
                        <div class="profile-detail-value" id="profileEmail">info@college.edu</div>
                    </div>
                    <div class="profile-detail-row">
                        <div class="profile-detail-label">Phone:</div>
                        <div class="profile-detail-value" id="profilePhone">+91 XXXXXXXXXX</div>
                    </div>
                    <div class="profile-detail-row">
                        <div class="profile-detail-label">Address:</div>
                        <div class="profile-detail-value" id="profileAddress">Complete address here</div>
                    </div>
                    <div class="profile-detail-row">
                        <div class="profile-detail-label">City:</div>
                        <div class="profile-detail-value" id="profileCity">Ahmedabad</div>
                    </div>
                    <div class="profile-detail-row">
                        <div class="profile-detail-label">State:</div>
                        <div class="profile-detail-value" id="profileState">Gujarat</div>
                    </div>
                    <div class="profile-detail-row">
                        <div class="profile-detail-label">Pincode:</div>
                        <div class="profile-detail-value" id="profilePincode">380001</div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="profile-section">
                    <div class="profile-section-title">
                        <i class="bx bx-detail"></i> About College
                    </div>
                    <p id="profileDescription" style="color: #6c757d; line-height: 1.8;">
                        College description will be displayed here. This section provides detailed information about the college, its history, achievements, and facilities.
                    </p>
                </div>
            </div>

            <div class="modal-footer" style="background: white; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add College Modal -->
<div class="modal fade" id="addCollegeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title" style="color: #fff;"><i class="bx bx-plus-circle"></i> Add New College</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
                <form id="addCollegeForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">College Name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="addCollegeName" placeholder="Enter college name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">College Code <span class="required">*</span></label>
                            <input type="text" class="form-control" id="addCollegeCode" placeholder="e.g., GEC-AHM-001" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">University <span class="required">*</span></label>
                            <select class="form-select" id="addUniversity" required>
                                <option value="">Select University</option>
                                @foreach($universities as $university)
                                    <option value="{{ $university->id }}">{{ $university->university_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Degrees multi-select (Select2) --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Degrees <span class="required">*</span></label>
                            <select class="form-select" id="addDegrees" name="degree_ids[]" multiple>
                                @foreach($degrees as $degree)
                                    <option value="{{ $degree->degree_id }}">{{ $degree->degree_name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Select one or more degrees offered by this college.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input type="email" class="form-control" id="addEmail" placeholder="college@email.com" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone <span class="required">*</span></label>
                            <input type="tel" class="form-control" id="addPhone" placeholder="+91 XXXXXXXXXX" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Website</label>
                            <input type="url" class="form-control" id="addWebsite" placeholder="https://college.edu">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Established Year</label>
                            <input type="number" class="form-control" id="addEstYear" placeholder="e.g., 1948" min="1800" max="2026">
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">Address <span class="required">*</span></label>
                            <textarea class="form-control" id="addAddress" rows="2" placeholder="Enter complete address" required></textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">City <span class="required">*</span></label>
                            <input type="text" class="form-control" id="addCity" placeholder="Enter city" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">State <span class="required">*</span></label>
                            <select class="form-select" id="addState" required>
                                <option value="">Select State</option>
                                <option value="Gujarat">Gujarat</option>
                                <option value="Maharashtra">Maharashtra</option>
                                <option value="Rajasthan">Rajasthan</option>
                                <option value="Delhi">Delhi</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pincode <span class="required">*</span></label>
                            <input type="text" class="form-control" id="addPincode" placeholder="e.g., 380001" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">College Logo</label>
                            <input type="file" class="form-control" id="addLogo" accept="image/*">
                            <img id="logoPreview" class="file-preview" style="display: none;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status <span class="required">*</span></label>
                            <select class="form-select" id="addStatus" required>
                                <option value="0">Pending Verification</option>
                                <option value="1">Approved</option>
                                <option value="2">Rejected</option>
                            </select>
                        </div>
                      
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn btn-submit" onclick="saveCollege()">
                    <i class="bx bx-save"></i> Save College
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Approve College Modal -->
<div class="modal fade" id="approveCollegeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header modal-header-approve">
                <h5 class="modal-title" style="color: #fff;"><i class="bx bx-check-circle"></i> Approve College</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">

                <!-- Toggle Button -->
                <div class="text-end mb-3">
                    <button type="button" class="btn btn-sm" id="btnToggleCollegeReplace" onclick="toggleCollegeReplaceSection()" style="background:linear-gradient(135deg, #17a2b8 0%, #138496 100%); color:#fff; padding:6px 16px; border-radius:6px; font-weight:600; font-size:13px; border:none;">
                        <i class="bx bx-transfer"></i> Replace College
                    </button>
                </div>

                <!-- ===== SECTION 1: Normal Approve ===== -->
                <div id="approveCollegeNormalSection">
                    <!-- Alert for existing college -->
                    <div class="alert-modal alert-warning" id="approveAlertExisting">
                        <i class="bx bx-error-circle"></i> 
                        <div style="display: inline-block; vertical-align: middle;">
                            <strong>Warning!</strong> A college with the same name already exists in the system.
                            <div style="font-size: 12px; margin-top: 3px; opacity: 0.9;">Please verify this is a different college before approving.</div>
                        </div>
                    </div>

                    <!-- College Information -->
                    <div class="college-info-box">
                        <strong>College Name:</strong>
                        <span class="college-name" id="approveCollegeName">College Name Here</span>
                        <span class="university-name" id="approveUniversityName">University Name</span>
                    </div>

                    <form id="approveCollegeForm">
                        <input type="hidden" id="approveCollegeId" value="">
                        
                        <div class="mb-3">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input type="email" class="form-control" id="approveEmail" placeholder="Enter email address" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password <span class="required">*</span></label>
                            <div class="password-input-wrapper">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-lock-alt"></i></span>
                                    <input type="text" class="form-control" id="approvePassword" placeholder="Enter or generate password" required>
                                </div>
                                <button type="button" class="btn btn-generate-password" onclick="generatePassword('approve')">
                                    <i class="bx bx-refresh"></i> Auto Generate
                                </button>
                            </div>
                        </div>

                        <div class="alert alert-info" role="alert" style="font-size: 13px;">
                            <i class="bx bx-info-circle"></i> Please verify your credentials to approve this college. University will also be approved automatically.
                        </div>
                    </form>
                </div>

                <!-- ===== SECTION 2: Replace College ===== -->
                <div id="replaceCollegeSection" style="display:none;">
                    <div class="alert-modal" style="background: linear-gradient(135deg, #e8f4fd 0%, #d1ecf1 100%); color: #0c5460; border: 2px solid #17a2b8; box-shadow: 0 4px 12px rgba(23,162,184,0.2); padding: 15px 20px; border-radius: 8px; margin-bottom: 20px;">
                        <i class="bx bx-transfer" style="font-size:20px; margin-right:8px; vertical-align:middle;"></i>
                        <div style="display: inline-block; vertical-align: middle;">
                            <strong>Replace College</strong>
                            <div style="font-size: 12px; margin-top: 3px;">The current college will be moved under the selected replacement college's university, then removed.</div>
                        </div>
                    </div>

                    <!-- Current College -->
                    <div class="mb-3">
                        <label class="form-label"><i class="bx bx-building-house" style="color:#dc3545;"></i> Current College</label>
                        <input type="text" class="form-control" id="replaceCurrentCollegeName" readonly style="background:#f8d7da; border:2px solid #f5c6cb; border-radius:8px; padding:10px 14px; font-weight:600; color:#721c24;">
                    </div>

                    <!-- Replace With -->
                    <div class="mb-3">
                        <label class="form-label"><i class="bx bx-transfer-alt" style="color:#28a745;"></i> Replace With <span class="required">*</span></label>
                        <select class="form-select" id="replaceWithCollege" style="border:2px solid #e0e0e0; border-radius:8px; padding:10px 14px;" required>
                            <option value="">Select College</option>
                        </select>
                    </div>

                    <!-- Show replacement college's university -->
                    <div id="replaceCollegeUniversityInfo" style="display:none;">
                        <div style="background: #d4edda; padding: 12px 15px; border-radius: 8px; border-left: 4px solid #28a745; margin-bottom: 15px;">
                            <strong style="color: #155724; font-size: 13px;"><i class="bx bx-buildings"></i> College will be moved to university:</strong>
                            <span id="replaceCollegeUniversityName" style="color: #155724; font-weight: 700; display: block; margin-top: 4px;"></span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn btn-approve" id="btnCollegeApprove" onclick="handleCollegeApproveAction()">
                    <i class="bx bx-check"></i> Approve College
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reject College Modal -->
<div class="modal fade" id="rejectCollegeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header modal-header-reject">
                <h5 class="modal-title" style="color: #fff;"><i class="bx bx-x-circle"></i> Reject College</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <!-- Alert for existing college -->
                <div class="alert-modal alert-danger" id="rejectAlertExisting">
                    <i class="bx bx-error-circle"></i> 
                    <div style="display: inline-block; vertical-align: middle;">
                        <strong>Alert!</strong> College already exists in the system.
                        <div style="font-size: 12px; margin-top: 3px; opacity: 0.9;">Do not approve this college. Consider rejecting with appropriate reason.</div>
                    </div>
                </div>

                <!-- College Information -->
                <div class="college-info-box" style="border-left-color: #dc3545;">
                    <strong>College Name:</strong>
                    <span class="college-name" style="color: #dc3545;" id="rejectCollegeName">College Name Here</span>
                    <span class="university-name" id="rejectUniversityName">University Name</span>
                </div>

                <form id="rejectCollegeForm">
                    <input type="hidden" id="rejectCollegeId" value="">
                    
                    <div class="mb-3">
                        <label class="form-label">Rejection Reason <span class="required">*</span></label>
                        <textarea class="form-control" id="rejectReason" rows="3" placeholder="Enter reason for rejection..." required></textarea>
                    </div>

                    <div class="alert alert-warning" role="alert" style="font-size: 13px;">
                        <i class="bx bx-error-circle"></i> Please verify your credentials to reject this college.
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn btn-reject" onclick="confirmRejectCollege()">
                    <i class="bx bx-x-circle"></i> Reject College
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
{{-- Select2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var newRequestsTable, approvedTable, rejectedTable;

    $(document).ready(function() {

        // ---- Initialise Select2 for Degrees inside the modal ----
        // dropdownParent is critical so the dropdown renders above the modal overlay
        $('#addDegrees').select2({
            placeholder: 'Select Degrees',
            allowClear: true,
            dropdownParent: $('#addCollegeModal'),
            width: '100%'
        });
        // Pending requests (status=0)
        newRequestsTable = $('#newRequestsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.college.data') }}",
                data: { status: 0 }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'college_name', name: 'college_name', render: function(data) { return '<strong>' + $('<span>').text(data).html() + '</strong>'; } },
                { data: 'college_code', name: 'college_code' },
                { data: 'university_name', name: 'university_name', render: function(data) { return '<span class="university-tag">' + $('<span>').text(data).html() + '</span>'; } },
                { data: 'location', name: 'location', orderable: false, searchable: false },
                { data: 'contact', name: 'contact', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search new requests..."
            }
        });

        // Approved colleges (status=1)
        approvedTable = $('#approvedCollegeTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.college.data') }}",
                data: { status: 1 }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'college_name', name: 'college_name', render: function(data) { return '<strong>' + $('<span>').text(data).html() + '</strong>'; } },
                { data: 'college_code', name: 'college_code' },
                { data: 'university_name', name: 'university_name', render: function(data) { return '<span class="university-tag">' + $('<span>').text(data).html() + '</span>'; } },
                { data: 'location', name: 'location', orderable: false, searchable: false },
                { data: 'contact', name: 'contact', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search approved colleges..."
            }
        });

        // Rejected colleges (status=2)
        rejectedTable = $('#rejectedCollegeTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.college.data') }}",
                data: { status: 2 }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'college_name', name: 'college_name', render: function(data) { return '<strong>' + $('<span>').text(data).html() + '</strong>'; } },
                { data: 'college_code', name: 'college_code' },
                { data: 'university_name', name: 'university_name', render: function(data) { return '<span class="university-tag">' + $('<span>').text(data).html() + '</span>'; } },
                { data: 'location', name: 'location', orderable: false, searchable: false },
                { data: 'created_at', name: 'created_at' },
                { data: 'reject_reason', name: 'reject_reason', render: function(data) { return '<small>' + $('<span>').text(data).html() + '</small>'; } },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search rejected colleges..."
            }
        });

        // Logo preview
        $('#addLogo').on('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#logoPreview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(file);
            }
        });
    });

    function reloadAllTables() {
        newRequestsTable.ajax.reload(null, false);
        approvedTable.ajax.reload(null, false);
        rejectedTable.ajax.reload(null, false);
    }

    // ========== Add College ==========
    var editingCollegeId = null;

    window.openAddCollegeModal = function() {
        editingCollegeId = null;
        document.getElementById('addCollegeForm').reset();
        // Reset Select2 degrees selection
        $('#addDegrees').val(null).trigger('change');
        $('#logoPreview').hide();
        $('#addCollegeModal .modal-title').html('<i class="bx bx-plus-circle"></i> Add New College');
        $('#addCollegeModal .btn-submit').html('<i class="bx bx-save"></i> Save College');
        var modal = new bootstrap.Modal(document.getElementById('addCollegeModal'));
        modal.show();
    }

    window.saveCollege = function() {
        var form = document.getElementById('addCollegeForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        var formData = new FormData();
        formData.append('college_name', $('#addCollegeName').val());
        formData.append('college_code', $('#addCollegeCode').val());
        formData.append('university_id', $('#addUniversity').val());
        formData.append('email', $('#addEmail').val());
        formData.append('phone', $('#addPhone').val());
        formData.append('website', $('#addWebsite').val());
        formData.append('established_year', $('#addEstYear').val());
        formData.append('address', $('#addAddress').val());
        formData.append('city', $('#addCity').val());
        formData.append('state', $('#addState').val());
        formData.append('pincode', $('#addPincode').val());
        formData.append('status', $('#addStatus').val());

        // Append each selected degree ID as an array field
        var selectedDegrees = $('#addDegrees').val() || [];
        selectedDegrees.forEach(function(degreeId) {
            formData.append('degree_ids[]', degreeId);
        });

        var logoFile = document.getElementById('addLogo').files[0];
        if (logoFile) {
            formData.append('logo', logoFile);
        }

        var url, method;
        if (editingCollegeId) {
            url = "{{ url('admin/college') }}/" + editingCollegeId + "/update";
            method = 'POST';
        } else {
            url = "{{ route('admin.college.store') }}";
            method = 'POST';
        }

        $.ajax({
            url: url,
            method: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                bootstrap.Modal.getInstance(document.getElementById('addCollegeModal')).hide();
                alert(editingCollegeId ? 'College updated successfully!' : 'College added successfully!');
                editingCollegeId = null;
                reloadAllTables();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var msg = '';
                    $.each(errors, function(key, val) {
                        msg += val[0] + '\n';
                    });
                    alert(msg);
                } else {
                    alert('Error: Something went wrong!');
                }
            }
        });
    }

    // ========== Edit College ==========
    window.editCollege = function(id) {
        $.ajax({
            url: "{{ url('admin/college') }}/" + id + "/edit",
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    var data = response.data;
                    editingCollegeId = id;
                    $('#addCollegeName').val(data.college_name);
                    $('#addCollegeCode').val(data.college_code);
                    $('#addUniversity').val(data.university_id);
                    $('#addEmail').val(data.email);
                    $('#addPhone').val(data.phone);
                    $('#addWebsite').val(data.website);
                    $('#addEstYear').val(data.established_year);
                    $('#addAddress').val(data.address);
                    $('#addCity').val(data.city);
                    $('#addState').val(data.state);
                    $('#addPincode').val(data.pincode);
                    $('#addStatus').val(data.status);

                    // Pre-select saved degrees in Select2
                    // degree_ids is returned as an array from the JSON cast
                    var savedDegrees = data.degree_ids || [];
                    $('#addDegrees').val(savedDegrees).trigger('change');

                    if (data.logo) {
                        $('#logoPreview').attr('src', "{{ url('/') }}/" + data.logo).show();
                    } else {
                        $('#logoPreview').hide();
                    }

                    $('#addCollegeModal .modal-title').html('<i class="bx bx-edit"></i> Edit College');
                    $('#addCollegeModal .btn-submit').html('<i class="bx bx-save"></i> Update College');

                    var modal = new bootstrap.Modal(document.getElementById('addCollegeModal'));
                    modal.show();
                }
            }
        });
    }

    // Reset modal on close
    $('#addCollegeModal').on('hidden.bs.modal', function () {
        editingCollegeId = null;
        $('#addCollegeModal .modal-title').html('<i class="bx bx-plus-circle"></i> Add New College');
        $('#addCollegeModal .btn-submit').html('<i class="bx bx-save"></i> Save College');
        document.getElementById('addCollegeForm').reset();
        // Clear Select2 degrees selection on modal close
        $('#addDegrees').val(null).trigger('change');
        $('#logoPreview').hide();
    });

    // ========== View College Profile ==========
    window.viewCollegeProfile = function(id) {
        $.ajax({
            url: "{{ url('admin/college') }}/" + id + "/show",
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    var data = response.data;
                    var statusText = data.status == 0 ? 'Pending' : (data.status == 1 ? 'Approved' : 'Rejected');
                    var statusClass = data.status == 0 ? 'status-pending' : (data.status == 1 ? 'status-approved' : 'status-rejected');

                    $('#profileLogo').attr('src', data.logo ? "{{ url('/') }}/" + data.logo : 'https://via.placeholder.com/120');
                    $('#profileCollegeName').text(data.college_name || '');
                    $('#profileCollegeCode').text(data.college_code || '');
                    $('#profileStatus').text(statusText).attr('class', 'profile-status-badge ' + statusClass);
                    $('#profileUniversity').text(data.university ? data.university.university_name : 'N/A');
                    $('#profileType').text('N/A');
                    $('#profileAffiliation').text('N/A');
                    $('#profileEstYear').text(data.established_year || 'N/A');
                    $('#profileWebsite').text(data.website || 'N/A').attr('href', data.website || '#');
                    $('#profileEmail').text(data.email || 'N/A');
                    $('#profilePhone').text(data.phone || 'N/A');
                    $('#profileAddress').text(data.address || 'N/A');
                    $('#profileCity').text(data.city || 'N/A');
                    $('#profileState').text(data.state || 'N/A');
                    $('#profilePincode').text(data.pincode || 'N/A');
                    $('#profileDescription').text('');

                    var modal = new bootstrap.Modal(document.getElementById('collegeProfileModal'));
                    modal.show();
                }
            }
        });
    }

    // ========== Delete College ==========
    window.deleteCollege = function(id) {
        if (confirm('Are you sure you want to delete this college?')) {
            $.ajax({
                url: "{{ url('admin/college') }}/" + id,
                method: 'DELETE',
                success: function(response) {
                    alert('College deleted successfully!');
                    reloadAllTables();
                },
                error: function(xhr) {
                    alert('Error: Something went wrong!');
                }
            });
        }
    }

    // ========== Approve College ==========
    var isCollegeReplaceMode = false;
    var allApprovedColleges = [];

    window.approveCollege = function(id) {
        // Reset to normal approve mode
        showCollegeApproveSection();

        // Get college name via AJAX
        $.ajax({
            url: "{{ url('admin/college') }}/" + id + "/show",
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    var data = response.data;
                    document.getElementById('approveCollegeId').value = id;
                    document.getElementById('approveCollegeName').textContent = data.college_name;
                    document.getElementById('approveUniversityName').textContent = 'University: ' + (data.university ? data.university.university_name : 'N/A');
                    document.getElementById('approveCollegeForm').reset();
                    document.getElementById('approveCollegeId').value = id;

                    // Pre-fill email if exists
                    if (data.email) {
                        $('#approveEmail').val(data.email);
                    }

                    // Check if college name already exists
                    $.ajax({
                        url: "{{ route('admin.college.checkExists') }}",
                        method: 'POST',
                        data: { college_name: data.college_name },
                        success: function(res) {
                            if (res.exists) {
                                $('#approveAlertExisting').show();
                            } else {
                                $('#approveAlertExisting').hide();
                            }
                        }
                    });

                    var modal = new bootstrap.Modal(document.getElementById('approveCollegeModal'));
                    modal.show();
                }
            }
        });
    }

    window.handleCollegeApproveAction = function() {
        if (isCollegeReplaceMode) {
            confirmReplaceCollege();
        } else {
            confirmApproveCollege();
        }
    }

    window.toggleCollegeReplaceSection = function() {
        if (isCollegeReplaceMode) {
            showCollegeApproveSection();
        } else {
            showCollegeReplaceSection();
        }
    }

    window.showCollegeReplaceSection = function() {
        isCollegeReplaceMode = true;
        var collegeName = document.getElementById('approveCollegeName').textContent;
        $('#replaceCurrentCollegeName').val(collegeName);

        // Hide approve section, show replace section
        $('#approveCollegeNormalSection').hide();
        $('#replaceCollegeSection').show();

        // Update toggle button text
        $('#btnToggleCollegeReplace').html('<i class="bx bx-arrow-back"></i> Back to Approve');

        // Update modal title
        $('#approveCollegeModal .modal-title').html('<i class="bx bx-transfer"></i> Replace College');

        // Update footer button text
        $('#btnCollegeApprove').html('<i class="bx bx-check"></i> Confirm Replace');

        // Load approved colleges list
        $.get("{{ route('admin.college.all') }}", function(response) {
            var collegeId = document.getElementById('approveCollegeId').value;
            var html = '<option value="">Select College</option>';
            allApprovedColleges = response.data || [];
            allApprovedColleges.forEach(function(col) {
                if (col.id != collegeId) {
                    html += '<option value="' + col.id + '">' + $('<span>').text(col.college_name).html() + '</option>';
                }
            });
            $('#replaceWithCollege').html(html);
        });

        // Reset university info
        $('#replaceCollegeUniversityInfo').hide();
    }

    // When replacement college is selected, show its university
    $(document).on('change', '#replaceWithCollege', function() {
        var selectedId = $(this).val();
        if (selectedId && allApprovedColleges.length > 0) {
            var selected = allApprovedColleges.find(function(c) { return c.id == selectedId; });
            if (selected && selected.university) {
                $('#replaceCollegeUniversityName').text(selected.university.university_name);
                $('#replaceCollegeUniversityInfo').show();
            } else {
                $('#replaceCollegeUniversityInfo').hide();
            }
        } else {
            $('#replaceCollegeUniversityInfo').hide();
        }
    });

    window.showCollegeApproveSection = function() {
        isCollegeReplaceMode = false;

        // Show approve section, hide replace section
        $('#approveCollegeNormalSection').show();
        $('#replaceCollegeSection').hide();

        // Update toggle button text
        $('#btnToggleCollegeReplace').html('<i class="bx bx-transfer"></i> Replace College');

        // Reset modal title
        $('#approveCollegeModal .modal-title').html('<i class="bx bx-check-circle"></i> Approve College');

        // Reset footer button text
        $('#btnCollegeApprove').html('<i class="bx bx-check"></i> Approve College');
    }

    window.confirmReplaceCollege = function() {
        var collegeId = document.getElementById('approveCollegeId').value;
        var replaceWithId = $('#replaceWithCollege').val();

        if (!replaceWithId) {
            $('#replaceWithCollege').focus();
            alert('Please select a college to replace with.');
            return;
        }

        $.ajax({
            url: "{{ url('admin/college') }}/" + collegeId + "/replace",
            method: 'POST',
            data: {
                replace_with_id: replaceWithId
            },
            success: function(response) {
                bootstrap.Modal.getInstance(document.getElementById('approveCollegeModal')).hide();
                showCollegeApproveSection();
                alert('College replaced successfully!');
                reloadAllTables();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong!'));
            }
        });
    }

    // Reset modal on close
    $('#approveCollegeModal').on('hidden.bs.modal', function () {
        showCollegeApproveSection();
    });

    window.confirmApproveCollege = function() {
        var form = document.getElementById('approveCollegeForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        var collegeId = document.getElementById('approveCollegeId').value;
        var email = document.getElementById('approveEmail').value;
        var password = document.getElementById('approvePassword').value;

        $.ajax({
            url: "{{ url('admin/college') }}/" + collegeId + "/approve",
            method: 'POST',
            data: {
                email: email,
                password: password
            },
            success: function(response) {
                bootstrap.Modal.getInstance(document.getElementById('approveCollegeModal')).hide();
                alert('College approved successfully! University also approved.');
                reloadAllTables();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong!'));
            }
        });
    }

    // ========== Reject College ==========
    window.rejectCollege = function(id) {
        $.ajax({
            url: "{{ url('admin/college') }}/" + id + "/show",
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    var data = response.data;
                    document.getElementById('rejectCollegeId').value = id;
                    document.getElementById('rejectCollegeName').textContent = data.college_name;
                    document.getElementById('rejectUniversityName').textContent = 'University: ' + (data.university ? data.university.university_name : 'N/A');
                    document.getElementById('rejectReason').value = '';
                    document.getElementById('rejectCollegeForm').reset();
                    document.getElementById('rejectCollegeId').value = id;

                    // Check if college name already exists
                    $.ajax({
                        url: "{{ route('admin.college.checkExists') }}",
                        method: 'POST',
                        data: { college_name: data.college_name },
                        success: function(res) {
                            if (res.exists) {
                                $('#rejectAlertExisting').show();
                            } else {
                                $('#rejectAlertExisting').hide();
                            }
                        }
                    });

                    var modal = new bootstrap.Modal(document.getElementById('rejectCollegeModal'));
                    modal.show();
                }
            }
        });
    }

    window.confirmRejectCollege = function() {
        var form = document.getElementById('rejectCollegeForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        var collegeId = document.getElementById('rejectCollegeId').value;
        var reason = document.getElementById('rejectReason').value;

        $.ajax({
            url: "{{ url('admin/college') }}/" + collegeId + "/reject",
            method: 'POST',
            data: {
                reject_reason: reason
            },
            success: function(response) {
                bootstrap.Modal.getInstance(document.getElementById('rejectCollegeModal')).hide();
                alert('College rejected successfully!');
                reloadAllTables();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var msg = '';
                    $.each(errors, function(key, val) {
                        msg += val[0] + '\n';
                    });
                    alert(msg);
                } else {
                    alert('Error: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong!'));
                }
            }
        });
    }

    // Auto Generate Password Function
    window.generatePassword = function(type) {
        var length = 12;
        var charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        var password = '';

        password += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.charAt(Math.floor(Math.random() * 26));
        password += 'abcdefghijklmnopqrstuvwxyz'.charAt(Math.floor(Math.random() * 26));
        password += '0123456789'.charAt(Math.floor(Math.random() * 10));
        password += '!@#$%^&*'.charAt(Math.floor(Math.random() * 8));

        for (var i = password.length; i < length; i++) {
            password += charset.charAt(Math.floor(Math.random() * charset.length));
        }

        password = password.split('').sort(function() { return Math.random() - 0.5; }).join('');

        if (type === 'approve') {
            document.getElementById('approvePassword').value = password;
        } else if (type === 'reject') {
            document.getElementById('rejectPassword').value = password;
        }

        var btn = event.target.closest('.btn-generate-password');
        var originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bx bx-check"></i> Generated!';
        setTimeout(function() {
            btn.innerHTML = originalText;
        }, 2000);
    }
</script>
@endpush
