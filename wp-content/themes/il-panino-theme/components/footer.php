<?php
/**
 * Footer component - Tutti i campi gestiti via ACF
 *
 * @package il-panino-theme
 */

$sitemap_titolo  = get_field('footer_sitemap_titolo') ?: 'Sitemap';
$contatti_titolo = get_field('footer_contatti_titolo') ?: 'Contatti';
$indirizzo_1     = get_field('footer_indirizzo_1');
$indirizzo_2     = get_field('footer_indirizzo_2');
$email           = get_field('footer_email');
$btn_seguici     = get_field('footer_btn_seguici');
$btn_trovaci     = get_field('footer_btn_trovaci');
$copyright       = get_field('footer_copyright') ?: 'Il Panino Bologna. Tutti i Diritti Riservati.';
$credits_nome    = get_field('footer_credits_nome') ?: 'Mattia Filosa';
$credits_url     = get_field('footer_credits_url');
?>

<footer class="c-footer">
    <div class="c-footer__main">
        <div class="c-footer__content">

            <!-- Colonna Sitemap -->
            <div class="c-footer__col c-footer__col--sitemap">
                <h3 class="c-footer__heading"><?php echo esc_html($sitemap_titolo); ?></h3>
                <nav class="c-footer__nav" aria-label="Footer navigation">
                    <ul class="c-footer__nav-list">
                        <li class="c-footer__nav-item">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="c-footer__nav-link">Home</a>
                        </li>
                        <li class="c-footer__nav-item">
                            <a href="<?php echo esc_url( home_url( '/il-menu' ) ); ?>" class="c-footer__nav-link">Il Menu</a>
                        </li>
                        <li class="c-footer__nav-item">
                            <a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>" class="c-footer__nav-link">Privacy &amp; Policy</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Colonna Contatti -->
            <div class="c-footer__col c-footer__col--contatti">
                <h3 class="c-footer__heading"><?php echo esc_html($contatti_titolo); ?></h3>

                <?php if ($indirizzo_1 || $indirizzo_2) : ?>
                    <address class="c-footer__address">
                        <?php if ($indirizzo_1) : ?>
                            <p class="c-footer__address-line"><?php echo esc_html($indirizzo_1); ?></p>
                        <?php endif; ?>
                        <?php if ($indirizzo_2) : ?>
                            <p class="c-footer__address-line"><?php echo esc_html($indirizzo_2); ?></p>
                        <?php endif; ?>
                    </address>
                <?php endif; ?>

                <?php if ($email) : ?>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="c-footer__email"><?php echo esc_html($email); ?></a>
                <?php endif; ?>

                <div class="c-footer__buttons">
                    <?php if ($btn_seguici) : ?>
                        <a href="<?php echo esc_url($btn_seguici); ?>" class="c-footer__btn c-footer__btn--seguici" target="_blank" rel="noopener noreferrer">Seguici</a>
                    <?php endif; ?>
                    <?php if ($btn_trovaci) : ?>
                        <a href="<?php echo esc_url($btn_trovaci); ?>" class="c-footer__btn c-footer__btn--trovaci" target="_blank" rel="noopener noreferrer">Trovaci</a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <div class="c-footer__bottom">
        <div class="c-footer__bottom-content">
            <span class="c-footer__copyright">&copy; <?php echo date('Y'); ?> <?php echo esc_html($copyright); ?></span>
            
        </div>
    </div>
</footer>
