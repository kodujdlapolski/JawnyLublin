<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */
?>
<div class="smartlib-post-box">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>




				<h3 class="entry-title">
					<a href="<?php the_permalink(); ?>"
						 title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'harmonux'), the_title_attribute('echo=0'))); ?>"
						 rel="bookmark"><?php the_title(); ?></a>
				</h3>

				<?php //smartlib_display_meta_post(); ?>


           <?php

					if (is_search()) : // Only display Excerpts for Search
						?>
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div><!-- .entry-summary -->
						<?php else : ?>
						<div class="entry-content">
							<?php the_content(__('Continue reading', 'harmonux') . ' <i class="fa fa-angle-right"></i>'); ?>

						</div><!-- .entry-content -->
						<?php endif; ?>



    </article>
    <!-- #post -->
</div><!-- .post-box -->
