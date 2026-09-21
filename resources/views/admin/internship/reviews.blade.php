@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "InternshipReviews";
</script>

<style>
    .reviews-header {
        background: #242a62;
        border-radius: 16px;
        padding: 24px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .reviews-header::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(242, 110, 44, 0.15);
        border-radius: 50%;
    }
    .stats-cards {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .stats-card-item {
        flex: 1;
        min-width: 160px;
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        text-align: center;
    }
    .stats-card-item h3 {
        font-size: 28px;
        font-weight: 800;
        margin: 0 0 4px;
    }
    .stats-card-item p {
        margin: 0;
        color: #6c757d;
        font-size: 13px;
        font-weight: 600;
    }
    .table-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="reviews-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 style="color: #fff; margin: 0;">
                    <i class="bx bx-star"></i> Opportunity Review Management
                </h4>
                <p style="color: rgba(255,255,255,0.7); margin: 5px 0 0 0; font-size: 14px;">
                    Manage and moderate student opportunity reviews
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-cards" id="reviewStats">
        <div class="stats-card-item">
            <h3 style="color: #242a62;" id="totalReviews">0</h3>
            <p>Total Reviews</p>
        </div>
        <div class="stats-card-item">
            <h3 style="color: #ffc107;" id="pendingReviews">0</h3>
            <p>Pending</p>
        </div>
        <div class="stats-card-item">
            <h3 style="color: #28a745;" id="approvedReviews">0</h3>
            <p>Approved</p>
        </div>
        <div class="stats-card-item">
            <h3 style="color: #dc3545;" id="rejectedReviews">0</h3>
            <p>Rejected</p>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover" id="reviewsTable" style="width: 100%;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Opportunity</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    var table = $('#reviewsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.internship.reviews-data") }}',
            type: 'GET',
            dataSrc: function(json) {
                // Update stats from all data
                var total = json.recordsTotal || 0;
                $('#totalReviews').text(total);
                return json.data;
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'student_name', name: 'student_name' },
            { data: 'internship_title', name: 'internship_title' },
            { data: 'star_display', name: 'star', orderable: true, searchable: false, className: 'text-center' },
            { data: 'review_text', name: 'review' },
            { data: 'status_badge', name: 'active_status', className: 'text-center' },
            { data: 'submitted_at', name: 'write_on', className: 'text-center' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        order: [[6, 'desc']],
        language: {
            emptyTable: "No reviews found",
            processing: '<i class="bx bx-loader-alt bx-spin" style="font-size:24px;color:#242a62;"></i> Loading...'
        },
        drawCallback: function() {
            updateStats();
        }
    });

    function updateStats() {
        $.ajax({
            url: '{{ route("admin.internship.reviews-stats") }}',
            method: 'GET',
            success: function(res) {
                if (res.success) {
                    $('#totalReviews').text(res.total);
                    $('#pendingReviews').text(res.pending);
                    $('#approvedReviews').text(res.approved);
                    $('#rejectedReviews').text(res.rejected);
                }
            }
        });
    }

    updateStats();

    // Approve / Reject actions
    $(document).on('click', '.review-action', function() {
        var reviewId = $(this).data('id');
        var newStatus = $(this).data('status');
        var statusLabel = newStatus == 1 ? 'Approve' : 'Reject';

        Swal.fire({
            title: statusLabel + ' this review?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: newStatus == 1 ? '#28a745' : '#dc3545',
            confirmButtonText: 'Yes, ' + statusLabel,
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("admin/internship/review") }}/' + reviewId + '/status',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Done!', res.message, 'success');
                            table.ajax.reload(null, false);
                            updateStats();
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to update status.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
