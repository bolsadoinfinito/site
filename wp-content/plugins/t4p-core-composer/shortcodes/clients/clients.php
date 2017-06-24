<?php

/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */

if ( ! class_exists( 'Clients' ) ) :
/**
 * Create Clients element
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Clients extends T4P_Pb_Shortcode_Parent {
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
		$this->config['name']             = __( 'Client Slider', 't4p-core' );
		$this->config['cat']              = __( 'General', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-client-slider';
		$this->config['has_subshortcode'] = 'Client';
		$this->config['description']      = __( 'Add client in Client Slider', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(
                    	'admin_assets' => array(
				't4p-pb-jquery.carouFredSel',
			),
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
					'id'            => 'client_items',
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
                                        'name'       => __( 'Picture Size ', 't4p-core' ),
                                        'id'         => 'picture_size',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => 'fixed',
                                        'options'    => array(
                                                        'fixed'      => __( 'Fixed', 't4p-core' ),
                                                        'auto'   => __( 'Auto', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'fixed = width and height will be fixed
                                                            auto = width and height will adjust to the image.', 't4p-core' )
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
                
                $picture_size  = ( ! $picture_size ) ? 'fixed' : $picture_size;

                $sub_shortcode = do_shortcode( $content );
		$items = explode( '<!--seperate-->', $sub_shortcode );
		// remove empty element
		$items         = array_filter( $items );
		foreach ( $items as $idx => $item ) {
			$items[$idx] = $item;
		}
		$sub_shortcode = implode( '', $items );
		$sub_htmls     = $sub_shortcode;
                
                //images_attr
                $class = 't4p-clients-slider clientslider-container';

                if( $picture_size == 'auto' ) {
                    $class .= ' picture-size-auto';
                }
                
                $html = "<div class='$class'><div class='es-carousel-wrapper t4p-carousel-small'><div class='es-carousel'><ul>$sub_htmls</ul></div><div class='es-nav'><span class='es-nav-prev'></span><span class='es-nav-next'></span></div></div></div>"; 
                
		return $this->element_wrapper( $html, $arr_params );
	}

}

endif;