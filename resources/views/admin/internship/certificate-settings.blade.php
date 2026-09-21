@extends('admin.layout.layout')

@section('content')
<script>
    page_active_id = "InternshipCertificateSettings";
</script>

<style>
    .cert-settings-hint {
        font-size: 12px;
        color: #6c757d;
        margin-top: 4px;
    }
    .cert-preview-chip {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        background: #e8eaf6;
        color: #242a64;
    }
    .cert-img-preview {
        max-height: 80px;
        max-width: 160px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 6px;
        background: #fff;
        margin-top: 8px;
    }
    .nav-tabs .nav-link.active {
        font-weight: 700;
        color: #242a64 !important;
        border-bottom-color: #242a64 !important;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h4 class="mb-1">Certificate Settings</h4>
            <p class="mb-0 text-muted">Edit static text shown on Company &amp; College opportunity certificates. Student name, dates, logos and certificate number stay dynamic.</p>
        </div>
        <a href="{{ route('admin.internship.certificates') }}" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back"></i> Back to Certificates
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $activeTab = old('cert_type', session('active_tab', 'company'));
        if (!in_array($activeTab, ['company', 'college'], true)) {
            $activeTab = 'company';
        }
    @endphp

    <div class="card">
        <div class="card-header border-bottom">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link {{ $activeTab === 'company' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#tab-company" type="button" role="tab">
                        Company Certificate
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link {{ $activeTab === 'college' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#tab-college" type="button" role="tab">
                        College Certificate
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content pt-3">
                {{-- COMPANY TAB --}}
                <div class="tab-pane fade {{ $activeTab === 'company' ? 'show active' : '' }}" id="tab-company" role="tabpanel">
                    @include('admin.internship.partials.certificate-settings-form', [
                        'type' => 'company',
                        'data' => $company,
                    ])
                </div>

                {{-- COLLEGE TAB --}}
                <div class="tab-pane fade {{ $activeTab === 'college' ? 'show active' : '' }}" id="tab-college" role="tabpanel">
                    @include('admin.internship.partials.certificate-settings-form', [
                        'type' => 'college',
                        'data' => $college,
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
