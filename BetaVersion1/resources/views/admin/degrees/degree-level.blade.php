@extends('admin.layout.layout')

@section('content')
<script>
    page_active_id = "Degrees-DegreeLevel";
</script>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Degrees /</span> Degree Levels
    </h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Degree Level Management</h5>
            @can('Degree_Level-Add')
            <button type="button" class="btn btn-primary" onclick="openAddModal()">
                <i class="bx bx-plus"></i> Add Degree Level
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
                            <th>Degree Level Name</th>
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

<style>
    /* Approve modal styles */
    #approveModal .approve-list .list-group-item { padding: .75rem 1rem; }
    #approveModal .degree-name { font-weight: 600; }
    #approveModal .majors-list .form-check { margin-bottom: .5rem; }
    #approveModal .list-group-item { border-radius: .5rem; }
    #approveModal .list-group-item.active { background-color: #e9e7ff; color: #000; }
    #approveModal .badge-status { font-size: 0.75rem; }
    /* Approve/Reject button styles (match university UI) */
    .btn-approve {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        margin: 0 3px;
    }
    .btn-approve:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(40,167,69,0.3); color: white; }
    .btn-reject {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        margin: 0 3px;
    }
    .btn-reject:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(220,53,69,0.3); color: white; }
</style>

<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Degree Level</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_id">
                <div class="mb-3">
                    <label for="degree_level_name" class="form-label">Degree Level Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="degree_level_name" placeholder="Enter degree level name">
                    <div class="invalid-feedback" id="error_degree_level_name"></div>
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
    var currentStatus = 0; // default to 'New Requests' on page load

    $(function () {
        table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.degree-level.data') }}",
                data: function (d) { d.approve_status = currentStatus; }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'degree_level_name', name: 'degree_level_name' },
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
    });

    function openAddModal() {
        $('#edit_id').val('');
        $('#degree_level_name').val('').removeClass('is-invalid');
        $('#modalTitle').text('Add Degree Level');
        $('#formModal').modal('show');
    }

    function saveData() {
        var id   = $('#edit_id').val();
        var name = $.trim($('#degree_level_name').val());

        if (!name) {
            $('#degree_level_name').addClass('is-invalid');
            $('#error_degree_level_name').text('Please enter degree level name');
            return;
        }
        $('#degree_level_name').removeClass('is-invalid');

        var url    = id ? "{{ route('admin.degree-level.update', ':id') }}".replace(':id', id) : "{{ route('admin.degree-level.store') }}";
        var method = id ? 'PUT' : 'POST';

        $('#saveBtn').prop('disabled', true).text('Saving...');

        $.ajax({
            url: url,
            type: method,
            data: { degree_level_name: name, _token: CSRF },
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
                if (xhr.status === 422 && xhr.responseJSON) {
                    var errors = xhr.responseJSON.errors || {};
                    if (errors.degree_level_name) {
                        $('#degree_level_name').addClass('is-invalid');
                        $('#error_degree_level_name').text(errors.degree_level_name[0]);
                    } else if (xhr.responseJSON.message) {
                        Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON.message });
                    }
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong!' });
                }
            }
        });
    }

    function editItem(id) {
        $.get("{{ route('admin.degree-level.edit', ':id') }}".replace(':id', id), function (res) {
            if (res.success) {
                $('#edit_id').val(res.data.degree_level_id);
                $('#degree_level_name').val(res.data.degree_level_name).removeClass('is-invalid');
                $('#modalTitle').text('Edit Degree Level');
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
                    url: "{{ route('admin.degree-level.destroy', ':id') }}".replace(':id', id),
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

    function approveItem(id) {
        $.post("{{ route('admin.degree-level.approve', ':id') }}".replace(':id', id), { _token: CSRF }, function (res) {
            if (res.success) {
                table.ajax.reload(null, false);
                Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 1500, showConfirmButton: false });
            }
        }).fail(function () { Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to approve.' }); });
    }

    var approveSelectedDegrees = [];
    var approveSelectedMajors  = [];
    var approveCurrentViewDegree = null;

    function openApproveModal(id, name) {
        // fetch degrees and majors under this level
        $.get("{{ route('admin.degree-level.details', ':id') }}".replace(':id', id), function (res) {
            if (res.success) {
                var data = res.data;
                $('#approveModal #approve_level_name').text(data.degree_level_name);

                // reset selections
                approveSelectedDegrees = [];
                approveSelectedMajors = [];
                approveCurrentViewDegree = null;

                // build left degrees list
                var $degList = $('#approveDegreesList').empty();
                if (data.degrees && data.degrees.length) {
                    data.degrees.forEach(function (deg, idx) {
                        // add to selected arrays by default
                        approveSelectedDegrees.push(deg.degree_id);
                        if (deg.majors && deg.majors.length) {
                            deg.majors.forEach(function(m){ approveSelectedMajors.push(m.major_id); });
                        }

                        var badge = (deg.approve_status == 1) ? '<span class="badge bg-success ms-2">Approved</span>' : (deg.approve_status == 2 ? '<span class="badge bg-danger ms-2">Rejected</span>' : '<span class="badge bg-warning text-dark ms-2">Pending</span>');

                        var $item = $('<label class="list-group-item d-flex align-items-center" style="cursor:pointer"></label>');
                        var $chk = $('<input class="form-check-input me-3 degree-checkbox" type="checkbox" checked>').attr('data-degree-id', deg.degree_id).data('degree-id', deg.degree_id).data('degree', deg);
                        $item.append($chk).append('<div class="flex-grow-1"><div class="degree-name">' + (deg.degree_name||'') + ' ' + badge + '</div></div>');
                        $item.attr('data-degree-id', deg.degree_id);
                        $degList.append($item);

                        // click shows majors
                        $item.on('click', function (e) {
                            if (e.target.tagName.toLowerCase() === 'input') return; // handled by change
                            // highlight selected degree
                            $degList.find('.list-group-item').removeClass('active');
                            $item.addClass('active');
                            renderMajorsForDegree(deg);
                        });

                        // checkbox change
                        $chk.on('change', function () {
                            var checked = $(this).is(':checked');
                            if (checked) {
                                if (approveSelectedDegrees.indexOf(deg.degree_id) === -1) approveSelectedDegrees.push(deg.degree_id);
                                if (deg.majors) deg.majors.forEach(function(m){ if (approveSelectedMajors.indexOf(m.major_id) === -1) approveSelectedMajors.push(m.major_id); });
                            } else {
                                approveSelectedDegrees = approveSelectedDegrees.filter(function(v){ return v != deg.degree_id; });
                                if (deg.majors) deg.majors.forEach(function(m){ approveSelectedMajors = approveSelectedMajors.filter(function(v){ return v != m.major_id; }); });
                            }
                            // if current view is this degree, re-render majors
                            if (approveCurrentViewDegree && approveCurrentViewDegree.degree_id == deg.degree_id) renderMajorsForDegree(deg);
                        });

                        // open first degree by default and highlight
                        if (idx === 0) { $item.addClass('active'); renderMajorsForDegree(deg); }
                    });
                } else {
                    $degList.append('<div class="text-muted p-2">No degrees found under this level.</div>');
                    $('#approveMajorsList').empty();
                }

                $('#approveModal').modal('show');
                $('#approveModal').data('level-id', id);
            }
        }).fail(function () {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load details.' });
        });
    }

    function renderMajorsForDegree(deg) {
        approveCurrentViewDegree = deg;
        var $maj = $('#approveMajorsList').empty();
        if (deg.majors && deg.majors.length) {
            var $list = $('<div class="list-group"></div>');
            deg.majors.forEach(function(m){
                var checked = (approveSelectedMajors.indexOf(m.major_id) !== -1);
                var badge = (m.approve_status == 1) ? '<span class="badge bg-success ms-2">Approved</span>' : (m.approve_status == 2 ? '<span class="badge bg-danger ms-2">Rejected</span>' : '<span class="badge bg-warning text-dark ms-2">Pending</span>');
                var $item = $('<label class="list-group-item d-flex align-items-center" style="cursor:default"></label>');
                var $chk = $('<input class="form-check-input major-checkbox me-3" type="checkbox">').prop('checked', checked).attr('data-major-id', m.major_id).data('major-id', m.major_id);
                $item.append($chk).append('<div>' + (m.major_name||'') + ' ' + badge + '</div>');
                if (checked) $item.addClass('active');
                $list.append($item);

                $chk.on('change', function () {
                    var cid = $(this).data('major-id');
                    if ($(this).is(':checked')) {
                        if (approveSelectedMajors.indexOf(cid) === -1) approveSelectedMajors.push(cid);
                        $item.addClass('active');
                    } else {
                        approveSelectedMajors = approveSelectedMajors.filter(function(v){ return v != cid; });
                        $item.removeClass('active');
                    }
                });
            });
            $maj.append($list);
        } else {
            $maj.append('<div class="text-muted">No majors for this degree.</div>');
        }
    }

    function submitApprove() {
        var id = $('#approveModal').data('level-id');
        var degree_ids = [];
        var major_ids = [];

        $('#approveModal .degree-checkbox:checked').each(function () {
            degree_ids.push($(this).data('degree-id'));
        });
        $('#approveModal .major-checkbox:checked').each(function () {
            major_ids.push($(this).data('major-id'));
        });

        $.post("{{ route('admin.degree-level.approve', ':id') }}".replace(':id', id), { degree_ids: degree_ids, major_ids: major_ids, _token: CSRF }, function (res) {
            if (res.success) {
                $('#approveModal').modal('hide');
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
        $.post("{{ route('admin.degree-level.reject', ':id') }}".replace(':id', id), { reject_reason: reason, _token: CSRF }, function (res) {
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

            <!-- Approve Modal -->
            <div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Approve Degree Level</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Degree Level:</label>
                                <div id="approve_level_name" class="h5"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label">Degrees</label>
                                    <div id="approveDegreesList" class="list-group" style="max-height:300px;overflow:auto"></div>
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label">Majors (for selected degree)</label>
                                    <div id="approveMajorsList" style="max-height:300px;overflow:auto"></div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <small class="text-muted">Explanation: Select which Degrees and Majors you want to approve. By default all are selected. Click a Degree on the left to view and toggle its Majors on the right.</small>
                            </div>

                            <div class="alert alert-info mt-2 mb-0">
                                <strong>Note:</strong> Approving here will also approve the selected Degree Level along with the checked Degree(s) and Major(s).
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn-approve" onclick="submitApprove()">Approve Selected</button>
                        </div>
                    </div>
                </div>
            </div>
</div>
