<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Accordian' ) ) :

/**
 * Create accordion element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Accordian extends T4P_Pb_Shortcode_Parent {

        private $accordian_counter = 1;

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
		$this->config['name']             = __( 'Accordian', 't4p-core' );
		$this->config['cat']              = __( 'Typography', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-accordion';
		$this->config['has_subshortcode'] = 'Toggle';
		$this->config['description']      = __( 'Vertically stacked and tabbed content', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(
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
					'id'            => 'accordion_items',
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
		$arr_params   = shortcode_atts( $this->config['params'], $atts );
		extract( $arr_params );

		$sub_shortcode = do_shortcode( $content );
		$items = explode( '<!--seperate-->', $sub_shortcode );
		// remove empty element
		$items         = array_filter( $items );
		foreach ( $items as $idx => $item ) {
			$items[$idx] = $item;
		}
		$sub_shortcode = implode( '', $items );
		$sub_htmls     = $sub_shortcode;

                $accordion_id = 'accordion-' . $this->accordian_counter;

		$html = "<div class='accordian t4p-accordian'><div id='{$accordion_id}' class='panel-group'>{$sub_htmls}</div></div>";

                $this->accordian_counter++;

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
