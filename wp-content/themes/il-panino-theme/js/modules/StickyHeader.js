/**
 * StickyHeader
 *
 * Toggles the visibility of the floating sticky header on scroll.
 * Adds `.is-visible` and sets `aria-hidden="false"` when the vertical
 * scroll offset passes the threshold declared on the root element via
 * `data-sticky-threshold` (fallback: 300px). Hides it otherwise.
 *
 * Performance: the scroll listener is throttled using
 * `requestAnimationFrame` so state is updated at most once per frame.
 *
 * Accessibility: the CSS transition is disabled via
 * `@media (prefers-reduced-motion: reduce)`; this module only toggles
 * a class and an ARIA attribute — no JS-driven animation.
 *
 * SRP: this class owns the single responsibility of syncing the
 * sticky header's visibility state with the scroll position.
 */
export default class StickyHeader {
    /**
     * @param {HTMLElement} element - The `.sticky-header` root element.
     */
    constructor(element) {
        this.element = element;

        const attr = element && element.dataset ? element.dataset.stickyThreshold : null;
        const parsed = attr !== null && attr !== undefined ? parseInt(attr, 10) : NaN;
        this.threshold = Number.isFinite(parsed) && parsed >= 0 ? parsed : 300;

        this.isVisible = false;
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
     * Apply the visibility state based on the current scroll offset.
     */
    update() {
        const shouldBeVisible = window.scrollY >= this.threshold;

        if (shouldBeVisible !== this.isVisible) {
            this.isVisible = shouldBeVisible;
            this.element.classList.toggle('is-visible', shouldBeVisible);
            this.element.setAttribute('aria-hidden', shouldBeVisible ? 'false' : 'true');
        }

        this.ticking = false;
    }
}
