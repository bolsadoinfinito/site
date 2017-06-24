<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */
if ( ! class_exists( 'Buttonbar' ) ) {

/**
 * Create multiple button elements
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    2.1.0
 */
	class Buttonbar extends T4P_Pb_Shortcode_Child {

                private $button_counter = 1;

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
		 * Define shortcode settings.
		 *
		 * @return  void
		 */
                public function element_items() {
			$this->items = array(
				'Notab' => array(
                                    array(
                                            'name'    => __( 'Button Text', 't4p-core' ),
                                            'id'      => 'text',
                                            'type'    => 'text_field',
                                            'std'     => 'Button Title',
                                            'tooltip' => __( 'Add the text that will display in the button.', 't4p-core' ),
                                    ),
                                    array(
                                            'name'       => __( 'Button URL', 't4p-core' ),
                                            'id'         => 'link',
                                            'type'       => 'text_field',
                                            'class'      => 'input-sm',
                                            'tooltip' => __( 'Add the button url ex: http://example.com', 't4p-core' ),
                                    ),
                                    array(
                                            'name'    => __( 'Button Title Attribute ', 't4p-core' ),
                                            'id'      => 'title',
                                            'type'    => 'text_field',
                                            'role'    => 'title',
                                            'tooltip' => __( 'Set a title attribute for the button link.', 't4p-core' ),
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
                                            'name'      => __( 'Select Custom Icon', 't4p-core' ),
                                            'id'        => 'icon',
                                            'type'      => 'icons',
                                            'std'       => '',
                                            'role'      => 'title_prepend',
                                            'title_prepend_type' => 'icon',
                                            'tooltip' => __( 'Click an icon to select, click None to deselect', 't4p-core' )
                                    ),
                                    array(
                                           'name'       => __( 'Icon Position', 't4p-core' ),
                                           'id'         => 'icon_position',
                                           'type'       => 'radio',
                                           'std'        => 'left',
                                           'options'    => array( 'left' => __( 'Left', 't4p-core' ), 'right' => __( 'Right', 't4p-core' ) ),
                                           'tooltip'    => __( 'Choose the position of the icon on the button.', 't4p-core' )
                                    ),
                                    array(
                                           'name'       => __( 'Icon Divider', 't4p-core' ),
                                           'id'         => 'icon_divider',
                                           'type'       => 'radio',
                                           'std'        => 'yes',
                                           'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                           'tooltip'    => __( 'Choose to display a divider between icon and text.', 't4p-core' )
                                    ),
                                    array(
                                            'name'    => __( 'Button Style', 't4p-core' ),
                                            'id'      => 'color',
                                            'type'    => 'select',
                                            'class'   => 'input-sm',
                                            'options'    => array(
                                                    'default'      => __( 'Default', 't4p-core' ),
                                                    'custom'   => __( 'Custom', 't4p-core' ),
                                                    'green'    => __( 'Green', 't4p-core' ),
                                                    'darkgreen'      => __( 'Dark Green', 't4p-core' ),
                                                    'orange'   => __( 'Orange', 't4p-core' ),
                                                    'blue'    => __( 'Blue', 't4p-core' ),
                                                    'red'      => __( 'Red', 't4p-core' ),
                                                    'pink'   => __( 'Pink', 't4p-core' ),
                                                    'darkgray'    => __( 'Dark Gray', 't4p-core' ),
                                                    'lightgray'      => __( 'Light Gray', 't4p-core' ),
                                            ),
                                            'tooltip' => __( 'Select the button color. Select default or color name for theme options, or select custom to use advanced color options.', 't4p-core' ),
                                            'has_depend' => '1',
                                    ),
                                    array(
                                            'name'    => __( 'Button Size', 't4p-core' ),
                                            'id'      => 'size',
                                            'type'    => 'select',
                                            'class'   => 'input-sm',
                                            'std'     => T4P_Pb_Helper_Type::get_first_option( T4P_Pb_Helper_Type::get_button_size() ),
                                            'options' => T4P_Pb_Helper_Type::get_button_size(),
                                            'tooltip' => __( 'Select the button size. Choose default for theme option selection.', 't4p-core' ),
                                    ),
                                    array(
                                            'name'       => __( 'Button Type', 't4p-core' ),
                                            'id'         => 'type',
                                            'type'       => 'select',
                                            'class'   => 'input-sm',
                                            'options'    => array(
                                                                    ''      => __( 'Default', 't4p-core' ),
                                                                    'flat'   => __( 'Flat', 't4p-core' ),
                                                                    '3d'    => __( '3D', 't4p-core' )
                                                            ),
                                            'tooltip'    => __( 'Select the button type. Choose default for theme option selection.', 't4p-core' )
                                    ),
                                    array(
                                            'name'       => __( 'Button Shape', 't4p-core' ),
                                            'id'         => 'shape',
                                            'type'       => 'select',
                                            'class'   => 'input-sm',
                                            'options'    => array(
                                                                    ''      => __( 'Default', 't4p-core' ),
                                                                    'square'   => __( 'Square', 't4p-core' ),
                                                                    'pill'    => __( 'Pill', 't4p-core' ),
                                                                    'round'    => __( 'Round', 't4p-core' ),
                                                            ),
                                            'tooltip'    => __( 'Select the button shape. Choose default for theme option selection.', 't4p-core' )
                                    ),
                                    array(
                                            'name' => __( 'Button Gradient Top Color', 't4p-core' ),
                                            'type' => array(
                                                    array(
                                                            'id'           => 'gradient_top_color',
                                                            'type'         => 'color_picker',
                                                            'std'          => '',
                                                            'parent_class' => 'combo-item',
                                                    ),
                                            ),
                                            'dependency'  => array( 'color', '=', 'custom' ),
                                            'tooltip' => __( 'Custom setting only. Set the top color of the button background.', 't4p-core' )
                                    ),
                                    array(
                                            'name' => __( 'Button Gradient Bottom Color', 't4p-core' ),
                                            'type' => array(
                                                    array(
                                                            'id'           => 'gradient_bottom_color',
                                                            'type'         => 'color_picker',
                                                            'std'          => '',
                                                            'parent_class' => 'combo-item',
                                                    ),
                                            ),
                                            'dependency'  => array( 'color', '=', 'custom' ),
                                            'tooltip' => __( 'Custom setting only. Set the bottom color of the button background or leave empty for solid color.', 't4p-core' )
                                    ),
                                    array(
                                            'name' => __( 'Button Gradient Top Color Hover', 't4p-core' ),
                                            'type' => array(
                                                    array(
                                                            'id'           => 'gradient_top_hover_color',
                                                            'type'         => 'color_picker',
                                                            'std'          => '',
                                                            'parent_class' => 'combo-item',
                                                    ),
                                            ),
                                            'dependency'  => array( 'color', '=', 'custom' ),
                                            'tooltip' => __( 'Custom setting only. Set the top hover color of the button background.', 't4p-core' )
                                    ),
                                    array(
                                            'name' => __( 'Button Gradient Bottom Color Hover', 't4p-core' ),
                                            'type' => array(
                                                    array(
                                                            'id'           => 'gradient_bottom_hover_color',
                                                            'type'         => 'color_picker',
                                                            'std'          => '',
                                                            'parent_class' => 'combo-item',
                                                    ),
                                            ),
                                            'dependency'  => array( 'color', '=', 'custom' ),
                                            'tooltip' => __( 'Custom setting only. Set the bottom hover color of the button background or leave empty for solid color.', 't4p-core' )
                                    ),
                                    array(
                                            'name' => __( 'Accent Color', 't4p-core' ),
                                            'type' => array(
                                                    array(
                                                            'id'           => 'accent_color',
                                                            'type'         => 'color_picker',
                                                            'std'          => '',
                                                            'parent_class' => 'combo-item',
                                                    ),
                                            ),
                                            'dependency'  => array( 'color', '=', 'custom' ),
                                            'tooltip' => __( 'Custom setting only. This option controls the color of the button border, divider, text and icon.', 't4p-core' )
                                    ),
                                    array(
                                            'name' => __( 'Accent Hover Color', 't4p-core' ),
                                            'type' => array(
                                                    array(
                                                            'id'           => 'accent_hover_color',
                                                            'type'         => 'color_picker',
                                                            'std'          => '',
                                                            'parent_class' => 'combo-item',
                                                    ),
                                            ),
                                            'dependency'  => array( 'color', '=', 'custom' ),
                                            'tooltip' => __( 'Custom setting only. This option controls the hover color of the button border, divider, text and icon.', 't4p-core' )
                                    ),
                                    array(
                                            'name' => __( 'Bevel Color (3D Mode only)', 't4p-core' ),
                                            'type' => array(
                                                    array(
                                                            'id'           => 'bevel_color',
                                                            'type'         => 'color_picker',
                                                            'std'          => '',
                                                            'parent_class' => 'combo-item',
                                                    ),
                                            ),
                                            'dependency'  => array( 'color', '=', 'custom' ),
                                            'tooltip' => __( 'Custom setting only. Set the bevel color of 3D buttons.', 't4p-core' )
                                    ),
                                    array(
                                            'name' => __( 'Border Width', 't4p-core' ),
                                            'type' => array(
                                                    array(
                                                            'id'         => 'border_width',
                                                            'type'       => 'text_append',
                                                            'type_input' => 'text_field',
                                                            'class'      => 'input-mini',
                                                            'std'        => '1px',
                                                    ),
                                            ),
                                            'dependency'  => array( 'color', '=', 'custom' ),
                                            'tooltip' => __( 'Custom setting only. Border width in pixels (px), ex: 1px.', 't4p-core' )
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
                                            'dependency'  => array( 'color', '=', 'custom' ),
                                            'tooltip' => __( 'Custom setting. Backside.', 't4p-core' )
                                    ),
                                    array(
                                            'name' => __( 'Border Hover Color', 't4p-core' ),
                                            'type' => array(
                                                    array(
                                                            'id'           => 'border_hover_color',
                                                            'type'         => 'color_picker',
                                                            'std'          => '',
                                                            'parent_class' => 'combo-item',
                                                    ),
                                            ),
                                            'dependency'  => array( 'color', '=', 'custom' ),
                                            'tooltip' => __( 'Custom setting. Backside', 't4p-core' )
                                    ),
                                    array(
                                            'name'       => __( 'Box Shadow', 't4p-core' ),
                                            'id'         => 'shadow',
                                            'type'       => 'select',
                                            'class'   => 'input-sm',
                                            'options'    => array(
                                                                    ''      => __( 'Default', 't4p-core' ),
                                                                    'yes'   => __( 'Yes', 't4p-core' ),
                                                                    'no'    => __( 'No', 't4p-core' )
                                                            ),
                                            'tooltip'    => __( 'Choose to enable/disable the shadows. Choose default for theme option selection.', 't4p-core' )
                                    ),
                                    array(
                                            'name'       => __( 'Modal Window Anchor', 't4p-core' ),
                                            'id'         => 'modal',
                                            'type'       => 'text_field',
                                            'class'      => 'input-sm',
                                            'tooltip' => __( 'Add the class name of the modal window you want to open on button click.', 't4p-core' ),
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
                global $evl_options, $smof_data;
                        $arr_params   = shortcode_atts( $this->config['params'], $atts );
                        extract( $arr_params );
                        $href = ( ! $link ) ? 'href=""' : 'href="'.$link.'"';
                        $text  = ( ! $text ) ? '' : $text;
                        $title  = ( ! $title ) ? 'title=""' : 'title="'.$title.'"';
                        $target = ( ! $target ) ? 'target="_self"' : 'target="'.$target.'"';
                        $icon  = ( ! $icon ) ? '' : "<i class='fa {$icon}'></i>";
                        $icon_position  = ( ! $icon_position ) ? 'left' : $icon_position;
                        $icon_divider  = ( ! $icon_divider ) ? 'yes' : $icon_divider;
                        $color = ( ! $color ) ? 'default' : $color;
                $size  = ( ! $size ) ? strtolower($smof_data['button_size']) . strtolower($evl_options['evl_shortcode_button_size']) : $size;
                $type = ( ! $type ) ? strtolower($smof_data['button_type']) . strtolower($evl_options['evl_shortcode_button_type']) : $type;
                $shape = ( ! $shape ) ? strtolower($smof_data['button_shape']) . strtolower($evl_options['evl_shortcode_button_shape']) : $shape;

                        if ( isset ($atts['gradient_colors']) && $atts['gradient_colors'] ) {
                            $grad_colors = explode('|', $atts['gradient_colors']);
                    $gradient_top_color = ( ! $grad_colors[0] ) ? strtolower($smof_data['button_gradient_top_color']) . strtolower($evl_options['evl_shortcode_button_gradient_top_color']) : $grad_colors[0];
                    $gradient_bottom_color = ( ! $grad_colors[1] ) ? strtolower($smof_data['button_gradient_bottom_color']) . strtolower($evl_options['evl_shortcode_button_gradient_bottom_color']) : $grad_colors[1];
                        } else {
                    $gradient_top_color = ( ! $gradient_top_color ) ? strtolower($smof_data['button_gradient_top_color']) . strtolower($evl_options['evl_shortcode_button_gradient_top_color']) : $gradient_top_color;
                    $gradient_bottom_color = ( ! $gradient_bottom_color ) ? strtolower($smof_data['button_gradient_bottom_color']) . strtolower($evl_options['evl_shortcode_button_gradient_bottom_color']) : $gradient_bottom_color;
                        }

                        if ( isset ($atts['gradient_hover_colors']) && $atts['gradient_hover_colors'] ) {
                            $gradient_hover_colors = explode('|', $atts['gradient_hover_colors']);
                    $gradient_top_hover_color = ( ! $gradient_hover_colors[0] ) ? strtolower($smof_data['button_gradient_top_color_hover']) . strtolower($evl_options['evl_shortcode_button_gradient_top_hover_color']) : $gradient_hover_colors[0];
                    $gradient_bottom_hover_color = ( ! $gradient_hover_colors[1] ) ? strtolower($smof_data['button_gradient_bottom_color_hover']) . strtolower($evl_options['evl_shortcode_button_gradient_bottom_hover_color']) : $gradient_hover_colors[1];
                        } else {
                    $gradient_top_hover_color = ( ! $gradient_top_hover_color ) ? strtolower($smof_data['button_gradient_top_color_hover']) . strtolower($evl_options['evl_shortcode_button_gradient_top_hover_color']) : $gradient_top_hover_color;
                    $gradient_bottom_hover_color = ( ! $gradient_bottom_hover_color ) ? strtolower($smof_data['button_gradient_bottom_color_hover']) . strtolower($evl_options['evl_shortcode_button_gradient_bottom_hover_color']) : $gradient_bottom_hover_color;
                        }

                $accent_color = ( ! $accent_color ) ? strtolower($smof_data['button_accent_color']) . strtolower($evl_options['evl_shortcode_button_accent_color']) : $accent_color;
                $accent_hover_color = ( ! $accent_hover_color ) ? strtolower($smof_data['button_accent_hover_color']) . strtolower($evl_options['evl_shortcode_button_accent_hover_color']) : $accent_hover_color;
                $bevel_color = ( ! $bevel_color ) ? strtolower($smof_data['button_bevel_color']) . strtolower($evl_options['evl_shortcode_button_bevel_color']) : $bevel_color;
                $border_width = ( ! $border_width ) ? strtolower($smof_data['button_border_width']) . strtolower($evl_options['evl_shortcode_button_border_width']) : $border_width;
                        $border_width = (float)$border_width;
                        if ( $color != 'custom' && $color != 'default' ) {
                            $border_color = '';
                        } elseif ( $color == 'custom' && $accent_color && !$border_color ) {
                            $border_color = $accent_color;
                        } elseif (!$border_color) {
                    $border_color =  strtolower($smof_data['button_border_color']) . strtolower($evl_options['evl_shortcode_button_border_color']);
                        } else {
                            $border_color = $border_color;
                        }
                $border_hover_color = ( ! $border_hover_color ) ? strtolower($smof_data['button_border_color_hover']) . strtolower($evl_options['evl_shortcode_button_border_hover_color']) : $border_hover_color;
                $shadow = ( ! $shadow ) ? strtolower($smof_data['button_text_shadow']) . strtolower($evl_options['evl_shortcode_button_shadow']) : $shadow;
                        $modal = ( ! $modal ) ? '' : $modal;

                        $clerfix = "<div class='clearfix'></div>";

                        $modaltype = '';
                        if ( isset( $modal ) && $modal ) {
                               $modaltype .= "data-toggle='modal'";
                               $modaltype .= 'data-target=".'.$modal.'"';
                        }

                        if ( $icon && $icon_divider == 'yes' ) {
                            $span = "<span class='t4p-button-text-{$icon_position}' >{$text}</span>";
                        } else {
                            $span = "<span class='t4p-button-text' >{$text}</span>";
                        }

                        if ( $icon ) {
                            if($icon_divider != 'yes') {
                                $icon_span = "<span class='button-icon-{$icon_position}' >{$icon}</span>";
                            } else {
                                $icon_span = "<span class='button-icon-divider-{$icon_position}' >{$icon}</span>";
                            }
                        } else {
                            $icon_span = "";
                        }

                        $styles = $general_styles = $button_3d_styles = $hover_styles = $gradient_styles = $gradient_hover_styles = '';
                        if ( ( $color == 'custom' || $color == 'default' ) && ( $bevel_color || $accent_color || $accent_hover_color || $border_width || $gradient_top_color || $gradient_bottom_color ) ) {

                            $styles = '<style scoped>';

                            if ( $type == '3d' && $bevel_color ) {
                                if ( $size == 'small' ) {
                                    $button_3d_add = 0;
                                } elseif ($size == 'medium') {
                                    $button_3d_add = 1;
                                } elseif ($size == 'large') {
                                    $button_3d_add = 2;
                                } elseif ($size == 'xlarge') {
                                    $button_3d_add = 3;
                                }

                                $button_3d_shadow_part_1 = 'inset 0px 1px 0px #fff,';

                                $button_3d_shadow_part_2 = sprintf('0px %spx 0px %s,', 2 + $button_3d_add, $bevel_color);

                                $button_3d_shadow_part_3 = sprintf('1px %spx %spx 3px rgba(0,0,0,0.3)', 4 + $button_3d_add, 4 + $button_3d_add);
                                if ( $size == 'small' ) {
                                    $button_3d_shadow_part_3 = str_replace('3px', '2px', $button_3d_shadow_part_3);
                                }

                                $button_3d_shadow = $button_3d_shadow_part_1 . $button_3d_shadow_part_2 . $button_3d_shadow_part_3;

                                $button_3d_styles = sprintf('-webkit-box-shadow: %s;-moz-box-shadow: %s;box-shadow: %s;', $button_3d_shadow, $button_3d_shadow, $button_3d_shadow);

                                if ($gradient_bottom_hover_color) {
                                    $gradient_bottom_hover_color_trim = str_replace('#', '', $gradient_bottom_hover_color);
                                    $bevel_color_hover = '#' . t4p_hexdarker($gradient_bottom_hover_color_trim);
                                }
                                $button_3d_shadow_hover_part_1 = 'inset 0px 1px 0px #fff,';

                                $button_3d_shadow_hover_part_2 = sprintf('0px %spx 0px %s,', 2 + $button_3d_add, $bevel_color_hover);

                                $button_3d_shadow_hover_part_3 = sprintf('1px %spx %spx 3px rgba(0,0,0,0.3)', 4 + $button_3d_add, 4 + $button_3d_add);
                                if ( $size == 'small' ) {
                                    $button_3d_shadow_hover_part_3 = str_replace('3px', '2px', $button_3d_shadow_hover_part_3);
                                }

                                $button_3d_shadow_hover = $button_3d_shadow_hover_part_1 . $button_3d_shadow_hover_part_2 . $button_3d_shadow_hover_part_3;

                                $button_3d_styles_hover = sprintf('-webkit-box-shadow: %s;-moz-box-shadow: %s;box-shadow: %s;', $button_3d_shadow_hover, $button_3d_shadow_hover, $button_3d_shadow_hover);
                            }

                            if ( $shadow == 'no' ) {
                                $general_styles .= 'text-shadow:none;';
                                if ( $type != '3d' ) {
                                    $general_styles .= '-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow: none;';
                                }
                            }

                            if ( $border_width || $border_width == 0 ) {
                                $general_styles .= sprintf('border-width:%spx;', $border_width);
                                $hover_styles .= sprintf('border-width:%spx;', $border_width);
                            }

                            if ($accent_color) {
                                    $general_styles .= sprintf('color:%s;', $accent_color . '!important');
                                    $general_styles .= sprintf('border-color:%s;', $border_color);
                            }

                            if ($border_color) {
                                $general_styles .= sprintf('border-color:%s;', $border_color);
                            }

                            if ($accent_hover_color) {
                                $hover_styles .= sprintf('border-color:%s;', $accent_hover_color);
                            } elseif ($accent_color) {
                                $hover_styles .= sprintf('border-color:%s;', $accent_color);
                            }

                            if ($accent_hover_color) {
                                $hover_styles .= sprintf('color:%s;', $accent_hover_color . '!important');
                            }

                            if ($accent_color) {
                                $general_styles .= sprintf('color:%s;', $accent_color . '!important');
                            }

                            if ($border_hover_color) {
                                $hover_styles .= sprintf('border-color:%s;', $border_hover_color . '!important');
                            }

                            // Apply general styles
                            if ($general_styles) {
                                $styles .= sprintf('.t4p-button.button-%s{%s}', $this->button_counter, $general_styles);
                            }

                            // Apply 3d styles
                            if ($button_3d_styles && $shadow == 'yes') {
                                $styles .= sprintf('.t4p-button.button-%s.button-3d{%s}.button-%1$s.button-3d:active{%2$s}', $this->button_counter, $button_3d_styles);
                            }

                            // Apply hover styles
                            if ($hover_styles) {
                                $styles .= sprintf('.t4p-button.button-%s:hover,.t4p-button.button-%s:focus,.t4p-button.button-%s:active{%s}', $this->button_counter, $this->button_counter, $this->button_counter, $hover_styles);
                            }

                            // Apply 3d hover styles
                            if (isset($button_3d_styles_hover) && $button_3d_styles_hover && $shadow == 'yes') {
                                $styles .= sprintf('.t4p-button.button-%s.button-3d:hover{%s}.button-%1$s.button-3d:hover{%2$s}.button-%1$s.button-3d:focus{%2$s}.button-%1$s.button-3d:active{%2$s}', $this->button_counter, $button_3d_styles_hover);
                            }

                            if ($gradient_top_color && $gradient_bottom_color) {

                                if ( $gradient_bottom_color == '' ) {
                                    $gradient_styles = "background: $gradient_top_color;";
                                } else {
                                    $gradient_styles = "background: {$gradient_top_color};
                                                        background-image: -webkit-gradient( linear, left bottom, left top, from( $gradient_bottom_color ), to( $gradient_top_color) );
                                                        background-image: -webkit-linear-gradient( bottom, $gradient_bottom_color, $gradient_top_color);
                                                        background-image:    -moz-linear-gradient( bottom, $gradient_bottom_color, $gradient_top_color);
                                                        background-image:      -o-linear-gradient( bottom, $gradient_bottom_color, $gradient_top_color);
                                                        background-image: linear-gradient( to top, $gradient_bottom_color, $gradient_top_color);";
                                }

                                $styles .= sprintf('.t4p-button.button-%s{%s}', $this->button_counter, $gradient_styles);
                            }

                            if ($gradient_top_hover_color && $gradient_bottom_hover_color) {

                                if ( $gradient_bottom_hover_color == '' ) {
                                    $gradient_hover_styles = "background: $gradient_top_hover_color;";
                                } else {
                                    $gradient_hover_styles .=
                                            "background: $gradient_top_hover_color;
                                                        background-image: -webkit-gradient( linear, left bottom, left top, from( {$gradient_bottom_hover_color} ), to( $gradient_top_hover_color ) );
                                                        background-image: -webkit-linear-gradient( bottom, {$gradient_bottom_hover_color}, $gradient_top_hover_color );
                                                        background-image:    -moz-linear-gradient( bottom, {$gradient_bottom_hover_color}, $gradient_top_hover_color );
                                                        background-image:      -o-linear-gradient( bottom, {$gradient_bottom_hover_color}, $gradient_top_hover_color );
                                                        background-image: linear-gradient( to top, {$gradient_bottom_hover_color}, $gradient_top_hover_color );";
                                }

                                $styles .= sprintf('.t4p-button.button-%s:hover,.button-%s:focus,.t4p-button.button-%s:active{%s}', $this->button_counter, $this->button_counter, $this->button_counter, $gradient_hover_styles);
                            }

                            $styles .= '</style>';
                        } else {
                            if ($shadow == 'no') {
                                $styles = '<style scoped>';
                                    $general_styles = 'text-shadow:none;';
                                    if ($type != '3d') {
                                        $general_styles .= 'box-shadow: none;';
                                    }
                                    if ($general_styles) {
                                        $styles .= sprintf('.t4p-button.button-%s{%s}', $this->button_counter, $general_styles);
                                    }
                                $styles .= '</style>';
                            }
                        }

                        /**
                         * If color is not "default" or "custom"
                         * Right now just "border color" fix applied,
                         * later can be added any aditional data
                         */
                        if ($color !== 'default' || $color !== 'custom') {
                            $styles .= '<style scoped>';

                            // If accent color set, let's apply it. | Else default border color from style.css will be aplied.
                            if ($accent_color) {
                                $general_styles .= sprintf('color:%s;', $accent_color . '!important');
                            }

                            // If accent hover color set, let's apply it. | Else default border hover color from theme options will be applied.
                            if ($accent_hover_color) {
                                $hover_styles .= sprintf('color:%s;', $accent_hover_color . '!important');
                            }

                            // If border color set, let's apply it. | Else default border color from style.css will be aplied.
                            if ($border_color) {
                                $general_styles .= sprintf('border-color:%s;', $border_color);
                            }

                            // If border hover color set, let's apply it. | Else default border hover color from theme options will be applied.
                            if ($border_hover_color) {
                                $hover_styles .= sprintf('border-color:%s;', $border_hover_color . '!important');
                            }

                            // Apply general style
                            if ($general_styles) {
                                $styles .= sprintf('.t4p-button.button-%s{%s}', $this->button_counter, $general_styles);
                            }

                            // Apply hover style
                            if ($hover_styles) {
                                $styles .= sprintf('.t4p-button.button-%s:hover,.t4p-button.button-%s:focus,.t4p-button.button-%s:active{%s}', $this->button_counter, $this->button_counter, $this->button_counter, $hover_styles);
                            }

                            $styles .= '</style>';
                        }

                        $inner_html = ( $icon_divider != 'yes' && $icon_position == 'right' ) ? $span.$icon_span : $icon_span.$span;

                        $html_result = "{$styles}<a class='btn-default button {$size} button {$color} t4p-button button-{$type} button-{$shape} button-{$size} button-{$color} button-$this->button_counter buttonshadow-{$shadow}' type='message/http' {$modaltype} {$href} {$target} {$title}>{$inner_html}</a> ";

                        $this->button_counter++;

			return $html_result . '<!--seperate-->';
		}

	}

}