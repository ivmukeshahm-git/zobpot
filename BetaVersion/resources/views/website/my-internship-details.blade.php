@extends('website.layout.layout')
@section('website-content')

<style>
    /* My Internship Details Page Styles */
    .internship-details-header {
        background: #242a62;
        border-radius: 12px;
        padding: 40px;
        margin-bottom: 30px;
        color: white;
        box-shadow: 0 4px 20px rgba(36, 42, 98, 0.3);
    }

    .internship-details-header h2 {
        margin: 0 0 10px 0;
        font-size: 32px;
        font-weight: 700;
    }

    .internship-details-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 16px;
    }

    /* Statistics Boxes */
    .stats-box {
        background: #eee;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        border-left: 4px solid;
        transition: all 0.3s ease;
    }

    .stats-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .stats-box .icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 15px;
    }

    .stats-box h3 {
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 5px 0;
    }

    .stats-box p {
        margin: 0;
        color: #6c757d;
        font-size: 14px;
        font-weight: 600;
    }

    /* Tab Navigation */
    .nav-tabs-internship {
        background: #fff;
        border-radius: 12px 12px 0 0;
        padding: 15px 20px 0 20px;
        border-bottom: 3px solid #242a62;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .nav-tabs-internship .nav-link {
        color: #666;
        border: none;
        border-bottom: 3px solid transparent;
        border-radius: 0;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        margin-bottom: -3px;
    }

    .nav-tabs-internship .nav-link:hover {
        color: #242a62;
        background: #fff5f0;
    }

    .nav-tabs-internship .nav-link.active {
        color: #242a62;
        background: transparent;
        border-bottom-color: #f26e2c;
    }

    .tab-content-card {
        background: #fff;
        border-radius: 0 0 12px 12px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    /* Section Card */
    .section-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 4px solid #242a62;
    }

    .section-card h6 {
        color: #242a62;
        font-weight: 700;
        margin-bottom: 15px;
        font-size: 16px;
    }

    /* Detail Row */
    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px dashed #dee2e6;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #495057;
        font-size: 14px;
        min-width: 200px;
    }

    .detail-value {
        color: #212529;
        font-size: 14px;
        flex: 1;
    }

    /* Task Card */
    .task-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border-left: 4px solid #17a2b8;
        transition: all 0.3s ease;
    }

    .task-card:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    /* Certificate Section */
    .certificate-box {
        background: #fff;
        border: 2px dashed #242a62;
        border-radius: 12px;
        padding: 40px;
        text-align: center;
    }

    .certificate-icon {
        width: 100px;
        height: 100px;
        background: #242a62;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 48px;
        color: white;
    }


    .modal-title{
        color: #fff!important;
    }
</style>

