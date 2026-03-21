<?php
/**
 * Component: Cross Slider (Fasce Marquee Diagonali)
 * Due fasce nere diagonali con frasi e icone in scorrimento continuo.
 */

$frasi = array(
    get_field('cross_slider_testo_1'),
    get_field('cross_slider_testo_2'),
    get_field('cross_slider_testo_3'),
);
$frasi = array_filter($frasi);

$icone = array(
    get_field('cross_slider_icona_1'),
    get_field('cross_slider_icona_2'),
    get_field('cross_slider_icona_3'),
    get_field('cross_slider_icona_4'),
);
$icone = array_filter($icone);
$icone_values = array_values($icone);
$num_icone = count($icone_values);

if ( empty($frasi) ) return;

$frasi_values = array_values($frasi);

// Due fasce con direzione diversa
$fasce = array(
    array('class' => 'c-cross-slider__band--1', 'direction' => 'left'),
    array('class' => 'c-cross-slider__band--2', 'direction' => 'right'),
);
?>

<section class="c-cross-slider" aria-hidden="true">
    <?php foreach ($fasce as $fascia) : ?>
        <div class="c-cross-slider__band <?php echo esc_attr($fascia['class']); ?>">
            <div class="c-cross-slider__marquee js-marquee" data-direction="<?php echo esc_attr($fascia['direction']); ?>">
                <div class="c-cross-slider__marquee-scroll">
                    <?php for ($repeat = 0; $repeat < 3; $repeat++) : ?>
                        <div class="c-cross-slider__marquee-group">
                            <p class="c-cross-slider__text">
                                <?php
                                $icona_index = 0;
                                foreach ($frasi_values as $frase) :
                                    ?>
                                    <span class="c-cross-slider__phrase"><?php echo esc_html($frase); ?></span>
                                    <?php if ($num_icone > 0) :
                                        $icona_url = $icone_values[$icona_index % $num_icone];
                                        $icona_index++;
                                    ?>
                                        <img class="c-cross-slider__icon"
                                             src="<?php echo esc_url($icona_url); ?>"
                                             alt="" aria-hidden="true" loading="lazy">
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </p>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</section>
