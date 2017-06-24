<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Slider_Button extends T4P_Pb_Helper_Html {
	/**
	 * Button
	 * @param type $element
	 * @return string
	 */
	static function render( $element ) {
		$element = parent::get_extra_info( $element );
		$label = parent::get_label( $element );
		$element['class'] = ( $element['class'] ) ? $element['class'] . ' btn' : 'btn';
		$action_type = isset( $element['action_type'] ) ? " data-action-type = '{$element["action_type"]}' " : '';
		$action = isset( $element['action'] ) ? " data-action = '{$element["action"]}' " : '';
		$output = "<button class='{$element['class']}' $action_type $action>{$element['std']}</button>";
                ob_start(); 
                ?>
                <script type="text/javascript">
                        jQuery(document).ready(function () {
                                jQuery("button.youtube_button").click(function () {
                                        jQuery('.activate-item #param-video_content').val('[youtube id="Enter video ID (eg. RZRyQT1qedE)" width="600" height="350" autoplay="no" disabled_el="no" div_margin_top="0" div_margin_left="0" div_margin_bottom="0" div_margin_right="0" ][/youtube]');
                                });
                                jQuery("button.vimeo_button").click(function () {
                                        jQuery('.activate-item #param-video_content').val('[vimeo id="Enter video ID (eg. 78439312)" width="600" height="350" autoplay="no" disabled_el="no" div_margin_top="0" div_margin_left="0" div_margin_bottom="0" div_margin_right="0" ][/vimeo]');
                                });
                        });
                </script>
                <?php
                $script = ob_get_clean();
		return parent::final_element( $element, $output.$script, $label );
	}
}