@push('css')
<style>
/* ------------------------------ */
/* PREMIUM FORM DESIGN — ZOBPOT  */
/* ------------------------------ */

#job-form .form-group label {
    font-weight: 600;
    color: #242a62;
}

#job-form .form-control {
    border-radius: 10px;
    border: 1px solid #cfd0e4;
    padding: 10px 14px;
    transition: 0.2s ease;
}

#job-form .form-control:focus {
    border-color: #242a62;
    box-shadow: 0 0 6px rgba(36, 42, 98, 0.3);
}

/* ------------------------------ */
/* JOB TYPE SELECT — Skilled / UnSkilled */
/* ------------------------------ */
.job-type-select {
    border: 2px solid #d6d6e6;
    padding: 15px;
    border-radius: 16px;
    cursor: pointer;
    transition: 0.3s;
    background: #f8f8ff;
}

.job-type-select:hover {
    border-color: #242a62;
    background: #f0f0ff;
}

.job-type-select h4 {
    color: #242a62;
    font-weight: 700;
    margin: 0;
}

/* ACTIVE option */
.select-job {
    border-color: #242a62 !important;
    background: #e9e9ff !important;
    box-shadow: 0 0 8px rgba(36, 42, 98, 0.3);
}

/* ------------------------------ */
/* SKILL TAGS DESIGN */
/* ------------------------------ */
.box-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.box-tags .btn {
    background: #242a62 !important;
    color: #fff !important;
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: 0.3s;
}

.box-tags .btn:hover {
    background: #1b204f !important;
}

.box-tags .remove-skill {
    font-size: 12px;
    padding: 3px 6px;
    background: #ffffff30;
    border-radius: 50%;
    cursor: pointer;
    transition: 0.2s;
}

.box-tags .remove-skill:hover {
    background: #ffffff70;
}

/* ------------------------------ */
/* INTERVIEW ROUND DESIGN */
/* ------------------------------ */
#CompanyInterviewRow .branch-box {
    border: 1px solid #dcdcec;
    background: #f9f9ff;
    padding: 15px 20px;
    border-radius: 16px;
    transition: 0.3s;
}

#CompanyInterviewRow .branch-box:hover {
    border-color: #242a62;
    box-shadow: 0px 4px 12px rgba(36, 42, 98, 0.15);
}

#CompanyInterviewRow .form-label {
    font-weight: 600;
    color: #242a62;
}

/* Add button */
.add-row {
    background: #242a62 !important;
    border-radius: 50%;
    padding: 15px !important;
    color: white;
    transition: 0.2s ease;
}

.add-row:hover {
    transform: scale(1.05);
    background: #1b204f !important;
}

/* Remove button */
.remove-row {
    background: #cb0000 !important;
    border-radius: 50%;
    /* padding: 15px !important; */
    color: white;
    transition: 0.2s;
}

.remove-row:hover {
    background: #a10000 !important;
    transform: scale(1.05);
}

/* ------------------------------ */
/* SUBTLE CARD BORDER & SECTIONS */
/* ------------------------------ */
.form-contact {
    background: #ffffff;
    padding: 20px 25px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(36, 42, 98, 0.05);
}

.box-option {
    padding: 0 !important;
    background: none !important;
    box-shadow: none !important;
}

.menu-bar {
    background: #eee;
    padding: 7px;
    border-radius: 12px;
}

#Statesuggestions {
    display: none;
}

#Citysuggestions {
    display: none;
}

#Areasuggestions {
    display: none;
}

#Pincodesuggestions {
    display: none;
}
/* AREA SUGGEST BADGE DESIGN */
#JobAreaSuggestBox .badge-item {
    display: inline-block;
    background: #242a62;
    color: #fff;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    cursor: pointer;
    transition: 0.2s ease;
}

#JobAreaSuggestBox .badge-item:hover {
    background: #1b204f;
    transform: scale(1.05);
}
.suggestions{
    position:absolute;
    background:#fff;
    width:100%;
    border:1px solid #ddd;
    z-index:9999;
    max-height:200px;
    overflow-y:auto;
    display:none;
}
.suggestion-item{
    padding:8px;
    cursor:pointer;
}
.suggestion-item:hover{
    background:#f0f0f0;
}


.suggestions {
    top: 100%;
    left: 0;
    right: 0;
    border: 1px solid #ccc;
    background-color: #fff;
    z-index: 10;
    max-height: 200px;
    overflow-y: auto;
}

.suggestion-item {
    padding: 8px;
    cursor: pointer;
}

.suggestion-item:hover {
    background-color: #f0f0f0;
}
/* JOB TITLE — PREMIUM SUGGESTION DROPDOWN */
#jobTitleSuggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #cfd0e4;
    box-shadow: 0 4px 12px rgba(36, 42, 98, 0.15);
    z-index: 9999;
    max-height: 230px;
    overflow-y: auto;
    padding: 5px 0;
    display: none;
}

#jobTitleSuggestions .suggestion-item {
    padding: 10px 14px;
    font-size: 14px;
    color: #242a62;
    border-bottom: 1px solid #f1f1f7;
    cursor: pointer;
    transition: 0.15s ease;
}

#jobTitleSuggestions .suggestion-item:last-child {
    border-bottom: none;
}

/* Hover effect */
#jobTitleSuggestions .suggestion-item:hover {
    background: #e9e9ff;
    color: #242a62;
    padding-left: 20px;
}

/* Smooth scroll bar */
#jobTitleSuggestions::-webkit-scrollbar {
    width: 6px;
}

#jobTitleSuggestions::-webkit-scrollbar-thumb {
    background: #b5b5d6;
    border-radius: 10px;
}

#jobTitleSuggestions::-webkit-scrollbar-thumb:hover {
    background: #242a62;
}


#AboutAndSkillEdit {
    display: none;
}

.banner-hero.banner-image-single {
    padding: 20px 0px 20px 0px;
}

.banner-hero {
    padding: 0px 65px 0px 15px;
    position: relative;
    max-width: 1770px;
    margin: 0 auto;
}

.banner-hero.banner-image-single img {
    width: 100%;
    border-radius: 16px;
}

.btn-editor {
    background-image: url(../imgs/page/candidates/editor.svg);
    background-position: center;
    background-repeat: no-repeat;
    background-color: #242a62;
    position: absolute;
    bottom: 45px;
    right: 20px;
    height: 35px;
    width: 35px;
    border-radius: 50%;
}

.box-company-profile {
    max-width: 90%;
    display: table;
    table-layout: fixed;
    margin: auto;
    width: 100%;
    padding: 0px 0px 0px 0px;
    position: relative;
}

.image-compay {
    position: absolute;
    top: -80px;
    left: 0px;
}

.image-compay img {
    width: 100%;
    border-radius: 16px;
}

.btn-preview-icon {
    background-image: url(../imgs/page/candidates/preview.svg);
    background-position: 35px 14px;
    background-repeat: no-repeat;
    padding: 14px 30px 14px 55px;
    font-size: 16px;
    line-height: 24px;
    font-weight: 700;
    min-width: 180px;
}

.btn-apply-big {
    background-color: #242a62;
    color: #ffffff;
    padding: 8px 35px;
    border-radius: 4px;
}

.user-info-label {
    margin-bottom: 5px;
    font-size: 14px;
    color: #242a62;
    font-weight: 500;
}

.user-info-value {
    color: #707070;
    font-weight: 600;
}

#DetailsEditProfile {
    display: none;
}

.existing-file-preview .card:hover {
    border-color: #0d6efd;
    transition: border-color 0.3s ease;
}

.existing-file-preview img:hover,
.existing-file-preview .fa-file-pdf:hover,
.existing-file-preview .fa-file:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}
</style>
<style>
/* Select2 main box */
.select2-container--default .select2-selection--single {
    height: auto !important;
    min-height: 46px !important;
    border: 1px solid #E0E6F7 !important;
    border-radius: 4px !important;
    background-color: #ffffff !important;
    padding: 11px 15px 13px 15px !important;
    width: 100% !important;
    color: #A0ABB8 !important;
    display: flex !important;
    align-items: center !important;
    font-size: 14px !important;
    line-height: 22px !important;
}

/* Text inside */
.select2-container--default .select2-selection--single .select2-selection__rendered {
    padding-left: 0px !important;
    color: #A0ABB8 !important;
    font-size: 14px !important;
    line-height: 22px !important;
}

/* Arrow icon */
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 100% !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    right: 15px !important;
}

/* Dropdown options */
.select2-dropdown {
    border: 1px solid #E0E6F7 !important;
    border-radius: 4px !important;
}

.card-grid-2 {
    overflow: visible !important;
}

#createjob {
    display: none;
}

.job-type-select {
    border: 1px solid #e0e0e0;
    border-radius: 13px;
    box-shadow: 12px 12px 5px #eee;
    cursor: pointer;
}

.select-job {
    border: 1px solid #242a62;
}

#job_Statesuggestions {
    display: none;
}

#job_Citysuggestions {
    display: none
}

#job_Areasuggestions {
    display: none
}

#job_Pincodesuggestions {
    display: none;
}

#Skillsuggestions {
    display: none;
}

table.custom-bordered th,
table.custom-bordered td {
    border: 1px solid #dee2e6;
    /* Bootstrap-style border color */
}

table.custom-bordered {
    border-collapse: collapse;
}

.job_selected_area {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
}
</style>
@endpush

