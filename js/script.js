// ================================================
// VideoWedding – script.js
// ================================================

document.addEventListener('DOMContentLoaded', function () {

    // ── 2. Navbar scroll ──
    const navbar = document.getElementById('navbar');
    if (navbar) {
        window.addEventListener('scroll', function () {
            navbar.classList.toggle('scrolled', window.scrollY > 60);
        });
    }

    // ── 3. Hero parallax + imagine ──
    const heroBg = document.getElementById('heroBg');
    if (heroBg) {
        setTimeout(function () { heroBg.classList.add('loaded'); }, 100);

        window.addEventListener('scroll', function () {
            var offset = window.scrollY;
            heroBg.style.transform = 'scale(1) translateY(' + (offset * 0.3) + 'px)';
        });
    }

    // ── 4. Counter animat ──
    var counters = document.querySelectorAll('.counter-num');
    var counted  = false;

    function animateCounters() {
        if (counted) return;
        var band = document.querySelector('.counter-band');
        if (!band) return;
        var rect = band.getBoundingClientRect();
        if (rect.top < window.innerHeight - 100) {
            counted = true;
            counters.forEach(function (el) {
                var target = parseInt(el.getAttribute('data-target'));
                var step   = Math.ceil(target / 60);
                var current = 0;
                var timer = setInterval(function () {
                    current += step;
                    if (current >= target) { current = target; clearInterval(timer); }
                    el.textContent = current + (el.getAttribute('data-target') == '98' ? '' : '+');
                }, 25);
            });
        }
    }

    window.addEventListener('scroll', animateCounters);
    animateCounters();

    // ── 5. Scroll reveal ──
    var reveals = document.querySelectorAll('.card, .avantaj, .testi-card, .galerie-item');

    function revealOnScroll() {
        reveals.forEach(function (el, i) {
            var rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight - 80) {
                setTimeout(function () {
                    el.classList.add('visible');
                }, i % 4 * 120);
            }
        });
    }

    window.addEventListener('scroll', revealOnScroll);
    revealOnScroll();

    // ── 6. Ascunde mesaje auto ──
    document.querySelectorAll('.mesaj').forEach(function (mesaj) {
        setTimeout(function () {
            mesaj.style.transition = 'opacity 0.5s';
            mesaj.style.opacity = '0';
            setTimeout(function () { mesaj.remove(); }, 500);
        }, 4000);
    });

    // ── 7. Smooth scroll pentru linkuri cu # ──
    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            var id = a.getAttribute('href');
            if (id === '#') return;
            var target = document.querySelector(id);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

});
