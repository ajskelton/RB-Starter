<?php
/**
 * Disable Editor
 *
 * @package      RBStarter
 * @author       Red Bridge Internet
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

/**
 * Templates and Page IDs without editor
 *
 * @param bool|integer $id
 *
 * @return bool
 */
function rb_disable_editor( $id = false ) {
	
	$excluded_templates = array();
	
	$excluded_ids = array();
	
	if ( empty( $id ) ) {
		return false;
	}
	
	$id       = (int) $id;
	$template = get_page_template_slug( $id );
	
	return in_array( $id, $excluded_ids, true ) || in_array( $template, $excluded_templates, true );
}

/**
 * Disable Gutenberg by template
 *
 * @param $can_edit
 * @param $post_type
 *
 * @return bool
 */
function rb_disable_gutenberg( $can_edit, $post_type ) {
	
	if ( ! ( is_admin() && ! empty( $_GET['post'] ) ) ) {
		return $can_edit;
	}
	
	if ( rb_disable_editor( $_GET['post'] ) ) {
		$can_edit = false;
	}
	
	return $can_edit;
	
}

add_filter( 'gutenberg_can_edit_post_type', 'rb_disable_gutenberg', 10, 2 );
add_filter( 'use_block_editor_for_post_type', 'rb_disable_gutenberg', 10, 2 );

/**
 * Disable Classic Editor by template
 *
 */
function rb_disable_classic_editor() {
	
	$screen = get_current_screen();
	if ( 'page' !== $screen->id || ! isset( $_GET['post'] ) ) {
		return;
	}
	
	if ( rb_disable_editor( $_GET['post'] ) ) {
		remove_post_type_support( 'page', 'editor' );
	}
	
}

add_action( 'admin_head', 'rb_disable_classic_editor' );
