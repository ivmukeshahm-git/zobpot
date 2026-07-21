@push('css')
    <style>
       @media only screen and (min-width: 768px) {
            .banner-hero .block-banner .form-find {
                display: flex !important;
            }
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
    <style>
/* Company Cards Styling - Same as Candidate Cards */
.company-card-attractive {
    background: #FFFFFF !important;
    border-radius: 16px !important;
    padding: 25px !important;
    margin-bottom: 24px !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    border: 1px solid #f0f0f0 !important;
    transition: all 0.3s ease !important;
    cursor: pointer !important;
    height: 320px !important;
    display: flex !important;
    flex-direction: column !important;
    position: relative !important;
    overflow: hidden !important;
    text-align: center !important;
}

.company-card-attractive:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 12px 35px rgba(36, 42, 101, 0.15) !important;
    border-color: #242a65 !important;
}

/* Company Logo */
.company-logo-attractive {
    width: 100px !important;
    height: 100px !important;
    border-radius: 16px !important;
    object-fit: cover !important;
    border: 3px solid #e9ecef !important;
    transition: all 0.3s ease !important;
    padding: 8px !important;
    background: #f8faff !important;
    margin: 0 auto 20px auto !important;
}

.company-card-attractive:hover .company-logo-attractive {
    border-color: #242a65 !important;
    transform: scale(1.05) !important;
}

/* Company Info */
.company-info-attractive {
    margin-bottom: 2px !important;
    flex: 1 !important;
}

.company-name-attractive {
    font-size: 20px !important;
    font-weight: 700 !important;
    color: #242a65 !important;
    margin-bottom: 12px !important;
    line-height: 1.3 !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    min-height: 48px !important;
}

.company-name-attractive a {
    color: inherit !important;
    text-decoration: none !important;
    transition: color 0.3s ease !important;
}

.company-name-attractive a:hover {
    color: #f36825 !important;
}

.company-location-attractive {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    font-size: 14px !important;
    color: #666 !important;
    margin-bottom: 8px !important;
}

.company-category-attractive {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    font-size: 13px !important;
    color: #f36825 !important;
    font-weight: 500 !important;
}

.company-location-attractive i {
    color: #242a65 !important;
    width: 16px !important;
}

/* Stats & Actions */
.company-stats-attractive {
    /* display: flex !important; */
    justify-content: space-between !important;
    align-items: center !important;
    margin-top: auto !important;
    padding-top: 10px !important;
    border-top: 1px solid #f0f0f0 !important;
    flex-shrink: 0 !important;
}

.job-count-badge-attractive {
    background: #f8faff !important;
    padding: 8px 16px !important;
    border-radius: 12px !important;
    text-align: center !important;
    border: 1px solid #e2e8ff !important;
}

.count-number-attractive {
    display: block !important;
    font-size: 20px !important;
    font-weight: 700 !important;
    color: #242a65 !important;
    line-height: 1 !important;
}

.count-text-attractive {
    display: block !important;
    font-size: 11px !important;
    color: #666 !important;
    font-weight: 500 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
}

.view-company-btn-attractive {
    background: #242a65 !important;
    color: white !important;
    text-decoration: none !important;
    padding: 10px 20px !important;
    border-radius: 8px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
    display: inline-block !important;
}

.view-company-btn-attractive:hover {
    background: #f36825 !important;
    color: white !important;
    transform: translateY(-2px) !important;
}

/* No Companies State */
.no-companies-state-attractive {
    text-align: center !important;
    padding: 60px 20px !important;
    background: #f8faff !important;
    border-radius: 16px !important;
    margin: 20px 0 !important;
    height: auto !important;
}

.no-company-icon-attractive {
    font-size: 64px !important;
    margin-bottom: 16px !important;
    opacity: 0.7 !important;
}

.no-companies-state-attractive h4 {
    font-size: 24px !important;
    color: #242a65 !important;
    margin-bottom: 8px !important;
    font-weight: 700 !important;
}

