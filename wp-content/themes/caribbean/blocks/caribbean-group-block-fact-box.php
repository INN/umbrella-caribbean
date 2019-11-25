<?php

// modifications to the Group block to include:
// - fact box block style
// - fact box stylesheets
function caribbean_group_block_fact_box_styling_init() {
	// Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	$dir = get_stylesheet_directory() . '/blocks';

	// editor styles
	$editor_css = 'caribbean-group-block-fact-box/editor.css';
	wp_register_style(
		'caribbean-group-block-fact-box-editor',
		get_stylesheet_directory_uri() . "/blocks/$editor_css",
		array(),
		filemtime( "$dir/$editor_css" )
	);

	// frontend styles
	$style_css = 'caribbean-group-block-fact-box/style.css';
	wp_register_style(
		'caribbean-group-block-fact-box',
		get_stylesheet_directory_uri() . "/blocks/$style_css",
		array(),
		filemtime( "$dir/$style_css" )
	);

	// reregister group block with styles
	register_block_type( 'citylimits/group-block', array(
		'editor_style'  => 'caribbean-group-block-fact-box-editor',
		'style'         => 'caribbean-group-block-fact-box',
	) );

	// register fact box style for group block
	register_block_style(
		'core/group',
		array(
			'name'         => 'fact-box',
			'label'        => __( 'Fact Box' ),
			'style_handle' => 'fact-box',
		)
	);
}
add_action( 'init', 'caribbean_group_block_fact_box_styling_init' );