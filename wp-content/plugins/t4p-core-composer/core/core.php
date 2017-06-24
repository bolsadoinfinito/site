<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */
/**
 * Core initialization class of T4P Pb Plugin.
 */
class T4P_Pb_Core {

	/**
	 * T4P Pb Plugin's custom post type slug.
	 *
	 * @var  string
	 */
	private $t4p_elements;

	/**
	 * Constructor.
	 *
	 * @return  void
	 */
	function __construct() {
		$this->t4p_elements = array();

		global $pagenow;
		if (
				'post.php' == $pagenow || 'post-new.php' == $pagenow // Post editing page
				|| 'widgets.php' == $pagenow || 'admin.php' == $pagenow                         // Widget page, for T4P Page Element Widget
				|| ( isset( $_GET['t4p-gadget'] ) && $_GET['t4p-gadget'] != '' )	// T4P Gadet
				|| ( defined( 'DOING_AJAX' ) && DOING_AJAX )         // Ajax page
				|| ! is_admin()                                      // Front end
		)
		{
			$this->register_element();
			$this->register_widget();
		}

		$this->custom_hook();
	}

	/**
	 * Get array of shortcode elements
	 * @return type
	 */
	function get_elements() {
		return $this->t4p_elements;
	}

	/**
	 * Add shortcode element
	 * @param type $type: type of element ( element/layout )
	 * @param type $class: name of class
	 * @param type $element: instance of class
	 */
	function set_element( $type, $class, $element = null ) {
		if ( empty( $element ) ) {
                    $this->t4p_elements[$type][strtolower( $class )] = new $class();
                }
		else {
                    $this->t4p_elements[$type][strtolower( $class )] = $element;
                }
	}

	/**
	 * T4P PageBuilder custom hook
	 */
	function custom_hook() {
		// filter assets
		add_filter( 't4p_pb_register_assets', array( &$this, 'apply_assets' ) );
		add_action( 'admin_head', array( &$this, 'load_assets' ), 10 );
		add_action( 'admin_head', array( &$this, 'load_elements_list' ), 10 );
		// translation
		add_action( 'init', array( &$this, 'translation' ) );
		// register modal page
		add_action( 'admin_init', array( &$this, 'modal_register' ) );
		add_action( 'admin_init', array( &$this, 'widget_register_assets' ) );

		// enable shortcode in content & filter content with IGPB shortcodes
		add_filter( 'the_content', array( &$this, 'pagebuilder_to_frontend' ), 9 );
		add_filter( 'the_content', 'do_shortcode' );

		// enqueue js for front-end
		add_action( 'wp_enqueue_scripts', array( &$this, 'frontend_scripts' ) );

		// hook saving post
		add_action( 'edit_post', array( &$this, 'save_pagebuilder_content' ) );
		add_action( 'save_post', array( &$this, 'save_pagebuilder_content' ) );
		add_action( 'publish_post', array( &$this, 'save_pagebuilder_content' ) );
		add_action( 'edit_page_form', array( &$this, 'save_pagebuilder_content' ) );
		add_action( 'pre_post_update', array( &$this, 'save_pagebuilder_content' ) );

		// ajax action
		add_action( 'wp_ajax_save_css_custom', array( &$this, 'save_css_custom' ) );
		add_action( 'wp_ajax_delete_layout', array( &$this, 'delete_layout' ) );
		add_action( 'wp_ajax_delete_layouts_group', array( &$this, 'delete_layouts_group' ) );
		add_action( 'wp_ajax_reload_layouts_box', array( &$this, 'reload_layouts_box' ) );
		add_action( 'wp_ajax_t4ppb_clear_cache', array( &$this, 'igpb_clear_cache' ) );
		add_action( 'wp_ajax_save_layout', array( &$this, 'save_layout' ) );
		add_action( 'wp_ajax_submit_report_bug', array( &$this, 'submit_report_bug' ) );
		add_action( 'wp_ajax_upload_layout', array( &$this, 'upload_layout' ) );
		add_action( 'wp_ajax_update_whole_sc_content', array( &$this, 'update_whole_sc_content' ) );
		add_action( 'wp_ajax_shortcode_extract_param', array( &$this, 'shortcode_extract_param' ) );
		add_action( 'wp_ajax_get_json_custom', array( &$this, 'ajax_json_custom' ) );
		add_action( 'wp_ajax_get_shortcode_tpl', array( &$this, 'get_shortcode_tpl' ) );
		add_action( 'wp_ajax_get_default_shortcode_structure', array( &$this, 'get_default_shortcode_structure' ) );
		add_action( 'wp_ajax_get_settings_html', array( &$this, 'get_settings_html' ) );

		add_action( 'wp_ajax_text_to_pagebuilder', array( &$this, 'text_to_pagebuilder' ) );
		add_action( 'wp_ajax_get_html_content', array( &$this, 'get_html_content' ) );
		add_action( 'wp_ajax_get_same_elements', array( &$this, 'get_same_elements' ) );
		add_action( 'wp_ajax_merge_style_params', array( &$this, 'merge_style_params' ) );
		// add IGPB metabox
		add_action( 'add_meta_boxes', array( &$this, 'custom_meta_boxes' ) );

		// print html template of shortcodes
		add_action( 'admin_footer', array( &$this, 'element_tpl' ) );

		// add IGPB button to Wordpress TinyMCE
		add_filter( 'wp_default_editor', create_function('', 'return "html";') );
		add_filter( 'tiny_mce_before_init', array( &$this, 'tiny_mce_before_init' ) );
		if ( $this->check_support( 'has_editor' ) ) {
			add_action( 'media_buttons_context',  array( &$this, 'add_page_element_button' ) );
		}

		// Remove Gravatar from Ig Modal Pages
		if ( is_admin() ) {
			add_filter( 'bp_core_fetch_avatar', array( &$this, 'remove_gravatar' ), 1, 9 );
			add_filter( 'get_avatar', array( &$this, 'get_gravatar' ), 1, 5 );
		}

		// add body class in backend
		add_filter( 'admin_body_class', array( &$this, 'admin_bodyclass' ) );

		// get image size
		add_filter( 't4p_pb_get_json_image_size', array( &$this, 'get_image_size' ) );

		// Editor hook before & after
		add_action( 'edit_form_after_title', array( &$this, 'hook_after_title' ) );
		add_action( 'edit_form_after_editor', array( &$this, 'hook_after_editor' ) );

		// Frontend hook
		add_filter( 'post_class', array( &$this, 'wp_bodyclass' ) );
		add_action( 'wp_head', array( &$this, 'post_view' ) );
		add_action( 'wp_footer', array( &$this, 'enqueue_compressed_assets' ) );

		// Custom css
		add_action( 'wp_head', array( &$this, 'enqueue_custom_css' ), 25 );
		add_action( 'wp_head', array( $this, 'print_frontend_styles' ), 25 );
		
		// Register 't4p_installed_product' filter
		add_filter( 't4p_pb_installed_product', array( __CLASS__, 'register_product' ) );

		// Add Wp pointer style/script
		add_action( 'admin_enqueue_scripts', array( $this, 'add_wp_pointer_assets' ) );

		do_action( 't4p_pb_custom_hook' );

		// global variable iframe_load_completed to use in checking load iframe in Text Element Editor
		add_action( 'admin_head', array( &$this, 'add_custom_global_variable' ) );

		// Add wp editor html
		add_action( 't4p_pb_footer', array( __CLASS__, 'text_html_wp_editor' ) );

	}

