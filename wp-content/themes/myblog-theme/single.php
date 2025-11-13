<?php
/**
 * Single post template
 * Purpose: display a single blog post with title, featured image, meta, and content.
 */
get_header();
?>

<section class="content">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
			<h1 class="post-title"><?php the_title(); ?></h1>
			<p class="post-meta">
				<?php echo esc_html(get_the_date()); ?>
				<?php esc_html_e(' by ', 'myblog-theme'); ?>
				<?php echo esc_html(get_the_author()); ?>
			</p>
			<?php if (has_post_thumbnail()) : ?>
				<div class="post-featured-image">
					<?php the_post_thumbnail('large'); ?>
				</div>
			<?php endif; ?>
			<div class="post-content">
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; endif; ?>

	<?php
	// Fallback pagination for next/previous single posts.
	the_post_navigation(array(
		'prev_text' => __('&larr; Previous', 'myblog-theme'),
		'next_text' => __('Next &rarr;', 'myblog-theme'),
	));
	?>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>


