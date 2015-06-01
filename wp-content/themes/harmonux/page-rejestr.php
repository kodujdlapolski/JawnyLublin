<?php
/**
 * Template Name: Rejestr Umów
 *
 */

get_header(); ?>
<div id="wrapper" class="row">
<main id="content">

	<?php while (have_posts()) : the_post(); ?>
	<?php the_content() ?>
	<iframe src="http://trup.siecobywatelska.pl/#/home/1" width="1140" height="600" class="iframe-rejestr"></iframe>
	<?php endwhile; // end of the loop. ?>



</main><!-- #content -->


</div><!-- #page -->


</div><!-- #wrapper -->
<?php get_footer(); ?>