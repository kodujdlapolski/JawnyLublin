
(function() {
	tinymce.create('tinymce.plugins.smartlib', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			ed.addButton('htext', {
				title : 'HighlightedText',
				cmd : 'htext',
				image : url + '/img/1378777158_autograf.png'
			});

			ed.addButton('s_map', {
				title : 'smartlib Google Map',
				cmd : 's_map',
				image : url + '/img/1379552090_globe.png'
			});
			ed.addButton('s_video', {
				title : 'smartlib Video',
				cmd : 's_video',
				image : url + '/img/1379552216_camcoder_pro.png'
			});



			ed.addCommand('htext', function() {
				var hText = prompt("Insert Text"),
						shortcode;
				if (hText !== null) {


						shortcode = '[harmonux_pullquote]' + hText + '[/harmonux_pullquote]';
						ed.execCommand('mceInsertContent', 0, shortcode);

				}
			});

			ed.addCommand('s_map', function() {
					var shortcode = '[harmonux_map api_key="INSERT YOUR API KEY"  id="harmonux_map-1" coords="52.339381, 4.260405" zoom="5" type="satellite"]';
					ed.execCommand('mceInsertContent', 0, shortcode);


			});

			ed.addCommand('s_video', function() {
				var shortcode = '[harmonux_video from="-->You can choose: youtube, vimeo, dailymotion" id="Video ID eg. sdsd#545sd"]';
				ed.execCommand('mceInsertContent', 0, shortcode);


			});
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'smartlib Functions',
				author : 'Peter Bielecki',
				authorurl : 'http://netbiel.pl',
				infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
				version : "0.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add( 'smartlib', tinymce.plugins.smartlib );
})();