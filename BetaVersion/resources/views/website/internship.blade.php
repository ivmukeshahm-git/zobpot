@extends('website.layout.layout')

@section('website-content')
    <script>
        page_active_id = "internship";
    </script>

    <style>
        #preloader-active {
            display: none;
        }

        .internship-page {
            background: #f8f9fa;
            padding: 30px 0;
        }

        .filter-bar {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .filter-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: white;
            border: 1px solid #ddd;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            color: #333;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            border-color: #3b7ddd;
            color: #3b7ddd;
        }

        .filter-btn.active {
            background: #3b7ddd;
            color: white;
            border-color: #3b7ddd;
        }

        .filter-btn .badge-count {
            background: #3b7ddd;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 12px;
        }

        .filter-btn.active .badge-count {
            background: white;
            color: #3b7ddd;
        }

        .internship-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .internship-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .internship-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .internship-title {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .company-name {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 12px;
        }

        .company-logo {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #e0e0e0;
        }

        .internship-meta {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 15px;
            font-size: 13px;
            color: #555;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .meta-item i {
            color: #3b7ddd;
        }

        .tags-container {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .tag {
            background: #f0f4ff;
            color: #3b7ddd;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .student-levels {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .level-tag {
            background: #f8f9fa;
            color: #555;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            border: 1px solid #e0e0e0;
        }

        .more-tag {
            background: white;
            color: #3b7ddd;
            border: 1px solid #3b7ddd;
        }

        .internship-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
        }

        .posted-info {
            font-size: 13px;
            color: #7f8c8d;
        }

        .deadline {
            color: #e74c3c;
            font-weight: 500;
        }

        .stipend {
            background: #d4edda;
            color: #155724;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .card-actions {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
        }

        .action-btn {
            background: white;
            border: 1px solid #ddd;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            border-color: #3b7ddd;
            color: #3b7ddd;
        }

        .action-btn.active {
            background: #3b7ddd;
            color: white;
            border-color: #3b7ddd;
        }

        .featured-sidebar {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 20px;
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .featured-item {
            display: flex;
            gap: 12px;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .featured-item:hover {
            background: #f8f9fa;
        }

        .featured-logo {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            background: #f0f4ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #3b7ddd;
            flex-shrink: 0;
        }

        .featured-info h6 {
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .featured-type {
            font-size: 12px;
            color: #7f8c8d;
        }

        @media (max-width: 768px) {
            .filter-buttons {
                overflow-x: auto;
                flex-wrap: nowrap;
            }

            .internship-header {
                flex-direction: column;
            }

            .company-logo {
                margin-bottom: 12px;
            }

            .card-actions {
                position: static;
                margin-top: 10px;
            }
        }
    </style>

    <main class="main">
        <section class="section-box">
            <div class="breacrumb-cover bg-img-about">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="mb-10">Internship Opportunities</h2>
                            <p class="font-lg color-text-paragraph-2">Discover and apply for the best internship
                                opportunities</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="internship-page">
            <div class="container">
                <!-- Filter Bar -->
                <div class="filter-bar">
                    <div class="filter-buttons">
                        <button class="filter-btn active">
                            <i class="fa fa-filter"></i> Filters <span class="badge-count">2</span>
                        </button>
                        <button class="filter-btn">
                            <i class="fa fa-briefcase"></i> Type
                        </button>
                        <button class="filter-btn">
                            <i class="fa fa-map-marker"></i> Location
                        </button>
                        <button class="filter-btn">
                            <i class="fa fa-th-large"></i> Categories
                        </button>
                        <button class="filter-btn">
                            <i class="fa fa-sort"></i> Sort By
                        </button>
                    </div>
                </div>

                <div class="row">
                    <!-- Internship List -->
                    <div class="col-lg-8">
                        <!-- Internship Card 1 -->
                        <div class="internship-card">
                            <div class="internship-header">

                                <div style="flex: 1;">
                                    <a href="{{ route('internship.detail') }}"></a>
                                    <h3 class="internship-title">Techniche Campus Ambassador</h3>
                                    <p class="company-name">Indian Institute of Technology (IIT), Guwahati</p>
                                    </a>
                                </div>
                                <img src="{{ asset('assets/imgs/favicons.png') }}" alt="Logo" class="company-logo">

                            </div>

                            <div class="internship-meta">
                                <div class="meta-item">
                                    <i class="fa fa-briefcase"></i> No prior experience required
                                </div>
                                <div class="meta-item">
                                    <i class="fa fa-clock-o"></i> Part Time
                                </div>
                                <div class="meta-item">
                                    <i class="fa fa-map-marker"></i> Remote
                                </div>
                            </div>

                            <div class="tags-container">
                                <span class="tag">Content Marketing (LinkedIn)</span>
                                <span class="tag">Social Media Marketing (SMM)</span>
                                <span class="tag">Content Marketing (LinkedIn)</span>
                                <span class="tag">+1</span>
                            </div>

                            <div class="student-levels">
                                <span class="level-tag">Undergraduate</span>
                                <span class="level-tag">Postgraduate</span>
                                <span class="level-tag">Engineering Students</span>
                                <span class="level-tag more-tag">+4</span>
                            </div>

                            <div class="internship-footer">
                                <div class="posted-info">
                                    Posted Feb 2, 2026 • <span class="deadline">14 days left</span>
                                </div>
                                <div class="card-actions" style="position: static;">
                                    <button class="action-btn">
                                        <i class="fa fa-share-alt"></i>
                                    </button>
                                    <button class="action-btn">
                                        <i class="fa fa-heart-o"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Internship Card 2 -->
                        <div class="internship-card">
                            <div class="internship-header">
                                <div style="flex: 1;">
                                    <a href="{{ route('internship.detail') }}">
                                        <h3 class="internship-title">Community Management Internship</h3>
                                        <p class="company-name">Eduveda Academy</p>
                                    </a>
                                </div>
                                <img src="{{ asset('assets/imgs/favicons.png') }}" alt="Logo" class="company-logo">
                            </div>

                            <div class="internship-meta">
                                <div class="meta-item">
                                    <i class="fa fa-briefcase"></i> No prior experience required
                                </div>
                                <div class="meta-item">
                                    <i class="fa fa-clock-o"></i> Part Time
                                </div>
                                <div class="meta-item">
                                    <i class="fa fa-map-marker"></i> Remote
                                </div>
                            </div>

                            <div class="tags-container">
                                <span class="tag">Communication Skills</span>
                                <span class="tag">Community Engagement</span>
                                <span class="tag">Customer Service</span>
                                <span class="tag">+1</span>
                            </div>

                            <div class="student-levels">
                                <span class="level-tag">Undergraduate</span>
                                <span class="level-tag">Postgraduate</span>
                                <span class="level-tag">Engineering Students</span>
                                <span class="level-tag more-tag">+5</span>
                            </div>

                            <div class="internship-footer">
                                <div class="posted-info">
                                    Posted Feb 2, 2026 • <span class="deadline">14 days left</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div class="stipend">
                                        <i class="fa fa-check-circle"></i> ₹15K - 20K/Month
                                    </div>
                                    <div class="card-actions" style="position: static;">
                                        <button class="action-btn">
                                            <i class="fa fa-share-alt"></i>
                                        </button>
                                        <button class="action-btn">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Internship Card 3 -->
                        <div class="internship-card">
                            <div class="internship-header">
                                <div style="flex: 1;">
                                    <a href="{{ route('internship.detail') }}">
                                        <h3 class="internship-title">Campus Relations Internship</h3>
                                        <p class="company-name">Skill Vedanth</p>
                                    </a>
                                </div>
                                <img src="{{ asset('assets/imgs/favicons.png') }}" alt="Logo" class="company-logo">
                            </div>

                            <div class="internship-meta">
                                <div class="meta-item">
                                    <i class="fa fa-briefcase"></i> No prior experience required
                                </div>
                                <div class="meta-item">
                                    <i class="fa fa-clock-o"></i> Part Time
                                </div>
                                <div class="meta-item">
                                    <i class="fa fa-map-marker"></i> Remote | Pan India
                                </div>
                            </div>

                            <div class="tags-container">
                                <span class="tag">Communication Skills</span>
                                <span class="tag">Microsoft Office Suite</span>
                                <span class="tag">Recruitment Strategy</span>
                                <span class="tag">+2</span>
                            </div>

                            <div class="student-levels">
                                <span class="level-tag">Undergraduate</span>
                                <span class="level-tag">Postgraduate</span>
                                <span class="level-tag">Engineering Students</span>
                                <span class="level-tag more-tag">+2</span>
                            </div>

                            <div class="internship-footer">
                                <div class="posted-info">
                                    Posted Feb 2, 2026 • <span class="deadline">13 days left</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div class="stipend">
                                        <i class="fa fa-check-circle"></i> ₹2.5K - 25K/Month
                                    </div>
                                    <div class="card-actions" style="position: static;">
                                        <button class="action-btn">
                                            <i class="fa fa-share-alt"></i>
                                        </button>
                                        <button class="action-btn active">
                                            <i class="fa fa-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Internship Card 4 -->
                        <div class="internship-card">
                            <div class="internship-header">
                                <div style="flex: 1;">
                                    <a href="{{ route('internship.detail') }}">
                                        <h3 class="internship-title">Digital Marketing Internship</h3>
                                        <p class="company-name">Tech Solutions Pvt Ltd</p>
                                    </a>
                                </div>
                                <img src="{{ asset('assets/imgs/favicons.png') }}" alt="Logo" class="company-logo">
                            </div>

                            <div class="internship-meta">
                                <div class="meta-item">
                                    <i class="fa fa-briefcase"></i> 0-6 months experience
                                </div>
                                <div class="meta-item">
                                    <i class="fa fa-clock-o"></i> Full Time
                                </div>
                                <div class="meta-item">
                                    <i class="fa fa-map-marker"></i> Bangalore | Hybrid
                                </div>
                            </div>

                            <div class="tags-container">
                                <span class="tag">SEO</span>
                                <span class="tag">Google Analytics</span>
                                <span class="tag">Content Writing</span>
                                <span class="tag">+3</span>
                            </div>

                            <div class="student-levels">
                                <span class="level-tag">Undergraduate</span>
                                <span class="level-tag">Postgraduate</span>
                                <span class="level-tag">MBA Students</span>
                            </div>

                            <div class="internship-footer">
                                <div class="posted-info">
                                    Posted Feb 1, 2026 • <span class="deadline">10 days left</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div class="stipend">
                                        <i class="fa fa-check-circle"></i> ₹10K - 15K/Month
                                    </div>
                                    <div class="card-actions" style="position: static;">
                                        <button class="action-btn">
                                            <i class="fa fa-share-alt"></i>
                                        </button>
                                        <button class="action-btn">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Internship Card 5 -->
                        <div class="internship-card">
                            <div class="internship-header">
                                <div style="flex: 1;">
                                    <a href="{{ route('internship.detail') }}">
                                        <h3 class="internship-title">Web Development Internship</h3>
                                        <p class="company-name">CodeCraft Solutions</p>
                                    </a>
                                </div>
                                <img src="{{ asset('assets/imgs/favicons.png') }}" alt="Logo" class="company-logo">
                            </div>

                            <div class="internship-meta">
                                <div class="meta-item">
                                    <i class="fa fa-briefcase"></i> Basic knowledge required
                                </div>
                                <div class="meta-item">
                                    <i class="fa fa-clock-o"></i> Part Time
                                </div>
                                <div class="meta-item">
                                    <i class="fa fa-map-marker"></i> Remote
                                </div>
                            </div>

                            <div class="tags-container">
                                <span class="tag">HTML/CSS</span>
                                <span class="tag">JavaScript</span>
                                <span class="tag">React JS</span>
                                <span class="tag">+2</span>
                            </div>

                            <div class="student-levels">
                                <span class="level-tag">Undergraduate</span>
                                <span class="level-tag">Engineering Students</span>
                                <span class="level-tag">BCA/MCA Students</span>
                            </div>

                            <div class="internship-footer">
                                <div class="posted-info">
                                    Posted Jan 31, 2026 • <span class="deadline">7 days left</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div class="stipend">
                                        <i class="fa fa-check-circle"></i> ₹8K - 12K/Month
                                    </div>
                                    <div class="card-actions" style="position: static;">
                                        <button class="action-btn">
                                            <i class="fa fa-share-alt"></i>
                                        </button>
                                        <button class="action-btn">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Sidebar -->
                    <div class="col-lg-4">
                        <div class="featured-sidebar">
                            <h4 class="sidebar-title">Featured Opportunities</h4>

                            <div class="featured-item">
                                <div class="featured-logo">
                                    <i class="fa fa-code" style="font-size: 20px;"></i>
                                </div>
                                <div class="featured-info">
                                    <h6>Deconstruct Skincare Internship - Season 2</h6>
                                    <span class="featured-type">Job</span>
                                </div>
                            </div>

                            <div class="featured-item">
                                <div class="featured-logo">
                                    <i class="fa fa-trophy" style="font-size: 20px;"></i>
                                </div>
                                <div class="featured-info">
                                    <h6>PPIs at L'Oreal + Intrapreneurship & Internation...</h6>
                                    <span class="featured-type">Competition</span>
                                </div>
                            </div>

                            <div class="featured-item">
                                <div class="featured-logo">
                                    <i class="fa fa-gift" style="font-size: 20px;"></i>
                                </div>
                                <div class="featured-info">
                                    <h6>L&T CreaTech 2026: PPIs and Cash Prize worth INR 2.25 Lakh!</h6>
                                    <span class="featured-type">Competition</span>
                                </div>
                            </div>

                            <div class="featured-item">
                                <div class="featured-logo">
                                    <i class="fa fa-mobile" style="font-size: 20px;"></i>
                                </div>
                                <div class="featured-info">
                                    <h6>International Offers, iPhone 17 & much more!</h6>
                                    <span class="featured-type">Hackathons</span>
                                </div>
                            </div>

                            <div class="featured-item">
                                <div class="featured-logo">
                                    <i class="fa fa-lightbulb-o" style="font-size: 20px;"></i>
                                </div>
                                <div class="featured-info">
                                    <h6>L&T OutThink 2026: PPIs and Cash Prize worth INR 2.25 Lakh!</h6>
                                    <span class="featured-type">Competition</span>
                                </div>
                            </div>

                            <div class="featured-item">
                                <div class="featured-logo">
                                    <i class="fa fa-users" style="font-size: 20px;"></i>
                                </div>
                                <div class="featured-info">
                                    <h6>Polycab Hiring Challenge</h6>
                                    <span class="featured-type">Job</span>
                                </div>
                            </div>

                            <div class="featured-item">
                                <div class="featured-logo">
                                    <i class="fa fa-rocket" style="font-size: 20px;"></i>
                                </div>
                                <div class="featured-info">
                                    <h6>Startup Innovation Challenge 2026</h6>
                                    <span class="featured-type">Competition</span>
                                </div>
                            </div>

                            <div class="featured-item">
                                <div class="featured-logo">
                                    <i class="fa fa-graduation-cap" style="font-size: 20px;"></i>
                                </div>
                                <div class="featured-info">
                                    <h6>Summer Training Program</h6>
                                    <span class="featured-type">Training</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
