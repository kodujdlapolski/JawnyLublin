<?php
/*
* Image row snippet
*/
?>

	<?php



	if ('' != get_the_post_thumbnail() ) {
		?>
		<div class="smartlib-single-image-container">

					<?php the_post_thumbnail( 'wide-image' ); ?>

		</div>
		<?php
	}
	?>
