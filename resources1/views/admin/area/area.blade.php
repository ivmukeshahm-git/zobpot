@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "Location-Area";
    </script>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Area</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        @can('Area-Add')
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#AreaAdd"><i class='bx bx-plus'></i> Add</button>
                        @endcan
                    </div>
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="AreaDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>State Name</th>
                            <th>City Name</th>
                            <th>Area Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="AreaAdd" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form id="area-form" class="modal-content" onsubmit="return false;">
                <div class="modal-header">
                    <h5 class="modal-title" id="AreaAddTitle">Add Area</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label for="nameBackdrop" class="form-label mb-2">State</label>
                            <select name="state_id" class="select2 form-select" id="state_id">
                                <option value="" selected>-Select State-</option>
                                @foreach ($StateData as $row)
                                    <option value="{{ $row->state_id }}">{{ $row->state_name }}</option>
                                @endforeach

                            </select>
                        </div>



                        <div class="col-lg-12 mb-4">
                            <label for="nameBackdrop" class="form-label mb-2">City</label>
                            <select name="city_id" class="select2 form-select" id="city_id">
                            </select>
                        </div>

                        <div class="col-lg-12">
                            <label for="nameBackdrop" class="form-label mb-2">Area Name</label>
                            <input type="text" id="area_nm" name="area_nm" class="form-control"
                                placeholder="Enter Area Name" />
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
            var datatable = $('#AreaDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.area.gettabledata') }}",
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
                        data: 'state_name',
                        name: 'state_name'
                    },
                    {
                        data: 'city_nm',
                        name: 'city_nm'
                    },
                    {
                        data: 'area_nm',
                        name: 'area_nm'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ]
            });


            $('#AreaDataTable tbody').on('click', '.view-details-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object

                    $("#AreaAdd").modal("show");
                    $("#state_id").val(rowData.state_id).trigger('change');

                    console.log(rowData.state_id);
                    let data = {
                        state_id: rowData.state_id
                    };

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    LoaderShow()

                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.area.get_state') }}",
                        data: data,
                        dataType: "json",
                        success: function(response) {
                            LoaderHide()
                            if (response.status === 1) {
                                toastr.success(response.message, 'Success');

                                let city = response.data;

                                // Start with default option (corrected quotes)
                                let optionHtml = `<option value="">Select City</option>`;

                                // Append subcategory options
                                city.forEach(val => {
                                    optionHtml +=
                                        `<option value="${val.city_id}">${val.city_nm}</option>`;
                                });

                                // Populate dropdown
                                $("#city_id").html(optionHtml);

                                $("#city_id").val(rowData.city_id).trigger('change');
                            } else {
                                toastr.warning(response.message, 'Warning');
                                $("#city_id").html(
                                    `<option value="">No City Found</option>`);
                            }
                        },
                        error: function() {
                            LoaderHide()
                            toastr.error("Something went wrong while fetching City.",
                                "Error");
                        }
                    });



                    $("#area_nm").val(rowData.area_nm);
                    $("#flag").val("U");
                    $("#row_id").val(rowData.area_id);
                    $("#_method").val("PUT");
                });

            $('#AreaDataTable tbody').on('click', '.delete-area-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object


                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Are you sure to delete Area?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, confirm!',
                        customClass: {
                            confirmButton: 'btn btn-primary me-3',
                            cancelButton: 'btn btn-label-secondary'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            var AreaId = rowData.area_id;
                            var data = {
                                'AreaId': AreaId
                            }

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            LoaderShow()

                            $.ajax({
                                type: "DELETE",
                                url: "{{ url('admin/area') }}/" + AreaId,
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


            $('#state_id').on('change', function() {
                let state_id = $(this).val();

                if (!state_id) return;

                // Prepare request data
                let data = {
                    state_id: state_id
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                LoaderShow()

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.area.get_state') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        LoaderHide()
                        if (response.status === 1) {
                            toastr.success(response.message, 'Success');

                            let city = response.data;

                            // Start with default option (corrected quotes)
                            let optionHtml = `<option value="">Select City</option>`;

                            // Append subcategory options
                            city.forEach(val => {
                                optionHtml +=
                                    `<option value="${val.city_id}">${val.city_nm}</option>`;
                            });

                            // Populate dropdown
                            $("#city_id").html(optionHtml);
                        } else {
                            toastr.warning(response.message, 'Warning');
                            $("#city_id").html(
                                `<option value="">No City Found</option>`);
                        }
                    },
                    error: function() {
                        LoaderHide()
                        toastr.error("Something went wrong while fetching City.",
                            "Error");
                    }
                });
            });

        });




        let validator = $("#area-form").validate({
            rules: {
                state_id: {
                    required: true
                },
                city_id: {
                    required: true
                },
                area_nm: {
                    required: true
                },
            },
            messages: {
                state_id: {
                    required: "Please Select State"
                },
                city_id: {
                    required: "Please Select City"
                },
                area_nm: {
                    required: "Please Enter Area"
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
        $("#area-form").submit(function(e) {
            e.preventDefault();

            if (!$("#area-form").valid()) {
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
                url = "{{ route('admin.area.store') }}";
            } else {
                url = "{{ url('admin/area') }}/" + id;
            }

            LoaderShow()

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(response) {
                    console.log(response);
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
