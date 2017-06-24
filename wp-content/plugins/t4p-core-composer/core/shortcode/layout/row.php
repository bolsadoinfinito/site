<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */

if ( ! class_exists( 'Row' ) ) :

class Row extends T4P_Pb_Shortcode_Layout {

	/* default layouts for Row */
	static $layouts = array(
		array( 6, 6 ),
		array( 4, 4, 4 ),
		array( 3, 3, 3, 3 ),
		array( 4, 8 ),
		array( 8, 4 ),
		array( 3, 9 ),
		array( 9, 3 ),
		array( 3, 6, 3 ),
		array( 3, 3, 6 ),
		array( 6, 3, 3 ),
		array( 2, 2, 2, 2, 2, 2 ),
	);

	public function __construct() {
		parent::__construct();
	}

	/**
	 * DEFINE configuration information of shortcode
	 */
	function element_config() {
		$this->config['shortcode'] = strtolower( __CLASS__ );

		// Define exception for this shortcode
		$this->config['exception'] = array(
			'admin_assets' => array(
		// Shortcode initialization
				'row.js',
		),
		);

		// Use Ajax to speed up element settings modal loading speed
		$this->config['edit_using_ajax'] = true;
	}

	/**
	 * contain setting items of this element ( use for modal box )
	 *
	 */
	function element_items() {
		$this->items = array(
			'Notab' => array(
		array(
					'name'    => __( 'Width', 't4p-core' ),
					'id'      => 'width',
					'type'    => 'radio',
					'std'     => 'boxed',
					'options' => array( 'boxed' => __( 'Boxed', 't4p-core' ), 'full' => __( 'Full', 't4p-core' ) ),
		),
		array(
					'name'       => __( 'Background', 't4p-core' ),
					'id'         => 'background',
					'type'       => 'select',
					'std'        => 'none',
					'class'		 => 'input-sm',
					'options'    => array(
						'none'     => __( 'None', 't4p-core' ),
						'solid'    => __( 'Solid Color', 't4p-core' ),
						'gradient' => __( 'Gradient Color', 't4p-core' ),
						'pattern'  => __( 'Pattern', 't4p-core' ),
						'image'    => __( 'Image', 't4p-core' ),
						'video'    => __( 'Video', 't4p-core' ),
		),
					'has_depend' => '1',
		),
		array(
					'name' => __( 'Solid Color', 't4p-core' ),
					'type' => array(
		array(
							'id'           => 'solid_color_value',
							'type'         => 'text_field',
							'class'        => 'input-small',
							'std'          => '#FFFFFF',
							'parent_class' => 'combo-item',
		),
		array(
							'id'           => 'solid_color_color',
							'type'         => 'color_picker',
							'std'          => '#ffffff',
							'parent_class' => 'combo-item',
		),
		),
					'container_class' => 'combo-group',
					'dependency'      => array( 'background', '=', 'solid' ),
		),
		array(
					'name'       => __( 'Gradient Color', 't4p-core' ),
					'id'         => 'gradient_color',
					'type'       => 'gradient_picker',
					'std'        => '0% #FFFFFF,100% #000000',
					'dependency' => array( 'background', '=', 'gradient' ),
		),
		array(
					'id'              => 'gradient_color_css',
					'type'            => 'text_field',
					'std'             => '',
					'type_input'      => 'hidden',
					'container_class' => 'hidden',
					'dependency'      => array( 'background', '=', 'gradient' ),
		),
		array(
					'name'       => __( 'Gradient Direction', 't4p-core' ),
					'id'         => 'gradient_direction',
					'type'       => 'select',
					'std'        => 'vertical',
					'options'    => array( 'vertical' => __( 'Vertical', 't4p-core' ), 'horizontal' => __( 'Horizontal', 't4p-core' ) ),
					'dependency' => array( 'background', '=', 'gradient' ),
		),
		array(
					'name'       => __( 'Pattern', 't4p-core' ),
					'id'         => 'pattern',
					'type'       => 'select_media',
					'std'        => '',
					'class'      => 'jsn-input-large-fluid',
					'dependency' => array( 'background', '=', 'pattern' ),
		),
		array(
					'name'    => __( 'Repeat', 't4p-core' ),
					'id'      => 'repeat',
					'type'    => 'radio_button_group',
					'std'     => 'full',
					'options' => array(
						'full'       => __( 'Full', 't4p-core' ),
						'vertical'   => __( 'Vertical', 't4p-core' ),
						'horizontal' => __( 'Horizontal', 't4p-core' ),
		),
					'dependency' => array( 'background', '=', 'pattern' ),
		),
		array(
					'name'       => __( 'Image', 't4p-core' ),
					'id'         => 'image',
					'type'       => 'select_media',
					'std'        => '',
					'class'      => 'jsn-input-large-fluid',
					'dependency' => array( 'background', '=', 'image' ),
		),
		array(
					'name'    => __( 'Repeat', 't4p-core' ),
					'id'      => 'img_repeat',
					'type'    => 'radio_button_group',
					'std'     => 'full',
					'options' => array(
						'full'       => __( 'Full', 't4p-core' ),
						'vertical'   => __( 'Vertical', 't4p-core' ),
						'horizontal' => __( 'Horizontal', 't4p-core' ),
		),
					'dependency' => array( 'background', '=', 'image' ),
		),
		array(
					'name'    => __( 'Video url', 't4p-core' ),
					'id'      => 'video_url',
					'type'    => 'text_field',
					'std'     => '',
					'placeholder'     => 'Youtube video url',
					'dependency' => array( 'background', '=', 'video' ),
		),
		array(
					'name'    => __( 'Autoplay', 't4p-core' ),
					'id'      => 'autoplay',
					'type'    => 'radio',
					'std'     => 'yes',
					'options' => array( '1' => __( 'Yes', 't4p-core' ), '0' => __( 'No', 't4p-core' ) ),
					'dependency' => array( 'background', '=', 'video' ),
		),
		array(
					'name'       => __( 'Position', 't4p-core' ),
					'id'         => 'position',
					'type'       => 'radio',
					'label_type' => 'image',
					'dimension'  => array( 23, 23 ),
					'std'        => 'center center',
					'options'    => array(
						'left top'      => array( 'left top' ),
						'center top'    => array( 'center top' ),
						'right top'     => array( 'right top', 'linebreak' => true ),
						'left center'   => array( 'left center' ),
						'center center' => array( 'center center' ),
						'right center'  => array( 'right center', 'linebreak' => true ),
						'left bottom'   => array( 'left bottom' ),
						'center bottom' => array( 'center bottom' ),
						'right bottom'  => array( 'right bottom' ),
		),
					'dependency' => array( 'background', '=', 'image' ),
		),
		array(
					'name'       => __( 'Enable Paralax', 't4p-core' ),
					'id'         => 'paralax',
					'type'       => 'radio',
					'std'        => 'no',
					'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'dependency' => array( 'background', '=', 'pattern__#__image' ),
		),
		array(
					'name' => __( 'Border', 't4p-core' ),
					'type' => array(
		array(
							'id'           => 'border_width_value_',
							'type'         => 'text_append',
							'type_input'   => 'number',
							'class'        => 'input-mini',
							'std'          => '0',
							'append'       => 'px',
							'validate'     => 'number',
							'parent_class' => 'input-group-inline',
		),
		array(
							'id'           => 'border_style',
							'type'         => 'select',
							'class'        => 'input-sm t4p-border-style',
							'std'          => 'solid',
							'options'      => T4P_Pb_Helper_Type::get_border_styles(),
							'parent_class' => 'combo-item',
		),
		array(
							'id'           => 'border_color',
							'type'         => 'color_picker',
							'std'          => '#000',
							'parent_class' => 'combo-item',
		),
		),
					'container_class' => 'combo-group',
		),
		array(
					'name'               => __( 'Padding', 't4p-core' ),
					'container_class'    => 'combo-group',
					'id'                 => 'div_padding',
					'type'               => 'margin',
					'extended_ids'       => array( 'div_padding_top', 'div_padding_bottom', 'div_padding_right', 'div_padding_left' ),
					'div_padding_top'    => array( 'std' => '0' ),
					'div_padding_bottom' => array( 'std' => '0' ),
					'div_padding_right'  => array( 'std' => '0' ),
					'div_padding_left'   => array( 'std' => '0' ),
		),
		array(
				'name'    => __( 'Custom CSS', 't4p-core' ),
				'id'      => '',
				'type'    => 'fieldset',
		),
		array(
					'name'    => __( 'Class', 't4p-core' ),
					'id'      => 'css_suffix',
					'type'    => 'text_field',
					'std'     => '',
					'tooltip' => __( 'Custom CSS Class for the wrapper div of this element', 't4p-core' ),
		),
		array(
					'name'    => __( 'ID', 't4p-core' ),
					'id'      => 'id_wrapper',
					'type'    => 'text_field',
					'std'     => '',
					'tooltip' => __( 'Custom CSS ID for the wrapper div of this element', 't4p-core' ),
		),
		)
		);
	}

