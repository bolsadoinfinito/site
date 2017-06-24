<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Carousel' ) ) :

class Carousel extends T4P_Pb_Shortcode_Parent {
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
		$this->config['name']             = __( 'Carousel', 't4p-core' );
		$this->config['cat']              = __( 'General', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-carousel';
		$this->config['has_subshortcode'] = str_replace( 'T4P_', '', __CLASS__ ).'_slide';
		$this->config['description']      = __( 'Rotating circular content with text and images', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(
			'admin_assets' => array(
				't4p-pb-joomlashine-iconselector-js',
			),
			'frontend_assets' => array(
					// Bootstrap 3
					't4p-pb-bootstrap-css',
					't4p-pb-bootstrap-js',
					// Font IcoMoon
					't4p-pb-font-icomoon-css',
					// Shortcode style
					'carousel_frontend.css',
					'carousel_frontend.js'
				),
			);

		// Use Ajax to speed up element settings modal loading speed
		$this->config['edit_using_ajax'] = true;

		// Edit inline supplement
		add_action( 't4p_pb_modal_footer', array( 'T4P_Pb_Objects_Modal', '_modal_footer' ) );
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
                                        'id'            => 'carousel_items',
                                        'type'          => 'group',
                                        'shortcode'     => ucfirst( __CLASS__ ),
                                        'sub_item_type' => $this->config['has_subshortcode'],
                                        'sub_items'     => array(
                                                                    array('std' => ''),
                                                                    array('std' => ''),
                                        ),
                                ),
                        ),
			'styling' => array(
				array(
							'type' => 'preview',
				),
				array(
							'name'    => __( 'Alignment', 't4p-core' ),
							'id'      => 'align',
							'class'   => 'input-sm',
							'std'     => 'center',
							'type'    => 'radio_button_group',
							'options' => T4P_Pb_Helper_Type::get_text_align(),
				),
//				array(
//							'name'                 => __( 'Dimension', 't4p-core' ),
//							'container_class'      => 'combo-group dimension-inline',
//							'id'                   => 'dimension',
//							'type'                 => 'dimension',
//							'extended_ids'         => array( 'dimension_width', 'dimension_height', 'dimension_width_unit' ),
//							'dimension_width'      => array( 'std' => '' ),
//							'dimension_height'     => array( 'std' => '' ),
//							'dimension_width_unit' => array(
//								'options' => array( 'px' => 'px', '%' => '%' ),
//								'std'     => 'px',
//				),
//							'tooltip' => __( 'Set width and height of element', 't4p-core' ),
//				),
                                array(
					'name'            => __( 'Dimension', 't4p-core' ),
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
					'tooltip' => __( 'Set width and height of element', 't4p-core' ),
				),
				array(
							'name'    => __( 'Show Indicator', 't4p-core' ),
							'id'      => 'show_indicator',
							'type'    => 'radio',
							'std'     => 'yes',
							'options' => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
							'tooltip' => __( 'Round Pagination buttons', 't4p-core' ),
				),
				array(
							'name'    => __( 'Show Arrows', 't4p-core' ),
							'id'      => 'show_arrows',
							'type'    => 'radio',
							'std'     => 'yes',
							'options' => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
							'tooltip' => __( 'Previous & Next buttons', 't4p-core' ),
				),
				array(
							'name'       => __( 'Automatic Cycling', 't4p-core' ),
							'id'         => 'automatic_cycling',
							'type'       => 'radio',
							'std'        => 'no',
							'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
							'has_depend' => '1',
							'tooltip' => __( 'Automatically run carousel', 't4p-core' ),
				),
				array(
							'name' => __( 'Cycling Interval', 't4p-core' ),
							'type' => array(
				array(
									'id'         => 'cycling_interval',
									'type'       => 'text_append',
									'type_input' => 'number',
									'class'      => 'input-mini',
									'std'        => '5',
									'append'     => 'second(s)',
									'validate'   => 'number',
				),
				),
							'dependency' => array('automatic_cycling', '=', 'yes'),
							'tooltip' => __( 'Set interval for each cycling', 't4p-core' ),
				),
				array(
							'name'       => __( 'Pause on mouse over', 't4p-core' ),
							'id'         => 'pause_mouseover',
							'type'       => 'radio',
							'std'        => 'yes',
							'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
							'dependency' => array( 'automatic_cycling', '=', 'yes' ),
							'tooltip' => __( 'Pause cycling on mouse over', 't4p-core' ),
				),				
				T4P_Pb_Helper_Type::get_animation_type(),
                                T4P_Pb_Helper_Type::get_animations_direction(),
				T4P_Pb_Helper_Type::get_animation_speeds(),
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
		$arr_params    = shortcode_atts( $this->config['params'], $atts );
		extract( $arr_params );
		$random_id     = T4P_Pb_Utils_Common::random_string();
		$carousel_id   = "carousel_$random_id";
                
                $width  = ( ! $width ) ? '100%' : $width;
                $height = ( ! $height ) ? '100%' : $height;

		$interval_time = ! empty( $cycling_interval ) ? intval( $cycling_interval ) * 1000 : 5000;
		$interval      = ( $automatic_cycling == 'yes' ) ? $interval_time : 'false';
		$pause         = ( $pause_mouseover == 'yes' ) ? 'pause : "hover"' : '';
		$script        = "<script type='text/javascript'>(function ($){ $( document ).ready(function(){if( $( '#$carousel_id' ).length ){ $( '#$carousel_id' ).carousel( {interval: $interval,$pause} );}});} )( jQuery )</script>";

		$styles        = array();
		if ( ! empty( $width ) )
		$styles[] = "width : {$width};";
		if ( ! empty( $height ) )
		$styles[] = "height : {$height};";

		if ( in_array( $align, array( 'left', 'right', 'inherit') ) ) {
			$styles[] = "float : $align;";
		} else if ( $align == 'center' )
		$styles[] = 'margin : 0 auto;';

		$styles = trim( implode( ' ', $styles ) );
		$styles = ! empty( $styles ) ? "style='$styles'" : '';


		$carousel_indicators   = array();
		$carousel_indicators[] = '<ol class="carousel-indicators">';

		$sub_shortcode         = do_shortcode( $content );
		$items                 = explode( '<!--seperate-->', $sub_shortcode );
		$items                 = array_filter( $items );
		$initial_open          = isset( $initial_open ) ? ( ( $initial_open > count( $items ) ) ? 1 : $initial_open ) : 1;
		foreach ( $items as $idx => $item ) {
			$active                = ($idx + 1 == $initial_open) ? 'active' : '';
			$item                  = str_replace( '{active}', $active, $item );
			$item                  = str_replace( '{WIDTH}', ( ! empty( $width ) ) ? ( string ) $width : '', $item );
			$item                  = str_replace( '{HEIGHT}', ( ! empty( $height ) ) ? ( string ) $height : '', $item );
			$items[$idx]           = $item;
			$active_li             = ($idx + 1 == $initial_open) ? "class='active'" : '';
			$carousel_indicators[] = "<li $active_li></li>";
		}
		$carousel_content      = "<div class='carousel-inner'>" . implode( '', $items ) . '</div>';

		$carousel_indicators[] = '</ol>';
		$carousel_indicators   = implode( '', $carousel_indicators );

		if ( $show_indicator == 'no' )
		$carousel_indicators = '';

		$carousel_navigator = '';
		if ($show_arrows == 'yes')
		$carousel_navigator = "<a class='left carousel-control'><span class='icon-arrow-left'></span></a><a class='right carousel-control'><span class='icon-arrow-right'></span></a>";

		$html = "<div class='carousel slide' $styles id='$carousel_id'>$carousel_indicators $carousel_content $carousel_navigator</div>";

		return $this->element_wrapper( $html . $script, $arr_params );
	}
}

endif;
