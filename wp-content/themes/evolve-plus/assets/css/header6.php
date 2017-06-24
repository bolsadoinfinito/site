<?php 
global $evl_options;
$options = $evl_options;

/* WooCommerce Menu */

$evolve_css_data = '
.header .woocommerce-menu {
    margin-right: 0;
    float: none;
}

.title-container #logo a {
    padding: 0px;
}

div#search-text-box {
    margin: 0px;
}

.searchform {
    float: right;
    clear: none;
}

#search-text-box #search_label_top .srch-btn {
    width: 182px;
}

#search-text-box #search_label_top .srch-btn::before {
    color: #273039;
    content: "\f0d9";
    cursor: pointer;
    font-family: icomoon;
    font-size: 18px !important;
    font-weight: normal;
    position: absolute;
    right: 47px !important;
    text-align: center;
    top: -5px !important;
    width: 3px;
}

#search-text-box #search_label_top .srch-btn::after {
    background: #273039 none repeat scroll 0 0;
    border-radius: 3px;
    color: '. $evolve_top_menu_hover_font_color .';
    content: "\e91e";
    cursor: pointer;
    font-family: icomoon;
    font-size: 18px !important;
    font-weight: normal;
    line-height: 35px;
    position: absolute;
    right: 7px !important;
    text-align: center;
    top: -10px !important;
    width: 38px;
}

#search-text-top {
    background: #fff none repeat scroll 0 0 !important;
    border: 1px solid #273039 !important;
    border-radius: 4px !important;
    color: #757575 !important;
    float: right !important;
    font-family: Roboto !important;
    font-size: 14px;
    font-weight: 500;
    height: 35px;
    padding: 0 0 0 10px !important;
    position: relative;
    text-indent: 1px !important;
    transition: all 0.5s ease 0s;
    width: 170px !important;
}

.woocommerce-menu-holder {
    float: left;
    margin-top: 7px;
}

.top-menu-social {
    margin: 10px 0 0px;
}

.header .woocommerce-menu li {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    margin-right: 10px;
}

.header .woocommerce-menu .cart-contents {
    right: auto;
}

.woocommerce-menu .my-account .fa-user {
    height: 17px;
}
@media (max-width: 1200px) {
    .header .woocommerce-menu li {
        margin-right: 0;
        margin-bottom: 10px;
    }
}
@media (min-width: 768px) {
    .header .container-header{
        display: flex;
        align-items: center;
        display: -webkit-flex;
        -webkit-align-items: center;
    }
}
@media (max-width: 768px) {
    #search-text-box {
        float: none;
        margin-bottom: 10px;
    }
    .title-container #logo a {
        padding: 0px;
    }
    .sc_menu {
        float: none;
        margin-bottom: 10px;
        text-align: center;
    }
    .woocommerce-menu-holder {
        float: none;
        margin: 0 0 10px 0;
    }
    .searchform {
        float: none;
        margin: 10px 0 0;
    }
    .title-container{
        margin-right: auto;
        margin-left: auto;
        display: block;
    }
    .sc_menu li{
        float: none;
    }
    #wrapper .top-menu .dd-container{
        text-align: center;
    }

    #wrapper .menu-container .dd-container .dd-selected-text {
        margin: 8px 0;
    }
    #wrapper .woocommerce-menu .dd-container .dd-options{
        margin-top: 8px;
    }
}

ul.nav-menu > li.current-menu-item, 
ul.nav-menu > li.current-menu-ancestor, 
ul.nav-menu li.current-menu-ancestor li.current-menu-parent > a, 
ul.nav-menu li > li.current-menu-ancestor a, 
ul.nav-menu li.current-menu-ancestor li.current-menu-item > a{
    background: '.$evolve_top_menu_hover_color.' none repeat scroll 0 0;
}

@media only screen and (min-width: 768px) {
    ul.nav-menu li.current-menu-item,
    ul.nav-menu li.current-menu-ancestor,
    ul.nav-menu li:hover {
        background: '.$evolve_top_menu_hover_color.' none repeat scroll 0 0;
    }
}
';

 if ($options['evl_menu_font']['color'] !='') {
    $color = $options['evl_menu_font']['color'];
$evolve_css_data .= '
.woocommerce-menu .cart>a:hover,
.woocommerce-menu .my-account-link:hover {
    border: 1px solid '. $evolve_top_menu_hover_font_color .' !important;
    color: '. $evolve_top_menu_hover_font_color .' !important;
}
';
    }

if ($options['evl_tagline_font']['color'] !='') {
    $color = $options['evl_tagline_font']['color'];
$evolve_css_data .= '
.woocommerce-menu .cart > a,
.woocommerce-menu .my-account > a {
    border: 1px solid '. $color .';
    border-radius: 3px;
    color: '. $color .' !important;
    font-weight: 500 !important;
    margin-bottom: 2px;
    padding: 7px 15px !important;
}
';
    }
    
/* retina support style */
$evolve_header_logo_retina = evolve_get_option('evl_header_logo_retina', '');
if($evolve_header_logo_retina != ""):
$evolve_css_data .= '
@media only screen and (min-resolution: 120dpi) and (min-width: 769px) {
    .header-logo-container .retina_logo,
    .sticky-header .retina_logo {
        display: block;
    }
}
';

endif;

/* Add Mega Menu Custom CSS */

if(evolve_get_option('evl_disable_megamenu', '0') == '0') {
$evolve_css_data .= '
.link-effect .sub-menu a {
    white-space: normal;
}

.t4p-dropdown-menu ul,
.top-menu ul.sub-menu {
    left: 0;
}

@media only screen and (max-width: 1219px) {
    body #header.sticky-header {
        margin: 0px;
        left: 0px;
    }
}
';
}