<?php
/**
 * Template Name: Lista Infografik
 *
 */

get_header(); ?>
<div id="wrapper" class="row">
<div id="page" role="main" class="columns large-16">
<main id="content" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">
<h2 style="margin-bottom: 30px;"><?php the_title() ?></h2>
		<ul class="infograph-boxes">
    <?php

		$args = array(
			'post_type' => 'infografika',
			'posts_per_page' => 100
		);

	 $infographics = new WP_Query($args);


		while ($infographics->have_posts()) : $infographics->the_post();
			$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
			$image_attributes = wp_get_attachment_image_src( $post_thumbnail_id, 'full' ); // returns an array
		?>

   <li><a href="<?php the_permalink() ?>"><?php the_post_thumbnail('medium-square') ?></a></li>

    <?php endwhile; // end of the loop. ?>
		</ul>

</main><!-- #content -->


</div><!-- #page -->
</div><!-- #wrapper -->
<?php get_footer(); ?>