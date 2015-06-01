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


function smartlib_breadcrumb(){
	?>
		<div class="smartlib-breadcrumb">
	   <?php __SMARTLIB::layout()->get_the_bredcrumb(); ?>
		</div>
	<?php
}

/**
 * Print logo theme
 *
 * @return mixed
 */
function smartlib_logo(){
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
				 class="smartlib-site-logo <?php echo ( strlen(__SMARTLIB::option('project_logo') ) > 0 ) ? 'image-logo' : ''; ?>"><img src="<?php echo get_template_directory_uri() ?>/images/logo.png" alt="<?php echo  get_bloginfo( 'name', 'display' ) ; ?>" />
				</a>
	<?php
	echo '</'.$header_tag.'>';
}

/**
 * Display Layout header - banner or Site description
 * @return mixed
 */

function smartlib_get_header(){
	return __SMARTLIB::layout()->get_site_header();
}

/**
Prints HTML category line
 */
function smartlib_category_line(){
	?>
<span class="smartlib-category-line">
	<?php echo __SMARTLIB::layout()->category_line(); ?>
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
function smartlib_list_pagination( $html_id){
	return __SMARTLIB::layout()->pagination_nav( $html_id);
}

/**
 * Displays navigation to next/previous post on single  page.
 */

function smartlib_prev_next_post_navigation(){
	return __SMARTLIB::layout()->single_prev_next();
}


/**
 * Modyfication wp_link_pages() - <!--nextpage--> pagination
 * @return mixed
 */
function smartlib_custom_single_page_pagination(){
	return __SMARTLIB::layout()->custom_wp_link_pages();
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
function smartlib_comment_component( $comment, $args, $depth ){
	return __SMARTLIB::layout()->comment_component( $comment, $args, $depth );
}

/**
 * Display Date in post loop
 * @return mixed
 */
function smartlib_get_date(){
    return __SMARTLIB::layout()->display_date();
}


function smartlib_social_buttons(){

	$social_buttons_array = __SMARTLIB::layout()->prepare_social_buttons();
	?>
	<ul class="no-bullet smartlib-soical-widgets">
		<?php
		if ( isset($social_buttons_array['facebook']) && $social_buttons_array['facebook'] ) {
			?>
		<li>
			<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="box_count"
					 data-width="60" data-show-faces="false"></div>
		</li>
		<?php
		}

		if ( isset($social_buttons_array['gplus']) && $social_buttons_array['gplus'] ) {

			?>
		<li>
			<g:plusone size="tall"></g:plusone>
		</li>
		<?php
		}

		if ( isset($social_buttons_array['twiter']) && $social_buttons_array['twiter'] ) {
			?>
		<li>
			<a href="https://twitter.com/share" style="width:50px" class="twitter-share-button" data-count="vertical"
				 data-dnt="true">Tweet</a>
			<script>!function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (!d.getElementById(id)) {
					js = d.createElement(s);
					js.id = id;
					js.src = "//platform.twitter.com/widgets.js";
					fjs.parentNode.insertBefore(js, fjs);
				}
			}(document, "script", "twitter-wjs");</script>
		</li>
		<?php
		}
		if ( isset($social_buttons_array['pinterest']) && $social_buttons_array['pinterest'] ) {
			?>
		<li class="pinterest-button">
			<a data-pin-config="above" href="//pinterest.com/pin/create/button/" data-pin-do="buttonBookmark"><img
					src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>
		</li>
		<?php
		}
		?>
</ul>
<?php
}

/**
 * add IE 7 & IE 8 CSS3 Box-sizing support
 *
 * @since MaxFlat 1.0
 *
 */

function smartlib_ie_support()
{

    ?><!--[if IE 7]>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/font/css/font-awesome-ie7.min.css">
<![endif]-->
<!--[if IE 7]>
<style>
    * {
    * behavior : url (<?php echo get_template_directory_uri(); ?>/js/boxsize-fix.htc );
    }
</style>
<![endif]-->
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php

}

/*
 * Return excerpt with limit
 */
function smartlib_excerpt_max_charlength( $charlength ) {
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
function smartlib_option_custom_code_header(){
	__SMARTLIB::option( 'custom_code_header');

}

/**
Retrieves project_fixed_top bar option and get fixed class
 */
function get_header_fixed_class(){
	$fixed = __SMARTLIB::option( 'project_fixed_topbar' );
   echo $fixed=='1'? ' smartlib-fixed-top-bar':'';
}

/**
 * Display lt ie7 info
 */

function smartlib_lt_ie7_info() {
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
function smartlib_searchmenu() {
	?>
<ul id="top-switches" class="no-bullet right">
	<li>
		<a href="#toggle-search" class="harmonux-toggle-topbar toggle-button button">
			<img src="<?php echo get_template_directory_uri() ?>/images/lupa.png" alt="search" />
		</a>
	</li>
	<li>
		<a href="https://www.facebook.com/FundacjaWolnosci" target="_blank" class="button btn-facebook">
			<span class="fa fa-facebook"></span>
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

function smartlib_searchform() {
	?>
<form action="<?php echo home_url( '/' ); ?>" method="get" role="search" id="smartlib-top-search-container">
	<div class="row">
		<div class="columns large-16">
			<input id="search-input" type="text" name="s"
						 placeholder="<?php _e( 'Szukana fraza ...',  __SMARTLIB::domain() ); ?>" value="">
			<input class="button" id="top-searchsubmit" type="submit"
						 value="<?php _e( 'Szukaj', __SMARTLIB::domain() ); ?>">
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

function  smartlib_mobile_menu($args=array()){



	$defaults = array(
		'theme_location' => '',
		'menu_class'     => 'mobile-menu',
	);

	$args           = wp_parse_args( $args, $defaults );

	$menu_item = __SMARTLIB::layout()->wp_nav_menu_select($args);

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
		return __SMARTLIB::layout()->check_position_of_component($component, $side);
}

/**
 * Returns the class of the given object
 */

function get_class_of_component( $component ) {
	return __SMARTLIB::layout()->get_class_of_component($component);
}


/**
 * Returns the image representing the gallery
 * @param $size
 *
 * @return mixed
 */
function smartlib_featured_image($size= 'full' ) {
	return __SMARTLIB::layout()->get_featured_image( $size  );
}


/**
 * Include the category specific template for the content
 */
function smartlib_template_category_loop() {

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

function smartlib_get_related_post_box( $category, $post_ID, $display_post_limit, $columns_per_slide = 4 ) {
	$query =  __SMARTLIB::layout()->get_related_post_box($category, $post_ID, $display_post_limit, $columns_per_slide);

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
											><?php smartlib_get_format_ico($post_format) ?><?php the_post_thumbnail( 'medium-image-thumb' ); ?></a>

								<?php
							}


							?>
							<h4><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
							<?php if ( '' == get_the_post_thumbnail() ) { ?>
						<?php smartlib_display_meta_post('author') ?>
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
 * Display sidebar with grid elements
 *
 * @param int $index
 *
 * @return mixed
 */
function smartlib_dynamic_sidebar_grid($index=1){
	return __SMARTLIB::layout()->dynamic_sidebar_grid($index);
}

/**
 * Return awesome icon based on key_class
 *
 * @param $key_class
 */
function smartlib_get_awesome_ico($key_class){
		$class_name = __SMARTLIB::layout()->get_awesome_icon_class($key_class);
	  ?>
    <i class="<?php echo $class_name ?>"></i>
		<?php
}

/**
 * Display format (gallery, video) icon
 *
 * @param $key_class
 */
function smartlib_get_format_ico($key_class){
	$class_name = __SMARTLIB::layout()->get_awesome_icon_class($key_class);
	$formats_array = __SMARTLIB::layout()->get_promoted_formats();
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
function smartlib_display_meta_post($type='author'){
	global $post;
	?>

<p class="meta-line">
       <?php echo smartlib_get_date() ?>
	<?php
	$post_format = get_post_format( $post->ID );

	$speacial_formats = array(
		'gallery', 'video'
	);
	if(in_array($post_format, $speacial_formats )){
		?>
		<span class="meta-label smartlib-postformat-info"><?php smartlib_get_awesome_ico($post_format) ?> <?php echo ucfirst ($post_format) ?></span>
			<?php
	}


		 if ( comments_open() && is_single() ) { ?>
				 <span class="meta-label comment-label"><?php comments_popup_link( __( 'Comment', 'harmonux' ) .'<i class="'.smartlib_get_awesome_ico('comments').'"></i></span>', __( '1 Reply', 'harmonux' ), __( '% Replies', 'harmonux' ) );?></span>
			 <?php
			 }


	if($type=='author'){

	}else if($type=='category'){
		smartlib_category_line();
	}
?>


</p>
		<?php
}
/*
 * Print author line
 */
function smartlib_author_line(){
	?>
<span class="meta-label meta-publisher vcard"><?php _e('Published by: ', 'harmonux') ?> <?php the_author_posts_link(); ?> </span>
		<?php
}

/**
 Prints tag line with HTML
 */
function smartlib_entry_tags(){
	?>
<?php if ( has_tag() ): ?>
	<div class="smartlib-tags-article"> <?php smartlib_get_awesome_ico('tag_icon')?> <?php the_tags( __( 'Tags: ', 'harmonux' ), '  ' ); ?></div>
	<?php endif ?>
		<?php
}

/**
 Prints leave replay button
 */
function smartlib_replay_link(){
	?>
<div class="smartlib-comments-link">
	<?php if ( comments_open() && is_single() ) { ?>
	<?php comments_popup_link( __( 'Comment', 'harmonux' ) .'<i class="'.smartlib_get_awesome_ico('comments').'"></i></span>', __( '1 Reply', 'harmonux' ), __( '% Replies', 'harmonux' ) ); ?>
	<?php } ?>
</div>
		<?php
}

/**
 * Custom form password
 *
 * @since MaxFlat 1.0
 *
 * @return string
 */

function smartlib_password_form() {
	global $post;
	$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
	$o     = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post" class="password-form"><div class="row"><div class="columns sixteen"><i class="icon-lock icon-left"></i>' . __( "To view this protected post, enter the password below:", 'harmonux') . '</div><label for="' . $label . '" class="columns four mobile-four">' . __( "Password:", 'harmonux') . ' </label><div class="columns eight mobile-four"><input name="post_password" id="' . $label . '" type="password" size="20" /></div><div class="columns four mobile-four"><input type="submit" name="Submit" value="' . esc_attr__( "Submit", 'harmonux') . '" /></div>
    </div></form>
    ';
	return $o;
}

/**
 * Return version of homepage layout
 * 1 - blog + sidebar
 * 2 - classic blog
 *
 * @return mixed
 */
function smartlib_version_homepage(){

	$version = __SMARTLIB::option( 'project_homepage_version' );
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
function smartlib_version_slider(){

	$slider_version = __SMARTLIB::option( 'project_homepage_slider' );
	if(empty($slider_version)){
		//return default (first value)
		return 1;
	}
	return $slider_version;

}

/*
 *  Display HomePage Slider
 */
function smartlib_get_homepage_slider(){

	$shortcode_slider = __SMARTLIB::option('project_homepage_slider_shortcode');



		if(!empty($shortcode_slider)){
			echo do_shortcode($shortcode_slider);
		}else{
			return false;
		}

}

function smartlib_display_options_taxonomy_filtr($term, $current_taxonomy, $taxonomy_name, $name, $link, $args=array(), $class_name='filter-selector', $slug=false, $label='select'){


	$args = array(
		'orderby'           => 'id',
		'order'             => 'DESC'
	);

	$product_taxonomy_list = get_terms( $taxonomy_name, $args);


	//w zalezności od tego czy rodzaj produktu czy materiał dodaje zerowa wartosc

	if(!$slug){
		$zero_value =  home_url( '/'  ).$link .$term->slug;
	}else{
		$zero_value = 0;
	}

	if($product_taxonomy_list>0){
		?>
	<select name="<?php echo $name ?>" class="<?php echo $class_name ?>">

		<?php

		if($taxonomy_name=='material'){
			$label = __('select material', 'maxflat');
		}else{
			$label = __('select product', 'maxflat');
		}
		?>

		<?php
		foreach($product_taxonomy_list as $taxonomy){
			if($slug){
				$value = $taxonomy->slug;
			}else{
				$value = home_url( '/'  ).$link .$taxonomy->slug;
			}

			if(is_object($current_taxonomy)){
				$current_slug = $current_taxonomy->slug;
			}else{
				$current_slug = $current_taxonomy;
			}
			if($taxonomy->slug == $current_slug){
				?>
				<option value="<?php echo $value  ?>" selected="selected"><?php echo $taxonomy->name ?></option>
				<?php
			}else{
				?>
				<option value="<?php echo  $value  ?>"><?php echo $taxonomy->name ?></option>
				<?php
			}

		}
		?>
	</select>
	<?php
	}


}
?>