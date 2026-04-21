/**
 * StickyHeader
 *
 * Toggles the scrolled state of the main site header. Adds the
 * `.is-scrolled` modifier on the root element when the vertical
 * scroll offset passes the threshold declared via
 * `data-sticky-threshold` (fallback: 300px). Removes it otherwise.
 *
 * Performance: the scroll listener is throttled using
 * `requestAnimationFrame` so state is updated at most once per frame.
 *
 * Accessibility: the CSS animation is disabled via
 * `@media (prefers-reduced-motion: reduce)`; this module only toggles
 * a class — no JS-driven animation, no ARIA state changes (the header
 * is always visible in the DOM; only its positioning changes).
 *
 * SRP: this class owns the single responsibility of syncing the
 * header's scrolled state with the scroll position.
 */
export default class StickyHeader {
    /**
     * @param {HTMLElement} element - The `header.site-header` root element.
     */
    constructor(element) {
        this.element = element;

        const attr = element && element.dataset ? element.dataset.stickyThreshold : null;
        const parsed = attr !== null && attr !== undefined ? parseInt(attr, 10) : NaN;
        this.threshold = Number.isFinite(parsed) && parsed >= 0 ? parsed : 300;

        this.isScrolled = false;
        this.ticking = false;

        // Bind once so we can remove the listener if ever needed.
        this.onScroll = this.onScroll.bind(this);
        this.update = this.update.bind(this);
    }

    /**
     * Attach the scroll listener and sync initial state.
     */
    init() {
        if (!this.element) {
            return;
        }

        // Sync immediately in case the page loads already scrolled.
        this.update();

        window.addEventListener('scroll', this.onScroll, { passive: true });
    }

    /**
     * Scroll handler: throttled via requestAnimationFrame.
     */
    onScroll() {
        if (this.ticking) {
            return;
        }
        this.ticking = true;
        window.requestAnimationFrame(this.update);
    }

    /**
     * Apply the scrolled state based on the current scroll offset.
     */
    update() {
        const shouldBeScrolled = window.scrollY >= this.threshold;

        if (shouldBeScrolled !== this.isScrolled) {
            this.isScrolled = shouldBeScrolled;
            this.element.classList.toggle('is-scrolled', shouldBeScrolled);
        }

        this.ticking = false;
    }
}
