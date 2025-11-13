<?php
/**
 * Theme bootstrap and AJAX handlers
 * Purpose: enqueue assets, register supports/sidebars, and provide load-more endpoint.
 */
if (!defined('ABSPATH')) { exit; }

/**
 * Theme setup: thumbnails, title-tag, menus.
 */
add_action('after_setup_theme', function () {
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');
	register_nav_menus(array(
		'primary' => __('Primary Menu', 'myblog-theme'),
	));
});

/**
 * Register sidebar.
 */
add_action('widgets_init', function () {
	register_sidebar(array(
		'name'          => __('Main Sidebar', 'myblog-theme'),
		'id'            => 'sidebar-1',
		'description'   => __('Add widgets here.', 'myblog-theme'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
});

/**
 * Enqueue CSS/JS (jQuery included by WordPress).
 */
add_action('wp_enqueue_scripts', function () {
	wp_enqueue_style('myblog-theme-style', get_stylesheet_uri(), array(), '1.0.0');
	wp_enqueue_script('jquery');
	wp_enqueue_script(
		'myblog-theme-main',
		get_template_directory_uri() . '/js/main.js',
		array('jquery'),
		'1.0.0',
		true
	);

	wp_localize_script('myblog-theme-main', 'MyBlogAjax', array(
		'ajaxUrl' => admin_url('admin-ajax.php'),
		'nonce'   => wp_create_nonce('myblog_load_more_nonce'),
		'queryVars' => array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => get_option('posts_per_page', 10),
		),
	));
});

/**
 * Render a single post card (shared output).
 */
function myblog_render_post_card($post_id) {
	$post = get_post($post_id);
	if (!$post) { return ''; }

	setup_postdata($post);
	ob_start(); ?>
	<article id="post-<?php echo esc_attr($post->ID); ?>" <?php post_class('post'); ?>>
		<h2 class="post-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>
		<p class="post-meta">
			<?php echo esc_html(get_the_date()); ?>
			<?php esc_html_e(' by ', 'myblog-theme'); ?>
			<?php echo esc_html(get_the_author()); ?>
		</p>
		<div class="post-excerpt">
			<?php echo esc_html(wp_trim_words(get_the_excerpt(), 35, '...')); ?>
		</div>
	</article>
	<?php
	wp_reset_postdata();
	return ob_get_clean();
}

/**
 * AJAX handler: Load more posts.
 */
add_action('wp_ajax_myblog_load_more', 'myblog_load_more_handler');
add_action('wp_ajax_nopriv_myblog_load_more', 'myblog_load_more_handler');

function myblog_load_more_handler() {
	check_ajax_referer('myblog_load_more_nonce', 'nonce');

	$page = isset($_POST['page']) ? max(2, intval($_POST['page'])) : 2;

	$base = isset($_POST['queryVars']) && is_array($_POST['queryVars']) ? $_POST['queryVars'] : array();
	$allowed = array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => get_option('posts_per_page', 10),
		'orderby'        => 'date',
		'order'          => 'DESC',
	);
	$args = array_merge($allowed, array_intersect_key($base, $allowed));
	$args['paged'] = $page;

	$q = new WP_Query($args);

	$html = '';
	if ($q->have_posts()) {
		while ($q->have_posts()) {
			$q->the_post();
			$html .= myblog_render_post_card(get_the_ID());
		}
		wp_reset_postdata();
	}

	wp_send_json_success(array(
		'html'        => $html,
		'found_posts' => intval($q->found_posts),
		'max_page'    => intval($q->max_num_pages),
		'page'        => $page,
	));
}


