<?php

function sbps_check_permission($page_type)
{
    if ($page_type == 'sme-post' && !is_user_logged_in())
    {
        ob_clean();
        header("location:" . wp_login_url($_SERVER['REQUEST_URI']));
    }
}

function sbpsmsme_SearchFilter($query)
{
    if ($query->is_search)
    {
        $query->set('post_type', array('resources', 'post'));
    }
    return $query;
}

add_filter('pre_get_posts', 'sbpsmsme_SearchFilter');

function sbpssme_redirect_user_after_login($user_login, $user) {
    if (!empty($_GET['redirect_to'])) {
        header('location:' . $_GET['redirect_to']);
        exit();
    }
}
add_action('wp_login', 'sbpssme_redirect_user_after_login', 10, 2);

function sbps_msme_init()
{
    // remember add first parameter post type as 'page'
    add_post_type_support('page', 'page-attributes');
}

add_action('init', 'sbps_msme_init');

function sbps_msme_setup()
{
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_image_size('frontpage-thumbnail', 460, 160, true);
    add_image_size(100, 300, true);
    add_theme_support('post-formats', array('aside',));

    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style();
    register_nav_menu('primary', __('Primary Menu', 'sbpsmsme'));
}

add_action('after_setup_theme', 'sbps_msme_setup');

function sbps_msme_adding_scripts()
{
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/plugins/bootstrap/js/bootstrap.min.js', array('jquery'), '20120206', true);
    wp_enqueue_script('hover-dropdown', get_template_directory_uri() . '/assets/plugins/hover-dropdown.js', array('jquery'), '20120206', true);
    wp_enqueue_script('back-to-top', get_template_directory_uri() . '/assets/plugins/back-to-top.js', array('jquery'), '20120206', true);
    wp_enqueue_script('jquery.fancybox.pack', get_template_directory_uri() . '/assets/plugins/fancybox/source/jquery.fancybox.pack.js', array('jquery'), '20120206', true);
    wp_enqueue_script('jquery.themepunch.plugins', get_template_directory_uri() . '/assets/plugins/revolution_slider/rs-plugin/js/jquery.themepunch.plugins.min.js', array('jquery'), '20120206', true);
    //wp_enqueue_script('jquery.themepunch.revolution', get_template_directory_uri() . '/assets/plugins/revolution_slider/rs-plugin/js/jquery.themepunch.revolution.min.js', array('jquery'), '20120206', true);
    wp_enqueue_script('jquery.bxslider', get_template_directory_uri() . '/assets/plugins/bxslider/jquery.bxslider.min.js', array('jquery'), '20120206', true);
    wp_enqueue_script('app-script', get_template_directory_uri() . '/assets/scripts/app.js', array('jquery'), '20120206', true);

    if (is_front_page())
    {
        wp_enqueue_script('index-script', get_template_directory_uri() . '/assets/scripts/index.js', array('jquery'), '20120206', true);
    }
}

add_action('wp_enqueue_scripts', 'sbps_msme_adding_scripts');

add_theme_support('post-thumbnails');

add_filter('wp_nav_menu_items', 'add_login_logout_link', 10, 2);

function add_login_logout_link($items, $args)
{
    if ($args->theme_location != 'primary')
        return $items;

    if (is_user_logged_in())
    {
        $loginoutlink = "<a href='" . wp_logout_url(site_url()) . "'><i class='fa fa-lock '></i> Logout</a>";
    }
    else
    {
        $args = array(
            'echo' => false,
            'redirect' => site_url($_SERVER['REQUEST_URI']),
            'form_id' => 'loginform',
            'label_username' => __('Username'),
            'label_password' => __('Password'),
            'label_remember' => __('Remember Me'),
            'label_log_in' => __('Log In'),
            'id_username' => 'user_login',
            'id_password' => 'user_pass',
            'id_remember' => 'rememberme',
            'id_submit' => 'wp-submit',
            'remember' => true,
            'value_username' => NULL,
            'value_remember' => false
        );
        $loginoutlink = "<a href='#' class='search-btn'><i class='fa fa-lock '></i> Login</a>";
        /*$loginoutlink .= '<div class="search-box">
                         <div class="pull-right"><a id="btn-close" href="#"><i class="fa fa-times"></i> </a></div>
                         <h3>Login Form</h3>                         
                         <p>
                         Please fill up the form to login to control panel.
                         </p>' . wp_login_form($args) . '</div>';*/
    }
    $items = '<li class="nav-login-form">' 
            . $loginoutlink . '</li>' . $items;
    return $items;
}

function sbpsmsme_categorized_blog()
{
    if (false === ( $all_the_cool_cats = get_transient('all_the_cool_cats') ))
    {
        // Create an array of all the categories that are attached to posts
        $all_the_cool_cats = get_categories(array(
            'hide_empty' => 1,
        ));

        // Count the number of categories that are attached to the posts
        $all_the_cool_cats = count($all_the_cool_cats);

        set_transient('all_the_cool_cats', $all_the_cool_cats);
    }

    if ('1' != $all_the_cool_cats)
    {
        // This blog has more than 1 category so adamos_categorized_blog should return true
        return true;
    }
    else
    {
        // This blog has only 1 category so adamos_categorized_blog should return false
        return false;
    }
}

