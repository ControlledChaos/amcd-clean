<?php
/**
 * Front page HTML output.
 *
 * @package WordPress
 * @subpackage AMCD_Theme
 * @since  1.0.0
 */

namespace AMCD_Theme;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

// Check for the Advanced Custom Fields plugin.
if ( class_exists( 'acf' ) ) :

    $intro_image = get_field( 'amcd_intro_image' );

    if ( ! empty( $intro_image ) ) {

        $url     = $intro_image['url'];
        $title   = $intro_image['title'];
        $alt     = $intro_image['alt'];
        $caption = $intro_image['caption'];
        $size    = 'large';
        $thumb   = $intro_image['sizes'][ $size ];
        $width   = $intro_image['sizes'][ $size . '-width' ];
        $height  = $intro_image['sizes'][ $size . '-height' ];
        $image   = '<div class="intro-image">';
        $image   .= sprintf(
            '<img src="%1s" alt="%2s" width="%3s" height="%4s" />',
            $url,
            $alt,
            $width,
            $height
        );
        $image   .= '</div>';

    } else {
        $image = null;
    }

else :
    $image = null;

// End check for ACF.
endif;

echo $image;