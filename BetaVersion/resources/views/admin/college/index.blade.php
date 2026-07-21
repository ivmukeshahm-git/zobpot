@extends('admin.layout.layout')
@section('content')
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
                <button type="button" class="btn btn-add-college" onclick="openAddCollegeModal()">
                    <i class="bx bx-plus-circle"></i> Add New College
                </button>
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
                                <tr data-id="1">
                                    <td>1</td>
                                    <td><strong>Government Engineering College</strong></td>
                                    <td>GEC-AHM-001</td>
                                    <td><span class="university-tag">Gujarat University</span></td>
                                    <td>Ahmedabad, Gujarat</td>
                                    <td>
                                        <div style="font-size: 13px;">
                                            <div><i class="bx bx-phone"></i> +91 79 2718 1051</div>
                                            <div><i class="bx bx-envelope"></i> info@gecg28.ac.in</div>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-action btn-view btn-sm p-2" onclick="viewCollegeProfile(1)">
                                            <i class="bx bx-show"></i> 
                                        </button>
                                        <button class="btn btn-action btn-edit btn-sm p-2" onclick="editCollege(1)">
                                            <i class="bx bx-edit"></i> 
                                        </button>
                                        <button class="btn btn-action btn-delete btn-sm p-2" onclick="deleteCollege(1)">
                                            <i class="bx bx-trash"></i> 
                                        </button>
                                    </td>
                                </tr>
                                <tr data-id="2">
                                    <td>2</td>
                                    <td><strong>Birla Vishvakarma Mahavidyalaya</strong></td>
                                    <td>BVM-VVN-003</td>
                                    <td><span class="university-tag">Gujarat University</span></td>
                                    <td>Vallabh Vidyanagar, Gujarat</td>
                                    <td>
                                        <div style="font-size: 13px;">
                                            <div><i class="bx bx-phone"></i> +91 2692 235969</div>
                                            <div><i class="bx bx-envelope"></i> principal@bvmengineering.ac.in</div>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-action btn-view btn-sm p-2" onclick="viewCollegeProfile(2)">
                                            <i class="bx bx-show"></i> 
                                        </button>
                                        <button class="btn btn-action btn-edit btn-sm p-2" onclick="editCollege(2)">
                                            <i class="bx bx-edit"></i> 
                                        </button>
                                        <button class="btn btn-action btn-delete btn-sm p-2" onclick="deleteCollege(2)">
                                            <i class="bx bx-trash"></i> 
                                        </button>
                                    </td>
                                </tr>
                                <tr data-id="3">
                                    <td>3</td>
                                    <td><strong>Faculty of Technology & Engineering</strong></td>
                                    <td>FTE-MSU-004</td>
                                    <td><span class="university-tag">MS University</span></td>
                                    <td>Vadodara, Gujarat</td>
                                    <td>
                                        <div style="font-size: 13px;">
                                            <div><i class="bx bx-phone"></i> +91 265 2434188</div>
                                            <div><i class="bx bx-envelope"></i> principal@msubaroda.ac.in</div>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-action btn-view btn-sm p-2" onclick="viewCollegeProfile(3)">
                                            <i class="bx bx-show"></i> 
                                        </button>
                                        <button class="btn btn-action btn-edit btn-sm p-2" onclick="editCollege(3)">
                                            <i class="bx bx-edit"></i> 
                                        </button>
                                        <button class="btn btn-action btn-delete btn-sm p-2" onclick="deleteCollege(3)">
                                            <i class="bx bx-trash"></i> 
                                        </button>
                                    </td>
                                </tr>
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
                                <tr data-id="5">
                                    <td>1</td>
                                    <td><strong>Sample Technical Institute</strong></td>
                                    <td>STI-AHM-005</td>
                                    <td><span class="university-tag">Gujarat University</span></td>
                                    <td>Ahmedabad, Gujarat</td>
                                    <td>28 Jan 2024</td>
                                    <td><small>Incomplete documentation</small></td>
                                    <td>
                                        <button class="btn btn-approve btn-sm p-2" onclick="approveCollege(5)">
                                            <i class="bx bx-check"></i> Approve
                                        </button>
                                        <button class="btn btn-action btn-delete btn-sm p-2" onclick="deleteCollege(5)">
                                            <i class="bx bx-trash"></i> 
                                        </button>
                                    </td>
                                </tr>
                                <tr data-id="6">
                                    <td>2</td>
                                    <td><strong>XYZ Polytechnic</strong></td>
                                    <td>XYZ-SUR-006</td>
                                    <td><span class="university-tag">Veer Narmad University</span></td>
                                    <td>Surat, Gujarat</td>
                                    <td>02 Feb 2024</td>
                                    <td><small>License verification failed</small></td>
                                    <td>
                                        <button class="btn btn-approve btn-sm p-2" onclick="approveCollege(6)">
                                            <i class="bx bx-check"></i> Approve
                                        </button>
                                        <button class="btn btn-action btn-delete btn-sm p-2" onclick="deleteCollege(6)">
                                            <i class="bx bx-trash"></i> 
                                        </button>
                                    </td>
                                </tr>
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
                                    <th>SUBMITTED DATE</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-id="7">
                                    <td>1</td>
                                    <td><strong>L.D. College of Engineering</strong></td>
                                    <td>LDCE-AHM-002</td>
                                    <td><span class="university-tag">Gujarat University</span></td>
                                    <td>Ahmedabad, Gujarat</td>
                                    <td>
                                        <div style="font-size: 13px;">
                                            <div><i class="bx bx-phone"></i> +91 79 2687 5950</div>
                                            <div><i class="bx bx-envelope"></i> principal@ldce.ac.in</div>
                                        </div>
                                    </td>
                                    <td>03 Feb 2024</td>
                                    <td>
                                        <button class="btn btn-action btn-view btn-sm p-2" onclick="viewCollegeProfile(7)">
                                            <i class="bx bx-show"></i> 
                                        </button>
                                        <button class="btn btn-approve btn-sm p-2" onclick="approveCollege(7)">
                                            <i class="bx bx-check"></i> Approve
                                        </button>
                                        <button class="btn btn-reject btn-sm p-2" onclick="rejectCollege(7)">
                                            <i class="bx bx-x"></i> Reject
                                        </button>
                                        <button class="btn btn-action btn-delete btn-sm p-2" onclick="deleteCollege(7)">
                                            <i class="bx bx-trash"></i> 
                                        </button>
                                    </td>
                                </tr>
                                <tr data-id="8">
                                    <td>2</td>
                                    <td><strong>Alpha Institute of Technology</strong></td>
                                    <td>AIT-RAJ-008</td>
                                    <td><span class="university-tag">GTU</span></td>
                                    <td>Rajkot, Gujarat</td>
                                    <td>
                                        <div style="font-size: 13px;">
                                            <div><i class="bx bx-phone"></i> +91 281 2345678</div>
                                            <div><i class="bx bx-envelope"></i> info@alphainstitute.ac.in</div>
                                        </div>
                                    </td>
                                    <td>05 Feb 2024</td>
                                    <td>
                                        <button class="btn btn-action btn-view btn-sm p-2" onclick="viewCollegeProfile(8)">
                                            <i class="bx bx-show"></i> 
                                        </button>
                                        <button class="btn btn-approve btn-sm p-2" onclick="approveCollege(8)">
                                            <i class="bx bx-check"></i> Approve
                                        </button>
                                        <button class="btn btn-reject btn-sm p-2" onclick="rejectCollege(8)">
                                            <i class="bx bx-x"></i> Reject
                                        </button>
                                        <button class="btn btn-action btn-delete btn-sm p-2" onclick="deleteCollege(8)">
                                            <i class="bx bx-trash"></i> 
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
                        <div class="profile-detail-label">Affiliation Status:</div>
                        <div class="profile-detail-value" id="profileAffiliation">Affiliated</div>
                    </div>
                    <div class="profile-detail-row">
                        <div class="profile-detail-label">Established Year:</div>
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
                                <option value="1">Gujarat University</option>
                                <option value="2">Sardar Patel University</option>
                                <option value="3">Maharaja Sayajirao University</option>
                            </select>
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
                                <option value="pending">Pending Verification</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
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
                        <i class="bx bx-info-circle"></i> Please verify your credentials to approve this college.
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn btn-approve" onclick="confirmApproveCollege()">
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
<script>
    $(document).ready(function() {
        // Initialize DataTables for all three tabs
        $('#approvedCollegeTable').DataTable({
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search approved colleges..."
            }
        });

        $('#rejectedCollegeTable').DataTable({
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search rejected colleges..."
            }
        });

        $('#newRequestsTable').DataTable({
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search new requests..."
            }
        });

        // Logo preview
        $('#addLogo').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#logoPreview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(file);
            }
        });
    });

    window.openAddCollegeModal = function() {
        document.getElementById('addCollegeForm').reset();
        $('#logoPreview').hide();
        const modal = new bootstrap.Modal(document.getElementById('addCollegeModal'));
        modal.show();
    }

    window.saveCollege = function() {
        const form = document.getElementById('addCollegeForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const formData = new FormData();
        formData.append('name', document.getElementById('addCollegeName').value);
        formData.append('code', document.getElementById('addCollegeCode').value);
        formData.append('university_id', document.getElementById('addUniversity').value);
        formData.append('email', document.getElementById('addEmail').value);
        formData.append('phone', document.getElementById('addPhone').value);
        formData.append('website', document.getElementById('addWebsite').value);
        formData.append('established_year', document.getElementById('addEstYear').value);
        formData.append('type', document.getElementById('addType').value);
        formData.append('affiliation_status', document.getElementById('addAffiliationStatus').value);
        formData.append('address', document.getElementById('addAddress').value);
        formData.append('city', document.getElementById('addCity').value);
        formData.append('state', document.getElementById('addState').value);
        formData.append('pincode', document.getElementById('addPincode').value);
        formData.append('status', document.getElementById('addStatus').value);
        formData.append('description', document.getElementById('addDescription').value);
        
        const logoFile = document.getElementById('addLogo').files[0];
        if (logoFile) {
            formData.append('logo', logoFile);
        }

        console.log('Saving college:', Object.fromEntries(formData));

        // AJAX call to backend
        // $.ajax({
        //     url: '{{ route("admin.college.store") }}',
        //     method: 'POST',
        //     data: formData,
        //     processData: false,
        //     contentType: false,
        //     success: function(response) {
        //         bootstrap.Modal.getInstance(document.getElementById('addCollegeModal')).hide();
        //         alert('✅ College added successfully!');
        //         location.reload();
        //     }
        // });

        bootstrap.Modal.getInstance(document.getElementById('addCollegeModal')).hide();
        alert('✅ College added successfully!');
    }

    window.viewCollegeProfile = function(id) {
        // Sample data - Replace with AJAX call to fetch actual data
        const sampleData = {
            1: {
                name: 'Government Engineering College',
                code: 'GEC-AHM-001',
                logo: 'https://via.placeholder.com/120',
                status: 'Approved',
                university: 'Gujarat University',
                type: 'Government',
                affiliation: 'Affiliated',
                estYear: '1948',
                website: 'https://gecg28.ac.in',
                email: 'info@gecg28.ac.in',
                phone: '+91 79 2718 1051',
                address: 'Government Engineering College Campus, Near Handloom House, Ahmedabad',
                city: 'Ahmedabad',
                state: 'Gujarat',
                pincode: '380015',
                description: 'Government Engineering College, Gandhinagar is one of the premier engineering institutes of Gujarat. It was established in 1948 and has been producing excellent engineers for over 70 years.'
            },
            2: {
                name: 'Birla Vishvakarma Mahavidyalaya',
                code: 'BVM-VVN-003',
                logo: 'https://via.placeholder.com/120',
                status: 'Approved',
                university: 'Gujarat Technological University',
                type: 'Private',
                affiliation: 'Affiliated',
                estYear: '1948',
                website: 'https://bvmengineering.ac.in',
                email: 'principal@bvmengineering.ac.in',
                phone: '+91 2692 235969',
                address: 'Sardar Patel University, Vallabh Vidyanagar',
                city: 'Anand',
                state: 'Gujarat',
                pincode: '388120',
                description: 'BVM Engineering College is one of the oldest and most prestigious engineering colleges in Gujarat, known for its excellent academic standards and industry connections.'
            }
        };

        const data = sampleData[id] || sampleData[1];

        // Populate modal with data
        document.getElementById('profileLogo').src = data.logo;
        document.getElementById('profileCollegeName').textContent = data.name;
        document.getElementById('profileCollegeCode').textContent = data.code;
        document.getElementById('profileStatus').textContent = data.status;
        document.getElementById('profileStatus').className = 'profile-status-badge status-' + data.status.toLowerCase();
        document.getElementById('profileUniversity').textContent = data.university;
        document.getElementById('profileType').textContent = data.type;
        document.getElementById('profileAffiliation').textContent = data.affiliation;
        document.getElementById('profileEstYear').textContent = data.estYear;
        document.getElementById('profileWebsite').textContent = data.website;
        document.getElementById('profileWebsite').href = data.website;
        document.getElementById('profileEmail').textContent = data.email;
        document.getElementById('profilePhone').textContent = data.phone;
        document.getElementById('profileAddress').textContent = data.address;
        document.getElementById('profileCity').textContent = data.city;
        document.getElementById('profileState').textContent = data.state;
        document.getElementById('profilePincode').textContent = data.pincode;
        document.getElementById('profileDescription').textContent = data.description;

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('collegeProfileModal'));
        modal.show();

        // AJAX call to fetch actual data
        // $.ajax({
        //     url: '{{ url("admin/college") }}/' + id,
        //     method: 'GET',
        //     success: function(response) {
        //         // Populate modal with actual data from response
        //     }
        // });
    }

    window.editCollege = function(id) {
        alert('Edit college: ' + id);
        // Implement edit functionality
    }

    window.deleteCollege = function(id) {
        if (confirm('⚠️ Are you sure you want to delete this college?')) {
            console.log('Deleting college:', id);
            
            // AJAX call to backend
            // $.ajax({
            //     url: '{{ url("admin/college/delete") }}/' + id,
            //     method: 'DELETE',
            //     success: function(response) {
            //         alert('✅ College deleted successfully!');
            //         location.reload();
            //     }
            // });

            alert('✅ College deleted successfully!');
        }
    }

    window.approveCollege = function(id) {
        // Sample colleges list to check for existing names
        const existingColleges = [
            'Government Engineering College',
            'Birla Vishvakarma Mahavidyalaya',
            'Faculty of Technology & Engineering'
        ];

        // Get college name from the row (you can fetch this via AJAX in real implementation)
        const collegeName = $(`tr[data-id="${id}"] td:nth-child(3) strong`).text();
        const universityName = $(`tr[data-id="${id}"] td:nth-child(5) .university-tag`).text();
        
        // Set the college ID and name in the modal
        document.getElementById('approveCollegeId').value = id;
        document.getElementById('approveCollegeName').textContent = collegeName;
        document.getElementById('approveUniversityName').textContent = 'University: ' + universityName;
        
        // Check if college exists
        const collegeExists = existingColleges.some(college => 
            college.toLowerCase() === collegeName.toLowerCase()
        );
        
        if (collegeExists) {
            $('#approveAlertExisting').addClass('show');
        } else {
            $('#approveAlertExisting').removeClass('show');
        }
        
        // Reset form
        document.getElementById('approveCollegeForm').reset();
        document.getElementById('approveCollegeId').value = id;
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('approveCollegeModal'));
        modal.show();

        // AJAX call to check if college exists
        // $.ajax({
        //     url: '{{ url("admin/college/check-exists") }}',
        //     method: 'POST',
        //     data: { college_name: collegeName },
        //     success: function(response) {
        //         if (response.exists) {
        //             $('#approveAlertExisting').addClass('show');
        //         } else {
        //             $('#approveAlertExisting').removeClass('show');
        //         }
        //     }
        // });
    }

    window.confirmApproveCollege = function() {
        const form = document.getElementById('approveCollegeForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const collegeId = document.getElementById('approveCollegeId').value;
        const email = document.getElementById('approveEmail').value;
        const username = document.getElementById('approveUsername').value;
        const password = document.getElementById('approvePassword').value;
        const collegeName = document.getElementById('approveCollegeName').textContent;
        const universityName = document.getElementById('approveUniversityName').textContent;

        console.log('Approving college:', {
            id: collegeId,
            name: collegeName,
            university: universityName,
            email: email,
            username: username,
            password: '***'
        });

        // AJAX call to backend
        // $.ajax({
        //     url: '{{ url("admin/college/approve") }}/' + collegeId,
        //     method: 'POST',
        //     data: {
        //         email: email,
        //         username: username,
        //         password: password,
        //         _token: '{{ csrf_token() }}'
        //     },
        //     success: function(response) {
        //         bootstrap.Modal.getInstance(document.getElementById('approveCollegeModal')).hide();
        //         alert('✅ College approved successfully!');
        //         location.reload();
        //     },
        //     error: function(xhr) {
        //         alert('❌ Error: ' + xhr.responseJSON.message);
        //     }
        // });

        bootstrap.Modal.getInstance(document.getElementById('approveCollegeModal')).hide();
        alert('✅ College approved successfully!\n\nCollege: ' + collegeName + '\nEmail: ' + email + '\nApproved by: ' + username);
        // Move row from rejected/new requests to approved tab
    }

    window.rejectCollege = function(id) {
        // Sample colleges list to check for existing names
        const existingColleges = [
            'Government Engineering College',
            'Birla Vishvakarma Mahavidyalaya',
            'Faculty of Technology & Engineering'
        ];

        // Get college name from the row
        const collegeName = $(`tr[data-id="${id}"] td:nth-child(3) strong`).text();
        const universityName = $(`tr[data-id="${id}"] td:nth-child(5) .university-tag`).text();
        
        // Set the college ID and name in the modal
        document.getElementById('rejectCollegeId').value = id;
        document.getElementById('rejectCollegeName').textContent = collegeName;
        document.getElementById('rejectUniversityName').textContent = 'University: ' + universityName;
        
        // Check if college exists
        const collegeExists = existingColleges.some(college => 
            college.toLowerCase() === collegeName.toLowerCase()
        );
        
        if (collegeExists) {
            $('#rejectAlertExisting').addClass('show');
        } else {
            $('#rejectAlertExisting').removeClass('show');
        }
        
        // Reset form
        document.getElementById('rejectCollegeForm').reset();
        document.getElementById('rejectCollegeId').value = id;
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('rejectCollegeModal'));
        modal.show();

        // AJAX call to check if college exists
        // $.ajax({
        //     url: '{{ url("admin/college/check-exists") }}',
        //     method: 'POST',
        //     data: { college_name: collegeName },
        //     success: function(response) {
        //         if (response.exists) {
        //             $('#rejectAlertExisting').addClass('show');
        //         } else {
        //             $('#rejectAlertExisting').removeClass('show');
        //         }
        //     }
        // });
    }

    window.confirmRejectCollege = function() {
        const form = document.getElementById('rejectCollegeForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const collegeId = document.getElementById('rejectCollegeId').value;
        const email = document.getElementById('rejectEmail').value;
        const username = document.getElementById('rejectUsername').value;
        const password = document.getElementById('rejectPassword').value;
        const reason = document.getElementById('rejectReason').value;
        const collegeName = document.getElementById('rejectCollegeName').textContent;
        const universityName = document.getElementById('rejectUniversityName').textContent;

        console.log('Rejecting college:', {
            id: collegeId,
            name: collegeName,
            university: universityName,
            email: email,
            username: username,
            password: '***',
            reason: reason
        });

        // AJAX call to backend
        // $.ajax({
        //     url: '{{ url("admin/college/reject") }}/' + collegeId,
        //     method: 'POST',
        //     data: {
        //         email: email,
        //         username: username,
        //         password: password,
        //         reason: reason,
        //         _token: '{{ csrf_token() }}'
        //     },
        //     success: function(response) {
        //         bootstrap.Modal.getInstance(document.getElementById('rejectCollegeModal')).hide();
        //         alert('✅ College rejected successfully!');
        //         location.reload();
        //     },
        //     error: function(xhr) {
        //         alert('❌ Error: ' + xhr.responseJSON.message);
        //     }
        // });

        bootstrap.Modal.getInstance(document.getElementById('rejectCollegeModal')).hide();
        alert('✅ College rejected!\n\nCollege: ' + collegeName + '\nEmail: ' + email + '\nReason: ' + reason + '\nRejected by: ' + username);
        // Move row from new requests to rejected tab
    }

    // Auto Generate Password Function
    window.generatePassword = function(type) {
        const length = 12;
        const charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        let password = '';
        
        // Ensure at least one of each type
        password += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.charAt(Math.floor(Math.random() * 26)); // uppercase
        password += 'abcdefghijklmnopqrstuvwxyz'.charAt(Math.floor(Math.random() * 26)); // lowercase
        password += '0123456789'.charAt(Math.floor(Math.random() * 10)); // number
        password += '!@#$%^&*'.charAt(Math.floor(Math.random() * 8)); // special
        
        // Fill the rest
        for (let i = password.length; i < length; i++) {
            password += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        
        // Shuffle the password
        password = password.split('').sort(() => Math.random() - 0.5).join('');
        
        // Set the password in the appropriate field
        if (type === 'approve') {
            document.getElementById('approvePassword').value = password;
        } else if (type === 'reject') {
            document.getElementById('rejectPassword').value = password;
        }
        
        // Show a brief notification
        const btn = event.target.closest('.btn-generate-password');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bx bx-check"></i> Generated!';
        setTimeout(() => {
            btn.innerHTML = originalText;
        }, 2000);
    }
</script>
@endpush
