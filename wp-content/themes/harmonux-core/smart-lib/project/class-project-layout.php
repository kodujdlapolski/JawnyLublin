<?php

/**
 * PROJECT LAYOUT CLASS
 * Includes layout settings
 */

class Smart_Project_Layout {

	public $obj_project;
	public $project_domain;
	public $project_prefix;
	public $obj_widgets;
	public $project_sidebars;
	public $project_widgets;
	public $default_separator = ' &raquo; ';
  public $mobile_menu_exclude = array(3); //array of layout wariants with exclude mobile menu - $layout_class_array $key

	/*comonents params*/
	public $excerpt_length = 20;

	public $positions_array =  array(
		1 => array(
			'sidebar' => array(
				'left'  => 0,
				'right' => 1
			),
		),
		2 => array(
			'sidebar' => array(
				'left'  => 0,
				'right' => 1
			),

		),
		3 => array(
			'sidebar' => array(
				'left'  => 0,
				'right' => 0
			),

		),

	);


	public static $promoted_formats = array(
		'video', 'gallery'
	);

	public $layout_class_array = array(
		1  => array(

			'sidebar' => 'medium-16 large-4  columns',

			'content' => 'medium-16 large-12 columns'
		),
		2  => array(

			'sidebar' => 'medium-16 large-4 columns large-pull-12',

			'content' => 'medium-16 large-12 columns large-push-4'
		),
		3  => array(

			'sidebar' => '',

			'content' => 'medium-16 large-16 columns'
		),


	);
  /*
   * Array maping awesome class
   */
	public $icon_awesome_translate_class = array(
		'gallery' => 'fa fa-picture-o',
		'video' => 'fa fa-video-camera',
		'default_icon' => 'fa fa-caret-square-o-right',
		'tag_icon'=>'fa fa-tags',
		'twitter' => 'fa fa fa-twitter-square',
		'facebook' => 'fa fa-facebook-square',
		'gplus' =>'fa fa-google-plus-square',
		'pinterest' =>'fa fa-pinterest-square',
		'linkedin' =>'fa fa-linkedin-square',
		'youtube' =>'fa fa-youtube-square',
		'twitter_large' => 'fa fa fa-twitter',
		'facebook_large' => 'fa fa-facebook',
		'gplus_large' =>'fa fa-google-plus',
		'pinterest_large' =>'fa fa-pinterest',
		'linkedin_large' =>'fa fa-linkedin',
		'youtube_large' =>'fa fa-youtube',
    'comments' => 'fa fa-comment'
	);



	public function __construct( $project_base ) {
		$this->obj_project    = $project_base;
		$this->project_prefix = $this->obj_project->project_prefix;
		$this->project_sidebars = $this->obj_project->project_sidebars;
		$this->project_widgets = $this->obj_project->project_widgets;

		add_filter( 'the_password_form', array( $this, 'harmonux_password_form' ) );

		//Initialize widgets
		$this->obj_widgets = new Smart_Theme_Widgets($this);

	}

	public function get_class_of_component( $component ) {

		$option = $this->obj_project->get_project_option( 'project_layout' );


		if ( isset( $this->layout_class_array[$option][$component] ) )
			return $this->layout_class_array[$option][$component];
		else
			return $this->layout_class_array[1][$component];
	}

	/**
	 * Returns an occurrence of the element at a given position
	 */

	function check_position_of_component( $component, $side ) {
		$option = $this->obj_project->get_project_option( 'project_layout' );

		if ( isset( $this->positions_array[$option][$component][$side] ) )
			return $this->positions_array[$option][$component][$side];
		else
			return $this->positions_array[1][$component][$side];
		//get default configuration


	}



