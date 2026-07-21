@push('css')
    <style>
        #LoadImgArea {
            display: none;
        }
    </style>
@endpush

@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "AdvertisementBanner";
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Product List Table -->
        <div class="card">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Advertisement Banner</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        @can('AdBanner-Add')
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#JobAdvertisement"><i class='bx bx-plus'></i> Add</button>
                        @endcan
                    </div>
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="AdBannerDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Area Name</th>
                            <th>Image</th>
                            <th>Status</th>
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
    <div class="modal fade" id="JobAdvertisement" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form id="ad-banner-form" onsubmit="return false;" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="JobAdvertisementTitle">Add Advertisement Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="nameBackdrop" class="form-label mb-2">Page Name <span
                                    style="color:red;">*</span></label>
                            <select name="page_name" class="form-control" id="page_name" onchange="SelectPageName()">
                                <option value="" selected>-Select Banner Add Area-</option>
                                <option value="1">Home Page</option>
                                <option value="2">Job View Page</option>
                                <option value="3">Company Profile Page</option>
                                <option value="4">Candidate Profile Page</option>
                            </select>
                        </div>


                        <div class="col-lg-6">
                            <label for="status" class="form-label mb-2">Status <span style="color:red;">*</span></label>
                            <select name="status" class="form-control" id="status">
                                <option value="1">Published</option>
                                <option value="0">Draft</option>
                            </select>
                        </div>



                        <div class="col-lg-12 mt-4">
                            <label for="nameBackdrop" class="form-label mb-2">Ad Link</label>
                            <input type="text" class="form-control" id="ad_link" name="ad_link"
                                placeholder="Enter Add Link">
                        </div>

                        <div class="col-lg-6 mt-4">
                            <label for="nameBackdrop" class="form-label mb-2">Start Date <span
                                    style="color:red;">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date">
                        </div>

                        <div class="col-lg-6 mt-4">
                            <label for="nameBackdrop" class="form-label mb-2">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>

                        <div class="col-lg-12 mt-4">
                            <label for="nameBackdrop" class="form-label mb-2">Image <span
                                    style="color:red;">*</span></label>
                            <input type="file" class="form-control mb-2" id="banner_img" name="banner_img"
                                accept="image/*">
                            <small><b id="ImageSize"></b></small>
                        </div>


                        <div class="col-lg-12 mt-4" id="LoadImgArea">
                            <img src="" alt="" id="LoadBanner" style="max-width: 100%;">
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

                    <input type="hidden" id="img_width" name="img_width">
                    <input type="hidden" id="img_height" name="img_height">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            var datatable = $('#AdBannerDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.adbanner.gettabledata') }}",
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
                        data: 'page',
                        name: 'page'
                    },
                    {
                        data: 'images',
                        name: 'images'
                    },
                    {
                        data: 'status_row',
                        name: 'status_row'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ]
            });


            $('#AdBannerDataTable tbody').on('click', '.view-details-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object


                    $("#JobAdvertisement").modal("show");
                    $("#page_name").val(rowData.page_nm);
                    setTimeout(function() {
                        $("#status").val(String(rowData.status)).trigger('change');
                    }, 100);
                    $("#ad_link").val(rowData.ad_link);
                    $("#start_date").val(rowData.start_date);
                    $("#end_date").val(rowData.end_date);


                    $("#flag").val("U");
                    $("#row_id").val(rowData.id);
                    $("#_method").val("PUT");

                    setTimeout(function() {
                        SelectPageName()
                    }, 500);

                });

            $('#AdBannerDataTable tbody').on('click', '.delete-ad-banner-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object


                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Are you sure to delete Ad Banner?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, confirm!',
                        customClass: {
                            confirmButton: 'btn btn-primary me-3',
                            cancelButton: 'btn btn-label-secondary'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            var id = rowData.id;
                            var data = {
                                'id': id
                            }

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            LoaderShow()

                            $.ajax({
                                type: "DELETE",
                                url: "{{ url('admin/ad-banner') }}/" + id,
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


        let validator = $("#ad-banner-form").validate({
            rules: {
                page_name: {
                    required: true
                },
                banner_img: {
                    required: function() {
                        // ✅ read `flag` dynamically at validation time
                        return $("#flag").val() === "A";
                    },
                    extension: "jpg|jpeg|png"
                }
            },
            messages: {
                page_name: {
                    required: "Please Select Page Name"
                },
                banner_img: {
                    required: "Please Upload Ad Banner Image",
                    extension: "Only image files (jpg, jpeg, png) are allowed"
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
                $(element).removeClass("is-invalid").addClass("is-valid");
            }
        });


        // ✅ Final submission with AJAX
        $("#ad-banner-form").submit(function(e) {
            e.preventDefault();

            if (!$("#ad-banner-form").valid()) {
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
                url = "{{ route('admin.ad-banner.store') }}";
            } else {
                url = "{{ url('admin/ad-banner') }}/" + id;
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
                }
            });
        });



        function SelectPageName() {
            var page_name = $("#page_name").val();
            var width = 0;
            var height = 0;

            if (page_name == 1) {
                width = 1500;
                height = 150;
            } else if (page_name == 2) {
                width = 500;
                height = 700;
            } else if (page_name == 3) {
                width = 500;
                height = 700;
            } else if (page_name == 4) {
                width = 500;
                height = 700;
            }
            $("#img_width").val(width);
            $("#img_height").val(height);

            $("#ImageSize").html(`File Upload Size ${width} X ${height}`);
        }
    </script>
@endpush
