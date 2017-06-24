<?php
/**
 * @version    1.0.0
 * @package    Theme4Press PageBuilder
 * @author     Theme4Press
 * 
 */

if ( ! class_exists( 'Vimeo' ) ) :

/**
 * Create Video element
 * User can input file from Vimeo
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Vimeo extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'Vimeo', 't4p-core' );
		$this->config['cat']         = __( 'Media', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-vimeo';
		$this->config['description'] = __( 'Embed Vimeo player', 't4p-core' );

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
                                        'name'    => __( 'Video ID', 't4p-core' ),
                                        'id'      => 'id',
                                        'type'    => 'text_field',
                                        'std'     => '',
                                        'tooltip'  => __( 'For example the Video ID for
                                                           https://vimeo.com/78439312 is 78439312', 't4p-core' ),
                                ),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),

				// Youtube video parameters
                                array(
                                        'name' => __( 'Width', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'         => 'width',
                                                        'type'       => 'text_append',
                                                        'type_input' => 'number',
                                                        'class'      => 'input-mini',
                                                        'std'        => '600',
                                                        'append'     => 'px',
                                                        'validate'   => 'number',
                                                ),
                                        ),
                                        'tooltip' => __( 'In pixels but only enter a number, ex: 600', 't4p-core' )
                                ),
                                array(
                                        'name' => __( 'Height', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'         => 'height',
                                                        'type'       => 'text_append',
                                                        'type_input' => 'number',
                                                        'class'      => 'input-mini',
                                                        'std'        => '350',
                                                        'append'     => 'px',
                                                        'validate'   => 'number',
                                                ),
                                        ),
                                        'tooltip' => __( 'In pixels but only enter a number, ex: 350', 't4p-core' )
                                ),
                            	array(
					'name'       => __( 'Auto Play', 't4p-core' ),
					'id'         => 'autoplay',
					'type'       => 'radio',
					'std'        => 'no',
					'options'    => array(
						'yes' => __( 'Yes', 't4p-core' ),
						'no' => __( 'No', 't4p-core' )
					),
				),
                                array(
                                        'name'    => __( 'AdditionalAPI Parameter', 't4p-core' ),
                                        'id'      => 'api_params',
                                        'type'    => 'text_field',
                                        'std'     => '',
                                        'tooltip'  => __( 'Use additional API parameter, for example &title=0 to disable title on video. VimeoPlus account may be required.', 't4p-core' ),
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
            	$arr_params = shortcode_atts( $this->config['params'], $atts );
		extract( $arr_params );

                $id = ( ! $id ) ? '' : $id;
                $width = ( ! $width ) ? 600 : $width;
                $height = ( ! $height ) ? 360 : $height;
                $autoplay = ( ! $autoplay ) ? 'no' : $autoplay;
                $api_params = ( ! $api_params ) ? '' : $api_params;
                $center = 'no';

                if ( $autoplay == 'true' || $autoplay == 'yes' ) {
			$autoplay = '?autoplay=1';
		} else {
			$autoplay = '?autoplay=0';
		}

                //html_attr
                $class = 't4p-vimeo';
		if( $center == 'yes' ) {
			$class .= ' center-video';
		} else {
			$style = sprintf( 'max-width:%spx;max-height:%spx;', $width, $height );
		}

                //video_sc_attr
                $video_sc_class = 'video-shortcode';
                $video_sc_style = '';

		if( $center == 'yes' ) {
			$video_sc_style = sprintf( 'max-width:%spx;max-height:%spx;', $width, $height );
		}

		$html = "<div class='$class' style='$style' ><div class='$video_sc_class' style='$video_sc_style' ><iframe src='https://player.vimeo.com/video/$id$autoplay$api_params' width='$width' height='$height' frameborder='0'></iframe></div></div>";

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;