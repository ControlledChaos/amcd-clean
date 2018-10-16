<?php
/**
 * Alana Morshead Clean child theme functions.
 *
 * @package    WordPress
 * @subpackage AMCD_Clean
 * @author     Greg Sweet <greg@ccdzine.com>
 * @copyright  Copyright (c) 2017 - 2018, Greg Sweet
 * @link       https://github.com/ControlledChaos/amcd-clean
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @since      1.0.0
 */

namespace AMCD_Clean;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

// Get plugins path to check for active plugins.
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Controlled Chaos functions class.
 *
 * @since  1.0.0
 * @access public
 */
final class Functions {

    /**
	 * Return the instance of the class.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {

			$instance = new self;

			// Class hook functions.
			$instance->hooks();

			// Class filter functions.
			// $instance->filters();

			// Theme dependencies.
			// $instance->dependencies();

		}

		return $instance;
	}

	/**
	 * Constructor magic method.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		// Swap html 'no-js' class with 'js'.
		add_action( 'wp_head', [ $this, 'js_detect' ], 0 );

		// Controlled Chaos theme setup.
		add_action( 'after_setup_theme', [ $this, 'setup' ] );

        // Frontend styles.
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_styles' ] );

		// Frontend scripts.
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );

		// Admin styles.
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_styles' ] );

		// Add conditional body classes.
		add_filter( 'body_class', [ $this, 'body_classes' ] );

		// Front page scripts.
		add_action( 'wp_footer', [ $this, 'front_page_scripts' ], 20 );

		// Remove the user admin color scheme picker.
		remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

	}

	/**
	 * Replace 'no-js' class with 'js' in the <html> element when JavaScript is detected.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function js_detect() {

		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";

	}

	/**
	 * Theme setup.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function setup() {

		/**
		 * Load domain for translation.
		 *
		 * @since 1.0.0
		 */
		load_theme_textdomain( 'amcd-clean' );

