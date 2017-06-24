<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Buttonbars' ) ) :

/**
 * Create a bar of buttons
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Buttonbars extends T4P_Pb_Shortcode_Parent {
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
		$this->config['shortcode']        = strtolower( __CLASS__ );
		$this->config['name']             = __( 'Button Bar', 't4p-core' );
		$this->config['cat']              = __( 'Typography', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-button-bar';
		$this->config['has_subshortcode'] = 'Buttonbar';
		$this->config['description']      = __( 'Bar of buttons', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(
                        'default_content'  => __( 'Button Bar', 't4p-core' ),
			'data-modal-title' => __( 'Button Bar', 't4p-core' ),
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
					'id' => 'buttonbar_items',
					'type' => 'group',
					'shortcode' => ucfirst( __CLASS__ ),
					'sub_item_type' => $this->config['has_subshortcode'],
					'sub_items' => array(
						array( 'std' => '' ),
						array( 'std' => '' ),
						array( 'std' => '' ),
					)
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => __( 'Alignment', 't4p-core' ),
					'id'      => 'buttonbar_alignment',
					'type'    => 'radio_button_group',
					'std'     => T4P_Pb_Helper_Type::get_first_option( T4P_Pb_Helper_Type::get_text_align() ),
					'options' => T4P_Pb_Helper_Type::get_text_align(),
				),
				array(
					'name'            => __( 'Margin', 't4p-core' ),
					'container_class' => 'combo-group',
					'id'              => 'buttonbar_margin',
					'type'            => 'margin',
					'extended_ids'    => array( 'buttonbar_margin_top', 'buttonbar_margin_right', 'buttonbar_margin_bottom', 'buttonbar_margin_left' ),
					'buttonbar_margin_top'    => array( 'std' => '10' ),
					'buttonbar_margin_right'  => array( 'std' => '10' ),
					'buttonbar_margin_bottom' => array( 'std' => '10' ),
					'buttonbar_margin_left'   => array( 'std' => '10' ),
					'tooltip'             => __( 'External spacing with other elements', 't4p-core' ),
				),
				array(
					'name' => __( 'Distance between items', 't4p-core' ),
					'type' => array(
						array(
							'id'         => 'distance_between',
							'type'       => 'text_append',
							'type_input' => 'number',
							'class'      => 'input-mini',
							'std'        => '5',
							'append'     => 'px',
							'validate'   => 'number',
						),
					),
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
		$arr_params    = shortcode_atts( $this->config['params'], $atts );
		$html_element  = '';
		$sub_shortcode = do_shortcode( $content );
		$items = explode( '<!--seperate-->', $sub_shortcode );
		// remove empty element
		$items         = array_filter( $items );
		$initial_open  = ( ! isset($initial_open ) || $initial_open > count( $items ) ) ? 1 : $initial_open;
		foreach ( $items as $idx => $item ) {
			$open        = ( $idx + 1 == $initial_open ) ? 'in' : '';
			$items[$idx] = $item;
		}
		$sub_shortcode = implode( '', $items );
		$sub_htmls     = $sub_shortcode;

		// button margin between
		$distance_between = ( isset( $arr_params['distance_between'] ) ) ? intval( $arr_params['distance_between'] ) : '';
                $distance_between = $distance_between ? "margin-right:{$distance_between}px" : '';
                $distance_null = "margin-right: 0px";
                $styles = sprintf('<style>.btn-default{%s} .btn-default:last-child{%s}</style>', $distance_between, $distance_null);

                $html_element = $sub_htmls;

		$cls_alignment = '';
		if ( strtolower( $arr_params['buttonbar_alignment'] ) != 'inherit' ) {
			if ( strtolower( $arr_params['buttonbar_alignment'] ) == 'left' )
				$cls_alignment = 'pull-left';
			if ( strtolower( $arr_params['buttonbar_alignment'] ) == 'right' )
				$cls_alignment = 'pull-right';
			if ( strtolower( $arr_params['buttonbar_alignment'] ) == 'center' )
				$cls_alignment = 'text-center';
		}
		$html_element = "{$styles}<div class='btn-toolbar {$cls_alignment}'>{$html_element}</div>";

		// Set button bar margin
		if ( isset( $arr_params['buttonbar_margin_top'] ) )
                            $arr_params['div_margin_top'] = $arr_params['buttonbar_margin_top'];
		if ( isset( $arr_params['buttonbar_margin_left'] ) )
			$arr_params['div_margin_left'] = $arr_params['buttonbar_margin_left'];
		if ( isset( $arr_params['buttonbar_margin_right'] ) )
			$arr_params['div_margin_right'] = $arr_params['buttonbar_margin_right'];
		if ( isset( $arr_params['buttonbar_margin_bottom'] ) )
			$arr_params['div_margin_bottom'] = $arr_params['buttonbar_margin_bottom'];

		return $this->element_wrapper( $html_element, $arr_params );
	}
}

endif;
