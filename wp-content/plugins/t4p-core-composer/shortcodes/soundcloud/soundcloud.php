<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Soundcloud' ) ) :

/**
 * Create Audio Player element,
 * User can choose
 * from other sources like Souncloud
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Soundcloud extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'SoundCloud', 't4p-core' );
		$this->config['cat']         = __( 'Media', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-soundcloud';
		$this->config['description'] = __( 'Add SoundCloud File', 't4p-core' );

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
                                        'name'    => __( 'SoundCloud Url', 't4p-core' ),
                                        'id'      => 'url',
                                        'type'    => 'text_field',
                                        'std'     => '',
                                        'tooltip'  => __( 'The SoundCloud url, ex: http://api.soundcloud.com/tracks/139533495', 't4p-core' ),
                                )
			),
			// Styling tab .
			'styling' => array(
				array(
					'type' => 'preview',
				),
                                array(
                                        'name'       => __( 'Show Comments', 't4p-core' ),
                                        'id'         => 'comments',
                                        'type'       => 'radio',
                                        'std'        => 'yes',
                                        'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                        'tooltip'  => __( 'Choose to display comments', 't4p-core' ),
                                ),
                                array(
                                        'name'       => __( 'Autoplay', 't4p-core' ),
                                        'id'         => 'auto_play',
                                        'type'       => 'radio',
                                        'std'        => 'no',
                                        'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                        'tooltip'  => __( 'Choose to autoplay the track', 't4p-core' ),
                                ),
                                array(
                                        'name' => __( 'Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '#ff7700',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Select the color of the shortcode', 't4p-core' )
                                ),
                                array(
                                        'name'    => __( 'Width', 't4p-core' ),
                                        'id'      => 'width',
                                        'type'    => 'text_field',
                                        'std'     => '100%',
                                        'tooltip'  => __( 'In pixels (px) or percentage (%)', 't4p-core' ),
                                ),
                                array(
                                        'name'    => __( 'Height', 't4p-core' ),
                                        'id'      => 'height',
                                        'type'    => 'text_field',
                                        'std'     => '81px',
                                        'tooltip'  => __( 'In pixels (px)', 't4p-core' ),
                                )
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

                $url = ( ! $url ) ? '' : $url;
                $comments = ( ! $comments ) ? 'yes' : $comments;
                $auto_play = ( ! $auto_play ) ? 'no' : $auto_play;
                $color = ( ! $color ) ? '#ff7700' : $color;
                $width = ( ! $width ) ? '100%' : $width;
                $height = ( ! $height ) ? '81px' : $height;

                if( $comments == 'yes' ) {
			$comments = 'true';
		} else {
			$comments = 'false';
		}

		if( $auto_play  == 'yes' ) {
			$auto_play = 'true';
		} else {
			$auto_play = 'false';
		}

		if( $color ) {
			$color = str_replace( '#', '', $color );
		}

		$html = "<div class='t4p-soundcloud'><iframe width='$width' height='$height' scrolling='no' frameborder='no' src='https://w.soundcloud.com/player/?url=$url&amp;show_comments=$comments&amp;auto_play=$auto_play&amp;color=$color'></iframe></div>";

		return $this->element_wrapper( $html, $arr_params );
	}

}

endif;
