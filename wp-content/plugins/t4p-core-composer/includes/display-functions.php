<?php

class T4P_Pb_Function extends T4P_Pb_Init {

    public function __construct() {
        parent::__construct();

        //include_once T4P_CORE_INC_PATH . '/editing-screen.php';

        //$cap_page = t4p_get_option( 'lc_min_capability_page', 't4p_plugin_options_access_control' );
        if (!$cap_page)
            $cap_page = 'publish_posts';
        define('T4P_Pb_CAPABILITY', $cap_page);
        define('T4P_Pb_CAPABILITY_SAVE', $cap_page);
        add_filter('the_content', array(&$this, 't4p_pb_filter_content'), 101);
        add_action('admin_footer', array(&$this, 't4p_display_composer'));
        wp_enqueue_style( 't4p-builder-main-css', T4P_CORE_URI . 'assets/builder/builder.main.css', array(), DS_LIVE_COMPOSER_VER );
        
    }

    function t4p_pb_filter_content($content) {

        $scomposer_wrapper_before = '';
        $composer_wrapper_after = '';
        $composer_header_append = ''; // HTML to output after LC header HTML
        $composer_footer_append = ''; // HTML to otuput after LC footer HTML
        $composer_header = ''; // HTML for LC header
        $composer_footer = ''; // HTML for LC footer
        $composer_prepend = ''; // HTML to output before LC content
        $composer_content = ''; // HTML for LC content
        $composer_append = ''; // HTML to ouput after LC content
        $template_code = false; // LC code if current post powered by template
        $template_id = false; // ID of the template that powers current post

        return $composer_wrapper_before . $composer_header . '<div id="t4p-theme-content"><div id="t4p-theme-content-inner">' . $content . '</div></div>' . $composer_footer . $composer_wrapper_after;
        //return '<div id="t4p-theme-content"><div id="t4p-theme-content-inner">' . $content . '</div></div>';
    }

    /**
     * Display the composer panels in active editing mode
     *
     * @since 1.0
     */
    function t4p_display_composer() {

        global $t4p_pb_active;

        $screen = get_current_screen();

        if ($screen->id != 'toplevel_page_t4p_pb_editor') {

            return;
        }

        // Reset the query ( because some devs leave their queries non-reseted ).
        wp_reset_query();

        // Show the composer to users who are allowed to view it.
        // $t4p_active &&
        if (is_user_logged_in() && current_user_can(T4P_Pb_CAPABILITY)) :
            ?>
            <style>
                .t4p-container {
                    font-family: 'Open Sans', sans-serif;
                    bottom: 0;
                    color: #fff;
                    left: 0;
                    position: fixed;
                    right: 0;
                    z-index: 99999;
                    -webkit-transition: bottom 0.3s;
                    -moz-transition: bottom 0.3s;
                    transition: bottom 0.3s;
                }
                .t4p-sections {
                    background: #F2F2F2;
                    box-sizing: border-box;
                    color: #666666;
                }
                .t4p-section-title {
                    display: block;
                    float: left;
                    background: #3b6fbe;
                    color: #fff;
                    font-family: 'Open Sans', sans-serif;
                    font-size: 17px;
                    line-height: 1;
                    padding: 28px 25px;
                    /* text-transform: uppercase; */
                }
                .t4p-section-title-filter {
                    position: relative;
                    cursor: pointer;
                }
                .t4p-section-title-filter .t4p-icon {
                    color: rgba( 255, 255, 255, 0.5 );
                    margin-left: 10px;
                    vertical-align: top;
                }
                .t4p-section-title-filter-options {
                    background: #5890E5;
                    border-radius: 3px 3px 0 0;
                    bottom: 35px;
                    display: none;
                    min-width: 100px;
                    left: -10px;
                    position: absolute;
                    z-index: 999999;
                    box-shadow: 0 2px 8px 0 rgba(0, 0, 0, 0.21);
                }
                .jsn-item{
                    display: inline-block;
                }
                .jsn-item .help-block{
                    display: none !important;
                }
                .t4p-front-set {
                    float: left;
                    text-align: center;
                    width: 100%;
                }
            </style>
            <div class="t4p-container">
                <div class="t4p-sections">
                    <div class="t4p-section t4p-modules" data-bg="#4A7AC3">
                    <?php
                    $this->show_element();
                    ?>
                    </div>
                </div>
            </div>
            <?php
        endif;
    }

