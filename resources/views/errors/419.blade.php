@php
    try {
        $Setting = \App\Models\Setting::where('id', 1)->first();
    } catch (\Throwable $e) {
        $Setting = null;
    }
    $logo = ($Setting && !empty($Setting->header_logo))
        ? asset('uploads/logo_img/' . $Setting->header_logo)
        : asset('assets/imgs/logo/logo1.png');
    $loginUrl = route('admin.login');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Session Expired · Zobpot</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/fonts/boxicons.css') }}">
    <style>
        :root {
            --p: #2563EB;
            --s: #4F46E5;
            --bg: #F8FAFC;
            --text: #0F172A;
            --muted: #64748B;
            --border: #E5E7EB;
        }
        * { box-sizing: border-box; }
        html, body {
            margin: 0;
            min-height: 100%;
            font-family: Inter, system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow-x: hidden;
            background:
                radial-gradient(ellipse 50% 40% at 10% 20%, rgba(37, 99, 235, 0.12), transparent 55%),
                radial-gradient(ellipse 45% 35% at 90% 80%, rgba(79, 70, 229, 0.10), transparent 50%),
                var(--bg);
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: none; }
        }
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            pointer-events: none;
            z-index: 0;
        }
        .blob-1 {
            width: 280px; height: 280px;
            background: #93C5FD;
            top: -80px; left: -60px;
        }
        .blob-2 {
            width: 220px; height: 220px;
            background: #C4B5FD;
            bottom: -40px; right: -40px;
        }
        .card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--border);
            border-radius: 28px;
            box-shadow: 0 24px 64px rgba(15, 23, 42, 0.10), 0 4px 16px rgba(15, 23, 42, 0.05);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            padding: 44px 40px;
            text-align: center;
        }
        .logo {
            margin-bottom: 28px;
        }
        .logo img {
            height: 40px;
            width: auto;
            max-width: 160px;
            object-fit: contain;
        }
        .logo-fallback {
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: -0.04em;
            background: linear-gradient(135deg, var(--p), var(--s));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .icon-wrap {
            width: 88px;
            height: 88px;
            margin: 0 auto 24px;
            border-radius: 24px;
            display: grid;
            place-items: center;
            background: linear-gradient(145deg, #EFF6FF, #EEF2FF);
            border: 1px solid #DBEAFE;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.12);
        }
        .icon-wrap i {
            font-size: 40px;
            background: linear-gradient(135deg, var(--p), var(--s));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 999px;
            background: #FEF3C7;
            border: 1px solid #FDE68A;
            color: #92400E;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        h1 {
            margin: 0 0 10px;
            font-size: 1.65rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: var(--text);
        }
        p {
            margin: 0 0 28px;
            font-size: 0.95rem;
            line-height: 1.6;
            color: var(--muted);
        }
        .actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 52px;
            padding: 0 20px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--p), var(--s));
            color: #fff;
            font-family: inherit;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.3);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 32px rgba(37, 99, 235, 0.36);
            color: #fff;
        }
        .btn-primary:focus-visible {
            outline: 2px solid var(--p);
            outline-offset: 3px;
        }
        .btn-ghost {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 44px;
            border-radius: 12px;
            color: var(--muted);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.15s ease, background 0.15s ease;
        }
        .btn-ghost:hover {
            color: var(--p);
            background: #EFF6FF;
        }
        .tips {
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid var(--border);
            text-align: left;
        }
        .tips h2 {
            margin: 0 0 12px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #94A3B8;
        }
        .tips ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .tips li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13px;
            color: #475569;
            line-height: 1.45;
            margin-bottom: 10px;
        }
        .tips li:last-child { margin-bottom: 0; }
        .tips li i {
            color: var(--p);
            font-size: 16px;
            margin-top: 1px;
            flex-shrink: 0;
        }
        .footer {
            margin-top: 24px;
            font-size: 12px;
            color: #94A3B8;
        }
        @media (max-width: 520px) {
            .card { padding: 32px 22px; border-radius: 22px; }
            h1 { font-size: 1.4rem; }
        }
        @media (prefers-reduced-motion: reduce) {
            body { animation: none; }
            .btn-primary:hover { transform: none; }
        }
    </style>
</head>
<body>
    <span class="blob blob-1" aria-hidden="true"></span>
    <span class="blob blob-2" aria-hidden="true"></span>

    <main class="card" role="main">
        <div class="logo">
            <img src="{{ $logo }}" alt="Zobpot"
                 onerror="this.style.display='none'; this.nextElementSibling.hidden=false;">
            <span class="logo-fallback" hidden>zobpot</span>
        </div>

        <div class="icon-wrap" aria-hidden="true">
            <i class="bx bx-time-five"></i>
        </div>

        <div class="badge" role="status">
            <i class="bx bx-error-circle" aria-hidden="true"></i>
            Session expired · 419
        </div>

        <h1>Your session has expired</h1>
        <p>
            For your security, this page timed out or the login token is no longer valid.
            Please sign in again to continue to your dashboard.
        </p>

        <div class="actions">
            <a class="btn-primary" href="{{ $loginUrl }}">
                <i class="bx bx-log-in" aria-hidden="true"></i>
                Back to Sign In
            </a>
            <a class="btn-ghost" href="{{ url('/') }}">Go to Homepage</a>
        </div>

        <div class="tips">
            <h2>Quick tips</h2>
            <ul>
                <li><i class="bx bx-check-circle" aria-hidden="true"></i> Refresh and sign in if you left the tab open for a long time.</li>
                <li><i class="bx bx-check-circle" aria-hidden="true"></i> Use Sign In from one tab only to avoid session conflicts.</li>
                <li><i class="bx bx-check-circle" aria-hidden="true"></i> Clear cookies for this site if the issue keeps happening.</li>
            </ul>
        </div>

        <p class="footer">© {{ date('Y') }} Zobpot · Secure access</p>
    </main>

    <script>
        // Optional gentle redirect after idle on this page
        setTimeout(function () {
            // stay put — user clicks when ready
        }, 0);
    </script>
</body>
</html>
