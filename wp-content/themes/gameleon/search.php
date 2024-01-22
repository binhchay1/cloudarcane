<?php

// If this file is called directly, busted!
if (!defined('ABSPATH')) {
	exit;
}

/*----------------------------------------------------------------------------------------------------------
    SEARCH TEMPLATE- WE USE PHP COMMENTS INSTEAD OF HTML, TO REDUCE THE PAGE SIZE.
-----------------------------------------------------------------------------------------------------------*/

get_header(); ?>

<?php
$td_post_excerpt 	= get_theme_mod('td_category_text_length'); // post excerpt
if (is_active_sidebar('main-sidebar') || is_active_sidebar('sticky-sidebar')) {
	$td_wide = '';
} else {
	$td_wide = 'td-wide';
}
?>

<div id="content" class="td-blog-layout grid col-700 <?php echo esc_attr($td_wide); ?>">
	<div class="td-content-inner">
		<div class="widget-title">
			<h1><?php _e('Search results for', 'gameleon'); ?> "<?php echo get_search_query(); ?>"</h1>
		</div>
		<div class="td-wrap-content">
			<?php if (have_posts()) : ?>
				<form role="search" class="td-search-form" method="post" id="searchform" action="<?php echo home_url('/search/'); ?>">
					<div>
						<label class="screen-reader-text" for="s"><?php esc_attr_e('Search for:', 'gameleon') ?></label>
						<input type="text" class="td-widget-search-input" name="s" id="s" autocomplete="off" value="<?php echo esc_attr(get_search_query()); ?>" />
						<button type="submit" id="td-searchsubmit">
							<i class="fa fa-search"></i>
						</button>
					</div>
				</form>
				<p class="td__center not-happy m_b_40"><?php echo esc_attr_e('If you\'re not happy with the results, please do another search', 'gameleon'); ?></p>

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="post-entry">
								<div class="td-fly-in">

									<div class="col-160">
										<?php get_template_part('post-img-friv'); // post image 
										?>
									</div>
									<div class="td-search-block fit">
										<h3 class="entry-title">
										</h3>

										<div class="td-post-details">
											<h3 class="entry-title">
												<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a>
											</h3>
											<div class="td-post-excerpt">
												<?php echo td_global_excerpt($td_post_excerpt); ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
				<?php endwhile;
				endif; ?>
			<?php else : ?>
				<h3 class="m_b_40"><?php _e('Sorry, but nothing matched your search criteria.', 'gameleon'); ?></h3>
				<p class="td__center"><?php echo esc_attr_e('If you\'re not happy with the results, please do another search', 'gameleon'); ?></p>
				<form role="search" class="td-search-form" method="post" id="searchform" action="<?php echo home_url('/search/'); ?>">
					<div>
						<label class="screen-reader-text" for="s"><?php esc_attr_e('Search for:', 'gameleon') ?></label>
						<input type="text" class="td-widget-search-input" name="s" id="s" autocomplete="off" value="<?php echo esc_attr(get_search_query()); ?>" />
						<button type="submit" id="td-searchsubmit">
							<i class="fa fa-search"></i>
						</button>
					</div>
				</form>
			<?php endif; ?>
		</div>
	</div>
	<?php get_template_part('loop-nav'); // pagination 
	?>

</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>