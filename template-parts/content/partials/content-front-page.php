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
    if ( have_rows( 'amcd_intro_slides' ) ) : ?>
    <div class="intro-image">
        <div id="slick-flexbox-fix"><!-- Stops SlickJS from getting original image rather than the intro-large size" -->
            <ul class="intro-slides">
                <?php while ( have_rows( 'amcd_intro_slides' ) ) : the_row();
                $image  = get_sub_field( 'amcd_intro_image' );
                $size   = 'intro-large';
                $thumb  = $image['sizes'][ $size ];
                $width  = $image['sizes'][ $size . '-width' ];
                $height = $image['sizes'][ $size . '-height' ]; ?>
                <li class="slide">
                    <img src="<?php echo $thumb; ?>" alt="<?php echo $image['alt'] ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
    <?php endif;
endif;