<?php


?>
<?php
/**
 *
 * MaxFlat functions and definitions.
 *
 * The functions file is used to initialize everything in the theme.
 * It sets up the supported features, default actions  and filters.
 *
 *
 * 
 * @since      MaxFlat 1.0
 */

// Load Smart Library
require(get_template_directory() . '/smart-lib/load.php');

/**
 * Initialize smart lib project object
 */
__SMARTLIB::init();



/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */

if (!isset($content_width))
    $content_width = 625;

/**
 * Sets up theme defaults and registers the various WordPress features
 */

function smartlib_setup(){
    /*
             * Load textdomain.
             */
    load_theme_textdomain('harmonux', get_template_directory() . '/languages');

    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style();

    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support('automatic-feed-links');

    // This theme supports a variety of post formats.
    add_theme_support('post-formats', array('aside', 'image', 'link', 'quote', 'status', 'video',  'gallery'));

    // add custom header suport
    $args = array(

        'uploads' => true,
        'header-text' => false
    );
    add_theme_support('custom-header', $args);

    // This theme large-2 wp_nav_menu() in large-1 location.
    register_nav_menu('top_pages', __('Top Menu', 'harmonux'));
    register_nav_menu('home_page_menu', __('Home Page Menu', 'harmonux'));

    /*
                 * This theme supports custom background color and image, and here
                 * we also set up the default background color.
                 */
    add_theme_support('custom-background', array(
                                                'default-color' => 'fff',
                                           ));
	  add_theme_support('shortcode');
    /**
     * POSTS THUMBNAILS
     */
    // This theme uses a custom image size for featured images, displayed on "standard" posts.
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(624, 9999); // Unlimited height, soft crop
    add_image_size('small-image', 80, 80, true);
    add_image_size('medium-image-thumb', 200, 150, true);
	  add_image_size('wide-image', 1000, 620, true);
	  add_image_size('medium-square', 350, 350, true);


}

add_action('after_setup_theme', 'smartlib_setup');

/**
 * Enqueues scripts and styles for front-end.
 *
 */
function smartlib_scripts_styles()
{

	wp_enqueue_script( 'harmonux_maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=drawing',  array( 'jquery' ));



}

add_action('wp_enqueue_scripts', 'smartlib_scripts_styles');

foreach ( array( 'pre_term_description' ) as $filter ) {
	remove_filter( $filter, 'wp_filter_kses' );
}

foreach ( array( 'term_description' ) as $filter ) {
	remove_filter( $filter, 'wp_kses_data' );
}
/**
 * Add new post type
 */

add_action( 'init', 'create_budget' );
function create_budget() {

	register_post_type( 'budget',
		array(
			'labels' => array(
				'name' => __( 'Pozycja w budzecie' ),
				'singular_name' => __( 'Pozycja w budzecie' )
			),
			'public' => true,
			'has_archive' => false,
			'hierarchical' => true,
			'rewrite' => array('slug' => 'budget'),
			'taxonomies' => array('year'),
			'supports' => array('title', 'editor', 'thumbnail' , 'page-attributes'  )
		)
	);
}

function harmonux_year_init() {
	// create a new taxonomy
	register_taxonomy(
		'year',
		array('budget', 'calculator'),
		array(

			'labels' => array('name'=>__( 'Lata podatkowe' ),'add_new_item'      => __( 'Dodaj Rok' )),
			'rewrite' => array( 'slug' => 'year' ),
			'hierarchical' => true
		)
	);
}
add_action( 'init', 'harmonux_year_init' );


function create_chart_data() {
	register_post_type( 'chart_data',
		array(
			'labels' => array(
				'name' => __( 'Punkt na wykresie' ),
				'singular_name' => __( 'Punkt na wykresie' )
			),
			'has_archive' => false,
			'hierarchical' => false,
			'public' => true,
			'taxonomies' => array('wykres'),
			'supports' => array('title', 'editor'  )
		)
	);
}
add_action( 'init', 'create_chart_data' );
function harmonux_wykres_init() {
	// create a new taxonomy
	register_taxonomy(
		'wykres',
		'chart_data',
		array(
			'label' => __( 'Wykres' ),
			'rewrite' => array( 'slug' => 'chart' ),
			'hierarchical' => true
		)
	);
}
add_action( 'init', 'harmonux_wykres_init' );

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'harmonx_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'harmonx_post_meta_boxes_setup' );
/*add metaboxes */

