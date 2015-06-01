<?php


/**
 *
 * MaxFlat helper functions.
 *
 * Provides some helper functions, which are used  in the theme as custom template tags.
 *

 *
 * @since      MaxFlat 1.0
 */


function harmonux_breadcrumb(){
	?>
		<div class="smartlib-breadcrumb">
	   <?php __HARMONUX::layout()->get_the_bredcrumb(); ?>
		</div>
	<?php
}

/**
 * Print logo theme
 *
 * @return mixed
 */
function harmonux_logo(){
   if(is_front_page()){
		 $header_tag = 'h1';
	 }else{
		 $header_tag = 'h4';
	 }
  echo '<'.$header_tag.' class="smartlib-logo-header" itemprop="headline">';
	?>
    <a href="<?php echo  home_url( '/'  ); ?>"
				 title="<?php echo  get_bloginfo( 'name', 'display' ) ; ?>"
				 rel="home"
				 class="smartlib-site-logo <?php echo ( strlen(__HARMONUX::option('project_logo') ) > 0 ) ? 'image-logo' : ''; ?>">
				<?php
				if ( strlen( __HARMONUX::option('project_logo') ) > 0 ) {
                    ?>
                    <img src="<?php echo __HARMONUX::option('project_logo'); ?>"
                         alt="<?php echo bloginfo( 'name' ); ?>" />
                <?php
                }
                else {
                    bloginfo( 'name' );
                }
				?></a>
	<?php
	echo '</'.$header_tag.'>';
}

/**
 * Display Layout header - banner or Site description
 * @return mixed
 */

function harmonux_get_header(){
	return __HARMONUX::layout()->get_site_header();
}

/**
Prints HTML category line
 */
function harmonux_category_line(){
	?>
<span class="smartlib-category-line">
	<?php echo __HARMONUX::layout()->category_line(); ?>
</span>
<?php

}



/**
 * Display pagination on the loop page
 *
 * @param $html_id
 *
 * @return mixed
 */
function harmonux_list_pagination( $html_id){
	return __HARMONUX::layout()->pagination_nav( $html_id);
}

/**
 * Displays navigation to next/previous post on single  page.
 */

function harmonux_prev_next_post_navigation(){
	return __HARMONUX::layout()->single_prev_next();
}


/**
 * Modyfication wp_link_pages() - <!--nextpage--> pagination
 * @return mixed
 */
function harmonux_custom_single_page_pagination(){
	return __HARMONUX::layout()->custom_wp_link_pages();
}

/**
 *
 * Display comment components
 *
 * @param $comment
 * @param $args
 * @param $depth
 *
 * @return mixed
 */
function harmonux_comment_component( $comment, $args, $depth ){
	return __HARMONUX::layout()->comment_component( $comment, $args, $depth );
}

/**
 * Display Date in post loop
 * @return mixed
 */
function harmonux_get_date(){
    return __HARMONUX::layout()->display_date();
}




/**
 * add IE 7 & IE 8 CSS3 Box-sizing support
 *

 *
 */

function harmonux_ie_support()
{

    ?><!--[if IE 7]>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/font/css/font-awesome-ie7.min.css">
<![endif]-->

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php

}

/*
 * Return excerpt with limit
 */
function harmonux_excerpt_max_charlength( $charlength ) {
	$excerpt = get_the_excerpt();
	$charlength ++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex   = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut   = - ( mb_strlen( $exwords[count( $exwords ) - 1] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		}
		else {
			echo $subex;
		}
		echo '...';
	}
	else {
		echo $excerpt;
	}
}



/**
 * Return custom_code_header
 *
 *
 * @return string
 */
function harmonux_option_custom_code_header(){
	__HARMONUX::option( 'custom_code_header');

}

/**
Retrieves project_fixed_top bar option and get fixed class
 */
function get_header_fixed_class(){
	$fixed = __HARMONUX::option( 'project_fixed_topbar' );
   echo $fixed=='1'? ' smartlib-fixed-top-bar':'';
}

/**
 * Display lt ie7 info
 */

function harmonux_lt_ie7_info() {
	?>
<!--[if lt IE 7]>
<p class=chromeframe>Your browser is <em>ancient!</em> Upgrade to a
    different browser.
</p>
<![endif]-->
<?php
}

/**
 * Display search menu
 */
function harmonux_searchmenu() {
	?>
<ul id="top-switches" class="no-bullet right">
	<li>
		<a href="#toggle-search" class="harmonux-toggle-topbar toggle-button button">
			<span class="fa fa-search"></span>
		</a>
	</li>
	<li class="hide-for-large">
		<a href="#top-navigation" class="harmonux-toggle-topbar toggle-button button">
			<span class="fa fa-align-justify"></span>
		</a>
	</li>
</ul>
<?php
}

