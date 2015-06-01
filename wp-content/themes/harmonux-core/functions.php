<?php


?>
<?php
/**
 *
 * HamronUX functions and definitions.
 *
 * The functions file is used to initialize everything in the theme.
 * It sets up the supported features, default actions  and filters.
 *
 *
 * 
 * @since      HamronUX 1.0
 */

// Load Smart Library
require(get_template_directory() . '/smart-lib/load.php');

/**
 * Initialize smart lib project object
 */
__HARMONUX::init();



/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */

if (!isset($content_width))
    $content_width = 625;

/**
 * Sets up theme defaults and registers the various WordPress features
 */

 if ( ! function_exists( 'harmonux_setup' ) ) :
 
function harmonux_setup(){
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
    register_nav_menu('footer_pages', __('Bottom Menu', 'harmonux'));

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

	add_action( 'tgmpa_register', 'harmonux_theme_register_required_plugins' );
}
endif; // harmonux_setup
add_action('after_setup_theme', 'harmonux_setup');

/**
 * Enqueues scripts and styles for front-end.
 *
 */
function harmonux_scripts_styles()
{

    if (is_singular() && comments_open() && get_option('thread_comments'))
        wp_enqueue_script('comment-reply');



}

add_action('wp_enqueue_scripts', 'harmonux_scripts_styles');


 if ( ! function_exists( 'harmonux_theme_register_required_plugins' ) ) :
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to harmonux_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into harmonux_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function harmonux_theme_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin pre-packaged with a theme.
		array(
			'name'               => 'WPSocialite', // The plugin name.
			'slug'               => 'wpsocialite', // The plugin slug (typically the folder name).
			'source'             => 'http://downloads.wordpress.org/plugin/wpsocialite.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => 'http://wordpress.org/plugins/wpsocialite/', // If set, overrides default API URL and points to an external URL.
		),



	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to pre-packaged plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'harmonux' ),
			'menu_title'                      => __( 'Install Plugins', 'harmonux' ),
			'installing'                      => __( 'Installing Plugin: %s', 'harmonux' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'harmonux' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'harmonux' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'harmonux' ), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'harmonux' ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'harmonux' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'harmonux' ), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'harmonux' ), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'harmonux' ), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'harmonux' ), // %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'harmonux' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'harmonux' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'harmonux' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'harmonux' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'harmonux' ), // %s = dashboard link.
			'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);

	tgmpa( $plugins, $config );

}
endif; // harmonux_setup