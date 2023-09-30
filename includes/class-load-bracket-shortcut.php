<?php

/**
 * load the template for each bracket
 *
 * @link       https://revmasters.com
 * @since      1.0.0
 *
 * @package    Prevent_Brackets
 * @subpackage Prevent_Brackets/includes
 */

 class Bracket_template {

  public function load_mlb_template() {
    ob_start();
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/bracket-template_mlb.php';
    return ob_get_clean();
  }

  public function load_nfl_template() {
    ob_start();
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/bracket-template_nfl.php';
    return ob_get_clean();
  }
}

// // Initialize the class
// new Bracket_shortcuts();
