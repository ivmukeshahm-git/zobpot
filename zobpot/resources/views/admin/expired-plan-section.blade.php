<div class="col-md-6 order-3 order-lg-4 mb-6 mb-lg-0">
                        <div class="card h-100">
                            <div class="card-header nav-align-top p-3" style="background: #242a62;">
                                <div class="card-title mb-0 d-flex justify-content-between" style="text-align: left;">
                                    <h5 class="mb-1 me-2" style="color: #fff;">
                                        <i class="fi-rr-calendar-x me-2"></i>Expired Plans This Month
                                    </h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light dropdown-toggle view-all-btn" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            View All
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @can('Company-company_expire_plan')
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.expire-company-plan') }}">
                                                        <i class="fi-rr-building me-2 text-primary"></i> Companies
                                                        <span class="badge bg-primary ms-auto">{{ $ExpiredPlanCompanyData->total() }}</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('Candidate-candidate_expire_plan')
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.expire-candidates-plan') }}">
                                                        <i class="fi-rr-user me-2 text-success"></i> Candidates
                                                        <span class="badge bg-success ms-auto">{{ $ExpiredPlanCandidateData->total() }}</span>
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>
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
                                                <i class="fi-rr-building me-1"></i> Companies
                                                @if($ExpiredPlanCompanyData->total() > 0)
                                                    <span class="badge bg-primary ms-2">{{ $ExpiredPlanCompanyData->total() }}</span>
                                                @endif
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                data-bs-target="#navs-pills-expired-candidates"
                                                aria-controls="navs-pills-expired-candidates" aria-selected="false">
                                                <i class="fi-rr-user me-1"></i> Candidates
                                                @if($ExpiredPlanCandidateData->total() > 0)
                                                    <span class="badge bg-success ms-2">{{ $ExpiredPlanCandidateData->total() }}</span>
                                                @endif
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content pt-0 pb-4 p-4">
                                    <div class="tab-pane fade show active" id="navs-pills-expired-company" role="tabpanel">
                                        <div class="table-responsive text-start text-nowrap">
                                            <table class="table table-borderless mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Company Name</th>
                                                        <th>Plan</th>
                                                        <th>Expires On</th>
                                                        <th>Contact</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($ExpiredPlanCompanyData as $row)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar flex-shrink-0 me-3">
                                                                        <span class="avatar-initial rounded bg-label-primary">
                                                                            <i class="fi-rr-building"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-0">{{ $row->name }}</h6>
                                                                        @if(isset($row->plan_name))
                                                                            <small class="text-muted">{{ $row->plan_name }}</small>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @if(isset($row->plan_name))
                                                                    <span class="badge bg-info">{{ $row->plan_name }}</span>
                                                                @else
                                                                    <span class="badge bg-secondary">N/A</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-heading">
                                                                <span class="badge bg-warning text-dark">
                                                                    <i class="fi-rr-calendar me-1"></i>
                                                                    {{ $row->expire_date ? \Carbon\Carbon::parse($row->expire_date)->format('d M Y') : 'N/A' }}
                                                                </span>
                                                            </td>
                                                            <td class="text-heading">{{ $row->contact_no }}</td>
                                                            <td>
                                                                <a href="{{ route('admin.company-profile', $row->id) }}"
                                                                    class="btn btn-warning rounded-pill btn-sm p-2" title="View Profile">
                                                                    <i class="fi-rr-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center py-4">
                                                                <div class="text-muted">
                                                                    <i class="fi-rr-calendar-check bx-lg mb-2 d-block"></i>
                                                                    <span>No companies with expiring plans this month</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>

                                            @if (!$ExpiredPlanCompanyData->isEmpty() && $ExpiredPlanCompanyData->hasPages())
                                                <div class="d-flex justify-content-center mt-3">
                                                    <nav aria-label="Page navigation">
                                                        <ul class="pagination pagination-sm mb-0">
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
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="navs-pills-expired-candidates" role="tabpanel">
                                        <div class="table-responsive text-start text-nowrap">
                                            <table class="table table-borderless mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Candidate Name</th>
                                                        <th>Plan</th>
                                                        <th>Expires On</th>
                                                        <th>Contact</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($ExpiredPlanCandidateData as $row)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar flex-shrink-0 me-3">
                                                                        <span class="avatar-initial rounded bg-label-success">
                                                                            <i class="fi-rr-user"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-0">{{ $row->name }}</h6>
                                                                        @if(isset($row->plan_name))
                                                                            <small class="text-muted">{{ $row->plan_name }}</small>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @if(isset($row->plan_name))
                                                                    <span class="badge bg-info">{{ $row->plan_name }}</span>
                                                                @else
                                                                    <span class="badge bg-secondary">N/A</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-heading">
                                                                <span class="badge bg-warning text-dark">
                                                                    <i class="fi-rr-calendar me-1"></i>
                                                                    {{ $row->expire_date ? \Carbon\Carbon::parse($row->expire_date)->format('d M Y') : 'N/A' }}
                                                                </span>
                                                            </td>
                                                            <td class="text-heading">{{ $row->contact_no }}</td>
                                                            <td>
                                                                <a href="{{ route('admin.candidate-profile', $row->id) }}"
                                                                    class="btn btn-warning rounded-pill btn-sm p-2" title="View Profile">
                                                                    <i class="fi-rr-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center py-4">
                                                                <div class="text-muted">
                                                                    <i class="fi-rr-calendar-check bx-lg mb-2 d-block"></i>
                                                                    <span>No candidates with expiring plans this month</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>

                                            @if (!$ExpiredPlanCandidateData->isEmpty() && $ExpiredPlanCandidateData->hasPages())
                                                <div class="d-flex justify-content-center mt-3">
                                                    <nav aria-label="Page navigation">
                                                        <ul class="pagination pagination-sm mb-0">
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
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>