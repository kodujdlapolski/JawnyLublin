<?php
//get queried term
$term = $wp_query->queried_object;
$tax  = null;//default material filter


//get parent category to select list
if ( isset( $term->parent ) && $term->parent != 0 ) {

$term_parent = get_term( $term->parent, 'gmcpt-kategoria' );

}
else {
$term_parent = $term;
}


if ( isset( $_POST['gmcpt-kategoria-form'] ) ) {
	$tax = $_POST['gmcpt-kategoria-form'];
}
elseif ( isset( $_COOKIE['gmcpt-kategoria-form'] ) ) {
	$tax = $_COOKIE['gmcpt-kategoria-form'];
}

?>
<div class="special-area gmcpt-special-area">
	<?php do_action('gmcpt_display_areas') ?>
</div>
<div id="wrapper" class="row">
	<div id="page" role="main" class="columns large-16">
		<main id="content" role="main" class="form-gmcpt">

			<form class="filter-list" action="<?php echo home_url( $wp->request ) ?>/" method="post" class="row">
				<div class="columns medium-3 large-3">
					<p class="select-container"><span>ROK: </span><?php
						smartlib_display_options_taxonomy_filtr( $term_parent, $term, 'gmcpt-rok', 'gmcpt-rok-form', '?gmcpt-rok=' );
						?></p>
				</div>
				<div class="columns medium-3 large-4">
					<p class="select-container"><span>RODZAJ: </span><?php
						smartlib_display_options_taxonomy_filtr( $term_parent, $tax, 'gmcpt-kategoria', 'gmcpt-kategoria-form', '?gmcpt-kategoria=', array(), 'category-filter', true );
						?></p>
				</div>
				<div class="columns medium-3 large-2">

				</div>
			</form>

		</main><!-- #content -->


	</div><!-- #page -->

</div><!-- #wrapper -->