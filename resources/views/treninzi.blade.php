<!DOCTYPE html>
<html lang="bs">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Raspored treninga - BEG'S FIT&FIGHT, fitness centar i kik boks klub u Goraždu">
    <meta name="keywords" content="Gym, treninzi, raspored, teretana, kik boks, Goražde, Beg's fitness">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Treninzi - BEG'S FIT&FIGHT</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900|Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('site/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('site/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('site/css/flaticon.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('site/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('site/css/style.css') }}" type="text/css">

    <style>
        /* --- Moderni dodaci za "Treninzi" stranicu (ista paleta: #ECD008 - zuta iz loga) --- */
        .reveal { opacity: 0; transform: translateY(26px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }
        .reveal.d1.is-visible { transition-delay: .08s; }
        .reveal.d2.is-visible { transition-delay: .16s; }
        .reveal.d3.is-visible { transition-delay: .24s; }

        .raspored-section { background: #0a0a0a; padding: 90px 0 100px; }
        .raspored-empty {
            color: #a9a9a9; text-align: center; padding: 60px 20px; font-size: 15px;
            background: #141414; border-radius: 16px; border: 1px solid rgba(255,255,255,.06);
        }

        .raspored-day {
            background: #141414; border-radius: 16px; border: 1px solid rgba(255, 255, 255, .05);
            padding: 26px 26px 22px; margin-bottom: 24px; height: 100%;
            transition: transform .3s ease, background .3s ease;
        }
        .raspored-day:hover { transform: translateY(-6px); background: #1a1a1a; }
        .raspored-day-title {
            color: #ECD008; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;
            font-size: 15px; margin-bottom: 18px; padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }
        .raspored-chip {
            background: rgba(255, 255, 255, .04); border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 12px; padding: 14px 16px; margin-bottom: 12px; transition: all .25s ease;
        }
        .raspored-chip:last-child { margin-bottom: 0; }
        .raspored-chip:hover { background: rgba(236, 208, 8, .1); border-color: rgba(236, 208, 8, .35); }
        .raspored-chip-top { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .raspored-chip-name { color: #eee; font-weight: 700; font-size: 15px; }
        .raspored-chip-time { color: #ECD008; font-weight: 700; font-size: 13px; white-space: nowrap; margin-left: 10px; }
        .raspored-chip-desc { color: #a9a9a9; font-size: 13px; margin-top: 6px; margin-bottom: 0; line-height: 1.6; }

        .raspored-cta { background: linear-gradient(135deg, #6b5100, #241b00); padding: 55px 0; text-align: center; margin-top: 10px; }
        .raspored-cta h3 { color: #fff; font-size: 26px; font-weight: 800; margin-bottom: 10px; }
        .raspored-cta p { color: rgba(255,255,255,.92); margin-bottom: 22px; }
        .raspored-cta .primary-btn { background: #111; color: #fff; margin: 0 6px; }
        .raspored-cta .primary-btn:hover { background: #000; }
        .raspored-cta .primary-btn.ghost { background: transparent; border: 2px solid rgba(255,255,255,.5); }
        .raspored-cta .primary-btn.ghost:hover { background: #fff; color: #111; border-color: #fff; }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Section Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas-logo">
            <img src="{{ asset('site/img/logo.png') }}" alt="">
        </div>
        <div class="canvas-close">
            <i class="fa fa-close"></i>
        </div>
        <div class="canvas-search search-switch">
            <i class="fa fa-search"></i>
        </div>
        <nav class="canvas-menu mobile-menu">
            <ul>
                <li><a href="{{ route('begsfit') }}"><i class="fa fa-home"></i>Početna</a></li>
                <li><a href="{{ route('about-us') }}"><i class="fa fa-info-circle"></i>O nama</a></li>
                <li><a class="active" href="{{ route('treninzi') }}"><i class="fa fa-calendar"></i>Treninzi</a></li>
                <li><a href="{{ route('usluge') }}"><i class="fa fa-star"></i>Usluge</a></li>
                <li><a href="{{ route('team') }}"><i class="fa fa-users"></i>Naš tim</a></li>
                <li><a href="{{ route('galerija') }}"><i class="fa fa-picture-o"></i>Galerija</a></li>
                <li><a href="{{ route('kontakt') }}"><i class="fa fa-envelope"></i>Kontakt</a></li>
                <li><a class="nav-link" href="{{ route('portal-info') }}"><i class="fa fa-user-circle"></i>Portal za članove</a></li>

            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="canvas-social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-youtube-play"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
    </div>
    <!-- Offcanvas Menu Section End -->

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="logo">
                        <a href="{{ route('begsfit') }}">
                            <img src="{{ asset('site/img/logo.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="nav-menu">
                        <ul>
                            <li><a href="{{ route('begsfit') }}">Početna</a></li>
                            <li><a href="{{ route('about-us') }}">O nama</a></li>
                            <li class="active"><a href="{{ route('treninzi') }}">Treninzi</a></li>
                            <li><a href="{{ route('usluge') }}">Usluge</a></li>
                            <li><a href="{{ route('team') }}">Naš tim</a></li>
                            <li><a href="{{ route('galerija') }}">Galerija</a></li>
                            <li><a href="{{ route('kontakt') }}">Kontakt</a></li>
                            <li><a class="nav-link" href="{{ route('portal-info') }}">Portal za članove</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="top-option">
                        <div class="to-search search-switch">
                            <i class="fa fa-search"></i>
                        </div>
                        <div class="to-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="canvas-open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('site/img/breadcrumb-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Treninzi</h2>
                        <div class="bt-option">
                            <a href="{{ route('begsfit') }}">Početna</a>
                            <span>Treninzi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Raspored Section Begin -->
    <section class="raspored-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title reveal">
                        <span>Sedmični raspored</span>
                        <h2>RASPORED TRENINGA</h2>
                    </div>
                </div>
            </div>

            @if(count($sedmicniRaspored ?? []))
                <div class="row">
                    @foreach($sedmicniRaspored as $dan)
                        <div class="col-lg-4 col-md-6 reveal">
                            <div class="raspored-day">
                                <div class="raspored-day-title">{{ $dan['danNaziv'] }}</div>
                                @foreach($dan['stavke'] as $stavka)
                                    <div class="raspored-chip">
                                        <div class="raspored-chip-top">
                                            <span class="raspored-chip-name">{{ $stavka->naziv }}</span>
                                            <span class="raspored-chip-time">{{ \Carbon\Carbon::parse($stavka->vrijeme_od)->format('H:i') }} - {{ \Carbon\Carbon::parse($stavka->vrijeme_do)->format('H:i') }}</span>
                                        </div>
                                        @if($stavka->opis)
                                            <p class="raspored-chip-desc">{{ $stavka->opis }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <p class="raspored-empty">Novi termini treninga se uskoro objavljuju - pratite nas ili nas kontaktirajte za detalje.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Raspored Section End -->

    <!-- Raspored CTA Begin -->
    <div class="raspored-cta">
        <div class="container">
            <h3>Spremni za prvi trening?</h3>
            <p>Postani član i prijavi se na termine koji ti odgovaraju, ili nas kontaktiraj za više informacija.</p>
            <a href="{{ route('portal-info') }}" class="primary-btn btn-normal">Portal za članove</a>
            <a href="{{ route('kontakt') }}" class="primary-btn btn-normal ghost">Kontaktiraj nas</a>
        </div>
    </div>
    <!-- Raspored CTA End -->

    <!-- Get In Touch Section Begin -->
    <div class="gettouch-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-map-marker"></i>
                        <p>Zaima Imamovića<br/> br. 29</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-mobile"></i>
                        <ul>
                            <li>+387 38 941 900</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gt-text email">
                        <i class="fa fa-envelope"></i>
                        <p>info@begsfit-fight.ba</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Get In Touch Section End -->

    <!-- Footer Section Begin -->
    <section class="footer-section">
        <div class="container">

            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="copyright-text">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This website is made  by <a href="https://begsfit.ba" target="_blank">BEG'S FITNESS</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="{{ asset('site/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('site/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('site/js/main.js') }}"></script>

    <script>
        // Moderni "reveal on scroll" efekat za "Treninzi" stranicu
        (function () {
            var els = document.querySelectorAll('.reveal');
            if (!('IntersectionObserver' in window)) {
                els.forEach(function (el) { el.classList.add('is-visible'); });
                return;
            }
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });
            els.forEach(function (el) { io.observe(el); });
        })();
    </script>

</body>

</html>
