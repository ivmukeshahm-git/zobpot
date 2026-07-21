@extends('admin.layout.layout')
@section('content')
  <script>
      page_active_id = "Master-Qualification";
  </script>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Product List Table -->
        <div class="card">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Qualification</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        @can('MinimumQualification-Add')
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#QualificationAdd"><i class='bx bx-plus'></i> Add</button>
                        @endcan
                    </div>
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="QualificationDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Name</th>
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
    <div class="modal fade" id="QualificationAdd" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form id="qualification-form" class="modal-content" onsubmit="return false;">
                <div class="modal-header">
                    <h5 class="modal-title" id="QualificationAddTitle">Add Qualification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="nameBackdrop" class="form-label mb-2">Qualification Name</label>
                            <input type="text" id="qualification_name" name="qualification_name" class="form-control"
                                placeholder="Enter Qualification Name" />
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
            var datatable = $('#QualificationDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.min-qualification.gettabledata') }}",
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
                        data: 'name',
                        name: 'name'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ]
            });


            $('#QualificationDataTable tbody').on('click', '.view-details-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object

                    $("#QualificationAdd").modal("show");
                    $("#qualification_name").val(rowData.name);
                    $("#flag").val("U");
                    $("#row_id").val(rowData.qualification_id);
                    $("#_method").val("PUT");
                });

            $('#QualificationDataTable tbody').on('click', '.delete-qualification-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object


                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Are you sure to delete qualification?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, confirm!',
                        customClass: {
                            confirmButton: 'btn btn-primary me-3',
                            cancelButton: 'btn btn-label-secondary'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            var QualificationId = rowData.qualification_id;
                            var data = {
                                'QualificationId': QualificationId
                            }

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            LoaderShow()

                            $.ajax({
                                type: "DELETE",
                                url: "{{ url('admin/min-qualification') }}/" + QualificationId,
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




            $('#QualificationAdd').on('hidden.bs.modal', function() {
                $("#_method").val("POST");
            });

        });



        let validator = $("#qualification-form").validate({
            rules: {
                qualification_name: {
                    required: true
                },
            },
            messages: {
                qualification_name: {
                    required: "Please Enter Qualification Name"
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
        $("#qualification-form").submit(function(e) {
            e.preventDefault();

            if (!$("#qualification-form").valid()) {
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
                url = "{{ route('admin.min-qualification.store') }}";
            } else {
                url = "{{ url('admin/min-qualification') }}/" + id;
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
