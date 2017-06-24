<?php
/**
 * @version   1.0.0
 * @package   Theme4Press PageBuilder
 * @author    Theme4Press
 * 
 * 
 */

if ( ! class_exists( 'Pricing_row' ) ) {

	/**
	 * Create pricing row child element.
	 *
	 * @package  T4P PageBuilder Shortcodes
	 * @since    1.0.0
	 */
	class Pricing_row extends T4P_Pb_Shortcode_Child {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		public function element_config() {
			$this->config['shortcode'] = strtolower( __CLASS__ );

			$this->config['exception'] = array();

                        $this->config['edit_inline'] = true;
		}

		/**
		 * DEFINE setting options of shortcode
		 */
		public function element_items() {
			$this->items = array(
				'Notab' => array(
                                        array(
                                                'name'    => __( 'Featured', 't4p-core' ),
                                                'id'      => 'row',
                                                'type'    => 'text_field',
                                                'class'   => 'jsn-input-xxlarge-fluid',
                                                'role'    => 'content',
                                                'std'     => 'Feature 1',
                                                'tooltip' => __( 'Insert the featured item', 't4p-core' )
                                        ),
				)
			);
		}

		/**
		 * DEFINE shortcode content
		 *
		 * @param type $atts
		 * @param type $content
		 */
		public function element_shortcode_full( $atts = null, $content = null ) {
                        $arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
			extract( $arr_params );

                        $html = '';

                        $html .= "<li class='list-group-item normal-row'>$content</li>";

                        return $html . '<!--seperate-->';
		}
	}

}