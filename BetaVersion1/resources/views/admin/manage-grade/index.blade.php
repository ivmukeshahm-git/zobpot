@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "ManageGrade";
</script>

<style>
    /* Manage Grade Page Styles */
    .grade-page-header {
        background: #242a62;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(36, 42, 98, 0.2);
    }

    .grade-page-header h4 {
        color: white;
        margin: 0;
        font-size: 26px;
        font-weight: 700;
    }

    .grade-page-header p {
        color: rgba(255, 255, 255, 0.9);
        margin: 5px 0 0 0;
        font-size: 14px;
    }

    .grade-table-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .table-header-section {
        background: #242a62;
        padding: 20px 25px;
        border-bottom: 3px solid #f26e2c;
    }

    .table-header-section h5 {
        color: white;
        margin: 0;
        font-size: 18px;
        font-weight: 700;
    }

 
    #collegeGradeTable thead th {
        font-weight: 700;
        font-size: 13px;
        padding: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }

    #collegeGradeTable tbody tr {
        transition: all 0.3s ease;
    }

    #collegeGradeTable tbody tr:hover {
        background-color: #f0f4ff;
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(44, 62, 144, 0.1);
    }

    #collegeGradeTable tbody td {
        padding: 15px;
        vertical-align: middle;
        font-size: 14px;
        color: #495057;
        border-bottom: 1px solid #e9ecef;
    }

    .btn-add-grade {
        background: #242a62;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
    }

    .btn-add-grade:hover {
        background: #242a62;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
    }

    .btn-add-grade i {
        margin-right: 5px;
    }

    .search-filter-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 8px 12px;
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 5px 10px;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="grade-page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="bx bx-medal"></i> Manage Grade</h4>
                <p>Manage college-wise grading system</p>
            </div>
        </div>
    </div>

    <!-- College Grade Table -->
    <div class="grade-table-card">
        <div class="table-header-section">
            <h5><i class="bx bx-list-ul"></i> College List</h5>
        </div>
        <div class="card-body" style="padding: 25px;">
            <div class="table-responsive">
                <table id="collegeGradeTable" class="table table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>SR. NO.</th>
                            <th>COLLEGE / SCHOOL NAME</th>
                            <th>UNIVERSITY / BOARD</th>
                            <th>CITY</th>
                            <th>STATE</th>
                            <th>EMAIL</th>
                            <th style="text-align: center;">PHONE</th>
                            <th style="text-align: center;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($colleges as $index => $college)
                        <tr>
                            <td style="font-weight: 600;">{{ $index + 1 }}</td>
                            <td>
                                <div style="font-weight: 600; color: #212529;">{{ $college->college_name }}</div>
                            </td>
                            <td>{{ $college->university ? $college->university->university_name : 'N/A' }}</td>
                            <td>{{ $college->city }}</td>
                            <td>{{ $college->state }}</td>
                            <td>{{ $college->email }}</td>
                            <td style="text-align: center; font-family: monospace;">{{ $college->phone }}</td>
                            <td style="text-align: center;">
                                @can('Manage_Grade-Add')
                                <a href="{{ route('admin.manage-grade.add', ['id' => $college->id]) }}" class="btn btn-add-grade">
                                    <i class="bx bx-plus-circle"></i> Add Grade
                                </a>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#collegeGradeTable').DataTable({
            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "Search colleges:",
                lengthMenu: "Show _MENU_ entries per page",
                info: "Showing _START_ to _END_ of _TOTAL_ colleges",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            columnDefs: [
                { orderable: false, targets: [7] } // Disable sorting on Action column
            ]
        });
    });
</script>
@endpush
