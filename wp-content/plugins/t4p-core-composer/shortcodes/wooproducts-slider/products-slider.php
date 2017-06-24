<?php
/**
 * @version	1.0.0
 * @package	 Theme4Press PageBuilder
 * @author	 Theme4Press
 */

if ( ! class_exists( 'Products_slider' ) ) :

/**
 * Create Products_slider element.
 *
 * @package  T4P PageBuilder Shortcodes
 * @since    1.0.0
 */
class Products_slider extends T4P_Pb_Shortcode_Element {
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
		$this->config['name']        = __( 'WooCommerce Products Slider', 't4p-core' );
		$this->config['cat']         = __( 'Post-Based', 't4p-core' );
		$this->config['icon']        = 't4p-pb-icon-woocommerce';
		$this->config['description'] = __( 'Add a WooCommerce Products in Slider', 't4p-core' );

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
                                        'name'       => __( 'Picture Size', 't4p-core' ),
                                        'id'         => 'picture_size',
                                        'type'       => 'select',
                                        'class'   => 'input-sm',
                                        'std'        => 'fixed',
                                        'options'    => array(
                                                        'fixed'      => __( 'Fixed', 't4p-core' ),
                                                        'auto'   => __( 'Auto', 't4p-core' ),
                                                ),
                                        'tooltip'    => __( 'fixed = width and height will be fixed
                                                            auto = width and height will adjust to the image.', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Categories', 't4p-core' ),
                                        'id'         => 'cat_slug',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '',
                                        'multiple'   => 'multiple',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_categories( 'product_cat' ),
                                        'tooltip'    => __( 'Select a category or leave blank for all', 't4p-core' )
                                ),
                                array(
                                        'name'       => __( 'Number of Products ', 't4p-core' ),
                                        'id'         => 'number_posts',
                                        'type'       => 'select',
                                        'class'      => 'input-sm',
                                        'std'        => '5',
                                        'options'    => T4P_Pb_Helper_Type::t4p_shortcodes_range( 20, false ),
                                        'tooltip'    => __( 'Select the number of products to display', 't4p-core' )
                                ),
                                array(
					'name'     => __( 'Show Categories', 't4p-core' ),
					'id'       => 'show_cats',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose to show or hide the categories', 't4p-core' ),
				),
                                array(
					'name'     => __( 'Show Price ', 't4p-core' ),
					'id'       => 'show_price',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose to show or hide the price', 't4p-core' ),
				),
                                array(
					'name'     => __( 'Show Buttons ', 't4p-core' ),
					'id'       => 'show_buttons',
					'type'     => 'radio',
					'std'      => 'yes',
					'options'  => array( 'yes' => __( 'Yes', 't4p-core' ), 'no' => __( 'No', 't4p-core' ) ),
					'tooltip'	=> __( 'Choose to show or hide the icon buttons', 't4p-core' ),
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

                $picture_size  = ( ! $picture_size ) ? 'fixed' : $picture_size;
                $cat_slug  = ( ! $cat_slug ) ? '' : $cat_slug;
                $number_posts  = ( ! $number_posts ) ? 5 : $number_posts;
                $show_cats  = ( ! $show_cats ) ? 'no' : $show_cats;
                $show_price  = ( ! $show_price ) ? 'no' : $show_price;
                $show_buttons  = ( ! $show_buttons ) ? 'no' : $show_buttons;

                $html = '';
		$buttons = '';

		if( class_exists( 'Woocommerce' ) ) {

			$number_posts = (int) $number_posts;
                        $tax_query = '';

                        if( $cat_slug ) {
				$cat_id = explode( ',', $cat_slug );
				$tax_query =
					array(
						array(
							'taxonomy' 	=> 'product_cat',
							'field' 	=> 'slug',
							'terms' 	=> $cat_id
						)
					);
			}

			$args = array(
				'post_type' 		=> 'product',
				'posts_per_page'	=> $number_posts,
				'meta_query' 		=> array(
					array(
						'key' 		=> '_thumbnail_id',
						'compare' 	=> '!=',
						'value' 	=> null
					)
				),
                                'tax_query'             => $tax_query,
			);

			$css_class = 'simple-products-slider';

			if( $picture_size != 'fixed' ) {
				$css_class = 'simple-products-slider-variable';
			}

			$products = new WP_Query( $args );
			$products_wrapper = $product = '';

			if( $products->have_posts() ) {

				while( $products->have_posts() ) {
					$products->the_post();

					$image = $price_tag = $terms = '';
					
					if( has_post_thumbnail() ) {

						if( $smof_data['image_rollover'] ) {

							$image = get_the_post_thumbnail( get_the_ID(), 'shop_catalog' );

						} else {

							$image = sprintf( '<a href="%s">%s</a>', get_permalink( get_the_ID() ), get_the_post_thumbnail( get_the_ID(), 'shop_catalog' ) );
						}

						if( $show_cats == 'yes' ) {
							$terms = get_the_term_list(get_the_ID(), 'product_cat', sprintf( '<span %s>', T4PCore_Plugin::attributes( 'cats' ) ), ', ', '</span>');
						}

						ob_start();
						wc_get_template( 'loop/price.php' );
						$price = ob_get_contents();
						ob_end_clean();

						if( $price && $show_price == 'yes' ) {
							$price_tag = $price;
						}

						if( $show_buttons == 'yes' ) {
						
							ob_start();
							wc_get_template('loop/add-to-cart.php');
							$cart_button = ob_get_contents();
							ob_end_clean();

							$buttons = sprintf( '<div class=%s>%s</div>', 'product-buttons', $cart_button,
												get_permalink() );
						}						
						
                                                //img_div_attr
                                                $product_link = get_permalink();
                                                $product_title = get_the_title();
						$product .= "<li><div class='image' aria-haspopup='true'>$image<div class='image-extras'><div class='image-extras-content'><h3><a href='$product_link'>$product_title</a></h3><br />$terms $price_tag $buttons</div></div></div></li>";
					}
				}
				$products_wrapper = sprintf('<ul>%s</ul>', $product );
			}

                        wp_reset_query();

			$html = "<div class='t4p-woo-product-slider woo-product-slider-shortcode'><div class='{$css_class} simple-products-slider'><div class='es-carousel-wrapper t4p-carousel-large'><div class='es-carousel'>$products_wrapper</div><div class='es-nav'><span class='es-nav-prev'></span><span class='es-nav-next'></span></div></div></div><div class='t4p-clearfix'></div></div>";

		}

		return $this->element_wrapper( $html, $arr_params );
	}
}

endif;
