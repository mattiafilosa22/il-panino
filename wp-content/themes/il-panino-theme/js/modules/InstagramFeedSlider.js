/**
 * Adds prev/next navigation arrows to the Spotlight Instagram feed grid,
 * turning it into a horizontally scrollable slider that matches the site UI.
 *
 * Spotlight renders the feed asynchronously, so we observe the section until
 * .FeedGridLayout__grid appears, then enhance it once.
 *
 * Important: we do NOT move the grid out of its parent — we mark the grid's
 * existing parent as the slider wrapper and append the arrows there. This
 * keeps Spotlight's DOM ownership intact, so the plugin can re-render or
 * load more posts without colliding with our enhancement.
 */
const prefersReducedMotion = () =>
    typeof window !== 'undefined'
    && typeof window.matchMedia === 'function'
    && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

export default class InstagramFeedSlider {
    constructor(section) {
        this.section = section;
        this.grid = null;
        this.wrapper = null;
        this.prevBtn = null;
        this.nextBtn = null;
        this.observer = null;
        this.gridMediaObserver = null;
        this.resizeObserver = null;
        this.scheduledFrame = null;
        this.scheduledTrack = null;
        this.enhanced = false;
        this.trackedImages = new WeakSet();
        this.boundUpdate = () => this.scheduleUpdate();
        this.boundKeydown = (e) => this.handleKeydown(e);
    }

    init() {
        if (!this.section) return;

        // Idempotency: if a previous instance owns this section, tear it down.
        const previous = this.section.__instagramFeedSlider;
        if (previous && previous !== this) previous.destroy();
        this.section.__instagramFeedSlider = this;

        const existing = this.section.querySelector('.FeedGridLayout__grid');
        if (existing) {
            this.enhance(existing);
            return;
        }

        this.observer = new MutationObserver(() => {
            const grid = this.section.querySelector('.FeedGridLayout__grid');
            if (grid && !this.enhanced) this.enhance(grid);
        });
        this.observer.observe(this.section, { childList: true, subtree: true });
    }

    enhance(grid) {
        // Defense in depth: skip if this grid's parent is already wrapped (e.g. plugin
        // re-rendered without unmounting our wrapper). Belt-and-braces with init()'s guard.
        if (grid.parentNode.classList.contains('c-instagram-feed__slider-wrapper')
            && grid.parentNode.querySelector('.c-instagram-feed__arrow')) {
            this.enhanced = true;
            return;
        }

        this.enhanced = true;
        this.grid = grid;
        if (this.observer) {
            this.observer.disconnect();
            this.observer = null;
        }

        this.wrapper = grid.parentNode;
        this.wrapper.classList.add('c-instagram-feed__slider-wrapper');

        this.prevBtn = this.makeArrow('prev', 'Scorri indietro');
        this.nextBtn = this.makeArrow('next', 'Scorri avanti');
        this.wrapper.appendChild(this.prevBtn);
        this.wrapper.appendChild(this.nextBtn);

        this.prevBtn.addEventListener('click', () => this.scroll(-1));
        this.nextBtn.addEventListener('click', () => this.scroll(1));

        grid.setAttribute('role', 'group');
        grid.setAttribute('aria-label', 'Feed Instagram');
        grid.setAttribute('tabindex', '0');
        grid.addEventListener('keydown', this.boundKeydown);
        grid.addEventListener('scroll', this.boundUpdate, { passive: true });
        window.addEventListener('resize', this.boundUpdate);

        if (typeof ResizeObserver !== 'undefined') {
            this.resizeObserver = new ResizeObserver(this.boundUpdate);
            this.resizeObserver.observe(grid);
        }

        // Track current images and re-track any image Spotlight injects later
        // (e.g. after "Load more"). Without this, arrow state would go stale.
        this.trackImages();
        this.gridMediaObserver = new MutationObserver((mutations) => {
            // Only walk the grid if nodes were actually added — Spotlight emits
            // many attribute/class mutations that don't introduce new media.
            if (!mutations.some(m => m.addedNodes.length > 0)) return;
            this.scheduleTrackImages();
        });
        this.gridMediaObserver.observe(grid, { childList: true, subtree: true });

        this.updateArrowState();
    }

    /**
     * Attach load + resize listeners to any <img> inside the grid we haven't
     * seen yet. Idempotent via a WeakSet so each image is wired exactly once.
     */
    trackImages() {
        if (!this.grid) return;
        this.grid.querySelectorAll('img').forEach((img) => {
            if (this.trackedImages.has(img)) return;
            this.trackedImages.add(img);
            if (this.resizeObserver) this.resizeObserver.observe(img);
            if (img.complete) return;
            img.addEventListener('load', this.boundUpdate, { once: true });
            img.addEventListener('error', this.boundUpdate, { once: true });
        });
    }

