@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "CollegeMarksHistory";
</script>

<style>
    .detail-header {
        background: #242a62;
        border-radius: 16px;
        padding: 24px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .detail-header::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(242, 110, 44, 0.15);
        border-radius: 50%;
    }
    .back-btn {
        background: rgba(255,255,255,0.15);
        color: white;
        padding: 8px 18px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .back-btn:hover { background: rgba(255,255,255,0.25); color: white; text-decoration: none; }
    .export-btn {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .export-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(40,167,69,0.3); color: white; text-decoration: none; }

    /* View toggle */
    .view-toggle-bar {
        background: white;
        border-radius: 12px;
        padding: 14px 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .toggle-label { font-weight: 700; font-size: 13px; color: #242a62; text-transform: uppercase; letter-spacing: 0.5px; }
    .toggle-btn {
        padding: 8px 22px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        border: 2px solid #dee2e6;
        cursor: pointer;
        transition: all 0.25s ease;
        background: white;
        color: #6c757d;
    }
    .toggle-btn:hover { border-color: #242a62; color: #242a62; background: #f0f2ff; }
    .toggle-btn.active-all      { background: #242a62; border-color: #242a62; color: white; }
    .toggle-btn.active-college  { background: #17a2b8; border-color: #17a2b8; color: white; }
    .toggle-btn.active-industry { background: #f26e2c; border-color: #f26e2c; color: white; }
    .toggle-group { display: flex; align-items: center; gap: 8px; }
    .export-tab-btn {
        padding: 7px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        border: 2px solid #28a745;
        cursor: pointer;
        background: white;
        color: #28a745;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .export-tab-btn:hover { background: #28a745; color: white; }

    /* Info card */
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 20px 24px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }
    .info-row { display: flex; gap: 8px; margin-bottom: 6px; font-size: 14px; align-items: flex-start; }
    .info-row i { color: #242a62; font-size: 18px; flex-shrink: 0; margin-top: 1px; }
    .student-count-badge {
        background: #f0f2ff; color: #242a62; padding: 6px 14px;
        border-radius: 20px; font-size: 13px; font-weight: 600;
        display: inline-flex; align-items: center; gap: 6px;
    }

    /* Main table */
    .marks-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }
    .marks-table thead {
        background: linear-gradient(135deg, #242a62 0%, #3d4575 100%);
    }
    .marks-table thead th {
        color: white;
        font-weight: 600;
        padding: 14px 12px;
        text-align: center;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-right: 1px solid rgba(255,255,255,0.1);
        vertical-align: middle;
        white-space: nowrap;
    }
    .marks-table thead th:last-child { border-right: none; }
    .marks-table thead th.th-college  { background: rgba(23,162,184,0.35); }
    .marks-table thead th.th-industry { background: rgba(242,110,44,0.35); }
    .marks-table thead th.th-combined { background: rgba(40,167,69,0.35); }

    .marks-table tbody tr { border-bottom: 1px solid #e9ecef; transition: background 0.2s; }
    .marks-table tbody tr:hover { background: #f8f9fa; }
    .marks-table tbody tr:last-child { border-bottom: none; }
    .marks-table tbody td {
        padding: 14px 12px;
        vertical-align: middle;
        font-size: 13px;
        color: #495057;
        text-align: center;
    }
    .marks-table tbody td:first-child { font-weight: 700; color: #242a62; }

    /* Inline marks group */
    .marks-group { display: flex; flex-direction: column; gap: 6px; min-width: 180px; }
    .marks-row   { display: flex; align-items: center; gap: 8px; justify-content: center; }
    .marks-row .crit-label {
        font-size: 12px; color: #6c757d; font-weight: 600;
        min-width: 100px; text-align: right; flex-shrink: 0;
    }
    .mark-val {
        display: inline-block;
        min-width: 52px;
        padding: 5px 10px;
        background: #f0f2ff;
        border: 2px solid #c9cef5;
        border-radius: 7px;
        text-align: center;
        font-weight: 700;
        font-size: 13px;
        color: #242a62;
    }
    .mark-val.industry {
        background: #fff4ee;
        border-color: #f5c9ae;
        color: #b8480f;
    }
    .mark-max { font-size: 11px; color: #adb5bd; font-weight: 600; }
    .no-criteria-dash { font-size: 22px; font-weight: 700; color: #adb5bd; letter-spacing: 2px; }

    /* Feedback */
    .feedback-box {
        padding: 8px 10px;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 13px;
        color: #495057;
        text-align: left;
        /* white-space: pre-wrap; */
        min-width: 140px;
        max-width: 220px;
        font-style: italic;
    }
    .feedback-box.industry { background: #fff8f4; border-color: #f5c9ae; }
    .feedback-box.empty    { color: #adb5bd; }

    /* Stats */
    .total-val  { font-size: 15px; font-weight: 700; color: #242a62; white-space: nowrap; }
    .pct-val    { font-size: 14px; font-weight: 700; color: #17a2b8; }
    .pct-combined { color: #28a745 !important; }
    .grade-badge {
        display: inline-block; padding: 6px 16px;
        border-radius: 20px; font-weight: 700; font-size: 13px;
    }
    .grade-A  { background: #28a745; color: white; }
    .grade-B  { background: #17a2b8; color: white; }
    .grade-C  { background: #ffc107; color: #333; }
    .grade-D  { background: #fd7e14; color: white; }
    .grade-F  { background: #dc3545; color: white; }
    .grade-dash { background: #dee2e6; color: #6c757d; }

    .mark-edit-input {
        width: 64px;
        padding: 4px 6px;
        border: 2px solid #242a62;
        border-radius: 6px;
        text-align: center;
        font-weight: 700;
        font-size: 13px;
        color: #242a62;
        display: none;
    }
    .feedback-edit {
        width: 100%;
        min-width: 140px;
        min-height: 70px;
        padding: 8px 10px;
        border: 2px solid #242a62;
        border-radius: 8px;
        font-size: 13px;
        display: none;
    }
    tr.editing .view-mode { display: none !important; }
    tr.editing .edit-mode { display: inline-block !important; }
    tr.editing textarea.edit-mode { display: block !important; }
    .btn-row-edit, .btn-row-update, .btn-row-cancel {
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        padding: 6px 12px;
        margin: 2px;
        cursor: pointer;
        white-space: nowrap;
    }
    .btn-row-edit { background: #242a62; color: #fff; }
    .btn-row-update { background: #28a745; color: #fff; display: none; }
    .btn-row-cancel { background: #6c757d; color: #fff; display: none; }
    tr.editing .btn-row-edit { display: none; }
    tr.editing .btn-row-update, tr.editing .btn-row-cancel { display: inline-block; }

    /* College/degree badge in student cell */
    .college-badge {
        display: inline-block;
        background: #f0f2ff; color: #242a62;
        padding: 2px 10px; border-radius: 10px;
        font-size: 11px; font-weight: 600; margin-top: 3px;
    }
    .degree-badge {
        display: inline-block;
        background: #e8f7fb; color: #0c6b7c;
        padding: 2px 10px; border-radius: 10px;
        font-size: 11px; font-weight: 600; margin-top: 2px;
    }

    @media (max-width: 768px) {
        .marks-table { font-size: 11px; }
        .mark-val { min-width: 40px; padding: 4px 6px; font-size: 11px; }
        .marks-table thead th, .marks-table tbody td { padding: 8px 6px; }
        .marks-row .crit-label { min-width: 70px; font-size: 10px; }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    @if(auth()->guard('college')->check() || auth()->guard('college_staff')->check())
    @component('admin.layout.partials.college-page-banner', [
        'emoji' => '🕒',
        'title' => $internship->internship_title,
        'subtitle' => 'College Marks History — Read Only',
        'illustration' => 'history',
        'crumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.college.dashboard')],
            ['label' => 'Marks History', 'url' => route('admin.internship.college-marks-history')],
            ['label' => 'Detail'],
        ],
    ])
        <a href="{{ route('admin.internship.college-marks-history') }}" class="btn zp-banner-btn">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    @endcomponent
    @else
    {{-- Page Header --}}
    <div class="detail-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div style="z-index:1;position:relative;">
                <h4 style="color:#fff;margin:0;"><i class="bx bx-history"></i> {{ $internship->internship_title }}</h4>
                <p style="color:rgba(255,255,255,0.7);margin:5px 0 0 0;font-size:14px;">College Marks History — Read Only</p>
            </div>
            <div class="d-flex gap-2" style="z-index:1;position:relative;">
                <a href="{{ route('admin.internship.college-marks-history') }}" class="back-btn">
                    <i class="bx bx-arrow-back"></i> Back
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- Status Alert --}}
    <div class="alert alert-success d-flex align-items-center" style="border-radius:10px;">
        <i class="bx bx-check-circle me-2" style="font-size:22px;"></i>
        @if($internship->internship_type == 2)
        <div><strong>Company Marks Submitted!</strong> This is a company-only opportunity. Feedback has been finalized. This is a read-only view.</div>
        @else
        <div><strong>College Marks Submitted!</strong> All marks and feedback have been finalized. This is a read-only view.</div>
        @endif
    </div>

    {{-- Info Card --}}
    <div class="info-card">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="info-row"><i class="bx bx-briefcase-alt-2"></i><strong>Opportunity:</strong>&nbsp;{{ $internship->internship_title }}</div>
                <div class="info-row"><i class="bx bx-building"></i><strong>Company:</strong>&nbsp;{{ optional($internship->company)->name ?? 'N/A' }}</div>
                @if($internship->start_date || $internship->end_date)
                <div class="info-row">
                    <i class="bx bx-calendar"></i><strong>Duration:</strong>&nbsp;
                    {{ $internship->start_date ? \Carbon\Carbon::parse($internship->start_date)->format('d M Y') : '' }}
                    {{ ($internship->start_date && $internship->end_date) ? ' — ' : '' }}
                    {{ $internship->end_date ? \Carbon\Carbon::parse($internship->end_date)->format('d M Y') : '' }}
                </div>
                @endif
            </div>
            <div class="col-md-4 text-end">
                <span class="student-count-badge">
                    <i class="bx bx-user"></i> {{ count($students) }} Student(s)
                </span>
            </div>
        </div>
    </div>

    {{-- View Toggle (type 1 only) --}}
    @if($internship->internship_type == 1)
    <div class="view-toggle-bar">
        <span class="toggle-label"><i class="bx bx-filter-alt"></i> View:</span>
        <button class="toggle-btn active-all" id="btnAll" onclick="setView('all')">
            <i class="bx bx-table"></i> View All <small style="opacity:.8;">(College + Industry)</small>
        </button>
        <button class="toggle-btn" id="btnCollege" onclick="setView('college')">
            <i class="bx bx-book-reader"></i> College Marks
        </button>
        <button class="toggle-btn" id="btnIndustry" onclick="setView('industry')">
            <i class="bx bx-briefcase-alt-2"></i> Industry Marks
        </button>
    </div>

    {{-- Export Bar --}}
    <div style="background:white;border-radius:12px;padding:14px 20px;box-shadow:0 2px 12px rgba(0,0,0,0.08);margin-bottom:16px;display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <span style="font-weight:700;font-size:13px;color:#242a62;text-transform:uppercase;letter-spacing:0.5px;"><i class="bx bx-download"></i> Export:</span>
        <button class="export-tab-btn" onclick="exportView('all')">
            <i class="bx bx-table"></i> View All (College + Industry)
        </button>
        <button class="export-tab-btn" style="border-color:#17a2b8;color:#17a2b8;" onclick="exportView('college')" onmouseover="this.style.background='#17a2b8';this.style.color='white'" onmouseout="this.style.background='white';this.style.color='#17a2b8'">
            <i class="bx bx-book-reader"></i> College Marks
        </button>
        <button class="export-tab-btn" style="border-color:#f26e2c;color:#f26e2c;" onclick="exportView('industry')" onmouseover="this.style.background='#f26e2c';this.style.color='white'" onmouseout="this.style.background='white';this.style.color='#f26e2c'">
            <i class="bx bx-briefcase-alt-2"></i> Industry Marks
        </button>
    </div>
    @endif {{-- closes @if($internship->internship_type == 1) --}}

    {{-- Marks Table --}}
    <div class="table-responsive">
        <table class="marks-table" id="marksHistoryTable">
            <thead>
                <tr>
                    <th>SR.NO</th>
                    <th>STUDENT</th>
                    @if($isSuperAdmin && $internship->internship_type == 1)
                    <th>COLLEGE</th>
                    @endif
                    @if($internship->internship_type == 2)
                    {{-- Company-only: just show company feedback --}}
                    <th class="th-industry">COMPANY FEEDBACK</th>
                    @else
                    <th class="th-college col-college">COLLEGE MARKS</th>
                    <th class="th-industry col-industry">INDUSTRY (INDUSTRY MARKS)</th>
                    <th class="th-college col-college">COLLEGE FEEDBACK</th>
                    <th class="th-industry col-industry">COMPANY FEEDBACK</th>
                    <th class="th-college col-college">COLLEGE TOTAL</th>
                    <th class="th-college col-college">COLLEGE %</th>
                    <th class="th-college col-college">COLLEGE GRADE</th>
                    <th class="th-industry col-industry">INDUSTRY TOTAL</th>
                    <th class="th-industry col-industry">INDUSTRY %</th>
                    <th class="th-industry col-industry">INDUSTRY GRADE</th>
                    <th class="th-combined col-combined">COMBINED TOTAL</th>
                    <th class="th-combined col-combined">COMBINED %</th>
                    <th class="th-combined col-combined">OVERALL GRADE</th>
                    @endif
                    @if($isSuperAdmin)
                    <th class="col-action no-export">ACTION</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($students as $index => $student)
                @php
                    $collegeCrit  = $student['college_criteria'];
                    $industryCrit = $student['industry_criteria'];
                    // Grade CSS class helper
                    $gradeClass = function(float $pct): string {
                        if ($pct >= 80) return 'grade-A';
                        if ($pct >= 70) return 'grade-B';
                        if ($pct >= 60) return 'grade-C';
                        if ($pct >= 50) return 'grade-D';
                        if ($pct >  0)  return 'grade-F';
                        return 'grade-dash';
                    };
                @endphp
                <tr data-student-id="{{ $student['id'] }}">
                    <td>{{ $index + 1 }}</td>

                    {{-- Student info --}}
                    <td style="text-align:left;min-width:150px;">
                        <div style="font-weight:700;color:#242a62;font-size:14px;">{{ strtoupper($student['name']) }}</div>
                        <div class="degree-badge">{{ $student['degree_name'] }}</div>
                        @if(!$isSuperAdmin || $internship->internship_type == 2)
                        <div class="college-badge">{{ $student['college_name'] }}</div>
                        @endif
                    </td>

                    @if($internship->internship_type == 2)
                    {{-- Company-only opportunity: show only company feedback --}}
                    <td style="min-width:200px;">
                        <div class="feedback-box industry view-mode company-feedback-view {{ $student['company_feedback'] ? '' : 'empty' }}">
                            {{ $student['company_feedback'] ?: 'No feedback' }}
                        </div>
                        @if($isSuperAdmin)
                        <textarea class="feedback-edit edit-mode company-feedback-input">{{ $student['company_feedback'] }}</textarea>
                        @endif
                    </td>
                    @else
                    {{-- Industry+College internship (type 1) --}}
                    @if($isSuperAdmin)
                    <td style="min-width:130px;">
                        <div style="font-weight:600;color:#495057;">{{ $student['college_name'] }}</div>
                        <div style="font-size:11px;color:#6c757d;">{{ $student['university_name'] }}</div>
                    </td>
                    @endif

                    {{-- College Marks --}}
                    <td class="col-college" style="min-width:220px;">
                        @if($collegeCrit->count())
                        <div class="marks-group">
                            @foreach($collegeCrit as $c)
                            <div class="marks-row" data-side="college" data-criteria-id="{{ $c->id }}">
                                <span class="crit-label">{{ $c->title }}</span>
                                <span class="mark-val view-mode" data-criteria-id="{{ $c->id }}">{{ $student['college_marks'][$c->id] ?? 0 }}</span>
                                @if($isSuperAdmin)
                                <input type="number" class="mark-edit-input edit-mode college-mark-input" min="0" max="{{ $c->marks }}"
                                    data-criteria-id="{{ $c->id }}" data-max="{{ $c->marks }}"
                                    value="{{ $student['college_marks'][$c->id] ?? 0 }}">
                                @endif
                                <span class="mark-max">/ {{ $c->marks }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <span class="no-criteria-dash">—</span>
                        @endif
                    </td>

                    {{-- Industry Marks --}}
                    <td class="col-industry" style="min-width:220px;">
                        @if($industryCrit->count())
                        <div class="marks-group">
                            @foreach($industryCrit as $c)
                            <div class="marks-row" data-side="industry" data-criteria-id="{{ $c->id }}">
                                <span class="crit-label">{{ $c->title }}</span>
                                <span class="mark-val industry view-mode" data-criteria-id="{{ $c->id }}">{{ $student['industry_marks'][$c->id] ?? 0 }}</span>
                                @if($isSuperAdmin)
                                <input type="number" class="mark-edit-input edit-mode industry-mark-input" min="0" max="{{ $c->marks }}"
                                    data-criteria-id="{{ $c->id }}" data-max="{{ $c->marks }}"
                                    value="{{ $student['industry_marks'][$c->id] ?? 0 }}">
                                @endif
                                <span class="mark-max">/ {{ $c->marks }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <span class="no-criteria-dash">—</span>
                        @endif
                    </td>

                    {{-- College Feedback --}}
                    <td class="col-college" style="min-width:160px;">
                        <div class="feedback-box view-mode college-feedback-view {{ $student['college_feedback'] ? '' : 'empty' }}">
                            {{ $student['college_feedback'] ?: 'No feedback' }}
                        </div>
                        @if($isSuperAdmin)
                        <textarea class="feedback-edit edit-mode college-feedback-input">{{ $student['college_feedback'] }}</textarea>
                        @endif
                    </td>

                    {{-- Company Feedback --}}
                    <td class="col-industry" style="min-width:160px;">
                        <div class="feedback-box industry view-mode company-feedback-view {{ $student['company_feedback'] ? '' : 'empty' }}">
                            {{ $student['company_feedback'] ?: 'No feedback' }}
                        </div>
                        @if($isSuperAdmin)
                        <textarea class="feedback-edit edit-mode company-feedback-input">{{ $student['company_feedback'] }}</textarea>
                        @endif
                    </td>

                    {{-- College Total --}}
                    <td class="col-college">
                        <div class="total-val college-total-val">{{ $student['college_total'] }} / {{ $student['college_max_total'] }}</div>
                    </td>
                    <td class="col-college">
                        <div class="pct-val college-pct-val" style="color:#17a2b8;">{{ $student['college_percentage'] }}%</div>
                    </td>
                    <td class="col-college">
                        <span class="grade-badge college-grade {{ $gradeClass((float)$student['college_percentage']) }}">
                            {{ $student['college_grade'] }}
                        </span>
                    </td>

                    {{-- Industry Total --}}
                    <td class="col-industry">
                        <div class="total-val industry-total-val">{{ $student['industry_total'] }} / {{ $student['industry_max_total'] }}</div>
                    </td>
                    <td class="col-industry">
                        <div class="pct-val industry-pct-val" style="color:#f26e2c;">{{ $student['industry_percentage'] }}%</div>
                    </td>
                    <td class="col-industry">
                        <span class="grade-badge industry-grade {{ $gradeClass((float)$student['industry_percentage']) }}">
                            {{ $student['industry_grade'] }}
                        </span>
                    </td>

                    {{-- Combined Total --}}
                    <td class="col-combined">
                        <div class="total-val combined-total-val" style="color:#28a745;">{{ $student['combined_total'] }} / {{ $student['combined_max_total'] }}</div>
                    </td>

                    {{-- Combined Percentage --}}
                    <td class="col-combined">
                        <div class="pct-val pct-combined combined-pct-val">{{ $student['combined_percentage'] }}%</div>
                    </td>

                    {{-- Combined Grade --}}
                    <td class="col-combined">
                        <span class="grade-badge combined-grade {{ $gradeClass((float)$student['combined_percentage']) }}">
                            {{ $student['combined_grade'] }}
                        </span>
                    </td>
                    @endif {{-- end type 1/type 2 --}}
                    @if($isSuperAdmin)
                    <td class="col-action no-export">
                        <button type="button" class="btn-row-edit" onclick="startEditMarksRow(this)"><i class="bx bx-edit"></i> Edit</button>
                        <button type="button" class="btn-row-update" onclick="saveMarksRow(this)"><i class="bx bx-check"></i> Update</button>
                        <button type="button" class="btn-row-cancel" onclick="cancelMarksRow(this)">Cancel</button>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $internship->internship_type == 2 ? 3 : ($isSuperAdmin ? 12 : 7) }}" class="text-center py-5 text-muted">
                        <i class="bx bx-info-circle" style="font-size:36px;"></i>
                        <p class="mt-2">No students found for this opportunity.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection

@push('script')
<script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
<script>
var currentView = 'all';

function setView(mode) {
    currentView = mode;

    // Reset all toggle buttons
    ['btnAll','btnCollege','btnIndustry'].forEach(function(id) {
        var btn = document.getElementById(id);
        if (btn) btn.className = 'toggle-btn';
    });

    var tbl = document.getElementById('marksHistoryTable');
    if (!tbl) return;

    if (mode === 'all') {
        document.getElementById('btnAll').classList.add('active-all');
        tbl.querySelectorAll('.col-college, .col-industry, .col-combined').forEach(function(el) {
            el.style.display = '';
        });
    } else if (mode === 'college') {
        document.getElementById('btnCollege').classList.add('active-college');
        tbl.querySelectorAll('.col-college').forEach(function(el) { el.style.display = ''; });
        tbl.querySelectorAll('.col-industry, .col-combined').forEach(function(el) { el.style.display = 'none'; });
    } else if (mode === 'industry') {
        document.getElementById('btnIndustry').classList.add('active-industry');
        tbl.querySelectorAll('.col-industry').forEach(function(el) { el.style.display = ''; });
        tbl.querySelectorAll('.col-college, .col-combined').forEach(function(el) { el.style.display = 'none'; });
    }
}

function exportView(exportMode) {
    var names = { all: 'marks_all', college: 'college_marks', industry: 'industry_marks' };
    var defaultName = names[exportMode] || 'marks_export';

    Swal.fire({
        title: 'Export to Excel',
        input: 'text',
        inputValue: defaultName,
        inputPlaceholder: 'Enter file name',
        showCancelButton: true,
        confirmButtonColor: '#242a62',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bx bx-download"></i> Download',
        cancelButtonText: 'Cancel',
        inputValidator: function(val) {
            if (!val || !val.trim()) return 'Please enter a file name';
        }
    }).then(function(result) {
        if (!result.isConfirmed || !result.value) return;

        var filename = result.value.trim().replace(/[^a-zA-Z0-9_\-]/g, '_') || defaultName;
        var prevView = currentView;

        // Switch to export mode to get correct column visibility
        setView(exportMode);

        var tbl = document.getElementById('marksHistoryTable');
        if (!tbl) { setView(prevView); return; }

        var clone = tbl.cloneNode(true);

        // Remove hidden th/td from every row
        clone.querySelectorAll('tr').forEach(function(row) {
            row.querySelectorAll('th, td').forEach(function(cell) {
                if (cell.style.display === 'none' || cell.classList.contains('no-export') || cell.classList.contains('col-action')) cell.remove();
            });
        });
        clone.querySelectorAll('.edit-mode, .btn-row-edit, .btn-row-update, .btn-row-cancel').forEach(function(el) {
            el.remove();
        });

        // Strip visual styling for clean export text
        clone.querySelectorAll('.grade-badge, .mark-val, .total-val, .pct-val, .feedback-box, .crit-label, .mark-max, .degree-badge, .college-badge, .marks-group, .marks-row').forEach(function(el) {
            el.style.border = 'none';
            el.style.background = 'none';
            el.style.padding = '2px';
        });

        var wb = XLSX.utils.table_to_book(clone, { sheet: 'Marks' });

        // Fix percentage cells: SheetJS auto-converts "98.00%" text → 0.98 number.
        // Post-process: any numeric cell whose formatted value contains "%" → force as string.
        var ws = wb.Sheets['Marks'];
        if (ws) {
            Object.keys(ws).forEach(function(addr) {
                if (addr[0] === '!') return;
                var cell = ws[addr];
                if (cell.t === 'n' && cell.w && cell.w.indexOf('%') !== -1) {
                    cell.t = 's';
                    cell.v = cell.w;
                    delete cell.z;
                }
            });
        }

        XLSX.writeFile(wb, filename + '.xlsx');

        // Restore previous view
        setView(prevView);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    setView('all');
});

@if($isSuperAdmin)
var marksHistoryInternshipId = {{ (int) $internship->id }};
var marksHistoryCsrf = '{{ csrf_token() }}';

function cancelAllMarksRows() {
    document.querySelectorAll('#marksHistoryTable tbody tr.editing').forEach(function(tr) {
        cancelMarksRowFor(tr);
    });
}

function startEditMarksRow(btn) {
    var tr = btn.closest('tr');
    cancelAllMarksRows();
    tr.classList.add('editing');
    tr.querySelectorAll('.college-mark-input, .industry-mark-input').forEach(function(input) {
        var viewEl = input.parentElement.querySelector('.mark-val.view-mode');
        if (viewEl) input.value = viewEl.textContent.trim();
    });
    var collegeFb = tr.querySelector('.college-feedback-view');
    var collegeInput = tr.querySelector('.college-feedback-input');
    if (collegeFb && collegeInput) {
        collegeInput.value = collegeFb.classList.contains('empty') ? '' : collegeFb.textContent.trim();
    }
    var companyFb = tr.querySelector('.company-feedback-view');
    var companyInput = tr.querySelector('.company-feedback-input');
    if (companyFb && companyInput) {
        companyInput.value = companyFb.classList.contains('empty') ? '' : companyFb.textContent.trim();
    }
}

function cancelMarksRow(btn) {
    cancelMarksRowFor(btn.closest('tr'));
}

function cancelMarksRowFor(tr) {
    if (!tr) return;
    tr.classList.remove('editing');
}

function saveMarksRow(btn) {
    var tr = btn.closest('tr');
    var studentId = tr.getAttribute('data-student-id');
    if (!studentId) return;

    var collegeMarks = {};
    var industryMarks = {};
    if (currentView === 'all' || currentView === 'college') {
        tr.querySelectorAll('.college-mark-input').forEach(function(input) {
            var max = parseInt(input.getAttribute('data-max') || '0', 10);
            var val = parseInt(input.value || '0', 10);
            if (isNaN(val) || val < 0) val = 0;
            if (val > max) val = max;
            input.value = val;
            collegeMarks[input.getAttribute('data-criteria-id')] = val;
        });
    }
    if (currentView === 'all' || currentView === 'industry') {
        tr.querySelectorAll('.industry-mark-input').forEach(function(input) {
            var max = parseInt(input.getAttribute('data-max') || '0', 10);
            var val = parseInt(input.value || '0', 10);
            if (isNaN(val) || val < 0) val = 0;
            if (val > max) val = max;
            input.value = val;
            industryMarks[input.getAttribute('data-criteria-id')] = val;
        });
    }

    var payload = {
        _token: marksHistoryCsrf,
        internship_id: marksHistoryInternshipId,
        student_id: studentId,
        view: currentView,
        college_marks: collegeMarks,
        industry_marks: industryMarks
    };
    var collegeFbInput = tr.querySelector('.college-feedback-input');
    var companyFbInput = tr.querySelector('.company-feedback-input');
    if (collegeFbInput && (currentView === 'all' || currentView === 'college')) {
        payload.college_feedback = collegeFbInput.value;
    }
    if (companyFbInput && (currentView === 'all' || currentView === 'industry')) {
        payload.company_feedback = companyFbInput.value;
    }

    btn.disabled = true;
    $.ajax({
        url: '{{ route("admin.internship.marks-history-update-row") }}',
        method: 'POST',
        data: payload,
        success: function(res) {
            btn.disabled = false;
            if (!res.success) {
                Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Failed to update marks.' });
                return;
            }
            applyMarksRowData(tr, res.data);
            tr.classList.remove('editing');
            Swal.fire({ icon: 'success', title: 'Updated', text: res.message || 'Marks updated successfully.', timer: 1400, showConfirmButton: false });
        },
        error: function(xhr) {
            btn.disabled = false;
            var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Failed to update marks.';
            Swal.fire({ icon: 'error', title: 'Error', text: msg });
        }
    });
}

function applyMarksRowData(tr, data) {
    if (!data) return;
    Object.keys(data.college_marks || {}).forEach(function(id) {
        var viewEl = tr.querySelector('.col-college .mark-val.view-mode[data-criteria-id="' + id + '"]');
        var inputEl = tr.querySelector('.college-mark-input[data-criteria-id="' + id + '"]');
        if (viewEl) viewEl.textContent = data.college_marks[id];
        if (inputEl) inputEl.value = data.college_marks[id];
    });
    Object.keys(data.industry_marks || {}).forEach(function(id) {
        var viewEl = tr.querySelector('.col-industry .mark-val.view-mode[data-criteria-id="' + id + '"]');
        var inputEl = tr.querySelector('.industry-mark-input[data-criteria-id="' + id + '"]');
        if (viewEl) viewEl.textContent = data.industry_marks[id];
        if (inputEl) inputEl.value = data.industry_marks[id];
    });

    function setFeedback(viewSel, inputSel, text) {
        var viewEl = tr.querySelector(viewSel);
        var inputEl = tr.querySelector(inputSel);
        var value = (text || '').trim();
        if (viewEl) {
            viewEl.textContent = value || 'No feedback';
            viewEl.classList.toggle('empty', !value);
        }
        if (inputEl) inputEl.value = value;
    }
    if (typeof data.college_feedback !== 'undefined') {
        setFeedback('.college-feedback-view', '.college-feedback-input', data.college_feedback);
    }
    if (typeof data.company_feedback !== 'undefined') {
        setFeedback('.company-feedback-view', '.company-feedback-input', data.company_feedback);
    }

    var collegeTotal = tr.querySelector('.college-total-val');
    var collegePct = tr.querySelector('.college-pct-val');
    var collegeGrade = tr.querySelector('.college-grade');
    if (collegeTotal) collegeTotal.textContent = data.college_total + ' / ' + data.college_max_total;
    if (collegePct) collegePct.textContent = data.college_percentage + '%';
    if (collegeGrade) {
        collegeGrade.textContent = data.college_grade;
        collegeGrade.className = 'grade-badge college-grade ' + (data.college_grade_class || '');
    }

    var industryTotal = tr.querySelector('.industry-total-val');
    var industryPct = tr.querySelector('.industry-pct-val');
    var industryGrade = tr.querySelector('.industry-grade');
    if (industryTotal) industryTotal.textContent = data.industry_total + ' / ' + data.industry_max_total;
    if (industryPct) industryPct.textContent = data.industry_percentage + '%';
    if (industryGrade) {
        industryGrade.textContent = data.industry_grade;
        industryGrade.className = 'grade-badge industry-grade ' + (data.industry_grade_class || '');
    }

    var combinedTotal = tr.querySelector('.combined-total-val');
    var combinedPct = tr.querySelector('.combined-pct-val');
    var combinedGrade = tr.querySelector('.combined-grade');
    if (combinedTotal) combinedTotal.textContent = data.combined_total + ' / ' + data.combined_max_total;
    if (combinedPct) combinedPct.textContent = data.combined_percentage + '%';
    if (combinedGrade) {
        combinedGrade.textContent = data.combined_grade;
        combinedGrade.className = 'grade-badge combined-grade ' + (data.combined_grade_class || '');
    }
}
@endif
</script>
@endpush
