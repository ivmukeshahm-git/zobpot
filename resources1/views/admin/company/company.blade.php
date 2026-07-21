@extends('admin.layout.layout')
@section('content')
   <script>
        page_active_id = "Company";
    </script>
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <div class="card-header p-4">
                <h5 class="card-title">Company</h5>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="CompanyDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Company Name</th>
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
    <!-- / Content -->
@endsection



@push('script')
    <script>
        $(document).ready(function() {
            var datatable = $('#CompanyDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.company.gettabledata') }}",
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


        // function ActiveDeactiveUser(sts){
        //     alert(sts);
        // }
    </script>
@endpush
