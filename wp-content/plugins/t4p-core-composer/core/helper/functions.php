<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */

/**
 * @todo : Common functions
 */

if ( ! class_exists( 'T4P_Pb_Helper_Functions' ) ) {

	class T4P_Pb_Helper_Functions {

		// Store how many times the action is executed
		static $run_time = 0;

		/**
		 * Translation for Javascript
		 *
		 * @return array
		 */
		static function js_translation() {
			$default = array(
				'site_url'              => site_url(),
				'delete_row'            => __( 'Are you sure you want to delete the whole row including all elements it contains?', 't4p-core' ),
				'delete_column'         => __( 'Are you sure you want to delete the whole column including all elements it contains?', 't4p-core' ),
				'delete_element'        => __( 'Are you sure you want to delete the element?', 't4p-core' ),
				'table'                 => array(
					'table1' => __( "A table must has atleast 1 columns. You can't remove this column", 't4p-core' ),
					'table2' => __( "A table must has atleast 2 rows. You can't remove this row", 't4p-core' ),
					'table3' => __( "Row span/Column span can't be negative", 't4p-core' ),
			),
				'saving'                => __( 'Saving content! Please wait a moment.', 't4p-core' ),
				'error_tinymce'         => __( 'Having error on loading TinyMCE.', 't4p-core' ),
				'settings'              => __( 'Settings', 't4p-core' ),
				'page_modal'            => __( 'Page Modal', 't4p-core' ),
				'convertText'           => __( 'Convert to ', 't4p-core' ),
				'shortcodes'            => array(
					'audio1'     => __( 'No audio source selected', 't4p-core' ),
					'googlemap1' => __( 'Select Destination Marker', 't4p-core' ),
					'video1'     => __( 'No video file selected', 't4p-core' ),
			),
				'noneTxt'               => __( 'None', 't4p-core' ),
				'invalid_link'          => __( 'The link is invalid', 't4p-core' ),
				'noItem'                => __( 'No %s found', 't4p-core' ),
				'singleEntry'           => __( 'Single %s', 't4p-core' ),
				'copy'                  => __( 'copy', 't4p-core' ),
				'itemFilter'            => __( '%s Filter', 't4p-core' ),
				'startFrom'             => __( 'Start From', 't4p-core' ),
				'menu'                  => __( 'Menu', 't4p-core' ),
				'filterBy'              => __( 'Filter By', 't4p-core' ),
				'attributes'            => __( 'Attributes', 't4p-core' ),
				'attribute'             => __( 'Attribute', 't4p-core' ),
				'option_attribute'      => __( 'Option Attribute', 't4p-core' ),
				'deactivatePb'          => __( 'After turning off, the content built with PageBuilder will be parsed to plain HTML code and inserted to default editor. Are you sure you want to turn PageBuilder off?', 't4p-core' ),
				'no_title'              => __( '(Untitled)', 't4p-core' ),
				'inno_shortcode'        => __( 'Add Page Element', 't4p-core' ),
				'asset_url'             => T4P_CORE_URI . 'assets/theme4press/',
				'limit_title'           => __( 'You used up to 50 characters', 't4p-core' ),
				'select_layout'         => __( 'The whole content of current Post will be replaced by content of selected Page item. Do you want to continue?', 't4p-core' ),
				'disabled'              => array(
					'deactivate' => __( 'Deactivate element', 't4p-core' ),
					'reactivate' => __( 'Activate element', 't4p-core' ),
			),
				'button'                => array(
					'select' => __( 'Select', 't4p-core' ),
			),
				'layout'                => array(
					'modal_title'           => __( 'Select template', 't4p-core' ),
					'upload_layout_success' => __( 'Upload successfully', 't4p-core' ),
					'upload_layout_fail'    => __( 'Upload fail', 't4p-core' ),
					'delete_layout_success' => __( 'Page is deleted successfully', 't4p-core' ),
					'delete_layout_fail'    => __( 'Fail. Can\'t delete layout', 't4p-core' ),
					'delete_group'          => __( 'All pages in this group will be remove. Do you want to continue ?', 't4p-core' ),
					'delete_layout'         => __( 'This page will be remove. Do you want to continue ?', 't4p-core' ),
					'no_layout_name'        => __( 'Template name can not be null', 't4p-core' ),
					'name_exist'            => __( 'Template name exists. Please choose another one.', 't4p-core' )
			),
				'custom_css'            => array(
					'modal_title'    => __( 'Custom CSS', 't4p-core' ),
					'file_not_found' => __( "File doesn't exist", 't4p-core' ),
			),
				'report_bug'            => array(
					'modal_title'       => __( 'Submit a bug report', 't4p-core' ),
					'submit'            => __( 'Submit', 't4p-core' ),
					'send_mail_success' => __( 'Send report bug successfully!', 't4p-core' ),
					'send_mail_fail'    => __( 'Fail to send report, please check again!', 't4p-core' )
				),
				'element_not_existed'   => __( 'Element not existed!', 't4p-core' ),
				'take_style'            => __( 'Take Style', 't4p-core' ),
				'select_element_title'  => __( 'Select Element', 't4p-core' ),
			);

			return apply_filters( 't4p_pb_js_translation', $default );
		}

		/**
		 * Enqueue assets for shortcodes
		 *
		 * @global type $t4p_sc_by_providers
		 *
		 * @param type  $this_    :   current shortcode object
		 * @param type  $extra    :   frontend_assets/ admin_assets
		 * @param type  $post_fix :   _frontend/ ''
		 */
		public static function shortcode_enqueue_assets( $this_, $extra, $post_fix = '' ) {
			$extra_js = isset( $this_->config['exception'] ) && isset( $this_->config['exception'][$extra] ) && is_array( $this_->config['exception'][$extra] );
			$assets   = array_merge( $extra_js ? $this_->config['exception'][$extra] : array(), array( str_replace( 't4p_', '', $this_->config['shortcode'] ) . $post_fix ) );

			foreach ( $assets as $asset ) {
				if ( ! preg_match( '/\.(css|js)$/', $asset ) ) {
					T4P_Pb_Init_Assets::load( $asset );
				} else {
					global $t4p_sc_by_providers;

					if ( empty( $t4p_sc_by_providers ) ) {
						continue;
					}

					// load assets file in common assets directory of provider
					$default_assets = self::assets_default( $this_, $asset );

					// if can't find the asset file, search in /assets folder of the shortcode
					if ( ! $default_assets ) {

						// Get path of directory contains all shortcodes of provider
 						$shortcode_dir = T4P_Pb_Helper_Shortcode::get_provider_info( $this_->config['shortcode'], 'shortcode_dir' );

						if ( $shortcode_dir == T4P_CORE_LAYOUT_PATH ) {
							// this is core PB
							$sc_path = T4P_PB_ELEMENT_PATH;
							$sc_uri  = T4P_CORE_URI . basename( $sc_path );
						} else {
							// Get directory of shortcodes of this provider
							$plugin_path       = T4P_Pb_Helper_Shortcode::get_provider_info( $this_->config['shortcode'], 'path' );
							$plugin_uri        = T4P_Pb_Helper_Shortcode::get_provider_info( $this_->config['shortcode'], 'uri' );
							$shortcode_dir_arr = (array) T4P_Pb_Helper_Shortcode::get_provider_info( $this_->config['shortcode'], 'shortcode_dir' );
							$shortcode_dir     = reset( $shortcode_dir_arr );

							$sc_path = $plugin_path . basename( $shortcode_dir );

							if ( is_dir( $sc_path ) ) {
								$sc_uri = $plugin_uri . basename( $shortcode_dir );
							} else {
								$sc_path = $plugin_path;
								$sc_uri  = $plugin_uri;
							}
						}

						$ext_regex = '/(_frontend)*\.(js|css)$/';
						if ( preg_match( $ext_regex, $asset ) ) {
							// load assets in directory of shortcodes
							$require_sc = preg_replace( $ext_regex, '', $asset );
							self::assets_specific_shortcode( $require_sc, $asset, $sc_path, $sc_uri );
						} else {
							// load js/css file in directory of current shortcode
							$exts = array( 'js', 'css' );

							foreach ( $exts as $ext ) {
								$require_sc = $this_->config['shortcode'];
								$file       = $asset . ".$ext";

								// if this asset is processed, leave it
								self::assets_check( $file );

								// enqueue or add to cache file
								self::assets_specific_shortcode( $require_sc, $file, $sc_path, $sc_uri );

								// store it as processed asset
								self::assets_check( $file, true );
							}
						}
					}
				}
			}
		}

		/**
		 * Check if asset file is processed | or add asset file to processed list
		 *
		 * @param string $file
		 * @param bool   $assign
		 */
		static private function assets_check( $file, $assign = false ) {
			if ( self::$run_time == 0 ) {
				unset( $_SESSION );
			}
			self::$run_time ++;

			global $post;
			$post_id = ! empty( $post ) ? $post->ID : 0;

			// Check if this is backend or frontend
			$side = T4P_Pb_Helper_Functions::is_preview() ? 'admin' : 'wp';

			if ( ! $assign ) {
					if ( isset($_SESSION['processed-assets'][$post_id][$side]['assets']) && in_array( $file, (array) $_SESSION['processed-assets'][$post_id][$side]['assets'] ) ) {
					return;
				}
			} else {
				// store it as processed asset
				$_SESSION['processed-assets'][$post_id][$side]['assets'][] = $file;
			}
		}

		/**
		 * Get assest file in T4P PageBuilder assets directory
		 *
		 * @param type $this_
		 * @param type $js_file
		 */
		static private function assets_default( $this_, $js_file ) {

			// if this asset is processed, leave it
			self::assets_check( $js_file );

			// Get js directory of Theme4Press
			$inno_gears    = array_values( T4P_Pb_Helper_Shortcode::register_provider() );
			$inno_gears_js = $inno_gears[0]['js_shortcode_dir'];

			// Get js directory of shortcodes
			$js_dir = T4P_Pb_Helper_Shortcode::get_provider_info( $this_->config['shortcode'], 'js_shortcode_dir' );
			if ( empty( $js_dir ) || ! count( $js_dir ) ) {
				// if doesn't have a js dir, assign Theme4Press js dir
				$js_dir = $inno_gears_js;
			}
			$file_path = $js_dir['path'] . '/' . $js_file;
			$file_uri  = $js_dir['uri'] . '/' . $js_file;

			// if file doesn't exist, try to get it in IGPB js dir
			if ( ! file_exists( $file_path ) ) {
				$file_path = $inno_gears_js['path'] . '/' . $js_file;
				$file_uri  = $inno_gears_js['uri'] . '/' . $js_file;
			}

			if ( file_exists( $file_path ) ) {
				self::asset_enqueue_( $file_uri, $js_file, $file_path );

				// store it as processed asset
				self::assets_check( $js_file, true );

				return true;
			}

			return false;
		}

		/**
		 * Get assets in specific shortcode folder
		 *
		 * @param type $require_sc
		 * @param type $js_file
		 * @param type $sc_path
		 * @param type $sc_uri
		 */
		static private function assets_specific_shortcode( $require_sc, $js_file, $sc_path, $sc_uri ) {
			$sc_path = rtrim( $sc_path, '/' );
			$sc_uri  = rtrim( $sc_uri, '/' );

			// Get parent shortcode name
			$require_sc = str_replace( '_', '-', preg_replace( '/(t4p_|item_)/', '', $require_sc ) );

			// Get type of asset file
			$type = strpos( $js_file, '.js' ) ? 'js/' : 'css/';

			// Get path & uri
			$file_path = $sc_path . "/$require_sc/assets/$type" . $js_file;
			$file_uri  = $sc_uri . "/$require_sc/assets/$type" . $js_file;

			if ( file_exists( $file_path ) ) {
				self::asset_enqueue_( $file_uri, $js_file, $file_path );
			}
		}

		/**
		 * Enqueue script/style
		 *
		 * @param unknown $file_uri
		 * @param unknown $js_file
		 */
		static private function asset_enqueue_( $file_uri, $js_file, $file_path ) {
			$enqueue = 0;
			$handle  = T4P_Pb_Init_Assets::file_to_handle( $js_file );

			if ( is_admin() ) {
				$enqueue = 1;
			} else {
				$t4p_pb_settings_cache = get_option( 't4p_pb_settings_cache', 'enable' );

				if ( $t4p_pb_settings_cache == 'enable' ) {
					self::store_assets_info( $handle, $file_uri, $file_path );
				} else {
					$enqueue = 1;
				}
			}

			if ( $enqueue ) {
				T4P_Pb_Init_Assets::load( $handle, $file_uri );
			}
		}

		/**
		 * Store handle to Session
		 *
		 * @global type $wp_scripts
		 *
		 * @param type  $handle
		 */
		static function store_assets_info( $handle, $src = '', $file_path = '' ) {
			global $wp_scripts, $post;
			$handle_object = array();

			if ( empty ( $_SESSION['t4p-pb-assets-frontend'] ) ) {
				$_SESSION['t4p-pb-assets-frontend'] = array();
			}
			if ( empty ( $_SESSION['t4p-pb-assets-frontend'][$post->ID] ) )
			$_SESSION['t4p-pb-assets-frontend'][$post->ID] = array();

			if ( ! ( empty ( $wp_scripts ) && empty ( $wp_scripts->registered ) ) ) {
				if ( array_key_exists( $handle, $wp_scripts->registered ) ) {
					$handle_object = $wp_scripts->registered[$handle];
					$src           = $handle_object['src'];
				}
			}

			$type = ( substr( $src, - 2 ) == 'js' ) ? 'js' : 'css';
			if ( empty ( $_SESSION['t4p-pb-assets-frontend'][$post->ID][$type] ) )
			$_SESSION['t4p-pb-assets-frontend'][$post->ID][$type] = array();

			if ( ! array_key_exists( $handle, $_SESSION['t4p-pb-assets-frontend'][$post->ID][$type] ) ) {
				//				// Dependency
				//				if( isset ( $handle_object['deps'] ) ) {
				//					$deps = $handle_object['deps'];
				//					foreach ($deps as $other_handle) {
				//						self::store_assets_info( $other_handle );
				//					}
				//				}
				$modified_time                                                   = filemtime( $file_path );
				$_SESSION['t4p-pb-assets-frontend'][$post->ID][$type][$file_path] = $modified_time;
			}

		}

		/**
		 * Remove HTML/PHP tag & other tag in ID of an element
		 *
		 * @param type $string
		 *
		 * @return type
		 */
		static function remove_tag( $string ) {
			$string = strip_tags( $string );
			$string = str_replace( '-value-', '', $string );
			$string = str_replace( '-type-', '', $string );

			return $string;
		}

		/**
		 * Get post excerpt (can't use WP excerpt function, because post content contains IGPB shortcodes)
		 *
		 * @param type $post_content
		 *
		 * @return type
		 */
		static function post_excerpt( $post_content ) {
			$excerpt = T4P_Pb_Helper_Shortcode::remove_t4p_shortcodes( $post_content );

			return strip_tags( $excerpt );
		}

		/**
		 * Open item in new window
		 *
		 * @param type $selector
		 * @param type $options
		 */
		static function new_window( $selector, $options = array() ) {
			$script  = "<script type='text/javascript'>";
			$script .= "( function ($) {
				$( document ).ready( function () {
					$( '$selector' ).click( function(e){
						e.preventDefault();
						var url = $(this).attr('href');

						var width = screen.availWidth * 0.75;
						var height = screen.availHeight * 0.75;
						var left = parseInt((screen.availWidth/2) - (width/2));
						var top = parseInt((screen.availHeight/2) - (height/2));
						var windowFeatures = 'width=' + width + ',height=' + height + ',status,resizable,left=' + left + ',top=' + top + 'screenX=' + left + ',screenY=' + top;
						myWindow = window.open(url, 'subWind', windowFeatures);
					} );
				});
			})( jQuery )";
			$script .= '</script>';

			return $script;
		}

		/**
		 * Js for fancybox
		 *
		 * @param type $selector
		 *
		 * @return type
		 */
		static function fancybox( $selector, $options = array() ) {
			$default = array(
				'type'          => '',
				'autoScale'     => 'false',
				'transitionIn'  => 'elastic',
				'transitionOut' => 'elastic',
			);
			$options = array_merge( $default, $options );
			$data    = array();
			foreach ( $options as $key => $value ) {
				$value  = is_string( $value ) ? "'$value'" : $value;
				$data[] = "'$key' : $value";
			}
			$data = implode( ',', $data );

			$script  = "<script type='text/javascript'>";
			$script .= "( function ($ ) {
				$( document ).ready( function () {
					$( '$selector' ).fancybox( { $data } );
				});
			})( jQuery )";
			$script .= '</script>';

			return $script;
		}

		/**
		 * Social share links
		 *
		 * @param type $social_networks
		 *
		 * @return type
		 */
		static function social_links( $social_networks, $permalink, $title, $thumb, $excerpt ) {
			$all_socials     = array(
				'facebook'   => array( 'link' => 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=' . $permalink . '&p[images][0]=' . $thumb . '&p[title]=' . $title . '&p[summary]=' . $excerpt ),
				'twitter'    => array( 'link' => 'http://twitter.com/home/?status=' . $title . ' - ' . $permalink ),
				'googleplus' => array( 'link' => 'https://plus.google.com/share?url=' . $permalink ),
			);
			$links           = array();
			$social_networks = array_filter( $social_networks );
			foreach ( $social_networks as $network ) {
				if ( isset( $all_socials[$network] ) ) {
					$network_info = $all_socials[$network];
					$links[]      = "<li><a href='{$network_info['link']}' target='_blank' class='$network social-link'></a></li>";
				}
			}
			ob_start();
			?>
<script type='text/javascript'>
				(function ($) {
					$(document).ready(function () {
						$('.social-link').unbind('click').click(function (e) {
							e.preventDefault();
							var w = 600, h = 600;
							var left = (screen.width / 2) - (w / 2);
							var top = (screen.height / 2) - (h / 2);
							window.open($(this).attr('href'), "_blank", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
						});
					});
				})(jQuery);
			</script>
			<?php
			$script = ob_get_clean();

			return $script . '<ul class="t4p-social-links">' . implode( '', $links ) . '</ul>';
		}

		/**
		 * Modify value in array
		 *
		 * @param type $value
		 * @param type $key
		 * @param type $new_values
		 */
		static function t4p_arr_walk( &$value, $key, $new_values ) {
			if ( array_key_exists( $value['id'], $new_values ) )
			$value['std'] = $new_values[$value['id']];
		}

		/**
		 * Modify value in array of sub-shortcode
		 *
		 * @param type $value
		 * @param type $key
		 * @param type $new_values
		 */
		static function t4p_arr_walk_subsc( &$value, $key, $new_values ) {
			$value['std'] = $new_values[$key];
		}

		/**
		 * Get image id
		 *
		 * @global type $wpdb
		 *
		 * @param type  $image_url
		 *
		 * @return type
		 */
		public static function get_image_id( $image_url = '' ) {
			global $wpdb;
			$attachment_id = false;

			// If there is no url, return.
			if ( '' == $image_url )
			return;

			// Get the upload directory paths
			$upload_dir_paths = wp_upload_dir();

			// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
			if ( false !== strpos( $image_url, $upload_dir_paths['baseurl'] ) ) {

				// If this is the URL of an auto-generated thumbnail, get the URL of the original image
				$image_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $image_url );

				// Remove the upload path base directory from the attachment URL
				$image_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $image_url );

				// Finally, run a custom database query to get the attachment ID from the modified attachment URL
				$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $image_url ) );
			}

			return $attachment_id;
		}

		/**
		 * Set post views
		 *
		 * @param int $postID
		 */
		public static function set_postview( $postID ) {
			$count_key = '_t4p_post_view_count';
			$count     = get_post_meta( $postID, $count_key, true );
			if ( $count == '' ) {
				$count = 0;
				delete_post_meta( $postID, $count_key );
				add_post_meta( $postID, $count_key, '0' );
			} else {
				$count ++;
				update_post_meta( $postID, $count_key, $count );
			}
		}

		/**
		 * Count post views
		 *
		 * @param int $postID
		 */
		public static function get_postview( $postID ) {
			$count_key = '_t4p_post_view_count';
			$count     = get_post_meta( $postID, $count_key, true );
			if ( empty( $count ) || intval( $count ) == 0 ) {
				delete_post_meta( $postID, $count_key );
				add_post_meta( $postID, $count_key, '0' );

				return '0 ' . __( 'View', 't4p-core' );
			}

			return $count . ' ' . ( ( intval( $count ) == 1 ) ? __( 'View', 't4p-core' ) : __( 'Views', 't4p-core' ) );
		}

		/**
		 * Get current shortcode
		 *
		 * @return type
		 */
		public static function current_shortcode() {
			if ( ! empty( $_GET['t4p-gadget'] ) && $_GET['t4p-gadget'] == 'edit-element' ) {
				$current_shortcode = ! empty( $_GET['t4p_modal_type'] ) ? $_GET['t4p_modal_type'] : ( ! empty( $_GET['t4p_shortcode_name'] ) ? $_GET['t4p_shortcode_name'] : '' );

				return $current_shortcode;
			}

			return NULL;
		}

		/**
		 * Check if current page is modal page
		 *
		 * @return type
		 */
		public static function is_modal() {
			return ( ! empty( $_GET['t4p-gadget'] ) && $_GET['t4p-gadget'] == 'edit-element' );
		}

		/**
		 * Check if current page is modal page
		 *
		 * @param type $shortcode
		 *
		 * @return type
		 */
		public static function is_modal_of_element( $shortcode ) {
			if ( empty ( $shortcode ) ) {
				return false;
			}

			return ( T4P_Pb_Helper_Functions::is_modal() && isset( $_GET['t4p_modal_type'] ) && $_GET['t4p_modal_type'] == $shortcode );
		}

		/**
		 * Check if current page is modal/ preview page
		 *
		 * @return type
		 */
		public static function is_preview() {
			return ( ! empty( $_GET['t4p_shortcode_preview'] ) && $_GET['t4p_shortcode_preview'] == '1' );
		}

		/**
		 * Get folder path
		 *
		 * @param type $folder
		 * @param type $uri
		 *
		 * @return type
		 */
		public static function path( $folder = '', $uri = '' ) {
			$uri = empty ( $uri ) ? T4P_CORE_URI : $uri;

			return $uri . $folder;
		}

		/**
		 * Common js/css file for T4P PageBuilder/Ig Modal/Ig Preview Page
		 *
		 * @return type
		 */
		public static function localize_js() {
			return array(
				'ajaxurl'      => admin_url( 'admin-ajax.php' ),
				'adminroot'    => admin_url(),
				'_nonce'       => wp_create_nonce( T4P_NONCE ),
				't4p_modal_url' => T4P_EDIT_ELEMENT_URL,
				'save'         => __( 'Save', 't4p-core' ),
				'cancel'       => __( 'Cancel', 't4p-core' ),
				'delete'       => __( 'Delete Element', 't4p-core' ),
				'assets_url'   => T4P_CORE_URI,
			);
		}

		/**
		 * Common scripts for T4P PageBuilder
		 */
		public static function enqueue_scripts() {
			T4P_Pb_Init_Assets::load(
			array(
					'jquery-ui-resizable',
					'jquery-ui-sortable',
					'jquery-ui-tabs',
					'jquery-ui-dialog',
					'jquery-ui-button',
					'jquery-ui-slider',
                                        't4p-pb-bootstrap-js',
					't4p-pb-jquery-easing-js',
			)
			);
		}

		/**
		 * Common scripts for T4P modal
		 */
		public static function enqueue_scripts_modal() {
			T4P_Pb_Init_Assets::load( array( 't4p-pb-preview-bootstrap-js', 't4p-pb-preview-main-js', 't4p-pb-gmap-js', 't4p-pb-jquery.carouFredSel', 't4p-pb-jquery.flexslider' ) );
			if ( ! self::is_preview() ) {
				T4P_Pb_Init_Assets::load( array( 'jquery-ui-tabs', 't4p-pb-jquery-easing-js', 't4p-pb-jquery.flexslider' ) );
			}
		}

		/**
		 * Enqueue needed scripts to handle elements on PageBuilder
		 */
		public static function enqueue_scripts_end() {
			// Load necessary scripts if not previewing
			if ( ! self::is_preview() ) {
				T4P_Pb_Init_Assets::load( 't4p-pb-modal-js' );

				if ( isset( $_GET['t4p_layout'] ) && $_GET['t4p_layout'] == 1 ) {
					// Load premade layout script
					T4P_Pb_Init_Assets::load( 't4p-pb-premade-pages-js' );
				} else {
					// Load element editor script
					T4P_Pb_Init_Assets::load( 't4p-pb-handleelement-js' );

					// Load element settings script
					T4P_Pb_Init_Assets::load( 't4p-pb-handlesetting-js' );

					// Load ZeroClipboard JavaScript library for Shortcode Content tab
					T4P_Pb_Init_Assets::load( 't4p-zeroclipboard-js' );
				}

				// Localize necessary scripts
				self::t4p_localize();
			}
		}

		/**
		 * Common styles
		 */
		public static function enqueue_styles() {
			add_filter( 't4p_pb_register_assets', array( __CLASS__, 'register_assets' ) );
			$arr_before_load_pb = apply_filters( 't4p_load_assets_before', array( 't4p-pb-jquery-ui-css', 't4p-pb-jquery-select2-css', 't4p-pb-jquery-select2-bootstrap3-css', 't4p-pb-admin-css', 't4p-pb-element-font-css', 't4p-pb-layout-font-css' ) );

			if ( is_admin() ) {
				T4P_Pb_Init_Assets::load( array( 't4p-pb-bootstrap-css', 't4p-pb-jsn-css', 't4p-pb-font-icomoon-css', 't4p-pb-font-fontawesome-css' ) );

				if ( ! self::is_preview() ) {
					T4P_Pb_Init_Assets::load( $arr_before_load_pb );
				}
			}

                        if ( T4P_Pb_Helper_Functions::is_preview() ) {
                                T4P_Pb_Init_Assets::load( array( 't4p-pb-animation-css', 't4p-pb-preview-style-css', 't4p-pb-preview-bootstrap-css', 't4p-pb-bootstrapcsstheme-css', 't4p-pb-shortcodes-css' ) );
                        }
		}

		/**
		 * Register some custom assets
		 *
		 * @param array $assets
		 *
		 * @return string
		 */
		public static function register_assets( $assets ) {
			$assets['t4p-pb-modal-js'] = array(
				'src' => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/js/modal.js',
				'ver' => '1.0.0',
			);

			$assets['t4p-pb-handleelement-js'] = array(
				'src' => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/js/handle_element.js',
				'ver' => '1.0.0',
			);

			$assets['t4p-pb-handlesetting-js'] = array(
				'src' => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/js/handle_setting.js',
				'ver' => '1.0.0',
			);

			$assets['t4p-pb-premade-pages-js'] = array(
				'src' => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/js/premade-pages/premade.js',
				'ver' => '1.0.0',
			);

			$assets['t4p-pb-admin-css'] = array(
				'src' => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/css/page_builder.css',
				'ver' => '1.0.0',
			);

			$assets['t4p-pb-element-font-css'] = array(
				'src' => T4P_Pb_Helper_Functions::path( 'assets/3rd-party/t4p-element-font' ) . '/css/t4p-element-font.css',
				'ver' => '1.0.0'
			);

			$assets['t4p-pb-layout-font-css'] = array(
				'src' => T4P_Pb_Helper_Functions::path( 'assets/3rd-party/t4p-layout-font' ) . '/css/t4p-layout-font.css',
				'ver' => '1.0.0'
			);
                        
			return $assets;
		}

		/**
		 * Localize for js files
		 */
		public static function t4p_localize() {
			T4P_Pb_Init_Assets::localize( 't4p-pb-handleelement', 't4p_translate', T4P_Pb_Helper_Functions::js_translation() );
			T4P_Pb_Init_Assets::localize( 't4p-pb-handleelement', 't4p_js_html', T4P_Pb_Helper_Shortcode::$item_html_template );
			T4P_Pb_Init_Assets::localize( 't4p-pb-handleelement', 't4p_ajax', T4P_Pb_Helper_Functions::localize_js() );

			// Localize scripts for premade layout modal.
			T4P_Pb_Init_Assets::localize( 't4p-pb-premade-pages', 't4p_translate', T4P_Pb_Helper_Functions::js_translation() );
			T4P_Pb_Init_Assets::localize( 't4p-pb-premade-pages', 't4p_ajax', T4P_Pb_Helper_Functions::localize_js() );

			T4P_Pb_Init_Assets::localize( 't4p-pb-layout', 't4p_translate', T4P_Pb_Helper_Functions::js_translation() );
			T4P_Pb_Init_Assets::localize(
				't4p-pb-widget', 't4p_preview_html', T4P_Pb_Helper_Functions::get_element_item_html(
			array(
						'element_wrapper' => 'div',
						'modal_title'     => '',
						'element_type'    => 'data-el-type="element"',
						'name'            => 'Widget Element Setting',
						'shortcode'       => 'T4P_SHORTCODE_CONTENT',
						'shortcode_data'  => 'T4P_SHORTCODE_DATA',
						'content_class'   => 't4p-pb-element',
						'content'         => 'Widget Element Setting',
			)
			)
			);
		}

		/**
		 * Get list of defined widgets
		 *
		 * @global type $wp_widget_factory
		 * @return type
		 */
		public static function list_widgets() {
			global $wp_widget_factory;
			$results = array();
			foreach ( $wp_widget_factory->widgets as $class => $info ) {
				$results[$info->id_base] = array(
					'class'       => $class,
					'name'        => __( $info->name, 't4p-core' ),
					'description' => __( $info->widget_options['description'], 't4p-core' )
				);
			}

			return $results;
		}

		/**
		 * Get all neccessary widgets information
		 *
		 * @return type
		 */
		public static function widgets() {
			$t4p_pb_widgets = array();
			$widgets       = T4P_Pb_Helper_Functions::list_widgets();
			foreach ( $widgets as $id => $widget ) {
				if ( $widget['class'] == 'T4P_Pb_Objects_Widget' )
				continue;
				$config                          = array(
					'shortcode'     => $widget['class'],
					'name'          => $widget['name'],
					'identity_name' => __( 'Widget', 't4p-core' ) . ' ' . $widget['name'],
					'extra_'        => sprintf( 'data-value="%1$s" data-type="%2$s" data-sort="%2$s"', esc_attr( $id ), 'widget' ),
					'description'   => $widget['description']
				);
				$t4p_pb_widgets[$widget['class']] = $config;
			}

			return $t4p_pb_widgets;
		}

		/**
		 * Get html item
		 *
		 * @param array $data
		 * @param bool $inlude_sc_structure print the data structure in
		 * a textarea or not
		 *
		 * @return string
		 */
		static function get_element_item_html( $data, $inlude_sc_structure = true ) {
			$default = array(
				'element_wrapper'       => '',
				'modal_title'           => '',
				'element_type'          => '',
				'name'                  => '',
				'shortcode'             => '',
				'shortcode_data'        => '',
				'content_class'         => '',
				'content'               => '',
				'action_btn'            => '',
				'has_preview'           => true,
				'this_'                 => '',
				'drag_handle'           => true,
				'is_sub_element'        => false,
				'edit_inline'        	=> false,
				'edit_using_ajax'       => ''
			);
			$data = array_merge( $default, $data );
			extract( $data );

			$preview_html = '';
			if ( $has_preview ) {
				$preview_html = '<div class="shortcode-preview-container" style="display: none">
					<div class="shortcode-preview-fog"></div>
					<div class="jsn-overlay jsn-bgimage image-loading-24"></div>
				</div>';
			}

			$enable_inline_edit = $edit_inline;

			$extra_class  = T4P_Pb_Utils_Placeholder::get_placeholder( 'extra_class' );
			$custom_style = T4P_Pb_Utils_Placeholder::get_placeholder( 'custom_style' );
			$other_class  = '';

			// Check if this element is deactivate
			preg_match_all( '/\[' . $shortcode . '\s+([A-Za-z0-9_-]+=\"[^"\']*\"\s*)*\s*\]/', $shortcode_data, $rg_sc_params );
			if ( ! empty( $rg_sc_params[0] ) ) {
				$sc_name_params = ! empty( $rg_sc_params[0][0] ) ? $rg_sc_params[0][0] : $rg_sc_params[0];
				if( strpos( $sc_name_params , 'disabled_el="yes"') !== false ) {
					$other_class = 'disabled';
				}
			}

			// Remove empty value attributes of shortcode tag.
			//$shortcode_data = preg_replace( '/\[*([a-z_]*[\n\s\t]*=[\n\s\t]*""\s)/', '', $shortcode_data );

			// Content
			$content = balanceTags( $content );

                        $content = apply_filters( 't4p_pb_content_in_pagebuilder', $content, $shortcode_data, $shortcode );

			// action buttons
			$edit_icon = 'icon-pencil';

			$edit_btn = apply_filters( 'edit_btn_class', 'element-edit', $shortcode );

			$buttons = array(
				'edit'       => '<a href="#" onclick="return false;" title="' . __( 'Edit element', 't4p-core' ) . '" data-shortcode="' . $shortcode . '" class="' . $edit_btn . ( $enable_inline_edit ? '-sub' : '' ) . '"><i class="' . $edit_icon . '"></i></a>',
				'clone'      => '<a href="#" onclick="return false;" title="' . __( 'Duplicate element', 't4p-core' ) . '" data-shortcode="' . $shortcode . '" class="element-clone"><i class="icon-copy"></i></a>',
				'deactivate' => '<a href="#" onclick="return false;" title="' . __( 'Deactivate element', 't4p-core' ) . '" data-shortcode="' . $shortcode . '" class="element-deactivate"><i class="icon-checkbox-unchecked"></i></a>',
				'delete'     => '<a href="#" onclick="return false;" title="' . __( 'Delete element', 't4p-core' ) . '" class="element-delete"><i class="icon-trash"></i></a>'
				);

				if ( ! empty ( $other_class ) ) {
					$buttons = array_merge(
					$buttons, array(
						'deactivate' => '<a href="#" onclick="return false;" title="' . __( 'Activate element', 't4p-core' ) . '" data-shortcode="' . $shortcode . '" class="element-deactivate"><i class="icon-checkbox-partial"></i></a>',
					)
					);
				}

				$action_btns = ( empty( $action_btn ) ) ? implode( '', $buttons ) : $buttons[$action_btn];
				$buttons     = apply_filters( 't4p_pb_button_in_pagebuilder', "<div class='jsn-iconbar'>$action_btns</div>", $shortcode_data, $shortcode );

				// Exclude the shortcode structure in shortcode textarea if not required.
				if ( !$inlude_sc_structure ) {
					$shortcode_data   = '';
				}

                                // Add drag handle
				$drag_handle_html = ( $drag_handle == true ) ? "<a class='element-drag'></a>" : "";
                                if (( strpos( $content, '_T4P_INDEX_' ) !== false )) {
                                        $content = ucwords ( str_replace( '_' , ' ', $content ) );
                                        $content = ucwords ( str_replace( ' T4P INDEX ' , '_T4P_INDEX_', $content ) );
                                } else {
                                        $content = ucwords ( str_replace( '_' , ' ', $content ) );
                                }
                                if ( strpos( $content, 'T4pslider' ) !== false ) {
                                        $content = ucwords ( str_replace( 'T4pslider' , 'Theme4Press Slider', $content ) );
                                }

				return "<$element_wrapper class='jsn-item jsn-element ui-state-default jsn-iconbar-trigger shortcode-container $extra_class $other_class' $modal_title $element_type $edit_using_ajax data-name='$name' $custom_style>
				<textarea class='hidden shortcode-content' shortcode-name='$shortcode' data-sc-info='shortcode_content' name='shortcode_content[]' >$shortcode_data</textarea>
				<div class='heading'>
				$drag_handle_html
				<div class='$content_class'>$content</div>
				</div>
				$buttons
				$preview_html
			</$element_wrapper>";
		}

		/**
		 * Get basedir of subfolder in UPLOAD folder
		 *
		 * @param type $sub_dir
		 *
		 * @return type
		 */
		static function get_wp_upload_folder( $sub_dir = '', $auto_create = true ) {
			$upload_dir = wp_upload_dir();
			if ( is_array( $upload_dir ) && isset ( $upload_dir['basedir'] ) ) {
				$upload_dir = $upload_dir['basedir'];
			} else {
				$upload_dir = WP_CONTENT_DIR . '/uploads';
				if ( ! is_dir( $upload_dir ) ) {
					mkdir( $upload_dir );
				}
			}
			if ( $auto_create && ! is_dir( $upload_dir . $sub_dir ) ) {
				mkdir( $upload_dir . $sub_dir, 0777, true );
			}

			return $upload_dir . $sub_dir;
		}

		/**
		 * Get baseurl of subfolder in UPLOAD folder
		 *
		 * @param type $sub_dir
		 *
		 * @return type
		 */
		static function get_wp_upload_url( $sub_dir = '' ) {
			$upload_dir = wp_upload_dir();
			if ( is_array( $upload_dir ) && isset ( $upload_dir['basedir'] ) ) {
				return $upload_dir['baseurl'] . $sub_dir;
			} else {
				return WP_CONTENT_URL . '/uploads' . $sub_dir;
			}
		}

		/**
		 * Store relation: array(file1, file2) => compressed file
		 *
		 * @param type $handle_info
		 * @param type $file_name
		 *
		 * @return type
		 */
		static function compression_data_store( $handle_info, $file_name ) {
			$cache_dir      = T4P_Pb_Helper_Functions::get_wp_upload_folder( '/igcache/pagebuilder' );
			$file_to_write_ = "$cache_dir/t4p-pb.cache";
			$fp             = fopen( $file_to_write_, 'a+' );
			if ( $fp ) {
				// Get stored data
				$str = '';
				while ( ! feof( $fp ) ) {
					$str .= fread( $fp, 1024 );
				}
				$stored_data = unserialize( $str );
				$stored_data = $stored_data ? $stored_data : array();
				// Check if $handle_info is existed in stored data
				$exist = '';
				foreach ( $stored_data as $handle_info_serialized => $compressed_file ) {
					$handle_info_old = unserialize( $handle_info_serialized );
					// Check if handle names are same
					if ( ! count( array_diff( array_keys( $handle_info ), array_keys( $handle_info_old ) ) ) ) {
						// Check if date modified are same
						if ( ! count( array_diff( $handle_info, $handle_info_old ) ) ) {
							$exist = $compressed_file;
							fclose( $fp );

							return array( 'exist', $compressed_file );
						}
					}
				}

				// close current handle
				fclose( $fp );

				// open new handle to write from beginning of file
				$fp                   = fopen( $file_to_write_, 'w' );
				$string               = serialize( $handle_info );
				$stored_data[$string] = $file_name;
				fwrite( $fp, serialize( $stored_data ) );

				fclose( $fp );

				return array( 'not exist', $file_name );
			}
		}

		/**
		 * Handle empty icon & heading for Carousel, ,Tab, Accordion, List item
		 *
		 * @param type $heading
		 * @param type $icon
		 */
		static function heading_icon( &$heading, &$icon, $heading_empty = false ) {
			if ( strpos( $heading, T4P_Pb_Utils_Placeholder::get_placeholder( 'index' ) ) !== false ) {
				$heading = '';
			}
			if ( empty ( $icon ) && empty ( $heading ) )
			$heading = ! $heading_empty ? __( '(Untitled)', 't4p-core' ) : '';
		}

		/**
		 * Show alert box
		 *
		 * @param unknown $mgs
		 */
		static function alert_msg( $mgs ) {
			?>
<div class="alert alert-<?php echo balanceTags( $mgs[0] ); ?>">
<?php echo balanceTags( $mgs[1] ); ?>
</div>
<?php
		}

		/**
		 * Load bootstrap 3, replace bootstrap 2
		 *
		 * @param type $assets
		 *
		 * @return string
		 */
		static function load_bootstrap_3( &$assets ) {
			if ( is_admin() && !T4P_Pb_Helper_Functions::is_preview() ) {
				$assets['t4p-pb-bootstrap-css'] = array(
					'src' => T4P_Pb_Helper_Functions::path( 'assets/3rd-party/bootstrap3' ) . '/css/bootstrap.min.css',
                                        'ver' => '3.1.1',
				);
				$assets['t4p-pb-bootstrap-js'] = array(
					'src'  => T4P_Pb_Helper_Functions::path( 'assets/3rd-party/bootstrap3' ) . '/js/bootstrap.min.js',
					'ver'  => '3.0.2',
					'deps' => array( 'jquery' ),
				);
			}
		}

                /**
		 * Load custom css
		 *
		 * @param type $assets
		 *
		 * @return string
		 */
		static function load_custom_css( &$assets ) {
                    global $theme_prefix, $smof_data;

			if ( T4P_Pb_Helper_Functions::is_preview() ) {

                            if ( $theme_prefix == 'evolve_' ) {
				$assets['t4p-pb-preview-bootstrap-css'] = array(
					'src' => get_template_directory_uri() . '/assets/css/bootstrap.css',
				);
                                $assets['t4p-pb-bootstrapcsstheme-css'] = array(
					'src' => get_template_directory_uri() . '/assets/css/bootstrap-theme.css',
				);
                                $assets['t4p-pb-preview-style-css'] = array(
                                        'src'  => get_template_directory_uri() . '/style.css',
				);
                                $assets['t4p-pb-shortcodes-css'] = array(
                                        'src'  => get_template_directory_uri() . '/assets/css/shortcode/shortcodes.css',
				);
                                $assets['t4p-pb-animation-css'] = array(
                                        'src'  => get_template_directory_uri() . '/assets/css/animate-css/animate-custom.css',
				);
                                $assets['t4p-pb-preview-bootstrap-js'] = array(
                                        'src'  => get_template_directory_uri() . '/assets/js/bootstrap.min.js',
				);
                                $assets['t4p-pb-preview-main-js'] = array(
                                        'src'  => get_template_directory_uri() . '/library/media/js/main_backend.js',
				);
                                $assets['t4p-pb-gmap-js'] = array(
                                        'src'  => get_template_directory_uri() . '/library/media/js/gmap.js',
				);
                                $assets['t4p-pb-jquery.carouFredSel'] = array(
                                        'src'  => get_template_directory_uri() . '/library/media/js/jquery.carouFredSel.js',
				);
                                $assets['t4p-pb-jquery.flexslider'] = array(
                                        'src'  => get_template_directory_uri() . '/library/media/js/jquery.flexslider-min.js',
				);
                            } else {
                                $assets['t4p-pb-preview-style-css'] = array(
                                        'src'  => get_template_directory_uri() . '/style.css',
				);
                                $assets['t4p-pb-animation-css'] = array(
                                        'src'  => get_template_directory_uri() . '/css/animate-custom.css',
				);
                                $assets['t4p-pb-preview-main-js'] = array(
                                        'src'  => get_template_directory_uri() . '/js/main_backend.js',
				);
                                $assets['t4p-pb-jquery.carouFredSel'] = array(
                                        'src'  => get_template_directory_uri() . '/js/jquery.carouFredSel-6.2.1-min.js',
				);
                                $assets['t4p-pb-jquery.flexslider'] = array(
                                        'src'  => get_template_directory_uri() . '/js/jquery.flexslider-min.js',
				);
                            }
                        } else {
                                if ( $theme_prefix == 'evolve_' ) {
                                        $assets['t4p-pb-jquery.flexslider'] = array(
                                                'src'  => get_template_directory_uri() . '/library/media/js/jquery.flexslider-min.js',
                                        );
                                } else {
                                        $assets['t4p-pb-jquery.flexslider'] = array(
                                                'src'  => get_template_directory_uri() . '/js/jquery.flexslider-min.js',
                                        );
                                }
                        }
		}

		/**
		 * Get custom CSS meta data of post
		 *
		 * @param type $post_id
		 * @param type $meta_key
		 * @param type $action : get / put
		 *
		 * @return type
		 */
		static function custom_css( $post_id, $meta_key, $action = 'get', $value = '' ) {
			switch ( $meta_key ) {

				case 'css_files':
					if ( $action == 'get' )
					$result = get_post_meta( $post_id, '_t4p_page_builder_css_files', true );
					else {
						$result = update_post_meta( $post_id, '_t4p_page_builder_css_files', $value );
					}
					break;

				case 'css_custom':
					if ( $action == 'get' )
					$result = get_post_meta( $post_id, '_t4p_page_builder_css_custom', true );
					else
					$result = update_post_meta( $post_id, '_t4p_page_builder_css_custom', $value );
					break;

				default:
					break;
			}
			return $result;
		}

		/**
		 * Get custom css data: Css files, Css code of a post
		 *
		 * @global type $post
		 *
		 * @param type  $post_id
		 *
		 * @return type
		 */
		static function custom_css_data( $post_id ) {

			$arr = array( 'css_files' => '', 'css_custom' => '' );
			if ( isset ( $post_id ) ) {
				$arr['css_files']  = T4P_Pb_Helper_Functions::custom_css( $post_id, 'css_files' );
				$arr['css_custom'] = T4P_Pb_Helper_Functions::custom_css( $post_id, 'css_custom' );
			}

			return $arr;
		}

		/**
		 * Get custom information of plugin
		 *
		 * @param string $plugin_file : main file of plugin
		 * @param string $custom_info : custom date key
		 *
		 * @return type
		 */
		static function get_plugin_info( $plugin_file, $custom_info = '' ) {
                        if (function_exists( 'get_plugin_data' ) ) {
                            $plugin_data = get_plugin_data( $plugin_file );
                        }
			if ( $custom_info ) {
				return isset ( $plugin_data[$custom_info] ) ? $plugin_data[$custom_info] : NULL;
			}

			return $plugin_data;
		}

		/**
		 * Add google link to header
		 *
		 * @param string $font
		 *
		 * @return string
		 */
		static function add_google_font_link_tag( $font ) {
			ob_start();
			?>
<script type="text/javascript">
	(function ($) {
		$(document).ready(function () {
			var font_val = '<?php echo esc_js( str_replace( ' ', '+', $font ) ); ?>';

			// Check if has a link tag of this font
			var exist_font = 0;
			$('link[rel="stylesheet"]').each(function (i, ele) {
				var href = $(this).attr('href');
				if (href.indexOf('fonts.googleapis.com/css?family=' + font_val) >= 0) {
					exist_font++;
				}
			});

			// if this font is not included at head, add it
			if (!exist_font) {
				$('head').append("<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=<?php echo esc_attr( $font ); ?>' type='text/css' media='all' />");
			}
		});
	})(jQuery)
</script>
			<?php
			return ob_get_clean();
		}

		/**
		 * Custom script tag
		 *
		 * @param string $content
		 *
		 * @return string
		 */
		static function script_box( $content = '' ) {
			ob_start();
			?>
<script type="text/javascript">
	(function ($) {
		$(document).ready(function () {
			<?php echo balanceTags( $content ); ?>
		});
	})(jQuery)
</script>
			<?php
			return ob_get_clean();
		}
	}
}