	/**
	* Render html wp editor
	*/
	public static function text_html_wp_editor() {
		echo "<script type='text/html' id='tmpl-t4p-editor'>";
			wp_editor( '_T4P_CONTENT_', 'param-text', array(
										'textarea_name' => 'param-text',
										'textarea_rows' => 15,
										'editor_class' => 't4p_pb_editor'
									)
			);
		echo '</script>';
	}

	/**
	* use global variable for Text Element Editor in loading iframe
	*/

	function add_custom_global_variable () { 
	?>

		<script type="text/javascript">
			//alert("ss");
			var iframe_load_completed = false;

		</script>

	<?php 
	}

	/**
	 * Wp pointer style/script
	 */
	function add_wp_pointer_assets() {
		// Assume pointer shouldn't be shown
		$enqueue_pointer_script_style = false;

		// Get array list of dismissed pointers for current user and convert it to array
		$dismissed_pointers = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

		// If this post has not used PageBuilder
		global $post;
		$not_used_pb = isset( $post ) && ( 1 !== get_post_meta( $post->ID, '_t4p_page_active_tab' ) );

		// Check if our pointer is not among dismissed ones
		if( $not_used_pb && !in_array( 't4p_pb_settings_pointer', $dismissed_pointers ) ) {
			$enqueue_pointer_script_style = true;

			// Add footer scripts using callback function
			add_action( 'admin_print_footer_scripts', array( $this, 'custom_pointer_scripts' ) );
		}

		// Enqueue pointer CSS and JS files, if needed
		if( $enqueue_pointer_script_style ) {
			wp_enqueue_style( 'wp-pointer' );
			wp_enqueue_script( 'wp-pointer' );
		}
	}

	/**
	 * Show T4P Pagbuider pointer
	 */
	function custom_pointer_scripts() {
		// Pointer content
		$pointer_content  = sprintf( "<p style=\"font-weight:bold;\">%s!</p>", __( 'Start using the PageBuilder', 't4p-core' ) );
		?>

		<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			$('#t4p_editor_tabs').pointer({
				content:		'<?php echo $pointer_content; ?>',
				position:		{
									edge:	'left', // arrow direction
									align:	'center' // vertical alignment
								},
				pointerWidth:	350,
				close:			function() {
									$.post( ajaxurl, {
											pointer: 't4p_pb_settings_pointer', // pointer ID
											action: 'dismiss-wp-pointer'
									});
								}
			}).pointer('open');
		});
		//]]>
		</script>
		<?php
	}

	/**
	 * Apply 't4p_installed_product' filter.
	 *
	 * @param   array  $plugins  Array of installed Theme4press product.
	 *
	 * @return  array
	 */
	public static function register_product( $plugins ) {
		// Register product identification
		$plugins[] = T4P_PAGEBUILDER_IDENTIFICATION;

		return $plugins;
	}

	/**
	 * Save the envato settings
	 * @param unknown_type $arg_holder
	 * @param array $settings
	 */
