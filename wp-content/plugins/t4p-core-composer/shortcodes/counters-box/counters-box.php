<?php

/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */

if ( ! class_exists( 'Counters_box' ) ) :

/**
 * Create Counters_box element
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Counters_box extends T4P_Pb_Shortcode_Parent {
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
		$this->config['name']             = __( 'Counter Box', 't4p-core' );
		$this->config['cat']              = __( 'General', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-counter-box';
		$this->config['has_subshortcode'] = 'Counter_box';
		$this->config['description']      = __( 'Layout for the counter box', 't4p-core' );

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
					'id'            => 'counter_box_item',
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

                $parent_attr_class = sprintf( 't4p-counters-box counters-box row t4p-clearfix t4p-columns-%s',  $columns );

                $html = "<div class='$parent_attr_class'>$sub_htmls</div><div class='clearfix'></div>";

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
