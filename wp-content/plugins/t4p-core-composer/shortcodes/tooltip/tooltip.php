<?php
/**
 * 
 * @version	1.0.0
 * @package	Theme4Press PageBuilder
 * @author	Theme4Press
 *
 */

if ( ! class_exists( 'Tooltip' ) ) :

/**
 * Create Tooltip element
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Tooltip extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Tooltip', 't4p-core' );
		$this->config['cat']         = __( 'Typography', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-tooltip';
		$this->config['description'] = __( 'Tooltip with flexible setting', 't4p-core' );

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
					'name'    => __( 'Tooltip Text', 't4p-core' ),
					'id'      => 'title',
					'type'    => 'text_field',
					'class'   => 'input-sm',
					'std'     => __( 'Your text', 't4p-core' ),
                                        'tooltip' => __( 'Insert the text that displays in the tooltip', 't4p-core' ),
				),
				array(
					'name'    => __( 'Content', 't4p-core' ),
					'id'      => 'tooltip_content',
					'role'    => 'content',
					'type'    => 'text_area',
					'std'     => __( 'Your tooltip content', 't4p-core' ),
                                        'tooltip' => __( 'Insert the text that will activate the tooltip hover', 't4p-core' ),
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => __( 'Tooltip Position', 't4p-core' ),
					'id'      => 'placement',
					'type'    => 'select',
					'class'   => 'input-sm',
					'std'     => T4P_Pb_Helper_Type::get_first_option( T4P_Pb_Helper_Type::get_full_positions() ),
					'options' => T4P_Pb_Helper_Type::get_full_positions(),
                                        'tooltip' => __( 'Choose the display position.', 't4p-core' )
				),
                                array(
                                        'name'       => __( 'Tooltip Trigger', 't4p-core' ),
                                        'id'         => 'trigger',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => 'hover',
                                        'options'    => array(
                                                                'hover'      => __( 'Hover', 't4p-core' ),
                                                                'click'   => __( 'Click', 't4p-core' ),
                                                        ),
                                        'tooltip'    => __( 'Choose action to trigger the tooltip.', 't4p-core' )
                                ),
                                array(
                                        'name'            => __( 'Delay', 't4p-core' ),
                                        'container_class' => 'combo-group',
                                        'type'            => array(
                                                array(
                                                        'id'            => 'show',
                                                        'type'          => 'text_append',
                                                        'type_input'    => 'number',
                                                        'class'         => 'input-mini',
                                                        'std'           => '500',
                                                        'append_before' => 'Show',
                                                        'append'        => 'ms',
                                                        'parent_class'  => 'input-group-inline',
                                                        'validate'      => 'number',
                                                ),
                                                array(
                                                        'id'            => 'hide',
                                                        'type'          => 'text_append',
                                                        'type_input'    => 'number',
                                                        'class'         => 'input-mini',
                                                        'std'           => '100',
                                                        'append_before' => 'Hide',
                                                        'append'        => 'ms',
                                                        'parent_class'  => 'input-group-inline',
                                                        'validate'      => 'number',
                                                ),
                                        ),
                                        'tooltip' => __( 'Set time (ms) to show/ hide tooltip when hover/ leave', 't4p-core' ),
                                    ),
                                array(
                                        'name'			=> __( 'Padding', 't4p-core' ),
                                        'container_class' 	=> 'combo-group',
                                        'id'			=> 'padding',
                                        'type'			=> 'margin',
                                        'extended_ids'          => array( 'padding_top', 'padding_bottom', 'padding_left', 'padding_right' ),
                                        'padding_top'            => array( 'std' => '' ),
                                        'padding_bottom' 	=> array( 'std' => '' ),
                                        'padding_left'           => array( 'std' => '' ),
                                        'padding_right'          => array( 'std' => '' ),
                                        'tooltip' 		=> __( 'In pixels', 't4p-core' )
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
		$arr_params = shortcode_atts( $this->config['params'], $atts );
		extract( $arr_params );
		$random_id  = T4P_Pb_Utils_Common::random_string();
		$tooltip_id = "tooltip_$random_id";

                $data_animation = 'false';
		$data_delay = 0;
		$data_placement = ( ! $placement ) ? 'top' : $placement;
		$data_title = ( ! $title ) ? 'none' : $title;
		$data_toggle = 'tooltip';
		$data_trigger = ( ! $trigger ) ? 'hover' : $trigger;
                $paddingtop = ( ! $padding_top ) ? '' : $padding_top;
                $paddingbottom = ( ! $padding_bottom ) ? '' : $padding_bottom;
                $paddingleft = ( ! $padding_left ) ? '' : $padding_left;
                $paddingright = ( ! $padding_right ) ? '' : $padding_right;

		$delay_show   = ! empty( $show ) ? intval( $show ) : 500;
		$delay_hide   = ! empty( $hide ) ? intval( $hide ) : 100;
		$script = "<script type='text/javascript'>( function ($) {
				$( document ).ready( function ()
				{
					$('.$tooltip_id').tooltip({
						delay: { show: $delay_show, hide: $delay_hide },
					})
				});
			} )( jQuery )</script>";
                
                $html_style = '';
                if( $paddingbottom ) {
			$html_style .= sprintf( 'padding-bottom:%spx;', $paddingbottom );
		}

		if( $paddingtop ) {
			$html_style .= sprintf( 'padding-top:%spx;', $paddingtop );
		}

                if( $paddingleft ) {
			$html_style .= sprintf( 'padding-left:%spx;', $paddingleft );
		}

                if( $paddingright ) {
			$html_style .= sprintf( 'padding-right:%spx;', $paddingright );
		}

                $html = "<span class='$tooltip_id t4p-tooltip tooltip-shortcode' data-animation='$data_animation' data-delay='$data_delay' data-placement='$data_placement' data-title='$data_title' data-toggle='$data_toggle' data-trigger='$data_trigger'>".do_shortcode( $content )."</span>";
                $html = "<div style='$html_style'>$html</div>";
		if ( is_admin() ) {
			$custom_style = "<style>.t4p-element-tooltip {width: 100%; margin-top: 50px; text-align: center;}</style>";
			$html_element = $custom_style.$html.$script;
		} else {
                        $html_element = $html.$script;
                }
		return $this->element_wrapper( $html_element, $arr_params );
	}
}

endif;