//	function save_envato_settings( $arg_holder, $settings ) {
//		$option    = T4P_PAGEBUILDER_ITEM_ID . "_purchase_data";
//		// Check if the option existed
//		if ( get_option($option) ) {
//			update_option( $option,
//					array(
//						'username'      => $settings['envato_username'],
//						'api_key'       => $settings['envato_api_key'],
//						'purchase_code' => $settings['envato_purchase_code'],
//					)
//				);
//		}else{
//			add_option( $option,
//					array(
//						'username'      => $settings['envato_username'],
//						'api_key'       => $settings['envato_api_key'],
//						'purchase_code' => $settings['envato_purchase_code'],
//					)
//				);
//		}
//	}

	/**
	 * Get translation file
	 */
	function translation() {
		load_plugin_textdomain( 't4p-core', false, dirname( plugin_basename( T4P_CORE_FILE ) ) . '/languages/' );
	}

	/**
	 * Register custom asset files
	 *
	 * @param type $assets
	 * @return string
	 */
	function apply_assets( $assets ) {
		$assets['t4p-pb-frontend-css'] = array(
			'src' => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/css/front_end.css',
			'ver' => '1.0.0',
		);
		T4P_Pb_Helper_Functions::load_bootstrap_3( $assets );
		if ( ! is_admin() || T4P_Pb_Helper_Functions::is_preview() ) {
			$assets['t4p-pb-scrollreveal'] = array(
				'src' => T4P_Pb_Helper_Functions::path( 'assets/3rd-party/scrollreveal' ) . '/scrollReveal.js',
				'ver' => '0.1.2',
			);
			$assets['t4p-pb-stellar'] = array(
				'src' => T4P_Pb_Helper_Functions::path( 'assets/3rd-party/stellar' ) . '/stellar.js',
				'ver' => '0.6.2',
			);
		}
		$assets['t4p-pb-joomlashine-frontend-css'] = array(
			'src' => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/css/jsn-gui-frontend.css',
			'deps' => array( 't4p-pb-bootstrap-css' ),
		);
		$assets['t4p-pb-frontend-responsive-css'] = array(
			'src' => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/css/front_end_responsive.css',
			'ver' => '1.0.0',
		);
		$assets['t4p-pb-addpanel-js'] = array(
			'src' => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/js/add_page_builder.js',
			'ver' => '1.0.0',
		);
		$assets['t4p-pb-layout-js'] = array(
			'src' => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/js/layout.js',
			'ver' => '1.0.0',
		);
		$assets['t4p-pb-widget-js'] = array(
			'src' => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/js/widget.js',
			'ver' => '1.0.0',
		);
		$assets['t4p-pb-placeholder'] = array(
			'src' => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/js/placeholder.js',
			'ver' => '1.0.0',
		);
		$assets['t4p-pb-settings-js'] = array(
			'src' => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/js/product/settings.js',
			'ver' => '1.0.0',
		);
		$assets['t4p-pb-upgrade-js'] = array(
			'src' => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/js/product/upgrade.js',
			'ver' => '1.0.0',
		);
		$assets['t4p-pb-tinymce-btn'] = array(
			'src' => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/js/tinymce.js',
			'ver' => '1.0.0',
		);
		return $assets;
	}

	/**
	 * Enqueue scripts & style for Front end
	 */
	function frontend_scripts() {
		/* Load stylesheets */
		$t4p_pb_frontend_css = array( 't4p-pb-font-fontawesome-css', 't4p-pb-joomlashine-frontend-css', 't4p-pb-frontend-css', 't4p-pb-frontend-responsive-css' );

		T4P_Pb_Init_Assets::load( $t4p_pb_frontend_css );

		// Load scripts
		$t4p_pb_frontend_js = array( 't4p-pb-bootstrap-js', 't4p-pb-scrollreveal', 't4p-pb-stellar' );

		// Proceed element appearing animation
		T4P_Pb_Init_Assets::load( apply_filters( 't4p_pb_assets_enqueue_frontend',  $t4p_pb_frontend_js ) );
		T4P_Pb_Init_Assets::inline( 'js', "
			var T4P_Ig_RevealObjects  = null;
			var T4P_Ig_StellarObjects = null;
			$(document).ready(function (){
				// Enable Appearing animations for elements
				if($('[data-scroll-reveal]').length) {
					if (!T4P_Ig_RevealObjects) {
						T4P_Ig_RevealObjects = new scrollReveal({
						        reset: true
						    });
					}
				}
				// Enable paralax for row container
				if($('[data-stellar-background-ratio]').length) {
					if (!T4P_Ig_StellarObjects) {
						T4P_Ig_StellarObjects = $.stellar({
					        horizontalScrolling: false,
					        verticalOffset: 40
					    });
					}
				}
			});
		" );
	}

	/**
	 * Add T4P PageBuilder Metaboxes
	 */
	function custom_meta_boxes() {
		// Fixed bug header already send
		ob_start();
		if ( $this->check_support() ) {
			add_meta_box(
				't4p_page_builder',
			__( 'T4P PageBuilder', 't4p-core' ),
			array( &$this, 'page_builder_html' )
			);
		}

	}

	/**
	 * Content file for T4P PageBuilder Metabox
	 */
	function page_builder_html() {
		// Get available data converters
		$converters = T4P_Pb_Converter::get_converters();

		if ( @count( $converters ) ) {
			// Load script initialization for data conversion
			T4P_Pb_Init_Assets::load( 't4p-pb-convert-data-js' );
		}

		// Load script initialization for undo / redo action
		T4P_Pb_Init_Assets::load( 't4p-pb-activity-js' );

		include T4P_CORE_TPL_PATH . '/page-builder.php';
	}

	/**
	 * Register all Parent & No-child element, for Add Element popover
	 */
	function register_element() {
		global $t4p_pb_shortcodes, $theme_prefix;
		$current_shortcode = T4P_Pb_Helper_Functions::current_shortcode();
		$t4p_pb_shortcodes  = ! empty ( $t4p_pb_shortcodes ) ? $t4p_pb_shortcodes : T4P_Pb_Helper_Shortcode::t4p_pb_shortcode_tags();
		foreach ( $t4p_pb_shortcodes as $name => $sc_info ) {
			$arr  = explode( '_', $name );
			$type = $sc_info['type'];
			if ( ! $current_shortcode || ! is_admin() || in_array( $current_shortcode, $arr ) || ( ! $current_shortcode && $type == 'layout' ) ) {
				$class   = T4P_Pb_Helper_Shortcode::get_shortcode_class( $name );
				if ( class_exists( $class ) ) {
					$element = new $class();
                                        if ( $theme_prefix == 'alora_' && ( $class == 'Carousel_slide' || $class == 'Carousel' ) ){
                                        } else {
                                                if ( !class_exists('Woocommerce') && ( $class == 'Featured_products_slider' || $class == 'Products_slider' ) ){
                                                } else {
                                                        $this->set_element( $type, $class, $element );
                                                }
                                        }
					//				$this->register_sub_el( $class, 1 );
				}
			}
		}
	}

	/**
	 * Register IGPB Widget
	 */
	function register_widget(){
		register_widget( 'T4P_Pb_Objects_Widget' );
	}

	/**
	 * Regiter sub element
	 *
	 * @param string $class
	 * @param int $level
	 */
	private function register_sub_el( $class, $level = 1 ) {
		$item  = str_repeat( '', intval( $level ) - 1 );
		$class = str_replace( "$item", "$item", $class );
		if ( class_exists( $class ) ) {
			// 1st level sub item
			$element = new $class();
			$this->set_element( 'element', $class, $element );
			// 2rd level sub item
			$this->register_sub_el( $class, 2 );
		}
	}

	/**
	 * print HTML template of shortcodes
	 */
	function element_tpl() {
		ob_start();

		// Print template for T4P PageBuilder elements
		$elements = $this->get_elements();

		foreach ( $elements as $type_list ) {
			foreach ( $type_list as $element ) {
				// Get element type
				$element_type = $element->element_in_pgbldr( null, null, null, null, false);
				// Print template tag
				foreach ( $element_type as $element_structure ) {
					echo balanceTags( "<script type='text/html' id='tmpl-{$element->config['shortcode']}'>\n{$element_structure}\n</script>\n" );
				}
			}
		}

		// Print widget template
		global $t4p_pb_widgets;

		if ( class_exists( 'Widget' ) ) {
			foreach ( $t4p_pb_widgets as $shortcode => $shortcode_obj ) {
				// Instantiate Widget element
				$element = new Widget();

				// Prepare necessary variables
				$modal_title = $shortcode_obj['identity_name'];
				$content     = $element->config['exception']['data-modal-title'] = $modal_title;

				$element->config['shortcode']           = $shortcode;
				$element->config['shortcode_structure'] = T4P_Pb_Utils_Placeholder::add_placeholder( "[widget widget_id=\"$shortcode\"]%s[/widget]", 'widget_title' );
				$element->config['el_type']             = 'widget';

				// Get element type
				$element_type = $element->element_in_pgbldr( null, null, null, null, false);

				// Print template tag
				foreach ( $element_type as $element_structure ) {
					echo balanceTags( "<script abc type='text/html' id='tmpl-{$shortcode}'>\n{$element_structure}\n</script>\n" );
				}
			}
		}

		// Allow printing extra footer
		do_action( 't4p_pb_footer' );

		ob_end_flush();
	}

	/**
	 * Show Modal page
	 */
	function modal_register() {
		if ( T4P_Pb_Helper_Functions::is_modal() ) {
			$cls_modal = T4P_Pb_Objects_Modal::get_instance();
			if ( ! empty( $_GET['t4p_modal_type'] ) )
				$cls_modal->preview_modal();
			if ( ! empty( $_GET['t4p_layout'] ) )
				$cls_modal->preview_modal( '_layout' );
			if ( ! empty( $_GET['t4p_custom_css'] ) )
				$cls_modal->preview_modal( '_custom_css' );
			if ( ! empty( $_GET['t4p_report_bug'] ) )
				$cls_modal->preview_modal( '_report_bug' );
			if ( ! empty( $_GET['t4p_add_element'] ) )
				$cls_modal->preview_modal( '_add_element' );
		}
	}

	/**
	 * Do action on modal page hook
	 */
	function modal_page_content() {
		do_action( 't4p_pb_modal_page_content' );
	}

	/**
	 * Save T4P PageBuilder shortcode content of a post/page
	 *
	 * @param int $post_id
	 * @return type
	 */
	function save_pagebuilder_content( $post_id ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

		if ( ! isset($_POST[T4P_NONCE . '_builder'] ) || ! wp_verify_nonce( $_POST[T4P_NONCE . '_builder'], 't4p_builder' ) ) {
			return;
		}

		$t4p_deactivate_pb = intval( esc_sql( $_POST['t4p_deactivate_pb'] ) );

		if ( $t4p_deactivate_pb ) {
			T4P_Pb_Utils_Common::delete_meta_key( array( '_t4p_page_builder_content', '_t4p_html_content', '_t4p_page_active_tab', '_t4p_post_view_count' ), $post_id );
		} else {
			$t4p_active_tab = intval( esc_sql( $_POST['t4p_active_tab'] ) );
			$post_content  = '';

			// T4P PageBuilder is activate
			if ( $t4p_active_tab ) {
				$data = array();

				if ( isset( $_POST['shortcode_content'] ) && is_array( $_POST['shortcode_content'] ) ) {
					foreach ( $_POST['shortcode_content'] as $shortcode ) {
						$data[] = trim( stripslashes( $shortcode ) );
					}
				} else {
					$data[] = '';
				}

				$post_content = T4P_Pb_Utils_Placeholder::remove_placeholder( implode( '', $data ), 'wrapper_append', '' );

				// update post meta
				update_post_meta( $post_id, '_t4p_page_builder_content', $post_content );
				update_post_meta( $post_id, '_t4p_html_content', T4P_Pb_Helper_Shortcode::doshortcode_content( $post_content ) );
                                
                                // update current active tab
                                update_post_meta( $post_id, '_t4p_page_active_tab', $t4p_active_tab );
                                update_post_meta( $post_id, '_t4p_editor_tab', 1 );
			}
			else {
				$post_content = stripslashes( $_POST['content'] );
                                update_post_meta( $post_id, '_t4p_page_builder_content', $post_content );
                                update_post_meta( $post_id, '_t4p_editor_tab', 0 );
                                preg_replace_callback( '/\[widget\s+([A-Za-z0-9_-]+=\"[^"\']*\"\s*)*\s*\](.*)\[\/widget\]/Us', array( 'T4P_Pb_Helper_Shortcode', 'classic_editor_widget' ), $post_content );
			}
		}

		// update whether or not deactive pagebuilder
		update_post_meta( $post_id, '_t4p_deactivate_pb', $t4p_deactivate_pb );
	}

	/**
	 * Render shortcode preview in a blank page
	 *
	 * @return Ambigous <string, mixed>|WP_Error
	 */
	function shortcode_iframe_preview() {

		if ( isset( $_GET['t4p_shortcode_preview'] ) ) {
			if ( ! isset($_GET['t4p_shortcode_name'] ) || ! isset( $_POST['params'] ) )
			return __( 'empty shortcode name / parameters', 't4p-core' );

			if ( ! isset($_GET[T4P_NONCE] ) || ! wp_verify_nonce( $_GET[T4P_NONCE], T4P_NONCE ) )
			return;

			$shortcode = esc_sql( $_GET['t4p_shortcode_name'] );
			$params    = urldecode( $_POST['params'] );
			$pattern   = '/^\[widget/i';
			if ( ! preg_match( $pattern, trim( $params ) ) ) {
				// get shortcode class
				$class = T4P_Pb_Helper_Shortcode::get_shortcode_class( $shortcode );

				// get option settings of shortcode
				$elements = $this->get_elements();
				$element  = isset( $elements['element'][strtolower( $class )] ) ? $elements['element'][strtolower( $class )] : null;
				if ( ! is_object( $element ) )
				$element = new $class();

				if ( $params ) {
					$extract_params = T4P_Pb_Helper_Shortcode::extract_params( $params, $shortcode );
				} else {
					$extract_params = $element->config;
				}

				$element->shortcode_data();

				$_shortcode_content = $extract_params['_shortcode_content'];
				$content = $element->element_shortcode( $extract_params, $_shortcode_content );
			} else {
				$class = 'Widget';
				$content = T4P_Pb_Helper_Shortcode::widget_content( array( $params ) );
			}
			global $t4p_pb_preview_class;
			$t4p_pb_preview_class = $class;

			$html  = '<div id="shortcode_inner_wrapper" class="jsn-bootstrap3"><fieldset>';
			$html .= $content;
			$html .= '</fieldset></div>';
			echo balanceTags( $html );
		}
	}

	/**
	 * Update Shortcode content by merge its content & sub-shortcode content
	 */
	function update_whole_sc_content() {
		if ( ! isset($_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) )
		return;

		$shortcode_content     = $_POST['shortcode_content'];
		$sub_shortcode_content = $_POST['sub_shortcode_content'];
		echo balanceTags( T4P_Pb_Helper_Shortcode::merge_shortcode_content( $shortcode_content, $sub_shortcode_content ) );

		exit;
	}

	/**
	 * extract a param from shortcode data
	 */
	function shortcode_extract_param() {
		if ( ! isset($_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) )
		return;

		$data		  = $_POST['data'];
		$extract_param = $_POST['param'];
		$extract       = array();
		$shortcodes    = T4P_Pb_Helper_Shortcode::extract_sub_shortcode( $data );
		foreach ( $shortcodes as $shortcode ) {
			$shortcode    = stripslashes( $shortcode );
			$parse_params = shortcode_parse_atts( $shortcode );
			$extract[]    = isset( $parse_params[$extract_param] ) ? trim( $parse_params[$extract_param] ) : '';
		}
		$extract = array_filter( $extract );
		$extract = array_unique( $extract );

		echo balanceTags( implode( ',', $extract ) );
		exit;
	}

	function ajax_json_custom() {
		if ( ! isset($_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) )
		return;

		if ( ! $_POST['custom_type'] )
		return 'false';

		$response = apply_filters( 't4p_pb_get_json_' . $_POST['custom_type'], $_POST );
		echo balanceTags( $response );

		exit;
	}

	/**
	 * Get shortcode structure with default attributes
	 * eg: [t4p_text title="The text"]Lorem ipsum[/t4p_text]
	 * Enter description here ...
	 */
	function get_default_shortcode_structure() {
		if ( ! isset($_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) )
		return;
		if ( ! $_POST['shortcode'] )
		return;
		$shortcode = $_POST['shortcode'];
		$class     = T4P_Pb_Helper_Shortcode::get_shortcode_class( $shortcode );
		if ( class_exists( $class ) ) {
			$element   = new $class();
			if ( method_exists( $element, 'init_element' ) ) {
				$element->init_element();
			}
			$shortcode_structure = isset( $element->config['shortcode_structure'] ) ? $element->config['shortcode_structure'] : '';

			if ( strpos( $shortcode, '' ) === false ) {
				// Replace _T4P_INDEX_ with index string when call generate shortcode first.
				$this->index_shortcode_item = 1;
				$shortcode_structure        = preg_replace_callback( '/_T4P_INDEX_/', array( &$this, 'replace_index_count' ), $shortcode_structure );
			}

			echo $shortcode_structure;
		}

		exit;
	}

	/**
	 * Replace _T4P_INDEX_ with index string in shortcode
	 *
	 * @param string $matches
	 * @return string
	 */
	private function replace_index_count( $matches ) {
		return $this->index_shortcode_item++;
	}

	/**
	 * Get settings HTML modal from shortcode content
	 *
	 * @return html
	 */
	function get_settings_html() {
		if ( ! isset($_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) )
		return;

		$shortcode      = $_POST['shortcode'];
		$shortcode_data = $_POST['data'];

		$sub_el_settings = T4P_Pb_Objects_Modal::shortcode_modal_settings( $shortcode, stripslashes( $shortcode_data ), '', true );
		printf( "<div class='sub-element-settings form' style='display: none'>%s</div>", balanceTags( $sub_el_settings ) );

		exit;
	}

	/**
	 * Update PageBuilder when switch Classic Editor to T4P PageBuilder
	 *
	 * @return string
	 */
	function text_to_pagebuilder() {
		if ( ! isset($_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) )
		return;

		if ( ! isset( $_POST['content'] ) )
		return;
		// $content = urldecode( $_POST['content'] );
		$content = ( $_POST['content'] );
		$content = stripslashes( $content );

		$empty_str = T4P_Pb_Helper_Shortcode::check_empty_( $content );
		if ( strlen( trim( $content ) ) && strlen( trim( $empty_str ) ) ) {
			$builder = new T4P_Pb_Helper_Shortcode();

			// remove wrap p tag
			$content = preg_replace( '/^<p>(.*)<\/p>$/', '$1', $content );
			$content = balanceTags( $content );

                        echo balanceTags( $builder->do_shortcode_admin( $content, false, true ) );
                } else {
                        echo '';
		}

		exit;
	}

	/**
	 * Show T4P PageBuilder content for Frontend post
	 *
	 * @param string $content
	 * @return string
	 */
	function pagebuilder_to_frontend( $content ) {
		global $post;

		// Get what tab (Classic - Pagebuilder) is active when Save content of this post
		$t4p_page_active_tab = get_post_meta( $post->ID, '_t4p_page_active_tab', true );

		$t4p_deactivate_pb = get_post_meta( $post->ID, '_t4p_deactivate_pb', true );

		// Check password protected in post
		$allow_show_post = false;
		if ( 'publish' == $post->post_status && empty( $post->post_password ) ) {
			$allow_show_post = true;
		}

		// if Pagebuilder is active when save and pagebuilder is not deactivate on this post
		if ( $t4p_page_active_tab && empty( $t4p_deactivate_pb ) && $allow_show_post == true ) {
			$t4p_pagebuilder_content = get_post_meta( $post->ID, '_t4p_page_builder_content', true );
			if ( ! empty( $t4p_pagebuilder_content ) ) {
				// remove placeholder text which was inserted to &lt; and &gt;
				$t4p_pagebuilder_content = T4P_Pb_Utils_Placeholder::remove_placeholder( $t4p_pagebuilder_content, 'wrapper_append', '' );

				$t4p_pagebuilder_content = preg_replace_callback(
						'/\[widget\s+([A-Za-z0-9_-]+=\"[^"\']*\"\s*)*\s*\](.*)\[\/widget\]/Us', array( 'T4P_Pb_Helper_Shortcode', 'widget_content' ), $t4p_pagebuilder_content
				);

				$content = $t4p_pagebuilder_content;
			}
		}

		return $content;
	}

	/**
	 * Get output html of pagebuilder content
	 */
	function get_html_content() {
		if ( ! isset($_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) )
		return;

		$content = $_POST['content'];
		$content = stripslashes( $content );
		$content = T4P_Pb_Helper_Shortcode::doshortcode_content( $content );

		if ( ! empty( $content ) ) {
			echo "<div class='jsn-bootstrap3'>" . $content . '</div>';
		}
		exit;
	}

	/**
	 * Check condition to load T4P PageBuilder content & assets.
	 *
	 * @return  boolean
	 */
	function check_support( $has_editor = false ) {
		global $pagenow, $post;

		if ( 'post.php' == $pagenow || 'post-new.php' == $pagenow || 'widgets.php' == $pagenow || 'admin.php' == $pagenow ) {
			if ( 'widgets.php' != $pagenow && ! empty( $post->ID ) ) {
				// Check if T4P PageBuilder is enabled for this post type
				$settings  = T4P_Pb_Product_Plugin::t4p_pb_settings_options();
				$post_type = get_post_type( $post->ID );

				// Only want to check whether has Editor or not
				if ( $has_editor ) {
					return post_type_supports( $post_type, 'editor' );
				}

				// Whether PageBuilder is enable for this post type or not
				if ( is_array( $settings['t4p_pb_settings_enable_for'] ) ) {
					if ( isset( $settings['t4p_pb_settings_enable_for'][ $post_type ] ) ) {
						return ( 'enable' == $settings['t4p_pb_settings_enable_for'][ $post_type ] );
					} else {
						return post_type_supports( $post_type, 'editor' );
					}
				} elseif ( 'enable' == $settings['t4p_pb_settings_enable_for'] ) {
					return post_type_supports( $post_type, 'editor' );
				}
			}

			return true;
		}

		return false;
	}

	/**
	 * Method to preload Elements list popup HTML
	 *
	 * @return void
	 */
	function load_elements_list() {
		if ( $this->check_support() ) {
			ob_start();
			include T4P_CORE_TPL_PATH . '/select-elements.php';
			ob_flush();
		}
	}

	/**
	 * Load necessary assets.
	 *
	 * @return  void
	 */
	function load_assets() {
		if ( $this->check_support( 'has_editor' ) ) {
			// Load styles
			T4P_Pb_Helper_Functions::enqueue_styles();

			// Load scripts
			T4P_Pb_Helper_Functions::enqueue_scripts();

			$scripts = array( 't4p-pb-jquery-select2-js', 't4p-pb-addpanel-js', 't4p-pb-jquery-resize-js', 't4p-pb-joomlashine-modalresize-js', 't4p-pb-layout-js', 't4p-pb-placeholder', 't4p-pb-tinymce-btn' );
			T4P_Pb_Init_Assets::load( apply_filters( 't4p_pb_assets_enqueue_admin', $scripts ) );

			T4P_Pb_Helper_Functions::enqueue_scripts_end();
		}
	}

	/**
	 * Register pagebuilder widget assets
	 *
	 * @return void
	 */
	function widget_register_assets() {
		global $pagenow;

		if ( $pagenow == 'widgets.php' ) {
			// enqueue admin script
			if ( function_exists( 'wp_enqueue_media' ) ) {
				wp_enqueue_media();
			} else {
				wp_enqueue_style( 'thickbox' );
				wp_enqueue_script( 'media-upload' );
				wp_enqueue_script( 'thickbox' );
			}
			$this->load_assets();
			T4P_Pb_Init_Assets::load( 't4p-pb-handlesetting-js' );
			T4P_Pb_Init_Assets::load( 't4p-pb-jquery-fancybox-js' );
			T4P_Pb_Init_Assets::load( 't4p-pb-widget-js' );
		}
	}

	/**
	 * Add Inno Button to Classic Editor
	 *
	 * @param array $context
	 * @return array
	 */
	function add_page_element_button( $context ) {
		//$icon_url = T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/images/t4p-pgbldr-icon-black.png';
		//$context .= '<a title="' . __( 'Add Page Element', 't4p-core' ) . '" class="button" id="t4p_pb_button" href="#"><i class="mce-ico mce-i-none" style="background-image: url(\'' . $icon_url . '\')"></i>' . __( 'Add Page Element', 't4p-core' ) . '</a>';

		return $context;
	}

	function tiny_mce_before_init( $init ) {
		$init['setup'] = <<<JS
[function(ed) {
    ed.on('blur', function(ed) {
        tinyMCE.triggerSave();
                jQuery('.t4p_pb_editor').first().trigger('change');
    });
}][0]
JS;

		return $init;
	}

	/**
	 * Gravatar : use default avatar, don't request from gravatar server
	 *
	 * @param type $image
	 * @param type $params
	 * @param type $item_id
	 * @param type $avatar_dir
	 * @param type $css_id
	 * @param type $html_width
	 * @param type $html_height
	 * @param type $avatar_folder_url
	 * @param type $avatar_folder_dir
	 * @return type
	 */
	function remove_gravatar( $image, $params, $item_id, $avatar_dir, $css_id, $html_width, $html_height, $avatar_folder_url, $avatar_folder_dir ) {

		$default = T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/images/default_avatar.png';

		if ( $image && strpos( $image, 'gravatar.com' ) ) {

			return '<img src="' . $default . '" alt="avatar" class="avatar" ' . $html_width . $html_height . ' />';
		} else {
			return $image;
		}
	}

	/**
	 * Gravatar : use default avatar
	 *
	 * @param type $avatar
	 * @param type $id_or_email
	 * @param type $size
	 * @param string $default
	 * @return type
	 */
	function get_gravatar( $avatar, $id_or_email, $size, $default ) {
		$default = T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/images/default_avatar.png';
		return '<img src="' . $default . '" alt="avatar" class="avatar" width="60" height="60" />';
	}

	/**
	 * Add admin body class
	 *
	 * @param string $classes
	 * @return string
	 */
	function admin_bodyclass( $classes ) {
		$classes .= ' jsn-master';
		if ( isset($_GET['t4p_load_modal'] ) AND isset( $_GET['t4p_modal_type']) ) {
			$classes .= ' contentpane';
		}
		return $classes;
	}

	/**
	 * Get image size
	 *
	 * @param array $post_request
	 * @return string
	 */
	function get_image_size( $post_request ) {
		$response  = '';
		$image_url = $post_request['image_url'];

		if ( $image_url ) {
			$image_id   = T4P_Pb_Helper_Functions::get_image_id( $image_url );
			$attachment = wp_prepare_attachment_for_js( $image_id );
			if ( $attachment['sizes'] ) {
				$sizes		       = $attachment['sizes'];
				$attachment['sizes'] = null;
				foreach ( $sizes as $key => $item ) {
					$item['total_size']	= $item['height'] + $item['width'];
					$attachment['sizes'][ucfirst( $key )] = $item;
				}
			}
			$response = json_encode( $attachment );
		}

		return $response;
	}

	/**
	 * Filter frontend body class
	 *
	 * @param array $classes
	 * @return array
	 */
	function wp_bodyclass( $classes ) {
		$classes[] = 'jsn-master';
		return $classes;
	}

	/**
	 * Update post view in frontend
	 *
	 * @global type $post
	 * @return type
	 */
	function post_view() {
		global $post;
		if ( ! isset($post ) || ! is_object( $post ) )
		return;
		if ( is_single( $post->ID ) ) {
			T4P_Pb_Helper_Functions::set_postview( $post->ID );
		}
	}

	/**
	 * Add custom HTML code after title in Post editing page
	 *
	 * @global type $post
	 */
	function hook_after_title() {
		global $post;
		if ( $this->check_support() ) {
			$t4p_pagebuilder_content = get_post_meta( $post->ID, '_t4p_page_builder_content', true );

			// Get active tab
			$t4p_page_active_tab = get_post_meta( $post->ID, '_t4p_editor_tab', true );
			$tab_active         = isset( $t4p_page_active_tab ) ? intval( $t4p_page_active_tab ) : ( ! empty( $t4p_pagebuilder_content ) ? 1 : 0 );

			// Deactivate pagebuilder
			$t4p_deactivate_pb = get_post_meta( $post->ID, '_t4p_deactivate_pb', true );
			$t4p_deactivate_pb = isset( $t4p_deactivate_pb ) ? intval( $t4p_deactivate_pb ) : 0;

			$wrapper_style = $tab_active ? 'style="display:none"' : '';

			// Get array list of dismissed pointers for current user and convert it to array
			$dismissed_pointers = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

			// If this post has not used PageBuilder
			global $post;
			$not_used_pb = isset( $post ) && ( 1 !== get_post_meta( $post->ID, '_t4p_page_active_tab' ) );
			
			// Check if our pointer is not among dismissed ones
			$translate = NULL;
			$current_lang = get_option( 'WPLANG' );
			
			if( $current_lang && !preg_match("/^en/", $current_lang) && $not_used_pb && !in_array( 't4p_pb_settings_pointer_translate', $dismissed_pointers ) ){
				
				$language = 'your language';
				if (file_exists(ABSPATH . 'wp-admin/includes/translation-install.php')) {
					require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
					$translations = wp_get_available_translations();
					$language = $translations[$current_lang]['native_name'];
				}
				
				$translate = '
					<div id="translation-transifex">
						<p>
							<a target="_blank" href="http://goo.gl/Sg2owo">'.sprintf(__('Help translate T4P PageBuilder to %s.') , $language).'</a>
							<span id="t4p-close"></span>
						</p>
					</div>
					<script type="text/javascript">
						jQuery(document).ready( function($) {
							$("#t4p-close").click(function(e){
								$.post( ajaxurl, {
										pointer: "t4p_pb_settings_pointer_translate", // pointer ID
										action: "dismiss-wp-pointer"
								});
								$("#translation-transifex").hide();
							})
						});
					</script>
				';
			}

			echo '
				<input id="t4p_active_tab" name="t4p_active_tab" value="' . $tab_active . '" type="hidden">
				<input id="t4p_deactivate_pb" name="t4p_deactivate_pb" value="' . $t4p_deactivate_pb . '" type="hidden">
				<div class="jsn-bootstrap3 t4p-editor-wrapper" ' . $wrapper_style . '>
					<ul class="nav nav-tabs" id="t4p_editor_tabs">
						<li class="active"><a href="#t4p_editor_tab1"><i class="icon-wordpress"></i> ' . __( 'Standard Editor', 't4p-core' ) . '</a></li>
						<li><a href="#t4p_editor_tab2"><span class="t4p-pb-icon-editor"></span> ' . __( 'Theme4Press Composer', 't4p-core' ) . '</a></li>
					</ul>
					'.$translate.'
					<div class="tab-content t4p-editor-tab-content">
						<div class="tab-pane active" id="t4p_editor_tab1">';
		}
	}

	/**
	 * Add custom HTML code after text editor in Post editing page
	 *
	 * @global type $post
	 */
	function hook_after_editor() {
		if ( $this->check_support() ) {
			echo '</div><div class="tab-pane" id="t4p_editor_tab2"><div id="t4p_before_pagebuilder"></div></div></div></div>';
		} else {
			echo '<div class="tab-pane" id="t4p_editor_tab2" style="display:none">'
			. '<div id="t4p_before_pagebuilder">'
			. '<div class="jsn-section-content jsn-style-light" id="form-design-content">'
			. '<div class="t4p-pb-form-container jsn-layout"></div>'
			. '</div>'
			. '</div>'
			. '</div>';
		}
	}

	/**
	 * Compress asset files
	 */
	function enqueue_compressed_assets() {
		if ( ! empty ( $_SESSION['t4p-pb-assets-frontend'] ) ) {
			global $post;
			if ( empty ( $post ) )
			exit;
			$t4p_pb_settings_cache = get_option( 't4p_pb_settings_cache', 'enable' );
			if ( $t4p_pb_settings_cache != 'enable' ) {
				exit;
			}
			$contents_of_type = array();
			$this_session     = $_SESSION['t4p-pb-assets-frontend'][$post->ID];
			// Get content of assets file from shortcode directories
			foreach ( $this_session as $type => $list ) {
				$contents_of_type[$type] = array();
				foreach ( $list as $path => $modified_time ) {
					$fp = @fopen( $path, 'r' );
					if ( $fp ) {
						$contents_of_type[$type][$path] = fread( $fp, filesize( $path ) );
						fclose( $fp );
					}
				}
			}
			// T4pite content of css, js to 2 seperate files
			$cache_dir = T4P_Pb_Helper_Functions::get_wp_upload_folder( '/igcache/pagebuilder' );
			foreach ( $contents_of_type as $type => $list ) {
				$handle_info   = $this_session[$type];
				$hash_name     = md5( implode( ',', array_keys( $list ) ) );
				$file_name     = "$hash_name.$type";
				$file_to_write = "$cache_dir/$file_name";

				// check stored data
				$store = T4P_Pb_Helper_Functions::compression_data_store( $handle_info, $file_name );

				if ( $store[0] == 'exist' ) {
					$file_name     = $store[1];
					$file_to_write = "$cache_dir/$file_name";
				} else {
					$fp = fopen( $file_to_write, 'w' );
					$handle_contents = implode( "\n/*------------------------------------------------------------*/\n", $list );
					fwrite( $fp, $handle_contents );
					fclose( $fp );
				}

				// Enqueue script/style to footer of page
				if ( file_exists( $file_to_write ) ) {
					$function = ( $type == 'css' ) ? 'wp_enqueue_style' : 'wp_enqueue_script';
					$function( $file_name, T4P_Pb_Helper_Functions::get_wp_upload_url( '/igcache/pagebuilder' ) . "/$file_name" );
				}
			}
		}
	}

	/**
	 * Clear cache files
	 *
	 * @return type
	 */
	function igpb_clear_cache() {
		if ( ! isset($_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) )
		return;

		$delete = T4P_Pb_Utils_Common::remove_cache_folder();

		echo balanceTags( $delete ? __( '<i class="icon-checkmark"></i>', 't4p-core' ) : __( "Fail. Can't delete cache folder", 't4p-core' ) );

		exit;
	}

	/*
	 * Function to process when submit report bug
	 */
	function submit_report_bug() {
		if ( ! isset( $_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) ) return;

		$data = isset( $_POST['data'] ) ? $_POST['data'] : '';
		$result = false;
		if ( is_array( $data ) && ! empty( $data ) ) {
			$arr_params = array();
			foreach ( $data as $i => $item ) {
				$arr_params[$item['name']] = $item['value'];
			}
			extract( $arr_params );

			// Configure for email received report bug
			$email   = 'theme4press@gmail.com';
			$subject = __( 'T4P PageBuilder Bug Report', 't4p-core' );
			$message = "
				<b>- Description:</b> {$t4p_description}
			<br />
				<b>- Browser:</b> {$t4p_browser}
			<br />
				<b>- Attachment path:</b> {$t4p_attachment}
			<br />
				</b>- URL:</b> {$t4p_url}
			";
			$headers = array('Content-Type: text/html; charset=UTF-8');
			$attachment_path = get_attached_file( $t4p_attachment_id );

			$attachment = ( ! empty( $attachment_path ) ) ? array( $attachment_path ) : null;
			if ( $email ) {
				$result = wp_mail( $email, $subject, $message, $headers, $attachment );
			}
		}

		if ( $result == true ) {
			echo '1';
		} else {
			echo '0';
		}
		exit;
	}

	/**
	 * Save premade layout to file
	 *
	 * @return type
	 */
	function save_layout() {
		if ( ! isset($_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) )
		return;

		$layout_name    = $_POST['layout_name'];
		$layout_content = stripslashes( $_POST['layout_content'] );

		$error = T4P_Pb_Helper_Layout::save_premade_layouts( $layout_name, $layout_content );

		echo intval( $error ) ? 'error' : 'success';

		exit;
	}

	/**
	 * Upload premade layout to file
	 *
	 * @return type
	 */
	function upload_layout() {
		if ( ! isset($_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) )
		return;

		$status = 0;
		if ( ! empty ( $_FILES ) ) {
			$fileinfo = $_FILES['file'];
			$file     = $fileinfo['tmp_name'];
			$tmp_file = 'tmp-layout-' . time();
			$dest     = T4P_Pb_Helper_Functions::get_wp_upload_folder( '/t4p-pb-layout/' . $tmp_file );
			if ( $fileinfo['type'] == 'application/octet-stream' ) {
				WP_Filesystem();
				$unzipfile = unzip_file( $file, $dest );
				if ( $unzipfile ) {
					// explore extracted folder to get provider info
					$status = T4P_Pb_Helper_Layout::import( $dest );
				}
				// remove zip file
				unlink( $file );
			}
			T4P_Pb_Utils_Common::recursive_delete( $dest );
		}
		echo intval( $status );

		exit;
	}

	/**
	 * Get list of Page template
	 *
	 * @return type
	 */
	function reload_layouts_box() {
		if ( ! isset($_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) )
		return;

		include T4P_CORE_TPL_PATH . '/layout/list.php';

		exit;
	}

	/**
	 * Delete group layout
	 *
	 * @return html
	 */
	function delete_layouts_group() {
		if ( ! isset( $_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) ) {
			return;
		}

		$group  = sanitize_key( $_POST['group'] );
		$delete = T4P_Pb_Helper_Layout::remove_group( $group );

		include T4P_CORE_TPL_PATH . '/layout/list.php';

		exit;
	}

	/**
	 * Delete layout
	 *
	 * @return int
	 */
	function delete_layout() {
		if ( ! isset( $_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) ) {
			return;
		}

		$group  = sanitize_key( $_POST['group'] );
		$layout = urlencode( $_POST['layout'] );
		$delete = T4P_Pb_Helper_Layout::remove_layout( $group, $layout );

		echo esc_html( $delete ? 1 : 0 );

		exit;
	}

	/**
	 * Save custom CSS information: files, code
	 *
	 * @return void
	 */
	function save_css_custom() {
		if ( ! isset( $_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) ) {
			return;
		}

		$post_id = esc_sql( $_POST['post_id'] );
		// save custom css code & files
		T4P_Pb_Helper_Functions::custom_css( $post_id, 'css_files', 'put', esc_sql( $_POST['css_files'] ) );
		T4P_Pb_Helper_Functions::custom_css( $post_id, 'css_custom', 'put', esc_textarea( $_POST['custom_css'] ) );

		exit;
	}

	/**
	 * Get same type elements in a text
	 *
	 * @return type
	 */
	function get_same_elements() {
		if ( ! isset($_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) )
		return;
		$shortcode_name  = $_POST['shortcode_name'];
		$content         = $_POST['content'];

		// replace opening tag
		$regex   = '\\[' // Opening bracket
		. '(\\[?)' // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
		. "($shortcode_name)" // 2: Shortcode name
		. '(?![\\w-])' // Not followed by word character or hyphen
		. '(' // 3: Unroll the loop: Inside the opening shortcode tag
		. '[^\\]\\/]*' // Not a closing bracket or forward slash
		. '(?:'
		. '\\/(?!\\])' // A forward slash not followed by a closing bracket
		. '[^\\]\\/]*' // Not a closing bracket or forward slash
		. ')*?'
		. ')'
		. '(?:'
		. '(\\/)' // 4: Self closing tag ...
		. '\\]' // ... and closing bracket
		. '|'
		. '\\]' // Closing bracket
		. ')'
		. '(\\]?)'; // 6: Optional second closing brocket for escaping shortcodes: [[tag]]

		preg_match_all('#' . $regex . '#', $content, $out, PREG_SET_ORDER);

		$select_options   = array();
		$options          = array();

		$k = 0;
		foreach ( $out as $el ) {
			$extracted_params  = T4P_Pb_Helper_Shortcode::extract_params($el[0]);
			if ( $extracted_params ) {
				$k ++;
				$el_title   = $extracted_params['el_title'] ? $extracted_params['el_title'] : __( '(Untitled)', 't4p-core' );
				// Append unique number to ensure array key is unique
				// for sorting purpose.
				if ( isset( $options[$el_title] ) ) {
					$options[$el_title . "___" . $k ] = $el[0];
				}else{
					$options[$el_title] = $el[0];
				}

			}
		}

		if ( count( $options ) ) {
			// Sort the options by title
			ksort( $options );

			foreach ( $options as $title => $value ) {
				if ( stripos( $value, '#_EDITTED' ) === false ) {
					if ( strpos( $title, "___" ) !== false ) {
						$title = substr( $title, 0, strpos( $title, "___" ) );
					}
					$select_options[]  = "<option value='" . $value . "'>" . $title . '</option>';
				}
			}

		}

		// Print out the options HTML for select box
		echo implode('', $select_options);
		exit;
	}

	/**
	 * Merge new style params to existed shortcode content
	 *
	 * @return type
	 */
	function merge_style_params() {
		if ( ! isset($_POST[T4P_NONCE] ) || ! wp_verify_nonce( $_POST[T4P_NONCE], T4P_NONCE ) )
		return;
		$shortcode_name  = $_POST['shortcode_name'];
		$structure       = str_replace( "\\", "", $_POST['content'] );
		$alter_structure = str_replace( "\\", "", $_POST['new_style_content'] );

		// Extract params of current element
		$params    = T4P_Pb_Helper_Shortcode::extract_params( $structure, $shortcode_name );

		// Extract styling params of copied element
		$alter_params  = T4P_Pb_Helper_Shortcode::get_styling_atts( $shortcode_name , $alter_structure );

		// Alter params of current element by copied element's params
		if ( count( $alter_params ) ) {
			foreach ( $alter_params as $k => $v ) {
				$params[$k]    = $v;
			}
		}

		$_shortcode_content = '';
		// Exclude shortcode_content from param list
		if ( isset ( $params['_shortcode_content'] ) ) {
			$_shortcode_content  = $params['_shortcode_content'];
			unset ($params['_shortcode_content']);
		}

		$new_shortcode_structure = T4P_Pb_Helper_Shortcode::join_params($params, $shortcode_name, $_shortcode_content );
		// Print out new shortcode structure.
		echo $new_shortcode_structure;
		exit;
	}

	/**
	 * Echo custom css code, link custom css files
	 */
	function enqueue_custom_css() {
		global $post;
		if ( ! isset( $post ) || ! is_object( $post ) ) {
			return;
		}

		$t4p_deactivate_pb = get_post_meta( $post->ID, '_t4p_deactivate_pb', true );

		// if not deactivate pagebuilder on this post
		if ( empty( $t4p_deactivate_pb ) ) {

			$custom_css_data = T4P_Pb_Helper_Functions::custom_css_data( isset ( $post->ID ) ? $post->ID : NULL );
			extract( $custom_css_data );

			$css_files = stripslashes( $css_files );

			if ( ! empty( $css_files ) ) {
				$css_files = json_decode( $css_files );
				$data      = $css_files->data;

				foreach ( $data as $idx => $file_info ) {
					$checked = $file_info->checked;
					$url     = $file_info->url;

					// if file is checked to load, enqueue it
					if ( $checked ) {
						wp_enqueue_style( 't4p-pb-custom-file-' . $post->ID . '-' . $idx, $url );
					}
				}
			}
		}
	}

	/**
	 * Print style on front-end
	 */
	function print_frontend_styles() {
		global $post;
		if ( ! isset( $post ) || ! is_object( $post ) ) {
			return;
		}

		$t4p_deactivate_pb = get_post_meta( $post->ID, '_t4p_deactivate_pb', true );

		// if not deactivate pagebuilder on this post
		if ( empty( $t4p_deactivate_pb ) ) {

			$custom_css_data = T4P_Pb_Helper_Functions::custom_css_data( isset ( $post->ID ) ? $post->ID : NULL );
			extract( $custom_css_data );

			$css_custom = html_entity_decode( stripslashes( $css_custom ) );

			echo balanceTags( "<style id='t4p-pb-custom-{$post->ID}-css'>\n$css_custom\n</style>\n" );
		}
	}
}