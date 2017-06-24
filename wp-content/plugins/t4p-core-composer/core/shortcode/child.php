<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
/*
/*
 * Parent class for sub elements
 */

class T4P_Pb_Shortcode_Child extends T4P_Pb_Shortcode_Element {

	/**
	 * Over write parent method
	 *
	 * @param string $content
	 * @param string $shortcode_data
	 * @param string $el_title
	 * @param int $index
	 * @param bool $inlude_sc_structure
	 * @param array $extra_params
	 * @return string
	 */
	public function element_in_pgbldr( $content = '', $shortcode_data = '', $el_title = '', $index = '', $inlude_sc_structure = true, $extra_params = array() ) {
		$this->config['sub_element'] = true;
		return parent::element_in_pgbldr( $content, $shortcode_data, $el_title, $index, $inlude_sc_structure, $extra_params );
	}

}
