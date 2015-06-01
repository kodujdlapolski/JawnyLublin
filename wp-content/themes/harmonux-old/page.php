<?php
/**
 * The template for displaying all pages.
 *
 */

get_header(); ?>
<div id="wrapper" class="row">
<div id="page" role="main" class="columns large-16">
<main id="content" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">


    <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('views/content', 'page'); ?>

    <?php endwhile; // end of the loop. ?>


</main><!-- #content -->


</div><!-- #page -->
</div><!-- #wrapper -->
<?php get_footer(); ?>