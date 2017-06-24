<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Gradient_Picker extends T4P_Pb_Helper_Html {
	/**
	 * gradient picker
	 * @param type $element
	 */
	static function render( $element ){
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );
		$output  = "<input type='hidden' class='jsn-grad-ex' id='{$element['id']}' name='{$element['id']}' value='{$element['std']}'  DATA_INFO />";
		$output .= "<div class='classy-gradient-box'></div>";

		add_filter( 't4p-edit-element-required-assets', array( __CLASS__, 'enqueue_assets_modal' ), 0 );

		return parent::final_element( $element, $output, $label );
	}

	/**
	 * Enqueue gradient assets
	 *
	 * @param array $scripts
	 * @return array
	 */
	static function enqueue_assets_modal( $scripts ){
		$scripts = array_merge( $scripts, array( 't4p-pb-classygradient-js', 't4p-pb-classygradient-css', ) );

		return $scripts;
	}
}