@push('css')
    <style>
        #AddPartners {
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
        page_active_id = "Partners";
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Product List Table -->
        <div class="card" id="ListOfPartners">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Partners</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        @can('Partner-Add')
                            <button type="button" class="btn btn-sm btn-primary" onclick="AddPartners()"><i
                                    class='bx bx-plus'></i> Add</button>
                        @endcan
                    </div>
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="PartnerDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Name</th>
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


        <div class="card" id="AddPartners">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Add New Partners</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        <button type="button" class="btn btn-sm btn-primary" onclick="backtoList()"><i
                                class='fa fa-long-arrow-left'></i>&nbsp; Back</button>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <form id="partner-form" onsubmit="return false;" method="POST">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-6">
                                <label class="form-label" for="username">Name</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Enter Partner Name">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
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
        $(document).ready(function () {

            // ================= DATATABLE =================
            var datatable = $('#PartnerDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.partner.gettabledata') }}",
                    type: "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
                    { data: 'name', name: 'name' },
                    { data: 'images', name: 'images', orderable:false, searchable:false },
                    { data: 'status_label', name: 'status', orderable:false, searchable:false },
                    { data: 'action', name: 'action', orderable:false, searchable:false }
                ]
            });


            // ================= EDIT =================
            $('#PartnerDataTable tbody').on('click', '.view-details-btn', function () {

                var rowData = datatable.row($(this).closest('tr')).data();
                // console.log(rowData);

                $("#AddPartners").show();
                $("#ListOfPartners").hide();

                $("#username").val(rowData.name);
                $("#status").val(rowData.status).trigger('change');

                let imagePath = "{{ asset('uploads/partner_img') }}/" + rowData.image;
                $("#ProfileImgsrc").attr('src', imagePath);

                $("#flag").val("U");
                $("#row_id").val(rowData.id);
                $("#_method").val("PUT");
            });


            // ================= DELETE =================
            $('#PartnerDataTable tbody').on('click', '.delete-partner-btn', function () {

                var rowData = datatable.row($(this).closest('tr')).data();
                var id = rowData.id;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete this partner?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes delete!'
                }).then((result) => {

                    if (result.isConfirmed) {

                        LoaderShow();

                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('admin/partners') }}/" + id,
                            data: {_token:"{{ csrf_token() }}"},
                            success: function (response) {
                                LoaderHide();

                                if (response.status == 1) {
                                    toastr.success(response.message);
                                    datatable.ajax.reload();
                                } else {
                                    toastr.error(response.message);
                                }
                            }
                        });
                    }
                });
            });

        });


        // ================= FORM VALIDATION =================
        let validator = $("#partner-form").validate({
            rules: {
                username: { required: true },
                status:{required:true},
                profile_img_upload: {
                    required: function () {
                        return $("#flag").val() === "A";
                    },
                    extension: "jpg|jpeg|png"
                }
            },
            messages: {
                username: { required: "Enter partner name" },
                profile_img_upload: {
                    required: "Upload image",
                    extension: "Only jpg png allowed"
                }
            }
        });


        // ================= SUBMIT =================
        $("#partner-form").submit(function (e) {
            e.preventDefault();

            if (!$("#partner-form").valid()) return;

            let formData = new FormData(this);
            let flag = $("#flag").val();
            let id = $("#row_id").val();
            let url = "";

            if (flag == "A") {
                url = "{{ route('admin.partners.store') }}";
            } else {
                url = "{{ url('admin/partners') }}/" + id;
                formData.append("_method", "PUT");
            }

            LoaderShow();

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                success: function (response) {
                    LoaderHide();

                    if (response.status == 1) {
                        toastr.success(response.message);

                        $("#AddPartners").hide();
                        $("#ListOfPartners").show();
                        $("#partner-form")[0].reset();

                        $('#PartnerDataTable').DataTable().ajax.reload();
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        });


        // ================= IMAGE PREVIEW =================
        function image_show(id, input, src_id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#' + src_id).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }


        // ================= SHOW ADD FORM =================
        function AddPartners() {
            $("#AddPartners").show();
            $("#ListOfPartners").hide();

            $("#partner-form")[0].reset();
            $("#flag").val("A");
        }


        // ================= BACK =================
        function backtoList() {
            $("#AddPartners").hide();
            $("#ListOfPartners").show();
        }
    </script>
@endpush
