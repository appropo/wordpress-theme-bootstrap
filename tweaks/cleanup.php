<?php
/* ------------------------------------------------
 * Clean up wp_head()
 *
 * Remove unnecessary <link>'s
 * Remove inline CSS used by Recent Comments widget
 * ------------------------------------------------ */
function roots_head_cleanup() {
	// Originally from http://wpengineer.com/1438/wordpress-header/
	remove_action( 'wp_head', 'feed_links_extra', 3 ); 				// Display the links to the extra feeds such as category feeds
	remove_action( 'wp_head', 'feed_links', 2 ); 					// Display the links to the general feeds: Post and Comment Feed
	remove_action( 'wp_head', 'rsd_link' ); 						// Display the link to the Really Simple Discovery service endpoint, EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' ); 				// Display the link to the Windows Live Writer manifest file.
	remove_action( 'wp_head', 'index_rel_link' ); 					// index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); 		// prev link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); 		// start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); 	// Display relational links for the posts adjacent to the current post.
	remove_action( 'wp_head', 'wp_generator' ); 					// Display the XHTML generator that is generated on the wp_head hook, WP version

	global $wp_widget_factory;
	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}

/* ----------------------------------------------------------------
 * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 * ---------------------------------------------------------------- */
function roots_embed_wrap($cache, $url, $attr = '', $post_ID = '') {
	return '<div class="entry-content-asset">' . $cache . '</div>';
}
add_filter('embed_oembed_html', 'roots_embed_wrap', 10, 4);
add_filter('embed_googlevideo', 'roots_embed_wrap', 10, 2);


/* ------------------------------------------------------------------------
 * Add Bootstrap thumbnail styling to images with captions
 * Use <figure> and <figcaption>
 *
 * @link http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 * ------------------------------------------------------------------------ */
function roots_caption($output, $attr, $content) {
	if (is_feed()) {
		return $output;
	}

	$defaults = array(
		'id'      => '',
		'align'   => 'alignnone',
		'width'   => '',
		'caption' => ''
	);

	$attr = shortcode_atts($defaults, $attr);

	// If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
	if ($attr['width'] < 1 || empty($attr['caption'])) {
		return $content;
	}

	// Set up the attributes for the caption <figure>
	$attributes  = (!empty($attr['id']) ? ' id="' . esc_attr($attr['id']) . '"' : '' );
	$attributes .= ' class="thumbnail wp-caption ' . esc_attr($attr['align']) . '"';
	$attributes .= ' style="width: ' . esc_attr($attr['width']) . 'px"';

	$output  = '<figure' . $attributes .'>';
	$output .= do_shortcode($content);
	$output .= '<figcaption class="caption wp-caption-text">' . $attr['caption'] . '</figcaption>';
	$output .= '</figure>';

	return $output;
}
add_filter('img_caption_shortcode', 'roots_caption', 10, 3);


/* --------------------------------------------------------------------------------------
 * Remove unnecessary dashboard widgets
 *
 * @link http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
 * -------------------------------------------------------------------------------------- */
function roots_remove_dashboard_widgets() {
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
	remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
	remove_meta_box('dashboard_primary', 'dashboard', 'normal');
	remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
}
add_action('admin_init', 'roots_remove_dashboard_widgets');


/* ----------------------
 * Clean up the_excerpt()
 * ---------------------- */
function roots_excerpt_length($length) {
	return POST_EXCERPT_LENGTH;
}

function roots_excerpt_more($more) {
	return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'roots') . '</a>';
}
add_filter('excerpt_length', 'roots_excerpt_length');
add_filter('excerpt_more', 'roots_excerpt_more');


/* ----------------------------------------------------------
 * Allow more tags in TinyMCE including <iframe> and <script>
 * ---------------------------------------------------------- */
function roots_change_mce_options($options) {
	$ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src],script[charset|defer|language|src|type]';

	if (isset($initArray['extended_valid_elements'])) {
		$options['extended_valid_elements'] .= ',' . $ext;
	} else {
		$options['extended_valid_elements'] = $ext;
	}

	return $options;
}
add_filter('tiny_mce_before_init', 'roots_change_mce_options');


/* --------------------------------------------------------------------------------------------
 * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
 * -------------------------------------------------------------------------------------------- */
function roots_request_filter($query_vars) {
	if (isset($_GET['s']) && empty($_GET['s'])) {
		$query_vars['s'] = ' ';
	}

	return $query_vars;
}
add_filter('request', 'roots_request_filter');


/* ------------------------------------------------------------------
 * Tell WordPress to use searchform.php from the templates/ directory
 * ------------------------------------------------------------------ */
function roots_get_search_form($argument) {
	if ($argument === '') {
		locate_template('/templates/searchform.php', true, false);
	}
}
add_filter('get_search_form', 'roots_get_search_form');
