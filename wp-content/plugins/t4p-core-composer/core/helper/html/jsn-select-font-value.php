<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Jsn_Select_Font_Value extends T4P_Pb_Helper_Html {
	/**
	 * Selectbox to select font
	 * @param type $element
	 * @return type
	 */
	static function render( $element ) {
		$selected_value = $element['std'];
		$element['exclude_class'] = array( 'form-control' );
		$element = parent::get_extra_info( $element );
		$label = parent::get_label( $element );

		$output  = "<select id='{$element['id']}' class='jsn-fontFace {$element['class']}' data-selected='{$selected_value}' value='{$selected_value}'>";
		$output .= "<option value='{$selected_value}' selected='selected'>{$selected_value}</option>";
		$output .= '</select>';

		return parent::final_element( $element, $output, $label );
	}
}