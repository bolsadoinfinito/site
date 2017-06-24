<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 * 
 */

/**
 * T4P PageBuilder Settings
 *
 * @package  T4P_PageBuilder
 * @since    1.0.0
 */
 
class T4P_Pb_Product_Plugin {
	/**
	 * Define pages.
	 *
	 * @var  array
	 */
	public static $pages = array( 't4p-pb-settings', 't4p-pb-addons' );

	/**
	 * Current T4P PageBuilder settings.
	 *
	 * @var  array
	 */
	protected static $settings;

	/**
	 * Initialize T4P PageBuilder plugin.
	 *
	 * @return  void
	 */
	public static function init() {
		global $pagenow;

		// Get product information
		$plugin = T4P_Pb_Product_Info::get( T4P_CORE_FILE );

		// Remove line below to enable Addons mechanism feature.
		$plugin['Addons'] = null;

		// Generate menu title
		$menu_title = __( 'Theme4Press Composer', 't4p-core' );

		// Define admin menus
		$admin_menus = array(
			'page_title' => __( 'Theme4Press Composer', 't4p-core' ),
			'menu_title' => $menu_title,
			'capability' => 'manage_options',
			'menu_slug'  => 't4p-pb-settings',
			'icon_url'   => T4P_Pb_Helper_Functions::path( 'assets/theme4press' ) . '/images/icont4p.png',
			'children'   => array(
				
				array(
					'page_title' => __( 'Theme4Press Composer - Settings', 't4p-core' ),
					'menu_title' => __( 'Settings', 't4p-core' ),
					'capability' => 'manage_options',
					'menu_slug'  => 't4p-pb-settings',
					'function'   => array( __CLASS__, 'settings' ),
				),
			),
		);

		if ( $plugin['Addons'] ) {
			// Generate menu title
			$menu_title = __( 'Add-ons', 't4p-core' );

			if ( $plugin['Available_Update'] && ( 'admin.php' == $pagenow && isset( $_REQUEST['page'] ) && in_array( $_REQUEST['page'], self::$pages ) ) ) {
				$menu_title .= " <span class='t4p-available-updates update-plugins count-{$plugin['Available_Update']}'><span class='pending-count'>{$plugin['Available_Update']}</span></span>";
			}

			// Update admin menus
			$admin_menus['children'][] = array(
				'page_title' => __( 'T4P PageBuilder - Add-ons', 't4p-core' ),
				'menu_title' => $menu_title,
				'capability' => 'manage_options',
				'menu_slug'  => 't4p-pb-addons',
				'function'   => array( __CLASS__, 'addons' ),
			);
		}

		// Initialize necessary T4P Library classes
		T4P_Pb_Init_Admin_Menu::hook();
		T4P_Pb_Product_Addons ::hook();

		// Register admin menus
		T4P_Pb_Init_Admin_Menu::add( $admin_menus );

		// Remove redundant menu
		T4P_Pb_Init_Assets::inline( 'js', '$(\'#toplevel_page_t4p-pb-about-us .wp-first-item\').hide();' );

		// Register 't4p_pb_installed_product' filter
		add_filter( 't4p_pb_installed_product', array( __CLASS__, 'register_product' ) );

		// Load required assets
		if ( 'admin.php' == $pagenow && isset( $_REQUEST['page'] ) && in_array( $_REQUEST['page'], array( 't4p-pb-settings', 't4p-pb-addons' ) ) ) {
			// Load common assets
			T4P_Pb_Init_Assets::load( array( 't4p-bootstrap-css', 't4p-jsn-css' ) );

			switch ( $_REQUEST['page'] ) {
				case 't4p-pb-addons':
					// Load addons style and script
					T4P_Pb_Init_Assets::load( array( 't4p-pb-addons-css', 't4p-pb-addons-js' ) );
				break;
			}
		}

		// Register Ajax actions
		if ( 'admin-ajax.php' == $pagenow ) {
			add_action( 'wp_ajax_t4p-pb-convert-data',  array( __CLASS__, 'convert_data' ) );
		}
	}

	/**
	 * Apply 't4p_pb_installed_product' filter.
	 *
	 * @param   array  $plugins  Array of installed Theme4press product.
	 *
	 * @return  array
	 */
	public static function register_product( $plugins ) {
		// Register product identification
		$plugins[] = T4P_PAGEBUILDER_IDENTIFICATION;

		return $plugins;
	}

