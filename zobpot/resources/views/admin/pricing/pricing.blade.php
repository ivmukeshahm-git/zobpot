@push('css')
    <style>
        .plan-benifits-box {
            border: 1px solid #e6e6e6;
            padding: 10px;
            border-radius: 7px;
            background-color: #e9e9e9;
        }
    </style>
@endpush


@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "PlanPricing";
    </script>


    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Product List Table -->
        <div class="card">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Plan & Pricing</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        @can('PlanPricing-Add')
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#JobPricing"><i class='bx bx-plus'></i> Add</button>
                        @endcan
                    </div>
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="PricingDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Plan Name</th>
                            <th>Price</th>
                            <th>Plan For</th>
                            <th>Status</th>
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

 

    <!-- Modal -->
    <div class="modal modal-lg fade" id="JobPricing" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form id="pricing-form" class="modal-content" onsubmit="return false;">
                <div class="modal-header">
                    <h5 class="modal-title" id="JobPricingTitle">Plan & Pricing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8 mb-3">
                            <label for="nameBackdrop" class="form-label mb-2">Plan Name <span
                                    style="color:red;">*</span></label>
                            <input type="text" id="plan_name" name="plan_name" class="form-control"
                                placeholder="Enter Plan Name">
                        </div>

                        <div class="col-lg-4 ">
                            <label for="nameBackdrop" class="form-label mb-2">Plan Price <span
                                    style="color:red;">*</span></label>
                            <input type="text" id="plan_price" name="plan_price" class="form-control"
                                placeholder="Enter Price Amount">
                        </div>

                        <div class="col-lg-4">
                            <label for="nameBackdrop" class="form-label mb-2">Select Duration <span
                                    style="color:red;">*</span></label>
                            <select name="plan_duration" class="form-control" id="plan_duration">
                                <option value="" selected>Select Duration</option>
                                <option value="D">Day</option>
                                <option value="M">Month</option>
                                <option value="Y">Year</option>
                            </select>
                        </div>
                        <div class="col-lg-8">
                            <label for="nameBackdrop" class="form-label mb-2">Enter Duration Time <span
                                    style="color:red;">*</span></label>
                            <input type="text" id="duration_time" class="form-control" name="duration_time"
                                placeholder="Enter Plan Duration Time">
                        </div>



                        <div class="col-lg-12 mt-4">
                            <label for="nameBackdrop" class="form-label mb-2">Plan Description <span
                                    style="color:red;">*</span></label>
                            <input type="text" id="plan_description" name="plan_description" class="form-control"
                                placeholder="Enter Description">
                        </div>
                        <div class="col-lg-6 mt-4">
                            <label for="nameBackdrop" class="form-label mb-2">Plan For <span
                                    style="color:red;">*</span></label>
                            <select name="plan_for" class="form-control" id="plan_for">
                                <option value="Employee">Employee</option>
                                <option value="Company">Company</option>
                            </select>
                        </div>

                        <div class="col-lg-6 mt-4">
                            <label for="plan_service" class="form-label mb-2">Service <span
                                    style="color:red;">*</span></label>
                            <select name="service" class="form-control" id="plan_service">
                                <option value="none" selected>None</option>
                                <option value="all">All</option>
                                <option value="job">Job</option>
                                <option value="internship">Internship</option>
                            </select>
                            <small class="text-muted">Controls Job / Internship tabs on user profile</small>
                        </div>

                        <div class="col-lg-6 mt-4" id="job_limit_wrap" style="display: none;">
                            <label for="job_limit" class="form-label mb-2">
                                Job Limit <span style="color:red;">*</span>
                            </label>
                            <input type="number" min="1" step="1" id="job_limit" name="job_limit"
                                class="form-control" placeholder="Enter Job Limit (e.g. 1)">
                            <small class="text-muted">Company: max jobs to create. Candidate: max job applications.</small>
                        </div>

                        <div class="col-lg-6 mt-4" id="opportunity_limit_wrap" style="display: none;">
                            <label for="opportunity_limit" class="form-label mb-2">
                                Internship Limit <span style="color:red;">*</span>
                            </label>
                            <input type="number" min="1" step="1" id="opportunity_limit" name="opportunity_limit"
                                class="form-control" placeholder="Enter Internship Limit (e.g. 1)">
                            <small class="text-muted">Company: max internships to create. Candidate: max internship applications.</small>
                        </div>


                        <div class="mt-5">
                            <label for="nameBackdrop" class="form-label mb-2">
                                Plan Benefits <span style="color:red;">*</span>
                            </label>
                            <div class="plan-benifits-box" id="benifitsBoxHtml">
                                <div class="row mb-4 benefit-row benefit-add-row">
                                    <div class="col-lg-11">
                                        <input type="text" class="form-control" name="plan_benefits[]"
                                            id="plan_benefits" placeholder="Enter Benefits"
                                            style="background-color: #fff;">
                                    </div>
                                    <div class="col-lg-1">
                                        <button type="button" class="btn btn-sm btn-primary p-2 add-benefit">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>      
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>

                    <input type="hidden" id="_method" name="_method" value="POST">
                    <input type="hidden" id="flag" name="flag" value="A">
                    <input type="hidden" id="row_id" name="row_id">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            function decodeHtmlEntities(value) {
                if (value === null || value === undefined) {
                    return '';
                }
                var text = String(value);
                var textarea = document.createElement('textarea');
                // Decode repeatedly in case value was double-escaped (&amp;amp;)
                for (var i = 0; i < 3; i++) {
                    textarea.innerHTML = text;
                    var decoded = textarea.value;
                    if (decoded === text) {
                        break;
                    }
                    text = decoded;
                }
                return text;
            }

            function toggleServiceLimitField() {
                var service = ($("#plan_service").val() || 'none').toString().trim();
                var showJob = (service === 'all' || service === 'job');
                var showOpp = (service === 'all' || service === 'opportunity' || service === 'internship');

                if (showJob) {
                    $("#job_limit_wrap").show();
                    $("#job_limit").prop('disabled', false);
                } else {
                    $("#job_limit_wrap").hide();
                    $("#job_limit").val('').prop('disabled', true);
                }

                if (showOpp) {
                    $("#opportunity_limit_wrap").show();
                    $("#opportunity_limit").prop('disabled', false);
                } else {
                    $("#opportunity_limit_wrap").hide();
                    $("#opportunity_limit").val('').prop('disabled', true);
                }
            }

            $("#plan_service").on('change', toggleServiceLimitField);
            toggleServiceLimitField();

            var datatable = $('#PricingDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.pricing.gettabledata') }}",
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
                        data: 'plan_name',
                        name: 'plan_name'
                    },
                    {
                        data: 'price_duration',
                        name: 'price_duration'
                    },
                    {
                        data: 'plan_for',
                        name: 'plan_for'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ]
            });

            $('#PricingDataTable tbody').on('click', '.view-details-btn', function() {
                var $row = $(this).closest('tr');
                var rowData = datatable.row($row).data();

                // Open modal
                $("#JobPricing").modal("show");


                // Fill form fields (decode DataTables HTML escaping so "&amp;" never appears in inputs)
                $("#plan_name").val(decodeHtmlEntities(rowData.plan_name));
                $("#plan_price").val(rowData.plan_price);
                $("#duration_time").val(rowData.plan_time);
                $("#plan_description").val(decodeHtmlEntities(rowData.plan_description));
                $("#plan_for").val(String(rowData.plan_for_type || '').trim()).trigger('change');
                $("#plan_duration").val(rowData.plan_duration).trigger('change');
                var serviceVal = (rowData.service || 'none').toString().trim();
                if (serviceVal === 'opportunity') {
                    serviceVal = 'internship';
                }
                $("#plan_service").val(serviceVal).trigger('change');
                $("#job_limit").val(rowData.job_limit || '');
                $("#opportunity_limit").val(rowData.opportunity_limit || '');
                // Fallback: old single service_limit
                if (!rowData.job_limit && !rowData.opportunity_limit && rowData.service_limit) {
                    if (serviceVal === 'all' || serviceVal === 'job') {
                        $("#job_limit").val(rowData.service_limit);
                    }
                    if (serviceVal === 'all' || serviceVal === 'opportunity' || serviceVal === 'internship') {
                        $("#opportunity_limit").val(rowData.service_limit);
                    }
                }
                toggleServiceLimitField();

                // Load existing benefits first, keep blank "+" row always at the end
                var addRowHtml = `
                <div class="row mb-4 benefit-row benefit-add-row">
                    <div class="col-lg-11">
                        <input type="text" class="form-control" name="plan_benefits[]"
                            placeholder="Enter Benefits" style="background-color: #fff;">
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-sm btn-primary p-2 add-benefit">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>`;
                $("#benifitsBoxHtml").empty();

                var benefitsRaw = decodeHtmlEntities(rowData.benefits || '');
                var benefits = benefitsRaw ? benefitsRaw.split(',') : [];
                benefits.forEach(function(benefit) {
                    var text = decodeHtmlEntities((benefit || '').toString().trim());
                    if (!text || text.toLowerCase() === 'null') {
                        return;
                    }
                    var $row = $(`
        <div class="row mb-4 benefit-row">
            <div class="col-lg-11">
                <input type="text" class="form-control" name="plan_benefits[]" value="" placeholder="Enter Benefits" style="background-color: #fff;">
            </div>
            <div class="col-lg-1">
                <button type="button" class="btn btn-sm btn-danger p-2 remove-benefit">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>`);
                    $row.find("input[name='plan_benefits[]']").val(text);
                    $("#benifitsBoxHtml").append($row);
                });
                $("#benifitsBoxHtml").append(addRowHtml);

                // Set form state
                $("#JobPricingTitle").text("Edit Plan & Pricing");


                $("#flag").val("U");
                $("#row_id").val(rowData.plan_id);
                $("#_method").val("PUT");
            });


            $('#PricingDataTable tbody').on('click', '.plan-status-btn', function () {
                var planId = $(this).data('id');
                var isActive = parseInt($(this).data('status'), 10) === 1;

                Swal.fire({
                    title: isActive ? 'Deactivate this plan?' : 'Activate this plan?',
                    text: isActive
                        ? 'This plan will be hidden on the website and cannot be purchased.'
                        : 'This plan will show on the website and can be purchased.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: isActive ? 'Yes, deactivate' : 'Yes, activate',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3',
                        cancelButton: 'btn btn-label-secondary'
                    }
                }).then((result) => {
                    if (!result.isConfirmed) {
                        return;
                    }

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.pricing.status') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            plan_id: planId
                        },
                        success: function (response) {
                            if (response.status === 1) {
                                datatable.ajax.reload(null, false);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated',
                                    text: response.message,
                                    customClass: { confirmButton: 'btn btn-primary' }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Unable to update',
                                    text: response.message || 'Please try again.',
                                    customClass: { confirmButton: 'btn btn-primary' }
                                });
                            }
                        },
                        error: function (xhr) {
                            var message = (xhr.responseJSON && xhr.responseJSON.message)
                                ? xhr.responseJSON.message
                                : 'Please try again.';
                            Swal.fire({
                                icon: 'error',
                                title: 'Unable to update',
                                text: message,
                                customClass: { confirmButton: 'btn btn-primary' }
                            });
                        }
                    });
                });
            });

            $('#PricingDataTable tbody').on('click', '.delete-plan-btn',
                function() { // Delegated event handler for the button
                    var $row = $(this).closest('tr'); // Get the closest row element
                    var rowData = datatable.row($row).data(); // Get the entire row data object


                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Are you sure to delete Pricing?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, confirm!',
                        customClass: {
                            confirmButton: 'btn btn-primary me-3',
                            cancelButton: 'btn btn-label-secondary'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            var PlanId = rowData.plan_id;
                            var data = {
                                'PlanId': PlanId
                            }

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            LoaderShow()

                            $.ajax({
                                type: "DELETE",
                                url: "{{ url('admin/pricing') }}/" + PlanId,
                                data: data,
                                dataType: "json",
                                success: function(response) {
                                    LoaderHide()
                                    if (response.status === 1) {
                                        toastr.success(response.message, 'Success');


                                        location.reload();
                                    } else {
                                        toastr.warning(response.message, 'Warning');
                                    }
                                }
                            });
                            return false;
                        }
                    });
                });




            $('#JobPricing').on('hidden.bs.modal', function() {
                var $form = $("#pricing-form");
                $form[0].reset();
                if (typeof validator !== 'undefined' && validator) {
                    validator.resetForm();
                }
                $form.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
                $form.find('.error').remove();

                $("#_method").val("POST");
                $("#flag").val("A");
                $("#row_id").val("");
                $("#JobPricingTitle").text("Plan & Pricing");

                $("#plan_name").val('');
                $("#plan_price").val('');
                $("#duration_time").val('');
                $("#plan_description").val('');
                $("#plan_for").val('').trigger('change');
                $("#plan_duration").val('').trigger('change');
                $("#plan_service").val("none").trigger('change');
                $("#job_limit").val('').prop('disabled', true);
                $("#opportunity_limit").val('').prop('disabled', true);
                toggleServiceLimitField();

                $("#benifitsBoxHtml").html(`
                <div class="row mb-4 benefit-row benefit-add-row">
                    <div class="col-lg-11">
                        <input type="text" class="form-control" name="plan_benefits[]"
                            placeholder="Enter Benefits" style="background-color: #fff;">
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-sm btn-primary p-2 add-benefit">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>`);
            });


        });


        let validator = $("#pricing-form").validate({
            rules: {
                plan_name: {
                    required: true
                },
                plan_price: {
                    required: true
                },
                plan_duration: {
                    required: true
                },
                duration_time: {
                    required: true
                },
                plan_description: {
                    required: true
                },
                plan_for: {
                    required: true
                },
                service: {
                    required: true
                },
                job_limit: {
                    required: {
                        depends: function() {
                            var service = ($("#plan_service").val() || 'none').toString().trim();
                            return service === 'all' || service === 'job';
                        }
                    },
                    digits: true,
                    min: 1
                },
                opportunity_limit: {
                    required: {
                        depends: function() {
                            var service = ($("#plan_service").val() || 'none').toString().trim();
                            return service === 'all' || service === 'opportunity' || service === 'internship';
                        }
                    },
                    digits: true,
                    min: 1
                },

            },
            messages: {
                plan_name: {
                    required: "Please Enter Plan Name"
                },
                plan_price: {
                    required: "Please Enter Plan Price"
                },
                plan_duration: {
                    required: "Please Enter Plan Duration"
                },
                duration_time: {
                    required: "Please Enter Duration Time"
                },
                plan_description: {
                    required: "Please Enter Plan Description"
                },
                plan_for: {
                    required: "Please Select Plan For"
                },
                service: {
                    required: "Please Select Service"
                },
                job_limit: {
                    required: "Please Enter Job Limit",
                    digits: "Please Enter a Valid Number",
                    min: "Job Limit must be at least 1"
                },
                opportunity_limit: {
                    required: "Please Enter Internship Limit",
                    digits: "Please Enter a Valid Number",
                    min: "Internship Limit must be at least 1"
                },
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                error.insertAfter(element);
            },
            highlight: function(element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            }
        });

        // ✅ Final submission with AJAX
        $("#pricing-form").submit(function(e) {
            e.preventDefault();

            if (!$("#pricing-form").valid()) {
                return;
            }

            // Clear empty / null values from trailing add row before serialize
            $("#benifitsBoxHtml .benefit-add-row input[name='plan_benefits[]']").each(function() {
                var val = ($(this).val() || '').toString().trim();
                if (!val || val.toLowerCase() === 'null') {
                    $(this).prop('disabled', true);
                }
            });
            $("#benifitsBoxHtml .benefit-row:not(.benefit-add-row) input[name='plan_benefits[]']").each(function() {
                var val = ($(this).val() || '').toString().trim();
                if (!val || val.toLowerCase() === 'null') {
                    $(this).closest('.benefit-row').remove();
                }
            });

            let form = $(this);
            let formData = form.serialize();

            // Re-enable add-row input after serialize
            $("#benifitsBoxHtml .benefit-add-row input[name='plan_benefits[]']").prop('disabled', false);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var flag = $("#flag").val();
            var id = $("#row_id").val();

            var url = "";
            if (flag == "A") {
                url = "{{ route('admin.pricing.store') }}";
            } else {
                url = "{{ url('admin/pricing') }}/" + id;
            }

            LoaderShow()

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(response) {
                    LoaderHide()
                    if (response.status === 1) {
                        toastr.success(response.message, 'Success');
                        form[0].reset();
                        validator.resetForm();

                        location.reload();
                    } else {
                        toastr.warning(response.message, 'Warning');
                    }
                },
                error: function(xhr) {
                    LoaderHide()
                    console.log(xhr.responseText);
                    toastr.error(response.message, 'Error');
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const benefitsBox = document.querySelector(".plan-benifits-box");

            benefitsBox.addEventListener("click", function(e) {
                if (e.target.closest(".add-benefit")) {
                    const addRow = e.target.closest(".benefit-row");
                    const addInput = addRow ? addRow.querySelector("input[name='plan_benefits[]']") : null;
                    const typedValue = addInput ? (addInput.value || '').trim() : '';

                    const newBenefitRow = document.createElement("div");
                    newBenefitRow.classList.add("row", "mb-4", "benefit-row");
                    const safeValue = $('<div>').text(typedValue).html();
                    newBenefitRow.innerHTML = `
                    <div class="col-lg-11">
                        <input type="text" class="form-control" name="plan_benefits[]" value="${safeValue}" placeholder="Enter Benefits" style="background-color: #fff;">
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-sm btn-danger p-2 remove-benefit">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                `;
                    // Prefer setting value via property so "&" stays as "&" (no &amp; in the field)
                    const createdInput = newBenefitRow.querySelector("input[name='plan_benefits[]']");
                    if (createdInput) {
                        createdInput.value = typedValue;
                    }
                    // Keep "+" row always last
                    if (addRow && addRow.parentNode) {
                        addRow.parentNode.insertBefore(newBenefitRow, addRow);
                    } else {
                        benefitsBox.appendChild(newBenefitRow);
                    }
                    if (addInput) {
                        addInput.value = '';
                        addInput.focus();
                    }
                }

                if (e.target.closest(".remove-benefit")) {
                    e.target.closest(".benefit-row").remove();
                }
            });
        });
    </script>
@endpush