    scheduleTrackImages() {
        if (this.scheduledTrack) return;
        this.scheduledTrack = requestAnimationFrame(() => {
            this.scheduledTrack = null;
            this.trackImages();
            this.updateArrowState();
        });
    }

    makeArrow(direction, label) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = `c-instagram-feed__arrow c-instagram-feed__arrow--${direction}`;
        btn.setAttribute('aria-label', label);
        // SVG chevron — created via DOM API (no innerHTML) to satisfy XSS lints.
        const svgNS = 'http://www.w3.org/2000/svg';
        const svg = document.createElementNS(svgNS, 'svg');
        svg.setAttribute('viewBox', '0 0 24 24');
        svg.setAttribute('aria-hidden', 'true');
        svg.setAttribute('focusable', 'false');
        const path = document.createElementNS(svgNS, 'path');
        path.setAttribute('d', direction === 'prev'
            ? 'M15.5 4.5 8 12l7.5 7.5'
            : 'M8.5 4.5 16 12l-7.5 7.5');
        path.setAttribute('fill', 'none');
        path.setAttribute('stroke', 'currentColor');
        path.setAttribute('stroke-width', '2.5');
        path.setAttribute('stroke-linecap', 'round');
        path.setAttribute('stroke-linejoin', 'round');
        svg.appendChild(path);
        btn.appendChild(svg);
        return btn;
    }

    handleKeydown(e) {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            this.scroll(-1);
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            this.scroll(1);
        }
    }

    scrollStep() {
        const cell = this.grid.querySelector('.FeedGridLayout__cell');
        // Fallback only matters when the grid is empty (no cells, nothing to scroll).
        const cellWidth = cell ? cell.getBoundingClientRect().width : 280;
        // gap fallback for very old Safari that doesn't compute flex `gap` as columnGap.
        const gap = parseFloat(getComputedStyle(this.grid).columnGap) || 16;
        return cellWidth + gap;
    }

    scroll(direction) {
        if (!this.grid) return;
        const behavior = prefersReducedMotion() ? 'auto' : 'smooth';
        this.grid.scrollBy({ left: this.scrollStep() * direction, behavior });
    }

    scheduleUpdate() {
        if (this.scheduledFrame) return;
        this.scheduledFrame = requestAnimationFrame(() => {
            this.scheduledFrame = null;
            this.updateArrowState();
        });
    }

    updateArrowState() {
        if (!this.grid || !this.prevBtn || !this.nextBtn) return;
        const { scrollLeft, scrollWidth, clientWidth } = this.grid;
        const atStart = scrollLeft <= 1;
        const atEnd = scrollLeft + clientWidth >= scrollWidth - 1;
        this.prevBtn.disabled = atStart;
        this.nextBtn.disabled = atEnd;
        const overflows = scrollWidth > clientWidth + 1;
        const nextDisplay = overflows ? '' : 'none';

        // If we're about to hide an arrow that currently has focus, move focus
        // to the grid so keyboard users don't lose their place.
        const active = document.activeElement;
        if (!overflows && (active === this.prevBtn || active === this.nextBtn)) {
            this.grid.focus({ preventScroll: true });
        }

        this.prevBtn.style.display = nextDisplay;
        this.nextBtn.style.display = nextDisplay;
    }

    destroy() {
        if (this.observer) this.observer.disconnect();
        if (this.gridMediaObserver) this.gridMediaObserver.disconnect();
        if (this.resizeObserver) this.resizeObserver.disconnect();
        if (this.scheduledFrame) cancelAnimationFrame(this.scheduledFrame);
        if (this.scheduledTrack) cancelAnimationFrame(this.scheduledTrack);
        window.removeEventListener('resize', this.boundUpdate);
        if (this.grid) {
            this.grid.removeEventListener('scroll', this.boundUpdate);
            this.grid.removeEventListener('keydown', this.boundKeydown);
        }
        if (this.prevBtn) this.prevBtn.remove();
        if (this.nextBtn) this.nextBtn.remove();
        if (this.wrapper) this.wrapper.classList.remove('c-instagram-feed__slider-wrapper');
        if (this.section && this.section.__instagramFeedSlider === this) {
            delete this.section.__instagramFeedSlider;
        }
    }
}
