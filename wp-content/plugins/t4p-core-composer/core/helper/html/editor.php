<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */

class T4P_Pb_Helper_Html_Editor extends T4P_Pb_Helper_Html {
	
	/**
	 * Render editor using jquery-te library
	 * 
	 * @param type $element
	 * @return type
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label = parent::get_label( $element );
		$element['row'] = ( isset( $element['row'] ) ) ? $element['row'] : '8';
		$element['col'] = ( isset( $element['col'] ) ) ? $element['col'] : '50';
		if ( isset($element['exclude_quote']) && $element['exclude_quote'] == '1' ) {
			$element['std'] = str_replace( '<t4p_quote>', '"', $element['std'] );
		}
		$output = "<textarea class='{$element['class']} t4p_pb_editor' id='{$element['id']}' rows='{$element['row']}' cols='{$element['col']}' name='{$element['id']}' DATA_INFO>{$element['std']}</textarea>";
		
		add_filter( 't4p_pb_assets_register_modal', array( __CLASS__, 'register_assets_register_modal' ) );
		add_filter( 't4p-edit-element-required-assets', array( __CLASS__, 'enqueue_assets_modal' ), 9 );
		
		return parent::final_element( $element, $output, $label, true );
	}
	
	/**
	 * Register jquery-te assets
	 *
	 * @param array $scripts
	 * @return array
	 */
	static function register_assets_register_modal( $assets ){
		$assets['t4p-pb-jquery-te-js'] = array(
			'src' => T4P_Pb_Helper_Functions::path( 'assets/3rd-party/jquery-te' ) . '/jquery-te-1.4.0.min.js',
			'ver' => '1.4.0',
		);
		$assets['t4p-pb-jquery-te-css'] = array(
			'src' => T4P_Pb_Helper_Functions::path( 'assets/3rd-party/jquery-te' ) . '/jquery-te-1.4.0.css',
			'ver' => '1.4.0',
		);
	
		return $assets;
	}
	
	/**
	 * Enqueue jquery-te assets
	 *
	 * @param array $scripts
	 * @return array
	 */
	static function enqueue_assets_modal( $scripts ){
		$scripts = array_merge( $scripts, array( 't4p-pb-jquery-te-js', 't4p-pb-jquery-te-css' ) );
	
		return $scripts;
	}
	
}