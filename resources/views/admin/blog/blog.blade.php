@push('css')
    <style>
        #AddBlog {
            display: none;
        }

        .image-upload-box {
            border: 1px solid #e3e3e3;
            text-align: center;
            cursor: pointer;
            border-radius: 12px;
            background: #eee;
             width: 100%;
        height: 200px;              /* ✅ fix height */
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden; 
        }
         .image-upload-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;        /* ✅ image cut nahi thase */
    }
    </style>
@endpush

@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "Blog";
    </script>


    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Product List Table -->
        <div class="card" id="ListOfBlog">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Blog</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        <button type="button" class="btn btn-sm btn-primary" onclick="AddBlog()"><i class='bx bx-plus'></i>
                            Add</button>
                    </div>
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="BlogDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Blog Title</th>
                            <th>Image</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>


        <div class="card" id="AddBlog">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Add New Blog</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        <button type="button" class="btn btn-sm btn-primary" onclick="backtoList()"><i
                                class='fa fa-long-arrow-left'></i>&nbsp; Back</button>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <form id="blog-form" onsubmit="return false;" method="POST">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-6">
                                <label class="form-label" for="basic-default-fullname">Blog Title</label>
                                <input type="text" class="form-control" id="blog_title" name="blog_title"
                                    placeholder="Enter Blog Title">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-6">
                                <label class="form-label" for="basic-default-fullname">Type</label>
                                <select class="form-select" id="action_type" name="action_type">
                                    <option value="1">Published</option>
                                    <option value="2">Draft</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label class="form-label">Blog Description</label>
                                <div id="blog-editor"></div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label" for="basic-default-fullname">Blog Image <b>(900 X 500)</b></label>
                            <div class="image-upload-box" onclick="document.getElementById('blog_img_upload').click();">
                                <img id="BLogImgsrc" src="{{ asset('admin-assets/img/image-upload.png') }}"
                                    style="max-width: 60%;" alt="">
                            </div>

                            <input type="file" style="visibility: hidden" id="blog_img_upload" name="blog_img_upload"
                                onchange="image_show(0,this, 'BLogImgsrc')">
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
        let editorInstanceProject;

        ClassicEditor.create(document.querySelector('#blog-editor'))
            .then(editor => {
                editorInstanceProject = editor; // Store the editor instance
                editor.ui.view.editable.element.style.height = '550px!important';
            })
            .catch(error => {
                console.error(error);
            });




        $(document).ready(function() {
            var datatable = $('#BlogDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.blog.gettabledata') }}",
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
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'images',
                        name: 'images'
                    },
                    {
                        data: 'add_date',
                        name: 'add_date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ]
            });


            $('#BlogDataTable tbody').on('click', '.view-details-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object

                    document.getElementById("AddBlog").style.display = "block";
                    document.getElementById("ListOfBlog").style.display = "none";


                    $("#blog_title").val(rowData.title);

                    const plainText = $('<div>').html(rowData.desc).text(); // jQuery way to strip HTML
                    editorInstanceProject.setData(plainText);

                    let imagePath = "{{ asset('uploads/blog_img') }}/" + rowData.image;
                    $("#BLogImgsrc").attr('src', imagePath);

                    $("#flag").val("U");
                    $("#row_id").val(rowData.id);
                    $("#_method").val("PUT");

                    //    $("#action_type").val(String(rowData.status)).trigger('change');
                });

            $('#BlogDataTable tbody').on('click', '.delete-blog-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object


                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Are you sure to delete blog?",
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
                                url: "{{ url('admin/blog') }}/" + id,
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


        let validator = $("#blog-form").validate({
            rules: {
                blog_title: {
                    required: true
                },
                blog_img_upload: {
                    required: function() {
                        // ✅ Get flag value at the time of validation
                        return $("#flag").val() === "A"; // only required on Add
                    },
                    extension: "jpg|jpeg|png"
                }
            },
            messages: {
                blog_title: {
                    required: "Please enter the blog title"
                },
                blog_img_upload: {
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
        $("#blog-form").submit(function(e) {
            e.preventDefault();

            // ✅ Check validation using jQuery Validation Plugin (if used)
            if (!$("#blog-form").valid()) {
                return;
            }

            // Get CKEditor description (from instance)
            var Description = editorInstanceProject.getData();

            // ✅ Prepare FormData object
            let form = this;
            let formData = new FormData(form);

            formData.append("description", Description); // Inject CKEditor content

            // ✅ Add _method if updating (PUT)
            var flag = $("#flag").val(); // "A" or "E"
            var id = $("#row_id").val();
            var url = "";
            var type = "POST";

            if (flag === "A") {
                url = "{{ route('admin.blog.store') }}";
            } else {
                url = "{{ url('admin/blog') }}/" + id;
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



        function AddBlog() {
            document.getElementById("AddBlog").style.display = "block";
            document.getElementById("ListOfBlog").style.display = "none";
        }

        function backtoList() {
            document.getElementById("AddBlog").style.display = "none";
            document.getElementById("ListOfBlog").style.display = "block";
        }

        function image_show(id, input, src_id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var setimg = document.getElementById(src_id).src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