	/**
	 * Convert other page builder data to T4P PageBuilder data.
	 *
	 * @return  void
	 */
	public static function convert_data() {
		// Set custom error reporting level
		error_reporting( E_ALL ^ E_NOTICE );

		// Get current post
		$post = isset( $_REQUEST['post'] ) ? get_post( $_REQUEST['post'] ) : null;

		if ( ! $post ) {
			die( json_encode( array( 'success' => false, 'message' => __( 'Missing post ID.', 't4p-core' ) ) ) );
		}

		// Get converter
		$converter = isset( $_REQUEST['converter'] ) ? T4P_Pb_Converter::get_converter( $_REQUEST['converter'], $post ) : null;

		if ( ! $converter ) {
			die( json_encode( array( 'success' => false, 'message' => __( 'Missing data converter.', 't4p-core' ) ) ) );
		}

		// Handle conversion of other page builder data to T4P PageBuilder
		$result = $converter->convert();

		if ( ! is_integer( $result ) || ! $result ) {
			$response = array( 'success' => false, 'message' => $result );
		} else {
			if ( isset( $_REQUEST['do'] ) && 'convert-and-publish' != $_REQUEST['do'] ) {
				$result = __( 'Data has been successfully converted!', 't4p-core' );
			} else {
				$result = __( 'Data has been successfully converted and published!', 't4p-core' );
			}

			$response = array( 'success' => true, 'message' => $result );
		}

		die( json_encode( $response ) );
	}

	/**
	 * Load required assets.
	 *
	 * @return  void
	 */
	public static function load_assets() {
		T4P_Pb_Helper_Functions::enqueue_styles();
		T4P_Pb_Helper_Functions::enqueue_scripts_end();
	}

	/**
	 * Render addons installation and management screen.
	 *
	 * @return  void
	 */
	public static function addons() {
		// Instantiate product addons class
		T4P_Pb_Product_Addons::init( T4P_CORE_FILE );
	}




	/**
	 * Render settings page.
	 *
	 * @return  void
	 */
	public static function settings() {
		// Load update script
		T4P_Pb_Init_Assets::load( array( 't4p-pb-settings-js' ) );

		include T4P_CORE_TPL_PATH . '/settings.php';
	}

	/**
	 * Register settings with WordPress.
	 *
	 * @return  void
	 */
	public static function settings_form() {
		// Add the section to reading settings so we can add our fields to it
		$page    = 't4p-pb-settings';
		$section = 't4p-pb-settings-form';

		add_settings_section(
		$section,
			'',
		array( __CLASS__, 't4p_pb_section_callback' ),
		$page
		);

		// Add the field with the names and function to use for our settings, put it in our new section
		$fields = array(
			array(
					'id'    => 'enable_for',
					'title' => __( 'Enable Composer for...', 't4p-core' ),
			),
			array(
					'id'    => 'cache',
					'title' => __( 'Enable Caching', 't4p-core' ),
			),
		);

		foreach ( $fields as $field ) {
			// Preset field id
			$field_id = $field['id'];

			// Do not add prefix for Theme4press Customer Account settings
			if ( 't4p_customer_account' != $field['id'] ) {
				$field_id = str_replace( '-', '_', $page ) . '_' . $field['id'];
			}

			// Register settings field
			add_settings_field(
			$field_id,
			$field['title'],
			array( __CLASS__, 't4p_pb_setting_callback_' . $field['id'] ),
			$page,
			$section,
			isset ( $field['args'] ) ? $field['args'] : array()
			);

			// Register our setting so that $_POST handling is done for us and callback function just has to echo the <input>
			register_setting( $page, $field_id );

			$params = isset( $field['params'] ) ? $field['params'] : array();
			foreach ( (array) $params as $field_id ) {
				register_setting( $page, $field_id );
			}
		}

	}

	/**
	 * Get current settings.
	 *
	 * @return  array
	 */
	public static function t4p_pb_settings_options() {
		if ( ! isset( self::$settings ) ) {
			// Define options
			$options  = array( 't4p_pb_settings_enable_for', 't4p_pb_settings_cache' );

			// Get saved options value
			self::$settings = array();

			foreach ( $options as $key ) {
				self::$settings[$key] = get_option( $key, ( $key != 't4p_pb_settings_fullmode' ) ? 'enable' : 'disable' );
			}
		}

		return self::$settings;
	}

	/**
	 * Check/select options.
	 *
	 * @param   string  $value    Current value.
	 * @param   string  $compare  Desired value for checking/selecting option.
	 * @param   string  $check    HTML attribute of checked/selected state.
	 *
	 * @return  void
	 */
	public static function t4p_pb_setting_show_check( $value, $compare, $check ) {
		echo esc_attr( ( $value == $compare ) ? "$check='$check'" : '' );
	}

