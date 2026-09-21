@push('css')
    <style>
        #AddInterviewTips {
            display: none;
        }

        .tip-point-row {
            border: 1px solid #e3e3e3;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            background: #fafafa;
        }

        .tip-point-number {
            width: 36px;
            height: 36px;
            min-width: 36px;
            border-radius: 50%;
            background: #233554;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 15px;
        }

        .add-point-btn {
            display: none !important;
        }

        #points-wrapper .tip-point-row:last-child .add-point-btn {
            display: inline-flex !important;
        }
    </style>
@endpush

@extends('admin.layout.layout')
@section('content')
    <script>
        page_active_id = "InterviewTips";
    </script>


    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card" id="ListOfInterviewTips">
            <div class="card-header p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title">Interview Tips</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        @can('InterviewTips-Add')
                        <button type="button" class="btn btn-sm btn-primary" onclick="AddInterviewTips()"><i class='bx bx-plus'></i>
                            Add</button>
                        @endcan
                    </div>
                </div>
            </div>
            <hr class="my-1">
            <div class="card-body table-responsive p-4">
                <table id="InterviewTipsDataTable" class="table table-sm table-striped table-hover">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. NO.</th>
                            <th>Main Header</th>
                            <th>Short Line</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="card" id="AddInterviewTips">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="card-title" id="form-card-title">Add New Interview Tip</h5>
                    </div>
                    <div class="col-lg-6" style="text-align: right;">
                        <button type="button" class="btn btn-sm btn-primary" onclick="backtoList()"><i
                                class='fa fa-long-arrow-left'></i>&nbsp; Back</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="interview-tips-form" onsubmit="return false;" method="POST">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label class="form-label">Main Header</label>
                                <input type="text" class="form-control" id="main_header" name="main_header"
                                    placeholder="Enter Main Header (e.g. Interview Tips)">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <select class="form-select" id="action_type" name="action_type">
                                    <option value="1">Published</option>
                                    <option value="2">Draft</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Short Line</label>
                                <input type="text" class="form-control" id="short_line" name="short_line"
                                    placeholder="Enter Short Line">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label class="form-label">Points</label>
                            <div id="points-wrapper">
                                <div class="tip-point-row">
                                    <div class="d-flex gap-3">
                                        <div class="tip-point-number">1</div>
                                        <div class="flex-grow-1">
                                            <div class="mb-2">
                                                <label class="form-label">Main Point</label>
                                                <input type="text" class="form-control" name="points[0][title]"
                                                    placeholder="Enter Main Point">
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control" name="points[0][description]" rows="2"
                                                    placeholder="Enter Point Description"></textarea>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column gap-2 align-self-start point-actions">
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary move-up-btn" onclick="movePoint(this, -1)">
                                                <i class='bx bx-up-arrow-alt'></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-secondary move-down-btn" onclick="movePoint(this, 1)">
                                                <i class='bx bx-down-arrow-alt'></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-icon btn-danger" onclick="removePoint(this)">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-icon btn-primary add-point-btn" onclick="addPoint()">
                                                <i class='bx bx-plus'></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Footer</label>
                                <input type="text" class="form-control" id="footer_title" name="footer_title"
                                    placeholder="Enter Footer (e.g. Good to Remember)">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Footer Description</label>
                                <textarea class="form-control" id="footer_description" name="footer_description" rows="3"
                                    placeholder="Enter Footer Description"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <input type="hidden" id="_method" name="_method" value="POST">
                            <input type="hidden" id="flag" name="flag" value="A">
                            <input type="hidden" id="row_id" name="row_id">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            var datatable = $('#InterviewTipsDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.interview-tips.gettabledata') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = '{{ csrf_token() }}';
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'main_header',
                        name: 'main_header'
                    },
                    {
                        data: 'short_line',
                        name: 'short_line'
                    },
                    {
                        data: 'add_date',
                        name: 'add_date'
                    },
                    {
                        data: 'status_text',
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

            $('#InterviewTipsDataTable tbody').on('click', '.view-details-btn', function() {
                var $row = $(this).closest('tr');
                var rowData = datatable.row($row).data();

                LoaderShow();
                $.ajax({
                    type: "GET",
                    url: "{{ url('admin/interview-tips') }}/" + rowData.id + "/edit",
                    dataType: "json",
                    success: function(response) {
                        LoaderHide();
                        var data = response.data || {};

                        resetForm();
                        document.getElementById("AddInterviewTips").style.display = "block";
                        document.getElementById("ListOfInterviewTips").style.display = "none";
                        $("#form-card-title").text("Edit Interview Tip");

                        $("#main_header").val(data.main_header);
                        $("#short_line").val(data.short_line);
                        $("#footer_title").val(data.footer_title);
                        $("#footer_description").val(data.footer_description);
                        $("#action_type").val(String(data.status));

                        var points = data.points || [];
                        $("#points-wrapper").html("");
                        if (points.length) {
                            points.forEach(function(point) {
                                addPoint(point.title, point.description);
                            });
                        } else {
                            addPoint();
                        }

                        $("#flag").val("U");
                        $("#row_id").val(data.id);
                        $("#_method").val("PUT");
                    },
                    error: function() {
                        LoaderHide();
                        toastr.error("Failed to load interview tip.", "Error");
                    }
                });
            });

            $('#InterviewTipsDataTable tbody').on('click', '.delete-interview-tips-btn', function() {
                var $row = $(this).closest('tr');
                var rowData = datatable.row($row).data();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Are you sure to delete interview tip?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, confirm!',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3',
                        cancelButton: 'btn btn-label-secondary'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        LoaderShow();

                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('admin/interview-tips') }}/" + rowData.id,
                            dataType: "json",
                            success: function(response) {
                                LoaderHide();
                                if (response.status === 1) {
                                    toastr.success(response.message, 'Success');
                                    location.reload();
                                } else {
                                    toastr.warning(response.message, 'Warning');
                                }
                            }
                        });
                    }
                });
            });
        });

        $("#interview-tips-form").validate({
            rules: {
                main_header: {
                    required: true
                }
            },
            messages: {
                main_header: {
                    required: "Please enter the main header"
                }
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
                $(element).removeClass("is-invalid").addClass("is-valid");
            }
        });

        $("#interview-tips-form").submit(function(e) {
            e.preventDefault();

            if (!$("#interview-tips-form").valid()) {
                return;
            }

            var firstPointTitle = $("#points-wrapper input[name*='[title]']").first().val();
            if (!firstPointTitle) {
                toastr.warning("Please enter at least one main point", "Warning");
                return;
            }

            let formData = new FormData(this);
            var flag = $("#flag").val();
            var id = $("#row_id").val();
            var url = "";

            if (flag === "A") {
                url = "{{ route('admin.interview-tips.store') }}";
            } else {
                url = "{{ url('admin/interview-tips') }}/" + id;
                formData.append("_method", "PUT");
            }

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            LoaderShow();

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    LoaderHide();
                    if (response.status === 1) {
                        toastr.success(response.message, "Success");
                        setTimeout(() => {
                            location.reload();
                        }, 800);
                    } else {
                        toastr.warning(response.message, "Warning");
                    }
                },
                error: function(xhr) {
                    LoaderHide();
                    console.error(xhr.responseText);
                    toastr.error("An error occurred. Please try again.", "Error");
                }
            });
        });

        function AddInterviewTips() {
            resetForm();
            document.getElementById("AddInterviewTips").style.display = "block";
            document.getElementById("ListOfInterviewTips").style.display = "none";
            $("#form-card-title").text("Add New Interview Tip");
        }

        function backtoList() {
            document.getElementById("AddInterviewTips").style.display = "none";
            document.getElementById("ListOfInterviewTips").style.display = "block";
            resetForm();
        }

        function resetForm() {
            $("#interview-tips-form")[0].reset();
            $("#flag").val("A");
            $("#row_id").val("");
            $("#_method").val("POST");
            $("#form-card-title").text("Add New Interview Tip");
            $("#points-wrapper").html("");
            addPoint();
        }

        function addPoint(title, description) {
            var wrapper = document.getElementById("points-wrapper");
            var index = wrapper.querySelectorAll(".tip-point-row").length;

            var row = document.createElement("div");
            row.className = "tip-point-row";
            row.innerHTML =
                '<div class="d-flex gap-3">' +
                    '<div class="tip-point-number">' + (index + 1) + '</div>' +
                    '<div class="flex-grow-1">' +
                        '<div class="mb-2">' +
                            '<label class="form-label">Main Point</label>' +
                            '<input type="text" class="form-control" name="points[' + index + '][title]" placeholder="Enter Main Point" value="' + (title ? String(title).replace(/"/g, '&quot;') : '') + '">' +
                        '</div>' +
                        '<div class="mb-0">' +
                            '<label class="form-label">Description</label>' +
                            '<textarea class="form-control" name="points[' + index + '][description]" rows="2" placeholder="Enter Point Description">' + (description || '') + '</textarea>' +
                        '</div>' +
                    '</div>' +
                    pointActionsHtml() +
                '</div>';

            wrapper.appendChild(row);
            renumberPoints();
        }

        function pointActionsHtml() {
            return '<div class="d-flex flex-column gap-2 align-self-start point-actions">' +
                '<button type="button" class="btn btn-sm btn-icon btn-outline-secondary move-up-btn" onclick="movePoint(this, -1)">' +
                    '<i class="bx bx-up-arrow-alt"></i>' +
                '</button>' +
                '<button type="button" class="btn btn-sm btn-icon btn-outline-secondary move-down-btn" onclick="movePoint(this, 1)">' +
                    '<i class="bx bx-down-arrow-alt"></i>' +
                '</button>' +
                '<button type="button" class="btn btn-sm btn-icon btn-danger" onclick="removePoint(this)">' +
                    '<i class="bx bx-trash"></i>' +
                '</button>' +
                '<button type="button" class="btn btn-sm btn-icon btn-primary add-point-btn" onclick="addPoint()">' +
                    '<i class="bx bx-plus"></i>' +
                '</button>' +
            '</div>';
        }

        function removePoint(btn) {
            var rows = document.querySelectorAll("#points-wrapper .tip-point-row");
            if (rows.length <= 1) {
                return;
            }
            btn.closest(".tip-point-row").remove();
            renumberPoints();
        }

        function movePoint(btn, direction) {
            var row = btn.closest(".tip-point-row");
            var sibling = direction === -1 ? row.previousElementSibling : row.nextElementSibling;
            if (!sibling || !sibling.classList.contains("tip-point-row")) {
                return;
            }
            if (direction === -1) {
                row.parentNode.insertBefore(row, sibling);
            } else {
                row.parentNode.insertBefore(sibling, row);
            }
            renumberPoints();
        }

        function renumberPoints() {
            var rows = document.querySelectorAll("#points-wrapper .tip-point-row");
            rows.forEach(function(row, i) {
                row.querySelector(".tip-point-number").textContent = i + 1;
                var title = row.querySelector('input[name*="[title]"]');
                var desc = row.querySelector('textarea[name*="[description]"]');
                if (title) title.name = "points[" + i + "][title]";
                if (desc) desc.name = "points[" + i + "][description]";

                var upBtn = row.querySelector(".move-up-btn");
                var downBtn = row.querySelector(".move-down-btn");
                if (upBtn) upBtn.disabled = (i === 0);
                if (downBtn) downBtn.disabled = (i === rows.length - 1);
            });
        }

        renumberPoints();
    </script>
@endpush
