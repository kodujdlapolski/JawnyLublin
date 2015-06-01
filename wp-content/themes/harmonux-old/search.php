<?php
/**
 * Template for displaying Search Results pages.
 */

get_header(); ?>

<div id="wrapper" class="row">
<div id="page" role="main" class="columns large-16">
<main id="content" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">
    <?php /* Start the Loop */



  if(have_posts()):
    while (have_posts()) : the_post(); ?>
        <?php get_template_part('views/content', 'loop'); ?>
        <?php endwhile; ?>

    <?php  smartlib_list_pagination('nav-below'); ?>

    <?php else : ?>

    <article id="post-0" class="post no-results not-found">
        <header class="entry-header">
            <h2 class="entry-title"><?php _e('Brak wyników', 'harmonux'); ?></h2>
        </header>

        <div class="entry-content">
            <p><?php _e('Brak wyników wyszukiwania spełniajacych podane warunki', 'harmonux'); ?></p>
            <?php get_search_form(); ?>
        </div>
        <!-- .entry-content -->
    </article>

    <?php endif; ?>

</main><!-- #content -->


</div><!-- #page -->
</div><!-- #wrapper -->
<?php get_footer(); ?>