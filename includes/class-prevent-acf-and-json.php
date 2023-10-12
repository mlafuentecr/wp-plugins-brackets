<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://revmasters.com
 * @since      1.0.0
 *
 * @package    Prevent_Brackets
 * @subpackage Prevent_Brackets/admin
 */

 

class load_acf_and_json {


  // Check if ACF is installed and not already loaded
  // function check_for_acf() {
  //   if (function_exists('acf')) {
  //       // Load ACF
  //       acf()->include_libraries();
  //       acf()->init();
  //   }
  // }


//add_filter( 'acf/settings/save_json', 'acf_location' );
function acf_location() {
  //print_r(plugin_dir_path( __FILE__ )).die();
	return plugin_dir_path( __FILE__ ) . 'acf-json/';
}




}
