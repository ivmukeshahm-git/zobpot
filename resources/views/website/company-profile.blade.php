@push('css')
    <style>
        .select2-selection__clear {
            display: none !important;
        }
        /* Select2 main box (single) */
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

        /* Select2 multi (Subcategory) — match Category look */
        .select2-container--default .select2-selection--multiple {
            height: auto !important;
            min-height: 46px !important;
            border: 1px solid #E0E6F7 !important;
            border-radius: 4px !important;
            background-color: #ffffff !important;
            padding: 6px 12px !important;
            width: 100% !important;
            font-size: 14px !important;
            line-height: 22px !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: 1px solid #E0E6F7 !important;
            outline: 0 !important;
            box-shadow: none !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            padding: 0 !important;
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            gap: 4px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
            color: #A0ABB8 !important;
            margin-top: 4px !important;
            margin-left: 3px !important;
            font-size: 14px !important;
            line-height: 22px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #F0F4FF !important;
            border: 1px solid #E0E6F7 !important;
            border-radius: 4px !important;
            color: #05264E !important;
            padding: 2px 8px !important;
            margin: 2px 0 !important;
            font-size: 13px !important;
            line-height: 20px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #A0ABB8 !important;
            margin-right: 4px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field {
            margin-top: 4px !important;
            font-size: 14px !important;
            color: #A0ABB8 !important;
            min-height: 22px !important;
        }

        /* Dropdown options */
        .select2-dropdown {
            border: 1px solid #E0E6F7 !important;
            border-radius: 4px !important;
        }

        .select2-results__options,
        .select2-results__option,
        .select2-selection__rendered {
            list-style: none !important;
            list-style-type: none !important;
        }

        .select2-results__options {
            padding-left: 0 !important;
            margin: 0 !important;
        }

        #internship_sub_category_id + .select2-container {
            width: 100% !important;
        }

        .internship-other-row .other-toggle-link {
            display: inline-block;
            margin-top: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #05264e;
            text-decoration: none;
            border-bottom: 1px dashed #3c65f5;
            line-height: 1.2;
        }

        .internship-other-row .other-toggle-link:hover {
            color: #3c65f5;
        }

        .internship-other-row .other-field-hint {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: #6c757d;
        }

        .internship-other-row.is-other-mode .select-wrap {
            display: none !important;
        }

        .card-grid-2 {
            overflow: visible !important;
        }

        #createjob {
            display: none;
        }
        
          /* Preview Section Styling */
        #internship-preview .card {
            border: none;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
        }

        #internship-preview .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }

        #internship-preview .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            border-bottom: none;
        }

        #internship-preview .card:nth-child(2) .card-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        #internship-preview .card:nth-child(3) .card-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        #internship-preview .card:nth-child(4) .card-header {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        #internship-preview .card-header h5 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }

        #internship-preview .card-body {
            padding: 25px;
            background: #ffffff;
        }

        #internship-preview label.text-muted {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            color: #8898aa !important;
            margin-bottom: 5px;
            display: block;
        }

        #internship-preview p.fw-semibold {
            font-size: 15px;
            color: #2d3748;
            font-weight: 600;
        }

        #internship-preview .badge {
            padding: 8px 15px;
            font-size: 13px;
            font-weight: 500;
            border-radius: 20px;
        }

        #internship-preview .bg-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        #internship-preview .bg-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
        }

        #internship-preview .border.rounded {
            border: 2px solid #e9ecef !important;
            border-radius: 10px !important;
            padding: 15px;
            background: #f8f9fa;
            min-height: 100px;
        }

        .skill-input-container, .eligibility_criteria_input_container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-height: 50px;
            background: #fff;
        }

        .skill-input-container input, .eligibility_criteria_input_container input {
            border: none;
            outline: none;
            flex: 1;
            min-width: 200px;
        }

        .skill-tag, .eligibility-tag {
            background: #05264e;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .skill-tag .remove-skill, .eligibility-tag .remove-eligibility {
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
        }

        .skill-tag .remove-skill:hover, .eligibility-tag .remove-eligibility:hover {
            color: #ff6b6b;
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
    <style>
        /* ============================================
   JOB CARD — FINAL FIXED HEIGHT + CLEAN SPACING
   ============================================ */

        .job-card-simple {
            background: #F8FAFF;
            border-radius: 16px;
            padding: 14px !important;
            margin: 14px 0 !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            border: 1px solid #242a65;
            transition: 0.3s ease;
            cursor: pointer;

            /* Auto height with equal row stretch */
            height: 100%;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            position: relative;
        }

        .job-card-simple:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(36, 42, 101, 0.12);
            border-color: #242a65;
        }

        /* Badge - Work Type */
        .job-badge {
            background: #f36825;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            position: absolute;
            top: 10px;
            left: 14px;
            box-shadow: 0 2px 6px rgba(243, 104, 37, 0.25);
        }

        /* Main Content Block */
        .job-main {
            padding-top: 38px; /* space below badge */
            flex: 1 1 auto;
        }

        .job-title {
            font-size: 18px;
            font-weight: 700;
            color: #242a65;
            margin-bottom: 6px;
            line-height: 1.4;

            /* Allow only 2 lines */
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Status Badge */
        .badge {
            font-size: 11px;
            padding: 5px 12px;
        }

        /* Location */
        .location {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-top: 6px;
            color: #444;
        }

        .location span {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            word-break: break-word;
        }

        .location i {
            color: #f36825;
        }

        /* Job Details Box */
        .job-details {
            background: #f0f3ff;
            padding: 12px;
            border-radius: 12px;
            margin-top: auto;
            font-size: 14px;
        }

        .detail {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #555;
        }

        .detail i {
            color: #242a65;
        }

        /* Apply History Button */
        .view-btn {
            background: #242a65;
            color: white !important;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            width: 100%;
            margin-top: 10px;
            transition: 0.25s ease;
        }

        .view-btn:hover {
            background: #f36825;
            transform: translateY(-2px);
        }

     
  #createInternship {
            display: none;
        }
    </style>
    
    
<style>
/* ============================================
   OPPORTUNITY CARDS — premium SaaS redesign
   Scoped to .internship-card-simple only
   ============================================ */
.internship-card-simple {
    --oc-primary: #2563EB;
    --oc-text: #0F172A;
    --oc-muted: #64748B;
    --oc-border: #E5E7EB;
    --oc-surface: #F8FAFC;
    background: #FFFFFF;
    border-radius: 20px;
    padding: 0 !important;
    margin: 0 0 8px !important;
    box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04), 0 8px 24px rgba(15, 23, 42, 0.06);
    border: 1px solid var(--oc-border);
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    height: 100%;
    min-height: 320px;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
}

.internship-card-simple:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(37, 99, 235, 0.12);
    border-color: #BFDBFE;
}

.internship-card-simple .oc-card-top {
    padding: 16px 16px 0;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}

.internship-card-simple .job-badge,
.internship-card-simple .oc-mode-badge {
    position: static !important;
    top: auto !important;
    left: auto !important;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #EFF6FF !important;
    color: var(--oc-primary) !important;
    border: 1px solid #BFDBFE;
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    box-shadow: none !important;
    letter-spacing: 0.01em;
}

.internship-card-simple .action-buttons-container {
    position: static !important;
    top: auto !important;
    right: auto !important;
    display: flex !important;
    gap: 6px;
    z-index: 10;
    flex-shrink: 0;
}

.internship-card-simple .action-buttons-container .btn {
    width: 34px;
    height: 34px;
    padding: 0 !important;
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    border-radius: 10px !important;
    border: 1px solid var(--oc-border) !important;
    background: #fff !important;
    box-shadow: none !important;
    transition: background 0.15s ease, border-color 0.15s ease, color 0.15s ease, transform 0.15s ease;
}

.internship-card-simple .action-buttons-container .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(15, 23, 42, 0.08) !important;
}

