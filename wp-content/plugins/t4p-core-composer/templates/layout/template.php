<?php
/**
 * 
 * @version	1.0.1
 * @package	Theme4Press PageBuilder
 * @author	Theme4Press
 * 
 */

/**
 * @todo : HTML form to save page template
 */
?>
<div id="t4p-add-layout" style="display: none;">
	<div class="popover top" style="display: block;">
		<div class="arrow"></div>
		<div class="popover-content">

			<div class="layout-box">
				<div id="save-layout" class="layout-action">
					<a href="javascript:void(0)"><?php _e( 'Save current content as template', 't4p-core' ); ?>
						<i class="icon-star"></i> </a>
				</div>
				<div id="save-layout-form"
					class="input-append hidden layout-toggle-form">
					<input type="text" name="layout_name" id="layout-name"
						placeholder="<?php _e( 'Layout Name', 't4p-core' ); ?>">
					<button class="btn" type="button">
						<i class="icon-checkmark"></i>
					</button>
					<button type="button" class="btn btn-layout-cancel"
						data-id="save-layout">
						<i class="icon-remove"></i>
					</button>
				</div>
				<div class="hidden layout-loading">
					<i class="jsn-icon16 jsn-icon-loading"></i>
				</div>
				<div class="hidden layout-message">
				<?php _e( 'Saved successfully', 't4p-core' ); ?>
				</div>
			</div>

			<div id="apply-layout">
				<a href="javascript:void(0)"><?php _e( 'Apply template from library', 't4p-core' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>
