<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
/*
/*
 * Parent class for all elements of page builder
 */
class T4P_Pb_Shortcode_Common {

	/**
	 * element type: layout/element
	 */
	public $type;

	/**
	 * config information of this element
	 */
	public $config;

	/**
	 * setting options of this element
	 */
	public $items;

	public function __construct() {
		// Register required assets
		add_filter( 't4p-edit-element-required-assets', array( &$this, 'required_assets' ) );
	}

	/**
	 * Define required assets for shortcode settings form.
	 *
	 * @param   array  $assets  Current required assets.
	 *
	 * @return  array
	 */
	public function required_assets( $assets ) {
		if ( ! isset( $_GET['t4p_shortcode_preview'] ) || ! $_GET['t4p_shortcode_preview'] ) {
			// Register admin assets if required
			if ( @is_array( $this->config['exception'] ) && isset( $this->config['exception']['admin_assets'] ) ) {
				$assets[] = $this->config['exception']['admin_assets'];
			}
		} else {
			// Register front-end assets if required
			if ( @is_array( $this->config['exception'] ) && isset( $this->config['exception']['frontend_assets'] ) ) {
				$assets[] = $this->config['exception']['frontend_assets'];
			}
		}

		return $assets;
	}

	/*
	 * HTML structure of an element in SELECT ELEMENT modal box
	 */

	public function element_button( $sort ) {

	}

	/*
	 * HTML structure of an element in Page Builder area
	 */

	public function element_in_pgbldr() {

	}

	public function init_element() {

	}

}
