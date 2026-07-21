@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "ManageGrade";
</script>

<style>
    .grade-form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 25px;
        overflow: hidden;
    }

    .card-header-custom {
        background: linear-gradient(135deg, #242a62 0%, #1a1f4a 100%);
        padding: 20px 25px;
        border-bottom: 3px solid #f26e2c;
    }

    .card-header-custom h5 {
        color: white;
        margin: 0;
        font-size: 18px;
        font-weight: 700;
    }

    .card-body-custom {
        padding: 30px;
    }

    .form-label-custom {
        font-weight: 600;
        color: #2c3e50;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .form-control-custom {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control-custom:focus {
        border-color: #242a62;
        box-shadow: 0 0 0 0.2rem rgba(36, 42, 98, 0.1);
    }

    .section-row {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        border-left: 4px solid #f26e2c;
    }

    .criteria-block {
        background: #ffffff;
        border: 2px solid #dee2e6;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .criteria-block-header {
        background: #242a62;
        color: white;
        padding: 12px 15px;
        border-radius: 8px 8px 0 0;
        margin: -20px -20px 15px -20px;
        font-weight: 600;
        font-size: 15px;
    }

    .criteria-row {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 10px;
        border-left: 3px solid #28a745;
    }

    .btn-add-row {
        background: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-add-row:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .btn-remove {
        background: #dc3545;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 5px;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .btn-remove:hover {
        background: #c82333;
    }

    .btn-save-grade {
        background: #242a62;
        color: white;
        border: none;
        padding: 12px 40px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(36, 42, 98, 0.3);
    }

    .btn-save-grade:hover {
        background: #1a1f4a;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(36, 42, 98, 0.4);
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
        border: none;
        padding: 12px 40px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #5a6268;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="grade-page-header" style="background: #242a62; padding: 25px 30px; border-radius: 12px; margin-bottom: 30px;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 style="color: white; margin: 0; font-size: 26px; font-weight: 700;">
                    <i class="bx bx-plus-circle"></i> Add Grade Configuration
                </h4>
                <p style="color: rgba(255, 255, 255, 0.9); margin: 5px 0 0 0;">
                    Configure grade system for {{ $college->college_name }}
                </p>
            </div>
            <a href="{{ route('admin.manage-grade.index') }}" class="btn btn-light">
                <i class="bx bx-arrow-back"></i> Back to List
            </a>
        </div>
    </div>

    <form id="gradeForm">
        @csrf
        <input type="hidden" name="college_id" value="{{ $college->id }}">
        <input type="hidden" name="grade_id" id="gradeId" value="">

        <!-- Basic Information Section -->
        <div class="grade-form-card">
            <div class="card-header-custom">
                <h5><i class="bx bx-info-circle"></i> Basic Information</h5>
            </div>
            <div class="card-body-custom">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Select Course <span class="text-danger">*</span></label>
                        <select name="course_id" id="courseSelect" class="form-control form-control-custom" required>
                            <option value="">-- Select Course --</option>
                            @if(isset($courses) && $courses->count() > 0)
                                @foreach($courses as $course)
                                    <option value="{{ $course->degree_id }}">{{ $course->degree_name }}</option>
                                @endforeach
                            @else
                                <option value="" disabled>No degrees configured for this college</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Total Marks <span class="text-danger">*</span></label>
                        <input type="number" name="total_marks" id="totalMarks" class="form-control form-control-custom" 
                               placeholder="Enter total marks" min="1" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Marks Entry Section -->
        <div class="grade-form-card">
            <div class="card-header-custom">
                <h5><i class="bx bx-list-ul"></i> Marks Entry Section</h5>
            </div>
            <div class="card-body-custom">
                <div id="sectionsContainer">
                    <!-- Dynamic Section Rows -->
                </div>
                <button type="button" class="btn btn-add-row" onclick="addSection()">
                    <i class="bx bx-plus"></i> Add Row
                </button>
            </div>
        </div>

        <!-- Grade Criteria Section (Auto-generated) -->
        <div id="gradeCriteriaContainer" style="display: none;">
            <div class="grade-form-card">
                <div class="card-header-custom">
                    <h5><i class="bx bx-star"></i> Add Grade Marks</h5>
                </div>
                <div class="card-body-custom">
                    <div id="criteriaBlocksContainer">
                        <!-- Auto-generated Criteria Blocks -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-4 mb-5">
            <button type="button" class="btn btn-cancel me-3" onclick="window.location='{{ route('admin.manage-grade.index') }}'">
                <i class="bx bx-x"></i> Cancel
            </button>
            <button type="submit" class="btn btn-save-grade">
                <i class="bx bx-save"></i> Save Grade Configuration
            </button>
        </div>
    </form>
</div>

@endsection

@push('script')
<script>
let sectionCounter = 0;
let criteriaCounters = {};

// Add new section row
function addSection() {
    const sectionId = sectionCounter++;
    const html = `
        <div class="section-row" data-section-id="${sectionId}">
            <div class="row align-items-end">
                <div class="col-md-5">
                    <label class="form-label-custom">Title <span class="text-danger">*</span></label>
                    <select name="sections[${sectionId}][title]" class="form-control form-control-custom section-title" required>
                        <option value="" disabled selected>Select Title</option>
                        <option value="College Marks">College Marks</option>
                        <option value="Industry Marks">Industry Marks</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label-custom">Marks <span class="text-danger">*</span></label>
                    <input type="number" name="sections[${sectionId}][marks]" class="form-control form-control-custom section-marks" 
                           placeholder="Enter marks" min="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-remove w-100" onclick="removeSection(${sectionId})">
                        <i class="bx bx-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    `;
    $('#sectionsContainer').append(html);
    updateCriteriaBlocks();
}

// Remove section row
function removeSection(sectionId) {
    $(`.section-row[data-section-id="${sectionId}"]`).remove();
    updateCriteriaBlocks();
}

// Update criteria blocks based on sections
function updateCriteriaBlocks() {
    const sections = [];
    $('.section-row').each(function() {
        const sectionId = $(this).data('section-id');
        const title = $(this).find('.section-title').val();
        const marks = $(this).find('.section-marks').val();
        
        if (title && marks) {
            sections.push({ id: sectionId, title: title, marks: marks });
        }
    });

    if (sections.length > 0) {
        $('#gradeCriteriaContainer').show();
        $('#criteriaBlocksContainer').empty();
        
        sections.forEach((section, index) => {
            const blockHtml = `
                <div class="criteria-block" data-section-index="${index}">
                    <div class="criteria-block-header">
                        ${section.title} - ${section.marks} Marks
                    </div>
                    <div class="criteria-rows-container" id="criteriaRows_${index}">
                        <!-- Criteria rows will be added here -->
                    </div>
                    <button type="button" class="btn btn-add-row btn-sm" onclick="addCriterion(${index}, '${section.title}')">
                        <i class="bx bx-plus"></i> Add Criterion
                    </button>
                </div>
            `;
            $('#criteriaBlocksContainer').append(blockHtml);
            criteriaCounters[index] = 0;
        });
    } else {
        $('#gradeCriteriaContainer').hide();
    }
}

// Add criterion to a section
function addCriterion(sectionIndex, sectionTitle) {
    if (!criteriaCounters[sectionIndex]) {
        criteriaCounters[sectionIndex] = 0;
    }
    const criterionId = criteriaCounters[sectionIndex]++;
    
    const html = `
        <div class="criteria-row" data-criterion-id="${criterionId}">
            <div class="row align-items-end">
                <div class="col-md-5">
                    <label class="form-label-custom" style="margin-bottom: 5px;">Title</label>
                    <input type="text" name="criteria[${sectionIndex}_${criterionId}][title]" 
                           class="form-control form-control-custom" placeholder="e.g., Attendance" required>
                    <input type="hidden" name="criteria[${sectionIndex}_${criterionId}][section_index]" value="${sectionIndex}">
                </div>
                <div class="col-md-5">
                    <label class="form-label-custom" style="margin-bottom: 5px;">Marks</label>
                    <input type="number" name="criteria[${sectionIndex}_${criterionId}][marks]" 
                           class="form-control form-control-custom" placeholder="Enter marks" min="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-remove w-100" onclick="removeCriterion(${sectionIndex}, ${criterionId})">
                        <i class="bx bx-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    `;
    $(`#criteriaRows_${sectionIndex}`).append(html);
}

// Remove criterion
function removeCriterion(sectionIndex, criterionId) {
    $(`#criteriaRows_${sectionIndex} .criteria-row[data-criterion-id="${criterionId}"]`).remove();
}

// Listen to section input/selection changes
$(document).on('change input', '.section-title, .section-marks', function() {
    updateCriteriaBlocks();
});

// Form submission
$('#gradeForm').on('submit', function(e) {
    e.preventDefault();
    
    // Validate at least one section exists
    if ($('.section-row').length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Validation Error',
            text: 'Please add at least one marks entry section'
        });
        return;
    }

    // Collect form data
    const formData = new FormData(this);
    
    // Show loading
    Swal.fire({
        title: 'Saving...',
        text: 'Please wait while we save the grade configuration',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });

    // Submit via AJAX
    $.ajax({
        url: '{{ route("admin.manage-grade.store") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: response.message || 'Grade configuration saved successfully',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '{{ route("admin.manage-grade.index") }}';
            });
        },
        error: function(xhr) {
            let errorMessage = 'An error occurred while saving the grade configuration';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = Object.values(xhr.responseJSON.errors).flat();
                errorMessage += ':\n' + errors.join('\n');
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage
            });
        }
    });
});

