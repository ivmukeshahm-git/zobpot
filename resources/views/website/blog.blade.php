@extends('website.layout.layout')

@section('website-content')
<script>
    page_active_id = "Blog";
</script>

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

    <main class="main">
        <section class="section-box ">
            <div class="breacrumb-cover bg-img-about">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2 class="mb-10">Blogs & Articles</h2>
                            <p class="font-lg color-text-paragraph-2">Get the latest news, updates and tips</p>
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
        <section class="section-box mt-50">
            <div class="container">
                <div class="row">

                    @forelse($Blog as $row)
                    <div class="col-lg-4 mb-30 d-flex">

                        <div class="blog-card w-100">

                            {{-- IMAGE (DYNAMIC) --}}
                            <div class="blog-img">
                                <a href="{{ route('blog-detail', $row->id) }}">
                                    <img src="{{ asset('uploads/blog_img/'.$row->image) }}" alt="{{ $row->title }}">
                                </a>
                            </div>

                            {{-- BODY --}}
                            <div class="blog-body">

                                {{-- TAG (DYNAMIC IF YOU HAVE CATEGORY) --}}
                                <div class="blog-tag-wrap">
                                    <span class="blog-tag">
                                        {{ $row->category_name ?? 'Blog' }}
                                    </span>
                                </div>


                                {{-- TITLE (DYNAMIC) --}}
                                <div class="blog-title">
                                    {{ $row->title }}
                                </div>

                                {{-- DESCRIPTION (DYNAMIC) --}}
                                <div class="blog-desc">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($row->desc), 90) }}
                                </div>

                                {{-- FOOTER (DYNAMIC) --}}
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

                    </div>
                    @empty
                    <div class="col-12 text-center">
                        <h3>No Blog Found</h3>
                    </div>
                    @endforelse

                </div>
            </div>
        </section>
    </main>

@endsection
