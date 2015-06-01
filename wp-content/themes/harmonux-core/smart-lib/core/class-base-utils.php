<?php

class Smart_Base_Utils{

	public $obj_project;
	public static $project_domain;
	function __construct($project){
		$this->obj_project = $project;
    self::$project_domain = $this->obj_project->get_project_domain();

		add_filter('wp_title', array($this, 'harmonux_wp_title') , '10', '2');
		//add custom code - header
		add_action('wp_head', array($this, 'custom_code_header'));
		//add custom code - footer
		add_action('wp_footer', array($this, 'custom_code_footer'));

		//add favicon
		add_action ( 'wp_head', array($this,'display_favicon') );



		add_filter('the_category', array($this,'replace_cat_tag'));
	}

	/**
	 * Return title tag content
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep   Optional separator.
	 *
	 * @return string Filtered title.
	 */
	function harmonux_wp_title($title, $sep)
	{
	    global $paged, $page;

	    if (is_feed())
	        return $title;

	    // Add the site name.
	    $title .= get_bloginfo('name');

	    // Add the site description for the home/front page.
	    $site_description = get_bloginfo('description', 'display');
	    if ($site_description && (is_home() || is_front_page()))
	        $title = "$title $sep $site_description";

	    // Add a page number if necessary.
	    if ($paged >= 2 || $page >= 2)
	        $title = "$title $sep " . sprintf(__('Page %s', 'harmonux'), max($paged, $page));

	    return $title;
	}

	/**
	 * Display custom code form header
	 */

	public function custom_code_header(){
		$code = $this->obj_project->get_project_option('custom_code_header');
		if(strlen($code)>0){
			echo $code;
		}
	}


	  /**
		 * Display custom code form footer
		 */

		public function custom_code_footer(){
			$code = $this->obj_project->get_project_option('custom_code_footer');
			if(strlen($code)>0){
				echo $code;
			}
		}

	/**
	 * W3C validation - fix the rel=”category tag”
	 *

	 */

	function replace_cat_tag($text)
	{
		$text = str_replace('rel="category tag"', "", $text);
		return $text;
	}

	/**
	 * Display favicon
	 */
	public function display_favicon() {
		$favico = $this->obj_project->get_project_option( 'project_favicon' );
		if ( ! empty( $favico ) ) {
			$extension = substr( $favico, strrpos( $favico, '.' )+1, 3 );
			?>
		<link rel="icon" type="image/<?php echo $extension ?>" href="<?php echo $favico ?>" />
		<?php
		}
	}

	/**
	 * Change category length
	 * @param $length
	 *
	 * @return mixed
	 */
	public function excerpt_length( $length ) {
		return $this->obj_project->excerpt_length;
	}


}