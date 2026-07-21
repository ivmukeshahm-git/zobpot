<style>
    .Interview-round-box {
        border: 1px solid #d9d9d9;
        padding: 10px;
        border-radius: 6px;
        background: #eee;
        position: relative;
        cursor: pointer;
    }
</style>

<div class="row display-list">
    <div class="row mb-20">
        <div class="col-lg-9 col-md-12">
            <h3 class="mb-0">{{ $jobData->job_title }}</h3>
            {{-- @dd($jobData); --}}
            <div class="mt-1 mb-15"><span class="card-briefcase">{{ $jobData->job_type_name }}</span><span
                    class="card-time">{{ \Carbon\Carbon::parse($jobData->datetime)->diffForHumans() }}</span>
            </div>
        </div>
        <div class="col-lg-3 text-right">
                                                <a class="btn btn-preview-icon btn-apply btn-apply-big"
                                                    style="padding: 14px 30px 14px 30px;" href="javascript:void(0);"
                                                    onclick="BackJobList()"><i class="fa fa-long-arrow-left"></i>&nbsp;
                                                    Back</a>
                                            </div>
        <div class="col-lg-12 col-md-12 text-lg-end" style="align-content: center;text-align:right;">
            <a href="{{ asset('storage/resumes/'.$jobData->file_nm) }}" download class="badge bg-secondary"
                style="padding: 10px 31px;font-size: 14px;"><i class="fa fa-file-text"></i>&nbsp; View Resume</a>

            @php
                $statusBadge = [
                    0 => ['label' => 'Pending', 'class' => 'bg-warning'],
                    1 => ['label' => 'Selected', 'class' => 'bg-success'],
                    2 => ['label' => 'Rejected', 'class' => 'bg-danger'],
                    3 => ['label' => 'Shortlisted', 'class' => 'bg-primary'],
                    4 => ['label' => 'Schedule Interview', 'class' => 'bg-warning'],
                ];

                $status = $statusBadge[$jobData->apply_status] ?? ['label' => 'Unknown', 'class' => 'bg-secondary'];
            @endphp

            <span class="badge {{ $status['class'] }}" style="padding: 10px 31px; font-size: 14px;">
                {{ $status['label'] }}
            </span>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            @php
                $TotalRoundCwt = 0;
                $CompleteRoundCwt = 0;
                $MessageStatus = 0;

                $hasScheduledButIncomplete = false;
                $hasUnscheduledRound = false;
            @endphp
            @foreach ($JobRoundComplete as $row)
                @php
                    $TotalRoundCwt++;

                    if ($row->status == 1) {
                        $CompleteRoundCwt++;
                    }

                    if (!$row->interview_datetime) {
                        $hasUnscheduledRound = true;
                    }

                    if ($row->status == 0 && $row->interview_datetime) {
                        $hasScheduledButIncomplete = true;
                    }
                @endphp
                @if ($row->interview_datetime)
                    <div class="job-overview position-relative mb-4 border rounded p-3">

                        @if ($row->status == 1)
                            <div class="position-absolute"
                                style="top: 25px;right: 15px;border: 1px solid #198754;font-size: 24px;border-radius: 12px;padding: 4px 16px;background: #19875403;">
                                <i class="fa fa-check-circle text-success" style="font-size: 20px;"></i> <b
                                    style="font-size: 18px;font-weight: 700;color:#198754;">Complete</b>
                            </div>
                        @elseif($row->status == 2)
                            <div class="position-absolute"
                                style="top: 25px;right: 15px;border: 1px solid #dc3746;font-size: 24px;border-radius: 12px;padding: 4px 16px;background: #dc354505;">
                                <i class="fa fa-times-circle text-danger" style="font-size: 20px;"></i> <b
                                    style="font-size: 18px;font-weight: 700;color:#dc3545;">Rejected</b>
                            </div>
                        @else
                            <div class="position-absolute"
                                style="top: 25px;right: 15px;border: 1px solid #ffc107;font-size: 24px;border-radius: 12px;padding: 4px 16px;background: #ffc1071a;">
                                <i class="fa fa-hourglass-half text-warning" style="font-size: 20px;"></i> <b
                                    style="font-size: 18px;font-weight: 700;color:#ffc107;">Pedning</b>
                            </div>
                        @endif


                        {{-- Header & Toggle Button --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Round #{{ $loop->iteration }} - {{ $row->round_name }}</h5>
                        </div>

                        <div class="mt-3">
                            <div class="row mb-20">
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="job-reject-box">
                                        <label>Interview Round Description</label>
                                        <p class="mb-0">{{ $row->round_desc }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 d-flex">
                                    <div class="sidebar-icon-item">
                                        <img style="max-width: 17px;" src="{{ asset('assets/imgs/calendar.png') }}"
                                            alt="jobBox">
                                    </div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description industry-icon mb-10">Interview
                                            Date/Time</span>
                                        <strong class="small-heading">{{ $row->interview_datetime }}</strong>
                                    </div>
                                </div>

                                <div class="col-md-6 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item">
                                        <img style="max-width: 17px;" src="{{ asset('assets/imgs/telephone.png') }}"
                                            alt="jobBox">
                                    </div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description joblevel-icon mb-10">HR Contact No.</span>
                                        <strong class="small-heading">{{ $row->hr_contact_no }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-25">
                                <div class="col-md-6 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item">
                                        <img style="max-width: 17px;" src="{{ asset('assets/imgs/mail.png') }}"
                                            alt="jobBox">
                                    </div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description jobtype-icon mb-10">HR Email</span>
                                        <strong class="small-heading">{{ $row->hr_email }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-25">
                                <div class="col-md-12 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item">
                                        <img src="{{ asset('assets/imgs/page/job-single/location.svg') }}"
                                            alt="jobBox">
                                    </div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Interview Location</span>
                                        <strong class="small-heading">{{ $row->interview_address }}</strong>
                                    </div>
                                </div>
                            </div>

                            @if ($row->remarks && $row->status == 1)
                                <div class="row mt-10">
                                    <div class="col-lg-12 col-md-12 col-12 mb-3">
                                        <div class="job-reject-box">
                                            <label>Remarks</label>
                                            <p>{{ $row->remarks }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        @if ($hasUnscheduledRound && !$hasScheduledButIncomplete && $CompleteRoundCwt < $TotalRoundCwt)
            <div class="col-lg-12">
                <h5 class="text-center mb-0" style="color: green;">
                    The interview is scheduled to begin shortly. Please stay connected with us.
                </h5>
                <p class="text-center text-muted" style="font-weight: 600;">
                    There are {{ $TotalRoundCwt }} rounds for this job interview.
                    You have completed {{ $CompleteRoundCwt }} round(s).
                    {{ $TotalRoundCwt - $CompleteRoundCwt }} round(s) are still pending and will be scheduled
                    shortly.
                </p>
            </div>
        @endif



        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="job-overview">
                <h5 class="border-bottom pb-15 mb-30">Employment Information</h5>
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="sidebar-icon-item"><img
                                src="{{ asset('assets/imgs/page/job-single/industry.svg') }}" alt="jobBox">
                        </div>
                        <div class="sidebar-text-info ml-10"><span
                                class="text-description industry-icon mb-10">Industry</span><strong
                                class="small-heading"> {{ $jobData->category_nm }} </strong></div>
                    </div>
                    <div class="col-md-6 d-flex mt-sm-15">
                        <div class="sidebar-icon-item"><img
                                src="{{ asset('assets/imgs/page/job-single/job-level.svg') }}" alt="jobBox">
                        </div>
                        <div class="sidebar-text-info ml-10"><span class="text-description joblevel-icon mb-10">Job
                                level</span><strong class="small-heading">{{ $jobData->job_level_name }}</strong>
                        </div>
                    </div>
                </div>
                <div class="row mt-25">
                    {{-- <div class="col-md-6 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><img src="assets/imgs/page/job-single/salary.svg"
                                            alt="jobBox"></div>
                                    <div class="sidebar-text-info ml-10"><span
                                            class="text-description salary-icon mb-10">Salary</span><strong
                                            class="small-heading">₹ 300000 - ₹ 500000</strong></div>
                                </div> --}}
                    <div class="col-md-6 d-flex mt-sm-15">
                        <div class="sidebar-icon-item"><img
                                src="{{ asset('assets/imgs/page/job-single/job-type.svg') }}" alt="jobBox">
                        </div>
                        <div class="sidebar-text-info ml-10"><span class="text-description jobtype-icon mb-10">Job
                                type</span><strong class="small-heading">{{ $jobData->job_type_name }}</strong></div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="sidebar-icon-item"><img
                                src="{{ asset('assets/imgs/page/job-single/experience.svg') }}" alt="jobBox">
                        </div>
                        <div class="sidebar-text-info ml-10"><span
                                class="text-description experience-icon mb-10">Experience</span><strong
                                class="small-heading">{{ $jobData->experience_name }}</strong></div>
                    </div>
                </div>
                <div class="row mt-25">
                    <div class="col-md-6 d-flex mt-sm-15">
                        <div class="sidebar-icon-item"><img
                                src="{{ asset('assets/imgs/page/job-single/updated.svg') }}" alt="jobBox">
                        </div>
                        <div class="sidebar-text-info ml-10"><span class="text-description jobtype-icon mb-10">Post
                                On</span><strong
                                class="small-heading">{{ \Carbon\Carbon::parse($jobData->datetime)->format('d F Y') }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex mt-sm-15">
                        <div class="sidebar-icon-item"><img
                                src="{{ asset('assets/imgs/page/job-single/opening.png') }}" style="width: 20px;" alt="jobBox">
                        </div>
                        <div class="sidebar-text-info ml-10"><span
                                class="text-description mb-10">Openings</span><strong
                                class="small-heading">{{ $jobData->number_of_openings }}</strong></div>
                    </div>
                </div>

                <div class="row mt-25">
                    <div class="col-md-6 d-flex mt-sm-15">
                        <div class="sidebar-icon-item"><img
                                src="{{ asset('assets/imgs/page/job-single/qualification.png') }}" style="width: 20px;" alt="jobbox">
                        </div>
                        <div class="sidebar-text-info ml-10"><span
                                class="text-description jobtype-icon mb-10">Qualification</span><strong
                                class="small-heading">{{ $jobData->qualification_nm }}</strong></div>
                    </div>
                    <div class="col-md-6 d-flex mt-sm-15">
                        <div class="sidebar-icon-item"><img
                                src="{{ asset('assets/imgs/page/job-single/work-type.png') }}" style="width: 20px;" alt="jobBox">
                        </div>
                        <div class="sidebar-text-info ml-10"><span class="text-description mb-10">Work
                                Type</span><strong class="small-heading">{{ $jobData->work_type_name }}</strong></div>
                    </div>
                </div>

                <div class="row mt-25">
                    <div class="col-md-12 d-flex mt-sm-15">
                        <div class="sidebar-icon-item"><img
                                src="{{ asset('assets/imgs/page/job-single/location.svg') }}" alt="jobBox">
                        </div>
                        <div class="sidebar-text-info ml-10"><span
                                class="text-description mb-10">Location</span><strong
                                class="small-heading">
                                @if ($Setting->ShowCompanyDetails == 1 && $user && !is_null($user->active_plan_id) && $user->active_plan_id != 0)
                                    {{ $jobData->company_address }}
                                @else
                                    {{ $jobData->area_nm }}, {{ $jobData->city_nm }},
                                    {{ $jobData->state_name }}
                                @endif</strong></div>
                    </div>
                </div>

                <div class="row mt-25">
                    <div class="col-md-12 d-flex mt-sm-15">
                        <div class="sidebar-icon-item"><img
                                src="{{ asset('assets/imgs/page/job-single/skill.png') }}" style="width: 20px;" alt="jobBox">
                        </div>
                        <div class="sidebar-text-info ml-10"><span class="text-description mb-10">Skill</span><strong
                                class="small-heading">
                                @php
                                    $skills = json_decode($jobData->skill_id, true);
                                @endphp

                                @foreach ($skills as $row)
                                    <a class="btn btn-grey-small" style="font-weight: 600;">{{ $row }}</a>
                                @endforeach
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
            

        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="content-single">
                <h4>Welcome to {{ $jobData->user_name }}</h4>
                <p>{{ $jobData->job_description }}</p>
            </div>
        </div>

    </div>
</div>
@push('script')


@endpush