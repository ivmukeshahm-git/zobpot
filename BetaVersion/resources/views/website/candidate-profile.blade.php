@push('css')
<style>
    .education-card {
        border-radius: 12px;
        border: 1px solid #eaeaea;
        padding: 25px;
        margin-bottom: 20px;
        background: white;
        position: relative;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    
    .education-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border-color: #242b60;
    }
    
    .education-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .education-title {
        flex: 1;
    }
    
    .education-actions {
        display: flex;
        gap: 10px;
    }
    
    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }
    
    .action-btn:hover {
        transform: scale(1.1);
    }
    
    .edit-btn {
        background: rgba(36, 43, 96, 0.1);
        color: #242b60;
    }
    
    .edit-btn:hover {
        background: #242b60;
        color: white;
    }
    
    .delete-btn {
        background: rgba(236, 107, 41, 0.1);
        color: #ec6b29;
    }
    
    .delete-btn:hover {
        background: #ec6b29;
        color: white;
    }
    
    .school-info {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .school-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #242b60, #3a4799);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .school-icon img {
        max-width: 35px;
        filter: brightness(0) invert(1);
    }
    
    .school-details h4 {
        margin: 0 0 5px 0;
        color: #242b60;
        font-weight: 700;
        font-size: 18px;
    }
    
    .school-details p {
        margin: 0;
        color: #666;
        font-size: 14px;
    }
    
    .degree-info {
        background: #f8f9ff;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        border-left: 4px solid #ec6b29;
    }
    
    .degree-info h5 {
        margin: 0 0 5px 0;
        color: #242b60;
        font-weight: 600;
        font-size: 16px;
    }
    
    .degree-meta {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #555;
        font-size: 14px;
    }
    
    .meta-item i {
        color: #ec6b29;
        font-size: 16px;
    }
    
    .description-box {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 15px;
        margin-top: 15px;
        border-left: 3px solid #242b60;
    }
    
    .description-box p {
        margin: 0;
        color: #444;
        line-height: 1.6;
        font-size: 14px;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: linear-gradient(135deg, #f8f9ff, #ffffff);
        border-radius: 12px;
        border: 2px dashed #e0e0e0;
    }
    
    .empty-state i {
        font-size: 60px;
        color: #ddd;
        margin-bottom: 20px;
    }
    
    .empty-state h4 {
        color: #666;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .empty-state p {
        color: #888;
        max-width: 400px;
        margin: 0 auto;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .education-header {
            flex-direction: column;
            gap: 15px;
        }
        
        .education-actions {
            align-self: flex-end;
        }
        
        .school-info {
            flex-direction: column;
            text-align: center;
        }
        
        .degree-meta {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>
    <style>
        #Skillsuggestions {
            display: none;
        }

        .card-grid-2 {
            overflow: visible !important;
        }

        .job-reject-box {
            border: 1px solid #f3f3f3;
            padding: 10px;
            border-radius: 6px;
            background: #eee;
        }

        .job-reject-box label {
            font-size: 15px;
            font-weight: 600;
        }

        .selected-tag {
            background-color: #0d6efd;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 14px;
        }

        .selected-tag::after {
            content: " ×";
            cursor: pointer;
            margin-left: 4px;
        }

        #languageDropdown {
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
<style>
    /* MAIN CARD */
.card-grid-2.hover-up {
    background: #FFFFFF !important;
    border-radius: 16px !important;
    padding: 12px !important;          /* Reduced padding */
    margin-bottom: 20px !important;
    border: 1px solid #242a65 !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    transition: all 0.3s ease !important;
    cursor: pointer !important;

    height: 300px !important;           /* Auto height - NO EXTRA SPACE */
    min-height: 260px !important;
    display: flex !important;
    flex-direction: column !important;
}

.card-grid-2.hover-up:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 12px 35px rgba(36, 42, 101, 0.15) !important;
}

/* CARD CONTENT WRAPPER */
.card-block-info.mt-20 {
    margin-top: 0 !important;
    display: flex !important;
    flex-direction: column !important;
    flex: 1 !important;
}

/* TITLE */
.card-block-info h6 {
    font-size: 18px !important;
    font-weight: 700 !important;
    color: #242a65 !important;
    margin-bottom: 8px !important;     /* Reduced gap */
    line-height: 1.4 !important;

    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
}

.card-block-info h6 a {
    text-decoration: none !important;
    color: inherit !important;
}

/* STATUS BADGE */
.badge {
    padding: 6px 12px !important;
    border-radius: 20px !important;
    font-size: 11px !important;
    font-weight: 600 !important;
}

/* COLORS */
.bg-warning { background: #ffc107 !important; color: #000 !important; }
.bg-success { background: #28a745 !important; color: #fff !important; }
.bg-danger  { background: #dc3545 !important; color: #fff !important; }
.bg-primary { background: #007bff !important; color: #fff !important; }

/* WORK TYPE ROW */
.mt-5 {
    margin: 6px 0 !important;          /* Reduced gap */
    display: flex !important;
    justify-content: space-between !important;
    flex-wrap: wrap !important;
    gap: 6px !important;
}

/* WORK TYPE TAG */
.card-briefcase {
    background: #f36825 !important;
    color: white !important;
    padding: 6px 12px !important;
    border-radius: 20px !important;
    font-size: 12px !important;
    font-weight: 600 !important;
}

/* TIME TEXT */
.card-time {
    font-size: 12px !important;
    color: #666 !important;
}

/* LOCATION BOX */
.font-sm.color-text-paragraph.mt-15.mb-0 {
    margin-top: 12px !important;
    margin-bottom: 10px !important;
    padding: 10px !important;
    background: #f8faff !important;
    border-radius: 12px !important;
    font-size: 14px !important;
    color: #666 !important;
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
}

.font-sm.color-text-paragraph.mt-15.mb-0 i {
    color: #242a65 !important;
}

/* BUTTON */
.btn-apply.btn-apply-big.hover-up.w-100 {
    background: #242a65 !important;
    color: #fff !important;
    padding: 12px !important;
    border-radius: 8px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    margin-top: auto !important;
}

.btn-apply.btn-apply-big.hover-up.w-100:hover {
    background: #f36825 !important;
    transform: translateY(-2px) !important;
}

/* RESPONSIVE FIX */
@media (max-width: 768px) {
    .card-grid-2.hover-up {
        padding: 16px !important;
        min-height: 220px !important;
    }
}
/* Default tab button */
.nav .btn {
    border: 1px solid #d8dae0 !important;
    color: #05264E !important;
    font-weight: 600 !important;
    padding: 10px 18px !important;
    border-radius: 10px !important;
    transition: all 0.25s ease-in-out !important;
}

/* ACTIVE TAB */
.nav .btn.active,
.nav .btn[aria-selected="true"] {
    background-color: #05264E !important;
    color: #ffffff !important;
    border-color: #05264E !important;
    transform: translateY(-3px) !important;
    box-shadow: 0px 4px 12px rgba(5, 38, 78, 0.3) !important;
}

/* Hover effect */
.nav .btn:hover {
    background-color: #eef2ff !important;
    border-color: #05264E !important;
    color: #05264E !important;
}

/* Active tab hover (keep white text) */
.nav .btn.active:hover {
    background-color: #05264E !important;
    color: #fff !important;
}

</style>
<style>
    .work-exp-card {
    background: #fff !important;
    border-radius: 12px !important;
    padding: 18px 22px !important;
    box-shadow: 0 3px 12px rgba(0,0,0,0.08) !important;
    border: 1px solid #eef0f6 !important;
    position: relative !important;
    margin-bottom: 20px !important;
}

/* Icon box */
.work-exp-icon {
    width: 52px !important;
    height: 52px !important;
    border-radius: 12px !important;
    background: #242a62 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.work-exp-icon img {
    width: 28px !important;
}

/* Company + Title */
.work-exp-title {
    font-size: 20px !important;
    font-weight: 700 !important;
    color: #242a62 !important;
}

.work-exp-company {
    font-size: 16px !important;
    font-weight: 600 !important;
    color: #242a62 !important;
    margin-bottom: 2px !important;
}

.work-exp-location {
    color: #6a6a6a !important;
    font-size: 13px !important;
}

/* Details box */
.work-exp-details {
    background: #f5f7ff !important;
    padding: 12px !important;
    border-radius: 10px !important;
    margin-top: 12px !important;
    font-size: 14px !important;
}

.work-exp-desc-box {
    background: #f8f9fb !important;
    border-radius: 10px !important;
    padding: 12px !important;
    margin-top: 12px !important;
}

/* Right side Edit Delete buttons */
.exp-action-btn {
    width: 34px !important;
    height: 34px !important;
    border-radius: 8px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    background: #eef0f9 !important;
    cursor: pointer !important;
    transition: 0.2s !important;
}

.exp-action-btn i {
    font-size: 15px !important;
    color: #242a62 !important;
}

.exp-action-btn:hover {
    background: #242a62 !important;
}

.exp-action-btn:hover i {
    color: white !important;
}

.exp-delete {
    background: #ffe7e7 !important;
}

.exp-delete i {
    color: red !important;
}

.exp-delete:hover {
    background: red !important;
}

.exp-delete:hover i {
    color: white !important;
}
.desc-text {
    max-height: 78px;
    overflow: hidden;
    position: relative;
    transition: 0.3s ease-in-out;
}

.desc-text.expanded {
    max-height: 1000px; /* Enough to show full text */
}

.read-more-toggle {
    display: inline-block;
    margin-top: 8px;
    font-size: 14px;
    color: #242a62;
    cursor: pointer;
    font-weight: 600;
}

.read-more-toggle:hover {
    text-decoration: underline;
}

</style>
@endpush

@extends('website.layout.layout')
@section('website-content')
    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
    @endphp
    <main class="main">
        <section class="section-box-2">
            <div class="container">
                <!-- <div class="banner-hero banner-image-single">
                    <img
                        src="{{ $user->cover_img ? asset('uploads/profile/' . $user->cover_img) : asset('uploads/profile/cover.png') }}"
                        alt="jobbox"><a class="btn-editor" href="#"></a></div> -->
                         <!-- <div class="banner-hero banner-image-single">
                             @if($user->cover_img)
                             <img
                        src="{{ $user->cover_img ? asset('uploads/profile/' . $user->cover_img) : asset('uploads/profile/cover.jpg') }}"
                        alt="Cover Image">
                        @endif
                        </div> -->
                        <div class="banner-hero banner-image-single">
                             
                             <img
                        src="{{ asset('uploads/profile/coverimage.jpg')}}"
                        alt="Cover Image">
                       
                        </div>
                <div class="box-company-profile" @if($user->cover_img == "") style="margin-top:30px;"  @endif>
                    <!-- <div class="image-compay"><img
                            src="{{ $user->profile_img ? asset('uploads/profile/' . $user->profile_img) : asset('uploads/profile/candidate.jpg') }}"
                            style="max-width:100px;" alt="jobbox">
                    </div> -->
                    <div class="row mt-10">
                        <div class="col-lg-6 col-md-12">
                            <h5 class="f-19 mb-10">{{ $user->name }}</h5>
                            <p class="mt-0 font-md color-text-paragraph-2 mb-15">{{ $user->designation }}</p>
                        </div>
                        <div class="col-lg-6 col-md-12 text-lg-end"><a
                                class="btn btn-apply btn-apply-big m-1"
                                href="{{ route('create-resume') }}">Create Resume</a><a
                                class="btn btn-apply btn-apply-big"
                                href="{{ route('candidate-profile-detail', ['id' => $user->id]) }}">Preview</a></div>
                    </div>
                </div>
                <div class="border-bottom pt-10 pb-10"></div>
            </div>
        </section>

        <section class="section-box mt-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-12">
                        <div class="box-nav-tabs nav-tavs-profile mb-5">
                            <!-- <ul class="nav" role="tablist">
                                <li><a class="btn btn-border mb-20 active" href="#tab-my-jobs" data-bs-toggle="tab"
                                        role="tab" aria-controls="tab-my-jobs" aria-selected="false">My Jobs</a></li>
                                <li><a class="btn btn-border mb-20" href="#tab-my-profile" data-bs-toggle="tab"
                                        role="tab" aria-controls="tab-my-profile" aria-selected="true">My Profile</a>
                                </li>
                                <li><a class="btn btn-border mb-20" href="#tab-about-skill" data-bs-toggle="tab"
                                        role="tab" aria-controls="tab-about-skill" aria-selected="true">About &
                                        Skill</a></li>
                                <li><a class="btn btn-border mb-20" href="#tab-work-exprince" data-bs-toggle="tab"
                                        role="tab" aria-controls="tab-work-exprince" aria-selected="false">Work
                                        Experience</a></li>
                                <li><a class="btn btn-border mb-20" href="#tab-education" data-bs-toggle="tab"
                                        role="tab" aria-controls="tab-education" aria-selected="false">Education</a>
                                </li>
                                <li><a class="btn btn-border mb-20" href="#tab-saved-jobs" data-bs-toggle="tab"
                                        role="tab" aria-controls="tab-saved-jobs" aria-selected="false">Saved Jobs</a>
                                </li>
                                <li><a class="btn btn-border mb-20" href="#tab-change-password" data-bs-toggle="tab"
                                        role="tab" aria-controls="tab-change-password" aria-selected="false">Change
                                        Password</a></li>
                                <li><a class="btn btn-border recruitment-icon mb-20" href="#tab-membership-history"
                                        data-bs-toggle="tab" role="tab" aria-controls="tab-membership-history"
                                        aria-selected="false">Membership History</a></li>
                            </ul> -->
                            <ul class="nav" role="tablist">
                                <li><a class="btn btn-border mb-20 active"
                                    href="#tab-my-jobs" data-bs-toggle="tab"
                                    role="tab" aria-controls="tab-my-jobs"
                                    aria-selected="true">My Jobs</a></li>

                                <li><a class="btn btn-border mb-20"
                                    href="#tab-my-profile" data-bs-toggle="tab"
                                    role="tab" aria-controls="tab-my-profile"
                                    aria-selected="false">My Profile</a></li>

                                <li><a class="btn btn-border mb-20"
                                    href="#tab-about-skill" data-bs-toggle="tab"
                                    role="tab" aria-controls="tab-about-skill"
                                    aria-selected="false">About & Skill</a></li>

                                <li><a class="btn btn-border mb-20"
                                    href="#tab-work-exprince" data-bs-toggle="tab"
                                    role="tab" aria-controls="tab-work-exprince"
                                    aria-selected="false">Work Experience</a></li>

                                <li><a class="btn btn-border mb-20"
                                    href="#tab-education" data-bs-toggle="tab"
                                    role="tab" aria-controls="tab-education"
                                    aria-selected="false">Education</a></li>
                                
                                <li><a class="btn btn-border mb-20"
                                    href="#tab-resume" data-bs-toggle="tab"
                                    role="tab" aria-controls="tab-resume"
                                    aria-selected="false">My Resume</a></li>

                                <li><a class="btn btn-border mb-20"
                                    href="#tab-my-internship" data-bs-toggle="tab"
                                    role="tab" aria-controls="tab-my-internship"
                                    aria-selected="false">My Internship</a></li>

                                <li><a class="btn btn-border mb-20"
                                    href="#tab-saved-jobs" data-bs-toggle="tab"
                                    role="tab" aria-controls="tab-saved-jobs"
                                    aria-selected="false">Saved Jobs</a></li>

                                <li><a class="btn btn-border mb-20"
                                    href="#tab-change-password" data-bs-toggle="tab"
                                    role="tab" aria-controls="tab-change-password"
                                    aria-selected="false">Change Password</a></li>

                                <li><a class="btn btn-border recruitment-icon mb-20"
                                    href="#tab-membership-history" data-bs-toggle="tab"
                                    role="tab" aria-controls="tab-membership-history"
                                    aria-selected="false">Membership History</a></li>
                            </ul>

                            <div class="border-bottom pt-10 pb-10"></div>
                            <!--<div class="mt-20 mb-20"><a class="link-red" href="#">Delete Account</a></div>-->
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-12 col-12 mb-50">
                        <div class="content-single">
                            <div class="tab-content">
                                <div class="tab-pane fade" id="tab-my-profile" role="tabpanel"
                                    aria-labelledby="tab-my-profile">
                                    <form id="candidate-profile-form" onsubmit="return false;">
                                        <h3 class="mt-0 mb-15 color-brand-1">My Profile</h3>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-12 mb-2">
                                                <div class="main-button-file-upload-box">
                                                    <a class="font-md color-text-paragraph-2 mb-10" href="#">Update
                                                        your profile <b style="font-weight: 600;">(Profile Image Size : 100
                                                            X 100)</b></a>
                                                    <div class="box-info-profie mt-2">
                                                        <div class="image-profile">
                                                            <img id="profilePreview"
                                                                src="{{ 
                                                                    (!empty($user->profile_img) && file_exists(public_path('uploads/profile/'.$user->profile_img)))
                                                                        ? asset('uploads/profile/'.$user->profile_img)
                                                                        : asset('uploads/profile/candidate.jpg')
                                                                }}"
                                                                alt="Avatar" style="height: 85px;">
                                                        </div>
                                                        <a class="btn btn-apply"
                                                            onclick="$('#profile_img').click()">Upload Profile</a>
                                                        <a class="btn btn-link" onclick="removeProfileImage()">Delete</a>

                                                        <input type="file" name="profile_img" id="profile_img"
                                                            accept="image/*" style="display: none;">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-12 col-12 mb-2 d-none">
                                                <div class="main-button-file-upload-box">
                                                    <a class="font-md color-text-paragraph-2 mb-15" href="#">Cover
                                                        Image <b style="font-weight: 600;">(Profile Image Size: 1400 X
                                                            400)</b></a>
                                                    <div class="box-info-profie mt-2">
                                                         @if($user->cover_img)
                                                        <div class="image-profile">
                                                            <img id="profilePreview"
                                                                src="{{ asset('uploads/profile/' . ($user->cover_img ?? 'cover.png')) }}"
                                                                alt="Avatar">
                                                        </div>
                                                        @endif
                                                        <a class="btn btn-apply" onclick="$('#cover_img').click()">Upload
                                                            Cover</a>
                                                        <input type="file" name="cover_img" id="cover_img"
                                                            accept="image/*" style="display: none;">
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="remove_img" id="remove_img" value="0">

                                            <div class="col-lg-12 col-md-12 col-12">
                                                <div class="main-button-file-upload-box">
                                                    <label class="font-md color-text-paragraph-2 mb-10">Upload Your Resume
                                                        (PDF Only)</label>
                                                    <div class="box-info-profie">
                                                        <input type="file" name="resume" id="resume"
                                                            accept="application/pdf" class="form-control mb-2">

                                                        @if (!empty($Resume->file_nm))
                                                            <a href="{{ asset('storage/resumes/' . $Resume->file_nm) }}"
                                                                target="_blank">
                                                                View Resume
                                                            </a>
                                                        @else
                                                            <span class="text-danger">No resume uploaded</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-contact mt-20">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10 ">
                                                                Designation

                                                            </label>
                                                            <input class="form-control" type="text" id="designation"
                                                                name="designation" placeholder="Enter Designation"
                                                                value="{{ $userData ? $userData->designation : '' }}"
                                                                {{ $userData && $userData->designation == 'Fresher' ? 'readonly' : '' }}>

                                                            <span class="d-flex align-items-center">
                                                                <input type="checkbox" id="is_fresher"
                                                                    onclick="handleFresherCheckbox()"
                                                                    style="max-width: 15px;">
                                                                <label for="is_fresher" class="mb-0 ms-1">Are you a
                                                                    fresher?</label>
                                                            </span>

                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Full Name
                                                                *</label>
                                                            <input class="form-control" type="text" id="full_name"
                                                                name="full_name" required placeholder="Enter Full Name"
                                                                value="{{ $userData ? $userData->name : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Email *</label>
                                                            <input class="form-control" type="text"
                                                                placeholder="Enter Email" id="email" name="email"
                                                                required value="{{ $userData ? $userData->email : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Gender *</label>
                                                            <select class="form-control" id="gender" name="gender" required>
                                                                <option value="">Select Gender</option>
                                                                <option value="1" {{ $userData && $userData->gender == 1 ? 'selected' : '' }}>Male</option>
                                                                <option value="2" {{ $userData && $userData->gender == 2 ? 'selected' : '' }}>Female</option>
                                                                <option value="3" {{ $userData && $userData->gender == 3 ? 'selected' : '' }}>Other</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Contact
                                                                number</label>
                                                            <input class="form-control" id="contact_no" name="contact_no"
                                                                type="text" placeholder="Enter Contact No." required
                                                                value="{{ $userData ? $userData->contact_no : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Personal
                                                                website</label>
                                                            <input class="form-control" id="personal_website"
                                                                name="personal_website" type="url"
                                                                placeholder="Enter Personal website"
                                                                value="{{ $userData ? $userData->personal_website : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="input-5">Pincode</label>
                                                            <input class="form-control" id="zipcode" type="text"
                                                                required="" name="zipcode" placeholder="Enter Pincode"
                                                                autocomplete="off" autocorrect="off" autocapitalize="off"
                                                                value="{{ $userData ? $userData->zipcode : '' }}">

                                                            <div id="Pincodesuggestions" class="suggestions"></div>
                                                            <input type="hidden" name="pincode_id_hidden"
                                                                id="pincode_id_hidden"
                                                                value="{{ $userData ? $userData->zipcode_id : '' }}">
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="input-5">State</label>
                                                            <input class="form-control" id="state_id" type="text"
                                                                required="" name="state_id" placeholder="Enter State"
                                                                autocomplete="off" autocorrect="off" autocapitalize="off"
                                                                value="{{ $userData ? $userData->state_name : '' }}">

                                                            <div id="Statesuggestions" class="suggestions"></div>
                                                            <input type="hidden" name="state_id_hidden"
                                                                id="state_id_hidden"
                                                                value="{{ $userData ? $userData->state_id : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="city_id">City</label>
                                                            <input class="form-control" id="city_id" type="text"
                                                                required="" name="city_id" placeholder="Enter City"
                                                                autocomplete="off" autocorrect="off" autocapitalize="off"
                                                                value="{{ $userData ? $userData->city_nm : '' }}">

                                                            <div id="Citysuggestions" class="suggestions"></div>
                                                            <input type="hidden" name="city_id_hidden"
                                                                id="city_id_hidden"
                                                                value="{{ $userData ? $userData->city_id : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="area_id">Area / Village</label>
                                                            <input class="form-control" id="area_id" type="text"
                                                                required="" name="area_id" placeholder="Enter Area"
                                                                autocomplete="off" autocorrect="off" autocapitalize="off"
                                                                value="{{ $userData ? $userData->area_nm : '' }}">

                                                            <div class="selected_area mt-2" id="AreaSuggestBox">

                                                            </div>

                                                            <div id="Areasuggestions" class="suggestions"></div>
                                                            <input type="hidden" name="area_id_hidden"
                                                                id="area_id_hidden"
                                                                value="{{ $userData ? $userData->area_id : '' }}">
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Address</label>
                                                            <input class="form-control" type="text" id="address"
                                                                name="address" required placeholder="Enter Address"
                                                                value="{{ $user ? $user->address : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="box-button mt-15">
                                                            <input type="hidden" id="_method" name="_method"
                                                                value="POST">
                                                            <input type="hidden" id="row_id" name="row_id"
                                                                value="{{ $user ? $user->id : '' }}">
                                                            <button class="btn btn-apply-big font-md font-bold"
                                                                type="submit">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div id="cropModal" class="crop-modal">
                                        <div class="crop-modal-content">
                                            <h5>Crop Profile Image (100 × 100)</h5>
                                            <img id="cropImage" style="max-width: 300px; border:1px solid #ddd">
                                            
                                            <div class="mt-3 text-center">
                                                <button id="cropSave" class="btn btn-primary">Apply Crop</button>
                                                <button id="cropCancel" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </div>
                                    </div>

                                    <style>
                                    .crop-modal {
                                        position: fixed; top:0; left:0; width:100%; height:100%;
                                        background: rgba(0,0,0,0.75);
                                        display:none; justify-content:center; align-items:center; z-index:9999;
                                    }
                                    .crop-modal-content{
                                        background:#fff; padding:20px; border-radius:12px;
                                        box-shadow:0px 3px 12px rgba(0,0,0,0.35);
                                        text-align:center;
                                        animation: fadeScale 0.2s ease-in-out;
                                    }
                                    @keyframes fadeScale {
                                        0% { transform: scale(0.8); opacity:0; }
                                        100% { transform: scale(1); opacity:1; }
                                    }
                                    </style>

                                </div>
                                <div class="tab-pane fade" id="tab-about-skill" role="tabpanel"
                                    aria-labelledby="tab-my-profile">
                                    <form id="candidate-about-skill-form" onsubmit="return false;">
                                        <h3 class="mt-0 mb-15 color-brand-1">About & Skill</h3>

                                        <div class="row form-contact">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label class="font-sm color-text-mutted mb-10">About</label>
                                                    <textarea class="form-control" id="about" name="about" rows="4">{{ $user && $user->about ? $user->about : 'Write Here..' }}</textarea>
                                                </div>

                                                <style>

                                                </style>

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label
                                                                class="font-sm color-text-mutted mb-10">Experience</label>
                                                            {{-- <input type="text" class="form-control" id="experience"
                                                                name="experience" placeholder="Enter Your Experience, eg: Fresher, 7 months, 1 year"
                                                                value="{{ $userData ? $userData->experience : '' }}"> --}}
                                                                <select class="form-control" id="experience" name="experience">
                                                                <option value="">-Select Experience-</option>
                                                                @foreach ($experience as $exp)  
                                                                    {{-- <option value="{{ $exp->id }}" {{ $userData && $userData->experience == $exp->id ? 'selected' : '' }}>{{ $exp->name }}</option> --}}
                                                                    <option value="{{ strtolower($exp->name) }}"
                                                                        {{ $userData && strtolower($userData->experience) == strtolower($exp->name) ? 'selected' : '' }}>
                                                                        {{ $exp->name }}
                                                                    </option>
                                                                @endforeach
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Expected
                                                                Salary</label>
                                                            <input type="number" class="form-control"
                                                                id="expected_salary" name="expected_salary"
                                                                placeholder="Enter Your Expected Salary"
                                                                value="{{ $userData ? $userData->expected_salary : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 mt-5 position-relative">
                                                        <label for="languageSelect" class="font-sm color-text-mutted mb-10">Languages</label>

                                                        <div id="languageSelectBtn"
                                                            class="form-control language-select position-relative d-flex flex-wrap gap-2 p-2"
                                                            style="cursor: pointer;font-size: 17px;">
                                                            <span class="placeholder text-muted">Choose Languages</span>
                                                        </div>

                                                        <div id="languageDropdown" class="border p-2 bg-white shadow-sm language-dropdown"
                                                            style="display: none; position: absolute; z-index: 1000; width: 100%;"
                                                            value="{{ $userData && $userData->languages ? implode(',', json_decode($userData->languages, true)) : '' }}">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="English" id="langEnglish">
                                                                <label class="form-check-label"
                                                                    for="langEnglish">English</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Hindi" id="langHindi">
                                                                <label class="form-check-label"
                                                                    for="langHindi">Hindi</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Gujarati" id="langGujarati">
                                                                <label class="form-check-label"
                                                                    for="langGujarati">Gujarati</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Marathi" id="langMarathi">
                                                                <label class="form-check-label"
                                                                    for="langMarathi">Marathi</label>
                                                            </div>
                                                        </div>

                                                        <!-- Hidden Input for form submission -->
                                                        <input type="hidden" id="selectedLanguages"
                                                            name="selectedLanguages">
                                                    </div>
                                                </div>

                                                <div class="box-skills">
                                                    <div class="row">

                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-10">Category
                                                                    *</label>
                                                                <select class="form-control" name="category_id"
                                                                    id="category_id">
                                                                    <option value="-Select Category-" selected>-Select Category-
                                                                    </option>
                                                                    @foreach ($CategoryData as $row)
                                                                        <option
                                                                            {{ $user && $user->category_id == $row->category_id ? 'selected' : '' }}
                                                                            value="{{ $row->category_id }}">
                                                                            {{ $row->category_nm }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-10">Sub Category
                                                                    *</label>
                                                                <select class="form-control" name="sub_category_id"
                                                                    id="sub_category_id">
                                                                    <option value="">-Select Category-</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h5 class="mt-0 color-brand-1">Skills</h5>
                                                  
                                                    @php
                                                        if (is_array($user->skills_id)) {
                                                            // already array
                                                            $Skill = $user->skills_id;
                                                        } elseif (!empty($user->skills_id)) {
                                                            // json string
                                                            $decoded = json_decode($user->skills_id, true);
                                                            $Skill = is_array($decoded) ? $decoded : [];
                                                        } else {
                                                            $Skill = [];
                                                        }
                                                    @endphp


                                                    <div class="form-contact">
                                                        <div class="form-group">
                                                            <input class="form-control search-icon" id="skill_id"
                                                                name="skill_id" type="text" value=""
                                                                placeholder="E.g. Angular, Laravel..." autocomplete="off"
                                                                autocorrect="off" autocapitalize="off">
                                                            <div id="Skillsuggestions" class="suggestions"></div>
                                                            <input type="hidden" name="skills_hidden" id="skills_hidden"
                                                                value="{{ implode(',', $Skill) }}">
                                                        </div>
                                                    </div>

                                                    <div class="box-tags mt-30">
                                                        @foreach ($Skill as $row)
                                                            <a class="btn btn-grey-small mr-10 skill-tag">{{ $row }}<span
                                                                    class="close-icon remove-skill fa fa-times"
                                                                    data-skill="{{ $row }}"></span></a>
                                                        @endforeach
                                                    </div>

                                                    {{-- <div class="mt-40"> <span class="card-info font-sm color-text-paragraph-2">You can add up to 15 skills</span></div> --}}
                                                </div>

                                                <div class="row mt-10">
                                                    <div class="col-lg-3">
                                                        <div class="box-button mt-15">
                                                            <input type="hidden" id="_method" name="_method"
                                                                value="POST">
                                                            <input type="hidden" id="row_id" name="row_id"
                                                                value="{{ $user ? $user->id : '' }}">
                                                            <button class="btn btn-apply-big font-md font-bold"
                                                                type="submit">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tab-work-exprince" role="tabpanel"
                                    aria-labelledby="tab-work-exprince">
                                    <div id="WorkExperienceAdd">
                                        <form id="candidate-work-experience-form" onsubmit="return false;">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <h3 class="mt-0 mb-15 color-brand-1">Work Experience</h3>
                                                </div>
                                                <div class="col-lg-6" style="text-align:right;">
                                                    <button class="btn btn-apply-big font-md font-bold w-50"
                                                        style="padding: 8px 2px !important;font-size: 13px !important;"
                                                        onclick="BackWorkExperience()">Back</button>
                                                </div>
                                            </div>
                                            <div class="row form-contact mt-20">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Title *</label>
                                                            <input class="form-control" type="text" id="title"
                                                                name="title" placeholder="Enter Title">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Work type
                                                                *</label>
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
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Company or
                                                                organization </label>
                                                            <input class="form-control" type="text" id="company_name"
                                                                name="company_name" placeholder="Enter Company Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mt-10 mb-10">
                                                        <div class="box-agree">
                                                            <label class="lbl-agree font-xs color-text-paragraph-2"
                                                                style=" font-size: 14px!important;">
                                                                <input class="lbl-checkbox" type="checkbox"
                                                                    id="currently_working" name="currently_working">I
                                                                am currently working in this role
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Start date
                                                            </label>
                                                            <input class="form-control" type="date" id="start_date"
                                                                name="start_date">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">End date
                                                            </label>
                                                            <input class="form-control" type="date" id="end_date"
                                                                name="end_date">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Location</label>
                                                            <input class="form-control" type="text"
                                                                placeholder="Enter Location" id="location"
                                                                name="location">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Job Type</label>
                                                            <select name="location_type" id="location_type"
                                                                class="form-control">
                                                                <option value="" selected>-Select Job Type-</option>
                                                                @foreach ($JobtypeData as $row)
                                                                    <option value="{{ $row->job_type_id }}">
                                                                        {{ $row->type_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Role and
                                                                Responsibility</label>
                                                            <textarea class="form-control" rows="4" id="role_responsibility" name="role_responsibility"
                                                                placeholder="Enter Role and Responsibility"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-5">
                                                        <input type="hidden" id="_method" name="_method"
                                                            value="POST">
                                                        <input type="hidden" id="flag" name="flag"
                                                            value="A">
                                                        <input type="hidden" id="row_id" name="row_id">
                                                        <button class="btn btn-apply-big font-md font-bold w-50"
                                                            type="submit">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div id="WorkExperiencelist">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h3 class="mt-0 mb-15 color-brand-1">Work Experience</h3>
                                            </div>
                                            <div class="col-lg-6" style="text-align:right;">
                                                <button class="btn btn-apply-big font-md font-bold w-50"
                                                    style="padding: 8px 2px !important;font-size: 13px !important;"
                                                    onclick="AddWorkExperience()">Add Work Experience</button>
                                            </div>
                                        </div>


                                        <div class="row form-contact mt-20">

                                            @if (count($WorkExperienceData) > 0)
                                                @foreach ($WorkExperienceData as $row)
                                                    <div class="work-exp-card">

                                                        <div style="display:flex; justify-content:space-between; align-items:center;">
                                                            
                                                            <div style="display:flex; gap:15px; align-items:center;">
                                                                <div class="work-exp-icon">
                                                                    <img src="{{ asset('assets/imgs/building.png') }}" />
                                                                </div>

                                                                <div>
                                                                    <div class="work-exp-company">{{ $row->company }}</div>
                                                                    <div class="work-exp-location">{{ $row->location }}</div>
                                                                </div>
                                                            </div>

                                                            <div style="display:flex; gap:10px;">
                                                                <div class="exp-action-btn" onclick="EditWorkExperience({{ $row->id }})">
                                                                    <i class="fa fa-pencil"></i>
                                                                </div>
                                                                <div class="exp-action-btn exp-delete" onclick="DeleteWorkExperience({{ $row->id }})">
                                                                    <i class="fa fa-trash"></i>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <h4 class="work-exp-title mt-3">{{ $row->title }}</h4>

                                                        <div class="work-exp-details">
                                                            <span><b>Type:</b> {{ $row->work_type_name }}</span> &nbsp; | &nbsp;
                                                            <span>
                                                                <b>Duration:</b>  
                                                                {{ \Carbon\Carbon::parse($row->start_date)->format('M Y') }} -
                                                                {{ $row->working_status == '1' ? 'Present' : \Carbon\Carbon::parse($row->end_date)->format('M Y') }}
                                                            </span>
                                                        </div>

                                                        <div class="work-exp-desc-box">
                                                            <b class="fw-bold font-md">Role and Responsibility:</b>

                                                            <div class="desc-text" id="desc-{{ $row->id }}">
                                                                {{ $row->role_responsibility }}
                                                            </div>

                                                            <span class="read-more-toggle" onclick="toggleDescription({{ $row->id }})">
                                                                Read more...
                                                            </span>
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
                                </div>
                                <div class="tab-pane fade" id="tab-education" role="tabpanel"
                                    aria-labelledby="tab-education">
                                    <div id="EducationAdd">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h3 class="mt-0 mb-15 color-brand-1">Education</h3>
                                            </div>
                                            <div class="col-lg-6" style="text-align:right;">
                                                <button class="btn btn-apply-big font-md font-bold w-50"
                                                    style="padding: 8px 2px !important;font-size: 13px !important;"
                                                    onclick="BackEducation()">Back</button>
                                            </div>
                                        </div>
                                        <div class="row form-contact mt-20">
                                            <form id="candidate-education-form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">School / University *</label>
                                                            <input class="form-control" type="text"
                                                                placeholder="Enter School / University Name" id="school_name"
                                                                name="school_name">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Degree / Result *</label>
                                                            <input class="form-control" type="text"
                                                                placeholder="Enter Degree / Result Name" id="degree_name"
                                                                name="degree_name">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Field of study
                                                                *</label>
                                                            <input class="form-control" type="text"
                                                                placeholder="Enter Field of study" id="field_of_study"
                                                                name="field_of_study">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Grade</label>
                                                            <input class="form-control" type="text"
                                                                placeholder="Enter Grade" id="grade" name="grade">
                                                        </div>
                                                    </div>

                                                    <!--<div class="col-lg-6">-->
                                                    <!--    <div class="form-group">-->
                                                    <!--        <label class="font-sm color-text-mutted mb-10">Start date-->
                                                    <!--        </label>-->
                                                    <!--        <input class="form-control" type="date" id="start_date"-->
                                                    <!--            name="start_date">-->
                                                    <!--    </div>-->
                                                    <!--</div>-->

                                                    <!-- <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Passing Year</label>
                                                            <input class="form-control" type="date" id="end_date"
                                                                name="end_date">
                                                        </div>
                                                    </div> -->
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-muted mb-10">Passing Year</label>
                                                            <select class="form-control" name="end_date" id="edu_end_year">
                                                                <option value="">Select Year</option>
                                                                @for ($year = date('Y'); $year >= 1970; $year--)
                                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label
                                                                class="font-sm color-text-mutted mb-10">Description</label>
                                                            <textarea class="form-control" rows="4" id="description" name="description" placeholder="Write Here..."></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-5">
                                                        <input type="hidden" id="_method" name="_method"
                                                            value="POST">
                                                        <input type="hidden" id="flag" name="flag"
                                                            value="A">
                                                        <input type="hidden" id="row_id" name="row_id">
                                                        <button class="btn btn-apply-big font-md font-bold w-50"
                                                            type="submit">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                    <div id="Educationlist">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h3 class="mt-0 mb-15 color-brand-1">Education</h3>
                                            </div>
                                            <div class="col-lg-6" style="text-align:right;">
                                                <button class="btn btn-apply-big font-md font-bold w-50"
                                                    style="padding: 8px 2px !important;font-size: 13px !important;"
                                                    onclick="AddEducation()">Add Education</button>
                                            </div>
                                        </div>




                                        <div class="row form-contact mt-20">
                                            @if (count($EducationData) > 0)
                                                @foreach ($EducationData as $row)
                                                    <div class="col-xl-12 col-12" id="education-card-{{ $row->id }}">
                                                        <div class="education-card">
                                                            <!-- Header with Edit/Delete buttons on right -->
                                                            <div class="education-header">
                                                                <div class="education-title">
                                                                    <h3 style="color: #242b60; margin: 0;">
                                                                        <i class="fa fa-graduation-cap me-2"></i>Education
                                                                    </h3>
                                                                </div>
                                                                <div class="education-actions">
                                                                    <button class="action-btn edit-btn" 
                                                                            onclick="EditEducation({{ $row->id }})" 
                                                                            title="Edit Education">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </button>
                                                                    <button class="action-btn delete-btn" 
                                                                            onclick="DeleteEducation({{ $row->id }})" 
                                                                            title="Delete Education">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <!-- School/College Information -->
                                                            <div class="school-info">
                                                                <div class="school-icon">
                                                                    <img src="{{ asset('assets/imgs/school.png') }}" alt="School">
                                                                </div>
                                                                <div class="school-details">
                                                                    <h4>{{ $row->school_name }}</h4>
                                                                </div>
                                                            </div>

                                                            <!-- Degree Information -->
                                                            <div class="degree-info">
                                                                <h5>{{ $row->degree }} - {{ $row->field_of_study }}</h5>
                                                                
                                                                <div class="degree-meta">
                                                                    <div class="meta-item">
                                                                        <i class="fa fa-star"></i>
                                                                        <span><strong>Grade:</strong> {{ $row->grade }}</span>
                                                                    </div>
                                                                    
                                                                    <div class="meta-item">
                                                                        <i class="fa fa-calendar"></i>
                                                                        <span><strong>Completion:</strong> {{ $row->end_date }}</span>
                                                                    </div>
                                                                    
                                                                    @if($row->start_date)
                                                                    <div class="meta-item">
                                                                        <i class="fa fa-clock-o"></i>
                                                                        <span><strong>Duration:</strong> 
                                                                            {{ \Carbon\Carbon::parse($row->start_date)->format('M Y') }} - 
                                                                            {{ \Carbon\Carbon::parse($row->end_date)->format('M Y') }}
                                                                        </span>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Description -->
                                                            @if($row->description)
                                                            <div class="description-box">
                                                                <p>
                                                                    <strong><i class="fa fa-file-text-o me-2" style="color: #242b60;"></i>Description:</strong><br>
                                                                    {{ $row->description }}
                                                                </p>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-xl-12 col-12">
                                                    <div class="empty-state">
                                                        <i class="fa fa-graduation-cap"></i>
                                                        <h4>No Education Details Found</h4>
                                                        <p>Add your educational qualifications to enhance your profile. Employers value your academic background!</p>
                                                        <!-- You can add an "Add Education" button here if needed -->
                                                        <button class="btn" style="
                                                            background: #242b60;
                                                            color: white;
                                                            padding: 10px 30px;
                                                            border-radius: 8px;
                                                            margin-top: 20px;
                                                            font-weight: 600;
                                                            border: none;
                                                        ">
                                                            <i class="fa fa-plus me-2"></i>Add Education
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade show active" id="tab-my-jobs" role="tabpanel"
                                    aria-labelledby="tab-my-jobs">
                                    <h3 class="mt-0 color-brand-1 mb-50">My Jobs</h3>
                                    <div class="row display-list">
                                        @forelse($MyjobData as $row)
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <a href="{{ route('job-detail', ['job_id' => $row->job_id]) }}">
                                                    <div class="card-grid-2 hover-up">
                                                        <div class="card-block-info mt-20">
                                                            <h6><a
                                                                    href="{{ route('job-detail', ['job_id' => $row->job_id]) }}">{{ $row->job_title }}</a>
                                                                @php
                                                                    $statusMap = [
                                                                        0 => [
                                                                            'label' => 'Pending',
                                                                            'class' => 'bg-warning',
                                                                        ],
                                                                        1 => [
                                                                            'label' => 'Selected',
                                                                            'class' => 'bg-success',
                                                                        ],
                                                                        2 => [
                                                                            'label' => 'Rejected',
                                                                            'class' => 'bg-danger',
                                                                        ],
                                                                        3 => [
                                                                            'label' => 'Shortlisted',
                                                                            'class' => 'bg-primary',
                                                                        ],
                                                                        4 => [
                                                                            'label' => 'Schedule Interview',
                                                                            'class' => 'bg-warning',
                                                                        ],
                                                                    ];

                                                                    $status = $statusMap[$row->status] ?? [
                                                                        'label' => 'Unknown',
                                                                        'class' => 'bg-secondary',
                                                                    ];
                                                                @endphp

                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);"
                                                                    class="badge {{ $status['class'] }}">
                                                                    {{ $status['label'] }}
                                                                </a>
                                                            </h6>

                                                            <div class="mt-5"><span
                                                                    class="card-briefcase">{{ $row->work_type_name }}</span><span
                                                                    class="card-time">{{ \Carbon\Carbon::parse($row->datetime)->diffForHumans() }}<span>
                                                                    </span></span></div>
                                                            @if ($Setting->ShowCompanyDetails == 1 && $user && !is_null($user->active_plan_id) && $user->active_plan_id != 0)
                                                                <p class="font-sm color-text-paragraph mt-15 mb-0">
                                                                    <i class="fa fa-map-marker"></i>&nbsp;
                                                                    {{ $row->company_address }}
                                                                </p>
                                                            @else
                                                                <p class="font-sm color-text-paragraph mt-15 mb-0 ">
                                                                    <i class="fa fa-map-marker"></i>&nbsp;
                                                                    {{ $row->area_nm }}, {{ $row->city_nm }},
                                                                    {{ $row->state_name }}
                                                                </p>
                                                            @endif

                                                            <div class="btn btn-apply btn-apply-big hover-up w-100"
                                                                style="padding: 10px 10px;"
                                                                onclick="loadJobDetails({{ $row->job_id }})">View
                                                                Information</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @empty
                                            <div class="col-xl-12 col-12">
                                                <h4 style="text-align: center;background: #eee;padding: 23px;">
                                                    Job Not Found</h4>
                                            </div>
                                        @endforelse

                                    </div>
                                    @if (!$MyjobData->isEmpty())
                                        <div class="paginations mt-30">
                                            <ul class="pager" id="pagination-links">
                                                {{-- Previous Page Link --}}
                                                <li>
                                                    <a class="pager-prev {{ $MyjobData->onFirstPage() ? 'disabled' : '' }}"
                                                        href="{{ $MyjobData->previousPageUrl() ?? '#' }}">
                                                    </a>
                                                </li>

                                                {{-- Page Numbers --}}
                                                @for ($i = 1; $i <= $MyjobData->lastPage(); $i++)
                                                    <li>
                                                        <a class="pager-number {{ $MyjobData->currentPage() == $i ? 'active' : '' }}"
                                                            href="{{ $MyjobData->url($i) }}">{{ $i }}</a>
                                                    </li>
                                                @endfor

                                                {{-- Next Page Link --}}
                                                <li>
                                                    <a class="pager-next {{ !$MyjobData->hasMorePages() ? 'disabled' : '' }}"
                                                        href="{{ $MyjobData->nextPageUrl() ?? '#' }}">
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif

                                </div>

                                <div class="tab-pane fade " id="tab-jobs-view-job" role="tabpanel"
                                    aria-labelledby="tab-my-jobs">

                                </div>

                                <div class="tab-pane fade " id="tab-resume" role="tabpanel"
                                    aria-labelledby="tab-resume">
                                    <h3 class="mt-0 color-brand-1 mb-50">My Resume</h3>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-striped table-hover custom-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Sr. No.</th>
                                                        <th scope="col">Resume Name</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   @forelse ($Resumes as $res)
                                                        <tr id="resume-row-{{ $res->resume_id }}">
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $res->file_nm }}</td>
                                                            <td>    
                                                               <a href="{{ asset('storage/resumes/' . $res->file_nm) }}"
                                                                target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                                <button type="button"
                                                                        class="btn btn-md text-danger delete-resume"
                                                                        data-resume-id="{{ $res->resume_id }}">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                            <td colspan="3" style="text-align: center;">
                                                                <div class="col-xl-12 col-12">
                                                                    <h4 style="text-align: center;">
                                                                        Resume Not Found</h4>
                                                                </div>
                                                            </td>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab-saved-jobs" role="tabpanel"
                                    aria-labelledby="tab-saved-jobs">
                                    <h3 class="mt-0 color-brand-1 mb-50">Saved Jobs</h3>
                                    <div class="row">
                                        @if (count($SaveJobData) > 0)
                                            @foreach ($SaveJobData as $row)
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" onclick="window.location.href='{{ route('job-detail', ['job_id' => $row->job_id]) }}'">
                                                    <a href="{{ route('job-detail', ['job_id' => $row->job_id]) }}">
                                                        <div class="card-grid-2 hover-up position-relative">
                                                                    {{-- <a href="javascript:void(0);" 
                                                                        onclick="DeleteSaveJob({{ $row->id }})"  
                                                                        class="btn btn-danger btn-sm position-absolute p-2 m-2" 
                                                                        style="top: -24px;right: -22px;border-radius: 24px;">
                                                                        <i style="color: #fff;" class="fa fa-trash" aria-hidden="true"></i>
                                                                    </a> --}}
                                                                    <a href="javascript:void(0);" 
                                                                        onclick="event.stopPropagation(); DeleteSaveJob({{ $row->id }})"
                                                                        class="btn btn-danger btn-sm position-absolute p-2 m-2" 
                                                                        style="top: -24px;right: -22px;border-radius: 24px;">
                                                                        <i style="color: #fff;" class="fa fa-trash"></i>
                                                                    </a>

                                                            <div class="card-block-info mt-10">
                                                                <h6><a
                                                                        href="{{ route('job-detail', ['job_id' => $row->job_id]) }}">{{ $row->job_title }}</a>
                                                                </h6>
                                                                <div class="mt-5"><span
                                                                        class="card-briefcase">{{ $row->work_type_name }}</span><span
                                                                        class="card-time">{{ \Carbon\Carbon::parse($row->datetime)->diffForHumans() }}</span>
                                                                </div>
                                                                @if ($Setting->ShowCompanyDetails == 1 && $user && !is_null($user->active_plan_id) && $user->active_plan_id != 0)
                                                                    <p class="font-sm color-text-paragraph mt-15 mb-0">
                                                                        <i class="fa fa-map-marker"></i>&nbsp;
                                                                        {{ $row->company_address }}
                                                                    </p>
                                                                @else
                                                                    <p class="font-sm color-text-paragraph mt-15 mb-0 ">
                                                                        <i class="fa fa-map-marker"></i>&nbsp;
                                                                        {{ $row->area_nm }}, {{ $row->city_nm }},
                                                                        {{ $row->state_name }}
                                                                    </p>
                                                                @endif
                                                                <div class="mt-20">

                                                                    @php
                                                                        $Skill = [];

                                                                        if (!empty($row->skill_id)) {
                                                                            $decoded = json_decode(
                                                                                $row->skill_id,
                                                                                true,
                                                                            );
                                                                            $Skill = is_array($decoded) ? $decoded : [];
                                                                        }
                                                                    @endphp
                                                                    @foreach ($Skill as $row)
                                                                        <a class="btn btn-grey-small mr-5 mb-2"
                                                                            href="javascript:void(0);">{{ $row }}</a>
                                                                    @endforeach

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-xl-12 col-12">
                                                <h4 style="text-align: center;background: #eee;padding: 23px;">
                                                    Job Not Found</h4>
                                            </div>
                                        @endif
                                    </div>


                                    @if ($SaveJobData->lastPage() > 1)
                                        <div class="paginations mt-30">
                                            <ul class="pager">
                                                {{-- Previous Page Link --}}
                                                <li>
                                                    <a class="pager-prev {{ $SaveJobData->onFirstPage() ? 'disabled' : '' }}"
                                                        href="{{ $SaveJobData->previousPageUrl() ?? '#' }}">
                                                    </a>
                                                </li>

                                                {{-- Page Numbers --}}
                                                @for ($i = 1; $i <= $SaveJobData->lastPage(); $i++)
                                                    <li>
                                                        <a class="pager-number {{ $SaveJobData->currentPage() == $i ? 'active' : '' }}"
                                                            href="{{ $SaveJobData->url($i) }}">{{ $i }}</a>
                                                    </li>
                                                @endfor

                                                {{-- Next Page Link --}}
                                                <li>
                                                    <a class="pager-next {{ !$SaveJobData->hasMorePages() ? 'disabled' : '' }}"
                                                        href="{{ $SaveJobData->nextPageUrl() ?? '#' }}">
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <div class="tab-pane fade" id="tab-change-password" role="tabpanel"
                                    aria-labelledby="tab-saved-jobs">
                                    <form id="change-password-form" onsubmit="return false;">
                                        <h3 class="mt-0 color-brand-1 mb-50">Change your password</h3>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group position-relative">
                                                    <label class="form-label" for="password">Old Password <span style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <input class="form-control" id="old_password" type="password" name="old_password" required placeholder="************">
                                                        <button type="button" class="btn btn-brand-1 hover-up " id="togglePassword">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--<div class="form-group">-->
                                                <!--    <label class="font-sm color-text-mutted mb-10">Old Password</label>-->
                                                <!--    <input class="form-control" type="password" id="old_password"-->
                                                <!--        name="old_password" placeholder="Enter Old Password">-->
                                                <!--</div>-->
                                            </div>

                                            <div class="col-lg-6">
                                                
                                                <div class="form-group position-relative">
                                                    <label class="form-label" for="password">Password <span style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <input class="form-control" id="new_password" type="password" name="new_password" required placeholder="************">
                                                        <button type="button" class="btn btn-brand-1 hover-up " id="togglePassword2">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--<div class="form-group">-->
                                                <!--    <label class="font-sm color-text-mutted mb-10">Password</label>-->
                                                <!--    <input class="form-control" type="password" id="new_password"-->
                                                <!--        name="new_password" placeholder="Enter New Password">-->
                                                <!--</div>-->
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group position-relative">
                                                    <label class="form-label" for="password">Re-Password * <span style="color: red;">*</span></label>
                                                    <div class="input-group">
                                                        <input class="form-control" id="new_password_confirmation" type="password" name="new_password_confirmation" required placeholder="************">
                                                        <button type="button" class="btn btn-brand-1 hover-up " id="togglePassword3">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--<div class="form-group">-->
                                                <!--    <label class="font-sm color-text-mutted mb-10">Re-Password *</label>-->
                                                <!--    <input class="form-control" type="password"-->
                                                <!--        id="new_password_confirmation" name="new_password_confirmation"-->
                                                <!--        placeholder="Confirm New Password">-->
                                                <!--</div>-->
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="box-button mt-15">
                                                    <input type="hidden" id="_method" name="_method" value="POST">
                                                    <input type="hidden" id="row_id" name="row_id"
                                                        value="{{ $user ? $user->id : '' }}">

                                                    <button class="btn btn-apply-big font-md font-bold"
                                                        type="submit">Save Change</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade " id="tab-membership-history" role="tabpanel"
                                    aria-labelledby="tab-membership-history">
                                    <h3 class="mt-0 color-brand-1 mb-50">Membership History</h3>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-striped table-hover custom-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Sr. No.</th>
                                                        <th scope="col">Plan</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Buy On</th>
                                                        <th scope="col">Expire On</th>
                                                        <th scope="col">Current Active Plan</th>
                                                        {{-- <th scope="col">Action</th> --}}
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
                                                            {{-- <td> <a class="btn  btn-apply btn-apply-big p-2"
                                                                    href=""><i class="fa fa-list-alt"></i></a></td> --}}
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- My Internship Tab -->
                                <div class="tab-pane fade" id="tab-my-internship" role="tabpanel"
                                    aria-labelledby="tab-my-internship">
                                    <h3 class="mt-0 color-brand-1 mb-50">My Internships</h3>
                                    
                                    <!-- Internship Cards -->
                                    <div class="row">
                                        <!-- Sample Internship Card 1 -->
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-4">
                                            <div class="card" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border: none; overflow: hidden;">
                                                <div class="card-header" style="background: #242a62; color: white; padding: 20px; border: none;">
                                                    <h5 style="margin: 0; font-weight: 700; font-size: 18px;color:#fff;">
                                                        <i class="bx bx-briefcase"></i> Full-Stack Web Development
                                                    </h5>
                                                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;color:#fff;">TechCorp Solutions Pvt. Ltd.</p>
                                                </div>
                                                <div class="card-body" style="padding: 20px;">
                                                    <div class="mb-3">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span style="color: #6c757d; font-size: 13px;"><i class="bx bx-calendar"></i> Duration:</span>
                                                            <span style="font-weight: 600; color: #212529; font-size: 13px;">3 Months</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span style="color: #6c757d; font-size: 13px;"><i class="bx bx-time"></i> Status:</span>
                                                            <span class="badge" style="background: #28a745; color: white; padding: 5px 12px; border-radius: 5px; font-size: 11px;">Active</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span style="color: #6c757d; font-size: 13px;"><i class="bx bx-map"></i> Mode:</span>
                                                            <span style="font-weight: 600; color: #212529; font-size: 13px;">Hybrid</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span style="color: #6c757d; font-size: 13px;"><i class="bx bx-calendar-check"></i> Started:</span>
                                                            <span style="font-weight: 600; color: #212529; font-size: 13px;">01 Feb 2026</span>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-apply w-100" onclick="viewMyInternship(1)" style="background: #242a62; color: white; padding: 10px; border-radius: 6px; font-weight: 600; border: none;">
                                                        <i class="bx bx-show"></i> View Details
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sample Internship Card 2 -->
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-4">
                                            <div class="card" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border: none; overflow: hidden;">
                                                <div class="card-header" style="background: #242a62; color: white; padding: 20px; border: none;">
                                                    <h5 style="margin: 0; font-weight: 700; font-size: 18px;color:#fff;">
                                                        <i class="bx bx-briefcase"></i> Mobile App Development
                                                    </h5>
                                                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;color:#fff;">InnovateTech Inc.</p>
                                                </div>
                                                <div class="card-body" style="padding: 20px;">
                                                    <div class="mb-3">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span style="color: #6c757d; font-size: 13px;"><i class="bx bx-calendar"></i> Duration:</span>
                                                            <span style="font-weight: 600; color: #212529; font-size: 13px;">6 Months</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span style="color: #6c757d; font-size: 13px;"><i class="bx bx-time"></i> Status:</span>
                                                            <span class="badge" style="background: #6c757d; color: white; padding: 5px 12px; border-radius: 5px; font-size: 11px;">Completed</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span style="color: #6c757d; font-size: 13px;"><i class="bx bx-map"></i> Mode:</span>
                                                            <span style="font-weight: 600; color: #212529; font-size: 13px;">Remote</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span style="color: #6c757d; font-size: 13px;"><i class="bx bx-calendar-check"></i> Completed:</span>
                                                            <span style="font-weight: 600; color: #212529; font-size: 13px;">15 Dec 2025</span>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-apply w-100" onclick="viewMyInternship(2)" style="background: #242a62; color: white; padding: 10px; border-radius: 6px; font-weight: 600; border: none;">
                                                        <i class="bx bx-show"></i> View Details
                                                    </button>
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
        </section>
    </main>

@endsection


@push('script')
<script>
function BackJobList() {
    $('#tab-jobs-view-job').removeClass('show active'); // Hide detail tab
    $('#tab-my-jobs').addClass('show active');          // Show job list tab

    $('html,body').animate({ scrollTop: $("#tab-my-jobs").offset().top - 50 }, 300);
}


</script>
<!-- Optional: Add some JavaScript for smooth hover effects -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effect to education cards
        const cards = document.querySelectorAll('.education-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Add confirmation for delete action
        // window.DeleteEducation = function(id) {
        //     if(confirm('Are you sure you want to delete this education record?')) {
        //         // Your existing delete logic here
        //         console.log('Deleting education with ID:', id);
        //         // Add your AJAX call here
        //     }
        // };
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const selectBtn   = document.getElementById('languageSelectBtn');
    const dropdown    = document.getElementById('languageDropdown');
    const hiddenInput = document.getElementById('selectedLanguages');

    // ❗ Safety checks
    if (!selectBtn || !dropdown || !hiddenInput) {
        console.warn('Language elements not found');
        return;
    }

    /* =========================
       SAFE PRESELECT FROM BACKEND
       ========================= */
    let preselected = {!! json_encode($userData ? json_decode($userData->languages, true) : null) !!};

    // ✅ ROOT CAUSE FIX
    if (!Array.isArray(preselected)) {
        preselected = [];
    }

    preselected.forEach(lang => {
        const checkbox = dropdown.querySelector(`input[value="${lang}"]`);
        if (checkbox) checkbox.checked = true;
    });

    updateSelectedLanguages();

    /* =========================
       OPEN DROPDOWN
       ========================= */
    selectBtn.addEventListener('click', function (e) {
        e.stopPropagation();

        // toggle instead of force open
        dropdown.style.display =
            dropdown.style.display === 'block' ? 'none' : 'block';
    });

    /* =========================
       CLICK INSIDE DROPDOWN
       ========================= */
    dropdown.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    /* =========================
       CHECKBOX CHANGE
       ========================= */
    dropdown.addEventListener('change', function () {
        updateSelectedLanguages();
    });

    /* =========================
       CLICK OUTSIDE → CLOSE
       ========================= */
    document.addEventListener('click', function () {
        dropdown.style.display = 'none';
    });

    /* =========================
       UPDATE UI + HIDDEN INPUT
       ========================= */
    function updateSelectedLanguages() {

        const selected = [];
        const tags = [];

        dropdown
            .querySelectorAll('input[type="checkbox"]:checked')
            .forEach(cb => {
                selected.push(cb.value);
                tags.push(
                    `<span class="badge bg-primary">${cb.value}</span>`
                );
            });

        hiddenInput.value = selected.join(',');

        selectBtn.innerHTML = selected.length
            ? tags.join(' ')
            : `<span class="placeholder text-muted">Choose Languages</span>`;
    }

});
</script>

     {{-- <script>

    document.addEventListener('DOMContentLoaded', function() {

            const selectBtn = document.getElementById('languageSelectBtn');
            const dropdown = document.getElementById('languageDropdown');
            const hiddenInput = document.getElementById('selectedLanguages');

            // Pre-selected values from the backend (e.g., ["English", "Gujarati"])
            const preselected = {!! json_encode($userData ? json_decode($userData->languages, true) : []) !!};

            // Apply preselection
            preselected.forEach(lang => {
                const checkbox = dropdown.querySelector(`input[value="${lang}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });

            updateSelectedLanguages();

            selectBtn.addEventListener('click', function(e) {
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });

            dropdown.addEventListener('change', function() {
                updateSelectedLanguages();
            });

            window.addEventListener('click', function(e) {
                if (!selectBtn.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });

            function updateSelectedLanguages() {
                const selected = [];
                const selectedTags = [];

                dropdown.querySelectorAll('input[type="checkbox"]:checked').forEach(input => {
                    selected.push(input.value);
                    selectedTags.push(`<span class="badge bg-primary">${input.value}</span>`);
                });

                // 👇 Store as comma-separated string instead of JSON array
                hiddenInput.value = selected.join(',');

                selectBtn.innerHTML = selected.length ?
                    selectedTags.join(' ') :
                    `<span class="placeholder text-muted">Choose Languages</span>`;
            }

            function ConfirmDeleteSaveJob(id) {
                DeleteSaveJob(id);
            }
    });
</script> --}}
    <script>
        function loadJobDetails(jobId) {

            var data = {
                'job_id': jobId
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            LoaderShow();

            $.ajax({
                type: "POST",
                url: "{{ route('view-candidate-job-detail-action') }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    LoaderHide();
                    if (response.status === 1) {
                        $('#tab-jobs-view-job').html(response.htmlContent); // Inject 
                        $('#tab-jobs-view-job').addClass('show active');
                        $('#tab-my-jobs').removeClass('show active'); // Hide other tab if needed
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
    </script>
    <script>
        function DeleteSaveJob(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to Remove this job?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect or submit form
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
                        type: "POST",
                        url: "{{ route('remove-job-action') }}",
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
    </script>
    <script>
        function DeleteEducation(id) {

            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to delete Education?",
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
                        url: "{{ url('education-action') }}/" + id,
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
                                // setTimeout(function() {
                                //     location.reload();
                                // }, 1000);
                                $('#education-card-' + id).fadeOut(300, function () {
                                    $(this).remove();

                                    // 🔥 IF NO EDUCATION LEFT → SHOW EMPTY STATE
                                    if ($('.education-card').length === 0) {
                                        $('.form-contact').html(`
                                            <div class="col-xl-12 col-12">
                                                <div class="empty-state">
                                                    <i class="fa fa-graduation-cap"></i>
                                                    <h4>No Education Details Found</h4>
                                                    <p>Add your educational qualifications to enhance your profile.</p>
                                                </div>
                                            </div>
                                        `);
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
                    });
                    return false;
                }
            });

        }

        function EditEducation(id) {
            LoaderShow();

            $.ajax({
                url: "{{ url('education-action') }}/" + id + "/edit",
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    LoaderHide();

                    if (response.status === 1) {
                        const data = response.data;

                        $('#school_name').val(data.school_name);
                        $('#degree_name').val(data.degree);
                        $('#field_of_study').val(data.field_of_study);
                        $('#grade').val(data.grade);
                        $('#description').val(data.description);

                        // ✅ CORRECT SELECT
                        $('#edu_end_year').prop('disabled', false);
                        $('#edu_end_year').val(String(data.end_date));

                        $('#row_id').val(data.id);
                        $('#flag').val('U');

                        $('#EducationAdd').show();
                        $('#Educationlist').hide();
                    }
                }
            });
        }




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
                // start_date: {
                //     required: true
                // },
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

            let form = $(this);
            let formData = new FormData(form[0]); // ✅ FIX

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var flag = $("#flag").val();
            var id = $("#row_id").val();
            var url = "";
            var type = "";

            if (flag == "A") {
                type = "POST";
                url = "{{ route('education-action.store') }}";
            } else {
                type = "POST"; // PATCH via _method
                url = "{{ url('education-action') }}/" + id;
                formData.append('_method', 'PATCH');
            }

            LoaderShow();

            $.ajax({
                type: type,
                url: url,
                data: formData,
                processData: false, // ✅ REQUIRED
                contentType: false, // ✅ REQUIRED
                success: function(response) {   
                    LoaderHide();
                    if (response.status === 1) {
                        Swal.fire('Success!', response.message, 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    LoaderHide();
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
    <script>
        function DeleteWorkExperience(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to delete Work Experience?",
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
                        url: "{{ url('work-experience-action') }}/" + id,
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

        function EditWorkExperience(id) {
            LoaderShow();
            $.ajax({
                url: `{{ url('work-experience-action/${id}/edit') }}`, // Adjust route as needed
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    LoaderHide();
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

                        $("#row_id").val(data.id);
                        $("#flag").val("U");

                        document.getElementById("WorkExperienceAdd").style.display = "block";
                        document.getElementById("WorkExperiencelist").style.display = "none";

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message,
                        });
                    }
                },
                error: function() {
                    LoaderHide();
                    // ErrorMsg('Something went wrong.');
                }
            });
        }


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

            let form = $(this);
            // let url = form.attr('action');
            let formData = form.serialize(); // Use FormData for file uploads

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var flag = $("#flag").val();

            var id = $("#row_id").val();
            var url = "";
            var type = "";
            if (flag == "A") {
                type = "POST";
                url = "{{ route('work-experience-action.store') }}";
            } else {
                type = "PATCH";
                url = "{{ url('work-experience-action') }}/" + id;
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
                        form[0].reset();
                        validator.resetForm();

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
                    // ErrorMsg(response.message);
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
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message,
                                    });
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
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message,
                                    });
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

                        // LoaderShow();

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            success: function(response) {
                                LoaderHide();
                                if (response.status === 1) {
                                    window.pincodes = response.data;
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message,
                                    });
                                }
                            },
                            error: function(xhr) {
                                // LoaderHide();
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
        const AreaSuggestBox = document.getElementById('AreaSuggestBox'); // Area suggestion box

        // Prevent form submission on Enter key in pincode field
        PincodeSelect.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                return false;
            }
        });

        PincodeSelect.addEventListener('input', function() {
            const query = this.value.trim();
            PincodeSuggestionsBox.innerHTML = '';
            AreaSuggestBox.innerHTML = ''; // Clear previous area suggestions

            if (query.length === 0 || !Array.isArray(window.pincodes)) {
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
                        
                        // Clear area suggestions when pincode is selected
                        AreaSuggestBox.innerHTML = '';
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

            let form = $(this)[0]; // ✅ Native DOM element
            let formData = new FormData(form); // ✅ Handles text + file inputs

            let id = $("#row_id").val();
            let url = "{{ url('candidate-profile-about-skill') }}/" + id;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false, // ✅ Important for FormData
                contentType: false, // ✅ Important for FormData
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

                LoaderShow();

                $.ajax({
                    type: "POST",
                    url: "{{ route('sub-category-action') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        LoaderHide();
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
                        LoaderHide();
                        // ErrorMsg("Something went wrong while fetching sub categories.");
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

                LoaderShow();

                $.ajax({
                    type: "POST",
                    url: "{{ route('skill-fetch-action') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        LoaderHide();
                        if (response.status === 1) {

                            let skillData = response.data;

                            skillData.forEach(item => {
                                if (item.skill_nm) {
                                    let skills = item.skill_nm.split(',');
                                    window.skills_arr = skills;
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message,
                            });
                        }
                    },
                    error: function() {
                        LoaderHide();
                        // ErrorMsg("Something went wrong while fetching Skills.");
                    }
                });
            });

            let selectedCategory = "{{ $user->category_id ?? '' }}";
            let selectedSubCategory = "{{ $user->sub_category_id ?? '' }}";

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



        let validator_change_password = $("#change-password-form").validate({
            rules: {
                old_password: {
                    required: true
                },
                new_password: {
                    required: true,
                    minlength: 6
                },
                new_password_confirmation: {
                    required: true,
                    equalTo: "#new_password"
                }
            },
            messages: {
                old_password: {
                    required: "Please enter your current password"
                },
                new_password: {
                    required: "Please enter a new password",
                    minlength: "Password must be at least 8 characters"
                },
                new_password_confirmation: {
                    required: "Please confirm your new password",
                    equalTo: "Passwords do not match"
                }
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                
                 if (element.attr('type') === "password" && element.closest('.input-group').length) {
                    // console.log('incdoition');
                        error.insertAfter(element.closest('.input-group'));
                    } else {
                        error.insertAfter(element);
                    }
                // error.insertAfter(element);
            },
            highlight: function(element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            }
        });

        $("#change-password-form").submit(function(e) {
            e.preventDefault();

            if (!$(this).valid()) {
                return;
            }

            let form = $(this)[0];
            let formData = new FormData(form);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            LoaderShow();

            $.ajax({
                type: "POST",
                url: "{{ route('password.change') }}", // ✅ Use the correct named route
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    LoaderHide();
                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                        });

                        $("#change-password-form")[0].reset();
                        validator_change_password.resetForm();
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
                    let errorMsg = "Something went wrong";
                    try {
                        const res = JSON.parse(xhr.responseText);
                        errorMsg = res.message || errorMsg;
                    } catch (e) {}
                    console.log(errorMsg);
                }
            });
        });



        function handleFresherCheckbox() {
            const checkbox = document.getElementById('is_fresher');
            const designationInput = document.getElementById('designation');

            if (checkbox.checked) {
                designationInput.value = 'Fresher';
                designationInput.readOnly = true;
            } else {
                designationInput.value = '';
                designationInput.readOnly = false;
            }
        }

        // Optional: Keep checkbox checked if value was already 'Fresher'
        document.addEventListener("DOMContentLoaded", function() {
            const designationInput = document.getElementById('designation');
            const checkbox = document.getElementById('is_fresher');
            if (designationInput.value === 'Fresher') {
                checkbox.checked = true;
                designationInput.readOnly = true;
            }
        });


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

            let form = $(this)[0]; // ✅ Native DOM element
            let formData = new FormData(form); // ✅ Handles text + file inputs

            let id = $("#row_id").val();
            let url = "{{ url('candidate-profile-action') }}/" + id;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            LoaderShow();

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false, // ✅ Important for FormData
                contentType: false, // ✅ Important for FormData
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

                    let errorMsg = "Something went wrong";
                    try {
                        const res = JSON.parse(xhr.responseText);
                        errorMsg = res.message || errorMsg;
                    } catch (e) {}

                    console.log(errorMsg)
                }
            });
        });

        // Optional: remove image
        function removeProfileImage() {
            $('#remove_img').val(1);
            $('#profilePreview').attr('src', '{{ asset('uploads/profile/profile.png') }}');
            $('#profile_img').val('');
        }

        function AddWorkExperience() {
            document.getElementById("WorkExperienceAdd").style.display = "block";
            document.getElementById("WorkExperiencelist").style.display = "none";
        }

        function BackWorkExperience() {
            document.getElementById("WorkExperiencelist").style.display = "block";
            document.getElementById("WorkExperienceAdd").style.display = "none";
        }


        function AddEducation() {
            document.getElementById("EducationAdd").style.display = "block";
            document.getElementById("Educationlist").style.display = "none";
        }

        function BackEducation() {
            document.getElementById("Educationlist").style.display = "block";
            document.getElementById("EducationAdd").style.display = "none";
        }

        $(document).ready(function() {
            // On page load, set the initial state
            toggleEndDate();

            // When checkbox changed
            $('#currently_working').change(function() {
                toggleEndDate();
            });

            function toggleEndDate() {
                if ($('#currently_working').is(':checked')) {
                    $('#end_date').prop('disabled', true);
                    // Optional: Clear the end_date value when disabled
                    $('#end_date').val('');
                } else {
                    $('#end_date').prop('disabled', false);
                }
            }
        });
    </script>
    
    <!--old_password ,new_password ,new_password_confirmation-->
      <script>
document.getElementById("togglePassword").addEventListener("click", function() {
    const passwordInput = document.getElementById("old_password");
    const icon = this.querySelector("i");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
});

document.getElementById("togglePassword2").addEventListener("click", function() {
    const passwordInput = document.getElementById("new_password");
    const icon = this.querySelector("i");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
});


document.getElementById("togglePassword3").addEventListener("click", function() {
    const passwordInput = document.getElementById("new_password_confirmation");
    const icon = this.querySelector("i");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
});

let cropper = null;
// Profile image preview with STRICT 100x100 validation
document.getElementById('profile_img').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(event){
        document.getElementById('cropModal').style.display="flex";
        const cropImg = document.getElementById('cropImage');
        cropImg.src = event.target.result;

        if (cropper) cropper.destroy();

        // cropper = new Cropper(cropImg, {
        //     viewMode:1,
        //     dragMode:'move',
        //     zoomable:false,
        //     scalable:false,
        //     movable:true,
        //     cropBoxMovable:false,
        //     cropBoxResizable:false,
        //     background:false,
        //     aspectRatio:1,
        //     ready(){
        //         let box = this.cropper;
        //         const area = box.getContainerData();
        //         box.setCropBoxData({
        //             width:100,
        //             height:100,
        //             left:(area.width-100)/2,
        //             top:(area.height-100)/2
        //         });
        //     }
        // });
        cropper = new Cropper(cropImg, {
            viewMode: 1,
            aspectRatio: 1,

            // 🔒 IMAGE SIZE LOCK
            zoomable: false,
            scalable: false,
            zoomOnWheel: false,
            zoomOnTouch: false,

            // 🔒 CROP BOX LOCK
            cropBoxMovable: false,
            cropBoxResizable: false,

            // ✅ IMAGE MOVE ONLY
            dragMode: 'move',
            movable: true,

            background: false,
            guides: false,
            center: false,
            highlight: false,

            toggleDragModeOnDblclick: false, // 🔥 double click zoom OFF

            ready() {
                const cropper = this.cropper;
                const area = cropper.getContainerData();

                cropper.setCropBoxData({
                    width: 100,
                    height: 100,
                    left: (area.width - 100) / 2,
                    top: (area.height - 100) / 2
                });
            }
        });
    };

    reader.readAsDataURL(file);
});




document.getElementById('cropSave').addEventListener('click', function () {
    if (!cropper) return;

    let canvas = cropper.getCroppedCanvas({ width: 100, height: 100 });

    // replace preview
    document.getElementById('profilePreview').src = canvas.toDataURL();

    // create Blob & convert to File
    canvas.toBlob(function(blob){
        let file = new File([blob], "profile.png", {type:"image/png"});

        // create virtual file input replacement
        let dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);

        document.getElementById('profile_img').files = dataTransfer.files;
    });

    closeCropModal();
});
document.getElementById('cropCancel').addEventListener('click', closeCropModal);

function closeCropModal(){
    document.getElementById('cropModal').style.display="none";
    if(cropper) cropper.destroy();
}


// Remove profile image function
function removeProfileImage() {
    $('#remove_img').val(1);
    $('#profilePreview').attr('src', '{{ asset('uploads/profile/profile.png') }}');
    $('#profile_img').val('');
}
function toggleDescription(id) {
    let desc = document.getElementById("desc-" + id);
    let toggleBtn = desc.nextElementSibling;

    if (desc.classList.contains("expanded")) {
        // Collapse
        desc.classList.remove("expanded");
        toggleBtn.innerHTML = "Read more...";
    } else {
        // Expand
        desc.classList.add("expanded");
        toggleBtn.innerHTML = "Read less";
    }
}

</script>
<script>
$(document).on('click', '.delete-resume', function () {

    let resumeId = $(this).data('resume-id');

    console.log('Resume ID to delete:', resumeId);

    let url = "{{ route('resume.delete') }}";

    Swal.fire({
        title: 'Are you sure?',
        text: "This resume will be deleted permanently!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    _token: "{{ csrf_token() }}",
                    resume_id: resumeId
                },
                success: function (response) {
                    if (response.status === 1) {

                        // 🔥 remove row without reload
                        $('#resume-row-' + resumeId).remove();

                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        );

                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Something went wrong', 'error');
                }
            });

        }
    });
});

// View My Internship Details
function viewMyInternship(internshipId) {
    console.log('Viewing internship ID:', internshipId);
    // Redirect to my internship details page
    window.location.href = '{{ route("my-internship-details") }}?id=' + internshipId;
}
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

@endpush
