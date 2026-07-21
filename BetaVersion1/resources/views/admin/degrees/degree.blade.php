@extends('admin.layout.layout')

@section('content')
<script>
    page_active_id = "Degrees-Degree";
</script>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Degrees /</span> Degrees
    </h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Degree Management</h5>
            @can('Degrees-Add')
            <button type="button" class="btn btn-primary" onclick="openAddModal()">
                <i class="bx bx-plus"></i> Add Degree
            </button>
            @endcan
        </div>
        <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="statusTabs">
                    <li class="nav-item"><a class="nav-link active" data-status="0" href="#">New Requests</a></li>
                    <li class="nav-item"><a class="nav-link" data-status="1" href="#">Approved</a></li>
                    <li class="nav-item"><a class="nav-link" data-status="2" href="#">Rejected</a></li>
                </ul>
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Degree Level</th>
                            <th>Degree Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<style>
    .btn-approve {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white; border: none; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 13px;
        transition: all 0.3s ease; margin: 0 3px;
    }
    .btn-approve:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(40,167,69,0.3); color: white; }
    .btn-reject {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white; border: none; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 13px;
        transition: all 0.3s ease; margin: 0 3px;
    }
    .btn-reject:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(220,53,69,0.3); color: white; }
</style>
<div class="modal fade" id="formModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Degree</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_id">
                <div class="mb-3">
                    <label for="degree_level_id" class="form-label">Degree Level <span class="text-danger">*</span></label>
                    <select class="form-select" id="degree_level_id">
                        <option value="">Select Degree Level</option>
                        @foreach($degreeLevels as $level)
                            <option value="{{ $level->degree_level_id }}">{{ $level->degree_level_name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="error_degree_level_id"></div>
                </div>
                <div class="mb-3">
                    <label for="degree_name" class="form-label">Degree Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="degree_name" placeholder="Enter degree name">
                    <div class="invalid-feedback" id="error_degree_name"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBtn" onclick="saveData()">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    var table;
    var CSRF = $('meta[name="csrf-token"]').attr('content');
    var currentStatus = 0; // default to New Requests

    $(function () {
        table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.degree.data') }}",
                data: function (d) { d.approve_status = currentStatus; }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'degree_level_name', name: 'degree_level_name' },
                { data: 'degree_name', name: 'degree_name' },
                { data: 'created_at', name: 'created_at', render: function(data) { return data ? data : ''; }},
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Tab click
    
    window.openRejectModal = function(id, name) {
        $('#reject_id').remove();
        var $modal = $('#rejectModal');
        $modal.find('#reject_reason').val('');
        $modal.find('.modal-title').text('Reject: ' + name);
        $modal.find('.modal-body').append('<input type="hidden" id="reject_id" value="' + id + '">');
        $modal.modal('show');
    }

    window.submitReject = function() {
        var id = $('#reject_id').val();
        var reason = $.trim($('#reject_reason').val());
        if (!reason) { $('#reject_reason').addClass('is-invalid'); return; }
        $('#reject_reason').removeClass('is-invalid');
        $.post("{{ route('admin.degree.reject', ':id') }}".replace(':id', id), { reject_reason: reason, _token: CSRF }, function (res) {
            if (res.success) {
                $('#rejectModal').modal('hide');
                table.ajax.reload(null, false);
                Swal.fire({ icon: 'success', title: 'Rejected', text: res.message, timer: 1500, showConfirmButton: false });
            }
        }).fail(function () { Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to reject.' }); });
    }
    
    // Approve modal logic (show majors for the degree and allow selecting majors)
    window.openApproveModal = function(id, name) {
        $.get("{{ route('admin.degree.details', ':id') }}".replace(':id', id), function (res) {
            if (res.success) {
                var deg = res.data;
                $('#approveDegreeModal #approve_degree_name').text(deg.degree_name);
                // left: show degree (auto-approved)
                var $left = $('#approveDegreeModal #approveDegreeBox').empty();
                var badge = '<span class="badge bg-success ms-2">Approved</span>';
                var $item = $('<div class="list-group-item d-flex align-items-center" style="cursor:default"></div>');
                $item.append('<div class="flex-grow-1"><div class="degree-name">' + (deg.degree_name||'') + ' ' + badge + '</div></div>');
                $left.append($item);

                // right: majors boxed
                var $majContainer = $('#approveDegreeModal #approveMajorsList').empty();
                if (deg.majors && deg.majors.length) {
                    var $list = $('<div class="list-group"></div>');
                    deg.majors.forEach(function(m){
                        var checked = (m.approve_status != 2); // default selected unless rejected
                        var mbadge = (m.approve_status == 1) ? '<span class="badge bg-success ms-2">Approved</span>' : (m.approve_status == 2 ? '<span class="badge bg-danger ms-2">Rejected</span>' : '<span class="badge bg-warning text-dark ms-2">Pending</span>');
                        var $mitem = $('<label class="list-group-item d-flex align-items-center" style="cursor:default"></label>');
                        var $mchk = $('<input class="form-check-input major-checkbox me-3" type="checkbox">').prop('checked', checked).attr('data-major-id', m.major_id).data('major-id', m.major_id);
                        if (checked) $mitem.addClass('active');
                        $mitem.append($mchk).append('<div>' + (m.major_name||'') + ' ' + mbadge + '</div>');
                        $list.append($mitem);

                        $mchk.on('change', function () {
                            if ($(this).is(':checked')) { $mitem.addClass('active'); } else { $mitem.removeClass('active'); }
                        });
                    });
                    $majContainer.append($list);
                } else {
                    $majContainer.append('<div class="text-muted">No majors for this degree.</div>');
                }

                $('#approveDegreeModal').data('degree-id', id).modal('show');
            }
        }).fail(function () { Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load details.' }); });
    }

    window.submitDegreeApprove = function() {
        var id = $('#approveDegreeModal').data('degree-id');
        var major_ids = [];
        $('#approveDegreeModal .major-checkbox:checked').each(function(){ major_ids.push($(this).data('major-id')); });
        $.post("{{ route('admin.degree.approve', ':id') }}".replace(':id', id), { major_ids: major_ids, _token: CSRF }, function (res) {
            if (res.success) {
                $('#approveDegreeModal').modal('hide');
                table.ajax.reload(null, false);
                Swal.fire({ icon: 'success', title: 'Approved', text: res.message, timer: 1500, showConfirmButton: false });
            }
        }).fail(function () { Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to approve.' }); });
    }
        $('#statusTabs .nav-link').on('click', function (e) {
            e.preventDefault();
            $('#statusTabs .nav-link').removeClass('active');
            $(this).addClass('active');
            currentStatus = $(this).data('status');
            table.ajax.reload();
        });
    });

    function clearErrors() {
        $('#degree_level_id, #degree_name').removeClass('is-invalid');
    }

    function openAddModal() {
        clearErrors();
        $('#edit_id').val('');
        $('#degree_level_id').val('');
        $('#degree_name').val('');
        $('#modalTitle').text('Add Degree');
        $('#formModal').modal('show');
    }

    function saveData() {
        clearErrors();
        var id      = $('#edit_id').val();
        var levelId = $('#degree_level_id').val();
        var name    = $.trim($('#degree_name').val());
        var valid   = true;

        if (!levelId) {
            $('#degree_level_id').addClass('is-invalid');
            $('#error_degree_level_id').text('Please select a degree level');
            valid = false;
        }

        if (!name) {
            $('#degree_name').addClass('is-invalid');
            $('#error_degree_name').text('Please enter degree name');
            valid = false;
        }
        
        if (!valid) return;

        var url    = id ? "{{ route('admin.degree.update', ':id') }}".replace(':id', id) : "{{ route('admin.degree.store') }}";
        var method = id ? 'PUT' : 'POST';

        $('#saveBtn').prop('disabled', true).text('Saving...');

        $.ajax({
            url: url,
            type: method,
            data: { degree_level_id: levelId, degree_name: name, _token: CSRF },
            dataType: 'json',
            success: function (res) {
                $('#saveBtn').prop('disabled', false).text('Save');
                if (res.success) {
                    $('#formModal').modal('hide');
                    table.ajax.reload(null, false);
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false });
                }
            },
            error: function (xhr) {
                $('#saveBtn').prop('disabled', false).text('Save');
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.degree_level_id) { $('#degree_level_id').addClass('is-invalid'); $('#error_degree_level_id').text(errors.degree_level_id[0]); }
                    if (errors.degree_name)     { $('#degree_name').addClass('is-invalid');     $('#error_degree_name').text(errors.degree_name[0]); }
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!' });
                }
            }
        });
    }

    function editItem(id) {
        clearErrors();
        $.get("{{ route('admin.degree.edit', ':id') }}".replace(':id', id), function (res) {
            if (res.success) {
                $('#edit_id').val(res.data.degree_id);
                $('#degree_level_id').val(res.data.degree_level_id);
                $('#degree_name').val(res.data.degree_name);
                $('#modalTitle').text('Edit Degree');
                $('#formModal').modal('show');
            }
        }).fail(function () {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load data.' });
        });
    }

    function deleteItem(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.degree.destroy', ':id') }}".replace(':id', id),
                    type: 'DELETE',
                    data: { _token: CSRF },
                    dataType: 'json',
                    success: function (res) {
                        if (res.success) {
                            table.ajax.reload(null, false);
                            Swal.fire({ icon: 'success', title: 'Deleted', text: res.message, timer: 2000, showConfirmButton: false });
                        }
                    },
                    error: function () {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete.' });
                    }
                });
            }
        });
    }
</script>
@endpush

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Reject</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Reason <span class="text-danger">*</span></label>
                    <textarea id="reject_reason" class="form-control" rows="3"></textarea>
                    <div class="invalid-feedback">Please enter a reason</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn-reject" onclick="submitReject()">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal (Degree) -->
<div class="modal fade" id="approveDegreeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Degree</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Degree:</label>
                    <div id="approve_degree_name" class="h5"></div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Degree</label>
                        <div id="approveDegreeBox" class="list-group"></div>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Majors</label>
                        <div id="approveMajorsList" style="max-height:320px;overflow:auto"></div>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">Explanation: Select which Majors you want to approve for this Degree. By default most Majors are selected.</small>
                </div>
                <div class="alert alert-info mt-2 mb-0">
                    <strong>Note:</strong> Approving here will also approve the selected Degree along with the checked Major(s).
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-approve" onclick="submitDegreeApprove()">Approve Selected</button>
            </div>
        </div>
    </div>
</div>
