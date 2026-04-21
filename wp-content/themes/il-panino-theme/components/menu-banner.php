<?php
/**
 * Component: Menu Banner ("Completa il tuo menu")
 *
 * Promotional banner on the menu page inviting users to add sides + drink
 * to their sandwich order. Content fully configurable via ACF.
 */

// Early-return guard: component is fully opt-in via ACF toggle.
if ( ! function_exists( 'get_field' ) || ! get_field( 'menu_banner_visible' ) ) {
    return;
}

$title    = get_field( 'menu_banner_title' );
$subtitle = get_field( 'menu_banner_subtitle' );
$cta_text = get_field( 'menu_banner_cta_text' );
$cta_link = get_field( 'menu_banner_cta_link' );

// Nothing meaningful to render? Bail out gracefully.
if ( empty( $title ) && empty( $subtitle ) && empty( $cta_text ) ) {
    return;
}

$spacing       = il_panino_get_spacing_classes( 'menu_banner' );
$images_base   = trailingslashit( get_template_directory_uri() ) . 'assets/images/menu-banner/';
$fries_src     = $images_base . 'fries-basket.png';
$soda_src      = $images_base . 'soda-can.png';
$has_cta_link  = ! empty( $cta_link );
$has_cta_label = ! empty( $cta_text );
?>

<section class="c-menu-banner <?php echo esc_attr( $spacing ); ?>">
    <div class="container">
        <div class="c-menu-banner__inner">

            <img
                src="<?php echo esc_url( $fries_src ); ?>"
                alt="<?php echo esc_attr__( 'Cestino di frittini croccanti', 'il-panino-theme' ); ?>"
                class="c-menu-banner__art c-menu-banner__art--left"
                loading="lazy"
                decoding="async"
            >

            <div class="c-menu-banner__content">
                <?php if ( ! empty( $title ) ) : ?>
                    <h2 class="c-menu-banner__title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( ! empty( $subtitle ) ) : ?>
                    <p class="c-menu-banner__subtitle"><?php echo wp_kses_post( $subtitle ); ?></p>
                <?php endif; ?>

                <?php if ( $has_cta_label ) : ?>
                    <?php if ( $has_cta_link ) : ?>
                        <a
                            class="c-menu-banner__cta btn btn-primary"
                            href="<?php echo esc_url( $cta_link ); ?>"
                        >
                            <span><?php echo esc_html( $cta_text ); ?></span>
                        </a>
                    <?php else : ?>
                        <span
                            class="c-menu-banner__cta btn btn-primary is-disabled"
                            aria-disabled="true"
                        >
                            <span><?php echo esc_html( $cta_text ); ?></span>
                        </span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <img
                src="<?php echo esc_url( $soda_src ); ?>"
                alt="<?php echo esc_attr__( 'Lattina di bevanda ghiacciata', 'il-panino-theme' ); ?>"
                class="c-menu-banner__art c-menu-banner__art--right"
                loading="lazy"
                decoding="async"
            >

        </div>
    </div>
</section>
