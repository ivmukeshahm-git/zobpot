@extends('website.layout.layout')

@section('website-content')
    <style>

        #preloader-active{
            display: none;
        }
        .internship-detail-page {
            background: #f8f9fa;
            padding: 30px 0;
        }

        .internship-detail-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-title-section {
            flex: 1;
        }

        .remote-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f0f4ff;
            color: #3b7ddd;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .remote-badge i {
            font-size: 12px;
        }

        .detail-title {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .detail-company {
            font-size: 16px;
            color: #7f8c8d;
            font-weight: 400;
        }

        .company-logo-large {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #e0e0e0;
        }

        .detail-actions {
            display: flex;
            gap: 12px;
            margin-top: 12px;
        }

        .detail-action-btn {
            background: white;
            border: 1px solid #ddd;
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            color: #555;
        }

        .detail-action-btn:hover {
            border-color: #3b7ddd;
            color: #3b7ddd;
            background: #f0f4ff;
        }

        .detail-action-btn.active {
            background: #3b7ddd;
            color: white;
            border-color: #3b7ddd;
        }

        .section-block {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
            padding-left: 12px;
            border-left: 4px solid #3b7ddd;
        }

        .eligibility-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .eligibility-tag {
            background: #f8f9fa;
            color: #555;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            border: 1px solid #e0e0e0;
        }

        .details-content {
            font-size: 15px;
            line-height: 1.8;
            color: #555;
        }

        .details-content p {
            margin-bottom: 15px;
        }

        .details-content ul {
            padding-left: 20px;
            margin-bottom: 15px;
        }

        .details-content ul li {
            margin-bottom: 10px;
            color: #555;
        }

        .read-more-btn {
            background: transparent;
            border: none;
            color: #3b7ddd;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 0;
            transition: all 0.3s ease;
        }

        .read-more-btn:hover {
            color: #2d5fb8;
        }

        .warning-box {
            background: #fff8e1;
            border: 1px solid #ffe082;
            border-radius: 8px;
            padding: 15px 15px 15px 45px;
            position: relative;
            font-size: 13px;
            color: #856404;
            line-height: 1.6;
        }

        .warning-box::before {
            content: "\f06a";
            font-family: FontAwesome;
            position: absolute;
            left: 15px;
            top: 15px;
            font-size: 20px;
            color: #ffa726;
        }

        .dates-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .date-item {
            display: flex;
            align-items: center;
            gap: 15px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }

        .date-calendar {
            background: #3b7ddd;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .date-day {
            font-size: 24px;
            font-weight: 700;
            line-height: 1;
        }

        .date-month {
            font-size: 11px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .date-info {
            flex: 1;
        }

        .date-time {
            font-size: 14px;
            color: #555;
            margin-bottom: 3px;
        }

        .date-label {
            font-size: 13px;
            color: #7f8c8d;
        }

        .info-section {
            background: transparent;
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 16px;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            padding: 18px 18px 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #eef2f7;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .info-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #3b7ddd, #00c6ff);
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            border-color: #dbe4f3;
        }

        .info-head {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .info-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #f0f4ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3b7ddd;
            font-size: 20px;
            border: 1px solid #e3e9f5;
            flex-shrink: 0;
        }

        .info-title {
            font-size: 15px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }

        .info-body {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
        }

        .badge-soft {
            display: inline-block;
            background: #eef4ff;
            color: #3b7ddd;
            padding: 6px 10px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 12px;
        }

        .perks-list {
            list-style: none;
            padding-left: 0;
            margin: 0;
            display: grid;
            gap: 6px;
        }

        .perks-list li {
            font-size: 14px;
            color: #555;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .perks-list li::before {
            content: "\f00c";
            font-family: FontAwesome;
            color: #3b7ddd;
            font-weight: 700;
            font-size: 12px;
        }

        /* Sidebar Styles */
        .apply-sidebar {
            position: sticky;
            top: 20px;
        }

        .deadline-banner {
            background: #2c3e50;
            color: white;
            padding: 12px 20px;
            border-radius: 12px 12px 0 0;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .deadline-banner::after {
            content: "";
            position: absolute;
            top: 0;
            right: 30px;
            width: 0;
            height: 0;
            border-left: 15px solid transparent;
            border-right: 0px solid transparent;
            border-top: 12px solid #1a1a1a;
        }

        .apply-card {
            background: white;
            border-radius: 0 0 12px 12px;
            padding: 25px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .welcome-section {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .welcome-icon {
            font-size: 24px;
        }

        .welcome-text h4 {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 2px;
        }

        .welcome-text p {
            font-size: 13px;
            color: #7f8c8d;
            margin: 0;
        }

        .quick-apply-btn {
            background: #0066ff;
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quick-apply-btn:hover {
            background: #0052cc;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
        }

        .refer-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .refer-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .refer-icon {
            font-size: 40px;
        }

        .refer-text h4 {
            color: white;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .refer-text p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 13px;
            margin: 0;
        }

        .refer-btn {
            background: white;
            color: #667eea;
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .featured-sidebar {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
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
            border-radius: 10px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid #eef2f7;
        }

        .featured-item:hover {
            background: #f8f9fa;
            border-color: #dbe4f3;
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
            font-weight: 700;
            color: #3b7ddd;
            flex-shrink: 0;
            font-size: 12px;
            text-align: center;
            padding: 4px;
            border: 1px solid #e3e9f5;
        }

        .featured-info h6 {
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .featured-meta {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            font-size: 12px;
            color: #7f8c8d;
            align-items: center;
        }

        .featured-tag {
            background: #eef4ff;
            color: #3b7ddd;
            padding: 4px 8px;
            border-radius: 8px;
            font-weight: 600;
        }

        /* Field display blocks pulled from company-profile form fields */
        .field-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            margin-bottom: 10px;
        }

        .field-card {
            background: transparent;
            border-radius: 12px;
            padding: 20px;
            border: 2px solid #e3e9f5;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }

        .field-card:hover {
            border-color: #3b7ddd;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(59, 125, 221, 0.12);
        }

        .field-card.highlight {
            background: transparent;
            border: 2px solid #3b7ddd;
            box-shadow: 0 4px 16px rgba(59, 125, 221, 0.15);
        }

        .field-card.highlight:hover {
            box-shadow: 0 8px 24px rgba(59, 125, 221, 0.2);
            border-color: #2d5fb8;
        }

        .field-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            border-radius: 10px;
            border: 2px solid;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s ease;
        }

        .field-card:hover .field-icon {
            transform: scale(1.08);
        }

        .field-icon.icon-blue {
            color: #3b7ddd;
            border-color: #3b7ddd;
        }

        .field-icon.icon-purple {
            color: #6366f1;
            border-color: #6366f1;
        }

        .field-icon.icon-green {
            color: #10b981;
            border-color: #10b981;
        }

        .field-icon.icon-orange {
            color: #f59e0b;
            border-color: #f59e0b;
        }

        .field-icon.icon-red {
            color: #ef4444;
            border-color: #ef4444;
        }

        .field-icon.icon-teal {
            color: #14b8a6;
            border-color: #14b8a6;
        }

        .field-icon.icon-indigo {
            color: #8b5cf6;
            border-color: #8b5cf6;
        }

        .field-icon.icon-pink {
            color: #ec4899;
            border-color: #ec4899;
        }

        .field-content-wrap {
            flex: 1;
            min-width: 0;
        }

        .field-label {
            font-size: 11px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 6px;
            font-weight: 600;
            display: block;
        }

        .field-value {
            font-size: 16px;
            color: #1e293b;
            font-weight: 600;
            line-height: 1.5;
            word-break: break-word;
        }

        .meta-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 6px;
        }

        .meta-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f5f5f5;
            color: #555;
            padding: 5px 12px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 12px;
            border: 1px solid #e0e0e0;
        }

        .skills-stack {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 6px;
        }

        .skill-chip {
            background: #f0f4ff;
            color: #1f3c88;
            padding: 8px 12px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 13px;
            border: 1px solid #dbe4f3;
        }

        .editor-display {
            background: white;
            border: 1px dashed #dbe4f3;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            margin-bottom: 18px;
        }

        .editor-display h5 {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #7f8c8d;
            margin-bottom: 10px;
        }

        .editor-display p {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #4a5568;
            line-height: 1.7;
        }

        .fees-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
        }

        .fees-card {
            background: #0f172a;
            color: white;
            border-radius: 14px;
            padding: 18px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.2);
            margin-bottom: 20px;
        }

        .fees-card .field-label {
            color: rgba(255, 255, 255, 0.7);
        }

        .fees-card .field-value {
            color: white;
        }

        .timeline-card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            border: 1px solid #eef2f7;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            margin-bottom: 18px;
        }

        .timeline-row {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 12px;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px dashed #e5e7eb;
        }

        .timeline-row:last-child {
            border-bottom: none;
        }

        .timeline-label {
            font-weight: 700;
            color: #2c3e50;
            font-size: 14px;
        }

        .timeline-value {
            color: #4a5568;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .detail-header {
                flex-direction: column;
            }

            .company-logo-large {
                margin-top: 15px;
            }

            .detail-title {
                font-size: 22px;
            }
        }

        /* Modal Styles */
        .form-control:focus,
        .form-select:focus {
            border-color: #667eea !important;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15) !important;
            outline: none;
        }

        .modal.fade .modal-dialog {
            transform: scale(0.8);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .modal.show .modal-dialog {
            transform: scale(1);
            opacity: 1;
        }

        .billing-summary {
            animation: slideInDown 0.5s ease;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <main class="main">
        <section class="section-box">
            <div class="breacrumb-cover bg-img-about">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="mb-10">Internship Details</h2>
                            <p class="font-lg color-text-paragraph-2">Complete information about the internship opportunity
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="internship-detail-page">
            <div class="container">
                <div class="row">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <!-- Header Card -->
                        <div class="internship-detail-card">
                            <div class="detail-header">
                                <div class="detail-title-section">
                                    <div class="remote-badge">
                                        <i class="fa fa-map-marker"></i> Remote
                                    </div>
                                    <h1 class="detail-title">Full-Stack Web Development Internship</h1>
                                    <p class="detail-company">CodeCraft Solutions Pvt Ltd</p>
                                </div>
                                <div>
                                    <img src="{{ asset('assets/imgs/favicons.png') }}" alt="CodeCraft Solutions"
                                        class="company-logo-large">
                                    <div class="detail-actions">
                                        <button class="detail-action-btn" title="Save">
                                            <i class="fa fa-bookmark-o"></i>
                                        </button>
                                        <button class="detail-action-btn" title="Like">
                                            <i class="fa fa-heart-o"></i>
                                        </button>
                                        <button class="detail-action-btn" title="Share">
                                            <i class="fa fa-share-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Internship Information -->
                            <div class="section-block">
                                <h3 class="section-title">Internship Information</h3>
                                <div class="field-grid">
                                    <div class="field-card highlight">
                                        <div class="field-icon icon-blue">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="field-content-wrap">
                                            <span class="field-label">Position Title</span>
                                            <div class="field-value">Full-Stack Web Development Intern</div>
                                        </div>
                                    </div>
                                    <div class="field-card">
                                        <div class="field-icon icon-purple">
                                            <i class="fa fa-tag"></i>
                                        </div>
                                        <div class="field-content-wrap">
                                            <span class="field-label">Category</span>
                                            <div class="field-value">Engineering / Technology</div>
                                        </div>
                                    </div>
                                    <div class="field-card">
                                        <div class="field-icon icon-indigo">
                                            <i class="fa fa-building"></i>
                                        </div>
                                        <div class="field-content-wrap">
                                            <span class="field-label">Company Name</span>
                                            <div class="field-value">CodeCraft Solutions Pvt Ltd</div>
                                        </div>
                                    </div>
                                    <div class="field-card">
                                        <div class="field-icon icon-teal">
                                            <i class="fa fa-globe"></i>
                                        </div>
                                        <div class="field-content-wrap">
                                            <span class="field-label">Company Website</span>
                                            <div class="field-value"><a href="https://codecraft.example.com" target="_blank"
                                                    style="color: #14b8a6; text-decoration: underline;">codecraft.example.com</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-card">
                                        <div class="field-icon icon-blue">
                                            <i class="fa fa-laptop"></i>
                                        </div>
                                        <div class="field-content-wrap">
                                            <span class="field-label">Work Mode</span>
                                            <div class="field-value">Hybrid</div>
                                        </div>
                                    </div>
                                    <div class="field-card">
                                        <div class="field-icon icon-red">
                                            <i class="fa fa-map-marker"></i>
                                        </div>
                                        <div class="field-content-wrap">
                                            <span class="field-label">Location</span>
                                            <div class="field-value">Ahmedabad, Gujarat</div>
                                        </div>
                                    </div>
                                    <div class="field-card">
                                        <div class="field-icon icon-purple">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <div class="field-content-wrap">
                                            <span class="field-label">Duration</span>
                                            <div class="field-value">3 Months</div>
                                        </div>
                                    </div>
                                    <div class="field-card">
                                        <div class="field-icon icon-indigo">
                                            <i class="fa fa-calendar-check-o"></i>
                                        </div>
                                        <div class="field-content-wrap">
                                            <span class="field-label">Total Weeks</span>
                                            <div class="field-value">12 Weeks</div>
                                        </div>
                                    </div>
                                    <div class="field-card">
                                        <div class="field-icon icon-teal">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <div class="field-content-wrap">
                                            <span class="field-label">Total Hours</span>
                                            <div class="field-value">180 Hours</div>
                                        </div>
                                    </div>
                                    <div class="field-card highlight">
                                        <div class="field-icon icon-green">
                                            <i class="fa fa-money"></i>
                                        </div>
                                        <div class="field-content-wrap">
                                            <span class="field-label">Monthly Stipend</span>
                                            <div class="field-value">₹8,000</div>
                                        </div>
                                    </div>
                                    <div class="field-card">
                                        <div class="field-icon icon-orange">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="field-content-wrap">
                                            <span class="field-label">Openings</span>
                                            <div class="field-value">5 Positions</div>
                                        </div>
                                    </div>
                                    <div class="field-card">
                                        <div class="field-icon icon-pink">
                                            <i class="fa fa-calendar-o"></i>
                                        </div>
                                        <div class="field-content-wrap">
                                            <span class="field-label">Working Days</span>
                                            <div class="field-value">5 Days / Week</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Schedule & Deadlines -->
                            <div class="section-block">
                                <h3 class="section-title">Schedule & Deadlines</h3>
                                <div class="timeline-card">
                                    <div class="timeline-row">
                                        <div class="timeline-label"><i class="fa fa-calendar-check-o"></i> Start Date
                                        </div>
                                        <div class="timeline-value">10 Mar 2026</div>
                                    </div>
                                    <div class="timeline-row">
                                        <div class="timeline-label"><i class="fa fa-flag-checkered"></i> End Date</div>
                                        <div class="timeline-value">10 Jun 2026</div>
                                    </div>
                                    <div class="timeline-row">
                                        <div class="timeline-label"><i class="fa fa-hourglass-half"></i> Application
                                            Deadline</div>
                                        <div class="timeline-value">28 Feb 2026 (26 days left)</div>
                                    </div>
                                    <div class="timeline-row">
                                        <div class="timeline-label"><i class="fa fa-calendar"></i> Batch Days</div>
                                        <div class="timeline-value">
                                            <span class="meta-pill">Monday</span>
                                            <span class="meta-pill">Wednesday</span>
                                            <span class="meta-pill">Friday</span>
                                        </div>
                                    </div>
                                    <div class="timeline-row">
                                        <div class="timeline-label"><i class="fa fa-clock-o"></i> Time Slots</div>
                                        <div class="timeline-value">
                                            <span class="meta-pill">Slot A: 10:00 AM - 1:00 PM</span>
                                            <span class="meta-pill">Slot B: 3:00 PM - 6:00 PM</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Program Description -->
                            <div class="section-block">
                                <h3 class="section-title">Internship Description</h3>
                                <div class="details-content">
                                    <p>Join our dynamic engineering team and gain hands-on experience in full-stack web
                                        development. This internship offers a perfect blend of learning and practical
                                        application, where you'll work on real-world projects alongside experienced
                                        developers.</p>

                                    <p><strong>What You'll Do:</strong></p>
                                    <ul>
                                        <li>Build responsive web modules and components using modern frameworks</li>
                                        <li>Fix UI bugs and deliver pixel-perfect designs that integrate seamlessly with
                                            backend APIs</li>
                                        <li>Participate in code reviews and collaborative development sessions</li>
                                        <li>Learn version control best practices and agile development methodologies</li>
                                    </ul>

                                    <div class="warning-box mt-4">
                                        <strong>Important:</strong> If an employer asks you to pay any security deposit or
                                        registration fee, please report immediately. We do not charge candidates for
                                        internship applications.
                                    </div>
                                </div>
                            </div>

                            <!-- Skills & Eligibility -->
                            <div class="section-block">
                                <h3 class="section-title">Skills & Eligibility</h3>
                                <div class="field-card">
                                    <div class="field-label">Required Skills</div>
                                    <div class="skills-stack">
                                        <span class="skill-chip"><i class="fa fa-check-circle"></i> HTML & CSS</span>
                                        <span class="skill-chip"><i class="fa fa-check-circle"></i> JavaScript</span>
                                        <span class="skill-chip"><i class="fa fa-check-circle"></i> React</span>
                                        <span class="skill-chip"><i class="fa fa-check-circle"></i> Git & GitHub</span>
                                        <span class="skill-chip"><i class="fa fa-check-circle"></i> REST APIs</span>
                                    </div>
                                </div>
                                <div class="field-card" style="margin-top:12px;">
                                    <div class="field-label">Eligibility Criteria</div>
                                    <div class="skills-stack">
                                        <span class="skill-chip"><i class="fa fa-graduation-cap"></i> Final-year
                                            students</span>
                                        <span class="skill-chip"><i class="fa fa-code"></i> Minimum 1 live project</span>
                                        <span class="skill-chip"><i class="fa fa-clock-o"></i> 12 weeks
                                            availability</span>
                                        <span class="skill-chip"><i class="fa fa-comments"></i> Good communication</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Program Content -->
                            <div class="section-block">
                                <h3 class="section-title">Program Details</h3>
                             
                                <div class="editor-display">
                                    <h5><i class="fa fa-book"></i> Module Brief</h5>
                                    <p>Weekly sprints covering layout systems, component libraries, API consumption,
                                        authentication, and deployment fundamentals. Each module includes practical
                                        assignments and mentor reviews.</p>
                                </div>
                                <div class="editor-display">
                                    <h5><i class="fa fa-bullseye"></i> Learning Objectives</h5>
                                    <p>Enable interns to ship production-ready features, follow version control best
                                        practices, and collaborate in agile ceremonies. Master modern development workflows
                                        and industry-standard tools.</p>
                                </div>
                                <div class="editor-display">
                                    <h5><i class="fa fa-trophy"></i> Expected Outcomes</h5>
                                    <p>By the end of the internship, participants will have a deployed portfolio project,
                                        code reviews from mentors, and a verified completion certificate. Plus
                                        recommendation letter for top performers.</p>
                                </div>
                            </div>

                            <!-- Perks & Benefits -->
                            <div class="section-block">
                                <h3 class="section-title">Perks & Benefits</h3>
                                <div class="info-grid">
                                    <div class="info-card">
                                        <div class="info-icon"><i class="fa fa-certificate"></i></div>
                                        <div class="info-body">
                                            <strong>Certificate</strong>
                                            <p style="margin:5px 0 0 0; color:#7f8c8d; font-size:13px;">Completion
                                                certificate upon successful finish</p>
                                        </div>
                                    </div>
                                    <div class="info-card">
                                        <div class="info-icon"><i class="fa fa-star"></i></div>
                                        <div class="info-body">
                                            <strong>Recommendation</strong>
                                            <p style="margin:5px 0 0 0; color:#7f8c8d; font-size:13px;">LOR for outstanding
                                                performers</p>
                                        </div>
                                    </div>
                                    <div class="info-card">
                                        <div class="info-icon"><i class="fa fa-clock-o"></i></div>
                                        <div class="info-body">
                                            <strong>Flexible Hours</strong>
                                            <p style="margin:5px 0 0 0; color:#7f8c8d; font-size:13px;">Choose your
                                                preferred time slot</p>
                                        </div>
                                    </div>
                                    <div class="info-card">
                                        <div class="info-icon"><i class="fa fa-users"></i></div>
                                        <div class="info-body">
                                            <strong>Mentorship</strong>
                                            <p style="margin:5px 0 0 0; color:#7f8c8d; font-size:13px;">1-on-1 guidance
                                                from senior developers</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <div class="apply-sidebar">
                            <!-- Apply Card -->
                            <div style="position: relative;">
                                <div class="deadline-banner">
                                    14 Days Left
                                </div>
                                <div class="apply-card">
                                    <div class="welcome-section">
                                        <div class="welcome-icon">👋</div>
                                        <div class="welcome-text">
                                            <h4>Hi Welcome!</h4>
                                            <p>Please register below.</p>
                                        </div>
                                    </div>
                                    <button class="quick-apply-btn">Quick Apply</button>
                                </div>
                            </div>


                            <!-- Recent Internships -->
                            <div class="featured-sidebar">
                                <h4 class="sidebar-title">Recent Internships</h4>

                                <div class="featured-item">
                                    <div class="featured-logo">TCH</div>
                                    <div class="featured-info">
                                        <h6>Techniche Campus Ambassador</h6>
                                        <div class="featured-meta">
                                            <span class="featured-tag">Remote</span>
                                            <span>Indian Institute of Technology (IIT), Guwahati</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="featured-item">
                                    <div class="featured-logo">EDU</div>
                                    <div class="featured-info">
                                        <h6>Community Management Internship</h6>
                                        <div class="featured-meta">
                                            <span class="featured-tag">Part Time</span>
                                            <span>Eduveda Academy</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="featured-item">
                                    <div class="featured-logo">SV</div>
                                    <div class="featured-info">
                                        <h6>Campus Relations Internship</h6>
                                        <div class="featured-meta">
                                            <span class="featured-tag">Remote</span>
                                            <span>Skill Vedanth</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="featured-item">
                                    <div class="featured-logo">TS</div>
                                    <div class="featured-info">
                                        <h6>Digital Marketing Internship</h6>
                                        <div class="featured-meta">
                                            <span class="featured-tag">Hybrid</span>
                                            <span>Tech Solutions Pvt Ltd</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="featured-item">
                                    <div class="featured-logo">CC</div>
                                    <div class="featured-info">
                                        <h6>Web Development Internship</h6>
                                        <div class="featured-meta">
                                            <span class="featured-tag">Remote</span>
                                            <span>CodeCraft Solutions</span>
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

    <!-- Internship Type Selection Modal -->
    <div class="modal fade" id="internshipTypeModal" tabindex="-1" aria-labelledby="internshipTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px;">
                <div class="modal-header p-3" style="background: #222b63; border: none; padding: 24px;">
                    <h5 class="modal-title text-white" id="internshipTypeModalLabel">
                        <i class="fa fa-plus-circle me-2"></i>Choose Internship Application Type
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 40px 30px;">
                    <h5 class="text-center text-muted mb-4" style="font-weight: 700">Select how you want to apply for the internship</h5>
                    <div class="row g-3">
                        <!-- Apply with College Option -->
                        <div class="col-6">
                            <div class="internship-type-card" id="applyWithCollege" style="cursor: pointer;">
                                <div class="card h-100 border-0 shadow-sm" style="transition: all 0.3s ease; border-radius: 12px;">
                                    <div class="card-body text-center p-4" style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);border: 2px solid #bebebe;border-radius: 12px;">
                                        <div class="icon-wrapper mb-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                            <i class="fa fa-building" style="font-size: 40px; color: white;"></i>
                                        </div>
                                        <h5 class="mb-2" style="color: #667eea; font-weight: 700;">Apply with College</h5>
                                        <p class="text-muted mb-0" style="font-size: 14px;">Apply for internship through your college or educational institution</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Apply Individually Option -->
                        <div class="col-6">
                            <div class="internship-type-card" id="applyIndividually" style="cursor: pointer;">
                                <div class="card h-100 border-0 shadow-sm" style="transition: all 0.3s ease; border-radius: 12px;">
                                    <div class="card-body text-center p-4" style="background: linear-gradient(135deg, #4facfe15 0%, #00f2fe15 100%);border: 2px solid #bebebe;border-radius: 12px;">
                                        <div class="icon-wrapper mb-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                            <i class="fa fa-user" style="font-size: 40px; color: white;"></i>
                                        </div>
                                        <h5 class="mb-2" style="color: #4facfe; font-weight: 700;">Apply Individually</h5>
                                        <p class="text-muted mb-0" style="font-size: 14px;">Apply for internship independently without college partnership</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .internship-type-card:hover .card {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
        }

        .internship-type-card:hover .icon-wrapper {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }

        .internship-type-card .card {
            border: 2px solid transparent;
        }

        .internship-type-card:hover .card {
            border: 2px solid #667eea;
        }

        #applyIndividually:hover .card {
            border: 2px solid #4facfe !important;
        }
    </style>

    <!-- College Information Modal -->
    <div class="modal fade" id="collegeInfoModal" tabindex="-1" aria-labelledby="collegeInfoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content"
                style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 16px 16px 0 0; padding: 25px 30px; border: none;">
                    <div>
                        <h5 class="modal-title" id="collegeInfoModalLabel"
                            style="font-size: 22px; font-weight: 700; margin: 0;color:#fff;">
                            <i class="fa fa-graduation-cap"></i> College Information
                        </h5>
                        <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;color:#fff;">Please provide your
                            academic details</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <form id="collegeInfoForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="university" class="form-label"
                                    style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; font-size: 14px;">
                                    <i class="fa fa-university" style="color: #667eea;"></i> University <span
                                        style="color: #e74c3c;">*</span>
                                </label>
                                <select class="form-select" id="university" name="university" required
                                    style="border: 2px solid #e0e0e0; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;">
                                    <option value="">Select University</option>
                                    <option value="Gujarat University">Gujarat University</option>
                                    <option value="Sardar Patel University">Sardar Patel University</option>
                                    <option value="Maharaja Sayajirao University">Maharaja Sayajirao University</option>
                                    <option value="Gujarat Technological University">Gujarat Technological University</option>
                                    <option value="Veer Narmad South Gujarat University">Veer Narmad South Gujarat University</option>
                                    <option value="Saurashtra University">Saurashtra University</option>
                                    <option value="Other">Other</option>
                                </select>
                                <input type="text" class="form-control mt-2" id="universityOther" name="universityOther" 
                                    placeholder="Enter University Name" style="border: 2px solid #e0e0e0; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s; display: none;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="college" class="form-label"
                                    style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; font-size: 14px;">
                                    <i class="fa fa-building" style="color: #667eea;"></i> College <span
                                        style="color: #e74c3c;">*</span>
                                </label>
                                <select class="form-select" id="college" name="college" required
                                    style="border: 2px solid #e0e0e0; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;">
                                    <option value="">Select College</option>
                                    <option value="Government Engineering College">Government Engineering College</option>
                                    <option value="Birla Vishvakarma Mahavidyalaya">Birla Vishvakarma Mahavidyalaya</option>
                                    <option value="L.D. College of Engineering">L.D. College of Engineering</option>
                                    <option value="Faculty of Technology & Engineering">Faculty of Technology & Engineering</option>
                                    <option value="Alpha Institute of Technology">Alpha Institute of Technology</option>
                                    <option value="Other">Other</option>
                                </select>
                                <input type="text" class="form-control mt-2" id="collegeOther" name="collegeOther" 
                                    placeholder="Enter College Name" style="border: 2px solid #e0e0e0; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s; display: none;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="degreeLevel" class="form-label"
                                    style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; font-size: 14px;">
                                    <i class="fa fa-certificate" style="color: #667eea;"></i> Degree Level <span
                                        style="color: #e74c3c;">*</span>
                                </label>
                                <select class="form-select" id="degreeLevel" name="degreeLevel" required
                                    style="border: 2px solid #e0e0e0; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;">
                                    <option value="">Select Degree Level</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="Bachelor">Bachelor's Degree</option>
                                    <option value="Master">Master's Degree</option>
                                    <option value="PhD">PhD</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="degree" class="form-label"
                                    style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; font-size: 14px;">
                                    <i class="fa fa-book" style="color: #667eea;"></i> Degree <span
                                        style="color: #e74c3c;">*</span>
                                </label>
                                <input type="text" class="form-control" id="degree" name="degree" required
                                    placeholder="e.g., Computer Science"
                                    style="border: 2px solid #e0e0e0; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="semester" class="form-label"
                                    style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; font-size: 14px;">
                                    <i class="fa fa-calendar" style="color: #667eea;"></i> Semester <span
                                        style="color: #e74c3c;">*</span>
                                </label>
                                <select class="form-select" id="semester" name="semester" required
                                    style="border: 2px solid #e0e0e0; border-radius: 10px; padding: 12px 16px; font-size: 14px; transition: all 0.3s;">
                                    <option value="">Select Semester</option>
                                    <option value="1">1st Semester</option>
                                    <option value="2">2nd Semester</option>
                                    <option value="3">3rd Semester</option>
                                    <option value="4">4th Semester</option>
                                    <option value="5">5th Semester</option>
                                    <option value="6">6th Semester</option>
                                    <option value="7">7th Semester</option>
                                    <option value="8">8th Semester</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"
                    style="border: none; padding: 20px 30px; background: #f8f9fa; border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; border: none;">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="submitCollegeInfo"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; border: none;">
                        <i class="fa fa-arrow-right"></i> Continue to Payment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Internship Billing Modal -->
    <div class="modal fade" id="billingModal" tabindex="-1" aria-labelledby="billingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content"
                style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #0066ff 0%, #00c6ff 100%); color: white; border-radius: 16px 16px 0 0; padding: 25px 30px; border: none;">
                    <div>
                        <h5 class="modal-title" id="billingModalLabel"
                            style="font-size: 22px; font-weight: 700; margin: 0;color:#fff;">
                            <i class="fa fa-credit-card"></i> Payment Details
                        </h5>
                        <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;color:#fff;">Complete your internship
                            registration</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <!-- Order Summary -->
                    <div class="billing-summary"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 25px; margin-bottom: 25px; color: white;">
                        <h6
                            style="font-size: 16px; font-weight: 700; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;color:#fff">
                            <i class="fa fa-shopping-cart"></i> Order Summary
                        </h6>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                            <span>Internship Program</span>
                            <span style="font-weight: 600;">Full-Stack Web Development</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                            <span>Duration</span>
                            <span style="font-weight: 600;">3 Months</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                            <span>Registration Fee</span>
                            <span style="font-weight: 600;">₹2,000</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                            <span>GST (18%)</span>
                            <span style="font-weight: 600;">₹360</span>
                        </div>
                        <hr style="border-color: rgba(255,255,255,0.3); margin: 15px 0;">
                        <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: 700;">
                            <span>Total Amount</span>
                            <span>₹2,360</span>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <form id="billingForm">
                        <div id="cardDetails" style="display: none;">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="cardNumber" class="form-label"
                                        style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; font-size: 14px;">
                                        <i class="fa fa-credit-card-alt" style="color: #0066ff;"></i> Card Number
                                    </label>
                                    <input type="text" class="form-control" id="cardNumber" name="cardNumber"
                                        placeholder="1234 5678 9012 3456" maxlength="19"
                                        style="border: 2px solid #e0e0e0; border-radius: 10px; padding: 12px 16px; font-size: 14px;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="expiryDate" class="form-label"
                                        style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; font-size: 14px;">
                                        <i class="fa fa-calendar" style="color: #0066ff;"></i> Expiry Date
                                    </label>
                                    <input type="text" class="form-control" id="expiryDate" name="expiryDate"
                                        placeholder="MM/YY" maxlength="5"
                                        style="border: 2px solid #e0e0e0; border-radius: 10px; padding: 12px 16px; font-size: 14px;">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cvv" class="form-label"
                                        style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; font-size: 14px;">
                                        <i class="fa fa-lock" style="color: #0066ff;"></i> CVV
                                    </label>
                                    <input type="text" class="form-control" id="cvv" name="cvv"
                                        placeholder="123" maxlength="3"
                                        style="border: 2px solid #e0e0e0; border-radius: 10px; padding: 12px 16px; font-size: 14px;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="cardholderName" class="form-label"
                                    style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; font-size: 14px;">
                                    <i class="fa fa-user" style="color: #0066ff;"></i> Cardholder Name
                                </label>
                                <input type="text" class="form-control" id="cardholderName" name="cardholderName"
                                    placeholder="Name on card"
                                    style="border: 2px solid #e0e0e0; border-radius: 10px; padding: 12px 16px; font-size: 14px;">
                            </div>
                        </div>

                        <div id="upiDetails" style="display: none;">
                            <div class="mb-3">
                                <label for="upiId" class="form-label"
                                    style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; font-size: 14px;">
                                    <i class="fa fa-mobile" style="color: #0066ff;"></i> UPI ID
                                </label>
                                <input type="text" class="form-control" id="upiId" name="upiId"
                                    placeholder="yourname@upi"
                                    style="border: 2px solid #e0e0e0; border-radius: 10px; padding: 12px 16px; font-size: 14px;">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"
                    style="border: none; padding: 20px 30px; background: #f8f9fa; border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-secondary" id="backToCollegeInfo"
                        style="padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; border: none;">
                        <i class="fa fa-arrow-left"></i> Back
                    </button>
                    <button type="button" class="btn btn-success" id="submitPayment"
                        style="background: linear-gradient(135deg, #0066ff 0%, #00c6ff 100%); padding: 12px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; border: none;">
                        <i class="fa fa-check"></i> Pay ₹2,360
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        (function() {
            'use strict';

            if (typeof bootstrap === 'undefined') {
                console.error('Bootstrap is not loaded');
                return;
            }

            // Set page active ID
            if (typeof page_active_id !== 'undefined') {
                page_active_id = "internship";
            }

            // Wait for DOM to be ready
            function initModals() {
                // Get modal instances
                const internshipTypeModal = new bootstrap.Modal(document.getElementById('internshipTypeModal'));
                const collegeInfoModal = new bootstrap.Modal(document.getElementById('collegeInfoModal'));
                const billingModal = new bootstrap.Modal(document.getElementById('billingModal'));

                // Show/Hide Other University Field
                document.getElementById('university').addEventListener('change', function() {
                    const otherField = document.getElementById('universityOther');
                    if (this.value === 'Other') {
                        otherField.style.display = 'block';
                        otherField.required = true;
                    } else {
                        otherField.style.display = 'none';
                        otherField.required = false;
                        otherField.value = '';
                    }
                });

                // Show/Hide Other College Field
                document.getElementById('college').addEventListener('change', function() {
                    const otherField = document.getElementById('collegeOther');
                    if (this.value === 'Other') {
                        otherField.style.display = 'block';
                        otherField.required = true;
                    } else {
                        otherField.style.display = 'none';
                        otherField.required = false;
                        otherField.value = '';
                    }
                });

                // Quick Apply Button - Open Internship Type Selection Modal
                document.querySelector('.quick-apply-btn').addEventListener('click', function() {
                    internshipTypeModal.show();
                });

                // Apply with College - Open College Info Modal
                document.getElementById('applyWithCollege').addEventListener('click', function() {
                    internshipTypeModal.hide();
                    setTimeout(() => {
                        collegeInfoModal.show();
                    }, 300);
                });

                // Apply Individually - Open Billing Modal Directly
                document.getElementById('applyIndividually').addEventListener('click', function() {
                    internshipTypeModal.hide();
                    setTimeout(() => {
                        billingModal.show();
                    }, 300);
                });

                // Submit College Info - Open Billing Modal
                document.getElementById('submitCollegeInfo').addEventListener('click', function() {
                    const form = document.getElementById('collegeInfoForm');

                    if (form.checkValidity()) {
                        // Get university value (use 'Other' field if selected)
                        const universitySelect = document.getElementById('university');
                        const universityValue = universitySelect.value === 'Other' ? 
                            document.getElementById('universityOther').value : 
                            universitySelect.value;

                        // Get college value (use 'Other' field if selected)
                        const collegeSelect = document.getElementById('college');
                        const collegeValue = collegeSelect.value === 'Other' ? 
                            document.getElementById('collegeOther').value : 
                            collegeSelect.value;

                        // Store college info (you can send to server here)
                        const collegeInfo = {
                            university: universityValue,
                            college: collegeValue,
                            degreeLevel: document.getElementById('degreeLevel').value,
                            degree: document.getElementById('degree').value,
                            semester: document.getElementById('semester').value
                        };

                        console.log('College Info:', collegeInfo);

                        // Close college info modal and open billing modal
                        collegeInfoModal.hide();
                        setTimeout(() => {
                            billingModal.show();
                        }, 300);
                    } else {
                        form.reportValidity();
                    }
                });

                // Back to College Info from Billing
                document.getElementById('backToCollegeInfo').addEventListener('click', function() {
                    billingModal.hide();
                    setTimeout(() => {
                        collegeInfoModal.show();
                    }, 300);
                });

                // Payment Method Change - Show/Hide relevant fields
                document.getElementById('paymentMethod').addEventListener('change', function() {
                    const cardDetails = document.getElementById('cardDetails');
                    const upiDetails = document.getElementById('upiDetails');
                    const netBankingDetails = document.getElementById('netBankingDetails');

                    // Hide all payment details
                    cardDetails.style.display = 'none';
                    upiDetails.style.display = 'none';
                    netBankingDetails.style.display = 'none';

                    // Show relevant payment details
                    const selectedMethod = this.value;
                    if (selectedMethod === 'credit-card' || selectedMethod === 'debit-card') {
                        cardDetails.style.display = 'block';
                    } else if (selectedMethod === 'upi') {
                        upiDetails.style.display = 'block';
                    } else if (selectedMethod === 'net-banking') {
                        netBankingDetails.style.display = 'block';
                    }
                });

                // Format card number input
                document.getElementById('cardNumber')?.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s/g, '');
                    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                    e.target.value = formattedValue;
                });

                // Format expiry date
                document.getElementById('expiryDate')?.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.slice(0, 2) + '/' + value.slice(2, 4);
                    }
                    e.target.value = value;
                });

                // Submit Payment
                document.getElementById('submitPayment').addEventListener('click', function() {
                    const billingForm = document.getElementById('billingForm');
                    const paymentMethod = document.getElementById('paymentMethod').value;

                    if (!paymentMethod) {
                        alert('Please select a payment method');
                        return;
                    }

                    // Validate based on payment method
                    let isValid = true;
                    if (paymentMethod === 'credit-card' || paymentMethod === 'debit-card') {
                        const cardNumber = document.getElementById('cardNumber').value;
                        const expiryDate = document.getElementById('expiryDate').value;
                        const cvv = document.getElementById('cvv').value;
                        const cardholderName = document.getElementById('cardholderName').value;

                        if (!cardNumber || !expiryDate || !cvv || !cardholderName) {
                            alert('Please fill in all card details');
                            isValid = false;
                        }
                    } else if (paymentMethod === 'upi') {
                        const upiId = document.getElementById('upiId').value;
                        if (!upiId) {
                            alert('Please enter your UPI ID');
                            isValid = false;
                        }
                    } else if (paymentMethod === 'net-banking') {
                        const bankName = document.getElementById('bankName').value;
                        if (!bankName) {
                            alert('Please select a bank');
                            isValid = false;
                        }
                    }

                    if (isValid) {
                        // Process payment (you can send to server here)
                        const paymentData = {
                            paymentMethod: paymentMethod,
                            amount: 2360
                        };

                        console.log('Payment Data:', paymentData);

                        // Show success message
                        alert('Payment successful! Your internship application has been submitted.');

                        // Close modal and reset forms
                        billingModal.hide();
                        document.getElementById('collegeInfoForm').reset();
                        document.getElementById('billingForm').reset();
                    }
                });

                // Reset forms when modals are closed
                document.getElementById('collegeInfoModal').addEventListener('hidden.bs.modal', function() {
                    if (!document.getElementById('billingModal').classList.contains('show')) {
                        document.getElementById('collegeInfoForm').reset();
                    }
                });

                document.getElementById('billingModal').addEventListener('hidden.bs.modal', function() {
                    document.getElementById('billingForm').reset();
                    document.getElementById('cardDetails').style.display = 'none';
                    document.getElementById('upiDetails').style.display = 'none';
                    document.getElementById('netBankingDetails').style.display = 'none';
                });
            }

            // Initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initModals);
            } else {
                initModals();
            }
        })();
    </script>
@endpush
