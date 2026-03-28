/**
 * SocialReelsCarousel Class
 * Carousel for social video/reels cards
 */
export default class SocialReelsCarousel {
    constructor(selector) {
        this.element = typeof selector === 'string' ? document.querySelector(selector) : selector;
        this.instance = null;

        if (this.element && typeof Splide !== 'undefined') {
            this.init();
        }
    }

    init() {
        this.instance = new Splide(this.element, {
            type       : 'loop',
            perPage    : 3,
            perMove    : 1,
            focus      : 'center',
            gap        : '1.5rem',
            padding    : '10%',
            pagination : false,
            arrows     : false,
            autoplay   : true,
            interval   : 4000,
            pauseOnHover: true,
            speed      : 800,
            easing     : 'cubic-bezier(0.65, 0.05, 0, 1)',
            breakpoints: {
                1200: {
                    perPage: 3,
                    padding: '8%',
                },
                992: {
                    perPage: 2,
                    padding: '10%',
                    gap: '1rem',
                },
                768: {
                    perPage: 1,
                    padding: '20%',
                    gap: '1rem',
                },
                480: {
                    perPage: 1,
                    padding: '12%',
                    gap: '0.75rem',
                },
            }
        });
    }

    mount() {
        if (this.instance) {
            this.instance.mount();
        }
    }
}
