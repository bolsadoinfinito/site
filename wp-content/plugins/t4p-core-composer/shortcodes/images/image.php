<?php
/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */
if ( ! class_exists( 'Image' ) ) {
	/**
	 * Create child Image element
	 *
	 * @package  T4P PageBuilder Shortcodes
	 * @since    1.0.0
	 */
	class Image extends T4P_Pb_Shortcode_Child {
            
                private $image_carousel_counter = 1;
            
		/**
		 * Constructor
		 *
		 * @return  void
		 */
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
                                        'name'    => __( 'Image Website Link', 't4p-core' ),
                                        'id'      => 'link',
                                        'type'    => 'text_field',
                                        'std'     => '',
                                        'tooltip'  => __( 'Add the url to image website. If lightbox option is enabled, you have to add the full image link to show it in the lightbox.', 't4p-core' ),
                                ),
                                array(
                                        'name'       => __( 'Link Target', 't4p-core' ),
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
                                        'name'    => __( 'Client Image', 't4p-core' ),
                                        'id'      => 'image',
                                        'type'    => 'select_media',
                                        'std'     => '',
                                        'class'   => 'jsn-input-large-fluid',
                                        'tooltip' => __( 'Upload the client image', 't4p-core' )
                                ),
                                array(
                                        'name'    => __( 'Image Alt Text', 't4p-core' ),
                                        'id'      => 'alt',
                                        'type'    => 'text_field',
                                        'class'   => 'jsn-input-xxlarge-fluid',
                                        'role'    => 'title',
                                        'std'     => '',
                                        'tooltip'  => __( 'The alt attribute provides alternative information if an image cannot be viewed.', 't4p-core' ),
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
                        global $parent_atts;
			$arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
			extract( $arr_params );

                         $link  = ( ! $link ) ? '' : $link;
                         $target  = ( ! $target ) ? '_self' : $target;
                         $image  = ( ! $image ) ? '' : $image;
                         $alt  = ( ! $alt ) ? '' : $alt;

                        $image_id = T4PCore_Plugin::get_attachment_id_from_url( $image );

                        if( ! $alt && empty( $alt ) && $image_id ) {
                            $alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                        }

                        if( $image_id ) {
                            $title_attr = get_post_field( 'post_excerpt', $image_id );
                        }

                        $output = sprintf( '<img src="%s" alt="%s" />', $image, $alt );
                        $slide_link_attr_rel = '';

                        //slide_link_attr
                        if( $parent_atts['lightbox'] == 'yes' ) {

                                if( ! $link ) {
                                        $link = $image;
                                }

                                $slide_link_attr_rel = sprintf( 'prettyPhoto[gallery_image_%s]', $this->image_carousel_counter );
                        }
                        $slide_link_attr_href = $link;

                        $slide_link_attr_target = $target;

                        if( $link || $parent_atts['lightbox'] == 'yes' ) {
                            $output = "<a href='$slide_link_attr_href' target='$slide_link_attr_target' rel='$slide_link_attr_rel' >$output</a>";
                        }

                        $html = "<li><div class='image'>$output</div></li>";
                        
                        $this->image_carousel_counter++;
                        
                        return $html . '<!--seperate-->';
		}

	}

}
