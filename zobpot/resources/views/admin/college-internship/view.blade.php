@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "CollegeInternship";
</script>

<style>
    /* Reuse existing opportunity view styles */
    .opportunity-view-header {
        background: #242a62; border-radius: 12px; padding: 30px; margin-bottom: 30px;
        color: white; box-shadow: 0 4px 15px rgba(36, 42, 98, 0.3);
    }
    .opportunity-view-header h4 { margin: 0; font-size: 28px; font-weight: 700; }
    .opportunity-view-header p { margin: 8px 0 0 0; opacity: 0.9; }

    .nav-tabs-opportunity,
    .nav-tabs-internship {
        background: #fff; border-radius: 12px 12px 0 0; padding: 15px 20px 0 20px;
        border-bottom: 3px solid #242a62; box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    .nav-tabs-opportunity .nav-link,
    .nav-tabs-internship .nav-link {
        color: #666; border: none; border-bottom: 3px solid transparent;
        border-radius: 0; padding: 12px 24px; font-weight: 600; font-size: 14px;
        transition: all 0.3s ease; margin-bottom: -3px;
    }
    .nav-tabs-opportunity .nav-link:hover,
    .nav-tabs-internship .nav-link:hover { color: #242a62; background: #fff5f0; }
    .nav-tabs-opportunity .nav-link.active,
    .nav-tabs-internship .nav-link.active {
        color: #242a62; background: transparent; border-bottom-color: #242a62;
    }
    .tab-content-card {
        background: #fff; border-radius: 0 0 12px 12px; padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    .detail-row-view {
        display: flex; justify-content: space-between; padding: 12px 0;
        border-bottom: 1px dashed #dee2e6;
    }
    .detail-row-view:last-child { border-bottom: none; }
    .detail-label-view { font-weight: 600; color: #495057; font-size: 14px; min-width: 200px; }
    .detail-value-view { color: #212529; font-size: 14px; flex: 1; }
    .section-card {
        background: #f8f9fa; border-radius: 10px; padding: 20px; margin-bottom: 20px;
        border-left: 4px solid #242a62;
    }
    .section-card h6 { color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 15px; }

    /* Assign bar */
    .assign-bar {
        background: #f8f9fa; border-radius: 10px; padding: 15px 20px;
        display: flex; align-items: center; gap: 15px; margin-bottom: 20px;
        border: 1px solid #e9ecef;
    }
    .assign-bar .selected-count { font-weight: 700; color: #242a62; font-size: 14px; min-width: 140px; }

    /* Modal */
    .modal-header-assign {
        background: linear-gradient(135deg, #242a62 0%, #f26e2c 100%);
        color: white; padding: 18px 22px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        border-bottom: none;
    }
    .modal-header-assign .header-text {
        flex: 1;
        min-width: 0;
        padding-right: 8px;
    }
    .modal-header-assign h5 { margin: 0; font-size: 20px; font-weight: 700; color: #fff; }
    .modal-header-assign p { margin: 4px 0 0 0; color: rgba(255,255,255,.9); font-size: 13px; }
    .modal-close-btn {
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        border: none;
        border-radius: 50%;
        background: rgba(255,255,255,0.22);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        line-height: 1;
        padding: 0;
        cursor: pointer;
        box-shadow: none;
        opacity: 1;
    }
    .modal-close-btn i { color: #fff; font-size: 22px; line-height: 1; }
    .modal-close-btn:hover,
    .modal-close-btn:focus {
        background: #fff;
        outline: none;
        box-shadow: none;
    }
    .modal-close-btn:hover i,
    .modal-close-btn:focus i { color: #242a62; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    @php
        // Ensure $isStaff is accurate even if the controller didn't set it
        $isStaff = isset($isStaff) ? $isStaff : (auth()->guard('college_staff')->check());
    @endphp
    {{-- Header --}}
    @component('admin.layout.partials.college-page-banner', [
        'emoji' => '💼',
        'title' => $internship->internship_title,
        'subtitle' => ($internship->company ? $internship->company->name : 'N/A') . ' • ' . $internship->duration . ' • ' . $internship->mode . ' Mode',
        'illustration' => 'opportunity',
        'crumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.college.dashboard')],
            ['label' => 'Opportunities', 'url' => route('admin.college.dashboard') . '#college-internship-section'],
            ['label' => 'Details'],
        ],
    ])
        <a href="{{ route('admin.college.dashboard') }}" class="btn zp-banner-btn">
            <i class="bx bx-arrow-back"></i> Back to Dashboard
        </a>
    @endcomponent

    {{-- Tab Navigation --}}
    <ul class="nav nav-tabs nav-tabs-internship" id="collegeViewTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="ci-details-tab" data-bs-toggle="tab"
                data-bs-target="#ci-details" type="button" role="tab">
                <i class="bx bx-info-circle"></i> &nbsp;Opportunity Details
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ci-students-tab" data-bs-toggle="tab"
                data-bs-target="#ci-students" type="button" role="tab">
                <i class="bx bx-user"></i> &nbsp;Applied Students
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ci-tasks-tab" data-bs-toggle="tab"
                data-bs-target="#ci-tasks" type="button" role="tab">
                <i class="bx bx-task"></i> &nbsp;Tasks
            </button>
        </li>
    </ul>

    {{-- Tab Content --}}
    <div class="tab-content tab-content-card" id="collegeViewTabContent">

        {{-- ═══════  TAB 1 – Opportunity Details  ═══════ --}}
        <div class="tab-pane fade show active" id="ci-details" role="tabpanel">
            <h5 style="color: #242a62; font-weight: 700; margin-bottom: 20px;">
                <i class="bx bx-detail"></i> Opportunity Information
            </h5>

            <div class="section-card">
                <h6><i class="bx bx-info-circle"></i> Basic Details</h6>
                <div class="detail-row-view">
                    <span class="detail-label-view">Opportunity Title:</span>
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
                    <span class="detail-value-view">{{ $internship->location ?? 'N/A' }}</span>
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
                        @else N/A @endif
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
                @if(!empty($internship->last_registration_date))
                <div class="detail-row-view">
                    <span class="detail-label-view">Last Date of Registration:</span>
                    <span class="detail-value-view">{{ $internship->last_registration_date->format('d M Y') }}</span>
                </div>
                @endif
                @if((float) ($internship->late_registration_fee ?? 0) > 0)
                <div class="detail-row-view">
                    <span class="detail-label-view">Late Registration Fee:</span>
                    <span class="detail-value-view">₹{{ number_format($internship->late_registration_fee, 2) }}</span>
                </div>
                @endif
                <div class="detail-row-view">
                    <span class="detail-label-view">GST ({{ $internship->gst_percentage }}%):</span>
                    <span class="detail-value-view">₹{{ number_format($internship->gst_amount, 2) }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Course Fee:</span>
                    <span class="detail-value-view"><strong>₹{{ number_format($internship->course_fee, 2) }}</strong></span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Platform Service Charge:</span>
                    <span class="detail-value-view"><strong>₹{{ number_format((float) ($internship->platform_service_charge ?? 0), 2) }}</strong></span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Openings:</span>
                    <span class="detail-value-view">{{ $internship->openings }} Positions</span>
                </div>
            </div>

            @php
                $skillsArr = [];
                if(!empty($internship->skills)) {
                    $decoded = json_decode($internship->skills, true);
                    $skillsArr = is_array($decoded) ? $decoded : array_filter(array_map('trim', explode(',', $internship->skills)));
                }
                $criteriaArr = [];
                if(!empty($internship->eligibility_criteria)) {
                    $decoded2 = json_decode($internship->eligibility_criteria, true);
                    $criteriaArr = is_array($decoded2) ? $decoded2 : array_filter(array_map('trim', explode(',', $internship->eligibility_criteria)));
                }
            @endphp

            <div class="section-card">
                <h6><i class="bx bx-cog"></i> Skills & Requirements</h6>
                <div class="detail-row-view">
                    <span class="detail-label-view">Required Skills:</span>
                    <span class="detail-value-view">
                        @if(!empty($skillsArr))
                            @foreach($skillsArr as $skill)
                                <span class="badge bg-light text-dark me-1">{{ trim($skill, " \"'") }}</span>
                            @endforeach
                        @else N/A @endif
                    </span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Eligibility:</span>
                    <span class="detail-value-view">
                        @if(!empty($criteriaArr))
                            @foreach($criteriaArr as $c)
                                <span class="badge bg-light text-dark me-1">{{ trim($c, " \"'") }}</span>
                            @endforeach
                        @else N/A @endif
                    </span>
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-detail"></i> Description</h6>
                <div style="padding: 15px; background: white; border-radius: 8px; border: 1px solid #e9ecef;">
                    {!! $internship->internship_description ?? '<p class="text-muted">No description</p>' !!}
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-target-lock"></i> Objective</h6>
                <div style="padding: 15px; background: white; border-radius: 8px; border: 1px solid #e9ecef;">
                    {!! $internship->internship_objective ?? '<p class="text-muted">No objective defined</p>' !!}
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-trophy"></i> Outcome</h6>
                <div style="padding: 15px; background: white; border-radius: 8px; border: 1px solid #e9ecef;">
                    {!! $internship->internship_outcome ?? '<p class="text-muted">No outcome defined</p>' !!}
                </div>
            </div>
        </div> {{-- End details tab --}}

        {{-- ═══════  TAB 2 – Applied Students  ═══════ --}}
        <div class="tab-pane fade" id="ci-students" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                    <i class="bx bx-user"></i> Applied Students
                </h5>
            </div>

            {{-- Assign bar (visible only for college, not staff) --}}
            @if(!$isStaff)
            <div class="assign-bar" id="assignBar">
                <span class="selected-count"><span id="selectedCount">0</span> student(s) selected</span>
                <button type="button" class="btn btn-sm btn-primary" id="btnAssignStaff" disabled
                    data-bs-toggle="modal" data-bs-target="#assignStaffModal">
                    <i class="bx bx-user-plus"></i> Assign To Staff
                </button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover" id="appliedStudentsTable" style="width:100%">
                    <thead >
                        <tr>
                            @if(!$isStaff)
                            <th style="width:40px;">
                                <input type="checkbox" id="selectAllStudents" title="Select All">
                            </th>
                            @endif
                            <th>Sr. No</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>University Name</th>
                            <th>College Name</th>
                            <th>Applied On</th>
                            <th>Assigned To</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div> {{-- End students tab --}}

        {{-- ═══════  TAB 3 – Tasks (view submissions only)  ═══════ --}}
        <div class="tab-pane fade" id="ci-tasks" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                    <i class="bx bx-task"></i> Student Task Submissions
                </h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover" id="collegeTasksTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Task Title</th>
                            <th>Date & Time</th>
                            <th>Day</th>
                            <th>Due Date</th>
                            <th>Task File</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($myTasks ?? collect()) as $idx => $task)
                            @php
                                $totalStudents = (int) ($task->college_total_students ?? 0);
                                $completedStudents = (int) ($task->college_completed_students ?? 0);
                            @endphp
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>{{ $task->module_title }}</td>
                                <td>{{ $task->date_time ? \Carbon\Carbon::parse($task->date_time)->format('d M Y h:i A') : '-' }}</td>
                                <td>{{ $task->day ?: 'N/A' }}</td>
                                <td>{{ $task->last_submission_date ? \Carbon\Carbon::parse($task->last_submission_date)->format('d M Y') : '-' }}</td>
                                <td>
                                    @if($task->upload_file)
                                        <a href="{{ asset('uploads/internship_tasks/' . $task->upload_file) }}" class="badge bg-info" target="_blank" rel="noopener">
                                            <i class="bx bx-show"></i> View File
                                        </a>
                                    @else
                                        <span class="text-muted">No file</span>
                                    @endif
                                </td>
                                <td>
                                    @if($totalStudents > 0 && $completedStudents == $totalStudents)
                                        <span class="badge bg-success">Completed ({{ $completedStudents }}/{{ $totalStudents }})</span>
                                    @elseif($totalStudents > 0)
                                        <span class="badge bg-warning text-dark">Pending ({{ $completedStudents }}/{{ $totalStudents }})</span>
                                    @else
                                        <span class="badge bg-secondary">No Students</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" onclick="viewCollegeSubmissions({{ $task->id }})">
                                        <i class="bx bx-file-find"></i> View Submissions
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No tasks found for this internship.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ═══════  Assign Staff Modal  ═══════ --}}
@if(!$isStaff)
<div class="modal fade" id="assignStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; overflow:hidden; border:none;">
            <div class="modal-header-assign">
                <div class="header-text">
                    <h5><i class="bx bx-user-plus"></i> Assign Staff</h5>
                </div>
                <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body" style="padding:30px;">
                <div class="mb-3">
                    <label class="form-label" style="font-weight:600;">Select Staff Member</label>
                    <select class="form-select" id="staffSelect">
                        <option value="">-- Select Staff --</option>
                        @foreach($staffList as $staff)
                            <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="text-muted" style="font-size:13px;">
                    Selected students will be assigned to the chosen staff member.
                </p>
            </div>
            <div class="modal-footer" style="border-top:1px solid #e9ecef; padding:15px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAssignStaff">
                    <i class="bx bx-check"></i> Assign
                </button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ═══════  View Submissions Modal  ═══════ --}}
<div class="modal fade" id="viewSubmissionsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; overflow:hidden; border:none;">
            <div class="modal-header-assign">
                <div class="header-text">
                    <h5 class="mb-0"><i class="bx bx-file-find"></i> Task Submissions</h5>
                    <p id="taskTitleSubmission">Task</p>
                </div>
                <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body" style="padding:30px; background:#f8f9fa;">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div style="background:white;border-radius:10px;padding:20px;border-left:4px solid #28a745;">
                            <p class="mb-0 text-muted" style="font-size:12px;font-weight:600;">COMPLETED</p>
                            <h4 class="mb-0" style="color:#28a745;font-weight:700;" id="completedCount">0</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background:white;border-radius:10px;padding:20px;border-left:4px solid #ffc107;">
                            <p class="mb-0 text-muted" style="font-size:12px;font-weight:600;">PENDING</p>
                            <h4 class="mb-0" style="color:#ffc107;font-weight:700;" id="pendingCount">0</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background:white;border-radius:10px;padding:20px;border-left:4px solid #17a2b8;">
                            <p class="mb-0 text-muted" style="font-size:12px;font-weight:600;">TOTAL STUDENTS</p>
                            <h4 class="mb-0" style="color:#17a2b8;font-weight:700;" id="totalCount">0</h4>
                        </div>
                    </div>
                </div>
                <div style="background:white;border-radius:10px;padding:20px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 style="color:#242a62;font-weight:700;margin:0;">Student Submission Status</h6>
                        <span id="submissionSummary" class="badge bg-info">0/0 Submitted</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Task Title</th>
                                    <th>Submit Status</th>
                                    <th class="text-center">View File</th>
                                    <th class="text-center">Note</th>
                                    <th class="text-center">Feedback</th>
                                </tr>
                            </thead>
                            <tbody id="submissionTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- ═══════  Student Note Modal  ═══════ --}}
<div class="modal fade" id="studentNoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; overflow:hidden; border:none;">
            <div class="modal-header-assign">
                <div class="header-text">
                    <h5 class="mb-0"><i class="bx bx-note"></i> Student Submission Note</h5>
                    <p id="studentNoteName">Student</p>
                </div>
                <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body" style="padding:30px; background:#f8f9fa;">
                <div class="mb-3" style="background:white;border-radius:10px;padding:16px;">
                    <div class="mb-2"><strong>Task Title:</strong> <span id="noteTaskTitle">-</span></div>
                    <div class="mb-2"><strong>Submitted On:</strong> <span id="noteSubmitDate">-</span></div>
                    <div class="mb-2"><strong>Status:</strong> <span id="noteStatus">-</span></div>
                    <div><strong>Submission File:</strong> <span id="noteFile">-</span></div>
                </div>
                <div style="background:white;border-radius:10px;padding:16px;" class="mb-3">
                    <h6 style="color:#242a62;font-weight:700;">Student's Note</h6>
                    <div id="noteContent" class="text-muted">-</div>
                </div>
                <div style="background:white;border-radius:10px;padding:16px;">
                    <h6 style="color:#242a62;font-weight:700;">Project Link</h6>
                    <div id="noteProjectLink">-</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- ═══════  Feedback Modal (view only)  ═══════ --}}
