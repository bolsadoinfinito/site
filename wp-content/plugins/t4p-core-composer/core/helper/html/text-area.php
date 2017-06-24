<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
/*
 */
class T4P_Pb_Helper_Html_Text_Area extends T4P_Pb_Helper_Html {
	/**
	 * Textarea option
	 * @param type $element
	 * @return type
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label = parent::get_label( $element );
		$element['row'] = ( isset( $element['row'] ) ) ? $element['row'] : '8';
		$element['col'] = ( isset( $element['col'] ) ) ? $element['col'] : '50';

                if ( $element['id'] == 'param-video_content' ) {
                        if ( strpos( $element['std'], '[vimeo' ) !== false || strpos( $element['std'], '[youtube' ) !== false ||  strpos( $element['std'], '<iframe' ) !== false) {
                        } else {
                                $element['std'] = '';
                        }
                }

		if ( isset($element['exclude_quote']) && $element['exclude_quote'] == '1' ) {
			$element['std'] = str_replace( '<t4p_quote>', '"', $element['std'] );
		}
		$output = "<textarea class='{$element['class']}' id='{$element['id']}' rows='{$element['row']}' cols='{$element['col']}' name='{$element['id']}' DATA_INFO>{$element['std']}</textarea>";

		return parent::final_element( $element, $output, $label );
	}
}