<main class="main mb-5">
    <section class="section-box">
        <div class="container">
            <!-- Header -->
            <div class="internship-details-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 style="color: #fff; margin: 0;"><i class="bx bx-briefcase"></i> Full-Stack Web Development</h2>
                        <p style="color: #fff; margin: 5px 0 0 0;"><i class="bx bx-buildings"></i> TechCorp Solutions Pvt. Ltd.</p>
                    </div>
                    <div class="d-flex align-items-center" style="gap: 15px;">
                        <a href="{{ route('candidate-profile') }}" class="btn-back-profile" style="background: rgba(255, 255, 255, 0.2); color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; border: 1px solid rgba(255, 255, 255, 0.3); transition: all 0.3s ease;" 
                           onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'; this.style.borderColor='rgba(255, 255, 255, 0.5)';" 
                           onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'; this.style.borderColor='rgba(255, 255, 255, 0.3)';">
                            <i class="bx bx-arrow-back"></i> Back to Profile
                        </a>
                        <button onclick="openReviewModal()" class="btn" style="background: #f26e2c; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; border: 1px solid #f26e2c; transition: all 0.3s ease;" 
                           onmouseover="this.style.background='#ff8c42'; this.style.borderColor='#ff8c42';" 
                           onmouseout="this.style.background='#f26e2c'; this.style.borderColor='#f26e2c';">
                            <i class="bx bx-star"></i> Give Review
                        </button>
                        <span class="badge" style="background: #28a745; color: white; padding: 10px 20px; font-size: 16px; border-radius: 8px;">
                            <i class="bx bx-check-circle"></i> Active
                        </span>
                    </div>
                </div>
            </div>

            <!-- Statistics Boxes -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                    <div class="stats-box" style="border-left-color: #17a2b8;">
                       
                        <h3 style="color: #17a2b8;">8</h3>
                        <p>Total Tasks</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                    <div class="stats-box" style="border-left-color: #28a745;">
                      
                        <h3 style="color: #28a745;">5</h3>
                        <p>Completed Tasks</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                    <div class="stats-box" style="border-left-color: #ffc107;">
                      
                        <h3 style="color: #ffc107;">3</h3>
                        <p>Pending Tasks</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                    <div class="stats-box" style="border-left-color: #dc3545;">
                       
                        <h3 style="color: #dc3545;">45</h3>
                        <p>Days Remaining</p>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs nav-tabs-internship" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#internship-details" type="button" role="tab">
                        <i class="bx bx-info-circle"></i> Internship Details
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#assigned-tasks" type="button" role="tab">
                        <i class="bx bx-task"></i> Assigned Tasks
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="certificate-tab" data-bs-toggle="tab" data-bs-target="#certificate" type="button" role="tab">
                        <i class="bx bx-certificate"></i> Certificate
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="instructions-tab" data-bs-toggle="tab" data-bs-target="#instructions" type="button" role="tab">
                        <i class="bx bx-file"></i> General Instructions
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content tab-content-card">
                <!-- Internship Details Tab -->
                <div class="tab-pane fade show active" id="internship-details" role="tabpanel">
                    <h5 style="color: #242a62; font-weight: 700; margin-bottom: 20px;">
                        <i class="bx bx-info-circle"></i> Internship Information
                    </h5>

                    <div class="section-card">
                        <h6><i class="bx bx-briefcase"></i> Basic Details</h6>
                        <div class="detail-row">
                            <span class="detail-label">Internship Title:</span>
                            <span class="detail-value">Full-Stack Web Development</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Company Name:</span>
                            <span class="detail-value">TechCorp Solutions Pvt. Ltd.</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Department:</span>
                            <span class="detail-value">Software Development</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Mode:</span>
                            <span class="detail-value">Hybrid (3 days office, 2 days remote)</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Location:</span>
                            <span class="detail-value">Bangalore, Karnataka</span>
                        </div>
                    </div>

                    <div class="section-card">
                        <h6><i class="bx bx-calendar"></i> Duration & Schedule</h6>
                        <div class="detail-row">
                            <span class="detail-label">Duration:</span>
                            <span class="detail-value">3 Months</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Start Date:</span>
                            <span class="detail-value">01 February 2026</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">End Date:</span>
                            <span class="detail-value">30 April 2026</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Working Hours:</span>
                            <span class="detail-value">9:00 AM - 6:00 PM</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Days per Week:</span>
                            <span class="detail-value">5 Days (Monday to Friday)</span>
                        </div>
                    </div>

                    <div class="section-card">
                        <h6><i class="bx bx-money"></i> Stipend & Benefits</h6>
                        <div class="detail-row">
                            <span class="detail-label">Monthly Stipend:</span>
                            <span class="detail-value">₹15,000</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Additional Benefits:</span>
                            <span class="detail-value">Certificate, Letter of Recommendation, Lunch Provided</span>
                        </div>
                    </div>

                    <div class="section-card">
                        <h6><i class="bx bx-user"></i> Mentor Details</h6>
                        <div class="detail-row">
                            <span class="detail-label">Mentor Name:</span>
                            <span class="detail-value">Mr. Rajesh Kumar</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Designation:</span>
                            <span class="detail-value">Senior Software Engineer</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Email:</span>
                            <span class="detail-value">rajesh.kumar@techcorp.com</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Contact:</span>
                            <span class="detail-value">+91 98765 43210</span>
                        </div>
                    </div>
                </div>

                <!-- Assigned Tasks Tab -->
                <div class="tab-pane fade" id="assigned-tasks" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                            <i class="bx bx-task"></i> Your Assigned Tasks
                        </h5>
                        <span class="badge" style="background: #17a2b8; color: white; font-size: 14px; padding: 8px 16px;">
                            5/8 Completed
                        </span>
                    </div>

                    <!-- Task Table -->
                    <div class="table-responsive">
                        <table class="table table-hover" style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                            <thead style="background: linear-gradient(135deg, #242a62 0%, #3a4799 100%); color: white;">
                                <tr>
                                    <th style="padding: 15px; font-weight: 600; font-size: 13px; border: none;">#</th>
                                    <th style="padding: 15px; font-weight: 600; font-size: 13px; border: none;">Task Title</th>
                                    <th style="padding: 15px; font-weight: 600; font-size: 13px; border: none;">Module</th>
                                    <th style="padding: 15px; font-weight: 600; font-size: 13px; border: none;">Due Date</th>
                                    <th style="padding: 15px; font-weight: 600; font-size: 13px; border: none;">Status</th>
                                    <th style="padding: 15px; font-weight: 600; font-size: 13px; border: none; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #f0f0f0;">
                                    <td style="padding: 15px; vertical-align: middle; color: #495057; font-weight: 600;">1</td>
                                    <td style="padding: 15px; vertical-align: middle;">
                                        <div style="color: #242a62; font-weight: 600; margin-bottom: 3px;">Setup Development Environment</div>
                                        <div style="color: #6c757d; font-size: 12px;">Configure IDE, Git, Node.js, and databases</div>
                                    </td>
                                    <td style="padding: 15px; vertical-align: middle; color: #6c757d; font-size: 13px;">Week 1</td>
                                    <td style="padding: 15px; vertical-align: middle; color: #6c757d; font-size: 13px;">05 Feb 2026</td>
                                    <td style="padding: 15px; vertical-align: middle;">
                                        <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 5px; font-size: 11px;">
                                            <i class="bx bx-check"></i> Completed
                                        </span>
                                    </td>
                                    <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                        <button class="btn btn-sm" onclick="viewTask(1)" style="background: #242a62; color: white; padding: 6px 12px; border-radius: 5px; font-weight: 600; border: none; font-size: 12px; margin-right: 5px;">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f0f0f0;">
                                    <td style="padding: 15px; vertical-align: middle; color: #495057; font-weight: 600;">2</td>
                                    <td style="padding: 15px; vertical-align: middle;">
                                        <div style="color: #242a62; font-weight: 600; margin-bottom: 3px;">Create Landing Page</div>
                                        <div style="color: #6c757d; font-size: 12px;">Responsive design with HTML5, CSS3, JavaScript</div>
                                    </td>
                                    <td style="padding: 15px; vertical-align: middle; color: #6c757d; font-size: 13px;">Week 2</td>
                                    <td style="padding: 15px; vertical-align: middle; color: #6c757d; font-size: 13px;">12 Feb 2026</td>
                                    <td style="padding: 15px; vertical-align: middle;">
                                        <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 5px; font-size: 11px;">
                                            <i class="bx bx-check"></i> Completed
                                        </span>
                                    </td>
                                    <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                        <button class="btn btn-sm" onclick="viewTask(2)" style="background: #242a62; color: white; padding: 6px 12px; border-radius: 5px; font-weight: 600; border: none; font-size: 12px; margin-right: 5px;">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f0f0f0;">
                                    <td style="padding: 15px; vertical-align: middle; color: #495057; font-weight: 600;">3</td>
                                    <td style="padding: 15px; vertical-align: middle;">
                                        <div style="color: #242a62; font-weight: 600; margin-bottom: 3px;">API Integration</div>
                                        <div style="color: #6c757d; font-size: 12px;">RESTful APIs, data fetching, error handling</div>
                                    </td>
                                    <td style="padding: 15px; vertical-align: middle; color: #6c757d; font-size: 13px;">Week 3</td>
                                    <td style="padding: 15px; vertical-align: middle; color: #dc3545; font-size: 13px; font-weight: 600;">19 Feb 2026</td>
                                    <td style="padding: 15px; vertical-align: middle;">
                                        <span class="badge" style="background: #ffc107; color: #212529; padding: 6px 12px; border-radius: 5px; font-size: 11px;">
                                            <i class="bx bx-time"></i> Pending
                                        </span>
                                    </td>
                                    <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                        <button class="btn btn-sm" onclick="submitTask(3)" style="background: #f26e2c; color: white; padding: 6px 12px; border-radius: 5px; font-weight: 600; border: none; font-size: 12px;">
                                            <i class="bx bx-upload"></i> Submit
                                        </button>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f0f0f0;">
                                    <td style="padding: 15px; vertical-align: middle; color: #495057; font-weight: 600;">4</td>
                                    <td style="padding: 15px; vertical-align: middle;">
                                        <div style="color: #242a62; font-weight: 600; margin-bottom: 3px;">Database Design</div>
                                        <div style="color: #6c757d; font-size: 12px;">Schema design, ERD, MySQL/PostgreSQL</div>
                                    </td>
                                    <td style="padding: 15px; vertical-align: middle; color: #6c757d; font-size: 13px;">Week 4</td>
                                    <td style="padding: 15px; vertical-align: middle; color: #6c757d; font-size: 13px;">26 Feb 2026</td>
                                    <td style="padding: 15px; vertical-align: middle;">
                                        <span class="badge" style="background: #ffc107; color: #212529; padding: 6px 12px; border-radius: 5px; font-size: 11px;">
                                            <i class="bx bx-time"></i> Pending
                                        </span>
                                    </td>
                                    <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                        <button class="btn btn-sm" onclick="submitTask(4)" style="background: #f26e2c; color: white; padding: 6px 12px; border-radius: 5px; font-weight: 600; border: none; font-size: 12px;">
                                            <i class="bx bx-upload"></i> Submit
                                        </button>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f0f0f0;">
                                    <td style="padding: 15px; vertical-align: middle; color: #495057; font-weight: 600;">5</td>
                                    <td style="padding: 15px; vertical-align: middle;">
                                        <div style="color: #242a62; font-weight: 600; margin-bottom: 3px;">Backend Development</div>
                                        <div style="color: #6c757d; font-size: 12px;">Node.js, Express.js, Authentication</div>
                                    </td>
                                    <td style="padding: 15px; vertical-align: middle; color: #6c757d; font-size: 13px;">Week 5</td>
                                    <td style="padding: 15px; vertical-align: middle; color: #6c757d; font-size: 13px;">05 Mar 2026</td>
                                    <td style="padding: 15px; vertical-align: middle;">
                                        <span class="badge" style="background: #6c757d; color: white; padding: 6px 12px; border-radius: 5px; font-size: 11px;">
                                            <i class="bx bx-lock"></i> Locked
                                        </span>
                                    </td>
                                    <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                        <button class="btn btn-sm" disabled style="background: #e9ecef; color: #6c757d; padding: 6px 12px; border-radius: 5px; font-weight: 600; border: none; font-size: 12px; cursor: not-allowed;">
                                            <i class="bx bx-lock"></i> Locked
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Certificate Tab -->
                <div class="tab-pane fade" id="certificate" role="tabpanel">
                    <h5 style="color: #242a62; font-weight: 700; margin-bottom: 20px;">
                        <i class="bx bx-certificate"></i> Internship Certificate
                    </h5>

                    <div class="certificate-box">
                        <div class="certificate-icon">
                            <i class="fa fa-certificate"></i>
                        </div>
                        <h4 style="color: #242a62; font-weight: 700; margin-bottom: 15px;">
                            <i class="fa fa-graduation-cap"></i> Certificate of Completion
                        </h4>
                        <p style="color: #6c757d; font-size: 14px; margin-bottom: 25px; max-width: 600px; margin-left: auto; margin-right: auto;">
                            Your certificate will be available once you complete all assigned tasks and successfully finish your internship. 
                            The certificate will be digitally signed and can be downloaded in PDF format.
                        </p>
                        
                        <!-- Give Review Button -->
                        <div style="margin-bottom: 25px;">
                            <button onclick="openReviewModal()" class="btn" 
                                    style="background: linear-gradient(135deg, #f26e2c 0%, #ff8c42 100%); color: white; padding: 12px 30px; border-radius: 25px; font-weight: 700; border: none; font-size: 15px; box-shadow: 0 4px 15px rgba(242, 110, 44, 0.3); transition: all 0.3s ease;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(242, 110, 44, 0.4)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(242, 110, 44, 0.3)'">
                                <i class="bx bx-star"></i> Give Your Review
                            </button>
                            <p style="color: #6c757d; font-size: 12px; margin-top: 10px;">
                                Share your experience about this internship
                            </p>
                        </div>

                        <div style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 15px; margin-top: 25px; max-width: 600px; margin-left: auto; margin-right: auto;">
                            <p style="margin: 0; color: #856404; font-size: 13px;">
                                <i class="bx bx-info-circle"></i> <strong>Note:</strong> Complete 3 more tasks to unlock your certificate!
                            </p>
                        </div>
                    </div>
                </div>

                <!-- General Instructions Tab -->
                <div class="tab-pane fade" id="instructions" role="tabpanel">
                    <h5 style="color: #242a62; font-weight: 700; margin-bottom: 20px;">
                        <i class="bx bx-file"></i> General Instructions
                    </h5>

                    <div style="background: #f8f9fa; border-radius: 10px; padding: 30px; border-left: 4px solid #242a62; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        <div style="color: #495057; font-size: 14px; line-height: 1.8;">
                            <h6 style="color: #242a62; font-weight: 700; margin-bottom: 15px;">Welcome to the Full-Stack Web Development Internship!</h6>
                            
                            <p style="color: #6c757d; margin-bottom: 20px;">Please read the following instructions carefully before starting your internship:</p>
                            
                            <h6 style="color: #242a62; font-weight: 700; margin-top: 25px; margin-bottom: 12px;">General Guidelines:</h6>
                            <ul style="margin-left: 20px; margin-bottom: 20px; color: #495057;">
                                <li style="margin-bottom: 8px;">Attend all scheduled sessions on time</li>
                                <li style="margin-bottom: 8px;">Complete all assigned tasks before the deadline</li>
                                <li style="margin-bottom: 8px;">Maintain professional communication with mentors and peers</li>
                                <li style="margin-bottom: 8px;">Follow the code of conduct at all times</li>
                            </ul>

                            <h6 style="color: #242a62; font-weight: 700; margin-top: 25px; margin-bottom: 12px;">Task Submission:</h6>
                            <ul style="margin-left: 20px; margin-bottom: 20px; color: #495057;">
                                <li style="margin-bottom: 8px;">Submit tasks in the specified format (ZIP file with proper folder structure)</li>
                                <li style="margin-bottom: 8px;">Include a README file with setup instructions</li>
                                <li style="margin-bottom: 8px;">Ensure your code is well-commented and follows best practices</li>
                            </ul>

                            <h6 style="color: #242a62; font-weight: 700; margin-top: 25px; margin-bottom: 12px;">Communication:</h6>
                            <ul style="margin-left: 20px; margin-bottom: 20px; color: #495057;">
                                <li style="margin-bottom: 8px;">Use official email for all communications</li>
                                <li style="margin-bottom: 8px;">Response time: Within 24 hours on working days</li>
                                <li style="margin-bottom: 8px;">Weekly progress meetings every Friday at 3:00 PM</li>
                            </ul>

                            <h6 style="color: #242a62; font-weight: 700; margin-top: 25px; margin-bottom: 12px;">Evaluation Criteria:</h6>
                            <ul style="margin-left: 20px; margin-bottom: 0; color: #495057;">
                                <li style="margin-bottom: 8px;">Task completion and quality: 40%</li>
                                <li style="margin-bottom: 8px;">Attendance and participation: 30%</li>
                                <li style="margin-bottom: 8px;">Final project: 20%</li>
                                <li style="margin-bottom: 8px;">Professional conduct: 10%</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- View Task Modal -->