<div class="modal fade" id="taskFeedbackModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; overflow:hidden; border:none;">
            <div class="modal-header-assign">
                <div class="header-text">
                    <h5 class="mb-0"><i class="bx bx-message-dots"></i> Task Feedback</h5>
                    <p id="feedbackStudentName">Student</p>
                </div>
                <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body" style="padding:30px; background:#f8f9fa;">
                <div class="mb-3" style="background:white;border-radius:10px;padding:16px;">
                    <div class="mb-2"><strong>Task Title:</strong> <span id="feedbackTaskTitle">-</span></div>
                    <div><strong>Status:</strong> <span id="feedbackStatus">-</span></div>
                </div>
                <div style="background:white;border-radius:10px;padding:16px;">
                    <h6 style="color:#242a62;font-weight:700;">Feedback</h6>
                    <div id="feedbackViewContent" class="text-muted">No feedback available.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
$(function(){
    var internshipId = {{ $internship->id }};
    var isStaff = {{ $isStaff ? 'true' : 'false' }};

    if (window.location.hash === '#ci-students') {
        var studentsTab = document.getElementById('ci-students-tab');
        if (studentsTab) {
            (new bootstrap.Tab(studentsTab)).show();
        }
    }

    // Applied Students DataTable
    var studentsTable = $('#appliedStudentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.college-internship.applied-students') }}",
            type: 'POST',
            data: { _token: '{{ csrf_token() }}', internship_id: internshipId }
        },
        columns: [
            @if(!$isStaff)
            { data: 'checkbox', orderable: false, searchable: false, className: 'text-center' },
            @endif
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'student_name' },
            { data: 'email' },
            { data: 'phone' },
            { data: 'university_name' },
            { data: 'college_name' },
            { data: 'applied_date' },
            { data: 'assigned_to', orderable: false },
            { data: 'action', orderable: false, searchable: false }
        ],
        order: [[isStaff ? 1 : 2, 'asc']],
        language: { emptyTable: "No students found for this opportunity." }
    });

    // Lazy-load on tab switch
    $('button[data-bs-target="#ci-students"]').on('shown.bs.tab', function(){
        studentsTable.ajax.reload();
    });

    @if(!$isStaff)
    // ── Select All ──
    $('#selectAllStudents').on('change', function(){
        var checked = $(this).prop('checked');
        $('.student-checkbox').prop('checked', checked);
        updateSelectedCount();
    });

    $(document).on('change', '.student-checkbox', function(){
        updateSelectedCount();
        // Uncheck "select all" if any unchecked
        if (!$(this).prop('checked')) {
            $('#selectAllStudents').prop('checked', false);
        }
        if ($('.student-checkbox:checked').length === $('.student-checkbox').length && $('.student-checkbox').length > 0) {
            $('#selectAllStudents').prop('checked', true);
        }
    });

    function updateSelectedCount(){
        var count = $('.student-checkbox:checked').length;
        $('#selectedCount').text(count);
        $('#btnAssignStaff').prop('disabled', count === 0);
    }

    // ── Assign Staff ──
    $('#confirmAssignStaff').on('click', function(){
        var staffId = $('#staffSelect').val();
        if (!staffId) {
            alert('Please select a staff member.');
            return;
        }

        var applicationIds = [];
        $('.student-checkbox:checked').each(function(){
            applicationIds.push($(this).val());
        });
        if (applicationIds.length === 0) {
            alert('Please select at least one student.');
            return;
        }

        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin"></i> Assigning...');

        $.ajax({
            url: "{{ route('admin.college-internship.assign-staff') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                application_ids: applicationIds,
                staff_id: staffId
            },
            success: function(res){
                if (res.success) {
                    $('#assignStaffModal').modal('hide');
                    studentsTable.ajax.reload();
                    updateSelectedCount();
                    $('#selectAllStudents').prop('checked', false);
                    alert(res.message);
                } else {
                    alert(res.message || 'Something went wrong.');
                }
            },
            error: function(xhr){
                var msg = xhr.responseJSON ? xhr.responseJSON.message : 'Server error.';
                alert(msg);
            },
            complete: function(){
                $btn.prop('disabled', false).html('<i class="bx bx-check"></i> Assign');
            }
        });
    });
    @endif
});

    var currentMasterTaskId = null;
    var submitFileBase = '{{ asset("uploads/internship_tasks_submit") }}';

    function reopenCollegeSubmissions() {
        if (!currentMasterTaskId) return;
        var el = document.getElementById('viewSubmissionsModal');
        var modal = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
        modal.show();
    }

    window.viewCollegeSubmissions = function(taskId) {
        currentMasterTaskId = taskId;
        document.getElementById('submissionTableBody').innerHTML = '<tr><td colspan="8" class="text-center py-4"><i class="bx bx-loader-alt bx-spin"></i> Loading...</td></tr>';
        document.getElementById('completedCount').textContent = '-';
        document.getElementById('pendingCount').textContent = '-';
        document.getElementById('totalCount').textContent = '-';
        document.getElementById('submissionSummary').textContent = '';
        document.getElementById('taskTitleSubmission').textContent = 'Task';
        (new bootstrap.Modal(document.getElementById('viewSubmissionsModal'))).show();

        $.ajax({
            url: '{{ url("admin/college-internship/task") }}/' + taskId + '/submissions',
            method: 'GET',
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

                var rows = '';
                res.students.forEach(function(s, idx) {
                    var isComplete = s.status === 1;
                    var statusBadge = isComplete
                        ? '<span class="badge bg-success">Complete</span>'
                        : '<span class="badge bg-warning text-dark">Pending</span>';
                    var fileBtn = (isComplete && s.student_submit_file)
                        ? '<a class="btn btn-sm btn-info" href="' + submitFileBase + '/' + encodeURIComponent(s.student_submit_file) + '" target="_blank"><i class="bx bx-file"></i> View File</a>'
                        : '<span class="text-muted">-</span>';
                    var escapedName = (s.name || '').replace(/'/g, "\\'");
                    var noteBtn = isComplete
                        ? '<button type="button" class="btn btn-sm" style="background:#f26e2c;color:#fff;" onclick="viewCollegeStudentNote(' + currentMasterTaskId + ',' + s.student_id + ',\'' + escapedName + '\')"><i class="bx bx-note"></i> Note</button>'
                        : '<span class="text-muted">-</span>';
                    var feedbackBtn = '<button type="button" class="btn btn-sm btn-info" onclick="viewCollegeTaskFeedback(' + currentMasterTaskId + ',' + s.student_id + ',\'' + escapedName + '\')"><i class="bx bx-message-dots"></i> Feedback</button>';

                    rows += '<tr>'
                        + '<td>' + (idx + 1) + '</td>'
                        + '<td><strong>' + (s.name || 'N/A') + '</strong></td>'
                        + '<td>' + (s.email || 'N/A') + '</td>'
                        + '<td>' + (s.task_title || '') + '</td>'
                        + '<td>' + statusBadge + '</td>'
                        + '<td class="text-center">' + fileBtn + '</td>'
                        + '<td class="text-center">' + noteBtn + '</td>'
                        + '<td class="text-center">' + feedbackBtn + '</td>'
                        + '</tr>';
                });
                document.getElementById('submissionTableBody').innerHTML = rows;
            },
            error: function() {
                document.getElementById('submissionTableBody').innerHTML = '<tr><td colspan="8" class="text-center py-4 text-danger">Failed to load submissions.</td></tr>';
            }
        });
    };

    window.viewCollegeStudentNote = function(taskId, studentId, studentName) {
        document.getElementById('studentNoteName').textContent = 'Student: ' + studentName;
        document.getElementById('noteTaskTitle').textContent = 'Loading...';
        document.getElementById('noteSubmitDate').textContent = '-';
        document.getElementById('noteStatus').innerHTML = '-';
        document.getElementById('noteFile').innerHTML = '-';
        document.getElementById('noteContent').innerHTML = '<p class="text-muted">Loading...</p>';
        document.getElementById('noteProjectLink').innerHTML = '-';

        var noteEl = document.getElementById('studentNoteModal');
        var noteModal = new bootstrap.Modal(noteEl);
        try {
            var subsInst = bootstrap.Modal.getInstance(document.getElementById('viewSubmissionsModal'));
            if (subsInst) subsInst.hide();
        } catch (e) {}
        noteModal.show();
        noteEl.addEventListener('hidden.bs.modal', function() { reopenCollegeSubmissions(); }, { once: true });

        $.ajax({
            url: '{{ url("admin/college-internship/task") }}/' + taskId + '/student/' + studentId + '/note',
            method: 'GET',
            success: function(res) {
                document.getElementById('noteTaskTitle').textContent = res.task_title || '-';
                document.getElementById('noteSubmitDate').textContent = res.submit_on || '-';
                document.getElementById('noteStatus').innerHTML = res.status === 1
                    ? '<span class="badge bg-success">Submitted</span>'
                    : '<span class="badge bg-warning text-dark">Pending</span>';
                if (res.student_submit_file) {
                    document.getElementById('noteFile').innerHTML = '<a href="' + submitFileBase + '/' + encodeURIComponent(res.student_submit_file) + '" target="_blank">Download file</a>';
                }
                document.getElementById('noteContent').innerHTML = res.student_submit_description
                    ? res.student_submit_description
                    : '<span class="text-muted">No note provided.</span>';
                document.getElementById('noteProjectLink').innerHTML = res.student_submit_project_link
                    ? '<a href="' + res.student_submit_project_link + '" target="_blank">' + res.student_submit_project_link + '</a>'
                    : '<span class="text-muted">No project link.</span>';
            },
            error: function() {
                document.getElementById('noteContent').innerHTML = '<p class="text-danger">Failed to load note.</p>';
            }
        });
    };

    window.viewCollegeTaskFeedback = function(taskId, studentId, studentName) {
        document.getElementById('feedbackStudentName').textContent = studentName || 'Student';
        document.getElementById('feedbackTaskTitle').textContent = 'Loading...';
        document.getElementById('feedbackStatus').innerHTML = '-';
        document.getElementById('feedbackViewContent').textContent = 'Loading...';

        var fbEl = document.getElementById('taskFeedbackModal');
        var fbModal = new bootstrap.Modal(fbEl);
        try {
            var subsInst = bootstrap.Modal.getInstance(document.getElementById('viewSubmissionsModal'));
            if (subsInst) subsInst.hide();
        } catch (e) {}
        fbModal.show();
        fbEl.addEventListener('hidden.bs.modal', function() { reopenCollegeSubmissions(); }, { once: true });

        $.ajax({
            url: '{{ url("admin/college-internship/task") }}/' + taskId + '/student/' + studentId + '/feedback',
            method: 'GET',
            success: function(res) {
                document.getElementById('feedbackTaskTitle').textContent = res.task_title || '-';
                document.getElementById('feedbackStatus').innerHTML = res.status === 1
                    ? '<span class="badge bg-success">Submitted</span>'
                    : '<span class="badge bg-warning text-dark">Pending</span>';
                document.getElementById('feedbackViewContent').textContent = res.task_feedback || 'No feedback available.';
            },
            error: function() {
                document.getElementById('feedbackViewContent').textContent = 'Failed to load feedback.';
            }
        });
    };
</script>
@endpush
