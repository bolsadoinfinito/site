<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Recent_works' ) ) :

/**
 * Create Recent_works element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Recent_works extends T4P_Pb_Shortcode_Element {

        private $column;
        private $icon_permalink;
        private $image_size;
        private $link_icon_css;
        private $link_target;
        private $zoom_icon_css;
        private $recent_works_counter = 1;

	/**
	 * Constructor
	 *
	 * @return  void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Configure shortcode.
	 *
	 * @return  void
	 */
	public function element_config() {
		$this->config['shortcode']   = strtolower( __CLASS__ );
		$this->config['name']        = __( 'Recent Works', 't4p-core' );
		$this->config['cat']         = __( 'Post-Based', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-recent-works';
		$this->config['description'] = __( 'Add Recent Works', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(
		);

		// Use Ajax to speed up element settings modal loading speed
		$this->config['edit_using_ajax'] = true;
	}

	/**
	 * Define shortcode settings.
	 *
	 * @return  void
	 */
	public function element_items() {
		$this->items = array(
			'styling' => array(
                                array(
                                        'name'       => __( 'Layout', 't4p-core' ),
                                        'id'         => 'layout',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => 'carousel',
                                        'options'    => array(
                                                        'carousel'      => __( 'Carousel', 't4p-core' ),
                                                        'grid'   => __( 'Grid', 't4p-core' ),
                                                        'grid-with-excerpts'   => __( 'Grid with Excerpts', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'Select the layout for the shortcode', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Picture Size For Carousel Layout ', 't4p-core' ),
                                        'id'         => 'picture_size',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => 'fixed',
                                        'options'    => array(
                                                        'fixed'      => __( 'Fixed', 't4p-core' ),
                                                        'auto'   => __( 'Auto', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'fixed = width and height will be fixed
                                                            auto = width and height will adjust to the image.
                                                            only works with carousel layout.', 't4p-core' )
                                ),
                                array(
					'name'     => __( 'Show Filters', 't4p-core' ),
					'id'       => 'filters',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose to show or hide the category filters ', 't4p-core' ),
				),
                                array(
					'name'       => __( 'Columns', 't4p-core' ),
					'id'         => 'columns',
					'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '1',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_range( 4, false ),
                                        'tooltip'    => __( 'Select the number of columns to display', 't4p-core' ),
				),
                                array(
                                        'name'       => __( 'Categories', 't4p-core' ),
                                        'id'         => 'cat_slug',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '',
                                        'multiple'   => 'multiple',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_categories( 'portfolio_category' ),
                                        'tooltip'    => __( 'Select a category or leave blank for all', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Exclude Categories', 't4p-core' ),
                                        'id'         => 'exclude_cats',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '',
                                        'multiple'   => 'multiple',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_categories( 'portfolio_category' ),
                                        'tooltip'    => __( 'Select a category to exclude', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Number of Posts ', 't4p-core' ),
                                        'id'         => 'number_posts',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '4',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_range( 12, false ),
                                        'tooltip'    => __( 'Select the number of posts to display', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Excerpt Length', 't4p-core' ),
                                        'id'         => 'excerpt_length',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '35',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_range( 60, false ),
                                        'tooltip'    => __( 'Insert the number of words/characters you want to show in the excerpt', 't4p-core' )
                                ),
                                T4P_Pb_Helper_Type::get_animation_type(),
                                T4P_Pb_Helper_Type::get_animations_direction(),
                                T4P_Pb_Helper_Type::get_animation_speeds(),
			)
		);
	}

	/**
	 * Generate HTML code from shortcode content.
	 *
	 * @param   array   $atts     Shortcode attributes.
	 * @param   string  $content  Current content.
	 *
	 * @return  string
	 */
	public function element_shortcode_full( $atts = null, $content = null ) {
                global $smof_data, $evl_options, $arr_params, $theme_prefix;

                if ($theme_prefix == 'alora_') {
                    $theme_prefix = 't4p_';
                }

		$arr_params    = ( shortcode_atts( $this->config['params'], $atts ) );
                extract( $arr_params );

                $layout = ( ! $layout ) ? 'carousel' : $layout;
                $picture_size = ( ! $picture_size ) ? 'fixed' : $picture_size;
                $filters = ( ! $filters ) ? 'yes' : $filters;
                $columns = ( ! $columns ) ? 4 : $columns;
                $cat_slug = ( ! $cat_slug ) ? '' : $cat_slug;
                $exclude_cats = ( ! $exclude_cats ) ? '' : $exclude_cats;
                $number_posts = ( ! $number_posts ) ? 4 : $number_posts;
                $excerpt_length = ( ! $excerpt_length ) ? '35' : $excerpt_length;
                
                ( $filters == 'yes' ) ? ( $filters = true ) : ( $filters = false );

                // set the image size for the slideshow
                $this->set_image_size();

                if ($excerpt_length || $excerpt_length === '0') {
                    $excerpt_words = $excerpt_length;
                }

                if ($exclude_cats) {
                    $cats_to_exclude = explode(',', $exclude_cats);
                }
                $tax_query = '';
                if ($cat_slug) {
                    $cat_slugs = explode(',', $cat_slug);

                    if (isset($cats_to_exclude) && $cats_to_exclude) {

                        $tax_query = array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'portfolio_category',
                                'field' => 'slug',
                                'terms' => $cat_slugs,
                                'operator' => 'IN'
                            ),
                            array(
                                'taxonomy' => 'portfolio_category',
                                'field' => 'slug',
                                'terms' => $cats_to_exclude,
                                'operator' => 'NOT IN'
                            )
                        );
                    } else {

                        $tax_query = array(
                            array(
                                'taxonomy' => 'portfolio_category',
                                'field' => 'slug',
                                'terms' => $cat_slugs
                            )
                        );
                    }
                }
                
                $theme = wp_get_theme(); // gets the current theme
                if ('evolve Plus' == $theme->name || 'evolve Plus' == $theme->parent_theme) {
                    $args = array(
                        'post_type' => 'evolve_portfolio',
                        'paged' => 1,
                        'posts_per_page' => $number_posts,
                        'has_password' => false,
                        'tax_query' => $tax_query
                    );
                } else {
                    $args = array(
                        'post_type' => 'alora_portfolio',
                        'paged' => 1,
                        'posts_per_page' => $number_posts,
                        'has_password' => false,
                        'tax_query' => $tax_query
                    );
                }

                wp_reset_query();

                $recent_works = new WP_Query($args);

                $works = '';

                while ($recent_works->have_posts()) {
                    $recent_works->the_post();

                    $item_classes = $terms = $image_wrapper = $item_content = $buttons = $url = '';

                    // set classes, link and target for the image extras content
                    $this->set_image_extras(get_the_ID());

                    if ($layout == 'carousel') {
                        if (has_post_thumbnail()) {

                            if ($smof_data['image_rollover'] || $evl_options['evl_portfolio_rollover']) {
                                $image = get_the_post_thumbnail(get_the_ID(), $this->image_size);

                                $image .= $this->get_image_extras(get_the_ID());
                            } else {
                                $image = sprintf('<a href="%s">%s</a>', get_permalink(get_the_ID()), get_the_post_thumbnail(get_the_ID(), $this->image_size));
                            }

                            $works .= sprintf('<li><div class="image" aria-haspopup="true">%s</div></li>', $image);
                        }
                    } else {

                        if (has_post_thumbnail() || get_post_meta(get_the_ID(), $theme_prefix.'video', true)) {
                            $item_cats = get_the_terms(get_the_ID(), 'portfolio_category');
                            if ($item_cats) {
                                foreach ($item_cats as $item_cat) {
                                    $item_classes .= $item_cat->slug . ' ';
                                }
                            }

                            $permalink = get_permalink();

                            if (has_post_thumbnail()) {
                                $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $this->image_size);
                                $src = $thumbnail[0];
                                $alt = get_post_field('post_excerpt', get_post_thumbnail_id(get_the_ID()));

                                if ($smof_data['image_rollover'] || $evl_options['evl_portfolio_rollover']) {
                                    $image = "<img src='$src', alt='$alt' />";

                                    $image .= $this->get_image_extras(get_the_ID());
                                } else {
                                    $image = "<a href='$permalink'><img src='$src', alt='$alt' /></a>";
                                }

                                $image_wrapper = "<div class='image' aria-haspopup='true'>$image</div>";
                            }

                            if ($layout == 'grid-with-excerpts') {

                                $stripped_content = strip_shortcodes(t4p_content($excerpt_words, $smof_data['strip_html_excerpt']));

                                if ($columns == 1) {

                                    if (get_post_meta(get_the_ID(), $theme_prefix.'project_url', true)) {
                                        $url = sprintf('<a href="%s" class="t4p-button medium default">%s</a>', get_post_meta(get_the_ID(), $theme_prefix.'project_url', true), __('View Project', 't4p-core'));
                                    }

                                    $buttons = sprintf('<div class="buttons"><a href="%s" class="t4p-button medium default">%s</a>%s</div>', $permalink, __('Learn More', 't4p-core'), $url);
                                }

                                $item_content = sprintf('<div class="portfolio-content"><h2 class="entry-title"><a href="%s">%s</a></h2><h4>%s</h4>%s</div>', $permalink, get_the_title(), get_the_term_list(get_the_ID(), 'portfolio_category', '', '<span class="rw-comma">,</span> ', ''), $stripped_content);
                            }

                            $works .= "<div class='portfolio-item {$item_classes}'>{$image_wrapper}{$item_content}</div>";
                        }
                    }
                }
                wp_reset_query();

                    //html_attr
                    $html_class = sprintf('t4p-recent-works layout-%s', $layout);
                    $data_columns = '';
                    if ($layout == 'carousel') {
                        $html_class .= ' recent-works-carousel';
                        if ($picture_size == 'auto') {
                            $html_class .= ' picture-size-auto';
                        }
                    } else {
                        $html_class .= sprintf(' portfolio portfolio-%s', $this->column);

                        $data_columns = $this->column;
                    }
                    if ($layout == 'grid') {
                        $html_class .= ' portfolio-grid';
                    }
                    if ($layout == 'grid-with-excerpts') {
                        $html_class .= sprintf(' portfolio-%s-text', $this->column);
                    }

                if ($layout == 'carousel') {

                    $html = "<div class='$html_class' data-columns='$data_columns'><div class='es-carousel-wrapper t4p-carousel-large'><div class='es-carousel'><ul>$works</ul></div><div class='es-nav'><span class='es-nav-prev'></span><span class='es-nav-next'></span></div></div></div>";
                } else {

                    $portfolio_category = get_terms('portfolio_category');
                    $filter = '';
                    $filter_wrapper = '';

                    if ($portfolio_category && $filters == true) {

                        $filter = sprintf('<li class="active"><a href="#" data-filter="*">%s</a></li>', __('All', 't4p-core'));

                        foreach ($portfolio_category as $portfolio_cat) {
                            $portfolio_cat_slug = $portfolio_cat->slug;
                            $portfolio_cat_name = $portfolio_cat->name;
                            if (isset($cat_slug) && $cat_slug) {
                                $cat_slug = preg_replace('/\s+/', '', $cat_slug);
                                $cat_slugs = explode(',', $cat_slug);

                                if (in_array($portfolio_cat->slug, $cat_slugs)) {

                                    $filter .= "<li><a href='#' data-filter='.{$portfolio_cat_slug}'>$portfolio_cat_name</a></li>";
                                }
                            } else {

                                $filter .= "<li><a href='#' data-filter='.{$portfolio_cat_slug}'>$portfolio_cat_name</a></li>";
                            }
                        }

                        $filter_wrapper = sprintf('<ul class="portfolio-tabs">%s</ul>', $filter);
                    }

                    $html = "<div class='$html_class' data-columns='$data_columns'>$filter_wrapper<div class='portfolio-wrapper'>$works</div></div>";
                }

                $this->recent_works_counter++;
		
		return $this->element_wrapper( $html, $arr_params );
	}
        
        function set_image_size() {
            global $evl_options, $arr_params;

            $theme = wp_get_theme(); // gets the current theme
            if ('evolve Plus' == $theme->name || 'evolve Plus' == $theme->parent_theme) {
                //Carousel
                if ($arr_params['layout'] == 'carousel') {
                    $this->image_size = 'related-img';
                    if ($arr_params['picture_size'] == 'auto') {
                        $this->image_size = 'full';
                    }
                }

                //Grid Layout             
                if ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page portfolio-one-800';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page portfolio-two-800';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page portfolio-three-800';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page portfolio-four-800';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page portfolio-one-985';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page portfolio-two-985';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page portfolio-three-985';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page portfolio-four-985';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page portfolio-one-1600';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page portfolio-two-1600';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page portfolio-three-1600';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page portfolio-four-1600';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes') {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes') {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes') {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes') {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page';
                }

                //Grid Layout with Sidebar
                if ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page portfolio-one-sidebar-page portfolio-one-800';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page portfolio-two-sidebar-page portfolio-two-800';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page portfolio-three-sidebar-page portfolio-three-800';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page portfolio-four-sidebar-page portfolio-four-800';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page portfolio-one-sidebar-page portfolio-one-985';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page portfolio-two-sidebar-page portfolio-two-985';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page portfolio-three-sidebar-page portfolio-three-985';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page portfolio-four-sidebar-page portfolio-four-985';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page portfolio-one-sidebar-page portfolio-one-1600';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page portfolio-two-sidebar-page portfolio-two-1600';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page portfolio-three-sidebar-page portfolio-three-1600';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page portfolio-four-sidebar-page portfolio-four-1600';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no') {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page portfolio-four-sidebar-page';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no') {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page portfolio-three-sidebar-page';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no') {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page portfolio-two-sidebar-page';
                } elseif ($arr_params['layout'] == 'grid' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no') {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page portfolio-one-sidebar-page';
                }

                //Grid Text Layout
                if ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page portfolio-one-text portfolio-one-800';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page portfolio-two-text portfolio-two-800';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page portfolio-three-text portfolio-three-800';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page portfolio-four-text portfolio-four-800';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page portfolio-one-text portfolio-one-985';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page portfolio-two-text portfolio-two-985';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page portfolio-three-text portfolio-three-985';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page portfolio-four-text portfolio-four-985';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page portfolio-one-text portfolio-one-1600';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page portfolio-two-text portfolio-two-1600';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page portfolio-three-text portfolio-three-1600';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page portfolio-four-text portfolio-four-1600';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes') {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page portfolio-one-text';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes') {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page portfolio-two-text';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes') {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page portfolio-three-text';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'yes') {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page portfolio-four-text';
                }

                //Grid Text Layout with Sidebar			
                if ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page portfolio-one-text portfolio-one-sidebar-page-text portfolio-one-800';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page portfolio-two-text portfolio-two-sidebar-page-text portfolio-two-800';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page portfolio-three-text portfolio-three-sidebar-page-text portfolio-three-800';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 800) {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page portfolio-four-text portfolio-four-sidebar-page-text portfolio-four-800';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page portfolio-one-text portfolio-one-sidebar-page-text portfolio-one-985';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page portfolio-two-text portfolio-two-sidebar-page-text portfolio-two-985';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page portfolio-three-text portfolio-three-sidebar-page-text portfolio-three-985';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 985) {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page portfolio-four-text portfolio-four-sidebar-page-text portfolio-four-985';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page portfolio-one-text portfolio-one-sidebar-page-text portfolio-one-1600';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page portfolio-two-text portfolio-two-sidebar-page-text portfolio-two-1600';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page portfolio-three-text portfolio-three-sidebar-page-text portfolio-three-1600';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no' && $evl_options['evl_width_px'] == 1600) {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page portfolio-four-text portfolio-four-sidebar-page-text portfolio-four-1600';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 4 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no') {
                    $this->image_size = 'full';
                    $this->column = 'four portfolio-four-page portfolio-four-text portfolio-four-sidebar-page-text';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 3 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no') {
                    $this->image_size = 'full';
                    $this->column = 'three portfolio-three-page portfolio-three-text portfolio-three-sidebar-page-text';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 2 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no') {
                    $this->image_size = 'full';
                    $this->column = 'two portfolio-two-page portfolio-two-text portfolio-two-sidebar-page-text';
                } elseif ($arr_params['layout'] == 'grid-with-excerpts' && $arr_params['columns'] == 1 && get_post_meta(get_the_ID(), 'evolve_full_width', true) == 'no') {
                    $this->image_size = 'full';
                    $this->column = 'one portfolio-one-page portfolio-one-text portfolio-one-sidebar-page-text';
                }

            } else {
                if ($arr_params['layout'] == 'carousel') {
                    $this->image_size = 'related-img';
                    if ($arr_params['picture_size'] == 'auto') {
                        $this->image_size = 'full';
                    }
                } elseif ($arr_params['columns'] == 1) {
                    $this->image_size = 'full';
                    $this->column = 'one';
                } elseif ($arr_params['columns'] == 2) {
                    $this->image_size = 'portfolio-two';
                    $this->column = 'two';
                } elseif ($arr_params['columns'] == 3) {
                    $this->image_size = 'portfolio-three';
                    $this->column = 'three';
                } elseif ($arr_params['columns'] == 4) {
                    $this->image_size = 'portfolio-four';
                    $this->column = 'four';
                }
            }
        }

        function set_image_extras($id) {
            global $theme_prefix;

            if ($theme_prefix == 'alora_') {
                $theme_prefix = 't4p_';
            }

            if (get_post_meta($id, $theme_prefix.'image_rollover_icons', true) == 'link') {
                $this->link_icon_css = 'display:inline-block;';
                $this->zoom_icon_css = 'display:none;';
            } elseif (get_post_meta($id, $theme_prefix.'image_rollover_icons', true) == 'zoom') {
                $this->link_icon_css = 'display:none;';
                $this->zoom_icon_css = 'display:inline-block;';
            } elseif (get_post_meta($id, $theme_prefix.'image_rollover_icons', true) == 'no') {
                $this->link_icon_css = 'display:none;';
                $this->zoom_icon_css = 'display:none;';
            } else {
                $this->link_icon_css = 'display:inline-block;';
                $this->zoom_icon_css = 'display:inline-block;';
            }

            $this->link_target = '';
            $icon_url_check = get_post_meta($id, $theme_prefix.'link_icon_url', true);

            if (!empty($icon_url_check)) {
                $this->icon_permalink = get_post_meta($id, $theme_prefix.'link_icon_url', true);

                if (get_post_meta($is, $theme_prefix.'link_icon_target', true) == 'yes') {
                    $this->link_target = '_blank';
                }
            } else {
                $this->icon_permalink = get_permalink($id);
            }
        }

        function get_image_extras($id) {
            global $arr_params, $theme_prefix;

            if ($theme_prefix == 'alora_') {
                $theme_prefix = 't4p_';
            }

            $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
            if (get_post_meta($id, $theme_prefix.'video_url', true)) {
                $full_image[0] = get_post_meta($id, $theme_prefix.'video_url', true);
            }

            $terms = '';
            if ($arr_params['layout'] != 'carousel') {
                $terms = sprintf('<br /><h4>%s</h4>', get_the_term_list(get_the_ID(), 'portfolio_category', '', '<span class="rw-comma">,</span> ', ''));
            }
            
            //img_link_icon_attr
            $img_link_icon_class = 'icon link-icon';
            $img_link_icon_href = $this->icon_permalink;
            $img_link_icon_style = $this->link_icon_css;
            
            //img_zoom_icon_attr
            $img_zoom_icon_class = 'icon gallery-icon';
            $img_zoom_icon_href = $full_image[0];
            $img_zoom_icon_rel = sprintf('prettyPhoto[gallery_recent_%s]', $this->recent_works_counter);
            $img_zoom_icon_style = $this->zoom_icon_css;
            
            //img_h3_link_attr
            $img_h3_link_href = $this->icon_permalink;
            $img_h3_link_target = $this->link_target;
            
            $image_extras = "<div class='image-extras'><div class='image-extras-content recent-works-shortcode'><a class='$img_link_icon_class' href='$img_link_icon_href' style='$img_link_icon_style' ></a><a class='$img_zoom_icon_class' href='$img_zoom_icon_href' rel='$img_zoom_icon_rel' style='$img_zoom_icon_style' ></a><br /><h3 class='entry-title'><a href='$img_h3_link_href' target='$img_h3_link_target'>".get_the_title($id)."</a></h3>$terms</div></div>";
            
            return $image_extras;
        }
}

endif;
