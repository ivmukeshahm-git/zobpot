@push('css')
<style>
.client-section{
    /* background:#f8f9ff; */
    padding:60px 0;
}

/* slider container */
.logo-slider{
    overflow:hidden;
    position:relative;
    margin-top:50px;
    width:100%;
}

/* moving track */
.logo-track{
    display:flex;
    align-items:center;
    width:max-content;
    animation:scroll 35s linear infinite;
    will-change:transform;
}

.logo-slider:hover .logo-track{
    animation-play-state:paused;
}

/* card design same size */
.logo-card{
    background:#fff;
    border-radius:14px;
    padding:20px;
    margin:0 18px;
    display:flex;
    align-items:center;
    justify-content:center;
    height:140px;
    width:220px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    transition:.4s;
    border:1px solid #eee;
    flex-shrink:0;
}

/* image same width height */
.logo-card img{
    width:160px;
    height:80px;
    object-fit:contain;
    filter:grayscale(100%);
    transition:.4s;
}

/* hover effect */
.logo-card:hover{
    transform:translateY(-8px);
    border:1px solid #242a62;
    box-shadow:0 12px 25px rgba(36,42,98,0.25);
}
.logo-card:hover img{
    filter:grayscale(0%);
    transform:scale(1.05);
}

/* animation */
@keyframes scroll{
    0%{transform:translateX(0);}
    100%{transform:translateX(-50%);}
}

/* mobile */
@media(max-width:768px){
    .logo-card{
        width:160px;
        height:100px;
    }
    .logo-card img{
        width:120px;
        height:60px;
    }
}
</style>
    <style>
        @media only screen and (min-width: 768px) {
            .banner-hero .block-banner .form-find {
                display: flex !important;
            }
        }

        .job-type-select {
            border: 1px solid #e0e0e0;
            border-radius: 13px;
            box-shadow: 12px 12px 5px #eee;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .job-type-select:hover {
            transform: scale(1.02);
            box-shadow: 0 0 10px rgba(36, 42, 98, 0.15);
        }

        .select-job {
            border: 2px solid #242a62;
        }

        #NonSkilledCategoryScreen {
            display: none;
        }
         .item-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: #fff;
            border: 1px solid #e6e6e6;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .item-logo:hover {
            border-color: #00a8ff;
            box-shadow: 0 6px 15px rgba(0, 168, 255, 0.2);
            transform: translateY(-4px);
        }

        .image-left img {
            display: block;
            max-width: 40px;
            height: auto;
        }

        .text-info-right h4 {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            color: #333;
        }

        .text-info-right p {
            font-size: 13px;
            margin: 2px 0 0;
            color: #666;
        }

        .hover-up {
            transition: transform 0.3s ease;
        }

        .hover-up:hover {
            transform: translateY(-6px);
        }

        #loadMoreBtn {
            background-color: #00a8ff;
            border: none;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        #loadMoreBtn:hover {
            background-color: #0086cc;
        }
    </style>
<style>
/* Job Cards Styling - Simple & Attractive */
.job-card-simple-attractive {
    background: #FFFFFF !important;
    border-radius: 16px !important;
    padding: 25px !important;
    margin-bottom: 24px !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    border: 1px solid #242a65 !important;
    transition: all 0.3s ease !important;
    cursor: pointer !important;
    height: 390px !important;
    display: flex !important;
    flex-direction: column !important;
    position: relative !important;
    overflow: hidden !important;
}

.job-card-simple-attractive:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 12px 35px rgba(36, 42, 101, 0.15) !important;
    border-color: #242a65 !important;
}

/* Job Title */
.job-title-simple-attractive {
    font-size: 18px !important;
    font-weight: 700 !important;
    color: #242a65 !important;
    margin-bottom: 15px !important;
    line-height: 1.4 !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    min-height: 50px !important;
}

.job-title-simple-attractive a {
    color: inherit !important;
    text-decoration: none !important;
    transition: color 0.3s ease !important;
}

