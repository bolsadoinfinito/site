<?php 


function t4p_pb_editing_screen() {

	global $t4p_pb_plugin_options;

	//$capability = t4p_pb_get_option( 'lc_min_capability_page', 't4p_pb_plugin_options_access_control' );
	if ( ! $capability ) {
		$capability = 'publish_posts';
	}

	// Base 64 encoded SVG image.
	$icon_svg = '';

	add_menu_page(
		__( 'T4P Page Builder Editing', 't4p-page-builder' ),
		__( 'T4P Page Builder Editing', 't4p-page-builder' ),
		$capability, // Capability.
		't4p_pb_editor', // Menu slug.
		't4p_pb_editing_front_screen_content', // Callable $function.
		$icon_svg, // Icon_url.
		'99' // Int $position.
	);

	//remove_menu_page( 't4p_pb_editor', 't4p_pb_editor' );

}
add_action( 'admin_menu', 't4p_pb_editing_screen' );


/**
 * Output iframe with preview of the page we are editing.
 *
 * On /wp-admin/admin.php?page=t4p_pb_editor page we display
 * iframe used as live preview of the page we are editing using Live T4P Page Builder.
 *
 * @since 1.1
 */
function t4p_pb_editing_front_screen_content() {
    $screen = get_current_screen();

	// Proceed only if current page is T4P Live Page Builder editing page in WP Admin
	// and has access role.
        if ( 'toplevel_page_t4p_pb_editor' !== $screen->id  ) {
		return;
	}
	// Array with URL variables to be used in add_query_arg
	$previewurl_keys = array();
	$preview_output = true;

	// Set id of the page we are editing.
        
	if ( isset( $_GET['page_id'] ) && is_numeric( $_GET['page_id'] ) ) {

		$previewurl_keys['page_id'] = $_GET['page_id'];
	} else {
		// Otherwise signal to not output preview iframe.
		$preview_output = false;
	}

	// Preview id used when working with post templates in LC.
	if ( isset( $_GET['preview_id'] ) ) {

		$previewurl_keys['preview_id'] = intval( $_GET['preview_id'] );
	}

	// Set 't4p' key – indicating that Live Composer editing mode is active.
	$previewurl_keys['t4ppb'] = '';

	// Output iframe with page being edited.
	if ( $preview_output ) {

		do_action( 't4pa_editing_screen_preview_before' );

		$frame_url = set_url_scheme( add_query_arg( $previewurl_keys, get_permalink( $previewurl_keys['page_id'] ) ) );

		echo '<div id="page-builder-preview-area">';
		echo '<iframe id="page-builder-frame" style="height:100%;left:0;position:fixed;width:100%;" src="' . esc_url( $frame_url ) . '"></iframe>';
		echo '</div>';

		do_action( 't4pa_editing_screen_preview_after' );
	} else {

		// Output error if no page_id for editing provided.
		echo '<div id="t4p-preview-error"><p>';
		echo esc_attr__( 'Error: No page id provided.', 'live-composer-page-builder' );
		echo '</p></div>';
	}
}


/**
 * Code to output in the <head> section of the editing page (WP Admin).
 *
 * – Inline styles to cover WP Admin interface with preview iframe
 * – Inline styles to hide any notices in WP Admin interface
 *
 * @since 1.1
 */
function t4p_pb_editing_screen_head() {

	$screen = get_current_screen();

	// Proceed only if current page is Live Composer editing page in WP Admin.
	if ( 'toplevel_page_t4p_pb_editor' !== $screen->id  ) {
		return;
	}
	?>
	<style>
		#wpcontent, #wpbody, #wpbody-content, #page-builder-frame, #page-builder-preview-area {
		   height: 100%;
		   top: 0;
		   left: 0;
		   position: fixed;
		   width: 100%;
		   margin: 0;
		   padding: 0;
		}

		.update-nag, .updated,
		#wpadminbar, #wpfooter, #adminmenuwrap, #adminmenuback, #adminmenumain, #screen-meta  {
			display: none !important;
			opacity: 0 !important;
			visibility: hidden !important;
		}

		#wpbody-content > * {
			display: none!important;
		}

		#wpbody-content #page-builder-preview-area {
			display: block!important;
		}

		#page-builder-preview-area {
		  z-index: 10000;
		  background: #fff;
		}
	</style>
	<?php

	do_action( 't4pa_editing_screen_head' );
}
add_action( 'admin_head', 't4p_pb_editing_screen_head' );

/**
 * Code to output before </body> on the editing page (WP Admin).
 *
 * – Inline script to hide WP Admin interface
 *
 * @since 1.1
 */
function t4p_pb_editing_screen_footer() {
	$screen = get_current_screen();

	if ( 'toplevel_page_t4p_pb_editor' !== $screen->id) {
		return;
	}

	?>
	<script type="text/javascript">
		jQuery('#wpadminbar, #wpfooter, #adminmenuwrap, #adminmenuback, #adminmenumain, #screen-meta, .update-nag, .updated').remove();
		jQuery('#wpbody-content > *').each(function() {
			var current_el = jQuery(this);
			if ( 'page-builder-preview-area' !== current_el[0].getAttribute('id') ) {
				current_el.remove();
			}
		});
	</script>
	<?php
	do_action( 't4pa_editing_screen_footer' );
}

add_action( 'admin_footer', 't4p_pb_editing_screen_footer' );

/**
 * Code to show in preview area head section.
 *
 * @since 1.1
 */
function t4p_pb_preview_area_head() {

	global $t4p_pb_active;

	if ( $t4p_pb_active ) : ?>
	<style>
		#wpadminbar {
			display: none !important;
			opacity: 0 !important;
			visibility: hidden !important;
		}
	</style>
	<?php endif;
}

add_action( 'wp_head', 't4p_pb_preview_area_head' );


/**
 * Change page title for the editing page (WP Admin).
 *
 * @since 1.1
 */
function t4p_pb_editing_screen_title() {
	$screen = get_current_screen();

	if ( 'toplevel_page_t4p_pb_editor' !== $screen->id || ! isset( $_GET['page_id'] ) ) {
		return;
	}

	$title = 'T4p Edit: ' . get_the_title( intval( $_GET['page_id'] ) );
	return $title;
}

add_filter( 'admin_title', 't4p_pb_editing_screen_title' );


?>