if (!function_exists('sbpsmsme_content_nav')):

    /**
     * Display navigation to next/previous pages when applicable
     *
     * @since adamos 1.0
     */
    function sbpsmsme_content_nav($nav_id)
    {
        global $wp_query, $post;

        // Don't print empty markup on single pages if there's nowhere to navigate.
        if (is_single())
        {
            $previous = ( is_attachment() ) ? get_post($post->post_parent) : get_adjacent_post(false, '', true);
            $next = get_adjacent_post(false, '', false);

            if (!$next && !$previous)
                return;
        }

        // Don't print empty markup in archives if there's only one page.
        if ($wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ))
            return;

        $nav_class = 'site-navigation paging-navigation';
        if (is_single())
            $nav_class = 'site-navigation post-navigation';
        ?>
        <nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
            <h1 class="assistive-text"><?php _e('Post navigation', 'adamos'); ?></h1>

            <?php if (is_single()) : // navigation links for single posts    ?>

                <?php previous_post_link('<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x('&larr;', 'Previous post link', 'adamos') . '</span> %title'); ?>
                <?php next_post_link('<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x('&rarr;', 'Next post link', 'adamos') . '</span>'); ?>

            <?php elseif ($wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() )) : // navigation links for home, archive, and search pages   ?>

                <?php if (get_next_posts_link()) : ?>
                    <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'adamos')); ?></div>
                <?php endif; ?>

                <?php if (get_previous_posts_link()) : ?>
                    <div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'adamos')); ?></div>
                <?php endif; ?>

            <?php endif; ?>

        </nav><!-- #<?php echo $nav_id; ?> -->
        <?php
    }

endif; // adamos_content_nav

function sbpsmsme_get_content_testimonial()
{
    ?>
    <div class="col-md-12 col-sm-12">
        <span style="text-align:center"><h2>WHAT BUSINESS IS SAYING ABOUT MYANMAR<span style="color: #ff8503;">SME</span>LINK</h2></span>
    </div>
    <div class="row front-team">
        <ul class="list-unstyled">
            <?php
            global $wp_query;
            wp_reset_query();
            query_posts('category_name=testimonial&order=asc');
            if (have_posts()) : while (have_posts()) : the_post();
                    ?>

                    <li class="col-md-3 space-mobile">
                        <div class="thumbnail">
                            <?php $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'myResizedThumbnail'); ?>
                            <img src="<?php echo $thumbnail[0] ?>" alt="">

                            <?php $meta = get_post_meta(get_the_ID(), 'job_title', true) ?>
                            <h3>
                                <a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a>
                                <small><?php echo $meta; ?></small>
                            </h3>
                        </div>
                    </li>

                <?php endwhile; ?>

                <?php
            endif;
            wp_reset_query();
            ?>
        </ul></div>
    <?php
}

if (function_exists('register_sidebar'))
{
    register_sidebar(array(
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
            )
    );
}

if (function_exists('register_sidebar'))
{
    register_sidebar(array(
        'name' => 'Footer Column 1',
        'id' => 'footer-column-one',
        'before_widget' => '<div class="footer-columns footer-column-one %1$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'Footer Column 2',
        'id' => 'footer-column-two',
        'before_widget' => '<div class="footer-columns footer-column-two %1$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'Footer Column 3',
        'id' => 'footer-column-three',
        'before_widget' => '<div class="footer-columns footer-column-three %1$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'Resource Filter | Date',
        'id' => 'resource-filter-date',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));
}

if (class_exists('kdMultipleFeaturedImages'))
{

    $args = array(
        'id' => 'featured-image-2',
        'post_type' => 'post', // Set this to post or page
        'labels' => array(
            'name' => 'Featured image 2',
            'set' => 'Set featured image 2',
            'remove' => 'Remove featured image 2',
            'use' => 'Use as featured image 2',
        )
    );

    new kdMultipleFeaturedImages($args);
}

function sbpsmsme_get_clients_carsoul()
{
    global $wp_query;
    wp_reset_query();
    ?>
    <div class="row margin-bottom-40 our-clients">
        <div class="col-md-3">
            <h2><a href="#">Our Clients</a></h2>
            <p>Lorem dipsum folor margade sitede lametep eiusmod psumquis dolore.</p>
        </div>
        <div class="col-md-9">
            <ul class="bxslider1 clients-list">        
                <?php query_posts('category_name=clients&order=asc'); ?>
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : ?>
                        <?php the_post(); ?>
                        <?php $img_1_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                        <?php
                        if (class_exists('kdMultipleFeaturedImages'))
                        {
                            //kd_mfi_the_featured_image('featured-image-2', 'post');
                            $img_2_url = kd_mfi_get_featured_image_url('featured-image-2', 'post', 'full');
                        }
                        ?>                        
                        <?php if (empty($img_2_url)) $img_2_url = $img_1_url; ?>
                        <li>
                            <a href="<?php the_permalink() ?>">
                                <img src="<?php echo $img_2_url; ?>" alt="" />
                                <img src="<?php echo $img_1_url[0]; ?>" class="color-img" alt="" />
                            </a>
                        </li>
                    <?php endwhile; ?>
                <?php endif; ?>                
            </ul>
        </div>
    </div>
    <?php
    wp_reset_query();
}

add_filter('posts_where', 'sbpsmsme_posts_where', 10, 2);

function sbpsmsme_posts_where($where, &$wp_query)
{
    global $wpdb;
    if ($search_title = $wp_query->get('search_title'))
    {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'' . esc_sql(like_escape($search_title)) . '%\'';
    }
    return $where;
}
