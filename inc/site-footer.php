<?php
/**
 * Site Footer
 *
 * @package      GrownAndFlown2020
 * @author       Red Bridge Internet
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

/**
 * Register footer widget areas
 *
 */
function rb_register_footer_widget_areas() {
	
	for ( $i = 1; $i <= 3; $i ++ ) {
		
		register_sidebar( rb_widget_area_args( array(
			'name' => esc_html__( 'Footer ' . $i, 'rb-starter' ),
		) ) );
	}
	
}

add_action( 'widgets_init', 'rb_register_footer_widget_areas' );


/**
 * Footer Widget Areas
 *
 */
function rb_site_footer_widgets() {
	echo '<div class="footer-widgets"><div class="wrap">';
	for ( $i = 1; $i < 4; $i ++ ) {
		dynamic_sidebar( 'footer-' . $i );
	}
	echo '</div></div>';
}

add_action( 'tha_footer_before', 'rb_site_footer_widgets' );

/**
 * Site Footer
 *
 */
function rb_site_footer() {
	echo '<div class="footer-left">';
	echo '<p class="copyright">Copyright &copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) . '®. All Rights Reserved.</p>';
	echo '<p class="footer-links"><a href="' . home_url( 'privacy-policy' ) . '">Privacy Policy</a> <a href="' . home_url( 'terms' ) . '">Terms</a></p>';
	echo '</div>';
	echo '<a class="backtotop" href="#main-content">Back to top' . rb_icon( array( 'icon' => 'arrow-up' ) ) . '</a>';
}

add_action( 'tha_footer_top', 'rb_site_footer' );
