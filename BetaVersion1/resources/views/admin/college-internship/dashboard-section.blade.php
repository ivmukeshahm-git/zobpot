{{-- College Internship Dashboard Section – included in admin/index --}}
<style>
    .college-internship-section { margin-top: 30px; }
    .college-section-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 20px; padding-bottom: 15px; border-bottom: 3px solid #242a62;
    }
    .college-section-header h5 { color: #242a62; font-weight: 700; margin: 0; }
    .college-tab-nav .nav-link {
        color: #666; border: none; border-bottom: 3px solid transparent;
        border-radius: 0; padding: 12px 24px; font-weight: 600; font-size: 14px;
        transition: all .3s ease; margin-bottom: -3px;
    }
    .college-tab-nav .nav-link:hover { color: #242a62; background: #fff5f0; }
    .college-tab-nav .nav-link.active {
        color: #242a62; background: transparent; border-bottom-color: #242a62;
    }
    .college-tab-nav { border-bottom: 3px solid #242a62; padding: 0 15px; background: #fff; border-radius: 12px 12px 0 0; }
    .college-tab-content { background: #fff; border-radius: 0 0 12px 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,.08); }
    .college-badge { display: inline-flex; align-items: center; justify-content: center; min-width: 22px; height: 22px; border-radius: 50%; font-size: 11px; font-weight: 700; color: #fff; margin-left: 6px; padding: 0 5px; }
    .college-badge-processing { background: #ffc107; color: #000; }
    .college-badge-completed { background: #28a745; }
</style>

<div class="college-internship-section">
    <div class="card" style="border: 2px solid #242a62; border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            {{-- Tabs --}}
            <ul class="nav nav-tabs college-tab-nav" id="collegeInternshipTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="ci-processing-tab" data-bs-toggle="tab"
                        data-bs-target="#ci-processing" type="button" role="tab">
                        <i class="bx bx-loader-circle"></i> &nbsp;My Processing Internship
                        <span class="college-badge college-badge-processing" id="ci-processing-count">0</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="ci-completed-tab" data-bs-toggle="tab"
                        data-bs-target="#ci-completed" type="button" role="tab">
                        <i class="bx bx-check-circle"></i> &nbsp;Completed Internship
                        <span class="college-badge college-badge-completed" id="ci-completed-count">0</span>
                    </button>
                </li>
            </ul>

            <div class="tab-content college-tab-content" id="collegeInternshipTabContent">
                {{-- Processing Table --}}
                <div class="tab-pane fade show active" id="ci-processing" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover" id="processingInternshipTable" style="width:100%">
                            <thead >
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Internship Title</th>
                                    <th>Company</th>
                                    <th>Duration</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Openings</th>
                                    <th>Status</th>
                                    <th>Total Students</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                {{-- Completed Table --}}
                <div class="tab-pane fade" id="ci-completed" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover" id="completedInternshipTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Internship Title</th>
                                    <th>Company</th>
                                    <th>Duration</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Openings</th>
                                    <th>Status</th>
                                    <th>Total Students</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
$(function(){
    // Badge counts
    $.get("{{ route('admin.college-internship.statistics') }}", function(res){
        $('#ci-processing-count').text(res.processing || 0);
        $('#ci-completed-count').text(res.completed || 0);
    });

    // Processing DataTable
    var processingTable = $('#processingInternshipTable').DataTable({
        processing: true, serverSide: true, responsive: true,
        ajax: {
            url: "{{ route('admin.college-internship.processing-data') }}",
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        },
        lengthMenu: [10, 25, 50],
        pageLength: 10,
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'internship_title' },
            { data: 'company_name' },
            { data: 'duration', className: 'text-center' },
            { data: 'category_name' },
            { data: 'location' },
            { data: 'openings', className: 'text-center' },
            { data: 'status_label', orderable: false, className: 'text-center' },
            { data: 'total_students', orderable: false, searchable: false, className: 'text-center' },
            { data: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        order: [[1,'asc']],
        language: { emptyTable: "No processing internships found." }
    });

    // Completed DataTable
    var completedTable = $('#completedInternshipTable').DataTable({
        processing: true, serverSide: true, responsive: true,
        ajax: {
            url: "{{ route('admin.college-internship.completed-data') }}",
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        },
        lengthMenu: [10, 25, 50],
        pageLength: 10,
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'internship_title' },
            { data: 'company_name' },
            { data: 'duration', className: 'text-center' },
            { data: 'category_name' },
            { data: 'location' },
            { data: 'openings', className: 'text-center' },
            { data: 'status_label', orderable: false, className: 'text-center' },
            { data: 'total_students', orderable: false, searchable: false, className: 'text-center' },
            { data: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        order: [[1,'asc']],
        language: { emptyTable: "No completed internships found." }
    });

    // Lazy-load completed on tab switch
    $('button[data-bs-target="#ci-completed"]').on('shown.bs.tab', function(){
        completedTable.ajax.reload();
    });
});
</script>
@endpush
