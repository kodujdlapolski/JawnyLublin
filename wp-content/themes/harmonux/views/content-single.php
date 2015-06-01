<?php
/**
 * The default template for displaying single content.
 *
 */
?>
<div class="post-box">
	<div class="row">
		<div class="columns large-2 medium-2">

		</div>
		<div class="columns large-14 medium-14">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<h2 class="entry-title"><?php the_title(); ?></h2>

				<div class="entry-content">
					<?php
					if(has_post_thumbnail()){
					?>
						<div class="logo-outer"><?php the_post_thumbnail('full') ?></div>
						<?php
					}
					?>
					<?php the_content(); ?>
				</div>

			</article>
		</div>
	</div>
	<!-- #post -->
</div><!-- .post-box -->
