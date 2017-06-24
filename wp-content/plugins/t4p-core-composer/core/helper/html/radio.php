<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Radio extends T4P_Pb_Helper_Html {
	/**
	 * Radio
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element['class'] = isset( $element['class'] ) ? $element['class'] : 'radio-inline';
		$element['type_input'] = 'radio';
		return T4P_Pb_Helper_Shortcode::render_parameter( 'checkbox', $element );
	}
}