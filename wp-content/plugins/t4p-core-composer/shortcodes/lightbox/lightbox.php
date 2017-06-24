<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Lightbox' ) ) :

/**
 * Create Lightbox element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Lightbox extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Lightbox',	't4p-core' );
		$this->config['cat']         = __( 'Media', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-lightbox';
		$this->config['description'] = __( 'Add a lightbox', 't4p-core' );

		// Define exception for this shortcode
                $this->config['exception'] = array(
                        'admin_assets' => array(
                                // Shortcode initialization
                                't4p-pb-image-js',
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
                                            'name'    => __( 'Full Image', 't4p-core' ),
                                            'id'      => 'src',
                                            'type'    => 'select_media',
                                            'std'     => '',
                                            'class'   => 'jsn-input-large-fluid',
                                            'tooltip' => __( 'Upload an image that will show up in the lightbox.', 't4p-core' )
                                    ),
                                    array(
                                            'name'    => __( 'Thumbnail Image', 't4p-core' ),
                                            'id'      => 'image',
                                            'type'    => 'select_media',
                                            'std'     => '',
                                            'class'   => 'jsn-input-large-fluid',
                                            'tooltip' => __( 'Clicking this image will show lightbox.', 't4p-core' )
                                    ),
                                    array(
                                            'name'    => __( 'Image Size', 't4p-core' ),
                                            'id'      => 'image_size',
                                            'type'    => 'large_image',
                                            'std'     => 'thumbnail',
                                            'tooltip' => __( 'Set image size', 't4p-core' )
                                    ),
                                    array(
                                        'name'  => __( 'Alt Text', 't4p-core' ),
                                        'id'    => 'caption',
                                        'type'  => 'text_field',
                                        'class' => 'input-sm',
                                        'tooltip' => __( 'The alt attribute provides alternative information if an image cannot be viewed.', 't4p-core' )
                                    ),
                                    array(
                                        'name'  => __( 'Lightbox Description', 't4p-core' ),
                                        'id'    => 'title',
                                        'type'  => 'text_field',
                                        'class' => 'input-sm',
                                        'tooltip' => __( 'This will show up in the lightbox as a description below the image.', 't4p-core' )
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
		$arr_params = shortcode_atts( $this->config['params'], $atts );
		extract( $arr_params );
                $src = ( ! $src ) ? '' : $src;
                $image = ( ! $image ) ? '' : $image;
                $caption = ( ! $caption ) ? '' : $caption;
                $title = ( ! $title ) ? '' : $title;

                $img_html = '';
                if ( $image ) {
                        $image_id       = T4P_Pb_Helper_Functions::get_image_id( $image );
                        $attachment     = wp_prepare_attachment_for_js( $image_id );
                        $image     = ( ! empty( $attachment['sizes'][$image_size]['url'] ) ) ? $attachment['sizes'][$image_size]['url'] : $image;			

                        $width = $attachment['sizes'][$image_size]['width'];
                        $height = $attachment['sizes'][$image_size]['height'];
                        
                        $img_html = "<img src='$image' alt='$caption' width='$width' height='$height' />";
                }
                
                $html = "<a title='$title' href='$src' rel='prettyPhoto'>$img_html</a>";

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
