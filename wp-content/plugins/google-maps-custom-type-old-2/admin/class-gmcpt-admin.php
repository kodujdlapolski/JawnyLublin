<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Google_Maps_Custom
 * @subpackage Google_Maps_Custom/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Google_Maps_Custom
 * @subpackage Google_Maps_Custom/admin
 * @author     Your Name <email@example.com>
 */
class Google_Maps_Custom_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Google_Maps_Custom    The ID of this plugin.
	 */
	private $Google_Maps_Custom;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $Google_Maps_Custom       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */

	public $post_type_name;
	public $taxonomy_name;

	public function __construct( $Google_Maps_Custom, $version ) {

		$this->Google_Maps_Custom = $Google_Maps_Custom;
		$this->version = $version;

		$this->post_type_name = 'gmcpt_post';
		$this->taxonomy_name = 'gmcpt_category';

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Google_Maps_Custom_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Google_Maps_Custom_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Google_Maps_Custom, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Google_Maps_Custom_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Google_Maps_Custom_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->Google_Maps_Custom.'_maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=drawing',  array( 'jquery' ));

		wp_enqueue_script( $this->Google_Maps_Custom, plugin_dir_url( __FILE__ ) . 'js/gmcpt-admin.js', array( 'jquery' ), $this->version, false );




	}

	/* Fire our meta box setup function on the post editor screen. */

	/*add metaboxes */

	function post_meta_boxes_setup() {

		/* Add meta boxes on the 'add_meta_boxes' hook. */
		add_action( 'add_meta_boxes', array($this, 'add_post_meta_boxes') );
		add_action( 'save_post', array($this,'save_maps_meta'), 10, 2 );
	}

	function add_post_meta_boxes(){


		add_meta_box(
			'suma-post-class',      // Unique ID
			 esc_html__( 'Edytuj Mapę', 'harmonux' ),    // Title
			array($this,'maps_meta_box'),   // Callback function
			$this->post_type_name,         // Admin page (or post type)
			'advanced',         // Context
			'default'         // Priority
		);
	}

	function maps_meta_box($object, $box){
		?>
  <div id="gmcpt_map" style="width: 800px; height: 400px"></div>
        <div id="poly_line_list"></div>
	<?php wp_nonce_field( basename( __FILE__ ), 'gmcpt_lat_nonce' ); ?>

	<p>
		<label for="gmcpt_lat"><?php _e( "Szerokość", 'harmonux' ); ?></label>
		<input class="widefat" type="text" name="gmcpt_lat" id="gmcpt_lat" value="<?php echo esc_attr( get_post_meta( $object->ID, 'gmcpt_lat', true ) ); ?>" size="30" />
	</p>

	<p>
		<label for="gmcpt_long"><?php _e( "Długość", 'harmonux' ); ?></label>
		<input class="widefat" type="text" name="gmcpt_long" id="gmcpt_long" value="<?php echo esc_attr( get_post_meta( $object->ID, 'gmcpt_long', true ) ); ?>" size="30" />
	</p>
	<?php
	}

	/* Save the meta box's post metadata. */
	function save_maps_meta( $post_id, $post ) {

		/* Verify the nonce before proceeding. */
		if ( !isset( $_POST['gmcpt_lat'] ) || !wp_verify_nonce( $_POST['gmcpt_lat_nonce'], basename( __FILE__ ) ) )
			return $post_id;

		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );

		/* Check if the current user has permission to edit the post. */
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
			return $post_id;

		/* Get the posted data and sanitize it for use as an HTML class. */
		$new_gmcpt_lat = ( isset( $_POST['gmcpt_lat'] ) ?  $_POST['gmcpt_lat']  : '' );
		$new_gmcpt_long = ( isset( $_POST['gmcpt_long'] ) ?  $_POST['gmcpt_long']  : '' );



		/* Get the meta value of the custom field key. */

		$gmcpt_lat = get_post_meta( $post_id, 'gmcpt_lat', true );
		$gmcpt_long = get_post_meta( $post_id, 'gmcpt_long', true );


		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_gmcpt_lat && '' == $gmcpt_lat )
			add_post_meta( $post_id, 'gmcpt_lat', $new_gmcpt_lat, true );
		/* If the new meta value does not match the old value, update it. */
		elseif ( $new_gmcpt_lat && $new_gmcpt_lat != $gmcpt_lat )
			update_post_meta( $post_id, 'gmcpt_lat', $new_gmcpt_lat );
		elseif ( '' == $new_gmcpt_lat && $gmcpt_lat )
			delete_post_meta( $post_id, 'gmcpt_lat', $gmcpt_lat );

		if ( $new_gmcpt_long && '' == $gmcpt_long  )
			add_post_meta( $post_id, 'gmcpt_long', $new_gmcpt_lat, true );
		elseif ( $new_gmcpt_long && $new_gmcpt_long != $gmcpt_long )
			update_post_meta( $post_id, 'gmcpt_long', $new_gmcpt_long );
		elseif ( $new_gmcpt_long && $new_gmcpt_long != $gmcpt_long )
			update_post_meta( $post_id, 'gmcpt_long', $new_gmcpt_long );

		/* If there is no new meta value but an old value exists, delete it. */

	}

}
