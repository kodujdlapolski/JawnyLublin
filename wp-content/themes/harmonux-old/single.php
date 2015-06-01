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

    <?php
    if (get_post_format()) {
        get_template_part('views/content', get_post_format());
    } else {
        get_template_part('views/content', 'single');
    }
    ?>
    <?php endwhile; // end of the loop. ?>

</main><!-- #content -->
</div><!-- #page -->
<section id="sidebar" class="columns large-4">

	<?php
	$post_type = get_post_type( $post );
	$post_id = $post->ID;
  	$args = array(
		'posts_per_page' => 1000,
     'order' => "ASC",
		'post_type' => $post_type,
	);

	$siblings = new WP_Query($args);
	if($siblings->have_posts()):
		?>
			<ul class="pages-menu">
			<?php
	while($siblings->have_posts()): $siblings->the_post();
  ?>
		<?php
		if($post_id==$post->ID){
			?>
			<li><a href="<?php the_permalink() ?>" style="font-weight: bold;"><?php the_title() ?></a></li>
				<?php
		}else{
			?>
			<li><a href="<?php the_permalink() ?>" ><?php the_title() ?></a></li>
				<?php
		}
?>


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