@extends('admin.layout.layout')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        @if ($CompanyProfileComplete != 100)
        <div class="col-lg-12">
            <div class="alert alert-warning alert-dismissible" role="alert">
                Your profile is {{ $CompanyProfileComplete }}% complete. Complete your profile to unlock a better
                and more personalized experience.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif

        <div class="col-xl-12">
            <div class="nav-align-top mb-6">
                <ul class="nav nav-pills mb-4 menu-bar" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home"
                            aria-selected="true">
                            Profile
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile"
                            aria-selected="false">
                            About & Skill
                        </button>
                    </li>

                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-top-my-jobs" aria-controls="navs-pills-top-my-jobs"
                            aria-selected="false">
                            My Jobs
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-top-membership-history"
                            aria-controls="navs-pills-top-membership-history" aria-selected="false">
                            Membership History
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-top-company-kyc" aria-controls="navs-pills-top-company-kyc"
                            aria-selected="false">
                            Company Kyc
                        </button>
                    </li>
                </ul>



                <div class="tab-content box-option">
                    <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-6">
                                <h4 style="font-size: 20px;font-weight:600;color: #242a62;" class="mb-0"><i
                                        class="bx bxs-building"></i> Company Profile</h4>
                            </div>
                            <div class="col-lg-6 col-md-6 col-6" style="text-align: center;align-content: center;">
                                <span style="font-size: 16px;font-weight:600;" class="mb-0">Do you want to deactivate
                                    your account? Click on the <a href="javascript:void(0);"
                                        style="text-decoration: underline;"
                                        onclick="ActiveDeactiveAccount({{ $userData->active_status == 1 ? 0 : 1 }},{{ $userData->id }})">{{ $userData->active_status == 1 ? 'Deactive' : 'Active' }}</a>
                                    button.</span>
                            </div>
                            <div class="col-lg-3 col-md-6 col-6" style="text-align: right;">
                                <h5 class="mb-0" style="font-size: 18px;font-weight:600;color: #242a62;">
                                    Account Status : <span style="font-size: 12px;"
                                        class="badge bg-{{ $userData->active_status == 1 ? 'success' : 'danger' }}">{{ $userData->active_status == 1 ? 'Active' : 'Deactive' }}</span></span>
                                </h5>
                            </div>
                        </div>


                        <section class="section-box-2">
                            <div class="container-fruid">
                                <div class="banner-hero banner-image-single"><img
                                        src="{{ $userData->cover_img ? asset('uploads/profile/' . $userData->cover_img) : asset('uploads/profile/company.jpeg') }}"
                                        alt="jobbox">
                                    <!-- <a class="btn-editor" href="#"></a> -->
                                </div>
                                <div class="box-company-profile">
                                    <div class="image-compay">
                                         @php
                                            $profileImg = (!empty($userData->profile_img)
                                                && file_exists(public_path('uploads/profile/'.$userData->profile_img)))
                                                ? $userData->profile_img
                                                : 'candidate.jpg';
                                        @endphp

                                            <img src="{{ asset('uploads/profile/'.$profileImg) }}"
                                                style="max-width:100px;height:100px;object-fit:cover;"
                                                alt="jobbox">
                                        {{-- <img style="max-width:90px;"
                                            src="{{ $userData->profile_img ? asset('uploads/profile/' . $userData->profile_img) : asset('uploads/profile/profile.png') }}"
                                            alt="jobbox"> --}}
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-lg-6 col-md-12">
                                            <h5 class="f-19 mb-0">{{ $userData->name }}</h5>
                                            <p class="mt-0 font-md color-text-paragraph-2 mb-15">
                                                {{ $userData->designation }}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="border-bottom pt-10 pb-10"></div> -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card mb-6 position-relative">

                                            <div class="card-body">
                                                <div id="DetailsViewProfile">
                                                    <a href="javascript:void(0)"
                                                        class="position-absolute top-0 end-0 m-3 btn btn-sm btn-primary"
                                                        onclick="EditprofileDetails()"><i class="fa fa-pencil"
                                                            aria-hidden="true"></i> &nbsp; Edit</a>
                                                    <div class="row">
                                                        @if ($userData->designation)
                                                        <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Image -->
                                                                <img src="{{ asset('admin-assets/img/position.png?id=1') }}"
                                                                    alt="Email Icon"
                                                                    style="width: 24px; height: 24px; margin-right: 10px;" />

                                                                <!-- Text Content -->
                                                                <div>
                                                                    <label
                                                                        class="user-info-label mb-0">Designation</label>
                                                                    <p class="user-info-value mb-0">
                                                                        {{ $userData->designation }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        @if ($userData->email)
                                                        <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Image -->
                                                                <img src="{{ asset('admin-assets/img/email.png?id=1') }}"
                                                                    alt="Email Icon"
                                                                    style="width: 24px; height: 24px; margin-right: 10px;" />

                                                                <!-- Text Content -->
                                                                <div>
                                                                    <label class="user-info-label mb-0">Email</label>
                                                                    <p class="user-info-value mb-0">
                                                                        {{ $userData->email }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        @if ($userData->contact_no)
                                                        <!-- Contact Number -->
                                                        <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('admin-assets/img/phone.png') }}"
                                                                    alt="Phone Icon"
                                                                    style="width: 24px; height: 24px; margin-right: 10px;" />
                                                                <div>
                                                                    <label class="user-info-label mb-0">Contact
                                                                        Number</label>
                                                                    <p class="user-info-value mb-0">
                                                                        {{ $userData->contact_no }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif


                                                        @if ($userData->personal_website)
                                                        <!-- Personal Website -->
                                                        <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('admin-assets/img/website.png') }}"
                                                                    alt="Website Icon"
                                                                    style="width: 24px; height: 24px; margin-right: 10px;" />
                                                                <div>
                                                                    <label class="user-info-label mb-0">Personal
                                                                        Website</label>
                                                                    <p class="user-info-value mb-0">
                                                                        {{ $userData->personal_website }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif


                                                        @if ($userData->state_name)
                                                        <!-- State -->
                                                        <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('admin-assets/img/state.png') }}"
                                                                    alt="State Icon"
                                                                    style="width: 24px; height: 24px; margin-right: 10px;" />
                                                                <div>
                                                                    <label class="user-info-label mb-0">State</label>
                                                                    <p class="user-info-value mb-0">
                                                                        {{ $userData->state_name }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif


                                                        @if ($userData->city_nm)
                                                        <!-- City -->
                                                        <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('admin-assets/img/city.png') }}"
                                                                    alt="City Icon"
                                                                    style="width: 24px; height: 24px; margin-right: 10px;" />
                                                                <div>
                                                                    <label class="user-info-label mb-0">City</label>
                                                                    <p class="user-info-value mb-0">
                                                                        {{ $userData->city_nm }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif


                                                        @if ($userData->area_nm)
                                                        <!-- Area -->
                                                        <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('admin-assets/img/city.png') }}"
                                                                    alt="City Icon"
                                                                    style="width: 24px; height: 24px; margin-right: 10px;" />
                                                                <div>
                                                                    <label class="user-info-label mb-0">Area</label>
                                                                    <p class="user-info-value mb-0">
                                                                        {{ $userData->area_nm }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif


                                                        @if ($userData->zipcode)
                                                        <!-- Zip Code -->
                                                        <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('admin-assets/img/zipcode.png') }}"
                                                                    alt="Zip Code Icon"
                                                                    style="width: 24px; height: 24px; margin-right: 10px;" />
                                                                <div>
                                                                    <label class="user-info-label mb-0">Zip
                                                                        Code</label>
                                                                    <p class="user-info-value mb-0">
                                                                        {{ $userData->zipcode }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        @if ($userData->address)
                                                        <!-- Zip Code -->
                                                        <div class="col-lg-12 col-md-12 col-12 mb-5">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('admin-assets/img/address.png') }}"
                                                                    alt="Zip Code Icon"
                                                                    style="width: 24px; height: 24px; margin-right: 10px;" />
                                                                <div>
                                                                    <label class="user-info-label mb-0">Address</label>
                                                                    <p class="user-info-value mb-0">
                                                                        {{ $userData->address }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div id="DetailsEditProfile">
                                                    <form id="company-profile-form" onsubmit="return false;">
                                                        <a href="javascript:void(0)"
                                                            class="position-absolute top-0 end-0 m-3 btn btn-sm btn-primary"
                                                            onclick="BackToprofileDetails()"><i
                                                                class="fa fa-long-arrow-left" aria-hidden="true"></i>
                                                            &nbsp; Back</a>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                                <label for="designation" class="form-label mb-2">Company
                                                                    Designation <span class="color-red">*</span></label>
                                                                <input type="text" id="designation" name="designation"
                                                                    class="form-control" placeholder="Enter Email"
                                                                    value="{{ $userData->designation }}">
                                                            </div>

                                                            <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                                <label for="company_nm" class="form-label mb-2">Company
                                                                    Name <span class="color-red">*</span></label>
                                                                <input type="text" id="company_nm" name="company_nm"
                                                                    class="form-control" placeholder="Enter Email"
                                                                    value="{{ $userData->name }}">
                                                            </div>


                                                            <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                                <label for="email" class="form-label mb-2">Email
                                                                    <span class="color-red">*</span></label>
                                                                <input type="text" id="email" name="email"
                                                                    class="form-control" placeholder="Enter Email"
                                                                    value="{{ $userData->email }}">
                                                            </div>


                                                            <!-- Contact Number -->
                                                            <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                                <label for="contact_no" class="form-label mb-2">Contact
                                                                    Number <span class="color-red">*</span></label>
                                                                <input type="text" id="contact_no" name="contact_no"
                                                                    class="form-control"
                                                                    placeholder="Enter Contact Number"
                                                                    value="{{ $userData->contact_no }}">
                                                            </div>

                                                            <!-- Personal Website -->
                                                            <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                                <label for="company_website"
                                                                    class="form-label mb-2">Company
                                                                    Website</label>
                                                                <input type="text" id="company_website"
                                                                    name="company_website" class="form-control"
                                                                    placeholder="Enter Personal Website"
                                                                    value="{{ $userData->personal_website }}">
                                                            </div>

                                                            <!-- State -->
                                                            <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="input-5">State
                                                                        <span class="color-red">*</span></label>
                                                                    <input class="form-control" id="state_id"
                                                                        type="text" required="" name="state_id"
                                                                        placeholder="Enter State" autocomplete="off"
                                                                        autocorrect="off" autocapitalize="off"
                                                                        value="{{ $userData ? $userData->state_name : '' }}">

                                                                    <div id="Statesuggestions" class="suggestions">
                                                                    </div>
                                                                    <input type="hidden" name="state_id_hidden"
                                                                        id="state_id_hidden"
                                                                        value="{{ $userData ? $userData->state_id : '' }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="city_id">City
                                                                        <span class="color-red">*</span></label>
                                                                    <input class="form-control" id="city_id" type="text"
                                                                        required="" name="city_id"
                                                                        placeholder="Enter City" autocomplete="off"
                                                                        autocorrect="off" autocapitalize="off"
                                                                        value="{{ $userData ? $userData->city_nm : '' }}">

                                                                    <div id="Citysuggestions" class="suggestions">
                                                                    </div>
                                                                    <input type="hidden" name="city_id_hidden"
                                                                        id="city_id_hidden"
                                                                        value="{{ $userData ? $userData->city_id : '' }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="area_id">Area
                                                                        <span class="color-red">*</span></label>
                                                                    <input class="form-control" id="area_id" type="text"
                                                                        required="" name="area_id"
                                                                        placeholder="Enter Area" autocomplete="off"
                                                                        autocorrect="off" autocapitalize="off"
                                                                        value="{{ $userData ? $userData->area_nm : '' }}">

                                                                    <div id="Areasuggestions" class="suggestions">
                                                                    </div>
                                                                    <input type="hidden" name="area_id_hidden"
                                                                        id="area_id_hidden"
                                                                        value="{{ $userData ? $userData->area_id : '' }}">
                                                                </div>
                                                            </div>


                                                            <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="input-5">Pincode
                                                                        <span class="color-red">*</span></label>
                                                                    <input class="form-control" id="zipcode" type="text"
                                                                        required="" name="zipcode"
                                                                        placeholder="Enter Pipcode" autocomplete="off"
                                                                        autocorrect="off" autocapitalize="off"
                                                                        value="{{ $userData ? $userData->zipcode : '' }}">

                                                                    <div id="Pincodesuggestions" class="suggestions">
                                                                    </div>
                                                                    <input type="hidden" name="pincode_id_hidden"
                                                                        id="pincode_id_hidden"
                                                                        value="{{ $userData ? $userData->zipcode_id : '' }}">
                                                                </div>
                                                            </div>

                                                            <!-- Zip Code -->
                                                            <div class="col-lg-12 col-md-12 col-12 mb-5">
                                                                <label for="nameBackdrop"
                                                                    class="form-label mb-2">Address
                                                                    <span class="color-red">*</span></label>
                                                                <textarea name="address" class="form-control"
                                                                    id="address">{{ $userData->address }}</textarea>
                                                            </div>

                                                            <div class="col-lg-12 col-md-12 col-12 mb-5">
                                                                <input type="hidden" id="_method" name="_method"
                                                                    value="POST">
                                                                <input type="hidden" id="user_id" name="user_id"
                                                                    value="{{ $userData->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-primary">Save</button>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </section>
                    </div>

                    <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card p-0 mb-6 position-relative">
                                    <!-- Edit Button Positioned Top-Right -->

                                    <div class="card-body p-3">
                                        <div id="AboutAndSkillView">
                                            <a href="javascript:void(0)" onclick="EditAboutAndSkill()"
                                                class="position-absolute top-0 end-0 m-3 btn btn-sm btn-primary"><i
                                                    class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Edit</a>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h4>About Us</h4>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <p>
                                                        {{ $userData->company_desc }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row mt-20">
                                                <div class="col-lg-12">
                                                    <h4>Specialties</h4>
                                                </div>
                                                <div class="col-lg-12">
                                                    <ul class="list-unstyled">
                                                        @foreach(explode(',', $userData->specialties) as $specialty)
                                                            <li>• {{ trim($specialty) }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>


                                        <div id="AboutAndSkillEdit">
                                            <form id="company-about-form" onsubmit="return false;">
                                                <a href="javascript:void(0)" onclick="BackToAboutAndSkillView()"
                                                    class="position-absolute top-0 end-0 m-3 btn btn-sm btn-primary"><i
                                                        class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;
                                                    Back</a>
                                                <div class="row mt-5">
                                                    <div class="col-lg-12 col-md-12 col-12">

                                                        <label for="nameBackdrop" class="form-label mb-2">About
                                                            us</label>
                                                        <textarea class="form-control" id="company_desc"
                                                            name="company_desc"
                                                            rows="8">{{ $userData->company_desc }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="form-group mb-5">
                                                            <label class="font-sm color-text-mutted mb-3">Specialties</label>

                                                            <input type="text"
                                                                class="form-control"
                                                                id="specialties"
                                                                name="specialties"
                                                                placeholder="Eg: Web Development, Software, CRM"
                                                                value="{{ $userData ? $userData->specialties : '' }}">

                                                            <small class="text-muted">
                                                                Add specialties in comma separated format.
                                                            </small>    
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-12 mb-5">
                                                        <input type="hidden" id="_method" name="_method" value="POST">
                                                        <input type="hidden" id="about_row_id" name="about_row_id"
                                                            value="{{ $userData ? $userData->id : '' }}">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="navs-pills-top-my-jobs" role="tabpanel">
                        <div class="row">




                            <div id="joblist">
                                <div class="d-flex justify-content-end mb-3">
                                    <a class="btn btn-primary text-white" id="addJobBtn" onclick="CreateNewJob()">
                                        <i class="fa fa-plus"></i> Add Job
                                    </a>
                                </div>
                                
                                <!-- Add row wrapper with d-flex -->
                                <div class="row">
                                    @foreach ($JobData as $row)
                                        <div class="col-lg-4 col-md-6">
                                            <div class="card p-0 mb-4 position-relative shadow-sm" style="border-radius:12px; overflow:hidden;">

                                                <!-- 👉 RIGHT TOP BUTTON GROUP -->
                                                <div class="position-absolute top-0 end-0 m-2 d-flex gap-2">

                                                    <!-- Edit Button -->
                                                    <button class="btn btn-sm btn-warning"
                                                        onclick="EditJob({{ $row->job_id }})"
                                                        title="Edit Job">
                                                        <i class="fa fa-pencil"></i>
                                                    </button>

                                                    <!-- View Button -->
                                                    <a href="{{ route('job-detail', ['job_id' => $row->job_id]) }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-info"
                                                        title="View Job">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <!-- Active / Close Toggle -->
                                                        @if($row->status != 1)
                                                        <a class="btn btn-sm btn-success p-2"
                                                            onclick="event.stopPropagation(); changeStatus({{ $row->job_id }},1)"
                                                            title="Mark Active">
                                                            <i class="fa fa-check text-white"></i>
                                                        </a>
                                                        @endif

                                                        <!-- CLOSE BUTTON (Only if NOT Closed) -->
                                                        @if($row->status != 2)
                                                        <a class="btn btn-danger btn-sm p-2"
                                                            onclick="event.stopPropagation(); changeStatus({{ $row->job_id }},2)"
                                                            title="Mark Closed">
                                                            <i class="fa fa-times text-white"></i>
                                                        </a>
                                                        @endif

                                                </div>
                                                <!-- END BUTTON GROUP -->

                                                <div class="card-body p-3" style="padding-top:45px !important;">
                                                    <h5 class="fw-bold mb-2">{{ $row->job_title }}</h5>

                                                    <p class="mb-1 fw-semibold">
                                                        <i class="fa fa-briefcase"></i>
                                                        {{ $row->work_type_name }}
                                                    </p>

                                                    <p class="mb-1 fw-semibold">
                                                        <i class="fa fa-clock"></i>
                                                        {{ \Carbon\Carbon::parse($row->datetime)->diffForHumans() }}
                                                    </p>

                                                    <p class="mb-1 fw-semibold">
                                                        <i class="fa fa-map-marker"></i>
                                                        {{ $row->company_address }}
                                                    </p>

                                                    <p class="mb-1 fw-semibold">
                                                        <i class="fa fa-info-circle"></i>

                                                        @if($row->status == 1)
                                                            <span class="badge bg-success">Active</span>
                                                        @elseif($row->status == 2)
                                                            <span class="badge bg-danger">Closed</span>
                                                        @else
                                                            <span class="badge bg-secondary">Draft</span>
                                                        @endif
                                                    </p>

                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                    </div>

                            </div>

                            

                            <div class="card">


                                <div id="createjob">
                                    <div class="row mt-5">
                                        <div class="col-lg-9">
                                            <h3 class="mt-0 color-brand-1 mb-50">Create New Job</h3>
                                        </div>
                                        <div class="col-lg-3 text-right">
                                            <a class="btn btn-preview-icon btn-apply btn-apply-big"
                                                style="padding: 14px 30px 14px 30px;" href="javascript:void(0);"
                                                onclick="BackJobList()"><i class="fa fa-long-arrow-left"></i>&nbsp;
                                                Back</a>
                                        </div>
                                    </div>
                                    <form id="job-form" onsubmit="return false;">
                                        <div class="row form-contact ">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-4">
                                                        <div class="job-type-select select-job" id="noneskill"
                                                            onclick="SelectJobType('Non-Skilled')">
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-4 col-4">
                                                                    <img src="/assets/imgs/noneskill.png" alt=""
                                                                        style="width: 100%;">
                                                                </div>
                                                                <div class="col-lg-8 col-md-8 col-8"
                                                                    style="align-content: center;">
                                                                    <h4>UnSkilled</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-4">
                                                        <div class="job-type-select" id="skill"
                                                            onclick="SelectJobType('Skilled')">
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-4 col-4">
                                                                    <img src="/assets/imgs/skill.png" alt=""
                                                                        style="width: 100%;">
                                                                </div>
                                                                <div class="col-lg-8 col-md-8 col-8"
                                                                    style="align-content: center;">
                                                                    <h4>Skilled</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <input type="hidden" id="job_preference_type"
                                                        name="job_preference_type" value="">
                                                    <input type="hidden" id="company_id" name="company_id" value="{{ $userData->id }}">
                                                </div>
                                                <div class="row mt-10">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-3">Job Category
                                                                *</label>
                                                            <select name="job_category_id" class="form-control"
                                                                id="job_category_id">
                                                                <option value="">-- Select Job Category --</option>
                                                                @foreach ($CategoryData as $row)
                                                                <option value="{{ $row->category_id }}">
                                                                    {{ $row->category_nm }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-3">Sub Category
                                                                *</label>
                                                            <select name="job_sub_category_id" class="form-control"
                                                                id="job_sub_category_id">
                                                                <option value="">-- Select Sub Category --
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group" style="position: relative;">
                                                            <label class="font-sm color-text-mutted m-3">Job
                                                                Title</label>
                                                            <input class="form-control" id="job_title" name="job_title"
                                                                type="text" placeholder="Enter Job Title">
                                                                <div id="jobTitleSuggestions" class="suggestions"></div>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-6">
                                                        <div class="form-group" id="SkillMinimumQualification">
                                                            <label class="font-sm color-text-mutted m-3">Minimum
                                                                Qualification *</label>
                                                            <select name="job_minimum_qualification"
                                                                class="form-control" id="job_minimum_qualification">
                                                                <option value="">-- Select Minimum Qualification
                                                                    --
                                                                </option>
                                                                @foreach ($MinqualificationData as $row)
                                                                <option value="{{ $row->qualification_id }}">
                                                                    {{ $row->name }}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">Job Level
                                                                *</label>
                                                            <select name="job_level" class="form-control"
                                                                id="job_level">
                                                                <option value="">-- Select Job Level --</option>
                                                                @foreach ($JoblevelData as $row)
                                                                <option value="{{ $row->job_level_id }}">
                                                                    {{ $row->type_nm }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">Job Type
                                                                *</label>
                                                            <select name="job_type" class="form-control" id="job_type">
                                                                <option value="">-- Select Job Type --</option>
                                                                @foreach ($JobtypeData as $row)
                                                                <option value="{{ $row->job_type_id }}">
                                                                    {{ $row->type_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">Work Type
                                                                *</label>
                                                            <select name="job_work_type" class="form-control"
                                                                id="job_work_type">
                                                                <option value="">-- Select Work Type --</option>
                                                                @foreach ($WorktypeData as $row)
                                                                <option value="{{ $row->work_type_id }}">
                                                                    {{ $row->type_nm }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">Number of
                                                                Openings</label>
                                                            <input class="form-control" type="text"
                                                                id="job_number_of_openings"
                                                                name="job_number_of_openings"
                                                                placeholder="How many candidates are needed">
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">Salary
                                                                Budget</label>
                                                            <input class="form-control" type="text"
                                                                id="job_salary_budget" name="job_salary_budget"
                                                                placeholder="Enter Salary Budget">
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">Job
                                                                Timing</label>
                                                            <input class="form-control" type="text" id="job_timing"
                                                                name="job_timing" placeholder="Enter Job Timing">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">Candidate
                                                                Gender</label>
                                                            <select class="form-control" id="gender" name="gender">
                                                                <option value="">Please Select Gender</option>
                                                                <option value="All">All</option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                                <option value="Other">Other</option>
                                                                <option value="Both">Male & Female Both</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">Age</label>
                                                            <input class="form-control" type="text" id="job_age"
                                                                name="job_age" placeholder="Enter Job Age">
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">Job
                                                                Description
                                                                & Responsibilities</label>
                                                            <!-- <textarea class="form-control" id="job_description"
                                                                name="job_description" rows="4">Enter Here...</textarea> -->
                                                            <div id="job_description_editor"
                                                                    style="height:200px; background:#fff;">
                                                            </div>
                                                            <input type="hidden" name="job_description" id="job_description">
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">Interviewer’s
                                                                Address</label>
                                                            <input class="form-control" type="text"
                                                                id="job_interviewer_address"
                                                                name="job_interviewer_address"
                                                                placeholder="Enter Interviewer Address">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">Experience
                                                                Required *</label>
                                                            <select name="job_experience_required" class="form-control"
                                                                id="job_experience_required">
                                                                <option value="">-- Select Experience Required --
                                                                </option>
                                                                @foreach ($ExperiencereqData as $row)
                                                                <option value="{{ $row->experience_req_id }}">
                                                                    {{ $row->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">Contact
                                                                number</label>
                                                            <input class="form-control" id="job_contact_number"
                                                                name="job_contact_number" type="text"
                                                                placeholder="Enter Contact No.">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">Company
                                                                Website</label>
                                                            <input class="form-control" type="text"
                                                                id="job_company_website" name="job_company_website"
                                                                placeholder="Enter Website URL">
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">Company
                                                                Address</label>
                                                            <input class="form-control" type="text"
                                                                id="job_company_address" name="job_company_address"
                                                                placeholder="Enter Address">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label m-3" for="input-5">Pincode</label>
                                                            <input class="form-control" id="job_zipcode" type="text"
                                                                required="" name="job_zipcode"
                                                                placeholder="Enter Pincode" autocomplete="off"
                                                                autocorrect="off" autocapitalize="off"
                                                                value="{{ $userData ? $userData->zipcode : '' }}">

                                                            <div id="job_Pincodesuggestions" class="suggestions">
                                                            </div>
                                                            <input type="hidden" name="job_pincode_id_hidden"
                                                                id="job_pincode_id_hidden"
                                                                value="{{ $userData ? $userData->zipcode_id : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label m-3" for="input-5">State</label>
                                                            <input class="form-control" id="job_state_id" type="text"
                                                                required="" name="job_state_id"
                                                                placeholder="Enter State" autocomplete="off"
                                                                autocorrect="off" autocapitalize="off"
                                                                value="{{ $userData ? $userData->state_name : '' }}">

                                                            <div id="job_Statesuggestions" class="suggestions"></div>
                                                            <input type="hidden" name="job_state_id_hidden"
                                                                id="job_state_id_hidden"
                                                                value="{{ $userData ? $userData->state_id : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label m-3" for="city_id">City</label>
                                                            <input class="form-control" id="job_city_id" type="text"
                                                                required="" name="job_city_id" placeholder="Enter City"
                                                                autocomplete="off" autocorrect="off"
                                                                autocapitalize="off"
                                                                value="{{ $userData ? $userData->city_nm : '' }}">

                                                            <div id="job_Citysuggestions" class="suggestions"></div>
                                                            <input type="hidden" name="job_city_id_hidden"
                                                                id="job_city_id_hidden"
                                                                value="{{ $userData ? $userData->city_id : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label m-3" for="job_area_id">Area /
                                                                Village</label>
                                                            <input class="form-control" id="job_area_id" type="text"
                                                                required="" name="job_area_id" placeholder="Enter Area"
                                                                autocomplete="off" autocorrect="off"
                                                                autocapitalize="off"
                                                                value="{{ $userData ? $userData->area_nm : '' }}">

                                                            <div class="job_selected_area mt-2" id="JobAreaSuggestBox">
                                                            </div>

                                                            <div id="job_Areasuggestions" class="suggestions"></div>
                                                            <input type="hidden" name="job_area_id_hidden"
                                                                id="job_area_id_hidden"
                                                                value="{{ $userData ? $userData->area_id : '' }}">
                                                        </div>
                                                    </div>





                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">HR
                                                                Email</label>
                                                            <input class="form-control" type="text" id="job_hr_email"
                                                                name="job_hr_email" placeholder="Enter HR Email">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted m-3">HR Contact
                                                                No.</label>
                                                            <input class="form-control" type="text"
                                                                id="job_hr_contact_no" name="job_hr_contact_no"
                                                                placeholder="Enter Contact No.">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="box-skills">
                                                            <h5 class="m-3 color-brand-1">Skills</h5>
                                                            <div class="form-contact">
                                                                <div class="form-group">
                                                                    <input class="form-control search-icon"
                                                                        id="skill_id" name="skill_id" type="text"
                                                                        value="" placeholder="E.g. Angular, Laravel..."
                                                                        autocomplete="off" autocorrect="off"
                                                                        autocapitalize="off">
                                                                    <div id="Skillsuggestions" class="suggestions">
                                                                    </div>
                                                                    <input type="hidden" name="skills_hidden"
                                                                        id="skills_hidden">
                                                                </div>
                                                            </div>
                                                            <div class="box-tags mt-30"></div>
                                                            <div class="mt-40"> <span
                                                                    class="card-info font-sm color-text-paragraph-2">You
                                                                    can add up to 15 skills</span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="border-bottom"></div>

                                                <div class="row mt-5">
                                                    <div class="col-lg-12">
                                                        <label class="form-label" for="input-5">Interviewe
                                                            Round</label>
                                                        <div id="CompanyInterviewRow">
                                                            <div class="row product-row">
                                                                <div class="col-lg-12">
                                                                    <div class="branch-box">
                                                                        <div class="row">
                                                                            <div class="col-lg-4">
                                                                                <div class="form-group">
                                                                                    <label class="form-label"
                                                                                        for="round_nm">Round
                                                                                        Name</label>
                                                                                    <input class="form-control"
                                                                                        id="round_nm" type="text"
                                                                                        name="round_nm[]"
                                                                                        placeholder="Enter Round Name">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-7">
                                                                                <div class="form-group">
                                                                                    <label class="form-label"
                                                                                        for="round_description">Round
                                                                                        Description</label>
                                                                                    <input class="form-control"
                                                                                        id="round_description"
                                                                                        type="text"
                                                                                        name="round_description[]"
                                                                                        placeholder="Enter Round Description">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-1">
                                                                                <button
                                                                                    class="btn btn-brand-1 hover-up mt-4 add-row"
                                                                                    style="padding: 18px 21px;"
                                                                                    type="button"><i
                                                                                        class="fa fa-plus"></i></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="box-button mt-15">
                                                            <input type="hidden" id="_method" name="_method"
                                                                value="POST">
                                                            <input type="hidden" id="flag" name="flag" value="A">
                                                            <input type="hidden" id="row_id" name="row_id">
                                                            <button class="mt-3 btn btn-apply-big font-md font-bold"
                                                                type="submit">Post
                                                                Job</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="navs-pills-top-membership-history" role="tabpanel">
                        <div class="card p-0 ">
                            <div class="card-header p-3 d-flex align-items-center justify-content-between">
                                <h5 class="card-title m-0 me-2">Membership History</h5>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Sr. No.</th>
                                                    <th scope="col">Plan</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Buy On</th>
                                                    <th scope="col">Expire On</th>
                                                    <th scope="col">Current Active Plan</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($PlanHistoryData as $row)
                                                <tr>
                                                    <th>{{ $loop->iteration }}</th>
                                                    <td>{{ $row->plan_name }}</td>
                                                    <td>₹ {{ $row->plan_price . '/' . $row->duration }}</td>
                                                    <td>{{ $row->purchase_date }}</td>
                                                    <td>{{ $row->expire_date }}</td>
                                                    <td><span
                                                            class="badge bg-{{ $row->status == 'Active' ? 'success' : 'danger' }}">{{ $row->status }}</span>
                                                    </td>
                                                    <td><a href="#" class="btn btn-sm  btn-secondary">
                                                            View Invoice
                                                        </a></td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="navs-pills-top-company-kyc" role="tabpanel">
                        <div class="card p-3 mt-3">
                            <h5 class="mb-3">Company KYC Upload</h5>

                            <form action="{{ route('admin.upload-company-kyc', $userData->id) }}" method="POST"
                                enctype="multipart/form-data" id="kycForm">
                                @csrf

                                <div class="row mb-3">
                                    <!-- Title Dropdown -->
                                    <div class="col-md-4">
                                        <label class="form-label">Select Document Type</label>
                                        <select name="title" class="form-control" required>
                                            <option value="">-- Select Document Type --</option>
                                            <option value="pan_card"
                                                {{ isset($CompanyKycData[0]) && $CompanyKycData[0]->title == 'pan_card' ? 'selected' : '' }}>
                                                PAN Card</option>
                                            <option value="aadhaar_card"
                                                {{ isset($CompanyKycData[0]) && $CompanyKycData[0]->title == 'aadhaar_card' ? 'selected' : '' }}>
                                                Aadhaar Card</option>
                                            <option value="business_card"
                                                {{ isset($CompanyKycData[0]) && $CompanyKycData[0]->title == 'business_card' ? 'selected' : '' }}>
                                                Business Card</option>
                                            <option value="gst"
                                                {{ isset($CompanyKycData[0]) && $CompanyKycData[0]->title == 'gst' ? 'selected' : '' }}>
                                                GST Certificate</option>
                                            <option value="msme"
                                                {{ isset($CompanyKycData[0]) && $CompanyKycData[0]->title == 'msme' ? 'selected' : '' }}>
                                                MSME Certificate</option>
                                        </select>
                                    </div>

                                    <!-- File Upload Section -->
                                    <div class="col-md-8">
                                        <label class="form-label">Upload Document</label>

                                        @if(isset($CompanyKycData[0]) && $CompanyKycData[0]->document)
                                        <!-- Existing File Preview -->
                                        <div class="existing-file-preview mb-3">
                                            <div class="card border">
                                                <div class="card-body py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <!-- Left Side - Document View/Link -->
                                                        <div class="d-flex align-items-center">
                                                            @php
                                                            $fileExtension = pathinfo($CompanyKycData[0]->document,
                                                            PATHINFO_EXTENSION);
                                                            $isImage = in_array(strtolower($fileExtension), ['jpg',
                                                            'jpeg', 'png', 'gif']);
                                                            $isPDF = strtolower($fileExtension) === 'pdf';
                                                            @endphp

                                                            @if($isImage)
                                                            <!-- Image Preview -->
                                                            <div class="me-3">
                                                                <img src="{{ asset('uploads/company_kyc/'.$CompanyKycData[0]->document) }}"
                                                                    alt="Document Preview" class="rounded"
                                                                    style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;"
                                                                    onclick="openDocument('{{ asset('uploads/company_kyc/'.$CompanyKycData[0]->document) }}')">
                                                            </div>
                                                            @elseif($isPDF)
                                                            <!-- PDF Icon -->
                                                            <div class="me-3">
                                                                <i class="fa fa-file-pdf text-danger"
                                                                    style="font-size: 40px; cursor: pointer;"
                                                                    onclick="openDocument('{{ asset('uploads/company_kyc/'.$CompanyKycData[0]->document) }}')"></i>
                                                            </div>
                                                            @else
                                                            <!-- Default File Icon -->
                                                            <div class="me-3">
                                                                <i class="fa fa-file text-primary"
                                                                    style="font-size: 40px; cursor: pointer;"
                                                                    onclick="openDocument('{{ asset('uploads/company_kyc/'.$CompanyKycData[0]->document) }}')"></i>
                                                            </div>
                                                            @endif

                                                            <!-- Document Info -->
                                                            <div>
                                                                <div class="fw-medium text-dark"
                                                                    style="cursor: pointer;"
                                                                    onclick="openDocument('{{ asset('uploads/company_kyc/'.$CompanyKycData[0]->document) }}')">
                                                                    {{ $CompanyKycData[0]->document }}
                                                                </div>
                                                                <small class="text-muted">
                                                                    Click to view document
                                                                </small>
                                                            </div>
                                                        </div>

                                                        <!-- Right Side - Remove Button -->
                                                        <div>
                                                            <button type="button" class="btn btn-sm btn-outline-info"
                                                                onclick="openDocument('{{ asset('uploads/company_kyc/'.$CompanyKycData[0]->document) }}')">
                                                                <i class="fa fa-eye me-1"></i> View
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden field to track file removal -->
                                        <input type="hidden" name="remove_existing_file" id="removeExistingFile"
                                            value="0">
                                        @endif

                                        <!-- Simple File Input -->
                                        <div class="file-upload-area">
                                            <input type="file" name="file" id="fileInput" class="form-control"
                                                accept=".jpg,.jpeg,.png,.pdf"
                                                {{ !isset($CompanyKycData[0]) ? 'required' : '' }}>
                                            <small class="text-muted">Allowed formats: JPG, JPEG, PNG, PDF (Max:
                                                1MB)</small>
                                        </div>

                                        <!-- New File Preview -->
                                        <div id="filePreview" class="mt-2" style="display: none;">
                                            <div class="card border">
                                                <div class="card-body py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <!-- Left Side - New File Info -->
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa fa-file-upload text-success me-3"
                                                                style="font-size: 40px;"></i>
                                                            <div>
                                                                <div class="fw-medium text-dark" id="fileName"></div>
                                                                <small class="text-muted">New document ready to
                                                                    upload</small>
                                                            </div>
                                                        </div>

                                                        <!-- Right Side - Remove Button -->
                                                        <div>
                                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                                onclick="removeFile()">
                                                                <i class="fa fa-times me-1"></i> Remove
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- SUBMIT / UPDATE BUTTON -->
                                <div class="text-end">
                                    @if(isset($CompanyKycData[0]))
                                    <button type="submit" class="btn btn-warning px-4">
                                        <i class="fa fa-sync me-2"></i>Update
                                    </button>
                                    @else
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fa fa-upload me-2"></i>Submit
                                    </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>






                </div>
            </div>
        </div>

    </div>

</div>
@endsection


@push('script')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
    <script>
        var quill = new Quill('#job_description_editor', {
            theme: 'snow',
            placeholder: 'Enter job description here...'
        });
    </script>
<script>
// ===========================================
// CORE FUNCTIONS DEFINED AT THE TOP
// ============================================
$(document).ready(function(){

    $("#job_title").keyup(function(){

        let keyword = $(this).val().trim();

        if (keyword.length < 1) {
            $("#jobTitleSuggestions").hide();
            return;
        }

        $.ajax({
            url: "{{ route('fetch-job-titles') }}",
            type: "POST",
            data: {
                keyword: keyword,
                _token: '{{ csrf_token() }}'
            },
            success: function(res){
                if(res.status === 1){
                    let html = "";

                    res.data.forEach(val => {
                        html += `<div class="suggestion-item"
                                    onclick="selectJobTitle('${val.title_name}')">
                                    ${val.title_name}
                                  </div>`;
                    });

                    $("#jobTitleSuggestions").html(html).show();
                }
            }
        });

    });

});

function selectJobTitle(val){
    $("#job_title").val(val);
    $("#jobTitleSuggestions").hide();
}

function CreateNewJob() {
    console.log("CreateNewJob called");

    // Show form, hide list
    document.getElementById("joblist").style.display = "none";
    document.getElementById("createjob").style.display = "block";

    // Wait for form to show
    setTimeout(function() {
        // Reset form
        $('#job-form')[0].reset();

        // Destroy existing Select2
        if ($('#job_category_id').hasClass('select2-hidden-accessible')) {
            $('#job_category_id').select2('destroy');
        }
        if ($('#job_sub_category_id').hasClass('select2-hidden-accessible')) {
            $('#job_sub_category_id').select2('destroy');
        }

        // Reset dropdowns
        $('#job_category_id').empty();
        $('#job_category_id').append('<option value="">-- Select Job Category --</option>');

        // Add all categories
        @foreach($CategoryData as $cat)
        $('#job_category_id').append('<option value="{{$cat->category_id}}">{{$cat->category_nm}}</option>');
        @endforeach

        $('#job_sub_category_id').empty();
        $('#job_sub_category_id').append('<option value="">Select Sub Category</option>');

        // Reset skills
        $('#skills_hidden').val('');
        $('.box-tags').empty();

        // Reset flags
        $("#flag").val("A");
        $("#row_id").val("");

        // Initialize Select2
        setTimeout(function() {
            $('#job_category_id').select2({
                placeholder: "-- Select Job Category --",
                allowClear: true,
                width: '100%'
            });

            $('#job_sub_category_id').select2({
                placeholder: "-- Select Sub Category --",
                allowClear: true,
                width: '100%'
            });

            // Initialize job type
            SelectJobType('Non-Skilled');
            
            console.log("Create form initialized");
        }, 100);

    }, 100);
}

function BackJobList() {
    console.log("BackJobList called");

    // Hide form, show list
    document.getElementById("createjob").style.display = "none";
    document.getElementById("joblist").style.display = "block";

    // Clean up Select2 to prevent conflicts
    if ($('#job_category_id').hasClass('select2-hidden-accessible')) {
        $('#job_category_id').select2('destroy');
        $('#job_sub_category_id').select2('destroy');
    }
}

function SelectJobType(type) {
    console.log("SelectJobType called:", type);

    // Remove active class from both selectors
    $('.job-type-select').removeClass('select-job');

    // Toggle visibility based on job type
    if (type === 'Non-Skilled') {
        $('#noneskill').addClass('select-job');
        $("#job_preference_type").val('2');

        // Destroy Select2 before loading new categories
        if ($('#job_category_id').hasClass('select2-hidden-accessible')) {
            $('#job_category_id').select2('destroy');
            $('#job_sub_category_id').select2('destroy');
        }

        // Load Unskilled categories
        loadJobCategories(2);

    } else if (type === 'Skilled') {
        $('#skill').addClass('select-job');
        $("#job_preference_type").val('1');

        // Destroy Select2 before loading new categories
        if ($('#job_category_id').hasClass('select2-hidden-accessible')) {
            $('#job_category_id').select2('destroy');
            $('#job_sub_category_id').select2('destroy');
        }

        // Load Skilled categories  
        loadJobCategories(1);
    }
}

function loadJobCategories(preferenceType) {
    console.log("Loading categories for preference:", preferenceType);

    // Clear current options
    $('#job_category_id').empty().append('<option value="">Loading...</option>');
    $('#job_sub_category_id').empty().append('<option value="">Select Sub Category</option>');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: "{{ route('job-categories-by-preference') }}",
        data: {
            preference_type: preferenceType
        },
        dataType: "json",
        success: function(response) {
            if (response.status === 1) {
                let categories = response.data;

                // Clear and rebuild
                $('#job_category_id').empty();
                $('#job_category_id').append('<option value="">-- Select Job Category --</option>');

                categories.forEach(category => {
                    $('#job_category_id').append(
                        `<option value="${category.category_id}">${category.category_nm}</option>`
                    );
                });

                // Reinitialize Select2
                $('#job_category_id').select2({
                    placeholder: "-- Select Job Category --",
                    allowClear: true,
                    width: '100%'
                });

                $('#job_sub_category_id').select2({
                    placeholder: "-- Select Sub Category --",
                    allowClear: true,
                    width: '100%'
                });

                console.log("Categories loaded:", categories.length);
            } else {
                $('#job_category_id').empty().append('<option value="">No Categories Found</option>');
            }
        },
        error: function() {
            $('#job_category_id').empty().append('<option value="">Error loading categories</option>');
        }
    });
}

function initSelect2() {
    setTimeout(function() {
        $('#job_category_id').select2({
            placeholder: "-- Select Job Category --",
            allowClear: true,
            width: '100%'
        });

        $('#job_sub_category_id').select2({
            placeholder: "-- Select Sub Category --",
            allowClear: true,
            width: '100%'
        });
    }, 100);
}

function updateSelect2Display(selector) {
    var $select = $(selector);
    var selectedValue = $select.val();
    var selectedText = $select.find('option:selected').text();
    var $select2Container = $select.next('.select2-container');

    if ($select2Container.length && selectedText && selectedText !== '') {
        var $display = $select2Container.find('.select2-selection__rendered');
        $display.text(selectedText);
        $display.attr('title', selectedText);

        console.log("Updated display for", selector, ":", selectedText);

        // Force Select2 to refresh
        $select.trigger('change.select2');
    }
}
function changeStatus(jobId, status) {

    let msg = status == 1 
        ? "Do you want to mark this job as <b>Active</b>?"
        : "Do you want to mark this job as <b>Closed</b>?";

    Swal.fire({
        title: "Confirm Status Change",
        html: msg,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#242a65",
        cancelButtonColor: "#f36825",
        confirmButtonText: "Yes, Confirm",
        cancelButtonText: "Cancel"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: "{{ route('job-status-change') }}",
                type: "POST",
                data: {
                    job_id: jobId,
                    status: status,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {

                    Swal.fire({
                        icon: "success",
                        title: "Updated!",
                        text: "Job status updated successfully.",
                        timer: 1500,
                        showConfirmButton: false
                    });

                    setTimeout(() => location.reload(), 1500);
                }
            });

        }

    });
}
// ===========================================
// EXISTING CODE (Keep all your existing code below)
// ============================================

const CompanyInterviewRow = document.getElementById('CompanyInterviewRow');

var count = 1;
if (CompanyInterviewRow) {
    CompanyInterviewRow.addEventListener('click', (event) => {
        if (event.target.classList.contains('add-row')) {
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'product-row', 'm-0', 'mt-3');

            const rowTemplate = `
                <div class="col-lg-12 p-0">
                  <div class="branch-box">
                    <div class="row">
                     <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label" for="round_nm">Round Name</label>
                            <input class="form-control" id="round_nm" type="text" name="round_nm[]" placeholder="Enter Round Name">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="form-group">
                            <label class="form-label" for="round_description">Round Description</label>
                            <input class="form-control" id="round_description" type="text" name="round_description[]" placeholder="Enter Round Description">
                        </div>
                    </div>

                      <div class="col-lg-1">
                        <button class="btn btn-brand-1 hover-up mt-4 remove-row" style="padding: 18px 21px;background: #cb0000;" type="button"><i class="fa fa-trash remove-row"></i></button>
                      </div>
                    </div>
                  </div>
                </div>`;

            newRow.innerHTML = rowTemplate;
            CompanyInterviewRow.appendChild(newRow);
            count++;
        }

        // Remove row functionality
        if (event.target.classList.contains('remove-row')) {
            const row = event.target.closest('.product-row');
            if (row) row.remove();
        }
    });
}

var skills_arr = [];

const SkillSelect = document.getElementById('skill_id');
const Skillsuggestions = document.getElementById('Skillsuggestions');
const skillsHidden = document.getElementById('skills_hidden');
const boxTags = document.querySelector('.box-tags');

let selectedSkills = [];

// Read and initialize existing skills
window.addEventListener('DOMContentLoaded', function() {
    const existingSkills = skillsHidden.value;
    if (existingSkills) {
        selectedSkills = existingSkills.split(',').map(s => s.trim()).filter(s => s !== '');
        selectedSkills = Array.from(new Set(selectedSkills)); // Remove duplicates
        renderTags();
    }
});

function renderTags() {
    if (!boxTags) return;
    
    boxTags.innerHTML = '';
    selectedSkills.forEach(skill => {
        const tag = document.createElement('a');
        tag.className = 'btn btn-grey-small mr-10';
        tag.innerHTML = `${skill}<span class="close-icon fa fa-times" data-skill="${skill}"></span>`;
        boxTags.appendChild(tag);
    });

    // Update hidden input
    skillsHidden.value = selectedSkills.join(',');

    // Add event to remove tags
    document.querySelectorAll('.close-icon').forEach(span => {
        span.addEventListener('click', function() {
            const skillToRemove = this.getAttribute('data-skill');
            selectedSkills = selectedSkills.filter(s => s !== skillToRemove);
            renderTags();
        });
    });
}

if (SkillSelect) {
    SkillSelect.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        if (Skillsuggestions) Skillsuggestions.innerHTML = '';

        if (query.length === 0) {
            if (Skillsuggestions) Skillsuggestions.style.display = 'none';
            return;
        }

        const filteredSkills = skills_arr.filter(skill =>
            skill.toLowerCase().includes(query)
        );

        if (Skillsuggestions && filteredSkills.length > 0) {
            Skillsuggestions.style.display = 'block';
            filteredSkills.forEach(skill => {
                const div = document.createElement('div');
                div.classList.add('suggestion-item');
                div.textContent = skill;
                div.addEventListener('click', () => {
                    addSkill(skill);
                });
                Skillsuggestions.appendChild(div);
            });
        } else {
            if (Skillsuggestions) Skillsuggestions.style.display = 'none';
        }
    });

    // Enter key handler
    SkillSelect.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const val = SkillSelect.value.trim();
            if (val && !selectedSkills.includes(val) && selectedSkills.length < 15) {
                addSkill(val);
            }
        }
    });
}

function addSkill(skill) {
    // Get existing value from hidden input
    const existing = skillsHidden.value ? skillsHidden.value.split(',').map(s => s.trim()) : [];

    // Merge existing + selectedSkills to ensure all are included
    selectedSkills = Array.from(new Set([...existing, ...selectedSkills]));

    // Only add if not already exists and under 15
    if (!selectedSkills.includes(skill) && selectedSkills.length < 15) {
        selectedSkills.push(skill);
        selectedSkills = Array.from(new Set(selectedSkills)); // remove duplicates
        renderTags();
    }

    if (SkillSelect) SkillSelect.value = '';
    if (Skillsuggestions) {
        Skillsuggestions.innerHTML = '';
        Skillsuggestions.style.display = 'none';
    }
}

function EditJob(id) {
    console.log("EditJob called for ID:", id);

    LoaderShow();
    $.ajax({
        url: `{{ url('job-action/${id}/edit') }}`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            LoaderHide();
            if (response.status === 1) {
                const data = response.data;
                console.log("Edit Data received:", data);

                // ✅ Step 1: Show create job form
                document.getElementById("joblist").style.display = "none";
                document.getElementById("createjob").style.display = "block";

                // ✅ Step 2: Wait for form to render
                setTimeout(function() {
                    // Reset form first
                    $('#job-form')[0].reset();
                    $("#company_id").val("{{ $userData->id }}");

                    // ✅ Step 3: DESTROY EXISTING SELECT2 (IMPORTANT!)
                    if ($('#job_category_id').hasClass('select2-hidden-accessible')) {
                        $('#job_category_id').select2('destroy');
                    }
                    if ($('#job_sub_category_id').hasClass('select2-hidden-accessible')) {
                        $('#job_sub_category_id').select2('destroy');
                    }

                    // ✅ Step 4: POPULATE CATEGORY DROPDOWN (NATIVE)
                    $('#job_category_id').empty();
                    $('#job_category_id').append(
                        '<option value="">-- Select Job Category --</option>');

                    // Add all categories
                    @foreach($CategoryData as $cat)
                    var selected = {{ $cat->category_id }} == data.category_id ? 'selected' : '';
                    $('#job_category_id').append('<option value="{{$cat->category_id}}" ' +
                        selected + '>{{$cat->category_nm}}</option>');
                    @endforeach

                    console.log("Category populated. Selected ID:", data.category_id);

                    // ✅ Step 5: LOAD SUB-CATEGORIES FOR SELECTED CATEGORY
                    if (data.category_id) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('sub-category-action') }}",
                            data: {
                                category_id: data.category_id,
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "json",
                            success: function(subResponse) {
                                console.log("Sub-category response:", subResponse);

                                if (subResponse.status === 1 && subResponse.data) {
                                    // Populate sub-category dropdown
                                    $('#job_sub_category_id').empty();
                                    $('#job_sub_category_id').append(
                                        '<option value="">Select Sub Category</option>'
                                    );

                                    subResponse.data.forEach(subCat => {
                                        var selected = subCat.sub_category_id ==
                                            data.sub_category_id ? 'selected' :
                                            '';
                                        $('#job_sub_category_id').append(
                                            '<option value="' + subCat
                                            .sub_category_id + '" ' +
                                            selected + '>' + subCat
                                            .sub_category_nm + '</option>'
                                        );
                                    });

                                    console.log("Sub-category populated. Selected ID:", data.sub_category_id);

                                    // ✅ Step 6: RE-INITIALIZE SELECT2 WITH DELAY
                                    setTimeout(function() {
                                        // Initialize Category Select2
                                        $('#job_category_id').select2({
                                            placeholder: "-- Select Job Category --",
                                            allowClear: true,
                                            width: '100%'
                                        });

                                        // Initialize Sub-Category Select2
                                        $('#job_sub_category_id').select2({
                                            placeholder: "-- Select Sub Category --",
                                            allowClear: true,
                                            width: '100%'
                                        });

                                        // ✅ Step 7: SET VALUES AND TRIGGER DISPLAY UPDATE
                                        $('#job_category_id').val(data
                                            .category_id).trigger(
                                            'change.select2');
                                        $('#job_sub_category_id').val(data
                                            .sub_category_id).trigger(
                                            'change.select2');

                                        // ✅ Step 8: MANUALLY UPDATE SELECT2 DISPLAY (CRITICAL!)
                                        setTimeout(function() {
                                            updateSelect2Display(
                                                '#job_category_id');
                                            updateSelect2Display(
                                                '#job_sub_category_id'
                                            );
                                        }, 50);

                                    }, 100);

                                } else {
                                    console.error("No sub-categories found");
                                    $('#job_sub_category_id').empty();
                                    $('#job_sub_category_id').append(
                                        '<option value="">No Sub Categories</option>'
                                    );

                                    // Still initialize Select2
                                    initSelect2();
                                }
                            },
                            error: function(xhr) {
                                console.error("Sub-category AJAX error:", xhr.responseText);
                                $('#job_sub_category_id').empty();
                                $('#job_sub_category_id').append(
                                    '<option value="">Error loading</option>');
                                initSelect2();
                            }
                        });
                    } else {
                        // No category selected, still initialize
                        $('#job_sub_category_id').empty();
                        $('#job_sub_category_id').append(
                            '<option value="">Select Sub Category</option>');
                        initSelect2();
                    }

                    // ✅ Step 9: SET OTHER FORM VALUES
                    // $("#preference_type").val(data.preference_type);
                    $("#job_preference_type").val(data.preference_type);
                    $("#job_title").val(data.job_title);
                    $("#job_minimum_qualification").val(data.qualification_id);
                    $("#job_level").val(data.job_level_id);
                    $("#job_type").val(data.job_type_id);
                    $("#job_work_type").val(data.work_type_id);
                    $("#job_number_of_openings").val(data.number_of_openings);
                    $("#job_salary_budget").val(data.salary_budget);
                    // $("#job_description").val(data.job_description);
                    if (data.job_description) {
                        quill.root.innerHTML = data.job_description;
                    } else {
                        quill.root.innerHTML = '';
                    }
                    $("#gender").val(data.gender || "All");
                    $("#job_timing").val(data.job_timing);
                    $("#job_age").val(data.age);
                    $("#job_interviewer_address").val(data.interviewer_address);
                    $("#job_experience_required").val(data.experience_req_id);
                    $("#job_contact_number").val(data.contact_no);
                    $("#job_company_website").val(data.company_website);
                    $("#job_company_address").val(data.company_address);
                    $("#job_state_id").val(data.state_name);
                    $("#job_state_id_hidden").val(data.state_id);
                    $("#job_city_id").val(data.city_nm);
                    $("#job_city_id_hidden").val(data.city_id);
                    $("#job_area_id").val(data.area_nm);
                    $("#job_area_id_hidden").val(data.area_id);
                    $("#job_zipcode").val(data.zipcode);
                    $("#job_pincode_id_hidden").val(data.zipcode_id);
                    $("#job_hr_email").val(data.hr_email);
                    $("#job_hr_contact_no").val(data.hr_contact_no);

                    if (data.preference_type == 1) {
                        SelectJobType('Skilled');
                    } else {
                        SelectJobType('Non-Skilled');
                    }

                    // Set row ID and flag
                    $("#row_id").val(data.job_id);
                    $("#flag").val("U");

                    // ✅ Step 10: SET SKILLS
                    if (data.skill_id) {
                        try {
                            var selectedSkills = JSON.parse(data.skill_id);
                            var skill_arr = Array.isArray(selectedSkills) ? selectedSkills : [];

                            // Update hidden input
                            document.getElementById('skills_hidden').value = skill_arr.join(',');

                            // Update display tags
                            const boxTags = document.querySelector('.box-tags');
                            if (boxTags) {
                                boxTags.innerHTML = '';
                                skill_arr.forEach(skill => {
                                    const tag = document.createElement('a');
                                    tag.className = 'btn btn-grey-small mr-10';
                                    tag.innerHTML = `${skill}
                                    <span class="close-icon remove-skill fa fa-times" 
                                          data-skill="${skill}" 
                                          style="cursor:pointer;margin-left:5px;"></span>`;
                                    boxTags.appendChild(tag);
                                });
                            }
                        } catch (e) {
                            console.log("Skills parse error:", e);
                        }
                    }

                    console.log("All form values set successfully");

                }, 200); // Wait for form display

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message,
                });
            }
        },
        error: function(xhr) {
            LoaderHide();
            console.error("Edit AJAX error:", xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to load job data.',
            });
        }
    });
}