	/*
		 * Sort helper function
		 */
	static function wp_nav_menu_select_sort( $a, $b ) {
		return $a = $b;
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

	function wp_nav_menu_select( $args = array() ) {

		$menu = array();


		$menu_locations = get_nav_menu_locations();

        $layout_variant = $this->obj_project->get_project_option( $this->project_prefix . '_layout' );

		//*check layout variant
       if(!in_array($layout_variant, $this->mobile_menu_exclude)){

        if ( isset( $menu_locations[$args['theme_location']] ) ) {
			$menu = wp_get_nav_menu_object( $menu_locations[$args['theme_location']] );
		}

		if ( count( $menu ) > 0 && isset( $menu->term_id ) ) {


			$menu_items = wp_get_nav_menu_items( $menu->term_id );

			$children = array();
			$parents  = array();

			foreach ( $menu_items as $id => $data ) {
				if ( empty( $data->menu_item_parent ) ) {
					$top_level[$data->ID] = $data;
				}
				else {
					$children[$data->menu_item_parent][$data->ID] = $data;
				}
			}

			foreach ( $top_level as $id => $data ) {
				foreach ( $children as $parent => $items ) {
					if ( $id == $parent ) {
						$menu_item[$id] = array(
							'parent'   => true,
							'item'     => $data,
							'children' => $items,
						);
						$parents[]      = $parent;
					}
				}
			}

			foreach ( $top_level as $id => $data ) {
				if ( ! in_array( $id, $parents ) ) {
					$menu_item[$id] = array(
						'parent' => false,
						'item'   => $data,
					);
				}
			}

			uksort( $menu_item, array( __CLASS__, 'wp_nav_menu_select_sort' ) );
        return $menu_item;



		}
		else {

       return false;
		}
      }
	}

	/**
	 * Print breadcrumb trail
	 *
	 *
	 */
	function get_the_bredcrumb() {

		//Get bredcrumb separator option
		$sep = ( $this->obj_project->get_project_option( 'breadcrumb_separator' ) ) ? $this->obj_project->get_project_option( 'breadcrumb_separator' ) : $this->default_separator;


		if ( ! is_front_page() ) {
			echo '<a href="';
			echo home_url();
			echo '">';
			bloginfo( 'name' );
			echo '</a>' . $sep;

			if ( is_category() || is_single() ) {
				the_category( $sep );
			}
			elseif ( is_archive() || is_single() ) {
				if ( is_day() ) {
					printf( __( '%s', 'harmonux'), get_the_date() );
				}
				elseif ( is_month() ) {
					printf( __( '%s', 'harmonux'), get_the_date( _x( 'F Y', 'monthly archives date format', 'harmonux') ) );
				}
				elseif ( is_year() ) {
					printf( __( '%s', 'harmonux'), get_the_date( _x( 'Y', 'yearly archives date format', 'harmonux') ) );
				}
				else {
					_e( 'Blog Archives', 'harmonux');
				}
			}

			if ( is_page() ) {
				echo the_title();
			}
		}
	}

	/**
	 * Output header
	 */

	function get_site_header() {
		?>
	<header class="frontpage-header" role="banner">

		<?php $header_image = get_header_image();
		$banner_header      = stripslashes(get_theme_mod( 'banner_code_header' ));
		$front_page_header      = $this->obj_project->get_project_option( 'project_homepage_header' );

        //add default value
        $front_page_header = ($front_page_header) ? $front_page_header: 1;

        if(is_front_page()){
		if ( ! empty( $header_image ) ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>"
																															 class="header-image"
																															 width="<?php echo get_custom_header()->width; ?>"
																															 height="<?php echo get_custom_header()->height; ?>"
																															 alt="" /></a>
			<?php elseif ( ! empty( $banner_header ) ): ?>
			<div class="header-banner">
				<?php echo $banner_header ?>
			</div>
			<?php
		else:

            if($front_page_header==1){

            ?>

            <h2 class="site-description" itemprop="description"><?php bloginfo( 'description' ); ?></h2>

                <?php
                  }
                endif;

		}
			?>

	</header>

	<?php
	}


	/**
	 * Rerutn current post categories.
	 */
	function category_line() {
		return $categories_list = get_the_category_list( __( ' ', 'harmonux') );

	}

	/**
	 * Print post date line
	 * @return string
	 */

	function display_date() {

		$archive_year  = get_the_time( 'Y' );
		$archive_month = get_the_time( 'm' );
		$archive_day   = get_the_time( 'd' );

		$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark" class="meta-label meta-date"><i class="icon-left fa fa-calendar-o"></i><time class="entry-date" itemprop="startDate" datetime="%3$s">%4$s</time></a>',
			esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		return $date;
	}

	/**
	 * Display pagination on the loop page
	 *
	 * @param $html_id
	 */
	function pagination_nav( $html_id ) {
		global $wp_query;

		$pagination_option = $this->obj_project->get_project_option(  'project_pagination_posts' );
		$html_id           = esc_attr( $html_id );

		if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'harmonux'); ?></h3>
			<?php

			if ( $pagination_option == '1' ) {
				?>
			<div class="smartlib-next-prev">
				<?php next_posts_link( __( '&larr; Older posts', 'harmonux') ); ?>
			  <?php previous_posts_link( __( 'Newer posts &rarr;', 'harmonux') ); ?>
			</div>
				<?php
			}
			else {
				//get custom smartlib pagination
				$this->pagination_links();
			}
			?>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
		<?php endif;
	}


	/*
	 * Display smartlib paginate links
	 */
	public function pagination_links() {
		global $wp_query;

		$big     = 999999999; // This needs to be an unlikely integer
		$current = max( 1, get_query_var( 'paged' ) );
		// For more options and info view the docs for paginate_links()
		// http://codex.wordpress.org/Function_Reference/paginate_links
		$paginate_links = paginate_links( array(
			'base'     => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
			'current'  => $current,
			'total'    => $wp_query->max_num_pages,
			'mid_size' => 5,
			'type'     => 'array'
		) );

		// Display the pagination if more than one page is found
		if ( $paginate_links ) {

			echo '<ul class="pagination">';
			foreach ( $paginate_links as $row ) {

				?>
			<li><?php echo $row ?></li>
			<?php

			}
			echo '</ul><!--// end .pagination -->';
		}
	}

	/**
	 * Displays navigation to next/previous post on single  page.
	 */

	function single_prev_next() {

		?>
	<nav class="nav-single">
		<h3 class="assistive-text"><?php _e( 'Post navigation', 'harmonux'); ?></h3>
				<div class="smartlib-single-next-prev">
       <?php previous_post_link( '%link',  _x( '&larr; Previous post link', 'Previous post link', 'harmonux') ); ?>
       <?php next_post_link( '%link',  _x( 'Next post link &rarr;', 'Next post link', 'harmonux') ); ?>
				</div>
	</nav><!-- .nav-single -->
	<?php
	}

	/**
	 *
	 * Modyfication wp_link_pages() - <!--nextpage--> pagination
	 *
	 * @param string|array $args Optional. Overwrite the defaults.
	 *
	 * @return string Formatted output in HTML.
	 */
	function custom_wp_link_pages( $args = '' ) {
		$defaults = array(
			'before'           => '<div id="post-pagination" class="pagination">' . __( 'Pages:', 'harmonux'),
			'after'            => '</div>',
			'text_before'      => '',
			'text_after'       => '',
			'next_or_number'   => 'number',
			'nextpagelink'     => __( 'Next page', 'harmonux'),
			'previouspagelink' => __( 'Previous page', 'harmonux'),
			'pagelink'         => '%',
			'echo'             => 1
		);

		$r = wp_parse_args( $args, $defaults );
		$r = apply_filters( 'wp_link_pages_args', $r );
		extract( $r, EXTR_SKIP );

		global $page, $numpages, $multipage, $more, $pagenow;

		$output = '';
		if ( $multipage ) {
			if ( 'number' == $next_or_number ) {
				$output .= $before;
				for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
					$j = str_replace( '%', $i, $pagelink );
					$output .= ' ';
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
						$output .= _wp_link_page( $i );
					else
						$output .= '<span class="current-post-page">';

					$output .= $text_before . $j . $text_after;
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
						$output .= '</a>';
					else
						$output .= '</span>';
				}
				$output .= $after;
			}
			else {
				if ( $more ) {
					$output .= $before;
					$i = $page - 1;
					if ( $i && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $text_before . $previouspagelink . $text_after . '</a>';
					}
					$i = $page + 1;
					if ( $i <= $numpages && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $text_before . $nextpagelink . $text_after . '</a>';
					}
					$output .= $after;
				}
			}
		}
		if ( is_single() || is_page() ) {
			if ( $echo )
				echo $output;

			return $output;
		}
		else {
			return '';
		}

	}


