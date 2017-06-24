<?php
/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */
if ( ! class_exists( 'Li_item' ) ) {
	/**
	 * Create child Checklist element
	 *
	 * @package  T4P PageBuilder Shortcodes
	 * @since    1.0.0
	 */
	class Li_item extends T4P_Pb_Shortcode_Child {

                private $circle_class = 'circle-no';
		/**
		 * Constructor
		 *
		 * @return  void
		 */
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
                                        'name'       => __( 'Icon in Circle', 't4p-core' ),
                                        'id'         => 'circle',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'options'    => array(
                                                        ''      => __( 'Default', 't4p-core' ),
                                                        'yes'   => __( 'Yes', 't4p-core' ),
                                                        'no'    => __( 'No', 't4p-core' )
                                                ),
                                        'tooltip'    => __( 'This setting will override the global setting above. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Circle Color', 't4p-core' ),
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
                                        'name' => __( 'List Item Content', 't4p-core' ),
                                        'id'   => 'body',
                                        'role' => 'content',
                                        'type' => 'text_area',
                                        'std'  => T4P_Pb_Helper_Type::lorem_text(10),
                                        'tooltip'  => __( 'Add list item content', 't4p-core' ),
                                ),
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
			$arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
			extract( $arr_params );

                        $icon  = ( ! $icon ) ? $parent_atts['icon'] : $icon;
                        $iconcolor = ( ! $iconcolor ) ? $smof_data['checklist_icons_color'] . $evl_options['evl_shortcode_checklist_circle_icon_color'] : $iconcolor;
                        $circle  = ( ! $circle ) ? $evl_options['evl_shortcode_checklist_circle'] : $circle;
                        $circlecolor  = ( ! $circlecolor ) ? $smof_data['checklist_circle_color'] . $evl_options['evl_shortcode_checklist_circle_color'] : $circlecolor;

                        $li_attr_class = sprintf( 't4p-li-item size-%s', $parent_atts['size'] );

                        $span_attr_style = '';
                        if( $circle == 'yes' || $parent_atts['circle'] == 'yes' && ( $circle  != 'no' ) ) {
                                $this->circle_class = 'circle-yes';
                                        if( ! $circlecolor ) {
                                                $circlecolor = $parent_atts['circlecolor'];
                                        } else {
                                                $circlecolor = $circlecolor;
                                        }
                                        $span_attr_style = sprintf( 'background-color:%s;', $circlecolor );
                        }
                        $span_attr_class = sprintf( 't4p-icon-wrapper %s', $this->circle_class );

                        if( ! $iconcolor ) {
                                $iconcolor = $parent_atts['iconcolor'];
                        } else {
                                $iconcolor = $iconcolor;
                        }
                        $icon_attr_class = sprintf( 't4p-li-icon fa %s', $icon );
                        $icon_attr_style = sprintf( 'color:%s;', $iconcolor );

                        $html = "<li class='$li_attr_class'><span class='$span_attr_class' style='$span_attr_style'><i class='$icon_attr_class' style='$icon_attr_style'></i></span><span class='t4p-li-item-content'>".do_shortcode( $content )."</span></li>";

                        $this->circle_class = 'circle-no';
                        
                        return $html . '<!--seperate-->';
		}

	}

}
