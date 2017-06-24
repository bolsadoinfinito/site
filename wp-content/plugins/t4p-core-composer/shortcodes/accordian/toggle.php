<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */
if ( ! class_exists( 'Toggle' ) ) {

	/**
	 * Create accordion child element.
	 *
	 * @package  T4P PageBuilder Shortcodes
	 * @since    1.0.0
	 */
	class Toggle extends T4P_Pb_Shortcode_Child {

                private $accordian_counter = 1;
                private $collaps_id;

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		public function element_config() {
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['exception'] = array(
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
                                                'name'  => __( 'Title', 't4p-core' ),
                                                'id'    => 'title',
                                                'type'  => 'text_field',
                                                'class' => 'input-sm',
                                                'std'   => 'Toggle Title',
                                                'tooltip' => __( 'Insert the toggle title', 't4p-core' ),
					),
					array(
                                                'name' => __( 'Toggle Content', 't4p-core' ),
                                                'id'   => 'description',
                                                'role' => 'content',
                                                'type'  => 'text_area',
                                                'container_class' => 't4p_tinymce_replace',
                                                'std'  => T4P_Pb_Helper_Type::lorem_text(12),
                                                'tooltip' => __( 'Insert the toggle content', 't4p-core' ),
					),
                                        array(
                                                'name'       => __( 'Open by Default', 't4p-core' ),
                                                'id'         => 'open',
                                                'type'       => 'radio',
                                                'std'        => 'no',
                                                'options'    => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
                                                'tooltip'    => __( 'Choose to have the toggle open when page loads', 't4p-core' )
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
			extract( shortcode_atts( $this->config['params'], $atts ) );

                        $title = ( ! $title ) ? '' : $title;
                        $open = ( ! $open ) ? '' : $open;

                        if ( ! empty( $content ) ) {
                                $content = T4P_Pb_Helper_Shortcode::remove_autop( $content );
                        }

                        $this->collaps_id = uniqid('collapse-');

                        $toggle_anchor_class = '';
                        if( $open == 'yes' ) {
                                $toggle_anchor_class = "class=active";
                        }

                        $data_parent = '#accordion-' . $this->accordian_counter;
                        $data_target = '#' . $this->collaps_id;
                        $href = '#' . $this->collaps_id;

                        $toggle_id = $this->collaps_id;
                        $toggle_class = '';
                        if( $open == 'yes' ) {
                            $toggle_class = 'in';
                        }
                        $toggle_class = 'panel-collapse collapse ' . $toggle_class;

			$html_result = 
			"<div class='panel panel-default'>
                            <div class='panel-heading'>
                                <h4 class='panel-title toggle'>
                                    <a {$toggle_anchor_class} data-toggle='collapse' data-parent='{$data_parent}' data-target='{$data_target}' href='{$href}'><i class='fa fa-t4p-box'></i>{$title}</a>
                                </h4>
                            </div>
                            <div id='{$toggle_id}' class='{$toggle_class}'>
                                <div class='panel-body toggle-content'>". $content ."</div>
                            </div>
                        </div>";

                        $this->accordian_counter++;

                        return $html_result . '<!--seperate-->';
		}

	}

}