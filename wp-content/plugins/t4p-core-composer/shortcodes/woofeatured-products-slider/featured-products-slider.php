<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Featured_products_slider' ) ) :

/**
 * Create Featured_products_slider element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Featured_products_slider extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'WooCommerce Featured Products Slider', 't4p-core' );
		$this->config['cat']         = __( 'Post-Based', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-woocommerce';
		$this->config['description'] = __( 'Add a WooCommerce Featured Products in Slider', 't4p-core' );

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
			'styling' => array(
				array(
					'type' => 'preview',
				),
                                array(
                                        'type'       => 'label',
                                        'class'   => 'input-sm',
                                        'std'        => 'No settings required. Insert the shortcode and your featured products will be pulled. <br>'
                                                        . 'Featured products are products that you have "Starred" in the WooCommerce settings.',
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
               global $woocommerce, $smof_data;
		$arr_params    = ( shortcode_atts( $this->config['params'], $atts ) );
                extract( $arr_params );

                $picture_size  =  'fixed' ;

                $html = '';
		$buttons = '';

		if( class_exists( 'Woocommerce' ) ) {

                        $theme = wp_get_theme(); // gets the current theme
			if ('evolve Plus' == $theme->name || 'evolve Plus' == $theme->parent_theme) {
                                $args = array(
					'post_type' 		=> 'product',
					'posts_per_page' 	=> -1,
					'meta_key' 		=> '_featured',
					'meta_value' 		=> 'yes',
					'picture_size'          => 'fixed'
				);
			} else {
				$args = array(
					'post_type' 		=> 'product',
					'posts_per_page' 	=> -1,
					'meta_key' 		=> '_featured',
					'meta_value' 		=> 'yes',					
				);
			}

                        if ('evolve Plus' == $theme->name || 'evolve Plus' == $theme->parent_theme) {
                                $css_class = 'simple-products-slider';

                                if( $picture_size != 'fixed' ) {
                                        $css_class = 'simple-products-slider-variable';
                                }
			}

                        $products = new WP_Query( $args );
			$products_wrapper = $product = '';

			if( $products->have_posts() ) {

				while( $products->have_posts() ) {
					$products->the_post();

					$image = $price_tag = $terms = $buttons = '';

					if( has_post_thumbnail() ) {

						if( $smof_data['image_rollover'] ) {
							$image = get_the_post_thumbnail( get_the_ID(), 'shop_single' );
						} else {
							$image = sprintf( '<a href="%s">%s</a>', get_permalink( get_the_ID() ), get_the_post_thumbnail( get_the_ID(), 'shop_single' ) );
						}

						$terms = get_the_term_list( get_the_ID(), 'product_cat', sprintf( '<span %s>', T4PCore_Plugin::attributes( 'cats' ) ), ', ', '</span>' );

						ob_start();
						wc_get_template( 'loop/price.php' );
						$price = ob_get_contents();
						ob_end_clean();

						if( $price ) {
							$price_tag = $price;
						}

						ob_start();
						wc_get_template('loop/add-to-cart.php');
						$cart_button = ob_get_contents();
						ob_end_clean();
						
						$buttons = sprintf( '<div class=%s>%s</div>', 'product-buttons', $cart_button,
												get_permalink() );						

						//img_div_attr
                                                $product_link = get_permalink();
                                                $product_title = get_the_title();
						$product .= "<li><div class='image' aria-haspopup='true'>$image<div class='image-extras'><div class='image-extras-content'><h3><a href='$product_link'>$product_title</a></h3><br />$terms $price_tag $buttons</div></div></div></li>";
					}

				}

				$products_wrapper = sprintf('<ul>%s</ul>', $product );

			}

                        wp_reset_query();

			if ('evolve Plus' == $theme->name || 'evolve Plus' == $theme->parent_theme) {							 
                                $html = "<div class='t4p-woo-product-slider woo-product-slider-shortcode'><div class='{$css_class} simple-products-slider'><div class='es-carousel-wrapper t4p-carousel-large'><div class='es-carousel'>$products_wrapper</div><div class='es-nav'><span class='es-nav-prev'></span><span class='es-nav-next'></span></div></div></div><div class='t4p-clearfix'></div></div>";
			} else {
				$html = "<div class='t4p-woo-featured-products-slider es-carousel-wrapper' ><div class='products-slider es-carousel' >$products_wrapper</div><div class='es-nav'><span class='es-nav-prev'></span><span class='es-nav-next'></span></div></div></div><div class='t4p-clearfix'></div></div>";
			}
		}
                
		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
