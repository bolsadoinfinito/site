<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Button_Group extends T4P_Pb_Helper_Html {
	/**
	 * Button group
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );

		$output = "<div class='btn-group'>
		  <a class='btn btn-default dropdown-toggle t4p-dropdown-toggle' href='#'>
			".__( 'Convert to', 't4p-core' )."...
			<span class='caret'></span>
		  </a>
		  <ul class='dropdown-menu'>";
		foreach ( $element['actions'] as $action ) {
			$output .= "<li><a href='#' data-action = '{$action["action"]}' data-action-type = '{$action["action_type"]}'>{$action['std']}</a></li>";
		}
		$output .= '</ul></div>';
		return parent::final_element( $element, $output, $label );
	}
}