@extends('website.layout.layout')
@section('website-content')
<script>
    page_active_id = "Blog";
</script>
<style>
    .blog-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease-in-out;
    border: 2px solid #242b62;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 30px 70px rgba(0, 0, 0, 0.12);
}

/* Image */
.blog-image {
    width: auto;
    height: auto;
    overflow: hidden;
}

.blog-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    padding: 23px;
    border-radius: 2rem;
}

/* Content */
.blog-content {
    padding: 40px;
    /* text-align: center; */
}

.blog-title {
    font-size: 34px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #1f2937;
}

.blog-desc {
    font-size: 17px;
    line-height: 1.9;
    color: #4b5563;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .blog-image {
        height: 260px;
    }

    .blog-title {
        font-size: 26px;
    }

    .blog-content {
        padding: 25px;
    }
}

</style>
{{-- <style>
/* Sticky image on left column */
.sticky-image {
    position: sticky;
    top: 120px;
    display: flex;              /* 🔥 center trick */
    justify-content: center;    /* 🔥 horizontal center */
}

.sticky-image img {
    width: 70%;                 /* ✔ same as you want */
    height: auto;               /* ✔ auto height */
    border-radius: 21px;
    display: block;
}
.blog-desc {
    font-size: 1.1rem;
    line-height: 1.8;
}
.archive-header{
  top: 0px !important;
}
.btn-tag {
    background: rgba(243, 104, 37, 0.12);
    color: #f36825;
    font-weight: 600;
    border-radius: 20px;
    padding: 6px 14px;
}
</style> --}}

<main class="main">

     <section class="section-box ">
            <div class="breacrumb-cover bg-img-about">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6"> <div class="date mb-2">
                            
                            
                        </div>
                            <h2 class="mb-10">
                                <div class="post-meta text-muted d-flex align-items-center flex-wrap">
                                    <div class="author d-flex align-items-center me-3 mb-2">
                                        <img alt="jobBox" src="{{ asset('assets/imgs/profile.png') }}" class="rounded-circle me-2" width="35">
                                        <span class="text-white">By Zobpot</span>
                                    </div>
                                </div>
                            </h2>
                            <p class="font-lg color-text-paragraph-2">
                                <i class="fa fa-calendar me-2"></i>
                                {{ \Carbon\Carbon::parse($Blog->datetime)->format('d F Y') }}
                            </p>
                        </div>
                        <!-- <div class="col-lg-6 text-lg-end">
                            <ul class="breadcrumbs mt-40">
                                <li><a class="home-icon" href="{{ route('home') }}">Home</a></li>
                                <li>Blogs & Articles</li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
        </section>

    {{-- <!-- Hero image (optional top image) -->
    <section class="section-box mb-4">
        <div><img src="{{ asset('assets/imgs/page/blog/img-single.png') }}" alt="Hero Image" class="img-fluid"></div>
    </section> --}}

    <!-- Archive Header -->
    {{-- <section class="section-box mb-5">
        <div class="archive-header pt-50 text-center">
            <div class="container">
                <div class="box-white py-4">
                    <a class="btn btn-primary btn-sm mb-2" href="#">Blog</a>
                    <h2 class="mb-3">{{ $Blog->title }}</h2>
                    <div class="post-meta text-muted d-flex align-items-center justify-content-center flex-wrap">
                        <div class="author d-flex align-items-center me-3 mb-2">
                            <img alt="jobBox" src="{{ asset('assets/imgs/profile.png') }}" class="rounded-circle me-2" width="35">
                            <span>Zobpot</span>
                        </div>
                        <div class="date mb-2">
                            <img src="{{ asset('assets/imgs/page/blog/calendar.svg') }}" class="me-1" width="16">
                            {{ \Carbon\Carbon::parse($Blog->datetime)->format('d F Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Main Content with Sticky Image -->
    <div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="blog-card">

                <!-- Blog Image -->
                <div class="blog-image">
                    <img src="{{ asset('uploads/blog_img/'. $Blog->image) }}" alt="{{ $Blog->title }}">
                </div>

                <!-- Blog Content -->
                <div class="blog-content">
                    <h1 class="blog-title">{{ $Blog->title }}</h1>

                    <div class="blog-desc">
                        {!! $Blog->desc !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


</main>
@endsection
