<?php

/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

define('HELLO_ELEMENTOR_VERSION', '2.7.1');

if (!isset($content_width)) {
	$content_width = 800; // Pixels.
}

if (!function_exists('hello_elementor_setup')) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup()
	{
		if (is_admin()) {
			hello_maybe_update_theme_version_in_db();
		}

		if (apply_filters('hello_elementor_register_menus', true)) {
			register_nav_menus(['menu-1' => esc_html__('Header', 'hello-elementor')]);
			register_nav_menus(['menu-2' => esc_html__('Footer', 'hello-elementor')]);
		}

		if (apply_filters('hello_elementor_post_type_support', true)) {
			add_post_type_support('page', 'excerpt');
		}

		if (apply_filters('hello_elementor_add_theme_support', true)) {
			add_theme_support('post-thumbnails');
			add_theme_support('automatic-feed-links');
			add_theme_support('title-tag');
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);

			/*
			 * Editor Style.
			 */
			add_editor_style('classic-editor.css');

			/*
			 * Gutenberg wide images.
			 */
			add_theme_support('align-wide');

			/*
			 * WooCommerce.
			 */
			if (apply_filters('hello_elementor_add_woocommerce_support', true)) {
				// WooCommerce in general.
				add_theme_support('woocommerce');
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support('wc-product-gallery-zoom');
				// lightbox.
				add_theme_support('wc-product-gallery-lightbox');
				// swipe.
				add_theme_support('wc-product-gallery-slider');
			}
		}
	}
}
add_action('after_setup_theme', 'hello_elementor_setup');

function hello_maybe_update_theme_version_in_db()
{
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option($theme_version_option_name);

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if (!$hello_theme_db_version || version_compare($hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<')) {
		update_option($theme_version_option_name, HELLO_ELEMENTOR_VERSION);
	}
}

if (!function_exists('hello_elementor_scripts_styles')) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles()
	{
		$min_suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		if (apply_filters('hello_elementor_enqueue_style', true)) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if (apply_filters('hello_elementor_enqueue_theme_style', true)) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action('wp_enqueue_scripts', 'hello_elementor_scripts_styles');

if (!function_exists('hello_elementor_register_elementor_locations')) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations($elementor_theme_manager)
	{
		if (apply_filters('hello_elementor_register_elementor_locations', true)) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action('elementor/theme/register_locations', 'hello_elementor_register_elementor_locations');

if (!function_exists('hello_elementor_content_width')) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width()
	{
		$GLOBALS['content_width'] = apply_filters('hello_elementor_content_width', 800);
	}
}
add_action('after_setup_theme', 'hello_elementor_content_width', 0);




add_action('admin_enqueue_scripts', 'load_admin_styles');
add_action('login_enqueue_scripts', 'load_admin_styles', 10);
function load_admin_styles()
{
	wp_enqueue_style('code_admin_css', get_template_directory_uri() . '/assets/css/code.css', false, '1.0.0');
}
add_action('admin_enqueue_scripts', 'load_admin_scripts', 10);
add_action('login_enqueue_scripts', 'load_admin_scripts', 10);
function load_admin_scripts()
{
	wp_enqueue_script('code_admin_js', get_stylesheet_directory_uri() . '/assets/js/code.js', null, null, true);
}

// Allowed SVG
function cc_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


function code_scripts() {

	    // Enqueue jQuery from CDN
		wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', [], null, true);
    // Enqueue Bootstrap CSS
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/src/bootstrap/css/bootstrap.min.css', [], null);

    // Enqueue main stylesheet
    wp_enqueue_style('code-style', get_template_directory_uri() . '/assets/css/main.css', [], null);


    // Register Bootstrap Bundle JS (includes Popper)
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/src/bootstrap/js/bootstrap.bundle.min.js', null, true);

    // Register main script, ensuring it loads after Bootstrap
    wp_register_script('code-script', get_template_directory_uri() . '/assets/js/main.js', ['bootstrap-js'], null, true);
    wp_enqueue_script('code-script');
}
add_action('wp_enqueue_scripts', 'code_scripts');

function enqueue_custom_scripts() {
    // Enqueue Swiper styles and scripts
    wp_enqueue_style('swiper-style', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.3.2/swiper-bundle.css', [], null);
    wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper@9/swiper-bundle.min.js',  null, true);

    // Enqueue your custom script for initializing Swiper
    wp_enqueue_script('custom-swiper-init', get_template_directory_uri() . '/js/swiper-init.js', ['swiper-js'], null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');




function track_post_views($post_id) {
    if (!is_single()) return; // Only count views on single post pages

    $views = get_post_meta($post_id, 'post_views_count', true);

    if ($views == '') {
        $views = 0;
        delete_post_meta($post_id, 'post_views_count');
        add_post_meta($post_id, 'post_views_count', '1');
    } else {
        $views++;
        update_post_meta($post_id, 'post_views_count', $views);
    }
}
add_action('wp_head', function() {
    if (is_single()) track_post_views(get_the_ID());
});



function register_my_menus() {
    register_nav_menus(array(
        'menu-1' => __('Primary Menu', 'your-text-domain'),
    ));
}
add_action('init', 'register_my_menus');
