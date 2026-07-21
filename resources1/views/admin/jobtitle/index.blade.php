@extends('admin.layout.layout')
@section('content')

<script>
    page_active_id = "Master-JobTitle";
</script>

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div class="card-header p-4">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="card-title">Job Title</h5>
                </div>
                <div class="col-lg-6" style="text-align: right;">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#JobTitleModal">
                        <i class='bx bx-plus'></i> Add
                    </button>
                </div>
            </div>
        </div>

        <hr class="my-1">

        <div class="card-body table-responsive p-4">
            <table id="JobTitleDataTable" class="table table-sm table-striped table-hover">
                <thead class="border-top">
                    <tr>
                        <th>Sr No.</th>
                        <th>Title Name</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody></tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="JobTitleModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form id="job-title-form" class="modal-content" onsubmit="return false;">
            <div class="modal-header">
                <h5 class="modal-title" id="JobTitleAddTitle">Add Job Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label class="form-label">Title Name</label>
                <input type="text" name="title_name" id="title_name"
                    class="form-control" placeholder="Enter Title Name">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>

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

    var datatable = $('#JobTitleDataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.job-title.gettabledata') }}",
            type: "POST",
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title_name' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });


    // Edit Button Click
    $('#JobTitleDataTable').on('click', '.edit-title-btn', function() {

        var row = datatable.row($(this).closest('tr')).data();

        $("#JobTitleModal").modal("show");
        $("#title_name").val(row.title_name);
        $("#row_id").val(row.id);
        $("#flag").val("U");
        $("#_method").val("PUT");
        $("#JobTitleAddTitle").text("Edit Job Title");
    });


    // Delete Button Click
    $('#JobTitleDataTable').on('click', '.delete-title-btn', function() {

        var row = datatable.row($(this).closest('tr')).data();
        var id = row.id;

        Swal.fire({
            title: 'Are you sure?',
            text: "Delete this job title?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete!',
            customClass: {
                confirmButton: 'btn btn-danger me-3',
                cancelButton: 'btn btn-label-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "{{ url('admin/job-title') }}/" + id,
                    type: "DELETE",
                    data: {_token: '{{ csrf_token() }}'},
                    success: function(res) {

                        if (res.status == 1) {
                            toastr.success(res.message);
                            datatable.ajax.reload(null, false);
                        } else {
                            toastr.error(res.message);
                        }

                    }
                });

            }
        });
    });


    // Reset modal on close
    $('#JobTitleModal').on('hidden.bs.modal', function() {
        $("#flag").val("A");
        $("#_method").val("POST");
        $("#job-title-form")[0].reset();
        $("#JobTitleAddTitle").text("Add Job Title");
    });


});

$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
});
// Form Submit
$("#job-title-form").submit(function(e) {
    e.preventDefault();

    var flag = $("#flag").val();
    var id = $("#row_id").val();
    var url = "";

    if (flag == "A") {
        url = "{{ route('admin.job-title.store') }}";
    } else {
        url = "{{ url('admin/job-title') }}/" + id;
    }

    $.ajax({
        url: url,
        type: "POST",
        data: $(this).serialize(),
        success: function(res) {

            if (res.status == 1) {
                toastr.success(res.message);
                $("#JobTitleModal").modal("hide");
                $('#JobTitleDataTable').DataTable().ajax.reload(null, false);
            } else {
                toastr.error(res.message);
            }

        }
    });
});


</script>
@endpush
