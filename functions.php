<?php
/**
 * Functions
 *
 * @package      RedBridge
 * @author       Red Bridge Internet
 * @since        1.0.0
 * @license      GPL-2.0+
**/

define( 'RB_THEME_VERSION', filemtime( get_template_directory() . '/dist/css/main.css' ) );

// General cleanup
include_once( get_template_directory() . '/inc/wordpress-cleanup.php' );

// Theme
include_once( get_template_directory() . '/inc/tha-theme-hooks.php' );
include_once( get_template_directory() . '/inc/layouts.php' );
include_once( get_template_directory() . '/inc/helper-functions.php' );
include_once( get_template_directory() . '/inc/navigation.php' );
include_once( get_template_directory() . '/inc/loop.php' );
include_once( get_template_directory() . '/inc/template-tags.php' );
include_once( get_template_directory() . '/inc/site-footer.php' );

// Editor
include_once( get_template_directory() . '/inc/disable-editor.php' );
include_once( get_template_directory() . '/inc/tinymce.php' );

// Functionality
include_once( get_template_directory() . '/inc/login-logo.php' );
include_once( get_template_directory() . '/inc/block-area.php' );
include_once( get_template_directory() . '/inc/social-links.php' );

// Plugin Support
include_once( get_template_directory() . '/inc/acf.php' );
include_once( get_template_directory() . '/inc/amp.php' );
include_once( get_template_directory() . '/inc/shared-counts.php' );
include_once( get_template_directory() . '/inc/wpforms.php' );

/**
 * Enqueue scripts and styles.
 */
function rb_scripts() {

	if( ! rb_is_amp() ) {
		wp_enqueue_script( 'rb-global', get_template_directory_uri() . '/dist/main-bundle.js', array( 'jquery' ), filemtime( get_template_directory() . '/dist/main-bundle.js' ), true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Move jQuery to footer
		if( ! is_admin() ) {
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
			wp_enqueue_script( 'jquery' );
		}

	}

	wp_enqueue_style( 'rb-fonts', rb_theme_fonts_url() );
	wp_enqueue_style( 'rb-style', get_template_directory_uri() . '/dist/css/main.css', array(), filemtime( get_template_directory() . '/dist/css/main.css' ) );

}
add_action( 'wp_enqueue_scripts', 'rb_scripts' );

/**
 * Gutenberg scripts and styles
 *
 */
function rb_gutenberg_scripts() {
	wp_enqueue_style( 'rb-fonts', rb_theme_fonts_url() );
	wp_enqueue_script( 'rb-editor', get_template_directory_uri() . '/assets/js/editor.js', array( 'wp-blocks', 'wp-dom' ), filemtime( get_template_directory() . '/assets/js/editor.js' ), true );
}
add_action( 'enqueue_block_editor_assets', 'rb_gutenberg_scripts' );

/**
 * Theme Fonts URL
 *
 */
function rb_theme_fonts_url() {
	return false;
}

if ( ! function_exists( 'rb_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function rb_setup() {
	/*
	 * Make theme available for translation.
	 */
	load_theme_textdomain( 'rb-starter', get_template_directory() . '/languages' );

	// Editor Styles
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	// Admin Bar Styling
	add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Body open hook
	add_theme_support( 'body-open' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 */
	 $GLOBALS['content_width'] = apply_filters( 'rb_content_width', 768 );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Navigation Menu', 'rb-starter' ),
		'secondary' => esc_html__( 'Secondary Navigation Menu', 'rb-starter' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Gutenberg

	// -- Responsive embeds
	add_theme_support( 'responsive-embeds' );

	// -- Wide Images
	add_theme_support( 'align-wide' );

	// -- Disable custom font sizes
	add_theme_support( 'disable-custom-font-sizes' );

	// -- Editor Font Styles
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name'      => __( 'Small', 'rb-starter' ),
			'shortName' => __( 'S', 'rb-starter' ),
			'size'      => 14,
			'slug'      => 'small'
		),
		array(
			'name'      => __( 'Normal', 'rb-starter' ),
			'shortName' => __( 'M', 'rb-starter' ),
			'size'      => 20,
			'slug'      => 'normal'
		),
		array(
			'name'      => __( 'Large', 'rb-starter' ),
			'shortName' => __( 'L', 'rb-starter' ),
			'size'      => 24,
			'slug'      => 'large'
		),
	) );

	// -- Disable Custom Colors
	add_theme_support( 'disable-custom-colors' );

	// -- Editor Color Palette
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Red', 'rb_starter' ),
			'slug'  => 'red',
			'color'	=> '#b71c1c',
		),
		array(
			'name'  => __( 'Grey', 'rb_starter' ),
			'slug'  => 'grey',
			'color' => '#FAFAFA',
		),
	) );

}
endif;
add_action( 'after_setup_theme', 'rb_setup' );

/**
 * Template Hierarchy
 *
 */
function rb_template_hierarchy( $template ) {

	if( is_home() || is_search() )
		$template = get_query_template( 'archive' );
	return $template;
}
add_filter( 'template_include', 'rb_template_hierarchy' );
