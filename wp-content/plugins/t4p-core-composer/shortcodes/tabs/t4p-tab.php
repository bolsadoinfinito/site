<?php
/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */
if ( ! class_exists( 'T4p_tab' ) ) {
	/**
	 * Create child Tab element
	 *
	 * @package  T4P PageBuilder Shortcodes
	 * @since    1.0.0
	 */
	class T4p_tab extends T4P_Pb_Shortcode_Child {

                private $active = false;

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
						'name'  => __( 'Tab Title', 't4p-core' ),
						'id'    => 'title',
						'type'  => 'text_field',
						'class' => 'input-sm',
						'std'   => 'Title',
                                                'tooltip'  => __( 'Title of the tab', 't4p-core' ),
			),
			array(
						'name' => __( 'Tab Content', 't4p-core' ),
						'id'   => 'body',
						'role' => 'content',
						'type' => 'text_area',
                                                'container_class' => 't4p_tinymce_replace',
						'std'  => T4P_Pb_Helper_Type::lorem_text(),
                                                'tooltip'  => __( 'Add the tabs content', 't4p-core' ),
			),
			array(
						'name'      => __( 'Icon', 't4p-core' ),
						'id'        => 'icon',
						'type'      => 'icons',
						'std'       => '',
						'role'      => 'title_prepend',
						'title_prepend_type' => 'icon',
                                                'tooltip'  => __( 'Click an icon to select, click None to deselect', 't4p-core' ),
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
			$arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
			extract( $arr_params );

                        if ( ! empty( $content ) ) {
                                $content = T4P_Pb_Helper_Shortcode::remove_autop( $content );
                        }

			$inner_content = do_shortcode( $content );

                        $random_id = T4P_Pb_Utils_Common::random_string();
                        $tabid = 'tab-'.$random_id;

			return "$tabid<!--tabid-->$title<!--heading-->$icon<!--icon-->$inner_content<!--seperate-->";
                        }

	}

}
