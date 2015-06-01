<?php
/**
 * Template for displaying 404 pages (Not Found).
 */

get_header(); ?>

<main id="content" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" role="main">

	<div class="entry-content">
		<p><?php _e('Apologies, but no results were found. Perhaps searching will help find a related post.', 'harmonux'); ?></p>
		<?php get_search_form(); ?>
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