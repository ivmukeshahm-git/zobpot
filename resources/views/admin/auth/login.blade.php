@php
    $Setting = App\Models\Setting::where('id', 1)->first();
    $logo = ($Setting && !empty($Setting->header_logo))
        ? asset('uploads/logo_img/' . $Setting->header_logo)
        : asset('assets/imgs/logo/logo1.png');
    $favicon = ($Setting && !empty($Setting->favicon))
        ? asset('uploads/logo_img/' . $Setting->favicon)
        : asset('assets/imgs/logo/favicon1.png');
@endphp
<!DOCTYPE html>
<html lang="en" class="zp-login-html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign in · Zobpot</title>
    <meta name="description" content="Sign in to Zobpot — manage colleges, students, opportunities and academic records.">
    <link rel="icon" type="image/x-icon" href="{{ $favicon }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor/fonts/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/login-saas.css') }}">
</head>
<body class="zp-login-body">
    <div class="zp-login-page">
        {{-- LEFT: Hero illustration --}}
        <aside class="zp-login-hero" aria-hidden="false">
            <div class="zp-login-hero-mesh" aria-hidden="true"></div>
            <span class="zp-login-blob zp-login-blob-1" aria-hidden="true"></span>
            <span class="zp-login-blob zp-login-blob-2" aria-hidden="true"></span>
            <span class="zp-login-blob zp-login-blob-3" aria-hidden="true"></span>

            <div class="zp-login-hero-brand">
                <img src="{{ $logo }}" alt="Zobpot" onerror="this.style.display='none'; this.nextElementSibling.hidden=false;">
                <span class="zp-login-hero-brand-fallback" hidden>zobpot</span>
            </div>

            <div class="zp-login-hero-copy">
                <h1>Empowering Education Through Technology</h1>
                <p>Manage colleges, students, opportunities, staff and academic records from one intelligent platform.</p>
            </div>

            <div class="zp-login-stage">
                <div class="zp-login-illustration">
                    {{-- Scene: campus + students + analytics --}}
                    <svg class="zp-scene" viewBox="0 0 480 300" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Education platform illustration">
                        <defs>
                            <linearGradient id="gBuilding" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#DBEAFE"/>
                                <stop offset="100%" stop-color="#93C5FD"/>
                            </linearGradient>
                            <linearGradient id="gDash" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#FFFFFF"/>
                                <stop offset="100%" stop-color="#E0E7FF"/>
                            </linearGradient>
                            <filter id="softShadow" x="-20%" y="-20%" width="140%" height="140%">
                                <feDropShadow dx="0" dy="8" stdDeviation="10" flood-color="#0F172A" flood-opacity="0.25"/>
                            </filter>
                        </defs>

                        {{-- Ground glow --}}
                        <ellipse cx="240" cy="268" rx="180" ry="18" fill="#1E3A8A" opacity="0.35"/>

                        {{-- College building --}}
                        <g filter="url(#softShadow)">
                            <rect x="150" y="88" width="180" height="160" rx="12" fill="url(#gBuilding)"/>
                            <rect x="170" y="68" width="140" height="28" rx="6" fill="#BFDBFE"/>
                            <polygon points="240,28 130,78 350,78" fill="#60A5FA"/>
                            <rect x="228" y="36" width="24" height="18" rx="3" fill="#FBBF24"/>
                            {{-- Windows --}}
                            <rect x="170" y="110" width="28" height="28" rx="4" fill="#1E40AF" opacity="0.55"/>
                            <rect x="214" y="110" width="28" height="28" rx="4" fill="#1E40AF" opacity="0.4"/>
                            <rect x="258" y="110" width="28" height="28" rx="4" fill="#1E40AF" opacity="0.55"/>
                            <rect x="302" y="110" width="28" height="28" rx="4" fill="#1E40AF" opacity="0.4"/>
                            <rect x="170" y="152" width="28" height="28" rx="4" fill="#1E40AF" opacity="0.4"/>
                            <rect x="214" y="152" width="28" height="28" rx="4" fill="#1E40AF" opacity="0.55"/>
                            <rect x="258" y="152" width="28" height="28" rx="4" fill="#1E40AF" opacity="0.4"/>
                            <rect x="302" y="152" width="28" height="28" rx="4" fill="#1E40AF" opacity="0.55"/>
                            <rect x="220" y="200" width="40" height="48" rx="4" fill="#1E3A8A"/>
                        </g>

                        {{-- Graduation cap --}}
                        <g transform="translate(68,72)" filter="url(#softShadow)">
                            <polygon points="40,8 80,28 40,48 0,28" fill="#1E293B"/>
                            <rect x="34" y="28" width="12" height="22" fill="#334155"/>
                            <circle cx="72" cy="30" r="4" fill="#FBBF24"/>
                            <path d="M72 30 C78 38 78 48 72 52" stroke="#FBBF24" stroke-width="2" fill="none"/>
                        </g>

                        {{-- Books stack --}}
                        <g transform="translate(360,190)" filter="url(#softShadow)">
                            <rect x="0" y="28" width="72" height="14" rx="3" fill="#F97316" transform="rotate(-6 36 35)"/>
                            <rect x="4" y="16" width="72" height="14" rx="3" fill="#2563EB" transform="rotate(-3 40 23)"/>
                            <rect x="8" y="4" width="72" height="14" rx="3" fill="#4F46E5"/>
                        </g>

                        {{-- Laptop --}}
                        <g transform="translate(40,178)" filter="url(#softShadow)">
                            <rect x="10" y="8" width="90" height="58" rx="6" fill="#E2E8F0"/>
                            <rect x="16" y="14" width="78" height="42" rx="3" fill="#1E3A8A"/>
                            <path d="M0 68 H110 L100 78 H10 Z" fill="#CBD5E1"/>
                            <rect x="28" y="22" width="22" height="8" rx="2" fill="#38BDF8" opacity="0.9"/>
                            <rect x="54" y="22" width="28" height="8" rx="2" fill="#818CF8" opacity="0.85"/>
                            <rect x="28" y="36" width="40" height="6" rx="2" fill="#94A3B8" opacity="0.7"/>
                            <rect x="28" y="46" width="30" height="6" rx="2" fill="#94A3B8" opacity="0.5"/>
                        </g>

                        {{-- Analytics dashboard card --}}
                        <g transform="translate(318,56)" filter="url(#softShadow)">
                            <rect width="120" height="88" rx="12" fill="url(#gDash)"/>
                            <text x="14" y="22" fill="#334155" font-size="10" font-family="Inter,sans-serif" font-weight="600">Analytics</text>
                            <rect x="14" y="32" width="10" height="36" rx="2" fill="#2563EB"/>
                            <rect x="32" y="44" width="10" height="24" rx="2" fill="#60A5FA"/>
                            <rect x="50" y="28" width="10" height="40" rx="2" fill="#4F46E5"/>
                            <rect x="68" y="38" width="10" height="30" rx="2" fill="#818CF8"/>
                            <rect x="86" y="48" width="10" height="20" rx="2" fill="#38BDF8"/>
                            <path d="M14 78 H106" stroke="#E2E8F0" stroke-width="2"/>
                        </g>

                        {{-- Students (simple figures) --}}
                        <g transform="translate(196,210)" filter="url(#softShadow)">
                            <circle cx="18" cy="10" r="9" fill="#FDE68A"/>
                            <rect x="8" y="20" width="20" height="28" rx="6" fill="#2563EB"/>
                            <circle cx="52" cy="12" r="9" fill="#FECACA"/>
                            <rect x="42" y="22" width="20" height="28" rx="6" fill="#4F46E5"/>
                        </g>

                        {{-- Opportunity badge --}}
                        <g transform="translate(118,48)">
                            <rect width="86" height="28" rx="14" fill="rgba(255,255,255,0.2)" stroke="rgba(255,255,255,0.35)"/>
                            <circle cx="16" cy="14" r="6" fill="#4ADE80"/>
                            <text x="28" y="18" fill="#fff" font-size="10" font-family="Inter,sans-serif" font-weight="600">Opportunities</text>
                        </g>
                    </svg>

                    <div class="zp-glass-card zp-glass-card-1">
                        <div class="zp-glass-icon" aria-hidden="true"><i class="bx bx-group"></i></div>
                        <div class="zp-glass-meta">
                            <span>Active Students</span>
                            <strong>12.4k+</strong>
                        </div>
                    </div>
                    <div class="zp-glass-card zp-glass-card-2">
                        <div class="zp-glass-icon" aria-hidden="true"><i class="bx bx-file"></i></div>
                        <div class="zp-glass-meta">
                            <span>Candidate Applications</span>
                            <strong>3.2k</strong>
                        </div>
                    </div>
                    <div class="zp-glass-card zp-glass-card-3">
                        <div class="zp-glass-icon" aria-hidden="true"><i class="bx bx-trophy"></i></div>
                        <div class="zp-glass-meta">
                            <span>Placement Success</span>
                            <strong>94%</strong>
                        </div>
                    </div>
                    <div class="zp-glass-card zp-glass-card-4">
                        <div class="zp-glass-icon" aria-hidden="true"><i class="bx bxs-bar-chart-alt-2"></i></div>
                        <div class="zp-glass-meta">
                            <span>College Performance</span>
                            <strong>+18%</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="zp-login-trust">
                <div class="zp-login-trust-item"><i aria-hidden="true">✓</i> Secure Login</div>
                <div class="zp-login-trust-item"><i aria-hidden="true">✓</i> Fast Performance</div>
                <div class="zp-login-trust-item"><i aria-hidden="true">✓</i> Role Based Access</div>
            </div>
        </aside>

        {{-- RIGHT: Login card --}}
        <main class="zp-login-panel">
            <div class="zp-login-card">
                <div class="zp-login-card-logo">
                    <img src="{{ $logo }}" alt="Zobpot"
                         onerror="this.style.display='none'; this.nextElementSibling.hidden=false;">
                    <span class="zp-wordmark" hidden>zobpot</span>
                </div>

                <div class="zp-login-card-head">
                    <h1>Welcome Back 👋</h1>
                    <p>Sign in to continue to your dashboard.</p>
                </div>

                <div id="zpLoginAlert" class="zp-login-alert" role="alert" @if(!$errors->has('email')) hidden @endif>
                    <i class="bx bx-error-circle" style="font-size:18px;flex-shrink:0;" aria-hidden="true"></i>
                    <span id="zpLoginAlertText">{{ $errors->first('email') }}</span>
                </div>

                <form id="login-form" action="{{ route('post-login') }}" method="POST" novalidate>
                    @csrf
                    {{-- Auto-detected; first attempt uses Admin. JS may retry as College. --}}
                    <input type="hidden" id="login_type" name="login_type" value="Admin">

                    <div class="zp-field">
                        <label for="email">Email or Username</label>
                        <div class="zp-input-wrap">
                            <input
                                type="text"
                                class="zp-input"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Enter your email or username"
                                autocomplete="username"
                                autofocus
                                required
                                aria-required="true"
                                aria-describedby="email-error"
                            >
                        </div>
                        <div id="email-error" class="zp-field-error" role="alert"></div>
                    </div>

                    <div class="zp-field">
                        <label for="password">Password</label>
                        <div class="zp-input-wrap">
                            <input
                                type="password"
                                class="zp-input zp-input-password"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required
                                aria-required="true"
                                aria-describedby="password-error"
                            >
                            <button type="button" class="zp-toggle-password" id="togglePassword"
                                    aria-label="Show password" aria-controls="password">
                                <i class="bx bx-hide" id="togglePasswordIcon" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div id="password-error" class="zp-field-error" role="alert"></div>
                    </div>

                    <div class="zp-login-row">
                        <label class="zp-remember">
                            <input type="checkbox" id="remember-me" name="remember" value="1"
                                   @if(old('remember')) checked @endif>
                            Remember Me
                        </label>
                        <a class="zp-forgot" href="{{ route('forget-password') }}">Forgot Password</a>
                    </div>

                    <button type="submit" class="zp-btn-signin" id="btnSignIn">
                        <span class="zp-spinner" aria-hidden="true"></span>
                        <span class="zp-btn-label">Sign In</span>
                    </button>
                </form>

                <div class="zp-login-help">
                    Need Help?<br>
                    <a href="mailto:support@zobpot.com">Contact Administrator</a>
                </div>

                <p class="zp-login-footer-note">Your role is detected automatically after sign-in.</p>
            </div>
        </main>
    </div>

    <script>
    (function () {
        'use strict';

        var form = document.getElementById('login-form');
        var emailInput = document.getElementById('email');
        var passwordInput = document.getElementById('password');
        var loginTypeInput = document.getElementById('login_type');
        var btn = document.getElementById('btnSignIn');
        var alertBox = document.getElementById('zpLoginAlert');
        var alertText = document.getElementById('zpLoginAlertText');
        var emailError = document.getElementById('email-error');
        var passwordError = document.getElementById('password-error');
        var toggleBtn = document.getElementById('togglePassword');
        var toggleIcon = document.getElementById('togglePasswordIcon');
        var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var postUrl = form.getAttribute('action');

        function showAlert(message) {
            alertText.textContent = message || 'Invalid email/username or password.';
            alertBox.hidden = false;
        }

        function clearAlert() {
            alertBox.hidden = true;
            alertText.textContent = '';
        }

        function setFieldError(el, message) {
            if (!el) return;
            if (message) {
                el.textContent = message;
                el.classList.add('is-visible');
            } else {
                el.textContent = '';
                el.classList.remove('is-visible');
            }
        }

        function setLoading(isLoading) {
            btn.disabled = isLoading;
            btn.classList.toggle('is-loading', isLoading);
            btn.setAttribute('aria-busy', isLoading ? 'true' : 'false');
        }

        function validate() {
            var ok = true;
            setFieldError(emailError, '');
            setFieldError(passwordError, '');
            emailInput.classList.remove('is-invalid');
            passwordInput.classList.remove('is-invalid');

            if (!emailInput.value.trim()) {
                setFieldError(emailError, 'Please enter email or username.');
                emailInput.classList.add('is-invalid');
                ok = false;
            }
            if (!passwordInput.value) {
                setFieldError(passwordError, 'Please enter password.');
                passwordInput.classList.add('is-invalid');
                ok = false;
            }
            return ok;
        }

        toggleBtn.addEventListener('click', function () {
            var showing = passwordInput.type === 'text';
            passwordInput.type = showing ? 'password' : 'text';
            toggleIcon.className = showing ? 'bx bx-hide' : 'bx bx-show';
            toggleBtn.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
        });

        function isSuccessUrl(url) {
            if (!url) return false;
            try {
                var path = new URL(url, window.location.origin).pathname.toLowerCase();
                if (path.indexOf('/admin/login') !== -1) return false;
                if (path.indexOf('/login') !== -1 && path.indexOf('college') === -1) return false;
                return (
                    path.indexOf('/admin/dashboard') !== -1 ||
                    path.indexOf('/admin/college-dashboard') !== -1 ||
                    path.indexOf('/dashboard') !== -1 ||
                    path.indexOf('/home') !== -1 ||
                    path.indexOf('/otp') !== -1 ||
                    path.indexOf('/pricing') !== -1
                );
            } catch (e) {
                return false;
            }
        }

        function extractErrorFromHtml(html) {
            try {
                var parser = new DOMParser();
                var doc = parser.parseFromString(html, 'text/html');
                var alertEl = doc.querySelector('.alert-danger, #zpLoginAlertText, .invalid-feedback');
                if (alertEl && alertEl.textContent.trim()) {
                    return alertEl.textContent.trim();
                }
                var match = html.match(/Invalid[^<]{0,120}/i);
                if (match) return match[0].replace(/\s+/g, ' ').trim();
            } catch (e) {}
            return null;
        }

        function attemptLogin(loginType) {
            var body = new FormData(form);
            body.set('login_type', loginType);
            body.set('_token', csrf);

            return fetch(postUrl, {
                method: 'POST',
                body: body,
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html,application/xhtml+xml'
                },
                redirect: 'follow'
            }).then(function (res) {
                return res.text().then(function (html) {
                    return { res: res, html: html, url: res.url };
                });
            });
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            clearAlert();

            if (!validate()) {
                return;
            }

            setLoading(true);

            // Try Admin/Staff first, then College/College Staff — existing post-login endpoint
            attemptLogin('Admin')
                .then(function (result) {
                    if (isSuccessUrl(result.url)) {
                        window.location.href = result.url;
                        return null;
                    }
                    return attemptLogin('College').then(function (collegeResult) {
                        if (isSuccessUrl(collegeResult.url)) {
                            window.location.href = collegeResult.url;
                            return null;
                        }
                        var adminMsg = extractErrorFromHtml(result.html);
                        var collegeMsg = extractErrorFromHtml(collegeResult.html);
                        var msgs = [adminMsg, collegeMsg].filter(Boolean);
                        var deactivated = msgs.find(function (m) {
                            return /deactivated/i.test(m);
                        });
                        var credentialMsg = msgs.find(function (m) {
                            return /password|credentials/i.test(m);
                        });
                        showAlert(
                            deactivated ||
                            credentialMsg ||
                            'Invalid email/username or password.'
                        );
                        setLoading(false);
                        return null;
                    });
                })
                .catch(function () {
                    // Network / CORS fallback: classic form submit as Admin
                    loginTypeInput.value = 'Admin';
                    form.submit();
                });
        });
    })();
    </script>
</body>
</html>
