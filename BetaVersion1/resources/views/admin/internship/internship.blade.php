@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "Internship";
</script>

<style>
    .nav-pills-custom .nav-link{
        padding: 12px 12px;
    }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Tab Navigation -->
    
    <div class="row mb-3">
        <div class="col-lg-12" style="text-align:right;">
            @can('Internship-Add')
            <a href="{{ route('admin.internship.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Create New Internship
            </a>
            @endcan
        </div>
    </div>

    <div class="internship-tabs p-1">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <ul class="nav nav-pills nav-pills-custom mb-0" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-new-tab" data-bs-toggle="pill" data-bs-target="#pills-new" 
                            type="button" role="tab" aria-controls="pills-new" aria-selected="true">
                        <i class="bx bx-bell"></i> New Requests
                        <span class="status-badge new" id="newCount">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-approved-tab" data-bs-toggle="pill" data-bs-target="#pills-approved" 
                            type="button" role="tab" aria-controls="pills-approved" aria-selected="false">
                        <i class="bx bx-check"></i> Approved Internships
                        <span class="status-badge" style="background: #d1e7dd; color: #0f5132;" id="approvedCount">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-rejected-tab" data-bs-toggle="pill" data-bs-target="#pills-rejected" 
                            type="button" role="tab" aria-controls="pills-rejected" aria-selected="false">
                        <i class="bx bx-x-circle"></i> Rejected Internships
                        <span class="status-badge" style="background: #f8d7da; color: #842029;" id="rejectedCount">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-processing-tab" data-bs-toggle="pill" data-bs-target="#pills-processing" 
                            type="button" role="tab" aria-controls="pills-processing" aria-selected="false">
                        <i class="bx bx-time"></i> Processing Internships
                        <span class="status-badge processing" id="processingCount">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-complete-tab" data-bs-toggle="pill" data-bs-target="#pills-complete" 
                            type="button" role="tab" aria-controls="pills-complete" aria-selected="false">
                        <i class="bx bx-check-circle"></i> Completed Internships
                        <span class="status-badge complete" id="completeCount">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-college-pending-tab" data-bs-toggle="pill" data-bs-target="#pills-college-pending" 
                            type="button" role="tab" aria-controls="pills-college-pending" aria-selected="false">
                        <i class="bx bx-time"></i> College Pending
                        <span class="status-badge" style="background:#fff3cd;color:#856404;" id="collegePendingCount">0</span>
                    </button>
                </li>
            </ul>
           
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content p-0" id="pills-tabContent">
        <!-- New Requests Tab -->
        <div class="tab-pane fade show active" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab">
            <div class="card">
                <div class="card-header p-4">
                    <h5 class="card-title mb-0"><i class="bx bx-bell"></i> New Internship Requests</h5>
                </div>
                <hr class="my-1">
                <div class="card-body table-responsive p-4">
                    <table id="NewRequestsTable" class="table table-sm table-striped table-hover">
                        <thead class="border-top">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Internship Title</th>
                                <th>Company</th>
                                <th>Duration</th>
                                <th>Created Date</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Openings</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Approved Internships Tab -->
        <div class="tab-pane fade" id="pills-approved" role="tabpanel" aria-labelledby="pills-approved-tab">
            <div class="card">
                <div class="card-header p-4">
                    <h5 class="card-title mb-0"><i class="bx bx-check"></i> Approved Internships</h5>
                </div>
                <hr class="my-1">
                <div class="card-body table-responsive p-4">
                    {{-- Assign bar (visible to users with assign permission) --}}
                    @can('Internship-Edit')
                    <div class="assign-bar mb-3" id="approvedAssignBar" style="display:none; align-items:center; gap:12px;">
                        <div><strong><span id="approvedSelectedCount">0</span></strong> selected</div>
                        <button class="btn btn-sm btn-primary" id="approvedBtnAssign" data-bs-toggle="modal" data-bs-target="#approveAssignModal" disabled>
                            <i class="bx bx-user-plus"></i> Assign To Staff
                        </button>
                    </div>
                    @endcan

                    <table id="ApprovedTable" class="table table-sm table-striped table-hover">
                        <thead class="border-top">
                            <tr>
                                @can('Internship-Edit')
                                <th style="width:40px;"><input type="checkbox" id="selectAllApproved"></th>
                                @endcan
                                <th>Sr. No.</th>
                                <th>Internship Title</th>
                                <th>Company</th>
                                <th>Duration</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Category</th>
                                <th>Openings</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Rejected Internships Tab -->
        <div class="tab-pane fade" id="pills-rejected" role="tabpanel" aria-labelledby="pills-rejected-tab">
            <div class="card">
                <div class="card-header p-4">
                    <h5 class="card-title mb-0"><i class="bx bx-x-circle"></i> Rejected Internships</h5>
                </div>
                <hr class="my-1">
                <div class="card-body table-responsive p-4">
                    <table id="RejectedTable" class="table table-sm table-striped table-hover">
                        <thead class="border-top">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Internship Title</th>
                                <th>Company</th>
                                <th>Duration</th>
                                <th>Rejected Date</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Processing Internships Tab -->
        <div class="tab-pane fade" id="pills-processing" role="tabpanel" aria-labelledby="pills-processing-tab">
            <div class="card">
                <div class="card-header p-4">
                    <h5 class="card-title mb-0"><i class="bx bx-time"></i> Processing Internships</h5>
                </div>
                <hr class="my-1">
                <div class="card-body table-responsive p-4">
                    <table id="ProcessingTable" class="table table-sm table-striped table-hover">
                        <thead class="border-top">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Internship Title</th>
                                <th>Company</th>
                                <th>Duration</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Completed Internships Tab -->
        <div class="tab-pane fade" id="pills-complete" role="tabpanel" aria-labelledby="pills-complete-tab">
            <div class="card">
                <div class="card-header p-4">
                    <h5 class="card-title mb-0"><i class="bx bx-check-circle"></i> Completed Internships</h5>
                </div>
                <hr class="my-1">
                <div class="card-body table-responsive p-4">
                    <table id="CompletedTable" class="table table-sm table-striped table-hover">
                        <thead class="border-top">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Internship Title</th>
                                <th>Company</th>
                                <th>Duration</th>
                                <th>Completion Date</th>
                                <th>Category</th>
                                <th>Openings</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- College Pending Tab -->
        <div class="tab-pane fade" id="pills-college-pending" role="tabpanel" aria-labelledby="pills-college-pending-tab">
            <div class="card">
                <div class="card-header p-4">
                    <h5 class="card-title mb-0"><i class="bx bx-time"></i> College Pending Internships</h5>
                </div>
                <hr class="my-1">
                <div class="card-body table-responsive p-4">
                    <table id="CollegePendingTable" class="table table-sm table-striped table-hover">
                        <thead class="border-top">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Internship Title</th>
                                <th>Company</th>
                                <th>Duration</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@push('script')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Setup CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Check if we need to open modal after update
        @if(session('openModal'))
            const internshipId = {{ session('openModal') }};
            // Clear session storage
            sessionStorage.removeItem('returnToModal');
            // Open modal after a short delay to ensure page is fully loaded
            setTimeout(function() {
                if (typeof openAcceptModal === 'function') {
                    openAcceptModal(internshipId);
                }
            }, 500);
        @endif

        // Initialize DataTables for New Requests with AJAX
        const newRequestsTable = $('#NewRequestsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.internship.new-requests-data") }}',
                type: 'POST',
                error: function(xhr, error, code) {
                    console.log('Ajax Error:', xhr.responseText);
                    alert('Error loading data: ' + xhr.status + ' ' + xhr.statusText);
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'internship_title', name: 'internship_title' },
                { data: 'company_name', name: 'company_name' },
                { data: 'duration', name: 'duration' },
                { data: 'formatted_date', name: 'created_at' },
                { data: 'category_name', name: 'category_name' },
                { data: 'location', name: 'location' },
                { data: 'openings', name: 'openings' },
                { data: 'status_badge', name: 'approve_status', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[4, 'desc']],
            pageLength: 10
        });

        // Initialize DataTables for Approved Internships
        const approvedTable = $('#ApprovedTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.internship.approved-data") }}',
                type: 'POST',
                error: function(xhr, error, code) {
                    console.log('Ajax Error:', xhr.responseText);
                }
            },
            columns: [
                { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'internship_title', name: 'internship_title' },
                { data: 'company_name', name: 'company_name' },
                { data: 'duration', name: 'duration' },
                { data: 'formatted_start_date', name: 'start_date' },
                { data: 'formatted_end_date', name: 'end_date' },
                { data: 'category_name', name: 'category_name' },
                { data: 'openings', name: 'openings' },
                { data: 'status_badge', name: 'approve_status', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[4, 'asc']],
            pageLength: 10
        });

        // Approved: select logic
        @can('Internship-Edit')
        // Toggle select all
        $(document).on('change', '#selectAllApproved', function(){
            var checked = $(this).prop('checked');
            $('.internship-checkbox').prop('checked', checked).trigger('change');
        });

        // When any checkbox toggles, update count and button
        $(document).on('change', '.internship-checkbox', function(){
            var count = $('.internship-checkbox:checked').length;
            $('#approvedSelectedCount').text(count);
            $('#approvedAssignBar').toggle(count > 0);
            $('#approvedBtnAssign').prop('disabled', count === 0);
            // uncheck select-all if not all checked
            if ($('.internship-checkbox').length > 0 && $('.internship-checkbox:checked').length !== $('.internship-checkbox').length) {
                $('#selectAllApproved').prop('checked', false);
            }
            if ($('.internship-checkbox').length > 0 && $('.internship-checkbox:checked').length === $('.internship-checkbox').length) {
                $('#selectAllApproved').prop('checked', true);
            }
        });

        // Load staff list into modal when opened
        $('#approveAssignModal').on('show.bs.modal', function(){
            var $sel = $('#assignStaffSelect');
            $sel.html('<option>Loading...</option>');
            $.get('{{ route("admin.internship.staff-list") }}', function(res){
                if (res.success) {
                    $sel.empty().append('<option value="">-- Select Staff --</option>');
                    res.data.forEach(function(s){
                        var label = s.name;
                        if (res.type === 'college' && s.college_name) {
                            label += ' ('+s.college_name+')';
                        } else if (res.type === 'admin' && s.email) {
                            label += ' - '+s.email;
                        }
                        $sel.append('<option value="'+s.id+'">'+label+'</option>');
                    });
                } else {
                    $sel.html('<option value="">No staff found</option>');
                }
            }).fail(function(){
                $sel.html('<option value="">Error loading</option>');
            });
        });

        // Confirm bulk assign
        $('#confirmApprovedAssign').on('click', function(){
            var staffId = $('#assignStaffSelect').val();
            if (!staffId) { alert('Please select a staff member'); return; }
            var ids = [];
            $('.internship-checkbox:checked').each(function(){ ids.push($(this).val()); });
            if (ids.length === 0) { alert('No internships selected'); return; }
            var $btn = $(this).prop('disabled', true).text('Assigning...');
            $.ajax({
                url: '{{ route("admin.internship.assign-staff") }}',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', internship_ids: ids, staff_id: staffId },
                success: function(res){
                    alert(res.message || 'Assigned successfully');
                    // reload tables
                    approvedTable.ajax.reload();
                    $('#approveAssignModal').modal('hide');
                    $('#selectAllApproved').prop('checked', false);
                },
                error: function(xhr){
                    var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Server error';
                    alert(msg);
                },
                complete: function(){ $btn.prop('disabled', false).text('Assign'); }
            });
        });
        @endcan

        // Initialize DataTables for Rejected Internships
        const rejectedTable = $('#RejectedTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.internship.rejected-data") }}',
                type: 'POST',
                error: function(xhr, error, code) {
                    console.log('Ajax Error:', xhr.responseText);
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'internship_title', name: 'internship_title' },
                { data: 'company_name', name: 'company_name' },
                { data: 'duration', name: 'duration' },
                { data: 'formatted_date', name: 'updated_at' },
                { data: 'category_name', name: 'category_name' },
                { data: 'location', name: 'location' },
                { data: 'rejection_reason', name: 'rejection_reason' },
                { data: 'status_badge', name: 'approve_status', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[4, 'desc']],
            pageLength: 10
        });

        // Initialize DataTables for Processing Internships with AJAX
        const processingTable = $('#ProcessingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.internship.processing-data") }}',
                type: 'POST',
                error: function(xhr, error, code) {
                    console.log('Ajax Error:', xhr.responseText);
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'internship_title', name: 'internship_title' },
                { data: 'company_name', name: 'company_name' },
                { data: 'duration', name: 'duration' },
                { data: 'formatted_start_date', name: 'start_date' },
                { data: 'formatted_end_date', name: 'end_date' },
                { data: 'category_name', name: 'category_name' },
                { data: 'status_badge', name: 'approve_status', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[4, 'asc']],
            pageLength: 10
        });

        // Initialize DataTables for College Pending Internships with AJAX
        const collegePendingTable = $('#CollegePendingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.internship.college-pending-data") }}',
                type: 'POST',
                error: function(xhr, error, code) {
                    console.log('Ajax Error:', xhr.responseText);
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'internship_title', name: 'internship_title' },
                { data: 'company_name', name: 'company_name' },
                { data: 'duration', name: 'duration' },
                { data: 'formatted_start_date', name: 'start_date' },
                { data: 'formatted_end_date', name: 'end_date' },
                { data: 'status_badge', name: 'status_badge', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[4, 'asc']],
            pageLength: 10
        });

        // Initialize DataTables for Completed Internships with AJAX
        const completedTable = $('#CompletedTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.internship.completed-data") }}',
                type: 'POST',
                error: function(xhr, error, code) {
                    console.log('Ajax Error:', xhr.responseText);
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'internship_title', name: 'internship_title' },
                { data: 'company_name', name: 'company_name' },
                { data: 'duration', name: 'duration' },
                { data: 'formatted_end_date', name: 'end_date' },
                { data: 'category_name', name: 'category_name' },
                { data: 'openings', name: 'openings' },
                { data: 'status_badge', name: 'complete_status', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[4, 'desc']],
            pageLength: 10
        });

        // Update badge counts
        updateCounts();

        // Set min date for date inputs
        const today = new Date().toISOString().split('T')[0];
        $('#lastRegisterDate').attr('min', today);
        $('#startDate').attr('min', today);
        $('#endDate').attr('min', today);

        // Update end date min when start date changes
        $('#startDate').on('change', function() {
            $('#endDate').attr('min', this.value);
        });
    });

    // Update badge counts
    function updateCounts() {
        $.ajax({
            url: '{{ route("admin.internship.statistics") }}',
            method: 'GET',
            success: function(response) {
                $('#newCount').text(response.new_count || 0);
                $('#approvedCount').text(response.approved_count || 0);
                $('#rejectedCount').text(response.rejected_count || 0);
                $('#processingCount').text(response.processing_count || 0);
                $('#completeCount').text(response.complete_count || 0);
                $('#collegePendingCount').text(response.college_pending_count || 0);
            }
        });
    }

    // Delete Internship with SweetAlert
    function deleteInternship(internshipId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("admin/internship") }}/' + internshipId,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message || 'Internship deleted successfully!',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            // Reload all tables
                            if ($.fn.DataTable.isDataTable('#NewRequestsTable')) {
                                $('#NewRequestsTable').DataTable().ajax.reload();
                            }
                            if ($.fn.DataTable.isDataTable('#ProcessingTable')) {
                                $('#ProcessingTable').DataTable().ajax.reload();
                            }
                            if ($.fn.DataTable.isDataTable('#CompletedTable')) {
                                $('#CompletedTable').DataTable().ajax.reload();
                            }
                            updateCounts();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to delete internship'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Delete Error Details:', {
                            status: xhr.status,
                            statusText: xhr.statusText,
                            responseText: xhr.responseText,
                            error: error
                        });
                        
                        let errorMessage = 'Failed to delete internship';
                        
                        // Try to parse error response
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                errorMessage = response.message || errorMessage;
                            } catch (e) {
                                // If not JSON, check for common HTTP errors
                                if (xhr.status === 404) {
                                    errorMessage = 'Internship not found';
                                } else if (xhr.status === 403) {
                                    errorMessage = 'You do not have permission to delete this internship';
                                } else if (xhr.status === 500) {
                                    errorMessage = 'Server error occurred while deleting internship';
                                } else if (xhr.status === 419) {
                                    errorMessage = 'Session expired. Please refresh the page and try again';
                                } else {
                                    errorMessage = 'Error: ' + xhr.status + ' - ' + xhr.statusText;
                                }
                            }
                        } else if (error) {
                            errorMessage = error;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage
                        });
                    }
                });
            }
        });
    }

  

 

    // View Internship Details
    function viewInternshipDetails(internshipId) {
        // Implement view details functionality
        alert('View details for internship ID: ' + internshipId);
    }
</script>

<!-- Approve Assign Modal -->
@can('Internship-Edit')
<div class="modal fade" id="approveAssignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Selected Internships to Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Select Staff</label>
                    <select id="assignStaffSelect" class="form-select"></select>
                </div>
                <p class="text-muted">This will assign all current applications for the selected internships to the chosen staff member.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmApprovedAssign">Assign</button>
            </div>
        </div>
    </div>
</div>
@endcan
@endpush
