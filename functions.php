<?php
/* -----------------------------------------
 * Include all necessary files for the theme
 * ----------------------------------------- */

/* ------
 * Tweaks
 * ------ */
require_once locate_template('/tweaks/init.php');			// Initial theme setup and constants
require_once locate_template('/tweaks/custom.php');			// Custom functions
require_once locate_template('/tweaks/cleanup.php');		// Cleanup
require_once locate_template('/tweaks/nav.php');			// Custom nav modifications
require_once locate_template('/tweaks/tinymce.php');		// Configure TinyMCE

/* -------
 * Helpers
 * ------- */
require_once locate_template('/helpers/helpers.php'); // Custom helper functions

/* -------
 * Extends
 * ------- */