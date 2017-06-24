<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Fontawesome' ) ) :

/**
 * Create Fontawesome element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Fontawesome extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Font Awesome', 't4p-core' );
		$this->config['cat']         = __( 'Typography', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-fontawesome';
		$this->config['description'] = __( 'Add a Font Awesome icon', 't4p-core' );

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
                                        'name'      => __( 'Icon', 't4p-core' ),
                                        'id'        => 'icon',
                                        'type'      => 'icons',
                                        'std'       => 'fa-user',
                                        'role'      => 'title_prepend',
                                        'title_prepend_type' => 'icon',
                                        'tooltip'  => __( 'Click an icon to select, click None to deselect', 't4p-core' ),
                                ),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
                                array(
                                        'name'       => __( 'Icon in Circle', 't4p-core' ),
                                        'id'         => 'circle',
                                        'type'       => 'radio',
                                        'std'        => 'yes',
                                        'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                        'tooltip'    => __( 'Choose to display the icon in a circle.', 't4p-core' ),
                                ),
                                array(
                                        'name'       => __( 'Size of Icon', 't4p-core' ),
                                        'id'         => 'size',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => 'small',
                                        'options'    => array(
                                                        'small'      => __( 'Small', 't4p-core' ),
                                                        'medium'   => __( 'Medium', 't4p-core' ),
                                                        'large'    => __( 'Large', 't4p-core' )
                                                ),
                                        'tooltip'    => __( 'Select the size of the icon.', 't4p-core' )
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
                                        'tooltip' => __( 'Controls the color of the icon. Leave blank for theme option selection.', 't4p-core' )
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
                                        'tooltip' => __( 'Controls the color of the circle. Leave blank for theme option selection.', 't4p-core' )
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
                                        'tooltip' => __( 'Controls the color of the circle border. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Flip Icon', 't4p-core' ),
                                        'id'         => 'flip',
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
                                        'id'         => 'rotate',
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
                                        'id'         => 'spin',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'          => 'no',
                                        'options'    => array(
                                                        'no'      => __( 'No', 't4p-core' ),
                                                        'yes'   => __( 'Yes', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'Choose to let the icon spin.', 't4p-core' )
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
		global $evl_options;
		$arr_params    = ( shortcode_atts( $this->config['params'], $atts ) );
                extract( $arr_params );
                
                $icon  = ( ! $icon ) ? '' : $icon;
                $circle  = ( ! $circle ) ? 'yes' : $circle;
                $size  = ( ! $size ) ? 'small' : $size;
                $iconcolor  = ( ! $iconcolor ) ? '' : $iconcolor;
                $circlecolor  = ( ! $circlecolor ) ? '' : $circlecolor;
                $circlebordercolor  = ( ! $circlebordercolor ) ? '' : $circlebordercolor;
                $flip  = ( ! $flip ) ? '' : $flip;
                $rotate  = ( ! $rotate ) ? '' : $rotate;
                $spin  = ( ! $spin ) ? 'no' : $spin;

                $icon_new = str_replace('fa-', '', $icon);
                
                $attr_class = sprintf( 'fa fontawesome-icon fa-%s size-%s %2$s circle-%s', $icon_new, $size, $circle );
		$attr_style = '';
		
		if( $circle == 'yes' ) {
			
			if( $circlebordercolor ) {
				$attr_style .= sprintf( 'border:1px solid %s;', $circlebordercolor );
			}
			
			if( $circlecolor ) {
				$attr_style .= sprintf( 'background-color:%s;', $circlecolor );
			}
			
		}
		
		if( $iconcolor ) {
			$attr_style .= sprintf( 'color:%s;', $iconcolor );
		}
		
		if( $flip ) {
			$attr_class .= ' fa-flip-' . $flip;
		}		
		
		if( $rotate ) {
			$attr_class .= ' fa-rotate-' . $rotate;
		}
		
		if( $spin == 'yes' ) {
			$attr_class .= ' fa-spin';
		}		
                
                $html = "<i class='$attr_class' style='$attr_style'></i>";

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
