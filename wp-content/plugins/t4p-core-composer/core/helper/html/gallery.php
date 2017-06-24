<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Gallery extends T4P_Pb_Helper_Html {
	/**
	 * Simple Input text
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );
		$output  = "<a href='' id='{$element['id']}' name='{$element['id']}' class='t4p-gallery-button t4p-shortcodes-button'>Attach Images to Gallery</a>";

		return parent::final_element( $element, $output, $label );
	}
}