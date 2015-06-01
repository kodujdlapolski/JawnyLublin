(function ($) {
	"use strict";

	jQuery(document).ready(function ($) {

		//initialize foundation
		$(document).foundation();

		if($('.smartlib-slider-container').length>0){
			$('.smartlib-slider-container').flexslider();
		}

		/*frontpage slider*/
		if($('.smartlib-front-slider').length>0){
			$('.smartlib-front-slider').flexslider();
		}

		$( ".budget-expenses-list .data-amount-info span, .chart-legend li p" ).each(function( index ) {
			var number =  $( this ).text();
			$( this ).number( number, 2, ',', ' ' );
		});


		/*sticky post initialize*/
		modifyStickyBox();

		$('.text-resize li').click(function (e) {
      var container = $(this);
			 if(container.hasClass('size-small')){
				 $('#wrapper, #sidebar ul').css('font-size', '90%');
			 }
			if(container.hasClass('size-medium')){
				$('#wrapper, #sidebar ul').css('font-size', '100%');
			}

			if(container.hasClass('size-large')){
				$('#wrapper, #sidebar ul').css('font-size', '120%');
			}
		});

		$('.harmonux-toggle-topbar').click(function (e) {
			var container_expand = $(this).attr('href');
			var toggle_container = $('.smartlib-toggle-area');
			var top_menu = $('#top-navigation');
			var search_container = $('#smartlib-top-search-container');
			var link = $(this);


			link.toggleClass('active-toggle');

			if(container_expand=='#top-navigation'){

					if(link.hasClass('active-toggle')){
						top_menu.removeClass('show-for-large-up');
				  }else{
						top_menu.addClass('show-for-large-up');
					}
			}else if(container_expand=='#toggle-search'){

				toggle_container.toggleClass('show-container');

				if(toggle_container.hasClass('show-container')){
					search_container.show();
				}else{
					search_container.hide();
				}
			}






			e.preventDefault();
		});

		/*Simple onscroll animated header*/



		if ('embed') {

			$("embed").each(function (index) {
				var height = $(this).attr('height');
				var width = $(this).attr('width');

				$(this).width(width);
				$(this).height(height);
			});

		}
		/*ADD photoswipe*/
		if ($(".gallery-icon a").length != 0)
			var myPhotoSwipe = $(".gallery-icon a").photoSwipe({ enableMouseWheel:true,imageScaleMethod: 'zoom', enableKeyboard:false, captionAndToolbarAutoHideDelay:0, captionAndToolbarFlipPosition:true });
		//fixed menu
		var nav = $('.fixed-menu');
		var max_margin = $('#page').height();
		var front_page_header_height = $('.frontpage-header').height();
		$(window).scroll(function () {
			var scrollTop = $(this).scrollTop();
			if (scrollTop > 230) {
				if (scrollTop < max_margin - 230)
					nav.css("margin-top", scrollTop - 70 - front_page_header_height);
			} else {
				nav.css("margin-top", 0);
			}
		});
    /*show overlay*/
		show_overlay();

		/*initialize contact map */

		initialize_contact_map();

		jQuery(".filter-selector").change(function () {
			window.location = jQuery(this).find("option:selected").val();
		});

		jQuery(".category-filter").change(function () {

			jQuery('.filter-list').submit();

		});
	});
	var isHidden = false;
	function topNavScroll() {
		jQuery(window).scroll(function () {

			if (!isHidden) {
				//Animate off the screen while scrolling
				jQuery('#top-bar').animate({
					top:'-55px'
				}, 250, function () {
					//Make hidden to disable re-rendering
					jQuery('#top-bar')[0].style.visibility = "hidden";
				});
				isHidden = true;
			}
			clearTimeout(jQuery.data(this, 'scrollTimer'));
			jQuery.data(this, 'scrollTimer', setTimeout(function () {
				//Animate back on the screen when finished scrolling and make visible
				jQuery('#top-bar')[0].style.visibility = "visible";
				jQuery('#top-bar').animate({
					top:'0px'
				}, 250, function () {
				});
				isHidden = false;
			}, 500));
		});
	}


	/*Sticky box modyfication depoend on sticky box counter */

	function modifyStickyBox(){
		var sticky_post = $('.smartlib-featured-post-box');
		var sticky_count = sticky_post.length;

			if(sticky_count%2!=0 && sticky_count> 2){

				sticky_post.last().addClass('smartlib-featured-post-box-wide');

			}else if(sticky_count==1){

				sticky_post.addClass('smartlib-featured-post-box-wide');

			}

	}

	function show_overlay(){
		$('.budget-expenses-list li').on('click', function (e) {

			var docHeight = $(document).height();

			e.preventDefault();

			var $current_box = $(this);
			var content = $current_box.find('.budget-expenses-window').clone();
			var current_box_index = 0;
			var $close = $('<a class="btn-close-window" href="#">x</a>');


			var $overlay = $('<div class="overlay-outer"></div>');

			var $window = $('<div class="overlay-window"></div>');

			var method = {};

			method.close = function () {
				$overlay.hide();
				$window.empty();
				console.log()

			};

			$close.click(function (e) {
				e.preventDefault();
				method.close();
			});
			$window.append(content);

			$overlay.append($window);
			$window.append($close);
			//add buttons


			$('body').append($overlay);


		});
	}

	function initialize_contact_map() {

		if(document.getElementById('contact-map')){
		var mapOptions = {
			center: { lat: 51.240, lng: 22.550},
			zoom: 11,
			navigationControl: false,
			mapTypeControl: false,
			scaleControl: false,
			scrollwheel: false
		};
		var map = new google.maps.Map(document.getElementById('contact-map'),
				mapOptions);
		}
	}
})(jQuery);








