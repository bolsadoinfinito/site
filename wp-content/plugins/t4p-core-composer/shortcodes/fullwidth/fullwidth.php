<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Fullwidth' ) ) :

/**
 * Create Fullwidth element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Fullwidth extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Fullwidth Container', 't4p-core' );
		$this->config['cat']         = __( 'Typography', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-fullwidth';
		$this->config['description'] = __( 'Add a Full width container in content', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(                    
                        'admin_assets' => array(
                                't4p-pb-text-js',
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
                                        'name'    => __( 'Name Of Menu Anchor', 't4p-core' ),
                                        'id'      => 'menu_anchor',
                                        'type'    => 'text_field',
                                        'class'   => 'jsn-input-xxlarge-fluid',
                                        'role'    => 'title',
                                        'std'     => '',
                                        'tooltip'  => __( 'This name will be the id you will have to use in your one page menu.', 't4p-core' ),
                                ),
                                array(
                                        'name'    => __( 'Content', 't4p-core' ),
                                        'id'      => 'text',
                                        'role'    => 'content',
                                        'type'    => 'text_area',
                                        'std'     => T4P_Pb_Helper_Type::lorem_text(),
                                        'rows' => 15,
                                        'tooltip'  => __( 'Add content', 't4p-core' ),
                                ),
			),
			'styling' => array(
				array(
					'type' => 'preview',
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
                                        'name'    => __( 'Backgrond Image', 't4p-core' ),
                                        'id'      => 'backgroundimage',
                                        'type'    => 'select_media',
                                        'std'     => '',
                                        'class'   => 'jsn-input-large-fluid',
                                        'tooltip' => __( 'Upload an image to display in the background', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Background Repeat ', 't4p-core' ),
                                        'id'         => 'backgroundrepeat',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => 'no-repeat',
                                        'options'    => array(
                                                        'no-repeat'      => __( 'No Repeat', 't4p-core' ),
                                                        'repeat'   => __( 'Repeat Vertically and Horizontally', 't4p-core' ),
                                                        'repeat-x'    => __( 'Repeat Horizontally', 't4p-core' ),
                                                        'repeat-y'    => __( 'Repeat Vertically', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'Choose how the background image repeats.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Background Position ', 't4p-core' ),
                                        'id'         => 'backgroundposition',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => 'left top',
                                        'options'    => array(
                                                        'left top'      => __( 'Left Top', 't4p-core' ),
                                                        'left center'   => __( 'Left Center', 't4p-core' ),
                                                        'left bottom'    => __( 'Left Bottom', 't4p-core' ),
                                                        'right top'    => __( 'Right Top', 't4p-core' ),
                                                        'right center'    => __( 'Right Center', 't4p-core' ),
                                                        'right bottom'    => __( 'Right Bottom', 't4p-core' ),
                                                        'center top'    => __( 'Center Top', 't4p-core' ),
                                                        'center center'    => __( 'Center Center', 't4p-core' ),
                                                        'center bottom'    => __( 'Center Bottom', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'Choose the postion of the background image', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Background Scroll', 't4p-core' ),
                                        'id'         => 'backgroundattachment',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => 'scroll',
                                        'options'    => array(
                                                        'scroll'  => __( 'Scroll: background scrolls along with the element', 't4p-core' ),
                                                        'fixed'   => __( 'Fixed: background is fixed giving a parallax effect', 't4p-core' ),
                                                        'local'   => __( 'Local: background scrolls along with the element contents', 't4p-core' )
                                                ),
                                        'tooltip'    => __( 'Choose how the background image scrolls', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Border Size ', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'         => 'bordersize',
                                                        'type'       => 'text_append',
                                                        'type_input' => 'text_field',
                                                        'class'      => 'input-mini',
                                                        'std'        => '0px',
                                                ),
                                        ),
                                        'tooltip' => __( 'In pixels (px), ex: 1px. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Border Color ', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'bordercolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the border color. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Border Style', 't4p-core' ),
                                        'id'         => 'borderstyle',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => 'Solid',
                                        'options'    => array(
                                                        'solid'      => __( 'Solid', 't4p-core' ),
                                                        'dashed'   => __( 'Dashed', 't4p-core' ),
                                                        'dotted'    => __( 'Dotted', 't4p-core' )
                                                ),
                                        'tooltip'    => __( 'Controls the border style.', 't4p-core' )
                                ),
                                array(
					'name'			=> __( 'Padding', 't4p-core' ),
					'container_class' => 'combo-group',
					'type'            => array(
                                                array(
							'id'            => 'paddingtop',
							'type'          => 'text_append',
							'type_input'    => 'text_field',
							'class'         => 'input-mini',
							'std'           => '20px',
							'append_before' => 'Top',
							'parent_class'  => 'input-group-inline',
						),
						array(
							'id'            => 'paddingbottom',
							'type'          => 'text_append',
							'type_input'    => 'text_field',
							'class'         => 'input-mini',
							'std'           => '20px',
							'append_before' => 'Bottom',
							'parent_class'  => 'input-group-inline',
						),
                                                 array(
							'id'            => 'paddingleft',
							'type'          => 'text_append',
							'type_input'    => 'text_field',
							'class'         => 'input-mini',
							'std'           => '20px',
							'append_before' => 'Left',
							'parent_class'  => 'input-group-inline',
						),
						array(
							'id'            => 'paddingright',
							'type'          => 'text_append',
							'type_input'    => 'text_field',
							'class'         => 'input-mini',
							'std'           => '20px',
							'append_before' => 'Right',
							'parent_class'  => 'input-group-inline',
						),
					),
					'tooltip' => __( 'Add padding of fullwidth container', 't4p-core' ),
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

                 $menu_anchor = ( ! $menu_anchor ) ? '' : $menu_anchor;
                 $backgroundcolor = ( ! $backgroundcolor ) ? $smof_data['full_width_bg_color'] . $evl_options['evl_shortcode_full_width_bg_color'] : $backgroundcolor;
                 $backgroundimage = ( ! $backgroundimage ) ? '' : $backgroundimage;
                 $backgroundrepeat = ( ! $backgroundrepeat ) ? 'no-repeat' : $backgroundrepeat;
                 $backgroundposition = ( ! $backgroundposition ) ? 'left top' : $backgroundposition;
                 $backgroundattachment = ( ! $backgroundattachment ) ? 'scroll' : $backgroundattachment;
                 $bordersize = ( ! $bordersize ) ? $smof_data['full_width_border_size'] . $evl_options['evl_shortcode_full_width_border_size'] : $bordersize;
                 $bordersize = (float)$bordersize;
                 $bordercolor = ( ! $bordercolor ) ? $smof_data['full_width_border_color'] . $evl_options['evl_shortcode_full_width_border_color'] : $bordercolor;
                 $borderstyle = ( ! $borderstyle ) ? 'solid' : $borderstyle;
                 $paddingtop = ( ! $paddingtop ) ? '20px' : $paddingtop;
                 $paddingbottom = ( ! $paddingbottom ) ? '20px' : $paddingbottom;
                 $paddingleft = ( ! $paddingleft ) ? '20px' : $paddingleft;
                 $paddingright = ( ! $paddingright ) ? '20px' : $paddingright;
                 
                //html_attr
                $html_class = 't4p-fullwidth fullwidth-box hentry';
		$html_style = '';

		if( $backgroundattachment ) {
			$html_style .= sprintf( 'background-attachment:%s;', $backgroundattachment );
		}

		if( $backgroundcolor ) {
			$html_style .= sprintf( 'background-color:%s;', $backgroundcolor );
		}

		if( $backgroundimage ) {
			$html_style .= sprintf( 'background-image: url(%s);', $backgroundimage );
		}

		if( $backgroundposition ) {
			$html_style .= sprintf( 'background-position:%s;', $backgroundposition );
		}

		if( $backgroundrepeat ) {
			$html_style .= sprintf( 'background-repeat:%s;', $backgroundrepeat );
		}
		
		if( $backgroundrepeat == 'no-repeat') {
			$html_style .= '-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;';
		}		

		if( $bordercolor ) {
			$html_style .= sprintf( 'border-color:%s;', $bordercolor );
		}

		if( $bordersize || $bordersize == 0  ) {
			$html_style .= sprintf( 'border-bottom-width: %spx;border-top-width: %spx;', $bordersize, $bordersize );
		}
		
		if( $borderstyle ) {
			$html_style .= sprintf( 'border-bottom-style: %s;border-top-style: %s;', $borderstyle, $borderstyle );
		}		

		if( $paddingtop ) {
			$html_style .= sprintf( 'padding-bottom:%s;', $paddingtop );
		}

		if( $paddingbottom ) {
			$html_style .= sprintf( 'padding-top:%s;', $paddingbottom );
		}
                
                if( $paddingleft ) {
			$html_style .= sprintf( 'padding-left:%s;', $paddingleft );
		}
                
                if( $paddingright ) {
			$html_style .= sprintf( 'padding-right:%s;', $paddingright );
		}
                 
                if( $menu_anchor ) {
			$html = "<div id='$menu_anchor'><div class='$html_class' style='$html_style' ><div class='t4p-row'>".do_shortcode( $content )."</div></div></div>";
		} else {
			$html = "<div class='$html_class' style='$html_style' ><div class='t4p-row'>".do_shortcode( $content )."</div></div>";
		}

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
