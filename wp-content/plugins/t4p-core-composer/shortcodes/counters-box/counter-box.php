<?php
/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */
if ( ! class_exists( 'Counter_box' ) ) {
	/**
	 * Create child Counters_box element
	 *
	 * @package  T4P PageBuilder Shortcodes
	 * @since    1.0.0
	 */
	class Counter_box extends T4P_Pb_Shortcode_Child {

                public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
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
		 * DEFINE setting options of shortcode
		 */
		public function element_items() {
			$this->items = array(
			'Notab' => array(
                                array(
                                        'name' => __( 'Counter Value', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'         => 'value',
                                                        'type'       => 'text_append',
                                                        'type_input' => 'number',
                                                        'class'      => 'input-mini',
                                                        'std'        => '25',
                                                        'validate'   => 'number',
                                                ),
                                        ),
                                        'tooltip' => __( 'The number to which the counter will animate.', 't4p-core' )
                                ),
                                array(
                                        'name'  => __( 'Counter Box Unit', 't4p-core' ),
                                        'id'    => 'unit',
                                        'type'  => 'text_field',
                                        'class' => 'input-sm',
                                        'std'   => '',
                                        'tooltip' => __( 'Insert a unit for the counter. ex %', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Unit Position', 't4p-core' ),
                                        'id'         => 'unit_pos',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => 'suffix',
                                        'options'    => array(
                                                        'suffix'   => __( 'After Counter', 't4p-core' ),
                                                        'prefix'    => __( 'Before Counter', 't4p-core' )
                                                ),
                                        'tooltip'    => __( 'Choose the positioning of the unit.', 't4p-core' )
                                ),
                                array(
                                        'name'      => __( 'Icon', 't4p-core' ),
                                        'id'        => 'icon',
                                        'type'      => 'icons',
                                        'std'       => '',
                                        'role'      => 'title_prepend',
                                        'title_prepend_type' => 'icon',
                                        'tooltip'  => __( 'Click an icon to select, click None to deselect', 't4p-core' ),
                                ),
                                array(
                                        'name'       => __( 'Show Border', 't4p-core' ),
                                        'id'         => 'border',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'          => 'yes',
                                        'options'    => array(
                                                        'yes'   => __( 'Yes', 't4p-core' ),
                                                        'no'      => __( 'No', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'Choose to show a box border.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Color Of Counter', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the color of the counter text and icon. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Counter Diection', 't4p-core' ),
                                        'id'         => 'direction',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => 'up',
                                        'options'    => array(
                                                        'up'   => __( 'Countup', 't4p-core' ),
                                                        'down'      => __( 'Countdown', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'Choose to count up or down.', 't4p-core' )
                                ),
                                array(
                                        'name'  => __( 'Counter Box Text', 't4p-core' ),
                                        'id'    => 'title',
                                        'type'  => 'text_field',
                                        'class' => 'input-sm',
                                        'std'   => 'Text',
                                        'role'    => 'content',
                                        'tooltip' => __( 'Insert text for counter box', 't4p-core' )
                                ),
                                
			)
			);
		}

		/**
		 * DEFINE shortcode content
		 *
		 * @param type $atts
		 * @param type $content
		 */
		public function element_shortcode_full( $atts = null, $content = null ) {
                        global $evl_options, $parent_atts, $smof_data;
			$arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
			extract( $arr_params );

                        $value  = ( ! $value ) ? '' : $value;
                        $unit  = ( ! $unit ) ? '' : $unit;
                        $unit_pos  = ( ! $unit_pos ) ? 'suffix' : $unit_pos;
                        $icon  = ( ! $icon ) ? '' : $icon;
                        $border  = ( ! $border ) ? 'yes' : $border;
                        $color = ( ! $color ) ? strtolower( $evl_options['evl_shortcode_counter_boxes_color'] ).strtolower( $smof_data['counter_box_color'] ) : $color;
                        $direction  = ( ! $direction ) ? 'up' : $direction;

                        $value = intval( $value );

                        $unit_output = '';
                        if( $unit ) {
                                $unit_output = "<span class='unit'>$unit</span>";
                        }

                        if( $direction	== 'up' ) {
                                $init_value = 0;
                        } else {
                                $init_value = $value;
                        }

                        $counter = "<span class='display-counter' data-value='$value' data-direction='$direction'>$init_value</span>";

                        $icon_output = '';
                        if( $icon ) {
                                $icon_output = "<i class='counter-box-icon fa fontawesome-icon $icon size-large'></i>";
                        }

                        if( $unit_pos == 'prefix' ) {
                                $counter = $icon_output . $unit_output . $counter;
                        } else {
                                $counter = $icon_output . $counter . $unit_output;
                        }

                        $counter_container_class = 'content-box-percentage content-box-counter';
                        $counter_container_style = '';

                        if( $color ) {
                                $counter_container_style = sprintf( 'color:%s;', $color );
                        }

                        $counter_wrapper = "<div class='$counter_container_class' style='$counter_container_style'>$counter</div>";

                        $content_output = "<div class='counter-box-content'>".do_shortcode( $content )."</div>";

                        $border_class = '';
                        if( $border == 'yes' ) {
                                $border_class .= ' counter-box-border';
                        }

                        if( $parent_atts['columns'] ) {
                                $columns = 12 / $parent_atts['columns'];
                        } else {
                                $columns = 4;
                        }
                        $child_attr_class = 't4p-counter-box t4p-column col-counter-box counter-box-wrapper col-lg-' . $columns . ' col-md-' . $columns . ' col-sm-' . $columns;

                        $html = "<div class='$child_attr_class'><div class='counter-box-container $border_class'>$counter_wrapper $content_output</div></div>";
                
			return $html . "<!--seperate-->";
                }

	}

}
