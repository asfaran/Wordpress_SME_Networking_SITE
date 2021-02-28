<?php

/**
 * Adds Foo_Widget widget.
 */
class Resource_Wiget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
                'resource_wiget', __('Resource Wiget', 'sbpsmsme_widget_domain'), array('description' => __('Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain'),)
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance)
    {
        echo '<div class="widget-resources">';
        $title = apply_filters('widget_title', $instance['title']);
        $count = filter_var($instance['count'], FILTER_SANITIZE_NUMBER_INT);
        if ($count < 1 || $count > 50)
            $count = 5;
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

        $resources = sbpsmsme_latest_resources($count);
        if (is_object($resources))
        {
            echo '<ul>';            
            $count = $resources->post_count;
            $i = 0;
            while ($resources->have_posts()) :
                $resources->the_post();
                $last_class = $count == ++$i ? 'last' : '';
                echo '<li class="widget-resources-item ' . $last_class . '">';
                if (has_post_thumbnail()) :
                    echo '<a href="' . get_the_permalink() . '">';
                    the_post_thumbnail('resource-xxxsmall', array('class' => 'pull-rigth'));
                    echo '</a>';
                endif;
                echo '<a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a>';
                echo '</li>';
            endwhile;
            echo '</ul>';
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
        if (isset($instance['count']))
            $count = $instance['count'];
        else
            $count = 5;
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count') ?>"><?php _e('Count') ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" />
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['count'] = (!empty($new_instance['count']) ) ? strip_tags($new_instance['count']) : '';
        return $instance;
    }

}

// Class wpb_widget ends here
// Register and load the widget
function sbpsmsme_load_widget()
{
    register_widget('Resource_Wiget');
}

add_action('widgets_init', 'sbpsmsme_load_widget');
