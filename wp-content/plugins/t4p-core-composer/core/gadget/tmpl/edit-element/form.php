<?php
/**
 * @author         Theme4Press
 * @package        Theme4Press Page Builder
 * @version        1.0.0
 */

// Make sure response header is HTML document
@header( 'Content-Type: ' . get_option( 'html_type' ) . '; charset=' . get_option( 'blog_charset' ) );

// Check if requesting form only
$form_only = ( isset( $_GET['form_only'] ) && absint( $_GET['form_only'] ) ) ? TRUE : FALSE ;

// Print HTML structure if not requesting form only
if ( ! $form_only ) :
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0" />

<?php
    global $smof_data, $theme_prefix;
        if ( $theme_prefix == 'evolve_' ) {
                $evolve_google_map_api = evolve_get_option('evl_google_map_api', '');
        } else {
                $evolve_google_map_api = $smof_data['google_map_api'];
        }
?>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=<?php echo $evolve_google_map_api; ?>&language=en"></script>

<?php
endif;

// Do necessary actions for loading header assets
if ( $form_only ) {
	ob_start();
}

if ( ! $form_only ) {
	do_action( 'pb_admin_enqueue_scripts' );
}

if ( $theme_prefix == 'evolve_' ) {
        require_once( get_template_directory() . '/custom-css.php' );
        echo '<style>';
        echo 'body { background-color: #fff !important; }';
        echo $evolve_css_data;
        echo '</style>';
} 

do_action( 'admin_print_styles'  );
do_action( 'admin_print_scripts' );

if ( $theme_prefix == 'alora_' ) {
        echo '<style>';
        require_once( get_template_directory() . '/framework/dynamic_css.php' );;
        echo '</style>';
}

if ( ! $form_only ) {
	do_action( 'pb_admin_head' );
}

if ( $form_only ) {
	ob_end_clean();

	// Do custom actions for loading assets
	do_action( 'pb_admin_enqueue_scripts' );
	do_action( 'pb_admin_print_styles'    );
	do_action( 'pb_admin_print_scripts'   );
	do_action( 'pb_admin_head'            );
}

// Print HTML structure if not requesting form only
if ( ! $form_only ) :
?>
</head>
<body id="wrapper" class="jsn-master contentpane">

<?php if ( $theme_prefix == 'alora_' ) { ?>
    <div id="content" style="width: 100%; margin-top: 50px;">
        <div class="post-content preview-content">
<?php } else { ?>
    <div id="content">
        <div class="entry-content preview-content">
<?php } ?>
        
<?php
endif;

// Print HTML code for element settings
echo '' . $data;

// Do necessary actions for loading footer assets
do_action( 'pb_admin_footer'            );
do_action( 'admin_print_footer_scripts' );

// Register inline script if not previewing
if ( ! isset( $_GET['t4p_shortcode_preview'] ) || ! $_GET['t4p_shortcode_preview'] ) {
	$script = '
		if ($.HandleSetting && $.HandleSetting.init) $.HandleSetting.init();
        ';

	T4P_Pb_Init_Assets::inline( 'js', $script, true );
}

// Print HTML structure if not requesting form only
if ( ! $form_only ) :
?>
        </div>
    </div>
</body>

    <?php
    if ( $theme_prefix == 'evolve_' ) {
        if (evolve_get_option('evl_animatecss', '') == "1") {
    ?>

        <script type="text/javascript">
            //Animated Buttons
            var $animated = jQuery.noConflict();
                    $animated('.button').hover(
                    function() {
                    $animated(this).addClass('animate pulse')
                    },
                    function() {
                    $animated(this).removeClass('animate pulse')
                    }
            )
        </script>

    <?php 
        }
    }
    ?>

        <script type="text/javascript">
                //flexslider
                jQuery(document).ready(function () {
                        jQuery('.flexslider').flexslider(
                                {
                                        slideshow: true,
                                        slideshowSpeed: 7000,
                                        video: true,
                                        pauseOnHover: false,
                                        useCSS: false,
                                }
                        ); 
                });
        </script>

</html>
<?php
endif;

// Exit immediately to prevent base gadget class from sending JSON data back
exit;
