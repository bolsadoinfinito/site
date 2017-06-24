<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
/*
 * Parent class for normal elements
 */

class T4P_Pb_Shortcode_Element extends T4P_Pb_Shortcode_Common {

	public function __construct() {
		$this->type = 'element';
		$this->config['el_type'] = 'element';

		$this->element_config();

		// add shortcode
		add_shortcode( $this->config['shortcode'], array( &$this, 'element_shortcode' ) );

	}

	/**
	 * Method to call neccessary functions for initialyzing the backend
	 */
	public function init_element()
	{
		$this->element_items();
		$this->element_items_extra();
		$this->shortcode_data();

		do_action( 't4p_pb_element_init' );

		parent::__construct();

		// enqueue assets for current element in backend (modal setting iframe)
		if ( T4P_Pb_Helper_Functions::is_modal_of_element( $this->config['shortcode'] ) ) {
			add_action( 'pb_admin_enqueue_scripts', array( &$this, 'enqueue_assets_modal' ) );
		}

		// enqueue assets for current element in backend (preview iframe)
		if ( T4P_Pb_Helper_Functions::is_preview() ) {
			add_action( 'pb_admin_enqueue_scripts', array( &$this, 'enqueue_assets_frontend' ) );
		}
	}

	/**
	 * Custom assets for frontend
	 */
	public function custom_assets_frontend() {
		// enqueue custom assets here
	}

	/**
	 * Enqueue scripts for frontend
	 */
	public function enqueue_assets_frontend() {
		T4P_Pb_Helper_Functions::shortcode_enqueue_assets( $this, 'frontend_assets', '_frontend' );
	}

	/**
	 * Enqueue scripts for modal setting iframe
	 *
	 * @param type $hook
	 */
	public function enqueue_assets_modal( $hook ) {
		T4P_Pb_Helper_Functions::shortcode_enqueue_assets( $this, 'admin_assets', '' );
	}

	/**
	 * Define configuration information of shortcode
	 */
	public function element_config() {

	}

	/**
	 * Define setting options of shortcode
	 */
	public function element_items() {

	}

