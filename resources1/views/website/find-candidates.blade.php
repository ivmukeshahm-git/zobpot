@push('css')
<style>
    @media only screen and (min-width: 768px) {
        .banner-hero .block-banner .form-find {
            display: flex !important;
        }
    }
</style>
<style>
/* ===== SCREENSHOT STRUCTURE – DYNAMIC CONTENT ===== */

.blog-card {
    background: #fff;
    border-radius: 22px;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    /* border: 1px solid #eee; */
    transition: 0.3s ease;
}

img:hover {
    transform: translateY(-6px);
    /* box-shadow: 0 20px 45px rgba(37,42,98,0.15); */
}

/* IMAGE */
.blog-img img {
    width: 100%;
    /* height: 220px; */
    height: 200px;
    object-fit: cover;
    border-radius: 22px;
}

/* BODY */
.blog-body {
    padding: 7px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

/* TAG WRAPPER */
.blog-tag-wrap {
    width: 100%;
    display: flex;
    justify-content: flex-start;
}

/* TAG ITSELF */
.blog-tag {
    display: inline-flex;
    align-items: center;
    width: fit-content;
    background: rgba(243,104,37,0.12);
    color: #f36825;
    font-size: 13px;
    font-weight: 600;
    padding: 5px 14px;
    margin-bottom: 7px;
    border-radius: 20px;
    white-space: nowrap;
}


/* TITLE */
.blog-title {
    font-size: 18px;
    font-weight: 700;
    color: #252a62;
    line-height: 1.4;
    margin-bottom: 8px;

    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* DESCRIPTION */
.blog-desc {
    font-size: 14px;
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 18px;

    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* FOOTER */
.blog-footer {
    margin-top: auto;
    display: flex;
    align-items: center;
    gap: 10px;
}

.blog-footer img {
    width: 42px;
    height: 42px;
    border-radius: 50%;
}

.blog-author {
    font-size: 14px;
    font-weight: 600;
    color: #252a62;
}

.blog-date {
    font-size: 12px;
    color: #9ca3af;
}
</style>
<style>
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
/* Candidate Cards Styling - Fixed Height */
.candidate-card-simple {
    background: #FFFFFF !important;
    border-radius: 16px !important;
    padding: 20px !important;
    margin-bottom: 24px !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    border: 1px solid #f0f0f0 !important;
    transition: all 0.3s ease !important;
    cursor: pointer !important;
    height: 450px !important;
    display: flex !important;
    flex-direction: column !important;
    position: relative !important;
    overflow: hidden !important;
}

.candidate-card-simple:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 12px 35px rgba(36, 42, 101, 0.15) !important;
    border-color: #242a65 !important;
}

/* Candidate Header - Fixed Height */
.candidate-header {
    /* display: flex !important; */
    align-items: flex-start !important;
    gap: 15px !important;
    margin-bottom: 5px !important;
    height: 90px !important;
    flex-shrink: 0 !important;
}

.candidate-avatar {
    position: relative !important;
    flex-shrink: 0 !important;
}

.candidate-img {
    width: 80px !important;
    height: 80px !important;
    border-radius: 50% !important;
    object-fit: cover !important;
    border: 3px solid #e9ecef !important;
    transition: border-color 0.3s ease !important;
}

.candidate-card-simple:hover .candidate-img {
    border-color: #242a65 !important;
}


.candidate-basic-info {
    flex: 1 !important;
    min-width: 0 !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
}

.candidate-name {
    font-size: 18px !important;
    font-weight: 700 !important;
    color: #242a65 !important;
    margin-bottom: 5px !important;
    line-height: 1.3 !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 1 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
}

.candidate-name a {
    color: inherit !important;
    text-decoration: none !important;
    transition: color 0.3s ease !important;
}

.candidate-name a:hover {
    color: #f36825 !important;
}

/* Experience Badge */
.candidate-experience {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
    padding: 5px 10px !important;
    border-radius: 20px !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 5px !important;
    width: fit-content !important;
    margin-bottom: 10px !important;
}

.candidate-experience i {
    font-size: 11px !important;
}

/* Category & Designation Section */
.candidate-details-info {
    margin: 6px 0 !important;
    padding: 12px !important;
    background: #f8faff !important;
    border-radius: 12px !important;
    border-left: 4px solid #242a65 !important;

    height: 85px !important;        /* 🔥 FIXED */
    overflow: hidden !important;
    flex-grow: 0 !important;
}


.detail-row {
    display: flex !important;
    align-items: center !important;
    margin-bottom: 12px !important;
}

.detail-row:last-child {
    margin-bottom: 0 !important;
}

.detail-label {
    min-width: 110px !important;
    font-size: 13px !important;
    color: #666 !important;
    font-weight: 500 !important;
}

.detail-value {
    font-size: 14px !important;
    color: #242a65 !important;
    font-weight: 600 !important;
    flex: 1 !important;

    display: -webkit-box !important;
    -webkit-line-clamp: 1 !important;   /* 🔥 only 1 line */
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: normal !important;
}


.detail-value.designation {
    color: #f36825 !important;
    font-weight: 700 !important;
}

.detail-value.category {
    color: #28a745 !important;
}

/* Location with Icon */
.location-row {
    display: flex !important;
    align-items: center !important;
    margin-top: 5px !important;
    padding: 10px 15px !important;
    background: #f0f8ff !important;
    border-radius: 10px !important;
    border: 1px solid #e1f0ff !important;
    flex-shrink: 0 !important;
}

.location-icon {
    color: #f36825 !important;
    margin-right: 10px !important;
    font-size: 16px !important;
    flex-shrink: 0 !important;
}

.location-text {
    font-size: 14px !important;
    color: #242a65 !important;
    font-weight: 500 !important;

    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
}


.candidate-footer {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    margin-top: auto !important;
    padding-top: 12px !important;
    border-top: 1px solid #f0f0f0 !important;
}

.salary-section {
    font-size: 14px !important;
    font-weight: 600 !important;
    color: #242a65 !important;
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
}


.view-profile-btn {
    background: linear-gradient(135deg, #242a65 0%, #3a428a 100%) !important;
    color: white !important;
    text-decoration: none !important;
    padding: 10px 24px !important;
    border-radius: 10px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    width: 100%;
    justify-content: center !important;
}

.view-profile-btn:hover {
    background: linear-gradient(135deg, #f36825 0%, #ff8c42 100%) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 15px rgba(243, 104, 37, 0.3) !important;
}

/* No Candidates State */
.no-candidates-state {
    text-align: center !important;
    padding: 60px 20px !important;
    background: #f8faff !important;
    border-radius: 16px !important;
    margin: 20px 0 !important;
}

.no-candidate-icon {
    font-size: 64px !important;
    margin-bottom: 16px !important;
    opacity: 0.7 !important;
}

.no-candidates-state h4 {
    font-size: 24px !important;
    color: #242a65 !important;
    margin-bottom: 8px !important;
    font-weight: 700 !important;
}

.no-candidates-state p {
    color: #666 !important;
    font-size: 16px !important;
    margin: 0 !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .candidate-card-simple {
        height: auto !important;
        min-height: 360px !important;
        overflow: visible !important;
        padding: 14px !important;
    }
    
    .candidate-header {
        gap: 12px !important;
        height: auto !important;
    }
    
    .candidate-img {
        width: 70px !important;
        height: 70px !important;
    }
    
    .candidate-name {
        font-size: 16px !important;
        -webkit-line-clamp: unset !important;
        overflow: visible !important;
        word-break: break-word !important;
    }
    
    .candidate-name{
        margin-bottom: 6px !important; 
    }
    
    .candidate-details-info {
        padding: 6px !important;
        margin: 0 !important;
        height: auto !important;
        overflow: visible !important;
    }

    .detail-row {
        flex-wrap: wrap !important;
        align-items: flex-start !important;
        margin-bottom: 8px !important;
    }
    
    .detail-label {
        min-width: auto !important;
        width: 100% !important;
        font-size: 12px !important;
        margin-bottom: 2px !important;
    }
    
    .detail-value {
        font-size: 13px !important;
        display: block !important;
        -webkit-line-clamp: unset !important;
        -webkit-box-orient: initial !important;
        overflow: visible !important;
        text-overflow: unset !important;
        white-space: normal !important;
        word-break: break-word !important;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0 !important;
        transform: translateY(20px) !important;
    }
    to {
        opacity: 1 !important;
        transform: translateY(0) !important;
    }
}

.candidate-card-simple {
    animation: fadeInUp 0.5s ease !important;
}

/* Ensure all cards have same height in row */
#candidate-list .row {
    display: flex !important;
    flex-wrap: wrap !important;
}

#candidate-list .col-xl-3,
#candidate-list .col-lg-4,
#candidate-list .col-md-6,
#candidate-list .col-sm-6 {
    display: flex !important;
}

#candidate-list .candidate-card-simple {
    width: 100% !important;
}

/* Loading Skeleton */
.candidate-card-loading {
    background: #f8f9fa !important;
    border-radius: 16px !important;
    padding: 20px !important;
    margin-bottom: 24px !important;
    animation: pulse 1.5s infinite !important;
    height: 350px !important;
}

@keyframes pulse {
    0% { opacity: 0.6 !important; }
    50% { opacity: 0.8 !important; }
    100% { opacity: 0.6 !important; }
}
</style>
@endpush

@extends('website.layout.layout')
@section('website-content')
<script>
    page_active_id = "Candidates";
</script>

<main class="main">
    <form id="search-candidate-filter" onsubmit="return false;">
        <section class="section-box-2">
            <div class="container">
                <div class="banner-hero banner-single banner-single-bg">
                    <div class="block-banner text-center">
                        <h3 class="wow animate__animated animate__fadeInUp"><span class="color-brand-2">{{ $allCandidateCount }}+ Employees</span> Available Now</h3>
                        <div class="font-sm color-text-paragraph-2 mt-10 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">Build your dream team effortlessly.From skilled experts to fresh talent,<br class="d-none d-xl-block">discover candidate perfectly suited to your company's goals. Post a job today and watch your business grow.</div>
                        <div class="form-find text-start mt-40 wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                            <div class="box-industry">
                                <select class="form-input mr-10 select-active input-industry" id="candidate_category"
                                    name="category_id[]">
                                    <option value="all" selected>Industry</option>
                                    @foreach ($CategoryData as $row)
                                         <option value="{{ $row->category_id }}">{{ $row->category_nm }}</option>

                                    @endforeach
                                </select>
                            </div>
                            {{-- <select class="form-input mr-10 select-active" id="candidate_location" name="candidate_location">
                                <option value="">Location</option>
                                @foreach ($locations as $citys)
                                    <option value="{{ $citys->city_id }}">{{ $citys->location }}</option>
                                @endforeach
                            </select> --}}
                            <select class="form-input mr-10 select-active" id="sub_category" name="sub_category_id[]">
                                <option value="">SubCategory</option>
                            </select>
                            <input class="form-input input-keysearch mr-10" type="text" placeholder="Your keyword... " id="candidate_title" name="candidate_title">
                            <button type="button" class="btn btn-default btn-find font-sm" onclick="FilterCandidates()">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="section-box mt-30">
            <div class="container">
                <div class="content-page">
                    <div id="candidate-count-text"></div>
                    <div class="row flex-row-reverse" id="candidate-list">
                            <div class="col-lg-9">
                                <div class="row">
                                    <!-- JS will render here -->
                                </div>
                                <div class="paginations mt-30">
                                    <ul class="pager" id="pagination-links">
                                        <li>
                                            <a class="pager-prev {{ $CandidateData->onFirstPage() ? 'disabled' : '' }}"
                                                href="{{ $CandidateData->previousPageUrl() ?? '#' }}">
                                            </a>
                                        </li>

                                        @php
                                            $lastPage = $CandidateData->lastPage();
                                            $currentPage = $CandidateData->currentPage();
                                            $visiblePages = range(1, min(5, $lastPage));

                                            if ($currentPage > 5 && $currentPage < $lastPage) {
                                                $visiblePages[] = $currentPage;
                                            }

                                            if ($lastPage > 5) {
                                                $visiblePages[] = $lastPage;
                                            }

                                            $visiblePages = array_values(array_unique($visiblePages));
                                            sort($visiblePages);
                                            $prevPage = null;
                                        @endphp

                                        @foreach ($visiblePages as $page)
                                            @if (!is_null($prevPage) && $page - $prevPage > 1)
                                                <li><span class="pager-number disabled">...</span></li>
                                            @endif
                                            <li>
                                                <a class="pager-number {{ $currentPage == $page ? 'active' : '' }}"
                                                    href="{{ $CandidateData->url($page) }}">{{ $page }}</a>
                                            </li>
                                            @php $prevPage = $page; @endphp
                                        @endforeach

                                        <li>
                                            <a class="pager-next {{ !$CandidateData->hasMorePages() ? 'disabled' : '' }}"
                                                href="{{ $CandidateData->nextPageUrl() ?? '#' }}">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        {{-- <div class="col-lg-9 col-md-12 col-sm-12 col-12 float-right">
                                <div class="row">
                                @forelse ($CandidateData as $row)
                                    @php
                                        // Get category and subcategory names
                                        $categoryName = '';
                                        $subCategoryName = '';
                                        foreach ($CategoryData as $cat) {
                                            if ($cat->category_id == $row->category_id) {
                                                $categoryName = $cat->category_nm;
                                                // Find subcategory
                                                if (isset($cat->subcategories)) {
                                                    foreach ($cat->subcategories as $subcat) {
                                                        if ($subcat->sub_category_id == $row->sub_category_id) {
                                                            $subCategoryName = $subcat->sub_category_nm;
                                                            break;
                                                        }
                                                    }
                                                }
                                                break;
                                            }
                                        }
                                        
                                        // Get location details
                                        $locationText = '';
                                        if ($row->city_nm || $row->area_nm || $row->zipcode) {
                                            $parts = [];
                                            if ($row->city_nm) $parts[] = $row->city_nm;
                                            if ($row->area_nm) $parts[] = $row->area_nm;
                                            if ($row->zipcode) $parts[] = 'Pincode: ' . $row->zipcode;
                                            $locationText = implode(', ', $parts);
                                        }
                                    @endphp
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                        <div class="candidate-card-simple" onclick="window.location.href='{{ route('candidate-profile-detail', ['id' => $row->id]) }}'">
                                            <!-- Header with Image and Basic Info -->
                                            <div class="candidate-header">
                                                <div class="candidate-avatar">
                                                    <a href="{{ route('candidate-profile-detail', ['id' => $row->id]) }}">
                                                        <img src="{{ $row->profile_img ? asset('uploads/profile/' . $row->profile_img) : asset('uploads/profile/candidate.jpg') }}" 
                                                            alt="{{ $row->name }}" 
                                                            class="candidate-img">
                                                    </a>
                                                </div>
                                                <div class="candidate-basic-info">
                                                    
                                                    
                                                
                                                    
                                                </div>
                                                @if($row->gender)
                                                        <div class="candidate-gender fw-bold">
                                                            @if($row->gender == '1')
                                                                <i class="fa fa-mars text-primary me-1"></i> Male
                                                            @elseif($row->gender == '2')
                                                                <i class="fa fa-venus text-danger me-1"></i> Female
                                                            @else
                                                                <i class="fa fa-genderless text-secondary me-1"></i> Other
                                                            @endif
                                                        </div>
                                                    @endif
                                            </div>
                                            @if($row->experience)
                                                        <div class="candidate-experience">
                                                            <i class="fa fa-briefcase me-1"></i> {{ ucfirst($row->experience) }}
                                                        </div>
                                            @endif
                                            
                                            <h5 class="candidate-name">
                                                        <a href="{{ route('candidate-profile-detail', ['id' => $row->id]) }}">{{ $row->name }}</a>
                                            </h5>
                                            

                                            <!-- Details Information -->
                                            <div class="candidate-details-info">
                                                
                                            <div class="detail-row">
                                                <span class="detail-label">Job Category:</span>
                                                <span class="detail-value category">{{ $row->category_name ?? '-' }}</span>
                                            </div>

                                                                                    
                                            <div class="detail-row">
                                                <span class="detail-label">Sub Category:</span>
                                                <span class="detail-value">{{ $row->sub_category_name ?? '-' }}</span>
                                            </div>

                                            </div>

                                            <!-- Location Information -->
                                            @if($locationText)
                                                <div class="location-row">
                                                    <i class="fa fa-map-marker-alt location-icon"></i>
                                                    <span class="location-text">{{ $locationText }}</span>
                                                </div>
                                            @endif

                                            <div class="candidate-footer">
                                                <div class="salary-section">
                                                    <i class="fa fa-money me-1"></i> {{ $row->expected_salary ?? '-' }}
                                                </div>

                                                <a href="{{ route('candidate-profile-detail', ['id' => $row->id]) }}"
                                                class="view-profile-btn w-50">
                                                <i class="fa fa-eye me-1"></i>  Profile 
                                                </a>
                                            </div>

                                            
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="no-candidates-state">
                                            <div class="no-candidate-icon">👤</div>
                                            <h4>No Candidates Found</h4>
                                            <p>We couldn't find any candidates matching your criteria</p>
                                        </div>
                                    </div>
                                @endforelse
                                </div>
                                <div class="paginations mt-30">
                                    <ul class="pager" id="pagination-links">
                                        <li>
                                            <a class="pager-prev {{ $CandidateData->onFirstPage() ? 'disabled' : '' }}"
                                                href="{{ $CandidateData->previousPageUrl() ?? '#' }}">
                                            </a>
                                        </li>

                                        @for ($i = 1; $i <= $CandidateData->lastPage(); $i++)
                                            <li>
                                                <a class="pager-number {{ $CandidateData->currentPage() == $i ? 'active' : '' }}"
                                                    href="{{ $CandidateData->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor

                                        <li>
                                            <a class="pager-next {{ !$CandidateData->hasMorePages() ? 'disabled' : '' }}"
                                                href="{{ $CandidateData->nextPageUrl() ?? '#' }}">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div> --}}

                        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                                <div class="sidebar-shadow none-shadow mb-30">
                                    <div class="sidebar-shadow none-shadow mb-30">
                                        <div class="sidebar-filters">

                                            {{-- ================= ADVANCE FILTER HEADER ================= --}}
                                            <div class="filter-block head-border mb-30">
                                                <h5>
                                                    Advance Filter
                                                    <a class="link-reset" href="javascript:void(0);" onclick="location.reload();">Reset</a>
                                                </h5>
                                            </div>

                                            {{-- ================= PREFERENCE TYPE ================= --}}
                                            <div class="filter-block mb-20">
                                                <h5 class="medium-heading mb-15">Preference Type</h5>
                                                <div class="form-group">
                                                    <ul class="list-checkbox">

                                                        @php
                                                            $totalPreference = $preferenceTypeCounts->sum('total');
                                                        @endphp

                                                        <li>
                                                            <label class="cb-container">
                                                                <input type="checkbox" id="select-all-preference-type"
                                                                    class="preference-type-checkbox">
                                                                <span class="text-small">All</span>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <span class="number-item">{{ $totalPreference }}</span>
                                                        </li>

                                                        @foreach ($preferenceTypeCounts as $row)
                                                            <li>
                                                                <label class="cb-container">
                                                                    <input type="checkbox"
                                                                        name="preference_type[]"
                                                                        value="{{ $row->preference_type }}"
                                                                        class="preference-type-checkbox single-preference-type">
                                                                    <span class="text-small">
                                                                        {{ $row->preference_type == 1 ? 'Skilled' : 'UnSkilled' }}
                                                                    </span>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <span class="number-item">{{ $row->total }}</span>
                                                            </li>
                                                        @endforeach

                                                    </ul>
                                                </div>
                                            </div>

                                            @php
                                                $TotalCategoryCandidate = $JobCategoryCount->sum('TotalJob');
                                            @endphp


                                            <div class="filter-block mb-20">
                                                <h5 class="medium-heading mb-15">Industry</h5>
                                                <div class="form-group">
                                                    <ul class="list-checkbox">

                                                        <li>
                                                            <label class="cb-container">
                                                                <input type="checkbox" id="select-all-categories"
                                                                    class="category-checkbox">
                                                                <span class="text-small">All</span>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <span class="number-item">{{ $TotalCategoryCandidate }}</span>
                                                        </li>

                                                        @foreach ($JobCategoryCount as $row)
                                                            <li>
                                                                <label class="cb-container">
                                                                    <input type="checkbox"
                                                                        name="category_id[]"
                                                                        value="{{ $row->category_id }}"
                                                                        class="category-checkbox single-category">
                                                                    <span class="text-small">{{ $row->category_nm }}</span>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <span class="number-item">{{ $row->TotalJob }}</span>
                                                            </li>
                                                        @endforeach

                                                    </ul>
                                                </div>
                                            </div>

                                            {{-- ================= EXPERIENCE LEVEL ================= --}}
                                            <div class="filter-block mb-30">
                                                <h5 class="medium-heading mb-10">Experience Level</h5>
                                                <div class="form-group">
                                                    <ul class="list-checkbox">
                                                        @foreach ($experienceCounts as $row)
                                                            <li>
                                                                <label class="cb-container">
                                                                    <input type="checkbox"
                                                                        name="experience[]"
                                                                        value="{{ $row->experience_name }}">
                                                                    <span class="text-small">{{ $row->experience_name }}</span>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <span class="number-item">{{ $row->total_jobs }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
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
        @if (!$Blog->isEmpty())
            <section class="section-box mt-50 mb-50">   
                <div class="container">
                    <div class="text-start">
                        <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">Blogs & Articles</h2>
                        <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">Get the
                            latest news, updates and tips</p>
                    </div>
                </div>
                <div class="container">
                    <div class="mt-50">
                        {{-- <div class="box-swiper style-nav-top">
                            <div class="swiper-container swiper-group-3 swiper">
                                <div class="swiper-wrapper pb-70 pt-5">
                                    @foreach ($Blog as $row)
                                        <div class="swiper-slide">
                                            <div class="card-grid-3 hover-up wow animate__animated animate__fadeIn">
                                                <div class="text-center card-grid-3-image"><a
                                                        href="{{ route('blog-detail', $row->id) }}">
                                                        <figure><img alt="jobBox"
                                                                src="{{ asset('uploads/blog_img/' . $row->image) }}">
                                                        </figure>
                                                    </a></div>
                                                <div class="card-block-info">
                                                    <div class="tags mb-15"><a class="btn btn-tag"
                                                            href="{{ route('blog-detail', $row->id) }}">Blog</a>
                                                    </div>
                                                    <h5><a
                                                            href="{{ route('blog-detail', $row->id) }}">{{ $row->title }}</a>
                                                    </h5>
                                                    <div class="card-2-bottom mt-20">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-6">
                                                                <div class="d-flex"><img class="img-rounded"
                                                                        src="{{ asset('assets/imgs/profile.png') }}">
                                                                    <div class="info-right-img"><span
                                                                            class="font-sm font-bold color-brand-1 op-70">Zobpot</span><br><span
                                                                            class="font-xs color-text-paragraph-2">
                                                                            {{ \Carbon\Carbon::parse($row->datetime)->format('d F') }}
                                                                            {{ \Carbon\Carbon::parse($row->datetime)->format('Y') }}
                                                                        </span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div> --}}
                        <div class="box-swiper style-nav-top">
                            <div class="swiper-container swiper-group-3 swiper">
                                <div class="swiper-wrapper pb-70 pt-5">

                                    @foreach ($Blog as $row)
                                        <div class="swiper-slide">

                                            {{-- 🔥 YOUR BLOG CARD STRUCTURE --}}
                                            <div class="blog-card w-100">

                                                {{-- IMAGE --}}
                                                <div class="blog-img">
                                                    <a href="{{ route('blog-detail', $row->id) }}">
                                                        <img src="{{ asset('uploads/blog_img/'.$row->image) }}" alt="{{ $row->title }}">
                                                    </a>
                                                </div>

                                                {{-- BODY --}}
                                                <div class="blog-body">

                                                    {{-- TAG --}}
                                                    <div class="blog-tag-wrap">
                                                        <span class="blog-tag">
                                                            {{ $row->category_name ?? 'Blog' }}
                                                        </span>
                                                    </div>

                                                    {{-- TITLE --}}
                                                    <div class="blog-title">
                                                        <a href="{{ route('blog-detail', $row->id) }}">
                                                            {{ $row->title }}
                                                        </a>
                                                    </div>

                                                    {{-- DESCRIPTION --}}
                                                    <div class="blog-desc">
                                                        {{ \Illuminate\Support\Str::limit(strip_tags($row->desc), 90) }}
                                                    </div>

                                                    {{-- FOOTER --}}
                                                    <div class="blog-footer">
                                                        <img src="{{ asset('assets/imgs/profile.png') }}">
                                                        <div>
                                                            <div class="blog-author">
                                                                {{ $row->author_name ?? 'Zobpot' }}
                                                            </div>
                                                            <div class="blog-date">
                                                                {{ \Carbon\Carbon::parse($row->datetime)->format('d F Y') }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            {{-- 🔥 END BLOG CARD --}}

                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            {{-- navigation already working --}}
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        
                    </div>
                </div>
            </section>
        @endif
    </form>
</main>
@endsection

@push('script')
<script>
    function loadSubCategories(categoryId) {
        const $subCategory = $("#sub_category");
        $subCategory.html('<option value="">SubCategory</option>');

        if (!categoryId || categoryId === "all") {
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
            success: function(response) {
                if (response.status === 1 && Array.isArray(response.data)) {
                    let optionHtml = '<option value="">SubCategory</option>';

                    response.data.forEach(function(item) {
                        optionHtml += `<option value="${item.sub_category_id}">${item.sub_category_nm}</option>`;
                    });

                    $subCategory.html(optionHtml);
                }
            },
            error: function() {
                $subCategory.html('<option value="">SubCategory</option>');
            }
        });
    }

    function FilterCandidates(page = 1) {
         let category = $("#candidate_category").val();

        // if industry = all → remove filter
        if(category == "all"){
            $("#candidate_category").prop('name', ''); 
        }else{
            $("#candidate_category").prop('name', 'category_id[]');
        }

        let form = $("#search-candidate-filter");
        let formData = form.serialize() + `&page=${page}`;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        LoaderShow();

        $.ajax({
            type: "POST",
            url: "{{ route('filter-candidates') }}",
            data: formData,
            success: function(response) {
                LoaderHide();
                if (response.status == 1) {
                    const data = response.data;
                    const jobInfo = response.job_info;

                    let showingText = '';

                    if (jobInfo.total > 0 && jobInfo.from && jobInfo.to) {
                        showingText = `
                            <span class='text-small text-showing'>
                                Showing <strong>${jobInfo.from}-${jobInfo.to}</strong> of <strong>${jobInfo.total}</strong> candidates
                            </span>`;
                    } else {
                        showingText = `
                            <span class='text-small text-showing'>
                                No candidates found
                            </span>`;
                    }

                    const countBox = document.getElementById("candidate-count-text");
                    if (countBox) {
                        countBox.innerHTML = showingText;
                    }
                    // console.log("AJAX Data:", data);

                    renderCandidates(data);
                    renderPagination(data);
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
                console.warn('AJAX error:', xhr.responseText);
            }
        });
    }

    $(document).on('change', '#candidate_category', function() {
        loadSubCategories($(this).val());
        $("#sub_category").val('');
    });

    // function renderCandidates(data) {
    //     const list = document.getElementById("candidate-list");
    //     list.innerHTML = "";

    //     if (!data.data || data.data.length === 0) {
    //         list.innerHTML = `
    //             <div class="col-12">
    //                 <div class="no-candidates-state">
    //                     <div class="no-candidate-icon">👤</div>
    //                     <h4>No Candidates Found</h4>
    //                     <p>We couldn't find any candidates matching your criteria</p>
    //                 </div>
    //             </div>`;
    //         return;
    //     }

    //     const baseUrl = "{{ url('candidate-profile-detail') }}";

    //     data.data.forEach(row => {
    //         console.log("==>",row);
    //         const img = row.profile_img
    //             ? `/uploads/profile/${row.profile_img}`
    //             : `/uploads/profile/profile.png`;

    //         // Build location text
    //         let locationParts = [];
    //         if (row.city_nm) locationParts.push(row.city_nm);
    //         if (row.area_nm) locationParts.push(row.area_nm);
    //         if (row.zipcode) locationParts.push(`Pincode: ${row.zipcode}`);
    //         const locationText = locationParts.join(', ');

    //         list.innerHTML += `
    //             <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
    //                 <div class="candidate-card-simple" onclick="window.location.href='${baseUrl}/${row.id}'">
    //                     <div class="candidate-header">
    //                         <div class="candidate-avatar">
    //                             <a href="${baseUrl}/${row.id}">
    //                                 <img src="${img}" class="candidate-img">
    //                             </a>
    //                         </div>
    //                         <div class="candidate-basic-info">
    //                             <h5 class="candidate-name">
    //                                 <a href="${baseUrl}/${row.id}">${row.name}</a>
    //                             </h5>
                                
    //                             ${row.experience ? `
    //                                 <div class="candidate-experience">
    //                                     <i class="fa fa-briefcase me-1"></i> ${row.experience}
    //                                 </div>` : ''}
    //                         </div>
    //                     </div>

    //                     <div class="candidate-details-info">
                            
    //                     ${row.category_name ? `
    // <div class="detail-row">
    //     <span class="detail-label">Job Category:</span>
    //     <span class="detail-value category">${row.category_name}</span>
    // </div>` : ''}

                            
    //                       ${row.sub_category_name ? `
    // <div class="detail-row">
    //     <span class="detail-label">Sub Category:</span>
    //     <span class="detail-value">${row.sub_category_name}</span>
    // </div>` : ''}
    

    //                     </div>

    //                     ${locationText ? `
    //                         <div class="location-row">
    //                             <i class="fa fa-map-marker-alt location-icon"></i>
    //                             <span class="location-text">${locationText}</span>
    //                         </div>` : ''}

    //                     <div class="candidate-footer">
    //                         <a href="${baseUrl}/${row.id}" class="view-profile-btn">
    //                             <i class="fa fa-eye me-1"></i>View Profile
    //                         </a>
    //                     </div>
    //                 </div>
    //             </div>`;
    //     });
    //     console.log(row);
    // }
    
    function renderCandidates(data) {

        // 🔥 EXACT CARD GRID SELECTOR
        const grid = document.querySelector(
            "#candidate-list > .col-lg-9 > .row"
        );

        if (!grid) {
            console.error("Candidate grid not found");
            return;
        }

        // 🔥 CLEAR OLD CARDS
        grid.innerHTML = "";

        // ❌ NO DATA
        if (!data.data || data.data.length === 0) {
            grid.innerHTML = `
                <div class="col-12">
                    <div class="no-candidates-state">
                        <div class="no-candidate-icon">👤</div>
                        <h4>No Candidates Found</h4>
                        <p>No candidates match your filter</p>
                    </div>
                </div>`;
            return;
        }

        const baseUrl = "{{ url('candidate-profile-detail') }}";

        // ✅ LOOP DATA
        data.data.forEach(row => {

            // const img = row.profile_img
            //     ? `/uploads/profile/${row.profile_img}`
            //     : `/uploads/profile/candidate.jpg`;
            const img = (row.profile_img && row.profile_img !== 'profile.png')
                ? `/uploads/profile/${row.profile_img}`
                : `/uploads/profile/candidate.jpg`;

            let location = [];
            if (row.city_nm) location.push(row.city_nm);
            if (row.area_nm) location.push(row.area_nm);
            if (row.zipcode) location.push("Pincode: " + row.zipcode);

            grid.innerHTML += `
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="candidate-card-simple"
                    onclick="window.location.href='${baseUrl}/${row.id}'">

                    <div class="candidate-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="candidate-avatar">
                                <img src="${img}" class="candidate-img">
                            </div>

                            ${row.experience ? `
                            <div class="candidate-experience">
                                <i class="fa fa-briefcase"></i> ${row.experience.charAt(0).toUpperCase() + row.experience.slice(1)}
                            </div>` : ''}
                        </div>
                    </div>


                    <h5 class="candidate-name">${row.name}</h5>

                    <div class="candidate-details-info">
                        <div class="detail-row">
                            <span class="detail-label">Category:</span>
                            <span class="detail-value">${row.category_name ?? '-'}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Sub Category:</span>
                            <span class="detail-value">${row.sub_category_name ?? '-'}</span>
                        </div>
                    </div>

                    ${location.length ? `
                    <div class="location-row">
                        <i class="fa fa-map-marker-alt"></i>
                        ${location.join(', ')}
                    </div>` : ''}

                    <div class="candidate-footer">
                        <a href="${baseUrl}/${row.id}" class="view-profile-btn">
                            <i class="fa fa-eye"></i> Profile
                        </a>
                    </div>

                </div>
            </div>`;
        });
    }


    function renderPagination(data) {
        const pagination = document.getElementById("pagination-links");
        pagination.innerHTML = "";

        if (data.total && data.total > 0) {
            pagination.innerHTML += `
                <li>
                    <a class="pager-prev ${data.current_page === 1 ? 'disabled' : ''}" 
                       href="#" data-page="${data.current_page - 1}">«</a>
                </li>
            `;

            const lastPage = data.last_page;
            const currentPage = data.current_page;
            const visiblePages = [];

            for (let i = 1; i <= Math.min(5, lastPage); i++) {
                visiblePages.push(i);
            }

            if (currentPage > 5 && currentPage < lastPage) {
                visiblePages.push(currentPage);
            }

            if (lastPage > 5) {
                visiblePages.push(lastPage);
            }

            const uniqueSortedPages = [...new Set(visiblePages)].sort((a, b) => a - b);
            let prevPage = null;

            for (const page of uniqueSortedPages) {
                if (prevPage !== null && page - prevPage > 1) {
                    pagination.innerHTML += `
                        <li><span class="pager-number disabled">...</span></li>
                    `;
                }

                pagination.innerHTML += `
                    <li>
                        <a class="pager-number ${currentPage === page ? 'active' : ''}" 
                           href="#" data-page="${page}">${page}</a>
                    </li>
                `;

                prevPage = page;
            }

            pagination.innerHTML += `
                <li>
                    <a class="pager-next ${!data.next_page_url ? 'disabled' : ''}" 
                       href="#" data-page="${data.current_page + 1}">»</a>
                </li>
            `;

            
        }
    }

    document.addEventListener("click", function(e) {
        const link = e.target.closest('#pagination-links a');

        if (!link) return;
        if (link.classList.contains('disabled')) return;

        const page = link.getAttribute('data-page');
        if (!page) return;

        e.preventDefault();   // 🔥 browser GET stop
        // FilterJob(page);      // ✅ AJAX pagination
        FilterCandidates(page);

    });


    $(document).on('change', '#search-candidate-filter :input', function() {
        FilterCandidates(1);
    });

    $(document).ready(function() {
        FilterCandidates();
    });

    $(document).on('click', '.dropdown-page-count', function(e) {
        e.preventDefault();
        let perPage = $(this).data('value');
        $('#per_page').val(perPage);
        $('#per-page-value').text(perPage);
        FilterCandidates(1);
    });

    $(document).on('click', '.dropdown-order-by', function(e) {
        e.preventDefault();
        let orderBy = $(this).data('value');
        $('#order_by').val(orderBy);
        FilterCandidates(1);
    });
</script>
@endpush