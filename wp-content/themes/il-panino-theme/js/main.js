import ProductSliderCarousel from './modules/ProductSliderCarousel.js';
import SocialReelsCarousel from './modules/SocialReelsCarousel.js';
import MenuCoreFilter from './modules/MenuCoreFilter.js';
import InstagramFeedSlider from './modules/InstagramFeedSlider.js';

document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileNavOverlay = document.querySelector('.mobile-nav-overlay');
    const mobileNavClose = document.querySelector('.mobile-nav-close');
    const body = document.body;

    if(menuToggle && mobileNavOverlay && mobileNavClose) {
        
        // Open Mobile Menu
        menuToggle.addEventListener('click', function() {
            mobileNavOverlay.classList.add('is-active');
            menuToggle.setAttribute('aria-expanded', 'true');
            // Blocca lo scroll del body quando il menu è aperto
            body.style.overflow = 'hidden';
        });

        // Close Mobile Menu
        mobileNavClose.addEventListener('click', function() {
            mobileNavOverlay.classList.remove('is-active');
            menuToggle.setAttribute('aria-expanded', 'false');
            // Ripristina lo scroll
            body.style.overflow = '';
        });

        // Chiudi il menu se si clicca un link nel menù mobile (utile per le ancore)
        const mobileLinks = mobileNavOverlay.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileNavOverlay.classList.remove('is-active');
                menuToggle.setAttribute('aria-expanded', 'false');
                body.style.overflow = '';
            });
        });
    }

    // Initialize Homepage Product Slider
    const productSliderElement = document.getElementById('homepage-product-slider');
    if (productSliderElement && typeof Splide !== 'undefined') {
        const carousel = new ProductSliderCarousel(productSliderElement);
        carousel.mount();
    }

    // Initialize Social Reels Slider
    const socialReelsElement = document.querySelector('.js-social-reels-slider');
    if (socialReelsElement && typeof Splide !== 'undefined') {
        const socialCarousel = new SocialReelsCarousel(socialReelsElement);
        socialCarousel.mount();
    }

    // Initialize Instagram Feed Slider (Spotlight grid -> horizontal slider)
    document.querySelectorAll('.c-instagram-feed').forEach(el => {
        new InstagramFeedSlider(el).init();
    });

    // Initialize Menu Core Filter
    const menuCoreElement = document.querySelector('.c-menu-core');
    if (menuCoreElement) {
        const menuFilter = new MenuCoreFilter(menuCoreElement);
        menuFilter.init();
    }

    // Scroll reveal for sections with .js-reveal
    const revealSections = document.querySelectorAll('.js-reveal');
    if (revealSections.length > 0) {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        revealSections.forEach(section => revealObserver.observe(section));
    }
});
