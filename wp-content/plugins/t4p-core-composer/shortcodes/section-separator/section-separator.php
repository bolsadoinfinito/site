<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Section_Separator' ) ) :

/**
 * Section_Separator element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Section_Separator extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Section Separator', 't4p-core' );
		$this->config['cat']         = __( 'General', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-section-separator';
		$this->config['description'] = __( 'Horizontal line for dividing sections', 't4p-core' );

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
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'         => __( 'Position of the Divider Candy', 't4p-core' ),
                                        'id'           => 'divider_candy',
                                        'type'         => 'select',
                                        'class'        => 'input-sm',
                                        'std'          => 'top',
                                        'options'    => array(
                                                'top'      => __( 'Top', 't4p-core' ),
                                                'bottom'   => __( 'Bottom', 't4p-core' ),
                                                'bottom,top'    => __( 'Top and Bottom', 't4p-core' )
                                        ),
                                        'tooltip'      => __( 'Select the position of the triangle candy', 't4p-core' )
				),
                                array(
                                        'name'      => __( 'Select Icon', 't4p-core' ),
                                        'id'        => 'icon',
                                        'type'      => 'icons',
                                        'std'       => 'fa-star',
                                        'role'      => 'title_prepend',
                                        'title_prepend_type' => 'icon',
                                        'tooltip' => __( 'Click an icon to select, click None to deselect', 't4p-core' )
                                ),
                                array(
                                        'name'         => __( 'Icon Color', 't4p-core' ),
                                        'id'           => 'icon_color',
                                        'type'         => 'color_picker',
                                        'std'          => '',
                                        'tooltip'      => __( 'Leave blank for theme option selection.', 't4p-core' )
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
                                        'tooltip' => __( 'In pixels (px), ex: 1px. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name'         => __( 'Border Color', 't4p-core' ),
                                        'id'           => 'bordercolor',
                                        'type'         => 'color_picker',
                                        'std'          => '',
                                        'tooltip'      => __( 'Controls the border color. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name'         => __( 'Background Color of Divider Candy', 't4p-core' ),
                                        'id'           => 'backgroundcolor',
                                        'type'         => 'color_picker',
                                        'std'          => '',
                                        'tooltip'      => __( 'Controls the background color of the triangle. Leave blank for theme option selection.', 't4p-core' )
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
                global $evl_options, $smof_data, $theme_prefix;
		$arr_params = shortcode_atts( $this->config['params'], $atts );
		extract( $arr_params );

                $divider_candy = ( ! $divider_candy ) ? '' : $divider_candy;
                $icon  = ( ! $icon ) ? '' : $icon;
                $icon_color = ( ! $icon_color ) ? strtolower($smof_data['icon_color']) . strtolower($evl_options['evl_shortcode_icon_color']) : $icon_color;
                $bordersize = ( ! $bordersize ) ? strtolower($smof_data['section_sep_border_size']) . strtolower($evl_options['evl_shortcode_section_separator_border_size']) : $bordersize;
                $bordersize = (float)$bordersize;
                $bordercolor = ( ! $bordercolor ) ? strtolower($smof_data['section_sep_border_color']) . strtolower($evl_options['evl_shortcode_section_separator_border_color']) : $bordercolor;
                $backgroundcolor = ( ! $backgroundcolor ) ? strtolower($smof_data['section_sep_bg']) . strtolower($evl_options['evl_shortcode_section_separator_bg_color_candy']) : $backgroundcolor;

                $top_evolve = -(30+$bordersize);
                $divider_candy_style_top = "background-color:$backgroundcolor;border-bottom:{$bordersize}px solid $bordercolor;border-left:{$bordersize}px solid $bordercolor;top:{$top_evolve}px";
                $divider_candy_style_bottom = "background-color:$backgroundcolor;border-bottom:{$bordersize}px solid $bordercolor;border-left:{$bordersize}px solid $bordercolor;";
                $divider_candy_style_alora = "background-color:$backgroundcolor;border:{$bordersize}px solid $bordercolor;";

                if( $icon ) {
			if( ! $icon_color ) {
				$icon_color = $bordercolor;
			}

                        $icon = "<div class='section-separator-icon icon fa {$icon}' style='color:{$icon_color}'></div>";
		}

		if( $divider_candy == 'bottom' ) {
			$candy = "<div class='divider-candy bottom' style='$divider_candy_style_bottom'></div>";
		} elseif( $divider_candy == 'top' ) {
			$candy = "<div class='divider-candy top' style='$divider_candy_style_top'></div>";
		} elseif( strpos($divider_candy, 'top') !== false && strpos($divider_candy, 'bottom') !== false && $theme_prefix == 'alora_' ) {
			$candy = "<div class='divider-candy top' style='$divider_candy_style_alora'></div>";
		} elseif( strpos($divider_candy, 'top') !== false && strpos($divider_candy, 'bottom') !== false ) {
			$candy = "<div class='divider-candy bottom' style='$divider_candy_style_bottom'></div><div class='divider-candy top' style='$divider_candy_style_top'></div>";
		}

		$html_element = "<div class='t4p-section-separator section-separator' style='border-top:{$bordersize}px solid $bordercolor;margin:50px 0px;'>{$icon}{$candy}</div>";

                return $this->element_wrapper( $html_element, $arr_params );
	}
}

endif;