	/**
	 * Add more options to all elements
	 */
	public function element_items_extra() {
		$css_suffix = array();
		$id_wrapper = array();
		$shortcode_name = $this->config['shortcode'];
                $is_sub_element   = ( isset( $this->config['sub_element'] ) ) ? true : false;

		$disable_el = array(
			'name' => __( 'Disable', 't4p-core' ),
			'id' => 'disabled_el',
			'type' => 'radio',
			'std' => 'no',
			'options' => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
			'wrap_class' => 'form-group control-group hidden clearfix',
		);

                // Add Advanced options & if not child element
		if ( ! $is_sub_element || ! empty( $this->config['use_wrapper'] ) ) {
			$css_wrapper = array(
				'name'    => __( 'Advanced', 't4p-core' ),
				'id'      => '',
				'type'    => 'fieldset',
			);
			$css_suffix = array(
				'name'    => __( 'CSS Class', 't4p-core' ),
				'id'      => 'class',
				'type'    => 'text_field',
				'std'     => '',
				'tooltip' => __( 'Add a class to the wrapping HTML element.', 't4p-core' )
			);
                        $id_wrapper = array(
                                'name'    => __( 'CSS ID', 't4p-core' ),
                                'id'      => 'id',
                                'type'    => 'text_field',
                                'std'     => '',
                                'tooltip' => __( 'Add an ID to the wrapping HTML element.', 't4p-core' ),
                        );
		}

		// Copy style from other element.
//		$style_copy = array(
//			'name'    => __( 'Copy Style from...', 't4p-core' ),
//			'id'      => 'copy_style_from',
//			'type'    => 'select',
//			'options' => array( '0' => __( 'Select element', 't4p-core' ) ),
//			'std'     => __( '0', 't4p-core' ),
//			'tooltip' => __( 'Copy Styling prameters from other same type element', 't4p-core' ),
//		);

		// Add Element Title & if not child element
		if ( isset ( $this->items['content'] ) && ! $is_sub_element ) {
			$this->items['content'] = array_merge(
				array(
					array(
						'name'    => __( 'Element Title', 't4p-core' ),
						'id'      => 'el_title',
						'type'    => 'text_field',
						'class'   => 'input-sm',
						'std'     => '',
						'role'    => 'title',
						'tooltip' => __( 'Set title for current element for identifying easily', 't4p-core' )
					),
				),
				$this->items['content']
			);
		}

                // Add Margin
		if ( isset ( $this->items['styling'] ) ) {
                        if ( $shortcode_name == 'youtube' || $shortcode_name == 'vimeo' ) {
                            $this->items['styling'] = array_merge(
                                    $this->items['styling'], array(
                                            $css_wrapper,
                                            $css_suffix,
                                            $disable_el,
                                    )
                            );
                        } else {
                            $this->items['styling'] = array_merge(
                                    $this->items['styling'], array(
                                            $css_wrapper,
                                            $css_suffix,
                                            $id_wrapper,
                                            $disable_el,
                                    )
                            );
                        }
                        if ( $shortcode_name != 'dropcap' && $shortcode_name != 'fontawesome' && $shortcode_name != 'highlight' && $shortcode_name != 'lightbox' && $shortcode_name != 'menu_anchor' && $shortcode_name != 'modal' && $shortcode_name != 'modal_text_link' && $shortcode_name != 'popover' && $shortcode_name != 'separator' && $shortcode_name != 'tooltip' ) {
                                $this->items['styling'] = array_merge(
                                        $this->items['styling'], array(
                                                array(
                                                        'name'			=> __( 'Margin', 't4p-core' ),
                                                        'container_class' 	=> 'combo-group',
                                                        'id'			=> 'div_margin',
                                                        'type'			=> 'margin',
                                                        'extended_ids'	=> array( 'div_margin_top', 'div_margin_bottom', 'div_margin_left', 'div_margin_right' ),
                                                        'div_margin_top'	=> array( 'std' => '0' ),
                                                        'div_margin_bottom'	=> array( 'std' => '0' ),
                                                        'div_margin_left'   => array( 'std' => '0' ),
                                                        'div_margin_right'  => array( 'std' => '0' ),
                                                        'margin_elements'	=> 't, b, l, r',
                                                        'tooltip' 			=> __( 'External spacing with other elements', 	't4p-core' )
                                                ),
                                        )
                                );
                        }
			//array_unshift( $this->items['styling'], $style_copy );
		} else {
			if ( isset ( $this->items['Notab'] ) && $shortcode_name != 'toggle' && $shortcode_name != 'buttonbar' && $shortcode_name != 'carousel_slide' && $shortcode_name != 'counter_circle' && $shortcode_name != 'content_box'
                             && $shortcode_name != 'client' && $shortcode_name != 'image' && $shortcode_name != 'list_item' && $shortcode_name != 'flip_box' && $shortcode_name != 'testimonial' 
                             && $shortcode_name != 't4p_tab' && $shortcode_name != 'counter_box' && $shortcode_name != 'li_item' && $shortcode_name != 'slide' && $shortcode_name != 'pricing_column' && $shortcode_name != 'pricing_price'&& $shortcode_name != 'pricing_row'&& $shortcode_name != 'pricing_footer' ) {
				$this->items['Notab'] = array_merge(
					$this->items['Notab'], array(
						$css_suffix,
						$id_wrapper,
						$disable_el,
					)
				);
			}
		}
	}

