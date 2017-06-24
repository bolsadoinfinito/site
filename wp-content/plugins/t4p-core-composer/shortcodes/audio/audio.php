<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Audio' ) ) :

/**
 * Create Audio Player element,
 * User can choose file from local server
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Audio extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Audio', 't4p-core' );
		$this->config['cat']         = __( 'Media', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-audio';
		$this->config['description'] = __( 'Add local audio file', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(
			'admin_assets' => array(
				// Shortcode initialization
				'audio.js',
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
			
			// Content tab.
			'content' => array(
				array(
					'id'          => 'audio_source_local',
					'name'        => __( 'File URL', 't4p-core' ),
					'type'        => 'select_media',
					'filter_type' => 'audio',
					'media_type'  => 'video',
					'class'       => 'input-sm',
				),
			),
			// Styling tab .
			'styling' => array(
				array(
					'type' => 'preview',
				),
				array(
					'name'                         => __( 'Dimension', 't4p-core' ),
					'container_class'              => 'combo-group',
					'id'                           => 'audio_local_dimension',
					'type'                         => 'dimension',
					'extended_ids'                 => array( 'audio_local_dimension_width', 'audio_local_dimension_height' ),
					'audio_local_dimension_width'  => array( 'std' => '500' ),
					'audio_local_dimension_height' => array( 'std' => '30' ),
					'tooltip'                      => __( 'Set width and height of element', 't4p-core' ),
				),
				array(
					'name'            => __( 'Elements', 't4p-core' ),
					'id'              => 'audio_local_elements',
					'type'            => 'checkbox',
					'class'           => 'jsn-column-item checkbox',
					'container_class' => 'jsn-columns-container jsn-columns-count-two',
					'std'             => 'play_button__#__current_time__#__time_rail__#__track_duration__#__volume_button__#__volume_slider',
					'options'         => array(
						'play_button'    => __( 'Play/Pause Button', 't4p-core' ),
						'current_time'   => __( 'Current Time', 't4p-core' ),
						'time_rail'      => __( 'Time Rail', 't4p-core' ),
						'track_duration' => __( 'Track Duration', 't4p-core' ),
						'volume_button'  => __( 'Volume Button', 't4p-core' ),
						'volume_slider'  => __( 'Volume Slider', 't4p-core' )
					),
					'tooltip' => __( 'Elements to display on audio player', 't4p-core' ),
				),
				array(
					'name'         => __( 'Start volume', 't4p-core' ),
					'id'           => 'audio_local_start_volume',
					'type'         => 'slider',
					'class'        => 't4p-slider',
					'std_max'      => '100',
					'std'          => '80',
				),
				array(
					'name'       => __( 'Loop', 't4p-core' ),
					'id'         => 'audio_local_loop',
					'type'       => 'radio',
					'std'        => 'false',
					'options'    => array(
						'true'  => __( 'Yes', 't4p-core' ),
						'false' => __( 'No', 't4p-core' )
					),
					'tooltip' => __( 'Whether to repeat playing or not', 't4p-core' ),
				),
				
				// Basic audio parameters
				array(
					'name'    => __( 'Alignment', 't4p-core' ),
					'id'      => 'audio_alignment',
					'type'    => 'select',
					'class'   => 'input-sm',
					'std'     => 'center',
					'options' => array(
						'0'      => __( 'No Alignment', 't4p-core' ),
						'left'   => __( 'Left', 't4p-core' ),
						'right'  => __( 'Right', 't4p-core' ),
						'center' => __( 'Center', 't4p-core' )
					),
				),
				array(
					'name'            => __( 'Margin', 't4p-core' ),
					'container_class' => 'combo-group',
					'id'              => 'audio_margin',
					'type'            => 'margin',
					'extended_ids'    => array( 'audio_margin_top', 'audio_margin_right', 'audio_margin_bottom', 'audio_margin_left' ),
					'audio_margin_top'     => array( 'std' => '10' ),
					'audio_margin_bottom'  => array( 'std' => '10' ),
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
			$atts['audio_local_dimension_width'] = $atts['audio_local_dimension_width'] ? $atts['audio_local_dimension_width'] : '100%';
			$arr_params                          = ( shortcode_atts( $this->config['params'], $atts ) );
			$arr_params                          = $this->merge_margin( $arr_params );
			if ( empty( $arr_params['audio_source_local'] ) ){
				$html_element = "<p class='jsn-bglabel'>" . __( 'No audio source selected', 't4p-core' ) . '</p>';
			} else {
				$html_element = $this->generate_local_files( $arr_params );
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
		if ( isset( $params['audio_margin_left'] ) && $params['audio_margin_left'] != '' )
			$params['div_margin_left'] = $params['audio_margin_left'];
		if ( isset( $params['audio_margin_right'] ) && $params['audio_margin_right'] != '' )
			$params['div_margin_right'] = $params['audio_margin_right'];
		if ( isset( $params['audio_margin_top'] ) && $params['audio_margin_top'] != '' )
			$params['div_margin_top'] = $params['audio_margin_top'];
		if ( isset( $params['audio_margin_bottom'] ) && $params['audio_margin_bottom'] != '' )
			$params['div_margin_bottom'] = $params['audio_margin_bottom'];
		return $params;
	}

	/**
	 * Generate HTML for local audio player.
	 *
	 * @param   array  $params  Shortcode parameters.
	 *
	 * @return  string  HTML code.
	 */
	function generate_local_files( $params ) {
		$random_id            = T4P_Pb_Utils_Common::random_string();
		$audio_size           = array();
		$audio_size['width']  = ' width="' . $params['audio_local_dimension_width'] . '" ';
		$audio_size['height'] = ( $params['audio_local_dimension_height'] != '' ) ? ' height="' . $params['audio_local_dimension_height'] . '" ' : '';

		$player_options = '{';
		$player_options .= ( $params['audio_local_start_volume'] != '' ) ? 'startVolume: ' . ( int ) $params['audio_local_start_volume'] / 100 . ',' : '';
		$player_options .= ( $params['audio_local_loop'] != '' ) ? 'loop: ' . $params['audio_local_loop'] . ',' : '';


		if ( ! isset( $params['audio_local_player_image'] ) ) {
			$_player_color = isset( $params['audio_local_player_color'] ) ? '$( ".mejs-mediaelement, .mejs-controls", audio_container ).css( "background", "none repeat scroll 0 0 ' . $params['audio_local_player_color'] . '" );' : '';
		} else {
			$_player_color = isset( $params['audio_local_player_color'] ) ? '$( ".mejs-mediaelement, .mejs-controls", audio_container ).css( "background", "url(\'' . $params['audio_local_player_image'] . '\' ) repeat scroll 0 0 ' . $params['audio_local_player_color'] . '");' : '';
		}

		$_progress_bar_color = isset( $params['audio_local_progress_color'] ) ? '$( ".mejs-time-loaded, .mejs-horizontal-volume-current", audio_container ).css( "background", "none repeat scroll 0 0 ' . $params['audio_local_progress_color'] . '" );' : '';

		$params['audio_local_elements'] = explode( '__#__', $params['audio_local_elements'] );
		$player_elements = '';
		$player_elements .= in_array( 'play_button', $params['audio_local_elements'] ) ? '' : '$( ".mejs-playpause-button", audio_container ).hide();';
		$player_elements .= in_array( 'current_time', $params['audio_local_elements'] ) ? '' : '$( ".mejs-currenttime-container", audio_container ).hide();';
		$player_elements .= in_array( 'time_rail', $params['audio_local_elements'] ) ? '' : '$( ".mejs-time-rail", audio_container ).hide();';
		$player_elements .= in_array( 'track_duration', $params['audio_local_elements'] ) ? '' : '$( ".mejs-duration-container", audio_container ).hide();';
		$player_elements .= in_array( 'volume_button', $params['audio_local_elements'] ) ? '' : '$( ".mejs-volume-button", audio_container ).hide();';
		$player_elements .= in_array( 'volume_slider', $params['audio_local_elements'] ) ? '' : '$( ".mejs-horizontal-volume-slider", audio_container ).hide();';

		$container_class = $container_style = '';
		if ( $params['audio_alignment'] === 'right' ) {
			$player_elements .= 'audio_container.css( "float", "right" )';
			$container_class .= 'clearafter pull-right';
		} else if ( $params['audio_alignment'] === 'center' ) {
			$container_style .= 'margin: 0 auto;';
			$player_elements .= 'audio_container.css( "margin", "0 auto" )';
		} else if ( $params['audio_alignment'] === 'left' ) {
			$player_elements .= 'audio_container.css( "float", "left" )';
			$container_class .= 'clearafter pull-left';
		}
		// Genarate Container class
		$container_class .= ' t4p-' . $random_id . ' ' . $container_class;
		$container_class = $container_class ? ' class="' . $container_class . '" ' : '';

		$player_options .= 'success: function( mediaElement, domObject ){

			var audio_container	= $( domObject ).parents( ".mejs-container" );
			' . $player_elements . '
		},';
		$player_options .= 'keyActions:[]}';

		$script = '
		<script type="text/javascript">
			jQuery( document ).ready( function ($ ){

				new MediaElementPlayer("#' . $random_id . '",
					' . $player_options . '
				);
			});
		</script>';
		$fixed_css = '';
		if ( isset( $params['audio_local_dimension_height'] ) && $params['audio_local_dimension_height'] != '' ) {
			$fixed_css = "<style type='text/css'>.t4p-element-audio .t4p-{$random_id} .mejs-container {
	min-height: {$params['audio_local_dimension_height']}px;
}</style>";
		}

		$container_style .= ( isset( $params['audio_local_dimension_width'] ) && $params['audio_local_dimension_width'] != '' ) ? 'width:' . $params['audio_local_dimension_width'] . 'px' : '';
		$container_style = $container_style ? ' style=" ' . $container_style . ' " ' : '';

		// Define the media type
		$src = str_replace( ' ', '+', $params['audio_source_local'] );
		$source = '<source type="%s" src="%s" />';
		$type = wp_check_filetype( $src );
		$source = sprintf( $source, $type['type'], esc_url( $src ) );

		return $fixed_css . $script . '<div ' . $container_class . $container_style . '>
								<audio controls="controls" preload="none" ' . $audio_size['width'] . $audio_size['height'] . ' id="' . $random_id . '" src="' . $src . '" >
									' . $source . '
								</audio>
							</div>';
	}

}

endif;
