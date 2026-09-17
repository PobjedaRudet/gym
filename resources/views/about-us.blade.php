<!DOCTYPE html>
<html lang="bs">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="O nama - BEG'S FIT&FIGHT, fitness centar i kik boks klub u Goraždu">
    <meta name="keywords" content="Gym, o nama, teretana, kik boks, Goražde, Beg's fitness">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>O nama - BEG'S FIT&FIGHT</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('site/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('site/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('site/css/flaticon.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('site/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('site/css/barfiller.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('site/css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('site/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('site/css/style.css') }}" type="text/css">

    <style>
        /* --- Moderni dodaci za "O nama" stranicu (koristi istu paletu kao naslovna: #ECD008 - zuta iz loga) --- */
        .reveal { opacity: 0; transform: translateY(26px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }

        .about-section { background: #000; }
        .about-video.set-bg { border-radius: 0; }

        .stats-strip { background: #0d0d0d; padding: 55px 0; border-top: 1px solid #1c1c1c; border-bottom: 1px solid #1c1c1c; }
        .stat-card { text-align: center; padding: 10px 15px; }
        .stat-card .num { font-size: 40px; font-weight: 800; color: #ECD008; line-height: 1; margin-bottom: 8px; font-family: 'Oswald', sans-serif; }
        .stat-card .lbl { color: #c4c4c4; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; }

        .value-card { background: #151515; border-radius: 14px; padding: 34px 26px; height: 100%; transition: transform .3s ease, background .3s ease; }
        .value-card:hover { transform: translateY(-6px); background: #1b1b1b; }
        .value-card .vc-icon { font-size: 30px; color: #ECD008; margin-bottom: 16px; }
        .value-card h4 { color: #fff; text-transform: uppercase; font-size: 15px; margin-bottom: 10px; letter-spacing: .5px; }
        .value-card p { color: #b7b7b7; font-size: 13px; margin: 0; line-height: 1.6; }

        .space-card { position: relative; border-radius: 14px; overflow: hidden; height: 250px; margin-bottom: 24px; display: block; }
        .space-card img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; display: block; }
        .space-card:hover img { transform: scale(1.08); }
        .space-card .sc-caption { position: absolute; left: 0; right: 0; bottom: 0; padding: 18px 20px; background: linear-gradient(0deg, rgba(0,0,0,.85), rgba(0,0,0,0)); color: #fff; font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: .6px; }

        .about-cta { background: linear-gradient(135deg, #6b5100, #241b00); padding: 55px 0; text-align: center; }
        .about-cta h3 { color: #fff; font-size: 26px; font-weight: 800; margin-bottom: 10px; }
        .about-cta p { color: rgba(255,255,255,.92); margin-bottom: 22px; }
        .about-cta .primary-btn { background: #111; color: #fff; }
        .about-cta .primary-btn:hover { background: #000; }

        .about-intro-section { background: #0d0d0d; padding: 90px 0 40px; }
        .about-intro-text p { color: #b7b7b7; font-size: 15px; line-height: 1.9; margin-bottom: 18px; }
        .about-intro-text p:last-child { margin-bottom: 0; }
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
                <li><a class="active" href="{{ route('about-us') }}"><i class="fa fa-info-circle"></i>O nama</a></li>
                <li><a href="{{ route('treninzi') }}"><i class="fa fa-calendar"></i>Treninzi</a></li>
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
                            <li class="active"><a href="{{ route('about-us') }}">O nama</a></li>
                            <li><a href="{{ route('treninzi') }}">Treninzi</a></li>
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
                        <h2>O nama</h2>
                        <div class="bt-option">
                            <a href="{{ route('begsfit') }}">Početna</a>
                            <span>O nama</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- O Nama Intro Section Begin -->
    <section class="about-intro-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 text-center reveal">
                    <div class="section-title">
                        <span>Ko smo mi</span>
                        <h2>O Nama</h2>
                    </div>
                    <div class="about-intro-text">
                        <p>Beg's fit&amp;fight je osnovan 2022. godine s ciljem da postane vodeći fitness i borilački centar u regiji. Naša misija je pružiti vrhunske usluge i stvoriti zajednicu posvećenu zdravom načinu života.</p>
                        <p>Naš tim čine profesionalni treneri i instruktori s višegodišnjim iskustvom u borilačkim vještinama. Ponosni smo na našu modernu opremu i prostorije koje pružaju idealne uvjete za trening.</p>
                        <p>Uz teretanu i kikboks, naš kompleks uključuje i cafe bar gdje možete uživati u zdravim napicima i obrocima nakon treninga, družiti se s prijateljima ili jednostavno se opustiti u ugodnoj atmosferi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- O Nama Intro Section End -->

    <!-- About Section Begin -->
    <section class="about-section">
        <div class="row no-gutters">
            <div class="col-lg-6">
                <div class="about-video set-bg" data-setbg="{{ asset('site/img/about-us.jpg') }}"></div>
            </div>
            <div class="col-lg-6">
                <div class="about-text">
                    <div class="section-title">
                        <span>Naša priča</span>
                        <h2>Mjesto gdje snaga upoznaje disciplinu</h2>
                    </div>
                    <div class="at-desc">
                        <p>BEG'S FIT & FIGHT je fitness centar smješten u Goraždu, na adresi Zaima Imamovića br. 29, koji na jednom mjestu okuplja ljubitelje rekreacije, fitnessa i borilačkih sportova. Uz moderno opremljenu teretanu, u sklopu centra djeluje i kik boks klub pod vodstvom licenciranih trenera, poseban prostor za žene, dječija igraonica i Beg's caffe za odmor nakon treninga.</p>
                        <p>Naš cilj je jednostavan: da svakom članu, bez obzira na godine i nivo pripremljenosti, pružimo siguran prostor za napredak - uz stručno vodstvo, kvalitetnu opremu i podršku zajednice.</p>
                    </div>
                    <div class="about-bar">
                        <div class="ab-item">
                            <p>Fitness &amp; kondicioni treninzi</p>
                            <div class="barfiller" id="bar1">
                                <span class="fill" data-percentage="95"></span>
                                <span class="tip"></span>
                            </div>
                        </div>
                        <div class="ab-item">
                            <p>Kik boks klub</p>
                            <div class="barfiller" id="bar2">
                                <span class="fill" data-percentage="90"></span>
                                <span class="tip"></span>
                            </div>
                        </div>
                        <div class="ab-item">
                            <p>Podrška i praćenje napretka članova</p>
                            <div class="barfiller" id="bar3">
                                <span class="fill" data-percentage="98"></span>
                                <span class="tip"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- Stats Strip Begin -->
    <div class="stats-strip">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-3 stat-card reveal">
                    <div class="num">1800+</div>
                    <div class="lbl">Registrovanih članova</div>
                </div>
                <div class="col-6 col-md-3 stat-card reveal">
                    <div class="num">3</div>
                    <div class="lbl">Licencirana trenera</div>
                </div>
                <div class="col-6 col-md-3 stat-card reveal">
                    <div class="num">5</div>
                    <div class="lbl">Programa i sadržaja</div>
                </div>
                <div class="col-6 col-md-3 stat-card reveal">
                    <div class="num">7/7</div>
                    <div class="lbl">Dana u sedmici otvoreno</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Stats Strip End -->

    <!-- Values Section Begin -->
    <section class="choseus-section spad" style="background:#0a0a0a;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Naše vrijednosti</span>
                        <h2>Zašto trenirati sa nama</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6 reveal">
                    <div class="value-card">
                        <div class="vc-icon"><i class="fa fa-shield"></i></div>
                        <h4>Sigurnost prije svega</h4>
                        <p>Nadzirano okruženje i oprema koja se redovno održava.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 reveal">
                    <div class="value-card">
                        <div class="vc-icon"><i class="fa fa-users"></i></div>
                        <h4>Zajednica</h4>
                        <p>Podržavamo jedni druge - od prvog treninga do takmičenja.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 reveal">
                    <div class="value-card">
                        <div class="vc-icon"><i class="fa fa-line-chart"></i></div>
                        <h4>Mjerljiv napredak</h4>
                        <p>Pratimo dolaske i ciljeve svakog člana kroz portal za članove.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 reveal">
                    <div class="value-card">
                        <div class="vc-icon"><i class="fa fa-heart"></i></div>
                        <h4>Zdrav stil života</h4>
                        <p>Od djece do penzionera - program prilagođen svakoj generaciji.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Values Section End -->

    <!-- Naši prostori Section Begin -->
    <section class="classes-section spad" style="background:#111;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Pogledajte</span>
                        <h2>Naši prostori</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="space-card">
                        <img src="{{ asset('site/img/gallery/teretana.jpg') }}" alt="Teretana">
                        <div class="sc-caption">Teretana</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="space-card">
                        <img src="{{ asset('site/img/gallery/latte.jpg') }}" alt="Beg's caffe">
                        <div class="sc-caption">Beg's caffe</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="space-card">
                        <img src="{{ asset('site/img/gallery/igraonavanjska.jpg') }}" alt="Dječija igraonica">
                        <div class="sc-caption">Dječija igraonica</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Naši prostori Section End -->

    <!-- Team Section Begin -->
    <section class="team-section team-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="team-title">
                        <div class="section-title">
                            <span>Naš tim</span>
                            <h2>Trenirajte sa profesionalcima</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="ts-item set-bg" data-setbg="{{ asset('site/img/team/emir.jpg') }}">
                        <div class="ts_text">
                            <h4>Emir Begović</h4>
                            <span>Licencirani kik boks trener</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ts-item set-bg" data-setbg="{{ asset('site/img/team/lejs.jpg') }}">
                        <div class="ts_text">
                            <h4>Lejs Begović</h4>
                            <span>Licencirani kik boks trener</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ts-item set-bg" data-setbg="{{ asset('site/img/team/adnan.jpg') }}">
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

    <!-- About CTA Begin -->
    <div class="about-cta">
        <div class="container">
            <h3>Spremni da napravite prvi korak?</h3>
            <p>Posjetite nas na adresi Zaima Imamovića br. 29, Goražde, ili nas kontaktirajte za više informacija o članarinama.</p>
            <a href="{{ route('begsfit') }}" class="primary-btn btn-normal">Nazad na početnu</a>
        </div>
    </div>
    <!-- About CTA End -->

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
    <script src="{{ asset('site/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('site/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('site/js/masonry.pkgd.min.js') }}"></script>
    <script src="{{ asset('site/js/jquery.barfiller.js') }}"></script>
    <script src="{{ asset('site/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('site/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('site/js/main.js') }}"></script>

    <script>
        // Moderni "reveal on scroll" efekat za "O nama" stranicu
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
