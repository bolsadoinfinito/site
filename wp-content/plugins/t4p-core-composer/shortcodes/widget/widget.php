<?php

/**
 * 
 * @version	1.0.0
 * @package	Theme4Press PageBuilder
 * @author	Theme4Press
 * 
 */
if ( ! class_exists( 'Widget' ) ) :

/**
 * Widget element for T4P PageBuilder.
 *
 * @since  1.0.0
 */
class Widget extends T4P_Pb_Shortcode_Element {
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
	function element_config() {
		$this->config['shortcode'] = strtolower( __CLASS__ );

		// Use Ajax to speed up element settings modal loading speed
		$this->config['edit_using_ajax'] = true;
	}

	/**
	 * Define shortcode settings.
	 *
	 * @return  void
	 */
	function element_items() {
	}

	/**
	 * Generate HTML code from shortcode content.
	 *
	 * @param   array   $atts     Shortcode attributes.
	 * @param   string  $content  Current content.
	 *
	 * @return  string
	 */
	function element_shortcode_full( $atts = null, $content = null ) {
            $temp;
	}
}

endif;
