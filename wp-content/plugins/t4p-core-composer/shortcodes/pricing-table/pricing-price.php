<?php
/**
 * @version   1.0.0
 * @package   Theme4Press PageBuilder
 * @author    Theme4Press
 * 
 * 
 */

if ( ! class_exists( 'Pricing_price' ) ) {

	/**
	 * Create pricing price child element.
	 *
	 * @package  T4P PageBuilder Shortcodes
	 * @since    1.0.0
	 */
	class Pricing_price extends T4P_Pb_Shortcode_Child {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		public function element_config() {
			$this->config['shortcode'] = strtolower( __CLASS__ );

			$this->config['exception'] = array();

                        $this->config['edit_inline'] = true;
                        
		}

		/**
		 * DEFINE setting options of shortcode
		 */
		public function element_items() {
			$this->items = array(
				'Notab' => array(
					array(
                                                'name'  => __( 'Currency', 't4p-core' ),
                                                'id'    => 'currency',
                                                'type'  => 'text_field',
                                                'class' => 'input-sm',
                                                'std'   => '$',
                                                'tooltip' => __( 'Insert the pricing currency', 't4p-core' ),
					),
                                        array(
                                                'name'       => __( 'Currency Position', 't4p-core' ),
                                                'id'         => 'currency_position',
                                                'type'       => 'select',
                                                'class'   => 'input-sm',
                                                'std'        => 'left',
                                                'options'    => array(
                                                                'left'      => __( 'Left', 't4p-core' ),
                                                                'center'   => __( 'Center', 't4p-core' ),
                                                                'right'    => __( 'Right', 't4p-core' )
                                                        ),
                                                'tooltip'    => __( 'Select the currency position type.', 't4p-core' )
                                        ),
                                        array(
                                                'name'  => __( 'Price', 't4p-core' ),
                                                'id'    => 'price',
                                                'type'  => 'text_field',
                                                'class' => 'input-sm',
                                                'std'   => '15.55',
                                                'tooltip' => __( 'Insert the price value', 't4p-core' ),
					),
                                        array(
                                                'name'  => __( 'Time Limits', 't4p-core' ),
                                                'id'    => 'time',
                                                'type'  => 'text_field',
                                                'class' => 'input-sm',
                                                'std'   => 'monthly',
                                                'tooltip' => __( 'Insert the time duration', 't4p-core' ),
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
                        $arr_params = ( shortcode_atts( $this->config['params'], $atts ) );
			extract( $arr_params );

                        $currency = ( ! $currency ) ? '$' : $currency;
                        $currency_position = ( ! $currency_position ) ? 'left' : $currency_position;
                        $price = ( ! $price ) ? '15.55' : $price;
                        $time = ( ! $time ) ? 'monthly' : $time;
                        
                        $pricing_class = $pricing = '';
                        $price = explode( '.' , $price );
                        if( isset($price[1]) ){
                                $pricing_class = 'price-with-decimal';
                        }

                        if( $currency_position != 'right' ){
                                $pricing = sprintf( '<span class="currency">%s</span>', $currency );
                        }

                        $pricing .= sprintf( '<span class="integer-part">%s</span>', $price[0] );			

                         if( isset($price[1]) ){
                                $pricing .= sprintf( '<sup class="decimal-part">%s</sup>', $price[1] );
                        }

                        if( $currency_position == 'right' ){
                                $pricing .= sprintf( '<span class="currency pos-right">%s</span>', $currency );

                                if( $time ) {
                                        $pricing .= sprintf( '<br /><span class="time pos-right">%s</span>', $time );
                                }				
                        }			

                        if( $time &&
                                $currency_position != 'right'
                        ) {
                                $pricing .= sprintf( '<br /><span class="time">%s</span>', $time );
                        }			

                        $html = "<div class='panel-body pricing-row'><div class='price $pricing_class'>$pricing</div></div>";

                        return $html . '<!--seperate-->';
		}

	}

}
