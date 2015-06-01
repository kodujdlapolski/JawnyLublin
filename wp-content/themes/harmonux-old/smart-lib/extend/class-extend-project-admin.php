<?php


class Smart_Extend_Project_Admin extends Smart_Base_Admin{

	public $obj_project;
	public $user_social_fields = array();


	public $shortcodes_list = array(
		'smartlib_Ico_Shortcode',
		'smartlib_Video_Shortcode',
		'smartlib_GoogleMap_Shortcode',
		'smartlib_PullquoteText_Shortcode',
		'smartlib_Smartlib_Link_Shortcode'
	);

	public $mce_buttons = array(
		'htext'=> 'highlightedtext',
		's_map'=> 'smartlib_map',
		's_video'=> 'smartlib_video',
		's_icon'=> 'smartlib_icon',
	);

	public function __construct($obj_project){
		$this->obj_project = $obj_project;

		/*extend user profile*/
        $this->set_user_social_fields();//set user fields array

        add_filter('user_contactmethods', array($this,'extend_contact_link'));

		add_action( 'show_user_profile', array($this,'image_profile_field'));
		add_action( 'edit_user_profile', array($this,'image_profile_field'));

		add_action( 'personal_options_update',array($this,'image_profile_save') );
		add_action( 'edit_user_profile_update', array($this,'image_profile_save'));

		//add avatar filter
		add_filter('get_avatar', array($this,'smartlib_userphoto_filter'), 1, 5);

    /*Load external script*/
		add_action( 'admin_enqueue_scripts', array($this,'extend_admin_area_enqueue_scripts'));

		//Initialize shortcodes
		$this->initialize_shortcodes();

		//ADD shortcode Buttons
		add_action( 'init', array($this, '_add_filters_shortocode_buttons') );

		//ADD Category layout metods
		add_action ('year_edit_form_fields', array($this,'extra_category_fields'), 10, 2);
		add_action('year_add_form_fields',array($this,'extra_category_fields'));

		// save extra category extra fields hook
		add_action( 'edited_year',  array($this,'save_extra_category_fileds'), 10, 2 );
		add_action( 'created_year',  array($this,'save_extra_category_fileds') );


		// ADD extra field to post

		add_action( 'add_meta_boxes', array($this,'smartlib_add_extended_box') );


		// ADD Header Banner Methods
		add_action('custom_header_options', array($this,'banner_code_header'));
		add_action('admin_head', array($this,'banner_code_header_save'));
	}

	/**
		Initlize shortcodes class from class-shortcodes.php
 	 */
	public function initialize_shortcodes(){

		Smartlib_PullquoteText_Shortcode::init();
		Smartlib_GoogleMap_Shortcode::init();
		Smartlib_Video_Shortcode::init();
		Smartlib_Ico_Shortcode::init();
		Smartlib_Link_Shortcode::init();

	}

    /*
     * Set user social array method
     */
    public function set_user_social_fields(){
        $this->user_social_fields['twitter'] =  __('Twitter Username', 'harmonux');
		$this->user_social_fields['facebook'] = __('Facebook URL', 'harmonux');
		$this->user_social_fields['gplus'] =__('Google+ URL', 'harmonux');
		$this->user_social_fields['pinterest'] =__('Pinterest URL', 'harmonux');
		$this->user_social_fields['linkedin'] =__('LinkedIn URL', 'harmonux');
		$this->user_social_fields['youtube'] =__('YouTube URL', 'harmonux');
    }


	/*EXTEND USER PROFILE*/
	function extend_contact_link($profile_fields) {

	return $this->user_social_fields;
    }

