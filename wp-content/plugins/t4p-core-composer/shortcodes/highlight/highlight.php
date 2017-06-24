<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Highlight' ) ) :

/**
 * Create Highlight element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Highlight extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Highlight', 't4p-core' );
		$this->config['cat']         = __( 'Typography', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-highlight';
		$this->config['description'] = __( 'Add a Highlight Text', 't4p-core' );

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
					'name'  => __( 'Content to Higlight', 't4p-core' ),
					'id'    => 'discription',
					'type'  => 'text_area',
					'role'  => 'content',
					'std'   => T4P_Pb_Helper_Type::lorem_text(5),
                                        'tooltip' => __( 'Add your content to be highlighted', 't4p-core' )
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
                            	array(
					'name' => __( 'Highlight Color', 't4p-core' ),
					'type' => array(
                                                array(
                                                        'id'           => 'color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
					),
                                        'tooltip' => __( 'Pick a highlight color', 't4p-core' )
				),
                                array(
					'name'     => __( 'Highlight With Round Edges', 't4p-core' ),
					'id'       => 'rounded',
					'type'     => 'radio',
					'std'      => 'no',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose to have rounded edges.', 't4p-core' ),
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

                $arr_params['color'] = ( ! $arr_params['color'] ) ? $smof_data['primary_color'] . $evl_options['evl_general_link'] : $arr_params['color'];
                $arr_params['rounded'] = ( ! $arr_params['rounded'] ) ? 'no' : $arr_params['rounded'];

                //html_attr
                $class = 't4p-highlight';
                $brightness_level = T4PCore_Plugin::calc_color_brightness( $arr_params['color'] );
                if( $brightness_level > 140 ) {
                        $class .= ' light';
                } else {
                        $class .= ' dark';
                }
                if( $arr_params['rounded'] == 'yes' ) {
                    $class .= ' rounded'; 
                }        
                if( $arr_params['color'] == 'black') {
                    $class .= ' highlight2';
                } else {
                    $class .= ' higlight1';
                }
                $style = sprintf( 'background-color:%s;', $arr_params['color'] );

                $html = "<span class='$class' style='$style'>".do_shortcode($content)."</span>";

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
