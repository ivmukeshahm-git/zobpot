@extends('admin.layout.layout')
@section('content')
<script>page_active_id = "Staff";</script>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header p-4">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-title">Assigned Internships (Super Admin)</h5>
                    <p class="text-muted">This page shows candidate applications that have been assigned to staff.</p>
                </div>
            </div>
        </div>
        <hr class="my-1">
        <div class="card-body table-responsive p-4">
            <table id="SuperAssignInternshipTable" class="table table-sm table-striped table-hover">
                <thead class="border-top">
                    <tr>
                        <th>Sr. NO.</th>
                        <th>Student Name</th>
                        <th>Opportunity</th>
                        <th>Assigned To</th>
                        <th>Assigned Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
$(function(){
    var table = $('#SuperAssignInternshipTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.staff.assign-internship-super-data") }}',
            type: 'POST',
            data: function(d){ d._token = '{{ csrf_token() }}'; }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'student_name', name: 'student_name' },
            { data: 'internship_title', name: 'internship_title' },
            { data: 'assigned_to', name: 'assigned_to' },
            { data: 'assigned_date', name: 'assigned_date' },
            { data: 'action', name: 'action', orderable:false, searchable:false }
        ]
    });
});
</script>
@endpush
