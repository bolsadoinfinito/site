<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Modal_text_link' ) ) :

/**
 * Create Modal_text_link element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Modal_text_link extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Modal Text Link', 't4p-core' );
		$this->config['cat']         = __( 'Media', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-modal';
		$this->config['description'] = __( 'Add a Modal Text Link', 't4p-core' );

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
                                        'name'    => __( 'Name Of Modal', 't4p-core' ),
                                        'id'      => 'name',
                                        'type'    => 'text_field',
                                        'class'   => 'jsn-input-sm',
                                        'role'    => 'title',
                                        'std'     => '',
                                        'tooltip'  => __( 'Unique identifier of the modal to open on click.', 't4p-core' ),
                                ),
                                array(
                                        'name'    => __( 'Text or HTML code', 't4p-core' ),
                                        'id'      => 'body',
                                        'role'    => 'content',
                                        'type'    => 'text_area',
                                        'std'     => T4P_Pb_Helper_Type::lorem_text(3),
                                        'tooltip'  => __( 'Insert text or HTML code here (e.g: HTML for image). This content will be used to trigger the modal popup.', 't4p-core' ),
                                ),
			),
                        'styling' => array(
				array(
					'type' => 'preview',
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
		$arr_params    = ( shortcode_atts( $this->config['params'], $atts ) );
                extract( $arr_params );

                $name = ( ! $name ) ? '' : $name;
                $html = '';

                if( $name ) {
			$data_toggle = 'modal'; 
			$data_target = '.' . $name;

                        $html = "<a href='#' class='t4p-modal-text-link' data-toggle='$data_toggle' data-target='$data_target'>".do_shortcode( $content )."</a>";
                }

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
