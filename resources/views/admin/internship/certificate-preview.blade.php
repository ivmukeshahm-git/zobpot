@extends('admin.layout.layout')
@section('content')
<script>
    page_active_id = "Internship-Internships";
</script>

<style>
    .cert-preview-toolbar {
        background: #fff;
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        justify-content: space-between;
    }
    .cert-preview-toolbar h5 {
        margin: 0;
        color: #242a62;
        font-weight: 700;
        font-size: 18px;
    }
    .cert-preview-toolbar .meta {
        color: #6c757d;
        font-size: 13px;
        margin: 4px 0 0;
    }
    .cert-preview-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .btn-cert-download {
        background: #28a745;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
    }
    .btn-cert-download:hover { background: #218838; color: #fff; }
    .btn-cert-print {
        background: #242a62;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
    }
    .btn-cert-print:hover { background: #1a1f47; color: #fff; }
    .btn-cert-back {
        background: #6c757d;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
    }
    .btn-cert-back:hover { background: #5a6268; color: #fff; }
</style>

<style id="certificate-print-styles">
    @include('admin.internship.partials.certificate-styles')
</style>

<style>
    @media print {
        @page {
            size: A4 landscape;
            margin: 0;
        }

        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            height: auto !important;
            background: #fff !important;
            overflow: visible !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Hide admin chrome; keep certificate ancestors visible for layout */
        .layout-menu,
        .layout-navbar,
        .content-footer,
        .content-backdrop,
        .layout-overlay,
        .drag-target,
        .template-customizer,
        .cert-preview-toolbar,
        .preloader,
        #Loader,
        aside,
        nav {
            display: none !important;
            visibility: hidden !important;
        }

        .layout-wrapper,
        .layout-container,
        .layout-page,
        .content-wrapper,
        .container-fluid,
        .cert-stage {
            display: block !important;
            position: static !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            max-width: none !important;
            min-width: 0 !important;
            height: auto !important;
            min-height: 0 !important;
            overflow: visible !important;
            background: #fff !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            transform: none !important;
            left: 0 !important;
            right: 0 !important;
            top: auto !important;
            bottom: auto !important;
            flex: none !important;
        }

        .layout-page {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
        }

        .cert-stage {
            display: flex !important;
            justify-content: center !important;
            align-items: flex-start !important;
        }

        #certificatePrintArea,
        .zp-certificate {
            position: relative !important;
            width: 297mm !important;
            height: 210mm !important;
            max-height: 210mm !important;
            margin: 0 auto !important;
            box-shadow: none !important;
            overflow: hidden !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>

<div class="container-fluid">
    <div class="cert-preview-toolbar">
        <div>
            <h5>
                <i class="bx bx-certification"></i>
                {{ $type === 'company' ? 'Company Certificate' : 'College Certificate' }} Preview
            </h5>
            <p class="meta">Certificate No: {{ $certificate_no }} &nbsp;|&nbsp; Student: {{ $student_name }}</p>
        </div>
        <div class="cert-preview-actions">
            <a href="{{ $back_url ?? url('admin/opportunity/view/' . $internship->id) . '#students' }}" class="btn btn-cert-back">
                <i class="bx bx-arrow-back"></i> Back
            </a>
            <button type="button" class="btn btn-cert-print" onclick="printCertificatePreview()">
                <i class="bx bx-printer"></i> Print
            </button>
            <a href="{{ $download_url }}" class="btn btn-cert-download">
                <i class="bx bx-download"></i> Download PDF
            </a>
        </div>
    </div>

    <div class="cert-stage">
        @include('admin.internship.partials.certificate-body', ['forPdf' => false])
    </div>
</div>

<script>
function printCertificatePreview() {
    var cert = document.getElementById('certificatePrintArea');
    if (!cert) {
        window.print();
        return;
    }

    var printWindow = window.open('', '_blank', 'width=1200,height=850');
    if (!printWindow) {
        window.print();
        return;
    }

    // Only certificate styles — admin layout CSS causes footer/seal spacing mismatch
    var certStyleEl = document.getElementById('certificate-print-styles');
    var styles = certStyleEl ? certStyleEl.outerHTML : '';

    printWindow.document.write(
        '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Certificate</title>' +
        styles +
        '<style>' +
        'html, body { margin: 0; padding: 0; background: #fff; }' +
        'body { display: flex; justify-content: center; align-items: flex-start; padding: 24px 12px; background: #e9ecef; }' +
        '.zp-certificate { box-shadow: none !important; margin: 0 !important; width: 297mm !important; height: 210mm !important; max-height: 210mm !important; overflow: hidden !important; }' +
        '.zp-cert-footer .zp-cert-seal { vertical-align: bottom; padding-bottom: 4mm; }' +
        '.zp-cert-footer .sign { vertical-align: bottom; }' +
        '@page { size: A4 landscape; margin: 0; }' +
        '@media print { html, body { margin: 0; padding: 0; background: #fff; width: 297mm; height: 210mm; } body { display: block; padding: 0; } .zp-certificate { page-break-inside: avoid; break-inside: avoid; } img { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; } }' +
        '</style></head><body>' +
        cert.outerHTML +
        '</body></html>'
    );
    printWindow.document.close();
    printWindow.focus();

    // Wait for images to load before printing
    var imgs = printWindow.document.images;
    var pending = imgs.length;
    var done = function () {
        setTimeout(function () {
            printWindow.print();
            printWindow.close();
        }, 250);
    };

    if (!pending) {
        done();
        return;
    }

    Array.from(imgs).forEach(function (img) {
        if (img.complete) {
            pending--;
            if (pending <= 0) done();
        } else {
            img.onload = img.onerror = function () {
                pending--;
                if (pending <= 0) done();
            };
        }
    });
}
</script>
@endsection
