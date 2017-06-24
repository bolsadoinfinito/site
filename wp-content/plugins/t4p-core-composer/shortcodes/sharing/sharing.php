<?php
/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */

if ( ! class_exists( 'Sharing' ) ) :

/**
 * Create Sharing element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Sharing extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Sharing Box', 				't4p-core' );
		$this->config['cat']         = __( 'Typography', 		't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-sharing';
		$this->config['description'] = __( 'The Sharing Box shortcode lets you insert a prominent social sharing box', 't4p-core' );

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
			'content' => array(

                                array(
                                        'name'    => __( 'Tagline', 't4p-core' ),
                                        'id'      => 'tagline',
                                        'type'    => 'text_field',
                                        'std'     => 'Share This',
                                        'tooltip'  => __( 'The title tagline that will display', 't4p-core' ),
                                ),
                                array(
                                        'name'    => __( 'Title', 't4p-core' ),
                                        'id'      => 'title',
                                        'type'    => 'text_field',
                                        'std'     => '',
                                        'tooltip'  => __( 'The post title that will be shared', 't4p-core' ),
                                ),
                                array(
                                        'name'    => __( 'Link to Share ', 't4p-core' ),
                                        'id'      => 'link',
                                        'type'    => 'text_field',
                                        'std'     => '',
                                ),
                                array(
                                        'name'    => __( 'Description', 't4p-core' ),
                                        'id'      => 'description',
                                        'type'    => 'text_area',
                                        'std'     => '',
                                        'tooltip'  => __( 'The description that will be shared', 't4p-core' ),
                                ),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
                                array(
                                        'name' => __( 'Tagline Color ', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'tagline_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the text color. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Background Color ', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'backgroundcolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the background color. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Boxed Social Icons', 't4p-core' ),
                                        'id'         => 'icons_boxed',
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
                                                        'id'         => 'icons_boxed_radius',
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
                                        'id'      => 'icon_colors',
                                        'type'    => 'text_area',
                                        'std'     => '',
                                        'tooltip'  => __( 'Specify the color of social icons. Use one for all or separate by | symbol. ex: #AA0000|#00AA00|#0000AA. Leave blank for theme option selection.', 't4p-core' ),
                                ),
                                array(
                                        'name'    => __( 'Social Icon Custom Box Colors', 't4p-core' ),
                                        'id'      => 'box_colors',
                                        'type'    => 'text_area',
                                        'std'     => '',
                                        'tooltip'  => __( 'Specify the box color of social icons. Use one for all or separate by | symbol. ex: #AA0000|#00AA00|#0000AA. Leave blank for theme option selection.', 't4p-core' ),
                                ),
                                array(
                                        'name'       => __( 'Social Icon Tooltip Position', 't4p-core' ),
                                        'id'         => 'tooltip_placement',
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
                                array(
                                        'name'    => __( 'Choose Image to Share on Pinterest ', 't4p-core' ),
                                        'id'      => 'pinterest_image',
                                        'type'    => 'select_media',
                                        'std'     => '',
                                        'class'   => 'jsn-input-large-fluid',
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

                $tagline  = ( ! $tagline ) ? '' : $tagline;
                $title  = ( ! $title ) ? '' : $title;
                $link  = ( ! $link ) ? '' : $link;
                $description  = ( ! $description ) ? '' : $description;
                $tagline_color  = ( ! $tagline_color ) ? strtolower( $smof_data['sharing_box_tagline_text_color'] ) . $evl_options['evl_shortcode_sharing_box_tagline_text_color'] : $tagline_color;
                $backgroundcolor  = ( ! $backgroundcolor ) ? strtolower( $smof_data['sharing_box_bg_color'] ) . $evl_options['evl_shortcode_sharing_box_bg_color'] : $backgroundcolor;
                $icons_boxed  = ( ! $icons_boxed ) ? strtolower( $smof_data['sharing_social_links_boxed'] ) . $evl_options['evl_sharing_box_control_color'] : $icons_boxed;
                $icons_boxed_radius  = ( ! $icons_boxed_radius ) ? strtolower( $smof_data['sharing_social_links_boxed_radius'] ) . $evl_options['evl_sharing_box_radius'] : $icons_boxed_radius;
                $icons_boxed_radius = (float)$icons_boxed_radius;
                $icon_colors  = ( ! $icon_colors ) ? strtolower( $smof_data['sharing_social_links_icon_color'] ) . $evl_options['evl_sharing_box_icon_color'] : $icon_colors;
                $box_colors  = ( ! $box_colors ) ? strtolower( $smof_data['sharing_social_links_box_color'] ) . $evl_options['evl_sharing_box_box_color'] : $box_colors;
                $tooltip_placement  = ( ! $tooltip_placement ) ? strtolower( $smof_data['sharing_social_links_tooltip_placement'] ) . $evl_options['evl_sharing_box_tooltip_position'] : $tooltip_placement;
                $pinterest_image  = ( ! $pinterest_image ) ? '' : $pinterest_image;

                $social_networks = array();

                	if( $smof_data['sharing_facebook'] || $evl_options['evl_sharing_facebook']) {
				$social_networks['facebook'] = 'http://www.facebook.com/sharer.php?m2w&s=100&p&#91;url&#93;='.$link.'&p&#91;images&#93;&#91;0&#93;=http://www.gravatar.com/avatar/2f8ec4a9ad7a39534f764d749e001046.png&p&#91;title&#93;='.$title;
			}

			if( $smof_data['sharing_twitter'] || $evl_options['evl_sharing_twitter'] ) {
				$social_networks['twitter'] = 'http://twitter.com/home?status='.$title.' '.$link;
			}

			if( $smof_data['sharing_linkedin'] || $evl_options['evl_sharing_linkedin']) {
				$social_networks['linkedin'] = 'http://linkedin.com/shareArticle?mini=true&amp;url='.$link.'&amp;title='.$title;
			}

			if( $smof_data['sharing_reddit'] || $evl_options['evl_sharing_reddit']) {
				$social_networks['reddit'] = 'http://reddit.com/submit?url='.$link.'&amp;title='.$title;
			}

			if( $smof_data['sharing_tumblr'] || $evl_options['evl_sharing_tumblr']) {
				$social_networks['tumblr'] = 'http://www.tumblr.com/share/link?url='.urlencode($link).'&amp;name='.urlencode($title).'&amp;description='.urlencode($description);
			}

			if( $smof_data['sharing_google'] || $evl_options['evl_sharing_google']) {
				$social_networks['googleplus'] = 'https://plus.google.com/share?url='.$link.'" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;';
			}

			if( $smof_data['sharing_pinterest'] || $evl_options['evl_sharing_pinterest'] ) {
				$social_networks['pinterest'] = 'http://pinterest.com/pin/create/button/?url='.urlencode($link).'&amp;description='.urlencode($title).'&amp;media='.urlencode($pinterest_image);
			}

			if( $smof_data['sharing_email'] || $evl_options['evl_sharing_email']) {
				$social_networks['mail'] = 'mailto:?subject='.$title.'&amp;body='.$link;
			}

		$icon_colors = explode( '|', $icon_colors );
		$num_of_icon_colors = count( $icon_colors );

		$box_colors = explode( '|', $box_colors );
		$num_of_box_colors = count( $box_colors );

		$icons = '';

                if( isset( $smof_data['social_sorter'] ) && $smof_data['social_sorter'] ) {
			$order = $smof_data['social_sorter'];
			$ordered_array = explode(',', $order);
			
			if( isset( $ordered_array ) && $ordered_array && is_array( $ordered_array ) ) {
				foreach( $social_networks as $reorder_social_network ) {
					$social_networks_old[$reorder_social_network] = $reorder_social_network;
				}
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

					$social_networks[] = $social_networks_old[$field_name];
				}
			}
		}

		for( $i = 0; $i < count( $social_networks ); $i++ ) {
			if( $num_of_icon_colors == 1 ) {
				$icon_colors[$i] = $icon_colors[0];
			}

			if( $num_of_box_colors == 1 ) {
				$box_colors[$i] = $box_colors[0];
                        }

		}

                //rendering icon_attr html
		$i = 0;
		foreach( $social_networks as $network => $social_link ) {
                        //icon_attr
                        $icon_attr_class = sprintf( 't4p-social-network-icon t4p-tooltip t4p-%s t4p-icon-%s', $network, $network );			
                        $tooltip = ucfirst( $network );
                        $href = $social_link;
                        $target = '_blank';

                        if( $smof_data['nofollow_social_links'] ) {
                                $rel = 'nofollow';
                        }

                        if($icon_colors ) {
                                $icon_attr_style = sprintf( 'color:%s;',$icon_colors[$i] );
                        }

                        if( $icons_boxed == 'yes' && is_array ( $box_colors ) ) {
                                        $icon_attr_style .= sprintf( 'background-color:%s;border-color:%s;', $box_colors[$i], $box_colors[$i] );	
                        }	

                        if( $icons_boxed== 'yes' && $icons_boxed_radius || $icons_boxed_radius === '0' ) {
                                if( $icons_boxed_radius == 'round' ) {
                                        $icons_boxed_radius = '50%';
                                }

                                $icon_attr_style .= sprintf( 'border-radius:%spx;', $icons_boxed_radius );
                        }			

                        if( strtolower( $tooltip_placement ) != 'none' ) {
                                $data_placement = strtolower( $tooltip_placement );
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

                //html_attr
                $class = 'share-box t4p-sharing-box';
                if( $icons_boxed == 'yes' ) {
                    $class .= ' boxed-icons';
                }
                if( $backgroundcolor ) {
                    $style = sprintf( 'background-color:%s;', $backgroundcolor );
                }

                //tagline_attr
                $tagline_class = 'tagline';
		if( $tagline_color ) {
			$tagline_style = sprintf( 'color:%s !important;', $tagline_color );
		}

		//social_networks_attr
		$social_networks_attr_class = 't4p-social-networks';
                if( $icons_boxed == 'yes' ) {
                        $social_networks_attr_class .= ' boxed-icons';
                }

                $html = "<style type='text/css'>.t4p-sharing-box .t4p-pb-icon-holder, .t4p-sharing-box .t4p-social-networks.boxed-icons a:after {border-radius:{$icons_boxed_radius}px;}</style><div class='$class' data-title='$title' data-description='$description' data-link='$link' data-image='$pinterest_image' style='$style'><h4 class='$tagline_class' style='$tagline_style'>$tagline</h4><div class='$social_networks_attr_class'>$icons</div></div>";

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
