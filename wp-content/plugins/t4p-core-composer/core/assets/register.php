<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */

/**
 * Init Theme4press's plugins.
 *
 * @package  T4P_Plugin_Framework
 * @since    1.0.0
 */
class T4P_Pb_Assets_Register {
	/**
	 * Assets to be registered.
	 *
	 * @var  array
	 */
	protected static $assets = array(
	/**
	 * Third party assets.
	 */
		't4p-pb-bootstrap-css' => array(
			'src' => '',
			'ver' => '3.1.1',
			'site' => 'admin',
	),

		't4p-pb-bootstrap-responsive-css' => array(
			'src' => 'assets/3rd-party/bootstrap3/css/bootstrap-responsive.min.css',
			'deps' => array( 't4p-pb-bootstrap-css' ),
			'ver' => '3.1.1',
			'site' => 'admin',
	),

		't4p-pb-bootstrap-js' => array(
			'src' => 'assets/3rd-party/bootstrap3/js/bootstrap.min.js',
			'deps' => array( 'jquery' ),
			'ver' => '3.1.1',
			'site' => 'admin',
	),

		't4p-pb-bootstrap-paginator-js' => array(
			'src' => 'assets/3rd-party/bootstrap-paginator/bootstrap-paginator.js',
			'deps' => array( 't4p-pb-bootstrap-js' ),
			'ver' => '0.5',
	),

		't4p-pb-classygradient-css' => array(
			'src' => 'assets/3rd-party/classygradient/css/jquery.classygradient.css',
			'deps' => array( 't4p-pb-colorpicker-css' ),
			'ver' => '1.0.0',
	),

		't4p-pb-classygradient-js' => array(
			'src' => 'assets/3rd-party/classygradient/js/jquery.classygradient.js',
			'deps' => array( 'jquery-ui-draggable', 't4p-pb-colorpicker-js' ),
			'ver' => '1.0.0',
	),

		't4p-pb-colorpicker-css' => array(
			'src' => 'assets/3rd-party/colorpicker/css/colorpicker.css',
	),

		't4p-pb-colorpicker-js' => array(
			'src' => 'assets/3rd-party/colorpicker/js/colorpicker.js',
	),

		't4p-pb-font-icomoon-css' => array(
			'src' => 'assets/3rd-party/font-icomoon/css/icomoon.css',
	),

                't4p-pb-font-fontawesome-css' => array(
			'src' => 'tinymce/css/font-awesome.css',
	),

		't4p-pb-jsn-css' => array(
			'src' => 'assets/3rd-party/jsn/css/jsn-gui.css',
			'deps' => array( 't4p-pb-bootstrap-css' ),
	),

		't4p-pb-joomlashine-fontselector-js' => array(
			'src' => 'assets/3rd-party/jsn/js/jsn-fontselector.js',
	),

		't4p-pb-joomlashine-iconselector-js' => array(
			'src' => 'assets/3rd-party/jsn/js/jsn-iconselector.js',
	),

		't4p-pb-joomlashine-modalresize-js' => array(
			'src' => 'assets/3rd-party/jsn/js/jsn-modalresize.js',
	),

		't4p-pb-jquery-easing-js' => array(
			'src' => 'assets/3rd-party/jquery-easing/jquery.easing.min.js',
			'ver' => '1.3',
	),

		't4p-pb-jquery-fancybox-js' => array(
			'src' => 'assets/3rd-party/jquery-fancybox/jquery.fancybox-1.3.4.js',
			'ver' => '1.3.4',
	),

		't4p-pb-jquery-fancybox-css' => array(
			'src' => 'assets/3rd-party/jquery-fancybox/jquery.fancybox-1.3.4.css',
			'ver' => '1.3.4',
	),

		't4p-pb-jquery-lazyload-js' => array(
			'src' => 'assets/3rd-party/jquery-lazyload/jquery.lazyload.js',
			'deps' => array( 'jquery' ),
			'ver' => '1.8.4',
	),

		't4p-pb-jquery-resize-js' => array(
			'src' => 'assets/3rd-party/jquery-resize/jquery.ba-resize.js',
			'deps' => array( 'jquery' ),
			'ver' => '1.1',
	),

		't4p-pb-jquery-select2-css' => array(
			'src' => 'assets/3rd-party/jquery-select2/select2.css',
			'ver' => '3.3.2',
	),

		't4p-pb-jquery-select2-bootstrap3-css' => array(
			'src' => 'assets/3rd-party/jquery-select2/select2-bootstrap3.css',
			'ver' => '3.3.2',
	),

		't4p-pb-jquery-select2-js' => array(
			'src' => 'assets/3rd-party/jquery-select2/select2.js',
			'deps' => array( 'jquery' ),
			'ver' => '3.3.2',
	),

		't4p-pb-jquery-ui-css' => array(
			'src' => 'assets/3rd-party/jquery-ui/css/ui-bootstrap/jquery-ui-1.9.0.custom.css',
			'ver' => '1.9.0',
	),

		't4p-zeroclipboard-js' => array(
			'src' => 'assets/3rd-party/zeroclipboard/ZeroClipboard.min.js',
			'ver' => '1.3.5',
	),

		't4p-pb-convert-data-js' => array(
			'src' => 'assets/theme4press/js/convert-data.js',
	),

		't4p-pb-activity-js' => array(
			'src' => 'assets/theme4press/js/activity.js',
	),

            	't4p-pb-text-js' => array(
			'src' => 'assets/theme4press/js/text.js',
	),
            
                't4p-pb-image-js' => array(
			'src' => 'assets/theme4press/js/image.js',
	),
            
                't4p-pb-preview-bootstrap-js' => array(
			'src' => '',
	),

                't4p-pb-preview-main-js' => array(
			'src' => '',
	),

                't4p-pb-jquery.carouFredSel' => array(
			'src' => '',
	),
                't4p-pb-jquery.flexslider' => array(
			'src' => '',
	),

                't4p-pb-preview-style-css' => array(
			'src' => '',
	),

                't4p-pb-shortcodes-css' => array(
			'src' => '',
	),

                't4p-pb-preview-bootstrap-css' => array(
			'src' => '',
	),

                't4p-pb-bootstrapcsstheme-css' => array(
			'src' => '',
	),

                't4p-pb-animation-css' => array(
			'src' => '',
	),
        );

