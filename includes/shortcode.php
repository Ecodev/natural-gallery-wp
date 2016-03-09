<?php

/**
 * Proper way to enqueue scripts and styles
 */
function naturalScripts()
{
    // Scripts
    wp_enqueue_script('naturalGalleryPhotoswipe', plugins_url('../resources/javascript/photoswipe.min.js', __FILE__), [], '1.1.2', true);
    wp_enqueue_script('naturalGalleryPhotoswipeTheme', plugins_url('../resources/javascript/photoswipe-ui-default.min.js', __FILE__), [], '1.1.2', true);
    wp_enqueue_script('naturalGalleryJs', plugins_url('../resources/javascript/natural-gallery.min.js', __FILE__), [], '1.1.2', true);

    // Styles
    wp_enqueue_style('naturalGalleryPhotoswipe', plugins_url('../resources/stylesheets/photoswipe/photoswipe.css', __FILE__), [], '1.1.2', 'all');
    wp_enqueue_style('naturalGalleryPhotoswipeTheme', plugins_url('../resources/stylesheets/photoswipe/default-skin/default-skin.css', __FILE__), [], '1.1.2', 'all');
    wp_enqueue_style('naturalGalleryMasterStyle', plugins_url('../resources/stylesheets/natural-gallery/natural-gallery.min.css', __FILE__), [], '1.1.2', 'all');
    wp_enqueue_style('naturalGalleryThemeStyle', plugins_url('../resources/stylesheets/natural-gallery/themes/natural.css', __FILE__), [], '1.1.2', 'all');
}


function photoswipeTemplate() {
    echo include('templates/photoswipe.php');
    echo include('templates/icons.php');
}

function natural_gallery_shortcode($output = '', $attr, $instance)
{
    // Use default gallery if infinite scroll is disabled
    if (!isset($attr['active']) || $attr['active'] != 'true') {
        return null;
    }

    naturalScripts();
    add_action('wp_footer', 'photoswipeTemplate');

    $post = get_post();

    $atts = shortcode_atts(array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post ? $post->ID : 0,
        'columns' => 3,
        'size' => 'medium',
        'include' => '',
        'exclude' => '',
        'link' => ''
    ), $attr, 'gallery');

    $id = intval($atts['id']);

    if (!empty($atts['include'])) {
        $_attachments = get_posts(array(
            'include' => $atts['include'],
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $atts['order'],
            'orderby' => $atts['orderby']
        ));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif (!empty($atts['exclude'])) {
        $attachments = get_children(array(
            'post_parent' => $id,
            'exclude' => $atts['exclude'],
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $atts['order'],
            'orderby' => $atts['orderby']
        ));
    } else {
        $attachments = get_children(array(
            'post_parent' => $id,
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $atts['order'],
            'orderby' => $atts['orderby']
        ));
    }

    if (empty($attachments)) {
        return '';
    }

    if (is_feed()) {
        $output = "\n";
        foreach ($attachments as $att_id => $attachment) {
            $output .= wp_get_attachment_link($att_id, $atts['size'], true) . "\n";
        }

        return $output;
    }

    $attr['thumbnailmaximumheight'] = 0;

    $items = [];
    foreach ($attachments as $id => $attachment) {

        $thumbHeight = wp_get_attachment_image_src($id, $atts['size'])[2];
        if ($thumbHeight > $attr['thumbnailmaximumheight']) {
            $attr['thumbnailmaximumheight'] = $thumbHeight;
        }

        $item = [
            'thumbnail' => wp_get_attachment_image_src($id, $atts['size'])[0],
            'enlarged' => wp_get_attachment_image_src($id, 'full')[0],
            'id' => $id,
            'title' => $attachment->post_excerpt,
            'thumbName' => $atts['size'],
            'tWidth' => wp_get_attachment_image_src($id, $atts['size'])[1],
            'tHeight' => wp_get_attachment_image_src($id, $atts['size'])[2],
            'eWidth' => wp_get_attachment_image_src($id, 'full')[1],
            'eHeight' => wp_get_attachment_image_src($id, 'full')[2],
        ];

        $items[] = $item;
    }

    // variables used in templates
    $items = json_encode($items);

    $output = require('templates/gallery.php');

    return $output;

}

add_filter('post_gallery', 'natural_gallery_shortcode', 10, 3);
