<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Fieldset extends T4P_Pb_Helper_Html {
	/**
	 * hr element
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
            
                $element['name'] = ucwords ( str_replace( '_' , ' ', $element['name'] ) );
		$html = sprintf( '<fieldset class="t4p-fieldset"><legend>%s</legend></fieldset>', $element['name'] );
		return $html;
	}
}