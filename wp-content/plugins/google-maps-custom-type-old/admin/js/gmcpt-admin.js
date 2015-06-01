(function( $ ) {
	'use strict';

	$(document).ready(function(){
				gmcpt_admin_initialize_mamp();
			}
			);


	/**
	 * All of the code for your Dashboard-specific JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */
	function gmcpt_admin_initialize_mamp() {
		var mapOptions = {
			center: { lat: 52.2, lng: 21},
			zoom: 7
		};
		var map = new google.maps.Map(document.getElementById('gmcpt_map'),
				mapOptions);



	var drawingManager = new google.maps.drawing.DrawingManager({
		drawingMode: google.maps.drawing.OverlayType.POLYGON,
		drawingControl: true,
		drawingControlOptions: {
			position: google.maps.ControlPosition.TOP_CENTER,
			drawingModes: [
				google.maps.drawing.OverlayType.MARKER,
				google.maps.drawing.OverlayType.CIRCLE,
				google.maps.drawing.OverlayType.POLYGON,
				google.maps.drawing.OverlayType.POLYLINE,
				google.maps.drawing.OverlayType.RECTANGLE
			]
		},

		circleOptions: {
			fillColor: '#ffff00',
			fillOpacity: 1,
			strokeWeight: 5,
			clickable: false,
			editable: true,
			zIndex: 1
		}
	});

		google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
			var coordinates = (polygon.getPath().getArray());
			console.log(coordinates);
		});
	drawingManager.setMap(map);
		drawingManager.setPath([{"21.329035778926478","73.46008301171878"},{"lat":"21.40065516914794","lng":"78.30505371484378"},{"lat":"20.106233605369603","lng":"77.37121582421878"},{"lat":"20.14749530904506","lng":"72.65808105859378"}])

	}

})( jQuery );
