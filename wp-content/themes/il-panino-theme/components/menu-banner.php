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

$title       = get_field( 'menu_banner_title' );
$subtitle    = get_field( 'menu_banner_subtitle' );
$cta_text    = get_field( 'menu_banner_cta_text' );
$cta_link    = get_field( 'menu_banner_cta_link' );
$image_left  = get_field( 'menu_banner_image_left' );
$image_right = get_field( 'menu_banner_image_right' );

// Nothing meaningful to render? Bail out gracefully.
if ( empty( $title ) && empty( $subtitle ) && empty( $cta_text ) ) {
    return;
}

$spacing       = il_panino_get_spacing_classes( 'menu_banner' );
$theme_uri     = trailingslashit( get_template_directory_uri() );
$images_base   = $theme_uri . 'assets/images/menu-banner/';
$left_url      = ! empty( $image_left['url'] ) ? $image_left['url'] : $images_base . 'fries-basket.png';
$left_alt      = ! empty( $image_left['alt'] ) ? $image_left['alt'] : __( 'Cestino di frittini croccanti', 'il-panino-theme' );
$right_url     = ! empty( $image_right['url'] ) ? $image_right['url'] : $images_base . 'soda-can.png';
$right_alt     = ! empty( $image_right['alt'] ) ? $image_right['alt'] : __( 'Lattina di bevanda ghiacciata', 'il-panino-theme' );
$has_cta_link  = ! empty( $cta_link );
$has_cta_label = ! empty( $cta_text );
?>

<section class="c-menu-banner <?php echo esc_attr( $spacing ); ?>">
    <div class="container">
        <div class="c-menu-banner__inner">

            <img
                src="<?php echo esc_url( $left_url ); ?>"
                alt="<?php echo esc_attr( $left_alt ); ?>"
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
                src="<?php echo esc_url( $right_url ); ?>"
                alt="<?php echo esc_attr( $right_alt ); ?>"
                class="c-menu-banner__art c-menu-banner__art--right"
                loading="lazy"
                decoding="async"
            >

        </div>
    </div>
</section>
