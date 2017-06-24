<?php
/**
 * @version   1.0.0
 * @package   Theme4Press PageBuilder
 * @author    Theme4Press
 * 
 * 
 */

if ( ! class_exists( 'Pricing_table' ) ) :

/**
 * Create Pricing Table element
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Pricing_table extends T4P_Pb_Shortcode_Parent {

        private $pricing_table_counter = 1;

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Configure shortcode.
	 *
	 * @return  void
	 */
	public function element_config() {
		$this->config['shortcode']        = strtolower( __CLASS__ );
		$this->config['name']             = __( 'Pricing Table', 't4p-core' );
		$this->config['cat']              = __( 'Typography', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-pricing-table';
		$this->config['description']      = __( 'Pricing table with flexible settings', 't4p-core' );
		$this->config['has_subshortcode'] = 'Pricing_column';

		// Define exception for this shortcode
		$this->config['exception'] = array();

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
					'name'                     => __( 'Pricing Column', 't4p-core' ),
					'id'                       => 'prtbl_column',
					'type'                     => 'group',
					'shortcode'                => ucfirst( __CLASS__ ),
					'sub_item_type'            => $this->config['has_subshortcode'],
					'sub_items'     => array(
						array( 'title' => 'Standard', 'standout' => 'no' ),
						array( 'title' => 'Standard', 'standout' => 'no' ),
						array( 'title' => 'Standard', 'standout' => 'no' ),
						array( 'title' => 'Standard', 'standout' => 'no' ),
						array( 'title' => 'Standard', 'standout' => 'no' ),
					),
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
                                array(
                                        'name'       => __( 'Type', 't4p-core' ),
                                        'id'         => 'type',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => '1',
                                        'options'    => array(
                                                        '1'      => __( 'Style 1 (Supports 5 Columns)', 't4p-core' ),
                                                        '2'   => __( 'Style 2 (Supports 4 Columns)', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'Select the type of pricing table', 't4p-core' ),
                                ),
                                array(
                                        'name' => __( 'Background Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'backgroundcolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the background color. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Border Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'bordercolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the border color. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Divider Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'dividercolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the divider color. Leave blank for theme option selection.', 't4p-core' )
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
                global $evl_options, $pricing_column_params, $column, $smof_data;

		$arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
		extract( $arr_params );

                $backgroundcolor = ( ! $backgroundcolor ) ? $smof_data['pricing_bg_color'] . $evl_options['evl_shortcode_pricing_box_bg_color'] : $backgroundcolor;
                $dividercolor = ( ! $dividercolor ) ? $smof_data['pricing_divider_color'] . $evl_options['evl_shortcode_pricing_box_divider_color'] : $dividercolor;
                $bordercolor = (! $dividercolor ) ? $smof_data['pricing_border_color'] . $evl_options['evl_shortcode_pricing_box_border_color'] : $bordercolor;
                $type = ( ! $type ) ? '1' : $type;
                $columns = '';

                $columns = $this->set_num_of_columns( $content );

                    if( $type == '1' && $columns > 6 ) {
                            $columns = 6;
                    }

                    if( $type == '2' && $columns > 4 ) {
                            $columns = 4;
                    }		

                    if( $columns ) {
                            $column = 12 / $columns;
                    } else {
                            $column = 4;
                    }

                //for get sub element html
                $sub_shortcode = do_shortcode( $content );
                $items = explode( '<!--seperate_column-->', $sub_shortcode );
                // remove empty element
                $items         = array_filter( $items );
                foreach ( $items as $idx => $item ) {
                        $items[$idx] = $item;
                }
                $sub_shortcode = implode( '', $items );
                $sub_htmls     = $sub_shortcode;

                $styles = "<style type='text/css'>
		.pricing-table-{$this->pricing_table_counter} .list-group .list-group-item,
		.pricing-table-{$this->pricing_table_counter} .list-group .list-group-item:last-child{background-color:{$backgroundcolor}; border-color:{$dividercolor};}
		.pricing-table-{$this->pricing_table_counter}.full-boxed-pricing .panel-heading{background-color:{$backgroundcolor};}
		.pricing-table-{$this->pricing_table_counter} .panel, .pricing-table-{$this->pricing_table_counter} .panel-wrapper:last-child .panel, 
		.pricing-table-{$this->pricing_table_counter} .standout .panel, .pricing-table-{$this->pricing_table_counter}  .panel-heading, 
		.pricing-table-{$this->pricing_table_counter} .panel-body, .pricing-table-{$this->pricing_table_counter} .panel-footer{border-color:{$dividercolor};}
		</style>";
                

                if( $type == '1' ) {
                        $type = 'full';
                } else {
                        $type = 'sep';
                }

                $attr_class = sprintf( 't4p-pricing-table pricing-table-%s %s-boxed-pricing row t4p-columns-%s columns-%s t4p-clearfix', 
                                          $this->pricing_table_counter, $type, $columns, $columns );

                $html_element = "$styles<div class='$attr_class'>$sub_htmls</div>";

		$this->pricing_table_counter++;

		return $this->element_wrapper( $html_element, $arr_params);
	}

        /**
         * Calculate the number of columns automatically
         * @param  string $content Content to be parsed
         */    
        function set_num_of_columns( $content ) {
                preg_match_all( '/(\[pricing_column (.*?)\](.*?)\[\/pricing_column\])/s', $content, $matches );
                if( is_array( $matches ) && 
                        ! empty( $matches ) 
                ) {
                        $columns = count( $matches[0] );

                        return $columns;
                }
	}

}

endif;
