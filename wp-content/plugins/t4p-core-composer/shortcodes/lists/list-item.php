<?php
/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */
if ( ! class_exists( 'List_Item' ) ) {

	class List_Item extends T4P_Pb_Shortcode_Child {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		public function element_config() {
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['exception'] = array(
                                'admin_assets' => array(
                                        't4p-pb-joomlashine-iconselector-js',
                                ),
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
						'name'    => __( 'Heading', 't4p-core' ),
						'id'      => 'heading',
						'type'    => 'text_field',
						'class'   => 'jsn-input-xxlarge-fluid',
						'role'    => 'title',
						'std'     => __( T4P_Pb_Utils_Placeholder::add_placeholder( 'List Item %s', 'index' ), 't4p-core' ),
			),
			array(
						'name'    => __( 'Body', 't4p-core' ),
						'id'      => 'body',
						'role'    => 'content',
						'type'    => 'text_area',
						'container_class' => 't4p_tinymce_replace',
						'std'     => T4P_Pb_Helper_Type::lorem_text(),
			),
			array(
						'name'      => __( 'Icon', 't4p-core' ),
						'id'        => 'icon',
						'type'      => 'icons',
						'std'       => 'fa-check-square-o',
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
			T4P_Pb_Helper_Functions::heading_icon( $heading, $icon, true );
			return "
			<li>
				[icon]<div class='t4p-sub-icons' style='t4p-styles'>
					<i class='fa $icon'></i>
				</div>[/icon]
				<div class='t4p-list-content-wrap'>
					[heading]<h4 style='t4p-list-title'>$heading</h4>[/heading]
					<p>$content</p>
				</div>
			</li><!--seperate-->";
		}

	}

}
