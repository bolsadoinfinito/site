<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_List_Extra extends T4P_Pb_Helper_Html {
	/**
	 * List Extra Element
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$html  = "<div class='{$element['class']}'>";
		$html .= "<div id='{$element['id']}' class='jsn-items-list ui-sortable'>";

		if ( $element['std'] ) {

		}

		$html .= '</div>';
		$html .= "<a class='jsn-add-more add-more-extra-list' onclick='return false;' href='#'><i class='icon-plus'></i>" . __( 'Add Item', 't4p-core' ) . '</a>';
		$html .= '</div>';
		return $html;
	}
}