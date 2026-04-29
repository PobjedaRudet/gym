<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <!-- CSS only -->
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script type="text/javascript" src="{{ URL::asset('js/datepicker.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
        type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script> var base_url = "{{asset('/images/')}}"; </script>

</head>

<body style="background: #f5f6fa;">

    <style>
      .modern-navbar {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        padding: 0.6rem 1.5rem;
        box-shadow: 0 2px 15px rgba(0,0,0,0.15);
      }
      .modern-navbar .navbar-brand img {
        height: 34px;
        width: auto;
        max-width: 180px;
        object-fit: contain;
        border-radius: 10px;
      }
      .modern-navbar .nav-user {
        color: rgba(255,255,255,0.85);
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        transition: background 0.2s;
      }
      .modern-navbar .nav-user:hover {
        background: rgba(255,255,255,0.1);
        color: #fff;
      }
      .modern-navbar .dropdown-menu {
        border: none;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        padding: 0.5rem;
        margin-top: 0.5rem;
      }
      .modern-navbar .dropdown-item {
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        transition: background 0.15s;
      }
      .modern-navbar .dropdown-item:hover {
        background: #f0f0f5;
      }
      .modern-subnav {
        background: #fff;
        padding: 0.75rem 0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        flex-wrap: wrap;
      }
      .modern-subnav .subnav-link {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.45rem 1.1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        color: #495057;
        background: #f0f0f5;
        border: 1px solid transparent;
        transition: all 0.2s ease;
      }
      .modern-subnav .subnav-link:hover {
        background: #e8e8f0;
        color: #1a1a2e;
        transform: translateY(-1px);
      }
      .modern-subnav .subnav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border-color: transparent;
      }
      .modern-subnav .subnav-link.highlight {
        background: linear-gradient(135deg, #0d6efd 0%, #6ea8fe 100%);
        color: #fff;
      }
      .modern-subnav .subnav-link.disabled {
        opacity: 0.5;
        pointer-events: none;
        background: #dee2e6;
        color: #6c757d;
      }
    </style>

    <nav class="modern-navbar d-flex align-items-center justify-content-between">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('site/img/logo.png') }}" />
        </a>
        <div>
            @guest
                @if (Route::has('login'))
                    <a class="nav-user" href="{{ route('login') }}">{{ __('Login') }}</a>
                @endif
                @if (Route::has('register'))
                    <a class="nav-user" href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif
            @else
                <div class="dropdown d-inline-block">
                    <a class="nav-user dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24" style="opacity:0.7;vertical-align:-3px;margin-right:4px;"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        @if (Auth::user()->name == 'Admir' || Auth::user()->name == 'admin')
                            <a class="dropdown-item" href="{{ route('members') }}">Početna</a>
                          <a class="dropdown-item" href="{{ route('report') }}">Izvještaj</a>
                          <a class="dropdown-item" href="{{ route('comparison') }}">Detaljna statistika</a>
                            @if(Auth::user()->email === 'admin@begsfit.ba')
                            <hr class="dropdown-divider mx-2">
                            <a class="dropdown-item" href="{{ route('admin.portal.obavijesti') }}">Portal obavijesti</a>
                            <a class="dropdown-item" href="{{ route('admin.portal.termini') }}">Portal termini</a>
                            @endif
                            <hr class="dropdown-divider mx-2">
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        @else
                            <a class="dropdown-item" href="{{ route('members') }}">Početna</a>
                          <a class="dropdown-item" href="{{ route('report') }}">Izvještaj</a>
                          <a class="dropdown-item" href="{{ route('comparison') }}">Detaljna statistika</a>
                            <a class="dropdown-item text-danger" href="{{ route('odjaviNeaktivne') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Odjavi neaktivne
                            </a>
                            <hr class="dropdown-divider mx-2">
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        @endif
                    </div>
                </div>
            @endguest
        </div>
    </nav>

    <div class="modern-subnav">
        <a class="subnav-link {{ request()->routeIs('members') ? 'active' : '' }}" href="{{ route('members') }}">Članovi</a>
        <a class="subnav-link {{ request()->routeIs('createMember') ? 'active' : '' }}" href="{{ route('createMember') }}">Kreiraj člana</a>
        <a class="subnav-link {{ request()->routeIs('attendance-live') ? 'active' : '' }}" href="{{ route('attendance-live') }}">Evidencije live</a>
        <a class="subnav-link {{ request()->routeIs('attendance-list') ? 'active' : '' }}" href="{{ route('attendance-list') }}">Evidencije članova</a>
        <a class="subnav-link highlight" href="{{ route('attendance') }}">Prijava</a>
        <span class="subnav-link disabled">Admin</span>
    </div>

    <main class="py-4">
        @yield('content')
    </main>
    </div>
    <!-- Footer -->
    <footer style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); color: rgba(255,255,255,0.6); text-align:center; padding: 1.25rem; font-size: 0.85rem; margin-top: 2rem;">
        © {{ date('Y') }} <a href="http://begsfit-fight.ba" style="color:#fff;text-decoration:none;font-weight:600;">BEG'S FIT & FIGHT</a>
    </footer>
    <!-- Footer -->
</body>


</html>
