@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "CollegeMarks";
</script>

<style>
    .college-marks-header {
        background: #242a62;
        border-radius: 16px;
        padding: 24px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
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
    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        margin-bottom: 24px;
    }
    .filter-card label {
        font-weight: 600;
        color: #242a62;
        margin-bottom: 6px;
        font-size: 13px;
    }
    .filter-card select {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .filter-card select:focus {
        border-color: #242a62;
        box-shadow: 0 0 0 3px rgba(36, 42, 98, 0.1);
    }
    .btn-load-data {
        background: linear-gradient(135deg, #242a62 0%, #3d4575 100%);
        color: white;
        padding: 10px 28px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-load-data:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(36, 42, 98, 0.3);
        color: white;
    }

    /* Complete Internship Table Styles */
    .complete-internship-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }
    .complete-internship-table thead {
        background: linear-gradient(135deg, #242a62 0%, #3d4575 100%);
    }
    .complete-internship-table thead th {
        color: white;
        font-weight: 600;
        padding: 16px 12px;
        text-align: center;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-right: 1px solid rgba(255,255,255,0.1);
    }
    .complete-internship-table thead th:last-child {
        border-right: none;
    }
    .complete-internship-table tbody tr {
        border-bottom: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }
    .complete-internship-table tbody tr:hover {
        background: #f8f9fa;
    }
    .complete-internship-table tbody td {
        padding: 16px 12px;
        vertical-align: middle;
        font-size: 14px;    
        color: #495057;
    }
    .complete-internship-table tbody td:first-child {
        text-align: center;
        font-weight: 600;
        color: #242a62;
    }
    .marks-input-group {
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
    }
    .marks-input-group label {
        margin: 0;
        font-size: 12px;
        color: #6c757d;
        font-weight: 600;
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
    .grade-A { background: #28a745; color: white; }
    .grade-B { background: #17a2b8; color: white; }
    .grade-C { background: #ffc107; color: #333; }
    .grade-D { background: #fd7e14; color: white; }
    .grade-F { background: #dc3545; color: white; }
    .btn-submit-college-marks {
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
    .btn-submit-college-marks:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        color: white;
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
        color: white;
    }
    .internship-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }
    .internship-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e9ecef;
    }
    .status-badge-completed {
        background: #28a745;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-badge-pending {
        background: #ffc107;
        color: #333;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    @media (max-width: 768px) {
        .complete-internship-table { font-size: 12px; }
        .marks-input { width: 60px; padding: 6px 8px; font-size: 12px; }
        .complete-internship-table thead th,
        .complete-internship-table tbody td { padding: 10px 6px; }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
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
        <div class="text-center py-5 text-muted">
            <i class="bx bx-filter-alt" style="font-size: 48px;"></i>
            <p class="mt-2">Select filters above and click "Load Students" to view data</p>
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
                        <div class="text-center py-5 text-muted">
                            <i class="bx bx-info-circle" style="font-size: 48px;"></i>
                            <p class="mt-2">${res.message || 'No internships found for the selected filters.'}</p>
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
    function renderInternships(internships, criteria, collegeId, courseId) {
        let html = '';

        internships.forEach(function(internship) {
            const isCompleted = internship.college_submitted === true;
            const statusBadge = isCompleted
                ? '<span class="status-badge-completed"><i class="bx bx-check"></i> College Marks Submitted</span>'
                : '<span class="status-badge-pending"><i class="bx bx-time"></i> Pending</span>';

            html += `<div class="internship-card" data-internship-id="${internship.internship_id}" data-college-id="${collegeId}">`;
            html += `<div class="internship-card-header">`;
            html += `<div>
                        <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                            <i class="bx bx-briefcase-alt-2"></i> ${escHtml(internship.internship_title)}
                        </h5>
                     </div>`;
            html += `<div class="d-flex align-items-center gap-2">
                        ${statusBadge}
                        <button class="btn export-btn btn-sm" onclick="exportCollegeMarks(${internship.internship_id})">
                            <i class="fa fa-file-excel-o"></i> Export
                        </button>
                     </div>`;
            html += `</div>`;

            if (isCompleted) {
                html += `<div class="alert alert-success"><i class="bx bx-check-circle"></i> <strong>Submitted!</strong> College marks have been finalized. Grades and feedback are locked.</div>`;
            }

            html += `<div class="table-responsive">`;
            html += `<table class="complete-internship-table" id="collegeTable_${internship.internship_id}">`;
            html += `<thead><tr>`;
            html += `<th>SR.NO</th><th>INTERNSHIP</th><th>STUDENT</th>`;
            if (isSuperAdmin) html += `<th>COLLEGE</th>`;
            html += `<th style="min-width: 300px;">COLLEGE MARKS</th>`;
            html += `<th>FEEDBACK</th><th>TOTAL</th><th>PERCENTAGE</th><th>GRADE</th>`;
            html += `</tr></thead><tbody>`;

            if (internship.students.length === 0) {
                const colSpan = isSuperAdmin ? 9 : 8;
                html += `<tr><td colspan="${colSpan}" class="text-center py-4"><i class="bx bx-info-circle"></i> No students found</td></tr>`;
            } else {
                internship.students.forEach(function(student, idx) {
                    const savedMarks = student.saved_marks || {};
                    const savedFeedback = student.feedback || '';
                    let maxTotal = 0;

                    html += `<tr data-student-id="${student.id}" data-internship-id="${internship.internship_id}">`;
                    html += `<td>${idx + 1}</td>`;
                    html += `<td><div style="font-weight: 600; color: #3d4575;">${escHtml(internship.internship_title)}</div></td>`;
                    html += `<td><div style="font-weight: 600; color: #242a62;">${escHtml(student.name).toUpperCase()}</div></td>`;
                    if (isSuperAdmin) html += `<td>${escHtml(student.college_name)}</td>`;

                    // College criteria inputs
                    html += `<td>`;
                    criteria.forEach(function(c) {
                        const savedVal = savedMarks[c.id] ? (typeof savedMarks[c.id] === 'object' ? savedMarks[c.id].marks : savedMarks[c.id]) : '';
                        maxTotal += parseInt(c.marks);
                        html += `<div class="marks-input-group mb-2">`;
                        html += `<label>${c.title}</label>`;
                        html += `<input type="number" class="marks-input college-mark"
                                    min="0" max="${c.marks}"
                                    data-max="${c.marks}"
                                    data-criteria-id="${c.id}"
                                    data-criteria-name="${c.title}"
                                    data-student-id="${student.id}"
                                    data-internship-id="${internship.internship_id}"
                                    placeholder="0"
                                    value="${savedVal}"
                                    ${isCompleted ? 'disabled' : ''}>`;
                        html += `<span class="max-marks">/ ${c.marks}</span>`;
                        html += `</div>`;
                    });
                    html += `</td>`;

                    // Feedback
                    html += `<td>
                        <textarea class="feedback-textarea college-feedback"
                            data-student-id="${student.id}"
                            data-internship-id="${internship.internship_id}"
                            placeholder="Enter college feedback..."
                            ${isCompleted ? 'disabled' : ''}>${escHtml(savedFeedback)}</textarea>
                    </td>`;

                    html += `<td class="total-display">0 / ${maxTotal}</td>`;
                    html += `<td class="percentage-display">0.00%</td>`;
                    html += `<td><span class="grade-badge grade-F">-</span></td>`;
                    html += `</tr>`;
                });
            }

            html += `</tbody></table></div>`;

            // Submit button
            if (!isCompleted && internship.students.length > 0) {
                html += `<div class="text-center mt-4">
                    <button class="btn btn-submit-college-marks" onclick="showSubmitConfirm(${internship.internship_id}, '${collegeId}', '${courseId}')">
                        <i class="fa fa-check-circle"></i> Submit College Marks
                    </button>
                </div>`;
            }

            html += `<div class="alert alert-info mt-3"><i class="bx bx-info-circle"></i> <strong>Note:</strong> Marks auto-save as you type. Once submitted, grades and feedback cannot be modified.</div>`;
            html += `</div>`;
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
        const internshipId = input.data('internship-id');
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
        const internshipId = textarea.data('internship-id');
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
        const rows = table.querySelectorAll('tbody tr[data-student-id]');
        let allFilled = true;
        let missingList = [];

        rows.forEach(row => {
            const studentName = row.querySelector('td:nth-child(2)')?.textContent?.trim() || 'Unknown';
            const inputs = row.querySelectorAll('.college-mark');
            const feedback = row.querySelector('.college-feedback');
            let rowOk = true;

            // Only validate marks if criteria inputs exist for this student
            if (inputs.length > 0) {
                inputs.forEach(input => {
                    if (input.value === '' || input.value === null) { rowOk = false; }
                });
            }

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
