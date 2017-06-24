<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */

// Define absolute path of plugin

    define( 'T4P_CORE_PATH', plugin_dir_path( __FILE__ ) );

// Define absolute path of shortcodes folder

    define( 'T4P_CORE_LAYOUT_PATH', T4P_CORE_PATH . 'core/shortcode/layout' );
    define( 'T4P_PB_ELEMENT_PATH', T4P_CORE_PATH . 'shortcodes' );

// Define premade layout folder

    define( 'T4P_PB_PREMADE_LAYOUT', T4P_CORE_PATH . 'templates/layout/pre-made' );
    define( 'T4P_PB_PREMADE_LAYOUT_URI', T4P_CORE_PATH . 'templates/layout/pre-made' );
    define( 'T4P_CORE_INC_PATH', T4P_CORE_PATH . 'includes' );

// Define absolute path of templates folder

    define( 'T4P_CORE_TPL_PATH', T4P_CORE_PATH . 'templates' );

// Define plugin URI

    define( 'T4P_CORE_URI', plugin_dir_url( __FILE__ ) );

// Define nonce ID

    define( 'T4P_NONCE', 't4p_nonce_check' );

// Define URL to load element editor

    define( 'T4P_EDIT_ELEMENT_URL', admin_url( 'admin.php?t4p-gadget=edit-element&action=form' ) );

// Define product identification

    define( 'T4P_PAGEBUILDER_IDENTIFICATION', 't4p_pagebuilder' );

// Define product addons

    define( 'T4P_PAGEBUIDLER_ADDONS', null );

// Define folder in /wp-content/uploads stores user's template

    define( 'T4P_PAGEBUILDER_USER_LAYOUT', 'user' );


/**
 * 
 * Fix error warning of Woocommerce, when try to call Woocommerce in WP Admin
 * 
 */

    if ( ! function_exists( 'woocommerce_reset_loop' ) ) {

	/**
	 * Reset the loop's index and columns when we're done outputting a product loop.
	 *
	 * @access public
	 * @subpackage	Loop
	 * @return void
	 */

        function woocommerce_reset_loop() {
		global $woocommerce_loop;
		// Reset loop/columns globals when starting a new loop
		$woocommerce_loop['loop'] = $woocommerce_loop['columns'] = '';
	}
}