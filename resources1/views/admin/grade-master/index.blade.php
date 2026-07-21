@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "GradeMaster";
    </script>

    <style>
        /* Grade Master Page Styles */
        .grade-master-header {
            background: linear-gradient(135deg, #242a62 0%, #3d4575 100%);
            padding: 25px 30px;
            border-radius: 12px 12px 0 0;
            box-shadow: 0 4px 15px rgba(36, 42, 98, 0.3);
        }

        .grade-master-header h5 {
            color: white;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .grade-master-header p {
            color: rgba(255, 255, 255, 0.85);
            margin: 5px 0 0 0;
            font-size: 14px;
        }

        .btn-add-grade {
            background: linear-gradient(135deg, #f26e2c 0%, #ff8c5a 100%);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(242, 110, 44, 0.3);
        }

        .btn-add-grade:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(242, 110, 44, 0.4);
            color: white;
        }

        .table-container {
            background: white;
            padding: 30px;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table-grade-master {
            margin-top: 20px;
        }

        .table-grade-master thead {
            background: #f8f9fa;
            border-bottom: 2px solid #242a62;
        }

        .table-grade-master thead th {
            color: #242a62;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            padding: 15px 12px;
            border: none;
        }

        .table-grade-master tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e9ecef;
        }

        .table-grade-master tbody tr:hover {
            background: #f8f9fa;
            transform: scale(1.01);
        }

        .table-grade-master tbody td {
            padding: 15px 12px;
            vertical-align: middle;
            color: #495057;
            font-size: 14px;
        }

        .grade-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 13px;
        }

        .grade-badge.grade-A {
            background: #28a745;
            color: white;
        }

        .grade-badge.grade-B {
            background: #17a2b8;
            color: white;
        }

        .grade-badge.grade-C {
            background: #ffc107;
            color: #333;
        }

        .grade-badge.grade-D {
            background: #fd7e14;
            color: white;
        }

        .grade-badge.grade-F {
            background: #dc3545;
            color: white;
        }

        .marks-range {
            font-weight: 600;
            color: #242a62;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            margin: 0 3px;
        }

        .btn-edit {
            background: #17a2b8;
            color: white;
        }

        .btn-edit:hover {
            background: #138496;
            color: white;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
            color: white;
            transform: translateY(-2px);
        }

        /* Modal Styles */
        .modal-header-custom {
            background: linear-gradient(135deg, #242a62 0%, #3d4575 100%);
            color: white;
            padding: 20px 30px;
            border: none;
        }

        .modal-header-custom .modal-title {
            font-size: 20px;
            font-weight: 700;
        }

        .modal-header-custom .btn-close {
            filter: brightness(0) invert(1);
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-label .required {
            color: #dc3545;
            margin-left: 3px;
        }

        .form-control:focus {
            border-color: #f26e2c;
            box-shadow: 0 0 0 0.2rem rgba(242, 110, 44, 0.15);
        }

        .btn-submit {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 10px 28px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 64px;
            color: #dee2e6;
            margin-bottom: 20px;
        }

        .empty-state h5 {
            color: #6c757d;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #adb5bd;
            font-size: 14px;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="card" style="border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
            <div class="grade-master-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5><i class="bx bx-award"></i> Grade Master</h5>
                        <p>Manage grading system and grade criteria</p>
                    </div>
                    <button type="button" class="btn btn-add-grade" onclick="openAddGradeModal()">
                        <i class="bx bx-plus-circle"></i> Add New Grade
                    </button>
                </div>
            </div>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-grade-master table-hover" id="gradeTable">
                        <thead>
                            <tr>
                                <th>SR. NO</th>
                                <th>GRADE NAME</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sample Data -->
                            <tr data-grade-id="1">
                                <td>1</td>
                                <td>College</td>
                                <td>
                                    <button class="btn btn-action btn-edit" onclick="openEditGradeModal(1)">
                                        <i class="bx bx-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-action btn-delete" onclick="deleteGrade(1)">
                                        <i class="bx bx-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            <tr data-grade-id="2">
                                <td>2</td>
                                <td>Company</td>
                                <td>
                                    <button class="btn btn-action btn-edit" onclick="openEditGradeModal(2)">
                                        <i class="bx bx-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-action btn-delete" onclick="deleteGrade(2)">
                                        <i class="bx bx-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Grade Modal -->
    <div class="modal fade" id="addGradeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; ">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" style="color: #fff;"><i class="bx bx-plus-circle"></i> Add New Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        style="background: #fff; border: none; font-size: 24px; color: white; opacity: 1; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                        <i class="bx bx-x" style="color: #000"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <form id="addGradeForm">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Marks Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="AddMarksName"
                                    placeholder="e.g., College, Company" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="background: #f8f9fa; padding: 20px 30px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-submit" onclick="saveGrade()">
                        <i class="bx bx-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Grade Modal -->
    <div class="modal fade" id="editGradeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title"><i class="bx bx-edit"></i> Edit Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <form id="editGradeForm">
                        <input type="hidden" id="editGradeId">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Grade Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="editGradeName"
                                    placeholder="e.g., A+, A, B" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Min Marks <span class="required">*</span></label>
                                <input type="number" class="form-control" id="editMinMarks" placeholder="0"
                                    min="0" max="100" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Max Marks <span class="required">*</span></label>
                                <input type="number" class="form-control" id="editMaxMarks" placeholder="100"
                                    min="0" max="100" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="editDescription" rows="3" placeholder="Enter description..."></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status <span class="required">*</span></label>
                                <select class="form-select" id="editStatus" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="background: #f8f9fa; padding: 20px 30px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-submit" onclick="updateGrade()">
                        <i class="bx bx-save"></i> Update Grade
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#gradeTable').DataTable({
                order: [
                    [0, 'asc']
                ],
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search grades..."
                }
            });
        });

        // Sample grade data
        const gradeData = {
            1: {
                name: 'A+',
                minMarks: 90,
                maxMarks: 100,
                description: 'Outstanding Performance',
                status: 1
            },
            2: {
                name: 'A',
                minMarks: 80,
                maxMarks: 89,
                description: 'Excellent Performance',
                status: 1
            },
            3: {
                name: 'B',
                minMarks: 70,
                maxMarks: 79,
                description: 'Good Performance',
                status: 1
            },
            4: {
                name: 'C',
                minMarks: 60,
                maxMarks: 69,
                description: 'Average Performance',
                status: 1
            },
            5: {
                name: 'D',
                minMarks: 50,
                maxMarks: 59,
                description: 'Below Average',
                status: 1
            },
            6: {
                name: 'F',
                minMarks: 0,
                maxMarks: 49,
                description: 'Fail',
                status: 1
            }
        };

        // Open Add Grade Modal
        window.openAddGradeModal = function() {
            document.getElementById('addGradeForm').reset();
            const modal = new bootstrap.Modal(document.getElementById('addGradeModal'));
            modal.show();
        }

        // Open Edit Grade Modal
        window.openEditGradeModal = function(gradeId) {
            const data = gradeData[gradeId];

            if (data) {
                document.getElementById('editGradeId').value = gradeId;
                document.getElementById('editGradeName').value = data.name;
                document.getElementById('editMinMarks').value = data.minMarks;
                document.getElementById('editMaxMarks').value = data.maxMarks;
                document.getElementById('editDescription').value = data.description;
                document.getElementById('editStatus').value = data.status;

                const modal = new bootstrap.Modal(document.getElementById('editGradeModal'));
                modal.show();
            }
        }

        // Save Grade
        window.saveGrade = function() {
            const form = document.getElementById('addGradeForm');

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const formData = {
                name: document.getElementById('addGradeName').value,
                minMarks: document.getElementById('addMinMarks').value,
                maxMarks: document.getElementById('addMaxMarks').value,
                description: document.getElementById('addDescription').value,
                status: document.getElementById('addStatus').value
            };

            console.log('Saving grade:', formData);

            // Here you would send to backend via AJAX
            // $.ajax({
            //     url: '/admin/grade-master/store',
            //     method: 'POST',
            //     data: formData,
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            //     success: function(response) {
            //         alert('✅ Grade added successfully!');
            //         location.reload();
            //     },
            //     error: function(error) {
            //         alert('❌ Error adding grade. Please try again.');
            //     }
            // });

            // For now, just show success message
            bootstrap.Modal.getInstance(document.getElementById('addGradeModal')).hide();
            alert('✅ Grade added successfully!');
            // location.reload();
        }

        // Update Grade
        window.updateGrade = function() {
            const form = document.getElementById('editGradeForm');

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const gradeId = document.getElementById('editGradeId').value;
            const formData = {
                id: gradeId,
                name: document.getElementById('editGradeName').value,
                minMarks: document.getElementById('editMinMarks').value,
                maxMarks: document.getElementById('editMaxMarks').value,
                description: document.getElementById('editDescription').value,
                status: document.getElementById('editStatus').value
            };

            console.log('Updating grade:', formData);

            // Here you would send to backend via AJAX
            // $.ajax({
            //     url: '/admin/grade-master/update/' + gradeId,
            //     method: 'PUT',
            //     data: formData,
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            //     success: function(response) {
            //         alert('✅ Grade updated successfully!');
            //         location.reload();
            //     },
            //     error: function(error) {
            //         alert('❌ Error updating grade. Please try again.');
            //     }
            // });

            // For now, just show success message
            bootstrap.Modal.getInstance(document.getElementById('editGradeModal')).hide();
            alert('✅ Grade updated successfully!');
            // location.reload();
        }

        // Delete Grade
        window.deleteGrade = function(gradeId) {
            if (confirm('⚠️ Are you sure you want to delete this grade?\n\nThis action cannot be undone.')) {
                console.log('Deleting grade:', gradeId);

                // Here you would send to backend via AJAX
                // $.ajax({
                //     url: '/admin/grade-master/delete/' + gradeId,
                //     method: 'DELETE',
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     },
                //     success: function(response) {
                //         alert('✅ Grade deleted successfully!');
                //         location.reload();
                //     },
                //     error: function(error) {
                //         alert('❌ Error deleting grade. Please try again.');
                //     }
                // });

                // For now, just show success message
                alert('✅ Grade deleted successfully!');
                // $('tr[data-grade-id="' + gradeId + '"]').fadeOut();
            }
        }
    </script>
@endpush