function DeleteJob(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Are you sure you want to delete this job?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            var data = {
                'id': id
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            LoaderShow();

            $.ajax({
                type: "DELETE",
                url: "{{ url('job-action') }}/" + id,
                data: data,
                dataType: "json",
                success: function(response) {
                    LoaderHide();
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
                }
            });
            return false;
        }
    });
}

// ===========================================
// FORM VALIDATION
// ============================================

let validator_job_form = $("#job-form").validate({
    ignore: [],
    rules: {
        job_category_id: {
            required: true
        },
        job_sub_category_id: {
            required: true
        },
        job_title: {
            required: true
        },
        job_minimum_qualification: {
            required: true
        },
        job_level: {
            required: true
        },
        job_type: {
            required: true
        },
        job_work_type: {
            required: true
        },
        job_number_of_openings: {
            required: true,
            digits: true,
            min: 1
        },
        job_description: {
            required: true
        },
        gender: {
            required: true
        },
        job_timing: {
            required: true
        },
        job_age: {
            required: true
        },
        job_interviewer_address: {
            required: true
        },
        job_experience_required: {
            required: true
        },
        job_contact_number: {
            required: true,
            digits: true,
            minlength: 10,
            maxlength: 15
        },

        job_state_id: {
            required: true
        },
        job_city_id: {
            required: true
        },
        job_area_id: {
            required: true
        },
        job_zipcode: {
            required: true
        },
        job_company_address: {
            required: true
        },
        job_hr_email: {
            required: true,
            email: true
        },
        hr_contact_no: {
            required: true,
            digits: true,
            minlength: 10,
            maxlength: 15
        }
    },
    messages: {
        job_category_id: {
            required: "Please select a job category"
        },
        job_sub_category_id: {
            required: "Please select a job sub-category"
        },
        job_title: {
            required: "Please enter the job title"
        },
        job_minimum_qualification: {
            required: "Please select the minimum qualification"
        },
        job_level: {
            required: "Please select the job level"
        },
        job_type: {
            required: "Please select the job type"
        },
        job_work_type: {
            required: "Please select the work type"
        },
        job_number_of_openings: {
            required: "Please enter the number of openings",
            digits: "Only numeric values allowed",
            min: "There must be at least 1 opening"
        },
        job_description: {
            required: "Please enter the job description"
        },
        gender: {
            required: "Please select candidate gender"
        },
        job_timing: {
            required: "Please select candidate job timing"
        },
        job_age: {
            required: "Please select candidate Age"
        },
        job_interviewer_address: {
            required: "Please enter the interviewer address"
        },
        job_experience_required: {
            required: "Please select required experience"
        },
        job_contact_number: {
            required: "Please enter a contact number",
            digits: "Only numbers are allowed",
            minlength: "Contact number must be at least 10 digits",
            maxlength: "Contact number cannot exceed 15 digits"
        },

        job_company_address: {
            required: "Please enter the company address"
        },
        job_state_id: {
            required: "Please select a state"
        },
        job_city_id: {
            required: "Please select a city"
        },
        job_area_id: {
            required: "Please select an area"
        },
        job_zipcode: {
            required: "Please enter a valid zipcode"
        },
        job_hr_email: {
            required: "Please enter HR email",
            email: "Please enter a valid email address"
        },
        job_hr_contact_no: {
            required: "Please enter HR contact number",
            digits: "Only numbers are allowed",
            minlength: "HR contact number must be at least 10 digits",
            maxlength: "HR contact number cannot exceed 15 digits"
        },
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

// ===========================================
// FORM SUBMISSION
// ============================================

$("#job-form").submit(function(e) {
    e.preventDefault();

    $("#job_description").val(quill.root.innerHTML.trim());

    if (!$("#job-form").valid()) {
        return;
    }

    let form = $(this);
    let formData = form.serialize();


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var flag = $("#flag").val();
    var id = $("#row_id").val();
    var type = "";
    var url = "";
    
    if (flag == "A") {
        url = "{{ route('job-action.store') }}";
        type = "POST";
    } else {
        url = "{{ url('job-action') }}/" + id;
        type = "PATCH";
    }

    LoaderShow();

    $.ajax({
        type: type,
        url: url,
        data: formData,
        success: function(response) {
            LoaderHide();
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
            LoaderHide();
            console.log(xhr.responseText);
            alert(response.message);
        }
    });
});

function SelectJObAreaBox(areaId, areaName) {
            // Set the selected area name in the visible input
            $('#job_area_id').val(areaName);

            // Set the selected area ID in the hidden input
            $('#job_area_id_hidden').val(areaId);

            // Optionally, you can hide suggestions or add visual feedback here
            $('#JobAreaSuggestBox').empty(); // Clears badges if needed
        }
        document.addEventListener("DOMContentLoaded", function() {
            const zipcodeInput = document.getElementById("job_zipcode");

            // Trigger on 'change' or 'Enter key press'
            zipcodeInput.addEventListener("change", handleZipcodeLookup);
            zipcodeInput.addEventListener("keypress", function(e) {
                if (e.key === "") {
                    e.preventDefault(); // Prevent form submit if inside a form
                    handleZipcodeLookup();
                }
            });

            function handleZipcodeLookup() {
                $("#job_state_id_hidden").val("");
                $("#job_state_id").val("");

                $("#job_city_id_hidden").val("");
                $("#job_city_id").val("");

                $("#job_area_id_hidden").val("");
                $("#job_area_id").val("");

                // $("#job_pincode_id_hidden").val("");
                // $("#job_zipcode").val("");



                const zipcode = zipcodeInput.value.trim();

                if (zipcode == '') {
                    alert("Please enter a Zipcode.");
                    return;
                }

                const data = {
                    zipcode: zipcode
                };

                const url = "{{ route('check-location') }}"; // ✅ Correct usage

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(response) {
                        if (response.status === true) {
                            var location = response.data;
                            var areas = response.areas;

                            var AreaSuggestBadge = ''
                            areas.forEach(val => {
                                AreaSuggestBadge += `<span class="badge-item me-1 mb-1"
                                onclick="SelectJObAreaBox(${val.area_id}, '${val.area_nm}')">
                            ${val.area_nm}
                         </span>`;
                            });

                            $("#JobAreaSuggestBox").append(AreaSuggestBadge);

                            $("#job_state_id_hidden").val(location.state_id);
                            $("#job_state_id").val(location.state_name);

                            $("#job_city_id_hidden").val(location.city_id);
                            $("#job_city_id").val(location.city_nm);

                            $("#job_area_id_hidden").val(location.area_id);
                            $("#job_area_id").val(location.area_nm);

                            $("#job_pincode_id_hidden").val(location.zipcode_id);
                            $("#job_zipcode").val(location.zipcode);

                        }
                    },
                    error: function(xhr) {
                        // console.error(xhr.responseText);
                        let errorMsg = "Something went wrong";
                        try {
                            const res = JSON.parse(xhr.responseText);
                            errorMsg = res.message || errorMsg;
                        } catch (e) {}
                        alert(errorMsg);
                    }
                });
            }
        });
// ===========================================
// DOM READY - INITIALIZATION
// ============================================

$(document).ready(function() {
    // Initialize job type selection when page loads
    setTimeout(function() {
        SelectJobType('Non-Skilled');
    }, 500);

    $('#job_category_id').on('change', function() {
        let category_id = $(this).val();

        if (!category_id) {
            $('#job_sub_category_id').html('<option value="">-- Select Sub Category --</option>');
            return;
        }

        let data = {
            category_id: category_id
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('sub-category-action') }}",
            data: data,
            dataType: "json",
            success: function(response) {
                if (response.status === 1) {
                    let subcategory = response.data;

                    let optionHtml = `<option value="">Select Sub Category</option>`;
                    subcategory.forEach(val => {
                        optionHtml +=
                            `<option value="${val.sub_category_id}">${val.sub_category_nm}</option>`;
                    });

                    $("#job_sub_category_id").html(optionHtml);
                } else {
                    $("#job_sub_category_id").html(
                        '<option value="">No Sub Category Found</option>');
                }
            },
            error: function() {
                $("#job_sub_category_id").html(
                    '<option value="">Error loading subcategories</option>');
            }
        });
    });

    $('#job_sub_category_id').on('change', function() {
        let category_id = $("#job_category_id").val();
        let sub_category_id = $("#job_sub_category_id").val();

        $('#multiSelectDropdown').html("");
        $("#multiSelectBtn").html("<span class='placeholder'>Choose Skills</span>");

        if (!sub_category_id) return;

        // Prepare request data
        let data = {
            sub_category_id: sub_category_id,
            category_id: category_id
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('skill-fetch-action') }}",
            data: data,
            dataType: "json",
            success: function(response) {
                if (response.status === 1) {
                    let skillData = response.data;
                    skillData.forEach(item => {
                        if (item.skill_nm) {
                            let skills = item.skill_nm.split(',');
                            window.skills_arr = skills;
                        }
                    });
                }
            },
            error: function() {
                // Error handling
            }
        });
    });

    let selectedCategory = $('#job_category_id').val();
    if (selectedCategory) {
        $('#job_category_id').trigger('change');
    }

    $(document).on('click', '.remove-skill', function() {
        const skillToRemove = $(this).data('skill');
        let skills = $('#skills_hidden').val().split(',');

        // Remove the clicked skill
        skills = skills.filter(skill => skill.trim().toLowerCase() !== skillToRemove.trim()
            .toLowerCase());

        // Update hidden input
        $('#skills_hidden').val(skills.join(','));

        // Remove the visual badge
        $(this).closest('a').remove();
    });
});

