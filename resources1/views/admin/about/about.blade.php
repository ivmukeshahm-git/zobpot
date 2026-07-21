@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "About";
    </script>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Product List Table -->
        <div class="card">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-lg-12">
                        <h5 class="card-title">About</h5>
                    </div>
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <form id="About-form" onsubmit="return false;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-6">
                                <label class="form-label" for="basic-default-fullname">About us</label>
                                <div id="about-editor"></div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <input type="hidden" id="_method" name="_method" value="POST">
                            <input type="hidden" id="flag" name="flag" value="U">
                            <input type="hidden" id="row_id" name="row_id" value="{{ $About->id }}">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        let editorInstanceProject;

        ClassicEditor.create(document.querySelector('#about-editor'))
            .then(editor => {
                editorInstanceProject = editor; // Store the editor instance
                editor.ui.view.editable.element.style.height = '550px!important';
            })
            .catch(error => {
                console.error(error);
            });





        // ✅ Final Blog Form Submit Handler
        $("#About-form").submit(function(e) {
            e.preventDefault();

            // ✅ Check validation using jQuery Validation Plugin (if used)
            if (!$("#About-form").valid()) {
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
                url = "{{ route('admin.about.store') }}";
            } else {
                url = "{{ url('admin/about') }}/" + id;
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
                    // ✅ Handle Success
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



        $(document).ready(function() {
            // Safely pass the about_us HTML into JS (escaping quotes etc.)
            var Desc = @json($About->about_us);

            // Set plain text in CKEditor 5
            editorInstanceProject.setData(Desc);
        });
    </script>
@endpush
