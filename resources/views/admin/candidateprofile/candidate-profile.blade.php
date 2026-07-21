@push('css')
    <style>
        #AboutAndSkillEdit {
            display: none;
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

        #Skillsuggestions {
            display: none;
        }

        .btn-grey-small {
            background-color: #EFF3FC;
            font-size: 12px;
            padding: 7px 10px;
            border-radius: 5px;
            color: #4F5E64 !important;
            margin-right: 12px;
        }

        .btn-grey-small:hover {
            background-color: #EFF3FC !important;
            font-size: 12px;
            padding: 7px 10px;
            border-radius: 5px;
            color: #4F5E64 !important;
            margin-right: 12px;
        }



        .work-desc {
            font-size: 15px;
            line-height: 27px;
            font-weight: 500;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 5;
            -webkit-box-orient: vertical;
        }

        #EducationEdit {
            display: none;
        }

        #WorkExperienceEdit {
            display: none;
        }
    </style>
@endpush


@extends('admin.layout.layout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">


        <div class="row">
            @if ($CandidateProfileComplete != 100)
                <div class="col-lg-12">
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        Your profile is {{ $CandidateProfileComplete }}% complete. Complete your profile to unlock a better
                        and more personalized experience.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <div class="col-xl-12">
                <div class="nav-align-top mb-6 ">
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
                                data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages"
                                aria-selected="false">
                                Work Experience
                            </button>
                        </li>

                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-education" aria-controls="navs-pills-top-education"
                                aria-selected="false">
                                Education
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
                                data-bs-target="#navs-pills-top-save-jobs" aria-controls="navs-pills-top-save-jobs"
                                aria-selected="false">
                                Saved Jobs
                            </button>
                        </li>

                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-membership-history"
                                aria-controls="navs-pills-top-membership-history" aria-selected="false">
                                Membership History
                            </button>
                        </li>
                    </ul>


                    <div class="tab-content box-option">
                        <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-6">
                                    <h4 style="font-size: 20px;font-weight:600;color: #242a62;" class="mb-0"><i
                                            class="bx bx-user"></i> Candidates Profile</h4>
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
                                            src="{{ $userData->cover_img ? asset('uploads/profile/' . $userData->cover_img) : asset('uploads/profile/candidate.jpeg') }}"
                                            alt="jobbox" height="300">
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
                                            @if (!empty($userData->resume_nm))
                                                <div class="col-lg-6 col-md-12 text-lg-end"><a
                                                        class="btn btn-preview-icon btn-apply btn-apply-big m-1"
                                                        href="{{ asset('storage/' . $userData->resume_nm) }}">View
                                                        Resume</a></div>
                                            @endif
                                        </div>
                                    </div>
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
                                                                            <label
                                                                                class="user-info-label mb-0">Email</label>
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
                                                                            <label
                                                                                class="user-info-label mb-0">State</label>
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
                                                                            <label
                                                                                class="user-info-label mb-0">City</label>
                                                                            <p class="user-info-value mb-0">
                                                                                {{ $userData->city_nm }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif



                                                            @if ($userData->area_nm)
                                                                <!-- City -->
                                                                <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                                    <div class="d-flex align-items-center">
                                                                        <img src="{{ asset('admin-assets/img/area.png') }}"
                                                                            alt="City Icon"
                                                                            style="width: 24px; height: 24px; margin-right: 10px;" />
                                                                        <div>
                                                                            <label
                                                                                class="user-info-label mb-0">Area</label>
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
                                                                            <label
                                                                                class="user-info-label mb-0">Address</label>
                                                                            <p class="user-info-value mb-0">
                                                                                {{ $userData->address }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div id="DetailsEditProfile">
                                                        <form id="candidate-profile-form" onsubmit="return false;">
                                                            <a href="javascript:void(0)"
                                                                class="position-absolute top-0 end-0 m-3 btn btn-sm btn-primary"
                                                                onclick="BackToprofileDetails()"><i
                                                                    class="fa fa-long-arrow-left" aria-hidden="true"></i>
                                                                &nbsp; Back</a>
                                                            <div class="row">
                                                                <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                                    <label for="nameBackdrop"
                                                                        class="form-label mb-2">Designation <span
                                                                            class="color-red">*</span></label>
                                                                    <input type="text" id="designation"
                                                                        name="designation" class="form-control"
                                                                        placeholder="Enter Email"
                                                                        value="{{ $userData->designation }}">
                                                                </div>
                                                                <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                                    <label for="nameBackdrop" class="form-label mb-2">Full
                                                                        Name <span class="color-red">*</span></label>
                                                                    <input type="text" id="full_name" name="full_name"
                                                                        class="form-control" placeholder="Enter Email"
                                                                        value="{{ $userData->name }}">
                                                                </div>
                                                                <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                                    <label for="nameBackdrop"
                                                                        class="form-label mb-2">Email <span
                                                                            class="color-red">*</span></label>
                                                                    <input type="text" id="email" name="email"
                                                                        class="form-control" placeholder="Enter Email"
                                                                        value="{{ $userData->email }}">
                                                                </div>
                                                                <!-- Contact Number -->
                                                                <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                                    <label for="nameBackdrop"
                                                                        class="form-label mb-2">Contact
                                                                        Number <span class="color-red">*</span></label>
                                                                    <input type="text" id="contact_no"
                                                                        name="contact_no" class="form-control"
                                                                        placeholder="Enter Contact Number"
                                                                        value="{{ $userData->contact_no }}">
                                                                </div>

                                                                <!-- Personal Website -->
                                                                <div class="col-lg-3 col-md-4 col-6 mb-5">
                                                                    <label for="nameBackdrop"
                                                                        class="form-label mb-2">Personal
                                                                        Website </label>
                                                                    <input type="text" id="personal_website"
                                                                        name="personal_website" class="form-control"
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
                                                                        <input class="form-control" id="city_id"
                                                                            type="text" required="" name="city_id"
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
                                                                        <input class="form-control" id="area_id"
                                                                            type="text" required="" name="area_id"
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
                                                                        <input class="form-control" id="zipcode"
                                                                            type="text" required="" name="zipcode"
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
                                                                        class="form-label mb-2">Address <span
                                                                            class="color-red">*</span></label>
                                                                    <textarea name="address" class="form-control" id="address">{{ $userData->address }}</textarea>
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
                                                            {{ $userData->about }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="divider">
                                                    <div class="divider-text"></div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <h6 class="mb-0">Category</h6>
                                                        <p>
                                                            {{ $userData->category_nm }}
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <h6 class="mb-0">Sub Category</h6>
                                                        <p>
                                                            {{ $userData->sub_category_nm }}
                                                        </p>
                                                    </div>
                                                </div>
                                                @php
                                                    $skills = [];

                                                    if (!empty($userData->skills_id)) {

                                                        $decoded = json_decode($userData->skills_id, true);

                                                        // If still string → decode again (double encoded case)
                                                        if (is_string($decoded)) {
                                                            $decoded = json_decode($decoded, true);
                                                        }

                                                        if (is_array($decoded)) {
                                                            $skills = $decoded;
                                                        }
                                                    }
                                                @endphp
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h4>Skill</h4>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        @if (!empty($skills))
                                                            @foreach ($skills as $skill)
                                                                <span class="badge bg-label-secondary me-1 mb-1">
                                                                    {{ $skill }}
                                                                </span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">No skills added</span>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>


                                            <div id="AboutAndSkillEdit">
                                                <form id="candidate-about-skill-form" onsubmit="return false;">
                                                    <a href="javascript:void(0)" onclick="BackToAboutAndSkillView()"
                                                        class="position-absolute top-0 end-0 m-3 btn btn-sm btn-primary"><i
                                                            class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;
                                                        Back</a>
                                                    <div class="row mt-5">
                                                        <div class="col-lg-12 col-md-12 col-12">

                                                            <label for="nameBackdrop" class="form-label mb-2">About
                                                                us</label>
                                                            <textarea class="form-control" id="about" name="about" rows="3">{{ $userData->about }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="divider">
                                                        <div class="divider-text"></div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6 mb-3">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-1">Category
                                                                    *</label>
                                                                <select class="form-control" name="category_id"
                                                                    id="category_id">
                                                                    <option value="" selected>-Select Category-
                                                                    </option>
                                                                    @foreach ($CategoryData as $row)
                                                                        <option
                                                                            {{ $userData && $userData->category_id == $row->category_id ? 'selected' : '' }}
                                                                            value="{{ $row->category_id }}">
                                                                            {{ $row->category_nm }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-1">Sub Category
                                                                    *</label>
                                                                <select class="form-control" name="sub_category_id"
                                                                    id="sub_category_id">
                                                                    <option value="">-Select Category-</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $Skill = [];

                                                            if (!empty($userData->skills_id)) {
                                                                $decoded = json_decode($userData->skills_id, true);
                                                                $Skill = is_array($decoded) ? $decoded : [];
                                                            }
                                                        @endphp

                                                        <div class="form-contact">
                                                            <div class="form-group">
                                                                <input class="form-control search-icon" id="skill_id"
                                                                    name="skill_id" type="text"
                                                                    placeholder="E.g. Angular, Laravel..."
                                                                    autocomplete="off" autocorrect="off"
                                                                    autocapitalize="off">

                                                                <div id="Skillsuggestions" class="suggestions"></div>

                                                                <input type="hidden" name="skills_hidden"
                                                                    id="skills_hidden"
                                                                    value="{{ implode(',', $Skill) }}">
                                                            </div>
                                                        </div>

                                                        <div class="box-tags mt-5 mb-5">
                                                            @foreach ($Skill as $row)
                                                                <a class="btn btn-grey-small skill-tag">
                                                                    {{ $row }}
                                                                    <span class="close-icon remove-skill fa fa-times"
                                                                        data-skill="{{ $row }}"></span>
                                                                </a>
                                                            @endforeach
                                                        </div>

                                                        {{-- @php
                                                            $Skill = $userData
                                                                ? json_decode($userData->skills_id, true)
                                                                : [];
                                                        @endphp

                                                        <div class="form-contact">
                                                            <div class="form-group">
                                                                <input class="form-control search-icon" id="skill_id"
                                                                    name="skill_id" type="text" value=""
                                                                    placeholder="E.g. Angular, Laravel..."
                                                                    autocomplete="off" autocorrect="off"
                                                                    autocapitalize="off">
                                                                <div id="Skillsuggestions" class="suggestions"></div>
                                                                <input type="hidden" name="skills_hidden"
                                                                    id="skills_hidden"
                                                                    value="{{ implode(',', $Skill) }}">
                                                            </div>
                                                        </div>

                                                        <div class="box-tags mt-5 mb-5">
                                                            @foreach ($Skill as $row)
                                                                <a class="btn btn-grey-small skill-tag">{{ $row }}<span
                                                                        class="close-icon remove-skill fa fa-times"
                                                                        data-skill="{{ $row }}"></span></a>
                                                            @endforeach
                                                        </div> --}}

                                                        <div class="col-lg-12 col-md-12 col-12 mb-5">
                                                            <input type="hidden" id="_method" name="_method"
                                                                value="POST">
                                                            <input type="hidden" id="user_id" name="user_id"
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

                        <div class="tab-pane fade" id="navs-pills-top-messages" role="tabpanel">
                            <div id="WorkExperienceView">
                                <div class="row">
                                    @if (count($WorkExperienceData) > 0)
                                        @foreach ($WorkExperienceData as $row)
                                            <div class="col-lg-6">
                                                <div class="card p-0 mb-6 position-relative">
                                                    <!-- Edit Button Positioned Top-Right -->
                                                    <a href="javascript:void(0)"
                                                        onclick="EditWorkExperience({{ $row->id }})"
                                                        class="position-absolute top-0 end-0 m-3 btn btn-sm btn-primary"><i
                                                            class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Edit</a>

                                                    <div class="card-body p-3">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-12">
                                                                <h4 style="font-weight: 600;">{{ $row->title }}</h4>
                                                                <p class="mb-2" style="font-weight: 600;">
                                                                    {{ $row->company }} - {{ $row->work_type_name }}</p>
                                                                <p class="mb-2" style="font-weight: 600;">
                                                                    {{ date('M Y', strtotime($row->start_date)) }}
                                                                    -
                                                                    {{ $row->end_date ? date('M Y', strtotime($row->end_date)) : 'Present' }}
                                                                    {{ $row->end_date ? date_diff(date_create($row->start_date), date_create($row->end_date))->format('%y yr %m mon') : '' }}
                                                                </p>
                                                                <p class="mb-2" style="font-weight: 600;">
                                                                    {{ $row->location }} - {{ $row->job_type_name }}</p>
                                                                <p class="work-desc">
                                                                    {!! nl2br(e($row->role_responsibility)) !!}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-xl-12 col-12">
                                            <h4 style="text-align: center;background: #eee;padding: 23px;">Work
                                                Experience Not
                                                Found</h4>
                                        </div>
                                    @endif


                                </div>
                            </div>

                            <div id="WorkExperienceEdit">
                                <form id="candidate-work-experience-form" onsubmit="return false;">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card p-0 mb-6 position-relative">
                                                <!-- Edit Button Positioned Top-Right -->
                                                <a href="javascript:void(0)" onclick="BackToWorkExperienceView()"
                                                    class="position-absolute top-0 end-0 m-3 btn btn-sm btn-primary"><i
                                                        class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;
                                                    Back</a>

                                                <div class="card-body p-3">
                                                    <div class="row mt-5">
                                                        <div class="col-lg-3 col-md-12 col-12 mb-5">
                                                            <label for="nameBackdrop"
                                                                class="form-label mb-2">Title</label>
                                                            <input type="text" class="form-control" id="title"
                                                                name="title" placeholder="Enter Title">
                                                        </div>

                                                        <div class="col-lg-3 col-md-12 col-12 mb-5">
                                                            <label for="employment_type"
                                                                class="form-label mb-2">Employment
                                                                type</label>
                                                            <select name="employment_type" id="employment_type"
                                                                class="form-control">
                                                                <option value="" selected>-Select Employment-
                                                                </option>
                                                                @foreach ($WorktypeData as $row)
                                                                    <option value="{{ $row->work_type_id }}">
                                                                        {{ $row->type_nm }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-6 col-md-12 col-12 mb-5">
                                                            <label for="nameBackdrop" class="form-label mb-2">Company or
                                                                organization</label>
                                                            <input type="text" class="form-control" id="company_name"
                                                                name="company_name"
                                                                placeholder="Enter Company or organization">
                                                        </div>
                                                        <div class="col-lg-12 mt-3 mb-3">
                                                            <div class="box-agree">
                                                                <label class="lbl-agree font-xs color-text-paragraph-2"
                                                                    style=" font-size: 14px!important;">
                                                                    <input class="lbl-checkbox" type="checkbox"
                                                                        id="currently_working" name="currently_working">I
                                                                    am currently working in this role
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3 col-md-12 col-12 mb-5">
                                                            <label for="nameBackdrop" class="form-label mb-2">Start
                                                                date</label>
                                                            <input type="date" class="form-control" id="start_date"
                                                                name="start_date">
                                                        </div>

                                                        <div class="col-lg-3 col-md-12 col-12 mb-5">
                                                            <label for="nameBackdrop" class="form-label mb-2">End
                                                                date</label>
                                                            <input type="date" class="form-control" id="end_date"
                                                                name="end_date">
                                                        </div>


                                                        <div class="col-lg-3 col-md-12 col-12 mb-5">
                                                            <label for="nameBackdrop"
                                                                class="form-label mb-2">Location</label>
                                                            <input type="text" class="form-control" id="location"
                                                                name="location" placeholder="Enter Location">
                                                        </div>

                                                        <div class="col-lg-3 col-md-12 col-12 mb-5">
                                                            <label for="nameBackdrop" class="form-label mb-2">Location
                                                                type</label>
                                                            <select name="location_type" id="location_type"
                                                                class="form-control">
                                                                <option value="" selected>-Select Location-</option>
                                                                @foreach ($JobtypeData as $row)
                                                                    <option value="{{ $row->job_type_id }}">
                                                                        {{ $row->type_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-lg-12 col-md-12 col-12 mb-5">
                                                            <label for="nameBackdrop" class="form-label mb-2">Role and
                                                                Responsibility</label>
                                                            <textarea class="form-control" id="role_responsibility" name="role_responsibility" rows="3"></textarea>
                                                        </div>

                                                        <div class="col-lg-12 col-md-12 col-12 mb-5">
                                                            <input type="hidden" id="work_exp_row_id"
                                                                name="work_exp_row_id">
                                                            <input type="hidden" id="flag" name="flag">
                                                            <input type="hidden" id="_method" name="_method"
                                                                value="POST">
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>



                        <div class="tab-pane fade" id="navs-pills-top-education" role="tabpanel">
                            <div id="EducationView">
                                <div class="row">
                                    @if (count($EducationData) > 0)
                                        @foreach ($EducationData as $row)
                                            <div class="col-lg-6">
                                                <div class="card p-0 mb-6 position-relative">
                                                    <!-- Edit Button Positioned Top-Right -->
                                                    <a href="javascript:void(0)"
                                                        onclick="EditEducation({{ $row->id }})"
                                                        class="position-absolute top-0 end-0 m-3 btn btn-sm btn-primary"><i
                                                            class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Edit</a>

                                                    <div class="card-body p-3">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-12">
                                                                <h4 style="font-weight: 600;">{{ $row->school_name }}</h4>
                                                                <p class="mb-2" style="font-weight: 600;">
                                                                    {{ $row->degree }} - {{ $row->field_of_study }}
                                                                </p>
                                                                {{-- <p class="mb-2" style="font-weight: 600;">
                                                                    {{ $row->start_date }} - {{ $row->end_date }}
                                                                </p> --}}
                                                                 <p class="mb-2" style="font-weight: 600;">
                                                                    {{ $row->end_date }}
                                                                </p>
                                                                <p>
                                                                    {{ $row->description }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-xl-12 col-12">
                                            <h4 style="text-align: center;background: #eee;padding: 23px;">
                                                Education
                                                Not Found</h4>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div id="EducationEdit">
                                <form id="candidate-education-form" onsubmit="return false;">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card p-0 mb-6 position-relative">
                                                <!-- Edit Button Positioned Top-Right -->
                                                <a href="javascript:void(0)" onclick="BackToEducationView()"
                                                    class="position-absolute top-0 end-0 m-3 btn btn-sm btn-primary"><i
                                                        class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;
                                                    Back</a>

                                                <div class="card-body p-3">
                                                    <div class="row mt-5">
                                                        <div class="col-lg-4 col-md-12 col-12 mb-5">
                                                            <label for="nameBackdrop"
                                                                class="form-label mb-2">School</label>
                                                            <input type="text" class="form-control" id="school_name"
                                                                name="school_name" placeholder="Enter School Name">
                                                        </div>

                                                        <div class="col-lg-4 col-md-12 col-12 mb-5">
                                                            <label for="nameBackdrop" class="form-label mb-2">Degree
                                                            </label>
                                                            <input type="text" class="form-control" id="degree_name"
                                                                name="degree_name" placeholder="Enter Degree Name">
                                                        </div>

                                                        <div class="col-lg-4 col-md-12 col-12 mb-5">
                                                            <label for="nameBackdrop" class="form-label mb-2">Field of
                                                                study</label>
                                                            <input type="text" class="form-control"
                                                                id="field_of_study" name="field_of_study"
                                                                placeholder="Enter Field of study">
                                                        </div>


                                                        <div class="col-lg-4 col-md-12 col-12 mb-5">
                                                            <label for="nameBackdrop"
                                                                class="form-label mb-2">Grade</label>
                                                            <input type="text" class="form-control" id="grade"
                                                                name="grade" placeholder="Enter Grade">
                                                        </div>
                                                        {{-- <div class="col-lg-4 col-md-12 col-12 mb-5">
                                                            <label for="nameBackdrop" class="form-label mb-2">Start
                                                                date</label>
                                                            <input type="date" class="form-control" id="start_date"
                                                                name="start_date">
                                                        </div>
                                                        <div class="col-lg-4 col-md-12 col-12 mb-5">
                                                            <label for="nameBackdrop" class="form-label mb-2">End
                                                                date</label>
                                                            <input type="date" class="form-control" id="end_date"
                                                                name="end_date">
                                                        </div> --}}
                                                        <div class="col-lg-4 col-md-12 col-12 mb-5">
                                                            <label class="form-label mb-2">Passing Year</label>
                                                            <select class="form-control" id="end_date" name="end_date">
                                                                <option value="">Select Year</option>
                                                                @for ($year = date('Y'); $year >= 1980; $year--)
                                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>



                                                        <div class="col-lg-12 col-md-12 col-12 mb-5">
                                                            <label for="nameBackdrop"
                                                                class="form-label mb-2">Description</label>
                                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                                        </div>

                                                        <div class="col-lg-12 col-md-12 col-12 mb-5">
                                                            <input type="hidden" id="education_row_id"
                                                                name="education_row_id">
                                                            <input type="hidden" id="flag" name="flag">
                                                            <input type="hidden" id="_method" name="_method"
                                                                value="POST">
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-my-jobs" role="tabpanel">
                            <div class="row">
                                @foreach ($MyjobData as $row)
                                    <div class="col-lg-4">
                                        <div class="card p-0 mb-6 position-relative">
                                            <!-- Edit Button Positioned Top-Right -->
                                            <a target="_blank"
                                                href="{{ route('job-detail', ['job_id' => $row->job_id]) }}"
                                                class="position-absolute top-0 end-0 m-3 btn btn-sm btn-secondary"><i
                                                    class="fa fa-eye" aria-hidden="true"></i>&nbsp; View</a>

                                            <div class="card-body p-3">
                                                <div class="row">

                                                    <div class="col-lg-12 col-md-12 col-12">
                                                        <h5 style="font-weight: 600;">{{ $row->job_title }}
                                                            @php
                                                                $statusMap = [
                                                                    0 => [
                                                                        'label' => 'Pending',
                                                                        'class' => 'bg-warning',
                                                                    ],
                                                                    1 => [
                                                                        'label' => 'Approved',
                                                                        'class' => 'bg-success',
                                                                    ],
                                                                    2 => [
                                                                        'label' => 'Rejected',
                                                                        'class' => 'bg-danger',
                                                                    ],
                                                                ];

                                                                $status = $statusMap[$row->status] ?? [
                                                                    'label' => 'Unknown',
                                                                    'class' => 'bg-secondary',
                                                                ];
                                                            @endphp

                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                                                                class="badge {{ $status['class'] }}"
                                                                style="font-size: 13px;">
                                                                {{ $status['label'] }}
                                                            </span></h5>
                                                        <p class="mb-2" style="font-weight: 600;"><span><i
                                                                    class="fa fa-briefcase" aria-hidden="true"></i>
                                                                &nbsp;{{ $row->work_type_name }}</span> &nbsp;&nbsp;
                                                            <span><i class="fa fa-clock" aria-hidden="true"></i>
                                                                &nbsp;{{ \Carbon\Carbon::parse($row->datetime)->diffForHumans() }}</span>
                                                        </p>
                                                        <p class="mb-2" style="font-weight: 600;"><i
                                                                class="fa fa-map-marker" aria-hidden="true"></i>
                                                            &nbsp;{{ $row->company_address }}</p>
                                                        @php
                                                            $Skill = $row->skill_id
                                                                ? json_decode($row->skill_id, true)
                                                                : [];
                                                        @endphp
                                                        @foreach ($Skill as $Skill_data)
                                                            <span
                                                                class="badge bg-label-secondary mx-1 mb-2">{{ $Skill_data }}</span>
                                                        @endforeach

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        <div class="tab-pane fade" id="navs-pills-top-save-jobs" role="tabpanel">
                            <div class="row">
                                @if (count($SaveJobData) > 0)
                                    @foreach ($SaveJobData as $row)
                                        <div class="col-lg-4">
                                            <div class="card p-0 mb-6 position-relative">
                                                <!-- Edit Button Positioned Top-Right -->
                                                <a href="javascript:void(0)" onclick="DeleteSaveJob({{ $row->id }})"
                                                    class="position-absolute top-0 end-0 m-3 btn btn-sm btn-danger"><i
                                                        class="fa fa-trash" aria-hidden="true"></i>&nbsp; Delete</a>

                                                <div class="card-body p-3">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-12">
                                                            <h5 style="font-weight: 600;">{{ $row->job_title }}</h5>
                                                            <p class="mb-2" style="font-weight: 600;"><span><i
                                                                        class="fa fa-briefcase" aria-hidden="true"></i>
                                                                    &nbsp;{{ $row->work_type_name }}</span> &nbsp;&nbsp;
                                                                <span><i class="fa fa-clock" aria-hidden="true"></i>
                                                                    &nbsp;{{ \Carbon\Carbon::parse($row->datetime)->diffForHumans() }}</span>
                                                            </p>
                                                            <p class="mb-2" style="font-weight: 600;"><i
                                                                    class="fa fa-map-marker" aria-hidden="true"></i>
                                                                &nbsp;{{ $row->company_address }}</p>


                                                            @php
                                                                $Skill = [];

                                                                if (!empty($row->skill_id)) {
                                                                    $decoded = json_decode($row->skill_id, true);
                                                                    $Skill = is_array($decoded) ? $decoded : [];
                                                                }
                                                            @endphp

                                                            @foreach ($Skill as $row)
                                                                <span
                                                                    class="badge bg-label-secondary mx-1">{{ $row }}</span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-xl-12 col-12">
                                        <h4 style="text-align: center;background: #eee;padding: 23px;">
                                            Job Not Found</h4>
                                    </div>
                                @endif

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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->



@endsection


@push('script')
    <script>
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
    <script>
        function DeleteSaveJob(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to Remove this job?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, confirm!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                }
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

                    LoaderShow()

                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.candidate-remove-job') }}",
                        data: data,
                        dataType: "json",
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
                        }
                    });
                    return false;
                }
            });

        }
    </script>
    <script>
        let validatorEducation = $("#candidate-education-form").validate({
            rules: {
                school_name: {
                    required: true
                },
                degree_name: {
                    required: true
                },
                field_of_study: {
                    required: true
                },
                grade: {
                    required: true
                },
                start_date: {
                    required: false
                },
                end_date: {
                    required: true
                },
                description: {
                    required: true
                },
            },
            messages: {
                school_name: {
                    required: "Please Enter School Name"
                },
                degree_name: {
                    required: "Please Enter Degree Name"
                },
                field_of_study: {
                    required: "Please Enter Field Of Study"
                },
                grade: {
                    required: "Please Enter Grade"
                },
                // start_date: {
                //     required: "Please Select Start Date"
                // },
                end_date: {
                    required: "Please Select End Date"
                },
                description: {
                    required: "Please Enter Description"
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

        // ✅ Final submission with AJAX
        $("#candidate-education-form").submit(function(e) {
            e.preventDefault();

            if (!$("#candidate-education-form").valid()) {
                return;
            }

            let form = this; // Native DOM form
            let formData = new FormData(form); // FormData to include files if any

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var url = "{{ route('admin.candidate-education-update') }}";

            LoaderShow()

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false, // ✅ Important for FormData
                contentType: false, // ✅ Important for FormData
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
                }
            });
        });


        function EditEducation(id) {
            LoaderShow()
            $.ajax({
                url: `{{ url('education-action/${id}/edit') }}`, // Adjust route as needed
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    LoaderHide()
                    if (response.status === 1) {
                        const data = response.data;
                        // console.log(data);

                        // Fill form fields with response data
                        $('#school_name').val(data.school_name);
                        $('#degree_name').val(data.degree);
                        $('#field_of_study').val(data.field_of_study);
                        $('#grade').val(data.grade);
                         $('#end_date option').prop('selected', false);
                        $('#end_date option[value="' + data.end_date + '"]').prop('selected', true);
                        // if (data.start_date && data.end_date) {

                        //     $('#start_date').val(data.start_date).trigger('change');
                        //     $('#end_date').val(data.end_date).trigger('change');
                        // }
                        $('#description').val(data.description);


                        $("#education_row_id").val(data.id);
                        $("#flag").val("U");

                        document.getElementById("EducationView").style.display = "none";
                        document.getElementById("EducationEdit").style.display = "block";

                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function() {
                    LoaderHide()
                    toastr.error('Something went wrong.', 'Error');
                }
            });
        }
    </script>
    <script>
        let validatorWorkExp = $("#candidate-work-experience-form").validate({
            rules: {
                title: {
                    required: true
                },
                employment_type: {
                    required: true
                },
                company_name: {
                    required: true
                },
                start_date: {
                    required: true
                },
                end_date: {
                    required: {
                        depends: function(element) {
                            return !$('#currently_working').is(':checked'); // required if not checked
                        }
                    }
                },
                location: {
                    required: true
                },
                location_type: {
                    required: true
                },
                role_responsibility: {
                    required: true
                },
            },
            messages: {
                title: {
                    required: "Please Enter Title"
                },
                employment_type: {
                    required: "Please select employment type"
                },
                company_name: {
                    required: "Please enter company name"
                },
                start_date: {
                    required: "Please enter start date"
                },
                currently_working: {
                    required: "Please check if currently working"
                },
                location: {
                    required: "Please enter location"
                },
                location_type: {
                    required: "Please select location type"
                },
                role_responsibility: {
                    required: "Please enter role and responsibility"
                },
                end_date: {
                    required: "Please enter end date unless currently working"
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

        // ✅ Final submission with AJAX
        $("#candidate-work-experience-form").submit(function(e) {
            e.preventDefault();

            if (!$("#candidate-work-experience-form").valid()) {
                return;
            }

            let form = this; // Native DOM form
            let formData = new FormData(form); // FormData to include files if any

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            LoaderShow()
            var flag = $("#flag").val();

            var url = "{{ route('admin.candidate-work-experience-update') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false, // ✅ Important for FormData
                contentType: false, // ✅ Important for FormData
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
                }
            });
        });


        function EditWorkExperience(id) {
            LoaderShow()
            $.ajax({
                url: `{{ url('work-experience-action/${id}/edit') }}`, // Adjust route as needed
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    LoaderHide()
                    if (response.status === 1) {
                        const data = response.data;

                        // Fill form fields with response data
                        $('#title').val(data.title);
                        $('#employment_type').val(data.work_type_id).trigger('change');
                        $('#company_name').val(data.company);
                        $('#start_date').val(data.start_date);
                        $('#end_date').val(data.end_date ?? '');
                        $('#location').val(data.location);
                        $('#location_type').val(data.job_type_id).trigger('change');
                        $('#role_responsibility').val(data.role_responsibility);

                        // Handle checkbox
                        if (data.working_status == 1) {
                            $('#currently_working').prop('checked', true);
                            $('#end_date').prop('disabled', true);
                        } else {
                            $('#currently_working').prop('checked', false);
                            $('#end_date').prop('disabled', false);
                        }

                        $("#work_exp_row_id").val(data.id);
                        $("#flag").val("U");


                        document.getElementById("WorkExperienceView").style.display = "none";
                        document.getElementById("WorkExperienceEdit").style.display = "block";

                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function() {
                    LoaderHide()
                    toastr.error("Something went wrong", 'Error');
                }
            });
        }
    </script>
    <script>
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
                selectedSkills = existingSkills.split(',').map(s => s.trim());
                renderTags();
            }
        });

        function renderTags() {
            boxTags.innerHTML = '';
            selectedSkills.forEach(skill => {
                const tag = document.createElement('a');
                tag.className = 'btn btn-grey-small ';
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

        SkillSelect.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            Skillsuggestions.innerHTML = '';

            if (query.length === 0) {
                Skillsuggestions.style.display = 'none';
                return;
            }

            const filteredSkills = skills_arr.filter(skill =>
                skill.toLowerCase().includes(query)
            );

            if (filteredSkills.length > 0) {
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
                Skillsuggestions.style.display = 'none';
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

        function addSkill(skill) {
            if (!selectedSkills.includes(skill) && selectedSkills.length < 15) {
                selectedSkills.push(skill);
                renderTags();
            }
            SkillSelect.value = '';
            Skillsuggestions.innerHTML = '';
            Skillsuggestions.style.display = 'none';
        }

        $("#candidate-about-skill-form").submit(function(e) {
            e.preventDefault();

            if (!$(this).valid()) {
                return;
            }

            let form = this; // Native DOM form
            let formData = new FormData(form); // FormData to include files if any

            let url = "{{ route('admin.candidate-profile-about-skill-update') }}";

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
                processData: false, // ✅ Important for FormData
                contentType: false, // ✅ Important for FormData
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

                }
            });
        });



        $(document).ready(function() {

            $('#category_id').on('change', function() {
                let category_id = $("#category_id").val();


                if (!category_id) return;

                // Prepare request data
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

                            console.log(subcategory);

                            // Start with default option (corrected quotes)
                            let optionHtml = `<option value="">Select Sub Category</option>`;

                            // Append subcategory options
                            subcategory.forEach(val => {
                                optionHtml +=
                                    `<option value="${val.sub_category_id}">${val.sub_category_nm}</option>`;
                            });

                            // Populate dropdown
                            $("#sub_category_id").html(optionHtml);
                        } else {
                            $("#sub_category_id").html(
                                `<option value="">No Sub Category Found</option>`);
                        }
                    },
                    error: function() {
                        toastr.error('Something went wrong while fetching sub categories.',
                            'Error');
                    }
                });
            });

            $('#sub_category_id').on('change', function() {
                let category_id = $("#category_id").val();
                let sub_category_id = $("#sub_category_id").val();

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
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function() {
                        toastr.error('Something went wrong while fetching Skills.', 'Error');
                    }
                });
            });

            let selectedCategory = "{{ $userData->category_id ?? '' }}";
            let selectedSubCategory = "{{ $userData->sub_category_id ?? '' }}";

            if (selectedCategory) {
                $('#category_id').val(selectedCategory).trigger('change');
                $('#sub_category_id').val(selectedSubCategory);


                setTimeout(function() {
                    $('#sub_category_id').val(selectedSubCategory).trigger('change');
                }, 600); // Adjust delay to match AJAX
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
    </script>
    <script>
        let validator = $("#candidate-profile-form").validate({
            rules: {
                full_name: {
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
                full_name: {
                    required: "Please Enter Full Name"
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

        $("#candidate-profile-form").submit(function(e) {
            e.preventDefault();

            if (!$(this).valid()) {
                return;
            }

            let form = this; // Native DOM form
            let formData = new FormData(form); // FormData to include files if any

            let url = "{{ route('admin.candidate-profile-update') }}"; // Laravel route

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
                processData: false, // ⚠️ Required for FormData
                contentType: false, // ⚠️ Required for FormData
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

                    alert(errorMsg);
                }
            });
        });
    </script>
    <script>
        const states = @json($states); // contains [{ state_id: 1, state_name: "Rajasthan" }, ...]
        var cities = [];
        var areas = [];
        var pincodes = [];


        const StateSelect = document.getElementById('state_id');
        const suggestionsBox = document.getElementById('Statesuggestions');
        const stateIdhidden = document.getElementById('state_id_hidden');


        StateSelect.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            suggestionsBox.innerHTML = '';

            if (query.length === 0) {
                suggestionsBox.style.display = 'none';
                return;
            }

            const filteredStates = states.filter(state =>
                state.state_name.toLowerCase().includes(query)
            );

            if (filteredStates.length > 0) {
                suggestionsBox.style.display = 'block';
                filteredStates.forEach(state => {
                    const div = document.createElement('div');
                    div.classList.add('suggestion-item');
                    div.textContent = state.state_name;
                    div.addEventListener('click', () => {
                        StateSelect.value = state.state_name;
                        stateIdhidden.value = state.state_id;
                        suggestionsBox.innerHTML = '';
                        suggestionsBox.style.display = 'none';

                        var data = {
                            'state_id': state.state_id
                        }

                        let url = "{{ route('city-fetch-action') }}";

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            success: function(response) {
                                if (response.status === 1) {
                                    window.cities = response.data;


                                } else {
                                    toastr.error(response.message, 'Error');
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);

                                let errorMsg = "Something went wrong";
                                try {
                                    const res = JSON.parse(xhr.responseText);
                                    errorMsg = res.message || errorMsg;
                                } catch (e) {}
                            }
                        });
                    });
                    suggestionsBox.appendChild(div);
                });
            } else {
                suggestionsBox.style.display = 'none';
            }

            // Reset state_id on every input (if user types manually)
            stateIdhidden.value = '';
        });



        const CitySelect = document.getElementById('city_id'); // Text input
        const CitysuggestionsBox = document.getElementById('Citysuggestions'); // Suggestion box
        const CityIdhidden = document.getElementById('city_id_hidden'); // Hidden input for selected city_id


        CitySelect.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            CitysuggestionsBox.innerHTML = '';

            if (query.length === 0) {
                CitysuggestionsBox.style.display = 'none';
                return;
            }

            const filteredCities = cities.filter(city =>
                city.city_nm.toLowerCase().includes(query)
            );

            if (filteredCities.length > 0) {
                CitysuggestionsBox.style.display = 'block';
                filteredCities.forEach(city => {
                    const div = document.createElement('div');
                    div.classList.add('suggestion-item');
                    div.textContent = city.city_nm;
                    div.addEventListener('click', () => {
                        CitySelect.value = city.city_nm;
                        CityIdhidden.value = city.city_id;
                        CitysuggestionsBox.innerHTML = '';
                        CitysuggestionsBox.style.display = 'none';

                        var state_id = $("#state_id_hidden").val();

                        var data = {
                            'state_id': state_id,
                            'city_id': city.city_id,
                        }

                        let url = "{{ route('area-fetch-action') }}";

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            success: function(response) {
                                if (response.status === 1) {
                                    window.areas = response.data;
                                } else {
                                    toastr.error(response.message, 'Error');
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);

                                let errorMsg = "Something went wrong";
                                try {
                                    const res = JSON.parse(xhr.responseText);
                                    errorMsg = res.message || errorMsg;
                                } catch (e) {}
                            }
                        });
                    });
                    CitysuggestionsBox.appendChild(div);
                });
            } else {
                CitysuggestionsBox.style.display = 'none';
            }

            // Reset city_id if user types manually
            CityIdhidden.value = '';
        });


        const AreaSelect = document.getElementById('area_id'); // Text input
        const AreasuggestionsBox = document.getElementById('Areasuggestions'); // Suggestion box
        const AreaIdhidden = document.getElementById('area_id_hidden'); // Hidden input for selected city_id


        AreaSelect.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            AreasuggestionsBox.innerHTML = '';

            if (query.length === 0) {
                AreasuggestionsBox.style.display = 'none';
                return;
            }

            const filteredAreas = areas.filter(area =>
                area.area_nm.toLowerCase().includes(query)
            );

            if (filteredAreas.length > 0) {
                AreasuggestionsBox.style.display = 'block';
                filteredAreas.forEach(area => {
                    const div = document.createElement('div');
                    div.classList.add('suggestion-item');
                    div.textContent = area.area_nm;
                    div.addEventListener('click', () => {
                        AreaSelect.value = area.area_nm;
                        AreaIdhidden.value = area.area_id;
                        AreasuggestionsBox.innerHTML = '';
                        AreasuggestionsBox.style.display = 'none';

                        var state_id = $("#state_id_hidden").val();
                        var city_id = $("#city_id_hidden").val();

                        var data = {
                            'state_id': state_id,
                            'city_id': city_id,
                            'area_id': area.area_id
                        }

                        let url = "{{ route('pincode-fetch-action') }}";

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            success: function(response) {
                                if (response.status === 1) {
                                    window.pincodes = response.data;
                                } else {
                                    toastr.error(response.message, 'Error');
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);

                                let errorMsg = "Something went wrong";
                                try {
                                    const res = JSON.parse(xhr.responseText);
                                    errorMsg = res.message || errorMsg;
                                } catch (e) {}
                            }
                        });
                    });
                    AreasuggestionsBox.appendChild(div);
                });
            } else {
                AreasuggestionsBox.style.display = 'none';
            }

            // Reset city_id if user types manually
            AreaIdhidden.value = '';
        });


        const PincodeSelect = document.getElementById('zipcode'); // Text input
        const PincodeSuggestionsBox = document.getElementById('Pincodesuggestions'); // Suggestion box
        const PincodeIdHidden = document.getElementById('pincode_id_hidden'); // Hidden input

        PincodeSelect.addEventListener('input', function() {
            const query = this.value.trim();
            PincodeSuggestionsBox.innerHTML = '';

            if (query.length === 0 || !Array.isArray(window.areas)) {
                PincodeSuggestionsBox.style.display = 'none';
                return;
            }

            const filteredPincodes = pincodes.filter(pincode =>
                pincode.zipcode.includes(query)
            );

            if (filteredPincodes.length > 0) {
                PincodeSuggestionsBox.style.display = 'block';
                filteredPincodes.forEach(pincode => {
                    const div = document.createElement('div');
                    div.classList.add('suggestion-item');
                    div.textContent = pincode.zipcode;
                    div.addEventListener('click', () => {
                        PincodeSelect.value = pincode.zipcode;
                        PincodeIdHidden.value = pincode.zipcode_id;
                        PincodeSuggestionsBox.innerHTML = '';
                        PincodeSuggestionsBox.style.display = 'none';
                    });
                    PincodeSuggestionsBox.appendChild(div);
                });
            } else {
                PincodeSuggestionsBox.style.display = 'none';
            }

            // Reset hidden ID on manual input
            PincodeIdHidden.value = '';
        });

        // Optional: hide suggestions when clicked outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.autocomplete-container')) {
                PincodeSuggestionsBox.innerHTML = '';
                PincodeSuggestionsBox.style.display = 'none';

                AreasuggestionsBox.innerHTML = '';
                AreasuggestionsBox.style.display = 'none';

                CitysuggestionsBox.innerHTML = '';
                CitysuggestionsBox.style.display = 'none';

                suggestionsBox.innerHTML = '';
                suggestionsBox.style.display = 'none';
            }
        });


        // Profile
        function EditprofileDetails() {
            document.getElementById("DetailsViewProfile").style.display = "none";
            document.getElementById("DetailsEditProfile").style.display = "block";
        }

        function BackToprofileDetails() {
            document.getElementById("DetailsViewProfile").style.display = "block";
            document.getElementById("DetailsEditProfile").style.display = "none";
        }


        // About
        function EditAboutAndSkill() {
            document.getElementById("AboutAndSkillView").style.display = "none";
            document.getElementById("AboutAndSkillEdit").style.display = "block";
        }

        function BackToAboutAndSkillView() {
            document.getElementById("AboutAndSkillView").style.display = "block";
            document.getElementById("AboutAndSkillEdit").style.display = "none";
        }

        // Work Experience

        function EditWorkExperienceRow() {
            document.getElementById("WorkExperienceView").style.display = "none";
            document.getElementById("WorkExperienceEdit").style.display = "block";
        }

        function BackToWorkExperienceView() {
            document.getElementById("WorkExperienceView").style.display = "block";
            document.getElementById("WorkExperienceEdit").style.display = "none";
        }

        // Education
        function EditEducationDetails() {
            document.getElementById("EducationView").style.display = "none";
            document.getElementById("EducationEdit").style.display = "block";
        }

        function BackToEducationView() {
            document.getElementById("EducationView").style.display = "block";
            document.getElementById("EducationEdit").style.display = "none";
        }
    </script>
@endpush
