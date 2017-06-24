<div class='t4p_metabox'>
    <?php
    $this->evolve_select('width', __('Width (Content Columns for Featured Image)', 'evolve'), array('full' => 'Full Width', 'half' => 'Half Width'), ''
    );
	
    $this->evolve_select('sidebar', __('Show Sidebar', 'evolve'), array('no' => 'No', 'yes' => 'Yes'), ''
    );

    $this->evolve_select('sidebar_position', __('Page: Sidebar Position', 'evolve'), array('default' => 'Default', 'right' => 'Right', 'left' => 'Left'), ''
    );

    $this->evolve_select('project_desc_title', __('Show Project Description Title', 'evolve'), array('yes' => 'Yes', 'no' => 'No'), ''
    );

    $this->evolve_select('project_details', __('Show Project Details', 'evolve'), array('yes' => 'Yes', 'no' => 'No'), ''
    );

    $this->evolve_text('project_url', __('Project URL', 'evolve'), ''
    );

    $this->evolve_text('project_url_text', __('Project URL Text', 'evolve'), ''
    );

//    $this->evolve_text('fimg_width', 'Featured Image Width', '(in pixels or percentage, e.g.: 100% or 100px.  Or Use "auto" for automatic resizing if you added either width or height)'
//    );
//
//    $this->evolve_text('fimg_height', 'Featured Image Height', '(in pixels or percentage, e.g.: 100% or 100px.  Or Use "auto" for automatic resizing if you added either width or height)'
//    );
//
//    $this->evolve_select('image_rollover_icons', 'Image Rollover Icons', array('linkzoom' => 'Link + Zoom', 'link' => 'Link', 'zoom' => 'Zoom', 'no' => 'No Icons'), ''
//    );
//
//    $this->evolve_text('link_icon_url', 'Link Icon URL', 'Leave blank for post URL'
//    );
//
//    $this->evolve_select('link_icon_target', 'Open Link Icon URL In New Window', array('no' => 'No', 'yes' => 'Yes'), ''
//    );

    $this->evolve_select('related_posts', __('Show Related Posts', 'evolve'), array('default' => 'Default', 'yes' => 'Show', 'no' => 'Hide'), ''
    );
    ?>    
</div>