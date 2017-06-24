<?php
/**
 * @version    1.0.0
 * @package    Theme4Press PageBuilder
 * @author     Theme4Press
 * 
 */

if ( ! class_exists( 'Video' ) ) :

/**
 * Create Video element
 * User can input file from local server 
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Video extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Video', 't4p-core' );
		$this->config['cat']         = __( 'Media', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-video';
		$this->config['description'] = __( 'Embed local file player', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(
			'admin_assets' => array(
                                // Shortcode initialization
				'video.js',
		),

			'frontend_assets' => array(
                                // Bootstrap 3
				't4p-pb-bootstrap-css',
				't4p-pb-bootstrap-js',

                                // Media Element
				'mediaelement-css',
				'mediaelement-js',
				't4p-pb-mediaelement-js',
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
                                        'id'          => 'video_source_local',
                                        'name'        => __( 'Video File', 't4p-core' ),
                                        'type'        => 'select_media',
                                        'filter_type' => 'video',
                                        'media_type'  => 'video',
                                        'class'       => 'jsn-input-large-fluid',
                                ),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'                         => __( 'Dimension', 't4p-core' ),
					'container_class'              => 'combo-group',
					'id'                           => 'video_local_dimension',
					'type'                         => 'dimension',
					'extended_ids'                 => array( 'video_local_dimension_width', 'video_local_dimension_height' ),
					'video_local_dimension_width'  => array( 'std' => '500' ),
					'video_local_dimension_height' => array( 'std' => '270' ),
					'tooltip'                      => __( 'Set width and height of element', 't4p-core' ),
				),
				array(
					'name'            => __( 'Elements', 't4p-core' ),
					'id'              => 'video_local_elements',
					'type'            => 'checkbox',
					'class'           => 'jsn-column-item checkbox',
					'container_class' => 'jsn-columns-container jsn-columns-count-two',
					'std'             => 'play_button__#__overlay_play_button__#__current_time__#__time_rail__#__track_duration__#__volume_button__#__volume_slider__#__fullscreen_button',
					'options'         => array(
						'play_button' => __( 'Play/Pause Button', 't4p-core' ),
						'overlay_play_button' => __( 'Overlay Play Button', 't4p-core' ),
						'current_time'        => __( 'Current Time', 't4p-core' ),
						'time_rail'           => __( 'Time Rail', 't4p-core' ),
						'track_duration'      => __( 'Track Duration', 't4p-core' ),
						'volume_button'       => __( 'Volume Button', 't4p-core' ),
						'volume_slider'       => __( 'Volume Slider', 't4p-core' ),
						'fullscreen_button'   => __( 'Fullscreen Button', 't4p-core' )
					),
					'tooltip' => __( 'Elements to display on video player', 't4p-core' ),
				),
				array(
					'name'         => __( 'Start volume', 't4p-core' ),
					'id'           => 'video_local_start_volume',
					'type'         => 'text_append',
					'type_input'   => 'number',
					'class'        => 'jsn-input-number input-mini',
					'parent_class' => 'combo-item',
					'std'          => '80',
					'append'       => '%',
					'validate'     => 'number',
				),
				array(
					'name'       => __( 'Loop', 't4p-core' ),
					'id'         => 'video_local_loop',
					'type'       => 'radio',
					'std'        => 'false',
					'options'    => array(
						'true'  => __( 'Yes', 't4p-core' ),
						'false' => __( 'No', 't4p-core' )
					),
					'tooltip' => __( 'Whether to repeat playing or not', 't4p-core' ),
				),
				array(
					'name'    => __( 'Alignment', 't4p-core' ),
					'id'      => 'video_alignment',
					'type'    => 'select',
					'class'   => 'input-sm',
					'std'     => 'center',
					'options' => array(
						'0'      => __( 'No Alignment', 't4p-core' ),
						'left'   => __( 'Left', 't4p-core' ),
						'right'  => __( 'Right', 't4p-core' ),
						'center' => __( 'Center', 't4p-core' ),
					),
				),
				array(
					'name'            => __( 'Margin', 't4p-core' ),
					'container_class' => 'combo-group',
					'id'              => 'video_margin',
					'type'            => 'margin',
					'extended_ids'    => array( 'video_margin_top', 'video_margin_right', 'video_margin_bottom', 'video_margin_left' ),
					'video_margin_top'    => array( 'std' => '10' ),
					'video_margin_bottom' => array( 'std' => '10' ),
					'tooltip'             => __( 'External spacing with other elements', 't4p-core' ),
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
		$html_element = '';

			$atts['video_local_dimension_width'] = $atts['video_local_dimension_width'] ? $atts['video_local_dimension_width'] : '100%';
			$arr_params                          = ( shortcode_atts( $this->config['params'], $atts ) );
			$arr_params                          = $this->merge_margin( $arr_params );
			if ( empty( $arr_params['video_source_local'] ) ){
				$html_element = "<p class='jsn-bglabel'>" . __( 'No video file selected', 't4p-core' ) . '</p>';
			} else {
				$html_element = $this->generate_local_file( $arr_params );
			}

		return $this->element_wrapper( $html_element, $arr_params );
	}

	/*
	 * Method to merge audio margin with div margin
	*
	* @param   array  $params Shortcode parameters.
	*
	* @return  array  $params
	*/
	private function merge_margin( $params ) {
		if ( isset( $params['video_margin_left'] ) && $params['video_margin_left'] != '' )
			$params['div_margin_left'] = $params['video_margin_left'];
		if ( isset( $params['video_margin_right'] ) && $params['video_margin_right'] != '' )
			$params['div_margin_right'] = $params['video_margin_right'];
		if ( isset( $params['video_margin_top'] ) && $params['video_margin_top'] != '' )
			$params['div_margin_top'] = $params['video_margin_top'];
		if ( isset( $params['video_margin_bottom'] ) && $params['video_margin_bottom'] != '' )
			$params['div_margin_bottom'] = $params['video_margin_bottom'];
		return $params;
	}

	/**
	 * Generate HTML for local video player.
	 *
	 * @param   array  $params  Shortcode parameters.
	 *
	 * @return  string  HTML code.
	 */
	function generate_local_file( $params ) {
		$random_id = T4P_Pb_Utils_Common::random_string();
		$video_size = array();
		$video_size['width']  = ' width="' . $params['video_local_dimension_width'] . '" ';
		$video_size['height'] = ( $params['video_local_dimension_height'] != '' ) ? ' height="' . $params['video_local_dimension_height'] . '" ' : '';

		$player_options = '{';
		$player_options .= $params['video_local_start_volume'] ? 'startVolume: ' . ( int ) $params['video_local_start_volume'] / 100 . ',' : '';
		$player_options .= $params['video_local_loop'] ? 'loop: ' . $params['video_local_loop'] . ',' : '';

		$_progress_bar_color = isset($params['video_local_progress_color']) ? '$(".mejs-time-loaded, .mejs-horizontal-volume-current", video_container).css("background", "none repeat scroll 0 0 ' . $params['video_local_progress_color'] . '");' : '';

		$params['video_local_elements'] = explode( '__#__', $params['video_local_elements'] );

		$player_elements = '';
		$player_elements .= in_array( 'play_button', $params['video_local_elements'] ) ? '' : '$(".mejs-playpause-button", video_container).hide();';
		$player_elements .= in_array( 'overlay_play_button', $params['video_local_elements'] ) ? '' : '$(".mejs-overlay-button", video_container).hide();';
		$player_elements .= in_array( 'current_time', $params['video_local_elements'] ) ? '' : '$(".mejs-currenttime-container", video_container).hide();';
		$player_elements .= in_array( 'time_rail', $params['video_local_elements'] ) ? '' : '$(".mejs-time-rail", video_container).hide();';
		$player_elements .= in_array( 'track_duration', $params['video_local_elements'] ) ? '' : '$(".mejs-duration-container", video_container).hide();';
		$player_elements .= in_array( 'volume_button', $params['video_local_elements'] ) ? '' : '$(".mejs-volume-button", video_container).hide();';
		$player_elements .= in_array( 'volume_slider', $params['video_local_elements'] ) ? '' : '$(".mejs-horizontal-volume-slider", video_container).hide();';
		$player_elements .= in_array( 'fullscreen_button', $params['video_local_elements'] ) ? '' : '$(".mejs-fullscreen-button", video_container).hide();';

		// Alignment
		$container_class = 'local_file ';
		$container_style = '';
		if ( $params['video_alignment'] === 'right' ) {
			$container_style .= 'float: right;';
			$container_class .= 'clearafter pull-right';
		} else if ( $params['video_alignment'] === 'center' ) {
			$container_style .= 'margin: 0 auto;';
		} else if ( $params['video_alignment'] === 'left' ) {
			$container_style .= 'float: right;';
			$container_class .= 'clearafter pull-left';
		}
		// Genarate Container class
		$container_class = $container_class ? ' class="' . $container_class . '" ' : '';

		$player_options .= 'defaultVideoHeight:' . ( intval( $params['video_local_dimension_height'] ) - 10 ) . ',';
		$player_options .= 'success: function(mediaElement, domObject){

                var video_container= $(domObject).parents(".mejs-container");
                ' . $player_elements . '
                },';
                                $player_options .= 'keyActions:[], pluginPath:"' . get_site_url() . '/wp-includes/js/mediaelement/' . '"}';

                                $script = '
                <script type="text/javascript">
                jQuery(document).ready(function ($){
                new MediaElementPlayer("#' . $random_id . '",
                ' . $player_options . '
                );

                });
                </script>';

		// This under is the fix for Chrome video dimension issue
		$container_style .= 'width: ' . $params['video_local_dimension_width'] . 'px;';
		$container_style .= 'height: ' . $params['video_local_dimension_height'] . 'px;';

		$container_style = $container_style ? ' style=" ' . $container_style . ' " ' : '';

		// Define the media type
		$src    = str_replace( ' ', '+', urldecode( $params['video_source_local'] ) );
		$source = '<source type="%s" src="%s" />';
		$type   = wp_check_filetype( $src );
		$source = sprintf( $source, $type['type'], esc_url( $src ) );

		$video  = '<video id="' . $random_id . '" ' . $video_size['width'] . $video_size['height'] . ' controls="controls" preload="none" src="' . $src . '">
                ' . $source . '
                </video>';

		return $script . '<div ' . $container_class . $container_style . '>'
		. $video . '
                </div>';
	}

}

endif;