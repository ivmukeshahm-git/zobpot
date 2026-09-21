<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ strtoupper($type) }} Certificate - {{ $student_name }}</title>
    <style>
        /*
         * DomPDF does NOT support box-sizing — never combine width + padding on one element.
         * Page = 841.89pt x 595.28pt (A4 landscape). Content inset via margins on sections.
         */
        @page {
            size: A4 landscape;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 841.89pt;
            height: 595.28pt;
            overflow: hidden;
            background: #fff;
            font-family: DejaVu Serif, Georgia, Times New Roman, serif;
            color: #212529;
        }

        .zp-certificate {
            position: absolute;
            top: 0;
            left: 0;
            width: 841.89pt;
            height: 595.28pt;
            background: #fff;
            padding: 0;
            overflow: hidden;
        }

        /* Shared content strip — centered on page */
        .zp-cert-top-logos,
        .zp-cert-header-row,
        .zp-cert-top,
        .zp-cert-body,
        .zp-cert-footer {
            width: 751.89pt;
            margin-left: 45pt;
            margin-right: 45pt;
            position: relative;
            z-index: 3;
        }

        .zp-cert-top-logos {
            margin-top: 51pt;
            margin-bottom: 4pt;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .zp-cert-header-row {
            margin-bottom: 6pt;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .zp-cert-top {
            margin-top: 51pt;
            margin-bottom: 6pt;
        }

        .zp-cert-footer {
            margin-top: 10pt;
            margin-bottom: 40pt;
        }

        .zp-cert-top,
        .zp-cert-footer {
            border-collapse: collapse;
        }

        .zp-certificate table {
            width: 751.89pt;
            table-layout: fixed;
        }

        .zp-cert-top-logos .cert-logo-left,
        .zp-cert-top-logos .cert-logo-right {
            width: 375pt;
            height: 55pt;
            overflow: hidden;
            vertical-align: middle;
        }

        .zp-cert-top-logos .cert-logo-left {
            text-align: left;
        }

        .zp-cert-top-logos .cert-logo-right {
            text-align: right;
        }

        .zp-cert-top-logos .cert-logo-left img,
        .zp-cert-top-logos .cert-logo-right img {
            width: 90pt;
            height: auto;
        }

        .zp-cert-top-logos .logo-fallback {
            font-size: 9pt;
            font-weight: bold;
            color: #242a62;
            font-family: DejaVu Sans, Arial, sans-serif;
            line-height: 1.2;
        }

        .zp-cert-header-row .zp-cert-header,
        .zp-cert-header {
            text-align: center;
            width: 751.89pt;
            vertical-align: middle;
        }

        .zp-certificate .corner {
            position: absolute;
            width: 36pt;
            height: 36pt;
            z-index: 2;
        }
        .zp-certificate .corner.tl { top: 23pt; left: 23pt; border-top: 3pt solid #242a62; border-left: 3pt solid #242a62; }
        .zp-certificate .corner.tr { top: 23pt; right: 23pt; border-top: 3pt solid #f26e2c; border-right: 3pt solid #f26e2c; }
        .zp-certificate .corner.bl { bottom: 23pt; left: 23pt; border-bottom: 3pt solid #f26e2c; border-left: 3pt solid #f26e2c; }
        .zp-certificate .corner.br { bottom: 23pt; right: 23pt; border-bottom: 3pt solid #242a62; border-right: 3pt solid #242a62; }

        /* DomPDF needs explicit width/height on absolute elements —
           four-offset (top/right/bottom/left) boxes are not painted. */
        .zp-certificate .inner-border {
            position: absolute;
            top: 34pt;
            left: 34pt;
            width: 770.89pt;  /* 841.89 - 2*34 - 2*1.5 */
            height: 524.28pt; /* 595.28 - 2*34 - 2*1.5 */
            border: 1.5pt solid #242a62;
            z-index: 1;
        }

        .zp-certificate .accent-line {
            position: absolute;
            left: 368.45pt; /* page centre - half width */
            width: 105pt;
            height: 2pt;
            background-color: #242a62;
            z-index: 2;
        }
        .zp-certificate .accent-line.top { top: 40pt; }
        .zp-certificate .accent-line.bottom { top: 553.28pt; background-color: #f26e2c; }

        .zp-cert-top .cert-logo-left,
        .zp-cert-top .cert-logo-right {
            width: 140pt;
            height: 60pt;
            overflow: hidden;
            text-align: center;
            vertical-align: middle;
        }

        .zp-cert-top .cert-logo-left img,
        .zp-cert-top .cert-logo-right img {
            width: 90pt;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .zp-cert-top .logo-fallback {
            font-size: 9pt;
            font-weight: bold;
            color: #242a62;
            text-align: center;
            font-family: DejaVu Sans, Arial, sans-serif;
            line-height: 1.2;
        }

        .zp-cert-header .brand {
            font-size: 9pt;
            letter-spacing: 1pt;
            text-transform: uppercase;
            color: #f26e2c;
            font-weight: bold;
            font-family: DejaVu Sans, Arial, sans-serif;
            margin-bottom: 2pt;
            text-align: center;
        }

        .zp-cert-header h1 {
            margin: 0 auto;
            font-size: 28pt;
            letter-spacing: 2pt;
            color: #242a62;
            text-transform: uppercase;
            font-weight: bold;
            font-family: DejaVu Serif, Georgia, serif;
            line-height: 1.05;
            text-align: center;
        }

        .zp-cert-header .subtitle {
            margin: 3pt auto 0;
            font-size: 10pt;
            color: #495057;
            letter-spacing: 0.6pt;
            font-family: DejaVu Sans, Arial, sans-serif;
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
        }

        .zp-cert-type-badge {
            display: inline-block;
            margin: 5pt auto 0;
            background-color: {{ $type === 'company' ? '#242a62' : '#f26e2c' }};
            color: #fff;
            font-size: 8pt;
            font-family: DejaVu Sans, Arial, sans-serif;
            font-weight: bold;
            padding: 3pt 10pt;
            letter-spacing: 0.6pt;
            text-transform: uppercase;
            text-align: center;
        }

        .zp-cert-body {
            text-align: center;
            padding: 3pt 0 0;
        }

        .zp-cert-body .awarded {
            font-size: 11pt;
            color: #6c757d;
            font-style: italic;
            margin: 5pt 0 3pt;
        }

        .zp-cert-body .student-name {
            font-size: 24pt;
            color: #f26e2c;
            font-weight: bold;
            margin: 3pt 0;
            padding: 4pt 10pt;
            border-top: 2pt double #242a62;
            border-bottom: 2pt double #242a62;
            letter-spacing: 0.4pt;
            display: inline-block;
            min-width: 50%;
            font-family: DejaVu Serif, Georgia, serif;
            line-height: 1.15;
        }

        .zp-cert-body .line-text {
            font-size: 10pt;
            color: #495057;
            margin: 4pt 0;
            font-family: DejaVu Sans, Arial, sans-serif;
            line-height: 1.4;
        }

        .zp-cert-body .opportunity-title {
            font-size: 14pt;
            color: #242a62;
            font-weight: bold;
            margin: 3pt 0;
            font-family: DejaVu Sans, Arial, sans-serif;
        }

        .zp-cert-body .org-name {
            font-size: 12pt;
            color: #212529;
            font-weight: bold;
            margin: 2pt 0 5pt;
            font-family: DejaVu Sans, Arial, sans-serif;
        }

        .zp-cert-body .cert-disclaimer {
            font-size: 9pt;
            font-style: italic;
            color: #6c757d;
            margin: 3pt 0 0;
            font-family: DejaVu Sans, Arial, sans-serif;
        }

        .zp-cert-meta {
            width: 100%;
            max-width: 100%;
            margin: 8pt auto 0;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
            font-family: DejaVu Sans, Arial, sans-serif;
        }

        .zp-cert-meta .item {
            background-color: #f4f5fb;
            border: 1pt solid #e3e6f0;
            padding: 5pt 4pt;
            text-align: center;
            vertical-align: top;
            width: 18%;
        }

        .zp-cert-meta .item-gap {
            width: 2%;
            border: none;
            background: transparent;
            padding: 0;
            font-size: 1pt;
        }

        .zp-cert-meta .label {
            font-size: 7pt;
            text-transform: uppercase;
            letter-spacing: 0.3pt;
            color: #6c757d;
            font-weight: bold;
            margin-bottom: 1pt;
        }

        .zp-cert-meta .value {
            font-size: 9pt;
            color: #242a62;
            font-weight: bold;
            line-height: 1.2;
            word-wrap: break-word;
        }

        .zp-cert-footer {
            font-family: DejaVu Sans, Arial, sans-serif;
            table-layout: fixed;
        }

        .zp-cert-footer .sign {
            width: 250pt;
            text-align: center;
            vertical-align: bottom;
            padding: 0 5pt 5pt;
        }

        .zp-cert-footer .zp-cert-seal {
            width: 251.89pt;
            text-align: center;
            vertical-align: bottom;
            padding-bottom: 5pt;
            font-size: 7pt;
            font-weight: bold;
            color: #242a62;
            line-height: 1.2;
        }

        .zp-cert-footer .sign img {
            width: 100pt;
            height: auto;
            display: block;
            margin: 0 auto 2pt;
        }

        .zp-cert-footer .sign-line {
            width: 115pt;
            border-top: 1pt solid #242a62;
            margin: 0 auto 3pt;
        }

        .zp-cert-footer .sign-name {
            font-size: 10pt;
            font-weight: bold;
            color: #242a62;
            margin-bottom: 1pt;
        }

        .zp-cert-footer .sign-role {
            font-size: 8pt;
            color: #6c757d;
            font-style: italic;
        }

        .zp-cert-seal img {
            width: 60pt;
            height: auto;
            display: inline-block;
        }

        .zp-cert-seal.no-img {
            border: 2pt solid #f26e2c;
            width: 48pt;
            height: 48pt;
            margin: 0 auto;
            font-size: 6pt;
            padding-top: 10pt;
        }

        /* College: tighter layout */
        .zp-certificate.college-cert .zp-cert-body .line-text {
            margin: 2pt 0;
            line-height: 1.3;
            font-size: 9pt;
        }
        .zp-certificate.college-cert .zp-cert-body .awarded { margin: 3pt 0 2pt; }
        .zp-certificate.college-cert .zp-cert-body .student-name {
            margin: 2pt 0;
            padding: 3pt 8pt;
            font-size: 20pt;
        }
        .zp-certificate.college-cert .zp-cert-body .opportunity-title { margin: 2pt 0; font-size: 12pt; }
        .zp-certificate.college-cert .zp-cert-body .org-name { margin: 1pt 0 2pt; font-size: 10pt; }
        .zp-certificate.college-cert .zp-cert-meta { margin-top: 5pt; }
        .zp-certificate.college-cert .zp-cert-meta .item { padding: 3pt 3pt; }
        .zp-certificate.college-cert .zp-cert-footer { margin-top: 6pt; }
        .zp-certificate.college-cert .zp-cert-footer .sign { padding-bottom: 4pt; }
        .zp-certificate.college-cert .zp-cert-seal { padding-bottom: 4pt; }
        .zp-certificate.college-cert .zp-cert-seal img { max-width: 52pt; max-height: 52pt; }
        .zp-certificate.college-cert .zp-cert-footer .sign img { max-height: 34pt; }
        .zp-certificate.college-cert .zp-cert-header h1 { font-size: 24pt; }
    </style>
</head>
<body>
@include('admin.internship.partials.certificate-body', ['forPdf' => true])
</body>
</html>
