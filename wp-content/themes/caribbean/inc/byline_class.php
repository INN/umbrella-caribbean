<?php

// require the main Largo_Byline class so we can extend it
require_once( get_template_directory().'/inc/byline_class.php' );

// For custom bylines specific to the Caribbean child theme
class Caribbean_Byline extends Largo_Byline {

	function populate_variables( $args ) {
		$this->post_id = $args['post_id'];
		$this->exclude_date = $args['exclude_date'];
		$this->custom = get_post_custom( $this->post_id );
		$this->author_id = get_post_field( 'post_author', $this->post_id, true );
		$this->show_avatar = $args['show_avatar'];
	}
	/**
	 * Modifies the default Largo_Byline avatar function to wrap
	 * the avatar in a div so we can style the avatar with a specific inner outline
	 */
	function avatar() {
		$output = '';
		if( true === $this->show_avatar ){
			$author_email = get_the_author_meta( 'email', $this->author_id );
			if ( isset( $this->author ) && $this->author->type == 'guest-author' && get_the_post_thumbnail( $this->author->ID ) ) {
				$output = get_the_post_thumbnail( $this->author->ID, array( 60,60 ) );
				$output = str_replace( 'attachment-32x32', 'avatar avatar-32 photo', $output );
				$output = str_replace( 'wp-post-image', '', $output );
			} else if ( largo_has_avatar( $author_email ) ) {
				$output = get_avatar(
					$author_email,
					32,
					'',
					get_the_author_meta( 'display_name', $this->author_id ),
					array(
						'class' => 'avatar avatar-32 photo',
					)
				);
			}
			$output .= ' '; // to reduce run-together bylines
			echo '<div class="byline-avatar-wrapper inner-circle">'.$output.'</div>';
		}
	}
}
