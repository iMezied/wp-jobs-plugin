<?php

/**
 * Plugin Name:       Login-Jobs
 * Plugin URI:        https://imezied.com
 * Description:       Login - Jobs plugin
 * Author:            LOGIN WP-Team
 * Author URI:        https://imezied.com
 * Version:           1.0.0
 */


/**
 * Register the "Jobs" custom post type
 */
if (!function_exists('loginjobs_setup_post_type')) {
    function loginjobs_setup_post_type()
    {
        $title = 'jobs';

        if (isset($title)) {
            register_post_type($title, [
                'label' => ucfirst($title),
                'public' => true,
                'menu_icon' =>
                'dashicons-chart-line'
            ]);
        }
    }
}

add_action('init', 'loginjobs_setup_post_type');

/**
 * Activate the plugin.
 */
function loginjobs_activate()
{
    // Trigger our function that registers the custom post type plugin.
    loginjobs_setup_post_type();
    // Clear the permalinks after the post type has been registered.
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'loginjobs_activate');

/**
 * Deactivation hook.
 */
function loginjobs_deactivate()
{
    // Unregister the post type, so the rules are no longer in memory.
    unregister_post_type('new');
    // Clear the permalinks to remove our post type's rules from the database.
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'loginjobs_deactivate');