	/**
	 * Set hook prefix for loading assets.
	 *
	 * @param   string  $prefix  Current hook prefix.
	 *
	 * @return  string
	 */
	public static function hook_prefix( $prefix = '' ) {
		if ( 'admin' == $prefix && class_exists( 'T4P_Pb_Helper_Functions' ) && T4P_Pb_Helper_Functions::is_modal() ) {
			$prefix = 'pb_admin';
		}

		return $prefix;
	}

	/**
	 * Filter to apply supported assets.
	 *
	 * @param   array  $assets  Current assets.
	 *
	 * @return  array
	 */
	public static function apply_assets( $assets = array() ) {
		foreach ( self::$assets AS $key => $value ) {
			if ( ! isset( $assets[$key] ) ) {
				// Fine-tune asset location
				if ( ! preg_match( '#^(https?:)?/#', $value['src'] ) AND is_file( T4P_CORE_PATH . ltrim( $value['src'], '/' ) ) ) {
					$value['src'] = T4P_CORE_URI . ltrim( $value['src'], '/' );

					$assets[$key] = $value;
				}
			}
		}

		return $assets;
	}

	/**
	 * Initialize Theme4press's plugins.
	 *
	 * @return  void
	 */
	public static function init() {
		// Add filters to register assets
		add_filter( 't4p_pb_asset_hook_prefix', array( __CLASS__, 'hook_prefix'  ) );
		add_filter( 't4p_pb_register_assets',   array( __CLASS__, 'apply_assets' ) );

		// Do 't4p_pb_init_plugins' action
		do_action( 't4p_pb_init_plugin' );
	}
}
