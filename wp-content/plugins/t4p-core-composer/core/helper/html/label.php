<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Label extends T4P_Pb_Helper_Html {
	/**
	 * Label
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );
		$output  = "<span class='add-on input-group-addon {$element['class']}'>{$element['std']}</span>";
		return parent::final_element( $element, $output, $label );
	}
}