<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Separator' ) ) :

/**
 * Separator element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Separator extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Separator', 't4p-core' );
		$this->config['cat']         = __( 'General', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-divider';
		$this->config['description'] = __( 'Horizontal line for dividing sections', 't4p-core' );

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
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'         => __( 'Style', 't4p-core' ),
                                        'id'           => 'style_type',
                                        'type'         => 'select',
                                        'class'        => 'input-sm',
                                        'std'          => 'single',
                                        'options'      => T4P_Pb_Helper_Type::get_border_styles(),
                                        'tooltip'      => __( 'Choose the separator line style', 't4p-core' )
				),
                                array(
                                        'name' => __( 'Margin Top', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'         => 'top_margin',
                                                        'type'       => 'text_append',
                                                        'type_input' => 'number',
                                                        'class'      => 'input-mini',
                                                        'std'        => '40',
                                                        'append'     => 'px',
                                                        'validate'   => 'number',
                                                ),
                                        ),
                                        'tooltip' => __( 'Spacing above the separator', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Margin Bottom', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'         => 'bottom_margin',
                                                        'type'       => 'text_append',
                                                        'type_input' => 'number',
                                                        'class'      => 'input-mini',
                                                        'std'        => '40',
                                                        'append'     => 'px',
                                                        'validate'   => 'number',
                                                ),
                                        ),
                                        'tooltip' => __( 'Spacing below the separator', 't4p-core' )
                                ),
                                array(
                                        'name'         => __( 'Separator Color', 't4p-core' ),
                                        'id'           => 'sep_color',
                                        'type'         => 'color_picker',
                                        'std'          => '',
                                        'tooltip'      => __( 'Controls the separator color. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name'      => __( 'Select Custom Icon', 't4p-core' ),
                                        'id'        => 'icon',
                                        'type'      => 'icons',
                                        'std'       => '',
                                        'role'      => 'title_prepend',
                                        'title_prepend_type' => 'icon',
                                        'tooltip' => __( 'Click an icon to select, click None to deselect', 't4p-core' )
                                ),
                                array(
                                        'name'    => __( 'Separator Width', 't4p-core' ),
                                        'id'      => 'width',
                                        'type'    => 'text_field',
                                        'tooltip' => __( 'In pixels (px or %), ex: 1px, ex: 50%. Leave blank for full width.', 't4p-core' ),
                                )
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
                
                $style_type = ( ! $style_type ) ? 'none' : $style_type;
                $top_margin = ( ! $top_margin ) ? '40px' : $top_margin.'px';
                $bottom_margin = ( ! $bottom_margin ) ? '40px' : $bottom_margin.'px';
                $sep_color = ( ! $sep_color ) ? $smof_data['sep_color'] . strtolower($evl_options['evl_shortcode_separator_color']) : $sep_color;
		$icon  = ( ! $icon ) ? '' : "<i class='fa {$icon}'></i>";
                $width = ( ! $width ) ? '' : $width;

                $icon_span = '';
                if( $style_type != 'none' && $icon ) {
                    $icon_span = "<span class='icon-wrapper' style='color:{$sep_color}'>{$icon}</span>";
                }

                if( isset($top_margin) && $top_margin ) {
                    $top_margin = 'margin-top:'.$top_margin.';';
                }
                if( isset($bottom_margin) && $bottom_margin ) {
                    $bottom_margin = 'margin-bottom:'.$bottom_margin.';';
                }
                if( isset($sep_color) && $sep_color ) {
                    $sep_color = 'border-color:'.$sep_color.';';
                }
                if( isset($width) && $width ) {
                    $width = 'width:'.$width.';';
                }
                $inline_style = 'style='.$top_margin. $bottom_margin. $sep_color. $width;

		$style_type = explode( '|', $style_type );

		if( ! in_array( 'none', $style_type ) &&
			! in_array( 'single', $style_type ) &&
			! in_array( 'double', $style_type ) &&
			! in_array( 'shadow', $style_type )
		) {
			$style_type[] .= 'single';
		}

                $border_type = '';
		foreach ( $style_type as $borderstyle ) {
                        $border_type .= ' sep-' . $borderstyle;
		}

		$html_element = "<div class='t4p-separator {$border_type}' {$inline_style}>{$icon_span}</div>";

		return $this->element_wrapper( $html_element, $arr_params );
	}
}

endif;
