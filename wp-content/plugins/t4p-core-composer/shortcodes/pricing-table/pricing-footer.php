<?php
/**
 * @version   1.0.0
 * @package   Theme4Press PageBuilder
 * @author    Theme4Press
 * 
 * 
 */

if ( ! class_exists( 'Pricing_footer' ) ) {

	/**
	 * Create pricing footer child element.
	 *
	 * @package  T4P PageBuilder Shortcodes
	 * @since    1.0.0
	 */
	class Pricing_footer extends T4P_Pb_Shortcode_Child {
                            
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
                                                'name'    => __( 'Button Text', 't4p-core' ),
                                                'id'      => 'footer',
                                                'type'    => 'text_field',
                                                'class'   => 'jsn-input-xxlarge-fluid',
                                                'role'    => 'content',
                                                'std'     => __( 'Signup', 't4p-core' ),
						'tooltip' => __( 'Button Text', 't4p-core' )
                                        ),
					array(
						'name'       => __( 'Button URL', 't4p-core' ),
						'id'         => 'button_url',
						'type'       => 'text_field',
						'class'      => 'jsn-input-xxlarge-fluid',
						'std'        => '',
						'tooltip'    => __( 'URL', 't4p-core' ),
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

                        $button_url = ( ! $button_url) ? '' : $button_url;

                        $html = "<div class='panel-footer footer-row'><a href='$button_url' style='display:block'>$content</a></div>";

                        return $html . '<!--seperate-->';
		}

	}

}