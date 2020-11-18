<?php
define( 'SHOW_GLOBAL_NAV', false );
define( 'SHOW_CATEGORY_RELATED_TOPICS', false );

/**
 * Include theme files
 *
 * Based off of how Largo loads files: https://github.com/INN/Largo/blob/master/functions.php#L358
 *
 * 1. hook function Largo() on after_setup_theme
 * 2. function Largo() runs Largo::get_instance()
 * 3. Largo::get_instance() runs Largo::require_files()
 *
 * This function is intended to be easily copied between child themes, and for that reason is not prefixed with this child theme's normal prefix.
 *
 * @link https://github.com/INN/Largo/blob/master/functions.php#L145
 */
function largo_child_require_files() {

	$includes = array(
		'/inc/enqueue.php',
		'/inc/decorations.php',
		'/inc/navigation.php',
		'/inc/class-caribbean-byline.php',
		'/inc/class-caribbean-coauthors-byline.php',
		'/inc/block-color-palette.php',
		'/blocks/caribbean-group-block-fact-box.php',
		'/blocks/caribbean-post-selector-block.php',
		'/inc/metaboxes.php',
		// homepage
		'/homepages/layout.php',
	);

	foreach ( $includes as $include ) {
		require_once( get_stylesheet_directory() . $include );
	}
}
add_action( 'after_setup_theme', 'largo_child_require_files' );

/**
 * Outputs custom byline and link (if set), otherwise outputs author link and post date
 *
 * @param Boolean $echo Echo the string or return it (default: echo)
 * @param Boolean $exclude_date Whether to exclude the date from byline (default: false)
 * @param WP_Post|Integer $post The post object or ID to get the byline for. Defaults to current post.
 * @return String Byline as formatted html
 * @since 0.1
 */
function largo_byline( $echo = true, $exclude_date = false, $post = null, $show_avatar = true ) {
	// Get the post ID
	if (!empty($post)) {
		if (is_object($post))
			$post_id = $post->ID;
		else if (is_numeric($post))
			$post_id = $post;
	} else {
		$post_id = get_the_ID();
		if ( WP_DEBUG || LARGO_DEBUG ) {
			_doing_it_wrong( 'largo_byline', 'largo_byline must be called with a post or post ID specified as the third argument. For more information, see https://github.com/INN/largo/issues/1517 .', '0.6' );
		}
	}

	// Set us up the options
	// This is an array of things to allow us to easily add options in the future
	$options = array(
		'post_id' => $post_id,
		'values' => get_post_custom( $post_id ),
		'exclude_date' => $exclude_date,
		'show_avatar' => $show_avatar,
	);
	if ( function_exists( 'get_coauthors' ) ) {
		// If Co-Authors Plus is enabled and there is not a custom byline
		$byline = new Caribbean_CoAuthors_Byline( $options );
	} else {
		// no custom byline, no coauthors: let's do the default
		$byline = new Caribbean_Byline( $options );
	}
	/**
	 * Filter the largo_byline output text to allow adding items at the beginning or the end of the text.
	 *
	 * @since 0.5.4
	 * @param string $partial The HTML of the output of largo_byline(), before the edit link is added.
	 * @param array $array Associative array of argument name => argument value, with the arguments passed to largo_byline(). Since https://github.com/INN/largo/issues/1656
	 * @link https://github.com/INN/Largo/issues/1070
	 */
	$byline = apply_filters(
		'largo_byline',
		$byline,
		array(
			'echo' => $echo,
			'exclude_date' => $exclude_date,
			'post' => $post
		)
	);
	if ( $echo ) {
		echo $byline;
	}
	return $byline;
}

/**
 * Register custom sidebars for the child theme
 */
function caribbean_custom_sidebars() {

	register_sidebar( array(
		'name' 		=> 'Header Widget - Right ',
		'description' 	=> 'An optional area to place widgets in the header to the right of the site logo.',
		'id' 		=> 'header-right-sidebar',
		'before_widget' => '<!-- Sidebar: header-right-sidebar --><aside id="%1$s" class="%2$s clearfix">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>',
	) );

}
add_action( 'widgets_init', 'caribbean_custom_sidebars' );

/**
 * Add the header-right-sidebar after the largo header
 */
function caribbean_after_header() {

	echo '<div class="header-right-sidebar">';
		dynamic_sidebar( 'header-right-sidebar' );
	echo '</div>';

}
add_action( 'largo_header_after_largo_header', 'caribbean_after_header' );

/**
 * Reimplement largo_home_single_top() but with WPML compatibility.
 *
 * @link https://wpml.org/forums/topic/get_posts-by-language-and-suppress_filters-false-issue/
 * @link https://github.com/INN/largo/blob/v0.6.4/homepages/homepage.php#L93
 */
function caribbean_home_single_top() {
	// Cache the terms
	$homepage_feature_term = get_term_by( 'slug', 'homepage-featured', 'prominence' );
	$top_story_term = get_term_by( 'slug', 'top-story', 'prominence' );

	// Get the posts that are both in 'Homepage Featured' and 'Homepage Top Story'
	$top_story_posts = get_posts(array(
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'prominence',
				'field' => 'term_id',
				'terms' => $top_story_term->term_id
			),
		),
		'posts_per_page' => 1,
		'suppress_filters' => false,
	));

	if ( !empty( $top_story_posts ) ) {
		return $top_story_posts[0];
	}

	// Fallback: get the posts that are in "Homepage Featured" but not "Homepage Top Story"
	$homepage_featured_posts = get_posts(array(
		'tax_query' => array(
			array(
				'taxonomy' => 'prominence',
				'field' => 'term_id',
				'terms' => $homepage_feature_term->term_id
			)
		),
		'posts_per_page' => 1,
		'suppress_filters' => false,
	));

	if ( !empty( $homepage_featured_posts ) ) {
		return $homepage_featured_posts[0];
	}

	// Double fallback: Get the most recent post
	$posts = get_posts( array(
		'orderby' => 'date',
		'order' => 'DESC',
		'posts_per_page' => 1,
		'suppress_filters' => false,
	) );

	if ( !empty( $posts ) ) {
		return $posts[0];
	}

	return null;
}
