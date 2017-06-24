<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */
if ( ! class_exists( 'Carousel_slide' ) ) {

	/**
	 * Create Carousel element
	 *
	 * @package  T4P PageBuilder Shortcodes
	 * @since    1.0.0
	 */
	class Carousel_slide extends T4P_Pb_Shortcode_Child {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		public function element_config() {
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['exception'] = array(
				'data-modal-title' => __( 'Carousel Item', 't4p-core' ),
			);

			// Inline edit for sub item
			$this->config['edit_inline'] = true;
		}

		/**
		 * DEFINE setting options of shortcode
		 */
		public function element_items() {
			$this->items = array(
				'Notab' => array(
			array(
						'name'    => __( 'Image File', 't4p-core' ),
						'id'      => 'image_file',
						'type'    => 'select_media',
						'std'     => '',
						'class'   => 'jsn-input-large-fluid',
			),
			array(
						'name'  => __( 'Heading', 't4p-core' ),
						'id'    => 'heading',
						'type'  => 'text_field',
						'class' => 'input-sm',
						'role'  => 'title',
						'std'   => 'Slide Title',
			),
                        array(
                                    'name'  => __( 'Alt Description', 't4p-core' ),
                                    'id'    => 'alt',
                                    'type'  => 'text_field',
                                    'class' => 'input-sm',
                                    'std'   => '',
                        ),
			array(
						'name' => __( 'Body', 't4p-core' ),
						'id'   => 'body',
						'role' => 'content',
						'type' => 'text_area',
						'container_class' => 't4p_tinymce_replace',
						'std'  => T4P_Pb_Helper_Type::lorem_text(12) . '<a href="#"> link</a>',
			),
			array(
						'name'      => __( 'Icon', 't4p-core' ),
						'id'        => 'icon',
						'type'      => 'icons',
						'std'       => '',
						'role'      => 'title_prepend',
						'title_prepend_type' => 'icon',
			),
			)
			);
		}

		/**
		 * DEFINE shortcode content
		 *
		 * @param type $atts
		 * @param type $content
		 */
		public function element_shortcode_full( $atts = null, $content = null ) {
			extract( shortcode_atts( $this->config['params'], $atts ) );
			$content_class = ! empty( $image_file ) ? 'carousel-caption' : 'carousel-content';
			$img           = ! empty( $image_file ) ? "<img width='{WIDTH}' height='{HEIGHT}' src='$image_file' alt='$alt' style='height : {HEIGHT}px;'>" : '';

			// remove image shortcode in content
			$content = T4P_Pb_Helper_Shortcode::remove_t4p_shortcodes( $content, 't4p_image' );

			$inner_content = T4P_Pb_Helper_Shortcode::remove_autop( $content );
			T4P_Pb_Helper_Functions::heading_icon( $heading, $icon, true );
			$heading       = trim( $heading );
			$inner_content = trim( $inner_content );

			if ( empty( $heading ) && empty( $inner_content ) ) {
				$html_content = "";
			} else {
				$html_content = "<div class='$content_class'>";
				$html_content .= ( ! empty( $heading ) ) ? "<h4><i class='fa $icon'></i>$heading</h4>" : '';
				$html_content .= ( ! empty( $inner_content ) ) ? "<p>{$inner_content}</p>" : '';
				$html_content .= "</div>";
			}

			return "<div class='{active} item'>{$img}{$html_content}</div><!--seperate-->";
		}

	}

}
