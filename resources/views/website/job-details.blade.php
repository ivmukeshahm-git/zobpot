@if(!Auth::check())
    <script>
        window.location.href = "{{ route('login') }}";
    </script>
@endif

@push('css')
    <style>
        .job-plan-limit-msg {
            padding: 10px 12px;
            font-size: 13px;
            line-height: 1.45;
            color: #842029;
            background: #f8d7da;
            border: 1px solid #f5c2c7;
            border-radius: 8px;
            max-width: 360px;
            display: inline-block;
        }

        .premium-sidebar {
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    overflow: hidden;
}

/* TITLE BAR */
.premium-title {
    background: linear-gradient(90deg, #242a62, #242a62);
    color: #fff;
    padding: 14px 18px;
    font-size: 16px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* CONTENT */
.premium-content {
    padding: 18px;
}

/* ROW */
.info-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px dashed #eee;
}

.info-row:last-child {
    border-bottom: none;
}

/* LABEL */
.info-label {
    /* font-size: 13px; */
    color: #6c757d;
    /* min-width: 120px; */
    display: flex;
    align-items: center;
    gap: 8px;
}

.info-label i {
    color: #242a62;
    /* font-size: 14px; */
}

/* VALUE */
.info-value {
    font-size: 14px;
    font-weight: 600;
    color: #05264E;
    text-align: right;
    word-break: break-word;
}

        .select-resume {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 6px;
            font-size: 15px;
            border: 1px solid #e9ecef;
            padding: 10px;
            background: #e9ecef;
            cursor: pointer;
        }

        .select-resume p {
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #333;
        }

        .select-resume a {
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
        }

        .select-resume a:hover {
            text-decoration: underline;
        }

        .upload-different-resume input[type="checkbox"] {
            width: 16px;
            height: 16px;
        }

        .hidden {
            display: none;
        }

        .resume-option.active {
            border: 2px solid #007bff;
            background-color: #f0f8ff;
            border-radius: 5px;
        }
       .cb-container .checkmark:after {
    content: "✔";
    position: absolute;
    color: #fff;
    font-size: 14px;
    display: none !important;  /* default hide */
    justify-content: center;
}
.cb-container input:checked ~ .checkmark:after {
    display: flex !important; /* show only after checked */
}

    </style>
@endpush
@php
    $jobURL = urlencode(url()->current());
@endphp

@extends('website.layout.layout')
@section('website-content')
    <script>
        page_active_id = "Job";
    </script>


    <main class="main">
        <section class="section-box-2">
            <div class="container">

                <div class="border-bottom pt-10 pb-10"></div>
            </div>
        </section>
        <section class="section-box mt-50">
            <div class="container">

                <div class="row mb-20">
                    <div class="col-lg-8 col-md-12">
                        <h3>{{ $jobData->job_title ?? "" }} / {{ $jobData->sub_category_nm ?? "" }}</h3>
                        <div class="mt-3 mb-15"><span class="card-briefcase">{{ $jobData->job_type_name ?? "" }}</span><span
                                class="card-time">{{ \Carbon\Carbon::parse($jobData->datetime)->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 text-lg-end">
                        @if (Auth::check())
                            @if ($user->profile_type == 'Employee')
                                @if ($JobApplyHistory)
                                    <div class="btn btn-apply-icon btn-apply btn-apply-big hover-up">Already Applied</div>
                                @else
                                    @if ($user && $user->active_plan_id == 0)
                                        <a class="btn btn-apply-icon btn-apply btn-apply-big hover-up"
                                            href="{{ route('pricing', ['user_id' => $user->id]) }}"><i class="fa fa-lock"></i> Upgrade Plan</a>
                                        <p class="job-plan-limit-msg mt-2 mb-0 text-start text-lg-end">
                                            {{ $jobApplyLimitCheck['message'] ?? 'Your plan has expired or is not active. Please upgrade your plan to continue.' }}
                                        </p>
                                    @elseif(empty($canApplyJob) || empty($jobApplyLimitCheck['allowed']))
                                        <a class="btn btn-apply-icon btn-apply btn-apply-big hover-up" href="javascript:void(0);"
                                            onclick="showCandidatePlanLimitAlert(@json($jobApplyLimitCheck['message'] ?? 'Your plan job apply limit has been reached.'), @json($jobApplyLimitCheck['upgrade_url'] ?? route('pricing', ['user_id' => $user->id])))">
                                            <i class="fa fa-lock"></i> Upgrade Plan
                                        </a>
                                        <p class="job-plan-limit-msg mt-2 mb-0 text-start text-lg-end">
                                            {{ $jobApplyLimitCheck['message'] ?? 'Your plan job apply limit has been reached. Please upgrade your plan to continue.' }}
                                            @if(isset($jobApplyLimitCheck['limit']) && $jobApplyLimitCheck['limit'] !== null)
                                                <span class="d-block fw-semibold">(Used {{ (int) ($jobApplyLimitCheck['used'] ?? 0) }}/{{ (int) $jobApplyLimitCheck['limit'] }})</span>
                                            @endif
                                        </p>
                                    @else
                                        <div class="btn btn-apply-icon btn-apply btn-apply-big hover-up"
                                            data-bs-toggle="modal" data-bs-target="#ModalApplyJobForm">Apply now</div>
                                    @endif
                                @endif
                            @endif
                        @else
                            <a class="btn btn-apply-icon btn-apply btn-apply-big hover-up" href="{{ route('login') }}">Apply
                                now</a>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-12">
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
                                    <div class="sidebar-text-info ml-10"><span
                                            class="text-description joblevel-icon mb-10">Job level</span><strong
                                            class="small-heading">{{ $jobData->job_level_name }}</strong></div>
                                </div>
                            </div>


                            <div class="row mt-25">
                                <div class="col-md-6 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><img
                                            src="{{ asset('assets/imgs/page/job-single/job-type.svg') }}" alt="jobBox">
                                    </div>
                                    <div class="sidebar-text-info ml-10"><span
                                            class="text-description jobtype-icon mb-10">Job type</span><strong
                                            class="small-heading">{{ $jobData->job_type_name }}</strong></div>
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
                                    <div class="sidebar-text-info ml-10"><span
                                            class="text-description jobtype-icon mb-10">Post On</span><strong
                                            class="small-heading">{{ \Carbon\Carbon::parse($jobData->datetime)->format('d F Y') }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><img
                                            src="{{ asset('assets/imgs/page/job-single/opening.png') }}"
                                            style="max-width: 18px;" alt="jobBox">
                                    </div>
                                    <div class="sidebar-text-info ml-10"><span
                                            class="text-description mb-10">Vacancy</span><strong
                                            class="small-heading">{{ $jobData->number_of_openings }}</strong></div>
                                </div>
                            </div>

                            <div class="row mt-25">
                                <div class="col-md-6 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><img
                                            src="{{ asset('assets/imgs/page/job-single/qualification.png') }}"
                                            style="max-width: 18px;" alt="jobBox">
                                    </div>
                                    <div class="sidebar-text-info ml-10"><span
                                            class="text-description jobtype-icon mb-10">Qualification</span><strong
                                            class="small-heading">{{ $jobData->qualification_nm }}</strong></div>
                                </div>
                                <div class="col-md-6 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><img
                                            src="{{ asset('assets/imgs/page/job-single/work-type.png') }}"
                                            style="max-width: 18px;" alt="jobBox">
                                    </div>
                                    <div class="sidebar-text-info ml-10"><span class="text-description mb-10">Work
                                            Type</span><strong
                                            class="small-heading">{{ $jobData->work_type_name }}</strong></div>
                                </div>
                            </div>
                            
                            
                            @if($jobData->job_timing || $jobData->age)
                        <div class="row mt-25">
                            @if($jobData->job_timing)
                            <div class="col-md-6 d-flex mt-sm-15">
                                <div class="sidebar-icon-item"><img
                                        src="{{ asset('assets/imgs/page/job-single/job-timing.png') }}"
                                        style="max-width: 18px;" alt="jobBox">
                                </div>
                                <div class="sidebar-text-info ml-10"><span
                                        class="text-description jobtype-icon mb-10">Job Timing</span><strong
                                        class="small-heading">{{ $jobData->job_timing }}</strong></div>
                            </div>

                            @endif

                            @if($jobData->age)
                            <div class="col-md-6 d-flex mt-sm-15">
                                <div class="sidebar-icon-item"><img
                                        src="{{ asset('assets/imgs/page/job-single/age.png') }}"
                                        style="max-width: 18px;" alt="jobBox">
                                </div>
                                <div class="sidebar-text-info ml-10"><span class="text-description mb-10">Age</span><strong
                                        class="small-heading">{{ $jobData->age }}</strong></div>
                            </div>
                            @endif
                        </div>
                        @endif


                            <div class="row mt-25">
                                <div class="col-md-6 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><img
                                            src="{{ asset('assets/imgs/page/job-single/budget.png') }}"
                                            style="max-width: 18px;" alt="jobBox">
                                    </div>
                                    <div class="sidebar-text-info ml-10"><span
                                            class="text-description jobtype-icon mb-10">Salary Budget</span><strong
                                            class="small-heading">{{ $jobData->salary_budget }}</strong></div>
                                </div>
                                {{-- @dd($jobData->gender) --}}

                                @if($jobData->gender)
                                <div class="col-md-6 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><img
                                            src="{{ asset('assets/imgs/page/job-single/gender.png') }}"
                                            style="max-width: 18px;" alt="jobBox">
                                    </div>
                                    <div class="sidebar-text-info ml-10"><span class="text-description mb-10">Required Gender</span><strong
                                            class="small-heading">{{ $jobData->gender }}</strong></div>
                                </div>
                                @endif
                            </div>

                            @if ($Setting->ShowCompanyDetails == 1 && ($user && !is_null($user->active_plan_id) && $user->active_plan_id != 0))
                                <div class="row mt-25">
                                    <div class="col-md-12 d-flex mt-sm-15">
                                        <div class="sidebar-icon-item"><img
                                                src="{{ asset('assets/imgs/page/job-single/location.svg') }}"
                                                alt="jobBox">
                                        </div>
                                        <div class="sidebar-text-info ml-10"><span
                                                class="text-description mb-10">Location</span><strong
                                                class="small-heading">{{ $jobData->company_address }}</strong></div>
                                    </div>
                                </div>
                            @endif

                            <div class="row mt-25">
                                <div class="col-md-12 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><img
                                            src="{{ asset('assets/imgs/page/job-single/skill.png') }}"
                                            style="max-width: 18px;" alt="jobBox">
                                    </div>
                                    <div class="sidebar-text-info ml-10"><span
                                            class="text-description mb-10">Skill</span><strong class="small-heading">
                                            @php
                                                $Skill = [];

                                                if (!empty($jobData->skill_id)) {
                                                    $decoded = json_decode($jobData->skill_id, true);
                                                    $Skill = is_array($decoded) ? $decoded : [];
                                                }
                                            @endphp

                                            @foreach ($Skill as $row)
                                                <a class="btn btn-grey-small"
                                                    style="font-weight: 600;">{{ $row }}</a>
                                            @endforeach
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content-single">
                            <h4>Welcome to {{ $jobData->user_name }}</h4>
                            <p>{!! $jobData->job_description !!}</p>
                        </div>
                        <div class="single-apply-jobs">
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <form id="save-job-form" onsubmit="return false;">
                                        @if (Auth::check())
                                            {{-- Apply Now Section --}}
                                            @if ($user->profile_type == 'Employee')
                                                @if ($JobApplyHistory)
                                                    <a class="btn btn-default mr-15" href="javascript:void(0);">Already
                                                        Applied</a>
                                                @else
                                                    @if ($user->active_plan_id == 0)
                                                        <a class="btn btn-default mr-15"
                                                            href="{{ route('pricing', ['user_id' => $user->id]) }}"><i class="fa fa-lock"></i> Upgrade Plan</a>
                                                        <p class="job-plan-limit-msg mt-2 mb-0">
                                                            {{ $jobApplyLimitCheck['message'] ?? 'Your plan has expired or is not active. Please upgrade your plan to continue.' }}
                                                        </p>
                                                    @elseif(empty($canApplyJob) || empty($jobApplyLimitCheck['allowed']))
                                                        <a class="btn btn-default mr-15" href="javascript:void(0);"
                                                            onclick="showCandidatePlanLimitAlert(@json($jobApplyLimitCheck['message'] ?? 'Your plan job apply limit has been reached.'), @json($jobApplyLimitCheck['upgrade_url'] ?? route('pricing', ['user_id' => $user->id])))">
                                                            <i class="fa fa-lock"></i> Upgrade Plan
                                                        </a>
                                                        <p class="job-plan-limit-msg mt-2 mb-0">
                                                            {{ $jobApplyLimitCheck['message'] ?? 'Your plan job apply limit has been reached. Please upgrade your plan to continue.' }}
                                                            @if(isset($jobApplyLimitCheck['limit']) && $jobApplyLimitCheck['limit'] !== null)
                                                                <span class="d-block fw-semibold">(Used {{ (int) ($jobApplyLimitCheck['used'] ?? 0) }}/{{ (int) $jobApplyLimitCheck['limit'] }})</span>
                                                            @endif
                                                        </p>
                                                    @else
                                                        <a class="btn btn-default mr-15" href="javascript:void(0);"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#ModalApplyJobForm">Apply now</a>
                                                    @endif
                                                @endif

                                                <button class="btn btn-border" type="submit"
                                                    @if ($SaveJobData) disabled @endif>
                                                    {{ $SaveJobData ? 'Job Saved' : 'Save Job' }}
                                                </button>
                                            @endif

                                            {{-- Hidden Fields + Save Job Button --}}
                                            <input type="hidden" id="user_id" name="user_id"
                                                value="{{ $user->id }}">
                                            <input type="hidden" id="job_id" name="job_id"
                                                value="{{ $jobData->job_id }}">
                                        @else
                                            {{-- For Guests --}}
                                            <a class="btn btn-default mr-15" href="{{ route('login') }}">Apply now</a>
                                            <a class="btn btn-border" href="{{ route('login') }}">Save job</a>
                                        @endif

                                    </form>
                                </div>
                                <!-- <div class="col-md-7 text-lg-end social-share">
                                    <h6 class="color-text-paragraph-2 d-inline-block d-baseline mr-10">Share this</h6>
                                    <a
                                        class="mr-5 d-inline-block d-middle" href="https://www.facebook.com/share/1CSt4R5rv2/"><img alt="jobBox"
                                            src="{{ asset('assets/imgs/template/icons/share-fb.svg') }}"></a>
                                            <a
                                        class="mr-5 d-inline-block d-middle" href="https://twitter.com/zobpot"><img alt="jobBox"
                                            src="{{ asset('assets/imgs/template/icons/share-tw.svg') }}"></a>
                                            <a
                                        class="mr-5 d-inline-block d-middle" href="https://www.instagram.com//zobpot/"><img alt="jobBox"
                                            src="{{ asset('assets/imgs/template/icons/share-insta.svg') }}"></a>
                                            <a
                                        class="d-inline-block d-middle" href="https://wa.me/919512383123"><img alt="jobBox"
                                            src="{{ asset('assets/imgs/template/icons/share-whatsapp.svg') }}"></a>
                                </div> -->
                                <div class="col-md-7 text-lg-end social-share">
                                    <h6 class="color-text-paragraph-2 d-inline-block d-baseline mr-10">Share this</h6>

                                    <!-- Facebook -->
                                    <a class="mr-5 d-inline-block d-middle"
                                    href="https://www.facebook.com/sharer/sharer.php?u={{ $jobURL }}"
                                    target="_blank">
                                        <img alt="jobBox" src="{{ asset('assets/imgs/template/icons/share-fb.svg') }}">
                                    </a>

                                    <!-- Twitter / X -->
                                    <a class="mr-5 d-inline-block d-middle"
                                    href="https://twitter.com/intent/tweet?url={{ $jobURL }}"
                                    target="_blank">
                                        <img alt="jobBox" src="{{ asset('assets/imgs/template/icons/share-tw.svg') }}">
                                    </a>

                                    <!-- Instagram (no direct share link, so copy URL feature j hoy) -->
                                    <a class="mr-5 d-inline-block d-middle"
                                    href="javascript:void(0)" onclick="copyJobLink()">
                                        <img alt="jobBox" src="{{ asset('assets/imgs/template/icons/share-insta.svg') }}">
                                    </a>

                                    <!-- WhatsApp -->
                                    <a class="d-inline-block d-middle"
                                    href="https://wa.me/?text={{ $jobURL }}"
                                    target="_blank">
                                        <img alt="jobBox" src="{{ asset('assets/imgs/template/icons/share-whatsapp.svg') }}">
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-12 pl-40 pl-lg-15 mt-lg-30">
                        @if ($Setting->ShowCompanyDetails == 1 && ($user && !is_null($user->active_plan_id) && $user->active_plan_id != 0))
                            {{-- <div class="sidebar-border">
                                <div class="sidebar-heading">
                                    <div class="avatar-sidebar">

                                        <div class="sidebar-info p-0"><span
                                                class="sidebar-company">{{ $jobData->user_name }}</span><span
                                                class="card-location">{{ $jobData->city_nm }},
                                                {{ $jobData->state_name }}</span></div>
                                    </div>
                                </div>
                                <div class="sidebar-list-job">
                                    <div class="box-map">
                                        @php
                                            $address = urlencode($jobData->company_address);
                                        @endphp
                                    </div>
                                    <ul class="ul-disc">
                                        <li>{{ $jobData->company_address }}</li>
                                        <li>Phone: {{ $jobData->hr_contact_no }}</li>
                                        <li>Email: {{ $jobData->hr_email }}</li>
                                        <li>Company Website : {{ $jobData->company_website }}</li>
                                    </ul>
                                </div>
                            </div> --}}
                            <div class="sidebar-border premium-sidebar">

    <!-- TITLE -->
    <div class="premium-title">
        <i class="fa fa-building"></i>
        Company Information
    </div>

    <!-- CONTENT -->
    <div class="premium-content">

        <div class="info-row">
            <span class="info-label">
                <i class="fa fa-user-circle"></i> Company
            </span>
            <span class="info-value">
                {{ $jobData->user_name ?? '-' }}
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">
                <i class="fa fa-map-marker"></i> Corporate Address
            </span>
            <span class="info-value">
                {{ $jobData->city_nm && $jobData->state_name ? $jobData->city_nm . ', ' . $jobData->state_name : '-' }}
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">
                <i class="fa fa-map"></i> Plant Address
            </span>
            <span class="info-value">
                {{ $jobData->company_address ?? '-' }}
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">
                <i class="fa fa-phone"></i> Phone
            </span>
            <span class="info-value">
                {{ $jobData->hr_contact_no ?? '-' }}
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">
                <i class="fa fa-envelope"></i> Email
            </span>
            <span class="info-value">
                {{ $jobData->hr_email ?? '-' }}
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">
                <i class="fa fa-globe"></i> Website
            </span>
            <span class="info-value">
                {{ $jobData->company_website ?? '-' }}
            </span>
        </div>

    </div>
</div>

                        @endif
                        @if ($adBanner)
                            <div class="sidebar-border-bg bg-right" style="padding: 3px!important;">
                                <a href="{{ $adBanner->ad_link }}" target="_blank">
                                    <img src="{{ asset('uploads/ad_banner_img/' . $adBanner->img_nm) }}" alt="img">
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>



    <div class="modal fade" id="ModalApplyJobForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content apply-job-form">
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body pl-30 pr-30 pt-50">
                    <div class="text-center">
                        <p class="font-sm text-brand-2">Job Application </p>
                        <h2 class="mt-10 mb-5 text-brand-1 text-capitalize">Start your career today</h2>
                        <p class="font-sm text-muted mb-30">Please fill in your information and send it to the employer.
                        </p>
                    </div>

                    <form id="job-apply" class="login-register text-start mt-20 pb-30" onsubmit="return false;">
                        {{-- @php
                            $resumePath = $user->resume_nm ?? '';
                            $cleanPath = str_replace('resumes/', '', $resumePath);
                        @endphp --}}


                        <div class="form-group" id="resumeUploadBlock"
                            style="display: {{ ($user && $Resumes && count($Resumes)) ? 'none' : 'block' }};">
                            <label class="form-label" for="resume">Upload Resume <span
                                    class="color-red">*</span></label>
                            <input class="form-control" id="resume" name="resume" type="file"
                                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                        </div>

                        <div id="existingResumeBlock">
                            @if ($user && $Resumes)
                                @foreach ($Resumes as $index => $row)
                                    @php
                                        $resumePath = $row->file_nm ?? '';
                                        $cleanPath = str_replace('resumes/', '', $resumePath);
                                    @endphp

                                    <div class="select-resume mb-10 d-flex align-items-center resume-option {{ $index === 0 ? 'active' : '' }}"
                                        data-id="{{ $row->id }}">
                                        <input type="radio" name="selected_resume" class="d-none"
                                            value="{{ $row->resume_id }}" {{ $index === 0 ? 'checked' : '' }} />

                                        <div class="w-100 d-flex justify-content-between align-items-center">
                                            <p class="mb-1"><i class="fa fa-file-text" aria-hidden="true"></i>
                                                {{ $cleanPath }}</p>
                                            <a href="{{ asset('storage/resumes/' . $resumePath) }}" target="_blank">View</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>


                        <div class="upload-different-resume mb-20">
                            <input type="checkbox" id="uploadNewResume" {{ ($user && $Resumes && count($Resumes) > 0) ? '' : 'checked' }}>
                            <label for="uploadNewResume">Upload Different Resume</label>
                        </div>


                        <input type="hidden" id="upload_type" name="upload_type"
                            value="{{ ($user && $Resumes && count($Resumes) > 0) ? 'Old' : 'New' }}">

                        <input type="hidden" id="user_id" name="user_id" value="{{ $user ? $user->id : '' }}">

                        <div class="login_footer form-group d-flex justify-content-between">
                            <label class="cb-container">
                                <input type="checkbox" class="form-check" id="terms_policy" name="terms_policy"><span
                                    class="text-small" id="terms_policy_text">Agree our terms and policy</span><span
                                    class="checkmark"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="job_id" name="job_id" value="{{ $jobData->job_id }}">
                            <button class="btn btn-default hover-up w-100" type="submit" name="login" id="apply-job-btn">Apply
                                Job</button>
                        </div>
                        <div class="text-muted text-center">Do you need support? <a href="page-contact">Contact Us</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        function copyJobLink() {
    navigator.clipboard.writeText(window.location.href);
    Swal.fire({
        icon: 'success',
        title: 'Link Copied!',
        text: 'Paste it anywhere to share.',
        timer: 1200,
        showConfirmButton: false
    });
}

        document.querySelectorAll('.resume-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove active from all
                document.querySelectorAll('.resume-option').forEach(opt => {
                    opt.classList.remove('active');
                    opt.querySelector('input[type="radio"]').checked = false;
                });

                // Add active to clicked
                this.classList.add('active');
                this.querySelector('input[type="radio"]').checked = true;
            });
        });



        document.addEventListener("DOMContentLoaded", function() {
            const checkbox = document.getElementById('uploadNewResume');
            const resumeUploadBlock = document.getElementById('resumeUploadBlock');
            const existingResumeBlock = document.getElementById('existingResumeBlock');

            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    resumeUploadBlock.style.display = 'block';
                    if (existingResumeBlock) existingResumeBlock.style.display = 'none';

                    $("#upload_type").val('New')
                } else {
                    resumeUploadBlock.style.display = 'none';
                    if (existingResumeBlock) existingResumeBlock.style.display = 'block';
                    $("#upload_type").val('Old')
                }
            });

            // Trigger on load in case of edit mode with checkbox pre-checked
            if (checkbox.checked) {
                checkbox.dispatchEvent(new Event('change'));
            }
        });


        // let validator = $("#job-apply").validate({
        //     rules: {
        //         resume: {
        //             required: true,
        //             extension: "jpg|jpeg|png|pdf|doc|docx" // Optional: restrict file types
        //         }
        //     },
        //     messages: {
        //         resume: {
        //             required: "Please upload your resume",
        //             extension: "Allowed file types: jpg, jpeg, png, pdf, doc, docx"
        //         }
        //     },
        //     errorElement: "div",

        //     highlight: function(element) {
        //         $(element).addClass("is-invalid").removeClass("is-valid");
        //     },
        //     unhighlight: function(element) {
        //         $(element).removeClass("is-invalid").addClass("is-valid");
        //     }
        // });


        $("#job-apply").submit(function(e) {
            e.preventDefault();

            let form = $(this);
            let submitBtn = $('#apply-job-btn');

            if (submitBtn.prop('disabled')) {
                return false;
            }

            if (!form.valid()) {
                return;
            }

            if (!$('#terms_policy').is(':checked')) {
                $('#terms_policy').focus();
                $('#terms_policy_text').css('color', 'red');
                return false;
            }

            let originalBtnText = submitBtn.html();
            submitBtn.prop('disabled', true).html('Please wait...');

            let formData = new FormData(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('apply-job') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 1) {
                        $("#ModalApplyJobForm").modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                        if (response.upgrade_url) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Upgrade Plan Required',
                                text: response.message,
                                showCancelButton: true,
                                confirmButtonText: 'Upgrade Plan',
                                cancelButtonText: 'Close'
                            }).then(function(result) {
                                if (result.isConfirmed) {
                                    window.location.href = response.upgrade_url;
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message,
                            });
                        }
                    }
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html(originalBtnText);
                    var res = xhr.responseJSON || {};
                    var msg = res.message || 'Something went wrong. Please try again.';
                    if (res.upgrade_url) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Upgrade Plan Required',
                            text: msg,
                            showCancelButton: true,
                            confirmButtonText: 'Upgrade Plan',
                            cancelButtonText: 'Close'
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                window.location.href = res.upgrade_url;
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: msg,
                        });
                    }
                }
            });
        });

        function showCandidatePlanLimitAlert(message, upgradeUrl) {
            Swal.fire({
                icon: 'warning',
                title: 'Upgrade Plan Required',
                text: message || 'Your plan limit has been reached. Please upgrade your plan.',
                showCancelButton: true,
                confirmButtonText: 'Upgrade Plan',
                cancelButtonText: 'Close'
            }).then(function(result) {
                if (result.isConfirmed && upgradeUrl) {
                    window.location.href = upgradeUrl;
                }
            });
        }

        $('#ModalApplyJobForm').on('hidden.bs.modal', function() {
            $('#apply-job-btn').prop('disabled', false).html('Apply Job');
        });




        // ✅ Final submission with AJAX
        $("#save-job-form").submit(function(e) {
            e.preventDefault();

            if (!$("#save-job-form").valid()) {
                return;
            }

            let form = $(this);
            // let url = form.attr('action');
            let formData = form.serialize(); // Use FormData for file uploads

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            $.ajax({
                type: "POST",
                url: "{{ route('save-job-action') }}",
                data: formData,
                success: function(response) {
                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                         Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message,
                        });
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endpush
