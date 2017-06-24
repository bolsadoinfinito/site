<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Text_Field extends T4P_Pb_Helper_Html {
	/**
	 * Simple Input text
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );
		$type    = ! empty( $element['type_input'] ) ? $element['type_input'] : 'text';
		$placeholder = isset( $element['placeholder'] ) ? "placeholder='{$element['placeholder']}'" : '';
		$output  = "<input type='$type' class='{$element['class']}' value='{$element['std']}' id='{$element['id']}' name='{$element['id']}' DATA_INFO {$placeholder} />";

		return parent::final_element( $element, $output, $label );
	}
}