/**
 * ProductSliderCarousel Class
 * SRP: Responsabile solo per l'inizializzazione della logica di Splide per i prodotti
 */
export default class ProductSliderCarousel {
    /**
     * @param {string|HTMLElement} selector - Il selettore dello slider
     * @param {Object} customOptions - Opzioni custom di Splide per l'Open-Closed Principle
     */
    constructor(selector, customOptions = {}) {
        this.element = typeof selector === 'string' ? document.querySelector(selector) : selector;
        this.instance = null;

        // Default options uniti alle customOptions (DIP/OCP)
        this.options = Object.assign({
            type       : 'loop',
            perPage    : 1,
            perMove    : 1,
            focus      : 'center',
            start      : 0,
            gap        : '0rem',
            padding    : '25%',
            pagination : false,
            arrows     : true,
            trimSpace  : false,
            autoplay   : true,
            interval   : 5000,
            pauseOnHover: true,
            pauseOnFocus: true,
            resetProgress: false,
            // Smoothness tuning (embla-like momentum & soft settle)
            speed             : 1000,
            easing            : 'cubic-bezier(0.25, 1, 0.35, 1)',
            drag              : 'free',
            snap              : true,
            flickPower        : 600,
            flickMaxPages     : 1,
            waitForTransition : true,
            breakpoints: {
                992: {
                    padding: '20%',
                },
                768: {
                    padding: '10%',
                    arrows : true,
                }
            }
        }, customOptions);

        if (this.element && typeof Splide !== 'undefined') {
            this.init();
        }
    }

    init() {
        this.instance = new Splide(this.element, this.options);
    }

    mount() {
        if (this.instance) {
            // Re-trigger scale/opacity animation on every slide change (including loop)
            this.instance.on('active', (slideComponent) => {
                const card = slideComponent.slide.querySelector('.c-product-card');
                if (!card) return;

                // Reset to inactive state without transition
                card.style.transition = 'none';
                card.style.transform = 'scale(0.7)';
                card.style.opacity = '0.4';

                // Force reflow, then let CSS transition animate to active state
                void card.offsetHeight;
                card.style.transition = '';
                card.style.transform = '';
                card.style.opacity = '';
            });

            this.instance.mount();
        }
    }

    getInstance() {
        return this.instance;
    }
}
