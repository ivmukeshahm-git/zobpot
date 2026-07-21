@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "ManageGrade";
</script>

<style>
    /* Grade Management Page Styles */
    .grade-management-header {
        background: #242a62;
        padding: 20px 30px;
        border-radius: 12px 12px 0 0;
        box-shadow: 0 4px 15px rgba(36, 42, 98, 0.2);
    }

    .grade-management-header h5 {
        color: white;
        margin: 0;
        font-size: 20px;
        font-weight: 700;
    }

    .btn-back {
        background: white;
        color: #242a62;
        border: none;
        padding: 8px 20px;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #f8f9fa;
        color: #242a62;
        transform: translateX(-3px);
    }

    .form-section {
        background: white;
        padding: 30px;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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

    .form-control,
    .form-select {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #f26e2c;
        box-shadow: 0 0 0 0.2rem rgba(242, 110, 44, 0.15);
    }

    .marks-entry-section {
        background: #3d4d5c;
        color: white;
        padding: 15px 25px;
        border-radius: 8px;
        margin: 25px 0 20px 0;
    }

    .marks-entry-section h6 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
    }

    .marks-entry-section h6 i {
        margin-right: 10px;
    }

    .marks-entry-row {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .marks-entry-row:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .marks-entry-row input {
        flex: 1;
    }

    .marks-entry-row .marks-entry-grade {
        flex: 1;
        background: white;
        border: 1px solid #dee2e6;
        color: #495057;
        font-weight: 600;
        cursor: pointer;
    }

    .marks-entry-row .marks-entry-grade:focus {
        border-color: #f26e2c;
        box-shadow: 0 0 0 0.2rem rgba(242, 110, 44, 0.15);
    }

    .btn-delete-row {
        background: #dc3545;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 50px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-delete-row:hover {
        background: #c82333;
        transform: scale(1.05);
    }

    .btn-add-row {
        background: white;
        color: #3d4d5c;
        border: 2px dashed #3d4d5c;
        padding: 10px 24px;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .btn-add-row:hover {
        background: #3d4d5c;
        color: white;
        border-color: #3d4d5c;
    }

    .grade-marks-section {
        background: #f4f4f4;
        padding: 25px;
        border-radius: 12px;
        margin-top: 30px;
        border: 2px solid #ff9f43;
    }

    .grade-marks-section h5 {
        color: #ff6b35;
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 18px;
    }

    .grade-section-header {
        background: #3d4d5c;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-weight: 700;
        font-size: 15px;
    }

    .grade-criterion-row {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .grade-criterion-row .row {
        align-items: center;
    }

    .grade-criterion-row .form-control,
    .grade-criterion-row .form-select {
        height: 42px;
    }

    .btn-add-criterion {
        background: white;
        color: #ff6b35;
        border: 2px dashed #ff6b35;
        padding: 8px 20px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .btn-add-criterion:hover {
        background: #ff6b35;
        color: white;
        border-color: #ff6b35;
    }

    .btn-update-grading {
        background: #242a62;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(242, 110, 44, 0.3);
    }

    .btn-update-grading:hover {
        background: #242a62;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(242, 110, 44, 0.4);
    }

    .btn-update-grading i {
        margin-right: 8px;
    }

    #gradeMarksContainer {
        display: none;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="card" style="border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <div class="grade-management-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5><i class="bx bx-save"></i> Grade Management</h5>
                <a href="{{ route('admin.manage-grade.index') }}" class="btn btn-back">
                    <i class="bx bx-arrow-back"></i> Back
                </a>
            </div>
        </div>

        <div class="form-section">
            <form id="gradeManagementForm">
                <!-- Course Selection and Total Marks -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">
                            Select Course <span class="required">*</span>
                        </label>
                        <select class="form-select" id="courseSelect" required>
                            <option value="">Select value</option>
                            <option value="bca">Bachelor of Computer Applications (BCA)</option>
                            <option value="bba">Bachelor of Business Administration (BBA)</option>
                            <option value="bcom">Bachelor of Commerce (B.Com)</option>
                            <option value="ba">Bachelor of Arts (BA)</option>
                            <option value="bsc">Bachelor of Science (B.Sc)</option>
                            <option value="mca">Master of Computer Applications (MCA)</option>
                            <option value="mba">Master of Business Administration (MBA)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">
                            Total Marks <span class="required">*</span>
                        </label>
                        <input type="number" class="form-control" id="totalMarks" placeholder="Enter Total Marks" required>
                    </div>
                </div>

                <!-- Marks Entry Section -->
                <div class="marks-entry-section">
                    <h6 style="color:#fff;"><i class="bx bx-spreadsheet"></i> Marks Entry Section</h6>
                </div>

                <div id="marksEntryContainer">
                    <!-- Dynamic rows will be added here -->
                </div>

                <button type="button" class="btn btn-add-row" onclick="addMarksEntryRow()">
                    <i class="bx bx-plus-circle"></i> Add Row
                </button>

                <!-- Add Grade Marks Section (Dynamic) -->
                <div id="gradeMarksContainer">
                    <div class="grade-marks-section">
                        <h5>Add Grade Marks</h5>
                        
                        <div id="gradeSectionsContainer">
                            <!-- Dynamic grade sections will be added here -->
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-update-grading">
                        <i class="bx bx-save"></i> Update Grading
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    let marksEntryRowCounter = 0;
    let marksEntrySections = [];

    // Add initial marks entry row on page load
    $(document).ready(function() {
        // Auto-add one row on load
        addMarksEntryRow();
    });

    // Add Marks Entry Row
    function addMarksEntryRow() {
        marksEntryRowCounter++;
        const rowId = 'marks-entry-' + marksEntryRowCounter;
        
        const rowHtml = `
            <div class="marks-entry-row" id="${rowId}" data-row-id="${marksEntryRowCounter}">
                <select name="title[]" 
                        class="form-select marks-entry-title form-control" 
                        data-row-id="${marksEntryRowCounter}"
                        required
                        onchange="updateGradeSections()">
                    <option value="" disabled selected>Select Title</option>
                    <option value="College Marks">College Marks</option>
                    <option value="Industry Marks">Industry Marks</option>
                </select>
                <input type="number" name="marks[]" 
                       class="form-control marks-entry-marks" 
                       placeholder="Marks (e.g., 80, 20)" 
                       data-row-id="${marksEntryRowCounter}"
                       required
                       onchange="updateGradeSections()">
                <button type="button" class="btn-delete-row" onclick="deleteMarksEntryRow('${rowId}', ${marksEntryRowCounter})">
                    <i class="bx bx-trash"></i>
                </button>
            </div>
        `;
        
        $('#marksEntryContainer').append(rowHtml);
    }

    // Delete Marks Entry Row
    function deleteMarksEntryRow(rowId, counter) {
        $('#' + rowId).fadeOut(300, function() {
            $(this).remove();
            updateGradeSections();
        });
    }

    // Update Grade Sections based on Marks Entry
    function updateGradeSections() {
        const entries = [];
        
        $('.marks-entry-row').each(function() {
            const rowId = $(this).data('row-id');
            const title = $(this).find('.marks-entry-title').val();
            const marks = $(this).find('.marks-entry-marks').val();
            
            if (title && marks) {
                entries.push({
                    id: rowId,
                    title: title,
                    marks: marks
                });
            }
        });
        
        marksEntrySections = entries;
        
        if (entries.length > 0) {
            $('#gradeMarksContainer').slideDown();
            renderGradeSections();
        } else {
            $('#gradeMarksContainer').slideUp();
        }
    }

    // Render Grade Sections
    function renderGradeSections() {
        let html = '';
        
        marksEntrySections.forEach((section, index) => {
            html += `
                <div class="mb-4">
                    <div class="grade-section-header">
                        ${section.title} Section Marks - ${section.marks}
                    </div>
                    <div id="grade-section-${section.id}" class="grade-criteria-container">
                        <!-- Initial criterion row -->
                        <div class="grade-criterion-row" data-section-id="${section.id}" data-criterion-index="0">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label" style="font-size: 13px;">Title</label>
                                    <input type="text" class="form-control" placeholder="Title" style="height: 42px;">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" style="font-size: 13px;">Select Type</label>
                                    <select class="form-select" style="height: 42px;">
                                        <option value="">Select Type</option>
                                        <option value="number">Number</option>
                                        <option value="percentage">Percentage</option>
                                        <option value="grade">Grade</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" style="font-size: 13px;">Marks</label>
                                    <input type="number" class="form-control" placeholder="Marks (e.g. 10)" style="height: 42px;">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" style="font-size: 13px;">Action</label>
                                    <button type="button" class="btn-delete-row" style="width: 100%; height: 42px;" onclick="deleteGradeCriterion(this)">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-add-criterion" onclick="addGradeCriterion(${section.id})">
                        <i class="bx bx-plus-circle"></i> Add Criterion
                    </button>
                </div>
            `;
        });
        
        $('#gradeSectionsContainer').html(html);
    }

    // Add Grade Criterion
    function addGradeCriterion(sectionId) {
        const container = $(`#grade-section-${sectionId}`);
        const criterionCount = container.find('.grade-criterion-row').length;
        
        const criterionHtml = `
            <div class="grade-criterion-row" data-section-id="${sectionId}" data-criterion-index="${criterionCount}">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label" style="font-size: 13px;">Title</label>
                        <input type="text" class="form-control" placeholder="Title" style="height: 42px;">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="font-size: 13px;">Select Type</label>
                        <select class="form-select" style="height: 42px;">
                            <option value="College">Given By College</option>
                            <option value="Company">Given By Company</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="font-size: 13px;">Marks</label>
                        <input type="number" class="form-control" placeholder="Marks (e.g. 10)" style="height: 42px;">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="font-size: 13px;">Action</label>
                        <button type="button" class="btn-delete-row" style="width: 100%; height: 42px;" onclick="deleteGradeCriterion(this)">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        container.append(criterionHtml);
    }

    // Delete Grade Criterion
    function deleteGradeCriterion(button) {
        $(button).closest('.grade-criterion-row').fadeOut(300, function() {
            $(this).remove();
        });
    }

    // Form Submission
    $('#gradeManagementForm').on('submit', function(e) {
        e.preventDefault();
        
        const courseId = $('#courseSelect').val();
        const totalMarks = $('#totalMarks').val();
        
        if (!courseId) {
            alert('Please select a course');
            return;
        }
        
        if (!totalMarks) {
            alert('Please enter total marks');
            return;
        }
        
        if (marksEntrySections.length === 0) {
            alert('Please add at least one marks entry section');
            return;
        }
        
        // Collect all grade criteria
        const gradeData = [];
        
        $('.grade-criterion-row').each(function() {
            const sectionId = $(this).data('section-id');
            const title = $(this).find('input[type="text"]').val();
            const type = $(this).find('select').val();
            const marks = $(this).find('input[type="number"]').val();
            
            if (title && type && marks) {
                gradeData.push({
                    section_id: sectionId,
                    title: title,
                    type: type,
                    marks: marks
                });
            }
        });
        
        const formData = {
            course_id: courseId,
            total_marks: totalMarks,
            marks_sections: marksEntrySections,
            grade_criteria: gradeData
        };
        
        console.log('Form Data:', formData);
        
        // In production, send to server
        // $.ajax({
        //     url: '/admin/manage-grade/store',
        //     method: 'POST',
        //     data: formData,
        //     success: function(response) {
        //         alert('Grade management updated successfully!');
        //         window.location.href = '/admin/manage-grade';
        //     },
        //     error: function(error) {
        //         alert('Error updating grade management');
        //     }
        // });
        
        alert('✅ Grade management data collected successfully!\n\nData:\n' + JSON.stringify(formData, null, 2));
    });
</script>
@endpush
