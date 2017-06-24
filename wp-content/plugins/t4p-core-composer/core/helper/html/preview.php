<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Preview extends T4P_Pb_Helper_Html {
	/**
	 * Preview Box of shortcode
	 * @return type
	 */
	static function render() {
		$hide_preview = __( 'Hide Live Preview', 't4p-core' );
		$show_preview = __( 'Show Live Preview', 't4p-core' );
		return "<div class='t4p-preview-resize'><div id='preview_container' class='t4p-preview-container col-md-12'>
		<legend>" . __( 'Preview', 't4p-core' ) . "</legend>
		<div id='t4p_overlay_loading' class='jsn-overlay jsn-bgimage image-loading-24'></div>
		<iframe id='shortcode_preview_iframe' name='shortcode_preview_iframe' class='shortcode_preview_iframe'></iframe>
		</div></div>";
	}
}