@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "Internship";
</script>

<style>
    /* Internship View Page Styles */
    .internship-view-header {
        background: #242a62;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        color: white;
        box-shadow: 0 4px 15px rgba(36, 42, 98, 0.3);
    }

    .internship-view-header h4 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
    }

    .internship-view-header p {
        margin: 8px 0 0 0;
        opacity: 0.9;
    }

    /* Tab Navigation */
    .nav-tabs-internship {
        background: #fff;
        border-radius: 12px 12px 0 0;
        padding: 15px 20px 0 20px;
        border-bottom: 3px solid #242a62;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .nav-tabs-internship .nav-link {
        color: #666;
        border: none;
        border-bottom: 3px solid transparent;
        border-radius: 0;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        margin-bottom: -3px;
    }

    .nav-tabs-internship .nav-link:hover {
        color: #242a62;
        background: #fff5f0;
    }

    .nav-tabs-internship .nav-link.active {
        color: #242a62;
        background: transparent;
        border-bottom-color: #242a62;
    }

    .tab-content-card {
        background: #fff;
        border-radius: 0 0 12px 12px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    /* Detail Section */
    .detail-row-view {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px dashed #dee2e6;
    }

    .detail-row-view:last-child {
        border-bottom: none;
    }

    .detail-label-view {
        font-weight: 600;
        color: #495057;
        font-size: 14px;
        min-width: 200px;
    }

    .detail-value-view {
        color: #212529;
        font-size: 14px;
        flex: 1;
    }

    .section-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 4px solid #242a62;
    }

    .section-card h6 {
        color: #242a62;
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 15px;
    }

    /* Action Buttons */
    .btn-action-view {
        padding: 6px 14px;
        font-size: 13px;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-edit-view {
        background: #17a2b8;
        color: white;
        border: none;
    }

    .btn-edit-view:hover {
        background: #138496;
        color: white;
        transform: translateY(-2px);
    }

    .btn-view-submission {
        background: #6f42c1;
        color: white;
        border: none;
    }

    .btn-view-submission:hover {
        background: #5a32a3;
        color: white;
        transform: translateY(-2px);
    }

    .btn-complete-internship {
        background: #28a745;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
    }

    .btn-complete-internship:hover {
        background: #218838;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
    }

    /* Modal Styles */
    .modal-header-view {
        background: linear-gradient(135deg, #242a62 0%, #f26e2c 100%);
        color: white;
        padding: 20px 30px;
    }

    .modal-header-view h5 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
    }

    .modal-header-view .btn-close {
        background: transparent;
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

    .modal-header-view .btn-close:hover {
        opacity: 0.8;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
    }

    /* Table Styles */
    .table-internship-view .table-hover tbody tr:hover {
        background-color: #fff5f0;
    }

    .badge-enrolled {
        background: #28a745;
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
    }

    .badge-completed {
        background: #007bff;
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
    }

    .badge-in-progress {
        background: #ffc107;
        color: #000;
        padding: 6px 12px;
        border-radius: 20px;
    }

    .ck-editor__editable {
        min-height: 300px;
    }

    /* Complete Internship Table Styles */
    .complete-internship-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }

    .complete-internship-table thead {
        background: linear-gradient(135deg, #242a62 0%, #3d4575 100%);
    }

    .complete-internship-table thead th {
        color: white;
        font-weight: 600;
        padding: 16px 12px;
        text-align: center;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-right: 1px solid rgba(255,255,255,0.1);
    }

    .complete-internship-table thead th:last-child {
        border-right: none;
    }

    .complete-internship-table tbody tr {
        border-bottom: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .complete-internship-table tbody tr:hover {
        background: #f8f9fa;
    }

    .complete-internship-table tbody td {
        padding: 16px 12px;
        vertical-align: middle;
        font-size: 14px;
        color: #495057;
    }

    .complete-internship-table tbody td:first-child {
        text-align: center;
        font-weight: 600;
        color: #242a62;
    }

    .marks-input-group {
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
    }

    .marks-input-group label {
        margin: 0;
        font-size: 12px;
        color: #6c757d;
        font-weight: 600;
    }

    .marks-input {
        width: 70px;
        padding: 8px 10px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        text-align: center;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .marks-input:focus {
        outline: none;
        border-color: #242a62;
        box-shadow: 0 0 0 3px rgba(36, 42, 98, 0.1);
    }

    .marks-input:disabled {
        background: #f8f9fa;
        cursor: not-allowed;
    }

    .max-marks {
        font-size: 13px;
        color: #6c757d;
        font-weight: 600;
    }

    .feedback-textarea {
        width: 100%;
        min-height: 80px;
        padding: 10px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 13px;
        resize: vertical;
        transition: all 0.3s ease;
    }

    .feedback-textarea:focus {
        outline: none;
        border-color: #242a62;
        box-shadow: 0 0 0 3px rgba(36, 42, 98, 0.1);
    }

    .total-display {
        font-size: 18px;
        font-weight: 700;
        color: #242a62;
        text-align: center;
    }

    .percentage-display {
        font-size: 16px;
        font-weight: 700;
        color: #17a2b8;
        text-align: center;
    }

    .grade-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 14px;
        text-align: center;
    }

    .grade-A { background: #28a745; color: white; }
    .grade-B { background: #17a2b8; color: white; }
    .grade-C { background: #ffc107; color: #333; }
    .grade-D { background: #fd7e14; color: white; }
    .grade-F { background: #dc3545; color: white; }

    .btn-complete-internship-submit {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 14px 32px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 16px;
        border: none;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        transition: all 0.3s ease;
    }

    .btn-complete-internship-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        color: white;
    }

    .btn-complete-internship-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    /* Confirmation Modal Styles */
    .confirmation-modal .modal-content {
        border-radius: 16px;
        border: none;
        overflow: hidden;
    }

    .confirmation-modal .modal-header {
        background: linear-gradient(135deg, #f26e2c 0%, #ff9966 100%);
        border: none;
        padding: 24px 30px;
    }

    .confirmation-modal .modal-title {
        color: white !important;
        font-size: 22px;
        font-weight: 700;
    }

    .confirmation-modal .modal-body {
        padding: 32px;
        text-align: center;
    }

    .confirmation-icon {
        font-size: 64px;
        color: #f26e2c;
        margin-bottom: 20px;
    }

    .confirmation-text {
        font-size: 16px;
        color: #495057;
        margin-bottom: 24px;
        line-height: 1.6;
    }

    .confirmation-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    .btn-confirm-yes {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 12px 32px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-confirm-yes:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        color: white;
    }

    .btn-confirm-no {
        background: #6c757d;
        color: white;
        padding: 12px 32px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-confirm-no:hover {
        background: #5a6268;
        color: white;
    }

    .export-btn {
        background: linear-gradient(135deg, #242a62 0%, #3d4575 100%);
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        margin-left: 12px;
    }

    .export-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(36, 42, 98, 0.3);
        color: white;
    }

    @media (max-width: 768px) {
        .complete-internship-table {
            font-size: 12px;
        }
        
        .marks-input {
            width: 60px;
            padding: 6px 8px;
            font-size: 12px;
        }
        
        .complete-internship-table thead th,
        .complete-internship-table tbody td {
            padding: 10px 6px;
        }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="internship-view-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 style="color: #fff;">
                    <i class="bx bx-briefcase-alt-2"></i> Full-Stack Web Development Internship
                </h4>
                <p>CodeCraft Solutions • 3 Months • Hybrid Mode</p>
            </div>
            <a href="{{ route('admin.internship.management') }}" class="btn btn-light">
                <i class="bx bx-arrow-back"></i> Back to List
            </a>
        </div>
    </div>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs nav-tabs-internship" id="internshipViewTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" 
                    type="button" role="tab">
                <i class="bx bx-info-circle"></i> &nbsp;&nbsp;Internship Details
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" 
                    type="button" role="tab">
                <i class="bx bx-user"></i> &nbsp;&nbsp; Students
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks" 
                    type="button" role="tab">
                <i class="bx bx-task"></i> &nbsp;&nbsp; Manage Tasks
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="instructions-tab" data-bs-toggle="tab" data-bs-target="#instructions" 
                    type="button" role="tab">
                <i class="bx bx-file"></i> &nbsp;&nbsp; General Instructions
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" 
                    type="button" role="tab">
                <i class="bx bx-money"></i> &nbsp;&nbsp; Payment History
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="complete-tab" data-bs-toggle="tab" data-bs-target="#complete" 
                    type="button" role="tab">
                <i class="bx bx-check-circle"></i> &nbsp;&nbsp; Complete Internship
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content tab-content-card" id="internshipViewTabContent">
        <!-- Internship Details Tab -->
        <div class="tab-pane fade show active" id="details" role="tabpanel">
            <h5 style="color: #242a62; font-weight: 700; margin-bottom: 20px;">
                <i class="bx bx-detail"></i> Internship Information
            </h5>

            <div class="section-card">
                <h6><i class="bx bx-info-circle"></i> Basic Details</h6>
                <div class="detail-row-view">
                    <span class="detail-label-view">Internship Title:</span>
                    <span class="detail-value-view">Full-Stack Web Development</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Company Name:</span>
                    <span class="detail-value-view">CodeCraft Solutions</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Category:</span>
                    <span class="detail-value-view">Engineering</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Mode:</span>
                    <span class="detail-value-view">Hybrid</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Location:</span>
                    <span class="detail-value-view">Ahmedabad, Gujarat</span>
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-time"></i> Duration & Schedule</h6>
                <div class="detail-row-view">
                    <span class="detail-label-view">Duration:</span>
                    <span class="detail-value-view">3 Months</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Total Weeks:</span>
                    <span class="detail-value-view">12 Weeks</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Total Hours:</span>
                    <span class="detail-value-view">180 Hours</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Start Date:</span>
                    <span class="detail-value-view">10 Mar 2026</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">End Date:</span>
                    <span class="detail-value-view">10 Jun 2026</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Batch Days:</span>
                    <span class="detail-value-view">Monday, Wednesday, Friday</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Time Slots:</span>
                    <span class="detail-value-view">10:00 AM - 1:00 PM, 3:00 PM - 6:00 PM</span>
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-money"></i> Compensation & Fees</h6>
                <div class="detail-row-view">
                    <span class="detail-label-view">Stipend:</span>
                    <span class="detail-value-view">₹8,000/month</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Internship Fee:</span>
                    <span class="detail-value-view">₹2,000</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">GST (18%):</span>
                    <span class="detail-value-view">₹360</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Total Fee:</span>
                    <span class="detail-value-view"><strong>₹2,360</strong></span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Openings:</span>
                    <span class="detail-value-view">5 Positions</span>
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-cog"></i> Skills & Requirements</h6>
                <div class="detail-row-view">
                    <span class="detail-label-view">Required Skills:</span>
                    <span class="detail-value-view">
                        <span class="badge bg-light text-dark me-1">HTML</span>
                        <span class="badge bg-light text-dark me-1">CSS</span>
                        <span class="badge bg-light text-dark me-1">JavaScript</span>
                        <span class="badge bg-light text-dark me-1">React</span>
                        <span class="badge bg-light text-dark me-1">Node.js</span>
                    </span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Eligibility Criteria:</span>
                    <span class="detail-value-view">
                        <span class="badge bg-light text-dark me-1">Final Year Students</span>
                        <span class="badge bg-light text-dark me-1">Good Communication</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Students Tab -->
        <div class="tab-pane fade" id="students" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                    <i class="bx bx-user"></i> Enrolled Students
                </h5>
                <span class="badge-enrolled">Total: 3 Students</span>
            </div>

            <div class="table-responsive">
                <table id="StudentsTable" class="table table-sm table-striped table-hover table-internship-view">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>University</th>
                            <th>College</th>
                            <th>Enrollment Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Rahul Sharma</td>
                            <td>rahul@example.com</td>
                            <td>+91 98765 43210</td>
                            <td>Gujarat University</td>
                            <td>L.D. College of Engineering</td>
                            <td>28 Jan 2026</td>
                            <td>
                                <button class="btn btn-action-view btn-edit-view btn-sm" onclick="viewStudentDetails(1)">
                                    <i class="bx bx-show"></i> View
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Priya Patel</td>
                            <td>priya@example.com</td>
                            <td>+91 98765 43211</td>
                            <td>Gujarat University</td>
                            <td>Nirma University</td>
                            <td>29 Jan 2026</td>
                        
                            <td>
                                <button class="btn btn-action-view btn-edit-view btn-sm" onclick="viewStudentDetails(2)">
                                    <i class="bx bx-show"></i> View
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Amit Kumar</td>
                            <td>amit@example.com</td>
                            <td>+91 98765 43212</td>
                            <td>Mumbai University</td>
                            <td>CEPT University</td>
                            <td>30 Jan 2026</td>
                          
                            <td>
                                <button class="btn btn-action-view btn-edit-view btn-sm" onclick="viewStudentDetails(3)">
                                    <i class="bx bx-show"></i> View
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Manage Tasks Tab -->
        <div class="tab-pane fade" id="tasks" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                    <i class="bx bx-task"></i> Task Management
                </h5>
                <button class="btn btn-primary" style="background: #f26e2c; border-color: #f26e2c;" onclick="openAddTaskModal()">
                    <i class="bx bx-plus"></i> Add New Task
                </button>
            </div>

            <div class="table-responsive">
                <table id="TasksTable" class="table table-sm table-striped table-hover table-internship-view">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Task Title</th>
                            <th>Description</th>
                            <th>Upload Date</th>
                            <th>Due Date</th>
                            <th>Task File</th>
                            <th>Submissions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Create Landing Page</td>
                            <td>Design and develop a responsive landing page</td>
                            <td>05 Feb 2026</td>
                            <td>12 Feb 2026</td>
                            <td>
                                <a href="#" class="badge bg-info">
                                    <i class="bx bx-download"></i> task_1.pdf
                                </a>
                            </td>
                            <td><span class="badge bg-warning">2/3 Submitted</span></td>
                            <td>
                                <button class="btn btn-action-view btn-edit-view btn-sm me-1" onclick="editTask(1)">
                                    <i class="bx bx-edit"></i> Edit
                                </button>
                                <button class="btn btn-action-view btn-view-submission btn-sm" onclick="viewSubmissions(1)">
                                    <i class="bx bx-show"></i> View Submissions
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>API Integration</td>
                            <td>Integrate REST APIs with frontend</td>
                            <td>10 Feb 2026</td>
                            <td>17 Feb 2026</td>
                            <td>
                                <a href="#" class="badge bg-info">
                                    <i class="bx bx-download"></i> task_2.pdf
                                </a>
                            </td>
                            <td><span class="badge bg-secondary">0/3 Submitted</span></td>
                            <td>
                                <button class="btn btn-action-view btn-edit-view btn-sm me-1" onclick="editTask(2)">
                                    <i class="bx bx-edit"></i> Edit
                                </button>
                                <button class="btn btn-action-view btn-view-submission btn-sm" onclick="viewSubmissions(2)">
                                    <i class="bx bx-show"></i> View Submissions
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- General Instructions Tab -->
        <div class="tab-pane fade" id="instructions" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                    <i class="bx bx-file"></i> General Instructions
                </h5>
                <button class="btn btn-primary" style="background: #f26e2c; border-color: #f26e2c;" onclick="openInstructionsModal()">
                    <i class="bx bx-edit"></i> Update Instructions
                </button>
            </div>

            <div class="section-card">
                <div id="instructionsContent">
                    <h6>Welcome to the Full-Stack Web Development Internship!</h6>
                    <p>Please read the following instructions carefully before starting your internship:</p>
                    
                    <h6 class="mt-3">General Guidelines:</h6>
                    <ul>
                        <li>Attend all scheduled sessions on time</li>
                        <li>Complete all assigned tasks before the deadline</li>
                        <li>Maintain professional communication with mentors and peers</li>
                        <li>Follow the code of conduct at all times</li>
                    </ul>

                    <h6 class="mt-3">Task Submission:</h6>
                    <ul>
                        <li>Submit tasks in the specified format (ZIP file with proper folder structure)</li>
                        <li>Include a README file with setup instructions</li>
                        <li>Ensure your code is well-commented and follows best practices</li>
                    </ul>

                    <h6 class="mt-3">Communication:</h6>
                    <ul>
                        <li>Use official email for all communications</li>
                        <li>Response time: Within 24 hours on working days</li>
                        <li>Weekly progress meetings every Friday at 3:00 PM</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Payment History Tab -->
        <div class="tab-pane fade" id="payment" role="tabpanel">
            <h5 style="color: #242a62; font-weight: 700; margin-bottom: 20px;">
                <i class="bx bx-money"></i> Payment Transaction History
            </h5>

            <div class="table-responsive">
                <table id="PaymentTable" class="table table-sm table-striped table-hover table-internship-view">
                    <thead class="border-top">
                        <tr>
                            <th>Transaction ID</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Purchase Date</th>
                            <th>Purchase Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>TXN_20260128_001</strong></td>
                            <td>Rahul Sharma</td>
                            <td>rahul@example.com</td>
                            <td><strong>₹2,360</strong></td>
                            <td>UPI</td>
                            <td>28 Jan 2026</td>
                            <td>10:30 AM</td>
                            <td><span class="badge bg-success">Success</span></td>
                            <td>
                                <button class="btn btn-action-view btn-edit-view btn-sm" onclick="viewPaymentDetails('TXN_20260128_001')">
                                    <i class="bx bx-show"></i> View
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>TXN_20260129_002</strong></td>
                            <td>Priya Patel</td>
                            <td>priya@example.com</td>
                            <td><strong>₹2,360</strong></td>
                            <td>Credit Card</td>
                            <td>29 Jan 2026</td>
                            <td>02:15 PM</td>
                            <td><span class="badge bg-success">Success</span></td>
                            <td>
                                <button class="btn btn-action-view btn-edit-view btn-sm" onclick="viewPaymentDetails('TXN_20260129_002')">
                                    <i class="bx bx-show"></i> View
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>TXN_20260130_003</strong></td>
                            <td>Amit Kumar</td>
                            <td>amit@example.com</td>
                            <td><strong>₹2,360</strong></td>
                            <td>Net Banking</td>
                            <td>30 Jan 2026</td>
                            <td>04:45 PM</td>
                            <td><span class="badge bg-success">Success</span></td>
                            <td>
                                <button class="btn btn-action-view btn-edit-view btn-sm" onclick="viewPaymentDetails('TXN_20260130_003')">
                                    <i class="bx bx-show"></i> View
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Payment Summary Cards -->
            <div class="mt-4">
                <h6 style="color: #242a62; font-weight: 700; margin-bottom: 20px;">
                    <i class="bx bx-chart"></i> Payment Summary
                </h6>
                <div class="row">
                    <!-- Total Revenue Card -->
                    <div class="col-md-3 mb-3">
                        <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #28a745; height: 100%;background-color: #eee;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Revenue</p>
                                    <h4 style="margin: 5px 0 0 0; color: #28a745; font-weight: 700; font-size: 24px;">₹7,080</h4>
                                </div>
                                <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(40, 167, 69, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="bx bx-rupee" style="font-size: 28px; color: #28a745;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Students Card -->
                    <div class="col-md-3 mb-3">
                        <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #17a2b8; height: 100%;background-color: #eee;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Students</p>
                                    <h4 style="margin: 5px 0 0 0; color: #17a2b8; font-weight: 700; font-size: 24px;">3</h4>
                                </div>
                                <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(23, 162, 184, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="bx bx-user-check" style="font-size: 28px; color: #17a2b8;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Successful Payments Card -->
                    <div class="col-md-3 mb-3">
                        <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #007bff; height: 100%;background-color: #eee;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">Successful</p>
                                    <h4 style="margin: 5px 0 0 0; color: #007bff; font-weight: 700; font-size: 24px;">3</h4>
                                </div>
                                <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(0, 123, 255, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="bx bx-check-double" style="font-size: 28px; color: #007bff;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Failed Payments Card -->
                    <div class="col-md-3 mb-3">
                        <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #dc3545; height: 100%;background-color: #eee;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">Failed</p>
                                    <h4 style="margin: 5px 0 0 0; color: #dc3545; font-weight: 700; font-size: 24px;">0</h4>
                                </div>
                                <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(220, 53, 69, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="bx bx-x-circle" style="font-size: 28px; color: #dc3545;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Complete Internship Tab -->
        <div class="tab-pane fade" id="complete" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                        <i class="bx bx-check-circle"></i> Complete The Internship | ગુજરાતી ભાષામા રચનાકોશનો અભ્યાસ
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 14px; margin-top: 5px;">Evaluate student performance and assign grades</p>
                </div>
                <button class="btn export-btn" onclick="exportToExcel()">
                    <i class="fa fa-file-excel-o"></i> Export to Excel
                </button>
            </div>

            <div class="table-responsive">
                <table class="complete-internship-table">
                    <thead>
                        <tr>
                            <th>SR.NO</th>
                            <th>STUDENT</th>
                            <th>COLLEGE</th>
                            <th style="min-width: 300px;">INDUSTRY (INDUSTRY MARKS)</th>
                            <th>FEEDBACK</th>
                            <th>TOTAL</th>
                            <th>PERCENTAGE</th>
                            <th>GRADE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Student 1 -->
                        <tr data-student-id="1">
                            <td>1</td>
                            <td>
                                <div style="font-weight: 600; color: #242a62;">NARESHKUMAR</div>
                                <div style="font-weight: 600; color: #242a62;">MAGANALAL</div>
                                <div style="font-weight: 600; color: #242a62;">BHAKHARIVALA</div>
                            </td>
                            <td>Techno College</td>
                            <td>
                                <div class="marks-input-group mb-2">
                                    <label>Completion of Hours</label>
                                    <input type="number" class="marks-input industry-mark" min="0" max="20" 
                                           data-max="20" placeholder="0" data-field="hours">
                                    <span class="max-marks">/ 20</span>
                                </div>
                                <div class="marks-input-group mb-2">
                                    <label>Quality Performance</label>
                                    <input type="number" class="marks-input industry-mark" min="0" max="20" 
                                           data-max="20" placeholder="0" data-field="quality">
                                    <span class="max-marks">/ 20</span>
                                </div>
                                <div class="marks-input-group">
                                    <label>Assignments</label>
                                    <input type="number" class="marks-input industry-mark" min="0" max="10" 
                                           data-max="10" placeholder="0" data-field="assignments">
                                    <span class="max-marks">/ 10</span>
                                </div>
                            </td>
                            <td>
                                <textarea class="feedback-textarea" placeholder="Enter feedback for student..."></textarea>
                            </td>
                            <td class="total-display">0/ 50</td>
                            <td class="percentage-display">0.00%</td>
                            <td>
                                <span class="grade-badge grade-F">-</span>
                            </td>
                        </tr>

                        <!-- Student 2 -->
                        <tr data-student-id="2">
                            <td>2</td>
                            <td>
                                <div style="font-weight: 600; color: #242a62;">PATEL MITKUMAR</div>
                                <div style="font-weight: 600; color: #242a62;">MAHESHKUMAR</div>
                            </td>
                            <td>
                                <div>MUNICIPAL ARTS &</div>
                                <div>URBAN SCIENCE</div>
                                <div>COLLEGE, MEHSANA</div>
                            </td>
                            <td>
                                <div class="marks-input-group mb-2">
                                    <label>Completion of Hours</label>
                                    <input type="number" class="marks-input industry-mark" min="0" max="20" 
                                           data-max="20" placeholder="0" data-field="hours">
                                    <span class="max-marks">/ 20</span>
                                </div>
                                <div class="marks-input-group mb-2">
                                    <label>Quality Performance</label>
                                    <input type="number" class="marks-input industry-mark" min="0" max="20" 
                                           data-max="20" placeholder="0" data-field="quality">
                                    <span class="max-marks">/ 20</span>
                                </div>
                                <div class="marks-input-group">
                                    <label>Regularity</label>
                                    <input type="number" class="marks-input industry-mark" min="0" max="20" 
                                           data-max="20" placeholder="0" data-field="regularity">
                                    <span class="max-marks">/ 20</span>
                                </div>
                            </td>
                            <td>
                                <textarea class="feedback-textarea" placeholder="Enter feedback for student..."></textarea>
                            </td>
                            <td class="total-display">0/ 60</td>
                            <td class="percentage-display">0.00%</td>
                            <td>
                                <span class="grade-badge grade-F">-</span>
                            </td>
                        </tr>

                        <!-- Student 3 -->
                        <tr data-student-id="3">
                            <td>3</td>
                            <td>
                                <div style="font-weight: 600; color: #242a62;">AMIT SHARMA</div>
                            </td>
                            <td>Engineering College</td>
                            <td>
                                <div class="marks-input-group mb-2">
                                    <label>Completion of Hours</label>
                                    <input type="number" class="marks-input industry-mark" min="0" max="20" 
                                           data-max="20" placeholder="0" data-field="hours">
                                    <span class="max-marks">/ 20</span>
                                </div>
                                <div class="marks-input-group mb-2">
                                    <label>Quality Performance</label>
                                    <input type="number" class="marks-input industry-mark" min="0" max="20" 
                                           data-max="20" placeholder="0" data-field="quality">
                                    <span class="max-marks">/ 20</span>
                                </div>
                                <div class="marks-input-group">
                                    <label>Assignments</label>
                                    <input type="number" class="marks-input industry-mark" min="0" max="10" 
                                           data-max="10" placeholder="0" data-field="assignments">
                                    <span class="max-marks">/ 10</span>
                                </div>
                            </td>
                            <td>
                                <textarea class="feedback-textarea" placeholder="Enter feedback for student..."></textarea>
                            </td>
                            <td class="total-display">0/ 50</td>
                            <td class="percentage-display">0.00%</td>
                            <td>
                                <span class="grade-badge grade-F">-</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-complete-internship-submit" onclick="showConfirmModal()">
                    <i class="fa fa-check-circle"></i> Submit & Complete Internship
                </button>
            </div>

            <div class="alert alert-info mt-4" role="alert">
                <i class="bx bx-info-circle"></i> <strong>Note:</strong> Once submitted, student grades and feedback cannot be modified. Please review all entries carefully before submission.
            </div>
        </div>
    </div>
</div>

<!-- Add New Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #242a62 0%, #f26e2c 100%); color: white; padding: 20px 30px; border: none;">
                <div>
                    <h5 class="modal-title" style="color: #fff; margin: 0; font-size: 20px; font-weight: 700;">
                        <i class="bx bx-plus-circle"></i> Add New Task
                    </h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="background: #fff; border: none; font-size: 24px; color: white; opacity: 1; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                    <i class="bx bx-x" style="color:#fff;"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
                <form id="addTaskForm">
                    <div class="row">
                        <!-- Date & Time -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Date & Time <span style="color: red;">*</span>
                            </label>
                            <input type="datetime-local" class="form-control" id="taskDateTime" name="task_datetime" required 
                                   style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>

                        <!-- Day -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Day
                            </label>
                            <input type="text" class="form-control" id="taskDay" name="task_day" placeholder="e.g., Monday" 
                                   style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>

                        <!-- Module Title -->
                        <div class="col-12 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Module Title <span style="color: red;">*</span>
                            </label>
                            <input type="text" class="form-control" id="moduleTitle" name="module_title" placeholder="Enter Module title" required 
                                   style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>

                        <!-- Module and Task Description -->
                        <div class="col-12 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Module and Task Description <span style="color: red;">*</span>
                            </label>
                            <textarea id="taskDescriptionEditor" name="task_description"></textarea>
                        </div>

                        <!-- Upload File (Optional) -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Upload File (Optional)
                            </label>
                            <input type="file" class="form-control" id="taskFile" name="task_file" 
                                   style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>

                        <!-- Last Submission Date -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Last Submission Date <span style="color: red;">*</span>
                            </label>
                            <input type="date" class="form-control" id="lastSubmissionDate" name="last_submission_date" required 
                                   style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>

                        <!-- Online Link -->
                        <div class="col-12 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Online Link
                            </label>
                            <input type="url" class="form-control" id="onlineLink" name="online_link" placeholder="Enter Online Link" 
                                   style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>

                        <!-- Is this the Final Assignment / Report? -->
                        <div class="col-12 mb-3">
                            <div class="form-check" style="padding-left: 1.5em;">
                                <input class="form-check-input" type="checkbox" id="isFinalAssignment" name="is_final_assignment" 
                                       style="width: 18px; height: 18px; margin-top: 0.15em;">
                                <label class="form-check-label" for="isFinalAssignment" style="font-weight: 600; color: #495057; font-size: 14px; margin-left: 8px;">
                                    Is this the Final Assignment / Report?
                                </label>
                            </div>
                            <small class="text-muted" style="margin-left: 2.5em; display: block; margin-top: 4px;">
                                Check this box if the task is the final assignment or report for this internship.
                            </small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 24px; border-radius: 6px; font-weight: 600;">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn" onclick="saveTask()" style="background: #242a62; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-save"></i> Save Module
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Submissions Modal -->
<div class="modal fade" id="viewSubmissionsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #242a62 0%, #f26e2c 100%); color: white; padding: 20px 30px; border: none;">
                <div>
                    <h5 class="modal-title" style="color: #fff; margin: 0; font-size: 20px; font-weight: 700;">
                        <i class="bx bx-file-find"></i> Task Submissions
                    </h5>
                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;" id="taskTitleSubmission">Task: Create Landing Page</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="background: #fff; border: none; font-size: 24px; color: white; opacity: 1; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                    <i class="bx bx-x" style="color:#000;"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
                
                  <!-- Submission Statistics -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #28a745;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600;">COMPLETED</p>
                                    <h4 style="margin: 5px 0 0 0; color: #28a745; font-weight: 700;" id="completedCount">2</h4>
                                </div>
                                <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(40, 167, 69, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="bx bx-check-circle" style="font-size: 28px; color: #28a745;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #ffc107;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600;">PENDING</p>
                                    <h4 style="margin: 5px 0 0 0; color: #ffc107; font-weight: 700;" id="pendingCount">1</h4>
                                </div>
                                <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(255, 193, 7, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="bx bx-time" style="font-size: 28px; color: #ffc107;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #17a2b8;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600;">TOTAL STUDENTS</p>
                                    <h4 style="margin: 5px 0 0 0; color: #17a2b8; font-weight: 700;" id="totalCount">3</h4>
                                </div>
                                <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(23, 162, 184, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="bx bx-user" style="font-size: 28px; color: #17a2b8;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 style="color: #242a62; font-weight: 700; margin: 0;">
                            <i class="bx bx-list-ul"></i> Student Submission Status
                        </h6>
                        <span id="submissionSummary" class="badge bg-info" style="font-size: 13px; padding: 8px 14px;">
                            2/3 Submitted
                        </span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" style="margin: 0;">
                            <thead style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                                <tr>
                                    <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px;">Sr. No.</th>
                                    <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px;">Student Name</th>
                                    <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px;">Email</th>
                                    <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px;">Task Title</th>
                                    <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px;">Submit Status</th>
                                    <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px; text-align: center;">View File</th>
                                    <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px; text-align: center;">Note</th>
                                </tr>
                            </thead>
                            <tbody id="submissionTableBody">
                                <!-- Dynamic content will be loaded here -->
                                <tr>
                                    <td style="padding: 12px; vertical-align: middle;">1</td>
                                    <td style="padding: 12px; vertical-align: middle;">
                                        <div style="display: flex; align-items: center;">
                                            <span style="font-weight: 600; color: #212529;">Rahul Sharma</span>
                                        </div>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; color: #6c757d; font-size: 13px;">rahul@example.com</td>
                                    <td style="padding: 12px; vertical-align: middle; color: #212529; font-size: 13px; font-weight: 500;">Create Landing Page</td>
                                    <td style="padding: 12px; vertical-align: middle;">
                                        <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; font-size: 12px; border-radius: 20px;">
                                            <i class="bx bx-check-circle"></i> Complete
                                        </span>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; text-align: center;">
                                        <button class="btn btn-sm" style="background: #6f42c1; color: white; border: none; padding: 5px 12px; border-radius: 5px; font-size: 12px;" onclick="viewSubmittedFile(1)">
                                            <i class="bx bx-file"></i> View File
                                        </button>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; text-align: center;">
                                        <button class="btn btn-sm" style="background: #f26e2c; color: white; border: none; padding: 5px 12px; border-radius: 5px; font-size: 12px;" onclick="viewStudentNote(1, 'Rahul Sharma')">
                                            <i class="bx bx-note"></i> Note
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px; vertical-align: middle;">2</td>
                                    <td style="padding: 12px; vertical-align: middle;">
                                        <div style="display: flex; align-items: center;">
                                            <span style="font-weight: 600; color: #212529;">Priya Patel</span>
                                        </div>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; color: #6c757d; font-size: 13px;">priya@example.com</td>
                                    <td style="padding: 12px; vertical-align: middle; color: #212529; font-size: 13px; font-weight: 500;">Create Landing Page</td>
                                    <td style="padding: 12px; vertical-align: middle;">
                                        <span class="badge" style="background: #ffc107; color: #000; padding: 6px 12px; font-size: 12px; border-radius: 20px;">
                                            <i class="bx bx-time"></i> Pending
                                        </span>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; text-align: center;">
                                        <span style="color: #6c757d; font-size: 12px;">-</span>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; text-align: center;">
                                        <span style="color: #6c757d; font-size: 12px;">-</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px; vertical-align: middle;">3</td>
                                    <td style="padding: 12px; vertical-align: middle;">
                                        <div style="display: flex; align-items: center;">
                                            <span style="font-weight: 600; color: #212529;">Amit Kumar</span>
                                        </div>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; color: #6c757d; font-size: 13px;">amit@example.com</td>
                                    <td style="padding: 12px; vertical-align: middle; color: #212529; font-size: 13px; font-weight: 500;">Create Landing Page</td>
                                    <td style="padding: 12px; vertical-align: middle;">
                                        <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; font-size: 12px; border-radius: 20px;">
                                            <i class="bx bx-check-circle"></i> Complete
                                        </span>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; text-align: center;">
                                        <button class="btn btn-sm" style="background: #6f42c1; color: white; border: none; padding: 5px 12px; border-radius: 5px; font-size: 12px;" onclick="viewSubmittedFile(3)">
                                            <i class="bx bx-file"></i> View File
                                        </button>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; text-align: center;">
                                        <button class="btn btn-sm" style="background: #f26e2c; color: white; border: none; padding: 5px 12px; border-radius: 5px; font-size: 12px;" onclick="viewStudentNote(3, 'Amit Kumar')">
                                            <i class="bx bx-note"></i> Note
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

              
            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 24px; border-radius: 6px; font-weight: 600;">
                    <i class="bx bx-x"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Student Note Modal -->
<div class="modal fade" id="studentNoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; ">
            <div class="modal-header" style="background: linear-gradient(135deg, #242a62 0%, #f26e2c 100%); color: white; padding: 20px 30px; border: none;">
                <div>
                    <h5 class="modal-title" style="color: #fff; margin: 0; font-size: 20px; font-weight: 700;">
                        <i class="bx bx-note"></i> Student Submission Note
                    </h5>
                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;" id="studentNoteName">Student: Rahul Sharma</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="background: #fff; border: none; font-size: 24px; color: white; opacity: 1; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                    <i class="bx bx-x" style="color:#000"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
                <!-- Student Info Card -->
                <div style="background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #242a62;">
                    <h6 style="color: #242a62; font-weight: 700; margin-bottom: 15px;">
                        <i class="bx bx-info-circle"></i> Submission Details
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; min-width: 140px; font-size: 13px;">Task Title:</span>
                                <span style="color: #212529; font-size: 13px; flex: 1;" id="noteTaskTitle">Create Landing Page</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; min-width: 140px; font-size: 13px;">Submitted On:</span>
                                <span style="color: #212529; font-size: 13px; flex: 1;" id="noteSubmitDate">08 Feb 2026, 3:45 PM</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; min-width: 140px; font-size: 13px;">Status:</span>
                                <span style="flex: 1;" id="noteStatus">
                                    <span class="badge" style="background: #28a745; color: white; padding: 4px 10px; font-size: 11px; border-radius: 12px;">
                                        <i class="bx bx-check-circle"></i> Submitted
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; min-width: 140px; font-size: 13px;">Submission File:</span>
                                <span style="flex: 1;" id="noteFile">
                                    <a href="#" class="badge bg-info" style="text-decoration: none;">
                                        <i class="bx bx-download"></i> landing_page.zip
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Student Note/Description -->
                <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #f26e2c;">
                    <h6 style="color: #242a62; font-weight: 700; margin-bottom: 15px;">
                        <i class="bx bx-message-detail"></i> Student's Note/Description
                    </h6>
                    <div style="background: #f8f9fa; border-radius: 8px; padding: 15px; min-height: 150px;" id="noteContent">
                        <p style="margin: 0; color: #495057; font-size: 14px; line-height: 1.6;">
                            I have completed the landing page design with all the required features:
                        </p>
                        <ul style="margin-top: 10px; color: #495057; font-size: 14px; line-height: 1.6;">
                            <li>Responsive design for mobile, tablet, and desktop</li>
                            <li>Hero section with call-to-action button</li>
                            <li>Features section with icons</li>
                            <li>Contact form with validation</li>
                            <li>Footer with social media links</li>
                        </ul>
                        <p style="margin-top: 10px; color: #495057; font-size: 14px; line-height: 1.6;">
                            Technologies used: HTML5, CSS3, Bootstrap 5, JavaScript. The project is fully responsive and cross-browser compatible.
                        </p>
                    </div>
                </div>

                <!-- Project Link (if provided) -->
                <div style="background: white; border-radius: 10px; padding: 20px; margin-top: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #17a2b8;">
                    <h6 style="color: #242a62; font-weight: 700; margin-bottom: 15px;">
                        <i class="bx bx-link"></i> Project Link
                    </h6>
                    <div style="background: #f8f9fa; border-radius: 8px; padding: 15px;" id="noteProjectLink">
                        <a href="https://example.com/rahul-landing-page" target="_blank" style="color: #17a2b8; font-size: 14px; text-decoration: none; font-weight: 500;">
                            <i class="bx bx-link-external"></i> https://example.com/rahul-landing-page
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 24px; border-radius: 6px; font-weight: 600;">
                    <i class="bx bx-x"></i> Close
                </button>
                <button type="button" class="btn" style="background: #28a745; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-check"></i> Approve Submission
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Details Modal -->
<div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #242a62 0%, #f26e2c 100%); color: white; padding: 20px 30px; border: none;">
                <div>
                    <h5 class="modal-title" style="color: #fff; margin: 0; font-size: 20px; font-weight: 700;">
                        <i class="bx bx-receipt"></i> Payment Transaction Details
                    </h5>
                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;" id="paymentTransactionId">Transaction ID: TXN_20260128_001</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="background: transparent; border: none; font-size: 24px; color: white; opacity: 1; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
                <!-- Transaction Status Badge -->
                <div class="text-center mb-4">
                    <div id="paymentStatusBadge" style="display: inline-block; background: #28a745; color: white; padding: 12px 30px; border-radius: 25px; font-size: 16px; font-weight: 700;">
                        <i class="bx bx-check-circle"></i> Payment Successful
                    </div>
                </div>

                <!-- Student Information -->
                <div style="background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #242a62;">
                    <h6 style="color: #242a62; font-weight: 700; margin-bottom: 15px;">
                        <i class="bx bx-user"></i> Student Information
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; font-size: 13px; min-width: 120px;">Student Name:</span>
                                <span style="color: #212529; font-size: 13px; font-weight: 500;" id="paymentStudentName">Rahul Sharma</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; font-size: 13px; min-width: 120px;">Email:</span>
                                <span style="color: #212529; font-size: 13px;" id="paymentStudentEmail">rahul@example.com</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; font-size: 13px; min-width: 120px;">Phone:</span>
                                <span style="color: #212529; font-size: 13px;" id="paymentStudentPhone">+91 98765 43210</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; font-size: 13px; min-width: 120px;">University:</span>
                                <span style="color: #212529; font-size: 13px;" id="paymentStudentUniversity">Gujarat University</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div style="background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #28a745;">
                    <h6 style="color: #242a62; font-weight: 700; margin-bottom: 15px;">
                        <i class="bx bx-money"></i> Payment Information
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; font-size: 13px; min-width: 140px;">Amount Paid:</span>
                                <span style="color: #28a745; font-size: 15px; font-weight: 700;" id="paymentAmount">₹2,360</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; font-size: 13px; min-width: 140px;">Payment Method:</span>
                                <span style="color: #212529; font-size: 13px; font-weight: 500;" id="paymentMethod">UPI</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; font-size: 13px; min-width: 140px;">Purchase Date:</span>
                                <span style="color: #212529; font-size: 13px;" id="paymentDate">28 Jan 2026</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; font-size: 13px; min-width: 140px;">Purchase Time:</span>
                                <span style="color: #212529; font-size: 13px;" id="paymentTime">10:30 AM</span>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; font-size: 13px; min-width: 140px;">Payment Status:</span>
                                <span id="paymentStatusText" style="color: #28a745; font-size: 13px; font-weight: 600;">✓ Success</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Details -->
                <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #17a2b8;">
                    <h6 style="color: #242a62; font-weight: 700; margin-bottom: 15px;">
                        <i class="bx bx-detail"></i> Transaction Details
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; font-size: 13px; min-width: 140px;">Base Fee:</span>
                                <span style="color: #212529; font-size: 13px;" id="paymentBaseFee">₹2,000</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; font-size: 13px; min-width: 140px;">GST (18%):</span>
                                <span style="color: #212529; font-size: 13px;" id="paymentGST">₹360</span>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div style="display: flex; padding: 8px 0; border-bottom: 1px solid #e9ecef;">
                                <span style="font-weight: 600; color: #6c757d; font-size: 13px; min-width: 140px;">Payment Gateway:</span>
                                <span style="color: #212529; font-size: 13px;" id="paymentGateway">Razorpay</span>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div style="display: flex; padding: 8px 0;">
                                <span style="font-weight: 600; color: #6c757d; font-size: 13px; min-width: 140px;">Gateway TXN ID:</span>
                                <span style="color: #212529; font-size: 13px; font-family: monospace;" id="paymentGatewayTxnId">pay_1234567890abcdef</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 24px; border-radius: 6px; font-weight: 600;">
                    <i class="bx bx-x"></i> Close
                </button>
                <button type="button" class="btn" onclick="viewReceipt()" style="background: #17a2b8; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-file-blank"></i> View Receipt
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; ">
            <div class="modal-header" style="background: linear-gradient(135deg, #242a62 0%, #f26e2c 100%); color: white; padding: 20px 30px; border: none;">
                <div>
                    <h5 class="modal-title" style="color: #fff; margin: 0; font-size: 20px; font-weight: 700;">
                        <i class="bx bx-receipt"></i> Payment Receipt
                    </h5>
                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;">Full-Stack Web Development Internship</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="background: #fff; border: none; font-size: 24px; color: white; opacity: 1; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                    <i class="bx bx-x" style="color: #000"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 0; background: white;">
                <!-- Receipt Content -->
                <div id="receiptContent" style="padding: 40px; background: white;">
                    <!-- Header Section -->
                    <div style="text-align: center; padding-bottom: 30px; border-bottom: 3px solid #242a62;">
                        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #242a62 0%, #f26e2c 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                <i class="bx bx-briefcase-alt-2" style="font-size: 32px; color: white;"></i>
                            </div>
                            <div style="text-align: left;">
                                <h3 style="margin: 0; color: #242a62; font-weight: 700; font-size: 24px;">ZobPot</h3>
                                <p style="margin: 0; color: #6c757d; font-size: 13px;">Job & Internship Portal</p>
                            </div>
                        </div>
                        <h4 style="color: #242a62; font-weight: 700; margin: 10px 0 5px 0; font-size: 20px;">PAYMENT RECEIPT</h4>
                        <p style="color: #6c757d; font-size: 13px; margin: 0;">Official receipt for internship enrollment</p>
                    </div>

                    <!-- Receipt Info Bar -->
                    <div style="background: #f8f9fa; padding: 15px; margin: 25px 0; border-radius: 8px; border-left: 4px solid #28a745;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <p style="margin: 0; color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase;">Receipt No.</p>
                                <p style="margin: 3px 0 0 0; color: #212529; font-size: 14px; font-weight: 700;" id="receiptNumber">RCP-20260128-001</p>
                            </div>
                            <div>
                                <p style="margin: 0; color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase;">Transaction ID</p>
                                <p style="margin: 3px 0 0 0; color: #212529; font-size: 14px; font-weight: 700;" id="receiptTxnId">TXN_20260128_001</p>
                            </div>
                            <div>
                                <p style="margin: 0; color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase;">Date</p>
                                <p style="margin: 3px 0 0 0; color: #212529; font-size: 14px; font-weight: 700;" id="receiptDate">28 Jan 2026</p>
                            </div>
                            <div>
                                <span style="background: #28a745; color: white; padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                                    <i class="bx bx-check-circle"></i> PAID
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Two Column Layout -->
                    <div class="row" style="margin-bottom: 25px;">
                        <!-- Bill To -->
                        <div class="col-md-6">
                            <div style="background: #fff; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; height: 100%;">
                                <h6 style="color: #242a62; font-weight: 700; font-size: 13px; margin-bottom: 15px; text-transform: uppercase;">
                                    <i class="bx bx-user"></i> Bill To
                                </h6>
                                <p style="margin: 0 0 5px 0; color: #212529; font-size: 15px; font-weight: 700;" id="receiptStudentName">Rahul Sharma</p>
                                <p style="margin: 0 0 3px 0; color: #6c757d; font-size: 13px;" id="receiptStudentEmail">rahul@example.com</p>
                                <p style="margin: 0 0 3px 0; color: #6c757d; font-size: 13px;" id="receiptStudentPhone">+91 98765 43210</p>
                                <p style="margin: 0; color: #6c757d; font-size: 13px;" id="receiptStudentUniversity">Gujarat University</p>
                            </div>
                        </div>  

                        <!-- Company Details -->
                        <div class="col-md-6">
                            <div style="background: #fff; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; height: 100%;">
                                <h6 style="color: #242a62; font-weight: 700; font-size: 13px; margin-bottom: 15px; text-transform: uppercase;">
                                    <i class="bx bx-building"></i> From
                                </h6>
                                <p style="margin: 0 0 5px 0; color: #212529; font-size: 15px; font-weight: 700;">CodeCraft Solutions</p>
                                <p style="margin: 0 0 3px 0; color: #6c757d; font-size: 13px;">123 Business Park, Tower A</p>
                                <p style="margin: 0 0 3px 0; color: #6c757d; font-size: 13px;">Ahmedabad, Gujarat 380015</p>
                                <p style="margin: 0 0 3px 0; color: #6c757d; font-size: 13px;">Email: info@codecraft.com</p>
                                <p style="margin: 0; color: #6c757d; font-size: 13px;">GSTIN: 24XXXXX1234X1ZX</p>
                            </div>
                        </div>
                    </div>

                    <!-- Internship Details -->
                    <div style="background: #f8f9fa; border-radius: 8px; padding: 20px; margin-bottom: 25px;">
                        <h6 style="color: #242a62; font-weight: 700; font-size: 13px; margin-bottom: 15px; text-transform: uppercase;">
                            <i class="bx bx-briefcase"></i> Internship Details
                        </h6>
                        <div class="row">
                            <div class="col-md-8">
                                <p style="margin: 0 0 8px 0; color: #212529; font-size: 15px; font-weight: 700;">Full-Stack Web Development Internship</p>
                                <p style="margin: 0 0 5px 0; color: #6c757d; font-size: 13px;"><strong>Duration:</strong> 3 Months (10 Mar 2026 - 10 Jun 2026)</p>
                                <p style="margin: 0 0 5px 0; color: #6c757d; font-size: 13px;"><strong>Mode:</strong> Hybrid</p>
                                <p style="margin: 0; color: #6c757d; font-size: 13px;"><strong>Enrollment Date:</strong> 28 Jan 2026</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <span style="background: #17a2b8; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                    <i class="bx bx-check"></i> Enrolled
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Breakdown Table -->
                    <div style="margin-bottom: 25px;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: #242a62;">
                                    <th style="padding: 12px; text-align: left; color: white; font-size: 13px; font-weight: 600;">Description</th>
                                    <th style="padding: 12px; text-align: center; color: white; font-size: 13px; font-weight: 600;">HSN/SAC</th>
                                    <th style="padding: 12px; text-align: right; color: white; font-size: 13px; font-weight: 600;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px; color: #212529; font-size: 13px;">Internship Enrollment Fee</td>
                                    <td style="padding: 12px; text-align: center; color: #6c757d; font-size: 13px;">999293</td>
                                    <td style="padding: 12px; text-align: right; color: #212529; font-size: 13px; font-weight: 600;">₹2,000.00</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px; color: #212529; font-size: 13px;">GST @ 18%</td>
                                    <td style="padding: 12px; text-align: center; color: #6c757d; font-size: 13px;">-</td>
                                    <td style="padding: 12px; text-align: right; color: #212529; font-size: 13px; font-weight: 600;">₹360.00</td>
                                </tr>
                                <tr style="background: #f8f9fa; border-top: 2px solid #242a62;">
                                    <td colspan="2" style="padding: 15px; color: #242a62; font-size: 15px; font-weight: 700;">Total Amount Paid</td>
                                    <td style="padding: 15px; text-align: right; color: #28a745; font-size: 18px; font-weight: 700;" id="receiptTotalAmount">₹2,360.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment Method Info -->
                    <div style="background: #fff5f0; border-radius: 8px; padding: 15px; margin-bottom: 25px; border-left: 4px solid #f26e2c;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <p style="margin: 0; color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase;">Payment Method</p>
                                <p style="margin: 3px 0 0 0; color: #212529; font-size: 14px; font-weight: 700;" id="receiptPaymentMethod">UPI</p>
                            </div>
                            <div>
                                <p style="margin: 0; color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase;">Payment Gateway</p>
                                <p style="margin: 3px 0 0 0; color: #212529; font-size: 14px; font-weight: 700;" id="receiptGateway">Razorpay</p>
                            </div>
                            <div>
                                <p style="margin: 0; color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase;">Gateway TXN ID</p>
                                <p style="margin: 3px 0 0 0; color: #212529; font-size: 12px; font-family: monospace; font-weight: 600;" id="receiptGatewayTxnId">pay_1234567890abcdef</p>
                            </div>
                        </div>
                    </div>

                    <!-- Amount in Words -->
                    <div style="background: #f8f9fa; padding: 12px; border-radius: 6px; margin-bottom: 25px;">
                        <p style="margin: 0; color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase;">Amount in Words</p>
                        <p style="margin: 3px 0 0 0; color: #212529; font-size: 14px; font-weight: 600;">Two Thousand Three Hundred Sixty Rupees Only</p>
                    </div>

                    <!-- Terms & Footer -->
                    <div style="border-top: 2px dashed #dee2e6; padding-top: 20px;">
                        <div style="margin-bottom: 15px;">
                            <p style="margin: 0 0 8px 0; color: #242a62; font-size: 13px; font-weight: 700;">Terms & Conditions:</p>
                            <ul style="margin: 0; padding-left: 20px; color: #6c757d; font-size: 12px; line-height: 1.8;">
                                <li>This receipt is computer generated and does not require a signature.</li>
                                <li>All payments are non-refundable once the internship has commenced.</li>
                                <li>Please retain this receipt for your records.</li>
                                <li>For any queries, contact us at support@zobpot.com</li>
                            </ul>
                        </div>
                        <div style="text-align: center; padding-top: 15px; border-top: 1px solid #dee2e6;">
                            <p style="margin: 0; color: #6c757d; font-size: 11px;">Thank you for enrolling with ZobPot!</p>
                            <p style="margin: 5px 0 0 0; color: #6c757d; font-size: 11px;">Generated on: <span id="receiptGeneratedDate">03 Feb 2026, 10:30 AM</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #f8f9fa; padding: 20px 30px; border-top: 1px solid #dee2e6;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 24px; border-radius: 6px; font-weight: 600;">
                    <i class="bx bx-x"></i> Close
                </button>
                <button type="button" class="btn" onclick="printReceipt()" style="background: #6f42c1; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-printer"></i> Print Receipt
                </button>
                <button type="button" class="btn" onclick="downloadReceiptPDF()" style="background: #28a745; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-download"></i> Download PDF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Update Instructions Modal -->
<div class="modal fade" id="instructionsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-view">
                <div>
                    <h5 class="modal-title" style="color: #fff;">
                        <i class="bx bx-edit"></i> Update General Instructions
                    </h5>
                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;">Edit the general instructions for students</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="background: #fff;">
                    <i class="bx bx-x" style="color: #000"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <form id="instructionsForm">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600;">Instructions Content</label>
                        <textarea id="instructionsEditor" name="instructions"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background: #f8f9fa; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn btn-success" onclick="saveInstructions()">
                    <i class="bx bx-save"></i> Save Instructions
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal for Complete Internship -->
<div class="modal fade confirmation-modal" id="confirmCompleteModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-exclamation-triangle"></i> Confirm Internship Completion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="confirmation-icon">
                    <i class="fa fa-question-circle"></i>
                </div>
                <div class="confirmation-text">
                    <strong>Are you sure you want to complete this internship?</strong>
                    <p style="margin-top: 12px; font-size: 14px;">
                        This action will finalize all student evaluations and submit their grades. 
                        Once confirmed, you will not be able to modify the marks or feedback.
                    </p>
                    <div style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 12px; margin-top: 16px; text-align: left;">
                        <i class="fa fa-info-circle" style="color: #856404;"></i>
                        <small style="color: #856404; margin-left: 8px;">
                            Please review all entries carefully before proceeding.
                        </small>
                    </div>
                </div>
                <div class="confirmation-actions">
                    <button type="button" class="btn btn-confirm-no" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-confirm-yes" onclick="confirmCompletion()">
                        <i class="fa fa-check"></i> Yes, Complete Internship
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<!-- Include CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    let instructionsEditor;
    let taskDescriptionEditor;

    // Payment Data - Sample transactions
    const paymentData = {
        'TXN_20260128_001': {
            transactionId: 'TXN_20260128_001',
            studentName: 'Rahul Sharma',
            email: 'rahul@example.com',
            phone: '+91 98765 43210',
            university: 'Gujarat University',
            amount: '₹2,360.00',
            baseFee: '₹2,000.00',
            gst: '₹360.00',
            paymentMethod: 'UPI',
            paymentDate: '28 Jan 2026',
            paymentTime: '10:30 AM',
            paymentGateway: 'Razorpay',
            gatewayTxnId: 'pay_1234567890abcdef',
            status: 'Success'
        },
        'TXN_20260129_002': {
            transactionId: 'TXN_20260129_002',
            studentName: 'Priya Patel',
            email: 'priya@example.com',
            phone: '+91 98765 43211',
            university: 'Mumbai University',
            amount: '₹2,360.00',
            baseFee: '₹2,000.00',
            gst: '₹360.00',
            paymentMethod: 'Credit Card',
            paymentDate: '29 Jan 2026',
            paymentTime: '2:15 PM',
            paymentGateway: 'Razorpay',
            gatewayTxnId: 'pay_2345678901bcdefg',
            status: 'Success'
        },
        'TXN_20260130_003': {
            transactionId: 'TXN_20260130_003',
            studentName: 'Amit Kumar',
            email: 'amit@example.com',
            phone: '+91 98765 43212',
            university: 'Delhi University',
            amount: '₹2,360.00',
            baseFee: '₹2,000.00',
            gst: '₹360.00',
            paymentMethod: 'Net Banking',
            paymentDate: '30 Jan 2026',
            paymentTime: '4:45 PM',
            paymentGateway: 'Razorpay',
            gatewayTxnId: 'pay_3456789012cdefgh',
            status: 'Success'
        }
    };

    $(document).ready(function() {
        // Initialize DataTables
        $('#StudentsTable').DataTable({
            order: [[0, 'asc']],
            pageLength: 10
        });

        $('#TasksTable').DataTable({
            order: [[3, 'desc']],
            pageLength: 10
        });

        $('#PaymentTable').DataTable({
            order: [[5, 'desc']],
            pageLength: 10,
            drawCallback: function() {
                // Re-attach event handlers after DataTables redraw
                console.log('DataTable redrawn');
            }
        });
    });

    // Open Add Task Modal
    window.openAddTaskModal = function() {
        const addTaskModal = new bootstrap.Modal(document.getElementById('addTaskModal'));
        addTaskModal.show();
        
        // Initialize CKEditor for task description
        if (!taskDescriptionEditor) {
            ClassicEditor
                .create(document.querySelector('#taskDescriptionEditor'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'blockQuote', 'insertTable', '|', 'imageUpload', '|', 'undo', 'redo']
                })
                .then(editor => {
                    taskDescriptionEditor = editor;
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }

    // Save Task
    window.saveTask = function() {
        const form = document.getElementById('addTaskForm');
        
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        if (taskDescriptionEditor) {
            const formData = new FormData();
            formData.append('task_datetime', document.getElementById('taskDateTime').value);
            formData.append('task_day', document.getElementById('taskDay').value);
            formData.append('module_title', document.getElementById('moduleTitle').value);
            formData.append('task_description', taskDescriptionEditor.getData());
            formData.append('last_submission_date', document.getElementById('lastSubmissionDate').value);
            formData.append('online_link', document.getElementById('onlineLink').value);
            formData.append('is_final_assignment', document.getElementById('isFinalAssignment').checked ? 1 : 0);
            
            // Handle file upload
            const fileInput = document.getElementById('taskFile');
            if (fileInput.files.length > 0) {
                formData.append('task_file', fileInput.files[0]);
            }

            console.log('Saving task:', Object.fromEntries(formData));
            
            // In production, send to server
            // $.ajax({
            //     url: '/admin/internship/task/store',
            //     method: 'POST',
            //     data: formData,
            //     processData: false,
            //     contentType: false,
            //     success: function(response) {
            //         $('#addTaskModal').modal('hide');
            //         alert('✅ Task added successfully!');
            //         location.reload();
            //     },
            //     error: function(error) {
            //         alert('❌ Error saving task. Please try again.');
            //     }
            // });

            const addTaskModal = bootstrap.Modal.getInstance(document.getElementById('addTaskModal'));
            if (addTaskModal) {
                addTaskModal.hide();
            }
            alert('✅ Task added successfully!');
            form.reset();
            taskDescriptionEditor.setData('');
        }
    }

    // Open Instructions Modal
    window.openInstructionsModal = function() {
        const instructionsModal = new bootstrap.Modal(document.getElementById('instructionsModal'));
        instructionsModal.show();
        
        // Initialize CKEditor
        if (!instructionsEditor) {
            ClassicEditor
                .create(document.querySelector('#instructionsEditor'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'blockQuote', 'insertTable', '|', 'undo', 'redo']
                })
                .then(editor => {
                    instructionsEditor = editor;
                    // Set existing content
                    editor.setData(document.getElementById('instructionsContent').innerHTML);
                })
                .catch(error => {
                    console.error(error);
                });
        } else {
            instructionsEditor.setData(document.getElementById('instructionsContent').innerHTML);
        }
    }

    // Save Instructions
    window.saveInstructions = function() {
        if (instructionsEditor) {
            const content = instructionsEditor.getData();
            
            console.log('Saving instructions:', content);
            
            // In production, send to server
            // $.ajax({
            //     url: '/admin/internship/update-instructions',
            //     method: 'POST',
            //     data: {
            //         internship_id: 1,
            //         instructions: content
            //     },
            //     success: function(response) {
            //         document.getElementById('instructionsContent').innerHTML = content;
            //         $('#instructionsModal').modal('hide');
            //         alert('✅ Instructions updated successfully!');
            //     }
            // });

            document.getElementById('instructionsContent').innerHTML = content;
            const instructionsModal = bootstrap.Modal.getInstance(document.getElementById('instructionsModal'));
            if (instructionsModal) {
                instructionsModal.hide();
            }
            alert('✅ Instructions updated successfully!');
        }
    }

    // View Payment Details - Opens Receipt Modal Directly
    window.viewPaymentDetails = function(transactionId) {
        // Get payment details
        const payment = paymentData[transactionId] || paymentData['TXN_20260128_001'];

        // Update receipt modal content directly
        document.getElementById('receiptNumber').textContent = 'RCP-' + payment.transactionId.replace('TXN_', '');
        document.getElementById('receiptTxnId').textContent = payment.transactionId;
        document.getElementById('receiptDate').textContent = payment.paymentDate;
        document.getElementById('receiptStudentName').textContent = payment.studentName;
        document.getElementById('receiptStudentEmail').textContent = payment.email;
        document.getElementById('receiptStudentPhone').textContent = payment.phone;
        document.getElementById('receiptStudentUniversity').textContent = payment.university;
        document.getElementById('receiptTotalAmount').textContent = payment.amount;
        document.getElementById('receiptPaymentMethod').textContent = payment.paymentMethod;
        document.getElementById('receiptGateway').textContent = payment.paymentGateway;
        document.getElementById('receiptGatewayTxnId').textContent = payment.gatewayTxnId;

        // Set generated date to current date/time
        const now = new Date();
        const generatedDate = now.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) + ', ' + 
                             now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
        document.getElementById('receiptGeneratedDate').textContent = generatedDate;

        // Open receipt modal directly - Bootstrap 5 syntax
        const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
        receiptModal.show();

        console.log('Opening receipt for transaction:', transactionId);
    }

    // View Receipt
    window.viewReceipt = function() {
        // Get current payment details from the payment details modal
        const transactionId = document.getElementById('paymentTransactionId').textContent.replace('Transaction ID: ', '');
        const studentName = document.getElementById('paymentStudentName').textContent;
        const email = document.getElementById('paymentStudentEmail').textContent;
        const phone = document.getElementById('paymentStudentPhone').textContent;
        const university = document.getElementById('paymentStudentUniversity').textContent;
        const amount = document.getElementById('paymentAmount').textContent;
        const paymentMethod = document.getElementById('paymentMethod').textContent;
        const paymentDate = document.getElementById('paymentDate').textContent;
        const gateway = document.getElementById('paymentGateway').textContent;
        const gatewayTxnId = document.getElementById('paymentGatewayTxnId').textContent;

        // Update receipt modal content
        document.getElementById('receiptNumber').textContent = 'RCP-' + transactionId.replace('TXN_', '');
        document.getElementById('receiptTxnId').textContent = transactionId;
        document.getElementById('receiptDate').textContent = paymentDate;
        document.getElementById('receiptStudentName').textContent = studentName;
        document.getElementById('receiptStudentEmail').textContent = email;
        document.getElementById('receiptStudentPhone').textContent = phone;
        document.getElementById('receiptStudentUniversity').textContent = university;
        document.getElementById('receiptTotalAmount').textContent = amount;
        document.getElementById('receiptPaymentMethod').textContent = paymentMethod;
        document.getElementById('receiptGateway').textContent = gateway;
        document.getElementById('receiptGatewayTxnId').textContent = gatewayTxnId;

        // Set generated date to current date/time
        const now = new Date();
        const generatedDate = now.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) + ', ' + 
                             now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
        document.getElementById('receiptGeneratedDate').textContent = generatedDate;

        // Close payment details modal and open receipt modal
        const paymentModalEl = document.getElementById('paymentDetailsModal');
        const paymentModal = bootstrap.Modal.getInstance(paymentModalEl);
        if (paymentModal) {
            paymentModal.hide();
        }
        
        setTimeout(() => {
            const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
            receiptModal.show();
        }, 300);

        console.log('Opening receipt for transaction:', transactionId);
    }

    // Print Receipt
    window.printReceipt = function() {
        const receiptContent = document.getElementById('receiptContent').innerHTML;
        const printWindow = window.open('', '_blank', 'width=800,height=600');
        
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Payment Receipt</title>
                <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    @media print {
                        body { margin: 0; }
                        button { display: none; }
                    }
                </style>
            </head>
            <body>
                ${receiptContent}
            </body>
            </html>
        `);
        
        printWindow.document.close();
        printWindow.focus();
        
        setTimeout(() => {
            printWindow.print();
        }, 500);

        console.log('Printing receipt...');
    }

    // Download Receipt as PDF
    window.downloadReceiptPDF = function() {
        alert('PDF download functionality will be implemented with backend integration.\n\nIn production, this will:\n1. Generate a PDF using a library (like FPDF or DomPDF)\n2. Include company logo and digital signature\n3. Download with proper filename format');
        
        // In production, make AJAX call to generate PDF
        // const transactionId = document.getElementById('receiptTxnId').textContent;
        // window.location.href = '/admin/internship/payment/receipt/pdf/' + transactionId;
        
        console.log('Download PDF clicked');
    }

    // View Student Details
    window.viewStudentDetails = function(studentId) {
        alert('View student details for ID: ' + studentId);
    }

    // Edit Task
    window.editTask = function(taskId) {
        alert('Edit task ID: ' + taskId);
    }

    // View Submissions
    window.viewSubmissions = function(taskId) {
        // Sample data - In production, fetch from server
        const taskData = {
            1: {
                title: 'Create Landing Page',
                students: [
                    { id: 1, name: 'Rahul Sharma', email: 'rahul@example.com', status: 'complete', initial: 'R', color: 'linear-gradient(135deg, #242a62, #3a4282)' },
                    { id: 2, name: 'Priya Patel', email: 'priya@example.com', status: 'pending', initial: 'P', color: 'linear-gradient(135deg, #f26e2c, #ff8548)' },
                    { id: 3, name: 'Amit Kumar', email: 'amit@example.com', status: 'complete', initial: 'A', color: 'linear-gradient(135deg, #6f42c1, #8c5dd8)' }
                ]
            },
            2: {
                title: 'API Integration',
                students: [
                    { id: 1, name: 'Rahul Sharma', email: 'rahul@example.com', status: 'pending', initial: 'R', color: 'linear-gradient(135deg, #242a62, #3a4282)' },
                    { id: 2, name: 'Priya Patel', email: 'priya@example.com', status: 'pending', initial: 'P', color: 'linear-gradient(135deg, #f26e2c, #ff8548)' },
                    { id: 3, name: 'Amit Kumar', email: 'amit@example.com', status: 'pending', initial: 'A', color: 'linear-gradient(135deg, #6f42c1, #8c5dd8)' }
                ]
            }
        };

        // Get task data
        const task = taskData[taskId] || taskData[1];
        
        // Update modal title
        document.getElementById('taskTitleSubmission').textContent = 'Task: ' + task.title;
        
        // Calculate statistics
        const completedCount = task.students.filter(s => s.status === 'complete').length;
        const pendingCount = task.students.filter(s => s.status === 'pending').length;
        const totalCount = task.students.length;
        
        // Update statistics
        document.getElementById('submissionSummary').textContent = completedCount + '/' + totalCount + ' Submitted';
        document.getElementById('completedCount').textContent = completedCount;
        document.getElementById('pendingCount').textContent = pendingCount;
        document.getElementById('totalCount').textContent = totalCount;
        
        // Build table rows
        let tableRows = '';
        task.students.forEach((student, index) => {
            const statusBadge = student.status === 'complete' 
                ? '<span class="badge" style="background: #28a745; color: white; padding: 6px 12px; font-size: 12px; border-radius: 20px;"><i class="bx bx-check-circle"></i> Complete</span>'
                : '<span class="badge" style="background: #ffc107; color: #000; padding: 6px 12px; font-size: 12px; border-radius: 20px;"><i class="bx bx-time"></i> Pending</span>';
            
            const viewFileButton = student.status === 'complete'
                ? '<button class="btn btn-sm" style="background: #6f42c1; color: white; border: none; padding: 5px 12px; border-radius: 5px; font-size: 12px;" onclick="viewSubmittedFile(' + student.id + ')"><i class="bx bx-file"></i> View File</button>'
                : '<span style="color: #6c757d; font-size: 12px;">-</span>';
            
            const noteButton = student.status === 'complete'
                ? '<button class="btn btn-sm" style="background: #f26e2c; color: white; border: none; padding: 5px 12px; border-radius: 5px; font-size: 12px;" onclick="viewStudentNote(' + student.id + ', \'' + student.name + '\')"><i class="bx bx-note"></i> Note</button>'
                : '<span style="color: #6c757d; font-size: 12px;">-</span>';
            
            tableRows += `
                <tr>
                    <td style="padding: 12px; vertical-align: middle;">${index + 1}</td>
                    <td style="padding: 12px; vertical-align: middle;">
                        <div style="display: flex; align-items: center;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: ${student.color}; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; margin-right: 10px;">
                                ${student.initial}
                            </div>
                            <span style="font-weight: 600; color: #212529;">${student.name}</span>
                        </div>
                    </td>
                    <td style="padding: 12px; vertical-align: middle; color: #6c757d; font-size: 13px;">${student.email}</td>
                    <td style="padding: 12px; vertical-align: middle; color: #212529; font-size: 13px; font-weight: 500;">${task.title}</td>
                    <td style="padding: 12px; vertical-align: middle;">${statusBadge}</td>
                    <td style="padding: 12px; vertical-align: middle; text-align: center;">${viewFileButton}</td>
                    <td style="padding: 12px; vertical-align: middle; text-align: center;">${noteButton}</td>
                </tr>
            `;
        });
        
        // Update table body
        document.getElementById('submissionTableBody').innerHTML = tableRows;
        
        // Show modal
        const submissionsModal = new bootstrap.Modal(document.getElementById('viewSubmissionsModal'));
        submissionsModal.show();
        
        // In production, fetch real data from server
        // $.ajax({
        //     url: '/admin/internship/task/submissions/' + taskId,
        //     method: 'GET',
        //     success: function(response) {
        //         // Update modal with real data
        //     }
        // });
    }

    // View Submitted File
    window.viewSubmittedFile = function(studentId) {
        alert('Opening submitted file for student ID: ' + studentId);
        // In production, download or open the submitted file
        // window.open('/admin/internship/submission/file/' + studentId, '_blank');
    }

    // View Student Note
    window.viewStudentNote = function(studentId, studentName) {
        // Sample data - In production, fetch from server
        const noteData = {
            1: {
                studentName: 'Rahul Sharma',
                taskTitle: 'Create Landing Page',
                submitDate: '08 Feb 2026, 3:45 PM',
                status: 'Submitted',
                fileName: 'landing_page.zip',
                note: `I have completed the landing page design with all the required features:
                <ul style="margin-top: 10px;">
                    <li>Responsive design for mobile, tablet, and desktop</li>
                    <li>Hero section with call-to-action button</li>
                    <li>Features section with icons</li>
                    <li>Contact form with validation</li>
                    <li>Footer with social media links</li>
                </ul>
                <p style="margin-top: 10px;">Technologies used: HTML5, CSS3, Bootstrap 5, JavaScript. The project is fully responsive and cross-browser compatible.</p>`,
                projectLink: 'https://example.com/rahul-landing-page'
            },
            3: {
                studentName: 'Amit Kumar',
                taskTitle: 'Create Landing Page',
                submitDate: '09 Feb 2026, 11:20 AM',
                status: 'Submitted',
                fileName: 'amit_landing_page.zip',
                note: `I have successfully created a modern and responsive landing page. Key features include:
                <ul style="margin-top: 10px;">
                    <li>Clean and modern UI design</li>
                    <li>Smooth scroll animations</li>
                    <li>Mobile-first approach</li>
                    <li>SEO optimized</li>
                    <li>Fast loading time</li>
                </ul>
                <p style="margin-top: 10px;">Used latest web technologies and best practices for optimal performance.</p>`,
                projectLink: 'https://example.com/amit-landing-page'
            }
        };

        const data = noteData[studentId] || noteData[1];
        
        // Update modal content
        document.getElementById('studentNoteName').textContent = 'Student: ' + data.studentName;
        document.getElementById('noteTaskTitle').textContent = data.taskTitle;
        document.getElementById('noteSubmitDate').textContent = data.submitDate;
        document.getElementById('noteContent').innerHTML = '<p style="margin: 0; color: #495057; font-size: 14px; line-height: 1.6;">' + data.note + '</p>';
        document.getElementById('noteProjectLink').innerHTML = '<a href="' + data.projectLink + '" target="_blank" style="color: #17a2b8; font-size: 14px; text-decoration: none; font-weight: 500;"><i class="bx bx-link-external"></i> ' + data.projectLink + '</a>';
        
        // Show modal
        const studentNoteModal = new bootstrap.Modal(document.getElementById('studentNoteModal'));
        studentNoteModal.show();
        
        // In production, fetch from server
        // $.ajax({
        //     url: '/admin/internship/submission/note/' + studentId,
        //     method: 'GET',
        //     success: function(response) {
        //         // Update modal with real data
        //     }
        // });
    }

    // View Payment Details
   

    // Complete Internship
    window.completeInternship = function() {
        if (confirm('⚠️ Are you sure you want to mark this internship as complete?\n\nThis will:\n- Generate certificates for all students\n- Close enrollment\n- Archive the internship\n\nThis action cannot be undone.')) {
            console.log('Completing internship...');
            
            // In production
            // $.ajax({
            //     url: '/admin/internship/complete',
            //     method: 'POST',
            //     data: { internship_id: 1 },
            //     success: function(response) {
            //         alert('✅ Internship completed successfully!\n\nCertificates have been generated and sent to all students.');
            //         window.location.href = '/admin/internship-management';
            //     }
            // });

            alert('✅ Internship completed successfully!\n\nCertificates have been generated and sent to all students.');
        }
    }

    // Calculate marks for each student row
    function calculateMarks(row) {
        const inputs = row.querySelectorAll('.industry-mark');
        let total = 0;
        let maxTotal = 0;

        inputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            const max = parseFloat(input.getAttribute('data-max')) || 0;
            
            // Validate input
            if (value > max) {
                input.value = max;
                total += max;
            } else {
                total += value;
            }
            maxTotal += max;
        });

        // Calculate percentage
        const percentage = maxTotal > 0 ? ((total / maxTotal) * 100).toFixed(2) : 0;

        // Determine grade
        let grade = '-';
        let gradeClass = 'grade-F';
        
        if (percentage >= 90) {
            grade = 'A+';
            gradeClass = 'grade-A';
        } else if (percentage >= 80) {
            grade = 'A';
            gradeClass = 'grade-A';
        } else if (percentage >= 70) {
            grade = 'B';
            gradeClass = 'grade-B';
        } else if (percentage >= 60) {
            grade = 'C';
            gradeClass = 'grade-C';
        } else if (percentage >= 50) {
            grade = 'D';
            gradeClass = 'grade-D';
        } else if (percentage > 0) {
            grade = 'F';
            gradeClass = 'grade-F';
        }

        // Update display
        row.querySelector('.total-display').textContent = `${total}/ ${maxTotal}`;
        row.querySelector('.percentage-display').textContent = `${percentage}%`;
        
        const gradeBadge = row.querySelector('.grade-badge');
        gradeBadge.textContent = grade;
        gradeBadge.className = `grade-badge ${gradeClass}`;
    }

    // Add event listeners to all marks inputs
    document.querySelectorAll('.complete-internship-table tbody tr').forEach(row => {
        row.querySelectorAll('.industry-mark').forEach(input => {
            input.addEventListener('input', () => {
                calculateMarks(row);
            });

            input.addEventListener('blur', () => {
                const max = parseFloat(input.getAttribute('data-max'));
                const value = parseFloat(input.value) || 0;
                if (value > max) {
                    input.value = max;
                    calculateMarks(row);
                }
            });
        });
    });

    // Show confirmation modal
    window.showConfirmModal = function() {
        // Validate that all required fields are filled
        const rows = document.querySelectorAll('.complete-internship-table tbody tr');
        let allFilled = true;
        
        rows.forEach(row => {
            const inputs = row.querySelectorAll('.industry-mark');
            const feedback = row.querySelector('.feedback-textarea');
            
            inputs.forEach(input => {
                if (!input.value || input.value === '0') {
                    allFilled = false;
                }
            });
            
            if (!feedback.value.trim()) {
                allFilled = false;
            }
        });

        if (!allFilled) {
            alert('Please fill in all marks and feedback for all students before submitting!');
            return;
        }

        // Show confirmation modal
        const modal = new bootstrap.Modal(document.getElementById('confirmCompleteModal'));
        modal.show();
    }

    // Confirm and submit completion
    window.confirmCompletion = function() {
        // Collect all data
        const rows = document.querySelectorAll('.complete-internship-table tbody tr');
        const studentsData = [];

        rows.forEach(row => {
            const studentId = row.getAttribute('data-student-id');
            const marks = {};
            
            row.querySelectorAll('.industry-mark').forEach(input => {
                const field = input.getAttribute('data-field');
                marks[field] = parseFloat(input.value) || 0;
            });

            const feedback = row.querySelector('.feedback-textarea').value;
            const total = row.querySelector('.total-display').textContent;
            const percentage = row.querySelector('.percentage-display').textContent;
            const grade = row.querySelector('.grade-badge').textContent;

            studentsData.push({
                studentId: studentId,
                marks: marks,
                feedback: feedback,
                total: total,
                percentage: percentage,
                grade: grade
            });
        });

        console.log('Submitting completion data:', studentsData);

        // Here you would send data to server via AJAX
        // Example:
        // $.ajax({
        //     url: '/admin/internship/complete-submission',
        //     method: 'POST',
        //     data: { students: studentsData },
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     success: function(response) {
        //         alert('✅ Internship completed successfully! Student grades have been submitted.');
        //         location.reload();
        //     },
        //     error: function(error) {
        //         alert('❌ Error completing internship. Please try again.');
        //     }
        // });

        // For now, just show success message
        bootstrap.Modal.getInstance(document.getElementById('confirmCompleteModal')).hide();
        
        alert('✅ Internship completed successfully! Student grades have been submitted.');
        
        // Disable all inputs after submission
        document.querySelectorAll('.marks-input, .feedback-textarea').forEach(input => {
            input.disabled = true;
        });
        document.querySelector('.btn-complete-internship-submit').disabled = true;
    }

    // Export to Excel function
    window.exportToExcel = function() {
        // Get table
        const table = document.querySelector('.complete-internship-table');
        const clone = table.cloneNode(true);
        
        // Remove input elements and replace with values
        clone.querySelectorAll('.industry-mark').forEach(input => {
            const span = document.createElement('span');
            span.textContent = input.value || '0';
            input.parentNode.replaceChild(span, input);
        });

        clone.querySelectorAll('.feedback-textarea').forEach(textarea => {
            const span = document.createElement('span');
            span.textContent = textarea.value || '';
            textarea.parentNode.replaceChild(span, textarea);
        });

        // Create workbook
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.table_to_sheet(clone);
        
        XLSX.utils.book_append_sheet(wb, ws, 'Internship Completion');
        
        // Save file
        XLSX.writeFile(wb, 'internship_completion_marks.xlsx');
    }
</script>

<!-- Include XLSX library for Excel export -->
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

@endpush
