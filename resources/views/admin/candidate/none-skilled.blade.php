@extends('admin.layout.layout')
@section('content')
       <script>
        page_active_id = "Candidate-NonSkill";
    </script>


    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            @can('Candidate-non_skill_register')
                <div class="col-lg-4">
                    <a href="{{ route('admin.candidate-none-skill') }}">
                        <div class="card p-1" style="border: 2px solid #f26824;">
                            <div class="row">
                                <div class="col-lg-4">
                                    <img src="{{ asset('admin-assets/img/noneskill.png') }}" alt="Img"
                                        style="max-width: 100%;">
                                </div>
                                <div class="col-lg-8" style="align-content:center;">
                                    <h5 class="mb-1">None Skilled</h5>
                                    <p style="font-size: 12px;">Click to view data related to non-skilled employees.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endcan


            @can('Candidate-skill_register')
                <div class="col-lg-4">
                    <a href="{{ route('admin.candidate-skill') }}">
                        <div class="card p-1">
                            <div class="row">
                                <div class="col-lg-4">
                                    <img src="{{ asset('admin-assets/img/skill.png') }}" alt="Img"
                                        style="max-width: 100%;">
                                </div>
                                <div class="col-lg-8" style="align-content:center;">
                                    <h5 class="mb-1">Skilled</h5>
                                    <p style="font-size: 12px;">Click to view data related to skilled employees.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endcan

        </div>

        <div class="card">
            <div class="card-header p-4">
                <h5 class="card-title">None Skilled Employee</h5>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="NoneSkilledEmployeeDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Zip code</th>
                            <th>Action</th>
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
            var datatable = $('#NoneSkilledEmployeeDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.none-skill.gettabledata') }}",
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
                        data: 'zipcode',
                        name: 'zipcode'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ]
            });
        });
    </script>
    <script>
        function toggleUserStatus(userId) {

            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to deactivate / activate this user?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {

                // ❌ NO click → nothing happens
                if (!result.isConfirmed) {
                    return;
                }

                // ✅ YES click → NOW AJAX CALL
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.skill-user-status') }}",
                    data: {
                        id: userId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (res) {

                        Swal.fire({
                            icon: res.status ? 'success' : 'error',
                            title: res.title,
                            text: res.message,
                            confirmButtonText: 'OK'
                        });

                        if (res.status) {
                            $('.dataTable').DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Something went wrong', 'error');
                    }
                });

            });
        }
    </script>

@endpush
