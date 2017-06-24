<?php
/**
 * @version	1.0.0
 * @package  Theme4Press PageBuilder
 * @author	 Theme4Press
 * 
 */

if ( ! class_exists( 'Progress' ) ) :

/**
 * Progress element for T4P PageBuilder.
 *
 * @since  1.0.0
 */
class Progress extends T4P_Pb_Shortcode_Element {
	/**
	 * Constructor
	 *
	 * @return  void
	 */
	function __construct() {
		parent::__construct();
	}

	/**
	 * Configure shortcode.
	 *
	 * @return  void
	 */
	function element_config() {
            	$this->config['shortcode']        = strtolower( __CLASS__ );
		$this->config['name']             = __( 'Progress Bar', 't4p-core' );
		$this->config['cat']              = __( 'General', 't4p-core' );
		$this->config['icon']             = 't4p-pb-icon-progress-bar';
		$this->config['description']      = __( 'Animated progress bar', 't4p-core' );

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
	function element_items() {
		$this->items = array(
			'content' =>array(

				array(
					'name'    => __( 'Progess Bar Text', 't4p-core' ),
					'id'      => 'text',
					'type'    => 'text_field',
					'role'    => 'content',
					'std'     => __( 'Text', 't4p-core'),
                                        'tooltip'    => __( 'Text will show up on progess bar', 't4p-core' )
				),
				array(
					'name'    => __( 'Text Color', 't4p-core' ),
					'id'      => 'textcolor',
					'type'    => 'color_picker',
					'std'     => '',
                                        'tooltip'    => __( 'Controls the text color. Leave blank for theme option selection.', 't4p-core' )
				),
                            	array(
					'name'       => __( 'Filled Area Percentage', 't4p-core' ),
					'id'         => 'percentage',
					'type'       => 'text_append',
					'type_input' => 'number',
					'class'      => 'input-mini',
					'std'        => '15',
					'append'     => '%',
					'validate'   => 'number',
                                    'tooltip'    => __( 'From 1% to 100%', 't4p-core' )
				),
                                array(
                                        'name'    => __( 'Progress Bar Unit', 't4p-core' ),
                                        'id'      => 'unit',
                                        'type'    => 'text_field',
                                        'class'   => 'input-sm',
                                        'std'     => '%',
                                        'role'    => 'title',
                                        'tooltip'    => __( 'Insert a unit for the progress bar. ex %', 't4p-core' )
                                ),
                                array(
                                        'name'      => __( 'Select Custom Icon', 't4p-core' ),
                                        'id'        => 'icon',
                                        'type'      => 'icons',
                                        'std'       => '',
                                        'role'      => 'title_prepend',
                                        'title_prepend_type' => 'icon',
                                        'tooltip' => __( 'Click an icon to select, click None to deselect', 't4p-core' )
                                ),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
                                array(
					'name'    => __( 'Show Icon', 't4p-core' ),
					'id'      => 'show_icon',
					'type'    => 'radio',
					'std'     => 'yes',
					'options' => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                        'tooltip' => __( 'Choose to show icon or not.', 't4p-core' )
				),
				array(
					'name'    => __( 'Show Title', 't4p-core' ),
					'id'      => 'show_title',
					'type'    => 'radio',
					'std'     => 'yes',
					'options' => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                        'tooltip' => __( 'Choose to show title or not.', 't4p-core' )
				),
				array(
					'name'    => __( 'Show Percentage', 't4p-core' ),
					'id'      => 'show_percent',
					'type'    => 'radio',
					'std'     => 'yes',
					'options' => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                        'tooltip' => __( 'Choose to show percentage or not.', 't4p-core' )
				),
				array(
					'name'    => __( 'Filled Color', 't4p-core' ),
					'id'      => 'filledcolor',
					'type'    => 'color_picker',
					'std'     => '',
                                        'tooltip'    => __( 'Controls the color of the filled in area. Leave blank for theme option selection.', 't4p-core' )
				),
                            	array(
					'name'    => __( 'Unfilled Color', 't4p-core' ),
					'id'      => 'unfilledcolor',
					'type'    => 'color_picker',
					'std'     => '',
                                        'tooltip'    => __( 'Controls the color of the unfilled in area. Leave blank for theme option selection.', 't4p-core' )
				),
                            	array(
					'name'    => __( 'Striped Filling', 't4p-core' ),
					'id'      => 'striped',
					'type'    => 'radio',
					'std'     => 'no',
					'options' => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                        'tooltip'    => __( 'Choose to get the filled area striped.', 't4p-core' )
				),
                            	array(
					'name'    => __( 'Animated Stripes', 't4p-core' ),
					'id'      => 'animated_stripes',
					'type'    => 'radio',
					'std'     => 'no',
					'options' => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                    'tooltip'    => __( 'Choose to get the the stripes animated.', 't4p-core' )
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
	function element_shortcode_full( $atts = null, $content = null ) {
                global $evl_options, $smof_data;
		$arr_params = shortcode_atts( $this->config['params'], $atts );
		extract( $arr_params );
                $textcolor = ( ! $textcolor ) ? $smof_data['progressbar_text_color'] . $evl_options['evl_shortcode_progress_text_color'] : $textcolor;
                $percentage = ( ! $percentage ) ? '15' : $percentage;
                $unit = ( ! $unit ) ? '%' : $unit;
                $filledcolor = ( ! $filledcolor ) ? $smof_data['progressbar_filled_color'] . $evl_options['evl_shortcode_progress_filled_color'] : $filledcolor;
                $unfilledcolor = ( ! $unfilledcolor ) ? $smof_data['progressbar_unfilled_color'] . $evl_options['evl_shortcode_progress_unfilled_color'] : $unfilledcolor;
                $striped = ( ! $striped ) ? 'no' : $striped;
                $animated_stripes = ( ! $animated_stripes ) ? 'no' : $animated_stripes;
                $show_icon = ( ! $show_icon ) ? 'yes' : $show_icon;
                $show_title = ( ! $show_title ) ? 'yes' : $show_title;
                $show_percent = ( ! $show_percent ) ? 'yes' : $show_percent;
                $icon  = ( ! $icon ) ? '' : "<i class='fa {$icon}'></i>";

                $att_style = sprintf( 'background-color:%s;', $unfilledcolor );

		$att_class = 't4p-progressbar t4p-progress-bar progress-bar';

		if( $striped == "yes" ) {
			$att_class .= ' progress-striped';
		}

		if( $animated_stripes == "yes" ) {
			$att_class .= ' active';
		}

                $content_attr_class = 't4p-progress progress-bar-content progress';

		$content_attr_style = sprintf( 'width:%s%%;background-color:%s;', 0, $filledcolor );

		$role = 'progressbar';
		$aria_valuemin = '0';
		$aria_valuemax = '100';
		$aria_valuenow = $percentage;

                $span_class = 'progress-title sr-only';

		$span_style = sprintf( 'color:%s;', $textcolor );
                
                $show_icon = ( $show_icon == 'yes' ) ? $icon : '';
                $showtitle = ( $show_title == 'yes' ) ? do_shortcode( $content ) : '';
                $showpercent = ( $show_percent == 'yes' ) ? $percentage.$unit : '';

                $clerfix = "<div class='clearfix'></div>";

                $html = "<div class='$att_class' style='$att_style'><div class='$content_attr_class' role='$role' aria-valuemin='$aria_valuemin' aria-valuemax='$aria_valuemax' aria-valuenow='$aria_valuenow' style='$content_attr_style'></div><span class='$span_class' style='$span_style'>$show_icon $showtitle $showpercent</div>$clerfix";

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
