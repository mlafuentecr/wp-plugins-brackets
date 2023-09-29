<?php
/**
 * Plugin Name: Admin Tab Plugin
 * Description: This plugin adds a custom tab in the admin panel.
 * Version: 1.0
 * Author: Your Name
 */



 class ACF_Onsave  {

    public function save_data_to_api( $post_id ) {
        $bracket = get_fields( $post_id );
        $Allbrackets = get_field('create_a_bracket', $post_id );
       
        //on save check what leagues Do I have 
       // $mlb =$Allbrackets[1]["select_a_league"]["value"];

       // wp_die( var_dump( $brackets[1]["select_a_league"]["value"] ) );

    //update_post_meta($post_id, 'my_special_message_flag', 1);
}

}


