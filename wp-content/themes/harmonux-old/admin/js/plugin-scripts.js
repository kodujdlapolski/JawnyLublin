// Uploading files
var file_frame;


jQuery('.smartlib-upload-user-photo-btn').live( 'click', function (event) {

	event.preventDefault();


	var uploader_widget = jQuery(this);

// If the media frame already exists, reopen it.
	if (file_frame) {
		file_frame.open('id_editor');
		return;
	}

// Create the media frame.


	file_frame = wp.media.frames.file_frame = wp.media({
		title   :jQuery(this).data('uploader_title'),
		button  :{
			text:jQuery(this).data('uploader_button_text')
		},
		multiple:false // Set to true to allow multiple files to be selected
	});

// When an image is selected, run a callback.
	file_frame.on('select', function () {
// We set multiple to false so only get one image from the uploader
		attachment = file_frame.state().get('selection').first().toJSON();

		jQuery('#smartlib_profile_image').val(attachment.url);
		jQuery('.smartlib-user-image-container').addClass('custom-image-outer');
		jQuery('.smartlib-user-image-container img').attr('src', attachment.url);
		jQuery('.smartlib-user-image-container img').removeAttr('style');


	});

// Finally, open the modal
	file_frame.open();
});
