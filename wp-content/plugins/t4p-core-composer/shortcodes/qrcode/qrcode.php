<?php
/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */

if ( ! class_exists( 'QRCode' ) ) :

/**
 * Create QR Code element
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class QRCode extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'QR Code', 't4p-core' );
		$this->config['cat']         = __( 'General', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-qr-code';
		$this->config['description'] = __( 'QR code with data setting', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(
			'default_content'  => __( 'QR Code', 't4p-core' ),
			'data-modal-title' => __( 'QR Code', 't4p-core' ),

			'admin_assets' => array(
		// Shortcode initialization
				'qrcode.js',
		),

			'frontend_assets' => array(
		// Bootstrap 3
				't4p-pb-bootstrap-css',
				't4p-pb-bootstrap-js',
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
					'name'          => __( 'Data', 't4p-core' ),
					'id'            => 'qr_content',
					'type'          => 'text_area',
					'class'         => 'input-sm',
					'std'           => 'http://www.theme4press.com',
					'tooltip'       => __( 'Here you can input names, urls, phone numbers, email addresses or plain text', 't4p-core' ),
					'exclude_quote' => '1',
				),
				array(
					'name'    => __( 'Image ALT Text', 't4p-core' ),
					'id'      => 'qr_alt',
					'type'    => 'text_field',
					'class'   => 'input-sm',
					'std'     => __( 'Wordpress themes from www.theme4press.com', 't4p-core' ),
					'tooltip' => __( 'Text tooltip appears when QR box is hovered through', 't4p-core' ),
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => __( 'Container Style', 't4p-core' ),
					'id'      => 'qr_container_style',
					'type'    => 'radio',
					//'class'   => 'input-sm',
					'std'     => T4P_Pb_Helper_Type::get_first_option( T4P_Pb_Helper_Type::get_qr_container_style() ),
					'options' => T4P_Pb_Helper_Type::get_qr_container_style(),
				),
				array(
					'name'    => __( 'Alignment', 't4p-core' ),
					'id'      => 'qr_alignment',
					'class'   => 'input-sm',
					'type'    => 'radio_button_group',
					'std'     => T4P_Pb_Helper_Type::get_first_option( T4P_Pb_Helper_Type::get_text_align() ),
					'options' => T4P_Pb_Helper_Type::get_text_align(),
				),
				array(
					'name'         => __( 'QR Code Size', 't4p-core' ),
					'id'           => 'qrcode_sizes',
					'type'         => 'select',
					'class'        => 'input-mini-m input-sm t4p-select2-editor',
					'std'          => '150',
					'options'      => array(
						'150' => __( '150', 't4p-core' ),
						'200' => __( '200', 't4p-core' ),
						'250' => __( '250', 't4p-core' ),
						'300' => __( '300', 't4p-core' ),
						'350' => __( '350', 't4p-core' ),
					),
					'parent_class'    => 'combo-item input-append select-append input-group input-select-append t4p-input-append',
					'append_text'     => 'px',
					'container_class' => 'combo-group',
					'disable_select2' => true
				),				
				T4P_Pb_Helper_Type::get_animation_type(),
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
		$html_element = '';
		$arr_params   = ( shortcode_atts( $this->config['params'], $atts ) );
		extract( $arr_params );
		$qrcode_sizes  = ( $qrcode_sizes ) ? ( int ) $qrcode_sizes : 0;
		$cls_alignment = '';
		if ( strtolower( $arr_params['qr_alignment'] ) != 'inherit' ) {
			if ( strtolower( $arr_params['qr_alignment'] ) == 'left' ) {
				$cls_alignment = 'pull-left';
			}
			if ( strtolower( $arr_params['qr_alignment'] ) == 'right' ) {
				$cls_alignment = 'pull-right';
			}
			if ( strtolower( $arr_params['qr_alignment'] ) == 'center' ) {
				$cls_alignment = 'text-center';
			}
		}
		$class_img    = ( $qr_container_style != 'no-styling' ) ? "class='{$qr_container_style}'" : '';
		$qr_content   = str_replace( '<t4p_quote>', '"', $qr_content );
		$image        = 'https://chart.googleapis.com/chart?chs=' . $qrcode_sizes . 'x' . $qrcode_sizes . '&cht=qr&chld=H|1&chl=' . $qr_content;
		$qr_alt       = ( ! empty( $qr_alt ) ) ? "alt='{$qr_alt}'" : '';
		$html_element = "<img src='{$image}' {$qr_alt} width='{$qrcode_sizes}' height='{$qrcode_sizes}' $class_img />";
		if ( $cls_alignment != '' ) {
			$html_element = "<div>{$html_element}</div>";
		}

		return $this->element_wrapper( $html_element, $arr_params, $cls_alignment );
	}
}

endif;