<div class="modal fade" id="viewTaskModal" tabindex="-1" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 1200px; width: 95%;">
        <div class="modal-content" style="border: none; border-radius: 15px; overflow: hidden;">
            <!-- Modal Header with Gradient -->
            <div class="modal-header" style="background: #242a62; border: none; padding: 25px 30px; color: white;">
                <div>
                    <h5 class="modal-title" id="viewTaskModalLabel" style="font-weight: 700; font-size: 20px; margin: 0 0 5px 0;">
                        <i class="bx bx-task"></i> Task Details
                    </h5>
                    <p style="margin: 0; font-size: 14px; opacity: 0.95;color:#fff;">View your submitted task information</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    
                </button>
            </div>
            
            <div class="modal-body" style="background: #f8f9fa; padding: 30px;">
                <!-- Task Information Section -->
                <div style="background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; border-left: 4px solid #242a62; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <h6 style="color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                        <i class="bx bx-info-circle"></i> Task Information
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Task Title:</label>
                                <p style="margin: 0; color: #212529; font-size: 14px;" id="viewTaskTitle">Create Landing Page</p>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Module:</label>
                                <p style="margin: 0; color: #212529; font-size: 14px;" id="viewTaskModule">Week 2</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Due Date:</label>
                                <p style="margin: 0; color: #212529; font-size: 14px;" id="viewTaskDueDate">12 Feb 2026</p>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Status:</label>
                                <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600;" id="viewTaskStatus">
                                    <i class="bx bx-check-circle"></i> Completed
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Task Description -->
                <div style="background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; border-left: 4px solid #17a2b8; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <h6 style="color: #17a2b8; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                        <i class="bx bx-file-blank"></i> Task Description
                    </h6>
                    <div style="color: #495057; font-size: 14px; line-height: 1.8;" id="viewTaskDescription">
                        Design and develop a responsive landing page using HTML5, CSS3, and JavaScript with modern UI/UX principles.
                    </div>
                </div>

                <!-- Submission Details Section -->
                <div style="background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; border-left: 4px solid #28a745; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <h6 style="color: #28a745; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                        <i class="bx bx-check-double"></i> Your Submission
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Submitted On:</label>
                                <p style="margin: 0; color: #212529; font-size: 14px;" id="viewSubmittedDate">11 Feb 2026, 04:30 PM</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Submitted File:</label>
                                <button class="btn btn-sm" style="background: #17a2b8; color: white; border: none; padding: 6px 15px; border-radius: 5px; font-size: 12px; font-weight: 600;">
                                    <i class="bx bx-download"></i> landing_page.zip
                                </button>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 15px;">
                        <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 10px; display: block;">Your Notes:</label>
                        <div style="background: #f8f9fa; border-radius: 8px; padding: 15px; color: #495057; font-size: 14px; line-height: 1.6;" id="viewSubmissionNotes">
                            I have successfully created a modern and responsive landing page with smooth animations, mobile-first approach, and SEO optimization.
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6;">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: #6c757d; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-x"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Internship Review Modal -->
<div class="modal fade" id="internshipReviewModal" tabindex="-1" aria-labelledby="internshipReviewModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 650px;">
        <div class="modal-content" style="border: none; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <!-- Modal Header with Gradient -->
            <div class="modal-header" style="background: linear-gradient(135deg, #242a62 0%, #3a4799 100%); border: none; padding: 30px; color: white; text-align: center; display: block;">
                <div style="text-align: center; margin-bottom: 15px;">
                    <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; backdrop-filter: blur(10px);">
                        <i class="bx bx-star" style="font-size: 40px; color: #ffc107;"></i>
                    </div>
                </div>
                <h5 class="modal-title" id="internshipReviewModalLabel" style="font-weight: 700; font-size: 24px; margin: 0 0 8px 0; text-align: center;">
                    🎉 Congratulations!
                </h5>
                <p style="margin: 0; font-size: 15px; opacity: 0.95; text-align: center;color:#fff;">You've successfully completed your internship</p>
            </div>
            
            <div class="modal-body" style="padding: 35px; background: white;">
                <!-- Internship Info Card -->
                <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; padding: 20px; margin-bottom: 25px; border-left: 4px solid #f26e2c;">
                    <div style="margin-bottom: 12px;">
                        <label style="font-weight: 600; color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 5px;">
                            <i class="bx bx-briefcase" style="font-size: 14px;"></i> Internship
                        </label>
                        <p style="margin: 0; color: #242a62; font-size: 18px; font-weight: 700;" id="reviewInternshipName">Full-Stack Web Development</p>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label style="font-weight: 600; color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 5px;">
                                <i class="bx bx-calendar-check" style="font-size: 14px;"></i> Start Date
                            </label>
                            <p style="margin: 0; color: #495057; font-size: 14px; font-weight: 600;" id="reviewStartDate">01 February 2026</p>
                        </div>
                        <div class="col-6">
                            <label style="font-weight: 600; color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 5px;">
                                <i class="bx bx-calendar-x" style="font-size: 14px;"></i> End Date
                            </label>
                            <p style="margin: 0; color: #495057; font-size: 14px; font-weight: 600;" id="reviewEndDate">30 April 2026</p>
                        </div>
                    </div>
                </div>

                <!-- Rating Section -->
                <div style="text-align: center; margin-bottom: 25px;">
                    <h6 style="color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 15px;">
                        How was your internship experience?
                    </h6>
                    <div class="star-rating" id="starRating" style="font-size: 50px; cursor: pointer; margin-bottom: 10px; display: flex; justify-content: center; gap: 8px;">
                        <i class="bx bx-star" data-rating="1" style="color: #c5c5c5; transition: all 0.2s ease; display: inline-block;"></i>
                        <i class="bx bx-star" data-rating="2" style="color: #c5c5c5; transition: all 0.2s ease; display: inline-block;"></i>
                        <i class="bx bx-star" data-rating="3" style="color: #c5c5c5; transition: all 0.2s ease; display: inline-block;"></i>
                        <i class="bx bx-star" data-rating="4" style="color: #c5c5c5; transition: all 0.2s ease; display: inline-block;"></i>
                        <i class="bx bx-star" data-rating="5" style="color: #c5c5c5; transition: all 0.2s ease; display: inline-block;"></i>
                    </div>
                    <p style="margin: 0; color: #6c757d; font-size: 14px; font-weight: 600;" id="ratingText">Tap a star to rate</p>
                    <input type="hidden" id="internshipRating" value="0">
                </div>

                <!-- Review Text Area -->
                <div style="margin-bottom: 20px;">
                    <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px; margin-bottom: 10px;">
                        <i class="bx bx-message-square-dots"></i> Share your experience (Optional)
                    </label>
                    <textarea class="form-control" id="reviewText" rows="4" 
                              style="padding: 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; resize: none;height:130px;"
                              placeholder="Tell us about your internship journey, what you learned, and how it helped you grow..."></textarea>
                </div>

                <!-- Skip Option -->
                <div style="text-align: center; margin-bottom: 15px;">
                    <button type="button" class="btn" data-bs-dismiss="modal" 
                            style="color: #6c757d; background: transparent; border: none; font-size: 13px; text-decoration: underline; padding: 5px 15px;">
                        Skip for now
                    </button>
                </div>
            </div>
            
            <div class="modal-footer" style="background: #f8f9fa; padding: 20px 35px; border-top: 1px solid #dee2e6; justify-content: center;">
                <button type="button" class="btn" onclick="submitReview()" 
                        style="background: linear-gradient(135deg, #f26e2c 0%, #ff8c42 100%); color: white; padding: 12px 40px; border-radius: 25px; font-weight: 700; border: none; font-size: 15px; box-shadow: 0 4px 15px rgba(242, 110, 44, 0.3); transition: all 0.3s ease;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(242, 110, 44, 0.4)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(242, 110, 44, 0.3)'">
                    <i class="bx bx-send"></i> Submit Review
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Submit Task Modal -->
<div class="modal fade" id="submitTaskModal" tabindex="-1" aria-labelledby="submitTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 1400px; width: 95%; margin: 1.75rem auto;">
        <div class="modal-content" style="border: none; border-radius: 15px; overflow: hidden;">
            <!-- Modal Header with Gradient -->
            <div class="modal-header" style="background: #242a62; border: none; padding: 25px 30px; color: white;">
                <div>
                    <h5 class="modal-title" id="submitTaskModalLabel" style="font-weight: 700; font-size: 20px; margin: 0 0 5px 0;">
                        <i class="bx bx-upload"></i> Submit Task
                    </h5>
                    <p style="margin: 0; font-size: 14px; opacity: 0.95;color:#fff;">Upload your completed task and provide details</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body" style="background: #f8f9fa; padding: 30px;">
                <form id="submitTaskForm">
                    <!-- Task Info Display -->
                    <div style="background: white; border-radius: 10px; padding: 20px; margin-bottom: 25px; border-left: 4px solid #242a62; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <div class="row">
                            <div class="col-md-6">
                                <div style="margin-bottom: 10px;">
                                    <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Task:</label>
                                    <p style="margin: 0; color: #242a62; font-size: 15px; font-weight: 600;" id="submitTaskTitle">API Integration</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="margin-bottom: 10px;">
                                    <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Due Date:</label>
                                    <p style="margin: 0; color: #dc3545; font-size: 14px; font-weight: 600;" id="submitTaskDueDate">19 Feb 2026</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <div style="background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <h6 style="color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                            <i class="bx bx-cloud-upload"></i> Upload Files
                        </h6>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px; margin-bottom: 10px;">
                                <i class="bx bx-file"></i> Upload Task File <span style="color: #dc3545;">*</span>
                            </label>
                            <input type="file" class="form-control" id="taskFile" name="task_file" required 
                                   style="padding: 12px; border: 2px dashed #dee2e6; border-radius: 8px; background: #f8f9fa;">
                            <small class="text-muted" style="font-size: 12px; margin-top: 5px; display: block;">
                                <i class="bx bx-info-circle"></i> Accepted formats: ZIP, PDF, DOC, DOCX (Max: 10MB)
                            </small>
                        </div>
                    </div>

                    <!-- Notes/Description Section with CKEditor -->
                    <div style="background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <h6 style="color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                            <i class="bx bx-edit"></i> Task Notes & Description
                        </h6>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px; margin-bottom: 10px;">
                                Describe your work <span style="color: #dc3545;">*</span>
                            </label>
                            <textarea class="form-control" id="taskNotes" name="task_notes" rows="8" required
                                      style="padding: 15px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px;"
                                      placeholder="Describe what you have accomplished, technologies used, challenges faced, and any additional information..."></textarea>
                            <small class="text-muted" style="font-size: 12px; margin-top: 5px; display: block;">
                                <i class="bx bx-info-circle"></i> Provide detailed information about your submission
                            </small>
                        </div>
                    </div>

                    <!-- Project Link (Optional) -->
                    <div style="background: white; border-radius: 10px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <h6 style="color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                            <i class="bx bx-link"></i> Additional Information
                        </h6>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px; margin-bottom: 10px;">
                                Project/Demo Link (Optional)
                            </label>
                            <input type="url" class="form-control" id="projectLink" name="project_link" 
                                   placeholder="https://example.com/your-project"
                                   style="padding: 12px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px;">
                            <small class="text-muted" style="font-size: 12px; margin-top: 5px; display: block;">
                                <i class="bx bx-info-circle"></i> Add a link to your hosted project or GitHub repository
                            </small>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6; display: flex; justify-content: space-between;">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: #6c757d; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-x"></i> Cancel
                </button>
                <button type="button" class="btn" onclick="submitTaskForm()" style="background: #28a745; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-check"></i> Submit Task
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
    // Initialize CKEditor
    let editor;
    
    // View Task Function
    window.viewTask = function(taskId) {
        console.log('Viewing task ID:', taskId);
        
        // Sample data based on task ID (replace with actual data from backend)
        const taskData = {
            1: {
                title: 'Setup Development Environment',
                module: 'Week 1',
                dueDate: '05 Feb 2026',
                status: '<i class="bx bx-check-circle"></i> Completed',
                statusClass: '#28a745',
                description: 'Install and configure all necessary development tools including IDE, Git, Node.js, and databases.',
                submittedDate: '04 Feb 2026, 02:15 PM',
                notes: 'Successfully set up the complete development environment with VS Code, Git, Node.js v18, and PostgreSQL. Configured all extensions and tested the setup.'
            },
            2: {
                title: 'Create Landing Page',
                module: 'Week 2',
                dueDate: '12 Feb 2026',
                status: '<i class="bx bx-check-circle"></i> Completed',
                statusClass: '#28a745',
                description: 'Design and develop a responsive landing page using HTML5, CSS3, and JavaScript with modern UI/UX principles.',
                submittedDate: '11 Feb 2026, 04:30 PM',
                notes: 'I have successfully created a modern and responsive landing page with smooth animations, mobile-first approach, and SEO optimization.'
            }
        };
        
        const task = taskData[taskId];
        if (task) {
            document.getElementById('viewTaskTitle').textContent = task.title;
            document.getElementById('viewTaskModule').textContent = task.module;
            document.getElementById('viewTaskDueDate').textContent = task.dueDate;
            document.getElementById('viewTaskStatus').innerHTML = task.status;
            document.getElementById('viewTaskStatus').style.background = task.statusClass;
            document.getElementById('viewTaskDescription').textContent = task.description;
            document.getElementById('viewSubmittedDate').textContent = task.submittedDate;
            document.getElementById('viewSubmissionNotes').textContent = task.notes;
        }
        
        const modal = new bootstrap.Modal(document.getElementById('viewTaskModal'));
        modal.show();
    }

    // Submit Task Function
    window.submitTask = function(taskId) {
        console.log('Submitting task ID:', taskId);
        
        // Sample data based on task ID (replace with actual data from backend)
        const taskData = {
            3: {
                title: 'API Integration',
                dueDate: '19 Feb 2026'
            },
            4: {
                title: 'Database Design',
                dueDate: '26 Feb 2026'
            }
        };
        
        const task = taskData[taskId];
        if (task) {
            document.getElementById('submitTaskTitle').textContent = task.title;
            document.getElementById('submitTaskDueDate').textContent = task.dueDate;
        }
        
        // Initialize CKEditor when modal opens
        const modal = new bootstrap.Modal(document.getElementById('submitTaskModal'));
        modal.show();
        
        // Initialize CKEditor after modal is shown
        document.getElementById('submitTaskModal').addEventListener('shown.bs.modal', function () {
            if (!editor) {
                editor = CKEDITOR.replace('taskNotes', {
                    height: 300,
                    toolbar: [
                        { name: 'document', items: [ 'Source' ] },
                        { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
                        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
                        { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Blockquote' ] },
                        { name: 'links', items: [ 'Link', 'Unlink' ] },
                        { name: 'insert', items: [ 'Table', 'HorizontalRule' ] },
                        { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
                        { name: 'colors', items: [ 'TextColor', 'BGColor' ] }
                    ]
                });
            }
        }, { once: true });
    }

    // Submit Task Form
    window.submitTaskForm = function() {
        const form = document.getElementById('submitTaskForm');
        const fileInput = document.getElementById('taskFile');
        
        // Get CKEditor content
        const editorContent = editor ? editor.getData() : document.getElementById('taskNotes').value;
        
        // Basic validation
        if (!fileInput.files.length) {
            alert('Please upload a file!');
            return;
        }
        
        if (!editorContent || editorContent.trim() === '') {
            alert('Please provide task notes/description!');
            return;
        }
        
        // Here you would normally submit to backend via AJAX
        console.log('Submitting task with:', {
            file: fileInput.files[0].name,
            notes: editorContent,
            projectLink: document.getElementById('projectLink').value
        });
        
        alert('Task submitted successfully!');
        bootstrap.Modal.getInstance(document.getElementById('submitTaskModal')).hide();
        
        // Reset form and destroy editor
        form.reset();
        if (editor) {
            editor.destroy();
            editor = null;
        }
        
        // Reload page or update UI
        location.reload();
    }

    // Cleanup editor when modal is hidden
    document.getElementById('submitTaskModal').addEventListener('hidden.bs.modal', function () {
        if (editor) {
            editor.destroy();
            editor = null;
        }
    });

    // Star Rating System
    let selectedRating = 0;
    const stars = document.querySelectorAll('#starRating i');
    const ratingText = document.getElementById('ratingText');
    const ratingInput = document.getElementById('internshipRating');

    const ratingMessages = {
        1: '⭐ Poor - Needs improvement',
        2: '⭐⭐ Fair - Below expectations',
        3: '⭐⭐⭐ Good - Met expectations',
        4: '⭐⭐⭐⭐ Very Good - Exceeded expectations',
        5: '⭐⭐⭐⭐⭐ Excellent - Outstanding experience!'
    };

    function updateStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('bx-star');
                star.classList.add('bxs-star');
                star.style.color = '#ffc107';
            } else {
                star.classList.remove('bxs-star');
                star.classList.add('bx-star');
                star.style.color = '#c5c5c5';
            }
        });
    }

    // Initialize stars with gray color
    updateStars(0);

    stars.forEach((star, index) => {
        // Click event
        star.addEventListener('click', function() {
            selectedRating = parseInt(this.getAttribute('data-rating'));
            ratingInput.value = selectedRating;
            updateStars(selectedRating);
            ratingText.textContent = ratingMessages[selectedRating];
            ratingText.style.color = '#f26e2c';
            ratingText.style.fontWeight = '700';
        });

        // Hover effect
        star.addEventListener('mouseenter', function() {
            const hoverRating = parseInt(this.getAttribute('data-rating'));
            updateStars(hoverRating);
        });
    });

    // Reset to selected rating on mouse leave
    document.getElementById('starRating').addEventListener('mouseleave', function() {
        updateStars(selectedRating);
    });

    // Submit Review Function
    window.submitReview = function() {
        const rating = selectedRating;
        const reviewText = document.getElementById('reviewText').value;

        if (rating === 0) {
            alert('Please select a star rating before submitting!');
            return;
        }

        // Here you would normally submit to backend via AJAX
        console.log('Submitting review:', {
            rating: rating,
            review: reviewText,
            internshipName: document.getElementById('reviewInternshipName').textContent,
            startDate: document.getElementById('reviewStartDate').textContent,
            endDate: document.getElementById('reviewEndDate').textContent
        });

        // Show success message
        alert('Thank you for your feedback! Your review has been submitted successfully.');
        
        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('internshipReviewModal')).hide();
        
        // Store in localStorage that review has been submitted
        localStorage.setItem('internshipReviewSubmitted', 'true');
    }

    // Function to open review modal manually
    window.openReviewModal = function() {
        // Reset star rating
        selectedRating = 0;
        ratingInput.value = 0;
        ratingText.textContent = 'Tap a star to rate';
        ratingText.style.color = '#6c757d';
        ratingText.style.fontWeight = '600';
        
        // Clear review text
        document.getElementById('reviewText').value = '';
        
        // Show modal
        const reviewModal = new bootstrap.Modal(document.getElementById('internshipReviewModal'));
        reviewModal.show();
        
        // Ensure stars are properly displayed after modal opens
        setTimeout(function() {
            updateStars(0);
        }, 100);
    }

    // Check if internship is completed and show review modal on page load
    window.addEventListener('load', function() {
        // Check if review has already been submitted
        const reviewSubmitted = localStorage.getItem('internshipReviewSubmitted');
        
        // Sample check: Check if internship end date has passed
        // In production, this should come from backend
        const internshipEndDate = new Date('2026-04-30'); // End Date from internship details
        const currentDate = new Date();
        const isCompleted = currentDate > internshipEndDate;

        // For demo purposes, let's show it immediately
        // Remove the isCompleted check in production and use actual completion status from backend
        const shouldShowModal = true; // Change this based on actual completion status from backend

        if (shouldShowModal && !reviewSubmitted) {
            // Small delay for better UX
            setTimeout(function() {
                const reviewModal = new bootstrap.Modal(document.getElementById('internshipReviewModal'));
                reviewModal.show();
            }, 1000);
        }
    });

    // Ensure stars display correctly when modal is shown
    document.getElementById('internshipReviewModal').addEventListener('shown.bs.modal', function () {
        updateStars(selectedRating || 0);
    });
    
    console.log('My Internship Details Page Loaded');
</script>
@endpush
