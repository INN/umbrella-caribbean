<?php

// modifications to the Group block to include:
// - fact box block style
// - fact box stylesheets
function caribbean_post_selector_block_init() {
	// Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
    $dir = get_stylesheet_directory() . '/blocks';
    
    $editor_js = 'caribbean-post-selector-block/index.js';
	wp_register_script(
		'caribbean-post-selector-block-editor-js',
		get_stylesheet_directory_uri() . "/blocks/$editor_js",
		array( 
			'wp-blocks',
			'wp-i18n',
			'wp-element',
			'wp-editor',
		),
		filemtime( "$dir/$editor_js" )
	);

	// editor styles
	// $editor_css = 'caribbean-group-block-fact-box/editor.css';
	// wp_register_style(
	// 	'caribbean-group-block-fact-box-editor',
	// 	get_stylesheet_directory_uri() . "/blocks/$editor_css",
	// 	array(),
	// 	filemtime( "$dir/$editor_css" )
	// );

	// // frontend styles
	// $style_css = 'caribbean-group-block-fact-box/style.css';
	// wp_register_style(
	// 	'caribbean-group-block-fact-box',
	// 	get_stylesheet_directory_uri() . "/blocks/$style_css",
	// 	array(),
	// 	filemtime( "$dir/$style_css" )
	// );

	// reregister group block with styles
	register_block_type( 'caribbean/post-selector-block', array(
		'editor_script' => 'caribbean-post-selector-block-editor-js',
		'render_callback' => 'caribbean_post_selector_block_callback',
        // 'editor_style'  => 'caribbean-group-block-fact-box-editor',
		// 'style'         => 'caribbean-group-block-fact-box',
	) );

	register_block_style(
		'core/group',
		array(
			'name'         => 'post-group',
			'label'        => __( 'Post Group' ),
			'style_handle' => 'post-group',
		)
	);

}
add_action( 'init', 'caribbean_post_selector_block_init' );

function caribbean_post_selector_block_callback( $attributes, $content ) {

	if( ! is_admin() ){

		$post_type = $post;
		if( 'video' === $attributes['postType'] ){
			$content = 'this is a video'.$content;
		} else if( 'podcast' === $attributes['postType'] ){
			$content = 'this is a podcast'.$content;
		} else {
			$content = 'this is a post'.$content;
		}

		return $content;
	}

}