/**
 * Display search form
 */

function harmonux_searchform() {
	?>
<form action="<?php echo home_url( '/' ); ?>" method="get" role="search" id="smartlib-top-search-container">
	<div class="row">
		<div class="columns large-16">
			<input id="search-input" type="text" name="s"
						 placeholder="<?php _e( 'Search for ...',  __HARMONUX::domain() ); ?>" value="">
			<input class="button" id="top-searchsubmit" type="submit"
						 value="<?php _e( 'Search', __HARMONUX::domain() ); ?>">
		</div>
	</div>

</form>
<?php
}

/*
 *  Add dynamic select menus  for mobile device navigation * *
 *
 * @since Maxflat 1.0
 * @link: http://kopepasah.com/tutorials/creating-dynamic-select-menus-in-wordpress-for-mobile-device-navigation/
 *
 * @param array $args
 *
*/

function  harmonux_mobile_menu($args=array()){



	$defaults = array(
		'theme_location' => '',
		'menu_class'     => 'mobile-menu',
	);

	$args           = wp_parse_args( $args, $defaults );

	$menu_item = __HARMONUX::layout()->wp_nav_menu_select($args);

	if($menu_item){
	?>

	<select id="menu-<?php echo $args['theme_location'] ?>" class="<?php echo $args['menu_class'] ?>">
			<option value=""><?php _e( '- Select -', 'harmonux'); ?></option>
			<?php foreach ( $menu_item as $id => $data ) : ?>
	<?php if ( $data['parent'] == true ) : ?>
		<optgroup label="<?php echo $data['item']->title ?>">
			<option value="<?php echo $data['item']->url ?>"><?php echo $data['item']->title ?></option>
			<?php foreach ( $data['children'] as $id => $child ) : ?>
			<option value="<?php echo $child->url ?>"><?php echo $child->title ?></option>
			<?php endforeach; ?>
		</optgroup>
		<?php else : ?>
		<option value="<?php echo $data['item']->url ?>"><?php echo $data['item']->title ?></option>
		<?php endif; ?>
	<?php endforeach; ?>
		</select>
		<?php
	}else{
		?>
	<select class="menu-not-found">
		<option value=""><?php _e( 'Menu Not Found', 'harmonux'); ?></option>
	</select>
			<?php
	}

}

/**
 * Returns an occurrence of the element at a given position
 */

function check_position_of_component( $component, $side) {
		return __HARMONUX::layout()->check_position_of_component($component, $side);
}

/**
 * Returns the class of the given object
 */

function get_class_of_component( $component ) {
	return __HARMONUX::layout()->get_class_of_component($component);
}


/**
 * Returns the image representing the gallery
 * @param $size
 *
 * @return mixed
 */
function harmonux_featured_image($size= 'full' ) {
	return __HARMONUX::layout()->get_featured_image( $size  );
}


/**
 * Include the category specific template for the content
 */
function harmonux_template_category_loop() {

	$category_id     = get_query_var( 'cat' );
	$category_option = get_option( 'category_' . $category_id );

	$category_template = $category_option['layout'] == 2 ? 'loop-2columns' : 'loop';

  return $category_template;
}


/**
 *
 * Display related posts component
 * @param     $category
 * @param     $post_ID
 * @param     $display_post_limit
 * @param int $columns_per_slide
 *
 * @return mixed
 */

function harmonux_get_related_post_box( $category, $post_ID, $display_post_limit, $columns_per_slide = 4 ) {
	$query =  __HARMONUX::layout()->get_related_post_box($category, $post_ID, $display_post_limit, $columns_per_slide);

	$limit= $query->found_posts;
	if ( $limit != 0) {

		?>
	<section class="smartlib-related-posts">
	    <h3><?php _e( 'Related posts', 'harmonux' ) ?></h3>
			<div class="smartlib-slider-container">
				<ul class="smartlib-slides slider-list slides">
					<?php
					$i = 1;
					$j = 1;
					while ( $query->have_posts() ) {
						$query->the_post();
						$post_format = get_post_format();
						if ( $i == 1 ) {
							?>
								<li class="row">
								<?php
						}
						?>
						<div class="columns large-4">
							<?php
							if ( '' != get_the_post_thumbnail() ) {
								?>

									<a href="<?php the_permalink(); ?>" class="smartlib-thumbnail-outer"
										 title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'harmonux' ), the_title_attribute( 'echo=0' ) ) ); ?>"
											><?php harmonux_get_format_ico($post_format) ?><?php the_post_thumbnail( 'medium-image-thumb' ); ?></a>

								<?php
							}


							?>
							<h4><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
							<?php if ( '' == get_the_post_thumbnail() ) { ?>
						<?php harmonux_display_meta_post('author') ?>
							<?php } ?>
						</div>

						<?php
						if ( $i % $columns_per_slide == 0 || $j == $limit ) {
					   ?>
						</li>
								<?php
							$i = 1;
						}
						else {
							$i ++;
						}

						$j ++;

					}// end while
					
					wp_reset_query();
					?>
				</ul>
			</div>


	</section>
		<?php
		}
}


