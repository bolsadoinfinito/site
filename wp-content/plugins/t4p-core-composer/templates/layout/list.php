<?php
/**
 * @version    1.0.0
 * @package    Theme4Press PageBuilder
 * @author     Theme4Press
 */

/**
 * @todo : List all page template
 */

$data = T4P_Pb_Helper_Layout::get_premade_layouts();
?>

<div class="jsn-master" id="t4p-pb-layout-box">
	<div class="jsn-bootstrap3">
		<div id="t4p-layout-lib">
			<input type="hidden" id="t4p-pb-layout-group"
				value="<?php echo esc_attr( T4P_PAGEBUILDER_USER_LAYOUT ); ?>" />
			<!-- Elements -->

				<?php
				// Get only the templates which saved by user.
				$user_templates = isset ( $data['files'] ) && isset ( $data['files'][T4P_PAGEBUILDER_USER_LAYOUT] ) ? $data['files'][T4P_PAGEBUILDER_USER_LAYOUT] : array();
				if ( ! count( $user_templates ) ) {
					echo '<p class="jsn-bglabel">You did not save any page yet.</p>';
				} else {
					$items   = array();
					$items[] = '<ul class="jsn-items-list " style="height: auto;">';
					foreach ( $user_templates as $name => $path ) {
						$layout_name = T4P_Pb_Helper_Layout::extract_layout_data( $path, 'name' );
						$layout_name = empty ( $layout_name ) ? __( '&mdash; Untitled &mdash;' ) : $layout_name;
						$content     = T4P_Pb_Helper_Layout::extract_layout_data( $path, 'content' );
						$items[]     = '<li data-type="element" data-value="user_layout" data-id="' . $name . '" class="jsn-item premade-layout-item" style="display: list-item;">
					' . $layout_name . '
					<i class="icon-trash delete-item"></i>
				<textarea style="display:none">' . $content . '</textarea>
			</li>';

					}
					$items[] = '</ul>';

					echo balanceTags( implode( "\n", $items ) );
				}

				?>

		</div>
	</div>
</div>