	/**
	 *
	 * @param type $content		: inner shortcode elements of this row
	 * @param type $shortcode_data : not used
	 * @return string
	 */
	public function element_in_pgbldr( $content = '', $shortcode_data = '' ) {
		if ( empty($content) ) {
			$column = new Column();
			$column_html = $column->element_in_pgbldr();
			$column_html = $column_html[0];
		} else {
			$column_html = T4P_Pb_Helper_Shortcode::do_shortcode_admin( $content );
		}
		if ( empty($shortcode_data) )
		$shortcode_data = $this->config['shortcode_structure'];
		// remove [/t4p_row][t4p_column...] from $shortcode_data
		$shortcode_data = explode( '][', $shortcode_data );
		$shortcode_data = $shortcode_data[0] . ']';

		// Remove empty value attributes of shortcode tag.
		$shortcode_data	= preg_replace( '/\[*([a-z_]*[\n\s\t]*=[\n\s\t]*"")/', '', $shortcode_data );

		$custom_style = T4P_Pb_Utils_Placeholder::get_placeholder( 'custom_style' );
		$row[] = '<div class="jsn-row-container ui-sortable row-fluid shortcode-container" ' . $custom_style . '>
						<textarea class="hidden" data-sc-info="shortcode_content" name="shortcode_content[]" >' . $shortcode_data . '</textarea>
						<div class="jsn-iconbar left">
							<a href="javascript:void(0);" title="' . __( 'Move Up', 't4p-core' ) . '" class="jsn-move-up disabled"><i class="icon-chevron-up"></i></a>
							<a href="javascript:void(0);" title="' . __( 'Move Down', 't4p-core' ) . '" class="jsn-move-down disabled"><i class=" icon-chevron-down"></i></a>
						</div>
						<div class="t4p-row-content">
						' . $column_html . '
						</div>
						<div class="jsn-iconbar jsn-vertical">
							<a href="javascript:void(0);" class="add-container" title="' . __( 'Add column', 't4p-core' ) . '"><i class="t4p-pb-icon-add-col"></i></a>
							<a href="javascript:void(0);" title="Edit row" data-shortcode="' . $this->config['shortcode'] . '" class="element-edit row" data-use-ajax="' . ( $this->config['edit_using_ajax'] ? 1 : 0 ) . '"><i class="icon-pencil"></i></a>
							<a href="javascript:void(0);" class="item-delete row" title="' . __( 'Delete row', 't4p-core' ) . '"><i class="icon-trash"></i></a>
						</div>
						<textarea class="hidden" name="shortcode_content[]" >[/' . $this->config['shortcode'] . ']</textarea>
					</div>';
		return $row;
	}

