<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Filter_List extends T4P_Pb_Helper_Html {
	/**
	 * Horizonal list of filter options
	 * @param type $data
	 * @param type $id
	 * @return string
	 */
	static function render( $data, $id ) {
		$html = "<ul id='filter_$id' class='nav nav-pills elementFilter'>";
		foreach ( $data as $idx => $value ) {
			$active = ( $idx == 0 ) ? 'active' : '';
			$html  .= "<li class='$active'><a href='#' class='" . str_replace( ' ', '_', $value ) . "'>" . ucfirst( $value ) . '</a></li>';
		}
		$html .= '</ul>';
		return $html;
	}
}