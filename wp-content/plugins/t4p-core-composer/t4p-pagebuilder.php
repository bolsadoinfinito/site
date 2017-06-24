<?php
/**
*
* T4P Page Builder 
* @package T4P Core Plugin
* @subpackage T4P Pagebuilder
* @since 1.3.3
*
*/

if ( ! defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly


if (!class_exists('T4P_Pb_Init')) :


/**
* 
* Initialize T4P PageBuilder
* @package Theme4Press Core
* @since    1.0.0
* 
*/

class T4P_Pb_Init {
	/**
	 * Constructor
	 *
	 * @return  void
	 */

	public function __construct() {
		
            // Load core functionalities
            
		$this->includes();
		$this->autoload();

	    // Initialize assets management and loader
                
		T4P_Pb_Assets_Register::init();
		T4P_Pb_Init_Assets::hook();
                
	    // Initialize T4P Library
                
		T4P_Pb_Init_Plugin::hook();

	    // Register necessary actions
                
		add_action( 'widgets_init', array(                 &$this, 'init'          ), 100 );
		add_action( 'admin_init'  , array(       'T4P_Pb_Gadget_Base', 'hook'          ), 100 );
		add_action( 'admin_init'  , array( 'T4P_Pb_Product_Plugin', 'settings_form' )      );
                
		
		/**
		
		// Check update
		if ( ( get_option( 't4p_pb_settings_auto_check_update', 'enable' ) == 'enable' ) && ( time() > get_option( 't4p_pagebuilder_update_schedule', 0 ) ) ) {
			update_option( 't4p_pagebuilder_update_schedule', time() + ( 2 * 7 * 24 * 60 * 60 ) );
			add_action( 'init', array( 'T4P_Pb_Helper_Update_Checker', 'check_by_curl' ) );
			add_action( 't4p_enqueue_scripts', array( 'T4P_Pb_Helper_Update_Checker', 'check_by_ajax' ) );
			add_action( 'admin_enqueue_scripts', array( 'T4P_Pb_Helper_Update_Checker', 'check_by_ajax' ) );
		}
		
		*/

		/**
		* Removed since we no longer need activation unless the page builder is in future used independently. 
		*
		// Activate plugin
		register_activation_hook( T4P_CORE_FILE, array( $this, 'do_activate' ) );
		// Redirect after plugin activation
		add_action( 'admin_init' , array( $this, 'do_activation_redirect' ) );
	    */

	// Initialize built-in shortcodes (Page builder shortcodes that are independent of the T4P Core shortcodes)
                
		include_once dirname( __FILE__ ) . '/shortcodes/main.php';
	}
        

/**
 * Initialize core functionalities.
 *
 * @return  void
 * 
 */
	
        function init(){
		global $t4p_pb, $t4p_pb_widgets;

	// Initialize T4P PageBuilder
		
                $t4p_pb = new T4P_Pb_Core();
		new T4P_Pb_Utils_Plugin();

		do_action( 't4p_pagebuilder_init' );

	// Initialize widget support
                
		$t4p_pb_widgets = ! empty( $t4p_pb_widgets ) ? $t4p_pb_widgets : 
		T4P_Pb_Helper_Functions::widgets();
	}

/**
* Include required files.
*
* @return  void
* 
*/
	
            function includes() {
            
	// include core files
		include_once 'core/loader.php';
		include_once 'defines.php';
             }

          
/**
* Register autoloader.
*
* @return  void
* 
*/
            function autoload() {
		
                T4P_Pb_Loader::register( T4P_CORE_PATH . 'core'       , 'T4P_Pb_'     );
		T4P_Pb_Loader::register( T4P_CORE_PATH . 'core/gadget', 'T4P_Gadget_' );

	// Allow autoload registration from outside
                
		do_action( 't4p_pb_autoload' );
            }

/**
* Activate handle.
*
* @return  void
* @TODO Remove /deactivate the Activation Hook since we no longer need this after combining the plugins
* 
*/
	 
            public function do_activate() {
		update_option( 't4p_pagebuilder_do_activation_redirect', 'Yes' );
	}
 
        
        
/**
* Activation redirect handle.
*
* @return  void
* 
*/
	  
        public function do_activation_redirect() {
		if ( get_option( 't4p_pagebuilder_do_activation_redirect', 'No' ) == 'Yes' ) {
			update_option( 't4p_pagebuilder_do_activation_redirect', 'No' );
			wp_redirect( admin_url( 'admin.php?page=t4p-pb-settings' ) );//@TODO: Change this URL to Documentation
		}
	}
}
 
 
// Instantiate T4P PageBuilder initialization class

        $GLOBALS['t4p_pagebuilder'] = new T4P_Pb_Init();
	 
endif;
		 		