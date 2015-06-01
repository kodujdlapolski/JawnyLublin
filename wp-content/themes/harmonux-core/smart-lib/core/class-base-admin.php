<?php

class Smart_Base_Admin{

	public $admin_enqueue_scripts;
	public $admin_enqueue_styles;
  public $shortcodes_list = array();
  public $style_cache=0;
	public $script_cache=0;

	protected static function add_nonce($action){
   // Add an nonce field so we can check for it later.
		wp_nonce_field( $action, $action.'_nonce' );
	}
	/**
	 * @static
	 *
	 * @param $post_id The ID of the post being saved.
	 * @param $action - action name
	 *
	 * @return mixed
	 */
	protected static function save_extrafield_nonce($post_id, $action){
// Check if our nonce is set.
		if ( ! isset( $_POST[$action.'_nonce'] ) ) {
			return $post_id;
		}
		$nonce = $_POST[$action.'_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, $action ) ) {
			return $post_id;
		}
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
	}

	function __construct(){

	}
	/*repaeat wp_enqueue_script*/

	public function admin_enqueue_scripts() {

		if ( count( $this->admin_enqueue_scripts ) > 0 ) {


			foreach ( $this->admin_enqueue_scripts as $key=> $row ) {

				/*default dependency array*/
				if ( isset( $row['deps'] ) )
					$deps_array = $row['deps'];
				else
					$deps_array = array();

				/*default version*/
				if ( $this->script_cache ) {
					if ( isset( $row['version'] ) )
						$version = $row['version'];
					else
						$version = '1.0';
				}
				else {
					$version = filemtime( SMART_ADMIN_DIRECTORY . $row['path'] );
				}

				/*in footer default*/
				if ( isset( $row['in_footer'] ))
					$in_footer = $row['in_footer'];
				else
					$in_footer = false;

				if(substr($row['path'], 0, 5)=='http:' || substr($row['path'], 0, 6)=='https:'){
					$path = $row['path'];
				}else{
					$path = SMART_ADMIN_DIRECTORY_URI . $row['path'];
				}
				wp_enqueue_script( $key, $path, $deps_array, $version, $in_footer );

			}
		}

	}

	/*repaeat wp_enqueue_script*/

	public function admin_enqueue_styles() {

		if ( count( $this->admin_enqueue_styles ) > 0 ) {


			foreach ( $this->admin_enqueue_styles as $key=> $row ) {

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
					$version = filemtime( SMART_ADMIN_DIRECTORY . $row['path'] );
				}

				/*in footer default*/
				if ( isset( $row['media'] ) )
					$media = $row['media'];
				else
					$media = 'all';

				if(substr($row['path'], 0, 5)=='http:' || substr($row['path'], 0, 6)=='https:'){
					$path = $row['path'];
				}else{
					$path = SMART_ADMIN_DIRECTORY_URI . $row['path'];
				}

				wp_enqueue_style( $key, $path, $deps_array, $version, $media );

			}
		}

	}

}