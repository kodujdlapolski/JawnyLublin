<?php
add_action('admin_menu', 'harmonux_pro_menu');

function harmonux_pro_menu() {
add_theme_page('HarmonUX Premium', 'HarmonUX Premium', 'edit_theme_options', 'harmonux-premium', 'harmonux_info_function');
}
function harmonux_info_function(){
?>
<div class="wrap">
    <div id="icon-tools"class="icon32"><br></div>
    <h2>HarmonUX Premium</h2>
    <h3>Need extensive documentation and theme support? Learn more about HarmonUX Premium!</h3>
    <p><a href="http://www.mojo-themes.com/item/harmonux-clean-responsive-ux-focused-wordpress-theme/">HarmonUX Premium</a> adds exciting new customization features to the Theme Customizer and other powerful customization tools like shortcodes or layout options. </p>
    <div style="float: left; width: 50%"><p><img src="<?php echo get_template_directory_uri();?>/admin/css/img/presentation-harmonux.jpg" alt=""></p></div>
    <div style="float: left; width: 40%; margin-left: 5%; ">
        <div id="submitdiv" class="postbox " style="margin-top: 40px;min-height: 295px;">
            <h3 class="hndle" style="padding: 9px 10px;"><span><strong>HarmonUX [Premium Version]</strong></span></h3>
            <div class="inside">
                <div style="float: left;width: 60%">
                    <ul style="list-style: square; margin:15px 20px 30px 40px;">
                        <li>Options to alter the layout: 3 layout combinations</li>
                        <li>Customizable width of the layout and sidebar</li>
                        <li>Built-in useful Shortcodes</li>
                        <li>Easily customize elements colors using color picker</li>

                        <li>User profile picture</li>
                        <li>Extensive documentation and theme support</li>
											  <li>and more...</li>
                    </ul>
                </div>


                <a href="http://www.mojo-themes.com/item/harmonux-clean-responsive-ux-focused-wordpress-theme/" class="button button-primary" style="clear: both; margin-top: 110px" target="_blank"><strong>More info &raquo;</strong></a>
            </div>

        </div>
        <div class="float: left: clear: both; width: 100%"></div>
    </div>



</div>

<?php
}