	/**
	 * DEFINE html structure of shortcode in Page Builder area
	 *
	 * @param string $content
	 * @param string $shortcode_data: string stores params (which is modified default value) of shortcode
	 * @param string $el_title: Element Title used to identifying elements in T4P PageBuilder
	 * @param int $index
	 * @param bool $inlude_sc_structure
	 * @param array $extra_params
	 * Ex:  param-tag=h6&param-text=Your+heading&param-font=custom&param-font-family=arial
	 * @return string
	 */
	public function element_in_pgbldr( $content = '', $shortcode_data = '', $el_title = '', $index = '', $inlude_sc_structure = true, $extra_params = array() ) {
		// Init neccessary data to render element in backend.
		$this->init_element();

		$shortcode		  = $this->config['shortcode'];
		$is_sub_element   = ( isset( $this->config['sub_element'] ) ) ? true : false;
		$parent_shortcode = ( $is_sub_element ) ? str_replace( 't4p_item_', '', $shortcode ) : $shortcode;
		$type			  = ! empty( $this->config['el_type'] ) ? $this->config['el_type'] : 'widget';

		// Empty content if this is not sub element
		if ( ! $is_sub_element )
		$content = '';

		$exception   = isset( $this->config['exception'] ) ? $this->config['exception'] : array();
		$content     = ( isset( $exception['default_content'] ) ) ? $exception['default_content'] : $content;
		$modal_title = '';
		// if is widget
		if ( $type == 'widget' ) {
			global $t4p_pb_widgets;
			if ( isset( $t4p_pb_widgets[$shortcode] ) && is_array( $t4p_pb_widgets[$shortcode] ) && isset( $t4p_pb_widgets[$shortcode]['identity_name'] ) ) {
				$modal_title = $t4p_pb_widgets[$shortcode]['identity_name'];
				$content     = $this->config['exception']['data-modal-title'] = $modal_title;
			}
		}

		// if content is still empty, Generate it
		if ( empty( $content ) ) {
			if ( ! $is_sub_element )
			$content = ucfirst( str_replace( 't4p_', '', $shortcode ) );
			else {
				if ( isset( $exception['item_text'] ) ) {
					if ( ! empty( $exception['item_text'] ) )
					$content = T4P_Pb_Utils_Placeholder::add_placeholder( $exception['item_text'] . ' %s', 'index' );
				} else
				$content = T4P_Pb_Utils_Placeholder::add_placeholder( ( __( ucfirst( $parent_shortcode ), 't4p-core' ) . ' ' . __( 'Item', 't4p-core' ) ) . ' %s', 'index' );
			}
		}
		$content = ! empty( $el_title ) ? ( $content . ': ' . "<span>$el_title</span>" ) : $content;

		// element name
		if ( $type == 'element' ) {
			if ( ! $is_sub_element ) {
                            $name = ucfirst( str_replace( 't4p_', '', $shortcode ) );
                        }
			else {
                            $name = __( ucfirst( $parent_shortcode ), 't4p-core' ) . ' ' . __( 'Item', 't4p-core' );
                        }
		}
		else {
			$name = $content;
		}
		if ( empty($shortcode_data) )
		$shortcode_data = $this->config['shortcode_structure'];

		// Process index for subitem element
		if ( ! empty( $index ) ) {
			$shortcode_data = str_replace( '_T4P_INDEX_' , $index, $shortcode_data );
		}

		$shortcode_data  = stripslashes( $shortcode_data );
		$element_wrapper = ! empty( $exception['item_wrapper'] ) ? $exception['item_wrapper'] : ( $is_sub_element ? 'li' : 'div' );
		$content_class   = ( $is_sub_element ) ? 'jsn-item-content' : 't4p-pb-element';
		$modal_title     = empty ( $modal_title ) ? ( ! empty( $exception['data-modal-title'] ) ? "data-modal-title='{$exception['data-modal-title']}'" : '' ) : $modal_title;
		$element_type    = "data-el-type='$type'";				
		$edit_using_ajax = (isset($this->config['edit_using_ajax']) && $this->config['edit_using_ajax']) ? sprintf( "data-using-ajax='%s'", esc_attr( $this->config['edit_using_ajax'] ) ) : '';
		
		$data = array(
			'element_wrapper' => $element_wrapper,
			'modal_title' => $modal_title,
			'element_type' => $element_type,
			'edit_using_ajax' => $edit_using_ajax,
			'edit_inline' => isset( $this->config['edit_inline'] ) ? 1 : 0,
			'name' => $name,
			'shortcode' => $shortcode,
			'shortcode_data' => $shortcode_data,
			'content_class' => $content_class,
			'content' => $content,
			'action_btn' => empty( $exception['action_btn'] ) ? '' : $exception['action_btn'],
			'is_sub_element' => $is_sub_element,
		);
		// Merge extra params if it exists.
		if ( ! empty( $extra_params ) ) {
			$data = array_merge( $data, $extra_params );
		}
		$extra = array();
		if ( isset( $this->config['exception']['disable_preview_container'] ) ) {
			$extra = array(
				'has_preview' => FALSE,
			);
		}
		$data = array_merge( $data, $extra );
		$html_preview = T4P_Pb_Helper_Functions::get_element_item_html( $data, $inlude_sc_structure );
		return array(
		$html_preview
		);
	}

	/**
	 * DEFINE shortcode content
	 *
	 * @param array $atts
	 * @param string $content
	 */
	public function element_shortcode_full( $atts = null, $content = null ) {

	}

