<?php
/**
 * Archive partial
 *
 * @package      RedBridge
 * @author       Red Bridge Internet
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

?>
<article class="post-summary">
	
	<?php rb_post_summary_image(); ?>

    <div class="post-summary__content">
		
		<?php
		rb_entry_category();
		rb_post_summary_title();
		?>
    
    </div>

</article>
