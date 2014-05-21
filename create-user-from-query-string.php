<?php
/**
 * Plugin Name: Create Users from Query String
 * Description: Allows you to create users based on query string parameters in the URL. Extremely helpful when locked out of WordPress, but can access the site via FTP, etc.
 * Version: .1
 * Author: Sleeping Willow Creative
 * Contributors: messica
 * Author URI: http://sleepingwillowcreative.com
 */

/* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * If you are locked out of WordPress, add this to your active theme's functions.php file:
// BEGIN FORCE ACTIVATION CODE
function cuqs_force_activation() {
    $active_plugins = get_option('active_plugins');
    $cuqs = 'create-user-from-query-string/create-user-from-query-string.php';

    if(in_array($cuqs, $active_plugins))
        die('Create User from Query String is already activated. Please delete the force activation code from ' .  __FILE__ . ' and try again.');

    if(!file_exists( WP_PLUGIN_DIR . '/' . $cuqs ))
        die('Plugin files are missing. Please add the create-user-from-query-string directory to ' . WP_PLUGIN_DIR . ' and try again.');

    //OK, go ahead and activate it.
    $active_plugins[] = $cuqs;
    update_option('active_plugins', $active_plugins);
    die('Create User from Query String is now activated. Please delete the force activation code from ' . __FILE__);
}
add_action('after_setup_theme', 'cuqs_force_activation');
// END FORCE ACTIVATION CODE
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */

/*
 * Globals
 */
global $cuqs_options;
$cuqs_options = get_option('cuqs_options');
if(empty($cuqs_options))
    $cuqs_options = array();

/*
 * Require Files
 */
require_once(plugin_dir_path(__FILE__) . '/inc/functions.php');

/*
 * Initialize Plugin
 */
add_action('plugins_loaded', 'cuqs_init');

/*
 * Activation/Deactivation Hooks
 */
function cuqs_activate() {
    update_option('cuqs_options', array('enabled' => true, 'show_admin_panel' => false, 'default_role' => 'administrator'));
}

function cuqs_deactivate() {
    delete_option('cuqs_options');
}
register_activation_hook(__FILE__, 'cuqs_activate');
register_deactivation_hook(__FILE__, 'cuqs_deactivate');