<?php
/**
 * @version    1.0.0
 * @package    Theme4Press PageBuilder
 * @author     Theme4Press
 * 
 */

if ( ! class_exists( 'Testimonials' ) ) :

/**
 * Testimonial element for T4P PageBuilder.
 *
 * @since  1.0.0
 */
class Testimonials extends T4P_Pb_Shortcode_Parent {
        
        private $testimonials_counter = 1;
        
	/**
	 * Constructor
	 *
	 * @return  void
	 */
	public function __construct() {
		parent::__construct();
                
                add_filter( 't4p_attr_testimonials-shortcode', array( $this, 'attr' ) );
		add_filter( 't4p_attr_testimonials-shortcode-testimonials', array( $this, 'testimonials_attr' ) );
	}

	/**
	 * Configure shortcode.
	 *
	 * @return  void
	 */
	public function element_config() {
		$this->config['shortcode']        = strtolower( __CLASS__ );
		$this->config['name']             = __( 'Testimonial', 't4p-core' );
		$this->config['cat']              = __( 'General', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-testimonial';
		$this->config['has_subshortcode'] = 'Testimonial';
		$this->config['description']      = __( 'Testimonial with flexible settings', 't4p-core' );

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
					'id'            => 'testimonial_items',
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
                                        'name' => __( 'Background Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'backgroundcolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the background color. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Text Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'textcolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the text color. Leave blank for theme option selection.', 't4p-core' )
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
                global $evl_options, $smof_data;
		$arr_params     = shortcode_atts( $this->config['params'], $atts );
		extract( $arr_params );

                $backgroundcolor = ( ! $backgroundcolor ) ? strtolower( $smof_data['testimonial_bg_color'] ) . $evl_options['evl_shortcode_testimonial_bg_color'] : $backgroundcolor;  
		$textcolor = ( ! $textcolor ) ? strtolower( $smof_data['testimonial_text_color'] ) . $evl_options['evl_shortcode_testimonial_text_color'] : $textcolor;

                $sub_shortcode = T4P_Pb_Helper_Shortcode::remove_autop( $content, false );
		$items = explode( '<!--seperate-->', $sub_shortcode );
		// remove empty element
		$items         = array_filter( $items );
		$initial_open  = ( ! isset($initial_open ) || $initial_open > count( $items ) ) ? 1 : $initial_open;
		foreach ( $items as $idx => $item ) {
			$open        = ( $idx + 1 == $initial_open ) ? 'in' : '';
			$items[$idx] = $item;
		}
		$sub_shortcode = implode( '', $items );
		$sub_htmls     = $sub_shortcode;
                
		$styles = "<style type='text/css'>
		.t4p-testimonials.t4p-testimonials-{$this->testimonials_counter} .author:after{border-top-color:{$backgroundcolor} !important;}
                .t4p-testimonials.t4p-testimonials-{$this->testimonials_counter}  blockquote { background-color:{$backgroundcolor}; color:{$textcolor}; }
		</style>
		";

		$html = "<div class='t4p-testimonials t4p-testimonials-$this->testimonials_counter'>$styles<div class='reviews'>$sub_htmls</div></div>";
		$this->testimonials_counter++;

		return $this->element_wrapper( $html, $arr_params );
	}

}

endif;