function harmonx_post_meta_boxes_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'harmonux_add_post_meta_boxes' );
	add_action( 'save_post', 'harmonux_save_budget_meta', 10, 2 );
}

function harmonux_add_post_meta_boxes(){


	add_meta_box(
		'suma-post-class',      // Unique ID
		esc_html__( 'Kwota wydatków', 'harmonux' ),    // Title
		'harmonux_budget_meta_box',   // Callback function
		'budget',         // Admin page (or post type)
		'side',         // Context
		'default'         // Priority
	);
}

function harmonux_budget_meta_box($object, $box){
	?>

<?php wp_nonce_field( basename( __FILE__ ), 'budget_ammount_nonce' ); ?>

<p>
	<label for="budget_ammount"><?php _e( "Kwota w budżecie", 'harmonux' ); ?></label>
	<br />
	<input class="widefat" type="text" name="budget_ammount" id="budget_ammount" value="<?php echo esc_attr( get_post_meta( $object->ID, 'budget_ammount', true ) ); ?>" size="30" />
</p>
<?php
}

/* Save the meta box's post metadata. */
function harmonux_save_budget_meta( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['budget_ammount_nonce'] ) || !wp_verify_nonce( $_POST['budget_ammount_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( isset( $_POST['budget_ammount'] ) ?  $_POST['budget_ammount']  : '' );

	/* Get the meta key. */
	$meta_key = 'budget_ammount';

	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
}

/*Localize script with data on category page*/

function harmonux_localize_script_category_data(){

	global $wp_query;
	global $post;
  if(is_object($post)){
	$calc_terms = get_the_terms( $post->ID, 'year' );

  if(is_array($calc_terms)&& count($calc_terms)>0){
	foreach($calc_terms as $term){
		$term_id = $term->term_id;
	}



		$queried_object = get_queried_object();
		wp_register_script( 'tax_info', get_template_directory_uri(). '/js/tax_info.js' );

		$cat_extra_data = get_option( 'taxonomy_' . $term_id );
		if(is_array($cat_extra_data)){
			wp_localize_script( 'tax_info', 'tax_info', $cat_extra_data );
			wp_enqueue_script( 'tax_info' );
		}
	}
	}
}

add_action('wp_head', 'harmonux_localize_script_category_data');

/**
 * CHARTS METABOX
 */

add_action( 'load-post.php',  'charts_meta_boxes_setup' );
add_action( 'load-post-new.php', 'charts_meta_boxes_setup' );

function charts_meta_boxes_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'add_chart_meta_boxes' );
	add_action( 'save_post', 'save_charts_meta', 10, 2 );
}

function add_chart_meta_boxes(){


	add_meta_box(
		'chart-post-class',      // Unique ID
		esc_html__( 'Współrzędne', 'harmonux' ),    // Title
		'charts_meta_box',   // Callback function
		'chart_data',         // Admin page (or post type)
		'side',         // Context
		'default'         // Priority
	);
}

function charts_meta_box($object, $box){
	?>

<?php wp_nonce_field( basename( __FILE__ ), 'chart_nonce' ); ?>

<p>
	<label for="axis_x"><?php _e( "Oś X wartość", 'harmonux' ); ?></label>
	<input class="widefat" type="text" name="axis_x" id="axis_x" value="<?php echo esc_attr( get_post_meta( $object->ID, 'axis_x', true ) ); ?>" size="30" />
</p>

<p>
	<label for="axis_y"><?php _e( "Oś Y wartość", 'harmonux' ); ?></label>
	<input class="widefat" type="text" name="axis_y" id="axis_y" value="<?php echo esc_attr( get_post_meta( $object->ID, 'axis_y', true ) ); ?>" size="30" />
</p>
<?php
}

