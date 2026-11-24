@extends('website.layout.layout')
@section('website-content')

    <style>
        /* Candidate Application History Page Styles */
        .internship-history-header,
        .opportunity-history-header {
            background: linear-gradient(135deg, #242a62 0%, #3d4575 55%, #f26e2c 160%);
            border-radius: 16px;
            padding: 28px 32px;
            margin-bottom: 28px;
            color: #ffffff;
            box-shadow: 0 10px 28px rgba(36, 42, 98, 0.22);
        }

        .internship-history-header h2,
        .opportunity-history-header h2 {
            margin: 0;
            font-size: 30px;
            font-weight: 800;
            color: #ffffff !important;
            line-height: 1.25;
        }

        .internship-history-header h2 i,
        .opportunity-history-header h2 i {
            color: #ffd7c2;
            margin-right: 8px;
        }

        .internship-history-header p,
        .opportunity-history-header p {
            margin: 8px 0 0 0;
            font-size: 15px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.92) !important;
        }

        .internship-history-header .header-meta,
        .opportunity-history-header .header-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 14px;
        }

        .internship-history-header .header-meta span,
        .opportunity-history-header .header-meta span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.28);
            color: #fff;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .internship-history-header .btn-back-home,
        .opportunity-history-header .btn-back-home {
            background: rgba(255, 255, 255, 0.18) !important;
            color: #ffffff !important;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.35) !important;
            white-space: nowrap;
        }

        .internship-history-header .btn-back-home:hover,
        .opportunity-history-header .btn-back-home:hover {
            background: #ffffff !important;
            color: #242a62 !important;
        }

        /* Tab Navigation */
        .nav-tabs-internship-history,
        .nav-tabs-opportunity-history {
            background: #fff;
            border-radius: 12px 12px 0 0;
            padding: 15px 20px 0 20px;
            border-bottom: 3px solid #242a62;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            flex-wrap: wrap;
        }

        .nav-tabs-internship-history .nav-link,
        .nav-tabs-opportunity-history .nav-link {
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

        .nav-tabs-internship-history .nav-link:hover,
        .nav-tabs-opportunity-history .nav-link:hover {
            color: #242a62;
            background: #fff5f0;
        }

        .nav-tabs-internship-history .nav-link.active,
        .nav-tabs-opportunity-history .nav-link.active {
            color: #242a62;
            background: transparent;
            border-bottom-color: #f26e2c;
        }

        .table-internship-view thead th,
        .table-opportunity-view thead th {
            background: #242a62;
            color: #fff !important;
            font-weight: 600;
            font-size: 13px;
            white-space: nowrap;
        }

        #CompanyStudentsTable,
        #CompanyTasksTable,
        #completionTable {
            width: 100% !important;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 6px 20px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #242a62 !important;
            color: #fff !important;
            border-color: #242a62 !important;
        }

        .tab-content-card {
            background: #fff;
            border-radius: 0 0 12px 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        /* Detail Section */
        .detail-row-view {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px dashed #dee2e6;
        }

        .detail-row-view:last-child {
            border-bottom: none;
        }

        .detail-label-view {
            font-weight: 600;
            color: #495057;
            font-size: 14px;
            min-width: 200px;
        }

        .detail-value-view {
            color: #212529;
            font-size: 14px;
            flex: 1;
        }

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
            font-size: 16px;
            margin-bottom: 15px;
        }

        /* Action Buttons */
        .btn-action-view {
            padding: 6px 14px;
            font-size: 13px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-edit-view {
            background: #17a2b8;
            color: white;
            border: none;
        }

        .btn-edit-view:hover {
            background: #138496;
            color: white;
            transform: translateY(-2px);
        }

        .btn-view-submission {
            background: #6f42c1;
            color: white;
            border: none;
        }

        .btn-view-submission:hover {
            background: #5a32a3;
            color: white;
            transform: translateY(-2px);
        }

        /* Table Styles */
        .table-opportunity-view .table-hover tbody tr:hover {
            background-color: #fff5f0;
        }

        .table-opportunity-view thead {
            background: #f8f9fa;
            border-bottom: 2px solid #242a62;
        }

        .table-opportunity-view thead th {
            font-weight: 600;
            color: #242a62;
            font-size: 13px;
            padding: 12px;
            border: none;
        }

        .table-opportunity-view tbody td {
            padding: 12px;
            vertical-align: middle;
            font-size: 13px;
        }

        /* Candidate Application Card */
        .application-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #242a62;
            transition: all 0.3s ease;
        }

        .application-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 80px;
            color: #dee2e6;
            margin-bottom: 20px;
        }

        .empty-state h4 {
            color: #6c757d;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #adb5bd;
            margin-bottom: 30px;
        }

        /* Progress Bar */
        .progress-container {
            margin-top: 15px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 13px;
            color: #495057;
            font-weight: 600;
        }

        .progress-bar-custom {
            height: 10px;
            border-radius: 5px;
            background: #e9ecef;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, # 0%, #f26e2c 100%);
            transition: width 0.3s ease;
        }

        /* Modal Styles */
        .modal-header-history {
            background: #242a62;
            color: white;
            padding: 20px 30px;
        }

        .modal-header-history h5 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
        }

        .modal-header-history p {
            color: #fff;
        }

        .modal-header-history .btn-close {
            background: #fff;
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


        .modal-header-history .btn-close i {
            color: #000;
        }

        .modal-header-history .btn-close:hover {
            opacity: 0.8;
            background: #fff;
            border-radius: 4px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .internship-history-header,
            .opportunity-history-header {
                padding: 22px 18px;
            }

            .internship-history-header h2,
            .opportunity-history-header h2 {
                font-size: 22px;
            }

            .detail-row-view {
                flex-direction: column;
                gap: 5px;
            }

            .detail-label-view {
                min-width: auto;
            }

            .table-responsive {
                font-size: 12px;
            }
        }


        .modal-title {
            color: #fff !important;
        }

        /* Complete Program Table Styles */
        .complete-internship-table,
        .complete-opportunity-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 0;
        }

        .complete-internship-table thead,
        .complete-opportunity-table thead {
            background: linear-gradient(135deg, #242a62 0%, #3d4575 100%);
        }

        .complete-internship-table thead th,
        .complete-opportunity-table thead th {
            color: #ffffff !important;
            font-weight: 600;
            padding: 14px 12px;
            text-align: center;
            vertical-align: middle;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-right: 1px solid rgba(255, 255, 255, 0.12);
            white-space: nowrap;
        }

        .complete-internship-table thead th:last-child,
        .complete-opportunity-table thead th:last-child {
            border-right: none;
        }

        .complete-internship-table tbody tr,
        .complete-opportunity-table tbody tr {
            border-bottom: 1px solid #e9ecef;
            transition: background 0.2s ease;
        }

        .complete-internship-table tbody tr:hover,
        .complete-opportunity-table tbody tr:hover {
            background: #f8f9fa;
        }

        .complete-internship-table tbody td,
        .complete-opportunity-table tbody td {
            padding: 14px 12px;
            vertical-align: middle;
            font-size: 13px;
            color: #495057;
            text-align: center;
            word-wrap: break-word;
        }

        .complete-internship-table tbody td:first-child,
        .complete-opportunity-table tbody td:first-child {
            text-align: center;
            font-weight: 700;
            color: #242a62;
        }

        .complete-internship-table .col-sr { width: 70px; }
        .complete-internship-table .col-student { width: 160px; text-align: left !important; }
        .complete-internship-table .col-college { width: 140px; }
        .complete-internship-table .col-industry { width: 240px; }
        .complete-internship-table .col-feedback { width: 220px; }
        .complete-internship-table .col-total { width: 90px; }
        .complete-internship-table .col-percent { width: 90px; }
        .complete-internship-table .col-grade { width: 90px; }
        .complete-internship-table .col-certificate { width: 160px; }
        .btn-company-cert {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #28a745;
            color: #fff !important;
            border: none;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-company-cert:hover { background: #218838; color: #fff !important; }

        .complete-internship-table td.col-student > div {
            text-align: left;
            font-weight: 600;
            color: #242a62;
            line-height: 1.35;
        }

        .complete-program-table-wrap {
            overflow-x: auto;
            border-radius: 12px;
        }

        .marks-input-group {
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: flex-start;
            flex-wrap: wrap;
            margin-bottom: 8px;
            padding: 6px 8px;
            background: #f8f9fc;
            border-radius: 8px;
            border: 1px solid #eef0f4;
        }

        .marks-input-group:last-child {
            margin-bottom: 0;
        }

        .marks-input-group label {
            margin: 0;
            font-size: 12px;
            color: #6c757d;
            font-weight: 600;
            min-width: 90px;
            text-align: left;
        }

        .marks-input {
            width: 70px;
            padding: 8px 10px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .marks-input:focus {
            outline: none;
            border-color: #242a62;
            box-shadow: 0 0 0 3px rgba(36, 42, 98, 0.1);
        }

        .marks-input:disabled {
            background: #f8f9fa;
            cursor: not-allowed;
        }

        .feedback-textarea:disabled {
            background: #f8f9fa;
            cursor: not-allowed;
            color: #495057;
            opacity: 1;
            resize: none;
        }

        .max-marks {
            font-size: 13px;
            color: #6c757d;
            font-weight: 600;
        }

        .feedback-textarea {
            width: 100%;
            min-height: 80px;
            padding: 10px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 13px;
            resize: vertical;
            transition: all 0.3s ease;
        }

        .feedback-textarea:focus {
            outline: none;
            border-color: #242a62;
            box-shadow: 0 0 0 3px rgba(36, 42, 98, 0.1);
        }

        .total-display {
            font-size: 18px;
            font-weight: 700;
            color: #242a62;
            text-align: center;
        }

        .percentage-display {
            font-size: 16px;
            font-weight: 700;
            color: #17a2b8;
            text-align: center;
        }

        .grade-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 14px;
            text-align: center;
        }

        .grade-A {
            background: #28a745;
            color: white;
        }

        .grade-B {
            background: #17a2b8;
            color: white;
        }

        .grade-C {
            background: #ffc107;
            color: #333;
        }

        .grade-D {
            background: #fd7e14;
            color: white;
        }

        .grade-F {
            background: #dc3545;
            color: white;
        }

        .btn-complete-opportunity,
        .btn-complete-internship,
        .btn-complete-opportunity-submit,
        .btn-complete-internship-submit {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 14px 32px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 16px;
            border: none;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            transition: all 0.3s ease;
        }

        .btn-complete-opportunity:hover,
        .btn-complete-internship:hover,
        .btn-complete-opportunity-submit:hover,
        .btn-complete-internship-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .btn-complete-opportunity:disabled,
        .btn-complete-internship:disabled,
        .btn-complete-opportunity-submit:disabled,
        .btn-complete-internship-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Confirmation Modal Styles */
        .confirmation-modal .modal-content {
            border-radius: 16px;
            border: none;
            overflow: hidden;
        }

        .confirmation-modal .modal-header {
            background: linear-gradient(135deg, #f26e2c 0%, #ff9966 100%);
            border: none;
            padding: 24px 30px;
        }

        .confirmation-modal .modal-title {
            color: white !important;
            font-size: 22px;
            font-weight: 700;
        }

        .confirmation-modal .modal-body {
            padding: 32px;
            text-align: center;
        }

        .confirmation-icon {
            font-size: 64px;
            color: #f26e2c;
            margin-bottom: 20px;
        }

        .confirmation-text {
            font-size: 16px;
            color: #495057;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .confirmation-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn-confirm-yes {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-confirm-yes:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-confirm-no {
            background: #6c757d;
            color: white;
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-confirm-no:hover {
            background: #5a6268;
        }

        .export-btn {
            background: linear-gradient(135deg, #242a62 0%, #3d4575 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            margin-left: 12px;
        }

        .export-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(36, 42, 98, 0.3);
        }

        @media (max-width: 768px) {
            .complete-internship-table,
            .complete-opportunity-table {
                font-size: 12px;
            }

            .marks-input {
                width: 60px;
                padding: 6px 8px;
                font-size: 12px;
            }

            .complete-internship-table thead th,
            .complete-opportunity-table thead th,
            .complete-internship-table tbody td,
            .complete-opportunity-table tbody td {
                padding: 10px 6px;
            }
        }

           .ck-editor__editable {
        min-height: 300px;
    }
    </style>

    <main class="main">
        <section class="section-box">
            <div class="container">
                <!-- Page Header -->
                <div class="internship-history-header">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <h2><i class="bx bx-briefcase"></i> {{ $internship->internship_title ?? 'Internship' }}</h2>
                            <p>Manage enrolled students, tasks, and program completion for this Internship.</p>
                            <div class="header-meta">
                                @if(!empty($internship->company) && !empty($internship->company->name))
                                    <span><i class="bx bx-buildings"></i> {{ $internship->company->name }}</span>
                                @endif
                                @if(!empty($internship->duration))
                                    <span><i class="bx bx-time"></i> {{ $internship->duration }}</span>
                                @endif
                                @if(!empty($internship->mode))
                                    <span><i class="bx bx-globe"></i> {{ $internship->mode }}</span>
                                @endif
                                @if(!empty($internship->location))
                                    <span><i class="bx bx-map"></i> {{ $internship->location }}</span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('/') }}" class="btn btn-back-home">
                            <i class="bx bx-arrow-back"></i> Back to Home
                        </a>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <!-- Total Students Card -->
                    <div class="col-md-3 mb-3">
                        <div
                            style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #17a2b8; height: 100%; background-color: #eee;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <p
                                        style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">
                                        Total Students</p>
                                    <h4 style="margin: 5px 0 0 0; color: #17a2b8; font-weight: 700; font-size: 24px;">{{ isset($applications) ? $applications->count() : 0 }}</h4>
                                </div>
                                <div
                                    style="width: 50px; height: 50px; border-radius: 10px; background: rgba(23, 162, 184, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-users" style="font-size: 28px; color: #17a2b8;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Tasks Card -->
                    <div class="col-md-3 mb-3">
                        <div
                            style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #f26e2c; height: 100%; background-color: #eee;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <p
                                        style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">
                                        Total Tasks</p>
                                    <h4 style="margin: 5px 0 0 0; color: #f26e2c; font-weight: 700; font-size: 24px;">{{ isset($myTasks) ? $myTasks->count() : 0 }}</h4>
                                </div>
                                <div
                                    style="width: 50px; height: 50px; border-radius: 10px; background: rgba(242, 110, 44, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-tasks" style="font-size: 28px; color: #f26e2c;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Tasks Card -->
                    <div class="col-md-3 mb-3">
                        <div
                            style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #28a745; height: 100%; background-color: #eee;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <p
                                        style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">
                                        Completed Tasks</p>
                                    <h4 style="margin: 5px 0 0 0; color: #28a745; font-weight: 700; font-size: 24px;">
                                        {{ $completedTasks ?? 0 }}/{{ $totalTasks ?? 0 }}
                                    </h4>
                                </div>
                                <div
                                    style="width: 50px; height: 50px; border-radius: 10px; background: rgba(40, 167, 69, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-check-circle" style="font-size: 28px; color: #28a745;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Hours Card -->
                    <div class="col-md-3 mb-3">
                        <div
                            style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #242a62; height: 100%; background-color: #eee;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <p
                                        style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">
                                        Total Hours</p>
                                    <h4 style="margin: 5px 0 0 0; color: #242a62; font-weight: 700; font-size: 24px;">{{ $internship->total_hours ?? 0 }}
                                    </h4>
                                </div>
                                <div
                                    style="width: 50px; height: 50px; border-radius: 10px; background: rgba(36, 42, 98, 0.1); display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-clock-o" style="font-size: 28px; color: #242a62;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Navigation -->
                <ul class="nav nav-tabs nav-tabs-internship-history" id="applicationTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                            type="button" role="tab">
                            <i class="bx bx-info-circle"></i> &nbsp;&nbsp;Internship Details
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="student-tab" data-bs-toggle="tab" data-bs-target="#student"
                            type="button" role="tab">
                            <i class="bx bx-user"></i> &nbsp;&nbsp;Student
                        </button>
                    </li>
                    @if ($internship->manage_task_status == 1)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks" type="button"
                            role="tab">
                            <i class="bx bx-task"></i> &nbsp;&nbsp;Manage Task
                        </button>
                    </li>
                    @endif
                    
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="instructions-tab" data-bs-toggle="tab" data-bs-target="#instructions"
                            type="button" role="tab">
                            <i class="bx bx-file"></i> &nbsp;&nbsp;General Instructions
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="complete-tab" data-bs-toggle="tab" data-bs-target="#complete"
                            type="button" role="tab">
                            @if($internship->company_complete_sts == 1 || $internship->complete_status == 1)
                                @if($internship->internship_type == 2)
                                    <i class="bx bx-message-square-detail"></i> &nbsp;&nbsp;View Feedback and Certificate
                                @else
                                    <i class="bx bx-eye"></i> &nbsp;&nbsp;View Marks and Certificate
                                @endif
                            @else
                                <i class="bx bx-check-circle"></i> &nbsp;&nbsp;Complete Program
                            @endif
                        </button>
                    </li>
                    
                </ul>

                <!-- Tab Content -->
                <div class="tab-content tab-content-card" id="applicationTabsContent">
                    <!-- Opportunity Details Tab -->
                    <div class="tab-pane fade show active" id="details" role="tabpanel">
                        <h5 style="color: #242a62; font-weight: 700; margin-bottom: 20px;">
                            <i class="bx bx-detail"></i> Internship Information
                        </h5>


                        <div class="section-card">
                            <h6><i class="bx bx-info-circle"></i> Basic Details</h6>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Internship Title:</span>
                                <span class="detail-value-view">{{ $internship->internship_title }}</span>
                            </div>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Company Name:</span>
                                <span
                                    class="detail-value-view">{{ $internship->company ? $internship->company->name : 'N/A' }}</span>
                            </div>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Category:</span>
                                <span
                                    class="detail-value-view">{{ $internship->jobCategory ? $internship->jobCategory->category_nm : 'N/A' }}</span>
                            </div>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Mode:</span>
                                <span class="detail-value-view">{{ $internship->mode }}</span>
                            </div>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Location:</span>
                                <span class="detail-value-view">{{ $internship->location }}</span>
                            </div>
                        </div>

                        <div class="section-card">
                            <h6><i class="bx bx-time"></i> Duration & Schedule</h6>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Duration:</span>
                                <span class="detail-value-view">{{ $internship->duration }}</span>
                            </div>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Total Weeks:</span>
                                <span class="detail-value-view">{{ $internship->total_weeks }} Weeks</span>
                            </div>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Total Hours:</span>
                                <span class="detail-value-view">{{ $internship->total_hours }} Hours</span>
                            </div>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Start Date:</span>
                                <span
                                    class="detail-value-view">{{ $internship->start_date ? $internship->start_date->format('d M Y') : 'N/A' }}</span>
                            </div>
                            <div class="detail-row-view">
                                <span class="detail-label-view">End Date:</span>
                                <span
                                    class="detail-value-view">{{ $internship->end_date ? $internship->end_date->format('d M Y') : 'N/A' }}</span>
                            </div>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Batch Days:</span>
                                <span class="detail-value-view">
                                    @if ($internship->batch_days && is_array($internship->batch_days))
                                        {{ implode(', ', array_keys($internship->batch_days)) }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Time Slots:</span>
                                <span class="detail-value-view">
                                    @if ($internship->batch_days && is_array($internship->batch_days))
                                        @foreach ($internship->batch_days as $day => $times)
                                            {{ $day }}: {{ $times['start_time'] ?? 'N/A' }} -
                                            {{ $times['end_time'] ?? 'N/A' }}<br>
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="section-card">
                            <h6><i class="bx bx-money"></i> Compensation & Fees</h6>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Stipend:</span>
                                <span class="detail-value-view">₹{{ number_format($internship->stipend, 2) }}/month</span>
                            </div>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Registration Fee:</span>
                                <span
                                    class="detail-value-view">₹{{ number_format($internship->registration_fees, 2) }}</span>
                            </div>
                            <div class="detail-row-view">
                                <span class="detail-label-view">GST ({{ $internship->gst_percentage }}%):</span>
                                <span class="detail-value-view">₹{{ number_format($internship->gst_amount, 2) }}</span>
                            </div>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Course Fee:</span>
                                <span class="detail-value-view"><strong>₹{{ number_format($internship->course_fee, 2) }}</strong></span>
                            </div>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Platform Service Charge:</span>
                                <span class="detail-value-view"><strong>₹{{ number_format((float) ($internship->platform_service_charge ?? 0), 2) }}</strong></span>
                            </div>
                            <div class="detail-row-view">
                                <span class="detail-label-view">Openings:</span>
                                <span class="detail-value-view">{{ $internship->openings }} Positions</span>
                            </div>
                        </div>

                        <div class="section-card">
                            <h6><i class="bx bx-cog"></i> Skills & Requirements</h6>
                            @php
                                // Normalize skills (handle JSON arrays, comma-separated strings, or PHP arrays)
                                $skillList = [];
                                if (!empty($internship->skills)) {
                                    if (is_string($internship->skills)) {
                                        $decodedSkills = json_decode($internship->skills, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decodedSkills)) {
                                            $skillList = $decodedSkills;
                                        } else {
                                            $skillList = array_map('trim', explode(',', $internship->skills));
                                        }
                                    } elseif (is_array($internship->skills)) {
                                        $skillList = $internship->skills;
                                    }
                                }

                                // Normalize eligibility criteria similarly
                                $eligibilityList = [];
                                if (!empty($internship->eligibility_criteria)) {
                                    if (is_string($internship->eligibility_criteria)) {
                                        $decodedElig = json_decode($internship->eligibility_criteria, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decodedElig)) {
                                            $eligibilityList = $decodedElig;
                                        } else {
                                            $eligibilityList = array_map('trim', explode(',', $internship->eligibility_criteria));
                                        }
                                    } elseif (is_array($internship->eligibility_criteria)) {
                                        $eligibilityList = $internship->eligibility_criteria;
                                    }
                                }
                            @endphp

                            <div class="detail-row-view">
                                <span class="detail-label-view">Required Skills:</span>
                                <span class="detail-value-view">
                                    @if (!empty($skillList))
                                        @foreach ($skillList as $skill)
                                            @php $skill = is_array($skill) ? ($skill['name'] ?? implode(' ', $skill)) : trim($skill); @endphp
                                            @if ($skill !== '')
                                                <span class="badge bg-primary text-white me-1">{{ $skill }}</span>
                                            @endif
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>

                            <div class="detail-row-view">
                                <span class="detail-label-view">Eligibility Criteria:</span>
                                <span class="detail-value-view">
                                    @if (!empty($eligibilityList))
                                        @foreach ($eligibilityList as $criteria)
                                            @php $criteria = is_array($criteria) ? implode(' ', $criteria) : trim($criteria); @endphp
                                            @if ($criteria !== '')
                                                <span class="badge bg-secondary text-white me-1">{{ $criteria }}</span>
                                            @endif
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="section-card">
                            <h6><i class="bx bx-detail"></i> Program Overview</h6>
                            <div style="padding: 15px; background: white; border-radius: 8px; border: 1px solid #e9ecef;">
                                {!! $internship->internship_description ?? '<p class="text-muted">No description available</p>' !!}
                            </div>
                        </div>

                        <div class="section-card">
                            <h6><i class="bx bx-book"></i> Module Brief Description</h6>
                            <div style="padding: 15px; background: white; border-radius: 8px; border: 1px solid #e9ecef;">
                                {!! $internship->module_brief_description ?? '<p class="text-muted">No module description available</p>' !!}
                            </div>
                        </div>

                        <div class="section-card">
                            <h6><i class="bx bx-target-lock"></i> Learning Objectives</h6>
                            <div style="padding: 15px; background: white; border-radius: 8px; border: 1px solid #e9ecef;">
                                {!! $internship->internship_objective ?? '<p class="text-muted">No objective defined</p>' !!}
                            </div>
                        </div>

                        <div class="section-card">
                            <h6><i class="bx bx-trophy"></i> Skills You'll Gain</h6>
                            <div style="padding: 15px; background: white; border-radius: 8px; border: 1px solid #e9ecef;">
                                {!! $internship->internship_outcome ?? '<p class="text-muted">No outcome defined</p>' !!}
                            </div>
                        </div>
                    </div>

                    <!-- Student Tab -->
                    <div class="tab-pane fade" id="student" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                                <i class="bx bx-user"></i> Enrolled Students
                            </h5>
                            <span class="badge"
                                style="background: #28a745; padding: 10px 20px; font-size: 14px; color: white;">
                                Total: {{ isset($applications) ? $applications->count() : 0 }} Students
                            </span>
                        </div>

                        <div class="table-responsive">
                            <table id="CompanyStudentsTable" class="table table-sm table-striped table-hover table-internship-view" style="width:100%">
                                <thead class="border-top">
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Student Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Apply On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($applications) && $applications->count() > 0)
                                        @foreach($applications as $index => $app)
                                            @php $user = $app->user ?? null; @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $user->name ?? ($app->applicant_name ?? 'N/A') }}</td>
                                                <td>{{ $user->email ?? ($app->email ?? 'N/A') }}</td>
                                                <td>{{ $user->contact_no ?? $user->phone_no ?? $user->phone ?? ($app->contact_no ?? 'N/A') }}</td>
                                                <td>{{ !empty($app->applied_on) ? \Carbon\Carbon::parse($app->applied_on)->format('d M Y') : (!empty($app->created_at) ? \Carbon\Carbon::parse($app->created_at)->format('d M Y') : 'N/A') }}</td>
                                               
                                                <td>
                                                    @if($user)
                                                        <a href="{{ route('candidate-profile-detail', $user->id) }}" class="btn btn-action-view btn-edit-view btn-sm" target="_blank">
                                                            <i class="bx bx-show"></i> View Profile
                                                        </a>
                                                    @else
                                                        <button class="btn btn-action-view btn-edit-view btn-sm" onclick="alert('No profile available')">
                                                            <i class="bx bx-show"></i> View
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Manage Task Tab -->
                    <div class="tab-pane fade" id="tasks" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                                <i class="bx bx-task"></i> My Tasks
                            </h5>
                            <div class="d-flex gap-2 align-items-center">
                                <button class="btn"
                                    style="background: #242a62; color: white; padding: 10px 20px; border-radius: 6px; font-weight: 600; border: none;"
                                    onclick="openAddTaskModal()">
                                    <i class="bx bx-plus"></i> Add New Task
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="CompanyTasksTable" class="table table-sm table-striped table-hover table-internship-view" style="width:100%">
                                <thead class="border-top">
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Task Title</th>
                                        <th>Upload Date</th>
                                        <th>Due Date</th>
                                        <th>Task File</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($myTasks) && $myTasks->count())
                                        @foreach($myTasks as $idx => $task)
                                            @php
                                                // Count child tasks for this master task
                                                $childTasks = \App\Models\InternshipTask::where('parent_id', $task->id)->get();
                                                $totalStudents = $childTasks->count();
                                                $completedStudents = $childTasks->where('status', 1)->count();
                                                $allCompleted = $totalStudents > 0 && $completedStudents == $totalStudents;
                                            @endphp
                                            <tr>
                                                <td>{{ $idx + 1 }}</td>
                                                <td>{{ $task->module_title }}</td>
                                                <td>{{ $task->created_at ? $task->created_at->format('d M Y') : '-' }}</td>
                                                <td>{{ $task->last_submission_date ? \Carbon\Carbon::parse($task->last_submission_date)->format('d M Y') : '-' }}</td>
                                                <td>
                                                    @if($task->upload_file)
                                                        <a href="{{ asset('uploads/internship_tasks/' . $task->upload_file) }}" class="badge bg-info" target="_blank" rel="noopener">
                                                            <i class="bx bx-download"></i> Task File
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($allCompleted)
                                                        <span class="badge bg-success">Completed ({{ $completedStudents }}/{{ $totalStudents }})</span>
                                                    @elseif($totalStudents > 0)
                                                        <span class="badge bg-warning">Pending ({{ $completedStudents }}/{{ $totalStudents }})</span>
                                                    @else
                                                        <span class="badge bg-secondary">No Students</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-action-view btn-edit-view btn-sm me-1" onclick="viewTaskDetails({{ $task->id }})">
                                                        <i class="bx bx-show"></i> View
                                                    </button>
                                                    <button class="btn btn-action-view btn-sm me-1" style="background: #ffc107; color: #000; border: none;" onclick="openEditTaskModal({{ $task->id }})">
                                                        <i class="bx bx-edit"></i> Edit
                                                    </button>
                                                    <button class="btn btn-action-view btn-sm me-1" style="background: #dc3545; color: white; border: none;" onclick="confirmDeleteTask({{ $task->id }})">
                                                        <i class="bx bx-trash"></i> Delete
                                                    </button>
                                                    <button class="btn btn-action-view btn-view-submission btn-sm" onclick="viewTaskSubmissions({{ $task->id }})">
                                                        <i class="bx bx-file-find"></i> View Submissions
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- General Instructions Tab -->
                    <div class="tab-pane fade" id="instructions" role="tabpanel">
                        <!-- Header with Title and Button -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                            <h5 style="color: #242a62; font-weight: 700; margin: 0; font-size: 18px;">
                                <i class="bx bx-file"></i> General Instructions
                            </h5>
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#updateInstructionsModal"
                                style="background: #f26e2c; color: white; padding: 10px 20px; border-radius: 6px; font-weight: 600; border: none; box-shadow: 0 2px 8px rgba(242, 110, 44, 0.3);">
                                <i class="bx bx-edit"></i> Update Instructions
                            </button>
                        </div>

                        <!-- Instructions Content Display -->
                        <div
                            style="background: #f8f9fa; border-radius: 10px; padding: 30px; border-left: 4px solid #242a62; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                            <style>#instructionsDisplayContent{display:none}</style>
                            <div id="instructionsDisplayServer" style="color: #495057; font-size: 14px; line-height: 1.8;">
                                {!! $internship->general_instructions ?? '<p style="color: #6c757d; margin-bottom: 20px;">No instructions have been set yet.</p>' !!}
                            </div>
                            <div id="instructionsDisplayContent"
                                style="color: #495057; font-size: 14px; line-height: 1.8;">
                                <h6 style="color: #242a62; font-weight: 700; margin-bottom: 15px;">Welcome to the
                                    Full-Stack Web Development Internship!</h6>

                                <p style="color: #6c757d; margin-bottom: 20px;">Please read the following instructions
                                    carefully before starting your Internship:</p>

                                <h6 style="color: #242a62; font-weight: 700; margin-top: 25px; margin-bottom: 12px;">
                                    General Guidelines:</h6>
                                <ul style="margin-left: 20px; margin-bottom: 20px; color: #495057;">
                                    <li style="margin-bottom: 8px;">Attend all scheduled sessions on time</li>
                                    <li style="margin-bottom: 8px;">Complete all assigned tasks before the deadline</li>
                                    <li style="margin-bottom: 8px;">Maintain professional communication with mentors and
                                        peers</li>
                                    <li style="margin-bottom: 8px;">Follow the code of conduct at all times</li>
                                </ul>

                                <h6 style="color: #242a62; font-weight: 700; margin-top: 25px; margin-bottom: 12px;">Task
                                    Submission:</h6>
                                <ul style="margin-left: 20px; margin-bottom: 20px; color: #495057;">
                                    <li style="margin-bottom: 8px;">Submit tasks in the specified format (ZIP file with
                                        proper folder structure)</li>
                                    <li style="margin-bottom: 8px;">Include a README file with setup instructions</li>
                                    <li style="margin-bottom: 8px;">Ensure your code is well-commented and follows best
                                        practices</li>
                                </ul>

                                <h6 style="color: #242a62; font-weight: 700; margin-top: 25px; margin-bottom: 12px;">
                                    Communication:</h6>
                                <ul style="margin-left: 20px; margin-bottom: 20px; color: #495057;">
                                    <li style="margin-bottom: 8px;">Use official email for all communications</li>
                                    <li style="margin-bottom: 8px;">Response time: Within 24 hours on working days</li>
                                    <li style="margin-bottom: 8px;">Weekly progress meetings every Friday at 3:00 PM</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Complete Program Tab -->
                    <div class="tab-pane fade" id="complete" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                                    @if($internship->company_complete_sts == 1 || $internship->complete_status == 1)
                                        @if($internship->internship_type == 2)
                                            <i class="bx bx-message-square-detail"></i> View Feedback and Certificate | {{ $internship->internship_title }}
                                        @else
                                            <i class="bx bx-eye"></i> View Marks and Certificate | {{ $internship->internship_title }}
                                        @endif
                                    @else
                                        <i class="bx bx-check-circle"></i> Complete The Internship | {{ $internship->internship_title }}
                                    @endif
                                </h5>
                                <p class="text-muted mb-0" style="font-size: 14px; margin-top: 5px;">
                                    @if($internship->company_complete_sts == 1 || $internship->complete_status == 1)
                                        @if($internship->internship_type == 2)
                                            Review submitted student feedback
                                        @else
                                            Review submitted student marks and grades
                                        @endif
                                    @else
                                        Evaluate student performance and assign grades
                                    @endif
                                </p>
                            </div>
                            <button class="btn export-btn" onclick="exportToExcel()">
                                <i class="fa fa-file-excel-o"></i> Export to Excel
                            </button>
                        </div>

                        @if($internship->internship_type == 2 && $internship->company_complete_sts == 1)
                            <div class="alert alert-success d-flex align-items-center" role="alert" style="margin-bottom:18px;">
                                <i class="bx bx-check-circle" style="font-size:20px;"></i>
                                <div class="ms-3">
                                    <strong>Completed by company.</strong> This is a company-only Internship and marks are submitted.
                                </div>
                            </div>
                        @elseif($internship->company_complete_sts == 1 && $internship->college_complete_sts == 0 && $internship->complete_status == 0)
                            <div class="alert alert-success d-flex align-items-center" role="alert" style="margin-bottom:18px;">
                                <i class="bx bx-check-circle" style="font-size:20px;"></i>
                                @if($internship->internship_type == 1)
                                    <div class="ms-3">
                                        <strong>Marks submitted successfully. Editing is disabled.</strong> College side marks are still pending.
                                    </div>
                                @else
                                    <div class="ms-3">
                                        <strong>Marks submitted successfully. Editing is disabled.</strong>
                                    </div>
                                @endif
                            </div>
                        @elseif($internship->complete_status == 1)
                            <div class="alert alert-success" role="alert">
                                <i class="bx bx-check-circle"></i> <strong>Completed!</strong> This Internship has been finalized. Grades and feedback are locked.
                            </div>
                        @endif

                        @php
                            $colspan = 2; // SR.NO, STUDENT
                            if($internship->internship_type == 1) $colspan++; // COLLEGE
                            if($internship->internship_type == 1 && $hasIndustryCriteria) $colspan++;
                            $colspan += 1; // FEEDBACK
                            if($internship->internship_type == 1) $colspan += 3; // TOTAL, PERCENTAGE, GRADE
                            if($internship->company_complete_sts == 1 || $internship->complete_status == 1) $colspan++; // CERTIFICATE
                        @endphp

                        <div class="table-responsive complete-program-table-wrap">
                            <table class="complete-internship-table" id="completionTable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="col-sr">SR.NO</th>
                                        <th class="col-student">STUDENT</th>
                                        @if($internship->internship_type == 1)
                                            <th class="col-college">COLLEGE</th>
                                        @endif

                                        @if($internship->internship_type == 1)
                                            <th class="col-industry">INDUSTRY MARKS</th>
                                        @endif
                                        <th class="col-feedback">FEEDBACK</th>
                                        @if($internship->internship_type == 1)
                                            <th class="col-total">TOTAL</th>
                                            <th class="col-percent">%</th>
                                            <th class="col-grade">GRADE</th>
                                        @endif
                                        @if($internship->company_complete_sts == 1 || $internship->complete_status == 1)
                                            <th class="col-certificate">CERTIFICATE</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $index => $application)
                                        @php
                                            $student = $application->user;
                                            $college = $student ? $student->college : null;
                                            $studentSavedMarks = isset($savedMarks[$student->id]) ? $savedMarks[$student->id]->keyBy('criteria_id') : collect();
                                            $savedFeedback = $savedFeedbacks[$student->id] ?? '';
                                            $isSubmitted = $internship->company_complete_sts == 1;
                                            $studentCriteria = $studentCriteriaMap[$student->id] ?? collect();
                                            $maxTotal = $studentCriteria->sum('marks');
                                        @endphp
                                        <tr data-student-id="{{ $student->id }}">
                                            <td class="col-sr">{{ $index + 1 }}</td>
                                            <td class="col-student">
                                                <div>{{ strtoupper($student->name ?? 'N/A') }}</div>
                                            </td>
                                            @if($internship->internship_type == 1)
                                            <td class="col-college">{{ $college ? $college->college_name : 'N/A' }}</td>
                                            @endif
                                            @if($internship->internship_type == 1)
                                            <td class="col-industry">
                                                
                                                @if($studentCriteria->count() > 0)
                                                    @foreach($studentCriteria as $criterion)
                                                        <div class="marks-input-group">
                                                            <label>{{ $criterion->title }}</label>
                                                            <input type="number"
                                                                   class="marks-input industry-mark"
                                                                   min="0"
                                                                   max="{{ $criterion->marks }}"
                                                                   data-max="{{ $criterion->marks }}"
                                                                   data-criteria-id="{{ $criterion->id }}"
                                                                   data-criteria-name="{{ $criterion->title }}"
                                                                   data-student-id="{{ $student->id }}"
                                                                   placeholder="0"
                                                                   value="{{ isset($studentSavedMarks[$criterion->id]) ? $studentSavedMarks[$criterion->id]->marks : '' }}"
                                                                   {{ $isSubmitted ? 'disabled' : '' }}>
                                                            <span class="max-marks">/ {{ $criterion->marks }}</span>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="text-muted" style="font-size:12px;">No grade configured</div>
                                                @endif
                                            </td>
                                            @endif
                                            <td class="col-feedback">
                                                <textarea class="feedback-textarea"
                                                          data-student-id="{{ $student->id }}"
                                                          placeholder="Enter feedback for student..."
                                                          {{ $isSubmitted ? 'disabled' : '' }}>{{ $savedFeedback }}</textarea>
                                            </td>
                                            @if($internship->internship_type == 1)
                                                <td class="col-total total-display">0 / {{ $maxTotal }}</td>
                                                <td class="col-percent percentage-display">0.00%</td>
                                                <td class="col-grade">
                                                    <span class="grade-badge grade-F">-</span>
                                                </td>
                                            @endif
                                            @if($internship->company_complete_sts == 1 || $internship->complete_status == 1)
                                                <td class="col-certificate">
                                                    <a class="btn-company-cert"
                                                       href="{{ route('company-internship-certificate.download', ['applicationId' => $application->id, 'type' => 'company']) }}">
                                                        <i class="bx bx-download"></i> Company Certificate
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($internship->company_complete_sts == 0 && $students->count() > 0)
                        <div class="text-center mt-4">
                            <button class="btn btn-complete-internship-submit" onclick="showConfirmModal()">
                                <i class="fa fa-check-circle"></i> Submit & Complete Program
                            </button>
                        </div>
                        @endif

                        <div class="alert alert-info mt-4" role="alert">
                            <i class="bx bx-info-circle"></i> <strong>Note:</strong> Once submitted, student grades and
                            feedback cannot be modified. Please review all entries carefully before submission.
                        </div>
                    </div>

                 
                </div>
            </div>
        </section>
    </main>

    <!-- Task Details Modal -->
    <div class="modal fade" id="taskDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header modal-header-history">
                    <div>
                        <h5 class="modal-title" style="color: #fff!important;">
                            <i class="bx bx-task"></i> Task Details
                        </h5>
                        <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;color:#fff;">Complete information about
                            the task</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" style="color: #fff;"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
                    <div class="section-card">
                        <h6><i class="bx bx-info-circle"></i> Task Information</h6>
                        <div class="detail-row-view">
                            <span class="detail-label-view">Task Title:</span>
                            <span class="detail-value-view" id="modal-task-title">-</span>
                        </div>
                        <div class="detail-row-view">
                            <span class="detail-label-view">Description: <br><br>
                            <span class="detail-value-view" id="modal-task-description">-</span>
                            </span>
                            
                        </div>
                        <div class="detail-row-view">
                            <span class="detail-label-view">Upload Date:</span>
                            <span class="detail-value-view" id="modal-task-upload">-</span>
                        </div>
                        <div class="detail-row-view">
                            <span class="detail-label-view">Due Date:</span>
                            <span class="detail-value-view" id="modal-task-due">-</span>
                        </div>
                        <div class="detail-row-view">
                            <span class="detail-label-view">Day:</span>
                            <span class="detail-value-view" id="modal-task-day">-</span>
                        </div>
                        <div class="detail-row-view">
                            <span class="detail-label-view">Task File:</span>
                            <span class="detail-value-view" id="modal-task-file">-</span>
                        </div>
                        <div class="detail-row-view">
                            <span class="detail-label-view">Online Link:</span>
                            <span class="detail-value-view" id="modal-task-online-link">-</span>
                        </div>
                        <div class="detail-row-view">
                            <span class="detail-label-view">Final Assignment:</span>
                            <span class="detail-value-view" id="modal-task-final">-</span>
                        </div>
                        <div class="detail-row-view">
                            <span class="detail-label-view">Status:</span>
                            <span class="detail-value-view" id="modal-task-status">
                                <span class="badge bg-secondary">-</span>
                            </span>
                        </div>
                    </div>

                    {{-- <div class="section-card">
                        <h6><i class="bx bx-file"></i> Your Submission</h6>
                        <div class="detail-row-view">
                            <span class="detail-label-view">Submitted On:</span>
                            <span class="detail-value-view" id="modal-submitted-on">-</span>
                        </div>
                        <div class="detail-row-view">
                            <span class="detail-label-view">Submitted File:</span>
                            <span class="detail-value-view" id="modal-submitted-file">-</span>
                        </div>
                        <div class="detail-row-view">
                            <span class="detail-label-view">Project Link:</span>
                            <span class="detail-value-view" id="modal-project-link">-</span>
                        </div>
                        <div class="detail-row-view">
                            <span class="detail-label-view">Notes:</span>
                            <span class="detail-value-view" id="modal-notes">-</span>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer" style="background: white; padding: 20px 30px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Task Modal -->
    <div class="modal fade" id="submitTaskModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header modal-header-history">
                    <div>
                        <h5 class="modal-title" style="color: #fff;">
                            <i class="bx bx-upload"></i> Submit Task
                        </h5>
                        <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;">Upload your completed task</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
                    <form id="submitTaskForm">
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Upload File <span style="color: red;">*</span>
                            </label>
                            <input type="file" class="form-control" id="taskSubmissionFile" required
                                style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                            <small class="text-muted">Accepted formats: ZIP, PDF, DOC, DOCX (Max: 10MB)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Project Link (Optional)
                            </label>
                            <input type="url" class="form-control" id="taskProjectLink"
                                placeholder="https://example.com/your-project"
                                style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                Notes/Description <span style="color: red;">*</span>
                            </label>
                            <textarea class="form-control" id="taskNotes" rows="5" required
                                placeholder="Describe your submission, technologies used, and any additional information..."
                                style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="background: white; padding: 20px 30px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x"></i> Cancel
                    </button>
                    <button type="button" class="btn" onclick="submitTaskForm()"
                        style="background: #242a62; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                        <i class="bx bx-upload"></i> Submit Task
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-lg-down modal-dialog-centered" style="max-width: 1000px; width: 95%;">
            <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header modal-header-history">
                    <div>
                        <h5 class="modal-title" id="addTaskModalTitle" style="color: #fff;">
                            <i class="bx bx-plus-circle"></i> Add New Task
                        </h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
                    <form id="addTaskForm">
                        <input type="hidden" id="editTaskId" value="">
                        <div class="row">
                            <!-- Date & Time -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                    Date & Time <span style="color: red;">*</span>
                                </label>
                                <input type="datetime-local" class="form-control" id="taskDateTime" name="task_datetime"
                                    required style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                            </div>

                            <!-- Day -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                    Day
                                </label>
                                <input type="text" class="form-control" id="taskDay" name="task_day" readonly
                                    placeholder="e.g., Monday"
                                    style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px; background:#f8f9fa;">
                            </div>

                            <!-- Module Title -->
                            <div class="col-12 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                    Module Title <span style="color: red;">*</span>
                                </label>
                                <input type="text" class="form-control" id="moduleTitle" name="module_title"
                                    placeholder="Enter Module title" required
                                    style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                            </div>

                            <!-- Module and Task Description -->
                            <div class="col-12 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                    Module and Task Description <span style="color: red;">*</span>
                                </label>
                                <textarea class="form-control" id="taskDescription" name="task_description" rows="6"
                                    placeholder="Enter detailed description of the module and task..."
                                    style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;"></textarea>
                            </div>

                            <!-- Upload File (Optional) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                    Upload File (Optional)
                                </label>
                                <input type="file" accept=".pdf,application/pdf" class="form-control" id="taskFile" name="task_file"
                                    style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                            </div>

                            <!-- Last Submission Date -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                    Last Submission Date <span style="color: red;">*</span>
                                </label>
                                <input type="date" class="form-control" id="lastSubmissionDate"
                                    name="last_submission_date" required
                                    style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                            </div>

                            <!-- Online Link -->
                            <div class="col-12 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px;">
                                    Online Link
                                </label>
                                <input type="url" class="form-control" id="onlineLink" name="online_link"
                                    placeholder="Enter Online Link"
                                    style="padding: 10px; border: 1px solid #ced4da; border-radius: 6px;">
                            </div>

                            <!-- Is this the Final Assignment / Report? -->
                            <div class="col-12 mb-3">
                                <div class="form-check" style="padding-left: 1.5em;">
                                    <input class="form-check-input" type="checkbox" id="isFinalAssignment"
                                        name="is_final_assignment" style="width: 18px; height: 18px; margin-top: 0.15em;">
                                    <label class="form-check-label" for="isFinalAssignment"
                                        style="font-weight: 600; color: #495057; font-size: 14px; margin-left: 8px;">
                                        Is this the Final Assignment / Report?
                                    </label>
                                </div>
                                <small class="text-muted" style="margin-left: 2.5em; display: block; margin-top: 4px;">
                                    Check this box if the task is the final assignment or report for this Internship.
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="padding: 10px 24px; border-radius: 6px; font-weight: 600;">
                        <i class="bx bx-x"></i> Cancel
                    </button>
                    <button type="button" class="btn" id="saveTaskBtn" onclick="saveNewTask()"
                        style="background: #242a62; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                        <i class="bx bx-save"></i> Save Module
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Submissions Modal -->
    <div class="modal fade" id="taskSubmissionsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-lg-down modal-dialog-centered modal-dialog-scrollable"
            style="max-width: 1200px; width: 95%;">
            <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header modal-header-history">
                    <div>
                        <h5 class="modal-title" style="color: #fff;">
                            <i class="bx bx-file-find"></i> Task Submissions
                        </h5>
                        <p id="submissions-modal-task-name" style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9; color:#fff;">Task: Loading...</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px; background: #f8f9fa;">
                    <!-- Submission Statistics -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div style="background: #eee; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #28a745;">
                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                    <div>
                                        <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">COMPLETED</p>
                                        <h4 id="submissions-completed-count" style="margin: 5px 0 0 0; color: #28a745; font-weight: 700; font-size: 28px;">0</h4>
                                    </div>
                                    <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(40, 167, 69, 0.1); display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-check-circle" style="font-size: 28px; color: #28a745;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="background: #eee; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #ffc107;">
                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                    <div>
                                        <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">PENDING</p>
                                        <h4 id="submissions-pending-count" style="margin: 5px 0 0 0; color: #ffc107; font-weight: 700; font-size: 28px;">0</h4>
                                    </div>
                                    <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(255, 193, 7, 0.1); display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-clock-o" style="font-size: 28px; color: #ffc107;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="background: #eee; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid #17a2b8;">
                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                    <div>
                                        <p style="margin: 0; color: #6c757d; font-size: 12px; font-weight: 600; text-transform: uppercase;">TOTAL STUDENTS</p>
                                        <h4 id="submissions-total-count" style="margin: 5px 0 0 0; color: #17a2b8; font-weight: 700; font-size: 28px;">0</h4>
                                    </div>
                                    <div style="width: 50px; height: 50px; border-radius: 10px; background: rgba(23, 162, 184, 0.1); display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-user" style="font-size: 28px; color: #17a2b8;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student Submission Status -->
                    <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 style="color: #242a62; font-weight: 700; margin: 0;">
                                <i class="bx bx-list-ul"></i> Student Submission Status
                            </h6>
                            <span id="submissions-submitted-badge" class="badge" style="background: #17a2b8; color: white; font-size: 13px; padding: 8px 14px;">
                                0/0 Submitted
                            </span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" style="margin: 0;">
                                <thead style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                                    <tr>
                                        <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px;">Sr. No.</th>
                                        <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px;">Student Name</th>
                                        <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px;">Email</th>
                                        <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px;">Task Title</th>
                                        <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px;">Submit Status</th>
                                        <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px;">Submit On</th>
                                        <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px; text-align: center;">View File</th>
                                        <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px; text-align: center;">Note</th>
                                        <th style="font-weight: 600; color: #495057; font-size: 13px; padding: 12px; text-align: center;">Feedback</th>
                                    </tr>
                                </thead>
                                <tbody id="submissions-table-body">
                                    <tr>
                                        <td colspan="9" class="text-center">Loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="padding: 10px 24px; border-radius: 6px; font-weight: 600;">
                        <i class="bx bx-x"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Submission Note Modal -->
    <div class="modal fade" id="studentSubmissionNoteModal" tabindex="-1"
        aria-labelledby="studentSubmissionNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 900px; width: 95%;">
            <div class="modal-content" style="border: none; border-radius: 15px; overflow: hidden;">
                <div class="modal-header" style="background: #242a62; border: none; padding: 25px 30px; color: white;">
                    <div>
                        <h5 class="modal-title" id="studentSubmissionNoteModalLabel"
                            style="font-weight: 700; font-size: 20px; margin: 0 0 5px 0;">
                            <i class="bx bx-note"></i> Student Submission Note
                        </h5>
                        <p style="margin: 0; font-size: 14px; opacity: 0.95;color:#fff;">Student: <span
                                id="studentNameDisplay">Loading...</span></p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body" style="background: #f8f9fa; padding: 30px;">
                    <!-- Submission Details Section -->
                    <div
                        style="background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; border-left: 4px solid #242a62; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <h6 style="color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                            <i class="bx bx-info-circle"></i> Submission Details
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div style="margin-bottom: 15px;">
                                    <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Task Title:</label>
                                    <p style="margin: 0; color: #212529; font-size: 14px;" id="noteTaskTitle">-</p>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Status:</label>
                                    <span id="noteStatus"><span class="badge bg-secondary">Loading</span></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="margin-bottom: 15px;">
                                    <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Submitted On:</label>
                                    <p style="margin: 0; color: #212529; font-size: 14px;" id="noteSubmittedDate">-</p>
                                </div>
                                <div style="margin-bottom: 15px;">
                                    <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Submission File:</label>
                                    <span id="noteSubmitFile">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student's Note/Description Section -->
                    <div
                        style="background: white; border-radius: 10px; padding: 25px; margin-bottom: 20px; border-left: 4px solid #f26e2c; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <h6 style="color: #f26e2c; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                            <i class="bx bx-message-square-detail"></i> Student's Note/Description
                        </h6>
                        <div style="color: #495057; font-size: 14px; line-height: 1.8;" id="studentNoteContent">
                            <p class="text-muted">No note provided.</p>
                        </div>
                    </div>

                    <!-- Project Link Section -->
                    <div
                        style="background: white; border-radius: 10px; padding: 25px; border-left: 4px solid #17a2b8; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <h6 style="color: #17a2b8; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                            <i class="bx bx-link"></i> Project Link
                        </h6>
                        <span id="projectLinkDisplay" style="color: #6c757d; font-size: 14px;">-</span>
                    </div>
                </div>

                <div class="modal-footer"
                    style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6;">
                    <button type="button" class="btn" data-bs-dismiss="modal"
                        style="background: #6c757d; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                        <i class="bx bx-x"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Feedback Modal -->
    <div class="modal fade" id="taskFeedbackModal" tabindex="-1" aria-labelledby="taskFeedbackModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 900px; width: 95%;">
            <div class="modal-content" style="border: none; border-radius: 15px; overflow: hidden;">
                <div class="modal-header" style="background: #242a62; border: none; padding: 25px 30px; color: white;">
                    <div>
                        <h5 class="modal-title" id="taskFeedbackModalLabel"
                            style="font-weight: 700; font-size: 20px; margin: 0 0 5px 0;">
                            <i class="bx bx-message-dots"></i> Task Feedback
                        </h5>
                        <p style="margin: 0; font-size: 14px; opacity: 0.95;color:#fff;">Student: <span
                                id="feedbackStudentName">Loading...</span></p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" style="background: #f8f9fa; padding: 30px;">
                    <!-- Task Information -->
                    <div
                        style="background: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; border-left: 4px solid #17a2b8; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <div class="row">
                            <div class="col-md-6">
                                <div style="margin-bottom: 10px;">
                                    <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Task Title:</label>
                                    <p style="margin: 0; color: #212529; font-size: 14px;" id="feedbackTaskTitle">-</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="margin-bottom: 10px;">
                                    <label style="font-weight: 600; color: #666; font-size: 13px; margin-bottom: 5px; display: block;">Submission Status:</label>
                                    <span id="feedbackStatus"><span class="badge bg-secondary">Loading</span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Feedback Display (shown when feedback exists) -->
                    <div id="feedbackViewSection" style="display: none;">
                        <div style="background: white; border-radius: 10px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #28a745;">
                            <h6 style="color: #28a745; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                                <i class="bx bx-check-circle"></i> Feedback (Already Submitted)
                            </h6>
                            <div id="feedbackViewContent" style="color: #495057; font-size: 14px; line-height: 1.8; white-space: pre-wrap;"></div>
                        </div>
                    </div>

                    <!-- Feedback Form (shown when no feedback exists) -->
                    <div id="feedbackFormSection">
                        <div style="background: white; border-radius: 10px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                            <h6 style="color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 20px;">
                                <i class="bx bx-edit"></i> Provide Feedback
                            </h6>
                            <div class="mb-3">
                                <label class="form-label" style="font-weight: 600; color: #495057; font-size: 14px; margin-bottom: 10px;">
                                    Feedback <span style="color: #dc3545;">*</span>
                                </label>
                                <textarea class="form-control" id="feedbackText" name="feedback" rows="8"
                                    style="padding: 15px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px;"
                                    placeholder="Provide detailed feedback on the student's task submission..."></textarea>
                                <small class="text-muted" style="font-size: 12px; margin-top: 5px; display: block;">
                                    <i class="bx bx-info-circle"></i> Provide constructive feedback to help the student improve
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer"
                    style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6; display: flex; justify-content: space-between;">
                    <button type="button" class="btn" data-bs-dismiss="modal"
                        style="background: #6c757d; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                        <i class="bx bx-x"></i> Close
                    </button>
                    <button type="button" class="btn" id="feedbackSubmitBtn" onclick="submitFeedback()"
                        style="background: #17a2b8; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                        <i class="bx bx-send"></i> Submit Feedback
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Instructions Modal -->
    <div class="modal fade" id="updateInstructionsModal" tabindex="-1" aria-labelledby="updateInstructionsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-lg-down" style="max-width: 1000px; width: 95%;">
            <div class="modal-content" style="border: none; border-radius: 15px; overflow: hidden;">
                <!-- Modal Header with Gradient -->
                <div class="modal-header" style="background: #242a62; border: none; padding: 25px 30px; color: white;">
                    <div>
                        <h5 class="modal-title" id="updateInstructionsModalLabel"
                            style="font-weight: 700; font-size: 20px; margin: 0 0 5px 0;">
                            <i class="bx bx-edit"></i> Update General Instructions
                        </h5>
                        <p style="margin: 0; font-size: 14px; opacity: 0.95;">Edit the general instructions for students
                        </p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body" style="background: #f8f9fa; padding: 30px;">
                    <div style="margin-bottom: 20px;">
                        <label
                            style="font-weight: 600; color: #495057; font-size: 14px; margin-bottom: 10px; display: block;">
                            Instructions Content
                        </label>

                        <!-- Text Editor Toolbar -->
                        <div
                            style="background: #f8f9fa; border: 1px solid #dee2e6; border-bottom: none; border-radius: 6px 6px 0 0; padding: 10px; display: flex; gap: 5px; flex-wrap: wrap;">
                            <select
                                style="padding: 5px 10px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px; background: white;">
                                <option>Paragraph</option>
                                <option>Heading 1</option>
                                <option>Heading 2</option>
                                <option>Heading 3</option>
                            </select>
                            <div style="display: flex; gap: 2px; border-left: 1px solid #dee2e6; padding-left: 8px;">
                                <button type="button"
                                    style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold;"
                                    title="Bold">
                                    <strong>B</strong>
                                </button>
                                <button type="button"
                                    style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-style: italic;"
                                    title="Italic">
                                    <em>I</em>
                                </button>
                                <button type="button"
                                    style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                    title="Link">
                                    <i class="bx bx-link"></i>
                                </button>
                            </div>
                            <div style="display: flex; gap: 2px; border-left: 1px solid #dee2e6; padding-left: 8px;">
                                <button type="button"
                                    style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                    title="Bullet List">
                                    <i class="bx bx-list-ul"></i>
                                </button>
                                <button type="button"
                                    style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                    title="Numbered List">
                                    <i class="bx bx-list-ol"></i>
                                </button>
                            </div>
                            <div style="display: flex; gap: 2px; border-left: 1px solid #dee2e6; padding-left: 8px;">
                                <button type="button"
                                    style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                    title="Quote">
                                    <i class="bx bx-quote-left"></i>
                                </button>
                                <button type="button"
                                    style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                    title="Table">
                                    <i class="bx bx-table"></i>
                                </button>
                            </div>
                            <div style="display: flex; gap: 2px; border-left: 1px solid #dee2e6; padding-left: 8px;">
                                <button type="button"
                                    style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                    title="Undo">
                                    <i class="bx bx-undo"></i>
                                </button>
                                <button type="button"
                                    style="width: 32px; height: 32px; border: 1px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                    title="Redo">
                                    <i class="bx bx-redo"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Content Editor Area (server-rendered form) -->
                        <form id="updateInstructionsForm" method="POST" action="{{ route('website.internship.instructions.save', $internship->id ?? 0) }}">
                            @csrf
                            <textarea id="instructionsContent" name="general_instructions"
                                style="min-height: 400px; border: 1px solid #dee2e6; border-radius: 0 0 6px 6px; padding: 20px; background: white; font-size: 14px; line-height: 1.8; color: #495057; width:100%;">{!! $internship->general_instructions ?? '<p style="color: #6a7681; margin-bottom: 15px;">Welcome to the Full-Stack Web Development Internship!</p>

<p style="margin-bottom: 15px;">Please read the following instructions carefully before starting your Internship:</p>

<p style="font-weight: 600; margin-top: 20px; margin-bottom: 10px;">General Guidelines:</p>
<ul style="margin-left: 20px; margin-bottom: 15px;">
    <li>Attend all scheduled sessions on time</li>
    <li>Complete all assigned tasks before the deadline</li>
    <li>Maintain professional communication with mentors and peers</li>
    <li>Follow the code of conduct at all times</li>
</ul>

<p style="font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Task Submission:</p>
<ul style="margin-left: 20px; margin-bottom: 15px;">
    <li>Submit tasks in the specified format (ZIP file with proper folder structure)</li>
    <li>Include a README file with setup instructions</li>
    <li>Ensure your code is well-commented and follows best practices</li>
</ul>

<p style="font-weight: 600; margin-top: 20px; margin-bottom: 10px;">Communication:</p>
<ul style="margin-left: 20px; margin-bottom: 15px;">
    <li>Use official email for all communications</li>
    <li>Response time: Within 24 hours on working days</li>
    <li>Weekly progress meetings every Friday at 3:00 PM</li>
</ul>' !!}</textarea>
                        </form>
                    </div>
                </div>

                <div class="modal-footer"
                    style="background: white; padding: 20px 30px; border-top: 1px solid #dee2e6; display: flex; justify-content: space-between;">
                    <button type="button" class="btn" data-bs-dismiss="modal"
                        style="background: #6c757d; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                        <i class="bx bx-x"></i> Cancel
                    </button>
                    <button type="submit" class="btn" form="updateInstructionsForm"
                        style="background: #28a745; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600; border: none;">
                        <i class="bx bx-save"></i> Save Instructions
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endpush

@push('script')
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
@php
    $completionAlerts = $internship->internship_type == 2 ? [
        'tabTitle' => 'Open Complete Program',
        'tabText' => 'You are about to review student feedback and complete this industry Internship.',
        'tabConfirm' => 'Continue',
        'submitTitle' => 'Confirm Program Completion',
        'submitHtml' => '<p>This will finalize all student feedback and mark the Internship as completed.</p><p><strong>This action cannot be undone.</strong></p>',
        'submitConfirm' => '<i class="fa fa-check-circle"></i> Yes, Complete Program',
        'loadingTitle' => 'Completing...',
        'loadingText' => 'Please wait while we finalize the Internship',
        'incompleteText' => 'Please fill in feedback for all students before submitting.',
    ] : [
        'tabTitle' => 'Open Complete Program',
        'tabText' => 'You are about to evaluate students and submit industry marks. College marks will still be required after submission.',
        'tabConfirm' => 'Continue',
        'submitTitle' => 'Submit Industry Marks',
        'submitHtml' => '<p>This will submit industry (company) marks and feedback for all students.</p><p><strong>College marks are still required before the Internship can be fully completed.</strong></p>',
        'submitConfirm' => '<i class="fa fa-check-circle"></i> Yes, Submit Industry Marks',
        'loadingTitle' => 'Submitting...',
        'loadingText' => 'Please wait while we submit industry marks',
        'incompleteText' => 'Please fill in all industry marks and feedback for all students before submitting.',
    ];
@endphp
    <script>
        let taskDescriptionEditor = null;
        let instructionsEditor = null;

        // View Task Details
        window.viewTaskDetails = function(taskId) {
            const modalEl = document.getElementById('taskDetailsModal');
            const modal = new bootstrap.Modal(modalEl);

            // show loading state
            document.getElementById('modal-task-title').textContent = 'Loading...';
            document.getElementById('modal-task-description').textContent = 'Please wait while we load task details.';
            document.getElementById('modal-task-upload').textContent = '-';
            document.getElementById('modal-task-due').textContent = '-';
            document.getElementById('modal-task-file').textContent = '-';
            document.getElementById('modal-task-online-link').textContent = '-';
            document.getElementById('modal-task-final').textContent = '-';
            document.getElementById('modal-task-status').innerHTML = '<span class="badge bg-secondary">Loading</span>';
      

            modal.show();

            // build URL (use route helper placeholder)
            let url = '{{ route("internship.task.json", ":id") }}';
            url = url.replace(':id', taskId);

            $.ajax({
                url: url,
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(data) {
                    // populate modal fields
                    document.getElementById('modal-task-title').textContent = data.title || '-';
                    document.getElementById('modal-task-description').innerHTML = data.module_description || '-';
                    document.getElementById('modal-task-upload').textContent = data.date_time ? new Date(data.date_time).toLocaleString() : '-';
                    document.getElementById('modal-task-due').textContent = data.due_date ? new Date(data.due_date).toLocaleDateString() : '-';

                    // Day
                    document.getElementById('modal-task-day').textContent = data.day || '-';

                    // Task File
                    const taskFileEl = document.getElementById('modal-task-file');
                    if (data.upload_file) {
                        const fileHref = '{{ asset("uploads") }}/' + data.upload_file;
                        taskFileEl.innerHTML = '<a href="' + fileHref + '" class="badge bg-info" target="_blank" rel="noopener" title="Click To View"><i class="bx bx-download"></i>View Task File</a>';
                    } else {
                        taskFileEl.textContent = '-';
                    }

                    // Online Link
                    const onlineLinkEl = document.getElementById('modal-task-online-link');
                    if (data.online_link) {
                        onlineLinkEl.innerHTML = '<a href="' + data.online_link + '" target="_blank" rel="noopener" style="color:#17a2b8;"><i class="bx bx-link-external"></i> View Link</a>';
                    } else {
                        onlineLinkEl.textContent = '-';
                    }

                    // Final Assignment
                    document.getElementById('modal-task-final').textContent = data.is_final_assignment == 1 ? 'Yes' : 'No';

                    const statusEl = document.getElementById('modal-task-status');
                    if (data.status == 1) {
                        statusEl.innerHTML = '<span class="badge bg-success">Completed</span>';
                    } else {
                        statusEl.innerHTML = '<span class="badge bg-warning">Pending</span>';
                    }

                    // student submission
                    // document.getElementById('modal-submitted-on').textContent = data.submit_on ? new Date(data.submit_on).toLocaleString() : '-';

                    // const submittedFileEl = document.getElementById('modal-submitted-file');
                    // if (data.student_submit_file) {
                    //     const href = '{{ asset("uploads") }}/' + data.student_submit_file;
                    //     submittedFileEl.innerHTML = '<a href="' + href + '" class="badge bg-info" target="_blank" rel="noopener"><i class="bx bx-download"></i> ' + data.student_submit_file + '</a>';
                    // } else {
                    //     submittedFileEl.textContent = '-';
                    // }

                    // const projectLinkEl = document.getElementById('modal-project-link');
                    // if (data.student_submit_project_link) {
                    //     projectLinkEl.innerHTML = '<a href="' + data.student_submit_project_link + '" target="_blank" rel="noopener" style="color:#17a2b8;"><i class="bx bx-link-external"></i> View Link</a>';
                    // } else {
                    //     projectLinkEl.textContent = '-';
                    // }

                    // document.getElementById('modal-notes').textContent = data.student_description || '-';
                },
                error: function(xhr) {
                    console.error('Failed to load task details', xhr);
                    document.getElementById('modal-task-title').textContent = 'Error loading task';
                    document.getElementById('modal-task-description').textContent = 'Could not fetch task details.';
                    document.getElementById('modal-task-status').innerHTML = '<span class="badge bg-danger">Error</span>';
                }
            });
        }

        // Submit Task
        window.submitTask = function(taskId) {
            const modal = new bootstrap.Modal(document.getElementById('submitTaskModal'));
            modal.show();
            console.log('Submitting task ID:', taskId);
        }

        // Submit Task Form
        window.submitTaskForm = function() {
            const form = document.getElementById('submitTaskForm');
            if (form.checkValidity()) {
                alert('Task submitted successfully!');
                bootstrap.Modal.getInstance(document.getElementById('submitTaskModal')).hide();
            } else {
                form.reportValidity();
            }
        }

        // View Student Profile
        window.viewStudentProfile = function(studentId) {
            window.open('{{ url("candidate-profile-detail") }}/' + studentId, '_blank');
        }

        // Open Add Task Modal (new task)
        window.openAddTaskModal = function() {
            // Reset form for add mode
            document.getElementById('addTaskForm').reset();
            document.getElementById('editTaskId').value = '';
            document.getElementById('addTaskModalTitle').innerHTML = '<i class="bx bx-plus-circle"></i> Add New Task';
            document.getElementById('saveTaskBtn').innerHTML = '<i class="bx bx-save"></i> Save Module';
            document.getElementById('saveTaskBtn').setAttribute('onclick', 'saveNewTask()');

            // Clear CKEditor if initialized
            if (taskDescriptionEditor && typeof taskDescriptionEditor.setData === 'function') {
                taskDescriptionEditor.setData('');
            }

            const modal = new bootstrap.Modal(document.getElementById('addTaskModal'));

            // Initialize CKEditor for Module and Task Description when modal opens
            if (!taskDescriptionEditor) {
                if (typeof ClassicEditor !== 'undefined') {
                    ClassicEditor
                        .create(document.querySelector('#taskDescription'), {
                            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'blockQuote', '|', 'undo', 'redo']
                        })
                        .then(editor => {
                            taskDescriptionEditor = editor;
                        })
                        .catch(error => {
                            console.error('CKEditor init error:', error);
                        });
                }
            }

            modal.show();

            // Day auto-fill logic
            setupDayAutoFill();
        }

        // Open Edit Task Modal
        window.openEditTaskModal = function(taskId) {
            // Set edit mode
            document.getElementById('editTaskId').value = taskId;
            document.getElementById('addTaskModalTitle').innerHTML = '<i class="bx bx-edit"></i> Edit Task';
            document.getElementById('saveTaskBtn').innerHTML = '<i class="bx bx-save"></i> Update Module';
            document.getElementById('saveTaskBtn').setAttribute('onclick', 'updateExistingTask()');

            var modal = bootstrap.Modal.getInstance(document.getElementById('addTaskModal')) || new bootstrap.Modal(document.getElementById('addTaskModal'));

            // Initialize CKEditor first if not done
            var initAndPopulate = function() {
                // Fetch task data and populate
                var url = '{{ route("internship.task.json", ":id") }}';
                url = url.replace(':id', taskId);

                $.ajax({
                    url: url,
                    method: 'GET',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(data) {
                        // Populate fields
                        if (data.date_time) {
                            var dt = new Date(data.date_time);
                            var formatted = dt.getFullYear() + '-' +
                                String(dt.getMonth() + 1).padStart(2, '0') + '-' +
                                String(dt.getDate()).padStart(2, '0') + 'T' +
                                String(dt.getHours()).padStart(2, '0') + ':' +
                                String(dt.getMinutes()).padStart(2, '0');
                            document.getElementById('taskDateTime').value = formatted;
                        }
                        document.getElementById('taskDay').value = data.day || '';
                        document.getElementById('moduleTitle').value = data.title || '';

                        if (taskDescriptionEditor && typeof taskDescriptionEditor.setData === 'function') {
                            taskDescriptionEditor.setData(data.module_description || '');
                        } else {
                            document.getElementById('taskDescription').value = data.module_description || '';
                        }

                        if (data.due_date) {
                            document.getElementById('lastSubmissionDate').value = data.due_date;
                        }
                        document.getElementById('onlineLink').value = data.online_link || '';
                        document.getElementById('isFinalAssignment').checked = data.is_final_assignment ? true : false;

                        modal.show();
                        setupDayAutoFill();
                    },
                    error: function(xhr) {
                        console.error('Failed to load task data', xhr);
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load task data.' });
                    }
                });
            };

            if (!taskDescriptionEditor) {
                if (typeof ClassicEditor !== 'undefined') {
                    ClassicEditor
                        .create(document.querySelector('#taskDescription'), {
                            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'blockQuote', '|', 'undo', 'redo']
                        })
                        .then(editor => {
                            taskDescriptionEditor = editor;
                            initAndPopulate();
                        })
                        .catch(error => {
                            console.error('CKEditor init error:', error);
                            initAndPopulate();
                        });
                } else {
                    initAndPopulate();
                }
            } else {
                initAndPopulate();
            }
        }

        // Day auto-fill helper
        function setupDayAutoFill() {
            try {
                const dtInput = document.getElementById('taskDateTime');
                const dayInput = document.getElementById('taskDay');
                if (dayInput) {
                    dayInput.readOnly = true;
                    dayInput.style.background = '#f8f9fa';
                }

                if (dtInput && dayInput) {
                    const setDayFromDt = () => {
                        const v = dtInput.value;
                        if (!v) { dayInput.value = ''; return; }
                        const d = new Date(v);
                        if (isNaN(d.getTime())) { dayInput.value = ''; return; }
                        const days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                        dayInput.value = days[d.getDay()];
                    };

                    setDayFromDt();
                    dtInput.removeEventListener('change', setDayFromDt);
                    dtInput.addEventListener('change', setDayFromDt);
                }
            } catch (e) {
                console.error('Day auto-fill error:', e);
            }
        }

        // Confirm Delete Task
        window.confirmDeleteTask = function(taskId) {
            Swal.fire({
                title: 'Delete Task?',
                text: 'Are you sure you want to delete this task? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = '{{ url("internship/task") }}/' + taskId + '/delete';
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message || 'Task deleted successfully!', timer: 1800, showConfirmButton: false });
                                setTimeout(() => location.reload(), 900);
                            } else {
                                Swal.fire({ icon: 'error', title: 'Error', text: response.message || 'Failed to delete task.' });
                            }
                        },
                        error: function(xhr) {
                            var msg = 'Failed to delete task.';
                            if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                            Swal.fire({ icon: 'error', title: 'Error', text: msg });
                        }
                    });
                }
            });
        }

        // Update Existing Task
        window.updateExistingTask = function() {
            var taskId = document.getElementById('editTaskId').value;
            if (!taskId) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Task ID not found.' });
                return;
            }

            var form = document.getElementById('addTaskForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            var fileInput = document.getElementById('taskFile');
            if (fileInput && fileInput.files.length > 0) {
                var file = fileInput.files[0];
                var ext = file.name.split('.').pop().toLowerCase();
                if (ext !== 'pdf') {
                    Swal.fire({ icon: 'error', title: 'Invalid File', text: 'Only PDF files are allowed.' });
                    return;
                }
                if (file.size > 10 * 1024 * 1024) {
                    Swal.fire({ icon: 'error', title: 'File Too Large', text: 'Max file size is 10MB.' });
                    return;
                }
            }

            var formData = new FormData();
            formData.append('date_time', document.getElementById('taskDateTime').value);
            formData.append('day', document.getElementById('taskDay').value);
            formData.append('module_title', document.getElementById('moduleTitle').value);

            var moduleDesc = (taskDescriptionEditor && typeof taskDescriptionEditor.getData === 'function')
                ? taskDescriptionEditor.getData()
                : document.getElementById('taskDescription').value;

            if (!moduleDesc || moduleDesc.trim() === '' || moduleDesc.replace(/<(.|\n)*?>/g, '').trim() === '') {
                Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Module and Task Description is required.' });
                return;
            }

            formData.append('module_description', moduleDesc);
            formData.append('last_submission_date', document.getElementById('lastSubmissionDate').value);
            formData.append('online_link', document.getElementById('onlineLink').value);
            formData.append('is_final_assignment', document.getElementById('isFinalAssignment').checked ? 1 : 0);
            if (fileInput && fileInput.files.length > 0) {
                formData.append('upload_file', fileInput.files[0]);
            }

            var url = '{{ url("internship/task") }}/' + taskId + '/update';

            $.ajax({
                url: url,
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        var addTaskModal = bootstrap.Modal.getInstance(document.getElementById('addTaskModal'));
                        if (addTaskModal) addTaskModal.hide();

                        Swal.fire({ icon: 'success', title: 'Updated', text: response.message || 'Task updated successfully!', timer: 1800, showConfirmButton: false });
                        setTimeout(() => location.reload(), 900);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: response.message || 'Failed to update task.' });
                    }
                },
                error: function(xhr) {
                    var msg = 'Failed to update task.';
                    if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    Swal.fire({ icon: 'error', title: 'Error', text: msg });
                }
            });
        }

        // Save New Task
        window.saveNewTask = function() {
            const form = document.getElementById('addTaskForm');

            // Basic HTML5 validation
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const fileInput = document.getElementById('taskFile');
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const ext = file.name.split('.').pop().toLowerCase();
                if (ext !== 'pdf') {
                    Swal.fire({ icon: 'error', title: 'Invalid File', text: 'Only PDF files are allowed.' });
                    return;
                }
                if (file.size > 10 * 1024 * 1024) {
                    Swal.fire({ icon: 'error', title: 'File Too Large', text: 'Max file size is 10MB.' });
                    return;
                }
            }

            const formData = new FormData();
            formData.append('date_time', document.getElementById('taskDateTime').value);
            formData.append('day', document.getElementById('taskDay').value);
            formData.append('module_title', document.getElementById('moduleTitle').value);
            // Use CKEditor data if available
            const moduleDesc = (taskDescriptionEditor && typeof taskDescriptionEditor.getData === 'function')
                ? taskDescriptionEditor.getData()
                : document.getElementById('taskDescription').value;

            // Validate module description (CKEditor) since textarea is not HTML-required
            if (!moduleDesc || moduleDesc.trim() === '' || moduleDesc.replace(/<(.|\n)*?>/g, '').trim() === '') {
                Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Module and Task Description is required.' });
                return;
            }
            formData.append('module_description', moduleDesc);
            formData.append('last_submission_date', document.getElementById('lastSubmissionDate').value);
            formData.append('online_link', document.getElementById('onlineLink').value);
            formData.append('is_final_assignment', document.getElementById('isFinalAssignment').checked ? 1 : 0);
            if (fileInput && fileInput.files.length > 0) {
                formData.append('upload_file', fileInput.files[0]);
            }

            // AJAX post to create master task and duplicate per-student tasks server-side
            <?php
                use Illuminate\Support\Facades\Route as RouteFacade;
                if (RouteFacade::has('admin.internship.tasks.store')) {
                    $storeUrl = route('admin.internship.tasks.store', $internship->id);
                } elseif (RouteFacade::has('opportunity.tasks.store')) {
                    $storeUrl = route('internship.tasks.store', $internship->id);
                } else {
                    $storeUrl = url('admin/internship/' . $internship->id . '/tasks/store');
                }
            ?>

            $.ajax({
                url: '{{ $storeUrl }}',
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        const addTaskModal = bootstrap.Modal.getInstance(document.getElementById('addTaskModal'));
                        if (addTaskModal) addTaskModal.hide();

                        Swal.fire({ icon: 'success', title: 'Task Added', text: response.message || 'Task added successfully!', timer: 1800, showConfirmButton: false });
                        form.reset();
                        if (taskDescriptionEditor && typeof taskDescriptionEditor.setData === 'function') {
                            taskDescriptionEditor.setData('');
                        }

                        // Optionally reload tasks table or refresh page section
                        if (typeof loadTasks === 'function') {
                            loadTasks();
                        } else {
                            // attempt to refresh the page section
                            setTimeout(() => location.reload(), 900);
                        }
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: response.message || 'Failed to add task.' });
                    }
                },
                error: function(xhr) {
                    let msg = 'Failed to add task.';
                    if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    Swal.fire({ icon: 'error', title: 'Error', text: msg });
                }
            });
        }

        // View Task Submissions
        // Track the current submissions task ID for modal reopening
        var currentSubmissionsTaskId = null;

        // Reopen Task Submissions when Note or Feedback modal closes
        var reopenSubmissionsAfterChild = false;

        var studentSubmissionNoteModalEl = document.getElementById('studentSubmissionNoteModal');
        if (studentSubmissionNoteModalEl && studentSubmissionNoteModalEl.addEventListener) {
            studentSubmissionNoteModalEl.addEventListener('hidden.bs.modal', function () {
                if (currentSubmissionsTaskId && reopenSubmissionsAfterChild) {
                    reopenSubmissionsAfterChild = false;
                    viewTaskSubmissions(currentSubmissionsTaskId);
                }
            });
        }

        var taskFeedbackModalEl = document.getElementById('taskFeedbackModal');
        if (taskFeedbackModalEl && taskFeedbackModalEl.addEventListener) {
            taskFeedbackModalEl.addEventListener('hidden.bs.modal', function () {
                if (currentSubmissionsTaskId && reopenSubmissionsAfterChild) {
                    reopenSubmissionsAfterChild = false;
                    viewTaskSubmissions(currentSubmissionsTaskId);
                }
            });
        }

        window.viewTaskSubmissions = function(taskId) {
            currentSubmissionsTaskId = taskId;
            var modalEl = document.getElementById('taskSubmissionsModal');
            var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);

            // Reset to loading
            document.getElementById('submissions-modal-task-name').textContent = 'Task: Loading...';
            document.getElementById('submissions-completed-count').textContent = '0';
            document.getElementById('submissions-pending-count').textContent = '0';
            document.getElementById('submissions-total-count').textContent = '0';
            document.getElementById('submissions-submitted-badge').textContent = '0/0 Submitted';
            document.getElementById('submissions-table-body').innerHTML = '<tr><td colspan="8" class="text-center">Loading...</td></tr>';

            modal.show();

            var url = '{{ route("internship.task.submissions", ":id") }}';
            url = url.replace(':id', taskId);

            $.ajax({
                url: url,
                method: 'GET',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(data) {
                    document.getElementById('submissions-modal-task-name').textContent = 'Task: ' + (data.task_title || '-');
                    document.getElementById('submissions-completed-count').textContent = data.completed;
                    document.getElementById('submissions-pending-count').textContent = data.pending;
                    document.getElementById('submissions-total-count').textContent = data.total;
                    document.getElementById('submissions-submitted-badge').textContent = data.completed + '/' + data.total + ' Submitted';

                    var tbody = document.getElementById('submissions-table-body');
                    if (!data.students || data.students.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="9" class="text-center">No student submissions found.</td></tr>';
                        return;
                    }

                    var colors = ['#242a62', '#f26e2c', '#6f42c1', '#17a2b8', '#28a745', '#dc3545'];
                    var rows = '';
                    data.students.forEach(function(s, i) {
                        var initial = s.name ? s.name.charAt(0).toUpperCase() : '?';
                        var bgColor = colors[i % colors.length];

                        var statusBadge = '';
                        if (s.status == 1) {
                            statusBadge = '<span class="badge" style="background:#28a745;color:white;padding:6px 12px;font-size:12px;border-radius:20px;"><i class="bx bx-check-circle"></i> Complete</span>';
                        } else {
                            statusBadge = '<span class="badge" style="background:#ffc107;color:#000;padding:6px 12px;font-size:12px;border-radius:20px;"><i class="bx bx-time"></i> Pending</span>';
                        }

                        var submitOnCell = s.submit_on ? '<span style="color:#212529;font-size:12px;">' + s.submit_on + '</span>' : '<span style="color:#6c757d;font-size:12px;">-</span>';

                        var fileCell = '<span style="color:#6c757d;font-size:12px;">-</span>';
                        if (s.student_submit_file) {
                            fileCell = '<a href="{{ asset("uploads/internship_tasks_submit") }}/' + s.student_submit_file + '" target="_blank" rel="noopener" class="btn btn-sm" style="background:#6f42c1;color:white;border:none;padding:5px 12px;border-radius:5px;font-size:12px;"><i class="bx bx-file"></i> View File</a>';
                        }

                        var noteCell = '<span style="color:#6c757d;font-size:12px;">-</span>';
                        if (s.student_submit_description) {
                            noteCell = '<button class="btn btn-sm btn-view-note" style="background:#f26e2c;color:white;border:none;padding:5px 12px;border-radius:5px;font-size:12px;" data-task-id="' + data.master_task_id + '" data-student-id="' + s.student_id + '"><i class="bx bx-note"></i> Note</button>';
                        }

                        var feedbackCell = '';
                        if (s.task_feedback) {
                            feedbackCell = '<button class="btn btn-sm btn-view-feedback" style="background:#28a745;color:white;border:none;padding:5px 12px;border-radius:5px;font-size:12px;" data-task-id="' + data.master_task_id + '" data-student-id="' + s.student_id + '" data-student-name="' + (s.name || '').replace(/'/g, '&#39;') + '"><i class="bx bx-check-circle"></i> View Feedback</button>';
                        } else {
                            feedbackCell = '<button class="btn btn-sm btn-view-feedback" style="background:#17a2b8;color:white;border:none;padding:5px 12px;border-radius:5px;font-size:12px;" data-task-id="' + data.master_task_id + '" data-student-id="' + s.student_id + '" data-student-name="' + (s.name || '').replace(/'/g, '&#39;') + '"><i class="bx bx-message-dots"></i> Feedback</button>';
                        }

                        rows += '<tr>' +
                            '<td style="padding:12px;vertical-align:middle;">' + s.sr + '</td>' +
                            '<td style="padding:12px;vertical-align:middle;"><div style="display:flex;align-items:center;"><div style="width:35px;height:35px;border-radius:50%;background:' + bgColor + ';color:white;display:flex;align-items:center;justify-content:center;font-weight:600;margin-right:10px;">' + initial + '</div><span style="font-weight:600;color:#212529;">' + (s.name || 'N/A') + '</span></div></td>' +
                            '<td style="padding:12px;vertical-align:middle;color:#6c757d;font-size:13px;">' + (s.email || 'N/A') + '</td>' +
                            '<td style="padding:12px;vertical-align:middle;color:#212529;font-size:13px;font-weight:500;">' + (s.task_title || '-') + '</td>' +
                            '<td style="padding:12px;vertical-align:middle;">' + statusBadge + '</td>' +
                            '<td style="padding:12px;vertical-align:middle;font-size:13px;">' + submitOnCell + '</td>' +
                            '<td style="padding:12px;vertical-align:middle;text-align:center;">' + fileCell + '</td>' +
                            '<td style="padding:12px;vertical-align:middle;text-align:center;">' + noteCell + '</td>' +
                            '<td style="padding:12px;vertical-align:middle;text-align:center;">' + feedbackCell + '</td>' +
                            '</tr>';
                    });
                    tbody.innerHTML = rows;
                },
                error: function(xhr) {
                    console.error('Failed to load task submissions', xhr);
                    document.getElementById('submissions-table-body').innerHTML = '<tr><td colspan="9" class="text-center text-danger">Failed to load submissions.</td></tr>';
                }
            });
        }

        // View Submitted File
        window.viewSubmittedFile = function(studentId) {
            console.log('Viewing file for student ID:', studentId);
            alert('File Viewer - Feature Coming Soon!');
        }

        // View Student Submission Note
        window.viewStudentSubmissionNote = function(taskId, studentId) {
            // Hide Task Submissions modal first
            var submissionsEl = document.getElementById('taskSubmissionsModal');
            var submissionsModal = bootstrap.Modal.getInstance(submissionsEl);

            var modalEl = document.getElementById('studentSubmissionNoteModal');

            // Reset to loading
            document.getElementById('studentNameDisplay').textContent = 'Loading...';
            document.getElementById('noteTaskTitle').textContent = '-';
            document.getElementById('noteStatus').innerHTML = '<span class="badge bg-secondary">Loading</span>';
            document.getElementById('noteSubmittedDate').textContent = '-';
            document.getElementById('noteSubmitFile').innerHTML = '-';
            document.getElementById('studentNoteContent').innerHTML = '<p class="text-muted">Loading...</p>';
            document.getElementById('projectLinkDisplay').innerHTML = '-';

            var url = '{{ route("internship.task.student.note", [":taskId", ":studentId"]) }}';
            url = url.replace(':taskId', taskId).replace(':studentId', studentId);

            // Fetch data first, then handle modal transitions
            $.ajax({
                url: url,
                method: 'GET',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(data) {
                    document.getElementById('studentNameDisplay').textContent = data.student_name || 'N/A';
                    document.getElementById('noteTaskTitle').textContent = data.task_title || '-';

                    if (data.status == 1) {
                        document.getElementById('noteStatus').innerHTML = '<span class="badge" style="background:#28a745;color:white;padding:6px 12px;border-radius:5px;font-size:12px;font-weight:600;"><i class="bx bx-check-circle"></i> Submitted</span>';
                    } else {
                        document.getElementById('noteStatus').innerHTML = '<span class="badge" style="background:#ffc107;color:#000;padding:6px 12px;border-radius:5px;font-size:12px;font-weight:600;"><i class="bx bx-time"></i> Pending</span>';
                    }

                    document.getElementById('noteSubmittedDate').textContent = data.submit_on || '-';

                    if (data.student_submit_file) {
                        document.getElementById('noteSubmitFile').innerHTML = '<a href="{{ asset("uploads/internship_tasks_submit") }}/' + data.student_submit_file + '" target="_blank" rel="noopener" class="btn btn-sm" style="background:#17a2b8;color:white;border:none;padding:6px 15px;border-radius:5px;font-size:12px;font-weight:600;"><i class="bx bx-download"></i> View File</a>';
                    } else {
                        document.getElementById('noteSubmitFile').innerHTML = '<span style="color:#6c757d;">No file submitted</span>';
                    }

                    if (data.student_submit_description) {
                        document.getElementById('studentNoteContent').innerHTML = '<div style="color:#495057;font-size:14px;line-height:1.8;">' + data.student_submit_description + '</div>';
                    } else {
                        document.getElementById('studentNoteContent').innerHTML = '<p class="text-muted">No note provided.</p>';
                    }

                    if (data.student_submit_project_link) {
                        document.getElementById('projectLinkDisplay').innerHTML = '<a href="' + data.student_submit_project_link + '" target="_blank" rel="noopener" style="color:#17a2b8;text-decoration:none;font-size:14px;font-weight:600;"><i class="bx bx-link-external"></i> ' + data.student_submit_project_link + '</a>';
                    } else {
                        document.getElementById('projectLinkDisplay').innerHTML = '<span style="color:#6c757d;">No project link provided</span>';
                    }

                    // Now show the note modal - handle transition properly
                    var showNoteModal = function() {
                        reopenSubmissionsAfterChild = true;
                        var modal = new bootstrap.Modal(modalEl);
                        modal.show();
                    };

                    if (submissionsModal) {
                        // Wait for submissions modal to fully hide, then show note modal
                        submissionsEl.addEventListener('hidden.bs.modal', function onHidden() {
                            submissionsEl.removeEventListener('hidden.bs.modal', onHidden);
                            showNoteModal();
                        }, { once: true });
                        submissionsModal.hide();
                    } else {
                        showNoteModal();
                    }
                },
                error: function(xhr) {
                    console.error('Failed to load student note', xhr);
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load submission details.' });
                }
            });
        }

        // Event delegation for Note buttons in submissions table
        document.addEventListener('click', function(e) {
            if (e.target && e.target.closest('.btn-view-note')) {
                var btn = e.target.closest('.btn-view-note');
                var taskId = btn.getAttribute('data-task-id');
                var studentId = btn.getAttribute('data-student-id');
                if (taskId && studentId) {
                    viewStudentSubmissionNote(taskId, studentId);
                }
            }
            // Event delegation for Feedback buttons
            if (e.target && e.target.closest('.btn-view-feedback')) {
                var btn = e.target.closest('.btn-view-feedback');
                var taskId = btn.getAttribute('data-task-id');
                var studentId = btn.getAttribute('data-student-id');
                var studentName = btn.getAttribute('data-student-name');
                if (taskId && studentId) {
                    openFeedbackModal(taskId, studentId, studentName);
                }
            }
        });

        // Initialize CKEditor for instructions modal and save via AJAX + SweetAlert
        (function() {
            var modalEl = document.getElementById('updateInstructionsModal');
            if (!modalEl) return;

            modalEl.addEventListener('shown.bs.modal', function () {
                if (!instructionsEditor && typeof ClassicEditor !== 'undefined') {
                    ClassicEditor.create(document.querySelector('#instructionsContent'))
                        .then(editor => { instructionsEditor = editor; })
                        .catch(error => { console.error(error); });
                }
            });

            var form = document.getElementById('updateInstructionsForm');
            if (!form) return;

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                var content = '';
                if (instructionsEditor && typeof instructionsEditor.getData === 'function') {
                    content = (instructionsEditor.getData() || '').trim();
                } else {
                    var ta = document.getElementById('instructionsContent');
                    content = ta ? (ta.value || '').trim() : '';
                }

                if (!content || content === '<p></p>' || content === '<p><br></p>') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Empty content',
                        text: 'Please enter instructions content before saving.'
                    });
                    return;
                }

                var tokenInput = form.querySelector('input[name="_token"]');
                var csrf = tokenInput ? tokenInput.value : ($('meta[name="csrf-token"]').attr('content') || '');

                Swal.fire({
                    title: 'Saving...',
                    allowOutsideClick: false,
                    didOpen: function () { Swal.showLoading(); }
                });

                $.ajax({
                    url: form.getAttribute('action'),
                    method: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: {
                        _token: csrf,
                        general_instructions: content,
                        instructions: content
                    },
                    success: function (response) {
                        if (response && response.success) {
                            var displayServer = document.getElementById('instructionsDisplayServer');
                            if (displayServer) {
                                displayServer.innerHTML = content;
                            }
                            var displayContent = document.getElementById('instructionsDisplayContent');
                            if (displayContent) {
                                displayContent.style.display = 'none';
                            }

                            var modalInstance = bootstrap.Modal.getInstance(modalEl);
                            if (modalInstance) {
                                modalInstance.hide();
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message || 'Instructions saved successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: (response && response.message) ? response.message : 'Failed to save instructions.'
                            });
                        }
                    },
                    error: function (xhr) {
                        var msg = 'Failed to save instructions.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: msg
                        });
                    }
                });
            });
        })();

        // Open Feedback Modal
        var currentFeedbackTaskId = null;
        var currentFeedbackStudentId = null;

        window.openFeedbackModal = function(taskId, studentId, studentName) {
            currentFeedbackTaskId = taskId;
            currentFeedbackStudentId = studentId;

            // Reset modal
            document.getElementById('feedbackStudentName').textContent = studentName || 'Loading...';
            document.getElementById('feedbackTaskTitle').textContent = '-';
            document.getElementById('feedbackStatus').innerHTML = '<span class="badge bg-secondary">Loading</span>';
            document.getElementById('feedbackText').value = '';
            document.getElementById('feedbackViewSection').style.display = 'none';
            document.getElementById('feedbackFormSection').style.display = 'block';
            document.getElementById('feedbackSubmitBtn').style.display = 'inline-block';

            var feedbackModalEl = document.getElementById('taskFeedbackModal');

            // Fetch existing feedback
            var url = '{{ route("internship.task.feedback.get", [":taskId", ":studentId"]) }}';
            url = url.replace(':taskId', taskId).replace(':studentId', studentId);

            $.ajax({
                url: url,
                method: 'GET',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(data) {
                    document.getElementById('feedbackTaskTitle').textContent = data.task_title || '-';
                    document.getElementById('feedbackStudentName').textContent = data.student_name || studentName || 'N/A';

                    if (data.status == 1) {
                        document.getElementById('feedbackStatus').innerHTML = '<span class="badge" style="background:#28a745;color:white;padding:6px 12px;border-radius:5px;font-size:12px;"><i class="bx bx-check-circle"></i> Completed</span>';
                    } else {
                        document.getElementById('feedbackStatus').innerHTML = '<span class="badge" style="background:#ffc107;color:#000;padding:6px 12px;border-radius:5px;font-size:12px;"><i class="bx bx-time"></i> Pending</span>';
                    }

                    if (data.task_feedback) {
                        document.getElementById('feedbackViewSection').style.display = 'block';
                        document.getElementById('feedbackFormSection').style.display = 'none';
                        document.getElementById('feedbackSubmitBtn').style.display = 'none';
                        document.getElementById('feedbackViewContent').textContent = data.task_feedback;
                    } else {
                        document.getElementById('feedbackViewSection').style.display = 'none';
                        document.getElementById('feedbackFormSection').style.display = 'block';
                        document.getElementById('feedbackSubmitBtn').style.display = 'inline-block';
                    }

                    // Now show the feedback modal - handle transition properly
                    var showFeedbackModal = function() {
                        reopenSubmissionsAfterChild = true;
                        var modal = new bootstrap.Modal(feedbackModalEl);
                        modal.show();
                    };

                    // Hide Task Submissions modal first if open
                    var submissionsEl = document.getElementById('taskSubmissionsModal');
                    var submissionsModal = bootstrap.Modal.getInstance(submissionsEl);
                    if (submissionsModal && submissionsEl.classList.contains('show')) {
                        submissionsEl.addEventListener('hidden.bs.modal', function onHidden() {
                            submissionsEl.removeEventListener('hidden.bs.modal', onHidden);
                            showFeedbackModal();
                        }, { once: true });
                        submissionsModal.hide();
                    } else {
                        showFeedbackModal();
                    }
                },
                error: function(xhr) {
                    console.error('Failed to load feedback', xhr);
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load feedback data.' });
                }
            });
        }

        // Submit Feedback
        window.submitFeedback = function() {
            var feedbackText = document.getElementById('feedbackText').value.trim();

            if (!feedbackText) {
                Swal.fire({ icon: 'warning', title: 'Required', text: 'Please provide feedback before submitting!' });
                return;
            }

            if (!currentFeedbackTaskId || !currentFeedbackStudentId) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Missing task or student information.' });
                return;
            }

            $.ajax({
                url: '{{ route("internship.task.feedback.save") }}',
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    task_id: currentFeedbackTaskId,
                    student_id: currentFeedbackStudentId,
                    feedback: feedbackText
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({ icon: 'success', title: 'Success', text: 'Feedback saved successfully!' });

                        // Switch to view mode
                        document.getElementById('feedbackViewSection').style.display = 'block';
                        document.getElementById('feedbackFormSection').style.display = 'none';
                        document.getElementById('feedbackSubmitBtn').style.display = 'none';
                        document.getElementById('feedbackViewContent').textContent = response.task_feedback;
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: response.message || 'Failed to save feedback.' });
                    }
                },
                error: function(xhr) {
                    var msg = 'Failed to save feedback.';
                    if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    Swal.fire({ icon: 'error', title: 'Error', text: msg });
                }
            });
        }

        // ==================== INTERNSHIP COMPLETION / GRADING ====================
        const completionInternshipId = {{ $internship->id }};
        const completionOpportunityId = completionInternshipId;
        const completionCsrfToken = '{{ csrf_token() }}';
        const internshipType = {{ $internship->internship_type }};
        const opportunityType = internshipType;
        const companyCompleteSts = {{ (int) $internship->company_complete_sts }};
        const completionAlerts = @json($completionAlerts);
        let marksLoaded = false;

        // ==================== AUTO-SAVE MARKS ON INPUT ====================
        let marksSaveTimer = {};

        $(document).on('input', '.industry-mark', function() {
            const input = $(this);
            const max = parseFloat(input.data('max'));
            let value = parseFloat(input.val()) || 0;

            // Clamp value
            if (value > max) { input.val(max); value = max; }
            if (value < 0) { input.val(0); value = 0; }

            // Recalculate row
            calculateMarks(input.closest('tr')[0]);

            // Debounced auto-save (300ms)
            const studentId = input.data('student-id');
            const criteriaId = input.data('criteria-id');
            const criteriaName = input.data('criteria-name');
            const maxMarks = input.data('max');
            const key = studentId + '_' + criteriaId;

            clearTimeout(marksSaveTimer[key]);
            marksSaveTimer[key] = setTimeout(function() {
                $.ajax({
                    url: '{{ route("website.internship.save-marks") }}',
                    method: 'POST',
                    data: {
                        _token: completionCsrfToken,
                        internship_id: completionOpportunityId,
                        student_id: studentId,
                        criteria_id: criteriaId,
                        criteria_name: criteriaName,
                        max_marks: maxMarks,
                        marks: value
                    },
                    success: function(res) {
                        if (res.success) {
                            input.css('border-color', '#28a745');
                            setTimeout(() => input.css('border-color', ''), 1500);
                        }
                    },
                    error: function(xhr) {
                        input.css('border-color', '#dc3545');
                        console.error('Auto-save failed:', xhr.responseJSON);
                    }
                });
            }, 300);
        });

        // ==================== AUTO-SAVE FEEDBACK ====================
        let completionFeedbackTimer = {};

        $(document).on('input', '.feedback-textarea', function() {
            const textarea = $(this);
            const studentId = textarea.data('student-id');
            const feedback = textarea.val();

            clearTimeout(completionFeedbackTimer[studentId]);
            completionFeedbackTimer[studentId] = setTimeout(function() {
                $.ajax({
                    url: '{{ route("website.internship.save-feedback") }}',
                    method: 'POST',
                    data: {
                        _token: completionCsrfToken,
                        internship_id: completionOpportunityId,
                        student_id: studentId,
                        feedback: feedback
                    },
                    success: function(res) {
                        if (res.success) {
                            textarea.css('border-color', '#28a745');
                            setTimeout(() => textarea.css('border-color', ''), 1500);
                        }
                    },
                    error: function() {
                        textarea.css('border-color', '#dc3545');
                    }
                });
            }, 500);
        });

        // ==================== LOAD SAVED MARKS ON PAGE ====================
        function loadSavedMarks() {
            if (marksLoaded) {
                document.querySelectorAll('#completionTable tbody tr[data-student-id]').forEach(row => calculateMarks(row));
                return;
            }
            marksLoaded = true;

            $.ajax({
                url: '{{ route("website.internship.fetch-marks", $internship->id) }}',
                method: 'GET',
                success: function(res) {
                    if (res.success && res.data) {
                        $.each(res.data, function(studentId, data) {
                            // Fill marks
                            if (data.criteria) {
                                $.each(data.criteria, function(criteriaId, criteriaData) {
                                    const marks = typeof criteriaData === 'object' ? criteriaData.marks : criteriaData;
                                    const input = $(`.industry-mark[data-student-id="${studentId}"][data-criteria-id="${criteriaId}"]`);
                                    if (input.length && !input.val()) {
                                        input.val(marks);
                                    }
                                });
                            }
                            // Fill feedback
                            if (data.feedback) {
                                const textarea = $(`.feedback-textarea[data-student-id="${studentId}"]`);
                                if (textarea.length && !textarea.val()) {
                                    textarea.val(data.feedback);
                                }
                            }
                        });
                    }
                    // Recalculate all rows
                    document.querySelectorAll('#completionTable tbody tr[data-student-id]').forEach(row => calculateMarks(row));
                    // Re-enforce disabled state after AJAX populates values
                    if (companyCompleteSts == 1) {
                        $('input.marks-input, textarea.feedback-textarea').prop('disabled', true);
                    }
                }
            });
        }

        // ==================== CALCULATION LOGIC ====
        function calculateMarks(row) {
            // Skip calculations for opportunities with type != 1 (feedback-only)
            if (parseInt(opportunityType) !== 1) return;

            const inputs = row.querySelectorAll('.industry-mark');
            let total = 0;
            let maxTotal = 0;

            inputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                const max = parseFloat(input.getAttribute('data-max')) || 0;
                if (value > max) {
                    input.value = max;
                    total += max;
                } else {
                    total += value;
                }
                maxTotal += max;
            });

            const percentage = maxTotal > 0 ? ((total / maxTotal) * 100).toFixed(2) : 0;

            let grade = '-';
            let gradeClass = 'grade-F';
            if (percentage >= 90) { grade = 'A+'; gradeClass = 'grade-A'; }
            else if (percentage >= 80) { grade = 'A'; gradeClass = 'grade-A'; }
            else if (percentage >= 70) { grade = 'B'; gradeClass = 'grade-B'; }
            else if (percentage >= 60) { grade = 'C'; gradeClass = 'grade-C'; }
            else if (percentage >= 50) { grade = 'D'; gradeClass = 'grade-D'; }
            else if (percentage > 0) { grade = 'F'; gradeClass = 'grade-F'; }

            const totalEl = row.querySelector('.total-display');
            const percentEl = row.querySelector('.percentage-display');
            const gradeBadge = row.querySelector('.grade-badge');
            if (totalEl) totalEl.textContent = `${total} / ${maxTotal}`;
            if (percentEl) percentEl.textContent = `${percentage}%`;
            if (gradeBadge) {
                gradeBadge.textContent = grade;
                gradeBadge.className = `grade-badge ${gradeClass}`;
            }
        }

        // Recalculate on page load + init DataTables
        $(document).ready(function() {
            document.querySelectorAll('#completionTable tbody tr[data-student-id]').forEach(row => calculateMarks(row));
            // jQuery safety: ensure inputs/textareas are disabled when company marks already submitted
            if (companyCompleteSts == 1) {
                $('input.marks-input, textarea.feedback-textarea').prop('disabled', true);
            }

            var studentsTable = null;
            var tasksTable = null;
            var completionTable = null;

            if ($.fn.DataTable && $('#CompanyStudentsTable').length) {
                studentsTable = $('#CompanyStudentsTable').DataTable({
                    order: [[0, 'asc']],
                    pageLength: 10,
                    autoWidth: false,
                    columnDefs: [
                        { orderable: false, targets: [5] }
                    ],
                    language: {
                        emptyTable: 'No applications found for this Internship.',
                        search: 'Search students:'
                    }
                });
            }

            if ($.fn.DataTable && $('#CompanyTasksTable').length) {
                tasksTable = $('#CompanyTasksTable').DataTable({
                    order: [[0, 'asc']],
                    pageLength: 10,
                    autoWidth: false,
                    columnDefs: [
                        { orderable: false, targets: [4, 6] }
                    ],
                    language: {
                        emptyTable: 'No tasks found for this Internship.',
                        search: 'Search tasks:'
                    }
                });
            }

            if ($.fn.DataTable && $('#completionTable').length) {
                var nonOrderable = [];
                $('#completionTable thead th').each(function(i) {
                    var txt = ($(this).text() || '').toUpperCase();
                    if (txt.indexOf('MARKS') !== -1 || txt.indexOf('FEEDBACK') !== -1 || txt.indexOf('GRADE') !== -1 || txt.indexOf('TOTAL') !== -1 || txt.indexOf('%') !== -1 || txt.indexOf('CERTIFICATE') !== -1) {
                        nonOrderable.push(i);
                    }
                });
                completionTable = $('#completionTable').DataTable({
                    order: [[0, 'asc']],
                    pageLength: 10,
                    autoWidth: false,
                    searching: true,
                    columnDefs: [
                        { orderable: false, targets: nonOrderable }
                    ],
                    language: {
                        emptyTable: 'No students enrolled in this Internship.',
                        search: 'Search students:'
                    }
                });
            }

            $('button[data-bs-target="#student"], #student-tab').on('shown.bs.tab', function () {
                if (studentsTable) studentsTable.columns.adjust().draw(false);
            });
            $('button[data-bs-target="#tasks"], #tasks-tab').on('shown.bs.tab', function () {
                if (tasksTable) tasksTable.columns.adjust().draw(false);
            });
            $('button[data-bs-target="#complete"], #complete-tab').on('shown.bs.tab', function () {
                if (completionTable) completionTable.columns.adjust().draw(false);
            });
        });

        // Load marks when Complete Program tab is clicked
        $('button[data-bs-target="#complete"]').on('click', function(e) {
            @if(!$internship->complete_status && !$internship->company_complete_sts)
            e.preventDefault();
            e.stopImmediatePropagation();

            Swal.fire({
                title: completionAlerts.tabTitle,
                text: completionAlerts.tabText,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#242a62',
                cancelButtonColor: '#6c757d',
                confirmButtonText: completionAlerts.tabConfirm,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Activate the tab
                    var tabEl = document.querySelector('#complete-tab');
                    var tab = new bootstrap.Tab(tabEl);
                    tab.show();
                    loadSavedMarks();
                }
            });
            @else
            loadSavedMarks();
            @endif
        });

        // ==================== SHOW CONFIRM MODAL ====================
        window.showConfirmModal = function() {
            const rows = document.querySelectorAll('#completionTable tbody tr[data-student-id]');
            let allFilled = true;
            let errorMessages = [];

            rows.forEach(row => {
                const studentName = row.querySelector('td:nth-child(2)').textContent.trim();
                const feedback = row.querySelector('.feedback-textarea');

                if (parseInt(opportunityType) === 1) {
                    const inputs = row.querySelectorAll('.industry-mark');
                    inputs.forEach(input => {
                        if (!input.value || parseFloat(input.value) === 0) {
                            allFilled = false;
                        }
                    });
                }

                if (!feedback || !feedback.value.trim()) {
                    allFilled = false;
                    errorMessages.push(studentName + ': Missing feedback');
                }
            });

            if (!allFilled) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Data',
                    text: completionAlerts.incompleteText
                });
                return;
            }

            Swal.fire({
                title: completionAlerts.submitTitle,
                html: completionAlerts.submitHtml,
                icon: parseInt(opportunityType) === 2 ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: completionAlerts.submitConfirm,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    confirmCompletion();
                }
            });
        }

        // ==================== FINAL SUBMIT ====================
        window.confirmCompletion = function() {
            Swal.fire({
                title: completionAlerts.loadingTitle,
                text: completionAlerts.loadingText,
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: '{{ route("website.internship.submit-completion") }}',
                method: 'POST',
                data: {
                    _token: completionCsrfToken,
                    internship_id: completionOpportunityId
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire({ icon: 'success', title: 'Submitted', text: res.message, timer: 2000, showConfirmButton: false }).then(() => location.reload());
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'An error occurred while completing the Internship.'
                    });
                }
            });
        }

        // ==================== EXPORT TO EXCEL ====================
        window.exportToExcel = function() {
            Swal.fire({
                title: 'Export Excel',
                text: 'Enter file name',
                input: 'text',
                inputPlaceholder: 'internship_report',
                inputAttributes: { autocapitalize: 'off' },
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-download"></i> Download',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#242a62',
                cancelButtonColor: '#6c757d',
                inputValidator: (value) => {
                    if (!value || !value.trim()) return 'Please enter a file name';
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const filename = result.value.trim().replace(/[^a-zA-Z0-9_\-]/g, '_') || 'internship_report';
                    const table = document.querySelector('#completionTable');
                    if (!table) { console.error('Complete Internship table not found'); return; }
                    const clone = table.cloneNode(true);

                    clone.querySelectorAll('.industry-mark').forEach(input => {
                        const span = document.createElement('span');
                        span.textContent = input.value || '0';
                        input.parentNode.replaceChild(span, input);
                    });
                    clone.querySelectorAll('.feedback-textarea').forEach(textarea => {
                        const span = document.createElement('span');
                        span.textContent = textarea.value || '';
                        textarea.parentNode.replaceChild(span, textarea);
                    });

                    const wb = XLSX.utils.book_new();
                    const ws = XLSX.utils.table_to_sheet(clone);
                    XLSX.utils.book_append_sheet(wb, ws, 'Internship Report');
                    XLSX.writeFile(wb, filename + '.xlsx');
                }
            });
        }

        // Export Marks Report (all college+degree tables)
        window.exportMarksReport = function() {
            Swal.fire({
                title: 'Export Marks Report',
                text: 'Enter file name',
                input: 'text',
                inputPlaceholder: 'marks_report',
                inputAttributes: { autocapitalize: 'off' },
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-download"></i> Download',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#242a62',
                cancelButtonColor: '#6c757d',
                inputValidator: (value) => {
                    if (!value || !value.trim()) return 'Please enter a file name';
                }
            }).then((result) => {
                if (!result.isConfirmed || !result.value) return;
                const filename = result.value.trim().replace(/[^a-zA-Z0-9_\-]/g, '_') || 'marks_report';
                const wb = XLSX.utils.book_new();

                const tables = document.querySelectorAll('[id^="marks-table-"]');
                if (!tables.length) { alert('No marks data found.'); return; }

                tables.forEach(function(tbl, idx) {
                    // Determine sheet name from group heading
                    const wrapper = tbl.closest('div[style*="margin-bottom"]');
                    let sheetName = 'Group_' + (idx + 1);
                    if (wrapper) {
                        const heading = wrapper.querySelector('span[style*="font-weight:700"]');
                        if (heading) sheetName = heading.textContent.trim().replace(/[^a-zA-Z0-9 _]/g, '').substring(0, 25);
                    }
                    const ws = XLSX.utils.table_to_sheet(tbl.cloneNode(true));
                    // Fix percentage cells
                    Object.keys(ws).forEach(function(cell) {
                        if (cell[0] === '!') return;
                        var c = ws[cell];
                        if (c.t === 'n' && c.w && c.w.indexOf('%') !== -1) {
                            c.t = 's'; c.v = c.w; delete c.z;
                        }
                    });
                    XLSX.utils.book_append_sheet(wb, ws, sheetName || ('Sheet' + (idx + 1)));
                });

                XLSX.writeFile(wb, filename + '.xlsx');
            });
        }
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
@endpush    
