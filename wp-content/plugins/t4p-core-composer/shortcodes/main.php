<?php

/**
 * @version    1.0.0
 * @package    Theme4Press PageBuilder
 * @author     Theme4Press 
 *
 */

/**
 * @todo : Define information of Build-in Shortcodes of T4P PageBuilder
 */

add_action( 't4p_pb_addon', 't4p_pb_builtin_sc_init' );

function t4p_pb_builtin_sc_init() {

	/**
	 * Main class to init Shortcodes
	 * for T4P PageBuilder
	 *
	 * @package  T4P PageBuilder Shortcodes
	 * @since    1.0.0
	 */
	class T4P_Pb_Builtin_Shortcode extends T4P_Pb_Addon {

		public function __construct() {

			// Addon information
			$this->set_provider(
			array(
					'name'             => __( 'Theme4Press Elements', 't4p-core' ),
					'file'             => __FILE__,
					'shortcode_dir'    => dirname( __FILE__ ),
					'js_shortcode_dir' => 'assets/js/shortcodes',
			)
			);

			//$this->custom_assets();
			// call parent construct
			parent::__construct();

			add_filter( 'plugin_action_links', array( &$this, 'plugin_action_links' ), 10, 2 );
		}

		/**
		 * Regiter & enqueue custom assets
		 */
		public function custom_assets() {
			// register custom assets
			$this->set_assets_register(
			array(
					't4p-frontend-free-css' => array(
						'src' => plugins_url( 'assets/css/main.css', dirname( __FILE__ ) ),
						'ver' => '1.0.0',
			),
					't4p-frontend-free-js'  => array(
						'src' => plugins_url( 'assets/js/main.js', dirname( __FILE__ ) ),
						'ver' => '1.0.0',
			)
			)
			);
			// enqueue assets for WP Admin pages
			$this->set_assets_enqueue_admin( array( 't4p-frontend-free-css' ) );
			// enqueue assets for T4P Modal setting iframe
			$this->set_assets_enqueue_modal( array( 't4p-frontend-free-js' ) );
			// enqueue assets for WP Frontend
			$this->set_assets_enqueue_frontend( array( 't4p-frontend-free-css', 't4p-frontend-free-js' ) );
		}

		/**
		 * Remove deactivate link
		 *
		 * @staticvar type $this_plugin
		 *
		 * @param type $links
		 * @param type $file
		 *
		 * @return type
		 */
		public function plugin_action_links( $links, $file ) {
			static $this_plugin;

			if ( ! $this_plugin ) {
				$this_plugin = plugin_basename( __FILE__ );
			}
			if ( $file == $this_plugin ) {
				unset ( $links['deactivate'] );
			}

			return $links;
		}

	}

	$this_ = new T4P_Pb_Builtin_Shortcode();
}