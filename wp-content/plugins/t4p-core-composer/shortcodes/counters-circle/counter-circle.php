<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */
if ( ! class_exists( 'Counter_circle' ) ) {

	class Counter_circle extends T4P_Pb_Shortcode_Child {

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
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['exception'] = array(
                                'admin_assets' => array(
                                        't4p-pb-joomlashine-iconselector-js',
                                        't4p-pb-colorpicker-js',
                                        't4p-pb-colorpicker-css',
                                ),
			);
			$this->config['use_wrapper'] = true;

			// Inline edit for sub item
			$this->config['edit_inline'] = true;
		}

		/**
		 * Define shortcode settings.
		 *
		 * @return  void
		 */
                public function element_items() {
			$this->items = array(
				'Notab' => array(
                                        array(
                                                'name'    => __( 'Counter Circle Text', 't4p-core' ),
                                                'id'      => 'title',
                                                'role'    => 'content',
                                                'type'    => 'text_field',
                                                'std'     => 'Circle Title',
                                                'tooltip' => __( 'Insert text for counter circle box, keep it short', 't4p-core' )
                                        ),
                                        array(
                                                'name'    => __( 'Counter Circle Description', 't4p-core' ),
                                                'id'      => 'description',
                                                'type'    => 'text_field',
                                                'std'     => '',
                                                'tooltip' => __( 'Insert description for counter circle box', 't4p-core' )
                                        ),
                                        array(
                                                'name'       => __( 'Filled Area Percentage', 't4p-core' ),
                                                'id'         => 'value',
                                                'type'       => 'text_append',
                                                'type_input' => 'number',
                                                'class'      => 'input-mini',
                                                'std'        => '15',
                                                'append'     => '%',
                                                'validate'   => 'number',
                                                'tooltip'    => __( 'From 1% to 100%', 't4p-core' )
                                        ),
                                        array(
                                                'name'    => __( 'Filled Color', 't4p-core' ),
                                                'id'      => 'filledcolor',
                                                'type'    => 'color_picker',
                                                'std'     => '',
                                                'tooltip' => __( 'Controls the color of the filled in area. Leave blank for theme option selection.', 't4p-core' )
                                        ),
                                        array(
                                                'name'    => __( 'Unfilled Color', 't4p-core' ),
                                                'id'      => 'unfilledcolor',
                                                'type'    => 'color_picker',
                                                'std'     => '',
                                                'tooltip' => __( 'Controls the color of the unfilled in area. Leave blank for theme option selection.', 't4p-core' )
                                        ),
                                        array(
                                                'name'       => __( 'Size of the Counter', 't4p-core' ),
                                                'id'         => 'size',
                                                'type'       => 'text_append',
                                                'type_input' => 'number',
                                                'class'      => 'input-mini',
                                                'std'        => '220',
                                                'append'     => 'px',
                                                'validate'   => 'number',
                                                'tooltip'    => __( 'Insert size of the counter in px. ex: 220', 't4p-core' )
                                        ),
                                        array(
                                                'name'       => __( 'Font Size', 't4p-core' ),
                                                'id'         => 'font_size',
                                                'type'       => 'text_append',
                                                'type_input' => 'number',
                                                'class'      => 'input-mini',
                                                'std'        => '30',
                                                'append'     => 'px',
                                                'validate'   => 'number',
                                                'tooltip'    => __( 'Insert font size of the counter in px. ex: 40', 't4p-core' )
                                        ),
                                        array(
                                                'name'      => __( 'Icon', 't4p-core' ),
                                                'id'        => 'icon',
                                                'type'      => 'icons',
                                                'std'       => '',
                                                'role'      => 'title_prepend',
                                                'title_prepend_type' => 'icon',
                                                'tooltip'    => __( 'Click an icon to select, click None to deselect.', 't4p-core' )
                                        ),
                                        array(
                                                'name'       => __( 'Show Scales', 't4p-core' ),
                                                'id'         => 'scales',
                                                'type'       => 'radio',
                                                'std'        => 'no',
                                                'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                                'tooltip'    => __( 'Choose to show a scale around circle.', 't4p-core' )
                                        ),
                                        array(
                                                'name'       => __( 'Countdown', 't4p-core' ),
                                                'id'         => 'countdown',
                                                'type'       => 'radio',
                                                'std'        => 'no',
                                                'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                                'tooltip'    => __( 'Choose to let the circle filling move counter clockwise.', 't4p-core' )
                                        ),
                                        array(
                                                'name'       => __( 'Animation Speed', 't4p-core' ),
                                                'id'         => 'speed',
                                                'type'       => 'text_append',
                                                'type_input' => 'number',
                                                'class'      => 'input-mini',
                                                'std'        => '1500',
                                                'append'     => 'ms',
                                                'validate'   => 'number',
                                                'tooltip'    => __( 'Insert animation speed in milliseconds', 't4p-core' )
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
                        $arr_params = shortcode_atts( $this->config['params'], $atts );
                        extract( $arr_params );

                        $description = ( ! $description ) ? '' : $description;
                        $value = ( ! $value ) ? '15' : $value;
                        $filledcolor = ( ! $filledcolor ) ? strtolower( $smof_data['counter_filled_color'] ) . $evl_options['evl_shortcode_counter_circle_filled_color'] : $filledcolor;
                        $unfilledcolor = ( ! $unfilledcolor ) ? strtolower( $smof_data['counter_unfilled_color'] ) . $evl_options['evl_shortcode_counter_circle_unfilled_color'] : $unfilledcolor;
                        $size = ( ! $size ) ? '' : $size;
                        $font_size = ( ! $font_size ) ? '' : $font_size;
                        $icon = ( ! $icon ) ? '' : "<i class='fa {$icon}'></i>";
                        $scales = ( ! $scales ) ? '' : $scales;
                        $countdown = ( ! $countdown ) ? '' : $countdown;
                        $speed = ( ! $speed ) ? '' : $speed;

                        $multiplicator = $size / 220;
                        $stroke_size = 11 * $multiplicator;
                        //$font_size = 50 * $multiplicator;
                        $content_line_height = $size+($size*25/100);

                        $circle_title = "<span class='t4p-counters-circle-text' style='line-height: {$size}px; font-size: {$font_size}px;'>{$icon}".do_shortcode( $content )."</span>";
                        $description = "<span class='t4p-counters-circle-info' style='line-height: {$content_line_height}px;'>{$description}</span>";
                        $data_percent = $value;
                        $data_countdown = ( $countdown == 'no' ) ? '' : 1 ;
                        $data_filledcolor = $filledcolor;
                        $data_unfilledcolor = $unfilledcolor;
                        $data_scale = ( $scales == 'no' ) ? '' : 1 ;
                        $data_size = $size;
                        $data_speed = $speed;
                        $data_strokesize = $stroke_size;

                        $child_wrapper_style = sprintf( 'height:%spx;width:%spx;line-height:%spx;', $size, $size, $size );

                        $output = "<div data-percent='{$data_percent}' data-countdown='{$data_countdown}' data-filledcolor='{$data_filledcolor}' data-unfilledcolor='{$data_unfilledcolor}' data-scale='{$data_scale}' data-size='{$data_size}' data-speed='{$data_speed}' data-strokesize='{$data_strokesize}' class='t4p-counter-circle counter-circle counter-circle-content' style='{$child_wrapper_style}'>{$circle_title}{$description}</div>";

                        $html = "<div class='counter-circle-wrapper' style='{$child_wrapper_style}'>{$output}</div>";

                        return $html."<!--seperate-->";
                }

	}

}