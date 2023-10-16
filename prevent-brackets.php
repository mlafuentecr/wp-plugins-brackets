<?php
/**
 * Bracket-contest-23
 *
 * @package bracket-contest
 * @license MIT
 */

/**
 * Plugin Name: Bracket-contest
 * Author: Mario Lafuente
 * Description: Feature plugin to build brackets contests
 * Version: 1.3.1
 * Network: true
 * License: MIT
 * Text Domain: bracket-contest
 * Requires PHP: 7.0
 * Requires at least: 6.3
 * GitHub Plugin URI: https://github.com/WordPress/bracket-contest
 * Primary Branch: main
 */

/*
 * Exit if called directly.
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('PREVENT_BRACKETS_VERSION', '1.0.0');

function activate_prevent_brackets()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-prevent-brackets-activator.php';
    Prevent_Brackets_Activator::activate();
}

function deactivate_prevent_brackets()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-prevent-brackets-deactivator.php';
    Prevent_Brackets_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_prevent_brackets');
register_deactivation_hook(__FILE__, 'deactivate_prevent_brackets');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-prevent-hooks-loader.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 */
function run_prevent_brackets()
{
    $plugin = new Prevent_Brackets();
    $plugin->run();
}
run_prevent_brackets();