	/**
	 * Display image user profile field
	 *
	 * @param $user
	 */
	function image_profile_field( $user ) {
		if(current_user_can('upload_files')){
			$user_image = get_the_author_meta( 'smartlib_profile_image', $user->ID );
			?>

		<h3><?php _e("User profile picture", 'harmonux') ?></h3>

		<table class="form-table">

			<tr>
				<th><label for="smartlib_profile_image"><?php _e("Image", 'harmonux') ?></label></th>

				<td>
					<div class="smartlib-image smartlib-user-image-container"><?php echo !empty($user_image)? '<img src="'.$user_image.'"  alt="User Image" />' :'<img src="#" style="width: 0;height: 0" alt="User Image" />'  ?></div>
					<input type="text" name="smartlib_profile_image" id="smartlib_profile_image" value="<?php echo $user_image; ?>" class="regular-text" /><br />
					<a href="#" class="button smartlib-upload-user-photo-btn"><?php _e("Upload user photo", 'harmonux') ?></a>
					<span class="description"><?php _e(" or You can paste external URL", 'harmonux'); ?></span>
				</td>
			</tr>

		</table>
		<?php
		}
	}

	/**
	 * Save user profile image
	 * @param $user_id
	 *
	 * @return bool
	 */
	function image_profile_save( $user_id ) {

		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;


		update_user_meta( $user_id, 'smartlib_profile_image', $_POST['smartlib_profile_image'] );
	}

	/**
	 * Enqueue admin script
	 */
	function extend_admin_area_enqueue_scripts() {
		if(current_user_can('upload_files')){
			wp_enqueue_media(); //add uploader files


			//add common script
			wp_enqueue_script( 'extend_admin_area_plugin', SMART_ADMIN_DIRECTORY_URI.'/js/plugin-scripts.js', array( 'jquery' ), '1.0', false );
		}
	}

	/**
	 *
	 * If no Avatar is found use smartlib_profile_image
	 *
	 * @param $avatar
	 * @param $id_or_email
	 * @param $size
	 * @param $default
	 * @param $alt
	 *
	 * @return string
	 */
	function smartlib_userphoto_filter($avatar, $id_or_email, $size, $default, $alt) {

		$avatarfound = '';
		$safe_alt = '';
		$myavatar = '';

		if ( empty($default) ) {
			$avatar_default = get_option('avatar_default');

			if ( empty($avatar_default) )
				$default = $myavatar;
			else
				$default = $avatar_default;
		}

		if ( 'Mystery' == $default )
			$default = $myavatar;

		if (!is_object($id_or_email)) {
			//Returns the Local Avatar for Posts and Pages

			$custom_avatar = get_the_author_meta('smartlib_profile_image', $id_or_email);

			if(!empty($custom_avatar))
				$avatarfound = $custom_avatar;

			elseif(empty($custom_avatar)){
				//Returns the Local Avatar for ADMIN AREA
				$id = (int) $id_or_email;
				$custom_avatar = get_user_meta($id,'smartlib_profile_image',true);
				if(!empty($custom_avatar)){
					$avatarfound = $custom_avatar;
				}
			}
		}
		elseif ( !empty($id_or_email->user_id) ) {
			//Returns the Local Avatar for Comments
			$id = (int)  $id_or_email->user_id;


			$user = get_userdata($id);





			if ( isset($user)){
				//Returns the Local Avatar for comments if User has one
				$email = $user->user_email;
				$custom_avatar = get_user_meta($id,'smartlib_profile_image',true);
				$avatarfound = $custom_avatar;
			}
		}

		elseif ( !empty($id_or_email->comment_author_email) ) {
			//Returns the DEFAULT Local Avatar for comments
			$email = $id_or_email->comment_author_email;
			$avatarfound = $default;
		}

		if ($avatarfound =='')
			$avatarfound = $default;



		$avatar = "<img alt='{$safe_alt}' src='{$avatarfound}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		return $avatar;

	}


