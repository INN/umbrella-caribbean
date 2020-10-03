<?php
/**
 * Used on the custom homepage layout
 *
 * Expects a variable $topstory being a WP_Post
 */
?>
<article id="top-story" <?php post_class( '', $topstory->ID ); ?> >
	<div class="post-image-top-term-container">
		<a class="img" href="<?php echo esc_attr( get_permalink( $topstory ) ); ?>"><?php echo get_the_post_thumbnail( $topstory, 'large' ); ?></a>
	</div>
	<h2><a href="<?php the_permalink( $topstory ); ?>"><?php echo get_the_title( $topstory ); ?></a></h2>
	<div class="inner">
		<div class="excerpt">
			<?php largo_excerpt( $topstory, 4 ); ?>
		</div>
		<div class="read-more-button">
			<a href="<?php echo esc_attr( get_permalink() ); ?>"><?php _e( 'Click here to read more', 'caribbean' ); ?></a>
		</div>
		<span class="byline"><?php largo_byline( true, false, $topstory ); ?></span>
		<?php if ( ! of_get_option( 'single_social_icons' ) == false ) {
			largo_post_social_links();
		} ?>
	</div>
</article>
