@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "Internship";
</script>

<style>
    /* Certificate Page Styles */
    .certificate-page-header {
        background: #242a62;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(36, 42, 98, 0.2);
    }

    .certificate-page-header h4 {
        color: white;
        margin: 0;
        font-size: 26px;
        font-weight: 700;
    }

    .certificate-page-header p {
        color: rgba(255, 255, 255, 0.9);
        margin: 5px 0 0 0;
        font-size: 14px;
    }

    /* Filter Section */
    .filter-card {
        background: white;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border-left: 4px solid #f26e2c;
    }

    .filter-card h6 {
        color: #242a62;
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 16px;
    }

    .filter-card .form-label {
        font-weight: 600;
        color: #495057;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .filter-card .form-control,
    .filter-card .form-select {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 10px 14px;
        font-size: 14px;
    }

    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: #f26e2c;
        box-shadow: 0 0 0 0.2rem rgba(242, 110, 44, 0.15);
    }

    .btn-filter {
        background: #242a62;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-filter:hover {
        background: #1a1f47;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(36, 42, 98, 0.3);
    }

    .btn-reset {
        background: #6c757d;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 6px;
        font-weight: 600;
    }

    .btn-reset:hover {
        background: #5a6268;
        color: white;
    }

    /* Internship Card */
    .internship-card {
        background: white;
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border-left: 4px solid #242a62;
    }

    .internship-card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .internship-card-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f8f9fa;
    }

    .internship-title {
        color: #242a62;
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .company-name {
        color: #6c757d;
        font-size: 14px;
        font-weight: 500;
    }

    .badge-completed {
        background: #28a745;
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .internship-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .info-item {
        display: flex;
        align-items: center;
        color: #495057;
        font-size: 13px;
    }

    .info-item i {
        color: #f26e2c;
        margin-right: 8px;
        font-size: 18px;
    }

    .info-item strong {
        color: #212529;
        margin-left: 5px;
    }

    .btn-view-certificates {
        background: #242a62;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-view-certificates:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(242, 110, 44, 0.4);
    }

    /* Student List Modal */
    .modal-header-certificate {
        background: #242a62;
        color: white;
        padding: 20px 30px;
        border: none;
    }

    .modal-header-certificate h5 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
    }

    .modal-header-certificate .btn-close {
        background: transparent;
        border: none;
        font-size: 24px;
        color: white;
        opacity: 1;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-header-certificate .btn-close:hover {
        opacity: 0.8;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
    }

    .table-students .table-hover tbody tr:hover {
        background-color: #fff5f0;
    }

    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        margin-right: 12px;
    }

    .btn-view-certificate {
        background: #6f42c1;
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 5px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-view-certificate:hover {
        background: #5a32a3;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(111, 66, 193, 0.4);
    }

    .btn-download-certificate {
        background: #28a745;
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 5px;
        font-size: 13px;
        font-weight: 600;
        margin-left: 8px;
    }

    .btn-download-certificate:hover {
        background: #218838;
        color: white;
    }

    /* Certificate Modal - A4 Single Page Optimized */
    .certificate-container {
        background: white;
        width: 210mm; /* A4 width */
        height: 297mm; /* A4 height */
        margin: 0 auto;
        padding: 15mm;
        position: relative;
        box-sizing: border-box;
        overflow: hidden;
    }

    /* Decorative Corner Borders */
    .certificate-corner-tl,
    .certificate-corner-tr,
    .certificate-corner-bl,
    .certificate-corner-br {
        position: absolute;
        width: 60px;
        height: 60px;
        z-index: 2;
    }

    .certificate-corner-tl {
        top: 10mm;
        left: 10mm;
        border-top: 4px solid #242a62;
        border-left: 4px solid #242a62;
    }

    .certificate-corner-tr {
        top: 10mm;
        right: 10mm;
        border-top: 4px solid #f26e2c;
        border-right: 4px solid #f26e2c;
    }

    .certificate-corner-bl {
        bottom: 10mm;
        left: 10mm;
        border-bottom: 4px solid #f26e2c;
        border-left: 4px solid #f26e2c;
    }

    .certificate-corner-br {
        bottom: 10mm;
        right: 10mm;
        border-bottom: 4px solid #242a62;
        border-right: 4px solid #242a62;
    }

    /* Inner decorative border */
    .certificate-border-design {
        position: absolute;
        top: 15mm;
        left: 15mm;
        right: 15mm;
        bottom: 15mm;
        border: 2px solid;
        border-image: #242a62;
        pointer-events: none;
        z-index: 1;
    }

    /* Decorative Pattern Lines */
    .certificate-pattern-top,
    .certificate-pattern-bottom {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 150px;
        height: 3px;
        z-index: 3;
    }

    .certificate-pattern-top {
        top: 18mm;
        background: #242a62;
    }

    .certificate-pattern-bottom {
        bottom: 18mm;
        background: #242a62;
    }

    .certificate-header {
        text-align: center;
        margin-bottom: 25px;
        margin-top: 25px;
        position: relative;
        z-index: 3;
    }

    .certificate-logo {
        width: 70px;
        height: 70px;
        background: #242a62;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        box-shadow: 0 4px 15px rgba(242, 110, 44, 0.3);
    }

    .certificate-logo i {
        font-size: 35px;
        color: white;
    }

    .certificate-title {
        font-size: 48px;
        font-weight: 700;
        color: #242a62;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 8px;
        font-family: 'Georgia', serif;
    }

    .certificate-subtitle {
        font-size: 18px;
        color: #f26e2c;
        margin-bottom: 20px;
        font-weight: 600;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .certificate-body {
        text-align: center;
        padding: 20px 40px;
        position: relative;
        z-index: 3;
    }

    .certificate-text {
        font-size: 15px;
        color: #495057;
        margin-bottom: 15px;
        line-height: 1.6;
    }

    .certificate-awarded-to {
        font-size: 16px;
        color: #6c757d;
        font-style: italic;
        margin-bottom: 10px;
    }

    .certificate-name {
        font-size: 40px;
        font-weight: 700;
        color: #f26e2c;
        margin: 15px 0;
        padding: 12px 0;
        border-top: 3px double #242a62;
        border-bottom: 3px double #242a62;
        font-family: 'Georgia', serif;
        letter-spacing: 2px;
    }

    .certificate-internship-info {
        margin: 20px 0;
    }

    .certificate-internship-title {
        font-size: 22px;
        font-weight: 700;
        color: #242a62;
        margin: 15px 0;
    }

    .certificate-company {
        font-size: 16px;
        color: #495057;
        margin-bottom: 15px;
    }

    .certificate-description {
        font-size: 14px;
        color: #6c757d;
        line-height: 1.6;
        margin-top: 15px;
        font-style: italic;
    }

    .certificate-details {
        margin-top: 25px;
        display: flex;
        justify-content: space-around;
        padding: 15px 0;
        background: #242a62;
        border-radius: 10px;
    }

    .certificate-detail-item {
        text-align: center;
    }

    .certificate-detail-label {
        font-size: 11px;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 5px;
        letter-spacing: 1px;
    }

    .certificate-detail-value {
        font-size: 15px;
        color: #242a62;
        font-weight: 700;
    }

    .certificate-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        padding: 0 60px;
        position: relative;
        z-index: 3;
    }

    .certificate-signature {
        text-align: center;
    }

    .signature-line {
        width: 180px;
        height: 2px;
        background: #242a62;
        margin: 0 auto 8px;
    }

    .signature-name {
        font-size: 14px;
        font-weight: 700;
        color: #242a62;
        margin-bottom: 3px;
    }

    .signature-title {
        font-size: 11px;
        color: #6c757d;
        font-style: italic;
    }

    .certificate-seal {
        position: absolute;
        bottom: 25mm;
        right: 25mm;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 3px solid #f26e2c;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 3;
    }

    .certificate-seal-text {
        font-size: 10px;
        font-weight: 700;
        color: #242a62;
        text-align: center;
        line-height: 1.2;
    }

    .certificate-watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.02;
        font-size: 180px;
        color: #242a62;
        pointer-events: none;
        z-index: 0;
    }

    /* Print Styles for Single Page Certificate */
    @media print {
        body * {
            visibility: hidden;
        }
        
        #certificateContent,
        #certificateContent * {
            visibility: visible;
        }
        
        #certificateContent {
            position: absolute;
            left: 0;
            top: 0;
            width: 210mm;
            height: 297mm;
            margin: 0;
            padding: 0;
        }
        
        .certificate-container {
            width: 210mm;
            height: 297mm;
            margin: 0;
            padding: 15mm;
            page-break-after: avoid;
            page-break-inside: avoid;
        }
        
        @page {
            size: A4;
            margin: 0;
        }
        
        .modal-header,
        .modal-footer,
        .btn,
        button {
            display: none !important;
        }
    }

    .no-data-message {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .no-data-message i {
        font-size: 80px;
        color: #dee2e6;
        margin-bottom: 20px;
    }

    .no-data-message h5 {
        color: #242a62;
        font-weight: 600;
        margin-bottom: 10px;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="certificate-page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="bx bx-certification"></i> Certificate Management</h4>
                <p>View and manage internship completion certificates</p>
            </div>
            <div>
                <button class="btn" onclick="exportAllCertificates()" style="background: white; color: #242a62; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600;">
                    <i class="bx bx-download"></i> Export All
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card">
        <h6><i class="bx bx-filter"></i> Filter Internships</h6>
        <form id="filterForm">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Search Internship</label>
                    <input type="text" class="form-control" id="searchInternship" placeholder="Search by title...">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Company</label>
                    <select class="form-select" id="filterCompany">
                        <option value="">All Companies</option>
                        <option value="1">CodeCraft Solutions</option>
                        <option value="2">TechNova Systems</option>
                        <option value="3">Digital Innovations</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Completion Date</label>
                    <input type="month" class="form-control" id="filterMonth">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Duration</label>
                    <select class="form-select" id="filterDuration">
                        <option value="">All Durations</option>
                        <option value="1">1 Month</option>
                        <option value="2">2 Months</option>
                        <option value="3">3 Months</option>
                        <option value="6">6 Months</option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-reset" onclick="resetFilters()">
                    <i class="bx bx-reset"></i> Reset
                </button>
                <button type="button" class="btn btn-filter" onclick="applyFilters()">
                    <i class="bx bx-search"></i> Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Internship List Table -->
    <div class="card" style="border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <div class="card-body" style="padding: 25px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                    <i class="bx bx-list-ul"></i> Completed Internships
                </h5>
                <span class="badge" style="background: #28a745; color: white; padding: 8px 16px; font-size: 13px; border-radius: 20px;">
                    <i class="bx bx-check-circle"></i> 3 Internships
                </span>
            </div>
            <div class="table-responsive">
                <table id="internshipsTable" class="table table-hover table-striped" style="width: 100%;">
                    <thead >
                        <tr>
                            <th style="padding: 15px; font-weight: 700; font-size: 13px;">#</th>
                            <th style="padding: 15px; font-weight: 700; font-size: 13px;">Internship Title</th>
                            <th style="padding: 15px; font-weight: 700; font-size: 13px;">Company Name</th>
                            <th style="padding: 15px; font-weight: 700; font-size: 13px;">Duration</th>
                            <th style="padding: 15px; font-weight: 700; font-size: 13px;">Completion Date</th>
                            <th style="padding: 15px; font-weight: 700; font-size: 13px; text-align: center;">Students</th>
                            <th style="padding: 15px; font-weight: 700; font-size: 13px; text-align: center;">Status</th>
                            <th style="padding: 15px; font-weight: 700; font-size: 13px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 600;">1</td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <div style="display: flex; align-items: center;">
                                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #242a62, #3a4282); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                        <i class="bx bx-code-alt" style="color: white; font-size: 20px;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #212529; font-size: 14px;">Full-Stack Web Development Internship</div>
                                        <div style="font-size: 12px; color: #6c757d;"><i class="bx bx-time"></i> 3 Months Program</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <div style="display: flex; align-items: center;">
                                    <i class="bx bx-buildings" style="color: #f26e2c; margin-right: 8px; font-size: 18px;"></i>
                                    <span style="color: #495057; font-weight: 500;">CodeCraft Solutions</span>
                                </div>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #495057; font-weight: 500;">3 Months</td>
                            <td style="padding: 15px; vertical-align: middle; color: #495057;">10 Jan 2026</td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                <span style="background: #e7f3ff; color: #0066cc; padding: 6px 12px; border-radius: 15px; font-weight: 600; font-size: 13px;">
                                    <i class="bx bx-group"></i> 25
                                </span>
                            </td>
                        
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                <span class="badge" style="background: #28a745; color: white; padding: 8px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                    <i class="bx bx-check-circle"></i> Completed
                                </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                <button class="btn btn-view-certificates" onclick="viewStudentCertificates(1, 'Full-Stack Web Development Internship')" style="padding: 8px 16px; font-size: 13px;">
                                    <i class="bx bx-certification"></i> View Certificates
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 600;">2</td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <div style="display: flex; align-items: center;">
                                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f26e2c, #ff8548); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                        <i class="bx bx-bullseye" style="color: white; font-size: 20px;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #212529; font-size: 14px;">Digital Marketing Internship</div>
                                        <div style="font-size: 12px; color: #6c757d;"><i class="bx bx-time"></i> 2 Months Program</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <div style="display: flex; align-items: center;">
                                    <i class="bx bx-buildings" style="color: #f26e2c; margin-right: 8px; font-size: 18px;"></i>
                                    <span style="color: #495057; font-weight: 500;">TechNova Systems</span>
                                </div>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #495057; font-weight: 500;">2 Months</td>
                            <td style="padding: 15px; vertical-align: middle; color: #495057;">15 Dec 2025</td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                <span style="background: #e7f3ff; color: #0066cc; padding: 6px 12px; border-radius: 15px; font-weight: 600; font-size: 13px;">
                                    <i class="bx bx-group"></i> 18
                                </span>
                            </td>
                            
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                <span class="badge" style="background: #28a745; color: white; padding: 8px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                    <i class="bx bx-check-circle"></i> Completed
                                </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                <button class="btn btn-view-certificates" onclick="viewStudentCertificates(2, 'Digital Marketing Internship')" style="padding: 8px 16px; font-size: 13px;">
                                    <i class="bx bx-certification"></i> View Certificates
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 600;">3</td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <div style="display: flex; align-items: center;">
                                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #6f42c1, #8c5dd8); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                        <i class="bx bx-mobile-alt" style="color: white; font-size: 20px;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #212529; font-size: 14px;">Mobile App Development Internship</div>
                                        <div style="font-size: 12px; color: #6c757d;"><i class="bx bx-time"></i> 3 Months Program</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <div style="display: flex; align-items: center;">
                                    <i class="bx bx-buildings" style="color: #f26e2c; margin-right: 8px; font-size: 18px;"></i>
                                    <span style="color: #495057; font-weight: 500;">Digital Innovations</span>
                                </div>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #495057; font-weight: 500;">3 Months</td>
                            <td style="padding: 15px; vertical-align: middle; color: #495057;">20 Nov 2025</td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                <span style="background: #e7f3ff; color: #0066cc; padding: 6px 12px; border-radius: 15px; font-weight: 600; font-size: 13px;">
                                    <i class="bx bx-group"></i> 15
                                </span>
                            </td>
                           
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                <span class="badge" style="background: #28a745; color: white; padding: 8px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                    <i class="bx bx-check-circle"></i> Completed
                                </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                <button class="btn btn-view-certificates" onclick="viewStudentCertificates(3, 'Mobile App Development Internship')" style="padding: 8px 16px; font-size: 13px;">
                                    <i class="bx bx-certification"></i> View Certificates
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Student List Modal -->
<div class="modal fade" id="studentListModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; ">
            <div class="modal-header modal-header-certificate">
                <div>
                    <h5 class="modal-title" style="color: #fff; margin: 0; font-size: 20px; font-weight: 700;">
                        <i class="bx bx-certification"></i> Student Certificates
                    </h5>
                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;" id="internshipTitleModal">Full-Stack Web Development Internship</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="background: #fff; border: none; font-size: 24px; color: white; opacity: 1;">
                    <i class="bx bx-x" style="color: #000;"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
             

                <!-- Student Table -->
                <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 style="color: #242a62; font-weight: 700; margin: 0;">
                            <i class="bx bx-list-ul"></i> Student List
                        </h6>
                        <button class="btn btn-sm" onclick="downloadAllCertificates()" style="background: #28a745; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 600;">
                            <i class="bx bx-download"></i> Download All
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-students" id="studentsTable">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th style="padding: 12px; color: #242a62; font-weight: 700; font-size: 13px;">#</th>
                                    <th style="padding: 12px; color: #242a62; font-weight: 700; font-size: 13px;">Student Name</th>
                                    <th style="padding: 12px; color: #242a62; font-weight: 700; font-size: 13px;">Email</th>
                                    <th style="padding: 12px; color: #242a62; font-weight: 700; font-size: 13px;">University</th>
                                    <th style="padding: 12px; color: #242a62; font-weight: 700; font-size: 13px;">Completion Date</th>
                                    <th style="padding: 12px; color: #242a62; font-weight: 700; font-size: 13px; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="studentTableBody">
                                <!-- Sample Data - Will be populated dynamically -->
                                <tr>
                                    <td style="padding: 12px; vertical-align: middle;">1</td>
                                    <td style="padding: 12px; vertical-align: middle;">
                                        <div style="display: flex; align-items: center;">
                                            <div class="student-avatar" style="background: linear-gradient(135deg, #242a62, #3a4282);">
                                                R
                                            </div>
                                            <span style="font-weight: 600; color: #212529;">Rahul Sharma</span>
                                        </div>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; color: #6c757d; font-size: 13px;">rahul@example.com</td>
                                    <td style="padding: 12px; vertical-align: middle; color: #495057; font-size: 13px;">Gujarat University</td>
                                    <td style="padding: 12px; vertical-align: middle; color: #495057; font-size: 13px;">10 Jan 2026</td>
                                    <td style="padding: 12px; vertical-align: middle; text-align: center;">
                                        <button class="btn btn-view-certificate" onclick="viewCertificate(1, 'Rahul Sharma', 'Full-Stack Web Development Internship', 'CodeCraft Solutions', '10 Jan 2026', 'CERT-2026-001')">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                        <button class="btn btn-download-certificate" onclick="downloadCertificate(1)">
                                            <i class="bx bx-download"></i> Download
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px; vertical-align: middle;">2</td>
                                    <td style="padding: 12px; vertical-align: middle;">
                                        <div style="display: flex; align-items: center;">
                                            <div class="student-avatar" style="background: linear-gradient(135deg, #f26e2c, #ff8548);">
                                                P
                                            </div>
                                            <span style="font-weight: 600; color: #212529;">Priya Patel</span>
                                        </div>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; color: #6c757d; font-size: 13px;">priya@example.com</td>
                                    <td style="padding: 12px; vertical-align: middle; color: #495057; font-size: 13px;">Mumbai University</td>
                                    <td style="padding: 12px; vertical-align: middle; color: #495057; font-size: 13px;">10 Jan 2026</td>
                                    <td style="padding: 12px; vertical-align: middle; text-align: center;">
                                        <button class="btn btn-view-certificate" onclick="viewCertificate(2, 'Priya Patel', 'Full-Stack Web Development Internship', 'CodeCraft Solutions', '10 Jan 2026', 'CERT-2026-002')">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                        <button class="btn btn-download-certificate" onclick="downloadCertificate(2)">
                                            <i class="bx bx-download"></i> Download
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px; vertical-align: middle;">3</td>
                                    <td style="padding: 12px; vertical-align: middle;">
                                        <div style="display: flex; align-items: center;">
                                            <div class="student-avatar" style="background: linear-gradient(135deg, #6f42c1, #8c5dd8);">
                                                A
                                            </div>
                                            <span style="font-weight: 600; color: #212529;">Amit Kumar</span>
                                        </div>
                                    </td>
                                    <td style="padding: 12px; vertical-align: middle; color: #6c757d; font-size: 13px;">amit@example.com</td>
                                    <td style="padding: 12px; vertical-align: middle; color: #495057; font-size: 13px;">Delhi University</td>
                                    <td style="padding: 12px; vertical-align: middle; color: #495057; font-size: 13px;">10 Jan 2026</td>
                                    <td style="padding: 12px; vertical-align: middle; text-align: center;">
                                        <button class="btn btn-view-certificate" onclick="viewCertificate(3, 'Amit Kumar', 'Full-Stack Web Development Internship', 'CodeCraft Solutions', '10 Jan 2026', 'CERT-2026-003')">
                                            <i class="bx bx-show"></i> View
                                        </button>
                                        <button class="btn btn-download-certificate" onclick="downloadCertificate(3)">
                                            <i class="bx bx-download"></i> Download
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 24px; border-radius: 6px; font-weight: 600;">
                    <i class="bx bx-x"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Certificate View Modal -->
<div class="modal fade" id="certificateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header modal-header-certificate">
                <div>
                    <h5 class="modal-title" style="color: #fff; margin: 0; font-size: 20px; font-weight: 700;">
                        <i class="bx bx-certification"></i> Internship Completion Certificate
                    </h5>
                    <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;" id="certificateNumberDisplay">Certificate No: CERT-2026-001</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="background: #fff;">
                    <i class="bx bx-x" style="color: #000;"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 0; background: #f8f9fa; display: flex; justify-content: center; align-items: center; min-height: 80vh;">
                <!-- Certificate Content -->
                <div id="certificateContent" class="certificate-container">
                    <!-- Corner Decorations -->
                    <div class="certificate-corner-tl"></div>
                    <div class="certificate-corner-tr"></div>
                    <div class="certificate-corner-bl"></div>
                    <div class="certificate-corner-br"></div>

                    <!-- Decorative Patterns -->
                    <div class="certificate-pattern-top"></div>
                    <div class="certificate-pattern-bottom"></div>

                    <!-- Watermark -->
                    <div class="certificate-watermark">
                        <i class="bx bx-certification"></i>
                    </div>

                    <!-- Border Design -->
                    <div class="certificate-border-design"></div>

                    <!-- Certificate Header -->
                    <div class="certificate-header">
                        <div class="certificate-logo">
                            <i class="bx bx-briefcase-alt-2"></i>
                        </div>
                        <h1 class="certificate-title">CERTIFICATE</h1>
                        <p class="certificate-subtitle">Of Internship Completion</p>
                    </div>

                    <!-- Certificate Body -->
                    <div class="certificate-body">
                        <p class="certificate-awarded-to">This is to certify that</p>
                        <h2 class="certificate-name" id="certificateStudentName">Rahul Sharma</h2>
                        
                        <div class="certificate-internship-info">
                            <p class="certificate-text">
                                has successfully completed the internship program in
                            </p>
                            <div class="certificate-internship-title" id="certificateInternshipTitle">
                                Full-Stack Web Development
                            </div>
                            <p class="certificate-company">
                                at <strong id="certificateCompanyName">CodeCraft Solutions</strong>
                            </p>
                        </div>

                        <p class="certificate-description">
                            The intern has demonstrated exceptional skills, dedication, and professionalism throughout the program,
                            successfully completing all assigned tasks and projects with distinction.
                        </p>

                        <!-- Certificate Details -->
                        <div class="certificate-details">
                            <div class="certificate-detail-item">
                                <div class="certificate-detail-label">Certificate No.</div>
                                <div class="certificate-detail-value" id="certificateNumber">CERT-2026-001</div>
                            </div>
                            <div class="certificate-detail-item">
                                <div class="certificate-detail-label">Issue Date</div>
                                <div class="certificate-detail-value" id="certificateDate">10 January 2026</div>
                            </div>
                            <div class="certificate-detail-item">
                                <div class="certificate-detail-label">Duration</div>
                                <div class="certificate-detail-value" id="certificateDuration">3 Months</div>
                            </div>
                        </div>
                    </div>

                    <!-- Certificate Footer with Signatures -->
                    <div class="certificate-footer">
                        <div class="certificate-signature">
                            <div class="signature-line"></div>
                            <div class="signature-name">Authorized Signatory</div>
                            <div class="signature-title">Company Representative</div>
                        </div>
                        <div class="certificate-signature">
                            <div class="signature-line"></div>
                            <div class="signature-name">Platform Director</div>
                            <div class="signature-title">ZobPot Internship Portal</div>
                        </div>
                    </div>

                    <!-- Official Seal -->
                    <div class="certificate-seal">
                        <div class="certificate-seal-text">
                            OFFICIAL<br>SEAL<br>2026
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 24px; border-radius: 6px; font-weight: 600;">
                    <i class="bx bx-x"></i> Close
                </button>
                <button type="button" class="btn" onclick="printCertificate()" style="background: #6f42c1; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-printer"></i> Print Certificate
                </button>
                <button type="button" class="btn" onclick="downloadCurrentCertificate()" style="background: #28a745; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                    <i class="bx bx-download"></i> Download PDF
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Initialize DataTable for internships
        $('#internshipsTable').DataTable({
            order: [[4, 'desc']], // Order by completion date descending
            pageLength: 10,
            language: {
                search: "Search internships:",
                lengthMenu: "Show _MENU_ internships per page"
            },
            columnDefs: [
                { orderable: false, targets: [7] } // Disable sorting on Actions column
            ]
        });

        // Initialize DataTable for students
        $('#studentsTable').DataTable({
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "Search students:",
                lengthMenu: "Show _MENU_ students per page"
            }
        });
    });

    // View Student Certificates
    window.viewStudentCertificates = function(internshipId, internshipTitle) {
        console.log('Loading certificates for internship:', internshipId);
        
        // Update modal title
        document.getElementById('internshipTitleModal').textContent = internshipTitle;
        
        // In production, fetch student data from server
        // $.ajax({
        //     url: '/admin/internship/certificates/students/' + internshipId,
        //     method: 'GET',
        //     success: function(response) {
        //         // Populate table with real data
        //         populateStudentTable(response.students);
        //         updateStatistics(response.statistics);
        //     }
        // });
        
        // Show modal
        const studentListModal = new bootstrap.Modal(document.getElementById('studentListModal'));
        studentListModal.show();
    }

    // View Certificate
    window.viewCertificate = function(studentId, studentName, internshipTitle, companyName, completionDate, certificateNo) {
        console.log('Viewing certificate for student:', studentId);
        
        // Update certificate content
        document.getElementById('certificateStudentName').textContent = studentName;
        document.getElementById('certificateInternshipTitle').textContent = internshipTitle;
        document.getElementById('certificateCompanyName').textContent = companyName;
        document.getElementById('certificateDate').textContent = completionDate;
        document.getElementById('certificateNumber').textContent = certificateNo;
        document.getElementById('certificateNumberDisplay').textContent = 'Certificate No: ' + certificateNo;
        
        // Show certificate modal
        const certificateModal = new bootstrap.Modal(document.getElementById('certificateModal'));
        certificateModal.show();
    }

    // Download Certificate
    window.downloadCertificate = function(studentId) {
        console.log('Downloading certificate for student:', studentId);
        
        // In production, make API call to download certificate
        // window.location.href = '/admin/internship/certificates/download/' + studentId;
        
        alert('Certificate download initiated for student ID: ' + studentId + '\n\nIn production, this will download the certificate PDF.');
    }

    // Download Current Certificate
    window.downloadCurrentCertificate = function() {
        const certificateNo = document.getElementById('certificateNumber').textContent;
        const studentName = document.getElementById('certificateStudentName').textContent;
        
        console.log('Downloading certificate:', certificateNo);
        
        alert('Certificate download initiated: ' + certificateNo + '\n\nFilename: Certificate_' + studentName.replace(' ', '_') + '_' + certificateNo + '.pdf');
        
        // In production, implement PDF generation and download
        // window.location.href = '/admin/internship/certificates/download/' + certificateNo;
    }

    // Print Certificate
    window.printCertificate = function() {
        const certificateContent = document.getElementById('certificateContent').innerHTML;
        const printWindow = window.open('', '_blank', 'width=1000,height=800');
        
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Certificate</title>
                <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
                <style>
                    body { 
                        font-family: Arial, sans-serif; 
                        margin: 0; 
                        padding: 20px;
                    }
                    .certificate-container {
                        background: white;
                        padding: 50px;
                        border: 10px solid;
                        border-image: linear-gradient(135deg, #242a62, #f26e2c) 1;
                        position: relative;
                        min-height: 600px;
                    }
                    .certificate-border-design {
                        position: absolute;
                        top: 20px;
                        left: 20px;
                        right: 20px;
                        bottom: 20px;
                        border: 2px solid #f26e2c;
                    }
                    .certificate-header { text-align: center; margin-bottom: 40px; }
                    .certificate-logo {
                        width: 80px;
                        height: 80px;
                        background: linear-gradient(135deg, #242a62, #f26e2c);
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin: 0 auto 20px;
                    }
                    .certificate-logo i { font-size: 40px; color: white; }
                    .certificate-title {
                        font-size: 42px;
                        font-weight: 700;
                        color: #242a62;
                        margin-bottom: 10px;
                        text-transform: uppercase;
                        letter-spacing: 3px;
                    }
                    .certificate-subtitle { font-size: 16px; color: #6c757d; margin-bottom: 40px; }
                    .certificate-body { text-align: center; padding: 30px; }
                    .certificate-text { font-size: 16px; color: #495057; margin-bottom: 20px; line-height: 1.8; }
                    .certificate-name {
                        font-size: 36px;
                        font-weight: 700;
                        color: #f26e2c;
                        margin: 20px 0;
                        padding: 15px;
                        border-top: 2px solid #242a62;
                        border-bottom: 2px solid #242a62;
                    }
                    .certificate-details {
                        margin-top: 30px;
                        display: flex;
                        justify-content: space-around;
                        padding: 20px 0;
                        border-top: 1px solid #dee2e6;
                    }
                    .certificate-detail-item { text-align: center; }
                    .certificate-detail-label {
                        font-size: 12px;
                        color: #6c757d;
                        text-transform: uppercase;
                        font-weight: 600;
                        margin-bottom: 5px;
                    }
                    .certificate-detail-value { font-size: 14px; color: #212529; font-weight: 600; }
                    .certificate-footer {
                        display: flex;
                        justify-content: space-around;
                        margin-top: 50px;
                        padding-top: 30px;
                    }
                    .certificate-signature { text-align: center; }
                    .signature-line {
                        width: 200px;
                        height: 2px;
                        background: #242a62;
                        margin: 0 auto 10px;
                    }
                    .signature-name { font-size: 14px; font-weight: 700; color: #242a62; }
                    .signature-title { font-size: 12px; color: #6c757d; }
                    .certificate-watermark {
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        opacity: 0.03;
                        font-size: 200px;
                        color: #242a62;
                        z-index: 0;
                    }
                    @media print {
                        body { padding: 0; }
                    }
                </style>
            </head>
            <body>
                ${certificateContent}
            </body>
            </html>
        `);
        
        printWindow.document.close();
        printWindow.focus();
        
        setTimeout(() => {
            printWindow.print();
        }, 500);
    }

    // Download All Certificates
    window.downloadAllCertificates = function() {
        const internshipTitle = document.getElementById('internshipTitleModal').textContent;
        console.log('Downloading all certificates for:', internshipTitle);
        
        alert('Bulk download initiated!\n\nAll certificates for "' + internshipTitle + '" will be downloaded as a ZIP file.\n\nIn production, this will generate a ZIP containing all student certificates.');
        
        // In production
        // window.location.href = '/admin/internship/certificates/download-all/' + internshipId;
    }

    // Export All Certificates
    window.exportAllCertificates = function() {
        console.log('Exporting all certificates data...');
        
        alert('Export functionality!\n\nThis will export all certificates data to Excel/CSV format.\n\nColumns: Certificate No, Student Name, Internship Title, Company, Completion Date, Status');
        
        // In production
        // window.location.href = '/admin/internship/certificates/export';
    }

    // Apply Filters
    window.applyFilters = function() {
        const searchTerm = document.getElementById('searchInternship').value;
        const company = document.getElementById('filterCompany').value;
        const month = document.getElementById('filterMonth').value;
        const duration = document.getElementById('filterDuration').value;
        
        console.log('Applying filters:', {
            search: searchTerm,
            company: company,
            month: month,
            duration: duration
        });
        
        // In production, make AJAX call to filter internships
        // $.ajax({
        //     url: '/admin/internship/certificates/filter',
        //     method: 'GET',
        //     data: { search: searchTerm, company: company, month: month, duration: duration },
        //     success: function(response) {
        //         updateInternshipList(response.internships);
        //     }
        // });
        
        alert('Filters applied! Results will be updated based on your selection.');
    }

    // Reset Filters
    window.resetFilters = function() {
        document.getElementById('filterForm').reset();
        console.log('Filters reset');
        
        // In production, reload page or fetch all internships
        // location.reload();
        
        alert('Filters reset! Showing all completed internships.');
    }
</script>
@endpush
