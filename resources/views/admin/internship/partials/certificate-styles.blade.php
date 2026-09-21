{{-- Shared certificate styles — Admin Preview (browser). Mirrors PDF visual design. --}}
    .cert-stage {
        background: #e9ecef;
        border-radius: 10px;
        padding: 24px 12px;
        overflow-x: auto;
        display: flex;
        justify-content: center;
    }

    .zp-certificate {
        width: 297mm;
        height: 210mm;
        max-height: 210mm;
        background: #fff;
        position: relative;
        box-sizing: border-box;
        padding: 18mm 16mm 16mm;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        overflow: hidden;
        font-family: Georgia, 'Times New Roman', serif;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .zp-certificate .corner {
        position: absolute;
        width: 48px;
        height: 48px;
        z-index: 2;
    }
    .zp-certificate .corner.tl { top: 8mm; left: 8mm; border-top: 4px solid #242a62; border-left: 4px solid #242a62; }
    .zp-certificate .corner.tr { top: 8mm; right: 8mm; border-top: 4px solid #f26e2c; border-right: 4px solid #f26e2c; }
    .zp-certificate .corner.bl { bottom: 8mm; left: 8mm; border-bottom: 4px solid #f26e2c; border-left: 4px solid #f26e2c; }
    .zp-certificate .corner.br { bottom: 8mm; right: 8mm; border-bottom: 4px solid #242a62; border-right: 4px solid #242a62; }

    .zp-certificate .inner-border {
        position: absolute;
        inset: 12mm;
        border: 1.5px solid #242a62;
        pointer-events: none;
        z-index: 1;
    }

    .zp-certificate .accent-line {
        position: absolute;
        left: 50%;
        margin-left: -70px;
        width: 140px;
        height: 3px;
        background: linear-gradient(90deg, #242a62, #f26e2c);
        z-index: 2;
    }
    .zp-certificate .accent-line.top { top: 14mm; }
    .zp-certificate .accent-line.bottom { bottom: 14mm; }

    .zp-cert-top {
        width: 100%;
        border-collapse: collapse;
        position: relative;
        z-index: 3;
        margin-bottom: 10px;
    }

    .zp-cert-top .cert-logo-left,
    .zp-cert-top .cert-logo-right {
        width: 22%;
        height: 90px;
        overflow: visible;
    }

    .zp-cert-top .cert-logo-left img,
    .zp-cert-top .cert-logo-right img {
        max-width: 140px;
        max-height: 90px;
        width: auto;
        height: auto;
        object-fit: contain;
        display: inline-block;
        vertical-align: middle;
    }

    .zp-cert-top .logo-fallback {
        font-size: 13px;
        font-weight: 700;
        color: #242a62;
        text-align: center;
        padding: 4px;
        font-family: Arial, sans-serif;
    }

    .zp-cert-header {
        text-align: center;
        position: relative;
        z-index: 3;
        padding-top: 4px;
    }

    .zp-cert-header .brand {
        font-size: 13px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #f26e2c;
        font-weight: 700;
        font-family: Arial, sans-serif;
        margin-bottom: 4px;
    }

    .zp-cert-header h1 {
        margin: 0;
        font-size: 36px;
        letter-spacing: 6px;
        color: #242a62;
        text-transform: uppercase;
        font-weight: 700;
        font-family: Georgia, 'Times New Roman', serif;
    }

    .zp-cert-header .subtitle {
        margin: 6px 0 0;
        font-size: 15px;
        color: #495057;
        letter-spacing: 1px;
        font-family: Arial, sans-serif;
        text-transform: uppercase;
        font-weight: 600;
    }

    .zp-cert-type-badge {
        display: inline-block;
        margin-top: 8px;
        background: {{ $type === 'company' ? '#242a62' : '#f26e2c' }};
        color: #fff;
        font-size: 11px;
        font-family: Arial, sans-serif;
        font-weight: 700;
        padding: 5px 14px;
        border-radius: 20px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .zp-cert-body {
        text-align: center;
        position: relative;
        z-index: 3;
        padding: 8px 24px 0;
    }

    .zp-cert-body .awarded {
        font-size: 15px;
        color: #6c757d;
        font-style: italic;
        margin: 10px 0 6px;
    }

    .zp-cert-body .student-name {
        font-size: 34px;
        color: #f26e2c;
        font-weight: 700;
        margin: 8px 0;
        padding: 8px 0;
        border-top: 3px double #242a62;
        border-bottom: 3px double #242a62;
        letter-spacing: 1px;
        display: inline-block;
        min-width: 55%;
        font-family: Georgia, 'Times New Roman', serif;
    }

    .zp-cert-body .line-text {
        font-size: 14px;
        color: #495057;
        margin: 8px 0;
        font-family: Arial, sans-serif;
        line-height: 1.55;
    }

    .zp-cert-body .opportunity-title {
        font-size: 20px;
        color: #242a62;
        font-weight: 700;
        margin: 8px 0;
    }

    .zp-cert-body .org-name {
        font-size: 16px;
        color: #212529;
        font-weight: 700;
        margin: 4px 0 10px;
    }

    .zp-cert-meta {
        width: 90%;
        margin: 14px auto 0;
        border-collapse: separate;
        border-spacing: 0;
        font-family: Arial, sans-serif;
        table-layout: fixed;
    }

    .zp-cert-meta .item {
        background: #f4f5fb;
        border: 1px solid #e3e6f0;
        border-radius: 8px;
        padding: 8px 10px;
        text-align: center;
        vertical-align: top;
        width: 18%;
    }

    .zp-cert-meta .item-gap {
        width: 2.5%;
        border: none;
        background: transparent;
        padding: 0;
    }

    .zp-cert-meta .label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #6c757d;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .zp-cert-meta .value {
        font-size: 13px;
        color: #242a62;
        font-weight: 700;
    }

    .zp-cert-footer {
        width: 100%;
        border-collapse: collapse;
        margin-top: 22px;
        position: relative;
        z-index: 3;
        font-family: Arial, sans-serif;
    }

    .zp-cert-footer .sign {
        text-align: center;
        vertical-align: bottom;
        padding: 0 20px 4mm;
    }

    .zp-cert-footer .sign img {
        max-width: 160px;
        max-height: 60px;
        display: block;
        margin: 0 auto 4px;
        object-fit: contain;
    }

    .zp-cert-footer .sign-line {
        width: 170px;
        height: 2px;
        background: #242a62;
        margin: 0 auto 6px;
    }

    .zp-cert-footer .sign-name {
        font-size: 13px;
        font-weight: 700;
        color: #242a62;
    }

    .zp-cert-footer .sign-role {
        font-size: 11px;
        color: #6c757d;
        font-style: italic;
    }

    .zp-cert-seal {
        text-align: center;
        vertical-align: bottom;
        padding-bottom: 4mm;
        font-size: 9px;
        font-weight: 700;
        color: #242a62;
        line-height: 1.25;
    }

    .zp-cert-seal img {
        max-width: 90px;
        max-height: 90px;
        border-radius: 50%;
        object-fit: contain;
        display: inline-block;
    }

    .zp-cert-seal.no-img {
        border: 3px solid #f26e2c;
        border-radius: 50%;
        background: #fff;
        width: 72px;
        height: 72px;
        display: inline-block;
        line-height: 1.2;
        padding-top: 14px;
        box-sizing: border-box;
    }

    .zp-certificate.college-cert .zp-cert-body .cert-disclaimer {
        font-size: 12px;
        margin: 3px 0 0;
        line-height: 1.35;
    }

    .zp-certificate.college-cert .zp-cert-body .line-text {
        margin: 4px 0;
        line-height: 1.4;
        font-size: 13px;
    }

    .zp-certificate.college-cert .zp-cert-body .awarded {
        margin: 5px 0 3px;
    }

    .zp-certificate.college-cert .zp-cert-body .student-name {
        margin: 5px 0;
        padding: 5px 0;
        font-size: 30px;
    }

    .zp-certificate.college-cert .zp-cert-body .opportunity-title {
        margin: 4px 0;
        font-size: 18px;
    }

    .zp-certificate.college-cert .zp-cert-body .org-name {
        margin: 2px 0 4px;
        font-size: 15px;
    }

    .zp-certificate.college-cert .zp-cert-meta {
        margin: 8px auto 0;
    }

    .zp-certificate.college-cert .zp-cert-meta .item {
        padding: 6px 8px;
    }

    .zp-certificate.college-cert .zp-cert-footer {
        margin-top: 14px;
    }

    .zp-certificate.college-cert .zp-cert-footer .sign {
        padding-bottom: 6mm;
    }

    .zp-certificate.college-cert .zp-cert-seal {
        padding-bottom: 6mm;
    }

    .zp-certificate.college-cert .zp-cert-seal img {
        max-width: 72px;
        max-height: 72px;
    }

    .zp-certificate.college-cert .zp-cert-footer .sign img {
        max-height: 48px;
    }
