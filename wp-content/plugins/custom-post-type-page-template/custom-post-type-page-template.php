<?php
/*
Plugin Name: Custom Post Type Page Template
Plugin URI: http://wpgogo.com/development/custom-post-type-page-template.html
Description: This plugin enables custom post types directly to add page templates of the page type.
Author: Hiroaki Miyashita
Version: 1.0
Author URI: http://wpgogo.com/
*/

/*  Copyright 2012 Hiroaki Miyashita

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class custom_post_type_page_template {

	function custom_post_type_page_template() {
		add_action( 'init', array(&$this, 'custom_post_type_page_template_init') );
		add_action( 'admin_init', array(&$this, 'custom_post_type_page_template_admin_init') );
		add_action( 'admin_menu', array(&$this, 'custom_post_type_page_template_admin_menu') );
		add_action( 'save_post', array(&$this, 'custom_post_type_page_template_save_post') );
		add_filter( 'template_include', array(&$this, 'custom_post_type_page_template_template_include') );		
		add_action( 'template_redirect', array(&$this, 'custom_post_type_page_template_template_redirect') );		
		add_filter( 'body_class', array(&$this, 'custom_post_type_page_template_body_classes') );
	}

	function custom_post_type_page_template_init() {
		if ( function_exists('load_plugin_textdomain') ) {
			if ( !defined('WP_PLUGIN_DIR') ) {
				load_plugin_textdomain( 'custom-post-type-page-template', str_replace( ABSPATH, '', dirname(__FILE__) ) );
			} else {
				load_plugin_textdomain( 'custom-post-type-page-template', false, dirname( plugin_basename(__FILE__) ) );
			}
		}
	}

	function custom_post_type_page_template_admin_init() {
		$options = get_option('custom_post_type_page_template');
		if ( !empty($options['post_types']) && is_array($options['post_types']) ) :
			foreach( $options['post_types'] as $post_type ) :
				add_meta_box( 'pagetemplatediv', __('Page Template', 'custom-post-type-page-template'), array(&$this, 'custom_post_type_page_template_meta_box'), $post_type, 'side', 'core');
			endforeach;
		endif;
	}

	function custom_post_type_page_template_admin_menu() {
		add_options_page( __('Custom Post Type Page Template', 'custom-post-type-page-template'), __('Custom Post Type Page Template', 'custom-post-type-page-template'), 'manage_options', basename(__FILE__), array(&$this, 'custom_post_type_page_template_options_page') );
	}

	function custom_post_type_page_template_meta_box($post) {
		$template = get_post_meta($post->ID, '_wp_page_template', true);
?>
<label class="screen-reader-text" for="page_template"><?php _e('Page Template', 'custom-post-type-page-template') ?></label><select name="page_template" id="page_template">
<option value='default'><?php _e('Default Template', 'custom-post-type-page-template'); ?></option>
<?php page_template_dropdown($template); ?>
</select>
<?php
	}

	function custom_post_type_page_template_save_post( $post_id ) {
		if ( !empty($_POST['page_template']) ) :
			if ( $_POST['page_template'] != 'default' ) :
				update_post_meta($post_id, '_wp_page_template', $_POST['page_template']);
			else :
				delete_post_meta($post_id, '_wp_page_template');
			endif;
		endif;
	}

	function custom_post_type_page_template_template_include($template) {
		global $wp_query, $post;

		if ( is_singular() && !is_page() ) :
			$id = get_queried_object_id();
			$new_template = get_post_meta( $id, '_wp_page_template', true );
			if ( $new_template && file_exists(get_query_template( 'page', $new_template )) ) :
				$wp_query->is_page = 1;
				$templates[] = $new_template;
				return get_query_template( 'page', $templates );
			endif;
		endif;
		return $template;
	}
	
	function custom_post_type_page_template_template_redirect() {
		$options = get_option('custom_post_type_page_template');
		if ( empty($options['enforcement_mode']) ) return;

		global $wp_query;
		
		if ( is_singular() && !is_page() ) :
			wp_cache_delete($wp_query->post->ID, 'posts');
			$GLOBALS['post']->post_type = 'page';
			wp_cache_add($wp_query->post->ID, $GLOBALS['post'], 'posts');
		endif;
	}

	function custom_post_type_page_template_body_classes( $classes ) {
		if ( is_singular() && is_page_template() ) :
			$classes[] = 'page-template';
			$classes[] = 'page-template-' . sanitize_html_class( str_replace( '.', '-', get_page_template_slug( get_queried_object_id() ) ) );			
		endif;
		return $classes;
	}

	function custom_post_type_page_template_options_page() {
		$options = get_option('custom_post_type_page_template');

		if ( !empty($_POST) ) :
			if ( !empty($_POST['enforcement_mode']) ) $options['enforcement_mode'] = 1;
			else unset($options['enforcement_mode']);
			if ( empty($_POST['post_types']) ) :
				delete_option('custom_post_type_page_template', $options);
				unset($options['post_types']);
			else :
				$options['post_types'] = $_POST['post_types'];
				update_option('custom_post_type_page_template', $options);
			endif;
		endif;
?>
<div class="wrap">
<div id="icon-plugins" class="icon32"><br/></div>
<h2><?php _e('Custom Post Type Page Template', 'custom-post-type-page-template'); ?></h2>

<?php
		if ( !empty($_GET['settings-updated']) ) :
?>
<div id="message" class="updated"><p><strong><?php _e( 'Settings saved.', 'custom-post-type-page-template' ); ?></strong></p></div>
<?php
		endif;
?>

<form action="?page=custom-post-type-page-template.php&settings-updated=true" method="post">
<table class="form-table">
<tbody>
<tr>
<th><label for="post_types"><?php _e('Custom Post Types', 'custom-post-type-page-template'); ?></label></th>
<td>
<?php
	$post_types = get_post_types(array('public'=>true));
	foreach( $post_types as $key => $val ) :
		if ( $key == 'attachment' || $key == 'page' ) continue;
?>
<label><input type="checkbox" name="post_types[]" value="<?php echo $key; ?>"<?php if ( is_array($options['post_types']) && in_array($key, $options['post_types'])) echo ' checked="checked"'; ?> /> <?php echo $key; ?></label><br />
<?php
	endforeach;
?>
</p>
</td>
</tr>
<tr>
<th><label for="enforcement_mode"><?php _e('Enforcement Mode', 'custom-post-type-page-template'); ?></label></th>
<td><label><input type="checkbox" name="enforcement_mode" id="enforcement_mode" value="1" <?php if ( !empty($options['enforcement_mode']) ) echo ' checked="checked"'; ?> /> <?php _e('Check this in case of using  themes like Twenty Eleven, Twenty Twelve, etc.', 'custom-post-type-page-template'); ?></label></td>
</tr>
</tbody>
</table>
<p class="submit"><input type="submit" value="<?php _e('Save Changes', 'custom-post-type-page-template'); ?>" class="button-primary" id="submit" name="submit"></p>
</form>
<?php
	}
}
global $custom_post_type_page_template;
$custom_post_type_page_template = new custom_post_type_page_template();
?>