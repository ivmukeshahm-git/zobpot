@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "University";
</script>

<style>
    /* University Management Page Styles */
    .university-header {
        background: #242a62;
        padding: 25px 30px;
        border-radius: 12px 12px 0 0;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .university-header h5 {
        color: white;
        margin: 0;
        font-size: 24px;
        font-weight: 700;
    }

    .university-header p {
        color: rgba(255, 255, 255, 0.85);
        margin: 5px 0 0 0;
        font-size: 14px;
    }

    .btn-add-university {
        background: #fff;
        color: 242a62;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(245, 87, 108, 0.3);
    }

    .btn-add-university:hover {
         background: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(245, 87, 108, 0.4);
        color: 242a62;
    }

    .table-container {
        background: white;
        padding: 30px;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .table-university {
        margin-top: 20px;
    }

    .table-university thead {
        background: #f8f9fa;
        border-bottom: 2px solid #242a62;
    }

    .table-university thead th {
        color: #242a62;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        padding: 15px 12px;
        border: none;
    }

    .table-university tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #e9ecef;
    }

    .table-university tbody tr:hover {
        background: #f8f9fa;
        transform: scale(1.01);
    }

    .table-university tbody td {
        padding: 15px 12px;
        vertical-align: middle;
        color: #495057;
        font-size: 14px;
    }

    .university-logo {
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
        background: #242a62;
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
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }

    .btn-submit {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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
    .university-tabs-wrapper {
        background: white;
        padding: 20px 30px 0;
    }

    .nav-tabs {
        border-bottom: 2px solid #242a62;
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
        background: #242a62;
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
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
        opacity: 1 !important;
        width: 1em;
        height: 1em;
        border: none;
        padding: 0.25em;
    }

    .modal-header-approve .btn-close:hover,
    .modal-header-reject .btn-close:hover {
        opacity: 0.75 !important;
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

    .university-info-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #667eea;
        margin-bottom: 20px;
    }

    .university-info-box strong {
        color: #2c3e50;
        display: block;
        margin-bottom: 5px;
    }

    .university-info-box .university-name {
        color: #667eea;
        font-size: 18px;
        font-weight: 700;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="card" style="border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
        <div class="university-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5><i class="bx bx-buildings"></i> University Management</h5>
                    <p>Manage universities and their information</p>
                </div>
                <button type="button" class="btn btn-add-university" onclick="openAddUniversityModal()">
                    <i class="bx bx-plus-circle"></i> Add New University
                </button>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="university-tabs-wrapper">
            <ul class="nav nav-tabs" id="universityTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="new-requests-tab" data-bs-toggle="tab" data-bs-target="#new-requests" type="button">
                        <i class="bx bx-time-five"></i> New University Requests
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button">
                        <i class="bx bx-check-circle"></i> Approved Universities
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button">
                        <i class="bx bx-x-circle"></i> Rejected Universities
                    </button>
                </li>
            </ul>
        </div>

        <div class="table-container">
            <div class="tab-content" id="universityTabContent">
                <!-- New University Requests Tab -->
                <div class="tab-pane fade show active" id="new-requests" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-university table-hover" id="newRequestsTable">
                            <thead>
                                <tr>
                                    <th>SR. NO</th>
                                    <th>UNIVERSITY NAME</th>
                                    <th>SUBMITTED DATE</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-id="4">
                                    <td>1</td>
                                    <td><strong>Gujarat Technological University</strong></td>
                                    <td>03 Feb 2024</td>
                                    <td>
                                        <button class="btn btn-approve" onclick="approveUniversity(4)">
                                            <i class="bx bx-check"></i> Approve
                                        </button>
                                        <button class="btn btn-reject" onclick="rejectUniversity(4)">
                                            <i class="bx bx-x"></i> Reject
                                        </button>
                                        <button class="btn btn-action btn-delete" onclick="deleteUniversity(4)">
                                            <i class="bx bx-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr data-id="5">
                                    <td>2</td>
                                    <td><strong>Veer Narmad South Gujarat University</strong></td>
                                    <td>05 Feb 2024</td>
                                    <td>
                                        <button class="btn btn-approve" onclick="approveUniversity(5)">
                                            <i class="bx bx-check"></i> Approve
                                        </button>
                                        <button class="btn btn-reject" onclick="rejectUniversity(5)">
                                            <i class="bx bx-x"></i> Reject
                                        </button>
                                        <button class="btn btn-action btn-delete" onclick="deleteUniversity(5)">
                                            <i class="bx bx-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr data-id="6">
                                    <td>3</td>
                                    <td><strong>Saurashtra University</strong></td>
                                    <td>06 Feb 2024</td>
                                    <td>
                                        <button class="btn btn-approve" onclick="approveUniversity(6)">
                                            <i class="bx bx-check"></i> Approve
                                        </button>
                                        <button class="btn btn-reject" onclick="rejectUniversity(6)">
                                            <i class="bx bx-x"></i> Reject
                                        </button>
                                        <button class="btn btn-action btn-delete" onclick="deleteUniversity(6)">
                                            <i class="bx bx-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Approved Universities Tab -->
                <div class="tab-pane fade" id="approved" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-university table-hover" id="approvedUniversityTable">
                            <thead>
                                <tr>
                                    <th>SR. NO</th>
                                    <th>UNIVERSITY NAME</th>
                                    <th>APPROVED DATE</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-id="1">
                                    <td>1</td>
                                    <td><strong>Gujarat University</strong></td>
                                    <td>15 Jan 2024</td>
                                    <td>
                                        <button class="btn btn-action btn-edit" onclick="editUniversity(1)">
                                            <i class="bx bx-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-action btn-delete" onclick="deleteUniversity(1)">
                                            <i class="bx bx-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr data-id="3">
                                    <td>2</td>
                                    <td><strong>Maharaja Sayajirao University</strong></td>
                                    <td>20 Jan 2024</td>
                                    <td>
                                        <button class="btn btn-action btn-edit" onclick="editUniversity(3)">
                                            <i class="bx bx-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-action btn-delete" onclick="deleteUniversity(3)">
                                            <i class="bx bx-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr data-id="7">
                                    <td>3</td>
                                    <td><strong>Hemchandracharya North Gujarat University</strong></td>
                                    <td>25 Jan 2024</td>
                                    <td>
                                        <button class="btn btn-action btn-edit" onclick="editUniversity(7)">
                                            <i class="bx bx-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-action btn-delete" onclick="deleteUniversity(7)">
                                            <i class="bx bx-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Rejected Universities Tab -->
                <div class="tab-pane fade" id="rejected" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-university table-hover" id="rejectedUniversityTable">
                            <thead>
                                <tr>
                                    <th>SR. NO</th>
                                    <th>UNIVERSITY NAME</th>
                                    <th>REJECTED DATE</th>
                                    <th>REASON</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-id="2">
                                    <td>1</td>
                                    <td><strong>Sardar Patel University</strong></td>
                                    <td>28 Jan 2024</td>
                                    <td><small>Incomplete documentation</small></td>
                                    <td>
                                        <button class="btn btn-approve" onclick="approveUniversity(2)">
                                            <i class="bx bx-check"></i> Approve
                                        </button>
                                        <button class="btn btn-action btn-delete" onclick="deleteUniversity(2)">
                                            <i class="bx bx-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr data-id="8">
                                    <td>2</td>
                                    <td><strong>Krantiguru Shyamji Krishna Verma Kachchh University</strong></td>
                                    <td>30 Jan 2024</td>
                                    <td><small>License verification failed</small></td>
                                    <td>
                                        <button class="btn btn-approve" onclick="approveUniversity(8)">
                                            <i class="bx bx-check"></i> Approve
                                        </button>
                                        <button class="btn btn-action btn-delete" onclick="deleteUniversity(8)">
                                            <i class="bx bx-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr data-id="9">
                                    <td>3</td>
                                    <td><strong>Children's University</strong></td>
                                    <td>02 Feb 2024</td>
                                    <td><small>Does not meet criteria</small></td>
                                    <td>
                                        <button class="btn btn-approve" onclick="approveUniversity(9)">
                                            <i class="bx bx-check"></i> Approve
                                        </button>
                                        <button class="btn btn-action btn-delete" onclick="deleteUniversity(9)">
                                            <i class="bx bx-trash"></i> Delete
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

<!-- Add University Modal -->
<div class="modal fade" id="addUniversityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title" style="color: #fff;"><i class="bx bx-plus-circle"></i> Add New University</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
                <form id="addUniversityForm">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">University Name <span class="required">*</span></label>
                            <input type="text" class="form-control" id="addUniversityName" placeholder="Enter university name" required>
                        </div>
                        <div class="col-md-12 mb-3">
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
                <button type="button" class="btn btn-submit" onclick="saveUniversity()">
                    <i class="bx bx-save"></i> Save University
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Approve University Modal -->
<div class="modal fade" id="approveUniversityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header modal-header-approve">
                <h5 class="modal-title" style="color:#fff;"><i class="bx bx-check-circle"></i> Approve University</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <!-- Alert for existing university -->
                <div class="alert-modal alert-warning" id="approveAlertExisting">
                    <i class="bx bx-error-circle"></i> 
                    <div style="display: inline-block; vertical-align: middle;">
                        <strong>Warning!</strong> A university with the same name already exists in the system.
                        <div style="font-size: 12px; margin-top: 3px; opacity: 0.9;">Please verify this is a different university before approving.</div>
                    </div>
                </div>

                <!-- University Information -->
                <div class="university-info-box">
                    <strong>University Name:</strong>
                    <span class="university-name" id="approveUniversityName">University Name Here</span>
                </div>

                <form id="approveUniversityForm">
                    <input type="hidden" id="approveUniversityId" value="">
                    
                    <div class="alert alert-info" role="alert" style="font-size: 13px;">
                        <i class="bx bx-info-circle"></i> Are you sure you want to approve this university?
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn btn-approve" onclick="confirmApproveUniversity()">
                    <i class="bx bx-check"></i> Approve University
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reject University Modal -->
<div class="modal fade" id="rejectUniversityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; ">
            <div class="modal-header modal-header-reject">
                <h5 class="modal-title" style="color: #fff;"><i class="bx bx-x-circle"></i> Reject University</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <!-- Alert for existing university -->
                <div class="alert-modal alert-danger" id="rejectAlertExisting">
                    <i class="bx bx-error-circle"></i> 
                    <div style="display: inline-block; vertical-align: middle;">
                        <strong>Alert!</strong> University already exists in the system.
                        <div style="font-size: 12px; margin-top: 3px; opacity: 0.9;">Do not approve this university. Consider rejecting with appropriate reason.</div>
                    </div>
                </div>

                <!-- University Information -->
                <div class="university-info-box" style="border-left-color: #dc3545;">
                    <strong>University Name:</strong>
                    <span class="university-name" style="color: #dc3545;" id="rejectUniversityName">University Name Here</span>
                </div>

                <form id="rejectUniversityForm">
                    <input type="hidden" id="rejectUniversityId" value="">
                    
                    <div class="mb-3">
                        <label class="form-label">Rejection Reason <span class="required">*</span></label>
                        <textarea class="form-control" id="rejectReason" rows="3" placeholder="Enter reason for rejection..." required></textarea>
                    </div>

                    <div class="alert alert-warning" role="alert" style="font-size: 13px;">
                        <i class="bx bx-error-circle"></i> Please provide a reason for rejecting this university.
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn btn-reject" onclick="confirmRejectUniversity()">
                    <i class="bx bx-x-circle"></i> Reject University
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
        $('#newRequestsTable').DataTable({
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search new requests..."
            }
        });

        $('#approvedUniversityTable').DataTable({
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search approved universities..."
            }
        });

        $('#rejectedUniversityTable').DataTable({
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search rejected universities..."
            }
        });
    });

    window.openAddUniversityModal = function() {
        document.getElementById('addUniversityForm').reset();
        const modal = new bootstrap.Modal(document.getElementById('addUniversityModal'));
        modal.show();
    }

    window.saveUniversity = function() {
        const form = document.getElementById('addUniversityForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const universityName = document.getElementById('addUniversityName').value;

        console.log('Saving university:', { name: universityName });

        // AJAX call to backend
        // $.ajax({
        //     url: '{{ route("admin.university.store") }}',
        //     method: 'POST',
        //     data: {
        //         name: universityName,
        //         _token: '{{ csrf_token() }}'
        //     },
        //     success: function(response) {
        //         bootstrap.Modal.getInstance(document.getElementById('addUniversityModal')).hide();
        //         alert('✅ University added successfully!');
        //         location.reload();
        //     }
        // });

        bootstrap.Modal.getInstance(document.getElementById('addUniversityModal')).hide();
        alert('✅ University added successfully!');
    }

    window.editUniversity = function(id) {
        alert('Edit university: ' + id);
    }

    window.viewUniversity = function(id) {
        alert('View university: ' + id);
    }

    window.deleteUniversity = function(id) {
        if (confirm('⚠️ Are you sure you want to delete this university?')) {
            console.log('Deleting university:', id);
            
            // AJAX call to backend
            // $.ajax({
            //     url: '{{ url("admin/university/delete") }}/' + id,
            //     method: 'DELETE',
            //     success: function(response) {
            //         alert('✅ University deleted successfully!');
            //         location.reload();
            //     }
            // });

            alert('✅ University deleted successfully!');
        }
    }

    window.approveUniversity = function(id) {
        // Sample universities list to check for existing names
        const existingUniversities = [
            'Gujarat University',
            'Maharaja Sayajirao University',
            'Sardar Patel University'
        ];

        // Get university name from the row
        const universityName = $(`tr[data-id="${id}"] td:nth-child(2) strong`).text();
        
        // Set the university ID and name in the modal
        document.getElementById('approveUniversityId').value = id;
        document.getElementById('approveUniversityName').textContent = universityName;
        
        // Check if university exists
        const universityExists = existingUniversities.some(university => 
            university.toLowerCase() === universityName.toLowerCase()
        );
        
        if (universityExists) {
            $('#approveAlertExisting').addClass('show');
        } else {
            $('#approveAlertExisting').removeClass('show');
        }
        
        // Reset form
        document.getElementById('approveUniversityForm').reset();
        document.getElementById('approveUniversityId').value = id;
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('approveUniversityModal'));
        modal.show();

        // AJAX call to check if university exists
        // $.ajax({
        //     url: '{{ url("admin/university/check-exists") }}',
        //     method: 'POST',
        //     data: { university_name: universityName },
        //     success: function(response) {
        //         if (response.exists) {
        //             $('#approveAlertExisting').addClass('show');
        //         } else {
        //             $('#approveAlertExisting').removeClass('show');
        //         }
        //     }
        // });
    }

    window.confirmApproveUniversity = function() {
        const universityId = document.getElementById('approveUniversityId').value;
        const universityName = document.getElementById('approveUniversityName').textContent;

        console.log('Approving university:', {
            id: universityId,
            name: universityName
        });

        // AJAX call to backend
        // $.ajax({
        //     url: '{{ url("admin/university/approve") }}/' + universityId,
        //     method: 'POST',
        //     data: {
        //         _token: '{{ csrf_token() }}'
        //     },
        //     success: function(response) {
        //         bootstrap.Modal.getInstance(document.getElementById('approveUniversityModal')).hide();
        //         alert('✅ University approved successfully!');
        //         location.reload();
        //     },
        //     error: function(xhr) {
        //         alert('❌ Error: ' + xhr.responseJSON.message);
        //     }
        // });

        bootstrap.Modal.getInstance(document.getElementById('approveUniversityModal')).hide();
        alert('✅ University approved successfully!\n\nUniversity: ' + universityName);
    }

    window.rejectUniversity = function(id) {
        // Sample universities list to check for existing names
        const existingUniversities = [
            'Gujarat University',
            'Maharaja Sayajirao University',
            'Sardar Patel University'
        ];

        // Get university name from the row
        const universityName = $(`tr[data-id="${id}"] td:nth-child(2) strong`).text();
        
        // Set the university ID and name in the modal
        document.getElementById('rejectUniversityId').value = id;
        document.getElementById('rejectUniversityName').textContent = universityName;
        
        // Check if university exists
        const universityExists = existingUniversities.some(university => 
            university.toLowerCase() === universityName.toLowerCase()
        );
        
        if (universityExists) {
            $('#rejectAlertExisting').addClass('show');
        } else {
            $('#rejectAlertExisting').removeClass('show');
        }
        
        // Reset form
        document.getElementById('rejectUniversityForm').reset();
        document.getElementById('rejectUniversityId').value = id;
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('rejectUniversityModal'));
        modal.show();

        // AJAX call to check if university exists
        // $.ajax({
        //     url: '{{ url("admin/university/check-exists") }}',
        //     method: 'POST',
        //     data: { university_name: universityName },
        //     success: function(response) {
        //         if (response.exists) {
        //             $('#rejectAlertExisting').addClass('show');
        //         } else {
        //             $('#rejectAlertExisting').removeClass('show');
        //         }
        //     }
        // });
    }

    window.confirmRejectUniversity = function() {
        const form = document.getElementById('rejectUniversityForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const universityId = document.getElementById('rejectUniversityId').value;
        const reason = document.getElementById('rejectReason').value;
        const universityName = document.getElementById('rejectUniversityName').textContent;

        console.log('Rejecting university:', {
            id: universityId,
            name: universityName,
            reason: reason
        });

        // AJAX call to backend
        // $.ajax({
        //     url: '{{ url("admin/university/reject") }}/' + universityId,
        //     method: 'POST',
        //     data: {
        //         reason: reason,
        //         _token: '{{ csrf_token() }}'
        //     },
        //     success: function(response) {
        //         bootstrap.Modal.getInstance(document.getElementById('rejectUniversityModal')).hide();
        //         alert('✅ University rejected successfully!');
        //         location.reload();
        //     },
        //     error: function(xhr) {
        //         alert('❌ Error: ' + xhr.responseJSON.message);
        //     }
        // });

        bootstrap.Modal.getInstance(document.getElementById('rejectUniversityModal')).hide();
        alert('✅ University rejected!\n\nUniversity: ' + universityName + '\nReason: ' + reason);
    }
</script>
@endpush
