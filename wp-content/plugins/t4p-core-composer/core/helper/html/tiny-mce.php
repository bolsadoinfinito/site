<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Tiny_Mce extends T4P_Pb_Helper_Html {
	/**
	 * text area with WYSIWYG
	 * @param type $element
	 * @return type
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label = parent::get_label( $element );
		$rows = isset($element['rows']) ? $element['rows'] : 10;
		if ( isset($element['exclude_quote']) && $element['exclude_quote'] == '1' ) {
			$element['std'] = str_replace( '<t4p_quote>', '"', $element['std'] );
		}

		$settings = array(
			'textarea_name' => $element['id'],
			'textarea_rows' => $rows,
			'editor_class' => 't4p_pb_editor'
		);

		ob_start();
		echo "<form id='t4p_tiny_mce' class='t4p_tiny_mce' method='post'>";
		wp_editor($element['std'], $element['id'], $settings);
		echo "</form>";
		$output = ob_get_clean();

		return parent::final_element( $element, $output, $label, true );
	}
}