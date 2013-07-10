<?php

/* ---------------------------
 * Customize admin login, yeh!
 * --------------------------- */

// Custom Admin Login - Logo
function my_custom_login_logo() {
    echo '<style  type="text/css"> h1 a {  background-image:url(' . get_bloginfo('template_directory') . '/images/admin-media/login-logo.png)  !important; } </style>';
};

// Custom Admin Login - Logo Link
function change_wp_login_url() {
    return get_bloginfo('url');  // OR ECHO YOUR OWN URL
};

// Custom Admin Login - Logo Title
function change_wp_login_title() {
    return get_option('blogname'); // OR ECHO YOUR OWN ALT TEXT
};

add_action('login_head',  'my_custom_login_logo');
add_filter('login_headerurl', 'change_wp_login_url');
add_filter('login_headertitle', 'change_wp_login_title');
