@push('css')
    <style>
        .applied-filter .select2-container { width: 100% !important; }
        .applied-filter .select2-selection--multiple {
            min-height: 38px;
            border: 1px solid #d9dee3;
            border-radius: 6px;
        }
        .applied-filter .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #696cff;
        }
        .applied-filter .select2-container { min-width: 100%; }
        .application-summary {
            border: 1px solid #e7e7e7;
            border-left: 4px solid #242a62;
            border-radius: 8px;
        }
        .application-summary .summary-number {
            color: #242a62;
            font-size: 24px;
            font-weight: 700;
        }
        .application-summary .summary-amount { font-size: 13px; }
    </style>
@endpush

@extends('admin.layout.layout')

@section('content')
    <script>page_active_id = "Internship-AppliedInternshipApplications";</script>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h5 class="card-title mb-1">Applied Internship Applications</h5>
                        <small class="text-muted">All internship applications</small>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-arrow-back"></i> Back
                        </a>
                    </div>
                </div>
            </div>
            <hr class="my-1">

            <div class="card-body pb-0">
                <div class="row g-3 mb-4 applied-filter">
                    <div class="col-lg-4">
                        <label class="form-label" for="internship_id">Approved Internship</label>
                        <select id="internship_id" class="form-select" multiple>
                            @foreach ($approvedInternships as $internship)
                                <option value="{{ $internship->id }}">{{ $internship->internship_title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label" for="payment_status">Payment Status</label>
                        <select id="payment_status" class="form-select">
                            <option value="">All</option>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label" for="date_from">Applied From</label>
                        <input type="date" id="date_from" class="form-control">
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label" for="date_to">Applied To</label>
                        <input type="date" id="date_to" class="form-control">
                    </div>
                    <div class="col-lg-2 d-flex align-items-end gap-2">
                        <button type="button" id="applyFilters" class="btn btn-primary btn-sm flex-fill px-2">
                            <i class="bx bx-filter-alt"></i> Apply
                        </button>
                        <button type="button" id="resetFilters" class="btn btn-outline-secondary btn-sm flex-fill px-2">
                            <i class="bx bx-reset"></i> Reset
                        </button>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="application-summary p-3">
                            <small class="text-muted">Total Applications</small>
                            <div class="summary-number" id="totalApplications">0</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="application-summary p-3">
                            <small class="text-muted">Paid Applications</small>
                            <div class="summary-number text-success" id="paidApplications">0</div>
                            <small class="summary-amount text-success">Payment Amount: ₹<span id="paidAmount">0.00</span></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="application-summary p-3">
                            <small class="text-muted">Unpaid Applications</small>
                            <div class="summary-number text-danger" id="unpaidApplications">0</div>
                            <small class="summary-amount text-danger">Payment Amount: ₹<span id="unpaidAmount">0.00</span></small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-4 pt-0">
                <table id="AppliedInternshipsDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Name</th>
                            <th>Contact No.</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>Internship Title</th>
                            <th>Applied At</th>
                            <th>Payment</th>
                            <th>Amount</th>
                            @can('Internship-Application-Delete')
                                <th>Action</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('#internship_id').select2({
                placeholder: 'Select approved internships',
                allowClear: true,
                closeOnSelect: false
            });
            $('#payment_status').select2({
                minimumResultsForSearch: Infinity,
                width: '100%'
            });

            function updateSummary(summary) {
                $('#totalApplications').text(summary.total || 0);
                $('#paidApplications').text(summary.paid_count || 0);
                $('#paidAmount').text(summary.paid_amount || '0.00');
                $('#unpaidApplications').text(summary.unpaid_count || 0);
                $('#unpaidAmount').text(summary.unpaid_amount || '0.00');
            }

            var table = $('#AppliedInternshipsDataTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ route('admin.internship.applied-internships.data') }}",
                    type: "GET",
                    data: function (d) {
                        d.internship_id = $('#internship_id').val() || [];
                        d.payment_status = $('#payment_status').val();
                        d.date_from = $('#date_from').val();
                        d.date_to = $('#date_to').val();
                    },
                    dataSrc: function (response) {
                        updateSummary(response.summary || {});
                        return response.data || [];
                    }
                },
                columns: [
                    {
                        data: null,
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    { data: 'name', name: 'name' },
                    { data: 'contact_no', name: 'contact_no' },
                    { data: 'email', name: 'email' },
                    { data: 'city', name: 'city' },
                    { data: 'internship_title', name: 'internship_title' },
                    { data: 'applied_at', name: 'applied_at' },
                    { data: 'payment_status', name: 'payment_status',
                        render: function (data) {
                            return '<span class="badge ' + (data === 'Paid' ? 'bg-success' : 'bg-secondary') + '">' + data + '</span>';
                        }
                    },
                    { data: 'payment_amount', name: 'payment_amount' }
                    @can('Internship-Application-Delete')
                        , {
                            data: null,
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function (data, type, row) {
                                return '<button type="button" class="btn btn-sm btn-danger delete-application" ' +
                                    'data-id="' + row.application_id + '" title="Delete application">' +
                                    '<i class="bx bx-trash"></i></button>';
                            }
                        }
                    @endcan
                ],
                order: [[6, 'desc']],
                drawCallback: function () {
                    var pageInfo = this.api().page.info();

                    this.api().rows({ page: 'current' }).every(function (rowIndex, tableLoop, rowLoop) {
                        $(this.node()).find('td:first').text(pageInfo.start + rowLoop + 1);
                    });
                }
            });

            $('#applyFilters').on('click', function () {
                table.ajax.reload();
            });

            $('#resetFilters').on('click', function () {
                $('#internship_id').val(null).trigger('change');
                $('#payment_status').val('').trigger('change');
                $('#date_from').val('');
                $('#date_to').val('');
                table.ajax.reload();
            });

            $('#AppliedInternshipsDataTable tbody').on('click', '.delete-application', function () {
                var applicationId = $(this).data('id');

                Swal.fire({
                    title: 'Delete application?',
                    text: 'This application will be soft deleted.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, delete it'
                }).then(function (result) {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $.ajax({
                        url: "{{ url('admin/internship/applied-internships') }}/" + applicationId,
                        type: 'DELETE',
                        data: { _token: "{{ csrf_token() }}" },
                        success: function (response) {
                            Swal.fire('Deleted', response.message, 'success');
                            table.ajax.reload(null, false);
                        },
                        error: function (xhr) {
                            Swal.fire(
                                'Error',
                                xhr.responseJSON && xhr.responseJSON.message
                                    ? xhr.responseJSON.message
                                    : 'Unable to delete application.',
                                'error'
                            );
                        }
                    });
                });
            });
        });
    </script>
@endpush
