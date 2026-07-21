@extends('website.layout.layout')
@section('website-content')
    <style>
        /* My Internship Details Page Styles */
        .internship-details-header {
            background: #242a62;
            border-radius: 12px;
            padding: 40px;
            margin-bottom: 30px;
            font-size: 32px;
            font-weight: 700;
        }

        .internship-details-header p {
            margin: 0;
            font-size: 16px;
        }

        .stats-box .icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 15px;
        }

        .stats-box h3 {
            font-size: 34px;
            font-weight: 800;
            margin: 0 0 6px 0;
            line-height: 1;
        }

        .stats-box p {
            margin: 0;
            color: #6c757d;
            font-size: 14px;
            font-weight: 600;
        }

        /* Per-stat styling */
        .stats-box {
            display: flex;
            flex-direction: column;
            /* align-items: center; */
            justify-content: center;
            padding: 18px 14px;
            border-radius: 8px;
            background: #fff;
            border: 1px solid #e9ecef;
            box-shadow: 0 8px 20px rgba(15,23,42,0.06);
            min-height: 110px;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            text-align: left;
        }

        .stats-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 30px rgba(15,23,42,0.08);
        }

        .stats-box.stats-total h3 { color: #17a2b8; }
        .stats-box.stats-completed h3 { color: #28a745; }
        .stats-box.stats-pending h3 { color: #ffc107; }
        .stats-box.stats-days h3 { color: #dc3545; }

        .stats-box .label {
            margin-top: 8px;
            color: #6c757d;
            font-size: 14px;
            font-weight: 700;
            text-transform: none;
        }

        /* Tab Navigation */
        .nav-tabs-internship {
            background: #fff;
            border-radius: 12px 12px 0 0;
            padding: 15px 20px 0 20px;
            border-bottom: 3px solid #242a62;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
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
            border-bottom-color: #f26e2c;
        }

        .tab-content-card {
            background: #fff;
            border-radius: 0 0 12px 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        /* Section Card */
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
            margin-bottom: 15px;
            font-size: 16px;
        }

        /* Detail Row */
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px dashed #dee2e6;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #495057;
            font-size: 14px;
            min-width: 200px;
        }

        .detail-value {
            color: #212529;
            font-size: 14px;
            flex: 1;
        }

        /* Task Card */
        .task-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #17a2b8;
            transition: all 0.3s ease;
        }

        .task-card:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Certificate Section */
        .certificate-box {
            background: #fff;
            border: 2px dashed #242a62;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
        }

        .certificate-icon {
            width: 100px;
            height: 100px;
            background: #242a62;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 48px;
            color: white;
        }


        .modal-title {
            color: #fff !important;
        }

        
    .ck-editor__editable {
        min-height: 300px;
    }

    /* Star rating radio styles for review modal */
    .stars{
        display:flex;
        flex-direction:row-reverse;
        justify-content:center;
        font-size:40px;
    }

    .stars input{
        display:none;
    }

    .stars label{
        color:#ccc;
        cursor:pointer;
        transition:0.3s;
    }

    .stars label:hover,
    .stars label:hover ~ label{
        color:#ffc107;
    }

    .stars input:checked ~ label{
        color:#ffc107;
    }

    </style>

    <main class="main mb-5">
        <section class="section-box">
            <div class="container">
                <!-- Header -->
                <div class="internship-details-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 style="color: #fff; margin: 0;"><i class="bx bx-briefcase"></i>
                                {{ $internship->internship_title ?? 'Internship Details' }}</h2>
                            <p style="color: #fff; margin: 5px 0 0 0;"><i class="bx bx-buildings"></i>
                                {{ $internship->company->name ?? ($internship->company->company_name ?? '') }}</p>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 15px;">
                            <a href="{{ route('candidate-profile') }}" class="btn-back-profile"
                                style="background: rgba(255, 255, 255, 0.2); color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; border: 1px solid rgba(255, 255, 255, 0.3); transition: all 0.3s ease;"
                                onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'; this.style.borderColor='rgba(255, 255, 255, 0.5)';"
                                onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'; this.style.borderColor='rgba(255, 255, 255, 0.3)';">
                                <i class="bx bx-arrow-back"></i> Back to Profile
                            </a>
                            @if(!empty($internship) && intval($internship->complete_status) === 1)
                                @if(!empty($userReview))
                                <button onclick="openViewReviewModal()" id="viewReviewBtn" class="btn"
                                    style="background: #6c757d; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; border: 1px solid #6c757d; transition: all 0.3s ease;"
                                    onmouseover="this.style.background='#5a636a'; this.style.borderColor='#5a636a';"
                                    onmouseout="this.style.background='#6c757d'; this.style.borderColor='#6c757d';">
                                    <i class="bx bx-show"></i> View Review
                                </button>
                                @else
                                    <button onclick="openReviewModal()" id="giveReviewBtn" class="btn"
                                        style="background: #f26e2c; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; border: 1px solid #f26e2c; transition: all 0.3s ease;"
                                        onmouseover="this.style.background='#ff8c42'; this.style.borderColor='#ff8c42';"
                                        onmouseout="this.style.background='#f26e2c'; this.style.borderColor='#f26e2c';">
                                        <i class="bx bx-star"></i> Give Review
                                    </button>
                                @endif
                            @endif
                            @php
                                $now = \Carbon\Carbon::now();
                                $startDt = $internship->start_date ? \Carbon\Carbon::parse($internship->start_date) : null;
                                $endDt = $internship->end_date ? \Carbon\Carbon::parse($internship->end_date) : null;
                                
                                if (intval($internship->complete_status ?? 0) === 1) {
                                    $dynamicStatus = 'Completed';
                                    $dynamicBadgeBg = '#28a745';
                                    $dynamicIcon = 'bx-check-circle';
                                } elseif ($startDt && $now->lt($startDt)) {
                                    $dynamicStatus = 'Upcoming';
                                    $dynamicBadgeBg = '#17a2b8';
                                    $dynamicIcon = 'bx-time-five';
                                } elseif ($endDt && $now->gt($endDt)) {
                                    // Past end date but complete_status != 1 → Pending
                                    $dynamicStatus = 'Pending';
                                    $dynamicBadgeBg = '#ffc107';
                                    $dynamicIcon = 'bx-time';
                                } else {
                                    $dynamicStatus = 'Active';
                                    $dynamicBadgeBg = '#28a745';
                                    $dynamicIcon = 'bx-check-circle';
                                }
                            @endphp
                            <span class="badge"
                                style="background: {{ $dynamicBadgeBg }}; color: white; padding: 10px 20px; font-size: 16px; border-radius: 8px;">
                                <i class="bx {{ $dynamicIcon }}"></i> {{ $dynamicStatus }}
                            </span>
                        </div>
                    </div>
                </div>

                        <!-- View Review Modal (shows saved review) -->
                        <div class="modal fade" id="viewReviewModal" tabindex="-1" aria-labelledby="viewReviewModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width:600px;">
                                <div class="modal-content" style="border-radius:12px; overflow:hidden;">
                                    <div class="modal-header" style="background:#242a62; color:#fff; border:none;">
                                        <h5 class="modal-title" id="viewReviewModalLabel">Your Review</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="padding:25px;">
                                        <div style="text-align:center; margin-bottom:12px;" id="viewReviewStars">&nbsp;</div>
                                        <div style="text-align:center; color:#6c757d; font-size:13px; margin-bottom:10px;" id="viewReviewMeta">&nbsp;</div>
                                        <div style="background:#f8f9fa; border-radius:8px; padding:15px; min-height:80px;" id="viewReviewText">-</div>
                                    </div>
                                    <div class="modal-footer" style="border-top:1px solid #eee;">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                <!-- Statistics Boxes -->
                @if(intval($internship->complete_status ?? 0) === 1)
                <!-- Success Box - Internship Completed -->
                <div class="mb-4" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border: 1px solid #28a745; border-radius: 12px; padding: 24px; box-shadow: 0 4px 15px rgba(40,167,69,0.15);">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 56px; height: 56px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <span style="font-size: 28px;">🎉</span>
                            </div>
                            <div>
                                <h5 style="margin: 0 0 4px 0; color: #155724; font-weight: 700; font-size: 18px;">Internship Completed Successfully</h5>
                                <p style="margin: 0; color: #155724; font-size: 14px; opacity: 0.85;">You have successfully completed this internship. Share your experience!</p>
                            </div>
                        </div>
                        @if(empty($userReview))
                        <button onclick="openReviewModal()" class="btn" style="background: #f26e2c; color: white; padding: 10px 24px; border-radius: 8px; font-weight: 600; border: none; font-size: 14px; white-space: nowrap;">
                            <i class="bx bx-star"></i> Give Review
                        </button>
                        @else
                        <span style="background: #28a745; color: white; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 13px;">
                            <i class="bx bx-check"></i> Review Submitted
                        </span>
                        @endif
                    </div>
                </div>
                @endif
                @php
                    $userId = auth()->id();
                    $internshipId = $internship->id ?? null;
                    $totalTasks = 0;
                    $completedTasks = 0;
                    $pendingTasks = 0;
                    $daysRemainingDisplay = '-';

                    if ($internshipId) {
                        $totalTasks = \App\Models\InternshipTask::where('internship_id', $internshipId)
                            ->when($userId, function ($q) use ($userId) {
                                return $q->where('student_id', $userId);
                            })->count();

                        $completedTasks = \App\Models\InternshipTask::where('internship_id', $internshipId)
                            ->when($userId, function ($q) use ($userId) {
                                return $q->where('student_id', $userId);
                            })->where('status', 1)->count();

                        $pendingTasks = \App\Models\InternshipTask::where('internship_id', $internshipId)
                            ->when($userId, function ($q) use ($userId) {
                                return $q->where('student_id', $userId);
                            })->where('status', 0)->count();

                        if (!empty($internship->end_date)) {
                            $end = \Carbon\Carbon::parse($internship->end_date);
                            if ($internship->complete_status == 1 || $end->isPast()) {
                                $daysRemainingDisplay = 'Completed';
                            } else {
                                $daysRemainingDisplay = $end->diffInDays(\Carbon\Carbon::now());
                            }
                        } else {
                            $daysRemainingDisplay = '-';
                        }
                    }
                @endphp

                <div class="row mb-4">
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                        <div class="stats-box stats-total" style="border-left:3px solid #17a2b8;border-left-color: #17a2b8;">
                            <h3>{{ $totalTasks }}</h3>
                            <div class="label">Total Tasks</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                        <div class="stats-box stats-completed" style="border-left:3px solid #28a745;border-left-color: #28a745;">
                            <h3>{{ $completedTasks }}</h3>
                            <div class="label">Completed Tasks</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                        <div class="stats-box stats-pending" style="border-left:3px solid #ffc107;border-left-color: #ffc107;">
                            <h3>{{ $pendingTasks }}</h3>
                            <div class="label">Pending Tasks</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                        <div class="stats-box stats-days" style="border-left:3px solid #dc3545;border-left-color: #dc3545;">
                            @if($daysRemainingDisplay === 'Completed')
                                <h4 style="color: #28a745;margin-bottom:10px;">Completed</h4>
                                <div class="label">Internship Status</div>
                            @elseif(is_numeric($daysRemainingDisplay))
                                <h3>{{ $daysRemainingDisplay }}</h3>
                                <div class="label">Days Remaining</div>
                            @else
                                <h3>-</h3>
                                <div class="label">Days Remaining</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs nav-tabs-internship" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab"
                            data-bs-target="#internship-details" type="button" role="tab">
                            <i class="bx bx-info-circle"></i> Internship Details
                        </button>
                    </li>
                    @if(!empty($internship->manage_task_status) && intval($internship->manage_task_status) === 1)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#assigned-tasks"
                            type="button" role="tab">
                            <i class="bx bx-task"></i> Assigned Tasks
                        </button>
                    </li>
                    @endif
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="certificate-tab" data-bs-toggle="tab" data-bs-target="#certificate"
                            type="button" role="tab">
                            <i class="bx bx-certificate"></i> Certificate
                        </button>
                    </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="instructions-tab" data-bs-toggle="tab"
                                data-bs-target="#instructions" type="button" role="tab">
                                <i class="bx bx-file"></i> General Instructions
                            </button>
                        </li>
                    @if(!empty($userReview))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="your-review-tab" data-bs-toggle="tab"
                                data-bs-target="#your-review" type="button" role="tab">
                                <i class="bx bx-star"></i> Your Review
                            </button>
                        </li>
                    @endif

                </ul>

                <!-- Tab Content -->
                <div class="tab-content tab-content-card">
                    <!-- Internship Details Tab -->
                    <div class="tab-pane fade show active" id="internship-details" role="tabpanel">
                        <h5 style="color: #242a62; font-weight: 700; margin-bottom: 20px;">
                            <i class="bx bx-info-circle"></i> Internship Information
                        </h5>

                        <div class="section-card">
                            <h6><i class="bx bx-briefcase"></i> Basic Details</h6>
                            <div class="detail-row">
                                <span class="detail-label">Internship Title:</span>
                                <span class="detail-value">{{ $internship->internship_title ?? '-' }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Company Name:</span>
                                <span
                                    class="detail-value">{{ $internship->company->name ?? ($internship->company->company_name ?? '-') }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Department:</span>
                                <span class="detail-value">{{ $internship->jobCategory->category_nm ?? '-' }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Mode:</span>
                                <span class="detail-value">{{ $internship->mode ?? '-' }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Location:</span>
                                <span class="detail-value">{{ $internship->location ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="section-card">
                            <h6><i class="bx bx-calendar"></i> Duration & Schedule</h6>
                            <div class="detail-row">
                                <span class="detail-label">Duration:</span>
                                <span
                                    class="detail-value">{{ $internship->duration ?? ($internship->total_weeks ? $internship->total_weeks . ' weeks' : '-') }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Start Date:</span>
                                <span
                                    class="detail-value">{{ $startDateFormatted ?? ($internship->start_date ? \Carbon\Carbon::parse($internship->start_date)->format('d F Y') : '-') }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">End Date:</span>
                                <span
                                    class="detail-value">{{ $endDateFormatted ?? ($internship->end_date ? \Carbon\Carbon::parse($internship->end_date)->format('d F Y') : '-') }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Working Hours:</span>
                                <span class="detail-value">
                                    @if (!empty($internship->batch_days) && is_array($internship->batch_days))
                                        {{ implode(', ', array_column($internship->batch_days, 'start_time')) }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Days per Week:</span>
                                <span class="detail-value">
                                    @if (!empty($internship->batch_days) && is_array($internship->batch_days))
                                        {{ count($internship->batch_days) }} Days
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="section-card">
                            <h6><i class="bx bx-money"></i> Stipend & Benefits</h6>
                            <div class="detail-row">
                                <span class="detail-label">Monthly Stipend:</span>
                                <span class="detail-value">
                                    @if (isset($internship->stipend) && $internship->stipend !== null)
                                        ₹{{ number_format($internship->stipend, 2) }}
                                    @else
                                        Not specified
                                    @endif
                                </span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Additional Benefits:</span>
                                <span class="detail-value">
                                    @if (is_array($internship->perks))
                                        {{ implode(', ', $internship->perks) }}
                                    @else
                                        {{ $internship->perks ?? '-' }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        @if (!empty($internship->mentor_name) || !empty($internship->mentor_email))
                            <div class="section-card">
                                <h6><i class="bx bx-user"></i> Mentor Details</h6>
                                <div class="detail-row">
                                    <span class="detail-label">Mentor Name:</span>
                                    <span class="detail-value">{{ $internship->mentor_name ?? '-' }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Designation:</span>
                                    <span class="detail-value">{{ $internship->mentor_designation ?? '-' }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Email:</span>
                                    <span class="detail-value">{{ $internship->mentor_email ?? '-' }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Contact:</span>
                                    <span class="detail-value">{{ $internship->mentor_contact ?? '-' }}</span>
                                </div>
                            </div>
                        @endif

                        @if ($internship->internship_description)
                            <div class="section-card">
                                <h6><i class="bx bx-book"></i> About the Internship</h6>
                                <div style="color: #495057; font-size: 14px; line-height: 1.8;">
                                    {!! $internship->internship_description ?? '<p>No description provided.</p>' !!}
                                </div>
                            </div>
                        @endif


                        @if ($internship->module_brief_description)
                            <div class="section-card">
                                <h6><i class="bx bx-book"></i> Module Brief:</h6>
                                <div style="color: #495057; font-size: 14px; line-height: 1.8;">
                                    {!! $internship->module_brief_description ?? '<p>No description provided.</p>' !!}
                                </div>
                            </div>
                        @endif



                        @if ($internship->internship_objective)
                            <div class="section-card">
                                <h6><i class="bx bx-book"></i> Objective</h6>
                                <div style="color: #495057; font-size: 14px; line-height: 1.8;">
                                    {!! $internship->internship_objective ?? '<p>No description provided.</p>' !!}
                                </div>
                            </div>
                        @endif



                        @if ($internship->internship_outcome)
                            <div class="section-card">
                                <h6><i class="bx bx-book"></i> Outcome</h6>
                                <div style="color: #495057; font-size: 14px; line-height: 1.8;">
                                    {!! $internship->internship_outcome ?? '<p>No description provided.</p>' !!}
                                </div>
                            </div>
                        @endif
                    </div>

                    @if(!empty($internship->manage_task_status) && intval($internship->manage_task_status) === 1)
                    <!-- Assigned Tasks Tab -->
                    <div class="tab-pane fade" id="assigned-tasks" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                                <i class="bx bx-task"></i> Your Assigned Tasks
                            </h5>
                            <span class="badge"
                                style="background: #17a2b8; color: white; font-size: 14px; padding: 8px 16px;">
                                {{ $completedTasks ?? 0 }}/{{ $totalTasks ?? 0 }} Completed
                            </span>
                        </div>

                        <!-- Task Table -->
                        <div class="table-responsive">
                            <table class="table table-hover"
                                style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                <thead
                                    style="background: linear-gradient(135deg, #242a62 0%, #3a4799 100%); color: white;">
                                    <tr>
                                        <th style="padding: 15px; font-weight: 600; font-size: 13px; border: none;">#</th>
                                        <th style="padding: 15px; font-weight: 600; font-size: 13px; border: none;">Task
                                            Title</th>
                                        <th style="padding: 15px; font-weight: 600; font-size: 13px; border: none;">File
                                        </th>
                                        <th style="padding: 15px; font-weight: 600; font-size: 13px; border: none;">Due
                                            Date</th>
                                        <th style="padding: 15px; font-weight: 600; font-size: 13px; border: none;">Status
                                        </th>
                                        <th style="padding: 15px; font-weight: 600; font-size: 13px; border: none; text-align: center;">
                                            Actions</th>
                                    </tr>
                                </thead>
                                    @php
                                    // removed inline imports; use fully-qualified class names below

                                    $userId = auth()->id();
                                    $internshipId = $internship->id ?? null;
                                    $assignedTasks = collect();
                                    if ($internshipId) {
                                        $assignedTasks = \App\Models\InternshipTask::where('internship_id', $internshipId)
                                            ->when($userId, function ($q) use ($userId) {
                                                return $q->where('student_id', $userId);
                                            })->orderBy('id')->get();
                                    }
                                @endphp

                                <tbody>
                                    @forelse($assignedTasks as $index => $task)
                                        <tr style="border-bottom: 1px solid #f0f0f0;">
                                            <td
                                                style="padding: 15px; vertical-align: middle; color: #495057; font-weight: 600;">
                                                {{ $index + 1 }}</td>
                                            <td style="padding: 15px; vertical-align: middle;">
                                                <div style="color: #242a62; font-weight: 600; margin-bottom: 3px;">{{ $task->module_title ?? $task->module_title ?? 'Untitled Task' }}</div>
                                                @php
                                                    $dt = null;
                                                    if(!empty($task->last_submission_date)){
                                                        $dt = \Carbon\Carbon::parse($task->last_submission_date);
                                                    } elseif(!empty($task->due_date)){
                                                        $dt = \Carbon\Carbon::parse($task->due_date);
                                                    } elseif(!empty($task->created_at)){
                                                        $dt = \Carbon\Carbon::parse($task->created_at);
                                                    }
                                                @endphp
                                                <div style="color: #6c757d; font-size: 12px;">
                                                    @if($dt)
                                                        {{ $dt->format('d M Y, h:i A') }} — {{ $dt->format('l') }}
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                            </td>
                                            <td style="padding: 15px; vertical-align: middle; color: #6c757d; font-size: 13px;">
                                                @if(!empty($task->upload_file))
                                                    <a href="{{ asset('uploads/internship_tasks/' . $task->upload_file) }}" class="btn btn-sm"
                                                       style="background: #17a2b8; color: white; padding: 6px 12px; border-radius: 5px; font-weight: 600; border: none; font-size: 12px;">
                                                        <i class="bx bx-download"></i> View Task File
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                                <td style="padding: 15px; vertical-align: middle; color: #6c757d; font-size: 13px;">
                                                {{ $task->last_submission_date ? \Carbon\Carbon::parse($task->last_submission_date)->format('d M Y') : '-' }}</td>
                                            <td style="padding: 15px; vertical-align: middle;">
                                                @if($task->status == 1)
                                                    <span class="badge"
                                                        style="background: #28a745; color: white; padding: 6px 12px; border-radius: 5px; font-size: 11px;">
                                                        <i class="bx bx-check"></i> Completed
                                                    </span>
                                                @elseif($task->status == 0)
                                                    <span class="badge"
                                                        style="background: #ffc107; color: #212529; padding: 6px 12px; border-radius: 5px; font-size: 11px;">
                                                        <i class="bx bx-time"></i> Pending
                                                    </span>
                                                @elseif($task->status == 2)
                                                    <span class="badge"
                                                        style="background: #6c757d; color: white; padding: 6px 12px; border-radius: 5px; font-size: 11px;">
                                                        <i class="bx bx-lock"></i> Locked
                                                    </span>
                                                @else
                                                    <span class="badge"
                                                        style="background: #6c757d; color: white; padding: 6px 12px; border-radius: 5px; font-size: 11px;">
                                                        Unknown
                                                    </span>
                                                @endif
                                            </td>
                                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                                <!-- Always show View Task button to open details modal -->
                                                <button class="btn btn-sm" onclick="viewTaskDetails({{ $task->id }})"
                                                    style="background: #242a62; color: white; padding: 6px 12px; border-radius: 5px; font-weight: 600; border: none; font-size: 12px; margin-right: 6px;">
                                                    <i class="bx bx-show"></i> View Task
                                                </button>

                                                @if($task->status == 0)
                                                    <button class="btn btn-sm" onclick="openSubmitModal(this)"
                                                        data-task-id="{{ $task->id }}"
                                                        data-task-title="{{ e($task->module_title ?? $task->module_title ?? 'Untitled Task') }}"
                                                        data-task-date="{{ $task->last_submission_date ?? $task->due_date ?? $task->created_at ?? '' }}"
                                                        data-is-final="{{ $task->is_final_assignment ? 1 : 0 }}"
                                                        style="background: #f26e2c; color: white; padding: 6px 12px; border-radius: 5px; font-weight: 600; border: none; font-size: 12px;">
                                                        <i class="bx bx-upload"></i> {{ $task->is_final_assignment ? 'Submit Final Assignment / Report' : 'Submit' }}
                                                    </button>
                                                @elseif($task->status == 1)
                                                    <button class="btn btn-sm" onclick="viewTask({{ $task->id }})"
                                                        style="background: #17a2b8; color: white; padding: 6px 12px; border-radius: 5px; font-weight: 600; border: none; font-size: 12px; margin-right: 5px;">
                                                        <i class="bx bx-download"></i> View Submission
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm" disabled
                                                        style="background: #e9ecef; color: #6c757d; padding: 6px 12px; border-radius: 5px; font-weight: 600; border: none; font-size: 12px; cursor: not-allowed;">
                                                        <i class="bx bx-lock"></i> Locked
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" style="padding:20px; text-align:center; color:#6c757d;">No tasks assigned.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Certificate Tab -->
                    <div class="tab-pane fade" id="certificate" role="tabpanel">
                        <h5 style="color: #242a62; font-weight: 700; margin-bottom: 20px;">
                            <i class="bx bx-certificate"></i> Internship Certificate
                        </h5>

                        <div class="certificate-box">
                            <div class="certificate-icon">
                                <i class="fa fa-certificate"></i>
                            </div>
                            <h4 style="color: #242a62; font-weight: 700; margin-bottom: 15px;">
                                <i class="fa fa-graduation-cap"></i> Certificate of Completion
                            </h4>

                            @if(!empty($certificatesAvailable))
                                <p style="color: #6c757d; font-size: 14px; margin-bottom: 25px; max-width: 600px; margin-left: auto; margin-right: auto;">
                                    Congratulations! Your internship certificates are ready. Download your digitally signed certificates below.
                                </p>

                                <div class="d-flex flex-wrap justify-content-center gap-3" style="margin-bottom: 25px;">
                                    @if(!empty($companyCertificateAvailable))
                                        <a href="{{ route('my-internship-certificate.download', ['applicationId' => $application->id, 'type' => 'company']) }}"
                                           class="btn"
                                           style="background: #242a62; color: #fff; padding: 12px 28px; border-radius: 25px; font-weight: 700; border: none; font-size: 14px; text-decoration: none;">
                                            <i class="bx bx-download"></i> Company Certificate
                                        </a>
                                    @endif

                                    @if(!empty($collegeCertificateAvailable))
                                        <a href="{{ route('my-internship-certificate.download', ['applicationId' => $application->id, 'type' => 'college']) }}"
                                           class="btn"
                                           style="background: #f26e2c; color: #fff; padding: 12px 28px; border-radius: 25px; font-weight: 700; border: none; font-size: 14px; text-decoration: none;">
                                            <i class="bx bx-download"></i> College Certificate
                                        </a>
                                    @endif
                                </div>
                            @else
                                <p style="color: #6c757d; font-size: 14px; margin-bottom: 25px; max-width: 600px; margin-left: auto; margin-right: auto;">
                                    Your certificate will be available once you complete all assigned tasks and successfully
                                    finish your internship.
                                    The certificate will be digitally signed and can be downloaded in PDF format.
                                </p>

                                @if($pendingTasks > 0)
                                <div style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 15px; margin-top: 25px; max-width: 600px; margin-left: auto; margin-right: auto;">
                                    <p style="margin: 0; color: #856404; font-size: 13px;">
                                        <i class="bx bx-info-circle"></i> <strong>Note:</strong> Complete {{ $pendingTasks }} more {{ $pendingTasks === 1 ? 'task' : 'tasks' }} to unlock your certificate!
                                    </p>
                                </div>
                                @elseif(intval($internship->complete_status ?? 0) !== 1)
                                <div style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 15px; margin-top: 25px; max-width: 600px; margin-left: auto; margin-right: auto;">
                                    <p style="margin: 0; color: #856404; font-size: 13px;">
                                        <i class="bx bx-info-circle"></i> <strong>Note:</strong> Your certificates will appear here after company and college complete the internship process.
                                    </p>
                                </div>
                                @endif
                            @endif

                            <!-- Give Review Button -->
                            <div style="margin-top: 25px;">
                                <button onclick="openReviewModal()" class="btn"
                                    style="background: linear-gradient(135deg, #f26e2c 0%, #ff8c42 100%); color: white; padding: 12px 30px; border-radius: 25px; font-weight: 700; border: none; font-size: 15px; box-shadow: 0 4px 15px rgba(242, 110, 44, 0.3); transition: all 0.3s ease;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(242, 110, 44, 0.4)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(242, 110, 44, 0.3)'">
                                    <i class="bx bx-star"></i> Give Your Review
                                </button>
                                <p style="color: #6c757d; font-size: 12px; margin-top: 10px;">
                                    Share your experience about this internship
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- General Instructions Tab -->
                    <div class="tab-pane fade" id="instructions" role="tabpanel">
                        <h5 style="color: #242a62; font-weight: 700; margin-bottom: 20px;">
                            <i class="bx bx-file"></i> General Instructions
                        </h5>

                        <div
                            style="background: #f8f9fa; border-radius: 10px; padding: 30px; border-left: 4px solid #242a62; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                            <div style="color: #495057; font-size: 14px; line-height: 1.8;">
                                {!! $internship->general_instructions ?? '<p>No description provided.</p>' !!}
                            </div>
                        </div>
                    </div>

                    {{-- Your Review Tab --}}
                    @if(!empty($userReview))
                    <div class="tab-pane fade" id="your-review" role="tabpanel">
                        <h5 style="color: #242a62; font-weight: 700; margin-bottom: 20px;">
                            <i class="bx bx-star"></i> Your Review
                        </h5>

                        <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 15px rgba(0,0,0,0.08); max-width: 100%;">
                            {{-- Star Rating --}}
                            <div style="text-align: left; margin-bottom: 20px;">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($userReview->star ?? 0))
                                        <span style="color: #ffc107; font-size: 32px;">&#9733;</span>
                                    @else
                                        <span style="color: #e0e0e0; font-size: 32px;">&#9733;</span>
                                    @endif
                                @endfor
                                <p style="margin:8px 0 0; color: #6c757d; font-size: 14px; font-weight: 600;">{{ $userReview->star ?? 0 }} out of 5</p>
                            </div>

                            {{-- Review Text --}}
                            <div style="background: #f8f9fa; border-radius: 10px; padding: 20px; margin-bottom: 16px; border-left: 4px solid #242a62;">
                                <label style="font-weight: 600; color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">Your Experience</label>
                                <p style="margin: 0; color: #495057; font-size: 14px; line-height: 1.7;">{{ $userReview->review ?? 'No description provided.' }}</p>
                            </div>

                            {{-- Meta Info --}}
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <span style="color: #6c757d; font-size: 13px;">
                                    <i class="bx bx-calendar"></i> Submitted on {{ $userReview->write_on ? \Carbon\Carbon::parse($userReview->write_on)->format('d M Y') : ($userReview->created_at ? \Carbon\Carbon::parse($userReview->created_at)->format('d M Y') : '-') }}
                                </span>
                                @php
                                    $reviewStatus = intval($userReview->active_status ?? 0);
                                    if ($reviewStatus === 1) {
                                        $statusLabel = 'Approved';
                                        $statusBg = '#28a745';
                                    } elseif ($reviewStatus === 2) {
                                        $statusLabel = 'Rejected';
                                        $statusBg = '#dc3545';
                                    } else {
                                        $statusLabel = 'Pending';
                                        $statusBg = '#ffc107';
                                    }
                                @endphp
                                <span style="background: {{ $statusBg }}; color: {{ $reviewStatus === 0 ? '#333' : 'white' }}; padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

    <!-- View Task Modal -->
    <!-- Task Details Modal (shows only task information, no submission) -->
    <div class="modal fade" id="viewTaskDetailsModal" tabindex="-1" aria-labelledby="viewTaskDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border: none; border-radius: 12px; overflow: hidden;">
                <div class="modal-header" style="background: #242a62; border: none; padding: 18px 22px; color: white;">
                    <h5 class="modal-title" id="viewTaskDetailsModalLabel" style="font-weight:700;">Task Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 22px;">
                    <div style="background: white; border-radius: 8px; padding: 18px; margin-bottom: 16px; border-left: 4px solid #242a62;">
                        <h6 style="color:#242a62; font-weight:700; margin-bottom:12px;">Task Information</h6>
                        <div style="display:flex; justify-content:space-between;">
                            <div>
                                <div style="color:#6c757d; font-size:13px;">Task Title:</div>
                                <div id="detailsTaskTitle" style="font-weight:700; color:#242a62; margin-top:6px;">-</div>
                                <div style="height:8px"></div>
                                <div style="color:#6c757d; font-size:13px;">Task Created Date/Day:</div>
                                <div id="detailsTaskModule" style="color:#495057; margin-top:6px;">-</div>
                            </div>
                            <div style="text-align:right;">
                                <div style="color:#6c757d; font-size:13px;">Due Date:</div>
                                <div id="detailsTaskDueDate" style="font-weight:700; color:#242a62; margin-top:6px;">-</div>
                                <div style="height:8px"></div>
                                <div style="color:#6c757d; font-size:13px;">Status:</div>
                                <div id="detailsTaskStatus" style="margin-top:6px;"></div>
                            </div>
                        </div>
                    </div>

                    <div style="background: white; border-radius: 8px; padding: 18px; border-left: 4px solid #17a2b8;">
                        <h6 style="color:#17a2b8; font-weight:700; margin-bottom:12px;">Task Description</h6>
                        <div id="detailsTaskDescription" style="color:#495057; font-size:14px; line-height:1.6;">-</div>
                    </div>
                </div>
                <div class="modal-footer" style="background: white; padding: 12px 18px; border-top:1px solid #dee2e6;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background:#6c757d; color:#fff; padding:8px 18px; border-radius:6px; border:none;">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewTaskModal" tabindex="-1" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 1200px; width: 95%;">
            <div class="modal-content" style="border: none; border-radius: 15px; overflow: hidden;">
                <!-- Modal Header with Gradient -->
                <div class="modal-header" style="background: #242a62; border: none; padding: 25px 30px; color: white;">
                    <div>
                        <h5 class="modal-title" id="viewTaskModalLabel"
                            style="font-weight: 700; font-size: 20px; margin: 0 0 5px 0;">
                            <i class="bx bx-task"></i> Task Details
                        </h5>
                        <p style="margin: 0; font-size: 14px; opacity: 0.95;color:#fff;">View your submitted task
                            information</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>

                <div class="modal-body" style="background: #f8f9fa; padding: 30px;">
                    <!-- Task Information Section -->
                    <div
                        style="background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; border-left: 4px solid #242a62; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <h6 style="color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                            <i class="bx bx-info-circle"></i> Task Information
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div style="margin-bottom: 15px;">
                                    <label
                                        style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Task
                                        Title:</label>
                                    <p style="margin: 0; color: #212529; font-size: 14px;" id="viewTaskTitle">Create
                                        Landing Page</p>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <label
                                        style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Task Created Date/Day:</label>
                                    <p style="margin: 0; color: #212529; font-size: 14px;" id="viewTaskModule">Week 2</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="margin-bottom: 15px;">
                                    <label
                                        style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Due
                                        Date:</label>
                                    <p style="margin: 0; color: #212529; font-size: 14px;" id="viewTaskDueDate">12 Feb
                                        2026</p>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <label
                                        style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Status:</label>
                                    <span class="badge"
                                        style="background: #28a745; color: white; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;"
                                        id="viewTaskStatus">
                                        <i class="bx bx-check-circle"></i> Completed
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Task Description -->
                    <div
                        style="background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; border-left: 4px solid #17a2b8; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <h6 style="color: #17a2b8; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                            <i class="bx bx-file-blank"></i> Task Description
                        </h6>
                        <div style="color: #495057; font-size: 14px; line-height: 1.8;" id="viewTaskDescription">
                            Design and develop a responsive landing page using HTML5, CSS3, and JavaScript with modern UI/UX
                            principles.
                        </div>
                    </div>

                    <!-- Submission Details Section -->
                    <div
                        style="background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; border-left: 4px solid #28a745; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <h6 style="color: #28a745; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                            <i class="bx bx-check-double"></i> Your Submission
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div style="margin-bottom: 15px;">
                                    <label
                                        style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Submitted
                                        On:</label>
                                    <p style="margin: 0; color: #212529; font-size: 14px;" id="viewSubmittedDate">11 Feb
                                        2026, 04:30 PM</p>
                                </div>
                            </div>
                                <div class="col-md-6">
                                    <div style="margin-bottom: 15px;">
                                        <label
                                            style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Submitted
                                            File:</label>
                                        <div id="viewSubmittedFile">
                                            <span style="color:#6c757d;">-</span>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div style="margin-top: 15px;">
                            <label
                                style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 10px; display: block;">Project
                                Link:</label>
                            <div style="background: #f8f9fa; border-radius: 8px; padding: 15px; color: #495057; font-size: 14px; line-height: 1.6;"
                                id="viewSubmissionProjectLink">
                                -
                            </div>
                        
                            <div style="margin-top:16px;">
                                <h6 style="color: #28a745; font-weight: 700; font-size: 14px; margin-bottom:8px;">Submission Description</h6>
                                <div id="viewSubmittedDescription" style="background:#f8f9fa; border-radius:8px; padding:12px; color:#495057; font-size:14px; line-height:1.6; white-space:pre-wrap;">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Feedback (shows after Your Submission) -->
                    <div id="viewFeedbackSection" style="display:none; background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #f26e2c; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <h6 style="color: #f26e2c; font-weight: 700; font-size: 16px; margin-bottom: 12px;">
                            <i class="bx bx-message-dots"></i> Instructor Feedback
                        </h6>
                        <div id="viewFeedbackContent" style="color: #495057; font-size: 14px; line-height: 1.6; white-space:pre-wrap;"></div>
                        <div style="margin-top:10px; color:#6c757d; font-size:12px;" id="viewFeedbackMeta"></div>
                    </div>
                </div>

                <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6;">
                    <button type="button" class="btn" data-bs-dismiss="modal"
                        style="background: #6c757d; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                        <i class="bx bx-x"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Internship Review Modal -->
    <div class="modal fade" id="internshipReviewModal" tabindex="-1" aria-labelledby="internshipReviewModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 650px;">
            <div class="modal-content"
                style="border: none; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
                <!-- Modal Header with Gradient -->
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #242a62 0%, #3a4799 100%); border: none; padding: 30px; color: white; text-align: center; display: block;">
                    <div style="text-align: center; margin-bottom: 15px;">
                        <div
                            style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; backdrop-filter: blur(10px);">
                            <img src="{{ asset('assets/imgs/profile.png') }}" alt="Profile image" style="border-radius: 50%">
                        </div>
                        <div style="margin-top:6px; font-weight:700; color:#fff;" id="reviewUserName">{{ auth()->user()->name ?? auth()->user()->full_name ?? auth()->user()->email ?? 'You' }}</div>
                    </div>
                    <h5 class="modal-title" id="internshipReviewModalLabel"
                        style="font-weight: 700; font-size: 24px; margin: 0 0 8px 0; text-align: center;">
                        🎉 Congratulations!
                    </h5>
                    <p style="margin: 0; font-size: 15px; opacity: 0.95; text-align: center;color:#fff;">You've
                        successfully completed your internship</p>
                </div>

                <div class="modal-body" style="padding: 35px; background: white;">
                    <!-- Internship Info Card -->
                    <div
                        style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; padding: 20px; margin-bottom: 25px; border-left: 4px solid #f26e2c;">
                        <div style="margin-bottom: 12px;">
                            <label
                                style="font-weight: 600; color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 5px;">
                                <i class="bx bx-briefcase" style="font-size: 14px;"></i> Internship
                            </label>
                            <p style="margin: 0; color: #242a62; font-size: 18px; font-weight: 700;"
                                id="reviewInternshipName">Full-Stack Web Development</p>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label
                                    style="font-weight: 600; color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 5px;">
                                    <i class="bx bx-calendar-check" style="font-size: 14px;"></i> Start Date
                                </label>
                                <p style="margin: 0; color: #495057; font-size: 14px; font-weight: 600;"
                                    id="reviewStartDate">01 February 2026</p>
                            </div>
                            <div class="col-6">
                                <label
                                    style="font-weight: 600; color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 5px;">
                                    <i class="bx bx-calendar-x" style="font-size: 14px;"></i> End Date
                                </label>
                                <p style="margin: 0; color: #495057; font-size: 14px; font-weight: 600;"
                                    id="reviewEndDate">30 April 2026</p>
                            </div>
                        </div>
                    </div>

                    <!-- Rating Section -->
                    <div style="text-align: center; margin-bottom: 25px;">
                        <h6 style="color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 15px;">
                            How was your internship experience?
                        </h6>
                        <div class="stars" id="radioStarRating" style="margin-bottom:8px;">
                            <input type="radio" name="rating" id="star5" value="5">
                            <label for="star5">★</label>

                            <input type="radio" name="rating" id="star4" value="4">
                            <label for="star4">★</label>

                            <input type="radio" name="rating" id="star3" value="3">
                            <label for="star3">★</label>

                            <input type="radio" name="rating" id="star2" value="2">
                            <label for="star2">★</label>

                            <input type="radio" name="rating" id="star1" value="1">
                            <label for="star1">★</label>
                        </div>
                        <p style="margin: 0; color: #6c757d; font-size: 14px; font-weight: 600;" id="ratingText">&nbsp;</p>
                        <input type="hidden" id="internshipRating" value="0">
                    </div>

                    <!-- Review Text Area -->
                    <div style="margin-bottom: 20px;">
                        <label class="form-label"
                            style="font-weight: 600; color: #495057; font-size: 14px; margin-bottom: 10px;">
                            <i class="bx bx-message-square-dots"></i> Share your experience (Optional)
                        </label>
                        <textarea class="form-control" id="reviewText" rows="4"
                            style="padding: 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; resize: none;height:130px;"
                            placeholder="Tell us about your internship journey, what you learned, and how it helped you grow..."></textarea>
                    </div>

                    <!-- Skip Option -->
                    <div style="text-align: center; margin-bottom: 15px;">
                        <button type="button" class="btn" data-bs-dismiss="modal"
                            style="color: #6c757d; background: transparent; border: none; font-size: 13px; text-decoration: underline; padding: 5px 15px;">
                            Skip for now
                        </button>
                    </div>
                </div>

                <div class="modal-footer"
                    style="background: #f8f9fa; padding: 20px 35px; border-top: 1px solid #dee2e6; justify-content: center;">
                    <button type="button" class="btn" onclick="submitReview()"
                        style="background: linear-gradient(135deg, #f26e2c 0%, #ff8c42 100%); color: white; padding: 12px 40px; border-radius: 25px; font-weight: 700; border: none; font-size: 15px; box-shadow: 0 4px 15px rgba(242, 110, 44, 0.3); transition: all 0.3s ease;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(242, 110, 44, 0.4)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(242, 110, 44, 0.3)'">
                        <i class="bx bx-send"></i> Submit Review
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Task Modal -->
    <div class="modal fade" id="submitTaskModal" tabindex="-1" aria-labelledby="submitTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 1400px; width: 95%; margin: 1.75rem auto;">
            <div class="modal-content" style="border: none; border-radius: 15px; overflow: hidden;">
                <!-- Modal Header with Gradient -->
                <div class="modal-header" style="background: #242a62; border: none; padding: 25px 30px; color: white;">
                    <div>
                        <h5 class="modal-title" id="submitTaskModalLabel"
                            style="font-weight: 700; font-size: 20px; margin: 0 0 5px 0;">
                            <i class="bx bx-upload"></i> Submit Task
                        </h5>
                        <p style="margin: 0; font-size: 14px; opacity: 0.95;color:#fff;">Upload your completed task and
                            provide details</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body" style="background: #f8f9fa; padding: 30px;">
                    <form id="submitTaskForm" action="{{ route('internship.task.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="task_id" id="submitTaskId" value="">
                        <!-- Task Info Display -->
                        <div
                            style="background: white; border-radius: 10px; padding: 20px; margin-bottom: 25px; border-left: 4px solid #242a62; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <div class="row">
                                <div class="col-md-6">
                                    <div style="margin-bottom: 10px;">
                                        <label
                                            style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Task:</label>
                                        <p style="margin: 0; color: #242a62; font-size: 15px; font-weight: 600;"
                                            id="submitTaskTitle">API Integration</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div style="margin-bottom: 10px;">
                                        <label
                                            style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Due
                                            Date:</label>
                                        <p style="margin: 0; color: #dc3545; font-size: 14px; font-weight: 600;"
                                            id="submitTaskDueDate">19 Feb 2026</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- File Upload Section -->
                        <div
                            style="background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <h6 style="color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                                <i class="bx bx-cloud-upload"></i> Upload Files
                            </h6>
                            <div class="mb-3">
                                <label class="form-label"
                                    style="font-weight: 600; color: #495057; font-size: 14px; margin-bottom: 10px;">
                                    <i class="bx bx-file"></i> Upload Task File <span style="color: #dc3545;">*</span>
                                </label>
                                <input type="file" accept=".pdf,application/pdf" class="form-control" id="taskFile" name="task_file" required
                                    style="padding: 12px; border: 2px dashed #dee2e6; border-radius: 8px; background: #f8f9fa;">
                                <small class="text-muted" style="font-size: 12px; margin-top: 5px; display: block;">
                                    <i class="bx bx-info-circle"></i> Accepted formats: ZIP, PDF, DOC, DOCX (Max: 10MB)
                                </small>
                            </div>
                        </div>

                        <!-- Notes/Description Section with CKEditor -->
                        <div
                            style="background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <h6 style="color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                                <i class="bx bx-edit"></i> Task Notes & Description
                            </h6>
                            <div class="mb-3">
                                <label class="form-label"
                                    style="font-weight: 600; color: #495057; font-size: 14px; margin-bottom: 10px;">
                                    Describe your work <span style="color: #dc3545;">*</span>
                                </label>
                                <textarea class="form-control" id="taskNotes" name="task_notes" rows="8" required
                                    style="padding: 15px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px;"
                                    placeholder="Enter Your Task Notes & Description"></textarea>
                                <small class="text-muted" style="font-size: 12px; margin-top: 5px; display: block;">
                                    <i class="bx bx-info-circle"></i> Provide detailed information about your submission
                                </small>
                            </div>
                        </div>

                        <!-- Project Link (Optional) -->
                        <div
                            style="background: white; border-radius: 10px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <h6 style="color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                                <i class="bx bx-link"></i> Additional Information
                            </h6>
                            <div class="mb-3">
                                <label class="form-label"
                                    style="font-weight: 600; color: #495057; font-size: 14px; margin-bottom: 10px;">
                                    Project/Demo Link (Optional)
                                </label>
                                <input type="url" class="form-control" id="projectLink" name="project_link"
                                    placeholder="https://example.com/your-project"
                                    style="padding: 12px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px;">
                                <small class="text-muted" style="font-size: 12px; margin-top: 5px; display: block;">
                                    <i class="bx bx-info-circle"></i> Add a link to your hosted project or GitHub
                                    repository
                                </small>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer"
                    style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6; display: flex; justify-content: space-between;">
                    <button type="button" class="btn" data-bs-dismiss="modal"
                        style="background: #6c757d; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                        <i class="bx bx-x"></i> Cancel
                    </button>
                    <button type="button" id="submitTaskBtn" class="btn" onclick="submitTaskForm()"
                        style="background: #28a745; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                        <i class="bx bx-check"></i> Submit Task
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Initialize CKEditor 5 (ClassicEditor)
        let editorInstance = null;

           window.openInstructionsModal = function() {
        const instructionsModal = new bootstrap.Modal(document.getElementById('instructionsModal'));
        instructionsModal.show();
        
        // Initialize CKEditor
        if (!instructionsEditor) {
            
        } else {
            instructionsEditor.setData(document.getElementById('instructionsContent').innerHTML);
        }
    }

        // Preload assigned tasks data for modal (keyed by id)
        // We'll fetch task details from server via AJAX when user clicks View

        // View Task by fetching JSON from server
        window.viewTask = function(taskId) {
            const url = '{{ url('internship/task') }}' + '/' + taskId + '/json';
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
                },
                credentials: 'same-origin'
            }).then(res => {
                if (!res.ok) throw res;
                return res.json();
            }).then(task => {
                document.getElementById('viewTaskTitle').textContent = task.title || 'Untitled Task';

                // Show task added date/time and day (replace Module)
                let added = '-';
                if (task.date_time) {
                    const dt = new Date(task.date_time);
                    const opts = { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' };
                    const dayName = task.day || dt.toLocaleDateString('en-GB', { weekday: 'long' });
                    added = dt.toLocaleDateString('en-GB', opts) + ' — ' + dayName;
                }
                document.getElementById('viewTaskModule').textContent = added;

                // Due date
                if (task.due_date) {
                    const dd = new Date(task.due_date);
                    document.getElementById('viewTaskDueDate').textContent = dd.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                } else {
                    document.getElementById('viewTaskDueDate').textContent = '-';
                }

                // Status badge
                const statusEl = document.getElementById('viewTaskStatus');
                if (task.status == 1) {
                    statusEl.innerHTML = '<i class="bx bx-check-circle"></i> Completed';
                    statusEl.style.background = '#28a745';
                } else if (task.status == 0) {
                    statusEl.innerHTML = '<i class="bx bx-time"></i> Pending';
                    statusEl.style.background = '#ffc107';
                } else {
                    statusEl.innerHTML = '<i class="bx bx-lock"></i> Locked';
                    statusEl.style.background = '#6c757d';
                }

                // Description (allow HTML)
                document.getElementById('viewTaskDescription').innerHTML = task.description || '<p>No description provided.</p>';

                // Your Submission: submitted on
                const submittedOnEl = document.getElementById('viewSubmittedDate');
                if (task.submit_on) {
                    const sd = new Date(task.submit_on);
                    submittedOnEl.textContent = sd.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                } else {
                    submittedOnEl.textContent = '-';
                }

                // Submitted file button
                const submittedFileContainer = document.getElementById('viewSubmittedFile');
                submittedFileContainer.innerHTML = '-';
                if (task.student_submit_file) {
                    const urlFile = '{{ asset('uploads/internship_tasks_submit') }}' + '/' + task.student_submit_file;
                    submittedFileContainer.innerHTML = '<a class="btn btn-sm" href="' + urlFile + '" target="_blank" style="background: #17a2b8; color: white; border: none; padding: 6px 15px; border-radius: 5px; font-size: 12px; font-weight: 600;\"><i class="bx bx-download"></i> View Submitted File</a>';
                }

                // Project link
                const projectLinkContainer = document.getElementById('viewSubmissionProjectLink');
                projectLinkContainer.innerHTML = '-';
                if (task.student_submit_project_link) {
                    const link = task.student_submit_project_link;
                    projectLinkContainer.innerHTML = '<div style="display:flex; align-items:center; gap:10px;\"><a href="'+link+'" target="_blank" class="btn btn-sm" style="background:#f26e2c; color:#fff; padding:6px 12px; border-radius:6px; font-weight:600;">Open Link</a><span style="word-break:break-all;">'+link+'</span></div>';
                }

                // Student submitted description (show under Your Submission)
                try {
                    const descEl = document.getElementById('viewSubmittedDescription');
                    if (descEl) {
                        const sdesc = (task.student_submit_description || '').toString();
                        if (sdesc.trim().length > 0) {
                            // Render as HTML so rich text / CKEditor content shows correctly
                            descEl.innerHTML = sdesc;
                        } else {
                            descEl.textContent = 'No description provided.';
                        }
                    }
                } catch (e) { console.error('desc render error', e); }

                // Show admin/instructor feedback if present
                try {
                    const feedbackSection = document.getElementById('viewFeedbackSection');
                    const feedbackContent = document.getElementById('viewFeedbackContent');
                    const feedbackMeta = document.getElementById('viewFeedbackMeta');
                    if ((task.task_feedback || '').toString().trim().length > 0) {
                        if (feedbackSection) feedbackSection.style.display = 'block';
                        if (feedbackContent) {
                            // Render as HTML to preserve formatting
                            feedbackContent.innerHTML = task.task_feedback;
                        }
                        // optional metadata if API provides who/when
                        var metaText = '';
                        if (task.feedback_by_name) metaText += 'By: ' + task.feedback_by_name;
                        if (task.feedback_on) {
                            var d = new Date(task.feedback_on);
                            var formatted = d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) + ' ' + d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
                            metaText += (metaText ? ' • ' : '') + 'On: ' + formatted;
                        }
                        if (feedbackMeta) feedbackMeta.textContent = metaText;
                    } else {
                        if (feedbackSection) feedbackSection.style.display = 'none';
                        if (feedbackContent) feedbackContent.textContent = '';
                        if (feedbackMeta) feedbackMeta.textContent = '';
                    }
                } catch (e) { console.error('feedback render error', e); }

                const modal = new bootstrap.Modal(document.getElementById('viewTaskModal'));
                modal.show();
            }).catch(err => {
                console.error('Fetch error', err);
                if (err && err.json) {
                    err.json().then(e => {
                        console.error('Server response error', e);
                        alert(e.error || 'Unable to fetch task');
                    }).catch(() => {
                        alert('Unable to fetch task');
                    });
                } else {
                    alert('Unable to fetch task');
                }
            });
        }

        // View only task details (no submission) — opens separate modal
        window.viewTaskDetails = function(taskId) {
            const url = '{{ url('internship/task') }}' + '/' + taskId + '/json';
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : ''
                },
                credentials: 'same-origin'
            }).then(res => {
                if (!res.ok) throw res;
                return res.json();
            }).then(task => {
                document.getElementById('detailsTaskTitle').textContent = task.title || 'Untitled Task';

                // created/added date
                let added = '-';
                if (task.date_time) {
                    const dt = new Date(task.date_time);
                    const opts = { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' };
                    const dayName = task.day || dt.toLocaleDateString('en-GB', { weekday: 'long' });
                    added = dt.toLocaleDateString('en-GB', opts) + ' — ' + dayName;
                }
                document.getElementById('detailsTaskModule').textContent = added;

                // Due date
                if (task.due_date) {
                    const dd = new Date(task.due_date);
                    document.getElementById('detailsTaskDueDate').textContent = dd.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                } else {
                    document.getElementById('detailsTaskDueDate').textContent = '-';
                }

                // Status
                const statusEl = document.getElementById('detailsTaskStatus');
                statusEl.innerHTML = '';
                if (task.status == 1) {
                    statusEl.innerHTML = '<span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 5px; font-size: 11px;"> <i class="bx bx-check"></i> Completed</span>';
                } else if (task.status == 0) {
                    statusEl.innerHTML = '<span class="badge" style="background: #ffc107; color: #212529; padding: 6px 12px; border-radius: 5px; font-size: 11px;"> <i class="bx bx-time"></i> Pending</span>';
                } else {
                    statusEl.innerHTML = '<span class="badge" style="background: #6c757d; color: white; padding: 6px 12px; border-radius: 5px; font-size: 11px;"> <i class="bx bx-lock"></i> Locked</span>';
                }

                // Description only (allow HTML)
                document.getElementById('detailsTaskDescription').innerHTML = task.module_description || '<p>No description provided.</p>';

                const modal = new bootstrap.Modal(document.getElementById('viewTaskDetailsModal'));
                modal.show();
            }).catch(err => {
                console.error('Fetch error', err);
                if (err && err.json) {
                    err.json().then(e => { alert(e.error || 'Unable to fetch task'); }).catch(() => { alert('Unable to fetch task'); });
                } else {
                    alert('Unable to fetch task');
                }
            });
        }

        // Open Submit Modal and prefill values
        window.openSubmitModal = function(button) {
            const taskId = button.getAttribute('data-task-id');
            const title = button.getAttribute('data-task-title') || 'Task';
            const date = button.getAttribute('data-task-date') || '';
            const isFinal = button.getAttribute('data-is-final') === '1' || button.getAttribute('data-is-final') === 'true';

            document.getElementById('submitTaskTitle').textContent = title;
            document.getElementById('submitTaskDueDate').textContent = date ? (new Date(date)).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
            document.getElementById('submitTaskId').value = taskId;

            // Update modal title and submit button text when this is the final assignment
            const modalTitleEl = document.getElementById('submitTaskModalLabel');
            const submitBtn = document.getElementById('submitTaskBtn');
            if (isFinal) {
                if (modalTitleEl) modalTitleEl.innerHTML = '<i class="bx bx-upload"></i> Submit Final Assignment / Report';
                if (submitBtn) submitBtn.innerHTML = '<i class="bx bx-check"></i> Submit Final Assignment / Report';
            } else {
                if (modalTitleEl) modalTitleEl.innerHTML = '<i class="bx bx-upload"></i> Submit Task';
                if (submitBtn) submitBtn.innerHTML = '<i class="bx bx-check"></i> Submit Task';
            }

            // Show modal
            const modalEl = document.getElementById('submitTaskModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();

            // Initialize CKEditor 5 (ClassicEditor) when modal opens
            modalEl.addEventListener('shown.bs.modal', function() {
                if (!editorInstance && window.ClassicEditor) {
                    ClassicEditor
                        .create(document.querySelector('#taskNotes'), {
                            toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote']
                        })
                        .then(ed => {
                            editorInstance = ed;
                            window.editorInstance = ed;
                        })
                        .catch(error => {
                            console.error('Error initializing CKEditor 5:', error);
                        });
                }
            }, { once: true });

            // Destroy CKEditor instance when modal is hidden to free memory
            modalEl.addEventListener('hidden.bs.modal', function() {
                if (editorInstance) {
                    editorInstance.destroy().catch(() => {});
                    editorInstance = null;
                    window.editorInstance = null;
                    // clear textarea
                    const ta = document.getElementById('taskNotes');
                    if (ta) ta.value = '';
                }
            });
        }

        // Submit Task Form (AJAX + SweetAlert2)
        window.submitTaskForm = function() {
            const form = document.getElementById('submitTaskForm');
            const fileInput = document.getElementById('taskFile');

            // Get CKEditor 5 content (if initialized) and set to textarea
            try {
                const notesEl = document.getElementById('taskNotes');
                if (window.editorInstance && typeof window.editorInstance.getData === 'function') {
                    const data = window.editorInstance.getData();
                    if (notesEl) notesEl.value = data;
                } else if (typeof CKEDITOR !== 'undefined' && window.CKEDITOR && CKEDITOR.instances) {
                    // fallback for CKEditor 4 (if used elsewhere)
                    try {
                        const inst = CKEDITOR.instances['taskNotes'];
                        if (inst && inst.getData) notesEl.value = inst.getData();
                    } catch(e) {}
                }
            } catch (e) { console.error('editor getData error', e); }

            // Basic validation
            if (!fileInput || !fileInput.files.length) {
                Swal.fire({ icon: 'warning', title: 'Please upload a file!', confirmButtonText: 'OK' });
                return;
            }

            const url = form.action;
            const formData = new FormData(form);
            const token = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

            Swal.fire({ title: 'Submitting...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                credentials: 'same-origin',
                body: formData
            }).then(res => {
                if (!res.ok) throw res;
                // Try to parse JSON, but if server returns HTML (redirect), fallback to success
                return res.json().catch(() => ({ success: true }));
            }).then(data => {
                Swal.close();
                const msg = (data && data.message) ? data.message : 'Task submitted successfully';
                Swal.fire({ icon: 'success', title: msg, confirmButtonText: 'OK' }).then(() => {
                    // Close submit modal if open and reload to refresh task state
                    try { const m = bootstrap.Modal.getInstance(document.getElementById('submitTaskModal')); if (m) m.hide(); } catch (e) {}
                    window.location.reload();
                });
            }).catch(err => {
                Swal.close();
                console.error('Submission error', err);
                let text = 'Unable to submit. Please try again.';
                if (err && err.statusText) text = err.statusText;
                Swal.fire({ icon: 'error', title: 'Submission failed', text: text, confirmButtonText: 'OK' });
            });
        }

        // Cleanup editor when modal is hidden (safety for any leftover instance)
        document.getElementById('submitTaskModal').addEventListener('hidden.bs.modal', function() {
            try {
                if (window.editorInstance && typeof window.editorInstance.destroy === 'function') {
                    window.editorInstance.destroy().catch(() => {});
                    window.editorInstance = null;
                    editorInstance = null;
                }
            } catch (e) {}
        });

        // Star Rating System (radio-input based)
        let selectedRating = 0;
        const ratingText = document.getElementById('ratingText');
        const ratingInput = document.getElementById('internshipRating');

        const ratingMessages = {
            1: '⭐ Poor - Needs improvement',
            2: '⭐⭐ Fair - Below expectations',
            3: '⭐⭐⭐ Good - Met expectations',
            4: '⭐⭐⭐⭐ Very Good - Exceeded expectations',
            5: '⭐⭐⭐⭐⭐ Excellent - Outstanding experience!'
        };

        // Wire radio inputs if present
        const radioStars = document.querySelectorAll('.stars input[name="rating"]');
        if (radioStars && radioStars.length) {
            radioStars.forEach(r => {
                r.addEventListener('change', function() {
                    selectedRating = parseInt(this.value) || 0;
                    ratingInput.value = selectedRating;
                    if (selectedRating && ratingMessages[selectedRating]) {
                        ratingText.textContent = ratingMessages[selectedRating];
                        ratingText.style.color = '#f26e2c';
                        ratingText.style.fontWeight = '700';
                    } else {
                        ratingText.textContent = '';
                    }
                });
            });
        }

        // Expose server-provided review (if any) to client JS
        window.serverUserReview = @json($userReview ?? null);

        // When modal opens, ensure radio reflects selectedRating (if previously set)
        document.getElementById('internshipReviewModal').addEventListener('shown.bs.modal', function() {
            // sync radio UI
            if (selectedRating > 0) {
                const sel = document.querySelector('.stars input[value="' + selectedRating + '"]');
                if (sel) sel.checked = true;
                ratingText.textContent = ratingMessages[selectedRating] || '';
                ratingText.style.color = '#f26e2c';
            } else {
                ratingText.textContent = '';
            }
        });

        // Submit Review Function
        window.submitReview = function() {
            const rating = selectedRating;
            const reviewText = document.getElementById('reviewText').value;

            if (rating === 0) {
                alert('Please select a star rating before submitting!');
                return;
            }

            // Prepare payload
            const payload = {
                internship_id: {{ $internship->id ?? 'null' }},
                student_id: {{ auth()->id() ?? 'null' }},
                star: rating,
                review: reviewText || null,
                active_status: 0,
                write_on: new Date().toISOString()
            };

            const url = '{{ url('internship/review') }}';
            const token = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token
                },
                credentials: 'same-origin',
                body: JSON.stringify(payload)
            }).then(res => {
                if (!res.ok) throw res;
                return res.json();
            }).then(data => {
                // Expecting { success: true, message: '...' }
                alert(data.message || 'Thank you for your feedback!');
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('internshipReviewModal')).hide();
                // mark as submitted locally
                localStorage.setItem('internshipReviewSubmitted', 'true');
                // Update UI: replace Give Review button with View Review button
                const giveBtn = document.getElementById('giveReviewBtn');
                if (giveBtn) giveBtn.remove();
                if (!document.getElementById('viewReviewBtn')) {
                    const container = document.querySelector('.internship-details-header .d-flex.align-items-center');
                    if (container) {
                        const btn = document.createElement('button');
                        btn.id = 'viewReviewBtn';
                        btn.className = 'btn';
                        btn.style = "background: #6c757d; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; border: 1px solid #6c757d; transition: all 0.3s ease;";
                        btn.innerHTML = '<i class="bx bx-show"></i> View Review';
                        btn.onclick = openViewReviewModal;
                        container.insertBefore(btn, container.querySelector('.badge'));
                    }
                }

                // Store the review client-side for immediate viewing
                window.userReview = {
                    internship_id: payload.internship_id,
                    student_id: payload.student_id,
                    star: payload.star,
                    review: payload.review,
                    write_on: payload.write_on
                };

                // Update success box: replace Give Review button with "Review Submitted" badge
                var successBoxBtn = document.querySelector('.mb-4 .btn[onclick="openReviewModal()"]');
                if (successBoxBtn) {
                    var badge = document.createElement('span');
                    badge.style = 'background:#28a745;color:white;padding:8px 16px;border-radius:8px;font-weight:600;font-size:13px;';
                    badge.innerHTML = '<i class="bx bx-check"></i> Review Submitted';
                    successBoxBtn.parentNode.replaceChild(badge, successBoxBtn);
                }

                // Add "Your Review" tab dynamically
                var tabList = document.querySelector('.nav-tabs-internship');
                var tabContent = document.querySelector('.tab-content.tab-content-card');
                if (tabList && !document.getElementById('your-review-tab')) {
                    var li = document.createElement('li');
                    li.className = 'nav-item';
                    li.setAttribute('role', 'presentation');
                    li.innerHTML = '<button class="nav-link" id="your-review-tab" data-bs-toggle="tab" data-bs-target="#your-review" type="button" role="tab"><i class="bx bx-star"></i> Your Review</button>';
                    tabList.appendChild(li);
                }
                if (tabContent && !document.getElementById('your-review')) {
                    var starsHtml = '';
                    for (var si = 1; si <= 5; si++) {
                        starsHtml += si <= payload.star ? '<span style="color:#ffc107;font-size:32px;">&#9733;</span>' : '<span style="color:#e0e0e0;font-size:32px;">&#9733;</span>';
                    }
                    var reviewDate = new Date().toLocaleDateString('en-GB', {day:'2-digit',month:'short',year:'numeric'});
                    var pane = document.createElement('div');
                    pane.className = 'tab-pane fade';
                    pane.id = 'your-review';
                    pane.setAttribute('role', 'tabpanel');
                    pane.innerHTML = '<h5 style="color:#242a62;font-weight:700;margin-bottom:20px;"><i class="bx bx-star"></i> Your Review</h5>'
                        + '<div style="background:white;border-radius:12px;padding:30px;box-shadow:0 2px 15px rgba(0,0,0,0.08);max-width:600px;">'
                        + '<div style="text-align:center;margin-bottom:20px;">' + starsHtml + '<p style="margin:8px 0 0;color:#6c757d;font-size:14px;font-weight:600;">' + payload.star + ' out of 5</p></div>'
                        + '<div style="background:#f8f9fa;border-radius:10px;padding:20px;margin-bottom:16px;border-left:4px solid #242a62;">'
                        + '<label style="font-weight:600;color:#6c757d;font-size:12px;text-transform:uppercase;letter-spacing:0.5px;display:block;margin-bottom:8px;">Your Experience</label>'
                        + '<p style="margin:0;color:#495057;font-size:14px;line-height:1.7;">' + (payload.review || 'No description provided.') + '</p></div>'
                        + '<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">'
                        + '<span style="color:#6c757d;font-size:13px;"><i class="bx bx-calendar"></i> Submitted on ' + reviewDate + '</span>'
                        + '<span style="background:#ffc107;color:#333;padding:5px 14px;border-radius:20px;font-size:12px;font-weight:600;">Pending</span>'
                        + '</div></div>';
                    tabContent.appendChild(pane);
                }
            }).catch(err => {
                console.error('Review submit error', err);
                if (err && err.json) {
                    err.json().then(e => {
                        alert(e.message || 'Unable to submit review');
                    }).catch(() => {
                        alert('Unable to submit review');
                    });
                } else {
                    alert('Unable to submit review');
                }
            });
        }

        // Function to open review modal manually
        window.openReviewModal = function() {
            // Reset star rating
            selectedRating = 0;
            ratingInput.value = 0;
            if (typeof ratingText !== 'undefined' && ratingText) {
                ratingText.textContent = '';
                ratingText.style.color = '#6c757d';
                ratingText.style.fontWeight = '600';
            }

            // Populate internship info from server-side values
            const internshipNameEl = document.getElementById('reviewInternshipName');
            const startDateEl = document.getElementById('reviewStartDate');
            const endDateEl = document.getElementById('reviewEndDate');

            if (internshipNameEl) internshipNameEl.textContent = @json($internship->internship_title ?? '-');
            if (startDateEl) startDateEl.textContent = @json($startDateFormatted ?? ($internship->start_date ? \Carbon\Carbon::parse($internship->start_date)->format('d F Y') : '-'));
            if (endDateEl) endDateEl.textContent = @json($endDateFormatted ?? ($internship->end_date ? \Carbon\Carbon::parse($internship->end_date)->format('d F Y') : '-'));

            // Clear review text
            const reviewTextarea = document.getElementById('reviewText');
            if (reviewTextarea) reviewTextarea.value = '';

            // Show modal
            const reviewModal = new bootstrap.Modal(document.getElementById('internshipReviewModal'));
            reviewModal.show();

            // Ensure radio stars are cleared after modal opens
            setTimeout(function() {
                const radios = document.querySelectorAll('.stars input[name="rating"]');
                if (radios && radios.length) {
                    radios.forEach(r => r.checked = false);
                }
            }, 100);
        }

        // Open view modal and populate with saved review
        window.openViewReviewModal = function() {
            // Prefer the client-side review if available, otherwise use serverUserReview
            let review = window.userReview || window.serverUserReview || null;
            if (!review) {
                alert('No review found');
                return;
            }

            // Render stars
            const starsEl = document.getElementById('viewReviewStars');
            if (starsEl) {
                let html = '';
                const starCount = parseInt(review.star) || 0;
                for (let i = 1; i <= 5; i++) {
                    if (i <= starCount) html += '<span style="color:#ffc107; font-size:26px;">★</span>';
                    else html += '<span style="color:#e0e0e0; font-size:26px;">★</span>';
                }
                starsEl.innerHTML = html;
            }

            // Meta (date)
            const metaEl = document.getElementById('viewReviewMeta');
            if (metaEl) {
                const d = review.write_on ? new Date(review.write_on) : new Date();
                metaEl.textContent = 'Submitted on ' + d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            }

            // Review text
            const textEl = document.getElementById('viewReviewText');
            if (textEl) textEl.textContent = review.review || '-';

            const modal = new bootstrap.Modal(document.getElementById('viewReviewModal'));
            modal.show();
        }

        // Show review modal on page load only when internship is marked complete (server-side)
        window.addEventListener('load', function() {
            const reviewSubmitted = localStorage.getItem('internshipReviewSubmitted');

            // Server-provided flag: 1 means complete, otherwise not complete
            const internshipCompleteFlag = @json($internship->complete_status ?? 0);
            const shouldShowModal = parseInt(internshipCompleteFlag) === 1;

            if (shouldShowModal && !reviewSubmitted) {
                // Small delay for better UX, then open and populate modal
                setTimeout(function() {
                    openReviewModal();
                }, 1000);
            }
        });


        console.log('My Internship Details Page Loaded');
    </script>
@endpush