	/**
	 * Setting section callback handler.
	 *
	 * @return  void
	 */
	public static function t4p_pb_section_callback() {}

	/**
	 * Render HTML code for `Enable On` field.
	 *
	 * @return  void
	 */
	public static function t4p_pb_setting_callback_enable_for() {
		// Get all post types
		$post_types = get_post_types( array( 'public' => true ), 'objects' );

		// Prepare post types as field options
		$options = array();

		global $_wp_post_type_features;

		foreach ( $post_types as $slug => $defines ) {
			// Filter supported post type
			if ( 'attachment' != $slug && post_type_supports( $slug, 'editor' ) ) {
				$options[ $slug ] = $defines->labels->name;
			}
		}

		// Get current settings
		$settings = self::t4p_pb_settings_options();
		extract( $settings );

		// Render field options
		$first = true;

		foreach ( $options as $slug => $label ) :

		// Prepare checking state
		$checked = '';

		if ( 'enable' == $t4p_pb_settings_enable_for ) :
		$checked = 'checked="checked"';
		elseif ( is_array( $t4p_pb_settings_enable_for ) && ( ! isset( $t4p_pb_settings_enable_for[ $slug ] ) || 'enable' == $t4p_pb_settings_enable_for[ $slug ] ) ) :
		$checked = 'checked="checked"';
		endif;

		// Set value based on checking state
		$value = empty( $checked ) ? 'disable' : 'enable';

		if ( ! $first ) :
		echo '<br />';
		endif;
		?>
<label for="t4p_pb_settings_enable_for_<?php esc_attr_e( $slug ); ?>"> <input
	type="hidden"
	name="t4p_pb_settings_enable_for[<?php esc_attr_e( $slug ); ?>]"
	value="<?php esc_attr_e( $value ); ?>" /> <input
	id="t4p_pb_settings_enable_for_<?php esc_attr_e( $slug ); ?>"
	<?php _e( $checked ); ?>
	onclick="jQuery(this).prev().val(this.checked ? 'enable' : 'disable');"
	type="checkbox" autocomplete="off" /> <?php _e( $label ); ?> </label>
	<?php
	$first = false;

	endforeach;
	?>
<p class="description">
<?php _e( 'Uncheck post types where you do not want Theme4Press Composer to be activated.', 't4p-core' ); ?>
</p>
<?php
	}

	/**
	 * Render HTML code for `Enable Caching` field.
	 *
	 * @return  void
	 */
	public static function t4p_pb_setting_callback_cache() {
		$settings = self::t4p_pb_settings_options();
		extract( $settings );
		?>
<div>
	<select name="t4p_pb_settings_cache">
		<option value="enable"
		<?php selected( $t4p_pb_settings_cache, 'enable' ); ?>>
			<?php _e( 'Yes', 't4p-core' ); ?>
		</option>
		<option value="disable"
		<?php selected( $t4p_pb_settings_cache, 'disable' ); ?>>
			<?php _e( 'No', 't4p-core' ); ?>
		</option>
	</select>
	<button class="button button-default"
		data-textchange="<?php _e( 'Done!', 't4p-core' ) ?>" id="t4p-pb-clear-cache">
		<?php _e( 'Clear cache', 't4p-core' ); ?>
		<i class="jsn-icon16 layout-loading jsn-icon-loading"></i>
	</button>
</div>
<p class="description">
<?php _e( "Select 'Yes' if you want to cache CSS and JS files of Composer", 't4p-core' ); ?>
</p>
<?php
	}

	/**
	 * Render HTML code for `Load Bootstrap Assets` field.
	 *
	 * @return  void
	 */
	public static function t4p_pb_setting_callback_bootstrap() {
	}

	/**
	 * Render HTML code for `Auto Check Update` field.
	 *
	 * @return  void
	 */
	public static function t4p_pb_setting_callback_auto_check_update() {
		$settings = self::t4p_pb_settings_options();
		extract( $settings );
		?>

<!--- <div>
	<select name="t4p_pb_settings_auto_check_update">
		<option value="enable"
		<?php// selected( $t4p_pb_settings_auto_check_update, 'enable' ); ?>>
			<//?php _e( 'Yes', 't4p-core' ); ?>
		</option>
		<option value="disable"
		<?php// selected( $t4p_pb_settings_auto_check_update, 'disable' ); ?>>
			<?php// _e( 'No', 't4p-core' ); ?>
		</option>
	</select>
</div>-->


<?php
	}
}
