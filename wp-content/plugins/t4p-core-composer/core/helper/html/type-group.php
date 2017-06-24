<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Type_Group extends T4P_Pb_Helper_Html {
	/**
	 * List of "items_list"
	 * @param type $element
	 * @return type
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );
		$output  = '';
		$items   = isset( $element['items'] ) ? $element['items'] : '';

		if ( is_array( $items ) ) {
			foreach ( $items as $element_ ) {
				$element_func = $element_['type'];
				$element_['wrap'] = '0';
				$element_['wrap_class'] = '';
				$element_['std'] = $element['std'];
				$element_['id'] = $element['id'];

				$output .= T4P_Pb_Helper_Shortcode::render_parameter( $element_func, $element_ );
			}
		}
		return parent::final_element( $element, $output, $label );
	}
}