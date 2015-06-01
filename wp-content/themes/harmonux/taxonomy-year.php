<?php
/**
 * The template for displaying Category pages.
 */

get_header();

$queried_object = get_queried_object();

$term_id = $queried_object->term_id;

?>
<div id="wrapper" class="row">
<div id="page" role="main" class="columns large-16">
<main id="content" role="main">
	<header class="page-header">
		<?php if (category_description()) : // Show an optional category description ?>
		<div class="header-description"><?php echo category_description(); ?></div>
		<?php endif; ?>
	</header><!-- .archive-header -->
	<?php
	$args = array(
		'post_type' => 'budget',
		'posts_per_page' => 1000,
		'post_parent' => 0,
		'order_by' => 'date',
		'order' => 'ASC',
		'tax_query' => array(array(
			'taxonomy' => 'year',
			'terms' => $term_id,
			'field' => 'term_id'
		)),
	);

	$main_categories = new WP_Query($args);

	$terms = get_terms( 'year' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		echo '<ul class="year-menu"><li>Rok: </li>';


		foreach ( $terms as $term ) {

			$class_string = ($term->term_id==$term_id)? ' class="actual_year"':'';
			echo '<li'.$class_string.'><a href="'.get_term_link($term).'">' . $term->name . '</a></li>';

		}
		echo '</ul>';
	}
?>

    <?php if ($main_categories->have_posts()) : ?>


<div class="row smartlib-category-row">
   <ul class="budget-expenses-list">
    <?php
		  /* Start the Loop */
	while ($main_categories->have_posts()) : $main_categories->the_post();

		$all_category_sum = (float)get_post_meta( $post->ID, 'budget_ammount', true );
		$thumbnail = get_the_post_thumbnail($post->ID,'full');
		$title = get_the_title();

		$args = array(
			'post_type' => 'budget',
			'posts_per_page' => 1000,
			'post_parent' => $post->ID,
			'order_by' => 'date',
			'order' => 'ASC',
			'tax_query' => array(
				'taxonomy' => 'year',
				'terms' => $term_id,
				'field' => 'term_id'
			),
		);

		$sub_query = $sub_query_chart = new WP_Query($args);

		?>
		<li data-amount-budget="<?php echo (int)get_post_meta( $post->ID, 'budget_ammount', true ); ?>">
			<?php echo $thumbnail ?>
			<h4><?php echo $title; ?></h4>
			<p class="data-amount-info"><span><?php echo $all_category_sum; ?></span> zł</p>
			<?php
				if($sub_query_chart->have_posts()){
					?>
					<div class="budget-expenses-window">
							<header class="budget-expenses-header">
								<?php echo  $thumbnail; ?>
								<h3><?php echo $title ?></h3>
							</header>
						<ul class="budget-chart">
							<?php
							/* Start the Loop */
							while ($sub_query_chart->have_posts()) : $sub_query_chart->the_post();
								$sub_ammount =   (float)get_post_meta( $post->ID, 'budget_ammount', true );
								$height_value = $sub_ammount/$all_category_sum*250;

								if($height_value>0){
								?>
								<li style="height:<?php echo $height_value ?>px; width: 30px;background: #0eb1f2; margin-top: <?php echo 250-$height_value ?>px"><p class="description-chart"><?php the_title(); ?></p></li>
								<?php
									}else{
									?>
									<li style="height:<?php echo $height_value *(-1) ?>px; width: 30px;background: #0eb1f2; margin-top: <?php echo 250 ?>px"><p class="description-chart" style="top: -120px"><?php the_title(); ?></p></li>
									<?php
								}
							endwhile;
							?>
						</ul>
				 <ul class="chart-legend">

					 <?php
					/* Start the Loop */
				while ($sub_query->have_posts()) : $sub_query->the_post();
				  $sub_ammount =   (int)get_post_meta( $post->ID, 'budget_ammount', true );
					?>
					<li><h4><?php the_title(); ?></h4>
						<em> zł</em><p><?php echo $sub_ammount ?></p></li>
				<?php
				endwhile;
				?>
					 <li class="last-line">
						 <h4><strong>Suma:</strong></h4>
						 <em> zł</em><p><?php echo $all_category_sum; ?></p>
					 </li>
				 </ul>

						</div>
						<?php
				}
			?>
			</li>
		<?php

    endwhile;
?>
	 </ul>
		</div>
		<?php
         //smartlib_list_pagination('nav-below');
    ?>

    <?php else : ?>
    <p>Brak pozycji</p>
    <?php endif; ?>

</main><!-- #content -->


</div><!-- #page -->

</div><!-- #wrapper -->
<?php get_footer(); ?>