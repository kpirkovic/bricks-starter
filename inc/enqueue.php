<?php
/**
 * Enqueue scripts and styles
 *
 * @package WP Made
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * 
 * Enqueue Block Editor Scripts and Styles
 *  
 */
if (!function_exists('enqueue_editor_styles_and_scripts')) {
    add_action('enqueue_block_editor_assets', 'enqueue_styles_and_scripts');

    function enqueue_styles_and_scripts()
    {
        wp_enqueue_style('wpmade-css', get_stylesheet_directory_uri() . '/public/editor.css');
    }
}

/**
 * 
 * Enqueue Frontend Scripts and Styles
 *  
 */
if (!function_exists('enqueue_frontend_styles_and_scripts')) {
    add_action('wp_enqueue_scripts', 'enqueue_frontend_styles_and_scripts');

    function enqueue_frontend_styles_and_scripts()
    {
        wp_enqueue_script('wpmade-js', get_stylesheet_directory_uri() . '/public/index.js');
        wp_enqueue_style('wpmade-css', get_stylesheet_directory_uri() . '/public/index.css');

        if ( !bricks_is_builder_main() ) {
            wp_enqueue_style( 'bricks-child', get_stylesheet_uri(), ['bricks-frontend'], filemtime( get_stylesheet_directory() . '/style.css' ) );
        }
    }
}

/**
 * 
 * Enqueue Admin Scripts and Styles
 *  
 */
if (!function_exists('enqueue_admin_styles_and_scripts')) {
    add_action('admin_enqueue_scripts', 'enqueue_admin_styles_and_scripts');

    function enqueue_admin_styles_and_scripts()
    {
        wp_enqueue_style('wpmade-admin-css', get_stylesheet_directory_uri() . '/public/admin.css');
    }
}

/**
 * 
 * Remove Block Editor Default Styles
 *  
 */
if (!function_exists('remove_block_editor_styles')) {
    // Hook the function to the wp_enqueue_scripts action
    add_action('wp_enqueue_scripts', 'remove_block_editor_styles', 100);
    function remove_block_editor_styles()
    {
        wp_dequeue_style('wp-block-library');         // Remove Gutenberg block library styles
        wp_dequeue_style('wp-block-library-theme');   // Remove Gutenberg default theme styles
        wp_dequeue_style('wc-block-style');           // Remove WooCommerce block styles if applicable

        // Optionally, remove the block editor script (uncomment the line below)
        wp_dequeue_script('wp-block-library');
    }
}