// ===========================================
// ADDITIONAL FUNCTIONS
// ============================================

// ⭐ Function to open document
window.openDocument = function(url) {
    window.open(url, '_blank');
};

// ⭐ Remove newly chosen file
window.removeFile = function() {
    document.getElementById('fileInput').value = '';
    document.getElementById('filePreview').style.display = 'none';
};

// ⭐ REMOVE EXISTING FILE — FIXED
window.removeExistingFile = function() {
    const existingPreview = document.querySelector('.existing-file-preview');
    if (existingPreview) {
        existingPreview.style.display = 'none'; // hide box
    }

    let removeField = document.getElementById('removeExistingFile');
    if (removeField) {
        removeField.value = '1'; // tell backend remove file
    }

    // file must be uploaded again
    document.getElementById('fileInput').required = true;
    showToast("Existing document removed. Please upload a new document.");
};

// ⭐ File Input Change — New Preview Show
document.getElementById('fileInput')?.addEventListener('change', function() {
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');

    if (this.files.length > 0) {
        fileName.textContent = this.files[0].name;
        filePreview.style.display = 'block';

        // Hide existing preview
        const existingPreview = document.querySelector('.existing-file-preview');
        if (existingPreview) {
            existingPreview.style.display = 'none';
        }

        // Set removal flag
        let removeField = document.getElementById('removeExistingFile');
        if (removeField) removeField.value = '1';
    } else {
        filePreview.style.display = 'none';
    }
});

