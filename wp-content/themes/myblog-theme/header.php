<?php if (!defined('ABSPATH')) { exit; } ?>
<?php
/**
 * Header template
 * Purpose: outputs <head>, site header and opens main container.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	<title><?php wp_title('|', true, 'right'); ?></title>
</head>
<body <?php body_class(); ?>>
	<header class="site-header">
		<div class="container branding">
			<h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h1>
			<nav class="site-nav" aria-label="<?php esc_attr_e('Primary Menu', 'myblog-theme'); ?>">
				<?php
					wp_nav_menu(array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'menu',
						'fallback_cb'    => false,
					));
				?>
			</nav>
		</div>
	</header>
	<main class="container layout">


