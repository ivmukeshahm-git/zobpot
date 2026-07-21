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
                        <label class="form-label fw-semibold">Candidate</label>
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

        function OpenUpdatePlanModal(userId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (typeof LoaderShow === 'function') LoaderShow();

            $.ajax({
                type: "POST",
                url: "{{ route('admin.get-candidates-update-plan-data') }}",
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
                        options += `<option value="${plan.plan_id}" ${selected}>${plan.plan_name} — ₹${plan.plan_price} / ${plan.plan_time}${plan.plan_duration}</option>`;
                    });
                    $('#update_plan_id').html(options);
                    $('#update_plan_note').val('');
                    $('#updatePlanModal').modal('show');
                },
                error: function() {
                    if (typeof LoaderHide === 'function') LoaderHide();
                    toastr.error('Failed to load plan data.', 'Error');
                }
            });
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

            $('#updatePlanForm').on('submit', function(e) {
                e.preventDefault();

                const planId = $('#update_plan_id').val();
                if (!planId) {
                    toastr.warning('Please select a plan.', 'Warning');
                    return;
                }

                const $btn = $('#updatePlanBtn');
                $btn.prop('disabled', true).text('Updating...');

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.update-candidates-plan') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: $('#update_user_id').val(),
                        plan_id: planId,
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
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        toastr.error(msg, 'Error');
                    }
                });
            });
        });
    </script>
@endpush
