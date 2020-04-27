<?php
/**
 * Helper Functions
 *
 * @package      RBStarter
 * @author       Red Bridge Internet
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

// Duplicate 'the_content' filters
global $wp_embed;
add_filter( 'rb_the_content', array( $wp_embed, 'run_shortcode' ), 8 );
add_filter( 'rb_the_content', array( $wp_embed, 'autoembed' ), 8 );
add_filter( 'rb_the_content', 'wptexturize' );
add_filter( 'rb_the_content', 'convert_chars' );
add_filter( 'rb_the_content', 'wpautop' );
add_filter( 'rb_the_content', 'shortcode_unautop' );
add_filter( 'rb_the_content', 'do_shortcode' );

/**
 * Get the first term attached to post
 *
 * @param array $args
 *
 * @return string/object
 */
function rb_first_term( $args = [] ) {
	
	$defaults = [
		'taxonomy' => 'category',
		'field'    => null,
		'post_id'  => null,
	];
	
	$args = wp_parse_args( $args, $defaults );
	
	$post_id = ! empty( $args['post_id'] ) ? intval( $args['post_id'] ) : get_the_ID();
	$field   = ! empty( $args['field'] ) ? esc_attr( $args['field'] ) : false;
	$term    = false;
	
	// Use WP SEO Primary Term
	// from https://github.com/Yoast/wordpress-seo/issues/4038
	if ( class_exists( 'WPSEO_Primary_Term' ) ) {
		$term = get_term( ( new WPSEO_Primary_Term( $args['taxonomy'], $post_id ) )->get_primary_term(), $args['taxonomy'] );
	}
	
	// Fallback on term with highest post count
	if ( ! $term || is_wp_error( $term ) ) {
		
		$terms = get_the_terms( $post_id, $args['taxonomy'] );
		
		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return false;
		}
		
		// If there's only one term, use that
		if ( 1 == count( $terms ) ) {
			$term = array_shift( $terms );
			
			// If there's more than one...
		} else {
			
			// Sort by term order if available
			// @uses WP Term Order plugin
			if ( isset( $terms[0]->order ) ) {
				$list = array();
				foreach ( $terms as $term ) {
					$list[ $term->order ] = $term;
				}
				ksort( $list, SORT_NUMERIC );
				
				// Or sort by post count
			} else {
				$list = array();
				foreach ( $terms as $term ) {
					$list[ $term->count ] = $term;
				}
				ksort( $list, SORT_NUMERIC );
				$list = array_reverse( $list );
			}
			
			$term = array_shift( $list );
		}
	}
	
	// Output
	if ( ! empty( $field ) && isset( $term->$field ) ) {
		return $term->$field;
	} else {
		return $term;
	}
}

/**
 * Conditional CSS Classes
 *
 * @param string $base_classes   , classes always applied
 * @param string $optional_class , additional class applied if $conditional is true
 * @param bool   $conditional    , whether to add $optional_class or not
 *
 * @return string $classes
 */
function rb_class( $base_classes, $optional_class, $conditional ) {
	return $conditional ? $base_classes . ' ' . $optional_class : $base_classes;
}

/**
 *  Background Image Style
 *
 * @param int $image_id
 *
 * @return string $output
 */
function rb_bg_image_style( $image_id = false, $image_size = 'full' ) {
	if ( ! empty( $image_id ) ) {
		return ' style="background-image: url(' . wp_get_attachment_image_url( $image_id, $image_size ) . ');"';
	}
}

/**
 * Get Icon
 * This function is in charge of displaying SVG icons across the site.
 *
 * Place each <svg> source in the /assets/icons/{group}/ directory, without adding
 * both `width` and `height` attributes, since these are added dynamically,
 * before rendering the SVG code.
 *
 * All icons are assumed to have equal width and height, hence the option
 * to only specify a `$size` parameter in the svg methods.
 *
 * @param array $attributes
 *
 * @return string|string[]|void|null
 */
function rb_icon( $attributes = array() ) {
	
	$attributes = shortcode_atts( array(
		'icon'  => false,
		'group' => 'utility',
		'size'  => 16,
		'class' => false,
		'label' => false,
	), $attributes );
	
	if ( empty( $attributes['icon'] ) ) {
		return;
	}
	
	$icon_path = get_theme_file_path( '/assets/icons/' . $attributes['group'] . '/' . $attributes['icon'] . '.svg' );
	if ( ! file_exists( $icon_path ) ) {
		return;
	}
	
	$icon = file_get_contents( $icon_path );
	
	$class = 'svg-icon';
	if ( ! empty( $attributes['class'] ) ) {
		$class .= ' ' . esc_attr( $attributes['class'] );
	}
	
	if ( false !== $attributes['size'] ) {
		$repl = sprintf( '<svg class="' . $class . '" width="%d" height="%d" aria-hidden="true" role="img" focusable="false" ', $attributes['size'], $attributes['size'] );
		$svg  = preg_replace( '/^<svg /', $repl, trim( $icon ) ); // Add extra attributes to SVG code.
	} else {
		$svg = preg_replace( '/^<svg /', '<svg class="' . $class . '"', trim( $icon ) );
	}
	$svg = preg_replace( "/([\n\t]+)/", ' ', $svg ); // Remove newlines & tabs.
	$svg = preg_replace( '/>\s*</', '><', $svg ); // Remove white space between SVG tags.
	
	if ( ! empty( $attributes['label'] ) ) {
		$svg = str_replace( array(
			'<svg class',
			'aria-hidden="true"'
		), array( '<svg aria-label="' . esc_attr( $attributes['label'] ) . '" class', '' ), $svg );
	}
	
	return $svg;
}

/**
 * Has Action
 *
 * @param $hook
 *
 * @return bool
 */
function rb_has_action( $hook ) {
	ob_start();
	do_action( $hook );
	$output = ob_get_clean();
	
	return ! empty( $output );
}

/**
 * Breadcrumbs
 *
 */
function rb_breadcrumbs() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumb">', '</p>' );
	}
}
