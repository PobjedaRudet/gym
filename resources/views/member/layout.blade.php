<!doctype html>
<html lang="bs">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BEG's Fit&Fight — Članovi Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <style>
        * { box-sizing: border-box; }
        body {
            background: #f2f2f2;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #333;
            margin: 0;
            overflow-x: hidden;
        }

        body.guest-portal {
            background: #0a0a0a;
            color: #f4f4f5;
        }

        /* ===== SIDEBAR ===== */
        .sidebar-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }
        .sidebar-overlay.active { opacity: 1; visibility: visible; }

        .sidebar {
            position: fixed; top: 0; left: -280px;
            width: 280px; height: 100vh;
            background: linear-gradient(180deg, #111 0%, #1a1a1a 100%);
            z-index: 999;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; flex-direction: column;
            box-shadow: 4px 0 30px rgba(0,0,0,0.4);
        }
        .sidebar.open { left: 0; }

        .sidebar-logo {
            padding: 1.25rem 1.25rem 0.75rem;
            border-bottom: 1px solid rgba(200,168,78,0.15);
            text-align: center;
        }
        .sidebar-logo img {
            height: 40px; width: auto;
        }

        .sidebar-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex; align-items: center; gap: 14px;
        }
        .sidebar-avatar {
            width: 50px; height: 50px;
            border-radius: 50%; object-fit: cover;
            border: 2px solid rgba(200,168,78,0.5);
        }
        .sidebar-name {
            font-weight: 700; font-size: 15px; color: #fff;
            line-height: 1.3;
        }
        .sidebar-email {
            font-size: 11px; color: rgba(255,255,255,0.4);
            overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
            max-width: 170px;
        }
        .sidebar-badge {
            display: inline-block; font-size: 10px; font-weight: 700;
            padding: 3px 10px; border-radius: 20px; margin-top: 4px;
        }
        .sidebar-badge.aktivan { background: rgba(56,239,125,0.15); color: #38ef7d; }
        .sidebar-badge.neaktivan { background: rgba(239,68,68,0.15); color: #ef4444; }

        .sidebar-nav {
            flex: 1; padding: 1rem 0; overflow-y: auto;
        }
        .sidebar-section {
            padding: 0 1.25rem; margin-bottom: 0.5rem;
            font-size: 10px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1.5px; color: rgba(200,168,78,0.4);
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 1.25rem;
            color: rgba(255,255,255,0.6);
            text-decoration: none; font-size: 14px; font-weight: 500;
            transition: all 0.2s; border-left: 3px solid transparent;
        }
        .sidebar-link:hover {
            background: rgba(200,168,78,0.08);
            color: #fff; border-left-color: rgba(200,168,78,0.3);
        }
        .sidebar-link.active {
            background: rgba(200,168,78,0.12);
            color: #c8a84e; font-weight: 700;
            border-left-color: #c8a84e;
        }
        .sidebar-link svg { flex-shrink: 0; }
        .sidebar-link .link-badge {
            margin-left: auto; font-size: 11px; font-weight: 700;
            background: rgba(200,168,78,0.2); color: #c8a84e;
            padding: 2px 8px; border-radius: 10px; min-width: 22px; text-align: center;
        }

        /* ===== SUBMENU ===== */
        .sidebar-submenu-toggle {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 1.25rem;
            color: rgba(255,255,255,0.6);
            text-decoration: none; font-size: 14px; font-weight: 500;
            transition: all 0.2s; border-left: 3px solid transparent;
            cursor: pointer; background: none; border: none; width: 100%;
            text-align: left;
        }
        .sidebar-submenu-toggle:hover {
            background: rgba(200,168,78,0.08);
            color: #fff; border-left-color: rgba(200,168,78,0.3);
        }
        .sidebar-submenu-toggle.active {
            background: rgba(200,168,78,0.12);
            color: #c8a84e; font-weight: 700;
            border-left-color: #c8a84e;
        }
        .sidebar-submenu-toggle svg { flex-shrink: 0; }
        .sidebar-submenu-toggle .toggle-arrow {
            margin-left: auto; transition: transform 0.3s;
        }
        .sidebar-submenu-toggle.expanded .toggle-arrow {
            transform: rotate(180deg);
        }

        .sidebar-submenu {
            display: none; flex-direction: column;
            background: rgba(0,0,0,0.3);
            border-left: 3px solid transparent;
        }
        .sidebar-submenu.expanded {
            display: flex;
        }
        .sidebar-submenu .sidebar-link {
            padding: 10px 1.25rem 10px 3.5rem;
            font-size: 13px;
            color: rgba(255,255,255,0.5);
        }
        .sidebar-submenu .sidebar-link:hover {
            background: rgba(200,168,78,0.06);
            color: #fff;
        }
        .sidebar-submenu .sidebar-link.active {
            background: rgba(200,168,78,0.1);
            color: #c8a84e;
            border-left: none;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.06);
        }
        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 12px 14px;
            background: linear-gradient(180deg, rgba(157,33,33,0.18) 0%, rgba(110,22,22,0.26) 100%);
            border: 1px solid rgba(239,68,68,0.22);
            color: #ffe2e2;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.2px;
            cursor: pointer;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.04), 0 8px 22px rgba(0,0,0,0.18);
            transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease, color 0.2s ease;
        }
        .logout-btn svg {
            color: #ff8f8f;
            transition: color 0.2s ease, transform 0.2s ease;
        }
        .logout-btn:hover {
            background: linear-gradient(180deg, rgba(185,40,40,0.24) 0%, rgba(128,26,26,0.34) 100%);
            border-color: rgba(248,113,113,0.4);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.06), 0 12px 26px rgba(80,10,10,0.22);
        }
        .logout-btn:hover svg {
            color: #ffc1c1;
            transform: translateX(1px);
        }
        .logout-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(248,113,113,0.18), inset 0 1px 0 rgba(255,255,255,0.05), 0 10px 24px rgba(80,10,10,0.2);
        }

        /* ===== TOP BAR ===== */
        .topbar {
            position: sticky; top: 0; z-index: 100;
            background: #0a0a0a;
            backdrop-filter: blur(12px);
            padding: 10px 1.25rem;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .topbar-left { display: flex; align-items: center; gap: 14px; }
        .hamburger {
            background: none; border: none; color: #f4f4f5; cursor: pointer;
            padding: 4px; display: flex; align-items: center;
        }
        .topbar-logo img {
            height: 34px; width: auto;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            min-height: calc(100vh - 52px);
            padding: 1.25rem;
        }

        /* ===== CARDS ===== */
        .glass-card {
            background: #fff;
            border: 1px solid rgba(0,0,0,0.06);
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        /* ===== AUTH CARD (login/register) ===== */
        .auth-card {
            background: #111111;
            border: 1px solid #2a2a2a;
            border-radius: 20px;
            padding: 2.5rem;
            max-width: 440px;
            margin: 0 auto;
            box-shadow: 0 20px 40px rgba(0,0,0,0.45);
        }
        .auth-card h2 { color: #ffffff; font-weight: 800; margin-bottom: 0.5rem; }
        .auth-card .subtitle { color: #b3b3b3; font-size: 14px; margin-bottom: 2rem; }
        .auth-symbol {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            border: 1px solid #3a3a3a;
            background: #161616;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f4f4f5;
            margin-bottom: 1rem;
        }
        .auth-symbol svg {
            width: 28px;
            height: 28px;
        }
        .auth-card label {
            color: #d4d4d8; font-size: 13px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .auth-card .form-control {
            background: #1a1a1a;
            border: 1px solid #3a3a3a;
            color: #f4f4f5; border-radius: 12px; padding: 12px 16px; font-size: 15px;
        }
        .auth-card .form-control:focus {
            background: #1f1f1f;
            border-color: #8a8a8a;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.12);
            color: #ffffff;
        }
        .auth-card .form-control::placeholder { color: #7d7d7d; }
        .btn-portal {
            background: #f5f5f5;
            border: 1px solid #f5f5f5;
            color: #111111; font-weight: 700; font-size: 15px;
            padding: 12px; border-radius: 12px; width: 100%;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-portal:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(255,255,255,0.2);
            color: #000;
        }
        .auth-link { color: #ffffff; text-decoration: none; font-weight: 600; }
        .auth-link:hover { color: #d4d4d8; }
        .alert-portal {
            background: #1a1a1a; border: 1px solid #525252;
            color: #e4e4e7; border-radius: 12px; padding: 12px 16px; font-size: 14px;
        }

        .auth-hero-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem 0.75rem;
        }
        .auth-phone {
            width: min(385px, 94vw);
            min-height: 700px;
            border-radius: 34px;
            border: 1px solid #1f1f1f;
            overflow: hidden;
            position: relative;
            background-size: cover;
            background-position: center;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.6);
        }
        .auth-phone::after {
            content: "";
            position: absolute;
            top: 12px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 6px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            z-index: 2;
        }
        .auth-phone::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.55) 0%, rgba(0, 0, 0, 0.75) 50%, rgba(0, 0, 0, 0.92) 100%);
        }
        .auth-phone-inner {
            position: relative;
            min-height: 700px;
            padding: 2.1rem 1.5rem 1.3rem;
            display: flex;
            flex-direction: column;
        }
        .auth-brand {
            text-align: center;
            margin-top: 0.2rem;
        }
        .auth-brand img {
            height: 58px;
            width: auto;
            border-radius: 14px;
            filter: drop-shadow(0 8px 18px rgba(0, 0, 0, 0.5));
        }
        .auth-copy {
            margin-top: auto;
            margin-bottom: 0.9rem;
            color: #f5f5f5;
            text-align: left;
            line-height: 1.12;
            font-size: clamp(1.85rem, 5.8vw, 2.25rem);
            font-weight: 300;
            letter-spacing: 0;
        }
        .auth-copy strong {
            font-weight: 800;
            color: #ffffff;
        }
        .auth-actions {
            display: grid;
            gap: 0.75rem;
        }
        .btn-auth-primary,
        .btn-auth-secondary {
            width: 100%;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 0.82rem 1rem;
            text-transform: uppercase;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: inline-block;
        }
        .btn-auth-primary {
            background: #ffb800;
            color: #111111;
            border: 1px solid #ffb800;
        }
        .btn-auth-primary:hover {
            color: #111111;
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(255, 184, 0, 0.3);
        }
        .btn-auth-secondary {
            background: rgba(0, 0, 0, 0.35);
            color: #f4f4f5;
            border: 1px solid #3f3f46;
        }
        .btn-auth-secondary:hover {
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.35);
        }
        .auth-form-panel {
            margin-top: 0.85rem;
            background: rgba(9, 9, 11, 0.86);
            border: 1px solid #2f2f35;
            border-radius: 16px;
            padding: 1.05rem;
            backdrop-filter: blur(3px);
        }
        .auth-form-title {
            color: #ffffff;
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.15rem;
        }
        .auth-form-subtitle {
            color: #a1a1aa;
            font-size: 0.82rem;
            margin-bottom: 0.85rem;
        }
        .auth-form-panel .form-control {
            background: #16161a;
            border-color: #31313a;
            color: #f4f4f5;
            min-height: 46px;
        }
        .auth-form-panel .form-control:focus {
            background: #18181b;
            border-color: #ffb800;
            box-shadow: 0 0 0 3px rgba(255, 184, 0, 0.2);
            color: #ffffff;
        }
        .auth-form-panel label,
        .auth-form-panel small,
        .auth-form-panel .form-check-label,
        .auth-muted {
            color: #d4d4d8 !important;
        }
        .auth-form-panel label {
            margin-bottom: 0.32rem;
        }
        .auth-form-panel .form-check-input {
            width: 1.1em;
            height: 1.1em;
            margin-top: 0.2em;
            background-color: #16161a;
            border: 1px solid #52525b;
            cursor: pointer;
        }
        .auth-form-panel .form-check-input:focus {
            border-color: #ffb800;
            box-shadow: 0 0 0 3px rgba(255, 184, 0, 0.18);
        }
        .auth-form-panel .form-check-input:checked {
            background-color: #ffb800;
            border-color: #ffb800;
        }
        .auth-form-panel .form-check-label {
            cursor: pointer;
        }
        .auth-legal {
            margin-top: auto;
            text-align: center;
            color: #a1a1aa;
            font-size: 11px;
        }

        @media (min-width: 992px) {
            .sidebar { left: 0; }
            .sidebar-overlay { display: none; }
            .main-wrap { margin-left: 280px; }
            .hamburger { display: none; }
        }
    </style>
    @yield('styles')
</head>
<body class="{{ Auth::guard('member')->check() ? '' : 'guest-portal' }}">
    @if(Auth::guard('member')->check())
    @php
        $authMember = Auth::guard('member')->user();
        $currentRoute = Route::currentRouteName();
        $neprocitaneObavijesti = \App\Models\Obavijest::where('created_at', '>', $authMember->last_seen_obavijesti ?? '2000-01-01')->count();
        $noviTermini = \App\Models\TerminTreninga::where('created_at', '>', $authMember->last_seen_termini ?? '2000-01-01')->count();
    @endphp

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('site/img/logo.png') }}" alt="BEG's Fit&Fight">
        </div>
        <div class="sidebar-header">
            @if($authMember->image_path)
            <img src="{{ asset('images/'.$authMember->image_path) }}" class="sidebar-avatar" alt="">
            @else
            <div class="sidebar-avatar d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg,#c8a84e,#a08430);font-weight:800;color:#fff;font-size:18px;">
                {{ mb_substr($authMember->name,0,1) }}{{ mb_substr($authMember->surname,0,1) }}
            </div>
            @endif
            <div style="overflow:hidden;">
                <div class="sidebar-name">{{ $authMember->name }} {{ $authMember->surname }}</div>
                <div class="sidebar-email">{{ $authMember->email }}</div>
                @php
                    $sideClanarina = \DB::table('fees')->where('member_id', $authMember->id)->orderBy('end','desc')->first();
                    $sideAktivan = $sideClanarina && \Carbon\Carbon::parse($sideClanarina->end)->gte(now()->startOfDay());
                @endphp
                <span class="sidebar-badge {{ $sideAktivan ? 'aktivan' : 'neaktivan' }}">{{ $sideAktivan ? 'Aktivan' : 'Neaktivan' }}</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section" style="margin-top:0.5rem;">Meni</div>

            <a href="{{ route('member.profile') }}" class="sidebar-link {{ $currentRoute == 'member.profile' ? 'active' : '' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Moj profil
            </a>
            <a href="{{ route('member.statistics') }}" class="sidebar-link {{ $currentRoute == 'member.statistics' ? 'active' : '' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                Statistika
            </a>
            <a href="{{ route('member.live') }}" class="sidebar-link {{ $currentRoute == 'member.live' ? 'active' : '' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                Trenutno prisutnih
            </a>
            <a href="{{ route('member.obavijesti') }}" class="sidebar-link {{ $currentRoute == 'member.obavijesti' ? 'active' : '' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
                Obavijesti
                @if($neprocitaneObavijesti > 0)
                <span class="link-badge" style="background:rgba(255,55,95,0.2);color:#FF375F;">{{ $neprocitaneObavijesti }}</span>
                @endif
            </a>
            <a href="{{ route('member.termini') }}" class="sidebar-link {{ $currentRoute == 'member.termini' ? 'active' : '' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                Termini treninga
                @if($noviTermini > 0)
                <span class="link-badge" style="background:rgba(48,209,88,0.2);color:#30D158;">{{ $noviTermini }}</span>
                @endif
            </a>

            @if($authMember->is_admin)
            <div class="sidebar-section" style="margin-top:1.5rem;">Administracija</div>

            <button class="sidebar-submenu-toggle" id="adminToggle" onclick="toggleAdminMenu()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z"/><path d="M19.4 15a1.65 1.65 0 00.33-1.82l-2.5-4.3a1.65 1.65 0 00-1.41-.84h-2.94a1.65 1.65 0 00-1.41.84l-2.5 4.3a1.65 1.65 0 00.33 1.82m9.44-6a2.41 2.41 0 00-1.16-2.13l-3.84-2.21a2.41 2.41 0 00-2.46 0l-3.84 2.21A2.41 2.41 0 004.6 9a2.41 2.41 0 00.88 2.13l3.84 2.21a2.41 2.41 0 002.46 0l3.84-2.21A2.41 2.41 0 0019.44 9z"/></svg>
                Admin panel
                <span class="toggle-arrow">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                </span>
            </button>

            <div class="sidebar-submenu" id="adminMenu">
                <a href="{{ route('member.obavijesti.create') }}" class="sidebar-link {{ $currentRoute == 'member.obavijesti.create' ? 'active' : '' }}">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                    Kreiraj obavijest
                </a>
                <a href="{{ route('member.termini.create') }}" class="sidebar-link {{ $currentRoute == 'member.termini.create' ? 'active' : '' }}">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                    Dodaj termin
                </a>
            </div>
            @endif

            <div class="sidebar-section" style="margin-top:1.5rem;">Postavke</div>

            <a href="{{ route('member.settings') }}" class="sidebar-link {{ $currentRoute == 'member.settings' ? 'active' : '' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06a1.65 1.65 0 001.82.33h0A1.65 1.65 0 0010 3.09V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51h0a1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82v0a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                Ciljevi treninga
            </a>

            <a href="{{ route('member.password') }}" class="sidebar-link {{ $currentRoute == 'member.password' ? 'active' : '' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                Promijeni lozinku
            </a>

            <form action="{{ route('member.logout') }}" method="POST" style="padding:8px 1.25rem 0;">
                @csrf
                <button type="submit" class="logout-btn" style="width:100%;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                    Odjava
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main wrapper -->
    <div class="main-wrap">
        <div class="topbar">
            <div class="topbar-left">
                <button class="hamburger" onclick="toggleSidebar()">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
                </button>
                <div class="topbar-logo">
                    <img src="{{ asset('site/img/logo.png') }}" alt="BEG's Fit&Fight">
                </div>
            </div>
        </div>
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebarOverlay').classList.toggle('active');
    }

    function toggleAdminMenu() {
        const toggle = document.getElementById('adminToggle');
        const menu = document.getElementById('adminMenu');
        toggle.classList.toggle('expanded');
        menu.classList.toggle('expanded');
    }
    </script>
    @else
    {{-- Guest layout (login/register) --}}
    @yield('content')
    @endif

    @yield('scripts')
</body>
</html>
