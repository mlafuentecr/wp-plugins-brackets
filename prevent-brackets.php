<?php

/**
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://revmasters.com
 * @since             1.0.0
 * @package           Prevent_Brackets
 *
 * @wordpress-plugin
 * Plugin Name:       Prevent-Brackets 
 * Plugin URI:        https://revmasters.com
 * Description:       RevMaster.com's NFL Brackets plugin simplifies tracking and managing your NFL predictions. Enhance your football experience and potentially increase your passive income.
 * Version:           1.0.0
 * Author:            Mario Lafuente
 * Author URI:        https://revmasters.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       prevent-brackets
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
define( 'PREVENT_BRACKETS_VERSION', '1.0.0' );


function activate_prevent_brackets() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-prevent-brackets-activator.php';
	Prevent_Brackets_Activator::activate();

	
}

function deactivate_prevent_brackets() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-prevent-brackets-deactivator.php';
	Prevent_Brackets_Deactivator::deactivate();
	
}

register_activation_hook( __FILE__, 'activate_prevent_brackets' );
register_deactivation_hook( __FILE__, 'deactivate_prevent_brackets' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-prevent-hooks-loader.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_prevent_brackets() {

	$plugin = new Prevent_Brackets();
	$plugin->run();

}
run_prevent_brackets();

