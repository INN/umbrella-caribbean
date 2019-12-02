<?php

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

	// frontend styles
	$style_css = 'caribbean-post-selector-block/style.css';
	wp_register_style(
		'caribbean-post-selector-block',
		get_stylesheet_directory_uri() . "/blocks/$style_css",
		array(),
		filemtime( "$dir/$style_css" )
	);

	// reregister group block with styles
	register_block_type( 'caribbean/post-selector-block', array(
		'editor_script'   => 'caribbean-post-selector-block-editor-js',
		'render_callback' => 'caribbean_post_selector_block_callback',
		'style'           => 'caribbean-post-selector-block',
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

		$post_id = $attributes['selectedPost'];
		$permalink = $attributes['link'];
		$post_type = 'post';

		if( 'podcast' === $attributes['postType'] ){
			$content = $content.'<div class="podcast-listen"><a href="'.$permalink.'"><span class="dashicons dashicons-controls-play"></span> LISTEN</a></div>';
		} else if( 'video' === $attributes['postType'] ){
			$content = '<a href="'.get_permalink().'"><div class="video-overlay"><div class="play-circle"><span class="dashicons dashicons-controls-play"></span></div>'.get_the_post_thumbnail( $post_id, 'rect_thumb' ).'</div></a>'.$content;
		} else {
			$content = '<a href="'.get_permalink().'">'.get_the_post_thumbnail( $post_id, 'rect_thumb' ).'</a>'.$content;
		}
		
		return $content;
		
	}

}