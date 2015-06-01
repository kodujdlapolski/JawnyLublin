<?php

class Smart_Project_Utils extends Smart_Base_Utils{



	public function __construct($obj_project){
		parent::__construct($obj_project);

		//change excerpt length
		add_filter( 'excerpt_length', array($this,'excerpt_length') );

		add_action('wp_footer', array($this, 'facebook_script'));

		add_action('wp_footer', array($this, 'pinterest_script'));

		//add excerpt to page
		add_action( 'init', array($this, 'add_excerpts_to_pages') );
	}

	public function facebook_script(){
	if( $this->obj_project->get_project_option('social_button_facebook')){
		?>
	<div id="fb-root"></div>
	<script>(function (d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s);
		js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
			<?php
	}

	}

	public function pinterest_script(){
		if( $this->obj_project->get_project_option('social_button_pinterest')){
		wp_enqueue_script('pinterest', '//assets.pinterest.com/js/pinit.js');
		}
	}
	function add_excerpts_to_pages() {

		add_post_type_support( 'page', 'excerpt' );

	}

	/**
	 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
	 *
	 * @since MaxFlat 1.0
	 *
	 */
	function page_menu_args($args)
	{
		if (!isset($args['show_home']))
			$args['show_home'] = true;
		return $args;
	}

	/**
	 *
	 * Static function Writing log to File
	 * @static
	 *
	 * @param $log
	 */
	static function write_log($log){
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}

}
