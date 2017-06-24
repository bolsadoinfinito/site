<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Alert' ) ) :

/**
 * Create Alert element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Alert extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Alert', 				't4p-core' );
		$this->config['cat']         = __( 'Typography', 		't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-alert';
		$this->config['description'] = __( 'Multiple Alert message box types', 't4p-core' );

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
					'name'  => __( 'Alert Content', 't4p-core' ),
					'id'    => 'alert_content',
                                        'type' => 'text_area',
					'role'  => 'content',
					'std'   => T4P_Pb_Helper_Type::lorem_text(12),
                                        'tooltip' => __( 'Insert the alert content', 't4p-core' )
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => __( 'Alert Type', 't4p-core' ),
					'id'      => 'type',
					'type'    => 'select',
					'class'   => 'input-sm',
					'std'     => T4P_Pb_Helper_Type::get_first_option( T4P_Pb_Helper_Type::get_alert_type() ),
					'options' => T4P_Pb_Helper_Type::get_alert_type(),
                                        'tooltip' => __( 'Select the type of alert message', 't4p-core' ),
                                        'has_depend' => '1',
				),
                            	array(
					'name' => __( 'Accent Color', 't4p-core' ),
					'type' => array(
                                                array(
                                                        'id'           => 'accent_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
					),
					'dependency'  => array( 'type', '=', 'custom' ),
                                        'tooltip' => __( 'Custom setting only. Set the border, text and icon color for custom alert boxes.', 't4p-core' )
				),
                                array(
					'name' => __( 'Background Color', 't4p-core' ),
					'type' => array(
						array(
							'id'           => 'background_color',
							'type'         => 'color_picker',
							'std'          => '',
							'parent_class' => 'combo-item',
						),
					),
					'dependency'  => array( 'type', '=', 'custom' ),
                                        'tooltip' => __( 'Custom setting only. Set the background color for custom alert boxes.', 't4p-core' )
				),
                            	array(
					'name' => __( 'Border Width', 't4p-core' ),
					'type' => array(
						array(
							'id'         => 'border_size',
							'type'       => 'text_append',
							'type_input' => 'text_field',
							'class'      => 'input-mini',
							'std'        => '1px',
						),
					),
					'dependency'  => array( 'type', '=', 'custom' ),
                                        'tooltip' => __( 'Custom setting only. For custom alert boxes. Border width in pixels (px).', 't4p-core' )
				),
                                array(
                                        'name'      => __( 'Select Custom Icon', 't4p-core' ),
                                        'id'        => 'icon',
                                        'type'      => 'icons',
                                        'std'       => '',
                                        'role'      => 'title_prepend',
                                        'title_prepend_type' => 'icon',
                                        'dependency'  => array( 'type', '=', 'custom' ),
                                        'tooltip' => __( 'Custom setting only. Click an icon to select, click None to deselect', 't4p-core' )
                                ),
                            	array(
					'name'     => __( 'Show Icon', 't4p-core' ),
					'id'       => 'show_icon',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Display alert box icon or not', 't4p-core' ),
				),
                                array(
					'name'		=> __( 'Allow to close', 		't4p-core' ),
					'id'		=> 'alert_close',
					'type'		=> 'radio',
					'std'		=> 'yes',
					'options'	=> array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Display alert box close button or not', 't4p-core' ),
				),
                            	array(
					'name'       => __( 'Box Shadow', 't4p-core' ),
					'id'         => 'box_shadow',
					'type'       => 'radio',
					'std'        => 'yes',
					'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                        'tooltip'    => __( 'Display a box shadow below the alert box.', 't4p-core' )
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
		$html_element  = '';
		$arr_params    = ( shortcode_atts( $this->config['params'], $atts ) );
		$type          = ( ! $arr_params['type'] ) ? '' : $arr_params['type'];
                $alert_close = ( ! $arr_params['alert_close'] ) ? 'yes' : $arr_params['alert_close'];
		$close_btn   = '<button type="button" class="toggle-alert close" data-dismiss="alert" aria-hidden="true">×</button>';
                $show_icon = ( ! $arr_params['show_icon'] ) ? '' : $arr_params['show_icon'];
                $icon_logo     = ( ! $arr_params['icon'] ) ? '' : $arr_params['icon'];
		$icon          = '';
                if ( $show_icon == 'yes' ) {
                    switch( $type ) {
                            case 'general':
                                    $icon = "<span class='alert-icon'><i class='fa fa-lg fa-info-circle'></i></span>";
                                    break;
                            case 'error':
                                    $icon = "<span class='alert-icon'><i class='fa fa-lg fa-exclamation-triangle'></i></span>";
                                    break;
                            case 'success':
                                    $icon = "<span class='alert-icon'><i class='fa fa-lg fa-check-circle'></i></span>";
                                    break;
                            case 'notice':
                                    $icon = "<span class='alert-icon'><i class='fa fa-lg fa-lg fa-cog'></i></span>";
                                    break;
                            case 'custom':
                                    $icon = "<span class='alert-icon'><i class='fa $icon_logo'></i></span>";
                                    break;
                    }
                }
                $box_shadow = ( $arr_params['box_shadow'] == 'yes' ) ? 'alert-shadow' : '';
                $custom_style = '';
                if( $type == 'custom' ) {
                    $accent_color     = ( ! $arr_params['accent_color'] ) ? '' : $arr_params['accent_color'];
                    $background_color = ( ! $arr_params['background_color'] ) ? '' : $arr_params['background_color'];
                    $border_size      = ( ! $arr_params['border_size'] ) ? '' : $arr_params['border_size'];
                    $border_size = (float)$border_size;
                    $custom_style     = "style='background-color:$background_color; border-color:$accent_color; border-width:{$border_size}px; color:$accent_color'";
                }
                
		$html_element .= "<div class='t4p-alert alert $type alert-dismissable alert-$type $box_shadow' $custom_style>";
                if ( $alert_close == 'yes' ) {
                    $html_element .= $close_btn;
                }
		$html_element .= $icon;
		$html_element .= ( ! $content ) ? '' : $content;
		$html_element .= '</div>';

		return $this->element_wrapper( $html_element, $arr_params );
	}
}

endif;
