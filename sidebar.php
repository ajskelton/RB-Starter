<?php
/**
 * Sidebar
 *
 * @package      RBStarter
 * @author       Red Bridge Internet
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

if ( ! function_exists( 'rb_page_layout' ) ) {
	return;
}

$layout = rb_page_layout();
if ( ! in_array( $layout, array( 'content-sidebar', 'sidebar-content' ) ) ) {
	return;
}

$sidebar = apply_filters( 'rb_sidebar', 'primary-sidebar' );
$display = is_active_sidebar( $sidebar );
if ( ! apply_filters( 'rb_display_sidebar', $display ) ) {
	return;
}

tha_sidebars_before();

?>
<aside class="sidebar-primary" role="complementary">
<?php
	tha_sidebar_top();
	if ( is_active_sidebar( $sidebar ) ) {
		dynamic_sidebar( $sidebar );
	}
	tha_sidebar_bottom();
?>
</aside>

<?php tha_sidebars_after(); ?>
