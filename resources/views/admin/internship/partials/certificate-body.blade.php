@php
    /**
     * Single source of truth for certificate HTML (Admin Preview + PDF Download).
     * $forPdf = true → use base64 DomPDF image sources; otherwise public URLs.
     */
    $forPdf = !empty($forPdf);

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
    {{-- PDF: logos on one row, title full-width centered on page --}}
    <table class="zp-cert-top-logos" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td class="cert-logo-left" width="50%" align="left" valign="middle">
                @if($leftLogoUrl)
                    <img src="{{ $leftLogoUrl }}" alt="Issuer Logo" width="90" height="50">
                @else
                    <div class="logo-fallback">{{ \Illuminate\Support\Str::limit($leftLogoLabel, 20) }}</div>
                @endif
            </td>
            <td class="cert-logo-right" width="50%" align="right" valign="middle">
                @if($platformLogo)
                    <img src="{{ $platformLogo }}" alt="ZobPot" width="90" height="50">
                @else
                    <div class="logo-fallback">ZobPot</div>
                @endif
            </td>
        </tr>
    </table>
    <table class="zp-cert-header-row" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td class="zp-cert-header" align="center" valign="middle">
                <div class="brand">ZobPot Internship Portal</div>
                <h1>Certificate</h1>
                <p class="subtitle">Of Internship Completion</p>
                <span class="zp-cert-type-badge">
                    {{ $type === 'company' ? 'Company Certificate' : 'College Certificate' }}
                </span>
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
                <div class="brand">ZobPot Internship Portal</div>
                <h1>Certificate</h1>
                <p class="subtitle">Of Internship Completion</p>
                <span class="zp-cert-type-badge">
                    {{ $type === 'company' ? 'Company Certificate' : 'College Certificate' }}
                </span>
            </td>
            <td class="cert-logo-right" width="22%" align="right" valign="middle">
                @if($platformLogo)
                    <img src="{{ $platformLogo }}" alt="ZobPot">
                @else
                    <div class="logo-fallback">ZobPot</div>
                @endif
            </td>
        </tr>
    </table>
    @endif

    <div class="zp-cert-body">
        <p class="awarded">This is to certify that</p>
        <h2 class="student-name">{{ $student_name }}</h2>

        @if($type === 'college')
            <p class="line-text">
                a student of <strong>{{ $college_name }}</strong>
                @if(!empty($university_name) && $university_name !== 'N/A')
                    ({{ $university_name }})
                @endif
                @if(!empty($degree_name))
                    pursuing <strong>{{ $degree_name }}</strong>
                @endif
            </p>
        @endif

        <p class="line-text">has successfully completed the internship programme</p>
        <div class="internship-title">{{ $internship_title }}</div>

        @if($type === 'company')
            <p class="line-text">conducted by</p>
            <div class="org-name">{{ $company_name }}</div>
        @else
            <p class="line-text">in association with</p>
            <div class="org-name">{{ $company_name }}</div>
            <p class="line-text">and is hereby awarded this certificate by <strong>{{ $college_name }}</strong>.</p>
        @endif

        <p class="line-text cert-disclaimer" style="font-style: italic; color: #6c757d;">
            The intern has demonstrated dedication, professionalism and satisfactory performance
            throughout the internship duration.
        </p>

        <table class="zp-cert-meta" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td class="item">
                    <div class="label">Certificate No.</div>
                    <div class="value">{{ $certificate_no }}</div>
                </td>
                <td class="item-gap">&nbsp;</td>
                <td class="item">
                    <div class="label">Duration</div>
                    <div class="value">{{ $duration }}</div>
                </td>
                <td class="item-gap">&nbsp;</td>
                <td class="item">
                    <div class="label">Period</div>
                    <div class="value">{{ $start_date }} – {{ $end_date }}</div>
                </td>
                <td class="item-gap">&nbsp;</td>
                <td class="item">
                    <div class="label">Issue Date</div>
                    <div class="value">{{ $issue_date }}</div>
                </td>
                <td class="item-gap">&nbsp;</td>
                <td class="item">
                    <div class="label">Mode</div>
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
                    <img src="{{ $companySig }}" alt="Company Signature">
                @elseif($type === 'college' && !empty($collegeSig))
                    <img src="{{ $collegeSig }}" alt="College Signature">
                @else
                    <div class="sign-name">{{ $issuer_name }}</div>
                @endif
                <div class="sign-line"></div>
                <div class="sign-role">
                    {{ $type === 'company' ? 'Authorized Company Signatory' : 'College Authorized Signatory' }}
                </div>
            </td>
            <td class="zp-cert-seal{{ empty($roundSeal) ? ' no-img' : '' }}" width="34%" align="center" valign="bottom">
                @if(!empty($roundSeal))
                    <img src="{{ $roundSeal }}" alt="Official Seal">
                @else
                    OFFICIAL<br>SEAL<br>{{ date('Y') }}
                @endif
            </td>
            <td class="sign" width="33%" align="center" valign="bottom">
                @if(!empty($directorSig))
                    <img src="{{ $directorSig }}" alt="Director Signature">
                @else
                    <div class="sign-name">ZobPot</div>
                @endif
                <div class="sign-line"></div>
                <div class="sign-role">Platform Director</div>
            </td>
        </tr>
    </table>
</div>
