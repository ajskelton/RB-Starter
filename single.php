<?php
/**
 * Single Post
 *
 * @package      RedBridge
 * @author       Red Bridge Internet
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Entry category in header
add_action( 'tha_entry_top', 'rb_entry_category', 8 );
add_action( 'tha_entry_top', 'rb_entry_author', 12 );
add_action( 'tha_entry_top', 'rb_entry_header_share', 13 );

/**
 * Entry header share
 *
 */
function rb_entry_header_share() {
	do_action( 'rb_entry_header_share' );
}

/**
 * After Entry
 *
 */
function rb_single_after_entry() {
	echo '<div class="after-entry">';

	// Breadcrumbs
	rb_breadcrumbs();

	// Publish date
	echo '<p class="publish-date">Published on ' . get_the_date( 'F j, Y' ) . '</p>';

	// Sharing
	do_action( 'rb_entry_footer_share' );

}
add_action( 'tha_content_while_after', 'rb_single_after_entry', 8 );

// Build the page
require get_template_directory() . '/index.php';
