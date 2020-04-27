<?php
/**
 * Archive
 *
 * @package      RBStarter
 * @author       Red Bridge Internet
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Full width
add_filter( 'rb_page_layout', 'rb_return_full_width_content' );

/**
 * Body Class
 *
 */
function rb_archive_body_class( $classes ) {
	$classes[] = 'archive';
	return $classes;
}
add_filter( 'body_class', 'rb_archive_body_class' );

/**
 * Archive Header
 *
 */
function rb_archive_header() {

	$title = $subtitle = $description = $more = false;

	if( is_home() ) {
		$title = get_the_title( get_option( 'page_for_posts' ) );

	} elseif( is_search() ) {
		$title = 'Search Results';
		$more = get_search_form( false );

	} elseif( is_archive() ) {
		$title = get_the_archive_title();
		if( ! get_query_var( 'paged' ) )
			$description = get_the_archive_description();
	}

	if( empty( $title ) && empty( $description ) )
		return;

	$classes = [ 'archive-description' ];
	if( is_author() )
		$classes[] = 'author-archive-description';

	echo '<header class="' . join( ' ', $classes ) . '">';
	do_action ('rb_archive_header_before' );
	if( ! empty( $title ) )
		echo '<h1 class="archive-title">' . $title . '</h1>';
	if( !empty( $subtitle ) )
		echo '<h4>' . $subtitle . '</h4>';
	echo apply_filters( 'rb_the_content', $description );
	echo $more;
	do_action ('rb_archive_header_after' );
	echo '</header>';

}
add_action( 'tha_content_while_before', 'rb_archive_header' );

// Breadcrumbs
add_action( 'rb_archive_header_before', 'rb_breadcrumbs', 5 );

// Build the page
require get_template_directory() . '/index.php';
