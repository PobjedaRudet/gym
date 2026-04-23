<!DOCTYPE html>
<html lang="zxx">

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
                <li><a href="./index.html">Početna</a></li>
                <li><a href="./about-us.html">O nama</a></li>
                <li><a href="./classes.html">Treninzi</a></li>
                <li><a href="./services.html">Usluge</a></li>
                <li><a href="./team.html">Naš tim</a></li>
                <li><a href="#">Više</a>
                    <ul class="dropdown">
                        <li><a href="./about-us.html">O nama</a></li>
                        <li><a href="./class-timetable.html">Raspored treninga</a></li>
                        <li><a href="./team.html">Naš tim</a></li>
                        <li><a href="./gallery.html">Galerija</a></li>

                    </ul>
                </li>
                <li><a href="./contact.html">Kontakt</a></li>
                <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                
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
                        <a href="./index.html">
                            <img src="{{ asset('site/img/logo.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="nav-menu">
                        <ul>
                            <li class="active"><a href="./index.html">Početna</a></li>
                            <li><a href="./about-us.html">O nama</a></li>
                            <li><a href="./class-details.html">Treninzi</a></li>
                            <li><a href="./services.html">Usluge</a></li>
                            <li><a href="./team.html">Naš tim</a></li>
                            <li><a href="#">Više</a>
                                <ul class="dropdown">
                                    <li><a href="./about-us.html">O nama</a></li>
                                    <li><a href="./class-timetable.html">Raspored treninga</a></li>
                                    <li><a href="./team.html">Naš tim</a></li>
                                    <li><a href="./gallery.html">Galerija</a></li>
                                </ul>
                            </li>
                            <li><a href="./contact.html">Kontakt</a></li>
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
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
                                <span>Oblikuj svoje tijelo</span>
                                <h1>Budi<strong> jak</strong> treniraj snažno</h1>
                                <a href="#" class="primary-btn">Više informacija</a>
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
                                <span>Oblikuj svoje tijelo</span>
                                <h1>Budi <strong>jak</strong> treniraj snažno</h1>
                                <a href="#" class="primary-btn">Više informacija</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- ChoseUs Section Begin -->
    <section class="choseus-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Zašto izabrati nas?</span>
                        <h2>POMJERITE SVOJE GRANICE</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-034-stationary-bike"></span>
                        <h4>Moderna oprema</h4>
                        <p>U našem fitness centru nudimo vrhunske sprave za vježbanje i stručne trenere.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-033-juice"></span>
                        <h4>Beg's caffe</h4>
                        <p>Poseban prostor za opuštanje i osvježenje - naš kafić i dječija igraonica. Smješten unutar samog centra, kafić i igraonica su idealno mjesto za sve koji žele odmor i ugodnu atmosferu.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-002-dumbell"></span>
                        <h4>Kik boks club - treninzi</h4>
                        <p>
Uz našu standardnu ponudu, s ponosom ističemo da u sklopu fitness centra posjedujemo i kik boks klub. Ovaj prostor je namijenjen za sve ljubitelje borilačkih sportova, bilo da ste početnik ili iskusan borac.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-014-heart-beat"></span>
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
                    <div class="section-title">
                        <span>Treninzi</span>
                        <h2>Šta nudimo</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="class-item">
                        <div class="ci-pic">
                            <img src="{{ asset('site/img/classes/class-1.jpg') }}" alt="">
                        </div>
                        <div class="ci-text">
                            <span>FITNESS CENTAR</span>
                            <h5>SPRAVE ZA VJEŽBANJE</h5>
                            <a href="#"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="class-item">
                        <div class="ci-pic">
                            <img src="{{ asset('site/img/classes/class-2.jpg') }}" alt="">
                        </div>
                        <div class="ci-text">
                            <span>KIK BOKS CLUB</span>
                            <h5>BEZ KONTAKTNI I KONTAKTNI</h5>
                            <a href="#"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="class-item">
                        <div class="ci-pic">
                            <img src="{{ asset('site/img/hero/hero-2.jpg') }}" alt="">
                        </div>
                        <div class="ci-text">
                            <span>LADIES FITNESS</span>
                            <h5>poseban objekat za žene opremljen je najnovijim spravama</h5>
                            <a href="#"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="class-item">
                        <div class="ci-pic">
                            <img src="{{ asset('site/img/classes/Screenshot_quad.jpg') }}" alt="">
                        </div>
                        <div class="ci-text">
                            <span>QUAD</span>
                            <h4>RENT A QUAD</h4>
                            <a href="#"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="class-item">
                        <div class="ci-pic">
                            <img src="{{ asset('site/img/classes/apartmani-rawda-foto-3-scaled.jpg') }}" alt="">
                        </div>
                        <div class="ci-text">
                            <span>RENT A APARTMENT</span>
                            <h4>Iznajmite jedan od naših apartmana</h4>
                            <a href="#"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ChoseUs Section End -->

    <!-- Banner Section Begin -->
    <section class="banner-section set-bg" data-setbg="{{ asset('site/img/banner-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="bs-text">
                        <h2>Za više informacija</h2>
                        <div class="bt-tips">Gdje se zdravlje, ljepota i izgleda upoznaju.</div>
                        <a href="#" class="primary-btn  btn-normal">Više informacija</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Pricing Section Begin -->
    <section class="pricing-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Članarine</span>
                        <h2>Našim članovima nudimo</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-8">
                    <div class="ps-item">
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
                        <a href="#" class="primary-btn pricing-btn">Učlani se</a>
                        <a href="#" class="thumb-icon"><i class="fa fa-picture-o"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8">
                    <div class="ps-item">
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
                        <a href="#" class="primary-btn pricing-btn">Učlani se</a>
                        <a href="#" class="thumb-icon"><i class="fa fa-picture-o"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8">
                    <div class="ps-item">
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
                        <a href="#" class="primary-btn pricing-btn">Učlani se</a>
                        <a href="#" class="thumb-icon"><i class="fa fa-picture-o"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8">
                    <div class="ps-item">
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
                        <a href="#" class="primary-btn pricing-btn">Učlani se</a>
                        <a href="#" class="thumb-icon"><i class="fa fa-picture-o"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8">
                    <div class="ps-item">
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
                        <a href="#" class="primary-btn pricing-btn">Učlani se</a>
                        <a href="#" class="thumb-icon"><i class="fa fa-picture-o"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8">
                    <div class="ps-item">
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
                        <a href="#" class="primary-btn pricing-btn">Saznaj više</a>
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
            <div class="gs-item grid-wide set-bg" data-setbg="{{ asset('site/img/gallery/teretana.jpg') }}">
                <a href="{{ asset('site/img/gallery/teretana.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item set-bg" data-setbg="{{ asset('site/img/gallery/sampion.jpg') }}">
                <a href="{{ asset('site/img/gallery/sampion.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item set-bg" data-setbg="{{ asset('site/img/gallery/latte.jpg') }}">
                <a href="{{ asset('site/img/gallery/gallery-3.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item set-bg" data-setbg="{{ asset('site/img/gallery/igraonavanjska.jpg') }}">
                <a href="{{ asset('site/img/gallery/igraonavanjska.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item set-bg" data-setbg="{{ asset('site/img/gallery/sank.jpg') }}">
                <a href="{{ asset('site/img/gallery/sank.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item grid-wide set-bg" data-setbg="{{ asset('site/img/gallery/begstim.jpg') }}">
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
        </div>
    </section>
    <!-- Team Section End -->

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



</body>

</html>