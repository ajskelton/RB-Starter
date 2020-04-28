<?php
/**
 * Singular partial
 *
 * @package      RedBridge
 * @author       Red Bridge Internet
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

?>
<article class="<?php echo implode( ' ', get_post_class() ) ?>">
	
	<?php if ( rb_has_action( 'tha_entry_top' ) ) : ?>
        <header class="entry-header">
			<?php tha_entry_top() ?>
        </header>
	<?php endif; ?>

    <div class="entry-content">
		
		<?php
		
		tha_entry_content_before();
		
		the_content();
		
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'rb-starter' ),
			'after'  => '</div>',
		) );
		
		tha_entry_content_after();
		
		?>
    </div>
	
	<?php if ( rb_has_action( 'tha_entry_bottom' ) ) : ?>
        <footer class="entry-footer">
			<?php tha_entry_bottom() ?>
        </footer>
	<?php endif; ?>

</article>
