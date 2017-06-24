<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Color_Picker extends T4P_Pb_Helper_Html {
	/**
	 * Color picker
	 * @param type $element
	 * @return string
	 */
	static function render( $element, $extra_params ) {
		$element  = parent::get_extra_info( $element );
		$label    = parent::get_label( $element );
                
                if ( ( $element['id'] == 'param-gradient_top_color' || $element['id'] == 'param-gradient_bottom_color' ) && isset ($extra_params['gradient_colors']) && $extra_params['gradient_colors'] ) {
                    $grad_colors = explode('|', $extra_params['gradient_colors']);
                    if ( $element['id'] == 'param-gradient_top_color' ) {
                            $element['std'] = ( ! $grad_colors[0] ) ? '' : $grad_colors[0];
                    } elseif ( $element['id'] == 'param-gradient_bottom_color' ) {
                            $element['std'] = ( ! $grad_colors[1] ) ? '' : $grad_colors[1];
                    }
                }

                if ( ( $element['id'] == 'param-gradient_top_hover_color' || $element['id'] == 'param-gradient_bottom_hover_color' ) && isset ($extra_params['gradient_hover_colors']) && $extra_params['gradient_hover_colors'] ) {
                    $gradient_hover_colors = explode('|', $extra_params['gradient_hover_colors']);
                    if ( $element['id'] == 'param-gradient_top_hover_color' ) {
                            $element['std'] = ( ! $gradient_hover_colors[0] ) ? '' : $gradient_hover_colors[0];
                    } elseif ( $element['id'] == 'param-gradient_bottom_hover_color' ) {
                            $element['std'] = ( ! $gradient_hover_colors[1] ) ? '' : $gradient_hover_colors[1];
                    }
                }
                
		$bg_color = ( $element['std'] ) ? $element['std'] : '#f7f7f7';
		$_hidden  = ( isset( $element['hide_value'] ) && $element['hide_value'] == false ) ? 'type="text"' : 'type="hidden"';
		$output   = '<input ' . $_hidden . " size='10' id='{$element['id']}' class='input-mini' disabled='disabled' name='{$element['id']}' value='{$element['std']}'  DATA_INFO />";
		$output  .= "<div id='color-picker-{$element['id']}' class='color-selector'><div style='background-color: {$bg_color}'></div></div>";

		add_filter( 't4p-edit-element-required-assets', array( __CLASS__, 'enqueue_assets_modal' ), 9 );

		return parent::final_element( $element, $output, $label );
	}

	/**
	 * Enqueue color picker assets
	 *
	 * @param array $scripts
	 * @return array
	 */
	static function enqueue_assets_modal( $scripts ){
		$scripts = array_merge( $scripts, array( 't4p-pb-colorpicker-js', 't4p-pb-colorpicker-css', ) );

		return $scripts;
	}
}