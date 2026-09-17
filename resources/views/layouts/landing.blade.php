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
           Ista paleta kao naslovna/about-us: akcent #ECD008 (zuta iz loga)
        ========================================================== */
        :root { --accent: #ECD008; --accent-2: #6b5100; --brand-yellow: #ECD008; }

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
            background: rgba(236, 208, 8, .12);
            border: 1px solid rgba(236, 208, 8, .4);
            color: var(--brand-yellow) !important;
            padding: 7px 18px;
            border-radius: 30px;
            font-size: 13px !important;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .hi-text h1 { letter-spacing: -1px; }
        .hi-text h1 strong { color: var(--brand-yellow); -webkit-text-fill-color: var(--brand-yellow); }
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
        .hero-stat-card .num span { color: var(--brand-yellow); }
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
            background: linear-gradient(135deg, var(--accent-2), #241b00);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 22px; box-shadow: 0 10px 24px rgba(184, 150, 11, .35);
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
        .ps-item.modern-price.featured { border: 1px solid rgba(236, 208, 8, .55); }
        .ps-item.modern-price .popular-badge {
            position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #111111; font-size: 11px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase;
            padding: 7px 18px; border-radius: 30px; box-shadow: 0 8px 18px rgba(236, 208, 8, .45); white-space: nowrap;
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
            background: rgba(236, 208, 8, .12); border: 1px solid rgba(236, 208, 8, .35);
            display: flex; align-items: center; justify-content: center; font-size: 20px; color: var(--accent);
        }

        /* --- Footer: prošireno na više kolona --- */
        .footer-section.modern-footer { background: #060606; padding: 70px 0 24px; text-align: left; }
        .footer-section.modern-footer .fw-title { color: #fff; font-size: 16px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 20px; }
        .footer-section.modern-footer p, .footer-section.modern-footer li { color: #a9a9a9; font-size: 14px; line-height: 2; }
        .footer-section.modern-footer ul { list-style: none; padding: 0; margin: 0; }
        .footer-section.modern-footer ul li a { color: #a9a9a9; transition: color .25s ease; }
        .footer-section.modern-footer ul li a:hover { color: var(--brand-yellow); }
        .footer-section.modern-footer .fw-social a {
            display: inline-flex; align-items: center; justify-content: center;
            width: 38px; height: 38px; border-radius: 50%; background: rgba(255, 255, 255, .06);
            color: #cfcfcf; margin-right: 10px; transition: all .25s ease;
        }
        .footer-section.modern-footer .fw-social a:hover { background: var(--accent); color: #111111; }
        .footer-section.modern-footer .fw-divider { border-top: 1px solid rgba(255, 255, 255, .08); margin: 40px 0 22px; }
        .footer-section.modern-footer .copyright-text { text-align: center; }
        .footer-section.modern-footer .copyright-text p { font-size: 13px; }

        /* --- "Sljedeći trening" kartica (inspirisano modernim gym/martial-arts predlošcima) --- */
        .next-training-wrap { position: relative; z-index: 6; margin-top: -110px; margin-bottom: 40px; }
        .next-training-card {
            position: relative; overflow: hidden;
            background:
                linear-gradient(90deg, rgba(26, 26, 26, .97) 0%, rgba(26, 26, 26, .92) 32%, rgba(26, 26, 26, .55) 62%, rgba(26, 26, 26, .22) 100%),
                url('{{ asset('site/img/gallery/gallery-1.jpg') }}') center/cover no-repeat;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 20px;
            padding: 44px 46px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, .45);
        }
        .next-training-card .ntc-decor {
            position: absolute; right: -90px; top: -90px; width: 340px; height: 340px;
            border-radius: 50%; pointer-events: none;
            background: repeating-radial-gradient(circle, rgba(236, 208, 8, .10) 0 2px, transparent 2px 28px);
        }
        .ntc-title {
            color: #fff; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;
            font-size: 26px; margin-bottom: 10px; position: relative;
        }
        .ntc-sub { color: #b7b7b7; font-size: 15px; margin-bottom: 24px; position: relative; max-width: 480px; }
        .ntc-meta { display: flex; flex-wrap: wrap; gap: 34px; position: relative; }
        .ntc-meta-item { display: flex; align-items: center; gap: 14px; }
        .ntc-icon {
            width: 48px; height: 48px; min-width: 48px; border-radius: 50%;
            background: rgba(255, 255, 255, .06); border: 1px solid rgba(255, 255, 255, .1);
            display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 18px;
        }
        .ntc-text { color: #eaeaea; font-weight: 700; font-size: 15px; }
        .ntc-btn {
            position: relative; margin-top: 26px; width: 100%; text-align: center;
        }
        @media (min-width: 992px) {
            .ntc-btn { margin-top: 0; width: auto; }
        }
        @media (max-width: 767px) {
            .next-training-wrap { margin-top: -60px; }
            .next-training-card { padding: 32px 24px; }
            .ntc-meta { gap: 20px; }
        }

        /* --- "Vijesti" - javne obavijesti / Facebook objave --- */
        .news-section.modern-section { background: #0a0a0a; }
        .news-card {
            background: #141414; border-radius: 16px; overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .05); cursor: pointer;
            transition: transform .35s ease, box-shadow .35s ease, background .35s ease;
            height: 100%; display: flex; flex-direction: column;
        }
        .news-card:hover { transform: translateY(-8px); background: #1a1a1a; box-shadow: 0 20px 40px rgba(0, 0, 0, .35); }
        .news-card .nc-img { width: 100%; height: 180px; object-fit: cover; display: block; background: #1a1a1a; }
        .news-card .nc-body { padding: 22px 24px 26px; flex: 1 1 auto; display: flex; flex-direction: column; }
        .news-card .nc-date { color: var(--brand-yellow); font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
        .news-card .nc-title { color: #fff; font-size: 18px; font-weight: 800; margin-bottom: 10px; line-height: 1.35; }
        .news-card .nc-excerpt { color: #a9a9a9; font-size: 14px; line-height: 1.7; flex: 1 1 auto; margin-bottom: 0; }
        .news-card .nc-more { color: var(--brand-yellow); font-size: 13px; font-weight: 700; margin-top: 16px; display: inline-flex; align-items: center; gap: 6px; }
        .news-empty { color: #a9a9a9; text-align: center; padding: 10px; }

        /* --- Detalj vijesti - modal --- */
        .news-modal-overlay {
            position: fixed; inset: 0; background: rgba(0, 0, 0, .75);
            opacity: 0; visibility: hidden; transition: opacity .3s ease, visibility .3s ease;
            z-index: 1300; display: flex; align-items: center; justify-content: center; padding: 24px;
        }
        .news-modal-overlay.active { opacity: 1; visibility: visible; }
        .news-modal {
            background: #141414; border: 1px solid rgba(255, 255, 255, .08); border-radius: 20px;
            max-width: 620px; width: 100%; max-height: 86vh; overflow-y: auto;
            box-shadow: 0 30px 70px rgba(0, 0, 0, .55);
            transform: translateY(30px); opacity: 0; transition: transform .35s ease, opacity .35s ease;
        }
        .news-modal-overlay.active .news-modal { transform: translateY(0); opacity: 1; }
        .news-modal .nm-img { width: 100%; max-height: 320px; object-fit: cover; display: block; }
        .news-modal .nm-body { padding: 28px 30px 32px; }
        .news-modal .nm-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 14px; }
        .news-modal .nm-date { color: var(--brand-yellow); font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .news-modal .nm-title { color: #fff; font-size: 22px; font-weight: 800; line-height: 1.3; margin: 0; }
        .news-modal .nm-close {
            width: 38px; height: 38px; min-width: 38px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255, 255, 255, .06); border: 1px solid rgba(255, 255, 255, .12);
            color: #eaeaea; cursor: pointer; transition: all .25s ease; font-size: 15px;
        }
        .news-modal .nm-close:hover { background: var(--accent); border-color: var(--accent); color: #111111; }
        .news-modal .nm-text { color: #cfcfcf; font-size: 15px; line-height: 1.8; white-space: pre-line; }
        body.news-modal-open { overflow: hidden; }
        @media (max-width: 480px) {
            .news-modal { border-radius: 14px; max-height: 92vh; }
            .news-modal .nm-body { padding: 22px 20px 26px; }
        }

        /* --- "Sljedeci termini" - klizni panel --- */
        .schedule-panel-overlay {
            position: fixed; inset: 0; background: rgba(0, 0, 0, .65);
            opacity: 0; visibility: hidden; transition: opacity .35s ease, visibility .35s ease;
            z-index: 1200;
        }
        .schedule-panel-overlay.active { opacity: 1; visibility: visible; }

        .schedule-panel {
            position: fixed; top: 0; right: 0; height: 100%; width: 420px; max-width: 92vw;
            background:
                linear-gradient(180deg, rgba(26, 26, 26, .65) 0%, rgba(26, 26, 26, .9) 26%, rgba(24, 24, 24, .98) 45%, #1a1a1a 60%),
                url('{{ asset('site/img/gallery/gallery-7.jpg') }}') top center/cover no-repeat;
            border-left: 1px solid rgba(255, 255, 255, .08);
            box-shadow: -30px 0 60px rgba(0, 0, 0, .5);
            z-index: 1201;
            transform: translateX(100%);
            transition: transform .4s cubic-bezier(.4, 0, .2, 1);
            display: flex; flex-direction: column;
        }
        .schedule-panel.active { transform: translateX(0); }

        .sp-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 28px 30px 20px; border-bottom: 1px solid rgba(255, 255, 255, .07);
        }
        .sp-header h3 {
            color: #fff; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;
            font-size: 20px; margin: 0;
        }
        .sp-close {
            width: 40px; height: 40px; min-width: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255, 255, 255, .06); border: 1px solid rgba(255, 255, 255, .12);
            color: #eaeaea; cursor: pointer; transition: all .25s ease; font-size: 16px;
        }
        .sp-close:hover { background: var(--accent); border-color: var(--accent); color: #111111; }

        .sp-body { flex: 1 1 auto; overflow-y: auto; padding: 24px 30px; }
        .sp-day { margin-bottom: 26px; }
        .sp-day:last-child { margin-bottom: 0; }
        .sp-day-title {
            color: var(--brand-yellow); text-transform: uppercase; font-weight: 700; letter-spacing: 1px;
            font-size: 13px; margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid rgba(255, 255, 255, .08);
        }
        .sp-chip {
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
            background: rgba(255, 255, 255, .04); border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 12px; padding: 14px 16px; margin-bottom: 10px; transition: all .25s ease;
        }
        .sp-chip:hover { background: rgba(236, 208, 8, .1); border-color: rgba(236, 208, 8, .35); }
        .sp-chip-name { color: #eee; font-weight: 700; font-size: 14px; }
        .sp-chip-time { color: var(--brand-yellow); font-weight: 700; font-size: 13px; white-space: nowrap; margin-left: 10px; }
        .sp-empty { color: #a9a9a9; font-size: 14px; text-align: center; padding: 50px 10px; }

        .sp-footer { padding: 22px 30px 28px; border-top: 1px solid rgba(255, 255, 255, .07); }
        .sp-footer .primary-btn { width: 100%; text-align: center; }

        body.schedule-panel-open { overflow: hidden; }

        @media (max-width: 480px) {
            .schedule-panel { width: 100%; max-width: 100%; }
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
                <li><a class="{{ request()->routeIs('begsfit') ? 'active' : '' }}" href="{{ route('begsfit') }}"><i class="fa fa-home"></i>Početna</a></li>
                <li><a href="{{ route('about-us') }}"><i class="fa fa-info-circle"></i>O nama</a></li>
                <li><a href="./classes.html"><i class="fa fa-calendar"></i>Treninzi</a></li>
                <li><a href="./services.html"><i class="fa fa-star"></i>Usluge</a></li>
                <li><a href="./team.html"><i class="fa fa-users"></i>Naš tim</a></li>
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

    <!-- Next Training Section Begin -->
    <div class="next-training-wrap reveal">
        <div class="container">
            <div class="next-training-card">
                <div class="ntc-decor"></div>
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <h3 class="ntc-title">Sljedeći trening</h3>
                        @if($sljedeciTermin)
                            <p class="ntc-sub">{{ $sljedeciTermin['termin']->naziv }}</p>
                        @else
                            <p class="ntc-sub">Novi termini treninga se uskoro objavljuju - pratite nas ili nas kontaktirajte za detalje.</p>
                        @endif
                        <div class="ntc-meta">
                            <div class="ntc-meta-item">
                                <span class="ntc-icon"><i class="fa fa-hourglass-half"></i></span>
                                <span class="ntc-text">
                                    @if($sljedeciTermin)
                                        {{ $sljedeciTermin['danNaziv'] }}: {{ $sljedeciTermin['kada']->format('H:i') }}
                                    @else
                                        Uskoro
                                    @endif
                                </span>
                            </div>
                            <div class="ntc-meta-item">
                                <span class="ntc-icon"><i class="fa fa-calendar"></i></span>
                                <span class="ntc-text">
                                    @if($sljedeciTermin)
                                        {{ $sljedeciTermin['datumNaziv'] }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 text-lg-right">
                        <a href="#" class="primary-btn btn-normal ntc-btn" id="openSchedulePanel">Provjeri raspored</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Next Training Section End -->

    @if($vijesti->count())
    <!-- Vijesti Section Begin -->
    <section class="news-section modern-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title reveal">
                        <span>Novosti</span>
                        <h2>VIJESTI I OBAVJESTI</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($vijesti as $v)
                    <div class="col-lg-4 col-md-6 reveal">
                        <div class="news-card"
                             data-news-open
                             data-title="{{ $v->naslov }}"
                             data-text="{{ $v->sadrzaj }}"
                             data-date="{{ $v->created_at ? $v->created_at->translatedFormat('d.m.Y.') : '' }}"
                             data-img="{{ $v->slika ? asset('images/obavijesti/' . $v->slika) : '' }}"
                             tabindex="0" role="button">
                            @if($v->slika)
                                <img class="nc-img" src="{{ asset('images/obavijesti/' . $v->slika) }}" alt="{{ $v->naslov }}">
                            @endif
                            <div class="nc-body">
                                <div class="nc-date">{{ $v->created_at ? $v->created_at->translatedFormat('d.m.Y.') : '' }}</div>
                                <h4 class="nc-title">{{ $v->naslov }}</h4>
                                <p class="nc-excerpt">{{ \Illuminate\Support\Str::limit($v->sadrzaj, 120) }}</p>
                                <span class="nc-more">Procitaj vise <i class="fa fa-long-arrow-right"></i></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Vijesti Section End -->
    @endif

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
    <div class="gettouch-section modern-touch" id="kontakt">
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

    <!-- Sljedeci termini Panel Begin -->
    <div class="schedule-panel-overlay" id="schedulePanelOverlay"></div>
    <div class="schedule-panel" id="schedulePanel" aria-hidden="true">
        <div class="sp-header">
            <h3>Sljedeci termini</h3>
            <div class="sp-close" id="schedulePanelClose"><i class="fa fa-close"></i></div>
        </div>
        <div class="sp-body">
            @if(count($sedmicniRaspored ?? []))
                @foreach($sedmicniRaspored as $dan)
                    <div class="sp-day">
                        <div class="sp-day-title">{{ $dan['danNaziv'] }}</div>
                        @foreach($dan['stavke'] as $stavka)
                            <div class="sp-chip">
                                <span class="sp-chip-name">{{ $stavka->naziv }}</span>
                                <span class="sp-chip-time">{{ \Carbon\Carbon::parse($stavka->vrijeme_od)->format('H:i') }} - {{ \Carbon\Carbon::parse($stavka->vrijeme_do)->format('H:i') }}</span>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @else
                <p class="sp-empty">Novi termini treninga se uskoro objavljuju - pratite nas ili nas kontaktirajte za detalje.</p>
            @endif
        </div>
        <div class="sp-footer">
            <a href="#kontakt" class="primary-btn btn-normal" id="schedulePanelContact">Kontaktiraj nas</a>
        </div>
    </div>
    <!-- Sljedeci termini Panel End -->

    <!-- Vijesti Modal Begin -->
    <div class="news-modal-overlay" id="newsModalOverlay">
        <div class="news-modal" id="newsModal">
            <img class="nm-img" id="newsModalImg" src="" alt="" style="display:none;">
            <div class="nm-body">
                <div class="nm-header">
                    <div>
                        <div class="nm-date" id="newsModalDate"></div>
                        <h3 class="nm-title" id="newsModalTitle"></h3>
                    </div>
                    <div class="nm-close" id="newsModalClose"><i class="fa fa-close"></i></div>
                </div>
                <div class="nm-text" id="newsModalText"></div>
            </div>
        </div>
    </div>
    <!-- Vijesti Modal End -->

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

    <script>
        // Klizni panel "Sljedeci termini"
        (function () {
            var openBtn = document.getElementById('openSchedulePanel');
            var closeBtn = document.getElementById('schedulePanelClose');
            var overlay = document.getElementById('schedulePanelOverlay');
            var panel = document.getElementById('schedulePanel');
            if (!openBtn || !panel || !overlay) return;

            function openPanel(e) {
                if (e) e.preventDefault();
                panel.classList.add('active');
                overlay.classList.add('active');
                panel.setAttribute('aria-hidden', 'false');
                document.body.classList.add('schedule-panel-open');
            }

            function closePanel() {
                panel.classList.remove('active');
                overlay.classList.remove('active');
                panel.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('schedule-panel-open');
            }

            openBtn.addEventListener('click', openPanel);
            if (closeBtn) closeBtn.addEventListener('click', closePanel);
            overlay.addEventListener('click', closePanel);
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && panel.classList.contains('active')) closePanel();
            });

            var contactBtn = document.getElementById('schedulePanelContact');
            if (contactBtn) {
                contactBtn.addEventListener('click', function () { closePanel(); });
            }
        })();
    </script>

    <script>
        // Vijesti - modal za detalj obavijesti
        (function () {
            var overlay = document.getElementById('newsModalOverlay');
            if (!overlay) return;
            var modalImg = document.getElementById('newsModalImg');
            var modalDate = document.getElementById('newsModalDate');
            var modalTitle = document.getElementById('newsModalTitle');
            var modalText = document.getElementById('newsModalText');
            var closeBtn = document.getElementById('newsModalClose');

            function openModal(card) {
                var img = card.getAttribute('data-img');
                if (img) {
                    modalImg.src = img;
                    modalImg.style.display = 'block';
                } else {
                    modalImg.removeAttribute('src');
                    modalImg.style.display = 'none';
                }
                modalDate.textContent = card.getAttribute('data-date') || '';
                modalTitle.textContent = card.getAttribute('data-title') || '';
                modalText.textContent = card.getAttribute('data-text') || '';
                overlay.classList.add('active');
                document.body.classList.add('news-modal-open');
            }

            function closeModal() {
                overlay.classList.remove('active');
                document.body.classList.remove('news-modal-open');
            }

            document.querySelectorAll('[data-news-open]').forEach(function (card) {
                card.addEventListener('click', function () { openModal(card); });
                card.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openModal(card); }
                });
            });

            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) closeModal();
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && overlay.classList.contains('active')) closeModal();
            });
        })();
    </script>

</body>

</html>
