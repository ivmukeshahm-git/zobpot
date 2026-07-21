@extends('admin.layout.layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex align-items-center mb-4">
        <h4 class="fw-bold mb-0" style="color:#242a62;">
            <i class="bx bx-time me-2" style="color:#FFC107;"></i> Pending Marks — Internships Awaiting College Evaluation
        </h4>
        <a href="{{ route('admin.college.dashboard') }}" class="btn btn-sm btn-secondary ms-auto">
            <i class="bx bx-arrow-back"></i> Back to Dashboard
        </a>
    </div>

    <div class="card">
        <div class="card-header p-4">
            <h5 class="card-title mb-0">
                <i class="bx bx-list-ul"></i> Internships Flagged for College Marks Entry
            </h5>
        </div>
        <hr class="my-1">
        <div class="card-body table-responsive p-4">
            <table id="pendingMarksFullTable" class="table table-sm table-striped table-hover">
                <thead>
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
                <tbody></tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('script')
<script>
$(function(){
    $('#pendingMarksFullTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.college.pending-marks.data') }}",
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'internship_title' },
            { data: 'company_name' },
            { data: 'duration' },
            { data: 'formatted_start_date' },
            { data: 'formatted_end_date' },
            { data: 'status_badge', orderable: false },
            { data: 'action', orderable: false, searchable: false }
        ],
        order: [[4, 'asc']],
        pageLength: 25,
        language: { emptyTable: "No internships are currently flagged for college marks entry." }
    });
});
</script>
@endpush
