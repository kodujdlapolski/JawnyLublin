<?php
/**
 * The template for displaying posts in the Link post format
 */
?>
<div class="post-box">
	<div class="row">
		<div class="columns large-2 medium-2">
			<?php
			if(function_exists('wpsocialite_markup')){
				?>
				<div class="smartlib-soical-widgets">
					<?php	wpsocialite_markup(); ?>
				</div>
				<?php
			}
			?>


		</div>
		<div class="columns large-14 medium-2">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php smartlib_display_meta_post('date'); ?>
				</header>


				<div class="entry-content">
				<?php the_content(); ?>
				</div>


			</article>
		</div>
	</div>
	<!-- #post -->
</div><!-- .post-box -->

