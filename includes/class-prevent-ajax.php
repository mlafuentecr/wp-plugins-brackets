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

 

class Bracket_ajax {
  /**
   * Handle the saveACF AJAX request.
   */
  function saveACF() {
    if (isset($_POST['action'])) {
      $option_value = get_field('create_a_bracket', 'option'); //acf
      $leagueSelected = $_POST['leagueSelected']; //from bracket click js

      foreach ($option_value as $bracketFromACF) {
          $braketName = $bracketFromACF["select_a_league"]["value"];
          $teamName_1 = $bracketFromACF["teamtest"]["team_name"];
          if( $braketName == $leagueSelected){
            var_dump($bracketFromACF);
          }
          var_dump('$leagueSelected=', $leagueSelected, $bracketFromACF["select_a_league"]["value"]);
      }

      // Send a response (optional)
      $response = array('message' => 'Data saved successfully');
      //wp_send_json($response);
      wp_die(json_encode($response), '', 200, true);
    }
  }


}
