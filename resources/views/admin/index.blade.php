@push('css')
    <style>
        .view-all-btn {
            background-color: #fff;
            color: #242a62;
            font-weight: 600;
        }

        .view-all-btn:hover {
            background-color: #fff !important;
            color: #242a62 !important;
        }
        
          /* New Internship Requests Section */
        .internship-requests-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border: 2px solid #f26e2c;
        }

        .section-header-requests {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #f26e2c;
        }

        .section-title-requests {
            font-size: 22px;
            font-weight: 700;
            color: #242a62;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }

        .badge-count-requests {
            background: #f26e2c;
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .btn-action-request {
            padding: 6px 14px;
            font-size: 13px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-accept-request {
            background: #28a745;
            color: white;
            border: none;
        }

        .btn-accept-request:hover {
            background: #218838;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }

        .btn-reject-request {
            background: #dc3545;
            color: white;
            border: none;
        }

        .btn-reject-request:hover {
            background: #c82333;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }

        .modal-header-custom-request {
            background: linear-gradient(135deg, #242a62 0%, #f26e2c 100%);
            color: white;
            border-radius: 0;
            padding: 20px 30px;
        }

        .modal-header-custom-request h5 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
        }

        .modal-header-custom-request .btn-close {
            filter: brightness(0) invert(1);
        }

        .detail-section-request {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .detail-section-request h6 {
            color: #242a62;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f26e2c;
        }

        .detail-row-request {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed #dee2e6;
        }

        .detail-row-request:last-child {
            border-bottom: none;
        }

        .detail-label-request {
            font-weight: 600;
            color: #495057;
            font-size: 13px;
        }

        .detail-value-request {
            color: #212529;
            font-size: 13px;
        }

        .form-section-request {
            background: white;
            border: 2px solid #e7e7ff;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .form-section-request h6 {
            color: #242a62;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f26e2c;
        }

        .form-label-required::after {
            content: " *";
            color: #dc3545;
        }

        .internship-requests-card .table-hover tbody tr:hover {
            background-color: #fff5f0;
        }
    </style>
@endpush

@extends('admin.layout.layout')
@section('content')
    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
    @endphp


    <script>
        page_active_id = "Home";
    </script>


    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-6 g-6">
            <div class="col-sm-6 col-xl-3">
                <div class="card"
                    style="background: #e7e7ff;border: 2px solid #3f447866;border-radius: 12px;overflow: hidden;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <h5 class="mb-1" style="font-size: 25px;font-weight: 700;">
                                    {{ $Count ? $Count->TotalCompany : 0 }}</h5>
                                <small style="font-size: 16px;font-weight: 600;">Total Company</small>
                            </div>
                            <span class="badge bg-label-primary rounded-circle p-2">
                                <i class="bx bx bx-building bx-lg"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card"
                    style="background: #e8fadf;border: 2px solid #75de3d7d;border-radius: 12px;overflow: hidden;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <h5 class="mb-1" style="font-size: 25px;font-weight: 700;">
                                    {{ $Count ? $Count->TotalCandidate : 0 }}</h5>
                                <small style="font-size: 16px;font-weight: 600;">Total Candidates</small>
                            </div>
                            <span class="badge bg-label-success rounded-circle p-2">
                                <i class="bx bx-user-pin bx-lg"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card"
                    style="background: #ffe0db;border: 2px solid #ff3e1d4a;border-radius: 12px;overflow: hidden;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <h5 class="mb-1" style="font-size: 25px;font-weight: 700;">
                                    {{ $Count ? $Count->TotalPaidUser : 0 }}</h5>
                                <small style="font-size: 16px;font-weight: 600;">Paid Users</small>
                            </div>
                            <span class="badge bg-label-danger rounded-circle p-2">
                                <i class="bx bx-user-check bx-lg"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card"
                    style="background: #d7f5fc;border: 2px solid #11c6ed73;border-radius: 12px;overflow: hidden;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="content-left">
                                <h5 class="mb-1" style="font-size: 25px;font-weight: 700;">
                                    {{ $Count ? $Count->TotalFreeUser : 0 }}</h5>
                                <small style="font-size: 16px;font-weight: 600;">Free Users</small>
                            </div>
                            <span class="badge bg-label-info rounded-circle p-2">
                                <i class="bx bx-user-minus bx-lg"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            
            @can('Dashboard-New_Internship_Requests')
             <div class="col-md-12 col-lg-12 order-2 mb-6">
                    <div class="card h-100">
                        <div class="card-header p-3 d-flex align-items-center justify-content-between"
                            style="background: #242a62;">
                            <h5 class="card-title m-0 me-2" style="color: #fff;">New Internship Requests</h5>
                            <div class="dropdown">
                                <a class="btn btn-sm btn-secondary view-all-btn"
                                    href="{{ route('admin.internship.management') }}">View All</a>
                            </div>
                        </div>
                        <div class="card-body table-responsive pt-4"
                            style="border: 2px solid #242a62;border-radius: 0px 0px 12px 12px;">
                            <table id="NewInternshipRequestsTable" class="table table-sm table-striped table-hover">
                            <thead class="border-top">
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Internship Title</th>
                                    <th>Company</th>
                                    <th>Duration</th>
                                    <th>Created Date</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Openings</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            @endcan

           

           

            <div class="col-md-6 col-lg-6 order-2 mb-6">
                    <div class="card h-100">
                        <div class="card-header p-3 d-flex align-items-center justify-content-between"
                            style="background: #242a62;">
                            <h5 class="card-title m-0 me-2" style="color: #fff;">Today Skillothon Register List</h5>
                            <div class="dropdown">
                                <a class="btn btn-sm btn-secondary view-all-btn"
                                    href="{{ route('admin.skillthon') }}">View All</a>
                            </div>
                        </div>
                        <div class="card-body table-responsive pt-4"
                            style="border: 2px solid #242a62;border-radius: 0px 0px 12px 12px;">
                            <table id="TodayHackathonsRegisterListDataTable" class="table table-sm table-striped table-hover">
                                <thead class="border-top">
                                    <tr>
                                        <th>Sr. NO.</th>
                                        <th>Name</th>
                                        <th>Contact No</th>
                                        <th>Degree/Cource</th>
                                        <th>City</th>
                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @can('Dashboard-today_candidates_register_list')
                <div class="col-md-6 col-lg-6 order-2 mb-6">
                    <div class="card h-100">
                        <div class="card-header p-3 d-flex align-items-center justify-content-between"
                            style="background: #242a62;">
                            <h5 class="card-title m-0 me-2" style="color: #fff;">Today Candidates Register List</h5>
                            <div class="dropdown">
                                <a class="btn btn-sm btn-secondary view-all-btn"
                                    href="{{ route('admin.candidates-register-list.index') }}">View All</a>
                            </div>
                        </div>
                        <div class="card-body table-responsive pt-4"
                            style="border: 2px solid #242a62;border-radius: 0px 0px 12px 12px;">
                            <table id="TodayCandidatesRegisterListDataTable" class="table table-sm table-striped table-hover">
                                <thead class="border-top">
                                    <tr>
                                        <th>Sr. NO.</th>
                                        <th>Name</th>
                                        <th>Contact No</th>
                                        <th>Plan</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endcan

            @can('Dashboard-today_company_register_list')
                <div class="col-md-6 col-lg-6 order-2 mb-6">
                    <div class="card h-100">
                        <div class="card-header p-3 d-flex align-items-center justify-content-between"
                            style="background: #242a62;">
                            <h5 class="card-title m-0 me-2" style="color: #fff;">Today Company Register List</h5>
                            <div class="dropdown">
                                <a class="btn btn-sm btn-secondary view-all-btn"
                                    href="{{ route('admin.company-register-list.index') }}">View All</a>

                            </div>
                        </div>
                        <div class="card-body p-4 table-responsive" style="border: 2px solid #242a62;border-radius: 0px 0px 12px 12px;">
                            <table id="TodayCompanyRegisterListDataTable" class="table table-sm table-striped table-hover">
                                <thead class="border-top">
                                    <tr>
                                        <th>Sr. NO.</th>
                                        <th>Company Name</th>
                                        <th>Contact No</th>
                                        <th>Plan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endcan

            @can('Dashboard-today_candidates_register_list')
                <div class="col-md-6 col-lg-6 order-2 mb-6">
                    <div class="card h-100">
                        <div class="card-header p-3 d-flex align-items-center justify-content-between"
                            style="background: #242a62;">
                            <h5 class="card-title m-0 me-2" style="color: #fff;">Today Candidates Approve RegisterList</h5>
                            <div class="dropdown">
                                <a class="btn btn-sm btn-secondary view-all-btn"
                                    href="{{ route('admin.candidates-register-list.index') }}">View All</a>
                            </div>
                        </div>
                        <div class="card-body table-responsive pt-4"
                            style="border: 2px solid #242a62;border-radius: 0px 0px 12px 12px;">
                            <table id="TodayApproveCandidatesRegisterListDataTable"
                                class="table table-sm table-striped table-hover">
                                <thead class="border-top">
                                    <tr>
                                        <th>Sr. NO.</th>
                                        <th>Name</th>
                                        <th>Contact No</th>
                                        <th>Plan</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endcan

            @can('Dashboard-today_company_register_list')
                <div class="col-md-6 col-lg-6 order-2 mb-6">
                    <div class="card h-100">
                        <div class="card-header p-3 d-flex align-items-center justify-content-between"
                            style="background: #242a62;">
                            <h5 class="card-title m-0 me-2" style="color: #fff;">Today Company Approve Register List</h5>
                            <div class="dropdown">
                                <a class="btn btn-sm btn-secondary view-all-btn"
                                    href="{{ route('admin.company-register-list.index') }}">View All</a>

                            </div>
                        </div>
                        <div class="card-body p-4 table-responsive"
                            style="border: 2px solid #242a62;border-radius: 0px 0px 12px 12px;">
                            <table id="TodayApproveCompanyRegisterListDataTable"
                                class="table table-sm table-striped table-hover">
                                <thead class="border-top">
                                    <tr>
                                        <th>Sr. NO.</th>
                                        <th>Company Name</th>
                                        <th>Contact No</th>
                                        <th>Plan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @endcan
        </div>

        <div class="row">
            <!-- Order Statistics -->
            @can('Dashboard-paid_company')
                <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
                    <div class="card h-100">
                        <div class="card-header p-3 d-flex justify-content-between" style="background: #242a62;">
                            <div class="card-title mb-0">
                                <h5 class="mb-1 me-2" style="color: #fff;">Paid Company</h5>
                            </div>
                            <div class="dropdown">
                                <a class="btn btn-sm btn-secondary view-all-btn"
                                    href="{{ route('admin.paid-company.index') }}">View All</a>
                            </div>
                        </div>
                        <div class="card-body p-4 h-100" style="border: 2px solid #242a62;border-radius: 0px 0px 12px 12px;">
                            <ul class="p-0 m-0">
                                {{-- loop through each user --}}
                                @forelse ($PaidCompanyData as $user)
                                    <li class="d-flex align-items-center mb-5">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-primary">
                                                <i class="bx bx-building"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">{{ $user->name }}</h6>
                                                <small>{{ $user->plan_name }}
                                                    &nbsp; <i class="bx bx-cart" style="font-size: 15px;"></i>
                                                    Buy Date -
                                                    {{ \Carbon\Carbon::parse($user->purchase_date)->format('d-m-Y') }}
                                                </small>
                                            </div>
                                            <div class="user-progress">
                                                <h6 class="mb-0">₹
                                                    {{ $user->plan_price }}/{{ $user->plan_time . $user->plan_duration }}
                                                </h6>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <div class="text-center mb-5 mt-5">
                                        <i class="bx bx-info-circle"></i> No Company Found.
                                    </div>
                                @endforelse

                                @if (!$PaidCompanyData->isEmpty())
                                    <li class="d-flex justify-content-center mb-5">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination pagination-sm">

                                                {{-- Previous Page --}}
                                                <li class="page-item {{ $PaidCompanyData->onFirstPage() ? 'disabled' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $PaidCompanyData->previousPageUrl() ?? '#' }}"
                                                        tabindex="-1">
                                                        <i class="tf-icon bx bx-chevrons-left bx-xs"></i>
                                                    </a>
                                                </li>

                                                {{-- Dynamic Page Numbers --}}
                                                @for ($i = 1; $i <= $PaidCompanyData->lastPage(); $i++)
                                                    <li
                                                        class="page-item {{ $PaidCompanyData->currentPage() == $i ? 'active' : '' }}">
                                                        <a class="page-link"
                                                            href="{{ $PaidCompanyData->url($i) }}">{{ $i }}</a>
                                                    </li>
                                                @endfor

                                                {{-- Next Page --}}
                                                <li
                                                    class="page-item {{ !$PaidCompanyData->hasMorePages() ? 'disabled' : '' }}">
                                                    <a class="page-link" href="{{ $PaidCompanyData->nextPageUrl() ?? '#' }}">
                                                        <i class="tf-icon bx bx-chevrons-right bx-xs"></i>
                                                    </a>
                                                </li>

                                            </ul>
                                        </nav>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            @endcan


            @can('Dashboard-paid_candidates')
                <!-- Transactions -->
                <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
                    <div class="card h-100">
                        <div class="card-header p-3 d-flex justify-content-between" style="background: #242a62;">
                            <div class="card-title mb-0">
                                <h5 class="mb-1 me-2" style="color: #fff;">Paid Candidates</h5>
                            </div>
                            <div class="dropdown">
                                <a class="btn btn-sm btn-secondary view-all-btn"
                                    href="{{ route('admin.paid-candidate.index') }}">View All</a>
                            </div>
                        </div>
                        <div class="card-body p-4" style="border: 2px solid #242a62;border-radius: 0px 0px 12px 12px;">
                            <ul class="p-0 m-0">

                                @forelse ($PaidCandidateData as $user)
                                    <li class="d-flex align-items-center mb-5">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-success"><i
                                                    class="bx bx-user-pin"></i></span>
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">{{ $user->name }}</h6>
                                                <small>{{ $user->plan_name }} &nbsp; <i class="bx bx-cart"
                                                        style="font-size: 15px;"></i> Buy Date -
                                                    {{ \Carbon\Carbon::parse($user->purchase_date)->format('d-m-Y') }}</small>
                                            </div>
                                            <div class="user-progress">
                                                <h6 class="mb-0">₹
                                                    {{ $user->plan_price }}/{{ $user->plan_time . $user->plan_duration }}</h6>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <div class="text-center mb-5 mt-5">
                                        <i class="bx bx-info-circle"></i> No Candidate Found.
                                    </div>
                                @endforelse

                                @if (!$PaidCandidateData->isEmpty())
                                    <li class="d-flex justify-content-center mb-5">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination pagination-sm">

                                                {{-- Previous Page --}}
                                                <li
                                                    class="page-item {{ $PaidCandidateData->onFirstPage() ? 'disabled' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $PaidCandidateData->previousPageUrl() ?? '#' }}"
                                                        tabindex="-1">
                                                        <i class="tf-icon bx bx-chevrons-left bx-xs"></i>
                                                    </a>
                                                </li>

                                                {{-- Dynamic Page Numbers --}}
                                                {{-- @for ($i = 1; $i <= $PaidCandidateData->lastPage(); $i++)
                                                    <li
                                                        class="page-item d-none {{ $PaidCandidateData->currentPage() == $i ? 'active' : '' }}">
                                                        <a class="page-link"
                                                            href="{{ $PaidCandidateData->url($i) }}">{{ $i }}</a>
                                                    </li>
                                                @endfor --}}

                                                {{-- Next Page --}}
                                                <li
                                                    class="page-item {{ !$PaidCandidateData->hasMorePages() ? 'disabled' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $PaidCandidateData->nextPageUrl() ?? '#' }}">
                                                        <i class="tf-icon bx bx-chevrons-right bx-xs"></i>
                                                    </a>
                                                </li>

                                            </ul>
                                        </nav>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <!--/ Transactions -->
            @endcan

<style> 
    .pagination {
    flex-wrap: wrap;
    gap: 6px;
}

.pagination .page-link {
    border-radius: 50%;
    min-width: 34px;
    text-align: center;
}

</style>
            @can('Dashboard-free_company_Candidates')
                <!-- Expense Overview -->
                <div class="col-md-6 col-lg-4 order-3 mb-6">
                    <div class="card text-center h-100">
                        <div class="card-header nav-align-top p-3" style="background: #242a62;">
                            <div class="card-title  mb-0 d-flex justify-content-between " style="text-align: left;">
                                <h5 class="mb-1 me-2" style="color: #fff;">Free Company & Candidates</h5>
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-secondary view-all-btn" href="free-company.php">View All</a>

                                </div>
                            </div>
                        </div>

                        <div class="h-100" style="border: 2px solid #242a62;border-radius: 0px 0px 12px 12px;">
                            <div class="container">
                                <ul class="nav nav-pills my-5" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-pills-Company" aria-controls="navs-pills-Company"
                                            aria-selected="true">
                                            Company
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-pills-Candidates" aria-controls="navs-pills-Candidates"
                                            aria-selected="false">
                                            Candidates
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content pt-0 pb-4">
                                <div class="tab-pane fade show active" id="navs-pills-Company" role="tabpanel">
                                    <ul class="p-0 m-0">
                                        @forelse ($FreeCompanyData as $row)
                                            <li class="d-flex align-items-center mb-5">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <span class="avatar-initial rounded bg-label-warning"><i
                                                            class="bx bx-building"></i></span>
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2" style="text-align: left;">
                                                        <h6 class="mb-0">{{ $row->name }}</h6>
                                                        <small>{{ $row->designation }}</small>
                                                    </div>
                                                    <div class="user-progress">
                                                        <h6 class="mb-0">Free</h6>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <div class="text-center mb-5 mt-5">
                                                <i class="bx bx-info-circle"></i> No Company Found.
                                            </div>
                                        @endforelse


                                        @if (!$FreeCompanyData->isEmpty())
                                            <li class="d-flex justify-content-center mb-5">
                                                <nav aria-label="Page navigation">
                                                    <ul class="pagination pagination-sm">

                                                        {{-- Previous Page --}}
                                                        <li
                                                            class="page-item {{ $FreeCompanyData->onFirstPage() ? 'disabled' : '' }}">
                                                            <a class="page-link"
                                                                href="{{ $FreeCompanyData->previousPageUrl() ?? '#' }}"
                                                                tabindex="-1">
                                                                <i class="tf-icon bx bx-chevrons-left bx-xs"></i>
                                                            </a>
                                                        </li>

                                                        {{-- Dynamic Page Numbers --}}
                                                        @for ($i = 1; $i <= $FreeCompanyData->lastPage(); $i++)
                                                            <li
                                                                class="page-item {{ $FreeCompanyData->currentPage() == $i ? 'active' : '' }}">
                                                                <a class="page-link"
                                                                    href="{{ $FreeCompanyData->url($i) }}">{{ $i }}</a>
                                                            </li>
                                                        @endfor

                                                        {{-- Next Page --}}
                                                        <li
                                                            class="page-item {{ !$FreeCompanyData->hasMorePages() ? 'disabled' : '' }}">
                                                            <a class="page-link"
                                                                href="{{ $FreeCompanyData->nextPageUrl() ?? '#' }}">
                                                                <i class="tf-icon bx bx-chevrons-right bx-xs"></i>
                                                            </a>
                                                        </li>

                                                    </ul>
                                                </nav>
                                            </li>
                                        @endif



                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="navs-pills-Candidates" role="tabpanel">
                                    <ul class="p-0 m-0">
                                        @forelse ($FreeCandidateData as $row)
                                            <li class="d-flex align-items-center mb-5">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <span class="avatar-initial rounded bg-label-warning">
                                                        <i class="bx bx-user-pin"></i>
                                                    </span>
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2" style="text-align: left;">
                                                        <h6 class="mb-0">{{ $row->name }}</h6>
                                                        <small>{{ $row->designation }}</small>
                                                    </div>
                                                    <div class="user-progress">
                                                        <h6 class="mb-0">Free</h6>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <div class="text-center mb-5">
                                                <i class="bx bx-info-circle"></i> No candidates found.
                                            </div>
                                        @endforelse

                                        @if (!$FreeCandidateData->isEmpty())
                                            <li class="d-flex justify-content-center mb-5">
                                                <nav aria-label="Page navigation">
                                                    <ul class="pagination pagination-sm">

                                                        {{-- Previous Page --}}
                                                        <li
                                                            class="page-item {{ $FreeCandidateData->onFirstPage() ? 'disabled' : '' }}">
                                                            <a class="page-link"
                                                                href="{{ $FreeCandidateData->previousPageUrl() ?? '#' }}"
                                                                tabindex="-1">
                                                                <i class="tf-icon bx bx-chevrons-left bx-xs"></i>
                                                            </a>
                                                        </li>

                                                        {{-- Dynamic Page Numbers --}}
                                                        @for ($i = 1; $i <= $FreeCandidateData->lastPage(); $i++)
                                                            <li
                                                                class="page-item {{ $FreeCandidateData->currentPage() == $i ? 'active' : '' }}">
                                                                <a class="page-link"
                                                                    href="{{ $FreeCandidateData->url($i) }}">{{ $i }}</a>
                                                            </li>
                                                        @endfor

                                                        {{-- Next Page --}}
                                                        <li
                                                            class="page-item {{ !$FreeCandidateData->hasMorePages() ? 'disabled' : '' }}">
                                                            <a class="page-link"
                                                                href="{{ $FreeCandidateData->nextPageUrl() ?? '#' }}">
                                                                <i class="tf-icon bx bx-chevrons-right bx-xs"></i>
                                                            </a>
                                                        </li>

                                                    </ul>
                                                </nav>
                                            </li>
                                        @endif



                                    </ul>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <!--/ Expense Overview -->
            @endcan


            @can('Dashboard-staff_activity_history')
                <!-- Activity Timeline -->
                <div class="col-md-12 col-lg-6 order-4 order-lg-3">
                    <div class="card h-100">
                        <div class="card-header p-3 d-flex justify-content-between" style="background: #242a62;">
                            <h5 class="card-title m-0 me-2" style="color: #fff;">Staff Activity History</h5>
                            <div class="dropdown">
                                <a class="btn btn-sm btn-secondary view-all-btn" href="{{ route('admin.staff-activity-history') }}">View
                                    All</a>

                            </div>
                        </div>
                        <div class="card-body pt-2" style="border: 2px solid #242a62;border-radius: 0px 0px 12px 12px;height: 450px;overflow: auto;">
                            <ul class="timeline mb-0 mt-3">
                                @forelse ($activities as $row)
                                    <li class="timeline-item timeline-item-transparent">
                                        <span class="timeline-point timeline-point-primary"></span>
                                        <div class="timeline-event">
                                            <div class="timeline-header mb-3">
                                                <h6 class="mb-0">{{ $row->user_name }}</h6>
                                                <small class="text-muted">{{ $row->datetime }}</small>
                                            </div>
                                            <p class="mb-2">{{ $row->msg }}</p>
                                            <span class="badge bg-label-secondary">{{ $row->role_name }}</span>
                                        </div>
                                    </li>
                                @empty
                                   <h5 class="mb-0" style="font-weight: 600;text-align: center;padding: 20px;">Data Not Found!</h5>
                                @endforelse



                            </ul>
                        </div>
                    </div>
                </div>
                <!--/ Activity Timeline -->
                @endif


                @can('Dashboard-expired_plan_month')
                    <div class="col-md-6 order-3 order-lg-4 mb-6 mb-lg-0">
                        <div class="card text-center h-100">
                            <div class="card-header nav-align-top p-3" style="background: #242a62;">
                                <div class="card-title mb-0 d-flex justify-content-between" style="text-align: left;">
                                    <h5 class="mb-1 me-2" style="color: #fff;">Expired Plan on this month</h5>
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-secondary view-all-btn"
                                            href="{{ route('admin.expire-company-plan') }}">View
                                            All</a>
                                    </div>
                                </div>
                            </div>

                            <div class="h-100" style="border: 2px solid #242a62;border-radius: 0px 0px 12px 12px;">
                                <div class="container">
                                    <ul class="nav nav-pills mt-3" role="tablist">
                                        <li class="nav-item">
                                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#navs-pills-expired-company"
                                                aria-controls="navs-pills-expired-company" aria-selected="true">
                                                Company
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#navs-pills-expired-candidates"
                                                aria-controls="navs-pills-expired-candidates" aria-selected="false">
                                                Candidates
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content pt-0 pb-4 p-4">
                                    <div class="tab-pane fade show active" id="navs-pills-expired-company" role="tabpanel">
                                        <div class="table-responsive text-start text-nowrap">
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Company Name</th>
                                                        <th>Expired Date</th>
                                                        <th>Contact No.</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($ExpiredPlanCompanyData as $row)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                <b>{{ $row->name }}</b>
                                                            </td>
                                                            <td class="text-heading">{{ $row->expire_date }}</td>
                                                            <td class="text-heading">{{ $row->contact_no }}</td>
                                                            <td>
                                                                <a href="{{ route('admin.company-profile', $row->id) }}"
                                                                    class="btn btn-warning rounded-pill btn-sm p-2"><i
                                                                        class="fa fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" style="text-align: center">No Company Found.</td>
                                                        </tr>
                                                    @endforelse

                                                </tbody>
                                            </table>

                                            @if (!$ExpiredPlanCompanyData->isEmpty())
                                                <li class="d-flex justify-content-center mt-4">
                                                    <nav aria-label="Page navigation">
                                                        <ul class="pagination pagination-sm">

                                                            {{-- Previous Page --}}
                                                            <li
                                                                class="page-item {{ $ExpiredPlanCompanyData->onFirstPage() ? 'disabled' : '' }}">
                                                                <a class="page-link"
                                                                    href="{{ $ExpiredPlanCompanyData->previousPageUrl() ?? '#' }}"
                                                                    tabindex="-1">
                                                                    <i class="tf-icon bx bx-chevrons-left bx-xs"></i>
                                                                </a>
                                                            </li>

                                                            {{-- Dynamic Page Numbers --}}
                                                            @for ($i = 1; $i <= $ExpiredPlanCompanyData->lastPage(); $i++)
                                                                <li
                                                                    class="page-item {{ $ExpiredPlanCompanyData->currentPage() == $i ? 'active' : '' }}">
                                                                    <a class="page-link"
                                                                        href="{{ $ExpiredPlanCompanyData->url($i) }}">{{ $i }}</a>
                                                                </li>
                                                            @endfor

                                                            {{-- Next Page --}}
                                                            <li
                                                                class="page-item {{ !$ExpiredPlanCompanyData->hasMorePages() ? 'disabled' : '' }}">
                                                                <a class="page-link"
                                                                    href="{{ $ExpiredPlanCompanyData->nextPageUrl() ?? '#' }}">
                                                                    <i class="tf-icon bx bx-chevrons-right bx-xs"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                </li>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="navs-pills-expired-candidates" role="tabpanel">
                                        <div class="table-responsive text-start text-nowrap">
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Candidate Name</th>
                                                        <th>Expired Date</th>
                                                        <th>Contact No.</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($ExpiredPlanCandidateData as $row)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                <b>{{ $row->name }}</b>
                                                            </td>
                                                            <td class="text-heading">{{ $row->expire_date }}</td>
                                                            <td class="text-heading">{{ $row->contact_no }}</td>
                                                            <td>
                                                                <a href="{{ route('admin.candidate-profile', $row->id) }}"
                                                                    class="btn btn-warning rounded-pill btn-sm p-2"><i
                                                                        class="fa fa-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" style="text-align: center">No Company Found.</td>
                                                        </tr>
                                                    @endforelse



                                                </tbody>
                                            </table>

                                            @if (!$ExpiredPlanCandidateData->isEmpty())
                                                <li class="d-flex justify-content-center mt-4">
                                                    <nav aria-label="Page navigation">
                                                        <ul class="pagination pagination-sm">

                                                            {{-- Previous Page --}}
                                                            <li
                                                                class="page-item {{ $ExpiredPlanCandidateData->onFirstPage() ? 'disabled' : '' }}">
                                                                <a class="page-link"
                                                                    href="{{ $ExpiredPlanCandidateData->previousPageUrl() ?? '#' }}"
                                                                    tabindex="-1">
                                                                    <i class="tf-icon bx bx-chevrons-left bx-xs"></i>
                                                                </a>
                                                            </li>

                                                            {{-- Dynamic Page Numbers --}}
                                                            @for ($i = 1; $i <= $ExpiredPlanCandidateData->lastPage(); $i++)
                                                                <li
                                                                    class="page-item {{ $ExpiredPlanCandidateData->currentPage() == $i ? 'active' : '' }}">
                                                                    <a class="page-link"
                                                                        href="{{ $ExpiredPlanCandidateData->url($i) }}">{{ $i }}</a>
                                                                </li>
                                                            @endfor

                                                            {{-- Next Page --}}
                                                            <li
                                                                class="page-item {{ !$ExpiredPlanCandidateData->hasMorePages() ? 'disabled' : '' }}">
                                                                <a class="page-link"
                                                                    href="{{ $ExpiredPlanCandidateData->nextPageUrl() ?? '#' }}">
                                                                    <i class="tf-icon bx bx-chevrons-right bx-xs"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                </li>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    @endsection


    @push('script')
        <script>
            $(document).ready(function() {

                var Company = $('#TodayinternshipRegisterListDataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.dashboard.internship.list') }}",
                        type: "GET",
                        data: function (d) {
                            d._token = '{{ csrf_token() }}';
                        }
                    },
                    columns: [
                        {
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
                            data: 'phone_no',
                            name: 'phone_no'
                        },
                        {
                            data: 'degree',
                            name: 'degree'
                        },
                        {
                            data: 'city',
                            name: 'city'
                        },
                        // {
                        //     data: 'action',
                        //     name: 'action',
                        //     orderable: false,
                        //     searchable: false
                        // }
                    ]
                });

                var Company = $('#TodayHackathonsRegisterListDataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.dashboard.hackathon.list') }}",
                        type: "GET",
                        data: function (d) {
                            d._token = '{{ csrf_token() }}';
                        }
                    },
                    columns: [
                        {
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
                            data: 'phone_no',
                            name: 'phone_no'
                        },
                        {
                            data: 'degree',
                            name: 'degree'
                        },
                        {
                            data: 'city',
                            name: 'city'
                        },
                        // {
                        //     data: 'action',
                        //     name: 'action',
                        //     orderable: false,
                        //     searchable: false
                        // }
                    ]
                });


                var candidate = $('#TodayCandidatesRegisterListDataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.dashboard.gettodaycandidatesregistertabledata') }}",
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
                            data: 'contact_no',
                            name: 'contact_no'
                        },

                        {
                            data: 'plan',
                            name: 'plan'
                        },
                        {
                            data: 'preference_type_name',
                            name: 'preference_type_name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }

                    ]
                });


                var candidateApprove = $('#TodayApproveCandidatesRegisterListDataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.dashboard.gettodayapprovecandidatesregistertabledata') }}",
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
                            data: 'contact_no',
                            name: 'contact_no'
                        },

                        {
                            data: 'plan',
                            name: 'plan'
                        },
                        {
                            data: 'preference_type_name',
                            name: 'preference_type_name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }

                    ]
                });


                var Company = $('#TodayCompanyRegisterListDataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.dashboard.gettodaycompanyregistertabledata') }}",
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
                            data: 'contact_no',
                            name: 'contact_no'
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


                var CompanyApprove = $('#TodayApproveCompanyRegisterListDataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.dashboard.gettodayapprovecompanyregistertabledata') }}",
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
                            data: 'contact_no',
                            name: 'contact_no'
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
                
                 // Initialize DataTable for New Internship Requests
                var newInternshipRequestsTable = $('#NewInternshipRequestsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.internship.new-requests-data') }}",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        error: function(xhr, error, code) {
                            console.log('Ajax Error:', xhr.responseText);
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'internship_title', name: 'internship_title' },
                        { data: 'company_name', name: 'company_name' },
                        { data: 'duration', name: 'duration' },
                        { data: 'formatted_date', name: 'created_at' },
                        { data: 'category_name', name: 'category_name' },
                        { data: 'location', name: 'location' },
                        { data: 'openings', name: 'openings' },
                        { data: 'status_badge', name: 'approve_status', orderable: false },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ],
                    order: [[4, 'desc']],
                    pageLength: 5,
                    lengthChange: false,
                    searching: false,
                    info: false
                });
          

            // Make functions global for DataTable buttons
            window.openAcceptModal = function(internshipId) {
                // Fetch internship details
                $.ajax({
                    url: '{{ url("admin/internship/details") }}/' + internshipId,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            const data = response.data;
                            
                            // Populate modal with internship details
                            $('#internshipTitle').text(data.internship_title || '-');
                            $('#category').text(data.category_name || '-');
                            $('#companyName').text(data.company_name || '-');
                            $('#workMode').text(data.mode || '-');
                            $('#location').text(data.location || '-');
                            $('#duration').text(data.duration || '-');
                            $('#startDate').text(data.formatted_start_date || '-');
                            $('#endDate').text(data.formatted_end_date || '-');
                            $('#stipend').text(data.stipend ? '₹' + data.stipend : 'Not specified');
                            $('#openings').text((data.openings || 0) + ' Positions');
                            
                            // Set date input fields with raw date values
                            if (data.start_date) {
                                $('#modalStartDate').val(data.start_date);
                            }
                            if (data.end_date) {
                                $('#modalEndDate').val(data.end_date);
                            }
                            
                            // Set registration fees if available
                            if (data.registration_fees) {
                                $('#registrationFees').val(data.registration_fees);
                            } else {
                                $('#registrationFees').val(0);
                            }
                            
                            // Trigger GST calculation (GST is fixed at 18%)
                            $('#registrationFees').trigger('input');
                            
                            // Batch Days
                            if (data.batch_days && Object.keys(data.batch_days).length > 0) {
                                const days = Object.keys(data.batch_days).join(', ');
                                $('#batchDays').text(days);
                                
                                let timeSlotsHtml = '';
                                Object.keys(data.batch_days).forEach(day => {
                                    const dayData = data.batch_days[day];
                                    timeSlotsHtml += `${day}: ${dayData.start_time || '-'} - ${dayData.end_time || '-'}<br>`;
                                });
                                $('#timeSlots').html(timeSlotsHtml);
                            } else {
                                $('#batchDays').text('Not specified');
                                $('#timeSlots').text('Not specified');
                            }
                            
                            // Skills
                            if (data.skills) {
                                let skills = [];
                                try {
                                    // Try to parse as JSON array first
                                    skills = JSON.parse(data.skills);
                                } catch (e) {
                                    // If not JSON, split by comma
                                    skills = data.skills.split(',');
                                }
                                let skillsHtml = '';
                                skills.forEach(skill => {
                                    skillsHtml += `<span class="badge bg-primary me-1">${skill.trim()}</span>`;
                                });
                                $('#requiredSkills').html(skillsHtml);
                            } else {
                                $('#requiredSkills').text('Not specified');
                            }
                            
                            // Eligibility Criteria
                            if (data.eligibility_criteria) {
                                let criteria = [];
                                try {
                                    // Try to parse as JSON array first
                                    criteria = JSON.parse(data.eligibility_criteria);
                                } catch (e) {
                                    // If not JSON, split by comma
                                    criteria = data.eligibility_criteria.split(',');
                                }
                                let criteriaHtml = '';
                                criteria.forEach(c => {
                                    criteriaHtml += `<span class="badge bg-info me-1">${c.trim()}</span>`;
                                });
                                $('#eligibilityCriteria').html(criteriaHtml);
                            } else {
                                $('#eligibilityCriteria').text('Not specified');
                            }
                            
                            // Descriptions
                            $('#internshipDescription').html(data.internship_description || '-');
                            $('#moduleDescription').html(data.module_brief_description || '-');
                            $('#internshipObjective').html(data.internship_objective || '-');
                            $('#internshipOutcome').html(data.internship_outcome || '-');
                            
                            // Store internship ID for accept action
                            $('#acceptInternshipModal').data('internship-id', internshipId);

                            // Default: Associate with College + Enable Task Management
                            $('#internshipType').val('1');
                            $('#manageTaskStatus').prop('checked', true);
                            
                            // Show modal
                            $('#acceptInternshipModal').modal('show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to load internship details'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to load internship details'
                        });
                    }
                });
            };

            // Reject Internship from Dashboard (Global function)
            window.rejectInternship = function(internshipId) {
                Swal.fire({
                    title: 'Reject Internship',
                    html: `
                        <p>Are you sure you want to reject this internship?</p>
                        <textarea id="rejectionReasonIndex" class="form-control mt-3" rows="3" placeholder="Enter rejection reason (optional)"></textarea>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, reject it!',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        return {
                            reason: document.getElementById('rejectionReasonIndex').value
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ url("admin/internship/reject") }}/' + internshipId,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                rejection_reason: result.value.reason
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Rejected!',
                                        text: response.message || 'Internship rejected successfully!',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    
                                    // Reload table
                                    if ($.fn.DataTable.isDataTable('#NewInternshipRequestsTable')) {
                                        $('#NewInternshipRequestsTable').DataTable().ajax.reload();
                                    }
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message || 'Failed to reject internship'
                                    });
                                }
                            },
                            error: function(xhr) {
                                let errorMessage = 'Failed to reject internship';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: errorMessage
                                });
                            }
                        });
                    }
                });
            };

            // Accept Internship from Dashboard (Alias for backward compatibility)
            function openAcceptModalIndex(internshipId) {
                window.openAcceptModal(internshipId);
            }

            // Reject Internship from Dashboard (Alias for backward compatibility)
            function rejectInternshipIndex(internshipId) {
                window.rejectInternship(internshipId);
            }

            // Confirm Accept Internship (Global function for modal)
            window.confirmAcceptInternship = function() {
                const internshipId = $('#acceptInternshipModal').data('internship-id');
                
                if (!internshipId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Internship ID not found'
                    });
                    return;
                }

                // Validate form
                const form = document.getElementById('internshipConfigForm');
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const internshipType = parseInt($('#internshipType').val(), 10);
                if (![1, 2].includes(internshipType)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation Error',
                        text: 'Please select internship type'
                    });
                    return;
                }
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to approve this internship with the configured fees?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, approve it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Collect form data
                        const formData = {
                            start_date: $('#modalStartDate').val(),
                            end_date: $('#modalEndDate').val(),
                            registration_fees: $('#registrationFees').val(),
                            gst_percentage: 18,
                            gst_amount: $('#gstAmount').val(),
                            final_amount: $('#finalAmount').val(),
                            internship_type: internshipType,
                            manage_task_status: $('#manageTaskStatus').is(':checked') ? 1 : 0
                        };

                        $.ajax({
                            url: '{{ url("admin/internship/accept") }}/' + internshipId,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: formData,
                            success: function(response) {
                                if (response.success) {
                                    $('#acceptInternshipModal').modal('hide');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Approved!',
                                        text: response.message || 'Internship approved successfully!',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    
                                    // Reload table
                                    if ($.fn.DataTable.isDataTable('#NewInternshipRequestsTable')) {
                                        $('#NewInternshipRequestsTable').DataTable().ajax.reload();
                                    }
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message || 'Failed to approve internship'
                                    });
                                }
                            },
                            error: function(xhr) {
                                let errorMessage = 'Failed to approve internship';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: errorMessage
                                });
                            }
                        });
                    }
                });
            };
            
            
            
            
            });
            
            
            // GST Calculation - Real-time calculation when registration fees change
            $(document).ready(function() {
                // Calculate GST when registration fees input changes
                $('#registrationFees').on('input', function() {
                    calculateGST();
                });

                // Function to calculate GST and total amount
                function calculateGST() {
                    const regFees = parseFloat($('#registrationFees').val()) || 0;
                    const gstPercent = 18; // Fixed at 18%
                    
                    // Calculate GST amount
                    const gstAmount = (regFees * gstPercent) / 100;
                    
                    // Calculate final amount
                    const finalAmount = regFees + gstAmount;
                    
                    // Update fields
                    $('#gstAmount').val(gstAmount.toFixed(2));
                    $('#finalAmount').val(finalAmount.toFixed(2));
                    
                    // Update summary box
                    $('#summaryRegFees').text(regFees.toFixed(2));
                    $('#summaryGst').text(gstAmount.toFixed(2));
                    $('#summaryTotal').text(finalAmount.toFixed(2));
                }

                // Initial calculation on page load
                calculateGST();
            });
        </script>
    @endpush