.internship-card-simple .oc-btn-edit { color: var(--oc-primary) !important; }
.internship-card-simple .oc-btn-edit:hover { background: #EFF6FF !important; border-color: #BFDBFE !important; }

.internship-card-simple .oc-btn-toggle-on { color: #059669 !important; }
.internship-card-simple .oc-btn-toggle-on:hover { background: #ECFDF5 !important; border-color: #A7F3D0 !important; }

.internship-card-simple .oc-btn-toggle-off { color: #64748B !important; }
.internship-card-simple .oc-btn-toggle-off:hover { background: #F1F5F9 !important; border-color: #CBD5E1 !important; }

.internship-card-simple .oc-btn-delete { color: #DC2626 !important; }
.internship-card-simple .oc-btn-delete:hover { background: #FEF2F2 !important; border-color: #FECACA !important; }

.internship-card-simple .job-main,
.internship-card-simple .oc-card-body {
    padding: 14px 18px 8px !important;
    flex: 1 1 auto;
}

.internship-card-simple .job-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--oc-text);
    margin: 0 0 10px;
    line-height: 1.35;
    letter-spacing: -0.02em;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.internship-card-simple .oc-status-row {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 12px;
}

.internship-card-simple .badge,
.internship-card-simple .oc-status {
    font-size: 11px !important;
    font-weight: 600 !important;
    padding: 4px 10px !important;
    border-radius: 999px !important;
    border: 1px solid transparent;
    letter-spacing: 0.01em;
}

.internship-card-simple .badge.bg-success,
.internship-card-simple .oc-status-approved {
    background: #ECFDF5 !important;
    color: #047857 !important;
    border-color: #A7F3D0 !important;
}

.internship-card-simple .badge.bg-primary,
.internship-card-simple .oc-status-active {
    background: #EFF6FF !important;
    color: #1D4ED8 !important;
    border-color: #BFDBFE !important;
}

.internship-card-simple .badge.bg-secondary,
.internship-card-simple .oc-status-closed {
    background: #F1F5F9 !important;
    color: #475569 !important;
    border-color: #E2E8F0 !important;
}

.internship-card-simple .badge.bg-danger,
.internship-card-simple .oc-status-rejected {
    background: #FEF2F2 !important;
    color: #B91C1C !important;
    border-color: #FECACA !important;
}

.internship-card-simple .badge.bg-warning,
.internship-card-simple .oc-status-pending {
    background: #FFFBEB !important;
    color: #B45309 !important;
    border-color: #FDE68A !important;
}

.internship-card-simple .badge.bg-info,
.internship-card-simple .oc-status-college {
    background: #ECFEFF !important;
    color: #0E7490 !important;
    border-color: #A5F3FC !important;
}

.internship-card-simple .location {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    margin-top: 0;
    color: var(--oc-muted);
    font-size: 13px;
    line-height: 1.45;
}

.internship-card-simple .location i {
    color: var(--oc-primary);
    margin-top: 2px;
}

.internship-card-simple .location span {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    word-break: break-word;
}

.internship-card-simple .job-details,
.internship-card-simple .oc-meta {
    background: var(--oc-surface) !important;
    border-top: 1px solid var(--oc-border);
    padding: 12px 18px !important;
    border-radius: 0 !important;
    margin-top: auto;
    display: flex;
    flex-wrap: wrap;
    gap: 14px 18px;
    font-size: 13px;
}

.internship-card-simple .detail {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: var(--oc-muted);
    font-weight: 500;
}

.internship-card-simple .detail i {
    color: var(--oc-primary);
    width: 16px;
    text-align: center;
}

.internship-card-simple .oc-card-footer {
    padding: 12px 18px 16px;
    background: #fff;
}

.internship-card-simple .view-btn,
.internship-card-simple .oc-view-btn {
    display: flex !important;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    height: 44px;
    margin-top: 0 !important;
    background: linear-gradient(135deg, #2563EB, #4F46E5) !important;
    color: #fff !important;
    border: none !important;
    border-radius: 12px !important;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none !important;
    box-shadow: 0 8px 18px rgba(37, 99, 235, 0.25);
    transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
}

.internship-card-simple .view-btn:hover,
.internship-card-simple .oc-view-btn:hover {
    background: linear-gradient(135deg, #1D4ED8, #4338CA) !important;
    color: #fff !important;
    transform: translateY(-1px);
    box-shadow: 0 10px 22px rgba(37, 99, 235, 0.32);
    text-decoration: none !important;
}

/* Filter chips polish (Internship tab only) */
#Internshiplist .d-flex.gap-3.mb-4 {
    flex-wrap: wrap;
    gap: 8px !important;
}
#Internshiplist .d-flex.gap-3.mb-4 .btn {
    border-radius: 999px !important;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 14px;
}

/* Action / filter shared hover (keep existing filter colors) */
.action-buttons-container .btn {
    transition: all 0.2s ease;
}
.btn-outline-primary.active,
.btn-outline-success.active,
.btn-outline-warning.active,
.btn-outline-danger.active {
    color: white !important;
}
.btn-outline-primary { border-color: #3b7ddd; color: #3b7ddd; }
.btn-outline-primary:hover,
.btn-outline-primary.active { background-color: #3b7ddd; border-color: #3b7ddd; }
.btn-outline-success { border-color: #10b981; color: #10b981; }
.btn-outline-success:hover,
.btn-outline-success.active { background-color: #10b981; border-color: #10b981; }
.btn-outline-warning { border-color: #f59e0b; color: #f59e0b; }
.btn-outline-warning:hover,
.btn-outline-warning.active { background-color: #f59e0b; border-color: #f59e0b; }
.btn-outline-info { border-color: #06b6d4; color: #06b6d4; }
.btn-outline-info:hover,
.btn-outline-info.active { background-color: #06b6d4; border-color: #06b6d4; }
.btn-outline-danger { border-color: #ef4444; color: #ef4444; }
.btn-outline-danger:hover,
.btn-outline-danger.active { background-color: #ef4444; border-color: #ef4444; }

@media (max-width: 575.98px) {
    .internship-card-simple { min-height: 0; }
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
               
                <div class="banner-hero banner-image-single">
                    <img
                        src="{{asset('uploads/profile/company.jpeg') }}"
                        alt="jobbox">
                        <!-- <a class="btn-editor" href="#"></a> -->    
                        </div>
                        
                       
                    <div class="box-company-profile" @if($user->cover_img == "") style="margin-top:30px;"  @endif>
                    <!-- <div class="image-compay"><img
                            src="{{ $user->profile_img ? asset('uploads/profile/' . $user->profile_img) : asset('uploads/profile/profile.png') }}"
                            style="max-width:100px;" alt="Profile Image"></div> -->
                    <div class="row mt-10">
                        <div class="col-lg-8 col-md-12">
                            <h5 class="f-18">{{ $user->name }} <span
                                    class="card-location font-regular ml-20">{{ $user->address }}</span></h5>
                            <p class="mt-0 font-md color-text-paragraph-2 mb-15">{{ $user->designation }}</p>
                            <p class="mt-0 mb-1 font-md color-text-paragraph-2"
                                style="font-size: 14px !important;font-weight: 600;"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp; Phone: {{ $userData->contact_no }}</p>
                            <p class="mt-0 mb-1 font-md color-text-paragraph-2"
                                style="font-size: 14px !important;font-weight: 600;"><i class="fa fa-envelope"
                                    aria-hidden="true"></i>&nbsp; Email: {{ $userData->email }}</p>
                        </div>
                        <div class="col-lg-4 col-md-12 text-lg-end"><a class="btn btn-preview-icon btn-apply btn-apply-big"
                                href="{{ route('company-profile-detail', ['id' => $user->id]) }}">Preview</a></div>
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
                            <ul class="nav" role="tablist">
                                <li><a class="btn btn-border recruitment-icon mb-20 active" href="#tab-my-jobs"
                                        data-bs-toggle="tab" role="tab" aria-controls="tab-my-jobs"
                                        aria-selected="false">My Jobs</a></li>
                                        <li><a class="btn btn-border recruitment-icon mb-20" href="#tab-my-internships"
                                        data-bs-toggle="tab" role="tab" aria-controls="tab-my-Internship"
                                        aria-selected="false">Internship</a></li>
                                <li><a class="btn btn-border aboutus-icon mb-20 " href="#tab-my-profile"
                                        data-bs-toggle="tab" role="tab" aria-controls="tab-my-profile"
                                        aria-selected="true">Company Account</a></li>
                                <li><a class="btn btn-border aboutus-icon mb-20" href="#tab-about" data-bs-toggle="tab"
                                        role="tab" aria-controls="tab-about" aria-selected="true">Company About Us</a></li>
                                <li><a class="btn btn-border recruitment-icon mb-20" href="#tab-change-password"
                                        data-bs-toggle="tab" role="tab" aria-controls="tab-change-password"
                                        aria-selected="false">Change Password</a></li>
                                <li><a class="btn btn-border recruitment-icon mb-20" href="#tab-membership-history"
                                        data-bs-toggle="tab" role="tab" aria-controls="tab-membership-history"
                                        aria-selected="false">Membership History</a></li>
                            </ul>
                            <div class="border-bottom pt-10 pb-10"></div>
                            <!--<div class="mt-20 mb-20"><a class="link-red" href="#">Delete Account</a></div>-->
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-12 col-12 mb-50">
                        <div class="content-single">
                            <div class="tab-content">
                                <div class="tab-pane fade" id="tab-my-internships" role="tabpanel"
                                    aria-labelledby="tab-my-Internship">
                                    <div id="Internshiplist">
                                        <div class="row mb-5">
                                            <div class="col-lg-6 col-md-6 col-5">
                                                <h3 class="mt-0 color-brand-1 mb-50">My Internship</h3>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-7 text-right" style="text-align: right;">
                                                @if(empty($hideCreateInternshipBtn))
                                                <a class="btn btn-preview-icon btn-apply btn-apply-big"
                                                    style="padding: 14px 30px 14px 30px;" href="javascript:void(0);"
                                                    onclick="CreateInternships()"><i class="fa fa-plus"></i>&nbsp; Create
                                                    New
                                                    Internship</a>
                                                @else
                                                <a class="btn btn-preview-icon btn-apply btn-apply-big"
                                                    style="padding: 14px 30px 14px 30px; opacity: 0.65;" href="javascript:void(0);"
                                                    onclick="showPlanLimitAlert('internship')"><i class="fa fa-lock"></i>&nbsp; Upgrade Plan</a>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row display-list">
                                            <!-- Filter Buttons -->
                                            <div class="d-flex gap-3 mb-4">
                                                <a href="?filter=all"
                                                    class="btn btn-outline-primary {{ $filter == 'all' ? 'active' : '' }}">
                                                    <i class="fa fa-list"></i> All Internship
                                                </a>
                                                <a href="?filter=approved"
                                                    class="btn btn-outline-success {{ $filter == 'approved' ? 'active' : '' }}">
                                                    <i class="fa fa-check-circle"></i> Approved
                                                </a>
                                                <a href="?filter=pending"
                                                    class="btn btn-outline-warning {{ $filter == 'pending' ? 'active' : '' }}">
                                                    <i class="fa fa-clock-o"></i> Pending Approval
                                                </a>
                                                <a href="?filter=completed"
                                                    class="btn btn-outline-info {{ $filter == 'completed' ? 'active' : '' }}">
                                                    <i class="fa fa-flag-checkered"></i> Completed
                                                </a>
                                                <a href="?filter=college_pending"
                                                    class="btn btn-outline-dark {{ $filter == 'college_pending' ? 'active' : '' }}">
                                                    <i class="fa fa-flag"></i> College Pending
                                                </a>
                                                <a href="?filter=rejected"
                                                    class="btn btn-outline-danger {{ $filter == 'rejected' ? 'active' : '' }}">
                                                    <i class="fa fa-times-circle"></i> Rejected
                                                </a>
                                            </div>

                                            @if (count($InternshipData) > 0)
                                                @foreach ($InternshipData as $internship)
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mt-4">
                                                        <div class="internship-card-simple position-relative"
                                                            @if ($internship->approve_status == 1)
                                                                onclick="window.location.href='{{ route('internship.detail', ['slugOrId' => $internship->slug ?? $internship->id]) }}'"
                                                                style="cursor: pointer;"
                                                            @else
                                                                style="cursor: default;"
                                                            @endif>

                                                            <div class="oc-card-top">
                                                                <div class="job-badge oc-mode-badge">
                                                                    {{ $internship->mode }}
                                                                </div>

                                                                <div class="action-buttons-container">
                                                                    <a href="javascript:void(0);"
                                                                        onclick="event.stopPropagation(); EditInternship({{ $internship->id }})"
                                                                        class="btn btn-sm oc-btn-edit"
                                                                        title="Update Internship">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </a>

                                                                    @if ($internship->complete_status == 0)
                                                                        <a href="javascript:void(0);"
                                                                            onclick="event.stopPropagation(); changeInternshipStatus({{ $internship->id }}, 1)"
                                                                            title="Mark as Closed"
                                                                            class="btn btn-sm oc-btn-toggle-on">
                                                                            <i class="fa fa-toggle-on"></i>
                                                                        </a>
                                                                    @else
                                                                        <a href="javascript:void(0);"
                                                                            onclick="event.stopPropagation(); changeInternshipStatus({{ $internship->id }}, 0)"
                                                                            title="Mark as Active"
                                                                            class="btn btn-sm oc-btn-toggle-off">
                                                                            <i class="fa fa-toggle-off"></i>
                                                                        </a>
                                                                    @endif

                                                                    <a href="javascript:void(0);"
                                                                        onclick="event.stopPropagation(); deleteInternship({{ $internship->id }})"
                                                                        class="btn btn-sm oc-btn-delete"
                                                                        title="Remove Internship">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                            <div class="job-main oc-card-body">
                                                                <h3 class="job-title">{{ $internship->internship_title }}</h3>

                                                                <div class="oc-status-row">
                                                                @if ($internship->approve_status == 1)
                                                                        <span class="badge bg-success rounded-pill oc-status-approved">
                                                                            <i class="fa fa-check-circle"></i> Approved
                                                                        </span>
                                                                        @if ($internship->complete_status == 0)
                                                                            <span class="badge bg-primary rounded-pill oc-status-active">
                                                                                <i class="fa fa-toggle-on"></i> Active
                                                                            </span>
                                                                        @else
                                                                            <span class="badge bg-secondary rounded-pill oc-status-closed">
                                                                                <i class="fa fa-lock"></i> Closed
                                                                            </span>
                                                                        @endif
                                                                @elseif($internship->approve_status == 2)
                                                                    <span class="badge bg-danger rounded-pill oc-status-rejected">
                                                                        <i class="fa fa-times-circle"></i> Rejected
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-warning rounded-pill oc-status-pending">
                                                                        <i class="fa fa-clock-o"></i> Pending Approval
                                                                    </span>
                                                                @endif

                                                                @if($internship->internship_type == 1 && $internship->company_complete_sts == 1 && $internship->college_complete_sts == 0 && $internship->complete_status == 0)
                                                                    <span class="badge bg-info rounded-pill oc-status-college">
                                                                        <i class="fa fa-flag"></i> College Pending
                                                                    </span>
                                                                @endif
                                                                </div>

                                                                <div class="location">
                                                                    <i class="fa fa-map-marker"></i>
                                                                    <span>{{ $internship->location }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="job-details oc-meta">
                                                                <div class="detail">
                                                                    <i class="fa fa-users"></i>
                                                                    <span>{{ $internship->apply_count }} Applied</span>
                                                                </div>
                                                                <div class="detail">
                                                                    <i class="fa fa-clock-o"></i>
                                                                    <span>{{ \Carbon\Carbon::parse($internship->created_at)->format('d M Y') }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="oc-card-footer">
                                                            <a
                                                                href="{{ route('internship.application.history', ['slug' => $internship->slug]) }}"
                                                                    class="view-btn oc-view-btn w-100"
                                                                    onclick="event.stopPropagation();">
                                                                View Apply History
                                                        </a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="row col-12 col-lg-12 col-md-12">
                                                    <h4 style="text-align: center;background: #eee;padding: 23px;">
                                                        No Internship Found
                                                    </h4>
                                                </div>
                                            @endif
                                        </div>
                                        @if ($JobData->lastPage() > 1)
                                            <div class="paginations mt-30">
                                                <ul class="pager">
                                                    {{-- Previous Page Link --}}
                                                    <li>
                                                        <a class="pager-prev {{ $JobData->onFirstPage() ? 'disabled' : '' }}"
                                                            href="{{ $JobData->previousPageUrl() ?? '#' }}">
                                                        </a>
                                                    </li>

                                                    {{-- Page Numbers --}}
                                                    @for ($i = 1; $i <= $JobData->lastPage(); $i++)
                                                        <li>
                                                            <a class="pager-number {{ $JobData->currentPage() == $i ? 'active' : '' }}"
                                                                href="{{ $JobData->url($i) }}">{{ $i }}</a>
                                                        </li>
                                                    @endfor

                                                    {{-- Next Page Link --}}
                                                    <li>
                                                        <a class="pager-next {{ !$JobData->hasMorePages() ? 'disabled' : '' }}"
                                                            href="{{ $JobData->nextPageUrl() ?? '#' }}">
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>

                                    <div id="createInternship">
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <h3 class="mt-0 color-brand-1 mb-50">Create Internship</h3>
                                            </div>
                                            <div class="col-lg-3 text-right">
                                                <a class="btn btn-preview-icon btn-apply btn-apply-big"
                                                    style="padding: 14px 30px 14px 30px;" href="javascript:void(0);"
                                                    onclick="BackJobInternship()"><i
                                                        class="fa fa-long-arrow-left"></i>&nbsp;
                                                    Back</a>
                                            </div>
                                        </div>

                                        <form id="internship-form" onsubmit="event.preventDefault(); event.stopPropagation(); console.log('Form submit blocked!'); return false;">
                                            <div class="row">
                                                <!-- Internship Details -->
                                                <div class="col-lg-6 mb-4">
                                                    <label class="form-label mb-2">Internship Title <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="internship_title" name="internship_title"
                                                        class="form-control" placeholder="e.g. Web Development Intern" />
                                                </div>

                                                <div class="col-lg-6 mb-4 internship-other-row" id="category-other-row">
                                                    <label class="form-label mb-2">Internship Category <span
                                                            class="text-danger">*</span></label>
                                                    <div class="select-wrap" id="category-select-wrap">
                                                        <select id="category_id" name="category_id"
                                                            class="form-control">
                                                            <option value="">Select Category</option>
                                                            @foreach($CategoryData as $category)
                                                                <option value="{{ $category->category_id }}">{{ $category->category_nm }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div id="other-category-wrap" style="display:none;">
                                                        <input type="text" id="other_category_name" name="other_category_name"
                                                            class="form-control" placeholder="Enter category name" />
                                                        <span class="other-field-hint">This will be sent to admin for approval.</span>
                                                    </div>
                                                    <a href="javascript:void(0);" id="toggle-other-category" class="other-toggle-link">Other</a>
                                                    <input type="hidden" id="use_other_category" name="use_other_category" value="0" />
                                                    <input type="hidden" id="category_request_id" name="category_request_id" value="" />
                                                </div>

                                                <div class="col-lg-6 mb-4 internship-other-row" id="subcategory-other-row">
                                                    <label class="form-label mb-2">Specialization  <span
                                                            class="text-danger">*</span></label>
                                                    <div class="select-wrap" id="subcategory-select-wrap">
                                                        <select id="internship_sub_category_id" name="sub_category_id[]"
                                                            class="form-control select2" multiple="multiple"
                                                            data-placeholder="Select Subcategory">
                                                        </select>
                                                    </div>
                                                    <div id="other-subcategory-wrap" style="display:none;">
                                                        <input type="text" id="other_subcategory_name" name="other_subcategory_name"
                                                            class="form-control" placeholder="Enter subcategory name" />
                                                        <span class="other-field-hint" id="other-subcategory-hint">This will be sent to admin for approval.</span>
                                                    </div>
                                                    <a href="javascript:void(0);" id="toggle-other-subcategory" class="other-toggle-link">Other</a>
                                                    <input type="hidden" id="use_other_subcategory" name="use_other_subcategory" value="0" />
                                                    <input type="hidden" id="subcategory_request_id" name="subcategory_request_id" value="" />
                                                </div>

                                           


                                                <div class="col-lg-6 mb-4">
                                                    <label for="company_website" class="form-label mb-2">Official Website
                                                        (Optional)</label>

                                                    <input type="text" id="company_website" name="company_website"
                                                        class="form-control" placeholder="https://www.example.com" />

                                                </div>


                                                <!-- Program Type -->
                                                <div class="col-lg-6 mb-4">
                                                    <label class="form-label mb-2">Mode <span
                                                            class="text-danger">*</span></label>
                                                    <select id="internship_mode" name="internship_mode"
                                                        class="form-control">
                                                        <option value="">Select Mode</option>
                                                        <option value="Online">Online</option>
                                                        <option value="Offline">Offline</option>
                                                        <option value="Hybrid">Hybrid</option>
                                                        <option value="Weekly">Weekly Internship</option>
                                                        <option value="Part Time">Part Time Internship</option>
                                                        <option value="Full Time">Full Time Internship</option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-6 mb-4">
                                                    <label class="form-label mb-2">Location <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" id="location" name="location"
                                                        class="form-control" placeholder="City / Office Location" />
                                                </div>

                                                <!-- Duration & Dates -->
                                                <div class="col-lg-6 mb-4 internship-other-row" id="duration-other-row">
                                                    <label class="form-label mb-2">Duration <span
                                                            class="text-danger">*</span></label>
                                                    <div class="select-wrap" id="duration-select-wrap">
                                                        <select id="duration_select" class="form-control">
                                                            <option value="">Select Duration</option>
                                                            <option value="1 Month">1 Month</option>
                                                            <option value="2 Months">2 Months</option>
                                                            <option value="3 Months">3 Months</option>
                                                            <option value="4 Months">4 Months</option>
                                                            <option value="5 Months">5 Months</option>
                                                            <option value="6 Months">6 Months</option>
                                                        </select>
                                                    </div>
                                                    <div id="other-duration-wrap" style="display:none;">
                                                        <input type="text" id="duration_other" class="form-control"
                                                            placeholder="Enter custom duration" />
                                                    </div>
                                                    <a href="javascript:void(0);" id="toggle-other-duration" class="other-toggle-link">Other</a>
                                                    <input type="hidden" name="duration" id="duration" value="" />
                                                    <input type="hidden" id="use_other_duration" value="0" />
                                                </div>

                                                <div class="col-lg-6 mb-4 internship-other-row" id="weeks-other-row">
                                                    <label class="form-label mb-2">Total Weeks <span
                                                            class="text-danger">*</span></label>
                                                    <div class="select-wrap" id="weeks-select-wrap">
                                                        <select id="weeks_select" class="form-control">
                                                            <option value="">Select Weeks</option>
                                                            <option value="4">4</option>
                                                            <option value="8">8</option>
                                                            <option value="12">12</option>
                                                            <option value="16">16</option>
                                                            <option value="20">20</option>
                                                            <option value="24">24</option>
                                                        </select>
                                                    </div>
                                                    <div id="other-weeks-wrap" style="display:none;">
                                                        <input type="number" id="weeks_other" class="form-control"
                                                            placeholder="Enter custom weeks" min="1" />
                                                    </div>
                                                    <a href="javascript:void(0);" id="toggle-other-weeks" class="other-toggle-link">Other</a>
                                                    <input type="hidden" name="weeks" id="weeks" value="" />
                                                    <input type="hidden" id="use_other_weeks" value="0" />
                                                </div>

                                                <div class="col-lg-6 mb-4 internship-other-row" id="hours-other-row">
                                                    <label class="form-label mb-2">Total Hours <span
                                                            class="text-danger">*</span></label>
                                                    <div class="select-wrap" id="hours-select-wrap">
                                                        <select id="hours_select" class="form-control">
                                                            <option value="">Select Hours</option>
                                                            <option value="60">60</option>
                                                            <option value="120">120</option>
                                                            <option value="240">240</option>
                                                            <option value="320">320</option>
                                                            <option value="360">360</option>
                                                        </select>
                                                    </div>
                                                    <div id="other-hours-wrap" style="display:none;">
                                                        <input type="number" id="hours_other" class="form-control"
                                                            placeholder="Enter custom hours" min="1" />
                                                    </div>
                                                    <a href="javascript:void(0);" id="toggle-other-hours" class="other-toggle-link">Other</a>
                                                    <input type="hidden" name="hours" id="hours" value="" />
                                                    <input type="hidden" id="use_other_hours" value="0" />
                                                </div>

                                                <div class="col-lg-6 mb-4">
                                                    <label class="form-label mb-2">Start Date <span
                                                            class="text-danger">*</span></label>
                                                    <input type="date" id="start_date" name="start_date"
                                                        class="form-control" />
                                                </div>

                                                <div class="col-lg-6 mb-4">
                                                    <label class="form-label mb-2">End Date <span
                                                            class="text-danger">*</span></label>
                                                    <input type="date" id="end_date" name="end_date"
                                                        class="form-control" />
                                                </div>

                                                <!-- Pay and Openings -->
                                                <div class="col-lg-6 mb-4">
                                                    <label class="form-label mb-2">Stipend (₹)</label>
                                                    <input type="number" id="stipend" name="stipend"
                                                        class="form-control" placeholder="Enter Stipend Amount" />
                                                </div>

                                                <div class="col-lg-6 mb-4">
                                                    <label class="form-label mb-2">Openings <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" id="openings" name="openings"
                                                        class="form-control" placeholder="Number of positions" />
                                                </div>

                                                <div class="col-lg-6 mb-4">
                                                    <label class="form-label mb-2">Application Deadline <span
                                                            class="text-danger">*</span></label>
                                                    <input type="date" id="application_deadline"
                                                        name="application_deadline" class="form-control" />
                                                </div>

                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label">
                                                        Select Batch Days <span class="text-danger">*</span>
                                                    </label>
                                                    <select id="batch_time" name="batch_time[]" class="form-control select2" multiple>
                                                        <option value="monday">Monday</option>
                                                        <option value="tuesday">Tuesday</option>
                                                        <option value="wednesday">Wednesday</option>
                                                        <option value="thursday">Thursday</option>
                                                        <option value="friday">Friday</option>
                                                        <option value="saturday">Saturday</option>
                                                        <option value="sunday">Sunday</option>
                                                    </select>
                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input" type="checkbox" id="all_week_days">
                                                        <label class="form-check-label" for="all_week_days">All Week</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div id="timeSectionFirst" class="mt-3 row"></div>
                                                    <div class="form-check my-2 w-100" id="copy_batch_times_wrap" style="display:none;">
                                                        <input class="form-check-input" type="checkbox" id="copy_batch_times">
                                                        <label class="form-check-label" for="copy_batch_times">Copy start &amp; end time to all days</label>
                                                    </div>
                                                    <div id="timeSections" class="row"></div>
                                                </div>


                                                <!-- Fees & GST -->
                                                <div class="col-lg-12">
                                                    <div id="feeSection" class="row">
                                                        <div class="col-lg-4 mb-4">
                                                            <label class="form-label mb-2">Enrollment Fee (₹)</label>
                                                            <input type="number" step="0.01" min="0"
                                                                id="internship_fee" name="internship_fee"
                                                                class="form-control" placeholder="Enter enrollment fee" />
                                                        </div>

                                                        <div class="col-lg-4 mb-4">
                                                            <label class="form-label mb-2">Late Registration Fee
                                                                (₹)</label>
                                                            <input type="number" step="0.01" min="0"
                                                                id="late_registration_fee" name="late_registration_fee"
                                                                class="form-control" placeholder="Enter late fee" />
                                                        </div>

                                                        <div class="col-lg-4 mb-4">
                                                            <label class="form-label mb-2">Last date of
                                                                registration</label>
                                                            <input type="date" id="last_registration_date"
                                                                name="last_registration_date" class="form-control"
                                                                placeholder="dd-mm-yyyy" />
                                                        </div>

                                                        <div class="col-lg-4 mb-4">
                                                            <label class="form-label mb-2">GST (%)</label>
                                                            <input type="number" step="0.01" min="0"
                                                                id="gst_percentage" name="gst_percentage"
                                                                class="form-control" value="18" />
                                                        </div>

                                                        <div class="col-lg-4 mb-4">
                                                            <label class="form-label mb-2">GST Amount (₹)</label>
                                                            <input type="number" step="0.01" min="0"
                                                                id="gst_amount" name="gst_amount" class="form-control"
                                                                placeholder="Auto calculated" readonly />
                                                        </div>

                                                        <div class="col-lg-4 mb-4">
                                                            <label class="form-label mb-2">Total Fee (Including
                                                                GST)</label>
                                                            <input type="number" step="0.01" min="0"
                                                                id="total_fee" name="total_fee" class="form-control"
                                                                placeholder="Auto calculated" readonly />
                                                        </div>
                                                    </div>
                                                </div>




                                                <!-- Skills & Requirements -->
                                                <div class="col-lg-12 mb-4">
                                                    <div class="form-group">
                                                        <label for="sk  ills">Required Skills</label>
                                                        <div id="skill-input-container" class="skill-input-container">
                                                            <input type="text" id="skills" name="skills"
                                                                placeholder="Type a skill and press Enter" />
                                                        </div>
                                                        <input type="hidden" name="required_skills"
                                                            id="required_skills">
                                                    </div>
                                                </div>


                                                <div class="col-lg-12 mb-4">
                                                    <div class="form-group mb-3">
                                                        <label for="eligibility_criteria">Eligibility Criteria</label>

                                                        <div id="eligibility_criteria_input_container"
                                                            class="eligibility_criteria_input_container">
                                                            <input type="text" id="eligibility_criteria"
                                                                placeholder="Type an Eligibility Criteria and press Enter">
                                                        </div>

                                                        <input type="hidden" name="required_eligibility_criteria"
                                                            id="required_eligibility_criteria">
                                                    </div>
                                                </div>



                                                <!-- Responsibilities & Description -->
                                                <div class="col-lg-12 mb-4">
                                                    <label class="form-label mb-2">Program Overview <span
                                                            class="text-danger">*</span></label>
                                                    <div id="full-editor-internship-description" style="height:200px; background:#fff;"></div>
                                                    <input type="hidden" name="internship_description" id="internship_description">
                                                </div>

                                         

                                                <div class="col-lg-12 mb-4">
                                                    <label class="form-label mb-2">Learning Objectives <span
                                                            class="text-danger">*</span></label>
                                                    <div id="full-editor-key-responsibilities" style="height:200px; background:#fff;"></div>
                                                    <input type="hidden" name="internship_objective" id="internship_objective">
                                                </div>

                                                <div class="col-lg-12 mb-4">
                                                    <label class="form-label mb-2">Module Brief Description <span
                                                            class="text-danger">*</span></label>
                                                    <div id="editor-module-desc" style="height:200px; background:#fff;"></div>
                                                    <input type="hidden" name="module_description" id="module_description">
                                                </div>

                                                <div class="col-lg-12 mb-4">
                                                    <label class="form-label mb-2">Skills You'll Gain <span
                                                            class="text-danger">*</span></label>
                                                    <div id="editor-industry-outcome" style="height:200px; background:#fff;"></div>
                                                    <input type="hidden" name="internship_outcome" id="internship_outcome">
                                                </div>

                                                <!-- Perks & Benefits -->
                                                <div class="col-lg-12 mb-4">
                                                    <label class="form-label mb-2">Perks & Benefits</label>
                                                    <select id="perks" name="perks[]" class="form-control select2" multiple>
                                                        <option value="Certificate">Certificate</option>
                                                        <option value="Letter of Recommendation">Letter of Recommendation</option>
                                                        <option value="Flexible Hours">Flexible Hours</option>
                                                        <option value="Mentorship">Mentorship</option>
                                                        <option value="5 Days a Week">5 Days a Week</option>
                                                        <option value="Free Snacks & Beverages">Free Snacks & Beverages</option>
                                                        <option value="Informal Dress Code">Informal Dress Code</option>
                                                        <option value="Job Offer">Job Offer</option>
                                                    </select>
                                                </div>

                                                <!-- Contact Person -->

                                            </div>


                                            <div class="text-end mt-4">
                                                <button type="reset" class="btn btn-secondary me-2">Reset</button>

                                                <input type="hidden" id="_method" name="_method" value="POST">
                                                <input type="hidden" id="flag" name="flag" value="A">
                                                <input type="hidden" id="row_id" name="row_id">

                                                <button type="button" id="saveInternshipBtn" class="btn btn-apply-big font-md font-bold">
                                                    <i class='fa fa-save'></i> <span id="btnText">Publish Internship</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                
                                <div class="tab-pane fade " id="tab-my-profile" role="tabpanel"
                                    aria-labelledby="tab-my-profile">
                                    <form id="company-profile-form" onsubmit="return false;">
                                        <h3 class="mt-0 mb-15 color-brand-1">Company Account</h3>

                                        <div class="row mt-10 mb-15">
                                            <div class="col-lg-12">
                                                <div class="main-button-file-upload-box">
                                                    <a class="font-md color-text-paragraph-2 mb-15" href="javascript:void(0);">Update
                                                        Your profile <b style="font-weight: 600;">( Profile Image Size : 100
                                                            X 100 )</b></a>
                                                    <div class="box-info-profie mt-2">
                                                        <div class="image-profile">
                                                            <img id="profilePreview"
                                                                {{-- src="{{ asset('uploads/profile/' . ($user->profile_img ?? 'profile.png')) }}" --}}
                                                                src="{{ 
                                                                    (!empty($user->profile_img) && file_exists(public_path('uploads/profile/'.$user->profile_img)))
                                                                        ? asset('uploads/profile/'.$user->profile_img)
                                                                        : asset('uploads/profile/candidate.jpg')
                                                                }}"
                                                                alt="Avatar" style="height: 85px;">
                                                        </div>
                                                        <a class="btn btn-apply" onclick="$('#profile_img').click()">Upload
                                                            Profile</a>
                                                        <a class="btn btn-link" onclick="removeProfileImage()">Delete</a>

                                                        <input type="file" name="profile_img" id="profile_img"
                                                            accept="image/*" style="display: none;">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="main-button-file-upload-box mt-2" style="height: auto; min-height: 180px;">
                                                        <a class="font-md color-text-paragraph-2 mb-15" href="javascript:void(0);">Authorized Company Signatory <b style="font-weight: 600;">( Signature Image )</b></a>
                                                        <div class="box-info-profie mt-2">
                                                            <div class="image-profile">
                                                                <img id="companySignaturePreview"
                                                                    src="{{ 
                                                                        (!empty($user->company_signature) && file_exists(public_path('uploads/profile/'.$user->company_signature)))
                                                                            ? asset('uploads/profile/'.$user->company_signature)
                                                                            : asset('assets/imgs/logo/logo1.png')
                                                                    }}"
                                                                    alt="Company Signature" style="max-width: 100%; height: 50px; object-fit: contain;">
                                                            </div>
                                                            <small class="d-block text-muted mb-1">Recommended Size: 300 x 80 px</small>
                                                            <a class="btn btn-apply" onclick="$('#company_signature').click()">Upload Signature</a>
                                                            <a class="btn btn-link" onclick="removeCompanySignature()">Delete</a>
                                                            <input type="file" name="company_signature" id="company_signature"
                                                                accept="image/*" style="display: none;">
                                                            <input type="hidden" name="remove_signature" id="remove_signature" value="0">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="main-button-file-upload-box mt-2" style="height: auto; min-height: 180px;">
                                                        <a class="font-md color-text-paragraph-2 mb-15" href="javascript:void(0);">Certificate Logo <b style="font-weight: 600;">( Company Logo on Certificate )</b></a>
                                                        <div class="box-info-profie mt-2">
                                                            <div class="image-profile">
                                                                <img id="certificateLogoPreview"
                                                                    src="{{ 
                                                                        (!empty($user->certificate_logo) && file_exists(public_path('uploads/profile/'.$user->certificate_logo)))
                                                                            ? asset('uploads/profile/'.$user->certificate_logo)
                                                                            : asset('assets/imgs/logo/logo1.png')
                                                                    }}"
                                                                    alt="Certificate Logo" style="max-width: 100%; height: 60px; object-fit: contain;">
                                                            </div>
                                                            <small class="d-block text-muted mb-1">Recommended Size: 150 x 150 px</small>
                                                            <a class="btn btn-apply" onclick="$('#certificate_logo').click()">Upload Logo</a>
                                                            <a class="btn btn-link" onclick="removeCertificateLogo()">Delete</a>
                                                            <input type="file" name="certificate_logo" id="certificate_logo"
                                                                accept="image/*" style="display: none;">
                                                            <input type="hidden" name="remove_certificate_logo" id="remove_certificate_logo" value="0">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="remove_img" id="remove_img" value="0">

                                            <div class="col-lg-6 d-none">
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


                                        </div>

                                        <div class="row form-contact">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Designation
                                                            </label>
                                                            <input class="form-control" type="text" id="designation"
                                                                name="designation" required
                                                                placeholder="Enter Designation"
                                                                value="{{ $userData ? $userData->designation : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Company Name
                                                                *</label>
                                                            <input class="form-control" type="text" id="company_nm"
                                                                name="company_nm" placeholder="Enter Company Name"
                                                                value="{{ $userData ? $userData->name : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Email *</label>
                                                            <input class="form-control" type="text" id="email"
                                                                name="email" placeholder="Enter Email"
                                                                value="{{ $userData ? $userData->email : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Contact
                                                                number</label>
                                                            <input class="form-control" type="text"
                                                                placeholder="Enter Contact number" id="contact_no"
                                                                name="contact_no"
                                                                value="{{ $userData ? $userData->contact_no : '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Company
                                                                Website</label>
                                                            <input class="form-control" type="url"
                                                                id="company_website" name="company_website"
                                                                placeholder="Enter Company Website"
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

                                                            <div class="selected_area mt-2" id="AreaSuggestBox"></div>

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
                                                </div>

                                                <div class="row">
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
                                            <img id="companyCropImage" style="max-width: 300px; border:1px solid #ddd">
                                            
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
                                <div class="tab-pane fade " id="tab-about" role="tabpanel" aria-labelledby="tab-about">
                                    <form id="company-about-form" onsubmit="return false;">
                                        <h3 class="mt-0 mb-15 color-brand-1">Company About us</h3>

                                        <div class="row form-contact">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">About us</label>
                                                            <textarea class="form-control" id="company_desc" name="company_desc" rows="14">{{ $user ? $user->company_desc : '' }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="font-sm color-text-mutted mb-10">Specialties</label>

                                                            <input type="text"
                                                                class="form-control"
                                                                id="specialties"
                                                                name="specialties"
                                                                placeholder="Eg: Web Development, Software, CRM"
                                                                value="{{ $user ? $user->specialties : '' }}">

                                                            <small class="text-muted">
                                                                Add specialties in comma separated format.
                                                            </small>    
                                                        </div>
                                                    </div>
                                                </div>
                                                

                                                <div class="row">
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
                                <div class="tab-pane fade show active" id="tab-my-jobs" role="tabpanel"
                                    aria-labelledby="tab-my-jobs">
                                    <div id="joblist">
                                        <div class="row mb-5">
                                            <div class="col-lg-9 col-md-6 col-5">
                                                <h3 class="mt-0 color-brand-1 mb-50">My Jobs</h3>
                                            </div>
                                            @if(!$hideCreateJobBtn)
                                            <div class="col-lg-3 col-md-6 col-7 text-right">
                                                <a class="btn btn-preview-icon btn-apply btn-apply-big"
                                                    style="padding: 14px 30px 14px 30px;" href="javascript:void(0);"
                                                    onclick="CreateNewJob()"><i class="fa fa-plus"></i>&nbsp; Create New
                                                    Job</a>
                                            </div>
                                            @else
                                            <div class="col-lg-3 col-md-6 col-7 text-right">
                                                <a class="btn btn-preview-icon btn-apply btn-apply-big"
                                                    style="padding: 14px 30px 14px 30px; opacity: 0.65;" href="javascript:void(0);"
                                                    onclick="showPlanLimitAlert('job')"><i class="fa fa-lock"></i>&nbsp; Upgrade Plan</a>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="row display-list">
                                            <!-- Filter Buttons -->
                                            <div class="d-flex gap-3 mb-3">
                                                <a href="?filter=all" class="btn btn-outline-primary {{ $filter == 'all' ? 'active' : '' }}">All</a>
                                                <a href="?filter=active" class="btn btn-outline-success {{ $filter == 'active' ? 'active' : '' }}">Active</a>
                                                <a href="?filter=closed" class="btn btn-outline-danger {{ $filter == 'closed' ? 'active' : '' }}">Closed</a>
                                                <!-- <a href="?filter=draft" class="btn btn-outline-secondary {{ $filter == 'draft' ? 'active' : '' }}">Draft</a> -->
                                            </div>

                                            @if (count($JobData) > 0)
                                                @foreach ($JobData as $row)
                                                    <!-- Your existing job cards -->
                                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 mt-4">
                                                        <div class="job-card-simple position-relative w-100" onclick="window.location.href='{{ route('job-detail', ['job_id' => $row->job_id]) }}'">

                                                            <!-- Edit Button -->
                                                            <a href="javascript:void(0);" onclick="event.stopPropagation(); EditJob({{ $row->job_id }})"
                                                                class="btn btn-primary btn-sm position-absolute p-2"
                                                                style="top:-18px; right:75px; border-radius:50%; width:34px; height:34px;">
                                                                <i class="fa fa-pencil text-white"></i>
                                                            </a>

                                                            <!-- Status Buttons -->
                                                            @if($row->status != 1)
                                                            <a class="btn btn-success btn-sm position-absolute p-2"
                                                                onclick="event.stopPropagation(); changeStatus({{ $row->job_id }},1)"
                                                                title="Mark Active"
                                                                style="top:-18px; right:40px; border-radius:50%; width:34px; height:34px;">
                                                                <i class="fa fa-check text-white"></i>
                                                            </a>
                                                            @endif

                                                            @if($row->status != 2)
                                                            <a class="btn btn-danger btn-sm position-absolute p-1"
                                                                onclick="event.stopPropagation(); changeStatus({{ $row->job_id }},2)"
                                                                title="Mark Closed"
                                                                style="top:-18px; right:6px; border-radius:50%; width:34px; height:34px;">
                                                                <i class="fa fa-times text-white"></i>
                                                            </a>
                                                            @endif

                                                            <!-- Job Badge -->
                                                            <div class="job-badge" style=" left: 15px; right: auto;">
                                                                {{ $row->work_type_name }}
                                                            </div>

                                                            <!-- Main Content -->
                                                            <div class="job-main">
                                                                <h3 class="job-title">{{ $row->job_title }}</h3>

                                                                <!-- Status Badge -->
                                                                @if($row->status == 1)
                                                                    <span class="badge bg-success rounded-pill mb-2">Active</span>
                                                                @elseif($row->status == 2)
                                                                    <span class="badge bg-danger rounded-pill mb-2">Closed</span>
                                                                @else
                                                                    <span class="badge bg-secondary rounded-pill mb-2">Draft</span>
                                                                @endif

                                                                <div class="location">
                                                                    <i class="fa fa-map-marker"></i>
                                                                    @if ($Setting->ShowCompanyDetails == 1 && $user && !is_null($user->active_plan_id) && $user->active_plan_id != 0)
                                                                        <span>{{ $row->company_address }}</span>
                                                                    @else
                                                                        <span>{{ $row->area_nm }}, {{ $row->city_nm }}, {{ $row->state_name }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Details -->
                                                            <div class="job-details">
                                                                <div class="detail">
                                                                    <i class="fa fa-users"></i>
                                                                    <span>{{ $row->apply_count }} Applied</span>
                                                                </div>
                                                                <div class="detail">
                                                                    <i class="fa fa-clock-o"></i>
                                                                    <span>{{ \Carbon\Carbon::parse($row->datetime)->diffForHumans() }}</span>
                                                                </div>
                                                            </div>

                                                            <!-- Footer Button -->
                                                            @if ($row->apply_count)
                                                            <button onclick="event.stopPropagation(); loadJobApplyDetails({{ $row->job_id }})"
                                                                class="view-btn w-100 mt-2">
                                                                View Apply History
                                                            </button>
                                                            @endif

                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="row col-lg-12 col-md-12 col-xl-12 col-12">
                                                    <h4 style="text-align: center;background: #eee;padding: 23px;">
                                                        @if($filter == 'all')
                                                            No Jobs Found
                                                        @elseif($filter == 'active')
                                                            No Active Jobs Found
                                                        @elseif($filter == 'closed')
                                                            No Closed Jobs Found
                                                        @elseif($filter == 'draft')
                                                            No Draft Jobs Found
                                                        @endif
                                                    </h4>
                                                </div>
                                            @endif
                                        </div>
                                        @if ($JobData->lastPage() > 1)
                                            <div class="paginations mt-30">
                                                <ul class="pager">
                                                    {{-- Previous Page Link --}}
                                                    <li>
                                                        <a class="pager-prev {{ $JobData->onFirstPage() ? 'disabled' : '' }}"
                                                            href="{{ $JobData->previousPageUrl() ?? '#' }}">
                                                        </a>
                                                    </li>

                                                    {{-- Page Numbers --}}
                                                    @for ($i = 1; $i <= $JobData->lastPage(); $i++)
                                                        <li>
                                                            <a class="pager-number {{ $JobData->currentPage() == $i ? 'active' : '' }}"
                                                                href="{{ $JobData->url($i) }}">{{ $i }}</a>
                                                        </li>
                                                    @endfor

                                                    {{-- Next Page Link --}}
                                                    <li>
                                                        <a class="pager-next {{ !$JobData->hasMorePages() ? 'disabled' : '' }}"
                                                            href="{{ $JobData->nextPageUrl() ?? '#' }}">
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>

                                    <div id="createjob">
                                        <div class="row">
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
                                            <div class="row form-contact">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-4">
                                                            <div class="job-type-select select-job" id="noneskill"
                                                                onclick="SelectJobType('Non-Skilled')">
                                                                <div class="row">
                                                                    <div class="col-lg-4 col-md-4 col-4">
                                                                        <img src="./assets/imgs/noneskill.png"
                                                                            alt="">
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
                                                                        <img src="./assets/imgs/skill.png" alt="">
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
                                                    </div>
                                                    <div class="row mt-10">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-10">Job Category
                                                                    *</label>
                                                               
                                                                <select name="job_category_id" class="form-control" id="job_category_id">
                                                                    <option value="">-- Select Job Category --</option>
                                                                    @foreach ($CategoryData as $row)
                                                                        <option value="{{ $row->category_id }}">{{ $row->category_nm }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-10">Sub Category
                                                                    *</label>
                                                                <select name="job_sub_category_id" class="form-control"
                                                                    id="job_sub_category_id">
                                                                    <option value="">-- Select Sub Category --
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="form-group" style="position: relative;">
                                                                <label class="font-sm color-text-mutted mb-10">Job
                                                                    Title</label>
                                                                <input class="form-control" id="job_title"
                                                                    name="job_title" type="text"
                                                                    placeholder="Enter Job Title">
                                                                <div id="jobTitleSuggestions" class="suggestions"></div>
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-6">
                                                            <div class="form-group" id="SkillMinimumQualification">
                                                                <label class="font-sm color-text-mutted mb-10">Minimum
                                                                    Qualification *</label>
                                                                <select name="job_minimum_qualification"
                                                                    class="form-control" id="job_minimum_qualification">
                                                                    <option value="">-- Select Minimum Qualification --</option>
                                                                    @foreach ($MinqualificationData as $row)
                                                                        <option value="{{ $row->qualification_id }}">
                                                                            {{ $row->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-10">Job Level
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
                                                                 <label class="font-sm color-text-mutted mb-10">Job Type
                                                                    *</label>
                                                                <select name="job_type" class="form-control"
                                                                    id="job_type">
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
                                                                <label class="font-sm color-text-mutted mb-10">Work Type
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
                                                                <label class="font-sm color-text-mutted mb-10">Number of
                                                                    Openings</label>
                                                                <input class="form-control" type="text"
                                                                    id="job_number_of_openings"
                                                                    name="job_number_of_openings"
                                                                    placeholder="How many candidates are needed">
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-10">Salary
                                                                    Budget</label>
                                                                <input class="form-control" type="text"
                                                                    id="job_salary_budget" name="job_salary_budget"
                                                                    placeholder="Enter Salary Budget">
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-10">Job Timing</label>
                                                                <input class="form-control" type="text" id="job_timing" name="job_timing" placeholder="Enter Job Timing">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-10">Candidate Gender</label>
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
                                                                <label class="font-sm color-text-mutted mb-10">Age</label>
                                                                <input class="form-control" type="text"
                                                                    id="job_age" name="job_age"
                                                                    placeholder="Enter Job Age">
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-10">Job
                                                                    Description
                                                                    & Responsibilities</label>
                                                                {{-- <textarea class="form-control" id="job_description" name="job_description" rows="4">Enter Here...</textarea> --}}
                                                                <div id="job_description_editor"
                                                                    style="height:200px; background:#fff;">
                                                                </div>
                                                                <input type="hidden" name="job_description" id="job_description">
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label
                                                                    class="font-sm color-text-mutted mb-10">Interviewer’s
                                                                    Address</label>
                                                                <input class="form-control" type="text"
                                                                    id="job_interviewer_address"
                                                                    name="job_interviewer_address"
                                                                    placeholder="Enter Interviewer Address">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-10">Experience
                                                                    Required *</label>
                                                                <select name="job_experience_required"
                                                                    class="form-control" id="job_experience_required">
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
                                                                <label class="font-sm color-text-mutted mb-10">Contact
                                                                    number</label>
                                                                <input class="form-control" id="job_contact_number"
                                                                    name="job_contact_number" type="text"
                                                                    placeholder="Enter Contact No.">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-10">Company
                                                                    Website</label>
                                                                <input class="form-control" type="text"
                                                                    id="job_company_website" name="job_company_website"
                                                                    placeholder="Enter Website URL">
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-10">Company
                                                                    Address</label>
                                                                <input class="form-control" type="text"
                                                                    id="job_company_address" name="job_company_address"
                                                                    placeholder="Enter Address">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="input-5">Pincode</label>
                                                                <input class="form-control" id="job_zipcode"
                                                                    type="text" required="" name="job_zipcode"
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
                                                                <label class="form-label" for="input-5">State</label>
                                                                <input class="form-control" id="job_state_id"
                                                                    type="text" required="" name="job_state_id"
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
                                                                <label class="form-label" for="city_id">City</label>
                                                                <input class="form-control" id="job_city_id"
                                                                    type="text" required="" name="job_city_id"
                                                                    placeholder="Enter City" autocomplete="off"
                                                                    autocorrect="off" autocapitalize="off"
                                                                    value="{{ $userData ? $userData->city_nm : '' }}">

                                                                <div id="job_Citysuggestions" class="suggestions"></div>
                                                                <input type="hidden" name="job_city_id_hidden"
                                                                    id="job_city_id_hidden"
                                                                    value="{{ $userData ? $userData->city_id : '' }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="job_area_id">Area / Village</label>
                                                                <input class="form-control" id="job_area_id"
                                                                    type="text" required="" name="job_area_id"
                                                                    placeholder="Enter Area" autocomplete="off"
                                                                    autocorrect="off" autocapitalize="off"
                                                                    value="{{ $userData ? $userData->area_nm : '' }}">

                                                                <div class="job_selected_area mt-2"
                                                                    id="JobAreaSuggestBox">
                                                                </div>

                                                                <div id="job_Areasuggestions" class="suggestions"></div>
                                                                <input type="hidden" name="job_area_id_hidden"
                                                                    id="job_area_id_hidden"
                                                                    value="{{ $userData ? $userData->area_id : '' }}">
                                                            </div>
                                                        </div>





                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-10">HR
                                                                    Email</label>
                                                                <input class="form-control" type="text"
                                                                    id="job_hr_email" name="job_hr_email"
                                                                    placeholder="Enter HR Email">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="font-sm color-text-mutted mb-10">HR Contact
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
                                                                <h5 class="mt-0 color-brand-1">Skills</h5>
                                                                <div class="form-contact">
                                                                    <div class="form-group">
                                                                        <input class="form-control search-icon"
                                                                            id="skill_id" name="skill_id" type="text"
                                                                            value=""
                                                                            placeholder="E.g. Angular, Laravel..."
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
                                                    <div class="border-bottom pt-10 pb-10"></div>

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
                                                                                            value="ROUND1"
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
                                                                                            value="Walk in interview"
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
                                                                <input type="hidden" id="flag" name="flag"
                                                                    value="A">
                                                                <input type="hidden" id="row_id" name="row_id">
                                                                <button class="btn btn-apply-big font-md font-bold"
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

                                <div class="tab-pane fade " id="tab-job-apply-history" role="tabpanel"
                                    aria-labelledby="tab-job-apply-history">


                                </div>
                                <div class="tab-pane fade " id="tab-change-password" role="tabpanel"
                                    aria-labelledby="tab-change-password">
                                    <form id="change-password-form" onsubmit="return false;">
                                        <h3 class="mt-0 color-brand-1 mb-50">Change your password</h3>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group position-relative">
                                                    <label class="font-sm color-text-mutted mb-10">Old Password</label>
                                                    <div class="input-group">
                                                        <input class="form-control" type="password" id="old_password" name="old_password" placeholder="Enter Old Password">
                                                        <button type="button" class="btn btn-brand-1 hover-up" id="oldtogglePassword">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group position-relative">
                                                    <label class="font-sm color-text-mutted mb-10">Password</label>
                                                    <div class="input-group">
                                                        <input class="form-control" type="password" id="new_password" name="new_password" placeholder="Enter New Password">
                                                        <button type="button" class="btn btn-brand-1 hover-up" id="passtogglePassword">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group position-relative">
                                                    <label class="font-sm color-text-mutted mb-10">Re-Password *</label>
                                                    <div class="input-group">
                                                        <input class="form-control" type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm New Password">
                                                        <button type="button" class="btn btn-brand-1 hover-up" id="newtogglePassword">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="box-button mt-15">
                                                    <input type="hidden" id="_method" name="_method" value="POST">
                                                    <input type="hidden" id="row_id" name="row_id"
                                                        value="{{ $user ? $user->id : '' }}">

                                                    <button class="btn btn-apply-big font-md font-bold"
                                                        type="submit">Save
                                                        Change</button>
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
                                                        <th scope="col">Job Limit</th>
                                                        <th scope="col">Opportunity Limit</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($PlanHistoryData as $row)
                                                        <tr>
                                                            <th>{{ $loop->iteration }}</th>
                                                            <td>{{ $row->plan_name }}</td>
                                                            <td>₹ {{ $row->plan_price . '/' . $row->duration }}</td>
                                                            <td>{{ $row->purchase_date }}</td>
                                                            <td>{{ $row->expire_date }}</td>
                                                            <td>
                                                                @if($row->display_job_limit !== null)
                                                                    @if($row->display_status === 'Active' && $row->display_job_used !== null)
                                                                        {{ (int) $row->display_job_used }} / {{ (int) $row->display_job_limit }}
                                                                    @else
                                                                        {{ (int) $row->display_job_limit }}
                                                                    @endif
                                                                @else
                                                                    Unlimited
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($row->display_opportunity_limit !== null)
                                                                    @if($row->display_status === 'Active' && $row->display_opportunity_used !== null)
                                                                        {{ (int) $row->display_opportunity_used }} / {{ (int) $row->display_opportunity_limit }}
                                                                    @else
                                                                        {{ (int) $row->display_opportunity_limit }}
                                                                    @endif
                                                                @else
                                                                    Unlimited
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($row->display_status === 'Active')
                                                                    <span class="badge bg-success">Active</span>
                                                                @else
                                                                    <span class="badge bg-danger">Expired</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0)"
                                                                    class="btn btn-apply btn-apply-big p-2 view-plan"
                                                                    data-plan-name="{{ $row->plan_name }}"
                                                                    data-plan-price="{{ $row->plan_price }}"
                                                                    data-payment-id="{{ $row->payment_id ?? 'N/A' }}"
                                                                    data-order-id="{{ $row->order_id ?? 'N/A' }}"
                                                                    data-status="{{ $row->display_status }}"
                                                                    data-purchase-date="{{ \Carbon\Carbon::parse($row->purchase_date)->format('d M Y') }}"
                                                                    data-expire-date="{{ \Carbon\Carbon::parse($row->expire_date)->format('d M Y') }}"
                                                                    data-duration="{{ $row->duration }}"
                                                                    data-job-limit="{{ $row->display_job_limit !== null ? (($row->display_status === 'Active' && $row->display_job_used !== null) ? ((int)$row->display_job_used . ' / ' . (int)$row->display_job_limit) : (int)$row->display_job_limit) : 'Unlimited' }}"
                                                                    data-opportunity-limit="{{ $row->display_opportunity_limit !== null ? (($row->display_status === 'Active' && $row->display_opportunity_used !== null) ? ((int)$row->display_opportunity_used . ' / ' . (int)$row->display_opportunity_limit) : (int)$row->display_opportunity_limit) : 'Unlimited' }}">
                                                                    <i class="fa fa-list-alt"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center text-muted py-4">No membership history found.</td>
                                                        </tr>
                                                    @endforelse
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
        </section>
    </main>


    <div class="modal fade" id="planDetailModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Plan Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered mb-0">
                <tr>
                    <th>Plan Name</th>
                    <td id="m_plan_name"></td>
                </tr>
                <tr>
                    <th>Plan Price</th>
                    <td id="m_plan_price"></td>
                </tr>
                <tr>
                    <th>Payment ID</th>
                    <td id="m_payment_id"></td>
                </tr>
                <tr>
                    <th>Order ID</th>
                    <td id="m_order_id"></td>
                </tr>
                <tr>
                    <th>Duration</th>
                    <td id="m_duration"></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td id="m_status"></td>
                </tr>
                <tr>
                    <th>Purchase Date</th>
                    <td id="m_purchase_date"></td>
                </tr>
                <tr>
                    <th>Expire Date</th>
                    <td id="m_expire_date"></td>
                </tr>
                <tr>
                    <th>Job Limit</th>
                    <td id="m_job_limit"></td>
                </tr>
                <tr>
                    <th>Opportunity Limit</th>
                    <td id="m_opportunity_limit"></td>
                </tr>
                </table>
            </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="RejectApplicationApply" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content apply-job-form">
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body pl-30 pr-30 pt-50">
                    <div class="text-center">
                        <p class="font-sm text-brand-2">Job Application </p>
                        <h2 class="mt-10 mb-10 text-brand-1 text-capitalize">Reject Application</h2>
                    </div>
                    <form id="apply-status-form" onsubmit="return false;">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <input type="hidden" name="status" id="status" value="2">
                            </div>
                            <div class="col-lg-12 col-md-12 col-12 mb-3">
                                <label for="">Message</label>
                                <Textarea id="message" name="message" class="form-control" style="height: 130px!important" required></Textarea>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12" style="text-align: center;">
                                <input type="hidden" id="apply_id" name="apply_id">
                                <input type="hidden" id="_method" name="_method" value="POST">
                                <button class="btn btn-default hover-up w-100" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

@push('script')
<script>
    
     // Quill editor variables (declare globally)
        var quill, quillOpportunityDesc, quillModuleDesc, quillObjective, quillOutcome;
        
        // Initialize Quill editors when document is ready
        $(document).ready(function() {
            // Job description editor (if needed)
            if ($('#job_description_editor').length) {
                quill = new Quill('#job_description_editor', {
                    theme: 'snow',
                    placeholder: 'Enter job description here...'
                });
            }
            
            // Initialize Quill editors for Opportunity form
            if ($('#full-editor-internship-description').length) {
                quillOpportunityDesc = new Quill('#full-editor-internship-description', {
                    theme: 'snow',
                    placeholder: 'Enter Internship description here...',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'link'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['clean']
                        ]
                    }
                });
            }

            if ($('#editor-module-desc').length) {
                quillModuleDesc = new Quill('#editor-module-desc', {
                    theme: 'snow',
                    placeholder: 'Enter module description here...',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'link'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['clean']
                        ]
                    }
                });
            }

            if ($('#full-editor-key-responsibilities').length) {
                quillObjective = new Quill('#full-editor-key-responsibilities', {
                    theme: 'snow',
                    placeholder: 'Enter Internship objective here...',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'link'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['clean']
                        ]
                    }
                });
            }

            if ($('#editor-industry-outcome').length) {
                quillOutcome = new Quill('#editor-industry-outcome', {
                    theme: 'snow',
                    placeholder: 'Enter Internship outcome here...',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'link'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['clean']
                        ]
                    }
                });
            }
        });
        
        
        $(document).ready(function() {

            // Initialize global batch timing object
            if (typeof window.batchTimingObj === 'undefined') {
                window.batchTimingObj = {};
            }

            const companyWeekDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

            function syncAllWeekCheckbox() {
                const selected = $('#batch_time').val() || [];
                const allSelected = companyWeekDays.every(function(day) {
                    return selected.indexOf(day) !== -1;
                });
                $('#all_week_days').prop('checked', allSelected && selected.length === companyWeekDays.length);
            }

            function getFirstDaySection() {
                const selected = $('#batch_time').val() || [];
                if (!selected.length) return null;
                return $(`.day-section[data-day="${selected[0]}"]`);
            }

            function buildDaySectionHtml(day, startVal, endVal, fullWidth) {
                const colClass = fullWidth ? 'col-12 mb-3 day-section' : 'col-lg-6 col-md-6 mb-3 day-section';
                return `
                <div class="${colClass}" data-day="${day}">
                       <div class="fw-bold text-capitalize mb-1">${day}</div>
                    <div class="card p-3" style="border:1px solid #ccc;border-radius:8px;">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <label class="small">Start Time</label>
                                <input type="time" class="form-control start-time" value="${startVal}">
                            </div>
                            <div class="col-md-6">
                                <label class="small">End Time</label>
                                <input type="time" class="form-control end-time" value="${endVal}">
                            </div>
                        </div>
                    </div>
                </div>
            `;
            }

            function renderCompanyDaySections(selectedDays) {
                const $firstWrap = $('#timeSectionFirst');
                const $restWrap = $('#timeSections');
                const existingValues = {};

                $('.day-section').each(function() {
                    const day = $(this).data('day');
                    existingValues[day] = {
                        start: $(this).find('.start-time').val() || '',
                        end: $(this).find('.end-time').val() || ''
                    };
                });

                $firstWrap.empty();
                $restWrap.empty();

                selectedDays.forEach(function(day, index) {
                    const startVal = existingValues[day]?.start ?? window.batchTimingObj?.[day]?.start ?? '';
                    const endVal = existingValues[day]?.end ?? window.batchTimingObj?.[day]?.end ?? '';
                    if (!window.batchTimingObj[day]) window.batchTimingObj[day] = {};
                    window.batchTimingObj[day].start = startVal;
                    window.batchTimingObj[day].end = endVal;

                    const html = buildDaySectionHtml(day, startVal, endVal, index === 0);
                    if (index === 0) {
                        $firstWrap.append(html);
                    } else {
                        $restWrap.append(html);
                    }
                });
            }

            function copyCompanyBatchTimesToAll() {
                const $first = getFirstDaySection();
                if (!$first || !$first.length) return;
                const startVal = $first.find('.start-time').val() || '';
                const endVal = $first.find('.end-time').val() || '';
                $('.day-section').each(function() {
                    const day = $(this).data('day');
                    const selected = $('#batch_time').val() || [];
                    if (selected.length && day === selected[0]) return;
                    $(this).find('.start-time').val(startVal);
                    $(this).find('.end-time').val(endVal);
                    if (!window.batchTimingObj[day]) window.batchTimingObj[day] = {};
                    window.batchTimingObj[day].start = startVal;
                    window.batchTimingObj[day].end = endVal;
                });
            }

            function clearCompanyBatchTimesExceptFirst() {
                const selected = $('#batch_time').val() || [];
                const firstDay = selected.length ? selected[0] : null;
                $('.day-section').each(function() {
                    const day = $(this).data('day');
                    if (firstDay && day === firstDay) return;
                    $(this).find('.start-time').val('');
                    $(this).find('.end-time').val('');
                    if (!window.batchTimingObj[day]) window.batchTimingObj[day] = {};
                    window.batchTimingObj[day].start = '';
                    window.batchTimingObj[day].end = '';
                });
            }

            function updateCopyTimesVisibility() {
                const selected = $('#batch_time').val() || [];
                const $first = getFirstDaySection();
                const startVal = $first && $first.length ? ($first.find('.start-time').val() || '') : '';
                const endVal = $first && $first.length ? ($first.find('.end-time').val() || '') : '';
                const hasFirstDayTime = !!(startVal && endVal);
                const $wrap = $('#copy_batch_times_wrap');

                // Keep checkbox in its own full-width slot between first and other days
                $wrap.insertAfter($('#timeSectionFirst'));

                if (selected.length > 1 && hasFirstDayTime) {
                    $wrap.show();
                } else {
                    $('#copy_batch_times').prop('checked', false);
                    $wrap.hide();
                }
            }

            $('#all_week_days').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#batch_time').val(companyWeekDays).trigger('change');
                } else {
                    $('#batch_time').val(null).trigger('change');
                }
            });

            $('#copy_batch_times').on('change', function() {
                if ($(this).is(':checked')) {
                    copyCompanyBatchTimesToAll();
                } else {
                    clearCompanyBatchTimesExceptFirst();
                }
            });

            $(document).on('change input', '#timeSectionFirst .start-time, #timeSectionFirst .end-time, #timeSections .start-time, #timeSections .end-time', function() {
                const $section = $(this).closest('.day-section');
                const day = $section.data('day');
                if (!window.batchTimingObj[day]) window.batchTimingObj[day] = {};
                window.batchTimingObj[day].start = $section.find('.start-time').val() || '';
                window.batchTimingObj[day].end = $section.find('.end-time').val() || '';

                updateCopyTimesVisibility();

                const selected = $('#batch_time').val() || [];
                if ($('#copy_batch_times').is(':checked') && selected.length && day === selected[0]) {
                    copyCompanyBatchTimesToAll();
                }
            });

            $('#batch_time').on('change', function() {
                const selectedDays = $(this).val() || [];
                renderCompanyDaySections(selectedDays);
                syncAllWeekCheckbox();
                updateCopyTimesVisibility();
                if ($('#copy_batch_times').is(':checked')) {
                    copyCompanyBatchTimesToAll();
                }
            });

        });
        
        // ==================== INTERNSHIP FORM SUBMISSION ====================
        
        // Global error handler
        window.addEventListener('error', function(e) {
            console.error('❌ JavaScript Error:', e.message, 'at', e.filename, ':', e.lineno);
        });
        
        $(document).ready(function() {
            console.log('✓ Document ready - Internship form handler setup');
            console.log('jQuery version:', $.fn.jquery);
            console.log('Button exists:', $('#saveInternshipBtn').length);
            console.log('Form exists:', $('#internship-form').length);
            
            // ==================== CLEAR VALIDATION ON INPUT ====================
            // Clear validation errors when user starts typing
            $('#internship-form input, #internship-form select, #internship-form textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.select2-container').removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
                $(this).siblings('.invalid-feedback').remove();
                const $parent = $(this).closest('.mb-4, .mb-3, .form-group, .col-lg-12, .col-lg-6, .col-lg-4');
                $parent.find('> .invalid-feedback').remove();
            });

            // Duration / Weeks / Hours — Other toggle (same pattern as Category)
            function syncDurationWeeksHoursValue(field) {
                if (field === 'duration') {
                    if ($('#use_other_duration').val() === '1') {
                        $('#duration').val(($('#duration_other').val() || '').trim());
                    } else {
                        $('#duration').val($('#duration_select').val() || '');
                    }
                } else if (field === 'weeks') {
                    if ($('#use_other_weeks').val() === '1') {
                        $('#weeks').val(($('#weeks_other').val() || '').trim());
                    } else {
                        $('#weeks').val($('#weeks_select').val() || '');
                    }
                } else if (field === 'hours') {
                    if ($('#use_other_hours').val() === '1') {
                        $('#hours').val(($('#hours_other').val() || '').trim());
                    } else {
                        $('#hours').val($('#hours_select').val() || '');
                    }
                }
            }

            window.setDurationOtherMode = function(enabled) {
                $('#use_other_duration').val(enabled ? '1' : '0');
                $('#duration-other-row').toggleClass('is-other-mode', enabled);
                $('#other-duration-wrap').toggle(enabled);
                $('#toggle-other-duration').text(enabled ? 'Select from list' : 'Other');
                if (enabled) {
                    $('#duration_select').val(null).trigger('change');
                } else {
                    $('#duration_other').val('');
                }
                syncDurationWeeksHoursValue('duration');
            };

            window.setWeeksOtherMode = function(enabled) {
                $('#use_other_weeks').val(enabled ? '1' : '0');
                $('#weeks-other-row').toggleClass('is-other-mode', enabled);
                $('#other-weeks-wrap').toggle(enabled);
                $('#toggle-other-weeks').text(enabled ? 'Select from list' : 'Other');
                if (enabled) {
                    $('#weeks_select').val(null).trigger('change');
                } else {
                    $('#weeks_other').val('');
                }
                syncDurationWeeksHoursValue('weeks');
            };

            window.setHoursOtherMode = function(enabled) {
                $('#use_other_hours').val(enabled ? '1' : '0');
                $('#hours-other-row').toggleClass('is-other-mode', enabled);
                $('#other-hours-wrap').toggle(enabled);
                $('#toggle-other-hours').text(enabled ? 'Select from list' : 'Other');
                if (enabled) {
                    $('#hours_select').val(null).trigger('change');
                } else {
                    $('#hours_other').val('');
                }
                syncDurationWeeksHoursValue('hours');
            };

            $('#toggle-other-duration').off('click').on('click', function() {
                setDurationOtherMode($('#use_other_duration').val() !== '1');
                if ($('#use_other_duration').val() === '1') {
                    $('#duration_other').focus();
                }
            });
            $('#toggle-other-weeks').off('click').on('click', function() {
                setWeeksOtherMode($('#use_other_weeks').val() !== '1');
                if ($('#use_other_weeks').val() === '1') {
                    $('#weeks_other').focus();
                }
            });
            $('#toggle-other-hours').off('click').on('click', function() {
                setHoursOtherMode($('#use_other_hours').val() !== '1');
                if ($('#use_other_hours').val() === '1') {
                    $('#hours_other').focus();
                }
            });

            $('#duration_select').on('change', function() { syncDurationWeeksHoursValue('duration'); });
            $('#weeks_select').on('change', function() { syncDurationWeeksHoursValue('weeks'); });
            $('#hours_select').on('change', function() { syncDurationWeeksHoursValue('hours'); });
            $('#duration_other, #weeks_other, #hours_other').on('input change', function() {
                const id = this.id;
                if (id === 'duration_other') syncDurationWeeksHoursValue('duration');
                if (id === 'weeks_other') syncDurationWeeksHoursValue('weeks');
                if (id === 'hours_other') syncDurationWeeksHoursValue('hours');
            });

            window.setInternshipDurationValue = function(value) {
                const options = ['1 Month', '2 Months', '3 Months', '4 Months', '5 Months', '6 Months'];
                let matched = '';
                const raw = (value || '').toString().trim();
                for (let i = 0; i < options.length; i++) {
                    if (options[i].toLowerCase() === raw.toLowerCase()) {
                        matched = options[i];
                        break;
                    }
                }
                if (!matched && raw) {
                    const m = raw.match(/^(\d+)\s*months?$/i);
                    if (m) {
                        const n = parseInt(m[1], 10);
                        if (n >= 1 && n <= 6) {
                            matched = n === 1 ? '1 Month' : (n + ' Months');
                        }
                    }
                }
                if (matched) {
                    setDurationOtherMode(false);
                    $('#duration_select').val(matched).trigger('change');
                    $('#duration').val(matched);
                } else if (raw) {
                    setDurationOtherMode(true);
                    $('#duration_other').val(raw);
                    $('#duration').val(raw);
                } else {
                    setDurationOtherMode(false);
                    $('#duration_select').val(null).trigger('change');
                    $('#duration').val('');
                }
            };

            window.setInternshipWeeksValue = function(value) {
                const presets = ['4', '8', '12', '16', '20', '24'];
                const strVal = value !== null && value !== undefined ? String(value) : '';
                if (presets.indexOf(strVal) !== -1) {
                    setWeeksOtherMode(false);
                    $('#weeks_select').val(strVal).trigger('change');
                    $('#weeks').val(strVal);
                } else if (strVal !== '') {
                    setWeeksOtherMode(true);
                    $('#weeks_other').val(strVal);
                    $('#weeks').val(strVal);
                } else {
                    setWeeksOtherMode(false);
                    $('#weeks_select').val(null).trigger('change');
                    $('#weeks').val('');
                }
            };

            window.setInternshipHoursValue = function(value) {
                const presets = ['60', '120', '240', '320', '360'];
                const strVal = value !== null && value !== undefined ? String(value) : '';
                if (presets.indexOf(strVal) !== -1) {
                    setHoursOtherMode(false);
                    $('#hours_select').val(strVal).trigger('change');
                    $('#hours').val(strVal);
                } else if (strVal !== '') {
                    setHoursOtherMode(true);
                    $('#hours_other').val(strVal);
                    $('#hours').val(strVal);
                } else {
                    setHoursOtherMode(false);
                    $('#hours_select').val(null).trigger('change');
                    $('#hours').val('');
                }
            };
            
            // Clear Quill editor validation on text change (attach later when editors are ready)
            setTimeout(function() {
                if (typeof quillOpportunityDesc !== 'undefined' && quillOpportunityDesc) {
                    quillOpportunityDesc.on('text-change', function() {
                        $('#full-editor-internship-description').removeClass('border-danger is-invalid');
                        $('#full-editor-internship-description').siblings('.invalid-feedback').remove();
                    });
                }
                if (typeof quillModuleDesc !== 'undefined' && quillModuleDesc) {
                    quillModuleDesc.on('text-change', function() {
                        $('#editor-module-desc').removeClass('border-danger is-invalid');
                        $('#editor-module-desc').siblings('.invalid-feedback').remove();
                    });
                }
                if (typeof quillObjective !== 'undefined' && quillObjective) {
                    quillObjective.on('text-change', function() {
                        $('#full-editor-key-responsibilities').removeClass('border-danger is-invalid');
                        $('#full-editor-key-responsibilities').siblings('.invalid-feedback').remove();
                    });
                }
                if (typeof quillOutcome !== 'undefined' && quillOutcome) {
                    quillOutcome.on('text-change', function() {
                        $('#editor-industry-outcome').removeClass('border-danger is-invalid');
                        $('#editor-industry-outcome').siblings('.invalid-feedback').remove();
                    });
                }
            }, 1000);

            function clearInternshipValidation() {
                $('#internship-form .is-invalid').removeClass('is-invalid');
                $('#internship-form .border-danger').removeClass('border-danger');
                $('#internship-form .invalid-feedback').remove();
                $('#internship-form .select2-container').removeClass('is-invalid');
            }

            function showInternshipFieldError($el, message) {
                if (!$el || !$el.length) return;
                $el.addClass('is-invalid');
                if ($el.hasClass('select2-hidden-accessible')) {
                    $el.next('.select2-container').addClass('is-invalid');
                }
                const $feedback = $('<div class="invalid-feedback d-block"></div>').text(message);
                if ($el.next('.select2-container').length) {
                    $el.next('.select2-container').after($feedback);
                } else if ($el.is('div') || $el.hasClass('ql-container') || $el.attr('id') && $el.attr('id').indexOf('editor') !== -1) {
                    $el.after($feedback);
                    $el.addClass('border-danger');
                } else {
                    $el.after($feedback);
                }
            }

            function isQuillEmpty(quill) {
                if (!quill) return true;
                const text = (quill.getText() || '').trim();
                const html = (quill.root.innerHTML || '').replace(/<p><br><\/p>/gi, '').trim();
                return text.length === 0 || html === '';
            }

            function getLocalTodayStr() {
                const now = new Date();
                const pad = (n) => String(n).padStart(2, '0');
                return now.getFullYear() + '-' + pad(now.getMonth() + 1) + '-' + pad(now.getDate());
            }

            function validateInternshipForm() {
                clearInternshipValidation();
                let isValid = true;
                let firstErrorEl = null;

                function markError($el, message) {
                    showInternshipFieldError($el, message);
                    if (!firstErrorEl && $el && $el.length) {
                        firstErrorEl = $el;
                    }
                    isValid = false;
                }

                const requiredTextFields = [
                    { id: '#internship_title', msg: 'Please enter Internship title' },
                    { id: '#location', msg: 'Please enter location' },
                    { id: '#openings', msg: 'Please enter number of openings' },
                    { id: '#start_date', msg: 'Please select start date' },
                    { id: '#end_date', msg: 'Please select end date' },
                    { id: '#application_deadline', msg: 'Please select application deadline' }
                ];

                requiredTextFields.forEach(function(field) {
                    const $el = $(field.id);
                    const val = ($el.val() || '').toString().trim();
                    if (!val) {
                        markError($el, field.msg);
                    }
                });

                syncDurationWeeksHoursValue('duration');
                syncDurationWeeksHoursValue('weeks');
                syncDurationWeeksHoursValue('hours');

                if (!$('#duration').val()) {
                    markError(
                        $('#use_other_duration').val() === '1' ? $('#duration_other') : $('#duration_select'),
                        $('#use_other_duration').val() === '1' ? 'Please enter duration' : 'Please select duration'
                    );
                }
                if (!$('#weeks').val()) {
                    markError(
                        $('#use_other_weeks').val() === '1' ? $('#weeks_other') : $('#weeks_select'),
                        $('#use_other_weeks').val() === '1' ? 'Please enter total weeks' : 'Please select total weeks'
                    );
                }
                if (!$('#hours').val()) {
                    markError(
                        $('#use_other_hours').val() === '1' ? $('#hours_other') : $('#hours_select'),
                        $('#use_other_hours').val() === '1' ? 'Please enter total hours' : 'Please select total hours'
                    );
                }

                if (!$('#use_other_category').val() || $('#use_other_category').val() === '0') {
                    if (!$('#category_id').val()) {
                        markError($('#category_id'), 'Please select a category');
                    }
                } else {
                    const otherCategoryName = ($('#other_category_name').val() || '').trim();
                    if (!otherCategoryName) {
                        markError($('#other_category_name'), 'Please enter custom category name');
                    }
                }

                const useOtherSub = $('#use_other_subcategory').val() === '1';
                if (!useOtherSub) {
                    const subCategoryVals = $('#internship_sub_category_id').val() || [];
                    if (!subCategoryVals.length) {
                        markError($('#internship_sub_category_id'), 'Please select at least one subcategory');
                    }
                } else {
                    const otherSubName = ($('#other_subcategory_name').val() || '').trim();
                    if (!otherSubName) {
                        markError($('#other_subcategory_name'), 'Please enter custom subcategory name');
                    }
                    if (!$('#use_other_category').val() || $('#use_other_category').val() === '0') {
                        if (!$('#category_id').val()) {
                            markError($('#category_id'), 'Please select a category for the subcategory request');
                        }
                    }
                }
                if (!$('#internship_mode').val()) {
                    markError($('#internship_mode'), 'Please select mode');
                }

                const weeks = parseInt($('#weeks').val(), 10);
                if ($('#weeks').val() && (isNaN(weeks) || weeks < 1)) {
                    markError($('#weeks'), 'Total weeks must be at least 1');
                }
                const hours = parseInt($('#hours').val(), 10);
                if ($('#hours').val() && (isNaN(hours) || hours < 1)) {
                    markError($('#hours'), 'Total hours must be at least 1');
                }
                const openings = parseInt($('#openings').val(), 10);
                if ($('#openings').val() && (isNaN(openings) || openings < 1)) {
                    markError($('#openings'), 'Openings must be at least 1');
                }

                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();
                const appDeadline = $('#application_deadline').val();
                const lastRegDate = $('#last_registration_date').val();
                const today = getLocalTodayStr();

                if (startDate && endDate && endDate <= startDate) {
                    markError($('#end_date'), 'End date must be after start date');
                }

                if (appDeadline) {
                    if (appDeadline < today) {
                        markError($('#application_deadline'), 'Application deadline cannot be before today');
                    }
                    if (startDate && appDeadline > startDate) {
                        markError($('#application_deadline'), 'Application deadline must be on or before start date');
                    }
                }

                if (lastRegDate) {
                    if (appDeadline && lastRegDate < appDeadline) {
                        markError($('#last_registration_date'), 'Last registration date must be on or after application deadline');
                    }
                    if (startDate && lastRegDate > startDate) {
                        markError($('#last_registration_date'), 'Last registration date must be on or before start date');
                    }
                }

                const selectedDays = $('#batch_time').val() || [];
                if (!selectedDays.length) {
                    markError($('#batch_time'), 'Please select at least one batch day');
                } else {
                    selectedDays.forEach(function(day) {
                        const daySection = $(`.day-section[data-day="${day}"]`);
                        if (!daySection.length) return;
                        const $startTime = daySection.find('.start-time');
                        const $endTime = daySection.find('.end-time');
                        if (!$startTime.val()) {
                            markError($startTime, 'Please select start time for ' + day);
                        }
                        if (!$endTime.val()) {
                            markError($endTime, 'Please select end time for ' + day);
                        }
                        if ($startTime.val() && $endTime.val() && $endTime.val() <= $startTime.val()) {
                            markError($endTime, 'End time must be after start time for ' + day);
                        }
                    });
                }

                if (typeof quillOpportunityDesc === 'undefined' || isQuillEmpty(quillOpportunityDesc)) {
                    markError($('#full-editor-internship-description'), 'Please enter program overview');
                }
                if (typeof quillObjective === 'undefined' || isQuillEmpty(quillObjective)) {
                    markError($('#full-editor-key-responsibilities'), 'Please enter learning objectives');
                }
                if (typeof quillModuleDesc === 'undefined' || isQuillEmpty(quillModuleDesc)) {
                    markError($('#editor-module-desc'), 'Please enter module brief description');
                }
                if (typeof quillOutcome === 'undefined' || isQuillEmpty(quillOutcome)) {
                    markError($('#editor-industry-outcome'), 'Please enter skills you\'ll gain');
                }

                if (!isValid && firstErrorEl) {
                    $('html, body').animate({
                        scrollTop: firstErrorEl.offset().top - 120
                    }, 400);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation Error',
                        text: 'Please fill all required fields correctly.'
                    });
                }

                return isValid;
            }
            
            // Prevent form from submitting normally
            $(document).off('submit.internshipForm', '#internship-form').on('submit.internshipForm', '#internship-form', function(e) {
                console.log('⚠️ Form submit event triggered - preventing default');
                e.preventDefault();
                e.stopPropagation();
                return false;
            });

            window.internshipPublishing = false;

            function setInternshipPublishLoading(isLoading) {
                const $btn = $('#saveInternshipBtn');
                const isEdit = $('#internship-form').data('is-edit');
                if (isLoading) {
                    $btn.prop('disabled', true).addClass('disabled');
                    $btn.find('#btnText').text(isEdit ? 'Updating...' : 'Publishing...');
                    $btn.find('i').removeClass('fa-save fa-edit').addClass('fa-spinner fa-spin');
                    if (typeof LoaderShow === 'function') {
                        LoaderShow();
                    }
                } else {
                    $btn.prop('disabled', false).removeClass('disabled');
                    $btn.find('#btnText').text(isEdit ? 'Update Internship' : 'Publish Internship');
                    $btn.find('i').removeClass('fa-spinner fa-spin').addClass(isEdit ? 'fa-edit' : 'fa-save');
                    if (typeof LoaderHide === 'function') {
                        LoaderHide();
                    }
                }
            }
            
            // Button click handler - use event delegation
            $(document).off('click.saveInternship', '#saveInternshipBtn').on('click.saveInternship', '#saveInternshipBtn', function(e) {
                console.log('🔥 BUTTON CLICKED!');
                e.preventDefault();
                e.stopPropagation();

                if (window.internshipPublishing) {
                    return false;
                }

                if (!validateInternshipForm()) {
                    return false;
                }

                syncDurationWeeksHoursValue('duration');
                syncDurationWeeksHoursValue('weeks');
                syncDurationWeeksHoursValue('hours');

                window.internshipPublishing = true;
                setInternshipPublishLoading(true);

                // Re-enable disabled fields so values are included in FormData
                $('#category_id, #internship_sub_category_id').prop('disabled', false);

                // Get form data
                const form = document.getElementById('internship-form');
                if (!form) {
                    console.error('Internship form #internship-form not found');
                    window.internshipPublishing = false;
                    setInternshipPublishLoading(false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Internship form not found. Please refresh the page.'
                    });
                    return false;
                }
                let formData = new FormData(form);

                const useOtherCategory = $('#use_other_category').val() === '1';
                const useOtherSubcategory = $('#use_other_subcategory').val() === '1';
                formData.set('use_other_category', useOtherCategory ? '1' : '0');
                formData.set('use_other_subcategory', useOtherSubcategory ? '1' : '0');
                formData.set('other_category_name', useOtherCategory ? ($('#other_category_name').val() || '').trim() : '');
                formData.set('other_subcategory_name', useOtherSubcategory ? ($('#other_subcategory_name').val() || '').trim() : '');
                if (useOtherCategory) {
                    formData.set('category_id', '');
                }
                if (useOtherSubcategory) {
                    formData.delete('sub_category_id[]');
                }
                
                // Get Quill content if available
                if (typeof quillOpportunityDesc !== 'undefined' && quillOpportunityDesc) {
                    formData.set('internship_description', quillOpportunityDesc.root.innerHTML);
                }
                if (typeof quillModuleDesc !== 'undefined' && quillModuleDesc) {
                    formData.set('module_description', quillModuleDesc.root.innerHTML);
                }
                if (typeof quillObjective !== 'undefined' && quillObjective) {
                    formData.set('internship_objective', quillObjective.root.innerHTML);
                }
                if (typeof quillOutcome !== 'undefined' && quillOutcome) {
                    formData.set('internship_outcome', quillOutcome.root.innerHTML);
                }
                
                // Batch days with timings - collect from select2 dropdown and time inputs
                let batchDaysWithTime = {};
                const selectedDays = $('#batch_time').val() || [];
                
                selectedDays.forEach(day => {
                    const daySection = $(`.day-section[data-day="${day}"]`);
                    if (daySection.length) {
                        const startTime = daySection.find('.start-time').val();
                        const endTime = daySection.find('.end-time').val();
                        
                        batchDaysWithTime[day] = {
                            start_time: startTime || '',
                            end_time: endTime || ''
                        };
                    } else {
                        // If no time section, just store the day
                        batchDaysWithTime[day] = {
                            start_time: '',
                            end_time: ''
                        };
                    }
                });
                
                console.log('Batch days with timings being submitted:', batchDaysWithTime);
                formData.set('batch_days', JSON.stringify(batchDaysWithTime));
                
                // Check if this is an edit or create
                const isEdit = $('#internship-form').data('is-edit');
                const internshipId = $('#internship-form').data('internship-id');
                
                let url = "{{ route('company.internship.store') }}";
                let method = "POST";
                
                if (isEdit && internshipId) {
                    url = "{{ url('company/internship/update') }}/" + internshipId;
                    console.log('Updating Internship:', internshipId);
                } else {
                    console.log('Creating new Internship');
                }
                
                console.log('Making AJAX call to:', url);
                
                // AJAX request
                $.ajax({
                    type: method,
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                     
                        if (response.success) {
                             Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });


                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            window.internshipPublishing = false;
                            setInternshipPublishLoading(false);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'An error occurred'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        window.internshipPublishing = false;
                        setInternshipPublishLoading(false);
                        console.log('❌ ERROR:', xhr.responseText);
                        
                        let errorMessage = 'An error occurred';
                        const res = xhr.responseJSON || {};

                        if (res.errors) {
                            clearInternshipValidation();
                            let firstErrorEl = null;
                            Object.keys(res.errors).forEach(function(field) {
                                const messages = res.errors[field];
                                const msg = Array.isArray(messages) ? messages[0] : messages;
                                let $el = $('[name="' + field + '"]');
                                if (!$el.length) {
                                    $el = $('[name="' + field + '[]"]');
                                }
                                if (!$el.length && field === 'internship_description') {
                                    $el = $('#full-editor-internship-description');
                                } else if (!$el.length && field === 'module_description') {
                                    $el = $('#editor-module-desc');
                                } else if (!$el.length && field === 'internship_objective') {
                                    $el = $('#full-editor-key-responsibilities');
                                } else if (!$el.length && field === 'internship_outcome') {
                                    $el = $('#editor-industry-outcome');
                                }
                                if ($el.length) {
                                    showInternshipFieldError($el.first(), msg);
                                    if (!firstErrorEl) firstErrorEl = $el.first();
                                }
                            });
                            if (firstErrorEl) {
                                $('html, body').animate({
                                    scrollTop: firstErrorEl.offset().top - 120
                                }, 400);
                            }
                            const firstKey = Object.keys(res.errors)[0];
                            errorMessage = Array.isArray(res.errors[firstKey]) ? res.errors[firstKey][0] : res.errors[firstKey];
                        } else if (res.message) {
                            errorMessage = res.message;
                        }

                        if (res.upgrade_url) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Upgrade Plan Required',
                                text: errorMessage,
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
                                text: errorMessage
                            });
                        }
                    }
                });
                
                return false;
            });

         
        }); // End of $(document).ready() for opportunity form

        // Initialize Select2 for Opportunity form fields
        $(document).ready(function() {
            $('#batch_time').select2({
                placeholder: "Select Batch Days",
                allowClear: true,
                width: '100%'
            });

            $('#category_id').select2({
                placeholder: "Select Category",
                allowClear: true,
                width: '100%'
            });

            $('#internship_sub_category_id').select2({
                placeholder: "Select Subcategory",
                allowClear: true,
                closeOnSelect: false,
                width: '100%',
                dropdownParent: $('#internship_sub_category_id').parent()
            });

            // Load subcategories when category changes (opportunity form)
            $('#category_id').off('change.opportunitySub').on('change.opportunitySub', function () {
                loadInternshipSubCategories($(this).val());
            });

            $('#toggle-other-category').on('click', function() {
                const enable = $('#use_other_category').val() !== '1';
                setCategoryOtherMode(enable);
                if (enable) {
                    $('#other_category_name').focus();
                }
            });

            $('#toggle-other-subcategory').on('click', function() {
                if ($('#use_other_category').val() === '1') {
                    return;
                }
                const enable = $('#use_other_subcategory').val() !== '1';
                setSubcategoryOtherMode(enable, false);
                if (enable) {
                    $('#other_subcategory_name').focus();
                }
            });

            $('#company_id').select2({
                placeholder: "Select Company",
                allowClear: true,
                width: '100%'
            });

            $('#internship_mode').select2({
                placeholder: "Select Mode",
                allowClear: true,
                width: '100%'
            });

            $('#duration_select').select2({
                placeholder: "Select Duration",
                allowClear: true,
                width: '100%'
            });

            $('#weeks_select').select2({
                placeholder: "Select Weeks",
                allowClear: true,
                width: '100%'
            });

            $('#hours_select').select2({
                placeholder: "Select Hours",
                allowClear: true,
                width: '100%'
            });

            $('#perks').select2({
                placeholder: "Select Perks & Benefits",
                allowClear: true,
                width: '100%'
            });
        });

        function loadInternshipSubCategories(categoryId, selectedIds) {
            selectedIds = selectedIds || [];
            var $subSelect = $('#internship_sub_category_id');
            $subSelect.empty().trigger('change');

            if (!categoryId) {
                return;
            }

            $.ajax({
                url: "{{ route('sub-category-action') }}",
                type: "POST",
                data: {
                    category_id: categoryId,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.status === 1 && response.data) {
                        response.data.forEach(function (item) {
                            var isSelected = selectedIds.map(String).indexOf(String(item.sub_category_id)) !== -1;
                            var option = new Option(item.sub_category_nm, item.sub_category_id, isSelected, isSelected);
                            $subSelect.append(option);
                        });
                        $subSelect.trigger('change');
                    }
                }
            });
        }
        // isNumber function for numeric inputs
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        // GST Calculation + date range constraints
        $(document).ready(function() {
            $('#internship_fee, #gst_percentage').on('input', function() {
                const fee = parseFloat($('#internship_fee').val()) || 0;
                const gstPercent = parseFloat($('#gst_percentage').val()) || 18;
                const gstAmount = (fee * gstPercent) / 100;
                const totalFee = fee + gstAmount;
                
                $('#gst_amount').val(gstAmount.toFixed(2));
                $('#total_fee').val(totalFee.toFixed(2));
            });

            // Application Deadline: today → start date
            // Last date of registration: application deadline → start date
            window.updateInternshipDateConstraints = function() {
                const pad = (n) => String(n).padStart(2, '0');
                const now = new Date();
                const today = now.getFullYear() + '-' + pad(now.getMonth() + 1) + '-' + pad(now.getDate());

                const $start = $('#start_date');
                const $deadline = $('#application_deadline');
                const $lastReg = $('#last_registration_date');
                const startDate = $start.val() || '';
                const deadlineVal = $deadline.val() || '';

                // Application Deadline: between today and start date
                let deadlineMin = today;
                if (deadlineVal && deadlineVal < today) {
                    deadlineMin = deadlineVal; // keep existing past value valid on edit
                }
                $deadline.attr('min', deadlineMin);
                if (startDate) {
                    $deadline.attr('max', startDate);
                    if (deadlineVal && deadlineVal > startDate) {
                        $deadline.val('');
                    }
                } else {
                    $deadline.removeAttr('max');
                }

                // Last registration: between application deadline and start date
                const freshDeadline = $deadline.val() || '';
                if (freshDeadline) {
                    $lastReg.attr('min', freshDeadline);
                } else {
                    $lastReg.removeAttr('min');
                }
                if (startDate) {
                    $lastReg.attr('max', startDate);
                } else {
                    $lastReg.removeAttr('max');
                }
                const lastRegVal = $lastReg.val() || '';
                if (lastRegVal) {
                    if (freshDeadline && lastRegVal < freshDeadline) {
                        $lastReg.val('');
                    } else if (startDate && lastRegVal > startDate) {
                        $lastReg.val('');
                    }
                }
            };

            $('#start_date, #application_deadline').on('change input', function() {
                window.updateInternshipDateConstraints();
            });
            window.updateInternshipDateConstraints();
        });

        // Skills Input Handler for Opportunity
        let skillsArray = [];
        const skillInput = document.getElementById('skills');
        const skillContainer = document.getElementById('skill-input-container');
        const skillsHidden = document.getElementById('required_skills');

        if (skillInput) {
            skillInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const skill = this.value.trim();
                    if (skill && !skillsArray.includes(skill)) {
                        skillsArray.push(skill);
                        addSkillTag(skill);
                        this.value = '';
                        skillsHidden.value = JSON.stringify(skillsArray);
                    }
                }
            });
        }

        function addSkillTag(skill) {
            const tag = document.createElement('span');
            tag.className = 'skill-tag';
            tag.innerHTML = `${skill} <span class="remove-skill" onclick="removeSkill('${skill}')">&times;</span>`;
            skillContainer.insertBefore(tag, skillInput);
        }

        function removeSkill(skill) {
            skillsArray = skillsArray.filter(s => s !== skill);
            skillsHidden.value = JSON.stringify(skillsArray);
            renderSkills();
        }

        function renderSkills() {
            const tags = skillContainer.querySelectorAll('.skill-tag');
            tags.forEach(tag => tag.remove());
            skillsArray.forEach(skill => addSkillTag(skill));
        }

        // Eligibility Criteria Input Handler
        let eligibilityArray = [];
        const eligibilityInput = document.getElementById('eligibility_criteria');
        const eligibilityContainer = document.getElementById('eligibility_criteria_input_container');
        const eligibilityHidden = document.getElementById('required_eligibility_criteria');

        if (eligibilityInput) {
            eligibilityInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const criteria = this.value.trim();
                    if (criteria && !eligibilityArray.includes(criteria)) {
                        eligibilityArray.push(criteria);
                        addEligibilityTag(criteria);
                        this.value = '';
                        eligibilityHidden.value = JSON.stringify(eligibilityArray);
                    }
                }
            });
        }

        function addEligibilityTag(criteria) {
            const tag = document.createElement('span');
            tag.className = 'eligibility-tag';
            tag.innerHTML = `${criteria} <span class="remove-eligibility" onclick="removeEligibility('${criteria}')">&times;</span>`;
            eligibilityContainer.insertBefore(tag, eligibilityInput);
        }

        function removeEligibility(criteria) {
            eligibilityArray = eligibilityArray.filter(c => c !== criteria);
            eligibilityHidden.value = JSON.stringify(eligibilityArray);
            renderEligibility();
        }

        function renderEligibility() {
            const tags = eligibilityContainer.querySelectorAll('.eligibility-tag');
            tags.forEach(tag => tag.remove());
            eligibilityArray.forEach(criteria => addEligibilityTag(criteria));
        }

       

         function BackJobList() {
            // console.log("BackJobList called");

            // Hide form, show list
            document.getElementById("createjob").style.display = "none";
            document.getElementById("createInternship").style.display = "none";
            document.getElementById("joblist").style.display = "block";
            document.getElementById("Internshiplist").style.display = "none";

            // Clean up Select2 to prevent conflicts
            if ($('#job_category_id').hasClass('select2-hidden-accessible')) {
                $('#job_category_id').select2('destroy');
                $('#job_sub_category_id').select2('destroy');
            }
        }

        function CreateInternships() {
            var canCreateInternship = {!! empty($hideCreateInternshipBtn) ? 'true' : 'false' !!};
            if (!canCreateInternship) {
                showPlanLimitAlert('internship');
                return;
            }

            // Hide opportunity list, show opportunity creation form
            document.getElementById("Internshiplist").style.display = "none";
            document.getElementById("createInternship").style.display = "block";
            
            // Wait for form to show
            setTimeout(function() {
                // Reset form
                $('#internship-form')[0].reset();
                $('#gst_percentage').val(18);
                $('#gst_amount').val('');
                $('#total_fee').val('');
                $('#internship_fee').val('');
                $('#late_registration_fee').val('');
                $('#last_registration_date').val('');
                
                // Clear Select2 fields
                $('#category_id').val(null).trigger('change');
                $('#internship_sub_category_id').empty().val(null).trigger('change');
                $('#category_id').prop('disabled', false);
                $('#internship_sub_category_id').prop('disabled', false);
                $('#use_other_category, #use_other_subcategory').val('0');
                $('#other_category_name, #other_subcategory_name').val('');
                $('#category_request_id, #subcategory_request_id').val('');
                $('#category-other-row, #subcategory-other-row').removeClass('is-other-mode');
                $('#other-category-wrap, #other-subcategory-wrap').hide();
                $('#toggle-other-category').text('Other');
                $('#toggle-other-subcategory').text('Other').show();
                $('#other-subcategory-hint').text('This will be sent to admin for approval.');
                $('#internship_mode').val(null).trigger('change');
                $('#batch_time').val(null).trigger('change');
                $('#perks').val(null).trigger('change');
                $('#all_week_days').prop('checked', false);
                $('#copy_batch_times').prop('checked', false);
                $('#copy_batch_times_wrap').hide();
                if (typeof setDurationOtherMode === 'function') setDurationOtherMode(false);
                if (typeof setWeeksOtherMode === 'function') setWeeksOtherMode(false);
                if (typeof setHoursOtherMode === 'function') setHoursOtherMode(false);
                $('#duration_select').val(null).trigger('change');
                $('#weeks_select').val(null).trigger('change');
                $('#hours_select').val(null).trigger('change');
                $('#duration_other, #weeks_other, #hours_other').val('');
                $('#duration, #weeks, #hours').val('');
                $('#use_other_duration, #use_other_weeks, #use_other_hours').val('0');
                $('#duration-other-row, #weeks-other-row, #hours-other-row').removeClass('is-other-mode');
                $('#other-duration-wrap, #other-weeks-wrap, #other-hours-wrap').hide();
                $('#toggle-other-duration, #toggle-other-weeks, #toggle-other-hours').text('Other');
                
                // Clear skills and eligibility arrays
                skillsArray = [];
                eligibilityArray = [];
                $('#skill-input-container .skill-tag').remove();
                $('#eligibility_criteria_input_container .eligibility-tag').remove();
                $('#required_skills').val('');
                $('#required_eligibility_criteria').val('');
                
                // Uncheck all batch days
                $('input[name="batch_days[]"]').prop('checked', false);
                
                // Clear Quill editors
                if (typeof quillOpportunityDesc !== 'undefined') {
                    quillOpportunityDesc.setText('');
                }
                if (typeof quillModuleDesc !== 'undefined') {
                    quillModuleDesc.setText('');
                }
                if (typeof quillObjective !== 'undefined') {
                    quillObjective.setText('');
                }
                if (typeof quillOutcome !== 'undefined') {
                    quillOutcome.setText('');
                }
                
                // Clear time sections and timing object
                $('#timeSectionFirst').empty();
                $('#timeSections').empty();
                window.batchTimingObj = {};
                
                // Reset form data attributes
                $('#internship-form').removeData('internship-id');
                $('#internship-form').removeData('is-edit');
                
                // Reset button text and icon
                $('#saveInternshipBtn #btnText').text('Publish Internship');
                $('#saveInternshipBtn i').removeClass('fa-edit').addClass('fa-save');
                
                // Reset flags
                $("#flag").val("A");
                $("#row_id").val("");

                if (typeof window.updateInternshipDateConstraints === 'function') {
                    window.updateInternshipDateConstraints();
                }
            }, 100);
        }

        window.BackJobInternship = function BackJobInternship() {
            // Hide opportunity form, show opportunity list
            document.getElementById("createInternship").style.display = "none";
            document.getElementById("Internshiplist").style.display = "block";
        }
        
            // ==================== INTERNSHIP MANAGEMENT FUNCTIONS ====================
        
        // Explicitly attach to window for inline onclick handlers
    window.EditInternship = function EditInternship(internshipId) {
            // Fetch opportunity data
            $.ajax({
                url: "{{ url('company/internship/edit') }}/" + internshipId,
                type: "GET",
                success: function(response) {
                    if (response.success) {
                        const internship = response.internship;
                        
                        // Populate form fields
                        $('#internship_title').val(internship.internship_title);
                        $('#category_id').off('change.opportunitySub');
                        $('#category_id').val(internship.category).trigger('change.select2');
                        loadInternshipSubCategories(internship.category, internship.sub_categories || []);
                        $('#category_id').on('change.opportunitySub', function () {
                            loadInternshipSubCategories($(this).val());
                        });

                        // Handle "Other" category/subcategory from edit data
                        if (internship.use_other_category) {
                            $('#use_other_category').val('1');
                            $('#other_category_name').val(internship.requested_category_name || '');
                            setCategoryOtherMode(true);
                        }
                        if (internship.use_other_subcategory) {
                            $('#use_other_subcategory').val('1');
                            const subNames = (internship.requested_subcategory_names || []).join(', ');
                            $('#other_subcategory_name').val(subNames);
                            // If category is not in other mode, enable subcategory other mode
                            if (!internship.use_other_category) {
                                setSubcategoryOtherMode(true, false);
                            }
                        }
                        $('#company_website').val(internship.company_website);
                        $('#internship_mode').val(internship.mode).trigger('change');
                        $('#location').val(internship.location);
                        if (typeof window.setInternshipDurationValue === 'function') {
                            window.setInternshipDurationValue(internship.duration);
                        } else {
                            $('#duration').val(internship.duration);
                        }
                        if (typeof window.setInternshipWeeksValue === 'function') {
                            window.setInternshipWeeksValue(internship.total_weeks);
                        } else {
                            $('#weeks').val(internship.total_weeks);
                        }
                        if (typeof window.setInternshipHoursValue === 'function') {
                            window.setInternshipHoursValue(internship.total_hours);
                        } else {
                            $('#hours').val(internship.total_hours);
                        }
                        $('#stipend').val(internship.stipend);
                        $('#openings').val(internship.openings);
                        $('#internship_fee').val(internship.registration_fees ?? 0);
                        $('#late_registration_fee').val(internship.late_registration_fee ?? 0);
                        $('#last_registration_date').val(internship.last_registration_date || internship.late_register_last_date || '');
                        $('#gst_percentage').val(internship.gst_percentage ?? 18);
                        $('#gst_amount').val(internship.gst_amount ?? 0);
                        $('#total_fee').val(internship.final_amount ?? 0);
                        
                        // Set dates - format them properly
                        if (internship.start_date) {
                            $('#start_date').val(internship.start_date);
                            console.log('Start Date set:', internship.start_date);
                        }
                        if (internship.end_date) {
                            $('#end_date').val(internship.end_date);
                            console.log('End Date set:', internship.end_date);
                        }
                        if (internship.application_deadline) {
                            $('#application_deadline').val(internship.application_deadline);
                            console.log('Application Deadline set:', internship.application_deadline);
                        }

                        if (typeof window.updateInternshipDateConstraints === 'function') {
                            window.updateInternshipDateConstraints();
                        }
                        
                        // Set batch days in select2 dropdown with timings
                        console.log('Setting batch days...');
                        console.log('Raw batch_days from server:', internship.batch_days);
                        console.log('Type:', typeof internship.batch_days);
                        
                        if (internship.batch_days) {
                            let batchDaysData = null;
                            let daysArray = [];
                            
                            // Handle different data formats
                            if (typeof internship.batch_days === 'string') {
                                try {
                                    batchDaysData = JSON.parse(internship.batch_days);
                                } catch (e) {
                                    console.error('Error parsing batch_days string:', e);
                                    batchDaysData = null;
                                }
                            } else if (typeof internship.batch_days === 'object' && internship.batch_days !== null) {
                                batchDaysData = internship.batch_days;
                            }
                            
                            console.log('Parsed batch_days data:', batchDaysData);
                            
                            // Extract days from the object/array
                            if (batchDaysData) {
                                if (Array.isArray(batchDaysData)) {
                                    // Old format: just array of days
                                    daysArray = batchDaysData;
                                    // Convert to object format for consistency
                                    const tempObj = {};
                                    daysArray.forEach(day => {
                                        tempObj[day] = { start_time: '', end_time: '' };
                                    });
                                    batchDaysData = tempObj;
                                } else {
                                    // New format: object with day as key and times as value
                                    daysArray = Object.keys(batchDaysData);
                                }
                            }
                            
                            console.log('Days array:', daysArray);
                            console.log('Batch days data object:', batchDaysData);
                            
                            // Set select2 value
                            if (daysArray.length > 0) {
                                // Convert to lowercase and trim to match option values
                                daysArray = daysArray.map(day => String(day).toLowerCase().trim());
                                console.log('Days to set (lowercase & trimmed):', daysArray);
                                
                                // Store timing data globally for the change event
                                window.batchTimingObj = {};
                                Object.keys(batchDaysData).forEach(day => {
                                    const dayLower = day.toLowerCase();
                                    window.batchTimingObj[dayLower] = {
                                        start: batchDaysData[day].start_time || '',
                                        end: batchDaysData[day].end_time || ''
                                    };
                                });
                                
                                console.log('Stored timing object:', window.batchTimingObj);
                                
                                // Clear first
                                $('#batch_time').val(null).trigger('change');
                                
                                // Set new values with a small delay to ensure select2 is ready
                                setTimeout(() => {
                                    $('#batch_time').val(daysArray).trigger('change');
                                    const setValues = $('#batch_time').val();
                                    console.log('Batch days actually set in select2:', setValues);
                                    
                                    if (!setValues || setValues.length === 0) {
                                        console.warn('Failed to set batch days. Trying alternative method...');
                                        // Alternative: Set options as selected
                                        daysArray.forEach(day => {
                                            $('#batch_time option[value="' + day + '"]').prop('selected', true);
                                        });
                                        $('#batch_time').trigger('change');
                                    }
                                    
                                    // After select2 triggers change and creates time sections,
                                    // populate the time values
                                    setTimeout(() => {
                                        Object.keys(window.batchTimingObj).forEach(day => {
                                            const daySection = $(`.day-section[data-day="${day}"]`);
                                            if (daySection.length) {
                                                const timing = window.batchTimingObj[day];
                                                daySection.find('.start-time').val(timing.start);
                                                daySection.find('.end-time').val(timing.end);
                                                console.log(`Set times for ${day}:`, timing);
                                            }
                                        });
                                    }, 100);
                                }, 200);
                            } else {
                                console.log('No valid batch days to set');
                            }
                        } else {
                            console.log('No batch_days in Internship data');
                        }
                        
                        // Set skills
                        if (internship.skills) {
                            let skills = [];
                            try {
                                // Handle different data formats
                                if (typeof internship.skills === 'string') {
                                    // Try JSON parse first
                                    try {
                                        skills = JSON.parse(internship.skills);
                                    } catch (e) {
                                        // If not JSON, split by comma
                                        skills = internship.skills.split(',');
                                    }
                                } else if (Array.isArray(internship.skills)) {
                                    skills = internship.skills;
                                }
                            } catch (e) {
                                console.error('Error parsing skills:', e);
                                skills = [];
                            }
                            
                            // Clear existing skills
                            skillsArray = [];
                            $('#skill-input-container .skill-tag').remove();
                            
                            // Add each skill - ensure skills is an array
                            if (Array.isArray(skills)) {
                                skills.forEach(skill => {
                                    const trimmedSkill = String(skill).trim();
                                    if (trimmedSkill && !skillsArray.includes(trimmedSkill)) {
                                        skillsArray.push(trimmedSkill);
                                        addSkillTag(trimmedSkill);
                                    }
                                });
                            }
                            
                            $('#required_skills').val(JSON.stringify(skillsArray));
                        }
                        
                        // Set eligibility criteria
                        if (internship.eligibility_criteria) {
                            let criteria = [];
                            try {
                                // Handle different data formats
                                if (typeof internship.eligibility_criteria === 'string') {
                                    // Try JSON parse first
                                    try {
                                        criteria = JSON.parse(internship.eligibility_criteria);
                                    } catch (e) {
                                        // If not JSON, split by comma
                                        criteria = internship.eligibility_criteria.split(',');
                                    }
                                } else if (Array.isArray(internship.eligibility_criteria)) {
                                    criteria = internship.eligibility_criteria;
                                }
                            } catch (e) {
                                console.error('Error parsing eligibility_criteria:', e);
                                criteria = [];
                            }
                            
                            // Clear existing criteria
                            eligibilityArray = [];
                            $('#eligibility_criteria_input_container .eligibility-tag').remove();
                            
                            // Add each criteria - ensure criteria is an array
                            if (Array.isArray(criteria)) {
                                criteria.forEach(criterion => {
                                    const trimmedCriterion = String(criterion).trim();
                                    if (trimmedCriterion && !eligibilityArray.includes(trimmedCriterion)) {
                                        eligibilityArray.push(trimmedCriterion);
                                        addEligibilityTag(trimmedCriterion);
                                    }
                                });
                            }
                            
                            $('#required_eligibility_criteria').val(JSON.stringify(eligibilityArray));
                        }
                        
                        // Set perks
                        if (internship.perks && Array.isArray(internship.perks)) {
                            $('#perks').val(internship.perks).trigger('change');
                        }
                        
                        // Set Quill editor content
                        if (typeof quillOpportunityDesc !== 'undefined') {
                            quillOpportunityDesc.root.innerHTML = internship.internship_description || '';
                        }
                        if (typeof quillModuleDesc !== 'undefined') {
                            quillModuleDesc.root.innerHTML = internship.module_brief_description || '';
                        }
                        if (typeof quillObjective !== 'undefined') {
                            quillObjective.root.innerHTML = internship.internship_objective || '';
                        }
                        if (typeof quillOutcome !== 'undefined') {
                            quillOutcome.root.innerHTML = internship.internship_outcome || '';
                        }
                        
                        // Store opportunity ID for update
                        $('#internship-form').data('internship-id', internshipId);
                        $('#internship-form').data('is-edit', true);
                        
                        // Show form
                        $("#Internshiplist").hide();
                        $("#createInternship").show();
                        
                        // Update button text and icon
                        $('#saveInternshipBtn #btnText').text('Update Internship');
                        $('#saveInternshipBtn i').removeClass('fa-save').addClass('fa-edit');
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load Internship data'
                    });
                }
            });
        }

        function changeInternshipStatus(internshipId, status) {
            let msg = status == 0 ?
                "Do you want to mark this Internship as <b>Active</b>? It will be visible to candidates." :
                "Do you want to mark this Internship as <b>Closed</b>? It will no longer accept applications.";

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
                        url: "{{ url('company/internship/change-status') }}/" + internshipId,
                        type: "POST",
                        data: {
                            status: status,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Updated!",
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                setTimeout(() => location.reload(), 1500);
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update status'
                            });
                        }
                    });
                }
            });
        }

        function deleteInternship(internshipId) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('company/internship/delete') }}/" + internshipId,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Deleted!",
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                setTimeout(() => location.reload(), 1500);
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete Internship'
                            });
                        }
                    });
                }
            });
        }

        // Global functions for category/subcategory "Other" mode (must be global for EditInternship to call)
        window.setCategoryOtherMode = function setCategoryOtherMode(enabled) {
            $('#use_other_category').val(enabled ? '1' : '0');
            $('#category-other-row').toggleClass('is-other-mode', enabled);
            $('#other-category-wrap').toggle(enabled);
            $('#toggle-other-category').text(enabled ? 'Select from list' : 'Other');
            if (enabled) {
                $('#category_id').val(null).trigger('change');
                $('#category_id').prop('disabled', true);
                setSubcategoryOtherMode(true, true);
                $('#other-subcategory-hint').text('Category is custom, so enter a custom subcategory as well.');
            } else {
                $('#category_id').prop('disabled', false);
                $('#other_category_name').val('');
                $('#category_request_id').val('');
                setSubcategoryOtherMode(false);
                $('#other-subcategory-hint').text('This will be sent to admin for approval.');
            }
        }

        window.setSubcategoryOtherMode = function setSubcategoryOtherMode(enabled, lockedByCategory) {
            $('#use_other_subcategory').val(enabled ? '1' : '0');
            $('#subcategory-other-row').toggleClass('is-other-mode', enabled);
            $('#other-subcategory-wrap').toggle(enabled);
            $('#toggle-other-subcategory').text(enabled ? 'Select from list' : 'Other');
            if (lockedByCategory) {
                $('#toggle-other-subcategory').hide();
            } else {
                $('#toggle-other-subcategory').show();
            }
            if (enabled) {
                $('#internship_sub_category_id').val(null).trigger('change');
                $('#internship_sub_category_id').prop('disabled', true);
            } else {
                $('#internship_sub_category_id').prop('disabled', false);
                $('#other_subcategory_name').val('');
                $('#subcategory_request_id').val('');
            }
        }
