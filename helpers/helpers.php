<?php

/* ----------------------------------------------
 * Returns the role of the current user as string
 * ---------------------------------------------- */
function get_user_role() {
	global $wp_roles;

	$current_user 	= wp_get_current_user();
	$roles 			= $current_user->roles;
	$role 			= array_shift($roles);

	return ( isset( $wp_roles->role_names[$role] ) ? strtolower($wp_roles->role_names[$role]) : "" );
};


/* -----------------------------------------------------------
 * Custom function to get posts´s attachment URL or a fallback
 * ----------------------------------------------------------- */
function get_image_url( $post_id, $image_size ) {

	$url 				= "";
	$attachment_id		= get_post_thumbnail_id( $post_id );
	$attachment_attr 	= wp_get_attachment_image_src( $attachment_id, $image_size );

	/* ------------------------------------------------
	 * Build the right fallback if empty attachment URL
	 * ------------------------------------------------ */
	if ( empty( $attachment_attr[0] ) ) {

		// fallback image

	} else {

		$url = $attachment_attr[0];

	};

	return $url;
};