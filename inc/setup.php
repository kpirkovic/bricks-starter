<?php
/**
 * Theme Setup
 *
 * @package Project Name
 */

/**
 * 
 * Load ACF JSON Files
 *  
 */
if (!function_exists('my_acf_json_load_point')) {

	// Hook into ACF settings
	add_filter('acf/settings/load_json', 'my_acf_json_load_point');

	// Load ACF JSON files
	function my_acf_json_load_point($paths)
	{
		// Add your theme's ACF JSON folder path
		$paths[] = get_template_directory() . '/acf-json';

		return $paths;
	}
}

/**
 * 
 * Remove WordPress Customizeer
 *  
 */
if (!function_exists('disable_theme_customizer')) {

	add_action('admin_menu', 'disable_theme_customizer');
	function disable_theme_customizer()
	{
		global $wp_customize;

		// Remove the Customize link from the admin menu
		remove_submenu_page('themes.php', 'customize.php');

		// Optionally, remove the Customize link from the admin bar
		function remove_customize_admin_bar_link()
		{
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu('customize');
		}
		add_action('wp_before_admin_bar_render', 'remove_customize_admin_bar_link');

		// Disable the customizer preview on the frontend
		remove_action('wp_head', array($wp_customize, 'wp_head'), 1);
	}
}

/**
 * 
 * Remove Adminbar Links
 *  
 */
if (!function_exists('remove_admin_bar_links')) {
	add_action('wp_before_admin_bar_render', 'remove_admin_bar_links');
	function remove_admin_bar_links()
	{
		global $wp_admin_bar;

		// Remove the WordPress customize link
		$wp_admin_bar->remove_menu('customize');

		// Remove the WordPress updates link
		$wp_admin_bar->remove_menu('updates');

		// Remove the comments link
		$wp_admin_bar->remove_menu('comments');
	}
}

/**
 * 
 * Remove Site Title & Tagline in Options
 *  
 */
if (!function_exists('remove_site_tagline_title_options')) {
	add_action('admin_init', 'remove_site_tagline_title_options');
	function remove_site_tagline_title_options()
	{
		unregister_setting('general', 'blogname');
		unregister_setting('general', 'blogdescription');
	}
}
