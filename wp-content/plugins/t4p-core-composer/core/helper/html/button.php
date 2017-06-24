<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Slider_Button extends T4P_Pb_Helper_Html {
	/**
	 * Button
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label = parent::get_label( $element );
		$element['class'] = ( $element['class'] ) ? $element['class'] . ' btn' : 'btn';
		$action_type = isset( $element['action_type'] ) ? " data-action-type = '{$element["action_type"]}' " : '';
		$action = isset( $element['action'] ) ? " data-action = '{$element["action"]}' " : '';
		$output = "<button class='{$element['class']}' $action_type $action>{$element['std']}</button>";
		return parent::final_element( $element, $output, $label );
	}
}