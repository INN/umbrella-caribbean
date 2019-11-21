<?php

/**
 * Enqueue specific styles and scripts for Caribbean child theme
 */
function caribbean_enqueue_styles(){
	wp_enqueue_style(
		'typekit',
		'https://use.typekit.net/rrf1wzf.css'
	);
	wp_enqueue_style(
		'largo-child-styles',
		get_stylesheet_directory_uri() . '/css/child-style.css',
		array( 'largo-stylesheet', 'typekit' ),
		filemtime( get_stylesheet_directory() . '/css/child-style.css' )
	);
}
add_action( 'wp_enqueue_scripts', 'caribbean_enqueue_styles' );