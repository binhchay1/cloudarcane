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
		$game_content = get_post_meta($game_id, 'mabp_game_content', true);
		$taq_review_criteria = get_post_meta($game_id, 'taq_review_criteria', true);
		$get_meta = get_post_custom($game_id);

		if (!empty($get_meta['taq_review_criteria'][0])) {
			$get_criteria = unserialize($get_meta['taq_review_criteria'][0]);
		}

		// Review Data
		$summary       = !empty($get_meta['taq_review_summary'][0]) ? htmlspecialchars_decode($get_meta['taq_review_summary'][0]) : '';
		$short_summary = !empty($get_meta['taq_review_total'][0]) ? $get_meta['taq_review_total'][0] : '';
		$style         = !empty($get_meta['taq_review_style'][0]) ? $get_meta['taq_review_style'][0] : 'stars';
		$image_style   = taqyeem_get_option('rating_image')          ? taqyeem_get_option('rating_image') : 'stars';
		$position = 'review-top';

		$total_score = $total_counter = $score = $ouput = 0;

		// Get users rate
		$users_rate = '';
		if (taqyeem_get_option('allowtorate') != 'none') {
			$users_rate = taqyeem_get_user_rate();
		}

		// Review Style
		$review_class = array(
			'review-box',
			$position,
		);

		if ($style == 'percentage') {
			$review_class[] = 'review-percentage';
		} elseif ($style == 'points') {
			$review_class[] = 'review-percentage';
		} else {
			$review_class[] = 'review-stars';
		}

		$review_class = apply_filters('taqyeem_reviews_box_classes', $review_class);

		$ouput = '
		<div class="review_wrap">
			<div id="review-box" class="' . join(' ', array_filter($review_class))  . '">';

		if (!empty($get_meta['taq_review_title'][0])) {
			$head_calss =  apply_filters('taqyeem_reviews_head_classes', 'review-box-header');
			$ouput .= '<h2 class="' . $head_calss . '">' . $get_meta['taq_review_title'][0] . '</h2>';
		}

		if (!empty($get_criteria) && is_array($get_criteria)) {
			foreach ($get_criteria as $criteria) {
				if ($criteria['name'] && is_numeric($criteria['score'])) {

					$criteria['score'] = max(0, min(100, $criteria['score']));

					$score += $criteria['score'];
					$total_counter++;

					if ($style == 'percentage') {
						$ouput .= '
								<div class="review-item">
									<span><h5>' . $criteria['name'] . ' - ' . $criteria['score'] . '%</h5><span style="width:' . $criteria['score'] . '%" data-width="' . $criteria['score'] . '"></span></span>
								</div>
							';
					} elseif ($style == 'points') {
						$point  =  $criteria['score'] / 10;
						$ouput .= '
								<div class="review-item">
									<span><h5>' . $criteria['name'] . ' - ' . $point . '</h5><span style="width:' . $criteria['score'] . '%" data-width="' . $criteria['score'] . '"></span></span>
								</div>
							';
					} else {
						$ouput .= '
								<div class="review-item">
									<h5>' . $criteria['name'] . '</h5>
									<span class="post-large-rate ' . $image_style . '-large"><span style="width:' . $criteria['score'] . '%"></span></span>
								</div>
							';
					}
				}
			}
		}

		if (has_filter('tie_taqyeem_before_summary')) {
			$ouput = apply_filters('tie_taqyeem_before_summary', $ouput, $get_meta);
		}

		if (!empty($score) && !empty($total_counter)) {
			$total_score =  $score / $total_counter;
		}

		$ouput .= '
				<div class="review-summary">';

		if ($style == 'percentage') {
			$ouput .= '
					<div class="review-final-score">
						<h3>' . round($total_score) . '<span>%</span></h3>
						<h4>' . $short_summary . '</h4>
					</div>
				';
		} elseif ($style == 'points') {
			$total_score = $total_score / 10;
			$ouput .= '
					<div class="review-final-score">
						<h3>' . round($total_score, 1) . '</h3>
						<h4>' . $short_summary . ' </h4>
					</div>
				';
		} else {
			$ouput .= '
					<div class="review-final-score">
						<span title="' . $short_summary . '" class="post-large-rate ' . $image_style . '-large"><span style="width:' . $total_score . '%"></span></span>
						<h4>' . $short_summary . '</h4>
					</div>
				';
		}

		$ouput .= '
				<div class="review-short-summary">';

		if (has_filter('tie_taqyeem_before_summary_text')) {
			$ouput = apply_filters('tie_taqyeem_before_summary_text', $ouput, $get_meta);
		}

		if (!empty($summary)) {
			$ouput .= '<p>' . $summary . '</p>';
		}

		if (has_filter('tie_taqyeem_after_summary_text')) {
			$ouput = apply_filters('tie_taqyeem_after_summary_text', $ouput, $get_meta);
		}

		$ouput .= '
				</div>
			</div>
			';

		if (has_filter('tie_taqyeem_before_user_rating')) {
			$ouput = apply_filters('tie_taqyeem_before_user_rating', $ouput, $get_meta);
		}

		$ouput .= $users_rate;

		if (has_filter('tie_taqyeem_after_user_rating')) {
			$ouput = apply_filters('tie_taqyeem_after_user_rating', $ouput, $get_meta);
		}

		$ouput .= '
		</div>
	</div>';


		$td_image           = wp_get_attachment_image_src(get_post_thumbnail_id($game_id), 'featured-image');
		$td_post_title      = get_the_title($game_id);
		$td_url             = urlencode(get_permalink($game_id));
		$td_source          = urlencode(get_bloginfo('name'));
		$twitter_username   = get_theme_mod('gameleon_twitter_username');
		?>
		<div class="game-iframe-container">
			<iframe class="game-iframe" src="<?php echo esc_url($game_url); ?>" width="<?php echo esc_attr($game_width); ?>" height="<?php echo esc_attr($game_height); ?>" scrolling="no" frameborder="0" allowfullscreen></iframe>
			<div class="content-game-iframe">
				<div class="body-content-game-iframe">
					<div>
						<h3>Content</h3>
						<p><?php echo $game_content ?></p>
					</div>
				</div>
			</div>

			<div class="review-game-iframe">
				<div class="body-review-game-iframe">
					<?php echo $ouput;
					?>
				</div>
			</div>

			<div class="video-game-iframe">
				<div class="body-video-game-iframe">
					<h3>Video intro</h3>
					<video loop autoplay muted preload="none">
						<source src="<?php echo $get_meta['mabp_video_url'][0] ?>" type="video/mp4" />
					</video>
				</div>
			</div>
		</div>
		<div class="set-button d-none" id="btn-fullscreen-area">
			<div class="button-control-iframe">
				<button id="fullscreeniframe" title="full screen" class="button btn btn-warning rounded-0"><i class="fas fa-expand"></i></button>
				<button id="contentiframe" title="content" class="button btn btn-warning rounded-0" onclick="displayContent()"><i class="fas fa-bars"></i></button>
				<button id="reviewiframe" title="review" class="button btn btn-warning rounded-0" onclick="displayReview()"><i class="fas fa-feather"></i></button>
				<button id="videoiframe" title="video" class="button btn btn-warning rounded-0" onclick="displayVideo()"><i class="fas fa-video"></i></button>
			</div>

			<?php echo kk_star_ratings(); ?>
			<?php gameleon_likes(); ?>
			<?php gameleon_post_views(); ?>
			<?php echo '
			<div id="td-social-share-buttons" class="td-social-box-share td-social-border">
				<a class="button td-box-twitter" href="https://twitter.com/intent/tweet?text=' . urlencode($td_post_title) . '&url=' . $td_url . '&via=' . urlencode($twitter_username ? $twitter_username : $td_source) . '" onclick="if(!document.getElementById(\'td-social-share-buttons\')){window.open(this.href, \'console\',\'left=50,top=50,width=600,height=440,toolbar=0\'); return false;}"><i class="fab fa-twitter"></i><span class="td-social-title">Twitter</span></a>
				<a class="button td-box-facebook" href="http://www.facebook.com/sharer.php?u=' . $td_url . '" onclick="window.open(this.href, \'console\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fab fa-facebook"></i><span class="td-social-title">Facebook</span></a>
				<a class="button td-box-google" href="https://plus.google.com/share?url=' . $td_url . '" onclick="window.open(this.href, \'console\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fab fa-google-plus"></i><span class="td-social-title">Google +</span></a>
				<a class="button td-box-pinterest" href="http://pinterest.com/pin/create/button/?url=' . $td_url . '&amp;media=' . (!empty($td_image[0]) ? $td_image[0] : '') . '" onclick="window.open(this.href, \'console\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fab fa-pinterest"></i><span class="td-social-title">Pinterest</span></a>
			</div>'; ?>
		</div>
		<?php do_action('cloudarcade_after_game_iframe'); ?>
		<div class="info-pre-game">
			<div class="d-flex">
				<p>Developer:</p>
				<?php if (!empty($get_meta['mabp_game_developer'][0])) { ?>
					<p style="margin-left: 10px;"><?php echo $get_meta['mabp_game_developer'][0] ?></p>
				<?php } else { ?>
					<p style="margin-left: 10px;">N/A</p>
				<?php } ?>
			</div>
			<div class="d-flex">
				<p>Released: </p>
				<p style="margin-left: 10px;"><?php echo get_the_date('F j, Y') ?></p>
			</div>
			<div class="d-flex">
				<p>Technology:</p>
				<?php if (!empty($get_meta['mabp_game_technology'][0])) { ?>
					<p style="margin-left: 10px;"><?php echo $get_meta['mabp_game_technology'][0] ?></p>
				<?php } else { ?>
					<p style="margin-left: 10px;">N/A</p>
				<?php } ?>
			</div>
			<div class="d-flex">
				<p>Platforms:</p>
				<?php if (!empty($get_meta['mabp_game_platforms'][0])) { ?>
					<p style="margin-left: 10px;"><?php echo $get_meta['mabp_game_platforms'][0] ?></p>
				<?php } else { ?>
					<p style="margin-left: 10px;">N/A</p>
				<?php } ?>
			</div>

		</div>
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
		<?php if (!empty($get_meta['mabp_video_url'][0])) { ?>
			<h2>Video intro</h2>
			<video loop autoplay muted preload="none">
				<source src="<?php echo $get_meta['mabp_video_url'][0] ?>" type="video/ogg" />
			</video>
		<?php } ?>
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