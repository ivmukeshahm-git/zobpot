@extends('admin.layout.layout')
@section('content')
   <script>
        page_active_id = "Staff";
    </script>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Product List Table -->
        <div class="card">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center gap-3">
                            <h5 class="card-title mb-0">Staff</h5>
                            @php
                                $currentUser = auth()->user() ?? auth()->guard('college_staff')->user() ?? auth()->guard('college')->user();
                                $currentRole = optional($currentUser)->role ?? optional(optional($currentUser)->roles->first())->name;
                            @endphp
                            @if($currentRole === 'Staff')
                                <a href="{{ route('admin.staff.assign-internship') }}" class="btn btn-sm btn-outline-primary ms-3">Assign Internship</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        <a href="{{ route('admin.add-staff') }}" class="btn btn-sm btn-primary"><i class='bx bx-plus'></i>
                            Add</a>
                    </div>
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="StaffDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Staff Name</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <th>State</th>
                            <th>City</th>
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
    <!-- / Content -->


    <!-- Modal -->
    <div class="modal fade" id="JobCategory" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form id="job-category-form" class="modal-content" onsubmit="return false;">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="JobCategoryTitle">Add Job Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12 mb-3">
                            <label for="nameBackdrop" class="form-label mb-2">Category Name</label>
                            <input type="text" id="category_nm" name="category_nm" class="form-control"
                                placeholder="Enter Category Name" />
                        </div>

                        <div class="col-lg-12 col-md-12 col-12 mb-3">
                            <label for="nameBackdrop" class="form-label mb-2">Category Icon Image (100 X 100)</label>
                            <input type="file" id="category_image" name="category_image" class="form-control" />
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
            var datatable = $('#StaffDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.staff.gettabledata') }}",
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'contact_no',
                        name: 'contact_no'
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
                        data: 'active_status_badge',
                        name: 'active_status_badge'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ]
            });


            $('#StaffDataTable tbody').on('click', '.delete-staff-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object


                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Are you sure to delete Staff?",
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
                                url: "{{ url('admin/staff') }}/" + id,
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

        });



        
    </script>
@endpush
