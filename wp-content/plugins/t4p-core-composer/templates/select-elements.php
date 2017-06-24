<?php
/**
 * @version    1.0.0
 * @package    Theme4Press PageBuilder
 * @author     Theme4Press
 * 
 */

/**
 * @todo : Popover to select Element
 */

global $t4p_pb, $t4p_pb_shortcodes, $t4p_sc_by_providers_Name;

// Arrray of element objects
$elements = $t4p_pb->get_elements();

if ( empty ( $elements ) || empty ( $elements['element'] ) ) {
    _e( 'You have not install Free or Pro Shortcode package.' );
} else {
	$elements_html = array(); // HTML button of a shortcode
	$categories    = array(); // array of shortcode category

	foreach ( $elements['element'] as $element ) {
		// don't show sub-shortcode
		if ( ! isset( $element->config['name'] ) ) {
			continue;
		}

		// get shortcode category

		$category = ''; // category name of this shortcode
		if ( ! empty( $t4p_pb_shortcodes[$element->config['shortcode']] ) ) {
			$category_name = $t4p_pb_shortcodes[$element->config['shortcode']]['provider']['name'] | '';
			$category      = strtolower( str_replace( ' ', '', $category_name ) );
			if ( ! array_key_exists( $category, $categories ) ) {
				$categories[$category] = $category_name;
			}
		}

		$elements_html[] = $element->element_button( $category );
	}
	?>
<div id="t4p-add-element" class="t4p-add-element add-field-dialog jsn-bootstrap3"
	style="display: none;">
	<div class="popover" style="display: block;">
		<h3 class="popover-title">
		<?php _e( 'Select Element', 't4p-core' ); ?>
		</h3>
		<a type="button" class="close t4p-popover-close">&times;</a>
		<div class="popover-content">
			<div class="jsn-elementselector">
				<div class="jsn-fieldset-filter">
					<fieldset>
						<div class="pull-left">
							<select id="jsn_filter_element"
								class="jsn-filter-button input-large">
								<?php
								// Reorder the Categories of Elements
								$categories_order = array();

								// add Standard Elements as second option
								$standard_el = __( 'Theme4Press Elements', 't4p-core' );
								$key = array_search( $standard_el, $categories );
								$categories_order[$key] = $standard_el;

								unset( $key );

								// Sort other options by alphabetical order
								asort( $categories );
								$categories_order = array_merge( $categories_order, $categories );

								foreach ( $categories_order as $category => $name ) {
									$selected = ( $name == __( 'Theme4Press Elements', 't4p-core' ) ) ? 'selected' : '';
									printf( '<option value="%s" %s>%s</option>', esc_attr( $category ), $selected, esc_html( $name ) );
								}
								?>
								<option value="widget">
								<?php _e( 'Widgets', 't4p-core' ) ?>
								</option>
							</select>
						</div>
						<div class="pull-right jsn-quick-search" role="search">
							<input type="text"
								class="input form-control jsn-quicksearch-field"
								placeholder="<?php _e( 'Search', 't4p-core' ); ?>..."> <a
								href="javascript:void(0);"
								title="<?php _e( 'Clear Search', 't4p-core' ); ?>"
								class="jsn-reset-search" id="reset-search-btn"><i
								class="icon-remove"></i> </a>
						</div>
					</fieldset>
				</div>
				<!-- Elements -->
				<ul class="jsn-items-list">
				<?php
				// shortcode elements
				foreach ( $elements_html as $idx => $element ) {
					echo balanceTags( $element );
				}

				// widgets
				global $t4p_pb_widgets;
				foreach ( $t4p_pb_widgets as $wg_class => $config ) {
					$extra_                    = $config['extra_'];
					$config['edit_using_ajax'] = true;
					echo balanceTags( T4P_Pb_Shortcode_Element::el_button( $extra_, $config ) );
				}
				?>
					<!-- Generate text area to add element from raw shortcode -->
					<li class="jsn-item full-width" data-value='raw'
						data-sort='shortcode'><textarea id="raw_shortcode"></textarea>

						<div class="text-center rawshortcode-container">
							<button class="shortcode-item btn btn-success"
								data-shortcode="raw" id="rawshortcode-add">
								<?php _e( 'Add Element', 't4p-core' ); ?>
							</button>
						</div>
					</li>
				</ul>
				<p style="text-align: center">
				<?php // echo esc_html( __( 'Want to add more elements?', 't4p-core' ) ); ?>
					&nbsp;<!--a target="_blank"
						href="<?php //echo esc_url( admin_url( 'admin.php?page=t4p-pb-addons' ) ); ?>"><?php //echo esc_html( __( 'Check add-ons.', 't4p-core' ) ); ?>
					</a-->
				</p>
			</div>
		</div>
	</div>
</div>

<?php
}