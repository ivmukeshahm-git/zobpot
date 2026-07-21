<style>
    #ApplyShortlistedList,
    #ApplySelectedList,
    #ApplyRejectedList {
        display: none;
    }

    .modal-lg-schedule-interview {
        max-width: 800px;
    }

    .Interview-round-box {
        border: 1px solid #d9d9d9;
        padding: 10px;
        border-radius: 6px;
        background: #eee;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .Interview-round-box:hover {
        background: #f5f5f5;
        border-color: #ec6b29;
    }

    /* New Styles for Redesign */
    .status-filter-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .filter-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        color: white;
        min-width: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
    }

    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .filter-btn.active {
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transform: translateY(-1px);
    }

    .apply-history-table {
        width: 100%;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid #eaeaea;
    }

    .apply-history-table thead {
        background: #242b60;
    }

    .apply-history-table thead th {
        color: white;
        font-weight: 600;
        padding: 18px 15px;
        border: none;
        font-size: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .apply-history-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .apply-history-table tbody tr:hover {
        background-color: #f9f9ff;
        transform: scale(1.001);
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }

    .apply-history-table tbody td {
        padding: 16px 15px;
        vertical-align: middle;
        border: none;
        color: #333;
        font-size: 14px;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-right: 8px;
        margin-bottom: 5px;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .view-profile-btn {
        background: #6c757d;
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .view-profile-btn:hover {
        background: #5a6268;
        color: white;
        transform: translateY(-2px);
        text-decoration: none;
    }

    .view-resume-btn {
        background: #17a2b8;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .view-resume-btn:hover {
        background: #138496;
        color: white;
        transform: translateY(-2px);
        text-decoration: none;
    }

    .empty-state {
        padding: 50px 20px;
        text-align: center;
        color: #666;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        color: #ddd;
    }

    .pagination-container {
        margin-top: 30px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .status-filter-buttons {
            justify-content: center;
        }
        
        .filter-btn {
            min-width: 100px;
            padding: 8px 15px;
            font-size: 13px;
        }
        
        .apply-history-table {
            font-size: 13px;
        }
        
        .apply-history-table thead th,
        .apply-history-table tbody td {
            padding: 12px 8px;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 5px;
        }
        
        .action-btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Custom colors for status badges */
    .status-pending { background: #ffc107; color: #000; }
    .status-selected { background: #28a745; color: white; }
    .status-rejected { background: #dc3545; color: white; }
    .status-shortlisted { background: #007bff; color: white; }
    .status-interview { background: #fd7e14; color: white; }
    .status-unknown { background: #6c757d; color: white; }
</style>

<div class="row">
    <div class="d-flex justify-content-end pb-2">
        <a class="btn btn-preview-icon btn-apply btn-apply-big" style="padding: 14px 30px 14px 30px;" href="javascript:void(0);" onclick="BackJobList()"><i class="fa fa-long-arrow-left"></i>&nbsp;
            Back
        </a>
    </div>
    <div class="col-lg-4">
        <h3 class="mt-0 mb-20" style="color: #242b60; font-weight: 700;">
            <i class="fa fa-history me-2"></i>Apply History
        </h3>
    </div>
    <div class="col-lg-8">
        <div class="status-filter-buttons">
            <button id="btnAll" type="button" class="filter-btn active" 
                    style="background: #242b60;">
                <i class="fa fa-list"></i> All
            </button>

            <button id="btnShortlisted" type="button" class="filter-btn" 
                    style="background: #ec6b29;">
                <i class="fa fa-bookmark"></i> Shortlisted
            </button>

            <button id="btnSelected" type="button" class="filter-btn" 
                    style="background: #28a745;">
                <i class="fa fa-check-square-o"></i> Selected
            </button>

            <button id="btnRejected" type="button" class="filter-btn" 
                    style="background: #dc3545;">
                <i class="fa fa-times"></i> Rejected
            </button>
        </div>
    </div>
</div>

<div id="AllApplyList">
    <div class="row display-list">
        <div class="table-responsive">
            <table class="table apply-history-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">Sr No.</th>
                        <th style="width: 15%;">Candidate</th>
                        <th style="width: 20%;">Contact Info</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">Documents</th>
                        <th style="width: 30%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $shortlistedApplicants = $jobApplicants->filter(function ($applicant) {
                            return $applicant->status != 0 || $applicant->status != 3;
                        });
                    @endphp

                    @forelse ($jobApplicants as $index => $applicant)
                        <tr class="clickable-row" style="cursor: pointer;">
                            <td style="font-weight: 600; color: #242b60;">
                                {{ $jobApplicants->firstItem() + $index }}
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #333;">{{ $applicant->name }}</div>
                            </td>
                            <td>
                                <div style="margin-bottom: 5px;">
                                    <i class="fa fa-envelope me-2" style="color: #ec6b29;"></i>
                                    <small>{{ $applicant->email }}</small>
                                </div>
                                <div>
                                    <i class="fa fa-phone me-2" style="color: #242b60;"></i>
                                    <small>{{ $applicant->contact_no }}</small>
                                </div>
                            </td>
                            <td>
                                @php
                                    $statusBadge = [
                                        0 => ['label' => 'Pending', 'class' => 'status-pending'],
                                        1 => ['label' => 'Selected', 'class' => 'status-selected'],
                                        2 => ['label' => 'Rejected', 'class' => 'status-rejected'],
                                        3 => ['label' => 'Shortlisted', 'class' => 'status-shortlisted'],
                                        4 => ['label' => 'Interview', 'class' => 'status-interview'],
                                    ];

                                    $status = $statusBadge[$applicant->status] ?? [
                                        'label' => 'Unknown',
                                        'class' => 'status-unknown',
                                    ];
                                @endphp

                                <div class="status-badge {{ $status['class'] }}">
                                    {{ $status['label'] }}
                                </div>
                                <br>
                                <a href="{{ route('candidate-profile-detail', ['id' => $applicant->user_id]) }}"
                                   class="view-profile-btn">
                                    <i class="fa fa-eye"></i> View
                                </a>
                            </td>
                            <td>
                                @if ($applicant->file_nm)
                                    <a href="{{ asset('storage/resumes/' . $applicant->file_nm) }}" target="_blank"
                                       class="view-resume-btn">
                                        <i class="fa fa-file-pdf-o"></i> View Resume
                                    </a>
                                @else
                                    <span class="text-muted" style="font-size: 13px;">No Resume</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if ($applicant->status == 0)
                                        <button class="action-btn" 
                                                style="background: #ec6b29; color: white;"
                                                onclick="AddToShortlist({{ $applicant->id }})">
                                            <i class="fa fa-bookmark"></i> Shortlist
                                        </button>
                                    @endif

                                    @if ($applicant->status == 3)
                                        <button class="action-btn" 
                                                style="background: #242b60; color: white;"
                                                onclick="FetchUserJobRound({{ $applicant->job_id }}, {{ $applicant->user_id }},{{ $applicant->id }},'Interview')">
                                            <i class="fa fa-calendar"></i> Schedule Interview
                                        </button>
                                    @endif

                                    <button class="action-btn" 
                                            style="background: #dc3545; color: white;"
                                            {{ $applicant->status == 1 || $applicant->status == 2 ? 'disabled' : '' }}
                                            onclick="ApplicationReject({{ $applicant->id }})">
                                        <i class="fa fa-times"></i> Reject
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fa fa-users"></i>
                                <h5 style="color: #666; margin-top: 10px;">No Applications Found</h5>
                                <p class="text-muted">There are no applications for this job yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        @if($jobApplicants->count() > 0)
        <div class="pagination-container">
            <div class="pagination justify-content-center">
                {{ $jobApplicants->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @endif
    </div>
</div>

<div id="ApplyShortlistedList">
    <div class="row display-list">
        <div class="table-responsive">
            <table class="table apply-history-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 15%;">Candidate</th>
                        <th style="width: 20%;">Contact Info</th>
                        <th style="width: 15%;">Interview Date</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">Documents</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $shortlistedApplicants = $jobApplicants->filter(function ($applicant) {
                            return $applicant->status == 3 || $applicant->status == 4;
                        });
                    @endphp

                    @forelse ($shortlistedApplicants as $index => $applicant)
                        <tr class="clickable-row" style="cursor: pointer;">
                            <td style="font-weight: 600; color: #242b60;">
                                {{ $jobApplicants->firstItem() + $index }}
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #333;">{{ $applicant->name }}</div>
                            </td>
                            <td>
                                <div style="margin-bottom: 5px;">
                                    <i class="fa fa-envelope me-2" style="color: #ec6b29;"></i>
                                    <small>{{ $applicant->email }}</small>
                                </div>
                                <div>
                                    <i class="fa fa-phone me-2" style="color: #242b60;"></i>
                                    <small>{{ $applicant->contact_no }}</small>
                                </div>
                            </td>
                            <td>
                                @if($applicant->interview_datetime)
                                    <div style="font-weight: 600; color: #242b60;">
                                        <i class="fa fa-calendar me-2"></i>
                                        {{ \Carbon\Carbon::parse($applicant->interview_datetime)->format('d M Y') }}
                                    </div>
                                    <small style="color: #666;">
                                        {{ \Carbon\Carbon::parse($applicant->interview_datetime)->format('h:i A') }}
                                    </small>
                                @else
                                    <span class="text-muted">Not Scheduled</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusBadge = [
                                        0 => ['label' => 'Pending', 'class' => 'status-pending'],
                                        1 => ['label' => 'Selected', 'class' => 'status-selected'],
                                        2 => ['label' => 'Rejected', 'class' => 'status-rejected'],
                                        3 => ['label' => 'Shortlisted', 'class' => 'status-shortlisted'],
                                        4 => ['label' => 'Interview', 'class' => 'status-interview'],
                                    ];

                                    $status = $statusBadge[$applicant->status] ?? [
                                        'label' => 'Unknown',
                                        'class' => 'status-unknown',
                                    ];
                                @endphp

                                <div class="status-badge {{ $status['class'] }}">
                                    {{ $status['label'] }}
                                </div>
                                <br>
                                <a href="{{ route('candidate-profile-detail', ['id' => $applicant->user_id]) }}"
                                   class="view-profile-btn">
                                    <i class="fa fa-eye"></i> View Profile
                                </a>
                            </td>
                            <td>
                                @if ($applicant->file_nm)
                                    <a href="{{ asset('storage/resumes/' . $applicant->file_nm) }}" target="_blank"
                                       class="view-resume-btn">
                                        <i class="fa fa-file-pdf-o"></i> View Resume
                                    </a>
                                @else
                                    <span class="text-muted" style="font-size: 13px;">No Resume</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if ($applicant->status == 3 || $applicant->status == 4)
                                        <button class="action-btn" 
                                                style="background: #242b60; color: white; margin-bottom: 5px;"
                                                onclick="FetchUserJobRound({{ $applicant->job_id }}, {{ $applicant->user_id }},{{ $applicant->id }},'Interview')">
                                            <i class="fa fa-calendar"></i> Schedule
                                        </button>
                                    @endif

                                    @if ($applicant->status == 4)
                                        <button class="action-btn" 
                                                style="background: #17a2b8; color: white;"
                                                onclick="FetchUserJobRound({{ $applicant->job_id }}, {{ $applicant->user_id }},{{ $applicant->id }},'Status')">
                                            <i class="fa fa-refresh"></i> Update Status
                                        </button>
                                    @else
                                        <button class="action-btn" 
                                                style="background: #dc3545; color: white;"
                                                onclick="ApplicationReject({{ $applicant->id }})">
                                            <i class="fa fa-times"></i> Reject
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <i class="fa fa-bookmark" style="color: #ec6b29;"></i>
                                <h5 style="color: #666; margin-top: 10px;">No Shortlisted Candidates</h5>
                                <p class="text-muted">No candidates have been shortlisted yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        @if($shortlistedApplicants->count() > 0)
        <div class="pagination-container">
            <div class="pagination justify-content-center">
                {{ $jobApplicants->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @endif
    </div>
</div>

<div id="ApplySelectedList">
    <div class="row display-list">
        <div class="table-responsive">
            <table class="table apply-history-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 20%;">Candidate</th>
                        <th style="width: 25%;">Contact Info</th>
                        <th style="width: 20%;">Status</th>
                        <th style="width: 30%;">Documents</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $selectedApplicants = $jobApplicants->filter(function ($applicant) {
                            return $applicant->status == 1;
                        });
                    @endphp

                    @forelse ($selectedApplicants as $index => $applicant)
                        <tr class="clickable-row" style="cursor: pointer;">
                            <td style="font-weight: 600; color: #242b60;">
                                {{ $jobApplicants->firstItem() + $index }}
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #333; font-size: 15px;">
                                    {{ $applicant->name }}
                                </div>
                            </td>
                            <td>
                                <div style="margin-bottom: 8px;">
                                    <i class="fa fa-envelope me-2" style="color: #ec6b29;"></i>
                                    <span style="font-size: 14px;">{{ $applicant->email }}</span>
                                </div>
                                <div>
                                    <i class="fa fa-phone me-2" style="color: #242b60;"></i>
                                    <span style="font-size: 14px;">{{ $applicant->contact_no }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="status-badge status-selected" style="font-size: 14px; padding: 10px 20px;">
                                    <i class="fa fa-check me-1"></i> SELECTED
                                </div>
                                <br>
                                <a href="{{ route('candidate-profile-detail', ['id' => $applicant->user_id]) }}"
                                   class="view-profile-btn" style="margin-top: 8px;">
                                    <i class="fa fa-eye"></i> View Profile
                                </a>
                            </td>
                            <td>
                                @if ($applicant->file_nm)
                                    <a href="{{ asset('storage/resumes/' . $applicant->file_nm) }}" target="_blank"
                                       class="view-resume-btn" style="padding: 10px 20px;">
                                        <i class="fa fa-file-pdf-o"></i> View Resume
                                    </a>
                                @else
                                    <span class="text-muted">No Resume Available</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <i class="fa fa-check-circle" style="color: #28a745;"></i>
                                <h5 style="color: #666; margin-top: 10px;">No Selected Candidates</h5>
                                <p class="text-muted">No candidates have been selected yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        @if($selectedApplicants->count() > 0)
        <div class="pagination-container">
            <div class="pagination justify-content-center">
                {{ $jobApplicants->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @endif
    </div>
</div>

<div id="ApplyRejectedList">
    <div class="row display-list">
        <div class="table-responsive">
            <table class="table apply-history-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 20%;">Candidate</th>
                        <th style="width: 25%;">Contact Info</th>
                        <th style="width: 20%;">Status</th>
                        <th style="width: 30%;">Documents</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $rejectedApplicants = $jobApplicants->filter(function ($applicant) {
                            return $applicant->status == 2;
                        });
                    @endphp

                    @forelse ($rejectedApplicants as $index => $applicant)
                        <tr class="clickable-row" style="cursor: pointer;">
                            <td style="font-weight: 600; color: #242b60;">
                                {{ $jobApplicants->firstItem() + $index }}
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #333; font-size: 15px;">
                                    {{ $applicant->name }}
                                </div>
                            </td>
                            <td>
                                <div style="margin-bottom: 8px;">
                                    <i class="fa fa-envelope me-2" style="color: #ec6b29;"></i>
                                    <span style="font-size: 14px;">{{ $applicant->email }}</span>
                                </div>
                                <div>
                                    <i class="fa fa-phone me-2" style="color: #242b60;"></i>
                                    <span style="font-size: 14px;">{{ $applicant->contact_no }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="status-badge status-rejected">
                                    <i class="fa fa-times me-1"></i> REJECTED
                                </div>
                                <br>
                                <a href="{{ route('candidate-profile-detail', ['id' => $applicant->user_id]) }}"
                                   class="view-profile-btn" style="margin-top: 8px;">
                                    <i class="fa fa-eye"></i> View Profile
                                </a>
                            </td>
                            <td>
                                @if ($applicant->file_nm)
                                    <a href="{{ asset('storage/resumes/' . $applicant->file_nm) }}" target="_blank"
                                       class="view-resume-btn" style="padding: 10px 20px;">
                                        <i class="fa fa-file-pdf-o"></i> View Resume
                                    </a>
                                @else
                                    <span class="text-muted">No Resume Available</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <i class="fa fa-times-circle" style="color: #dc3545;"></i>
                                <h5 style="color: #666; margin-top: 10px;">No Rejected Candidates</h5>
                                <p class="text-muted">No candidates have been rejected yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        @if($rejectedApplicants->count() > 0)
        <div class="pagination-container">
            <div class="pagination justify-content-center">
                {{ $jobApplicants->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @endif
    </div>
</div>
    

    <div class="modal fade" id="ScheduleInterviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg-schedule-interview">
            <div class="modal-content apply-job-form">
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body pl-30 pr-30 pt-50">
                    <div class="text-center">
                        <h3 class="mt-10 mb-50 text-brand-1 text-capitalize">Schedule Interview</h3>
                    </div>
                    <form id="schedule-interview-form">
                        <div class="row mt-20">
                            <label>Interviewe Round</label>
                            <div class="row" id="UserJobRoundHtml"></div>
                        </div>
                        <div class="row mb-30 mt-20">
                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="interview_datetime">Interview Date & Time <span class="color-red">*</span>
                                </label>
                                <input type="datetime-local" class="form-control" id="interview_datetime"
                                    name="interview_datetime">
                            </div>

                            <div class="col-lg-6 col-md-12 col-12 mb-3">
                                <label for="hr_contact_no">HR Contact Number <span class="color-red">*</span></label>
                                <input type="text" class="form-control" id="hr_contact_no" name="hr_contact_no"
                                    placeholder="Enter HR Contact Number" value="{{ $JobData->hr_contact_no }}">
                            </div>

                            <div class="col-lg-6 col-md-12 col-12 mb-3">
                                <label for="hr_email">HR Email <span class="color-red">*</span></label>
                                <input type="text" class="form-control" id="hr_email" name="hr_email"
                                    placeholder="Enter HR Email" value="{{ $JobData->hr_email }}">
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="">Interviewer’s Address <span class="color-red">*</span></label>
                                <input type="text" class="form-control" id="interviewer_address"
                                    name="interviewer_address" placeholder="Enter Interviewer’s Address"
                                    value="{{ $JobData->interviewer_address }}">
                            </div>

                            <div class="col-lg-12 col-md-12 col-12" style="text-align: center;">
                                {{-- <input type="hidden" name="job_id" id="job_id" value=""> --}}
                                <input type="hidden" id="interview_job_id" name="interview_job_id" value="">
                                <input type="hidden" id="interview_user_id" name="interview_user_id" value="">
                                <input type="hidden" id="interview_job_apply_id" name="interview_job_apply_id">
                                <input type="hidden" id="_method" name="_method" value="POST">
                                {{-- <button class="btn btn-default hover-up w-100" type="submit">Submit</button> --}}
                                <button class="btn btn-default hover-up w-100" type="button" id="scheduleInterviewBtn">
                                    Submit
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ApplicationStatusUpdateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg-schedule-interview">
            <div class="modal-content apply-job-form">
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body pl-30 pr-30 pt-50">
                    <div class="text-center">
                        <h3 class="mt-10 mb-50 text-brand-1 text-capitalize">Update Application Status</h3>
                    </div>
                    <form id="application-status-form" onsubmit="return false;">
                        <div class="row mb-20 mt-20">
                            <label>Interview Round</label>
                            <div class="row" id="StatusCompleteUserRound">

                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="interview_datetime">Status <span class="color-red">*</span></label>
                                <select name="application_status" id="application_status" class="form-control">

                                </select>
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="hr_name">Remarks</label>
                                <textarea name="remarks" id="remarks" class="form-control"></textarea>
                            </div>

                            <div class="col-lg-12 col-md-12 col-12" style="text-align: center;">
                                <input type="hidden" id="status_job_id" name="status_job_id" value="">
                                <input type="hidden" id="status_user_id" name="status_user_id" value="">
                                <input type="hidden" id="job_apply_id" name="job_apply_id">
                                <input type="hidden" id="_method" name="_method" value="POST">
                                <button class="btn btn-default hover-up w-100" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function BackJobList() {
            $('#tab-job-apply-history').removeClass('show active'); 
            $('#tab-my-jobs').addClass('show active');

            $('html,body').animate({ scrollTop: $("#tab-my-jobs").offset().top - 50 }, 300);
        }

        // ✅ GLOBAL VARIABLE TO TRACK VALIDATOR
        let validatorscheduleinterview = null;

        function SetScheduleInterview(application_id) {

        // Reset form fields
            $("#schedule-interview-form")[0].reset();

            // 🔥 RESET VALIDATION STATE
            if (validatorscheduleinterview) {
                validatorscheduleinterview.resetForm();
                $("#schedule-interview-form")
                    .find('.is-invalid')
                    .removeClass('is-invalid');
            }

            // Clear rounds
            $("#UserJobRoundHtml").html('');

            // Set application id
            $("#interview_job_apply_id").val(application_id);

            // Show modal
            $("#ScheduleInterviewModal").modal('show');
        }


        window.FetchUserJobRound = function(job_id, user_id, application_id, typ) {
            if (typ == "Interview") {
                SetScheduleInterview(application_id)
                $("#interview_user_id").val(user_id);
                $("#interview_job_id").val(job_id);
            } else {
                UpdateApplicationStatus(application_id)
                $("#status_user_id").val(user_id);
                $("#status_job_id").val(job_id);
            }

            $.ajax({
                url: "{{ route('fetch.user.job.round') }}",
                method: "POST",
                data: {
                    job_id: job_id,
                    user_id: user_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    let JobInterviewhtml = '';
                    let UpdateStatushtml = '';
                    let optionHtml = `
                    <option value="Selected">Complete All Round & Selected For Job</option>
                `;

                    if (response.length === 0) {
                        html = '<div class="col-lg-12"><p>No rounds found.</p></div>';
                    } else {
                        response.forEach(row => {
                            JobInterviewhtml += `
                            <div class="col-lg-6 mb-20">
                                <div class="Interview-round-box d-flex align-items-center position-relative">
                                    ${row.status == 1 ? `
                                        <i class="fa fa-check-circle text-success position-absolute"
                                        style="top: 1px; right: 19px; font-size: 32px; z-index: 999999;"></i>
                                    ` : `
                                        <input type="checkbox" class="round-checkbox me-2 position-absolute"
                                            name="round_ids[]" value="${row.round_id}"
                                            id="round_${row.round_id}" style="right: 10px; top: 10px;">
                                    `}
                                    <label for="round_${row.round_id}" class="ms-4 w-100">
                                        <h6 class="mb-1">${row.round_name}</h6>
                                        <p class="mb-0">${row.round_desc}</p>
                                    </label>
                                </div>
                            </div>`;
                            
                            UpdateStatushtml += `
                            <div class="col-lg-6 mb-20">
                                <div class="Interview-round-box d-flex align-items-center position-relative">
                                    ${row.status == 1 ? `
                                        <i class="fa fa-check-circle text-success position-absolute"
                                        style="top: 1px; right: 19px; font-size: 32px; z-index: 999999;"></i>
                                    ` : `
                                        <i class="fa fa-clock-o text-success position-absolute"
                                        style="top: 8px;right: 19px;font-size: 29px;z-index: 999999;color: #f9af00 !important;"></i>
                                    `}
                                    <label for="round_${row.round_id}" class="ms-4 w-100">
                                        <h6 class="mb-1">${row.round_name}</h6>
                                        <p class="mb-0">${row.round_desc}</p>
                                    </label>
                                </div>
                            </div>`;

                            optionHtml +=
                                // `<option value="${row.id}">Complete ${row.round_name}</option>`;
                                `<option value="${row.round_id}">Complete ${row.round_name}</option>`;
                        });
                    }
                    optionHtml += `<option value="Rejected">Reject For Job</option>`;

                    if (typ == "Interview") {
                        $('#UserJobRoundHtml').html(JobInterviewhtml);

                        // 🔥 Reset validation after dynamic HTML
                        if (validatorscheduleinterview) {
                            validatorscheduleinterview.resetForm();
                        }
                    } else {
                        $('#StatusCompleteUserRound').html(UpdateStatushtml);
                        $('#application_status').html(optionHtml);
                    }

                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    $('#UserJobRoundHtml').html('<p class="text-danger">Failed to load job rounds.</p>');
                }
            });
        }

        function UpdateApplicationStatus(id) {
            $("#ApplicationStatusUpdateModal").modal('show');
            $("#job_apply_id").val(id);
        }
        // update status logic
        let validatorApplicationStatus = null;

        $(document).ready(function(){

            validatorApplicationStatus = $("#application-status-form").validate({
                rules:{
                    status_job_id:{ required:true },
                    status_user_id:{ required:true },
                    job_apply_id:{ required:true }
                },
                messages:{
                    status_job_id:{ required:"Job ID missing" },
                    status_user_id:{ required:"User ID missing" },
                    job_apply_id:{ required:"Application ID missing" }
                },
                errorElement:"div",
                errorPlacement:function(error, element){
                    error.addClass("invalid-feedback");
                    error.insertAfter(element);
                }
            });

            // new line update by shakshi
            $(document).off('submit.applyHistoryStatus', '#application-status-form').on('submit.applyHistoryStatus', '#application-status-form', function(e){

                e.preventDefault();

                if(!$("#application-status-form").valid()){
                    return;
                }

                let formData = $(this).serialize();

                LoaderShow();

                $.ajax({
                    type:"POST",
                    url:"{{ route('apply-job-application-status-action') }}",
                    data: formData,
                    success:function(res){
                        LoaderHide();

                        if(res.status === 1){
                            SuccessMsg(res.message);
                            $("#ApplicationStatusUpdateModal").modal('hide');
                            // setTimeout(() => {location.reload();}, 1500);

                                setTimeout(() => {
                                    const jobId = $("#status_job_id").val();
                                    if (typeof loadJobApplyDetails === 'function' && jobId) {
                                        loadJobApplyDetails(jobId);
                                    }
                                }, 300);

                        } else {
                            ErrorMsg(res.message);
                        }
                    },
                    error:function(xhr){
                        LoaderHide();
                        ErrorMsg("Ajax fail in status update");
                    }
                });

            });

        });



        $(document).ready(function() {
            // Initialize schedule interview validator ONCE
            validatorscheduleinterview = $("#schedule-interview-form").validate({
                rules: {
                    interview_datetime: {
                        required: true
                    },
                    hr_contact_no: {
                        required: true
                    },
                    hr_email: {
                        required: true
                    },
                    interviewer_address: {
                        required: true
                    }
                },
                messages: {
                    interview_datetime: {
                        required: "Please Select Interview Date"
                    },
                    hr_contact_no: {
                        required: "Please Enter HR Contact No."
                    },
                    hr_email: {
                        required: "Please Enter HR Email"
                    },
                    interviewer_address: {
                        required: "Please Enter Interviewer Address"
                    }
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass("invalid-feedback");
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid");
                }
            });

            // ✅ SUBMIT HANDLER
            // $(document).on('click', '#scheduleInterviewBtn', function () {

            //    let submitBtn = $(this);
            //     submitBtn.prop('disabled', true);

            //     if (!$("#schedule-interview-form").valid()) {
            //         submitBtn.prop('disabled', false);
            //         return;
            //     }

            //     let checkedRounds = $('input[name="round_ids[]"]:checked').length;
            //     if (checkedRounds === 0) {
            //         ErrorMsg('Please select at least one Interview Round');
            //         submitBtn.prop('disabled', false);
            //         return;
            //     }

            //     let formData = $("#schedule-interview-form").serialize();


            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //     });

            //     let url = "{{ route('apply-job-application-schedule-interview-action') }}";

            //     LoaderShow();

            //     $.ajax({
            //         type: "POST",
            //         url: url,
            //         data: formData,
            //         success: function(response) {
            //             LoaderHide();
            //             $("#ScheduleInterviewModal").modal('hide');
            //             if (response.status === 1) {
            //                 SuccessMsg(response.message);
            //                 // Optional: reload after delay
            //                 setTimeout(function() {
            //                     location.reload();
            //                 }, 1500);
            //             } else {
            //                 ErrorMsg(response.message);
            //             }
            //         },
            //         error: function(xhr) {
            //             LoaderHide();
            //             console.log(xhr.responseText);
            //             ErrorMsg('Something went wrong. Please try again.');
            //         }
            //     });
            // });
            //update by shakshi
            $(document).off('click.applyHistoryInterview', '#scheduleInterviewBtn').on('click.applyHistoryInterview', '#scheduleInterviewBtn', function () {

                let submitBtn = $(this);
                submitBtn.prop('disabled', true);

                let form = $("#schedule-interview-form");

                if (!form.valid()) {
                    submitBtn.prop('disabled', false);
                    return;
                }

                let checkedRounds = $('input[name="round_ids[]"]:checked').length;
                if (checkedRounds === 0) {
                    ErrorMsg('Please select at least one Interview Round');
                    submitBtn.prop('disabled', false);
                    return;
                }

                let formData = form.serialize(); // ✅ FIXED

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                LoaderShow();

                $.ajax({
                    type: "POST",
                    url: "{{ route('apply-job-application-schedule-interview-action') }}",
                    data: formData,
                    success: function(response) {
                        LoaderHide();
                        submitBtn.prop('disabled', false);

                        if (response.status === 1) {
                            $("#ScheduleInterviewModal").modal('hide');
                            SuccessMsg(response.message);
                            setTimeout(() => {
                                const jobId = $("#interview_job_id").val();
                                if (typeof loadJobApplyDetails === 'function' && jobId) {
                                    loadJobApplyDetails(jobId);
                                }
                            }, 300);

                        } else {
                            ErrorMsg(response.message);
                        }
                    },
                    error: function(xhr) {
                        LoaderHide();
                        submitBtn.prop('disabled', false);
                        console.log(xhr.responseText);
                        ErrorMsg('Something went wrong. Please try again.');
                    }
                });
            });


            // Interactive checkbox functionality
            $(document).on('click', '.Interview-round-box', function(e) {
                if (!$(e.target).is('input[type="checkbox"]') && !$(e.target).is('label')) {
                    const checkbox = $(this).find('input[type="checkbox"]');
                    if (checkbox.length && !checkbox.is(':disabled')) {
                        checkbox.prop('checked', !checkbox.prop('checked'));
                        $(this).toggleClass('selected', checkbox.prop('checked'));
                    }
                }
            });

            // Tab switching functionality
            // const tabs = {
            //     'btnAll': '#AllApplyList',
            //     'btnShortlisted': '#ApplyShortlistedList',
            //     'btnSelected': '#ApplySelectedList',
            //     'btnRejected': '#ApplyRejectedList'
            // };

            // // Initialize - show All, hide others
            // $('#AllApplyList').show();
            // $('#ApplyShortlistedList, #ApplySelectedList, #ApplyRejectedList').hide();
            // $('#btnAll').addClass('active');

            // // Tab switching with animation
            // Object.keys(tabs).forEach(btnId => {
            //     $(`#${btnId}`).on('click', function() {
            //         // Hide all content
            //         Object.values(tabs).forEach(content => {
            //             $(content).hide();
            //         });
                    
            //         // Remove active class from all buttons
            //         Object.keys(tabs).forEach(id => {
            //             $(`#${id}`).removeClass('active');
            //         });
                    
            //         // Show selected content
            //         $(tabs[btnId]).fadeIn(300);
            //         $(this).addClass('active');
            //     });
            // });
            function showApplyTab(type) {

                $('#AllApplyList, #ApplyShortlistedList, #ApplySelectedList, #ApplyRejectedList').hide();
                $('.filter-btn').removeClass('active');

                if (type === 'All') {
                    $('#AllApplyList').show();
                    $('#btnAll').addClass('active');
                }

                if (type === 'Shortlisted') {
                    $('#ApplyShortlistedList').show();
                    $('#btnShortlisted').addClass('active');
                }

                if (type === 'Selected') {
                    $('#ApplySelectedList').show();
                    $('#btnSelected').addClass('active');
                }

                if (type === 'Rejected') {
                    $('#ApplyRejectedList').show();
                    $('#btnRejected').addClass('active');
                }
            }

            // ✅ DELEGATED EVENTS (AJAX SAFE)
            $(document).on('click', '#btnAll', function () {
                showApplyTab('All');
            });

            $(document).on('click', '#btnShortlisted', function () {
                showApplyTab('Shortlisted');
            });

            $(document).on('click', '#btnSelected', function () {
                showApplyTab('Selected');
            });

            $(document).on('click', '#btnRejected', function () {
                showApplyTab('Rejected');
            });

            // default
            showApplyTab('All');

        });
    </script>

    <script>
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault(); // ❌ reload bandh

        let url = $(this).attr('href'); // ?page=2&job_id=...

        LoaderShow();

        $.get(url, function (res) {
            LoaderHide();

            console.log(res); // 👈 aa j tu jois che

            if (res.status === 1) {

                // 🔥 IMPORTANT LINE
                let newHtml = $('<div>').html(res.htmlContent);

                // ONLY AllApplyList replace
               $('#AllApplyList').replaceWith(
    newHtml.find('#AllApplyList')
);

$('#ApplyShortlistedList').replaceWith(
    newHtml.find('#ApplyShortlistedList')
);

$('#ApplySelectedList').replaceWith(
    newHtml.find('#ApplySelectedList')
);

$('#ApplyRejectedList').replaceWith(
    newHtml.find('#ApplyRejectedList')
);

            } else {
                ErrorMsg(res.message || 'Something went wrong');
            }
        }).fail(function () {
            LoaderHide();
            ErrorMsg('Pagination request failed');
        });
    });
    </script>
