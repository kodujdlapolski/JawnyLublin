<!DOCTYPE html>
<!--[if lt IE 9]>
<html class="ie lt-ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php

    wp_head();
    ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-12583796-19', 'auto');
  ga('send', 'pageview');

</script>
</head>

<body <?php body_class(); ?>>
<?php smartlib_lt_ie7_info(); //display info if IE lower than 7  ?>
<div class="top-bar-outer">
<div id="top-bar" class="top-bar">
 <div class="top-bar-container">
	<div class="row">
		<div class="columns large-16">
			<!--falayout search menu-->
			<?php smartlib_searchmenu(); //display search menu ?>

			<nav id="top-navigation" class="left show-for-large-up">
				<a class="harmonux-wai-info harmonux-skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'harmonux' ); ?>"><?php _e( 'Skip to content', 'harmonux' ); ?></a>
				<?php wp_nav_menu( array( 'theme_location' => 'top_pages', 'menu_class' => 'harmonux-menu harmonux-top-menu' ) ); ?>
			</nav>

			<ul class="text-resize">
				<li class="size-small"><a href="#">A</a></li>
				<li class="size-medium"><a href="#">A</a></li>
				<li class="size-large"><a href="#">A</a></li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="columns large-16 smartlib-toggle-area" id="toggle-search">
			<?php smartlib_searchform(); //display toggle form search  ?>
		</div>
	</div>
	</div>
	<div class="logo-area">
			<div class="row">
					<div class="columns large-16">
						<?php
						/**
						 * Add Theme logo : template_tags
						 */
						smartlib_logo()
						?>
					</div>
				</div>
	</div>
</div>
</div>
<?php
	if(!is_front_page()){
?>
		<?php
	}
?>
<?php
		if ( is_page_template( 'page-kontakt.php' ) ) {
?>
			<div class="special-area">
				<div id="contact-map"></div>
			</div>
<?php
		}elseif(is_home()){
			?>
   <div class="special-area">

		 <div class="row">
			 <div class="columns large-12">
				 <img src="<?php echo get_template_directory_uri()?>/images/bg-fontpage-top.png" class="top-frontpage-photo" alt="Jawny Lublin" />
			 </div>
		 </div>

	 </div>
<?php
		}
?>
