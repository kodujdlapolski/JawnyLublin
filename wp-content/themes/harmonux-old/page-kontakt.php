<?php
/**
 * Template Name: Kontakt
 *
 */

get_header(); ?>
<div id="wrapper" class="row">
<div id="page" role="main" class="columns large-16">
<main id="content" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">


    <?php while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('page-content-area'); ?>>
			<?php the_content(); ?>
		</article>

    <?php endwhile; // end of the loop. ?>


</main><!-- #content -->


</div><!-- #page -->
</div><!-- #wrapper -->
<?php get_footer(); ?>