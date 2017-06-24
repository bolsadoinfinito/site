<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
class T4P_Pb_Helper_Html_Group extends T4P_Pb_Helper_Html {
	/**
	 * Group items
	 *
	 * @param type $element
	 *
	 * @return string
	 */
	static function render( $element ) {
		$_element                 = $element;

		$add_item                 = isset( $element['add_item_text'] ) ? $element['add_item_text'] : __( 'Add Item', 't4p-core' );
		$sub_items                = $_element['sub_items'];
                $overwrite_shortcode_data = isset( $element['overwrite_shortcode_data'] ) ? $element['overwrite_shortcode_data'] : true;
		$sub_item_type            = $element['sub_item_type'];
		$items_html               = array();
		$shortcode_name           = str_replace( 'T4P_', '', $element['shortcode'] );

		if ( $sub_items ) {
			foreach ( $sub_items as $idx => $item ) {
				$element = new $sub_item_type();
				$element->init_element();
				$label_item = ( isset( $element->config['exception']['item_text'] ) ) ? $element->config['exception']['item_text'] : '';

				// check if $item['std'] is empty or not
				$shortcode_data = '';

				if ( ! $label_item ) {
					$content = __( $sub_item_type, 't4p-core' ) . ' ' . __( 'Item', 't4p-core' ) . ' ' . ( $idx + 1 );
				} else {
					$content = rtrim( $label_item ) . ' ' . ( $idx + 1 );
				}
				if ( isset( $_element['no_title'] ) ) {
					$content = $_element['no_title'];
				}
				if ( ! empty( $item['std'] ) ) {
					// keep shortcode data as it is
					$shortcode_data = $item['std'];

					// reassign params for shortcode base on std string
					$extract_params = T4P_Pb_Helper_Shortcode::extract_params( ( $item['std'] ) );

					$params         = T4P_Pb_Helper_Shortcode::generate_shortcode_params( $element->items, NULL, $extract_params, TRUE, FALSE, $content );

					$element->shortcode_data();
					$params['extract_title'] = ( ! $label_item ) ?  $sub_item_type. ' ' . __( 'Item', 't4p-core' ) . ' ' . ( $idx + 1 ) : __( '(Untitled)', 't4p-core' );
					$content                 = $params['extract_title'];
					if ( $overwrite_shortcode_data ) {
                                            if ($sub_item_type == 'Pricing_column') {
                                                $shortcode_data = $item['std'];
                                            } else {
						$shortcode_data = $element->config['shortcode_structure'];
                                            }
					}
				}

				$element_type = (array) $element->element_in_pgbldr( $content, $shortcode_data, '', $idx + 1 );
				foreach ( $element_type as $element_structure ) {
					$items_html[] = $element_structure;
				}
			}
		}

		$style        = ( isset( $_element['style'] ) ) ? 'style="' . $_element['style'] . '"' : '';
		$items_html   = implode( '', $items_html );
		$element_name = ( isset( $_element['name'] ) ) ? $_element['name'] : __( ucwords( ( ! $label_item ) ? $shortcode_name : $label_item ), 't4p-core' );
		$element_name = str_replace( 'Item', '', $element_name ) . ' ' . __( 'Items', 't4p-core' );
		$group_heading = T4P_Pb_Helper_Html_Fieldset::render( array( 'name'    => $element_name, 'id'      => '', 'type'    => 'fieldset', ) );
		$html_element = "<div id='{$_element['id']}' class='form-group control-group clearfix'>$group_heading
				<div class='item-container has_submodal controls'>
					<ul $style class='ui-sortable jsn-items-list item-container-content jsn-rounded-medium' id='group_elements'>
					$items_html
					</ul>
					<a href='javascript:void(0);' class='jsn-add-more t4p-more-element in-modal' item_common_title='" . __( $shortcode_name, 't4p-core' ) . ' ' . __( 'Item', 't4p-core' ) . "' data-shortcode-item='" . strtolower( $sub_item_type ) . "'><i class='icon-plus'></i>" . __( $add_item, 't4p-core' ) . '</a>
				</div></div>';

					return $html_element;
	}
}