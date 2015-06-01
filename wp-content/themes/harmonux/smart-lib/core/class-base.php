<?php

/*Project specific class*/
class  Smart_Base {

	public $script_cache=0;
	public $style_cache=0;
	public static $project_domain ='';
	public $base_sidebars=array();
  public $project_enqueue_scripts;
	public $project_enqueue_styles;
	public $project_register_styles;
  public $project_register_scripts;


	public $site_enqueue_scripts = array(
		'foundation'      => array(
			'path'     => '/js/foundation/foundation.js',
			'deps'     => array( 'jquery' ),
			'version'  => '1.0',
			'in_footer'=> false
		),




		'smartlib-photoswipe-lib' => array(
			'path'     => '/js/photoswipe/lib/klass.min.js',
			'deps'     => array( 'jquery' ),
			'version'  => '1.0',
			'in_footer'=> false
		),
		'smartlib-photoswipe'     => array(
			'path'     => '/js/photoswipe/code.photoswipe.jquery-3.0.5.min.js',
			'deps'     => array( 'jquery' ),
			'version'  => '1.0',
			'in_footer'=> false
		),


	);

	public $site_enqueue_styles = array(

		'smartlib-foundation'      => array(
				'path'     => '/css/foundation.css',

			),
		'smartlib-font-icon'           => array(
					'path'     => '/font/css/font-awesome.min.css'

		),
		'smartlib-photoswipe-css'      => array(
			'path'     => '/css/photoswipe/photoswipe.css',
			'deps'     => array('smartlib-foundation')
		)
	);

	public $site_register_scripts = array(
		'pinterest'      => array(
		'path'     => '//assets.pinterest.com/js/pinit.js',
		),
	);


	public $site_register_styles = array(

	);
	/*setting initialization*/

	public function __construct() {

		//Merge array style & scripts
		$this->site_enqueue_scripts = array_merge($this->site_enqueue_scripts, $this->project_enqueue_scripts);
		$this->site_enqueue_styles = array_merge($this->site_enqueue_styles, $this->project_enqueue_styles);
		//merge register styles & scripts
		$this->site_register_scripts = array_merge($this->site_register_scripts, $this->project_register_scripts);
		$this->site_register_styles = array_merge($this->site_register_styles, $this->project_register_styles);
	}

	/*repaeat wp_enqueue_script*/

	public function site_enqueue_scripts() {


			$scripts_array['enqueue'] = $this->site_enqueue_scripts;


	  	$scripts_array['register'] = $this->site_register_scripts;

	foreach($scripts_array as $type_include => $scripts){

		if ( count( $scripts ) > 0 ) {


			foreach ( $scripts as $key=> $row ) {


				/*default dependency array*/
				if ( isset( $row['deps'] ) )
					$deps_array = $row['deps'];
				else
					$deps_array = array();

				/*default version*/
				if ( $this->script_cache ==0) {
					if ( isset( $row['version'] ) )
						$version = $row['version'];
					else
						$version = '1.0';
				}
				else {
					$version = rand(0,300);
				}

				/*in footer default*/
				if ( isset( $row['in_footer'] ))
										$in_footer = $row['in_footer'];
									else
										$in_footer = false;

				if(substr($row['path'], 0, 2)=='//' || substr($row['path'], 5, 2)=='//' || substr($row['path'], 6, 2)=='//'){
					$path = $row['path'];
				}else{
					$path = SMART_TEMPLATE_DIRECTORY_URI . $row['path'];
				}

				if($type_include=='register'){

					wp_register_script( $key, $path, $deps_array, $version, $in_footer );

				}else{

					wp_enqueue_script( $key, $path, $deps_array, $version, $in_footer );

				}

			}
			}
	}

	}

	/*repaeat wp_enqueue_script*/

		public function site_enqueue_styles() {

			if ( count( $this->site_enqueue_styles ) > 0 ) {


				foreach ( $this->site_enqueue_styles as $key=> $row ) {

					/*default dependency array*/
					if ( isset( $row['deps'] ) )
						$deps_array = $row['deps'];
					else
						$deps_array = array();

					/*default version*/
					if ( $this->style_cache ) {
						if ( isset( $row['version'] ) )
							$version = $row['version'];
						else
						  $version = '1.0';
					}
					else {
						$version = filemtime( SMART_TEMPLATE_DIRECTORY . $row['path'] );
					}

					/*in footer default*/
					if ( isset( $row['media'] ) )
											$media = $row['media'];
										else
											$media = 'all';

					if(substr($row['path'], 0, 5)=='http:' || substr($row['path'], 0, 6)=='https:'){
						$path = $row['path'];
					}else{
						$path = SMART_TEMPLATE_DIRECTORY_URI . $row['path'];
					}

					wp_enqueue_style( $key, $path, $deps_array, $version, $media );

				}
			}

		}


}