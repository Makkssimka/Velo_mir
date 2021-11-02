<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Call_Form_Free
 *
 * @wordpress-plugin
 * Plugin Name:       Плагин обратного звонка
 * Plugin URI:        http://example.com/call-form-free-uri/
 * Description:       Плагин для управления обратными звонками.
 * Version:           1.0.0
 * Author:            Makkssimka
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       call-form-free
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
global $wpdb;

define( 'CALL_FORM_FREE_VERSION', '1.0.0' );
define( 'CALL_FORM_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'CALL_FORM_TABLE_NAME', $wpdb->prefix."call_form_free");

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-call-form-free-activator.php
 */
function activate_call_form_free() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-call-form-free-activator.php';
	$activator = new Call_Form_Free_Activator();
	$activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-call-form-free-deactivator.php
 */
function deactivate_call_form_free() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-call-form-free-deactivator.php';
	$deactivator = new Call_Form_Free_Deactivator();
    $deactivator->deactivate();
}

register_activation_hook( __FILE__, 'activate_call_form_free' );
register_deactivation_hook( __FILE__, 'deactivate_call_form_free' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-call-form-free.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_call_form_free() {

	$plugin = new Call_Form_Free();
	$plugin->run();

}
run_call_form_free();
