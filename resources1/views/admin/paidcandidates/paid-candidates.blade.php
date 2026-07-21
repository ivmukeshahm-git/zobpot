@extends('admin.layout.layout')
@section('content')
   <script>
        page_active_id = "PaidCandidates";
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Product List Table -->
        <div class="row mb-5">
            <div class="col-lg-12">
                <a href="#">
                    <div class="card p-3">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-6">
                                    <label class="form-label" for="candidate_name">Candidate Name</label>
                                    <input type="text" class="form-control" id="candidate_name" name="candidate_name"
                                        placeholder="Enter Candidate Name">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="mb-6">
                                    <label class="form-label" for="purchase_date">Purchase Date</label>
                                    <input type="date" class="form-control" id="purchase_date" name="purchase_date"
                                        placeholder="John Doe">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="mb-6">
                                    <label class="form-label" for="expired_date">Expired Date</label>
                                    <input type="date" class="form-control" id="expired_date" name="expired_date"
                                        placeholder="John Doe">
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
                <h5 class="card-title">Paid Candidates List</h5>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="PaidCandidateDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Purchase Date</th>
                            <th>Expired Date</th>
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
        let datatable;

        function initCandidatesTable() {
            datatable = $('#PaidCandidateDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.paid-candidate-action.gettabledata') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = '{{ csrf_token() }}';
                        d.candidate_name = $('#candidate_name').val();
                        d.purchase_date = $('#purchase_date').val();
                        d.expired_date = $('#expired_date').val();
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
                        data: 'purchase_date',
                        name: 'purchase_date'
                    },
                    {
                        data: 'expire_date',
                        name: 'expire_date'
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
