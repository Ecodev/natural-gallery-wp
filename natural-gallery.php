<?php

/*
Plugin Name: Natural Gallery
Description: A lazy load, infinite scroll and natural layout list gallery
Version: 1.0
Author: Ecodev Sàrl
Author URI: http://ecodev.ch
License: GPL
*/

// Load shortcode and media settings
include('includes/adminSettings.php');
include('includes/shortcode.php');

// Create gallery thumbnails
add_image_size ('natural_gallery_preview', 0, ((int)  get_option('thumbnail_size_h') * 0.5), false);
add_image_size ('natural_gallery_thumbnail', 0, get_option('thumbnail_size_h'), false);
add_image_size ('natural_gallery_medium', 0, ((int)  get_option('thumbnail_size_h') * 1.5), false);
add_filter( 'image_size_names_choose', 'infinite_scroll_image_sizes' );

function infinite_scroll_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'natural_gallery_preview' => __( 'Gallery preview'),
        'natural_gallery_thumbnail' => __( 'Gallery thumbnail'),
        'natural_gallery_medium' => __( 'Gallery medium' ),
    ) );
}
