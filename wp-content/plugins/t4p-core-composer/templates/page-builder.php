<?php
/**
 * @version    1.0.0
 * @package    Theme4Press Page Builder
 * @author     Theme4Press 
 * 
 */

global $post;

wp_nonce_field( 't4p_builder', T4P_NONCE . '_builder' );

$settings = T4P_Pb_Product_Plugin::t4p_pb_settings_options();

?>
<!-- Buttons bar -->
<div class="jsn-form-bar">
	<!-- Page Templates -->
	<div class="pull-right" id="top-btn-actions">
		<div class="pull-left" id="page-custom-css">
			<button class="btn btn-default" onclick="return false;">
			<?php _e( 'Custom CSS', 't4p-core' ) ?>
			</button>
		</div>
		<div class="btn-group dropdown pull-left" id="page-template">
			<a class="btn btn-default dropdown-toggle t4p-dropdown-toggle"
				href="#"><i class="icon-settings"></i>
			</a>
			<ul class="dropdown-menu pull-right">
				<li><a href="#" id="save-as-new" class="t4p-modal-toggle"><?php _e( 'Save template', 't4p-core' ); ?>
				</a></li>
				<li><a id="apply-page" href="#"><?php _e( 'Load template', 't4p-core' ); ?>
				</a></li>
			</ul>
		</div>
	</div>

	<!-- Save as new template modal -->
	<div id="save-as-new-dialog" role="dialog" aria-hidden="true"
		tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header ui-dialog-title">
					<h3>
					<?php _e( 'Save as a new template', 't4p-core' ); ?>
					</h3>
				</div>
				<div class="modal-body form-horizontal">
					<div class="form-group">
						<label class="control-label" for="template-name"><?php _e( 'Template Name:' );?>
						</label>
						<div class="controls">
							<input type="text" id="template-name" class="input form-control">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-primary template-save"><?php _e( 'Save', 't4p-core' ); ?>
					</a> <a href="#" class="btn template-cancel"><?php _e( 'Cancel', 't4p-core' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
	<!-- END Save as new template modal -->

        <div class="clearfix"></div>
</div>

<!-- T4P PageBuilder elements -->
<div class="jsn-section-content jsn-style-light"
	id="form-design-content">
	<div id="t4p-pbd-loading" class="text-center">
		<i class="jsn-icon32 jsn-icon-loading"></i>
	</div>
	<div class="t4p-pb-form-container jsn-layout">
	<?php if ( @count( $converters ) ) : ?>
		<?php foreach ( $converters as $id => $name ) : ?>
		<!-- Data conversion dialog -->
		<div class="data-conversion-dialog" data-target="<?php echo esc_attr( $id ); ?>">
			<div class="alert alert-warning">
				<i class="icon-warning"></i>
				&nbsp;&nbsp;&nbsp;
				<span class="message">
				<?php
				// Get current post type's singular_name
				$post_type = get_post_type_object( get_post_type() );
				$post_type = strtolower( $post_type->labels->singular_name );

				printf(
					__(
						'Your current %1$s has been built by using <strong>%2$s</strong>. Would you like to convert all data to <strong>Theme4Press PageBuilder</strong>?',
						't4p-core'
					),
					$post_type,
					$name
				);
				?>
				</span>
			</div>
			<div class="action">
				<div class="text-center">
					<label>
						<input type="checkbox" name="backup_data" value="1" checked="checked" />
						<?php printf( __( 'I also want to backup all data as a new %s', 't4p-core' ), $post_type ); ?>
					</label>
				</div>
				<div class="text-center">
					<button class="btn btn-success col-xs-3 center-block" data-action="convert-only">
						<span data-working-text="<?php _e( 'Converting Data...', 't4p-core' ); ?>">
							<?php _e( 'Convert' ); ?>
						</span>
					</button>
					<?php _e( 'or', 't4p-core' ); ?>
					<button class="btn btn-link" data-action="convert-and-publish">
						<span data-working-text="<?php _e( 'Converting Data...', 't4p-core' ); ?>">
							<?php _e( 'Convert and Publish' ); ?>
						</span>
					</button>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	<?php
	else :

	$pagebuilder_content = get_post_meta( $post->ID, '_t4p_page_builder_content', true );

	if ( ! empty( $pagebuilder_content ) ) :
		$builder = new T4P_Pb_Helper_Shortcode();
		echo balanceTags( $builder->do_shortcode_admin( $pagebuilder_content ) );
	endif;
	?>
               
                   
                
		<a href="javascript:void(0);" id="jsn-add-container"
			class="jsn-add-more">
                    
                    
                    
                    <i class="t4p-layout-3-6-3"></i> <?php _e( 'Add Row or Choose Your Layout', 't4p-core' ) ?>
		</a>
		<?php
		// Default layouts
		include T4P_CORE_TPL_PATH . '/default-layouts.php';
		?>
		<input type="hidden" id="t4p-select-media" value="" />
	<?php endif; ?>
	</div>
	<div id="deactivate-msg" class="jsn-section-empty hidden">
		<p class="jsn-bglabel">
			<span class="jsn-icon64 jsn-icon-remove"></span>
			<?php _e( 'Theme4Press PageBuilder is Currently Off.', 't4p-core' ); ?>
		</p>
		<p class="jsn-bglabel">
			<a href="javascript:void(0)" class="btn btn-success"
				id="status-on-link"><?php _e( 'Turn PageBuilder On', 't4p-core' )?> </a>
		</p>

	</div>
</div>

			<?php

			// Page Template
			include 'layout/template.php';

			// Insert Post ID as hidden field
			$post_id = isset ( $_GET['post'] ) ? $_GET['post'] : ( isset ( $post->ID ) ? $post->ID : '' );
			?>
<div id="t4p-pb-css-value">
	<input type="hidden" name="t4p_pb_post_id" value="<?php echo esc_attr( $post_id ); ?>">
</div>

<!--[if IE]>
<style>
	.jsn-quicksearch-field{
		height: 28px;
	}
</style>
<![endif]-->
