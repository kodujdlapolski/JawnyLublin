<?php
/**
 * Template for displaying Search Results pages.
 */

get_header(); ?>

<main id="content" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">

    <?php if (have_posts()) : ?>

    <header class="page-header">
        <h1 class="archive-title"><?php printf(__('Search Results for: %s', 'harmonux'), '<span>' . get_search_query() . '</span>'); ?></h1>
    </header>



    <?php /* Start the Loop */ ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('views/content', 'loop'); ?>
        <?php endwhile; ?>

    <?php  harmonux_list_pagination('nav-below'); ?>

    <?php else : ?>

    <article id="post-0" class="post no-results not-found">
        <header class="entry-header">
            <h2 class="entry-title"><?php _e('Nothing Found', 'harmonux'); ?></h2>
        </header>

        <div class="entry-content">
            <p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'harmonux'); ?></p>
            <?php get_search_form(); ?>
        </div>
        <!-- .entry-content -->
    </article>

    <?php endif; ?>

</main><!-- #content -->

</div><!-- #page -->

<?php
//add sidebar on the right side
if(check_position_of_component('sidebar', 'right'))
	get_sidebar();
?>
</div><!-- #wrapper -->
<?php get_footer(); ?>