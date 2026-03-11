<?php
/**
 * Component: Hero Banner
 */

$hero_title = function_exists('get_field') ? get_field('hero_title') : '';
$hero_subtitle = function_exists('get_field') ? get_field('hero_subtitle') : '';
$hero_bg_image = function_exists('get_field') ? get_field('hero_bg_image') : '';

// Retrieve button settings from WordPress Customizer
$seguici_text = get_theme_mod('seguici_text', 'SEGUICI');
$seguici_link = get_theme_mod('seguici_link', '#');
$recensiscici_text = get_theme_mod('recensiscici_text', 'RECENSISCICI');
$recensiscici_link = get_theme_mod('recensiscici_link', '#');
?>

<section class="hero-section">
    <div class="hero-content-wrapper">
        
        <?php if($hero_title): ?>
            <h1 class="hero-title"><?php echo wp_kses_post(nl2br($hero_title)); ?></h1>
        <?php else: ?>
            <h1 class="hero-title"><?php the_title(); ?></h1>
        <?php endif; ?>
        
        <?php if($hero_bg_image): ?>
            <div class="hero-image-wrapper">
                <img src="<?php echo esc_url($hero_bg_image); ?>" alt="<?php echo esc_attr(strip_tags($hero_title)); ?>" class="hero-main-image">
            </div>
        <?php endif; ?>
        
        <?php if($hero_subtitle): ?>
            <p class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
        <?php endif; ?>
        
        <div class="hero-actions-bottom">
            <?php if($seguici_text): ?>
                <a href="<?php echo esc_url($seguici_link); ?>" class="btn btn-outline" data-text="<?php echo esc_attr($seguici_text); ?>" target="_blank" rel="noopener">
                    <span><?php echo esc_html($seguici_text); ?></span>
                </a>
            <?php endif; ?>
            <?php if($recensiscici_text): ?>
                <a href="<?php echo esc_url($recensiscici_link); ?>" class="btn btn-primary" data-text="<?php echo esc_attr($recensiscici_text); ?>" target="_blank" rel="noopener">
                    <span><?php echo esc_html($recensiscici_text); ?></span>
                </a>
            <?php endif; ?>
        </div>
        
    </div>
</section>