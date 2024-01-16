<?php

// If this file is called directly, busted!
if (!defined('ABSPATH')) {
	exit;
}

/*----------------------------------------------------------------------------------------------------------
	POST IMAGE BIG SLIDER TEMPLATE-PART FILE
-----------------------------------------------------------------------------------------------------------*/
?>

<div class="td-main-slide-shadow">
	<span class="main-cat"><?php the_category(' '); ?></span>
	<?php if (has_post_thumbnail() || is_myarcade_game()) : ?>
		<?php $image = '<a href="' . get_permalink() . '">' . get_the_post_thumbnail(get_the_ID(), 'modular-slider-wide') . '<div class="dark-cover"></div></a>'; ?>
		<?php if (empty($image[0])) $image[0] = myarcade_featured_image(); ?>
		<?php echo html_entity_decode(esc_html($image)); ?>

	<?php else :
	?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<img src="<?php echo get_post_meta(get_the_ID(), 'game_thumb1')[0] ?>" width="610" height="349" alt="<?php the_title(); ?>" />
		</a>

	<?php endif;
	?>
</div>