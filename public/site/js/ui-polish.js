/* UI polish - zajednicko za sve /begsfit stranice.
   Div elementi koji glume dugmad (meni, pretraga) dobijaju podrsku za tastaturu,
   a .reveal elementi se odmah prikazuju ako je ukljucen "smanji pokret". */
(function () {
    var btns = document.querySelectorAll('.canvas-open, .canvas-close, .search-switch');
    btns.forEach(function (el) {
        if (!el.hasAttribute('role')) el.setAttribute('role', 'button');
        if (!el.hasAttribute('tabindex')) el.setAttribute('tabindex', '0');
        el.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); el.click(); }
        });
    });
    // Link "Preskoci na sadrzaj" - vodi na prvu sekciju poslije zaglavlja
    var target = document.querySelector('header ~ section, .header-section ~ section, section');
    if (target) {
        if (!target.id) target.id = 'sadrzaj';
        if (!target.hasAttribute('tabindex')) target.setAttribute('tabindex', '-1');
        var skip = document.createElement('a');
        skip.className = 'bf-skip-link';
        skip.href = '#' + target.id;
        skip.textContent = 'Preskoči na sadržaj';
        document.body.insertBefore(skip, document.body.firstChild);
    }
    // Mobilni meni: aria-expanded + zatvaranje tipkom Escape
    var openBtn = document.querySelector('.canvas-open');
    var wrap = document.querySelector('.offcanvas-menu-wrapper');
    if (openBtn && wrap) {
        openBtn.setAttribute('aria-expanded', 'false');
        var sync = function () { openBtn.setAttribute('aria-expanded', wrap.classList.contains('show-offcanvas-menu-wrapper') ? 'true' : 'false'); };
        new MutationObserver(sync).observe(wrap, { attributes: true, attributeFilter: ['class'] });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && wrap.classList.contains('show-offcanvas-menu-wrapper')) {
                var c = wrap.querySelector('.canvas-close'); if (c) c.click(); openBtn.focus();
            }
        });
    }
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.querySelectorAll('.reveal').forEach(function (el) { el.classList.add('is-visible'); });
    }
})();
