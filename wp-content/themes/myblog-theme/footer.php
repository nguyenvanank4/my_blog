	</main>
	<?php
	/**
	 * Footer template
	 * Purpose: closes main container and outputs site footer.
	 */
	?>
	<footer class="site-footer">
		<div class="container">
			<p>&copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
		</div>
	</footer>
	<?php wp_footer(); ?>
</body>
</html>


