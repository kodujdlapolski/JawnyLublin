<?php

class Smart_Theme_Widgets{

  public $obj_project; //base project class object


	public $default_widget_params = array(
		'name'                    => '',
	                                    'id'                      => '',
	                                    'description'             => '',
	                                    'class'                   => '',
	                                    'before_widget'           => '<li id="%1$s" class="widget %2$s">',
	                                    'after_widget'            => '</li>',
	                                    'before_title'            => '<h3 class="widget-title">',
	                                    'after_title'             => '</h3>',
  );


	public $default_widget_list=array();

	function __construct($obj_project){

		$this->obj_project = $obj_project;
		$this->default_widget_list = $this->obj_project->project_widgets;

		add_action( 'widgets_init', array($this, 'register_theme_sidebars'));
		add_action( 'widgets_init', array($this, 'register_theme_widgets'));

	}

	/**
  Register theme sidebars
	 *
	 * @since 0.5
	 */

	public function register_theme_sidebars(){

	$sidebar = array();

  foreach ( $this->obj_project->project_sidebars as $id => $row) {
           foreach ( $this->default_widget_params as $key => $default_value ) {
             if ('id' == $key ) {
               $sidebar[$key] = $id;
             }
             else if ( 'name' == $key || 'description' == $key) {
							 $sidebar[$key] = !isset($row[$key]) ? $default_value : call_user_func( '__' ,$row[$key], $this->obj_project->project_domain);
             }
             else {
							 $sidebar[$key] = !isset($row[$key]) ? $default_value : $row[$key];
             }
           }

         //registers project sidebars
         register_sidebar($sidebar);


       }

     }

	/**
   Register all widgets class from array
	 *
	 * @since 0.5
	 */
	public function register_theme_widgets(){

		if(count($this->default_widget_list)>0){
			foreach($this->default_widget_list as $widget_class){
				if(class_exists($widget_class) ){
					 register_widget($widget_class);
				}
			}
		}
	}
}
 
