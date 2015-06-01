<?php
/**
 * Template Name: Kalkulator
 *
 */

get_header();
$args = array();
$calc_terms = get_the_terms( $post->ID, 'year' );
if(is_array($calc_terms)&& count($calc_terms)>0){
foreach($calc_terms as $term){
	$term_id = $term->term_id;
}
$args = array(
	'post_type' => 'budget',
	'posts_per_page' => 1000,
	'post_parent' => 0,
	'order_by' => 'date',
	'order' => 'ASC',
	'tax_query' => array(
		array(
		'taxonomy' => 'year',
		'terms' => $term_id,
		'field' => 'term_id'
	)),
);
}
$query =  new WP_Query($args);
?>
<div id="wrapper" class="row">
<div id="page" role="main" class="columns large-16">
<main id="content">
	<div class="set-sallary-area">
		<?php
		/* Start the Loop */
			while (have_posts()) : the_post();
				?>
       <?php the_content() ?>
			<?php
			endwhile;
			?>
	  <div class="noUiSlider sallary_scroll" rel="sallary_scroll" year_param="1"></div>
		<div class="outer-slider-range"><input type="text" class="slider-range-input"  readonly="readonly" id="sallary_scroll_field" class="range-customize-input" value="1200" /><span>zł</span></div>
		<div class="period-menu-outer">
		<p>Okres: </p>
		<ul class="period-menu">
			<li class="per-month-period" year_param="0"><a href="#">miesięcznie</a></li>
			<li class="per-year-period default" year_param="1"><a href="#">rocznie</a></li>
		</ul>
		</div>
		<p style="clear: both">podatek, który trafia do budżetu miasta:</p>
		<p class="tax-ammount"><span>52.30</span> zł</p>
		<p>w tym na:</p>
	</div>
	<div class="row smartlib-category-row">
		<ul class="expenses-list">
			<?php
			/* Start the Loop */
			while ($query->have_posts()) : $query->the_post();
				$thumbnail = get_the_post_thumbnail($post->ID,'full');
				?>
				<li data-amount-budget="<?php echo (int)get_post_meta( $post->ID, 'budget_ammount', true ); ?>">
					<?php echo $thumbnail ?>
					<h4><?php the_title(); ?></h4>
					<div class="data-amount-info"><span>0</span> zł</div>
				</li>
				<?php

			endwhile;
			?>
		</ul>
	</div>




</main><!-- #content -->


</div><!-- #page -->

<?php
//add sidebar on the right side
if(check_position_of_component('sidebar', 'right'))
	get_sidebar();
?>
</div><!-- #wrapper -->
<?php get_footer(); ?>