    function show_element() {
        global $t4p_pb, $t4p_pb_shortcodes, $t4p_sc_by_providers_Name;
        // Arrray of element objects
        $elements = $t4p_pb->get_elements();
        //print_r($elements);
        if (empty($elements) || empty($elements['element'])) {
            _e('You have not install Free or Pro Shortcode package.');
        } else {
            $elements_html = array(); // HTML button of a shortcode
            $categories = array(); // array of shortcode category

            foreach ($elements['element'] as $element) {
                // don't show sub-shortcode
                if (!isset($element->config['name'])) {
                    continue;
                }

                // get shortcode category

                $category = ''; // category name of this shortcode
                if (!empty($t4p_pb_shortcodes[$element->config['shortcode']])) {
                    $category_name = $t4p_pb_shortcodes[$element->config['shortcode']]['provider']['name'] | '';
                    $category = strtolower(str_replace(' ', '', $category_name));
                    if (!array_key_exists($category, $categories)) {
                        $categories[$category] = $category_name;
                    }
                }
                $elements_html[] = $element->element_button($category);
            }
            ?>
            <div class="t4p-section-title">
                <div class="t4p-section-title-filter">
                    <span class="t4p-section-title-filter-curr">Show All</span>
                    <span class="t4p-icon t4p-icon-angle-up"></span>
                    
                </div><!-- .t4p-section-title-filter -->
            </div>
            <div class="t4p-section-scroller">
                <div class="t4p-section-scroller-inner">
                    <div class="t4p-section-scroller-content">
                        <ul class="jsn-bootstrap3" id="drag">
                                <?php
                                // shortcode elements
                                foreach ($elements_html as $idx => $element) {
                                    echo balanceTags($element);
                                }

                                // widgets
                                global $t4p_pb_widgets;
                                foreach ($t4p_pb_widgets as $wg_class => $config) {
                                    $extra_ = $config['extra_'];
                                    $config['edit_using_ajax'] = true;
                                    echo balanceTags(T4P_Pb_Shortcode_Element::el_button($extra_, $config));
                                }
                                ?>
                                <!-- Generate text area to add element from raw shortcode -->
                                <li class="jsn-item full-width" data-value='raw'
                                    data-sort='shortcode'><textarea id="raw_shortcode"></textarea>
                                    <div class="text-center rawshortcode-container">
                                        <button class="shortcode-item btn btn-success"
                                                data-shortcode="raw" id="rawshortcode-add">
                                                    <?php _e('Add Element', 't4p-core'); ?>
                                        </button>
                                    </div>
                                </li>
                            </ul>
                            
                    </div>
                </div>
            </div>
            <div class="t4p-section-scroller-nav jsn-bootstrap3">
                <a href="#" class="t4p-section-scroller-prev"><span class="icon-arrow-left"></span></a>
                <a href="#" class="t4p-section-scroller-next"><span class="icon-arrow-right"></span></a>
            </div>

            <?php
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_script( 'jquery-ui-draggable' );
            wp_enqueue_script( 'jquery-ui-droppable' );
            wp_enqueue_script( 'jquery-effects-core' );
            wp_enqueue_script( 'jquery-ui-resizable' );

            wp_enqueue_script( 'wp-mediaelement' );
            wp_enqueue_script( 'imagesloaded' ); // Need this for Masonry.
            wp_enqueue_script( 'jquery-masonry' );
            wp_enqueue_script( 't4p-builder-main-js', T4P_CORE_URI . 'assets/js/builder.all.min.js', array(  ), '1.0.0' );
            wp_enqueue_script( 't4p-builder-custome-js', T4P_CORE_URI . 'assets/js/custome.js', array(  ), '1.0.0' );
        }
    }

}
if (isset($_GET['t4ppb']) || isset($_POST['t4ppb'])) {
        $t4p_pb_active = true;
        define('T4P_Pb_ACTIVE', true);
    } else {
        $t4p_pb_active = false;
        define('T4P_Pb_ACTIVE', false);
    }
global $t4p_pb_front;
$t4p_pb_front = new T4P_Pb_Function();
?>