<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Title' ) ) :

/**
 * Heading element for T4P PageBuilder.
 *
 * @since  1.0.0
 */
class Title extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Title', 't4p-core' );
		$this->config['cat']         = __( 'Typography', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-heading';
		$this->config['description'] = __( 'Heading tags for text', 't4p-core' );

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
					'name'    => __( 'Title Size', 't4p-core' ),
					'id'      => 'size',
					'type'    => 'select',
					'class'   => 'input-sm',
					'std'     => '1',
					'options' => array( '1' => 'H1', '2' => 'H2', '3' => 'H3', '4' => 'H4', '5' => 'H5', '6' => 'H6' ),
					'tooltip' => __( 'Choose the title size, H1-H6', 't4p-core' )
				),
				array(
					'name'    => __( 'Title', 't4p-core' ),
					'id'      => 'title',
					'type'    => 'text_field',
					'role'    => 'content',
					'class'   => 'input-sm',
					'std'     => __( 'Your heading text', 't4p-core' ),
                                        'tooltip' => __( 'Insert the title text.', 't4p-core' )
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => __( 'Title Alignment', 't4p-core' ),
					'id'      => 'content_align',
					'type'    => 'radio_button_group',
					'std'     => T4P_Pb_Helper_Type::get_first_option( T4P_Pb_Helper_Type::get_text_align_lr() ),
					'options' => T4P_Pb_Helper_Type::get_text_align_lr(),
					'class'   => 'input-sm',
                                        'tooltip'    => __( 'Choose to align the heading left or right.', 't4p-core' )
				),
                                array(
                                        'name'       => __( 'Separator', 't4p-core' ),
                                        'id'         => 'separator',
                                        'type'       => 'select',
                                        'std'        => 'single',
                                        'class'      => 'input-sm',
                                        'options'    => array(
                                                                'single'   => __( 'Single', 't4p-core' ),
                                                                'double'    => __( 'Double', 't4p-core' ),
                                                                'underline'    => __( 'Underline', 't4p-core' ),
                                                        ),
                                        'tooltip'    => __( 'Choose the kind of the title separator you want to use.', 't4p-core' ),
                                ),
                                array(
                                        'name'       => __( 'Separator Style', 't4p-core' ),
                                        'id'         => 'separator_style',
                                        'type'       => 'select',
                                        'std'        => 'solid',
                                        'class'      => 'input-sm',
                                        'options'    => array(
                                                                'solid'   => __( 'Solid', 't4p-core' ),
                                                                'dashed'    => __( 'Dashed', 't4p-core' ),
                                                                'dotted'    => __( 'Dotted', 't4p-core' ),
                                                                'groove'    => __( 'Groove', 't4p-core' ),
                                                                'ridge'    => __( 'Ridge', 't4p-core' ),
                                                                'inset'    => __( 'Inset', 't4p-core' ),
                                                                'outset'    => __( 'Outset', 't4p-core' ),
                                                    ),
                                        'tooltip'    => __( 'Choose the style of the title separator.', 't4p-core' ),
                                ),
                                array(
                                        'name' => __( 'Separator Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'sep_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the separator color. Leave blank for theme option selection.', 't4p-core' ),
                                ),
				array(
					'name' => __( 'Underline Padding', 't4p-core' ),
					'type' => array(
						array(
							'id'         => 'padding_bottom',
							'type'       => 'text_append',
							'type_input' => 'number',
							'class'      => 'input-mini',
							'std'        => '',
							'append'     => 'px',
							'validate'   => 'number',
						),
					),
                                        'tooltip' => __( 'Spacing above the underline.', 't4p-core' ),
				),
				T4P_Pb_Helper_Type::get_animation_type(),
                                T4P_Pb_Helper_Type::get_animations_direction(),
				T4P_Pb_Helper_Type::get_animation_speeds(),

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
                global $evl_options;
		$arr_params     = ( shortcode_atts( $this->config['params'], $atts ) );
		extract($arr_params);

                $size = ( ! $size ) ? '1' : $size;
                $content_align = ( ! $content_align ) ? 'left' : $content_align;
                if ( isset ( $atts['style_type'] ) ) {
                        $style_type = explode(' ', $atts['style_type']);
                        $separator = ( ! $style_type[0] ) ? '' : $style_type[0];
                        $separator_style = ( ! $style_type[1] ) ? '' : $style_type[1];
                } else {
                        $separator = ( ! $separator ) ? '' : $separator;
                        $separator_style = ( ! $separator_style ) ? '' : $separator_style;
                }
                $sep_color = ( ! $sep_color ) ? strtolower($evl_options['evl_shortcode_title_sep_color']) : $sep_color;
                $padding_bottom = ( ! $padding_bottom ) ? '' : $padding_bottom.'px';

                $attr_class = 't4p-title title';
                if( $separator == 'underline' ) {
                        $attr_class .= ' sep-' . $separator;
                        $attr_class .= ' sep-' . $separator_style;

                        $attr_style =  'border-color:'.$sep_color.';';
                        if ($padding_bottom) {
                            $attr_style .=  'padding-bottom:'.$padding_bottom.';';
                        }
		}

                $heading_attr_class = 'title-heading-'.$content_align;

                $sep_attr_class = 'title-sep';
                $sep_attr_class .= ' sep-' . $separator;
                $sep_attr_class .= ' sep-' . $separator_style;
                $sep_attr_style =  'border-color:'.$sep_color;

		if( $separator != 'underline' ) {

			if( $content_align == 'right' ) {

				$html_element = "<div class='$attr_class'><div class='title-sep-container'><div class='$sep_attr_class' style='$sep_attr_style'></div></div><h$size class='$heading_attr_class'>".do_shortcode( $content )."</h$size></div>";			

			} else {

				$html_element = "<div class='$attr_class'><h$size class='$heading_attr_class'>".do_shortcode( $content )."</h$size><div class='title-sep-container'><div class='$sep_attr_class' style='$sep_attr_style'></div></div></div>";
			}
		
		} else {

			$html_element = "<div class='$attr_class' style='$attr_style'><h$size class='$heading_attr_class'>".do_shortcode( $content )."</h$size></div>";
		}

		return $this->element_wrapper( $html_element, $arr_params );
	}
}

endif;
