<?php
/**
 * @version    1.0.0
 * @package    Theme4Press PageBuilder
 * @author     Theme4Press 
 * 
 */
if ( ! class_exists( 'Item_table' ) ) {

	/**
	 * Create Table child element
	 *
	 * @package  T4P PageBuilder Shortcodes
	 * @since    1.0.0
	 */
	class Item_table extends T4P_Pb_Shortcode_Child {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		public function element_config() {
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['exception'] = array(
				'item_text'        => '',
				'data-modal-title' => __( 'Table Item', 't4p-core' ),
				'item_wrapper'     => 'div',
				'action_btn'       => 'edit',

				'admin_assets' => array(
					// Shortcode initialization
					'item_table.js',
				),
			);
                        $this->config['edit_using_ajax'] = true;

		}

		/**
		 * DEFINE setting options of shortcode
		 */
		public function element_items() {
			$this->items = array(
				'Notab' => array(
					array(
						'name' => __( 'Width', 't4p-core' ),
						'type' => array(
							array(
								'id'           => 'width_value',
								'type'         => 'text_number',
								'std'          => '',
								'class'        => 'input-mini',
								'validate'     => 'number',
								'parent_class' => 'combo-item merge-data',
							),
							array(
								'id'           => 'width_type',
								'type'         => 'select',
								'class'        => 'input-mini',
								'options'      => array( 'percentage' => '%', 'px' => 'px' ),
								'std'          => 'percentage',
								'parent_class' => 'combo-item merge-data',
							),
						),
						'container_class' => 'combo-group',
					),
					array(
						'name'            => __( 'Tag Name', 't4p-core' ),
						'id'              => 'tagname',
						'type'            => 'text_field',
						'std'             => 'td',
						'type_input'      => 'hidden',
						'container_class' => 'hidden',
                        'tooltip' => '',
					),
					array(
						'name'     => __( 'Row Span', 't4p-core' ),
						'id'       => 'rowspan',
						'type'     => 'text_number',
						'std'      => '1',
						'class'    => 'input-mini positive-val',
						'validate' => 'number',
						'role'     => 'extract',
                        'tooltip' => __( 'Enable extending over multiple rows', 't4p-core' ),
					),
					array(
						'name'     => __( 'Column Span', 't4p-core' ),
						'id'       => 'colspan',
						'type'     => 'text_number',
						'std'      => '1',
						'class'    => 'input-mini positive-val',
						'validate' => 'number',
						'role'     => 'extract',
                        'tooltip' => __( 'Enable extending over multiple columns', 't4p-core' ),
					),
					array(
						'name'    => __( 'Row Style', 't4p-core' ),
						'id'      => 'rowstyle',
						'type'    => 'select',
						'class'   => 'input-sm',
						'std'     => T4P_Pb_Helper_Type::get_first_option( T4P_Pb_Helper_Type::get_table_row_color() ),
						'options' => T4P_Pb_Helper_Type::get_table_row_color(),
					),
					array(
						'name'   => __( 'Content', 't4p-core' ),
						'id'     => 'cell_content',
						'role'   => 'content',
						'role_2' => 'title',
						'type'   => 'tiny_mce',
						'std'    => '',
                        'tooltip' => __( 'Table content', 't4p-core' ),
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
			$rowstyle = ( ! $rowstyle || strtolower( $rowstyle ) == 'default' ) ? '' : $rowstyle;
			if ( in_array( $tagname, array( 'tr_start', 'tr_end' ) ) ) {
				return "$tagname<!--seperate-->";
			}
			
			$width_type = $width_type == 'percentage' ? '%' : $width_type;
			$width = ! empty( $width_value ) ? "width='{$width_value}{$width_type}'" : '';
			$empty = empty( $content ) ? '<!--empty-->' : '';
			return "<CELL_WRAPPER class='$rowstyle' rowspan='$rowspan' colspan='$colspan' $width>" . T4P_Pb_Helper_Shortcode::remove_autop( $content ) . "</CELL_WRAPPER>$empty<!--seperate-->";
		}

	}

}
