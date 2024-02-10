<?php
/**
 * @package           WP Made
 * @author            Krisitjan Pirkovic
 * @copyright         2023 WP Made
 *
 * WP Made functions and definitions
 * 
 */

//exit if accessed directly.
defined('ABSPATH') || exit;

//array of files to include.
$theme_functions = array(
  '/setup.php',                 // Theme Setup
  '/extra-functions.php',       // Custom Functions
  '/enqueue.php',               // Load Scripts and Styles
);

//include files.
if (!empty($theme_functions)) {
  foreach ($theme_functions as $file) {
    require_once get_stylesheet_directory() . '/inc' . $file;
  }
}