  function extened_user_social_fields(){
		$field_width_values = array();


		foreach($this->user_social_fields as $key =>$row){
			$value = get_the_author_meta($key);

			$rel = '';
			if(!empty($value)){
				if($key=='gplus'){ //check author rel (google headshot)
					$parse_array =  parse_url($value);

					if(isset($parse_array['query'])){
						parse_str($parse_array['query'], $output);

						if(!isset($output['rel']))
							$rel = '?rel=author';
					}else{
						$rel = '?rel=author';
					}
				}
				$field_width_values[$key] = $value.$rel;
			}
		}
		return $field_width_values;
	}



//add extra fields to category edit form callback function
	function extra_category_fields( $tag ) { //check for existing featured ID
		$cat_extra_data['kwota_zmniejszajaca'] = '';
		$cat_extra_data['kwota_wolna'] = '';
		$cat_extra_data['stawka_pierwsza'] = '';
		$cat_extra_data['stawka_druga'] = '';
		$cat_extra_data['kwota_drugi_prog'] = '';
		$cat_extra_data['ubezpieczenie_spoleczne'] = '';
		$cat_extra_data['ubezpieczenie_zdrowotne_stawka_2'] = '';
		$cat_extra_data['koszty_uzyskania'] = '';
		$cat_extra_data['wykonane_wydatki'] = '';
		$cat_extra_data['dochdowy_dla_gminy'] = '';
		$cat_extra_data['dochdowy_dla_powiatu'] = '';

		if(is_object($tag)){
			$term_id        = $tag->term_id;
			$cat_extra_data = get_option( 'taxonomy_' . $term_id );
		}
		?>
	<fieldset class="smartlib-fieldset">

		<h4><?php _e( 'Dane dotyczące roku podatkowego', 'smartlib' ); ?></h4>

		<div class="smartlib-form-block">
			<div class="smartlib-form-line">
				<label for="kwota_wolna" class="smartlib-radio-label"><?php _e( 'Kwota wolna od podatku', 'harmonux'); ?></label><input type="text" name="cat_extra_data[kwota_wolna]" id="kwota_wolna" style="float: left; width: auto" value="<?php echo isset($cat_extra_data['kwota_wolna'])?  $cat_extra_data['kwota_wolna'] : ''; ?>" ><br />
			</div>
			</div>
		<div class="smartlib-form-block">
			<div class="smartlib-form-line">
				<label for="stawka_pierwsza" class="smartlib-radio-label"><?php _e( 'Stwaka I próg podatkowy', 'harmonux'); ?></label><input type="text" name="cat_extra_data[stawka_pierwsza]" id="stawka_pierwsza" style="float: left; width: auto" value="<?php echo isset($cat_extra_data['stawka_pierwsza'])?  $cat_extra_data['stawka_pierwsza'] : ''; ?>" ><br />
			</div>
		</div>
		<div class="smartlib-form-block">
		<div class="smartlib-form-line">
			<label for="stawka_druga" class="smartlib-radio-label"><?php _e( 'Stwaka II próg podatkowy', 'harmonux'); ?></label><input type="text" name="cat_extra_data[stawka_druga]" id="stawka_druga" style="float: left; width: auto" value="<?php echo isset($cat_extra_data['stawka_druga'])?  $cat_extra_data['stawka_druga'] : ''; ?>" ><br />
		</div>
		</div>

		<div class="smartlib-form-block">
			<div class="smartlib-form-line">
				<label for="kwota_drugi_prog" class="smartlib-radio-label"><?php _e( 'Kwota drugi prog podatkowy', 'harmonux'); ?></label><input type="text" name="cat_extra_data[kwota_drugi_prog]" id="kwota_drugi_prog" style="float: left; width: auto" value="<?php echo isset($cat_extra_data['kwota_drugi_prog'])?  $cat_extra_data['kwota_drugi_prog'] : ''; ?>" ><br />
			</div>
		</div>

			<div class="smartlib-form-block">
			<div class="smartlib-form-line">
				<label for="kwota_zmniejszajaca" class="smartlib-radio-label"><?php _e( 'Kwota zmniejszająca podatek', 'harmonux'); ?></label><input type="text" name="cat_extra_data[kwota_zmniejszajaca]" id="kwota_zmniejszajaca" style="float: left; width: auto" value="<?php echo isset($cat_extra_data['kwota_zmniejszajaca'])?  $cat_extra_data['kwota_zmniejszajaca'] : ''; ?>" ><br />
			</div>
		</div>

		<div class="smartlib-form-block">
			<div class="smartlib-form-line">
				<label for="ubezpieczenie_spoleczne" class="smartlib-radio-label"><?php _e( 'Ubezpieczenie Społeczne - współczynnik', 'harmonux'); ?></label><input type="text" name="cat_extra_data[ubezpieczenie_spoleczne]" id="ubezpieczenie_spoleczne" style="float: left; width: auto" value="<?php echo isset($cat_extra_data['ubezpieczenie_spoleczne'])?  $cat_extra_data['ubezpieczenie_spoleczne'] : ''; ?>" ><br />
			</div>
		</div>
		<div class="smartlib-form-block">
			<div class="smartlib-form-line">
				<label for="ubezpieczenie_zdrowotne_stawka_2" class="smartlib-radio-label"><?php _e( 'Stawka % ubezpieczenie zdrowotne do odliczenia', 'harmonux'); ?></label><input type="text" name="cat_extra_data[ubezpieczenie_zdrowotne_stawka_2]" id="ubezpieczenie_zdrowotne_stawka_2" style="float: left; width: auto" value="<?php echo isset($cat_extra_data['ubezpieczenie_zdrowotne_stawka_2'])?  $cat_extra_data['ubezpieczenie_zdrowotne_stawka_2'] : ''; ?>" ><br />
			</div>
		</div>



		<div class="smartlib-form-block">
			<div class="smartlib-form-line">
				<label for="koszty_uzyskania" class="smartlib-radio-label"><?php _e( 'Koszty uzyskania', 'harmonux'); ?></label><input type="text" name="cat_extra_data[koszty_uzyskania]" id="koszty_uzyskania" style="float: left; width: auto" value="<?php echo isset($cat_extra_data['koszty_uzyskania'])?  $cat_extra_data['koszty_uzyskania'] : ''; ?>" ><br />
			</div>
		</div>

		<div class="smartlib-form-block">
		<div class="smartlib-form-line">
			<label for="wykonane_wydatki" class="smartlib-radio-label"><?php _e( 'Wykonane wydatki', 'harmonux'); ?></label><input type="text" name="cat_extra_data[wykonane_wydatki]" id="wykonane_wydatki" style="float: left; width: auto" value="<?php echo isset($cat_extra_data['wykonane_wydatki'])?  $cat_extra_data['wykonane_wydatki'] : ''; ?>" ><br />
		</div>
	</div>

		<div class="smartlib-form-block">
			<div class="smartlib-form-line">
				<label for="dochdowy_dla_gminy" class="smartlib-radio-label"><?php _e( 'Dochodowy dla gminy (współczynnik)', 'harmonux'); ?></label><input type="text" name="cat_extra_data[dochdowy_dla_gminy]" id="dochdowy_dla_gminy" style="float: left; width: auto" value="<?php echo isset($cat_extra_data['dochdowy_dla_gminy'])?  $cat_extra_data['dochdowy_dla_gminy'] : ''; ?>" ><br />
			</div>
		</div>

		<div class="smartlib-form-block">
			<div class="smartlib-form-line">
				<label for="dochdowy_dla_powiatu" class="smartlib-radio-label"><?php _e( 'Dochodowy dla powiatu (współczynnik)', 'harmonux'); ?></label><input type="text" name="cat_extra_data[dochdowy_dla_powiatu]" id="dochdowy_dla_powiatu" style="float: left; width: auto" value="<?php echo isset($cat_extra_data['dochdowy_dla_powiatu'])?  $cat_extra_data['dochdowy_dla_powiatu'] : ''; ?>" ><br />
			</div>
		</div>


	</fieldset>
	<?php
	}

// save extra category extra fields callback function

