<?php
/*
* Image row snippet
*/
?>

	<?php



	if ( '' != get_the_post_thumbnail() ) {
		?>
		<div class="smartlib-featured-image-container">

					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium-square' ); ?></a>

		</div>
		<?php
	}
	?>
