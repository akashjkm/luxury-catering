/* ============================================
   GOURMET AFFAIR — Main JavaScript
   ============================================ */

$(document).ready(function() {

    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 100
    });

    // Navbar scroll effect
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('#mainNav').addClass('scrolled');
        } else {
            $('#mainNav').removeClass('scrolled');
        }
    });

    // ============================================
    // HERO SLIDER
    // ============================================

    let currentSlide = 0;
    const slides = $('.hero-slide');
    const dots = $('.hero-dot');
    const totalSlides = slides.length;
    let slideInterval;

    function goToSlide(index) {
        slides.removeClass('active');
        dots.removeClass('active');

        slides.eq(index).addClass('active');
        dots.eq(index).addClass('active');

        currentSlide = index;
    }

    function nextSlide() {
        let next = currentSlide + 1;
        if (next >= totalSlides) next = 0;
        goToSlide(next);
    }

    function prevSlide() {
        let prev = currentSlide - 1;
        if (prev < 0) prev = totalSlides - 1;
        goToSlide(prev);
    }

    function startAutoSlide() {
        slideInterval = setInterval(nextSlide, 6000);
    }

    function stopAutoSlide() {
        clearInterval(slideInterval);
    }

    // Hero navigation
    $('.hero-arrow.next').on('click', function() {
        stopAutoSlide();
        nextSlide();
        startAutoSlide();
    });

    $('.hero-arrow.prev').on('click', function() {
        stopAutoSlide();
        prevSlide();
        startAutoSlide();
    });

    $('.hero-dot').on('click', function() {
        stopAutoSlide();
        goToSlide($(this).data('index'));
        startAutoSlide();
    });

    // Start auto-slide
    startAutoSlide();

    // ============================================
    // SIGNATURE SERVICES OWL CAROUSEL
    // ============================================

    const servicesCarousel = $('.services-carousel');

    servicesCarousel.owlCarousel({
        items: 3,
        loop: true,
        margin: 30,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsive: {
            0: { items: 1 },
            768: { items: 2 },
            992: { items: 3 }
        }
    });

    $('.services-prev').on('click', function() {
        servicesCarousel.trigger('prev.owl.carousel');
    });

    $('.services-next').on('click', function() {
        servicesCarousel.trigger('next.owl.carousel');
    });

    // ============================================
    // TESTIMONIALS CAROUSEL
    // ============================================

    const testimonialCarousel = $('.testimonials-carousel');

    testimonialCarousel.owlCarousel({
        items: 1,
        loop: true,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn'
    });

    $('.testimonial-prev').on('click', function() {
        testimonialCarousel.trigger('prev.owl.carousel');
    });

    $('.testimonial-next').on('click', function() {
        testimonialCarousel.trigger('next.owl.carousel');
    });

    $('.testimonial-dot').on('click', function() {
        const index = $(this).data('index');
        testimonialCarousel.trigger('to.owl.carousel', [index, 500]);
        $('.testimonial-dot').removeClass('active');
        $(this).addClass('active');
    });

    testimonialCarousel.on('changed.owl.carousel', function(event) {
        const index = event.item.index - event.relatedTarget._clones.length / 2;
        let realIndex = index % event.item.count;
        if (realIndex < 0) realIndex += event.item.count;

        $('.testimonial-dot').removeClass('active');
        $('.testimonial-dot').eq(realIndex).addClass('active');
    });

    // ============================================
    // VENUES CAROUSEL
    // ============================================

    $('.venues-carousel').owlCarousel({
        items: 3,
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        responsive: {
            0: { items: 1 },
            768: { items: 2 },
            992: { items: 3 }
        }
    });

    // ============================================
    // SMOOTH SCROLL
    // ============================================

    $('a[href^="#"]').on('click', function(e) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 800);
        }
    });

    // ============================================
    // FORM HANDLING
    // ============================================

    $('#enquiryForm').on('submit', function(e) {
        e.preventDefault();

        const btn = $(this).find('button[type="submit"]');
        const originalText = btn.text();

        btn.prop('disabled', true).text('Sending...');

        setTimeout(function() {
            btn.text('Enquiry Sent!');
            btn.removeClass('btn-gold').addClass('btn-success');

            setTimeout(function() {
                $('#enquiryModal').modal('hide');
                btn.prop('disabled', false).text(originalText);
                btn.removeClass('btn-success').addClass('btn-gold');
                $('#enquiryForm')[0].reset();
            }, 2000);
        }, 1500);
    });

    $('.newsletter-form').on('submit', function(e) {
        e.preventDefault();
        const btn = $(this).find('button');
        const originalText = btn.text();
        btn.text('Subscribed!');
        setTimeout(function() {
            btn.text(originalText);
            $(this)[0].reset();
        }.bind(this), 2000);
    });

    // ============================================
    // GALLERY LIGHTBOX (Simple)
    // ============================================

    $('.gallery-item, .gallery-full-item').on('click', function() {
        const imgSrc = $(this).find('img').attr('src');
        const title = $(this).find('h4').text() || '';

        const lightbox = $(`
            <div class="lightbox" style="
                position: fixed;
                top: 0; left: 0;
                width: 100%; height: 100%;
                background: rgba(10,10,10,0.95);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                cursor: pointer;
                animation: fadeIn 0.3s ease;
            ">
                <img src="${imgSrc}" style="max-width: 90%; max-height: 80vh; object-fit: contain;">
                ${title ? `<p style="color: var(--color-gold); margin-top: 20px; font-family: var(--font-serif); font-size: 1.2rem;">${title}</p>` : ''}
                <button style="
                    position: absolute;
                    top: 20px; right: 20px;
                    background: none; border: none;
                    color: white; font-size: 2rem;
                    cursor: pointer;
                ">&times;</button>
            </div>
        `);

        $('body').append(lightbox);
        $('body').css('overflow', 'hidden');

        lightbox.on('click', function(e) {
            if (e.target !== $(this).find('img')[0]) {
                lightbox.remove();
                $('body').css('overflow', '');
            }
        });
    });

    // ============================================
    // COUNTER ANIMATION
    // ============================================

    function animateCounter($el) {
        const target = parseInt($el.data('count'));
        const duration = 2000;
        const start = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - start;
            const progress = Math.min(elapsed / duration, 1);
            const easeOut = 1 - Math.pow(1 - progress, 3);
            const current = Math.floor(easeOut * target);

            $el.text(current + ($el.data('suffix') || ''));

            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                $el.text(target + ($el.data('suffix') || ''));
            }
        }

        requestAnimationFrame(update);
    }

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter($(entry.target));
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    $('[data-count]').each(function() {
        counterObserver.observe(this);
    });

    // ============================================
    // PARALLAX EFFECT
    // ============================================

    $(window).scroll(function() {
        const scrolled = $(window).scrollTop();
        $('.parallax-bg').each(function() {
            const speed = $(this).data('speed') || 0.3;
            $(this).css('transform', 'translateY(' + (scrolled * speed) + 'px)');
        });
    });

    // ============================================
    // PAGE TRANSITION
    // ============================================

    $('a:not([href^="#"]):not([data-bs-toggle]):not([target])').on('click', function(e) {
        const href = $(this).attr('href');
        if (href && href.indexOf('javascript:') !== 0) {
            e.preventDefault();
            $('body').fadeOut(300, function() {
                window.location = href;
            });
        }
    });

    $('body').fadeIn(300);

});

// Fade in animation for page load
document.addEventListener('DOMContentLoaded', function() {
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';
    setTimeout(function() {
        document.body.style.opacity = '1';
    }, 100);
});
