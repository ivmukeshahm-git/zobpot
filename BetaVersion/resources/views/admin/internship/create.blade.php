@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "Internship";
</script>

<link rel="stylesheet" href="{{ asset('admin-assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .skill-input-container, .eligibility_criteria_input_container {
        border: 1px solid #d9dee3;
        border-radius: 6px;
        padding: 8px;
        min-height: 50px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        background: white;
    }

    .skill-tag, .eligibility-tag {
        background: #242a62;
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .skill-tag .remove, .eligibility-tag .remove {
        cursor: pointer;
        font-weight: bold;
    }

    .ql-container {
        min-height: 150px;
    }

    /* Select2 Styling */
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        min-height: 45px;
        max-height: 120px;
        overflow-y: auto;
        background: #ffffff;
        transition: all 0.3s ease;
    }

    .select2-container--default .select2-selection--multiple:focus,
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 41px;
        padding-left: 15px;
        color: #2d3748;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background: #242a62!important;
        border: none;
        color: white!important;
        padding: 6px 30px;
        border-radius: 25px;
        font-weight: 500;
        font-size: 13px;
        margin: 5px 3px;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: white!important;
        margin-right: 6px;
        font-weight: bold;
        border-right: none!important;
        width: 15px;
            left: 7px;
    top: 5px;
        
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: none;
        background: none;
    }

    /* Batch Days Container */
    #batchDaysTableContainer {
        background: linear-gradient(135deg, #f5f7fa 0%, #fafbfc 100%);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        border: 1px solid #e3e8ef;
    }

    /* Batch Days Table */
    .batch-days-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .batch-days-table thead {
        background: #242a62!important;
    }

    .batch-days-table th {
        color: white;
        padding: 15px 20px;
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }

    .batch-days-table th:first-child {
        border-radius: 10px 0 0 0;
    }

    .batch-days-table th:last-child {
        border-radius: 0 10px 0 0;
    }

    .batch-days-table tbody tr {
        transition: all 0.3s ease;
    }

    .batch-days-table td {
        padding: 15px 20px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    .batch-days-table tbody tr:last-child td {
        border-bottom: none;
    }

    .batch-days-table tbody tr:hover {
        background: linear-gradient(90deg, #f8f9ff 0%, #ffffff 100%);
        transform: scale(1.01);
    }

    .batch-day-row .day-name {
        font-weight: 700;
        color: #667eea;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .batch-day-row .day-name::before {
        content: "📅";
        font-size: 16px;
    }

    .batch-days-table input[type="date"],
    .batch-days-table input[type="time"],
    .batch-days-table input[type="datetime-local"] {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 13px;
        transition: all 0.3s ease;
        background: #f8f9fa;
        width: 100%;
    }

    .batch-days-table input[type="date"]:focus,
    .batch-days-table input[type="time"]:focus,
    .batch-days-table input[type="datetime-local"]:focus {
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .time-input-group {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .time-input-group input {
        flex: 1;
    }

    .time-separator {
        color: #667eea;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-remove-day {
        background: red;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(245, 87, 108, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-remove-day:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 87, 108, 0.4);
    }

    .btn-remove-day i {
        font-size: 14px;
    }

    /* Select2 Dropdown Custom Styling */
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background: #242a62!important;
        color: white!important;
    }

    /* Empty State */
    .batch-days-empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #8898aa;
    }

    .batch-days-empty-state i {
        font-size: 48px;
        color: #d0d7de;
        margin-bottom: 10px;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bx bx-plus-circle"></i> Create New Internship
            </h4>
            <p class="text-muted mb-0">Fill in the details step by step to create a new internship program</p>
        </div>
        <a href="{{ route('admin.internship.management') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Back to List
        </a>
    </div>

    <div class="col-12 mb-6">
        <div class="bs-stepper wizard-numbered">
            <div class="bs-stepper-header">
                <div class="step" data-target="#basic-info">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle"><i class="bx bx-info-circle"></i></span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Basic Information</span>
                            <span class="bs-stepper-subtitle">Internship Details</span>
                        </span>
                    </button>
                </div>
                <div class="line">
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" data-target="#duration-schedule">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle"><i class="bx bx-time-five"></i></span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Duration & Schedule</span>
                            <span class="bs-stepper-subtitle">Time Details</span>
                        </span>
                    </button>
                </div>
                <div class="line">
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" data-target="#skills-eligibility">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle"><i class="bx bx-star"></i></span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Skills & Eligibility</span>
                            <span class="bs-stepper-subtitle">Requirements</span>
                        </span>
                    </button>
                </div>
                <div class="line">
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" data-target="#descriptions">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle"><i class="bx bx-file-blank"></i></span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Program Details</span>
                            <span class="bs-stepper-subtitle">Descriptions</span>
                        </span>
                    </button>
                </div>
                <div class="line">
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" data-target="#preview">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle"><i class="bx bx-show"></i></span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Preview</span>
                            <span class="bs-stepper-subtitle">Review & Submit</span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content">
                <form id="internshipForm" action="{{ route('admin.internship.store') }}" method="POST">
                    @csrf
                    
                    <!-- Step 1: Basic Information -->
                    <div id="basic-info" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Basic Information</h6>
                            <small>Enter the basic details of the internship program.</small>
                        </div>
                        <div class="row g-6">
                            <div class="col-lg-6">
                                <label class="form-label">Internship Title <span class="text-danger">*</span></label>
                                <input type="text" name="internship_title" class="form-control" 
                                       placeholder="e.g. Web Development Intern" required />
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <option value="20">Arts</option>
                                    <option value="21">Commerce</option>
                                    <option value="22">Science</option>
                                    <option value="23">Engineering</option>
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                <select name="company_id" class="form-select" required>
                                    <option value="">Select Company</option>
                                    <option value="345">Adesh Roadtech India Pvt Ltd</option>
                                    <option value="355">Ambica Engineering</option>
                                    <option value="357">Ambika Industrias</option>
                                    <option value="354">Anil Engineering Works</option>
                                    <option value="325">Apple Container</option>
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label">Company Website (Optional)</label>
                                <input type="url" name="company_website" class="form-control" 
                                       placeholder="https://www.example.com" />
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label">Mode <span class="text-danger">*</span></label>
                                <select name="internship_mode" class="form-select" required>
                                    <option value="">Select Mode</option>
                                    <option value="Online">Online</option>
                                    <option value="Offline">Offline</option>
                                    <option value="Hybrid">Hybrid</option>
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" name="location" class="form-control" 
                                       placeholder="City / Office Location" required />
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label">Stipend (₹)</label>
                                <input type="number" name="stipend" class="form-control" 
                                       placeholder="Enter Stipend Amount" min="0" />
                            </div>

                            <div class="col-lg-6">
                                <label class="form-label">Openings <span class="text-danger">*</span></label>
                                <input type="number" name="openings" class="form-control" 
                                       placeholder="Number of positions" required min="1" />
                            </div>

                            <div class="col-12 d-flex justify-content-between mt-4">
                                <button class="btn btn-label-secondary btn-prev" disabled>
                                    <i class="bx bx-left-arrow-alt bx-sm ms-sm-n2 me-sm-2"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button class="btn btn-primary btn-next">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span>
                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Duration & Schedule -->
                    <div id="duration-schedule" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Duration & Schedule</h6>
                            <small>Set the duration and schedule for the internship.</small>
                        </div>
                        <div class="row g-6">
                            <div class="col-lg-4">
                                <label class="form-label">Duration <span class="text-danger">*</span></label>
                                <input type="text" name="duration" class="form-control" 
                                       placeholder="e.g. 3 Months, 6 Weeks" required />
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">Total Weeks <span class="text-danger">*</span></label>
                                <input type="number" name="weeks" class="form-control" 
                                       placeholder="Enter total weeks" required />
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">Total Hours <span class="text-danger">*</span></label>
                                <input type="number" name="hours" class="form-control" 
                                       placeholder="Enter total hours" required />
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" class="form-control" required />
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" class="form-control" required />
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">Application Deadline <span class="text-danger">*</span></label>
                                <input type="date" name="application_deadline" class="form-control" required />
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label" style="font-weight: 600; color: #2d3748; display: flex; align-items: center; gap: 8px;">
                                    <i class="bx bx-calendar-week" style="color: #667eea; font-size: 20px;"></i>
                                    Select Batch Days <span class="text-danger">*</span>
                                </label>
                                <select id="batchDaysSelect" class="form-select" multiple>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                                <small class="text-muted" style="display: flex; align-items: center; gap: 5px; margin-top: 8px;">
                                    <i class="bx bx-info-circle"></i>
                                    Select days to add individual start and end dates for each day
                                </small>
                            </div>

                            <div class="col-lg-12" id="batchDaysTableContainer" style="display: none;">
                                <div class="mt-3">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                                        <i class="bx bx-list-ul" style="font-size: 24px; color: #667eea;"></i>
                                        <h6 style="margin: 0; color: #2d3748; font-weight: 700;">Batch Day Schedules</h6>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="batch-days-table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20%;">
                                                        <i class="bx bx-calendar me-1"></i>Day
                                                    </th>
                                                    <th style="width: 35%;">
                                                        <i class="bx bx-calendar-check me-1"></i>Start Date & Time
                                                    </th>
                                                    <th style="width: 35%;">
                                                        <i class="bx bx-calendar-x me-1"></i>End Date & Time
                                                    </th>
                                                    <th style="width: 10%; text-align: center;">
                                                        <i class="bx bx-trash"></i>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="batchDaysTableBody">
                                                <!-- Dynamic rows will be added here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-between mt-4">
                                <button class="btn btn-primary btn-prev">
                                    <i class="bx bx-left-arrow-alt bx-sm ms-sm-n2 me-sm-2"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button class="btn btn-primary btn-next">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span>
                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Skills & Eligibility -->
                    <div id="skills-eligibility" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Skills & Eligibility</h6>
                            <small>Define required skills and eligibility criteria.</small>
                        </div>
                        <div class="row g-6">
                            <div class="col-lg-12">
                                <label class="form-label">Required Skills</label>
                                <div id="skill-input-container" class="skill-input-container">
                                    <input type="text" id="skills" placeholder="Type a skill and press Enter" 
                                           style="border: none; outline: none; flex: 1; min-width: 200px;" />
                                </div>
                                <input type="hidden" name="required_skills" id="required_skills">
                                <small class="text-muted">Press Enter to add each skill</small>
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label">Eligibility Criteria</label>
                                <div id="eligibility_criteria_input_container" class="eligibility_criteria_input_container">
                                    <input type="text" id="eligibility_criteria" placeholder="Type criteria and press Enter" 
                                           style="border: none; outline: none; flex: 1; min-width: 200px;" />
                                </div>
                                <input type="hidden" name="required_eligibility_criteria" id="required_eligibility_criteria">
                                <small class="text-muted">Press Enter to add each criterion</small>
                            </div>

                            <div class="col-12 d-flex justify-content-between mt-4">
                                <button class="btn btn-primary btn-prev">
                                    <i class="bx bx-left-arrow-alt bx-sm ms-sm-n2 me-sm-2"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button class="btn btn-primary btn-next">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span>
                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Program Details -->
                    <div id="descriptions" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Program Details</h6>
                            <small>Add descriptions and objectives for the internship.</small>
                        </div>
                        <div class="row g-6">
                            <div class="col-lg-12">
                                <label class="form-label">Internship Description <span class="text-danger">*</span></label>
                                <div id="full-editor-internship-description" style="height:150px;"></div>
                                <input type="hidden" name="internship_description" id="internship_description">
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label">Module Brief Description <span class="text-danger">*</span></label>
                                <div id="editor-module-desc" style="height:150px;"></div>
                                <input type="hidden" name="module_description" id="module_description">
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label">Internship Objective <span class="text-danger">*</span></label>
                                <div id="full-editor-key-responsibilities" style="height:150px;"></div>
                                <input type="hidden" name="internship_objective" id="internship_objective">
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label">Internship Outcome <span class="text-danger">*</span></label>
                                <div id="editor-industry-outcome" style="height:150px;"></div>
                                <input type="hidden" name="internship_outcome" id="internship_outcome">
                            </div>

                            <div class="col-12 d-flex justify-content-between mt-4">
                                <button class="btn btn-primary btn-prev">
                                    <i class="bx bx-left-arrow-alt bx-sm ms-sm-n2 me-sm-2"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button class="btn btn-primary btn-next">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span>
                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Preview -->
                    <div id="preview" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Preview Internship Details</h6>
                            <small>Review all information before submitting.</small>
                        </div>
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="bx bx-info-circle me-2"></i>Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted small">Internship Title</label>
                                                <p class="fw-semibold mb-0" id="preview_title">-</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted small">Category</label>
                                                <p class="fw-semibold mb-0" id="preview_category">-</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted small">Company</label>
                                                <p class="fw-semibold mb-0" id="preview_company">-</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted small">Mode</label>
                                                <p class="fw-semibold mb-0" id="preview_mode">-</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted small">Location</label>
                                                <p class="fw-semibold mb-0" id="preview_location">-</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted small">Openings</label>
                                                <p class="fw-semibold mb-0" id="preview_openings">-</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted small">Stipend</label>
                                                <p class="fw-semibold mb-0" id="preview_stipend">-</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="bx bx-time-five me-2"></i>Duration & Schedule</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="text-muted small">Duration</label>
                                                <p class="fw-semibold mb-0" id="preview_duration">-</p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="text-muted small">Total Weeks</label>
                                                <p class="fw-semibold mb-0" id="preview_weeks">-</p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="text-muted small">Total Hours</label>
                                                <p class="fw-semibold mb-0" id="preview_hours">-</p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="text-muted small">Start Date</label>
                                                <p class="fw-semibold mb-0" id="preview_start_date">-</p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="text-muted small">End Date</label>
                                                <p class="fw-semibold mb-0" id="preview_end_date">-</p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="text-muted small">Application Deadline</label>
                                                <p class="fw-semibold mb-0" id="preview_deadline">-</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted small">Batch Days</label>
                                                <p class="fw-semibold mb-0" id="preview_batch_days">-</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted small">Time Slots</label>
                                                <p class="fw-semibold mb-0" id="preview_time_slots">-</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="bx bx-star me-2"></i>Skills & Eligibility</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted small">Required Skills</label>
                                                <div id="preview_skills" class="d-flex flex-wrap gap-2">-</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted small">Eligibility Criteria</label>
                                                <div id="preview_criteria" class="d-flex flex-wrap gap-2">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="bx bx-file-blank me-2"></i>Program Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="text-muted small">Internship Description</label>
                                            <div id="preview_description" class="border rounded p-3 bg-light">-</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted small">Module Description</label>
                                            <div id="preview_module" class="border rounded p-3 bg-light">-</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted small">Internship Objective</label>
                                            <div id="preview_objective" class="border rounded p-3 bg-light">-</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted small">Internship Outcome</label>
                                            <div id="preview_outcome" class="border rounded p-3 bg-light">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-between mt-4">
                                <button class="btn btn-primary btn-prev">
                                    <i class="bx bx-left-arrow-alt bx-sm ms-sm-n2 me-sm-2"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="bx bx-save"></i> Create Internship
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<!-- BS Stepper JS -->
<script src="{{ asset('admin-assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>

<!-- Include Quill Editor -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 for all select elements
    $('select[name="category_id"]').select2({
        placeholder: 'Select Category',
        allowClear: true
    });

    $('select[name="company_id"]').select2({
        placeholder: 'Select Company',
        allowClear: true
    });

    $('select[name="internship_mode"]').select2({
        placeholder: 'Select Mode',
        allowClear: true
    });

    // Initialize Select2 for Batch Days
    $('#batchDaysSelect').select2({
        placeholder: 'Select batch days',
        allowClear: true
    });

    // Batch Days Management
    let selectedDays = [];

    $('#batchDaysSelect').on('change', function() {
        const currentSelection = $(this).val() || [];
        
        // Find newly added days
        const newDays = currentSelection.filter(day => !selectedDays.includes(day));
        
        // Find removed days
        const removedDays = selectedDays.filter(day => !currentSelection.includes(day));
        
        // Add rows for new days
        newDays.forEach(day => {
            addBatchDayRow(day);
        });
        
        // Remove rows for removed days
        removedDays.forEach(day => {
            $(`#batch-row-${day}`).remove();
        });
        
        // Update selected days
        selectedDays = currentSelection;
        
        // Show/hide table
        if (selectedDays.length > 0) {
            $('#batchDaysTableContainer').show();
        } else {
            $('#batchDaysTableContainer').hide();
        }
    });

    function addBatchDayRow(day) {
        const rowId = `batch-row-${day}`;
        const row = `
            <tr class="batch-day-row" id="${rowId}">
                <td class="day-name">${day}</td>
                <td>
                    <input type="datetime-local" name="batch_days[${day}][start_datetime]" class="form-control" required />
                </td>
                <td>
                    <input type="datetime-local" name="batch_days[${day}][end_datetime]" class="form-control" required />
                </td>
                <td style="text-align: center;">
                    <button type="button" class="btn-remove-day" onclick="removeBatchDay('${day}')">
                        <i class="bx bx-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#batchDaysTableBody').append(row);
    }

    // Make removeBatchDay function global
    window.removeBatchDay = function(day) {
        // Remove from Select2
        const currentValues = $('#batchDaysSelect').val() || [];
        const newValues = currentValues.filter(d => d !== day);
        $('#batchDaysSelect').val(newValues).trigger('change');
    };
    // Initialize BS Stepper
    const wizardNumbered = document.querySelector('.wizard-numbered');
    if (typeof wizardNumbered !== undefined && wizardNumbered !== null) {
        const stepper = new Stepper(wizardNumbered, {
            linear: false
        });

        // Handle Next button
        const btnNext = wizardNumbered.querySelectorAll('.btn-next');
        btnNext.forEach(btn => {
            btn.addEventListener('click', () => {
                stepper.next();
            });
        });

        // Handle Previous button
        const btnPrev = wizardNumbered.querySelectorAll('.btn-prev');
        btnPrev.forEach(btn => {
            btn.addEventListener('click', () => {
                stepper.previous();
            });
        });
    }

    // Initialize Quill Editors
    const internshipDescEditor = new Quill('#full-editor-internship-description', {
        theme: 'snow',
        placeholder: 'Describe the internship program...'
    });

    const moduleDescEditor = new Quill('#editor-module-desc', {
        theme: 'snow',
        placeholder: 'Brief description of modules...'
    });

    const objectiveEditor = new Quill('#full-editor-key-responsibilities', {
        theme: 'snow',
        placeholder: 'Learning objectives...'
    });

    const outcomeEditor = new Quill('#editor-industry-outcome', {
        theme: 'snow',
        placeholder: 'Expected outcomes...'
    });

    // Skills Management
    let skillsArray = [];
    $('#skills').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            const skill = $(this).val().trim();
            if (skill && !skillsArray.includes(skill)) {
                skillsArray.push(skill);
                addSkillTag(skill);
                $(this).val('');
                $('#required_skills').val(skillsArray.join(','));
            }
        }
    });

    function addSkillTag(skill) {
        const tag = $('<span class="skill-tag">' + skill + ' <span class="remove">×</span></span>');
        tag.find('.remove').on('click', function() {
            skillsArray = skillsArray.filter(s => s !== skill);
            $('#required_skills').val(skillsArray.join(','));
            tag.remove();
        });
        tag.insertBefore('#skills');
    }

    // Eligibility Criteria Management
    let criteriaArray = [];
    $('#eligibility_criteria').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            const criteria = $(this).val().trim();
            if (criteria && !criteriaArray.includes(criteria)) {
                criteriaArray.push(criteria);
                addCriteriaTag(criteria);
                $(this).val('');
                $('#required_eligibility_criteria').val(criteriaArray.join(','));
            }
        }
    });

    function addCriteriaTag(criteria) {
        const tag = $('<span class="eligibility-tag">' + criteria + ' <span class="remove">×</span></span>');
        tag.find('.remove').on('click', function() {
            criteriaArray = criteriaArray.filter(c => c !== criteria);
            $('#required_eligibility_criteria').val(criteriaArray.join(','));
            tag.remove();
        });
        tag.insertBefore('#eligibility_criteria');
    }

    // Update Preview when navigating to preview step
    wizardNumbered.addEventListener('show.bs-stepper', function (event) {
        if (event.detail.to === 4) { // Preview is step 5 (index 4)
            updatePreview();
        }
    });

    function updatePreview() {
        // Basic Information
        $('#preview_title').text($('input[name="internship_title"]').val() || '-');
        $('#preview_category').text($('select[name="category_id"] option:selected').text() || '-');
        $('#preview_company').text($('select[name="company_id"] option:selected').text() || '-');
        $('#preview_mode').text($('select[name="internship_mode"]').val() || '-');
        $('#preview_location').text($('input[name="location"]').val() || '-');
        $('#preview_openings').text($('input[name="openings"]').val() || '-');
        const stipend = $('input[name="stipend"]').val();
        $('#preview_stipend').text(stipend ? '₹' + stipend : 'Not specified');

        // Duration & Schedule
        $('#preview_duration').text($('input[name="duration"]').val() || '-');
        $('#preview_weeks').text($('input[name="weeks"]').val() + ' weeks' || '-');
        $('#preview_hours').text($('input[name="hours"]').val() + ' hours' || '-');
        $('#preview_start_date').text($('input[name="start_date"]').val() || '-');
        $('#preview_end_date').text($('input[name="end_date"]').val() || '-');
        $('#preview_deadline').text($('input[name="application_deadline"]').val() || '-');
        
        const batchDaysRows = $('#batchDaysTableBody tr');
        if (batchDaysRows.length > 0) {
            let batchDaysHtml = '<div class="d-flex flex-column gap-2">';
            batchDaysRows.each(function() {
                const day = $(this).find('.day-name').text();
                const startDate = $(this).find('input[type="date"]').eq(0).val();
                const endDate = $(this).find('input[type="date"]').eq(1).val();
                batchDaysHtml += `<div class="badge bg-primary" style="padding: 8px 12px;">
                    <strong>${day}:</strong> ${startDate || 'Not set'} to ${endDate || 'Not set'}
                </div>`;
            });
            batchDaysHtml += '</div>';
            $('#preview_batch_days').html(batchDaysHtml);
        } else {
            $('#preview_batch_days').text('No days selected');
        }
        
        const timeSlot1 = $('input[name="time_slots"]').val();
        const timeSlot2 = $('input[name="time_slots_2"]').val();
        const timeSlots = [timeSlot1, timeSlot2].filter(Boolean).join(', ');
        $('#preview_time_slots').text(timeSlots || 'Not specified');

        // Skills & Eligibility
        if (skillsArray.length > 0) {
            const skillBadges = skillsArray.map(skill => 
                `<span class="badge bg-primary">${skill}</span>`
            ).join(' ');
            $('#preview_skills').html(skillBadges);
        } else {
            $('#preview_skills').text('No skills added');
        }

        if (criteriaArray.length > 0) {
            const criteriaBadges = criteriaArray.map(criteria => 
                `<span class="badge bg-info">${criteria}</span>`
            ).join(' ');
            $('#preview_criteria').html(criteriaBadges);
        } else {
            $('#preview_criteria').text('No criteria added');
        }

        // Program Details
        $('#preview_description').html(internshipDescEditor.root.innerHTML || '-');
        $('#preview_module').html(moduleDescEditor.root.innerHTML || '-');
        $('#preview_objective').html(objectiveEditor.root.innerHTML || '-');
        $('#preview_outcome').html(outcomeEditor.root.innerHTML || '-');
    }

    // Form Submission
    $('#internshipForm').on('submit', function(e) {
        e.preventDefault();
        
        // Update hidden fields with Quill content
        $('#internship_description').val(internshipDescEditor.root.innerHTML);
        $('#module_description').val(moduleDescEditor.root.innerHTML);
        $('#internship_objective').val(objectiveEditor.root.innerHTML);
        $('#internship_outcome').val(outcomeEditor.root.innerHTML);
        
        // Validate required fields
        if (!$('#internship_description').val() || 
            !$('#module_description').val() || 
            !$('#internship_objective').val() || 
            !$('#internship_outcome').val()) {
            toastr.error('Please fill in all description fields', 'Error');
            return;
        }
        
        // Submit form
        this.submit();
    });
});
</script>
@endpush
