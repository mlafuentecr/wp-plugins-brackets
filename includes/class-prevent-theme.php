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

class Prevent_Brackets_Theme {


  function theme_supported_features() {
    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => esc_attr__( 'strong magenta', 'themeLangDomain' ),
            'slug'  => 'strong-magenta',
            'color' => '#a156b4',
        ),
        array(
            'name'  => esc_attr__( 'light grayish magenta', 'themeLangDomain' ),
            'slug'  => 'light-grayish-magenta',
            'color' => '#d0a5db',
        ),
        array(
            'name'  => esc_attr__( 'very light gray', 'themeLangDomain' ),
            'slug'  => 'very-light-gray',
            'color' => '#eee',
        ),
        array(
            'name'  => esc_attr__( 'very dark gray', 'themeLangDomain' ),
            'slug'  => 'very-dark-gray',
            'color' => '#444',
        ),
    ) );
}

//add_action( 'after_setup_theme', 'theme_supported_features' );




}