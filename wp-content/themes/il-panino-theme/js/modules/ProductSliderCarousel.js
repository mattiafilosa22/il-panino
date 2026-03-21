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
            padding    : '20%',
            pagination : false,
            arrows     : true,
            trimSpace  : false,
            breakpoints: {
                992: {
                    padding: '15%',
                },
                768: {
                    padding: '0',
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
