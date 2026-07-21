@extends('admin.layout.layout')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Product List Table -->

        <div class="row mb-5">
            <div class="col-lg-12">
                <a href="#">
                    <div class="card p-3">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-6">
                                    <label class="form-label" for="staff_nm">Staff Name</label>
                                    <select name="staff_nm" class="form-control" id="staff_nm">
                                        <option value="" selected>-Select Staff-</option>
                                        @foreach ($StaffData as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="mb-6">
                                    <label class="form-label" for="start_date">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        placeholder="John Doe">
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="mb-6">
                                    <label class="form-label" for="end_date">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        placeholder="John Doe">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="mb-6">
                                    <label class="form-label" for="role">Department</label>
                                    <select name="role_nm" class="form-control" id="role_nm">
                                        <option value="" selected>-Select Department-</option>
                                        @foreach ($Roles as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <button type="button" class="btn btn-primary mt-5" onclick="FilterData()">Filter</button>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>


        <div class="card">
            <div class="card-header p-4">
                <h5 class="card-title">Staff Activity History</h5>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="StaffActivityHistoryDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Date Time</th>
                            <th>Activity</th>
                            <th>Staff Name</th>
                            <th>Department</th>
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
            datatable = $('#StaffActivityHistoryDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.staff-activity-history-action.gettabledata') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = '{{ csrf_token() }}';
                        d.staff_nm = $('#staff_nm').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.role_nm = $('#role_nm').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'datetime',
                        name: 'datetime'
                    },
                    {
                        data: 'msg',
                        name: 'msg'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'department_name',
                        name: 'department_name'
                    },
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