	/**
	 * return shortcode content: if shortcode is disable, return empty
	 *
	 * @param array $atts
	 * @param string $content
	 */
	public function element_shortcode( $atts = null, $content = null ) {
		$this->init_element();

		$prefix = T4P_Pb_Helper_Functions::is_preview() ? 'pb_admin' : 'wp';

		// enqueue custom assets at footer of frontend/backend
		add_action( "{$prefix}_footer", array( &$this, 'custom_assets_frontend' ) );

		$arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
		if ( $arr_params['disabled_el'] == 'yes' ) {
			if ( T4P_Pb_Helper_Functions::is_preview() ) {
				return ''; //_e( 'This element is deactivated. It will be hidden at frontend', 't4p-core' );
			}
			return '';
		}

		// enqueue script for current element in frontend
		add_action( 'wp_footer', array( &$this, 'enqueue_assets_frontend' ), 1 );
		// get full shortcode content
		$string  = htmlentities( $content, null, 'utf-8' );
		$content = str_replace( "&nbsp;", "", $string );
		$content = html_entity_decode( $content );

		return $this->element_shortcode_full( $atts, $content );
	}

	/**
	 *  output html of a shortcode
	 *
	 * @param array $arr_params
	 * @param string $html_element
	 * @param string $extra_class
	 * @return string
	 */
	public function element_wrapper( $html_element, $arr_params, $extra_class = '', $custom_style = '' ) {
		$shortcode_name = T4P_Pb_Helper_Shortcode::shortcode_name( $this->config['shortcode'] );
		// extract margin here then insert inline style to wrapper div
		$styles = array();
		if ( ! empty ( $arr_params['div_margin_top'] ) ) {
			$styles[] = 'margin-top:' . intval( $arr_params['div_margin_top'] ) . 'px';
		}
		if ( ! empty ( $arr_params['div_margin_bottom'] ) ) {
			$styles[] = 'margin-bottom:' . intval( $arr_params['div_margin_bottom'] ) . 'px';
		}
		if ( ! empty ( $arr_params['div_margin_left'] ) ) {
			$styles[] = 'margin-left:' . intval( $arr_params['div_margin_left'] ) . 'px';
		}
		if ( ! empty ( $arr_params['div_margin_right'] ) ) {
			$styles[] = 'margin-right:' . intval( $arr_params['div_margin_right'] ) . 'px';
		}
		$style = count( $styles ) ? implode( '; ', $styles ) : '';
		if ( ! empty( $style ) || ! empty( $custom_style ) ){
			$style = "style='$style $custom_style'";
		}

		$class        = "t4p-element-container t4p-element-$shortcode_name";
		$extra_class .= ! empty ( $arr_params['class'] ) ? ' ' . esc_attr( $arr_params['class'] ) : '';
		$class       .= ! empty ( $extra_class ) ? ' ' . ltrim( $extra_class, ' ' ) : '';
		$extra_id     = ! empty ( $arr_params['id'] ) ? ' ' . esc_attr( $arr_params['id'] ) : '';
		$extra_id     = ! empty ( $extra_id ) ? "id='" . ltrim( $extra_id, ' ' ) . "'" : '';
		
		// Element appearing animation

		if ( ! empty ( $arr_params['animation_type'] ) && $arr_params['animation_type'] != '0' ) {
			$animation_direction = 'down';
                        if ( ! empty( $arr_params['animation_direction'] ) ) {
				switch ( $arr_params['animation_direction'] ) {
                                    case 'down':
                                            $animation_direction = 'Down';
                                            break;
                                    case 'left':
                                            $animation_direction = 'Left';
                                            break;
                                    case 'right':
                                            $animation_direction = 'Right';
                                            break;
                                    case 'up':
                                            $animation_direction = 'Up';
                                            break;
				}
			}

                        $appearring_animation = '';
			switch ( $arr_params['animation_type'] ) {
				case 'bounce':
					$appearring_animation   = 'bounce';
					break;
				case 'fade':
					$appearring_animation   = 'fadeIn'.$animation_direction;
					break;
				case 'flash':
					$appearring_animation   = 'flash';
					break;
				case 'shake':
					$appearring_animation   = 'shake';
					break;
				case 'slide':
					$appearring_animation   = 'slideIn'.$animation_direction;
					break;				
			}

                        $animation_speed = '0.1';
                        if ( ! empty( $arr_params['animation_speed'] ) ) {
				switch ( $arr_params['animation_speed'] ) {
                                    case '0.1':
                                            $animation_speed = '0.1s';
                                            break;
                                    case '0.2':
                                            $animation_speed = '0.2s';
                                            break;
                                    case '0.3':
                                            $animation_speed = '0.3s';
                                            break;
                                    case '0.4':
                                            $animation_speed = '0.4s';
                                            break;
                                    case '0.5':
                                            $animation_speed = '0.5s';
                                            break;
                                    case '0.6':
                                            $animation_speed = '0.6s';
                                            break;
                                    case '0.7':
                                            $animation_speed = '0.7s';
                                            break;
                                    case '0.8':
                                            $animation_speed = '0.8s';
                                            break;
                                    case '0.9':
                                            $animation_speed = '0.9s';
                                            break;
                                    case '1':
                                            $animation_speed = '1s';
                                            break;
				}
			}
		}
		$html = "<div  $extra_id class='$class' $style>" . balanceTags( $html_element ) . '</div>';
		if ( ! empty ( $arr_params['animation_type'] ) && $arr_params['animation_type'] != '0' ) {
                    if ( T4P_Pb_Helper_Functions::is_preview() ) {
			$html = "<div class='t4p-animated $appearring_animation' style = 'animation-duration: $animation_speed'>" . $html . "</div>";
                    } else {
                        $html = "<div class='t4p-animated $appearring_animation' animation_class='t4p-animated' data-animationtype='$appearring_animation' data-animationduration='$animation_speed' style = 'animation-duration: $animation_speed'>" . $html . "</div>";
                    }
		}
		return $html;
	}

