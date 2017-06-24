<?php
/**
 * 
 * @version    1.0.0
 * @package    Theme4Press PageBuilder
 * @author     Theme4Press
 * 
 */

/**
 * @todo : Theme4Press PageBuilder Settings page
 */
?>
<div class="wrap">

	<h2>
	<?php esc_html_e( 'Theme4Press Composer Settings', 't4p-core' ); ?>
	</h2>

	<?php
	// Show message when save
	$saved = ( isset ( $_GET['settings-updated'] ) && $_GET['settings-updated'] == 'true' ) ? __( 'Settings saved.', 't4p-core' ) : __( 'Settings saved.', 't4p-core' );

	$msg = $type = '';
	if ( isset ( $_GET['settings-updated'] ) && $_GET['settings-updated'] == 'true' ) {
		$msg  = __( 'Settings saved.', 't4p-core' );
		$type = 'updated';
	} else {
		if ( isset ( $_GET['settings-updated'] ) && $_GET['settings-updated'] != 'true' ) {
			$msg  = __( 'Settings is not saved.', 't4p-core' );
			$type = 'error';
		}
	}

	if ( isset ( $_GET['settings-updated'] ) ) {
		?>
	<div id="setting-error-settings_updated"
		class="<?php echo esc_attr( $type ); ?> settings-error">
		<p>
			<strong><?php echo esc_html( $msg ); ?> </strong>
		</p>
	</div>
	<?php
	}


	$options = array( 't4p_pb_settings_cache', 't4p_pb_settings_boostrap_js', 't4p_pb_settings_boostrap_css' );
	// submit handle
	if ( ! empty ( $_POST ) ) {
		foreach ( $options as $key ) {
			$value = ! empty( $_POST[$key] ) ? 'enable' : 'disable';
			update_option( $key, $value );
		}

		unset( $_POST );
		T4P_Pb_Helper_Functions::alert_msg( array( 'success', __( 'Your settings are saved successfully', 't4p-core' ) ) );
	}
	// get saved options value
	foreach ( $options as $key ) {
		$$key = get_option( $key, 'enable' );
	}

	// show options form
	?>
	<form method="POST" action="options.php">
	<?php
	$page = 't4p-pb-settings';
	settings_fields( $page );
	do_settings_sections( $page );
	submit_button();
	?>
	</form>


</div>

	<?php
	// Load inline script initialization
	$script = '
		new t4p_pb_settings({
			ajaxurl: "' . admin_url( 'admin-ajax.php' ) . '",
			_nonce: "' . wp_create_nonce( T4P_NONCE ) . '",
			button: "t4p-pb-clear-cache",
			button: "t4p-pb-clear-cache",
			loading: "#t4p-pb-clear-cache .layout-loading",
			message: $("#t4p-pb-clear-cache").parent().find(".layout-message"),
		});
        ';

	T4P_Pb_Init_Assets::inline( 'js', $script );

	// Load inlide style
	$loading_img = T4P_CORE_URI . '/assets/theme4press/images/icons-16/icon-16-loading-circle.gif';
	$style = '
		.jsn-bootstrap3 { margin-top: 30px; }
        .jsn-bootstrap3 .checkbox { background:#fff; }
        #t4p-pb-clear-cache, .layout-message { margin-left: 6px; }
        .jsn-icon-loading { background: url("' . $loading_img . '") no-repeat scroll left center; content: " "; display: none; height: 16px; width: 16px; float: right; margin-left: 20px; margin-top: -26px; padding-top: 10px; }
		.t4p-banner-wrapper .t4p-banner { float: left; line-height: 0; margin: 0px 10px 0px 10px; }
		.t4p-banner-l a{
			text-decoration: none;
		}
		.t4p-banner-l img{
			margin-right: 10px;
		}
		.t4p-accordion { border: 1px solid #E5E5E5; margin-top: 20px; }
		.t4p-accordion-title { margin: 0; padding: 8px 20px; cursor: pointer; background: #C3C3C3; }
		.t4p-accordion-content { padding: 0; border-top: 1px solid #E5E5E5; line-height: 0; display: none; }

		/*** Premium ***/
		#t4p-promo-ab h3 {
		    margin: 70px 0 30px;
		    color: #fff;
		    font-size: 32px;
		    font-weight: bold;
		    line-height: 1.1;
		}
		#t4p-promo-ab ul {
		    margin: 0 10px 25px 10px;
		    padding: 0;
		    list-style: none;
		    color: #6c7885;
		}
		#t4p-promo-ab li {
		    display: inline-block;
		    line-height: 31px;
		    margin: 0 5px 10px;
		}
		#t4p-promo-ab li span {
		    background: #6c7886;
		    float: left;
		    border-radius: 50%;
		    -o-border-radius: 50%;
		    -ms-border-radius: 50%;
		    -moz-border-radius: 50%;
		    -webkit-border-radius: 50%;
		    margin: 0 5px 0 0;
		}
		#t4p-promo-ab li img {
		    margin: 8px;
		    float: left !important;
		}
		#t4p-promo-ab .btn-premium {
		    margin: 0 0 60px 0;
		}
		#t4p-promo-ab .btn-premium a {
		    display: inline-block;   
		    margin: 0;
		    background: #418858;
		    color: #fff;
		    padding: 10px 25px;
		    border-radius: 3px;
		    -o-border-radius: 3px;
		    -ms-border-radius: 3px;
		    -moz-border-radius: 3px;
		    -webkit-border-radius: 3px;
		    font-size: 11px;
		    box-shadow: 0 4px 0 0 #2a6d40;
		    -o-box-shadow: 0 4px 0 0 #2a6d40;
		    -ms-box-shadow: 0 4px 0 0 #2a6d40;
		    -moz-box-shadow: 0 4px 0 0 #2a6d40;
		    -webkit-box-shadow: 0 4px 0 0 #2a6d40;
		    text-decoration: none;
		    transition: all 0.3s;
		    -o-transition: all 0.3s;
		    -ms-transition: all 0.3s;
		    -moz-transition: all 0.3s;
		    -webkit-transition: all 0.3s;
		}
		#t4p-promo-ab .btn-premium strong {
		    font-size: 18px;
		}
		#t4p-promo-ab .btn-premium a:hover {
		    background: #2a6d40;
		    text-decoration:none;
		    box-shadow: 0 4px 0 0 #418858;
		    -o-box-shadow: 0 4px 0 0 #418858;
		    -ms-box-shadow: 0 4px 0 0 #418858;
		    -moz-box-shadow: 0 4px 0 0 #418858;
		    -webkit-box-shadow: 0 4px 0 0 #418858;
		}

		@media only screen and (max-width: 1232px), (max-device-width: 1232px) {
			#t4p-promo-ab {
				width:100%
			}
		}

		@media only screen and (max-width: 768px), (max-device-width: 768px) {
		  #t4p-promo-ab ul {
		    width: 270px;
		    margin-right: auto;
		    margin-left: auto;
		  }
		  #t4p-promo-ab ul li {
		    display: block;
		    text-align: left;
		    margin-left: 0;
		    margin-bottom: 20px;
		  }
		}

        ';
T4P_Pb_Init_Assets::inline( 'css', $style );
