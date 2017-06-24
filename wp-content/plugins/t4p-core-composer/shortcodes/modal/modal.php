<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Modal' ) ) :

/**
 * Create Modal element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Modal extends T4P_Pb_Shortcode_Element {
    
        private $modal_counter = 1;
    
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
		$this->config['name']        = __( 'Modal', 't4p-core' );
		$this->config['cat']         = __( 'Media', 		't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-modal';
		$this->config['description'] = __( 'Add a Modal box', 't4p-core' );

		// Define exception for this shortcode
		$this->config['exception'] = array(                    
                        'admin_assets' => array(
                                't4p-pb-text-js',
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
                                        'name'    => __( 'Name Of Modal', 't4p-core' ),
                                        'id'      => 'name',
                                        'type'    => 'text_field',
                                        'class'   => 'jsn-input-xxlarge-fluid',
                                        'std'     => '',
                                        'tooltip'  => __( 'Needs to be a unique identifier (lowercase), used for button or modal_text_link shortcode to open the modal. ex: mymodal', 't4p-core' ),
                                ),
                                array(
                                        'name'    => __( 'Modal Heading', 't4p-core' ),
                                        'id'      => 'title',
                                        'type'    => 'text_field',
                                        'class'   => 'jsn-input-xxlarge-fluid',
                                        'std'     => '',
                                        'tooltip'  => __( 'Heading text for the modal.', 't4p-core' ),
                                ),
                                array(
                                        'name'    => __( 'Contents of Modal', 't4p-core' ),
                                        'id'      => 'text',
                                        'role'    => 'content',
                                        'type'    => 'text_area',
                                        'rows'      => 10,
                                        'std'     => T4P_Pb_Helper_Type::lorem_text(12),
                                        'tooltip'  => __( 'Add your content to be displayed in modal.', 't4p-core' ),
                                ),
			),
			'styling' => array(
				array(
					'type' => 'preview',
				),
                                array(
                                        'name'       => __( 'Size Of Modal', 't4p-core' ),
                                        'id'         => 'size',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => 'small',
                                        'options'    => array(
                                                        'small'      => __( 'Small', 't4p-core' ),
                                                        'large'   => __( 'Large', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'Select the modal window size.', 't4p-core' )
                                ),
                            	array(
					'name' => __( 'Background Color', 't4p-core' ),
					'type' => array(
                                                array(
                                                        'id'           => 'background',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
					),
                                        'tooltip' => __( 'Controls the modal background color. Leave blank for theme option selection.', 't4p-core' )
				),
                                array(
                                        'name' => __( 'Border Color', 't4p-core' ),
                                        'type' => array(
                                                array(
                                                        'id'           => 'border_color',
                                                        'type'         => 'color_picker',
                                                        'std'          => '',
                                                        'parent_class' => 'combo-item',
                                                ),
                                        ),
                                        'tooltip' => __( 'Controls the modal border color. Leave blank for theme option selection.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Show footer', 't4p-core' ),
                                        'id'         => 'show_footer',
                                        'type'       => 'radio',
                                        'std'        => 'yes',
                                        'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                        'tooltip'  => __( 'Choose to show the modal footer with close button.', 't4p-core' ),
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
		global $evl_options, $smof_data;
		$arr_params    = ( shortcode_atts( $this->config['params'], $atts ) );
                extract( $arr_params );

                $name = ( ! $name ) ? '' : $name;
                $title = ( ! $title ) ? '' : $title;
                $size = ( ! $size ) ? '' : $size;
                $background = ( ! $background ) ? $smof_data['modal_bg_color'] : $background;
                $border_color = ( ! $border_color ) ? $smof_data['modal_border_color'] : $border_color;
                $show_footer = ( ! $show_footer ) ? '' : $show_footer;

                $style = '';
                if( $border_color ) {
                        $style = sprintf( '<style>.modal-%s .modal-header, .modal-%s .modal-footer{border-color:%s;}</style>', $this->modal_counter, $this->modal_counter, $border_color );
                }

                //html_attr
                if ( is_admin() ) {
                    $html_class = 'modal-' . $this->modal_counter;
                } else {
                    $html_class = 't4p-modal modal fade modal-' . $this->modal_counter;
                }
		$tabindex = '-1';
		$role = 'dialog';
		$aria_labelledby = sprintf( 'modal-heading-%s', $this->modal_counter ); 
		$aria_hidden = 'true';
                if( $name ) {
                    $html_class .= ' ' . $name;
                }

                //modal-shortcode-dialog
                $modal_shortcode_dialog_class = 'modal-dialog';
		if( $size == 'small' ) {
			$modal_shortcode_dialog_class .= ' modal-sm';
		} else {
			$modal_shortcode_dialog_class .= ' modal-lg';
		}

                //content_attr
                $content_class = 'modal-content t4p-modal-content';
                $content_style = '';

                if( $background ) {
                    $content_style = sprintf( 'background-color:%s', $background );
                }

                //button_attr
                $button_class = 'close';
                $button_type = 'button';
                $button_data_dismiss = 'modal';
                $button_aria_hidden = 'true';

                //heading_attr
                $heading_class = 'modal-title';
                $heading_id = sprintf( 'modal-heading-%s', $this->modal_counter );
                $heading_data_dismiss = 'modal';
                $heading_aria_hidden = 'true';

                //button_footer_attr
                $button_footer_class = 't4p-button button-default button-medium button default medium';
                $button_footer_type = 'button';
                $button_footer_data_dismiss = 'modal';

		$html = "<div class='$html_class' tabindex='$tabindex' role='$role' aria-labelledby='$aria_labelledby' aria-hidden='$aria_hidden'>$style<div class='$modal_shortcode_dialog_class'><div class='$content_class' style='$content_style'>"
                        . "<div class='modal-header'><button class='$button_class' type='$button_type' data-dismiss='$button_data_dismiss' aria-hidden='$button_aria_hidden' >&times;</button><h3 class='$heading_class' id='$heading_id' data-dismiss='$heading_data_dismiss' aria-hidden='$heading_aria_hidden' >$title</h3></div><div class='modal-body'>".do_shortcode( $content )."</div>";
						 
		if( $show_footer == 'yes' ) {
			$html .= "<div class='modal-footer' ><a class='$button_footer_class' type='$button_footer_type' data-dismiss='$button_footer_data_dismiss'>".__( 'Close', 't4p-core' )."</a></div>";
		}

		$html .= '</div></div></div>';

		$this->modal_counter++;

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
