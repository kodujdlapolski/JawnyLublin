<?php
/**
 * Template for displaying Author Archive pages.
 *
 */

get_header(); ?>

<main id="content" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">

    <?php if (have_posts()) : ?>

    <?php

    the_post();
    ?>

    <header class="archive-header">
        <h2 class="archive-title"><?php printf(__('Author Archives: %s', 'harmonux'), '<span class="vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta("ID"))) . '" title="' . esc_attr(get_the_author()) . '" rel="me">' . get_the_author() . '</a></span>'); ?></h2>
    </header><!-- .archive-header -->

    <?php
    /* Since we called the_post() above, we need to
                  * rewind the loop back to the beginning that way
                  * we can run the loop properly, in full.
                  */
    rewind_posts();
    ?>

    <?php
    // If a user has filled out their description, show a bio on their entries.
    if (get_the_author_meta('description')) : ?>
        <div class="author-info">
					<div class="author-avatar">
						<?php
						$user_image = get_the_author_meta( 'smartlib_profile_image',get_the_author_meta( 'ID' ) );
						if(!empty($user_image)){
							?>
							<img src="<?php echo $user_image ?>" alt="<?php printf( __( 'About %s', 'harmonux' ), get_the_author() ); ?>" />
							<?php
						}else
							echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'smartlib_author_bio_avatar_size', 68 ) ); ?>
					</div>
            <!-- .author-avatar -->
            <div class="author-description">
                <h2><?php printf(__('About %s', 'harmonux'), get_the_author()); ?></h2>

                <p><?php the_author_meta('description'); ?></p>
            </div>
            <!-- .author-description	-->
        </div><!-- .author-info -->
        <?php endif; ?>

    <?php /* Start the Loop */ ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('views/content','loop'); ?>
        <?php endwhile; ?>

    <?php smartlib_list_pagination('nav-below'); ?>

    <?php else : ?>
    <?php get_template_part('views/content', 'none'); ?>
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