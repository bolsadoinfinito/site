<?php
/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */
if ( ! class_exists( 'Slide' ) ) {
	/**
	 * Create child Slide element
	 *
	 * @package  T4P PageBuilder Shortcodes
	 * @since    1.0.0
	 */
	class Slide extends T4P_Pb_Shortcode_Child {

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
                                                            'name'       => __( 'Slide Type', 't4p-core' ),
                                                            'id'         => 'type',
                                                            'type'       => 'select',
                                                            'class'   => 'input-sm',
                                                            'std'        => 'image',
                                                            'options'    => array(
                                                                                    'image'      => __( 'Image', 't4p-core' ),
                                                                                    'video'   => __( 'Video', 't4p-core' ),
                                                                            ),
                                                            'tooltip' => __( 'Choose a video or image slide', 't4p-core' ),
                                                    ),
                                                    array(
                                                            'name'    => __( 'Slide Image', 't4p-core' ),
                                                            'id'      => 'image',
                                                            'type'    => 'select_media',
                                                            'std'     => '',
                                                            'class'   => 'jsn-input-large-fluid',
                                                            'tooltip' => __( 'Image type only. Upload an image to display in the slide', 't4p-core' ),
                                                    ),
                                                    array(
                                                            'name'       => __( 'Full Image Link or External Link', 't4p-core' ),
                                                            'id'         => 'link',
                                                            'type'       => 'text_field',
                                                            'class'      => 'input-sm',
                                                            'tooltip' => __( 'Image type only. Add the url of where the image will link to. If lightbox option is enabled,and you do not add the full image link, lightbox will open slide image', 't4p-core' ),
                                                    ),
                                                    array(
                                                            'name'       => __( 'Link Target', 't4p-core' ),
                                                            'id'         => 'linktarget',
                                                            'type'       => 'select',
                                                            'class'   => 'input-sm',
                                                            'std'        => '_self',
                                                            'options'    => array(
                                                                                    '_self'      => __( '_self', 't4p-core' ),
                                                                                    '_blank'   => __( '_blank', 't4p-core' ),
                                                                            ),
                                                            'tooltip' => __( 'Image type only. _self = open in same window _blank = open in new window.', 't4p-core' ),
                                                    ),
                                                    array(
                                                            'name'       => __( 'Lighbox', 't4p-core' ),
                                                            'id'         => 'lightbox',
                                                            'type'       => 'select',
                                                            'class'   => 'input-sm',
                                                            'std'        => 'yes',
                                                            'options'    => array(
                                                                                    'yes'      => __( 'Yes', 't4p-core' ),
                                                                                    'no'   => __( 'No', 't4p-core' ),
                                                                            ),
                                                            'tooltip' => __( 'Image type only. Show image in Lightbox', 't4p-core' ),
                                                    ),
                                                    array(
                                                            'name' => __( 'Video Shortcode or Video Embed Code', 't4p-core' ),
                                                            'id'   => 'video_content',
                                                            'role' => 'content',
                                                            'type'  => 'text_area',
                                                            'tooltip' => __( 'Video type only. Click the Youtube or Vimeo Shortcode button below then enter your unique video ID, or copy and paste your video embed code.', 't4p-core' ),
                                                    ),
                                                    array(
                                                            'id'        => 'youtube_button',
                                                            'type'      => 'slider_button',
                                                            'std'       => 'Insert Youtube Shortcode',
                                                            'class'     => 'youtube_button',
                                                    ),
                                                    array(
                                                            'id'        => 'vimeo_button',
                                                            'type'      => 'slider_button',
                                                            'std'       => 'Insert Vimeo Shortcode',
                                                            'class'     => 'vimeo_button',
                                                    ),
                                            )
			);
		}

		/**
		 * DEFINE shortcode content
		 *
		 * @param type $atts
		 * @param type $content
		 */
		public function element_shortcode_full( $atts = null, $content = null ) {
			$arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
			extract( $arr_params );

                        $type  = ( ! $type ) ? 'image' : $type;
                        $src  = ( ! $image ) ? '' : $image;
                        $link  = ( ! $link ) ? NULL : $link;
                        $linktarget  = ( ! $linktarget ) ? '_self' : $linktarget;
                        $lightbox  = ( ! $lightbox ) ? 'no' : $lightbox;
                        $video_content  = ( ! $video_content ) ? '' : $video_content;
                        $alt = '';
                        $title = '';

                        if ( ! $src && $content && $type == 'image' ) {
                                $src = $content;
                                $src = str_replace('&#215;', 'x', $src);
                                $image_id = T4PCore_Plugin::get_attachment_id_from_url( $src );
                        }

                        if( $lightbox == 'yes' && $type == 'image' ) {

                                if( ! empty( $link ) && $link ) {
                                        $image_id = T4PCore_Plugin::get_attachment_id_from_url( $link );
                                } else {
                                        $image_id = T4PCore_Plugin::get_attachment_id_from_url( $src );
                                }

                                if( $image_id ) {
                                        $alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                                        $title = get_post_field( "post_excerpt", $image_id );
                                }
                                
                        }

                        if( empty( $link ) && ! $link && $type == 'image' ) {
                                $link = $src;
                        }
                    
                        //slide_li_attr
                        if( $type == 'video' ) {
                                $slide_li_class = 'video';
                        } else {
                                $slide_li_class = 'image';
                        }
                        $html = sprintf( '<li class="%s" >', $slide_li_class );

                        if( !empty( $link ) && $link ) {
                            
                                if( $lightbox == 'yes' ) {
                                    $html .= "<a class='lightbox' rel='prettyPhoto' href='$link' target='$linktarget' title='$title' >";
                                } else {
                                    $html .= "<a href='$link' target='$linktarget' title='$title' >";
                                }
                            
                        }

                        if( !empty( $type ) && $type == 'video') {
      
                                if ( ! empty( $content ) ) {
                                        $content = T4P_Pb_Helper_Shortcode::remove_autop( $content );
                                }

                                $html .= sprintf( '<div class="full-video">%s</div>', do_shortcode($content) );
                        } else {
                                $html .= "<img src='$src' alt='$alt' />";
                        }

                        if( ! empty( $link ) && $link ) {
                                $html .= '</a>';
                        }

                        $html .= '</li>';

			 return $html . '<!--seperate-->';
                        }

	}

}
