<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://revmasters.com
 * @since      1.0.0
 *
 * @package    Prevent_Brackets
 * @subpackage Prevent_Brackets/includes
 */

 class Bracket_shortcuts {

  public function load_mlb_template() {
    ob_start();
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/bracket-template_mlb.php';
    return ob_get_clean();
  }
}

// Initialize the class
new Bracket_shortcuts();
