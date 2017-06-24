<header id="header" class="sticky-header 
<?php
$evolve_width_layout = evolve_get_option('evl_width_layout', 'fixed');
if ($evolve_width_layout == "fixed" && !is_page_template('100-width.php')) {
    echo "container row";
}
?>">
    <div class="container">
        <?php
        $evolve_sticky_header_logo = evolve_get_option('evl_sticky_header_logo', 1);
        if ($evolve_sticky_header_logo == "0") {
            
        } else {
            $evolve_sticky_header_logo_img = evolve_get_option('evl_sticky_header_logo_img', '');
            $evolve_sticky_header_logo_img_retina = evolve_get_option('evl_sticky_header_logo_img_retina', '');
            $evolve_sticky_header_logo_img_retina_width = evolve_get_option('evl_sticky_header_logo_img_retina_width', '');
            $evolve_sticky_header_logo_img_retina_height = evolve_get_option('evl_sticky_header_logo_img_retina_height', '');

            $evolve_header_logo = evolve_get_option('evl_header_logo', '');
            $evolve_header_logo_retina = evolve_get_option('evl_header_logo_retina', '');
            $evolve_header_logo_retina_width = evolve_get_option('evl_header_logo_retina_width', '');
            $evolve_header_logo_retina_height = evolve_get_option('evl_header_logo_retina_height', '');
            if (!empty($evolve_sticky_header_logo_img['url']) || !empty($evolve_sticky_header_logo_img_retina)) {
                echo "<div id='sticky-logo' ><a class='logo-url' href=" . home_url() . ">";
                if (!empty($evolve_sticky_header_logo_img['url'])):
                    ?>
                    <img id="logo-image" class="img-responsive normal_logo" src="<?php echo $evolve_sticky_header_logo_img['url'] ?>" alt="<?php bloginfo('name'); ?>" />
                    <?php
                endif;
                if ($evolve_sticky_header_logo_img_retina != "" && $evolve_sticky_header_logo_img_retina_width != "" && $evolve_sticky_header_logo_img_retina_height != ""):
                    $pixels = "";
                    if (is_numeric($evolve_sticky_header_logo_img_retina_width) && is_numeric($evolve_sticky_header_logo_img_retina_height)):
                        $pixels = "px";
                    endif;
                    ?>
                    <img id="logo-image" src="<?php echo $evolve_sticky_header_logo_img_retina ?>" alt="<?php bloginfo('name'); ?>" style="width:<?php echo $evolve_sticky_header_logo_img_retina_width . $pixels ?>;max-height:<?php echo $evolve_sticky_header_logo_img_retina_height . $pixels ?>; height:auto !important;" class="retina_logo" />
                    <?php
                endif;
                echo "</a></div>";
            } elseif (!empty($evolve_header_logo) || !empty($evolve_header_logo_retina)) {
                echo "<div id='sticky-logo' ><a class='logo-url' href=" . home_url() . ">";
                if ($evolve_header_logo != ''):
                    ?>
                    <img id="logo-image" class="img-responsive normal_logo" src="<?php echo $evolve_header_logo ?>" alt="<?php echo bloginfo('name') ?>" />
                    <?php
                endif;
                if ($evolve_header_logo_retina != "" && $evolve_header_logo_retina_width != "" && $evolve_header_logo_retina_height != ""):
                    $pixels = "";
                    if (is_numeric($evolve_header_logo_retina_width) && is_numeric($evolve_header_logo_retina_height)):
                        $pixels = "px";
                    endif;
                    ?>
                    <img id="logo-image" src="<?php echo $evolve_header_logo_retina ?>" alt="<?php bloginfo('name'); ?>" style="width:<?php echo $evolve_header_logo_retina_width . $pixels ?>;max-height:<?php echo $evolve_header_logo_retina_height . $pixels ?>; height:auto !important;" class="retina_logo" />
                    <?php
                endif;
                echo "</a></div>";
            }
        }

        $evolve_blog_title = evolve_get_option('evl_blog_title', '0');
        if ($evolve_blog_title == "0") {
            ?>
            <div id="sticky-logo"><a class='logo-url-text' href="<?php echo home_url(); ?>"><?php bloginfo('name') ?></a></div>
        <?php }
        ?>
        <div class="sticky-menu col-md-10 col-sm-10">
            <?php
            if (has_nav_menu('sticky_navigation')) {
                echo '<nav class="nav nav-holder link-effect">';
                if (evolve_get_option('evl_disable_megamenu', '0') == '0'):
                    wp_nav_menu(array('theme_location' => 'sticky_navigation', 'menu_class' => 'nav-menu t4p-navbar-nav', 'fallback_cb' => 'wp_page_menu', 'walker' => new T4PCoreFrontendWalker()));
                else:
                    wp_nav_menu(array('theme_location' => 'sticky_navigation', 'menu_class' => 'nav-menu', 'fallback_cb' => 'wp_page_menu', 'walker' => new evolve_Walker_Nav_Menu()));
                endif;
            } elseif (has_nav_menu('primary-menu')) {
                echo '<nav class="nav nav-holder link-effect">';
                if (evolve_get_option('evl_disable_megamenu', '0') == '0'):
                    wp_nav_menu(array('theme_location' => 'primary-menu', 'menu_class' => 'nav-menu t4p-navbar-nav', 'fallback_cb' => 'wp_page_menu', 'walker' => new T4PCoreFrontendWalker()));
                else:
                    wp_nav_menu(array('theme_location' => 'primary-menu', 'menu_class' => 'nav-menu', 'fallback_cb' => 'wp_page_menu', 'walker' => new evolve_Walker_Nav_Menu()));
                endif;
            } else {
                ?>
                <nav class="nav nav-holder link-effect">
                    <?php
                    wp_nav_menu(array('theme_location' => 'primary-menu', 'menu_class' => 'nav-menu', 'fallback_cb' => 'wp_page_menu'));
                }
                ?>
            </nav>
        </div>
        <?php
        $evolve_searchbox_sticky_header = evolve_get_option('evl_searchbox_sticky_header', '1');
        if ($evolve_searchbox_sticky_header == "1") {
            ?>
            <!--BEGIN #searchform-->
            <form action="<?php echo home_url(); ?>" method="get" class="stickysearchform stickyubersearch">
                <div id="stickysearch-text-box" class="col-md-1 col-sm-1" >
                    <label class="searchfield" id="stickysearch_label" for="search-stickyfix"><input id="search-stickyfix" type="text" tabindex="1" name="s" class="search" placeholder="<?php _e('Type your search', 'evolve'); ?>" /></label>
                </div>
            </form>
            <div class="clearfix"></div>
            <!--END #searchform-->
        <?php } ?>
    </div>
</header>