<?php
/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */

if ( ! class_exists( 'Tagline_box' ) ) :

/**
 * Create Tagline_box element
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Tagline_box extends T4P_Pb_Shortcode_Element {

        private $tagline_box_counter = 1;

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
		$this->config['name']        = __( 'Tagline Box', 't4p-core' );
		$this->config['cat']         = __( 'Typography', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-promotion-box';
		$this->config['description'] = __( 'Styled box for promotion', 't4p-core' );

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
                                        'name'    => __( 'Tagline Title', 't4p-core' ),
					'id'      => 'title',
					'type'    => 'text_field',
					'class'   => 'input-sm',
					'std'     => __( 'Title', 't4p-core' ),
                                        'tooltip' => __( 'Insert the title text', 't4p-core' )
				),
				array(
                                        'name'    => __( 'Tagline Description', 't4p-core' ),
					'id'      => 'description',
					'type'    => 'text_area',
					'rows'    => '12',
					'std'     => T4P_Pb_Helper_Type::lorem_text(12),
                                        'tooltip' => __( 'Insert the description text', 't4p-core' )
				),
                                array(
                                        'name'    => __( 'Button Text', 't4p-core' ),
                                        'id'      => 'button',
                                        'type'    => 'text_field',
                                        'std'     => '',
                                        'tooltip' => __( 'Insert the text that will display in the button', 't4p-core' ),
                                ),
                            	array(
                                    'name'       => __( 'Link', 't4p-core' ),
                                    'id'         => 'link',
                                    'type'       => 'text_field',
                                    'class'      => 'input-sm',
                                    'tooltip'    => __( 'The url the button will link to', 't4p-core' ),
                                ),
                                array(
                                        'name'       => __( 'Link Target', 't4p-core' ),
                                        'id'         => 'linktarget',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '_self',
                                        'options'    => array(
                                                                '_self'      => __( '_self', 't4p-core' ),
                                                                '_blank'   => __( '_blank', 't4p-core' ),
                                                        ),
                                        'tooltip'    => __( '_self = open in same window _blank = open in new window.', 't4p-core' ),
                                ),
			),
			'styling' => array(
				array(
					'type' => 'preview',
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
                                    'name'       => __( 'Shadow', 't4p-core' ),
                                    'id'         => 'shadow',
                                    'type'       => 'select',
                                    'class'      => 'input-sm',
                                    'std'        => 'no',
                                    'options'    => array(
                                                            'yes'   => __( 'Yes', 't4p-core' ),
                                                            'no'    => __( 'No', 't4p-core' )
                                                    ),
                                    'tooltip'    => __( 'Choose to enable/disable the shadows. Choose default for theme option selection.', 't4p-core' )
                                ),
                                array(
                                    'name'       => __( 'Shadow Opacity', 't4p-core' ),
                                    'id'         => 'shadowopacity',
                                    'type'       => 'select',
                                    'class'   => 'input-sm',
                                    'std'        => '0.1',
                                    'options'    => array(
                                                            '0.1'   => __( '0.1', 't4p-core' ),
                                                            '0.2'   => __( '0.2', 't4p-core' ),
                                                            '0.3'   => __( '0.3', 't4p-core' ),
                                                            '0.4'   => __( '0.4', 't4p-core' ),
                                                            '0.5'   => __( '0.5', 't4p-core' ),
                                                            '0.6'   => __( '0.6', 't4p-core' ),
                                                            '0.7'   => __( '0.7', 't4p-core' ),
                                                            '0.8'   => __( '0.8', 't4p-core' ),
                                                            '0.9'   => __( '0.9', 't4p-core' ),
                                                            '1'   => __( '1', 't4p-core' ),
                                                    ),
                                    'tooltip'    => __( 'Choose the opacity of the shadow', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Border Width', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'         => 'border',
                                                        'type'       => 'text_append',
                                                        'type_input' => 'text_field',
                                                        'class'      => 'input-mini',
                                                        'std'        => '1px',
                                                ),
                                        ),
                                        'tooltip' => __( 'In pixels (px), ex: 1px', 't4p-core' )
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
                                    'name'       => __( 'Highlight Border Position', 't4p-core' ),
                                    'id'         => 'highlightposition',
                                    'type'       => 'select',
                                    'class'      => 'input-sm',
                                    'std'        => 'top',
                                    'options'    => array(
                                                            'top'   => __( 'Top', 't4p-core' ),
                                                            'bottom'    => __( 'Bottom', 't4p-core' ),
                                                            'left'   => __( 'Left', 't4p-core' ),
                                                            'right'    => __( 'Right', 't4p-core' ),
                                                            'none'   => __( 'None', 't4p-core' )
                                                    ),
                                    'tooltip'    => __( 'Choose the position of the highlight. This border highlight is from theme options primary color and does not take the color from border color above', 't4p-core' )
                                ),
                                array(
                                    'name'       => __( 'Content Alignment', 't4p-core' ),
                                    'id'         => 'content_alignment',
                                    'type'       => 'select',
                                    'class'      => 'input-sm',
                                    'std'        => 'left',
                                    'options'    => array(
                                                            'left'   => __( 'Left', 't4p-core' ),
                                                            'center'   => __( 'Center', 't4p-core' ),
                                                            'right'    => __( 'Right', 't4p-core' )
                                                    ),
                                    'tooltip'    => __( 'Choose how the content should be displayed.', 't4p-core' )
                                ),
                                array(
                                        'name'    => __( 'Button Style', 't4p-core' ),
                                        'id'      => 'buttoncolor',
                                        'type'    => 'select',
                                        'class'   => 'input-sm',
                                        'options'    => array(
                                                'default'      => __( 'Default', 't4p-core' ),
                                                'green'    => __( 'Green', 't4p-core' ),
                                                'darkgreen'      => __( 'Dark Green', 't4p-core' ),
                                                'orange'   => __( 'Orange', 't4p-core' ),
                                                'blue'    => __( 'Blue', 't4p-core' ),
                                                'red'      => __( 'Red', 't4p-core' ),
                                                'pink'   => __( 'Pink', 't4p-core' ),
                                                'darkgray'    => __( 'Dark Gray', 't4p-core' ),
                                                'lightgray'      => __( 'Light Gray', 't4p-core' ),
                                        ),
                                        'tooltip' => __( 'Choose the button color. Default uses theme option selection', 't4p-core' ),
                                ),
                                array(
                                        'name'    => __( 'Button Size', 't4p-core' ),
                                        'id'      => 'button_size',
                                        'type'    => 'select',
                                        'class'   => 'input-sm',
                                        'std'     => 'small',
                                        'options' => T4P_Pb_Helper_Type::get_button_size(),
                                        'tooltip' => __( 'Select the buttons size.', 't4p-core' ),
                                ),
                                array(
                                        'name'       => __( 'Button Type', 't4p-core' ),
                                        'id'         => 'button_type',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'     => 'flat',
                                        'options'    => array(
                                                                'flat'   => __( 'Flat', 't4p-core' ),
                                                                '3d'    => __( '3D', 't4p-core' )
                                                        ),
                                        'tooltip'    => __( 'Select the button type.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Button Shape', 't4p-core' ),
                                        'id'         => 'button_shape',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'     => 'square',
                                        'options'    => array(
                                                                'square'   => __( 'Square', 't4p-core' ),
                                                                'pill'    => __( 'Pill', 't4p-core' ),
                                                                'round'    => __( 'Round', 't4p-core' ),
                                                        ),
                                        'tooltip'    => __( 'Select the button shape.', 't4p-core' )
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
                global $evl_options, $smof_data;
		$html_element = '';
		$arr_params   = shortcode_atts( $this->config['params'], $atts );
		extract( $arr_params );

                $title = ( ! $title ) ? '' : $title;
                $description = ( ! $description ) ? '' : $description;
                $button  = ( ! $button ) ? '' : $button;
		$link = ( ! $link ) ? '' : $link;
                $linktarget = ( ! $linktarget ) ? 'target="_self"' : 'target="'.$linktarget.'"';
                $backgroundcolor = ( ! $backgroundcolor ) ? strtolower( $smof_data['tagline_bg'] ) . $evl_options['evl_shortcode_tagline_bg_color'] : $backgroundcolor;
                $shadow = ( ! $shadow ) ? '' : $shadow;
                $shadowopacity = ( ! $shadowopacity ) ? '' : $shadowopacity;
                $border = ( ! $border ) ? '' : $border;
                $border = (float)$border;
                $bordercolor = ( ! $bordercolor ) ? strtolower( $smof_data['tagline_border_color'] ) . $evl_options['evl_shortcode_tagline_border_color'] : $bordercolor;
                $highlightposition = ( ! $highlightposition ) ? '' : $highlightposition;
                $content_alignment = ( ! $content_alignment ) ? '' : $content_alignment;
                $buttoncolor = ( ! $buttoncolor ) ? 'default' : $buttoncolor;
                $button_size  = ( ! $button_size ) ? strtolower( $smof_data['button_size'] ) : $button_size;
                $button_type = ( ! $button_type ) ? strtolower( $smof_data['button_type'] ) : $button_type;
                $button_shape = ( ! $button_shape ) ? strtolower( $smof_data['button_shape'] ) : $button_shape;

                $additional_content = '';

		$styles = "<style type='text/css'>.reading-box-container-{$this->tagline_box_counter} .element-bottomshadow:before,.reading-box-container-{$this->tagline_box_counter} .element-bottomshadow:after{opacity:{$shadowopacity};}</style>";

                $button_attr = sprintf( 'btn button btn-default t4p-button button-%s button-%s button-%s button-%s', $buttoncolor, 
        						  $button_shape, $button_size, $button_type );

		if( $content_alignment == 'right' ) {
			$button_attr .= ' continue-left';
		} elseif( $content_alignment == 'center' ) {
			$button_attr .= ' continue-center';
		} else {
			$button_attr .= ' continue-right';
		}

		$button_href = $link;
		$button_target = $linktarget;
		$button_type = 'button';

                if( ( isset( $link ) && $link ) && 
			( isset( $button ) && $button ) &&
			$content_alignment != 'center'
		) {
			$button_class = 'continue';
			$additional_content = "<a class='$button_attr $button_class' href='{$button_href}' target='{$button_target}' type='{$button_type}'>{$button}</a>";
                }

		if( isset( $title ) && $title ) {
			$additional_content .= sprintf( '<h2>%s</h2>',  $title );
		}

		if( isset( $description ) && $description ) {
			$additional_content .= sprintf( '<p>%s</p>',  $description );
		}

		if( ( isset( $link ) && $link ) && 
			( isset( $button ) && $button ) &&
			$content_alignment == 'center'
		) {
			$button_class = 'continue';
			$additional_content .= "<a class='$button_attr $button_class' href='{$button_href}' target='{$button_target}' type='{$button_type}'>{$button}</a>";
		}		

		if( ( isset( $link ) && $link ) && ( isset( $button ) && $button ) ) {
			$button_class = 'mobile-button';
			$additional_content .= "<a class='$button_attr $button_class' href='{$button_href}' target='{$button_target}' type='{$button_type}'>{$button}</a>";
		}

                $attr = 't4p-reading-box-container reading-box-container-' . $this->tagline_box_counter;

                $reading_box_attr = 'reading-box';

                if( $content_alignment == 'right' ) {
                        $reading_box_attr .= ' reading-box-right';
                } elseif( $content_alignment == 'center' ) {
                        $reading_box_attr .= ' reading-box-center';
                }

                if( $shadow == 'yes' ) {
                        $reading_box_attr .= ' element-bottomshadow';
                }

                $reading_boxr_style = sprintf( 'background-color:%s;', $backgroundcolor );
                if( $highlightposition != 'none' ) {
                        if( str_replace( 'px', '', $border ) > 3  ) {
                                $reading_boxr_style .= sprintf( 'border-%s:%spx solid %s', $highlightposition, $border, $bordercolor  );
                        } else {
                                $reading_boxr_style .= sprintf( 'border-%s:3px solid %s;', $highlightposition, $bordercolor );
                        }
                }

		$html_element = "{$styles}<div class='$attr'><section class='$reading_box_attr' style='$reading_boxr_style'>{$additional_content}</section></div>";
		$this->tagline_box_counter++;

		return $this->element_wrapper( $html_element, $arr_params );
	}
}

endif;
