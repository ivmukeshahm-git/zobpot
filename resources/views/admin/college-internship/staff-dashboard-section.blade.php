{{-- College Staff Opportunity Dashboard Section – included in admin/index for Staff with college_id --}}
<style>
    .staff-opportunity-section { margin-top: 30px; }
    .staff-section-card {
        /* background: #fff; border-radius: 12px; border: 2px solid #242a62; */
        overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,.08);
    }
    .staff-section-header {
        /* background: linear-gradient(135deg, #242a62, #3d4575); color: #fff; */
        padding: 20px 25px; display: flex; align-items: center; gap: 10px;
    }
    .staff-section-header h5 { margin: 0; font-weight: 700; font-size: 18px; color: #fff; }
</style>

<div class="staff-internship-section">
    <div class="staff-section-card">
        <div class="staff-section-header">
            <i class="bx bx-briefcase-alt-2" style="font-size:24px;"></i>
            <h5>My Assigned Opportunities</h5>
        </div>
        <div style="padding: 25px;">
            <div class="table-responsive">
                <table class="table table-hover" id="staffInternshipTable" style="width:100%">
                    <thead >
                        <tr>
                            <th>Sr. No</th>
                            <th>Opportunity Title</th>
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

@push('script')
<script>
$(function(){
    $('#staffInternshipTable').DataTable({
        processing: true, serverSide: true,
        ajax: {
            url: "{{ route('admin.college-internship.staff-internships') }}",
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'internship_title' },
            { data: 'company_name' },
            { data: 'duration' },
            { data: 'category_name' },
            { data: 'location' },
            { data: 'openings' },
            { data: 'status_label', orderable: false },
            { data: 'total_students', orderable: false },
            { data: 'action', orderable: false, searchable: false }
        ],
        order: [[1,'asc']],
        language: { emptyTable: "No opportunities assigned to you yet." }
    });
});
</script>
@endpush
