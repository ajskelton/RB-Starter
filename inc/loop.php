<?php
/**
 * EA Starter
 *
 * @package      EAStarter
 * @since        1.0.0
 * @copyright    Copyright (c) 2014, Contributors to EA Genesis Child project
 * @license      GPL-2.0+
 */

/**
 * Body Classes
 *
 */
function ea_body_classes( $classes ) {

	// Page Layout
	$classes[] = ea_page_layout();
	
	// Blog Archive
	if( is_home() || is_archive() || is_search() )
		$classes[] = 'blog-archive';
	
	return $classes;
}
add_filter( 'body_class', 'ea_body_classes' );

/**
 * Default Loop
 *
 */
function ea_default_loop() {

	if ( have_posts() ) :

		tha_content_while_before();

		/* Start the Loop */
		while ( have_posts() ) : the_post();

			tha_entry_before();
			get_template_part( 'template-parts/content', get_post_type() );
			tha_entry_after(); 
			
		endwhile;

		tha_content_while_after();

	else :

		tha_entry_before();
		get_template_part( 'template-parts/content', 'none' );
		tha_entry_after(); 

	endif;

}
add_action( 'tha_content_loop', 'ea_default_loop' );

/**
 * Archive Header 
 *
 */
function ea_archive_header() {

	$title = $description = false;
	
	if( is_search() )
		$title = 'Search Results for: <em>' . get_search_query() . '</em>';
	if( is_archive() ) {
		$title = get_the_archive_title();
		$description = get_the_archive_description();
	}
	
	if( empty( $title ) && empty( $description ) )
		return;

	echo '<header class="archive-intro">';
	if( ! empty( $title ) )
		echo '<h1 class="archive-title">' . $title . '</h1>';
	if( ! empty( $description ) )
		echo '<div class="archive-description">' . apply_filters( 'ea_the_content', $description ) . '</div>';
	echo '</header>';

}
add_action( 'tha_content_while_before', 'ea_archive_header' );

/**
 * Archive Navigation 
 *
 */
function ea_archive_navigation() {

	if( ! is_singular() )
		the_posts_navigation();

}
add_action( 'tha_content_while_after', 'ea_archive_navigation' );

/**
 * Post Comments 
 *
 */
function ea_comments() {

	if ( is_singular() && ( comments_open() || get_comments_number() ) ) {
		comments_template();
	}

}
add_action( 'tha_content_while_after', 'ea_comments' );