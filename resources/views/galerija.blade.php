<!DOCTYPE html>
<html lang="bs">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Galerija - BEG'S FIT&FIGHT, fitness centar i kik boks klub u Goraždu">
    <meta name="keywords" content="Gym, galerija, slike, teretana, kik boks, Goražde, Beg's fitness">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Galerija - BEG'S FIT&FIGHT</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900|Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="@assetv('site/css/bootstrap.min.css')" type="text/css">
    <link rel="stylesheet" href="@assetv('site/css/font-awesome.min.css')" type="text/css">
    <link rel="stylesheet" href="@assetv('site/css/flaticon.css')" type="text/css">
    <link rel="stylesheet" href="@assetv('site/css/magnific-popup.css')" type="text/css">
    <link rel="stylesheet" href="@assetv('site/css/slicknav.min.css')" type="text/css">
    <link rel="stylesheet" href="@assetv('site/css/style.css')" type="text/css">

    <style>
        /* --- Moderni dodaci za "Galerija" stranicu (ista paleta: #ECD008 - zuta iz loga) --- */
        .reveal { opacity: 0; transform: translateY(26px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }

        .gallery-intro-section { background: #0d0d0d; padding: 90px 0 20px; }
        .gallery-intro-text { text-align: center; max-width: 700px; margin: 0 auto; }
        .gallery-intro-text p { color: #b7b7b7; font-size: 15px; line-height: 1.9; margin: 0; }

        .gallery-page-section { background: #000; padding: 20px 0 100px; }

        .gs-item.modern-gallery { border-radius: 14px; overflow: hidden; transition: transform .4s ease; }
        .gs-item.modern-gallery:hover { transform: scale(1.02); }
        .gs-item.modern-gallery .thumb-icon { transition: all .3s ease; }
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
                <li><a class="active" href="{{ route('galerija') }}"><i class="fa fa-picture-o"></i>Galerija</a></li>
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
                            <li class="active"><a href="{{ route('galerija') }}">Galerija</a></li>
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
                        <h2>Galerija</h2>
                        <div class="bt-option">
                            <a href="{{ route('begsfit') }}">Početna</a>
                            <span>Galerija</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Gallery Intro Section Begin -->
    <section class="gallery-intro-section">
        <div class="container">
            <div class="gallery-intro-text reveal">
                <p>Pogledajte kako izgleda naš centar - teretana, kik boks klub i Beg's caffe. Kliknite na sliku za uvećani prikaz.</p>
            </div>
        </div>
    </section>
    <!-- Gallery Intro Section End -->

    <!-- Gallery Section Begin -->
    <section class="gallery-page-section">
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
    </section>
    <!-- Gallery Section End -->

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
    <script src="@assetv('site/js/jquery.magnific-popup.min.js')"></script>
    <script src="@assetv('site/js/masonry.pkgd.min.js')"></script>
    <script src="@assetv('site/js/jquery.slicknav.js')"></script>
    <script src="@assetv('site/js/main.js')"></script>

    <script>
        // Moderni "reveal on scroll" efekat za "Galerija" stranicu
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
