@push('css')
    <style>
        .image-upload-box {
            border: 1px solid #e3e3e3;
            text-align: center;
            cursor: pointer;
            border-radius: 12px;
            background: #eee;
        }
    </style>
@endpush

@extends('admin.layout.layout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Setting</h5>
            </div>
            <div class="card-body table-responsive">
                <form id="setting-form" onsubmit="return false;" method="POST">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-6">
                                <label class="form-label" for="website_title">Website Title</label>
                                <input type="text" class="form-control" id="website_title" name="website_title"
                                    placeholder="Enter Website Title" value="{{ $Setting->web_title }}">
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="mb-6">
                                <label class="form-label" for="basic-default-fullname">Website Meta Title</label>
                                <input type="text" class="form-control" id="website_meta_title" name="website_meta_title"
                                    placeholder="Enter Website Meta Title" value="{{ $Setting->web_meta }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-6">
                                <label class="form-label" for="website_keyword">Website Keyword</label>
                                <input type="text" class="form-control" id="website_keyword" name="website_keyword"
                                    placeholder="Enter Website Keyword" value="{{ $Setting->web_keyword }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-6">
                                <label class="form-label" for="website_description">Website Description</label>
                                <input type="text" class="form-control" id="website_description"
                                    name="website_description" placeholder="Enter Website Description"
                                    value="{{ $Setting->web_description }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-6">
                                <label class="form-label" for="contact_1">Contact 1</label>
                                <input type="text" class="form-control" id="contact_1" name="contact_1"
                                    placeholder="Enter Contact No." value="{{ $Setting->contact_1 }}">
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="mb-6">
                                <label class="form-label" for="contact_2">contact_2</label>
                                <input type="text" class="form-control" id="contact_2" name="contact_2"
                                    placeholder="Enter Contact No." value="{{ $Setting->contact_2 }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-6">
                                <label class="form-label" for="email_1">Email 1</label>
                                <input type="text" class="form-control" id="email_1" name="email_1"
                                    placeholder="Enter Email" value="{{ $Setting->email_1 }}">
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="mb-6">
                                <label class="form-label" for="email_2">Email 2</label>
                                <input type="text" class="form-control" id="email_2" name="email_2"
                                    placeholder="Enter Email" value="{{ $Setting->email_2 }}">
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="mb-6">
                                <label class="form-label" for="address">Address</label>
                                <textarea type="text" class="form-control" id="address" name="address" placeholder="Enter Address">{{ $Setting->Address }}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-6">
                                <label class="form-label" for="corporate-address">Corporate Address</label>
                                <textarea type="text" class="form-control" id="corporate-address" name="corporate_address" placeholder="Enter Corporate Address">{{ $Setting->corporate_address}}</textarea>
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="mb-6">
                                <label class="form-label" for="play_store_link">Play Store Link</label>
                                <input type="text" class="form-control" id="play_store_link" name="play_store_link"
                                    placeholder="Enter Play Store Link" value="{{ $Setting->play_store_link }}">
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="mb-6">
                                <label class="form-label" for="app_store_link">App Store Link</label>
                                <input type="text" class="form-control" id="app_store_link" name="app_store_link"
                                    placeholder="Enter App Store Link" value="{{ $Setting->app_store_link }}">
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <label class="form-label" for="basic-default-fullname">Favicon <b>(100 X 100)</b></label>
                            <div class="image-upload-box"
                                onclick="document.getElementById('favicon_img_upload').click();">
                                <img id="FaviconImgsrc"
                                    src="{{ $Setting->favicon ? asset('uploads/logo_img/' . $Setting->favicon) : asset('admin-assets/img/image-upload.png') }}"
                                    style="max-width: 60%;" alt="">
                            </div>

                            <input type="file" style="visibility: hidden" id="favicon_img_upload"
                                name="favicon_img_upload" onchange="image_show(0,this, 'FaviconImgsrc')">
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label" for="basic-default-fullname">Header Logo <b>(300 X 100)</b></label>
                            <div class="image-upload-box"
                                onclick="document.getElementById('header_logo_img_upload').click();">
                                <img id="HeaderLogoImgsrc"
                                    src="{{ $Setting->header_logo ? asset('uploads/logo_img/' . $Setting->header_logo) : asset('admin-assets/img/image-upload.png') }}"
                                    style="max-width: 60%;" alt="">
                            </div>

                            <input type="file" style="visibility: hidden" id="header_logo_img_upload"
                                name="header_logo_img_upload" onchange="image_show(0,this, 'HeaderLogoImgsrc')">
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label" for="basic-default-fullname">Footer Logo <b>(300 X 100)</b></label>
                            <div class="image-upload-box"
                                onclick="document.getElementById('footer_logo_img_upload').click();">
                                <img id="FooterLogoImgsrc"
                                    src="{{ $Setting->footer_logo ? asset('uploads/logo_img/' . $Setting->footer_logo) : asset('admin-assets/img/image-upload.png') }}"
                                    style="max-width: 60%;" alt="">
                            </div>

                            <input type="file" style="visibility: hidden" id="footer_logo_img_upload"
                                name="footer_logo_img_upload" onchange="image_show(0,this, 'FooterLogoImgsrc')">
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label">Director Signature <b>(PNG, recommended 200x60)</b></label>
                            <div class="image-upload-box"
                                onclick="document.getElementById('director_signature_upload').click();">
                                <img id="DirectorSignatureSrc"
                                    src="{{ $Setting->director_signature ? asset('uploads/logo_img/' . $Setting->director_signature) : asset('admin-assets/img/image-upload.png') }}"
                                    style="max-width: 60%; max-height: 80px;" alt="">
                            </div>
                            <input type="file" style="visibility: hidden" id="director_signature_upload"
                                name="director_signature_upload" onchange="image_show(0,this, 'DirectorSignatureSrc')">
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label">Round Seal <b>(PNG, recommended 150x150)</b></label>
                            <div class="image-upload-box"
                                onclick="document.getElementById('round_seal_upload').click();">
                                <img id="RoundSealSrc"
                                    src="{{ $Setting->round_seal ? asset('uploads/logo_img/' . $Setting->round_seal) : asset('admin-assets/img/image-upload.png') }}"
                                    style="max-width: 60%; max-height: 80px;" alt="">
                            </div>
                            <input type="file" style="visibility: hidden" id="round_seal_upload"
                                name="round_seal_upload" onchange="image_show(0,this, 'RoundSealSrc')">
                        </div>

                        <div class="col-lg-12 my-3">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="ShowCompanyDetails" name="ShowCompanyDetails" {{ $Setting->ShowCompanyDetails ? 'checked' : '' }}>
                                <label class="form-check-label" for="ShowCompanyDetails">Show Address and Company
                                    Details on Job Posting</label>

                            </div>
                        </div>

                        <div class="col-lg-12">
                            <input type="hidden" id="_method" name="_method" value="POST">
                            <input type="hidden" id="flag" name="flag" value="U">
                            <input type="hidden" id="row_id" name="row_id" value="{{ $Setting->id }}">
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
        // ✅ Final Blog Form Submit Handler
        $("#setting-form").submit(function(e) {
            e.preventDefault();

            // ✅ Check validation using jQuery Validation Plugin (if used)
            // if (!$("#setting-form").valid()) {
            //     return;
            // }


            // ✅ Prepare FormData object
            let form = this;
            let formData = new FormData(form);


            // ✅ Add _method if updating (PUT)
            var flag = $("#flag").val(); // "A" or "E"
            var id = $("#row_id").val();
            var url = "";
            var type = "POST";

            if (flag === "A") {
                url = "{{ route('admin.setting.store') }}";
            } else {
                url = "{{ url('admin/setting') }}/" + id;
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
