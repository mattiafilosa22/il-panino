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
            perPage    : 3,
            perMove    : 1,
            focus      : 'center',
            gap        : '8rem', // Increased gap between slides significantly for desktop
            pagination : false,
            arrows     : true,
            breakpoints: {
                992: {
                    perPage: 2,
                    focus  : 'center',
                    gap    : '4rem',
                },
                768: {
                    perPage: 1,
                    focus  : 'center',
                    gap    : '1rem',
                    arrows : false,
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
            this.instance.mount();
        }
    }

    getInstance() {
        return this.instance;
    }
}
