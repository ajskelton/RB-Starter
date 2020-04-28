<?php
/**
 * 404 / No Results partial
 *
 * @package      RedBridge
 * @author       Red Bridge Internet
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

?>
<section class="no-results not-found">

    <header class="entry-header"><h1 class="entry-title"><?php echo esc_html__( 'Nothing Found', 'rb-starter' ) ?></h1>
    </header>
    <div class="entry-content">
		
		<?php if ( is_search() ) : ?>

            <p><?php echo esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'rb-starter' ) ?></p>
			<?php get_search_form() ?>
		
		<?php else : ?>

            <p><?php echo esc_html__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'rb-starter' ) ?></p>
			<?php get_search_form() ?>
		
		<?php endif; ?>

    </div>
</section>
