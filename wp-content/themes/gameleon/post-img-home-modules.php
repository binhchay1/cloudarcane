<?php

// If this file is called directly, busted!
if (!defined('ABSPATH')) {
	exit;
}

/*----------------------------------------------------------------------------------------------------------
	POST IMAGE MODULES SLIDER TEMPLATE-PART FILE
-----------------------------------------------------------------------------------------------------------*/
?>

<div class="grid-image big-wrap">
	<?php if (has_post_thumbnail() || is_myarcade_game()) : ?>
		<?php $image = '<a href="' . get_permalink() . '">' . get_the_post_thumbnail(get_the_ID(), 'modular-cat') . '</a>'; ?>
		<?php if (empty($image[0])) $image[0] = myarcade_featured_image(); ?>
		<?php echo html_entity_decode(esc_html($image)); ?>
	<?php else :
	?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="img-thumb-game-with-video">
			<img src="<?php echo get_post_meta(get_the_ID(), 'game_thumb1')[0] ?>" width="300" height="145" alt="<?php the_title(); ?>" />
			<?php $meta = get_post_meta(get_the_ID());
			if (array_key_exists('mabp_video_url', $meta)) { ?>
				<div class="pre-video-load">
					<iframe style="width: 100%; height: 100%;" src="<?php echo $meta['mabp_video_url'][0] ?>&autoplay=1&mute=1&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
				</div>
				<div class="foot-pre-load"></div>
			<?php } ?>
		</a>
	<?php endif;
	?>
</div>
<div class="clearfix"></div>