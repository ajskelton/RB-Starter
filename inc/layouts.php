<?php
/**
 * Sidebar Layouts
 *
 * @package      RedBridge
 * @author       Red Bridge Internet
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

/**
 * Layout Options
 *
 */
function rb_page_layout_options() {
	return [
		'content-sidebar',
		'content',
		'full-width-content',
	];
}

/**
 * Gutenberg layout style
 *
 */
function rb_editor_layout_style() {
	wp_enqueue_style( 'rb-editor-layout', get_stylesheet_directory_uri() . '/dist/css/editor-layout.css', [], filemtime( get_stylesheet_directory() . '/dist/css/editor-layout.css' ) );
}

add_action( 'enqueue_block_editor_assets', 'rb_editor_layout_style' );

/**
 * Editor layout class
 * @link https://www.billerickson.net/change-gutenberg-content-width-to-match-layout/
 *
 * @param string $classes
 *
 * @return string
 */
function rb_editor_layout_class( $classes ) {
	$screen = get_current_screen();
	if ( ! $screen->is_block_editor() ) {
		return $classes;
	}
	
	$post_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : false;
	$layout  = rb_page_layout( $post_id );
	
	$classes .= ' ' . $layout . ' ';
	
	return $classes;
}

add_filter( 'admin_body_class', 'rb_editor_layout_class' );


/**
 * Layout Metabox (ACF)
 *
 */
function rb_page_layout_metabox() {
	
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	
	$choices = [];
	$layouts = rb_page_layout_options();
	foreach ( $layouts as $layout ) {
		$label              = str_replace( '-', ' ', $layout );
		$choices[ $layout ] = ucwords( $label );
	}
	
	acf_add_local_field_group( array(
		'key'                   => 'group_5dd714b369526',
		'title'                 => 'Page Layout',
		'fields'                => array(
			array(
				'key'               => 'field_5dd715a02eaf0',
				'label'             => 'Page Layout',
				'name'              => 'rb_page_layout',
				'type'              => 'select',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'choices'           => $choices,
				'default_value'     => array(),
				'allow_null'        => 1,
				'multiple'          => 0,
				'ui'                => 0,
				'return_format'     => 'value',
				'ajax'              => 0,
				'placeholder'       => '',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'page',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'side',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
	) );
}

add_action( 'acf/init', 'rb_page_layout_metabox' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rb_widgets_init() {
	
	register_sidebar( rb_widget_area_args( array(
		'name' => esc_html__( 'Primary Sidebar', 'rb-starter' ),
	) ) );
	
}

add_action( 'widgets_init', 'rb_widgets_init' );

/**
 * Layout Body Class
 *
 */
function rb_layout_body_class( $classes ) {
	$classes[] = rb_page_layout();
	
	return $classes;
}

add_filter( 'body_class', 'rb_layout_body_class', 5 );

/**
 * Default Widget Area Arguments
 *
 * @param array $args
 *
 * @return array $args
 */
function rb_widget_area_args( $args = array() ) {
	
	$defaults = array(
		'name'          => '',
		'id'            => '',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	);
	$args     = wp_parse_args( $args, $defaults );
	
	if ( ! empty( $args['name'] ) && empty( $args['id'] ) ) {
		$args['id'] = sanitize_title_with_dashes( $args['name'] );
	}
	
	return $args;
	
}

/**
 * Page Layout
 *
 */
function rb_page_layout( $id = false ) {
	
	$available_layouts = rb_page_layout_options();
	$layout            = 'content-sidebar';
	
	if ( is_singular() || $id ) {
		$id       = $id ? intval( $id ) : get_the_ID();
		$selected = get_post_meta( $id, 'rb_page_layout', true );
		if ( ! empty( $selected ) && in_array( $selected, $available_layouts ) ) {
			$layout = $selected;
		}
	}
	
	$layout = apply_filters( 'rb_page_layout', $layout );
	$layout = in_array( $layout, $available_layouts, true ) ? $layout : $available_layouts[0];
	
	return sanitize_title_with_dashes( $layout );
}

/**
 * Return Full Width Content
 * used when filtering 'rb_page_layout'
 */
function rb_return_full_width_content() {
	return 'full-width-content';
}

/**
 * Return Content Sidebar
 * used when filtering 'rb_page_layout'
 */
function rb_return_content_sidebar() {
	return 'content-sidebar';
}

/**
 * Return Content
 * used when filtering 'rb_page_layout'
 */
function rb_return_content() {
	return 'content';
}
