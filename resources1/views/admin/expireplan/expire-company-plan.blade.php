@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "ExpiredPlan-Candidate";
    </script>
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-lg-12">
                <div class="nav-align-top mb-6">
                    <ul class="nav nav-pills mb-4 menu-bar" role="tablist">
                        @can('Company-company_expire_plan')
                            <li class="nav-item">
                                <a href="{{ route('admin.expire-company-plan') }}" class="nav-link active">
                                    Company
                                </a>
                            </li>
                        @endcan
                        @can('Candidate-candidate_expire_plan')
                            <li class="nav-item">
                                <a href="{{ route('admin.expire-candidates-plan') }}" class="nav-link">
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
                                    <label class="form-label" for="company_name">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name"
                                        placeholder="Enter Company Name">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="mb-6">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="John Doe">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="mb-6">
                                    <label class="form-label" for="contact_no">Contact No.</label>
                                    <input type="text" class="form-control" id="contact_no" name="contact_no"
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
                <h5 class="card-title">Free Company List</h5>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="ExpiredPlanCompanyDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <th>State</th>
                            <th>Expire On</th>
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



    <div class="modal fade" id="CompanyPlanHistory" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">Plan History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Plan Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Purchase Date</th>
                                <th scope="col">Expire Date</th>
                            </tr>
                        </thead>
                        <tbody id="PlanHistoryHtml">

                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
@endsection



@push('script')
    <script>
        let datatable;

        function initCandidatesTable() {
            datatable = $('#ExpiredPlanCompanyDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.expire-company-action.getcompanytabledata') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = '{{ csrf_token() }}';
                        d.company_name = $('#company_name').val();
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
                        data: 'expire_date',
                        name: 'expire_date'
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


        function ViewPlanHistory(id) {
            $("#PlanHistoryHtml").html("")
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
                type: "POST",
                url: "{{ route('admin.expired-plan-history') }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    LoaderHide()
                    if (response.status === 1) {
                        $("#CompanyPlanHistory").modal('show');

                        var data = response.data;
                        var html = "";
                        data.forEach(function(item, index) {

                            html += `
                    <tr>
                        <th scope="row">${ item.plan_name }</th>
                        <td>₹ ${ item.plan_price }/${item.duration}</td>
                        <td>${ formatDate(item.purchase_date) }</td>
                        <td>${ formatDate(item.expire_date) }</td>
                    </tr>`;


                        });

                        $("#PlanHistoryHtml").append(html)

                    } else {
                        toastr.warning(response.message, 'Warning');
                    }
                }
            });
            return false;
        }

        function formatDate(dateStr) {
            if (!dateStr) return '-';
            const d = new Date(dateStr);
            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const year = d.getFullYear();
            return `${ day }-${ month }-${ year }`;
        }
    </script>
@endpush
