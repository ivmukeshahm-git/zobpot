@push('css')
    <style>
        .job-type-select {
            border: 1px solid #e0e0e0;
            border-radius: 13px;
            box-shadow: 12px 12px 5px #eee;
            cursor: pointer;
        }

        .select-job {
            border: 1px solid #242a62;
        }

    </style>
@endpush


@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "Master-Category";
    </script>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Product List Table -->
        <div class="card">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Job Category</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        @can('Category-Add')
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#JobCategory"><i class='bx bx-plus'></i> Add</button>
                        @endcan
                    </div>
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="JobCategoryDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Preference Type</th>
                            <th>Category Name</th>
                            <th>Category Image</th>
                            <th>Action</th>
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
    <div class="modal fade" id="JobCategory" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form id="job-category-form" class="modal-content" onsubmit="return false;">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="JobCategoryTitle">Add Job Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-lg-6 col-md-4 col-4">
                            <div class="job-type-select select-job" id="noneskill" onclick="SelectJobType('Non-Skilled')">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-4">
                                        <img src="{{ asset('assets/imgs/noneskill.png') }}" alt="Non Skilled"
                                            style="max-width: 100%;">
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-8" style="align-content: center;">
                                        <h4 class="mb-0"><b>Non Skilled</b></h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-4 col-4">
                            <div class="job-type-select" id="skill" onclick="SelectJobType('Skilled')">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-4">
                                        <img src="{{ asset('assets/imgs/noneskill.png') }}" alt="Skilled"
                                            style="max-width: 100%;">
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-8" style="align-content: center;">
                                        <h4 class="mb-0"><b>Skilled</b></h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <input type="hidden" id="job_preference_type" name="job_preference_type" value="2">
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12 mb-3">
                            <label for="nameBackdrop" class="form-label mb-2">Category Name</label>
                            <input type="text" id="category_nm" name="category_nm" class="form-control"
                                placeholder="Enter Category Name" />
                        </div>

                        <div class="col-lg-12 col-md-12 col-12 mb-3">
                            <label for="nameBackdrop" class="form-label mb-2">Category Icon Image (100 X 100)</label>
                            <input type="file" id="category_image" name="category_image" class="form-control" />
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
        function SelectJobType(type) {
            $('.job-type-select').removeClass('select-job');

            if (type === 'Non-Skilled') {
                $('#noneskill').addClass('select-job');
                $("#job_preference_type").val('2');
            } else if (type === 'Skilled') {
                $('#skill').addClass('select-job');
                $("#job_preference_type").val('1');
            }
        }



        $(document).ready(function() {
            var datatable = $('#JobCategoryDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.job-category.gettabledata') }}",
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
                        data: 'preference_type_name',
                        name: 'preference_type_name'
                    },
                    {
                        data: 'category_nm',
                        name: 'category_nm'
                    },
                    {
                        data: 'images',
                        name: 'images'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ]
            });


            $('#JobCategoryDataTable tbody').on('click', '.view-details-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object

                    var preference_type = rowData.preference_type;
                    $('.job-type-select').removeClass('select-job');
                    if (preference_type == 1) {
                        $('#skill').addClass('select-job');
                    } else {
                        $('#noneskill').addClass('select-job');
                    }

                    $("#job_preference_type").val(preference_type);

                    $("#JobCategory").modal("show");
                    $("#category_nm").val(rowData.category_nm);
                    $("#flag").val("U");
                    $("#row_id").val(rowData.category_id);
                    $("#_method").val("PUT");
                });

            $('#JobCategoryDataTable tbody').on('click', '.delete-cetegory-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object


                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Are you sure to delete job category?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, confirm!',
                        customClass: {
                            confirmButton: 'btn btn-primary me-3',
                            cancelButton: 'btn btn-label-secondary'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            var categoryId = rowData.category_id;
                            var data = {
                                'categoryId': categoryId
                            }

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            LoaderShow()

                            $.ajax({
                                type: "DELETE",
                                url: "{{ url('admin/job-category') }}/" + categoryId,
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




            $('#JobCategory').on('hidden.bs.modal', function() {
                $("#_method").val("POST");
            });

        });



        let validator = $("#job-category-form").validate({
            rules: {
                category_nm: {
                    required: true
                },
                category_image: {
                    required: function(element) {
                        return $('#flag').val() === 'A';
                    }
                },

            },
            messages: {
                category_nm: {
                    required: "Please Enter Category Name"
                },
                category_image: {
                    required: "Please Upload Category Image"
                }
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
        $("#job-category-form").submit(function(e) {
            e.preventDefault();

            if (!$("#job-category-form").valid()) {
                return;
            }

            let form = $(this)[0]; // ✅ Native DOM element
            let formData = new FormData(form); // ✅ Handles text + file inputs
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var flag = $("#flag").val();

            var id = $("#row_id").val();
            var url = "";
            if (flag == "A") {
                url = "{{ route('admin.job-category.store') }}";
            } else {
                url = "{{ url('admin/job-category') }}/" + id;
            }

            LoaderShow()

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false, // ✅ Important for FormData
                contentType: false, // ✅ Important for FormData
                success: function(response) {
                    LoaderHide()
                    if (response.status === 1) {
                        toastr.success(response.message, 'Success');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
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
    </script>
@endpush
