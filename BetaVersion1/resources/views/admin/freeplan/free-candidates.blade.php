@extends('admin.layout.layout')
@section('content')
   <script>
        page_active_id = "FreeCompanyCandidates-Candidates";
    </script>
                                    
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12">
            <div class="nav-align-top mb-6">
                <ul class="nav nav-pills mb-4 menu-bar" role="tablist">
                     @can('Company-free_company')
                    <li class="nav-item">
                        <a href="{{ route('admin.free-company-plan') }}"
                            class="nav-link ">
                            Company
                        </a>
                    </li>
                    @endcan
                    @can('Candidate-free_candidate')
                    <li class="nav-item">
                        <a href="{{ route('admin.free-candidate-plan') }}"
                            class="nav-link active">
                            Candidates
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </div>
    </div>


    <div class="row mb-5">
        <div class="col-lg-12"> 
            <a href="#">
                <div class="card p-3">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="mb-6">
                                <label class="form-label" for="candidate_name">Candidate Name</label>
                                <input type="text" class="form-control" id="candidate_name" name="candidate_name" placeholder="Enter Company Name">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-6">
                                <label class="form-label" for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-6">
                                <label class="form-label" for="contact_no">Contact No.</label>
                                <input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="Enter Contact No.">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <button type="button" class="btn btn-primary mt-5" onclick="FilterData()">Filter</button>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header p-4">
            <h5 class="card-title">Free Candidates List</h5>
        </div>
        <hr class="my-1">
        <div class="card-body table-responsive p-4">
            <table id="FreePlanCandidateDataTable" class="table table-sm table-striped table-hover">
                <thead class="border-top">
                    <tr>
                        <th>Sr. NO.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact No.</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Plan</th>
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
</div>

@endsection



@push('script')
    <script>
        let datatable;

        function initCandidatesTable() {
            datatable = $('#FreePlanCandidateDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.free-candidate-plan-action.getcandidatetabledata') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = '{{ csrf_token() }}';
                        d.candidate_name = $('#candidate_name').val();
                        d.email = $('#email').val();
                        d.contact_no = $('#contact_no').val();
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
                        data: 'plan',
                        name: 'plan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        }

        // ✅ Filter data using existing DataTable instance
        function FilterData() {
            if (datatable) {
                datatable.ajax.reload();
            }
        }

        // ✅ Call this on page load
        $(document).ready(function() {
            initCandidatesTable();
        });
    </script>
@endpush
