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
		'/inc/byline_class.php',
		'/inc/block-color-palette.php',
		'/blocks/caribbean-group-block-fact-box.php',
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
		$byline = new Largo_CoAuthors_Byline( $options );
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
