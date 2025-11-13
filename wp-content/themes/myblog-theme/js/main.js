/**
 * Theme main JS
 * Purpose: handle AJAX "Load More Posts" behavior.
 */
(function ($) {
	'use strict';

	function disableButton($btn, text) {
		$btn.prop('disabled', true);
		if (text) $btn.data('orig-text', $btn.text()).text(text);
	}
	function enableButton($btn) {
		$btn.prop('disabled', false);
		if ($btn.data('orig-text')) $btn.text($btn.data('orig-text'));
	}

	$(document).on('click', '#load-more', function () {
		var $btn = $(this);
		var nextPage = parseInt($btn.attr('data-page'), 10) || 2;
		var maxPage  = parseInt($btn.attr('data-max'), 10) || 1;

		if (nextPage > maxPage) {
			$btn.hide();
			return;
		}

		disableButton($btn, 'Loading...');

		$.ajax({
			url: MyBlogAjax.ajaxUrl,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'myblog_load_more',
				nonce: MyBlogAjax.nonce,
				page: nextPage,
				queryVars: MyBlogAjax.queryVars
			}
		})
		.done(function (res) {
			if (res && res.success && res.data && res.data.html) {
				$('#post-list').append(res.data.html);
				var newPage = nextPage + 1;
				$btn.attr('data-page', newPage);

				if (newPage > maxPage) {
					$btn.hide();
				} else {
					enableButton($btn);
				}
			} else {
				enableButton($btn);
			}
		})
		.fail(function () {
			enableButton($btn);
			alert('Failed to load more posts. Please try again.');
		});
	});
})(jQuery);