.job-title-simple-attractive a:hover {
    color: #f36825 !important;
}

/* Work Type & Time */
.job-meta-simple-attractive {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    margin-bottom: 15px !important;
    flex-wrap: wrap !important;
    gap: 8px !important;
}

.work-type-simple-attractive {
    background: #f36825 !important;
    color: white !important;
    padding: 6px 12px !important;
    border-radius: 20px !important;
    font-size: 12px !important;
    font-weight: 600 !important;
}

.job-time-simple-attractive {
    font-size: 12px !important;
    color: #666 !important;
    font-weight: 500 !important;
}

/* Location */
.job-location-simple-attractive {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    font-size: 14px !important;
    color: #666 !important;
    margin-bottom: 20px !important;
    padding: 12px !important;
    background: #f8faff !important;
    border-radius: 12px !important;
}

.job-location-simple-attractive i {
    color: #242a65 !important;
    flex-shrink: 0 !important;
}

.job-location-simple-attractive span {
    display: block !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    line-height: 1.4 !important;
    max-width: 100% !important;
    word-break: normal !important;
}

/* Job Details Grid */
.job-details-simple-attractive {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    gap: 12px !important;
    margin-bottom: 20px !important;
    flex: 1 !important;
}

.job-detail-simple-item {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    font-size: 13px !important;
    color: #555 !important;
}

.job-detail-simple-item i {
    color: #242a65 !important;
    width: 16px !important;
    flex-shrink: 0 !important;
}

/* Footer */
.job-footer-simple-attractive {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    margin-top: auto !important;
    padding-top: 15px !important;
    border-top: 1px solid #f0f0f0 !important;
    flex-shrink: 0 !important;
}

.view-job-btn-simple-attractive {
    background: #242a65 !important;
    color: white !important;
    text-decoration: none !important;
    padding: 8px 20px !important;
    border-radius: 8px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
    display: inline-block !important;
}

.view-job-btn-simple-attractive:hover {
    background: #f36825 !important;
    color: white !important;
    transform: translateY(-1px) !important;
}

