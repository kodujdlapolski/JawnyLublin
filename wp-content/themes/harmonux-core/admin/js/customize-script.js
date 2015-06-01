jQuery(document).ready(function ($) {


	$(".harmonux_project_layout_width").noUiSlider({

		range:[900, 1280], slide:triggerChange, start:$("#harmonux_project_layout_width").val(), handles:1, step: 1, serialization:{
			to:$("#harmonux_project_layout_width"),  resolution: 1
		}

	});

	$(".harmonux_project_sidebar_resize").noUiSlider({

		range:[250, 350], slide:triggerChange, start:$("#harmonux_project_sidebar_resize").val(), handles:1, step: 1, serialization:{
			to:$("#harmonux_project_sidebar_resize"), resolution: 1
		}

	});


});

function triggerChange() {
	jQuery('input').change();






}