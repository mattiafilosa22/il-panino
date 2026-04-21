<?php
/**
 * Component: Header
 *
 * @package il-panino-theme
 */
?>

<?php
$seguici_text = get_theme_mod( 'seguici_text', 'SEGUICI' );
$seguici_link = get_theme_mod( 'seguici_link', '#' );
$recensiscici_text = get_theme_mod( 'recensiscici_text', 'RECENSISCICI' );
$recensiscici_link = get_theme_mod( 'recensiscici_link', '#' );
?>

<header class="site-header" data-sticky-threshold="300">
    <div class="header-container">
        
        <!-- Sinistra: Navigazione -->
        <nav class="header-nav-left desktop-only">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'menu-1',
                'menu_id'        => 'primary-menu',
                'container'      => false,
                'fallback_cb'    => false,
                'items_wrap'     => '<ul id="%1$s" class="%2$s nav-list">%3$s</ul>',
            ) );
            ?>
        </nav>

        <!-- Hamburger Icon (Mobile Only) -->
        <button class="menu-toggle mobile-only" aria-controls="primary-menu" aria-expanded="false" aria-label="Apri menu">
            <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <!-- Centro: Logo / Titolo -->
        <div class="header-logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                IL PANINO BOLOGNA
            </a>
        </div>

        <!-- Destra: Bottoni -->
        <div class="header-actions desktop-only">
            <a href="<?php echo esc_url($seguici_link); ?>" class="btn btn-outline" data-text="<?php echo esc_attr($seguici_text); ?>" target="_blank" rel="noopener">
                <span><?php echo esc_html($seguici_text); ?></span>
            </a>
            <a href="<?php echo esc_url($recensiscici_link); ?>" class="btn btn-primary" data-text="<?php echo esc_attr($recensiscici_text); ?>" target="_blank" rel="noopener">
                <span><?php echo esc_html($recensiscici_text); ?></span>
            </a>
        </div>

    </div>
</header>

<!-- Mobile Menu Overlay -->
<div class="mobile-nav-overlay">
    <div class="mobile-nav-inner">
        <button class="mobile-nav-close" aria-label="Chiudi menu">
            <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <?php
        wp_nav_menu( array(
            'theme_location' => 'menu-1',
            'container'      => 'nav',
            'container_class'=> 'mobile-menu-wrapper',
            'fallback_cb'    => false,
        ) );
        ?>
        <div class="mobile-actions">
            <a href="<?php echo esc_url($seguici_link); ?>" class="btn btn-outline" data-text="<?php echo esc_attr($seguici_text); ?>" target="_blank" rel="noopener"><span><?php echo esc_html($seguici_text); ?></span></a>
            <a href="<?php echo esc_url($recensiscici_link); ?>" class="btn btn-primary" data-text="<?php echo esc_attr($recensiscici_text); ?>" target="_blank" rel="noopener"><span><?php echo esc_html($recensiscici_text); ?></span></a>
        </div>
    </div>
</div>
