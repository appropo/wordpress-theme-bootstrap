<?php

function configure_TinyMCE($settings) {

	/* ----------------------------------------------------------
	 * Allow more tags in TinyMCE including <iframe> and <script>
	 * ---------------------------------------------------------- */
	$extensions = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src],script[charset|defer|language|src|type]';

	if ( isset($settings['extended_valid_elements']) ) {
		$settings['extended_valid_elements'] .= ',' . $extensions;
	} else {
		$settings['extended_valid_elements'] = $extensions;
	};

    /* ----------------------------------------------------
     * Enable only the necessary buttons and format options
     * ---------------------------------------------------- */
	$settings['theme_advanced_buttons1']		= 'formatselect,|,bold,italic,underline,|,bullist,numlist,blockquote,|,link,unlink,|,wp_adv';
	$settings['theme_advanced_buttons2']		= 'pastetext,pasteword,removeformat,|,undo,redo';
	$settings['theme_advanced_blockformats'] 	= 'p,h1,h2,h3,h4';

	return $settings;
}

add_filter('tiny_mce_before_init', 'configure_TinyMCE' );