// ⭐ Form Validation
document.getElementById('kycForm')?.addEventListener('submit', function(e) {
    const title = document.querySelector('select[name="title"]').value;
    const fileInput = document.getElementById('fileInput');
    const hasExistingFile = {{ isset($CompanyKycData[0]) && $CompanyKycData[0]->document ? 'true' : 'false' }};
    const removeExisting = document.getElementById('removeExistingFile')?.value == "1";

    if (!title) {
        e.preventDefault();
        showToast("Please select document type", "error");
        return;
    }

    if (!hasExistingFile && !fileInput.files.length) {
        e.preventDefault();
        showToast("Please upload a document", "error");
        return;
    }
});

$("#company-about-form").submit(function(e) {
    e.preventDefault();

    if (!$(this).valid()) {
        return;
    }

    let form = this;
    let formData = new FormData(form);
    let url = "{{ route('admin.company-profile-about-update') }}";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    LoaderShow()

    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            LoaderHide()
            if (response.status === 1) {
                toastr.success(response.message, 'Success');
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                toastr.error(response.message, 'Error');
            }
        },
        error: function(xhr) {
            LoaderHide()
            console.log(xhr.responseText);
            let errorMsg = "Something went wrong";
            try {
                const res = JSON.parse(xhr.responseText);
                errorMsg = res.message || errorMsg;
            } catch (e) {}
            console.log(errorMsg)
        }
    });
});

