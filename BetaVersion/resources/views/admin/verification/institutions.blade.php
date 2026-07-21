@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "VerifyInstitutions";
</script>

<style>
    /* Verification Page Styles */
    .verification-header {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(67, 233, 123, 0.3);
    }

   .verification-header h5 {
        color: white;
        margin: 0 0 8px 0;
        font-size: 28px;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .verification-header p {
        color: rgba(255, 255, 255, 0.9);
        margin: 0;
        font-size: 15px;
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border-left: 4px solid;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
    }

    .stat-card.pending {
        border-left-color: #ffc107;
    }

    .stat-card.approved {
        border-left-color: #28a745;
    }

    .stat-card.rejected {
        border-left-color: #dc3545;
    }

    .stat-card .stat-icon {
        font-size: 32px;
        margin-bottom: 10px;
    }

    .stat-card.pending .stat-icon {
        color: #ffc107;
    }

    .stat-card.approved .stat-icon {
        color: #28a745;
    }

    .stat-card.rejected .stat-icon {
        color: #dc3545;
    }

    .stat-card .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin: 5px 0;
    }

    .stat-card .stat-label {
        font-size: 13px;
        color: #7f8c8d;
        text-transform: uppercase;
        font-weight: 600;
    }

    .verification-tabs {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .table-verification {
        margin-top: 20px;
    }

    .table-verification thead {
        background: #f8f9fa;
        border-bottom: 2px solid #43e97b;
    }

    .table-verification thead th {
        color: #2c3e50;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        padding: 15px 12px;
        border: none;
    }

    .table-verification tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #e9ecef;
    }

    .table-verification tbody tr:hover {
        background: #f8f9fa;
    }

    .table-verification tbody td {
        padding: 15px 12px;
        vertical-align: middle;
        font-size: 14px;
    }

    .institution-logo {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
        border: 3px solid #e9ecef;
    }

    .institution-info h6 {
        margin: 0 0 5px 0;
        font-size: 15px;
        font-weight: 700;
        color: #2c3e50;
    }

    .institution-info .code {
        font-size: 12px;
        color: #6c757d;
        font-weight: 600;
    }

    .type-badge {
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .type-university {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .type-college {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .btn-approve {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border: none;
        padding: 8px 18px;
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
        padding: 8px 18px;
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

    .btn-view-details {
        background: #6f42c1;
        color: white;
        border: none;
        padding: 8px 18px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        margin: 0 3px;
    }

    .btn-view-details:hover {
        background: #5a32a3;
        transform: translateY(-2px);
        color: white;
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

    /* Modal Styles */
    .modal-header-approve {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 20px 30px;
        border: none;
    }

    .modal-header-reject {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
    }

    .detail-row {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .detail-label {
        font-weight: 700;
        color: #495057;
        width: 160px;
        flex-shrink: 0;
    }

    .detail-value {
        color: #6c757d;
        flex: 1;
    }

    .verification-note {
        background: #f8f9fa;
        border-left: 4px solid #43e97b;
        padding: 15px;
        border-radius: 6px;
        margin: 15px 0;
    }

    .verification-note strong {
        color: #2c3e50;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="verification-header">
        <h5><i class="bx bx-check-shield"></i> Institution Verification & Approval</h5>
        <p>Review and approve pending universities and colleges</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card pending">
            <div class="stat-icon"><i class="bx bx-time-five"></i></div>
            <div class="stat-number">8</div>
            <div class="stat-label">Pending Verification</div>
        </div>
        <div class="stat-card approved">
            <div class="stat-icon"><i class="bx bx-check-circle"></i></div>
            <div class="stat-number">45</div>
            <div class="stat-label">Approved</div>
        </div>
        <div class="stat-card rejected">
            <div class="stat-icon"><i class="bx bx-x-circle"></i></div>
            <div class="stat-number">3</div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>

    <!-- Verification Tabs -->
    <div class="verification-tabs">
        <ul class="nav nav-tabs" id="verificationTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button">
                    <i class="bx bx-time-five"></i> Pending Verification (8)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button">
                    <i class="bx bx-check-circle"></i> Approved (45)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button">
                    <i class="bx bx-x-circle"></i> Rejected (3)
                </button>
            </li>
        </ul>

        <div class="tab-content" id="verificationTabContent">
            <!-- Pending Tab -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-verification table-hover" id="pendingTable">
                        <thead>
                            <tr>
                                <th>SR. NO</th>
                                <th>TYPE</th>
                                <th>LOGO</th>
                                <th>INSTITUTION</th>
                                <th>LOCATION</th>
                                <th>CONTACT</th>
                                <th>SUBMITTED DATE</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-id="1" data-type="university">
                                <td>1</td>
                                <td><span class="type-badge type-university">University</span></td>
                                <td><img src="https://via.placeholder.com/60" alt="Logo" class="institution-logo"></td>
                                <td>
                                    <div class="institution-info">
                                        <h6>Sardar Patel University</h6>
                                        <span class="code">SPU-002</span>
                                    </div>
                                </td>
                                <td>Vallabh Vidyanagar, Gujarat</td>
                                <td>
                                    <div style="font-size: 13px;">
                                        <div><i class="bx bx-phone"></i> +91 2692 226801</div>
                                        <div><i class="bx bx-envelope"></i> info@spuvvn.edu</div>
                                    </div>
                                </td>
                                <td>15 Jan 2024</td>
                                <td>
                                    <button class="btn btn-view-details" onclick="viewDetails(1, 'university')">
                                        <i class="bx bx-show"></i> View
                                    </button>
                                    <button class="btn btn-approve" onclick="showApproveModal(1, 'university', 'Sardar Patel University')">
                                        <i class="bx bx-check"></i> Approve
                                    </button>
                                    <button class="btn btn-reject" onclick="showRejectModal(1, 'university', 'Sardar Patel University')">
                                        <i class="bx bx-x"></i> Reject
                                    </button>
                                </td>
                            </tr>
                            <tr data-id="2" data-type="college">
                                <td>2</td>
                                <td><span class="type-badge type-college">College</span></td>
                                <td><img src="https://via.placeholder.com/60" alt="Logo" class="institution-logo"></td>
                                <td>
                                    <div class="institution-info">
                                        <h6>L.D. College of Engineering</h6>
                                        <span class="code">LDCE-AHM-002</span>
                                    </div>
                                </td>
                                <td>Ahmedabad, Gujarat</td>
                                <td>
                                    <div style="font-size: 13px;">
                                        <div><i class="bx bx-phone"></i> +91 79 2687 5950</div>
                                        <div><i class="bx bx-envelope"></i> principal@ldce.ac.in</div>
                                    </div>
                                </td>
                                <td>18 Jan 2024</td>
                                <td>
                                    <button class="btn btn-view-details" onclick="viewDetails(2, 'college')">
                                        <i class="bx bx-show"></i> View
                                    </button>
                                    <button class="btn btn-approve" onclick="showApproveModal(2, 'college', 'L.D. College of Engineering')">
                                        <i class="bx bx-check"></i> Approve
                                    </button>
                                    <button class="btn btn-reject" onclick="showRejectModal(2, 'college', 'L.D. College of Engineering')">
                                        <i class="bx bx-x"></i> Reject
                                    </button>
                                </td>
                            </tr>
                            <tr data-id="3" data-type="university">
                                <td>3</td>
                                <td><span class="type-badge type-university">University</span></td>
                                <td><img src="https://via.placeholder.com/60" alt="Logo" class="institution-logo"></td>
                                <td>
                                    <div class="institution-info">
                                        <h6>Ganpat University</h6>
                                        <span class="code">GPU-003</span>
                                    </div>
                                </td>
                                <td>Mehsana, Gujarat</td>
                                <td>
                                    <div style="font-size: 13px;">
                                        <div><i class="bx bx-phone"></i> +91 2763 286080</div>
                                        <div><i class="bx bx-envelope"></i> info@ganpatuniversity.ac.in</div>
                                    </div>
                                </td>
                                <td>20 Jan 2024</td>
                                <td>
                                    <button class="btn btn-view-details" onclick="viewDetails(3, 'university')">
                                        <i class="bx bx-show"></i> View
                                    </button>
                                    <button class="btn btn-approve" onclick="showApproveModal(3, 'university', 'Ganpat University')">
                                        <i class="bx bx-check"></i> Approve
                                    </button>
                                    <button class="btn btn-reject" onclick="showRejectModal(3, 'university', 'Ganpat University')">
                                        <i class="bx bx-x"></i> Reject
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Approved Tab -->
            <div class="tab-pane fade" id="approved" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-verification table-hover" id="approvedTable">
                        <thead>
                            <tr>
                                <th>SR. NO</th>
                                <th>TYPE</th>
                                <th>LOGO</th>
                                <th>INSTITUTION</th>
                                <th>LOCATION</th>
                                <th>APPROVED DATE</th>
                                <th>APPROVED BY</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><span class="type-badge type-university">University</span></td>
                                <td><img src="https://via.placeholder.com/60" alt="Logo" class="institution-logo"></td>
                                <td>
                                    <div class="institution-info">
                                        <h6>Gujarat University</h6>
                                        <span class="code">GU-001</span>
                                    </div>
                                </td>
                                <td>Ahmedabad, Gujarat</td>
                                <td>10 Dec 2023</td>
                                <td>Admin User</td>
                                <td>
                                    <button class="btn btn-view-details" onclick="viewDetails(1, 'university')">
                                        <i class="bx bx-show"></i> View Details
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><span class="type-badge type-college">College</span></td>
                                <td><img src="https://via.placeholder.com/60" alt="Logo" class="institution-logo"></td>
                                <td>
                                    <div class="institution-info">
                                        <h6>Government Engineering College</h6>
                                        <span class="code">GEC-AHM-001</span>
                                    </div>
                                </td>
                                <td>Ahmedabad, Gujarat</td>
                                <td>12 Dec 2023</td>
                                <td>Admin User</td>
                                <td>
                                    <button class="btn btn-view-details" onclick="viewDetails(1, 'college')">
                                        <i class="bx bx-show"></i> View Details
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Rejected Tab -->
            <div class="tab-pane fade" id="rejected" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-verification table-hover" id="rejectedTable">
                        <thead>
                            <tr>
                                <th>SR. NO</th>
                                <th>TYPE</th>
                                <th>INSTITUTION</th>
                                <th>LOCATION</th>
                                <th>REJECTED DATE</th>
                                <th>REJECTED BY</th>
                                <th>REASON</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><span class="type-badge type-college">College</span></td>
                                <td>
                                    <div class="institution-info">
                                        <h6>Sample Tech Institute</h6>
                                        <span class="code">STI-001</span>
                                    </div>
                                </td>
                                <td>Ahmedabad, Gujarat</td>
                                <td>05 Jan 2024</td>
                                <td>Admin User</td>
                                <td>Incomplete documentation</td>
                                <td>
                                    <button class="btn btn-view-details" onclick="viewDetails(1, 'college')">
                                        <i class="bx bx-show"></i> View Details
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

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header modal-header-approve">
                <h5 class="modal-title"><i class="bx bx-check-circle"></i> Approve Institution</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <div class="verification-note">
                    <strong>Institution:</strong> <span id="approveInstitutionName"></span>
                </div>
                <form id="approveForm">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Approval Notes (Optional)</label>
                        <textarea class="form-control" id="approveNotes" rows="4" placeholder="Add any notes about the approval..."></textarea>
                    </div>
                    <div class="alert alert-info" role="alert">
                        <i class="bx bx-info-circle"></i> Once approved, this institution will be visible to all users and can start posting opportunities.
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn btn-approve" onclick="confirmApprove()">
                    <i class="bx bx-check"></i> Approve Institution
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header modal-header-reject">
                <h5 class="modal-title"><i class="bx bx-x-circle"></i> Reject Institution</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <div class="verification-note" style="border-left-color: #dc3545;">
                    <strong>Institution:</strong> <span id="rejectInstitutionName"></span>
                </div>
                <form id="rejectForm">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Rejection Reason <span style="color: #dc3545;">*</span></label>
                        <textarea class="form-control" id="rejectReason" rows="4" placeholder="Please provide a reason for rejection..." required></textarea>
                    </div>
                    <div class="alert alert-warning" role="alert">
                        <i class="bx bx-error"></i> The institution will be notified about the rejection and the reason provided.
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn btn-reject" onclick="confirmReject()">
                    <i class="bx bx-x-circle"></i> Reject Institution
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    let currentInstitutionId = null;
    let currentInstitutionType = null;

    $(document).ready(function() {
        $('#pendingTable').DataTable({
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search institutions..."
            }
        });

        $('#approvedTable').DataTable({
            order: [[0, 'asc']],
            pageLength: 10
        });

        $('#rejectedTable').DataTable({
            order: [[0, 'asc']],
            pageLength: 10
        });
    });

    window.showApproveModal = function(id, type, name) {
        currentInstitutionId = id;
        currentInstitutionType = type;
        document.getElementById('approveInstitutionName').textContent = name;
        document.getElementById('approveNotes').value = '';
        const modal = new bootstrap.Modal(document.getElementById('approveModal'));
        modal.show();
    }

    window.showRejectModal = function(id, type, name) {
        currentInstitutionId = id;
        currentInstitutionType = type;
        document.getElementById('rejectInstitutionName').textContent = name;
        document.getElementById('rejectReason').value = '';
        const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
        modal.show();
    }

    window.confirmApprove = function() {
        const notes = document.getElementById('approveNotes').value;
        
        console.log('Approving:', {
            id: currentInstitutionId,
            type: currentInstitutionType,
            notes: notes
        });

        // AJAX call to backend
        // $.ajax({...});

        bootstrap.Modal.getInstance(document.getElementById('approveModal')).hide();
        alert('✅ Institution approved successfully!');
        
        // Remove row from pending table
        $(`#pendingTable tr[data-id="${currentInstitutionId}"][data-type="${currentInstitutionType}"]`).remove();
    }

    window.confirmReject = function() {
        const form = document.getElementById('rejectForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const reason = document.getElementById('rejectReason').value;
        
        console.log('Rejecting:', {
            id: currentInstitutionId,
            type: currentInstitutionType,
            reason: reason
        });

        // AJAX call to backend
        // $.ajax({...});

        bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
        alert('✅ Institution rejected successfully!');
        
        // Remove row from pending table
        $(`#pendingTable tr[data-id="${currentInstitutionId}"][data-type="${currentInstitutionType}"]`).remove();
    }

    window.viewDetails = function(id, type) {
        alert(`View details for ${type}: ${id}`);
        // Open detailed view modal or redirect to detail page
    }
</script>
@endpush
