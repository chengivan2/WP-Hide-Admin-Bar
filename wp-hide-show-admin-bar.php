<?php
/*
Plugin Name: WP Enable & Disable Admin Bar
Description: This plugin allows the admin to disable and enable the WordPress admin bar from the frontend.
Version: 1.0
Author: Ivan the Dev
Author URI: https://ivanthedev.guru/
*/

// Add settings page
function disable_admin_bar_settings_page() {
    add_options_page('Disable Admin Bar', 'Disable Admin Bar', 'manage_options', 'disable-admin-bar', 'disable_admin_bar_settings_page_content');
}
add_action('admin_menu', 'disable_admin_bar_settings_page');

// Settings page content
function disable_admin_bar_settings_page_content() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('disable_admin_bar');
            do_settings_sections('disable_admin_bar');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

// Register settings
function disable_admin_bar_settings() {
    register_setting('disable_admin_bar', 'disable_admin_bar');
    add_settings_section('disable_admin_bar_section', 'Settings', '', 'disable_admin_bar');
    add_settings_field('disable_admin_bar_field', 'Disable admin bar', 'disable_admin_bar_field_callback', 'disable_admin_bar', 'disable_admin_bar_section');
}
add_action('admin_init', 'disable_admin_bar_settings');

// Settings field callback
function disable_admin_bar_field_callback() {
    $disable_admin_bar = get_option('disable_admin_bar');
    $checked = isset($disable_admin_bar) && $disable_admin_bar === '1' ? 'checked' : '';
    echo '<input type="checkbox" name="disable_admin_bar" value="1" '.$checked.'>';
}

// Disable admin bar on the frontend
function disable_admin_bar_on_frontend() {
    if (!is_admin() && get_option('disable_admin_bar')) {
        show_admin_bar(false);
    }
}
add_action('init', 'disable_admin_bar_on_frontend');

// Add settings link to plugins page
function disable_admin_bar_add_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=disable-admin-bar">' . __('Settings') . '</a>';
    array_push($links, $settings_link);
    return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'disable_admin_bar_add_settings_link');
?>