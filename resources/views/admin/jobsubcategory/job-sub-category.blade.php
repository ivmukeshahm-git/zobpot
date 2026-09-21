@extends('admin.layout.layout')
@section('content')
  <script>
      page_active_id = "Master-SubCategory";
  </script>
    <div class="container-xxl flex-grow-1 container-p-y">
        <ul class="nav nav-tabs mb-3" id="jobSubCategoryTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="subcategories-tab" data-bs-toggle="tab" data-bs-target="#subcategories-panel" type="button" role="tab">Sub Categories</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="subcategory-requests-tab" data-bs-toggle="tab" data-bs-target="#subcategory-requests-panel" type="button" role="tab">Requests</button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="subcategories-panel" role="tabpanel">
        <!-- Product List Table -->
        <div class="card">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Job Sub Category</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        @can('SubCategory-Add')
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#JobSubCategory"><i class='bx bx-plus'></i> Add</button>
                        @endcan
                    </div>
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="JobSubCategoryDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Category Name</th>
                            <th>Sub Category Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
            </div>

            <div class="tab-pane fade" id="subcategory-requests-panel" role="tabpanel">
                <div class="card">
                    <div class="card-header p-4">
                        <h5 class="card-title mb-0">Sub Category Requests</h5>
                    </div>
                    <hr class="my-1">
                    <div class="card-body table-responsive p-4">
                        <table id="JobSubCategoryRequestsDataTable" class="table table-sm table-striped table-hover">
                            <thead class="border-top">
                                <tr>
                                    <th>Sr. NO.</th>
                                    <th>Category Name</th>
                                    <th>Requested Sub Category</th>
                                    <th>Company Name</th>
                                    <th>Company Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
    </div>


    <!-- Modal -->
    <div class="modal fade" id="JobSubCategory" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form id="job-sub-category-form" class="modal-content" onsubmit="return false;">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="JobSubCategoryTitle">Add State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label for="nameBackdrop" class="form-label mb-2">Category</label>
                            <select name="category_id" class="select2 form-select" id="category_id">
                                <option value="" selected>-Select Category-</option>
                                @foreach ($JobCategory as $row)
                                    <option value="{{ $row->category_id }}">{{ $row->category_nm }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-lg-12">
                            <label for="nameBackdrop" class="form-label mb-2">Sub Category Name</label>
                            <input type="text" id="sub_category_nm" name="sub_category_nm" class="form-control"
                                placeholder="Enter Sub Category Name" />
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
            var datatable = $('#JobSubCategoryDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.job-sub-category-datatable.gettabledata') }}",
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
                        name: 'category_nm',
                    },
                    {
                        data: 'sub_category_nm',
                        name: 'sub_category_nm'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ]
            });


            $('#JobSubCategoryDataTable tbody').on('click', '.view-details-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object

                    $("#JobSubCategory").modal("show");
                    $("#sub_category_nm").val(rowData.sub_category_nm);
                    $("#flag").val("U");
                    $("#row_id").val(rowData.sub_category_id);
                    $("#_method").val("PUT");
                    $("#category_id").val(rowData.category_id).trigger('change');
                });

            $('#JobSubCategoryDataTable tbody').on('click', '.delete-sub-cetegory-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object


                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Are you sure to delete sub category?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, confirm!',
                        customClass: {
                            confirmButton: 'btn btn-primary me-3',
                            cancelButton: 'btn btn-label-secondary'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            var subCategoryId = rowData.sub_category_id;
                            var data = {
                                'subCategoryId': subCategoryId
                            }

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });


                            LoaderShow()

                            $.ajax({
                                type: "DELETE",
                                url: "{{ url('admin/job-sub-category') }}/" + subCategoryId,
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




            $('#JobSubCategory').on('hidden.bs.modal', function() {
                $("#_method").val("POST");
            });

            var subRequestsDatatable = $('#JobSubCategoryRequestsDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.job-sub-category.requests.gettabledata') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = '{{ csrf_token() }}';
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'category_nm', name: 'category_nm' },
                    { data: 'requested_name', name: 'requested_name' },
                    { data: 'company_name', name: 'company_name' },
                    { data: 'company_email', name: 'company_email' },
                    { data: 'status_label', name: 'status_label', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $('#JobSubCategoryRequestsDataTable').on('click', '.approve-subcategory-request-btn', function() {
                var requestId = $(this).data('id');
                Swal.fire({
                    title: 'Approve Request?',
                    text: 'This will create a new job sub category.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Approve',
                    customClass: {
                        confirmButton: 'btn btn-success me-3',
                        cancelButton: 'btn btn-label-secondary'
                    }
                }).then(function(result) {
                    if (!result.isConfirmed) return;
                    LoaderShow();
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('admin/job-sub-category-requests') }}/" + requestId + "/approve",
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            LoaderHide();
                            if (response.status === 1) {
                                toastr.success(response.message, 'Success');
                                subRequestsDatatable.ajax.reload(null, false);
                                datatable.ajax.reload(null, false);
                            } else {
                                toastr.warning(response.message, 'Warning');
                            }
                        },
                        error: function(xhr) {
                            LoaderHide();
                            toastr.error(xhr.responseJSON?.message || 'Failed to approve request', 'Error');
                        }
                    });
                });
            });

            $('#JobSubCategoryRequestsDataTable').on('click', '.reject-subcategory-request-btn', function() {
                var requestId = $(this).data('id');
                Swal.fire({
                    title: 'Reject Request?',
                    text: 'This request will be marked as rejected.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Reject',
                    customClass: {
                        confirmButton: 'btn btn-danger me-3',
                        cancelButton: 'btn btn-label-secondary'
                    }
                }).then(function(result) {
                    if (!result.isConfirmed) return;
                    LoaderShow();
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('admin/job-sub-category-requests') }}/" + requestId + "/reject",
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            LoaderHide();
                            if (response.status === 1) {
                                toastr.success(response.message, 'Success');
                                subRequestsDatatable.ajax.reload(null, false);
                                datatable.ajax.reload(null, false);
                            } else {
                                toastr.warning(response.message, 'Warning');
                            }
                        },
                        error: function(xhr) {
                            LoaderHide();
                            toastr.error(xhr.responseJSON?.message || 'Failed to reject request', 'Error');
                        }
                    });
                });
            });

        });



        let validator = $("#job-sub-category-form").validate({
            rules: {
                category_id: {
                    required: true
                },
                sub_category_nm: {
                    required: true
                },
            },
            messages: {
                category_id: {
                    required: "Please Select Category"
                },
                sub_category_nm: {
                    required: "Please Enter Sub Category Name"
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
        $("#job-sub-category-form").submit(function(e) {
            e.preventDefault();

            if (!$("#job-sub-category-form").valid()) {
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
                url = "{{ route('admin.job-sub-category.store') }}";
            } else {
                url = "{{ url('admin/job-sub-category') }}/" + id;
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
    </script>
@endpush
