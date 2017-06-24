<?php
/**
 * @version    1.0.0
 * @package    Theme4Press PageBuilder
 * @author     Theme4Press 
 * 
 * 
 */
if ( ! class_exists( 'Testimonial' ) ) {

	class Testimonial extends T4P_Pb_Shortcode_Child {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		public function element_config() {
			$this->config['shortcode'] = strtolower( __CLASS__ );

			$this->config['exception'] = array(
			);

                        $this->config['use_wrapper'] = true;
                        
			// Inline edit for sub item
			$this->config['edit_inline'] = true;
		}

		/**
		 * DEFINE setting options of shortcode
		 */
		public function element_items() {
			$this->items = array(
				'Notab' => array(
					array(
						'name'    => __( 'Name', 't4p-core' ),
						'id'      => 'name',
						'type'    => 'text_field',
						'std'     => __( 'Lorem sit', 't4p-core' ),
                                                'tooltip' => __( 'Insert the name of the person.', 't4p-core' )
					),
					array(
						'name'       => __( 'Avatar', 't4p-core' ),
						'id'         => 'avatar',
						'type'       => 'radio',
                                                'std'        => 'none',
                                                'options'    => array( 'image' => __( 'Image', 't4p-core' ), 'none' => __( 'None', 't4p-core' ) ),
                                                'tooltip'    => __( 'Country Description', 't4p-core' ),
					),
                                    	array(
						'name'    => __( 'Custom Avatar', 't4p-core' ),
						'id'      => 'image',
						'type'    => 'select_media',
						'std'     => '',
						'class'   => 'jsn-input-large-fluid',
						'tooltip' => __( 'Upload a custom avatar image.', 't4p-core' )
					),
					array(
						'name'    => __( 'Company', 't4p-core' ),
						'id'      => 'company',
						'type'    => 'text_field',
						'std'     => '',
						'tooltip' => __( 'Insert the name of the company.', 't4p-core' )
					),
					array(
						'name'    => __( 'Link', 't4p-core' ),
						'id'      => 'link',
						'type'    => 'text_field',
						'std'     => '',
						'tooltip' => __( 'Add the url the company name will link to.', 't4p-core' )
					),
                                        array(
                                                'name'       => __( 'Button Target', 't4p-core' ),
                                                'id'         => 'target',
                                                'type'       => 'select',
                                                'class'   => 'input-sm',
                                                'std'        => '_self',
                                                'options'    => array(
                                                                        '_self'      => __( '_self', 't4p-core' ),
                                                                        '_blank'   => __( '_blank', 't4p-core' ),
                                                                ),
                                                'tooltip' => __( '_self = open in same window _blank = open in new window.', 't4p-core' ),
                                        ),
                                    	array(
						'name' => __( 'Testimonial Content', 't4p-core' ),
						'id'   => 'body',
						'role' => 'content',
						'type' => 'text_area',
                                                'container_class' => 't4p_tinymce_replace',
						'std'  => T4P_Pb_Helper_Type::lorem_text(12),
                                                'tooltip' => __( 'Add the testimonial content', 't4p-core' ),
					),

				),
			);
		}

		/**
		 * DEFINE shortcode content
		 *
		 * @param type $atts
		 * @param type $content
		 */
		public function element_shortcode_full( $atts = null, $content = null ) {
                        $arr_params   = shortcode_atts( $this->config['params'], $atts );
                        extract( $arr_params );

                        $name  = ( ! $name ) ? '' : $name;
                        $avatar = ( ! $avatar ) ? 'none' : $avatar;
                        $image = ( ! $image ) ? '' : $image;
                        $company = ( ! $company ) ? '' : $company;
                        $link = ( ! $link ) ? '' : $link;
                        $target = ( ! $target ) ? '_self' : $target;

                        $inner_content = $thumbnail = $pic = $alt = '';
                        if( $name ) {

                            if( $avatar == 'image' && 
                                    $image 
                            ) {
                                
                                    $attr['class'] = 'testimonial-image';
                                    $attr['src'] = $image;
                                    $attr['alt'] = $alt;

                                    $image_id = T4PCore_Plugin::get_attachment_id_from_url( $image );
                                    if( $image_id ) {
                                            $alt = get_post_field( 'post_excerpt', $image_id );
                                    }

                                    $pic = "<img class='testimonial-image' src='$image' alt='$alt' />";
                                            
                            }

                            if( $avatar == 'image' && 
                                    ! $image 
                            ) {
                                    $avatar = 'none';
                            }

                            if( $avatar != 'none' ) {
                                    $thumbnail = "<span class='testimonials-shortcode-thumbnail'>$pic</span>";
                            }

                            $inner_content .= "<div class='author'>$thumbnail<span class='company-name'><strong>$name</strong>";

                            if( $company ) {

                                    if( ! empty( $link ) && 
                                            $link 
                                    ) {

                                            $inner_content .= ", <a href='$link' target='$target'><span>$company</span></a>";

                                    } else {

                                            $inner_content .= "<span>$company</span>";

                                    }

                            }

                            $inner_content .= '</span></div>';
                        }

                        if( $avatar == 'none' ) {
                           $review_class = 'no-avatar';
                        } else {
                            $review_class = $avatar;
                        }

                        $html = "<div class='$review_class' ><blockquote><q>".do_shortcode( $content )."</q></blockquote>$inner_content</div>";
                        return $html . '<!--seperate-->';
		}

	}

}
