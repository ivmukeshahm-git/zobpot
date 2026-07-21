@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "Location-PinCode";
    </script>


    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Product List Table -->
        <div class="card">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Pin Code</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        @can('Zipcode-Add')
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#PincodeAdd"><i class='bx bx-plus'></i> Add</button>
                        @endcan
                    </div>
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="PinCodeDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>State Name</th>
                            <th>City Name</th>
                            <th>Area Name</th>
                            <th>PinCode Name</th>
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
    <div class="modal fade" id="PincodeAdd" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form id="pincode-form" class="modal-content" onsubmit="return false;">
                <div class="modal-header">
                    <h5 class="modal-title" id="PincodeAddTitle">Add PinCode</h5>
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

                        <div class="col-lg-12 mb-4">
                            <label for="nameBackdrop" class="form-label mb-2">Area</label>
                            <select name="area_id" class="select2 form-select" id="area_id">
                            </select>
                        </div>


                        <div class="col-lg-12">
                            <label for="nameBackdrop" class="form-label mb-2">Pincode Name</label>
                            <input type="text" id="pincode" name="pincode" class="form-control"
                                placeholder="Enter Pincode" />
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
            var datatable = $('#PinCodeDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.pincode.gettabledata') }}",
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
                        data: 'zipcode',
                        name: 'zipcode'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ]
            });


            $('#PinCodeDataTable tbody').on('click', '.view-details-btn', function() {
                var $row = $(this).closest('tr');
                var rowData = datatable.row($row).data();

                // Open modal
                $("#PincodeAdd").modal("show");

                // Reset dropdowns
                $("#city_id").html('<option value="">Select City</option>');
                $("#area_id").html('<option value="">Select Area</option>');

                // Set state
                $("#state_id").val(rowData.state_id).trigger('change');

                // CSRF Token
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Load cities
                $.post("{{ route('admin.pincode.get_city') }}", {
                    state_id: rowData.state_id
                }, function(response) {
                    if (response.status === 1) {
                        let cityOptions = `<option value="">Select City</option>`;
                        response.data.forEach(val => {
                            cityOptions +=
                                `<option value="${val.city_id}">${val.city_nm}</option>`;
                        });
                        $("#city_id").html(cityOptions);
                        $("#city_id").val(rowData.city_id).trigger('change');
                    } else {
                        toastr.warning(response.message, 'Warning');
                    }
                });

                // Load areas
                $.post("{{ route('admin.pincode.get_area') }}", {
                    city_id: rowData.city_id
                }, function(response) {
                    if (response.status === 1) {
                        let areaOptions = `<option value="">Select Area</option>`;
                        response.data.forEach(val => {
                            areaOptions +=
                                `<option value="${val.area_id}">${val.area_nm}</option>`;
                        });
                        $("#area_id").html(areaOptions);
                        $("#area_id").val(rowData.area_id).trigger('change');
                    } else {
                        toastr.warning(response.message, 'Warning');
                    }
                });

                // Fill form fields
                $("#pincode").val(rowData.zipcode);
                $("#flag").val("U");
                $("#row_id").val(rowData.zipcode_id);
                $("#_method").val("PUT");
            });



            $('#PinCodeDataTable tbody').on('click', '.delete-pincode-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object


                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Are you sure to delete Zipcode?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, confirm!',
                        customClass: {
                            confirmButton: 'btn btn-primary me-3',
                            cancelButton: 'btn btn-label-secondary'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            var AreaId = rowData.zipcode_id;
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
                                url: "{{ url('admin/pincode') }}/" + AreaId,
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




            $('#PincodeAdd').on('hidden.bs.modal', function() {
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


                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.pincode.get_city') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
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
                        toastr.error("Something went wrong while fetching City.",
                            "Error");
                    }
                });
            });


            $('#city_id').on('change', function() {
                let city_id = $(this).val();

                if (!city_id) return;

                // Prepare request data
                let data = {
                    city_id: city_id
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.pincode.get_area') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 1) {
                            toastr.success(response.message, 'Success');

                            let area = response.data;

                            // Start with default option (corrected quotes)
                            let optionHtml = `<option value="">Select Area</option>`;

                            // Append subcategory options
                            area.forEach(val => {
                                optionHtml +=
                                    `<option value="${val.area_id}">${val.area_nm}</option>`;
                            });

                            // Populate dropdown
                            $("#area_id").html(optionHtml);
                        } else {
                            toastr.warning(response.message, 'Warning');
                            $("#area_id").html(
                                `<option value="">No Area Found</option>`);
                        }
                    },
                    error: function() {
                        toastr.error("Something went wrong while fetching Area.",
                            "Error");
                    }
                });
            });

        });






        let validator = $("#pincode-form").validate({
            rules: {
                state_id: {
                    required: true
                },
                city_id: {
                    required: true
                },
                area_id: {
                    required: true
                },
                pincode: {
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
                area_id: {
                    required: "Please Select Area"
                },
                pincode: {
                    required: "Please Enter Pincode"
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
        $("#pincode-form").submit(function(e) {
            e.preventDefault();

            if (!$("#pincode-form").valid()) {
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
                url = "{{ route('admin.pincode.store') }}";
            } else {
                url = "{{ url('admin/pincode') }}/" + id;
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
