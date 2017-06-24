<?php

if (get_stylesheet_directory() == get_template_directory()) {
    define('EVOLVE_URL', get_template_directory() . '/library/functions/');
    define('EVOLVE_DIRECTORY', get_template_directory_uri() . '/library/functions/');
} else {
    define('EVOLVE_URL', get_template_directory() . '/library/functions/');
    define('EVOLVE_DIRECTORY', get_template_directory_uri() . '/library/functions/');
}

/**
 * Get Option.
 * Helper function to return the theme option value.
 * If no value has been saved, it returns $default.
 * Needed because options are
 * as serialized strings.
 */
function evolve_get_option($name, $default = false) {
    $config = get_option('evolve');

    if (!isset($config['id'])) {
        //return $default;
    }
    global $evl_options;

    $options = $evl_options;
    if (isset($GLOBALS['redux_compiler_options'])) {
        $options = $GLOBALS['redux_compiler_options'];
    }

    if (isset($options[$name])) {
        $mediaKeys = array(
            'evl_bootstrap_slide1_img',
            'evl_bootstrap_slide2_img',
            'evl_bootstrap_slide3_img',
            'evl_bootstrap_slide4_img',
            'evl_bootstrap_slide5_img',
            'evl_content_background_image',
            'evl_favicon',
            'evl_iphone_icon',
            'evl_iphone_icon_retina',
            'evl_ipad_icon',
            'evl_ipad_icon_retina',
            'evl_footer_background_image',
            'evl_header_logo',
            'evl_header_logo_retina',
            'evl_sticky_header_logo_img_retina',
            'evl_scheme_background',
            'evl_slide1_img',
            'evl_slide2_img',
            'evl_slide3_img',
            'evl_slide4_img',
            'evl_slide5_img',
            'evl_pagetitlebar_background',
            'evl_pagetitlebar_background_retina',
        );
        // Media SHIM
        if (in_array($name, $mediaKeys)) {
            if (is_array($options[$name])) {
                return isset($options[$name]['url']) ? $options[$name]['url'] : false;
            } else {
                return $options[$name];
            }
        }

        return $options[$name];
    }

    return $default;
}

add_filter('upload_mimes', 'evolve_custom_upload_mimes');

function evolve_custom_upload_mimes($existing_mimes = array()) {

    // add the file extension to the array

    $existing_mimes['svg'] = 'mime/type';
    $existing_mimes['woff'] = 'mime/type';
    $existing_mimes['eot'] = 'mime/type';
    $existing_mimes['ttf'] = 'mime/type';
    // call the modified list of extensions

    return $existing_mimes;
}

get_template_part('library/functions/basic-functions');
get_template_part('library/admin/admin-init');

// Metaboxes
get_template_part('library/views/metaboxes/metaboxes');

// Theme4Press Theme Autoupdater 
require_once( 'library/functions/class-wp-theme-update-manager.php' );
$theme_data = wp_get_theme();
$update_manager = new Wp_Theme_Update_Manager($theme_data->Name, 'https://theme4press.com/user_authenticate.php');

/* polylang plugin if active than filter custom post type  */
add_filter('pll_get_post_types', 'evolve_pll_get_post_types');

function evolve_pll_get_post_types($types) {
    return array_merge($types, array('evolve_portfolio' => 'evolve_portfolio', 'slide' => 'slide'));
}

// Register Navigation
register_nav_menu('sticky_navigation', 'Sticky Header Navigation');

/* Theme4Press Mega Menu */
require_once( get_template_directory() . '/library/mega-menu-framework.php' );

function evolve_script() {
    wp_enqueue_style('reset', get_template_directory_uri() . '/assets/css/reset.css');
    // Bootstrap Elements  
    wp_enqueue_style('bootstrapcss', get_template_directory_uri() . '/assets/css/bootstrap.css', array('maincss'));
    wp_enqueue_style('bootstrapcsstheme', get_template_directory_uri() . '/assets/css/bootstrap-theme.css', array('bootstrapcss'));
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js');
    wp_enqueue_script('tooltip', get_template_directory_uri() . '/assets/js/tooltip.js');
    // Media.css
    wp_enqueue_style('mediacss', get_template_directory_uri() . '/assets/css/media.css', array('maincss'));
    // Shortcode.css
    wp_enqueue_style('shortcode', get_template_directory_uri() . '/assets/css/shortcode/shortcodes.css');
    wp_enqueue_style('animations', get_template_directory_uri() . '/assets/css/shortcode/animations.css');
}

add_action('wp_enqueue_scripts', 'evolve_script');

function evolve_admin_scripts($hook) {
    /* mega menu icon picker */
    if ($hook == 'nav-menus.php' || $hook == 'appearance_page_evl_options_options') {
        wp_enqueue_style('fontawesomecss', get_template_directory_uri() . '/assets/fonts/fontawesome/css/font-awesome.css', false);
        wp_enqueue_script('iconpicker', get_template_directory_uri() . '/library/admin/iconpicker/fontawesome-iconpicker.js', array(), '', true, 'all');
        wp_enqueue_style('colorpickercss', get_template_directory_uri() . '/library/admin/iconpicker/fontawesome-iconpicker.css', array(), '', 'all');
    }
}

add_action('admin_enqueue_scripts', 'evolve_admin_scripts');
