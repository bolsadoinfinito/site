<?php
/**
 * Archive Forum Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */
?>

<div id="bbpress-forums">

    <?php
    $evolve_breadcrumbs = evolve_get_option('evl_breadcrumbs', '1');
    $evolve_pagetitlebar_layout = evolve_get_option('evl_pagetitlebar_layout', '0');
    if ($evolve_breadcrumbs == "1" && $evolve_pagetitlebar_layout == '0'):
        if (is_home() || is_front_page()):
        elseif (evolve_titlebar_breadcrumb() == true):
            bbp_breadcrumb();
            bbp_forum_subscription_link();
        endif;
    endif;

    if (bbp_allow_search()) :
        ?>

        <div class="bbp-search-form">

            <?php bbp_get_template_part('form', 'search'); ?>

        </div>

        <?php
    endif;

    do_action('bbp_template_before_forums_index');

    if (bbp_has_forums()) :

        bbp_get_template_part('loop', 'forums');

    else :

        bbp_get_template_part('feedback', 'no-forums');

    endif;

    do_action('bbp_template_after_forums_index');
    ?>

</div>