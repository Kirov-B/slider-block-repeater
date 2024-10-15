<?php

/**
 * Slider section with slider and information.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Support custom "anchor" values. 
// dont change this 
$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'slider-repeater-section';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $class_name .= ' align' . $block['align'];
}


$is_editor = isset($is_preview) && $is_preview;

$sliders_to_show = get_field('sliders_to_show') ?: 3;
$slider_to_show_tablet = get_field('slider_to_show_tablet') ?: 2;
$slider_to_show_mobile = get_field('slider_to_show_mobile') ?: 1;
$show_arrows = get_field('show_arrows') == 1 ? true : false;
$show_dots = get_field('show_dots') == 1 ? true : false;

// Add data attributes to the section
$data_attributes = sprintf(
    'data-slides-to-show="%s" data-slides-to-show-tablet="%s" data-slides-to-show-mobile="%s" data-show-arrows="%s" data-show-dots="%s"',
    esc_attr($sliders_to_show),
    esc_attr($slider_to_show_tablet),
    esc_attr($slider_to_show_mobile),
    esc_attr($show_arrows ? 'true' : 'false'),
    esc_attr($show_dots ? 'true' : 'false')
);

$slider = get_field('slider_gallery');
if ($slider): ?>
<section <?php echo $anchor; ?>
    class="<?php echo esc_attr($class_name); ?><?php echo $is_editor ? ' is-editor' : ''; ?>"
    <?php echo $data_attributes; ?>>
    <ul class="slider-repeater">
        <?php foreach ($slider as $sliderSingle):
                $image = $sliderSingle['image'];
                $overlayText = $sliderSingle['overlay_text'];
            ?>
        <li>
            <div class="image__container">
                <?php
                        if ($image) {
                            echo wp_get_attachment_image($image, 'full');
                        }   else {
                            echo '<img src="' . plugin_dir_url(__DIR__) . 'assets/images/placeholder.png" alt="Placeholder image" />';
                        }
                        ?>
            </div>
            <?php if ($overlayText): ?>
            <div class="overlay">
                <h2><?php echo $overlayText; ?></h2>
            </div>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
</section>
<?php 
else :
    if ($is_editor):
        echo '<section class="' . esc_attr($class_name) . ' is-editor no__slides">';
         echo '<h3>Please Insert Slides</h3>';
        echo '</section>';
        endif;
endif;