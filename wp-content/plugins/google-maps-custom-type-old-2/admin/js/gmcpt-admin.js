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

    }

     function gmcpt_admin_initialize_mamp() {
                        var myLatLng = new google.maps.LatLng(52.2,21);
                        MYMAP.init('#gmcpt_map', myLatLng, 7);
                    }

       // polygons variables
            var poly;
            var poly_markers = [];
            var poly_path = new google.maps.MVCArray;


            var MYMAP = {
                map: null,
                bounds: null
            }
            MYMAP.init = function(selector, latLng, zoom) {
                  var myOptions = {
                    zoom:zoom,
                    center: latLng,
                    zoomControl: true,
                    panControl: true,
                    mapTypeControl: true,
                    streetViewControl: true,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                  }
                this.map = new google.maps.Map(jQuery(selector)[0], myOptions);
                this.bounds = new google.maps.LatLngBounds();
                // polygons
                poly = new google.maps.Polygon({
                  strokeWeight: 3,
                  fillColor: '#66FF00'
                });
                poly.setMap(this.map);

                google.maps.event.addListener(this.map, 'click', addPoint);
                if($('#gmcpt_lat').length && $('#gmcpt_lat').val().length){
                    console.log('s');
                        addPolygon();
                }

            }

         function addPolygon() {
             var polygon_coordinates = jQuery("#gmcpt_lat").val();
             //polygon_coordinates = polygon_coordinates.substring(0,polygon_coordinates.length-1);
             polygon_coordinates = JSON.parse(polygon_coordinates);


             $.each(polygon_coordinates.j, function( k, v ) {
                 var temp_gps = new google.maps.LatLng(v.k, v.B);
                    addExistingPoint(temp_gps);
                    updatePolyPath(poly_path);
            });

              poly = new google.maps.Polygon({
                     strokeWeight: 3,
                  fillColor: '#66FF00'
                });
                poly.setMap(MYMAP.map);
                poly.setPaths(poly_path);
                google.maps.event.addListener(MYMAP.map, 'click', addPoint);
         }

              function addExistingPoint(temp_gps) {
                poly_path.insertAt(poly_path.length, temp_gps);
                var poly_marker = new google.maps.Marker({
                  position: temp_gps,
                  map: MYMAP.map,
                  draggable: true
                });
                poly_markers.push(poly_marker);
                poly_marker.setTitle("#" + poly_path.length);
                google.maps.event.addListener(poly_marker, 'click', function() {
                      poly_marker.setMap(null);
                      for (var i = 0, I = poly_markers.length; i < I && poly_markers[i] != poly_marker; ++i);
                      poly_markers.splice(i, 1);
                      poly_path.removeAt(i);
                      updatePolyPath(poly_path);
                      }
                    );

                    google.maps.event.addListener(poly_marker, 'dragend', function() {
                      for (var i = 0, I = poly_markers.length; i < I && poly_markers[i] != poly_marker; ++i);
                      poly_path.setAt(i, poly_marker.getPosition());
                      updatePolyPath(poly_path);
                      }
                    );
            }
    function addPoint(event) {

                    var path = poly.getPath();
                    path.push(event.latLng);

                    var poly_marker = new google.maps.Marker({
                      position: event.latLng,
                      map: MYMAP.map,
                      draggable: true
                    });



                    poly_markers.push(poly_marker);
                    poly_marker.setTitle("#" + path.length);

                    google.maps.event.addListener(poly_marker, 'click', function() {
                      poly_marker.setMap(null);
                      for (var i = 0, I = poly_markers.length; i < I && poly_markers[i] != poly_marker; ++i);
                      poly_markers.splice(i, 1);
                      path.removeAt(i);
                      updatePolyPath(path);
                      }
                    );

                    google.maps.event.addListener(poly_marker, 'dragend', function() {
                      for (var i = 0, I = poly_markers.length; i < I && poly_markers[i] != poly_marker; ++i);
                      path.setAt(i, poly_marker.getPosition());
                      updatePolyPath(path);
                      }
                    );


                    updatePolyPath(path);
              }

              function updatePolyPath(poly_path) {
                var temp_array;
                temp_array = "";
                poly_path.forEach(function(latLng, index) {
               temp_array = temp_array + " ["+ index +"] :"+ latLng + ", ";

                   console.log(latLng)
                 // temp_array = temp_array + latLng + ":";
                });
                jQuery("#gmcpt_lat").val(JSON.stringify(poly_path));
              }

})( jQuery );
