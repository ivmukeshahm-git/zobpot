@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "CollegeMarks";
</script>

<style>
    .college-marks-header {
        background: linear-gradient(135deg, #242a62 0%, #3d4575 55%, #f26e2c 160%);
        border-radius: 16px;
        padding: 24px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 28px rgba(36, 42, 98, 0.22);
    }
    .college-marks-header::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(242, 110, 44, 0.15);
        border-radius: 50%;
    }
    .college-marks-header h4 {
        color: #fff !important;
        margin: 0;
        font-weight: 800;
        position: relative;
        z-index: 1;
    }
    .college-marks-header p {
        color: rgba(255,255,255,0.9) !important;
        margin: 6px 0 0 0;
        font-size: 14px;
        position: relative;
        z-index: 1;
    }

    .filter-card {
        background: white;
        border-radius: 14px;
        padding: 22px 24px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        margin-bottom: 24px;
        border: 1px solid #eef0f4;
    }
    .filter-card label {
        font-weight: 700;
        color: #242a62;
        margin-bottom: 6px;
        font-size: 13px;
        display: block;
    }
    .filter-card select,
    .filter-card .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.3s ease;
        height: auto;
    }
    .filter-card select:focus,
    .filter-card .form-control:focus {
        border-color: #242a62;
        box-shadow: 0 0 0 3px rgba(36, 42, 98, 0.1);
    }
    .btn-load-data {
        background: linear-gradient(135deg, #242a62 0%, #3d4575 100%);
        color: white;
        padding: 11px 28px;
        border-radius: 10px;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
        width: 100%;
    }
    .btn-load-data:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(36, 42, 98, 0.3);
        color: white;
    }
    .btn-load-data:disabled {
        opacity: 0.55;
        cursor: not-allowed;
    }

    .college-marks-empty {
        background: #fff;
        border-radius: 14px;
        padding: 48px 24px;
        text-align: center;
        color: #6c757d;
        box-shadow: 0 2px 15px rgba(0,0,0,0.06);
        border: 1px dashed #d7dbe3;
    }
    .college-marks-empty i {
        font-size: 48px;
        color: #c5cad6;
    }

    /* Opportunity / Internship cards */
    .internship-card,
    .opportunity-card {
        background: #fff;
        border-radius: 16px;
        padding: 0;
        margin-bottom: 28px;
        box-shadow: 0 4px 20px rgba(36, 42, 98, 0.08);
        border: 1px solid #eef0f4;
        overflow: hidden;
    }
    .internship-card-header,
    .opportunity-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        padding: 18px 22px;
        background: linear-gradient(135deg, #f7f8fc 0%, #ffffff 100%);
        border-bottom: 1px solid #eef0f4;
    }
    .internship-card-header h5,
    .opportunity-card-header h5 {
        color: #242a62 !important;
        font-weight: 800;
        margin: 0;
        font-size: 18px;
        line-height: 1.35;
    }
    .internship-card-header h5 i,
    .opportunity-card-header h5 i {
        color: #f26e2c;
        margin-right: 6px;
    }
    .internship-card-body,
    .opportunity-card-body {
        padding: 18px 22px 8px;
    }
    .internship-card-footer,
    .opportunity-card-footer {
        padding: 16px 22px 22px;
        background: #fafbfd;
        border-top: 1px solid #eef0f4;
    }

    .status-badge-completed {
        background: #28a745;
        color: white;
        padding: 7px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .status-badge-pending {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffe08a;
        padding: 7px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Marks table */
    .complete-internship-table,
    .complete-opportunity-table {
        width: 100%;
        table-layout: fixed;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        margin-bottom: 0;
    }
    .complete-internship-table thead,
    .complete-opportunity-table thead {
        background: linear-gradient(135deg, #242a62 0%, #3d4575 100%);
    }
    .complete-internship-table thead th,
    .complete-opportunity-table thead th {
        color: #ffffff !important;
        font-weight: 700;
        padding: 14px 12px;
        text-align: center;
        vertical-align: middle;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        border-right: 1px solid rgba(255,255,255,0.12);
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
        background: #f8f9fc;
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

    .complete-internship-table .col-sr { width: 70px; }
    .complete-internship-table .col-student { width: 170px; text-align: left !important; }
    .complete-internship-table .col-college { width: 140px; }
    .complete-internship-table .col-marks { width: 260px; }
    .complete-internship-table .col-feedback { width: 220px; }
    .complete-internship-table .col-total { width: 100px; }
    .complete-internship-table .col-percent { width: 100px; }
    .complete-internship-table .col-grade { width: 90px; }

    .complete-internship-table td.col-student > div,
    .complete-internship-table td.col-sr {
        font-weight: 700;
        color: #242a62;
    }
    .complete-internship-table td.col-student > div {
        text-align: left;
        line-height: 1.35;
    }

    .college-marks-table-wrap {
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
        padding: 8px 10px;
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
        color: #5c6578;
        font-weight: 700;
        min-width: 110px;
        text-align: left;
    }
    .marks-input {
        width: 72px;
        padding: 8px 10px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        text-align: center;
        font-weight: 700;
        font-size: 14px;
        color: #242a62;
        transition: all 0.3s ease;
        background: #fff;
    }
    .marks-input:focus {
        outline: none;
        border-color: #242a62;
        box-shadow: 0 0 0 3px rgba(36, 42, 98, 0.1);
    }
    .marks-input:disabled {
        background: #f1f3f5;
        cursor: not-allowed;
    }
    .max-marks {
        font-size: 12px;
        color: #6c757d;
        font-weight: 700;
    }
    .feedback-textarea {
        width: 100%;
        min-height: 88px;
        padding: 10px 12px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 13px;
        resize: vertical;
        transition: all 0.3s ease;
        background: #fff;
    }
    .feedback-textarea:focus {
        outline: none;
        border-color: #242a62;
        box-shadow: 0 0 0 3px rgba(36, 42, 98, 0.1);
    }
    .feedback-textarea:disabled {
        background: #f1f3f5;
        cursor: not-allowed;
    }
    .total-display {
        font-size: 16px;
        font-weight: 800;
        color: #242a62;
        text-align: center;
        white-space: nowrap;
    }
    .percentage-display {
        font-size: 15px;
        font-weight: 800;
        color: #17a2b8;
        text-align: center;
        white-space: nowrap;
    }
    .grade-badge {
        display: inline-block;
        min-width: 42px;
        padding: 8px 14px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 13px;
        text-align: center;
    }
    .grade-A { background: #28a745; color: white; }
    .grade-B { background: #17a2b8; color: white; }
    .grade-C { background: #ffc107; color: #333; }
    .grade-D { background: #fd7e14; color: white; }
    .grade-F { background: #dc3545; color: white; }

    .btn-submit-college-marks {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 15px;
        border: none;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        transition: all 0.3s ease;
    }
    .btn-submit-college-marks:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        color: white;
    }
    .export-btn {
        background: linear-gradient(135deg, #242a62 0%, #3d4575 100%);
        color: white !important;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
        font-size: 13px;
    }
    .export-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(36, 42, 98, 0.28);
        color: white !important;
    }

    .college-marks-note {
        margin: 0;
        border-radius: 10px;
        border: 1px solid #cfe2ff;
        background: #f0f6ff;
        color: #1e3a5f;
        padding: 12px 14px;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .complete-internship-table,
        .complete-opportunity-table { font-size: 12px; }
        .marks-input { width: 60px; padding: 6px 8px; font-size: 12px; }
        .marks-input-group label { min-width: 80px; }
        .complete-internship-table thead th,
        .complete-opportunity-table thead th,
        .complete-internship-table tbody td,
        .complete-opportunity-table tbody td { padding: 10px 6px; }
        .internship-card-header,
        .opportunity-card-header,
        .internship-card-body,
        .internship-card-footer { padding-left: 16px; padding-right: 16px; }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    @if(auth()->guard('college')->check() || auth()->guard('college_staff')->check())
    @include('admin.layout.partials.college-page-banner', [
        'emoji' => '📊',
        'title' => 'Update College Marks',
        'subtitle' => 'Evaluate student performance and assign college-side marks.',
        'illustration' => 'marks',
        'crumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.college.dashboard')],
            ['label' => 'College Marks'],
        ],
    ])
    @else
    <!-- Page Header -->
    <div class="college-marks-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 style="color: #fff; margin: 0;">
                    <i class="bx bx-edit"></i> Update College Marks
                </h4>
                <p style="color: rgba(255,255,255,0.7); margin: 5px 0 0 0; font-size: 14px;">
                    Evaluate student performance and assign college-side marks
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Filter Section -->
    <div class="filter-card">
        <div class="row align-items-end">
            @if($isSuperAdmin)
            <div class="col-md-3">
                <label for="filter_university">University</label>
                <select id="filter_university" class="form-control">
                    <option value="">-- Select University --</option>
                    @foreach($universities as $uni)
                        <option value="{{ $uni->id }}">{{ $uni->university_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="filter_college">College</label>
                <select id="filter_college" class="form-control" disabled>
                    <option value="">-- Select College --</option>
                </select>
            </div>
            @else
            <input type="hidden" id="filter_college" value="{{ $collegeId }}">
            @endif

            <div class="col-md-3">
                <label for="filter_course">Course</label>
                <select id="filter_course" class="form-control" {{ $isSuperAdmin ? 'disabled' : '' }}>
                    <option value="">-- Select Course --</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-load-data" id="btnLoadData" disabled>
                    <i class="bx bx-search"></i> Load Students
                </button>
            </div>
        </div>
    </div>

    <!-- Data Container -->
    <div id="dataContainer">
        <div class="college-marks-empty">
            <i class="bx bx-filter-alt"></i>
            <p class="mt-2 mb-0">Select filters above and click <strong>Load Students</strong> to view data</p>
        </div>
    </div>
</div>

@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    const csrfToken = '{{ csrf_token() }}';
    const isSuperAdmin = {{ $isSuperAdmin ? 'true' : 'false' }};
    const presetCollegeId = '{{ $collegeId ?? '' }}';

    // HTML-escape helper to prevent XSS in rendered content
    function escHtml(str) {
        if (!str) return '';
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // ==================== DEPENDENT DROPDOWNS ====================

    @if($isSuperAdmin)
    // University → College
    $('#filter_university').on('change', function() {
        const uniId = $(this).val();
        $('#filter_college').html('<option value="">-- Loading... --</option>').prop('disabled', true);
        $('#filter_course').html('<option value="">-- Select Course --</option>').prop('disabled', true);
        $('#btnLoadData').prop('disabled', true);

        if (!uniId) return;

        $.ajax({
            url: '{{ route("admin.internship.colleges-by-university") }}',
            data: { university_id: uniId },
            success: function(res) {
                let opts = '<option value="">-- Select College --</option>';
                res.forEach(c => { opts += `<option value="${c.id}">${c.college_name}</option>`; });
                $('#filter_college').html(opts).prop('disabled', false);
            },
            error: function() {
                $('#filter_college').html('<option value="">-- Error --</option>');
            }
        });
    });

    // College → Course
    $('#filter_college').on('change', function() {
        const collegeId = $(this).val();
        $('#filter_course').html('<option value="">-- Loading... --</option>').prop('disabled', true);
        $('#btnLoadData').prop('disabled', true);

        if (!collegeId) return;

        $.ajax({
            url: '{{ route("admin.internship.courses-by-college") }}',
            data: { college_id: collegeId },
            success: function(res) {
                let opts = '<option value="">-- Select Course --</option>';
                res.forEach(c => { opts += `<option value="${c.degree_id}">${c.degree_name}</option>`; });
                $('#filter_course').html(opts).prop('disabled', false);
            },
            error: function() {
                $('#filter_course').html('<option value="">-- Error --</option>');
            }
        });
    });
    @else
    // College login: auto-load courses
    if (presetCollegeId) {
        $.ajax({
            url: '{{ route("admin.internship.courses-by-college") }}',
            data: { college_id: presetCollegeId },
            success: function(res) {
                let opts = '<option value="">-- Select Course --</option>';
                res.forEach(c => { opts += `<option value="${c.degree_id}">${c.degree_name}</option>`; });
                $('#filter_course').html(opts).prop('disabled', false);
            }
        });
    }
    @endif

    // Enable load button when course is selected
    $('#filter_course').on('change', function() {
        $('#btnLoadData').prop('disabled', !$(this).val());
    });

    // ==================== LOAD STUDENTS DATA ====================
    $('#btnLoadData').on('click', function() {
        const collegeId = $('#filter_college').val();
        const courseId = $('#filter_course').val();

        if (!collegeId || !courseId) {
            Swal.fire('Warning', 'Please select all filters', 'warning');
            return;
        }

        const btn = $(this);
        btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin"></i> Loading...');

        $.ajax({
            url: '{{ route("admin.internship.college-marks-data") }}',
            method: 'POST',
            data: {
                _token: csrfToken,
                college_id: collegeId,
                course_id: courseId
            },
            success: function(res) {
                btn.prop('disabled', false).html('<i class="bx bx-search"></i> Load Students');

                if (!res.success || !res.internships || res.internships.length === 0) {
                    $('#dataContainer').html(`
                        <div class="college-marks-empty">
                            <i class="bx bx-info-circle"></i>
                            <p class="mt-2 mb-0">${res.message || 'No opportunities found for the selected filters.'}</p>
                        </div>
                    `);
                    return;
                }

                renderInternships(res.internships, res.college_criteria, collegeId, courseId);
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<i class="bx bx-search"></i> Load Students');
                let msg = 'An error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                Swal.fire('Error', msg, 'error');
            }
        });
    });

    // ==================== RENDER INTERNSHIPS ====================
    function renderInternships(opportunities, criteria, collegeId, courseId) {
        let html = '';
        const baseColSpan = isSuperAdmin ? 8 : 7;

        opportunities.forEach(function(opportunity) {
            const isCompleted = opportunity.college_submitted === true;
            const statusBadge = isCompleted
                ? '<span class="status-badge-completed"><i class="bx bx-check"></i> Submitted</span>'
                : '<span class="status-badge-pending"><i class="bx bx-time"></i> Pending</span>';
            const studentCount = (opportunity.students && opportunity.students.length) ? opportunity.students.length : 0;

            html += `<div class="internship-card" data-opportunity-id="${opportunity.internship_id}" data-college-id="${collegeId}">`;
            html += `<div class="internship-card-header">`;
            html += `<div>
                        <h5><i class="bx bx-briefcase-alt-2"></i> ${escHtml(opportunity.internship_title)}</h5>
                        <div style="margin-top:6px;color:#6c757d;font-size:13px;font-weight:600;">
                            <i class="bx bx-user"></i> ${studentCount} Student${studentCount === 1 ? '' : 's'}
                        </div>
                     </div>`;
            html += `<div class="d-flex align-items-center gap-2 flex-wrap">
                        ${statusBadge}
                        <button type="button" class="btn export-btn btn-sm" onclick="exportCollegeMarks(${opportunity.internship_id})">
                            <i class="fa fa-file-excel-o"></i> Export
                        </button>
                     </div>`;
            html += `</div>`;

            html += `<div class="internship-card-body">`;
            if (isCompleted) {
                html += `<div class="alert alert-success mb-3"><i class="bx bx-check-circle"></i> <strong>Submitted!</strong> College marks are locked and cannot be edited.</div>`;
            }

            html += `<div class="college-marks-table-wrap table-responsive">`;
            html += `<table class="complete-internship-table" id="collegeTable_${opportunity.internship_id}" style="width:100%">`;
            html += `<thead><tr>`;
            html += `<th class="col-sr">SR.NO</th>`;
            html += `<th class="col-student">STUDENT</th>`;
            if (isSuperAdmin) html += `<th class="col-college">COLLEGE</th>`;
            html += `<th class="col-marks">COLLEGE MARKS</th>`;
            html += `<th class="col-feedback">FEEDBACK</th>`;
            html += `<th class="col-total">TOTAL</th>`;
            html += `<th class="col-percent">%</th>`;
            html += `<th class="col-grade">GRADE</th>`;
            html += `</tr></thead><tbody>`;

            if (!opportunity.students || opportunity.students.length === 0) {
                html += `<tr><td colspan="${baseColSpan}" class="text-center py-4"><i class="bx bx-info-circle"></i> No students found</td></tr>`;
            } else {
                opportunity.students.forEach(function(student, idx) {
                    const savedMarks = student.saved_marks || {};
                    const savedFeedback = student.feedback || '';
                    let maxTotal = 0;

                    html += `<tr data-student-id="${student.id}" data-opportunity-id="${opportunity.internship_id}">`;
                    html += `<td class="col-sr">${idx + 1}</td>`;
                    html += `<td class="col-student"><div>${escHtml(student.name).toUpperCase()}</div></td>`;
                    if (isSuperAdmin) html += `<td class="col-college">${escHtml(student.college_name)}</td>`;

                    html += `<td class="col-marks">`;
                    criteria.forEach(function(c) {
                        const savedVal = savedMarks[c.id] ? (typeof savedMarks[c.id] === 'object' ? savedMarks[c.id].marks : savedMarks[c.id]) : '';
                        maxTotal += parseInt(c.marks) || 0;
                        html += `<div class="marks-input-group">`;
                        html += `<label>${escHtml(c.title)}</label>`;
                        html += `<input type="number" class="marks-input college-mark"
                                    min="0" max="${c.marks}"
                                    data-max="${c.marks}"
                                    data-criteria-id="${c.id}"
                                    data-criteria-name="${escHtml(c.title)}"
                                    data-student-id="${student.id}"
                                    data-opportunity-id="${opportunity.internship_id}"
                                    placeholder="0"
                                    value="${savedVal}"
                                    ${isCompleted ? 'disabled' : ''}>`;
                        html += `<span class="max-marks">/ ${c.marks}</span>`;
                        html += `</div>`;
                    });
                    if (!criteria || criteria.length === 0) {
                        html += `<div class="text-muted" style="font-size:12px;font-weight:600;">No grade configured</div>`;
                    }
                    html += `</td>`;

                    html += `<td class="col-feedback">
                        <textarea class="feedback-textarea college-feedback"
                            data-student-id="${student.id}"
                            data-opportunity-id="${opportunity.internship_id}"
                            placeholder="Enter college feedback..."
                            ${isCompleted ? 'disabled' : ''}>${escHtml(savedFeedback)}</textarea>
                    </td>`;

                    html += `<td class="col-total total-display">0 / ${maxTotal}</td>`;
                    html += `<td class="col-percent percentage-display">0.00%</td>`;
                    html += `<td class="col-grade"><span class="grade-badge grade-F">-</span></td>`;
                    html += `</tr>`;
                });
            }

            html += `</tbody></table></div>`;
            html += `</div>`; // card body

            html += `<div class="internship-card-footer">`;
            html += `<div class="d-flex flex-wrap justify-content-between align-items-center gap-3">`;
            html += `<div class="college-marks-note flex-grow-1"><i class="bx bx-info-circle"></i> <strong>Note:</strong> Marks auto-save as you type. Once submitted, grades and feedback cannot be modified.</div>`;
            if (!isCompleted && studentCount > 0) {
                html += `<button type="button" class="btn btn-submit-college-marks" onclick="showSubmitConfirm(${opportunity.internship_id}, '${collegeId}', '${courseId}')">
                            <i class="fa fa-check-circle"></i> Submit College Marks
                         </button>`;
            }
            html += `</div></div>`;
            html += `</div>`; // card
        });

        $('#dataContainer').html(html);

        // Recalculate all rows
        document.querySelectorAll('[id^="collegeTable_"] tbody tr[data-student-id]').forEach(row => calculateMarks(row));
    }

    // ==================== AUTO-SAVE MARKS ON INPUT ====================
    let saveTimer = {};

    $(document).on('input', '.college-mark', function() {
        const input = $(this);
        const max = parseFloat(input.data('max'));
        let value = parseFloat(input.val()) || 0;

        if (value > max) { input.val(max); value = max; }
        if (value < 0) { input.val(0); value = 0; }

        calculateMarks(input.closest('tr')[0]);

        const studentId = input.data('student-id');
        const criteriaId = input.data('criteria-id');
        const criteriaName = input.data('criteria-name');
        const maxMarks = input.data('max');
        const internshipId = input.data('opportunity-id');
        const key = internshipId + '_' + studentId + '_' + criteriaId;

        clearTimeout(saveTimer[key]);
        saveTimer[key] = setTimeout(function() {
            $.ajax({
                url: '{{ route("admin.internship.save-college-marks") }}',
                method: 'POST',
                data: {
                    _token: csrfToken,
                    internship_id: internshipId,
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
    let feedbackTimer = {};

    $(document).on('input', '.college-feedback', function() {
        const textarea = $(this);
        const studentId = textarea.data('student-id');
        const internshipId = textarea.data('opportunity-id');
        const feedback = textarea.val();

        const key = internshipId + '_' + studentId;
        clearTimeout(feedbackTimer[key]);
        feedbackTimer[key] = setTimeout(function() {
            $.ajax({
                url: '{{ route("admin.internship.save-college-feedback") }}',
                method: 'POST',
                data: {
                    _token: csrfToken,
                    internship_id: internshipId,
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

    // ==================== CALCULATION LOGIC ====================
    window.calculateMarks = function(row) {
        const inputs = row.querySelectorAll('.college-mark');
        let total = 0;
        let maxTotal = 0;

        inputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            const max = parseFloat(input.getAttribute('data-max')) || 0;
            if (value > max) { input.value = max; total += max; } else { total += value; }
            maxTotal += max;
        });

        const percentage = maxTotal > 0 ? ((total / maxTotal) * 100).toFixed(2) : 0;

        let grade = '-', gradeClass = 'grade-F';
        if (percentage >= 90) { grade = 'A+'; gradeClass = 'grade-A'; }
        else if (percentage >= 80) { grade = 'A'; gradeClass = 'grade-A'; }
        else if (percentage >= 70) { grade = 'B'; gradeClass = 'grade-B'; }
        else if (percentage >= 60) { grade = 'C'; gradeClass = 'grade-C'; }
        else if (percentage >= 50) { grade = 'D'; gradeClass = 'grade-D'; }
        else if (percentage > 0) { grade = 'F'; gradeClass = 'grade-F'; }

        row.querySelector('.total-display').textContent = `${total} / ${maxTotal}`;
        row.querySelector('.percentage-display').textContent = `${percentage}%`;

        const gradeBadge = row.querySelector('.grade-badge');
        gradeBadge.textContent = grade;
        gradeBadge.className = `grade-badge ${gradeClass}`;
    };

    // ==================== SHOW SUBMIT CONFIRM ====================
    window.showSubmitConfirm = function(internshipId, collegeId, courseId) {
        const table = document.getElementById('collegeTable_' + internshipId);
        if (!table) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Marks table not found.' });
            return;
        }

        const markInputs = table.querySelectorAll('.college-mark');
        if (!markInputs || markInputs.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Grade Configured',
                html: 'College Marks grade criteria are not configured for this course.<br><small>Please configure grades first, then submit marks.</small>'
            });
            return;
        }

        const rows = table.querySelectorAll('tbody tr[data-student-id]');
        let allFilled = true;
        let missingList = [];

        rows.forEach(row => {
            const studentName = row.querySelector('td:nth-child(2)')?.textContent?.trim() || 'Unknown';
            const inputs = row.querySelectorAll('.college-mark');
            const feedback = row.querySelector('.college-feedback');
            let rowOk = true;

            inputs.forEach(input => {
                if (input.value === '' || input.value === null) { rowOk = false; }
            });

            if (!feedback || !feedback.value.trim()) { rowOk = false; }

            if (!rowOk) {
                allFilled = false;
                missingList.push(studentName);
            }
        });

        if (!allFilled) {
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Data',
                html: 'Please fill in all marks and feedback before submitting.<br><small class="text-danger">' + missingList.slice(0,5).join(', ') + '</small>'
            });
            return;
        }

        Swal.fire({
            title: 'Confirm College Marks Submission',
            html: '<p>This will finalize all college-side student evaluations.</p><p><strong>This action cannot be undone.</strong></p>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-check"></i> Yes, Submit College Marks',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                submitCollegeMarks(internshipId, collegeId, courseId);
            }
        });
    };

    // ==================== FINAL SUBMIT ====================
    window.submitCollegeMarks = function(internshipId, collegeId, courseId) {
        Swal.fire({
            title: 'Saving...',
            text: 'Please wait while we finalize college marks',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: '{{ route("admin.internship.submit-college-completion") }}',
            method: 'POST',
            data: {
                _token: csrfToken,
                internship_id: internshipId,
                college_id: collegeId,
                course_id: courseId
            },
            success: function(res) {
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: res.message,
                        timer: 2500,
                        showConfirmButton: false
                    }).then(() => {
                        $('#btnLoadData').click();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                }
            },
            error: function(xhr) {
                let msg = 'An error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            }
        });
    };

    // ==================== EXPORT TO EXCEL ====================
    window.exportCollegeMarks = function(internshipId) {
        Swal.fire({
            title: 'Export Excel',
            text: 'Enter file name',
            input: 'text',
            inputPlaceholder: 'college_marks_report',
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
                const filename = result.value.trim().replace(/[^a-zA-Z0-9_\-]/g, '_') || 'college_marks_report';
                const table = document.getElementById('collegeTable_' + internshipId);
                if (!table) { Swal.fire('Error', 'Table not found', 'error'); return; }

                const clone = table.cloneNode(true);
                // Replace inputs with their values
                clone.querySelectorAll('.college-mark').forEach(input => {
                    const td = document.createElement('span');
                    td.textContent = input.value || '0';
                    input.replaceWith(td);
                });
                clone.querySelectorAll('.college-feedback').forEach(textarea => {
                    const td = document.createElement('span');
                    td.textContent = textarea.value || '';
                    textarea.replaceWith(td);
                });

                const wb = XLSX.utils.table_to_book(clone, { sheet: 'College Marks' });
                XLSX.writeFile(wb, filename + '.xlsx');
            }
        });
    };
});
</script>
<script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
@endpush
