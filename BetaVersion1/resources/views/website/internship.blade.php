@extends('website.layout.layout')

@section('website-content')
    <script>
        page_active_id = "internship";
    </script>

    <style>
        #preloader-active { display: none; }

        /* ============================================
           ZOBPOT — UNSTOP-STYLE JOBS/INTERNSHIP LIST
           ============================================ */
        :root {
            --primary:       #242a64;
            --primary-d:     #1a1f4d;
            --primary-light: #e8eaf6;
            --text:          #1f2937;
            --muted:         #6b7280;
            --border:        #e5e7eb;
            --white:         #ffffff;
            --success:       #16a34a;
            --bg:            #f3f4f6;
            --shadow:        0 1px 3px rgba(0,0,0,.08);
            --shadow-md:     0 4px 16px rgba(0,0,0,.09);
            --shadow-lg:     0 8px 30px rgba(0,0,0,.11);
        }

        body { background: var(--bg); }
        .jobs-page { padding: 28px 0 80px; }

        /* ── PAGE HEADER ── */
        .page-header { margin-bottom: 20px; }
        .page-heading {
            font-size: 28px; font-weight: 800;
            color: var(--text); margin: 0 0 4px; line-height: 1.25;
        }
        .page-subheading { font-size: 13px; color: var(--muted); margin: 0; }

        /* ── CATEGORY SLIDER ── */
        .cat-slider-wrapper { position: relative; margin-bottom: 24px; padding: 0 38px; }
        .cat-scroll {
            display: flex; gap: 10px; overflow-x: auto;
            padding: 6px 4px 12px; scrollbar-width: none; scroll-behavior: smooth;
        }
        .cat-scroll::-webkit-scrollbar { display: none; }
        .cat-item {
            display: flex; flex-direction: column; align-items: center;
            width: 120px; min-width: 120px; max-width: 120px;
            background: var(--white);
            border: 1.5px solid var(--border); border-radius: 16px;
            padding: 15px 10px; text-align: center;
            text-decoration: none !important; color: var(--text) !important;
            transition: all .22s ease; cursor: pointer; flex-shrink: 0;
        }
        .cat-item:hover, .cat-item.active {
            border-color: var(--primary); background: var(--primary-light);
            transform: translateY(-2px); box-shadow: var(--shadow-md);
        }
        .cat-icon {
            width: 46px; height: 46px; border-radius: 50%;
            background: var(--primary-light);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 8px; font-size: 17px; color: var(--primary);
            transition: background .22s, color .22s;
            overflow: hidden;
        }
        .cat-icon img { width: 26px; height: 26px; object-fit: contain; }

        .cat-label {
            font-size: 11px; font-weight: 700; line-height: 1.4; color: inherit;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
            overflow: hidden; word-break: break-word;
        }

        /* Slider arrows */
        .slider-arrow {
            position: absolute; top: 50%; transform: translateY(-60%);
            width: 32px; height: 32px; border-radius: 50%;
            border: 1.5px solid var(--border); background: var(--white);
            color: var(--muted); font-size: 18px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; z-index: 5; box-shadow: var(--shadow);
            transition: all .2s; line-height: 1; padding: 0;
        }
        .slider-arrow:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-light); }
        .slider-arrow.prev { left: 0; }
        .slider-arrow.next { right: 0; }

        /* ── SEARCH BOX ── */
        .zp-search-box {
            background: var(--white); border: 1.5px solid var(--border);
            border-radius: 14px; padding: 7px 7px 7px 16px;
            display: flex; align-items: center; gap: 10px;
            box-shadow: var(--shadow); margin-bottom: 16px;
        }
        .zp-search-box > i { color: var(--muted); font-size: 14px; flex-shrink: 0; }
        .zp-search-box form { display: flex; flex: 1; align-items: center; gap: 10px; }
        .zp-search-box input {
            flex: 1; border: none; outline: none;
            background: transparent; font-size: 14px; color: var(--text); padding: 8px 0;
        }
        .zp-search-box input::placeholder { color: #9ca3af; }
        .zp-search-btn {
            background: var(--primary); color: var(--white); border: none;
            border-radius: 10px; padding: 10px 24px; font-size: 13px;
            font-weight: 700; cursor: pointer; white-space: nowrap; transition: background .2s;
        }
        .zp-search-btn:hover { background: var(--primary-d); }

        /* ── FILTER BAR ── */
        .filter-bar {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 22px; flex-wrap: wrap;
        }
        .filter-pill {
            display: inline-flex; align-items: center; gap: 5px;
            background: var(--white); border: 1.5px solid var(--border);
            border-radius: 40px; padding: 7px 14px; font-size: 13px;
            font-weight: 600; color: #374151; cursor: pointer;
            transition: all .18s; text-decoration: none !important;
            white-space: nowrap; position: relative;
        }
        .filter-pill:hover { border-color: var(--primary); color: var(--primary); }
        .filter-pill.active { background: var(--primary-light); border-color: #c5cae9; color: var(--primary); }
        .filter-count {
            background: var(--primary); color: var(--white);
            border-radius: 40px; padding: 1px 7px;
            font-size: 11px; font-weight: 700; margin-left: 2px;
        }
        .filter-pill .fa-chevron-down { font-size: 10px; color: #9ca3af; margin-left: 1px; }

        /* Dropdown menu */
        .filter-dropdown { position: relative; }
        .filter-dropdown-menu {
            display: none; position: absolute; top: calc(100% + 8px); left: 0;
            background: var(--white); border: 1.5px solid var(--border);
            border-radius: 14px; box-shadow: var(--shadow-lg);
            min-width: 190px; z-index: 200; padding: 6px 0;
            max-height: 260px; overflow-y: auto; overflow-x: hidden;
        }
        .filter-dropdown-menu::-webkit-scrollbar { width: 4px; }
        .filter-dropdown-menu::-webkit-scrollbar-track { background: transparent; }
        .filter-dropdown-menu::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        .filter-dropdown-menu::-webkit-scrollbar-thumb:hover { background: var(--primary); }
        .filter-dropdown.open .filter-dropdown-menu { display: block; }
        .filter-dropdown-item {
            display: flex; align-items: center; gap: 8px;
            padding: 10px 16px; font-size: 13px; font-weight: 500;
            color: var(--text); cursor: pointer; transition: background .15s;
        }
        .filter-dropdown-item:hover { background: var(--primary-light); color: var(--primary); }
        .filter-dropdown-item.active { background: var(--primary-light); color: var(--primary); font-weight: 700; }
        .filter-dropdown-item i { font-size: 12px; width: 14px; text-align: center; }

        /* ── JOB CARD ── */
        .job-card {
            background: var(--white); border: 1.5px solid var(--border);
            border-radius: 18px; padding: 20px 22px; margin-bottom: 14px;
            cursor: pointer; transition: all .22s ease;
            box-shadow: var(--shadow); position: relative;
        }
        .job-card:hover {
            border-color: #c5cae9; box-shadow: var(--shadow-lg); transform: translateY(-2px);
        }
        .job-card-inner { display: flex; gap: 14px; justify-content: space-between; align-items: flex-start; }
        .job-card-body { flex: 1; min-width: 0; }
        .job-card-right { display: flex; flex-direction: column; align-items: center; gap: 12px; flex-shrink: 0; }

        /* Title & company */
        .job-title {
            font-size: 16px; font-weight: 800; color: var(--text);
            margin: 0 0 3px; line-height: 1.35;
        }
        .job-company { font-size: 13px; color: var(--muted); font-weight: 500; margin: 0 0 10px; }

        /* Meta row */
        .job-meta {
            display: flex; flex-wrap: wrap; align-items: center;
            gap: 0; margin-bottom: 8px; font-size: 13px; color: #4b5563;
        }
        .job-meta-item { display: inline-flex; align-items: center; gap: 5px; }
        .job-meta-sep { color: #d1d5db; margin: 0 9px; }
        .job-meta-item i { color: #9ca3af; font-size: 11px; }

        /* Skills */
        .job-skills {
            font-size: 12.5px; color: var(--muted);
            display: flex; flex-wrap: wrap; align-items: center;
            gap: 0; margin-bottom: 10px;
        }
        .skill-item { white-space: nowrap; }
        .skill-dot { color: #d1d5db; margin: 0 6px; font-size: 10px; }

        /* Tags */
        .job-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 12px; }
        .job-tag {
            background: #f9fafb; color: #374151;
            border: 1px solid #e5e7eb; border-radius: 8px;
            padding: 4px 11px; font-size: 11.5px; font-weight: 600;
        }

        /* Card footer */
        .job-card-footer {
            display: flex; align-items: center;
            justify-content: space-between; padding-top: 12px;
            border-top: 1px solid #f3f4f6; flex-wrap: wrap; gap: 8px;
        }
        .job-footer-left {
            display: flex; align-items: center; flex-wrap: wrap;
            gap: 16px; font-size: 12.5px; color: var(--muted);
        }
        .job-footer-item { display: inline-flex; align-items: center; gap: 5px; }
        .job-footer-item i { font-size: 12px; }
        .job-deadline { color: var(--primary); font-weight: 700; }
        .job-footer-actions { display: flex; align-items: center; gap: 7px; }

        /* Action icon buttons */
        .icon-btn {
            width: 34px; height: 34px; border-radius: 50%;
            border: 1.5px solid #e5e7eb; background: var(--white);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; color: var(--muted); cursor: pointer;
            transition: all .18s; flex-shrink: 0;
        }
        .icon-btn:hover { border-color: var(--primary); color: var(--primary); background: var(--primary-light); }
        .icon-btn.saved { color: #ef4444; border-color: #fecaca; background: #fef2f2; }

        /* Company logo */
        .company-logo-box {
            width: 54px; height: 54px; border-radius: 12px;
            border: 1.5px solid var(--border); background: var(--white);
            padding: 7px; display: flex; align-items: center; justify-content: center;
            overflow: hidden; flex-shrink: 0;
        }
        .company-logo-box img { width: 100%; height: 100%; object-fit: contain; }
        .company-logo-initials {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 800; color: var(--primary);
            background: var(--primary-light); border-radius: 8px; text-transform: uppercase;
        }

        /* ── SIDEBAR ── */
        .sidebar-card {
            background: var(--white); border-radius: 18px;
            border: 1.5px solid var(--border); box-shadow: var(--shadow);
            padding: 20px; position: sticky; top: 78px;
        }
        .sidebar-heading {
            font-size: 16px; font-weight: 800; color: var(--text);
            margin: 0 0 14px; padding-bottom: 12px; border-bottom: 1px solid var(--border);
        }
        .sidebar-item {
            display: flex; gap: 11px; padding: 11px 0;
            border-bottom: 1px solid #f3f4f6;
            text-decoration: none !important; color: inherit !important;
            transition: all .18s; align-items: flex-start;
        }
        .sidebar-item:last-child { border-bottom: none; padding-bottom: 0; }
        .sidebar-item:hover .sidebar-item-title { color: var(--primary); }
        .sidebar-logo {
            width: 42px; height: 42px; border-radius: 10px;
            border: 1px solid var(--border); background: #f9fafb;
            overflow: hidden; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .sidebar-logo img { width: 100%; height: 100%; object-fit: contain; }
        .sidebar-logo-init {
            font-size: 11px; font-weight: 800; color: var(--primary);
            background: var(--primary-light); width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center; text-transform: uppercase;
        }
        .sidebar-item-info { flex: 1; min-width: 0; }
        .sidebar-item-title {
            font-size: 12.5px; font-weight: 700; color: var(--text);
            line-height: 1.4; margin: 0 0 2px; transition: color .18s;
        }
        .sidebar-item-sub { font-size: 11.5px; color: var(--muted); }

        /* ── PAGINATION ── */
        .pagination { gap: 4px; }
        .page-item .page-link {
            width: 36px; height: 36px; border-radius: 50% !important;
            display: flex; align-items: center; justify-content: center;
            border: 1.5px solid #d1d5db !important; color: #374151;
            font-weight: 700; font-size: 13px; background: var(--white); transition: all .18s;
        }
        .page-item.active .page-link { background: var(--primary) !important; border-color: var(--primary) !important; color: var(--white) !important; }
        .page-item .page-link:hover { border-color: var(--primary) !important; color: var(--primary); background: var(--primary-light); }

        /* ── EMPTY STATE ── */
        .empty-state { text-align: center; padding: 60px 20px; color: var(--muted); }
        .empty-state i { font-size: 48px; opacity: .25; display: block; margin-bottom: 12px; }
        .empty-state p { font-size: 14px; margin: 0; }

        /* ── RESPONSIVE ── */
        @media (max-width: 991px) {
            .page-heading { font-size: 22px; }
            .sidebar-card { margin-top: 24px; position: static; }
        }
        @media (max-width: 768px) {
            .jobs-page { padding: 20px 0 60px; }
            .job-card { padding: 16px; }
            .job-title { font-size: 15px; }
            .company-logo-box { width: 46px; height: 46px; }
            .filter-bar { flex-wrap: nowrap; overflow-x: auto; padding-bottom: 8px; scrollbar-width: none; }
            .filter-bar::-webkit-scrollbar { display: none; }
            .cat-item { min-width: 95px; padding: 12px 8px; }
            .cat-slider-wrapper { padding: 0 30px; }
        }
    </style>

    <main class="main">
        <section class="jobs-page">
            <div class="container">

                {{-- ── PAGE HEADER ── --}}
                <div class="page-header">
                    <h1 class="page-heading">{{ $internships->total() }} Internships in India for Students</h1>
                    <p class="page-subheading">Latest internships and opportunities in India.</p>
                </div>

                {{-- ── CATEGORY SLIDER WITH ARROWS ── --}}
                <div class="cat-slider-wrapper">
                    <button class="slider-arrow prev" id="sliderPrev" aria-label="Previous">&#8249;</button>
                    <div class="cat-scroll" id="catScroll">
                        @foreach($categories as $cat)
                            @php
                                $isActive = request('category') == $cat->category_id;
                            @endphp
                            <a class="cat-item {{ $isActive ? 'active' : '' }}"
                               href="{{ route('internship') }}?category={{ $cat->category_id }}"
                               data-category-id="{{ $cat->category_id }}">
                                <div class="cat-icon">
                                    @if(!empty($cat->image) && file_exists(public_path('uploads/category_img/' . $cat->image)))
                                        <img src="{{ asset('uploads/category_img/' . $cat->image) }}"
                                             alt="{{ $cat->category_nm }}"
                                             style="width:26px;height:26px;object-fit:contain;">
                                    @else
                                        <i class="fa fa-briefcase"></i>
                                    @endif
                                </div>
                                <span class="cat-label">{{ $cat->category_nm }}</span>
                            </a>
                        @endforeach
                    </div>
                    <button class="slider-arrow next" id="sliderNext" aria-label="Next">&#8250;</button>
                </div>

                {{-- ── SEARCH BOX ── --}}
                <div class="zp-search-box">
                    <i class="fa fa-search"></i>
                    <form action="{{ route('internship') }}" method="GET" style="display:flex;flex:1;align-items:center;gap:10px;">
                        <input type="text" name="search" placeholder="Search by title, skills, or location..." value="{{ request('search') }}">
                        <button type="submit" class="zp-search-btn">Search</button>
                    </form>
                </div>

                {{-- ── FILTER BAR (Unstop-style dropdowns) ── --}}
                <div class="filter-bar" id="filterBar">

                    {{-- Filters count button --}}
                    @php
                        $activeCount = (request('mode') ? 1 : 0)
                                     + (request('category') ? 1 : 0)
                                     + (request('search') ? 1 : 0)
                                     + (request('near_lat') ? 1 : 0);
                    @endphp
                    <button class="filter-pill {{ $activeCount > 0 ? 'active' : '' }}" onclick="clearAllFilters()">
                        <i class="fa fa-sliders"></i> Filters
                        @if($activeCount > 0)
                            <span class="filter-count">{{ $activeCount }}</span>
                        @endif
                    </button>

                    {{-- Type dropdown --}}
                    <div class="filter-dropdown" id="dd-type">
                        <button class="filter-pill {{ request('mode') ? 'active' : '' }}" onclick="toggleDropdown('dd-type')">
                            @if(request('mode') == 'Online') Work from Home
                            @elseif(request('mode') == 'Offline') In Office
                            @elseif(request('mode')) {{ request('mode') }}
                            @else Type
                            @endif
                            <i class="fa fa-chevron-down"></i>
                        </button>
                        <div class="filter-dropdown-menu">
                            <div class="filter-dropdown-item {{ !request('mode') ? 'active' : '' }}" onclick="filterByMode('')">All Types</div>
                            <div class="filter-dropdown-item {{ request('mode')=='Online' ? 'active' : '' }}" onclick="filterByMode('Online')">
                                <i class="fa fa-home"></i> Work from Home
                            </div>
                            <div class="filter-dropdown-item {{ request('mode')=='Offline' ? 'active' : '' }}" onclick="filterByMode('Offline')">
                                <i class="fa fa-building"></i> In Office
                            </div>
                            <div class="filter-dropdown-item {{ request('mode')=='Hybrid' ? 'active' : '' }}" onclick="filterByMode('Hybrid')">
                                <i class="fa fa-exchange"></i> Hybrid
                            </div>
                        </div>
                    </div>

                    {{-- Location / Near Me --}}
                    {{-- <button class="filter-pill {{ request('near_lat') ? 'active' : '' }}" id="near-me-pill" onclick="filterNearMe()">
                        <i class="fa fa-map-marker"></i> Location
                        <i class="fa fa-chevron-down"></i>
                    </button> --}}

                    {{-- Roles / Category dropdown --}}
                    <div class="filter-dropdown" id="dd-roles">
                        @php $selCat = request('category') ? $categories->firstWhere('category_id', request('category')) : null; @endphp
                        <button class="filter-pill {{ request('category') ? 'active' : '' }}" onclick="toggleDropdown('dd-roles')">
                            {{ $selCat ? \Illuminate\Support\Str::limit($selCat->category_nm, 18) : 'Roles' }}
                            <i class="fa fa-chevron-down"></i>
                        </button>
                        <div class="filter-dropdown-menu">
                            <div class="filter-dropdown-item {{ !request('category') ? 'active' : '' }}" onclick="filterByCategory('')">All Roles</div>
                            @foreach($categories as $cat)
                                <div class="filter-dropdown-item {{ request('category') == $cat->category_id ? 'active' : '' }}"
                                     onclick="filterByCategory('{{ $cat->category_id }}')">b
                                    {{ $cat->category_nm }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Sort By dropdown --}}
                    <div class="filter-dropdown" id="dd-sort">
                        <button class="filter-pill {{ request('sort_by') && request('sort_by') != 'latest' ? 'active' : '' }}" onclick="toggleDropdown('dd-sort')">
                            <i class="fa fa-sort-amount-asc"></i> Sort By
                            <i class="fa fa-chevron-down"></i>
                        </button>
                        <div class="filter-dropdown-menu">
                            <div class="filter-dropdown-item {{ (request('sort_by','latest')=='latest') ? 'active' : '' }}" onclick="sortBy('latest')">Latest First</div>
                            <div class="filter-dropdown-item {{ request('sort_by')=='oldest' ? 'active' : '' }}" onclick="sortBy('oldest')">Oldest First</div>
                            <div class="filter-dropdown-item {{ request('sort_by')=='stipend_high' ? 'active' : '' }}" onclick="sortBy('stipend_high')">Stipend: High to Low</div>
                            <div class="filter-dropdown-item {{ request('sort_by')=='stipend_low' ? 'active' : '' }}" onclick="sortBy('stipend_low')">Stipend: Low to High</div>
                            <div class="filter-dropdown-item {{ request('sort_by')=='deadline' ? 'active' : '' }}" onclick="sortBy('deadline')">Deadline</div>
                        </div>
                    </div>

                </div>{{-- /filter-bar --}}

                <div class="row">

                    {{-- ── JOB CARDS COLUMN ── --}}
                    <div class="col-lg-8">
                        @if($internships->count() > 0)
                            @foreach($internships as $item)
                                @php
                                    $daysLeftCard = null;
                                    if ($item->application_deadline) {
                                        $daysLeftCard = (int) \Carbon\Carbon::now()->diffInDays(
                                            \Carbon\Carbon::parse($item->application_deadline), false
                                        );
                                    }
                                    $skills = [];
                                    if ($item->skills) {
                                        try {
                                            $skills = json_decode($item->skills, true);
                                            if (!is_array($skills)) $skills = array_map('trim', explode(',', $item->skills));
                                        } catch (\Exception $e) {
                                            $skills = array_map('trim', explode(',', $item->skills));
                                        }
                                    }
                                    $companyName     = $item->company ? $item->company->name : 'Company';
                                    $companyInitials = strtoupper(substr($companyName, 0, 2));
                                    $isWishlisted    = in_array($item->id, $wishlistIds ?? []);
                                    $modeLabel       = $item->mode == 'Online' ? 'Work from Home'
                                                      : ($item->mode == 'Offline' ? 'In Office' : $item->mode);
                                @endphp

                                <div class="job-card"
                                     onclick="window.location.href='{{ route('internship.detail', $item->slug ?? $item->id) }}'">
                                    <div class="job-card-inner">

                                        {{-- Left: details --}}
                                        <div class="job-card-body">
                                            <h3 class="job-title">{{ $item->internship_title }}</h3>
                                            <p class="job-company">{{ $companyName }}</p>

                                            <div class="job-meta">
                                                @if($item->duration)
                                                    <span class="job-meta-item"><i class="fa fa-clock-o"></i> {{ $item->duration }}</span>
                                                    <span class="job-meta-sep">|</span>
                                                @endif
                                                <span class="job-meta-item"><i class="fa fa-briefcase"></i> {{ $modeLabel }}</span>
                                                @if($item->location)
                                                    <span class="job-meta-sep">|</span>
                                                    <span class="job-meta-item"><i class="fa fa-map-marker"></i> {{ $item->location }}</span>
                                                @endif
                                            </div>

                                            @if(!empty($skills))
                                                <div class="job-skills">
                                                    @foreach(array_slice($skills, 0, 5) as $si => $sk)
                                                        @if($si > 0)<span class="skill-dot">&bull;</span>@endif
                                                        <span class="skill-item">{{ trim($sk) }}</span>
                                                    @endforeach
                                                    @if(count($skills) > 5)
                                                        <span class="skill-dot">&bull;</span>
                                                        <span class="skill-item" style="color:var(--primary);font-weight:600;">+{{ count($skills)-5 }}</span>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="job-tags">
                                                @if($item->jobCategory)
                                                    <span class="job-tag">{{ \Illuminate\Support\Str::limit($item->jobCategory->category_nm, 22) }}</span>
                                                @endif
                                                <span class="job-tag">{{ $modeLabel }}</span>
                                                @if($item->stipend > 0)
                                                    <span class="job-tag" style="color:var(--success);border-color:#bbf7d0;background:#f0fdf4;">
                                                        ₹{{ number_format($item->stipend) }}/mo
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="job-card-footer" onclick="event.stopPropagation();">
                                                <div class="job-footer-left">
                                                    <span class="job-footer-item">
                                                        <i class="fa fa-calendar-o"></i>
                                                        Posted {{ $item->created_at->format('M d, Y') }}
                                                    </span>
                                                    @if($daysLeftCard !== null)
                                                        <span class="job-footer-item">
                                                            <i class="fa fa-flag" style="color:#f59e0b;"></i>
                                                            @if($daysLeftCard > 0)
                                                                <span class="job-deadline">{{ $daysLeftCard }} day{{ $daysLeftCard > 1 ? 's' : '' }} left</span>
                                                            @else
                                                                <span class="text-secondary fw-bold">Closed</span>
                                                            @endif
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="job-footer-actions">
                                                    <button class="icon-btn"
                                                            onclick="shareInternship('{{ $item->slug ?? $item->id }}')"
                                                            title="Share">
                                                        <i class="fa fa-share-alt"></i>
                                                    </button>
                                                    <button class="icon-btn {{ $isWishlisted ? 'saved' : '' }}"
                                                            id="wishlist-btn-{{ $item->id }}"
                                                            onclick="toggleWishlist({{ $item->id }})"
                                                            title="{{ $isWishlisted ? 'Remove from Wishlist' : 'Save' }}">
                                                        <i class="fa {{ $isWishlisted ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>{{-- /job-card-body --}}

                                        {{-- Right: company logo --}}
                                        <div class="job-card-right">
                                            <div class="company-logo-box">
                                                @if($item->company && !empty($item->company->profile_img) && file_exists(public_path('uploads/profile/' . $item->company->profile_img)))
                                                    <img src="{{ asset('uploads/profile/' . $item->company->profile_img) }}"
                                                         alt="{{ $companyName }}"
                                                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                                    <div class="company-logo-initials" style="display:none;">{{ $companyInitials }}</div>
                                                @else
                                                    <div class="company-logo-initials">{{ $companyInitials }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>{{-- /job-card-inner --}}
                                </div>{{-- /job-card --}}
                            @endforeach

                            <div class="d-flex justify-content-center mt-4">
                                {{ $internships->appends(request()->query())->links() }}
                            </div>

                        @else
                            <div class="empty-state">
                                <i class="fa fa-search"></i>
                                <p>No internships found matching your criteria.<br>
                                   Try adjusting filters or search terms.</p>
                            </div>
                        @endif
                    </div>{{-- /col-lg-8 --}}

                    {{-- ── FEATURED SIDEBAR ── --}}
                    <div class="col-lg-4">
                        <div class="sidebar-card">
                            <h5 class="sidebar-heading">Featured</h5>

                            @if($featuredInternships && $featuredInternships->count() > 0)
                                @foreach($featuredInternships as $feat)
                                    @php
                                        $featName = $feat->company ? $feat->company->name : 'Company';
                                        $featInit = strtoupper(substr($featName, 0, 2));
                                    @endphp
                                    <a href="{{ route('internship.detail', $feat->slug ?? $feat->id) }}" class="sidebar-item">
                                        <div class="sidebar-logo">
                                            @if($feat->company && !empty($feat->company->profile_img) && file_exists(public_path('uploads/profile/' . $feat->company->profile_img)))
                                                <img src="{{ asset('uploads/profile/' . $feat->company->profile_img) }}"
                                                     alt="{{ $featName }}"
                                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                                <div class="sidebar-logo-init" style="display:none;">{{ $featInit }}</div>
                                            @else
                                                <div class="sidebar-logo-init">{{ $featInit }}</div>
                                            @endif
                                        </div>
                                        <div class="sidebar-item-info">
                                            <div class="sidebar-item-title">{{ \Illuminate\Support\Str::limit($feat->internship_title, 40) }}</div>
                                            <div class="sidebar-item-sub">{{ $feat->jobCategory ? $feat->jobCategory->category_nm : 'Internship' }}</div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div style="text-align:center;padding:30px 0;color:var(--muted);">
                                    <i class="fa fa-inbox" style="font-size:32px;opacity:.2;display:block;margin-bottom:8px;"></i>
                                    <p style="font-size:13px;margin:0;">No featured items</p>
                                </div>
                            @endif
                        </div>
                    </div>{{-- /col-lg-4 --}}

                </div>{{-- /row --}}
            </div>{{-- /container --}}
        </section>
    </main>

    <script>
        /* ── Category Slider Arrows ── */
        (function () {
            const scroll = document.getElementById('catScroll');
            const prev   = document.getElementById('sliderPrev');
            const next   = document.getElementById('sliderNext');
            if (!scroll) return;
            const step = 250;
            if (prev) prev.addEventListener('click', () => scroll.scrollBy({ left: -step, behavior: 'smooth' }));
            if (next) next.addEventListener('click', () => scroll.scrollBy({ left:  step, behavior: 'smooth' }));

            // Highlight active category card (already handled server-side via .active class)
            // Auto-scroll active item into view
            const activeItem = document.querySelector('.cat-item.active');
            if (activeItem && scroll) {
                scroll.scrollTo({ left: activeItem.offsetLeft - 60, behavior: 'smooth' });
            }
        })();

        /* ── Filter Dropdowns ── */
        function toggleDropdown(id) {
            document.querySelectorAll('.filter-dropdown').forEach(d => {
                if (d.id !== id) d.classList.remove('open');
            });
            const el = document.getElementById(id);
            if (el) el.classList.toggle('open');
        }
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.filter-dropdown')) {
                document.querySelectorAll('.filter-dropdown').forEach(d => d.classList.remove('open'));
            }
        });

        /* ── URL Filter Helpers ── */
        function filterByMode(mode) {
            const url = new URL(window.location.href);
            mode ? url.searchParams.set('mode', mode) : url.searchParams.delete('mode');
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }
        function filterByCategory(cat) {
            const url = new URL(window.location.href);
            cat ? url.searchParams.set('category', cat) : url.searchParams.delete('category');
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }
        function sortBy(val) {
            const url = new URL(window.location.href);
            val ? url.searchParams.set('sort_by', val) : url.searchParams.delete('sort_by');
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }
        function clearAllFilters() {
            window.location.href = '{{ route("internship") }}';
        }

        /* ── Near Me (Geolocation) ── */
        function filterNearMe() {
            if (!navigator.geolocation) { alert('Geolocation is not supported by your browser'); return; }
            const btn  = document.getElementById('near-me-pill');
            btn.disabled = true;
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="fa fa-spinner fa-pulse"></i> Locating…';
            navigator.geolocation.getCurrentPosition(
                function (pos) {
                    const url = new URL(window.location.href);
                    url.searchParams.set('near_lat', pos.coords.latitude);
                    url.searchParams.set('near_lng', pos.coords.longitude);
                    url.searchParams.delete('page');
                    window.location.href = url.toString();
                },
                function () {
                    alert('Unable to retrieve your location');
                    btn.disabled = false;
                    btn.innerHTML = orig;
                },
                { timeout: 10000 }
            );
        }
        // Highlight "Location" pill if near_lat is set
        (function () {
            if (new URLSearchParams(window.location.search).get('near_lat')) {
                const p = document.getElementById('near-me-pill');
                if (p) p.classList.add('active');
            }
        })();

        /* ── Share ── */
        function shareInternship(slug) {
            const url = '{{ url("/internship-detail") }}/' + slug;
            if (navigator.share) {
                navigator.share({ title: 'Internship Opportunity', url }).catch(() => {});
            } else {
                navigator.clipboard.writeText(url).then(() => alert('Link copied to clipboard!'));
            }
        }

        /* ── Wishlist Toggle ── */
        function toggleWishlist(id) {
            @guest
                alert('Please login to save internships');
                window.location.href = '{{ route("login") }}';
                return;
            @endguest
            const btn  = document.getElementById('wishlist-btn-' + id);
            const icon = btn.querySelector('i');
            btn.disabled = true;
            fetch('{{ route("internship.wishlist.toggle") }}', {
                method:  'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body:    JSON.stringify({ internship_id: id })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const added = data.action === 'added';
                    icon.className = added ? 'fa fa-heart' : 'fa fa-heart-o';
                    btn.classList.toggle('saved', added);
                    btn.title = added ? 'Remove from Wishlist' : 'Save';
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon: added ? 'success' : 'info', title: data.message,
                                    timer: 1800, showConfirmButton: false });
                    }
                } else {
                    alert(data.message || 'An error occurred');
                }
            })
            .catch(() => alert('An error occurred while updating wishlist'))
            .finally(() => { btn.disabled = false; });
        }
    </script>
@endsection
