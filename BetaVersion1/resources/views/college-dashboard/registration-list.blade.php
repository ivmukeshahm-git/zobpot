@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "CollegeRegistration";
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center"
                style="background: linear-gradient(135deg, #242a62 0%, #3a4799 100%); border-radius: 12px 12px 0 0;">
                <h5 class="mb-0" style="color: #fff; font-weight: 700;">
                    <i class="bx bx-list-ul"></i> Registration List
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="registrationTable" style="width:100%">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th>Sr No</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>University</th>
                                <th>Course</th>
                                <th>Registered Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
$(function() {
    $('#registrationTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.college.registration-list.data") }}',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'contact_no', name: 'contact_no', defaultContent: '-' },
            { data: 'university_name', name: 'university_name', orderable: false, searchable: false },
            { data: 'course', name: 'course', orderable: false, searchable: false },
            { data: 'registered_date', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[6, 'desc']],
        language: { emptyTable: "No students registered under this college." }
    });
});
</script>
@endpush
