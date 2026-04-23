<!doctype html>
<html lang="bs">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BEG's Fit&Fight — Moderator Panel</title>
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

        .sidebar-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 998;
            opacity: 0; visibility: hidden;
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
            border-bottom: 1px solid rgba(255,55,95,0.15);
            text-align: center;
        }
        .sidebar-logo img { height: 40px; width: auto; }

        .sidebar-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex; align-items: center; gap: 14px;
        }
        .sidebar-avatar {
            width: 50px; height: 50px;
            border-radius: 50%; object-fit: cover;
            background: linear-gradient(135deg,#FF375F,#BF5AF2);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; color: #fff; font-size: 18px;
        }
        .sidebar-name { font-weight: 700; font-size: 15px; color: #fff; }
        .sidebar-role {
            font-size: 11px; color: #FF375F; font-weight: 600;
            text-transform: uppercase; letter-spacing: 1px;
        }

        .sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; }
        .sidebar-section {
            padding: 0 1.25rem; margin-bottom: 0.5rem;
            font-size: 10px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1.5px; color: rgba(255,55,95,0.4);
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 1.25rem;
            color: rgba(255,255,255,0.6);
            text-decoration: none; font-size: 14px; font-weight: 500;
            transition: all 0.2s; border-left: 3px solid transparent;
        }
        .sidebar-link:hover {
            background: rgba(255,55,95,0.08);
            color: #fff; border-left-color: rgba(255,55,95,0.3);
        }
        .sidebar-link.active {
            background: rgba(255,55,95,0.12);
            color: #FF375F; font-weight: 700;
            border-left-color: #FF375F;
        }
        .sidebar-link svg { flex-shrink: 0; }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.06);
        }
        .sidebar-footer .logout-btn {
            display: flex; align-items: center; gap: 10px;
            width: 100%; padding: 10px 14px;
            background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.15);
            color: #ef4444; border-radius: 12px;
            font-size: 13px; font-weight: 600; cursor: pointer;
            transition: all 0.2s;
        }
        .sidebar-footer .logout-btn:hover { background: rgba(239,68,68,0.15); }

        .topbar {
            position: sticky; top: 0; z-index: 100;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            padding: 10px 1.25rem;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid rgba(0,0,0,0.08);
        }
        .topbar-left { display: flex; align-items: center; gap: 14px; }
        .hamburger {
            background: none; border: none; color: #1a1a1a; cursor: pointer;
            padding: 4px; display: flex; align-items: center;
        }
        .topbar-logo img { height: 34px; width: auto; }
        .main-content { min-height: calc(100vh - 52px); padding: 1.25rem; }
        .glass-card {
            background: #fff;
            border: 1px solid rgba(0,0,0,0.06);
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .auth-card {
            background: #fff;
            border: 1px solid rgba(0,0,0,0.08);
            border-radius: 20px;
            padding: 2.5rem;
            max-width: 440px;
            margin: 0 auto;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        }
        .auth-card h2 { color: #1a1a1a; font-weight: 800; margin-bottom: 0.5rem; }
        .auth-card .subtitle { color: #888; font-size: 14px; margin-bottom: 2rem; }
        .auth-card label {
            color: #555; font-size: 13px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .auth-card .form-control {
            background: #f8f8f8;
            border: 1px solid #ddd;
            color: #1a1a1a; border-radius: 12px; padding: 12px 16px; font-size: 15px;
        }
        .auth-card .form-control:focus {
            background: #fff;
            border-color: #FF375F;
            box-shadow: 0 0 0 3px rgba(255,55,95,0.15);
            color: #1a1a1a;
        }
        .btn-mod {
            background: linear-gradient(135deg, #FF375F, #BF5AF2);
            border: none; color: #fff; font-weight: 700; font-size: 15px;
            padding: 12px; border-radius: 12px; width: 100%;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-mod:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255,55,95,0.35);
            color: #fff;
        }
        .alert-portal {
            background: rgba(220,53,69,0.08); border: 1px solid rgba(220,53,69,0.2);
            color: #dc3545; border-radius: 12px; padding: 12px 16px; font-size: 14px;
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
<body>
    @if(Auth::guard('moderator')->check())
    @php
        $authMod = Auth::guard('moderator')->user();
        $currentRoute = Route::currentRouteName();
    @endphp

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('site/img/logo.png') }}" alt="BEG's Fit&Fight">
        </div>
        <div class="sidebar-header">
            <div class="sidebar-avatar">
                {{ mb_substr($authMod->name,0,2) }}
            </div>
            <div>
                <div class="sidebar-name">{{ $authMod->name }}</div>
                <div class="sidebar-role">Moderator</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section" style="margin-top:0.5rem;">Upravljanje</div>

            <a href="{{ route('moderator.dashboard') }}" class="sidebar-link {{ $currentRoute == 'moderator.dashboard' ? 'active' : '' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Početna
            </a>
            <a href="{{ route('moderator.obavijesti') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'moderator.obavijesti') ? 'active' : '' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
                Obavijesti
            </a>
            <a href="{{ route('moderator.termini') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'moderator.termini') ? 'active' : '' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                Termini treninga
            </a>
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('moderator.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                    Odjava
                </button>
            </form>
        </div>
    </aside>

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
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" style="border-radius:12px;" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @yield('content')
        </div>
    </div>

    <script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebarOverlay').classList.toggle('active');
    }
    </script>
    @else
    @yield('content')
    @endif

    @yield('scripts')
</body>
</html>
