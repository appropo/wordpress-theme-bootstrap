<?php

/* ---------------------------
 * Modify the admin menu items
 * --------------------------- */
function custom_admin_menu() {

	remove_menu_page('edit-comments.php');

};

add_action( 'admin_init', 'custom_admin_menu' );


/* --------------------
 * Modify the admin bar
 * -------------------- */
function custom_admin_bar() {
	global $wp_admin_bar;

	$wp_admin_bar->remove_menu('new-content');
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('wp-logo');

};

add_action( 'wp_before_admin_bar_render', 'custom_admin_bar' );