<?php
/**
 * Base template
 *
 * @package      RBStarter
 * @author       Red Bridge Internet
 * @since        1.0.0
 * @license      GPL-2.0+
**/

get_header();

tha_content_before();

?>
	<div class="<?php echo rb_class( 'content-area', 'wrap', apply_filters( 'rb_content_area_wrap', true ) ); ?>">
		<?php tha_content_wrap_before() ?>
		<main class="site-main" role="main">
			<?php
			tha_content_top();
			tha_content_loop();
			tha_content_bottom();
			?>
		</main>
	<?php
	get_sidebar();
	tha_content_wrap_after();
	?>
	</div>
<?php

tha_content_after();

get_footer();