</script>
    <script>
        var quill = new Quill('#job_description_editor', {
            theme: 'snow',
            placeholder: 'Enter job description here...'
        });
    </script>

    <script>
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
        function togglePassword(inputId, buttonId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(buttonId).querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }

        document.getElementById("oldtogglePassword").onclick = function() {
            togglePassword("old_password", "oldtogglePassword");
        };

        document.getElementById("passtogglePassword").onclick = function() {
            togglePassword("new_password", "passtogglePassword");
        };

        document.getElementById("newtogglePassword").onclick = function() {
            togglePassword("new_password_confirmation", "newtogglePassword");
        };
    </script>

    <script>
        let validatorEducation = $("#apply-status-form").validate({
            rules: {
                status: {
                    required: true
                },

            },
            messages: {
                status: {
                    required: "Please Select Application Status"
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
        $("#apply-status-form").submit(function(e) {
            e.preventDefault();

            if (!$("#apply-status-form").valid()) {
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

            var url = "{{ route('apply-job-application-reject-action') }}";

            // LoaderShow();


            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(response) {
                    // LoaderShow();
                    $("#RejectApplicationApply").modal('hide');
                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                        });

                         loadJobApplyDetails(response.job_id);

                        // setTimeout(function() {
                        //     location.reload();
                        // }, 1000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message,
                        });

                    }
                },
                error: function(xhr) {
                    LoaderShow();
                    // console.log(xhr.responseText);
                }
            });
        });


        function ApplicationReject(id) {
            $("#RejectApplicationApply").modal('show');
            $("#apply_id").val(id);
        }

    // new function update by shakshi
        function injectHtmlWithScripts(selector, htmlContent) {
            var $target = $(selector);
            var $wrapper = $('<div>').html(htmlContent);

            $target.empty().html($wrapper.contents().not('script'));

            $wrapper.find('script').each(function() {
                var script = document.createElement('script');

                if (this.src) {
                    script.src = this.src;
                    script.async = false;
                } else {
                    script.text = this.innerHTML;
                }

                document.body.appendChild(script);
                document.body.removeChild(script);
            });
        }

        function loadJobApplyDetails(jobId) {

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
                url: "{{ route('view-apply-job-history-action') }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    LoaderHide();
                    if (response.status === 1) {
                        // new line update by shakshi
                        injectHtmlWithScripts('#tab-job-apply-history', response.htmlContent);
                        $('#tab-job-apply-history').addClass('show active');
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
        function switchToShortlistTab() {
            // Remove active from all tabs
            $('.nav-link').removeClass('active');
            $('.tab-pane').removeClass('show active');

            // Activate shortlist tab button
            $('a[href="#tab-job-apply-history"]').addClass('active');

            // Activate shortlist tab content
            $('#tab-job-apply-history').addClass('show active');

            // Optional: Save active tab
            localStorage.setItem('activeTab', '#tab-job-apply-history');
        }

        function AddToShortlist(id) {
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
                url: "{{ route('apply-job-add-to-shortlist-action') }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    LoaderHide();

                    if (response.status === 1) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Added to Shortlist!',
                            text: response.message || 'Candidate added successfully',
                            timer: 1200,
                            showConfirmButton: false
                        });

                        let job_id = response.job_id;

                        setTimeout(function () {
                            // 🔥 Reload shortlist content
                            updateShortlistTabSilently(job_id);

                            // 🔥 Switch to shortlist tab
                            switchToShortlistTab();
                        }, 500);

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    LoaderHide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                    });
                }
            });
            return false;
        }

        function SetScheduleInterview(id) {
            $("#interview_job_apply_id").val(id);
            $("#ScheduleInterviewModal").modal('show');
        }

        // ✅ NEW FUNCTION: Update shortlist tab silently without switching tabs
        function updateShortlistTabSilently(jobId) {
            var data = {
                'job_id': jobId
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('view-apply-job-history-action') }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.status === 1) {
                        // ✅ Update tab content WITHOUT switching to it
                        // update this line by shakshi
                        injectHtmlWithScripts('#tab-job-apply-history', response.htmlContent);
                        $('#tab-job-apply-history').data('job-id', jobId);
                        
                        // ✅ Optional: Update apply count on job card if visible
                        updateJobCardApplyCount(jobId);
                    }
                }
            });
        }

        // ✅ Helper function to refresh job card apply count
        function updateJobCardApplyCount(jobId) {
            // Find job card and update apply count if needed
            var $jobCard = $('[data-job-id="' + jobId + '"]');
            if ($jobCard.length) {
                // You can update specific elements in the job card here
                // For example, refresh the apply count badge
            }
        }

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

        $("#job-form").submit(function(e) {
            e.preventDefault();

            $("#job_description").val(quill.root.innerHTML.trim());

            // Remove empty interview round rows before submit to prevent blank DB entries
            $('#CompanyInterviewRow .product-row').each(function() {
                var roundName = $(this).find('input[name="round_nm[]"]').val();
                if (!roundName || roundName.trim() === '') {
                    $(this).find('input, select, textarea').attr('disabled', true);
                }
            });

            if (!$("#job-form").valid()) {
                // Re-enable disabled inputs if validation fails
                $('#CompanyInterviewRow .product-row input:disabled').attr('disabled', false);
                return;
            }

            let form = $(this);
            // let url = form.attr('action');
            let formData = form.serialize(); // Use FormData for file uploads

            // Re-enable disabled inputs after serialize
            $('#CompanyInterviewRow .product-row input:disabled').attr('disabled', false);

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
                    var res = xhr.responseJSON || {};
                    var msg = res.message || res.error || 'Something went wrong. Please try again.';
                    var upgradeUrl = res.upgrade_url || '';
                    if (upgradeUrl) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Upgrade Plan Required',
                            text: msg,
                            showCancelButton: true,
                            confirmButtonText: 'Upgrade Plan',
                            cancelButtonText: 'Close'
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                window.location.href = upgradeUrl;
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Unable to create job',
                            text: msg,
                        });
                    }
                }
            });
        });



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
        

        var skills_arr = [];

        function loadSkills() {

                let categoryId = $('#job_category_id').val();
                let subCatId   = $('#job_sub_category_id').val();

                // console.log("Loading skills for:", categoryId, subCatId);

                if (!categoryId || !subCatId) {
                    skills_arr = [];
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('skill-fetch-action') }}",
                    data: {
                        category_id: categoryId,        // ✅ MUST
                        sub_category_id: subCatId,      // ✅ MUST
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function (res) {
            if (res.status === 1 && Array.isArray(res.data) && res.data.length > 0) {

                skills_arr = res.data[0].skill_nm
                    .split(',')
                    .map(s => s.trim())
                    .filter(s => s !== '');

            } else {
                skills_arr = [];
            }


                        $('#Skillsuggestions').hide().html('');
                    }
                });
        }
    
         

        const SkillSelect = document.getElementById('skill_id');
        const Skillsuggestions = document.getElementById('Skillsuggestions');
        // const skillsHidden = document.getElementById('skills_hidden');
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

            SkillSelect.value = '';
            Skillsuggestions.innerHTML = '';
            Skillsuggestions.style.display = 'none';
        }


        function EditJob(id) {
            // console.log("EditJob called for ID:", id);
            
            LoaderShow();
            $.ajax({
                url: `{{ url('job-action/${id}/edit') }}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    LoaderHide();
                    if (response.status === 1) {
                        renderExistingRounds(response.rounds);
                        const data = response.data;
                        // console.log("Edit Data received:", data);
                        
                        // ✅ Step 1: Show create job form
                        document.getElementById("joblist").style.display = "none";
                        document.getElementById("createjob").style.display = "block";

                        $("#job_preference_type").val(data.preference_type);

                                // Highlight correct button
                                if (data.preference_type == 1) {
                                    SelectJobType('Skilled');
                                } else {
                                    SelectJobType('Non-Skilled');
                                }

                        
                        // ✅ Step 2: Wait for form to render
                        setTimeout(function() {
                            // Reset form first
                            $('#job-form')[0].reset();
                            
                            // ✅ Step 3: DESTROY EXISTING SELECT2 (IMPORTANT!)
                            if ($('#job_category_id').hasClass('select2-hidden-accessible')) {
                                $('#job_category_id').select2('destroy');
                            }
                            if ($('#job_sub_category_id').hasClass('select2-hidden-accessible')) {
                                $('#job_sub_category_id').select2('destroy');
                            }
                            if ($('#job_minimum_qualification').hasClass('select2-hidden-accessible')) {
                                $('#job_minimum_qualification').select2('destroy');
                            }
                            
                            // ✅ Step 4: POPULATE CATEGORY DROPDOWN (NATIVE)
                            $('#job_category_id').empty();
                            $('#job_category_id').append('<option value="">-- Select Job Category --</option>');
                            
                            // Add all categories
                            @foreach($CategoryData as $cat)
                                var selected = {{$cat->category_id}} == data.category_id ? 'selected' : '';
                                $('#job_category_id').append('<option value="{{$cat->category_id}}" ' + selected + '>{{$cat->category_nm}}</option>');
                            @endforeach
                            
                            // console.log("Category populated. Selected ID:", data.category_id);
                            
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
                                        // console.log("Sub-category response:", subResponse);
                                        console.log("Category:", $('#job_category_id').val());
                                        console.log("SubCat:", $('#job_sub_category_id').val());
                                        console.log("Skills Arr:", skills_arr);

                                        
                                        if (subResponse.status === 1 && subResponse.data) {
                                            // Populate sub-category dropdown
                                            $('#job_sub_category_id').empty();
                                            $('#job_sub_category_id').append('<option value="">Select Sub Category</option>');
                                            
                                            subResponse.data.forEach(subCat => {
                                                var selected = subCat.sub_category_id == data.sub_category_id ? 'selected' : '';
                                                $('#job_sub_category_id').append(
                                                    '<option value="' + subCat.sub_category_id + '" ' + selected + '>' + subCat.sub_category_nm + '</option>'
                                                );
                                            });
                                            
                                            // console.log("Sub-category populated. Selected ID:", data.sub_category_id);
                                            
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

                                                $('#job_minimum_qualification').select2({
                                                    placeholder: "-- Select Minimum Qualification --",
                                                    allowClear: true,
                                                    width: '100%',
                                                });
                                                
                                                // ✅ Step 7: SET VALUES AND TRIGGER DISPLAY UPDATE
                                                $('#job_category_id').val(data.category_id).trigger('change.select2');
                                                $('#job_sub_category_id').val(data.sub_category_id).trigger('change.select2');
                                                $('#job_minimum_qualification').val(data.qualification_id).trigger('change.select2');
                                                // 🔥 NOW load skills (AFTER both are set)
                                                setTimeout(function () {
                                                    loadSkills();
                                                }, 300);

                                                
                                                // ✅ Step 8: MANUALLY UPDATE SELECT2 DISPLAY (CRITICAL!)
                                                setTimeout(function() {
                                                    updateSelect2Display('#job_category_id');
                                                    updateSelect2Display('#job_sub_category_id');
                                                }, 50);
                                                
                                            }, 100);
                                            
                                        } else {
                                            // console.error("No sub-categories found");
                                            $('#job_sub_category_id').empty();
                                            $('#job_sub_category_id').append('<option value="">No Sub Categories</option>');
                                            
                                            // Still initialize Select2
                                            initSelect2();
                                        }
                                    },
                                    error: function(xhr) {
                                        // console.error("Sub-category AJAX error:", xhr.responseText);
                                        $('#job_sub_category_id').empty();
                                        $('#job_sub_category_id').append('<option value="">Error loading</option>');
                                        initSelect2();
                                    }
                                });
                            } else {
                                // No category selected, still initialize
                                $('#job_sub_category_id').empty();
                                $('#job_sub_category_id').append('<option value="">Select Sub Category</option>');
                                initSelect2();
                            }
                            
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
                                } catch(e) {
                                    // console.log("Skills parse error:", e);
                                }
                            }
                            
                            // console.log("All form values set successfully");
                            
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
                    // console.error("Edit AJAX error:", xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to load job data.',
                    });
                }
            });
        }


        // ✅ HELPER FUNCTION: Initialize Select2
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

        $('#job_minimum_qualification').select2({
            placeholder: "-- Select Minimum Qualification --",
            allowClear: true,
            width: '100%',
        });
    }, 100);
}

        // ✅ HELPER FUNCTION: Manually update Select2 display
        function updateSelect2Display(selector) {
    var $select = $(selector);
    var selectedValue = $select.val();
    var selectedText = $select.find('option:selected').text();
    var $select2Container = $select.next('.select2-container');
    
    if ($select2Container.length && selectedText && selectedText !== '') {
        var $display = $select2Container.find('.select2-selection__rendered');
        $display.text(selectedText);
        $display.attr('title', selectedText);
        
        // console.log("Updated display for", selector, ":", selectedText);
        
        // Force Select2 to refresh
        $select.trigger('change.select2');
    }
}
    
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
                                // console.log(xhr.responseText);

                                let errorMsg = "Something went wrong";
                                try {
                                    const res = JSON.parse(xhr.responseText);
                                    errorMsg = res.message || errorMsg;
                                } catch (e) {}

                                // console.log(errorMsg)
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
                                // console.log(xhr.responseText);

                                let errorMsg = "Something went wrong";
                                try {
                                    const res = JSON.parse(xhr.responseText);
                                    errorMsg = res.message || errorMsg;
                                } catch (e) {}

                                // console.log(errorMsg)
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
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message,
                                    });

                                }
                            },
                            error: function(xhr) {
                                // console.log(xhr.responseText);

                                let errorMsg = "Something went wrong";
                                try {
                                    const res = JSON.parse(xhr.responseText);
                                    errorMsg = res.message || errorMsg;
                                } catch (e) {}

                                // console.log(errorMsg)
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
        const job_states = @json($states); // contains [{ state_id: 1, state_name: "Rajasthan" }, ...]
        var job_cities = [];
        var job_areas = [];
        var job_pincodes = [];


        const job_StateSelect = document.getElementById('job_state_id');
        const job_suggestionsBox = document.getElementById('job_Statesuggestions');
        const job_stateIdhidden = document.getElementById('job_state_id_hidden');


        job_StateSelect.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            job_suggestionsBox.innerHTML = '';

            if (query.length === 0) {
                job_suggestionsBox.style.display = 'none';
                return;
            }

            const filteredStates = job_states.filter(state =>
                state.state_name.toLowerCase().includes(query)
            );

            if (filteredStates.length > 0) {
                job_suggestionsBox.style.display = 'block';
                filteredStates.forEach(state => {
                    const div = document.createElement('div');
                    div.classList.add('suggestion-item');
                    div.textContent = state.state_name;
                    div.addEventListener('click', () => {
                        job_StateSelect.value = state.state_name;
                        job_stateIdhidden.value = state.state_id;
                        job_suggestionsBox.innerHTML = '';
                        job_suggestionsBox.style.display = 'none';

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
                                    window.job_cities = response.data;

                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message,
                                    });

                                }
                            },
                            error: function(xhr) {
                                // console.log(xhr.responseText);

                                let errorMsg = "Something went wrong";
                                try {
                                    const res = JSON.parse(xhr.responseText);
                                    errorMsg = res.message || errorMsg;
                                } catch (e) {}

                                // console.log(errorMsg)
                            }
                        });
                    });
                    job_suggestionsBox.appendChild(div);
                });
            } else {
                job_suggestionsBox.style.display = 'none';
            }

            // Reset state_id on every input (if user types manually)
            job_stateIdhidden.value = '';
        });


        const job_CitySelect = document.getElementById('job_city_id'); // Text input
        const job_CitysuggestionsBox = document.getElementById('job_Citysuggestions'); // Suggestion box
        const job_CityIdhidden = document.getElementById('job_city_id_hidden'); // Hidden input for selected city_id


        job_CitySelect.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            job_CitysuggestionsBox.innerHTML = '';

            if (query.length === 0) {
                job_CitysuggestionsBox.style.display = 'none';
                return;
            }

            const filteredCities = job_cities.filter(city =>
                city.city_nm.toLowerCase().includes(query)
            );

            if (filteredCities.length > 0) {
                job_CitysuggestionsBox.style.display = 'block';
                filteredCities.forEach(city => {
                    const div = document.createElement('div');
                    div.classList.add('suggestion-item');
                    div.textContent = city.city_nm;
                    div.addEventListener('click', () => {
                        job_CitySelect.value = city.city_nm;
                        job_CityIdhidden.value = city.city_id;
                        job_CitysuggestionsBox.innerHTML = '';
                        job_CitysuggestionsBox.style.display = 'none';

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
                                    window.job_areas = response.data;

                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message,
                                    });

                                }
                            },
                            error: function(xhr) {
                                // console.log(xhr.responseText);

                                let errorMsg = "Something went wrong";
                                try {
                                    const res = JSON.parse(xhr.responseText);
                                    errorMsg = res.message || errorMsg;
                                } catch (e) {}

                                // console.log(errorMsg)
                            }
                        });
                    });
                    job_CitysuggestionsBox.appendChild(div);
                });
            } else {
                job_CitysuggestionsBox.style.display = 'none';
            }

            // Reset city_id if user types manually
            job_CityIdhidden.value = '';
        });


        const job_AreaSelect = document.getElementById('job_area_id'); // Text input
        const job_AreasuggestionsBox = document.getElementById('job_Areasuggestions'); // Suggestion box
        const job_AreaIdhidden = document.getElementById('job_area_id_hidden'); // Hidden input for selected city_id


        job_AreaSelect.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            job_AreasuggestionsBox.innerHTML = '';

            if (query.length === 0) {
                job_AreasuggestionsBox.style.display = 'none';
                return;
            }

            const filteredAreas = job_areas.filter(area =>
                area.area_nm.toLowerCase().includes(query)
            );

            if (filteredAreas.length > 0) {
                job_AreasuggestionsBox.style.display = 'block';
                filteredAreas.forEach(area => {
                    const div = document.createElement('div');
                    div.classList.add('suggestion-item');
                    div.textContent = area.area_nm;
                    div.addEventListener('click', () => {
                        job_AreaSelect.value = area.area_nm;
                        job_AreaIdhidden.value = area.area_id;
                        job_AreasuggestionsBox.innerHTML = '';
                        job_AreasuggestionsBox.style.display = 'none';

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
                                    window.job_pincodes = response.data;

                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message,
                                    });
                                }
                            },
                            error: function(xhr) {
                                // console.log(xhr.responseText);

                                let errorMsg = "Something went wrong";
                                try {
                                    const res = JSON.parse(xhr.responseText);
                                    errorMsg = res.message || errorMsg;
                                } catch (e) {}

                                // console.log(errorMsg)
                            }
                        });
                    });
                    job_AreasuggestionsBox.appendChild(div);
                });
            } else {
                job_AreasuggestionsBox.style.display = 'none';
            }

            // Reset city_id if user types manually
            job_AreaIdhidden.value = '';
        });


        const job_PincodeSelect = document.getElementById('job_zipcode'); // Text input
        const job_PincodeSuggestionsBox = document.getElementById('job_Pincodesuggestions'); // Suggestion box
        const job_PincodeIdHidden = document.getElementById('job_pincode_id_hidden'); // Hidden input
        const JobAreaSuggestBox = document.getElementById('JobAreaSuggestBox'); // Area suggestion box

        // Prevent form submission on Enter key in job pincode field
        job_PincodeSelect.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                return false;
            }
        });

        job_PincodeSelect.addEventListener('input', function() {
            const query = this.value.trim();
            job_PincodeSuggestionsBox.innerHTML = '';
            JobAreaSuggestBox.innerHTML = ''; // Clear previous area suggestions

            if (query.length === 0 || !Array.isArray(window.job_pincodes)) {
                job_PincodeSuggestionsBox.style.display = 'none';
                return;
            }

            const filteredPincodes = job_pincodes.filter(pincode =>
                pincode.zipcode.includes(query)
            );

            if (filteredPincodes.length > 0) {
                job_PincodeSuggestionsBox.style.display = 'block';
                filteredPincodes.forEach(pincode => {
                    const div = document.createElement('div');
                    div.classList.add('suggestion-item');
                    div.textContent = pincode.zipcode;
                    div.addEventListener('click', () => {
                        job_PincodeSelect.value = pincode.zipcode;
                        job_PincodeIdHidden.value = pincode.zipcode_id;
                        job_PincodeSuggestionsBox.innerHTML = '';
                        job_PincodeSuggestionsBox.style.display = 'none';
                        
                        // Clear area suggestions when pincode is selected
                        JobAreaSuggestBox.innerHTML = '';
                    });
                    job_PincodeSuggestionsBox.appendChild(div);
                });
            } else {
                job_PincodeSuggestionsBox.style.display = 'none';
            }

            // Reset hidden ID on manual input
            job_PincodeIdHidden.value = '';
        });

        // Optional: hide suggestions when clicked outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.autocomplete-container')) {
                job_PincodeSuggestionsBox.innerHTML = '';
                job_PincodeSuggestionsBox.style.display = 'none';

                job_AreasuggestionsBox.innerHTML = '';
                job_AreasuggestionsBox.style.display = 'none';

                job_CitysuggestionsBox.innerHTML = '';
                job_CitysuggestionsBox.style.display = 'none';

                job_suggestionsBox.innerHTML = '';
                job_suggestionsBox.style.display = 'none';
            }
        });
    </script>
    {{-- Location Finder For Job --}}

    <script>
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

            // Prevent Enter key from submitting form
            zipcodeInput.addEventListener("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    return false;
                }
            });

            // Trigger on 'change' or 'Enter key press'
            zipcodeInput.addEventListener("change", handleZipcodeLookup);
            zipcodeInput.addEventListener("keypress", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault(); // Prevent form submit if inside a form
                    handleZipcodeLookup();
                }
            });

            function handleZipcodeLookup() {
                // Clear previous area suggestions
                $("#JobAreaSuggestBox").empty();
                
                $("#job_state_id_hidden").val("");
                $("#job_state_id").val("");

                $("#job_city_id_hidden").val("");
                $("#job_city_id").val("");

                $("#job_area_id_hidden").val("");
                $("#job_area_id").val("");

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

                            // Clear and rebuild
                            $("#JobAreaSuggestBox").empty();

                            var AreaSuggestBadge = ''
                            areas.forEach(val => {
                                AreaSuggestBadge += `<span class="badge-item me-1 mb-1"
                                onclick="SelectJObAreaBox(${val.area_id}, '${val.area_nm}')">
                            ${val.area_nm}
                         </span>`;
                            });

                            $("#JobAreaSuggestBox").html(AreaSuggestBadge);

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
    </script>

    <script>
        $("#company-about-form").submit(function(e) {
            e.preventDefault();

            if (!$(this).valid()) {
                return;
            }

            let form = $(this)[0]; // ✅ Native DOM element
            let formData = new FormData(form); // ✅ Handles text + file inputs

            let url = "{{ route('company.profile.about.action', $user->id) }}";

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
                    // console.log(xhr.responseText);

                    let errorMsg = "Something went wrong";
                    try {
                        const res = JSON.parse(xhr.responseText);
                        errorMsg = res.message || errorMsg;
                    } catch (e) {}

                    // console.log(errorMsg)
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

            let form = $(this)[0]; // ✅ Native DOM element
            let formData = new FormData(form); // ✅ Handles text + file inputs

            let url = "{{ route('company.profile.action', $user->id) }}";

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
                    // console.log(xhr.responseText);

                    let errorMsg = "Something went wrong";
                    try {
                        const res = JSON.parse(xhr.responseText);
                        errorMsg = res.message || errorMsg;
                    } catch (e) {}

                    // console.log(errorMsg)
                }
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
                error.insertAfter(element);
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
                    // console.log(errorMsg);
                }
            });
        });



        function showPlanLimitAlert(type) {
            var isJob = type === 'job';
            var jobLimitData = {!! json_encode(isset($jobLimitCheck) && is_array($jobLimitCheck) ? $jobLimitCheck : ['allowed' => true, 'message' => null, 'limit' => null, 'used' => 0, 'upgrade_url' => null]) !!};
            var internshipLimitData = {!! json_encode(isset($internshipLimitCheck) && is_array($internshipLimitCheck) ? $internshipLimitCheck : ['allowed' => true, 'message' => null, 'limit' => null, 'used' => 0, 'upgrade_url' => null]) !!};
            var limitData = isJob ? jobLimitData : internshipLimitData;
            var canPost = isJob
                ? {!! !empty($canPostJob) ? 'true' : 'false' !!}
                : {!! !empty($canPostInternship) ? 'true' : 'false' !!};
            var upgradeUrl = limitData.upgrade_url || @json(route('pricing', ['user_id' => Auth::id() ?? 0]));

            var msg = limitData.message;
            if (!canPost) {
                msg = isJob
                    ? 'Your current plan does not include Job service. Please upgrade your plan to post jobs.'
                    : 'Your current plan does not include Opportunity service. Please upgrade your plan to post opportunities.';
            }
            if (!msg) {
                msg = 'Your plan create limit has been reached. Please upgrade your plan to continue.';
            }

            Swal.fire({
                icon: 'warning',
                title: 'Upgrade Plan Required',
                text: msg,
                showCancelButton: true,
                confirmButtonText: 'Upgrade Plan',
                cancelButtonText: 'Close'
            }).then(function(result) {
                if (result.isConfirmed && upgradeUrl) {
                    window.location.href = upgradeUrl;
                }
            });
        }

        function CreateNewJob() {
            // console.log("CreateNewJob called");
            var canCreateJob = {!! empty($hideCreateJobBtn) ? 'true' : 'false' !!};
            if (!canCreateJob) {
                showPlanLimitAlert('job');
                return;
            }
            
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
                
                // Reset skills
                $('#skills_hidden').val('');
                $('.box-tags').empty();
                
                // Reset flags
                $("#flag").val("A");
                $("#row_id").val("");
                
                // Set default to Unskilled (preference_type = 2)
                $("#job_preference_type").val('2');
                $('.job-type-select').removeClass('select-job');
                $('#noneskill').addClass('select-job');
                
                // Load Unskilled categories by default
                loadJobCategories(2);
                
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
                    
                    // console.log("Create form initialized");
                }, 100);
                
            }, 100);
        }

        // function BackJobList() {
        //     document.getElementById("createjob").style.display = "none";
        //     document.getElementById("joblist").style.display = "block";
        // }
        function BackJobList() {
            // console.log("BackJobList called");
            
            // Hide form, show list
            document.getElementById("createjob").style.display = "none";
            document.getElementById("joblist").style.display = "block";
            
            // Clean up Select2 to prevent conflicts
            if ($('#job_category_id').hasClass('select2-hidden-accessible')) {
                $('#job_category_id').select2('destroy');
                $('#job_sub_category_id').select2('destroy');
            }
        }

        // function SelectJobType(type) {
        //     // Remove active class from both selectors
        //     $('.job-type-select').removeClass('select-job');

        //     // Toggle visibility based on job type
        //     if (type === 'Non-Skilled') {
        //         $('#noneskill').addClass('select-job');
        //         // $('#SkillMinimumQualification').hide();
        //         // $('#NonSkillMinimumQualification').show();
        //         $("#job_preference_type").val('2');
        //     } else if (type === 'Skilled') {
        //         $('#skill').addClass('select-job');
        //         // $('#SkillMinimumQualification').show();
        //         // $('#NonSkillMinimumQualification').hide();
        //         $("#job_preference_type").val('1');
        //     }
        // }
       function SelectJobType(type) {
        // console.log("SelectJobType:", type);
        
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
        // console.log("Loading categories for preference:", preferenceType);
        
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
            data: { preference_type: preferenceType },
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
                    
                    // console.log("Categories loaded:", categories.length);
                } else {
                    $('#job_category_id').empty().append('<option value="">No Categories Found</option>');
                }
            },
            error: function() {
                $('#job_category_id').empty().append('<option value="">Error loading categories</option>');
            }
        });
    }


        // Optional: remove image
        function removeProfileImage() {
            $('#remove_img').val(1);
            $('#profilePreview').attr('src', '{{ asset('uploads/profile/profile.png') }}');
        }

        //  Add Estimated Time Row Loop
        const CompanyInterviewRow = document.getElementById('CompanyInterviewRow');

        var count = 1;
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
                                                                                            for="round_description">Round Description</label>
                                                                                        <input class="form-control"
                                                                                            id="round_description"
                                                                                            type="text"
                                                                                            name="round_description[]"
                                                                                            placeholder="Enter Round Description">
                                                                                    </div>
                                                                                </div>

                          <div class="col-lg-1">
                            <button class="btn btn-brand-1 hover-up mt-4 remove-row" style="padding: 18px 21px;background: #cb0000;" type="button"><i class="fa fa-trash remove-row"></i></button>
                          </div>
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
    </script>

    <script>
    // Profile image preview with STRICT 100x100 validation

    let cropper = null;
    // Profile image preview with STRICT 100x100 validation
    document.getElementById('profile_img').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(event){
            document.getElementById('cropModal').style.display="flex";
            const cropImg = document.getElementById('companyCropImage');

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
            //     autoCropArea:1,
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

    // Authorized Company Signatory preview
    document.getElementById('company_signature').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (event) {
            document.getElementById('companySignaturePreview').src = event.target.result;
        };
        reader.readAsDataURL(file);
    });

    // Certificate Logo preview
    document.getElementById('certificate_logo').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (event) {
            document.getElementById('certificateLogoPreview').src = event.target.result;
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

    // Remove company signature function
    function removeCompanySignature() {
        $('#remove_signature').val(1);
        $('#companySignaturePreview').attr('src', '{{ asset('assets/imgs/logo/logo1.png') }}');
        $('#company_signature').val('');
    }

    // Remove certificate logo function
    function removeCertificateLogo() {
        $('#remove_certificate_logo').val(1);
        $('#certificateLogoPreview').attr('src', '{{ asset('assets/imgs/logo/logo1.png') }}');
        $('#certificate_logo').val('');
    }
    // function changeStatus(jobId, status){

    //     let msg = status == 1 
    //         ? "Are you sure you want to mark job as Active?"
    //         : "Are you sure you want to mark job as Closed?";

    //     if(!confirm(msg)) return;

    //     $.ajax({
    //         url: "{{ route('job-status-change') }}",
    //         type: "POST",
    //         data: {
    //             job_id: jobId,
    //             status: status,
    //             _token: "{{ csrf_token() }}",
    //         },
    //         success:function(res){
    //             alert("Status Updated Successfully!");
    //             location.reload();
    //         }
    //     });
    // }
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


    </script>

    <script>
    $(document).ready(function() {
        // console.log("DOM Ready - Initializing Select2");
        
        // Initialize Select2 ONLY IF ELEMENTS EXIST
        if ($('#job_category_id').length) {
            $('#job_category_id').select2({
                placeholder: "-- Select Job Category --",
                allowClear: true,
                width: '100%'
            });
        }
        
        if ($('#job_sub_category_id').length) {
            $('#job_sub_category_id').select2({
                placeholder: "-- Select Sub Category --",
                allowClear: true,
                width: '100%'
            });
        }
        
        // console.log("Select2 initialized on DOM ready");
    });
    // 🔥 WHEN SUB CATEGORY CHANGES → LOAD SKILLS
    $(document).on('change', '#job_sub_category_id', function () {

        let subCatId = $(this).val();

        if (!subCatId) {
            skills_arr = [];
            $('#Skillsuggestions').hide().html('');
            return;
        }

        // 🔥 MAIN FIX
        loadSkills();
    });

    // 🔥 CREATE JOB: Load Sub Category when Category changes
    $(document).on('change', '#job_category_id', function () {

        let categoryId = $(this).val();

        // Reset sub category
        $('#job_sub_category_id')
            .empty()
            .append('<option value="">Loading...</option>');

        if (!categoryId) {
            $('#job_sub_category_id')
                .empty()
                .append('<option value="">Select Sub Category</option>');
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('sub-category-action') }}",
            data: {
                category_id: categoryId
            },
            dataType: "json",
            success: function (response) {

                $('#job_sub_category_id').empty();
                $('#job_sub_category_id')
                    .append('<option value="">Select Sub Category</option>');

                if (response.status === 1 && response.data.length > 0) {
                    response.data.forEach(sub => {
                        $('#job_sub_category_id').append(
                            `<option value="${sub.sub_category_id}">
                                ${sub.sub_category_nm}
                            </option>`
                        );
                    });
                } else {
                    $('#job_sub_category_id')
                        .append('<option value="">No Sub Category Found</option>');
                }

                // 🔁 Re-init Select2
                if ($('#job_sub_category_id').hasClass('select2-hidden-accessible')) {
                    $('#job_sub_category_id').select2('destroy');
                }

                $('#job_sub_category_id').select2({
                    placeholder: "-- Select Sub Category --",
                    allowClear: true,
                    width: '100%'
                });
            }
        });
    });

    </script>

    <script>
    $(document).ready(function () {

        // Save active tab
        $(document).on('shown.bs.tab', 'a[data-bs-toggle="tab"]', function (e) {
            let activeTab = $(e.target).attr('href');
            localStorage.setItem('activeTab', activeTab);
        });

        // Restore active tab
        let activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('a[data-bs-toggle="tab"][href="' + activeTab + '"]').tab('show');
        }
    });
    function renderExistingRounds(rounds) {

        // Clear ALL rows (including the default empty template row) to prevent duplicates
        $('#CompanyInterviewRow').empty();

        let html = '';

        (rounds || []).forEach(r => {
            html += `
            <div class="row product-row mt-3 existing-round">
                <div class="col-lg-12">
                    <div class="branch-box">
                        <div class="row">

                            <!-- IMPORTANT -->
                            <input type="hidden" name="round_id[]" value="${r.id}">

                            <div class="col-lg-4">
                                <label class="form-label">Round Name</label>
                            <input class="form-control"
        type="text"
        name="round_nm[]"
        value="${r.round_name}"
        readonly>
                            </div>

                            <div class="col-lg-7">
                                <label class="form-label">Round Description</label>
                            <input class="form-control"
        type="text"
        name="round_description[]"
        value="${r.round_desc}"
        readonly>
                            </div>

                            <div class="col-lg-1">
                                <button type="button"
                                        class="btn btn-warning mt-4 edit-round">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>`;
        });

        // Add an empty row at the end so user can add new rounds
        html += `
            <div class="row product-row">
                <div class="col-lg-12">
                    <div class="branch-box">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label" for="round_nm">Round Name</label>
                                    <input class="form-control" type="text" name="round_nm[]" placeholder="Enter Round Name">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label class="form-label" for="round_description">Round Description</label>
                                    <input class="form-control" type="text" name="round_description[]" placeholder="Enter Round Description">
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <button class="btn btn-brand-1 hover-up mt-4 add-row" style="padding: 18px 21px;" type="button"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

        $('#CompanyInterviewRow').append(html);
    }
    $(document).on('click', '.edit-round', function () {

        let row = $(this).closest('.existing-round');

        row.find('input[type="text"]').prop('readonly', false);


        $(this)
            .removeClass('btn-warning edit-round')
            .addClass('btn-success save-round')
            .html('<i class="fa fa-save"></i>');
    });

    $(document).on('click', '.save-round', function () {

        let row = $(this).closest('.existing-round');

        row.find('input[type="text"]').prop('readonly', true);


        $(this)
            .removeClass('btn-success save-round')
            .addClass('btn-warning edit-round')
            .html('<i class="fa fa-edit"></i>');
    });

    </script>

    <script>
    $(document).ready(function () {

        // 🔥 ONLY Minimum Qualification Select2
        $('#job_minimum_qualification').select2({
            placeholder: "-- Select Minimum Qualification --",
            allowClear: true,
            width: '100%'
        });

    });
    </script>

    <script>
    $(document).on('click', '.view-plan', function () {

        $('#m_plan_name').text($(this).data('plan-name'));
        $('#m_plan_price').text('₹ ' + $(this).data('plan-price'));
        $('#m_payment_id').text($(this).data('payment-id'));
        $('#m_order_id').text($(this).data('order-id'));
        $('#m_duration').text($(this).data('duration'));
        $('#m_purchase_date').text($(this).data('purchase-date'));
        $('#m_expire_date').text($(this).data('expire-date'));
        $('#m_job_limit').text($(this).data('job-limit') || '-');
        $('#m_opportunity_limit').text($(this).data('opportunity-limit') || '-');

        let status = $(this).data('status');
        let badge = status === 'Active'
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-danger">Expired</span>';

        $('#m_status').html(badge);

        $('#planDetailModal').modal('show');
    });
    </script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
@endpush
