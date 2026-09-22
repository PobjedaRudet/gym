{{-- Dugme "nazad na vrh" - pojavljuje se nakon skrolanja, desni donji ugao. --}}
<button type="button" id="backToTop" class="back-to-top" aria-label="Nazad na vrh stranice" title="Nazad na vrh">
    <i class="fa fa-angle-up" aria-hidden="true"></i>
</button>

<style>
    .back-to-top {
        position: fixed;
        right: 24px;
        bottom: 24px;
        width: 48px;
        height: 48px;
        padding: 0;
        border: none;
        border-radius: 50%;
        background: #ECD008;
        color: #111111;
        font-size: 24px;
        line-height: 1;
        cursor: pointer;
        /* Ispod preloadera (999999), pretrage (99999), bocnog panela (1201)
           i modala (1300) - da ne pluta preko njih kad su otvoreni. */
        z-index: 900;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 22px rgba(0, 0, 0, .4);
        opacity: 0;
        visibility: hidden;
        transform: translateY(14px);
        transition: opacity .3s ease, transform .3s ease, visibility .3s, background .25s ease;
    }

    .back-to-top.is-visible {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .back-to-top:hover {
        background: #ffffff;
    }

    .back-to-top:focus-visible {
        outline: none;
        box-shadow: 0 8px 22px rgba(0, 0, 0, .4), 0 0 0 3px rgba(236, 208, 8, .55);
    }

    @media (max-width: 767px) {
        .back-to-top {
            right: 16px;
            bottom: 16px;
            width: 44px;
            height: 44px;
            font-size: 22px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .back-to-top { transition: opacity .01ms linear; }
    }
</style>

<script>
    (function () {
        var btn = document.getElementById('backToTop');
        if (!btn) return;

        var SHOW_AFTER = 300;
        var ticking = false;

        function update() {
            ticking = false;
            var y = window.pageYOffset || document.documentElement.scrollTop || 0;
            btn.classList.toggle('is-visible', y > SHOW_AFTER);
        }

        window.addEventListener('scroll', function () {
            if (ticking) return;
            ticking = true;
            window.requestAnimationFrame(update);
        }, { passive: true });

        btn.addEventListener('click', function () {
            var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            try {
                window.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' });
            } catch (e) {
                window.scrollTo(0, 0); // stariji preglednici bez podrske za objekat
            }
        });

        update();
    })();
</script>
