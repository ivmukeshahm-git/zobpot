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
                            <th>CITY / DISTRICT</th>
                            <th>STATE</th>
                            <th>CONTACT PERSON</th>
                            <th style="text-align: center;">CONTACT NO.</th>
                            <th style="text-align: center;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-weight: 600;">1</td>
                            <td>
                                <div style="font-weight: 600; color: #212529;">A.P. TRIVEDI ARTS, COMMERCE & SCIENCE COLLEGE, KHORDA</div>
                            </td>
                            <td>Hemchandracharya North Gujarat University, Patan</td>
                            <td>KHORDA</td>
                            <td>GUJARAT</td>
                            <td>Shree B. B. Sodha</td>
                            <td style="text-align: center; font-family: monospace;">9427362260</td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.manage-grade.add', ['id' => 1]) }}" class="btn btn-add-grade">
                                    <i class="bx bx-plus-circle"></i> Add Grade
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">2</td>
                            <td>
                                <div style="font-weight: 600; color: #212529;">ADARSH ARTS & COMMERCE COLLEGE, BHABHAR</div>
                            </td>
                            <td>Hemchandracharya North Gujarat University, Patan</td>
                            <td>BHABHAR</td>
                            <td>GUJARAT</td>
                            <td>B.S. Chaudhari</td>
                            <td style="text-align: center; font-family: monospace;">6351569096</td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.manage-grade.add', ['id' => 2]) }}" class="btn btn-add-grade">
                                    <i class="bx bx-plus-circle"></i> Add Grade
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">3</td>
                            <td>
                                <div style="font-weight: 600; color: #212529;">ADARSH ARTS & COMMERCE COLLEGE, PATAN</div>
                            </td>
                            <td>Hemchandracharya North Gujarat University, Patan</td>
                            <td>PATAN</td>
                            <td>GUJARAT</td>
                            <td>Jinalben</td>
                            <td style="text-align: center; font-family: monospace;">9265287190</td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.manage-grade.add', ['id' => 3]) }}" class="btn btn-add-grade">
                                    <i class="bx bx-plus-circle"></i> Add Grade
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">4</td>
                            <td>
                                <div style="font-weight: 600; color: #212529;">ADARSH ARTS AND COMM. COLLEGE, VISNAGAR</div>
                            </td>
                            <td>Hemchandracharya North Gujarat University, Patan</td>
                            <td>VISNAGAR</td>
                            <td>GUJARAT</td>
                            <td>Prof. Alpaben A. Chaudhary</td>
                            <td style="text-align: center; font-family: monospace;">7284050611</td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.manage-grade.add', ['id' => 4]) }}" class="btn btn-add-grade">
                                    <i class="bx bx-plus-circle"></i> Add Grade
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">5</td>
                            <td>
                                <div style="font-weight: 600; color: #212529;">ADIVASI ARTS & COMMERCE COLLEGE, BHILODA</div>
                            </td>
                            <td>Hemchandracharya North Gujarat University, Patan</td>
                            <td>BHILODA</td>
                            <td>GUJARAT</td>
                            <td>Dr. D. D. Chobisa</td>
                            <td style="text-align: center; font-family: monospace;">9427565014</td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.manage-grade.add', ['id' => 5]) }}" class="btn btn-add-grade">
                                    <i class="bx bx-plus-circle"></i> Add Grade
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">6</td>
                            <td>
                                <div style="font-weight: 600; color: #212529;">ADWAIT ARTS COLLEGE, JASARA</div>
                            </td>
                            <td>Hemchandracharya North Gujarat University, Patan</td>
                            <td>JASARA</td>
                            <td>GUJARAT</td>
                            <td>abcd1</td>
                            <td style="text-align: center; font-family: monospace;">9624956835</td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.manage-grade.add', ['id' => 6]) }}" class="btn btn-add-grade">
                                    <i class="bx bx-plus-circle"></i> Add Grade
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">7</td>
                            <td>
                                <div style="font-weight: 600; color: #212529;">ARTS COLLEGE, LAVANA</div>
                            </td>
                            <td>Hemchandracharya North Gujarat University, Patan</td>
                            <td>LAVANA</td>
                            <td>GUJARAT</td>
                            <td>Velabhai Sasun</td>
                            <td style="text-align: center; font-family: monospace;">9429258862</td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.manage-grade.add', ['id' => 7]) }}" class="btn btn-add-grade">
                                    <i class="bx bx-plus-circle"></i> Add Grade
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">8</td>
                            <td>
                                <div style="font-weight: 600; color: #212529;">C.N. ARTS & B.D. COMMERCE COLLEGE, KADI</div>
                            </td>
                            <td>Hemchandracharya North Gujarat University, Patan</td>
                            <td>KADI</td>
                            <td>GUJARAT</td>
                            <td>Dr. G. D. Tripathi</td>
                            <td style="text-align: center; font-family: monospace;">9426997349</td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.manage-grade.add', ['id' => 8]) }}" class="btn btn-add-grade">
                                    <i class="bx bx-plus-circle"></i> Add Grade
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 600;">9</td>
                            <td>
                                <div style="font-weight: 600; color: #212529;">D.D. THAKAR ARTS & K.J. PATEL COMMERCE COLLEGE, KHEDBRAHMA</div>
                            </td>
                            <td>Hemchandracharya North Gujarat University, Patan</td>
                            <td>KHEDBRAHMA</td>
                            <td>GUJARAT</td>
                            <td>Dr. N D Patel</td>
                            <td style="text-align: center; font-family: monospace;">9427695500</td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.manage-grade.add', ['id' => 9]) }}" class="btn btn-add-grade">
                                    <i class="bx bx-plus-circle"></i> Add Grade
                                </a>
                            </td>
                        </tr>
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
