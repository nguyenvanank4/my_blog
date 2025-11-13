<?php
/**
 * Plugin Name: Featured Posts
 * Description: Adds [featured_posts] shortcode to display latest posts with thumbnail and excerpt. Supports [featured_posts count=\"5\" category=\"news\"].
 * Version: 1.0.0
 * Author: You
 * Text Domain: featured-posts
 */

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('FP_Featured_Posts')) {
	class FP_Featured_Posts {

		/**
		 * Bootstraps shortcode and assets.
		 */
		public function __construct() {
			add_shortcode('featured_posts', array($this, 'renderFeaturedPosts'));
			add_action('wp_enqueue_scripts', array($this, 'enqueueAssets'));
		}

		/**
		 * Enqueue plugin CSS only when shortcode is present on the current page.
		 */
		public function enqueueAssets() {
			if (!is_singular() && !is_home() && !is_front_page()) {
				return;
			}

			global $post;
			if ($post instanceof WP_Post && has_shortcode($post->post_content, 'featured_posts')) {
				wp_enqueue_style(
					'fp-featured-posts',
					plugins_url('assets/css/featured-posts.css', __FILE__),
					array(),
					'1.0.0'
				);
			}
		}

		/**
		 * Shortcode callback.
		 *
		 * Usage:
		 *   [featured_posts]
		 *   [featured_posts count="5"]
		 *   [featured_posts count="5" category="news"]
		 *
		 * Attributes:
		 * - count: number of posts (int, 1..12; default 3)
		 * - category: category slug to filter (string; optional)
		 */
		public function renderFeaturedPosts($atts = array()) {
			$atts = shortcode_atts(
				array(
					'count'    => 3,
					'category' => '',
				),
				$atts,
				'featured_posts'
			);

			// Sanitize and validate attributes.
			$count = intval($atts['count']);
			if ($count < 1) { $count = 1; }
			if ($count > 12) { $count = 12; }

			$category_slug = '';
			if (!empty($atts['category'])) {
				$category_slug = sanitize_title($atts['category']); // ensures slug-like format
			}

			$args = array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => $count,
				'no_found_rows'  => true,
			);

			if (!empty($category_slug)) {
				$args['category_name'] = $category_slug;
			}

			$query = new WP_Query($args);

			ob_start();

			if ($query->have_posts()) : ?>
				<div class="fp-featured-posts">
					<?php while ($query->have_posts()) : $query->the_post(); ?>
						<article class="fp-post">
							<a href="<?php the_permalink(); ?>" class="fp-thumb">
								<?php if (has_post_thumbnail()) {
									the_post_thumbnail('medium');
								} ?>
							</a>
							<div class="fp-content">
								<h3 class="fp-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<p class="fp-excerpt">
									<?php echo esc_html(wp_trim_words(get_the_excerpt(), 20, '...')); ?>
								</p>
							</div>
						</article>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			<?php else : ?>
				<p><?php esc_html_e('No posts found.', 'featured-posts'); ?></p>
			<?php endif;

			return ob_get_clean();
		}
	}

	new FP_Featured_Posts();
}


