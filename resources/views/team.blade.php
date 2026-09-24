<!DOCTYPE html>
<html lang="bs">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Naš tim - BEG'S FIT&FIGHT, fitness centar i kik boks klub u Goraždu">
    <meta name="keywords" content="Gym, tim, treneri, kik boks, teretana, Goražde, Beg's fitness">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Naš tim - BEG'S FIT&FIGHT</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900|Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="@assetv('site/css/bootstrap.min.css')" type="text/css">
    <link rel="stylesheet" href="@assetv('site/css/font-awesome.min.css')" type="text/css">
    <link rel="stylesheet" href="@assetv('site/css/flaticon.css')" type="text/css">
    <link rel="stylesheet" href="@assetv('site/css/slicknav.min.css')" type="text/css">
    <link rel="stylesheet" href="@assetv('site/css/style.css')" type="text/css">

    <style>
        /* --- Moderni dodaci za "Naš tim" stranicu (ista paleta: #ECD008 - zuta iz loga) --- */
        .reveal { opacity: 0; transform: translateY(26px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }
        .reveal.d1.is-visible { transition-delay: .08s; }
        .reveal.d2.is-visible { transition-delay: .16s; }
        .reveal.d3.is-visible { transition-delay: .24s; }

        .team-intro-section { background: #0d0d0d; padding: 90px 0 20px; }
        .team-intro-text { text-align: center; max-width: 700px; margin: 0 auto; }
        .team-intro-text p { color: #b7b7b7; font-size: 15px; line-height: 1.9; margin: 0; }

        .ts-item.modern-team { border-radius: 16px; overflow: hidden; transition: transform .4s ease, box-shadow .4s ease; }
        .ts-item.modern-team:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0, 0, 0, .4); }

        .team-cta { background: linear-gradient(135deg, #6b5100, #241b00); padding: 55px 0; text-align: center; }
        .team-cta h3 { color: #fff; font-size: 26px; font-weight: 800; margin-bottom: 10px; }
        .team-cta p { color: rgba(255,255,255,.92); margin-bottom: 22px; }
        .team-cta .primary-btn { background: #111; color: #fff; margin: 0 6px; }
        .team-cta .primary-btn:hover { background: #000; }
        .team-cta .primary-btn.ghost { background: transparent; border: 2px solid rgba(255,255,255,.5); }
        .team-cta .primary-btn.ghost:hover { background: #fff; color: #111; border-color: #fff; }
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
                <li><a href="{{ route('treninzi') }}"><i class="fa fa-calendar"></i>Treninzi</a></li>
                <li><a href="{{ route('usluge') }}"><i class="fa fa-star"></i>Usluge</a></li>
                <li><a class="active" href="{{ route('team') }}"><i class="fa fa-users"></i>Naš tim</a></li>
                <li><a href="{{ route('galerija') }}"><i class="fa fa-picture-o"></i>Galerija</a></li>
                <li><a href="{{ route('kontakt') }}"><i class="fa fa-envelope"></i>Kontakt</a></li>
                <li><a class="nav-link" href="{{ route('portal-info') }}"><i class="fa fa-user-circle"></i>Portal za članove</a></li>

            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="canvas-social">
            <a href="https://www.facebook.com/beg.s.fit.fight/" target="_blank" rel="noopener"><i class="fa fa-facebook"></i></a>
            <a href="https://www.instagram.com/begsfitandfight/" target="_blank" rel="noopener"><i class="fa fa-instagram"></i></a>
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
                            <li><a href="{{ route('treninzi') }}">Treninzi</a></li>
                            <li><a href="{{ route('usluge') }}">Usluge</a></li>
                            <li class="active"><a href="{{ route('team') }}">Naš tim</a></li>
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
                            <a href="https://www.facebook.com/beg.s.fit.fight/" target="_blank" rel="noopener"><i class="fa fa-facebook"></i></a>
                            <a href="https://www.instagram.com/begsfitandfight/" target="_blank" rel="noopener"><i class="fa fa-instagram"></i></a>
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
                        <h2>Naš tim</h2>
                        <div class="bt-option">
                            <a href="{{ route('begsfit') }}">Početna</a>
                            <span>Naš tim</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Team Intro Section Begin -->
    <section class="team-intro-section">
        <div class="container">
            <div class="team-intro-text reveal">
                <p>Naš tim čine profesionalni treneri i instruktori s višegodišnjim iskustvom u borilačkim vještinama, posvećeni tvom napretku i sigurnom, kvalitetnom treningu.</p>
            </div>
        </div>
    </section>
    <!-- Team Intro Section End -->

    <!-- Team Section Begin -->
    <section class="team-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="team-title reveal">
                        <div class="section-title">
                            <span>Naš tim</span>
                            <h2>Trenirajte sa profesionalcima</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 reveal d1">
                    <div class="ts-item modern-team set-bg" data-setbg="{{ asset('site/img/team/emir.jpg') }}">
                        <div class="ts_text">
                            <h4>Emir Begović</h4>
                            <span>Licencirani kik boks trener</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 reveal d2">
                    <div class="ts-item modern-team set-bg" data-setbg="{{ asset('site/img/team/lejs.jpg') }}">
                        <div class="ts_text">
                            <h4>Lejs Begović</h4>
                            <span>Licencirani kik boks trener</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 reveal d3">
                    <div class="ts-item modern-team set-bg" data-setbg="{{ asset('site/img/team/adnan.jpg') }}">
                        <div class="ts_text">
                            <h4>Adnan Kadić</h4>
                            <span>Kik boks trener</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->

    <!-- Team CTA Begin -->
    <div class="team-cta">
        <div class="container">
            <h3>Upoznaj tim uživo</h3>
            <p>Dođi na trening ili nas kontaktiraj za više informacija o programima i terminima.</p>
            <a href="{{ route('treninzi') }}" class="primary-btn btn-normal">Raspored treninga</a>
            <a href="{{ route('kontakt') }}" class="primary-btn btn-normal ghost">Kontaktiraj nas</a>
        </div>
    </div>
    <!-- Team CTA End -->

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
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This website is made  by <a href="https://begsfit-fight.ba/" target="_blank">BEG'S FITNESS</a>
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

    @include('partials.back-to-top')

    <!-- Js Plugins -->
    <script src="@assetv('site/js/jquery-3.3.1.min.js')"></script>
    <script src="@assetv('site/js/jquery.slicknav.js')"></script>
    <script src="@assetv('site/js/main.js')"></script>

    <script>
        // Moderni "reveal on scroll" efekat za "Naš tim" stranicu
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
