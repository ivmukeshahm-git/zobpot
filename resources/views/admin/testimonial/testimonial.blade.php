@push('css')
    <style>
        #AddTestimonials {
            display: none;
        }

        .image-upload-box {
            border: 1px solid #e3e3e3;
            text-align: center;
            border-radius: 12px;
            background: #eee;
        }
    </style>
@endpush


@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "Testimonials";
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Product List Table -->
        <div class="card" id="ListOfTestimonials">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Testimonials</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        @can('Testimonial-Add')
                            <button type="button" class="btn btn-sm btn-primary" onclick="AddTestimonials()"><i
                                    class='bx bx-plus'></i> Add</button>
                        @endcan
                    </div>
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="TestimonialDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>


        <div class="card" id="AddTestimonials">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Add New Testimonials</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        <button type="button" class="btn btn-sm btn-primary" onclick="backtoList()"><i
                                class='fa fa-long-arrow-left'></i>&nbsp; Back</button>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <form id="testimonial-form" onsubmit="return false;" method="POST">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-6">
                                <label class="form-label" for="username">Name</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-6">
                                <label class="form-label" for="designation">Designation</label>
                                <input type="text" class="form-control" id="designation" name="designation"
                                    placeholder="Enter Designation">
                            </div>
                        </div>


                        <div class="col-lg-8">
                            <div class="mb-6">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label" for="basic-default-fullname">Profile Image <b>(100 X 100)</b></label>
                            <div class="image-upload-box" onclick="document.getElementById('profile_img_upload').click();">
                                <img id="ProfileImgsrc" src="{{ asset('admin-assets/img/image-upload.png') }}"
                                    style="max-width: 60%;" alt="">
                            </div>

                            <input type="file" style="visibility: hidden" id="profile_img_upload"
                                name="profile_img_upload" onchange="image_show(0,this, 'ProfileImgsrc')">
                        </div>

                        <div class="col-lg-12">
                            <input type="hidden" id="_method" name="_method" value="POST">
                            <input type="hidden" id="flag" name="flag" value="A">
                            <input type="hidden" id="row_id" name="row_id">

                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            var datatable = $('#TestimonialDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.testimonial.gettabledata') }}",
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
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'designation',
                        name: 'designation'
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


            $('#TestimonialDataTable tbody').on('click', '.view-details-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object


                    document.getElementById("AddTestimonials").style.display = "block";
                    document.getElementById("ListOfTestimonials").style.display = "none";

                    $("#username").val(rowData.username);
                    $("#designation").val(rowData.designation);
                    $("#description").val(rowData.description);


                    let imagePath = "{{ asset('uploads/testimonial_img') }}/" + rowData.profile_img;
                    $("#ProfileImgsrc").attr('src', imagePath);

                    $("#flag").val("U");
                    $("#row_id").val(rowData.id);
                    $("#_method").val("PUT");

                    //    $("#action_type").val(String(rowData.status)).trigger('change');
                });

            $('#TestimonialDataTable tbody').on('click', '.delete-testimonial-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object


                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Are you sure to delete Testimonial?",
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
                                url: "{{ url('admin/testimonial') }}/" + id,
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


        let validator = $("#testimonial-form").validate({
            rules: {
                username: {
                    required: true
                },
                designation: {
                    required: true
                },
                description: {
                    required: true
                },
                profile_img_upload: {
                    required: function() {
                        // ✅ Get flag value at the time of validation
                        return $("#flag").val() === "A"; // only required on Add
                    },
                    extension: "jpg|jpeg|png"
                }
            },
            messages: {
                username: {
                    required: "Please Enter User Name"
                },
                designation: {
                    required: "Please Enter Designation"
                },
                description: {
                    required: "Please Enter Description"
                },
                profile_img_upload: {
                    required: "Please upload a blog image",
                    extension: "Only JPG, JPEG, or PNG images are allowed"
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


        // ✅ Final Blog Form Submit Handler
        $("#testimonial-form").submit(function(e) {
            e.preventDefault();

            // ✅ Check validation using jQuery Validation Plugin (if used)
            if (!$("#testimonial-form").valid()) {
                return;
            }

            // ✅ Prepare FormData object
            let form = this;
            let formData = new FormData(form);


            // ✅ Add _method if updating (PUT)
            var flag = $("#flag").val(); // "A" or "E"
            var id = $("#row_id").val();
            var url = "";
            var type = "POST";

            if (flag === "A") {
                url = "{{ route('admin.testimonial.store') }}";
            } else {
                url = "{{ url('admin/testimonial') }}/" + id;
                formData.append("_method", "PUT"); // Laravel needs this, AJAX has no true PUT
            }

            // ✅ CSRF token for Laravel
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            LoaderShow()

            // ✅ Make AJAX request
            $.ajax({
                type: "POST", // Always POST (PUT is spoofed)
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    LoaderHide()
                    if (response.status === 1) {
                        toastr.success(response.message, "Success");
                        setTimeout(() => {
                            location.reload();
                        }, 800);
                    } else {
                        toastr.warning(response.message, "Warning");
                    }
                },
                error: function(xhr) {
                    LoaderHide()
                    console.error(xhr.responseText);
                    toastr.error("An error occurred. Please try again.", "Error");
                }
            });
        });


        function image_show(id, input, src_id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var setimg = document.getElementById(src_id).src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }


        function AddTestimonials() {
            document.getElementById("AddTestimonials").style.display = "block";
            document.getElementById("ListOfTestimonials").style.display = "none";
        }

        function backtoList() {
            document.getElementById("AddTestimonials").style.display = "none";
            document.getElementById("ListOfTestimonials").style.display = "block";
        }
    </script>
@endpush
