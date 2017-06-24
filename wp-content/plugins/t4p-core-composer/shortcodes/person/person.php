<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Person' ) ) :

/**
 * Create Person element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Person extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Person', 't4p-core' );
		$this->config['cat']         = __( 'Typography', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-person';
		$this->config['description'] = __( 'Add a person details', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(                    
                        'admin_assets' => array(
                                't4p-pb-text-js',
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
					'name'  => __( 'Name', 't4p-core' ),
					'id'    => 'name',
                                        'std'   => 'PersonName',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert the name of the person.', 't4p-core' )
				),
                                array(
					'name'  => __( 'Title', 't4p-core' ),
					'id'    => 'title',
                                        'std'   => 'Title Here',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert the title of the person', 't4p-core' )
				),
                                array(
					'name'      => __( 'Profile Description', 't4p-core' ),
					'id'        => 'text',
                                        'type'      => 'text_area',
                                        'role'      => 'content',
                                        'rows'      => 10,
                                        'std'     => T4P_Pb_Helper_Type::lorem_text(12),
                                        'tooltip'   => __( 'Enter the content to be displayed', 't4p-core' )
				),
                                array(
                                        'name'    => __( 'Picture', 't4p-core' ),
                                        'id'      => 'picture',
                                        'type'    => 'select_media',
                                        'std'     => '',
                                        'class'   => 'jsn-input-large-fluid',
                                        'tooltip' => __( 'Upload an image to display.', 't4p-core' )
                                ),
                                array(
                                        'name'    => __( 'Image Size', 't4p-core' ),
                                        'id'      => 'image_size',
                                        'type'    => 'large_image',
                                        'std'     => 'thumbnail',
                                        'tooltip' => __( 'Set image size', 't4p-core' )
                                ),
                                array(
					'name'  => __( 'Picture Link URL ', 't4p-core' ),
					'id'    => 'pic_link',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Add the URL the picture will link to, ex: http://example.com.', 't4p-core' )
				),
                                array(
					'name'  => __( 'Email Address', 't4p-core' ),
					'id'    => 'email',
                                        'std'     => '#',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert an email address to display the email icon', 't4p-core' )
				),
				array(
					'name'  => __( 'Facebook Link', 't4p-core' ),
					'id'    => 'facebook',
                                        'std'     => '#',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Facebook link', 't4p-core' )
				),
                            	array(
					'name'  => __( 'Twitter Link', 't4p-core' ),
					'id'    => 'twitter',
                                        'std'     => '#',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Twitter link', 't4p-core' )
				),
                            	array(
					'name'  => __( 'Dribbble Link', 't4p-core' ),
					'id'    => 'dribbble',
                                        'std'     => '#',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Dribbble link', 't4p-core' )
				),
                            	array(
					'name'  => __( 'Google+ Link', 't4p-core' ),
					'id'    => 'google',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Google+ link', 't4p-core' )
				),
                            	array(
					'name'  => __( 'LinkedIn Link', 't4p-core' ),
					'id'    => 'linkedin',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom LinkedIn link', 't4p-core' )
				),
                            	array(
					'name'  => __( 'Blogger Link', 't4p-core' ),
					'id'    => 'blogger',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Blogger link', 't4p-core' )
				),				
                                array(
					'name'  => __( 'Tumblr Link', 't4p-core' ),
					'id'    => 'tumblr',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Tumblr link', 't4p-core' )
				),				
                                array(
					'name'  => __( 'Reddit Link', 't4p-core' ),
					'id'    => 'reddit',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Reddit link', 't4p-core' )
				),
                            	array(
					'name'  => __( 'Yahoo Link', 't4p-core' ),
					'id'    => 'yahoo',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Yahoo link', 't4p-core' )
				),				
                                array(
					'name'  => __( 'Deviantart Link', 't4p-core' ),
					'id'    => 'deviantart',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Deviantart link', 't4p-core' )
				),				
                                array(
					'name'  => __( 'Vimeo Link', 't4p-core' ),
					'id'    => 'vimeo',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Vimeo link', 't4p-core' )
				),				
                                array(
					'name'  => __( 'Youtube Link', 't4p-core' ),
					'id'    => 'youtube',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Youtube link', 't4p-core' )
				),
                            	array(
					'name'  => __( 'Pinterst Link', 't4p-core' ),
					'id'    => 'pinterest',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Pinterest link', 't4p-core' )
				),
                            	array(
					'name'  => __( 'RSS Link', 't4p-core' ),
					'id'    => 'rss',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom RSS link', 't4p-core' )
				),
                                array(
					'name'  => __( 'Digg Link', 't4p-core' ),
					'id'    => 'digg',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Digg link', 't4p-core' )
				),
                            	array(
					'name'  => __( 'Flickr Link', 't4p-core' ),
					'id'    => 'flickr',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Flickr link', 't4p-core' )
				),
                            	array(
					'name'  => __( 'Forrst Link', 't4p-core' ),
					'id'    => 'forrst',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Forrst link', 't4p-core' )
				),
                            	array(
					'name'  => __( 'Myspace Link', 't4p-core' ),
					'id'    => 'myspace',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Myspace link', 't4p-core' )
				),
                            	array(
					'name'  => __( 'Skype Link', 't4p-core' ),
					'id'    => 'skype',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom Skype link', 't4p-core' )
				),
                            	array(
					'name'  => __( 'PayPal Link', 't4p-core' ),
					'id'    => 'paypal',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom paypal link', 't4p-core' )
				),
                            	array(
					'name'  => __( 'Dropbox Link', 't4p-core' ),
					'id'    => 'dropbox',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom dropbox link', 't4p-core' )
				),
                            	array(
					'name'  => __( 'SoundCloud Link', 't4p-core' ),
					'id'    => 'soundcloud',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom soundcloud link', 't4p-core' )
				),				
                                array(
					'name'  => __( 'VK Link', 't4p-core' ),
					'id'    => 'vk',
					'type'  => 'text_field',
                                        'tooltip' => __( 'Insert your custom vk link', 't4p-core' )
				),				

			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
                                array(
                                        'name'       => __( 'Picture Style Type', 't4p-core' ),
                                        'id'         => 'pic_style',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => '',
                                        'options'    => array(
                                                        'none'      => __( 'None', 't4p-core' ),
                                                        'border'   => __( 'Border', 't4p-core' ),
                                                        'glow'    => __( 'Glow', 't4p-core' ),
                                                        'dropshadow'    => __( 'Drop Shadow', 't4p-core' ),
                                                        'bottomshadow'    => __( 'Bottom Shadow', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'Selected the style type for the picture,', 't4p-core' )
                                ),
                                array(
					'name' => __( 'Picture Style color', 't4p-core' ),
					'type' => array(
                                                array(
                                                        'id'           => 'pic_style_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
					),
                                        'tooltip' => __( 'For all style types except border. Controls the style color. Leave blank for theme option selection.', 't4p-core' )
				),
                                array(
                                        'name' => __( 'Picture Border Size', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'         => 'pic_bordersize',
                                                        'type'       => 'text_append',
                                                        'type_input' => 'text_field',
                                                        'class'      => 'input-mini',
                                                        'std'        => '0px',
                                                ),
                                        ),
                                        'tooltip' => __( 'In pixels (px), ex: 1px. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
					'name' => __( 'Picture Border Color', 't4p-core' ),
					'type' => array(
                                                array(
                                                        'id'           => 'pic_bordercolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
					),
                                        'tooltip' => __( 'Controls the picture border color. Leave blank for theme option selection.', 't4p-core' )
				),
                                array(
                                        'name'       => __( 'Boxed Social Icons', 't4p-core' ),
                                        'id'         => 'social_icon_boxed',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => '',
                                        'options'    => array(
                                                        ''      => __( 'Default', 't4p-core' ),
                                                        'no'   => __( 'No', 't4p-core' ),
                                                        'yes'    => __( 'Yes', 't4p-core' )
                                                ),
                                        'tooltip'    => __( 'Choose to get a boxed icons. Choose default for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Social Icon Box Radius', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'         => 'social_icon_boxed_radius',
                                                        'type'       => 'text_append',
                                                        'type_input' => 'text_field',
                                                        'class'      => 'input-mini',
                                                        'std'        => '3px',
                                                ),
                                        ),
                                        'tooltip' => __( 'Choose the radius of the boxed icons. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name'    => __( 'Social Icon Custom Colors', 't4p-core' ),
                                        'id'      => 'social_icon_colors',
                                        'type'    => 'text_area',
                                        'std'     => '',
                                        'tooltip'  => __( 'Specify the color of social icons. Use one for all or separate by | symbol. ex: #AA0000|#00AA00|#0000AA. Leave blank for theme option selection.', 't4p-core' ),
                                ),
                                array(
                                        'name'    => __( 'Social Icon Custom Box Colors', 't4p-core' ),
                                        'id'      => 'social_icon_boxed_colors',
                                        'type'    => 'text_area',
                                        'std'     => '',
                                        'tooltip'  => __( 'Specify the box color of social icons. Use one for all or separate by | symbol. ex: #AA0000|#00AA00|#0000AA. Leave blank for theme option selection.', 't4p-core' ),
                                ),
                                array(
                                        'name'       => __( 'Social Icon Tooltip Position', 't4p-core' ),
                                        'id'         => 'social_icon_tooltip',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => '',
                                        'options'    => array(
                                                        ''      => __( 'Default', 't4p-core' ),
                                                        'top'   => __( 'Top', 't4p-core' ),
                                                        'bottom'    => __( 'Bottom', 't4p-core' ),
                                                        'left'    => __( 'Left', 't4p-core' ),
                                                        'Right'    => __( 'Right', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'Choose the display position for tooltips. Choose default for theme option selection.', 't4p-core' )
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
		$arr_params    = ( shortcode_atts( $this->config['params'], $atts ) );
                extract( $arr_params );

                $name  = ( ! $name ) ? '' : $name;
                $title  = ( ! $title ) ? '' : $title;
                $picture  = ( ! $picture ) ? '' : $picture;
                $pic_link  = ( ! $pic_link ) ? '' : $pic_link;

                $pic_style  = ( ! $pic_style ) ? 'none' : $pic_style;
                $pic_style_color  = ( ! $pic_style_color ) ? strtolower( $smof_data['person_style_color'] ) . $evl_options['evl_shortcode_person_style_color'] : $pic_style_color;
                $pic_bordersize  = ( ! $pic_bordersize ) ? strtolower( $smof_data['person_border_size'] ) . $evl_options['evl_shortcode_person_border_size'] : $pic_bordersize;
                $pic_bordersize = (float)$pic_bordersize;
                $pic_bordercolor  = ( ! $pic_bordercolor ) ? strtolower( $smof_data['person_border_color'] ) . $evl_options['evl_shortcode_person_border_color'] : $pic_bordercolor;
                $social_icon_boxed = ( ! $social_icon_boxed ) ? strtolower( $smof_data['social_links_boxed'] ) . $evl_options['evl_shortcode_social_icon_boxed'] : $social_icon_boxed;
                $social_icon_boxed_radius  = ( ! $social_icon_boxed_radius ) ? strtolower( $smof_data['social_links_boxed_radius'] ) . $evl_options['evl_shortcode_social_icon_box_radius'] : $social_icon_boxed_radius;
                $social_icon_boxed_radius = (float)$social_icon_boxed_radius;
                $social_icon_colors  = ( ! $social_icon_colors ) ? strtolower( $smof_data['social_links_icon_color'] ) . $evl_options['evl_shortcode_social_icon_color'] : $social_icon_colors;
                $social_icon_boxed_colors  = ( ! $social_icon_boxed_colors ) ? strtolower( $smof_data['social_links_box_color'] ) . $evl_options['evl_shortcode_social_icon_box_color'] : $social_icon_boxed_colors;
                $social_icon_tooltip  = ( ! $social_icon_tooltip ) ? strtolower( $smof_data['social_links_tooltip_placement'] ) . $evl_options['evl_shortcode_social_icon_tooltip_position'] : $social_icon_tooltip;
                $linktarget = '_self';
                $lightbox = 'no';

                $inner_content = '';

                        if( $smof_data['social_icons_new'] ) {
                                $linktarget == '_blank';
                        }

                        //style_attr
                        $style = '';

                        $rgb = T4PCore_Plugin::hex2rgb( $pic_style_color );

                        if( $pic_style == 'glow' ) {
                                $style .= "-moz-box-shadow: 0 0 3px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);
                                        -webkit-box-shadow: 0 0 3px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);
                                        box-shadow: 0 0 3px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);";
                        }

                        if( $pic_style == 'dropshadow' ) {
                                $style .= "
                                        -moz-box-shadow: 2px 3px 7px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);
                                        -webkit-box-shadow: 2px 3px 7px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);
                                        box-shadow: 2px 3px 7px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);";
                        }

                        //rendering picture
                	if( $picture ) {
                            //img_attr
                            $img_attr_class = 'person-img img-responsive';
                            $img_attr_style = '';
                            if( $pic_bordersize ) {
                                $img_attr_style = sprintf( 'border:%spx solid %s;', $pic_bordersize, $pic_bordercolor );
                            }
                            
                            $image_id       = T4P_Pb_Helper_Functions::get_image_id( $picture );
                            $attachment     = wp_prepare_attachment_for_js( $image_id );
                            $picture     = ( ! empty( $attachment['sizes'][$image_size]['url'] ) ) ? $attachment['sizes'][$image_size]['url'] : $picture;			

                            $width = ( ! empty( $attachment['sizes'][$image_size]['width'] ) ) ? $attachment['sizes'][$image_size]['width'] : '';
                            $height = ( ! empty( $attachment['sizes'][$image_size]['height'] ) ) ? $attachment['sizes'][$image_size]['height'] : '';
                            
                            $img_attr_src = $picture; 

                            $img_attr_alt = $name;

                            $picture = "<img class='$img_attr_class' src='$img_attr_src' alt='$img_attr_alt' width='$width' height='$height' style='$img_attr_style' />";

                            //href_attr
                            $href_attr_href = $pic_link;
                            $href_attr_class = '';
                            $href_attr_target = '';

                            if( $lightbox == 'yes' ) {
                                    $href_attr_class = 'lightbox-shortcode';
                                    $href_attr_href = $picture;
                            } else {
                                    $href_attr_target = $linktarget;
                            }

                            if ( $pic_link ) {
                                    $picture = "<a class='$href_attr_class' href='$href_attr_href' target='$href_attr_target' >$picture</a>";
                            }

                            //image_container_attr

                            $image_container_attr_class = 'person-imgage-container';

                            if( $pic_style == 'glow' ) {
                                    $image_container_attr_class .= ' glow';
                            } else if( $pic_style == 'dropshadow' ) {
                                    $image_container_attr_class .= ' dropshadow';
                            } else if( $pic_style == 'bottomshadow' ) {
                                    $image_container_attr_class .= ' element-bottomshadow';
                            }

                            $image_container_attr_styles = $style;

                            $picture =  "<div class='person-shortcode-image-wrapper'><div class='$image_container_attr_class' style='$image_container_attr_styles' >$picture</div></div>";

                        }

                        //style_radius_attr
                        $style_radius = '';
                        if( isset($social_icon_boxed_radius) && $social_icon_boxed_radius ) {
                            $style_radius .= sprintf( 'border-radius:%spx;', $social_icon_boxed_radius );
                        }
                        $print_css_radius = '<style type="text/css">.t4p-person .t4p-pb-icon-holder, .t4p-person .t4p-social-networks.boxed-icons a:after {'.$style_radius.'}</style>';
                        echo $print_css_radius;

                if( $name || $title || $content ) {

                        $social_networks = array();

                        if( isset( $arr_params['facebook'] ) && $arr_params['facebook'] ) {
                                $social_networks['facebook'] = $arr_params['facebook'];
                        }
                        if( isset( $arr_params['twitter'] ) && $arr_params['twitter'] ) {
                                $social_networks['twitter'] = $arr_params['twitter'];
                        }
                        if( isset( $arr_params['linkedin'] ) && $arr_params['linkedin'] ) {
                                $social_networks['linkedin'] = $arr_params['linkedin'];
                        }
                        if( isset( $arr_params['dribbble'] ) && $arr_params['dribbble'] ) {
                                $social_networks['dribbble'] = $arr_params['dribbble'];
                        }
                        if( isset( $arr_params['rss'] ) && $arr_params['rss'] ) {
                                $social_networks['rss'] = $arr_params['rss'];
                        }
                        if( isset( $arr_params['youtube'] ) && $arr_params['youtube'] ) {
                                $social_networks['youtube'] = $arr_params['youtube'];
                        }
                        if( isset( $arr_params['instagram'] ) && $arr_params['instagram'] ) {
                                $social_networks['instagram'] = $arr_params['instagram'];
                        }			
                        if( isset( $arr_params['pinterest'] ) && $arr_params['pinterest'] ) {
                                $social_networks['pinterest'] = $arr_params['pinterest'];
                        }
                        if( isset( $arr_params['flickr'] ) && $arr_params['flickr'] ) {
                                $social_networks['flickr'] = $arr_params['flickr'];
                        }
                        if( isset( $arr_params['vimeo'] ) && $arr_params['vimeo'] ) {
                                $social_networks['vimeo'] = $arr_params['vimeo'];
                        }
                        if( isset( $arr_params['tumblr'] ) && $arr_params['tumblr'] ) {
                                $social_networks['tumblr'] = $arr_params['tumblr'];
                        }
                        if( isset( $arr_params['googleplus'] ) && $arr_params['googleplus'] ) {
                                $social_networks['googleplus'] = $arr_params['googleplus'];
                        }
                        if( isset( $arr_params['google'] ) && $arr_params['google'] ) {
                                $social_networks['googleplus'] = $arr_params['google'];
                        }    
                        if( isset( $arr_params['digg'] ) && $arr_params['digg'] ) {
                                $social_networks['digg'] = $arr_params['digg'];
                        }
                        if( isset( $arr_params['blogger'] ) && $arr_params['blogger'] ) {
                                $social_networks['blogger'] = $arr_params['blogger'];
                        }
                        if( isset( $arr_params['skype'] ) && $arr_params['skype'] ) {
                                $social_networks['skype'] = $arr_params['skype'];
                        }
                        if( isset( $arr_params['myspace'] ) && $arr_params['myspace'] ) {
                                $social_networks['myspace'] = $arr_params['myspace'];
                        }
                        if( isset( $arr_params['deviantart'] ) && $arr_params['deviantart'] ) {
                                $social_networks['deviantart'] = $arr_params['deviantart'];
                        }
                        if( isset( $arr_params['yahoo'] ) && $arr_params['yahoo'] ) {
                                $social_networks['yahoo'] = $arr_params['yahoo'];
                        }
                        if( isset( $arr_params['reddit'] ) && $arr_params['reddit'] ) {
                                $social_networks['reddit'] = $arr_params['reddit'];
                        }
                        if( isset( $arr_params['forrst'] ) && $arr_params['forrst'] ) {
                                $social_networks['forrst'] = $arr_params['forrst'];
                        }
                        if( isset( $arr_params['paypal'] ) && $arr_params['paypal'] ) {
                                $social_networks['paypal'] = $arr_params['paypal'];
                        }	
                        if( isset( $arr_params['dropbox'] ) && $arr_params['dropbox'] ) {
                                $social_networks['dropbox'] = $arr_params['dropbox'];
                        }	
                        if( isset( $arr_params['soundcloud'] ) && $arr_params['soundcloud'] ) {
                                $social_networks['soundcloud'] = $arr_params['soundcloud'];
                        }			
                        if( isset( $arr_params['vk'] ) && $arr_params['vk'] ) {
                                $social_networks['vk'] = $arr_params['vk'];
                        }		
                        if( isset( $arr_params['email'] ) && $arr_params['email'] ) {
                                $social_networks['mail'] = $arr_params['email'];
                        }

                        $social_icon_colors = explode( '|', $social_icon_colors );
                        $num_of_icon_colors = count( $social_icon_colors );

                        $social_icon_boxed_colors = explode( '|', $social_icon_boxed_colors );
                        $num_of_box_colors = count( $social_icon_boxed_colors );

                        $icons = '';

                        if( isset( $smof_data['social_sorter'] ) && $smof_data['social_sorter'] ) {
				$order = $smof_data['social_sorter'];
				$ordered_array = explode(',', $order);
				
				if( isset( $ordered_array ) && $ordered_array && is_array( $ordered_array ) ) {
					$social_networks_old = $social_networks;
					$social_networks = array();
					foreach( $ordered_array as $key => $field_order ) {
						$field_order_number = str_replace(  'social_sorter_', '', $field_order );
						$find_the_field = $smof_data['social_sorter_' . $field_order_number];
						$field_name = str_replace( '_link', '', $smof_data['social_sorter_' . $field_order_number] );
						
						if( $field_name == 'google' ) {
							$field_name = 'googleplus';
						} elseif($field_name == 'email' ) {
							$field_name = 'mail';
						}

						if( ! isset( $social_networks_old[$field_name] ) ) {
							continue;
						}

						$social_networks[$field_name] = $social_networks_old[$field_name];
					}
				}
			}

                        for( $i = 0; $i < count( $social_networks ); $i++ ) {
                                if( isset ( $social_icon_colors[$i] ) ) {
                                        $social_icon_colors[$i] = $social_icon_colors[$i];
                                } else {
                                        $social_icon_colors[$i] = strtolower( $smof_data['social_links_icon_color'] ) . $evl_options['evl_shortcode_social_icon_color'];
                                }

                                if( isset( $social_icon_boxed_colors[$i] ) ) {
                                        $social_icon_boxed_colors[$i] = $social_icon_boxed_colors[$i];
                                } else {
                                        $social_icon_boxed_colors[$i] = strtolower( $smof_data['social_links_box_color'] ) . $evl_options['evl_shortcode_social_icon_box_color'];
                                }

                        }

                        //rendering icon_attr html
                        $i = 0;
                        foreach( $social_networks as $network => $link ) {
                                //icon_attr
                                $icon_attr_class = sprintf( 't4p-social-network-icon t4p-tooltip t4p-%s t4p-icon-%s', $network, $network );			
                                $tooltip = ucfirst( $network );
                                if ( $network=='mail' ) {
                                    $href = "mailto:$link";
                                } else {
                                    $href = $link;
                                }
                                $target = $linktarget;

                                if( $smof_data['nofollow_social_links'] ) {
                                        $rel = 'nofollow';
                                }

                                if($social_icon_colors ) {
                                        $icon_attr_style = sprintf( 'color:%s;',$social_icon_colors[$i] );
                                }

                                if( $social_icon_boxed== 'yes' && $social_icon_boxed_colors ) {
                                                $icon_attr_style .= sprintf( 'background-color:%s;border-color:%s;', $social_icon_boxed_colors[$i], $social_icon_boxed_colors[$i] );	
                                }	

                                if( $social_icon_boxed== 'yes' && $social_icon_boxed_radius || $social_icon_boxed_radius === '0' ) {
                                        if( $social_icon_boxed_radius == 'round' ) {
                                                $social_icon_boxed_radius = '50%';
                                        }

                                        $icon_attr_style .= sprintf( 'border-radius:%spx;', $social_icon_boxed_radius );
                                }			

                                if( strtolower( $social_icon_tooltip ) != 'none' ) {
                                        $data_placement = strtolower( $social_icon_tooltip );
                                        $data_title = $tooltip;
                                        $data_toggle = 'tooltip';
                                }

                                $custom = '';
                                if( $network == 'custom' ) {
                                        $custom = sprintf( '<img src="%s" alt="%s" />', $smof_data['custom_icon_image'], $smof_data['custom_icon_name'] );
          
                                        $network = 'custom_' . $smof_data['custom_icon_name'];

                                }

                                $icons .= "<span class='t4p-icon-holder'><a class='$icon_attr_class' href='$href' target='$target' style='$icon_attr_style' data-placement='$data_placement' data-title='$data_title' data-toggle='$data_toggle' data-original-title='' title=''>$custom</a></span>";
                                $i++;
                        }

                        //social_networks_attr
                        $social_networks_attr_class = 't4p-social-networks';

                        if( $social_icon_boxed == 'yes' ) {
                                $social_networks_attr_class .= ' boxed-icons';
                        }	
                        
                        //rendering person_attr html
			$inner_content .= "<div class='person-desc' ><div class='person-author' ><div class='person-author-wrapper' ><span class='person-name' >$name</span><span class='person-title' >$title</span></div><div class='person-content t4p-clearfix' >".do_shortcode( $content )."</div></div><div class='$social_networks_attr_class' >$icons</div></div>";
                }

                $html = "<div class='t4p-person person'>$picture $inner_content</div>";

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
