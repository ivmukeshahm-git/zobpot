@extends('admin.layout.layout')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <style>
        .candidate-report-toolbar {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            flex-wrap: wrap;
        }

        .candidate-report-toolbar .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }
    </style>
    <script>
        page_active_id = "CandidatesRegisterList";
    </script>

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <div class="card-header p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h5 class="card-title">Candidates Register List</h5>
                <div class="candidate-report-toolbar">
                    @can('Candidate-candidate_register_list_download_csv')
                    <button type="button" class="btn btn-outline-success btn-sm" id="downloadCandidatesCsv">
                        <i class="fa fa-file-text-o"></i> Download CSV
                    </button>
                    @endcan
                    @can('Candidate-candidate_register_list_download_report')
                    <button type="button" class="btn btn-primary btn-sm" id="downloadCandidatesReport">
                        <i class="fa fa-download"></i> Download Report
                    </button>
                    @endcan
                </div>
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
                        <label for="update_plan_service" class="form-label">Service <span class="text-danger">*</span></label>
                        <select id="update_plan_service" name="service" class="form-select" required>
                            <option value="none">None</option>
                            <option value="all">All</option>
                            <option value="job">Job</option>
                            <option value="internship">Internship</option>
                        </select>
                        <small class="text-muted">Controls Job / Internship access for this candidate</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3" id="update_job_limit_wrap" style="display:none;">
                            <label for="update_job_limit" class="form-label">Job Limit <span class="text-danger">*</span></label>
                            <input type="number" min="1" step="1" id="update_job_limit" name="job_limit" class="form-control" placeholder="e.g. 1">
                            <small class="text-muted">Max job applications for this candidate</small>
                        </div>
                        <div class="col-md-6 mb-3" id="update_opportunity_limit_wrap" style="display:none;">
                            <label for="update_opportunity_limit" class="form-label">Internship Limit <span class="text-danger">*</span></label>
                            <input type="number" min="1" step="1" id="update_opportunity_limit" name="opportunity_limit" class="form-control" placeholder="e.g. 1">
                            <small class="text-muted">Max internship applications for this candidate</small>
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
    <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.8.2/dist/jspdf.plugin.autotable.min.js"></script>
    <script>
        var datatable;

        const reportLogoUrl = @json(
            $Setting && $Setting->header_logo
                ? asset('uploads/logo_img/' . $Setting->header_logo)
                : asset('assets/imgs/logo/logo1.png')
        );
        const reporterLoginId = @json($loginUser->email ?? $loginUser->id ?? '-');

        function getCandidateTableRows() {
            return datatable.rows({ search: 'applied' }).data().toArray().map(function(row, index) {
                return [
                    index + 1,
                    row.name || '-',
                    row.email || '-',
                    row.contact_no || '-',
                    row.state_name || '-',
                    row.city_nm || '-',
                    $('<div>').html(row.plan || '-').text().trim(),
                    formatDate(row.purchase_date)
                ];
            });
        }

        function exportAllCandidateRows(callback) {
            const currentLength = datatable.page.len();
            datatable.one('draw', function() {
                callback(getCandidateTableRows());
                datatable.page.len(currentLength).draw(false);
            });
            datatable.page.len(-1).draw();
        }

        function imageToDataUrl(url) {
            return new Promise(function(resolve) {
                const image = new Image();
                image.crossOrigin = 'anonymous';
                image.onload = function() {
                    const canvas = document.createElement('canvas');
                    canvas.width = image.naturalWidth;
                    canvas.height = image.naturalHeight;
                    canvas.getContext('2d').drawImage(image, 0, 0);
                    resolve(canvas.toDataURL('image/png'));
                };
                image.onerror = function() { resolve(null); };
                image.src = url;
            });
        }

        function downloadCandidateReport(rows) {
            rows = rows || getCandidateTableRows();
            if (!rows.length) {
                toastr.warning('No candidate data available for the report.', 'Warning');
                return;
            }

            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF('landscape', 'mm', 'a4');
            const reportDate = new Date().toLocaleString();

            imageToDataUrl(reportLogoUrl).then(function(logo) {
                if (logo) {
                    pdf.addImage(logo, 'PNG', 14, 10, 42, 16, undefined, 'FAST');
                }

                pdf.setFontSize(16);
                pdf.setTextColor(36, 42, 98);
                pdf.text('Candidates Register Report', 148, 17, { align: 'center' });
                pdf.setFontSize(9);
                pdf.setTextColor(90, 90, 90);
                pdf.text('Generated: ' + reportDate, 283, 17, { align: 'right' });
                pdf.text('Reported By: ' + reporterLoginId, 283, 23, { align: 'right' });

                pdf.autoTable({
                    startY: 34,
                    head: [['Sr. No.', 'Name', 'Email', 'Contact No.', 'State', 'City', 'Current Plan', 'Purchase Date']],
                    body: rows,
                    theme: 'grid',
                    styles: {
                        fontSize: 9,
                        cellPadding: 3,
                        textColor: [45, 45, 45],
                        lineColor: [220, 224, 234],
                        lineWidth: 0.2
                    },
                    headStyles: {
                        fillColor: [36, 42, 98],
                        textColor: [255, 255, 255],
                        fontStyle: 'bold'
                    },
                    alternateRowStyles: { fillColor: [247, 248, 252] },
                    margin: { left: 14, right: 14 }
                });

                pdf.save('candidates-register-report-' + new Date().toISOString().slice(0, 10) + '.pdf');
            });
        }

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

        function deleteCandidate(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will permanently delete this candidate and cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then(function(result) {
                if (!result.isConfirmed) {
                    return;
                }

                $.ajax({
                    type: 'DELETE',
                    url: "{{ url('admin/candidates-register-list') }}/" + id,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            datatable.ajax.reload(null, false);
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: response.message });
                        }
                    },
                    error: function(xhr) {
                        var message = xhr.responseJSON && xhr.responseJSON.message
                            ? xhr.responseJSON.message
                            : 'Failed to delete candidate.';
                        Swal.fire({ icon: 'error', title: 'Error', text: message });
                    }
                });
            });
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

            datatable = $('#CandidatesRegisterListDataTable').DataTable({
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

            $('#downloadCandidatesCsv').on('click', function() {
                const headers = ['Sr. No.', 'Name', 'Email', 'Contact No.', 'State', 'City', 'Current Plan', 'Purchase Date'];
                exportAllCandidateRows(function(rows) {
                    const csv = [headers].concat(rows).map(function(row) {
                        return row.map(function(value) {
                            return '"' + String(value).replace(/"/g, '""') + '"';
                        }).join(',');
                    }).join('\r\n');
                    const blob = new Blob(["\ufeff" + csv], { type: 'text/csv;charset=utf-8;' });
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = 'candidates-register-' + new Date().toISOString().slice(0, 10) + '.csv';
                    link.click();
                    URL.revokeObjectURL(link.href);
                });
            });

            $('#downloadCandidatesReport').on('click', function() {
                exportAllCandidateRows(downloadCandidateReport);
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
                    url: "{{ route('admin.update-candidates-plan') }}",
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
