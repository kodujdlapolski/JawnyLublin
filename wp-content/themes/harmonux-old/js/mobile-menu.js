jQuery(document).ready(function () {
    jQuery(".mobile-menu").change(function () {
        window.location = jQuery(this).find("option:selected").val();
    });
});
