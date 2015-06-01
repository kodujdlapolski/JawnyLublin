<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */
?>
<div class="smartlib-post-box smartlib-post-large-box">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">

			<h3 class="entry-title">
				<a href="<?php the_permalink(); ?>"
					 title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'harmonux'), the_title_attribute('echo=0'))); ?>"
					 rel="bookmark"><?php the_title(); ?></a>
			</h3>

			<?php harmonux_display_meta_post(); ?>

		<!-- .entry-header -->
				<?php

				$post_format = get_post_format();
				if ('' != get_the_post_thumbnail()) {
					?>
					<div class="smartlib-thumbnail-outer"><a href="<?php the_permalink(); ?>"><?php harmonux_get_format_ico($post_format) ?><?php the_post_thumbnail('wide-image'); ?></a><?php harmonux_category_line(); ?></div>

					<?php
				}else{
					?>
					<?php harmonux_category_line(); ?>
						<?php
				}
        ?>
		</header>
<?php

				if (is_search()) : // Only display Excerpts for Search
					?>

					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->
					<?php else : ?>
					<div class="entry-content">
						<?php the_content(__('Continue reading', 'harmonux') . ' <i class="fa fa-angle-right"></i>'); ?>
						<?php harmonux_author_line(); ?>
					</div><!-- .entry-content -->
					<?php endif; ?>



		<!-- .entry-meta -->
	</article>
	<!-- #post -->
</div><!-- .post-box -->
