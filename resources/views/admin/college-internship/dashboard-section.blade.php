{{-- College Internship Dashboard Section – included in college dashboard --}}
<style>
    .college-internship-section { margin-top: 8px; }
    .college-badge {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 22px; height: 22px; border-radius: 50%;
        font-size: 11px; font-weight: 700; color: #fff; margin-left: 6px; padding: 0 5px;
    }
    .college-badge-processing { background: #F59E0B; color: #111; }
    .college-badge-completed { background: #10B981; }
</style>

<div class="college-internship-section" id="college-internship-section">
    <div class="zp-section-panel">
        <div class="zp-section-toolbar">
            <h5>Internship Overview</h5>
            <div class="zp-toolbar-actions">
                <div class="zp-search">
                    <i class="bx bx-search"></i>
                    <input type="text" id="ciOverviewSearch" placeholder="Search internships..." autocomplete="off">
                </div>
                <button type="button" class="btn btn-primary" id="ciFilterBtn">
                    <i class="bx bx-filter-alt"></i> Filter
                </button>
            </div>
        </div>

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
            <div class="tab-pane fade show active" id="ci-processing" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover" id="processingInternshipTable" style="width:100%">
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

@push('script')
<script>
$(function(){
    $.get("{{ route('admin.college-internship.statistics') }}", function(res){
        $('#ci-processing-count').text(res.processing || 0);
        $('#ci-completed-count').text(res.completed || 0);
    });

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

    $('button[data-bs-target="#ci-completed"]').on('shown.bs.tab', function(){
        completedTable.ajax.reload();
    });

    // Overview toolbar search → active DataTable
    var searchTimer = null;
    $('#ciOverviewSearch').on('keyup', function(){
        var q = this.value;
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function(){
            var activeTab = $('#collegeInternshipTabs .nav-link.active').attr('data-bs-target');
            if (activeTab === '#ci-completed') {
                completedTable.search(q).draw();
            } else {
                processingTable.search(q).draw();
            }
        }, 300);
    });

    $('#ciFilterBtn').on('click', function(){
        $('#ciOverviewSearch').trigger('focus');
    });
});
</script>
@endpush
