/**
 * MenuCoreFilter
 * Responsabilità: filtraggio delle card menù per categoria.
 */
export default class MenuCoreFilter {
    constructor(container) {
        this.container = container;
        this.filters = container.querySelectorAll('.js-menu-filter');
        this.cards = container.querySelectorAll('.js-menu-card');
    }

    init() {
        this.filters.forEach(btn => {
            btn.addEventListener('click', () => this.filterBy(btn));
        });
    }

    filterBy(activeBtn) {
        const category = activeBtn.dataset.category;

        // Aggiorna stato attivo dei pulsanti
        this.filters.forEach(btn => {
            btn.classList.remove('is-active');
            btn.setAttribute('aria-selected', 'false');
        });
        activeBtn.classList.add('is-active');
        activeBtn.setAttribute('aria-selected', 'true');

        // Filtra le card
        this.cards.forEach(card => {
            const cardCategories = card.dataset.categories || '';

            if (category === 'all' || cardCategories.split(' ').includes(category)) {
                card.classList.remove('is-hidden');
            } else {
                card.classList.add('is-hidden');
            }
        });
    }
}
