<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Dropcap' ) ) :

/**
 * Create Dropcap element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Dropcap extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Dropcap', 				't4p-core' );
		$this->config['cat']         = __( 'Typography', 		't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-dropcap';
		$this->config['description'] = __( 'Add a dropcap', 't4p-core' );

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
					'name'  => __( 'Dropcap Letter', 't4p-core' ),
					'id'    => 'dropcap_letter',
					'type'  => 'text_field',
					'role'  => 'content',
					'std'   => 'A',
                                        'tooltip' => __( 'Add the letter to be used as dropcap', 't4p-core' )
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
                            	array(
					'name' => __( 'Color', 't4p-core' ),
					'type' => array(
                                                array(
                                                        'id'           => 'color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
					),
                                        'tooltip' => __( 'Controls the color of the dropcap letter. Leave blank for theme option selection.', 't4p-core' )
				),
                                array(
					'name'     => __( 'Boxed Dropcap', 't4p-core' ),
					'id'       => 'boxed',
					'type'     => 'radio',
					'std'      => 'no',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose to get a boxed dropcap.', 't4p-core' ),
				),
                            	array(
					'name' => __( 'Box Radius', 't4p-core' ),
					'type' => array(
						array(
							'id'         => 'boxed_radius',
							'type'       => 'text_append',
							'type_input' => 'text_field',
							'class'      => 'input-mini',
							'std'        => '8px',
						),
					),
                                        'tooltip' => __( 'Choose the radius of the boxed dropcap.', 't4p-core' )
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
                
                $arr_params['color'] = ( ! $arr_params['color'] ) ? strtolower( $smof_data['dropcap_color'] ) . $evl_options['evl_shortcode_dropcap_color'] : $arr_params['color'];
                
                $attr_class = 't4p-dropcap dropcap';
		$attr_style = '';
		
                $arr_params['boxed_radius'] = (float)$arr_params['boxed_radius'];
                
		if( $arr_params['boxed'] == 'yes' ) {
			$attr_class .= ' dropcap-boxed';
			
			if( $arr_params['boxed_radius'] || 
				$arr_params['boxed_radius'] === '0'
			) {
				if( $arr_params['boxed_radius'] == 'round' ) {
					$arr_params['boxed_radius'] = '50%';
				}

				$attr_style = sprintf( 'border-radius:%spx;', $arr_params['boxed_radius'] );
			}			

			$attr_style .= sprintf( 'background-color:%s;', $arr_params['color'] );	
		} else {
			$attr_style .= sprintf( 'color:%s;', $arr_params['color'] );
		}

                $html = "<span class='$attr_class' style='$attr_style'>".do_shortcode( $content )."</span>";

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
