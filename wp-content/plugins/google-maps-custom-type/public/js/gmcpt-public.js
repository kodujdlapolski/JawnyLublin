(function( $ ) {
	'use strict';

		$(document).ready(function(){
				if($('#gmcpt_map').length>0){
					gmcpt_initialize_mamp();
				}

                //console.log(gmcpt_maps_areas);
			}
			);


	// polygons variables



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
										scrollwheel: false,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                  }
                this.map = new google.maps.Map(jQuery(selector)[0], myOptions);
                this.bounds = new google.maps.LatLngBounds();
                // polygons

                   var maps_areas = JSON.parse(gmcpt_maps_areas);
                //google.maps.event.addListener(this.map, 'click', addPoint);

                 for (var i = 0; i <  maps_areas.length; i++) {

                     addPolygon(this.map,  maps_areas[i]);
                  }


            }

         function addPolygon(map, polygon_coordinates) {

              var poly;
              var poly_markers = [];
              var poly_path = new google.maps.MVCArray;


              poly = new google.maps.Polygon({
                  strokeWeight: 3,
                  fillColor: '#66FF00'
                });
                poly.setMap(map);

             $.each(polygon_coordinates.area_points.j, function( k, v ) {
                 var temp_gps = new google.maps.LatLng(v.k, v.B);
                    addExistingPoint(poly_path,poly_markers,temp_gps, polygon_coordinates);
                    updatePolyPath(poly_path);
            });

              poly = new google.maps.Polygon({
                     strokeWeight: 3,
                  fillColor: '#66FF00'
                });
                poly.setMap(MYMAP.map);
                poly.setPaths(poly_path);
					 google.maps.event.addListener(poly, 'click', function (event) {
						 show_place_window(polygon_coordinates['area_name'],polygon_coordinates['area_content']);
					 });
				 }

              function addExistingPoint(poly_path, poly_markers,  temp_gps, polygon_coordinates) {
                poly_path.insertAt(poly_path.length, temp_gps);
                var poly_marker = new google.maps.Marker({
                  position: temp_gps,
                  map: MYMAP.map,
                  draggable: false
                });
                poly_markers.push(poly_marker);
								google.maps.event.addListener(poly_marker, 'click', function (event) {
									show_place_window(polygon_coordinates['area_name'],polygon_coordinates['area_content']);
								});
            }
    function addPoint(event) {

                    var path = poly.getPath();
                    path.push(event.latLng);

                    var poly_marker = new google.maps.Marker({
                      position: event.latLng,
                      map: MYMAP.map,
                      draggable: false
                    });



                    poly_markers.push(poly_marker);
                    poly_marker.setTitle("#" + path.length);

                     /*
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
                     */

                    updatePolyPath(path);
              }

              function updatePolyPath(poly_path) {
                var temp_array;
                temp_array = "";
                poly_path.forEach(function(latLng, index) {
               temp_array = temp_array + " ["+ index +"] :"+ latLng + ", ";


                 // temp_array = temp_array + latLng + ":";
                });

              }
	function gmcpt_initialize_mamp() {

       var myLatLng = new google.maps.LatLng(51.240,22.550);
                        MYMAP.init('#gmcpt_map', myLatLng, 12);

    }

	function show_place_window(title, content) {
		var $overlay = $('<div class="overlay-places"></div>');
		var $window = $('<div class="window-place"><h4>'+title+'</h4><div class="description-place">'+content+'</div></div>');
		var $close = $('<a class="btn-close-window" href="#">close</a>');
		var method = {};


		/*methods*/

		// Close the overlay
		method.close = function () {

			$overlay.remove();

		};

		$close.click(function (e) {
			e.preventDefault();
			method.close();
		});
		$overlay.append($window);
		$window.append($close);
		$('body').append($overlay);
	}

})( jQuery );
