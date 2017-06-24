<?php
/**
 * @version   1.0.0
 * @package   Theme4Press PageBuilder
 * @author    Theme4Press
 * 
 * 
 */

if ( ! class_exists( 'Pricing_column' ) ) {

	class Pricing_column extends T4P_Pb_Shortcode_Parent {

                private $is_first_li = true;
                private $is_last_li = true;

		public function __construct() {
			parent::__construct();
		}

		public function element_config() {
			$this->config['shortcode']        = strtolower( __CLASS__ );
                        $this->config['has_subshortcode'] = 'Pricing_price';
                        $this->config['has_subshortcode'] = 'Pricing_row';
                        $this->config['has_subshortcode'] = 'Pricing_footer';

                        $this->config['exception'] = array();

                        $this->config['edit_using_ajax'] = true;
		}

		public function element_items() {
			$this->items = array(
                                'Notab' => array(
                                        array(
						'name'    => __( 'Title', 't4p-core' ),
						'id'      => 'title',
						'type'    => 'text_field',
						'class'   => 'jsn-input-xxlarge-fluid',
						'role'    => 'title',
						'std'     => 'Standard',
						'tooltip' => __( 'Title', 't4p-core' )
					),
					array(
						'name'    => __( 'Standout', 't4p-core' ),
						'id'      => 'standout',
						'type'    => 'radio',
						'std'     => 'no',
						'options' => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
						'tooltip' => __( 'Featured', 't4p-core' ),
					),
                                        array(
                                                'name'                     => __( 'Pricing Price', 't4p-core' ),
                                                'id'                       => 'prtbl_price',
                                                'type'                     => 'group',
                                                'shortcode'                => ucfirst( __CLASS__ ),
                                                'sub_item_type'            => 'Pricing_price',
                                                'sub_items'                => array(
                                                        array( 'currency' => '$', 'currency_position' => 'left', 'price' => '15.55', 'time' => 'monthly' ),
                                                ),
                                        ),
                                        array(
                                                'name'                     => __( 'Pricing Row', 't4p-core' ),
                                                'id'                       => 'prtbl_row',
                                                'type'                     => 'group',
                                                'shortcode'                => ucfirst( __CLASS__ ),
                                                'sub_item_type'            => 'Pricing_row',
                                                'sub_items'                => array(
                                                        array( 'row' => 'Feature 1'),
                                                ),
                                        ),
                                        array(
                                                'name'                     => __( 'Pricing Footer', 't4p-core' ),
                                                'id'                       => 'prtbl_footer',
                                                'type'                     => 'group',
                                                'shortcode'                => ucfirst( __CLASS__ ),
                                                'sub_item_type'            => 'Pricing_footer',
                                                'sub_items'                => array(
                                                        array( 'footer' => 'Signup', 'button_url' => ''),
                                                ),
                                        ),
                                ),
			);
		}

		public function element_shortcode_full( $atts = null, $content = null ) {
                        global $pricing_column_params, $column;

                        $pricing_column_params = $arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
			extract( $arr_params );

                        $class = 't4p-pricingtable-column';
                        $id = '';
                        $standout = ( ! $standout ) ? 'no' : $standout;
                        $title = ( ! $title ) ? '' : $title;

                        //for get sub element html
                        $sub_shortcode = do_shortcode( $content );
                        $items = explode( '<!--seperate-->', $sub_shortcode );
                        $items = array_filter( $items );
                        
                        $counter = 1;
                        foreach ( $items as $idx => $item ) {
                                if (strpos($item, '<li') !== false) {
                                        if( $this->is_first_li.$counter && $idx != 0) {
                                            $items[$idx-1] = $items[$idx-1]."<ul class='list-group'>";
                                        } elseif($this->is_first_li.$counter) {
                                            $items[$idx] = "<ul class='list-group'>".$items[$idx];
                                        }
                                        $this->is_first_li.$counter = false;
                                }

                                if (strpos($item, '</li>') == false && $this->is_first_li.$counter != true) {
                                        if( $this->is_last_li.$counter ) {
                                            $items[$idx-1] = $items[$idx-1]."</ul>";
                                        }
                                        $this->is_last_li.$counter = false;
                                }
                                $items[$idx] = $item;
                                $counter++;
                        }

                        $sub_shortcode = implode( '', $items );
                        $sub_htmls = $sub_shortcode;

                        $attr_class = 'panel-wrapper t4p-column column col-lg-' . $column . ' col-md-' . $column . ' col-sm-' . $column;

                        if( $column == '2.4'  ) {
                                $attr_class = 'panel-wrapper col-lg-2 col-md-2 col-sm-2';
                        }

                        if( $standout == 'yes' ) {
                                $attr_class .= ' standout';
                        }

                        $attr_class .= ' ' . $class;

                        $attr_id = $id;

                        $html = "<div class='$attr_class' id='$attr_id'><div class='panel-container'><div class='panel'><div class='panel-heading'><h3 class='title-row'>$title</h3></div>$sub_htmls";

                        $html .= '</div></div></div>';

                        return $html . '<!--seperate_column-->';
		}
	}

}