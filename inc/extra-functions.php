<?php
/**
 * Custom Functions
 *
 * @package Project Name
 */

/**
 * 
 * Disable Comments
 *
 */
add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;

    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

/**
 * Allow SVG uploads for administrator users.
 *
 * @param array $upload_mimes Allowed mime types.
 *
 * @return mixed
 */
add_filter(
    'upload_mimes',
    function ($upload_mimes) {
        // By default, only administrator users are allowed to add SVGs.
        // To enable more user types edit or comment the lines below but beware of
        // the security risks if you allow any user to upload SVG files.
        if (!current_user_can('administrator')) {
            return $upload_mimes;
        }

        $upload_mimes['svg'] = 'image/svg+xml';
        $upload_mimes['svgz'] = 'image/svg+xml';

        return $upload_mimes;
    }
);

/**
 * Add SVG files mime check.
 *
 * @param array        $wp_check_filetype_and_ext Values for the extension, mime type, and corrected filename.
 * @param string       $file Full path to the file.
 * @param string       $filename The name of the file (may differ from $file due to $file being in a tmp directory).
 * @param string[]     $mimes Array of mime types keyed by their file extension regex.
 * @param string|false $real_mime The actual mime type or false if the type cannot be determined.
 */
add_filter(
    'wp_check_filetype_and_ext',
    function ($wp_check_filetype_and_ext, $file, $filename, $mimes, $real_mime) {

        if (!$wp_check_filetype_and_ext['type']) {

            $check_filetype = wp_check_filetype($filename, $mimes);
            $ext = $check_filetype['ext'];
            $type = $check_filetype['type'];
            $proper_filename = $filename;

            if ($type && 0 === strpos($type, 'image/') && 'svg' !== $ext) {
                $ext = false;
                $type = false;
            }

            $wp_check_filetype_and_ext = compact('ext', 'type', 'proper_filename');
        }

        return $wp_check_filetype_and_ext;

    },
    10,
    5
);

/**
 * 
 * Change Admin Footer Text
 *
 */
add_filter(
    'admin_footer_text',
    function ($footer_text) {
        // Edit the line below to customize the footer text.
        $footer_text = '<span>Copyright 2024© All Rights Reserved to <a href="https://project-name.com/" target="_blank" rel="noopener">Project Name</a></span>';

        return $footer_text;
    }
);


/**
 * 
 * Update Site Data
 *
 */
if (!function_exists('update_site_data')) {
    // add_action('admin_init', 'update_site_data');
    function update_site_data()
    {
        $site_title = get_field('site_title', 'option') ?? '';
        $site_tagline = get_field('site_tagline', 'option') ?? '';
        $fav_icon = get_field('fav_icon', 'option') ?? '';

        update_option('blogname', $site_title);
        update_option('blogdescription', $site_tagline);
        update_option('site_icon', $fav_icon);
    }
}


/**
 * 
 * Register custom bricks elements
 * 
 */
add_action('init', function () {
    $element_files = [
        __DIR__ . '/elements/title.php',
    ];

    foreach ($element_files as $file) {
        \Bricks\Elements::register_element($file);
    }
}, 11);