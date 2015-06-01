<?php
/**
 * MaxFlat main template file.
 *
 *
 *
 * @since      MaxFlat 1.0
 */

get_header(); ?>


<main id="content" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">
	<?php
    /* Get all sticky posts */
	$sticky = get_option( 'sticky_posts' );
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

	if(harmonux_version_homepage()=='1'){


	//if slider based on sticky post

	  if(harmonux_version_slider()==1){
		 get_template_part('views/snippets/sticky-slider');

		 /* if sticky post in slider above ommit sticky post*/
		 $args = array(


			 'post___not_in' => $sticky,
			 'ignore_sticky_posts' => 1,
			 'paged' => $paged

		 );

	 }else{

		 harmonux_get_homepage_slider();

		 $args = array(
			 'paged' => $paged

		 );
	 }



	$news= new WP_Query( $args );

	if ( $news->have_posts() ) : ?>
<ul class="small-block-grid-1 large-block-grid-2 smartlib-grid-list">
	<?php /* start the loop */ ?>
	<?php while ( $news->have_posts() ) : $news->the_post(); ?>
			<li>	<?php
			get_template_part( 'views/content'); ?>

			</li>
		<?php endwhile;
?>
</ul>
			<?php
	harmonux_list_pagination( 'nav-below' );

	?>
	<?php else : ?>
	<article id="post-0" class="post no-results not-found">

	<?php get_template_part( 'views/content', 'none'); ?>
	</article>
	<?php endif; // end have_posts() check ?>


	 <?php
 }else{

	 if ( have_posts() ) : ?>
	 <ul class="small-block-grid-1 large-block-grid-2 smartlib-grid-list">
		 <?php /* start the loop */ ?>
		 <?php while (have_posts() ) : the_post(); ?>
		 <li>	<?php
			 get_template_part( 'views/content'); ?>

		 </li>
		 <?php endwhile;
		 ?>
	 </ul>
	 <?php
	 harmonux_list_pagination( 'nav-below' );

	 ?>
	 <?php else : ?>
	 <article id="post-0" class="post no-results not-found">

		 <?php get_template_part( 'views/content', 'none'); ?>
	 </article>
	 <?php endif; // end have_posts() check ?>
		 <?php
 }
?>
</main><!-- #content -->



</div><!-- #page -->

<?php
//add sidebar on the right side
if(check_position_of_component('sidebar', 'right'))
	get_sidebar();
?>
</div><!-- #wrapper -->
<?php get_footer(); ?>
