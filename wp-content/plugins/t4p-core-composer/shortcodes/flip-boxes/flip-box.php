<?php
/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */
if ( ! class_exists( 'Flip_box' ) ) {
	/**
	 * Create child Flip_boxes element
	 *
	 * @package  T4P PageBuilder Shortcodes
	 * @since    1.0.0
	 */
	class Flip_box extends T4P_Pb_Shortcode_Child {

                private $flipbox_counter = 1;

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
                                        'name'  => __( 'Flip Box Frontside Heading', 't4p-core' ),
                                        'id'    => 'title_front',
                                        'type'  => 'text_field',
                                        'class' => 'input-sm',
                                        'std'   => 'Lorem proin',
                                        'tooltip' => __( 'Add a heading for the frontside of the flip box.', 't4p-core' )
                                ),
                                array(
                                        'name'  => __( 'Flip Box Backside Heading', 't4p-core' ),
                                        'id'    => 'title_back',
                                        'type'  => 'text_field',
                                        'class' => 'input-sm',
                                        'std'   => 'Lorem proin',
                                        'tooltip' => __( 'Add a heading for the backside of the flip box.', 't4p-core' )
                                ),
                                array(
                                        'name'    => __( 'Flip Box Frontside Content', 't4p-core' ),
                                        'id'      => 'text_front',
                                        'type'    => 'text_area',
                                        'std'     => T4P_Pb_Helper_Type::lorem_text(12),
                                        'tooltip'  => __( 'Add content for the frontside of the flip box.', 't4p-core' ),
                                ),
                                array(
                                        'name'    => __( 'Flip Box Backside Content', 't4p-core' ),
                                        'id'      => 'body',
                                        'role'    => 'content',
                                        'type'    => 'text_area',
                                        'std'     => T4P_Pb_Helper_Type::lorem_text(12),
                                        'tooltip'  => __( 'Add content for the backside of the flip box.', 't4p-core' ),
                                ),
                                array(
                                        'name' => __( 'Background Color Frontside', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'background_color_front',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the background color of the frontside. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Heading Color Frontside', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'title_front_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the heading color of the frontside. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Text Color Frontside', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'text_front_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the text color of the frontside. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Background Color Backside', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'background_color_back',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the background color of the backside. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Heading Color Backside', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'title_back_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the heading color of the backside. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Text Color Backside', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'text_back_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the text color of the backside. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Border Size', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'         => 'border_size',
                                                        'type'       => 'text_append',
                                                        'type_input' => 'text_field',
                                                        'class'      => 'input-mini',
                                                        'std'        => '1px',
                                                ),
                                        ),
                                        'tooltip' => __( 'In pixels (px), ex: 1px. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Border Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'border_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the border color.  Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'BorderRadius', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'         => 'border_radius',
                                                        'type'       => 'text_append',
                                                        'type_input' => 'text_field',
                                                        'class'      => 'input-mini',
                                                        'std'        => '3px',
                                                ),
                                        ),
                                        'tooltip' => __( 'Choose the radius of the flip box. In pixels (px), ex: 1px.  Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name'      => __( 'Icon', 't4p-core' ),
                                        'id'        => 'icon',
                                        'type'      => 'icons',
                                        'std'       => '',
                                        'role'      => 'title_prepend',
                                        'title_prepend_type' => 'icon',
                                        'tooltip'  => __( 'Click an icon to select, click None to deselect.', 't4p-core' ),
                                ),
                                array(
                                        'name' => __( 'Icon Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'icon_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the color of the icon. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Icon Circle', 't4p-core' ),
                                        'id'         => 'circle',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => 'yes',
                                        'options'    => array(
                                                        'yes'   => __( 'Yes', 't4p-core' ),
                                                        'no'    => __( 'No', 't4p-core' )
                                                ),
                                        'tooltip'    => __( 'Choose to use a circled background on the icon.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Icon Circle Background Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'circle_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the color of the circle. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Icon Circle Border Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'circle_border_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the color of the circle border. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Flip Icon', 't4p-core' ),
                                        'id'         => 'icon_flip',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => '',
                                        'options'    => array(
                                                        ''      => __( 'None', 't4p-core' ),
                                                        'horizontal'   => __( 'Horizontal', 't4p-core' ),
                                                        'vertical'    => __( 'Vertical', 't4p-core' )
                                                ),
                                        'tooltip'    => __( 'Choose to flip the icon.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Rotate Icon', 't4p-core' ),
                                        'id'         => 'icon_rotate',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => '',
                                        'options'    => array(
                                                        ''      => __( 'None', 't4p-core' ),
                                                        '90'   => __( '90', 't4p-core' ),
                                                        '180'    => __( '180', 't4p-core' ),
                                                        '270'    => __( '270', 't4p-core' )
                                                ),
                                        'tooltip'    => __( 'Choose to rotate the icon.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Spinning Icon', 't4p-core' ),
                                        'id'         => 'icon_spin',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => 'no',
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
                                        'tooltip' => __( 'If using an icon image, specify the image width in pixels but do not add px, ex: 35.', 't4p-core' )
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
                                        'tooltip' => __( 'If using an icon image, specify the image height in pixels but do not add px, ex: 35.', 't4p-core' )
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
                        global $evl_options, $parent_atts, $smof_data;
			$arr_params = ( T4P_Pb_Helper_Type::t4p_shortcode_atts( $this->config['params'], $atts ) );
			extract( $arr_params );

                        $title_front  = ( ! $title_front ) ? '' : $title_front;
                        $title_back  = ( ! $title_back ) ? '' : $title_back;
                        $text_front  = ( ! $text_front ) ? '' : $text_front;
                        $background_color_front  = ( ! $background_color_front ) ? $smof_data['flip_boxes_front_bg'] . $evl_options['evl_shortcode_flip_boxes_bg_color_frontside'] : $background_color_front;
                        $title_front_color  = ( ! $title_front_color ) ? $smof_data['flip_boxes_front_heading'] . $evl_options['evl_shortcode_flip_boxes_heading_color_frontside'] : $title_front_color;
                        $text_front_color  = ( ! $text_front_color ) ? $smof_data['flip_boxes_front_text'] . $evl_options['evl_shortcode_flip_text_color_frontside'] : $text_front_color;
                        $background_color_back  = ( ! $background_color_back ) ? $smof_data['flip_boxes_back_bg'] . $evl_options['evl_shortcode_flip_bg_color_backside'] : $background_color_back;
                        $title_back_color  = ( ! $title_back_color ) ? $smof_data['flip_boxes_back_heading'] . $evl_options['evl_shortcode_flip_heading_color_backside'] : $title_back_color;
                        $text_back_color  = ( ! $text_back_color ) ? $smof_data['flip_boxes_back_text'] . $evl_options['evl_shortcode_flip_text_color_backside'] : $text_back_color;
                        $border_size  = ( ! $border_size ) ? $smof_data['flip_boxes_border_size'] . $evl_options['evl_shortcode_flip_border_size'] : $border_size;
                        $border_size = (float)$border_size;
                        $border_color  = ( ! $border_color ) ? $smof_data['flip_boxes_border_color'] . $evl_options['evl_shortcode_flip_border_color'] : $border_color;
                        $border_radius  = ( ! $border_radius ) ? $smof_data['flip_boxes_border_radius'] . $evl_options['evl_shortcode_flip_border_radius'] : $border_radius;
                        $border_radius = (float)$border_radius;
                        $icon  = ( ! $icon ) ? '' : $icon;
                        $icon_color  = ( ! $icon_color ) ? $smof_data['icon_color'] . $evl_options['evl_shortcode_icon_color'] : $icon_color;
                        $circle  = ( ! $circle ) ? '' : $circle;
                        $circle_color  = ( ! $circle_color ) ? $smof_data['icon_circle_color'] . $evl_options['evl_shortcode_icon_circle_color'] : $circle_color;
                        $circle_border_color = ( ! $circle_border_color ) ? $smof_data['icon_border_color'] . $evl_options['evl_shortcode_icon_circle_border_color'] : $circle_border_color;
                        $icon_flip  = ( ! $icon_flip ) ? '' : $icon_flip;
                        $icon_rotate  = ( ! $icon_rotate ) ? '' : $icon_rotate;
                        $icon_spin = ( ! $icon_spin ) ? '' : $icon_spin;
                        $image  = ( ! $image ) ? '' : $image;
                        $image_width  = ( ! $image_width ) ? '35' : $image_width;
                        $image_height  = ( ! $image_height ) ? '35' : $image_height;

                        //icon_attr        
                        if( $image ) {
                                $icon_attr_class = 'image';
                        } else if( $icon ) {
                                $icon_attr_class = sprintf( 'fa %s', T4PCore_Plugin::font_awesome_name_handler( $icon ) );
                        }

                        $grafix_attr_style = '';
                        if( $icon_color ) {
                                $grafix_attr_style = sprintf( 'color:%s;', $icon_color );
                        }

                        if( $icon_flip ) {
                                $icon_attr_class .= ' fa-flip-' . $icon_flip;
                        }		

                        if( $icon_rotate ) {
                                $icon_attr_class .= ' fa-rotate-' . $icon_rotate;
                        }

                        if( $icon_spin == 'yes' ) {
                                $icon_attr_class .= ' fa-spin';
                        }

                        //grafix_attr
                        $grafix_attr_class = 'flip-box-grafix';

                        if( ! $image ) {

                                if( $circle == 'yes' ) {
                                        $grafix_attr_class .= ' flip-box-circle';

                                        if( $circle_color ) {
                                                $grafix_attr_style .= sprintf( 'background-color:%s;', $circle_color );
                                        }

                                        if( $circle_border_color ) {
                                                $grafix_attr_style .= sprintf( 'border-color:%s;', $circle_border_color );
                                        }			

                                } else {
                                        $grafix_attr_class .= ' flip-box-no-circle';
                                }
                        } else {
                                $grafix_attr_class .= ' flip-box-image';
                        }
                        
                        //heading_front_attr
                        $heading_front_attr_class = 'flip-box-heading';

                        if( ! $text_front ) {
                                $heading_front_attr_class .= ' without-text';
                        }

                        if( $title_front_color ) {
                                $heading_front_attr_style = sprintf( 'color:%s;', $title_front_color );
                        }
                        
                        //heading_back_attr   
                        $heading_back_attr_class = 'flip-box-heading-back';

                        if( $title_back_color ) {
                                $heading_back_attr_style = sprintf( 'color:%s;', $title_back_color );
                        }
                        
                        //front_box_attr        
                        $front_box_attr_style = '';

                        $front_box_attr_class = 'flip-box-front';

                        if( $background_color_front ) {
                                $front_box_attr_style = sprintf( 'background-color:%s;', $background_color_front );
                        }

                        if( $border_color ) {
                                $front_box_attr_style .= sprintf( 'border-color:%s;', $border_color );
                        }

                        if( $border_radius ) {
                                $front_box_attr_style .= sprintf( 'border-radius:%spx;', $border_radius );
                        }

                        if( $border_size ) {
                                $front_box_attr_style .= sprintf( 'border-style:solid;border-width:%spx;', $border_size );
                        }

                        if( $text_front_color ) {
                                $front_box_attr_style .= sprintf( 'color:%s;', $text_front_color );
                        }

                        //back_box_attr        
                        $back_box_attr_style = '';
                        
                        $back_box_attr_class = 'flip-box-back';

                        if( $background_color_back ) {
                                $back_box_attr_style = sprintf( 'background-color:%s;', $background_color_back );
                        }

                        if( $border_color ) {
                                $back_box_attr_style .= sprintf( 'border-color:%s;', $border_color );
                        }

                        if( $border_radius ) {
                                $back_box_attr_style .= sprintf( 'border-radius:%spx;', $border_radius );
                        }

                        if( $border_size ) {
                                $back_box_attr_style .= sprintf( 'border-style:solid;border-width:%spx;', $border_size );
                        }

                        if( $text_back_color ) {
                                $back_box_attr_style .= sprintf( 'color:%s;', $text_back_color );
                        }	
                        
                        //child_attr
                        if( $parent_atts['columns'] ) {
                                $columns = 12 / $parent_atts['columns'];
                        } else {
                                $columns = 4;
                        }

                        $child_attr_class = sprintf('t4p-flip-box-wrapper col-lg-%s col-md-%s col-sm-%s', $columns, $columns, $columns );

                        
                        //Render the child html

                        $style = $icon_output = $title_output = $title_front_output = $title_back_output = '';

                        if( $image && $image_width && $image_height ) {
                                $icon_output = sprintf( '<img src="%s" width="%spx" height="%spx" />', $image, $image_width, $image_height );
                        } else if( $icon ) {
                                $icon_output = "<i class='$icon_attr_class'></i>";
                        }

                        if( $icon_output ) {
                                $icon_output = "<div class='$grafix_attr_class' style='$grafix_attr_style'>$icon_output</div>";
                        } else {
                                $icon_output = '';
                        }

                        if( $title_front ) {
                                $title_front_output = "<h2 class='$heading_front_attr_class' style='$heading_front_attr_style'>$title_front</h2>";
                        }

                        if( $title_back ) {
                                $title_back_output = "<h3 class='$heading_back_attr_class' style='$heading_back_attr_style'>$title_back</h3>";
                        }

                        $front_inner = "<div class='flip-box-front-inner'>$icon_output $title_front_output $text_front</div>";
                        $back_inner = "<div class='flip-box-back-inner'>$title_back_output".do_shortcode( $content )."</div>";

                        $front = "<div class='$front_box_attr_class' style='$front_box_attr_style'>$front_inner</div>";
                        $back = "<div class='$back_box_attr_class' style='$back_box_attr_style'>$back_inner</div>";

                        $html = "<div class='$child_attr_class'><div class='t4p-flip-box'><div class='flip-box-inner-wrapper'>$front$back</div></div></div>";

                        $this->flipbox_counter++;

			return $html . "<!--seperate-->";
                }

	}

}
