<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Menu_anchor' ) ) :

/**
 * Create Menu_anchor element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Menu_anchor extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Menu Anchor', 't4p-core' );
		$this->config['cat']         = __( 'General', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-menu-anchor';
		$this->config['description'] = __( 'Add a Menu in your one page menu.', 't4p-core' );

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
                                        'name'    => __( 'Name Of Menu Anchor ', 't4p-core' ),
                                        'id'      => 'name',
                                        'type'    => 'text_field',
                                        'class'   => 'jsn-input-xxlarge-fluid',
                                        'role'    => 'title',
                                        'std'     => '',
                                        'tooltip'  => __( 'This name will be the id you will have to use in your one page menu.', 't4p-core' ),
                                ),
			),
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
		$arr_params    = ( shortcode_atts( $this->config['params'], $atts ) );
                extract( $arr_params );

                $name = ( ! $name ) ? '' : $name;

                $html = "<div id='$name' class='t4p-menu-anchor'></div>";

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
