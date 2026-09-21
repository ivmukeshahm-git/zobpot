@php
    /**
     * Single source of truth for certificate HTML (Admin Preview + PDF Download).
     * $forPdf = true → use base64 DomPDF image sources; otherwise public URLs.
     * Static copy comes from $certSettings (CertificateSetting::forType).
     */
    $forPdf = !empty($forPdf);
    $cs = $certSettings ?? \App\Models\CertificateSetting::forType($type ?? 'company');

    if ($forPdf) {
        $leftLogoUrl = $type === 'company' ? ($company_logo_src ?? null) : ($college_logo_src ?? null);
        $platformLogo = $platform_logo_src ?? null;
        $companySig = $company_signature_src ?? null;
        $collegeSig = $college_signature_src ?? null;
        $directorSig = $director_signature_src ?? null;
        $roundSeal = $round_seal_src ?? null;
    } else {
        $leftLogoUrl = $type === 'company' ? ($company_logo_url ?? null) : ($college_logo_url ?? null);
        $platformLogo = $platform_logo_url ?? null;
        $companySig = $company_signature_url ?? null;
        $collegeSig = $college_signature_url ?? null;
        $directorSig = $director_signature_url ?? null;
        $roundSeal = $round_seal_url ?? null;
    }

    $leftLogoLabel = $type === 'company' ? ($company_name ?? 'Company') : ($college_name ?? 'College');
    $platformFallback = $cs['platform_director_name'] ?? 'ZobPot';