let validator = $("#company-profile-form").validate({
    rules: {
        company_nm: {
            required: true
        },
        email: {
            required: true
        },
        contact_no: {
            required: true
        },
        state_id: {
            required: true
        },
        city_id: {
            required: true
        },
        zipcode: {
            required: true
        },
        address: {
            required: true
        },
    },
    messages: {
        company_nm: {
            required: "Please Enter Company Name"
        },
        email: {
            required: "Please Enter Email Address"
        },
        contact_no: {
            required: "Please Enter Contact No."
        },
        state_id: {
            required: "Please Enter State"
        },
        city_id: {
            required: "Please Enter City"
        },
        zipcode: {
            required: "Please Enter Zipcode"
        },
        address: {
            required: "Please Enter Address"
        },
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

$("#company-profile-form").submit(function(e) {
    e.preventDefault();

    if (!$(this).valid()) {
        return;
    }

    let form = this;
    let formData = new FormData(form);
    let url = "{{ route('admin.company-profile-update') }}";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    LoaderShow()

    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            LoaderHide()
            if (response.status === 1) {
                toastr.success(response.message, 'Success');
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                toastr.error(response.message, 'Error');
            }
        },
        error: function(xhr) {
            LoaderHide()
            console.log(xhr.responseText);
            let errorMsg = "Something went wrong";
            try {
                const res = JSON.parse(xhr.responseText);
                errorMsg = res.message || errorMsg;
            } catch (e) {}
            console.log(errorMsg)
        }
    });
});

