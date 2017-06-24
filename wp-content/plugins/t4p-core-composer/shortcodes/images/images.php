<?php

/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */

if ( ! class_exists( 'Images' ) ) :
/**
 * Create Images element
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Images extends T4P_Pb_Shortcode_Parent {
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
		$this->config['name']             = __( 'Image Carousel', 't4p-core' );
		$this->config['cat']              = __( 'Media', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-image-carousel';
		$this->config['has_subshortcode'] = 'Image';
		$this->config['description']      = __( 'Add images in carousel slider', 't4p-core' );

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
					'id'            => 'image_items',
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
                                array(
                                        'name'       => __( 'Image lightbox ', 't4p-core' ),
                                        'id'         => 'lightbox',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => 'no',
                                        'options'    => array(
                                                        'yes'      => __( 'Yes', 't4p-core' ),
                                                        'no'   => __( 'No', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'Show image in lightbox.', 't4p-core' )
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
                $lightbox  = ( ! $lightbox ) ? 'no' : $lightbox;

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
                $class = 'images-carousel-container t4p-image-carousel';

                if( $lightbox == 'yes' ) {
                    $class .= ' lightbox-enabled';
                }

                if( $picture_size == 'auto' ) {
                    $class .= ' picture-size-auto';
                }
                
                $html = "<div class='$class'><div class='es-carousel-wrapper t4p-carousel-small'><div class='es-carousel'><ul>$sub_htmls</ul></div><div class='es-nav'><span class='es-nav-prev'></span><span class='es-nav-next'></span></div></div></div>"; 
                
		return $this->element_wrapper( $html, $arr_params );
	}

}

endif;