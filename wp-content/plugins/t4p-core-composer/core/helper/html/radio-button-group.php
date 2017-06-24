<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Radio_Button_Group extends T4P_Pb_Helper_Html {
	/**
	 * Radio Button group
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );

		$output = "<div class='btn-group t4p-btn-group' data-toggle='buttons'>";
		foreach ( $element['options'] as $key => $text ) {
			$active  = ( $key == $element['std'] ) ? 'active' : '';
			$checked = ( $key == $element['std'] ) ? 'checked' : '';
			$output .= "<label class='btn btn-default {$active}'>";
			$output .= "<input type='radio' name='{$element['id']}' $checked id='{$element['id']}' value='$key'/>";
			$output .= $text;
			$output .= "</label>";
		}
		$output .= '</div>';

		return parent::final_element( $element, $output, $label );
	}
}