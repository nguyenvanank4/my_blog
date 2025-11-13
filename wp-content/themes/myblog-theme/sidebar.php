<?php if (!defined('ABSPATH')) { exit; } ?>
<?php
/**
 * Sidebar template
 * Purpose: renders the primary widget area.
 */
?>
<aside class="sidebar">
	<?php if (is_active_sidebar('sidebar-1')) : ?>
		<?php dynamic_sidebar('sidebar-1'); ?>
	<?php else : ?>
		<section class="widget">
			<h2 class="widget-title"><?php esc_html_e('About', 'myblog-theme'); ?></h2>
			<p><?php esc_html_e('Add widgets to the sidebar from Appearance → Widgets.', 'myblog-theme'); ?></p>
		</section>
	<?php endif; ?>
</aside>


