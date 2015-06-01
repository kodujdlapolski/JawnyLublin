<section id="sidebar" class="<?php echo get_class_of_component('sidebar') ?>">

    <ul id="secondary" class="widget-area medium-block-grid-2 small-block-grid-1 large-block-grid-1" role="complementary">
        <?php

			if(is_archive()){
				dynamic_sidebar('sidebar-4');
			}else if(is_single())
			dynamic_sidebar('sidebar-5');
				else
			dynamic_sidebar('sidebar-1');

			?>
    </ul><!-- #secondary -->

</section><!-- #sidebar .widget-area -->