@endphp
<div class="zp-certificate {{ $type === 'college' ? 'college-cert' : 'company-cert' }}" id="certificatePrintArea">
    <div class="corner tl"></div>
    <div class="corner tr"></div>
    <div class="corner bl"></div>
    <div class="corner br"></div>
    <div class="inner-border"></div>
    <div class="accent-line top"></div>
    <div class="accent-line bottom"></div>

    @if($forPdf)
    {{-- PDF: 3-column single table — left logo | title | right logo — mirrors preview layout --}}
    <table class="zp-cert-top" width="100%" cellpadding="0" cellspacing="0">
        <colgroup>
            <col style="width: 140pt;">
            <col style="width: 471.89pt;">
            <col style="width: 140pt;">
        </colgroup>
        <tr>
            <td class="cert-logo-left" width="140" align="left" valign="middle">
                @if($leftLogoUrl)
                    <img src="{{ $leftLogoUrl }}" alt="Issuer Logo" width="90" height="50" style="width:90pt;height:auto;display:block;">
                @else
                    <div class="logo-fallback">{{ \Illuminate\Support\Str::limit($leftLogoLabel, 20) }}</div>
                @endif
            </td>
            <td class="zp-cert-header" align="center" valign="middle">
                <div class="brand">{{ $cs['brand_title'] }}</div>
                <h1>{{ $cs['heading'] }}</h1>
                <p class="subtitle">{{ $cs['subtitle'] }}</p>
                <span class="zp-cert-type-badge">{{ $cs['badge_label'] }}</span>
            </td>
            <td class="cert-logo-right" width="140" align="right" valign="middle">
                @if($platformLogo)
                    <img src="{{ $platformLogo }}" alt="{{ $platformFallback }}" width="90" height="50" style="width:90pt;height:auto;display:block;margin-left:auto;">
                @else
                    <div class="logo-fallback">{{ $platformFallback }}</div>
                @endif
            </td>
        </tr>
    </table>
    @else
    <table class="zp-cert-top" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td class="cert-logo-left" width="22%" align="left" valign="middle">
                @if($leftLogoUrl)
                    <img src="{{ $leftLogoUrl }}" alt="Issuer Logo">
                @else
                    <div class="logo-fallback">{{ \Illuminate\Support\Str::limit($leftLogoLabel, 20) }}</div>
                @endif
            </td>
            <td class="zp-cert-header" width="56%" align="center" valign="middle">
                <div class="brand">{{ $cs['brand_title'] }}</div>
                <h1>{{ $cs['heading'] }}</h1>
                <p class="subtitle">{{ $cs['subtitle'] }}</p>
                <span class="zp-cert-type-badge">{{ $cs['badge_label'] }}</span>
            </td>
            <td class="cert-logo-right" width="22%" align="right" valign="middle">
                @if($platformLogo)
                    <img src="{{ $platformLogo }}" alt="{{ $platformFallback }}">
                @else
                    <div class="logo-fallback">{{ $platformFallback }}</div>
                @endif
            </td>
        </tr>
    </table>
    @endif

    <div class="zp-cert-body">
        <p class="awarded">{{ $cs['certify_text'] }}</p>
        <h2 class="student-name">{{ $student_name }}</h2>

        @if($type === 'college')
            <p class="line-text">
                {{ $cs['student_of_text'] }} <strong>{{ $college_name }}</strong>
                @if(!empty($university_name) && $university_name !== 'N/A')
                    ({{ $university_name }})
                @endif
                @if(!empty($degree_name))
                    {{ $cs['pursuing_text'] }} <strong>{{ $degree_name }}</strong>
                @endif
            </p>
        @endif

        <p class="line-text">{{ $cs['completed_text'] }}</p>
        <div class="internship-title">{{ $internship_title }}</div>

        @if($type === 'company')
            <p class="line-text">{{ $cs['conducted_by_text'] }}</p>
            <div class="org-name">{{ $company_name }}</div>
        @else
            <p class="line-text">{{ $cs['association_text'] }}</p>
            <div class="org-name">{{ $company_name }}</div>
            <p class="line-text">{{ $cs['awarded_by_text'] }} <strong>{{ $college_name }}</strong>.</p>
        @endif

        <p class="line-text cert-disclaimer" style="font-style: italic; color: #6c757d;">
            {{ $cs['disclaimer_text'] }}
        </p>

        <table class="zp-cert-meta" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td class="item">
                    <div class="label">{{ $cs['label_certificate_no'] }}</div>
                    <div class="value">{{ $certificate_no }}</div>
                </td>
                <td class="item-gap">&nbsp;</td>
                <td class="item">
                    <div class="label">{{ $cs['label_duration'] }}</div>
                    <div class="value">{{ $duration }}</div>
                </td>
                <td class="item-gap">&nbsp;</td>
                <td class="item">
                    <div class="label">{{ $cs['label_period'] }}</div>
                    <div class="value">{{ $start_date }} – {{ $end_date }}</div>
                </td>
                <td class="item-gap">&nbsp;</td>
                <td class="item">
                    <div class="label">{{ $cs['label_issue_date'] }}</div>
                    <div class="value">{{ $issue_date }}</div>
                </td>
                <td class="item-gap">&nbsp;</td>
                <td class="item">
                    <div class="label">{{ $cs['label_mode'] }}</div>
                    <div class="value">{{ $mode }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="zp-cert-footer" width="100%" cellpadding="0" cellspacing="0">
        @if($forPdf)
        <colgroup>
            <col style="width: 250pt;">
            <col style="width: 251.89pt;">
            <col style="width: 250pt;">
        </colgroup>
        @endif
        <tr>
            <td class="sign" width="33%" align="center" valign="bottom">
                @if($type === 'company' && !empty($companySig))
                    @if($forPdf)
                        <img src="{{ $companySig }}" alt="Company Signature" width="100" height="45" style="width:100pt;height:45pt;display:block;margin:0 auto 2pt;">
                    @else
                        <img src="{{ $companySig }}" alt="Company Signature">
                    @endif
                @elseif($type === 'college' && !empty($collegeSig))
                    @if($forPdf)
                        <img src="{{ $collegeSig }}" alt="College Signature" width="100" height="45" style="width:100pt;height:45pt;display:block;margin:0 auto 2pt;">
                    @else
                        <img src="{{ $collegeSig }}" alt="College Signature">
                    @endif
                @else
                    <div class="sign-name">{{ $issuer_name }}</div>
                @endif
                <div class="sign-line"></div>
                <div class="sign-role">{{ $cs['left_signatory_role'] }}</div>
            </td>
            <td class="zp-cert-seal{{ empty($roundSeal) ? ' no-img' : '' }}" width="34%" align="center" valign="bottom">
                @if(!empty($roundSeal))
                    @if($forPdf)
                        <img src="{{ $roundSeal }}" alt="Official Seal" width="55" height="55" style="width:55pt;height:55pt;display:inline-block;">
                    @else
                        <img src="{{ $roundSeal }}" alt="Official Seal">
                    @endif
                @else
                    {{ $cs['seal_line1'] }}<br>{{ $cs['seal_line2'] }}<br>{{ date('Y') }}
                @endif
            </td>
            <td class="sign" width="33%" align="center" valign="bottom">
                @if(!empty($directorSig))
                    @if($forPdf)
                        <img src="{{ $directorSig }}" alt="Director Signature" width="100" height="45" style="width:100pt;height:45pt;display:block;margin:0 auto 2pt;">
                    @else
                        <img src="{{ $directorSig }}" alt="Director Signature">
                    @endif
                @else
                    <div class="sign-name">{{ $cs['platform_director_name'] }}</div>
                @endif
                <div class="sign-line"></div>
                <div class="sign-role">{{ $cs['platform_director_role'] }}</div>
            </td>
        </tr>
    </table>
</div>
