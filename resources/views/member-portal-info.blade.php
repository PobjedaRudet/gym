<!DOCTYPE html>
<html lang="bs">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Portal za članove - BEG'S FIT&FIGHT. Saznajte kako da se registrujete i prijavite na portal za članove.">
    <meta name="keywords" content="Portal za članove, registracija, prijava, BEG'S FIT&FIGHT, Goražde">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Portal za članove - BEG'S FIT&FIGHT</title>

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
        /* --- Portal za članove: koristi istu paletu kao naslovna/O nama: #ECD008 (zuta iz loga) --- */
        .reveal { opacity: 0; transform: translateY(26px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }

        .portal-intro { background: #000; padding: 90px 0; }
        .portal-intro p { color: #b7b7b7; font-size: 15px; line-height: 1.8; }

        .steps-section { background: #0a0a0a; }
        .step-card { background: #151515; border-radius: 14px; padding: 34px 26px; height: 100%; position: relative; transition: transform .3s ease, background .3s ease; }
        .step-card:hover { transform: translateY(-6px); background: #1b1b1b; }
        .step-card .step-num { display: inline-flex; align-items: center; justify-content: center; width: 44px; height: 44px; border-radius: 50%; background: #ECD008; color: #111111; font-weight: 800; font-family: 'Oswald', sans-serif; font-size: 18px; margin-bottom: 18px; }
        .step-card h4 { color: #fff; text-transform: uppercase; font-size: 15px; margin-bottom: 10px; letter-spacing: .5px; }
        .step-card p { color: #b7b7b7; font-size: 13px; margin: 0; line-height: 1.7; }
        .step-card p a { color: #ECD008; font-weight: 700; text-decoration: underline; text-underline-offset: 2px; transition: color .2s ease; }
        .step-card p a:hover { color: #fff; }

        .portal-note { background: #1b1400; border: 1px solid #3a2a00; border-radius: 10px; padding: 16px 20px; margin-top: 28px; }
        .portal-note p { color: #e8b877; font-size: 13px; margin: 0; line-height: 1.7; }
        .portal-note i { color: #ECD008; margin-right: 8px; }

        .faq-section { background: #111; }
        .faq-item { background: #151515; border-radius: 12px; padding: 24px 26px; margin-bottom: 18px; }
        .faq-item h4 { color: #ECD008; font-size: 14px; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 10px; }
        .faq-item p { color: #b7b7b7; font-size: 13px; margin: 0; line-height: 1.7; }

        .portal-cta { background: linear-gradient(135deg, #6b5100, #241b00); padding: 55px 0; text-align: center; }
        .portal-cta h3 { color: #fff; font-size: 26px; font-weight: 800; margin-bottom: 10px; }
        .portal-cta p { color: rgba(255,255,255,.92); margin-bottom: 26px; }
        .portal-cta .primary-btn { background: #111; color: #fff; margin: 0 8px 10px; }
        .portal-cta .primary-btn:hover { background: #000; }
        .portal-cta .primary-btn.outline { background: transparent; border: 2px solid #fff; color: #fff; }
        .portal-cta .primary-btn.outline:hover { background: rgba(255,255,255,.12); }

        .screens-section { background: #000; padding: 90px 0; }
        .screen-card {
            background: #111; border-radius: 18px; padding: 16px 16px 22px;
            border: 1px solid rgba(255, 255, 255, .06); height: 100%;
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        }
        .screen-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0, 0, 0, .4); border-color: rgba(236, 208, 8, .3); }
        .screen-card .screen-frame {
            border-radius: 12px; overflow: hidden; border: 1px solid rgba(255, 255, 255, .08);
            background: #000; margin-bottom: 16px;
        }
        .screen-card .screen-frame img { width: 100%; height: auto; display: block; }
        .screen-card .screen-num {
            display: inline-flex; align-items: center; justify-content: center;
            width: 26px; height: 26px; border-radius: 50%; background: #ECD008; color: #111;
            font-weight: 800; font-size: 12px; font-family: 'Oswald', sans-serif; margin-right: 8px;
        }
        .screen-card h5 { color: #fff; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: .3px; display: inline-flex; align-items: center; margin-bottom: 10px; }
        .screen-card p { color: #a9a9a9; font-size: 13px; line-height: 1.7; margin: 0; }
        .screen-card .screen-link {
            display: inline-flex; align-items: center; gap: 6px;
            color: #ECD008; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .3px;
            margin-top: 14px; transition: gap .25s ease, color .25s ease;
        }
        .screen-card .screen-link:hover { gap: 10px; color: #fff; }
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
                            <li><a href="{{ route('usluge') }}">Usluge</a></li>
                            <li><a href="{{ route('team') }}">Naš tim</a></li>
                            <li><a href="{{ route('galerija') }}">Galerija</a></li>
                            <li><a href="{{ route('kontakt') }}">Kontakt</a></li>
                            <li class="active"><a class="nav-link" href="{{ route('portal-info') }}">Portal za članove</a></li>
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
                        <h2>Portal za članove</h2>
                        <div class="bt-option">
                            <a href="{{ route('begsfit') }}">Početna</a>
                            <span>Portal za članove</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Portal Intro Begin -->
    <section class="portal-intro">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <span>Za naše članove</span>
                        <h2>Šta je portal za članove?</h2>
                    </div>
                    <p>Portal za članove je online prostor namijenjen isključivo članovima BEG'S FIT&amp;FIGHT centra. Kroz njega možete pratiti status i trajanje vaše članarine, prijavljivati se na termine i treninge, pratiti svoj napredak (dolaske i ciljeve) i biti u toku sa svim obavijestima iz centra - bez potrebe da nas kontaktirate za svaku informaciju.</p>
                    <p>Da biste koristili portal, potrebno je da <strong>prvo budete registrovani kao član na recepciji</strong> - portal ne služi za kreiranje potpuno novog članstva, već za aktivaciju online pristupa vašem postojećem članskom nalogu.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Portal Intro End -->

    <!-- Steps Section Begin: Registracija -->
    <section class="steps-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Prvi koraci</span>
                        <h2>Kako se registrovati na portal</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6 reveal">
                    <div class="step-card">
                        <div class="step-num">1</div>
                        <h4>Unesite svoj email</h4>
                        <p>Otvorite stranicu za <a href="https://begsfit-fight.ba/portal/register" target="_blank" rel="noopener">registraciju</a> i unesite email adresu koju ste ostavili prilikom učlanjenja na recepciji. Ako sistem ne prepozna vaš email, obratite se recepciji da ga dodaju uz vaš članski nalog.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 reveal">
                    <div class="step-card">
                        <div class="step-num">2</div>
                        <h4>Provjerite svoj email</h4>
                        <p>Sistem automatski generiše sigurnu lozinku i šalje vam je na email. Ova lozinka vam omogućava prvu prijavu na portal - kasnije je možete promijeniti u svojim postavkama.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 reveal">
                    <div class="step-card">
                        <div class="step-num">3</div>
                        <h4>Prijavite se</h4>
                        <p>Vratite se na stranicu za <a href="https://begsfit-fight.ba/portal/login" target="_blank" rel="noopener">prijavu</a> i unesite svoj email i lozinku koju ste dobili. Nakon prijave, odmah imate pristup svom profilu, terminima, statistici i obavijestima.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="portal-note">
                        <p><i class="fa fa-info-circle"></i>Registracija je moguća samo ako imate aktivnu članarinu. Ako je vaša članarina istekla, prvo je potrebno obnoviti je na recepciji.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Steps Section End -->

    <!-- Steps Section Begin: Prijava -->
    <section class="steps-section spad" style="background:#0a0a0a; padding-top:0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Već imate nalog?</span>
                        <h2>Kako se prijaviti na portal</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6 reveal">
                    <div class="step-card">
                        <div class="step-num">1</div>
                        <h4>Otvorite stranicu za prijavu</h4>
                        <p>Kliknite na dugme "<a href="https://begsfit-fight.ba/portal/login" target="_blank" rel="noopener">Prijavi se</a>" ispod ili posjetite stranicu za prijavu članova.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 reveal">
                    <div class="step-card">
                        <div class="step-num">2</div>
                        <h4>Unesite email i lozinku</h4>
                        <p>Unesite svoj email i lozinku koju ste dobili prilikom registracije (ili naknadno postavili). Opcija "Zapamti me" vas ostavlja prijavljenim na ovom uređaju.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 reveal">
                    <div class="step-card">
                        <div class="step-num">3</div>
                        <h4>Zaboravili ste lozinku?</h4>
                        <p>Na stranici za prijavu kliknite na "Zaboravili ste lozinku?" i unesite svoj email - poslat ćemo vam link za kreiranje nove lozinke, koji vrijedi 60 minuta.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Steps Section End -->

    <!-- Screens Section Begin -->
    <section class="screens-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title reveal">
                        <span>Pogledaj unaprijed</span>
                        <h2>Kako izgleda portal za članove</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6 reveal d1">
                    <div class="screen-card">
                        <div class="screen-frame">
                            <img src="{{ asset('site/img/portal-screens/portal-1-registracija.png') }}" alt="Registracija na portal za članove">
                        </div>
                        <h5><span class="screen-num">1</span>Registracija</h5>
                        <p>Unosite email koji ste ostavili na recepciji - sistem vam šalje lozinku za prvu prijavu.</p>
                        <a href="https://begsfit-fight.ba/portal/register" class="screen-link">Idi na registraciju <i class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 reveal d2">
                    <div class="screen-card">
                        <div class="screen-frame">
                            <img src="{{ asset('site/img/portal-screens/portal-2-prijava.png') }}" alt="Prijava na portal za članove">
                        </div>
                        <h5><span class="screen-num">2</span>Prijava</h5>
                        <p>Prijava emailom i lozinkom, uz opciju "Zaboravili ste lozinku?" ako vam zatreba nova.</p>
                        <a href="https://begsfit-fight.ba/portal/login" class="screen-link">Idi na prijavu <i class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 reveal d3">
                    <div class="screen-card">
                        <div class="screen-frame">
                            <img src="{{ asset('site/img/portal-screens/portal-3-profil.png') }}" alt="Profil, dolasci i mjesečni ciljevi na portalu">
                        </div>
                        <h5><span class="screen-num">3</span>Profil i statistika</h5>
                        <p>Pregled dolazaka, ukupnih sati, prosjeka treninga i napretka prema mjesečnim ciljevima.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 reveal d4">
                    <div class="screen-card">
                        <div class="screen-frame">
                            <img src="{{ asset('site/img/portal-screens/portal-4-meni.png') }}" alt="Meni portala - termini, obavijesti i postavke">
                        </div>
                        <h5><span class="screen-num">4</span>Meni portala</h5>
                        <p>Brz pristup terminima treninga, obavijestima, pravilima centra i postavkama naloga.</p>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 30px;">
                <div class="col-lg-3 col-sm-6 reveal d1">
                    <div class="screen-card">
                        <div class="screen-frame">
                            <img src="{{ asset('site/img/portal-screens/portal-5-pregled-mjeseci.png') }}" alt="Pregled dolazaka po mjesecima na portalu">
                        </div>
                        <h5><span class="screen-num">5</span>Pregled po mjesecima</h5>
                        <p>Grafik i tabela dolazaka za svaki mjesec, uz poređenje broja dolazaka po godinama.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 reveal d2">
                    <div class="screen-card">
                        <div class="screen-frame">
                            <img src="{{ asset('site/img/portal-screens/portal-6-usporedba.png') }}" alt="Mjesečna usporedba dolazaka na portalu">
                        </div>
                        <h5><span class="screen-num">6</span>Mjesečna usporedba</h5>
                        <p>Usporedba posljednjih 6 mjeseci - broj dolazaka, ukupno vrijeme i prosjek po posjeti.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 reveal d3">
                    <div class="screen-card">
                        <div class="screen-frame">
                            <img src="{{ asset('site/img/portal-screens/portal-7-sedmicni.png') }}" alt="Sedmični pregled dolazaka na portalu">
                        </div>
                        <h5><span class="screen-num">7</span>Sedmični pregled</h5>
                        <p>Broj dolazaka i utrošeno vrijeme po sedmicama, sa grafikom kretanja kroz mjesece.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 reveal d4">
                    <div class="screen-card">
                        <div class="screen-frame">
                            <img src="{{ asset('site/img/portal-screens/portal-8-statistika-treninga.png') }}" alt="Statistika treninga i mjesečni ciljevi na portalu">
                        </div>
                        <h5><span class="screen-num">8</span>Statistika treninga</h5>
                        <p>Ukupan broj dolazaka i sati, prosjek po treningu i napredak prema mjesečnim ciljevima.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Screens Section End -->

    <!-- FAQ Section Begin -->
    <section class="faq-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Pitanja i odgovori</span>
                        <h2>Često postavljana pitanja</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="faq-item">
                        <h4>Nisam dobio email sa lozinkom, šta da radim?</h4>
                        <p>Provjerite folder za neželjenu poštu (spam). Ako ga i dalje ne vidite, obratite se recepciji da provjeri da li je email ispravno unesen uz vaš članski nalog.</p>
                    </div>
                    <div class="faq-item">
                        <h4>Da li mogu sam da promijenim email pod kojim sam registrovan?</h4>
                        <p>Email vezan za vaš članski nalog mijenja isključivo osoblje na recepciji - iz sigurnosnih razloga to nije moguće uraditi samostalno kroz portal.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="faq-item">
                        <h4>Moja članarina je istekla - mogu li se prijaviti na portal?</h4>
                        <p>Ne, portal je dostupan samo članovima sa aktivnom članarinom. Obnovite članarinu na recepciji, nakon čega ćete ponovo moći da se prijavite.</p>
                    </div>
                    <div class="faq-item">
                        <h4>Mogu li promijeniti lozinku nakon prijave?</h4>
                        <p>Da, u postavkama profila na portalu možete u svakom trenutku postaviti novu lozinku unosom trenutne i nove lozinke.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FAQ Section End -->

    <!-- Portal CTA Begin -->
    <div class="portal-cta">
        <div class="container">
            <h3>Spremni da pristupite portalu?</h3>
            <p>Registrujte se ako ovo radite prvi put, ili se prijavite ako već imate nalog.</p>
            <a href="https://begsfit-fight.ba/portal/register" class="primary-btn btn-normal">Registruj se</a>
            <a href="https://begsfit-fight.ba/portal/login" class="primary-btn btn-normal outline">Prijavi se</a>
        </div>
    </div>
    <!-- Portal CTA End -->

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
        // Reveal on scroll efekat za "Portal za članove" stranicu
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
