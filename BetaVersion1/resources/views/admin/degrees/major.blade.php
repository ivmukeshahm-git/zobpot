@extends('admin.layout.layout')

@section('content')
<script>
    page_active_id = "Degrees-Major";
</script>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Degrees /</span> Majors
    </h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Major Management</h5>
            @can('Major-Add')
            <button type="button" class="btn btn-primary" onclick="openAddModal()">
                <i class="bx bx-plus"></i> Add Major
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
                            <th>Degree</th>
                            <th>Major Name</th>
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
            <!-- Approve Modal (Major) -->
            <div class="modal fade" id="approveMajorModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header"><h5 class="modal-title">Approve Major</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body">
                            <p><strong>Major:</strong> <span id="approve_major_name"></span></p>
                            <p class="text-muted">Approve this Major.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn-approve" onclick="submitMajorApprove()">Approve</button>
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
                <h5 class="modal-title" id="modalTitle">Add Major</h5>
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
                    <label for="degree_id" class="form-label">Degree <span class="text-danger">*</span></label>
                    <select class="form-select" id="degree_id" disabled>
                        <option value="">Select Degree Level First</option>
                    </select>
                    <div class="invalid-feedback" id="error_degree_id"></div>
                </div>
                <div class="mb-3">
                    <label for="major_name" class="form-label">Major Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="major_name" placeholder="Enter major name">
                    <div class="invalid-feedback" id="error_major_name"></div>
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
                url: "{{ route('admin.major.data') }}",
                data: function (d) { d.approve_status = currentStatus; }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'degree_level_name', name: 'degree_level_name' },
                { data: 'degree_name', name: 'degree_name' },
                { data: 'major_name', name: 'major_name' },
                { data: 'created_at', name: 'created_at', render: function(data) { return data ? data : ''; } },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Tab click
        $('#statusTabs .nav-link').on('click', function (e) {
            e.preventDefault();
            $('#statusTabs .nav-link').removeClass('active');
            $(this).addClass('active');
            currentStatus = $(this).data('status');
            table.ajax.reload();
        });

        // Cascade: load degrees when degree level changes
        $('#degree_level_id').on('change', function () {
            var levelId = $(this).val();
            var $degree = $('#degree_id');

            if (!levelId) {
                $degree.prop('disabled', true).html('<option value="">Select Degree Level First</option>');
                return;
            }

            $.ajax({
                url: "{{ route('admin.degree.by-level') }}",
                type: 'POST',
                data: { degree_level_id: levelId, _token: CSRF },
                dataType: 'json',
                success: function (res) {
                    $degree.prop('disabled', false).html('<option value="">Select Degree</option>');
                    if (res.success && res.data.length) {
                        $.each(res.data, function (i, d) {
                            $degree.append('<option value="' + d.degree_id + '">' + d.degree_name + '</option>');
                        });
                    } else {
                        $degree.html('<option value="">No degrees available</option>');
                    }
                }
            });
        });
    });

    function clearErrors() {
        $('#degree_level_id, #degree_id, #major_name').removeClass('is-invalid');
    }

    function openAddModal() {
        clearErrors();
        $('#edit_id').val('');
        $('#degree_level_id').val('');
        $('#degree_id').prop('disabled', true).html('<option value="">Select Degree Level First</option>');
        $('#major_name').val('');
        $('#modalTitle').text('Add Major');
        $('#formModal').modal('show');
    }

    function saveData() {
        clearErrors();
        var id       = $('#edit_id').val();
        var degreeId = $('#degree_id').val();
        var name     = $.trim($('#major_name').val());
        var valid    = true;

        if (!$('#degree_level_id').val()) {
            $('#degree_level_id').addClass('is-invalid');
            $('#error_degree_level_id').text('Please select a degree level');
            valid = false;
        }
        if (!degreeId) {
            $('#degree_id').addClass('is-invalid');
            $('#error_degree_id').text('Please select a degree');
            valid = false;
        }
        if (!name) {
            $('#major_name').addClass('is-invalid');
            $('#error_major_name').text('Please enter major name');
            valid = false;
        }
        if (!valid) return;

        var url    = id ? "{{ route('admin.major.update', ':id') }}".replace(':id', id) : "{{ route('admin.major.store') }}";
        var method = id ? 'PUT' : 'POST';

        $('#saveBtn').prop('disabled', true).text('Saving...');

        $.ajax({
            url: url,
            type: method,
            data: { degree_id: degreeId, major_name: name, _token: CSRF },
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
                    if (errors.degree_id)  { $('#degree_id').addClass('is-invalid');  $('#error_degree_id').text(errors.degree_id[0]); }
                    if (errors.major_name) { $('#major_name').addClass('is-invalid'); $('#error_major_name').text(errors.major_name[0]); }
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!' });
                }
            }
        });
    }

    function editItem(id) {
        clearErrors();
        $.get("{{ route('admin.major.edit', ':id') }}".replace(':id', id), function (res) {
            if (res.success) {
                $('#edit_id').val(res.data.major_id);
                $('#major_name').val(res.data.major_name);

                // Set degree level and load degrees
                $('#degree_level_id').val(res.data.degree.degree_level_id);

                // Load degrees for the level, then set selected degree
                $.ajax({
                    url: "{{ route('admin.degree.by-level') }}",
                    type: 'POST',
                    data: { degree_level_id: res.data.degree.degree_level_id, _token: CSRF },
                    dataType: 'json',
                    success: function (degRes) {
                        var $degree = $('#degree_id');
                        $degree.prop('disabled', false).html('<option value="">Select Degree</option>');
                        if (degRes.success && degRes.data.length) {
                            $.each(degRes.data, function (i, d) {
                                $degree.append('<option value="' + d.degree_id + '">' + d.degree_name + '</option>');
                            });
                        }
                        $degree.val(res.data.degree_id);
                    }
                });

                $('#modalTitle').text('Edit Major');
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
                    url: "{{ route('admin.major.destroy', ':id') }}".replace(':id', id),
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

    window.openApproveModal = function(id, name) {
        $('#approveMajorModal #approve_major_name').text(name);
        $('#approveMajorModal').data('major-id', id).modal('show');
    }

    window.submitMajorApprove = function() {
        var id = $('#approveMajorModal').data('major-id');
        $.post("{{ route('admin.major.approve', ':id') }}".replace(':id', id), { _token: CSRF }, function (res) {
            if (res.success) {
                $('#approveMajorModal').modal('hide');
                table.ajax.reload(null, false);
                Swal.fire({ icon: 'success', title: 'Approved', text: res.message, timer: 1500, showConfirmButton: false });
            }
        }).fail(function () { Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to approve.' }); });
    }

    function openRejectModal(id, name) {
        $('#reject_id').remove();
        var $modal = $('#rejectModal');
        $modal.find('#reject_reason').val('');
        $modal.find('.modal-title').text('Reject: ' + name);
        $modal.find('.modal-body').append('<input type="hidden" id="reject_id" value="' + id + '">');
        $modal.modal('show');
    }

    function submitReject() {
        var id = $('#reject_id').val();
        var reason = $.trim($('#reject_reason').val());
        if (!reason) { $('#reject_reason').addClass('is-invalid'); return; }
        $('#reject_reason').removeClass('is-invalid');
        $.post("{{ route('admin.major.reject', ':id') }}".replace(':id', id), { reject_reason: reason, _token: CSRF }, function (res) {
            if (res.success) {
                $('#rejectModal').modal('hide');
                table.ajax.reload(null, false);
                Swal.fire({ icon: 'success', title: 'Rejected', text: res.message, timer: 1500, showConfirmButton: false });
            }
        }).fail(function () { Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to reject.' }); });
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