// Profile functions
function EditprofileDetails() {
    document.getElementById("DetailsViewProfile").style.display = "none";
    document.getElementById("DetailsEditProfile").style.display = "block";
}

function BackToprofileDetails() {
    document.getElementById("DetailsViewProfile").style.display = "block";
    document.getElementById("DetailsEditProfile").style.display = "none";
}

// About functions
function EditAboutAndSkill() {
    document.getElementById("AboutAndSkillView").style.display = "none";
    document.getElementById("AboutAndSkillEdit").style.display = "block";
}

function BackToAboutAndSkillView() {
    document.getElementById("AboutAndSkillView").style.display = "block";
    document.getElementById("AboutAndSkillEdit").style.display = "none";
}

// Tab persistence
document.addEventListener("DOMContentLoaded", function() {
    // Activate the last active tab from localStorage
    const lastTab = localStorage.getItem('activeCandidateTab');
    if (lastTab) {
        let triggerEl = document.querySelector(`button[data-bs-target="${lastTab}"]`);
        if (triggerEl) {
            let tabTrigger = new bootstrap.Tab(triggerEl);
            tabTrigger.show();
        }
    }

    // Save the currently clicked tab to localStorage
    const tabButtons = document.querySelectorAll(".menu-bar .nav-link");
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function(event) {
            const activeTabTarget = event.target.getAttribute('data-bs-target');
            localStorage.setItem('activeCandidateTab', activeTabTarget);
        });
    });
});
</script>
@endpush