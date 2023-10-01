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
  
  function saveACF() {
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
          //ESTA fallando creo que seria mejro cargarlo manual
          $value1 = array(
            'rank' => 33,
          );
    
          update_field($groupTeamTest, $value1, 'option');
          
          if ($field_name) {
            echo ' Field updated successfully '.$testField. '<---';
        } else {
            echo ' Field update failed ';
        }
    
        
          echo'$testField='.$testField.' ';
          echo' $teamName_1='.$groupTeamTest.' ';
        
        }
        var_dump($testField);
          
          // if( $braketName == $leagueSelected){
          //   //var_dump($bracketFromACF);
          //   $value = get_field( 'field_6518931d0cf5a', 'option');
          //   var_dump('field=', $option_value);
          //   update_field('field_6518931d0cf5a', 'value here', 'option');
          //   // var_dump('field=', $teamName_1);
          // }
          //var_dump('$leagueSelected=', $leagueSelected, $bracketFromACF["select_a_league"]["value"]);
      }
      // //acf[field_6513599e12351][row-0][field_65184dec6f009][field_65184dec6f00a]
      // Send a response (optional)
      $response = array('message' => 'AJAX Data saved successfully');
      //wp_send_json($response);
      wp_die(json_encode($response), '', 200, true);
    }
  }


}
