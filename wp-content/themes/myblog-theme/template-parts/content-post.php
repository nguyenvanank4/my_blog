<?php
/**
 * Post card partial
 * Purpose: reuse the same markup for index and AJAX loads.
 */
if (!defined('ABSPATH')) { exit; }
echo myblog_render_post_card(get_the_ID());


