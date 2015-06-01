<?php



class Smart_Project_Base extends Smart_Base {

	public static $project_domain = 'harmonux';
	public $project_prefix = 'harmonux';
	public $obj_widgets = array();
	public $obj_admin_utils;
	public $obj_layout;
	public $obj_utils; //contain project utils
	public $project_options = array();
	public $excerpt_length = 150; //excertp length
	public $customize_messenger_channel = 0; //customizer preview flag (from POST array)


	public $plugin_territory = false; // plugin territory flag

	public $project_enqueue_scripts = array(


		'foundation-min'            => array(
			'path'     => '/js/foundation.min.js',
			'deps'     => array( 'jquery' ),
			'version'  => '1.0',
			'in_footer'=> false
		),

		'select-menu'               => array(
			'path'     => '/js/mobile-menu.js',
			'deps'     => array( 'jquery' ),
			'version'  => '1.0',
			'in_footer'=> false
		),
		'responsive-table'               => array(
			'path'     => '/js/responsive-tables.js',
			'deps'     => array( 'jquery' ),
			'version'  => '1.0',
			'in_footer'=> false
		),

		'flex-slider' => array(
			'path'     => '/js/flexslider/jquery.flexslider-min.js',
			'deps'     => array( 'jquery' ),
			'version'  => '1.0',
			'in_footer'=> false
		),

		'smartlib-main'           => array(
			'path'     => '/js/main.js',
			'deps'     => array( 'jquery' ),
			'version'  => '1.0',
			'in_footer'=> false
		),

	);

	public $project_enqueue_styles = array(

		'harmonux-flexslider'           => array(
			'path'     => '/css/flexslider/flexslider.css',

		),
		'harmonux-responsive-tables'           => array(
			'path'     => '/css/responsive-tables.css',

		),

		'smartlib-structure'           => array(
			'path'     => '/style.css',
			'deps'     => array( 'smartlib-foundation' )
		),
	);

	public $project_register_styles = array(

		'smartlib-structure'           => array(
			'path'     => '/style.css',
			'deps'     => array( 'smartlib-foundation' )
		),
	);

	/*
	 * Array of files Used in certain places
	 */
	public $project_register_scripts = array(

		'gplus_script'           => array(
			'path'     => 'https://apis.google.com/js/plusone.js',

		),
	);

	/*define project sidebars*/
	public $project_sidebars = array(
		'sidebar-1' => array(

			'name'          => 'Main Sidebar',
			'description'   => 'Appears on  Front Page',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		),
		'sidebar-4' => array(
			'name'          => 'HarmonUX: Category Page Sidebar',
			'description'   => 'Appears on Category page',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>'
		),
		'sidebar-5' => array(
			'name'          => 'HarmonUX: Single Page Sidebar',
			'description'   => 'Appears on Single page',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>'
		),
		'sidebar-2' => array(
			'name'          => 'Appears on Frontpage in the footer',
			'description'   => 'HarmonUX: Footer Front Page Widget Area',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '<hr /></li>',
			'before_title'  => '<h3 class="widget-title"><em>',
			'after_title'   => '</em></h3>'
		),
		'sidebar-3' => array(
			'name'          => 'HarmonUX: Footer Single Page Widget Area',
			'description'   => 'Appear on a Single Page in the footer',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '<hr /></li>',
			'before_title'  => '<h3 class="widget-title"><em>',
			'after_title'   => '</em></h3>'
		)


	);

	public $project_widgets = array(
		'Smart_Widget_Recent_Posts',
		'Smart_Widget_One_Author',
		'Smart_Widget_Social_Icons',
		'Smart_Widget_Video',
		'Smart_Widget_Recent_Videos',
		'Smart_Widget_Search',
		'Smart_Widget_Recent_Galleries'
	);


	public function __construct() {

		parent::__construct();

		$this->project_options = get_option( $this->project_prefix . '_theme_options' );

		//add scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'site_enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'site_enqueue_styles' ) );

		//register scripts
		add_action( 'wp_register_scripts', array( $this, 'site_enqueue_scripts' ), true );
		add_action( 'wp_register_scripts', array( $this, 'site_enqueue_styles' ), true );

		//Initialize layout
		$this->obj_layout = new Smart_Project_Layout( $this );


		//Initialize admin object
		$this->obj_admin_utils = new Smart_Project_Admin_Utils( $this );

		//get customizer preview flag
		if ( isset( $_POST['customize_messenger_channel'] ) && $_POST['customize_messenger_channel'] != 'preview-0' ) {
			$this->customize_messenger_channel = 1;
		}


	}

	/**
	 * Get project option depend on $this->customize_messenger_channel (customizer flag) value
	 *
	 * @param $key_option
	 *
	 * @return bool
	 */
	public function get_project_option( $key_option ) {

		//get from cache array if is not customizer preview
		if ( $this->customize_messenger_channel == 0 ) {

			return isset( $this->project_options[$key_option] ) ? $this->project_options[$key_option] : false;

		}
		else {

			$option = get_option( $this->project_prefix . '_theme_options' );

			return isset( $option[$key_option] ) ? $option[$key_option] : false;
		}

	}

	/**
	 * Return Project Domain
	 *
	 * @static
	 * @return string
	 */
	public static function get_project_domain() {
		return self::$project_domain;
	}
}


