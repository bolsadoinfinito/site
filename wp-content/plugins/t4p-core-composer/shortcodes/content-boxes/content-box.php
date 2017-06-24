<?php
/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */
if ( ! class_exists( 'Content_box' ) ) {
	/**
	 * Create child Content_boxes element
	 *
	 * @package  T4P PageBuilder Shortcodes
	 * @since    1.0.0
	 */
	class Content_box extends T4P_Pb_Shortcode_Child {

                private $column_counter = 1;
                private $num_of_columns = 1;

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		public function element_config() {
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['exception'] = array(
                                'admin_assets' => array(
                                        't4p-pb-joomlashine-iconselector-js',
                                        't4p-pb-colorpicker-js',
                                        't4p-pb-colorpicker-css',
                                ),
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
                                        'name'  => __( 'Title', 't4p-core' ),
                                        'id'    => 'title',
                                        'type'  => 'text_field',
                                        'class' => 'input-sm',
                                        'std'   => 'Lorem proin',
                                ),
                                array(
                                        'name' => __( 'Content Box Background Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'backgroundcolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'This setting will override the global setting above. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name'      => __( 'Icon', 't4p-core' ),
                                        'id'        => 'icon',
                                        'type'      => 'icons',
                                        'std'       => '',
                                        'role'      => 'title_prepend',
                                        'title_prepend_type' => 'icon',
                                        'tooltip'  => __( 'Click an icon to select, click None to deselect', 't4p-core' ),
                                ),
                                array(
                                        'name' => __( 'Icon Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'iconcolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'This setting will override the global setting above. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Icon Circle Background Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'circlecolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'This setting will override the global setting above. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Icon Circle Border Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'circlebordercolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'This setting will override the global setting above. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Flip Icon', 't4p-core' ),
                                        'id'         => 'iconflip',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'options'    => array(
                                                        ''      => __( 'None', 't4p-core' ),
                                                        'horizontal'   => __( 'Horizontal', 't4p-core' ),
                                                        'vertical'    => __( 'Vertical', 't4p-core' )
                                                ),
                                        'tooltip'    => __( 'Choose to flip the icon.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Rotate Icon', 't4p-core' ),
                                        'id'         => 'iconrotate',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'options'    => array(
                                                        ''      => __( 'None', 't4p-core' ),
                                                        '90'   => __( '90', 't4p-core' ),
                                                        '180'    => __( '180', 't4p-core' ),
                                                        '270'    => __( '270', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'Choose to rotate the icon.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Spinning Icon', 't4p-core' ),
                                        'id'         => 'iconspin',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'          => 'no',
                                        'options'    => array(
                                                        'no'      => __( 'No', 't4p-core' ),
                                                        'yes'   => __( 'Yes', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'Choose to let the icon spin.', 't4p-core' )
                                ),
                                array(
                                        'name'    => __( 'Icon Image', 't4p-core' ),
                                        'id'      => 'image',
                                        'type'    => 'select_media',
                                        'std'     => '',
                                        'class'   => 'jsn-input-large-fluid',
                                        'tooltip' => __( 'To upload your own icon image, deselect the icon above and then upload your icon image.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Icon Image Width', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'         => 'image_width',
                                                        'type'       => 'text_append',
                                                        'type_input' => 'number',
                                                        'class'      => 'input-mini',
                                                        'std'        => '35',
                                                        'append'     => 'px',
                                                        'validate'   => 'number',
                                                ),
                                        ),
                                        'tooltip' => __( 'If using an icon image, specify the image width in pixels. ex: 35.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Icon Image Height', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'         => 'image_height',
                                                        'type'       => 'text_append',
                                                        'type_input' => 'number',
                                                        'class'      => 'input-mini',
                                                        'std'        => '35',
                                                        'append'     => 'px',
                                                        'validate'   => 'number',
                                                ),
                                        ),
                                        'tooltip' => __( 'If using an icon image, specify the image height in pixels. ex: 35.', 't4p-core' )
                                ),
                                array(
                                        'name'    => __( 'Read More Link Url', 't4p-core' ),
                                        'id'      => 'link',
                                        'type'    => 'text_field',
                                        'class'   => 'jsn-input-xxlarge-fluid',
                                        'std'     => '',
                                        'tooltip'  => __( 'Add the link url ex: http://example.com', 't4p-core' ),
                                ),
                                array(
                                        'name'    => __( 'Read More Link Text', 't4p-core' ),
                                        'id'      => 'linktext',
                                        'type'    => 'text_field',
                                        'class'   => 'jsn-input-xxlarge-fluid',
                                        'std'     => '',
                                        'tooltip'  => __( 'Insert the text to display as the link', 't4p-core' ),
                                ),
                                array(
                                        'name'       => __( 'Read More Link Target', 't4p-core' ),
                                        'id'         => 'linktarget',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '_self',
                                        'options'    => array(
                                                                '_self'      => __( '_self', 't4p-core' ),
                                                                '_blank'   => __( '_blank', 't4p-core' ),
                                                        ),
                                        'tooltip' => __( '_self = open in same window _blank = open in new window.', 't4p-core' ),
                                ),
                                array(
                                        'name'    => __( 'Content Box Content', 't4p-core' ),
                                        'id'      => 'body',
                                        'role'    => 'content',
                                        'type'    => 'text_area',
                                        'container_class' => 't4p_tinymce_replace',
                                        'std'     => T4P_Pb_Helper_Type::lorem_text(),
                                        'tooltip'  => __( 'Add content for content box', 't4p-core' ),
                                ),
                                T4P_Pb_Helper_Type::get_animation_type(),
                                T4P_Pb_Helper_Type::get_animations_direction(),
                                T4P_Pb_Helper_Type::get_animation_speeds(),
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

                        $title  = ( ! $title ) ? '' : $title;
                        $backgroundcolor  = ( ! $backgroundcolor ) ? '' : $backgroundcolor;
                        $icon  = ( ! $icon ) ? '' : $icon;
                        $iconcolor  = ( ! $iconcolor ) ? '' : $iconcolor;
                        $circlecolor  = ( ! $circlecolor ) ? '' : $circlecolor;
                        $circlebordercolor  = ( ! $circlebordercolor ) ? '' : $circlebordercolor;
                        $iconflip  = ( ! $iconflip ) ? '' : $iconflip;
                        $iconrotate  = ( ! $iconrotate ) ? '' : $iconrotate;
                        $iconspin  = ( ! $iconspin ) ? '' : $iconspin;
                        $image  = ( ! $image ) ? '' : $image;
                        $image_width  = ( ! $image_width ) ? '' : $image_width;
                        $image_height  = ( ! $image_height ) ? '' : $image_height;
                        $link  = ( ! $link ) ? '' : $link;
                        $linktext  = ( ! $linktext ) ? '' : $linktext;
                        $linktarget  = ( ! $linktarget ) ? '' : $linktarget;

                        $output = '';
                        $icon_output = '';
                        $title_output = '';
                        $content_output = '';
                        $link_output = '';

                        //icon_attr
                        $icon_attr_style = '';	
                        if( $image ) {
                                $icon_attr_class = 'image';

                                if( $parent_atts['layout'] == 'icon-boxed' && $image_width && $image_height ) {
                                        $icon_attr_style = sprintf( 'margin-left:-%spx;', $image_width / 2 );
                                        $icon_attr_style .= sprintf( 'top:-%spx;', $image_height / 2 + 50 );
                                }			

                        } else if( $icon ) {

                                $icon_attr_class = "fa fontawesome-icon medium $icon";

                                $icon_attr_class .= ' circle-yes';

                                if( $circlebordercolor ) {
                                        $icon_attr_style .= "border: 1px solid $circlebordercolor;";
                                }

                                if( $circlecolor ) {
                                        $icon_attr_style .= "background-color:$circlecolor;";
                                }

                                if( $iconcolor ) {
                                        $icon_attr_style .= "color:$iconcolor;";
                                }

                                if( $iconflip ) {
                                        $icon_attr_class .= ' fa-flip-' . $iconflip;
                                }

                                if( $iconrotate ) {
                                        $icon_attr_class .= ' fa-rotate-' . $iconrotate;
                                }

                                if( $iconspin == 'yes' ) {
                                        $icon_attr_class .= ' fa-spin';
                                }
                        }

                        //link_attr
                        if( $link ) {
                                $link_attr_href = $link;
                        }

                        $link_attr_target = '';
                        if( $linktarget ) {
                                $link_attr_target = $linktarget;
                        }

                        //heading_wrapper_attr
                        $heading_wrapper_attr_class = 'heading';

                        if( $icon || $image ) {
                                $heading_wrapper_attr_class .= ' heading-with-icon';
                        }
                        
                        //content_container_attr
                        $content_container_attr_class = 'content-container';
                        $content_container_attr_style = '';

                        if( $parent_atts['layout'] == 'icon-on-side' && $image && $image_width && $image_height ) {
                                $content_container_attr_style = sprintf( 'padding-left:%spx;', $image_width + 10 );
                        }
                        
                        //child_attr
                        if( $parent_atts['columns'] > 4 ) {
                                $this->num_of_columns = 4;
                        } else {
                                $this->num_of_columns = $parent_atts['columns'];
                        }
 
                        $columns = 12 / $this->num_of_columns;

                        $child_attr_class = sprintf( 't4p-column content-box-column content-box-column-%s col-lg-%s col-md-%s col-sm-%s', $this->column_counter, $columns, $columns, $columns );
                        
                        //content_wrapper_attr
                        $content_wrapper_attr_class = 'col content-wrapper';
                        $content_wrapper_attr_style = '';

                        if( $backgroundcolor ) {
                                $content_wrapper_attr_style= sprintf( 'background-color:%s;', $backgroundcolor );
                                $content_wrapper_attr_class .= '-background';
                        }

                        if( $parent_atts['layout']  == 'icon-boxed' ) {
                                $content_wrapper_attr_class .= ' content-wrapper-boxed';
                        }		

                        //---------------------------rendering child html----------------------------
                        if( $image && $image_width && $image_height ) {
                                $icon_output = "<div class='$icon_attr_class' style='$icon_attr_style'><img src='$image' width='{$image_width}px' height='{$image_height}px' /></div>";
                        } elseif( $icon ) {
                                $icon_output = "<div class='icon'><i class='$icon_attr_class' style='$icon_attr_style'></i></div>";
                        }

                        if( $title ) {
                                $title_output = "<h2 class='content-box-heading'>$title</h2>";
                        }

                        if( $link ) {
                                $heading_content = "<a class='heading-link' href='$link_attr_href' target='$link_attr_target'>$icon_output $title_output</a>";
                        } else {
                                $heading_content = $icon_output . $title_output;
                        }
                        $heading = "<div class='$heading_wrapper_attr_class'>$heading_content</div>";

                        if( $link && $linktext ) {
                                $link_output = "<span class='more'><a class='read-more btn t4p-button-default' href='$link_attr_href' target='$link_attr_target'>$linktext</a></span><div class='t4p-clearfix'></div>";
                        } 

                        $content_output = "<div class='$content_container_attr_class' style='$content_container_attr_style'>".do_shortcode( $content )."$link_output</div>";

                        $output = $heading . $content_output;

                        $html = "<div class='$child_attr_class'><div class='$content_wrapper_attr_class' style='$content_wrapper_attr_style'>$output</div></div>";

                        $clearfix_test = $this->column_counter / $this->num_of_columns;

                        if(is_int($clearfix_test)) {
                                $html .= '<div class="t4p-clearfix"></div>';
                        }

                        $this->column_counter++;
		

			return $html . "<!--seperate-->";
                }

	}

}
