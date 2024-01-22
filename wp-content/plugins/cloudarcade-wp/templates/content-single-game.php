<?php
defined('ABSPATH') || exit;

do_action('cloudarcade_before_single_game');
?>

<div class="cloudarcade">
	<div class="single-game">
		<?php
		do_action('cloudarcade_before_game_iframe');
		$game_id = get_the_ID();
		$game_url = ca_get_game_url($game_id);
		$game_width = get_post_meta($game_id, 'game_width', true);
		$game_height = get_post_meta($game_id, 'game_height', true);
		?>
		<div class="game-iframe-container">
			<iframe class="game-iframe" src="<?php echo esc_url($game_url); ?>" width="<?php echo esc_attr($game_width); ?>" height="<?php echo esc_attr($game_height); ?>" scrolling="no" frameborder="0" allowfullscreen></iframe>
		</div>
		<div class="set-button d-none" id="btn-fullscreen-area">
			<button id="fullscreeniframe" title="view in full screen" class="button btn btn-warning rounded-0"><i class="fas fa-expand"></i></button>
		</div>
		<?php do_action('cloudarcade_after_game_iframe'); ?>

		<?php do_action('cloudarcade_before_game_info'); ?>
		<div class="game-info">
			<div class="game-description">
				<h2>Description</h2>
				<?php echo get_the_content(); ?>
			</div>
			<div class="game-instructions">
				<h2>Instructions</h2>
				<?php echo get_post_meta($game_id, 'game_instructions', true); ?>
			</div>
		</div>
		<?php do_action('cloudarcade_after_game_info'); ?>

		<h2>Categories</h2>
		<?php
		$categories = get_the_terms($game_id, 'game_category');
		if ($categories) :
		?>
			<div class="game-categories">
				<ul>
					<?php
					foreach ($categories as $category) :
						$category_link = get_term_link($category);
						if (is_wp_error($category_link)) continue;
					?>
						<li><a href="<?php echo esc_url($category_link); ?>"><?php echo esc_html($category->name); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
		<h2>Rating</h2>
		<?php echo kk_star_ratings(); ?>
		<h2>You may like</h2>
		<?php
		$random_games = ca_get_random_games();
		?>
		<div class="cloudarcade archive-game random-games">
			<ul class="games">
				<?php while ($random_games->have_posts()) : $random_games->the_post(); ?>
					<?php include('content-game.php'); ?>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>
</div>
<script>
	(function(window, document) {
		let $ = function(selector, context) {
			return (context || document).querySelector(selector)
		};

		let iframe = $("iframe"),
			domPrefixes = 'Webkit Moz O ms Khtml'.split(' ');

		let fullscreen = function(elem) {
			let prefix;
			for (let i = -1, len = domPrefixes.length; ++i < len;) {
				prefix = domPrefixes[i].toLowerCase();

				if (elem[prefix + 'EnterFullScreen']) {

					return prefix + 'EnterFullScreen';
				} else if (elem[prefix + 'RequestFullScreen']) {

					return prefix + 'RequestFullScreen';
				}
			}

			return false;
		};
		let fullscreenother = fullscreen(document.createElement("iframe"));

		if (!fullscreen) {
			alert("Fullscreen won't work, please make sure you're using a browser that supports it and you have enabled the feature");
			return;
		}

		$("#fullscreeniframe").addEventListener("click", function() {
			iframe[fullscreenother]();
		}, false);

	})(this, this.document);
</script>

<?php do_action('cloudarcade_after_single_game'); ?>