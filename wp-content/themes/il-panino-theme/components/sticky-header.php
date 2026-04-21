<?php
/**
 * Component: Sticky Header
 *
 * Floating header that becomes visible on scroll.
 * Markup only — visibility is toggled by the frontend JS
 * via the `.is-visible` class, which also flips `aria-hidden`
 * from `true` (initial) to `false`.
 *
 * Frontend contract (DOM / CSS):
 * - Root:             .sticky-header        [data-sticky-threshold="300"] [aria-hidden="true"]
 * - Inner wrapper:    .sticky-header__inner
 * - Wordmark (top):   .sticky-header__wordmark         (primary/red color)
 * - Dark pill:        .sticky-header__pill
 *   - Nav:            .sticky-header__nav
 *     - Menu UL:      .sticky-header__nav-list        (rendered by wp_nav_menu)
 *   - Actions:        .sticky-header__actions
 *     - CTA "follow": .sticky-header__btn.sticky-header__btn--seguici     (.btn.btn-outline)
 *     - CTA "review": .sticky-header__btn.sticky-header__btn--recensiscici (.btn.btn-primary)
 *
 * Visibility state (set by frontend JS):
 * - hidden  -> no `.is-visible` class, `aria-hidden="true"`
 * - visible -> `.is-visible` class added, `aria-hidden="false"`
 *
 * @package il-panino-theme
 */

$seguici_text      = get_theme_mod( 'seguici_text', 'SEGUICI' );
$seguici_link      = get_theme_mod( 'seguici_link', '#' );
$recensiscici_text = get_theme_mod( 'recensiscici_text', 'RECENSISCICI' );
$recensiscici_link = get_theme_mod( 'recensiscici_link', '#' );
?>

<div class="sticky-header" data-sticky-threshold="300" aria-hidden="true">
    <div class="sticky-header__inner">
        <a class="sticky-header__wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <?php esc_html_e( 'IL PANINO BOLOGNA', 'il-panino-theme' ); ?>
        </a>

        <div class="sticky-header__pill">
            <nav class="sticky-header__nav" aria-label="<?php esc_attr_e( 'Primary', 'il-panino-theme' ); ?>">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'menu-1',
                    'menu_id'        => 'sticky-primary-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                    'items_wrap'     => '<ul id="%1$s" class="%2$s sticky-header__nav-list">%3$s</ul>',
                    'depth'          => 1,
                ) );
                ?>
            </nav>

            <div class="sticky-header__actions">
                <a href="<?php echo esc_url( $seguici_link ); ?>"
                   class="btn btn-outline sticky-header__btn sticky-header__btn--seguici"
                   data-text="<?php echo esc_attr( $seguici_text ); ?>"
                   target="_blank"
                   rel="noopener">
                    <span><?php echo esc_html( $seguici_text ); ?></span>
                </a>
                <a href="<?php echo esc_url( $recensiscici_link ); ?>"
                   class="btn btn-primary sticky-header__btn sticky-header__btn--recensiscici"
                   data-text="<?php echo esc_attr( $recensiscici_text ); ?>"
                   target="_blank"
                   rel="noopener">
                    <span><?php echo esc_html( $recensiscici_text ); ?></span>
                </a>
            </div>
        </div>
    </div>
</div>