.no-companies-state-attractive p {
    color: #666 !important;
    font-size: 16px !important;
    margin: 0 !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .company-card-attractive {
        padding: 20px !important;
        margin-bottom: 16px !important;
        height: 300px !important;
    }
    
    .company-logo-attractive {
        width: 80px !important;
        height: 80px !important;
    }
    
    .company-stats-attractive {
        flex-direction: column !important;
        gap: 12px !important;
        align-items: stretch !important;
    }
    
    .view-company-btn-attractive {
        text-align: center !important;
    }
    
    .company-name-attractive {
        font-size: 18px !important;
        min-height: 44px !important;
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

.company-card-attractive {
    animation: fadeInUp 0.5s ease !important;
}
</style>
@endpush



@extends('website.layout.layout')
@section('website-content')
    <script>
        page_active_id = "Companies";
    </script>
    <main class="main">
        <form id="search-company-filter" onsubmit="return false;" method="POST">
            <section class="section-box-2">
                <div class="container">
                    <div class="banner-hero banner-single banner-single-bg">
                        <div class="block-banner text-center">
                            <h3 class="wow animate__animated animate__fadeInUp"><span
                                    class="color-brand-2">{{ $allCompanyCount }}+ Company</span> Available Now</h3>
                            <div class="font-sm color-text-paragraph-2 mt-10 wow animate__animated animate__fadeInUp"
                                data-wow-delay=".1s">Post your job in minutes, reach thousands instantly.Find the right talent,faster than ever</div>
                            <div class="form-find text-start mt-40 wow animate__animated animate__fadeInUp"
                                data-wow-delay=".2s">
                                <div class="box-industry">
                                    <select class="form-input mr-10 select-active input-industry" id="job_category"
                                        name="job_category">
                                        <option value="" selected>Industry</option>
                                        @foreach ($CategoryData as $row)
                                            <option value="{{ $row->category_id }}">{{ $row->category_nm }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <select class="form-input mr-10 select-active" id="job_location" name="job_location">
                                    <option value="">Location</option>
                                    @foreach ($locations as $citys)
                                        <option value="{{ $citys->city_id }}">{{ $citys->location }}</option>
                                    @endforeach
                                </select>
                                <input class="form-input input-keysearch mr-10" type="text"
                                    placeholder="Your keyword... " id="job_title" name="job_title">
                                <button class="btn btn-default btn-find font-sm" type="button"
                                    onclick="FilterCompany(1)">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section-box mt-30">
                <div class="container">
                    <div class="row flex-row-reverse">
                        <div class="col-lg-9 col-md-12 col-sm-12 col-12 float-right">
                            <div class="content-page">
                                
                                <!-- <div class="row" id="company-list">
                                    @forelse ($CompanyData as $row)
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                            <div class="card-grid-1 hover-up wow animate__animated animate__fadeIn">
                                                <div class="image-box"><a
                                                        href="{{ route('company-profile-detail', ['id' => $row->id]) }}"><img
                                                            style="max-width: 130px!important;"
                                                            src="{{ asset('uploads/profile/' . ($row->profile_img ?? 'profile.png')) }}"
                                                            alt="jobBox"></a></div>
                                                <div class="info-text mt-10">
                                                    <h5 class="font-bold"><a
                                                            href="{{ route('company-profile-detail', ['id' => $row->id]) }}">{{ $row->name }}</a>
                                                    </h5>
                                                    <span
                                                        class="card-location">{{ $row->city_nm . ' ' . $row->state_name }}</span>
                                                    <div class="mt-30"><a class="btn btn-grey-big" href="{{ route('company-profile-detail', ['id' => $row->id]) }}"><span>{{ $row->JobCount }}</span><span>
                                                                Jobs Open</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"
                                            style="text-align:center;">
                                            <h5 aria-current=""style="padding: 55px;background: #eee;font-size: 29px;font-weight: 800;color: #666666;">
                                                Company Not Found</h5>
                                        </div>
                                    @endforelse
                                </div> -->
                                <div class="row" id="company-list">
                                    
                                    @forelse ($CompanyData as $row)
                                    
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                            <div class="company-card-attractive" onclick="window.location.href='{{ route('company-profile-detail', ['id' => $row->id]) }}'">
                                                <!-- Company Logo -->
                                                <div class="image-box">
                                                    <a href="{{ route('company-profile-detail', ['id' => $row->id]) }}">
                                                        <img class="company-logo-attractive"
                                                        {{-- src="{{ $row->profile_img 
                                                                ? asset('uploads/profile/' . $row->profile_img)
                                                                : asset('uploads/profile/profile.png') }}" --}}
                                                                src="{{ 
                                                                    (!empty($user->profile_img) && file_exists(public_path('uploads/profile/'.$user->profile_img)))
                                                                        ? asset('uploads/profile/'.$user->profile_img)
                                                                        : asset('uploads/profile/candidate.jpg')
                                                                }}"
                                                        alt="{{ $row->name }}">

                                                    </a>
                                                </div>

                                                <!-- Company Info -->
                                                <div class="company-info-attractive">
                                                    <h5 class="company-name-attractive">
                                                        <a href="{{ route('company-profile-detail', ['id' => $row->id]) }}">{{ $row->name }}</a>
                                                    </h5>
                                                    
                                                    <div class="company-location-attractive">
                                                        <i class="fa fa-map-marker"></i>
                                                        <span>{{ $row->city_nm . ' ' . $row->state_name }}</span>
                                                    </div>

                                                    @if(isset($row->category_nm) && $row->category_nm)
                                                    <div class="company-category-attractive">
                                                        <i class="fa fa-briefcase"></i>
                                                        <span>{{ $row->category_nm }}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                                    <div class="job-count-badge-attractive">
                                                        <span class="count-number-attractive">{{ $row->JobCount ?? 0 }}</span>
                                                        <span class="count-text-attractive">Open Jobs</span>
                                                    </div>
                                                
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="no-companies-state-attractive">
                                                <div class="no-company-icon-attractive">🏢</div>
                                                <h4>No Companies Found</h4>
                                                <p>We couldn't find any companies matching your criteria</p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="paginations mt-30">
                                <ul class="pager" id="pagination-links">
                                    {{-- Previous Page Link --}}
                                    <li>
                                        <a class="pager-prev {{ $CompanyData->onFirstPage() ? 'disabled' : '' }}"
                                            href="{{ $CompanyData->previousPageUrl() ?? '#' }}">
                                        </a>
                                    </li>

                                    {{-- Page Numbers --}}
                                    @for ($i = 1; $i <= $CompanyData->lastPage(); $i++)
                                        <li>
                                            <a class="pager-number {{ $CompanyData->currentPage() == $i ? 'active' : '' }}"
                                                href="{{ $CompanyData->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    {{-- Next Page Link --}}
                                    <li>
                                        <a class="pager-next {{ !$CompanyData->hasMorePages() ? 'disabled' : '' }}"
                                            href="{{ $CompanyData->nextPageUrl() ?? '#' }}">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                            <div class="sidebar-shadow none-shadow mb-30">
                                <div class="sidebar-filters">
                                    <div class="filter-block head-border mb-30">
                                        <h5>Advance Filter <a class="link-reset" href="javascript:void(0)"  onclick="location.reload();">Reset</a></h5>
                                    </div>

                                    <div class="filter-block mb-20">
                                        <h5 class="medium-heading mb-15">Industry</h5>
                                        <div class="form-group">
                                            <ul class="list-checkbox">
                                                @php
                                                    // $TotalCategoryJob = $JobCategoryCount->sum('TotalJob');
                                                    // @dd($JobCategoryCount);
                                                    $TotalCategoryCompany = DB::table('users')
                                                    ->where('role', 'User')
                                                    ->where('profile_type', 'Company')
                                                    ->where('active_status', 1)
                                                    ->count();

                                                @endphp

                                                <!-- All Category Option -->
                                                <li>
                                                    <label class="cb-container">
                                                        <input type="checkbox" id="select-all-categories"
                                                            class="category-checkbox">
                                                        <span class="text-small">All</span>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <span class="number-item">{{ $allCompanyCount  }}</span>
                                                </li>

                                                <!-- Categories -->
                                                @foreach ($JobCategoryCount as $row)
                                                    <li>
                                                        <label class="cb-container">
                                                            <input type="checkbox" name="category_id[]"
                                                                value="{{ $row->category_id }}"
                                                                class="category-checkbox single-category">
                                                            <span class="text-small">{{ $row->category_nm }}</span>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <span class="number-item">{{ $row->TotalCompany }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="filter-block mb-30">
                                        <h5 class="medium-heading mb-10">Job Type</h5>
                                        <div class="form-group">
                                            <ul class="list-checkbox">
                                                @foreach ($jobTypeCounts as $row)
                                                    <li>
                                                        <label class="cb-container">
                                                            <input type="checkbox" class="job-type-checkbox"
                                                                name="job_type_id[]"
                                                                value="{{ $row->job_type_id }}"><span
                                                                class="text-small">{{ $row->type_name }}</span><span
                                                                class="checkmark"></span>
                                                        </label><span class="number-item">{{ $row->total_jobs }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="filter-block mb-30">
                                        <h5 class="medium-heading mb-10">Job Level</h5>
                                        <div class="form-group">
                                            <ul class="list-checkbox">
                                                @foreach ($jobLevelCounts as $row)
                                                    <li>
                                                        <label class="cb-container">
                                                            <input type="checkbox" class="job-level-checkbox"
                                                                name="job_level_id[]"
                                                                value="{{ $row->job_level_id }}"><span
                                                                class="text-small">{{ $row->job_level_name }}</span><span
                                                                class="checkmark"></span>
                                                        </label><span class="number-item">{{ $row->total_jobs }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="filter-block mb-30">
                                        <h5 class="medium-heading mb-10">Work Type</h5>
                                        <div class="form-group">
                                            <ul class="list-checkbox">
                                                @foreach ($workTypeCounts as $row)
                                                    <li>
                                                        <label class="cb-container">
                                                            <input type="checkbox" class="work-type-checkbox"
                                                                name="work_type_id[]"
                                                                value="{{ $row->work_type_id }}"><span
                                                                class="text-small">{{ $row->work_type_name }}</span><span
                                                                class="checkmark"></span>
                                                        </label><span class="number-item">{{ $row->total_jobs }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="filter-block mb-30">
                                        <h5 class="medium-heading mb-10">Experience Level</h5>
                                        <div class="form-group">
                                            <ul class="list-checkbox">
                                                @foreach ($experienceCounts as $row)
                                                    <li>
                                                        <label class="cb-container">
                                                            <input type="checkbox" class="experience-level-checkbox"
                                                                name="experience_req_id[]"
                                                                value="{{ $row->experience_req_id }}"><span
                                                                class="text-small">{{ $row->experience_name }}</span><span
                                                                class="checkmark"></span>
                                                        </label><span class="number-item">{{ $row->total_jobs }}</span>
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
            </section>
            @if (!$Blog->isEmpty())
                <!--<section class="section-box mt-50 mb-50">-->
                <!--    <div class="container">-->
                <!--        <div class="text-start">-->
                <!--            <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">News and Blog</h2>-->
                <!--            <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">Get the-->
                <!--                latest-->
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
                <!--                                    <div class="text-center card-grid-3-image"><a-->
                <!--                                            href="{{ route('blog-detail', $row->id) }}">-->
                <!--                                            <figure><img alt="jobBox"-->
                <!--                                                    src="{{ asset('uploads/blog_img/' . $row->image) }}">-->
                <!--                                            </figure>-->
                <!--                                        </a>-->
                <!--                                    </div>-->
                <!--                                    <div class="card-block-info">-->
                <!--                                        <div class="tags mb-15">-->
                <!--                                            <a class="btn btn-tag" href="{{ route('blog-detail', $row->id) }}">Blog</a>-->
                <!--                                        </div>-->
                <!--                                        <h5>-->
                <!--                                            <a href="{{ route('blog-detail', $row->id) }}">{{ $row->title }}</a>-->
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
        </form>
    </main>
@endsection


@push('script')
    <script>
        function FilterCompany(page = 1) {
            let form = $("#search-company-filter");
            let formData = form.serialize() + `&page=${page}`; // add page number for pagination

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                }
            });

            LoaderShow();


            $.ajax({
                type: "POST",
                url: "{{ route('filter-companies') }}", // Laravel route for company filtering
                data: formData,
                success: function(response) {
                    LoaderHide();
                    if (response.status == 1) {
                        let data = response.data;

                        let showingText = '';
                        let from = data.from;
                        let to = data.to;
                        let total = data.total;

                        if (total > 0 && from && to) {
                            showingText = `
                        <span class='text-small text-showing'>
                            Showing <strong>${from}-${to}</strong> of <strong>${total}</strong> Companies
                        </span>`;
                        } else {
                            showingText = `
                        <span class='text-small text-showing'>
                            No companies found
                        </span>`;
                        }

                        $('#Company-count-text').html(showingText);

                        renderPagination(data); // reuse your pagination
                        renderCompanies(data); // ✅ fix here

                    } else {
                        ErrorMsg(response.message);
                    }
                },
                error: function(xhr) {
                    LoaderHide();
                }
            });
        }


        $(document).on('click', '.category-checkbox', function() {
            FilterCompany();
        });

        $(document).on('click', '.job-type-checkbox', function() {
            FilterCompany();
        });

        $(document).on('click', '.job-level-checkbox', function() {
            FilterCompany();
        });

        $(document).on('click', '.work-type-checkbox', function() {
            FilterCompany();
        });

        $(document).on('click', '.experience-level-checkbox', function() {
            FilterCompany();
        });

        $(document).on('click', '.job-posted-checkbox', function() {
            FilterCompany();
        });

        $(document).on('click', '.dropdown-page-count', function(e) {
            e.preventDefault();

            let perPage = $(this).data('value'); // get selected value

            $('#per_page').val(perPage); // set it in hidden input
            $('#per-page-value').text(perPage); // update button text

            FilterCompany(); // call your filter function
        });

        $(document).on('click', '.dropdown-order-by', function(e) {
            e.preventDefault();

            let perPage = $(this).data('value'); // get selected value

            $('#order_by').val(perPage); // set it in hidden input

            FilterCompany(); // call your filter function
        });


    
        function renderCompanies(data) {
            const COMPANY_DETAIL_URL = "{{ url('company-profile-detail') }}/:id";
            const companyList = document.getElementById('company-list');
            companyList.innerHTML = '';

            if (!data.data || data.data.length === 0) {
                companyList.innerHTML = `
                    <div class="col-12">
                        <div class="no-companies-state-attractive">
                            <div class="no-company-icon-attractive">🏢</div>
                            <h4>No Companies Found</h4>
                            <p>We couldn't find any companies matching your criteria</p>
                        </div>
                    </div>`;
                return;
            }

            data.data.forEach(row => {
                const profileImg = row.profile_img
                    ? "{{ asset('uploads/profile') }}/" + row.profile_img
                    : "{{ asset('uploads/profile/profile.png') }}";

                const companyUrl = COMPANY_DETAIL_URL.replace(':id', row.id);
                const location = `${row.city_nm ?? ''} ${row.state_name ?? ''}`.trim();

                companyList.innerHTML += `
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="company-card-attractive"
                            onclick="window.location.href='${companyUrl}'">

                            <div class="image-box">
                                <img class="company-logo-attractive"
                                    src="${profileImg}"
                                    alt="${row.name}">
                            </div>

                            <div class="company-info-attractive">
                                <h5 class="company-name-attractive">
                                    ${row.name}
                                </h5>

                                <div class="company-location-attractive">
                                    <i class="fa fa-map-marker"></i>
                                    <span>${location}</span>
                                </div>
                            </div>

                            <div class="job-count-badge-attractive">
                                <span class="count-number-attractive">${row.JobCount ?? 0}</span>
                                <span class="count-text-attractive">Open Jobs</span>
                            </div>

                        </div>
                    </div>
                `;
            });
        }





        function renderPagination(data) {
            const pagination = document.getElementById('pagination-links');
            pagination.innerHTML = '';

            // Previous button
            if (data.total && data.total > 0) {

                // Previous button
                pagination.innerHTML += `
            <li>
                <a class="pager-prev ${data.current_page === 1 ? 'disabled' : ''}" 
                   href="#" data-page="${data.current_page - 1}">«</a>
            </li>
        `;

                // Page number buttons
                for (let i = 1; i <= data.last_page; i++) {
                    pagination.innerHTML += `
                <li>
                    <a class="pager-number ${data.current_page === i ? 'active' : ''}" 
                       href="#" data-page="${i}">${i}</a>
                </li>
            `;
                }

                // Next button
                pagination.innerHTML += `
            <li>
                <a class="pager-next ${!data.next_page_url ? 'disabled' : ''}" 
                   href="#" data-page="${data.current_page + 1}">»</a>
            </li>
        `;

            } else {
                // No results / pagination to show
                pagination.innerHTML = '';
            }
        }

        
       
        $(document).on('click', '.dropdown-page-count', function(e) {
            e.preventDefault();

            let perPage = $(this).data('value'); // get selected value

            $('#per_page').val(perPage); // set it in hidden input
            $('#per-page-value').text(perPage); // update button text

            FilterCompany(); // call your filter function
        });

        $(document).on('click', '.dropdown-order-by', function(e) {
            e.preventDefault();

            let perPage = $(this).data('value'); // get selected value

            $('#order_by').val(perPage); // set it in hidden input

            FilterCompany(); // call your filter function
        });
        
        
    </script>
@endpush
