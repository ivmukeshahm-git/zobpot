@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "CollegeStaff";
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center"
                style="background: linear-gradient(135deg, #242a62 0%, #3a4799 100%); border-radius: 12px 12px 0 0;">
                <h5 class="mb-0" style="color: #fff; font-weight: 700;">
                    <i class="bx bx-group"></i> College Staff Management
                </h5>
                <button type="button" class="btn btn-light btn-sm" id="addStaffBtn">
                    <i class="bx bx-plus"></i> Add Staff
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="staffDataTable" style="width:100%">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Staff Modal -->
    <div class="modal fade" id="staffModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #242a62 0%, #3a4799 100%);">
                    <h5 class="modal-title" style="color: #fff;" id="staffModalTitle">Add Staff</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="staffForm">
                        @csrf
                        <input type="hidden" id="staff_id" value="">
                        <input type="hidden" id="staff_method" value="POST">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="staff_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="staff_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone</label>
                            <input type="text" class="form-control" id="staff_phone" name="phone">
                        </div>
                        <div class="mb-3" id="password_group">
                            <label class="form-label fw-bold">Password <span class="text-danger" id="pwd_required">*</span></label>
                            <input type="password" class="form-control" id="staff_password" name="password">
                            <small class="text-muted" id="pwd_hint" style="display:none;">Leave blank to keep current password.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Role</label>
                            <select class="form-select" id="staff_role" name="role_id">
                                <option value="">-- No Role --</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="staff_status" name="active_status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveStaffBtn">
                        <i class="bx bx-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
$(function() {
    // DataTable
    var table = $('#staffDataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.college.staff.data") }}',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone', defaultContent: '-' },
            { data: 'role_name', name: 'role_name', orderable: false, searchable: false },
            { data: 'status_badge', name: 'status_badge', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']],
        language: { emptyTable: "No staff members found. Click 'Add Staff' to create one." }
    });

    // Load roles dropdown
    function loadRoles(selectedId) {
        $.get('{{ route("admin.college.staff.roles-list") }}', function(data) {
            var sel = $('#staff_role');
            sel.find('option:not(:first)').remove();
            $.each(data, function(i, role) {
                sel.append('<option value="' + role.id + '"' + (role.id == selectedId ? ' selected' : '') + '>' + role.name + '</option>');
            });
        });
    }

    // Add Staff
    $('#addStaffBtn').on('click', function() {
        $('#staffModalTitle').text('Add Staff');
        $('#staffForm')[0].reset();
        $('#staff_id').val('');
        $('#staff_method').val('POST');
        $('#staff_password').attr('required', true);
        $('#pwd_required').show();
        $('#pwd_hint').hide();
        loadRoles(null);
        new bootstrap.Modal('#staffModal').show();
    });

    // Edit Staff
    $(document).on('click', '.edit-staff-btn', function() {
        var id = $(this).data('id');
        $.get('{{ url("admin/college-staff") }}/' + id + '/edit', function(res) {
            if (res.status === 1) {
                var d = res.data;
                $('#staffModalTitle').text('Edit Staff');
                $('#staff_id').val(d.id);
                $('#staff_method').val('PUT');
                $('#staff_name').val(d.name);
                $('#staff_email').val(d.email);
                $('#staff_phone').val(d.phone);
                $('#staff_password').val('').removeAttr('required');
                $('#pwd_required').hide();
                $('#pwd_hint').show();
                $('#staff_status').val(d.active_status);
                loadRoles(d.role_id);
                new bootstrap.Modal('#staffModal').show();
            }
        });
    });

    // Save Staff
    $('#saveStaffBtn').on('click', function() {
        var id = $('#staff_id').val();
        var isEdit = id !== '';
        var url = isEdit
            ? '{{ url("admin/college-staff") }}/' + id + '/update'
            : '{{ route("admin.college.staff.store") }}';

        var data = {
            _token: '{{ csrf_token() }}',
            name: $('#staff_name').val(),
            email: $('#staff_email').val(),
            phone: $('#staff_phone').val(),
            password: $('#staff_password').val(),
            role_id: $('#staff_role').val() || '',
            active_status: $('#staff_status').val()
        };

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(res) {
                if (res.status === 1) {
                    bootstrap.Modal.getInstance(document.getElementById('staffModal')).hide();
                    table.ajax.reload();
                    alert(res.message);
                } else {
                    alert(res.message);
                }
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
            }
        });
    });

    // Delete Staff
    $(document).on('click', '.delete-staff-btn', function() {
        if (!confirm('Are you sure you want to delete this staff member?')) return;
        var id = $(this).data('id');
        $.ajax({
            url: '{{ url("admin/college-staff") }}/' + id + '/delete',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(res) {
                table.ajax.reload();
                alert(res.message);
            }
        });
    });
});
</script>
@endpush
