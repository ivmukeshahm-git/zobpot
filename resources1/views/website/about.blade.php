@extends('website.layout.layout')
@section('website-content')

    <script>
        page_active_id = "About";
    </script>


    <main class="main">
        <section class="section-box ">
            <div class="breacrumb-cover bg-img-about">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2 class="mb-10">About Us</h2>
                            <p class="font-lg color-text-paragraph-2">Learn more about who we are and what drives us forward</p>
                        </div>
                        <!-- <div class="col-lg-6 text-lg-end">
                            <ul class="breadcrumbs mt-40">
                                <li><a class="home-icon" href="{{ route('home') }}">Home</a></li>
                                <li>About Us</li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
        </section>
        <section class="section-box mt-50 mb-70">
            <div class="post-loop-grid">
                <div class="container">
                    <div class="text-center">
                        <!-- <h6 class="f-18 color-text-mutted text-uppercase">Our company</h6> -->
                        <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">About Our Company</h2>
                       
                    </div>
                    <div class="row mt-70">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <!-- <img src="{{ asset('assets/imgs/page/about/img-about2.png') }}" alt="joxBox"></div> -->
                            <img src="{{ asset('assets/imgs/page/about/about-us.jpg') }}" alt="joxBox"></div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <h3 class="mt-15">What we do</h3>
                            <div class="mt-20">
                                @php
                                    echo $About->about_us;
                                @endphp
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
            <!--            <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">Blog</h2>-->
            <!--            <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">Get the latest-->
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
            <!--                                        </a></div>-->
            <!--                                    <div class="card-block-info">-->
            <!--                                        <div class="tags mb-15"><a class="btn btn-tag"-->
            <!--                                                href="{{ route('blog-detail', $row->id) }}">Blog</a>-->
            <!--                                        </div>-->
            <!--                                        <h5><a-->
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

        @if (!$Testimonial->isEmpty())
            <section class="section-box mt-30 mb-40">
                <div class="container">
                    <h2 class="text-center mb-15 wow animate__animated animate__fadeInUp">Our Happy Customer</h2>
                    <div class="font-lg color-text-paragraph-2 text-center wow animate__animated animate__fadeInUp">When it
                        comes to choosing the right web hosting provider, we know how easy it<br class="d-none d-lg-block">
                        is
                        to get overwhelmed with the number.</div>
                    <div class="row mt-50">
                        <div class="box-swiper">
                            <div class="swiper-container swiper-group-3 swiper">
                                <div class="swiper-wrapper pb-70 pt-5">
                                    @foreach ($Testimonial as $row)
                                        <div class="swiper-slide">
                                            <div class="card-grid-6 hover-up">
                                                <div class="card-text-desc mt-10">
                                                    <p class="font-md color-text-paragraph">{{ $row->description }}</p>
                                                </div>
                                                <div class="card-image">
                                                    <div class="image">
                                                        <figure><img alt="jobBox"
                                                                src="{{ asset('uploads/testimonial_img/' . $row->profile_img) }}">
                                                        </figure>
                                                    </div>
                                                    <div class="card-profile">
                                                        <h6>{{ $row->username }}</h6><span>{{ $row->designation }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach


                                    <div class="swiper-pagination swiper-pagination3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        @endif
    </main>
@endsection