	/**
	 * Define html structure of shortcode in "Select Elements" Modal
	 *
	 * @param string $data_sort The string relates to Provider name to sort
	 * @return string
	 */
	public function element_button( $data_sort = '' ) {
		// Prepare variables
		$type  = 'element';
		$data_value = strtolower( $this->config['name'] );

		$extra = sprintf( 'data-value="%s" data-type="%s" data-sort="%s"', esc_attr( $data_value ), esc_attr( $type ), esc_attr( $data_sort ) );

		return self::el_button( $extra, $this->config );
	}

	/**
	 * HTML output for a shortcode in Add Element popover
	 *
	 * @param string $extra
	 * @param array $config
	 * @return string
	 */
	public static function el_button( $extra, $config ) {
		// Generate icon if necessary
		$icon = isset( $config['icon'] ) ? $config['icon'] : 't4p-pb-icon-widget';

		$icon = '<i class="t4p-pb-icon-formfields ' . $icon . '"></i> ';

		// Generate data-iframe attribute if needed
		$attr = '';

		if ( isset( $config['edit_using_ajax'] ) && $config['edit_using_ajax'] ) {
			$attr = ' data-use-ajax="1"';
		}

		return '<li class="jsn-item"' . ( empty( $extra ) ? '' : ' ' . trim( $extra ) ) . '>
					<button data-shortcode="' . $config['shortcode'] . '" class="shortcode-item btn btn-default" title="' . $config['description'] . '"' . $attr . '>
						' . $icon . '<span class="t4p-front-set">'.$config['name'] . '</span>
							<p class="help-block">' . $config['description'] . '</p>
					</button>
				</li>';
	}

	/**
	 * Get params & structure of shortcode
	 */
	public function shortcode_data() {
		$params = T4P_Pb_Helper_Shortcode::generate_shortcode_params( $this->items, null, null, false, true );
                $shortcode_name = $this->config['shortcode'];
                $is_sub_element   = ( isset( $this->config['sub_element'] ) ) ? true : false;

		// add Margin parameter for Not child shortcode
		if ( ! $is_sub_element ) {
                    if ( $shortcode_name == 'youtube' || $shortcode_name == 'vimeo' ) {
			$this->config['params'] = array_merge( array( 'div_margin_top' => '10', 'div_margin_bottom' => '10', 'disabled_el' => 'no', 'class' => '' ), $params );
                    }
                    elseif ( $shortcode_name != 'dropcap' && $shortcode_name != 'fontawesome' && $shortcode_name != 'highlight' && $shortcode_name != 'menu_anchor' && $shortcode_name != 'modal' && $shortcode_name != 'modal_text_link' && $shortcode_name != 'popover' && $shortcode_name != 'separator' && $shortcode_name != 'tooltip' ) {
                        $this->config['params'] = array_merge( array( 'div_margin_top' => '10', 'div_margin_bottom' => '10', 'disabled_el' => 'no', 'class' => '', 'id' => '' ), $params );
                    }
                    else {
                        $this->config['params'] = array_merge( array( 'disabled_el' => 'no', 'class' => '', 'id' => '' ), $params );
                    }
		}
		else {
			$this->config['params'] = $params;
		}
		$this->config['shortcode_structure'] = T4P_Pb_Helper_Shortcode::generate_shortcode_structure( $this->config['shortcode'], $this->config['params'] );
	}

}
