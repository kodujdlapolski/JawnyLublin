<?php
/*
 * Author info snippet
 */
?>

<div class="author-avatar">
	<?php
	$user_image = get_the_author_meta( 'smartlib_profile_image',get_the_author_meta( 'ID' ) );
	if(!empty($user_image)){
		?>
			<img src="<?php echo $user_image ?>" alt="<?php printf( __( 'About %s', 'smartlib' ), get_the_author() ); ?>" />
			<?php
	}else
	echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'smartlib_author_bio_avatar_size', 68 ) ); ?>
</div>
<!-- .author-avatar -->
<div class="author-description">
	<h2><?php printf( __( 'About %s', 'smartlib' ), '<span itemprop="name">'.get_the_author().'</span>' ); ?></h2>

	<p itemprop="description"><?php the_author_meta( 'description' ); ?></p>

</div><!-- .author-description -->
<div class="row">
	<div class="columns ten">
<?php  smartlib_ext_user_profile_fields() ?>
	</div>
	<div class="columns six">
		<div class="author-link">
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( __( 'View all posts by %s <span class="icon-chevron-sign-right"></span>', 'smartlib' ), get_the_author() ); ?>
			</a>

		</div>	<!-- .author-link	-->
	</div>

</div>