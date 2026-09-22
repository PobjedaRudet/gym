<!DOCTYPE html>
<html lang="bs">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Usluge - BEG'S FIT&FIGHT. Teretana, kik boks klub, Ladies Fitness, iznajmljivanje quadova i apartmana, članarine.">
    <meta name="keywords" content="Usluge, teretana, kik boks, Ladies Fitness, quad, apartman, članarine, Goražde, Beg's fitness">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Usluge - BEG'S FIT&FIGHT</title>

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
        /* --- Moderni dodaci za "Usluge" stranicu (ista paleta: #ECD008 - zuta iz loga) --- */
        :root { --accent: #ECD008; --accent-2: #6b5100; --brand-yellow: #ECD008; }
        .reveal { opacity: 0; transform: translateY(26px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }
        .reveal.d1.is-visible { transition-delay: .08s; }
        .reveal.d2.is-visible { transition-delay: .16s; }
        .reveal.d3.is-visible { transition-delay: .24s; }
        .reveal.d4.is-visible { transition-delay: .32s; }

        .usluge-intro-section { background: #0d0d0d; padding: 90px 0 20px; }
        .usluge-intro-text { text-align: center; max-width: 720px; margin: 0 auto; }
        .usluge-intro-text p { color: #b7b7b7; font-size: 15px; line-height: 1.9; margin: 0; }

        /* --- Usluge: kartice sa slikom (isti obrazac kao "Sta nudimo" na naslovnoj) --- */
        .usluge-section { background: #000; }
        .class-item.modern-card { border-radius: 16px; overflow: hidden; background: #111; }
        .class-item.modern-card .ci-pic { border-radius: 16px 16px 0 0; overflow: hidden; height: 230px; }
        .class-item.modern-card .ci-pic img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s ease; }
        .class-item.modern-card:hover .ci-pic img { transform: scale(1.1); }
        .class-item.modern-card .ci-text { padding: 26px 26px 30px; }
        .class-item.modern-card .ci-text span { color: var(--brand-yellow); }
        .class-item.modern-card .ci-text p { color: #a9a9a9; font-size: 13px; line-height: 1.7; margin: 10px 0 0; }

        /* --- Dodatni sadrzaji: isti "prostori" obrazac kao na "O nama" --- */
        .amenities-section { background: #0a0a0a; }
        .space-card { position: relative; border-radius: 14px; overflow: hidden; height: 220px; margin-bottom: 24px; display: block; }
        .space-card img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; display: block; }
        .space-card:hover img { transform: scale(1.08); }
        .space-card .sc-caption { position: absolute; left: 0; right: 0; bottom: 0; padding: 18px 20px; background: linear-gradient(0deg, rgba(0,0,0,.85), rgba(0,0,0,0)); color: #fff; font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: .6px; }

        /* --- Cjenovnik: isti obrazac kao na naslovnoj --- */
        .pricing-section.modern-section { background: #000; }
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

        .usluge-cta { background: linear-gradient(135deg, #6b5100, #241b00); padding: 55px 0; text-align: center; }
        .usluge-cta h3 { color: #fff; font-size: 26px; font-weight: 800; margin-bottom: 10px; }
        .usluge-cta p { color: rgba(255,255,255,.92); margin-bottom: 22px; }
        .usluge-cta .primary-btn { background: #111; color: #fff; margin: 0 6px 10px; }
        .usluge-cta .primary-btn:hover { background: #000; }
        .usluge-cta .primary-btn.ghost { background: transparent; border: 2px solid rgba(255,255,255,.5); }
        .usluge-cta .primary-btn.ghost:hover { background: #fff; color: #111; border-color: #fff; }
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
                <li><a class="active" href="{{ route('usluge') }}"><i class="fa fa-star"></i>Usluge</a></li>
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
                            <li><a href="{{ route('treninzi') }}">Treninzi</a></li>
                            <li class="active"><a href="{{ route('usluge') }}">Usluge</a></li>
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
                        <h2>Usluge</h2>
                        <div class="bt-option">
                            <a href="{{ route('begsfit') }}">Početna</a>
                            <span>Usluge</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Usluge Intro Section Begin -->
    <section class="usluge-intro-section">
        <div class="container">
            <div class="usluge-intro-text reveal">
                <p>BEG'S FIT&amp;FIGHT na jednom mjestu okuplja teretanu, kik boks klub i poseban prostor za žene, uz dodatne sadržaje za opuštanje i rekreaciju izvan teretane. Pogledajte šta sve nudimo.</p>
            </div>
        </div>
    </section>
    <!-- Usluge Intro Section End -->

    <!-- Usluge Section Begin -->
    <section class="usluge-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title reveal">
                        <span>Šta nudimo</span>
                        <h2>Naše usluge</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 reveal d1">
                    <div class="class-item modern-card">
                        <div class="ci-pic">
                            <img src="{{ asset('site/img/classes/class-1.jpg') }}" alt="Fitness centar">
                        </div>
                        <div class="ci-text">
                            <span>FITNESS CENTAR</span>
                            <h5>Sprave za vježbanje</h5>
                            <p>Moderno opremljena teretana sa vrhunskim spravama za vježbanje i stručnim trenerima na raspolaganju.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal d2">
                    <div class="class-item modern-card">
                        <div class="ci-pic">
                            <img src="{{ asset('site/img/classes/class-2.jpg') }}" alt="Kik boks klub">
                        </div>
                        <div class="ci-text">
                            <span>KIK BOKS KLUB</span>
                            <h5>Bez-kontaktni i kontaktni treninzi</h5>
                            <p>Treninzi pod vodstvom licenciranih trenera, prilagođeni i početnicima i iskusnim borcima.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal d3">
                    <div class="class-item modern-card">
                        <div class="ci-pic">
                            <img src="{{ asset('site/img/hero/hero-2.jpg') }}" alt="Ladies Fitness">
                        </div>
                        <div class="ci-text">
                            <span>LADIES FITNESS</span>
                            <h5>Poseban prostor za žene</h5>
                            <p>Zaseban objekat opremljen najnovijim spravama, namijenjen isključivo ženama.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 reveal d4">
                    <div class="class-item modern-card">
                        <div class="ci-pic">
                            <img src="{{ asset('site/img/classes/quads.jpg') }}" alt="Rent a Quad">
                        </div>
                        <div class="ci-text">
                            <span>RENT A QUAD</span>
                            <h5>Iznajmljivanje quadova</h5>
                            <p>Doživite adrenalinsku vožnju uz iznajmljivanje quada - idealno za druženje i aktivan odmor u prirodi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 reveal d1">
                    <div class="class-item modern-card">
                        <div class="ci-pic">
                            <img src="{{ asset('site/img/classes/apartmani-rawda-foto-3-scaled.jpg') }}" alt="Rent an Apartment">
                        </div>
                        <div class="ci-text">
                            <span>RENT AN APARTMENT</span>
                            <h5>Iznajmite jedan od naših apartmana</h5>
                            <p>Udoban smještaj za goste i posjetioce - kontaktirajte nas za dostupnost i cijene.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Usluge Section End -->

    <!-- Amenities Section Begin -->
    <section class="amenities-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title reveal">
                        <span>Uz trening</span>
                        <h2>Dodatni sadržaji</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 reveal d1">
                    <div class="space-card">
                        <img src="{{ asset('site/img/gallery/latte.jpg') }}" alt="Beg's caffe">
                        <div class="sc-caption">Beg's caffe - zdrava ishrana i osvježenje</div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 reveal d2">
                    <div class="space-card">
                        <img src="{{ asset('site/img/gallery/igraonavanjska.jpg') }}" alt="Dječija igraonica">
                        <div class="sc-caption">Dječija igraonica</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Amenities Section End -->

    <!-- Pricing Section Begin -->
    <section class="pricing-section modern-section spad">
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
                            <span>Za mališane</span>
                        </div>
                        <ul>
                            <li>Namjenjen djeci do 15 godina</li>
                            <li>Uključuje redovne kik-boks treninge prilagođene uzrastu</li>
                            <li>Fokus na razvoju koordinacije, kondicije i discipline kroz zabavne i interaktivne vježbe</li>
                            <li>Profesionalni treneri sa iskustvom u radu sa djecom</li>
                        </ul>
                        <a href="{{ route('kontakt') }}" class="primary-btn pricing-btn">Učlani se</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 reveal d2">
                    <div class="ps-item modern-price">
                        <h3>Đačka članarina</h3>
                        <div class="pi-price">
                            <h2>KM 40.00</h2>
                            <span>Korištenje teretane mjesec dana</span>
                        </div>
                        <ul>
                            <li>Namjenjen maloljetnicima od 14 do 18 godina</li>
                            <li>Uključuje neograničen pristup teretani</li>
                            <li>Mogućnost sudjelovanja u kik-boks treninzima bez dodatnih troškova</li>
                            <li>Poseban fokus na jačanju izdržljivosti, snage i mentalne discipline</li>
                        </ul>
                        <a href="{{ route('kontakt') }}" class="primary-btn pricing-btn">Učlani se</a>
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
                            <li>Uključuje opciju sudjelovanja u kik-boks treninzima za rekreativce</li>
                            <li>Idealno za one koji žele kombinovati vježbe snage i borilačke sportove</li>
                            <li>Treninzi pod nadzorom licenciranih instruktora</li>
                        </ul>
                        <a href="{{ route('kontakt') }}" class="primary-btn pricing-btn">Učlani se</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 reveal d1">
                    <div class="ps-item modern-price">
                        <h3>Članarina za penzionere</h3>
                        <div class="pi-price">
                            <h2>KM 40.00</h2>
                            <span>Korištenje teretane mjesec dana</span>
                        </div>
                        <ul>
                            <li>Namjenjen osobama u penziji koje žele održavati zdravlje i kondiciju</li>
                            <li>Uključuje pristup teretani i prilagođene treninge</li>
                            <li>Fokus na lagane vježbe, fleksibilnost i rehabilitaciju</li>
                            <li>Idealna prilika za socijalizaciju i aktivan stil života</li>
                        </ul>
                        <a href="{{ route('kontakt') }}" class="primary-btn pricing-btn">Učlani se</a>
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
                            <li>Pogodna opcija za povremene korisnike ili one koji žele isprobati ponudu</li>
                            <li>Uključuje pristup grupnim treninzima ili individualno korištenje opreme</li>
                            <li>Fleksibilan izbor za ljude sa ograničenim rasporedom</li>
                        </ul>
                        <a href="{{ route('kontakt') }}" class="primary-btn pricing-btn">Učlani se</a>
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
                            <li>Uključuje pristup teretani i mogućnost zakazivanja grupnih treninga</li>
                            <li>Dodatni popust za timove ili grupe</li>
                            <li>Prilagođeni termini za treninge i mogućnost korištenja prostora za timske aktivnosti</li>
                        </ul>
                        <a href="{{ route('kontakt') }}" class="primary-btn pricing-btn">Saznaj više</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Pricing Section End -->

    <!-- Usluge CTA Begin -->
    <div class="usluge-cta">
        <div class="container">
            <h3>Spremni da nam se pridružite?</h3>
            <p>Pogledaj raspored treninga ili nas kontaktiraj za sve dodatne informacije o uslugama i članarinama.</p>
            <a href="{{ route('treninzi') }}" class="primary-btn btn-normal">Raspored treninga</a>
            <a href="{{ route('kontakt') }}" class="primary-btn btn-normal ghost">Kontaktiraj nas</a>
        </div>
    </div>
    <!-- Usluge CTA End -->

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
    <script src="@assetv('site/js/jquery-3.3.1.min.js')"></script>
    <script src="@assetv('site/js/jquery.slicknav.js')"></script>
    <script src="@assetv('site/js/main.js')"></script>

    <script>
        // Moderni "reveal on scroll" efekat za "Usluge" stranicu
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
