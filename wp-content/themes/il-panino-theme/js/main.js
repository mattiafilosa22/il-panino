import ProductSliderCarousel from './modules/ProductSliderCarousel.js';

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
});
