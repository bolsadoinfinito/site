<?php
/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */

if ( ! class_exists( 'Lists' ) ) :

/**
 * Create List of items element
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Lists extends T4P_Pb_Shortcode_Parent {
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
		$this->config['name']             = __( 'List', 't4p-core' );
		$this->config['cat']              = __( 'Typography', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-list-icon';
		$this->config['has_subshortcode'] = 'list_item';
		$this->config['description']      = __( 'List of free content with icons', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(
			'admin_assets' => array(
				'lists.js',
			),
			'frontend_assets' => array(
				// Shortcode style
				'lists_frontend.css',
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
					'id'            => 'list_items',
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
					'name'    => __( 'Layout', 't4p-core' ),
					'id'      => 'icon_position',
					'type'    => 'radio_button_group',
					'std'     => T4P_Pb_Helper_Type::get_first_option( T4P_Pb_Helper_Type::get_text_align() ),
					'options' => T4P_Pb_Helper_Type::get_text_align(),
				),
				array(
					'name'       => __( 'Show Icon', 't4p-core' ),
					'id'         => 'show_icon',
					'type'       => 'radio',
					'std'        => 'yes',
					'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'has_depend' => '1',
				),
				array(
					'name' => __( 'Icon Background', 't4p-core' ),
					'type' => array(
						array(
							'id'           => 'icon_size_value',
							'type'         => 'select',
							'class'        => 'input-mini input-sm',
							'std'          => '16',
							'options'      => T4P_Pb_Helper_Type::get_icon_sizes(),
							'parent_class' => 'combo-item input-append select-append input-group input-select-append',
							'append_text'  => 'px',
						),
						array(
							'id'           => 'icon_background_type',
							'type'         => 'select',
							'class'        => 'input-sm',
							'std'          => 'circle',
							'options'      => T4P_Pb_Helper_Type::get_icon_background(),
							'parent_class' => 'combo-item',
						),
						array(
							'id'           => 'icon_background_color',
							'type'         => 'color_picker',
							'std'          => '#0088CC',
							'parent_class' => 'combo-item',
						),
					),
					'container_class' => 'combo-group',
					'dependency'      => array( 'show_icon', '=', 'yes' )
				),
				array(
					'name' => __( 'Icon Color', 't4p-core' ),
					'type' => array(
						array(
							'id'           => 'icon_c_color',
							'type'         => 'color_picker',
							'std'          => '#ffffff',
							'parent_class' => 'combo-item',
						),
					),
					'container_class' => 'combo-group',
					'dependency'      => array( 'show_icon', '=', 'yes' )
				),
				array(
					'name'       => __( 'Show Heading', 't4p-core' ),
					'id'         => 'show_heading',
					'type'       => 'radio',
					'std'        => 'yes',
					'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'has_depend' => '1',
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
		$arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
		$link = '';
		$exclude_params = array( 'tag', 'text', 'preview' );

		$arr_styles = array();
		$arr_icon_styles = array();
		$arr_icon_class = array();
		$arr_icon_class[] = '';
		if ( $arr_params['icon_position'] ) {
			$icon_position    = strtolower( $arr_params['icon_position'] );
			$arr_icon_class[] = ( $icon_position != 'inherit' ) ? "t4p-position-{$icon_position}" : '';
		}
		if (strtolower( $arr_params['icon_background_type'] ) != '' )
		$arr_icon_class[] = "t4p-shape-{$arr_params['icon_background_type']}";
		if ( $arr_params['icon_size_value'] ) {
			$arr_icon_class[] = "t4p-pb-icon-{$arr_params['icon_size_value']}";
		}

		if ($arr_params['icon_background_color'])
		$arr_icon_styles[] = 'background-color: ' . $arr_params['icon_background_color'];
		if ( $arr_params['icon_c_color'] ) {
			$arr_icon_styles[] = 'color: ' . $arr_params['icon_c_color'];
		}

		$html_elements = '';
		$sub_shortcode = T4P_Pb_Helper_Shortcode::remove_autop( $content );
		$items         = explode( '<!--seperate-->', $sub_shortcode );
		// remove empty element
		$items         = array_filter( $items );
		$initial_open  = ( ! isset( $initial_open ) || $initial_open > count( $items ) ) ? 1 : $initial_open;
		foreach ( $items as $idx => $item ) {
			$open        = ( $idx + 1 == $initial_open ) ? 'in' : '';
			$items[$idx] = $item;
		}
		$sub_shortcode = implode( '', $items );
		$sub_shortcode = implode( '', $items );
		if ( ! empty( $sub_shortcode ) ) {
			$parent_class  = implode( ' ', $arr_icon_class );
			$html_elements = "<ul class='t4p-list-icons {$parent_class}'>";
			$sub_htmls     = do_shortcode( $sub_shortcode );
			$sub_htmls     = str_replace( 't4p-sub-icons', 't4p-pb-icon-base', $sub_htmls );
			$sub_htmls     = str_replace( 't4p-styles', implode( ';', $arr_icon_styles ), $sub_htmls );
			$sub_htmls     = str_replace( 't4p-list-title', implode( ';', $arr_styles ), $sub_htmls );

			if ( $arr_params['show_icon'] == 'no' ) {
				$pattern   = '\\[(\\[?)(icon)(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
				$sub_htmls = preg_replace( "/$pattern/s", '', $sub_htmls );
			} else {
				$sub_htmls = str_replace( '[icon]', '', $sub_htmls );
				$sub_htmls = str_replace( '[/icon]', '', $sub_htmls );
			}

			if ( $arr_params['show_heading'] == 'no' ) {
				$pattern   = '\\[(\\[?)(heading)(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
				$sub_htmls = preg_replace( "/$pattern/s", '', $sub_htmls );
			} else {
				$sub_htmls = str_replace( '[heading]', '', $sub_htmls );
				$sub_htmls = str_replace( '[/heading]', '', $sub_htmls );
			}

			$html_elements .= $sub_htmls;
			$html_elements .= '</ul>';
		}

		return $this->element_wrapper( $link . $html_elements, $arr_params );
	}
}

endif;
