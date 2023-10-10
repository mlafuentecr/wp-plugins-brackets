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
  // $path = preg_replace( '/wp-content.*$/', '', __DIR__ );
  // require_once( $path . 'wp-load.php' );
  // Example server-side code (PHP)


  function saveACF() {
    echo 'ENTRE saveACF';
    if (isset($_POST['action'])) {
      $leagueSelected = $_POST['leagueSelected']; //from bracket click js
      $option_value   = get_field('create_a_bracket', 'option'); //acf
      $testField      = get_field( 'field_6518931d0cf5a', 'option');
 

      echo $leagueSelected;
      foreach ($option_value as $bracketFromACF) {
        $braketName = $bracketFromACF["select_a_league"]["value"];
        $teamName_1 = $bracketFromACF["teamtest"]["test"];
       
        
        if( $braketName == $leagueSelected){
          echo 'ENTRE';
          $groupTeamTest  = "field_6515b2851d850";
          $testField = get_field( 'field_6515b2851d850', 'option');
          $bracket_title = get_field( 'bracket_title', 'option');
     
          update_field('bracket_title', 'title new test', 'option');
          
          if ($bracket_title) {
            echo ' Field updated successfully '.$bracket_title. '<---';
        } else {
            echo ' Field update failed ';
        }
        
          echo'$bracket_title='.$bracket_title.' ';
          echo' $teamName_1='.$groupTeamTest.' ';
        
        }

      }

      $response = array('message' => 'AJAX Data saved successfully');
      //wp_send_json($response);
      wp_die(json_encode($response), '', 200, true);
    }
  }


}
