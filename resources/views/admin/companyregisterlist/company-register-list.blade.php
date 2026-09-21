@extends('admin.layout.layout')
@section('content')
   <script>
        page_active_id = "CompanyRegisterList";
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header p-4">
                <h5 class="card-title">Company Register List</h5>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="CompanyRegisterListDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Current Plan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>


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

    {{-- Update Plan Modal --}}
    <div class="modal fade" id="updatePlanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="updatePlanForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Update Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="update_user_id" name="user_id">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Company</label>
                        <p class="mb-0" id="update_user_name">-</p>
                        <small class="text-muted" id="update_user_email"></small>
                    </div>

                    <div class="mb-3 p-3 rounded" style="background:#f5f5f9;">
                        <label class="form-label fw-semibold mb-1">Current Plan</label>
                        <div id="update_current_plan_name" class="fw-bold text-primary">-</div>
                        <small class="text-muted d-block" id="update_current_plan_meta"></small>
                    </div>

                    <div class="mb-3">
                        <label for="update_plan_id" class="form-label">Select New Plan <span class="text-danger">*</span></label>
                        <select id="update_plan_id" name="plan_id" class="form-select" required>
                            <option value="">Select Plan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="update_plan_service" class="form-label">Service <span class="text-danger">*</span></label>
                        <select id="update_plan_service" name="service" class="form-select" required>
                            <option value="none">None</option>
                            <option value="all">All</option>
                            <option value="job">Job</option>
                            <option value="internship">Internship</option>
                        </select>
                        <small class="text-muted">Controls Job / Internship access for this company</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3" id="update_job_limit_wrap" style="display:none;">
                            <label for="update_job_limit" class="form-label">Job Limit <span class="text-danger">*</span></label>
                            <input type="number" min="1" step="1" id="update_job_limit" name="job_limit" class="form-control" placeholder="e.g. 1">
                            <small class="text-muted">Max jobs this company can create</small>
                        </div>
                        <div class="col-md-6 mb-3" id="update_opportunity_limit_wrap" style="display:none;">
                            <label for="update_opportunity_limit" class="form-label">Internship Limit <span class="text-danger">*</span></label>
                            <input type="number" min="1" step="1" id="update_opportunity_limit" name="opportunity_limit" class="form-control" placeholder="e.g. 1">
                            <small class="text-muted">Max internships this company can create</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="update_plan_note" class="form-label">Note</label>
                        <textarea id="update_plan_note" name="note" class="form-control" rows="3"
                            placeholder="Optional note about this plan update..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="updatePlanBtn">Update Plan</button>
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

            $.ajax({
                type: "POST",
                url: "{{ route('admin.view-company-plan-history') }}",
                data: data,
                dataType: "json",
                success: function(response) {
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

        function OpenUpdatePlanModal(userId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (typeof LoaderShow === 'function') LoaderShow();

            $.ajax({
                type: "POST",
                url: "{{ route('admin.get-company-update-plan-data') }}",
                data: { user_id: userId },
                dataType: "json",
                success: function(response) {
                    if (typeof LoaderHide === 'function') LoaderHide();

                    if (response.status !== 1) {
                        toastr.warning(response.message || 'Unable to load plan data.', 'Warning');
                        return;
                    }

                    const data = response.data;
                    $('#update_user_id').val(data.user_id);
                    $('#update_user_name').text(data.user_name || '-');
                    $('#update_user_email').text(data.user_email || '');
                    $('#update_current_plan_name').text(data.current_plan_name || 'No Plan Purchased');

                    let meta = '';
                    if (data.current_plan_price !== null && data.current_plan_price !== undefined) {
                        meta += 'Price: ₹' + data.current_plan_price;
                    }
                    if (data.purchase_date || data.expire_date) {
                        meta += (meta ? ' | ' : '') +
                            'Purchase: ' + formatDate(data.purchase_date) +
                            ' | Expire: ' + formatDate(data.expire_date);
                    }
                    $('#update_current_plan_meta').text(meta);

                    let options = '<option value="">Select Plan</option>';
                    (data.plans || []).forEach(function(plan) {
                        const selected = (parseInt(data.active_plan_id) === parseInt(plan.plan_id)) ? 'selected' : '';
                        const service = (plan.service || 'none').toString().trim();
                        const jobLimit = plan.job_limit != null ? plan.job_limit : '';
                        const oppLimit = plan.opportunity_limit != null ? plan.opportunity_limit : '';
                        options += `<option value="${plan.plan_id}" data-service="${service}" data-job-limit="${jobLimit}" data-opportunity-limit="${oppLimit}" ${selected}>${plan.plan_name} — ₹${plan.plan_price} / ${plan.plan_time}${plan.plan_duration}</option>`;
                    });
                    $('#update_plan_id').html(options);
                    var svc = (data.current_service || 'none').toString().trim();
                    if (svc === 'opportunity') svc = 'internship';
                    $('#update_plan_service').val(svc);
                    $('#update_job_limit').val(data.job_limit || '');
                    $('#update_opportunity_limit').val(data.opportunity_limit || '');
                    toggleUpdatePlanLimitFields();
                    $('#update_plan_note').val('');
                    $('#updatePlanModal').modal('show');
                },
                error: function() {
                    if (typeof LoaderHide === 'function') LoaderHide();
                    toastr.error('Failed to load plan data.', 'Error');
                }
            });
        }

        function toggleUpdatePlanLimitFields() {
            var service = ($('#update_plan_service').val() || 'none').toString().trim();
            var showJob = (service === 'all' || service === 'job');
            var showOpp = (service === 'all' || service === 'opportunity' || service === 'internship');

            if (showJob) {
                $('#update_job_limit_wrap').show();
                $('#update_job_limit').prop('disabled', false);
            } else {
                $('#update_job_limit_wrap').hide();
                $('#update_job_limit').val('').prop('disabled', true);
            }

            if (showOpp) {
                $('#update_opportunity_limit_wrap').show();
                $('#update_opportunity_limit').prop('disabled', false);
            } else {
                $('#update_opportunity_limit_wrap').hide();
                $('#update_opportunity_limit').val('').prop('disabled', true);
            }
        }

        function fillLimitsFromSelectedPlan() {
            var $opt = $('#update_plan_id').find('option:selected');
            var jobLimit = $opt.data('job-limit');
            var oppLimit = $opt.data('opportunity-limit');
            if (jobLimit !== undefined && jobLimit !== null && String(jobLimit) !== '') {
                $('#update_job_limit').val(jobLimit);
            }
            if (oppLimit !== undefined && oppLimit !== null && String(oppLimit) !== '') {
                $('#update_opportunity_limit').val(oppLimit);
            }
        }

        $(document).ready(function() {
            $('#update_plan_id').on('change', function() {
                let service = ($(this).find('option:selected').data('service') || '').toString().trim();
                if (service === 'internship' || service === 'opportunity') service = 'internship';
                if (service) {
                    $('#update_plan_service').val(service);
                }
                fillLimitsFromSelectedPlan();
                toggleUpdatePlanLimitFields();
            });

            $('#update_plan_service').on('change', function() {
                toggleUpdatePlanLimitFields();
            });

            var datatable = $('#CompanyRegisterListDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.company-register-list.gettabledata') }}",
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

            $('#updatePlanForm').on('submit', function(e) {
                e.preventDefault();

                const planId = $('#update_plan_id').val();
                if (!planId) {
                    toastr.warning('Please select a plan.', 'Warning');
                    return;
                }

                const service = ($('#update_plan_service').val() || 'none').toString().trim();
                const jobLimit = $('#update_job_limit').val();
                const oppLimit = $('#update_opportunity_limit').val();
                if ((service === 'all' || service === 'job') && !jobLimit) {
                    toastr.warning('Please enter Job Limit.', 'Warning');
                    return;
                }
                if ((service === 'all' || service === 'internship' || service === 'opportunity') && !oppLimit) {
                    toastr.warning('Please enter Internship Limit.', 'Warning');
                    return;
                }

                const $btn = $('#updatePlanBtn');
                $btn.prop('disabled', true).text('Updating...');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.update-company-plan') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: $('#update_user_id').val(),
                        plan_id: planId,
                        service: service,
                        job_limit: jobLimit || null,
                        opportunity_limit: oppLimit || null,
                        note: $('#update_plan_note').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        $btn.prop('disabled', false).text('Update Plan');
                        if (response.status === 1) {
                            $('#updatePlanModal').modal('hide');
                            toastr.success(response.message || 'Plan updated successfully.', 'Success');
                            datatable.ajax.reload(null, false);
                        } else {
                            toastr.error(response.message || 'Failed to update plan.', 'Error');
                        }
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).text('Update Plan');
                        let msg = 'Failed to update plan.';
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            } else if (xhr.responseJSON.errors) {
                                const firstKey = Object.keys(xhr.responseJSON.errors)[0];
                                msg = xhr.responseJSON.errors[firstKey][0] || msg;
                            }
                        }
                        toastr.error(msg, 'Error');
                    }
                });
            });
        });
    </script>
@endpush
