@extends('admin.layout.layout')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                @can('University-Add')
                <button type="button" class="btn btn-add-university" onclick="openAddUniversityModal()">
                    <i class="bx bx-plus-circle"></i> Add New University
                </button>
                @endcan
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
                <button type="button" class="btn btn-submit" onclick="saveUniversity()">
                    <i class="bx bx-save"></i> Save University
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Approve University Modal -->
<div class="modal fade" id="approveUniversityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header modal-header-approve">
                <h5 class="modal-title" id="approveModalTitle" style="color:#fff;"><i class="bx bx-check-circle"></i> Approve University</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">

                <!-- Toggle Button -->
                <div class="text-end mb-3">
                    <button type="button" class="btn btn-sm" id="btnToggleReplace" onclick="toggleReplaceSection()" style="background:linear-gradient(135deg, #17a2b8 0%, #138496 100%); color:#fff; padding:6px 16px; border-radius:6px; font-weight:600; font-size:13px; border:none;">
                        <i class="bx bx-transfer"></i> Replace University
                    </button>
                </div>

                <!-- ===== SECTION 1: Normal Approve ===== -->
                <div id="approveNormalSection">
                    <!-- Alert for existing university -->
                    <div class="alert-modal alert-warning" id="approveAlertExisting" style="display:none;">
                        <i class="bx bx-error-circle"></i> 
                        <div style="display: inline-block; vertical-align: middle;">
                            <strong>Warning!</strong> A university with the same name already exists in the approved list.
                            <div style="font-size: 12px; margin-top: 3px; opacity: 0.9;">Please verify this is a different university before approving.</div>
                        </div>
                    </div>

                    <!-- University Information -->
                    <div class="university-info-box">
                        <strong>University Name:</strong>
                        <span class="university-name" id="approveUniversityName">University Name Here</span>
                    </div>

                    <!-- Colleges under this university -->
                    <div id="approveCollegesSection" style="display:none;">
                        <div style="background: #f0f4ff; padding: 15px; border-radius: 8px; border-left: 4px solid #17a2b8; margin-bottom: 15px;">
                            <strong style="color: #2c3e50; font-size: 14px;"><i class="bx bx-building-house"></i> Colleges under this University</strong>
                            <p style="font-size: 12px; color: #6c757d; margin: 5px 0 0;">Approved colleges are shown in green. Select pending/rejected colleges to approve them along with the university.</p>
                        </div>
                        <div id="approveCollegesList"></div>
                    </div>

                    <form id="approveUniversityForm">
                        <input type="hidden" id="approveUniversityId" value="">
                    </form>
                </div>

                <!-- ===== SECTION 2: Replace University ===== -->
                <div id="replaceUniversitySection" style="display:none;">
                    <div class="alert-modal alert-info" style="background: linear-gradient(135deg, #e8f4fd 0%, #d1ecf1 100%); color: #0c5460; border: 2px solid #17a2b8; box-shadow: 0 4px 12px rgba(23,162,184,0.2); padding: 15px 20px; border-radius: 8px; margin-bottom: 20px;">
                        <i class="bx bx-transfer" style="font-size:20px; margin-right:8px; vertical-align:middle;"></i>
                        <div style="display: inline-block; vertical-align: middle;">
                            <strong>Replace University</strong>
                            <div style="font-size: 12px; margin-top: 3px;">Colleges will be moved to the selected university. The current university will be removed.</div>
                        </div>
                    </div>

                    <!-- Current University -->
                    <div class="mb-3">
                        <label class="form-label"><i class="bx bx-buildings" style="color:#dc3545;"></i> Current University</label>
                        <input type="text" class="form-control" id="replaceCurrentName" readonly style="background:#f8d7da; border:2px solid #f5c6cb; border-radius:8px; padding:10px 14px; font-weight:600; color:#721c24;">
                    </div>

                    <!-- Replace With -->
                    <div class="mb-3">
                        <label class="form-label"><i class="bx bx-transfer-alt" style="color:#28a745;"></i> Replace With <span class="required">*</span></label>
                        <select class="form-select" id="replaceWithUniversity" style="border:2px solid #e0e0e0; border-radius:8px; padding:10px 14px;" required>
                            <option value="">Select University</option>
                        </select>
                    </div>

                    <!-- Colleges to transfer -->
                    <div id="replaceCollegesSection" style="display:none;">
                        <div style="background: #f0f4ff; padding: 15px; border-radius: 8px; border-left: 4px solid #667eea; margin-bottom: 15px;">
                            <strong style="color: #2c3e50; font-size: 14px;"><i class="bx bx-building-house"></i> Colleges to Transfer</strong>
                            <p style="font-size: 12px; color: #6c757d; margin: 5px 0 0;">These colleges will be moved to the selected university. Check the ones you want to approve.</p>
                        </div>
                        <div id="replaceCollegesList"></div>
                    </div>
                </div>

            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn btn-approve" id="btnApprove" onclick="handleApproveAction()">
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var newRequestsTable, approvedTable, rejectedTable;

    $(document).ready(function() {
        // Pending requests (status=0)
        newRequestsTable = $('#newRequestsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.university.data') }}",
                data: { status: 0 }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'university_name', name: 'university_name', render: function(data) { return '<strong>' + $('<span>').text(data).html() + '</strong>'; } },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search new requests..."
            }
        });

        // Approved universities (status=1)
        approvedTable = $('#approvedUniversityTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.university.data') }}",
                data: { status: 1 }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'university_name', name: 'university_name', render: function(data) { return '<strong>' + $('<span>').text(data).html() + '</strong>'; } },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search approved universities..."
            }
        });

        // Rejected universities (status=2)
        rejectedTable = $('#rejectedUniversityTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.university.data') }}",
                data: { status: 2 }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'university_name', name: 'university_name', render: function(data) { return '<strong>' + $('<span>').text(data).html() + '</strong>'; } },
                { data: 'created_at', name: 'created_at' },
                { data: 'reject_reason', name: 'reject_reason', render: function(data) { return '<small>' + $('<span>').text(data).html() + '</small>'; } },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search rejected universities..."
            }
        });
    });

    function reloadAllTables() {
        newRequestsTable.ajax.reload(null, false);
        approvedTable.ajax.reload(null, false);
        rejectedTable.ajax.reload(null, false);
    }

    // ========== Add University ==========
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

        var universityName = $('#addUniversityName').val();
        var status = $('#addStatus').val();

        $.ajax({
            url: "{{ route('admin.university.store') }}",
            method: 'POST',
            data: {
                university_name: universityName,
                status: status
            },
            success: function(response) {
                bootstrap.Modal.getInstance(document.getElementById('addUniversityModal')).hide();
                alert('University added successfully!');
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

    // ========== Edit University ==========
    window.editUniversity = function(id) {
        $.ajax({
            url: "{{ url('admin/university') }}/" + id + "/edit",
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#addUniversityName').val(response.data.university_name);
                    $('#addStatus').val(response.data.status);

                    // Change modal title and button for editing
                    $('#addUniversityModal .modal-title').html('<i class="bx bx-edit"></i> Edit University');
                    $('#addUniversityModal .btn-submit').attr('onclick', 'updateUniversity(' + id + ')').html('<i class="bx bx-save"></i> Update University');

                    var modal = new bootstrap.Modal(document.getElementById('addUniversityModal'));
                    modal.show();
                }
            }
        });
    }

    window.updateUniversity = function(id) {
        var form = document.getElementById('addUniversityForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        $.ajax({
            url: "{{ url('admin/university') }}/" + id,
            method: 'PUT',
            data: {
                university_name: $('#addUniversityName').val()
            },
            success: function(response) {
                bootstrap.Modal.getInstance(document.getElementById('addUniversityModal')).hide();
                // Reset modal title and button
                $('#addUniversityModal .modal-title').html('<i class="bx bx-plus-circle"></i> Add New University');
                $('#addUniversityModal .btn-submit').attr('onclick', 'saveUniversity()').html('<i class="bx bx-save"></i> Save University');
                alert('University updated successfully!');
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

    // Reset modal on close
    $('#addUniversityModal').on('hidden.bs.modal', function () {
        $('#addUniversityModal .modal-title').html('<i class="bx bx-plus-circle"></i> Add New University');
        $('#addUniversityModal .btn-submit').attr('onclick', 'saveUniversity()').html('<i class="bx bx-save"></i> Save University');
        document.getElementById('addUniversityForm').reset();
    });

    // ========== Delete University ==========
    window.deleteUniversity = function(id) {
        if (confirm('Are you sure you want to delete this university?')) {
            $.ajax({
                url: "{{ url('admin/university') }}/" + id,
                method: 'DELETE',
                success: function(response) {
                    alert('University deleted successfully!');
                    reloadAllTables();
                },
                error: function(xhr) {
                    alert('Error: Something went wrong!');
                }
            });
        }
    }

    // ========== Approve University ==========
    window.approveUniversity = function(id, name) {
        document.getElementById('approveUniversityId').value = id;
        document.getElementById('approveUniversityName').textContent = name;
        $('#approveCollegesSection').hide();
        $('#approveCollegesList').html('');
        currentApproveColleges = [];

        // Check if university name already exists + fetch colleges
        $.ajax({
            url: "{{ route('admin.university.checkExists') }}",
            method: 'POST',
            data: { university_name: name, university_id: id },
            success: function(response) {
                if (response.exists) {
                    $('#approveAlertExisting').show();
                } else {
                    $('#approveAlertExisting').hide();
                }

                // Show colleges section
                if (response.colleges && response.colleges.length > 0) {
                    currentApproveColleges = response.colleges;
                    var html = '';
                    response.colleges.forEach(function(college) {
                        var statusLabel = '';
                        var isDisabled = '';
                        var isChecked = '';

                        if (college.status == 1) {
                            statusLabel = '<span class="status-badge status-approved" style="font-size:11px; padding:3px 10px;">Approved</span>';
                            isDisabled = 'disabled';
                            isChecked = 'checked';
                        } else if (college.status == 2) {
                            statusLabel = '<span class="status-badge status-rejected" style="font-size:11px; padding:3px 10px;">Rejected</span>';
                            isChecked = 'checked';
                        } else {
                            statusLabel = '<span class="status-badge status-pending" style="font-size:11px; padding:3px 10px;">Pending</span>';
                            isChecked = 'checked';
                        }

                        html += '<div style="display:flex; align-items:center; gap:10px; padding:10px 12px; margin-bottom:6px; background:#fff; border:1px solid #e9ecef; border-radius:8px;">';
                        html += '<input type="checkbox" class="form-check-input approve-college-check" value="' + college.id + '" ' + isChecked + ' ' + isDisabled + ' style="width:18px; height:18px;">';
                        html += '<span style="flex:1; font-size:14px; color:#2c3e50;">' + $('<span>').text(college.college_name).html() + '</span>';
                        html += statusLabel;
                        html += '</div>';
                    });
                    $('#approveCollegesList').html(html);
                    $('#approveCollegesSection').show();
                } else {
                    $('#approveCollegesSection').hide();
                }
            }
        });

        var modal = new bootstrap.Modal(document.getElementById('approveUniversityModal'));
        modal.show();
    }

    window.confirmApproveUniversity = function() {
        var universityId = document.getElementById('approveUniversityId').value;

        // Collect checked college IDs (exclude already approved/disabled ones)
        var collegeIds = [];
        $('.approve-college-check:checked:not(:disabled)').each(function() {
            collegeIds.push($(this).val());
        });

        $.ajax({
            url: "{{ url('admin/university') }}/" + universityId + "/approve",
            method: 'POST',
            data: { college_ids: collegeIds },
            success: function(response) {
                bootstrap.Modal.getInstance(document.getElementById('approveUniversityModal')).hide();
                alert('University approved successfully!');
                reloadAllTables();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong!'));
            }
        });
    }

    // ========== Replace University ==========
    // Store colleges data for replace section
    var currentApproveColleges = [];

    var isReplaceMode = false;

    window.toggleReplaceSection = function() {
        if (isReplaceMode) {
            showApproveSection();
        } else {
            showReplaceSection();
        }
    }

    window.handleApproveAction = function() {
        if (isReplaceMode) {
            confirmReplaceUniversity();
        } else {
            confirmApproveUniversity();
        }
    }

    window.showReplaceSection = function() {
        isReplaceMode = true;
        var universityName = document.getElementById('approveUniversityName').textContent;
        $('#replaceCurrentName').val(universityName);

        // Hide approve section, show replace section
        $('#approveNormalSection').hide();
        $('#replaceUniversitySection').show();

        // Update toggle button text
        $('#btnToggleReplace').html('<i class="bx bx-arrow-back"></i> Back to Approve');

        // Update modal title
        $('#approveModalTitle').html('<i class="bx bx-transfer"></i> Replace University');

        // Update footer button text
        $('#btnApprove').html('<i class="bx bx-check"></i> Confirm Replace');

        // Load approved universities list
        $.get("{{ route('admin.university.all') }}", function(response) {
            var universityId = document.getElementById('approveUniversityId').value;
            var html = '<option value="">Select University</option>';
            if (response.data) {
                response.data.forEach(function(uni) {
                    if (uni.id != universityId) {
                        html += '<option value="' + uni.id + '">' + $('<span>').text(uni.university_name).html() + '</option>';
                    }
                });
            }
            $('#replaceWithUniversity').html(html);
        });

        // Show colleges with checkboxes for approve
        if (currentApproveColleges.length > 0) {
            var html = '';
            currentApproveColleges.forEach(function(college) {
                var statusLabel = '';
                var isDisabled = '';
                var isChecked = '';

                if (college.status == 1) {
                    statusLabel = '<span class="status-badge status-approved" style="font-size:11px; padding:3px 10px;">Approved</span>';
                    isDisabled = 'disabled';
                    isChecked = 'checked';
                } else if (college.status == 2) {
                    statusLabel = '<span class="status-badge status-rejected" style="font-size:11px; padding:3px 10px;">Rejected</span>';
                    isChecked = 'checked';
                } else {
                    statusLabel = '<span class="status-badge status-pending" style="font-size:11px; padding:3px 10px;">Pending</span>';
                    isChecked = 'checked';
                }

                html += '<div style="display:flex; align-items:center; gap:10px; padding:10px 12px; margin-bottom:6px; background:#fff; border:1px solid #e9ecef; border-radius:8px;">';
                html += '<input type="checkbox" class="form-check-input replace-college-check" value="' + college.id + '" ' + isChecked + ' ' + isDisabled + ' style="width:18px; height:18px;">';
                html += '<span style="flex:1; font-size:14px; color:#2c3e50;">' + $('<span>').text(college.college_name).html() + '</span>';
                html += statusLabel;
                html += '</div>';
            });
            $('#replaceCollegesList').html(html);
            $('#replaceCollegesSection').show();
        } else {
            $('#replaceCollegesSection').hide();
        }
    }

    window.showApproveSection = function() {
        isReplaceMode = false;

        // Show approve section, hide replace section
        $('#approveNormalSection').show();
        $('#replaceUniversitySection').hide();

        // Update toggle button text
        $('#btnToggleReplace').html('<i class="bx bx-transfer"></i> Replace University');

        // Reset modal title
        $('#approveModalTitle').html('<i class="bx bx-check-circle"></i> Approve University');

        // Reset footer button text
        $('#btnApprove').html('<i class="bx bx-check"></i> Approve University');
    }

    window.confirmReplaceUniversity = function() {
        var universityId = document.getElementById('approveUniversityId').value;
        var replaceWithId = $('#replaceWithUniversity').val();

        if (!replaceWithId) {
            $('#replaceWithUniversity').focus();
            alert('Please select a university to replace with.');
            return;
        }

        // Collect checked college IDs for approve
        var collegeIds = [];
        $('.replace-college-check:checked:not(:disabled)').each(function() {
            collegeIds.push($(this).val());
        });

        $.ajax({
            url: "{{ url('admin/university') }}/" + universityId + "/replace",
            method: 'POST',
            data: {
                replace_with_id: replaceWithId,
                college_ids: collegeIds
            },
            success: function(response) {
                bootstrap.Modal.getInstance(document.getElementById('approveUniversityModal')).hide();
                showApproveSection(); // Reset view
                alert('University replaced and colleges transferred successfully!');
                reloadAllTables();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong!'));
            }
        });
    }

    // Reset modal on close
    $('#approveUniversityModal').on('hidden.bs.modal', function () {
        showApproveSection();
    });

    // ========== Reject University ==========
    window.rejectUniversity = function(id, name) {
        document.getElementById('rejectUniversityId').value = id;
        document.getElementById('rejectUniversityName').textContent = name;
        document.getElementById('rejectReason').value = '';

        // Check if university name already exists in approved list
        $.ajax({
            url: "{{ route('admin.university.checkExists') }}",
            method: 'POST',
            data: { university_name: name, university_id: id },
            success: function(response) {
                if (response.exists) {
                    $('#rejectAlertExisting').show();
                } else {
                    $('#rejectAlertExisting').hide();
                }
            }
        });

        var modal = new bootstrap.Modal(document.getElementById('rejectUniversityModal'));
        modal.show();
    }

    window.confirmRejectUniversity = function() {
        var form = document.getElementById('rejectUniversityForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        var universityId = document.getElementById('rejectUniversityId').value;
        var reason = document.getElementById('rejectReason').value;

        $.ajax({
            url: "{{ url('admin/university') }}/" + universityId + "/reject",
            method: 'POST',
            data: {
                reject_reason: reason
            },
            success: function(response) {
                bootstrap.Modal.getInstance(document.getElementById('rejectUniversityModal')).hide();
                alert('University rejected successfully!');
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
</script>
@endpush
    