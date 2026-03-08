<?php
/**
 * Template Name: Menù
 *
 * @package il-panino-theme
 */

get_header(); ?>

<main id="primary" class="site-main menu-template">
    <header class="page-header">
        <h1><?php the_title(); ?></h1>
    </header>

    <div class="menu-content">
        <?php
        // Contenuto classico di WordPress (es. descrizione introduttiva del menù)
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
        ?>

        <?php
        // Esempio di struttura ACF con Repeater per le categorie e i prodotti del menù
        if( have_rows('menu_categories') ): ?>
            <div class="menu-categories-wrapper">
                <?php while( have_rows('menu_categories') ): the_row(); 
                    $category_name = get_sub_field('category_name');
                    ?>
                    
                    <section class="menu-category">
                        <?php if($category_name): ?>
                            <h2><?php echo esc_html($category_name); ?></h2>
                        <?php endif; ?>
                        
                        <?php if( have_rows('menu_items') ): ?>
                            <ul class="menu-items-list">
                                <?php while( have_rows('menu_items') ): the_row();
                                    $item_name = get_sub_field('item_name');
                                    $item_description = get_sub_field('item_description');
                                    $item_price = get_sub_field('item_price');
                                ?>
                                    <li class="menu-item">
                                        <div class="menu-item-header">
                                            <h3><?php echo esc_html($item_name); ?></h3>
                                            <span class="price"><?php echo esc_html($item_price); ?></span>
                                        </div>
                                        <?php if($item_description): ?>
                                            <p class="description"><?php echo esc_html($item_description); ?></p>
                                        <?php endif; ?>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>
                        
                    </section>
                    
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Nessuna categoria menù trovata. Aggiungi i campi ACF dal pannello di controllo.</p>
        <?php endif; ?>
    </div>
</main><!-- #main -->

<?php
get_footer();
