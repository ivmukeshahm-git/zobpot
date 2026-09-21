@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "CollegeMarksHistory";
</script>

<style>
    .history-header {
        background: #242a62;
        border-radius: 16px;
        padding: 24px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .history-header::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(242, 110, 44, 0.15);
        border-radius: 50%;
    }
    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        margin-bottom: 24px;
    }
    .filter-card label {
        font-weight: 600;
        color: #242a62;
        margin-bottom: 6px;
        font-size: 13px;
    }
    .filter-card select, .filter-card input {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .filter-card select:focus, .filter-card input:focus {
        border-color: #242a62;
        box-shadow: 0 0 0 3px rgba(36, 42, 98, 0.1);
    }

    /* Card Styles */
    .opportunity-history-card,
    .internship-history-card {
        background: white;
        border-radius: 14px;
        padding: 0;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .opportunity-history-card:hover,
    .internship-history-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(36, 42, 98, 0.18);
    }
    .card-top-bar {
        background: linear-gradient(135deg, #242a62 0%, #3d4575 100%);
        padding: 16px 20px;
        color: white;
    }
    .card-top-bar h6 {
        color: white;
        font-weight: 700;
        margin: 0;
        font-size: 15px;
        line-height: 1.4;
    }
    .card-body-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .card-info-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 10px;
        font-size: 13px;
        color: #495057;
    }
    .card-info-row i {
        color: #242a62;
        font-size: 16px;
        margin-top: 2px;
        flex-shrink: 0;
    }
    .card-info-row strong {
        color: #242a62;
    }
    .card-badge-completed {
        display: inline-block;
        background: #28a745;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .card-student-count {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f0f2ff;
        color: #242a62;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    .card-footer-section {
        padding: 16px 20px;
        border-top: 1px solid #e9ecef;
        text-align: center;
        margin-top: auto;
    }
    .btn-view-details {
        background: linear-gradient(135deg, #242a62 0%, #3d4575 100%);
        color: white;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    .btn-view-details:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(36, 42, 98, 0.3);
        color: white;
        text-decoration: none;
    }
    .no-results-box {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }
    .no-results-box i {
        font-size: 64px;
        margin-bottom: 16px;
        color: #dee2e6;
    }
    .cards-count-badge {
        background: rgba(255,255,255,0.2);
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 13px;
        color: white;
        font-weight: 600;
    }
    /* Pagination */
    .cards-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
        margin-top: 8px;
        flex-wrap: wrap;
    }
    .page-btn {
        min-width: 38px;
        height: 38px;
        padding: 0 10px;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        background: white;
        color: #242a62;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .page-btn:hover:not(:disabled) {
        border-color: #242a62;
        background: #f0f2ff;
    }
    .page-btn.active {
        background: linear-gradient(135deg, #242a62 0%, #3d4575 100%);
        border-color: #242a62;
        color: white;
    }
    .page-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }
    .pagination-info {
        text-align: center;
        color: #6c757d;
        font-size: 13px;
        margin-top: 10px;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    @if(auth()->guard('college')->check() || auth()->guard('college_staff')->check())
    @component('admin.layout.partials.college-page-banner', [
        'emoji' => '🕒',
        'title' => 'College Marks History',
        'subtitle' => 'View submitted college marks for completed opportunities.',
        'illustration' => 'history',
        'crumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.college.dashboard')],
            ['label' => 'Marks History'],
        ],
    ])
        <span class="cards-count-badge" id="totalCount">{{ count($cards) }} Opportunity(s)</span>
    @endcomponent
    @else
    <!-- Page Header -->
    <div class="history-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 style="color: #fff; margin: 0;">
                    <i class="bx bx-history"></i> College Marks History
                </h4>
                <p style="color: rgba(255,255,255,0.7); margin: 5px 0 0 0; font-size: 14px;">
                    View submitted college marks for completed programs
                </p>
            </div>
            <span class="cards-count-badge" id="totalCount">{{ count($cards) }} Internship(s)</span>
        </div>
    </div>
    @endif

    <!-- Filter Section -->
    <div class="filter-card">
        <div class="row align-items-end">
            <div class="col-md-{{ $isSuperAdmin ? '6' : '12' }}">
                <label for="search_text"><i class="bx bx-search"></i> Search</label>
                <input type="text" id="search_text" class="form-control" placeholder="Search by title or company...">
            </div>
            @if($isSuperAdmin)
            <div class="col-md-6">
                <label for="filter_university">University</label>
                <select id="filter_university" class="form-control">
                    <option value="">-- All Universities --</option>
                    @foreach($universities as $uni)
                        <option value="{{ strtolower($uni->university_name) }}">{{ $uni->university_name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="row" id="cardsContainer">
        @forelse($cards as $card)
        <div class="col-lg-4 col-md-6 mb-4 card-item"
             data-title="{{ strtolower($card['title']) }}"
             data-company="{{ strtolower($card['company_name']) }}"
             data-university="{{ strtolower($card['university_name'] ?? '') }}">
            <div class="internship-history-card">
                <div class="card-top-bar">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6><i class="bx bx-briefcase-alt-2"></i> {{ $card['title'] }}</h6>
                        <div class="d-flex flex-column align-items-end gap-1">
                            <span class="card-badge-completed"><i class="bx bx-check"></i> Completed</span>
                            @if($card['internship_type'] == 2)
                            <span style="background:rgba(242,110,44,0.85);color:white;padding:2px 10px;border-radius:12px;font-size:10px;font-weight:700;letter-spacing:0.4px;">
                                COMPANY ONLY
                            </span>
                            @else
                            <span style="background:rgba( 23,162,184,0.85);color:white;padding:2px 10px;border-radius:12px;font-size:10px;font-weight:700;letter-spacing:0.4px;">
                                INDUSTRY + COLLEGE
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body-content">
                    <div class="card-info-row">
                        <i class="bx bx-building"></i>
                        <span><strong>Company:</strong> {{ $card['company_name'] }}</span>
                    </div>
                  
                    @if($card['start_date'] || $card['end_date'])
                    <div class="card-info-row">
                        <i class="bx bx-calendar"></i>
                        <span>
                            {{ $card['start_date'] ? \Carbon\Carbon::parse($card['start_date'])->format('d M Y') : '' }}
                            {{ ($card['start_date'] && $card['end_date']) ? ' — ' : '' }}
                            {{ $card['end_date'] ? \Carbon\Carbon::parse($card['end_date'])->format('d M Y') : '' }}
                        </span>
                    </div>
                    @endif
                    <div class="mt-2">
                        <span class="card-student-count">
                            <i class="bx bx-user"></i> {{ $card['student_count'] }} Student(s)
                        </span>
                    </div>
                </div>
                <div class="card-footer-section">
                    <a href="{{ route('admin.internship.college-marks-history-detail', $card['id']) }}" class="btn-view-details">
                        <i class="bx bx-show"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="no-results-box">
                <i class="bx bx-info-circle"></i>
                <h5>No Completed Programs Found</h5>
                <p>There are no opportunities with submitted college marks yet.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- No filter results message (hidden by default) -->
    <div id="noFilterResults" style="display: none;">
        <div class="no-results-box">
            <i class="bx bx-search-alt"></i>
            <h5>No Matching Results</h5>
            <p>Try adjusting your search or filter criteria.</p>
        </div>
    </div>

    <!-- Pagination -->
    <div id="paginationWrapper" style="display:none;">
        <div class="cards-pagination" id="paginationBtns"></div>
        <div class="pagination-info" id="paginationInfo"></div>
    </div>
</div>

@endsection

@push('script')
<script>
$(document).ready(function() {
    const PER_PAGE = 9;
    let currentPage = 1;
    let filteredCards = [];

    function getFilteredCards() {
        const searchText = $('#search_text').val().toLowerCase().trim();
        const universityFilter = ($('#filter_university').val() || '').toLowerCase().trim();

        const result = [];
        $('.card-item').each(function() {
            const $card = $(this);
            const title = $card.data('title') || '';
            const company = $card.data('company') || '';
            const university = $card.data('university') || '';

            let show = true;
            if (searchText && title.indexOf(searchText) === -1 && company.indexOf(searchText) === -1) show = false;
            if (universityFilter && university.indexOf(universityFilter) === -1) show = false;

            if (show) result.push($card);
        });
        return result;
    }

    function renderPage(page) {
        currentPage = page;
        const start = (page - 1) * PER_PAGE;
        const end = start + PER_PAGE;

        // Hide all first
        $('.card-item').hide();

        // Show only current page slice of filtered
        filteredCards.forEach(function($card, idx) {
            if (idx >= start && idx < end) $card.show();
        });

        const totalPages = Math.ceil(filteredCards.length / PER_PAGE);
        const showingFrom = filteredCards.length === 0 ? 0 : start + 1;
        const showingTo = Math.min(end, filteredCards.length);

        $('#totalCount').text(filteredCards.length + ' Internship(s)');
        $('#noFilterResults').toggle(filteredCards.length === 0 && $('.card-item').length > 0);

        // Pagination visibility
        if (totalPages <= 1) {
            $('#paginationWrapper').hide();
            return;
        }
        $('#paginationWrapper').show();
        $('#paginationInfo').text('Showing ' + showingFrom + ' – ' + showingTo + ' of ' + filteredCards.length + ' opportunities');

        // Build page buttons
        let btns = '';
        btns += `<button class="page-btn" id="btnPrev" ${page === 1 ? 'disabled' : ''} onclick="goPage(${page - 1})"><i class="bx bx-chevron-left"></i></button>`;

        // Show up to 5 page numbers around current
        let startP = Math.max(1, page - 2);
        let endP   = Math.min(totalPages, startP + 4);
        if (endP - startP < 4) startP = Math.max(1, endP - 4);

        if (startP > 1) {
            btns += `<button class="page-btn" onclick="goPage(1)">1</button>`;
            if (startP > 2) btns += `<span class="page-btn" style="pointer-events:none;">…</span>`;
        }
        for (let i = startP; i <= endP; i++) {
            btns += `<button class="page-btn ${i === page ? 'active' : ''}" onclick="goPage(${i})">${i}</button>`;
        }
        if (endP < totalPages) {
            if (endP < totalPages - 1) btns += `<span class="page-btn" style="pointer-events:none;">…</span>`;
            btns += `<button class="page-btn" onclick="goPage(${totalPages})">${totalPages}</button>`;
        }

        btns += `<button class="page-btn" id="btnNext" ${page === totalPages ? 'disabled' : ''} onclick="goPage(${page + 1})"><i class="bx bx-chevron-right"></i></button>`;

        $('#paginationBtns').html(btns);
    }

    window.goPage = function(page) {
        renderPage(page);
        $('html, body').animate({ scrollTop: $('#cardsContainer').offset().top - 20 }, 200);
    };

    function filterCards() {
        filteredCards = getFilteredCards();
        renderPage(1);
    }

    // Init
    filterCards();

    $('#search_text').on('keyup', filterCards);
    $('#filter_university').on('change', filterCards);
});
</script>
@endpush
