<?php
/**
 * The template for displaying Archive pages.
 */

get_header();


?>
<div id="wrapper" class="row">
<main id="content" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">


	<?php if (have_posts()) : ?>
	<header class="archive-header">
		<h1 class="archive-title"><?php
			if (is_day()) :
				printf(__('Daily Archives: %s', 'harmonux'), '<span>' . get_the_date() . '</span>'); elseif (is_month()) :
				printf(__('Monthly Archives: %s', 'harmonux'), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'harmonux')) . '</span>');
			elseif (is_year()) :
				printf(__('Yearly Archives: %s', 'harmonux'), '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'harmonux')) . '</span>');
			else :
				_e('Archives', 'harmonux');
			endif;
			?></h1>

		<?php if (category_description()) : // Show an optional category description ?>
		<div class="archive-meta"><?php echo category_description(); ?></div>
		<?php endif; ?>
	</header><!-- .archive-header -->
	<?php
	$category_template = smartlib_template_category_loop();
	?>
	<div class="row smartlib-category-row <?php echo $category_template ?>">
		<?php

		global $wp_query;

		if(isset($wp_query->query_vars['posts_per_page'])){
			$limit = $wp_query->query_vars['posts_per_page'];
		}else{
			$limit = 10;
		}
		$all_posts = $wp_query->post_count;
		$i = 1;
		$j = 1;
		/* Start the Loop */
		while (have_posts()) : the_post();
			if ( $i == 1 && $category_template=='loop-2columns') {
				echo '<div class="row smartlib-box-line">';
			}
			/* Include the post format-specific template for the content. If you want to
												 * this in a child theme then include a file called called content-___.php
												 * (where ___ is the post format) and that will be used instead.
												 */

			get_template_part('views/content');

			if($category_template=='loop-2columns'){
				if ( $i % 2 == 0 || $j == $limit || $j == $all_posts ) {

					echo '</div>';

					$i = 1;
				}
				else {
					$i ++;
				}

				$j ++;
			}
		endwhile;
		?>
	</div>
	<?php
	smartlib_list_pagination('nav-below');
	?>

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