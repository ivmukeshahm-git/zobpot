@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "CandidatesRegisterList";
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <div class="card-header p-4">
                <h5 class="card-title">Candidates Register List</h5>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="CandidatesRegisterListDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Currect Plan</th>
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


    <div class="modal fade" id="candidatesPlanHistory" tabindex="-1">
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
                url: "{{ route('admin.view-candidates-plan-history') }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    LoaderHide()
                    if (response.status === 1) {
                        $("#candidatesPlanHistory").modal('show');

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


        $(document).ready(function() {
            var datatable = $('#CandidatesRegisterListDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.candidates-register-list.gettabledata') }}",
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
        });
    </script>
@endpush
