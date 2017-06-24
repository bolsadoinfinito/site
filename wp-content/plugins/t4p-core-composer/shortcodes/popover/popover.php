<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Popover' ) ) :

/**
 * Create Popover element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Popover extends T4P_Pb_Shortcode_Element {
    
        private $popover_counter = 1;
    
	/**
	 * Constructor
	 *
	 * @return  void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Configure shortcode.
	 *
	 * @return  void
	 */
	public function element_config() {
		$this->config['shortcode']   = strtolower( __CLASS__ );
		$this->config['name']        = __( 'Popover', 't4p-core' );
		$this->config['cat']         = __( 'Typography', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-popover';
		$this->config['description'] = __( 'Add a popover', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(
		);

		// Use Ajax to speed up element settings modal loading speed
		$this->config['edit_using_ajax'] = true;
	}

	/**
	 * Define shortcode settings.
	 *
	 * @return  void
	 */
	public function element_items() {
		$this->items = array(
			'content' => array(
				array(
					'name'  => __( 'Popover Heading', 't4p-core' ),
					'id'    => 'title',
					'type'  => 'text_field',
					'std'   => '',
                                        'tooltip' => __( 'Heading text of the popover.', 't4p-core' )
				),
                                array(
                                        'name'    => __( 'Contents Inside Popover', 't4p-core' ),
                                        'id'      => 'content',
                                        'type'    => 'text_area',
                                        'std'     => T4P_Pb_Helper_Type::lorem_text(10),
                                        'tooltip'  => __( 'Text to be displayed inside the popover.', 't4p-core' ),
                                ),
                                array(
                                        'name'    => __( 'Triggering Content', 't4p-core' ),
                                        'id'      => 'heading',
                                        'type'    => 'text_field',
                                        'role'    => 'content',
                                        'std'     => 'Text',
                                        'tooltip'  => __( 'Content that will trigger the popover.', 't4p-core' ),
                                ),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
                            	array(
					'name' => __( 'Popover Heading Background Color', 't4p-core' ),
					'type' => array(
                                                array(
                                                        'id'           => 'title_bg_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
					),
                                        'tooltip' => __( 'Controls the background color of the popover heading. Leave blank for theme option selection.', 't4p-core' )
				),
                                array(
					'name' => __( 'Contents Inside Popover', 't4p-core' ),
					'type' => array(
                                                array(
                                                        'id'           => 'content_bg_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
					),
                                        'tooltip' => __( 'Controls the background color of the popover content area. Leave blank for theme option selection.', 't4p-core' )
				),
                                array(
					'name' => __( 'Popover Border Color', 't4p-core' ),
					'type' => array(
                                                array(
                                                        'id'           => 'bordercolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
					),
                                        'tooltip' => __( 'Controls the border color of the of the popover box. Leave blank for theme option selection.', 't4p-core' )
				),
                                array(
					'name' => __( 'Popover Text Color', 't4p-core' ),
					'type' => array(
                                                array(
                                                        'id'           => 'textcolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
					),
                                        'tooltip' => __( 'Controls all the text color inside the popover box. Leave blank for theme option selection.', 't4p-core' )
				),
                                array(
                                        'name'       => __( 'Popover Trigger Method', 't4p-core' ),
                                        'id'         => 'trigger',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => 'click',
                                        'options'    => array(
                                                        'click'   => __( 'Click', 't4p-core' ),
                                                        'hover'    => __( 'Hover', 't4p-core' )
                                                ),
                                        'tooltip'    => __( 'Choose mouse action to trigger popover.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Popover Position', 't4p-core' ),
                                        'id'         => 'placement',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => '',
                                        'options'    => array(
                                                        ''      => __( 'Default', 't4p-core' ),
                                                        'top'   => __( 'Top', 't4p-core' ),
                                                        'bottom'    => __( 'Bottom', 't4p-core' ),
                                                        'left'    => __( 'Left', 't4p-core' ),
                                                        'Right'    => __( 'Right', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'Choose the display position of the popover. Choose default for theme option selection.', 't4p-core' )
                                ),
			)
		);
	}

	/**
	 * Generate HTML code from shortcode content.
	 *
	 * @param   array   $atts     Shortcode attributes.
	 * @param   string  $content  Current content.
	 *
	 * @return  string
	 */
	public function element_shortcode_full( $atts = null, $content = null ) {
		global $evl_options, $smof_data;
		$arr_params    = ( shortcode_atts( $this->config['params'], $atts ) );
                //extract( $arr_params );

                $popover_title = ( ! $arr_params['title'] ) ? '' : $arr_params['title'];
                $popover_content = ( ! $arr_params['content']) ? '' : $arr_params['content'];
                $title_bg_color = ( ! $arr_params['title_bg_color'] ) ? $smof_data['popover_heading_bg_color'] . $evl_options['evl_shortcode_popover_heading_bg_color'] : $arr_params['title_bg_color'];
                $content_bg_color = ( ! $arr_params['content_bg_color'] ) ? $smof_data['popover_content_bg_color'] . $evl_options['evl_shortcode_popover_content_bg_color'] : $arr_params['content_bg_color'];
                $bordercolor = ( ! $arr_params['bordercolor'] ) ? $smof_data['popover_border_color'] . $evl_options['evl_shortcode_popover_border_color'] : $arr_params['bordercolor'];
                $textcolor = ( ! $arr_params['textcolor'] ) ? $smof_data['popover_text_color'] . $evl_options['evl_shortcode_popover_text_color'] : $arr_params['textcolor'];
                $trigger = ( ! $arr_params['trigger'] ) ? 'click' : $arr_params['trigger'];
                $placement = ( ! $arr_params['placement'] ) ? strtolower( $smof_data['popover_placement'] ) . $evl_options['evl_shortcode_popover_position'] : $arr_params['placement'];
                $animation = 'false';
                $delay	= '';

                if( $placement == 'bottom' ) {
			$arrow_color = $title_bg_color;
		} else {
			$arrow_color = $content_bg_color;
		}

                $attr_class = sprintf( 't4p-popover popover-%s', $this->popover_counter );

		$data_animation = $animation;
		$data_class = sprintf( 'popover-%s', $this->popover_counter );
		$data_container = sprintf( 'popover-%s', $this->popover_counter );
		$data_content = $popover_content;
		$data_delay = $delay;
		$data_placement = strtolower( $placement );
		$data_title = $popover_title;
		$data_toggle = 'popover';
		$data_trigger = $trigger;
                $classname = 'popover-'.$this->popover_counter;

                ob_start(); 
                ?>
                <script type="text/javascript">
                        jQuery(document).ready(function ($) {
                                jQuery('[data-toggle~="popover"]').popover({
                                        container: 'body',
                                        'template': "<div class='popover <?php echo $classname ?>' role='tooltip'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div></div>"
                                });
                        });
                </script>
                <?php
                $script = ob_get_clean();

    		$styles = sprintf( '<style>.popover-%s.%s .arrow{border-%s-color:%s;}.popover-%s{border-color:%s;}.popover{background-color:%s;}.popover-%s .popover-title{background-color:%s;color:%s;border-color:%s;}.popover-%s .popover-content{background-color:%s;color:%s;}.popover-%s.%s .arrow:after{border-%s-color:%s;}</style>', 
						   $this->popover_counter, $placement, $placement, $bordercolor, $this->popover_counter, $bordercolor, $bordercolor, $this->popover_counter, $title_bg_color, $textcolor, $bordercolor, $this->popover_counter, $content_bg_color, $textcolor, $this->popover_counter, $placement, $placement, $arrow_color );

                $html = "<span class='$attr_class' data-animation='$data_animation' data-class='popover-1 {$data_class}' data-container='$data_container' data-content='$data_content' data-delay='$data_delay' data-placement='$data_placement' data-title='$data_title' data-toggle='$data_toggle' data-trigger='$data_trigger' data-original-title='' title=''>$styles $content</span>";

                if ( is_admin() ) {
			$custom_style = "<style>.t4p-element-popover {width: 100%; margin-top: 50px; text-align: center;}</style>";
			$html_element = $custom_style.$html.$script;
		} else {
                        $html_element = $html.$script;
                }

		$this->popover_counter++;

		return $this->element_wrapper( $html_element, $arr_params );
	}
}

endif;
