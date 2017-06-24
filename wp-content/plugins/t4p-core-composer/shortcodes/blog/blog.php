<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Blog' ) ) :

/**
 * Create Alert element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Blog extends T4P_Pb_Shortcode_Element {

        private $post_count = 1;
        private $post_id = 0;
        private $post_month = null;
        private $header = array();
        private $query = '';
        public static $args;

	/**
	 * Constructor
	 *
	 * @return  void
	 */
	public function __construct() {

                // containers
                add_action('t4p_pb_blog_shortcode_before_loop', array($this, 'before_loop'));
                add_action('t4p_pb_blog_shortcode_before_loop_timeline', array($this, 'before_loop_timeline'));
                add_action('t4p_pb_blog_shortcode_after_loop', array($this, 'after_loop'));

                // post / loop basic structure
                add_action('t4p_pb_blog_shortcode_loop_header', array($this, 'loop_header'));
                add_action('t4p_pb_blog_shortcode_loop_footer', array($this, 'loop_footer'));
                add_action('t4p_pb_blog_shortcode_loop_content', array($this, 'loop_content'));
                add_action('t4p_pb_blog_shortcode_loop_content', array($this, 'page_links'));
                add_action('t4p_pb_blog_shortcode_loop', array($this, 'loop'));

                // special blog layout structure
                add_action('t4p_pb_blog_shortcode_wrap_loop_open', array($this, 'wrap_loop_open'));
                add_action('t4p_pb_blog_shortcode_wrap_loop_close', array($this, 'wrap_loop_close'));
                add_action('t4p_pb_blog_shortcode_date_and_format', array($this, 'date_and_format'));
                add_action('t4p_pb_blog_shortcode_timeline_date', array($this, 'timeline_date'));
                add_action('t4p_pb_blog_shortcode_entry_meta_alternate', array($this, 'entry_meta_alternate'));
                add_action('t4p_pb_blog_shortcode_entry_meta_grid_timeline', array($this, 'entry_meta_grid_timeline'));

                // loop footer content
                add_action('t4p_pb_blog_shortcode_entry_meta_default', array($this, 'entry_meta_default'));

		parent::__construct();
	}

	/**
	 * Configure shortcode.
	 *
	 * @return  void
	 */
	public function element_config() {
		$this->config['shortcode']   = strtolower( __CLASS__ );
		$this->config['name']        = __( 'Blog', 't4p-core' );
		$this->config['cat']         = __( 'Post-Based', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-blog';
		$this->config['description'] = __( 'Add Recent Posts', 't4p-core' );

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
                                        'name'       => __( 'Blog Layout', 't4p-core' ),
                                        'id'         => 'layout',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => 'large',
                                        'options'    => array(
                                                                'large'      => __( 'Large', 't4p-core' ),
                                                                'medium'   => __( 'Medium', 't4p-core' ),
                                                                'large alternate'   => __( 'Large Alternate', 't4p-core' ),
                                                                'medium alternate'   => __( 'Medium Alternate', 't4p-core' ),
                                                                'grid'   => __( 'Grid', 't4p-core' ),
                                                                'timeline'   => __( 'Timeline', 't4p-core' ),
                                                        ),
                                        'tooltip'    => __( 'Select the layout for the blog shortcode', 't4p-core' )
                                ),
                                array(
					'name'       => __( 'Posts Per Page', 't4p-core' ),
					'id'         => 'number_posts',
					'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_range( 25, true, true ),
                                        'tooltip'    => __( 'Select number of posts per page', 't4p-core' ),
				),
                                array(
                                        'name'       => __( 'Categories', 't4p-core' ),
                                        'id'         => 'cat_slug',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '',
                                        'multiple'   => 'multiple',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_categories( 'category' ),
                                        'tooltip'    => __( 'Select a category or leave blank for all', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Exclude Categories', 't4p-core' ),
                                        'id'         => 'exclude_cats',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '',
                                        'multiple'   => 'multiple',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_categories( 'category' ),
                                        'tooltip'    => __( 'Select a category to exclude', 't4p-core' )
                                ),
                                array(
					'name'     => __( 'Show Title', 't4p-core' ),
					'id'       => 'show_title',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Display the post title below the featured image', 't4p-core' ),
				),
                                array(
					'name'     => __( 'Link Title To Post', 't4p-core' ),
					'id'       => 'title_link',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose if the title should be a link to the single post page.', 't4p-core' ),
				),
                                array(
					'name'     => __( 'Show Thumbnail', 't4p-core' ),
					'id'       => 'thumbnail',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Display the post featured image', 't4p-core' ),
				),
                                array(
					'name'     => __( 'Show Excerpt', 't4p-core' ),
					'id'       => 'excerpt',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose to display the post excerpt', 't4p-core' ),
				),
                                array(
                                        'name'       => __( 'Number of words/characters in Excerpt', 't4p-core' ),
                                        'id'         => 'excerpt_length',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '35',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_range( 60, false ),
                                        'tooltip'    => __( 'Controls the excerpt length based on words or characters that is set in Theme Options > Extra.', 't4p-core' )
                                ),
                                array(
					'name'     => __( 'Show Meta Info', 't4p-core' ),
					'id'       => 'meta_all',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose to show all meta data', 't4p-core' ),
				),
                                array(
					'name'     => __( 'Show Author Name', 't4p-core' ),
					'id'       => 'meta_author',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose to show the author', 't4p-core' ),
				),
                                array(
					'name'     => __( 'Show Categories', 't4p-core' ),
					'id'       => 'meta_categories',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose to show the categories', 't4p-core' ),
				),
                                array(
					'name'     => __( 'Show Comment Count', 't4p-core' ),
					'id'       => 'meta_comments',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose to show the comments', 't4p-core' ),
				),
                                array(
					'name'     => __( 'Show Date', 't4p-core' ),
					'id'       => 'meta_date',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose to show the date', 't4p-core' ),
				),
                                array(
					'name'     => __( 'Show Read More Link', 't4p-core' ),
					'id'       => 'meta_link',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose to show the link', 't4p-core' ),
				),
                                array(
					'name'     => __( 'Show Tags', 't4p-core' ),
					'id'       => 'meta_tags',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose to show the tags', 't4p-core' ),
				),
                                array(
					'name'     => __( 'Show Pagination', 't4p-core' ),
					'id'       => 'paging',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Show numerical pagination boxes', 't4p-core' ),
				),
                                array(
                                        'name'       => __( 'Infinite Scrolling', 't4p-core' ),
                                        'id'         => 'scrolling',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => 'pagination',
                                        'options'    => array(
                                                                'pagination'   => __( 'pagination', 't4p-core' ),
                                                                'infinite'    => __( 'Infinite Scrolling', 't4p-core' )
                                                        ),
                                        'tooltip'    => __( 'Choose the type of scrolling', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Grid Layout # of Columns', 't4p-core' ),
                                        'id'         => 'blog_grid_columns',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '2',
                                        'options'    => array(
                                                                '2'   => __( '2', 't4p-core' ),
                                                                '3'   => __( '3', 't4p-core' ),
                                                                '4'   => __( '4', 't4p-core' )
                                                        ),
                                        'tooltip'    => __( 'Select whether to display the grid layout in 2, 3 or 4 column.', 't4p-core' )
                                ),
                                array(
					'name'     => __( 'Strip HTML from Posts Content', 't4p-core' ),
					'id'       => 'strip_html',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'  => __( 'Strip HTML from the post excerpt', 't4p-core' ),
				),
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
                global $arr_params;
		$arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
                extract( $arr_params );

                $layout = ( ! $layout ) ? 'large' : $layout;
                $number_posts = ( ! $number_posts ) ? '-1' : $number_posts;
                $cat_slug = ( ! $cat_slug ) ? '' : $cat_slug;
                $exclude_cats = ( ! $exclude_cats ) ? '' : $exclude_cats;
                $show_title = ( ! $show_title ) ? 'yes' : $show_title;
                $title_link = ( ! $title_link ) ? 'yes' : $title_link;
                $thumbnail = ( ! $thumbnail ) ? 'yes' : $thumbnail;
                $excerpt = ( ! $excerpt ) ? 'yes' : $excerpt;
                $excerpt_length = ( ! $excerpt_length ) ? '35' : $excerpt_length;
                $meta_all = ( ! $meta_all ) ? 'yes' : $meta_all;
                $meta_author = ( ! $meta_author ) ? 'yes' : $meta_author;
                $meta_categories = ( ! $meta_categories ) ? 'yes' : $meta_categories;
                $meta_comments = ( ! $meta_comments ) ? 'yes' : $meta_comments;
                $meta_date = ( ! $meta_date ) ? 'yes' : $meta_date;
                $meta_link = ( ! $meta_link ) ? 'yes' : $meta_link;
                $meta_tags = ( ! $meta_tags ) ? 'yes' : $meta_tags;
                $paging = ( ! $paging ) ? 'yes' : $paging;
                $scrolling = ( ! $scrolling ) ? 'pagination' : $scrolling;
                $blog_grid_columns = ( ! $blog_grid_columns ) ? '2' : $blog_grid_columns;
                $strip_html = ( ! $strip_html ) ? 'yes' : $strip_html;

        if ( is_front_page() || is_home() ) {
            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : ( ( get_query_var('page') ) ? get_query_var('page') : 1 );
        } else {
            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        }

        // covert all attributes to correct values for WP query		
        if ($number_posts) {
            $posts_per_page = $number_posts;
        }

        $nopaging = '';
        if ($posts_per_page == -1) {
            $nopaging = true;
        }

        ( $excerpt == "yes" ) ? ( $excerpt = true ) : ( $excerpt = false );
        ( $meta_all == "yes" ) ? ( $meta_all = true ) : ( $meta_all = false );
        ( $meta_author == "yes" ) ? ( $meta_author = true ) : ( $meta_author = false );
        ( $meta_categories == "yes" ) ? ( $meta_categories = true ) : ( $meta_categories = false );
        ( $meta_comments == "yes" ) ? ( $meta_comments = true) : ( $meta_comments = false );
        ( $meta_date == "yes" ) ? ( $meta_date = true ) : ( $meta_date = false );
        ( $meta_link == "yes" ) ? ( $meta_link = true ) : ( $meta_link = false );
        ( $meta_tags == "yes" ) ? ( $meta_tags = true ) : ( $meta_tags = false );
        ( $paging == "yes" ) ? ( $paging = true ) : ( $paging = false );
        ( $scrolling == "infinite" ) ? ( $paging = true ) : ( $paging = $paging );
        ( $strip_html == "yes" ) ? ( $strip_html = true ) : ( $strip_html = false );
        ( $thumbnail == "yes" ) ? ( $thumbnail = true ) : ( $thumbnail = false );
        ( $show_title == "yes" ) ? ( $show_title = true ) : ( $show_title = false );
        ( $title_link == "yes" ) ? ( $title_link = true ) : ( $title_link = false );

        //check for cats to exclude; needs to be checked via exclude_cats param and '-' prefixed cats on cats param
        //exclution via exclude_cats param 
        $cats_to_exclude = explode(',', $exclude_cats);
        $cats_id_to_exclude = $category__not_in = array();
        if ($cats_to_exclude) {
            foreach ($cats_to_exclude as $cat_to_exclude) {
                $id_obj = get_category_by_slug($cat_to_exclude);
                if ($id_obj) {
                    $cats_id_to_exclude[] = $id_obj->term_id;
                }
            }
            if ($cats_id_to_exclude) {
                $category__not_in = $cats_id_to_exclude;
            }
        }

        //setting up cats to be used and exclution using '-' prefix on cats param; transform slugs to ids
        $cat_ids = '';
        $categories = explode(',', $cat_slug);
        if ( isset($categories) && $categories ) {
            foreach ($categories as $category) {

                $id_obj = get_category_by_slug($category);

                if ($id_obj) {
                    if (strpos($category, '-') === 0) {
                        $cat_ids .= '-' . $id_obj->cat_ID . ',';
                    } else {
                        $cat_ids .= $id_obj->cat_ID . ',';
                    }
                }
            }
        }
        $cat = substr($cat_ids, 0, -1);

        $args = array(
                'paged' => $paged,
                'nopaging' => $nopaging,
                'posts_per_page' => $posts_per_page,
                'category__not_in' => $category__not_in,
                'cat' => $cat
        );

        $t4p_query = new WP_Query($args);

        $this->query = $t4p_query;

        //prepare needed wrapping containers
        $html = '';

        //blog-shortcode-attr
        $blog_layout = '';
        if ($layout == 'large alternate') {
            $blog_layout = 'large-alternate';
        } elseif ($layout == 'medium alternate') {
            $blog_layout = 'medium-alternate';
        } else {
            $blog_layout = $layout;
        }
        $attr_class = sprintf('t4p-blog-shortcode t4p-blog-%s t4p-blog-%s', $blog_layout, $scrolling);
        $html .= "<div class='$attr_class'>";

        //blog-shortcode-posts-container
        $post_container_class = sprintf('t4p-posts-container posts-container-%s', $scrolling);
        if ($layout == 'grid') {
            $post_container_class .= sprintf(' grid-layout grid-layout-%s', $blog_grid_columns);
        }
        $html .= "<div class='$post_container_class'>";

        ob_start();
        do_action('t4p_pb_blog_shortcode_wrap_loop_open');
        $wrap_loop_open = ob_get_contents();
        ob_get_clean();

        $html .= $wrap_loop_open;

        if ($layout == 'timeline') {
            $this->post_count = 1;

            $prev_post_timestamp = null;
            $prev_post_month = null;
            $first_timeline_loop = false;
        }

        //do the loop
        if ($t4p_query->have_posts()) : while ($t4p_query->have_posts()) : $t4p_query->the_post();

                $this->post_id = get_the_ID();

                if ($layout == 'timeline') {
                    $post_timestamp = strtotime(get_the_date());
                    $this->post_month = date('n', $post_timestamp);
                    $post_year = get_the_date('o');
                    $current_date = get_the_date('o-n');

                    $date_params['prev_post_month'] = $prev_post_month;
                    $date_params['post_month'] = $this->post_month;

                    ob_start();
                    do_action('t4p_pb_blog_shortcode_timeline_date', $date_params);

                    do_action('t4p_pb_blog_shortcode_before_loop_timeline');
                    $before_loop_timeline_action = ob_get_contents();
                    ob_get_clean();

                    $html .= $before_loop_timeline_action;
                } else {

                    ob_start();
                    do_action('t4p_pb_blog_shortcode_before_loop');
                    $before_loop_action = ob_get_contents();
                    ob_get_clean();

                    $html .= $before_loop_action;
                }

                if ($layout == 'grid' ||
                        $layout == 'timeline'
                ) {
                    $html .= "<div class='post-content-wrapper'>";
                }

                $this->header = array(
                    'title_link' => true,
                );

                ob_start();
                do_action('t4p_pb_blog_shortcode_loop_header');

                do_action('t4p_pb_blog_shortcode_loop_content');

                do_action('t4p_pb_blog_shortcode_loop_footer');

                do_action('t4p_pb_blog_shortcode_after_loop');
                $loop_actions = ob_get_contents();
                ob_get_clean();

                $html .= $loop_actions;

                if ( $layout == 'grid' || $layout == 'timeline' ) {
                    $html .= '</div>';
                }

                if ( $layout == 'timeline' ) {
                    $prev_post_timestamp = $post_timestamp;
                    $prev_post_month = $this->post_month;
                    $this->post_count++;
                }

            endwhile;
        else:
        endif;
		
		wp_reset_query();				

        ob_start();
        do_action('t4p_pb_blog_shortcode_wrap_loop_close');

        $wrap_loop_close_action = ob_get_contents();
        ob_get_clean();

        $html .= $wrap_loop_close_action;

        $html .= '</div>';

        if ($arr_params['paging']) {
            ob_start();
            t4p_pagination($this->query->max_num_pages, $range = 2, $this->query);
            $pagination = ob_get_contents();
            ob_get_clean();

            $html .= $pagination;
        }

        $html .= '</div>';

	return $this->element_wrapper( $html, $arr_params );
	}

        function wrap_loop_open() {
            global $arr_params;

            $wrapper = '';

            if ($arr_params['layout'] == 'timeline') {

                $wrapper .= "<div class='blog-timeline-layout'>";
            }

            echo $wrapper;
        }

    // end wrap_loop_open()

        function wrap_loop_close() {
            global $arr_params;

            $wrapper = '';

            if ($arr_params['layout'] == 'timeline') {
                $wrapper = '<div class="t4p-clearfix"></div>';
                $wrapper .= '</div>';
            }

            if ( $arr_params['layout'] == 'grid' || $arr_params['layout'] == 'timeline' ) {
                $wrapper .= '<div class="t4p-clearfix"></div>';
            }

            echo $wrapper;
        }

    // end wrap_loop_close()

        function before_loop() {
            global $arr_params;
            
            //loop_attr
            $defaults = array(
                'post_id' => '',
                'post_count' => '',
            );

            $args['post_id'] = $this->post_id;
            $args['post_count'] = $this->post_count;

            $args = wp_parse_args($args, $defaults);

            $post_id = $args['post_id'];

            $post_count = $args['post_count'];

            $loop_attr_id = 'post-' . $post_id;

            $extra_classes = array();

            if ($arr_params['layout'] == 'medium') {
                $extra_classes[] = 'blog-medium';
            }

            if ($arr_params['layout'] == 'medium alternate') {
                $extra_classes[] = 'blog-medium-alternate';
            }

            if ($arr_params['layout'] == 'large') {
                $extra_classes[] = 'blog-large';
            }

            if ($arr_params['layout'] == 'large alternate') {
                $extra_classes[] = 'blog-large-alternate';
            }

            if ($arr_params['layout'] == 'grid') {

                $column_width = 12 / $arr_params['blog_grid_columns'];

                $extra_classes[] = 'blog-grid';
                $extra_classes[] = sprintf('col-lg-%s col-md-%s col-sm-%s', $column_width, $column_width, $column_width);
            }

            if ($arr_params['layout'] == 'timeline') {

                if (( $post_count % 2 ) > 0) {
                    $timeline_align = ' timeline-align-left';
                } else {
                    $timeline_align = ' timeline-align-right';
                }

                $extra_classes[] = 'blog-timeline t4p-clearfix';
                $extra_classes[] = 'col-lg-5 col-md-5 col-sm-5' . $timeline_align;
            }

            $post_class = get_post_class($extra_classes, $post_id);

            if ($post_class && is_array($post_class)) {

                $classes = implode(' ', get_post_class($extra_classes, $post_id));
                $loop_attr_class = $classes;
            }
            
            $loop_attr_itemtype = '';
            $loop_attr_itemprop = '';
            if (current_theme_supports('t4p-schema')) {
                $loop_attr_itemtype = 'http://schema.org/BlogPosting';
                $loop_attr_itemprop = 'blogPost';
            }

            echo "<div id='$loop_attr_id' class='$loop_attr_class' itemtype='$loop_attr_itemtype' itemprop='$loop_attr_itemprop'> \n";
        }

    // end before_loop()

        function before_loop_timeline($args) {
            global $arr_params;
            //loop_attr
            $defaults = array(
                'post_id' => '',
                'post_count' => '',
            );

            $args['post_id'] = $this->post_id;
            $args['post_count'] = $this->post_count;

            $args = wp_parse_args($args, $defaults);

            $post_id = $args['post_id'];

            $post_count = $args['post_count'];

            $loop_attr_id = 'post-' . $post_id;

            $extra_classes = array();

            if ($arr_params['layout'] == 'medium') {
                $extra_classes[] = 'blog-medium';
            }

            if ($arr_params['layout'] == 'medium alternate') {
                $extra_classes[] = 'blog-medium-alternate';
            }

            if ($arr_params['layout'] == 'large') {
                $extra_classes[] = 'blog-large';
            }

            if ($arr_params['layout'] == 'large alternate') {
                $extra_classes[] = 'blog-large-alternate';
            }

            if ($arr_params['layout'] == 'grid') {

                $column_width = 12 / $arr_params['blog_grid_columns'];

                $extra_classes[] = 'blog-grid';
                $extra_classes[] = sprintf('col-lg-%s col-md-%s col-sm-%s', $column_width, $column_width, $column_width);
            }

            if ($arr_params['layout'] == 'timeline') {

                if (( $post_count % 2 ) > 0) {
                    $timeline_align = ' timeline-align-left';
                } else {
                    $timeline_align = ' timeline-align-right';
                }

                $extra_classes[] = 'blog-timeline t4p-clearfix';
                $extra_classes[] = 'col-lg-5 col-md-5 col-sm-5' . $timeline_align;
            }

            $post_class = get_post_class($extra_classes, $post_id);

            if ($post_class && is_array($post_class)) {

                $classes = implode(' ', get_post_class($extra_classes, $post_id));
                $loop_attr_class = $classes;
            }
            
            $loop_attr_itemtype = '';
            $loop_attr_itemprop = '';
            if (current_theme_supports('t4p-schema')) {
                $loop_attr_itemtype = 'http://schema.org/BlogPosting';
                $loop_attr_itemprop = 'blogPost';
            }

            echo "<div id='$loop_attr_id' class='$loop_attr_class' itemtype='$loop_attr_itemtype' itemprop='$loop_attr_itemprop'> \n";

        }

    // end before_loop_timeline()

        function after_loop() {

            echo '</div>' . "\n";
        }

    // end after_loop()

        function get_slideshow() {
            global $arr_params, $smof_data, $theme_prefix;

            $html = '';

            $slideshow = array(
                'images' => $this->get_post_thumbnails(get_the_ID(), $smof_data['posts_slideshow_number'])
            );

            if (get_post_meta($this->post_id, $theme_prefix.'video', true)) {
                $slideshow['video'] = get_post_meta($this->post_id, $theme_prefix.'video', true);
            }

            if ( $arr_params['layout'] == 'medium' || $arr_params['layout'] == 'medium alternate' ) {

                if ($arr_params['layout'] == 'medium_alternate') {
                    ob_start();
                    do_action('t4p_pb_blog_shortcode_date_and_format');
                    $date_and_format_action = ob_get_contents();
                    ob_get_clean();

                    $html .= $date_and_format_action;
                }

                $slideshow['size'] = 'blog-medium';

                $html .= "<div class='blog-medium-slideshow-container'>";

                ob_start();
                $atts = $arr_params;
                if ($smof_data['legacy_posts_slideshow']) {
                    include(locate_template('legacy-slideshow-blog-shortcode.php', false));
                } else {
                    include(locate_template('new-slideshow-blog-shortcode.php', false));
                }
                $post_slideshow_action = ob_get_contents();
                ob_get_clean();

                $html .= $post_slideshow_action;

                $html .= '</div>';
            } else {
                ob_start();
                $atts = $arr_params;
                if ($smof_data['legacy_posts_slideshow']) {
                    include(locate_template('legacy-slideshow-blog-shortcode.php', false));
                } else {
                    include(locate_template('new-slideshow-blog-shortcode.php', false));
                }
                $post_slideshow_action = ob_get_contents();
                ob_get_clean();

                $html .= $post_slideshow_action;
            }

            return $html;
        }

    // end get_slideshow()

        function get_post_thumbnails($post_id, $count = '') {
            global $arr_params, $smof_data;

            $attachment_ids = array();

            if (get_post_thumbnail_id($post_id)) {
                $attachment_ids[] = get_post_thumbnail_id($post_id);
            }

            if ($smof_data['posts_slideshow']) {
                $i = 2;
                while ($i <= $smof_data['posts_slideshow_number']) {

                    if (kd_mfi_get_featured_image_id('featured-image-' . $i, 'post')) {
                        $attachment_ids[] = kd_mfi_get_featured_image_id('featured-image-' . $i, 'post');
                    }

                    $i++;
                }
            }

            if (isset($count) && $count >= 1) {
                $attachment_ids = array_slice($attachment_ids, 0, $count);
            }

            return $attachment_ids;
        }

    // end get_post_thumbnails()

        function loop_header() {
            global $arr_params;
            $defaults = array(
                'title_link' => false,
            );

            $args = wp_parse_args($this->header, $defaults);

            $pre_title_content = '';
            $meta_data = '';
            $content_sep = '';
            $link = '';


            if ($arr_params['thumbnail'] && $arr_params['layout'] != 'medium alternate') {
                $pre_title_content = $this->get_slideshow();
            }

            if ($arr_params['layout'] == 'large' || $arr_params['layout'] == 'large alternate') {
                ob_start();
                do_action('t4p_pb_blog_shortcode_entry_meta_alternate');
                $meta_data = ob_get_contents();
                ob_get_clean();
            }

            if ($arr_params['layout'] == 'medium alternate' || $arr_params['layout'] == 'large alternate') {
                ob_start();
                do_action('t4p_pb_blog_shortcode_date_and_format');
                $pre_title_content .= ob_get_contents();
                ob_get_clean();

                if ($arr_params['thumbnail'] && $arr_params['layout'] == 'medium alternate') {
                    $pre_title_content .= $this->get_slideshow();
                }


                if ($arr_params['meta_all'] && !$arr_params['layout'] == 'medium alternate') {
                    ob_start();
                    do_action('t4p_pb_blog_shortcode_entry_meta_alternate');
                    $meta_data = ob_get_contents();
                    ob_get_clean();
                }
            }

            if ($arr_params['layout'] == 'grid' || $arr_params['layout'] == 'timeline') {
                if ((!$arr_params['meta_all'] && $arr_params['excerpt_length'] == '0' ) ||
                        (!$arr_params['meta_author'] && !$arr_params['meta_date'] && !$arr_params['meta_categories'] && !$arr_params['meta_tags'] && !$arr_params['meta_comments'] && !$arr_params['meta_link'] && $arr_params['excerpt_length'] == '0' )
                ) {
                    $content_sep = "<div class='no-content-sep'></div>";
                } else {
                    $content_sep = "<div class='content-sep'></div>";
                }

                if ($arr_params['meta_all']) {
                    ob_start();
                    do_action('t4p_pb_blog_shortcode_entry_meta_grid_timeline');
                    $meta_data = ob_get_contents();
                    ob_get_clean();
                }
            }

            $pre_title_content .= "<div class='post-content-container'>";

            if ($arr_params['show_title']) {
                if ($arr_params['title_link']) {
                    $link = sprintf('<a href="%s">%s</a>', get_permalink(), get_the_title());
                } else {
                    $link = get_the_title();
                }
            }

            if ($arr_params['layout'] == 'timeline') {
                $pre_title_content .= "<div class='timeline-circle'></div><div class='timeline-arrow'></div>";
            }
            
            $itemprop = '';
            if (current_theme_supports('t4p-schema')) {
                $itemprop = 'headline';
            }
            $html = "{$pre_title_content}<h2 class='entry-title' itemprop='$itemprop'>{$link}</h2>{$meta_data}{$content_sep}";

            echo $html;
        }

    // end loop_header()

        function loop_footer() {
            global $arr_params;
            if ($arr_params['meta_all'] && ($arr_params['layout'] == 'medium' || $arr_params['layout'] == 'medium alternate')) {
                do_action('t4p_pb_blog_shortcode_entry_meta_alternate');
            }

            if ($arr_params['meta_all'] && ($arr_params['layout'] == 'medium' || $arr_params['layout'] == 'large')) {
                do_action('t4p_pb_blog_shortcode_entry_meta_default');
            }

            if ($arr_params['meta_all'] && ($arr_params['layout'] == 'large alternate' || $arr_params['layout'] == 'grid' || $arr_params['layout'] == 'timeline')) {
                echo $this->read_more();
            }

            if ($arr_params['meta_all'] && ($arr_params['layout'] == 'grid' || $arr_params['layout'] == 'timeline')) {
                echo $this->grid_timeline_comments();
                echo '<div class="t4p-clearfix"></div>';
            }

            echo '</div>';
            echo '<div class="t4p-clearfix"></div>';

            if ($arr_params['meta_all'] && $arr_params['layout'] == 'medium alternate') {
                echo $this->read_more();
            }
        }

    // end loop_footer()

        function date_and_format() {
            global $arr_params, $smof_data;

            $inner_content = "<div class='date-and-formats'>";
            $inner_content .= "<div class='date-box updated'>";

            $inner_content .= sprintf('<span class="date">%s</span>', get_the_time($smof_data['alternate_date_format_day']));
            $inner_content .= sprintf('<span class="month-year">%s</span>', get_the_time($smof_data['alternate_date_format_month_year']));

            switch (get_post_format()) {
                case 'gallery':
                    $format_class = 'camera-retro';
                    break;
                case 'link':
                    $format_class = 'link';
                    break;
                case 'image':
                    $format_class = 'picture-o';
                    break;
                case 'quote':
                    $format_class = 'quote-left';
                    break;
                case 'video':
                    $format_class = 'youtube-play';
                    break;
                case 'audio':
                    $format_class = 'headphones';
                    break;
                case 'chat':
                    $format_class = 'comments-o';
                    break;
                default:
                    $format_class = 'pencil';
                    break;
            }

            $inner_content .= "</div><div class='format-box'><i class=t4p-icon-$format_class></i></div></div>";

            echo $inner_content;
        }

    // end add_date_and_format()

        function timeline_date($date_params) {
            global $arr_params, $smof_data;

            $defaults = array(
                'prev_post_month' => null,
                'post_month' => 'null'
            );

            $args = wp_parse_args($date_params, $defaults);
            $inner_content = '';

            if ($args['prev_post_month'] != $args['post_month']) {
                $inner_content = sprintf('<div class="timeline-date hidden-div"><h3 class="timeline-title" style="font-size:13px !important; padding: 0px 5px;">%s</h3></div>', get_the_date($smof_data['timeline_date_format']));
            }

            echo $inner_content;
        }

    // end timeline_date()

        function entry_meta_default() {
            global $arr_params;

            $inner_content = '';
            $inner_content .= $this->read_more();

            $theme = wp_get_theme(); // gets the current theme
            if ('evolve Plus' == $theme->name || 'evolve Plus' == $theme->parent_theme) {
                if ($arr_params['layout'] == 'large') {
                    if ($arr_params['meta_categories']) {

                        $categories = get_the_category();
                        $no_of_categories = count($categories);
                        $separator = ', ';
                        $output = ' ';
                        $count = 1;

                        foreach ($categories as $category) {

                            $output .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"), $category->name)) . '">' . $category->cat_name . '</a>';

                            if ($count < $no_of_categories) {
                                $output .= $separator;
                            }

                            $count++;
                        }

                        $inner_content .= sprintf('<span class="entry-categories">%s</span><span class="meta-separator">|</span>', $output);
                    }
                    if ($arr_params['meta_tags']) {
                        $inner_content .= sprintf('%s<span class="meta-separator">|</span>', $this->post_meta_tags());
                    }
                }
            }

            //blog-shortcode-entry-meta    
            if ($arr_params['layout'] == 'grid' || $arr_params['layout'] == 'timeline') {
                $blog_shortcode_entry_meta = 'entry-meta-single';
            } else {
                $blog_shortcode_entry_meta = 'entry-meta';
            }
            $entry_meta = "<div class='t4p-clearfix'></div><div class='$blog_shortcode_entry_meta'>{$inner_content}</div>";

            echo $entry_meta;
        }

    // end entry_meta_default()

        function entry_meta_alternate() {
            global $arr_params;
            $inner_content = $this->post_meta_data(true);

            //blog-shortcode-entry-meta    
            if ($arr_params['layout'] == 'grid' || $arr_params['layout'] == 'timeline') {
                $blog_shortcode_entry_meta = 'entry-meta-single';
            } else {
                $blog_shortcode_entry_meta = 'entry-meta';
            }
            $entry_meta = "<div class='$blog_shortcode_entry_meta'>$inner_content</div>";

            echo $entry_meta;
        }

    // end entry_meta_alternate()

        function entry_meta_grid_timeline() {
            global $arr_params;
            $inner_content = $this->post_meta_data(false);

            //blog-shortcode-entry-meta    
            if ($arr_params['layout'] == 'grid' || $arr_params['layout'] == 'timeline') {
                $blog_shortcode_entry_meta = 'entry-meta-single';
            } else {
                $blog_shortcode_entry_meta = 'entry-meta';
            }
            $entry_meta = "<div class='$blog_shortcode_entry_meta'>$inner_content</div>";

            echo $entry_meta;
        }

    // end entry_meta_grid_timeline()

        function post_meta_data($return_all_meta = false) {
            global $arr_params, $smof_data;

            $inner_content = "<p class='entry-meta-details'>";

            $theme = wp_get_theme(); // gets the current theme

                $meta_time = get_the_modified_time('c');

                //meta_date_attr
                $meta_date_class = 'published';
                $meta_date_datetime = '';
                if (current_theme_supports('t4p-schema')) {
                    $meta_date_datetime = get_the_time('c');
                }

                $meta_date = get_the_time(get_option( 'date_format' ));

                //blog-shortcode-meta-author
                $meta_author_class = 'entry-author fn';
                $meta_author_itemprop = '';
                $meta_author_itemscope = '';
                $meta_author_itemtype = '';
                if (current_theme_supports('t4p-schema')) {
                    $meta_author_itemprop = 'author';
                    $meta_author_itemscope = 'itemscope';
                    $meta_author_itemtype = 'http://schema.org/Person';
                }

                //meta_author_link_attr       
                $meta_author_link_href = get_author_posts_url(get_the_author_meta('ID'));
                $meta_author_link_itemprop = '';
                $meta_author_link_rel = '';
                if (current_theme_supports('t4p-schema')) {
                    $meta_author_link_itemprop = 'url';
                    $meta_author_link_rel = 'author';
                }

                $meta_author = get_the_author_meta('display_name');

            if ('evolve Plus' == $theme->name || 'evolve Plus' == $theme->parent_theme) {
                if ($arr_params['meta_date']) {
                    $inner_content .= "<span class='entry-time'><span class='updated' style='display:none;'>$meta_time</span><time class='$meta_date_class'>$meta_date</time></span><span class='meta-separator'>|</span>";
                }

                if ($arr_params['meta_author']) {
                    $inner_content .= "<span class='$meta_author_class' itemprop='$meta_author_itemprop' itemscope='$meta_author_itemscope' itemtype='$meta_author_itemtype'>" . __('Written By', 't4p-core') . " <a href='$meta_author_link_href' itemprop='$meta_author_link_itemprop' rel='$meta_author_link_rel'>$meta_author</a>" . "</span><span class='meta-separator'>|</span>";
                }

                if ($arr_params['layout'] != 'grid' && $arr_params['layout'] != 'timeline') {
                    if ($arr_params['meta_comments']) {

                            ob_start();
                            comments_popup_link(__('0 Comments', 't4p-core'), __('1 Comment', 't4p-core'), __('% Comments', 't4p-core'));
                            $comments = ob_get_contents();
                            ob_get_clean();

                            $inner_content .= sprintf('<span class="entry-comments">%s</span><span class="meta-separator">|</span>', $comments);
                    }
                }
            } else {
                if ($arr_params['meta_author']) {
                    $inner_content .= "<span class='$meta_author_class' itemprop='$meta_author_itemprop' itemscope='$meta_author_itemscope' itemtype='$meta_author_itemtype'>" . __('By', 't4p-core') . " <a href='$meta_author_link_href' itemprop='$meta_author_link_itemprop' rel='$meta_author_link_rel'>$meta_author</a>" . "</span><span class='meta-separator'>|</span>";
                }

                if ($arr_params['meta_date']) {
                    $inner_content .= "<span class='entry-time'><span class='updated' style='display:none;'>$meta_time</span><time class='$meta_date_class'>".get_the_time($smof_data['date_format'])."</time></span><span class='meta-separator'>|</span>";
                }
            }

            if ($return_all_meta) {
                $theme = wp_get_theme(); // gets the current theme
                if ('evolve Plus' == $theme->name || 'evolve Plus' == $theme->parent_theme) {
                    if ($arr_params['layout'] == 'medium') {
                        if ($arr_params['meta_categories']) {

                            $categories = get_the_category();
                            $no_of_categories = count($categories);
                            $separator = ', ';
                            $output = __('Categories:', 't4p-core') . ' ';
                            $count = 1;

                            foreach ($categories as $category) {

                                $output .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"), $category->name)) . '">' . $category->cat_name . '</a>';

                                if ($count < $no_of_categories) {
                                    $output .= $separator;
                                }

                                $count++;
                            }

                            $inner_content .= "<span class='entry-categories'>$output</span><span class='meta-separator'>|</span>";
                            
                        }
                    }
                } else {

                    if ($arr_params['meta_categories']) {

                        $categories = get_the_category();
                        $no_of_categories = count($categories);
                        $separator = ', ';
                        $output = __('Categories:', 't4p-core') . ' ';
                        $count = 1;

                        foreach ($categories as $category) {

                            $output .= '<a href="' . get_category_link($category->term_id) . '" title="' . esc_attr(sprintf(__("View all posts in %s"), $category->name)) . '">' . $category->cat_name . '</a>';

                            if ($count < $no_of_categories) {
                                $output .= $separator;
                            }

                            $count++;
                        }

                        $inner_content .= "<span class='entry-categories'>$output</span><span class='meta-separator'>|</span>";
                    }
                }

                $theme = wp_get_theme(); // gets the current theme
                if ('evolve Plus' == $theme->name || 'evolve Plus' == $theme->parent_theme) {

                } else {
                    if ($arr_params['meta_tags']) {
                        $inner_content .= sprintf('%s<span class="meta-separator">|</span>', $this->post_meta_tags());
                    }
                    if ($arr_params['meta_comments']) {

                        ob_start();
                        comments_popup_link(__('0 Comments', 't4p-core'), __('1 Comment', 't4p-core'), __('% Comments', 't4p-core'));
                        $comments = ob_get_contents();
                        ob_get_clean();

                        $inner_content .= sprintf('<span class="entry-comments">%s</span><span class="meta-separator">|</span>', $comments);
                    }
                }
            }

            $inner_content .= '</p>';

            return $inner_content;
        }

    // end post_meta_data()

        function grid_timeline_comments() {
            global $arr_params;
            if ($arr_params['meta_comments']) {

                $comments_icon = "<i class='t4p-icon-comment'></i>&nbsp";
                ob_start();
                comments_popup_link($comments_icon . __('0', 't4p-core'), $comments_icon . __('1', 't4p-core'), $comments_icon . __('%', 't4p-core'));
                $comments = ob_get_contents();
                ob_get_clean();

                $inner_content = sprintf('<span class="comment-number">%s</span>', $comments);

                return $inner_content;
            }
        }

    // end grid_timeline_comments()

        function post_meta_tags() {
            global $arr_params;
            $theme = wp_get_theme(); // gets the current theme
            if ('evolve Plus' == $theme->name || 'evolve Plus' == $theme->parent_theme) {
                    if( has_tag() ) {
                            $inner_content = '';			
                            if ($arr_params['meta_tags']) {
                                    ob_start();
                                    echo ' ';
                                    the_tags('');
                                    $tags = ob_get_contents();
                                    ob_get_clean();
                                    $inner_content = sprintf('<span class="meta-tags">%s</span>', $tags);
                            }
                            return $inner_content;
                    }
            } else {
            $inner_content = '';			
                    if ($arr_params['meta_tags']) {

                        ob_start();
                        echo __('Tags:', 't4p-core') . ' ';
                        the_tags('');
                        $tags = ob_get_contents();
                        ob_get_clean();

                        $inner_content = sprintf('<span class="meta-tags">%s</span>', $tags);
                    }
                    return $inner_content;
            }
        }

    // end post_meta_tags()	

        function read_more() {
            global $arr_params;
            if ($arr_params['meta_link']) {
                $inner_content = '';

                    $inner_content .= "<p class='entry-read-more'>";
                    $btn_text = __('Read More', 't4p-core');
                    $link = get_permalink();
                    $inner_content .= "<a class='read-more btn t4p-button-default' href='$link'>$btn_text</a>";
                    $inner_content .= '</p>';

                return $inner_content;
            }
        }

    // end read_more()

        function loop_content() {
            global $arr_params;
            // get the post content according to the chosen kind of delivery
            if ($arr_params['excerpt']) {
                $content = t4p_content($arr_params['excerpt_length'], $arr_params['strip_html']);
            } else {
                $content = get_the_content();
                $content = apply_filters('the_content', $content);
                $content = str_replace(']]>', ']]&gt;', $content);
            }

            echo $content;
        }

    // end loop_content()

        function page_links() {

            wp_link_pages(array('before' => '<div id="page-links"><p>' . __('<strong>Pages:</strong>', 't4p-core'), 'after' => '</p></div>'));

        }

    // end page_links()
}

endif;