// Initialize with one section
$(document).ready(function() {
    // Course change event - fetch existing data if available
    $('#courseSelect').on('change', function() {
        const courseId = $(this).val();
        const collegeId = $('input[name="college_id"]').val();
        
        if (!courseId) {
            resetForm();
            return;
        }
        
        // Fetch existing grade data for this college and course
        $.ajax({
            url: '{{ route("admin.manage-grade.fetch-data") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                college_id: collegeId,
                course_id: courseId
            },
            success: function(response) {
                if (response.success && response.data) {
                    populateExistingData(response.data);
                } else {
                    // No existing data, initialize with empty form
                    resetForm();
                    addSection();
                }
            },
            error: function() {
                // On error, just initialize with empty form
                resetForm();
                addSection();
            }
        });
    });
    
    // Initialize with one section if no course selected
    if (!$('#courseSelect').val()) {
        addSection();
    }
});

// Function to populate form with existing data
function populateExistingData(data) {
    // Clear existing form
    $('#sectionsContainer').empty();
    $('#criteriaBlocksContainer').empty();
    $('#gradeCriteriaContainer').hide();
    
    // Set grade ID for update
    $('#gradeId').val(data.grade_id);
    
    // Set total marks
    $('#totalMarks').val(data.total_marks);
    
    // Reset counters
    sectionCounter = 0;
    criteriaCounters = {};
    
    // Create a map of section_id to section index for criteria
    const sectionIdToIndex = {};
    
    // Populate sections
    data.sections.forEach((section, index) => {
        const sectionId = sectionCounter++;
        sectionIdToIndex[section.id] = sectionId;
        
        const html = `
            <div class="section-row" data-section-id="${sectionId}">
                <div class="row align-items-end">
                    <div class="col-md-5">
                        <label class="form-label-custom">Title <span class="text-danger">*</span></label>
                        <select name="sections[${sectionId}][title]" class="form-control form-control-custom section-title" required>
                            <option value="" disabled ${section.title ? '' : 'selected'}>Select Title</option>
                            <option value="College Marks" ${section.title === 'College Marks' ? 'selected' : ''}>College Marks</option>
                            <option value="Industry Marks" ${section.title === 'Industry Marks' ? 'selected' : ''}>Industry Marks</option>
                            ${section.title !== 'College Marks' && section.title !== 'Industry Marks' ? `<option value="${section.title}" selected>${section.title}</option>` : ''}
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label-custom">Marks <span class="text-danger">*</span></label>
                        <input type="number" name="sections[${sectionId}][marks]" class="form-control form-control-custom section-marks" 
                               placeholder="Enter marks" min="1" value="${section.marks}" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-remove w-100" onclick="removeSection(${sectionId})">
                            <i class="bx bx-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        `;
        $('#sectionsContainer').append(html);
    });
    
    // Trigger criteria blocks generation
    updateCriteriaBlocks();
    
    // Populate criteria
    data.criteria.forEach(criterion => {
        const sectionIndex = sectionIdToIndex[criterion.section_id];
        if (typeof sectionIndex !== 'undefined') {
            if (!criteriaCounters[sectionIndex]) {
                criteriaCounters[sectionIndex] = 0;
            }
            const criterionId = criteriaCounters[sectionIndex]++;
            
            const html = `
                <div class="criteria-row" data-criterion-id="${criterionId}">
                    <div class="row align-items-end">
                        <div class="col-md-5">
                            <label class="form-label-custom" style="margin-bottom: 5px;">Title</label>
                            <input type="text" name="criteria[${sectionIndex}_${criterionId}][title]" 
                                   class="form-control form-control-custom" placeholder="e.g., Attendance" 
                                   value="${criterion.title}" required>
                            <input type="hidden" name="criteria[${sectionIndex}_${criterionId}][section_index]" value="${sectionIndex}">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label-custom" style="margin-bottom: 5px;">Marks</label>
                            <input type="number" name="criteria[${sectionIndex}_${criterionId}][marks]" 
                                   class="form-control form-control-custom" placeholder="Enter marks" 
                                   min="1" value="${criterion.marks}" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-remove w-100" onclick="removeCriterion(${sectionIndex}, ${criterionId})">
                                <i class="bx bx-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            `;
            $(`#criteriaRows_${sectionIndex}`).append(html);
        }
    });
    
    // Update submit button text
    $('.btn-save-grade').html('<i class="bx bx-save"></i> Update Grade Configuration');
    
    // Show success message
    Swal.fire({
        icon: 'info',
        title: 'Existing Data Loaded',
        text: 'Grade configuration already exists for this course. You can update it.',
        timer: 2000,
        showConfirmButton: false
    });
}

// Function to reset form
function resetForm() {
    $('#gradeId').val('');
    $('#totalMarks').val('');
    $('#sectionsContainer').empty();
    $('#criteriaBlocksContainer').empty();
    $('#gradeCriteriaContainer').hide();
    sectionCounter = 0;
    criteriaCounters = {};
    $('.btn-save-grade').html('<i class="bx bx-save"></i> Save Grade Configuration');
}
</script>
@endpush