		/**
		 * Add stylesheet for the content editor.
		 *
		 * @since 1.0.0
		 */
		add_editor_style( '/assets/css/editor-style.css', [ 'amcd-admin' ], '', 'screen' );

	}

	/**
	 * Hooks and filters.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function hooks() {

		// HTML before the site header.
		add_action( 'amcd_before_header_content', [ $this, 'before_header' ] );

		// HTML after the main navigation.
		add_action( 'amcd_after_main_nav', [ $this, 'after_nav' ] );

	}

	/**
	 * HTML before the site header.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function before_header() {

		if ( is_front_page() ) {
			echo '<div class="page-top-wrap front-body-wrap">';
		} else {
			echo '<div class="page-top-wrap">';
		}

	}

	/**
	 * HTML after the main navigation.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function after_nav() {

		echo '</div>';

	}

    /**
	 * Frontend styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function frontend_styles() {

		// Enqueue parent styles.
        wp_enqueue_style( 'amcd-parent', get_template_directory_uri() . '/style.css', [], '', 'screen' );

        // Enqueue child styles.
        wp_enqueue_style( 'amcd-child', get_stylesheet_uri(), [ 'amcd-parent' ], '', 'screen' );

		/**
		 * Check if we and/or Google are online. If so, get Google fonts
		 * from their servers. Otherwise, get them from the theme directory.
		 */
		$google = checkdnsrr( 'google.com' );

		if ( $google ) {
			wp_enqueue_style( 'amcd-fonts', 'https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700|Open+Sans:400,400i,600,600i,700,700i', [], '', 'screen' );
		}

		wp_enqueue_style( 'amcd-icons',  get_theme_file_uri( '/assets/icon-font/amcd-icons.min.css' ), [], '', 'screen' );

	}

	/**
	 * Admin styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_styles() {

		/**
		 * Check if we and/or Google are online. If so, get Google fonts
		 * from their servers. Otherwise, get them from the theme directory.
		 */
		$google = checkdnsrr( 'google.com' );

		if ( $google ) {
			wp_enqueue_style( 'amcd-fonts', 'https://fonts.googleapis.com/css?family=Montserrat:400,500,600|Open+Sans:400,400i,600,600i,700,700i', [], '', 'screen' );
		}

		// Admin styles.
		wp_enqueue_style( 'amcd-clean-admin',  get_theme_file_uri( '/assets/css/admin-theme.css' ), [], '', 'screen' );

	}

	/**
	 * Frontend scripts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function frontend_scripts() {}

	/**
	 * Add conditional body classes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function body_classes( $classes ) {

		if ( is_admin() ) {
			return;
		}

		// Check for the Advanced Custom Fields plugin.
		if ( class_exists( 'acf' ) ) {

			/**
			 * Front page intro image.
			 *
			 * @since 1.0.0
			 */
			$intro_image = get_field( 'amcd_intro_image' );

			if ( ! empty( $intro_image ) && is_front_page() ) {
				$classes[] = 'intro-has-image';
			}

		} else {
			$classes[] = null;
		} // End check for ACF.

		return $classes;

	}

	/**
	 * Front page scripts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function front_page_scripts() {

		/**
		 * FitText script for front page site title.
		 *
		 * @since  1.0.0
		 */

		// Check for the Advanced Custom Fields plugin.
		if ( class_exists( 'acf' ) ) :

			// Look for an image in the field.
			$intro_image = get_field( 'amcd_intro_image' );

			if ( ! empty( $intro_image ) && is_front_page() ) {

				$fit_text = '<script>!function(a){a.fn.fitText=function(b,c){var d=b||1,e=a.extend({minFontSize:Number.NEGATIVE_INFINITY,maxFontSize:Number.POSITIVE_INFINITY},c);return this.each(function(){var b=a(this),c=function(){b.css("font-size",Math.max(Math.min(b.width()/(10*d),parseFloat(e.maxFontSize)),parseFloat(e.minFontSize)))};c(),a(window).on("resize.fittext orientationchange.fittext",c)})}}(jQuery);jQuery(".home .site-title").fitText(1.2, { minFontSize: "24px", maxFontSize: "36px" });</script>';

			} elseif ( is_front_page() ) {

				$fit_text = '<script>!function(a){a.fn.fitText=function(b,c){var d=b||1,e=a.extend({minFontSize:Number.NEGATIVE_INFINITY,maxFontSize:Number.POSITIVE_INFINITY},c);return this.each(function(){var b=a(this),c=function(){b.css("font-size",Math.max(Math.min(b.width()/(10*d),parseFloat(e.maxFontSize)),parseFloat(e.minFontSize)))};c(),a(window).on("resize.fittext orientationchange.fittext",c)})}}(jQuery);jQuery(".home .site-title").fitText(1.2, { minFontSize: "28px", maxFontSize: "44px" });</script>';

			} else {
				$fit_text = null;
			}

			echo $fit_text;

		// If no ACF, no image. So use a larger max size for FitText.
		elseif ( is_front_page() ) :

			$fit_text = '<script>!function(a){a.fn.fitText=function(b,c){var d=b||1,e=a.extend({minFontSize:Number.NEGATIVE_INFINITY,maxFontSize:Number.POSITIVE_INFINITY},c);return this.each(function(){var b=a(this),c=function(){b.css("font-size",Math.max(Math.min(b.width()/(10*d),parseFloat(e.maxFontSize)),parseFloat(e.minFontSize)))};c(),a(window).on("resize.fittext orientationchange.fittext",c)})}}(jQuery);jQuery(".home .site-title").fitText(1.2, { minFontSize: "28px", maxFontSize: "44px" });</script>';

			echo $fit_text;

		// End check for ACF.
		endif;

		if ( is_front_page() ) {
			echo '
			<script>
			jQuery(".intro-slides").slick({
				autoplay: true,
				autoplaySpeed: 5000,
				slidesToShow: 1,
				arrows: false,
				dots: false,
				infinite: true,
				speed: 800,
				adaptiveHeight: false,
				variableWidth: false,
				draggable: false,
				fade: true
			});
			</script>';
		}

	}

}

/**
 * Gets the instance of the Functions class.
 *
 * This function is useful for quickly grabbing data
 * used throughout the theme.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function amcd_clean() {

	$amcd_clean = Functions::get_instance();

	return $amcd_clean;

}

// Run the Functions class.
amcd_clean();