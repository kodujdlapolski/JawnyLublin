<?php
$term =	$wp_query->queried_object;

get_header();

?>
<div id="wrapper" class="row">
	<div id="page" role="main" class="columns large-16">
		<main id="content" class="chart-content" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">
			<h2><?php echo $term->name ?></h2>
			<?php if (category_description()) : // Show an optional category description ?>
			<div class="archive-meta"><?php echo category_description(); ?></div>
			<?php endif; ?>
			<img src="<?php echo get_template_directory_uri()?>/images/img-chart-header.png" class="chart-header" alt="Wykres Nagłówek" />
      <div class="chart-area">
				<div class="chart-positions">
			<?php while (have_posts()) : the_post(); ?>
			<span class="chart-point" style="left: <?php echo get_post_meta( $post->ID, 'axis_x', true ) ?>px; bottom: <?php echo get_post_meta( $post->ID, 'axis_y', true ) ?>px">
				<em class="charpoint-description"><?php the_title(); ?><br /><?php echo get_post_meta( $post->ID, 'axis_x', true ) ?>/<?php echo get_post_meta( $post->ID, 'axis_y', true ) ?></em>
			</span>

			<?php endwhile; // end of the loop. ?>
			</div>
			</div>
		</main><!-- #content -->


	</div><!-- #page -->
</div><!-- #wrapper -->
<?php get_footer(); ?>