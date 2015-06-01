<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Google_Maps_Custom
 * @subpackage Google_Maps_Custom/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Google_Maps_Custom
 * @subpackage Google_Maps_Custom/public
 * @author     Your Name <email@example.com>
 */
class Google_Maps_Custom_Public {

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
	 * @var      string    $Google_Maps_Custom       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $Google_Maps_Custom, $version ) {

		$this->Google_Maps_Custom = $Google_Maps_Custom;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Google_Maps_Custom_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Google_Maps_Custom_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Google_Maps_Custom, plugin_dir_url( __FILE__ ) . 'css/plugin-name-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Google_Maps_Custom_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Google_Maps_Custom_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        wp_enqueue_script( 'gmcpt-maps-api', 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=drawing', array( 'jquery' ) );
        wp_register_script( 'gmcpt-maps-areas', plugin_dir_url( __FILE__ ). '/js/gmcpt-public.js', array('gmcpt-maps-api') );
        wp_localize_script( 'gmcpt-maps-areas', 'gmcpt_maps_areas', $this->gmcpt_localize_script_areas_data() );
        wp_enqueue_script( 'gmcpt-maps-areas' );
		//wp_enqueue_script( 'gmcpt-maps-areas', plugin_dir_url( __FILE__ ) . 'js/gmcpt-public.js', array( 'jquery' ), $this->version, false );

	}

    public function get_all_points(){
        ?>
        <div id="gmcpt_map" style="height: 500px"></div>
            <?php
    }

    function gmcpt_localize_script_areas_data(){

	global $wp_query;
	global $post;
         $queried_object = $term = get_queried_object();


				//prepare tax query
     if(isset($queried_object->slug)){
				$tax_query = array(
					array(
						'taxonomy' => 'gmcpt-rok',
						'field'    => 'slug',
						'terms'    => $queried_object->slug
					)
				);

				if ( isset( $_POST['gmcpt-kategoria-form'] ) ) {
					$tax = $_POST['gmcpt-kategoria-form'];
				}
				elseif ( isset( $_COOKIE['gmcpt-kategoria-form'] ) ) {
					$tax = $_COOKIE['gmcpt-kategoria-form'];
				}

				if ( ! empty( $tax ) ) {
					$tax_query = array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'gmcpt-kategoria',
							'field'    => 'slug',
							'terms'    => $tax
						),
						array(
							'taxonomy' => 'gmcpt-rok',
							'field'    => 'slug',
							'terms'    => $term->slug
						)
					);

				}


        $args = array(
            'post_type' => 'gmcpt_post',
            'posts_per_page' => 1000,
            'tax_query'      => $tax_query,
        );

        $areas_posts = new WP_Query($args);

        $areas_content = array();

        $i=0;
        while($areas_posts->have_posts()): $areas_posts->the_post();
					      $areas_content[$i]['area_id'] = $post->ID;
                $areas_content[$i]['area_name'] = get_the_title();
                $areas_content[$i]['area_content'] = get_the_content();
                $areas_content[$i]['area_points'] = json_decode(get_post_meta( $post->ID, 'gmcpt_lat', true ));
                $i++;
        endwhile;




  if(is_archive()&& count($areas_posts)>0){
            return json_encode($areas_content);

	}
		 }
}

}
