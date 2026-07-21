  @php
      $Setting = App\Models\Setting::where('id', 1)->first();
  @endphp
@push('css')
    <style>
        .job-notofication {
            border: 1px solid #d4d4d4;
            padding: 14px;
            border-radius: 11px;
            box-shadow: 5px 5px 12px #eee;
        }

        .of-txt-6 {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 6;
            -webkit-box-orient: vertical;
        }
    </style>
    <style>
    .job-desc {
        display: -webkit-box;
        -webkit-line-clamp: 3;   /* 👈 jetla lines joiye etla */
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .job-desc.expanded {
        -webkit-line-clamp: unset;
    }

    .read-more-btn {
        color: #242a65;
        font-weight: 600;
        cursor: pointer;
        font-size: 14px;
    }
    </style>

@endpush


@extends('website.layout.layout')
@section('website-content')
    <main class="main">
        <section class="section-box-2">
            <div class="container">
                <div class="banner-hero banner-image-single">
                     
                    <img src="{{asset('uploads/profile/cover.jpeg') }}" alt="Cover Image">
                    
                    </div>
                <div class="box-company-profile" @if($userData->cover_img == "") style="margin-top:30px;"  @endif>
                    <!-- <div class="image-compay"><img src="{{ asset('uploads/profile/' . ($userData->profile_img ?? 'profile.png')) }}" style="width: 100px;height: 100px;"></div> -->
                    <div class="row mt-10">
                        <div class="col-lg-8 col-md-12">
                            <h5 class="f-18">{{ $userData->name }} <span class="card-location font-regular ml-20" style="font-size: 14px!important;">{{ $userData->address }}</span></h5>
                            <p class="mt-5 font-md color-text-paragraph-2 mb-15">{{ $userData->designation }}</p>
                            {{-- <p class="mt-0 mb-1 font-md color-text-paragraph-2"
                                style="font-size: 14px !important;font-weight: 600;"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp; Phone: {{ $userData->contact_no }}</p>
                            <p class="mt-0 mb-1 font-md color-text-paragraph-2"
                                style="font-size: 14px !important;font-weight: 600;"><i class="fa fa-envelope"
                                    aria-hidden="true"></i>&nbsp; Email: {{ $userData->email }}</p> --}}
                                    <p class="mt-0 mb-1 font-md color-text-paragraph-2"
                                style="font-size: 14px !important;font-weight: 600;"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp; Phone: {{ $Setting ? $Setting->contact_2 : '' }}</p>
                            <p class="mt-0 mb-1 font-md color-text-paragraph-2"
                                style="font-size: 14px !important;font-weight: 600;"><i class="fa fa-envelope"
                                    aria-hidden="true"></i>&nbsp; Email: {{ $Setting ? $Setting->email_1 : '' }}</p>
                        </div>
                        {{-- <div class="col-lg-4 col-md-12 text-lg-end"><a class="btn btn-call-icon btn-apply btn-apply-big" href="{{ route('contact') }}">Contact us</a></div> --}}
                    </div>
                </div>


                <div class="box-nav-tabs mt-40 mb-5">
                    <ul class="nav" role="tablist">
                        <li><a class="btn btn-border aboutus-icon mr-15 mb-5 active" style="padding: 12px 42px!important;"
                                href="#tab-home" data-bs-toggle="tab" role="tab" aria-controls="tab-home"
                                aria-selected="true">About</a></li>
                        <li><a class="btn btn-border recruitment-icon mr-15 mb-5" style="padding: 12px 42px!important;"
                                href="#tab-recruitments" data-bs-toggle="tab" role="tab"
                                aria-controls="tab-recruitments" aria-selected="false">Job</a></li>
                        <!-- <li><a class="btn btn-border people-icon mb-5" href="#tab-people"
                                style="padding: 12px 42px!important;" data-bs-toggle="tab" role="tab"
                                aria-controls="tab-people" aria-selected="false">People</a>
                            </li> -->
                    </ul>
                </div>
                <div class="border-bottom pt-10 pb-10"></div>
            </div>
        </section>
        <section class="section-box mt-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                        <div class="content-single">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="tab-home">
                                    <h4>Welcome to {{ $userData->name }}</h4>
                                    <p>{{ $userData->company_desc }}</p>

                                    <p class="mb-0" style="font-weight: 600;">Website</p>
                                    <p>{{ $userData->personal_website }}</p>

                                    <p class="mb-0" style="font-weight: 600;">Industry</p>
                                    <p>{{ $userData->category_nm }}</p>

                                    <p class="mb-0" style="font-weight: 600;">Headquarters</p>
                                    <p>{{ $userData->city_nm }}, {{ $userData->state_name }}</p>

                                    <p class="mb-0" style="font-weight: 600;">Specialties</p>
                                    <p>Website Developement, Software Development, E-Commerce Site Development, Blog site Development, PHP Wordpress Expert Development, Android, Android app, IOS app, and custom web development</p>
                                </div>

                                <div class="tab-pane fade" id="tab-recruitments" role="tabpanel" aria-labelledby="tab-recruitments">
                                    <h5 class="mb-30">Jobs</h5>
                                    <div class="box-list-jobs display-list">
                                        @foreach ($JobData as $row)
                                            <div class="col-xl-12 col-12" style="cursor:pointer;" onclick="window.location.href='{{ route('job-detail', ['job_id' => $row->job_id]) }}'">
                                            {{-- <div class="col-xl-12 col-12" style="cursor:pointer;"> --}}
                                                <div class="card-grid-2 hover-up"><span class="flash"></span>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="card-grid-2-image-left">
                                                                <div class="image-box"><img
                                                                        src="{{ asset('assets/imgs/job.png') }}"
                                                                        style="max-width: 50px;" alt="jobBox"></div>
                                                                <div class="right-info"><a class="name-job">{{ $row->job_title }}</a><span
                                                                        class="card-briefcase">{{ $row->work_type_name }}</span><span
                                                                        class="card-time"><span>{{ \Carbon\Carbon::parse($row->datetime)->diffForHumans() }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-block-info">
                                                        <div class="mb-15 mt-5">
                                                            @php
                                                                $Skill = [];

                                                                if (!empty($row->skill_id)) {
                                                                    $decoded = json_decode($row->skill_id, true);
                                                                    $Skill = is_array($decoded) ? $decoded : [];
                                                                }
                                                            @endphp

                                                            @foreach ($Skill as $skill_nm)
                                                                <a class="btn btn-grey-small mr-5"
                                                                    href="javascript:void(0);">{{ $skill_nm }}</a>
                                                            @endforeach
                                                        </div>

                                                        {{-- <div class="work-desc mt-10">
                                                            <h6>About the job</h6>
                                                            <p class="mb-10 mt-10 of-txt-6">{{ $row->job_description }}
                                                            </p>
                                                        </div> --}}
                                                        <div class="work-desc mt-10">
                                                            <h6>About the job</h6>

                                                            <p class="mb-10 mt-10 of-txt-6 job-desc">
                                                                {!! $row->job_description !!}
                                                            </p>

                                                            <a href="javascript:void(0);" class="read-more-btn">
                                                                Read more...
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if ($JobData->lastPage() > 1)
                                        <div class="paginations mt-30">
                                            <ul class="pager">
                                                {{-- Previous Page Link --}}
                                                <li>
                                                    <a href="javascript:void(0)"
                                                        class="pager-prev {{ $JobData->onFirstPage() ? 'disabled' : '' }}"
                                                        data-page="{{ $JobData->currentPage() - 1 }}">
                                                    </a>
                                                </li>

                                                {{-- Page Numbers --}}
                                                @for ($i = 1; $i <= $JobData->lastPage(); $i++)
                                                    <li>
                                                        <a href="javascript:void(0)"
                                                            class="pager-number {{ $JobData->currentPage() == $i ? 'active' : '' }}"
                                                            data-page="{{ $i }}">
                                                            {{ $i }}
                                                        </a>

                                                    </li>
                                                @endfor

                                                {{-- Next Page Link --}}
                                                <li>
                                                   <a href="javascript:void(0)"
                                                        class="pager-next {{ !$JobData->hasMorePages() ? 'disabled' : '' }}"
                                                        data-page="{{ $JobData->currentPage() + 1 }}">
                                                    </a>

                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <!-- <div class="tab-pane fade" id="tab-people" role="tabpanel" aria-labelledby="tab-people">
                                    <h4>People</h4>
                                    <p>The AliStudio Design team has a vision to establish a trusted platform that enables
                                        productive and healthy enterprises in a world of digital and remote everything,
                                        constantly changing work patterns and norms, and the need for organizational
                                        resiliency.</p>
                                    <p>The ideal candidate will have strong creative skills and a portfolio of work which
                                        demonstrates their passion for illustrative design and typography. This candidate
                                        will have experiences in working with numerous different design platforms such as
                                        digital and print forms.</p>
                                </div> -->
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-12 pl-40 pl-lg-15 mt-lg-30">
                        <div class="sidebar-border">
                            <div class="sidebar-heading">
                                <div class="avatar-sidebar">
                                    <div class="sidebar-info pl-0"><span class="sidebar-company">{{ $userData->name }}</span><span class="card-location">{{ $userData->city_nm }},{{ $userData->state_name }}</span></div>
                                </div>
                            </div>
                            {{-- <div class="sidebar-list-job">
                                <div class="box-map">
                                    @php
                                        $address = urlencode($userData->address);
                                    @endphp
                                    <iframe src="https://www.google.com/maps?q={{ $address }}&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div> --}}
                            <div class="sidebar-list-job">
                                <ul>
                                    <li>
                                        <div class="sidebar-icon-item"><i class="fi-rr-briefcase"></i></div>
                                        <div class="sidebar-text-info"><span class="text-description">Company field</span><strong class="small-heading">{{ $userData->category_nm }}</strong></div>
                                    </li>
                                    <li>
                                        <div class="sidebar-icon-item"><i class="fi-rr-marker"></i></div>
                                        <div class="sidebar-text-info"><span
                                                class="text-description">Location</span><strong
                                                class="small-heading">{{ $userData->city_nm }},
                                                {{ $userData->state_name }} {{ $userData->zipcode }}</strong></div>
                                    </li>
                                    <li class="d-none">
                                        <div class="sidebar-icon-item"><i class="fi-rr-money"></i></div>
                                        <div class="sidebar-text-info"><span class="text-description">Salary</span><strong
                                                class="small-heading">{{ $userData->average_salary }}</strong></div>
                                    </li>
                                    <li>
                                        <div class="sidebar-icon-item"><i class="fi-rr-clock"></i></div>
                                        <div class="sidebar-text-info"><span class="text-description">Member
                                                since</span><strong
                                                class="small-heading">{{ $userData->company_since }}</strong></div>
                                    </li>
                                    {{-- <li>
                                        <div class="sidebar-icon-item"><i class="fi-rr-time-fast"></i></div>
                                        <div class="sidebar-text-info"><span class="text-description">Last Jobs
                                                Posted</span><strong class="small-heading">4 days</strong></div>
                                    </li> --}}
                                </ul>
                            </div>
                            {{-- <div class="sidebar-list-job text-center">
                                <div class="mt-5">
                                    <a class="btn btn-send-message" 
                                    target="_blank"
                                    href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $userData->email }}">
                                    Send Message
                                    </a>
                                </div>
                            </div> --}}
                            {{-- <div class="sidebar-list-job text-center">
                                <div class="mt-5">
                                    <a class="btn btn-send-message" 
                                    target="_blank"
                                    href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $Setting ? $Setting->email_1 : '' }}">
                                    <i class="fa fa-whatsapp"></i>
                                    Send Message
                                    </a>
                                </div>
                            </div> --}}
                            <div class="sidebar-list-job text-center">
                                <div class="mt-5">
                                    <a class="btn btn-send-message"
                                    target="_blank"
                                    href="https://wa.me/{{ preg_replace('/\D/', '', $Setting ? $Setting->contact_2 : '') }}">
                                        <i class="fa fa-whatsapp"></i>
                                        Send Message
                                    </a>
                                </div>
                            </div>

                        </div>

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


    <script>
        function RemoveNotification() {
            document.getElementById("NotifiCationSection").style.display = "none";
        }
    </script>
@endsection
@push('script')
<script>
function loadJobs(page = 1) {

    $.ajax({
        url: window.location.pathname, // 🔥 SAME URL, SAME ROUTE
        type: "GET",
        data: {
            page: page
        },
        beforeSend: function () {
            $(".box-list-jobs").css("opacity", "0.5");
        },
        success: function (response) {

            // 🔥 HTML replace only (reload nai)
            let html = $(response).find(".box-list-jobs").html();
            let pagination = $(response).find(".paginations").html();

            $(".box-list-jobs").html(html);
            $(".paginations").html(pagination);

            $(".box-list-jobs").css("opacity", "1");
        }
    });
}
</script>

<script>
$(document).on("click", ".paginations a", function (e) {
    e.preventDefault();

    let page = $(this).data("page");
    if (!page || $(this).hasClass("disabled")) return;

    loadJobs(page);
});
</script>

<script>
$(document).on('click', '.read-more-btn', function () {

    let desc = $(this).siblings('.job-desc');

    if (desc.hasClass('expanded')) {
        desc.removeClass('expanded');
        $(this).text('Read more...');
    } else {
        desc.addClass('expanded');
        $(this).text('Read less');
    }

});
</script>

@endpush