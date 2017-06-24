<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */
?>
<div class="wrap jsn-bootstrap3">
	<h2><?php _e( $plugin['Name'], 't4p-core' ); ?> <?php _e( 'Add-ons', 't4p-core' ); ?></h2>
	<p>
		<?php printf( __( 'Extend %s functionality with following add-ons', 't4p-core' ), __( $plugin['Name'], 't4p-core' ) ); ?>
	</p>
	<div id="t4p-product-addons">
		<ul id="<?php echo '' . $plugin['Identified_Name']; ?>-addons" class="thumbnails clearfix">
			<?php foreach ( $plugin['Addons'] as $identified_name => $details ) : ?>
			<li class="thumbnail pull-left">
				<a href="<?php echo esc_url( $details->url ); ?>" target="_blank">
					<img src="<?php echo esc_url( $details->thumbnail ); ?>" alt="<?php esc_attr_e( $details->name, 't4p-core' ) ?>" />
				</a>
				<?php if ( ! $details->compatible ) : ?>
				<span class="label label-danger"><?php _e( 'Incompatible', 't4p-core' ); ?></span>
				<?php elseif ( $details->installed ) : ?>
				<span class="label label-success"><?php _e( 'Installed', 't4p-core' ); ?></span>
				<?php endif; ?>
				<div class="caption">
					<h3><?php _e( $details->name, 't4p-core' ) ?></h3>
					<p><?php _e( $details->description, 't4p-core' ) ?></p>
					<div class="actions clearfix">
						<div class="pull-left">
							<?php if ( ! $details->installed ) : ?>
							<a class="btn btn-primary <?php if ( ! $details->compatible ) echo 'disabled'; ?>" href="javascript:void(0);" <?php if ( $details->compatible ) : ?>data-action="install" data-authentication="<?php echo absint( $details->authentication ); ?>" data-identification="<?php echo '' . $details->identified_name; ?>"<?php endif; ?>>
								<?php _e( 'Install', 't4p-core' ); ?>
							</a>
							<?php else : if ( $details->updatable ) : ?>
							<a class="btn btn-primary <?php if ( ! $details->compatible ) echo 'disabled'; ?>" href="javascript:void(0);" data-action="update" <?php if ( $details->compatible ) : ?>data-authentication="<?php echo absint( $details->authentication ); ?>" data-identification="<?php echo '' . $details->identified_name; ?>"<?php endif; ?>>
								<?php _e( 'Update', 't4p-core' ); ?>
							</a>
							<?php endif; ?>
							<a class="btn <?php if ( ! $details->updatable ) echo 'btn-primary'; ?> <?php if ( ! $details->compatible ) echo 'incompatible'; ?>" href="javascript:void(0);" data-action="uninstall" data-authentication="<?php echo absint( $details->authentication ); ?>" data-identification="<?php echo '' . $details->identified_name; ?>">
								<?php _e( 'Uninstall', 't4p-core' ); ?>
							</a>
							<?php endif; ?>
						</div>
						<a class="btn btn-info pull-right" href="<?php echo esc_url( $details->url ); ?>" target="_blank">
							<?php _e( 'More Info', 't4p-core' ); ?>
						</a>
					</div>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<div class="jsn-bootstrap3 t4p-product-addons-authentication">
	<div class="modal fade" id="<?php echo '' . $plugin['Identified_Name']; ?>-authentication" tabindex="-1" role="dialog" aria-labelledby="<?php echo '' . $plugin['Identified_Name']; ?>-authentication-modal-label" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="<?php echo '' . $plugin['Identified_Name']; ?>-authentication-modal-label">
						<?php _e( 'Theme4press Customer Account', 't4p-core' ); ?>
					</h4>
				</div>
				<div class="modal-body">
					<form name="T4P_Addons_Authentication" method="POST" class="form-horizontal" autocomplete="off">
						<div class="alert alert-danger hidden">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<span class="message"></span>
						</div>
						<div class="form-group clearfix">
							<label class="col-sm-3 control-label" for="username"><?php _e( 'Username', 't4p-core' ); ?>:</label>
							<div class="col-sm-9">
								<input type="text" value="" class="form-control" id="username" name="username" autocomplete="off" />
							</div>
						</div>
						<div class="form-group clearfix">
							<label class="col-sm-3 control-label" for="password"><?php _e( 'Password', 't4p-core' ); ?>:</label>
							<div class="col-sm-9">
								<input type="password" value="" class="form-control" id="password" name="password" autocomplete="off" />
							</div>
						</div>
						<div class="form-group clearfix">
							<div class="col-sm-9 pull-right">
								<div class="checkbox-inline">
									<label>
										<input type="checkbox" value="1" id="remember" name="remember" autocomplete="off" />
										<?php _e( 'Remember Me', 't4p-core' ); ?>
									</label>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary"><?php _e( 'Install', 't4p-core' ); ?></button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e( 'Cancel', 't4p-core' ); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
// Load inline script initialization
$script = '
		new $.T4P_ProductAddons({
			base_url: "' . esc_url( admin_url( 'admin-ajax.php?action=t4p-addons-management' ) ) . '",
 			core_plugin: "' . $plugin['Identified_Name'] . '",
 			has_saved_account: ' . ( $has_customer_account ? 'true' : 'false' ) . ',
			language: {
				CANCEL: "' . __( 'Cancel', 't4p-core' ) . '",
				INSTALL: "' . __( 'Install', 't4p-core' ) . '",
				UNINSTALL: "' . __( 'Uninstall', 't4p-core' ) . '",
				INSTALLED: "' . __( 'Installed', 't4p-core' ) . '",
				INCOMPATIBLE: "' . __( 'Incompatible', 't4p-core' ) . '",
				UNINSTALL_CONFIRM: "' . __( 'Are you sure you want to uninstall %s?', 't4p-core' ) . '",
				AUTHENTICATING: "' . __( 'Verifying...', 't4p-core' ) . '",
				INSTALLING: "' . __( 'Installing...', 't4p-core' ) . '",
				UPDATING: "' . __( 'Updating...', 't4p-core' ) . '",
				UNINSTALLING: "' . __( 'Uninstalling...', 't4p-core' ) . '",
			}
		});';

T4P_Pb_Init_Assets::inline( 'js', $script );
