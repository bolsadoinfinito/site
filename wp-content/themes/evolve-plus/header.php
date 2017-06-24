<?php
/*
 *
 * Template: Header.php
 *
 */
?>
<!DOCTYPE html>
<!--BEGIN html-->
<html <?php language_attributes(); ?>>
    <!--BEGIN head-->
    <head>

        <?php
        $evolve_page_ID = get_queried_object_id();
        $evolve_slider_position = evolve_get_option('evl_slider_position', 'below');

        $evolve_favicon = evolve_get_option('evl_favicon');
        $evolve_iphone_icon = evolve_get_option('evl_iphone_icon');
        $evolve_iphone_icon_retina = evolve_get_option('evl_iphone_icon_retina');
        $evolve_ipad_icon = evolve_get_option('evl_ipad_icon');
        $evolve_ipad_icon_retina = evolve_get_option('evl_ipad_icon_retina');

        if ($evolve_favicon != ''):
            ?>
            <!-- Favicon -->
            <!-- Firefox, Chrome, Safari, IE 11+ and Opera. -->
            <link rel="shortcut icon" href="<?php echo $evolve_favicon ?>" type="image/x-icon" />
            <?php
        endif;

        if ($evolve_iphone_icon != ''):
            ?>
            <!-- For iPhone -->
            <link rel="apple-touch-icon-precomposed" href="<?php echo $evolve_iphone_icon ?>">
            <?php
        endif;

        if ($evolve_iphone_icon_retina != ''):
            ?>
            <!-- For iPhone 4 Retina display -->
            <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $evolve_iphone_icon_retina ?>">
            <?php
        endif;

        if ($evolve_ipad_icon != ''):
            ?>
            <!-- For iPad -->
            <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $evolve_ipad_icon ?>">
            <?php
        endif;

        if ($evolve_ipad_icon_retina != ''):
            ?>
            <!-- For iPad Retina display -->
            <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $evolve_ipad_icon_retina ?>">
        <?php endif; ?>

        <!-- Meta Tags -->
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <?php wp_head(); ?>

        <!--[if lt IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/ie.css">
        <![endif]-->

    </head><!--END head-->

    <?php $evolve_header_type = evolve_get_option('evl_header_type', 'none'); ?>

    <!--BEGIN body-->
    <body <?php body_class(); ?>>
        <?php
        $evolve_custom_background = evolve_get_option('evl_custom_background', '1');
        if ($evolve_custom_background == "1") {
            ?>
            <div id="wrapper">
                <?php
            }
            ?>

            <div class="menu-back">
                <?php
                $evolve_current_post_slider_position = get_post_meta($evolve_page_ID, 'evolve_slider_position', true);
                $evolve_current_post_slider_position = empty($evolve_current_post_slider_position) ? 'default' : $evolve_current_post_slider_position;
                if ($evolve_current_post_slider_position == 'above' || ($evolve_current_post_slider_position == 'default' && $evolve_slider_position == 'above') || (is_home() && $evolve_slider_position == 'above')):
                    get_template_part('allslider');
                endif;
                ?>
                <div class="clearfix"></div>
            </div><!--/.menu-back-->

            <div id="top"></div>
            <?php
            switch ($evolve_header_type) {
                case "none":
                    get_template_part('assets/templates/header_v1');
                    break;
                case "h1":
                    get_template_part('assets/templates/header_v2');
                    break;
                case "h2":
                    get_template_part('assets/templates/header_v3');
                    break;
                case "h3":
                    get_template_part('assets/templates/header_v4');
                    break;
                case "h4":
                    get_template_part('assets/templates/header_v5');
                    break;
                case "h5":
                    get_template_part('assets/templates/header_v6');
                    break;
            }
            ?> 
            <div class="menu-container">
                <?php
                $evolve_menu_background = evolve_get_option('evl_disable_menu_back', '1');
                $evolve_width_layout = evolve_get_option('evl_width_layout', 'fixed');
                if ($evolve_width_layout == "fluid" && $evolve_menu_background == "1" || is_page_template('100-width.php')) {
                    ?>
                    <div class="fluid-width">
                    <?php }
                    ?>
                    <div class="menu-back">
                        <?php
                        $evolve_current_post_slider_position = get_post_meta($evolve_page_ID, 'evolve_slider_position', true);
                        $evolve_current_post_slider_position = empty($evolve_current_post_slider_position) ? 'default' : $evolve_current_post_slider_position;
                        if ($evolve_current_post_slider_position == 'below' || ($evolve_current_post_slider_position == 'default' && $evolve_slider_position == 'below') || (is_home() && $evolve_slider_position == 'below')):
                            get_template_part('allslider');
                        endif;
                        ?>
                        <div style="clear:both;"></div> 

                        <?php
                        if ($evolve_width_layout == "fluid" || is_page_template('100-width.php')) {
                            ?>
                            <div class="container">
                                <?php
                            }

                            $evolve_header_widgets_placement = evolve_get_option('evl_header_widgets_placement', 'home');
                            $evolve_widget_this_page = get_post_meta($evolve_page_ID, 'evolve_widget_page', true);
                            if (((is_home() || is_front_page()) && $evolve_header_widgets_placement == "home") || (is_single() && $evolve_header_widgets_placement == "single") || (is_page() && $evolve_header_widgets_placement == "page") || ($evolve_header_widgets_placement == "all") || ($evolve_widget_this_page == "yes" && $evolve_header_widgets_placement == "custom")) {
                                $evolve_widgets_header = evolve_get_option('evl_widgets_header', 'disable');
                                // if Header widgets exist
                                if (($evolve_widgets_header == "") || ($evolve_widgets_header == "disable")) {
                                    
                                } else {
                                    $evolve_header_css = '';
                                    if ($evolve_widgets_header == "one") {
                                        $evolve_header_css = 'widget-one-column col-sm-12';
                                    }
                                    if ($evolve_widgets_header == "two") {
                                        $evolve_header_css = 'col-sm-6 col-md-6';
                                    }
                                    if ($evolve_widgets_header == "three") {
                                        $evolve_header_css = 'col-sm-6 col-md-4';
                                    }
                                    if ($evolve_widgets_header == "four") {
                                        $evolve_header_css = 'col-sm-6 col-md-3';
                                    }
                                    ?>
                                    <div class="container">
                                        <div class="header-widgets">
                                            <div class="widgets-back-inside">
                                                <div class="<?php echo $evolve_header_css; ?>">
                                                    <?php
                                                    if (!dynamic_sidebar('header-1')) :
                                                    endif;
                                                    ?>
                                                </div>
                                                <div class="<?php echo $evolve_header_css; ?>">
                                                    <?php
                                                    if (!dynamic_sidebar('header-2')) :
                                                    endif;
                                                    ?>
                                                </div>
                                                <div class="<?php echo $evolve_header_css; ?>">
                                                    <?php
                                                    if (!dynamic_sidebar('header-3')) :
                                                    endif;
                                                    ?>
                                                </div>
                                                <div class="<?php echo $evolve_header_css; ?>">
                                                    <?php
                                                    if (!dynamic_sidebar('header-4')) :
                                                    endif;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.container -->
                                    <?php
                                }
                            } else {
                                
                            }
                            ?>
                            <?php
                            if ($evolve_width_layout == "fluid" || is_page_template('100-width.php')) {
                                ?>
                            </div><!-- /.container -->
                        <?php } ?>                    
                    </div><!--/.menu-back-->
                    <?php
                    if ($evolve_width_layout == "fluid" || is_page_template('100-width.php')) {
                        ?>
                    </div><!-- /.fluid-width -->
                <?php } 

                $evolve_pagetitlebar_layout = evolve_get_option('evl_pagetitlebar_layout', '0');
                if ((is_home() || is_front_page())) {
                    if (!( is_home() && !is_front_page() )) {
                        // do nothing
                    } elseif (is_home() && $evolve_pagetitlebar_layout == '1') {
                        global $wp_query, $post;
                        $post_id = '';
                        if ($wp_query->is_posts_page) {
                            $post_id = get_option('page_for_posts');
                        } elseif (is_buddypress()) {
                            $post_id = evolve_bp_get_id();
                        } else {
                            $post_id = isset($post->ID) ? $post->ID : '';
                        }

                        $evolve_display_pagetitlebar = evolve_get_option('evl_display_pagetitlebar', 'titlebar_breadcrumb');
                        $evolve_display_page_title = get_post_meta($post_id, 'evolve_page_title', true);
                        if ($evolve_display_page_title == 'none' || ($evolve_display_page_title == 'default' && $evolve_display_pagetitlebar == 'none')) {
                            // do nothing
                        } else {
                            evolve_page_title_bar();
                        }
                    }
                } elseif ($evolve_pagetitlebar_layout == '1') {
                    global $wp_query, $post;
                    $post_id = '';
                    if ($wp_query->is_posts_page) {
                        $post_id = get_option('page_for_posts');
                    } elseif (is_buddypress()) {
                        $post_id = evolve_bp_get_id();
                    } else {
                        $post_id = isset($post->ID) ? $post->ID : '';
                    }

                    $evolve_display_pagetitlebar = evolve_get_option('evl_display_pagetitlebar', 'titlebar_breadcrumb');
                    $evolve_display_page_title = get_post_meta($post_id, 'evolve_page_title', true);
                    if ($evolve_display_page_title == 'none' || ($evolve_display_page_title == 'default' && $evolve_display_pagetitlebar == 'none')) {
                        // do nothing
                    } else {
                        evolve_page_title_bar();
                    }
                }
                ?>
                <!--BEGIN .content-->
                <div class="content <?php semantic_body(); ?>">
                    <?php if (is_page_template('contact.php')): ?>
                        <div class="gmap" id="gmap"></div>
                    <?php endif; ?>
                    <!--BEGIN .container-->
                    <div class="container container-center row">
                        <!--BEGIN #content-->
                        <div id="content">
                            <?php
                            if (is_front_page()) {
                                evolve_content_boxes();
                            }