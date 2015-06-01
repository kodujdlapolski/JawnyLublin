<?php

//initialize extended class - pass base __SMARTLIB::project() object
__SMARTLIB_EXT::init(__SMARTLIB::project());


/**
 * Print user profile fields - Google headshot support
 *
 */
function smartlib_ext_user_profile_fields(){
		/*
		 * Social Icons
		 */
		$profile_links = __SMARTLIB_EXT::extended_user_social_fields();

		if(count($profile_links)>0){
			?>
		<ul class="user-profiles inline-list">
			<?php
			foreach($profile_links as $key =>$row){
				?>
				<li><a href="<?php echo $row ?>"><i class="<?php echo __SMARTLIB::awesome_icon_class($key) ?>"></i></a></li>
				<?php
			}
			?>
		</ul>

		<?php

		}

}