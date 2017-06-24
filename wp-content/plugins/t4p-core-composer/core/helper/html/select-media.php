<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Select_Media extends T4P_Pb_Helper_Html {
	/**
	 * Input field to select Media
	 * @param type $element
	 * @return type
	 */
	static function render( $element, $extra_params ) {
		$element = parent::get_extra_info( $element );
		$label = parent::get_label( $element );
                if ( isset($extra_params['_shortcode_content']) && $extra_params['_shortcode_content'] && !$element['std'] ) {
                        $img_url = $extra_params['_shortcode_content'];
                        if( preg_match('/<img/', $img_url) ) {
                                preg_match('/src="([^"]*)"/', $img_url, $image);
                                $element['std'] = $image[1];
                        } elseif ( preg_match('/(\.jpg|\.png|\.bmp)$/', $img_url) ) {
                                $element['std'] = $img_url;
                        }
                }
		$_filter_type = isset( $element['filter_type'] ) ? $element['filter_type'] : 'image';
		$output = '<div class="input-append row-fluid input-group">
							<input type="text" class="' . $element['class'] . '" value="' . $element['std'] . '" id="' . $element['id'] . '">
							<span class="input-group-addon select-media btn btn-default" filter_type="' . $_filter_type . '" id="' . $element['id'] . '_button">...</span>
							<span class="input-group-addon select-media-remove btn btn-default"><i class="icon-remove"></i></span>
						</div>';
		return parent::final_element( $element, $output, $label );
	}
}