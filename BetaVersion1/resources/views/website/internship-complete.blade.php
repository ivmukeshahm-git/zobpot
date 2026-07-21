@extends('website.layout.layout')
@section('website-content')

@push('css')
<style>
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

    .complete-internship-table thead th:last-child { border-right: none; }

    .complete-internship-table tbody tr {
        border-bottom: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .complete-internship-table tbody tr:hover { background: #f8f9fa; }

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

    .marks-input:disabled { background: #f8f9fa; cursor: not-allowed; }

    .feedback-textarea:disabled {
        background: #f8f9fa;
        cursor: not-allowed;
        color: #495057;
        opacity: 1;
        resize: none;
    }

    .max-marks { font-size: 13px; color: #6c757d; font-weight: 600; }

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

    .total-display { font-size: 18px; font-weight: 700; color: #242a62; text-align: center; }
    .percentage-display { font-size: 16px; font-weight: 700; color: #17a2b8; text-align: center; }

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

    .btn-complete-internship-submit:hover {
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
    }

    .export-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(36, 42, 98, 0.3);
        color: white;
    }

    /* Readonly display for replaced inputs */
    .readonly-mark {
        display: inline-block;
        min-width: 70px;
        padding: 8px 10px;
        border-radius: 8px;
        background: #f8f9fa;
        text-align: center;
        font-weight: 600;
    }

    .readonly-feedback {
        padding: 10px;
        border-radius: 8px;
        background: #f8f9fa;
        min-height: 80px;
        white-space: pre-wrap;
    }
</style>
@endpush

<main class="main">
    <section class="section-box mt-50">
        <div class="container">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4" style="background: #242a62; padding: 25px 30px; border-radius: 12px;">
                <div>
                    <h4 style="color: white; margin: 0; font-weight: 700;">
                        <i class="bx bx-check-circle"></i> Complete Internship
                    </h4>
                    <p style="color: rgba(255,255,255,0.9); margin: 5px 0 0;">{{ $internship->internship_title }}</p>
                </div>
                <a href="{{ route('company-profile') }}" class="btn btn-light">
                    <i class="bx bx-arrow-back"></i> Back
                </a>
            </div>

            {{-- If internship type is company-only (2) and company has completed, treat as completed; otherwise show college-pending warning when appropriate --}}
            @if($internship->internship_type == 2 && $internship->company_complete_sts == 1)
                <div class="alert alert-success d-flex align-items-center" role="alert" style="margin-bottom:18px;">
                    <i class="bx bx-check-circle" style="font-size:20px;"></i>
                    <div class="ms-3">
                        <strong>Completed by company.</strong> This is a company-only internship and marks are submitted.
                    </div>
                </div>
            @elseif($internship->company_complete_sts == 1 && $internship->college_complete_sts == 0 && $internship->complete_status == 0)
                <div class="alert alert-success d-flex align-items-center" role="alert" style="margin-bottom:18px;">
                    <i class="bx bx-check-circle" style="font-size:20px;"></i>
                    <div class="ms-3">
                        <strong>Marks submitted successfully. Editing is disabled.</strong> College side marks are still pending.
                    </div>
                </div>
            @endif

            @if($internship->complete_status == 1)
                <div class="alert alert-success" role="alert">
                    <i class="bx bx-check-circle"></i> <strong>Completed!</strong> This internship has been finalized. Grades and feedback are locked.
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="text-muted mb-0">Evaluate student performance and assign grades</p>
                <button class="btn export-btn" onclick="exportToExcel()">
                    <i class="fa fa-file-excel-o"></i> Export to Excel
                </button>
            </div>

            @php
                $colspan = 3; // SR.NO, STUDENT, COLLEGE
                if($internship->internship_type == 1 && $hasIndustryCriteria) $colspan++;
                $colspan += 1; // FEEDBACK
                if($internship->internship_type == 1) $colspan += 3; // TOTAL, PERCENTAGE, GRADE
            @endphp

            <div class="table-responsive">
                <table class="complete-internship-table" id="completionTable">
                    <thead>
                        <tr>
                            <th>SR.NO</th>
                            <th>STUDENT</th>
                            <th>COLLEGE</th>
                            @if($internship->internship_type == 1 && $hasIndustryCriteria)
                                <th style="min-width: 300px;">INDUSTRY (INDUSTRY MARKS)</th>
                            @endif
                            <th>FEEDBACK</th>
                            @if($internship->internship_type == 1)
                                <th>TOTAL</th>
                                <th>PERCENTAGE</th>
                                <th>GRADE</th>
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
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div style="font-weight: 600; color: #242a62;">
                                        {{ strtoupper($student->name ?? 'N/A') }}
                                    </div>
                                </td>
                                <td>{{ $college ? $college->college_name : 'N/A' }}</td>
                                @if($internship->internship_type == 1 && $studentCriteria->count() > 0)
                                <td>
                                    @foreach($studentCriteria as $criterion)
                                        <div class="marks-input-group mb-2">
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
                                </td>
                                @endif
                                <td>
                                    <textarea class="feedback-textarea"
                                              data-student-id="{{ $student->id }}"
                                              placeholder="Enter feedback for student..."
                                              {{ $isSubmitted ? 'disabled' : '' }}>{{ $savedFeedback }}</textarea>
                                </td>
                                @if($internship->internship_type == 1)
                                    <td class="total-display">0 / {{ $maxTotal }}</td>
                                    <td class="percentage-display">0.00%</td>
                                    <td>
                                        <span class="grade-badge grade-F">-</span>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $colspan }}" class="text-center py-4">
                                    <i class="bx bx-info-circle"></i> No students enrolled
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(!$internship->complete_status && $students->count() > 0 && !($internship->company_complete_sts == 1 && $internship->college_complete_sts == 0) && !($internship->internship_type == 2 && $internship->company_complete_sts == 1))
            <div class="text-center mt-4">
                <button class="btn btn-complete-internship-submit" onclick="showConfirmModal()">
                    <i class="fa fa-check-circle"></i> Submit & Complete Internship
                </button>
            </div>
            @elseif(!$internship->complete_status && $internship->company_complete_sts == 1 && $internship->college_complete_sts == 0)
            <div class="alert alert-warning mt-4" role="alert">
                <i class="bx bx-info-circle"></i> <strong>Industry marks completed.</strong> College side marks are still pending. Submission is disabled until college marks are entered.
            </div>
            @endif

            <div class="alert alert-info mt-4 mb-5" role="alert">
                <i class="bx bx-info-circle"></i> <strong>Note:</strong> Once submitted, student grades and feedback cannot be modified.
            </div>
        </div>
    </section>
</main>

@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
    const internshipId = {{ $internship->id }};
    const csrfToken = '{{ csrf_token() }}';
    const internshipType = {{ $internship->internship_type }};
    const companyCompleteSts = {{ (int) $internship->company_complete_sts }};

    let marksLoaded = false;

    // Auto-save marks
    let saveTimer = {};
    $(document).on('input', '.industry-mark', function() {
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
        const key = studentId + '_' + criteriaId;

        clearTimeout(saveTimer[key]);
        saveTimer[key] = setTimeout(function() {
            $.ajax({
                url: '{{ route("website.internship.save-marks") }}',
                method: 'POST',
                data: { _token: csrfToken, internship_id: internshipId, student_id: studentId, criteria_id: criteriaId, criteria_name: criteriaName, max_marks: maxMarks, marks: value },
                success: function(res) {
                    if (res.success) { input.css('border-color', '#28a745'); setTimeout(() => input.css('border-color', ''), 1500); }
                },
                error: function() { input.css('border-color', '#dc3545'); }
            });
        }, 300);
    });

    // Auto-save feedback
    let feedbackTimer = {};
    $(document).on('input', '.feedback-textarea', function() {
        const textarea = $(this);
        const studentId = textarea.data('student-id');
        clearTimeout(feedbackTimer[studentId]);
        feedbackTimer[studentId] = setTimeout(function() {
            $.ajax({
                url: '{{ route("website.internship.save-feedback") }}',
                method: 'POST',
                data: { _token: csrfToken, internship_id: internshipId, student_id: studentId, feedback: textarea.val() },
                success: function(res) {
                    if (res.success) { textarea.css('border-color', '#28a745'); setTimeout(() => textarea.css('border-color', ''), 1500); }
                },
                error: function() { textarea.css('border-color', '#dc3545'); }
            });
        }, 500);
    });

    // Load saved marks
    function loadSavedMarks() {
        if (marksLoaded) { recalcAll(); return; }
        marksLoaded = true;
        $.ajax({
            url: '{{ route("website.internship.fetch-marks", $internship->id) }}',
            method: 'GET',
            success: function(res) {
                if (res.success && res.data) {
                    $.each(res.data, function(studentId, data) {
                        if (data.criteria) {
                            $.each(data.criteria, function(criteriaId, criteriaData) {
                                const marks = typeof criteriaData === 'object' ? criteriaData.marks : criteriaData;
                                const input = $(`.industry-mark[data-student-id="${studentId}"][data-criteria-id="${criteriaId}"]`);
                                if (input.length && !input.val()) input.val(marks);
                            });
                        }
                        if (data.feedback) {
                            const textarea = $(`.feedback-textarea[data-student-id="${studentId}"]`);
                            if (textarea.length && !textarea.val()) textarea.val(data.feedback);
                        }
                    });
                }
                recalcAll();

                // Re-enforce disabled state after AJAX populates values
                if (companyCompleteSts == 1) {
                    $('input.marks-input, textarea.feedback-textarea').prop('disabled', true);
                }
            }
        });
    }

    function recalcAll() {
        document.querySelectorAll('#completionTable tbody tr[data-student-id]').forEach(row => calculateMarks(row));
    }

    // Calculate
    function calculateMarks(row) {
        // Skip calculations for internship type 2 (only feedback required)
        if (parseInt(internshipType) !== 1) return;

        const inputs = row.querySelectorAll('.industry-mark');
        let total = 0, maxTotal = 0;
        inputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            const max = parseFloat(input.getAttribute('data-max')) || 0;
            total += value > max ? max : value;
            if (value > max) input.value = max;
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

        const totalEl = row.querySelector('.total-display');
        const percentEl = row.querySelector('.percentage-display');
        const badge = row.querySelector('.grade-badge');
        if (totalEl) totalEl.textContent = `${total} / ${maxTotal}`;
        if (percentEl) percentEl.textContent = `${percentage}%`;
        if (badge) {
            badge.textContent = grade;
            badge.className = `grade-badge ${gradeClass}`;
        }
    }

    // Confirm modal
    window.showConfirmModal = function() {
        let allFilled = true;
        document.querySelectorAll('#completionTable tbody tr[data-student-id]').forEach(row => {
            if (parseInt(internshipType) === 1) {
                row.querySelectorAll('.industry-mark').forEach(input => { if (!input.value || parseFloat(input.value) === 0) allFilled = false; });
            }
            const fb = row.querySelector('.feedback-textarea');
            if (!fb || !fb.value.trim()) allFilled = false;
        });

        if (!allFilled) {
            Swal.fire({ icon: 'warning', title: 'Incomplete Data', text: 'Please fill all marks and feedback.' });
            return;
        }

        Swal.fire({
            title: 'Submit Industry Marks',
            html: '<p>This will submit the industry (company) marks and mark the internship as company-submitted. <strong>College marks are still required.</strong></p>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Submit',
            cancelButtonText: 'Cancel'
        }).then((result) => { if (result.isConfirmed) confirmCompletion(); });
    }

    window.confirmCompletion = function() {
        Swal.fire({ title: 'Saving...', allowOutsideClick: false, showConfirmButton: false, willOpen: () => Swal.showLoading() });
        $.ajax({
            url: '{{ route("website.internship.submit-completion") }}',
            method: 'POST',
            data: { _token: csrfToken, internship_id: internshipId },
            success: function(res) {
                if (res.success) {
                    // Clear any pending autosave timers so no further AJAX fires
                    try { Object.keys(saveTimer).forEach(k => clearTimeout(saveTimer[k])); } catch(e) {}
                    try { Object.keys(feedbackTimer).forEach(k => clearTimeout(feedbackTimer[k])); } catch(e) {}

                    // Disable submit button
                    $('.btn-complete-internship-submit').prop('disabled', true).addClass('disabled');

                    // Unbind input handlers to avoid accidental triggers
                    $(document).off('input', '.industry-mark');
                    $(document).off('input', '.feedback-textarea');

                    // Replace inputs with readonly displays (robust lock)
                    function escapeHtml(str) { return $('<div>').text(str).html(); }
                    $('.industry-mark').each(function() {
                        const $i = $(this);
                        const v = $i.val() || '';
                        // replace input with span showing value
                        $i.replaceWith('<span class="readonly-mark">' + escapeHtml(v) + '</span>');
                    });
                    $('.feedback-textarea').each(function() {
                        const $t = $(this);
                        const v = $t.val() || '';
                        $t.replaceWith('<div class="readonly-feedback">' + escapeHtml(v) + '</div>');
                    });

                    Swal.fire({ icon: 'success', title: 'Submitted', text: res.message, timer: 1400, showConfirmButton: false });

                    // Reload shortly to refresh banners and server state
                    setTimeout(function() { location.reload(); }, 1500);
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                }
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message || 'An error occurred' });
            }
        });
    }

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
                const clone = document.querySelector('#completionTable').cloneNode(true);

                clone.querySelectorAll('.industry-mark').forEach(i => {
                    const s = document.createElement('span'); s.textContent = i.value || '0'; i.parentNode.replaceChild(s, i);
                });
                clone.querySelectorAll('.feedback-textarea').forEach(t => {
                    const s = document.createElement('span'); s.textContent = t.value || ''; t.parentNode.replaceChild(s, t);
                });

                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, XLSX.utils.table_to_sheet(clone), 'Internship Report');
                XLSX.writeFile(wb, filename + '.xlsx');
            }
        });
    }

    // Init
    $(document).ready(function() {
        loadSavedMarks();
        // jQuery safety: ensure inputs/textareas are disabled when company marks already submitted
        if (companyCompleteSts == 1) {
            $('input.marks-input, textarea.feedback-textarea').prop('disabled', true);
        }
    });
</script>
@endpush
