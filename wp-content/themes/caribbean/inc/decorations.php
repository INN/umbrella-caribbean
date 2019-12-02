<?php
/**
 * Functions for decorative elements
 */

/**
 * Add a line at the bottom of articles, with a CIJN logo
 *
 * Done as an actual element rather than a pseudoelement because
 * there's no good selector to hook a pseudoelement on:
 * - article is wider than the main column of the article
 * - section is wider than the main column of the article
 * - any element within section is part of the article's post_content
 *
 * @link https://github.com/INN/umbrella-caribbean/issues/23
 */
function caribbean_article_bottom() {
	echo '<div class="entry-content cijn-border-bottom"></div>';
}
add_action( 'largo_after_post_content', 'caribbean_article_bottom' );
