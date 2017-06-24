<!--rename this file page_options.php to tab_page_portfolio.php-->
<!--this is actual page portfolio file-->
<div class="t4p_metabox">
    <p><b><?php _e('Note: Portfolio options override all Layout options and work for only portfolio template','evolve'); ?></b></p>
    <?php
    $this->evolve_select('portfolio_full_width', __('Portfolio: Full Width', 'evolve'), array(
        'yes' => __('Yes', 'evolve'),
        'no' => __('No', 'evolve')
            ), ''
    );

    $this->evolve_select('portfolio_sidebar_position', 'Portfolio: Sidebar Position', array(
        'right' => __('Right', 'evolve'),
        'left' => __('Left', 'evolve')
            ), ''
    );

    $types = get_terms('portfolio_category', 'hide_empty=0');
    $types_array[0] = 'All categories';
    if ($types) {
        foreach ($types as $type) {
            $types_array[$type->term_id] = $type->name;
        }
        $this->evolve_multiple('portfolio_category', __('Portfolio Type', 'evolve'), $types_array, __('Choose what portfolio category you want to display on this page. Leave blank for all categories.', 'evolve')
        );
    }

    $this->evolve_select('portfolio_filters', __('Show Portfolio Filters', 'evolve'), array(
        'yes' => __('Show', 'evolve'),
        'no' => __('Hide', 'evolve')
            ), ''
    );
    ?>
</div>