<?php
/**
 * The template used for displaying page content in page.php
 */
?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('page-content-area'); ?>>

					<h2 class="entry-title"><?php the_title(); ?></h2>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>

			</article>

	<!-- #post -->
</div><!-- .post-box -->
