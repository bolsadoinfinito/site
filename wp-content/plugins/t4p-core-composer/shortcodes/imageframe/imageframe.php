<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */


if ( ! class_exists( 'Imageframe' ) ) :

/**
 * Create Imageframe element
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Imageframe extends T4P_Pb_Shortcode_Element {

        private $imageframe_counter = 1;

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
		$this->config['name']        = __( 'Image Frame', 't4p-core' );
		$this->config['cat']         = __( 'Media', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-image';
		$this->config['description'] = __( 'Simple image with animation', 't4p-core' );

		// Define exception for this shortcode
                $this->config['exception'] = array(
                        'admin_assets' => array(
                                // Shortcode initialization
                                't4p-pb-image-js',
                        ),
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
			'content' => array(
                                array(
                                        'name'    => __( 'Image', 't4p-core' ),
                                        'id'      => 'image',
					'type'    => 'select_media',
                                        'std'     => '',
                                        'class'   => 'jsn-input-large-fluid',
                                        'tooltip' => __( 'Upload an image to display in the frame', 't4p-core' )
                                ),
                                array(
                                        'name'    => __( 'Image Size', 't4p-core' ),
                                        'id'      => 'image_size',
                                        'type'    => 'large_image',
                                        'std'     => 'full',
                                        'tooltip' => __( 'Set image size', 't4p-core' )
                                ),
                                array(
                                        'name'    => __( 'Image Alt Text', 't4p-core' ),
                                        'id'      => 'alt',
                                        'type'    => 'text_field',
                                        'class'   => 'input-sm',
                                        'std'     => '',
                                        'tooltip' => __( 'The alt attribute provides alternative information if an image cannot be viewed', 't4p-core' )
                                ),
                        ),
			'styling' => array(
				array(
							'type' => 'preview',
				),
                                array(
                                    'name'       => __( 'Frame Style Type', 't4p-core' ),
                                    'id'         => 'style_type',
                                    'type'       => 'select',
                                    'class'      => 'input-sm',
                                    'std'        => 'none',
                                    'options'    => array(
                                                            'none'      => __( 'None', 't4p-core' ),
                                                            'border'   => __( 'Border', 't4p-core' ),
                                                            'glow'    => __( 'Glow', 't4p-core' ),
                                                            'dropshadow'    => __( 'Drop Shadow', 't4p-core' ),
                                                            'bottomshadow'    => __( 'Bottom Shadow', 't4p-core' ),
                                                    ),
                                    'tooltip'    => __( 'Select the frame style type.', 't4p-core' ),
                                ),
                                array(
                                    'name'       => __( 'Border Color', 't4p-core' ),
                                    'type' => array(
                                            array(
                                                    'id'           => 'bordercolor',
                                                    'type'         => 'color_picker',
                                                    'std'          => '',
                                                    'parent_class' => 'combo-item',
                                            ),
                                    ),
                                    'tooltip'    => __( 'For border style only. Controls the border color. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Border Size', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'         => 'bordersize',
                                                        'type'       => 'text_append',
                                                        'type_input' => 'text_field',
                                                        'class'      => 'input-mini',
                                                        'std'        => '1px',
                                                ),
                                        ),
                                        'tooltip' => __( 'For border style only. In pixels (px), ex: 1px. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Style Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'stylecolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip'    => __( 'For all style types except border. Controls the style color. Leave blank for theme option selection.', 't4p-core' )
                                ),
                            	array(
                                        'name'    => __( 'Align', 't4p-core' ),
                                        'id'      => 'align',
                                        'class'   => 'input-sm',
                                        'type'    => 'radio_button_group',
                                        'std'     => T4P_Pb_Helper_Type::get_first_option( T4P_Pb_Helper_Type::get_text_align() ),
                                        'options' => T4P_Pb_Helper_Type::get_text_align(),
                                        'tooltip'    => __( 'Choose how to align the image', 't4p-core' )
				),
                                array(
                                        'name'      => __( 'Image lightbox', 't4p-core' ),
                                        'id'        => 'lightbox',
                                        'type'      => 'select',
                                        'class'     => 'input-sm',
                                        'std'       => 'no',
                                        'options'   => array(
                                                                'yes'   => __( 'Yes', 't4p-core' ),
                                                                'no'    => __( 'No', 't4p-core' )
                                                        ),
                                        'tooltip'   => __( 'Show image in Lightbox', 't4p-core' )
                                ),
				array(
                                        'name'            => __( 'Margin', 't4p-core' ),
                                        'container_class' => 'combo-group',
                                        'id'              => 'image_margin',
                                        'type'            => 'margin',
                                        'extended_ids'    => array( 'image_margin_top', 'image_margin_right', 'image_margin_bottom', 'image_margin_left' ),
                                        'image_margin_top'    => array( 'std' => '' ),
                                        'image_margin_bottom' => array( 'std' => '' ),
                                        'tooltip'             => __( 'External spacing with other elements', 't4p-core' )
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
                global $evl_options, $smof_data;
		$arr_params     = shortcode_atts( $this->config['params'], $atts );
		extract( $arr_params );
		$image = ( ! $image ) ? '' : $image;
                $alt = ( ! $alt ) ? '' : $alt;
                $style_type = ( ! $style_type ) ? 'none' : $style_type;
                $bordercolor = ( ! $bordercolor ) ? $smof_data['imgframe_border_color'] . strtolower($evl_options['evl_shortcode_image_frame_border_color']) : $bordercolor;
                $bordersize = ( ! $bordersize ) ? $smof_data['imageframe_border_size'] . strtolower($evl_options['evl_shortcode_image_frame_border_size']) : $bordersize;
                $bordersize = (float)$bordersize;
                $stylecolor = ( ! $stylecolor ) ? $smof_data['imgframe_style_color'] . strtolower($evl_options['evl_shortcode_image_frame_style_color']) : $stylecolor;
                $align = ( ! $align ) ? '' : $align;
                $lightbox = ( ! $lightbox ) ? 'no' : $lightbox;

                if ( ! $image && $content ) {
                            preg_match('/src="([^"]*)"/', $content, $image);
                            $image = $image[1];
                }

                if ( isset( $arr_params['image_margin_top'] ) )
			$arr_params['div_margin_top']    = $arr_params['image_margin_top'];
		if ( isset( $arr_params['image_margin_bottom'] ) )
			$arr_params['div_margin_bottom'] = $arr_params['image_margin_bottom'];
		if ( isset( $arr_params['image_margin_right'] ) )
			$arr_params['div_margin_right']  = $arr_params['image_margin_right'];
		if ( isset( $arr_params['image_margin_left'] ) )
			$arr_params['div_margin_left']   = $arr_params['image_margin_left'];

                $clerfix = "<div class='clearfix'></div>";

                $style = '';
                if( ! $style ) {
			$style = $style_type;
		}

		$rgb = T4PCore_Plugin::hex2rgb( $stylecolor );
		$styles = '';

		if( $bordersize != '0' ) {
			$styles .= ".imageframe-{$this->imageframe_counter} img{border:{$bordersize}px solid {$bordercolor};}";
		}

		if( $style == 'glow' ) {
			$styles .= ".imageframe-{$this->imageframe_counter}.imageframe-glow img{
				-moz-box-shadow: 0 0 3px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);
				-webkit-box-shadow: 0 0 3px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);
				box-shadow: 0 0 3px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);
			}";
		}

		if( $style == 'dropshadow' ) {
			$styles .= ".imageframe-{$this->imageframe_counter}.imageframe-dropshadow img{
				-moz-box-shadow: 2px 3px 7px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);
				-webkit-box-shadow: 2px 3px 7px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);
				box-shadow: 2px 3px 7px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);
			}";
		}

		$styles = "<style type='text/css'>$styles</style>";

                $att_class = "t4p-imageframe imageframe imageframe-$style imageframe-$this->imageframe_counter";
                if( $style_type == 'bottomshadow' ) {
                    $att_class .= ' element-bottomshadow'; 
                }		
                $att_style = '';
                if( $align == 'left' ) {
                    $att_style .= 'margin-right:25px;float:left;'; 
                } elseif( $align == 'right' ) {
                    $att_style .= 'margin-left:25px;float:right;';
                }

		$html_elemments = "$styles<span class='$att_class' style='$att_style'>";

		
                $output = '';
                if ( $image ) {
                        $image_id       = T4P_Pb_Helper_Functions::get_image_id( $image );
                        $attachment     = wp_prepare_attachment_for_js( $image_id );
                        $image     = ( ! empty( $attachment['sizes'][$image_size]['url'] ) ) ? $attachment['sizes'][$image_size]['url'] : $image;			

                        $width = $attachment['sizes'][$image_size]['width'];
                        $height = $attachment['sizes'][$image_size]['height'];

                        $img_class = 'img-responsive';
                        if ( $style == 'circle' ) {
                                $img_class .= ' img-circle';
                        }
                        $output = "<img src='$image' alt='$alt' width='$width' height='$height' class='$img_class'>";
                }

                $linl_href = $image;
                $link_class = 'lightbox-shortcode';
                $link_rel = 'prettyPhoto';
		if( $lightbox == 'yes' ) {
			$output = "<a href='$linl_href' class='$link_class' rel='$link_rel'>$output</a>";
		}

		$html_elemments .= $output . '</span>' . $clerfix;

		if( $align == 'center' ) {
			$html_elemments = "<div class='imageframe-align-center'>$html_elemments</div>";
		}

		$this->imageframe_counter++;

		return $this->element_wrapper( $html_elemments, $arr_params );
	}
}

endif;
