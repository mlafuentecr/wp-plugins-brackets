<?php
/**
 * Register Api 
 *
 * @link       https://revmasters.com
 * @since      1.0.0
 *
 * @package    Prevent_Brackets
 * @subpackage Prevent_Brackets/includes
 */



 class Prevent_Brackets_add_tab {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	// Hook to add a custom admin menu item
	 function load_tab() {

    // Check function exists.
    if( function_exists('acf_add_options_page') ) {
			acf_add_options_page(array(
        'page_title'    => 'Bracket Contest',
        'menu_title'    => 'Bracket Contest',
        'menu_slug'     => 'bracket_contest',
        'capability'    => 'edit_posts',
				'autoload' 			=> true,
				'update_button' => __('Update Bracket', 'acf'),
				'icon_url' 			=> 'dashicons-editor-kitchensink',
				'redirect'      => false
    ));

	}
	}

}
