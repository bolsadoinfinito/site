<div class="t4p_metabox">
    <?php
    $this->evolve_select('slider_position', __('Slider Position', 'evolve'), array(
        'default' => __('Default', 'evolve'),
        'below' => __('Below', 'evolve'),
        'above' => __('Above', 'evolve')
            ), __('Select if the slider shows below or above the header. This only works for the slider assigned in page options, not with shortcodes.', 'evolve')
    );

    $this->evolve_select('slider_type', __('Slider Type', 'evolve'), array(
        'no' => __('No Slider', 'evolve'),
        'layer' => __('LayerSlider', 'evolve'),
        'rev' => __('Revolution Slider', 'evolve'),
        'flex' => __('Theme4Press Slider', 'evolve'),
        'parallax' => __('Parallax Slider', 'evolve'),
        'posts' => __('Posts Slider', 'evolve'),
        'bootstrap' => __('Bootstrap Slider', 'evolve')
            ), ''
    );

    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    if (is_plugin_active('LayerSlider/layerslider.php')) {
        global $wpdb;
        $slides_array[0] = __('Select a slider', 'evolve');
        // Table name
        $table_name = $wpdb->prefix . "layerslider";

        // Get sliders
        $sliders = $wpdb->get_results("SELECT * FROM $table_name
                                                                    WHERE flag_hidden = '0' AND flag_deleted = '0'
                                                                    ORDER BY date_c ASC");

        if (!empty($sliders)):
            foreach ($sliders as $key => $item):
                $slides[$item->id] = '';
            endforeach;
        endif;

        if (isset($slides) && $slides) {
            foreach ($slides as $key => $val) {
                $slides_array[$key] = 'LayerSlider #' . ( $key );
            }
        }
        $this->evolve_select('slider', __('Select LayerSlider', 'evolve'), $slides_array, ''
        );
    }

    global $wpdb;
    $revsliders[0] = __('Select a slider', 'evolve');
    if (function_exists('rev_slider_shortcode')) {
        $get_sliders = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'revslider_sliders');
        if ($get_sliders) {
            foreach ($get_sliders as $slider) {
                $revsliders[$slider->alias] = $slider->title;
            }
        }
    }
    $this->evolve_select('revslider', __('Select Revolution Slider', 'evolve'), $revsliders, ''
    );

    $slides_array = array();
    $slides = array();
    $slides_array[0] = __('Select a slider', 'evolve');
    $slides = get_terms('slide-page');
    if ($slides && !isset($slides->errors)) {
        $slides = is_array($slides) ? $slides : unserialize($slides);
        foreach ($slides as $key => $val) {
            $slides_array[$val->slug] = $val->name;
        }
    }
    $this->evolve_select('wooslider', __('Select Theme4Press Slider', 'evolve'), $slides_array, ''
    );
    ?>
</div>