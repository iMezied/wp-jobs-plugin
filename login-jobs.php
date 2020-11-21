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

/**
 * add plugin options page
 */
function loginjobs_add_settings_page()
{
    add_options_page(
        'Jobs Settings Page',
        'LOGIN Jobs',
        'manage_options',
        'login-jobs-settings-page',
        'loginjobs_render_plugin_settings_page'
    );
}
add_action('admin_menu', 'loginjobs_add_settings_page');

/**
 * Plugin setting page content
 */
function loginjobs_render_plugin_settings_page()
{
?>
    <form action="options.php" method="post">
        <?php
        settings_fields('loginjobs_jobs_options_group');
        do_settings_sections('login-jobs-settings-page'); ?>
        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save'); ?>" />
    </form>
<?php
}


function loginjobs_register_settings()
{
    add_option('job_close_duration');

    register_setting('loginjobs_jobs_options_group', 'job_close_duration');

    add_settings_section(
        'loginjaobs_jobs_section_options',
        'Jobs Options',
        'loginjobs_plugin_section_text',
        'login-jobs-settings-page'
    );

    add_settings_field(
        'loginjobs_jobs_close_duration',
        'Jobs Close Duration',
        'loginjobs_plugin_setting_close_duration',
        'login-jobs-settings-page',
        'loginjaobs_jobs_section_options'
    );
}
add_action('admin_init', 'loginjobs_register_settings');


function loginjobs_plugin_setting_close_duration()
{
    $options = get_option('job_close_duration');
    echo "<input id='loginjobs_plugin_setting_close_duration' name='job_close_duration' type='number' value='{$options}' /> Days";
}

function loginjobs_plugin_section_text()
{
    echo '<p>Here you can set all the options that related to posted jobs</p>';
}