/* Save the meta box's post metadata. */
function save_charts_meta( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['axis_x'] ) || !wp_verify_nonce( $_POST['chart_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_axis_x = ( isset( $_POST['axis_x'] ) ?  $_POST['axis_x']  : '' );
	$new_axis_y = ( isset( $_POST['axis_y'] ) ?  $_POST['axis_y']  : '' );



	/* Get the meta value of the custom field key. */

	$axis_x = get_post_meta( $post_id, 'axis_x', true );
	$axis_y = get_post_meta( $post_id, 'axis_y', true );


	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_axis_x && '' == $axis_x )
		add_post_meta( $post_id, 'axis_x', $new_axis_x, true );
	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_axis_x && $new_axis_x != $axis_x )
		update_post_meta( $post_id, 'axis_x', $new_axis_x );
	elseif ( '' == $new_axis_x && $axis_x )
		delete_post_meta( $post_id, 'axis_x', $axis_x );

	if ( $new_axis_y && '' == $axis_y  )
		add_post_meta( $post_id, 'axis_y', $new_axis_y, true );
	elseif ( $new_axis_y && $new_axis_y != $axis_y )
		update_post_meta( $post_id, 'axis_y', $new_axis_y );
	elseif ( $new_axis_y && $new_axis_y != $axis_y )
		update_post_meta( $post_id, 'axis_y', $new_axis_y );

	/* If there is no new meta value but an old value exists, delete it. */

}

add_action( 'init', 'create_calculator' );

function create_calculator() {

	register_post_type( 'calculator',
		array(
			'labels' => array(
				'name' => __( 'Kalkulatory' ),
				'singular_name' => __( 'Kalkulator' ),
				'add_new' => __( 'Dodaj Nowy' ),
			),
			'public' => true,
			'has_archive' => false,
			'hierarchical' => false,
			'rewrite' => array('slug' => 'kalkulator'),
			'taxonomies' => array('year'),

			'supports' => array('title', 'editor', 'thumbnail' , 'page-attributes'  )
		)
	);
}

/**
 * Spółki Miejsce Post Type
 */
add_action( 'init', 'harmonux_create_spolka' );
function harmonux_create_spolka() {

	register_post_type( 'spolka',
		array(
			'labels' => array(
				'name' => __( 'Spółki' ),
				'singular_name' => __( 'Spółka' )
			),
			'public' => true,
			'has_archive' => false,
			'hierarchical' => true,
			'rewrite' => array('slug' => 'spolka'),
			'taxonomies' => array('spolka_category'),
			'supports' => array('title', 'editor', 'thumbnail' , 'page-attributes'  )
		)
	);
}

function harmonux_taxonomy_spolka_category() {
	// create a new taxonomy
	register_taxonomy(
		'spolka_category',
		array('spolka'),
		array(

			'labels' => array('name'=>__( 'Kategorie' ),'add_new_item'      => __( 'Dodaj Kategorię' )),
			'rewrite' => array( 'slug' => 's' ),
			'hierarchical' => true
		)
	);
}
add_action( 'init', 'harmonux_taxonomy_spolka_category' );

/**
 * Porady Post Type
 */
add_action( 'init', 'harmonux_create_poradnik' );
function harmonux_create_poradnik() {

	register_post_type( 'poradnik',
		array(
			'labels' => array(
				'name' => __( 'Poradnik' ),
				'singular_name' => __( 'Porada' )
			),
			'public' => true,
			'has_archive' => false,
			'hierarchical' => true,
			'rewrite' => array('slug' => 'porada'),
			'supports' => array('title', 'editor', 'thumbnail' , 'page-attributes'  )
		)
	);
}

/**
 * Infografiki Post Type
 */
add_action( 'init', 'harmonux_create_infografika' );
function harmonux_create_infografika() {

	register_post_type( 'infografika',
		array(
			'labels' => array(
				'name' => __( 'Infografiki' ),
				'singular_name' => __( 'infografika' )
			),
			'public' => true,
			'has_archive' => false,
			'hierarchical' => true,
			'rewrite' => array('slug' => 'infografika'),
			'supports' => array('title', 'editor', 'thumbnail' , 'page-attributes'  )
		)
	);
}

/*Places Filter*/
function set_filter_category_cookie() {
	if ( isset($_POST['gmcpt-kategoria-form'])) {
		setcookie('gmcpt-kategoria-form', $_POST['gmcpt-kategoria-form'], time()+3600*24*100, COOKIEPATH, COOKIE_DOMAIN, false);
	}
}
add_action( 'init', 'set_filter_category_cookie');




