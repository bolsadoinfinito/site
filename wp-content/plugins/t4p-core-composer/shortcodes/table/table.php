<?php
/**
 * @version   1.0.0
 * @package   Theme4Press PageBuilder
 * @author     Theme4Press
 * 
 * 
 */

if ( ! class_exists( 'Table' ) ) :

/**
 * Create Table element
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Table extends T4P_Pb_Shortcode_Parent {
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
		$this->config['name']             = __( 'Table', 't4p-core' );
		$this->config['cat']              = __( 'Typography', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-table';
		$this->config['has_subshortcode'] = 'Item_table';
		$this->config['description']      = __( 'Simple table with flexible setting', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(
			'admin_assets' => array(
				// Shortcode initialization
				'table.js',
			),
		);

		// Do not use Ajax to load element settings modal because this element has sub-item
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
					'name'          => __( 'Table Content', 't4p-core' ),
					'id'            => 'table_',
					'type'          => 'table',
					'shortcode'     => ucfirst( __CLASS__ ),
					'sub_item_type' => $this->config['has_subshortcode'],
					'sub_items'     => array(
						array( 'std' => "[item_table tagname='tr_start' ][/item_table]" ),
						array( 'std' => '' ),
						array( 'std' => '' ),
						array( 'std' => "[item_table tagname='tr_end' ][/item_table]" ),
						array( 'std' => "[item_table tagname='tr_start' ][/item_table]" ),
						array( 'std' => '' ),
						array( 'std' => '' ),
						array( 'std' => "[item_table tagname='tr_end' ][/item_table]" ),
					),
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'    => __( 'Style', 't4p-core' ),
					'id'      => 'tb_style',
					'type'    => 'select',
					'class'   => 'input-sm',
					'options' => array( 'table-default' => __( 'Default', 't4p-core' ), 'table-striped' => __( 'Striped', 't4p-core' ), 'table-bordered' => __( 'Bordered', 't4p-core' ), 'table-hover' => __( 'Hover', 't4p-core' ) ),
					'std'     => 'table-default',
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
		$arr_params    = ( shortcode_atts( $this->config['params'], $atts ) );

		$sub_shortcode = do_shortcode( $content );
		// seperate by cell
		$items_html    = explode( '<!--seperate-->', $sub_shortcode );

		// remove empty element
		$items_html    = array_filter( $items_html );
		$row           = 0;
		$not_empty     = 0;
		$updated_html  = array();
		
		foreach ( $items_html as $item ) {
			$cell_html = '';
			$cell_wrap = ( $row == 0 ) ? 'th' : 'td';

			if ( strpos( $item, 'CELL_WRAPPER' ) === false ) {
				$cell_html .= ( $item == 'tr_start' ) ? '<tr>' : '</tr>';
				if ( strip_tags( $item ) == 'tr_end' )
				$row++;
			}
			else {
				if ( strpos( $item, '<!--empty-->' ) !== false ) {
					$item = str_replace( '<!--empty-->', '', $item );
				} else {
					$not_empty++;
				}

				$cell_html .= str_replace( 'CELL_WRAPPER', $cell_wrap, $item );
			}
			$updated_html[] = $cell_html;
		}

		$sub_shortcode = ( $not_empty == 0 ) ? '' : implode( '', $updated_html );

		$html_element = "<table class='table {$arr_params['tb_style']}'>" . $sub_shortcode . '</table>';
		return $this->element_wrapper( $html_element, $arr_params );
	}
}

endif;
