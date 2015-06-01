<?php

class Smart_Project_Admin_Utils extends Smart_Base_Admin{

	public $obj_project;
	public $admin_domain;

	//customizer variables
	public $customizer_project;
	public $customizer_key = 'harmonux';//usually the same as the name of the project
	public $customizer_option_key = 'smartlib_theme_options';
	public $project_prefix;
	public $plugin_territory;
	public $extend_project_admin = null; //Extended class variable
	public $admin_enqueue_scripts = array(

		'admin-form-scroll'  => array(
			'path'     => '/js/noUislider/jquery.nouislider.min.js',
			'deps'     => array( 'jquery' ),
			'version'  => '1.0',
			'in_footer'=> false
		),
		'customize-script'  => array(
			'path'     => '/js/customize-script.js',
			'deps'     => array( 'jquery' ),
			'version'  => '1.0',
			'in_footer'=> false
		),
	);


	public $admin_enqueue_styles = array(
		'admin-form-css'           => array(
			'path'     => '/css/css-admin-mod.css',

		),
		'noUiSlider'           => array(
			'path'     => '/css/noUislider/nouislider.fox.css',

		),
	);



	public function __construct($obj_project){

		$this->obj_project =$obj_project;

		//get admin panel domain

    $this->project_prefix = $this->obj_project->project_prefix;
		$this->plugin_territory = $this->obj_project->plugin_territory;

		//add admin scripts
		add_action ( 'admin_enqueue_scripts'						, array( $this , 'admin_enqueue_scripts' ) );
		add_action ( 'admin_print_styles'						, array( $this , 'admin_enqueue_styles' ) );

		//add customizer script
		add_action( 'customize_controls_print_styles', array( $this , 'admin_enqueue_scripts' ) );
		add_action( 'customize_controls_print_styles', array( $this , 'admin_enqueue_styles' ) );

    //add customizer to admin menu
		add_action( 'admin_menu', array($this,'project_add_customize_to_admin_menu') );

		/**
		 * CUSTOMIZER OBJECT AND ACTIONS
		 */

		//pass admin object to the constructor
		$this->customizer_project = new Smart_Project_Customizer($this);

		//Setup the Theme Customizer settings and controls
		add_action( 'customize_register', array( $this->customizer_project, 'register' ) );

		//Output custom CSS to live site
		add_action( 'wp_head', array( $this->customizer_project, 'header_output' ) );

		//Enqueue live preview javascript in Theme Customizer admin screen
		add_action( 'customize_preview_init', array( $this->customizer_project, 'customize_preview_js' ) );

    //additional admin stylesheet - new components styles
		add_action( 'admin_print_styles', array($this,'admin_area_enqueue_styles') );
		/**
		 * Plugin Territory Section
		 *
		 */

		if($this->plugin_territory){

			/*external object with most of plugin territory functionality*/
			$this->extend_project_admin = new Smart_Extend_Project_Admin($this->obj_project);
		}


	}





	/**
 add Customize page to admin menu
	 */
	function project_add_customize_to_admin_menu() {
		add_theme_page( __( 'Customize', 'harmonux'), 'Customize', 'edit_theme_options', 'customize.php' );
	}

	function admin_area_enqueue_styles(){
		wp_enqueue_style( 'admin_area_enqueue_styles', SMART_ADMIN_DIRECTORY_URI.'/css/css-admin-mod.css', array(), '1.0', false );
	}



}