.job-salary-simple-attractive {
    font-size: 14px !important;
    font-weight: 700 !important;
    color: #242a65 !important;
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

.job-card-simple-attractive {
    animation: fadeInUp 0.5s ease !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .job-card-simple-attractive {
        padding: 20px !important;
        margin-bottom: 10px !important;
        height: 490px !important;
    }
    
    .job-details-simple-attractive {
        grid-template-columns: 1fr !important;
        gap: 8px !important;
    }
    
    .job-footer-simple-attractive {
        flex-direction: column !important;
        gap: 10px !important;
        align-items: stretch !important;
    }
    
    .view-job-btn-simple-attractive {
        text-align: center !important;
    }
    
    .job-title-simple-attractive {
        font-size: 16px !important;
        min-height: 44px !important;
    }
}
</style>
@endpush


@extends('website.layout.layout')
@section('website-content')
    <script>
        page_active_id = "Home";
    </script>

    <main class="main">
        <div class="bg-homepage1"></div>
        <section class="section-box">
            <div class="banner-hero hero-1">
                <div class="banner-inner">
                    <div class="row">
                        <div class="col-xl-8 col-lg-12">
                            <div class="block-banner">
                                <h1 class="heading-banner wow animate__animated animate__fadeInUp">Find Your Dream Job with
                                    <span class="color-brand-2">Zobpot</span><br class="d-none d-lg-block">
                                </h1>
                                <div class="banner-description mt-20 wow animate__animated animate__fadeInUp"
                                    data-wow-delay=".1s">Explore thousands of career opportunities across the industrial and corporate sectors of India.<br
                                        class="d-none d-lg-block">  Over 2M job seekers trust our website as<br
                                        class="d-none d-lg-block">most genuine and supportive in terms of job searching and placements. whether you’re a fresher or a professional, just grab your perfect career opportunity with us.</div>
                        
                                <div class="col-lg-12 col-sm-12 d-flex justify-content-center mt-20">
                                    <img class="img-job-1" alt="jobBox"
                                        src="{{ asset('assets/imgs/page/homepage1/startup.png') }}" width="270">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-12 d-none d-xl-block col-md-6">
                            <div class="banner-imgs">
                                <div class="block-1 shape-1"><img class="img-responsive" style="max-width:60%;" alt="jobBox"
                                        src="{{ asset('assets/imgs/page/homepage1/gemini-2.5-flash-image-preview (nano-banana)_plaese_add_indian_yo.png') }}"></div>
                                <div class="block-2 shape-2"><img class="img-responsive" alt="jobBox"
                                        src="{{ asset('assets/imgs/page/homepage1/banner2.png') }}"></div>
                                <div class="block-3 shape-3"><img class="img-responsive" alt="jobBox"
                                        src="{{ asset('assets/imgs/page/homepage1/icon-top-banner.png') }}"></div>
                                <div class="block-4 shape-3"><img class="img-responsive" alt="jobBox"
                                        src="{{ asset('assets/imgs/page/homepage1/icon-bottom-banner.png') }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <div class="mt-100"></div>
         <section class="section-box mt-80">
            <div class="section-box wow animate__animated animate__fadeIn">
                <div class="container">
                    <div class="text-center">
                        <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">Search by categorys</h2>
                        <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">Find the job
                            that&rsquo;s perfect for you. about 800+ new jobs everyday</p>

                        <!-- Skill Type Selection Boxes -->
                        <div class="row justify-content-center mt-4 wow animate__animated animate__fadeInUp"
                            data-wow-delay="0.2s">



                            <!-- Skilled Box -->
                            <div class="col-lg-3 col-md-4 col-6 mb-3">
                                <div class="job-type-select select-job text-center" id="skill"
                                    onclick="SelectJobType('Skilled')">
                                    <div class="row align-items-center">
                                        <div class="col-lg-3 col-md-3 col-4">
                                            <img src="{{ asset('assets/imgs/skill.png') }}" alt="Skilled"
                                                style="max-width: 100%;">
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-8">
                                            <h5 class="mb-0"><b>Skilled</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--UnSkilled Box -->
                            <div class="col-lg-3 col-md-4 col-6 mb-3">
                                <div class="job-type-select  text-center" id="noneskill"
                                    onclick="SelectJobType('Non-Skilled')">
                                    <div class="row align-items-center">
                                        <div class="col-lg-3 col-md-3 col-4">
                                            <img src="{{ asset('assets/imgs/noneskill.png') }}" alt="UnSkilled"
                                                style="max-width: 100%;">
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-8">
                                            <h5 class="mb-0"><b>UnSkilled</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                    <div id="SkilledCategoryScreen">
                        <div class="row mt-50">
                            @php $skillCount = 0; @endphp
                            @foreach ($CategoryData as $category)
                                @if ($category->preference_type == 1)
                                    @php $skillCount++; @endphp
                                    <div class="col-lg-3 col-md-3 col-12 mb-3 hover-up category-item-skill"
                                        style="display: {{ $skillCount <= 12 ? 'block' : 'none' }};">
                                        <a href="javascript:void(0);"
                                            onclick="FilterJobByCategory({{ $category->category_id }})">
                                            <div class="item-logo">
                                                <div class="image-left">
                                                    <img alt="{{ $category->category_nm }}"
                                                        src="{{ asset('uploads/category_img/' . ($category->image ?? 'default.png')) }}"
                                                        style="max-width: 40px;">
                                                </div>
                                                <div class="text-info-right">
                                                    <h4>{{ $category->category_nm }}</h4>
                                                    {{-- <p class="font-xs">{{ $category->totalJob ?? 0 }} <span>Jobs Available</span></p> --}}
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        @if ($skillCount > 12)
                            <div class="text-center mt-4">
                                <button id="loadMoreBtnSkill" class="btn btn-default font-sm">View More</button>
                            </div>
                        @endif
                    </div>

                    <div id="NonSkilledCategoryScreen">
                        <div class="row mt-50">
                            @php $nonSkillCount = 0; @endphp
                            @foreach ($CategoryData as $category)
                                @if ($category->preference_type == 2)
                                    @php $nonSkillCount++; @endphp
                                    <div class="col-lg-3 col-md-3 col-12 mb-3 hover-up category-item-nonskill"
                                        style="display: {{ $nonSkillCount <= 12 ? 'block' : 'none' }};">
                                        <a href="javascript:void(0);"
                                            onclick="FilterJobByCategory({{ $category->category_id }})">
                                            <div class="item-logo">
                                                <div class="image-left">
                                                    <img alt="{{ $category->category_nm }}"
                                                        src="{{ asset('uploads/category_img/' . ($category->image ?? 'default.png')) }}"
                                                        style="max-width: 40px;">
                                                </div>
                                                <div class="text-info-right">
                                                    <h4>{{ $category->category_nm }}</h4>
                                                    {{-- <p class="font-xs">{{ $category->totalJob ?? 0 }} <span>Jobs
                                                            Available</span>
                                                        </p> --}}
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>

 @if ($nonSkillCount > 12)
                        <div class="text-center mt-4">
                            <button id="loadMoreBtnNonSkill" class="btn btn-default font-sm">View More</button>
                        </div>
                          @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- @if ($adBanner)
            <div class="section-box mb-30">
                <div class="container">
                    <a href="{{ $adBanner->ad_link }}" target="_blank">
                        <img src="{{ asset('uploads/ad_banner_img/' . $adBanner->img_nm) }}" alt="img">
                    </a>
                </div>
            </div>
        @endif -->

        @if (!$jobData->isEmpty())
            <section class="section-box mt-50">
                <div class="container">
                    <div class="text-center">
                        <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">Recently Posted jobs</h2>
                        <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">Search and
                            connect with the right company faster. </p>
                    </div>
                    <div class="mt-70">
                        <div class="tab-content" id="myTabContent-1">
                            <div class="tab-pane fade show active" id="tab-job-1" role="tabpanel"
                                aria-labelledby="tab-job-1">
                                <!-- <div class="row">
                                    @foreach ($jobData as $row)
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <a href="{{ route('job-detail', ['job_id' => $row->job_id]) }}">
                                                <div class="card-grid-2 hover-up">
                                                    <div class="card-block-info mt-20">
                                                        <a href="{{ route('job-detail', ['job_id' => $row->job_id]) }}" class="card-block-info d-block text-decoration-none">
                                                            <h6>{{ $row->job_title }}</h6>
                                                            <div class="mt-5">
                                                                <span class="card-briefcase">{{ $row->work_type_name }}</span>
                                                                <span class="card-time">{{ \Carbon\Carbon::parse($row->datetime)->diffForHumans() }}</span>
                                                            </div>
                                                            <p class="font-sm color-text-paragraph mt-15 mb-0">
                                                                <i class="fa fa-map-marker"></i>&nbsp;{{ $row->company_address }}
                                                            </p>
                                                        </a>

                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div> -->
                                <div class="row">
                                    @foreach ($jobData as $row)
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="job-card-simple-attractive" onclick="window.location.href='{{ route('job-detail', ['job_id' => $row->job_id]) }}'">
                                                <!-- Job Title -->
                                                <h5 class="job-title-simple-attractive">
                                                    <a href="{{ route('job-detail', ['job_id' => $row->job_id]) }}">{{ $row->job_title }}</a>
                                                </h5>

                                                <!-- Work Type & Time -->
                                                <div class="job-meta-simple-attractive">
                                                    <span class="work-type-simple-attractive">{{ $row->work_type_name }}</span>
                                                    <span class="job-time-simple-attractive">{{ \Carbon\Carbon::parse($row->datetime)->diffForHumans() }}</span>
                                                </div>

                                                <!-- Location -->
                                                <div class="job-location-simple-attractive">
                                                    <i class="fa fa-map-marker"></i>
                                                    <span>{{ $row->company_address }}</span>
                                                </div>

                                                <!-- Job Details -->
                                                <div class="job-details-simple-attractive">
                                                    <div class="job-detail-simple-item">
                                                        <i class="fa fa-briefcase"></i>
                                                        <span>{{ $row->job_type_name ?? 'Full Time' }}</span>
                                                    </div>
                                                    <div class="job-detail-simple-item">
                                                        <i class="fa fa-users"></i>
                                                        <span>{{ $row->number_of_openings ?? 1 }} Vacancy</span>
                                                    </div>
                                                    <div class="job-detail-simple-item">
                                                        <i class="fa fa-graduation-cap"></i>
                                                        <span>{{ $row->qualification_nm }}</span>
                                                    </div>
                                                    <div class="job-detail-simple-item">
                                                        <i class="fa fa-venus-mars"></i>
                                                        <span>{{ $row->gender }}</span>
                                                    </div>
                                                </div>

                                                <!-- Footer -->
                                                <div class="job-footer-simple-attractive">
                                                    @if($row->salary_budget)
                                                    <div class="job-salary-simple-attractive d-flex align-items-center">
                                                         <i class="fi-rr-money me-1"></i>{{$row->salary_budget}}
                                                    </div>
                                                    @else
                                                    <div></div>
                                                    @endif
                                                    <a href="{{ route('job-detail', ['job_id' => $row->job_id]) }}" class="view-job-btn-simple-attractive">
                                                        View Job
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section class="section-box overflow-visible mt-100 mb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="box-image-job">
                            <img class="img-job-2" alt="jobBox"
                                src="{{ asset('assets/imgs/page/homepage1/controlcard.png') }}">
                            <figure class="wow animate__animated animate__fadeIn"><img alt="jobBox"
                                    src="{{ asset('assets/imgs/about-us-home.png') }}"></figure>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="content-job-inner"><span class="color-text-mutted text-32">About us</span>
                            <h2 class="text-42 wow animate__animated animate__fadeInUp">About <span
                                    class="color-brand-2">Zobpot</span></h2>
                            <div class="mt-40 pr-50 text-md-lh28 wow animate__animated animate__fadeInUp about-desc">
                                @php
                                    echo $About->about_us;
                                @endphp
                            </div>
                            <div class="mt-40">
                                <div class="wow animate__animated animate__fadeInUp">
    
                                   @if(Auth::check() && Auth::user()->profile_type !== 'Company')
                                        <a class="btn btn-default" href="{{ route('job') }}">
                                            Search Jobs
                                        </a>
                                    @endif

                                    <a class="btn btn-link" href="{{ route('about') }}">
                                        Read More
                                    </a>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-box overflow-visible mt-50 mb-50 pt-40 pb-40" style="background: #f2682412;">
            <div class="container">
                <div class="row">
                    @foreach ($Achievement as $row)
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="text-center">
                                <h1 class="color-brand-2"><span class="count">{{ $row->count }}</span><span>K+</span>
                                </h1>
                                <h5 style="color: #252a62;">{{ $row->title }}</h5>
                                <p style="color: #252a62;" class="font-sm color-text-paragraph mt-10">
                                    {{ $row->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        @if (!$Blog->isEmpty())
            <!--<section class="section-box mt-50 mb-50">-->
            <!--    <div class="container">-->
            <!--        <div class="text-center">-->
            <!--            <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">News and Blog</h2>-->
            <!--            <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">Get the latest-->
            <!--                news,-->
            <!--                updates and tips</p>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    <div class="container">-->
            <!--        <div class="mt-50">-->
            <!--            <div class="box-swiper style-nav-top">-->
            <!--                <div class="swiper-container swiper-group-3 swiper">-->
            <!--                    <div class="swiper-wrapper pb-70 pt-5">-->
            <!--                        @foreach ($Blog as $row)-->
            <!--                            <div class="swiper-slide">-->
            <!--                                <div class="card-grid-3 hover-up wow animate__animated animate__fadeIn">-->
            <!--                                    <div class="text-center card-grid-3-image">-->
            <!--                                        <a href="{{ route('blog-detail', $row->id) }}">-->
            <!--                                            <figure><img alt="jobBox"-->
            <!--                                                    src="{{ asset('uploads/blog_img/' . $row->image) }}">-->
            <!--                                            </figure>-->
            <!--                                        </a>-->
            <!--                                    </div>-->
            <!--                                    <div class="card-block-info">-->
            <!--                                        <div class="tags mb-15"><a class="btn btn-tag"-->
            <!--                                                href="{{ route('blog-detail', $row->id) }}">Blog</a>-->
            <!--                                        </div>-->
            <!--                                        <h5>-->
            <!--                                            <a-->
            <!--                                                href="{{ route('blog-detail', $row->id) }}">{{ $row->title }}</a>-->
            <!--                                        </h5>-->
            <!--                                        <div class="card-2-bottom mt-20">-->
            <!--                                            <div class="row">-->
            <!--                                                <div class="col-lg-6 col-6">-->
            <!--                                                    <div class="d-flex"><img class="img-rounded"-->
            <!--                                                            src="{{ asset('assets/imgs/profile.png') }}">-->
            <!--                                                        <div class="info-right-img"><span-->
            <!--                                                                class="font-sm font-bold color-brand-1 op-70">Zobpot</span><br><span-->
            <!--                                                                class="font-xs color-text-paragraph-2">-->
            <!--                                                                {{ \Carbon\Carbon::parse($row->datetime)->format('d F') }}-->
            <!--                                                                {{ \Carbon\Carbon::parse($row->datetime)->format('Y') }}-->
            <!--                                                            </span></div>-->
            <!--                                                    </div>-->
            <!--                                                </div>-->
            <!--                                            </div>-->
            <!--                                        </div>-->
            <!--                                    </div>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                        @endforeach-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <div class="swiper-button-next"></div>-->
            <!--                <div class="swiper-button-prev"></div>-->
            <!--            </div>-->

            <!--        </div>-->
            <!--    </div>-->
            <!--</section>-->
        @endif
        
        
         {{-- <section class="section-box mt-50 mb-50">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">Our Valuable Clients</h2>
                    <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">Discover opportunities that fit you — only on Zobpot.</p>
                </div>
            </div>
            <div class="container">
                <div class="box-swiper mt-50">
                    <div class="swiper-container swiper-group-1 swiper-style-2 swiper">
                        <div class="swiper-wrapper pt-5">
                            <div class="swiper-slide">
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                
                                        <img src="{{ asset('assets/imgs/patner/partner1.png') }}" alt="patner-1" style="height: 115px;width: 100%;">
                                    
                                </div>
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                
                                        <img src="{{ asset('assets/imgs/patner/patner-5.jpg') }}" alt="patner-2" style="height: 115px;width: 100%;">
                                
                                </div>
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                
                                        <img src="{{ asset('assets/imgs/patner/partner3.png') }}" alt="patner-3" style="height: 115px;width: 100%;">
                                
                                </div>
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                
                                        <img src="{{ asset('assets/imgs/patner/partner4.png') }}" alt="patner-4" style="height: 115px;width: 100%;">
                                
                                </div>
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                        <img src="{{ asset('assets/imgs/patner/partner5.png') }}" alt="patner-5" style="height: 115px;width: 100%;">
                                </div>
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                        <img src="{{ asset('assets/imgs/patner/partner6.png') }}" alt="patner-6" style="height: 115px;width: 100%;">
                                </div>
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                        <img src="{{ asset('assets/imgs/patner/partner7.png') }}" alt="patner-7" style="height: 115px;width: 100%;">
                                </div>
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                        <img src="{{ asset('assets/imgs/patner/partner8.png') }}" alt="patner-8" style="height: 115px;width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-next swiper-button-next-1"></div>
                    <div class="swiper-button-prev swiper-button-prev-1"></div>
                </div>
            </div>
        </section> --}}
        
        <section class="section-box mt-50 mb-50 client-section">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-title mb-10">Our Valuable Clients</h2>
                    <p class="font-lg color-text-paragraph-2">
                        Discover opportunities that fit you — only on Zobpot.
                    </p>
                </div>
            </div>

            <!-- LOGO SLIDER -->
            <div class="logo-slider">
                <div class="logo-track">
                    @if (count($partner) > 0)
                        @foreach ($partner as $row)
                            <div class="logo-card">
                                <img src="{{ asset('uploads/partner_img/' . ($row->image ?? 'default.png')) }}" alt="{{ $row->name }}">
                            </div>
                        @endforeach

                        @foreach ($partner as $row)
                            <div class="logo-card" aria-hidden="true">
                                <img src="{{ asset('uploads/partner_img/' . ($row->image ?? 'default.png')) }}" alt="{{ $row->name }}">
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 text-center py-5">
                            <img src="{{ asset('assets/imgs/Empty.png') }}" alt="No Partners" style="max-width: 200px; opacity: 0.5;">
                            <h4 class="mt-4 color-text-paragraph-2">No Partners Available</h4>
                            <p class="font-md color-text-paragraph-2">We're currently building our network of valuable clients.</p>
                        </div>
                    @endif


                </div>
            </div>
        </section>



        <div id="pageLoader" style="display:none;">
            <div class="preloader d-flex align-items-center justify-content-center">
                <div class="preloader-inner position-relative">
                    <div class="text-center"><img src="{{ asset('assets/imgs/template/loading.gif') }}" alt="Loader">
                    </div>
                </div>
            </div>
        </div>


        <script src="{{ asset('assets/js/plugins/counterup.js') }}"></script>
    </main>


@endsection


@push('script')
    <script>
        window.addEventListener("pageshow", function () {
            const loader = document.getElementById("pageLoader");
            if (loader) {
                loader.style.display = "none";
            }
            sessionStorage.removeItem("loader_show");
        });
    </script>

    <script>
        // function FilterJobByCategory(id) {
        //     sessionStorage.setItem('job_category_id', id);

        //     window.location.href = "{{ route('job') }}";
        // }
        function FilterJobByCategory(id) {

            sessionStorage.setItem('job_category_id', id);

            // loader show
            sessionStorage.setItem("loader_show", "yes");

            document.getElementById("pageLoader").style.display = "flex";

            setTimeout(function () {
                window.location.href = "{{ route('job') }}?category=" + id;
            }, 400);
        }




        function FindJob() {
            var job_category = $("#home_job_category").val();
            var job_location = $("#home_job_location").val();
            var job_title = $("#home_job_title").val();


            // ✅ Store in sessionStorage
            sessionStorage.setItem('job_category', job_category);
            sessionStorage.setItem('job_location', job_location);
            sessionStorage.setItem('job_title', job_title);

            // ✅ Redirect to the job listing page
            window.location.href = "{{ route('job') }}";
        }

        function SelectJobType(type) {
            $('.job-type-select').removeClass('select-job');

            if (type === 'Non-Skilled') {
                $('#noneskill').addClass('select-job');
                document.getElementById("NonSkilledCategoryScreen").style.display = "block";
                document.getElementById("SkilledCategoryScreen").style.display = "none";
            } else if (type === 'Skilled') {
                $('#skill').addClass('select-job');
                document.getElementById("NonSkilledCategoryScreen").style.display = "none";
                document.getElementById("SkilledCategoryScreen").style.display = "block";
            }
        }
    </script>
@endpush