	public function save_extra_category_fileds( $term_id ) {

		if ( isset( $_POST['cat_extra_data'] ) ) {
			$term_id  = $term_id;
			$cat_meta = get_option( 'taxonomy_' . $term_id );
			$cat_keys = array_keys( $_POST['cat_extra_data'] );
			foreach ( $cat_keys as $key ) {
				if ( isset( $_POST['cat_extra_data'][$key] ) ) {
					$cat_meta[$key] = $_POST['cat_extra_data'][$key];
				}
			}
			//save the option array
			if ( isset( $cat_meta ) && ! update_option( 'taxonomy_' . $term_id, $cat_meta ) ) add_option( 'taxonomy_' . $term_id, $cat_meta );
		}
	}

	public function smartlib_add_extended_box() {

		$post_type = array( 'post', 'page' );

		foreach ( $post_type as $type ) {

			add_meta_box(
				'smartlib_extended_info',
				__( 'HarmonUX: Post additional content', 'harmonux'),
				array($this,'smartlib_display_extended_info'),
				$type
			);
		}
	}

	public function smartlib_display_extended_info( $post ) {

		//add wp_nonce_field in a fixed schema
		parent::add_nonce('smartlib_display_extended_info');

		$video_link = get_post_meta( $post->ID, '_smartlib_video_link', true );

		echo '<fieldset class="smartlib-fieldset"><h4>' . __( 'Video:', 'harmonux') . '</h4><div class="smartlib-form-block"><label for="embed_code_field">';
		_e( "Embed code:", 'harmonux');
		echo '</label> ';
		echo '<textarea id="embed_code_field" name="embed_code_field">' . esc_attr( $video_link ) . '</textarea><p class="smartlib-prompt">' . __( 'You can embed video from YouTube, Vimeo, DailyMotion or from another service', 'harmonux') . '</p></div></fieldset>';
	}


