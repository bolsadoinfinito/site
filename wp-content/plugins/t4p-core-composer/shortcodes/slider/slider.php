<?php

/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */

if ( ! class_exists( 'Slider' ) ) :

/**
 * Create Slider element
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Slider extends T4P_Pb_Shortcode_Parent {
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
		$this->config['name']             = __( 'Slider', 't4p-core' );
		$this->config['cat']              = __( 'General', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-carousel';
		$this->config['has_subshortcode'] = 'Slide';
		$this->config['description']      = __( 'Add a slider with image and video content', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(
                    	'admin_assets' => array(
				't4p-pb-jquery.flexslider',
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
					'id'            => 'slider_items',
					'type'          => 'group',
					'shortcode'     => ucfirst( __CLASS__ ),
					'sub_item_type' => $this->config['has_subshortcode'],
					'sub_items'     => array(
						array( 'std' => '' ),
					),
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'            => __( 'Image Size (Width/Height)', 't4p-core' ),
					'container_class' => 'combo-group',
					'type'            => array(
                                                array(
							'id'            => 'width',
							'type'          => 'text_append',
							'type_input'    => 'text_field',
							'class'         => 'input-mini',
							'std'           => '100%',
							'append_before' => 'Width',
							'parent_class'  => 'input-group-inline',
						),
						array(
							'id'            => 'height',
							'type'          => 'text_append',
							'type_input'    => 'text_field',
							'class'         => 'input-mini',
							'std'           => '100%',
							'append_before' => 'Height',
							'parent_class'  => 'input-group-inline',
						),
					),
					'tooltip' => __( 'Width and Height in percentage (%) or pixels (px)', 't4p-core' ),
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
                global $evl_options;
                $arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
                extract( $arr_params );
                
                $width  = ( ! $width ) ? '100%' : $width;
                $height = ( ! $height ) ? '100%' : $height;
                
                $sub_shortcode = do_shortcode( $content );
		$items = explode( '<!--seperate-->', $sub_shortcode );
                // remove empty element
		$items         = array_filter( $items );
		foreach ( $items as $idx => $item ) {
			$items[$idx] = $item;
		}
		$sub_shortcode = implode( '', $items );
		$sub_htmls     = $sub_shortcode;
                
                $class = 't4p-slider-sc flexslider';
		$style = sprintf( 'max-width:%s;height:%s;', $width, $height );

		$html = "<div class='$class' style='$style' ><ul class='slides'>$sub_htmls</ul></div>";

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;

