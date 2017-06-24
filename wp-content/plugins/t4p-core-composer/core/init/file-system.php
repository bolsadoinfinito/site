<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */

if ( ! class_exists( 'T4P_Pb_Init_File_System' ) ) :

/**
 * File system initialization.
 *
 * @package  T4P_PageBuilder
 * @since    1.0.0
 */
class T4P_Pb_Init_File_System {
	/**
	 * Initialize WordPress Filesystem Abstraction.
	 *
	 * @return  object
	 */
	public static function get_instance() {
		global $wp_filesystem;

		if ( ! function_exists( 'WP_Filesystem' ) ) {
			include_once ABSPATH . 'wp-admin/includes/file.php';
		}

		if ( ! $wp_filesystem ) {
			WP_Filesystem();
		}

		return $wp_filesystem;
	}
	
	/**
	 * Prepare a directory.
	 *
	 * @param   string  $path  Absolute path to directory needs preparation.
	 *
	 * @return  mixed  Directory path on success, boolean FALSE on failure
	 */
	public static function prepare_directory( $path ) {
		// Get WordPress Filesystem Abstraction object
		$wp_filesystem = self::get_instance();

		if ( ! $wp_filesystem->is_dir( $path ) ) {
			$result = explode( '/', str_replace( '\\', '/', $path ) );
			$path   = array();

			while ( count( $result ) ) {
				$path[] = current( $result );

				if ( ! $wp_filesystem->is_dir( implode( '/', $path ) ) ) {
					if ( ! $wp_filesystem->mkdir( implode( '/', $path ), 0755 ) ) {
						return false;
					}
				}

				// Shift paths
				array_shift( $result );
			}
		}

		return ( is_array( $path ) ? implode( '/', $path ) : $path );
	}
}

endif;
