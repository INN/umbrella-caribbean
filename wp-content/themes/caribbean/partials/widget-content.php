<?php

// the thumbnail image (if we're using one)

$is_category = is_category();

if( $is_category ) {
	$image_container_class = 'span4 is-image';
} else {
	$image_container_class = '';
}

if ($thumb == 'small') {
	$img_location = ! empty( $instance['image_align'] ) ? $instance['image_align'] : 'left';
	$img_attr = array( 'class' => $img_location . '-align' );
	$img_attr['class'] .= " attachment-small";
	?>
		<div class="post-image-top-term-container <?php echo $image_container_class; ?>">
            <?php
                // The top term
                if ( isset( $instance['show_top_term'] ) && $instance['show_top_term'] == 1 && largo_has_categories_or_tags() ) {
                    largo_maybe_top_term();
                }
            ?>
            <a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), '60x60', $img_attr); ?></a>
        </div>
	<?php
} elseif ($thumb == 'medium') {
	$img_location = ! empty( $instance['image_align'] ) ? $instance['image_align'] : 'left';
	$img_attr = array('class' => $img_location . '-align');
	$img_attr['class'] .= " attachment-thumbnail";
    ?>
        <div class="post-image-top-term-container <?php echo $image_container_class; ?>">
            <?php
                // The top term
                if ( isset( $instance['show_top_term'] ) && $instance['show_top_term'] == 1 && largo_has_categories_or_tags() ) {
                    largo_maybe_top_term();
                }
            ?>
            <a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), 'post-thumbnail', $img_attr); ?></a>
        </div>
	<?php
} elseif ($thumb == 'large') {
	$img_attr = array();
	$img_attr['class'] = " attachment-two-third-full";
    ?>
        <div class="post-image-top-term-container <?php echo $image_container_class; ?>">
            <?php
                // The top term
                if ( isset( $instance['show_top_term'] ) && $instance['show_top_term'] == 1 && largo_has_categories_or_tags() ) {
                    largo_maybe_top_term();
                }
            ?>
            <a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), 'two-third-full', $img_attr); ?></a>
        </div>
	<?php
}

if( $is_category ) {
	echo '<div class="span8">';
}

// the headline and optionally the post-type icon
?><h5>
	<a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?>
	<?php
		if ( isset( $instance['show_icon'] ) && $instance['show_icon'] == true ) {
			post_type_icon();
		}
	?>
	</a>
</h5>

<?php

if( $is_category ) {

	// byline on posts
	if ( isset( $instance['show_byline'] ) && $instance['show_byline'] == true) {
		$hide_byline_date = ( ! empty( $instance['hide_byline_date'] ) ) ? $instance['hide_byline_date'] : true;
		?>
			<span class="byline"><?php echo largo_byline( false, $hide_byline_date, get_the_ID() ); ?></span>
		<?php
	}

	// the excerpt
	if ( $excerpt == 'num_sentences' ) {
		$num_sentences = ( ! empty( $instance['num_sentences'] ) ) ? $instance['num_sentences'] : 2;
		?>
			<p><?php echo largo_trim_sentences( get_the_content(), $num_sentences ); ?></p>
		<?php } elseif ( $excerpt == 'custom_excerpt' ) { ?>
			<p><?php echo get_the_excerpt(); ?></p>
		<?php
	}

	printf('
		<div class="read-more-button">
			<a href="%1$s">%2$s</a>
		</div>',
		esc_attr( get_permalink() ),
		__( 'Click here to read more', 'caribbean' )
	);

	echo '</div>';

} else {

	if ( $subtitle = get_post_meta( $post->ID, 'subtitle', true ) ) :
		echo '<h2 class="subtitle">'.$subtitle.'</h2>';
	endif;

	// byline on posts
	if ( isset( $instance['show_byline'] ) && $instance['show_byline'] == true) {
		$hide_byline_date = ( ! empty( $instance['hide_byline_date'] ) ) ? $instance['hide_byline_date'] : true;
		?>
			<span class="byline"><?php echo largo_byline( false, $hide_byline_date, get_the_ID() ); ?></span>
		<?php
	}
	
	// the excerpt
	if ( $excerpt == 'num_sentences' ) {
		$num_sentences = ( ! empty( $instance['num_sentences'] ) ) ? $instance['num_sentences'] : 2;
		?>
			<p><?php echo largo_trim_sentences( get_the_content(), $num_sentences ); ?></p>
		<?php } elseif ( $excerpt == 'custom_excerpt' ) { ?>
			<p><?php echo get_the_excerpt(); ?></p>
		<?php
	}

	printf('
		<div class="read-more-button">
			<a href="%1$s">%2$s</a>
		</div>
		<br/>',
		esc_attr( get_permalink() ),
		__( 'Click here to read more', 'caribbean' )
	);

}

?>
<div class="widget-bottom">
	<div class="bottom-lines"></div>

	<?php if ( ! of_get_option( 'single_social_icons' ) == false ) {
		largo_post_social_links();
	} ?>
</div>
