<?php

/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */

if ( ! class_exists( 'T4p_tabs' ) ) :

/**
 * Create Tabs element
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class T4p_tabs extends T4P_Pb_Shortcode_Parent {

        private $tabs_counter = 1;

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
		$this->config['name']             = __( 'Tab', 't4p-core' );
		$this->config['cat']              = __( 'Typography', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-tab';
		$this->config['has_subshortcode'] = 'T4p_tab';
		$this->config['description']      = __( 'Tabbed content', 't4p-core' );

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
					'id'            => 'tab_items',
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
                                        'name'    => __( 'Layout', 't4p-core' ),
                                        'id'      => 'layout',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => 'horizontal',
                                        'options'    => array(
                                                        'horizontal'      => __( 'Horizontal', 't4p-core' ),
                                                        'vertical'   => __( 'Vertical', 't4p-core' ),
                                                ),
                                        'tooltip'  => __( 'Choose the layout of the shortcode', 't4p-core' ),
                                ),
                            	array(
					'name'       => __( 'Justify Tabs', 't4p-core' ),
					'id'         => 'justified',
					'type'       => 'radio',
					'std'        => 'yes',
					'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                        'tooltip'  => __( 'Choose to get tabs stretched over full shortcode width.', 't4p-core' ),
				),
                                array(
                                        'name' => __( 'Background Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'backgroundcolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the background tab color. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Inactive Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'inactivecolor',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the inactive tab color. Leave blank for theme option selection.', 't4p-core' )
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
                $arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
                extract( $arr_params );

                $layout  = ( ! $layout ) ? 'horizontal' : $layout;
                $justified  = ( ! $justified ) ? 'yes' : $justified;
                $backgroundcolor  = ( ! $backgroundcolor ) ? $smof_data['tabs_bg_color'] . $evl_options['evl_shortcode_tabs_bg_color'] : $backgroundcolor;
                $inactivecolor  = ( ! $inactivecolor ) ? $smof_data['tabs_inactive_color'] . $evl_options['evl_shortcode_tabs_inactive_color'] : $inactivecolor;

		$justified_class = '';
		if( $justified == 'yes' &&
			$layout != 'vertical'
		) {
			$justified_class = ' nav-justified';
		}

		$styles = sprintf( '.t4p-tabs.t4p-tabs-%s .nav-tabs li a{border-top-color:%s;background-color:%s;}', $this->tabs_counter, 
						   $inactivecolor, $inactivecolor );	
		$styles .= sprintf( '.t4p-tabs.t4p-tabs-%s .nav-tabs li.active a,.t4p-tabs.t4p-tabs-%s .nav-tabs li.active a:hover,.t4p-tabs.t4p-tabs-%s .nav-tabs li.active a:focus{background-color:%s;border-right-color:%s;}', 
							$this->tabs_counter, $this->tabs_counter, $this->tabs_counter, $backgroundcolor, $backgroundcolor );
 		$styles .= sprintf( '.t4p-tabs.t4p-tabs-%s .nav,.t4p-tabs.t4p-tabs-%s .nav-tabs,.t4p-tabs.t4p-tabs-%s .tab-content .tab-pane{border-color:%s;}', $this->tabs_counter, $this->tabs_counter, $this->tabs_counter, $inactivecolor );
		$styles = sprintf( '<style>%s</style>', $styles );

                $attr_class = sprintf( 't4p-tabs t4p-tabs-%s', $this->tabs_counter );

                if( $justified != 'yes' ) {
                        $attr_class .= ' nav-not-justified';
                }

                if( $layout == 'vertical' ) {
                        $attr_class .= ' vertical-tabs';
                } else {
                        $attr_class .= ' horizontal-tabs';
                }

		$html = "<div class='$attr_class'>$styles<div class='nav'><ul class='nav-tabs $justified_class'>";

                $sub_shortcode = str_replace('<br />', '', do_shortcode( $content ));;
                $new_sub_shortcode = trim(preg_replace('/\s\s+/', ' ', $sub_shortcode));
                $items = explode( '<!--seperate-->', $new_sub_shortcode );
		// remove empty element
		$items         = array_filter( $items );
                $is_first_tab = true;
		foreach ( $items as $idx => $item ) {
                        $items[$idx] = $item;
                        $ex_tabid = explode( '<!--tabid-->', $item );
                        $ex_heading = explode( '<!--heading-->', isset ( $ex_tabid[1] ) ? $ex_tabid[1] : '' );
			$ex_icon    = explode( '<!--icon-->', isset ( $ex_heading[1] ) ? $ex_heading[1] : '' );

                        $link_attr_class = 'tab-link';
                        $attr_href = trim($ex_tabid[0], "\n"); 
                        $link_attr_href = '#'.$attr_href;
                        $link_attr_data_toggle = 'tab';

                        $icon    = ! empty ( $ex_icon[0] ) ?  "<i class='fa {$ex_icon[0]}'></i>&nbsp;" : '';
			$heading = ! empty ( $ex_heading[0] ) ? $ex_heading[0] : 'Title';
                        $discription = ! empty ( $ex_icon[1] ) ? $ex_icon[1] : '';

                        if( $is_first_tab ) {
                                $html .= "<li class='active'><a class='$link_attr_class' href='$link_attr_href' data-toggle='$link_attr_data_toggle'>{$icon}{$heading}</a></li>";
                                $is_first_tab = false;
                        } else {
                                $html .= "<li><a class='$link_attr_class' href='$link_attr_href' data-toggle='$link_attr_data_toggle'>{$icon}{$heading}</a></li>";
                        }
		}

                $html .= "</ul></div><div class='tab-content'>";

                $is_first_tab = true;
		foreach ( $items as $idx => $item ) {
                        $items[$idx] = $item;
                        $ex_tabid = explode( '<!--tabid-->', $item );
                        $ex_heading = explode( '<!--heading-->', isset ( $ex_tabid[1] ) ? $ex_tabid[1] : '' );
			$ex_icon    = explode( '<!--icon-->', isset ( $ex_heading[1] ) ? $ex_heading[1] : '' );
                        $attr_href = trim($ex_tabid[0], "\n");

                        if( $is_first_tab ) {
                                $tab_attr_class = 'tab-pane fade in active';
                                $is_first_tab = false;
                        } else {
                                $tab_attr_class = 'tab-pane fade';
                        }
                        $discription = ! empty ( $ex_icon[1] ) ? $ex_icon[1] : '';

                        $html .= "<div class='$tab_attr_class' id='$attr_href'>$discription</div>";
		}

                $html .= "</div></div>";

		$this->tabs_counter++;

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