	/**
	 * get params & structure of shortcode
	 */
	public function shortcode_data() {
		$this->config['params'] = T4P_Pb_Helper_Shortcode::generate_shortcode_params( $this->items, null, null, false, true );
		$this->config['shortcode_structure'] = T4P_Pb_Helper_Shortcode::generate_shortcode_structure( $this->config['shortcode'], $this->config['params'] );
	}

	/**
	 * Return CSS for background-repeat
	 *
	 * @param string $bg_repeat
	 * @return string
	 */
	static function background_repeat( $bg_repeat ) {
		$background_repeat = '';

		switch ( $bg_repeat ) {
			case 'full':
				$background_repeat = 'repeat';
				break;
			case 'vertical':
				$background_repeat = 'repeat-y';
				break;
			case 'horizontal':
				$background_repeat = 'repeat-x';
				break;
		}

		return $background_repeat;
	}

	/**
	 * define shortcode structure of element
	 */
	function element_shortcode( $atts = null, $content = null ) {
		$extra_class = $style = $custom_script = $extra_content = $data_attr = '';
		$extra_id    = ! empty ( $atts['id_wrapper'] ) ? esc_attr( $atts['id_wrapper'] ) : T4P_Pb_Utils_Common::random_string();

		if ( isset( $atts ) && is_array( $atts ) ) {
			$arr_styles = array();

			switch ( $atts['width'] ) {
				case 'full':
					$extra_class = 't4p_fullwidth';
					// some overwrite css to enable row full width
					$script = "$('body').addClass('t4p-full-width');";
					$custom_script = T4P_Pb_Helper_Functions::script_box( $script );

					$arr_styles[] = '-webkit-box-sizing: content-box;-moz-box-sizing: content-box;box-sizing: content-box;width: 100%;padding-left: 1000px;padding-right: 1000px;margin:0 -1000px;';
					break;
				case 'boxed':
					///$arr_styles[] = "width: 100%;";
					break;
			}

			$background = '';
			switch ( $atts['background'] ) {
				case 'none':
					if ( $atts['width'] == 'full' )
					$background = 'background: none;';
					break;

				case 'solid':
					$solid_color = $atts['solid_color_value'];
					$background  = "background-color: $solid_color;";
					break;

				case 'gradient':
					$background = $atts['gradient_color_css'];
					break;

				case 'pattern':
					$pattern_img     = $atts['pattern'];
					$background = "background-image:url(\"$pattern_img\");";

					$background_repeat = self::background_repeat( $atts['repeat'] );
					if ( ! empty( $background_repeat ) ) {
						$background .= "background-repeat:$background_repeat;";
					}
					break;

				case 'image':
					$image = $atts['image'];
					$image_position = $atts['position'];

					$background = "background-image:url(\"$image\");background-position:$image_position;";

					// Background repeat
					$background_repeat = self::background_repeat( $atts['img_repeat'] );
					if ( ! empty( $background_repeat ) ) {
						$background .= "background-repeat:$background_repeat;";
					}
					break;

				case 'video':
					$url = $atts['video_url'];

					// Youtube video
					if ( preg_match( '/youtube\.com/', $url ) ) {
						$extra_class .= ' t4p_video_bg';

						parse_str( $url, $youtube_url );

						$data_attr = sprintf(
								"data-property=\"{videoURL:'http://youtu.be/%s', containment:'%s', autoPlay:%s, mute:true, startAt:0, opacity:1, showControls:false}\"",
								reset( $youtube_url ),
								"#$extra_id",
								$atts['autoplay']
								);

						add_action( 'wp_footer', array( __CLASS__, 'enqueue_player_scripts' ) );
						add_action( 'wp_footer', array( __CLASS__, 'print_player_scripts' ) );
					}

					break;
			}

			$arr_styles[] = $background;

			// Paralax background
			if ( isset( $atts['paralax']) && $atts['paralax'] == 'yes' ) {
				$data_attr .= " data-stellar-background-ratio='-.3'";
			}

			// Border
			if ( isset( $atts['border_width_value_'] ) && intval( $atts['border_width_value_'] ) ) {
				$border       = array();
				$border[]     = $atts['border_width_value_'] . 'px';
				$border[]     = $atts['border_style'];
				$border[]     = $atts['border_color'];
				$arr_styles[] = sprintf( 'border-top:%1$s; border-bottom:%1$s;', implode( ' ', $border ) );
			}

			// Padding
			$arr_styles[] = "padding-top:{$atts['div_padding_top']}px;";
			$arr_styles[] = "padding-bottom:{$atts['div_padding_bottom']}px;";

			if ( $atts['width'] != 'full' ) {
				$arr_styles[] = "padding-left:{$atts['div_padding_left']}px;";
				$arr_styles[] = "padding-right:{$atts['div_padding_right']}px;";
			}

			$style = $arr_styles ? sprintf( "style='%s'", implode( '', $arr_styles ) ) : '';
		}
		$extra_class .= ! empty ( $atts['css_suffix'] ) ? ' ' . esc_attr( $atts['css_suffix'] ) : '';

		$content = T4P_Pb_Helper_Shortcode::remove_autop( $content );

		return $custom_script . sprintf(
				"<div class='jsn-bootstrap3'><div id='%s' class='row %s' %s>%s</div></div>",
				$extra_id,
				ltrim( $extra_class, ' ' ),
				$data_attr . ' ' . $style,
				balanceTags( $extra_content . $content )
		);
	}

	/**
	 * Enqueue scripts of 3rd-party libraries for Full width video background
	 */
	static function enqueue_player_scripts() {
		wp_enqueue_style( 'YTPlayer-css', T4P_Pb_Helper_Functions::path( 'assets/3rd-party/YTPlayer' ) . '/YTPlayer.css' );
		wp_enqueue_script( 'YTPlayer-js', T4P_Pb_Helper_Functions::path( 'assets/3rd-party/YTPlayer' ) . '/jquery.mb.YTPlayer.js' );
	}

	/**
	 * Custom script for Video background
	 */
	static function print_player_scripts() {
		echo T4P_Pb_Helper_Functions::script_box("$('.t4p_video_bg').mb_YTPlayer(); $('.t4p_video_bg').click(function(){ $(this).playYTP() });");
	}
}

endif;
