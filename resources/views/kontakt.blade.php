<!DOCTYPE html>
<html lang="bs">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Kontakt - BEG'S FIT&FIGHT, fitness centar i kik boks klub u Goraždu">
    <meta name="keywords" content="Gym, kontakt, teretana, kik boks, Goražde, Beg's fitness">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kontakt - BEG'S FIT&FIGHT</title>

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
        /* --- Kontakt stranica: koristi istu paletu kao naslovna/O nama: #ECD008 (zuta iz loga) --- */
        .reveal { opacity: 0; transform: translateY(26px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }

        .contact-section-modern { background: #000; padding: 100px 0; }
        .contact-title-block .section-title { text-align: left; margin-bottom: 20px; }
        .contact-hero-text { color: #b7b7b7; font-size: 15px; line-height: 1.8; max-width: 520px; margin-bottom: 30px; }

        .form-alert-success { background: #122010; border: 1px solid #1e3a17; color: #8fd67f; border-radius: 10px; padding: 14px 18px; margin-bottom: 22px; font-size: 14px; }
        .form-alert-error { background: #2a1010; border: 1px solid #3a1717; color: #f28b8b; border-radius: 10px; padding: 14px 18px; margin-bottom: 22px; font-size: 14px; }

        .contact-form-card { background: #151515; border-radius: 16px; padding: 40px 36px; }
        .contact-form-card .row-2 { display: flex; gap: 18px; flex-wrap: wrap; }
        .contact-form-card .row-2 .form-group { flex: 1 1 200px; }
        .contact-form-card .form-group { margin-bottom: 20px; }
        .contact-form-card label { display: block; color: #cfcfcf; font-size: 12px; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 8px; font-weight: 700; }
        .contact-form-card .form-control {
            width: 100%; height: auto; background: #0d0d0d; border: 1px solid #2a2a2a; border-radius: 10px;
            padding: 13px 16px; color: #fff; font-size: 14px; transition: border-color .25s ease;
        }
        .contact-form-card select.form-control { cursor: pointer; }
        .contact-form-card .form-control:focus { outline: none; border-color: #ECD008; }
        .contact-form-card textarea.form-control { resize: vertical; min-height: 130px; }
        .contact-submit-btn { width: 100%; border: none; cursor: pointer; }

        .info-card { background: #151515; border-radius: 16px; padding: 30px 32px; margin-bottom: 24px; }
        .info-card h4 { color: #fff; text-transform: uppercase; font-size: 15px; letter-spacing: .5px; margin-bottom: 20px; font-weight: 800; }
        .info-row { display: flex; align-items: flex-start; gap: 16px; margin-bottom: 20px; }
        .info-row:last-child { margin-bottom: 0; }
        .info-row .info-icon {
            width: 46px; height: 46px; min-width: 46px; border-radius: 50%;
            background: rgba(236, 208, 8, .1); border: 1px solid rgba(236, 208, 8, .3);
            display: flex; align-items: center; justify-content: center; color: #ECD008; font-size: 18px;
        }
        .info-row .info-text strong { display: block; color: #fff; font-size: 12px; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 4px; }
        .info-row .info-text span { color: #b7b7b7; font-size: 14px; line-height: 1.6; }

        .hours-group { margin-bottom: 18px; }
        .hours-group:last-child { margin-bottom: 0; }
        .hours-group h5 { color: #ECD008; font-size: 13px; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 10px; font-weight: 700; }
        .hours-row { display: flex; justify-content: space-between; padding: 7px 0; border-bottom: 1px solid #232323; font-size: 13px; }
        .hours-row:last-child { border-bottom: none; }
        .hours-row span:first-child { color: #b7b7b7; }
        .hours-row span:last-child { color: #fff; font-weight: 600; }

        .social-row { display: flex; gap: 12px; }
        .social-row a {
            width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            background: rgba(255, 255, 255, .06); color: #cfcfcf; transition: all .25s ease; font-size: 16px;
        }
        .social-row a:hover { background: #ECD008; color: #111111; }

        @media (max-width: 991px) {
            .contact-section-modern { padding: 70px 0; }
            .contact-form-card { padding: 30px 24px; }
        }
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
                <li><a class="active" href="{{ route('kontakt') }}"><i class="fa fa-envelope"></i>Kontakt</a></li>
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
                            <li class="active"><a href="{{ route('kontakt') }}">Kontakt</a></li>
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
                        <h2>Kontakt</h2>
                        <div class="bt-option">
                            <a href="{{ route('begsfit') }}">Početna</a>
                            <span>Kontakt</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Section Begin -->
    <section class="contact-section-modern">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 reveal">
                    <div class="contact-title-block">
                        <div class="section-title">
                            <span>Kontakt</span>
                            <h2>Kontaktirajte Nas</h2>
                        </div>
                    </div>
                    <p class="contact-hero-text">Imate pitanje ili želite rezervisati besplatan probni trening? Kontaktirajte nas putem forme ili nas posjetite na našoj lokaciji.</p>

                    @if(session('success'))
                        <div class="form-alert-success"><i class="fa fa-check-circle"></i>&nbsp; {{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="form-alert-error"><i class="fa fa-exclamation-circle"></i>&nbsp; {{ $errors->first() }}</div>
                    @endif

                    <div class="contact-form-card">
                        <form method="POST" action="{{ route('kontakt.submit') }}">
                            @csrf
                            {{-- Honeypot: sakriveno od ljudi, botovi ga popunjavaju i time se odaju --}}
                            <div aria-hidden="true" style="position:absolute;left:-9999px;top:-9999px;height:0;overflow:hidden;">
                                <label for="website">Ne popunjavajte ovo polje</label>
                                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                            </div>
                            <div class="row-2">
                                <div class="form-group">
                                    <label for="ime_prezime">Ime i prezime</label>
                                    <input type="text" class="form-control" id="ime_prezime" name="ime_prezime" value="{{ old('ime_prezime') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email adresa</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="row-2">
                                <div class="form-group">
                                    <label for="telefon">Telefon</label>
                                    <input type="text" class="form-control" id="telefon" name="telefon" value="{{ old('telefon') }}">
                                </div>
                                <div class="form-group">
                                    <label for="predmet">Predmet</label>
                                    <select class="form-control" id="predmet" name="predmet" required>
                                        <option value="" disabled {{ old('predmet') ? '' : 'selected' }}>Izaberite predmet</option>
                                        <option value="Članstvo" {{ old('predmet') == 'Članstvo' ? 'selected' : '' }}>Članstvo</option>
                                        <option value="Besplatan probni trening" {{ old('predmet') == 'Besplatan probni trening' ? 'selected' : '' }}>Besplatan probni trening</option>
                                        <option value="Personalni trening" {{ old('predmet') == 'Personalni trening' ? 'selected' : '' }}>Personalni trening</option>
                                        <option value="Kikboks treninzi" {{ old('predmet') == 'Kikboks treninzi' ? 'selected' : '' }}>Kikboks treninzi</option>
                                        <option value="Cafe bar" {{ old('predmet') == 'Cafe bar' ? 'selected' : '' }}>Cafe bar</option>
                                        <option value="Ostalo" {{ old('predmet') == 'Ostalo' ? 'selected' : '' }}>Ostalo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="poruka">Poruka</label>
                                <textarea class="form-control" id="poruka" name="poruka" required>{{ old('poruka') }}</textarea>
                            </div>
                            <button type="submit" class="primary-btn btn-normal contact-submit-btn">Pošalji poruku</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5 reveal">
                    <div class="info-card">
                        <h4>Kontakt informacije</h4>
                        <div class="info-row">
                            <div class="info-icon"><i class="fa fa-map-marker"></i></div>
                            <div class="info-text">
                                <strong>Adresa</strong>
                                <span>Zaima Imamovića 22, 73000 Goražde, Bosna i Hercegovina</span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><i class="fa fa-phone"></i></div>
                            <div class="info-text">
                                <strong>Telefon</strong>
                                <span>+387 38 941 900</span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><i class="fa fa-envelope"></i></div>
                            <div class="info-text">
                                <strong>Email</strong>
                                <span>besgfitandfight@hotmail.com</span>
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h4>Radno vrijeme</h4>
                        <div class="hours-group">
                            <h5>Teretana</h5>
                            <div class="hours-row"><span>Pon - Pet</span><span>06:30 - 22:00</span></div>
                            <div class="hours-row"><span>Subota</span><span>09:00 - 21:00</span></div>
                            <div class="hours-row"><span>Nedjelja</span><span>09:00 - 21:00</span></div>
                        </div>
                        <div class="hours-group">
                            <h5>Cafe Bar</h5>
                            <div class="hours-row"><span>Pon - Pet</span><span>06:30 - 22:30</span></div>
                            <div class="hours-row"><span>Subota</span><span>08:00 - 22:00</span></div>
                            <div class="hours-row"><span>Nedjelja</span><span>08:00 - 22:00</span></div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h4>Pratite nas</h4>
                        <div class="social-row">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

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
        // Moderni "reveal on scroll" efekat za Kontakt stranicu
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
