<?php
/**
 * @version    1.0.0
 * @package    Theme4Press PageBuilder
 * @author     Theme4Press 
 *
 */

/**
 * @todo : Modal box content
 */

if ( ! isset( $_POST ) ) {
	die;
}

extract( $_POST );
$submodal = ! empty( $submodal ) ? 'submodal_frame' : '';
if ( ! isset( $params ) ) {
	exit;
}

if ( ! empty( $shortcode ) ) {
	$script     = '';
	if ( isset( $init_tab ) && $init_tab == 'styling' ) {
		// Auto move to Styling tab if previous action
		// is coping style from other element.
		$script .= "
			(function ($) {
				$(document).ready(function (){
					setTimeout(function (){
						$('[href=\"#styling\"]').click();
					}, 500);

				});
			})(jQuery);";
	}

	if ($_REQUEST['form_only']) {
		$script .=  " var t4p_pb_modal_ajax = true;";
	}

	T4P_Pb_Init_Assets::print_inline( 'js', $script, true );
	?>

<div
	id="t4p-element-<?php echo esc_attr( T4P_Pb_Helper_Shortcode::shortcode_name( $shortcode ) ); ?>">
	<div class="t4p-pb-form-container jsn-bootstrap3">
		<div id="modalOptions"
			class="form <?php echo esc_attr( $submodal ); ?>">
			<?php
			if ( ! empty( $params ) ) {
				$params = stripslashes( $params );
				$params = urldecode( $params );
			}
			// elements
			if ( $el_type == 'element' ) {

				echo T4P_Pb_Objects_Modal::shortcode_modal_settings( $shortcode, $params, isset( $el_title ) ? $el_title : '' );

				?>
			<form id="frm_shortcode_settings" action="" method="post">
			<?php
			// Render the inputs to store element setting data for Copy style feature
			foreach ( $_POST as $k => $v ) {
				echo '<input type="hidden" id="hid-' . $k .  '" name="' . $k . '" value="' . urlencode( $v ) . '" />';
			}
			echo '<input type="hidden" id="hid-init_tab" name="init_tab" value="styling" />';
			?>
			</form>
			<?php
			}
			// widgets
			else if ( $el_type == 'widget' ) {
				$instance          = T4P_Pb_Helper_Shortcode::extract_widget_params( $params );
				$instance['title'] = isset( $instance['title'] ) ? $instance['title'] : $el_title;

				// generate setting form of widget
				$widget = new $shortcode();
				ob_start();
				$widget->form( $instance );
				$form = ob_get_clean();

				// simplify widget field name
				$exp  = preg_quote( $widget->get_field_name( '____' ) );
				$exp  = str_replace( '____', '(.*? )', $exp );
				$form = preg_replace( '/' . $exp . '/', '$1', $form );

				// simplify widget field id
				$exp  = preg_quote( $widget->get_field_id( '____' ) );
				$exp  = str_replace( '____', '(.*? )', $exp );
				$form = preg_replace( '/' . $exp . '/', '$1', $form );

				// tab and content generate
				$tabs = array();
				foreach ( array( 'content', 'styling' ) as $i => $tab ) {
					$active               = ( $i ++ == 0 ) ? 'active' : '';
					$data_['href']        = "#$tab";
					$data_['data-toggle'] = 'tab';
					$content_             = ucfirst( $tab );
					$tabs[]               = "<li class='$active'>" . T4P_Pb_Objects_Modal::tab_settings( 'a', $data_, $content_ ) . '</li>';
				}

				// content
				$contents   = array();
				$contents[] = "<div class='tab-pane active' id='content'><form id='t4p-widget-form'>$form</form></div>";
				$contents[] = "<div class='tab-pane' id='styling'>" . T4P_Pb_Helper_Shortcode::render_parameter( 'preview' ) . '</div>';

				$output = T4P_Pb_Objects_Modal::setting_tab_html( $shortcode, $tabs, $contents, array(), '', array() );

				echo balanceTags( $output );
			}
			?>
			<div id="modalAction" class="t4p-pb-setting-tab"></div>
		</div>
		<textarea class="hidden" id="shortcode_content">
		<?php echo esc_attr( $params ); ?>
		</textarea>
		<textarea class="hidden" id="t4p_share_data"></textarea>
		<textarea class="hidden" id="t4p_merge_data"></textarea>
		<textarea class="hidden" id="t4p_extract_data"></textarea>
		<input type="hidden" id="t4p_previewing" value="0" />
		<input id="shortcode_type" type="hidden" value="<?php echo esc_attr( $el_type ); ?>" />
		<input id="shortcode_name" type="hidden" value="<?php echo esc_attr( esc_sql( $_GET['t4p_modal_type'] ) ); ?>" />

		<div class="jsn-modal-overlay"></div>
		<div class="jsn-modal-indicator"></div>

		<?php
		// append custom assets/HTML for specific shortcode here
		do_action( 't4p_pb_modal_footer', $shortcode ); ?>
	</div>
</div>
<?php
}