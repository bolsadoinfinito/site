<?php

/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */

if ( ! class_exists( 'Flip_boxes' ) ) :

/**
 * Create Flip_boxes element
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Flip_boxes extends T4P_Pb_Shortcode_Parent {
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
		$this->config['name']             = __( 'Flip Boxes', 't4p-core' );
		$this->config['cat']              = __( 'Typography', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-flip-box';
		$this->config['has_subshortcode'] = 'Flip_box';
		$this->config['description']      = __( 'Add a flip boxes', 't4p-core' );

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
					'id'            => 'content_box_item',
					'type'          => 'group',
					'shortcode'     => ucfirst( __CLASS__ ),
					'sub_item_type' => $this->config['has_subshortcode'],
					'sub_items'     => array(
						array( 'std' => '' ),
						array( 'std' => '' ),
					),
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
                            	array(
					'name'       => __( 'Number of Columns', 't4p-core' ),
					'id'         => 'columns',
					'type'    => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => '4',
                                        'options'    => array(
                                                        '1'   => __( '1', 't4p-core' ),
                                                        '2'   => __( '2', 't4p-core' ),
                                                        '3'   => __( '3', 't4p-core' ),
                                                        '4'   => __( '4', 't4p-core' ),
                                                ),
                                        'tooltip'  => __( 'Set the number of columns per row.', 't4p-core' ),
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
                global $parent_atts;
                $parent_atts = $arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
                extract( $arr_params );

                $columns  = ( ! $columns ) ? '4' : $columns;

                $sub_shortcode = do_shortcode( $content );
		$items = explode( '<!--seperate-->', $sub_shortcode );
		// remove empty element
		$items         = array_filter( $items );
		foreach ( $items as $idx => $item ) {
			$items[$idx] = $item;
		}
		$sub_shortcode = implode( '', $items );
		$sub_htmls     = $sub_shortcode;

                $html = "<div class='t4p-flip-boxes flip-boxes'>$sub_htmls</div><div class='clearfix'></div>";

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
