@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "Internship-InternshipManagement";
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

    /* Readonly display for replaced inputs (when internship is submitted) */
    .readonly-mark {
        display: inline-block;
        min-width: 70px;
        padding: 8px 10px;
        border-radius: 8px;
        background: #f8f9fa;
        text-align: center;
        font-weight: 600;
    }

    .readonly-feedback {
        padding: 10px;
        border-radius: 8px;
        background: #f8f9fa;
        min-height: 80px;
        white-space: pre-wrap;
    }

    /* Internship Complete Alert */
    .internship-complete-alert {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        padding: 14px 20px;
        box-shadow: 0 6px 18px rgba(32, 201, 151, 0.12);
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
    }
    .internship-complete-alert .icon {
        font-size: 22px;
        opacity: 0.95;
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
    {{-- Top banner: Industry completed, College pending --}}
    @if($internship->internship_type == 1 && $internship->company_complete_sts == 1 && $internship->college_complete_sts == 0 && $internship->complete_status == 0)
        <div class="alert alert-warning d-flex align-items-center" role="alert" style="margin-bottom:18px;">
            <i class="bx bx-info-circle" style="font-size:20px;"></i>
            <div class="ms-3">
                <strong>Industry marks completed.</strong> College side marks are still pending.
            </div>
            @if(!empty($internship->college_pending_flag) && $internship->college_pending_flag)
                <span class="badge ms-auto" style="background:#856404;color:#fff;font-size:13px;padding:6px 12px;border-radius:4px;"><i class="bx bx-flag"></i> Already Flagged for College</span>
            @else
                <button class="btn btn-warning btn-sm ms-auto" onclick="markCollegePending({{ $internship->id }})"><i class="bx bx-flag"></i> Mark as Pending for College</button>
            @endif
        </div>
    @endif

    @if($internship->complete_status == 1)
        <div class="internship-complete-alert" role="alert">
            <span class="icon"><i class="bx bx-check-circle"></i></span>
            <div>
                <strong>Internship Completed</strong>
                <div class="small" style="opacity:0.95;">This internship has been marked complete successfully.</div>
            </div>
        </div>
    @endif
    
    <!-- Page Header -->
    <div class="internship-view-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 style="color: #fff;">
                    <i class="bx bx-briefcase-alt-2"></i> {{ $internship->internship_title }}
                </h4>
                <p>{{ $internship->company ? $internship->company->name : 'N/A' }} • {{ $internship->duration }} • {{ $internship->mode }} Mode</p>
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
        @if(!empty($internship->manage_task_status) && intval($internship->manage_task_status) === 1)
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks" 
                    type="button" role="tab">
                <i class="bx bx-task"></i> &nbsp;&nbsp; Manage Tasks
            </button>
        </li>
        @endif
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
                @if($internship->company_complete_sts == 1 || $internship->complete_status == 1)
                    @if($internship->internship_type == 2)
                        <i class="bx bx-message-square-detail"></i> &nbsp;&nbsp; View Feedback
                    @else
                        <i class="bx bx-eye"></i> &nbsp;&nbsp; View Marks
                    @endif
                @else
                    <i class="bx bx-check-circle"></i> &nbsp;&nbsp; Complete Internship
                @endif
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
                    <span class="detail-value-view">{{ $internship->internship_title }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Company Name:</span>
                    <span class="detail-value-view">{{ $internship->company ? $internship->company->name : 'N/A' }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Category:</span>
                    <span class="detail-value-view">{{ $internship->jobCategory ? $internship->jobCategory->category_nm : 'N/A' }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Mode:</span>
                    <span class="detail-value-view">{{ $internship->mode }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Location:</span>
                    <span class="detail-value-view">{{ $internship->location }}</span>
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-time"></i> Duration & Schedule</h6>
                <div class="detail-row-view">
                    <span class="detail-label-view">Duration:</span>
                    <span class="detail-value-view">{{ $internship->duration }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Total Weeks:</span>
                    <span class="detail-value-view">{{ $internship->total_weeks }} Weeks</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Total Hours:</span>
                    <span class="detail-value-view">{{ $internship->total_hours }} Hours</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Start Date:</span>
                    <span class="detail-value-view">{{ $internship->start_date ? $internship->start_date->format('d M Y') : 'N/A' }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">End Date:</span>
                    <span class="detail-value-view">{{ $internship->end_date ? $internship->end_date->format('d M Y') : 'N/A' }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Batch Days:</span>
                    <span class="detail-value-view">
                        @if($internship->batch_days && is_array($internship->batch_days))
                            {{ implode(', ', array_keys($internship->batch_days)) }}
                        @else
                            N/A
                        @endif
                    </span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Time Slots:</span>
                    <span class="detail-value-view">
                        @if($internship->batch_days && is_array($internship->batch_days))
                            @foreach($internship->batch_days as $day => $times)
                                {{ $day }}: {{ $times['start_time'] ?? 'N/A' }} - {{ $times['end_time'] ?? 'N/A' }}<br>
                            @endforeach
                        @else
                            N/A
                        @endif
                    </span>
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-money"></i> Compensation & Fees</h6>
                <div class="detail-row-view">
                    <span class="detail-label-view">Stipend:</span>
                    <span class="detail-value-view">₹{{ number_format($internship->stipend, 2) }}/month</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Registration Fee:</span>
                    <span class="detail-value-view">₹{{ number_format($internship->registration_fees, 2) }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">GST ({{ $internship->gst_percentage }}%):</span>
                    <span class="detail-value-view">₹{{ number_format($internship->gst_amount, 2) }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Total Fee:</span>
                    <span class="detail-value-view"><strong>₹{{ number_format($internship->final_amount, 2) }}</strong></span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Openings:</span>
                    <span class="detail-value-view">{{ $internship->openings }} Positions</span>
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-cog"></i> Skills & Requirements</h6>
                @php
                    $skillsArr = [];
                    if(!empty($internship->skills)) {
                        $decoded = json_decode($internship->skills, true);
                        if(is_array($decoded)) {
                            $skillsArr = $decoded;
                        } else {
                            $skillsArr = array_filter(array_map('trim', explode(',', $internship->skills)));
                        }
                    }

                    $criteriaArr = [];
                    if(!empty($internship->eligibility_criteria)) {
                        $decoded2 = json_decode($internship->eligibility_criteria, true);
                        if(is_array($decoded2)) {
                            $criteriaArr = $decoded2;
                        } else {
                            $criteriaArr = array_filter(array_map('trim', explode(',', $internship->eligibility_criteria)));
                        }
                    }
                @endphp
                <div class="detail-row-view">
                    <span class="detail-label-view">Required Skills:</span>
                    <span class="detail-value-view">
                        @if(!empty($skillsArr) && count($skillsArr) > 0)
                            @foreach($skillsArr as $skill)
                                <span class="badge bg-light text-dark me-1">{{ trim($skill, " \"'") }}</span>
                            @endforeach
                        @else
                            N/A
                        @endif
                    </span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Eligibility Criteria:</span>
                    <span class="detail-value-view">
                        @if(!empty($criteriaArr) && count($criteriaArr) > 0)
                            @foreach($criteriaArr as $criteria)
                                <span class="badge bg-light text-dark me-1">{{ trim($criteria, " \"'") }}</span>
                            @endforeach
                        @else
                            N/A
                        @endif
                    </span>
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-detail"></i> Internship Description</h6>
                <div style="padding: 15px; background: white; border-radius: 8px; border: 1px solid #e9ecef;">
                    {!! $internship->internship_description ?? '<p class="text-muted">No description available</p>' !!}
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-book"></i> Module Brief Description</h6>
                <div style="padding: 15px; background: white; border-radius: 8px; border: 1px solid #e9ecef;">
                    {!! $internship->module_brief_description ?? '<p class="text-muted">No module description available</p>' !!}
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-target-lock"></i> Internship Objective</h6>
                <div style="padding: 15px; background: white; border-radius: 8px; border: 1px solid #e9ecef;">
                    {!! $internship->internship_objective ?? '<p class="text-muted">No objective defined</p>' !!}
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-trophy"></i> Internship Outcome</h6>
                <div style="padding: 15px; background: white; border-radius: 8px; border: 1px solid #e9ecef;">
                    {!! $internship->internship_outcome ?? '<p class="text-muted">No outcome defined</p>' !!}
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
                            <th>Degree</th>
                            <th>Semester</th>
                            <th>Enrollment Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will populate rows via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>

        @if(!empty($internship->manage_task_status) && intval($internship->manage_task_status) === 1)
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
                            <th>Date & Time</th>
                            <th>Day</th>
                            <th>Due Date</th>
                            <th>Task File</th>
                            <th>Submissions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
        @endif

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
                    {!! $internship->general_instructions ?? '<p>No instructions added yet. Click "Update Instructions" to add content.</p>' !!}
                </div>
            </div>
        </div>

        <!-- Payment History Tab -->
        <div class="tab-pane fade" id="payment" role="tabpanel">
            <h5 style="color: #242a62; font-weight: 700; margin-bottom: 20px;">
                <i class="bx bx-money"></i> Payment Transaction History
            </h5>

            <div class="table-responsive">
                <div class="mb-3 d-flex gap-2 align-items-center">
                    <select id="filterPaymentStatus" class="form-select form-select-sm" style="width:160px;">
                        <option value="">All Status</option>
                        <option value="0">Pending</option>
                        <option value="1">Success</option>
                        <option value="2">Failed</option>
                        <option value="3">Refunded</option>
                    </select>
                    <select id="filterPaymentMode" class="form-select form-select-sm" style="width:160px;">
                        <option value="">All Methods</option>
                        <option value="UPI">UPI</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Net Banking">Net Banking</option>
                        <option value="Wallet">Wallet</option>
                    </select>
                    <input id="filterDateFrom" type="date" class="form-control form-control-sm" style="width:150px;" />
                    <input id="filterDateTo" type="date" class="form-control form-control-sm" style="width:150px;" />
                    <button id="applyPaymentFilters" class="btn btn-sm btn-primary">Apply</button>
                    <button id="resetPaymentFilters" class="btn btn-sm btn-secondary">Reset</button>
                </div>

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
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        
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
                                        <h4 style="margin: 5px 0 0 0; color: #28a745; font-weight: 700; font-size: 24px;"><span id="totalRevenue">₹0</span></h4>
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
                                    <h4 style="margin: 5px 0 0 0; color: #17a2b8; font-weight: 700; font-size: 24px;"><span id="totalStudents">3</span></h4>
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
                                    <h4 style="margin: 5px 0 0 0; color: #007bff; font-weight: 700; font-size: 24px;"><span id="successfulPayments">3</span></h4>
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
                                    <h4 style="margin: 5px 0 0 0; color: #dc3545; font-weight: 700; font-size: 24px;"><span id="failedPayments">0</span></h4>
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
                        @if($internship->company_complete_sts == 1 || $internship->complete_status == 1)
                            @if($internship->internship_type == 2)
                                <i class="bx bx-message-square-detail"></i> View Feedback | {{ $internship->internship_title }}
                            @else
                                <i class="bx bx-eye"></i> View Marks | {{ $internship->internship_title }}
                            @endif
                        @else
                            <i class="bx bx-check-circle"></i> Complete The Internship | {{ $internship->internship_title }}
                        @endif
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 14px; margin-top: 5px;">
                        @if($internship->company_complete_sts == 1 || $internship->complete_status == 1)
                            @if($internship->internship_type == 2)
                                Review submitted student feedback
                            @else
                                Review submitted student marks and grades
                            @endif
                        @else
                            Evaluate student performance and assign grades
                        @endif
                    </p>
                </div>
                <button class="btn export-btn" onclick="exportToExcel()">
                    <i class="fa fa-file-excel-o"></i> Export to Excel
                </button>
            </div>

            @if($internship->complete_status == 1)
                <div class="alert alert-success" role="alert">
                    <i class="bx bx-check-circle"></i> <strong>Completed!</strong> This internship has been finalized. Grades and feedback are locked.
                </div>
            @elseif(!$internship->complete_status && $internship->internship_type == 1 && $internship->company_complete_sts == 1 && $internship->college_complete_sts == 0)
                <div class="alert alert-warning d-flex align-items-center flex-wrap gap-2" role="alert">
                    <span><i class="bx bx-info-circle"></i> <strong>Industry marks completed.</strong> College side marks are still pending.</span>
                    @if(!$internship->college_pending_flag)
                        <button class="btn btn-warning btn-sm ms-auto" id="btnMarkCollegePending" onclick="markCollegePending({{ $internship->id }})">
                            <i class="bx bx-flag"></i> Mark as Pending for College
                        </button>
                    @else
                        <span class="badge ms-auto" style="background:#856404;color:#fff;font-size:13px;padding:6px 12px;">
                            <i class="bx bx-flag"></i> Already Flagged for College
                        </span>
                    @endif
                </div>
            @endif

            @php
                $colspan = 2; // SR.NO, STUDENT
                if($internship->internship_type == 1) $colspan++; // COLLEGE
                if($internship->internship_type == 1) $colspan++; // INDUSTRY marks column (per-student)
                $colspan += 1; // FEEDBACK
                if($internship->internship_type == 1) $colspan += 3; // TOTAL, PERCENTAGE, GRADE
            @endphp

            <div class="table-responsive">
                <table class="complete-internship-table" id="completionTable">
                    <thead>
                        <tr>
                            <th>SR.NO</th>
                            <th>STUDENT</th>
                            @if($internship->internship_type == 1)
                                <th>COLLEGE</th>
                            @endif
                            @if($internship->internship_type == 1)
                                <th style="min-width: 300px;">INDUSTRY (INDUSTRY MARKS)</th>
                            @endif
                            <th>FEEDBACK</th>
                            @if($internship->internship_type == 1)
                                <th>TOTAL</th>
                                <th>PERCENTAGE</th>
                                <th>GRADE</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $index => $application)
                            @php
                                $student = $application->user;
                                $college = $student ? $student->college : null;
                                $studentSavedMarks = isset($savedMarks[$student->id]) ? $savedMarks[$student->id]->keyBy('criteria_id') : collect();
                                $savedFeedback = $savedFeedbacks[$student->id] ?? '';
                                // Treat as submitted/read-only when company has submitted or overall finalised
                                $isSubmitted = $internship->company_complete_sts == 1 || $internship->complete_status == 1;
                                // Per-student criteria based on their college + degree
                                $studentCriteria = $studentCriteriaMap[$student->id] ?? collect();
                                $maxTotal = $studentCriteria->sum('marks');
                            @endphp
                            <tr data-student-id="{{ $student->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div style="font-weight: 600; color: #242a62;">
                                        {{ strtoupper($student->name ?? 'N/A') }}
                                    </div>
                                </td>
                                @if($internship->internship_type == 1)
                                <td>{{ $college ? $college->college_name : 'N/A' }}</td>
                                @endif
                                @if($internship->internship_type == 1)
                                <td>
                                    @if($studentCriteria->count() > 0)
                                        @foreach($studentCriteria as $criterion)
                                            <div class="marks-input-group mb-2">
                                                <label>{{ $criterion->title }}</label>
                                                <input type="number"
                                                       class="marks-input industry-mark"
                                                       min="0"
                                                       max="{{ $criterion->marks }}"
                                                       data-max="{{ $criterion->marks }}"
                                                       data-criteria-id="{{ $criterion->id }}"
                                                       data-criteria-name="{{ $criterion->title }}"
                                                       data-student-id="{{ $student->id }}"
                                                       placeholder="0"
                                                       value="{{ isset($studentSavedMarks[$criterion->id]) ? $studentSavedMarks[$criterion->id]->marks : '' }}"
                                                       {{ $isSubmitted ? 'disabled' : '' }}>
                                                <span class="max-marks">/ {{ $criterion->marks }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted d-block text-center" style="font-size:22px;font-weight:700;letter-spacing:2px;">-</span>
                                        <small class="text-muted d-block text-center" style="font-size:11px;">No grade configured</small>
                                    @endif
                                </td>
                                @endif
                                <td>
                                    <textarea class="feedback-textarea"
                                              data-student-id="{{ $student->id }}"
                                              placeholder="Enter feedback for student..."
                                              {{ $isSubmitted ? 'disabled' : '' }}>{{ $savedFeedback }}</textarea>
                                </td>
                                @if($internship->internship_type == 1)
                                    <td class="total-display">0 / {{ $maxTotal }}</td>
                                    <td class="percentage-display">0.00%</td>
                                    <td>
                                        <span class="grade-badge grade-F">-</span>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $colspan }}" class="text-center py-4">
                                    <i class="bx bx-info-circle"></i> No students enrolled in this internship
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($internship->company_complete_sts == 1 && $internship->college_complete_sts == 1)
            <div class="text-center mt-4">
                <button class="btn btn-secondary" disabled>
                    <i class="bx bx-lock-alt"></i> Marks Already Submitted — Locked
                </button>
            </div>
            @elseif(!$internship->complete_status && !($internship->company_complete_sts == 1 && $internship->college_complete_sts == 0) && $students->count() > 0)
            <div class="text-center mt-4">
                <button class="btn btn-complete-internship-submit" onclick="showConfirmModal()">
                    <i class="fa fa-check-circle"></i> Submit &amp; Complete Internship
                </button>
            </div>
            @endif

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
                                Upload File (Optional - PDF only)
                            </label>
                            <input type="file" class="form-control" id="taskFile" name="task_file" accept=".pdf"
                                   style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                            <small class="text-muted">Only PDF files are allowed (Max 10MB)</small>
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

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #242a62 0%, #f26e2c 100%); color: white; padding: 20px 30px; border: none;">
                <div>
                    <h5 class="modal-title" style="color: #fff; margin: 0; font-size: 20px; font-weight: 700;">
                        <i class="bx bx-edit"></i> Edit Task
                    </h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="background: #fff; border: none; font-size: 24px; color: white; opacity: 1; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                    <i class="bx bx-x" style="color:#fff;"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
                <form id="editTaskForm">
                    <input type="hidden" id="editTaskId" name="task_id">
                    <div class="row">
                        <!-- Date & Time -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Date & Time <span style="color: red;">*</span>
                            </label>
                            <input type="datetime-local" class="form-control" id="editTaskDateTime" name="task_datetime" required 
                                   style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>

                        <!-- Day -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Day
                            </label>
                            <input type="text" class="form-control" id="editTaskDay" name="task_day" placeholder="e.g., Monday" 
                                   style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>

                        <!-- Module Title -->
                        <div class="col-12 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Module Title <span style="color: red;">*</span>
                            </label>
                            <input type="text" class="form-control" id="editModuleTitle" name="module_title" placeholder="Enter Module title" required 
                                   style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>

                        <!-- Module and Task Description -->
                        <div class="col-12 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Module and Task Description <span style="color: red;">*</span>
                            </label>
                            <textarea id="editTaskDescriptionEditor" name="task_description"></textarea>
                        </div>

                        <!-- Upload File (Optional) -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Upload File (Optional - PDF only)
                            </label>
                            <input type="file" class="form-control" id="editTaskFile" name="task_file" accept=".pdf"
                                   style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                            <small class="text-muted" id="editCurrentFile"></small>
                            <small class="text-muted d-block">Only PDF files are allowed (Max 10MB)</small>
                        </div>

                        <!-- Last Submission Date -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Last Submission Date <span style="color: red;">*</span>
                            </label>
                            <input type="date" class="form-control" id="editLastSubmissionDate" name="last_submission_date" required 
                                   style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>

                        <!-- Online Link -->
                        <div class="col-12 mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Online Link
                            </label>
                            <input type="url" class="form-control" id="editOnlineLink" name="online_link" placeholder="Enter Online Link" 
                                   style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>

                        <!-- Is this the Final Assignment / Report? -->
                        <div class="col-12 mb-3">
                            <div class="form-check" style="padding-left: 1.5em;">
                                <input class="form-check-input" type="checkbox" id="editIsFinalAssignment" name="is_final_assignment" 
                                       style="width: 18px; height: 18px; margin-top: 0.15em;">
                                <label class="form-check-label" for="editIsFinalAssignment" style="font-weight: 600; color: #495057; font-size: 14px; margin-left: 8px;">
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
                <button type="button" class="btn" onclick="updateTask()" style="background: #242a62; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-save"></i> Update Module
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Details Modal -->
<div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #242a62 0%, #f26e2c 100%); color: white; padding: 20px 30px; border: none;">
                <h5 class="modal-title" style="color: #fff; margin: 0; font-size: 18px; font-weight: 700;">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="background: #fff; border: none; font-size: 24px; color: white; opacity: 1; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                    <i class="bx bx-x" style="color:#fff;"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="row mb-2">
                    <div class="col-6"><strong>Transaction ID:</strong> <div id="paymentTxn"></div></div>
                    <div class="col-6"><strong>Amount:</strong> <div id="paymentAmount"></div></div>
                </div>
                <div class="row mb-2">
                    <div class="col-6"><strong>Student:</strong> <div id="paymentStudent"></div></div>
                    <div class="col-6"><strong>Email:</strong> <div id="paymentEmail"></div></div>
                </div>
                <div class="row mb-2">
                    <div class="col-6"><strong>Payment Method:</strong> <div id="paymentMethod"></div></div>
                    <div class="col-6"><strong>Paid On:</strong> <div id="paymentPaidOn"></div></div>
                </div>
                <hr />
                <h6>Gateway / Response Data</h6>
                <pre id="paymentGatewayResponse" style="background:#f8f9fa;padding:12px;border-radius:6px;max-height:300px;overflow:auto;"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                                    <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px; text-align: center;">Feedback</th>
                                </tr>
                            </thead>
                            <tbody id="submissionTableBody">
                                <!-- Dynamic content loaded via AJAX -->
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

<!-- Task Feedback Modal -->
<div class="modal fade" id="taskFeedbackModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #242a62 0%, #f26e2c 100%); color: white; padding: 20px 30px; border: none;">
                <div>
                    <h5 class="modal-title" style="color: #fff; margin: 0; font-size: 20px; font-weight: 700;">
                        <i class="bx bx-message-dots"></i> Task Feedback
                    </h5>
                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;">Student: <span id="feedbackStudentName">Loading...</span></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="background: #fff; border: none; font-size: 24px; color: white; opacity: 1; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                    <i class="bx bx-x" style="color:#000;"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
                <!-- Task Info -->
                <div style="background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #242a62;">
                    <div class="row">
                        <div class="col-md-6">
                            <span style="font-weight: 600; color: #6c757d; font-size: 13px;">Task Title:</span>
                            <p style="margin: 4px 0 0 0; color: #212529; font-weight: 500;" id="feedbackTaskTitle">-</p>
                        </div>
                        <div class="col-md-6">
                            <span style="font-weight: 600; color: #6c757d; font-size: 13px;">Submission Status:</span>
                            <p style="margin: 4px 0 0 0;" id="feedbackStatus">-</p>
                        </div>
                    </div>
                </div>

                <!-- Existing Feedback (view only) -->
                <div id="feedbackViewSection" style="display: none;">
                    <div style="background: white; border-radius: 10px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #28a745;">
                        <h6 style="color: #28a745; font-weight: 700; margin-bottom: 15px;">
                            <i class="bx bx-check-circle"></i> Feedback (Already Submitted)
                        </h6>
                        <div style="background: #f8f9fa; border-radius: 8px; padding: 15px; min-height: 80px;" id="feedbackViewContent"></div>
                    </div>
                </div>

                <!-- Feedback Form (write) -->
                <div id="feedbackFormSection">
                    <div style="background: white; border-radius: 10px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #17a2b8;">
                        <h6 style="color: #242a62; font-weight: 700; margin-bottom: 15px;">
                            <i class="bx bx-edit"></i> Provide Feedback
                        </h6>
                        <textarea class="form-control" id="feedbackText" rows="6" placeholder="Provide detailed feedback on the student's task submission..." style="border: 2px solid #e9ecef; border-radius: 8px;"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 24px; border-radius: 6px; font-weight: 600;">
                    <i class="bx bx-x"></i> Close
                </button>
                <button type="button" class="btn" id="feedbackSubmitBtn" onclick="submitFeedback()" style="background: #17a2b8; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-send"></i> Submit Feedback
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
                                <p style="margin: 0; color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase;">Transaction ID</p>
                                <p style="margin: 3px 0 0 0; color: #212529; font-size: 14px; font-weight: 700;" id="receiptTxnId">TXN_20260128_001</p>
                            </div>
                            <div>
                                <p style="margin: 0; color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase;">Date</p>
                                <p style="margin: 3px 0 0 0; color: #212529; font-size: 14px; font-weight: 700;" id="receiptDate">28 Jan 2026</p>
                            </div>
                            <div>
                                <span id="receiptStatusBadge" style="background: #28a745; color: white; padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 700;">
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
                                <p style="margin: 0 0 8px 0; color: #212529; font-size: 15px; font-weight: 700;" id="receiptInternshipTitle">Full-Stack Web Development Internship</p>
                                <p style="margin: 0 0 5px 0; color: #6c757d; font-size: 13px;"><strong>Duration:</strong> <span id="receiptInternshipDuration">3 Months (10 Mar 2026 - 10 Jun 2026)</span></p>
                                <p style="margin: 0 0 5px 0; color: #6c757d; font-size: 13px;"><strong>Mode:</strong> <span id="receiptInternshipMode">Hybrid</span></p>
                                <p style="margin: 0; color: #6c757d; font-size: 13px;"><strong>Enrollment Date:</strong> <span id="receiptEnrollmentDate">28 Jan 2026</span></p>
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
                                    <td id="receiptHsn" style="padding: 12px; text-align: center; color: #6c757d; font-size: 13px;">999293</td>
                                    <td id="receiptBaseAmount" style="padding: 12px; text-align: right; color: #212529; font-size: 13px; font-weight: 600;">₹2,000.00</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #dee2e6;">
                                    <td style="padding: 12px; color: #212529; font-size: 13px;">GST @ 18%</td>
                                    <td style="padding: 12px; text-align: center; color: #6c757d; font-size: 13px;">-</td>
                                    <td id="receiptGstAmount" style="padding: 12px; text-align: right; color: #212529; font-size: 13px; font-weight: 600;">₹360.00</td>
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
                        <p id="receiptAmountInWords" style="margin: 3px 0 0 0; color: #212a62; font-size: 14px; font-weight: 600;">Two Thousand Three Hundred Sixty Rupees Only</p>
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

@endsection

@push('script')
@php
    $completionAlerts = $internship->internship_type == 2 ? [
        'tabTitle' => 'Open Complete Internship',
        'tabText' => 'You are about to review student feedback and complete this industry internship.',
        'tabConfirm' => 'Continue',
        'submitTitle' => 'Confirm Internship Completion',
        'submitHtml' => '<p>This will finalize all student feedback and mark the internship as completed.</p><p><strong>This action cannot be undone.</strong></p>',
        'submitConfirm' => '<i class="fa fa-check"></i> Yes, Complete Internship',
        'loadingTitle' => 'Completing...',
        'loadingText' => 'Please wait while we finalize the internship',
        'incompleteText' => 'Please fill in feedback for all students before submitting.',
    ] : [
        'tabTitle' => 'Open Complete Internship',
        'tabText' => 'You are about to evaluate students and submit industry marks. College marks will still be required after submission.',
        'tabConfirm' => 'Continue',
        'submitTitle' => 'Submit Industry Marks',
        'submitHtml' => '<p>This will submit industry (company) marks and feedback for all students.</p><p><strong>College marks are still required before the internship can be fully completed.</strong></p>',
        'submitConfirm' => '<i class="fa fa-check"></i> Yes, Submit Industry Marks',
        'loadingTitle' => 'Submitting...',
        'loadingText' => 'Please wait while we submit industry marks',
        'incompleteText' => 'Please fill in all industry marks and feedback for all students before submitting.',
    ];
@endphp
<!-- Include CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    let instructionsEditor;
    let taskDescriptionEditor;
    let editTaskDescriptionEditor;

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

    const internshipId = {{ $internship->id }};

    $(document).ready(function() {
        // Initialize Students DataTable (server-side)
        $('#StudentsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.internship.students-data") }}',
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                data: function(d) {
                    d.internship_id = internshipId;
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error('StudentsTable AJAX error:', textStatus, errorThrown, xhr.responseText);
                    try { var json = JSON.parse(xhr.responseText || '{}'); var msg = json.message || json.error || xhr.statusText; } catch(e) { var msg = xhr.status + ' ' + xhr.statusText; }
                    if (window.Swal) { Swal.fire({ icon: 'error', title: 'Failed to load students', text: String(msg).substring(0,200) }); } else { alert('Failed to load students: ' + msg); }
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'student_name', name: 'student_name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'university_name', name: 'university_name' },
                { data: 'college_name', name: 'college_name' },
                { data: 'degree_name', name: 'degree_name' },
                { data: 'semester', name: 'semester' },
                { data: 'enrollment_date', name: 'enrollment_date' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[8, 'desc']],
            pageLength: 10
        });

        // Initialize other tables
        $('#TasksTable').DataTable({
            order: [[3, 'desc']],
            pageLength: 10
        });

        // Debug: fetch payments once to log server response (helps diagnose empty table)
        $.ajax({
            url: '{{ route("admin.internship.payments-data", $internship->id) }}',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(res) {
                console.log('payments-data response (debug):', res);
            },
            error: function(xhr, status, err) {
                console.error('payments-data debug error:', status, err, xhr.responseText);
            }
        });

        // Initialize Payment History DataTable (AJAX)
        $('#PaymentTable').DataTable({
            processing: true,
            serverSide: false,
            ajax: function(data, callback, settings) {
                $.ajax({
                    url: '{{ route("admin.internship.payments-data", $internship->id) }}',
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    data: {
                        payment_status: $('#filterPaymentStatus') ? $('#filterPaymentStatus').val() : '',
                        payment_mode: $('#filterPaymentMode') ? $('#filterPaymentMode').val() : '',
                        date_from: $('#filterDateFrom') ? $('#filterDateFrom').val() : '',
                        date_to: $('#filterDateTo') ? $('#filterDateTo').val() : ''
                    },
                    success: function(json) {
                        console.log('payments-data ajax success:', json);
                        if (json && json.summary) {
                            $('#totalRevenue').text('₹' + Number(json.summary.total_revenue || 0).toLocaleString('en-IN'));
                            $('#totalStudents').text(json.summary.total_students_paid || 0);
                            $('#successfulPayments').text(json.summary.successful || 0);
                            $('#failedPayments').text(json.summary.failed || 0);
                        }
                        var rows = json && json.data ? json.data : (Array.isArray(json) ? json : []);
                        callback({ data: rows });
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('PaymentTable AJAX error:', textStatus, errorThrown, xhr.responseText);
                        try {
                            var json = JSON.parse(xhr.responseText || '{}');
                            var msg = json.message || json.error || xhr.statusText;
                        } catch (e) {
                            var msg = xhr.status + ' ' + xhr.statusText;
                        }
                        if (window.Swal) {
                            Swal.fire({ icon: 'error', title: 'Failed to load payments', text: String(msg).substring(0,200) });
                        } else {
                            alert('Failed to load payments: ' + msg);
                        }
                        callback({ data: [] });
                    }
                });
            },
            order: [[5, 'desc']],
            pageLength: 10,
            columns: [
                { data: 'transaction_id', name: 'transaction_id', render: function(data){ return '<strong>'+ (data || 'N/A') +'</strong>'; } },
                { data: 'student_name', name: 'student_name', render: function(data,row){ return data || row.student_name || 'N/A'; } },
                { data: 'student_email', name: 'student_email' },
                { data: 'total_amount', name: 'total_amount', render: function(data){ return '<strong>₹'+ (data ? Number(data).toLocaleString('en-IN') : '0.00') +'</strong>'; } },
                { data: 'payment_mode', name: 'payment_mode' },
                { data: 'paid_on', name: 'paid_on', render: function(data){ if(!data) return 'N/A'; var d = new Date(data); return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }); } },
                { data: 'paid_on', name: 'paid_time', render: function(data){ if(!data) return ''; var d = new Date(data); return d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true }); } },
                { data: 'payment_status', name: 'payment_status', render: function(data){ var map = {0:['Pending','bg-warning'],1:['Success','bg-success'],2:['Failed','bg-danger'],3:['Refunded','bg-info']}; var t = map[data] || ['Unknown','bg-secondary']; return '<span class="badge '+ t[1] +'">'+ t[0] +'</span>'; } },
                
            ],
            drawCallback: function() {
                // optional post-draw actions
            }
        });
        // Filter handlers for payments
        $('#applyPaymentFilters').on('click', function(){ $('#PaymentTable').DataTable().ajax.reload(); });
        $('#resetPaymentFilters').on('click', function(){ $('#filterPaymentStatus').val(''); $('#filterPaymentMode').val(''); $('#filterDateFrom').val(''); $('#filterDateTo').val(''); $('#PaymentTable').DataTable().ajax.reload(); });
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

    // Fetch payment details from server and populate receipt modal
    window.fetchAndShowReceipt = function(transactionId) {
        if (!transactionId) return;
        $.ajax({
            url: '{{ url("admin/internship/payment") }}/' + encodeURIComponent(transactionId) + '/details',
            method: 'GET',
            success: function(res) {
                if (!res || !res.success) {
                    Swal.fire({ icon: 'error', title: 'Error', text: (res && res.message) ? res.message : 'Payment not found' });
                    return;
                }
                const p = res.data;
                // Populate receipt fields
                document.getElementById('receiptTxnId').textContent = p.transaction_id || p.transactionId || '';
                document.getElementById('receiptDate').textContent = p.paid_on ? new Date(p.paid_on).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) : '';
                document.getElementById('receiptStudentName').textContent = p.user ? (p.user.name || '') : '';
                document.getElementById('receiptStudentEmail').textContent = p.user ? (p.user.email || '') : '';
                document.getElementById('receiptStudentPhone').textContent = p.user ? (p.user.contact_no || '') : '';
                document.getElementById('receiptStudentUniversity').textContent = (p.user && p.user.university) ? p.user.university : '';

                // Amounts
                const total = parseFloat(p.total_amount) || 0;
                const gst = parseFloat(p.gst_amount) || (p.payment_response_data && p.payment_response_data.gst_amount ? parseFloat(p.payment_response_data.gst_amount) : 0);
                const base = total - gst;
                document.getElementById('receiptBaseAmount').textContent = '₹' + base.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                document.getElementById('receiptGstAmount').textContent = '₹' + (gst).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                document.getElementById('receiptTotalAmount').textContent = '₹' + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                // HSN or code if available
                if (p.payment_response_data && p.payment_response_data.hsn) {
                    document.getElementById('receiptHsn').textContent = p.payment_response_data.hsn;
                }

                document.getElementById('receiptPaymentMethod').textContent = p.payment_mode || '';
                document.getElementById('receiptGateway').textContent = (p.payment_response_data && p.payment_response_data.gateway) ? p.payment_response_data.gateway : '';
                document.getElementById('receiptGatewayTxnId').textContent = (p.payment_response_data && (p.payment_response_data.gateway_txn_id || p.payment_response_data.razorpay_payment_id)) ? (p.payment_response_data.gateway_txn_id || p.payment_response_data.razorpay_payment_id) : '';

                // Internship info if provided
                if (p.internship && p.internship.internship_title) {
                    document.getElementById('receiptInternshipTitle').textContent = p.internship.internship_title;
                    const dur = (p.internship.start_date && p.internship.end_date) ? ('(' + new Date(p.internship.start_date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) + ' - ' + new Date(p.internship.end_date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) + ')') : '';
                    document.getElementById('receiptInternshipDuration').textContent = (p.internship.total_weeks ? p.internship.total_weeks + ' Weeks ' : '') + ' ' + dur;
                    document.getElementById('receiptInternshipMode').textContent = p.internship.mode || '';
                    if (p.internship.start_date) document.getElementById('receiptEnrollmentDate').textContent = new Date(p.internship.start_date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                }

                // Status badge
                var statusText = 'Pending'; var statusColor = '#ffc107';
                if (p.payment_status == 1) { statusText = 'PAID'; statusColor = '#28a745'; }
                else if (p.payment_status == 2) { statusText = 'FAILED'; statusColor = '#dc3545'; }
                else if (p.payment_status == 3) { statusText = 'REFUNDED'; statusColor = '#17a2b8'; }
                var badgeEl = document.getElementById('receiptStatusBadge');
                if (badgeEl) { badgeEl.innerHTML = '<i class="bx bx-check-circle"></i> ' + statusText; badgeEl.style.background = statusColor; }

                // Amount in words (rupees only)
                function numberToWords(num) {
                    var a = ['','One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen','Seventeen','Eighteen','Nineteen'];
                    var b = ['', '', 'Twenty','Thirty','Forty','Fifty','Sixty','Seventy','Eighty','Ninety'];
                    if ((num = num.toString()).length > 9) return 'Amount too large';
                    var n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{3})$/);
                    if (!n) return; var str = '';
                    str += (n[1] != 0) ? (a[Number(n[1])] + ' Crore ') : '';
                    str += (n[2] != 0) ? (a[Number(n[2])] + ' Lakh ') : '';
                    str += (n[3] != 0) ? (a[Number(n[3])] + ' Thousand ') : '';
                    var hundreds = Number(n[4]);
                    if (hundreds) {
                        if (hundreds < 20) str += a[hundreds] + ' '; else str += b[Math.floor(hundreds/10)] + (hundreds%10? ' ' + a[hundreds%10] : '') + ' ';
                        str += 'Rupees Only';
                    }
                    return str.trim();
                }
                document.getElementById('receiptAmountInWords').textContent = numberToWords(Math.floor(total)) || '';

                // Generated date now
                const now = new Date();
                const generatedDate = now.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) + ', ' + now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
                document.getElementById('receiptGeneratedDate').textContent = generatedDate;

                // Show receipt modal
                const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
                receiptModal.show();
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to fetch payment details' });
            }
        });
    }

    // Save Task
    window.saveTask = function() {
        const form = document.getElementById('addTaskForm');
        
        // Check HTML5 validation
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Validate file type if file is selected
        const fileInput = document.getElementById('taskFile');
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const fileExtension = file.name.split('.').pop().toLowerCase();
            
            if (fileExtension !== 'pdf') {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type',
                    text: 'Only PDF files are allowed!'
                });
                return;
            }
            
            // Check file size (10MB = 10 * 1024 * 1024 bytes)
            if (file.size > 10 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: 'File size must be less than 10MB!'
                });
                return;
            }
        }

        // Validate CKEditor content
        if (taskDescriptionEditor) {
            const editorContent = taskDescriptionEditor.getData().trim();
            if (!editorContent || editorContent === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Module and Task Description is required!'
                });
                return;
            }

            const formData = new FormData();
            formData.append('date_time', document.getElementById('taskDateTime').value);
            formData.append('day', document.getElementById('taskDay').value);
            formData.append('module_title', document.getElementById('moduleTitle').value);
            formData.append('module_description', editorContent);
            formData.append('last_submission_date', document.getElementById('lastSubmissionDate').value);
            formData.append('online_link', document.getElementById('onlineLink').value);
            formData.append('is_final_assignment', document.getElementById('isFinalAssignment').checked ? 1 : 0);
            
            // Handle file upload
            if (fileInput.files.length > 0) {
                formData.append('upload_file', fileInput.files[0]);
            }

            // Send to server
            $.ajax({
                url: '{{ route("admin.internship.tasks.store", $internship->id) }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        const addTaskModal = bootstrap.Modal.getInstance(document.getElementById('addTaskModal'));
                        if (addTaskModal) {
                            addTaskModal.hide();
                        }
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'Task added successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        
                        form.reset();
                        taskDescriptionEditor.setData('');
                        
                        // Reload tasks table
                        loadTasks();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message || 'Failed to add task'
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Failed to add task';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage
                    });
                }
            });
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
            
            // Send to server
            $.ajax({
                url: '{{ route("admin.internship.updateInstructions", $internship->id) }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    general_instructions: content
                },
                success: function(response) {
                    if (response.success) {
                        document.getElementById('instructionsContent').innerHTML = content;
                        const instructionsModal = bootstrap.Modal.getInstance(document.getElementById('instructionsModal'));
                        if (instructionsModal) {
                            instructionsModal.hide();
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'Instructions updated successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message || 'Failed to update instructions'
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Failed to update instructions';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage
                    });
                }
            });
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
        // Redirect to server endpoint to generate/download PDF
        const transactionId = (document.getElementById('receiptTxnId').textContent || '').trim();
        if (!transactionId) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Transaction ID not found' });
            return;
        }
        const url = '{{ url("admin/internship/payment") }}/' + encodeURIComponent(transactionId) + '/receipt';
        // Navigate to download URL
        window.location = url;
    }

    // View Student Details
    window.viewStudentDetails = function(studentId) {
        alert('View student details for ID: ' + studentId);
    }

    // Edit Task
    window.editTask = function(taskId) {
        // Fetch task data
        $.ajax({
            url: '{{ route("admin.internship.tasks.get", $internship->id) }}',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const task = response.data.find(t => t.id === taskId);
                    if (task) {
                        // Populate form fields
                        document.getElementById('editTaskId').value = task.id;
                        
                        // Format datetime for datetime-local input
                        const dateTime = new Date(task.date_time);
                        const formattedDateTime = dateTime.toISOString().slice(0, 16);
                        document.getElementById('editTaskDateTime').value = formattedDateTime;
                        
                        document.getElementById('editTaskDay').value = task.day || '';
                        document.getElementById('editModuleTitle').value = task.module_title;
                        
                        // Format date for date input
                        const submissionDate = new Date(task.last_submission_date);
                        const formattedDate = submissionDate.toISOString().split('T')[0];
                        document.getElementById('editLastSubmissionDate').value = formattedDate;
                        
                        document.getElementById('editOnlineLink').value = task.online_link || '';
                        document.getElementById('editIsFinalAssignment').checked = task.is_final_assignment == 1;
                        
                        // Show current file if exists
                        if (task.upload_file) {
                            document.getElementById('editCurrentFile').textContent = 'Current file: ' + task.upload_file;
                        } else {
                            document.getElementById('editCurrentFile').textContent = '';
                        }
                        
                        // Initialize or update CKEditor for edit modal
                        if (!editTaskDescriptionEditor) {
                            ClassicEditor
                                .create(document.querySelector('#editTaskDescriptionEditor'), {
                                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'blockQuote', 'insertTable', '|', 'imageUpload', '|', 'undo', 'redo']
                                })
                                .then(editor => {
                                    editTaskDescriptionEditor = editor;
                                    editor.setData(task.module_description || '');
                                })
                                .catch(error => {
                                    console.error(error);
                                });
                        } else {
                            editTaskDescriptionEditor.setData(task.module_description || '');
                        }
                        
                        // Open modal
                        const editTaskModal = new bootstrap.Modal(document.getElementById('editTaskModal'));
                        editTaskModal.show();
                    }
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to fetch task data'
                });
            }
        });
    }

    // Update Task
    window.updateTask = function() {
        const form = document.getElementById('editTaskForm');
        
        // Check HTML5 validation
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Validate file type if file is selected
        const fileInput = document.getElementById('editTaskFile');
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const fileExtension = file.name.split('.').pop().toLowerCase();
            
            if (fileExtension !== 'pdf') {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type',
                    text: 'Only PDF files are allowed!'
                });
                return;
            }
            
            // Check file size (10MB = 10 * 1024 * 1024 bytes)
            if (file.size > 10 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: 'File size must be less than 10MB!'
                });
                return;
            }
        }

        // Validate CKEditor content
        if (editTaskDescriptionEditor) {
            const editorContent = editTaskDescriptionEditor.getData().trim();
            if (!editorContent || editorContent === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Module and Task Description is required!'
                });
                return;
            }

            const taskId = document.getElementById('editTaskId').value;
            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('date_time', document.getElementById('editTaskDateTime').value);
            formData.append('day', document.getElementById('editTaskDay').value);
            formData.append('module_title', document.getElementById('editModuleTitle').value);
            formData.append('module_description', editorContent);
            formData.append('last_submission_date', document.getElementById('editLastSubmissionDate').value);
            formData.append('online_link', document.getElementById('editOnlineLink').value);
            formData.append('is_final_assignment', document.getElementById('editIsFinalAssignment').checked ? 1 : 0);
            
            // Handle file upload
            if (fileInput.files.length > 0) {
                formData.append('upload_file', fileInput.files[0]);
            }

            // Send to server
            $.ajax({
                url: '{{ route("admin.internship.tasks.update", ":taskId") }}'.replace(':taskId', taskId),
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        const editTaskModal = bootstrap.Modal.getInstance(document.getElementById('editTaskModal'));
                        if (editTaskModal) {
                            editTaskModal.hide();
                        }
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'Task updated successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        
                        // Reload tasks table
                        loadTasks();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message || 'Failed to update task'
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Failed to update task';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage
                    });
                }
            });
        }
    }

    // Auto-fill Day field when Date & Time is selected in Edit Modal
    $('#editTaskDateTime').on('change', function() {
        const dateValue = $(this).val();
        if (dateValue) {
            const date = new Date(dateValue);
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const dayName = days[date.getDay()];
            $('#editTaskDay').val(dayName);
        }
    });

    // Delete Task
    window.deleteTask = function(taskId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.internship.tasks.delete", ":taskId") }}'.replace(':taskId', taskId),
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message || 'Task deleted successfully!',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            // Reload tasks table
                            loadTasks();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to delete task'
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Failed to delete task';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage
                        });
                    }
                });
            }
        });
    }

    // Load Tasks into DataTable
    function loadTasks() {
        $.ajax({
            url: '{{ route("admin.internship.tasks.get", $internship->id) }}',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const tasks = response.data;
                    const tbody = $('#TasksTable tbody');
                    tbody.empty();
                    
                    if (tasks.length === 0) {
                        tbody.append('<tr><td colspan="8" class="text-center">No tasks found</td></tr>');
                        return;
                    }
                    
                    tasks.forEach((task, index) => {
                        const dateTime = new Date(task.date_time);
                        const dateTimeStr = dateTime.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) + ' ' + 
                                          dateTime.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
                        const dueDate = new Date(task.last_submission_date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                        const day = task.day || 'N/A';
                        
                        const baseUrl = '{{ url("/") }}';
                        const fileLink = task.upload_file 
                            ? `<a href="${baseUrl}/uploads/internship_tasks/${task.upload_file}" target="_blank" class="badge bg-info"><i class="bx bx-show"></i> View File</a>`
                            : '<span class="text-muted">No file</span>';
                        
                        const submittedCellId = 'submissions-' + task.id;

                        const submittedBadge = `<span id="${submittedCellId}" class="badge bg-secondary">Loading...</span>`;

                        const row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${task.module_title}</td>
                                <td>${dateTimeStr}</td>
                                <td>${day}</td>
                                <td>${dueDate}</td>
                                <td>${fileLink}</td>
                                <td id="${submittedCellId}_cell">${submittedBadge}</td>
                                <td>
                                    <button class="btn btn-action-view btn-edit-view btn-sm me-1" onclick="editTask(${task.id})">
                                        <i class="bx bx-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-action-view btn-view-submission btn-sm me-1" onclick="viewSubmissions(${task.id})">
                                        <i class="bx bx-show"></i> View Submissions
                                    </button>
                                    <button class="btn btn-action-view btn-reject btn-sm" onclick="deleteTask(${task.id})">
                                        <i class="bx bx-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                        // Fetch submission counts for this task and update the badge
                        (function(tid, badgeId) {
                            $.ajax({
                                url: '{{ url("admin/internship/task") }}/' + tid + '/submissions',
                                method: 'GET',
                                success: function(r) {
                                    try {
                                        if (r && (r.completed !== undefined) && (r.total !== undefined)) {
                                            const el = document.getElementById(badgeId);
                                            if (el) el.textContent = `${r.completed}/${r.total} Submitted`;
                                        } else if (r && r.students) {
                                            const completed = r.completed || 0;
                                            const total = r.total || r.students.length || 0;
                                            const el = document.getElementById(badgeId);
                                            if (el) el.textContent = `${completed}/${total} Submitted`;
                                        }
                                    } catch (e) { console.error(e); }
                                },
                                error: function() {
                                    // leave the loading text or set to 0/0 on error
                                    const el = document.getElementById(badgeId);
                                    if (el) el.textContent = '0/0 Submitted';
                                }
                            });
                        })(task.id, submittedCellId);
                    });
                }
            },
            error: function(xhr) {
                console.error('Failed to load tasks:', xhr);
            }
        });
    }

    // Auto-fill Day field when Date & Time is selected
    $('#taskDateTime').on('change', function() {
        const dateValue = $(this).val();
        if (dateValue) {
            const date = new Date(dateValue);
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const dayName = days[date.getDay()];
            $('#taskDay').val(dayName);
        }
    });

    // Load tasks when Manage Tasks tab is clicked
    $('button[data-bs-target="#tasks"]').on('click', function() {
        loadTasks();
    });

    // Current master task ID (set when viewSubmissions is called)
    var currentMasterTaskId = null;
    var currentFeedbackTaskId = null;
    var currentFeedbackStudentId = null;

    // View Submissions — fetch from server
    window.viewSubmissions = function(taskId) {
        currentMasterTaskId = taskId;
        document.getElementById('submissionTableBody').innerHTML = '<tr><td colspan="8" class="text-center py-4"><i class="bx bx-loader-alt bx-spin"></i> Loading...</td></tr>';
        document.getElementById('completedCount').textContent = '-';
        document.getElementById('pendingCount').textContent = '-';
        document.getElementById('totalCount').textContent = '-';
        document.getElementById('submissionSummary').textContent = '';

        const submissionsModal = new bootstrap.Modal(document.getElementById('viewSubmissionsModal'));
        // Ensure any open note/feedback modals are closed before showing submissions
        try {
            const noteEl = document.getElementById('studentNoteModal');
            const noteInst = bootstrap.Modal.getInstance(noteEl);
            if (noteInst) noteInst.hide();
        } catch (e) {}
        try {
            const fbEl = document.getElementById('taskFeedbackModal');
            const fbInst = bootstrap.Modal.getInstance(fbEl);
            if (fbInst) fbInst.hide();
        } catch (e) {}

        submissionsModal.show();

        $.ajax({
            url: '{{ url("admin/internship/task") }}/' + taskId + '/submissions',
            method: 'GET',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function(res) {
                document.getElementById('taskTitleSubmission').textContent = 'Task: ' + (res.task_title || 'Untitled');
                document.getElementById('completedCount').textContent = res.completed || 0;
                document.getElementById('pendingCount').textContent = res.pending || 0;
                document.getElementById('totalCount').textContent = res.total || 0;
                document.getElementById('submissionSummary').textContent = (res.completed || 0) + '/' + (res.total || 0) + ' Submitted';

                if (!res.students || res.students.length === 0) {
                    document.getElementById('submissionTableBody').innerHTML = '<tr><td colspan="8" class="text-center py-4 text-muted">No student submissions found.</td></tr>';
                    return;
                }

                var colors = [
                    'linear-gradient(135deg, #242a62, #3a4282)',
                    'linear-gradient(135deg, #f26e2c, #ff8548)',
                    'linear-gradient(135deg, #6f42c1, #8c5dd8)',
                    'linear-gradient(135deg, #28a745, #48c768)',
                    'linear-gradient(135deg, #17a2b8, #3cbdd4)'
                ];

                var rows = '';
                res.students.forEach(function(s, idx) {
                    var initial = (s.name && s.name.length > 0) ? s.name.charAt(0).toUpperCase() : '?';
                    var color = colors[idx % colors.length];
                    var isComplete = s.status === 1;

                    var statusBadge = isComplete
                        ? '<span class="badge" style="background:#28a745;color:#fff;padding:6px 12px;font-size:12px;border-radius:20px;"><i class="bx bx-check-circle"></i> Complete</span>'
                        : '<span class="badge" style="background:#ffc107;color:#000;padding:6px 12px;font-size:12px;border-radius:20px;"><i class="bx bx-time"></i> Pending</span>';

                    var viewFileBtn = (isComplete && s.student_submit_file)
                        ? '<button class="btn btn-sm" style="background:#6f42c1;color:#fff;border:none;padding:5px 12px;border-radius:5px;font-size:12px;" onclick="viewSubmittedFile(\'' + s.student_submit_file.replace(/'/g, "\\'") + '\')"><i class="bx bx-file"></i> View File</button>'
                        : '<span style="color:#6c757d;font-size:12px;">-</span>';

                    var escapedName = (s.name || '').replace(/'/g, "\\'");
                    var noteBtn = isComplete
                        ? '<button class="btn btn-sm" style="background:#f26e2c;color:#fff;border:none;padding:5px 12px;border-radius:5px;font-size:12px;" onclick="viewStudentNote(' + currentMasterTaskId + ',' + s.student_id + ',\'' + escapedName + '\')"><i class="bx bx-note"></i> Note</button>'
                        : '<span style="color:#6c757d;font-size:12px;">-</span>';

                    var feedbackBtn = '<button class="btn btn-sm" style="background:#17a2b8;color:#fff;border:none;padding:5px 12px;border-radius:5px;font-size:12px;" onclick="viewTaskFeedback(' + currentMasterTaskId + ',' + s.student_id + ',\'' + escapedName + '\')"><i class="bx bx-message-dots"></i> Feedback</button>';

                    rows += '<tr>'
                        + '<td style="padding:12px;vertical-align:middle;">' + (idx + 1) + '</td>'
                        + '<td style="padding:12px;vertical-align:middle;"><div style="display:flex;align-items:center;"><div style="width:36px;height:36px;border-radius:50%;background:' + color + ';color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;margin-right:10px;">' + initial + '</div><span style="font-weight:600;color:#212529;">' + (s.name || 'N/A') + '</span></div></td>'
                        + '<td style="padding:12px;vertical-align:middle;color:#6c757d;font-size:13px;">' + (s.email || 'N/A') + '</td>'
                        + '<td style="padding:12px;vertical-align:middle;color:#212529;font-size:13px;font-weight:500;">' + (s.task_title || '') + '</td>'
                        + '<td style="padding:12px;vertical-align:middle;">' + statusBadge + '</td>'
                        + '<td style="padding:12px;vertical-align:middle;text-align:center;">' + viewFileBtn + '</td>'
                        + '<td style="padding:12px;vertical-align:middle;text-align:center;">' + noteBtn + '</td>'
                        + '<td style="padding:12px;vertical-align:middle;text-align:center;">' + feedbackBtn + '</td>'
                        + '</tr>';
                });

                document.getElementById('submissionTableBody').innerHTML = rows;
            },
            error: function(xhr) {
                document.getElementById('submissionTableBody').innerHTML = '<tr><td colspan="8" class="text-center py-4 text-danger">Failed to load submissions.</td></tr>';
                console.error('getTaskSubmissions error', xhr.responseText);
            }
        });
    }

    // View Submitted File — open in new tab (student submissions folder)
    window.viewSubmittedFile = function(filePath) {
        if (!filePath) { alert('No file available.'); return; }
        window.open('{{ asset("uploads/internship_tasks_submit") }}/' + filePath, '_blank');
    }

    // View Student Note — fetch from server
    window.viewStudentNote = function(taskId, studentId, studentName) {
        document.getElementById('studentNoteName').textContent = 'Student: ' + studentName;
        document.getElementById('noteTaskTitle').textContent = 'Loading...';
        document.getElementById('noteSubmitDate').textContent = '-';
        document.getElementById('noteContent').innerHTML = '<p class="text-muted">Loading...</p>';
        document.getElementById('noteProjectLink').innerHTML = '-';

        // Hide submissions modal (if open) before showing note
        try {
            const subsEl = document.getElementById('viewSubmissionsModal');
            const subsInst = bootstrap.Modal.getInstance(subsEl);
            if (subsInst) subsInst.hide();
        } catch (e) {}

        const noteModalEl = document.getElementById('studentNoteModal');
        var noteModal = new bootstrap.Modal(noteModalEl);
        noteModal.show();

        // When note modal is closed, reopen submissions modal once
        noteModalEl.addEventListener('hidden.bs.modal', function() {
            try {
                if (currentMasterTaskId) {
                    const subsModal = new bootstrap.Modal(document.getElementById('viewSubmissionsModal'));
                    subsModal.show();
                }
            } catch (e) {}
        }, { once: true });

        $.ajax({
            url: '{{ url("admin/internship/task") }}/' + taskId + '/student/' + studentId + '/note',
            method: 'GET',
            success: function(res) {
                document.getElementById('noteTaskTitle').textContent = res.task_title || '-';
                document.getElementById('noteSubmitDate').textContent = res.submit_on || '-';

                // Status badge
                var statusHtml = res.status === 1
                    ? '<span class="badge" style="background:#28a745;color:#fff;padding:4px 10px;font-size:11px;border-radius:12px;"><i class="bx bx-check-circle"></i> Submitted</span>'
                    : '<span class="badge" style="background:#ffc107;color:#000;padding:4px 10px;font-size:11px;border-radius:12px;"><i class="bx bx-time"></i> Pending</span>';
                document.getElementById('noteStatus').innerHTML = statusHtml;

                // File
                if (res.student_submit_file) {
                    var fileUrl = '{{ asset("uploads/internship_tasks_submit") }}/' + res.student_submit_file;
                    var fileName = res.student_submit_file.split('/').pop();
                    document.getElementById('noteFile').innerHTML = '<a href="' + fileUrl + '" target="_blank" class="badge bg-info" style="text-decoration:none;"><i class="bx bx-download"></i> View File</a>';
                } else {
                    document.getElementById('noteFile').innerHTML = '<span class="text-muted">No file uploaded</span>';
                }

                // Description
                if (res.student_submit_description) {
                    document.getElementById('noteContent').innerHTML = '<p style="margin:0;color:#495057;font-size:14px;line-height:1.6;">' + res.student_submit_description + '</p>';
                } else {
                    document.getElementById('noteContent').innerHTML = '<p class="text-muted">No description provided.</p>';
                }

                // Project link
                if (res.student_submit_project_link) {
                    document.getElementById('noteProjectLink').innerHTML = '<a href="' + res.student_submit_project_link + '" target="_blank" style="color:#17a2b8;font-size:14px;text-decoration:none;font-weight:500;"><i class="bx bx-link-external"></i> ' + res.student_submit_project_link + '</a>';
                } else {
                    document.getElementById('noteProjectLink').innerHTML = '<span class="text-muted">No project link provided.</span>';
                }
            },
            error: function(xhr) {
                document.getElementById('noteContent').innerHTML = '<p class="text-danger">Failed to load note.</p>';
                console.error('getStudentTaskNote error', xhr.responseText);
            }
        });
    }

    // View/Submit Feedback
    window.viewTaskFeedback = function(taskId, studentId, studentName) {
        currentFeedbackTaskId = taskId;
        currentFeedbackStudentId = studentId;

        document.getElementById('feedbackStudentName').textContent = studentName || 'Loading...';
        document.getElementById('feedbackTaskTitle').textContent = 'Loading...';
        document.getElementById('feedbackStatus').innerHTML = '-';
        document.getElementById('feedbackViewSection').style.display = 'none';
        document.getElementById('feedbackFormSection').style.display = 'block';
        document.getElementById('feedbackSubmitBtn').style.display = '';
        document.getElementById('feedbackText').value = '';

        // Hide submissions modal (if open) before showing feedback
        try {
            const subsEl = document.getElementById('viewSubmissionsModal');
            const subsInst = bootstrap.Modal.getInstance(subsEl);
            if (subsInst) subsInst.hide();
        } catch (e) {}

        const fbModalEl = document.getElementById('taskFeedbackModal');
        var fbModal = new bootstrap.Modal(fbModalEl);
        fbModal.show();

        // When feedback modal is closed, reopen submissions modal once
        fbModalEl.addEventListener('hidden.bs.modal', function() {
            try {
                if (currentMasterTaskId) {
                    const subsModal = new bootstrap.Modal(document.getElementById('viewSubmissionsModal'));
                    subsModal.show();
                }
            } catch (e) {}
        }, { once: true });

        $.ajax({
            url: '{{ url("admin/internship/task") }}/' + taskId + '/student/' + studentId + '/feedback',
            method: 'GET',
            success: function(res) {
                document.getElementById('feedbackTaskTitle').textContent = res.task_title || '-';
                var stHtml = res.status === 1
                    ? '<span class="badge" style="background:#28a745;color:#fff;padding:4px 10px;font-size:11px;border-radius:12px;"><i class="bx bx-check-circle"></i> Submitted</span>'
                    : '<span class="badge" style="background:#ffc107;color:#000;padding:4px 10px;font-size:11px;border-radius:12px;"><i class="bx bx-time"></i> Pending</span>';
                document.getElementById('feedbackStatus').innerHTML = stHtml;

                if (res.task_feedback) {
                    document.getElementById('feedbackViewSection').style.display = 'block';
                    document.getElementById('feedbackFormSection').style.display = 'none';
                    var fbBtn = document.getElementById('feedbackSubmitBtn');
                    if (fbBtn) {
                        fbBtn.classList.add('d-none');
                        fbBtn.disabled = true;
                    }
                    document.getElementById('feedbackViewContent').textContent = res.task_feedback;
                } else {
                    document.getElementById('feedbackViewSection').style.display = 'none';
                    document.getElementById('feedbackFormSection').style.display = 'block';
                    var fbBtn2 = document.getElementById('feedbackSubmitBtn');
                    if (fbBtn2) {
                        fbBtn2.classList.remove('d-none');
                        fbBtn2.disabled = false;
                    }
                }
            },
            error: function(xhr) {
                console.error('getTaskFeedback error', xhr.responseText);
            }
        });
    }

    // Submit Feedback
    window.submitFeedback = function() {
        var feedbackText = document.getElementById('feedbackText').value.trim();
        if (!feedbackText) {
            if (window.Swal) { Swal.fire({ icon: 'warning', title: 'Required', text: 'Please enter feedback before submitting.' }); }
            else { alert('Please enter feedback before submitting.'); }
            return;
        }

        $('#feedbackSubmitBtn').prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin"></i> Saving...');

        $.ajax({
            url: '{{ route("admin.internship.task.feedback.save") }}',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            data: {
                task_id: currentFeedbackTaskId,
                student_id: currentFeedbackStudentId,
                feedback: feedbackText
            },
            success: function(res) {
                if (res.success) {
                    document.getElementById('feedbackViewSection').style.display = 'block';
                    document.getElementById('feedbackFormSection').style.display = 'none';
                    var fbBtn = document.getElementById('feedbackSubmitBtn');
                    if (fbBtn) {
                        fbBtn.classList.add('d-none');
                        fbBtn.disabled = true;
                        fbBtn.removeAttribute('onclick');
                    }
                    document.getElementById('feedbackViewContent').textContent = res.task_feedback || feedbackText;

                    if (window.Swal) { Swal.fire({ icon: 'success', title: 'Success', text: 'Feedback submitted successfully!', timer: 2000, showConfirmButton: false }); }
                } else {
                    if (window.Swal) { Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Failed to save feedback.' }); }
                    // re-enable button so user can retry
                    var fbBtnErr = document.getElementById('feedbackSubmitBtn');
                    if (fbBtnErr) {
                        fbBtnErr.disabled = false;
                        $(fbBtnErr).html('<i class="bx bx-send"></i> Submit Feedback');
                        fbBtnErr.classList.remove('d-none');
                    }
                }
            },
            error: function(xhr) {
                console.error('saveTaskFeedback error', xhr.responseText);
                var msg = 'Failed to save feedback.';
                try { var j = JSON.parse(xhr.responseText); msg = j.message || msg; } catch(e){}
                if (window.Swal) { Swal.fire({ icon: 'error', title: 'Error', text: msg }); }
                else { alert(msg); }
                $('#feedbackSubmitBtn').prop('disabled', false).html('<i class="bx bx-send"></i> Submit Feedback');
            }
        });
    }

    // View Payment Details
   

    const completionInternshipId = {{ $internship->id }};
    const csrfToken = '{{ csrf_token() }}';
    const internshipType = {{ $internship->internship_type }};
    const completionAlerts = @json($completionAlerts);
    let marksLoaded = false;

    // Complete Internship - SweetAlert on tab click
    $('#complete-tab').on('click', function(e) {
        // Only show confirmation if internship is not yet completed AND industry-only (not waiting on college)
        @if(!$internship->complete_status && !($internship->company_complete_sts == 1 && $internship->college_complete_sts == 0))
        e.preventDefault();
        e.stopImmediatePropagation();
        
        Swal.fire({
            title: completionAlerts.tabTitle,
            text: completionAlerts.tabText,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#242a62',
            cancelButtonColor: '#6c757d',
            confirmButtonText: completionAlerts.tabConfirm,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Activate the tab manually
                var tab = new bootstrap.Tab(document.getElementById('complete-tab'));
                tab.show();
                // Load saved marks on first open
                loadSavedMarks();
            }
        });
        @else
        // Already completed or college pending — just load marks for display
        loadSavedMarks();
        @endif
    });

    // ==================== AUTO-SAVE MARKS ON INPUT ====================
    let saveTimer = {};

    $(document).on('input', '.industry-mark', function() {
        const input = $(this);
        const max = parseFloat(input.data('max'));
        let value = parseFloat(input.val()) || 0;

        // Clamp value
        if (value > max) {
            input.val(max);
            value = max;
        }
        if (value < 0) {
            input.val(0);
            value = 0;
        }

        // Recalculate row
        calculateMarks(input.closest('tr')[0]);

        // Debounced auto-save (300ms)
        const studentId = input.data('student-id');
        const criteriaId = input.data('criteria-id');
        const criteriaName = input.data('criteria-name');
        const maxMarks = input.data('max');
        const key = studentId + '_' + criteriaId;

        clearTimeout(saveTimer[key]);
        saveTimer[key] = setTimeout(function() {
            $.ajax({
                url: '{{ route("admin.internship.save-marks") }}',
                method: 'POST',
                data: {
                    _token: csrfToken,
                    internship_id: completionInternshipId,
                    student_id: studentId,
                    criteria_id: criteriaId,
                    criteria_name: criteriaName,
                    max_marks: maxMarks,
                    marks: value
                },
                success: function(res) {
                    if (res.success) {
                        input.css('border-color', '#28a745');
                        setTimeout(() => input.css('border-color', ''), 1500);
                    }
                },
                error: function(xhr) {
                    input.css('border-color', '#dc3545');
                    console.error('Auto-save failed:', xhr.responseJSON);
                }
            });
        }, 300);
    });

    // ==================== AUTO-SAVE FEEDBACK ====================
    let feedbackTimer = {};

    $(document).on('input', '.feedback-textarea', function() {
        const textarea = $(this);
        const studentId = textarea.data('student-id');
        const feedback = textarea.val();

        clearTimeout(feedbackTimer[studentId]);
        feedbackTimer[studentId] = setTimeout(function() {
            $.ajax({
                url: '{{ route("admin.internship.save-feedback") }}',
                method: 'POST',
                data: {
                    _token: csrfToken,
                    internship_id: completionInternshipId,
                    student_id: studentId,
                    feedback: feedback
                },
                success: function(res) {
                    if (res.success) {
                        textarea.css('border-color', '#28a745');
                        setTimeout(() => textarea.css('border-color', ''), 1500);
                    }
                },
                error: function() {
                    textarea.css('border-color', '#dc3545');
                }
            });
        }, 500);
    });

    // ==================== LOAD SAVED MARKS ON PAGE ====================
    function loadSavedMarks() {
        if (marksLoaded) {
            // Just recalculate
            document.querySelectorAll('#completionTable tbody tr[data-student-id]').forEach(row => calculateMarks(row));
            return;
        }
        marksLoaded = true;

        $.ajax({
            url: '{{ route("admin.internship.fetch-marks", $internship->id) }}',
            method: 'GET',
            success: function(res) {
                if (res.success && res.data) {
                    $.each(res.data, function(studentId, data) {
                        // Fill marks (new format: criteria values are objects with marks/criteria_name/max_marks)
                        if (data.criteria) {
                            $.each(data.criteria, function(criteriaId, criteriaData) {
                                const marks = typeof criteriaData === 'object' ? criteriaData.marks : criteriaData;
                                const input = $(`.industry-mark[data-student-id="${studentId}"][data-criteria-id="${criteriaId}"]`);
                                if (input.length && !input.val()) {
                                    input.val(marks);
                                }
                            });
                        }
                        // Fill feedback (now from tbl_internship_application)
                        if (data.feedback) {
                            const textarea = $(`.feedback-textarea[data-student-id="${studentId}"]`);
                            if (textarea.length && !textarea.val()) {
                                textarea.val(data.feedback);
                            }
                        }
                    });
                }
                // Recalculate all rows
                document.querySelectorAll('#completionTable tbody tr[data-student-id]').forEach(row => calculateMarks(row));
            }
        });
    }

    // ==================== CALCULATION LOGIC ====================
    function calculateMarks(row) {
        // No numeric calculations for internship type 2 (only feedback required)
        if (parseInt(internshipType) !== 1) return;

        const inputs = row.querySelectorAll('.industry-mark');
        let total = 0;
        let maxTotal = 0;

        inputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            const max = parseFloat(input.getAttribute('data-max')) || 0;
            if (value > max) {
                input.value = max;
                total += max;
            } else {
                total += value;
            }
            maxTotal += max;
        });

        const percentage = maxTotal > 0 ? ((total / maxTotal) * 100).toFixed(2) : 0;

        let grade = '-';
        let gradeClass = 'grade-F';
        if (percentage >= 90) { grade = 'A+'; gradeClass = 'grade-A'; }
        else if (percentage >= 80) { grade = 'A'; gradeClass = 'grade-A'; }
        else if (percentage >= 70) { grade = 'B'; gradeClass = 'grade-B'; }
        else if (percentage >= 60) { grade = 'C'; gradeClass = 'grade-C'; }
        else if (percentage >= 50) { grade = 'D'; gradeClass = 'grade-D'; }
        else if (percentage > 0) { grade = 'F'; gradeClass = 'grade-F'; }

        const totalEl = row.querySelector('.total-display');
        const percentEl = row.querySelector('.percentage-display');
        const gradeBadge = row.querySelector('.grade-badge');

        if (totalEl) totalEl.textContent = `${total} / ${maxTotal}`;
        if (percentEl) percentEl.textContent = `${percentage}%`;
        if (gradeBadge) {
            gradeBadge.textContent = grade;
            gradeBadge.className = `grade-badge ${gradeClass}`;
        }
    }

    // Recalculate on page load if pre-filled values exist
    $(document).ready(function() {
        document.querySelectorAll('#completionTable tbody tr[data-student-id]').forEach(row => calculateMarks(row));
    });

    // ==================== SHOW CONFIRM MODAL ====================
    window.showConfirmModal = function() {
        const rows = document.querySelectorAll('#completionTable tbody tr[data-student-id]');
        let allFilled = true;
        let errorMessages = [];

        rows.forEach(row => {
            const studentName = row.querySelector('td:nth-child(2)').textContent.trim();
            const feedback = row.querySelector('.feedback-textarea');

            if (parseInt(internshipType) === 1) {
                const inputs = row.querySelectorAll('.industry-mark');
                inputs.forEach(input => {
                    if (!input.value || parseFloat(input.value) === 0) {
                        allFilled = false;
                    }
                });
            }

            if (!feedback || !feedback.value.trim()) {
                allFilled = false;
                errorMessages.push(studentName);
            }
        });

        if (!allFilled) {
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Data',
                text: completionAlerts.incompleteText
            });
            return;
        }

        Swal.fire({
            title: completionAlerts.submitTitle,
            html: completionAlerts.submitHtml,
            icon: parseInt(internshipType) === 2 ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: completionAlerts.submitConfirm,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                confirmCompletion();
            }
        });
    }

    // ==================== FINAL SUBMIT ====================
    window.confirmCompletion = function() {
        Swal.fire({
            title: completionAlerts.loadingTitle,
            text: completionAlerts.loadingText,
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: '{{ route("admin.internship.submit-completion") }}',
            method: 'POST',
            data: {
                _token: csrfToken,
                internship_id: completionInternshipId
            },
            success: function(res) {
                if (res.success) {
                    // Clear any pending autosave timers (if present) and disable submit
                    try { Object.keys(saveTimer).forEach(k => clearTimeout(saveTimer[k])); } catch(e) {}
                    try { Object.keys(feedbackTimer).forEach(k => clearTimeout(feedbackTimer[k])); } catch(e) {}
                    $('.btn-complete-internship-submit').prop('disabled', true).addClass('disabled');

                    // Unbind and replace inputs with readonly displays
                    function escapeHtml(str) { return $('<div>').text(str).html(); }
                    $(document).off('input', '.industry-mark');
                    $(document).off('input', '.feedback-textarea');
                    $('.industry-mark').each(function() {
                        const $i = $(this);
                        const v = $i.val() || '';
                        $i.replaceWith('<span class="readonly-mark">' + escapeHtml(v) + '</span>');
                    });
                    $('.feedback-textarea').each(function() {
                        const $t = $(this);
                        const v = $t.val() || '';
                        $t.replaceWith('<div class="readonly-feedback">' + escapeHtml(v) + '</div>');
                    });

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: res.message,
                        timer: 1400,
                        showConfirmButton: false
                    });

                    // Reload shortly to refresh banners and server state
                    setTimeout(function() { location.reload(); }, 1500);
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                }
            },
            error: function(xhr) {
                let msg = 'An error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            }
        });
    }

    // ==================== EXPORT TO EXCEL ====================
    window.exportToExcel = function() {
        Swal.fire({
            title: 'Export Excel',
            text: 'Enter file name',
            input: 'text',
            inputPlaceholder: 'internship_report',
            inputAttributes: { autocapitalize: 'off' },
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-download"></i> Download',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#242a62',
            cancelButtonColor: '#6c757d',
            inputValidator: (value) => {
                if (!value || !value.trim()) return 'Please enter a file name';
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                const filename = result.value.trim().replace(/[^a-zA-Z0-9_\-]/g, '_') || 'internship_report';
                const table = document.querySelector('#completionTable');
                const clone = table.cloneNode(true);

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

                const wb = XLSX.utils.book_new();
                const ws = XLSX.utils.table_to_sheet(clone);
                XLSX.utils.book_append_sheet(wb, ws, 'Internship Report');
                XLSX.writeFile(wb, filename + '.xlsx');
            }
        });
    }

    // Open Payment Modal and populate with data attribute
    window.openPaymentModal = function(btn) {
        try {
            var raw = $(btn).attr('data-payment');
            if (!raw) return;
            var jsonStr = $('<div>').html(raw).text();
            var data = JSON.parse(jsonStr);

            $('#paymentTxn').text(data.transaction_id || data.transactionId || 'N/A');
            $('#paymentAmount').text(data.total_amount ? '₹' + Number(data.total_amount).toLocaleString('en-IN') : (data.amount || 'N/A'));
            $('#paymentStudent').text(data.student_name || data.studentName || 'N/A');
            $('#paymentEmail').text(data.student_email || data.email || 'N/A');
            $('#paymentMethod').text(data.payment_mode || data.paymentMethod || 'N/A');
            $('#paymentPaidOn').text(data.paid_on ? new Date(data.paid_on).toLocaleString('en-GB') : (data.paymentDate || 'N/A'));

            var resp = data.payment_response_data || data.paymentResponse || data;
            try { $('#paymentGatewayResponse').text(JSON.stringify(resp, null, 2)); } catch(e) { $('#paymentGatewayResponse').text(String(resp)); }

            const modal = new bootstrap.Modal(document.getElementById('paymentDetailsModal'));
            modal.show();
        } catch (err) {
            console.error('Failed to open payment modal', err);
        }
    }
</script>

<!-- Include XLSX library for Excel export -->
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<script>
    function markCollegePending(internshipId) {
        Swal.fire({
            title: 'Mark as Pending for College?',
            text: 'This will flag the internship so the college team knows marks need to be entered.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f26e2c',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Flag It'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.internship.mark-college-pending", ["id" => ":id"]) }}'.replace(':id', internshipId),
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Flagged!',
                                text: res.message || 'Internship has been flagged for college marks.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(function() { location.reload(); });
                        } else {
                            Swal.fire({ icon: 'warning', title: 'Cannot Flag', text: res.message || 'Unable to flag this internship.' });
                        }
                    },
                    error: function(xhr) {
                        var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred. Please try again.';
                        Swal.fire({ icon: 'error', title: 'Error', text: msg });
                    }
                });
            }
        });
    }
</script>

@endpush
