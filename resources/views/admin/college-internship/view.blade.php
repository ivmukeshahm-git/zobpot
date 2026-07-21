@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "CollegeInternship";
</script>

<style>
    /* Reuse existing internship view styles */
    .internship-view-header {
        background: #242a62; border-radius: 12px; padding: 30px; margin-bottom: 30px;
        color: white; box-shadow: 0 4px 15px rgba(36, 42, 98, 0.3);
    }
    .internship-view-header h4 { margin: 0; font-size: 28px; font-weight: 700; }
    .internship-view-header p { margin: 8px 0 0 0; opacity: 0.9; }

    .nav-tabs-internship {
        background: #fff; border-radius: 12px 12px 0 0; padding: 15px 20px 0 20px;
        border-bottom: 3px solid #242a62; box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    .nav-tabs-internship .nav-link {
        color: #666; border: none; border-bottom: 3px solid transparent;
        border-radius: 0; padding: 12px 24px; font-weight: 600; font-size: 14px;
        transition: all 0.3s ease; margin-bottom: -3px;
    }
    .nav-tabs-internship .nav-link:hover { color: #242a62; background: #fff5f0; }
    .nav-tabs-internship .nav-link.active {
        color: #242a62; background: transparent; border-bottom-color: #242a62;
    }
    .tab-content-card {
        background: #fff; border-radius: 0 0 12px 12px; padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    .detail-row-view {
        display: flex; justify-content: space-between; padding: 12px 0;
        border-bottom: 1px dashed #dee2e6;
    }
    .detail-row-view:last-child { border-bottom: none; }
    .detail-label-view { font-weight: 600; color: #495057; font-size: 14px; min-width: 200px; }
    .detail-value-view { color: #212529; font-size: 14px; flex: 1; }
    .section-card {
        background: #f8f9fa; border-radius: 10px; padding: 20px; margin-bottom: 20px;
        border-left: 4px solid #242a62;
    }
    .section-card h6 { color: #242a62; font-weight: 700; font-size: 16px; margin-bottom: 15px; }

    /* Assign bar */
    .assign-bar {
        background: #f8f9fa; border-radius: 10px; padding: 15px 20px;
        display: flex; align-items: center; gap: 15px; margin-bottom: 20px;
        border: 1px solid #e9ecef;
    }
    .assign-bar .selected-count { font-weight: 700; color: #242a62; font-size: 14px; min-width: 140px; }

    /* Modal */
    .modal-header-assign {
        background: linear-gradient(135deg, #242a62 0%, #f26e2c 100%);
        color: white; padding: 20px 30px;
    }
    .modal-header-assign h5 { margin: 0; font-size: 20px; font-weight: 700; color: #fff; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    @php
        // Ensure $isStaff is accurate even if the controller didn't set it
        $isStaff = isset($isStaff) ? $isStaff : (auth()->guard('college_staff')->check());
    @endphp
    {{-- Header --}}
    <div class="internship-view-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 style="color: #fff;">
                    <i class="bx bx-briefcase-alt-2"></i> {{ $internship->internship_title }}
                </h4>
                <p>{{ $internship->company ? $internship->company->name : 'N/A' }} &bull; {{ $internship->duration }} &bull; {{ $internship->mode }} Mode</p>
            </div>
            <a href="{{ route('admin.college.dashboard') }}" class="btn btn-light">
                <i class="bx bx-arrow-back"></i> Back to Dashboard
            </a>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <ul class="nav nav-tabs nav-tabs-internship" id="collegeViewTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="ci-details-tab" data-bs-toggle="tab"
                data-bs-target="#ci-details" type="button" role="tab">
                <i class="bx bx-info-circle"></i> &nbsp;Internship Details
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ci-students-tab" data-bs-toggle="tab"
                data-bs-target="#ci-students" type="button" role="tab">
                <i class="bx bx-user"></i> &nbsp;Applied Students
            </button>
        </li>
    </ul>

    {{-- Tab Content --}}
    <div class="tab-content tab-content-card" id="collegeViewTabContent">

        {{-- ═══════  TAB 1 – Internship Details  ═══════ --}}
        <div class="tab-pane fade show active" id="ci-details" role="tabpanel">
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
                    <span class="detail-value-view">{{ $internship->company ? $internship->company->name : 'N/A' }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Category:</span>
                    <span class="detail-value-view">{{ $internship->jobCategory ? $internship->jobCategory->category_nm : 'N/A' }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Mode:</span>
                    <span class="detail-value-view">{{ $internship->mode }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Location:</span>
                    <span class="detail-value-view">{{ $internship->location ?? 'N/A' }}</span>
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
                    <span class="detail-value-view">{{ $internship->start_date ? $internship->start_date->format('d M Y') : 'N/A' }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">End Date:</span>
                    <span class="detail-value-view">{{ $internship->end_date ? $internship->end_date->format('d M Y') : 'N/A' }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Batch Days:</span>
                    <span class="detail-value-view">
                        @if($internship->batch_days && is_array($internship->batch_days))
                            {{ implode(', ', array_keys($internship->batch_days)) }}
                        @else N/A @endif
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
                    <span class="detail-value-view">₹{{ number_format($internship->registration_fees, 2) }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">GST ({{ $internship->gst_percentage }}%):</span>
                    <span class="detail-value-view">₹{{ number_format($internship->gst_amount, 2) }}</span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Total Fee:</span>
                    <span class="detail-value-view"><strong>₹{{ number_format($internship->final_amount, 2) }}</strong></span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Openings:</span>
                    <span class="detail-value-view">{{ $internship->openings }} Positions</span>
                </div>
            </div>

            @php
                $skillsArr = [];
                if(!empty($internship->skills)) {
                    $decoded = json_decode($internship->skills, true);
                    $skillsArr = is_array($decoded) ? $decoded : array_filter(array_map('trim', explode(',', $internship->skills)));
                }
                $criteriaArr = [];
                if(!empty($internship->eligibility_criteria)) {
                    $decoded2 = json_decode($internship->eligibility_criteria, true);
                    $criteriaArr = is_array($decoded2) ? $decoded2 : array_filter(array_map('trim', explode(',', $internship->eligibility_criteria)));
                }
            @endphp

            <div class="section-card">
                <h6><i class="bx bx-cog"></i> Skills & Requirements</h6>
                <div class="detail-row-view">
                    <span class="detail-label-view">Required Skills:</span>
                    <span class="detail-value-view">
                        @if(!empty($skillsArr))
                            @foreach($skillsArr as $skill)
                                <span class="badge bg-light text-dark me-1">{{ trim($skill, " \"'") }}</span>
                            @endforeach
                        @else N/A @endif
                    </span>
                </div>
                <div class="detail-row-view">
                    <span class="detail-label-view">Eligibility:</span>
                    <span class="detail-value-view">
                        @if(!empty($criteriaArr))
                            @foreach($criteriaArr as $c)
                                <span class="badge bg-light text-dark me-1">{{ trim($c, " \"'") }}</span>
                            @endforeach
                        @else N/A @endif
                    </span>
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-detail"></i> Description</h6>
                <div style="padding: 15px; background: white; border-radius: 8px; border: 1px solid #e9ecef;">
                    {!! $internship->internship_description ?? '<p class="text-muted">No description</p>' !!}
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-target-lock"></i> Objective</h6>
                <div style="padding: 15px; background: white; border-radius: 8px; border: 1px solid #e9ecef;">
                    {!! $internship->internship_objective ?? '<p class="text-muted">No objective defined</p>' !!}
                </div>
            </div>

            <div class="section-card">
                <h6><i class="bx bx-trophy"></i> Outcome</h6>
                <div style="padding: 15px; background: white; border-radius: 8px; border: 1px solid #e9ecef;">
                    {!! $internship->internship_outcome ?? '<p class="text-muted">No outcome defined</p>' !!}
                </div>
            </div>
        </div> {{-- End details tab --}}

        {{-- ═══════  TAB 2 – Applied Students  ═══════ --}}
        <div class="tab-pane fade" id="ci-students" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 style="color: #242a62; font-weight: 700; margin: 0;">
                    <i class="bx bx-user"></i> Applied Students
                </h5>
            </div>

            {{-- Assign bar (visible only for college, not staff) --}}
            @if(!$isStaff)
            <div class="assign-bar" id="assignBar">
                <span class="selected-count"><span id="selectedCount">0</span> student(s) selected</span>
                <button type="button" class="btn btn-sm btn-primary" id="btnAssignStaff" disabled
                    data-bs-toggle="modal" data-bs-target="#assignStaffModal">
                    <i class="bx bx-user-plus"></i> Assign To Staff
                </button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover" id="appliedStudentsTable" style="width:100%">
                    <thead >
                        <tr>
                            @if(!$isStaff)
                            <th style="width:40px;">
                                <input type="checkbox" id="selectAllStudents" title="Select All">
                            </th>
                            @endif
                            <th>Sr. No</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>University Name</th>
                            <th>College Name</th>
                            <th>Applied On</th>
                            <th>Assigned To</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div> {{-- End students tab --}}
    </div>
</div>

{{-- ═══════  Assign Staff Modal  ═══════ --}}
@if(!$isStaff)
<div class="modal fade" id="assignStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; overflow:hidden; border:none;">
            <div class="modal-header-assign">
                <h5><i class="bx bx-user-plus"></i> Assign Staff</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding:30px;">
                <div class="mb-3">
                    <label class="form-label" style="font-weight:600;">Select Staff Member</label>
                    <select class="form-select" id="staffSelect">
                        <option value="">-- Select Staff --</option>
                        @foreach($staffList as $staff)
                            <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="text-muted" style="font-size:13px;">
                    Selected students will be assigned to the chosen staff member.
                </p>
            </div>
            <div class="modal-footer" style="border-top:1px solid #e9ecef; padding:15px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAssignStaff">
                    <i class="bx bx-check"></i> Assign
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('script')
<script>
$(function(){
    var internshipId = {{ $internship->id }};
    var isStaff = {{ $isStaff ? 'true' : 'false' }};

    if (window.location.hash === '#ci-students') {
        var studentsTab = document.getElementById('ci-students-tab');
        if (studentsTab) {
            (new bootstrap.Tab(studentsTab)).show();
        }
    }

    // Applied Students DataTable
    var studentsTable = $('#appliedStudentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.college-internship.applied-students') }}",
            type: 'POST',
            data: { _token: '{{ csrf_token() }}', internship_id: internshipId }
        },
        columns: [
            @if(!$isStaff)
            { data: 'checkbox', orderable: false, searchable: false, className: 'text-center' },
            @endif
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'student_name' },
            { data: 'email' },
            { data: 'phone' },
            { data: 'university_name' },
            { data: 'college_name' },
            { data: 'applied_date' },
            { data: 'assigned_to', orderable: false },
            { data: 'action', orderable: false, searchable: false }
        ],
        order: [[isStaff ? 1 : 2, 'asc']],
        language: { emptyTable: "No students found for this internship." }
    });

    // Lazy-load on tab switch
    $('button[data-bs-target="#ci-students"]').on('shown.bs.tab', function(){
        studentsTable.ajax.reload();
    });

    @if(!$isStaff)
    // ── Select All ──
    $('#selectAllStudents').on('change', function(){
        var checked = $(this).prop('checked');
        $('.student-checkbox').prop('checked', checked);
        updateSelectedCount();
    });

    $(document).on('change', '.student-checkbox', function(){
        updateSelectedCount();
        // Uncheck "select all" if any unchecked
        if (!$(this).prop('checked')) {
            $('#selectAllStudents').prop('checked', false);
        }
        if ($('.student-checkbox:checked').length === $('.student-checkbox').length && $('.student-checkbox').length > 0) {
            $('#selectAllStudents').prop('checked', true);
        }
    });

    function updateSelectedCount(){
        var count = $('.student-checkbox:checked').length;
        $('#selectedCount').text(count);
        $('#btnAssignStaff').prop('disabled', count === 0);
    }

    // ── Assign Staff ──
    $('#confirmAssignStaff').on('click', function(){
        var staffId = $('#staffSelect').val();
        if (!staffId) {
            alert('Please select a staff member.');
            return;
        }

        var applicationIds = [];
        $('.student-checkbox:checked').each(function(){
            applicationIds.push($(this).val());
        });
        if (applicationIds.length === 0) {
            alert('Please select at least one student.');
            return;
        }

        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin"></i> Assigning...');

        $.ajax({
            url: "{{ route('admin.college-internship.assign-staff') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                application_ids: applicationIds,
                staff_id: staffId
            },
            success: function(res){
                if (res.success) {
                    $('#assignStaffModal').modal('hide');
                    studentsTable.ajax.reload();
                    updateSelectedCount();
                    $('#selectAllStudents').prop('checked', false);
                    alert(res.message);
                } else {
                    alert(res.message || 'Something went wrong.');
                }
            },
            error: function(xhr){
                var msg = xhr.responseJSON ? xhr.responseJSON.message : 'Server error.';
                alert(msg);
            },
            complete: function(){
                $btn.prop('disabled', false).html('<i class="bx bx-check"></i> Assign');
            }
        });
    });
    @endif
});
</script>
@endpush
