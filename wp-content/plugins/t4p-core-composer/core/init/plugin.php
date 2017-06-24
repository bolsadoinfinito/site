<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */

if ( ! class_exists( 'T4P_Pb_Init_Plugin' ) ) :

/**
 * T4P Library initialization.
 *
 * @package  T4P_PageBuilder
 * @since    1.0.0
 */
class T4P_Pb_Init_Plugin {
	/**
	 * Define Ajax actions.
	 *
	 * @var  array
	 */
	protected static $actions = array( 't4p-addons-management' );

	/**
	 * Register action to initialize T4P Library.
	 *
	 * @return  void
	 */
	public static function hook() {
		// Register action to initialize T4P Library
		static $registered;

		if ( ! isset( $registered ) ) {
			add_action( 'init', array( __CLASS__, 'init' ) );

			$registered = true;
		}
	}

	/**
	 * Initialize T4P Library.
	 *
	 * @return  void
	 */
	public static function init() {
		global $pagenow;
		
		// Register Ajax actions
		if ( 'admin-ajax.php' == $pagenow && isset( $_GET['action'] ) && in_array( $_GET['action'], self::$actions ) ) {
			// Init WordPress Filesystem Abstraction
			T4P_Pb_Init_File_System::get_instance();

			// Register Ajax actions
			switch ( $_GET['action'] ) {
				case 't4p-addons-management' :
					T4P_Pb_Product_Addons::hook();
				break;
			}
		}

		// Add filter to fine-tune uploaded file name
		add_filter( 'wp_handle_upload_prefilter', array( __CLASS__, 'wp_handle_upload_prefilter' ) );

		// Do 't4p_init' action
		do_action( 't4p_pb_init' );
		
		// Register 't4p_sample_settings_url' filter
		add_filter( 't4p_pagebuilder_settings_url', array( __CLASS__, 'settings_url' ) );
	}
	
	/**
	 * Apply 't4p_pagebuilder_settings_url' filter.
	 *
	 * @param   string  $url  Default settings link.
	 *
	 * @return  string
	 */
	public static function settings_url( $url ) {
		return admin_url( 'admin.php?page=t4p-pb-settings' );
	}
	

	/**
	 * Apply 'wp_handle_upload_prefilter' filter.
	 *
	 * @param   array  $file  Array containing uploaded file details.
	 *
	 * @return  string
	 */
	public static function wp_handle_upload_prefilter( $file ) {
		if ( $name = iconv( 'utf-8', 'ascii//TRANSLIT//IGNORE', $file['name'] ) ) {
			$file['name'] = $name;
		}

		return $file;
	}
}

endif;
