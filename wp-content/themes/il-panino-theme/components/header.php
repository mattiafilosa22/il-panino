<?php
/**
 * Component: Header
 *
 * @package il-panino-theme
 */
?>

<header class="site-header">
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
        <button class="menu-toggle mobile-only" aria-controls="primary-menu" aria-expanded="false">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>

        <!-- Centro: Logo / Titolo -->
        <div class="header-logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                IL PANINO BOLOGNA
            </a>
        </div>

        <!-- Destra: Bottoni -->
        <div class="header-actions desktop-only">
            <a href="#" class="btn btn-outline" data-text="SEGUICI">
                <span>SEGUICI</span>
            </a>
            <a href="#" class="btn btn-primary" data-text="RECENSISCICI">
                <span>RECENSISCICI</span>
            </a>
        </div>

    </div>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-nav-overlay">
        <div class="mobile-nav-inner">
            <button class="mobile-nav-close">&times;</button>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'menu-1',
                'container'      => 'nav',
                'container_class'=> 'mobile-menu-wrapper',
                'fallback_cb'    => false,
            ) );
            ?>
            <div class="mobile-actions">
                <a href="#" class="btn btn-outline" data-text="SEGUICI"><span>SEGUICI</span></a>
                <a href="#" class="btn btn-primary" data-text="RECENSISCICI"><span>RECENSISCICI</span></a>
            </div>
        </div>
    </div>
</header>
