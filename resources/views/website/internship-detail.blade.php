@extends('website.layout.layout')

@section('website-content')
    <style>
        /* =============================================
           ZOBPOT — INTERNSHIP DETAIL PAGE (Unstop-exact)
           ============================================= */

        #preloader-active { display: none; }

        :root {
            --zp-primary:    #242a64;
            --zp-primary-lt: #e8eaf6;
            --zp-success:    #1e8e3e;
            --zp-warning:    #f59e0b;
            --zp-danger:     #d93025;
            --zp-text:       #202124;
            --zp-muted:      #5f6368;
            --zp-border:     #e0e0e0;
            --zp-bg:         #f5f5f5;
            --zp-white:      #ffffff;
            --zp-radius:     12px;
            --zp-shadow:     0 1px 6px rgba(0,0,0,.08);
            --zp-shadow-lg:  0 4px 20px rgba(0,0,0,.12);
        }

        body { background: var(--zp-bg); }

        /* ===== PAGE ===== */
        .zp-detail-page { padding: 22px 0 60px; }

        /* ===== MAIN CARD ===== */
        .zp-main-card {
            /* background: var(--zp-white); */
            border-radius: var(--zp-radius);
            /* border: 1px solid var(--zp-border); */
            /* box-shadow: var(--zp-shadow); */
            margin-bottom: 16px;
            overflow: hidden;
        }
        .zp-main-card.zp-hero-card {
            border-top: 3px solid var(--zp-primary);
        }

        /* ===== COMPANY HEADER ===== */
        .zp-company-header {
            padding: 22px 24px 18px;
            border-bottom: 1px solid var(--zp-border);
        }
        .zp-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
        }
        .zp-header-left { flex: 1; min-width: 0; }
        .zp-header-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 14px;
            flex-shrink: 0;
            padding-top: 2px;
        }
        .zp-mode-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            color: var(--zp-muted);
            background: transparent;
            border: none;
            margin-bottom: 8px;
        }
        .zp-mode-badge i { font-size: 13px; }
        .zp-detail-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--zp-text);
            margin: 0 0 5px;
            line-height: 1.3;
        }
        .zp-detail-company {
            font-size: 14px;
            color: var(--zp-muted);
            margin: 0 0 14px;
        }
        .zp-header-tags {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }
        .zp-htag {
            display: inline-flex;
            align-items: center;
            font-size: 12px;
            color: #5f6368;
            background: #f1f3f4;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
            padding: 3px 11px;
            font-weight: 400;
        }
        .zp-htag-dot { color: #bdbdbd; font-size: 14px; line-height: 1; margin: 0 4px; }
        .zp-company-logo {
            width: 84px; height: 84px;
            border-radius: 10px;
            border: 1px solid var(--zp-border);
            background: #f8f8f8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 800;
            color: var(--zp-primary);
            overflow: hidden;
        }
        .zp-company-logo img { width: 100%; height: 100%; object-fit: contain; }
        .zp-icon-actions {
            display: flex;
            gap: 8px;
        }
        .zp-icon-btn {
            width: 34px; height: 34px;
            border-radius: 50%;
            border: 1.5px solid #dadce0;
            background: var(--zp-white);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            color: #5f6368;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
        }
        .zp-icon-btn:hover { border-color: var(--zp-primary); color: var(--zp-primary); background: #e8eaf6; }
        .zp-icon-btn.saved { color: #e53935; border-color: #e53935; }

        /* ===== SECTION ===== */
        .zp-section { padding: 22px 24px; border-bottom: 1px solid var(--zp-border); }
        .zp-section:last-child { border-bottom: none; }
        .zp-section-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--zp-text);
            margin-bottom: 14px;
            padding-left: 12px;
            border-left: 3px solid var(--zp-primary);
        }

        /* ===== ELIGIBILITY ===== */
        .zp-elig-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0;
        }
        .zp-elig-item {
            font-size: 13px;
            color: #242a64;
            font-weight: 400;
        }
        .zp-elig-dot {
            color: #bdbdbd;
            margin: 0 8px;
            font-size: 16px;
            line-height: 1;
        }

        /* ===== CONTENT ===== */
        .zp-content-block {
            font-size: 14px;
            line-height: 1.8;
            color: #3c4043;
        }
        .zp-content-block p { margin-bottom: 10px; }
        .zp-content-block ul { padding-left: 20px; margin-bottom: 10px; }
        .zp-content-block ul li { margin-bottom: 6px; }
        .zp-content-block h5,
        .zp-content-block h6 { font-weight: 700; color: var(--zp-text); margin: 14px 0 6px; }

        /* ===== DETAILS — COLLAPSIBLE ===== */
        .zp-details-collapsible {
            position: relative;
            overflow: hidden;
            max-height: 320px;
            transition: max-height .5s cubic-bezier(.4,0,.2,1);
        }
        .zp-details-collapsible.expanded { max-height: 9999px; }
        .zp-details-collapsible:not(.expanded)::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 90px;
            background: linear-gradient(to bottom, transparent, var(--zp-white));
            pointer-events: none;
        }
        /* Sub-section headings inside details */
        .zp-sub-section { margin-top: 22px; padding-top: 18px; border-top: 1px solid #f1f3f4; }
        .zp-sub-section:first-child { margin-top: 0; padding-top: 0; border-top: none; }
        .zp-sub-heading {
            font-size: 14.5px; font-weight: 700; color: var(--zp-text);
            margin: 0 0 12px; display: flex; align-items: center; gap: 8px;
        }
        .zp-sub-heading-icon {
            width: 30px; height: 30px; border-radius: 8px;
            background: var(--zp-primary-lt); color: var(--zp-primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; flex-shrink: 0;
        }
        /* Read More / Read Less toggle */
        .zp-read-toggle { text-align: center; padding-top: 14px; }
        .zp-read-btn {
            background: none; border: none;
            color: var(--zp-primary); font-size: 13px; font-weight: 700;
            cursor: pointer; display: inline-flex; align-items: center;
            gap: 5px; padding: 0; transition: opacity .15s;
        }
        .zp-read-btn:hover { opacity: .7; }
        .zp-read-btn i { font-size: 11px; }

        /* ===== WARNING ===== */
        .zp-warning {
            background: #fffde7;
            border: 1px solid #fff176;
            border-radius: 8px;
            padding: 12px 16px 12px 44px;
            position: relative;
            font-size: 13px;
            color: #5d4037;
            line-height: 1.6;
            margin-top: 16px;
        }
        .zp-warning i {
            position: absolute;
            left: 14px; top: 13px;
            font-size: 17px;
            color: #f9a825;
        }

        /* ===== INFO TILES ===== */
        .zp-info-tile-row {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .zp-info-tile {
            background: var(--zp-white);
            border: 1px solid var(--zp-border);
            border-radius: 10px;
            padding: 16px 18px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }
        .zp-tile-icon {
            width: 48px; height: 48px;
            border-radius: 10px;
            background: #e8eaf6;
            color: #242a64;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .zp-tile-body { flex: 1; }
        .zp-tile-label {
            font-size: 14px;
            font-weight: 700;
            color: var(--zp-text);
            margin-bottom: 4px;
            display: block;
        }
        .zp-tile-value {
            font-size: 13px;
            color: var(--zp-muted);
            line-height: 1.5;
        }
        .zp-tile-value ul {
            list-style: none;
            padding: 0; margin: 0;
        }
        .zp-tile-value ul li { margin-bottom: 2px; }

        /* ===== SKILLS ===== */
        .zp-skills-stack { display: flex; flex-wrap: wrap; gap: 8px; }
        .zp-skill-chip {
            background: #e8eaf6;
            color: var(--zp-primary);
            border: none;
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 500;
        }

        /* ===== EDITOR BOX ===== */
        .zp-editor-box {
            background: #f8f9fa;
            border: 1px solid var(--zp-border);
            border-radius: 10px;
            padding: 16px 18px;
            margin-bottom: 12px;
        }
        .zp-editor-box h5 {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--zp-muted);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .zp-editor-box h5 i { color: var(--zp-primary); }

        /* ===== SIDEBAR ===== */
        .zp-sidebar { position: sticky; top: 20px; }

        /* ===== APPLY CARD (screenshot match) ===== */
        .zp-apply-wrap { position: relative; margin-bottom: 16px; }

        /* "X Days Left" pill badge — floats above the card */
        .zp-days-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #1c1c1e;
            color: #fff;
            padding: 6px 14px 6px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .2px;
            margin-bottom: 8px;
        }
        .zp-days-pill.urgent { background: var(--zp-danger); }
        .zp-days-pill i { font-size: 11px; opacity: .8; }

        /* White card */
        .zp-apply-card {
            background: var(--zp-white);
            border: 1.5px solid #e0e0e0;
            border-radius: 18px;
            padding: 20px 18px 16px;
            box-shadow: 0 2px 14px rgba(0,0,0,.08);
        }

        /* User row */
        .zp-ac-user {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 18px;
            padding: 4px 0;
        }
        .zp-ac-avatar {
            width: 52px; height: 52px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            background: #e8eaf6;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: 800;
            color: var(--zp-primary);
            border: 3px solid #242a64;
            box-shadow: 0 0 0 3px #e8eaf6;
        }
        .zp-ac-avatar img { width:100%; height:100%; object-fit:cover; }
        .zp-ac-name {
            font-size: 14.5px; font-weight: 700;
            color: var(--zp-text); margin: 0 0 3px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .zp-ac-email {
            font-size: 12px; color: var(--zp-muted); margin: 0;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        /* Quick Apply pill button */
        .quick-apply-btn {
            width: 100%;
            background: var(--zp-primary);
            color: #fff;
            border: none;
            padding: 14px 24px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: background .2s, transform .1s;
            letter-spacing: .3px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .quick-apply-btn:hover:not(:disabled) { background: #1a1f4d; transform: translateY(-1px); }
        .quick-apply-btn:active:not(:disabled) { transform: translateY(0); }
        .quick-apply-btn:disabled { background: #bdbdbd; cursor: not-allowed; }
        .quick-apply-btn.applied {
            background: #e8f5e9; color: #2e7d32;
            border: 2px solid #a5d6a7;
            font-weight: 700;
        }
        .quick-apply-btn.company-block {
            background: #fff3e0; color: #e65100;
            border: 2px solid #ffcc80;
            font-weight: 700;
            cursor: not-allowed;
        }

        .zp-plan-limit-msg {
            margin: 10px 0 0;
            padding: 10px 12px;
            font-size: 13px;
            line-height: 1.45;
            color: #842029;
            background: #f8d7da;
            border: 1px solid #f5c2c7;
            border-radius: 8px;
            text-align: center;
        }

        .zp-plan-limit-msg .zp-plan-limit-usage {
            display: block;
            margin-top: 4px;
            font-size: 12px;
            font-weight: 600;
            color: #6c1b21;
        }

        /* Applied count row */
        .zp-applied-count {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 11px;
            font-size: 13px;
            color: var(--zp-muted);
        }
        .zp-applied-count i { font-size: 14px; }

        /* Eligible banner */
        .zp-eligible-bar {
            background: #f0fdf4;
            border: 1.5px solid #86efac;
            border-radius: 10px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #16a34a;
            margin-bottom: 16px;
            width: 100%;
        }
        .zp-eligible-bar .elig-icon { font-size: 17px; line-height: 1; }
        .zp-eligible-bar span.elig-text { flex: 1; }

        /* Sidebar cards */
        .zp-sb-card {
            background: var(--zp-white);
            border-radius: 12px;
            border: 1px solid var(--zp-border);
            padding: 18px;
            margin-bottom: 16px;
            box-shadow: var(--zp-shadow);
        }
        
        .zp-sb-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--zp-text);
            margin-bottom: 14px;
            display: block;
        }

        /* Refer & Win Banner */
        .zp-refer-banner {
            background: linear-gradient(120deg, #1a1f4d 0%, #242a64 55%, #3a4290 100%);
            border-radius: 14px;
            display: flex;
            align-items: stretch;
            margin-bottom: 16px;
            text-decoration: none;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(36,42,100,.28);
            transition: transform .2s, box-shadow .2s;
        }
        .zp-refer-banner:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(36,42,100,.35);
            opacity: 1;
        }
        .zp-refer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 14px 16px;
            gap: 10px;
        }
        .zp-refer-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .zp-refer-img {
            width: 50px; height: 50px;
            border-radius: 12px;
            background: rgba(255,255,255,.18);
            display: flex; align-items: center; justify-content: center;
            font-size: 28px;
            flex-shrink: 0;
            border: 1.5px solid rgba(255,255,255,.25);
        }
        .zp-refer-text { color: #fff; }
        .zp-refer-text h6 {
            font-size: 19px; font-weight: 900;
            margin: 0 0 1px; color: #fff; line-height: 1.15;
            letter-spacing: -.2px;
        }
        .zp-refer-text span { font-size: 11.5px; opacity: .88; color: #fff; letter-spacing: .1px; }
        .zp-refer-btn {
            background: #0d2137;
            color: #fff;
            border: none;
            padding: 9px 15px;
            border-radius: 22px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 6px;
            letter-spacing: .1px;
            box-shadow: 0 2px 8px rgba(0,0,0,.25);
        }

        /* Featured / Recent items */
        .zp-recent-item {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f1f3f4;
            text-decoration: none;
            color: inherit;
            transition: background .15s;
        }
        .zp-recent-item:last-child { border-bottom: none; }
        .zp-recent-item:hover .zp-recent-info h6 { color: var(--zp-primary); }
        .zp-recent-logo {
            width: 44px; height: 44px;
            border-radius: 8px;
            border: 1px solid var(--zp-border);
            background: #f8f8f8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            color: var(--zp-primary);
            flex-shrink: 0;
            overflow: hidden;
        }
        .zp-recent-logo img { width: 100%; height: 100%; object-fit: contain; }
        .zp-recent-info h6 { font-size: 13px; font-weight: 600; color: var(--zp-text); margin: 0 0 4px; line-height: 1.4; transition: color .15s; }
        .zp-recent-meta { font-size: 11px; color: var(--zp-muted); }

        /* ===== RELATED INTERNSHIPS ===== */
        .zp-rel-card {
            background: var(--zp-white);
            border: 1.5px solid var(--zp-border);
            border-radius: 14px;
            padding: 16px;
            text-decoration: none !important;
            color: inherit !important;
            display: block;
            transition: all .2s ease;
            height: 100%;
        }
        .zp-rel-card:hover {
            border-color: var(--zp-primary);
            box-shadow: 0 4px 18px rgba(36,42,100,.12);
            transform: translateY(-2px);
        }
        .zp-rel-card-head {
            display: flex; align-items: flex-start; gap: 10px; margin-bottom: 10px;
        }
        .zp-rel-logo {
            width: 44px; height: 44px; border-radius: 10px;
            border: 1px solid var(--zp-border); background: #f8f8f8;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 800; color: var(--zp-primary);
            flex-shrink: 0; overflow: hidden;
        }
        .zp-rel-logo img { width: 100%; height: 100%; object-fit: contain; }
        .zp-rel-title {
            font-size: 13.5px; font-weight: 700; color: var(--zp-text);
            line-height: 1.4; margin: 0 0 2px;
        }
        .zp-rel-company { font-size: 12px; color: var(--zp-muted); margin: 0; }
        .zp-rel-tags { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 8px; }
        .zp-rel-tag {
            background: #f1f3f4; color: #5f6368;
            border-radius: 6px; padding: 3px 9px;
            font-size: 11px; font-weight: 500;
        }
        .zp-rel-tag.green { background: #e8f5e9; color: #2e7d32; }

        /* ===== APPLY CARD REDESIGN ===== */
        .zp-apply-user-block {
            display: flex; align-items: center; gap: 12px;
            padding: 14px 0 14px;
            border-bottom: 1px solid #f1f3f4;
            margin-bottom: 14px;
        }
        .zp-apply-avatar {
            width: 48px; height: 48px; border-radius: 50%;
            overflow: hidden; flex-shrink: 0;
            background: var(--zp-primary-lt);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; font-weight: 800; color: var(--zp-primary);
            border: 2px solid var(--zp-primary-lt);
        }
        .zp-apply-avatar img { width:100%; height:100%; object-fit:cover; }
        .zp-apply-uname { font-size: 15px; font-weight: 700; color: var(--zp-text); margin: 0 0 2px; }
        .zp-apply-uemail { font-size: 12px; color: var(--zp-muted); margin: 0; }
        .zp-apply-card-title {
            font-size: 13px; font-weight: 700; color: var(--zp-text);
            margin: 0 0 12px; display: flex; align-items: center; gap: 6px;
        }
        .zp-apply-card-title i { color: var(--zp-primary); }
        .zp-stipend-row {
            display: flex; align-items: center; justify-content: center;
            gap: 6px; padding: 10px 0 0;
            font-size: 12.5px; color: var(--zp-muted);
        }
        .zp-stipend-row strong { color: var(--zp-success); font-size: 14px; }

        /* ===== AD SECTION ===== */
        .zp-ad-card {
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            border-radius: 14px;
            padding: 20px 18px;
            margin-top: 0;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .zp-ad-card::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 120px; height: 120px;
            border-radius: 50%;
            background: rgba(255,255,255,.06);
        }
        .zp-ad-card::after {
            content: '';
            position: absolute;
            bottom: -20px; left: -20px;
            width: 80px; height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
        }
        .zp-ad-badge {
            display: inline-block;
            background: rgba(255,255,255,.18);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .zp-ad-title {
            font-size: 16px; font-weight: 800;
            color: #fff; margin: 0 0 6px; line-height: 1.35;
        }
        .zp-ad-sub {
            font-size: 12px; opacity: .8; margin: 0 0 14px; line-height: 1.5;
        }
        .zp-ad-cta {
            display: inline-flex; align-items: center; gap: 6px;
            background: #fff; color: #0f2027;
            padding: 9px 18px; border-radius: 8px;
            font-size: 13px; font-weight: 700;
            text-decoration: none !important;
            transition: opacity .2s;
        }
        .zp-ad-cta:hover { opacity: .88; color: #0f2027; }
        .zp-ad-img {
            text-align: center; font-size: 36px;
            margin-bottom: 10px; position: relative; z-index: 1;
        }

        /* ===== PILL ===== */
        .zp-pill {
            display: inline-flex;
            align-items: center;
            background: #f1f3f4;
            color: var(--zp-muted);
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
            margin-right: 4px;
        }

        /* ===== BENEFITS CARD ===== */
        .zp-benefits-card {
            border-radius: 16px;
            overflow: hidden;
            border: 1.5px solid #e0e0e0;
            box-shadow: 0 2px 14px rgba(0,0,0,.07);
            background: var(--zp-white);
            margin-bottom: 16px;
        }
        .zp-benefits-header {
            background: linear-gradient(135deg, #242a64 0%, #3a4290 60%, #4e5aa8 100%);
            padding: 20px 20px 18px;
            position: relative;
            overflow: hidden;
        }
        .zp-benefits-header::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 100px; height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,.06);
        }
        .zp-benefits-header::after {
            content: '';
            position: absolute;
            bottom: -20px; left: 20px;
            width: 70px; height: 70px;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
        }
        .zp-benefits-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(255,255,255,.18);
            color: #fff;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 50px;
            margin-bottom: 8px;
        }
        .zp-benefits-title {
            font-size: 15px;
            font-weight: 800;
            color: #fff;
            margin: 0 0 4px;
            line-height: 1.3;
        }
        .zp-benefits-sub {
            font-size: 11.5px;
            color: rgba(255,255,255,.75);
            margin: 0;
        }
        .zp-benefits-list {
            padding: 6px 0 8px;
        }
        .zp-benefit-item {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 11px 18px;
            border-bottom: 1px solid #f3f4f6;
            transition: background .15s;
        }
        .zp-benefit-item:hover { background: #fafafa; }
        .zp-benefit-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }
        .zp-benefit-body {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .zp-benefit-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--zp-text);
            line-height: 1.3;
        }
        .zp-benefit-desc {
            font-size: 11.5px;
            color: var(--zp-muted);
            line-height: 1.4;
        }

        /* ===== MODAL overrides ===== */
        .form-control:focus, .form-select:focus {
            border-color: #242a64 !important;
            box-shadow: 0 0 0 .2rem rgba(36,42,100,.15) !important;
            outline: none;
        }
        .modal.fade .modal-dialog { transform: scale(.95); opacity: 0; transition: all .25s ease; }
        .modal.show .modal-dialog { transform: scale(1); opacity: 1; }
        .billing-summary { animation: slideInDown .35s ease; }
        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) { .zp-sidebar { position: relative; top: 0; } }
        @media (max-width: 767px) {
            .zp-header-top { flex-direction: column-reverse; }
            .zp-header-right { flex-direction: row; align-items: center; justify-content: space-between; width: 100%; }
            .zp-detail-title { font-size: 20px; }
            .zp-section { padding: 18px 16px; }
            .zp-company-header { padding: 16px; }
        }
    </style>

    <main class="main">
        {{-- =========== CONTENT =========== --}}
        <section class="zp-detail-page">
            <div class="container">
                <div class="row g-3">

                    {{-- ===== LEFT COLUMN ===== --}}
                    <div class="col-lg-8">

                        {{-- ---- Company Header Card ---- --}}
                        <div class="zp-main-card zp-hero-card">
                            <div class="zp-company-header">
                                <div class="zp-header-top">
                                    <div class="zp-header-left">
                                        @php
                                            $modeIcon = match(strtolower($internship->mode ?? '')) {
                                                'online'  => 'fa-home',
                                                'hybrid'  => 'fa-exchange',
                                                default   => 'fa-building',
                                            };
                                        @endphp
                                        <div class="zp-mode-badge">
                                            <i class="fa {{ $modeIcon }}"></i>
                                            {{ $internship->mode }}
                                        </div>
                                        <h1 class="zp-detail-title">{{ $internship->internship_title }}</h1>
                                        <p class="zp-detail-company">{{ $internship->company ? $internship->company->name : 'N/A' }}</p>
                                        <div class="zp-header-tags">
                                            @if($internship->jobCategory)
                                                <span class="zp-htag">{{ $internship->jobCategory->category_nm }}</span>
                                            @endif
                                            @if($internship->location)
                                                <span class="zp-htag-dot">&bull;</span>
                                                <span class="zp-htag">{{ $internship->location }}</span>
                                            @endif
                                            @if($internship->stipend > 0)
                                                <span class="zp-htag-dot">&bull;</span>
                                                <span class="zp-htag" style="color:#2e7d32;">Stipend ₹{{ number_format($internship->stipend) }}/Month</span>
                                            @endif
                                            @if((float) ($internship->registration_fees ?? 0) > 0)
                                                <span class="zp-htag-dot">&bull;</span>
                                                <span class="zp-htag" style="color:#1d4ed8;">Course Fee ₹{{ number_format((float) $internship->registration_fees) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="zp-header-right">
                                        <div class="zp-icon-actions">
                                            <button class="zp-icon-btn {{ $inWishlist ? 'saved' : '' }}"
                                                    id="wishlistBtn"
                                                    onclick="toggleWishlist({{ $internship->id }})"
                                                    title="{{ $inWishlist ? 'Remove from Wishlist' : 'Save' }}">
                                                <i class="fa {{ $inWishlist ? 'fa-heart' : 'fa-heart-o' }}"></i>
                                            </button>
                                            <button class="zp-icon-btn"
                                                    onclick="shareInternship('{{ $internship->slug }}')"
                                                    title="Share">
                                                <i class="fa fa-share-alt"></i>
                                            </button>
                                        </div>
                                        <div class="zp-company-logo">
                                            @if($internship->company && !empty($internship->company->profile_img) && file_exists(public_path('uploads/profile/' . $internship->company->profile_img)))
                                                <img src="{{ asset('uploads/profile/' . $internship->company->profile_img) }}"
                                                     alt="{{ $internship->company->name }}"
                                                     style="width:100%;height:100%;object-fit:cover;"
                                                     onerror="this.style.display='none'; this.parentElement.textContent='{{ strtoupper(substr($internship->company->name ?? 'IN', 0, 2)) }}'">
                                            @else
                                                {{ strtoupper(substr($internship->company->name ?? 'IN', 0, 2)) }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ---- Eligibility ---- --}}
                            @if($internship->eligibility_criteria)
                            <div class="zp-section">
                                <h3 class="zp-section-title">Eligibility</h3>
                                <div class="zp-elig-row">
                                    @php
                                        $criteria = [];
                                        if (!empty($internship->eligibility_criteria)) {
                                            $decodedCriteria = json_decode($internship->eligibility_criteria, true);
                                            if (is_array($decodedCriteria)) {
                                                $criteria = array_values(array_filter(array_map('trim', $decodedCriteria)));
                                            } else {
                                                $criteria = array_values(array_filter(array_map('trim', explode(',', $internship->eligibility_criteria))));
                                            }
                                        }
                                    @endphp
                                    @foreach($criteria as $ci => $criterion)
                                        @if($ci > 0)<span class="zp-elig-dot">&bull;</span>@endif
                                        <span class="zp-elig-item">{{ $criterion }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            {{-- ---- Combined Details Section (collapsible) ---- --}}
                            <div class="zp-section">
                                <h3 class="zp-section-title">Details</h3>

                                <div class="zp-details-collapsible" id="detailsCollapsible">

                                    {{-- Overview / Description --}}
                                    @if($internship->internship_description)
                                    <div class="zp-sub-section">
                                        <div class="zp-content-block">
                                            {!! $internship->internship_description !!}
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Program Details --}}
                                    @if($internship->module_brief_description)
                                    <div class="zp-sub-section">
                                        <h4 class="zp-sub-heading">
                                            <span class="zp-sub-heading-icon"><i class="fa fa-book"></i></span>
                                            Program Details
                                        </h4>
                                        <div class="zp-content-block">
                                            {!! $internship->module_brief_description !!}
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Learning Objectives --}}
                                    @if($internship->internship_objective)
                                    <div class="zp-sub-section">
                                        <h4 class="zp-sub-heading">
                                            <span class="zp-sub-heading-icon"><i class="fa fa-bullseye"></i></span>
                                            Learning Objectives
                                        </h4>
                                        <div class="zp-content-block">
                                            {!! $internship->internship_objective !!}
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Expected Outcomes --}}
                                    @if($internship->internship_outcome)
                                    <div class="zp-sub-section">
                                        <h4 class="zp-sub-heading">
                                            <span class="zp-sub-heading-icon"><i class="fa fa-trophy"></i></span>
                                            Expected Outcomes
                                        </h4>
                                        <div class="zp-content-block">
                                            {!! $internship->internship_outcome !!}
                                        </div>
                                    </div>
                                    @endif

                                </div>{{-- /zp-details-collapsible --}}

                                {{-- Read More / Read Less toggle --}}
                                <div class="zp-read-toggle">
                                    <button class="zp-read-btn" id="detailsReadBtn" onclick="toggleDetails()">
                                        Read More <i class="fa fa-chevron-down"></i>
                                    </button>
                                </div>
                            </div>

                             

                            {{-- ---- Warning ---- --}}
                            <div class="zp-section" style="padding-top:0; border-bottom:none;">
                                <div class="zp-warning">
                                    <i class="fa fa-lightbulb-o"></i>
                                    If an employer asks you to pay any kind of fee, please notify us immediately. Zobpot does not charge any fee from the applicants and we do not allow other companies also to do so.
                                </div>
                            </div>
                        </div>

                        {{-- ---- Additional Information ---- --}}
                        <div class="zp-main-card">
                            <div class="zp-section">
                                <h3 class="zp-section-title">Additional Information</h3>
                                <div class="zp-info-tile-row">

                                    <div class="zp-info-tile">
                                        <div class="zp-tile-icon"><i class="fa fa-calendar"></i></div>
                                        <div class="zp-tile-body">
                                            <span class="zp-tile-label">Program Duration</span>
                                            <div class="zp-tile-value">{{ $internship->duration }}</div>
                                        </div>
                                    </div>

                                    <div class="zp-info-tile">
                                        <div class="zp-tile-icon" style="background:#fff3e0;color:#e65100;"><i class="fa fa-money"></i></div>
                                        <div class="zp-tile-body">
                                            <span class="zp-tile-label">Stipend</span>
                                            <div class="zp-tile-value">
                                                @if($internship->stipend > 0)
                                                    &#8377;{{ number_format($internship->stipend) }}/Month
                                                @else
                                                    Unpaid
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="zp-info-tile">
                                        <div class="zp-tile-icon" style="background:#e3f2fd;color:#1565c0;"><i class="fa fa-credit-card"></i></div>
                                        <div class="zp-tile-body">
                                            <span class="zp-tile-label">Course Fee</span>
                                            <div class="zp-tile-value">
                                                @if((float) ($internship->registration_fees ?? 0) > 0)
                                                    &#8377;{{ number_format((float) $internship->registration_fees) }}
                                                @else
                                                    Free
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="zp-info-tile">
                                        <div class="zp-tile-icon" style="background:#e8f5e9;color:#2e7d32;"><i class="fa fa-list-alt"></i></div>
                                        <div class="zp-tile-body">
                                            <span class="zp-tile-label">Work Detail</span>
                                            <div class="zp-tile-value">
                                                Working Days: {{ count($batchDays) }} Days
                                                @if($internship->total_hours)
                                                    &nbsp;&bull;&nbsp; {{ $internship->total_hours }} Hrs/week
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="zp-info-tile">
                                        <div class="zp-tile-icon" style="background:#e3f2fd;color:#0277bd;"><i class="fa fa-clock-o"></i></div>
                                        <div class="zp-tile-body">
                                            <span class="zp-tile-label">Program Mode</span>
                                            <div class="zp-tile-value">
                                                Program Mode: {{ $internship->mode }}<br>
                                                @if(!empty($batchDays) && is_array($batchDays))
                                                    @php $bt = collect($batchDays)->pluck('day')->filter()->join(', '); @endphp
                                                    @if($bt)Batch Days: {{ $bt }}@endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if($internship->application_deadline)
                                    <div class="zp-info-tile">
                                        <div class="zp-tile-icon" style="background:#fce4ec;color:#c62828;"><i class="fa fa-flag"></i></div>
                                        <div class="zp-tile-body">
                                            <span class="zp-tile-label">Application Deadline</span>
                                            <div class="zp-tile-value">
                                                {{ \Carbon\Carbon::parse($internship->application_deadline)->format('d M Y') }}
                                                @if($daysLeft !== null && $daysLeft > 0)
                                                    &nbsp;<span class="zp-pill" style="background:#e8f5e9;color:#2e7d32;">{{ $daysLeft }}d left</span>
                                                @elseif($daysLeft !== null && $daysLeft <= 0)
                                                    &nbsp;<span class="zp-pill" style="background:#fce4ec;color:#c62828;">Closed</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($internship->openings)
                                    <div class="zp-info-tile">
                                        <div class="zp-tile-icon" style="background:#ede7f6;color:#6a1b9a;"><i class="fa fa-users"></i></div>
                                        <div class="zp-tile-body">
                                            <span class="zp-tile-label">Openings</span>
                                            <div class="zp-tile-value">{{ $internship->openings }} Position{{ $internship->openings > 1 ? 's' : '' }}</div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($internship->skills)
                                    @php
                                        $skillsList = [];
                                        if (!empty($internship->skills)) {
                                            $decodedSkills = json_decode($internship->skills, true);
                                            if (is_array($decodedSkills)) {
                                                $skillsList = array_values(array_filter(array_map('trim', $decodedSkills)));
                                            } else {
                                                $skillsList = array_values(array_filter(array_map('trim', explode(',', $internship->skills))));
                                            }
                                        }
                                    @endphp
                                    <div class="zp-info-tile">
                                        <div class="zp-tile-icon" style="background:#e8eaf6;color:#283593;"><i class="fa fa-lightbulb-o"></i></div>
                                        <div class="zp-tile-body">
                                            <span class="zp-tile-label">Skills Required</span>
                                            <div class="zp-tile-value">
                                                <div class="zp-skills-stack" style="margin-top:6px;">
                                                    @foreach($skillsList as $skill)
                                                        <span class="zp-skill-chip">{{ $skill }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if($internship->perks && is_array($internship->perks) && count($internship->perks) > 0)
                                    <div class="zp-info-tile">
                                        <div class="zp-tile-icon" style="background:#fce4ec;color:#880e4f;"><i class="fa fa-gift"></i></div>
                                        <div class="zp-tile-body">
                                            <span class="zp-tile-label">Perks</span>
                                            <div class="zp-tile-value">
                                                <ul>
                                                    @foreach($internship->perks as $perk)
                                                        <li>{{ $perk }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                     
                        {{-- ---- Related Internship ---- --}}
                        @if($recentInternships && $recentInternships->count() > 0)
                        <div class="zp-main-card">
                            <div class="zp-section">
                                <h3 class="zp-section-title">Related Internship</h3>
                                <div class="row g-3">
                                    @foreach($recentInternships as $recent)
                                    @php
                                        $rCompany  = $recent->company ? $recent->company->name : 'Company';
                                        $rInitials = strtoupper(substr($rCompany, 0, 2));
                                        $rDays     = null;
                                        if ($recent->application_deadline) {
                                            $rDays = (int)\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($recent->application_deadline), false);
                                        }
                                    @endphp
                                    <div class="col-md-6">
                                        <a href="{{ route('internship.detail', $recent->slug ?? $recent->id) }}" class="zp-rel-card">
                                            <div class="zp-rel-card-head">
                                                <div class="zp-rel-logo">
                                                    @if($recent->company && !empty($recent->company->profile_img) && file_exists(public_path('uploads/profile/' . $recent->company->profile_img)))
                                                        <img src="{{ asset('uploads/profile/' . $recent->company->profile_img) }}"
                                                             alt="{{ $rCompany }}"
                                                             style="width:100%;height:100%;object-fit:cover;border-radius:6px;"
                                                             onerror="this.style.display='none';this.parentElement.textContent='{{ $rInitials }}'">
                                                    @else
                                                        {{ $rInitials }}
                                                    @endif
                                                </div>
                                                <div style="flex:1;min-width:0;">
                                                    <p class="zp-rel-title">{{ \Illuminate\Support\Str::limit($recent->internship_title, 38) }}</p>
                                                    <p class="zp-rel-company">{{ $rCompany }}</p>
                                                </div>
                                            </div>
                                            <div class="zp-rel-tags">
                                                <span class="zp-rel-tag"><i class="fa fa-briefcase" style="margin-right:4px;"></i>{{ $recent->mode }}</span>
                                                @if($recent->duration)
                                                    <span class="zp-rel-tag"><i class="fa fa-clock-o" style="margin-right:4px;"></i>{{ $recent->duration }}</span>
                                                @endif
                                                @if($recent->stipend > 0)
                                                    <span class="zp-rel-tag green"><i class="fa fa-rupee" style="margin-right:3px;"></i>{{ number_format($recent->stipend) }}/mo</span>
                                                @else
                                                    <span class="zp-rel-tag">Unpaid</span>
                                                @endif
                                                @if((float) ($recent->registration_fees ?? 0) > 0)
                                                    <span class="zp-rel-tag" style="background:#eff6ff;color:#1d4ed8;"><i class="fa fa-credit-card" style="margin-right:4px;"></i>Fee ₹{{ number_format((float) $recent->registration_fees) }}</span>
                                                @endif
                                                @if($rDays !== null)
                                                    @if($rDays > 0)
                                                        <span class="zp-rel-tag" style="background:#fff3e0;color:#e65100;"><i class="fa fa-flag" style="margin-right:4px;"></i>{{ $rDays }}d left</span>
                                                    @else
                                                        <span class="zp-rel-tag" style="background:#fce4ec;color:#c62828;">Closed</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>

                    {{-- ===== RIGHT SIDEBAR ===== --}}
                    <div class="col-lg-4">
                        <div class="zp-sidebar">

                            {{-- ===== APPLY CARD (screenshot design) ===== --}}
                            <div class="zp-apply-wrap">

                                {{-- "X Days Left" pill badge above card --}}
                                @if($daysLeft !== null)
                                    @if($daysLeft > 0)
                                        <div>
                                            <span class="zp-days-pill {{ $daysLeft <= 3 ? 'urgent' : '' }}">
                                                <i class="fa fa-clock-o"></i>
                                                {{ $daysLeft }} Day{{ $daysLeft != 1 ? 's' : '' }} Left
                                            </span>
                                        </div>
                                    @else
                                        <div>
                                            <span class="zp-days-pill urgent">
                                                <i class="fa fa-times-circle"></i> Closed
                                            </span>
                                        </div>
                                    @endif
                                @endif

                                <div class="zp-apply-card">

                                    {{-- ── Eligible bar (candidate only) ── --}}
                                    @auth
                                        @if(Auth::user()->profile_type != 'Company')
                                            <div class="zp-eligible-bar">
                                                <span class="elig-icon">✨</span>
                                                <span class="elig-text">You're eligible</span>
                                                <i class="fa fa-check-circle" style="color:#22c55e;font-size:15px;"></i>
                                            </div>
                                        @endif
                                    @endauth
                                            
                                    {{-- ── User row ── --}}
                                    <div class="zp-ac-user">
                                        <div class="zp-ac-avatar">
                                            @auth
                                                @if(Auth::user()->profile_image)
                                                    <img src="{{ asset('uploads/profile/' . Auth::user()->profile_image) }}" alt="">
                                                @else
                                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                                @endif
                                            @else
                                                <i class="fa fa-user"></i>
                                            @endauth
                                        </div>
                                        <div style="flex:1;min-width:0;">
                                            @auth
                                                <p class="zp-ac-name">{{ Auth::user()->name }}</p>
                                                <p class="zp-ac-email">{{ Auth::user()->email }}</p>
                                            @else
                                                <p class="zp-ac-name">Welcome!</p>
                                                <p class="zp-ac-email">Login to apply now</p>
                                            @endauth
                                        </div>
                                    </div>

                                    {{-- ── Apply Button (logic) ── --}}
                                    @auth
                                        @if(Auth::user()->profile_type == 'Company')
                                            {{-- Company account: cannot apply --}}
                                            <button class="quick-apply-btn company-block" disabled
                                                    title="Company accounts cannot apply to Internships">
                                                <i class="fa fa-building"></i> Companies Can't Apply
                                            </button>
                                        @elseif(!empty($alreadyApplied) && $alreadyApplied)
                                            {{-- Already applied --}}
                                            <button class="quick-apply-btn applied" disabled>
                                                <i class="fa fa-check-circle"></i> Applied Successfully
                                            </button>
                                        @elseif($daysLeft !== null && $daysLeft <= 0)
                                            {{-- Deadline passed --}}
                                            <button class="quick-apply-btn" disabled>
                                                <i class="fa fa-lock"></i> Applications Closed
                                            </button>
                                        @elseif(!empty($openingsFull) && $openingsFull)
                                            {{-- All openings filled --}}
                                            <button class="quick-apply-btn" disabled>
                                                <i class="fa fa-users"></i> Positions Filled
                                            </button>
                                        @elseif(empty($canApplyInternship) || empty($internshipApplyLimitCheck['allowed']))
                                            <button class="quick-apply-btn" type="button"
                                                onclick="showCandidatePlanLimitAlert(@json(($internshipApplyLimitCheck['message'] ?? null) ?: 'Your plan opportunity apply limit has been reached.'), @json(($internshipApplyLimitCheck['upgrade_url'] ?? null) ?: route('pricing', ['user_id' => Auth::id() ?? 0])))">
                                                <i class="fa fa-lock"></i> Upgrade Plan
                                            </button>
                                            <p class="zp-plan-limit-msg">
                                                {{ ($internshipApplyLimitCheck['message'] ?? null) ?: 'Your plan opportunity apply limit has been reached. Please upgrade your plan to continue.' }}
                                                @if(isset($internshipApplyLimitCheck['limit']) && $internshipApplyLimitCheck['limit'] !== null)
                                                    <span class="zp-plan-limit-usage">(Used {{ (int) ($internshipApplyLimitCheck['used'] ?? 0) }}/{{ (int) $internshipApplyLimitCheck['limit'] }})</span>
                                                @endif
                                            </p>
                                        @else
                                            {{-- Employee / candidate: Quick Apply --}}
                                            
                                            @if($internship->internship_type == 1)
                                            <button class="quick-apply-btn" id="quickApplyBtn" onclick="openApplyModal()">
                                                <i class="fa fa-bolt"></i> Quick Apply
                                            </button>
                                            @else
                                            <button class="quick-apply-btn" id="quickApplyBtn" onclick="openBillingModal()">
                                                <i class="fa fa-bolt"></i> Quick Apply
                                            </button>
                                            @endif
                                            
                                        @endif
                                    @else
                                        {{-- Guest: redirect to login --}}
                                        <button class="quick-apply-btn" onclick="window.location.href='{{ route('login') }}'">
                                            Quick Apply
                                        </button>
                                    @endauth

                                    {{-- ── Applied count ── --}}
                                    @php $applyCount = $internship->apply_count ?? $internship->internship_applications_count ?? 0; @endphp
                                    @if($applyCount > 0)
                                        <div class="zp-applied-count">
                                            <i class="fa fa-mouse-pointer"></i>
                                            <span>{{ $applyCount }} Applied</span>
                                        </div>
                                    @endif

                                </div>
                            </div>

                          

                            {{-- ── BENEFITS OF INTERNSHIP WITH ZOBPOT ── --}}
                            <div class="zp-benefits-card">
                                <div class="zp-benefits-header">
                                    <span class="zp-benefits-badge">Why Zobpot?</span>
                                    <h5 class="zp-benefits-title">Benefits of Interning via Zobpot</h5>
                                    <p class="zp-benefits-sub">Everything you need to launch your career — in one place.</p>
                                </div>
                                <div class="zp-benefits-list">
                                    <div class="zp-benefit-item">
                                        <div class="zp-benefit-icon" style="background:#e8f5e9;color:#1e8e3e;">
                                            <i class="fa fa-shield"></i>
                                        </div>
                                        <div class="zp-benefit-body">
                                            <span class="zp-benefit-name">Verified Companies</span>
                                            <span class="zp-benefit-desc">All companies are screened &amp; trusted</span>
                                        </div>
                                    </div>
                                    <div class="zp-benefit-item">
                                        <div class="zp-benefit-icon" style="background:#e3f2fd;color:#0277bd;">
                                            <i class="fa fa-certificate"></i>
                                        </div>
                                        <div class="zp-benefit-body">
                                            <span class="zp-benefit-name">Completion Certificate</span>
                                            <span class="zp-benefit-desc">Get industry-recognised proof of work</span>
                                        </div>
                                    </div>
                                    <div class="zp-benefit-item">
                                        <div class="zp-benefit-icon" style="background:#ede7f6;color:#6a1b9a;">
                                            <i class="fa fa-line-chart"></i>
                                        </div>
                                        <div class="zp-benefit-body">
                                            <span class="zp-benefit-name">Skill Development</span>
                                            <span class="zp-benefit-desc">Build real-world, in-demand skills</span>
                                        </div>
                                    </div>
                                    <div class="zp-benefit-item">
                                        <div class="zp-benefit-icon" style="background:#fff3e0;color:#e65100;">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="zp-benefit-body">
                                            <span class="zp-benefit-name">Expert Mentorship</span>
                                            <span class="zp-benefit-desc">Learn directly from industry leaders</span>
                                        </div>
                                    </div>
                                    <div class="zp-benefit-item">
                                        <div class="zp-benefit-icon" style="background:#fce4ec;color:#c62828;">
                                            <i class="fa fa-heart"></i>
                                        </div>
                                        <div class="zp-benefit-body">
                                            <span class="zp-benefit-name">Zero Hidden Fees</span>
                                            <span class="zp-benefit-desc">100% free to apply, always</span>
                                        </div>
                                    </div>
                                    <div class="zp-benefit-item" style="border-bottom:none;padding-bottom:0;">
                                        <div class="zp-benefit-icon" style="background:#e8eaf6;color:#242a64;">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="zp-benefit-body">
                                            <span class="zp-benefit-name">Career Network</span>
                                            <span class="zp-benefit-desc">Connect with 10,000+ professionals</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>


    {{-- ======================================================
         COLLEGE INFORMATION MODAL (unchanged)
         ====================================================== --}}
    <div class="modal fade" id="collegeInfoModal" tabindex="-1" aria-labelledby="collegeInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 10px 40px rgba(0,0,0,.15);">
                <div class="modal-header"
                     style="background:linear-gradient(135deg,#242a64 0%,#3a4290 100%); color:white; border-radius:16px 16px 0 0; padding:25px 30px; border:none;">
                    <div>
                        <h5 class="modal-title" id="collegeInfoModalLabel" style="font-size:22px; font-weight:700; margin:0; color:#fff;">
                            <i class="fa fa-graduation-cap"></i> College Information
                        </h5>
                        <p style="margin:5px 0 0; font-size:13px; opacity:.9; color:#fff;">Please provide your academic details</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding:30px;">
                    <form id="collegeInfoForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="university" class="form-label" style="font-weight:600; color:#2c3e50; font-size:14px;">
                                    <i class="fa fa-university" style="color:#242a64;"></i> University <span style="color:#e74c3c;">*</span>
                                </label>
                                <select class="form-select" id="university" name="university_id" required style="border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px;">
                                    <option value="" selected>Select University</option>
                                </select>
                                <input type="text" class="form-control mt-2" id="universityOther" name="university_other"
                                       placeholder="Enter University Name"
                                       style="display:none; border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px;"/>
                                <button type="button" id="universityUseList" class="btn btn-link p-0" style="display:none; margin-top:6px;">Choose from list</button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="college" class="form-label" style="font-weight:600; color:#2c3e50; font-size:14px;">
                                    <i class="fa fa-building" style="color:#242a64;"></i> College <span style="color:#e74c3c;">*</span>
                                </label>
                                <select class="form-select" id="college" name="college_id" required style="border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px;">
                                    <option value="">Select College</option>
                                </select>
                                <input type="text" class="form-control mt-2" id="collegeOther" name="college_other"
                                       placeholder="Enter College Name"
                                       style="border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px; display:none;">
                                <button type="button" id="collegeUseList" class="btn btn-link p-0" style="display:none; margin-top:6px;">Choose from list</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="degreeLevel" class="form-label" style="font-weight:600; color:#2c3e50; font-size:14px;">
                                    <i class="fa fa-certificate" style="color:#242a64;"></i> Degree Level <span style="color:#e74c3c;">*</span>
                                </label>
                                <select class="form-select" id="degreeLevel" name="degree_level_id" required style="border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px;">
                                    <option value="">Select Degree Level</option>
                                </select>
                                <input type="text" class="form-control mt-2" id="degreeLevelOther" name="degree_level_other"
                                       placeholder="Enter Degree Level"
                                       style="display:none; border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px;"/>
                                <button type="button" id="degreeLevelUseList" class="btn btn-link p-0" style="display:none; margin-top:6px;">Choose from list</button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="degree" class="form-label" style="font-weight:600; color:#2c3e50; font-size:14px;">
                                    <i class="fa fa-book" style="color:#242a64;"></i> Degree <span style="color:#e74c3c;">*</span>
                                </label>
                                <select class="form-select" id="degree" name="degree_id" required style="border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px;">
                                    <option value="">Select Degree</option>
                                </select>
                                <input type="text" class="form-control mt-2" id="degreeOther" name="degree_other"
                                       placeholder="Enter Degree Name"
                                       style="display:none; border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px;"/>
                                <button type="button" id="degreeUseList" class="btn btn-link p-0" style="display:none; margin-top:6px;">Choose from list</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="major" class="form-label" style="font-weight:600; color:#2c3e50; font-size:14px;">
                                    <i class="fa fa-bookmark" style="color:#242a64;"></i> Major <span style="color:#e74c3c;">*</span>
                                </label>
                                <select class="form-select" id="major" name="major_id" required style="border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px;">
                                    <option value="">Select Major</option>
                                </select>
                                <input type="text" class="form-control mt-2" id="majorOther" name="major_other"
                                       placeholder="Enter Major Name"
                                       style="display:none; border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px;"/>
                                <button type="button" id="majorUseList" class="btn btn-link p-0" style="display:none; margin-top:6px;">Choose from list</button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="semester" class="form-label" style="font-weight:600; color:#2c3e50; font-size:14px;">
                                    <i class="fa fa-calendar" style="color:#242a64;"></i> Semester <span style="color:#e74c3c;">*</span>
                                </label>
                                <select class="form-select" id="semester" name="semester" required style="border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px;">
                                    <option value="">Select Semester</option>
                                    @for($s=1; $s<=8; $s++)
                                        <option value="{{ $s }}">{{ $s }}{{ in_array($s,[1]) ? 'st' : (in_array($s,[2]) ? 'nd' : (in_array($s,[3]) ? 'rd' : 'th')) }} Semester</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border:none; padding:20px 30px; background:#f8f9fa; border-radius:0 0 16px 16px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding:12px 24px; border-radius:10px; font-weight:600; font-size:14px; border:none;">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="submitCollegeInfo"
                            style="background:linear-gradient(135deg,#242a64 0%,#3a4290 100%); padding:12px 24px; border-radius:10px; font-weight:600; font-size:14px; border:none;">
                        <i class="fa fa-arrow-right"></i> Continue to Payment
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================================
         BILLING MODAL (same design + late fee calculation only)
         ====================================================== --}}
    <div class="modal fade" id="billingModal" tabindex="-1" aria-labelledby="billingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 10px 40px rgba(0,0,0,.15);">
                <div class="modal-header"
                     style="background:linear-gradient(135deg,#242a64 0%,#3a4290 100%); color:white; border-radius:16px 16px 0 0; padding:25px 30px; border:none;">
                    <div>
                        <h5 class="modal-title" id="billingModalLabel" style="font-size:22px; font-weight:700; margin:0; color:#fff;">
                            <i class="fa fa-credit-card"></i> Payment Details
                        </h5>
                        <p style="margin:5px 0 0; font-size:13px; opacity:.9; color:#fff;">Complete your Internship registration</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding:30px;">
                    <div style="background:#fff; border:1px solid #eef0f5; border-radius:12px; padding:25px; margin-bottom:25px; box-shadow:0 2px 10px rgba(0,0,0,.04);">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
                            <h6 style="font-size:16px; font-weight:700; margin:0; color:#242a64; display:flex; align-items:center; gap:8px;">
                                <i class="fa fa-shopping-cart"></i> Order Summary
                            </h6>
                            <span id="billing-reg-badge"
                                  style="font-size:11px; font-weight:700; padding:5px 12px; border-radius:20px; background:{{ !empty($paymentCalc['is_late_registration']) ? '#dc3545' : '#28a745' }}; color:#fff;">
                                {{ !empty($paymentCalc['is_late_registration']) ? 'Late Registration Applied' : 'Regular Registration' }}
                            </span>
                        </div>

                        <div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:14px; color:#495057;">
                            <span>Career Program</span>
                            <span id="billing-title" style="font-weight:600; color:#212529;">{{ $internship->internship_title }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:14px; color:#495057;">
                            <span>Duration</span>
                            <span id="billing-duration" style="font-weight:600; color:#212529;">{{ $internship->duration }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:14px; color:#495057;">
                            <span>Registration Fee</span>
                            <span id="billing-reg-fee" style="font-weight:600; color:#212529;">₹{{ number_format($paymentCalc['registration_fee'], 2) }}</span>
                        </div>

                        {{-- Late fee rows: only shown when late registration applies --}}
                        <div id="billing-late-fee-row"
                             style="display:{{ !empty($paymentCalc['is_late_registration']) && (float) $paymentCalc['late_registration_fee'] > 0 ? 'flex' : 'none' }}; justify-content:space-between; margin-bottom:12px; font-size:14px; color:#495057;">
                            <span>Late Registration Fee</span>
                            <span id="billing-late-fee" style="font-weight:600; color:#212529;">₹{{ number_format($paymentCalc['late_registration_fee'], 2) }}</span>
                        </div>
                        <div id="billing-subtotal-row"
                             style="display:{{ !empty($paymentCalc['is_late_registration']) ? 'flex' : 'none' }}; justify-content:space-between; margin-bottom:12px; font-size:14px; color:#495057;">
                            <span>Subtotal</span>
                            <span id="billing-subtotal" style="font-weight:600; color:#212529;">₹{{ number_format($paymentCalc['subtotal'], 2) }}</span>
                        </div>

                        <div style="display:flex; justify-content:space-between; margin-bottom:12px; font-size:14px; color:#495057;">
                            <span>GST (<span id="billing-gst-pct">{{ $paymentCalc['gst_percentage'] }}</span>%)</span>
                            <span id="billing-gst-amt" style="font-weight:600; color:#212529;">₹{{ number_format($paymentCalc['gst_amount'], 2) }}</span>
                        </div>
                        <hr style="border-color:#e9ecef; margin:15px 0;">
                        <div style="display:flex; justify-content:space-between; font-size:18px; font-weight:700; color:#242a64;">
                            <span>Total Amount</span>
                            <span id="billing-total">₹{{ number_format($paymentCalc['total_amount'], 2) }}</span>
                        </div>
                    </div>
                    <form id="billingForm">
                        <div id="cardDetails" style="display:none;">
                            <div class="mb-3">
                                <label class="form-label" style="font-weight:600; color:#2c3e50; font-size:14px;">
                                    <i class="fa fa-credit-card-alt" style="color:#242a64;"></i> Card Number
                                </label>
                                <input type="text" class="form-control" id="cardNumber" name="cardNumber"
                                       placeholder="1234 5678 9012 3456" maxlength="19"
                                       style="border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px;">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" style="font-weight:600; color:#2c3e50; font-size:14px;">
                                        <i class="fa fa-calendar" style="color:#242a64;"></i> Expiry Date
                                    </label>
                                    <input type="text" class="form-control" id="expiryDate" name="expiryDate"
                                           placeholder="MM/YY" maxlength="5"
                                           style="border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px;">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" style="font-weight:600; color:#2c3e50; font-size:14px;">
                                        <i class="fa fa-lock" style="color:#242a64;"></i> CVV
                                    </label>
                                    <input type="text" class="form-control" id="cvv" name="cvv"
                                           placeholder="123" maxlength="3"
                                           style="border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-weight:600; color:#2c3e50; font-size:14px;">
                                    <i class="fa fa-user" style="color:#242a64;"></i> Cardholder Name
                                </label>
                                <input type="text" class="form-control" id="cardholderName" name="cardholderName"
                                       placeholder="Name on card"
                                       style="border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px;">
                            </div>
                        </div>
                        <div id="upiDetails" style="display:none;">
                            <div class="mb-3">
                                <label class="form-label" style="font-weight:600; color:#2c3e50; font-size:14px;">
                                    <i class="fa fa-mobile" style="color:#242a64;"></i> UPI ID
                                </label>
                                <input type="text" class="form-control" id="upiId" name="upiId"
                                       placeholder="yourname@upi"
                                       style="border:2px solid #e0e0e0; border-radius:10px; padding:12px 16px; font-size:14px;">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border:none; padding:20px 30px; background:#f8f9fa; border-radius:0 0 16px 16px;">
                    <button type="button" class="btn btn-secondary" id="backToCollegeInfo"
                            style="padding:12px 24px; border-radius:10px; font-weight:600; font-size:14px; border:none;">
                        <i class="fa fa-arrow-left"></i> Back
                    </button>
                    <button type="button" class="btn btn-success" id="submitPayment"
                            style="background:linear-gradient(135deg,#242a64 0%,#3a4290 100%); padding:12px 24px; border-radius:10px; font-weight:600; font-size:14px; border:none;">
                        <i class="fa fa-check"></i> Pay <span id="billing-pay-amount">₹{{ number_format($paymentCalc['total_amount'], 2) }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        /* ── PHP → JS opportunity data ── */
        var INTERNSHIP_ID   = {{ $internship->id }};
        var INTERNSHIP_TYPE = {{ $internship->internship_type ?? 0 }};
        // 0 = Default, 1 = With College (college form first), 2 = With Industry (direct payment)

        var CSRF_TOKEN = '{{ csrf_token() }}';
        var LAST_BILLING_AMOUNT = {{ (float) ($paymentCalc['total_amount'] ?? 0) }};

        /* ── Details Read More / Read Less ── */
        (function () {
            var box = document.getElementById('detailsCollapsible');
            var btn = document.getElementById('detailsReadBtn');
            if (!box || !btn) return;
            if (box.scrollHeight <= 322) {
                box.classList.add('expanded');
                btn.parentElement.style.display = 'none';
            }
        })();

        function toggleDetails() {
            var box = document.getElementById('detailsCollapsible');
            var btn = document.getElementById('detailsReadBtn');
            var expanded = box.classList.contains('expanded');
            if (expanded) {
                box.classList.remove('expanded');
                btn.innerHTML = 'Read More <i class="fa fa-chevron-down"></i>';
                box.closest('.zp-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                box.classList.add('expanded');
                btn.innerHTML = 'Read Less <i class="fa fa-chevron-up"></i>';
            }
        }

        /* ══════════════════════════════════════════
           QUICK APPLY — always collect college info before payment
           so degree/college are saved and linked to the application.
           ══════════════════════════════════════════ */
        function openApplyModal() {
            loadUniversities();
            loadDegreeLevels();
            var collegeModal = new bootstrap.Modal(document.getElementById('collegeInfoModal'));
            collegeModal.show();
        }
        
        
        function formatMoney(value) {
            var num = parseFloat(value);
            if (isNaN(num)) num = 0;
            return '₹' + num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        function applyBillingPaymentData(data) {
            if (!data) return;

            if (data.internship_title) {
                document.getElementById('billing-title').textContent = data.internship_title;
            }
            if (data.duration) {
                document.getElementById('billing-duration').textContent = data.duration;
            }

            var isLate = !!data.is_late_registration;
            var lateFee = parseFloat(String(data.late_registration_fee || '0').replace(/,/g, '')) || 0;

            document.getElementById('billing-reg-fee').textContent = '₹' + (data.registration_fee || data.registration_fees || '0.00');
            document.getElementById('billing-late-fee').textContent = '₹' + (data.late_registration_fee || '0.00');
            document.getElementById('billing-subtotal').textContent = '₹' + (data.subtotal || '0.00');
            document.getElementById('billing-gst-pct').textContent = data.gst_percentage || 0;
            document.getElementById('billing-gst-amt').textContent = '₹' + (data.gst_amount || '0.00');
            document.getElementById('billing-total').textContent = '₹' + (data.total_amount || data.final_amount || '0.00');
            document.getElementById('billing-pay-amount').textContent = '₹' + (data.total_amount || data.final_amount || '0.00');

            if (typeof data.final_amount_raw !== 'undefined' && data.final_amount_raw !== null) {
                LAST_BILLING_AMOUNT = parseFloat(data.final_amount_raw);
            } else {
                LAST_BILLING_AMOUNT = parseFloat(String(data.total_amount || data.final_amount || '0').replace(/,/g, '')) || 0;
            }

            var lateRow = document.getElementById('billing-late-fee-row');
            var subtotalRow = document.getElementById('billing-subtotal-row');
            var badge = document.getElementById('billing-reg-badge');

            if (isLate && lateFee > 0) {
                lateRow.style.display = 'flex';
            } else {
                lateRow.style.display = 'none';
            }

            if (isLate) {
                subtotalRow.style.display = 'flex';
                badge.style.background = '#dc3545';
                badge.textContent = 'Late Registration Applied';
            } else {
                subtotalRow.style.display = 'none';
                badge.style.background = '#28a745';
                badge.textContent = 'Regular Registration';
            }
        }

        function refreshBillingSummary(callback) {
            fetch('{{ route("internship.payment.data") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({ internship_id: INTERNSHIP_ID })
            })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (res && res.success && res.data) {
                    applyBillingPaymentData(res.data);
                }
                if (typeof callback === 'function') callback();
            })
            .catch(function () {
                if (typeof callback === 'function') callback();
            });
        }

        function openBillingModal(){
            refreshBillingSummary(function () {
                var billingModal = new bootstrap.Modal(document.getElementById('billingModal'));
                billingModal.show();
            });
        }

        /* ── Back button: billing → college info (only for type 1) ── */
        document.addEventListener('DOMContentLoaded', function () {

            var backBtn = document.getElementById('backToCollegeInfo');
            if (backBtn) {
                backBtn.addEventListener('click', function () {
                    bootstrap.Modal.getInstance(document.getElementById('billingModal')).hide();
                    var collegeModal = new bootstrap.Modal(document.getElementById('collegeInfoModal'));
                    collegeModal.show();
                });
            }

            /* ── College Info → Continue to Payment ── */
            var submitCollegeBtn = document.getElementById('submitCollegeInfo');
            if (submitCollegeBtn) {
                submitCollegeBtn.addEventListener('click', function () {
                    var form = document.getElementById('collegeInfoForm');
                    /* Basic HTML5 validation */
                    if (!form.checkValidity()) {
                        form.reportValidity();
                        return;
                    }
                    var data = new FormData(form);
                    data.append('_token', CSRF_TOKEN);

                    submitCollegeBtn.disabled = true;
                    submitCollegeBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving…';

                    fetch('{{ route("submit.college.info") }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
                        body: data
                    })
                    .then(function (r) { return r.json(); })
                    .then(function (res) {
                        submitCollegeBtn.disabled = false;
                        submitCollegeBtn.innerHTML = '<i class="fa fa-arrow-right"></i> Continue to Payment';
                        if (res.success) {
                            bootstrap.Modal.getInstance(document.getElementById('collegeInfoModal')).hide();
                            openBillingModal();
                        } else {
                            alert(res.message || 'Could not save college info. Please try again.');
                        }
                    })
                    .catch(function () {
                        submitCollegeBtn.disabled = false;
                        submitCollegeBtn.innerHTML = '<i class="fa fa-arrow-right"></i> Continue to Payment';
                        alert('Network error. Please try again.');
                    });
                });
            }

            /* ── Submit Payment ── */
            var submitPaymentBtn = document.getElementById('submitPayment');
            if (submitPaymentBtn) {
                submitPaymentBtn.addEventListener('click', function () {
                    submitPaymentBtn.disabled = true;
                    submitPaymentBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing…';

                    /*
                    // Mukeshbhai old code - internship apply payment bypass (no Razorpay)
                    fetch('{{ route("internship.application.create") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        body: JSON.stringify({ internship_id: INTERNSHIP_ID })
                    })
                    .then(function (r) { return r.json(); })
                    .then(function (res) {
                        submitPaymentBtn.disabled = false;
                        submitPaymentBtn.innerHTML = '<i class="fa fa-check"></i> Pay <span id="billing-pay-amount">₹{{ number_format($paymentCalc['total_amount'], 2) }}</span>';
                        if (res.success) {
                            bootstrap.Modal.getInstance(document.getElementById('billingModal')).hide();
                            var applyBtn = document.getElementById('quickApplyBtn');
                            if (applyBtn) {
                                applyBtn.className = 'quick-apply-btn applied';
                                applyBtn.disabled = true;
                                applyBtn.innerHTML = '<i class="fa fa-check-circle"></i> Applied Successfully';
                                applyBtn.onclick = null;
                            }
                            showToast('success', 'Application submitted successfully!');
                        } else if (res.message === 'already_applied') {
                            ...
                        }
                    });
                    */

                    // Raj new code - dynamic Razorpay
                    fetch('{{ route("internship.razorpay.create-order") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        },
                        body: JSON.stringify({
                            internship_id: INTERNSHIP_ID,
                            amount: LAST_BILLING_AMOUNT
                        })
                    })
                    .then(function (r) { return r.json().then(function (data) { return { status: r.status, data: data }; }); })
                    .then(function (result) {
                        var res = result.data || {};
                        if (!res.success) {
                            resetPayButton(submitPaymentBtn);
                            handleInternshipApplyError(res);
                            return;
                        }

                        var options = {
                            "key": res.key,
                            "amount": res.amount,
                            "currency": res.currency || 'INR',
                            "name": res.name || 'ZobPot',
                            "description": res.description || '',
                            "order_id": res.order_id,
                            "prefill": {
                                "name": (res.prefill && res.prefill.name) ? res.prefill.name : '',
                                "email": (res.prefill && res.prefill.email) ? res.prefill.email : '',
                                "contact": (res.prefill && res.prefill.contact) ? res.prefill.contact : ''
                            },
                            "theme": {
                                "color": (res.theme && res.theme.color) ? res.theme.color : '#242a62'
                            },
                            "handler": function (response) {
                                fetch('{{ route("internship.razorpay.verify") }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': CSRF_TOKEN
                                    },
                                    body: JSON.stringify({
                                        internship_id: INTERNSHIP_ID,
                                        razorpay_payment_id: response.razorpay_payment_id,
                                        razorpay_order_id: response.razorpay_order_id,
                                        razorpay_signature: response.razorpay_signature
                                    })
                                })
                                .then(function (r) { return r.json(); })
                                .then(function (verifyRes) {
                                    resetPayButton(submitPaymentBtn);
                                    if (verifyRes.success) {
                                        var billingInst = bootstrap.Modal.getInstance(document.getElementById('billingModal'));
                                        if (billingInst) billingInst.hide();
                                        var applyBtn = document.getElementById('quickApplyBtn');
                                        if (applyBtn) {
                                            applyBtn.className = 'quick-apply-btn applied';
                                            applyBtn.disabled = true;
                                            applyBtn.innerHTML = '<i class="fa fa-check-circle"></i> Applied Successfully';
                                            applyBtn.onclick = null;
                                        }
                                        showToast('success', 'Application submitted successfully!');
                                    } else {
                                        handleInternshipApplyError(verifyRes);
                                    }
                                })
                                .catch(function () {
                                    resetPayButton(submitPaymentBtn);
                                    alert('Network error. Please try again.');
                                });
                            },
                            "modal": {
                                "ondismiss": function () {
                                    resetPayButton(submitPaymentBtn);
                                }
                            }
                        };

                        var rzp = new Razorpay(options);
                        rzp.on('payment.failed', function () {
                            resetPayButton(submitPaymentBtn);
                            alert('Payment failed. Please try again.');
                        });
                        rzp.open();
                    })
                    .catch(function () {
                        resetPayButton(submitPaymentBtn);
                        alert('Network error. Please try again.');
                    });
                });
            }
        });

        function resetPayButton(btn) {
            if (!btn) return;
            btn.disabled = false;
            btn.innerHTML = '<i class="fa fa-check"></i> Pay <span id="billing-pay-amount">₹' + (LAST_BILLING_AMOUNT ? LAST_BILLING_AMOUNT.toFixed(2) : '0.00') + '</span>';
        }

        function handleInternshipApplyError(res) {
            if (!res) {
                alert('Payment failed. Please try again.');
                return;
            }
            if (res.message === 'already_applied') {
                var billingInst = bootstrap.Modal.getInstance(document.getElementById('billingModal'));
                if (billingInst) billingInst.hide();
                showToast('info', 'You have already applied for this Internship.');
            } else if (res.message === 'no_openings') {
                var billingInst2 = bootstrap.Modal.getInstance(document.getElementById('billingModal'));
                if (billingInst2) billingInst2.hide();
                showToast('info', 'All positions for this Internship are filled.');
            } else if (res.message === 'college_info_required') {
                var billingInst3 = bootstrap.Modal.getInstance(document.getElementById('billingModal'));
                if (billingInst3) billingInst3.hide();
                showToast('info', 'Please complete your college and degree details before applying.');
                openApplyModal();
            } else if (res.message === 'internship_not_available') {
                var billingInst4 = bootstrap.Modal.getInstance(document.getElementById('billingModal'));
                if (billingInst4) billingInst4.hide();
                showToast('info', 'This Internship is not available for applications yet.');
            } else if (res.message === 'internship_closed') {
                var billingInst5 = bootstrap.Modal.getInstance(document.getElementById('billingModal'));
                if (billingInst5) billingInst5.hide();
                showToast('info', 'This Internship is closed and no longer accepting applications.');
            } else if (res.message === 'plan_service_required') {
                var billingInst6 = bootstrap.Modal.getInstance(document.getElementById('billingModal'));
                if (billingInst6) billingInst6.hide();
                showCandidatePlanLimitAlert(res.error || 'Your current plan does not include Internship service.', res.upgrade_url || '');
            } else if (res.message === 'plan_service_limit_reached') {
                var billingInstLimit = bootstrap.Modal.getInstance(document.getElementById('billingModal'));
                if (billingInstLimit) billingInstLimit.hide();
                showCandidatePlanLimitAlert(res.error || 'Your plan service limit has been reached. Please upgrade your plan.', res.upgrade_url || '');
            } else if (res.message === 'login_required') {
                alert('Please login to apply.');
            } else if (res.message === 'invalid_amount' || res.message === 'amount_mismatch') {
                alert(res.error || 'Payment amount is invalid. Please refresh and try again.');
            } else if (res.message === 'payment_create_failed' || res.message === 'payment_verify_failed' || res.message === 'order_create_failed') {
                alert((res.error || 'Payment could not be completed. Please try again.') + (res.debug ? ('\n\n' + res.debug) : ''));
            } else {
                alert(res.error || res.message || 'Payment failed. Please try again.');
            }
        }

        /* ── Plan limit → Upgrade Plan alert ── */
        function showCandidatePlanLimitAlert(message, upgradeUrl) {
            if (typeof Swal === 'undefined') {
                if (upgradeUrl && confirm(message || 'Plan limit reached. Upgrade now?')) {
                    window.location.href = upgradeUrl;
                } else {
                    alert(message || 'Plan limit reached. Please upgrade your plan.');
                }
                return;
            }
            Swal.fire({
                icon: 'warning',
                title: 'Upgrade Plan Required',
                text: message || 'Your plan limit has been reached. Please upgrade your plan.',
                showCancelButton: true,
                confirmButtonText: 'Upgrade Plan',
                cancelButtonText: 'Close'
            }).then(function(result) {
                if (result.isConfirmed && upgradeUrl) {
                    window.location.href = upgradeUrl;
                }
            });
        }

        /* ── Simple toast helper ── */
        function showToast(type, message) {
            var color = type === 'success' ? '#1e8e3e' : '#242a64';
            var toast = document.createElement('div');
            toast.style.cssText = 'position:fixed;bottom:28px;right:24px;background:'+color+';color:#fff;padding:14px 22px;border-radius:10px;font-size:14px;font-weight:600;z-index:9999;box-shadow:0 4px 16px rgba(0,0,0,.18);';
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(function () { toast.remove(); }, 4000);
        }

        /* ── Wishlist toggle ── */
        function toggleWishlist(internshipId) {
            var btn = document.getElementById('wishlistBtn');
            fetch('{{ route("internship.wishlist.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({ internship_id: internshipId })
            })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (res.success) {
                    var icon = btn.querySelector('i');
                    if (res.action === 'added') {
                        btn.classList.add('saved');
                        icon.className = 'fa fa-heart';
                        btn.title = 'Remove from Wishlist';
                    } else {
                        btn.classList.remove('saved');
                        icon.className = 'fa fa-heart-o';
                        btn.title = 'Save';
                    }
                }
            });
        }

        /* ── Share opportunity ── */
        function shareInternship(slug) {
            var url = window.location.origin + '/opportunity-detail/' + slug;
            if (navigator.share) {
                navigator.share({ title: document.title, url: url });
            } else if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(function () {
                    showToast('info', 'Link copied to clipboard!');
                });
            } else {
                prompt('Copy this link:', url);
            }
        }

        /* ══════════════════════════════════════════
           COLLEGE INFO MODAL — dynamic dropdowns + Other
           ══════════════════════════════════════════ */

        function resetSelectOptions(selectEl, placeholderText) {
            if (!selectEl) return;
            selectEl.innerHTML = '';
            selectEl.add(new Option(placeholderText, ''));
            selectEl.value = '';
            selectEl.style.display = '';
            selectEl.required = true;
        }

        function enableOtherMode(selectEl, otherInput, useListBtn) {
            if (!selectEl) return;
            selectEl.style.display = 'none';
            selectEl.required = false;
            if (otherInput) {
                otherInput.style.display = '';
                otherInput.required = true;
                otherInput.value = otherInput.value || '';
            }
            if (useListBtn) {
                useListBtn.style.display = '';
            }
        }

        function enableListMode(selectEl, otherInput, useListBtn) {
            if (!selectEl) return;
            selectEl.style.display = '';
            selectEl.required = true;
            if (selectEl.value === 'other') {
                selectEl.value = '';
            }
            if (otherInput) {
                otherInput.style.display = 'none';
                otherInput.required = false;
                otherInput.value = '';
            }
            if (useListBtn) {
                useListBtn.style.display = 'none';
            }
        }

        function addOtherOption(selectEl) {
            if (!selectEl) return;
            var exists = Array.prototype.some.call(selectEl.options, function (opt) {
                return opt.value === 'other';
            });
            if (!exists) {
                selectEl.add(new Option('Other (not listed)', 'other'));
            }
        }

        function loadUniversities() {
            var sel = document.getElementById('university');
            if (!sel || sel.options.length > 1) return;
            fetch('{{ route("get.universities") }}')
                .then(function (r) { return r.json(); })
                .then(function (list) {
                    (list || []).forEach(function (u) {
                        sel.add(new Option(u.university_name, u.id));
                    });
                    addOtherOption(sel);
                });
        }

        function loadDegreeLevels() {
            var sel = document.getElementById('degreeLevel');
            if (!sel || sel.options.length > 1) return;
            fetch('{{ route("get.degree.levels") }}')
                .then(function (r) { return r.json(); })
                .then(function (list) {
                    (list || []).forEach(function (dl) {
                        sel.add(new Option(dl.degree_level_name, dl.degree_level_id));
                    });
                    addOtherOption(sel);
                });
        }

        function loadCollegesByUniversity(universityId) {
            var collegesSel = document.getElementById('college');
            var collegeOther = document.getElementById('collegeOther');
            var collegeUseList = document.getElementById('collegeUseList');

            resetSelectOptions(collegesSel, 'Select College');
            enableListMode(collegesSel, collegeOther, collegeUseList);

            if (!universityId) return;

            // If university is Other, still allow College Other
            if (universityId === 'other') {
                addOtherOption(collegesSel);
                return;
            }

            fetch('{{ route("get.colleges.by.university") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                body: JSON.stringify({ university_id: universityId })
            })
            .then(function (r) { return r.json(); })
            .then(function (list) {
                (list || []).forEach(function (c) {
                    collegesSel.add(new Option(c.college_name, c.id));
                });
                addOtherOption(collegesSel);
            });
        }

        function loadDegreesByLevel(degreeLevelId) {
            var degreeSel = document.getElementById('degree');
            var degreeOther = document.getElementById('degreeOther');
            var degreeUseList = document.getElementById('degreeUseList');
            var majorSel = document.getElementById('major');
            var majorOther = document.getElementById('majorOther');
            var majorUseList = document.getElementById('majorUseList');

            resetSelectOptions(degreeSel, 'Select Degree');
            enableListMode(degreeSel, degreeOther, degreeUseList);
            resetSelectOptions(majorSel, 'Select Major');
            enableListMode(majorSel, majorOther, majorUseList);

            if (!degreeLevelId) return;

            if (degreeLevelId === 'other') {
                addOtherOption(degreeSel);
                return;
            }

            fetch('{{ route("get.degrees.by.level") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                body: JSON.stringify({ degree_level_id: degreeLevelId })
            })
            .then(function (r) { return r.json(); })
            .then(function (list) {
                (list || []).forEach(function (d) {
                    degreeSel.add(new Option(d.degree_name, d.degree_id));
                });
                addOtherOption(degreeSel);
            });
        }

        function loadMajorsByDegree(degreeId) {
            var majorSel = document.getElementById('major');
            var majorOther = document.getElementById('majorOther');
            var majorUseList = document.getElementById('majorUseList');

            resetSelectOptions(majorSel, 'Select Major');
            enableListMode(majorSel, majorOther, majorUseList);

            if (!degreeId) return;

            if (degreeId === 'other') {
                addOtherOption(majorSel);
                return;
            }

            fetch('{{ route("get.majors.by.degree") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                body: JSON.stringify({ degree_id: degreeId })
            })
            .then(function (r) { return r.json(); })
            .then(function (list) {
                (list || []).forEach(function (m) {
                    majorSel.add(new Option(m.major_name, m.major_id));
                });
                addOtherOption(majorSel);
            });
        }

        document.addEventListener('change', function (e) {
            if (!e.target) return;

            if (e.target.id === 'university') {
                var val = e.target.value;
                var otherInput = document.getElementById('universityOther');
                var useListBtn = document.getElementById('universityUseList');

                if (val === 'other') {
                    enableOtherMode(e.target, otherInput, useListBtn);
                } else {
                    enableListMode(e.target, otherInput, useListBtn);
                    e.target.value = val;
                }

                loadCollegesByUniversity(val);
            }

            if (e.target.id === 'college') {
                var collegeOther = document.getElementById('collegeOther');
                var collegeUseList = document.getElementById('collegeUseList');
                if (e.target.value === 'other') {
                    enableOtherMode(e.target, collegeOther, collegeUseList);
                } else {
                    enableListMode(e.target, collegeOther, collegeUseList);
                    e.target.value = e.target.value;
                }
            }

            if (e.target.id === 'degreeLevel') {
                var val = e.target.value;
                var dlOther = document.getElementById('degreeLevelOther');
                var dlUseList = document.getElementById('degreeLevelUseList');

                if (val === 'other') {
                    enableOtherMode(e.target, dlOther, dlUseList);
                } else {
                    enableListMode(e.target, dlOther, dlUseList);
                    e.target.value = val;
                }

                loadDegreesByLevel(val);
            }

            if (e.target.id === 'degree') {
                var val = e.target.value;
                var dOther = document.getElementById('degreeOther');
                var dUseList = document.getElementById('degreeUseList');

                if (val === 'other') {
                    enableOtherMode(e.target, dOther, dUseList);
                } else {
                    enableListMode(e.target, dOther, dUseList);
                    e.target.value = val;
                }

                loadMajorsByDegree(val);
            }

            if (e.target.id === 'major') {
                var mOther = document.getElementById('majorOther');
                var mUseList = document.getElementById('majorUseList');
                if (e.target.value === 'other') {
                    enableOtherMode(e.target, mOther, mUseList);
                } else {
                    enableListMode(e.target, mOther, mUseList);
                    e.target.value = e.target.value;
                }
            }
        });

        /* "Choose from list" buttons — restore only that field */
        document.addEventListener('click', function (e) {
            if (!e.target) return;

            if (e.target.id === 'universityUseList') {
                var uni = document.getElementById('university');
                enableListMode(uni, document.getElementById('universityOther'), e.target);
                loadCollegesByUniversity('');
            }

            if (e.target.id === 'collegeUseList') {
                var college = document.getElementById('college');
                enableListMode(college, document.getElementById('collegeOther'), e.target);
                // Keep existing college options; just leave Other available
                addOtherOption(college);
            }

            if (e.target.id === 'degreeLevelUseList') {
                var dl = document.getElementById('degreeLevel');
                enableListMode(dl, document.getElementById('degreeLevelOther'), e.target);
                loadDegreesByLevel('');
            }

            if (e.target.id === 'degreeUseList') {
                var degree = document.getElementById('degree');
                enableListMode(degree, document.getElementById('degreeOther'), e.target);
                loadMajorsByDegree('');
                addOtherOption(degree);
            }

            if (e.target.id === 'majorUseList') {
                var major = document.getElementById('major');
                enableListMode(major, document.getElementById('majorOther'), e.target);
                addOtherOption(major);
            }
        });
    </script>
@endsection

