<?php
/**
 * Blog index template
 * Purpose: list posts with AJAX Load More and a pagination fallback.
 */
?>
<?php get_header(); ?>

<section class="content">
	<div id="post-list" class="post-list">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('template-parts/content', 'post'); ?>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e('No posts found.', 'myblog-theme'); ?></p>
		<?php endif; ?>
	</div>

	<?php
	global $wp_query;
	$max_pages = (int) $wp_query->max_num_pages;
	if ($max_pages > 1) :
	?>
		<div class="load-more-wrap">
			<button id="load-more"
				data-page="2"
				data-max="<?php echo esc_attr($max_pages); ?>">
				<?php esc_html_e('Load More Posts', 'myblog-theme'); ?>
			</button>
		</div>
	<?php endif; ?>
</section>

<?php
// Progressive enhancement: show normal pagination if JS is disabled
// or as an additional navigation element.
?>
<noscript>
	<div class="container">
		<?php the_posts_pagination(array(
			'mid_size'  => 1,
			'prev_text' => __('&larr; Newer', 'myblog-theme'),
			'next_text' => __('Older &rarr;', 'myblog-theme'),
		)); ?>
	</div>
</noscript>

<?php
// Also render pagination as a fallback below (visible even with JS),
// useful if you choose to disable the Load More button in the future.
the_posts_pagination(array(
	'mid_size'  => 1,
	'prev_text' => __('&larr; Newer', 'myblog-theme'),
	'next_text' => __('Older &rarr;', 'myblog-theme'),
));
?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>


