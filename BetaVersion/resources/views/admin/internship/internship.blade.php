@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "Internship";
</script>

<style>
    /* Tab Navigation Styles */
    .internship-tabs {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .nav-pills-custom {
        display: flex;
        gap: 12px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 0;
    }

    .nav-pills-custom .nav-link {
        background: transparent;
        color: #666;
        border: none;
        border-bottom: 3px solid transparent;
        border-radius: 0;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-pills-custom .nav-link:hover {
        color: #f26e2c;
        background: #fff5f0;
    }

    .nav-pills-custom .nav-link.active {
        color: #242a62;
        background: transparent;
        border-bottom-color: #f26e2c;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 8px;
    }

    .status-badge.new {
        background: #fff3cd;
        color: #856404;
    }

    .status-badge.processing {
        background: #cfe2ff;
        color: #084298;
    }

    .status-badge.complete {
        background: #d1e7dd;
        color: #0f5132;
    }

    /* Action Buttons */
    .btn-action {
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-accept {
        background: #28a745;
        color: white;
        border: none;
    }

    .btn-accept:hover {
        background: #218838;
        color: white;
    }

    .btn-reject {
        background: #dc3545;
        color: white;
        border: none;
    }

    .btn-reject:hover {
        background: #c82333;
        color: white;
    }

    .btn-view {
        background: #17a2b8;
        color: white;
        border: none;
    }

    .btn-view:hover {
        background: #138496;
        color: white;
    }

    /* Modal Styles */
    .modal-header-custom {
        background: #242a62;
        color: white;
        border-radius: 0;
        padding: 20px 30px;
    }

    .modal-header-custom h5 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
    }

    .modal-header-custom .btn-close {
        background: #fff;
        border: none;
        font-size: 24px;
        color: white;
        opacity: 1;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-header-custom .btn-close:hover {
        opacity: 0.8;
        background: #fff;
        border-radius: 4px;
    }

    .detail-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .detail-section h6 {
        color: #242a62;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #242a62;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed #dee2e6;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #495057;
        font-size: 13px;
    }

    .detail-value {
        color: #212529;
        font-size: 13px;
    }

    .form-section {
        background: white;
        border: 2px solid #e7e7ff;
        border-radius: 10px;
        padding: 20px;
        margin-top: 20px;
    }

    .form-section h6 {
        color: #696cff;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .form-label-required::after {
        content: " *";
        color: #dc3545;
    }

    /* Table Styles */
    .table-hover tbody tr:hover {
        background-color: #f5f5ff;
    }

    .dataTables_wrapper .dataTables_length select {
        padding: 4px 8px;
        border-radius: 6px;
        border: 1px solid #d9d9e3;
    }

    .dataTables_wrapper .dataTables_filter input {
        border-radius: 6px;
        border: 1px solid #d9d9e3;
        padding: 6px 12px;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Tab Navigation -->
    <div class="internship-tabs">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <ul class="nav nav-pills nav-pills-custom mb-0" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-new-tab" data-bs-toggle="pill" data-bs-target="#pills-new" 
                            type="button" role="tab" aria-controls="pills-new" aria-selected="true">
                        <i class="bx bx-bell"></i> New Requests
                        <span class="status-badge new" id="newCount">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-processing-tab" data-bs-toggle="pill" data-bs-target="#pills-processing" 
                            type="button" role="tab" aria-controls="pills-processing" aria-selected="false">
                        <i class="bx bx-time"></i> Processing Internships
                        <span class="status-badge processing" id="processingCount">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-complete-tab" data-bs-toggle="pill" data-bs-target="#pills-complete" 
                            type="button" role="tab" aria-controls="pills-complete" aria-selected="false">
                        <i class="bx bx-check-circle"></i> Completed Internships
                        <span class="status-badge complete" id="completeCount">0</span>
                    </button>
                </li>
            </ul>
            <a href="{{ route('admin.internship.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Create New Internship
            </a>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content p-0" id="pills-tabContent">
        <!-- New Requests Tab -->
        <div class="tab-pane fade show active" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab">
            <div class="card">
                <div class="card-header p-4">
                    <h5 class="card-title mb-0"><i class="bx bx-bell"></i> New Internship Requests</h5>
                </div>
                <hr class="my-1">
                <div class="card-body table-responsive p-4">
                    <table id="NewRequestsTable" class="table table-sm table-striped table-hover">
                        <thead class="border-top">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Internship Name</th>
                                <th>Company</th>
                                <th>Duration (Months)</th>
                                <th>Applied Date</th>
                                <th>Student Name</th>
                                <th>Student Email</th>
                                <th>University</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sample Data - Replace with dynamic data -->
                            <tr>
                                <td>1</td>
                                <td>Full-Stack Web Development</td>
                                <td>CodeCraft Solutions</td>
                                <td>3</td>
                                <td>Jan 28, 2026</td>
                                <td>Rahul Sharma</td>
                                <td>rahul@example.com</td>
                                <td>Gujarat University</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td>
                                    <button class="btn btn-action btn-accept btn-sm me-1" onclick="openAcceptModal(1)">
                                        <i class="bx bx-check"></i> Accept
                                    </button>
                                    <button class="btn btn-action btn-reject btn-sm" onclick="rejectInternship(1)">
                                        <i class="bx bx-x"></i> Reject
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Digital Marketing Internship</td>
                                <td>Tech Solutions Pvt Ltd</td>
                                <td>2</td>
                                <td>Jan 29, 2026</td>
                                <td>Priya Patel</td>
                                <td>priya@example.com</td>
                                <td>Ahmedabad University</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td>
                                    <button class="btn btn-action btn-accept btn-sm me-1" onclick="openAcceptModal(2)">
                                        <i class="bx bx-check"></i> Accept
                                    </button>
                                    <button class="btn btn-action btn-reject btn-sm" onclick="rejectInternship(2)">
                                        <i class="bx bx-x"></i> Reject
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Processing Internships Tab -->
        <div class="tab-pane fade" id="pills-processing" role="tabpanel" aria-labelledby="pills-processing-tab">
            <div class="card">
                <div class="card-header p-4">
                    <h5 class="card-title mb-0"><i class="bx bx-time"></i> Processing Internships</h5>
                </div>
                <hr class="my-1">
                <div class="card-body table-responsive p-4">
                    <table id="ProcessingTable" class="table table-sm table-striped table-hover">
                        <thead class="border-top">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Internship Name</th>
                                <th>Company</th>
                                <th>Duration (Months)</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Student Name</th>
                                <th>Progress</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sample Data -->
                            <tr>
                                <td>1</td>
                                <td>UI/UX Design Internship</td>
                                <td>Design Studio</td>
                                <td>3</td>
                                <td>Jan 15, 2026</td>
                                <td>Apr 15, 2026</td>
                                <td>Amit Kumar</td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                                    </div>
                                </td>
                                <td><span class="badge bg-info">In Progress</span></td>
                                <td>
                                    <a href="{{ route('admin.internship.view', 1) }}" class="btn btn-action btn-view btn-sm">
                                        <i class="bx bx-show"></i> View
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Completed Internships Tab -->
        <div class="tab-pane fade" id="pills-complete" role="tabpanel" aria-labelledby="pills-complete-tab">
            <div class="card">
                <div class="card-header p-4">
                    <h5 class="card-title mb-0"><i class="bx bx-check-circle"></i> Completed Internships</h5>
                </div>
                <hr class="my-1">
                <div class="card-body table-responsive p-4">
                    <table id="CompletedTable" class="table table-sm table-striped table-hover">
                        <thead class="border-top">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Internship Name</th>
                                <th>Company</th>
                                <th>Duration (Months)</th>
                                <th>Completion Date</th>
                                <th>Student Name</th>
                                <th>Rating</th>
                                <th>Certificate</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sample Data -->
                            <tr>
                                <td>1</td>
                                <td>Data Analytics Internship</td>
                                <td>Analytics Corp</td>
                                <td>3</td>
                                <td>Dec 20, 2025</td>
                                <td>Neha Shah</td>
                                <td>
                                    <i class="bx bxs-star text-warning"></i>
                                    <i class="bx bxs-star text-warning"></i>
                                    <i class="bx bxs-star text-warning"></i>
                                    <i class="bx bxs-star text-warning"></i>
                                    <i class="bx bxs-star-half text-warning"></i>
                                </td>
                                <td><span class="badge bg-success">Issued</span></td>
                                <td>
                                    <button class="btn btn-action btn-view btn-sm" onclick="viewInternshipDetails(1)">
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

<!-- Accept Internship Modal -->
<div class="modal fade" id="acceptInternshipModal" tabindex="-1" aria-labelledby="acceptInternshipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <div>
                    <h5 class="modal-title" id="acceptInternshipModalLabel" style="color:#fff; ">
                        <i class="bx bx-check-circle"></i> Accept Internship Application
                    </h5>
                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;">Review and configure internship details</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x" style="color:#000;"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px;">
               

                <div class="detail-section">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6><i class="bx bx-briefcase"></i> Internship Details</h6>
                        <button class="btn btn-sm btn-outline-primary" onclick="toggleEditMode('internship')">
                            <i class="bx bx-edit"></i> Edit
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-row">
                                <span class="detail-label">Internship Title:</span>
                                <span class="detail-value" id="internshipTitle">Full-Stack Web Development</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Category:</span>
                                <span class="detail-value" id="category">Engineering</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Company Name:</span>
                                <span class="detail-value" id="companyName">CodeCraft Solutions</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Company Website:</span>
                                <span class="detail-value" id="companyWebsite">https://www.codecraft.com</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Mode:</span>
                                <span class="detail-value" id="workMode">Hybrid</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Location:</span>
                                <span class="detail-value" id="location">Ahmedabad, Gujarat</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Duration:</span>
                                <span class="detail-value" id="duration">3 Months</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Total Weeks:</span>
                                <span class="detail-value" id="totalWeeks">12 Weeks</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Total Hours:</span>
                                <span class="detail-value" id="totalHours">180 Hours</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-row">
                                <span class="detail-label">Start Date:</span>
                                <span class="detail-value" id="startDate">10 Mar 2026</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">End Date:</span>
                                <span class="detail-value" id="endDate">10 Jun 2026</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Stipend:</span>
                                <span class="detail-value" id="stipend">₹8,000/month</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Openings:</span>
                                <span class="detail-value" id="openings">5 Positions</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Application Deadline:</span>
                                <span class="detail-value" id="applicationDeadline">28 Feb 2026</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Batch Days:</span>
                                <span class="detail-value" id="batchDays">Monday, Wednesday, Friday</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Time Slots:</span>
                                <span class="detail-value" id="timeSlots">10:00 AM - 1:00 PM, 3:00 PM - 6:00 PM</span>
                            </div>
                        </div>
                    </div>

                    <!-- Fees Section -->
                    <div class="row mt-3" id="feesDetailsSection">
                        <div class="col-12">
                            <h6 class="text-primary mb-2" style="font-size: 13px;"><i class="bx bx-money"></i> Fee Structure</h6>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-row">
                                <span class="detail-label">Internship Fee:</span>
                                <span class="detail-value" id="internshipFee">₹2,000</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-row">
                                <span class="detail-label">Late Registration Fee:</span>
                                <span class="detail-value" id="lateRegistrationFee">₹500</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-row">
                                <span class="detail-label">Last Date of Registration:</span>
                                <span class="detail-value" id="lateRegisterLastDate">25 Feb 2026</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-row">
                                <span class="detail-label">GST (%):</span>
                                <span class="detail-value" id="gstPercentage">18%</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-row">
                                <span class="detail-label">GST Amount:</span>
                                <span class="detail-value" id="gstAmount">₹360</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-row">
                                <span class="detail-label">Total Fee (with GST):</span>
                                <span class="detail-value" id="totalFee"><strong>₹2,360</strong></span>
                            </div>
                        </div>
                    </div>

                    <!-- Skills & Eligibility -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="text-primary mb-2" style="font-size: 13px;"><i class="bx bx-cog"></i> Skills & Requirements</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-row">
                                <span class="detail-label">Required Skills:</span>
                                <span class="detail-value" id="requiredSkills">
                                    <span class="badge bg-light text-dark me-1">HTML</span>
                                    <span class="badge bg-light text-dark me-1">CSS</span>
                                    <span class="badge bg-light text-dark me-1">JavaScript</span>
                                    <span class="badge bg-light text-dark me-1">React</span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-row">
                                <span class="detail-label">Eligibility Criteria:</span>
                                <span class="detail-value" id="eligibilityCriteria">
                                    <span class="badge bg-light text-dark me-1">Final Year</span>
                                    <span class="badge bg-light text-dark me-1">Good Communication</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Descriptions -->
                    <div class="row mt-3">
                        <div class="col-12 mb-2">
                            <h6 class="text-primary mb-2" style="font-size: 13px;"><i class="bx bx-detail"></i> Description Details</h6>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="detail-row">
                                <span class="detail-label">Internship Description:</span>
                            </div>
                            <div class="detail-value" id="internshipDescription" style="padding: 10px; background: #f8f9fa; border-radius: 6px; font-size: 12px;">
                                Work with the engineering team to build responsive web modules and features...
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="detail-row">
                                <span class="detail-label">Module Brief:</span>
                            </div>
                            <div class="detail-value" id="moduleDescription" style="padding: 10px; background: #f8f9fa; border-radius: 6px; font-size: 12px;">
                                Weekly sprints covering layout systems, component libraries, API consumption...
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="detail-row">
                                <span class="detail-label">Internship Objective:</span>
                            </div>
                            <div class="detail-value" id="internshipObjective" style="padding: 10px; background: #f8f9fa; border-radius: 6px; font-size: 12px;">
                                Enable interns to ship production-ready features and follow version control best practices...
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="detail-row">
                                <span class="detail-label">Internship Outcome:</span>
                            </div>
                            <div class="detail-value" id="internshipOutcome" style="padding: 10px; background: #f8f9fa; border-radius: 6px; font-size: 12px;">
                                By the end, participants will have a deployed portfolio project and verified completion certificate...
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configuration Form -->
                <div class="form-section">
                    <h6><i class="bx bx-cog"></i> Internship Configuration</h6>
                    <form id="internshipConfigForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="registrationFees" class="form-label form-label-required">Registration Fees</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control" id="registrationFees" name="registrationFees" 
                                           placeholder="2000" value="2000" required>
                                </div>
                                <small class="text-muted">One-time registration fee for the internship</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastRegisterDate" class="form-label form-label-required">Last Registration Date</label>
                                <input type="date" class="form-control" id="lastRegisterDate" name="lastRegisterDate" required>
                                <small class="text-muted">Final date for accepting applications</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="startDate" class="form-label form-label-required">Internship Start Date</label>
                                <input type="date" class="form-control" id="startDate" name="startDate" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="endDate" class="form-label form-label-required">Internship End Date</label>
                                <input type="date" class="form-control" id="endDate" name="endDate" required>
                            </div>
                        </div>
                       
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="background: #f8f9fa; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn btn-success" onclick="confirmAcceptInternship()">
                    <i class="bx bx-check"></i> Accept & Configure Internship
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Initialize DataTables for all tables
        $('#NewRequestsTable').DataTable({
            order: [[4, 'desc']], // Sort by date
            pageLength: 10
        });

        $('#ProcessingTable').DataTable({
            order: [[4, 'asc']], // Sort by start date
            pageLength: 10
        });

        $('#CompletedTable').DataTable({
            order: [[4, 'desc']], // Sort by completion date
            pageLength: 10
        });

        // Update badge counts (replace with actual data from server)
        $('#newCount').text('2');
        $('#processingCount').text('1');
        $('#completeCount').text('1');

        // Set min date for date inputs
        const today = new Date().toISOString().split('T')[0];
        $('#lastRegisterDate').attr('min', today);
        $('#startDate').attr('min', today);
        $('#endDate').attr('min', today);

        // Update end date min when start date changes
        $('#startDate').on('change', function() {
            $('#endDate').attr('min', this.value);
        });
    });

    // Open Accept Modal
    function openAcceptModal(internshipId) {
        // Here you would fetch actual data from server using AJAX
        // For now, using sample data
        $('#acceptInternshipModal').modal('show');
    }

    // Toggle Edit Mode
    function toggleEditMode(section) {
        // Implement edit mode functionality
        alert('Edit mode for ' + section + ' section - To be implemented with actual edit fields');
    }

    // Confirm Accept Internship
    function confirmAcceptInternship() {
        const form = document.getElementById('internshipConfigForm');
        
        if (form.checkValidity()) {
            // Collect form data
            const formData = {
                registrationFees: $('#registrationFees').val(),
                lastRegisterDate: $('#lastRegisterDate').val(),
                startDate: $('#startDate').val(),
                endDate: $('#endDate').val(),
                totalSeats: $('#totalSeats').val(),
                mentorName: $('#mentorName').val(),
                prerequisites: $('#prerequisites').val(),
                learningObjectives: $('#learningObjectives').val(),
                certificationType: $('#certificationType').val(),
                evaluationCriteria: $('#evaluationCriteria').val(),
                specialNotes: $('#specialNotes').val(),
                sendWelcomeEmail: $('#sendWelcomeEmail').is(':checked'),
                notifyCompany: $('#notifyCompany').is(':checked')
            };

            console.log('Form Data:', formData);

            // Here you would send data to server using AJAX
            // $.ajax({
            //     url: '/admin/internship/accept',
            //     method: 'POST',
            //     data: formData,
            //     success: function(response) {
            //         // Handle success
            //     }
            // });

            // Show success message
            alert('Internship accepted successfully! Student will receive confirmation email.');
            $('#acceptInternshipModal').modal('hide');
            
            // Reload table or update row
            location.reload();
        } else {
            form.reportValidity();
        }
    }

    // Reject Internship
    function rejectInternship(internshipId) {
        if (confirm('Are you sure you want to reject this internship application?')) {
            const reason = prompt('Please provide a reason for rejection (optional):');
            
            // Here you would send rejection to server
            console.log('Rejecting internship:', internshipId, 'Reason:', reason);
            
            alert('Internship application rejected. Student will be notified.');
            location.reload();
        }
    }

    // View Internship Details
    function viewInternshipDetails(internshipId) {
        // Implement view details functionality
        alert('View details for internship ID: ' + internshipId);
    }
</script>
@endpush
