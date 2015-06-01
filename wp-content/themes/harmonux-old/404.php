<?php
/**
 * Template for displaying 404 pages (Not Found).
 */

get_header();

?>
<div id="wrapper" class="row">
<div id="page" role="main" class="columns large-16">
<main id="content" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog" class="<?php echo get_class_of_component('content') ?>" role="main" style='height: 500px'>
            	<h1><?php _e('Przepraszamy, tej strony jeszcze nie mamy', 'harmonux'); ?> [404]</h1>



</main><!-- #content -->


</div><!-- #page -->
</div><!-- #wrapper -->
<?php get_footer(); ?>