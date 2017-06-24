<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
/*
 * Define a column shortcode
 */
if ( ! class_exists( 'Column' ) ) {

	class Column extends T4P_Pb_Shortcode_Layout {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		function element_config() {
			$this->config['shortcode']     = strtolower( __CLASS__ );
			$this->config['extract_param'] = array(
				'span',
				'hidden_on'
			);

			// Use Ajax to speed up element settings modal loading speed
			$this->config['edit_using_ajax'] = true;
		}

		/**
		 * contain setting items of this element (use for modal box)
		 *
		 */
		function element_items() {
			$this->items = array(
				'Notab' => array(
					// --------------------------------------------------------------- HIDDEN
					array(
						'name'    => __( 'Hidden on ...', 't4p-core' ),
						'id'      => 'hidden_on',
						'type'    => 'checkbox',
						'std'     => '',
						'options' => array(
							'hidden-lg' => __( 'Large' , 't4p-core' ),
							'hidden-md' => __( 'Medium', 't4p-core' ),
							'hidden-sm' => __( 'Small', 't4p-core' ),
							'hidden-xs' => __( 'Extra-Small', 't4p-core' )
						)
					)
				)
			);
		}

		/**
		 * get params & structure of shortcode
		 */
		public function shortcode_data() {
			$this->config['params'] = T4P_Pb_Helper_Shortcode::generate_shortcode_params( $this->items, null, null, false, true );
			$this->config['params']['span'] = ( ! empty( $this->params['span'] ) ) ? $this->params['span'] : 'span12';
			$this->config['shortcode_structure'] = T4P_Pb_Helper_Shortcode::generate_shortcode_structure( $this->config['shortcode'], $this->config['params'] );
		}

		/**
		 *
		 * @param type $content			 : inner shortcode elements of this column
		 * @param string $shortcode_data
		 * @return string
		 */
		public function element_in_pgbldr( $content = '', $shortcode_data = '' ) {
			$column_html    = empty( $content ) ? '' : T4P_Pb_Helper_Shortcode::do_shortcode_admin( $content, true );
			
			if ( empty( $shortcode_data ) )
				$shortcode_data = $this->config['shortcode_structure'];
			// remove [/t4p_row][t4p_column...] from $shortcode_data
			$shortcode_data = explode( '][', $shortcode_data );
			$shortcode_data = $shortcode_data[0] . ']';

			// Remove empty value attributes of shortcode tag.
       			$shortcode_data	= preg_replace( '/\[*([a-z_]*[\n\s\t]*=[\n\s\t]*"")/', '', $shortcode_data );
                        $params = T4P_Pb_Helper_Shortcode::extract_params( $shortcode_data );
                        $span = ( ! empty( $params['span'] ) ) ? $params['span'] : 'span12';
                        $hidden_on = ( ! empty( $params['hidden_on'] ) ) ? $params['hidden_on'] : '';
			$rnd_id   = T4P_Pb_Utils_Common::random_string();
			$column[] = '<div class="jsn-column-container clearafter shortcode-container ">
							<div class="jsn-column ' . $span . '">
								<div class="thumbnail clearafter">
									<textarea id="column-span" class="hidden" data-sc-info="shortcode_content" name="shortcode_content[]" data-name='.$span.' >[' . $this->config['shortcode'] . ' span="'.$span.'" hidden_on="'.$hidden_on.'"]</textarea>
									<div class="jsn-column-content item-container" data-column-class="' . $span . '" >
										<div class="jsn-handle-drag jsn-horizontal jsn-iconbar-trigger">
											<div class="jsn-iconbar layout">
												<a href="javascript:void(0);" title="Edit Column" data-shortcode="' . $this->config['shortcode'] . '" class="element-edit column" data-use-ajax="' . ( $this->config['edit_using_ajax'] ? 1 : 0 ) . '"><i class="icon-pencil"></i></a>
												<a class="item-delete column" onclick="return false;" title="' . __( 'Delete column', 't4p-core' ) . '" href="#"><i class="icon-trash"></i></a>
											</div>
										</div>
										<div class="jsn-element-container item-container-content">
											' . $column_html . '</div>
										<a class="jsn-add-more t4p-more-element" href="javascript:void(0);"><i class="t4p-pb-icon-widget"></i>' . __( 'Add Element', 't4p-core' ) . '</a>
									</div>
									<textarea class="hidden" name="shortcode_content[]" >[/' . $this->config['shortcode'] . ']</textarea>
								</div>
							</div>
						</div>';
			return $column;
		}

		/**
		 * define shortcode structure of element
		 */
		function element_shortcode( $atts = null, $content = null ) {
			extract( shortcode_atts(
				array(
	        		'span' => 'span12',
	        		'hidden_on' => '',
	        		'style' => ''
	        	),
	        	$atts
	        ) );
			$style   = empty( $style ) ? '' : "style='$style'";
			$span    = intval( substr( $span, 4 ) );
			$hidden_on = trim( str_replace( '__#__', ' ', $hidden_on ) );
			$class   = "col-md-$span col-sm-$span col-xs-12 $hidden_on";

			$content = T4P_Pb_Helper_Shortcode::remove_autop( $content );

			return '<div class="' . $class . '" ' . $style . '>' . $content . '</div>';
		}

	}

}
