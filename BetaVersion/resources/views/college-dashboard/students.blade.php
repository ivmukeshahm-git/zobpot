@push('css')
    <style>
        .filter-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .student-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .student-avatar-large {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e0e0e0;
        }

        .filter-chip {
            display: inline-block;
            padding: 8px 16px;
            margin: 5px;
            border-radius: 20px;
            background: #f0f0f0;
            color: #666;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-chip:hover {
            background: #242a62;
            color: white;
        }

        .filter-chip.active {
            background: #242a62;
            color: white;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding-left: 45px;
            border-radius: 25px;
            border: 2px solid #e0e0e0;
            height: 45px;
        }

        .search-box i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 18px;
        }

        .action-buttons .btn {
            margin: 0 3px;
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 6px;
        }
    </style>
@endpush

@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "College-Dashboard";
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: #242a62;">
                    <i class="bx bx-group"></i> All Students
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.college.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Students</li>
                    </ol>
                </nav>
            </div>
            <div>
                <button class="btn btn-success ms-2">
                    <i class="bx bx-download"></i> Export
                </button>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filter-card">
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label" style="font-size: 13px; font-weight: 600; color: #242a62;">Student Name</label>
                    <input type="text" class="form-control" placeholder="Enter student name..." id="filterStudentName">
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-size: 13px; font-weight: 600; color: #242a62;">Email Address</label>
                    <input type="text" class="form-control" placeholder="Enter email address..." id="filterEmail">
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="font-size: 13px; font-weight: 600; color: #242a62;">Contact Number</label>
                    <input type="text" class="form-control" placeholder="Enter contact number..." id="filterContact">
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-size: 13px; font-weight: 600; color: #242a62;">Internship Name</label>
                    <input type="text" class="form-control" placeholder="Enter internship name..." id="filterInternship">
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="font-size: 13px; font-weight: 600; color: transparent;">Filter</label>
                    <button class="btn btn-primary w-100" id="applyFilters">
                        <i class="bx bx-filter"></i> Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Students Table -->
        <div class="student-card">
            <div class="table-responsive">
                <table class="table table-hover" id="studentsTable">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th style="font-weight: 700; color: #242a62;">Student Details</th>
                            <th style="font-weight: 700; color: #242a62;">Enrollment No.</th>
                            <th style="font-weight: 700; color: #242a62;">Department</th>
                            <th style="font-weight: 700; color: #242a62;">Semester</th>
                            <th style="font-weight: 700; color: #242a62;">Contact</th>
                            <th style="font-weight: 700; color: #242a62;">Internship Status</th>
                            <th style="font-weight: 700; color: #242a62;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('uploads/profile/candidate.jpg') }}" alt="Avatar" class="student-avatar-large me-3">
                                    <div>
                                        <h6 class="mb-0" style="font-weight: 700; color: #242a62; font-size: 14px;">Rahul Sharma</h6>
                                        <small style="color: #666;">rahul.sharma@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td style="vertical-align: middle;">
                                <span style="font-weight: 600; color: #242a62; font-size: 13px;">CS2024001</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <span style="font-size: 13px; color: #666;">Computer Science</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="badge bg-primary" style="font-size: 12px;">6th Semester</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <div>
                                    <small style="display: block; color: #666; font-size: 12px;">
                                        <i class="bx bx-phone"></i> +91 98765 43210
                                    </small>
                                    <small style="display: block; color: #666; font-size: 12px; margin-top: 3px;">
                                        <i class="bx bx-envelope"></i> rahul@example.com
                                    </small>
                                </div>
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 15px; font-size: 11px;">Active</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-info" title="View Profile">
                                        <i class="bx bx-show"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('uploads/profile/candidate.jpg') }}" alt="Avatar" class="student-avatar-large me-3">
                                    <div>
                                        <h6 class="mb-0" style="font-weight: 700; color: #242a62; font-size: 14px;">Priya Patel</h6>
                                        <small style="color: #666;">priya.patel@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td style="vertical-align: middle;">
                                <span style="font-weight: 600; color: #242a62; font-size: 13px;">IT2024002</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <span style="font-size: 13px; color: #666;">Information Technology</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="badge bg-primary" style="font-size: 12px;">5th Semester</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <div>
                                    <small style="display: block; color: #666; font-size: 12px;">
                                        <i class="bx bx-phone"></i> +91 98765 43211
                                    </small>
                                    <small style="display: block; color: #666; font-size: 12px; margin-top: 3px;">
                                        <i class="bx bx-envelope"></i> priya@example.com
                                    </small>
                                </div>
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="badge" style="background: #ffc107; color: #000; padding: 6px 12px; border-radius: 15px; font-size: 11px;">Pending</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-info" title="View Profile">
                                        <i class="bx bx-show"></i>
                                    </button>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('uploads/profile/candidate.jpg') }}" alt="Avatar" class="student-avatar-large me-3">
                                    <div>
                                        <h6 class="mb-0" style="font-weight: 700; color: #242a62; font-size: 14px;">Amit Kumar</h6>
                                        <small style="color: #666;">amit.kumar@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td style="vertical-align: middle;">
                                <span style="font-weight: 600; color: #242a62; font-size: 13px;">ME2024003</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <span style="font-size: 13px; color: #666;">Mechanical Engineering</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="badge bg-primary" style="font-size: 12px;">7th Semester</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <div>
                                    <small style="display: block; color: #666; font-size: 12px;">
                                        <i class="bx bx-phone"></i> +91 98765 43212
                                    </small>
                                    <small style="display: block; color: #666; font-size: 12px; margin-top: 3px;">
                                        <i class="bx bx-envelope"></i> amit@example.com
                                    </small>
                                </div>
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="badge" style="background: #6c757d; color: white; padding: 6px 12px; border-radius: 15px; font-size: 11px;">Completed</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-info" title="View Profile">
                                        <i class="bx bx-show"></i>
                                    </button>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('uploads/profile/candidate.jpg') }}" alt="Avatar" class="student-avatar-large me-3">
                                    <div>
                                        <h6 class="mb-0" style="font-weight: 700; color: #242a62; font-size: 14px;">Neha Shah</h6>
                                        <small style="color: #666;">neha.shah@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td style="vertical-align: middle;">
                                <span style="font-weight: 600; color: #242a62; font-size: 13px;">EC2024004</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <span style="font-size: 13px; color: #666;">Electronics & Communication</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="badge bg-primary" style="font-size: 12px;">6th Semester</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <div>
                                    <small style="display: block; color: #666; font-size: 12px;">
                                        <i class="bx bx-phone"></i> +91 98765 43213
                                    </small>
                                    <small style="display: block; color: #666; font-size: 12px; margin-top: 3px;">
                                        <i class="bx bx-envelope"></i> neha@example.com
                                    </small>
                                </div>
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 15px; font-size: 11px;">Active</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-info" title="View Profile">
                                        <i class="bx bx-show"></i>
                                    </button>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;">
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #ec6b29 0%, #f39c6b 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px;">
                                        VD
                                    </div>
                                    <div>
                                        <h6 class="mb-0" style="font-weight: 700; color: #242a62; font-size: 14px;">Vijay Desai</h6>
                                        <small style="color: #666;">vijay.desai@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td style="vertical-align: middle;">
                                <span style="font-weight: 600; color: #242a62; font-size: 13px;">CE2024005</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <span style="font-size: 13px; color: #666;">Civil Engineering</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="badge bg-primary" style="font-size: 12px;">8th Semester</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <div>
                                    <small style="display: block; color: #666; font-size: 12px;">
                                        <i class="bx bx-phone"></i> +91 98765 43214
                                    </small>
                                    <small style="display: block; color: #666; font-size: 12px; margin-top: 3px;">
                                        <i class="bx bx-envelope"></i> vijay@example.com
                                    </small>
                                </div>
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="badge" style="background: #ffc107; color: #000; padding: 6px 12px; border-radius: 15px; font-size: 11px;">Pending</span>
                            </td>
                            <td style="vertical-align: middle;">
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-info" title="View Profile">
                                        <i class="bx bx-show"></i>
                                    </button>
                                    
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #242a62 0%, #3a4799 100%);">
                    <h5 class="modal-title" style="color: white;">
                        <i class="bx bx-user-plus"></i> Add New Student
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addStudentForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter full name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" placeholder="Enter email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Enrollment Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter enrollment number" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" placeholder="Enter phone number" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Department <span class="text-danger">*</span></label>
                                <select class="form-select" required>
                                    <option value="">Select Department</option>
                                    <option value="cs">Computer Science</option>
                                    <option value="it">Information Technology</option>
                                    <option value="me">Mechanical Engineering</option>
                                    <option value="ce">Civil Engineering</option>
                                    <option value="ec">Electronics & Communication</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Semester <span class="text-danger">*</span></label>
                                <select class="form-select" required>
                                    <option value="">Select Semester</option>
                                    <option value="1">Semester 1</option>
                                    <option value="2">Semester 2</option>
                                    <option value="3">Semester 3</option>
                                    <option value="4">Semester 4</option>
                                    <option value="5">Semester 5</option>
                                    <option value="6">Semester 6</option>
                                    <option value="7">Semester 7</option>
                                    <option value="8">Semester 8</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" rows="2" placeholder="Enter address"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" form="addStudentForm">
                        <i class="bx bx-save"></i> Save Student
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var studentsTable = $('#studentsTable').DataTable({
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[1, 'asc']], // Sort by enrollment number
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ students",
                infoEmpty: "Showing 0 to 0 of 0 students",
                infoFiltered: "(filtered from _MAX_ total students)",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [6] } // Disable sorting on action column
            ]
        });

        // Filter button click handler
        $('#applyFilters').on('click', function() {
            studentsTable.draw();
        });

        // Custom filtering function
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var studentName = $('#filterStudentName').val().toLowerCase();
                var email = $('#filterEmail').val().toLowerCase();
                var contact = $('#filterContact').val().toLowerCase();
                var internship = $('#filterInternship').val().toLowerCase();

                var rowStudentName = data[0].toLowerCase(); // Student Details column
                var rowDepartment = data[2].toLowerCase(); // Department column
                var rowContact = data[4].toLowerCase(); // Contact column

                // Check each filter
                if (studentName && !rowStudentName.includes(studentName)) return false;
                if (email && !rowStudentName.includes(email)) return false;
                if (contact && !rowContact.includes(contact)) return false;
                if (internship && !rowStudentName.includes(internship)) return false;

                return true;
            }
        );

        // Add student form submission
        $('#addStudentForm').on('submit', function(e) {
            e.preventDefault();
            // Add your form submission logic here
            console.log('Student form submitted');
            $('#addStudentModal').modal('hide');
        });
    });
</script>
@endpush

@endsection
    
