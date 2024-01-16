<?php
/*----------------------------------------------------------------------------------------------------------
	MODULAR SLIDER
-----------------------------------------------------------------------------------------------------------*/
?>

<div id="td-modular-slider" class="grid col-1060">

	<?php
	global $wp_query;
	$filter_slider_posts 	= get_theme_mod('td_filter_slider_posts');
	$td_modular_slider 		= get_theme_mod('td_modular_slider_shortcode');
	$td_post_per_page 		= get_theme_mod('td_modular_slider_number');

	if (!empty($td_modular_slider)) {
		$td_offset = 0;
	} else {
		$td_offset = $td_post_per_page;
	}

	$slider_tags_option = get_theme_mod('td_slider_tags_in');
	$slider_tags_option = explode(',', $slider_tags_option);

	if ($slider_tags_option and $filter_slider_posts == 1) {
		$slider_tags = '';
	} else {
		$slider_tags = $slider_tags_option;
	}

	$argsBig = array(
		'ignore_sticky_posts' => 1,
		'post_type' => 'game',
		'meta_query' => array(
			array(
				'key' => 'mabp_game_tag',
				'value' => 'slide-big',
				'compare' => '=',
			),
		),
		'posts_per_page' => $td_post_per_page
	);

	$argsSmall = array(
		'ignore_sticky_posts' => 1,
		'post_type' => 'game',
		'meta_query' => array(
			array(
				'key' => 'mabp_game_tag',
				'value' => 'slide-small',
				'compare' => '=',
			),
		),
		'posts_per_page' => 4
	);

	$slider_posts_big = new WP_Query($argsBig);
	$slider_posts_small = new WP_Query($argsSmall);
	?>

	<div class="td-main-slide grid col-610">
		<?php
		if (empty($td_modular_slider)) :
		?>
			<div class="flexslider">
				<ul class="slides">
					<?php while ($slider_posts_big->have_posts()) : $slider_posts_big->the_post(); ?>
						<li>
							<?php get_template_part('post-img-slider-big');
							?>
							<div class="main-slide-text">
								<a href="<?php the_permalink(); ?>">
									<h3><?php the_title(); ?></h3>
								</a>
								<div class="main-excerpt">
									<p><?php echo td_global_excerpt(20); ?></p>
								</div>
							</div>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>
		<?php else :
		?>
			<?php echo do_shortcode($td_modular_slider); ?>
		<?php endif; ?>
	</div>

	<?php
	while ($slider_posts_small->have_posts()) : $slider_posts_small->the_post(); ?>

		<div class="small-posts-slider grid col-250">
			<?php get_template_part('post-img-slider-small');
			?>

			<div class="small-slide-title">
				<a href="<?php the_permalink(); ?>">
					<h2><?php the_title(); ?></h2>
				</a>
			</div>
		</div>
	<?php endwhile; ?>
	<?php wp_reset_query(); ?>
</div>
<div class="clearfix"></div>