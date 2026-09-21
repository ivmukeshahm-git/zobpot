@extends('admin.layout.layout')
@section('content')
       <script>
        page_active_id = "internship";
    </script>

    <style>
    /* Gender badge colors */
    .bg-pink {
        background-color: #e83e8c !important;
        color: #fff;
    }

    /* Status dropdown colors */
    .status-pending {
        background-color: #fff3cd !important;
        color: #856404;
        border-color: #ffeeba;
    }

    .status-complete {
        background-color: #d4edda !important;
        color: #155724;
        border-color: #c3e6cb;
    }

    .status-cancel {
        background-color: #f8d7da !important;
        color: #721c24;
        border-color: #f5c6cb;
    }

    /* Table polish */
    table td {
        vertical-align: middle !important;
    }

    table select.form-select {
        font-size: 13px;
        padding: 4px 8px;
    }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <div class="card-header p-4">
                <h5 class="card-title">Opportunity Register List</h5>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="InternshipRegisterListDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <th>City</th>
                            <th>Pincode</th>
                            <th>University</th>
                            <th>College</th>
                            <th>Degree/Course</th>
                            <th>Gender</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        $(document).ready(function() {
            var datatable = $('#InternshipRegisterListDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.internship.list') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = '{{ csrf_token() }}'; // Required for POST in Laravel
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
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
                        data: 'phone_no',
                        name: 'phone_no'
                    },
                    {
                        data: 'city',
                        name: 'city'
                    },
                     {
                        data: 'pincode',
                        name: 'pincode'
                    },
                    {
                        data: 'university',
                        name: 'university'
                    },
                    {
                        data: 'college',
                        name: 'college'
                    },
                    {
                        data: 'degree',
                        name: 'degree'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    { data: 'status', orderable:false, searchable:false },
                ]
            });
        });

        let previousStatus = null;

        $(document).on('focus', '.changeStatus', function () {
            previousStatus = $(this).val(); // store old value
        });

        $(document).on('change', '.changeStatus', function () {

            let select = $(this);
            let id = select.data('id');
            let status = select.val();

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to change the status?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it',
                cancelButtonText: 'No'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ route('admin.skillthon.status.update') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                            status: status
                        },
                        success: function (res) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: 'Status has been updated successfully.',
                                timer: 1500,
                                showConfirmButton: false
                            });

                        }
                    });

                } else {
                    // revert to old value
                    select.val(previousStatus);
                }

            });
        });
    </script>
@endpush