/**
 * Return awesome icon based on key_class
 *
 * @param $key_class
 */
function harmonux_get_awesome_ico($key_class){
		$class_name = __HARMONUX::layout()->get_awesome_icon_class($key_class);
	  ?>
    <i class="<?php echo $class_name ?>"></i>
		<?php
}

/**
 * Display format (gallery, video) icon
 *
 * @param $key_class
 */
function harmonux_get_format_ico($key_class){
	$class_name = __HARMONUX::layout()->get_awesome_icon_class($key_class);
	$formats_array = __HARMONUX::layout()->get_promoted_formats();
	if(in_array($key_class, $formats_array)){
	?>
		<span class="smartlib-format-ico"><i class="<?php echo $class_name ?>"></i></span>
	<?php
	}

}
/**
 *
 * Display meta line under post title
 *
 * @param string $type author|category|date
 */
function harmonux_display_meta_post($type='author'){
	global $post;
	?>

<p class="meta-line">
       <?php echo harmonux_get_date() ?>
	<?php
	$post_format = get_post_format( $post->ID );

	$speacial_formats = array(
		'gallery', 'video'
	);
	if(in_array($post_format, $speacial_formats )){
		?>
		<span class="meta-label smartlib-postformat-info"><?php harmonux_get_awesome_ico($post_format) ?> <?php echo ucfirst ($post_format) ?></span>
			<?php
	}


		 if ( comments_open() && is_single() ) { ?>
				 <span class="meta-label comment-label"><?php comments_popup_link( __( 'Comment', 'harmonux' ) .'<i class="'.harmonux_get_awesome_ico('comments').'"></i></span>', __( '1 Reply', 'harmonux' ), __( '% Replies', 'harmonux' ) );?></span>
			 <?php
			 }


	if($type=='author'){

	}else if($type=='category'){
		harmonux_category_line();
	}
?>


</p>
		<?php
}
/*
 * Print author line
 */
function harmonux_author_line(){
	?>
<span class="meta-label meta-publisher vcard"><?php _e('Published by: ', 'harmonux') ?> <?php the_author_posts_link(); ?> </span>
		<?php
}

/**
 Prints tag line with HTML
 */
function harmonux_entry_tags(){
	?>
<?php if ( has_tag() ): ?>
	<div class="smartlib-tags-article"> <?php harmonux_get_awesome_ico('tag_icon')?> <?php the_tags( __( 'Tags: ', 'harmonux' ), '  ' ); ?></div>
	<?php endif ?>
		<?php
}

/**
 Prints leave replay button
 */
function harmonux_replay_link(){
	?>
<div class="smartlib-comments-link">
	<?php if ( comments_open() && is_single() ) { ?>
	<?php comments_popup_link( __( 'Comment', 'harmonux' ) .'<i class="'.harmonux_get_awesome_ico('comments').'"></i></span>', __( '1 Reply', 'harmonux' ), __( '% Replies', 'harmonux' ) ); ?>
	<?php } ?>
</div>
		<?php
}



/**
 * Return version of homepage layout
 * 1 - blog + sidebar
 * 2 - classic blog
 *
 * @return mixed
 */
function harmonux_version_homepage(){

	$version = __HARMONUX::option( 'project_homepage_version' );
  if(empty($version)){
		//return default (first value)
		return 1;
	}
	return $version;

}

/**
 * Retrun slider version
 *
 * @return mixed
 */
function harmonux_version_slider(){

	$slider_version = __HARMONUX::option( 'project_homepage_slider' );
	if(empty($slider_version)){
		//return default (first value)
		return 1;
	}
	return $slider_version;

}

/*
 *  Display HomePage Slider
 */
function harmonux_get_homepage_slider(){

	$shortcode_slider = __HARMONUX::option('project_homepage_slider_shortcode');



		if(!empty($shortcode_slider)){
			echo do_shortcode($shortcode_slider);
		}else{
			return false;
		}

}
?>