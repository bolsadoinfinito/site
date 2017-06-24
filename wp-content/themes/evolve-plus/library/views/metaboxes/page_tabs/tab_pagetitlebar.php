<div class="t4p_metabox">
    <?php
    $this->evolve_select('page_title', __('Page Title / Breadcrumbs / Page Title Bar', 'evolve'), array(
        'titlebar_breadcrumb' => __('Title + Breadcrumb', 'evolve'),
        'titlebar' => __('Only Title', 'evolve'),
        'breadcrumb' => __('Only Breadcrumb', 'evolve'),
        'none' => __('None', 'evolve'),
        'default' => __('Default', 'evolve'),
            ), ''
    );

    $this->evolve_text('page_title_bar_bg_color', __('Page Title Bar Background Color (Hex Code)', 'evolve'), '');

    $this->evolve_upload('page_title_bar_bg', __('Page Title Bar Background', 'evolve'));

    $this->evolve_upload('page_title_bar_bg_retina', __('Page Title Bar Background Retina', 'evolve'));

    $this->evolve_select('page_title_bar_full_bg', __('100% Background Image', 'evolve'), array(
        'default' => __('Default', 'evolve'),
        'yes' => __('Show', 'evolve'),
        'no' => __('Hide', 'evolve'),
            ), ''
    );

    $this->evolve_select('page_title_bar_parallax_bg', __('Parallax Background Image', 'evolve'), array(
        'default' => __('Default', 'evolve'),
        'yes' => __('Show', 'evolve'),
        'no' => __('Hide', 'evolve'),
            ), ''
    );
    ?>
</div>
