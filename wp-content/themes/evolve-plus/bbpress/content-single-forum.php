<?php
/**
 * Single Forum Content Part
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

    if (post_password_required()) :

        bbp_get_template_part('form', 'protected');

    else :

        if (bbp_has_forums()) :

            bbp_get_template_part('loop', 'forums');

        endif;

        if (!bbp_is_forum_category() && bbp_has_topics()) :

            bbp_get_template_part('pagination', 'topics');

            bbp_get_template_part('loop', 'topics');

            bbp_get_template_part('pagination', 'topics');

            bbp_get_template_part('form', 'topic');

        elseif (!bbp_is_forum_category()) :

            bbp_get_template_part('feedback', 'no-topics');

            bbp_get_template_part('form', 'topic');

        endif;

    endif;

    do_action('bbp_template_after_single_forum');
    ?>

</div>