<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */

/**
 * @todo : Check plugin update
 */

class T4P_Pb_Helper_Update_Checker {
	/**
	 * Check update by cURL.
	 *
	 * @return  void
	 */
	public static function check_by_curl() {
		$server_url = "http://www.theme4press.com/wp-admin/admin-ajax.php";
		$plugin_data = get_plugin_data( T4P_CORE_FILE );
		$data = array(
			'action' => 't4p_update_checking',
			'url' => site_url(),
			'plugin' => $plugin_data['Name'],
			'version' => $plugin_data['Version']
		);
		$ch = curl_init( $server_url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_exec( $ch );
		curl_close( $ch );
	}

	/**
	 * Check update by AJAX.
	 *
	 * @return  void
	 */
	public static function check_by_ajax() {
		wp_enqueue_script( 't4p-pb-check-update-js', T4P_CORE_URI . 'assets/theme4press/js/check-update.js' );
		$plugin_data = get_plugin_data( T4P_CORE_FILE );
		$ajax_t4p_check_update = array(
			'url' => site_url(),
			'plugin' => $plugin_data['Name'],
			'version' => $plugin_data['Version']
		);
		wp_localize_script( 't4p-pb-check-update-js', 'ajax_t4p_check_update', $ajax_t4p_check_update );
	}
}
