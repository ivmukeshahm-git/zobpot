@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "CollegeRoles";
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center"
                style="background: linear-gradient(135deg, #242a62 0%, #3a4799 100%); border-radius: 12px 12px 0 0;">
                <h5 class="mb-0" style="color: #fff; font-weight: 700;">
                    <i class="bx bx-shield-quarter"></i> College Roles Management
                </h5>
                <button type="button" class="btn btn-light btn-sm" id="addRoleBtn">
                    <i class="bx bx-plus"></i> Add Role
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="rolesDataTable" style="width:100%">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Guard</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Role Modal -->
    <div class="modal fade" id="roleModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #242a62 0%, #3a4799 100%);">
                    <h5 class="modal-title" style="color: #fff;" id="roleModalTitle">Add Role</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="roleForm">
                        @csrf
                        <input type="hidden" id="role_id" value="">

                        <div class="mb-4">
                            <label class="form-label fw-bold">Role Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="role_name" name="role_nm" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Permissions</label>
                            <div class="form-check mb-3" style="border-bottom: 2px solid #242a62; padding-bottom: 10px;">
                                <input class="form-check-input" type="checkbox" id="selectAllPermissions">
                                <label class="form-check-label fw-bold" for="selectAllPermissions">Select All Permissions</label>
                            </div>

                            @foreach ($PermissionData as $group => $permissions)
                                <div class="mb-3 p-3" style="background: #f8f9fa; border-radius: 8px;">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input group-check" type="checkbox"
                                            id="group_{{ $group }}" data-group="{{ $group }}">
                                        <label class="form-check-label fw-bold" for="group_{{ $group }}">
                                            {{ $group }}
                                        </label>
                                    </div>
                                    <div class="ms-4 row">
                                        @foreach ($permissions as $permission)
                                            <div class="col-md-4 col-sm-6">
                                                <div class="form-check">
                                                    <input class="form-check-input permission-check"
                                                        type="checkbox" name="permissions[]"
                                                        value="{{ $permission->id }}"
                                                        data-group="{{ $group }}"
                                                        id="perm_{{ $permission->id }}">
                                                    <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                        {{ explode('-', $permission->name)[1] ?? $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveRoleBtn">
                        <i class="bx bx-save"></i> Save Role
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
    var table = $('#rolesDataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.college.roles.data") }}',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'guard_name', name: 'guard_name' },
            { data: 'created_at_formatted', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']],
        language: { emptyTable: "No roles found. Click 'Add Role' to create one." }
    });

    // Select All permissions
    $('#selectAllPermissions').on('change', function() {
        $('.permission-check').prop('checked', $(this).is(':checked'));
        $('.group-check').prop('checked', $(this).is(':checked'));
    });

    // Group checkbox toggle
    $('.group-check').on('change', function() {
        var group = $(this).data('group');
        $('.permission-check[data-group="' + group + '"]').prop('checked', $(this).is(':checked'));
    });

    // Individual permission click updates group checkbox
    $('.permission-check').on('change', function() {
        var group = $(this).data('group');
        var total = $('.permission-check[data-group="' + group + '"]').length;
        var checked = $('.permission-check[data-group="' + group + '"]:checked').length;
        $('#group_' + group).prop('checked', total === checked);
    });

    // Add Role
    $('#addRoleBtn').on('click', function() {
        $('#roleModalTitle').text('Add Role');
        $('#roleForm')[0].reset();
        $('#role_id').val('');
        $('.permission-check').prop('checked', false);
        $('.group-check').prop('checked', false);
        $('#selectAllPermissions').prop('checked', false);
        new bootstrap.Modal('#roleModal').show();
    });

    // Edit Role
    $(document).on('click', '.edit-role-btn', function() {
        var id = $(this).data('id');
        $.get('{{ url("admin/college-roles") }}/' + id + '/permissions', function(res) {
            if (res.status === 1) {
                $('#roleModalTitle').text('Edit Role');
                $('#role_id').val(id);
                $('#role_name').val(res.role.name);
                $('.permission-check').prop('checked', false);
                $('.group-check').prop('checked', false);
                $.each(res.permissions, function(i, pid) {
                    $('#perm_' + pid).prop('checked', true);
                });
                // Update group checkboxes
                $('.group-check').each(function() {
                    var group = $(this).data('group');
                    var total = $('.permission-check[data-group="' + group + '"]').length;
                    var checked = $('.permission-check[data-group="' + group + '"]:checked').length;
                    $(this).prop('checked', total === checked);
                });
                new bootstrap.Modal('#roleModal').show();
            }
        });
    });

    // Save Role
    $('#saveRoleBtn').on('click', function() {
        var id = $('#role_id').val();
        var isEdit = id !== '';
        var url = isEdit
            ? '{{ url("admin/college-roles") }}/' + id + '/update'
            : '{{ route("admin.college.roles.store") }}';

        var perms = [];
        $('.permission-check:checked').each(function() {
            perms.push($(this).val());
        });

        var data = {
            _token: '{{ csrf_token() }}',
            role_nm: $('#role_name').val(),
            permissions: perms
        };

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(res) {
                if (res.status === 1) {
                    bootstrap.Modal.getInstance(document.getElementById('roleModal')).hide();
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

    // Delete Role
    $(document).on('click', '.delete-role-btn', function() {
        if (!confirm('Are you sure you want to delete this role?')) return;
        var id = $(this).data('id');
        $.ajax({
            url: '{{ url("admin/college-roles") }}/' + id + '/delete',
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
