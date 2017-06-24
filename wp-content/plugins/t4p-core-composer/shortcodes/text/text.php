<?php
/**
 * 
 * @version    1.0.0
 * @package    Theme4Press PageBuilder
 * @author     Theme4Press
 * 
 * 
 */

if ( ! class_exists( 'Text' ) ) :

/**
 * Create Text element
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Text extends T4P_Pb_Shortcode_Element {
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
	function element_config() {
		$this->config['shortcode']   = strtolower( __CLASS__ );
		$this->config['name']        = __( 'Text', 't4p-core' );
		$this->config['cat']         = __( 'Typography', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-text';
		$this->config['description'] = __( 'Simple text', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(
			'default_content' => __( 'Text', 't4p-core' ),

			'admin_assets' => array(
				't4p-pb-text-js',
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
	function element_items() {
		$this->items = array(
			'content' => array(

				array(
					'name' => __( 'Parent Element Text', 't4p-core' ),
					'desc' => __( 'Enter some content for this textblock', 't4p-core' ),
					'id'   => 'text',
					'type' => 'text_area',
					'role' => 'content',
					'std'  => T4P_Pb_Helper_Type::lorem_text(),
					'rows' => 15,
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'               => __( 'Margin', 't4p-core' ),
					'container_class'    => 'combo-group',
					'id'                 => 'text_margin',
					'type'               => 'margin',
					'extended_ids'       => array( 'text_margin_top', 'text_margin_right', 'text_margin_bottom', 'text_margin_left' ),
					'text_margin_top'    => array( 'std' => '0' ),
					'text_margin_bottom' => array( 'std' => '0' ),
					'tooltip'            => __( 'External spacing with other elements', 't4p-core' )
				),
				array(
					'name'       => __( 'Enable Dropcap', 't4p-core' ),
					'id'         => 'enable_dropcap',
					'type'       => 'radio',
					'std'        => 'no',
					'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'    => __( 'The first letter of paragraph that is enlarged', 't4p-core' ),
					'has_depend' => '1',
				),
				array(
					'name' => __( 'Font Attributes', 't4p-core' ),
					'type' => array(
						array(
							'id'           => 'dropcap_font_size',
							'type'         => 'text_append',
							'type_input'   => 'number',
							'class'        => 'input-mini',
							'std'          => '64',
							'append'       => 'px',
							'validate'     => 'number',
							'parent_class' => 'combo-item input-mini-inline',
						),
						array(
							'id'           => 'dropcap_font_style',
							'type'         => 'select',
							'class'        => 'input-medium t4p-mini-input input-sm',
							'std'          => 'bold',
							'options'      => T4P_Pb_Helper_Type::get_font_styles(),
							'parent_class' => 'combo-item',
						),
						array(
							'id'           => 'dropcap_font_color',
							'type'         => 'color_picker',
							'std'          => '#000000',
							'parent_class' => 'combo-item',
						),
					),
					'dependency'      => array( 'enable_dropcap', '=', 'yes' ),
					'tooltip'         => __( 'Set Font Attribute', 't4p-core' ),
					'container_class' => 'combo-group',
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
	function element_shortcode_full( $atts = null, $content = null ) {
		$arr_params = shortcode_atts( $this->config['params'], $atts );
		extract( $arr_params );

		$random_id = T4P_Pb_Utils_Common::random_string();
		$html_element = '';
		if ( ! empty( $content ) ) {
			$content = T4P_Pb_Helper_Shortcode::remove_autop( $content );
		}
		if ( isset( $enable_dropcap ) && $enable_dropcap == 'yes' ) {
			if ( $content ) {
				$styles = array();

				if ( intval( $dropcap_font_size ) > 0 ) {
					$styles[] = 'font-size:' . intval( $dropcap_font_size ) . 'px';
					$styles[] = 'line-height:' . intval( $dropcap_font_size ) . 'px';
				}
				switch ( $dropcap_font_style ) {
					case 'bold':
						$styles[] = 'font-weight:700';
						break;
					case 'italic':
						$styles[] = 'font-style:italic';
						break;
					case 'normal':
						$styles[] = 'font-weight:normal';
						break;
				}

				if ( strpos( $dropcap_font_color, '#' ) !== false ) {
					$styles[] = 'color:' . $dropcap_font_color;
				}

				if ( count( $styles ) ) {
					$html_element .= '<style type="text/css">';
					$html_element .= sprintf( '%1$s .pb_dropcap:first-letter, %1$s .pb_dropcap p:first-letter { float:left;', "#$random_id" );
					$html_element .= implode( ';', $styles );
					$html_element .= '}';
					$html_element .= '</style>';
				}

				$html_element .= "<div class='pb_dropcap'>{$content}</div>";
			}
		} else {
			$html_element .= $content;
		}
		$html  = sprintf( '<div class="t4p_text" id="%s">', $random_id );
		$html .= $html_element;
		$html .= '</div>';

		// Process margins
		if ( isset( $arr_params['text_margin_top'] ) )
			$arr_params['div_margin_top']    = $arr_params['text_margin_top'];
		if ( isset( $arr_params['text_margin_bottom'] ) )
			$arr_params['div_margin_bottom'] = $arr_params['text_margin_bottom'];
		if ( isset( $arr_params['text_margin_right'] ) )
			$arr_params['div_margin_right']  = $arr_params['text_margin_right'];
		if ( isset( $arr_params['text_margin_left'] ) )
			$arr_params['div_margin_left']   = $arr_params['text_margin_left'];

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
