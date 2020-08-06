<?php
/**
 * Template Name: Series Landing Page Parent/Child
 * Description: The default template for a series landing page where posts are displayed via child series instead of from the main series river.
 */
get_header();

// Load up our meta data and whatnot
the_post();

//make sure it's a landing page.
if ( 'cftl-tax-landing' == $post->post_type ) {
	$opt = get_post_custom( $post->ID );
	foreach( $opt as $key => $val ) {
		$opt[ $key ] = $val[0];
	}
	$opt['show'] = maybe_unserialize($opt['show']);	//make this friendlier
	/**
	 * $opt will look like this:
	 *
	 *	Array (
	 *		[header_enabled] => boolean
	 *		[show_series_byline] => boolean
	 *		[show_sharebar] => boolean
	 *		[header_style] => standard|alternate
	 *		[cftl_layout] => one-column|two-column|three-column
	 *		[per_page] => integer|all
	 *		[post_order] => ASC|DESC|top, DESC|top, ASC
	 *		[footer_enabled] => boolean
	 *		[footerhtml] => {html}
	 *		[show] => array with boolean values for keys byline|excerpt|image|tags
	 *	)
	 *
	 * The post description is stored in 'excerpt' and the custom HTML header is the post content
	 */
}

// #content span width helper
$content_span = array( 'one-column' => 12, 'two-column' => 8, 'three-column' => 5 );
?>

<?php if ( $opt['header_enabled'] ) : ?>
	<section id="series-header" class="span12">
		<?php
		if ( $opt['show_series_byline'] )
			echo '<h5 class="byline">' . largo_byline( false, false, get_the_ID() ) . '</h5>';
		if ( $opt['show_sharebar'] )
			largo_post_social_links();
		?>
		<?php
		if ( 'standard' == $opt['header_style'] ) {
			//need to set a size, make this responsive, etc
			?>
			<div class="full series-banner full-image"><?php the_post_thumbnail( 'full' ); ?></div>
		<?php
		} else {
			the_content();
		}
		?>
        <div class="description">
			<?php echo apply_filters( 'the_content', $post->post_excerpt ); ?>
		</div>
        <div class="bottom-lines"></div>
	</section>
	</div><!-- end main div -->
	<div id="series-main" class="row-fluid clearfix">
<?php endif; ?>


<?php // display left rail
if ( 'three-column' == $opt['cftl_layout'] ) :
		$left_rail = $opt['left_region'];
?>
	<aside id="sidebar-left" class="span3">
		<div class="widget-area" role="complementary">
			<?php
				dynamic_sidebar($left_rail);
			?>
		</div>
	</aside>
<?php
endif;
?>

<?php // display left rail
if ($opt['cftl_layout'] != 'one-column') :
	if (!empty($opt['right_region']) && $opt['right_region'] !== 'none') {
		$right_rail = $opt['right_region'];
	} else {
		$right_rail = 'single';
	}
?>
<aside id="sidebar" class="span4">
	<?php do_action('largo_before_sidebar_content'); ?>
	<div class="widget-area" role="complementary">
		<?php
			do_action('largo_before_sidebar_widgets');
			dynamic_sidebar($right_rail);
			do_action('largo_after_sidebar_widgets');
		?>
	</div><!-- .widget-area -->
	<?php do_action('largo_after_sidebar_content'); ?>
</aside>

<?php
endif;

//display series footer
if ( 'none' != $opt['footer_style'] ) : ?>
	<section id="series-footer">
		<?php
			/*
			 * custom footer html
			 * If we don't reset the post meta here, then the footer HTML is from the wrong post. This doesn't mess with LMP, because it happens after LMP is enqueued in the main column.
			 */
			wp_reset_postdata();
			if ( 'custom' == $opt['footer_style']) {
				echo apply_filters( 'the_content', $opt['footerhtml'] );
			} else if ( 'widget' == $opt['footer_style'] && is_active_sidebar( $post->post_name . "_footer" ) ) { ?>
				<aside id="sidebar-bottom">
				<?php dynamic_sidebar( $post->post_name . "_footer" ); ?>
				</aside>
			<?php }
		?>
	</section>
<?php endif; ?>

<!-- /.grid_4 -->
<?php get_footer();
