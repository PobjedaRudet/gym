/*  ---------------------------------------------------
  Template Name: Gym
  Description:  Gym Fitness HTML Template
  Author: Colorlib
  Author URI: https://colorlib.com
  Version: 1.0
  Created: Colorlib
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    // Skriva se cim je DOM spreman - cekanje na window.load je drzalo
    // stranicu praznom dok se ne skinu sve slike.
    function hidePreloader() {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");
    }
    hidePreloader();
    $(window).on('load', hidePreloader);

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    //Canvas Menu
    $(".canvas-open").on('click', function () {
        $(".offcanvas-menu-wrapper").addClass("show-offcanvas-menu-wrapper");
        $(".offcanvas-menu-overlay").addClass("active");
    });

    $(".canvas-close, .offcanvas-menu-overlay").on('click', function () {
        $(".offcanvas-menu-wrapper").removeClass("show-offcanvas-menu-wrapper");
        $(".offcanvas-menu-overlay").removeClass("active");
    });

    // Search model
    $('.search-switch').on('click', function () {
        $('.search-model').fadeIn(400);
    });

    $('.search-close-switch').on('click', function () {
        $('.search-model').fadeOut(400, function () {
            $('#search-input').val('');
        });
    });

    //Masonary
    if ($.fn.masonry && $('.gallery').length) {
        $('.gallery').masonry({
            itemSelector: '.gs-item',
            columnWidth: '.grid-sizer',
            gutter: 10
        });
    }

    /*------------------
		Navigation
	--------------------*/
    if ($.fn.slicknav && $(".mobile-menu").length) {
        $(".mobile-menu").slicknav({
            prependTo: '#mobile-menu-wrap',
            allowParentLinks: true
        });
    }

    /*------------------
        Carousel Slider
    --------------------*/
    if ($.fn.owlCarousel) {
        var hero_s = $(".hs-slider");
        if (hero_s.length) {
            hero_s.owlCarousel({
                loop: true,
                margin: 0,
                nav: true,
                items: 1,
                dots: false,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                smartSpeed: 1200,
                autoHeight: false,
                autoplay: false
            });
        }

        /*------------------
            Team Slider
        --------------------*/
        if ($(".ts-slider").length) {
            $(".ts-slider").owlCarousel({
                loop: true,
                margin: 0,
                items: 3,
                dots: true,
                dotsEach: 2,
                smartSpeed: 1200,
                autoHeight: false,
                autoplay: true,
                responsive: {
                    320: {
                        items: 1,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    }
                }
            });
        }

        /*------------------
            Testimonial Slider
        --------------------*/
        if ($(".ts_slider").length) {
            $(".ts_slider").owlCarousel({
                loop: true,
                margin: 0,
                items: 1,
                dots: false,
                nav: true,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                smartSpeed: 1200,
                autoHeight: false,
                autoplay: true
            });
        }
    }

    /*------------------
        Image / Video Popup
    --------------------*/
    if ($.fn.magnificPopup) {
        if ($('.image-popup').length) {
            $('.image-popup').magnificPopup({
                type: 'image'
            });
        }
        if ($('.video-popup').length) {
            $('.video-popup').magnificPopup({
                type: 'iframe'
            });
        }
    }

    /*------------------
        Barfiller
    --------------------*/
    if ($.fn.barfiller) {
        $('#bar1, #bar2, #bar3').each(function () {
            $(this).barfiller({
                barColor: '#ffffff',
                duration: 2000
            });
        });
    }

    $('.table-controls ul li').on('click', function () {
        var tsfilter = $(this).data('tsfilter');
        $('.table-controls ul li').removeClass('active');
        $(this).addClass('active');

        if (tsfilter == 'all') {
            $('.class-timetable').removeClass('filtering');
            $('.ts-meta').removeClass('show');
        } else {
            $('.class-timetable').addClass('filtering');
        }
        $('.ts-meta').each(function () {
            $(this).removeClass('show');
            if ($(this).data('tsmeta') == tsfilter) {
                $(this).addClass('show');
            }
        });
    });

})(jQuery);