<?php
/**
 * The Template for displaying all single posts.
 */

get_header();
$category = get_the_category();
?>
<div id="wrapper" class="row">
<div id="page" role="main" class="columns large-12">
<main id="content" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog"  role="main">

    <?php while (have_posts()) : the_post(); ?>

	<div class="post-box">
		<div class="row">
			<div class="columns large-2 medium-2">

			</div>
			<div class="columns large-14 medium-14">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


					<div class="entry-content">
						<?php the_content(); ?>
					</div>

				</article>
			</div>
		</div>
		<!-- #post -->
	</div><!-- .post-box -->

	<?php endwhile; // end of the loop. ?>

</main><!-- #content -->
</div><!-- #page -->
<section id="sidebar" class="columns large-4">

	<?php
	$post_type = get_post_type( $post );
	$post_id = $post->ID;
  	$args = array(
		'posts_per_page' => 1000,
		'post__not_in' => array($post_id),
		'post_type' => $post_type,
	);

	$siblings = new WP_Query($args);
	if($siblings->have_posts()):
		?>
			<ul class="pages-menu">
			<?php
	while($siblings->have_posts()): $siblings->the_post();
  ?>
			<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
			<?php
		endwhile;
	?>

	<?php
		endif;
	?>
</ul>
</section><!-- #sidebar .widget-area -->
</div><!-- #wrapper -->
<?php get_footer(); ?>