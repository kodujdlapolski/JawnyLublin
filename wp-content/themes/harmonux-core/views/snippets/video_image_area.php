<?php
/*
* Video row snippet
*/

$video_link = get_post_meta( $post->ID, '_harmonux_video_link', true );
	if ( ! empty( $video_link ) ) {
		?>
	<div class="smartlib-video-container">
		<?php echo $video_link; ?>
	</div>
	<?php
	}else if ('' != get_the_post_thumbnail() ) {
?>
<div class="smartlib-single-image-container">

	<?php the_post_thumbnail( 'wide-image' ); ?>

</div>
<?php
}
?>