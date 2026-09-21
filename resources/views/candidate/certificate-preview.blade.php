<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes">
    <title>{{ strtoupper($type) }} Certificate - {{ $student_name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f0f2f5;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top bar navigation */
        .preview-header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 20px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .preview-title-group h1 {
            font-size: 17px;
            font-weight: 700;
            color: #242a62;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .preview-title-group p {
            font-size: 12px;
            color: #64748b;
            margin-top: 2px;
        }
        .preview-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }
        .btn-download {
            background: #2563eb;
            color: #ffffff;
        }
        .btn-download:hover {
            background: #1d4ed8;
            color: #ffffff;
        }
        .btn-print {
            background: #f1f5f9;
            color: #334155;
            border-color: #cbd5e1;
        }
        .btn-print:hover {
            background: #e2e8f0;
        }

        /* Viewport Stage */
        .preview-container {
            flex: 1;
            padding: 24px 16px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            overflow-x: auto;
        }

        .cert-stage {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            width: 100%;
        }

        /* Certificate Print & Shared Styles */
        @include('admin.internship.partials.certificate-styles')

        @media print {
            .preview-header {
                display: none !important;
            }
            body, .preview-container, .cert-stage {
                background: #fff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .zp-certificate {
                box-shadow: none !important;
                width: 297mm !important;
                height: 210mm !important;
            }
        }
    </style>
</head>
<body>

    <header class="preview-header">
        <div class="preview-title-group">
            <h1>
                <i class="bx bxs-certification" style="color: #2563eb;"></i>
                {{ $type === 'company' ? 'Industry / Company Certificate' : 'College Certificate' }}
            </h1>
            <p>Certificate No: <strong>{{ $certificate_no }}</strong> &nbsp;|&nbsp; Student: <strong>{{ $student_name }}</strong></p>
        </div>
        <div class="preview-actions">
            <button type="button" class="btn-action btn-print" onclick="window.print()">
                <i class="bx bx-printer"></i> Print
            </button>
            <a href="{{ $download_url }}" class="btn-action btn-download">
                <i class="bx bx-download"></i> Download PDF
            </a>
        </div>
    </header>

    <main class="preview-container">
        <div class="cert-stage">
            @include('admin.internship.partials.certificate-body', ['forPdf' => false])
        </div>
    </main>

</body>
</html>
