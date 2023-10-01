<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://revmasters.com
 * @since      1.0.0
 *
 * @package    Prevent_Brackets
 * @subpackage Prevent_Brackets/includes
 */

class Prevent_Brackets {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Prevent_Brackets_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PREVENT_BRACKETS_VERSION' ) ) {
			$this->version = PREVENT_BRACKETS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'prevent-brackets';

		$this->load_dependencies();
		$this->load_bracketshortcuts();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_theme_features();
		$this->define_acf();
		$this->define_ajax_function();
	
		
	}

	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-prevent-brackets-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-prevent-brackets-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-prevent-brackets-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-prevent-brackets-public.php';

				/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-prevent-tab.php';

			/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-prevent-theme.php';

		
				/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-load-bracket-shortcut.php';
				/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-prevent-ACF_Onsave.php';
				/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-prevent-ajax.php';
	
	
	

		$this->loader = new Prevent_Brackets_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Prevent_Brackets_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Prevent_Brackets_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	
	private function define_admin_hooks() {

		$plugin_admin = new Prevent_Brackets_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$Bracket_ajax = new Bracket_ajax();
		$this->loader->add_action( 'acf/options_page/save', $Bracket_ajax, 'saveACF', 20);
	
	}


	private function define_public_hooks() {

		$plugin_public = new Prevent_Brackets_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	
		// $expose = new Expose_api(  );
		// $this->loader->add_action( 'rest_api_init', $expose, 'expose_bracket' );
	
	}

	private function define_ajax_function() {
		$template_class = new Bracket_ajax();
		$this->loader->add_action( 'wp_ajax_saveACF', $template_class, 'saveACF' );
		$this->loader->add_action( 'wp_ajax_nopriv_saveACF', $template_class, 'saveACF' );
 }



	private function load_bracketshortcuts() {
		 $template_class = new Bracket_template();
		 $this->loader->add_shortcode( 'bracket_mlb', $template_class, 'load_mlb_template' );
	}


	private function define_theme_features(){
		$theme_features = new Prevent_Brackets_Theme();
		$this->loader->add_action( 'after_setup_theme',  $theme_features, 'theme_supported_features' );
	}

	private function define_acf(){
		define( 'MY_ACF_PATH',  plugin_dir_path( dirname( __FILE__ ) ) . 'includes/acf/' );
		define( 'MY_ACF_URL',  plugin_dir_path( dirname( __FILE__ ) ) . 'includes/acf/' );

		// Include the ACF plugin.
		include_once( MY_ACF_PATH . 'acf.php' );
		// When including the PRO plugin, hide the ACF Updates menu
		add_filter('acf/settings/show_updates', '__return_false', 100);

		// (Optional) Hide the ACF admin menu item.
		//add_filter('acf/settings/show_admin', '__return_false');


	}





	public function run() {
		$this->loader->run();
	}


	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}


	public function get_version() {
		return $this->version;
	}

}
