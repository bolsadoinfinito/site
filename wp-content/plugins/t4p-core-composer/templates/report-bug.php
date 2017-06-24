<?php
/**
 * @version    1.0.0
 * @package    Theme4Press PageBuilder
 * @author     Theme4Press
 * 
 */
?>
<div class="jsn-master" id="t4p-pb-custom-css-box">
	<div class="jsn-bootstrap3">
		<div class="form-group control-group jsn-items-list-container t4p-modal-content">
			<form id="t4p-form-report-bug" class="form-horizontal" role="form">
				<div class="form-group clearfix">
					<label for="t4p_description" class="control-label" title="<?php echo __( 'Description', 't4p-core' ) ?>"><?php echo __( 'Description', 't4p-core' ) ?></label>
					<p class="help-block"><?php echo __( 'Please give the details of your report. Our technical staffs will recheck and fix bug(s) as soon as possible', 't4p-core' ) ?></p>
					<textarea id="t4p_description" name="t4p_description" class="form-control" row="3" style="min-height:120px"></textarea>
				</div>
				<div class="form-group clearfix">
					<label for="t4p_browser" class="control-label" title="<?php echo __( 'Browser', 't4p-core' ) ?>"><?php echo __( 'Browser', 't4p-core' ) ?></label>
					<p class="help-block"><?php echo __( 'Chose the browser that you meet the bug while using', 't4p-core' ) ?></p>
					<select id="t4p_browser" name="t4p_browser" class="form-control">
						<option value="0"><?php echo __( '--Select Browser--', 't4p-core' ) ?></option>
						<option value="firefox"><?php echo __( 'Firefox', 't4p-core' ) ?></option>
						<option value="chrome"><?php echo __( 'Chrome', 't4p-core' ) ?></option>
						<option value="safari"><?php echo __( 'Safari', 't4p-core' ) ?></option>
						<option value="opera"><?php echo __( 'Opera', 't4p-core' ) ?></option>
						<option value="ie"><?php echo __( 'Internet Explorer', 't4p-core' ) ?></option>
						<option value="other"><?php echo __( 'Other', 't4p-core' ) ?></option>
					</select>
				</div>
				<div class="form-group clearfix">
					<label for="t4p_attachment" class="control-label" title="<?php echo __( 'Attachment(s)', 't4p-core' ) ?>"><?php echo __( 'Attachment(s)', 't4p-core' ) ?></label>
					<div class="controls">
						<div class="input-append input-group">
							<input id="t4p_attachment" name="t4p_attachment" class="input-sm form-control" type="text" value="" />
							<input type="hidden" name="t4p_attachment_id" id="t4p_attachment_id" value="" />
							<span class="t4p_attachment_select input-group-addon btn btn-default">...</span>
							<span class="t4p_attachment_remove input-group-addon btn btn-default"><i class="icon-remove"></i></span>
						</div>
					</div>
				</div>
				<div class="form-group clearfix">
					<label for="t4p_url" class="control-label" title="<?php echo __( 'Or Enter an URL', 't4p-core' ) ?>"><?php echo __( 'Or Enter an URL', 't4p-core' ) ?></label>
					<input type="text" id="t4p_url" name="t4p_url" class="form-control" placeholder="http://" value="" />
				</div>
			</form>
		</div>
	</div>
</div>