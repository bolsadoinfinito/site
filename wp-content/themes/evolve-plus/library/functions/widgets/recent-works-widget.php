<?php
add_action('widgets_init', 'recent_works_load_widgets');

function recent_works_load_widgets() {
    register_widget('Recent_Works_Widget');
}

class Recent_Works_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'recent_works-widget', __('evolve: Portfolio', 'evolve'), // Name
                array('classname' => 'recent_works', 'description' => __('Recent works from the portfolio.', 'evolve'),) // Args
        );
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $number = $instance['number'];

        echo $before_widget;

        if ($title) {
            echo $before_title . $title . $after_title;
        }
        ?>
        <div class="recent-works-items clearfix">
            <?php
            $args = array(
                'post_type' => 'evolve_portfolio',
                'posts_per_page' => $number,
                'has_password' => false
            );
            $portfolio = new WP_Query($args);
            if ($portfolio->have_posts()):

                while ($portfolio->have_posts()): $portfolio->the_post();
                    if (has_post_thumbnail()):

                        $link_target = "";
                        $url_check = get_post_meta(get_the_ID(), 'evolve_link_icon_url', true);
                        if (!empty($url_check)) {
                            $new_permalink = get_post_meta(get_the_ID(), 'evolve_link_icon_url', true);
                            if (get_post_meta(get_the_ID(), 'evolve_link_icon_target', true) == "yes") {
                                $link_target = ' target="_blank"';
                            }
                        } else {
                            $new_permalink = get_permalink();
                        }
                        ?>
                        <a href="<?php echo $new_permalink; ?>"<?php echo $link_target; ?> title="<?php the_title(); ?>">
                            <?php the_post_thumbnail('recent-works-thumbnail'); ?>
                        </a>
                        <?php
                    endif;
                endwhile;
            endif;
            wp_reset_query();
            ?>
        </div>

        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = $new_instance['number'];

        return $instance;
    }

    function form($instance) {
        $defaults = array('title' => 'Portfolio', 'number' => 6);
        $instance = wp_parse_args((array) $instance, $defaults);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>">Number of items to show:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $instance['number']; ?>" />
        </p>
        <?php
    }

}
