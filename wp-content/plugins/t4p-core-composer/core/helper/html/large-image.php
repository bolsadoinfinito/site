<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Large_Image extends T4P_Pb_Helper_Html {
	/**
	 * Selectbox of Image Size options
	 * @param type $element
	 * @return type
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );
		// Add default select2 for all large image html type
		$element['class'] .= ' select2-select';
		$output  = "<div id='{$element['id']}_wrapper' class='large_image_wrapper'><select id=\"select_{$element['id']}\"><option value=\"none\">".__( 'None', 't4p-core' ).'</option></select></div>';
		$output .= "<div class='image_loader'></div>";
		$output .= "<input type='hidden' id='{$element['id']}' class='{$element['class']}' value='{$element['std']}'  DATA_INFO />";
		return parent::final_element( $element, $output, $label );
	}
}