	/**
	 * Template for comments and pingbacks.
	 */

	function comment_component( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				// Display trackbacks differently than normal comments.
				?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'harmonux'); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'harmonux'), '<span class="edit-link">', '</span>' ); ?></p>
					<?php
				break;
			default :
				// Proceed with normal comments.
				global $post;
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment">
						<header class="comment-meta comment-author vcard">
							<?php
							$user_photo = get_user_meta( $comment->user_id, 'harmonux_profile_image', true );
							if ( ! empty( $user_photo ) ) {
								?>
								<img src="<?php echo $user_photo?>" alt="User" width="44" height="44" />
								<?php

							}
							else
								echo get_avatar( $comment, 44 );
							printf( '<cite class="fn">%1$s %2$s</cite>',
								get_comment_author_link(),
								// If current post author is also comment author, make it known visually.
								( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'harmonux') . '</span>' : ''
							);
							printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'harmonux'), get_comment_date(), get_comment_time() )
							);
							?>
						</header>
						<!-- .comment-meta -->

						<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'harmonux'); ?></p>
						<?php endif; ?>

						<section class="comment-content comment">
							<?php comment_text(); ?>
							<?php edit_comment_link( __( 'Edit', 'harmonux'), '<p class="edit-link">', '</p>' ); ?>
						</section>
						<!-- .comment-content -->

						<div class="smartlib-comments-replay-button">
							<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'harmonux'), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div>
						<!-- .reply -->
					</article><!-- #comment-## -->
					<?php
				break;
		endswitch; // end comment_type check
	}


	/**
	 * Display related post component
	 *
	 * @param     $category of related articles
	 * @param     $post_ID
	 * @param     $display_post_limit
	 * @param int $columns_per_slide
	 */
	function get_related_post_box( $category, $post_ID, $display_post_limit, $columns_per_slide = 4 ) {
		global $post;

		$args = array(
			'cat'           => $category,
			'post__not_in'  => array( $post_ID * - 1 ),
			'posts_per_page'=> $display_post_limit,
			'tax_query' => array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array( 'post-format-gallery' )
				),
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array( 'post-format-video' )
				),
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => array( 'post-format-standard' )
					)

			)
		);


		$query = new WP_Query( $args );


			return $query;


		//if limit >0

	}

	/**
	 * Returns the image representing the gallery
	 *
	 * @param string $size
	 *
	 * @return string
	 */
	function get_featured_image( $size = 'full' ) {
		global $post;


		$attachmentimage = '';


		if ( $images = get_children( array(
			'post_parent'    => $post->ID,
			'post_type'      => 'attachment',
			'numberposts'    => 1,
			'post_mime_type' => 'image',
			'order'          => 'DESC',
			'orderby'        => 'menu_order ID'
		) )
		) {
			foreach ( $images as $image ) {

				$attachmentimage = wp_get_attachment_image( $image->ID, $size );
			}

		}


		if ( empty( $attachmentimage ) ) {

			/*if gallery is not attachment*/
			$post_subtitrare = get_post( $post->ID );
			$content         = $post_subtitrare->post_content;

			$pattern = get_shortcode_regex();


			if (
				preg_match_all( "/$pattern/s", $content, $matches )
				&& array_key_exists( 2, $matches )
				&& in_array( 'gallery', $matches[2] )
			) {

				foreach ( $matches[2] as $key => $row ) {
					if ( $row == 'gallery' ) {
						$id = $key;
					}
				}

        foreach($matches[0] as $match_line){
					 $match_array =  shortcode_parse_atts($match_line);
					foreach($match_array as $row){

						$pos = strripos($row, 'ids="');

						if($pos!==false){

							$piece = substr($row, $pos, strpos($row,','));
							$first_id = substr($piece,5);
						}


					}

				}

				$attachmentimage = wp_get_attachment_image( $first_id, $size );
				}

			}


		return $attachmentimage;

	}

	/**
	 * Display social buttons
	 */
	function prepare_social_buttons() {

		$social_buttons_array = array();
		//get social options
		$social_buttons_array['facebook']  = $this->obj_project->get_project_option( 'social_button_facebook' );
		$social_buttons_array['twiter']    = $this->obj_project->get_project_option( 'social_button_twitter' );
		$social_buttons_array['gplus']     = $this->obj_project->get_project_option( 'social_button_gplus' );
		$social_buttons_array['pinterest'] = $this->obj_project->get_project_option( 'social_button_pinterest' );

    if(isset($social_buttons_array['gplus'] ) && $social_buttons_array['twiter'] ){
			wp_enqueue_script( 'gplus_script' );
		}

		return $social_buttons_array;
	}



	/**
		Return value form  $this->icon_awesome_translate_class
 	 */
	public function get_awesome_icon_class($key){
		if(isset($this->icon_awesome_translate_class[$key])){
			return $this->icon_awesome_translate_class[$key];
		}else{
			return $this->icon_awesome_translate_class['default_icon'];
		}
	}

	/**
	 * Return promoted formats to decide which formats have icons
	 *
	 * @return array
	 */
	public function get_promoted_formats(){
		return self::$promoted_formats;
	}

	/**
	 * Custom form password
	 *

	 *
	 * @return string
	 */

	public function harmonux_password_form() {
		global $post;
		$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
		$o     = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post" class="password-form"><div class="row"><div class="columns sixteen"><i class="icon-lock icon-left"></i>' . __( "To view this protected post, enter the password below:", 'harmonux') . '</div><label for="' . $label . '" class="columns four mobile-four">' . __( "Password:", 'harmonux') . ' </label><div class="columns eight mobile-four"><input name="post_password" id="' . $label . '" type="password" size="20" /></div><div class="columns four mobile-four"><input type="submit" name="Submit" value="' . esc_attr__( "Submit", 'harmonux') . '" /></div>
    </div></form>
    ';
		return $o;
	}
}