@extends('website.layout.layout')
@section('website-content')

<style>
    /* Internship Application History Page Styles */
    .internship-history-header {
        background: #242a62;
        border-radius: 12px;
        padding: 40px;
        margin-bottom: 30px;
        color: white;
        box-shadow: 0 4px 20px rgba(36, 42, 98, 0.3);
    }

    .internship-history-header h2 {
        margin: 0 0 10px 0;
        font-size: 32px;
        font-weight: 700;
    }

    .internship-history-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 16px;
    }

    /* Tab Navigation */
    .nav-tabs-internship-history {
        background: #fff;
        border-radius: 12px 12px 0 0;
        padding: 15px 20px 0 20px;
        border-bottom: 3px solid #242a62;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .nav-tabs-internship-history .nav-link {
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

    .nav-tabs-internship-history .nav-link:hover {
        color: #242a62;
        background: #fff5f0;
    }

    .nav-tabs-internship-history .nav-link.active {
        color: #242a62;
        background: transparent;
        border-bottom-color: #f26e2c;
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

    /* Table Styles */
    .table-internship-view .table-hover tbody tr:hover {
        background-color: #fff5f0;
    }

    .table-internship-view thead {
        background: #f8f9fa;
        border-bottom: 2px solid #242a62;
    }

    .table-internship-view thead th {
        font-weight: 600;
        color: #242a62;
        font-size: 13px;
        padding: 12px;
        border: none;
    }

    .table-internship-view tbody td {
        padding: 12px;
        vertical-align: middle;
        font-size: 13px;
    }

    /* Internship Application Card */
    .application-card {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border-left: 4px solid #242a62;
        transition: all 0.3s ease;
    }

    .application-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        transform: translateY(-3px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 80px;
        color: #dee2e6;
        margin-bottom: 20px;
    }

    .empty-state h4 {
        color: #6c757d;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #adb5bd;
        margin-bottom: 30px;
    }

    /* Progress Bar */
    .progress-container {
        margin-top: 15px;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        font-size: 13px;
        color: #495057;
        font-weight: 600;
    }

    .progress-bar-custom {
        height: 10px;
        border-radius: 5px;
        background: #e9ecef;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, # 0%, #f26e2c 100%);
        transition: width 0.3s ease;
    }

    /* Modal Styles */
    .modal-header-history {
        background: #242a62;
        color: white;
        padding: 20px 30px;
    }

    .modal-header-history h5 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
    }

    .modal-header-history p {
     color: #fff;
    }

    .modal-header-history .btn-close {
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


    .modal-header-history .btn-close i {
        color: #000;
    }

    .modal-header-history .btn-close:hover {
        opacity: 0.8;
        background: #fff;
        border-radius: 4px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .internship-history-header {
            padding: 30px 20px;
        }

        .internship-history-header h2 {
            font-size: 24px;
        }

        .detail-row-view {
            flex-direction: column;
            gap: 5px;
        }

        .detail-label-view {
            min-width: auto;
        }

        .table-responsive {
            font-size: 12px;
        }
    }


    .modal-title{
        color: #fff!important;
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

    .btn-complete-internship {
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

    .btn-complete-internship:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    }

    .btn-complete-internship:disabled {
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

<main class="main">
    <section class="section-box">
        <div class="container">
            <!-- Page Header -->
            <div class="internship-history-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 style="color: #fff;"><i class="bx bx-history"></i> My Internship Applications</h2>
                        <p style="color: #fff;">Track and manage your internship application history</p>
                    </div>
                    <a href="{{ route('/') }}" class="btn" style="background: white; color: #242a62; padding: 12px 24px; border-radius: 8px; font-weight: 600;">
                        <i class="bx bx-arrow-back"></i> Back to Home
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <!-- Total Students Card -->
                <div class="col-md-3 mb-3">
                    <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #17a2b8; height: 100%; background-color: #eee;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Students</p>
                                <h4 style="margin: 5px 0 0 0; color: #17a2b8; font-weight: 700; font-size: 24px;">3</h4>
                            </div>
                            <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(23, 162, 184, 0.1); display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-users" style="font-size: 28px; color: #17a2b8;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Tasks Card -->
                <div class="col-md-3 mb-3">
                    <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #f26e2c; height: 100%; background-color: #eee;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Tasks</p>
                                <h4 style="margin: 5px 0 0 0; color: #f26e2c; font-weight: 700; font-size: 24px;">8</h4>
                            </div>
                            <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(242, 110, 44, 0.1); display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-tasks" style="font-size: 28px; color: #f26e2c;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Tasks Card -->
                <div class="col-md-3 mb-3">
                    <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #28a745; height: 100%; background-color: #eee;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">Completed Tasks</p>
                                <h4 style="margin: 5px 0 0 0; color: #28a745; font-weight: 700; font-size: 24px;">4/8</h4>
                            </div>
                            <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(40, 167, 69, 0.1); display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-check-circle" style="font-size: 28px; color: #28a745;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Hours Card -->
                <div class="col-md-3 mb-3">
                    <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #242a62; height: 100%; background-color: #eee;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Hours</p>
                                <h4 style="margin: 5px 0 0 0; color: #242a62; font-weight: 700; font-size: 24px;">180</h4>
                            </div>
                            <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(36, 42, 98, 0.1); display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-clock-o" style="font-size: 28px; color: #242a62;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <ul class="nav nav-tabs nav-tabs-internship-history" id="applicationTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" 
                            type="button" role="tab">
                        <i class="bx bx-info-circle"></i> &nbsp;&nbsp;Internship Details
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="student-tab" data-bs-toggle="tab" data-bs-target="#student" 
                            type="button" role="tab">
                        <i class="bx bx-user"></i> &nbsp;&nbsp;Student
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks" 
                            type="button" role="tab">
                        <i class="bx bx-task"></i> &nbsp;&nbsp;Manage Task
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="instructions-tab" data-bs-toggle="tab" data-bs-target="#instructions" 
                            type="button" role="tab">
                        <i class="bx bx-file"></i> &nbsp;&nbsp;General Instructions
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="complete-tab" data-bs-toggle="tab" data-bs-target="#complete" 
                            type="button" role="tab">
                        <i class="bx bx-check-circle"></i> &nbsp;&nbsp;Complete Internship
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content tab-content-card" id="applicationTabsContent">
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

                <!-- Student Tab -->
                <div class="tab-pane fade" id="student" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                            <i class="bx bx-user"></i> Enrolled Students
                        </h5>
                        <span class="badge" style="background: #28a745; padding: 10px 20px; font-size: 14px; color: white;">
                            Total: 3 Students
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover table-internship-view">
                            <thead class="border-top">
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>University</th>
                                    <th>College</th>
                                    <th>Enrollment Date</th>
                                    <th>Status</th>
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
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-action-view btn-edit-view btn-sm" onclick="viewStudentProfile(1)">
                                            <i class="bx bx-show"></i> View Profile
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
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-action-view btn-edit-view btn-sm" onclick="viewStudentProfile(2)">
                                            <i class="bx bx-show"></i> View Profile
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
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-action-view btn-edit-view btn-sm" onclick="viewStudentProfile(3)">
                                            <i class="bx bx-show"></i> View Profile
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Manage Task Tab -->
                <div class="tab-pane fade" id="tasks" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                            <i class="bx bx-task"></i> My Tasks
                        </h5>
                        <div class="d-flex gap-2 align-items-center">
                            <span class="badge" style="background: #f26e2c; padding: 10px 20px; font-size: 14px;">
                                4/8 Completed
                            </span>
                            <button class="btn" style="background: #242a62; color: white; padding: 10px 20px; border-radius: 6px; font-weight: 600; border: none;" onclick="openAddTaskModal()">
                                <i class="bx bx-plus"></i> Add New Task
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover table-internship-view">
                            <thead class="border-top">
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Task Title</th>
                                    <th>Description</th>
                                    <th>Upload Date</th>
                                    <th>Due Date</th>
                                    <th>Task File</th>
                                    <th>Status</th>
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
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td>
                                        <button class="btn btn-action-view btn-edit-view btn-sm me-1" onclick="viewTaskDetails(1)">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                        <button class="btn btn-action-view btn-view-submission btn-sm" onclick="viewTaskSubmissions(1)">
                                            <i class="bx bx-file-find"></i> View Submissions
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
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td>
                                        <button class="btn btn-action-view btn-view-submission btn-sm me-1" onclick="submitTask(2)">
                                            <i class="bx bx-upload"></i> Submit
                                        </button>
                                        <button class="btn btn-action-view btn-view-submission btn-sm" onclick="viewTaskSubmissions(2)">
                                            <i class="bx bx-file-find"></i> View Submissions
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Database Design</td>
                                    <td>Design database schema for the project</td>
                                    <td>15 Feb 2026</td>
                                    <td>22 Feb 2026</td>
                                    <td>
                                        <a href="#" class="badge bg-info">
                                            <i class="bx bx-download"></i> task_3.pdf
                                        </a>
                                    </td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td>
                                        <button class="btn btn-action-view btn-edit-view btn-sm me-1" onclick="viewTaskDetails(3)">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                        <button class="btn btn-action-view btn-view-submission btn-sm" onclick="viewTaskSubmissions(3)">
                                            <i class="bx bx-file-find"></i> View Submissions
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- General Instructions Tab -->
                <div class="tab-pane fade" id="instructions" role="tabpanel">
                    <!-- Header with Title and Button -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                        <h5 style="color: #242a62; font-weight: 700; margin: 0; font-size: 18px;">
                            <i class="bx bx-file"></i> General Instructions
                        </h5>
                        <button type="button" class="btn" onclick="openUpdateInstructionsModal()" style="background: #f26e2c; color: white; padding: 10px 20px; border-radius: 6px; font-weight: 600; border: none; box-shadow: 0 2px 8px rgba(242, 110, 44, 0.3);">
                            <i class="bx bx-edit"></i> Update Instructions
                        </button>
                    </div>

                    <!-- Instructions Content Display -->
                    <div style="background: #f8f9fa; border-radius: 10px; padding: 30px; border-left: 4px solid #242a62; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        <div id="instructionsDisplayContent" style="color: #495057; font-size: 14px; line-height: 1.8;">
                            <h6 style="color: #242a62; font-weight: 700; margin-bottom: 15px;">Welcome to the Full-Stack Web Development Internship!</h6>
                            
                            <p style="color: #6c757d; margin-bottom: 20px;">Please read the following instructions carefully before starting your internship:</p>
                            
                            <h6 style="color: #242a62; font-weight: 700; margin-top: 25px; margin-bottom: 12px;">General Guidelines:</h6>
                            <ul style="margin-left: 20px; margin-bottom: 20px; color: #495057;">
                                <li style="margin-bottom: 8px;">Attend all scheduled sessions on time</li>
                                <li style="margin-bottom: 8px;">Complete all assigned tasks before the deadline</li>
                                <li style="margin-bottom: 8px;">Maintain professional communication with mentors and peers</li>
                                <li style="margin-bottom: 8px;">Follow the code of conduct at all times</li>
                            </ul>

                            <h6 style="color: #242a62; font-weight: 700; margin-top: 25px; margin-bottom: 12px;">Task Submission:</h6>
                            <ul style="margin-left: 20px; margin-bottom: 20px; color: #495057;">
                                <li style="margin-bottom: 8px;">Submit tasks in the specified format (ZIP file with proper folder structure)</li>
                                <li style="margin-bottom: 8px;">Include a README file with setup instructions</li>
                                <li style="margin-bottom: 8px;">Ensure your code is well-commented and follows best practices</li>
                            </ul>

                            <h6 style="color: #242a62; font-weight: 700; margin-top: 25px; margin-bottom: 12px;">Communication:</h6>
                            <ul style="margin-left: 20px; margin-bottom: 20px; color: #495057;">
                                <li style="margin-bottom: 8px;">Use official email for all communications</li>
                                <li style="margin-bottom: 8px;">Response time: Within 24 hours on working days</li>
                                <li style="margin-bottom: 8px;">Weekly progress meetings every Friday at 3:00 PM</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Complete Internship Tab -->
                <div class="tab-pane fade" id="complete" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                                <i class="bx bx-check-circle"></i> Complete The Internship | ગુજરાતી ભાષામા રચનાકોષનો અભ્યાસ
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
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-complete-internship" onclick="showConfirmModal()">
                            <i class="fa fa-check-circle"></i> Submit & Complete Internship
                        </button>
                    </div>

                    <div class="alert alert-info mt-4" role="alert">
                        <i class="bx bx-info-circle"></i> <strong>Note:</strong> Once submitted, student grades and feedback cannot be modified. Please review all entries carefully before submission.
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Task Details Modal -->
<div class="modal fade" id="taskDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header modal-header-history">
                <div>
                    <h5 class="modal-title" style="color: #fff!important;">
                        <i class="bx bx-task"></i> Task Details
                    </h5>
                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;color:#fff;">Complete information about the task</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times" style="color: #fff;"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
                <div class="section-card">
                    <h6><i class="bx bx-info-circle"></i> Task Information</h6>
                    <div class="detail-row-view">
                        <span class="detail-label-view">Task Title:</span>
                        <span class="detail-value-view" id="modal-task-title">Create Landing Page</span>
                    </div>
                    <div class="detail-row-view">
                        <span class="detail-label-view">Description:</span>
                        <span class="detail-value-view" id="modal-task-description">Design and develop a responsive landing page</span>
                    </div>
                    <div class="detail-row-view">
                        <span class="detail-label-view">Upload Date:</span>
                        <span class="detail-value-view" id="modal-task-upload">05 Feb 2026</span>
                    </div>
                    <div class="detail-row-view">
                        <span class="detail-label-view">Due Date:</span>
                        <span class="detail-value-view" id="modal-task-due">12 Feb 2026</span>
                    </div>
                    <div class="detail-row-view">
                        <span class="detail-label-view">Status:</span>
                        <span class="detail-value-view" id="modal-task-status">
                            <span class="badge bg-success">Completed</span>
                        </span>
                    </div>
                </div>

                <div class="section-card">
                    <h6><i class="bx bx-file"></i> Your Submission</h6>
                    <div class="detail-row-view">
                        <span class="detail-label-view">Submitted On:</span>
                        <span class="detail-value-view">08 Feb 2026, 3:45 PM</span>
                    </div>
                    <div class="detail-row-view">
                        <span class="detail-label-view">Submitted File:</span>
                        <span class="detail-value-view">
                            <a href="#" class="badge bg-info">
                                <i class="bx bx-download"></i> landing_page.zip
                            </a>
                        </span>
                    </div>
                    <div class="detail-row-view">
                        <span class="detail-label-view">Project Link:</span>
                        <span class="detail-value-view">
                            <a href="https://example.com/landing-page" target="_blank" style="color: #17a2b8;">
                                <i class="bx bx-link-external"></i> View Live Demo
                            </a>
                        </span>
                    </div>
                </div>

                <div class="section-card">
                    <h6><i class="bx bx-message-detail"></i> Your Notes</h6>
                    <div style="background: white; border-radius: 8px; padding: 15px;">
                        <p style="margin: 0; color: #495057; font-size: 14px; line-height: 1.6;">
                            I have completed the landing page design with all the required features including responsive design, hero section, features section, and contact form.
                        </p>
                    </div>
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

<!-- Submit Task Modal -->
<div class="modal fade" id="submitTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header modal-header-history">
                <div>
                    <h5 class="modal-title" style="color: #fff;">
                        <i class="bx bx-upload"></i> Submit Task
                    </h5>
                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;">Upload your completed task</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
                <form id="submitTaskForm">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                            Upload File <span style="color: red;">*</span>
                        </label>
                        <input type="file" class="form-control" id="taskSubmissionFile" required 
                               style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                        <small class="text-muted">Accepted formats: ZIP, PDF, DOC, DOCX (Max: 10MB)</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                            Project Link (Optional)
                        </label>
                        <input type="url" class="form-control" id="taskProjectLink" placeholder="https://example.com/your-project" 
                               style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                            Notes/Description <span style="color: red;">*</span>
                        </label>
                        <textarea class="form-control" id="taskNotes" rows="5" required 
                                  placeholder="Describe your submission, technologies used, and any additional information..."
                                  style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn" onclick="submitTaskForm()" style="background: #242a62; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-upload"></i> Submit Task
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add New Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down modal-dialog-centered" style="max-width: 1000px; width: 95%;">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header modal-header-history">
                <div>
                    <h5 class="modal-title" style="color: #fff;">
                        <i class="bx bx-plus-circle"></i> Add New Task
                    </h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
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
                            <textarea class="form-control" id="taskDescription" name="task_description" rows="6" required
                                      placeholder="Enter detailed description of the module and task..."
                                      style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;"></textarea>
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
                <button type="button" class="btn" onclick="saveNewTask()" style="background: #242a62; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-save"></i> Save Module
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Task Submissions Modal -->
<div class="modal fade" id="taskSubmissionsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down modal-dialog-centered modal-dialog-scrollable" style="max-width: 1200px; width: 95%;">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header modal-header-history">
                <div>
                    <h5 class="modal-title" style="color: #fff;">
                        <i class="bx bx-file-find"></i> Task Submissions
                    </h5>
                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;">Task: API Integration</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
                <!-- Submission Statistics -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div style="background: #eee; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #28a745;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">COMPLETED</p>
                                    <h4 style="margin: 5px 0 0 0; color: #28a745; font-weight: 700; font-size: 28px;">2</h4>
                                </div>
                                <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(40, 167, 69, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-check-circle" style="font-size: 28px; color: #28a745;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background: #eee; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #ffc107;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">PENDING</p>
                                    <h4 style="margin: 5px 0 0 0; color: #ffc107; font-weight: 700; font-size: 28px;">1</h4>
                                </div>
                                <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(255, 193, 7, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-clock-o" style="font-size: 28px; color: #ffc107;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background: #eee; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #17a2b8;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">TOTAL STUDENTS</p>
                                    <h4 style="margin: 5px 0 0 0; color: #17a2b8; font-weight: 700; font-size: 28px;">3</h4>
                                </div>
                                <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(23, 162, 184, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-user" style="font-size: 28px; color: #17a2b8;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Student Submission Status -->
                <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 style="color: #242a62; font-weight: 700; margin: 0;">
                            <i class="bx bx-list-ul"></i> Student Submission Status
                        </h6>
                        <span class="badge" style="background: #17a2b8; color: white; font-size: 13px; padding: 8px 14px;">
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
                                    <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px; text-align: center;">Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px; vertical-align: middle;">1</td>
                                    <td style="padding: 12px; vertical-align: middle;">
                                        <div style="display: flex; align-items: center;">
                                            <div style="width: 35px; height: 35px; border-radius: 50%; background: #242a62; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; margin-right: 10px;">
                                                R
                                            </div>
                                            <span style="font-weight: 600; color: #212529;">Rahul Sharma</span>
                                        </div>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; color: #6c757d; font-size: 13px;">rahul@example.com</td>
                                    <td style="padding: 12px; vertical-align: middle; color: #212529; font-size: 13px; font-weight: 500;">API Integration</td>
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
                                    <td style="padding: 12px; vertical-align: middle; text-align: center;">
                                        <span style="color: #6c757d; font-size: 12px;">-</span>
                                    </td>
                                  
                                </tr>
                                <tr>
                                    <td style="padding: 12px; vertical-align: middle;">2</td>
                                    <td style="padding: 12px; vertical-align: middle;">
                                        <div style="display: flex; align-items: center;">
                                            <div style="width: 35px; height: 35px; border-radius: 50%; background: #f26e2c; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; margin-right: 10px;">
                                                P
                                            </div>
                                            <span style="font-weight: 600; color: #212529;">Priya Patel</span>
                                        </div>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; color: #6c757d; font-size: 13px;">priya@example.com</td>
                                    <td style="padding: 12px; vertical-align: middle; color: #212529; font-size: 13px; font-weight: 500;">API Integration</td>
                                    <td style="padding: 12px; vertical-align: middle;">
                                        <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; font-size: 12px; border-radius: 20px;">
                                            <i class="bx bx-check-circle"></i> Complete
                                        </span>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; text-align: center;">
                                        <button class="btn btn-sm" style="background: #6f42c1; color: white; border: none; padding: 5px 12px; border-radius: 5px; font-size: 12px;" onclick="viewSubmittedFile(2)">
                                            <i class="bx bx-file"></i> View File
                                        </button>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; text-align: center;">
                                        <button class="btn btn-sm" style="background: #f26e2c; color: white; border: none; padding: 5px 12px; border-radius: 5px; font-size: 12px;" onclick="viewStudentSubmissionNote(2)">
                                            <i class="bx bx-note"></i> Note
                                        </button>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; text-align: center;">
                                        <button class="btn btn-sm" style="background: #17a2b8; color: white; border: none; padding: 5px 12px; border-radius: 5px; font-size: 12px;" onclick="openFeedbackModal(2, 'Priya Patel')">
                                            <i class="bx bx-message-dots"></i> Feedback
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px; vertical-align: middle;">3</td>
                                    <td style="padding: 12px; vertical-align: middle;">
                                        <div style="display: flex; align-items: center;">
                                            <div style="width: 35px; height: 35px; border-radius: 50%; background: #6f42c1; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; margin-right: 10px;">
                                                A
                                            </div>
                                            <span style="font-weight: 600; color: #212529;">Amit Kumar</span>
                                        </div>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; color: #6c757d; font-size: 13px;">amit@example.com</td>
                                    <td style="padding: 12px; vertical-align: middle; color: #212529; font-size: 13px; font-weight: 500;">API Integration</td>
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
                                        <button class="btn btn-sm" style="background: #f26e2c; color: white; border: none; padding: 5px 12px; border-radius: 5px; font-size: 12px;" onclick="viewStudentSubmissionNote(3)">
                                            <i class="bx bx-note"></i> Note
                                        </button>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; text-align: center;">
                                        <span style="color: #6c757d; font-size: 12px;">-</span>
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

<!-- Student Submission Note Modal -->
<div class="modal fade" id="studentSubmissionNoteModal" tabindex="-1" aria-labelledby="studentSubmissionNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 900px; width: 95%;">
        <div class="modal-content" style="border: none; border-radius: 15px; overflow: hidden;">
            <!-- Modal Header with Gradient -->
            <div class="modal-header" style="background: #242a62; border: none; padding: 25px 30px; color: white;">
                <div>
                    <h5 class="modal-title" id="studentSubmissionNoteModalLabel" style="font-weight: 700; font-size: 20px; margin: 0 0 5px 0;">
                        <i class="bx bx-note"></i> Student Submission Note
                    </h5>
                    <p style="margin: 0; font-size: 14px; opacity: 0.95;color:#fff;">Student: <span id="studentNameDisplay">Amit Kumar</span></p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body" style="background: #f8f9fa; padding: 30px;">
                <!-- Submission Details Section -->
                <div style="background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; border-left: 4px solid #242a62; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <h6 style="color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                        <i class="bx bx-info-circle"></i> Submission Details
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Task Title:</label>
                                <p style="margin: 0; color: #212529; font-size: 14px;" id="noteTaskTitle">Create Landing Page</p>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Status:</label>
                                <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;">
                                    <i class="bx bx-check-circle"></i> Submitted
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Submitted On:</label>
                                <p style="margin: 0; color: #212529; font-size: 14px;" id="noteSubmittedDate">09 Feb 2026, 11:20 AM</p>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Submission File:</label>
                                <button class="btn btn-sm" style="background: #17a2b8; color: white; border: none; padding: 6px 15px; border-radius: 5px; font-size: 12px; font-weight: 600;">
                                    <i class="bx bx-download"></i> landing_page.zip
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Student's Note/Description Section -->
                <div style="background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; border-left: 4px solid #f26e2c; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <h6 style="color: #f26e2c; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                        <i class="bx bx-message-square-detail"></i> Student's Note/Description
                    </h6>
                    <div style="color: #495057; font-size: 14px; line-height: 1.8;" id="studentNoteContent">
                        <p style="margin-bottom: 15px;">I have successfully created a modern and responsive landing page. Key features include:</p>
                        <ul style="margin-left: 20px; margin-bottom: 15px;">
                            <li>Clean and modern UI design</li>
                            <li>Smooth scroll animations</li>
                            <li>Mobile-first approach</li>
                            <li>SEO optimized</li>
                            <li>Fast loading time</li>
                        </ul>
                        <p style="margin: 0;">Used latest web technologies and best practices for optimal performance.</p>
                    </div>
                </div>

                <!-- Project Link Section -->
                <div style="background: white; border-radius: 10px; padding: 25px; border-left: 4px solid #17a2b8; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <h6 style="color: #17a2b8; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                        <i class="bx bx-link"></i> Project Link
                    </h6>
                    <a href="https://example.com/amit-landing-page" target="_blank" style="color: #17a2b8; text-decoration: none; font-size: 14px; font-weight: 600;" id="projectLinkDisplay">
                        <i class="bx bx-link-external"></i> https://example.com/amit-landing-page
                    </a>
                </div>
            </div>
            
            <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6; display: flex; justify-content: space-between;">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: #6c757d; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-x"></i> Close
                </button>
                <button type="button" class="btn" style="background: #28a745; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-check"></i> Approve Submission
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Task Feedback Modal -->
<div class="modal fade" id="taskFeedbackModal" tabindex="-1" aria-labelledby="taskFeedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 900px; width: 95%;">
        <div class="modal-content" style="border: none; border-radius: 15px; overflow: hidden;">
            <!-- Modal Header with Gradient -->
            <div class="modal-header" style="background: #242a62; border: none; padding: 25px 30px; color: white;">
                <div>
                    <h5 class="modal-title" id="taskFeedbackModalLabel" style="font-weight: 700; font-size: 20px; margin: 0 0 5px 0;">
                        <i class="bx bx-message-dots"></i> Task Feedback
                    </h5>
                    <p style="margin: 0; font-size: 14px; opacity: 0.95;">Student: <span id="feedbackStudentName">Priya Patel</span></p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                  
                </button>
            </div>
            
            <div class="modal-body" style="background: #f8f9fa; padding: 30px;">
                <form id="taskFeedbackForm">
                    <!-- Task Information -->
                    <div style="background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #17a2b8; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <div class="row">
                            <div class="col-md-6">
                                <div style="margin-bottom: 10px;">
                                    <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Task Title:</label>
                                    <p style="margin: 0; color: #212529; font-size: 14px;">API Integration</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="margin-bottom: 10px;">
                                    <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Submission Status:</label>
                                    <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 5px; font-size: 12px;">
                                        <i class="bx bx-check-circle"></i> Completed
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feedback Section -->
                    <div style="background: white; border-radius: 10px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <h6 style="color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                            <i class="bx bx-edit"></i> Provide Feedback
                        </h6>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px; margin-bottom: 10px;">
                                Feedback <span style="color: #dc3545;">*</span>
                            </label>
                            <textarea class="form-control" id="feedbackText" name="feedback" rows="8" required
                                      style="padding: 15px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px;"
                                      placeholder="Provide detailed feedback on the student's task submission...&#10;&#10;Example:&#10;- Quality of work&#10;- Areas of improvement&#10;- Strengths observed&#10;- Suggestions for enhancement"></textarea>
                            <small class="text-muted" style="font-size: 12px; margin-top: 5px; display: block;">
                                <i class="bx bx-info-circle"></i> Provide constructive feedback to help the student improve
                            </small>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6; display: flex; justify-content: space-between;">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: #6c757d; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn" onclick="submitFeedback()" style="background: #17a2b8; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-send"></i> Submit Feedback
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Task Feedback Modal -->
<div class="modal fade" id="taskFeedbackModal" tabindex="-1" aria-labelledby="taskFeedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 900px; width: 95%;">
        <div class="modal-content" style="border: none; border-radius: 15px; overflow: hidden;">
            <!-- Modal Header with Gradient -->
            <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border: none; padding: 25px 30px; color: white;">
                <div>
                    <h5 class="modal-title" id="taskFeedbackModalLabel" style="font-weight: 700; font-size: 20px; margin: 0 0 5px 0;">
                        <i class="bx bx-message-dots"></i> Task Feedback
                    </h5>
                    <p style="margin: 0; font-size: 14px; opacity: 0.95;">Student: <span id="feedbackStudentName">Priya Patel</span></p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body" style="background: #f8f9fa; padding: 30px;">
                <form id="taskFeedbackForm">
                    <!-- Task Information -->
                    <div style="background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #17a2b8; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <div class="row">
                            <div class="col-md-6">
                                <div style="margin-bottom: 10px;">
                                    <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Task Title:</label>
                                    <p style="margin: 0; color: #212529; font-size: 14px;">API Integration</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="margin-bottom: 10px;">
                                    <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Submission Status:</label>
                                    <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 5px; font-size: 12px;">
                                        <i class="bx bx-check-circle"></i> Completed
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feedback Section -->
                    <div style="background: white; border-radius: 10px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <h6 style="color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                            <i class="bx bx-edit"></i> Provide Feedback
                        </h6>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px; margin-bottom: 10px;">
                                Feedback <span style="color: #dc3545;">*</span>
                            </label>
                            <textarea class="form-control" id="feedbackText" name="feedback" rows="8" required
                                      style="padding: 15px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px;"
                                      placeholder="Provide detailed feedback on the student's task submission...&#10;&#10;Example:&#10;- Quality of work&#10;- Areas of improvement&#10;- Strengths observed&#10;- Suggestions for enhancement"></textarea>
                            <small class="text-muted" style="font-size: 12px; margin-top: 5px; display: block;">
                                <i class="bx bx-info-circle"></i> Provide constructive feedback to help the student improve
                            </small>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6; display: flex; justify-content: space-between;">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: #6c757d; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn" onclick="submitFeedback()" style="background: #17a2b8; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-send"></i> Submit Feedback
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Update Instructions Modal -->
<div class="modal fade" id="updateInstructionsModal" tabindex="-1" aria-labelledby="updateInstructionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 1000px; width: 95%;">
        <div class="modal-content" style="border: none; border-radius: 15px; overflow: hidden;">
            <!-- Modal Header with Gradient -->
            <div class="modal-header" style="background: #242a62; border: none; padding: 25px 30px; color: white;">
                <div>
                    <h5 class="modal-title" id="updateInstructionsModalLabel" style="font-weight: 700; font-size: 20px; margin: 0 0 5px 0;">
                        <i class="bx bx-edit"></i> Update General Instructions
                    </h5>
                    <p style="margin: 0; font-size: 14px; opacity: 0.95;">Edit the general instructions for students</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body" style="background: #f8f9fa; padding: 30px;">
                <div style="margin-bottom: 20px;">
                    <label style="font-weight: 600; color: #495057; font-size: 14px; margin-bottom: 10px; display: block;">
                        Instructions Content
                    </label>
                    
                    <!-- Text Editor Toolbar -->
                    <div style="background: #f8f9fa; border: 1px solid #dee2e6; border-bottom: none; border-radius: 6px 6px 0 0; padding: 10px; display: flex; gap: 5px; flex-wrap: wrap;">
                        <select style="padding: 5px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px; background: white;">
                            <option>Paragraph</option>
                            <option>Heading 1</option>
                            <option>Heading 2</option>
                            <option>Heading 3</option>
                        </select>
                        <div style="display: flex; gap: 2px; border-left: 1px solid #dee2e6; padding-left: 8px;">
                            <button type="button" style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold;" title="Bold">
                                <strong>B</strong>
                            </button>
                            <button type="button" style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-style: italic;" title="Italic">
                                <em>I</em>
                            </button>
                            <button type="button" style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Link">
                                <i class="bx bx-link"></i>
                            </button>
                        </div>
                        <div style="display: flex; gap: 2px; border-left: 1px solid #dee2e6; padding-left: 8px;">
                            <button type="button" style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Bullet List">
                                <i class="bx bx-list-ul"></i>
                            </button>
                            <button type="button" style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Numbered List">
                                <i class="bx bx-list-ol"></i>
                            </button>
                        </div>
                        <div style="display: flex; gap: 2px; border-left: 1px solid #dee2e6; padding-left: 8px;">
                            <button type="button" style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Quote">
                                <i class="bx bx-quote-left"></i>
                            </button>
                            <button type="button" style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Table">
                                <i class="bx bx-table"></i>
                            </button>
                        </div>
                        <div style="display: flex; gap: 2px; border-left: 1px solid #dee2e6; padding-left: 8px;">
                            <button type="button" style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Undo">
                                <i class="bx bx-undo"></i>
                            </button>
                            <button type="button" style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Redo">
                                <i class="bx bx-redo"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Content Editor Area -->
                    <div contenteditable="true" id="instructionsContent" style="min-height: 400px; border: 1px solid #dee2e6; border-radius: 0 0 6px 6px; padding: 20px; background: white; font-size: 14px; line-height: 1.8; color: #495057; overflow-y: auto;">
                        <p style="color: #6a7681; margin-bottom: 15px;">Welcome to the Full-Stack Web Development Internship!</p>
                        
                        <p style="margin-bottom: 15px;">Please read the following instructions carefully before starting your internship:</p>
                        
                        <p style="font-weight: 600; margin-top: 20px; margin-bottom: 10px;">General Guidelines:</p>
                        <ul style="margin-left: 20px; margin-bottom: 15px;">
                            <li>Attend all scheduled sessions on time</li>
                            <li>Complete all assigned tasks before the deadline</li>
                            <li>Maintain professional communication with mentors and peers</li>
                            <li>Follow the code of conduct at all times</li>
                        </ul>

                        <p style="font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Task Submission:</p>
                        <ul style="margin-left: 20px; margin-bottom: 15px;">
                            <li>Submit tasks in the specified format (ZIP file with proper folder structure)</li>
                            <li>Include a README file with setup instructions</li>
                            <li>Ensure your code is well-commented and follows best practices</li>
                        </ul>

                        <p style="font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Communication:</p>
                        <ul style="margin-left: 20px; margin-bottom: 15px;">
                            <li>Use official email for all communications</li>
                            <li>Response time: Within 24 hours on working days</li>
                            <li>Weekly progress meetings every Friday at 3:00 PM</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6; display: flex; justify-content: space-between;">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: #6c757d; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn" onclick="saveInstructions()" style="background: #28a745; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
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
<script>
    // View Task Details
    window.viewTaskDetails = function(taskId) {
        const modal = new bootstrap.Modal(document.getElementById('taskDetailsModal'));
        modal.show();
        console.log('Viewing task details for ID:', taskId);
    }

    // Submit Task
    window.submitTask = function(taskId) {
        const modal = new bootstrap.Modal(document.getElementById('submitTaskModal'));
        modal.show();
        console.log('Submitting task ID:', taskId);
    }

    // Submit Task Form
    window.submitTaskForm = function() {
        const form = document.getElementById('submitTaskForm');
        if (form.checkValidity()) {
            alert('Task submitted successfully!');
            bootstrap.Modal.getInstance(document.getElementById('submitTaskModal')).hide();
        } else {
            form.reportValidity();
        }
    }

    // View Student Profile
    window.viewStudentProfile = function(studentId) {
        console.log('Viewing student profile for ID:', studentId);
        alert('Student Profile - Feature Coming Soon!');
    }

    // Open Add Task Modal
    window.openAddTaskModal = function() {
        const modal = new bootstrap.Modal(document.getElementById('addTaskModal'));
        modal.show();
    }

    // Save New Task
    window.saveNewTask = function() {
        const form = document.getElementById('addTaskForm');
        if (form.checkValidity()) {
            alert('Task added successfully!');
            bootstrap.Modal.getInstance(document.getElementById('addTaskModal')).hide();
            // Reset form
            form.reset();
        } else {
            form.reportValidity();
        }
    }

    // View Task Submissions
    window.viewTaskSubmissions = function(taskId) {
        const modal = new bootstrap.Modal(document.getElementById('taskSubmissionsModal'));
        modal.show();
        console.log('Viewing submissions for task ID:', taskId);
    }

    // View Submitted File
    window.viewSubmittedFile = function(studentId) {
        console.log('Viewing file for student ID:', studentId);
        alert('File Viewer - Feature Coming Soon!');
    }

    // View Student Submission Note
    window.viewStudentSubmissionNote = function(studentId) {
        const modal = new bootstrap.Modal(document.getElementById('studentSubmissionNoteModal'));
        
        // Here you can populate the modal with specific student data
        // For now, using sample data
        console.log('Viewing note for student ID:', studentId);
        
        modal.show();
    }

    // Open Update Instructions Modal
    window.openUpdateInstructionsModal = function() {
        const modal = new bootstrap.Modal(document.getElementById('updateInstructionsModal'));
        // Load current content into the editor
        const currentContent = document.getElementById('instructionsDisplayContent').innerHTML;
        document.getElementById('instructionsContent').innerHTML = currentContent;
        modal.show();
    }

    // Save Instructions
    window.saveInstructions = function() {
        const content = document.getElementById('instructionsContent').innerHTML;
        console.log('Saving instructions:', content);
        
        // Update the display content
        document.getElementById('instructionsDisplayContent').innerHTML = content;
        
        // Close the modal
        bootstrap.Modal.getInstance(document.getElementById('updateInstructionsModal')).hide();
        
        // Here you can send the content to the server via AJAX
        alert('Instructions saved successfully!');
    }

    // Open Feedback Modal
    window.openFeedbackModal = function(studentId, studentName) {
        console.log('Opening feedback modal for student ID:', studentId);
        
        // Update student name in modal
        document.getElementById('feedbackStudentName').textContent = studentName;
        
        // Clear previous feedback
        document.getElementById('feedbackText').value = '';
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('taskFeedbackModal'));
        modal.show();
    }

    // Submit Feedback
    window.submitFeedback = function() {
        const feedbackText = document.getElementById('feedbackText').value.trim();
        
        if (!feedbackText) {
            alert('Please provide feedback before submitting!');
            return;
        }
        
        // Here you would normally submit to backend via AJAX
        console.log('Submitting feedback:', feedbackText);
        
        alert('Feedback submitted successfully!');
        bootstrap.Modal.getInstance(document.getElementById('taskFeedbackModal')).hide();
        
        // Reset form
        document.getElementById('feedbackText').value = '';
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
        // fetch('/api/complete-internship', {
        //     method: 'POST',
        //     headers: { 'Content-Type': 'application/json' },
        //     body: JSON.stringify(studentsData)
        // }).then(response => response.json())
        //   .then(data => {
        //       alert('Internship completed successfully!');
        //       location.reload();
        //   });

        // For now, just show success message
        bootstrap.Modal.getInstance(document.getElementById('confirmCompleteModal')).hide();
        
        alert('Internship completed successfully! Student grades have been submitted.');
        
        // Disable all inputs after submission
        document.querySelectorAll('.marks-input, .feedback-textarea').forEach(input => {
            input.disabled = true;
        });
        document.querySelector('.btn-complete-internship').disabled = true;
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
