(function ($) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practice to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */


})(jQuery);

function displayContent() {
	if (jQuery(".content-game-iframe").css('visibility') == 'hidden') {
		let right = 0;
		if (jQuery(".review-game-iframe").css('visibility') == 'visible') {
			let widthReview = jQuery(".review-game-iframe").width();
			right = right + widthReview + 30;
		}

		if (jQuery(".video-game-iframe").css('visibility') == 'visible') {
			let widthVideo = jQuery(".video-game-iframe").width();
			right = right + widthVideo + 30;
		}

		jQuery('.content-game-iframe').css('right', right);
		jQuery('.content-game-iframe').css('visibility', 'visible');
	} else {
		jQuery('.content-game-iframe').css('right', 0);
		jQuery('.content-game-iframe').css('visibility', 'hidden');
	}
}

function displayReview() {
	if (jQuery(".review-game-iframe").css('visibility') == 'hidden') {
		let right = 0;
		if (jQuery(".content-game-iframe").css('visibility') == 'visible') {
			let widthContent = jQuery(".content-game-iframe").width();
			right = right + widthContent + 30;
		}

		if (jQuery(".video-game-iframe").css('visibility') == 'visible') {
			let widthVideo = jQuery(".video-game-iframe").width();
			right = right + widthVideo + 30;
		}

		jQuery('.review-game-iframe').css('right', right);
		jQuery('.review-game-iframe').css('visibility', 'visible');
	} else {
		jQuery('.review-game-iframe').css('right', 0);
		jQuery('.review-game-iframe').css('visibility', 'hidden');
	}
}

function displayVideo() {
	if (jQuery(".video-game-iframe").css('visibility') == 'hidden') {
		let right = 0;
		if (jQuery(".content-game-iframe").css('visibility') == 'visible') {
			let widthContent = jQuery(".content-game-iframe").width();
			right = right + widthContent + 30;
		}

		if (jQuery(".review-game-iframe").css('visibility') == 'visible') {
			let widthReview = jQuery(".review-game-iframe").width();
			right = right + widthReview + 30;
		}

		jQuery('.video-game-iframe').css('right', right);
		jQuery('.video-game-iframe').css('visibility', 'visible');
	} else {
		jQuery('.video-game-iframe').css('right', 0);
		jQuery('.video-game-iframe').css('visibility', 'hidden');
	}
}