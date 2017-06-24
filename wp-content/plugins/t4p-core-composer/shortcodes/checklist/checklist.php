<?php

/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */

if ( ! class_exists( 'Checklist' ) ) :
/**
 * Create Checklist element
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Checklist extends T4P_Pb_Shortcode_Parent {
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
		$this->config['shortcode']        = strtolower( __CLASS__ );
		$this->config['name']             = __( 'Checklist', 't4p-core' );
		$this->config['cat']              = __( 'Typography', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-list';
		$this->config['has_subshortcode'] = 'Li_item';
		$this->config['description']      = __( 'List of free content with icons', 't4p-core' );

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
					'id'            => 'li_items',
					'type'          => 'group',
					'shortcode'     => ucfirst( __CLASS__ ),
					'sub_item_type' => $this->config['has_subshortcode'],
					'sub_items'     => array(
						array( 'std' => '' ),
						array( 'std' => '' ),
					),
				),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
                                array(
                                        'name'      => __( 'Select Icon', 't4p-core' ),
                                        'id'        => 'icon',
                                        'type'      => 'icons',
                                        'std'       => 'fa-check-square-o',
                                        'role'      => 'title_prepend',
                                        'title_prepend_type' => 'icon',
                                        'tooltip'   => __( 'Global setting for all list items, this can be overridden individually below. Click an icon to select, click None to deselect.', 't4p-core' ),
                                ),
                                array(
                                        'name'       => __( 'Icon in Circle', 't4p-core' ),
                                        'id'         => 'circle',
                                        'type'       => 'radio',
                                        'std'        => 'yes',
                                        'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                        'tooltip'    => __( 'Global setting for all list items, this can be overridden individually below. Choose to display the icon in a circle.', 't4p-core' ),
                                ),
                                array(
                                        'name'       => __( 'Item Size', 't4p-core' ),
                                        'id'         => 'size',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => 'small',
                                        'options'    => array(
                                                        'small'      => __( 'Small', 't4p-core' ),
                                                        'medium'   => __( 'Medium', 't4p-core' ),
                                                        'large'    => __( 'Large', 't4p-core' )
                                                ),
                                        'tooltip'    => __( 'Select the list item size.', 't4p-core' )
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
                global $evl_options, $parent_atts, $smof_data;
                $parent_atts = $arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
                extract( $arr_params );
                
                $icon  = ( ! $icon ) ? 'fa-check-square-o' : $icon;
                $circle  = ( ! $circle ) ? strtolower( $smof_data['checklist_circle'] ) . $evl_options['evl_shortcode_checklist_circle'] : $circle;
                $size = ( ! $size ) ? 'small' : $size;
                
                ( $circle == 1 ) ? $circle = 'yes' : $circle = $circle;

                $sub_shortcode = do_shortcode( $content );
		$items = explode( '<!--seperate-->', $sub_shortcode );
		// remove empty element
		$items         = array_filter( $items );
		foreach ( $items as $idx => $item ) {
			$items[$idx] = $item;
		}
		$sub_shortcode = implode( '', $items );
		$sub_htmls     = $sub_shortcode;
                
                $html = "<ul class='t4p-checklist'>$sub_htmls</ul>";

                $html = str_replace( '</li><br />', '</li>', $html );
                
		return $this->element_wrapper( $html, $arr_params );
	}

}

endif;