<?php
/**
 * Footer HTML and content output.
 *
 * @package WordPress
 * @subpackage AMCD_Theme
 * @since  1.0.0
 */

namespace AMCD_Theme;

// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit;

do_action( 'amcd_before_footer_content' );

    echo '<div class="footer-content global-wrapper footer-wrapper">', "\r";

        $site_name      = esc_attr( get_bloginfo( 'name' ) );
        $copyright_text = sprintf( '<p class="copyright-text" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">&copy; <span class="screen-reader-text">%1s</span><span itemprop="copyrightYear">%2s</span> <span itemprop="copyrightHolder">%3s.</span></p>', esc_html__( 'Copyright ', 'amcd-theme' ), get_the_time( 'Y' ), $site_name );

        $copyright = apply_filters( 'amcd_copyright_text', $copyright_text );

        if ( ! is_front_page() ) {
            echo $copyright, "\r";
        }

    echo '</div><!-- footer-content -->', "\r";

do_action( 'amcd_after_footer_content' );