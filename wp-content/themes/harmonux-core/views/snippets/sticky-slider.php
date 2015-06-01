<?php
/*Display sticky post in slider*/

$sticky = get_option( 'sticky_posts' );

$args = array(


'post__in' => $sticky,

);
$slider_news= new WP_Query( $args );
if($slider_news->have_posts()){
?>

<!-- Front Page Slider -->
<div class="smartlib-front-slider">
	<ul class="slides">
		<?php
		while($slider_news->have_posts()){
			$slider_news->the_post();
			?>
			<li>  <article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
				<div class="columns large-10 smartlib-slider-image-column">
					<?php

					if ( '' != get_the_post_thumbnail() ) {
						?>
						<div class="smartlib-featured-image-container">

							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'wide-image' ); ?></a>

						</div>
						<?php
					}
					?>


				</div>
				<div class="columns large-6">

					<div class="smartlib-featured-post-box">
						<?php harmonux_author_line(); ?>
						<header class="entry-header">
							<h3 class="entry-title">
								<a href="<?php the_permalink(); ?>"
									 title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'harmonux'), the_title_attribute('echo=0'))); ?>"
									 rel="bookmark"><?php the_title(); ?></a>
							</h3>
							<?php harmonux_display_meta_post('data'); ?>
						</header>
					</div>
				</div>
			</article>

			</li>
			<?php
		}
		?>
	</ul>
</div>
<!-- .End Front Page Slider -->
<?php

wp_reset_postdata();
}