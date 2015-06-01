<div class="row smartlib-footer-widget-area">
    <ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">
        <?php
        if (is_front_page()) {
            dynamic_sidebar('sidebar-2');
        } else {
            dynamic_sidebar('sidebar-3');
        }


        ?>
    </ul>
</div>
