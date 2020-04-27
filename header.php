<?php
/**
 * Site Header
 *
 * @package      RBStarter
 * @author       Red Bridge Internet
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

?>

<!DOCTYPE html>
<?php tha_html_before() ?>
<html <?php echo get_language_attributes() ?>>

<head>
	<?php
	tha_head_top();
	wp_head();
	tha_head_bottom();
	?>
</head>

<body class="<?php echo implode( ' ', get_body_class() ); ?>">
<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
tha_body_top();
?>
<div class="site-container">
    <a class="skip-link screen-reader-text"
       href="#main-content"><?php echo esc_html__( 'Skip to content', 'rb-starter' ) ?></a>
	
	<?php tha_header_before() ?>

    <header class="site-header" role="banner">
        <div class="wrap">
			
			<?php tha_header_top() ?>

            <div class="title-area">
				<?php $logo_tag = ( apply_filters( 'rb_h1_site_title', false ) || ( is_front_page() && is_home() ) ) ? 'h1' : 'p'; ?>
                <<?php echo $logo_tag; ?> class="site-title">
                    <a href="<?php echo esc_url( home_url() ); ?>" rel="home"><?php echo get_bloginfo( 'name' ) ?></a>
                </<?php echo $logo_tag ?>>
                <?php if ( apply_filters( 'rb_header_site_description', false ) ) : ?>
                    <p class="site-description"><?php echo get_bloginfo( 'description' ); ?></p>
                <?php endif; ?>
            </div>
		
		<?php tha_header_bottom() ?>
        
        </div>
    </header>
    <?php tha_header_after() ?>
    <div class="site-inner" id="main-content">
