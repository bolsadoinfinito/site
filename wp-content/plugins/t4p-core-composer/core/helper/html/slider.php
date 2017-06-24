<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Slider extends T4P_Pb_Helper_Html {
	/**
	 * Horizonal slider to select a numeric value
	 * @param type $element
	 * @return type
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label   = parent::get_label( $element );
		$std_max = empty ( $element['std_max'] ) ? 100 : $element['std_max'];
		$output  = '<script>
			( function ($ ) {
				$( document ).ready( function ()
				{
					var slider_ = $( ".t4p-slider" );
					var input_slider = slider_.next("input").first();
					slider_.slider({
						range: "min",
						value: ' . $element['std'] . ',
						min: 1,
						max: ' . $std_max .',
						slide: function ( event, ui ) {
							var input_slide = $(ui.handle).parent().next("input").first();
							input_slide.val( ui.value ).change();
							$( ui.handle ).html( "<div class=\'t4p-slider-value\'>" + ui.value + "%</div>" );
						},
						create: function( event, ui ) {
							$( "#' . $element['id'] . '_slider .ui-slider-handle" ).html( "<div class=\'t4p-slider-value\'>" + ' . $element['std'] . ' + "%</div>" );
						}
					});
				});
			})( jQuery )
		</script>';
		$output .= '<div id="' . $element['id'] . '_slider" class="' . $element['class'] . '" ></div>';
		$output .= '<input type="text" class="hidden" id="' . $element['id'] . '" value="' . $element['std'] . '" />';

		return parent::final_element( $element, $output, $label );
	}
}