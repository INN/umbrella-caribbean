<article id="post-<?php echo $featured_post->ID ?>" <?php post_class('clearfix row-fluid', $featured_post->ID); ?>>
<?php if ( has_post_thumbnail($featured_post->ID) ) { ?>
	<div class="span4 <?php largo_hero_class($featured_post->ID); ?>">
		<a href="<?php echo get_permalink($featured_post->ID); ?>"><?php echo get_the_post_thumbnail($featured_post->ID, 'rect_thumb'); ?></a>
	</div>

	<div class="span8">
<?php } else { ?>
	<div class="span12">
<?php } ?>
		<header>
			<h2 class="entry-title">
				<a href="<?php echo get_permalink($featured_post->ID); ?>"
					title="<?php echo __( 'Permalink to', 'largo' ) . esc_attr(strip_tags($featured_post->post_title)); ?>"
					rel="bookmark"><?php echo $featured_post->post_title; ?></a>
			</h2>
			<?php if ( $subtitle = get_post_meta( $featured_post->ID, 'subtitle', true ) ) : ?>
				<h2 class="subtitle"><?php echo $subtitle ?></h2>
			<?php endif; ?>

			<h5 class="byline"><?php largo_byline( true, false, $featured_post ); ?></h5>
		</header>

		<div class="entry-content">
			<?php largo_excerpt($featured_post, 5, null, null, true, false); ?>
		</div>
		<div class="read-more-button">
			<a href="<?php echo esc_attr( get_permalink() ); ?>"><?php _e( 'Click here to read more', 'caribbean' ); ?></a>
		</div>
	</div>
</article>
