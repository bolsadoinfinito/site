<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */

/**
 * Manage placeholders on Php files
 *
 * Set & Get placeholder on Php files
 */

// define array of placeholders php
global  $placeholders;
$placeholders = array();
$placeholders['widget_title']   = '_T4P_WIDGET_TIGLE_';
$placeholders['extra_class']    = '_T4P_EXTRA_CLASS_';
$placeholders['index']		    = '_T4P_INDEX_';
$placeholders['custom_style']   = '_T4P_STYLE_';
$placeholders['standard_value'] = '_T4P_STD_';
$placeholders['wrapper_append'] = '_T4P_WRAPPER_TAG_';

class T4P_Pb_Utils_Placeholder {
	/**
	 * Add placeholder to string
	 * Ex:	T4P_Pb_Utils_Placeholder::add_placeholder( 'Text %s', 'widget_title' )	=>	'Progress bar _T4P_WIDGET_TIGLE_'
	 */
	static function add_placeholder( $string, $placeholder, $expression = '' ){
		global $placeholders;
		if ( ! isset( $placeholders[$placeholder] ) )
		return NULL;
		if ( empty( $expression ) )
		return sprintf( $string, $placeholders[$placeholder] );
		else
		return sprintf( $string, sprintf( $expression, $placeholders[$placeholder] ) );
	}

	/**
	 * Replace placeholder with real value
	 * Ex:	str_replace( '_T4P_STYLE_', $replace, $string );   =>  T4P_Pb_Utils_Placeholder::remove_placeholder( $string, 'custom_style', $replace )
	 */
	static function remove_placeholder( $string, $placeholder, $value ){
		global $placeholders;
		if ( ! isset( $placeholders[$placeholder] ) )
		return $string;
		return str_replace( $placeholders[$placeholder], $value, $string );
	}

	/**
	 * Get placeholder value
	 * @global array $placeholders
	 * @param type $placeholder
	 * @return string
	 */
	static function get_placeholder( $placeholder ){
		global $placeholders;
		if ( ! isset( $placeholders[$placeholder] ) )
		return NULL;
		return $placeholders[$placeholder];
	}
}