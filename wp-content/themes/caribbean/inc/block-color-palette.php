<?php
/**
 * Block color palette information
 */
/**
 * Define the block color palette
 *
 * If updating these colors, please update less/vars.less. Slugs should match LESS var names.
 *
 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/
 * @return Array of Arrays
 */
function caribbean_block_colors() {
	return array(
		array(
			'name' => __( 'White', 'caribbean' ),
			'slug' => 'white',
			'color' => 'white',
        ),
        array(
			'name' => __( 'Black', 'caribbean' ),
			'slug' => 'black',
			'color' => '#313131',
		),
		array(
			'name' => __( 'Grey', 'caribbean' ),
			'slug' => 'grey',
			'color' => '#4A4A4A',
		),
		array(
			'name' => __( 'Grey 2', 'caribbean' ),
			'slug' => 'grey2',
			'color' => '#E2E2E2',
		),
		array(
			'name' => __( 'Grey 3', 'caribbean' ),
			'slug' => 'grey3',
			'color' => '#CDCDCD',
		),
		array(
			'name' => __( 'Red', 'caribbean' ),
			'slug' => 'red',
			'color' => '#ED4424',
		),
		array(
			'name' => __( 'Teal', 'caribbean' ),
			'slug' => 'teal',
			'color' => '#00829A',
        ),
        array(
			'name' => __( 'Blue', 'caribbean' ),
			'slug' => 'blue',
			'color' => '#1897BE',
		),
	);
}
add_theme_support( 'editor-color-palette', caribbean_block_colors() );
/**
 * Loop over the defined colors and create classes for them
 *
 * @uses caribbean_block_colors
 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/
 */
function caribbean_block_colors_styles() {
	$colors = caribbean_block_colors();
	if ( is_array( $colors ) && ! empty( $colors ) ) {
		echo '<style type="text/css" id="caribbean_block_colors_styles">';
		foreach ( $colors as $color ) {
			if (
				is_array( $color )
				&& isset( $color['slug'] )
				&& isset( $color['color'] )
			) {
				printf(
					'.has-%1$s-background-color { background-color: %2$s; }',
					$color['slug'],
					$color['color']
				);
				printf(
					'.has-%1$s-color { color: %2$s; }',
					$color['slug'],
					$color['color']
				);
			}
		}
		echo '</style>';
	}
}
add_action( 'wp_print_styles', 'caribbean_block_colors_styles' );