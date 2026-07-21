@push('css')
    <style>
        .skill-add-box {
            border: 1px solid #e6e6e6;
            padding: 10px;
            border-radius: 7px;
            background-color: #e9e9e9;
        }
    </style>
@endpush

@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "Master-Skill";
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Product List Table -->
        <div class="card">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Skill</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        @can('Skills-Add')
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#SkillAdd"><i class='bx bx-plus'></i> Add</button>
                        @endcan
                    </div>
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="SkillDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th style="width:10%;">Sr. NO.</th>
                            <th style="width:20%;">Category</th>
                            <th style="width:20%;">Sub Category</th>
                            <th style="width:40%;">Skills</th>
                            <th style="width:10%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->


    <!-- Modal -->
    <div class="modal fade" id="SkillAdd" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form id="skill-form" class="modal-content" onsubmit="return false;">
                <div class="modal-header">
                    <h5 class="modal-title" id="SkillAddTitle">Add Skill</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="nameBackdrop" class="form-label mb-2">Category</label>
                            <select name="category_id" id="category_id" class="select2 form-select">
                                <option value="" selected>-Select Category-</option>
                                @foreach ($Category as $row)
                                    <option value="{{ $row->category_id }}">{{ $row->category_nm }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label for="nameBackdrop" class="form-label mb-2">Sub Category</label>
                            <select class="select2 form-select" name="sub_category_id" id="sub_category_id">


                            </select>
                        </div>

                        <div class="col-lg-12">
                            <div class="mt-2">
                                <label for="nameBackdrop" class="form-label mb-2">
                                    Skill <span style="color:red;">*</span>
                                </label>
                                <div class="skill-add-box" id="SkillHtmlRows">
                                    <div class="row mb-4 benefit-row">
                                        <div class="col-lg-10">
                                            <input type="text" name="skills[]" class="form-control"
                                                placeholder="Enter Skill Name" style="background-color: #fff;">
                                        </div>
                                        <div class="col-lg-1">
                                            <button type="button" class="btn btn-sm btn-primary p-2 add-benefit">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>


                    <input type="hidden" id="_method" name="_method" value="POST">
                    <input type="hidden" id="flag" name="flag" value="A">
                    <input type="hidden" id="row_id" name="row_id">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('script')
    <script>
        $(document).ready(function() {
            var datatable = $('#SkillDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.skills.gettabledata') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = '{{ csrf_token() }}'; // Required for POST in Laravel
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'category_nm',
                        name: 'category_nm'
                    },
                    {
                        data: 'sub_category_nm',
                        name: 'sub_category_nm'
                    },
                    {
                        data: 'skills',
                        name: 'skills'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ]
            });


            $('#SkillDataTable tbody').on('click', '.view-details-btn',
                function() { // Delegated event handler for the button
                    $("#SkillHtmlRows").html("");
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object

                    $("#SkillAdd").modal("show");
                    $("#category_id").val(rowData.category_id).trigger('change');

                    let SkillS_arr = rowData.skill_nm.split(',');
                    let SkillHtmlRows = '';


                    SkillHtmlRows = `<div class="row mb-4 benefit-row">
                                        <div class="col-lg-10">
                                            <input type="text" name="skills[]" class="form-control"
                                                placeholder="Enter Skill Name" style="background-color: #fff;">
                                        </div>
                                        <div class="col-lg-1">
                                            <button type="button" class="btn btn-sm btn-primary p-2 add-benefit">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>`;

                    SkillS_arr.forEach(skill => {
                        skill = skill.trim(); // remove extra spaces
                        SkillHtmlRows += `
        <div class="row mb-4 benefit-row">
            <div class="col-lg-10">
                <input type="text" class="form-control" name="skills[]" value="${skill}" placeholder="Enter Skill Name" style="background-color: #fff;">
            </div>
            <div class="col-lg-1">
                <button type="button" class="btn btn-sm btn-danger p-2 remove-benefit">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    `;
                    });

                    // Append to container
                    $("#SkillHtmlRows").append(SkillHtmlRows);
                    let data = {
                        category_id: rowData.category_id
                    };

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });



                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.skills.get_sub_category') }}",
                        data: data,
                        dataType: "json",
                        success: function(response) {
                            if (response.status === 1) {
                                toastr.success(response.message, 'Success');

                                let subcategory = response.data;

                                // Start with default option (corrected quotes)
                                let optionHtml = `<option value="">Select Sub Category</option>`;

                                // Append subcategory options
                                subcategory.forEach(val => {
                                    optionHtml +=
                                        `<option value="${val.sub_category_id}">${val.sub_category_nm}</option>`;
                                });

                                // Populate dropdown
                                $("#sub_category_id").html(optionHtml);

                                setTimeout(function() {
                                    $("#sub_category_id").val(rowData.sub_category_id)
                                        .trigger('change');
                                }, 500);


                            } else {
                                toastr.warning(response.message, 'Warning');
                                $("#sub_category_id").html(
                                    `<option value="">No Sub Category Found</option>`);
                            }
                        },
                        error: function() {
                            toastr.error("Something went wrong while fetching sub categories.",
                                "Error");
                        }
                    });



                    $("#category_id").val(rowData.category_id).trigger('change');
                    $("#flag").val("U");
                    $("#row_id").val(rowData.id);
                    $("#_method").val("PUT");
                });

            $('#SkillDataTable tbody').on('click', '.delete-skill-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object


                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Are you sure to delete Skill?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, confirm!',
                        customClass: {
                            confirmButton: 'btn btn-primary me-3',
                            cancelButton: 'btn btn-label-secondary'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            var SkillId = rowData.id;
                            var data = {
                                'SkillId': SkillId
                            }

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            LoaderShow()

                            $.ajax({
                                type: "DELETE",
                                url: "{{ url('admin/skills') }}/" + SkillId,
                                data: data,
                                dataType: "json",
                                success: function(response) {
                                    LoaderHide()
                                    if (response.status === 1) {
                                        toastr.success(response.message, 'Success');


                                        location.reload();
                                    } else {
                                        toastr.warning(response.message, 'Warning');
                                    }
                                }
                            });
                            return false;
                        }
                    });
                });




            $('#SkillAdd').on('hidden.bs.modal', function() {
                $("#_method").val("POST");
            });


            $('#category_id').on('change', function() {
                let category_id = $(this).val();

                if (!category_id) return;

                // Prepare request data
                let data = {
                    category_id: category_id
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.skills.get_sub_category') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 1) {
                            toastr.success(response.message, 'Success');

                            let subcategory = response.data;

                            // Start with default option (corrected quotes)
                            let optionHtml = `<option value="">Select Sub Category</option>`;

                            // Append subcategory options
                            subcategory.forEach(val => {
                                optionHtml +=
                                    `<option value="${val.sub_category_id}">${val.sub_category_nm}</option>`;
                            });

                            // Populate dropdown
                            $("#sub_category_id").html(optionHtml);
                        } else {
                            toastr.warning(response.message, 'Warning');
                            $("#sub_category_id").html(
                                `<option value="">No Sub Category Found</option>`);
                        }
                    },
                    error: function() {
                        toastr.error("Something went wrong while fetching sub categories.",
                            "Error");
                    }
                });
            });

        });




        let validator = $("#skill-form").validate({
            rules: {
                category_id: {
                    required: true
                },
                sub_category_id: {
                    required: true
                },
            },
            messages: {
                category_id: {
                    required: "Please Select Category"
                },
                sub_category_id: {
                    required: "Please Select Sub Category"
                },
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                error.insertAfter(element);
            },
            highlight: function(element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            }
        });

        // ✅ Final submission with AJAX
        $("#skill-form").submit(function(e) {
            e.preventDefault();

            if (!$("#skill-form").valid()) {
                return;
            }

            let form = $(this);
            // let url = form.attr('action');
            let formData = form.serialize(); // Use FormData for file uploads

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var flag = $("#flag").val();

            var id = $("#row_id").val();
            var url = "";
            if (flag == "A") {
                url = "{{ route('admin.skills.store') }}";
            } else {
                url = "{{ url('admin/skills') }}/" + id;
            }

            LoaderShow()

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(response) {
                    LoaderHide()
                    if (response.status === 1) {
                        toastr.success(response.message, 'Success');
                        form[0].reset();
                        validator.resetForm();

                        location.reload();
                    } else {
                        toastr.warning(response.message, 'Warning');
                    }
                },
                error: function(xhr) {
                    LoaderHide()
                    console.log(xhr.responseText);
                    toastr.error(response.message, 'Error');
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const benefitsBox = document.querySelector(".skill-add-box");

            benefitsBox.addEventListener("click", function(e) {
                if (e.target.closest(".add-benefit")) {
                    const newBenefitRow = document.createElement("div");
                    newBenefitRow.classList.add("row", "mb-4", "benefit-row");
                    newBenefitRow.innerHTML = `
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="skills[]" placeholder="Enter Skill Name" style="background-color: #fff;">
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-sm btn-danger p-2 remove-benefit">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                `;
                    benefitsBox.appendChild(newBenefitRow);
                }

                if (e.target.closest(".remove-benefit")) {
                    e.target.closest(".benefit-row").remove();
                }
            });
        });
    </script>
@endpush
