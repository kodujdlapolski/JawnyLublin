<?php
/**
 * MaxFlat main template file.
 *
 *
 *
 * @since      MaxFlat 1.0
 */

get_header(); ?>
<div id="wrapper" class="row">


<div id="page" role="main" class="columns large-16">
<main id="content" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">
	<?php wp_nav_menu( array( 'theme_location' => 'home_page_menu', 'menu_class' => 'harmonux-menu harmonux-homepage-menu' ) ); ?>
	<div class="homepage-content">
	<p class="site-description"><?php echo get_bloginfo( 'description' );?></p>
  <img src="<?php echo get_template_directory_uri()?>/images/img-frontpage-chart.png" class="homepage-chart" alt="Home Page Chart" />
	</div>
</main><!-- #content -->



</div><!-- #page -->

</div><!-- #wrapper -->
<div class="homepage-footer">
	<div class="row">
		<div class="columns large-16">
			<img src="<?php echo get_template_directory_uri()?>/images/img-fio.png" alt="Fundusz Inicjatyw Obywatelskich" />
			<p>Projekt dofinansowany ze środków Programu Fundusz Inicjatyw Obywatelskich </p>
		</div>
	</div>
</div>
<?php get_footer(); ?>
