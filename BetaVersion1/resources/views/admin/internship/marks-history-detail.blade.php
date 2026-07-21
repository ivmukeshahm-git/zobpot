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
                {{-- <a href="{{ route('admin.internship.export-marks-history', $internship->id) }}" class="export-btn">
                    <i class="bx bx-download"></i> Export Excel
                </a> --}}
            </div>
        </div>
    </div>

    {{-- Status Alert --}}
    <div class="alert alert-success d-flex align-items-center" style="border-radius:10px;">
        <i class="bx bx-check-circle me-2" style="font-size:22px;"></i>
        @if($internship->internship_type == 2)
        <div><strong>Company Marks Submitted!</strong> This is a company-only internship. Feedback has been finalized. This is a read-only view.</div>
        @else
        <div><strong>College Marks Submitted!</strong> All marks and feedback have been finalized. This is a read-only view.</div>
        @endif
    </div>

    {{-- Info Card --}}
    <div class="info-card">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="info-row"><i class="bx bx-briefcase-alt-2"></i><strong>Internship:</strong>&nbsp;{{ $internship->internship_title }}</div>
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
                <tr>
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
                    {{-- Company-only internship: show only company feedback --}}
                    <td style="min-width:200px;">
                        <div class="feedback-box industry {{ $student['company_feedback'] ? '' : 'empty' }}">
                            {{ $student['company_feedback'] ?: 'No feedback' }}
                        </div>
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
                            <div class="marks-row">
                                <span class="crit-label">{{ $c->title }}</span>
                                <span class="mark-val">{{ $student['college_marks'][$c->id] ?? 0 }}</span>
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
                            <div class="marks-row">
                                <span class="crit-label">{{ $c->title }}</span>
                                <span class="mark-val industry">{{ $student['industry_marks'][$c->id] ?? 0 }}</span>
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
                        <div class="feedback-box {{ $student['college_feedback'] ? '' : 'empty' }}">
                            {{ $student['college_feedback'] ?: 'No feedback' }}
                        </div>
                    </td>

                    {{-- Company Feedback --}}
                    <td class="col-industry" style="min-width:160px;">
                        <div class="feedback-box industry {{ $student['company_feedback'] ? '' : 'empty' }}">
                            {{ $student['company_feedback'] ?: 'No feedback' }}
                        </div>
                    </td>

                    {{-- College Total --}}
                    <td class="col-college">
                        <div class="total-val">{{ $student['college_total'] }} / {{ $student['college_max_total'] }}</div>
                    </td>
                    <td class="col-college">
                        <div class="pct-val" style="color:#17a2b8;">{{ $student['college_percentage'] }}%</div>
                    </td>
                    <td class="col-college">
                        <span class="grade-badge {{ $gradeClass((float)$student['college_percentage']) }}">
                            {{ $student['college_grade'] }}
                        </span>
                    </td>

                    {{-- Industry Total --}}
                    <td class="col-industry">
                        <div class="total-val">{{ $student['industry_total'] }} / {{ $student['industry_max_total'] }}</div>
                    </td>
                    <td class="col-industry">
                        <div class="pct-val" style="color:#f26e2c;">{{ $student['industry_percentage'] }}%</div>
                    </td>
                    <td class="col-industry">
                        <span class="grade-badge {{ $gradeClass((float)$student['industry_percentage']) }}">
                            {{ $student['industry_grade'] }}
                        </span>
                    </td>

                    {{-- Combined Total --}}
                    <td class="col-combined">
                        <div class="total-val" style="color:#28a745;">{{ $student['combined_total'] }} / {{ $student['combined_max_total'] }}</div>
                    </td>

                    {{-- Combined Percentage --}}
                    <td class="col-combined">
                        <div class="pct-val pct-combined">{{ $student['combined_percentage'] }}%</div>
                    </td>

                    {{-- Combined Grade --}}
                    <td class="col-combined">
                        <span class="grade-badge {{ $gradeClass((float)$student['combined_percentage']) }}">
                            {{ $student['combined_grade'] }}
                        </span>
                    </td>
                    @endif {{-- end type 1/type 2 --}}
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $internship->internship_type == 2 ? 3 : ($isSuperAdmin ? 12 : 7) }}" class="text-center py-5 text-muted">
                        <i class="bx bx-info-circle" style="font-size:36px;"></i>
                        <p class="mt-2">No students found for this internship.</p>
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
                if (cell.style.display === 'none') cell.remove();
            });
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
</script>
@endpush
