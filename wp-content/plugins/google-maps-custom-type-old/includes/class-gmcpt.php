<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Google_Maps_Custom
 * @subpackage Google_Maps_Custom/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Google_Maps_Custom
 * @subpackage Google_Maps_Custom/includes
 * @author     Your Name <email@example.com>
 */
class Google_Maps_Custom {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Google_Maps_Custom_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $Google_Maps_Custom    The string used to uniquely identify this plugin.
	 */
	protected $Google_Maps_Custom;

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
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */

	public $post_type_name;
	public $taxonomy_name;



	public function __construct() {

		$this->Google_Maps_Custom = 'google-maps-custom';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		$this->post_type_name = 'gmcpt_post';
		$this->taxonomy_name = 'gmcpt_category';

		add_action( 'init', array($this,'add_google_maps_postype') );

		add_action( 'init', array($this, 'add_google_maps_taxonomy') );

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Google_Maps_Custom_Loader. Orchestrates the hooks of the plugin.
	 * - Google_Maps_Custom_i18n. Defines internationalization functionality.
	 * - Google_Maps_Custom_Admin. Defines all hooks for the dashboard.
	 * - Google_Maps_Custom_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gmcpt-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gmcpt-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-gmcpt-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-gmcpt-public.php';

		$this->loader = new Google_Maps_Custom_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Google_Maps_Custom_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Google_Maps_Custom_i18n();
		$plugin_i18n->set_domain( $this->get_Google_Maps_Custom() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );



	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Google_Maps_Custom_Admin( $this->get_Google_Maps_Custom(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'load-post.php',  $plugin_admin, 'post_meta_boxes_setup' );
		$this->loader->add_action( 'load-post-new.php',  $plugin_admin, 'post_meta_boxes_setup' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Google_Maps_Custom_Public( $this->get_Google_Maps_Custom(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_Google_Maps_Custom() {
		return $this->Google_Maps_Custom;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Google_Maps_Custom_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function add_google_maps_postype(){
		register_post_type( $this->post_type_name,
			array(
				'labels' => array(
					'name' => __( 'Miejsca' ),
					'singular_name' => __( 'Miejsce' )
				),
				'public' => true,
				'has_archive' => false,
				'hierarchical' => true,
				'rewrite' => array('slug' => 'gmcpt'),
				'taxonomies' => array('year'),
				'supports' => array('title', 'editor', 'thumbnail' , 'page-attributes'  )
			)
		);
	}

	public function add_google_maps_taxonomy() {
		// create a new taxonomy
		register_taxonomy(
			$this->taxonomy_name,
			$this->post_type_name,
			array(
				'label' => __( 'Kategoria' ),
				'rewrite' => array( 'slug' => 'gmcpt-category' ),
				'hierarchical' => true
			)
		);
	}

}
