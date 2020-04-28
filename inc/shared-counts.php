<?php
/**
 * Shared Counts
 *
 * @package      RedBridge
 * @author       Red Bridge Internet
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

// Disable CSS and JS
add_filter( 'shared_counts_load_css', '__return_false' );
add_filter( 'shared_counts_load_js', '__return_false' );

/**
 * Shared Counts header
 *
 */
function rb_shared_counts_header( $output, $location ) {
	if ( 'after_content' === $location ) {
		$output = '<h3>Share this Article</h3>' . $output;
	}
	
	return $output;
}

add_filter( 'shared_counts_display', 'rb_shared_counts_header', 10, 2 );

/**
 * Simple email button
 * Does not require loading JS
 */
function rb_shared_counts_email_link( $link, $id ) {
	if ( 'email' !== $link['type'] ) {
		return $link;
	}
	
	$subject      = esc_html__( 'Your friend has shared an article with you.', 'shared-counts' );
	$subject      = apply_filters( 'shared_counts_amp_email_subject', $subject, $id );
	$body         = html_entity_decode( get_the_title( $id ), ENT_QUOTES ) . "\r\n";
	$body         .= get_permalink( $id ) . "\r\n";
	$body         = apply_filters( 'shared_counts_amp_email_body', $body, $id );
	$link['link'] = 'mailto:?subject=' . rawurlencode( $subject ) . '&body=' . rawurlencode( $body );
	
	return $link;
}

add_filter( 'shared_counts_link', 'rb_shared_counts_email_link', 10, 2 );

/**
 * Shared Counts Services
 *
 */
function rb_shared_counts_services( $services, $location ) {
	if ( 'after_content' !== $location ) {
		return $services;
	}
	
	foreach ( $services as $i => $service ) {
		if ( 'print' === $service ) {
			unset( $services[ $i ] );
		}
	}
	
	return $services;
}

add_filter( 'shared_counts_display_services', 'rb_shared_counts_services', 10, 2 );

/**
 * Shared Counts Locations
 *
 */
function rb_shared_counts_locations( $locations ) {
	$locations['before']['hook'] = 'rb_entry_header_share';
	$locations['after']['hook']  = 'rb_entry_footer_share';
	$locations['after']['style'] = 'button';
	
	return $locations;
}

add_filter( 'shared_counts_theme_locations', 'rb_shared_counts_locations' );

/**
 * Production URL
 *
 * @param string $url (optional), URL to convert to production.
 *
 * @return string $url, converted to production. Uses home_url() if no url provided
 *
 * @author Red Bridge Internet
 * @link   https://sharedcountsplugin.com/2019/03/27/use-production-url-when-in-development-or-staging/
 *
 */
function rb_production_url( $url = false ) {
	$production = false; // put production URL here
	
	if ( ! empty( $production_url ) ) {
		$url = $url ? esc_url( $url ) : home_url();
		$url = str_replace( home_url(), $production, $url );
	}
	
	return esc_url( $url );
}

/**
 * Use Production URL for Share Count API
 *
 * @param array $params , API parameters used when fetching share counts
 *
 * @return array
 * @author Red Bridge Internet
 * @link   http://www.billerickson.net/code/use-production-url-in-shared-counts/
 *
 */
function rb_production_url_share_count_api( $params ) {
	$params['url'] = rb_production_url( $params['url'] );
	
	return $params;
}

add_filter( 'shared_counts_api_params', 'rb_production_url_share_count_api' );

/**
 * Use Production URL for Share Count link
 *
 * @param array $link , elements of the link
 *
 * @return array
 * @author Red Bridge Internet
 * @link   http://www.billerickson.net/code/use-production-url-in-shared-counts/
 *
 */
function rb_production_url_share_count_link( $link ) {
	$exclude = array( 'print', 'email' );
	if ( ! in_array( $link['type'], $exclude ) ) {
		$link['link'] = rb_production_url( $link['link'] );
	}
	
	return $link;
}

add_filter( 'shared_counts_link', 'rb_production_url_share_count_link' );
