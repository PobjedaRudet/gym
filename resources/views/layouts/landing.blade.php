<!DOCTYPE html>
<html lang="bs">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gym Template">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BEG'S FIT&FIGHT</title>

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
        /* =======================================================
           MODERNI SLOJ - naslovna stranica (dodatak preko style.css)
           Ista paleta kao naslovna/about-us: akcent #f36100
        ========================================================== */
        :root { --accent: #f36100; --accent-2: #ff8a3d; }

        html { scroll-behavior: smooth; }

        .reveal { opacity: 0; transform: translateY(28px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }
        .reveal.d1.is-visible { transition-delay: .08s; }
        .reveal.d2.is-visible { transition-delay: .16s; }
        .reveal.d3.is-visible { transition-delay: .24s; }
        .reveal.d4.is-visible { transition-delay: .32s; }

        /* --- Header: fiksni, staklo-efekat nakon skrola --- */
        .header-section { position: fixed; transition: background .35s ease, padding .35s ease, box-shadow .35s ease; }
        .header-section.scrolled {
            background: rgba(10, 10, 10, 0.85);
            -webkit-backdrop-filter: blur(14px);
            backdrop-filter: blur(14px);
            padding-top: 16px;
            padding-bottom: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .35);
        }

        /* --- Hero: moderniji naglasak i staklene stat-kartice --- */
        .hi-text span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(243, 97, 0, .12);
            border: 1px solid rgba(243, 97, 0, .4);
            color: var(--accent-2) !important;
            padding: 7px 18px;
            border-radius: 30px;
            font-size: 13px !important;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .hi-text h1 { letter-spacing: -1px; }
        .hi-text h1 strong { color: var(--accent); -webkit-text-fill-color: var(--accent); }
        .hi-text .hero-sub { color: #d8d8d8; font-size: 16px; max-width: 460px; margin: 18px 0 26px; line-height: 1.7; }
        .hi-text .hero-btns { display: flex; flex-wrap: wrap; gap: 14px; align-items: center; }
        .hi-text .btn-ghost {
            display: inline-block; padding: 15px 34px; border-radius: 6px;
            border: 2px solid rgba(255, 255, 255, .35); color: #fff; font-weight: 700;
            font-size: 14px; text-transform: uppercase; letter-spacing: .5px; transition: all .3s ease;
        }
        .hi-text .btn-ghost:hover { background: #fff; color: #111; border-color: #fff; }

        .hero-stats { position: absolute; right: 6%; bottom: 15%; display: flex; flex-direction: column; gap: 16px; z-index: 5; }
        .hero-stat-card {
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .18);
            -webkit-backdrop-filter: blur(12px);
            backdrop-filter: blur(12px);
            border-radius: 14px;
            padding: 16px 26px;
            min-width: 190px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .25);
        }
        .hero-stat-card .num { font-family: 'Oswald', sans-serif; font-size: 30px; font-weight: 700; color: #fff; line-height: 1; }
        .hero-stat-card .num span { color: var(--accent); }
        .hero-stat-card .lbl { color: #cfcfcf; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-top: 4px; }

        .scroll-cue {
            position: absolute; left: 50%; bottom: 30px; transform: translateX(-50%);
            width: 26px; height: 42px; border: 2px solid rgba(255, 255, 255, .45); border-radius: 20px; z-index: 5;
        }
        .scroll-cue::before {
            content: ""; position: absolute; top: 8px; left: 50%; width: 4px; height: 8px;
            background: var(--accent); border-radius: 3px; transform: translateX(-50%);
            animation: scrollCue 1.6s infinite;
        }
        @keyframes scrollCue { 0% { opacity: 1; top: 8px; } 70% { opacity: 0; top: 20px; } 100% { opacity: 0; top: 8px; } }

        @media (max-width: 991px) {
            .hero-stats { display: none; }
        }

        /* --- ChoseUs: kartice sa ikonicom u krugu --- */
        .choseus-section.modern-section { background: #0a0a0a; }
        .cs-item.modern-card {
            background: #141414; border-radius: 16px; padding: 40px 28px 32px;
            transition: transform .35s ease, box-shadow .35s ease, background .35s ease;
            border: 1px solid rgba(255, 255, 255, .05);
        }
        .cs-item.modern-card:hover { transform: translateY(-8px); background: #1a1a1a; box-shadow: 0 20px 40px rgba(0, 0, 0, .35); }
        .cs-icon-badge {
            width: 70px; height: 70px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), #c94e00);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 22px; box-shadow: 0 10px 24px rgba(243, 97, 0, .35);
        }
        .cs-icon-badge span { font-size: 30px; color: #fff; display: block; }
        .cs-item.modern-card:hover span { color: #fff; }
        .cs-item.modern-card h4 { margin-top: 4px; }

        /* --- Klase / "Šta nudimo": zaobljene slike + zoom na hover --- */
        .class-item.modern-card { border-radius: 16px; overflow: hidden; }
        .class-item.modern-card .ci-pic { border-radius: 16px; overflow: hidden; }
        .class-item.modern-card .ci-pic img { transition: transform .6s ease; }
        .class-item.modern-card:hover .ci-pic img { transform: scale(1.1); }

        /* --- Banner: tamniji overlay za bolji kontrast + veći CTA --- */
        .banner-section.modern-banner { position: relative; }
        .banner-section.modern-banner::before {
            content: ""; position: absolute; inset: 0;
            background: linear-gradient(120deg, rgba(0,0,0,.82), rgba(20,10,0,.55));
        }
        .banner-section.modern-banner .container { position: relative; z-index: 2; }
        .banner-section.modern-banner .bs-text h2 { font-size: 42px; }
        .banner-section.modern-banner .primary-btn { display: inline-flex; align-items: center; gap: 10px; }

        /* --- Cjenovnik: modernije kartice, kvačice, "najpopularnije" --- */
        .pricing-section.modern-section { background: #0a0a0a; }
        .ps-item.modern-price {
            border-radius: 18px; position: relative; overflow: visible;
            border: 1px solid rgba(255, 255, 255, .06);
            transition: transform .35s ease, box-shadow .35s ease;
        }
        .ps-item.modern-price:hover { transform: translateY(-10px); box-shadow: 0 24px 50px rgba(0, 0, 0, .4); }
        .ps-item.modern-price.featured { border: 1px solid rgba(243, 97, 0, .55); }
        .ps-item.modern-price .popular-badge {
            position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #fff; font-size: 11px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase;
            padding: 7px 18px; border-radius: 30px; box-shadow: 0 8px 18px rgba(243, 97, 0, .45); white-space: nowrap;
        }
        .ps-item.modern-price ul li { position: relative; padding-left: 22px; }
        .ps-item.modern-price ul li::before {
            content: "\f00c"; font-family: "FontAwesome"; position: absolute; left: 0; top: 2px;
            color: var(--accent); font-size: 12px;
        }

        /* --- Galerija: hover zoom + zatamnjenje --- */
        .gs-item.modern-gallery { border-radius: 14px; overflow: hidden; transition: transform .4s ease; }
        .gs-item.modern-gallery:hover { transform: scale(1.02); }
        .gs-item.modern-gallery .thumb-icon { transition: all .3s ease; }

        /* --- Tim: blaga elevacija na hover --- */
        .ts-item.modern-team { border-radius: 16px; overflow: hidden; transition: transform .4s ease, box-shadow .4s ease; }
        .ts-item.modern-team:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0, 0, 0, .4); }

        /* --- Kontakt traka: kružne ikonice --- */
        .gettouch-section.modern-touch { background: #0d0d0d; padding: 55px 0; }
        .gettouch-section.modern-touch .gt-text {
            display: flex; align-items: center; gap: 16px; justify-content: center;
        }
        .gettouch-section.modern-touch .gt-text i {
            width: 52px; height: 52px; min-width: 52px; border-radius: 50%;
            background: rgba(243, 97, 0, .12); border: 1px solid rgba(243, 97, 0, .35);
            display: flex; align-items: center; justify-content: center; font-size: 20px; color: var(--accent);
        }

        /* --- Footer: prošireno na više kolona --- */
        .footer-section.modern-footer { background: #060606; padding: 70px 0 24px; text-align: left; }
        .footer-section.modern-footer .fw-title { color: #fff; font-size: 16px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 20px; }
        .footer-section.modern-footer p, .footer-section.modern-footer li { color: #a9a9a9; font-size: 14px; line-height: 2; }
        .footer-section.modern-footer ul { list-style: none; padding: 0; margin: 0; }
        .footer-section.modern-footer ul li a { color: #a9a9a9; transition: color .25s ease; }
        .footer-section.modern-footer ul li a:hover { color: var(--accent); }
        .footer-section.modern-footer .fw-social a {
            display: inline-flex; align-items: center; justify-content: center;
            width: 38px; height: 38px; border-radius: 50%; background: rgba(255, 255, 255, .06);
            color: #cfcfcf; margin-right: 10px; transition: all .25s ease;
        }
        .footer-section.modern-footer .fw-social a:hover { background: var(--accent); color: #fff; }
        .footer-section.modern-footer .fw-divider { border-top: 1px solid rgba(255, 255, 255, .08); margin: 40px 0 22px; }
        .footer-section.modern-footer .copyright-text { text-align: center; }
        .footer-section.modern-footer .copyright-text p { font-size: 13px; }
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
        <div class="canvas-close">
            <i class="fa fa-close"></i>
        </div>
        <div class="canvas-search search-switch">
            <i class="fa fa-search"></i>
        </div>
        <nav class="canvas-menu mobile-menu">
            <ul>
                <li><a href="{{ route('begsfit') }}">Početna</a></li>
                <li><a href="{{ route('about-us') }}">O nama</a></li>
                <li><a href="./classes.html">Treninzi</a></li>
                <li><a href="./services.html">Usluge</a></li>
                <li><a href="./team.html">Naš tim</a></li>
                <li><a href="./contact.html">Kontakt</a></li>
                <li><a class="nav-link" href="{{ route('portal-info') }}">Portal za članove</a></li>

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
    <header class="header-section" id="siteHeader">
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
                            <li class="{{ request()->routeIs('begsfit') ? 'active' : '' }}"><a href="{{ route('begsfit') }}">Početna</a></li>
                            <li><a href="{{ route('about-us') }}">O nama</a></li>
                            <li><a href="./class-details.html">Treninzi</a></li>
                            <li><a href="./services.html">Usluge</a></li>
                            <li><a href="./team.html">Naš tim</a></li>
                            <li><a href="./contact.html">Kontakt</a></li>
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

    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="hs-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="{{ asset('site/img/hero/hero-1.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7 offset-lg-7">
                            <div class="hi-text">
                                <span><i class="fa fa-bolt"></i> Fitness &amp; Kik boks centar - Goražde</span>
                                <h1>Budi<strong> jak</strong>, treniraj snažno</h1>
                                <p class="hero-sub">Moderna teretana, kik boks klub sa licenciranim trenerima i zajednica koja te gura naprijed - sve na jednom mjestu.</p>
                                <div class="hero-btns">
                                    <a href="{{ route('about-us') }}" class="primary-btn">Više informacija</a>
                                    <a href="#pricing" class="btn-ghost">Pogledaj članarine</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hs-item set-bg" data-setbg="{{ asset('site/img/hero/hero-2.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-6">
                            <div class="hi-text">
                                <span><i class="fa fa-bolt"></i> Fitness &amp; Kik boks centar - Goražde</span>
                                <h1>Budi <strong>jak</strong>, treniraj snažno</h1>
                                <p class="hero-sub">Moderna teretana, kik boks klub sa licenciranim trenerima i zajednica koja te gura naprijed - sve na jednom mjestu.</p>
                                <div class="hero-btns">
                                    <a href="{{ route('about-us') }}" class="primary-btn">Više informacija</a>
                                    <a href="#pricing" class="btn-ghost">Pogledaj članarine</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-stats">
            <div class="hero-stat-card">
                <div class="num"><span>1800+</span></div>
                <div class="lbl">Registrovanih članova</div>
            </div>
            <div class="hero-stat-card">
                <div class="num"><span>3</span></div>
                <div class="lbl">Licencirana trenera</div>
            </div>
        </div>
        <div class="scroll-cue"></div>
    </section>
    <!-- Hero Section End -->

    <!-- ChoseUs Section Begin -->
    <section class="choseus-section modern-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title reveal">
                        <span>Zašto izabrati nas?</span>
                        <h2>POMJERITE SVOJE GRANICE</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6 reveal d1">
                    <div class="cs-item modern-card">
                        <div class="cs-icon-badge"><span class="flaticon-034-stationary-bike"></span></div>
                        <h4>Moderna oprema</h4>
                        <p>U našem fitness centru nudimo vrhunske sprave za vježbanje i stručne trenere.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 reveal d2">
                    <div class="cs-item modern-card">
                        <div class="cs-icon-badge"><span class="flaticon-033-juice"></span></div>
                        <h4>Beg's caffe</h4>
                        <p>Poseban prostor za opuštanje i osvježenje - naš kafić i dječija igraonica. Smješten unutar samog centra, kafić i igraonica su idealno mjesto za sve koji žele odmor i ugodnu atmosferu.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 reveal d3">
                    <div class="cs-item modern-card">
                        <div class="cs-icon-badge"><span class="flaticon-002-dumbell"></span></div>
                        <h4>Kik boks club - treninzi</h4>
                        <p>
Uz našu standardnu ponudu, s ponosom ističemo da u sklopu fitness centra posjedujemo i kik boks klub. Ovaj prostor je namijenjen za sve ljubitelje borilačkih sportova, bilo da ste početnik ili iskusan borac.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 reveal d4">
                    <div class="cs-item modern-card">
                        <div class="cs-icon-badge"><span class="flaticon-014-heart-beat"></span></div>
                        <h4>Zdrava ishrana</h4>
                        <p>Svi naši proizvodi su pažljivo odabrani kako bi podržali zdrav životni stil i pomogli vam da izgledate i osjećate se najbolje. </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ChoseUs Section End -->

    <!-- Classes Section Begin -->
    <section class="classes-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title reveal">
                        <span>Treninzi</span>
                        <h2>Šta nudimo</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 reveal d1">
                    <div class="class-item modern-card">
                        <div class="ci-pic">
                            <img src="{{ asset('site/img/classes/class-1.jpg') }}" alt="">
                        </div>
                        <div class="ci-text">
                            <span>FITNESS CENTAR</span>
                            <h5>SPRAVE ZA VJEŽBANJE</h5>
                            <a href="{{ route('about-us') }}"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal d2">
                    <div class="class-item modern-card">
                        <div class="ci-pic">
                            <img src="{{ asset('site/img/classes/class-2.jpg') }}" alt="">
                        </div>
                        <div class="ci-text">
                            <span>KIK BOKS CLUB</span>
                            <h5>BEZ KONTAKTNI I KONTAKTNI</h5>
                            <a href="{{ route('about-us') }}"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal d3">
                    <div class="class-item modern-card">
                        <div class="ci-pic">
                            <img src="{{ asset('site/img/hero/hero-2.jpg') }}" alt="">
                        </div>
                        <div class="ci-text">
                            <span>LADIES FITNESS</span>
                            <h5>poseban objekat za žene opremljen je najnovijim spravama</h5>
                            <a href="{{ route('about-us') }}"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 reveal d1">
                    <div class="class-item modern-card">
                        <div class="ci-pic">
                            <img src="{{ asset('site/img/classes/Screenshot_quad.jpg') }}" alt="">
                        </div>
                        <div class="ci-text">
                            <span>QUAD</span>
                            <h4>RENT A QUAD</h4>
                            <a href="{{ route('about-us') }}"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 reveal d2">
                    <div class="class-item modern-card">
                        <div class="ci-pic">
                            <img src="{{ asset('site/img/classes/apartmani-rawda-foto-3-scaled.jpg') }}" alt="">
                        </div>
                        <div class="ci-text">
                            <span>RENT A APARTMENT</span>
                            <h4>Iznajmite jedan od naših apartmana</h4>
                            <a href="{{ route('about-us') }}"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ChoseUs Section End -->

    <!-- Banner Section Begin -->
    <section class="banner-section modern-banner set-bg" data-setbg="{{ asset('site/img/banner-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="bs-text reveal">
                        <h2>Za više informacija</h2>
                        <div class="bt-tips">Gdje se zdravlje, ljepota i izgleda upoznaju.</div>
                        <a href="{{ route('about-us') }}" class="primary-btn btn-normal">Više informacija <i class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Pricing Section Begin -->
    <section id="pricing" class="pricing-section modern-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title reveal">
                        <span>Članarine</span>
                        <h2>Našim članovima nudimo</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-8 reveal d1">
                    <div class="ps-item modern-price">
                        <h3>Dječija članarina</h3>
                        <div class="pi-price">
                            <h2>KM 30.00</h2>
                            <span>Za mališane
                        </div>
                        <ul>
                            <li>Namjenjen djeci do 15 godina</li>
                            <li>Uključuje redovne kik-boks treninge prilagođen uzrastu</li>
                            <li>Fokus na razvoju koordinacije, kondicije i discipline kroz zabavne i interaktivne vježbe</li>
                            <li>Profesionalni treneri sa iskustvon u radu sa djecom</li>
                            <li>Ideslno za mališane kiji žele aktivno provoditi slobodno vrijeme i razvijati sportsku vještinu</li>
                        </ul>
                        <a href="{{ route('about-us') }}" class="primary-btn pricing-btn">Učlani se</a>
                        <a href="#" class="thumb-icon"><i class="fa fa-picture-o"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 reveal d2">
                    <div class="ps-item modern-price">
                        <h3>Đačka članarina</h3>
                        <div class="pi-price">
                            <h2>KM 40.00</h2>
                            <span>Korištenje teretana mjesec dana</span>
                        </div>
                        <ul>
                            <li>Namjenjen maloljetnicima od 14 do 18 godina</li>
                            <li>Uključuje neograničen pristup teretani</li>
                            <li>Mogućnost sudjelovanja u kik-boks treninzima bez dodatnih troškova</li>
                            <li>Programi prilagođeni uzrastu i kondicionim sposobnostima</li>
                            <li>Poseban fokus na jačanju izdržljivosti, snage i mentalne discipline</li>
                        </ul>
                        <a href="{{ route('about-us') }}" class="primary-btn pricing-btn">Učlani se</a>
                        <a href="#" class="thumb-icon"><i class="fa fa-picture-o"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 reveal d3">
                    <div class="ps-item modern-price featured">
                        <span class="popular-badge">Najpopularnije</span>
                        <h3>Članarina za odrasle</h3>
                        <div class="pi-price">
                            <h2>KM 50.00</h2>
                            <span>Korištenje teretane mjesec dana</span>
                        </div>
                        <ul>
                            <li>Neograničen pristup teretani</li>
                            <li>Uključuje opciju sudjelovanja kik-boks treninzima za rekreativce</li>
                            <li>Idealno za one koji žele kombinovati vježbe snage i borilačke sportove</li>
                            <li>Treninzi pod nadzorom licenciranih instruktora</li>
                            <li>Savršeno za poboljšanje kondicije, redukciju stresa i izgradnju samopouzdanja</li>
</ul>
                        <a href="{{ route('about-us') }}" class="primary-btn pricing-btn">Učlani se</a>
                        <a href="#" class="thumb-icon"><i class="fa fa-picture-o"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 reveal d1">
                    <div class="ps-item modern-price">
                        <h3>Članarina za penzionere</h3>
                        <div class="pi-price">
                            <h2>KM 40.00</h2>
                            <span>Korištenje teretana mjesec dana</span>
                        </div>
                        <ul>
                            <li>Namjenjen osobama u penziji koji žele održavati zdravlje i kondiciju</li>
                            <li>Uključuje pristup teretani i prilagođene treninge</li>
                            <li>Fokus na lagane vježbe, fleksibilnost i rehabilitaciju</li>
                            <li>Idealna prilika za socijalizaciju i aktivan stil života</li></ul>
                        <a href="{{ route('about-us') }}" class="primary-btn pricing-btn">Učlani se</a>
                        <a href="#" class="thumb-icon"><i class="fa fa-picture-o"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 reveal d2">
                    <div class="ps-item modern-price">
                        <h3>Dnevna karta</h3>
                        <div class="pi-price">
                            <h2>KM 15.00</h2>
                            <span>Jednodnevni pristup svim sadržajima teretane</span>
                        </div>
                        <ul>
                            <li>pogodna opcija za povremene korisnike ili one koji žele isprobati ponudu</li>
                            <li>uključuje pristup grupnim treninzima ili individualno korištenje opreme</li>
                            <li>Fleksibilan izbor za ljude sa ograničenim rasporedom</li>
</ul>
                        <a href="{{ route('about-us') }}" class="primary-btn pricing-btn">Učlani se</a>
                        <a href="#" class="thumb-icon"><i class="fa fa-picture-o"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 reveal d3">
                    <div class="ps-item modern-price">
                        <h3>Sponsorship</h3>
                        <div class="pi-price">
                            <h2>KM **</h2>
                            <span>Namjenjen sportskim klubovima i kompanijama</span>
                        </div>
                        <ul>
                            <li>Namjenjen grupama od 10 ili više članova</li>
                            <li>Uključuje pristup teretani i mogućnost zakazivanja gruonih treninga</li>
                            <li>Dodatni popust za timove ili grupe</li>
                            <li>Prilagođeni termini za treninge i mogućnost korištenja prostora za timske aktivnosti</li>





                        </ul>
                        <a href="{{ route('about-us') }}" class="primary-btn pricing-btn">Saznaj više</a>
                        <a href="#" class="thumb-icon"><i class="fa fa-picture-o"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Pricing Section End -->

    <!-- Gallery Section Begin -->
    <div class="gallery-section">
        <div class="gallery">
            <div class="grid-sizer"></div>
            <div class="gs-item modern-gallery grid-wide set-bg" data-setbg="{{ asset('site/img/gallery/teretana.jpg') }}">
                <a href="{{ asset('site/img/gallery/teretana.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item modern-gallery set-bg" data-setbg="{{ asset('site/img/gallery/sampion.jpg') }}">
                <a href="{{ asset('site/img/gallery/sampion.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item modern-gallery set-bg" data-setbg="{{ asset('site/img/gallery/latte.jpg') }}">
                <a href="{{ asset('site/img/gallery/gallery-3.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item modern-gallery set-bg" data-setbg="{{ asset('site/img/gallery/igraonavanjska.jpg') }}">
                <a href="{{ asset('site/img/gallery/igraonavanjska.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item modern-gallery set-bg" data-setbg="{{ asset('site/img/gallery/sank.jpg') }}">
                <a href="{{ asset('site/img/gallery/sank.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item modern-gallery grid-wide set-bg" data-setbg="{{ asset('site/img/gallery/begstim.jpg') }}">
                <a href="{{ asset('site/img/gallery/begstim.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
            </div>
        </div>
    </div>
    <!-- Gallery Section End -->

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
        </div>
    </section>
    <!-- Team Section End -->

    <!-- Get In Touch Section Begin -->
    <div class="gettouch-section modern-touch">
        <div class="container">
            <div class="row">
                <div class="col-md-4 reveal d1">
                    <div class="gt-text">
                        <i class="fa fa-map-marker"></i>
                        <p>Zaima Imamovića<br/> br. 29</p>
                    </div>
                </div>
                <div class="col-md-4 reveal d2">
                    <div class="gt-text">
                        <i class="fa fa-mobile"></i>
                        <ul>
                            <li>+387 38 941 900</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 reveal d3">
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
    <section class="footer-section modern-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 reveal">
                    <div class="fw-title">BEG'S FIT&amp;FIGHT</div>
                    <p>Fitness centar i kik boks klub u Goraždu - teretana, treninzi za sve uzraste, Beg's caffe i dječija igraonica na jednom mjestu.</p>
                    <div class="fw-social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-youtube-play"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 reveal d1">
                    <div class="fw-title">Stranica</div>
                    <ul>
                        <li><a href="{{ route('begsfit') }}">Početna</a></li>
                        <li><a href="{{ route('about-us') }}">O nama</a></li>
                        <li><a href="#pricing">Članarine</a></li>
                        <li><a href="{{ route('login') }}">Prijava</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 reveal d2">
                    <div class="fw-title">Sadržaji</div>
                    <ul>
                        <li>Teretana</li>
                        <li>Kik boks klub</li>
                        <li>Ladies fitness</li>
                        <li>Beg's caffe &amp; igraonica</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 reveal d3">
                    <div class="fw-title">Kontakt</div>
                    <ul>
                        <li><i class="fa fa-map-marker"></i>&nbsp; Zaima Imamovića br. 29, Goražde</li>
                        <li><i class="fa fa-mobile"></i>&nbsp; +387 38 941 900</li>
                        <li><i class="fa fa-envelope"></i>&nbsp; info@begsfit-fight.ba</li>
                    </ul>
                </div>
            </div>

            <div class="fw-divider"></div>

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
        // Moderni dodaci: staklo-header na skrol + reveal-on-scroll
        (function () {
            var header = document.getElementById('siteHeader');
            function onScroll() {
                if (!header) return;
                if (window.scrollY > 60) { header.classList.add('scrolled'); }
                else { header.classList.remove('scrolled'); }
            }
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();

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
            }, { threshold: 0.12 });
            els.forEach(function (el) { io.observe(el); });
        })();
    </script>

</body>

</html>
