<?php

/**
 * Adds Foo_Widget widget.
 */
class Signup_Wiget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
                'signup_wiget', __('Signup Wiget', 'sbpsmsme_widget_domain'), array('description' => __('Put a signup link in sidebar', 'sbpsmsme_widget_domain'),)
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance)
    {
        $user = wp_get_current_user();
        echo '<div class="widget-signup">';
        $title = apply_filters('widget_title', $instance['title']);

        if (is_user_logged_in())
        {
            ?>
            <h2>Welcome, <?php echo $user->display_name; ?> !</h2>
            <?php
        }
        else
        {
            ?>
            <p>&nbsp;</p>
            <h4>New user?</h4>
            <a class="btn btn-success" href="<?php echo get_page_link(160) ?>">Signup</a>
            <?php
        }
        echo $args['after_widget'];
        echo '</div>';
    }

    // Widget Backend 
    public function form($instance)
    {
        if (isset($instance['title']))
        {
            $title = $instance['title'];
        }
        else
        {
            $title = __('New title', 'sbpsmsme_widget_domain');
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

}

// Class wpb_widget ends here
// Register and load the widget
function sbpsmsme_load_widget_signup()
{
    register_widget('Signup_Wiget');
}

add_action('widgets_init', 'sbpsmsme_load_widget_signup');
