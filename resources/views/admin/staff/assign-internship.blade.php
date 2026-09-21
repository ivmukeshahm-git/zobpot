@extends('admin.layout.layout')
@section('content')
<script>page_active_id = "Staff";</script>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header p-4">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-title">Assign Opportunity</h5>
                    <p class="text-muted">List of opportunities assigned to you (staff view).</p>
                </div>
            </div>
        </div>
        <hr class="my-1">
        <div class="card-body table-responsive p-4">
            <table id="StaffAssignInternshipTable" class="table table-sm table-striped table-hover">
                <thead class="border-top">
                    <tr>
                        <th>Sr. NO.</th>
                        <th>Student Name</th>
                        <th>Opportunity</th>
                        <th>Email</th>
                        <th>Contact</th>
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
    var table = $('#StaffAssignInternshipTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("internship.students-data") }}',
            type: 'POST',
            data: function(d){ d._token = '{{ csrf_token() }}'; }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'student_name', name: 'student_name' },
            { data: 'internship_title', name: 'internship_title' },
            { data: 'email', name: 'email' },
            { data: 'contact', name: 'contact' },
            { data: 'assigned_date', name: 'assigned_date' },
            { data: 'action', name: 'action', orderable:false, searchable:false }
        ]
    });
});
</script>
@endpush
