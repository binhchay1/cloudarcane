<?php

// If this file is called directly, busted!
if (!defined('ABSPATH')) {
	exit;
}

/*----------------------------------------------------------------------------------------------------------
	POST IMAGE BIG TEMPLATE-PART FILE
-----------------------------------------------------------------------------------------------------------*/
?>
<div class="grid-image big-wrap">
	<?php if (has_post_thumbnail() || is_myarcade_game()) : ?>
		<?php $image = '<a href="' . get_permalink() . '">' . get_the_post_thumbnail(get_the_ID(), 'module-blog-index') . '</a>'; ?>
		<?php if (empty($image[0])) $image[0] = myarcade_featured_image(); ?>
		<?php echo html_entity_decode(esc_html($image)); ?>
	<?php else :
	?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholders/174x100.png" width="174" height="100" alt="<?php the_title(); ?>" />
		</a>
	<?php endif;
	?>
</div>