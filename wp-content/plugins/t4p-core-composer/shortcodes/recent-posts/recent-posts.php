<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Recent_posts' ) ) :

/**
 * Create Recent_posts element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Recent_posts extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Recent Posts', 't4p-core' );
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
                                        'name'       => __( 'Layout', 't4p-core' ),
                                        'id'         => 'layout',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => 'default',
                                        'options'    => array(
                                                        'default'      => __( 'Default', 't4p-core' ),
                                                        'thumbnails-on-side'   => __( 'Thumbnails on Side', 't4p-core' ),
                                                        'icon-on-side'   => __( 'Icon on Side', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'Select the layout for the shortcode', 't4p-core' )
                                ),
                                array(
					'name'       => __( 'Columns', 't4p-core' ),
					'id'         => 'columns',
					'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '4',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_range( 4, false ),
                                        'tooltip'    => __( 'Select the number of columns to display', 't4p-core' ),
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
					'name'     => __( 'Show Thumbnail', 't4p-core' ),
					'id'       => 'thumbnail',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Display the post featured image', 't4p-core' ),
				),
                                array(
					'name'     => __( 'Show Title', 't4p-core' ),
					'id'       => 'title',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Display the post title below the featured image', 't4p-core' ),
				),
                                array(
					'name'     => __( 'Show Meta', 't4p-core' ),
					'id'       => 'meta',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose to show all meta data', 't4p-core' ),
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
                                        'name'       => __( 'Excerpt Length', 't4p-core' ),
                                        'id'         => 'excerpt_words',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '35',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_range( 60, false ),
                                        'tooltip'    => __( 'Insert the number of words/characters you want to show in the excerpt', 't4p-core' )
                                ),
                                array(
					'name'     => __( 'Strip HTML', 't4p-core' ),
					'id'       => 'strip_html',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Strip HTML from the post excerpt', 't4p-core' ),
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
                global $smof_data, $theme_prefix;
		$arr_params    = ( shortcode_atts( $this->config['params'], $atts ) );
                extract( $arr_params );

                $layout = ( ! $layout ) ? 'default' : $layout;
                $columns = ( ! $columns ) ? 4 : $columns;
                $number_posts = ( ! $number_posts ) ? 4 : $number_posts;
                $cat_slug = ( ! $cat_slug ) ? '' : $cat_slug;
                $exclude_cats = ( ! $exclude_cats ) ? '' : $exclude_cats;
                $thumbnail = ( ! $thumbnail ) ? 'yes' : $thumbnail;
                $title = ( ! $title ) ? 'yes' : $title;
                $meta = ( ! $meta ) ? 'yes' : $meta;
                $excerpt = ( ! $excerpt ) ? 'no' : $excerpt;
                $excerpt_words = ( ! $excerpt_words ) ? '35' : $excerpt_words;
                $strip_html = ( ! $strip_html ) ? 'yes' : $strip_html;
                $cat_id = '';

                ( $strip_html == 'yes' ) ? ( $strip_html = true ) : ( $strip_html = false );

		//check for cats to exclude; needs to be checked via exclude_cats param and '-' prefixed cats on cats param
		//exclution via exclude_cats param 
		$cats_to_exclude = explode( ',' , $exclude_cats );
		if( $cats_to_exclude ) {
			foreach( $cats_to_exclude as $cat_to_exclude ) {
				$idObj = get_category_by_slug( $cat_to_exclude );
				if( $idObj ) {
					$cats_id_to_exclude[] = $idObj->term_id;
				}
			}
			if( isset( $cats_id_to_exclude ) && $cats_id_to_exclude ) {
				$category__not_in = $cats_id_to_exclude;
			}
		}

		//setting up cats to be used and exclution using '-' prefix on cats param; transform slugs to ids
		$cat_ids = '';
		$categories = explode( ',' , $cat_slug );
		if ( isset( $categories ) && $categories ) {
			foreach ( $categories as $category ) {
				if( $category ) {
                                    $cat_object = get_category_by_slug($category);
                                    if($cat_object){
                                        if (strpos($category, '-') === 0) {
                                            $cat_ids .= '-' . $cat_object->cat_ID . ',';
                                        } else {
                                            $cat_ids .= $cat_object->cat_ID . ',';
                                        }
                                    }
				}
			}
		}
		$cat = substr( $cat_ids, 0, -1 );	
		
		$cat .= $cat_id;

		$items = '';

                $arg_cat = '';

		if( $cat ) {
			$arg_cat = $cat;
		}

                $args = array(
			'posts_per_page' => $number_posts,
			'ignore_sticky_posts' => 1,
			'has_password' => false,
                        'cat' => $arg_cat,
		);

		$recent_posts = new WP_Query( $args );
		
		$count = 1;
		
		while( $recent_posts->have_posts() ) {
			$recent_posts->the_post();

			$attachment = $date_box = $slideshow = $slides = $content = '';
			
			if( $layout == 'icon-on-side' ) {

				switch(get_post_format()) {
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

				$date_box = "<div class='date-and-formats'><div clas='format-box'><i class='t4p-icon-{$format_class}'></i></div></div>";
			}
							  
			if( $thumbnail == 'yes' && $layout != 'icon-on-side'
			) {
				
				if( $layout == 'default' ) {
					$image_size = 'recent-posts';
				} elseif( $layout == 'thumbnails-on-side' ) {
					$image_size = 'portfolio-two';
				}
			
				if( $smof_data['legacy_posts_slideshow'] ) {
					$args = array(
						'exclude' 			=> get_post_thumbnail_id(),
						'numberposts' 		=> $smof_data['posts_slideshow_number'] - 1,
						'order' 			=> 'ASC',
						'orderby' 			=> 'menu_order',
						'post_mime_type' 	=> 'image',
						'post_parent' 		=> get_the_ID(),
						'post_status' 		=> null,
						'post_type' 		=> 'attachment',
					);
					$attachments = get_posts( $args );

					if( $attachments || has_post_thumbnail() || get_post_meta( get_the_ID(), $theme_prefix.'video', true ) ) {

						if( get_post_meta( get_the_ID(), $theme_prefix.'video', true ) ) {
							$slides .= sprintf( '<li><div class="%s">%s</div></li>', 'full-video', get_post_meta(get_the_ID(), $theme_prefix.'video', true) );
						}
                                                
						if( has_post_thumbnail() ) {
							$attachment_image = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_size );
                                                        if($attachment_image){
                                                                $full_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                                                                $attachment_data = wp_get_attachment_metadata( get_post_thumbnail_id() );

                                                                //img_attr
                                                                $img_href = get_permalink( get_the_ID() );
                                                                $img_src = $attachment_image[0];
                                                                $img_alt = get_the_title();
                                                                $slides .= "<li><a href='$img_href'><img src='$img_src' alt='$img_alt' /></a></li>";
                                                        }
						}
						if( $smof_data['posts_slideshow'] ) {
							foreach( $attachments as $attachment ) {
								$attachment_image = wp_get_attachment_image_src( $attachment->ID, $image_size );
								$full_image = wp_get_attachment_image_src( $attachment->ID, 'full' );
								$attachment_data = wp_get_attachment_metadata( $attachment->ID );
                                                                
                                                                //img_attr
                                                                $img_href = get_permalink( get_the_ID() );
                                                                $img_src = $attachment_image[0];
                                                                $img_alt = $attachment->post_title;
								$slides .= "<li><a href='$img_href'><img src='$img_src' alt='$img_alt' /></a></li>";  
							}
						}
                                                
                                                //slideshow_attr
                                                $slideshow_class = 't4p-flexslider flexslider';
                                                if( $layout == 'thumbnails-on-side' ) {
                                                       $slideshow_class .= ' floated-slideshow';
                                                }

						$slideshow = "<div class='$slideshow_class'><ul class='slides'>$slides</ul></div>";
					}
				} else {
					if( has_post_thumbnail() || get_post_meta(get_the_ID(), $theme_prefix.'video', true) ) {
						if( get_post_meta( get_the_ID(), $theme_prefix.'video', true ) ) {
							$slides .= sprintf( '<li><div class="%s">%s</div></li>', 'full-video', get_post_meta(get_the_ID(), $theme_prefix.'video', true) );
						}

						if( has_post_thumbnail() ) {
							$attachment_image = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_size );
							$full_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
							$attachment_data = wp_get_attachment_metadata( get_post_thumbnail_id() );
							$attachment = get_post(get_post_thumbnail_id());
                                                        
                                                        //img_attr
                                                        $img_href = get_permalink( get_the_ID() );
                                                        $img_src = $attachment_image[0];
                                                        $img_alt = $attachment->post_title;
                                                        $slides .= "<li><a href='$img_href'><img src='$img_src' alt='$img_alt' /></a></li>";
						}

						if( $smof_data['posts_slideshow'] ) {
							$i = 2;
							while( $i <= $smof_data['posts_slideshow_number'] ) {
								$attachment_new_id = kd_mfi_get_featured_image_id( 'featured-image-' . $i, 'post' );
								if( $attachment_new_id ) {
									$attachment_image = wp_get_attachment_image_src( $attachment_new_id, $image_size );
									$full_image = wp_get_attachment_image_src( $attachment_new_id, 'full' );
									$attachment_data = wp_get_attachment_metadata( $attachment_new_id );

									//img_attr
                                                                        $img_href = get_permalink( get_the_ID() );
                                                                        $img_src = $attachment_image[0];
                                                                        $img_alt = '';
                                                                        $slides .= "<li><a href='$img_href'><img src='$img_src' alt='$img_alt' /></a></li>";									
								}
								$i++; 
							}
						}
                                                
                                                //slideshow_attr
                                                $slideshow_class = 't4p-flexslider flexslider';
                                                if( $layout == 'thumbnails-on-side' ) {
                                                       $slideshow_class .= ' floated-slideshow';
                                                }
						$slideshow = "<div class='$slideshow_class'><ul class='slides'>$slides</ul></div>";
					}
				}
			}

			if( $title == 'yes' ) {
				$content .= sprintf( '<h3><a href="%s">%s</a></h3>', get_permalink( get_the_ID() ), get_the_title() );
			}

			if( $meta == 'yes' ) {

				$comments = '';
				if( get_comments_number( get_the_ID() ) >= 1 ) {
					$comments = sprintf( '<span class="%s">|</span><a href="%s">%s %s</a></span>', 'meta-separator', get_permalink( get_the_ID() ), 
										 get_comments_number( get_the_ID() ), __( 'Comments', 't4p-core' ) );
				}		

				$content .= sprintf( '<p class="%s"><span><time class="%s">%s</time></span>%s</p>', 'meta', 'date', 
								     get_the_time( $smof_data['date_format'], get_the_ID() ), $comments);

			}

			if( $excerpt == 'yes' ) {
				$content .= t4p_content( $excerpt_words, $strip_html );
			}

                        //column_attr
                        if( $columns > 4 ) {
                                $columns = 4;
                        } else {
                                $columns = $columns;
                        }
 
                        $columns_new = 12 / $columns;
                        $column_class = sprintf( 't4p-column column col col-lg-%s col-md-%s col-sm-%s', $columns_new, $columns_new, $columns_new );
                        
			$items .= sprintf( '<article class="%s">%s%s<div class="%s">%s</div></article>', $column_class, $date_box, $slideshow, 
							   'recent-posts-content',  $content );
			$count++;
			
		}
                
                //html_attr
                $html_class = sprintf( 't4p-recent-posts evolve-container alora-container layout-%s layout-columns-%s', $layout, $columns );
                
                //section_attr
                $section_class = sprintf( 't4p-columns columns columns-%s', $columns );
		$section_style = 'width:100%;';
                
		$html = "<div class='$html_class'><section class='$section_class' style='$section_style' ><div class='row holder' >$items</div></section></div>";

		wp_reset_query();
                
		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
