<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Postslider' ) ) :

/**
 * Create Postslider element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Postslider extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Postslider', 't4p-core' );
		$this->config['cat']         = __( 'Post-Based', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-postslider';
		$this->config['description'] = __( 'Add a Postslider', 't4p-core' );

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
                                        'class'   => 'input-sm',
                                        'std'        => 'posts',
                                        'options'    => array(
                                                        'posts'      => __( 'Posts with Title', 't4p-core' ),
                                                        'posts-with-excerpt'   => __( 'Posts with Title and Excerpt', 't4p-core' ),
                                                        'attachments-only'    => __( 'Attachment Layout, Only Images Attached to Post/Page', 't4p-core' )
                                                ),
                                        'tooltip'    => __( 'Choose a layout style for Post Slider.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Excerpt Number of Words', 't4p-core' ),
                                        'id'         => 'excerpt',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '35',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_range( 50, false ),
                                        'tooltip'    => __( 'Insert the number of words you want to show in the excerpt.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Category', 't4p-core' ),
                                        'id'         => 'category',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_categories( 'category', true ),
                                        'tooltip'    => __( 'Select a category of posts to display.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Number of Slides', 't4p-core' ),
                                        'id'         => 'limit',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '3',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_range( 10, false ),
                                        'tooltip'    => __( 'Select the number of slides to display.', 't4p-core' )
                                ),
                                array(
					'name'     => __( 'Lightbox on Click', 't4p-core' ),
					'id'       => 'lightbox',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Only works on attachment layout.', 't4p-core' ),
				),
                                array(
                                        'name'    => __( 'Attach Images to Post/Page Gallery', 't4p-core' ),
                                        'id'      => 'gallery_id',
                                        'type'    => 'gallery',
                                        'tooltip'  => __( 'Only works for attachments layout.', 't4p-core' ),
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
                $arr_params['post_id'] = '';
                extract( $arr_params );

                $layout = ( ! $layout ) ? 'posts' : $layout;
                $excerpt = ( ! $excerpt ) ? '35' : $excerpt;
                $category = ( ! $category ) ? '' : $category;
                $limit = ( ! $limit ) ? '3' : $limit;
                $lightbox = ( ! $lightbox ) ? 'yes' : $lightbox;
                $gallery_id = ( ! $gallery_id ) ? '' : $gallery_id;

                $thumbnails = '';
		$theme = wp_get_theme(); // gets the current theme
		if ('evolve Plus' == $theme->name || 'evolve Plus' == $theme->parent_theme) {

                        if( $layout == 'attachments-only' ) {
                                $slider = $this->posts_attachments();
                                //$thumbnails = $this->get_attachments_thumbnails();
                        } else if( $layout == 'posts' ) {
                                $slider = $this->posts();
                        } else if( $layout == 'posts-with-excerpt' ) {
                                $slider = $this->posts_excerpt();
                        } else {
                                $slider = $this->default_layout();
                        }
		
		} else {

                        if( $layout == 'attachments' ) {
                                $slider = $this->attachments();
                                $thumbnails = $this->get_attachments_thumbnails();
                        } else if( $layout == 'posts' ) {
                                $slider = $this->posts();
                        } else if( $layout == 'posts-with-excerpt' ) {
                                $slider = $this->posts_excerpt();
                        } else {
                                $slider = $this->default_layout();
                        }
			
		}
		

		$slides_html = sprintf( '<ul class="slides">%s</ul>', $slider );

                //html_attr
                $class = 't4p-flexslider flexslider flexslider-' . $layout;
		if( $lightbox == 'yes' && $layout == 'attachments' ) {
			$class .= ' flexslider-lightbox';
		}

		$html = "<div class='$class'>$slides_html</div>";

		if( $layout == 'attachments' ) {
                        //thumbnails_attr
                        $thumbnails_class = 'flexslider';
                        if($layout == 'attachments' ) {
                                $thumbnails_class .= ' fat';
                        }
                    
			//$thumbnails_html = sprintf( '<ul class="slides">%s</ul>', $thumbnails );
			$thumbnails_html = '';
			$html .= "<div class='$thumbnails_class'>$thumbnails_html</div>";
		}
                
		return $this->element_wrapper( $html, $arr_params );
	}
        
        function default_layout() {
                global $arr_params;
		if( isset($arr_params['group']) && $arr_params['group'] ) {

			$html = '';

			$group = explode( ',', $arr_params['group'] );

			$query = new WP_Query( array(
				'post_type' 	 => 'slide',
				'post__not_in' => get_option('sticky_posts'),
				'posts_per_page' => $arr_params['limit'],
				'tax_query' 	 => array(
					array(
						'taxonomy' => 'slide-page',
						'field'    => 'slug',
						'terms'    => $group,
					),
				),
			) );

			if( $query->have_posts() ):

				while( $query->have_posts() ): $query->the_post();

					$meta = get_post_meta( get_the_ID(), 'smof_data', true );
					$caption = '';

					if( isset( $meta['caption'] ) && $meta['caption'] ) {
						$caption = sprintf( '<p class="flex-caption">%s</p>', $meta['caption'] );
					}

					$html .= sprintf( '<li>%s</li>', t4p_content( $arr_params['excerpt'], true ) . $caption );

				endwhile;

			else:
			endif;

			wp_reset_query();

			return $html;

		}

	}

	function attachments() {
                global $arr_params;
		$html = '';

		if( ! $arr_params['post_id'] ) {
			$arr_params['post_id'] = get_the_ID();
		}

		$query = get_posts( array(
			'post_type' 	 => 'attachment',
			'post__not_in' => get_option('sticky_posts'),
			'posts_per_page' => $arr_params['limit'],
		    'post_status'    => null,
		    'post_parent' 	 => $arr_params['post_id'],
			'orderby'    	 => 'menu_order',
			'order' 		 => 'ASC',
			'post_mime_type' => 'image',
			'exclude' 		 => get_post_thumbnail_id()
		) );

		if( $query ):

			foreach( $query as $attachment ):

				$image = wp_get_attachment_url( $attachment->ID );
				$title = get_post_field( 'post_excerpt', $attachment->ID );
				$alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
				$thumb = wp_get_attachment_image_src( $attachment->ID, 'thumbnail' );

				$image_output = sprintf( '<img src="%s" alt="%s" />', $image, $alt );
				$output = $image_output;

				if( $arr_params['lightbox'] == 'yes' ) {
					$output = sprintf( '<a href="%s" data-title="%s" data-caption="%s" title="%s">%s</a>', $image, $title, $alt, $title, $image_output );
				}

				$html .= sprintf( '<li data-thumb="' . $thumb[0] . '">%s</li>', $output );

			endforeach;

		endif;

		wp_reset_query();

		return $html;

	}

	function get_attachments_thumbnails() {
                global $arr_params;
		$html = ''; 

		if( ! $arr_params['post_id'] ) {
			$arr_params['post_id'] = get_the_ID();
		}

		$query = get_posts( array(
			'post_type' 	 => 'attachment',
			'post__not_in' => get_option('sticky_posts'),
			'posts_per_page' => $arr_params['limit'],
		    'post_status'    => null,
		    'post_parent' 	 => $arr_params['post_id'],
			'orderby'    	 => 'menu_order',
			'order' 		 => 'ASC',
			'post_mime_type' => 'image',
			'exclude' 		 => get_post_thumbnail_id()
		) );

		if( $query ):

			foreach( $query as $attachment ):

				$image = wp_get_attachment_url( $attachment->ID );
				$title = get_post_field( 'post_excerpt', $attachment->ID );
				$alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
				$thumb = wp_get_attachment_image_src( $attachment->ID, 'thumbnail' );

				$image_output = sprintf( '<img src="%s" alt="%s" />', $thumb[0], $alt );
				$output = $image_output;

				$html .= sprintf( '<li>%s</li>', $output );

			endforeach;

		endif;

		wp_reset_query();

		return $html;

	}

	function posts_attachments() {
                global $arr_params;
		$html = '';

		$args = array(
			'posts_per_page' => $arr_params['limit'],
			'post__not_in' => get_option('sticky_posts'),
			'meta_query' 	 => array(
				array(
					'key' => '_thumbnail_id'
				)
			),
		);

		if( $arr_params['post_id'] ) {
			$post_ids = explode( ',', $arr_params['post_id'] );
			$args['post__in'] = $post_ids;
		}

		if( $arr_params['category'] ) {
			$args['category_name'] = $arr_params['category'];
		}

		$query = new WP_Query( $args );

		if( $query->have_posts() ):

			while( $query->have_posts() ): $query->the_post();

				$image = wp_get_attachment_url( get_post_thumbnail_id() );
				$title = get_post_field( 'post_excerpt', get_post_thumbnail_id() );
				$alt = get_the_title();

				$image_output = sprintf( '<img src="%s" alt="%s" />', $image, get_the_title() );

				$link_output = sprintf( '<a href="%s">%s</a>', get_permalink(), $image_output );

				//$title = sprintf( '<h2><a href="%s">%s</a></h2>', get_permalink(), get_the_title() );

				//$container = sprintf( '<div %s>%s</div>', T4PCore_Plugin::attributes( 'flexslider-shortcode-title-container' ), $title );

				$html .= sprintf( '<li>%s</li>', $link_output );

			endwhile;

		else:
		endif;

		wp_reset_query();

		return $html;

	}

	function posts() {
                global $arr_params;
		$html = '';

		$args = array(
			'posts_per_page' => $arr_params['limit'],
			'post__not_in' => get_option('sticky_posts'),
			'meta_query' 	 => array(
				array(
					'key' => '_thumbnail_id'
				)
			),
		);

		if( $arr_params['post_id'] ) {
			$post_ids = explode( ',', $arr_params['post_id'] );
			$args['post__in'] = $post_ids;
		}

		if( $arr_params['category'] ) {
			$args['category_name'] = $arr_params['category'];
		}

		$query = new WP_Query( $args );

		if( $query->have_posts() ):

			while( $query->have_posts() ): $query->the_post();

				$image = wp_get_attachment_url( get_post_thumbnail_id() );
				$title = get_post_field( 'post_excerpt', get_post_thumbnail_id() );
				$alt = get_the_title();

				$image_output = sprintf( '<img src="%s" alt="%s" />', $image, get_the_title() );

				$link_output = sprintf( '<a href="%s">%s</a>', get_permalink(), $image_output );

				$title = sprintf( '<h2><a href="%s">%s</a></h2>', get_permalink(), get_the_title() );

				$container = sprintf( '<div class="slide-excerpt">%s</div>', $title );

				$html .= sprintf( '<li>%s</li>', $link_output . $container );

			endwhile;

		else:
		endif;

		wp_reset_query();

		return $html;

	}

	function posts_excerpt() {
                global $arr_params;
		$html = '';

		$args = array(
			'posts_per_page' => $arr_params['limit'],
			'post__not_in' => get_option('sticky_posts'),
			'meta_query' 	 => array(
				array(
					'key' => '_thumbnail_id'
				)
			),
		);

		if( $arr_params['post_id'] ) {
			$post_ids = explode( ',', $arr_params['post_id'] );
			$args['post__in'] = $post_ids;
		}

		if( $arr_params['category'] ) {
			$args['category_name'] = $arr_params['category'];
		}

		$query = new WP_Query( $args );

		if( $query->have_posts() ):

			while( $query->have_posts() ): $query->the_post();

				$image = wp_get_attachment_url( get_post_thumbnail_id() );
				$title = get_post_field( 'post_excerpt', get_post_thumbnail_id() );
				$alt = get_the_title();

				$image_output = sprintf( '<img src="%s" alt="%s" />', $image, get_the_title() );

				$link_output = sprintf( '<a href="%s">%s</a>', get_permalink(), $image_output );

				$title = sprintf( '<h2><a href="%s">%s</a></h2>', get_permalink(), get_the_title() );
				$excerpt = sprintf( '%s', t4p_content( $arr_params['excerpt'], true ) );

				$container = sprintf( '<div class="slide-excerpt"><div class="excerpt-container">%s</div></div>', $title . $excerpt );

				$html .= sprintf( '<li>%s</li>', $link_output . $container );

			endwhile;

		else:
		endif;

		wp_reset_query();

		return $html;

	}
}

endif;