	/**
	 * ADD custom banner field
	 */
	function banner_code_header()
	{
		?>
	<hr />
	<table class="form-table">
		<tbody>
		<tr valign="top" class="hide-if-no-js">
			<th scope="row"><?php _e( 'Banner code:', 'harmonux'); ?></th>
			<td>
				<p>
					<textarea name="banner_code_header" style="width: 60%;height: 100px;"><?php echo  stripslashes(get_theme_mod( 'banner_code_header')) ; ?></textarea>
				</p>
				<p>
					<?php _e('You can add a banner code to the <strong>header</strong> of page', 'harmonux') ?>
				</p>
			</td>
		</tr>

		</tbody>
	</table>
	<?php
	}

	/*
	 * add smartlib custom header save hook
	 */

	function banner_code_header_save()
	{
		if ( isset( $_POST['banner_code_header'] ) )	{


			if ( current_user_can('manage_options') ) {


				set_theme_mod( 'banner_code_header', $_POST['banner_code_header'] );

			}
		}
		return;
	}

	/*Shortcodes helper Functions*/

	/**
	 * Push new buttons
	 *
	 * @param $buttons
	 *
	 * @return mixed
	 */
	function _push_mce_buttons($buttons){

		if(count($this->mce_buttons)>0){
			foreach($this->mce_buttons as $key=> $name)
				array_push( $buttons, $key, $name );
		}

		return $buttons;
	}

	function _add_buttons_scripts( $plugin_array ) {
		$plugin_array['smartlib'] = SMART_ADMIN_DIRECTORY_URI.'/js/editor.plugins.js';
		return $plugin_array;

	}

	function _add_filters_shortocode_buttons() {

		add_filter( "mce_external_plugins", array($this, '_add_buttons_scripts'));
		add_filter( 'mce_buttons', array($this, '_push_mce_buttons') );


	}



	function admin_area_enqueue_extend_styles(){
		wp_enqueue_style( 'admin_area_enqueue_styles', SMART_ADMIN_DIRECTORY_URI.'/css/css-admin-mod.css', array(), '1.0', false );
	}



}